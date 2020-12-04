<?php


namespace App\Api\V1\Services;


use App\Advert;
use Illuminate\Support\Facades\DB;

class NewAdvertSMSSenderService
{

    protected $sms;
    public function __construct(SMSSenderService $senderService)
    {
        $this->sms = $senderService;
    }

    public function send(){
        $adverts = Advert::where(['status'=>'on_advert','media_path'=>'not_assigned'])->get();
        $drivers = DB::table('role_user')->where('role_id','=','2')
            ->join('users',function ($join){
                $join->on('users.id','role_user.user_id');
            })->select('users.id','users.first_name','users.phone')->get();
        if (count($adverts)>0){
            foreach ($drivers as $driver){
                $message = 'Hello, '.$driver->first_name.'\nHow was your day?\nYou have 
                 '.count($adverts).' new adverts for you. Start downloading now and get more income.\nThank you \nGulo ads Group';
                $this->sms->send($driver->phone,$message);
            }
        }
    }
}
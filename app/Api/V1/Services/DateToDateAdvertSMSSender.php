<?php


namespace App\Api\V1\Services;


use App\Advert;
use App\Company;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DateToDateAdvertSMSSender
{

    public function send(){
        $company = DB::table('companies')->join('adverts',function ($join){
            $join->on('adverts.company_id','=','companies.id');
        })->where('adverts.created_at','!=','null')->get();

    }
}
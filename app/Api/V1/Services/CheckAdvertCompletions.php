<?php


namespace App\Api\V1\Services;


use App\Advert;
use App\CarAdvert;

class CheckAdvertCompletions
{

    public function check(){
        $adverts = Advert::all();

        foreach ($adverts as $ads){
            $advert = Advert::find($ads['id']);
            if ($advert->required_views_number=$this->findViews($advert->id)){
                $advert->status = 'Completed';
                $advert->save();
            }
        }
    }

    public function findViews($advertId){
        $advertViews = CarAdvert::where(['advert_id'=>$advertId,'status'=>'Payed'])->get();

        return count($advertViews);
    }

}
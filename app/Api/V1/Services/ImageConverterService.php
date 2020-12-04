<?php


namespace App\Api\V1\Services;


use App\CarAdvert;
use Carbon\Carbon;

class ImageConverterService
{

    public function startConverting(){
        $carAdvert = CarAdvert::all();
        foreach ($carAdvert as $advert){
            $advertView = CarAdvert::find($advert->id);
            if (strlen($advert->picture)>100) {
                $advertView->picture = $this->changeBase64Image($advertView->picture, $advert->id);
                $advertView->save();
            }
        }
    }

    public function changeBase64Image($base64Image,$id){
        $imageName = $id.Carbon::now()->format('dmyhms').'.jpg';
        $path = public_path().'/images/'.$imageName;
        $status = file_put_contents($path,base64_decode($base64Image));
        if ($status){
            return env('HOST_NAME')."/images/".$imageName;
        }
    }
}
<?php


namespace App\Api\V1\Services;
use App\Fault;
use App\RegionWoredZoneCity;
class AccidentFinderService {

    
    public function checkAccidentsBySpecificName($name){
        $similarityPercentage = 0.0;
        $accidents = Fault::where('status',false)->with('faultType')
        ->with('region')->with('subcity')->with('woreda')->with('group')->get();
        $accidentsArray = array();
        foreach($accidents as $accident){
            similar_text($accident->specific_name,$name,$similarityPercentage);
            if($similarityPercentage>50){
               array_push($accidentsArray,$accident);
            }
        }
        return $accidentsArray;
    }

    public function checkAccidentsByWoreda($woredaCity){
        $woreda = RegionWoredZoneCity::where('name',$woredaCity)->get();
        $accidents = Fault::where(['status'=>false,'woreda_city_id'=>$woreda[0]->id])->get();
        return $accidents;
    }
}
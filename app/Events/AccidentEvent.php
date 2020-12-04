<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Support\Facades\DB;
use App\SpecificName;
use App\Fault;
use App\DistrictControllingArea;
use App\RegionWoredZoneCity;
class AccidentEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $accident;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Fault $accident)
    {
        //
        $this->accident = $accident;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return ['accident-on'];
    }


    public function broadcastAs()
    {
      return 'all-accidents';
    }

    public function broadcastWith(){
        return [
            'id'=>$this->accident->id,
            'sender_phone'=>$this->accident->sender_phone,
            'specific_name'=>$this->accident->specific_name,
            'fault_type_id'=>$this->accident->fault_type_id,
            'fault_type'=>$this->accident->faultType,
            'region'=>$this->accident->region,
            'subcity'=>$this->accident->subcity,
            'woreda'=>$this->accident->woreda,
            'group'=>$this->accident->group,
            'districts'=>$this->getDistrict($this->accident->region_id,$this->accident->sub_city_zone_id,$this->accident->specific_name,$this->accident->woreda_city_id)
        ];
    }

    public function getDistrict($regionId,$subcityZoneId,$specificName,$woredaCityId){
        $districtBySpecificName =$this->checkBySpecificName($regionId,$subcityZoneId,$specificName);
        if($districtBySpecificName!=null){
            return $districtBySpecificName;
        }else{
            return $this->checkByWoreda($regionId,$subcityZoneId,$woredaCityId);
        }
    }

    public function checkBySpecificName($regionId,$subcityZoneId,$accidentHappenedSpecificname){
        $namePercentage = 0.0;
        $areas = DistrictControllingArea::where(['region_id'=>$regionId,'sub_city_zone_id'=>$subcityZoneId])->get();
        foreach($areas as $area){
            $specificName= json_decode($area->specific_name);
            foreach($specificName as $names){
               similar_text($names,$accidentHappenedSpecificname,$namePercentage);
               if($names==$accidentHappenedSpecificname){
                   return $area;
               }else if($namePercentage>=75){
                   return $area;
               } 
            }
        }
    }

    public function checkByWoreda($regionId,$subcityZoneId,$woredaCityId){
        $woreda = RegionWoredZoneCity::where('id',$woredaCityId)->get();
        $areas = DistrictControllingArea::where(['region_id'=>$regionId,'sub_city_zone_id'=>$subcityZoneId])->get();
        $namePercentage =0.0;
        foreach($areas as $area){
            $woredas= json_decode($area->woreda);
            foreach($woredas as $name){
               similar_text($name,$woreda[0]->name,$namePercentage);
               if($namePercentage>=75){
                   return $area;
               } 
            }
        }
}
}

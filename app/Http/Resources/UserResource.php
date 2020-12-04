<?php

namespace App\Http\Resources;

use App\Advert;
use App\Car;
use App\CarAdvert;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;
use App\Gender;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'type' => ['User data'],
            'attribute' => [
                'id' => $this->id,
                'name' => $this->name,
                'user_name'=>$this->user_name,
                'profile_pic_path'=>$this->profile_pic_path,
                'email' => $this->email,
                'phone' => $this->phone,
                'age'=>Carbon::parse($this->birth_date)->age
            ],
            'relations' => [
                'gender' => $this->gender,
                'looking_for'=>$this->interest,
                'utilities'=>$this->utility,
                'medias'=>$this->media,
                'passion'=>$this->passion
            ],

        ];
    }

}

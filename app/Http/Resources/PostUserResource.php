<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class PostUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'user_name'=>$this->user_name,
            'profile_pic_path'=>$this->profile_pic_path,
            'email' => $this->email,
            'phone' => $this->phone,
            'age'=>Carbon::parse($this->birth_date)->age,
            'utility'=>$this->utility,
            'passions'=>$this->passion
        ];
    }
}

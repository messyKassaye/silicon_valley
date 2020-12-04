<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\User;
use Auth;
class LikeResource extends JsonResource
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
          'id'=>$this->id,
          'user'=>Auth::user()->id==$this->liker_id?
          User::find($this->user_id) 
          :User::find($this->liker_id) 
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ProductPriceResource;
class ProductResource extends JsonResource
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
            'name'=>$this->name,
            'image_path'=>$this->product_image,
            'description'=>$this->description,
            'subscription'=>$this->subscriptions,
            'prices'=>ProductPriceResource::collection($this->price),

        ];
    }
}

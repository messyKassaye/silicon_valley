<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ProductSubscriptionInclude;
use App\Subscribtion;

class Products extends Model
{
    //

    public function includes(){
        return $this->hasMany(ProductSubscriptionInclude::class,'product_id');
    }

    public function price(){
        return $this->hasMany(ProductPrice::class,'product_id');
    }

    public function subscriptions(){
        return $this->belongsToMany(Subscribtion::class);
    }
}

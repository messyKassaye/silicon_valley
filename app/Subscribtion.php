<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Products;
class Subscribtion extends Model
{
    //

    public function product(){
        return $this->belongsToMany(Products::class);
    }
}

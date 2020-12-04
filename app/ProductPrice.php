<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Package;
class ProductPrice extends Model
{
    //

    public function package(){
        return $this->belongsTo(Package::class,'package_id');
    }
}

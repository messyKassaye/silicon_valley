<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Passion extends Model
{
    //

    public function user(){
        return $this->belongsToMany(User::class);
    }
}

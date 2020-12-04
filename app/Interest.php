<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Gender;
use App\User;
class Interest extends Model
{
    //

    public function gender(){
        return $this->hasOne(Gender::class);
    }

    public function user(){
        return $this->hasOne(User::class);
    }
}

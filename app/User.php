<?php

namespace App;

use App\Address;
use App\Company;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\BankAccount;
use App\District;
use App\Group;
use App\Gender;
use App\Interest;
use App\Passion;
use App\UserUtility;
use App\Media;
class User extends Authenticatable implements JWTSubject
{
    use Notifiable;
    protected  $visible = ['id','name','email','phone','profile_pic_path','status'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
   

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Automatically creates hash for the user password.
     *
     * @param  string  $value
     * @return void
     */

    

    
     public function role(){
         return $this->belongsToMany(Role::class);
     }

     public function gender(){
         return $this->belongsToMany(Gender::class);
     }

     public function interest(){
         return $this->hasOne(Interest::class);
     }

     public function passion(){
         return $this->belongsToMany(Passion::class);
     }

     public function utility(){
         return $this->hasOne(UserUtility::class);
     }

     public function media(){
         return $this->hasMany(Media::class);
     }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function setFirstNameAttribute($value){
         $this->attributes['first_name'] = ucfirst($value);
    }

    public function setLastNameAttribute($value){
         $this->attributes['last_name'] = ucfirst($value);
    }
    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}

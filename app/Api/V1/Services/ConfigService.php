<?php


namespace App\Api\V1\Services;


use App\EntityType;
use App\FinanceBalance;
use App\PaymentPercentage;
use App\Role;
use App\User;

class ConfigService
{

    public function createAdmin(){
        $user = new User();
        $user->first_name  = 'Meseret';
        $user->last_name = 'Kassaye';
        $user->email = 'meseret.kassaye@gmail.com';
        $user->phone = '0923644545';
        $user->avator = 'letter';
        $user->confirmation_code = $this->generateCouponCode(6);
        $user->password = 'configuration';
        $user->save();

        $financeBalance = new FinanceBalance();
        $financeBalance->balance = 0.0;
        $user->balance()->save($financeBalance);

        $role = Role::find(1);
        $user->role()->save($role);
    }

    public function createRoles(){
        $roles = new Role();
        $roles->name = 'Admin';
        $roles->is_public = false;
        if ($roles->save()){
            //drivers role
            $driverRole = new Role();
            $driverRole->name = 'Car owner';
            $driverRole->save();

            //save advertiser
            $advertiserRole = new Role();
            $advertiserRole->name = 'Advertiser';
            $advertiserRole->save();

            //downloader role
            $downloader = new Role();
            $downloader->name = 'Driver';
            $roles->is_public = false;
            $downloader->save();
        }
    }

    public function createEntities(){
        $entityType = array(
            array('New advert payment is sent','Advert payment is sent to you and waiting your permission'),
            array('New advert media is sent to you','Advert medial is uploaded and waiting your view'),
            array('New advert media file upload permission is sent to you','You are allowed to upload your advert media file'),
            array('Your advert is on air',"Your advert is sent to Ride ads advertisement air")
        );
        foreach ($entityType as $entity){
             $entities = new EntityType();
             $entities->name = $entity[0];
             $entities->message = $entity[1];
             $entities->save();
        }
        $this->createRoles();
        $this->createAdmin();
        $this->createPaymentPercentage();
    }

    public function createPaymentPercentage(){
        $paymentPercentage = new PaymentPercentage();
        $paymentPercentage->car_owners_percentage = 60;
        $paymentPercentage->save();
    }

    public function advertPaymententity(){
        $entity = new EntityType();
        $entity->name = 'Advert payment is done';
        $entity->message = 'Your advert payment is done. you can upload your advert media now';
        $entity->save();
    }

    public function withdrawRequestIsDone(){
        $entity = new EntityType();
        $entity->name = 'Withdraw request is done';
        $entity->message = 'Your withdraw request is done';
        $entity->save();
    }

    function generateCouponCode($length = 4)
    {
        $chars = '0123456789';
        $ret = '';
        for ($i = 0; $i < $length; ++$i) {
            $random = str_shuffle($chars);
            $ret .= $random[0];
        }
        return $ret;
    }

}
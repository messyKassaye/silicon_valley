<?php


namespace App\Api\V1\Services;


class PercentCalculator
{

    public function calculate($percent,$amount){
        return $percent *($amount/100);
    }
}
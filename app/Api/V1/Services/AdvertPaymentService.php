<?php


namespace App\Api\V1\Services;


use App\AdvertViewPayment;

class AdvertPaymentService
{

    protected $financeService;
    public function __construct(FinanceService $financeService)
    {
        $this->financeService = $financeService;
    }

    public function driversPayment($driverId,$totalPayment,$payerId,$carAdvertId){
        $advertPayment = new AdvertViewPayment();
        $advertPayment->car_advert_id = $carAdvertId;
        $advertPayment->payer_id = $payerId;
        $advertPayment->total_payment = $totalPayment;
        $advertPayment->payed_for = $driverId;
        if($advertPayment->save()){
            $this->financeService->finance($driverId,$totalPayment);
            return true;
        }
    }

    public function tabAdvertsPayment($tabAdvertid,$totalPayment,$payerId,$carAdvertId){
        $advertPayment = new AdvertViewPayment();
        $advertPayment->car_advert_id = $carAdvertId;
        $advertPayment->payer_id = $payerId;
        $advertPayment->total_payment = $totalPayment;
        $advertPayment->payed_for = $tabAdvertid;
       if($advertPayment->save()){
           $this->financeService->finance($tabAdvertid,$totalPayment);
           return true;
       }
    }
}
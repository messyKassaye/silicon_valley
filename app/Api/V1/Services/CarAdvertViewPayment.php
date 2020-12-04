<?php


namespace App\Api\V1\Services;
use App\AdvertViewPayment;
use App\CarAdvert;
use App\FinanceBalance;
use App\Http\Resources\AdvertsResource;
use App\Api\V1\Services\AdvertPaymentService;
use App\Api\V1\Services\PercentCalculator;
use App\PaymentPercentage;
use Auth;
class CarAdvertViewPayment
{

    protected $advertViewPaymentService,$percentageCalculator;
    public function __construct(AdvertPaymentService $advertPaymentService,PercentCalculator $percentCalculator)
    {
        $this->advertViewPaymentService = $this->advertViewPaymentService;
        $this->percentageCalculator = $percentCalculator;
    }

    public function pay(){
        //
        $paymentPercentage = PaymentPercentage::find(1);
        $driverPayment = $paymentPercentage['car_owners_percentage'];
        $tabAdvertPayment = 100-$driverPayment;

        $carAdverts = CarAdvert::where('status','On progress')->get();
        foreach ($carAdverts as $adverts){
            $carAdvert = CarAdvert::find($adverts['id']);
            $advert = new AdvertsResource($carAdvert['advert']);
            $MediaType = $advert['advertMediaType'];
            $perViewPayment = $MediaType['per_view_payment'];
            $payerId = 1;///Auth::guard()->user()->id;
            $carAdvertId = $carAdvert['id'];
            $car = $carAdvert['car'];

            //driver is payed
            $driverTotalPayment = $this->percentageCalculator->calculate($driverPayment,$perViewPayment);
             $this->driversPayment($car['user_id'],$driverTotalPayment,$payerId,$carAdvertId,$car['driver_id'],$driverPayment);

            //tab advert is payed
            $tabAdvertTotalPayment = $this->percentageCalculator->calculate($tabAdvertPayment,$perViewPayment);
            $this->tabAdvertsPayment(1,$tabAdvertTotalPayment,$payerId,$carAdvertId);

            $carAdvert->status = 'Payed';
            $carAdvert->save();
        }
    }



    public function driversPayment($carOwnerId,$totalPayment,$payerId,$carAdvertId,$driverId,$carOwnerPaymentPercentage){

        $carOwnerPayment = $carOwnerPaymentPercentage;
        $driverPayment = 100-$carOwnerPayment;
        //car owners payment
        $carOwnerTotalPayment = $this->percentageCalculator->calculate($carOwnerPayment,$totalPayment);
        $advertPayment = new AdvertViewPayment();
        $advertPayment->car_advert_id = $carAdvertId;
        $advertPayment->payer_id = $payerId;
        $advertPayment->total_payment = $carOwnerTotalPayment;
        $advertPayment->payed_for = $carOwnerId;

        //driver payment
        $driverTotalPayment = $this->percentageCalculator->calculate($driverPayment,$totalPayment);
        $advertPaymentDriver = new AdvertViewPayment();
        $advertPaymentDriver->car_advert_id = $carAdvertId;
        $advertPaymentDriver->payer_id = $payerId;
        $advertPaymentDriver->total_payment = $driverTotalPayment;
        $advertPaymentDriver->payed_for = $driverId;
        if($advertPayment->save()&&$advertPaymentDriver->save()){
            $this->finance($carOwnerId,$carOwnerTotalPayment);
            $this->finance($driverId,$driverTotalPayment);
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
            $this->finance($tabAdvertid,$totalPayment);
            return true;
        }
    }

    public function finance($user_id,$amount)
    {


        //save total balance for tab adverts
        $financeBalance = FinanceBalance::where('user_id',$user_id)->get();
        $totalBalance = $financeBalance[0]['balance'] + $amount;

        $financeBalanceUpdater = FinanceBalance::find($financeBalance[0]['id']);
        $financeBalanceUpdater->balance = $totalBalance;
        $financeBalanceUpdater->save();
    }
}
<?php


namespace App\Api\V1\Services;


use App\FinanceBalance;

class FinanceService
{

    public function finance($user_id,$amount)
    {


        //save total balance for tab adverts
        $financeBalance = FinanceBalance::where('user_id',$user_id)->get();
        $totalBalance = $financeBalance[0]['balance'] + $amount;

        $financeBalanceUpdater = FinanceBalance::find($financeBalance[0]['id']);
        $financeBalanceUpdater->balance = $totalBalance;
        $financeBalanceUpdater->save();
    }

    public function withdraw($user_id,$amount){
        $financeBalance = FinanceBalance::where('user_id',$user_id)->get();
        $totalBalance = $financeBalance[0]['balance'];
        if($amount>$totalBalance){
            return false;
        }else{
            $currentBalance = round($totalBalance-$amount,2);
            $financeBalanceUpdater = FinanceBalance::find($financeBalance[0]['id']);
            $financeBalanceUpdater->balance = $currentBalance;
            $financeBalanceUpdater->save();
            return true;
        }

    }
}
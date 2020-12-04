<?php


namespace App\Api\V1\Services;

use App\AdvertDeposit;
use App\Deposit;
use App\Finance;
use App\FinanceBalance;
use App\User;
use Carbon\Carbon;
use Auth;
class TabAdvertDepositService
{

    public function advertDeposit($admin_id,$advert_id,$transaction_id,$deposit)
    {
        $advertDeposit = new AdvertDeposit();
        $advertDeposit->advert_id = $advert_id;
        $advertDeposit->deposited_by = $admin_id;
        $advertDeposit->transaction_id = $transaction_id;
        $advertDeposit->deposit = $deposit;
        $advertDeposit->save();

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Credit  $credit
     * @return \Illuminate\Http\Response
     */
    public function finance($user_id,$amount)
    {


        //save total balance for tab adverts
        $financeBalance = FinanceBalance::where('user_id',$user_id)->get();
        $totalBalance = $financeBalance[0]['balance'] + $amount;

        $financeBalanceUpdater = FinanceBalance::find($financeBalance[0]['id']);
        $financeBalanceUpdater->balance = $totalBalance;
        $financeBalanceUpdater->save();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Credit  $credit
     * @return \Illuminate\Http\Response
     */
    public function cancelAdvertDeposit($advert_id)
    {

        $advertDeposit = AdvertDeposit::where('advert_id',$advert_id)->get();
        if(AdvertDeposit::destroy($advertDeposit[0]['id'])){
            return true;
        }
    }

    public function cancelDepositAndFinanceBalance($admin_id,$advert_id,$amount){

        $deposit = Deposit::where(['advert_id'=>$advert_id,'user_id'=>$admin_id])->get();

        $financeBalance = FinanceBalance::where('user_id',$admin_id)->get();
        $totalBalance = $financeBalance[0]['balance'] - $amount;

        $financeBalanceUpdater = FinanceBalance::find($financeBalance[0]['id']);
        $financeBalanceUpdater->balance = $totalBalance;
        $financeBalanceUpdater->save();
        if(Deposit::destroy($deposit[0]['id'])){
            return true;
        }
    }


}
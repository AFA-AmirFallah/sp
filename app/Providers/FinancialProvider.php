<?php

namespace App\Providers;

use App\Models\UserCredit;
use App\Models\UserInfo;
use App\myappenv;

class FinancialProvider
{
    private $buyer_src = null;
    private function get_buyer_src($UserName)
    {
        if ($this->buyer_src != null) {
            return $this->buyer_src;
        }
        $this->buyer_src = UserInfo::where('UserName', $UserName)->first();
        return $this->buyer_src;
    }
    private function check_buyer_history($buyer_UserName, $CreditMod, $maxBuy)
    {
        $buyer_src = $this->get_buyer_src($buyer_UserName);
        if($buyer_src->CreditePlan != 2){
            return [
                'result' => false,
                'msg' => 'این قابلیت برای شما فعال نمی باشد'
            ];
        }
        $usercredit = UserCredit::where('UserName', $buyer_UserName)->where('CreditMod', $CreditMod)->get();
        $totall_buy = 0;
        foreach ($usercredit as $usercredit_item) {
            if ($usercredit_item->Mony > 0) {  // buy before
                $totall_buy += $usercredit_item->Mony;
            }
        }
        if ($totall_buy >= $maxBuy) {
            return [
                'result' => false,
                'msg' => 'مشتری گرامی شما تا کنون بیشتر از سقف برداشت خرید نموده اید!'
            ];
        } else {
            return [
                'result' => true
            ];
        }
    }
    private function check_provider_to_support_buyer()
    {
        return [
            'result' => true
        ];
    }

    private function decrease_buyer_price_from_provider()
    {
        return [
            'result' => true
        ];
    }
    private function add_buyer_price_to_buyer_credit($buyer_UserName,$dec_price,$CreditMod){
        $TransactionData = [
            'UserName' => $buyer_UserName,
            'Mony' => $dec_price,
            'Type' => 94,
            'Date' =>now(),
            'Note' => 'افزاش موجودی بنا بر طرح خاص',
            'TransferBy' => 'system',
            'CreditMod' => $CreditMod,
            'branch' => myappenv::Branch,
            'ConfirmBy'=>'system',
            'Confirmdate'=>now()

        ];
         $insert_result = UserCredit::create($TransactionData);
         return $insert_result->id;
    }



    // $CreditMod = 4

    public function pre_checkout_process($CreditMod, $buyer_UserName, int $dec_price, $maxBuy = 50000000)
    {
        $dec_price = abs($dec_price); // make sure the price if positive
        if ($CreditMod != 4) { // test credit mod
            return [
                'result' => true
            ];
        }

        //1 check buyer not credit not more then defined credit -> 50000
        $check_buyer_history = $this->check_buyer_history($buyer_UserName, $CreditMod, $maxBuy);
        if (!$check_buyer_history['result']) {
            return $check_buyer_history;
        }


        //TODO: 2 check provider has credit to provide buyer selling 


        $check_provider_to_support_buyer = $this->check_provider_to_support_buyer();
        if (!$check_provider_to_support_buyer['result']) {
            return $check_provider_to_support_buyer;
        }




        //TODO: 3 decrease buyer price from provider

        $decrease_buyer_price_from_provider = $this->decrease_buyer_price_from_provider();
        if (!$decrease_buyer_price_from_provider['result']) {
            return $decrease_buyer_price_from_provider;
        }



        //4 add buyer price to buyer credit
        $add_buyer_price_to_buyer_credit = $this->add_buyer_price_to_buyer_credit($buyer_UserName,$dec_price,$CreditMod);
        return [
            'result' => true,
            'BaseCredit'=>$add_buyer_price_to_buyer_credit
        ];
    }
}

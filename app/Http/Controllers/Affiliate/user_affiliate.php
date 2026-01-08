<?php

namespace App\Http\Controllers\Affiliate;

use App\Affiliate\affiliate_user;
use App\Functions\Financial;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Users\Accounts;
use App\myappenv;
use Illuminate\Http\Request;
use Auth;

class user_affiliate extends Controller
{
    public function affiliate()
    {
        $affiliate = new affiliate_user;
        $MyAccount = new Accounts;
        $UserAccounts = $MyAccount->get_user_bank_accounts(Auth::id());

        return view('Affiliate.Affiliate_main_page', ['affiliate' => $affiliate,'UserAccounts'=>$UserAccounts]);
    }
    private function load_affiliate_dashboard()
    {
        $affiliate = new affiliate_user;
        $refers = $affiliate->get_who_many_clint_under_user_cat(Auth::id(), 1);
        $requst = $affiliate->get_who_many_request_under_user_cat(Auth::id(), 1);
        $contract = $affiliate->get_who_many_service_under_user_cat(Auth::id(), 1);
        $Myfin = new Financial();
        $UserCredit = $Myfin->UserHasCredite(Auth::id(), myappenv::CachCredit);

       
        $result = [
            'result' => true,
            'refers' => $refers['data'],
            'total_refers' => $refers['data'],
            'request' => $requst['data'],
            'contract' => $contract['data'],
            'UserCredit'=>number_format($UserCredit) ,
            'done_contract' => 10
        ];

        return $result;
    }
    public function Doaffiliate(Request $request)
    {
        if ($request->axios) {
            if ($request->function == 'load_dashboard') {
                return $this->load_affiliate_dashboard();
            }
        }
    }
}

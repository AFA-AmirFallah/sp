<?php

namespace App\Http\Controllers\Credit;

use App\Functions\CacheData;
use App\Http\Controllers\Controller;
use App\Models\BankAccount;
use App\Models\UserCreditModMeta;
use App\myappenv;
use Illuminate\Http\Request;
use Auth;
use DB;

class Accounts extends Controller
{
    public function GetWalletType($Extra , $ID){
        if(str_contains($Extra,'api')){
            return 'کیف پول API';
        }
        if($Extra == 'Periodic'){
            return 'اعتبار دوره ای';
        }
        if($ID == myappenv::CachCredit){
            return 'کیف پول قابل برداشت';
        }
        if($ID == myappenv::UnaccessCredit){
            return 'کیف پول غیر قابل برداشت';
        }
        return '';
    }
    public function CreditModCreate(){
        $CreditModSrc = UserCreditModMeta::all();
        return view('Credit.CreateUserCredit',['functions'=>$this, 'CreditModSrc'=>$CreditModSrc]);

    }
    public function DoCreditModCreate(Request $request){
        if($request->has('submit')){
            
            $Max = UserCreditModMeta::max('ID') + 1;
            if($request->has('API')){
                $Extra = [
                    'API'=>$request->input('API')
                ];
                $Extra = json_encode($Extra);
            }else{
                $Extra = null;
            }
            $Data = [
                'ID'=>$Max,
                'ModName'=>$request->input('ModName'),
                'extra'=>$Extra
            ];
            UserCreditModMeta::create($Data);
            return redirect()->back()->with('success','کیف پول اضافه شد!');

        }
        if($request->has('periodical')){
            $CreditID = $request->input('periodical');
            UserCreditModMeta::where('ID',$CreditID)->update(['extra'=>'Periodic']);
            CacheData::PutCreditMod();
            return redirect()->back()->with('success','کیف پول به کیف پول دوره ای تغییر وضعیت داد!');

        }
    }
    public function AccountConfirm()
    {
        return view("Credit.AccountConfirm", ['Cards' => null]);
    }

    public function DoAccountConfirm(Request $request)
    {
        if ($request->input('submit') == 'Search') {
            $user_branch = Auth::user()->branch;

            $Query = "SELECT BankAccount.UserName, BankAccount.CardNo, BankAccount.‌BankName as BankName, BankAccount.Status ,UserInfo.Name ,UserInfo.Family,BankAccount.Account FROM BankAccount INNER JOIN UserInfo on BankAccount.UserName = UserInfo.UserName  ";
            if($user_branch == myappenv::Branch){
                $Query .= " where UserInfo.branch is not null  ";
            }else{
                $Query .= " where UserInfo.branch =  $user_branch ";
            }
            if ($request->has('CartOwner') && $request->input('CartOwner') != null) {
                $CartOwner = $request->input('CartOwner');
                $Query .= " and BankAccount.UserName = '$CartOwner'";
            }
            if ($request->has('CartNumber') && $request->input('CartNumber') != null) {
                $CartNumber = $request->input('CartNumber');
                $Query .= " and BankAccount.CardNo = '$CartNumber'";
            }
            if ($request->has('NameFamily') && $request->input('NameFamily') != null) {
                $NameFamily = $request->input('NameFamily');
                $Query .= " and (UserInfo.Name like '%$NameFamily%'  or UserInfo.Family like '%$NameFamily%'  )";
            }
            $CardType = $request->input('optionsRadios');
            switch ($CardType) {
                case '2':
                    $Query .= " and BankAccount.Status = 0 ";
                    break;
                case '1':
                    $Query .= " and BankAccount.Status = 1 ";
                    break;
                case '3':
                    $Query .= " and BankAccount.Status != 3 ";
                    break;
            }
            $Cards = DB::select($Query);
            return view("Credit.AccountConfirm", ['Cards' => $Cards]);
        } elseif ($request->has('submitState')) {
            $UpdateData = [
                '‌BankName' => $request->input('modal_bank'),
                'Status' => $request->input('submitState')
            ];
            $UpdateResult = BankAccount::where('UserName', $request->input('UserName'))->where('CardNo', $request->input('Cardno'))->update($UpdateData);
            if($UpdateResult  == 1){
                return redirect()->back()->with('success',__("Transaction done!"));

            }else{
                return redirect()->back()->with('error',__("The error has accure in your requsest please try again or call to callcenter!"));

            }
        } elseif ($request->has('submit') == 'update') {
            $UpdateData = [
                'CardNo'=>$request->input('Cardno'),
                'Account'=>$request->input('Accountno'),
                '‌BankName'=>$request->input('modal_bank')
            ];
            $UpdateResult = BankAccount::where('UserName', $request->input('UserName'))->where('CardNo', $request->input('CardnoBase'))->update($UpdateData);
            if($UpdateResult  == 1){
                return redirect()->back()->with('success',__("Transaction done!"));

            }else{
                return redirect()->back()->with('error',__("The error has accure in your requsest please try again or call to callcenter!"));

            }

        }


    }
}

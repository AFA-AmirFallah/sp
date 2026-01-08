<?php

namespace App\Shop;

use App\delete_rows\delete_data_main;
use App\Http\Controllers\Credit\Tashim as CreditTashim;
use App\Models\DeviceContract;
use App\Models\DeviceItemExternal;
use App\Models\tashim;
use App\Models\UserCredit;
use App\Models\warehouse_goods;
use App\myappenv;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class rent
{
    private $wallet_arr = [];
    private $RefrenceID = null;

    public function delete_rent_permanent($username, $rent_id)
    {
        $related_credit_src = UserCredit::where('bill', $rent_id)->get();
        $DeviceContract_src = DeviceContract::where('ContractID', $rent_id)->get();
        $related_credit_rows = $related_credit_src->toArray();
        $DeviceContract_rows = $DeviceContract_src->toArray();
        $my_delete = new delete_data_main;
        $usercredit_delete_audit = $my_delete->permanent_delete($username, 'UserCredit', $related_credit_rows,'');
        if(!$usercredit_delete_audit['result']){
            return [
                'result'=>false,
                'msg'=>'can not add to delete auditing'
            ];
        }
        $device_contract_delete_audit = $my_delete->permanent_delete($username,'DeviceContract',$DeviceContract_rows,'');
        if(!$device_contract_delete_audit['result']){
            return [
                'result'=>false,
                'msg'=>'can not add to delete auditing'
            ];
        }
        $related_credit_src = UserCredit::where('bill', $rent_id)->delete(); //HACK:UserCredit 
        $DeviceContract_src = DeviceContract::where('ContractID', $rent_id)->delete();
        return [
            'result'=>true
        ];

        
    }
    private function checkout_rent($Result, $DeviceContract_id, $RequestUser)
    {
        foreach ($Result as $Result_item) {
            if ($Result_item['TargteUserID'] != null) {
                if ($Result_item['Amount'] != 0) {
                    $TransactionData = [
                        'UserName' => $Result_item['TargteUserID'],
                        'Mony' => $Result_item['Amount'],
                        'Type' => 35,
                        'Date' => now(),
                        'TransferBy' => $RequestUser,
                        'CreditMod' => $Result_item['CreditMod'],
                        'ReferenceId' => $this->RefrenceID,
                        'bill' => $DeviceContract_id,
                        'Note' => "قرارداد اجاره شماره $DeviceContract_id : " . $Result_item['Note'],
                        'branch' => Auth::user()->branch
                    ];
                    $Result = UserCredit::create($TransactionData);
                    if ($this->RefrenceID == null) {
                        $this->RefrenceID = $Result->id;
                        UserCredit::where('id', $this->RefrenceID)->update(['ReferenceId' => $this->RefrenceID]);
                    }
                }
            }
        }
        return true;
    }
    public function rent_checkout(string $RequestUser, Request $request)
    {
        $tashim = new CreditTashim;
        $DeviceContract_id = $request->payment;
        $DeviceContract_src = DeviceContract::where('ContractID', $DeviceContract_id)->first();
        if ($DeviceContract_src == null) {
            return [
                'result' => false,
                'msg' => 'قرارداد درخواست شده در سامانه موجود نیست!'
            ];
        }
        $DeviceItemExternal_src = DeviceItemExternal::where('ContractNumber', $DeviceContract_id)->get();
        $main_tashim = $DeviceContract_src->tashim;
        $buyer = $DeviceContract_src->Owner;
        foreach ($DeviceItemExternal_src as $DeviceItemExternal_item) {
            $pwid =  $DeviceItemExternal_item->pwid;
            $warehouse_good_src = warehouse_goods::where('id', $pwid)->first();
            $owner = $warehouse_good_src->owner;
            $Seller = $RequestUser;
            $Daramad = myappenv::StackHolder . Auth::user()->branch;
            $Marketer = null;
            $wg_src = warehouse_goods::where('id', $pwid)->first();
            $Price = $DeviceItemExternal_item->Price;
            $OwnerPrice = $DeviceItemExternal_item->OwnerPrice;
            $ProductAttr = [
                'ProductId' => $wg_src->GoodID,
                'PwID' => $pwid,
                'TashimID' => $main_tashim,
            ];
            $MonyAttr = [
                'SaleMony' => $Price,
                'BuyMony' => $OwnerPrice,
                'DeleverMony' => 0,
                'TaxMony' => 0,
            ];
            $tashim->set_holders($buyer, $Seller, $owner, $Daramad, $Marketer);
            $Result = $tashim->ExecTashim($ProductAttr, $MonyAttr);
            $result = $this->checkout_rent($Result, $DeviceContract_id, $RequestUser);
        }

        DeviceContract::where('ContractID', $DeviceContract_id)->update(['Status' => 100]);
        return $result;
    }
}

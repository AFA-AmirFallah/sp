<?php


namespace App\Functions;

use App\APIS\SmsCenter;
use App\Http\Controllers\woocommerce\buy;
use App\Http\Controllers\woocommerce\product;
use App\Models\product_order;
use App\Models\ProductView;
use App\Models\UserCredit;
use App\Models\UserInfo;
use App\myappenv;
use Session;
use DB;
use Auth;
use Illuminate\Queue\NullQueue;

class cashierClass extends buy
{
    public function UserHasPeriodicCredit($UserName)
    {
        $MyPeriodicCredit = new periodicCreditClass();
        return $MyPeriodicCredit->UserHasPeriodicCredit($UserName);
    }
    public function GetUserPeriodicCredit($UserName)
    {
        $MyPeriodicCredit = new periodicCreditClass();
        return $MyPeriodicCredit->GetUserPeriodicStatus($UserName, 3);
    }
    public function UserUnPayed($UserName)
    {
        return UserCredit::where('UserName', $UserName)->where('Type', myappenv::casheirCredittype)->where('ZeroRefrenceID', null)->orderBy('InvoiceNo', 'DESC')->get();
    }
    public function MyUnPayed()
    {
        return $this->UserUnPayed(Auth::id());
    }
    public function removeCustomer()
    {
        Session::forget('customerID');
        return true;
    }
    public function SearchProduct($SearchText)
    {
        return ProductView::where('NameFa', 'like', "%$SearchText%")->orWhere('id', $SearchText)->orWhere('IRID', $SearchText)->orWhere('SKU', $SearchText)->get();
    }
    public function get_Product_tashims($WGID)
    {
        $Query = "select * from tashim_items  as ti inner join tashims t on ti.TashimID = t.id where ti.GoodsID = $WGID and t.Operation != 0 ";
        $Tashims = DB::select($Query);
        return $Tashims;
    }
    public function clear_order()
    {
        Session::forget('basket');
        Session::forget('Tashim');
    }
    public function definecustomer($UserName)
    {
        $UserSrc = UserInfo::where('UserName', $UserName)->first();
        if ($UserSrc) {
            Session::put('customerID', $UserName);
            $Output = [
                'result' => true,
            ];
            return $Output;
        } else {
            $Output = [
                'result' => false
            ];
            return $Output;
        }
    }
    public function get_curent_customer($Feild = null)
    {
        if (Session::has('customerID')) {
            $UserName = Session::get('customerID');
            $UserSrc = UserInfo::where('UserName', $UserName)->first();

            if ($Feild == null) {

                return $UserSrc;
            } else {
                return $UserSrc->$Feild;
            }
        } else {
            return null;
        }
    }
    public function get_User_Order_History($UserName)
    {
        $Orders = product_order::all()->where('CustomerId', $UserName)->where('status', '>=', 0);
        return $Orders;
    }
    public function get_user_walet($UserName)
    {

        $Query = "SELECT sum(uc.Mony) as Mony ,uc.CreditMod , um.ModName as ModName  FROM UserCredit as uc inner join UserCreditModMeta as um on um.ID = uc.CreditMod WHERE uc.UserName = '$UserName' and uc.ConfirmBy is not null GROUP BY uc.CreditMod";
        $Resutl = DB::select($Query);
        return $Resutl;
    }
    public function ConfirmPay($pay = null, $ref = null)
    {

        $ResNum = Session::get('ResNum');
        //$price = Session::get('price');
        $price = Session::get('casherprice');

        $MyTransfer = new TransferProduct($ResNum);
        $resutl = $MyTransfer->UserPay('صندوقدار', $ResNum, 'CDP');
        if ($resutl) {
            $RResult = array('Mony' => Session::get('price'), 'Confirmdate' => date("Y-m-d H:i:s"), 'GateWay' => 'کیف پول');
            Session::forget('price');
            Session::forget('casherprice');
            Session::forget('ResNum');
            $UserName = $this->get_curent_customer('UserName');
            $UserInfo = UserInfo::where('UserName', $UserName)->first();
            Session::forget('basket');
            Session::forget('Tashim');
            Session::forget('customerID');
            $MySMS = new SmsCenter();
            $CustomerText = 'سلام ' . Auth::user()->Name . ' ' . Auth::user()->Family . ' عزیز' . "\n";
            $CustomerText .= 'سفارش شما به شماره ' . $ResNum . ' با موفقیت ثبت شد.' . "\n";
            $CustomerText .= 'با تشکر از خرید شما.' . "\n";
            $CustomerText .= myappenv::CenterName;
            $MySMS->OndemandSMS($CustomerText, $UserInfo->MobileNo, 'tnks', $UserInfo->MobileNo);
            $SellerText = 'سلام مدیر خرید حضوری ' . $ResNum . 'با مبلغ ' . number_format($price) . ' در سامانه ثبت شد!';

            if (myappenv::MainOwner == 'shafatel' || myappenv::MainOwner == 'Carpetour') {
                $MySMS->OndemandSMS($SellerText, '09126543802', 'tnks', '09126543802');
            } else {
                // $MySMS->OndemandSMS($SellerText, '09123345580', 'tnks', '09123345580');
            }
            //$this->AddLog($ResNum);
            $MyProduct = new product();
            $MyProduct->AddLog($ResNum);
            // $MySMS->OndemandSMS($SellerText, '09123936105', 'tnks', '09123936105');
            if (myappenv::MainOwner == 'kookbaz') {
                $MySMS->OndemandSMS($SellerText, '09125833245', 'tnks', '09125833245');
                $MySMS->OndemandSMS($SellerText, '09192228284', 'tnks', '09192228284');
                $MySMS->OndemandSMS($SellerText, '09101812802', 'tnks', '09101812802');
            }
            return  $ResNum;
        } else {
            return 0;
        }
    }

    public function finalyze()
    {
        $MyOrder = new Orders();
        $TargetLocation = 0; //Frosh hozori
        $ProductOrderId = $MyOrder->OrderPreSave($TargetLocation);
        Session::put('ResNum', $ProductOrderId);
        $MyOrder->AddOrderItems($ProductOrderId);
        $MyOrder->SetShepping(0);
        $finalyzeresult = $MyOrder->finalyzeProductOrder();
        if ($finalyzeresult == 1) {
            if (Session::has('customerID')) {
                $TargetUser = Session::get('customerID');
            } else {
                $TargetUser = Auth::id();
            }
            if ($MyOrder->IsValidTashim($TargetUser)) {
                return $this->ConfirmPay(myappenv::CachCredit, $ProductOrderId);
            } else {
                return 'مشکلی پیش آمده است';
            }
        } else {
            return 'دسترسی غیر مجاز';
        }
    }
    public function removeitem($ProductID)
    {
        $MyBuy = new buy();
        $MyBuy->RemoveGoodFromBasket($ProductID);
    }
}

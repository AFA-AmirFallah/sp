<?php

namespace App\Functions;

use App\APIS\SmsCenter;
use App\Http\Controllers\Credit\Invoice;
use App\Models\DeviceContract;
use App\Models\DeviceItemInternal;
use App\Models\product_order;
use App\Models\product_order_items;
use App\Models\UserCredit;
use App\Models\UserInfo;
use App\myappenv;
use Illuminate\Support\Facades\Auth;
use DB;
use Throwable;
use Session;
use App\Http\Controllers\Credit\DirectPayment;


class TransferInvoice
{
    private $InvoiceNumber;
    private $RefrenceID;
    private $RequestUser;
    private $TotalPrice;
    private $BeyanehPrice;
    private $OwnerPrice;
    private $BuyerName;
    private $BuyerPhone;
    private $Note;
    private $PayAmount;
    private $Sellers;
    private $product_orders;
    private $InvouceCurentStatus;
    public function __construct($InvoiceNumber)
    {
        $this->InvoiceNumber = $InvoiceNumber;
        $DeviceContract = DeviceContract::where('ContractID', $InvoiceNumber)->first();
        $this->RequestUser = $DeviceContract->Owner;
        $BuyerInfo = UserInfo::where('UserName', $DeviceContract->Owner)->first();
        $this->BuyerName = $BuyerInfo->Name . ' ' . $BuyerInfo->Family;
        $this->BuyerPhone = $BuyerInfo->MobileNo;
        $this->TotalPrice = $DeviceContract->TotalPrice;
        $this->BeyanehPrice = $DeviceContract->BeyanehPrice;
        $this->OwnerPrice = $DeviceContract->OwnerPrice;
        $this->InvouceCurentStatus = $DeviceContract->Status;
        $this->Note = $DeviceContract->Note;
        $this->RefrenceID = $DeviceContract->CreditRefrence;
        $ProductOrderSrc = product_order::where('DeviceContract', $InvoiceNumber)->first();
        $this->product_orders = $ProductOrderSrc->id;
        $query = "SELECT  b.id,b.UserName,b.Phone from DeviceItemInternal as di INNER JOIN branches as b on di.Ownerbranch = b.id  WHERE di.ContractNumber = $InvoiceNumber GROUP BY  b.UserName,b.Phone ,b.id";
        $this->Sellers = DB::select($query);
    }
    public function GetUserInfo()
    {
        return UserInfo::where('UserName', $this->RequestUser)->first();
    }
    private function IncreaseTOBuyer($TRACENO, $RefNum, $Gateway)
    {
        if ($this->RefrenceID == null) { // initial insert to credite
            $TransactionData = [
                'UserName' => $this->RequestUser,
                'Mony' => $this->PayAmount,
                'Type' => 88,
                'Date' => now(),
                'Note' => $TRACENO . ' ' . $RefNum,
                'TransferBy' => 'system',
                'CreditMod' => myappenv::CachCredit,
                'ConfirmBy' => 'system',
                'InvoiceNo' => $this->product_orders,
                'PaymentId' => $TRACENO,
                'SpecialPaymentId' => $RefNum,
                'GateWay' => $Gateway,
                'Confirmdate' => now(),
                'branch' => 0
            ];
            $insertResult = UserCredit::create($TransactionData);
            $this->RefrenceID = $insertResult->id;
            UserCredit::where('ID', $this->RefrenceID)->update(['ReferenceId' => $this->RefrenceID]);
            DeviceContract::where('ContractID', $this->InvoiceNumber)->update(['CreditRefrence' => $this->RefrenceID]);
            return true;
        } else { // pay this invoice before
            $TransactionData = [
                'UserName' => $this->RequestUser,
                'Mony' => $this->PayAmount,
                'Type' => 88,
                'Date' => now(),
                'Note' => $TRACENO . ' ' . $RefNum,
                'TransferBy' => 'system',
                'CreditMod' => myappenv::CachCredit,
                'ConfirmBy' => 'system',
                'InvoiceNo' => $this->product_orders,
                'PaymentId' => $TRACENO,
                'SpecialPaymentId' => $RefNum,
                'GateWay' => $Gateway,
                'Confirmdate' => now(),
                'branch' => 0,
                'ReferenceId' => $this->RefrenceID
            ];
            UserCredit::create($TransactionData);
            return true;
        }
    }

    private function DecreseFromBuyer()
    {
        $TransactionData = [
            'UserName' => $this->RequestUser,
            'Mony' => -1 * $this->PayAmount,
            'Type' => 88,
            'Date' => now(),
            'Note' => $this->Note,
            'TransferBy' => 'system',
            'CreditMod' => myappenv::CachCredit,
            'ConfirmBy' => 'system',
            'InvoiceNo' => $this->product_orders,
            'Confirmdate' => now(),
            'branch' => 0,
            'ReferenceId' => $this->RefrenceID
        ];
        UserCredit::create($TransactionData);
        return true;
    }
    private function transfer_invoice_to_product_order()
    {
        $InvoiceItems = DeviceItemInternal::where('ContractNumber', $this->InvoiceNumber)->get();
        foreach ($InvoiceItems as $InvoiceItemsTarget) {
            $ProductOrderData = [
                'order_id' => $this->product_orders,
                'product_id' => $InvoiceItemsTarget->product_id,
                'pw_id' => $InvoiceItemsTarget->Device,
                'product_qty' => $InvoiceItemsTarget->product_qty,
                'branch' => $InvoiceItemsTarget->Ownerbranch,
                'customer_id' => $InvoiceItemsTarget->customer_id,
                'unit_Price' => $InvoiceItemsTarget->unit_Price,
                'unit_sales' => $InvoiceItemsTarget->unit_sales,
                'total_sales' => $InvoiceItemsTarget->total_sales,
                'tax_total' => 0,
                'customer_benefit_total' => $InvoiceItemsTarget->customer_benefit_total,
                'shipping_amount' => 0,
                'net_total' => $InvoiceItemsTarget->net_total,
                'desc' => 'استعلام قیمت شماره ' . $this->InvoiceNumber,
                'weight' => 0
            ];
            product_order_items::create($ProductOrderData);
        }
        return true;
    }
    private function BuyerPayComplite_increase_Seller()
    {
        $InvoiceItems = DeviceItemInternal::where('ContractNumber', $this->InvoiceNumber)->get();
        foreach ($InvoiceItems as $InvoiceItemsTarget) {
            $OwnerPrice = $InvoiceItemsTarget->OwnerPrice;
            foreach ($this->Sellers as $seller) {
                if ($InvoiceItemsTarget->Ownerbranch == $seller->id) {
                    $Sellerid = $seller->UserName;
                }
            }
            $TransactionData = [
                'UserName' => $Sellerid,
                'Mony' =>  $InvoiceItemsTarget->OwnerPrice,
                'Type' => 88,
                'Date' => now(),
                'Note' => $this->Note,
                'TransferBy' => 'system',
                'CreditMod' => myappenv::UnaccessCredit,
                'ConfirmBy' => 'system',
                'InvoiceNo' => $this->product_orders,
                'Confirmdate' => now(),
                'branch' => 0,
                'ReferenceId' => $this->RefrenceID
            ];
            UserCredit::create($TransactionData);
            $TransactionData = [
                'UserName' => myappenv::StackHolder,
                'Mony' =>  $InvoiceItemsTarget->Price - $InvoiceItemsTarget->OwnerPrice,
                'Type' => 88,
                'Date' => now(),
                'Note' => $this->Note,
                'TransferBy' => 'system',
                'CreditMod' => myappenv::CachCredit,
                'ConfirmBy' => 'system',
                'InvoiceNo' => $this->product_orders,
                'Confirmdate' => now(),
                'branch' => 0,
                'ReferenceId' => $this->RefrenceID
            ];
            UserCredit::create($TransactionData);
        }
        $this->transfer_invoice_to_product_order();
        return true;
    }
    private function BuyerPayUnComplite_increase_Seller()
    {
        return false;
    }
    private function IncreaseToSeller()
    {
        if ($this->PayAmount == $this->TotalPrice - $this->BeyanehPrice) {
            if ($this->InvouceCurentStatus == 50) {
                return  $this->BuyerPayComplite_increase_Seller();
            } else {
                return abort('404', 'مشکل امنیتی کد: ۳۲۷۸۴۳۶');
            }
        } else {
            return $this->BuyerPayUnComplite_increase_Seller();
        }
    }
    private function ConfirmInvoice()
    {
        DeviceContract::where('ContractID', $this->InvoiceNumber)->update(['Status' => 100]);
        return true;
    }
    private function AlertUsers_success()
    {
        $MySMS = new SmsCenter();
        foreach ($this->Sellers as $TargetBranch) {
            $BranchPhone = $TargetBranch->Phone;
            if (str_starts_with($BranchPhone, '09')) { //check if mobile phone to send sms
                $SellerText = myappenv::CenterName . ' ';
                $SellerText .= ' سلام تامین کننده گرامی سفارش ' . $this->product_orders  . ' پرداخت  نمود!';
                try {
                    $MySMS->OndemandSMS($SellerText, $BranchPhone, 'alert', $BranchPhone);
                } catch (Throwable $e) {
                }
            }
        }
        $CustomerText = myappenv::CenterName . ' ';
        $CustomerText .= $this->BuyerName . ' عزیز ' . $this->product_orders  . ' پرداخت  شما با موفقیت ثبت شد!';
        try {
            $MySMS->OndemandSMS($CustomerText, $this->BuyerPhone, 'alert', $this->BuyerPhone);
        } catch (Throwable $e) {
        }
        $CustomerText = ' سلام مدیر ' . $this->product_orders  . ' پرداخت  نمود!';
        try {
            $MySMS->OndemandSMS($CustomerText, '09125833245', 'alert', '09125833245');
            $MySMS->OndemandSMS($CustomerText, '09123936105', 'alert', '09123936105');
            $MySMS->OndemandSMS($CustomerText, '09192228284', 'alert', '09192228284');
        } catch (Throwable $e) {
        }
    }
    private function AlertUsers_partial_pay()
    {
        $MySMS = new SmsCenter();
        foreach ($this->Sellers as $TargetBranch) {
            $BranchPhone = $TargetBranch->Phone;
            if (str_starts_with($BranchPhone, '09')) { //check if mobile phone to send sms
                $SellerText = myappenv::CenterName . ' ';
                $SellerText .= ' سلام تامین کننده گرامی سفارش ' . $this->product_orders  . ' پرداخت بیعانه نمود!';
                try {
                    $MySMS->OndemandSMS($SellerText, $BranchPhone, 'alert', $BranchPhone);
                } catch (Throwable $e) {
                }
            }
        }
        $CustomerText = myappenv::CenterName . ' ';
        $CustomerText .= $this->BuyerName . ' عزیز ' . $this->product_orders  . ' پرداخت بیعانه شما با موفقیت ثبت شد!';
        try {
            $MySMS->OndemandSMS($CustomerText, $this->BuyerPhone, 'alert', $this->BuyerPhone);
        } catch (Throwable $e) {
        }
        $CustomerText = ' سلام مدیر ' . $this->product_orders  . ' پرداخت بیعانه نمود!';
        try {
            $MySMS->OndemandSMS($CustomerText, '09125833245', 'alert', '09125833245');
            $MySMS->OndemandSMS($CustomerText, '09123936105', 'alert', '09123936105');
            $MySMS->OndemandSMS($CustomerText, '09192228284', 'alert', '09192228284');
        } catch (Throwable $e) {
        }
    }
    private function confirm_partial_invoice()
    {
        if ($this->PayAmount == $this->BeyanehPrice) {
            DeviceContract::where('ContractID', $this->InvoiceNumber)->update(['Status' => 50]);
            return true;
        } else {
            return abort('404', 'مشکل امنیتی کد: ۸۳۶۶۴۹');
        }
    }
    public function UserPay($TRACENO, $RefNum, $Gateway, $PayAmount)
    {
        $this->PayAmount = $PayAmount;
        if (is_numeric($Gateway)) { // use user Credit
            $this->RefrenceID = 0;
        } else { // use from bank gateway
            $this->IncreaseTOBuyer($TRACENO, $RefNum, $Gateway);
        }
        $this->DecreseFromBuyer();
        if ($this->IncreaseToSeller()) {
            $this->ConfirmInvoice();
            $this->AlertUsers_success();
            return true;
        } else { //uncomplite pay
            if (Session::has('NormalInvoice')) {
                $NormalInvoice = Session::get('NormalInvoice');
                $DirectPay = new DirectPayment;
                $result['payername']=$this->RequestUser;
                $result['amount']= $this->TotalPrice ;
                $result['note']=$this->Note;
                $result['transactionReferenceID']=$this->RefrenceID;
                $result['traceNumber']=$this->RefrenceID;
                $result['transactionReferenceID']=$this->RefrenceID;
                $result =  $DirectPay->ConfirmIPG($NormalInvoice,$result,'normalinvoice');
                if($result){
                   
                    return true;

                    
                }

               
            }
            $result = $this->confirm_partial_invoice();
            if ($result != true) {
                return $result;
            }
            $this->AlertUsers_partial_pay();
            return true;
        }
    }
}

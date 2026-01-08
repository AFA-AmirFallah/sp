<?php


namespace App\Functions;

use App\APIS\SmsCenter;
use App\Http\Controllers\woocommerce\product;
use App\Models\branches;
use App\Models\branchs_order;
use App\Models\goods;
use App\Models\product_order;
use App\Models\product_order_items;
use App\Models\UserCredit;
use App\Models\UserInfo;
use App\Models\warehouse_goods;
use App\myappenv;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Throwable;

class TransferProduct
{
    protected $TotallMony;
    protected $product_orders;
    protected $Benefit;
    protected $StackHolder;
    protected $TaxHolder;
    protected $DefMony;
    protected $DefMonyTotall;
    protected $RequestUser;
    protected $Note;
    protected $RefrenceID;
    protected $SystemOwner;
    protected $TotallTax;
    protected $shipping;
    private function AddToSellers()
    {
        $OrderItems = product_order_items::all()->where('order_id', $this->product_orders);
        foreach ($OrderItems as $OrderItemTarget) {
            $ProductId = $OrderItemTarget->product_id;
            $MyProduct = new product();
            $Result = $MyProduct->GetProductBranch($ProductId, true);
            foreach ($Result as $ResultItem) {
                $BrnachOwner = $ResultItem->UserName;
                $BrachID = $ResultItem->BrachID;
            }
            $net_total = $OrderItemTarget->net_total;
            $total_sales = $OrderItemTarget->total_sales - $net_total;
            $seller_net = $net_total / 2;
            $Holder_Net = $net_total - $seller_net;
            $SelerProductAdd = [
                'UserName' => $BrnachOwner,
                'Mony' => $total_sales,
                'Type' => 88,
                'Date' => now(),
                'Note' => 'بابت فروش شماره : ' . $this->product_orders,
                'TransferBy' => 'system',
                'CreditMod' => myappenv::UnaccessCredit,
                'ConfirmBy' => 'system',
                'InvoiceNo' => $this->product_orders,
                'GateWay' => '',
                'Confirmdate' => now(),
                'branch' => $BrachID,
                'ReferenceId' => $this->RefrenceID
            ];
            UserCredit::create($SelerProductAdd);
            $SelerNetAdd = [
                'UserName' => $BrnachOwner,
                'Mony' => $seller_net,
                'Type' => 999,
                'Date' => now(),
                'Note' => 'بابت سود فروش شماره : ' . $this->product_orders,
                'TransferBy' => 'system',
                'CreditMod' => myappenv::UnaccessCredit,
                'ConfirmBy' => 'system',
                'InvoiceNo' => $this->product_orders,
                'GateWay' => '',
                'Confirmdate' => now(),
                'branch' => $BrachID,
                'ReferenceId' => $this->RefrenceID
            ];
            UserCredit::create($SelerNetAdd);
            $HolderNetAdd = [
                'UserName' => myappenv::StackHolder,
                'Mony' => $Holder_Net,
                'Type' => 999,
                'Date' => now(),
                'Note' => 'بابت سود فروش شماره : ' . $this->product_orders,
                'TransferBy' => 'system',
                'CreditMod' => myappenv::CachCredit,
                'ConfirmBy' => 'system',
                'InvoiceNo' => $this->product_orders,
                'GateWay' => '',
                'Confirmdate' => now(),
                'branch' => myappenv::Branch,
                'ReferenceId' => $this->RefrenceID
            ];
            UserCredit::create($HolderNetAdd);
        }
    }
    function __construct($product_orders)
    {
        $DefMony = 0;
        $this->product_orders = $product_orders;
        $this->StackHolder = myappenv::StackHolder;
        $this->SystemOwner = myappenv::SystemOwner;
        $this->TaxHolder = myappenv::TaxHolder;
        $product_order = product_order::where('id', $product_orders)->first();
        if ($product_order == null) {
            $this->RequestUser = Auth::id();
            $this->TotallMony = 0;
            $this->Benefit = 0;
        } else {
            $this->RequestUser = $product_order->CustomerId;
            $this->TotallMony = $product_order->total_sales;
            $this->TotallTax = $product_order->tax_total;
            $this->Benefit = $product_order->net_total;
            $this->shipping = $product_order->shipping_total;
        }
    }
    public function UserDirectPAy($TRACENO, $RefNum, $Gateway, $amount)
    {
        $this->TotallMony = $amount;
        if (is_numeric($Gateway)) { // use user Credit
            $this->RefrenceID = 0;
        } else { // use from bank gateway
            $this->AddToBuyer($TRACENO, $RefNum, $Gateway);
        }
        return true;
    }
    public function SetPayment($NewAmount)
    {
        $this->TotallMony = $NewAmount;
        return true;
    }
    private function Tasim_extar_pre_save_modify($SaveData, $TashimData)
    {
        $myTashimclass = new TashimClass();
        return $myTashimclass->Tasim_extar_pre_save_modify($SaveData, $TashimData);
    }
    private function PeriodicalCreditAdd($TransactionData)
    {
        if (CacheData::GetCreditMod($TransactionData['CreditMod']) == 'Periodic') {
            $CreditAtt['TargetDate'] = $TransactionData['Date'];
            $CreditAtt['TargetMony'] = $TransactionData['Mony'];
            $CreditAtt['CreditMod'] = $TransactionData['CreditMod'];
            $CreditAtt['Note'] = $TransactionData['Note'];
            $CreditAtt['InvoiceNo'] = $TransactionData['InvoiceNo'];
            $UserAtt['UserName'] = $TransactionData['UserName'];
            $UserAtt['Confirmer'] = Auth::id();
            $MyPeriodicalCredit = new periodicCreditClass();
            return $MyPeriodicalCredit->AddCreditToPeriodical($CreditAtt, $UserAtt);
        }
        return true;
    }

    public function UserPayWithTashim($TRACENO, $RefNum, $Gateway)
    {
        $WaletSrc = Session::get('Walets');
        if (is_numeric($Gateway)) { // use user Credit
            $this->RefrenceID = 0;
        } else { // use from bank gateway

            $this->AddToBuyer($TRACENO, $RefNum, $Gateway);
        }

        if ($WaletSrc == null) {
            $WaletSrc = [];
        } else {
            try {
                $WaletSrc = json_decode($WaletSrc);
            } catch (Throwable $e) {
                // $WaletSrc = [];
            }
        }
        $myTashim = new TashimClass();
        $Periodical = new periodicCreditClass();
        $validPriodical = $Periodical->IsValidWalets($this->RequestUser, $WaletSrc);
        if (!$validPriodical) {
            return 'موجودی اعتبار دوره ای کافی نیست!';
        }
        $WaletSrc = $myTashim->WaletAgregator($WaletSrc);
        $TashimAgregator = $myTashim->TashimAgregator($WaletSrc);
        $Periodical = new periodicCreditClass();
        foreach ($TashimAgregator as $WaletSrcItem) {
            $SelerProductAdd = [
                'UserName' => $WaletSrcItem['TargteUserID'],
                'Mony' => $WaletSrcItem['Amount'],
                'Type' => 89,
                'Date' => now(),
                'Note' => 'بابت فروش شماره : ' . $RefNum . ' ' . $WaletSrcItem['Note'],
                'TransferBy' => 'system',
                'CreditMod' => $WaletSrcItem['CreditMod'],
                'ConfirmBy' => 'system',
                'InvoiceNo' => $this->product_orders,
                'GateWay' => '',
                'Confirmdate' => now(),
                'branch' => 1,
                'ReferenceId' => $this->RefrenceID
            ];

            /**
             * Cange Transaction before save based on Tashim
             */
            $SelerProductAdd = $this->Tasim_extar_pre_save_modify($SelerProductAdd, $WaletSrcItem);
            $this->PeriodicalCreditAdd($SelerProductAdd);
            UserCredit::create($SelerProductAdd);
        }

        $this->ConfirmOrder();
        $this->DecriseFromStore();
        return true;
    }

    public function UserPay($TRACENO, $RefNum, $Gateway)
    {
        if (myappenv::tashim == 'main') {
            return $this->UserPayWithTashim($TRACENO, $RefNum, $Gateway);
        }
        if (is_numeric($Gateway)) { // use user Credit
            $this->RefrenceID = 0;
        } else { // use from bank gateway

            $this->AddToBuyer($TRACENO, $RefNum, $Gateway);
        }
        $this->DecriseFromBuyer();
        if (myappenv::Lic['MultiBranch']) {
            $this->AddToSellers();
        } else {
            $this->AddToDaramad();
        }
        $this->ConfirmOrder();
        $this->AddToTax();
        $this->DecriseFromStore();
        return true;
    }
    private function AddToTax()
    {
        if ($this->TotallTax == 0) {
            return true;
        }
        $TransactionData = [
            'UserName' => $this->TaxHolder,
            'Mony' => $this->TotallTax,
            'Type' => 88,
            'Date' => now(),
            'TransferBy' => 'system',
            'CreditMod' => myappenv::CachCredit,
            'ConfirmBy' => 'system',
            'InvoiceNo' => $this->product_orders,
            'Confirmdate' => now(),
            'note' => '',
            'ReferenceId' => $this->RefrenceID,
            'branch' => 0
        ];
        UserCredit::create($TransactionData);
        return true;
    }
    private function DecriseFromStore()
    {
        $OrderItems = product_order_items::all()->where('order_id', $this->product_orders);
        foreach ($OrderItems as $OrderItemTarget) {
            $Decrement = $OrderItemTarget->product_qty;
            $ProductId = $OrderItemTarget->product_id;
            $ProductInWarehouseID = $OrderItemTarget->pw_id;
            $TargetBranch = $OrderItemTarget->branch;
            if ($ProductInWarehouseID == null) { //Temp condition 13333
                if ($TargetBranch == null) { //If not set Branch 
                    warehouse_goods::where('GoodID', $ProductId)->where('OnSale', 1)->decrement('Remian', $Decrement);
                } else {
                    warehouse_goods::where('GoodID', $ProductId)->where('OnSale', 1)->decrement('Remian', $Decrement);
                }
            } else {
                /**
                 * this code just need and Temp condition 13333 should be delete
                 */
                warehouse_goods::where('id', $ProductInWarehouseID)->decrement('Remian', $Decrement);
                $WG_AfterDecrese = warehouse_goods::where('id', $ProductInWarehouseID)->first();
                $TargetGood = goods::where('id', $ProductId)->first();
                if ($TargetGood->Virtual == 2) { // The Product is Special Account 
                    $SepecialAccount = json_decode($WG_AfterDecrese->extra);
                    $type = $SepecialAccount->type;
                    $Days = $SepecialAccount->Days;
                    $TargetRole = $SepecialAccount->TargetRole;
                    if ($type == 'SpecialAccount') {
                        $CourntExtraNote = Auth::user()->extranote;
                        $ApplayTime = date('y-m-d H:i:s');
                        $ExpireDate = date('Y-m-d', strtotime("+$Days days"));
                        $ExtraNote = [
                            'Type' => $type,
                            'ApplayTime' => $ApplayTime,
                            'ExpireDate' => $ExpireDate
                        ];
                        $ExtraNote = json_encode($ExtraNote);
                        $UserUpdateData = [
                            'Role' => $TargetRole,
                            'extranote' => $ExtraNote
                        ];

                        UserInfo::where('UserName', Auth::id())->update($UserUpdateData);
                    }
                }
            }
        }
        return true;
    }
    public function get_order_price()
    {
        if (myappenv::tashim == 'main') {
            $MyTashim = new TashimClass;
            $Mony = $MyTashim->SumOfBuyWalet(myappenv::CachCredit, 'buyer');
        } else {
            $Mony = $this->TotallTax + $this->TotallMony + $this->shipping;
        }
        return $Mony;
    }

    private function AddToBuyer($TRACENO, $RefNum, $Gateway)
    {

        $Mony = Session::get('price');


        if ($Gateway == 'CDP') { //casheir method
            if ($Mony < 0) {
                $Mony *= -1;
            }
            $TransactionData = [  //Decres from casheir
                'UserName' => Auth::id(),
                'Mony' => -1 * $Mony,
                'Type' => myappenv::casheirCredittype, // chsheir Method
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
            $TransactionData = [ // increase to customer
                'UserName' => $this->RequestUser,
                'Mony' => $Mony,
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
                'ReferenceId' => $this->RefrenceID,
                'branch' => 0
            ];
            if ($Mony != 0) {
                UserCredit::create($TransactionData);
            }

            $MyProduct = new product();
            $CurentDate = date('Y-m-d H:i:s');
            $Note = 'ثبت صورت حساب توسط صندوقدار';
            $InputArr = ['UserREport' => Auth::user()->Name . '' . Auth::user()->Family, 'Date' => $CurentDate, 'note' => $Note];
            $MyProduct->AddReport($RefNum, $InputArr);
            return true;
        } else {
            $TransactionData = [
                'UserName' => $this->RequestUser,
                'Mony' => $Mony,
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
                'Note' => Session::get('PayNote') ?? '',
                'branch' => 0
            ];
            $insertResult = UserCredit::create($TransactionData);
            $this->RefrenceID = $insertResult->id;
            UserCredit::where('ID', $this->RefrenceID)->update(['ReferenceId' => $this->RefrenceID]);
            return true;
        }
    }

    private function DecriseFromBuyer()
    {
        $Mony = $this->TotallTax + $this->TotallMony;
        $InvoiceNo = $this->product_orders;
        $TransactionData = [
            'UserName' => $this->RequestUser,
            'Mony' => -1 * $Mony,
            'Type' => 88,
            'Date' => now(),
            'TransferBy' => 'system',
            'CreditMod' => myappenv::CachCredit,
            'ConfirmBy' => 'system',
            'InvoiceNo' => $InvoiceNo,
            'Confirmdate' => now(),
            'ReferenceId' => $this->RefrenceID,
            'Note' => 'کسر هزینه صورت حساب شماره : ' . $InvoiceNo,
            'branch' => 0
        ];
        $Result = UserCredit::create($TransactionData);
        if ($this->RefrenceID == 0) {
            $this->RefrenceID = $Result->id;
            UserCredit::where('ID', $this->RefrenceID)->update(['ReferenceId' => $this->RefrenceID]);
        }
        $ProductOrderSRC = product_order::where('id', $this->product_orders)->first();
        if (isset($ProductOrderSRC->shipping_total)) {
            $DeleverPrice = $ProductOrderSRC->shipping_total;
        } else {
            $DeleverPrice = 0;
        }
        if ($DeleverPrice != 0) { // صورت حساب هزینه حمل و نقل دارد
            $TransactionData = [
                'UserName' => $this->RequestUser,
                'Mony' => -1 * $DeleverPrice,
                'Type' => 88,
                'Date' => now(),
                'TransferBy' => 'system',
                'CreditMod' => myappenv::CachCredit,
                'ConfirmBy' => 'system',
                'InvoiceNo' => $this->product_orders,
                'Confirmdate' => now(),
                'ReferenceId' => $this->RefrenceID,
                'Note' => 'کسر هزینه حمل و نقل' . ' بابت صورت حساب شماره : ' . $this->product_orders,
                'branch' => 0
            ];
            $Result = UserCredit::create($TransactionData);
            $TransactionData = [
                'UserName' => 'delever',
                'Mony' => $DeleverPrice,
                'Type' => 88,
                'Date' => now(),
                'TransferBy' => 'system',
                'CreditMod' => myappenv::CachCredit,
                'ConfirmBy' => 'system',
                'InvoiceNo' => $this->product_orders,
                'Confirmdate' => now(),
                'ReferenceId' => $this->RefrenceID,
                'Note' => 'هزینه حمل و نقل بابت صورت حساب شماره : ' . $this->product_orders,
                'branch' => 0
            ];
            $Result = UserCredit::create($TransactionData);
        }
        return true;
    }



    public function ConfirmOrder($DeviceContract = null)
    {
        //$DeviceContract is for Estelam Price
        if ($DeviceContract == null) {
            product_order::where('id', $this->product_orders)->update(['status' => 1]);
        } else {
            product_order::where('id', $this->product_orders)->update(['status' => 1, 'DeviceContract' => $DeviceContract]);
        }
        branchs_order::where('order_id', $this->product_orders)->update(['order_status' => 1]);
        if (myappenv::Lic['marketplace']) {
            $Branches = branchs_order::all()->where('order_id', $this->product_orders);
            $MySMS = new SmsCenter();
            foreach ($Branches as $TargetBranch) {
                $TargetBranchID = $TargetBranch->branch;
                $ResNum = $TargetBranch->order_id;
                $BranchSRC = branches::where('id', $TargetBranchID)->first();
                $BranchPhone = $BranchSRC->Phone;
                if (str_starts_with($BranchPhone, '09')) { //check if mobile phone to send sms
                    $SellerText = myappenv::CenterName . ' ';
                    $SellerText .= 'سلام مدیر سفارش ' . $ResNum . ' در سامانه ثبت شد!';
                    try {
                        $MySMS->OndemandSMS($SellerText, $BranchPhone, 'tnks', $BranchPhone);
                    } catch (Throwable $e) {
                    }
                }
            }
        }
        return true;
    }
    private function AddToDaramad()
    {
        $TransactionData = [
            'UserName' => $this->StackHolder,
            'Mony' => $this->Benefit,
            'Type' => 88,
            'Date' => now(),
            'TransferBy' => 'system',
            'CreditMod' => myappenv::CachCredit,
            'ConfirmBy' => 'system',
            'InvoiceNo' => $this->product_orders,
            'Confirmdate' => now(),
            'ReferenceId' => $this->RefrenceID,
            'Note' => '',
            'branch' => 0
        ];
        UserCredit::create($TransactionData);
        return true;
    }
}

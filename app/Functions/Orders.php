<?php

namespace App\Functions;

use App\APIS\SmsCenter;
use App\Functions\TransferProduct;
use App\Http\Controllers\APIS\poolkhord;
use App\Http\Controllers\Credit\Tashim;
use App\Http\Controllers\setting\debuger;
use App\Http\Controllers\woocommerce\product;
use App\Http\Controllers\woocommerce\ProductClass;
use App\Models\branches;
use App\Models\branchs_order;
use App\Models\citys;
use App\Models\DeviceContract;
use App\Models\DeviceItemInternal;
use App\Models\goods;
use App\Models\locations;
use App\Models\product_order;
use App\Models\product_order_items;
use App\Models\provinces;
use App\Models\report_detial;
use App\Models\transactionstemp;
use App\Models\UserCredit;
use App\Models\warehouse_goods;
use App\myappenv;
use App\PEC\PECMain;
use App\PEP\RSAKeyType;
use App\PEP\RSAProcessor;
use App\zarinpal\zarinpal;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Orders extends TashimClass
{
    private $TotalWight = null;
    private $TotalPrice = null;
    private $num_items_sold;
    private $total_sales_G;
    private $tax_total_G;
    private $customer_benefit_total_G;
    private $shipping_total_G;
    private $net_total_G;
    private $TotallWeight;
    private $MainDeviceOrderID;
    private $ProductOrderId;
    private $DeviceOrder = null;
    private $OrderVirtual;


    private $UserName;

    public $order_status = [
        ['id' => 0, 'name' => 'ثبت شده'],
        ['id' => 1, 'name' => 'پرداخت شده'],
        ['id' => 10, 'name' => 'در دست اقدام'],
        ['id' => 20, 'name' => 'ارسال به انبار'],
        ['id' => 30, 'name' => 'در حال آماده سازی'],
        ['id' => 40, 'name' => 'ارسال به پست'],
        ['id' => 50, 'name' => 'ارسال برای مشتری'],
        ['id' => 60, 'name' => 'تحویل شده'],
        ['id' => 70, 'name' => 'لغو توسط فروشنده'],
        ['id' => 80, 'name' => 'لغو توسط مشتری'],
        //['id' => 90, 'name' => 'لغو سفارش'],
        ['id' => 90, 'name' => 'اتمام سفارش'],
        ['id' => 100, 'name' => 'اتمام سفارش'],

    ];
    public function get_order_status_txt($target_status)
    {
        if ($target_status == 0) {
            return ' در انتظار پرداخت';
        } elseif ($target_status == 1) {
            return ' پرداخت شده';
        } elseif ($target_status == 10) {
            return ' در دست اقدام';
        } elseif ($target_status == 20) {
            return ' ارسال به انبار';
        } elseif ($target_status == 30) {
            return '  درحال بسته بندی';
        } elseif ($target_status == 40) {
            return ' ارسال به پست';
        } elseif ($target_status == 50) {
            return 'ارسال برای مشتری';
        } elseif ($target_status == 60) {
            return 'تحویل شده';
        } elseif ($target_status == 70) {
            return 'لغو توسط فروشنده';
        } elseif ($target_status == 80) {
            return 'لغو توسط مشتری';
        } elseif ($target_status == 90) {
            return 'انجام شده';

            //  return 'لغو سفارش';
        } elseif ($target_status == 100) {
            return 'انجام شده';
        }
        return ' نا مشخص';
    }
    public function __construct()
    {
        if (Session::has('customerID')) {
            $this->UserName = Session::get('customerID');
        } else {
            $this->UserName = Auth::id();
        }
    }

    public function get_order($oder_id)
    {
        $order = product_order::find($oder_id);
        return $order;
    }

    public function get_order_detail($oder_id)
    {
        $Query = "SELECT poi.*,g.NameFa,g.ImgURL from product_order_items poi inner join goods g on g.id = poi.product_id  WHERE poi.order_id  = $oder_id ";
        $OrderDetail = DB::select($Query);
        return $OrderDetail;
    }

    public function UserCashCredit($UserName = null)
    {
        if (!auth::check()) {
            return false;
        }
        if ($UserName == null) {
            $UserName = $this->UserName;
        }
        $Result = UserCredit::where('UserName', $UserName)->where('CreditMod', myappenv::CachCredit)->sum('Mony');
        return $Result;
    }
    private function GetDeviceOrder()
    {
        if ($this->DeviceOrder == null) {
            $ContractData = [
                'Owner' => $this->UserName,
                'ContractDate' => now(),
                'RentDate' => now(),
                'ExpireDate' => now(),
                'Guarantee' => 0,
                'Status' => 0,
                'Note' => '',
                'ContractType' => 10000,
            ];
            $DeviceContract = DeviceContract::create($ContractData);
            $DeviceContractId = $DeviceContract->id;
            $this->DeviceOrder = $DeviceContractId;
            return $DeviceContractId;
        } else {
            return $this->DeviceOrder;
        }
    }
    public function PayFromEstelam($ResNum)
    {
        $MyTransfer = new TransferProduct($ResNum);
        $resutl = $MyTransfer->ConfirmOrder($this->DeviceOrder);
        $price = $this->total_sales_G + $this->shipping_total_G;
        $RResult = array('Mony' => $price, 'Confirmdate' => date("Y-m-d H:i:s"), 'GateWay' => 'کیف پول');
        Session::put('price', null);
        Session::put('ResNum', null);
        $UserInfo = Auth::user();
        Session::put('basket', null);
        $MySMS = new SmsCenter();
        $CustomerText = 'سلام ' . Auth::user()->Name . ' ' . Auth::user()->Family . ' عزیز' . "\n";
        $CustomerText .= 'استعلام  شما به شماره ' . $ResNum . ' با موفقیت ثبت شد.' . "\n";
        $CustomerText .= 'با تشکر از خرید شما.' . "\n";
        $CustomerText .= myappenv::CenterName;
        $MySMS->OndemandSMS($CustomerText, Auth::user()->MobileNo, 'tnks', Auth::user()->MobileNo);
        $SellerText = 'سلام مدیر استعلام ' . $ResNum . 'با مبلغ ' . number_format($price) . ' در سامانه ثبت شد!';
        if (myappenv::MainOwner == 'shafatel' || myappenv::MainOwner == 'Carpetour') {
            $MySMS->OndemandSMS($SellerText, '09126543802', 'tnks', '09126543802');
        } else {
            // $MySMS->OndemandSMS($SellerText, '09123345580', 'tnks', '09123345580');
        }
        $this->AddLog($ResNum);
        $MySMS->OndemandSMS($SellerText, '09123936105', 'tnks', '09123936105');
        if (myappenv::MainOwner == 'kookbaz') {
            $MySMS->OndemandSMS($SellerText, '09125833245', 'tnks', '09125833245');
            $MySMS->OndemandSMS($SellerText, '09192228284', 'tnks', '09192228284');
            $MySMS->OndemandSMS($SellerText, '09101812802', 'tnks', '09101812802');
        }
        $Myorder = new Orders();
        $product_order = product_order::where('id', $ResNum)->first();
        return view('Layouts.Theme1.FinalOFEstelam', ['ResNum' => $ResNum, 'Result' => $RResult, 'UserInfo' => $UserInfo, 'Myorder' => $Myorder, 'product_order' => $product_order]);
    }
    private function AddLog($OrderID)
    {
        $Products = product_order_items::where('order_id', $OrderID)->get();
        foreach ($Products as $ProductItem) {
            $ProductId = $ProductItem->product_id;
            $pw_id = $ProductItem->pw_id;
            $UserID = $this->UserName;
            $SaveData = [
                'ProductID' => $ProductId,
                'WGID' => $pw_id,
                'UserID' => $UserID,
                'ReportType' => 2,
            ];
            report_detial::create($SaveData);
        }
        return true;
    }

    public function Get_order_Cash_to_pay($UserCeridet = myappenv::CachCredit)
    {
        $MyTashim = new TashimClass();
        $MyOrder = json_decode(Session::get('basket'));
        $OrderTashim = json_decode(Session::get('Tashim')) ?? [];
        $CashCredit = 0;
        $MyProduct = new product();
        foreach ($MyOrder as $MyOrderItem) {
            $HasTashim = false;
            foreach ($OrderTashim as $OrderTashimItem) {
                if ($OrderTashimItem->ProductId == $MyOrderItem[0]) {
                    $TashimId = $OrderTashimItem->Tashim;
                    $HasTashim = true;
                }
            }
            if (myappenv::tashim == 'main') {
                if (!$HasTashim || $TashimId == 0 || $TashimId == null) {
                    $HasTashim = true;
                    $TashimId = CacheData::GetSetting('DefultTashim');
                }
            }
            $ProductSrc = warehouse_goods::where('id', $MyOrderItem[2])->first();

            $ProductMainSrc = goods::where('id', $ProductSrc->GoodID)->first();
            $Qty = $MyOrderItem[1];
            if ($ProductSrc->PricePlan == null) {
                $Price = $ProductSrc->Price;
            } else {
                $Price = $MyProduct->GetTargetPriceFromPricePlanJson($ProductSrc->PricePlan, $Qty);
            }

            $ProductPrice = $Price * $Qty;
            if ($HasTashim) {
                $ProductPriceAttr = [
                    'ProductPrice' => $Price,
                    'tax_status' => $ProductMainSrc->tax_status,
                ];
                $CashArr = $MyTashim->get_sale_price_walet_with_tashim($ProductPriceAttr, $TashimId, $UserCeridet);
                $CashCredit += $CashArr['PriceWithTax'] * $Qty;
            } else {
                $CashCredit_tmp = $ProductPrice * -1;
                $CashCredit += ProductClass::GetTargetPrice($CashCredit_tmp, $ProductMainSrc->tax_status);
            }
        }
        return ($CashCredit * -1);
    }

    public function update_basket($ProductOrderArr, $QtyArr)
    {
        $MyOrder = json_decode(Session::get('basket'));
        foreach ($ProductOrderArr as $ProductOrderItem => $value) {
            $product_qty = $QtyArr[$ProductOrderItem];
            foreach ($MyOrder as $Orderindex => $Basketvalue) {
                if ($Basketvalue[0] == $value) {
                    $MyOrder[$Orderindex][1] = $product_qty;
                }
            }
        }
        $MyOrder = json_encode($MyOrder);
        Session::put('basket', $MyOrder);
        return true;
    }


    public function payFromPasargad()
    {
        $price = $this->Get_order_Cash_to_pay() + $this->shipping_total_G; // Price Rial
        $ResNum = $this->ProductOrderId; // Invoice Number
        Session::put('price', $price);
        Session::put('ResNum', $ResNum);
        $Certificate = myappenv::PEPPrivate;
        $processor = new RSAProcessor($Certificate, RSAKeyType::XMLString);

        $merchantCode = myappenv::PEPMerchantCode; // كد پذيرنده
        $terminalCode = myappenv::PEPTerminalCode; // كد ترمينال
        $amount = $price; // مبلغ فاكتور
        $redirectAddress = route('peppay');
        $invoiceNumber = $ResNum; //شماره فاكتور

        $redirectAddress = route('checkout', ['pay' => 'pep', 'ref' => $invoiceNumber]);
        if (myappenv::SiteTheme == 'Theme1') {
            $redirectAddress = route('ConfirmPayment', ['pay' => 'pep', 'ref' => $invoiceNumber]);
        }
        $timeStamp = date("Y/m/d H:i:s");
        $invoiceDate = date("Y/m/d H:i:s"); //تاريخ فاكتور
        $action = "1003"; // 1003 : براي درخواست خريد
        $Mobile = Auth::user()->MobileNo;
        $data = "#" . $merchantCode . "#" . $terminalCode . "#" . $invoiceNumber . "#" . $invoiceDate . "#" . $amount . "#" . $redirectAddress . "#" . $action . "#" . $timeStamp . "#";
        $data = sha1($data, true);
        $data = $processor->sign($data); // امضاي ديجيتال
        $result = base64_encode($data); // base64_encode
        $SendData = [
            'invoiceNumber' => $invoiceNumber,
            'invoiceDate' => $invoiceDate,
            'amount' => $amount,
            'terminalCode' => $terminalCode,
            'merchantCode' => $merchantCode,
            'redirectAddress' => $redirectAddress,
            'timeStamp' => $timeStamp,
            'mobile' => $Mobile,
            'action' => $action,
            'sign' => $result,
        ];
        echo "<form id='peppeyment' action='https://pep.shaparak.ir/gateway.aspx' method='post'>
        <input  type='text' name='invoiceNumber' value='$invoiceNumber' /><br />
        <input  type='text' name='invoiceDate' value='$invoiceDate' /><br />
        <input  type='text' name='amount' value='$amount' /><br />
        <input  type='text' name='terminalCode' value='$terminalCode' /><br />
        <input  type='text' name='merchantCode' value='$merchantCode' /><br />
        <input  type='text' name='redirectAddress' value='$redirectAddress' /><br />
        <input  type='text' name='timeStamp' value='$timeStamp' /><br />
        <input  name='mobile' value='$Mobile' /><br />
        <input  type='text' name='action' value='$action' /><br />
        <input  type='text' name='sign' value='$result' /><br />
        </form><script>document.forms['peppeyment'].submit()</script>";
    }

    public function payFromPOL()
    {
        $price = $this->Get_order_Cash_to_pay() + $this->shipping_total_G; // Price Rial
        Session::put('price', $price);
        $ResNum = Session::get('ResNum');
        $pool = new poolkhord;
        return $pool->pay_ipg($price, 'خرید از فروشگاه شماره: ' . $ResNum, 1);
    }
    private function pay_from_wallet()
    {
        $price = Session::get('price');
        $ResNum = Session::get('ResNum');
        $MyTransfer = new TransferProduct($ResNum);
        $resutl = $MyTransfer->UserPay(null, null, myappenv::CachCredit);
        if ($resutl) {
            $RResult = array('Mony' => Session::get('price'), 'Confirmdate' => date("Y-m-d H:i:s"), 'GateWay' => 'کیف پول');
            Session::forget('price');
            Session::forget('ResNum');
            session::forget('DeleverMony');
            $UserInfo = Auth::user();
            Session::forget('basket');
            $MySMS = new SmsCenter();
            $CustomerText = 'سلام ' . Auth::user()->Name . ' ' . Auth::user()->Family . ' عزیز' . "\n";
            $CustomerText .= 'سفارش شما به شماره ' . $ResNum . ' با موفقیت ثبت شد.' . "\n";
            $CustomerText .= 'با تشکر از خرید شما.' . "\n";
            $CustomerText .= myappenv::CenterName;

            $MySMS->OndemandSMS($CustomerText, Auth::user()->MobileNo, 'tnks', Auth::user()->MobileNo);
            $SellerText = 'سلام  مدیر سفارش ' . $ResNum . 'با مبلغ ' . number_format($price) . ' در سامانه ثبت شد!';
            $this->AddLog($ResNum);
            $MySMS->OndemandSMS($SellerText, '09123936105', 'tnks', '09123936105');
            $RResult = array('Mony' => $price, 'Confirmdate' => date("Y-m-d H:i:s"), 'GateWay' => 'ایران کیش');
            $Myorder = new Orders();
            $product_order = product_order::where('id', $ResNum)->first();
            if (Session::has('NormalInvoice')) {
                return view('Layouts.Theme1.FinalOfDirectPay');
            } else {
                return view('Layouts.Theme1.FinalOFOrder', ['ResNum' => $ResNum, 'RResult' => $RResult, 'Myorder' => $Myorder, 'product_order' => $product_order]);
            }
        } else {
            return abort('404', 'در انجام تراکنش مشکلی پیش آمده لطفا با فروشگاه تماس بگیرید 14693  ');
        }
    }
    public function payFromSEP()
    {
        $price = $this->Get_order_Cash_to_pay() + $this->shipping_total_G; // Price Rial
        $walet_mony = UserCredit::where('UserName', Auth::id())->where('CreditMod', myappenv::CachCredit)->whereNotNull('ConfirmBy')->whereNull('ZeroRefrenceID')->sum('Mony');
        $price = $price - $walet_mony;
        switch ($price) {
            case $price <= 0:
                $price = 0;
                Session::put('price', $price);
                Session::save();
                $Amount = $price;
                $RefNum = Session::get('ResNum');
                $targetid = rand(10, 1000000);
                $Paydata = [
                    'id' => $targetid,
                    'refnumber' => $RefNum,
                    'gateway' => 'sep',
                    'Amount' => $Amount
                ];
                transactionstemp::create($Paydata);
                return redirect()->route('ConfirmPayment', ['pay' => 'sep', 'ref' => $targetid]);
            case $price < 10000:
                $price = 20000;
                break;
        }
        Session::put('price', $price);
        $ResNum = Session::get('ResNum');
        //Session::put('ResNum', $this->ResNum);
        $MerchantCode = "12155575";
        $MerchantCode = "15360733";
        $RedirectURL = route('seppay');
        //$RedirectURL = str_replace("http", "https", $RedirectURL);
        $url = 'https://sep.shaparak.ir/onlinepg/onlinepg'; // آدرس API مقصد

        $data = [
            "action" => "token",
            "TerminalId" => "15360733",
            "Amount" => $price,
            "ResNum" => $ResNum,
            "RedirectUrl" => $RedirectURL,
            "CellNumber" => Auth::user()->MobileNo,
        ];
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
            ],
            CURLOPT_POSTFIELDS => json_encode($data),
        ]);

        $response = curl_exec($ch);
        $response = json_decode($response,true);
        $token = $response['token'];
       // dd($response['token']);

        echo "<form id='samanpeyment' action='https://sep.shaparak.ir/OnlinePG/OnlinePG' method='post'>  
        <input type='hidden' name='Amount' value='{$price}' />      
        <input type='hidden' name='ResNum' value='{$ResNum}'>  
        <input type='hidden' name='RedirectURL' value='{$RedirectURL}'/>
        <input type='hidden' name='Token' value='{$token}'/>
        <button type='submit' >submit</button>
        </form> <script>document.forms['samanpeyment'].submit()</script>";
    }
    public function payFromZAR()
    {
        $price = $this->Get_order_Cash_to_pay() + $this->shipping_total_G; // Price Rial
        $ResNum = $this->ProductOrderId; // Invoice Number
        Session::put('price', $price);
        Session::save('price', $price);
        Session::save('ResNum', $ResNum);

        $redirectAddress = route('ConfirmPayment', ['pay' => 'ZAR', 'ref' => $ResNum]);
        $DBData = [
            'refnumber' => $ResNum,
            'Amount' => $price,
            'gateway' => 'ZAR'
        ];
        transactionstemp::create($DBData);
        $zarinpal = new zarinpal;
        return $zarinpal->payment($price, 'خرید کالا', Auth::user()->MobileNo, $ResNum, $redirectAddress);
        $Certificate = myappenv::PEPPrivate;
        $processor = '';

        $merchantCode = myappenv::PEPMerchantCode; // كد پذيرنده
        $terminalCode = myappenv::PEPTerminalCode; // كد ترمينال
        $amount = $price; // مبلغ فاكتور
        $redirectAddress = route('peppay');
        $invoiceNumber = $ResNum; //شماره فاكتور
        $redirectAddress = route('checkout', ['pay' => 'pep', 'ref' => $invoiceNumber]);
        if (myappenv::SiteTheme == 'Theme1') {
            $redirectAddress = route('ConfirmPayment', ['pay' => 'pep', 'ref' => $invoiceNumber]);
        }
        $timeStamp = date("Y/m/d H:i:s");
        $invoiceDate = date("Y/m/d H:i:s"); //تاريخ فاكتور
        $action = "1003"; // 1003 : براي درخواست خريد
        $Mobile = Auth::user()->MobileNo;
        $data = "#" . $merchantCode . "#" . $terminalCode . "#" . $invoiceNumber . "#" . $invoiceDate . "#" . $amount . "#" . $redirectAddress . "#" . $action . "#" . $timeStamp . "#";
        $data = sha1($data, true);
        $data = ''; // امضاي ديجيتال
        $result = base64_encode($data); // base64_encode
        $SendData = [
            'invoiceNumber' => $invoiceNumber,
            'invoiceDate' => $invoiceDate,
            'amount' => $amount,
            'terminalCode' => $terminalCode,
            'merchantCode' => $merchantCode,
            'redirectAddress' => $redirectAddress,
            'timeStamp' => $timeStamp,
            'mobile' => $Mobile,
            'action' => $action,
            'sign' => $result,
        ];
        echo "<form id='peppeyment' action='https://pep.shaparak.ir/gateway.aspx' method='post'>
        <input  type='text' name='invoiceNumber' value='$invoiceNumber' /><br />
        <input  type='text' name='invoiceDate' value='$invoiceDate' /><br />
        <input  type='text' name='amount' value='$amount' /><br />
        <input  type='text' name='terminalCode' value='$terminalCode' /><br />
        <input  type='text' name='merchantCode' value='$merchantCode' /><br />
        <input  type='text' name='redirectAddress' value='$redirectAddress' /><br />
        <input  type='text' name='timeStamp' value='$timeStamp' /><br />
        <input  name='mobile' value='$Mobile' /><br />
        <input  type='text' name='action' value='$action' /><br />
        <input  type='text' name='sign' value='$result' /><br />
        </form><script>document.forms['peppeyment'].submit()</script>";
    }
    public function payFromPNA()
    {
        $price = $this->Get_order_Cash_to_pay() + $this->shipping_total_G;         // Price Rial
        //  $price = 20000;
        //$ResNum = time();             // Invoice Number
        //Session::put('price', $price);
        // Session::put('ResNum', $ResNum);
        $ResNum = Session::get('ResNum');
        Session::put('price', $price);

        $DBData = [
            'strid' => $ResNum,
            'Amount' => $price,
            'gateway' => 'PNA'
        ];
        transactionstemp::create($DBData);



        $Order_id = $ResNum;
        $CallbackURL = route('pnaReciver');
        $Email = Auth::user()->Email;
        $Mobile = Auth::user()->MobileNo;
        $Username = '011578717';
        $Password = '9915758808';
        $Terminal = '11584036';

        $curl = curl_init();
        curl_setopt_array(
            $curl,
            array(
                CURLOPT_URL => 'https://pna.shaparak.ir/ref-payment2/RestServices/mts/generateTokenWithNoSign/',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => '{
      "WSContext":{"UserId":"' . $Username . '","Password":"' . $Password . '"},
      "TransType":"EN_GOODS",
      "ReserveNum":"' . $ResNum . '",
      "TerminalId":"' . $Terminal . '",
      "Amount":"' . $price . '",
      "GoodsReferenceID":"' . $Order_id . '",
      "MobileNo":"' . $Mobile . '",
      "Email":"' . $Email . '",
      "RedirectUrl":"' . $CallbackURL . '"
  }',
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json',
                ),
            )
        );

        $Login = curl_exec($curl);
        $Login = json_decode($Login);

        curl_close($curl);
        $Result = !empty($Login->Result) ? $Login->Result : 'erMts_UnknownError';

        if ($Result != 'erSucceed') {
            echo 'پرداخت با خطا مواجه شد!';
            return false;
        }

        echo '<form id="pnaform" method="post" action="https://pna.shaparak.ir/_ipgw_/payment/"  >
            <input type="hidden" id="token" name="token" value="' . $Login->Token . '" />
            <input type="hidden" id="TerminalId" name="TerminalId" value="' . $Terminal . '" />
            <input type="hidden" id="language" name="language" value="fa">
            <button type="submit" name="submit" value="startcall"
            class="btn btn-success px-4 text-white rad25  ml-3 "> انتفال به درگاه بانکی</button>
          </form><script>document.forms["pnaform"].submit()</script>';
        return true;
    }
    public function payFromIKC()
    {
        $price = $this->Get_order_Cash_to_pay() + $this->shipping_total_G; // Price Rial
        if ($price == 0) {
            $price = 100000;
        }

        Session::put('price', $price);
        Session::put('ResNum', $this->ProductOrderId);
        return redirect()->route('ikc');
    }
    public function payFromPEC()
    {
        $price = $this->Get_order_Cash_to_pay() + $this->shipping_total_G; // Price Rial
        $walet_mony = UserCredit::where('UserName', Auth::id())->where('CreditMod', myappenv::CachCredit)->whereNotNull('ConfirmBy')->whereNull('ZeroRefrenceID')->sum('Mony');
        $price = $price - $walet_mony;
        switch ($price) {
            case $price <= 0:
                $price = 0;
                Session::put('price', $price);
                Session::save();
                $Amount = $price;
                $RefNum = Session::get('ResNum');
                $targetid = rand(10, 1000000);
                $Paydata = [
                    'id' => $targetid,
                    'refnumber' => $RefNum,
                    'gateway' => 'sep',
                    'Amount' => $Amount
                ];
                transactionstemp::create($Paydata);
                return redirect()->route('ConfirmPayment', ['pay' => 'sep', 'ref' => $targetid]);
            case $price < 10000:
                $price = 20000;
                break;
        }
        Session::put('price', $price);
        $ResNum = Session::get('ResNum');
        $PEC = new PECMain;
        return $PEC->request($price);
    }
    public function PayFromIPG()
    {
        if (myappenv::Bank == 'pasargad') {
            return $this->payFromPasargad();
        }
        if (myappenv::Bank == 'pol') {
            return $this->payFromPOL();
        }
        if (myappenv::Bank == 'IKC') {
            return $this->payFromIKC();
        }
        if (myappenv::Bank == 'sep') {
            return $this->payFromSEP();
        }
        if (myappenv::Bank == 'PEC') {
            return $this->payFromPEC();
        }
        if (myappenv::Bank == 'PNA') {
            return $this->payFromPNA();
        }
        if (myappenv::Bank == 'ZAR') {
            return $this->payFromZAR();
        }
    }
    public function finalyzeProductOrder()
    {
        Session::put('casherprice', $this->total_sales_G);
        $OrderPostData = [
            'num_items_sold' => $this->num_items_sold,
            'total_sales' => $this->total_sales_G,
            'tax_total' => $this->tax_total_G,
            'customer_benefit_total' => $this->customer_benefit_total_G,
            'shipping_total' => $this->shipping_total_G ?? 0,
            'net_total' => $this->net_total_G,
            'TotallWeight' => $this->TotallWeight,
            'DeviceContract' => $this->MainDeviceOrderID,
        ];
        return product_order::where('id', $this->ProductOrderId)->update($OrderPostData);
    }
    public function GetProductBranchV1($ProductId, $withBranchOwner)
    {

        $Query = "SELECT b.id as BrachID, b.UserName as UserName from branches as b INNER JOIN stores as s on b.id = s.branch INNER JOIN warehouses as w on w.StoreID = s.id INNER JOIN warehouse_goods wg on wg.WarehouseID = w.id WHERE wg.GoodID = $ProductId";
        $Result = DB::select($Query);
        if ($withBranchOwner == true) {
            return $Result;
        } else {
            foreach ($Result as $ResultItem) {
                return $ResultItem->BrachID;
            }
        }
    }
    public function GetProductBranch($ProductId, $withBranchOwner)
    {
        $Query = "SELECT b.id as BrachID, b.UserName as UserName from branches as b INNER JOIN stores as s on b.id = s.branch INNER JOIN warehouses as w on w.StoreID = s.id INNER JOIN warehouse_goods wg on wg.WarehouseID = w.id WHERE wg.GoodID = $ProductId";
        $Result = DB::select($Query);
        if ($withBranchOwner == true) {
            return $Result;
        } else {
            foreach ($Result as $ResultItem) {
                return $ResultItem->BrachID;
            }
        }
    }
    public function get_order_item_tashim($ProductId)
    {
        if (!Session::has('Tashim') || Session::get('Tashim') == null || Session::get('Tashim') == "[]") {
            // if not hashim session exist
            if (myappenv::tashim == 'main') {
                return CacheData::GetSetting('DefultTashim');
            } else {
                return null;
            }
        }

        $ProductTashimArr = json_decode(Session::get('Tashim'));

        foreach ($ProductTashimArr as $ProductTashimItem) {
            if ($ProductId == $ProductTashimItem->ProductId) {
                return $ProductTashimItem->Tashim;
            }
        }
        return null;
    }
    public static function getshiping()
    {
        if (session::has('DeleverMony')) {
            return session::get('DeleverMony');
        } else {
            return 0;
        }
    }
    public function SetShepping($ShipingType)
    {
        if ($ShipingType == 'post') {
            $shipping_amount = session::get('DeleverMony');
        } else {
            $shipping_amount = 0;
        }
        $this->shipping_total_G = $shipping_amount;
    }
    public function AddOrderItems($ProductOrderId)
    {

        Session::forget('Walets');
        $num_items_sold = 0;
        $total_sales_G = 0;
        $tax_total_G = 0;
        $customer_benefit_total_G = 0;
        $SubItem = 0;
        $net_total_G = 0;
        $TotallWeight = 0;
        $topay = 0;
        $tax_total = 0;
        $ProductOrderArr = json_decode(Session::get('basket'));
        $branches = array();
        foreach ($ProductOrderArr as $ProductOrderItem) {
            $num_items_sold++;
            $product_id = $ProductOrderItem[0];
            $product_qty = $ProductOrderItem[1];
            $ProductWarehouseID = $ProductOrderItem[2];
            $ProductTarget = warehouse_goods::where('id', $ProductWarehouseID)->where('OnSale', 1)->first();
            $ProductSourceTarget = goods::where('id', $product_id)->first();
            $ItemWeight = $ProductSourceTarget->weight * $product_qty;
            $TotallWeight += $ItemWeight;
            if ($ProductTarget == null) {
                return abort('404');
            }
            if ($ProductTarget->BasePrice == 0) {
                $unit_Price = $ProductTarget->Price; // without sale
            } else {
                $unit_Price = $ProductTarget->BasePrice;
            }
            //$unit_Price = ProductClass::GetTargetPrice($unit_Price, $ProductSourceTarget->tax_status);
            if (myappenv::Lic['MultiBranch']) {
                $TargetBranch = $this->GetProductBranchV1($product_id, false);
                if (!in_array($TargetBranch, $branches)) {
                    array_push($branches, $TargetBranch);
                    $BranchData = [
                        'branch' => $TargetBranch,
                        'order_status' => 0,
                        'order_id' => $ProductOrderId,
                    ];
                    branchs_order::create($BranchData);
                }
            } else {
                $TargetBranch = myappenv::Branch;
                if (!in_array($TargetBranch, $branches)) {
                    array_push($branches, $TargetBranch);
                    $BranchData = [
                        'branch' => $TargetBranch,
                        'order_status' => 0,
                        'order_id' => $ProductOrderId,
                    ];
                    branchs_order::create($BranchData);
                }
            }

            if (myappenv::tashim == 'main') {
                $TashimId = $this->get_order_item_tashim($product_id);
                if ($TashimId == null) {
                    $TashimId = CacheData::GetSetting('DefultTashim');
                }
                $ProductPriceAttr = [
                    'ProductPrice' => $ProductTarget->Price,
                    'tax_status' => $ProductSourceTarget->tax_status,
                ];
                $ProductPriceArr = $this->get_sale_price_with_tashim($ProductPriceAttr, $TashimId);
                $ProductPrice = abs($ProductPriceArr['PriceWithTax']) - abs($ProductPriceArr['TaxPrice']);
                $total_sales = $ProductPrice * $product_qty;
                $With_tax = $ProductPriceArr['PriceWithTax'] * $product_qty;
                $tax_total = $ProductPriceArr['TaxPrice'] * $product_qty;
                $total_sales_G += abs($total_sales);
                $tax_total_G += abs($tax_total);
                $topay += abs($total_sales);
                $customer_benefit_total = ($unit_Price * $product_qty) - ($ProductPrice * $product_qty);
                $customer_benefit_total_G += $customer_benefit_total;
            } else {
                $ProductPrice = $ProductTarget->Price;
                $total_sales = $this->get_totall_price($ProductTarget->PricePlan, $ProductTarget->MinPrice, $ProductTarget->Price, $product_qty);
                $With_tax = ProductClass::GetTargetPrice($total_sales, $ProductSourceTarget->tax_status);
                $tax_total = $With_tax - $total_sales; //todo fill when tax added
                $total_sales_G += abs($total_sales);
                $tax_total_G += abs($tax_total);
                $topay += abs($total_sales);
                $customer_benefit_total = ($unit_Price * $product_qty) - $total_sales;
                $customer_benefit_total_G += $customer_benefit_total;
            }

            if (!is_int((int) $product_qty)) {
                return abort('404', 'مشکل امنیتی کد : ۱۴۸۳ ');
            }
            if ($product_qty < 1) {
                return abort('404', 'مشکل امنیتی کد : ۱۴۸۴ ');
            }
            $net_total = $total_sales - ($ProductTarget->BuyPrice * $product_qty);
            $net_total_G += $net_total;
            $MainDeviceOrderID = null;
            if ($ProductTarget->MinPrice != 0) { // Estelam
                $MainDeviceOrderID = $this->GetDeviceOrder();
                $TargetBranchsrc = branches::where('id', $TargetBranch)->first();
                $DataToSave = [
                    'ContractNumber' => $MainDeviceOrderID,
                    'SubItem' => $SubItem++,
                    'Device' => $ProductWarehouseID,
                    'product_qty' => $product_qty,
                    'product_id' => $product_id,
                    'customer_id' => $this->UserName,
                    'Ownerbranch' => $TargetBranch,
                    'Owner' => $TargetBranchsrc->UserName,
                ];
                DeviceItemInternal::create($DataToSave);
            } else {
                if (!is_int((int) $product_qty)) {
                    return abort('404', 'مشکل امنیتی کد : ۱۴۸۵ ');
                }
                if ($product_qty < 1) {
                    return abort('404', 'مشکل امنیتی کد : ۱۴۸۶ ');
                }
                if (myappenv::tashim == '') {
                    $TashimId = 0;
                }
                $ProductItemData = [
                    'order_id' => $ProductOrderId,
                    'product_id' => $product_id,
                    'pw_id' => $ProductWarehouseID,
                    'product_qty' => $product_qty,
                    'Tashim' => $TashimId,
                    'customer_id' => $this->UserName,
                    'unit_Price' => $ProductTarget->Price,
                    'main_unit_price' => $ProductTarget->BasePrice,
                    'unit_sales' => $ProductPrice,
                    'total_sales' => $total_sales,
                    'tax_total' => $tax_total,
                    'customer_benefit_total' => $customer_benefit_total,
                    'shipping_amount' => $this->getshiping(),
                    'weight' => $ItemWeight,
                    'net_total' => $net_total,
                    'branch' => $TargetBranch,
                ];
                product_order_items::create($ProductItemData);
                $MyTashim = new Tashim;
                $total_sales = $this->get_totall_price($ProductTarget->PricePlan, $ProductTarget->MinPrice, $ProductTarget->Price, $product_qty);
                $totall_buy = $ProductTarget->BuyPrice * $product_qty;
                $ProductAttr = [
                    'TargetWarehouse' => $ProductTarget->WarehouseID,
                    'SaleMony' => $total_sales,
                    'BuyMony' => $totall_buy,
                    'TaxMony' => $tax_total,
                    'ProductId' => $product_id,
                    'PwID' => $ProductWarehouseID,
                ];
                $MyTashim->AddWallet($ProductAttr, $TashimId);
            }
        }
        $this->num_items_sold = $num_items_sold;
        $this->total_sales_G = $total_sales_G;
        $this->tax_total_G = $tax_total_G;
        $this->customer_benefit_total_G = $customer_benefit_total_G;
        $this->SubItem = $SubItem;
        $this->net_total_G = $net_total_G;
        $this->TotallWeight = $TotallWeight;
        $this->topay = $topay;
    }
    public function AddnewLocation($LocationAtribute)
    {

        $SaharestanID = $LocationAtribute['Shahrestan'];
        $ProvinceID = $LocationAtribute['Province'];
        $recivername = $LocationAtribute['recivername'];
        $reciverphone = $LocationAtribute['reciverphone'];
        $LocationName = $LocationAtribute['LocationName'];
        $OthersAddress = $LocationAtribute['OthersAddress'];
        $PostalCode = $LocationAtribute['PostalCode'];
        $ExtraNote = $LocationAtribute['ExtraNote'];
        $Street = $LocationAtribute['Street'];
        $Pelak = $LocationAtribute['Pelak'];


        $CityName = citys::where('id', $SaharestanID)->first();
        if ($CityName == null) {
            $CityName = 'شهر یافت نشد';
        } else {
            $CityName = $CityName->CityName;
        }
        $ProvinceName = provinces::where('id', $ProvinceID)->first();
        if ($ProvinceName == null) {
            $ProvinceName = 'استان یافت نشد';
        } else {
            $ProvinceName = $ProvinceName->ProvinceName;
        }

        if ($recivername == null) { //not define reciver name
            $recivername = Auth::user()->Name . ' ' . Auth::user()->Family;
        }
        if ($reciverphone == null) {
            $reciverphone = Auth::user()->MobileNo;
        }
        $LocationData = [
            'Owner' => $this->UserName,
            'name' => $LocationName,
            'Province' => $ProvinceName,
            'ProvinceID' => $ProvinceID,
            'City' => $CityName,
            'CityID' => $SaharestanID,
            'Street' => $Street,
            'OthersAddress' => $OthersAddress,
            'Pelak' => $Pelak,
            'PostalCode' => $PostalCode,
            'ExtraNote' => $ExtraNote,
            'recivername' => $recivername,
            'reciverphone' => $reciverphone,
        ];

        $Result = locations::create($LocationData);
        return $Result->id;
    }
    public function OrderPreSave($TargetLocation)
    {

        $OrderPreData = [
            'status' => 0,
            'ReturnCustomerId' => $this->UserName,
            'CustomerId' => $this->UserName,
            'SendLocation' => $TargetLocation,
            'ReturnLocation' => $TargetLocation,
            'status_history' => '' // TODO: add create order 
        ];
        $ProductOrderInsertResult = product_order::create($OrderPreData);
        $this->MainDeviceOrderID = $ProductOrderInsertResult->id;
        $this->ProductOrderId = $ProductOrderInsertResult->id;
        return $ProductOrderInsertResult->id;
    }
    public function get_totall_price_totall()
    {
        return $this->TotalPrice;
    }
    public function get_totall_wight()
    {
        return $this->TotalWight;
    }
    public function test()
    {
        return 'salam';
    }
    public function get_provices_all()
    {
        return provinces::all();
    }
    public function get_User_Locations($UserId = null)
    {
        if ($UserId == null) {
            if (Auth::check()) {
                $UserId = $this->UserName;
            } else {
                return [];
            }
        }
        return locations::all()->where("Owner", $UserId)->where('Status', 1);
    }
    public function get_product_unit_Plan($UnitPlan, $ProductQty, $DefultVal = null)
    {
        if ($UnitPlan == null || $UnitPlan == []) {
            return $DefultVal;
        } else {
            $MyProduct = new product();
            return $MyProduct->GetTargetUnitFromUnitPlanJson($UnitPlan, $ProductQty);
        }
    }
    public function get_product_warehouse($ProductId)
    {
        return warehouse_goods::where('GoodID', $ProductId)->first();
    }
    public function get_product_warehouse_ID($WGId)
    {
        return warehouse_goods::where('id', $WGId)->first();
    }
    public function get_product_tashims($WGID)
    {
        $Query = "select * from tashim_items  as ti inner join tashims t on ti.TashimID = t.id where ti.GoodsID = $WGID";
        return DB::select($Query);
    }
    public function get_totall_price($PricePlan, $MinPrice, $Price, $ProductQty)
    {
        if ($PricePlan == null) {
            if ($MinPrice > 0) { //offline sale
                return 0;
            } else { //online sale
                return intval($Price) * intval($ProductQty);
            }
        } else {
            $MyProduct = new product();
            $BasePrice = $MyProduct->GetTargetPriceFromPricePlanJson($PricePlan, $ProductQty);
            return intval($BasePrice) * intval($ProductQty);
        }
    }
    public function get_order_detials_with_ID($OrderID)
    {
        $query = "SELECT g.NameFa ,g.id as GoodId ,g.SKU,Pi.* from product_order_items as Pi INNER join goods as g on Pi.product_id = g.id WHERE Pi.order_id = $OrderID";
        return DB::select($query);
    }
    public function get_order_pay_status($OrderID)
    {
        $Query = "SELECT po.CustomerId , us.CreditMod from product_orders as po INNER join UserCredit as us on po.id = us.InvoiceNo and po.CustomerId = us.UserName  WHERE po.id = $OrderID 
        GROUP by po.CustomerId , us.CreditMod ";
        $Result = DB::select($Query);

        return $Result[0];
    }


    public function get_order_price_total($CreditMod)
    {
    }
    public function get_order_virtual()
    {
        return $this->OrderVirtual;
    }
    public function get_order_detials()
    {
        $TotalWight = 0;
        $TotalPrice = 0;
        $MyOrder = json_decode(Session::get('basket'));
        $OrderDetials = array();
        if ($MyOrder == null) {
            $OrderDetials = null;
            $this->TotalPrice = $TotalPrice;
            $this->TotalWight = $TotalWight;
            return $OrderDetials;
        }
        foreach ($MyOrder as $MyOrderTarget) {
            $ProductQty = $MyOrderTarget[1];
            $ProductId = $MyOrderTarget[0];
            $pw_id = $MyOrderTarget[2];
            $Product = goods::where('id', $ProductId)->first();
            $ProductVirtual = $Product->Virtual;
            if (!isset($this->OrderVirtual)) {
                $this->OrderVirtual = $ProductVirtual;
            } elseif ($this->OrderVirtual != $ProductVirtual) {
                $this->OrderVirtual = 'TypeMismatch';
            }
            $UnitPlan = $this->get_product_unit_Plan($Product->UnitPlan, $ProductQty);
            $BaseUnit = $this->get_product_unit_Plan($Product->UnitPlan, 1, 'عدد');

            $ProductInWarehouse = $this->get_product_warehouse_ID($pw_id);
            $remain = $ProductInWarehouse->Remian;
            $TotalWight += intval($Product->weight) * intval($ProductQty);
            $WGID = $ProductInWarehouse->id;
            $Tashims = $this->get_product_tashims($WGID);
            $TotalProductPrice = $this->get_totall_price($ProductInWarehouse->PricePlan, $ProductInWarehouse->MinPrice, $ProductInWarehouse->Price, $ProductQty);
            $TotalPrice += $TotalProductPrice;
            array_push($OrderDetials, ['Tashims' => $Tashims, 'BaseUnit' => $BaseUnit, 'UnitPlan' => $UnitPlan, 'TotalWight' => $TotalWight, 'Product' => $Product, 'ProductQty' => $ProductQty, 'ProductInWarehouse' => $ProductInWarehouse, 'remain' => $remain]);
        }

        $this->TotalPrice = $TotalPrice;
        $this->TotalWight = $TotalWight;
        return $OrderDetials;
    }

    public function ViewOrders($UserName, $UserRole)
    {

        $Query = "SELECT branches.Description as branch_name , addorder1.ID, addorder1.UserName, addorder1.BimarUserName,citys.CityName,Province.ProvinceName, catorder.Cat, addorder1.CreateDate as CreateDatew, addorder1.Address  , addorder1.Extranote, orderstatus.status, actionsorder.UserAction, actionsorder.CreateDate, Bimaruser.Name as BimarName, Bimaruser.Family as Bimarfamily,Bimaruser.MobileNo as BimarMobile, Orderuser.Name as ordername, Orderuser.Family as orderfamily
                    FROM addorder1 left JOIN actionsorder on addorder1.ID = actionsorder.OrderID 
                    INNER JOIN catorder on addorder1.CatID = catorder.ID 
                    INNER JOIN orderstatus on addorder1.Status = orderstatus.ID
                    INNER JOIN branches on addorder1.branch = branches.id
                    LEFT JOIN citys as citys on citys.id = addorder1.city 
                    LEFT JOIN provinces as Province on Province.id = addorder1.Province 
                    LEFT JOIN UserInfo as Bimaruser on Bimaruser.UserName = addorder1.BimarUserName 
                    LEFT JOIN UserInfo as Orderuser on addorder1.UserName = Orderuser.UserName ";

        if ($UserRole == myappenv::role_SuperAdmin) {
            $Query .= "WHERE addorder1.Status < 6 and ( addorder1.state < 1000 or addorder1.state is null ) ";
        } elseif ($UserRole == myappenv::role_customer) {
            $Query .= "WHERE addorder1.Status < 6 and ( addorder1.state < 1000 or addorder1.state is null ) and addorder1.UserName = '$UserName' ";
        } else {
            $Query .= "WHERE   (actionsorder.UserAction = '$UserName' OR actionsorder.UserAction is null) and addorder1.Status < 6 and ( addorder1.state < 1000 or addorder1.state is null ) ";
        }
        if (Auth::user()->branch != myappenv::Branch) {
            $Query .= " and addorder1.branch =" . Auth::user()->branch . " ";
        }
        $Query .= "GROUP by branches.Description, addorder1.ID, addorder1.UserName, addorder1.BimarUserName, catorder.Cat, addorder1.CreateDate, addorder1.Address, addorder1.Extranote, orderstatus.status, actionsorder.UserAction, actionsorder.CreateDate, Bimaruser.Name , Bimaruser.Family ,Bimaruser.MobileNo , Orderuser.Name , Orderuser.Family ,citys.CityName,Province.ProvinceName
        ORDER BY addorder1.ID DESC";
        $mydebug = new debuger();
        if ($mydebug->DebugEnable()) {
            echo ($Query);
        }
        return DB::select($Query);
    }
    /**
     * This function use to return  orderlist to show in AccountingDashboard
     *
     *
     */
    public function ViweOrderList()
    {
        $Query = "SELECT po.*, ui.Name  as customername , ui.Family as customerfamily , ui.MobileNo from product_orders po inner join UserInfo ui on po.CustomerId  = ui.UserName WHERE po.status = 70 limit 5";
        $OrderList = DB::select($Query);
        return $OrderList;
    }
}

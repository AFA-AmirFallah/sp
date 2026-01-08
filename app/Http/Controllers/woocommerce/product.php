<?php

namespace App\Http\Controllers\woocommerce;

use App\APIS\SmsCenter;
use App\APIS\SMSDotIR;
use App\APIS\Tapin;
use App\Functions\adsClass;
use App\Functions\AppSetting;
use App\Functions\CacheData;
use App\Functions\DashboardClass;
use App\Functions\Financial;
use App\Functions\Images;
use App\Functions\Indexes;
use App\Functions\Orders;
use App\Functions\persian;
use App\Functions\Statistics;
use App\Functions\TashimClass;
use App\Functions\TashimVars;
use App\Functions\TextClassMain;
use App\Functions\TransferInvoice;
use App\Functions\TransferProduct;
use App\hiring\hiring_package_manager;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Credit\currency;
use App\Http\Controllers\Credit\DirectPayment;
use App\Http\Controllers\Credit\Tashim as CreditTashim;
use App\Http\Controllers\Order\OrderBack;
use App\Http\Controllers\Point\Points;
use App\Http\Controllers\setting\debuger;
use App\Http\Controllers\setting\SettingManagement;
use App\Http\Controllers\site\main;
use App\Http\Controllers\woocommerce\ProductClass;
use App\Http\Controllers\woocommerce\store as WoocommerceStore;
use App\Models\branches;
use App\Models\branchs_order;
use App\Models\citys;
use App\Models\DeviceContract;
use App\Models\DeviceItemInternal;
use App\Models\goodindex;
use App\Models\goods;
use App\Models\L1Work;
use App\Models\L2Work;
use App\Models\L3Work;
use App\Models\locations;
use App\Models\metadata;
use App\Models\picrefrence;
use App\Models\post_views;
use App\Models\posts;
use App\Models\product_alert;
use App\Models\ProductUnitMeta;
use App\Models\ProductView;
use App\Models\ProductViewWithIndex;
use App\Models\product_order;
use App\Models\product_order_items;
use App\Models\provinces;
use App\Models\report_detial;
use App\Models\report_overview;
use App\Models\setting;
use App\Models\store;
use App\Models\tashim;
use App\Models\tashim_items;
use App\Models\transactionstemp;
use App\Models\UserCredit;
use App\Models\UserInfo;
use App\Models\UserPoint;
use App\Models\UserRole;
use App\Models\warehouse;
use App\Models\warehouse_goods;
use App\Models\WorkCat;
use App\Models\WorkerSkils;
use App\myappenv;
use App\Patient\PatiantServices;
use App\PEC\PECMain;
use App\PEP\RSAKeyType;
use App\PEP\RSAProcessor;
use App\Renting\ProductRenting;
use App\SEO\meta_keyword;
use App\Shop\ProductAlert;
use App\Shop\ProductManagement;
use App\Shop\ProductMark;
use App\zarinpal\zarinpal;
use Illuminate\Support\Facades\DB;
use Hamcrest\Type\IsNumeric;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use PDF;
use stdClass;

use function PHPUnit\Framework\isJson;
use function PHPUnit\Framework\returnValue;

class product extends Controller
{



    private $target_user = null;
    public $MeueTypes = 'L3';
    private $DeviceOrder = null;

    private $brand_WC = 2; //TODO: dynamic assign
    private $brand_L1 = 2;//TODO: dynamic assign
    private $brand_L2 = 1;//TODO: dynamic assign

    private function get_paginate()
    {
        return $paginate = AppSetting::getcache('product_pag') ?? 10;
    }

    public function get_product_custom_url($product_id)
    {
        // $product_id = substr($product_id, strlen(myappenv::PreProductTag));
        if (!is_numeric($product_id)) {
            return [
                'result' => true,
                'type' => 'return', // return result
                'url' => $product_id
            ];
        }
        $good_src = goods::where('id', $product_id)->first();
        if ($good_src == null) {
            return [
                'result' => false,
                'type' => 'error',
                'msg' => 'محصول مورد نظر موجود نیست!'
            ];
        }
        return [
            'result' => true,
            'type' => 'redirect',// redirect to new address
            'url' => $good_src->urladdress
        ];

    }

    public function brand(Request $request, $TagName)
    {
        $l3_src = L3Work::where('WorkCat', $this->brand_WC)->where('L1ID', $this->brand_L1)->where('L2ID', $this->brand_L2)->where('Name', $TagName)->first();
        if ($l3_src == null) {
            return abort('404');
        }

        $post_src = posts::where('MainIndex', $l3_src->UID)->where('Type', '>', 1)->where('status', 1)->first();

        return $this->ShowProduct($request, $l3_src->UID, $TagName, $post_src);


    }
    public function Dobrand(Request $request, $TagName)
    {
        $l3_src = L3Work::where('WorkCat', $this->brand_WC)->where('L1ID', $this->brand_L1)->where('L2ID', $this->brand_L2)->where('Name', $TagName)->first();
        if ($l3_src == null) {
            return abort('404');
        }
        return $this->DoShowProduct($request, $l3_src->UID);

    }
    public function ProductCat()
    {
        $menu = Indexes::get_index_id();
        $main_cat = L2Work::where('WorkCat', $menu->WorkCat)->where('L1ID', $menu->L1ID)->get();
        return view('Layouts.Theme5.ProductCat', ['main_cat' => $main_cat]);
    }
    public function DoProductCat()
    {

    }
    private function is_payment_unsuccess(Request $request, $pay = null, $ref = null)
    {

        if ($ref == 'Faild') {
            return [
                'result' => true,
                'msg' => 'تراکنش انجام نشد در صورت کسر مبلغ نهایتا پس از ۷۲ ساعت به حساب شما بازگشت داده خواهد شد'
            ];
        }
        return [
            'result' => false
        ];
    }
    private function check_payment_pre_define(Request $request, $pay = null, $ref = null)
    {
        $pay_result = transactionstemp::where('refnumber', $ref)->first(); //TODO: check this function not use globaly
        transactionstemp::where('refnumber', $ref)->delete();
        //  $pay_result = transactionstemp::where('id', $ref)->first(); //TODO: check this function not use globaly

        if ($pay_result == null) {
            return [
                'result' => false,
                'msg' => 'اطلاعات تراکنش نا معتبر است!'
            ];
        }
        $price = Session::get('price');
        if ($price != $pay_result->Amount) {
            return [
                'result' => false,
                'msg' => 'مشکل امنیتی کد : ۱۴۸۷ '
            ];
        }
        return [
            'result' => true,
            'amount' => $pay_result->Amount,
            'ref_number' => $pay_result->refnumber
        ];

    }
    private function get_pay_type()
    {
        $ResNum = Session::get('ResNum');
        if (Session::has('uc')) {
            return 'pay_by_link';
        }
        if (Session::has('package')) {
            return 'package';
        }
        if ($ResNum == 0) {
            return 'direct_payment';
        }
        if (str_starts_with($ResNum, '99000')) {
            return 'karmozd_payment';
        }
        return 'product_buy';

    }
    private function clear_cache()
    {
        Session::forget('price');
        Session::forget('uc');
        Session::forget('ResNum');
        Session::forget('note');
        session::forget('DeleverMony');
        Session::forget('package');
        Session::forget('basket');

        Session::save();
        return true;
    }
    private function ipg_verification($request, $pay, $ref)
    {
        return [
            'result' => true
        ];
    }
    private function product_buy($ResNum, $ref_number, $pay)
    {
        $MyTransfer = new TransferProduct(product_orders: $ResNum);
        $payment_result = $MyTransfer->UserPay($ref_number, $ref_number, $pay);
        return $payment_result;
    }
    private function pay_by_link($price, $RefID, $gateway)
    {
        $transaction_id = Session::get('uc');
        $credit_src = UserCredit::find($transaction_id);
        if ($credit_src == null) {
            return false;
        }
        if ($credit_src->CreditMod != myappenv::ToPayCredit) {
            return false;
        }
        if ($credit_src->ConfirmBy != null) {
            return false;
        }
        if ($credit_src->Mony != $price) {
            return false;
        }

        $TransactionData = [
            'Date' => now(),
            'CreditMod' => myappenv::CachCredit,
            'ConfirmBy' => 'system',
            'PaymentId' => $RefID,
            'SpecialPaymentId' => $RefID,
            'GateWay' => $gateway,
            'Confirmdate' => now(),
        ];
        UserCredit::where('ID', $transaction_id)->update($TransactionData);
        $userCredit_src = UserCredit::where('ID', $transaction_id)->first();
        $this->target_user = $userCredit_src->UserName;


        //$credit_src->update($TransactionData);
        //$credit_src->save();
        //UserCredit::where('id', $transaction_id)->where('Mony', $price)->update($TransactionData);
        return true;

    }
    private function buy_package($price, $ResNum, $RefID, $GateWay)
    {
        $payment_result = $this->direct_payment($price, $ResNum, $RefID, $GateWay);
        if (!$payment_result['result']) {
            return false;
        }
        $credit_reference_id = $payment_result['credit_id'];
        $package_manager = new hiring_package_manager;
        return $package_manager->confirm_payment(true, $credit_reference_id);
    }
    private function direct_payment($price, $ResNum, $RefID, $GateWay)
    {
        $note = Session::get('note');
        $TransactionData = [
            'UserName' => Auth::id(),
            'Mony' => $price,
            'Type' => 66,
            'Date' => now(),
            'Note' => $note ?? 'پرداخت از طریق درگاه ',
            'TransferBy' => Auth::id(),
            'CreditMod' => myappenv::CachCredit,
            'ConfirmBy' => 'system',
            'InvoiceNo' => $ResNum,
            'PaymentId' => $RefID,
            'SpecialPaymentId' => $RefID,
            'GateWay' => $GateWay,
            'Confirmdate' => now(),
            'branch' => Auth::user()->branch,
        ];
        $insertResult = UserCredit::create($TransactionData);
        return [
            'result' => true,
            'credit_id' => $insertResult->id
        ];
    }
    private function confirm_pay_form_ipg(Request $request, $pay = null, $ref = null)
    {
        /**
         * 1- check ipg result
         * check payment success from ipg
         * first step pass if ipg result is true
         */
        $unsuccess_payment = $this->is_payment_unsuccess($request, $pay, $ref);
        if ($unsuccess_payment['result']) {
            return abort('404', $unsuccess_payment['msg']);
        }
        /**
         * 2- check predefine record to ensuring transaction
         * before send user to ipg the information record save in database and after payment check the record again
         */
        $payment_pre_define = $this->check_payment_pre_define($request, $pay, $ref);

        if (!$payment_pre_define['result']) {
            return abort('404', $payment_pre_define['msg']);
        }
        $amount = $payment_pre_define['amount'];
        $ref_number = $payment_pre_define['ref_number'];
        /**
         * 3- verification transaction if not verified before
         */
        $verification = $this->ipg_verification($request, $pay, $ref);
        if (!$verification['result']) {
            return abort('404', $verification['msg']);
        }
        /**
         * 4- do pay process based on pay type
         */
        $pay_type = $this->get_pay_type();
        if ($pay_type == 'product_buy') {
            $ResNum = Session::get('ResNum');
            $payment_result = $this->product_buy($ResNum, $ref_number, $pay);
        }
        if ($pay_type == 'pay_by_link') {
            $payment_result = $this->pay_by_link($amount, $ref_number, $pay);
        }
        if ($pay_type == 'package') {
            $payment_result = $this->buy_package($amount, $ref_number, $ref_number, $pay);
        }
        if ($pay_type == 'direct_payment') {
            $payment_result = $this->direct_payment($amount, $ref_number, $ref_number, $pay);
            $payment_result = $payment_result['result'];
        }
        if ($pay_type == 'karmozd_payment') {
            $payment_result = $this->karmozd_payment();
        }
        /**
         * 5- check payment process done success fully
         */
        if ($payment_result) {

        } else {
            $clear_cache = $this->clear_cache();
            return abort('404', 'در انجام تراکنش مشکلی پیش آمده لطفا با فروشگاه تماس بگیرید 14693  ');
        }
        /**
         * 6- alert buy and payment
         */
        $sms_center = new SMSDotIR;
        $arr = [
            [
                "name" => "NAME",
                "value" => Auth::user()->Name . ' ' . Auth::user()->Family
            ],
            [
                "name" => "CODE",
                "value" => $ResNum
            ]

        ];
        $sms_center->send_order_final($arr, Auth::user()->MobileNo);
        $sms_center = new SMSDotIR;
        $arr = [
            [
                "name" => "ID",
                "value" => $ResNum
            ],
            [
                "name" => "PRICE",
                "value" => number_format($amount) . ' ریال'
            ]
        ];
        $sms_center->send_manager_alert($arr, '09123936105');
        $sms_center->send_manager_alert($arr, '09123345580');


        /**
         * 7- add log
         */

        /**
         * 8- clear related field and cache
         */
        $RResult = array('Mony' => Session::get('price'), 'Confirmdate' => date("Y-m-d H:i:s"), 'GateWay' => 'درگاه بانکی');
        if ($this->target_user != null) {
            $UserInfo = UserInfo::where('UserName', $this->target_user)->first();
        } else {
            $UserInfo = Auth::user();
        }
        $clear_cache = $this->clear_cache();
        return view("Credit.ConfirmPay", ['Result' => $RResult, 'UserInfo' => $UserInfo]);

    }
    private function pay_from_wallet(Request $request, $pay = null, $ref = null)
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
                $MySMS->OndemandSMS($SellerText, '09192228284', 'tnks', '09101812802');
            }
            $RResult = array('Mony' => $price, 'Confirmdate' => date("Y-m-d H:i:s"), 'GateWay' => 'ایران کیش');
            $UserInfo = Auth::user();
            $Myorder = new Orders();
            $product_order = product_order::where('id', $ResNum)->first();
            $product_order_Item = product_order_items::where('order_id', $ResNum)->get();
            foreach ($product_order_Item as $item) {

                $this->GetProductIndex($item->product_id, $Buy = 1);
            }

            if (Session::has('NormalInvoice')) {
                return view('Layouts.Theme1.FinalOfDirectPay');
            } else {
                return view('Layouts.Theme1.FinalOFOrder', ['ResNum' => $ResNum, 'RResult' => $RResult, 'Myorder' => $Myorder, 'product_order' => $product_order]);
            }
        } else {
            return abort('404', 'در انجام تراکنش مشکلی پیش آمده لطفا با فروشگاه تماس بگیرید 14693  ');
        }
    }

    public function ConfirmPay(Request $request, $pay = null, $ref = null)
    {
        if ($request->ajax()) {
            $Order = new Orders();
            if ($request->has('removeitem')) {
                $MyBuy = new buy();
                $MyBuy->RemoveGoodFromBasket($request->input('removeitem'));
            }
            if ($request->has('clear')) {
                $MyBuy = new buy();
                $MyBuy->RemoveAllFromBasket();
            }
            if ($request->has('page')) {
                $TargetPage = $request->input('page');
                $returnHTML = view("Layouts.Theme1.objects.$TargetPage", ['Order' => $Order])->render();
                return $returnHTML;
            } else {
                return 'error';
            }
        }
        if (is_numeric($pay)) { //pay from wallet
            return $this->pay_from_wallet($request, $pay, $ref);
        }
        if ($pay != 'sep') {
            return $this->confirm_pay_form_ipg($request, $pay, $ref);

        }





        if ($pay == 'sep' || $pay == 'pep' || $pay == 'IKC' || $pay == 'PEC' || $pay == 'PNA' || $pay == 'ZAR') {
            if ($ref == 'Faild') {
                return abort('404', 'تراکنش انجام نشد در صورت کسر مبلغ نهایتا پس از ۷۲ ساعت به حساب شما بازگشت داده خواهد شد');
            }
            if ($pay == 'sep') {
                $Payresutl = transactionstemp::where('id', $ref)->first();
                if ($Payresutl == null) {
                    return abort('404', 'اطلاعات تراکنش نا معتبر است!');
                }
                $price = Session::get('price');
                $ResNum = Session::get('ResNum');
                if ($price == $Payresutl->Amount) {
                    $MyTransfer = new TransferProduct($ResNum);
                    $resutl = $MyTransfer->UserPay($Payresutl->refnumber, $Payresutl->refnumber, $pay);
                    if ($resutl) {
                        $RResult = array('Mony' => Session::get('price'), 'Confirmdate' => date("Y-m-d H:i:s"), 'GateWay' => 'بانک سامان');
                        Session::put('price', null);
                        Session::put('ResNum', null);
                        transactionstemp::where('refnumber', $ref)->delete();
                        $UserInfo = Auth::user();
                        Session::put('basket', null);
                        if (myappenv::MainOwner == 'shafatel' || myappenv::MainOwner == 'Carpetour') {
                            $MySMS = new SmsCenter();
                            $CustomerText = 'سلام ' . Auth::user()->Name . ' ' . Auth::user()->Family . ' عزیز' . "\n";
                            $CustomerText .= 'سفارش شما به شماره ' . $ResNum . ' با موفقیت ثبت شد.' . "\n";
                            $CustomerText .= 'با تشکر از خرید شما.' . "\n";
                            $CustomerText .= myappenv::CenterName;
                            $MySMS->OndemandSMS($CustomerText, Auth::user()->MobileNo, 'tnks', Auth::user()->MobileNo);
                            $SellerText = 'سلام مدیر گرامی سفارش ' . $ResNum . 'با مبلغ ' . number_format($price) . ' در سامانه ثبت شد!';
                            $MySMS->OndemandSMS($SellerText, '09126543802', 'tnks', '09126543802');
                            $MySMS->OndemandSMS($SellerText, '09123936105', 'tnks', '09123936105');
                        } else {
                            $sms_center = new SMSDotIR;
                            $arr = [
                                [
                                    "name" => "NAME",
                                    "value" => Auth::user()->Name . ' ' . Auth::user()->Family
                                ],
                                [
                                    "name" => "CODE",
                                    "value" => $ResNum
                                ]

                            ];
                            $sms_center->send_order_final($arr, Auth::user()->MobileNo);
                            $sms_center = new SMSDotIR;
                            $arr = [
                                [
                                    "name" => "ID",
                                    "value" => $ResNum
                                ],
                                [
                                    "name" => "PRICE",
                                    "value" => number_format($MyTransfer->get_order_price()) . ' ریال'
                                ]
                            ];
                            $sms_center->send_manager_alert($arr, '09123936105');
                            $sms_center->send_manager_alert($arr, '09123345580');

                        }
                        $this->AddLog($ResNum);
                        return view("Credit.ConfirmPay", ['Result' => $RResult, 'UserInfo' => $UserInfo]);
                    } else {
                        return abort('404', 'در انجام تراکنش مشکلی پیش آمده لطفا با فروشگاه تماس بگیرید 14693  ');
                    }
                } else {

                    return abort('404', 'مشکل امنیتی کد : ۱۴۸۷ ');
                }
            } elseif ($pay == 'ZAR') {

                $NormalBuy = true;
                $Payresutl = transactionstemp::where('refnumber', $ref)->first();

                if ($Payresutl == null) {
                    return abort('404', 'اطلاعات تراکنش نا معتبر است!');
                }
                $price = Session::get('price');
                $ResNum = Session::get('ResNum');

                if ($price == $Payresutl->Amount) {
                    $zarinpal = new zarinpal;
                    $veryfy_result = $zarinpal->verification($price);

                    if ($veryfy_result['result']) { //direct pay charge account
                        $veryfy_data = $veryfy_result['data'];
                        $note = Session::get('note');
                        if (Session::has('uc')) { //پرداخت از طریق لینک درخواست پرداخت
                            $transaction_id = Session::has('uc');
                            $TransactionData = [
                                'Date' => now(),
                                'CreditMod' => myappenv::CachCredit,
                                'ConfirmBy' => 'system',
                                'PaymentId' => $veryfy_data['RefID'],
                                'SpecialPaymentId' => $veryfy_data['RefID'],
                                'GateWay' => 'ZAR',
                                'Confirmdate' => now(),
                            ];
                            UserCredit::where('id', $transaction_id)->where('Mony', $price)->update($TransactionData);
                        } else {
                            $TransactionData = [
                                'UserName' => Auth::id(),
                                'Mony' => $price,
                                'Type' => 66,
                                'Date' => now(),
                                'Note' => $note ?? 'پرداخت از درگاه پرداخت زرین پال',
                                'TransferBy' => Auth::id(),
                                'CreditMod' => myappenv::CachCredit,
                                'ConfirmBy' => 'system',
                                'InvoiceNo' => $ResNum,
                                'PaymentId' => $veryfy_data['RefID'],
                                'SpecialPaymentId' => $veryfy_data['RefID'],
                                'GateWay' => 'ZAR',
                                'Confirmdate' => now(),
                                'branch' => Auth::user()->branch,
                            ];
                            $insertResult = UserCredit::create($TransactionData);
                            transactionstemp::where('refnumber', $ref)->delete();
                        }
                        if (Session::has('package')) {
                            $package_manager = new hiring_package_manager;
                            return $package_manager->confirm_payment(true, $insertResult->id);
                        }

                        Session::forget('price');
                        Session::forget('uc');
                        Session::forget('ResNum');
                        Session::forget('note');
                        $RResult = array('Mony' => $price, 'Confirmdate' => date("Y-m-d H:i:s"), 'GateWay' => 'زرین پال');
                        $UserInfo = Auth::user();
                        $Myorder = new Orders();
                        $product_order = product_order::where('id', $ResNum)->first();
                        if (Session::has('NormalInvoice')) {
                            Session::forget('NormalInvoice');
                            return view('Layouts.Theme1.FinalOfDirectPay');
                        } else {
                            return view('Layouts.Theme1.FinalOFOrder', ['ResNum' => $ResNum, 'RResult' => $RResult, 'Myorder' => $Myorder, 'product_order' => $product_order]);
                        }
                    } else {
                        return abort('404', $veryfy_result['msg']);
                    }
                } else {
                    return abort('404', 'مشکل امنیتی کد : ۱۴۸۲ ');
                }
            } elseif ($pay == 'IKC') {

                $NormalBuy = true;
                $Payresutl = transactionstemp::where('refnumber', $ref)->first();

                if ($Payresutl == null) {
                    return abort('404', 'اطلاعات تراکنش نا معتبر است!');
                }
                $price = Session::get('price');
                $ResNum = Session::get('ResNum');
                if ($price == $Payresutl->Amount) {

                    if ($ResNum == 0) { //direct pay charge account
                        $note = Session::get('note');
                        $TransactionData = [
                            'UserName' => Auth::id(),
                            'Mony' => $price,
                            'Type' => 66,
                            'Date' => now(),
                            'Note' => $note,
                            'TransferBy' => Auth::id(),
                            'CreditMod' => myappenv::CachCredit,
                            'ConfirmBy' => 'system',
                            'InvoiceNo' => '',
                            'PaymentId' => $ref,
                            'SpecialPaymentId' => $ref,
                            'GateWay' => 'IKC',
                            'Confirmdate' => now(),
                            'branch' => Auth::user()->branch,
                        ];
                        $insertResult = UserCredit::create($TransactionData);
                        Session::put('price', null);
                        Session::put('ResNum', null);
                        Session::put('note', null);
                        transactionstemp::where('refnumber', $ref)->delete();
                        $RResult = array('Mony' => $price, 'Confirmdate' => date("Y-m-d H:i:s"), 'GateWay' => 'ایران کیش');
                        $UserInfo = Auth::user();
                        $Myorder = new Orders();
                        $product_order = product_order::where('id', $ResNum)->first();
                        if (Session::has('NormalInvoice')) {
                            return view('Layouts.Theme1.FinalOfDirectPay');
                        } else {
                            return view('Layouts.Theme1.FinalOFOrder', ['ResNum' => $ResNum, 'RResult' => $RResult, 'Myorder' => $Myorder, 'product_order' => $product_order]);
                        }
                    }
                    if (str_starts_with($ResNum, '99000')) {  //karmozd
                        $InvoiceNumber = substr($ResNum, 5, strlen($ResNum));
                        $MyInvouce = new TransferInvoice($InvoiceNumber);
                        $resutl = $MyInvouce->UserPay($ResNum, $InvoiceNumber, 'IKC', $price);
                        $UserInfo = $MyInvouce->GetUserInfo();

                        $NormalBuy = false;
                    } else {

                        $MyTransfer = new TransferProduct($ResNum);
                        $MyTransfer->SetPayment($price);
                        $resutl = $MyTransfer->UserPay($Payresutl->refnumber, $Payresutl->refnumber, $pay);
                    }
                    if ($resutl) {
                        $RResult = array('Mony' => Session::get('price'), 'Confirmdate' => date("Y-m-d H:i:s"), 'GateWay' => 'ایران کیش');
                        Session::put('price', null);
                        Session::put('ResNum', null);

                        transactionstemp::where('refnumber', $ref)->delete();
                        Session::put('basket', null);
                        if ($NormalBuy) {
                            $UserInfo = Auth::user();
                            $MySMS = new SmsCenter();
                            $CustomerText = 'سلام ' . Auth::user()->Name . ' ' . Auth::user()->Family . ' عزیز' . "\n";
                            $CustomerText .= 'سفارش شما به شماره ' . $ResNum . ' با موفقیت ثبت شد.' . "\n";
                            $CustomerText .= 'با تشکر از خرید شما.' . "\n";
                            $CustomerText .= myappenv::CenterName;
                            $MySMS->OndemandSMS($CustomerText, Auth::user()->MobileNo, 'tnks', Auth::user()->MobileNo);
                            $SellerText = 'سلام مدیر سفارش ' . $ResNum . 'با مبلغ ' . number_format($price) . ' در سامانه ثبت شد!';
                            if (myappenv::MainOwner == 'shafatel' || myappenv::MainOwner == 'Carpetour') {
                                $MySMS->OndemandSMS($SellerText, '09126543802', 'tnks', '09126543802');
                            } else {
                                //$MySMS->OndemandSMS($SellerText, '09123345580', 'tnks', '09123345580');
                            }
                            $this->AddLog($ResNum);
                            $MySMS->OndemandSMS($SellerText, '09123936105', 'tnks', '09123936105');
                            if (myappenv::MainOwner == 'kookbaz') {
                                $MySMS->OndemandSMS($SellerText, '09125833245', 'tnks', '09125833245');
                                $MySMS->OndemandSMS($SellerText, '09192228284', 'tnks', '09192228284');
                            }
                        }
                        $UserInfo = Auth::user();
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
                } else {

                    return abort('404', 'مشکل امنیتی کد : ۱۴۸۲ ');
                }
            } elseif ($pay == 'PNA') {
                $Payresutl = transactionstemp::where('refnumber', $ref)->first();
                if ($Payresutl == null) {
                    echo "شماره ارجاع $ref در سامانه موجود نیست";
                    return false;
                }
                $NormalBuy = true;
                $price = Session::get('price');
                $ResNum = Session::get('ResNum');
                if ($price == $Payresutl->Amount) {


                    if ($ResNum == 0) { //direct pay charge account
                        $note = Session::get('note');
                        $TransactionData = [
                            'UserName' => Auth::id(),
                            'Mony' => $price,
                            'Type' => 66,
                            'Date' => now(),
                            'Note' => $note,
                            'TransferBy' => Auth::id(),
                            'CreditMod' => myappenv::CachCredit,
                            'ConfirmBy' => 'system',
                            'InvoiceNo' => '',
                            'PaymentId' => $ref,
                            'SpecialPaymentId' => $ref,
                            'GateWay' => 'PNA',
                            'Confirmdate' => now(),
                            'branch' => Auth::user()->branch,
                        ];
                        $insertResult = UserCredit::create($TransactionData);
                        Session::put('price', null);
                        Session::put('ResNum', null);
                        Session::put('note', null);
                        transactionstemp::where('refnumber', $ref)->delete();
                        $RResult = array('Mony' => $price, 'Confirmdate' => date("Y-m-d H:i:s"), 'GateWay' => 'ایران کیش');
                        $UserInfo = Auth::user();
                        $Myorder = new Orders();
                        $product_order = product_order::where('id', $ResNum)->first();
                        if (Session::has('NormalInvoice')) {
                            return view('Layouts.Theme1.FinalOfDirectPay');
                        } else {
                            return view('Layouts.Theme1.FinalOFOrder', ['ResNum' => $ResNum, 'RResult' => $RResult, 'Myorder' => $Myorder, 'product_order' => $product_order]);
                        }
                    }
                    if (str_starts_with($ResNum, '99000')) {
                        $InvoiceNumber = substr($ResNum, 5, strlen($ResNum));
                        $MyInvouce = new TransferInvoice($InvoiceNumber);
                        $resutl = $MyInvouce->UserPay($ResNum, $InvoiceNumber, 'IKC', $price);
                        $UserInfo = $MyInvouce->GetUserInfo();

                        $NormalBuy = false;
                    } else {

                        $MyTransfer = new TransferProduct($ResNum);
                        $MyTransfer->SetPayment($price);
                        $resutl = $MyTransfer->UserPay($Payresutl->refnumber, $Payresutl->refnumber, $pay);
                    }
                    if ($resutl) {
                        $RResult = array('Mony' => Session::get('price'), 'Confirmdate' => date("Y-m-d H:i:s"), 'GateWay' => 'ایران کیش');
                        Session::put('price', null);
                        Session::put('ResNum', null);

                        transactionstemp::where('refnumber', $ref)->delete();
                        Session::put('basket', null);
                        if ($NormalBuy) {
                            $UserInfo = Auth::user();
                            $MySMS = new SmsCenter();
                            $CustomerText = 'سلام ' . Auth::user()->Name . ' ' . Auth::user()->Family . ' عزیز' . "\n";
                            $CustomerText .= 'سفارش شما به شماره ' . $ResNum . ' با موفقیت ثبت شد.' . "\n";
                            $CustomerText .= 'با تشکر از خرید شما.' . "\n";
                            $CustomerText .= myappenv::CenterName;
                            $MySMS->OndemandSMS($CustomerText, Auth::user()->MobileNo, 'tnks', Auth::user()->MobileNo);
                            $SellerText = 'سلام مدیر سفارش ' . $ResNum . 'با مبلغ ' . number_format($price) . ' در سامانه ثبت شد!';
                            if (myappenv::MainOwner == 'shafatel' || myappenv::MainOwner == 'Carpetour') {
                                $MySMS->OndemandSMS($SellerText, '09126543802', 'tnks', '09126543802');
                            } else {
                                //$MySMS->OndemandSMS($SellerText, '09123345580', 'tnks', '09123345580');
                            }
                            $this->AddLog($ResNum);
                            $MySMS->OndemandSMS($SellerText, '09123936105', 'tnks', '09123936105');
                            if (myappenv::MainOwner == 'kookbaz') {
                                $MySMS->OndemandSMS($SellerText, '09125833245', 'tnks', '09125833245');
                                $MySMS->OndemandSMS($SellerText, '09192228284', 'tnks', '09192228284');
                            }
                        }
                        $UserInfo = Auth::user();
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
                } else {

                    return abort('404', 'مشکل امنیتی کد : ۱۴۸۲ ');
                }
            } elseif ($pay == 'PEC') {

                $NormalBuy = true;
                $Payresutl = transactionstemp::where('refnumber', $ref)->first();

                if ($Payresutl == null) {
                    return abort('404', 'اطلاعات تراکنش نا معتبر است!');
                }
                $price = Session::get('price');
                $ResNum = Session::get('ResNum');
                if ($price == $Payresutl->Amount) {

                    if ($ResNum == 0) { //direct pay charge account
                        $note = Session::get('note');
                        $TransactionData = [
                            'UserName' => Auth::id(),
                            'Mony' => $price,
                            'Type' => 66,
                            'Date' => now(),
                            'Note' => $note,
                            'TransferBy' => Auth::id(),
                            'CreditMod' => myappenv::CachCredit,
                            'ConfirmBy' => 'system',
                            'InvoiceNo' => '',
                            'PaymentId' => $ref,
                            'SpecialPaymentId' => $ref,
                            'GateWay' => 'PEC',
                            'Confirmdate' => now(),
                            'branch' => Auth::user()->branch,
                        ];
                        $insertResult = UserCredit::create($TransactionData);
                        Session::put('price', null);
                        Session::put('ResNum', null);
                        Session::put('note', null);
                        transactionstemp::where('refnumber', $ref)->delete();
                        $RResult = array('Mony' => $price, 'Confirmdate' => date("Y-m-d H:i:s"), 'GateWay' => 'بانک پارسیان');
                        $UserInfo = Auth::user();
                        $Myorder = new Orders();
                        $product_order = product_order::where('id', $ResNum)->first();
                        if (Session::has('NormalInvoice')) {
                            return view('Layouts.Theme1.FinalOfDirectPay');
                        } else {
                            return view('Layouts.Theme1.FinalOFOrder', ['ResNum' => $ResNum, 'RResult' => $RResult, 'Myorder' => $Myorder, 'product_order' => $product_order]);
                        }
                    }
                    if (str_starts_with($ResNum, '99000')) {
                        $InvoiceNumber = substr($ResNum, 5, strlen($ResNum));
                        $MyInvouce = new TransferInvoice($InvoiceNumber);
                        $resutl = $MyInvouce->UserPay($ResNum, $InvoiceNumber, 'IKC', $price);
                        $UserInfo = $MyInvouce->GetUserInfo();

                        $NormalBuy = false;
                    } else {

                        $MyTransfer = new TransferProduct($ResNum);
                        $MyTransfer->SetPayment($price);
                        $resutl = $MyTransfer->UserPay($Payresutl->refnumber, $Payresutl->refnumber, $pay);
                    }
                    if ($resutl) {
                        $RResult = array('Mony' => Session::get('price'), 'Confirmdate' => date("Y-m-d H:i:s"), 'GateWay' => 'ایران کیش');
                        Session::put('price', null);
                        Session::put('ResNum', null);

                        transactionstemp::where('refnumber', $ref)->delete();
                        Session::put('basket', null);
                        if ($NormalBuy) {
                            $UserInfo = Auth::user();
                            $MySMS = new SmsCenter();
                            $CustomerText = 'سلام ' . Auth::user()->Name . ' ' . Auth::user()->Family . ' عزیز' . "\n";
                            $CustomerText .= 'سفارش شما به شماره ' . $ResNum . ' با موفقیت ثبت شد.' . "\n";
                            $CustomerText .= 'با تشکر از خرید شما.' . "\n";
                            $CustomerText .= myappenv::CenterName;
                            $MySMS->OndemandSMS($CustomerText, Auth::user()->MobileNo, 'tnks', Auth::user()->MobileNo);
                            $SellerText = 'سلام مدیر سفارش ' . $ResNum . 'با مبلغ ' . number_format($price) . ' در سامانه ثبت شد!';
                            if (myappenv::MainOwner == 'shafatel' || myappenv::MainOwner == 'Carpetour') {
                                $MySMS->OndemandSMS($SellerText, '09126543802', 'tnks', '09126543802');
                            } else {
                                //$MySMS->OndemandSMS($SellerText, '09123345580', 'tnks', '09123345580');
                            }
                            $this->AddLog($ResNum);
                            $MySMS->OndemandSMS($SellerText, '09123936105', 'tnks', '09123936105');
                            if (myappenv::MainOwner == 'kookbaz') {
                                $MySMS->OndemandSMS($SellerText, '09125833245', 'tnks', '09125833245');
                                $MySMS->OndemandSMS($SellerText, '09192228284', 'tnks', '09192228284');
                            }
                        }
                        $UserInfo = Auth::user();
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
                } else {

                    return abort('404', 'مشکل امنیتی کد : ۱۴۸۲ ');
                }
            } elseif ($pay == 'pep') {
                dd($request->input());
                $price = Session::get('price');
                $ResNum = Session::get('ResNum');
                $fields = array('invoiceUID' => $request->input('tref'));
                $result = $this->post2https($fields, 'https://pep.shaparak.ir/CheckTransactionResult.aspx');
                $array = $this->makeXMLTree($result);
                foreach ($array as $ietm) {
                    if (isset($ietm['result'])) {
                        $PayResult = $ietm["result"];
                    } elseif (isset($ietm['transactionReferenceID'])) {
                        $transactionReferenceID = $ietm["transactionReferenceID"];
                    } elseif (isset($ietm['invoiceNumber'])) {
                        $invoiceNumber = $ietm["invoiceNumber"];
                    } elseif (isset($ietm['amount'])) {
                        $amount = $ietm["amount"];
                    } elseif (isset($ietm['traceNumber'])) {
                        $traceNumber = $ietm["traceNumber"];
                    } elseif (isset($ietm['referenceNumber'])) {
                        $referenceNumber = $ietm["referenceNumber"];
                    } elseif (isset($ietm['invoiceDate'])) {
                        $InvoiceDate = $ietm["invoiceDate"];
                    }
                }
                $MerchantCode = myappenv::PEPMerchantCode;
                $TerminalCode = myappenv::PEPTerminalCode;
                $TimeStamp = date("Y/m/d H:i:s");
                $fields = array(
                    'MerchantCode' => $MerchantCode, //shomare ye moshtari e shoma.
                    'TerminalCode' => $TerminalCode, //shomare ye terminal e shoma.
                    'InvoiceNumber' => $invoiceNumber, //shomare ye factor tarakonesh.
                    'InvoiceDate' => $InvoiceDate, //tarikh e tarakonesh.
                    'amount' => $amount, //mablagh e tarakonesh. faghat adad.
                    'TimeStamp' => date("Y/m/d H:i:s"), //zamane jari ye system.
                    'sign' => '', //reshte ye ersali ye code shode. in mored automatic por mishavad.
                );
                $data = "#$MerchantCode#$TerminalCode#$invoiceNumber#$InvoiceDate#$amount#$TimeStamp#";
                $data = sha1($data, true);
                $Certificate = myappenv::PEPPrivate;
                $processor = new RSAProcessor($Certificate, RSAKeyType::XMLString);
                $data = $processor->sign($data);
                $fields['sign'] = base64_encode($data); // base64_encode
                $sendingData = "MerchantCode=" . $MerchantCode . "&TerminalCode=" . $TerminalCode . "&InvoiceNumber=" . $invoiceNumber . "&InvoiceDate=" . $InvoiceDate . "&amount=" . $amount . "&TimeStamp=" . $TimeStamp . "&sign=" . $fields['sign'];
                $verifyresult = $this->post2https($fields, 'https://pep.shaparak.ir/VerifyPayment.aspx');
                $array = $this->makeXMLTree($verifyresult);
                foreach ($array as $ietm) {
                    if (isset($ietm['result'])) {
                        $ConfirmResult = $ietm["result"];
                    }
                }
                if ($ConfirmResult == 'True') { //pay successfuly
                    $MyTransfer = new TransferProduct($ResNum);
                    if ($invoiceNumber == 1) { //directPayment
                        $resutl = $MyTransfer->UserDirectPAy($traceNumber, $referenceNumber, 'pep', $amount);
                    } else {
                        $resutl = $MyTransfer->UserPay($traceNumber, $referenceNumber, 'pep');
                    }

                    if ($resutl) {
                        $RResult = array('Mony' => Session::get('price'), 'Confirmdate' => date("Y-m-d H:i:s"), 'GateWay' => 'بانک پاسارگاد');
                        Session::put('price', null);
                        Session::put('ResNum', null);
                        $UserInfo = Auth::user();
                        Session::put('basket', null);
                        if ($invoiceNumber == 1) { //directPayment
                            $MySMS = new SmsCenter();
                            $CustomerText = myappenv::CenterName;
                            $CustomerText .= '
                            ' . Auth::user()->Name . ' ' . Auth::user()->Family . ' عزیز اعتبار شما به مبلغ ' . number_format($price) . ' افزایش پیدا کرد';
                            $CustomerText .= '
                             با تشکر از پرداخت شما.';
                            $MySMS->OndemandSMS($CustomerText, Auth::user()->MobileNo, 'tnks', Auth::user()->MobileNo);
                        } else {
                            $MySMS = new SmsCenter();
                            $CustomerText = 'سلام ' . Auth::user()->Name . ' ' . Auth::user()->Family . ' عزیز' . "\n";
                            $CustomerText .= 'سفارش شما به شماره ' . $ResNum . ' با موفقیت ثبت شد.' . "\n";
                            $CustomerText .= 'با تشکر از خرید شما.' . "\n";
                            $CustomerText .= myappenv::CenterName;

                            $MySMS->OndemandSMS($CustomerText, Auth::user()->MobileNo, 'tnks', Auth::user()->MobileNo);
                            $SellerText = 'سلام مدیر سفارش ' . $ResNum . 'با مبلغ ' . number_format($price) . ' در سامانه ثبت شد!';
                            if (myappenv::MainOwner == 'shafatel' || myappenv::MainOwner == 'Carpetour') {
                                $MySMS->OndemandSMS($SellerText, '09126543802', 'tnks', '09126543802');
                            } else {
                                $MySMS->OndemandSMS($SellerText, '09123345580', 'tnks', '09123345580');
                            }
                            $this->AddLog($ResNum);
                            $MySMS->OndemandSMS($SellerText, '09123936105', 'tnks', '09123936105');
                            if (myappenv::MainOwner == 'kookbaz') {
                                $MySMS->OndemandSMS($SellerText, '09125833245', 'tnks', '09125833245');
                                $MySMS->OndemandSMS($SellerText, '09192228284', 'tnks', '09192228284');
                            }
                        }
                        return view("Credit.ConfirmPay", ['Result' => $RResult, 'UserInfo' => $UserInfo]);
                    } else {
                        return abort('404', 'در انجام تراکنش مشکلی پیش آمده لطفا با فروشگاه تماس بگیرید 14693  ');
                    }
                } else { // pay has error

                }
            }
        }
    }

    public function removeItemfrombasket()
    {
    }

    public function newcheckout(Request $request)
    {
        $theme = myappenv::ShopTheme;
        $Tashim = new TashimClass;
        if ($request->ajax()) {
            $Order = new Orders();
            if ($request->has('removeitem')) {
                $MyBuy = new buy();
                $response = $MyBuy->RemoveGoodFromBasket($request->input('removeitem'));
                return $response;
            }
            if ($request->has('clear')) {
                $MyBuy = new buy();
                $MyBuy->RemoveAllFromBasket();
            }
            if ($request->has('page')) {
                $TargetPage = $request->input('page');
                $returnHTML = view("Layouts.$theme.objects.$TargetPage", ['MyProduct' => $this, 'Order' => $Order])->render();
                //return view("Layouts.$theme.objects.$TargetPage", ['MyProduct' => $this, 'Order' => $Order]);
            } else {
                return 'error';
            }
            if ($request->has('page1')) {
                $TargetPage = $request->input('page1');
                $returnHTML .= view("Layouts.$theme.objects.$TargetPage", ['MyProduct' => $this, 'Order' => $Order])->render();
            }
            if ($request->has('page2')) {
                $TargetPage = $request->input('page2');
                $returnHTML .= view("Layouts.$theme.objects.$TargetPage", ['MyProduct' => $this, 'Order' => $Order])->render();
            }
            if ($request->has('page3')) {
                $TargetPage = $request->input('page3');
                $returnHTML .= view("Layouts.$theme.objects.$TargetPage", ['MyProduct' => $this, 'Order' => $Order])->render();
            }
            if ($request->has('page4')) {
                $TargetPage = $request->input('page4');
                $returnHTML .= view("Layouts.$theme.objects.$TargetPage", ['Order' => $Order])->render();
            }
            if ($request->has('page5')) {
                $TargetPage = $request->input('page5');
                $returnHTML .= view("Layouts.$theme.objects.$TargetPage", ['Order' => $Order])->render();
            }
            return ($returnHTML);
        }
        $IsValidTashim = $Tashim->IsValidTashim();
        return view("Layouts.$theme.Checkout", ['MyProduct' => $this, 'IsValidTashim' => $IsValidTashim]);
    }
    public function Donewcheckout(Request $request)
    {
        $MyOrder = new Orders();
        if ($request->input('typesubmit') == 'submit') {
            $payType = 'bank'; // pay from bank
        } elseif ($request->input('typesubmit') == 'PayFromCredit') {
            $payType = 1; // decrease form usercredit
        } elseif ($request->input('typesubmit') == 'SubmitOrder') {
            $payType = 2; //offline sale
        } elseif ($request->input('typesubmit') == 'updatepasket') {
            $MyOrder->update_basket($request->input('productid'), $request->input('qty'));
            return redirect()->back();
        }

        if ($request->input('Location') == 0) {
            // Add new location on finalize Order

            $LocationAtribute = [
                'Shahrestan' => $request->input('Shahrestan'),
                'Province' => $request->input('Province'),
                'recivername' => $request->input('recivername'),
                'reciverphone' => $request->input('reciverphone'),
                'LocationName' => $request->input('LocationName'),
                'Street' => $request->input('Street'),
                'OthersAddress' => $request->input('OthersAddress'),
                'Pelak' => $request->input('Pelak'),
                'PostalCode' => $request->input('PostalCode'),
                'ExtraNote' => $request->input('ExtraNote'),
            ];
            $TargetLocation = $MyOrder->AddnewLocation($LocationAtribute);
        } else {
            $TargetLocation = $request->input('Location');
        }
        $ProductOrderId = $MyOrder->OrderPreSave($TargetLocation);
        Session::put('ResNum', $ProductOrderId);
        $MyOrder->AddOrderItems($ProductOrderId);
        $TashimSession = json_decode(Session::get('Tashim'));
        $MyOrder->SetShepping($request->input('shipping'));
        $shipping = $request->input('shipping');
        switch ($shipping) {
            case 'post_free':
                $Note = 'ارسال رایگان با پست';
                break;
            case 'post':
                $Note = ' ارسال با پست ';
                break;
            case 'ask':
                $Note = 'تحویل حضوری';
                break;
            case 'peyk':
                $Note = 'ارسال با پیک';
                break;

            case 'tipax':
                $Note = 'ارسال با تیپاکس';
                break;

            default:
                $Note = 'هزینه ارسال: ' . $shipping . '';
                break;
        }
        $MyProduct = new product();
        $CurentDate = date('Y-m-d H:i:s');
        $InputArr = ['UserDeliverReport' => Auth::user()->Name . ' ' . Auth::user()->Family . ' ', 'Date' => $CurentDate, 'note' => $Note];
        $MyProduct->AddReport($ProductOrderId, $InputArr);
        $finalyzeresult = $MyOrder->finalyzeProductOrder();
        if ($finalyzeresult == 1) {
            if ($MyOrder->IsValidTashim()) {
                $ResNum = $ProductOrderId;
                // Invoice Number
                if ($payType == 'bank') {
                    return $MyOrder->PayFromIPG();
                } elseif ($payType == 2) {
                    return $MyOrder->PayFromEstelam($ResNum);
                } elseif ($payType == 1) {
                    return $this->ConfirmPay($request, $pay = myappenv::CachCredit, $ResNum);
                }
            } else {
                if (Auth::user()->CreditePlan == '1') {
                    return redirect()->back()->With('error', 'متاسفانه قابلیت این کار را ندارید');
                } else {
                    return redirect()->back()->With('error', 'برای استفاده از این قابلیت می باید حساب کاربری خود را به کاربر ویژه ارتقا دهید!');
                }
            }
        } else {
            return abort('404');
        }
    }

    private function GetDeviceOrder()
    {
        if ($this->DeviceOrder == null) {
            $ContractData = [
                'Owner' => Auth::id(),
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
    public static function GetTargetPrice($InputPrice, $TaxStatus)
    {
        //return price with tax
        if ($TaxStatus == 0) {
            return $InputPrice;
        }
        if ($TaxStatus == 10) {
            $TaxPercent = myappenv::TaxPercent;
            return $InputPrice + ($InputPrice * $TaxPercent / 100);
        }
    }
    public $BenefitTotall = 0;
    public $TOPayTotall = 0;
    public $ItemTotall;

    public function product_in_basket_process($MyOrderTarget)
    {
        $Price = $this->GetTargetPrice(
            $MyOrderTarget['ProductInWarehouse']->Price,
            $MyOrderTarget['Product']->tax_status,
        );
        $BasePrice = $this->GetTargetPrice(
            $MyOrderTarget['ProductInWarehouse']->BasePrice,
            $MyOrderTarget['Product']->tax_status,
        );
        $TashimRes = $this->TashimBlade(
            $MyOrderTarget['Product']->id,
            $MyOrderTarget['ProductInWarehouse']->Price,
            $MyOrderTarget['Product']->tax_status,
        );
        $MinPrice = $this->GetTargetPrice(
            $MyOrderTarget['ProductInWarehouse']->MinPrice,
            $MyOrderTarget['Product']->tax_status,
        );
        $MaxPrice = $this->GetTargetPrice(
            $MyOrderTarget['ProductInWarehouse']->MaxPrice,
            $MyOrderTarget['Product']->tax_status,
        );
        $TotallProductPrice = 0;
        $Estelam = false;
        if ($MyOrderTarget['ProductInWarehouse']->PricePlan == null) {
            if ($MyOrderTarget['ProductInWarehouse']->MinPrice > -1) { //TODO:remove estelam
                if (isset($TashimRes[0]) && $TashimRes[0] != '') {
                    $UnitPrice = $TashimRes[1];
                } else {
                    $UnitPrice = $Price;
                }

                $ItemTotall = $UnitPrice * $MyOrderTarget['ProductQty'];

                $ItemBenefit = $BasePrice * $MyOrderTarget['ProductQty'] - $ItemTotall;

                $this->BenefitTotall += $ItemBenefit;

                $this->TOPayTotall += $ItemTotall;
            } else {
                //estelam
                $Estelam = true;
            }
        } else {
            $ItemTotall =
                $this->GetTargetPriceFromPricePlanJson(
                    $MyOrderTarget['ProductInWarehouse']->PricePlan,
                    $MyOrderTarget['ProductQty'],
                ) * $MyOrderTarget['ProductQty'];
            $ItemBenefit = $BasePrice * $MyOrderTarget['ProductQty'] - $ItemTotall;
            $this->BenefitTotall += $ItemBenefit;
            $this->TOPayTotall += $ItemTotall;
        }

        $TashimResddd = $this->TashimBlade(
            $MyOrderTarget['Product']->id,
            $MyOrderTarget['ProductInWarehouse']->Price,
            $MyOrderTarget['Product']->tax_status,
        );
        $this->ItemTotall = $ItemTotall;



    }



    public function TashimBlade($ProductId, $SaleMony, $TaxStatus = 0)
    {
        // Change Price based on Tashim
        $TashimValues = new TashimVars();
        $MyTashim = new TashimClass();
        $TashimValues->SalePrice = $SaleMony;
        $TashimValues->TaxPrice = ProductClass::GetTargetTax($SaleMony, $TaxStatus);
        $result = 0;
        $TashimSession = json_decode(Session::get('Tashim'));
        $TashimId = null;
        //  'ProductId' => $request->input('ProductId'),
        //'Tashim' => $request->input('Tashim')
        $OutPutResult = 0;
        if ($TashimSession != null) {
            foreach ($TashimSession as $TashimSessionItem) {
                if ($TashimSessionItem->ProductId == $ProductId) {
                    $TashimId = $TashimSessionItem->Tashim;
                    break;
                }
            }
        }
        if ($TashimId != null) {
            $OutPutStr = '';
            $TashimSrc = tashim::where('TashimID', $TashimId)->get();
            foreach ($TashimSrc as $TashimSrcItem) {
                if ($TashimSrcItem->TargetUser == 'buyer') {
                    $OutPutStr .= $TashimSrcItem->Note . ' ';
                    $OutPutStr = ' '; //TODO: handel output to customer
                    $result = $MyTashim->FormulaCalc($TashimSrcItem->FormolStr, $TashimValues);
                    $OutPutResult += $result;
                }
            }
        } else {
            $OutPutStr = null;
        }
        $OutPutResult *= -1;

        return [$OutPutStr, $OutPutResult];
    }
    public function AddLog($OrderID)
    {
        $Products = product_order_items::where('order_id', $OrderID)->get();
        foreach ($Products as $ProductItem) {
            $ProductId = $ProductItem->product_id;
            $pw_id = $ProductItem->pw_id;
            $UserID = Auth::id();
            $SaveData = [
                'ProductID' => $ProductId,
                'WGID' => $pw_id,
                'UserID' => $UserID,
                'ReportType' => 2, // Report count order of product
                'ReportVal' => $OrderID,
            ];
            report_detial::create($SaveData);
        }

        return true;
    }
    public static function IsProductInBasket($ProductID, $WarehouseID)
    {
        $MyOrder = json_decode(Session::get('basket'));
        if ($MyOrder == null) {
            return 0;
        }
        foreach ($MyOrder as $MyOrderItem) {
            if ($MyOrderItem[0] == $ProductID && $MyOrderItem[2] == $WarehouseID) {
                return $MyOrderItem[1];
            }
        }
        return 0;
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
    public function GetBenefitOfBuyItem($ProductId, $ProductQty)
    {
        $ProDuctTarget = warehouse_goods::where('GoodID', $ProductId)->first();
        if ($ProDuctTarget->PricePlan != null) {
            $TotallPrice = $this->GetTargetPriceFromPricePlanJson($ProDuctTarget->PricePlan, $ProductQty);
            $TotallBasePrice = $ProDuctTarget->BasePrice * $ProductQty;
            return $TotallBasePrice - $TotallPrice;
        } else {
            $TotallPrice = $ProDuctTarget->Price * $ProductQty;
            $TotallBasePrice = $ProDuctTarget->BasePrice * $ProductQty;
            return $TotallBasePrice - $TotallPrice;
        }
    }
    public static function GetJsonFeild($Json, $element)
    {
        $TextArr = json_decode($Json);
        if (json_last_error() === 0) {
            if (isset($TextArr->$element)) {
                $TextArr = $TextArr->$element;
            } else {
                $TextArr = '';
            }

            return $TextArr;
        } else {
            if ($element == 'MainText') {
                return $Json;
            } else {
                return '';
            }
        }
    }
    public function get_product_plan_array($PricePlan)
    {
        $result = json_decode($PricePlan);
        return $result;
    }
    public function GetTargetPriceFromPricePlan($PricePlan, $Qty)
    {
        if (!is_array($PricePlan)) {
            if (isJson($PricePlan)) {
                $PricePlan = json_decode($PricePlan);
            }
        }

        foreach ($PricePlan as $PricePlanTarget) {
            if ($Qty != 'max') {
                if ($PricePlanTarget->ToNumber > $Qty) {
                    return $PricePlanTarget->Price;
                }
            }
        }
        return $PricePlanTarget->Price;

    }
    public function GetTargetUnitFromUnitPlan($UnitPlan, $Qty)
    {
        $OutPut = null;
        foreach ($UnitPlan as $UnitPlanTarget) {
            if ($UnitPlanTarget->multiple <= $Qty) {
                $OutPut = [
                    'Multiple' => $UnitPlanTarget->multiple,
                    'UnitName' => $UnitPlanTarget->UnitName,
                    'img' => $UnitPlanTarget->img,
                ];
            }
        }
        return $OutPut;
    }
    public function GetTargetBasePriceFromPricePlan($PricePlan, $Qty)
    {
        $Output = '';
        foreach ($PricePlan as $PricePlanTarget) {
            if ($PricePlanTarget->ToNumber > $Qty) {
                return $Output;
            } else {
                $Output .= '<del id="Modal_product_base_price" class="formola_break text-secondary"> ' . number_format($PricePlanTarget->Price) . ' ریال</del>';
            }
        }
    }
    public function GetTargetUnitFromUnitPlanJson($UnitPlan, $Qty)
    {
        return $this->GetTargetUnitFromUnitPlan(json_decode($UnitPlan), $Qty);
    }

    public function GetTargetPriceFromPricePlanJson($PricePlan, $Qty)
    {
        return $this->GetTargetPriceFromPricePlan(json_decode($PricePlan), $Qty);
    }
    public function GetTargetBasePriceFromPricePlanJson($PricePlan, $Qty)
    {
        return $this->GetTargetBasePriceFromPricePlan(json_decode($PricePlan), $Qty);
    }
    public function GetProductPrice($ProductWHId, $Qty)
    {
        $Product = warehouse_goods::where('id', $ProductWHId)->first();
        $PricePlan = $Product->PricePlan;
        $PricePlan = json_decode($PricePlan);
        return $this->GetTargetPriceFromPricePlan($PricePlan, $Qty);
    }
    public static function GetMaxPrice($InputArray)
    {
        if (!is_array($InputArray)) {
            $InputArray = json_decode($InputArray);
        }

        $Output = 0;
        foreach ($InputArray as $InputArrayTarget) {
            if ($InputArrayTarget->Price > $Output) {
                $Output = $InputArrayTarget->Price;
            }
        }
        return $Output;
    }
    public static function GetMinPrice($InputArray)
    {
        if (!is_array($InputArray)) {
            $InputArray = json_decode($InputArray);
        }
        $Output = 10000000000000;
        foreach ($InputArray as $InputArrayTarget) {
            if ($InputArrayTarget->Price < $Output) {
                $Output = $InputArrayTarget->Price;
            }
        }
        return $Output;
    }

    public static function GetPostDleverBarcode($status_history)
    {
        $status_history = json_decode($status_history);
        foreach ($status_history as $status_history_target) {
            return $status_history_target->Tapin_barcode;
            if (array_key_exists('Tapin_barcode', $status_history_target)) {
                return ($status_history_target->Tapin_barcode);
            }
        }
    }
    public static function GetPostDleverID($status_history)
    {
        $status_history = json_decode($status_history);

        foreach ($status_history as $status_history_target) {
            return $status_history_target->Topin_order_id;
        }
    }
    public function CheckOrderHasOffline($OrderID, $OrderSurce)
    {

        /**
         * check order has offline invoice or not
         * input : OrderID or $Order Source
         *
         * return 0 is not has offline
         * return 1 is has not set offline invoice
         * return 2 is has active offline invoice
         * return 3 is has prepayed offline order
         * return 4 is has peyde offline order
         */
        if ($OrderID != null) {
            $OrderSurce = product_order::where('id', $OrderID)->first();
        }
        if ($OrderSurce->DeviceContract == null || $OrderSurce->DeviceContract == $OrderSurce->id) {
            return 0;
        } else {
            $DiviceContract = DeviceContract::where('ContractID', $OrderSurce->DeviceContract)->first();
            switch ($DiviceContract->Status) {
                case 0:
                    return 1;
                    break;
                case 1:
                    return 2;
                    break;
                case 50:
                    return 3;
                    break;
                case 100:
                    return 4;
                    break;
                default:
                    return false;
            }
        }
    }
    public function EditOrder($OrderID, $type = null)
    {
        if ($type == 'service') {
            $PatiantService = new PatiantServices;
            return $PatiantService->EditOrder($OrderID);
        }
        if (Auth::user()->Role == myappenv::role_SuperAdmin || Auth::user()->Role == myappenv::role_ShopAdmin) {
            $UserType = 'SuperAdmin';
        } else {
            $UserType = 'Seller';
        }
        if ($UserType != 'SuperAdmin') { // check if broduct related to user
            $UserBranch = Auth::user()->branch;
            $OrderBranch = branchs_order::where('branch', $UserBranch)->where('order_id', $OrderID)->first();
            if ($OrderBranch == null) {
                return abort('404', 'لینک مورد نظر وجود ندارد');
            }
        }
        $UserPoint = UserPoint::where('UserName', Auth::id())->where('ConfirmUser', '!=', null)->sum('Point');

        /* $Tapin = new Tapin();
        if (myappenv::TopenShopID != null) {
            $TopinCredit = $Tapin->GetShopCredit();
        } else {
            $TopinCredit = null;
        }
        */
        $TopinCredit = 0;

        $ProductOrder = product_order::where('id', $OrderID)->first();
        $Offlinecheck = $this->CheckOrderHasOffline(null, $ProductOrder);
        $locations = locations::where('id', $ProductOrder->SendLocation)->first();
        $Customer = UserInfo::where('UserName', $ProductOrder->CustomerId)->first();
        $Operator = UserInfo::where('UserName', $ProductOrder->Operator)->first();
        if ($Operator != null) {
            $Operator = $Operator->Name . ' ' . $Operator->Family;
        }

        $Query = "SELECT  poi.* , g.NameFa ,g.ImgURL,g.SKU,tashims.Name,warehouses.Name as wname from product_order_items poi  inner join goods g on poi.product_id  = g.id  INNER JOIN warehouse_goods on poi.pw_id = warehouse_goods.id INNER JOIN warehouses on warehouse_goods.WarehouseID = warehouses.id  LEFT join tashims on poi.Tashim = tashims.TashimID  and tashims.ItemOrder = 0 where poi.order_id = $OrderID";
        $ProductOrderItem = DB::select($Query);
        $PriceToPoint = SettingManagement::GetSettingValue('number_to_point');
        if (isset($PriceToPoint) && $PriceToPoint > 0) {
            $Point = $ProductOrder->total_sales / $PriceToPoint;
        } else {
            $Point = 0;
        }

        $CurentPoint = UserPoint::where('Work', $OrderID)->first();

        return view('woocommerce.admin.EditOrder', ['Offlinecheck' => $Offlinecheck, 'UserType' => $UserType, 'CurentPoint' => $CurentPoint, 'Point' => $Point, 'UserPoint' => $UserPoint, 'TopinCredit' => $TopinCredit, 'locations' => $locations, 'ProductOrder' => $ProductOrder, 'ProductOrderItem' => $ProductOrderItem, 'Customer' => $Customer, 'Operator' => $Operator]);
    }

    public function AddOrderHistory($OrderID, $InputArr, $Status)
    {
        $TargetOrder = product_order::where('id', $OrderID)->first();
        $TargetStatus = array();
        if ($TargetOrder->status_history != null) {
            $TargetStatus = json_decode($TargetOrder->status_history);
        }
        array_push($TargetStatus, $InputArr);
        $TargetStatus = json_encode($TargetStatus);
        $UpdateData = [
            'status_history' => $TargetStatus,
            'status' => $Status,
        ];
        product_order::where('id', $OrderID)->update($UpdateData);
        return true;
    }
    public function AddReport($OrderID, $InputArr)
    {
        $TargetOrder = product_order::where('id', $OrderID)->first();
        $TargetStatus = array();
        if ($TargetOrder->extra != null) {
            $TargetStatus = json_decode($TargetOrder->extra);
        }
        array_push($TargetStatus, $InputArr);
        $TargetStatus = json_encode($TargetStatus);
        $UpdateData = [
            'extra' => $TargetStatus,
        ];
        product_order::where('id', $OrderID)->update($UpdateData);
        return true;
    }

    public function DoEditOrder(Request $request, $OrderID, $type = null)
    {
        if ($request->ajax()) {

            $procedure = $request->procedure;
            if ($procedure == 'defineoperator') {
                $OrderID = $OrderID;
                $OrderSRC = product_order::where('id', $OrderID)->first();
                if ($OrderSRC == null) {
                    return false;
                }
                $ProductOrder = product_order::where('id', $OrderID)->update(['Operator' => $request->UserName, 'Manager' => Auth::id()]);
                $OrderSRCnew = product_order::where('id', $OrderID)->first();
                $OwnerSrc = UserInfo::where('UserName', $OrderSRCnew->Operator)->first();
                $ownerusername = $OwnerSrc->Name . ' ' . $OwnerSrc->Family;

                return $ownerusername;
            }
        }
        if ($request->has('getownerinfo')) {
            $TargetUser = UserInfo::where('UserName', $request->getownerinfo)->first();
            return $TargetUser->Name . ' ' . $TargetUser->Family;
        }
        if ($type == 'service') {
            $TargetOrder = product_order::where('ServiceContract', $OrderID)->first();
            if ($TargetOrder == null) {
                return abort('سفارش درخواست شده موجود نمی باشد!');
            }
            $service_id = $OrderID;
            $OrderID = $TargetOrder->id;
        } else {
            $TargetOrder = product_order::where('id', $OrderID)->first();
        }

        if ($request->input('submit') == 'Saveprint') {
            $Query = "SELECT  poi.* , g.NameFa ,(poi.main_unit_price - poi.unit_price) as UniDef,g.ImgURL,tashims.Name from product_order_items poi  inner join goods g on poi.product_id  = g.id   LEFT join tashims on poi.Tashim = tashims.TashimID  and tashims.ItemOrder = 0 where poi.order_id = $OrderID";
            $TargetproductOrder = DB::select($Query);
            $TargetUser = UserInfo::where('UserName', $request->input('UserName'))->first();
            $TargetOrder = product_order::where('id', $OrderID)->first();
            $TavanSrc = UserCredit::where('UserName', $TargetUser->UserName)->where('CreditMod', 3)->where('InvoiceNo', $OrderID)->get();
            /*        $MyReport = new Reports();
            $Estelam = $MyReport->Estelam($TargetUser->MelliID);
            if ($Estelam == 'notvalid') {
            return 'notvalid';
            } else {
            $TavanMAx = $Estelam->tavg;

            } */
            $pdf = PDF::loadView("Print.PrintKasrAzHoghgh", ['TavanSrc' => $TavanSrc, 'TargetOrder' => $TargetOrder, 'TargetproductOrder' => $TargetproductOrder, 'TargetUser' => $TargetUser, 'OrderID' => $OrderID]);
            return $pdf->download('KasrAzHoghgh.pdf');
        }
        if ($request->input('submit') == "SendSms") {
            if (myappenv::Lic['send_custom_sms']) {
                $request->validate([
                    "MessageText" => ['required', 'min:5'],
                ], [
                    'MessageText.required' => __("fill feild ") . __('SMS') . __(" is requird!"),
                    'MessageText.min' => __("The chars of feild ") . __('SMS') . __(" Less than limet!"),

                ]);
                $MessageText = $request->input('MessageText');
                $Mysms = new SmsCenter();
                $TargetUser = UserInfo::where("UserName", $RequestUser)->first();
                $Mysms->OndemandSMS($MessageText, $TargetUser->MobileNo, 'SystemUA', Auth::id());
                return redirect()->back()->with("success", __('sms was send!!'));
            } else {
                return redirect()->back()->with("lic_error", __("You have not permission for this function!"));
            }
        }
        if ($request->input('submit') == 'CancelOrder') {

            $CancleOrder = new Orderback();
            $OrderAtribute = [
                'OrderID' => $OrderID,
                'UserName' => $request->input('UserName'),
                'MobileNumber' => $request->input('MobileNo'),

            ];
            $OutPut = $CancleOrder->Cancel_Order($OrderAtribute);
            $CurentDate = date('Y-m-d H:i:s');
            $InputArr = ['UserREport' => Auth::user()->Name . '' . Auth::user()->Family, 'Date' => $CurentDate, 'note' => 'لغو سفارش      '];
            $this->AddReport($OrderID, $InputArr);

            return redirect()->back()->with('success', 'لغو سفارش انجام شد   ');
        }
        /**
         * This function use to set point 1-5 from order and snd sms to user
         *
         *
         */
        if ($request->input('submit') == "SendPoint") {
        }

        if ($request->input('submit') == 'savereport') {
            $Note = $request->input('Report');
            if ($Note == null) {
                return redirect()->back()->with('error', ' امکان ارسال گزارش به صورت خالی وجود ندارد');
            }

            $CurentDate = date('Y-m-d H:i:s');
            $InputArr = ['UserREport' => Auth::user()->Name . '' . Auth::user()->Family, 'Date' => $CurentDate, 'note' => $Note];
            $this->AddReport($OrderID, $InputArr);
            return redirect()->back()->with('success', '  گزارش با موفقیت ثبت شد!');
        }
        if ($request->has('submit')) {
            if ($request->input('submit') == 'Delete') {
                product_order::where('id', $OrderID)->delete();
                product_order_items::where('order_id', $OrderID)->delete();
                return redirect()->route('FaildBuy')->with('حذف سفارش انجام گرفت!');
            }
        }
        if ($request->has('AddPoint')) {
            $Point = $request->input('AddPoint');
            $PointData = [
                'UserName' => $request->input('UserName'),
                'Point' => $Point,
                'CreateDate' => now(),
                'Work' => $OrderID,
                'CreatedUser' => Auth::id(),
                'ConfirmUser' => Auth::id(),
                'ConfirmDate' => now(),
                'Note' => '',
                'status' => 3, // for product buy
            ];
            UserPoint::create($PointData);
            return redirect()->back()->with('success', 'امتیاز اعمال شد!');
        }

        if ($request->has('DellPoint')) {
            $PointId = $request->input('DellPoint');
            UserPoint::where('id', $PointId)->delete();
            return redirect()->back()->with('success', 'امتیاز حذف شد!');
        }
        if ($request->has('UserInfo')) {
            $UserInfoData = [
                $request->input('UserInfo') => $request->input($request->input('UserInfo')),
            ];
            UserInfo::where('UserName', $request->input('UserName'))->update($UserInfoData);
            return redirect()->back()->with('success', 'مشخصات کاربر به روز شد!');
        }
        if ($request->has('changestate')) {
            $Data = [
                'status' => $request->input('changestate'),
            ];
            product_order::where('id', $OrderID)->update($Data);
            switch ($request->input('changestate')) {
                case 10: // Dar Daste eghdam
                    $FeildName = 'SMS_DDE';
                    $CurentDate = date('Y-m-d H:i:s');
                    $UpdateUser = ['Userupdate' => Auth::user()->Name . ' ' . Auth::user()->Family, 'Date' => $CurentDate, 'status' => 10];
                    $this->AddOrderHistory($OrderID, $UpdateUser, 10);
                    break;
                case 20: // Ersal be anbar
                    $FeildName = 'SMS_EBA';
                    $CurentDate = date('Y-m-d H:i:s');
                    $UpdateUser = ['Userupdate' => Auth::user()->Name . '' . Auth::user()->Family, 'Date' => $CurentDate, 'status' => 20];
                    $this->AddOrderHistory($OrderID, $UpdateUser, 20);

                    break;
                case 30: //Dar hale baste bandi
                    $FeildName = 'SMS_DHBB';
                    $CurentDate = date('Y-m-d H:i:s');
                    $UpdateUser = ['Userupdate' => Auth::user()->Name . '' . Auth::user()->Family, 'Date' => $CurentDate, 'status' => 30];
                    $this->AddOrderHistory($OrderID, $UpdateUser, 30);
                    break;
                case 40: //Ersal be post
                    $FeildName = 'SMS_EBP';
                    $FeildName = 'SMS_DHBB';
                    $CurentDate = date('Y-m-d H:i:s');
                    $UpdateUser = ['Userupdate' => Auth::user()->Name . '' . Auth::user()->Family, 'Date' => $CurentDate, 'status' => 40];
                    $this->AddOrderHistory($OrderID, $UpdateUser, 40);
                    break;
                case 70: //tahvil be moshtari
                    $FeildName = 'SMS_TBM';
                    $CurentDate = date('Y-m-d H:i:s');
                    $UpdateUser = ['Userupdate' => Auth::user()->Name . '' . Auth::user()->Family, 'Date' => $CurentDate, 'status' => 70];
                    $this->AddOrderHistory($OrderID, $UpdateUser, 70);
                    break;
                case 60: //enserfa
                    $FeildName = 'SMS_ENS';
                    $CurentDate = date('Y-m-d H:i:s');
                    $UpdateUser = ['Userupdate' => Auth::user()->Name . '' . Auth::user()->Family, 'Date' => $CurentDate, 'status' => 60];
                    $this->AddOrderHistory($OrderID, $UpdateUser, 60);
                    break;
                case 80: //Bill registration
                    $FeildName = 'SMS_bill';
                    $CurentDate = date('Y-m-d H:i:s');
                    $UpdateUser = ['Userupdate' => Auth::user()->Name . '' . Auth::user()->Family, 'Date' => $CurentDate, 'status' => 80];
                    $this->AddOrderHistory($OrderID, $UpdateUser, 80);
                    break;
                case 90: //tahvil
                    $FeildName = 'SMS_Rec';
                    $CurentDate = date('Y-m-d H:i:s');
                    $UpdateUser = ['Userupdate' => Auth::user()->Name . '' . Auth::user()->Family, 'Date' => $CurentDate, 'status' => 90];
                    $this->AddOrderHistory($OrderID, $UpdateUser, 90);
                    $Point = new Points();
                    $PointAttr = [
                        'OrderID' => $OrderID,
                        'UserName' => $request->input('UserName'),
                        'MobileNumber' => $request->input('MobileNo'),

                    ];
                    $OutPut = $Point->ReservePoint($PointAttr);
                    $CurentDate = date('Y-m-d H:i:s');
                    $InputArr = ['UserREport' => Auth::user()->Name . '' . Auth::user()->Family, 'Date' => $CurentDate, 'note' => 'ارسال پیامک نظرسنجی به مشتری  '];
                    $this->AddReport($OrderID, $InputArr);
                    $myindex = new Indexes;
                    $myindex->assign_index_to_customer_by_order($OrderID);
                    return redirect()->back()->with('success', 'پیامک با موفقیت ارسال شد');
                    break;
                default:
                    $FeildName = null;
            }
            if ($FeildName != null) {
                $SettingSrc = CacheData::GetSetting($FeildName);
                if ($SettingSrc != null) {
                    // if field set
                    if ($SettingSrc == '' || $SettingSrc == '0' || $SettingSrc == null) {

                        // is not set text
                    } else {
                        $CustomerName = $request->input('Name') . ' ' . $request->input('Family');
                        $SMSMainText = $SettingSrc;
                        $SMSMainText = str_replace("%Name%", ' ' . $CustomerName . ' ', $SMSMainText);
                        $SMSMainText = str_replace("%Factor%", ' ' . $OrderID . '', $SMSMainText);
                        $MobileNo = $request->input('MobileNo');
                        $MySMS = new SmsCenter();
                        $MySMS->OndemandSMS($SMSMainText, $MobileNo, 'chstate', $MobileNo);
                    }
                }
            }

            return redirect()->back()->with('success', ' وضعیت سفارش به روز شد!');
        }
        if ($request->has('location')) {
            $UserlocationData = [
                $request->input('location') => $request->input($request->input('location')),
            ];
            locations::where('id', $request->input('locationid'))->update($UserlocationData);
            return redirect()->back()->with('success', ' محل تحویل به روز شد!');
        }
        if ($request->has('updatewiget')) {
            $OrderItems = $request->input('weight');
            $Totalw = 0;
            foreach ($OrderItems as $OrderItem => $value) {
                product_order_items::where('id', $OrderItem)->update(['weight' => $OrderItems[$OrderItem]]);
                $Totalw += $OrderItems[$OrderItem];
            }
            product_order::where('id', $OrderID)->update(['weight' => $Totalw]);
            return redirect()->back()->with('success', '  وزن محصولات به روز شد!');
        }
        if ($request->has('changeweight')) {
            product_order::where('id', $OrderID)->update(['weight' => $request->input('Totallweight')]);
            return redirect()->back()->with('success', '  وزن مرسوله به روز شد!');
        }
        if ($request->has('delever')) {
            if ($request->input('delever') == 'tapin') {
                $Tapin = new Tapin();
                $price = $request->input('Totall_price');
                $weight = $request->input('Totallweight');
                $address = $request->input('Totall_address');
                $city_code = $request->input('Totall_city_code');
                $province_code = $request->input('Totall_province_code');
                $first_name = $request->input('Name');
                $last_name = $request->input('Family');
                $mobile = $request->input('MobileNo');
                $box_id = $request->box_id;
                $postal_code = $request->input('PostalCode');
                $package_weight = $request->input('Totallweight');
                $DeleverResult = $Tapin->SendOrderToTapin($price, $weight, $address, $city_code, $province_code, $first_name, $last_name, $mobile, $postal_code, $package_weight, $OrderID, $box_id);
                if (isset($DeleverResult->entries->barcode)) {
                    $CurentDate = date('Y-m-d H:i:s');
                    $UpdateData = ['Tapin_barcode' => $DeleverResult->entries->barcode, 'Tapin_id' => $DeleverResult->entries->id, 'Topin_order_id' => $DeleverResult->entries->order_id, 'Date' => $CurentDate];
                    $this->AddOrderHistory($OrderID, $UpdateData, 50);
                    return redirect()->back()->with('success', 'ثبت در تاپین با موفقیت انجام گرفت');
                } else {
                    return redirect()->back()->with('error', 'اختلال در پاسخ دهنده' . ' ' . $DeleverResult->returns->message);
                }
            } else { // Delever contian Post ID
                $Tapin = new Tapin();
                $Result = $Tapin->change_status($request->input('delever'), 1);
                if (isset($Result->entries->barcode)) {
                    $CurentDate = date('Y-m-d H:i:s');
                    $InputArr = ['Tapin_Final_barcode' => $Result->entries->barcode, 'Date' => $CurentDate];
                    $this->AddOrderHistory($OrderID, $InputArr, 51);
                    return redirect()->back()->with('success', 'ارسال به تاپین با موفقیت انجام گرفت');
                } else {
                    $ErrorResult = '';
                    foreach ($Result->returns as $target) {
                        $ErrorResult .= $target . ' ';
                    }
                    return redirect()->back()->with('error', 'اختلال در پاسخ دهنده' . $ErrorResult);
                }
            }
        }
    }
    public function OpenOrders()
    {

        if (Auth::user()->Role == myappenv::role_ShopOwner) {
            $UserBranch = Auth::user()->branch;
            $Query = "SELECT po.*,ui.Name as customername, ui.Family as customerfamily from product_orders po inner join UserInfo ui on po.CustomerId = ui.UserName INNER JOIN branchs_orders AS bo ON bo.order_id = po.id and bo.branch = $UserBranch WHERE po.status > 0 AND po.status < 100 ORDER BY po.id DESC";
        } else {
            $Query = "SELECT po.*, ui.Name  as customername , ui.Family as customerfamily from product_orders po inner join UserInfo ui on po.CustomerId  = ui.UserName WHERE po.status > 0 AND po.status  < 100 ORDER BY po.id DESC";
        }

        $OpenOrder = DB::select($Query);
        return view('woocommerce.admin.OpenOrders', ['OpenOrder' => $OpenOrder]);
    }
    public function DoOpenOrders(Request $request)
    {
        if ($request->ajax()) {

            if ($request->procedure == 'reciveorder') {

                if (Auth::user()->Role == myappenv::role_ShopOwner) {
                    $UserBranch = Auth::user()->branch;
                    $Query = "SELECT po.*,ui.Name as customername, ui.Family as customerfamily from product_orders po inner join UserInfo ui on po.CustomerId = ui.UserName INNER JOIN branchs_orders AS bo ON bo.order_id = po.id and bo.branch = $UserBranch WHERE po.status = 70 or po.status = 80 ORDER BY po.id DESC";
                } else {
                    $Query = "SELECT po.*, ui.Name  as customername , ui.Family as customerfamily , ui.MobileNo from product_orders po inner join UserInfo ui on po.CustomerId  = ui.UserName WHERE po.status = 70 or po.status = 80 ORDER BY po.id DESC";
                }

                $reciveOrder = DB::select($Query);
                return view('woocommerce.admin.ListofReciveOrders', ['reciveOrder' => $reciveOrder])->render();
            }
            if ($request->procedure == 'cancelorder') {

                if (Auth::user()->Role == myappenv::role_ShopOwner) {
                    $UserBranch = Auth::user()->branch;
                    $Query = "SELECT po.*,ui.Name as customername, ui.Family as customerfamily from product_orders po inner join UserInfo ui on po.CustomerId = ui.UserName INNER JOIN branchs_orders AS bo ON bo.order_id = po.id and bo.branch = $UserBranch WHERE po.status = 60 ORDER BY po.id DESC";
                } else {
                    $Query = "SELECT po.*, ui.Name  as customername , ui.Family as customerfamily , ui.MobileNo from product_orders po inner join UserInfo ui on po.CustomerId  = ui.UserName WHERE po.status = 60 ORDER BY po.id DESC";
                }

                $OpenOrder = DB::select($Query);
                return view('woocommerce.admin.ListofCancelOrders', ['OpenOrder' => $OpenOrder])->render();
            }
            if ($request->procedure == 'openorder') {


                if (Auth::user()->Role == myappenv::role_ShopOwner) {
                    $UserBranch = Auth::user()->branch;

                    $Query = "SELECT po.*,ui.Name as customername, ui.Family as customerfamily , ui.MobileNo  from product_orders po inner join UserInfo ui on po.CustomerId = ui.UserName INNER JOIN branchs_orders AS bo ON bo.order_id = po.id and bo.branch = $UserBranch WHERE po.status > 0 AND po.status < 40 and po.id = po.DeviceContract  ORDER BY po.id DESC";
                } else {
                    $Query = "SELECT po.*, ui.Name  as customername , ui.Family as customerfamily , ui.MobileNo from product_orders po inner join UserInfo ui on po.CustomerId  = ui.UserName WHERE po.status > 0 AND po.status  < 40   and po.id = po.DeviceContract ORDER BY po.id DESC";
                }

                $OpenOrder = DB::select($Query);


                return view('woocommerce.admin.ListofOpenOrders', ['OpenOrder' => $OpenOrder])->render();
            }
            if ($request->procedure == 'DoneOrder') {
                if (Auth::user()->Role == myappenv::role_ShopOwner) {
                    $UserBranch = Auth::user()->branch;
                    $DoneQuery = "SELECT po.*,ui.Name as customername, ui.Family as customerfamily , ui.MobileNo from product_orders po inner join UserInfo ui on po.CustomerId = ui.UserName INNER JOIN branchs_orders AS bo ON bo.order_id = po.id and bo.branch = $UserBranch WHERE po.status = 100 or po.status = 90 ORDER BY po.id DESC";
                } else {
                    $DoneQuery = "SELECT po.*, ui.Name  as customername , ui.Family as customerfamily , ui.MobileNo from product_orders po inner join UserInfo ui on po.CustomerId  = ui.UserName WHERE po.status = 100 or po.status = 90 ORDER BY po.id DESC";
                }

                $DoneOrder = DB::select($DoneQuery);
                return view('woocommerce.admin.ListoDoneOrders', ['DoneOrder' => $DoneOrder])->render();
            }
            if ($request->procedure == 'SendOrder') {
                if (Auth::user()->Role == myappenv::role_ShopOwner) {
                    $UserBranch = Auth::user()->branch;
                    $SendQuery = "SELECT po.*,ui.Name as customername, ui.Family as customerfamily, ui.MobileNo from product_orders po inner join UserInfo ui on po.CustomerId = ui.UserName INNER JOIN branchs_orders AS bo ON bo.order_id = po.id and bo.branch = $UserBranch WHERE po.status = 40 ORDER BY po.id DESC";
                } else {
                    $SendQuery = "SELECT po.*, ui.Name  as customername , ui.Family as customerfamily , ui.MobileNo from product_orders po inner join UserInfo ui on po.CustomerId  = ui.UserName WHERE po.status = 40 or po.status = 50 ORDER BY po.id DESC";
                }

                $DoneOrder = DB::select($SendQuery);
                return view('woocommerce.admin.ListofSendOrders', ['DoneOrder' => $DoneOrder])->render();
            }
            if ($request->procedure == 'showEstelam') {
                if (Auth::user()->Role == myappenv::role_ShopOwner) {
                    $UserBranch = Auth::user()->branch;
                    $OpenOrder = "SELECT po.*,ui.Name as customername, ui.Family as customerfamily , ui.MobileNo from product_orders po inner join UserInfo ui on po.CustomerId = ui.UserName INNER JOIN branchs_orders AS bo ON bo.order_id = po.id and bo.branch = $UserBranch WHERE po.status > 0 AND po.status  < 100  AND po.status  != 60  AND po.status  != 70  and  po.id != po.DeviceContract  ORDER BY po.id DESC";
                } else {
                    $OpenOrder = "SELECT po.*, ui.Name  as customername , ui.Family as customerfamily , ui.MobileNo from product_orders po inner join UserInfo ui on po.CustomerId  = ui.UserName WHERE po.status > 0 AND po.status  < 100  AND po.status  != 60  AND po.status  != 70  and  po.id != po.DeviceContract  ORDER BY po.id DESC";
                }

                $OpenOrder = DB::select($OpenOrder);
                return view('woocommerce.admin.ListofEstelam', ['OpenOrder' => $OpenOrder])->render();
            }
        }

        $Query = "SELECT po.id as OrderID ,  ui.MobileNo as MobileNo , ui.UserName as UserName  from product_orders po inner join UserInfo ui on po.CustomerId  = ui.UserName WHERE po.status = 70  and  (po.DeviceContract is null or  po.id = po.DeviceContract)";
        $OpenOrderResult = DB::select($Query);
        $Point = new Points();
        if ($request->input('submit') == "SendPointAll") {

            foreach ($OpenOrderResult as $OpenOrderResult) {
                $PointAttr = [
                    'OrderID' => $OpenOrderResult->OrderID,
                    'UserName' => $OpenOrderResult->UserName,
                    'MobileNumber' => $OpenOrderResult->MobileNo,

                ];

                $OutPut = $Point->ReservePoint($PointAttr, 1);
                $CurentDate = date('Y-m-d H:i:s');
                $InputArr = ['UserREport' => Auth::user()->Name . '' . Auth::user()->Family, 'Date' => $CurentDate, 'note' => 'ارسال پیامک نظرسنجی به مشتری  '];
                $this->AddReport($OpenOrderResult->OrderID, $InputArr);
            }
            $SendallSms = $Point->SendAllSMS();
            return redirect()->back()->with('success', 'پیامک با موفقیت ارسال شد');
        }
    }

    public function BranchOrders(Request $request)
    {
        //  $mysta = new Statistics();
        // $statdata = $mysta->Product_Statistic(5,3,1);
        // dd($statdata);

        $mysta = new Statistics();
        $Query = "SELECT
        po.id,
        po.status,
        w.Name,
        w.Phone,
        goods.NameFa,
        goods.id as goodid,
        po.CustomerId,
        UserInfo.Name as customername,
        UserInfo.Family as customerfamily,
        UserInfo.MobileNo ,
        poi.unit_Price,
        poi.unit_sales,
        po.created_at
    FROM
        product_orders as po
        INNER JOIN product_order_items as poi on po.id = poi.order_id
        INNER JOIN warehouse_goods as wg on wg.id = poi.pw_id
        INNER JOIN warehouses as w on w.id = wg.WarehouseID
        INNER JOIN goods ON poi.product_id = goods.id
        INNER JOIN UserInfo on UserInfo.UserName = po.CustomerId
    WHERE
    po.status != 60
            and po.status != 0
        and po.DeviceContract = po.id

    ORDER BY
        `po`.`id` DESC";

        $SumQuery = "SELECT

        w.Name,
        w.Phone,
        SUM(wg.BuyPrice) as sum
    FROM
        product_orders as po
        INNER JOIN product_order_items as poi on po.id = poi.order_id
        INNER JOIN warehouse_goods as wg on wg.id = poi.pw_id
        INNER JOIN warehouses as w on w.id = wg.WarehouseID
        INNER JOIN goods ON poi.product_id = goods.id
        INNER JOIN UserInfo on UserInfo.UserName = po.CustomerId

    WHERE
    po.status != 60
            and po.status != 0
        and po.DeviceContract = po.id


   GROUP by w.Name
    ORDER BY
        `po`.`id` DESC";

        $BranchOrders = DB::select($Query);
        $BranchOrdersSum = DB::select($SumQuery);
        return view('woocommerce.admin.BranchOrders', ['mysta' => $mysta, 'BranchOrders' => $BranchOrders, 'BranchOrdersSum' => $BranchOrdersSum]);
    }
    public function DoBranchOrders(Request $request)
    {
    }

    public function KPI(Request $request)
    {
        //  $mysta = new Statistics();
        // $statdata = $mysta->Product_Statistic(5,3,1);
        // dd($statdata);
        $ShamsiEnd = '';
        $ShamsiStart = '';

        $TargetUserInfo = UserInfo::where('Role', 81)->orWhere('Role', 100)->get();


        if ($request->ajax()) {

            if ($request->has('page')) {
                if ($request->page == 'userstatistic') {
                    $mysta = new Statistics();
                    $statdata = $mysta->get_user_statistic();
                    $statdata = json_encode($statdata);
                    return $statdata;
                }
                if ($request->page == 'productstatisic') {
                    $mysta = new Statistics();
                    $statdata = $mysta->Product_Statistic();
                    $statdata = json_encode($statdata);
                    return $statdata;
                }
                if ($request->page == 'storestatistic') {

                    $mysta = new Statistics();

                    $statdata = $mysta->get_store_statistics();

                    $statdata = json_encode($statdata);
                    return $statdata;
                }
            } else {
                return 'error';
            }
        }
        $Mystat = new Statistics();

        return view('woocommerce.admin.KPI', ['TargetUserInfo' => $TargetUserInfo, 'ShamsiStart' => $ShamsiStart, 'ShamsiEnd' => $ShamsiEnd, 'ShowMod' => 'Search', 'Mystat' => $Mystat]);
    }
    public function DoKPI(Request $request)
    {

        $Mystat = new Statistics();
        $ShamsiEnd = '';
        $ShamsiStart = '';
        if ($request->input('submit') == 'Search') {

            $MyDate = new persian();
            if ($request->input('StartDate') != null) {
                $StartDate = $MyDate->MiladiDate($request->input('StartDate'));
                $ShamsiStart = $request->input('StartDate');
            }

            if ($request->input('EndDate') != null) {
                $EndDate = $MyDate->MiladiDate($request->input('EndDate'));
                $ShamsiEnd = $request->input('EndDate');
            }
            if ($request->input('UserName') != null) {
                $UserName = $request->input('UserName');
            } else {
                $UserName = null;
            }

            return view('woocommerce.admin.KPI', ['UserName' => $UserName, 'ShamsiStart' => $ShamsiStart, 'ShamsiEnd' => $ShamsiEnd, 'ShowMod' => 'List', 'Mystat' => $Mystat, 'EndDate' => $EndDate, 'StartDate' => $StartDate]);
        }
    }

    public static function GetProductCats($L1ID = null, $LimitRow = null)
    {
        if (debuger::DebugEnable()) {
            $ItemName = 'MainMenuT';
        } else {
            $ItemName = 'MainMenu';
        }
        $MainMenu = CacheData::GetSetting($ItemName);
        if ($MainMenu == null) {
            $MainMenuData = [
                'WorkCat' => myappenv::MainCats['WorkCat'],
                'L1ID' => myappenv::MainCats['L1'],
                'L2ID' => myappenv::MainCats['L2'],
            ];
            $MainMenuData = json_encode($MainMenuData);
            $Data = [
                'name' => $ItemName,
                'value' => $MainMenuData,
            ];
            setting::create($Data);
            $MainMenu = CacheData::GetSetting($ItemName);
        }
        $MainMenu = $MainMenu->value;
        $MainMenu = json_decode($MainMenu);
        if ($L1ID != null) {
            $MainMenu->L1ID = $L1ID;
        }
        if ($MainMenu->L1ID == 0) {
            $MenuType = 'L1';
            if ($LimitRow == null) {
                $Cats = L1Work::where('WorkCat', $MainMenu->WorkCat)->get();
            } else {
                $Cats = L1Work::where('WorkCat', $MainMenu->WorkCat)->take($LimitRow)->get();
            }
        } elseif ($MainMenu->L2ID == 0) {
            $MenuType = 'L2';
            if ($LimitRow == null) {
                $Cats = L2Work::where('WorkCat', $MainMenu->WorkCat)->where('L1ID', $MainMenu->L1ID)->get();
            } else {
                $Cats = L2Work::where('WorkCat', $MainMenu->WorkCat)->where('L1ID', $MainMenu->L1ID)->take($LimitRow)->get();
            }
        } else {
            $MenuType = 'L3';
            if ($LimitRow == null) {
                $Cats = L3Work::where('WorkCat', $MainMenu->WorkCat)->where('L1ID', $MainMenu->L1ID)->where('L2ID', $MainMenu->L2ID)->orderBy('L3ID')->get();
            } else {
                $Cats = L3Work::where('WorkCat', $MainMenu->WorkCat)->where('L1ID', $MainMenu->L1ID)->where('L2ID', $MainMenu->L2ID)->orderBy('L3ID')->take($LimitRow)->get();
            }
        }
        $mianCats = [
            'MenuType' => $MenuType,
            'Cats' => $Cats,
        ];
        return $mianCats;
    }
    public function GetMenuCats($L1ID = null, $LimitRow = null)
    {

        if (debuger::DebugEnable()) {
            $ItemName = 'MainMenuT';
        } else {
            $ItemName = 'MainMenu';
        }
        $MainMenu = CacheData::GetSetting($ItemName);

        if ($MainMenu == null) {
            $MainMenuData = [
                'WorkCat' => myappenv::MainCats['WorkCat'],
                'L1ID' => myappenv::MainCats['L1'],
                'L2ID' => myappenv::MainCats['L2'],
            ];
            $MainMenuData = json_encode($MainMenuData);
            $Data = [
                'name' => $ItemName,
                'value' => $MainMenuData,
            ];
            setting::create($Data);

            $MainMenu = CacheData::GetSetting($ItemName);
        }
        $MainMenu = json_decode($MainMenu);
        if (!isset($MainMenu->L1ID)) {
            $MainMenu = json_decode($MainMenu->value);
        }
        if ($L1ID != null) {
            $MainMenu->L1ID = $L1ID;
        }
        if ($MainMenu->L1ID == 0) {
            $this->MeueTypes = 'L1';
            if ($LimitRow == null) {
                $Cats = L1Work::where('WorkCat', $MainMenu->WorkCat)->get();
            } else {
                $Cats = L1Work::where('WorkCat', $MainMenu->WorkCat)->take($LimitRow)->get();
            }
        } elseif ($MainMenu->L2ID == 0) {
            $this->MeueTypes = 'L2';
            if ($LimitRow == null) {
                $Cats = L2Work::where('WorkCat', $MainMenu->WorkCat)->where('L1ID', $MainMenu->L1ID)->get();
            } else {
                $Cats = L2Work::where('WorkCat', $MainMenu->WorkCat)->where('L1ID', $MainMenu->L1ID)->take($LimitRow)->get();
            }
        } else {
            $this->MeueTypes = 'L3';
            if ($LimitRow == null) {
                $Cats = L3Work::where('WorkCat', $MainMenu->WorkCat)->where('L1ID', $MainMenu->L1ID)->where('L2ID', $MainMenu->L2ID)->orderBy('L3ID')->get();
            } else {
                $Cats = L3Work::where('WorkCat', $MainMenu->WorkCat)->where('L1ID', $MainMenu->L1ID)->where('L2ID', $MainMenu->L2ID)->orderBy('L3ID')->take($LimitRow)->get();
            }
        }
        return $Cats;
    }

    public function ProductCats($TargetLayer)
    {
        // $Cats = $this->GetMenuCats($TargetLayer);
        $menu = Indexes::get_index_id();
        $matas = L2Work::where('WorkCat', $menu->WorkCat)->where('L1ID', $menu->L1ID)->get();
        $Cats = L3Work::where('WorkCat', $menu->WorkCat)->where('L1ID', $menu->L1ID)->where('L2ID', $TargetLayer)->orderBy('L3ID')->get();
        $DashboardClass = new DashboardClass;
        $MyProduct = new product;
        $Product = new ProductClass();
        return view('Layouts.Theme5.ProductCats', ['TargetLayer' => $TargetLayer, 'matas' => $matas, 'MenuType' => $this->MeueTypes, 'Cats' => $Cats, 'DashboardClass' => $DashboardClass, 'MyProduct' => $MyProduct, 'Product' => $Product]);
        //return view('woocommerce.Customer.ProductCats', ['MenuType' => $this->MeueTypes, 'Cats' => $Cats]);
    }
    public function SearchProductsV1($ProductTag = null, $ProductSearch = null, $Instock = true, $LimtRow = null)
    {

        if ($ProductTag != null) {
            $result = [];
        } elseif ($ProductSearch != null) {
            $ProductSearch = str_replace(' ', '', $ProductSearch);
            $result = ProductView::where(DB::raw("REPLACE(NameFa, ' ', '')"), 'like', "%$ProductSearch%")->orderBy('Remian', 'DESC')->paginate($this->get_paginate());
        } else {
            $result = [];
        }

        return $result;
    }

    public function GetProductsV1($ProductTag = null, $ProductId = null, $Instock = false, $LimtRow = null, $ProductType = null)
    {
        $OrderItem = 'id';
        $sortSirection = 'desc';
        if (Session::has('search_condition')) {
            $SearchArray = json_decode(Session::get('search_condition'), true);
            if (isset($SearchArray['sort'])) {
                switch ($SearchArray['sort']) {
                    case 'last':
                        $OrderItem = 'id';
                        $sortSirection = 'asc';
                        break;
                    case 'view':
                        $OrderItem = 'view';
                        $sortSirection = 'asc';
                        break;
                    case 'new':
                        $OrderItem = 'id';
                        $sortSirection = 'asc';
                        break;
                    case 'default':
                        $OrderItem = 'Price';
                        $sortSirection = 'asc';
                        break;
                    case 'expensive':
                        $OrderItem = 'Price';
                        $sortSirection = 'DESC';
                        break;
                    case 'cheap':
                        $OrderItem = 'Price';
                        $sortSirection = 'ASC';
                        break;
                    default:
                        $OrderItem = 'Remian';
                        $sortSirection = 'desc';
                }
            } else { //defult order
                $OrderItem = 'id';
                $sortSirection = 'desc';
            }
        } else { //defult order
            $OrderItem = 'id';
            $sortSirection = 'desc';
        }
        if ($ProductType == 'SpecialAccount') {
            $Result = ProductView::where('Virtual', 2)->where('Remian', '>', 0)->orderBy($OrderItem, $sortSirection)->paginate($this->get_paginate());
        } elseif ($ProductTag == null && $ProductId == null) { // all product list
            //$Result = ProductView::where('Remian', '>', 0)->paginate(10);
            $Result = ProductView::where('Remian', '>', 0)->orderBy('wg_create', 'desc')->paginate($this->get_paginate());
        } elseif ($ProductTag != null && $ProductId == null) { // product list by tag
            $new_product_index = CacheData::GetSetting('new_product_index');
            if ($ProductTag == $new_product_index) {

                $Result = ProductViewWithIndex::orderBy('wgid', 'desc')->groupBy('id')->paginate($this->get_paginate());

            } else {
                $Result = ProductViewWithIndex::where('IndexID', $ProductTag)->orderBy($OrderItem, $sortSirection)->paginate($this->get_paginate());
            }
        } elseif ($ProductTag == null && $ProductId != null) { // single Product
            $Result = ProductView::where('id', $ProductId)->orderBy($OrderItem, $sortSirection)->paginate($this->get_paginate());
        }
        return $Result;
    }
    private function GetProducts_new($LimtRow = null)
    {
        $Query = "SELECT
        g.id ,
        g.NameFa ,
        wg.MinPrice ,
        wg.MaxPrice ,
        wg.extra,
        g.ImgURL ,
        g.IRID,
        g.SKU,
        g.tax_status,
        g.stock_quantity ,
        g.average_rating ,
        g.total_sales ,
        g.UnitPlan,
        wg.BasePrice ,
        g.rating_count ,
        g.MainDescription,
        wg.PricePlan,
        wg.Remian,
        wg.Price ,
        wg.view ,
        wg.id as wgid,
        min( L3.img),
        min(L3.WorkCat)
    from
        warehouse_goods wg
    inner join goods g on
        wg.GoodID = g.id
    INNER JOIN  goodindices g2 on g2.GoodID = wg.GoodID INNER JOIN L3Work  L3 on L3.UID =  g2.IndexID
        WHERE wg.OnSale = 1 and wg.Remian > 0 group by g.id ,
        g.NameFa ,
        wg.MinPrice ,
        wg.MaxPrice ,
        wg.extra,
        g.ImgURL ,
        g.IRID,
        g.SKU,
        g.tax_status,
        g.stock_quantity ,
        g.average_rating ,
        g.total_sales ,
        g.UnitPlan,
        wg.BasePrice ,
        g.rating_count ,
        g.MainDescription,
        wg.PricePlan,
        wg.Remian,
        wg.Price ,
        wg.view ,
        wg.id order by  wg.created_at desc ";


        if ($LimtRow != null) {
            $Query .= "  LIMIT $LimtRow ";
        }
        $query_result = DB::select($Query);
        return $query_result;
    }
    public function GetProducts($ProductTag = null, $ProductId = null, $Instock = false, $LimtRow = null, $ProductType = null)
    {
        $new_product_index = CacheData::GetSetting('new_product_index');
        if ($ProductTag != null) {

            if ($ProductTag == $new_product_index) {

                return $this->GetProducts_new($LimtRow);
            }
        }


        $SortQuery = null;
        if (Session::has('search_condition')) {
            $SearchArray = json_decode(Session::get('search_condition'), true);
            if (isset($SearchArray['sort'])) {
                switch ($SearchArray['sort']) {
                    case 'last':
                        $SortQuery = 'order by g.id DESC';
                        break;
                    case 'offers':
                        $SortQuery = '';
                        break;
                    case 'view':
                        $SortQuery = 'order by wg.view';
                        break;
                    case 'new':
                        $SortQuery = 'order by g.id DESC';
                        break;
                    case 'hot':
                        $SortQuery = '';
                        break;
                    case 'expensive':
                        $SortQuery = 'order by wg.Price DESC';
                        break;
                    case 'cheap':
                        $SortQuery = 'order by wg.Price ASC';
                        break;
                    default:
                        $SortQuery = '';
                }
            }
        }

        if ($ProductType == 'SpecialAccount') {

            $Query = "SELECT g.id ,
        g.NameFa ,
        wg.MinPrice ,
        wg.MaxPrice ,
        wg.extra,
        g.SKU,
        g.IRID,
        g.ImgURL ,
        g.tax_status,
        g.stock_quantity ,
        g.average_rating ,
        g.total_sales ,
        g.rating_count ,
        g.MainDescription,
        g.UnitPlan,
        g.Description,
        g.weight,
        wg.BasePrice ,
        wg.Remian,
        wg.PricePlan,
        wg.Price ,
        wg.view ,
        wg.id as wgid
    from
        warehouse_goods wg
    inner join goods g on
        wg.GoodID = g.id
        WHERE wg.OnSale = 1 and g.Virtual = 2 and wg.Remian > 0";
        } elseif ($ProductTag == null && $ProductId == null) { // all product list
            $Query = "SELECT g.id ,
        g.NameFa ,
        wg.MinPrice ,
        wg.MaxPrice ,
        wg.extra,
        g.IRID,
        g.SKU,
        g.ImgURL ,
        g.tax_status,
        g.stock_quantity ,
        g.average_rating ,
        g.total_sales ,
        g.rating_count ,
        g.MainDescription,
        g.UnitPlan,
        wg.BasePrice ,
        wg.Remian,
        wg.PricePlan,
        wg.Price ,
        wg.view ,
        wg.id as wgid
    from
        warehouse_goods wg
    inner join goods g on
        wg.GoodID = g.id
        WHERE wg.OnSale = 1 and wg.Remian > 0 ";
        } elseif ($ProductTag != null && $ProductId == null) { // product list by tag
            $Query = "SELECT
        g.id ,
        g.NameFa ,
        wg.MinPrice ,
        wg.MaxPrice ,
        wg.extra,
        g.ImgURL ,
        g.IRID,
        g.SKU,
        g.tax_status,
        g.stock_quantity ,
        g.average_rating ,
        g.total_sales ,
        g.UnitPlan,
        wg.BasePrice ,
        g.rating_count ,
        g.MainDescription,
        wg.PricePlan,
        wg.Remian,
        wg.Price ,
        wg.view ,
        wg.id as wgid,
        L3.img,
        L3.WorkCat
    from
        warehouse_goods wg
    inner join goods g on
        wg.GoodID = g.id
    INNER JOIN  goodindices g2 on g2.GoodID = wg.GoodID INNER JOIN L3Work  L3 on L3.UID =  g2.IndexID
        WHERE wg.OnSale = 1 and  g2.IndexID = $ProductTag";
        } elseif ($ProductTag == null && $ProductId != null) { // single Product
            $Query = "SELECT
        g.id ,
        g.NameFa ,
        g.Description,
        wg.MinPrice ,
        wg.MaxPrice ,
        wg.extra,
        g.tax_status,
        g.stock_quantity ,
        g.average_rating ,
        g.total_sales ,
        g.rating_count ,
        g.UnitPlan,
        g.IRID,
        g.SKU,
        g.ImgURL ,
        wg.BasePrice ,
        g.MainDescription,
        wg.Remian,
        wg.PricePlan,
        wg.Price ,
        wg.view ,
        wg.id as wgid
    from
        warehouse_goods wg
    inner join goods g on
        wg.GoodID = g.id
        WHERE wg.OnSale = 1 and  g.id= $ProductId ";
        }
        if ($Instock) {
            $Query .= ' and wg.Remian > 0 ';
        }
        if ($SortQuery == null) {
            $Query .= ' order by  wg.Remian desc ';
        } else {
            $Query .= $SortQuery . ' , wg.Remian desc ';
        }

        if ($LimtRow != null) {
            $Query .= "  LIMIT $LimtRow ";
        }

        return DB::select($Query);
    }
    public function GetSrachedProducts($ProductTag, $SearchArray)
    {

        $Condition = '';
        $SortQuery = '';
        if (isset($SearchArray['sort'])) {
            switch ($SearchArray['sort']) {
                case 'last':
                    $SortQuery = 'order by g.id DESC';
                    break;
                case 'offers':
                    $SortQuery = '';
                    break;
                case 'view':
                    $SortQuery = 'order by wg.view';
                    break;
                case 'new':
                    $SortQuery = 'order by g.id DESC';
                    break;
                case 'hot':
                    $SortQuery = '';
                    break;
                case 'expensive':
                    $SortQuery = 'order by wg.Price DESC';
                    break;
                case 'cheap':
                    $SortQuery = 'order by wg.Price ASC';
                    break;
                default:
                    $SortQuery = 'order by Remian DESC ';
            }
        }

        if (isset($SearchArray['remained'])) {
            $Condition .= ' and wg.Remian > 0 ';
        } else {
            $Condition .= ' and wg.Remian >= 0 ';
        }
        if (isset($SearchArray['withDiscount'])) {
            $Condition .= ' and wg.BasePrice !=  wg.Price ';
        }
        $Query = "SELECT
        g.id ,
        g.NameFa ,
        wg.MinPrice ,
        wg.MaxPrice ,
        wg.extra,
        g.ImgURL ,
        g.IRID,
        g.SKU,
        g.tax_status,
        g.stock_quantity ,
        g.average_rating ,
        g.total_sales ,
        g.UnitPlan,
        wg.BasePrice ,
        g.rating_count ,
        g.MainDescription,
        wg.PricePlan,
        wg.Remian,
        wg.Price ,
        wg.view ,
        wg.id as wgid
    from
        warehouse_goods wg
    inner join goods g on
        wg.GoodID = g.id
    LEFT JOIN  goodindices g2 on g2.GoodID = wg.GoodID
        WHERE wg.OnSale = 1 and  g2.IndexID = $ProductTag $Condition $SortQuery";
        if (debuger::DebugEnable()) {
            echo $Query;
        }
        return DB::select($Query);
    }
    public function GetSrachedProductsByName($ProductName, $SearchArray)
    {
        $ProductName = trim($ProductName);
        $Condition = '';
        $SortQuery = '';
        if (isset($SearchArray->sort)) {
            switch ($SearchArray->sort) {
                case 'last':
                    $SortQuery = 'order by g.id DESC';
                    break;
                case 'offers':
                    $SortQuery = '';
                    break;
                case 'view':
                    $SortQuery = 'order by wg.view';
                    break;
                case 'new':
                    $SortQuery = 'order by g.id DESC';
                    break;
                case 'hot':
                    $SortQuery = '';
                    break;
                case 'expensive':
                    $SortQuery = 'order by wg.BasePrice DESC';
                    break;
                case 'cheap':
                    $SortQuery = 'order by wg.BasePrice ASC';
                    break;
                default:
                    $SortQuery = 'order by wg.Remian ASC  ';
            }
        }

        if (isset($SearchArray['remained'])) {
            $Condition .= ' and wg.Remian > 0 ';
        } else {
            $Condition .= ' and wg.Remian >= 0 ';
        }
        if (isset($SearchArray['withDiscount'])) {
            $Condition .= ' and wg.BasePrice !=  wg.Price ';
        }
        $Query = "SELECT
        g.id ,
        g.NameFa ,
        wg.MinPrice ,
        wg.MaxPrice ,
        wg.extra,
        g.ImgURL ,
        g.tax_status,
        g.IRID,
        g.SKU,
        g.stock_quantity ,
        g.average_rating ,
        g.total_sales ,
        g.UnitPlan,
        wg.BasePrice ,
        g.rating_count ,
        g.MainDescription,
        wg.PricePlan,
        wg.Remian,
        wg.Price ,
        wg.view ,
        wg.id as wgid
    from
        warehouse_goods wg
    inner join goods g on
        wg.GoodID = g.id
    LEFT JOIN  goodindices g2 on g2.GoodID = wg.GoodID

        WHERE wg.OnSale = 1 and   TRIM(g.NameFa) like '%$ProductName%' $Condition  group by g.id ,
        g.NameFa ,
        wg.MinPrice ,
        wg.MaxPrice ,
        wg.extra,
        g.ImgURL ,
        g.IRID,
        g.SKU,
        g.tax_status,
        g.stock_quantity ,
        g.average_rating ,
        g.total_sales ,
        g.UnitPlan,
        wg.BasePrice ,
        g.rating_count ,
        g.MainDescription,
        wg.PricePlan,
        wg.Remian,
        wg.Price ,
        wg.view ,
        wg.id    $SortQuery";
        return DB::select($Query);
    }

    private function GetL2Products($ProductL2Tag)
    {
        if (debuger::DebugEnable()) {
            $ItemName = 'MainMenuT';
        } else {
            $ItemName = 'MainMenu';
        }
        $MainMenu = CacheData::GetSetting($ItemName);
        if (isset($MainMenu->value)) {
            $MainMenu = $MainMenu->value;
        }
        $MainMenu = json_decode($MainMenu);
        $L2 = $ProductL2Tag['L2'];
        $WorkCatID = $MainMenu->WorkCat;
        $L1ID = $ProductL2Tag['L1'];
        $Query = "SELECT L3.UID , L3.Name  as L3Name ,L3.img as L3img, L2.Name as L2Name from L3Work L3  inner join L2Work L2 on L3.WorkCat = L2.WorkCat and L3.L1ID = L2.L1ID and L3.L2ID = L2.L2ID  WHERE L2.L2ID = $L2 and L2.WorkCat = $WorkCatID and L2.L1ID = $L1ID";
        return DB::select($Query);
    }
    public function SearchProducts($ProductTag = null, $ProductSearch = null, $Instock = true, $LimtRow = null)
    {
        if ($ProductTag == null && $ProductSearch == null) { // all product list
            $Query = "SELECT g.id ,
        g.NameFa ,
        wg.MinPrice ,
        wg.MaxPrice ,
        wg.extra,
        g.ImgURL ,
        g.IRID,
        g.SKU,
        g.tax_status,
        g.stock_quantity ,
        g.average_rating ,
        g.UnitPlan,
        g.total_sales,
        g.rating_count,
        g.MainDescription,
        wg.BasePrice ,
        wg.Remian,
        wg.PricePlan,
        wg.Price ,
        wg.id as wgid
    from
        warehouse_goods wg
    inner join goods g on
        wg.GoodID = g.id
        WHERE wg.OnSale = 1 ";
        } elseif ($ProductTag != null && $ProductSearch == null) { // product list by tag
            $Query = "SELECT
        g.id ,
        g.NameFa ,
        wg.MinPrice ,
        wg.MaxPrice ,
        wg.extra,
        g.ImgURL ,
        g.IRID,
        g.tax_status,
        g.SKU,
        g.stock_quantity ,
        g.average_rating ,
        g.total_sales ,
        g.UnitPlan,
        wg.BasePrice ,
        g.rating_count ,
        g.MainDescription,
        wg.PricePlan,
        wg.Remian,
        wg.Price ,
        wg.id as wgid
    from
        warehouse_goods wg
    inner join goods g on
        wg.GoodID = g.id
    INNER JOIN  goodindices g2 on g2.GoodID = wg.GoodID
        WHERE wg.OnSale = 1 and  g2.IndexID = $ProductTag";
        } elseif ($ProductTag == null && $ProductSearch != null) { // search Product
            $Query = "SELECT
        g.id ,
        g.NameFa ,
        wg.MinPrice ,
        wg.MaxPrice ,
        wg.extra,
        g.ImgURL ,
        g.IRID,
        g.SKU,
        g.stock_quantity ,
        g.average_rating ,
        g.tax_status,
        g.total_sales ,
        g.rating_count ,
        g.UnitPlan,
        wg.BasePrice ,
        g.MainDescription,
        wg.Remian,
        wg.PricePlan,
        wg.Price ,
        wg.id as wgid
    from
        warehouse_goods wg
    inner join goods g on
        wg.GoodID = g.id
        WHERE wg.OnSale = 1 and  g.NameFa like '%$ProductSearch%' ";
        }
        if ($Instock) {
            $Query .= ' and wg.Remian > 0 ';
        }
        if ($LimtRow != null) {
            $Query .= "  LIMIT $LimtRow ";
        }
        $Query .= " order by wg.Remian desc  ";
        return DB::select($Query);
    }
    public function EditProductInStore($id, $iframe = false)
    {


        $GoodInWarehouse = warehouse_goods::where('id', $id)->first();
        if ($GoodInWarehouse == null) {
            return abort('404', "لینک درخواستی وجود ندارد!");
        }
        $Warehouse = warehouse::where('id', $GoodInWarehouse->WarehouseID)->first();
        if ($Warehouse == null) {
            return abort('404', "لینک درخواستی وجود ندارد!");
        }
        $MyStore = new WoocommerceStore();
        $TargetStore = $MyStore->CurentUserHasAutorizeToAccessStore($Warehouse->StoreID);
        if ($TargetStore == false) {
            abort('404', 'انبار درخواست شده موجود نمی باشد!');
        }
        $Good = goods::where('id', $GoodInWarehouse->GoodID)->first();
        if ($Good == null) {
            return abort('404', "لینک درخواستی وجود ندارد!");
        }

        return view('woocommerce.admin.EditGoodInWarehouse', ['iframe' => $iframe, 'TargetStore' => $TargetStore, 'Warehouse' => $Warehouse, 'Good' => $Good, 'GoodInWarehouse' => $GoodInWarehouse]);
    }
    public function DoEditProductInStore(Request $request, $id)
    {

        $AddType = 'online';
        $alerting = false;
        if ($request->has('submit')) {
            if ($request->submit == 'renting') {
                $renting = new ProductRenting;
                if ($request->DeviceType == 0) {
                    return redirect()->back()->with('error', 'انجام فرایند اجاره بدون مشخص سازی سرفصل اجاره ممکن نیست!');
                }
                $DeviceType = $request->DeviceType;
                $rent_process = $renting->change_product_to_rating_mode($id, $DeviceType);
                if ($rent_process['result']) {
                    return redirect()->back()->with('success', __("success alert"));
                } else {
                    return redirect()->back()->with('error', $rent_process['msg']);
                }
            }
            if ($request->input('submit') == 'DisableItem') {
                warehouse_goods::where('id', $id)->update(['OnSale' => 0]);
                return redirect()->back()->with('success', __("success alert"));
            }
            if ($request->input('submit') == 'EnableItem') {
                warehouse_goods::where('GoodID', $request->GoodID)->update(['OnSale' => 0]);
                warehouse_goods::where('id', $id)->update(['OnSale' => 1]);
                return redirect()->back()->with('success', __("success alert"));
            }
            if ($request->input('submit') == 'offline') {
                $AddType = 'Offline';
            }
            if ($request->input('submit') == 'online_alert') {
                $alerting = true;
                $request->submit = 'online';
            }

        }
        if ($request->has('ProductType')) {
            $ProductType = $request->input('ProductType');
        } else {
            $ProductType = 'good';
        }

        if ($request->input('AlertFinish') == 'on') {
            $AlertFinish = 1;
        } else {
            $AlertFinish = 0;
        }
        if ($AddType == 'online') {
            $Price = $request->input('Price');
            if ($request->has('MainPrice')) {
                $MainPrice = $request->input('MainPrice');
            } else {
                $MainPrice = 0;
            }
        }
        if ($AddType == 'Offline') {
            $MaxPrice = $request->input('MaxPrice');
            $MinPrice = $request->input('MinPrice');
            $Note = $request->input('Note');


            if ($request->has('Price')) {
                $Price = $request->input('Price');
            } else {
                $Price = 0;
            }
        }

        $PriceUniqu = true;
        if ($MainPrice != 0) {
            $Price = $MainPrice;
            $PriceFormola = null;
            $PriceUniqu = true;
        } else {
            if (is_array($Price)) {
                $PriceFormola = array();
                $PriceUniqu = false;
                $ToNumber = $request->input('ToNumber');
                $counter = 1;
                $step_price = \App\Http\Controllers\setting\SettingManagement::GetSettingValue('step_mode') ?? 0;
                if ($step_price == 1) {
                    for ($counter; $counter < 14; $counter++) {
                        if ($ToNumber[$counter] == null || $Price[$counter] == null) {
                            break;
                        }

                        array_push($PriceFormola, ['ToNumber' => $ToNumber[$counter], 'Price' => $Price[$counter]]);
                    }
                }
                if ($step_price == 2) {
                    $target_price = 0;
                    for ($counter; $counter < 14; $counter++) {
                        if ($ToNumber[$counter] == null || $Price[$counter] == null) {
                            break;
                        }
                        if ($counter == 1) {
                            $target_price = $Price[$counter];
                        } else {
                            array_push($PriceFormola, ['ToNumber' => $ToNumber[$counter], 'Price' => $target_price]);
                            $target_price = $Price[$counter];
                        }

                    }
                    array_push($PriceFormola, ['ToNumber' => 1000, 'Price' => $target_price]);
                }


                $PriceFormola = json_encode($PriceFormola);
            }
        }

        if (Auth::user()->Role == myappenv::role_SuperAdmin || Auth::user()->Role == myappenv::role_ShopAdmin) {
            $OnSale = 1;
            $Owner = $request->input('UserName');
        } else {
            $OnSale = 10;
            $TargetStore = store::where('branch', Auth::user()->branch)->first();
            $Owner = $TargetStore->Owner;
        }

        if (myappenv::discountlimit) {
            if ($request->input('BasePrice') <= $Price) {

                return redirect()->back()->with('error', __("مبلغ پایه می باید از مبلغ فروش بزرگتر باشد!"));
            }
        }
        if ($request->input('BuyPrice') > $Price) {
            return redirect()->back()->with('error', __("مبلغ فروش نمیتواند از مبلغ خرید کمتر باشد!"));
        }
        if ($AddType == 'online') {
            if ($PriceUniqu) {
                if ($ProductType == 'good') {

                    $Data = [
                        'WarehouseID' => $request->input('WarehouseID'),
                        'GoodID' => $request->input('GoodID'),
                        'QTY' => $request->input('QTY'),
                        'BuyPrice' => $request->input('BuyPrice'),
                        'Price' => $Price,
                        'PricePlan' => null,
                        'OnSale' => $OnSale,
                        'SaleLimit' => $request->input('SaleLimit') ?? $request->input('QTY'),
                        'AlertLimit' => $request->input('AlertLimit') ?? 0,
                        'AlertFinish' => $AlertFinish,
                        'InputDate' => $request->input('InputDate'),
                        'MadeDate' => $request->input('MadeDate'),
                        'ExpireDate' => $request->input('ExpireDate'),
                        'ActiveTime' => $request->input('ActiveTime'),
                        'BasePrice' => $request->input('BasePrice'),
                        'Remian' => $request->input('Remian'),
                        'DeactiveTime' => $request->input('DeactiveTime'),
                        'MaxPrice' => 0,
                        'MinPrice' => 0,
                        'extra' => '',
                        'owner' => $Owner,

                    ];
                } elseif ($ProductType == 'SpecialAccount') {
                    $TargetGood = goods::where('id', $request->input('GoodID'))->first();
                    $Days = $TargetGood->weight;
                    $AccountArray = [
                        'type' => 'SpecialAccount',
                        'Days' => $Days,
                        'TargetRole' => $request->input('TargetRole'),
                    ];
                    $extra = json_encode($AccountArray);
                    $Data = [
                        'WarehouseID' => $request->input('WarehouseID'),
                        'GoodID' => $request->input('GoodID'),
                        'QTY' => $request->input('QTY'),
                        'BuyPrice' => $request->input('BuyPrice'),
                        'Price' => $Price,
                        'PricePlan' => null,
                        'OnSale' => $OnSale,
                        'AlertLimit' => $request->input('AlertLimit'),
                        'AlertFinish' => $AlertFinish,
                        'BasePrice' => $request->input('BasePrice'),
                        'Remian' => $request->input('Remian'),
                        'extra' => $extra,
                        'owner' => $Owner,
                    ];
                }
            } else {
                $Data = [
                    'WarehouseID' => $request->input('WarehouseID'),
                    'GoodID' => $request->input('GoodID'),
                    'QTY' => $request->input('QTY'),
                    'BuyPrice' => $request->input('BuyPrice'),
                    'Price' => 0,
                    'PricePlan' => $PriceFormola,
                    'OnSale' => $OnSale,
                    'SaleLimit' => $request->input('SaleLimit') ?? $request->input('QTY'),
                    'AlertLimit' => $request->input('AlertLimit') ?? 0,
                    'AlertFinish' => $AlertFinish,
                    'InputDate' => $request->input('InputDate'),
                    'MadeDate' => $request->input('MadeDate'),
                    'ExpireDate' => $request->input('ExpireDate'),
                    'ActiveTime' => $request->input('ActiveTime'),
                    'BasePrice' => $request->input('BasePrice'),
                    'Remian' => $request->input('Remian'),
                    'DeactiveTime' => $request->input('DeactiveTime'),
                    'MaxPrice' => 0,
                    'MinPrice' => 0,
                    'extra' => '',
                    'owner' => $Owner,
                ];
            }
        }
        if ($AddType == 'Offline') {
            $Data = [
                'WarehouseID' => $request->input('WarehouseID'),
                'GoodID' => $request->input('GoodID'),
                'QTY' => $request->input('QTY'),
                'BuyPrice' => $request->input('BuyPrice'),
                'Price' => $Price,
                'PricePlan' => null,
                'OnSale' => $OnSale,
                'SaleLimit' => $request->input('SaleLimit') ?? $request->input('QTY'),
                'AlertLimit' => $request->input('AlertLimit') ?? 0,
                'AlertFinish' => $AlertFinish,
                'InputDate' => $request->input('InputDate'),
                'MadeDate' => $request->input('MadeDate'),
                'ExpireDate' => $request->input('ExpireDate'),
                'ActiveTime' => $request->input('ActiveTime'),
                'BasePrice' => $request->input('BasePrice'),
                'Remian' => $request->input('Remian'),
                'DeactiveTime' => $request->input('DeactiveTime'),
                'MaxPrice' => $MaxPrice,
                'MinPrice' => $MinPrice,
                'extra' => $Note,
                'owner' => $Owner,
            ];
        }

        $OldRow = warehouse_goods::where('id', $id)->first();
        if ($OldRow->Price != $Price) {
            $UserID = Auth::id();
            $ArryData = [
                'FromPrice' => $OldRow->Price,
                'ToPrice' => $Price,
            ];
            $reportData = json_encode($ArryData);
            $SaveData = [
                'ProductID' => $request->input('GoodID'),
                'WGID' => $id,
                'UserID' => $UserID,
                'ReportType' => 3, //change  unit_sales
                'ReportVal' => $reportData,
            ];
            report_detial::create($SaveData);
        }
        if ($OldRow->Remian != $request->input('Remian')) {
            $UserID = Auth::id();
            $ArryData = [
                'FromRemain' => $OldRow->Remian,
                'ToRemain' => $request->input('Remian'),
            ];
            $reportData = json_encode($ArryData);
            $SaveData = [
                'ProductID' => $request->input('GoodID'),
                'WGID' => $id,
                'UserID' => $UserID,
                'ReportType' => 4, //change remain
                'ReportVal' => $reportData,
            ];
            report_detial::create($SaveData);
        }

        $Result = warehouse_goods::where('id', $id)->update($Data);
        if ($alerting) {
            $alerts = new ProductAlert();
            $alerts->alert_user_on_existing($request->input('GoodID'));
        }
        return redirect()->back()->with('success', __("success alert"));
    }
    public function makeXMLTree($data)
    {
        $ret = array();
        $parser = xml_parser_create();
        xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
        xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
        xml_parse_into_struct($parser, $data, $values, $tags);
        xml_parser_free($parser);
        $hash_stack = array();

        foreach ($values as $key => $val) {
            switch ($val['type']) {
                case 'open':
                    // array_push($hash_stack, [$val['tag']=>$val['value']]);
                    break;
                case 'close':
                    array_pop($hash_stack);
                    break;
                case 'complete':
                    array_push($hash_stack, [$val['tag'] => $val['value']]);
                    // uncomment to see what this function is doing
                    //echo("\$ret[" . implode($hash_stack, "][") . "] = '{$val[value]}';\n");
                    //eval("\$ret[" . implode($hash_stack, "][") . "] = '{$val[value]}';");
                    //array_pop($hash_stack);
                    break;
            }
        }
        return $hash_stack;
    }

    public function post2https($fields_arr, $url)
    {
        $fields_string = '';
        foreach ($fields_arr as $key => $value) {
            $fields_string .= $key . '=' . $value . '&';
        }
        $fields_string = substr($fields_string, 0, -1);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, count($fields_arr));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $res = curl_exec($ch);
        curl_close($ch);
        return $res;
    }
    public function startsWith($string, $startString)
    {
        $len = strlen($startString);
        return (substr($string, 0, $len) === $startString);
    }
    public function checkout(Request $request, $pay = null, $ref = null, $type = null)
    {
        if ($pay == 'sep' || $pay == 'pep' || $pay == 'IKC' || $pay == 'pol') {
            if ($ref == 'Faild') {
                return abort('404', 'تراکنش انجام نشد در صورت کسر مبلغ نهایتا پس از ۷۲ ساعت به حساب شما بازگشت داده خواهد شد');
            }
            if ($pay == 'sep') {
                $Payresutl = transactionstemp::where('id', $ref)->first();
                if ($Payresutl == null) {
                    return abort('404', 'اطلاعات تراکنش نا معتبر است!');
                }
                $price = Session::get('price');
                $ResNum = Session::get('ResNum');
                if ($price == $Payresutl->Amount) {
                    $MyTransfer = new TransferProduct($ResNum);
                    $resutl = $MyTransfer->UserPay($Payresutl->refnumber, $Payresutl->refnumber, $pay);
                    if ($resutl) {
                        $RResult = array('Mony' => Session::get('price'), 'Confirmdate' => date("Y-m-d H:i:s"), 'GateWay' => 'بانک سامان');
                        Session::put('price', null);
                        Session::put('ResNum', null);
                        transactionstemp::where('refnumber', $ref)->delete();
                        $UserInfo = Auth::user();
                        Session::put('basket', null);
                        $MySMS = new SmsCenter();
                        $CustomerText = 'سلام ' . Auth::user()->Name . ' ' . Auth::user()->Family . ' عزیز' . "\n";
                        $CustomerText .= 'سفارش شما به شماره ' . $ResNum . ' با موفقیت ثبت شد.' . "\n";
                        $CustomerText .= 'با تشکر از خرید شما.' . "\n";
                        $CustomerText .= myappenv::CenterName;

                        $MySMS->OndemandSMS($CustomerText, Auth::user()->MobileNo, 'tnks', Auth::user()->MobileNo);
                        $SellerText = 'سلام مدیر سفارش ' . $ResNum . 'با مبلغ ' . number_format($price) . ' در سامانه ثبت شد!';

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
                        }
                        return view("Credit.ConfirmPay", ['Result' => $RResult, 'UserInfo' => $UserInfo]);
                    } else {
                        return abort('404', 'در انجام تراکنش مشکلی پیش آمده لطفا با فروشگاه تماس بگیرید 14693  ');
                    }
                } else {

                    return abort('404', 'مشکل امنیتی کد : ۱۴۸۷ ');
                }
            } elseif ($pay == 'IKC') {
                $NormalBuy = true;
                $Payresutl = transactionstemp::where('refnumber', $ref)->first();
                if ($Payresutl == null) {
                    return abort('404', 'اطلاعات تراکنش نا معتبر است!');
                }
                $price = Session::get('price');
                $ResNum = Session::get('ResNum');
                if ($price == $Payresutl->Amount) {
                    if ($ResNum == 0) { //direct pay charge account
                        $note = Session::get('note');
                        $TransactionData = [
                            'UserName' => Auth::id(),
                            'Mony' => $price,
                            'Type' => 66,
                            'Date' => now(),
                            'Note' => $note,
                            'TransferBy' => Auth::id(),
                            'CreditMod' => myappenv::CachCredit,
                            'ConfirmBy' => 'system',
                            'InvoiceNo' => '',
                            'PaymentId' => $ref,
                            'SpecialPaymentId' => $ref,
                            'GateWay' => 'IKC',
                            'Confirmdate' => now(),
                            'branch' => Auth::user()->branch,
                        ];
                        $insertResult = UserCredit::create($TransactionData);
                        Session::put('price', null);
                        Session::put('ResNum', null);
                        Session::put('note', null);
                        transactionstemp::where('refnumber', $ref)->delete();
                        $RResult = array('Mony' => $price, 'Confirmdate' => date("Y-m-d H:i:s"), 'GateWay' => 'ایران کیش');
                        $UserInfo = Auth::user();
                        return view("Credit.ConfirmPay", ['Result' => $RResult, 'UserInfo' => $UserInfo]);
                    }
                    if (str_starts_with($ResNum, '99000')) {
                        $InvoiceNumber = substr($ResNum, 5, strlen($ResNum));
                        $MyInvouce = new TransferInvoice($InvoiceNumber);
                        $resutl = $MyInvouce->UserPay($ResNum, $InvoiceNumber, 'IKC', $price);
                        $UserInfo = $MyInvouce->GetUserInfo();

                        $NormalBuy = false;
                    } else {
                        $MyTransfer = new TransferProduct($ResNum);
                        $MyTransfer->SetPayment($price);
                        $resutl = $MyTransfer->UserPay($Payresutl->refnumber, $Payresutl->refnumber, $pay);
                    }
                    if ($resutl) {
                        $RResult = array('Mony' => Session::get('price'), 'Confirmdate' => date("Y-m-d H:i:s"), 'GateWay' => 'ایران کیش');
                        Session::put('price', null);
                        Session::put('ResNum', null);
                        transactionstemp::where('refnumber', $ref)->delete();
                        Session::put('basket', null);
                        if ($NormalBuy) {
                            $UserInfo = Auth::user();
                            $MySMS = new SmsCenter();
                            $CustomerText = 'سلام ' . Auth::user()->Name . ' ' . Auth::user()->Family . ' عزیز' . "\n";
                            $CustomerText .= 'سفارش شما به شماره ' . $ResNum . ' با موفقیت ثبت شد.' . "\n";
                            $CustomerText .= 'با تشکر از خرید شما.' . "\n";
                            $CustomerText .= myappenv::CenterName;
                            $MySMS->OndemandSMS($CustomerText, Auth::user()->MobileNo, 'tnks', Auth::user()->MobileNo);
                            $SellerText = 'سلام مدیر سفارش ' . $ResNum . 'با مبلغ ' . number_format($price) . ' در سامانه ثبت شد!';
                            if (myappenv::MainOwner == 'shafatel' || myappenv::MainOwner == 'Carpetour') {
                                $MySMS->OndemandSMS($SellerText, '09126543802', 'tnks', '09126543802');
                            } else {
                                //$MySMS->OndemandSMS($SellerText, '09123345580', 'tnks', '09123345580');
                            }
                            $this->AddLog($ResNum);
                            $MySMS->OndemandSMS($SellerText, '09123936105', 'tnks', '09123936105');
                            if (myappenv::MainOwner == 'kookbaz') {
                                $MySMS->OndemandSMS($SellerText, '09125833245', 'tnks', '09125833245');
                                $MySMS->OndemandSMS($SellerText, '09192228284', 'tnks', '09192228284');
                            }
                        }
                        return view("Credit.ConfirmPay", ['Result' => $RResult, 'UserInfo' => $UserInfo]);
                    } else {
                        return abort('404', 'در انجام تراکنش مشکلی پیش آمده لطفا با فروشگاه تماس بگیرید 14693  ');
                    }
                } else {

                    return abort('404', 'مشکل امنیتی کد : ۱۴۸۲ ');
                }
            } elseif ($pay == 'pol') {
                $NormalBuy = true;
                $Payresutl = transactionstemp::where('refnumber', $ref)->first();
                if ($Payresutl == null) {
                    return abort('404', 'اطلاعات تراکنش نا معتبر است!');
                }
                $price = Session::get('price');
                $ResNum = Session::get('ResNum');
                if ($price == $Payresutl->Amount) {
                    if ($ResNum == 0) { //direct pay charge account
                        if (Session::has('uc')) { // request to pay method
                            $UserCredit_id = Session::get('uc');
                            $CreditSrc = UserCredit::where('ID', $UserCredit_id)->where('CreditMod', myappenv::ToPayCredit)->where('ConfirmBy', null)->first();
                            if ($CreditSrc == null) {
                                return abort('404', 'عملیات با خطا مواجه شد لطفا با مرکز تماس حاصل فرمایید!');
                            }
                            $TransactionData = [
                                'Date' => now(),
                                'CreditMod' => myappenv::CachCredit,
                                'ConfirmBy' => 'system',
                                'PaymentId' => $ref,
                                'SpecialPaymentId' => $ref,
                                'GateWay' => 'pol',
                                'Confirmdate' => now(),
                            ];
                            UserCredit::where('ID', $UserCredit_id)->update($TransactionData);
                            $UserInfo = UserInfo::where('UserName', $CreditSrc->UserName)->first();
                        } else {
                            $note = Session::get('note');
                            $TransactionData = [
                                'UserName' => Auth::id(),
                                'Mony' => $price,
                                'Type' => 66,
                                'Date' => now(),
                                'Note' => $note,
                                'TransferBy' => Auth::id(),
                                'CreditMod' => myappenv::CachCredit,
                                'ConfirmBy' => 'system',
                                'InvoiceNo' => '',
                                'PaymentId' => $ref,
                                'SpecialPaymentId' => $ref,
                                'GateWay' => 'pol',
                                'Confirmdate' => now(),
                                'branch' => Auth::user()->branch,
                            ];
                            $insertResult = UserCredit::create($TransactionData);
                            $UserInfo = Auth::user();
                        }
                        Session::forget('price');
                        Session::forget('ResNum');
                        Session::forget('note');
                        Session::forget('uc');
                        transactionstemp::where('refnumber', $ref)->delete();
                        $RResult = array('Mony' => $price, 'Confirmdate' => date("Y-m-d H:i:s"), 'GateWay' => ' کیف پول خرد');
                        return view("Credit.ConfirmPay", ['Result' => $RResult, 'UserInfo' => $UserInfo]);
                    }
                    if (str_starts_with($ResNum, '99000')) {
                        $InvoiceNumber = substr($ResNum, 5, strlen($ResNum));
                        $MyInvouce = new TransferInvoice($InvoiceNumber);
                        $resutl = $MyInvouce->UserPay($ResNum, $InvoiceNumber, 'IKC', $price);
                        $UserInfo = $MyInvouce->GetUserInfo();

                        $NormalBuy = false;
                    } else {
                        $MyTransfer = new TransferProduct($ResNum);
                        $MyTransfer->SetPayment($price);
                        $resutl = $MyTransfer->UserPay($Payresutl->refnumber, $Payresutl->refnumber, $pay);
                    }
                    if ($resutl) {
                        $RResult = array('Mony' => Session::get('price'), 'Confirmdate' => date("Y-m-d H:i:s"), 'GateWay' => 'کیف پول خرد');
                        Session::put('price', null);
                        Session::put('ResNum', null);
                        transactionstemp::where('refnumber', $ref)->delete();
                        Session::put('basket', null);
                        if ($NormalBuy) {
                            $UserInfo = Auth::user();
                            $MySMS = new SmsCenter();
                            $CustomerText = 'سلام ' . Auth::user()->Name . ' ' . Auth::user()->Family . ' عزیز' . "\n";
                            $CustomerText .= 'سفارش شما به شماره ' . $ResNum . ' با موفقیت ثبت شد.' . "\n";
                            $CustomerText .= 'با تشکر از خرید شما.' . "\n";
                            $CustomerText .= myappenv::CenterName;
                            $MySMS->OndemandSMS($CustomerText, Auth::user()->MobileNo, 'tnks', Auth::user()->MobileNo);
                            $SellerText = 'سلام مدیر سفارش ' . $ResNum . 'با مبلغ ' . number_format($price) . ' در سامانه ثبت شد!';
                            if (myappenv::MainOwner == 'shafatel' || myappenv::MainOwner == 'Carpetour') {
                                $MySMS->OndemandSMS($SellerText, '09126543802', 'tnks', '09126543802');
                            } else {
                                //$MySMS->OndemandSMS($SellerText, '09123345580', 'tnks', '09123345580');
                            }
                            $this->AddLog($ResNum);
                            $MySMS->OndemandSMS($SellerText, '09123936105', 'tnks', '09123936105');
                            if (myappenv::MainOwner == 'kookbaz') {
                                $MySMS->OndemandSMS($SellerText, '09125833245', 'tnks', '09125833245');
                                $MySMS->OndemandSMS($SellerText, '09192228284', 'tnks', '09192228284');
                            }
                        }
                        return view("Credit.ConfirmPay", ['Result' => $RResult, 'UserInfo' => $UserInfo]);
                    } else {
                        return abort('404', 'در انجام تراکنش مشکلی پیش آمده لطفا با فروشگاه تماس بگیرید 14693  ');
                    }
                } else {

                    return abort('404', 'مشکل امنیتی کد : ۱۴۸۲ ');
                }
            } elseif ($pay == 'pep') {
                $price = Session::get('price');
                $ResNum = Session::get('ResNum');
                $fields = array('invoiceUID' => $request->input('tref'));
                $result = $this->post2https($fields, 'https://pep.shaparak.ir/CheckTransactionResult.aspx');
                $array = $this->makeXMLTree($result);
                foreach ($array as $ietm) {
                    if (isset($ietm['result'])) {
                        $PayResult = $ietm["result"];
                    } elseif (isset($ietm['transactionReferenceID'])) {
                        $transactionReferenceID = $ietm["transactionReferenceID"];
                    } elseif (isset($ietm['invoiceNumber'])) {
                        $invoiceNumber = $ietm["invoiceNumber"];
                    } elseif (isset($ietm['amount'])) {
                        $amount = $ietm["amount"];
                    } elseif (isset($ietm['traceNumber'])) {
                        $traceNumber = $ietm["traceNumber"];
                    } elseif (isset($ietm['referenceNumber'])) {
                        $referenceNumber = $ietm["referenceNumber"];
                    } elseif (isset($ietm['invoiceDate'])) {
                        $InvoiceDate = $ietm["invoiceDate"];
                    }
                }
                $MerchantCode = myappenv::PEPMerchantCode;
                $TerminalCode = myappenv::PEPTerminalCode;
                $TimeStamp = date("Y/m/d H:i:s");
                $fields = array(
                    'MerchantCode' => $MerchantCode, //shomare ye moshtari e shoma.
                    'TerminalCode' => $TerminalCode, //shomare ye terminal e shoma.
                    'InvoiceNumber' => $invoiceNumber, //shomare ye factor tarakonesh.
                    'InvoiceDate' => $InvoiceDate, //tarikh e tarakonesh.
                    'amount' => $amount, //mablagh e tarakonesh. faghat adad.
                    'TimeStamp' => date("Y/m/d H:i:s"), //zamane jari ye system.
                    'sign' => '', //reshte ye ersali ye code shode. in mored automatic por mishavad.
                );
                $data = "#$MerchantCode#$TerminalCode#$invoiceNumber#$InvoiceDate#$amount#$TimeStamp#";
                $data = sha1($data, true);
                $Certificate = myappenv::PEPPrivate;
                $processor = new RSAProcessor($Certificate, RSAKeyType::XMLString);
                $data = $processor->sign($data);
                $fields['sign'] = base64_encode($data); // base64_encode
                $sendingData = "MerchantCode=" . $MerchantCode . "&TerminalCode=" . $TerminalCode . "&InvoiceNumber=" . $invoiceNumber . "&InvoiceDate=" . $InvoiceDate . "&amount=" . $amount . "&TimeStamp=" . $TimeStamp . "&sign=" . $fields['sign'];
                $verifyresult = $this->post2https($fields, 'https://pep.shaparak.ir/VerifyPayment.aspx');
                $array = $this->makeXMLTree($verifyresult);
                foreach ($array as $ietm) {
                    if (isset($ietm['result'])) {
                        $ConfirmResult = $ietm["result"];
                    }
                }
                if ($ConfirmResult == 'True') { //pay successfuly
                    $MyTransfer = new TransferProduct($ResNum);
                    if ($invoiceNumber == 1) { //directPayment
                        $resutl = $MyTransfer->UserDirectPAy($traceNumber, $referenceNumber, 'pep', $amount);
                    } else {
                        $resutl = $MyTransfer->UserPay($traceNumber, $referenceNumber, 'pep');
                    }

                    if ($resutl) {
                        $RResult = array('Mony' => Session::get('price'), 'Confirmdate' => date("Y-m-d H:i:s"), 'GateWay' => 'بانک پاسارگاد');
                        Session::put('price', null);
                        Session::put('ResNum', null);
                        $UserInfo = Auth::user();
                        Session::put('basket', null);
                        if ($invoiceNumber == 1) { //directPayment
                            $MySMS = new SmsCenter();
                            $CustomerText = myappenv::CenterName;
                            $CustomerText .= '
                            ' . Auth::user()->Name . ' ' . Auth::user()->Family . ' عزیز اعتبار شما به مبلغ ' . number_format($price) . ' افزایش پیدا کرد';
                            $CustomerText .= '
                             با تشکر از پرداخت شما.';
                            $MySMS->OndemandSMS($CustomerText, Auth::user()->MobileNo, 'tnks', Auth::user()->MobileNo);
                        } else {
                            $MySMS = new SmsCenter();
                            $CustomerText = 'سلام ' . Auth::user()->Name . ' ' . Auth::user()->Family . ' عزیز' . "\n";
                            $CustomerText .= 'سفارش شما به شماره ' . $ResNum . ' با موفقیت ثبت شد.' . "\n";
                            $CustomerText .= 'با تشکر از خرید شما.' . "\n";
                            $CustomerText .= myappenv::CenterName;
                            $MySMS->OndemandSMS($CustomerText, Auth::user()->MobileNo, 'tnks', Auth::user()->MobileNo);
                            $SellerText = 'سلام مدیر سفارش ' . $ResNum . 'با مبلغ ' . number_format($price) . ' در سامانه ثبت شد!';
                            if (myappenv::MainOwner == 'shafatel' || myappenv::MainOwner == 'Carpetour') {
                                $MySMS->OndemandSMS($SellerText, '09126543802', 'tnks', '09126543802');
                            } else {
                                //  $MySMS->OndemandSMS($SellerText, '09123345580', 'tnks', '09123345580');
                            }
                            $this->AddLog($ResNum);
                            $MySMS->OndemandSMS($SellerText, '09123936105', 'tnks', '09123936105');
                            if (myappenv::MainOwner == 'kookbaz') {
                                $MySMS->OndemandSMS($SellerText, '09125833245', 'tnks', '09125833245');
                                $MySMS->OndemandSMS($SellerText, '09192228284', 'tnks', '09192228284');
                            }
                        }
                        return view("Credit.ConfirmPay", ['Result' => $RResult, 'UserInfo' => $UserInfo]);
                    } else {
                        return abort('404', 'در انجام تراکنش مشکلی پیش آمده لطفا با فروشگاه تماس بگیرید 14693  ');
                    }
                } else { // pay has error

                }
            }
        }
        $OrderType = 'normal';
        $Financial = new Financial();
        $UserCashCredit = $Financial->UserHasCredite(Auth::id(), 1);
        $UserLocations = null;
        $MyOrder = json_decode(Session::get('basket'));

        $TotalPrice = 0;
        $TotalWight = 0;
        $OrderDetials = array();
        $Provinces = provinces::all();
        if ($MyOrder == null) {
            $OrderDetials = null;
        } else {

            $UserLocations = locations::all()->where("Owner", Auth::id())->where('Status', 1);
            foreach ($MyOrder as $MyOrderTarget) {
                $ProductQty = $MyOrderTarget[1];
                $Product = goods::where('id', $MyOrderTarget[0])->first();
                if ($Product->UnitPlan == null || $Product->UnitPlan == []) {
                    $UnitPlan = null;
                } else {
                    $UnitPlan = $this->GetTargetUnitFromUnitPlanJson($Product->UnitPlan, $ProductQty);
                }
                if ($Product->UnitPlan == null || $Product->UnitPlan == []) {
                    $BaseUnit = 'عدد';
                } else {
                    $BaseUnit = $this->GetTargetUnitFromUnitPlanJson($Product->UnitPlan, 1);
                }
                $ProductInWarehouse = warehouse_goods::where('GoodID', $MyOrderTarget[0])->first();
                if ($ProductInWarehouse->MinPrice != 0) {
                    $OrderType = 'register';
                }
                $TotalWight += intval($Product->weight) * intval($ProductQty);
                $WGID = $ProductInWarehouse->id;
                $Query = "select * from tashim_items  as ti inner join tashims t on ti.TashimID = t.id where ti.GoodsID = $WGID";
                $Tashims = DB::select($Query);
                if ($ProductInWarehouse->PricePlan == null) {
                    if ($ProductInWarehouse->MinPrice != null && $ProductInWarehouse->MinPrice > 0) { //offline sale
                        $TotalPrice += 0;
                        array_push($OrderDetials, ['Tashims' => $Tashims, 'BaseUnit' => $BaseUnit, 'UnitPlan' => $UnitPlan, 'TotalWight' => $TotalWight, 'Product' => $Product, 'ProductQty' => $ProductQty, 'ProductInWarehouse' => $ProductInWarehouse]);
                    } else { //online sale
                        $TotalPrice += intval($ProductInWarehouse->Price) * intval($ProductQty);
                        array_push($OrderDetials, ['Tashims' => $Tashims, 'BaseUnit' => $BaseUnit, 'UnitPlan' => $UnitPlan, 'TotalWight' => $TotalWight, 'Product' => $Product, 'ProductQty' => $ProductQty, 'ProductInWarehouse' => $ProductInWarehouse]);
                    }
                } else {
                    $BasePrice = $this->GetTargetPriceFromPricePlanJson($ProductInWarehouse->PricePlan, $ProductQty);
                    $TotalPrice += intval($BasePrice) * intval($ProductQty);
                    array_push($OrderDetials, ['Tashims' => $Tashims, 'BaseUnit' => $BaseUnit, 'UnitPlan' => $UnitPlan, 'TotalWight' => $TotalWight, 'Product' => $Product, 'ProductQty' => $ProductQty, 'ProductInWarehouse' => $ProductInWarehouse]);
                }
            }
        }
        $TashimSession = json_decode(Session::get('Tashim'));
        $TashimWork = new CreditTashim;
        $Walets = $TashimWork->TashimPreResult($TashimSession, $OrderDetials);
        $WaletSummery = $TashimWork->WaletSummery($Walets, 'buyer');
        Session::put('Walets', $Walets);
        $TargetTheme = myappenv::SiteTheme;
        if ($TargetTheme == 'sepehrmall') {
            return view('woocommerce.Customer.Sepehrmall_OrderView', ['TashimWork' => $TashimWork, 'WaletSummery' => $WaletSummery, 'TashimSession' => $TashimSession, 'UserCashCredit' => $UserCashCredit, 'MyProduct' => $this, 'TotalPrice' => $TotalPrice, 'TotalWight' => $TotalWight, 'Provinces' => $Provinces, 'UserLocations' => $UserLocations, 'OrderDetials' => $OrderDetials]);
        } elseif ($TargetTheme == 'kookbaz') {
            if ($OrderType == 'normal') {
                return view('woocommerce.Customer.OrderView_kookbaz', ['TashimWork' => $TashimWork, 'WaletSummery' => $WaletSummery, 'TashimSession' => $TashimSession, 'UserCashCredit' => $UserCashCredit, 'MyProduct' => $this, 'TotalPrice' => $TotalPrice, 'TotalWight' => $TotalWight, 'Provinces' => $Provinces, 'UserLocations' => $UserLocations, 'OrderDetials' => $OrderDetials]);
            } elseif ($OrderType == 'register') {
                return view('woocommerce.Customer.OrderView_kookbaz_register_order', ['TashimWork' => $TashimWork, 'WaletSummery' => $WaletSummery, 'TashimSession' => $TashimSession, 'UserCashCredit' => $UserCashCredit, 'MyProduct' => $this, 'TotalPrice' => $TotalPrice, 'TotalWight' => $TotalWight, 'Provinces' => $Provinces, 'UserLocations' => $UserLocations, 'OrderDetials' => $OrderDetials]);
            }
        } elseif ($TargetTheme == 'shafatel' || $TargetTheme == 'news247') {
            return view('woocommerce.Customer.OrderView', ['TashimWork' => $TashimWork, 'WaletSummery' => $WaletSummery, 'TashimSession' => $TashimSession, 'UserCashCredit' => $UserCashCredit, 'MyProduct' => $this, 'TotalPrice' => $TotalPrice, 'TotalWight' => $TotalWight, 'Provinces' => $Provinces, 'UserLocations' => $UserLocations, 'OrderDetials' => $OrderDetials]);
        } else { // other themes
            return view("Layouts.$TargetTheme.OrderView", ['TashimWork' => $TashimWork, 'WaletSummery' => $WaletSummery, 'TashimSession' => $TashimSession, 'UserCashCredit' => $UserCashCredit, 'MyProduct' => $this, 'TotalPrice' => $TotalPrice, 'TotalWight' => $TotalWight, 'Provinces' => $Provinces, 'UserLocations' => $UserLocations, 'OrderDetials' => $OrderDetials]);
        }
    }
    public function get_my_credit()
    {
        $usercredit = UserCredit::where('UserName', Auth::id())->where('CreditMod', myappenv::CachCredit)->where('ConfirmBy', '!=', null)->sum('Mony');
        return $usercredit;
    }
    public function IsValidTashim($NewTashimID, $NEWProductId, $NEWpwid, $TashimSession)
    {
        $TashimsArr = new stdClass;
        $MyTashim = new CreditTashim;
        $CreditMods = array();
        $Result = array();
        if ($TashimSession != null) {
            foreach ($TashimSession as $TashimSessionItem) {
                if ($TashimSessionItem->ProductId != $NEWProductId) {
                    $ProductSrc = warehouse_goods::where('GoodID', $TashimSessionItem->ProductId)->first();
                    $MonyAttr = [
                        'SaleMony' => $ProductSrc->Price,
                    ];
                    $Result = $MyTashim->DoTashim($TashimSessionItem->Tashim, $MonyAttr);
                    foreach ($Result as $TashimSRCItem) {
                        if ($TashimSRCItem['TargetUser'] == 'buyer') {
                            if ($TashimSRCItem['CreditMod'] != myappenv::CachCredit) {
                                $ArrItem = $TashimSRCItem['CreditMod'];
                                if (!in_array($ArrItem, $CreditMods)) {
                                    array_push($CreditMods, $ArrItem);
                                }
                                if (isset($TashimsArr->$ArrItem)) {
                                    $TashimsArr->$ArrItem = $TashimsArr->$ArrItem + $TashimSRCItem['Amount'];
                                } else {
                                    $TashimsArr->$ArrItem = $TashimSRCItem['Amount'];
                                }
                            }
                        }
                    }
                }
            }
        }

        $ProductSrc = warehouse_goods::where('id', $NEWpwid)->first();
        $MonyAttr = [
            'SaleMony' => $ProductSrc->Price,
        ];
        $Result = $MyTashim->DoTashim($NewTashimID, $MonyAttr);
        foreach ($Result as $TashimSRCItem) {
            if ($TashimSRCItem['TargetUser'] == 'buyer') {
                if ($TashimSRCItem['CreditMod'] != myappenv::CachCredit) {
                    $ArrItem = $TashimSRCItem['CreditMod'];
                    if (!in_array($ArrItem, $CreditMods)) {
                        array_push($CreditMods, $ArrItem);
                    }
                    if (isset($TashimsArr->$ArrItem)) {
                        $TashimsArr->$ArrItem = $TashimsArr->$ArrItem + $TashimSRCItem['Amount'];
                    } else {
                        $TashimsArr->$ArrItem = $TashimSRCItem['Amount'];
                    }
                }
            }
        }
        $ValidTransfer = true;
        $Myfin = new Financial;

        foreach ($CreditMods as $CreditMod) {
            $CheckTransfer = $Myfin->IsValidTransfer(Auth::id(), $CreditMod, $TashimsArr->$CreditMod);
            if (!$CheckTransfer) {
                $ValidTransfer = false;
            }
        }
        return $ValidTransfer;
    }
    public function Docheckout(Request $request)
    {

        if ($request->has('Tashim')) {
            $TashimSession = json_decode(Session::get('Tashim'));
            $Isvalid = $this->IsValidTashim($request->input('Tashim'), $request->input('ProductId'), $request->input('pwid'), $TashimSession);
            if (!$Isvalid) {
                return redirect()->back()->with('error', 'کیف پول شما به قدر کافی اعتبار ندارد');
            }
            if ($TashimSession == null) {
                $TashimSession = array();
            }
            $tempTashim = array();
            $additem = false;
            foreach ($TashimSession as $TashimSessionItem) {
                if ($TashimSessionItem->ProductId == $request->input('ProductId')) {
                    if ($request->input('Tashim') != 0) {
                        $NewTashim = [
                            'ProductId' => $request->input('ProductId'),
                            'Tashim' => $request->input('Tashim'),
                        ];
                        array_push($tempTashim, $NewTashim);
                    }

                    $additem = true;
                } else {
                    if ($request->input('Tashim') != 0) {
                        array_push($tempTashim, $TashimSessionItem);
                    }
                    $additem = true;
                }
            }
            if (!$additem) {
                if ($request->input('Tashim') != 0) {
                    $NewTashim = [
                        'ProductId' => $request->input('ProductId'),
                        'Tashim' => $request->input('Tashim'),
                    ];
                    array_push($tempTashim, $NewTashim);
                }
            }
            $TashimSession = json_encode($tempTashim);
            Session::put('Tashim', $TashimSession);
            return redirect()->back();
        }
        if ($request->has('deleteaddress')) {
            locations::where('id', $request->input('deleteaddress'))->update(['Status' => 0]);
            return redirect()->back()->with('success', 'آدرس مورد نظر حذف گردید!');
        }

        if ($request->has('ChangeAddress')) {
            $DataToSave = [
                "name" => $request->input('LocationName'),
                "Street" => $request->input('Street'),
                "OthersAddress" => $request->input('OthersAddress'),
                "Pelak" => $request->input('Pelak'),
                "PostalCode" => $request->input('PostalCode'),
                "recivername" => $request->input('recivername'),
                "reciverphone" => $request->input('reciverphone'),
                "ExtraNote" => $request->input('ExtraNote'),
            ];
            locations::where('id', $request->input('ChangeAddress'))->update($DataToSave);
            return redirect()->back()->with('success', 'آدرس مورد نظر به روز رسانی شد!');
        }

        if ($request->has('Edit')) {
            $MyBuy = new buy();
            $ProductId = $request->input('Edit');
            $MyBuy->RemoveGoodFromBasket($ProductId);
            return redirect()->route('SingleProduct', ['productID' => $ProductId]);
        }
        if ($request->input('submit') == 'updatebasket') {
            $ProductOrderArr = $request->input('productcount');
            $MyOrder = json_decode(Session::get('basket'));
            $NewBasket = array();
            foreach ($ProductOrderArr as $ProductOrderItem => $value) {
                $product_id = $ProductOrderItem;
                $product_qty = $ProductOrderArr[$ProductOrderItem];
                $changearr = ["$product_id", "$product_qty"];
                array_push($NewBasket, $changearr);
            }
            $NewBasket = json_encode($NewBasket);
            Session::put('basket', $NewBasket);
            return redirect()->back();
        }
        if ($request->input('submit') == 'submit' || $request->input('submit') == 'PayFromCredit' || $request->input('submit') == 'SubmitOrder') {
            $SubItem = 1;
            if ($request->input('submit') == 'submit') {
                $payType = 'bank';
            } elseif ($request->input('submit') == 'PayFromCredit') {
                $payType = 1;
            } elseif ($request->input('submit') == 'SubmitOrder') {
                $payType = 2; //offline sale
            }
            if ($request->input('Location') == 0) { // Add new location on finalize Order
                $CityName = citys::where('id', $request->input('Saharestan'))->first();
                $CityName = $CityName->CityName;
                $ProvinceName = provinces::where('id', $request->input('Province'))->first();
                $ProvinceName = $ProvinceName->ProvinceName;
                if ($request->input('recivername') != null) {
                    $recivername = $request->input('recivername');
                } else {
                    $recivername = Auth::user()->Name . ' ' . Auth::user()->Family;
                }
                if ($request->input('reciverphone') != null) {
                    $reciverphone = $request->input('reciverphone');
                } else {
                    $reciverphone = Auth::user()->MobileNo;
                }
                $LocationData = [
                    'Owner' => Auth::id(),
                    'name' => $request->input('LocationName'),
                    'Province' => $ProvinceName,
                    'ProvinceID' => $request->input('Province'),
                    'City' => $CityName,
                    'CityID' => $request->input('Saharestan'),
                    'Street' => $request->input('Street'),
                    'OthersAddress' => $request->input('OthersAddress'),
                    'Pelak' => $request->input('Pelak'),
                    'PostalCode' => $request->input('PostalCode'),
                    'ExtraNote' => $request->input('ExtraNote'),
                    'recivername' => $recivername,
                    'reciverphone' => $reciverphone,
                ];
                $Result = locations::create($LocationData);
                $TargetLocation = $Result->id;
            } else {
                $TargetLocation = $request->input('Location');
            }
            $OrderPreData = [
                'status' => 0,
                'ReturnCustomerId' => Auth::id(),
                'CustomerId' => Auth::id(),
                'SendLocation' => $TargetLocation,
                'ReturnLocation' => $TargetLocation,
            ];
            if (Session::has('Walets')) {
                $WaletSrc = Session::get('Walets');
                $TashimToPay = 0; // مبلغی که مشتری باید پرداخت کند بر اساس تسهیم ثبت شده
                foreach ($WaletSrc as $WaletSrcItem) {
                    if ($WaletSrcItem['TargetUser'] == 'buyer') {
                        if ($WaletSrcItem['CreditMod'] == myappenv::CachCredit) {
                            $TashimToPay += $WaletSrcItem['Amount'];
                        }
                    }
                }
            } else {
            }
            $ProductOrderInsertResult = product_order::create($OrderPreData);
            $ProductOrderId = $ProductOrderInsertResult->id;
            $num_items_sold = 0;
            $total_sales_G = 0;
            $tax_total_G = 0;
            $customer_benefit_total_G = 0;
            $shipping_total_G = 0;
            $net_total_G = 0;
            $TotallWeight = 0;
            $ProductOrderArr = json_decode(Session::get('basket'));
            $branches = array();
            foreach ($ProductOrderArr as $ProductOrderItem) {
                $num_items_sold++;
                $product_id = $ProductOrderItem[0];
                $product_qty = $ProductOrderItem[1];
                $ProductWarehouseID = $ProductOrderItem[2];
                $ProductTarget = warehouse_goods::where('GoodID', $product_id)->where('OnSale', 1)->first();
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
                if ($ProductTarget->PricePlan == null) {
                    $unit_sales = $ProductTarget->Price;
                } else {
                    $unit_sales = $this->GetTargetPriceFromPricePlanJson($ProductTarget->PricePlan, $product_qty);
                }
                if (myappenv::Lic['MultiBranch']) {
                    $TargetBranch = $this->GetProductBranch($product_id, false);
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
                $total_sales = $unit_sales * $product_qty;
                $total_sales_G += $total_sales;
                $tax_total = 0; //todo fill when tax added
                $tax_total_G += $tax_total;
                $customer_benefit_total = ($unit_Price * $product_qty) - $total_sales;
                $customer_benefit_total_G += $customer_benefit_total;
                if (!is_int((int) $product_qty)) {
                    return abort('404', 'مشکل امنیتی کد : ۱۴۸۳ ');
                }
                if ($product_qty < 1) {
                    return abort('404', 'مشکل امنیتی کد : ۱۴۸۴ ');
                }
                if ($request->input('shipping') == 'post') {

                    $shipping_amount = $request->input('TotalDeleveryPriceFinalInput');
                } else {
                    $shipping_amount = 0;
                }
                $shipping_total_G += $shipping_amount;
                $net_total = ($ProductTarget->Price - $ProductTarget->BuyPrice) * $product_qty;
                $net_total_G += $net_total;
                $MainDeviceOrderID = null;
                if ($ProductTarget->MinPrice != 0) { //
                    $MainDeviceOrderID = $this->GetDeviceOrder();
                    $TargetBranchsrc = branches::where('id', $TargetBranch)->first();
                    $DataToSave = [
                        'ContractNumber' => $MainDeviceOrderID,
                        'SubItem' => $SubItem++,
                        'Device' => $ProductWarehouseID,
                        'product_qty' => $product_qty,
                        'product_id' => $product_id,
                        'customer_id' => Auth::id(),
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
                    $ProductItemData = [
                        'order_id' => $ProductOrderId,
                        'product_id' => $product_id,
                        'pw_id' => $ProductWarehouseID,
                        'product_qty' => $product_qty,
                        'customer_id' => Auth::id(),
                        'unit_Price' => $unit_Price,
                        'unit_sales' => $unit_sales,
                        'total_sales' => $total_sales,
                        'tax_total' => $tax_total,
                        'customer_benefit_total' => $customer_benefit_total,
                        'shipping_amount' => $shipping_amount,
                        'weight' => $ItemWeight,
                        'net_total' => $net_total,
                        'branch' => $TargetBranch,
                    ];
                    product_order_items::create($ProductItemData);
                }
            }
            $OrderPostData = [
                'num_items_sold' => $num_items_sold,
                'total_sales' => $total_sales_G,
                'tax_total' => $tax_total_G,
                'customer_benefit_total' => $customer_benefit_total_G,
                'shipping_total' => $shipping_total_G,
                'net_total' => $net_total_G,
                'TotallWeight' => $TotallWeight,
                'DeviceContract' => $MainDeviceOrderID,
            ];
            $InsertResult = product_order::where('id', $ProductOrderId)->update($OrderPostData);
            if ($InsertResult == 1) {
                $ResNum = $ProductOrderId; // Invoice Number
                if ($payType == 'bank') {
                    if (myappenv::Bank == 'pasargad') {
                        $price = $total_sales_G + $shipping_total_G; // Price Rial
                        $ResNum = $ProductOrderId; // Invoice Number
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
                    if (myappenv::Bank == 'IKC') {
                        $TashimToPay *= -1;
                        $price = $TashimToPay + $shipping_total_G; // Price Rial
                        if ($price == 0) {
                            $price = 100000;
                        }
                        Session::put('price', $price);
                        Session::put('ResNum', $ResNum);
                        $RedirectURL = route('seppay');
                        return redirect()->route('ikc');
                    }
                    if (myappenv::Bank == 'shafatel') {

                        $MyDirectPay = new DirectPayment();
                        $payername = Auth::user()->Name . ' ' . Auth::user()->Family;
                        $Mobile = Auth::user()->Mobile;
                        $InvoiceNumer = $ProductOrderId;
                        $Owner = Auth::id();
                        $Note = "صورت حساب شماره :" . $InvoiceNumer;
                        $Amount = $total_sales_G + $shipping_total_G;
                        $Result = $MyDirectPay->PepDirectPayAdd($Amount, '93000' . $InvoiceNumer, $Owner, $payername, $Mobile, $Note);
                        Session::put('price', $Amount);
                        Session::put('ResNum', $InvoiceNumer);
                        return redirect()->to('https://shafatel.com/pep/?payment=' . $Result);
                    }
                    if (myappenv::Bank == 'sep') {
                        $price = $total_sales_G + $shipping_total_G; // Price Rial
                        Session::put('price', $price);
                        Session::put('ResNum', $ResNum);
                        $MerchantCode = "12155575";
                        $RedirectURL = route('seppay');
                        echo "<form id='samanpeyment' action='https://sep.shaparak.ir/payment.aspx' method='post'>  <input type='hidden' name='Amount' value='{$price}' />      <input type='hidden' name='ResNum' value='{$ResNum}'>  <input type='hidden' name='RedirectURL' value='{$RedirectURL}'/>   <input type='hidden' name='MID' value='{$MerchantCode}'/>  </form>";
                    }
                    if (myappenv::Bank == 'PEC') {
                        $price = $total_sales_G + $shipping_total_G; // Price Rial
                        Session::put('price', $price);
                        Session::put('ResNum', $ResNum);
                        $PEC = new PECMain;
                        return ($PEC->request($price));
                    }
                } elseif ($payType == 1) {
                    $MyTransfer = new TransferProduct($ResNum);
                    $resutl = $MyTransfer->UserPay(0, 0, 1);
                    if ($resutl) {
                        $price = $total_sales_G + $shipping_total_G;
                        $RResult = array('Mony' => $price, 'Confirmdate' => date("Y-m-d H:i:s"), 'GateWay' => 'کیف پول');
                        Session::put('price', null);
                        Session::put('ResNum', null);
                        $UserInfo = Auth::user();
                        Session::put('basket', null);
                        $MySMS = new SmsCenter();
                        $CustomerText = 'سلام ' . Auth::user()->Name . ' ' . Auth::user()->Family . ' عزیز' . "\n";
                        $CustomerText .= 'سفارش شما به شماره ' . $ResNum . ' با موفقیت ثبت شد.' . "\n";
                        $CustomerText .= 'با تشکر از خرید شما.' . "\n";
                        $CustomerText .= myappenv::CenterName;
                        $MySMS->OndemandSMS($CustomerText, Auth::user()->MobileNo, 'tnks', Auth::user()->MobileNo);
                        $SellerText = 'سلام مدیر سفارش ' . $ResNum . 'با مبلغ ' . number_format($price) . ' در سامانه ثبت شد!';
                        if (myappenv::MainOwner == 'shafatel' || myappenv::MainOwner == 'Carpetour') {
                            $MySMS->OndemandSMS($SellerText, '09126543802', 'tnks', '09126543802');
                        } else {
                            //  $MySMS->OndemandSMS($SellerText, '09123345580', 'tnks', '09123345580');
                        }
                        $this->AddLog($ResNum);
                        $MySMS->OndemandSMS($SellerText, '09123936105', 'tnks', '09123936105');
                        if (myappenv::MainOwner == 'kookbaz') {
                            $MySMS->OndemandSMS($SellerText, '09125833245', 'tnks', '09125833245');
                            $MySMS->OndemandSMS($SellerText, '09192228284', 'tnks', '09192228284');
                        }
                        return view("Credit.ConfirmPay", ['Result' => $RResult, 'UserInfo' => $UserInfo]);
                    } else {
                        return abort('404', 'در انجام تراکنش مشکلی پیش آمده لطفا با فروشگاه تماس بگیرید 14693  ');
                    }
                } elseif ($payType == 2) {
                    $MyTransfer = new TransferProduct($ResNum);
                    $resutl = $MyTransfer->ConfirmOrder();
                    $price = $total_sales_G + $shipping_total_G;
                    $RResult = array('Mony' => $price, 'Confirmdate' => date("Y-m-d H:i:s"), 'GateWay' => 'کیف پول');
                    Session::put('price', null);
                    Session::put('ResNum', null);
                    $UserInfo = Auth::user();
                    Session::put('basket', null);
                    $MySMS = new SmsCenter();
                    $CustomerText = 'سلام ' . Auth::user()->Name . ' ' . Auth::user()->Family . ' عزیز' . "\n";
                    $CustomerText .= 'سفارش شما به شماره ' . $ResNum . ' با موفقیت ثبت شد.' . "\n";
                    $CustomerText .= 'با تشکر از خرید شما.' . "\n";
                    $CustomerText .= myappenv::CenterName;
                    $MySMS->OndemandSMS($CustomerText, Auth::user()->MobileNo, 'tnks', Auth::user()->MobileNo);
                    $SellerText = 'سلام مدیر سفارش ' . $ResNum . 'با مبلغ ' . number_format($price) . ' در سامانه ثبت شد!';
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
                    }
                    return view("Credit.ConfirmPay", ['Result' => $RResult, 'UserInfo' => $UserInfo]);
                }
            } else {
                return abort('404');
            }
        } elseif ($request->input('submit') == 'deleteorder') {
            Session::put('basket', null);
            return redirect()->back()->with('success', 'موارد از سبد خرید حذف گردید');
        }
    }
    public function UnitManagement()
    {
        $ProductUnits = ProductUnitMeta::all();
        return view('woocommerce.admin.ProductUnitMeta', ['ProductUnits' => $ProductUnits]);
    }
    public function DoUnitManagement(Request $request)
    {
        if ($request->input('submit') == 'AddUnit') {
            if ($request->input('MainUnit') == 0) { // has not mother unit
                $SaveData = [
                    'Name' => $request->input('Name'),
                ];
            } else {
                if ($request->input('MultiplNumber') > 0) {
                } else {
                    return abort('404', 'تعداد واحد زیر مجموعه وارد نشده است');
                }
                $SaveData = [
                    'Name' => $request->input('Name'),
                    'MainUnit' => $request->input('MainUnit'),
                    'MultiplNumber' => $request->input('MultiplNumber'),
                ];
            }
            ProductUnitMeta::create($SaveData);
            return redirect()->back()->with('success', 'واحد با موفقیت اضافه شد!');
        }
    }
    public function is_management_login()
    {
        if (Auth::check()) {
            if (Auth::user()->Role >= myappenv::role_admin) {
                $management = true;
            } else {
                $management = false;
            }
        } else {
            $management = false;
        }
        return $management;
    }
    private function loger($log_text = 'salam')
    {
        if (Auth::check()) {
            if (Auth::id() == 'j8cpgutgo947le9e') {
                Log::channel('single')->info($log_text);
            }
        }
    }
    private function L3ShowProduct($request, $Tags = null, $TagName = null, $post_src = null)
    {
        if ($request->ajax()) {


            if ($request->has('menu')) {

                if ($request->input('menu') == 'l1') {
                    $L1Src = Indexes::get_l1_menu();
                    return view('Layouts.Theme1.objects.indexmanu', ['layer' => 'l1', 'L1Src' => $L1Src])->render();
                } elseif ($request->input('menu') == 'l2') {
                    $L1Id = $request->input('l1');
                    $L2Id = $request->input('l2');
                    $L2Src = Indexes::get_l2_menu($L1Id, $L2Id);
                    return view('Layouts.Theme1.objects.indexmanu', ['layer' => 'l2', 'header' => $request->input('l1nmae'), 'L2Src' => $L2Src])->render();
                } elseif ($request->input('menu') == 'l3') {
                    $L1Id = $request->input('l1');
                    $L2Id = $request->input('l2');
                    $L3Src = Indexes::get_l3_menu($L1Id, $L2Id);
                    $header = $request->input('header') . ' - ' . $request->input('l1nmae');
                    return view('Layouts.Theme1.objects.indexmanu', ['layer' => 'l3', 'header' => $header, 'L3Src' => $L3Src])->render();
                }
            }

            if ($request->has('sort')) {
                $SearchArray = json_decode(Session::get('search_condition'), true);
                if (isset($SearchArray['sort'])) { //set sort before
                    $SearchArray['sort'] = $request->input('sort');
                } else {
                    $SearchArray = arr::add($SearchArray, 'sort', $request->input('sort'));
                }
                $Tosave = json_encode($SearchArray);
                Session::put('search_condition', $Tosave);
            }
            $Goods = $this->GetProductsV1($Tags ?? null, null);
            $theme = myappenv::ShopTheme;
            $management = $this->is_management_login();
            $MyProduct = new product;
            return view("Layouts.$theme.objects.ProductListFeilds", ['Goods' => $Goods, 'management' => $management, 'MyProduct' => $MyProduct])->render();
        }
        $SearchArray = null;
        if (Session::has('search_condition')) {
            $SearchArray = json_decode(Session::get('search_condition'), true);
            if ($request->has('sort')) {
                if (isset($SearchArray['sort'])) { //set sort before
                    $SearchArray['sort'] = $request->input('sort');
                } else {
                    $SearchArray = arr::add($SearchArray, 'sort', $request->input('sort'));
                }
                $Tosave = json_encode($SearchArray);
                Session::put('search_condition', $Tosave);
            }

            if ($request->has('condition')) {
                $SearchArray = json_decode(Session::get('search_condition'), true);
                if ($request->input('value') == 'yes') {

                    $SearchArray = arr::add($SearchArray, $request->input('condition'), $request->input('value'));
                    $Tosave = json_encode($SearchArray);
                    Session::put('search_condition', $Tosave);
                } elseif ($request->input('value') == 'no') {
                    $ConditionKey = $request->input('condition');
                    unset($SearchArray[$ConditionKey]);
                    $Tosave = json_encode($SearchArray);
                    Session::put('search_condition', $Tosave);
                }
            }
        } else { // not set search conditions
            $SearchArray = null;
            if ($request->has('sort')) {
                $InputArray = [
                    'sort' => $request->input('sort'),
                ];
                $SearchArray = $InputArray;
                $Tosave = json_encode($InputArray);
                Session::put('search_condition', $Tosave);
            }
            if ($request->has('condition')) {
                $InputArray = [
                    $request->input('condition') => $request->input('value'),
                ];
                $SearchArray = $InputArray;
                $Tosave = json_encode($InputArray);
                Session::put('search_condition', $Tosave);
            }
            if ($request->has('from_price') && $request->has('to_price')) {
                $InputArray = [
                    'from_price' => $request->input('from_price'),
                    'to_price' => $request->input('to_price'),
                ];
                $SearchArray = $InputArray;
                $Tosave = json_encode($InputArray);
                Session::put('search_condition', $Tosave);
            }
        }
        $Carrency = new currency();
        $SessionArray = json_decode(Session::get('basket'));
        $BuyArray = array();
        if (isset($SessionArray)) {
            foreach ($SessionArray as $SessionArrayTarget) {
                array_push($BuyArray, $SessionArrayTarget[0]);
            }
        }
        if ($Tags != null) {
            if (!is_numeric($Tags)) {
                return abort('404', 'لینک درخواست شده وجود ندارد!');
            }
            $targetTag = L3Work::where('UID', $Tags)->first();
            if ($targetTag == null) {
                return abort('404', 'لینک درخواست شده وجود ندارد!');
            } else {
                if ($targetTag->Name != $TagName) {
                    return redirect()->route('ShowProduct', ['TagName' => $targetTag->Name, 'Tags' => $Tags]);
                }
            }
        }
        $SiteElements = new main();
        $theme = myappenv::ShopTheme;
        $menu = Indexes::get_index_id();
        $matas = L2Work::where('WorkCat', $menu->WorkCat)->where('L1ID', $menu->L1ID)->get();
        $get_cats = L3Work::where('UID', $Tags)->first();
        $Cats = [];
        $L2 = null;
        if ($get_cats != null) {
            $L2 = $get_cats->L2ID;
            $Cats = L3Work::where('WorkCat', $menu->WorkCat)->where('L1ID', $menu->L1ID)->where('L2ID', $get_cats->L2ID)->orderBy('L3ID')->get();
        }
        // $Cats = L3Work::where('WorkCat', 4)->where('L1ID', 1)->where('L2ID', $Tags)->orderBy('L3ID')->get();
        return view("Layouts.$theme.ProductList", ['post_src' => $post_src, 'L2' => $L2, 'matas' => $matas, 'Cats' => $Cats, 'SearchArray' => $SearchArray, 'Tags' => $Tags, 'TagName' => $TagName, 'SiteElements' => $SiteElements, 'Carrency' => $Carrency, 'Goods' => [], 'BuyArray' => $BuyArray]);

    }
    public function L2ShowProduct($Tags, $TagName, $post_src = null)
    {

        $TagScName = $Tags['TagsrcName'];
        $Carrency = new currency();
        $SessionArray = json_decode(Session::get('basket'));
        $BuyArray = array();
        if (isset($SessionArray)) {
            foreach ($SessionArray as $SessionArrayTarget) {
                array_push($BuyArray, $SessionArrayTarget[0]);
            }
        }
        $Tags = $this->GetL2Products($Tags);
        $SiteElements = new main();
        $DashboardClass = new DashboardClass();
        return view('woocommerce.Customer.ProductListL2', ['post_src' => $post_src, 'TagScName' => $TagScName, 'DashboardClass' => $DashboardClass, 'TagName' => '$TagName', 'SiteElements' => $SiteElements, 'Carrency' => $Carrency, 'Tags' => $Tags, 'BuyArray' => $BuyArray]);
    }
    public function ShowProduct(Request $request, $Tags = null, $TagName = null, $post_src = null)
    {
        if (!$request->has('l2')) {
            if ($post_src == null) {
                if ($Tags != null) {
                    $post_src = posts::where('MainIndex', $Tags)->where('Type', '>', 1)->where('status', 1)->first();
                }
            }
            return $this->L3ShowProduct($request, $Tags, $TagName, $post_src);
        } else {
            if ($request->has('l2')) {
                $L2 = $request->input('l2');
            } else {
                $L2 = null;
            }
            if ($request->has('l1')) {
                $L1 = $request->input('l1');
            } else {
                $L1 = null;
            }
            if ($request->has('TagsrcName')) {
                $TagsrcName = $request->input('TagsrcName');
            } else {
                $TagsrcName = null;
            }
            $Tags = [
                'L1' => $L1,
                'L2' => $L2,
                'TagsrcName' => $TagsrcName,
            ];
            if ($L2 != null) {
                return $this->L2ShowProduct($Tags, $TagName, $post_src);
            } else {
                return abort('404', 'صفحه درخواستی موجود نیست');
            }
        }
    }
    public function DoShowProduct(Request $request, $Tags = null)
    {
        if ($request->ajax()) {
            if ($request->has('menu')) {

                if ($request->input('menu') == 'l3') {
                    $L1Id = $request->input('l1');
                    $L2Id = $request->input('l2');
                    $L3Src = Indexes::get_l3_menu($L1Id, $L2Id);
                    $header = $request->input('header') . ' - ' . $request->input('l1nmae');
                    return view('Layouts.Theme1.objects.indexmanu', ['layer' => 'l3', 'header' => $header, 'L3Src' => $L3Src])->render();
                }
            }
            if ($request->has('sort')) {
                $SearchArray = json_decode(Session::get('search_condition'), true);
                if (isset($SearchArray['sort'])) { //set sort before
                    $SearchArray['sort'] = $request->input('sort');
                } else {
                    $SearchArray = arr::add($SearchArray, 'sort', $request->input('sort'));
                }
                $Tosave = json_encode($SearchArray);
                Session::put('search_condition', $Tosave);
            }
            if ($Tags == null) {
                $Goods = $this->GetProductsV1(null, null);
            } else {
                $Goods = $this->GetProductsV1($Tags, null);
            }

            return response()->json($Goods);
        }
    }
    public function AddGoodToWarehouse()
    {
        if (Gate::allows('shopadmin_') || Gate::allows('root_')) {

            if (Session::has('MyStore')) {
                $TargetStoreID = Session::get('MyStore');
                $TargetStore = store::where('id', $TargetStoreID)->first();
                $Warehouses = warehouse::all()->where('StoreID', $TargetStoreID);
            } else {
                $TargetStore = null;
            }
        } else {
            $TargetStore = store::where('branch', Auth::user()->branch)->first();
            $Warehouses = warehouse::all()->where('StoreID', $TargetStore->id);
        }

        if ($TargetStore == null) {
            return abort('404', "فروشگاهی برای شما تعریف نشده است!");
        }

        $Goods = goods::all();
        return view("woocommerce.admin.AddGoodToWarehouse", ['TargetStore' => $TargetStore, 'Warehouses' => $Warehouses, 'Goods' => $Goods]);
    }
    public function DoAddGoodToWarehouse(Request $request)
    {
        $warehouse = new \App\Shop\warehouse;
        if ($request->input('submit') == 'offline') {
            $warehouse->add_product_to_warehouse_offline($request);
            $AddType = 'Offline';
        } else {
            $insrt_data = $warehouse->add_product_to_warehouse_online($request);
            return redirect()->back()->with('success', __("success alert"));
        }


        dd($request->input());
        if ($request->input('submit') == 'offline') {
            $AddType = 'Offline';
        } else {
            $AddType = 'online';
        }
        if ($request->has('ProductType')) {
            $ProductType = $request->input('ProductType');
        } else {
            $ProductType = 'good';
        }
        if ($request->input('AlertFinish') == 'on') {
            $AlertFinish = 1;
        } else {
            $AlertFinish = 0;
        }

        if ($request->has('MadeDate') && $request->input('MadeDate') != null) {
            $MadeDate = $request->input('MadeDate');
        } else {
            $MadeDate = '0001-01-01 00:00:00';
        }

        if ($AddType == 'online') {
            $Price = $request->input('Price');
            $MaxPrice = 0;
            $MinPrice = 0;
        }
        if ($AddType == 'Offline') {
            $MaxPrice = $request->input('MaxPrice');
            $MinPrice = $request->input('MinPrice');
            $Note = $request->input('Note');
            $Price = 0;
        }

        $PriceUniqu = true;
        if (is_array($Price)) {
            $PriceFormola = array();
            $PriceUniqu = false;
            $ToNumber = $request->input('ToNumber');
            $counter = 1;
            for ($counter; $counter < 14; $counter++) {
                if ($ToNumber[$counter] == null || $Price[$counter] == null) {
                    break;
                }

                array_push($PriceFormola, ['ToNumber' => $ToNumber[$counter], 'Price' => $Price[$counter]]);
            }
            $PriceFormola = json_encode($PriceFormola);
        }
        if (Auth::user()->Role == myappenv::role_SuperAdmin || Auth::user()->Role == myappenv::role_ShopAdmin) {
            $old_warehouse = warehouse_goods::where('GoodID', $request->input('GoodID'))->where('OnSale', 1)->first();
            $OnSale = 0;
            if ($old_warehouse == null) {
                $OnSale = 1;
            }

            $Owner = $request->input('UserName');
        } else {
            $OnSale = 10;
            $TargetStore = store::where('branch', Auth::user()->branch)->first();
            $Owner = $TargetStore->Owner;
        }
        if ($AddType == 'online') {
            if ($PriceUniqu) {
                if ($ProductType == 'good') {
                    $Data = [
                        'WarehouseID' => $request->input('WarehouseID'),
                        'GoodID' => $request->input('GoodID'),
                        'QTY' => $request->input('QTY'),
                        'Remian' => $request->input('QTY'),
                        'BuyPrice' => $request->input('BuyPrice'),
                        'Price' => $Price,
                        'OnSale' => $OnSale,
                        'SaleLimit' => $request->input('QTY'),
                        'AlertLimit' => $request->input('AlertLimit'),
                        'AlertFinish' => $AlertFinish,
                        'InputDate' => $request->input('InputDate'),
                        'MadeDate' => $MadeDate,
                        'ExpireDate' => $request->input('ExpireDate'),
                        'ActiveTime' => now(),
                        'BasePrice' => $request->input('BasePrice'),
                        'DeactiveTime' => now(),
                        'MaxPrice' => 0,
                        'MinPrice' => 0,
                        'owner' => $Owner,

                    ];
                } elseif ($ProductType == 'SpecialAccount') {
                    $TargetGood = goods::where('id', $request->input('GoodID'))->first();
                    $Days = $TargetGood->weight;
                    $AccountArray = [
                        'type' => 'SpecialAccount',
                        'Days' => $Days,
                        'TargetRole' => $request->input('TargetRole'),
                    ];
                    $extra = json_encode($AccountArray);
                    $Data = [
                        'WarehouseID' => $request->input('WarehouseID'),
                        'GoodID' => $request->input('GoodID'),
                        'QTY' => $request->input('QTY'),
                        'Remian' => $request->input('QTY'),
                        'BuyPrice' => $request->input('BuyPrice'),
                        'Price' => $Price,
                        'OnSale' => $OnSale,
                        'SaleLimit' => $request->input('QTY'),
                        'AlertLimit' => $request->input('AlertLimit'),
                        'AlertFinish' => $AlertFinish,
                        'InputDate' => now(),
                        'MadeDate' => $MadeDate,
                        'ExpireDate' => now(),
                        'ActiveTime' => now(),
                        'BasePrice' => $request->input('BasePrice'),
                        'extra' => $extra,
                        'MaxPrice' => 0,
                        'MinPrice' => 0,
                        'DeactiveTime' => now(),
                        'owner' => $Owner,

                    ];
                }
            } else {
                $Data = [
                    'WarehouseID' => $request->input('WarehouseID'),
                    'GoodID' => $request->input('GoodID'),
                    'QTY' => $request->input('QTY'),
                    'BuyPrice' => $request->input('BuyPrice'),
                    'Price' => 0,
                    'PricePlan' => $PriceFormola,
                    'OnSale' => $OnSale,
                    'SaleLimit' => $request->input('QTY'),
                    'AlertLimit' => $request->input('AlertLimit'),
                    'AlertFinish' => $AlertFinish,
                    'InputDate' => $request->input('InputDate'),
                    'MadeDate' => $MadeDate,
                    'ExpireDate' => $request->input('ExpireDate'),
                    'ActiveTime' => now(),
                    'BasePrice' => $request->input('BasePrice'),
                    'Remian' => $request->input('QTY'),
                    'MaxPrice' => 0,
                    'MinPrice' => 0,
                    'DeactiveTime' => now(),
                    'owner' => $Owner,

                ];
            }
        }
        if ($AddType == 'Offline') {
            $Data = [
                'WarehouseID' => $request->input('WarehouseID'),
                'GoodID' => $request->input('GoodID'),
                'QTY' => 1,
                'Remian' => 1,
                'BuyPrice' => $request->input('BuyPrice'),
                'Price' => 0,
                'OnSale' => $OnSale,
                'SaleLimit' => 1,
                'AlertLimit' => 1,
                'AlertFinish' => 1,
                'InputDate' => now(),
                'MadeDate' => now(),
                'ExpireDate' => now(),
                'ActiveTime' => now(),
                'BasePrice' => 0,
                'DeactiveTime' => now(),
                'MaxPrice' => $MaxPrice,
                'MinPrice' => $MinPrice,
                'extra' => $Note,
                'owner' => $Owner,

            ];
        }

        $UserID = Auth::id();
        $ArryData = [
            'BuyPrice' => $request->input('BuyPrice'),

        ];
        $reportData = json_encode($ArryData);
        $SaveData = [
            'ProductID' => $request->input('GoodID'),
            'WGID' => $request->input('WarehouseID'),
            'UserID' => $UserID,
            'ReportType' => 5, //add product
            'ReportVal' => $reportData,
        ];
        report_detial::create($SaveData);


        $Result = warehouse_goods::create($Data);
        return redirect()->back()->with('success', __("success alert"));
    }

    public function ProductIndex($id, $iframe = false)
    {
        if (Auth::user()->Role == myappenv::role_SuperAdmin || Auth::user()->Role == myappenv::role_ShopAdmin) {
        } else {
            return abort('404', 'دسترسی غیر مجاز!');
        }
        $WorkCats = WorkCat::all();
        $L1Works = L1Work::all();
        $L2Works = L2Work::all();
        $L3Works = L3Work::all();
        $Query = "SELECT
        goodindices.id as id ,L3Work.Name as L3Name , L2Work.Name as L2Name , L1Work.Name as L1Name , WorkCat.Name as WorkcatName
    FROM
        goodindices
    inner join L3Work on
        goodindices.IndexID = L3Work.UID
    INNER JOIN L2Work on
        L3Work.L2ID = L2Work.L2ID
        and L2Work.L1ID = L3Work.L1ID
        AND L2Work.WorkCat = L3Work.WorkCat
    INNER JOIN L1Work on
        L1Work.L1ID = L3Work.L1ID
        AND L1Work.WorkCat = L3Work.WorkCat
    INNER JOIN WorkCat on
        WorkCat.ID = L3Work.WorkCat
    WHERE
        goodindices.GoodID = $id";
        $GoodIndexes = DB::select($Query);
        $MyIndex = new Indexes();
        $IndexTree = $MyIndex->HTMLTreeIndex_cover_admin();
        return view('woocommerce.admin.GoodIndex', ['iframe' => $iframe, 'IndexTree' => $IndexTree, 'GoodIndexes' => $GoodIndexes, 'WorkCats' => $WorkCats, 'L1Works' => $L1Works, 'L2Works' => $L2Works, 'L3Works' => $L3Works]);
    }
    public function DoProductIndex($id, Request $request)
    {
        if (Auth::user()->Role == myappenv::role_SuperAdmin || Auth::user()->Role == myappenv::role_ShopAdmin) {
        } else {
            return abort('404', 'دسترسی غیر مجاز!');
        }

        if ($request->has('submit')) {
            if ($request->input('submit') == 'multiindex') {
                foreach ($request->input('check_list') as $IndexID) {
                    $Result = goodindex::where('GoodID', $id)->where('IndexID', $IndexID)->first();
                    if ($Result == null) {
                        $IndexData = [
                            'GoodID' => $id,
                            'IndexID' => $IndexID,
                            'CreateDate' => now(),
                            'Creator' => Auth::id(),
                        ];
                        goodindex::create($IndexData);
                    }
                }
                return redirect()->back()->with('success', 'شاخص ها به سیستم اضافه گردید');
            }
        }
        if ($request->has('delete')) {
            goodindex::where('id', $request->input('delete'))->delete();
            return redirect()->back()->with('success', __("success alert"));
        } elseif ($request->has('addindex')) {
            $Result = goodindex::where('GoodID', $id)->where('IndexID', $request->input('L3Work'))->first();
            if ($Result == null) {

                $IndexData = [
                    'GoodID' => $id,
                    'IndexID' => $request->input('L3Work'),
                    'CreateDate' => now(),
                    'Creator' => Auth::id(),
                ];
                goodindex::create($IndexData);
            }
            return redirect()->back()->with('success', __("success alert"));
        } else {
            if ($request->input('WorkCatAdd') != '' || $request->input('WorkCatAdd') != null) {
                $WorkCatData = [
                    'Name' => $request->input('WorkCatAdd'),
                    'img' => '',
                ];
                WorkCat::create($WorkCatData);
                return redirect()->back()->with('success', __("success alert"));
            } elseif ($request->input('L1Add') != '' || $request->input('L1Add') != null) {
                $LastID = L1Work::where('WorkCat', $request->input('WorkCat'))->max('L1ID');
                if ($LastID == null) {
                    $LastID = 1;
                } else {
                    $LastID++;
                }
                $L1WorkData = [
                    'WorkCat' => $request->input('WorkCat'),
                    'L1ID' => $LastID,
                    'Name' => $request->input('L1Add'),
                    'img' => '',
                ];
                L1Work::create($L1WorkData);
                return redirect()->back()->with('success', __("success alert"));
            } elseif ($request->input('L2Add') != '' || $request->input('L2Add') != null) {
                $LastID = L2Work::where('WorkCat', $request->input('WorkCat'))->where('L1ID', $request->input('L1Work'))->max('L2ID');
                if ($LastID == null) {
                    $LastID = 1;
                } else {
                    $LastID++;
                }
                $L2WorkData = [
                    'WorkCat' => $request->input('WorkCat'),
                    'L1ID' => $request->input('L1Work'),
                    'L2ID' => $LastID,
                    'Name' => $request->input('L2Add'),
                    'img' => '',
                ];
                L2Work::create($L2WorkData);
                return redirect()->back()->with('success', __("success alert"));
            } elseif ($request->input('L3Add') != '' || $request->input('L3Add') != null) {
                $LastID = L3Work::where('WorkCat', $request->input('WorkCat'))->where('L1ID', $request->input('L1Work'))->where('L2ID', $request->input('L2Work'))->max('L3ID');
                if ($LastID == null) {
                    $LastID = 1;
                } else {
                    $LastID++;
                }
                if ($request->input('pic') == null) {
                    $PicAddress = ' ';
                } else {
                    $PicAddress = $request->input('pic');
                }
                $L3WorkData = [
                    'WorkCat' => $request->input('WorkCat'),
                    'L1ID' => $request->input('L1Work'),
                    'L2ID' => $request->input('L2Work'),
                    'L3ID' => $LastID,
                    'Name' => $request->input('L3Add'),
                    'Description' => '',
                    'img' => $PicAddress,
                ];
                L3Work::create($L3WorkData);
                return redirect()->back()->with('success', __("success alert"));
            }
        }
    }
    public function EditProduct($id, Request $request)
    {


        $UserBranch = Auth()->user()->branch;
        $good = goods::where('id', $id)->first();
        if ($good->Virtual == 0) {
            $ProductType = 'good';
        } elseif ($good->Virtual == 2) {
            $ProductType = 'SpecialAccount';
        }
        $GoodInWarehouse = warehouse_goods::where('GoodID', $id)->first();
        if ($GoodInWarehouse != null) {
            if ($GoodInWarehouse->extra == null) {
                $extra = null;
            } else {
                $extra = json_decode($GoodInWarehouse->extra);
            }
            $TargetStore = store::where('id', $GoodInWarehouse->StoreID)->first();
            if ($UserBranch != myappenv::Branch) {
                $AccessType = 'owner';
                if ($TargetStore != null) {
                    if ($TargetStore->branch != $UserBranch) {
                        return abort(404, 'این کالا در فروشگاه دیگری موجود است!');
                    }
                }
            } else { // admin access
                $AccessType = 'admin';
            }
        } else {
            $extra = null;
            if ($UserBranch != myappenv::Branch) {
                $AccessType = 'owner';
            } else {
                $AccessType = 'admin';
            }
        }
        if ($UserBranch == myappenv::Branch) {
            $Warehouses = warehouse::all();
        } else {
            $query = "SELECT
            w.*
            FROM
            warehouses as w INNER JOIN stores as s on w.StoreID = s.id

            WHERE s.branch = $UserBranch";
            $Warehouses = DB::select($query);
        }
        if ($good == null) {
            return 'محصول مورد درخواست وجود ندارد!';
        }
        $ProductUnits = ProductUnitMeta::all()->where('MainUnit', null);
        if ($good->MainDescription != null) {
            $TextArr = json_decode($good->MainDescription);
            if (json_last_error() === 0) {
                $TextArr = $TextArr;
            } else {
                $TextArr = null;
            }
        } else {
            $TextArr = null;
        }
        if ($ProductType == 'good') {
            $reportData = report_overview::all();
            $Tashims = tashim::all()->where('ItemOrder', 0);
            if ($GoodInWarehouse != null) {

                $TashimItems = tashim_items::where('GoodsID', $GoodInWarehouse->id)->get();
                $GoodReport = report_detial::where('ProductID', $GoodInWarehouse->GoodID)->orderBy('id', 'DESC')->get();
            } else {
                $TashimItems = null;
                $GoodReport = null;
            }
            $Product = new ProductClass();
            $Product->GoodIDSetter($id);
            if ($request->has('page')) {
                if ($request->page == 'EditGood') {
                    if ($AccessType == 'admin') {
                        return view("woocommerce.admin.EditGood_Stock_Admin", ['Product' => $Product, 'GoodReport' => $GoodReport, 'TashimItems' => $TashimItems, 'Tashims' => $Tashims, 'AccessType' => $AccessType, 'Warehouses' => $Warehouses, 'GoodInWarehouse' => $GoodInWarehouse, 'TextArr' => $TextArr, 'good' => $good, 'ProductUnits' => $ProductUnits])->render();
                    } else {
                        return view("woocommerce.admin.EditGood_Stock_User", ['Product' => $Product, 'GoodReport' => $GoodReport, 'TashimItems' => $TashimItems, 'Tashims' => $Tashims, 'AccessType' => $AccessType, 'Warehouses' => $Warehouses, 'GoodInWarehouse' => $GoodInWarehouse, 'TextArr' => $TextArr, 'good' => $good, 'ProductUnits' => $ProductUnits])->render();
                    }
                }
            }
            $key_words = new meta_keyword;
            $MultiWarehouse = "SELECT wg.id as wgid , w.id as WarehouseID , w.Name ,  wg.Remian ,wg.OnSale
            from warehouse_goods as wg
            INNER JOIN warehouses as w on w.id = wg.WarehouseID
            WHERE wg.GoodID = $id";
            $MultiWarehouse = DB::select($MultiWarehouse);
            $Tags = $key_words->get_item_tags($id, 2);
            return view("woocommerce.admin.EditGood", ['Tags' => $Tags, 'MultiWarehouse' => $MultiWarehouse, 'Product' => $Product, 'GoodReport' => $GoodReport, 'TashimItems' => $TashimItems, 'Tashims' => $Tashims, 'AccessType' => $AccessType, 'Warehouses' => $Warehouses, 'GoodInWarehouse' => $GoodInWarehouse, 'TextArr' => $TextArr, 'good' => $good, 'ProductUnits' => $ProductUnits]);
        } elseif ($ProductType == 'SpecialAccount') {
            $Roles = UserRole::all()->where('Role', '!=', 100);
            return view("woocommerce.admin.EditSpecialAccount", ['extra' => $extra, 'Roles' => $Roles, 'AccessType' => $AccessType, 'Warehouses' => $Warehouses, 'GoodInWarehouse' => $GoodInWarehouse, 'TextArr' => $TextArr, 'good' => $good, 'ProductUnits' => $ProductUnits]);
        }
    }
    private function AddProductAttrebute($Attr)
    {
        /*
        $Attr = [
        'AttName'=>$request->AttName,
        'Attval'=>$request->Attval,
        'AttRemain'=>$request->AttRemain,
        'AttBuyPrice'=>$request->AttBuyPrice,
        'AttPrice'=>$request->AttPrice,
        'AttBasePrice'=>$request->AttBasePrice,
        'AttNote'=>$request->AttNote,
        'WGID'=>$request->WGID,
        ];
         */
        $meta_value = json_encode($Attr);
        $Data = [
            'tt' => 'warehouse_goods',
            'fgint' => $Attr['WGID'],
            'meta_key' => 'ProductAttribute',
            'meta_value' => $meta_value,
            'status' => 1,
        ];
        metadata::create($Data);
        return 'افزودن موفقیت آمیز';
    }
    public function LoadProductAttribute($WgID)
    {
        $Metas = metadata::where('fgint', $WgID)->where('tt', 'warehouse_goods')->where('meta_key', 'ProductAttribute')->get();
        $MetaData = array();
        foreach ($Metas as $MetaItem) {
            $MetaDataArr = json_decode($MetaItem->meta_value);
            array_push($MetaData, $MetaDataArr);
        }
        return $MetaData;
    }

    public function DoEditProduct($id, Request $request)
    {
        if ($request->has('send_sms')) {
            if ($request->send_sms == 'like') {
                $sms_center = new SMSDotIR;
                $cname = $request->c_name;
                $cphone = $request->c_phone;
                $product_src = goods::where('id', $id)->first();
                foreach ($cname as $nameindex => $name_item) {
                    $phone = $cphone[$nameindex];
                    $name = $name_item;
                    $arr = [
                        [
                            "name" => "NAME",
                            "value" => $name
                        ],
                        [
                            "name" => "PRODUCT",
                            "value" => substr($product_src->NameEn, 0, 24)
                        ]
                    ];
                    $sms_center->system_line_alert($arr, $phone);
                }
                return redirect()->back()->with('success', 'ارسال پیامک موفق');
            }
        }


        if ($request->ajax()) {
            $procedure = $request->procedure;
            if ($procedure == 'load_step_table') {
                $step_price = \App\Http\Controllers\setting\SettingManagement::GetSettingValue('step_mode') ?? 0;
                $GoodInWarehouse = null;
                return view('woocommerce.admin.EditGood_Stock_Admin_step_price_table', ['GoodInWarehouse' => $GoodInWarehouse, 'step_price' => $step_price])->render();
            }
            if ($procedure == 'loadwarehouse') {
                $WGID = $request->WGID;
                $WGSRC = warehouse_goods::where('id', $WGID)->first();
                if ($WGSRC == null) {
                    return false;
                }
                $WarehouseID = $WGSRC->WarehouseID;
                $Warehouse = warehouse::where('id', $WarehouseID)->first();
                if ($WGSRC->owner == null) {
                    $WGSRC->ownerusername = 'مالک نا مشخص';
                } else {
                    $OwnerSrc = UserInfo::where('UserName', $WGSRC->owner)->first();
                    if ($OwnerSrc == null) {
                        $WGSRC->ownerusername = 'مالک در جدول موجود نیست ';
                    } else {
                        $WGSRC->ownerusername = $OwnerSrc->Name . ' ' . $OwnerSrc->Family;
                    }
                }
                $WGSRC->warehousename = $Warehouse->Name;
                $WGSRC->attr = $this->LoadProductAttribute($WGID);
                $step_price = \App\Http\Controllers\setting\SettingManagement::GetSettingValue('step_mode') ?? 0;
                $GoodInWarehouse = warehouse_goods::where('id', $WGID)->first();
                $WGSRC->step_table = view('woocommerce.admin.EditGood_Stock_Admin_step_price_table', ['GoodInWarehouse' => $GoodInWarehouse, 'step_price' => $step_price])->render();
                return $WGSRC;
            }
            if ($procedure == 'check_url') {
                $url = $request->new_url;
                $exist_product = goods::where('id', '!=', $id)->where('urladdress', $url)->first();
                if ($exist_product == null) {
                    return true;
                }
                return false;

            }

            if ($procedure == 'save_rent') {
                $Attr = [
                    'RentName' => $request->RentName,
                    'rent_days' => $request->rent_days,
                    'rent_status' => $request->rent_status,
                    'rent_buyprice' => $request->rent_buyprice,
                    'rent_price' => $request->rent_price,
                    'AttBasePrice' => $request->AttBasePrice,
                    'rent_tasshims' => $request->rent_tasshims,
                    'WGID' => $request->WGID,
                ];

                return $this->AddProductAttrebute($Attr);
            }
            if ($procedure == 'saveatt') {
                $Attr = [
                    'AttName' => $request->AttName,
                    'Attval' => $request->Attval,
                    'AttRemain' => $request->AttRemain,
                    'AttBuyPrice' => $request->AttBuyPrice,
                    'AttPrice' => $request->AttPrice,
                    'AttBasePrice' => $request->AttBasePrice,
                    'AttNote' => $request->AttNote,
                    'WGID' => $request->WGID,
                ];

                return $this->AddProductAttrebute($Attr);
            }
        }

        if ($request->has('getownerinfo')) {
            $TargetUser = UserInfo::where('UserName', $request->getownerinfo)->first();
            return $TargetUser->Name . ' ' . $TargetUser->Family;
        }
        if ($request->has('submit_tashim')) {
            $TashimsArr = $request->input('tashim');
            $ProductId = $id;
            $WarehouseID = $request->input('submit_tashim');
            $TargetWGSrc = warehouse_goods::where('GoodID', $ProductId)->get();
            foreach ($TargetWGSrc as $TargetWG) {
                $WGID = $TargetWG->id;
                tashim_items::where('GoodsID', $WGID)->delete();
                foreach ($TashimsArr as $TashimsItem) {
                    $SaveData = [
                        'GoodsID' => $WGID,
                        'TashimID' => $TashimsItem,
                        'Creator' => Auth::id(),
                    ];
                    tashim_items::create($SaveData);
                }
            }

            return redirect()->back()->with('success', 'تسیهیم با موفقیت افزوده شد!');
        }
        if ($request->has('Tax')) {
            goods::where('id', $id)->update(['tax_status' => $request->input('Tax')]);
            if ($request->input('Tax') == 0) {
                return redirect()->back()->with('success', 'مالیات غیر فعال شد');
            } elseif ($request->input('Tax') == 10) {
                return redirect()->back()->with('success', 'مالیا بر روی کالا فعال گردید!');
            }
        }
        if ($request->has('delete')) {
            goods::where('id', $id)->delete();
            warehouse_goods::where('GoodID', $id)->delete();
            goodindex::where('GoodID', $id)->delete();
            return redirect()->route('ProductLsit')->with('success', 'حذف کالا انجام گرفت');
        }
        if (!$request->has('multiple')) {
            $multiple_unit = null;
            $UnitFormola = null;
        } else {
            $multiple_unit = $request->input('multiple');
            $UnitFormola = null;
        }

        if (is_array($multiple_unit)) {
            $UnitFormola = array();
            $UnitName = $request->input('UnitName');
            $img = $request->input('img');
            $counter = 1;
            for ($counter; $counter < 14; $counter++) {
                if ($multiple_unit[$counter] == null || $UnitName[$counter] == null) {
                    break;
                }
                array_push($UnitFormola, ['multiple' => $multiple_unit[$counter], 'UnitName' => $UnitName[$counter], 'img' => $img[$counter]]);
            }
            $UnitFormola = json_encode($UnitFormola);
        }
        if ($request->input('ce1') != null) { // text with description
            if ($request->input('ce') == null) {
                $MainText = '';
            } else {
                $MainText = $request->input('ce');
            }
            $DiscText = $request->input('ce1');
            $MainDescription = [
                'DiscText' => $DiscText,
                'MainText' => $MainText,
            ];
            $MainDescription = json_encode($MainDescription);
        } else {
            $MainDescription = $request->input('ce');
        }
        $ProductData = [
            'NameFa' => $request->input('NameFa'),
            'NameEn' => $request->input('NameEn'),
            'IRID' => $request->input('IRID'),
            'IntID' => $request->input('IntID'),
            'Unit' => $request->input('MainUnit'),
            'SKU' => $request->input('SKU'),
            'Description' => $request->input('Description'),
            'MainDescription' => $MainDescription,
            'weight' => $request->input('weight'),
            'urladdress' => $request->input('urladdress'),
            'UnitPlan' => $UnitFormola,
        ];
        goods::where('id', $id)->update($ProductData);
        if ($request->has('SelectTags')) {
            $my_keywords = new meta_keyword;
            $my_keywords->add_meta_keyword_to_item($request->input('SelectTags'), $id, 2);
        }
        return redirect()->back()->with('success', __("success alert"));
    }
    public function ProductLsit()
    {

        $UserBranch = auth()->user()->branch;
        /**
         * admin access
         */

        if (Auth::user()->Role >= myappenv::role_SuperAdmin) {

            $ShowMod = 'Search';
            $MyIndex = new Indexes();
            $IndexTree = $MyIndex->HTMLTreeIndex();
            $Sellers = warehouse::all();

            $Tashims = tashim::all()->where('ItemOrder', 0);

            return view("woocommerce.admin.GoodLsit", ['ShowMod' => $ShowMod, 'Tashims' => $Tashims, 'IndexTree' => $IndexTree, 'Sellers' => $Sellers]);
        }
        /**
         * shop owner access
         */ else {
            $Query = "SELECT
            g.*,
            wg.QTY,
            w.Name,
            s.branch
          FROM
            goods g
            left join warehouse_goods wg on g.id = wg.GoodID
            LEFT join warehouses w on wg.WarehouseID = w.id
            LEFT JOIN stores as s on w.StoreID = s.id
          WHERE s.branch is null or s.branch = $UserBranch ";
            $goods = DB::select($Query);
            $MyIndex = new Indexes();
            $IndexTree = $MyIndex->HTMLTreeIndex();
            return view("woocommerce.admin.GoodLsitShopOwner", ['IndexTree' => $IndexTree, 'goods' => $goods]);
        }
    }
    public function DoProductLsit(Request $request)
    {
        if ($request->input('submit') == 'updateproductbulk') {
            $good = $request->input('good');


            foreach ($good as $productId => $ProductTarget) {

                foreach ($ProductTarget as $wgtId => $ProductTargeItem) {

                    $NameFa = $ProductTargeItem['NameFa'];

                    $OldNameFa = $ProductTargeItem['oldNameFa'];
                    $OldPrice = $ProductTargeItem['oldPrice'];
                    $OldBuyPrice = $ProductTargeItem['oldBuyPrice'];
                    if (isset($ProductTargeItem['Price']) || isset($ProductTargeItem['BuyPrice'])) {
                        $Price = str_replace(',', '', $ProductTargeItem['Price']);
                        $BuyPrice = str_replace(',', '', $ProductTargeItem['BuyPrice']);
                    }

                    if ($BuyPrice > $Price) {
                        return redirect()->back()->with('error', __("مبلغ فروش نمیتواند از مبلغ خرید کمتر باشد!"));
                    }
                    if ($Price == null) {
                        return false;
                    }
                    if ($NameFa != $OldNameFa) {

                        goods::where('id', $productId)->update(['NameFa' => $NameFa]);
                    }
                    if ($Price != $OldPrice) {

                        warehouse_goods::where('GoodID', $productId)->where('WarehouseID', $wgtId)->update(['Price' => $Price]);
                    }
                    if ($BuyPrice != $OldBuyPrice) {

                        warehouse_goods::where('GoodID', $productId)->where('WarehouseID', $wgtId)->update(['BuyPrice' => $BuyPrice]);
                    }
                }
            }

            return redirect()->back()->with('success', __("success alert"));
        }
        if ($request->input('submit') == 'indexes') {
            $check_list = $request->input('check_list');
            $Condition = ' where 1 = 1 and (';
            $FirstStep = true;
            foreach ($check_list as $check_listItem) {
                if ($FirstStep) {
                    $Condition .= "  gi.IndexID = $check_listItem ";
                    $FirstStep = false;
                } else {
                    $Condition .= " or gi.IndexID = $check_listItem ";
                }
            }
            $Condition .= ' )';
            $Query = "SELECT g.id,g.SKU,
            g.NameFa,
            g.NameEn,
            g.IRID,
            g.IntID,
            g.Virtual,
            g.downloadable,
            g.onsale,
            g.Status,
            g.Description,
            g.MinPrice,
            g.MaxPrice,
            g.Unit,
            g.MainDescription,
            g.ImgURL,
            g.stock_quantity,
            g.stock_status,
            g.rating_count,
            g.average_rating,
            g.total_sales,
            g.tax_status,
            g.onrent,
            g.created_at,
            g.weight , wg.Remian as QTY, w.Name ,w.phone as phone , wg.PricePlan, wg.BuyPrice,wg.Price, w.StoreID as wid FROM goods g inner join goodindices as gi on gi.GoodID = g.id  left join warehouse_goods wg on g.id = wg.GoodID LEFT join warehouses w on wg.WarehouseID  = w.id LEFT join tashim_items t on wg.id  = t.GoodsID $Condition
            GROUP BY g.id,g.SKU,g.onrent,wg.BuyPrice,wg.Price,g.created_at,
            g.NameFa,
            g.NameEn,
            g.IRID,
            g.IntID,
            g.Virtual,
            g.downloadable,
            g.onsale,
            g.Status,
            g.Description,
            g.MinPrice,
            g.MaxPrice,
            g.Unit,
            g.MainDescription,
            g.ImgURL,
            g.stock_quantity,
            g.stock_status,
            g.rating_count,
            g.average_rating,
            g.total_sales,
            g.tax_status,
            w.Name,
            g.weight ,wg.Remian,w.phone,w.StoreID ORDER BY  g.id DESC  ";
            $goods = DB::select($Query);
            $MyIndex = new Indexes();
            $IndexTree = $MyIndex->HTMLTreeIndex();
            return view("woocommerce.admin.GoodLsit", ['ShowMod' => 'List', 'IndexTree' => $IndexTree, 'goods' => $goods]);
        }
        if ($request->input('submit') == 'Search') {
            $Condition = ' where 1 = 1 ';
            if ($request->input('ProductName') != null) {
                $ProductName

                    = $request->input('ProductName');
                $Condition .= " and  g.NameFa like '%$ProductName%' ";
            }
            if ($request->input('ProductID') != null) {
                $ProductID = $request->input('ProductID');
                $Condition .= " and  g.id = $ProductID ";
            }
            if ($request->input('ProductState') != null) {
                if ($request->input('ProductState') == 1) { // remain product
                    $Condition .= " and  wg.Remian > 0 ";
                }
                if ($request->input('ProductState') == 2) { // not remain product
                    $Condition .= " and  wg.Remian = 0 ";
                }
                if ($request->input('ProductState') == 3) { // deactive product
                    $Condition .= " and  g.onsale = 0 ";
                }
                if ($request->input('ProductState') == 4) { // has not provider product
                    $Condition .= " and  wg.Remian is null ";
                }
                if ($request->input('ProductState') == 5) { // has not tashim product
                    $Condition .= " and  t.id is null ";
                }
                if ($request->input('ProductState') == 6) { //  shop owner product
                    $Condition .= " and   wg.onsale = 10 ";
                }
            }
            if ($request->input('Productwarehouse') != null) {
                $Productwarehouse = $request->input('Productwarehouse');
                $Condition .= " and  wg.WarehouseID = $Productwarehouse ";
            }
            if ($request->input('ToPrice') != null) {
                $ToPrice = $request->input('ToPrice');
                $Condition .= " and  wg.Price <= $ToPrice ";
            }
            if ($request->input('FromPrice') != null) {
                $FromPrice = $request->input('FromPrice');
                $Condition .= " and  wg.Price >= $FromPrice ";
            }
            if ($request->input('ToRemain') != null) {
                $ToRemain = $request->input('ToRemain');
                $Condition .= " and  wg.Remian <= $ToRemain ";
            }
            if ($request->input('FromRemain') != null) {
                $FromRemain = $request->input('FromRemain');
                $Condition .= " and  wg.Remian >= $FromRemain ";
            }
            if ($request->input('Tashim') != null) {
                $Tashim = $request->input('Tashim');
                $Condition .= " and  t.TashimID = $Tashim ";
            }
            $MyDate = new persian();
            if ($request->input('StartDate') != null) {
                $StartDate = $MyDate->MiladiDate($request->input('StartDate'));
                $Condition .= " and  g.created_at >= '$StartDate'";
            }

            if ($request->input('EndDate') != null) {
                $EndDate = $MyDate->MiladiDate($request->input('EndDate'));
                $Condition .= " and  g.created_at <= '$EndDate'";
            }

            $Query = "SELECT g.NameFa ,
            g.id ,
            g.onrent,
            g.tax_status,
            g.created_at,
            wg.PricePlan,
            wg.Remian as QTY,
            wg.Price as Price,
            wg.BuyPrice as BuyPrice ,
            w.Name ,w.phone as phone ,
            w.StoreID as wid
            FROM goods g left join warehouse_goods wg on g.id = wg.GoodID LEFT join warehouses w on wg.WarehouseID  = w.id LEFT join tashim_items t on wg.id  = t.GoodsID $Condition
            GROUP BY g.NameFa ,
            g.id ,
            g.onrent,
            g.tax_status ,
            g.created_at ,
            wg.Remian,
            wg.Price ,
            wg.BuyPrice  ,
            wg.PricePlan,
            w.Name ,w.phone ,
             wg.id ,
            w.StoreID
            order by  wg.id DESC";
            $goods = DB::select($Query);
            $MyIndex = new Indexes();
            $IndexTree = $MyIndex->HTMLTreeIndex();
            return view("woocommerce.admin.GoodLsit", ['ShowMod' => 'List', 'IndexTree' => $IndexTree, 'goods' => $goods]);
        } elseif ($request->input('submit') == 'doble') {
            $pm = new ProductManagement;
            $id = $request->input('ProductId');
            $result = $pm->make_double($id);
            if (!$result['result']) {
                return redirect()->back()->with('error', $result['msg']);
            }
            return redirect()->route('EditProduct', ['id' => $result['product_id']]);
        }
        if ($request->input('submit') == 'delete') {
            $id = $request->input('ProductId');
            goods::where('id', $id)->delete();
            warehouse_goods::where('GoodID', $id)->delete();
            goodindex::where('GoodID', $id)->delete();
            return redirect()->route('ProductLsit')->with('success', 'حذف کالا انجام گرفت');
        }
        if ($request->input('submit') == 'multiindex') {
            $IndexArr = $request->input('check_list');
            $ProductsArr = $request->input('products');
            foreach ($ProductsArr as $ProductTarget) {
                foreach ($IndexArr as $IndexItem) {
                    $TargrtIndex = goodindex::where('GoodID', $ProductTarget)->where('IndexID', $IndexItem)->first();
                    if ($TargrtIndex == null) {
                        $SaveData = [
                            'GoodID' => $ProductTarget,
                            'IndexID' => $IndexItem,
                            'CreateDate' => now(),
                            'Creator' => Auth::id(),
                        ];
                        goodindex::create($SaveData);
                    }
                }
            }
            return redirect()->back()->with('success', 'شاخص - شاخص های مورد نظر به کالا - کالاها اضافه گردید');
        } elseif ($request->input('submit') == 'DeleteIndexes') {
            $IndexArr = $request->input('check_list');
            $ProductsArr = $request->input('products');
            foreach ($ProductsArr as $ProductTarget) {
                foreach ($IndexArr as $IndexItem) {
                    goodindex::where('GoodID', $ProductTarget)->where('IndexID', $IndexItem)->delete();
                }
            }
            return redirect()->back()->with('success', 'شاخص - شاخص های مورد نظر از کالا - کالاها حذف گردید');
        }
    }
    public function ProductGalery($id, $iframe = false)
    {

        $good = goods::where('id', $id)->first();
        $ImageArray = json_decode($good->ImgURL);
        $picrefrence = picrefrence::all()->where('type', 1);
        if (Auth::user()->Role >= myappenv::role_ShopAdmin) {
            return view('woocommerce.admin.GoodGalery', ['iframe' => $iframe, 'good' => $good, 'picrefrence' => $picrefrence, 'ImageArray' => $ImageArray]);
        }
        if (Auth::user()->Role == myappenv::role_ShopOwner) {
            return view('woocommerce.admin.GoodGaleryShopOwner', ['iframe' => $iframe, 'good' => $good, 'picrefrence' => $picrefrence, 'ImageArray' => $ImageArray]);
        } else {
            return abort('404', 'دسترسی غیر مجاز!');
        }
    }
    public function DoProductGalery($id, Request $request, $iframe = false)
    {

        if (Auth::user()->Role > myappenv::role_ShopAdmin) {
            $picrefrence = picrefrence::all()->where('type', 1);
            $myimage = new Images();
            $MainJson = '';
            $mainArr = array();
            foreach ($picrefrence as $picrefrenceItem) {
                $NewArray = ['RefrenceID' => $picrefrenceItem->id, 'PicUrl' => $request->input('pic_' . $picrefrenceItem->id)];
                array_push($mainArr, $NewArray);
                $Mianjson = json_encode($mainArr);
            }
            goods::where('id', $id)->update(['ImgURL' => $Mianjson]);
            if ($iframe == true) {
                return redirect()->back()->with('success', __("success alert"));
            } else {
                return redirect()->route('EditProduct', ['id' => $id])->with('success', __("success alert"));
            }
        }
        if (Gate::allows('shopowner_')) {
            if ($request->input('submit') == 'UpdateIMG') {
                if ($request->file('avatar_' . 1) == null) {
                    return back()->with('error', __('لطفا یک عکس برای محصول خود بارگذاری کنید'));
                }
                $picrefrence = picrefrence::all()->where('type', 1);
                $myimage = new Images();
                $MainJson = '';
                $mainArr = array(); {
                    foreach ($picrefrence as $picrefrenceItem) {
                        $Mytext = new TextClassMain();
                        if ($request->file('avatar_' . $picrefrenceItem->id) != null) {
                            $imageName = 'ShowpOwnerPic' . $Mytext->StrRandom() . '.' . $request->file('avatar_' . $picrefrenceItem->id)->getClientOriginalExtension();
                            $request->file('avatar_' . $picrefrenceItem->id)->move(public_path('/storage/ShopownerPic'), $imageName);
                            $imageName = url('/') . '/storage/ShopownerPic/' . $imageName;
                            $NewArray = ['RefrenceID' => $picrefrenceItem->id, 'PicUrl' => $imageName];
                            array_push($mainArr, $NewArray);
                            $Mianjson = json_encode($mainArr);
                        }
                    }
                }

                goods::where('id', $id)->update(['ImgURL' => $Mianjson]);

                //  return back()->with('success', __('You have successfully upload image.'));
                return redirect()->route('EditProduct', ['id' => $id])->with('success', __("success alert"));
            }
        } else {
            return abort('404', 'دسترسی غیر مجاز!');
        }
    }
    public function AddProduct(Request $request)
    {

        if (Auth::user()->Role < myappenv::role_ShopOwner) {
            return abort('404', 'این امکان برای شما وجود ندارد!');
        }
        if ($request->has('ProductType')) {
            $ProductType = $request->input('ProductType');
        } else {
            $ProductType = 'goods';
        }
        if ($ProductType == 'goods') {
            $showindex = 'SelectBox';
            $IndexList = L3Work::all();
            $picrefrence = picrefrence::all();
            $GoodStatusResult = [];
            $GoodIndexes = L3Work::all();
            $ProductUnits = ProductUnitMeta::all()->where('MainUnit', null);
            $WorkCat = myappenv::PostIndexWorkCat;
            $L1ID = myappenv::NewsIndexL1;
            $L2ID = myappenv::NewsIndexL2;
            $Tags = L3Work::all()->where('WorkCat', $WorkCat)->where('L1ID', $L1ID)->where('L2ID', $L2ID);
            return view("woocommerce.admin.AddGood", ['ProductUnits' => $ProductUnits, 'Tags' => $Tags, 'showindex' => $showindex, 'IndexList' => $IndexList, 'picrefrence' => $picrefrence, 'GoodStatusResult' => $GoodStatusResult, 'GoodIndexes' => $GoodIndexes]);
        } elseif ($ProductType == 'SpecialAccount') {
            $showindex = 'SelectBox';
            $IndexList = L3Work::all();
            $picrefrence = picrefrence::all();
            $GoodStatusResult = [];
            $GoodIndexes = L3Work::all();
            $ProductUnits = ProductUnitMeta::all()->where('MainUnit', null);
            return view("woocommerce.admin.AddSpecialAccount", ['ProductUnits' => $ProductUnits, 'showindex' => $showindex, 'IndexList' => $IndexList, 'picrefrence' => $picrefrence, 'GoodStatusResult' => $GoodStatusResult, 'GoodIndexes' => $GoodIndexes]);
        } else {
            return abort('404', 'نوع کالای مورد نظر موجود نمی باشد');
        }
    }
    public function DoAddProduct(Request $request)
    {
        if ($request->ajax()) {
            $procedure = $request->procedure;
            if ($procedure == 'check_url') {
                $url = $request->new_url;
                $exist_product = goods::where('urladdress', $url)->first();
                if ($exist_product == null) {
                    return true;
                }
                return false;

            }
        }

        if ($request->has('ProductType')) {
            $ProductType = $request->input('ProductType');
        } else {
            $ProductType = 'goods';
        }
        if ($ProductType == 'goods') {
            $Virtual = 0;
            $downloadable = 0;
        } elseif ($ProductType == 'SpecialAccount') {
            $Virtual = 2;
            $downloadable = 0;
        }

        $NameFa = $request->input('NameFa');
        $NameEn = $request->input('NameEn');
        $IRID = $request->input('IRID');
        $IntID = $request->input('IntID');
        $Status = 0;
        $Description = $request->input('Description');
        $ImgURL = '';
        if ($request->input('ce1') != null) { // text with description
            if ($request->input('ce') == null) {
                $MainText = '';
            } else {
                $MainText = $request->input('ce');
            }
            $DiscText = $request->input('ce1');
            $MainDescription = [
                'DiscText' => $DiscText,
                'MainText' => $MainText,
            ];
            $MainDescription = json_encode($MainDescription);
        } else {
            if ($request->input('ce') == null) {
                $MainDescription = '';
            } else {
                $MainDescription = $request->input('ce');
            }
        }
        $ProductData = [
            'NameFa' => $NameFa,
            'NameEn' => $NameEn,
            'IRID' => $IRID,
            'IntID' => $IntID,
            'Unit' => $request->input('MainUnit'),
            'SKU' => $request->input('SKU'),
            'Status' => $Status,
            'Description' => $Description,
            'MainDescription' => $MainDescription,
            'weight' => $request->input('weight'),
            'ImgURL' => $ImgURL,
            'urladdress' => $request->input('urladdress'),
            'Virtual' => $Virtual,
            'downloadable' => $downloadable,
        ];
        $GoodResult = goods::create($ProductData);
        if ($request->has('SelectTags')) {
            $my_keywords = new meta_keyword;
            $my_keywords->add_meta_keyword_to_item($request->input('SelectTags'), $GoodResult->id, 2);
        }

        return redirect()->route('ProductGalery', ['id' => $GoodResult->id]);
    }
    public function SingleProduct($productIDInput, $productName = null)
    {
        if (myappenv::PreProductTag != '') {
            if (strpos($productIDInput, myappenv::PreProductTag) === false) {

                $productID = $productIDInput;
                if (is_numeric($productID)) {
                    $productIDInput = myappenv::PreProductTag . $productIDInput;
                    return redirect()->route('SingleProduct', ['productID' => $productIDInput, 'productName' => '']);
                    $shouldChange = true;
                }
            } else {
                $productID = substr($productIDInput, strlen(myappenv::PreProductTag));
                $shouldChange = false;
            }
        } else {
            $productID = $productIDInput;
            $shouldChange = false;
        }
        if (is_numeric($productID)) {
            $TargetGood = goods::where('id', $productID)->first();
            //if($TargetGood->urladdress != null && $TargetGood->urladdress != ''){
            //  return redirect()->route('SingleProduct', ['productID' =>$TargetGood->urladdress, 'productName' =>'']);
            // }
        } else {
            $TargetGood = goods::where('urladdress', $productID)->first();
	    if ($TargetGood == null) {
		 return redirect()->route('home');
                return abort('404', 'آدرس وارد شده معتبر نمی باشد!');
            }
            $productID = $TargetGood->id;
            $shouldChange = 'never';
        }
        if (myappenv::version == myappenv::version_stable) {
            $Productsrc = $this->GetProducts(null, $productID, false); // product in shop warehouse

        } else {
            $Productsrc = $this->GetProductsV1(null, $productID, false); // product in shop warehouse

        }

        $ProductTarget = null;

        if (count($Productsrc) > 1) {

            foreach ($Productsrc as $Productdata) {


                if ($Productdata->Remian > 0) {
                    $ProductTarget = $Productdata;
                }
            }
        } else {

            foreach ($Productsrc as $Productdata) {

                $ProductTarget = $Productdata;
            }
        }


	if ($ProductTarget == null) {
		return redirect()->route('home');
            return abort(404, 'محصول مورد نظر در سامانه وجود ندارد');
        }
        if ($ProductTarget->PricePlan != null) {
            $PricePlan = json_decode($ProductTarget->PricePlan);
        } else {
            $PricePlan = null;
        }
        if ($ProductTarget->UnitPlan != null) {
            $UnitPlan = json_decode($ProductTarget->UnitPlan);
        } else {
            $UnitPlan = null;
        }
	if ($TargetGood == null) {
		return redirect()->route('home');
            return abort('404', 'آدرس معتبر نمی باشد!');
        }
        $SiteElements = new main();
        if ($shouldChange != 'never') {
            if ($TargetGood->NameFa != $productName || $shouldChange) {
                return redirect()->route('SingleProduct', ['productID' => $productIDInput, 'productName' => $TargetGood->NameFa]);
            }
        }
        $Setting = null;
        $Setting = CacheData::GetSetting('show_table_of_index');
        if ($Setting == null || $Setting == '1') {
            $showTable = true;
        } else {
            $showTable = false;
        }
        $Product = new ProductClass();
        if (Auth::check()) {
            $UserLogin = 'user';
            if (Auth::user()->Role > myappenv::role_customer) {
                $UserLogin = 'admin';
            }
        } else {
            $UserLogin = null;
        }

        //L3Work::where('WorkCat',$this->brand_WC)->where('L1ID',$this->brand_L1)->where('L2ID',$this->brand_L2)->where('Name',$TagName)->first()
        $Query = "SELECT L3.UID,L3.img as L3img, L3.Name as L3Name from L3Work as L3 INNER JOIN goodindices as Gi on L3.UID = Gi.IndexID WHERE Gi.GoodID = $productID and L3.WorkCat = $this->brand_WC
         and L3.L1ID = $this->brand_L1 and L3.L2ID = $this->brand_L2 ";
        $Tags = DB::select($Query);
        $DashboardClass = new DashboardClass();
        $PostComments = post_views::all()->where('Post', $productID)->where('Status', 100);
        $WGID = $ProductTarget->wgid;
        $Query = "select * from tashim_items  as ti inner join tashims t on ti.TashimID = t.id where ti.GoodsID = $WGID";
        $Tashims = DB::select($Query);

        if ($UserLogin == null || $UserLogin == 'user') {
            $AlreadyView = false;
            $ViewArr = Session::get('MyView');
            if ($ViewArr == null) {
                $ViewArr = array();
            }
            foreach ($ViewArr as $ViewItem) {
                $ViewType = $ViewItem[0];
                $ViewVal = $ViewItem[1];

                if ($ViewType == 'singleproduct' && $ViewVal == $productID) {
                    $AlreadyView = true;
                    break;
                }
            }
            if (!$AlreadyView) {
                $ViewCount = $ProductTarget->view + 1;
                $UpdateData = [
                    'view' => $ViewCount,
                ];
                warehouse_goods::where('id', $ProductTarget->wgid)->update($UpdateData);
                if (Auth::check()) {
                    $UserID = Auth::id();
                } else {
                    $UserID = 'unknownuser';
                }
                $SaveData = [
                    'ProductID' => $productID,
                    'UserID' => $UserID,
                    'ReportType' => 1, //view counter
                    'ReportVal' => $ViewCount,

                ];
                report_detial::create($SaveData);
                $ViewItem = ['singleproduct', $productID];
                array_push($ViewArr, $ViewItem);
                Session::put('MyView', $ViewArr);
            }
        }
        if (myappenv::SiteTheme == 'shafatel' || myappenv::MainOwner == 'Carpetour') {
            return view('woocommerce.Customer.SingleProductShafatel', ['Tashims' => $Tashims, 'PostComments' => $PostComments, 'DashboardClass' => $DashboardClass, 'Tags' => $Tags, 'UnitPlan' => $UnitPlan, 'showTable' => $showTable, 'PricePlan' => $PricePlan, 'SiteElements' => $SiteElements, 'Product' => $Product, 'page' => 'ProductList', 'TargetGood' => $TargetGood, 'ProductTarget' => $ProductTarget]);
        } elseif (myappenv::SiteTheme == 'kookbaz') {
            return view('woocommerce.Customer.SingleProductKookbaz', ['Tashims' => $Tashims, 'PostComments' => $PostComments, 'DashboardClass' => $DashboardClass, 'Tags' => $Tags, 'UnitPlan' => $UnitPlan, 'showTable' => $showTable, 'PricePlan' => $PricePlan, 'SiteElements' => $SiteElements, 'Product' => $Product, 'page' => 'ProductList', 'TargetGood' => $TargetGood, 'ProductTarget' => $ProductTarget]);
        } else {
            $theme = myappenv::ShopTheme;
            $management = $this->is_management_login();
            $MyProduct = new product;
            $mark = new ProductMark;
            return view("Layouts.$theme.SingleProduct", ['mark' => $mark, 'MyProduct' => $MyProduct, 'management' => $management, 'Product' => $this, 'Tashims' => $Tashims, 'PostComments' => $PostComments, 'DashboardClass' => $DashboardClass, 'Tags' => $Tags, 'UnitPlan' => $UnitPlan, 'showTable' => $showTable, 'PricePlan' => $PricePlan, 'SiteElements' => $SiteElements, 'Product' => $Product, 'page' => 'ProductList', 'TargetGood' => $TargetGood, 'ProductTarget' => $ProductTarget]);
        }
    }
    public function get_product_map($product_id)
    {
        $MainMenu = CacheData::GetSetting('MainMenu');
        $MainMenu = json_decode($MainMenu);
        $WorkCat = $MainMenu->WorkCat;
        $L1ID = $MainMenu->L1ID;
        $Query = "SELECT lw.Name , lw.UID from goodindices g inner join goods g2  on g.GoodID = g2.id INNER join L3Work lw on lw.UID = g.IndexID
where g2.id = $product_id and lw.WorkCat = $WorkCat and lw.L1ID = $L1ID  ";
        return DB::select($Query);
    }

    public function GetDefultTashim()
    {
        return 0;
    }
    private function GetProductAds($TargetPage, $Position)
    {

        if (Auth::check()) {

            if (Auth::check()) {

                $User = Auth::id();
            } else {
                $User = null;
            }
            $Ad = new adsClass();

            $TargetProperty = [
                'TargetPage' => $TargetPage,
                'TargetUser' => $User,
                'Limit' => 2,
            ];
            return $Ad->get_ads($TargetProperty);
        }
    }

    /**
     * GetProductIndex function
     *
     * @param  $ProductId
     * @return Add Record into Table workerSkill
     * how many Times users see this product and what is the index of product
     */
    private function GetProductIndex($ProductId, $Buy = null)
    {
        $Weight = myappenv::Weight;
        if (Auth::check()) {
            $User = Auth::id();
            $ProductIndex = goodindex::where('GoodID', $ProductId)->get();
            foreach ($ProductIndex as $ProductIndexDetail) {
                $WorkerSkill = WorkerSkils::where('SkilID', $ProductIndexDetail->IndexID)->first();
                if ($WorkerSkill == null) {
                    $UID = $ProductIndexDetail->IndexID;
                    $TL3WorkSrc = L3Work::where('UID', $UID)->first();
                    $TWorkCat = $TL3WorkSrc->WorkCat;
                    $TL1ID = $TL3WorkSrc->L1ID;
                    $TL2ID = $TL3WorkSrc->L2ID;
                    if ($Buy = 1) {
                        $SingleData = [
                            'UserName' => $User,
                            'SkilID' => $UID,
                            'WorkCat' => $TWorkCat,
                            'L1ID' => $TL1ID,
                            'L2ID' => $TL2ID,
                            'CreateDate' => now(),
                            'Status' => 20,
                            'Note' => "",
                            'Weight' => 1000,
                        ];
                    } else {
                        $SingleData = [
                            'UserName' => $User,
                            'SkilID' => $UID,
                            'WorkCat' => $TWorkCat,
                            'L1ID' => $TL1ID,
                            'L2ID' => $TL2ID,
                            'CreateDate' => now(),
                            'Status' => 20,
                            'Note' => "",
                            'Weight' => $Weight['viwe'],
                        ];
                    }

                    WorkerSkils::create($SingleData);
                } else {

                    $Weight = $WorkerSkill->Weight;
                    if ($Buy = 1) {
                        $Weight += 1000;
                    } else {
                        $Weight += 1;
                    }

                    WorkerSkils::where('SkilID', $ProductIndexDetail->IndexID)->where('UserName', $WorkerSkill->UserName)->update(['Weight' => $Weight]);
                }
            }
        } else {

            return false;
        }
    }
    public function DoSingleProduct(Request $request, $productID, $productName = null)
    {
        if ($request->has('ajax')) {
            if ($request->input('procedure') == 'load_modal') {
                $good_src = goods::where('id', $request->good_id)->first();
                $warehouse_good = warehouse_goods::where('GoodID', $request->good_id)->where('Remian', '>', 0)->where('OnSale', 1)->first();
                $MyProduct = $this;
                return view('Layouts.Theme5.layout.fast_buy_modal', ['warehouse_good' => $warehouse_good, 'MyProduct' => $MyProduct, 'good_src' => $good_src])->render();
            }

            if ($request->input('procedure') == 'tblview') {
                $ads = $this->GetProductAds('test', 'sideads');

                return view('Layouts.Theme1.objects.adsSingleproduct', ['ads' => $ads])->render();
            }
            if ($request->input('procedure') == 'userindex') {
                $ProductId = $request->input('ProductId');

                $this->GetProductIndex($ProductId);
            }
            if ($request->input('procedure') == 'settashim') {
                $Order = new Orders();
                $ProductID = $request->input('ProductId');
                $PWID = $request->input('PWID');
                $Tashim = $request->input('Tashim');
                $Order->put_tashim($ProductID, $PWID, $Tashim);
                return 'true';
            }
            if ($request->input('procedure') == 'AddToBasket') {
                $ProductId = $request->input('ProductId');
                $pw_id = $request->input('pw_id');
                $OrderQty = $request->input('OrderQty');
                $MyBuy = new buy();
                if ($MyBuy->IsValidProduct($pw_id)) {
                    $SteperResult = $MyBuy->AddToBasketStepper($ProductId, $OrderQty, $pw_id);
                    $Order = new Orders();
                    if ($request->has('Tashim')) {
                        $Tashim = $request->input('Tashim');
                        if ($Tashim == 0) {
                            $Order->put_tashim($ProductId, $pw_id, CacheData::GetSetting('DefultTashim'));
                        } else {
                            $Order->put_tashim($ProductId, $pw_id, $Tashim);
                        }
                    } else {
                        if (myappenv::tashim == 'main') { // if branch use customize tashim
                            $Tashim = CacheData::GetSetting('DefultTashim');
                            $Order->put_tashim($ProductId, $pw_id, $Tashim);
                        }
                    }
                    return $SteperResult;
                } else {
                    return 'typemismatch';
                }
            }
        }
        if (myappenv::PreProductTag != '') {
            $productID = substr($productID, strlen(myappenv::PreProductTag));
        }
        if (is_numeric($productID)) {
        } else {
            $TargetGood = goods::where('urladdress', $productID)->first();
	    if ($TargetGood == null) {
		     return redirect()->route('home');
                return abort('404', 'آدرس وارد شده معتبر نمی باشد!');
            }
            $productID = $TargetGood->id;
        }

        if ($request->input('submit') == 'AddComment') {

            $ViewsData = [
                'UserName' => Auth::id(),
                'MobileNumber' => Auth::user()->MobileNo,
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'message' => $request->input('comment'),
                'Post' => $productID,
                'Status' => 2,
            ];
            $result = post_views::create($ViewsData);
            post_views::where('id', $result->id)->update(['refrence' => $result->id]);
            return redirect()->back()->with('success', 'دیدگاه شما ثبت شد ، پس از بررسی منتشر خواهد شد!');
        }
    }
}

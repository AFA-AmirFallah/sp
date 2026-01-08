<?php


namespace App\Functions;

use App\Models\transactionstemp;
use App\Models\UserCredit;
use App\myappenv;

class IPGPaymentClass
{
    private $refnumber;
    private function get_temp_transaction_amount($ref)
    {
        $Payresutl = transactionstemp::where('refnumber', $ref)->first();
        if ($Payresutl == null) {
            return null;
        } else {
            $this->refnumber = $Payresutl->refnumber;
            return $Payresutl->Amount;
        }
    }
    public function ConfirmPay_sep()
    {
        $Payresutl = transactionstemp::where('id', $ref)->first();
        if ($Payresutl == null) {
            return abort('404', 'اطلاعات تراکنش نا معتبر است!');
        }
        $price = Session::get('price');
        $ResNum = Session::get('ResNum');
        if ($price == $Payresutl->Amount) {
            $MyTransfer = new TransferProduct($ResNum);
            $resutl = $MyTransfer->UserPay($this->refnumber, $this->refnumber, $pay);
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
                $SellerText = 'سلام مدیر سفارش ' . $ResNum . 'با مبلغ ' . number_format($price)  . ' در سامانه ثبت شد!';

                if (myappenv::MainOwner == 'shafatel' || myappenv::MainOwner == 'Carpetour') {
                    $MySMS->OndemandSMS($SellerText, '09126543802', 'tnks', '09126543802');
                } else {
                    // $MySMS->OndemandSMS($SellerText, '09123345580', 'tnks', '09123345580');
                }
                //$this->AddLog($ResNum);
                $MySMS->OndemandSMS($SellerText, '09123936105', 'tnks', '09123936105');
                if (myappenv::MainOwner == 'kookbaz') {
                    $MySMS->OndemandSMS($SellerText, '09125833245', 'tnks', '09125833245');
                    $MySMS->OndemandSMS($SellerText, '09192228284', 'tnks', '09192228284');
                    $MySMS->OndemandSMS($SellerText, '09101812802', 'tnks', '09101812802');

                }
                if (myappenv::MainOwner == 'Iranekala') {
                    $MySMS->OndemandSMS($SellerText, '09192615961', 'tnks', '09192615961');


                }
                return view("Credit.ConfirmPay", ['Result' => $RResult, 'UserInfo' => $UserInfo]);
            } else {
                return abort('404', 'در انجام تراکنش مشکلی پیش آمده لطفا با فروشگاه تماس بگیرید 14693  ');
            }
        } else {

            return abort('404', 'مشکل امنیتی کد : ۱۴۸۷ ');
        }
    }
    private function add_ipg_credit($UserName, $Mony, $note, $ref, $branch, $Gw)
    {
        $TransactionData = [
            'UserName' => $UserName,
            'Mony' => $Mony,
            'Type' => 66,
            'Date' => now(),
            'Note' => $note,
            'TransferBy' => $UserName,
            'CreditMod' => myappenv::CachCredit,
            'ConfirmBy' => 'system',
            'InvoiceNo' => '',
            'PaymentId' => $ref,
            'SpecialPaymentId' => $ref,
            'GateWay' => $Gw,
            'Confirmdate' => now(),
            'branch' => $branch
        ];
        return UserCredit::create($TransactionData);
    }
    private function finalize_pay($ref)
    {
        Session::put('price', null);
        Session::put('ResNum', null);
        Session::put('note', null);
        Session::put('basket', null);
        transactionstemp::where('refnumber', $ref)->delete();
    }
    public function ConfirmPay_ikc($ref)
    {
        $NormalBuy = true;
        $price = Session::get('price');
        $ResNum = Session::get('ResNum');
        if ($price == $this->get_temp_transaction_amount($ref)) {
            if ($ResNum == 0) { //direct pay charge account
                $note = Session::get('note');
                $this->add_ipg_credit(Auth::id(), $price, $note, $ref, Auth::user()->branch, 'IKC');
                $this->finalize_pay($ref);
                return true;
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
                $resutl = $MyTransfer->UserPay($this->refnumber, $this->refnumber, 'IKC');
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
                    $SellerText = 'سلام مدیر سفارش ' . $ResNum . 'با مبلغ ' . number_format($price)  . ' در سامانه ثبت شد!';
                    if (myappenv::MainOwner == 'shafatel' || myappenv::MainOwner == 'Carpetour') {
                        $MySMS->OndemandSMS($SellerText, '09126543802', 'tnks', '09126543802');
                    } else {
                        //$MySMS->OndemandSMS($SellerText, '09123345580', 'tnks', '09123345580');
                    }
                    //$this->AddLog($ResNum);
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
    }
    public function ConfirmPay_pep()
    {
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
            'MerchantCode' => $MerchantCode,            //shomare ye moshtari e shoma.
            'TerminalCode' => $TerminalCode,            //shomare ye terminal e shoma.
            'InvoiceNumber' => $invoiceNumber,            //shomare ye factor tarakonesh.
            'InvoiceDate' => $InvoiceDate, //tarikh e tarakonesh.
            'amount' => $amount,                    //mablagh e tarakonesh. faghat adad.
            'TimeStamp' => date("Y/m/d H:i:s"),    //zamane jari ye system.
            'sign' => ''                            //reshte ye ersali ye code shode. in mored automatic por mishavad.
        );
        $data = "#$MerchantCode#$TerminalCode#$invoiceNumber#$InvoiceDate#$amount#$TimeStamp#";
        $data = sha1($data, true);
        $Certificate = myappenv::PEPPrivate;
        $processor =  new RSAProcessor($Certificate, RSAKeyType::XMLString);
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
                    $SellerText = 'سلام مدیر سفارش ' . $ResNum . 'با مبلغ ' . number_format($price)  . ' در سامانه ثبت شد!';
                    if (myappenv::MainOwner == 'shafatel' || myappenv::MainOwner == 'Carpetour') {
                        $MySMS->OndemandSMS($SellerText, '09126543802', 'tnks', '09126543802');
                    } else {
                        //  $MySMS->OndemandSMS($SellerText, '09123345580', 'tnks', '09123345580');
                    }
                    //$this->AddLog($ResNum);
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
    public function ConfirmPay($pay)
    {
        if ($pay == 'sep' || $pay == 'pep' || $pay == 'IKC') {

            if ($pay == 'sep') {
                $this->ConfirmPay_sep();
            } elseif ($pay == 'IKC') {
                $this->ConfirmPay_ikc('ref');
            } elseif ($pay == 'pep') {
                $this->ConfirmPay_pep();
            }
        }
    }
}

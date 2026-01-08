<?php

namespace App\Http\Controllers\Point;

use App\APIS\SmsCenter;
use App\Functions\persian;
use App\Http\Controllers\Controller;
use App\Http\Controllers\woocommerce\product;
use App\Models\product_order;
use App\Models\UserInfo;
use App\Models\UserPoint;
use App\myappenv;
use Auth;

class Points extends Controller
{
    public function ReservePoint($PointAttr, $status = null)
    {

        $OrderID = $PointAttr['OrderID'];
        $UserName = $PointAttr['UserName'];
        $MobileNumber = $PointAttr['MobileNumber'];
        $PointData = [
            'UserName' => $UserName,
            'Point' => 0,
            'CreateDate' => now(),
            'Work' => 0,
            'order' => $OrderID,
            'CreatedUser' => Auth::id(),
            'ConfirmUser' => Auth::id(),
            'ConfirmDate' => now(),
            'Note' => '',
            'status' => 3, // for product buy
        ];
        UserPoint::create($PointData);

        if ($status == null) {

            $CustomerText = 'مشتری عزیز'."\n";
            $CustomerText .= 'با شرکت در نظرسنجی زیر ما در بهبود خدمات یاری کنید .' . "\n";
            $CustomerText .= 'لطفا میزان رضایت خود را از محصول و خدمات ما بیان نماید .' . "\n";
            $CustomerText .= '1 کمترین رضایت.' . "\n";
            $CustomerText .= '5 بیشترین رضایت.' . "\n";
            $CustomerText .= myappenv::CenterName;
            $SMSAttr = [
                'MessageText' => $CustomerText,
                'MobileNumber' => $MobileNumber,
            ];

            $this->SendSMS($SMSAttr);
        }
        return true;
    }
    public function SendAllSMS()
    {
        $UserPointResult = UserPoint::where('point', 0)->groupBy('UserName')->get();

        foreach ($UserPointResult as $UserPointList) {
            $UserinfoResult = UserInfo::where('UserName', $UserPointList->UserName)->first();


            $FooterText = "https://kookbaz.ir/";
            $MessageText = "مشتری گرامی با تشکر از خرید شما از سایت کوکباز
                لطفا میزان رضایت خود را از محصول و خدمت دریافتی باارسال عدد 1 تا 5 اعلام بفرمایید.
                1 کمترین رضایت
                5 بیشترین رضایت
                 $FooterText ";

            $SMSAttr = [
                'MessageText' => $MessageText,
                'MobileNumber' =>  $UserPointList->UserName,
            ];

            $this->SendSMS($SMSAttr);
        }
        return true;
    }
    public function SendSMS($SMSAttr)
    {
        $MessageText = $SMSAttr['MessageText'];
        $Mobile_Number = $SMSAttr['MobileNumber'];
        $MySMS = new SmsCenter();
        $MySMS->OndemandSMS($MessageText, $Mobile_Number, 'SMS SEND', Auth::id());
    }
    public function SetPoint($SMSAttr)
    {
        $MobileNumber = $SMSAttr['MobileNumber'];
        $Point = $SMSAttr['MessageText'];
        $persian = new persian();
        $Point = $persian->EnglishNumber($Point);

        $UserResult = UserInfo::where('MobileNo', $SMSAttr['MobileNumber'])->orWhere('Phone1', $SMSAttr['MobileNumber'])->orWhere('Phone2', $SMSAttr['MobileNumber'])->first();

        if ($UserResult == null) {
            return false;
        }

        $UserPointResult = UserPoint::where('UserName', $UserResult->UserName)->where('Point', 0)->get();
        $UserPoint = UserPoint::where('UserName', $UserResult->UserName)->where('Point', 0)->update(['Point' => $Point]);
        foreach ($UserPointResult as $UserPointResultList) {
            if ($UserPointResultList->order != null) {
                $ProductOrder = product_order::where('id', $UserPointResultList->order)->update(['status' => 100]);
                $MyProduct = new product();
                $CurentDate = date('Y-m-d H:i:s');
                $InputArr = ['UserREport' => $UserResult->UserName, 'Date' => $CurentDate, 'note' => 'اتمام سفارش '];
                $MyProduct->AddReport($UserPointResultList->order, $InputArr);
            }

        }
        $MySMS = new SmsCenter();
        $FooterText = myappenv::CenterName;
        $smstext = "با تشکر پیامک شما دریافت شد
        $FooterText ";
        $MySMS->OndemandSMS($smstext, $MobileNumber, 'SMS Reciver', $MobileNumber);

        return true;
    }
}

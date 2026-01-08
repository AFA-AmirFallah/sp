<?php


namespace App\Users;

use App\APIS\SmsCenter;
use App\Functions\TextClassMain;
use App\Models\UserInfo;
use App\myappenv;
use Illuminate\Support\Facades\Session;
class otp
{
    /**
     * send_otp function use to send one time password used by SMS
     * @param string $MobileNo
     * @return bool
     */
    public function send_otp(string $MobileNo): array
    {
        if ($this->is_sms_bombing()) {
            return [
                'result' => false,
                'msg' => ' تعداد درخواست ارسال کد بیشتر از حد مجاز!'
            ];
        }
        Session::put('MobileNo', $MobileNo);
        $MyPassWoord = rand(myappenv::minpass, myappenv::maxpass);
        Session::put('MyPassWoord', $MyPassWoord);
        Session::save();
        if (env('APP_NAME') == 'local') { //This function for developers test
            $otp_text = 'PassWord:' . Session::get('MyPassWoord') . '</h4>';
            return [
                'result' => false,
                'msg' => $otp_text,
                'user_role' => $this->get_login_user_role($MobileNo)
            ];
        }
        $mytext = new TextClassMain();
        $MyPassWoordRaw = Session::get('MyPassWoord');
        $SMSText = $mytext->ResetPassword(Session::get('MyPassWoord'));
        $MySMS = new SmsCenter();
        $MySMS->OndemandSMS($SMSText, Session::get('MobileNo'), 'otp', Session::get('MobileNo'), $MyPassWoordRaw);

        return [
            'result' => true,
            'user_role' => $this->get_login_user_role($MobileNo)
        ];
    }
    private function get_login_user_role($MobileNo)
    {
        $TargetUser = UserInfo::where('MobileNo', $MobileNo)->first();
        if ($TargetUser == null) {
            $TargetUser = UserInfo::where('UserName', $MobileNo)->first();
        }
        if ($TargetUser == null) {
            return myappenv::role_customer;
        }
        return $TargetUser->Role;

    }
    public function is_sms_bombing()
    {
        if (!session::has('trypass')) {
            session::put('trypass', 0);
        }
        $trypass = session::get('trypass');
        $trypass = (int) $trypass;
        if ($trypass > 2) {
            return true;
        }
        $Restrypadd = $trypass + 1;
        session::put('trypass', $Restrypadd);
        session::get('trypass');
        return false;
    }
}
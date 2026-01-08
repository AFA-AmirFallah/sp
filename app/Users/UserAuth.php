<?php


namespace App\Users;

use App\APIS\SmsCenter;
use App\Functions\TextClassMain;
use App\Models\UserInfo;
use App\myappenv;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Session;

class UserAuth extends UserClass
{
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

    /**
     * send_otp function use to send one time password used by SMS
     * @param string $MobileNo
     * @return bool
     */
    public function send_otp(string $MobileNo): array
    {
        Session::put('MobileNo', $MobileNo);
        $try_opt = Session::get('try_opt') ?? 0;
        if ($try_opt > 5) {
            return ['result' => false, 'message' => 'روال امنیتی سامانه جلوی ارسال پیامک را برای شما مسدود کرده لطفا با پشتیبانی تماس بگیرید'];
        }
        $try_opt++;
        Session::put('try_opt', $try_opt);
        Session::save();
        $sessionKey = 'otp:session:' . session()->getId();
        $phoneKey = 'otp:phone:' . $MobileNo;

        if (RateLimiter::tooManyAttempts($phoneKey, 1)) {
            return ['result' => false, 'message' => 'برای این شماره فعلاً نمی‌توانید درخواست دهید.'];
        }

        if (RateLimiter::tooManyAttempts($sessionKey, 3)) {
            return ['result' => false, 'message' => 'تعداد درخواست‌های شما زیاد بوده. کمی صبر کنید.'];
        }

        RateLimiter::hit($phoneKey, 60);   // شماره → ۶۰ ثانیه
        RateLimiter::hit($sessionKey, 600); // سشن → ۱۰ دقیقه

        $MyPassWoord = rand(myappenv::minpass, myappenv::maxpass);
        Session::put('MyPassWoord', $MyPassWoord);
        Session::save();
        if (env('APP_NAME') == 'local') { //This function for developers test
            echo '<h4 style="
            position: absolute;
            display: table-column;
            z-index: 90;
            text-align: left;
        "> PassWord:' . Session::get('MyPassWoord') . '</h4>';
            return [
                'result' => true,
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
    public function is_valid_confirm_code(string $verification_code)
    {
        if (Session::get('MyPassWoord') == $verification_code) {
            return true;
        }
        return false;
    }
    public function check_valid_try_verification_code()
    {
        if (!Session::has('verification_try')) {
            Session::put('verification_try', 1);
            Session::save();
            return true;
        }
        $verification_try = Session::get('verification_try');
        if ($verification_try > 3) {
            return false;
        }
        $verification_try++;
        Session::put('verification_try', $verification_try);
        Session::save();
        return true;
    }
    private function add_basic_user($MobileNo)
    {
        $userName = $this->add_user_form_calls($MobileNo, $MobileNo, $MobileNo, 'N');
        return $userName;
    }
    public function login_admin_mobile_number($password)
    {
        $MobileNo = Session::get('MobileNo');
        $TargetUser = UserInfo::where('MobileNo', $MobileNo)->first();
        if ($TargetUser == null) {
            $TargetUser = UserInfo::where('UserName', $MobileNo)->first();
        }
        $Main_userName = $TargetUser->UserName;
        $auth_result = Auth::attempt(['UserName' => $Main_userName, 'password' => $password]);
        if ($auth_result) {
            $this->clear_cache();
        }
        return $auth_result;
    }
    private function clear_cache()
    {
        Session::forget('MyPassWoord');
        Session::forget('MobileNo');
        Session::forget('verification_try');
        Session::save();
    }
    public function login_with_mobile_number()
    {
        $MobileNo = Session::get('MobileNo');
        // Type
        /*
            1: Auth Before
            2: Auth new
        */
        $auth_type = 1;
        $ChangeData = [
            'password' => Hash::make(Session::get('MyPassWoord'))
        ];
        $TargetUser = UserInfo::where('MobileNo', $MobileNo)->first();
        if ($TargetUser == null) {
            $TargetUser = UserInfo::where('UserName', $MobileNo)->first();
        }
        if ($TargetUser == null) {
            $this->add_basic_user($MobileNo);
            $auth_type = 2;
            $TargetUser = UserInfo::where('MobileNo', $MobileNo)->first();
        }
        $user_role = $TargetUser->Role;
        $MainPassword = $TargetUser->password ?? 'NA';
        $Main_userName = $TargetUser->UserName;
        UserInfo::where('UserName', $Main_userName)->update($ChangeData);
        $login_result = Auth::attempt(['UserName' => $Main_userName, 'password' => Session::get('MyPassWoord')]);
        $ChangeData = [
            'password' => $MainPassword
        ];
        UserInfo::where('UserName', $Main_userName)->update($ChangeData);
        if ($login_result) {
            $this->clear_cache();
        }
        return [
            'result' => $login_result,
            'type' => $auth_type,
            'user_role' => $user_role
        ];
    }

}

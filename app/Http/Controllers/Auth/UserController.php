<?php

namespace App\Http\Controllers\Auth;

use App\Functions\AlertsNotifications;
use App\Functions\Financial;
use App\Functions\TextClassMain;
use App\Http\Controllers\Controller;
use App\Models\branches;
use App\Models\entrance_personel;
use App\myappenv;
use App\Users\UserAuth;
use Illuminate\Http\Request;
use App\Models\UserInfo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\Functions\JsonWorks;
use App\APIS\SmsCenter;
use App\Functions\CacheData;
use App\Functions\MarketingClass;
use App\Users\UserClass;
use App\Patient\PatientClass;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public $UserName;
    public $UserMobile;
    public $TargetUser;
    public function CheckPassComplex($password)
    {
        //check password is complex or not
        $uppercase = preg_match('@[A-Z]@', $password);
        $lowercase = preg_match('@[a-z]@', $password);
        $number = preg_match('@[0-9]@', $password);
        $specialChars = preg_match('@[^\w]@', $password);
        $PassLen = myappenv::PassLen;
        if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < $PassLen) {
            return false;
        } else {
            return true;
        }
    }

    public function Register()
    {

        $result = false;
        if ($result && myappenv::Lic['wpa']) {
            return view('WPA.Auth.register', ['step' => 1]);
        } else {
            return view("Auth.signUp", ['step' => 1]);
        }
    }
    public function CaptchaChek($InputCaptcha)
    {
        if (strlen($InputCaptcha) != myappenv::CaptchaLen) {
            return false;
        }
        return captcha_check($InputCaptcha);
    }

    public function DoRegister(Request $request)
    {
        $result = false;
        if (myappenv::Captcha == 'local') {
            $captcha = $request->input('captcha');
            $ValidCpatcha = $this->CaptchaChek($captcha);
            if (!$ValidCpatcha) {
                return back()->with('error', 'کد کپچا اشتباه وارد شده است!');
            }
        } else {
            $ValidCpatcha = true;
        }
        if ($request->input("submit") == 'step1') {
            if ($ValidCpatcha) {
                if ($request->has('MobileNo')) {
                    if (UserInfo::where('MobileNo', $request->input('MobileNo'))->get()->count() == 0) {
                        session::put('MobileNo', $request->input('MobileNo'));
                        $MyPassWoord = rand(myappenv::minpass, myappenv::maxpass);
                        session::put('MyPassWoord', $MyPassWoord);
                    } else {
                        return redirect()->back()->with('error', __("The mobile number already exist in system!"));
                    }
                }
                $mytext = new TextClassMain();
                $MyPassWoordRaw = session::get('MyPassWoord');
                $SMSText = $mytext->ResetPassword(session::get('MyPassWoord'));
                $MySMS = new SmsCenter();
                $MySMS->OndemandSMS($SMSText, session::get('MobileNo'), 'otp', session::get('MobileNo'), $MyPassWoordRaw);
                if ($result && myappenv::Lic['wpa']) {
                    return view('WPA.Auth.register', ['step' => 2, 'MobileNo' => session::get('MobileNo')]);
                } else {
                    return view("Auth.signUp", ['step' => 2, 'MobileNo' => session::get('MobileNo')]);
                }
            } else {
                return redirect()->back()->with('error', 'کد امنیتی درست وارد نشده است!');
            }
        } elseif ($request->input("submit") == 'ConfirmCode') {
            if ($request->input('ConfirmCode') == session::get('MyPassWoord')) {
                if ($result && myappenv::Lic['wpa']) {
                    return view('WPA.Auth.register', ['step' => 3]);
                } else {
                    return view("Auth.signUp", ['step' => 3]);
                }
            } else {
                if ($result && myappenv::Lic['wpa']) {
                    return view('WPA.Auth.register', ['step' => 2, 'MobileNo' => session::get('MobileNo'), 'error' => __("The veryfication code is invalid")]);
                } else {
                    return view("Auth.signUp", ['step' => 2, 'MobileNo' => session::get('MobileNo'), 'error' => __("The veryfication code is invalid")]);
                }
            }
        } elseif ($request->input("submit") == 'ResendCode') {
            $mytext = new TextClassMain();
            $SMSText = $mytext->ResetPassword(session::get('MyPassWoord'));
            $MySMS = new SmsCenter();
            $MySMS->OndemandSMS($SMSText, session::get('MobileNo'), 'otp', session::get('MobileNo'), session::get('MyPassWoord'));
            if ($result && myappenv::Lic['wpa']) {
                return view('WPA.Auth.register', ['step' => 2, 'MobileNo' => session::get('MobileNo'), 'success' => __("send confirm code")]);
            } else {
                return view("Auth.signUp", ['step' => 2, 'MobileNo' => session::get('MobileNo'), 'success' => __("send confirm code")]);
            }
        } elseif ($request->input("submit") == 'discard') {
            Session::flush();
            if ($result && myappenv::Lic['wpa']) {
                return view('WPA.Auth.register', ['step' => 1])->with("success", __("Removed input data"));
            } else {
                return view("Auth.signUp", ['step' => 1])->with("success", __("Removed input data"));
            }
        } elseif ($request->input("submit") == 'save') {
            $Marker = new MarketingClass();
            $LastExt = DB::table('UserInfo')->latest('Ext')->first();
            $Ext = $LastExt->Ext;
            if (myappenv::SystemOwner == 'finoward') {
                $role = myappenv::role_trader;
            } else {
                $role = myappenv::role_customer;
            }

            $NewUserData = [
                'UserName' => UserClass::get_free_username(),
                'Email' => $request->input('MobileNo') . "@nomail.com",
                'password' => Hash::make($request->input('Password')),
                'UserPass' => $request->input('Password'),
                'Name' => $request->input('Name'),
                'Ext' => $Ext + 1,
                'Family' => $request->input('Family'),
                'MobileNo' => session::get('MobileNo'),
                'Role' => $role,
                'Sex' => $request->input('Sex'),
                'Status' => myappenv::User_active_status,
                'MarketingCode' => $Marker->get_marketer(),
                'Marketer' => $Marker->get_marketer(),
                'branch' => myappenv::Branch
            ];

            UserInfo::create($NewUserData);
            if (Auth::attempt(['UserName' => session::get('MobileNo'), 'password' => $request->input('Password')])) {
                if (Session::has('intended_url')) {
                    $TargetUrl = Session::get('intended_url');
                    //Session::forget('UrlPrevious');
                    return redirect()->to($TargetUrl);
                } else {
                    return redirect()->route('home');
                }
            }
        }
    }

    public function forgot()
    {
        return view("Auth.forgot");
    }

    public function Doforgot(Request $request)
    {
        if (myappenv::Captcha == 'local') {
            if ($result && myappenv::Lic['wpa']) {
                $captcah = true;
            } else {
                $captcha = $request->input('captcha');
                if (strlen($captcha) != myappenv::CaptchaLen) {
                    return back()->with('error', 'کد کپچا اشتباه وارد شده است!');
                }
                $captcah = captcha_check($captcha);
            }
        } else {
            $captcah = true;
        }

        if ($captcah) {
            $validatedData = $request->validate([
                'UserName' => 'required|max:11|min:11',
            ], [
                'UserName.required' => 'پر کردن فیلد شماره تلفن الزامی میباشد!',
                'UserName.max' => 'شماره مویایل وارد شده اشتباه است!',
                'UserName.min' => 'شماره مویایل وارد شده اشتباه است!',
            ]);
            $TargetUser = $request->input('UserName');
            $MyPassWoord = rand(myappenv::minpass, myappenv::maxpass);
            $UpdateUserPassword = [
                'password' => Hash::make($MyPassWoord),
            ];
            $result = UserInfo::where('MobileNo', $TargetUser)
                ->update($UpdateUserPassword);
            if ($result == 0) {
                return redirect()->back()->withErrors('نام کاربری موجود نمی باشد');
            }
            $mytext = new TextClassMain();
            $SMSText = $mytext->ResetPassword($MyPassWoord);
            $MySMS = new SmsCenter();
            $MySMS->OndemandSMS($SMSText, $request->input('UserName'), 'otp', $request->input('UserName'), $MyPassWoord);
            return redirect()->route('login')->with('success', "Your password sent by sms!");
        } else {
            return redirect()->back()->with('error', 'کد امنیتی درست وارد نشده است!');
        }
    }

    public function logout()
    {
        Session::flush();
        Auth::logout();
        return redirect()->route('login');
    }
    private function LoginNew()
    {
        if (Auth::check()) {  // if user already login
            return redirect()->route('home');
        }
        Session::forget('MobileNo');
        $TargetUrl = Redirect::intended()->getTargetUrl();
        Session::put('intended_url', $TargetUrl);
        return view('Auth.Theme5.login');
    }
    private function send_otp(Request $request)
    {
        $auth_proc = new UserAuth;
        $phone_number = $request->phone_number;
        $user_auth = new UserAuth;
        $send_otp_result = $user_auth->send_otp($request->phone_number);
        $targte_role = $send_otp_result['user_role'];
        $management_login = false;
        if ($targte_role > myappenv::role_customer) {
            $management_login = true;
        }
        return view('Auth.Theme5.login_verify_phone_number', ['phone_number' => $request->phone_number, 'management_login' => $management_login])->render();
    }

    private function check_verification_code(Request $request)
    {
        $user_auth = new UserAuth;
        if (!$user_auth->check_valid_try_verification_code()) { // try more than standard
            return [
                'result' => false,
                'msg' => ' شما بیش از حد مجاز پسورد وارد کرده اید ساعاتی دیگر مجددا تلاش کنید!'
            ];
        }
        $verification_code = $request->verification_code;
        if ($user_auth->is_valid_confirm_code($verification_code)) {
            $user_auth->login_with_mobile_number();
            return [
                'result' => true,
                'data' => view('Auth.Theme5.login_welcome')->render()
            ];
        } else {
            return [
                'result' => false,
                'msg' => 'کد وارد شده صحیح نمی‌باشد!'
            ];
        }

    }
    private function check_verification_code_admin(Request $request)
    {
        $user_auth = new UserAuth;
        if (!$user_auth->check_valid_try_verification_code()) { // try more than standard
            return [
                'result' => false,
                'msg' => ' شما بیش از حد مجاز پسورد وارد کرده اید ساعاتی دیگر مجددا تلاش کنید!'
            ];
        }
        $verification_code = $request->verification_code;
        $password = $request->password;
        if ($user_auth->is_valid_confirm_code($verification_code)) {
            $login_result = $user_auth->login_admin_mobile_number($password);
            if (!$login_result) {
                return [
                    'result' => false,
                    'msg' => 'گذرواژه وارد شده صحیح نمی‌باشد!'
                ];
            }
            return [
                'result' => true,
                'data' => view('Auth.Theme5.login_welcome')->render()
            ];
        } else {
            return [
                'result' => false,
                'msg' => 'کد وارد شده صحیح نمی‌باشد!'
            ];
        }

    }
    public function DoLoginNew(Request $request, $BranchName = null)
    {
        if ($request->ajax()) {
            $function = $request->function;
            switch ($function) {
                case 'send_otp':
                    return $this->send_otp($request);
                case 'verification_code':
                    return $this->check_verification_code($request);
                case 'confirm_verification_code':
                    return $this->check_verification_code($request);
                case 'confirm_verification_code_admin':
                    return $this->check_verification_code_admin($request);
            }
        }

    }

    public function Login($BranchName = null)
    {
        if (myappenv::SiteTheme == 'Theme5') {
            return $this->LoginNew();
        }
        if (myappenv::Lic['MultiBranch']) {
            $multi_branch = true;
        } else {
            $multi_branch = false;
        }

        if (Auth::check()) {  // if user already login
            return redirect()->route('home');
        }
        Session::forget('MobileNo');
        $TargetUrl = Redirect::intended()->getTargetUrl();
        Session::put('intended_url', $TargetUrl);
        if (myappenv::DashboardTheme == 'Theme2') {
            return view('Theme2.SignIn', ['multi_branch' => $multi_branch, 'BrEanchName' => $BranchName, 'Step' => 'init', 'TargetUrl' => $TargetUrl]);
        }
        if (myappenv::AuthType == 2) {
            return view('Auth.signIn', ['multi_branch' => $multi_branch, 'BranchName' => $BranchName, 'Step' => 'init', 'TargetUrl' => $TargetUrl]);
        } elseif (myappenv::AuthType == 1) {
            return view('Auth.AuthOneStep', ['multi_branch' => $multi_branch, 'BranchName' => $BranchName, 'Step' => 'init', 'TargetUrl' => $TargetUrl, 'branch_src' => null]);
        } elseif (myappenv::AuthType == 3 || myappenv::AuthType == 4) {
            return view('Auth.AuthOneStepSMS', ['multi_branch' => $multi_branch, 'BranchName' => $BranchName, 'Step' => 'init', 'TargetUrl' => $TargetUrl]);
        }
    }
    public function user_count_with_mobile_no($Mobile_number, $SetClassVale)
    {
        $TargetUser = UserInfo::where('MobileNo', $Mobile_number)->get();
        $Query = "SELECT UserInfo.* , branches.Description as branch_desc , branches.avatar as branch_avatar , UserRole.RoleName  from UserInfo INNER JOIN branches on UserInfo.branch = branches.id INNER JOIN UserRole on UserInfo.Role = UserRole.Role
        where UserInfo.MobileNo = '$Mobile_number'";
        $TargetUser = DB::select($Query);
        $record_count = count($TargetUser);
        return [
            'record_count' => $record_count,
            'UserInfo_src' => $TargetUser
        ];
    }
    public function CheckUserExist($UserName, $SetClassVale, int $Branch)
    {
        $TargetUser = UserInfo::where('UserName', $UserName)->first();
        if ($TargetUser == null) {
            return false;
        } else {
            if ($SetClassVale) {
                $this->UserName = $UserName;
                $this->UserMobile = $TargetUser->MobileNo;
                $this->TargetUser = $TargetUser;
            }
            return true;
        }
    }
    public function is_mobile_number($InputStr)
    {
        return str_starts_with($InputStr, '09');
    }
    public function send_confirm_code($Password = null)
    {
        if ($Password == null) {
            $Password = session::get('MyPassWoord');
        }
        if (env('APP_NAME') == 'local') {
            echo '<h4 style="
            position: absolute;
            display: table-column;
            z-index: 90;
            text-align: left;
        "> PassWord:' . $Password . '</h4>';
        } else {
            $mytext = new TextClassMain();
            $SMSText = $mytext->ResetPassword($Password);
            $MySMS = new SmsCenter();
            $MySMS->OndemandSMS($SMSText, session::get('MobileNo'), 'otp', session::get('MobileNo'), $Password);
        }
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
    public function admin_send_confirm_code($UserName)
    {
        $TargetUser = UserInfo::where('UserName', $UserName)->first();
        session::put('MobileNo', $TargetUser->MobileNo ?? $UserName);
        session::put('UserName', $UserName);
        $MyPassWoord = rand(myappenv::minpass, myappenv::maxpass);
        session::put('MyPassWoord', $MyPassWoord);
        if ($this->is_sms_bombing()) {
            return redirect()->route('logout')->with('error', ' تعداد درخواست ارسال کد بیشتر از حد مجاز!');
        }
        $this->send_confirm_code();
        return true;
    }

    public function new_user_send_code_init($UserName)
    {
        if ($this->is_mobile_number($UserName)) {
            session::put('MobileNo', $UserName);
            session::put('UserName', $UserName);

            $MyPassWoord = rand(myappenv::minpass, myappenv::maxpass);
            session::put('MyPassWoord', $MyPassWoord);
            if ($this->is_sms_bombing()) {
                return redirect()->route('logout')->with('error', ' تعداد درخواست ارسال کد بیشتر از حد مجاز!');
            }
            $this->send_confirm_code();
            if (myappenv::DashboardTheme == 'Theme2') {
                return view("Theme2.AuthOneStep", ['Step' => 'register', 'MobileNo' => $UserName]);
            } else {
                return view("Auth.AuthOneStep", ['Step' => 'register', 'MobileNo' => $UserName, 'branch_src' => null]);
            }
        } else {
            return view("Auth.AuthOneStep", ['Step' => 'init', 'branch_src' => null])->with('error', 'شماره موبایل وارد شده صحیح نمی باشد!');
        }
    }
    private function is_valid_confirm_code($confirmcode)
    {
        if ($confirmcode == session::get('MyPassWoord')) {
            return true;
        } else {
            return false;
        }
    }
    private function clear_auth_data($status)
    {
        if ($status == 'all') {
        }
    }
    private function admin_login($UserName, $Password)
    {

        return Auth::attempt(['UserName' => $UserName, 'password' => $Password]);
    }
    public function login_with_onetime_pass($UserName, $OneTimePass)
    {
        Log::channel('local')->info('This is some useful information username =>' . $UserName);
        $ChangeData = [
            'password' => Hash::make($OneTimePass)
        ];

        $TargetUser = UserInfo::where('MobileNo', $UserName)->first();
        if ($TargetUser == null) {
            $TargetUser = UserInfo::where('UserName', $UserName)->first();
        }
        if ($TargetUser == null) {
            return false;
        }

        $MainPassword = $TargetUser->password ?? 'NA';
        $Main_userName = $TargetUser->UserName;
        UserInfo::where('UserName', $Main_userName)->update($ChangeData);
        Auth::attempt(['UserName' => $Main_userName, 'password' => $OneTimePass]);
        $ChangeData = [
            'password' => $MainPassword
        ];
        UserInfo::where('UserName', $Main_userName)->update($ChangeData);
        return true;
    }
    private function after_login_jobs()
    {
        $MyAlert = new AlertsNotifications();
        $MyAlert->MyNotification(\Illuminate\Support\Facades\Auth::id(), Auth::user()->Role);
        $extranote = Auth::user()->extranote;
        $MyJson = new JsonWorks();
        $extranoteArr = $MyJson->GetJsonInArray($extranote);
        if (Auth::user()->Role < myappenv::role_SuperAdmin) {
            Session::put('target', Auth::id());
        }
        Session::put('accesstype', 'wpa');
        $Myfin = new Financial();
        Session::put('UserCredit', $Myfin->UserHasCredite(\Illuminate\Support\Facades\Auth::id(), myappenv::CachCredit));
        if (Auth::user()->branch != null) {
            $branch = branches::where('id', Auth::user()->branch)->first();
            if ($branch->avatar != null) {
                Session::put('BrandLogo', $branch->avatar);
            } else {
                Session::put('BrandLogo', url('/') . \App\myappenv::ShafatelIcon);
            }
        } else {
            Session::put('BrandLogo', url('/') . \App\myappenv::ShafatelIcon);
        }

        if (isset($extranoteArr['pic'])) {
            Session::put('UserPic', $extranoteArr['pic']);
        } else {
            Session::put('UserPic', url('/') . myappenv::LoginUserAvatarPic);
        }
    }
    private function send_verification_code_to_input_mobile($Mobile_number)
    {
        session::put('MobileNo', $Mobile_number);
        $this->admin_send_confirm_code($Mobile_number);
    }
    private function single_account_user($UserInfo_src)
    {

        if ($UserInfo_src[0]->Role > myappenv::role_trader) {
            session::put('MobileNo', $UserInfo_src[0]->UserName);
            $BranchInfo = branches::where('id', $UserInfo_src[0]->branch)->first();
            return view('Auth.Type4.login_password_for_admins', ['BranchInfo' => $BranchInfo]);
        } else {
            $mytext = new TextClassMain;
            $pass = $mytext->StrRandom(8);
            $this->login_with_onetime_pass($UserInfo_src[0]->UserName, $pass);
            if (Auth::check()) {
                if (Auth::user()->Role == myappenv::role_worker) {
                    if (auth::user()->avatar == null) {
                        return redirect()->route('UserProfile')->with('error', 'لطفا اطلاعات خود را تکمیل کنید!');
                    }
                }
            }
            if (Session::has('intended_url')) {
                $TargetUrl = Session::get('intended_url');
                Session::forget('UrlPrevious');
                return redirect()->to($TargetUrl);
            } else {
                return redirect()->route('home');
            }
        }
    }
    private function multi_account_user($UserInfo_src)
    {

        return view('Auth.Type4.user_account_selector', ['UserInfo_src' => $UserInfo_src]);
    }
    private function do_login_mobile_base(Request $request, int $Branch)
    {
        if ($Branch == null) {
            $branch_src = null;
        } else {
            $branch_src = branches::where('id', $Branch)->first();
        }


        if ($request->has('accountlogin')) {
            $target_UserName = $request->accountlogin;
            $target_mobile_number = session::get('MobileNo');
            $Target_user_src = UserInfo::where('UserName', $target_UserName)->where('MobileNo', $target_mobile_number)->first();
            if ($Target_user_src == null) {
                return abort('404', 'مشکل امنیتی ۷۷۴۶۲');
            }
            if ($Target_user_src->Role > myappenv::role_trader) {
                session::put('MobileNo', $target_UserName);
                $BranchInfo = branches::where('id', $Target_user_src->branch)->first();
                return view('Auth.Type4.login_password_for_admins', ['BranchInfo' => $BranchInfo]);
            } else {
                $mytext = new TextClassMain;
                $pass = $mytext->StrRandom(8);
                $this->login_with_onetime_pass($target_UserName, $pass);
                if (Session::has('intended_url')) {
                    $TargetUrl = Session::get('intended_url');
                    Session::forget('UrlPrevious');
                    return redirect()->to($TargetUrl);
                } else {
                    return redirect()->route('home');
                }
            }
        }
        if ($request->input('submit') == 'OneStep_1') {
            $MobileNo = $request->input('UserName');
            $this->send_verification_code_to_input_mobile($MobileNo);
            return view('Auth.Type4.basic_verification_confirm', ['MobileNo' => $MobileNo, 'branch_src' => $branch_src]);
        } elseif ($request->submit == 'admin_password') {
            $target_UserName = session::get('MobileNo');
            if (Auth::attempt(['UserName' => $target_UserName, 'password' => Hash::make($request->input('Password'))  ])) {
                if (Session::has('intended_url')) {
                    $TargetUrl = Session::get('intended_url');
                    Session::forget('UrlPrevious');
                    return redirect()->to($TargetUrl);
                } else {
                    return redirect()->route('home');
                }
            } else {
                return redirect()->back()->with('error', 'گذرواژه اشتباه است');
            }
        } elseif ($request->input('submit') == 'confirmcode') {
            $ConfirmCode = '';
            foreach ($request->confirmcode as $ConfirmDigit) {
                $ConfirmCode .= $ConfirmDigit;
            }
            if ($this->is_valid_confirm_code($ConfirmCode)) {
                $user_with_mobile_src = $this->user_count_with_mobile_no(session()->get('MobileNo'), true);
                if ($user_with_mobile_src['record_count'] > 1) { // then user has multi account
                    return $this->multi_account_user($user_with_mobile_src['UserInfo_src']);
                } elseif ($user_with_mobile_src['record_count'] == 1) { // the user has single account
                    return $this->single_account_user($user_with_mobile_src['UserInfo_src']);
                } elseif ($user_with_mobile_src['record_count'] == 0) { // the user has not registerd before

                    return view('Auth.Type4.register_user', ['branch_src' => $branch_src]);
                }
            } else {   // confirm code  error
                return view('Auth.Type4.basic_verification_confirm', ['MobileNo' => session()->get('MobileNo')])->withErrors('کد یکبار مصرف اشتباه است!');
            }
        } elseif ($request->input('submit') == 'Saveinfo' || $request->input('submit') == 'SaveinfoOneTime') {
            $SaveType = $request->input('submit');

            if ($SaveType == 'Saveinfo') {
                $ImputPass = $request->input('Password');
                $CheckPassResult = $this->check_password_policy($ImputPass);
                if ($CheckPassResult != 'ok') {
                    $errors = new MessageBag();

                    // add your error messages:
                    $errors->add('error', $CheckPassResult);
                    return view("Auth.AuthOneStep", ['Step' => 'information', 'branch_src' => $branch_src])->withErrors($errors);
                }
                $TosavePass = Hash::make($ImputPass);
            } elseif ($SaveType == 'SaveinfoOneTime') {
                $TosavePass = 'NA';
            } else {
                return abort('404', '33fuewf بروز مشکل امنیتی!');
            }
            $Name = strip_tags($request->input('Name'));
            $Family = strip_tags($request->input('Family'));
            $Marker = new MarketingClass();
            $LastExt = DB::table('UserInfo')->latest('Ext')->first();
            $Ext = $LastExt->Ext;
            if (myappenv::SystemOwner == 'finoward') {
                $role = myappenv::role_trader;
            } else {
                $role = myappenv::role_customer;
            }
            $UserName = UserClass::get_free_username();
            if ($Branch == null) {
                $Branch = myappenv::Branch;
            }
            $NewUserData = [
                'UserName' => $UserName,
                'Email' => $request->input('MobileNo') . "@nomail.com",
                'password' => $TosavePass,
                'UserPass' => $TosavePass,
                'Name' => $Name,
                'Ext' => $Ext + 1,
                'Family' => $Family,
                'MobileNo' => session::get('MobileNo'),
                'Role' => $role,
                'Sex' => $request->input('Sex'),
                'Status' => myappenv::User_active_status,
                'MarketingCode' => $Marker->get_marketer(),
                'Marketer' => $Marker->get_marketer(),
                'branch' => $Branch
            ];

            $Feilds = CacheData::GetSetting('register_feilds');

            $Feilds = json_decode($Feilds);
            if (myappenv::MainOwner == 'shafatel') {
                $log_text = 'کاربر جدید ' . "$Name $Family شعبه: $Branch شماره موبایل: " . session::get('MobileNo');
                Log::channel('slack')->info($log_text);
            }

            if (isset($Feilds->melliid)) {
                if (isset($Feilds->melliid_req)) {
                    //TODO:Check MelliId validation
                    $NewUserData['MelliID'] = $request->MelliID;
                } else {
                    if ($request->has('MelliID')) {
                        $NewUserData['MelliID'] = $request->MelliID;
                    }
                }
            }
            UserInfo::create($NewUserData);
            $this->clear_auth_data('all');
            //todo: access by na pass
            if ($SaveType == 'Saveinfo') { //access by real password
                if (Auth::attempt(['UserName' => $UserName, 'password' => $request->input('Password')])) {
                    if (Session::has('intended_url')) {
                        $TargetUrl = Session::get('intended_url');
                        Session::forget('UrlPrevious');
                        return redirect()->to($TargetUrl);
                    } else {
                        return redirect()->route('home');
                    }
                }
            } elseif ($SaveType == 'SaveinfoOneTime') { // access by one time password
                $this->login_with_onetime_pass($UserName, '123');
                if (Session::has('intended_url')) {
                    $TargetUrl = Session::get('intended_url');
                    Session::forget('UrlPrevious');
                    return redirect()->to($TargetUrl);
                } else {
                    return redirect()->route('home');
                }
            }
        } elseif ($request->input('submit') == 'GetPass' || $request->input('submit') == 'resend') { // ارسال کد یکبار مصرف برای کاربر

            if (session::has('UserName')) { //admin login
                $this->admin_send_confirm_code(session::get('UserName'));
                return view("Auth.AuthOneStep", ['Step' => 'adminlogin', 'UserInfo' => $this->TargetUser, 'branch_src' => $branch_src ?? null]);
            } else {
                if ($this->is_sms_bombing()) {
                    return redirect()->route('logout')->with('error', ' تعداد درخواست ارسال کد بیشتر از حد مجاز!');
                }
                $MyPassWoord = rand(myappenv::minpass, myappenv::maxpass);
                $this->send_confirm_code($MyPassWoord);
                session::put('onetimepass', $MyPassWoord);

                return view("Auth.AuthOneStep", ['Step' => 'loginWithSendCode', 'MobileNo' => session()->get('MobileNo'), 'branch_src' => $branch_src ?? null]);
            }
        } elseif ($request->input('submit') == 'login') {
            if (session::has('UserName')) { //admin login
                if ($request->input('onetime') == session::get('MyPassWoord')) {
                    $loginresutl = $this->admin_login(session::get('UserName'), $request->input('Password'));
                    if ($loginresutl) {
                        if (Session::has('intended_url')) {
                            $TargetUrl = Session::get('intended_url');

                            //Session::forget('UrlPrevious');
                            return redirect()->to($TargetUrl);
                        } else {
                            return redirect()->route('home');
                        }
                    } else {
                        $errors = new MessageBag();
                        $errors->add('error', 'پسورد وارد شده اشتباه است');
                        return view("Auth.AuthOneStep", ['Step' => 'adminlogin', 'UserInfo' => $this->TargetUser, 'branch_src' => $branch_src ?? null])->withErrors($errors);
                    }
                } else {
                    $errors = new MessageBag();
                    $errors->add('error', 'کد وارد شده اشتباه است');
                    return view("Auth.AuthOneStep", ['Step' => 'adminlogin', 'UserInfo' => $this->TargetUser, 'branch_src' => $branch_src ?? null])->withErrors($errors);
                }
            }
            if (session::has('onetimepass')) { //request One Time Password
                if ($request->input('Password') == session::get('onetimepass')) {
                    $this->login_with_onetime_pass(session::get('MobileNo'), session::get('onetimepass'));
                    $this->after_login_jobs();
                    if (Session::has('intended_url')) {
                        $TargetUrl = Session::get('intended_url');
                        //Session::forget('UrlPrevious');
                        return redirect()->to($TargetUrl);
                    } else {
                        return redirect()->route('home');
                    }
                } else {
                    return redirect()->back()->with('error', 'اطلاعات وارد شده اشتباه است!');
                }
            } else {
                if (Auth::attempt(['UserName' => session::get('MobileNo'), 'password' => $request->input('Password')])) {
                    $this->after_login_jobs();
                    if (Session::has('intended_url')) {
                        $TargetUrl = Session::get('intended_url');
                        //Session::forget('UrlPrevious');
                        return redirect()->to($TargetUrl);
                    } else {
                        return redirect()->route('home');
                    }
                } else {
                    return view("Auth.AuthOneStep", ['Step' => 'login', 'UserInfo' => session::get('MobileNo'), 'branch_src' => $branch_src ?? null])->with('error', 'گذرواژه اشتباه است');
                }
            }
        }
    }
    private function DoLogin1Step(Request $request, int $Branch)
    {
        if ($request->input('submit') == 'OneStep_1') {
            if ($this->CheckUserExist($request->input('UserName'), true, $Branch)) { //if user registerd before
                // $this->UserName = $request->input('UserName');
                session::put('MobileNo', $this->UserName);
                session::put('UserName', $this->UserName);

                $TargetUser = $this->TargetUser;
                if (myappenv::DashboardTheme == 'Theme2') {
                    $this->admin_send_confirm_code($this->UserName);
                    return view("Theme2.AuthOneStep", ['Step' => 'adminlogin', 'UserInfo' => $this->TargetUser]);
                }
                if ($TargetUser->Role > myappenv::role_superviser) {
                    $this->admin_send_confirm_code($this->UserName);

                    return view("Auth.AuthOneStep", ['Step' => 'adminlogin', 'UserInfo' => $this->TargetUser, 'branch_src' => $branch_src ?? null]);
                } else {
                    if (myappenv::AuthType == 1) {
                        return view("Auth.AuthOneStep", ['Step' => 'login', 'UserInfo' => $this->TargetUser, 'branch_src' => $branch_src ?? null]);
                    }
                    if (myappenv::AuthType == 3) {
                        if (session::has('UserName')) { //admin login
                            $this->admin_send_confirm_code(session::get('UserName'));
                            return view("Auth.AuthOneStep", ['Step' => 'adminlogin', 'UserInfo' => $this->TargetUser, 'branch_src' => $branch_src ?? null]);
                        } else {
                            if ($this->is_sms_bombing()) {
                                return redirect()->route('logout')->with('error', ' تعداد درخواست ارسال کد بیشتر از حد مجاز!');
                            }
                            $MyPassWoord = rand(myappenv::minpass, myappenv::maxpass);
                            $this->send_confirm_code($MyPassWoord);
                            session::put('onetimepass', $MyPassWoord);
                            return view("Auth.AuthOneStep", ['Step' => 'loginWithSendCode', 'MobileNo' => session()->get('MobileNo'), 'branch_src' => $branch_src ?? null]);
                        }
                    }
                }
            } else { // user is new user
                return $this->new_user_send_code_init($request->input('UserName'));
            }
        } elseif ($request->input('submit') == 'confirmcode') {
            if (myappenv::DashboardTheme == 'Theme2') {
                $ConfirmCode = '';
                foreach ($request->confirmcode as $ConfirmDigit) {
                    $ConfirmCode .= $ConfirmDigit;
                }
                if ($this->is_valid_confirm_code($ConfirmCode)) {
                    if (session::has('UserName')) {

                        $result = $this->login_with_onetime_pass(session::get('UserName'), '123');
                        if (!$result) { // the user should to register
                            return view("Theme2.AuthOneStep", ['Step' => 'information']);
                        }
                        if (Session::has('intended_url')) {
                            $TargetUrl = Session::get('intended_url');
                            Session::forget('UrlPrevious');
                            return redirect()->to($TargetUrl);
                        } else {
                            return redirect()->route('home');
                        }
                    }
                }
            } else {
                $ConfirmCode = $request->input('confirmcode');
            }

            if ($this->is_valid_confirm_code($ConfirmCode)) {
                if (myappenv::DashboardTheme == 'Theme2') {
                    return view("Theme2.AuthOneStep", ['Step' => 'information']);
                }
                return view("Auth.AuthOneStep", ['Step' => 'information', 'branch_src' => null]);
            } else {   // confirm code  error
                return view("Auth.AuthOneStep", ['Step' => 'register', 'MobileNo' => session()->get('MobileNo'), 'branch_src' => null])->with('error', 'کد یکبار مصرف اشتباه است!');
            }
        } elseif ($request->input('submit') == 'Saveinfo' || $request->input('submit') == 'SaveinfoOneTime') {
            $SaveType = $request->input('submit');

            if ($SaveType == 'Saveinfo') {
                if ($request->has('Password')) {
                    $ImputPass = $request->input('Password');
                } else {
                    $mytest = new TextClassMain;
                    $ImputPass = $mytest->StrRandom();
                }

                $CheckPassResult = $this->check_password_policy($ImputPass);
                if ($CheckPassResult != 'ok') {
                    $errors = new MessageBag();

                    // add your error messages:
                    $errors->add('error', $CheckPassResult);
                    return view("Auth.AuthOneStep", ['Step' => 'information', 'branch_src' => null])->withErrors($errors);
                }
                $TosavePass = Hash::make($ImputPass);
            } elseif ($SaveType == 'SaveinfoOneTime') {
                $TosavePass = 'NA';
            } else {
                return abort('404', '33fuewf بروز مشکل امنیتی!');
            }

            $Name = strip_tags($request->input('Name'));
            $Family = strip_tags($request->input('Family'));
            $Marker = new MarketingClass();
            $LastExt = DB::table('UserInfo')->latest('Ext')->first();
            $Ext = $LastExt->Ext;
            if (myappenv::SystemOwner == 'finoward') {
                $role = myappenv::role_trader;
            } else {
                $role = myappenv::role_customer;
            }


            $NewUserData = [
                'UserName' => UserClass::get_free_username(),
                'Email' => $request->input('MobileNo') . "@nomail.com",
                'password' => $TosavePass,
                'UserPass' => $TosavePass,
                'Name' => $Name,
                'Ext' => $Ext + 1,
                'Family' => $Family,
                'MobileNo' => session::get('MobileNo'),
                'Role' => $role,
                'Sex' => $request->input('Sex'),
                'Status' => myappenv::User_active_status,
                'MarketingCode' => $Marker->get_marketer(),
                'Marketer' => $Marker->get_marketer(),
                'branch' => myappenv::Branch
            ];

            $Feilds = CacheData::GetSetting('register_feilds');
            $Feilds = json_decode($Feilds);

            if (isset($Feilds->melliid)) {
                if (isset($Feilds->melliid_req)) {
                    //TODO:Check MelliId validation
                    $NewUserData['MelliID'] = $request->MelliID;
                } else {
                    if ($request->has('MelliID')) {
                        $NewUserData['MelliID'] = $request->MelliID;
                    }
                }
            }
            UserInfo::create($NewUserData);
            $this->clear_auth_data('all');
            //todo: access by na pass
            if ($SaveType == 'Saveinfo') { //access by real password
                if (Auth::attempt(['UserName' => session::get('MobileNo'), 'password' => $request->input('Password')])) {
                    if (Session::has('intended_url')) {
                        $TargetUrl = Session::get('intended_url');
                        Session::forget('UrlPrevious');
                        return redirect()->to($TargetUrl);
                    } else {
                        return redirect()->route('home');
                    }
                }
            } elseif ($SaveType == 'SaveinfoOneTime') { // access by one time password
                $this->login_with_onetime_pass(session::get('MobileNo'), '123');
                if (Auth::user()->status != 101)
                    if (Session::has('intended_url')) {
                        $TargetUrl = Session::get('intended_url');
                        Session::forget('UrlPrevious');
                        return redirect()->to($TargetUrl);
                    } else {
                        return redirect()->route('home');
                    }
            }
        } elseif ($request->input('submit') == 'GetPass' || $request->input('submit') == 'resend') { // ارسال کد یکبار مصرف برای کاربر

            if (session::has('UserName')) { //admin login
                $this->admin_send_confirm_code(session::get('UserName'));
                return view("Auth.AuthOneStep", ['Step' => 'adminlogin', 'UserInfo' => $this->TargetUser, 'branch_src' => $branch_src ?? null]);
            } else {
                if ($this->is_sms_bombing()) {
                    return redirect()->route('logout')->with('error', ' تعداد درخواست ارسال کد بیشتر از حد مجاز!');
                }
                $MyPassWoord = rand(myappenv::minpass, myappenv::maxpass);
                $this->send_confirm_code($MyPassWoord);
                session::put('onetimepass', $MyPassWoord);

                return view("Auth.AuthOneStep", ['Step' => 'loginWithSendCode', 'MobileNo' => session()->get('MobileNo'), 'branch_src' => $branch_src ?? null]);
            }
        } elseif ($request->input('submit') == 'login') {
            if (session::has('UserName')) { //admin login
                if ($request->input('onetime') == session::get('MyPassWoord')) {
                    $loginresutl = $this->admin_login(session::get('UserName'), $request->input('Password'));
                    if ($loginresutl) {
                        if (Session::has('intended_url')) {
                            $TargetUrl = Session::get('intended_url');

                            //Session::forget('UrlPrevious');
                            return redirect()->to($TargetUrl);
                        } else {
                            return redirect()->route('home');
                        }
                    } else {
                        $errors = new MessageBag();
                        $errors->add('error', 'پسورد وارد شده اشتباه است');
                        return view("Auth.AuthOneStep", ['Step' => 'adminlogin', 'UserInfo' => $this->TargetUser, 'branch_src' => $branch_src ?? null])->withErrors($errors);
                    }
                } else {
                    $errors = new MessageBag();
                    $errors->add('error', 'کد وارد شده اشتباه است');
                    return view("Auth.AuthOneStep", ['Step' => 'adminlogin', 'UserInfo' => $this->TargetUser, 'branch_src' => $branch_src ?? null])->withErrors($errors);
                }
            }
            if (session::has('onetimepass')) { //request One Time Password
                if ($request->input('Password') == session::get('onetimepass')) {
                    $this->login_with_onetime_pass(session::get('MobileNo'), session::get('onetimepass'));
                    $this->after_login_jobs();
                    if (Session::has('intended_url')) {
                        $TargetUrl = Session::get('intended_url');
                        //Session::forget('UrlPrevious');
                        return redirect()->to($TargetUrl);
                    } else {
                        return redirect()->route('home');
                    }
                } else {
                    return redirect()->back()->with('error', 'اطلاعات وارد شده اشتباه است!');
                }
            } else {
                if (Auth::attempt(['UserName' => session::get('MobileNo'), 'password' => $request->input('Password')])) {
                    $this->after_login_jobs();
                    if (Session::has('intended_url')) {
                        $TargetUrl = Session::get('intended_url');
                        //Session::forget('UrlPrevious');
                        return redirect()->to($TargetUrl);
                    } else {
                        return redirect()->route('home');
                    }
                } else {
                    return view("Auth.AuthOneStep", ['Step' => 'login', 'UserInfo' => session::get('MobileNo'), 'branch_src' => $branch_src ?? null])->with('error', 'گذرواژه اشتباه است');
                }
            }
        }
    }
    public function check_password_policy($Password)
    {
        if (strlen($Password) < myappenv::PassLen) {
            return 'پسورد وارد شده کوتاه است. حد اقل طول پسورد می باید ' . myappenv::PassLen . ' کارکتر باشد ! ';
        } else {
            if (myappenv::ComplexPass) {
                if (!$this->CheckPassComplex($Password)) {
                    return "پسورد وارد شده پیچیدگی لازم را ندارد";
                } else {
                    return 'ok';
                }
            } else {
                return 'ok';
            }
        }
    }
    public function DoLogin(Request $request, $BranchName = null)
    {
        if (myappenv::SiteTheme == 'Theme5') {
            return $this->DoLoginNew($request, $BranchName);
        }
        if (myappenv::Lic['MultiBranch']) {
            if ($request->axios) {
                if ($request->function == 'add_patient') {
                    $Patiant = new PatientClass;
                    return $Patiant->add_new_patient($request);
                }
            }
            if ($BranchName == null) {
                $Branch = myappenv::Branch;
            } else {
                $BranchSrc = \App\Branchs\BranchsFunctions::get_branch_id_with_name($BranchName);
                $Result = $BranchSrc['result'];
                if ($Result) {
                    $BranchSrc = $BranchSrc['data'];
                    $Branch = $BranchSrc->id;
                } else {
                    $Branch = myappenv::Branch;
                }
            }
        } else {
            $Branch = myappenv::Branch;
        }


        if (Session::has('intended_url_important')) {
            Session::put('intended_url', Session::get('intended_url_important'));
        }

        if (myappenv::Captcha == 'local') {
            if (session::has('MobileNo')) {
                $ValidCpatcha = true;   // if user already pass captcha
            } else {
                $captcha = $request->input('captcha');
                $ValidCpatcha = $this->CaptchaChek($captcha);
                if (!$ValidCpatcha) {
                    return back()->with('error', 'کد کپچا اشتباه وارد شده است!');
                }
            }
        } else {
            $ValidCpatcha = true;
        }
        if ($ValidCpatcha) {
            if (myappenv::AuthType == 1 || myappenv::AuthType == 3) {
                return $this->DoLogin1Step($request, $Branch);
            } elseif (myappenv::AuthType == 4) {
                return $this->do_login_mobile_base($request, $Branch);  //shafatel finoward
            } else {
                if (myappenv::ComplexPass) {
                    if (strlen($request->input('Password')) < myappenv::PassLen) {
                        return redirect()->back()->with('error', 'لطفا از کد یکبار مصرف استفاده فرمایید!');
                    }
                }
                if (Auth::attempt(['UserName' => $request->input('UserName'), 'password' => $request->input('UserPass'), 'Status' => myappenv::User_active_status])) {
                    $MyAlert = new AlertsNotifications();
                    $MyAlert->MyNotification(\Illuminate\Support\Facades\Auth::id(), Auth::user()->Role);
                    $extranote = Auth::user()->extranote;
                    $MyJson = new JsonWorks();
                    $extranoteArr = $MyJson->GetJsonInArray($extranote);
                    if (Auth::user()->Role < myappenv::role_SuperAdmin) {
                        Session::put('target', Auth::id());
                    }
                    $Myfin = new Financial();
                    if (myappenv::Lic['hozorgheyab']) {
                        $entrance = entrance_personel::where('UserName', Auth::id())->where('WorkingDate', date("Y-m-d"))->where('exittime', null)->first();
                        if ($entrance == null) {
                            Session::put('Entrance', false);
                        } else {
                            Session::put('Entrance', true);
                        }
                    }
                    Session::put('UserCredit', $Myfin->UserHasCredite($request->input('UserName'), myappenv::CachCredit));
                    if (Auth::user()->branch != null) {
                        $branch = branches::where('id', Auth::user()->branch)->first();
                        if ($branch != null and $branch->avatar != null) {
                            Session::put('BrandLogo', $branch->avatar);
                        } else {
                            Session::put('BrandLogo', url('/') . \App\myappenv::ShafatelIcon);
                        }
                    } else {
                        Session::put('BrandLogo', url('/') . \App\myappenv::ShafatelIcon);
                    }

                    if (isset($extranoteArr['pic'])) {
                        Session::put('UserPic', $extranoteArr['pic']);
                    } else {
                        Session::put('UserPic', url('/') . myappenv::LoginUserAvatarPic);
                    }
                    if ($request->input('TargetUrl') == Route('login')) {

                        return redirect()->route('home');
                    } else {
                        return Redirect::to($request->input('TargetUrl'));
                    }
                } else {
                    $targetuser = UserInfo::where('UserName', $request->input('UserName'))->first();
                    if ($targetuser != null) {
                        $UserPass = $request->input('UserPass');
                        if (myappenv::ComplexPass) {
                            if (!$this->CheckPassComplex($UserPass)) {
                                return redirect()->back()->with('error', 'پسورد وارد شده پیچیده نیست!');
                            }
                        }
                        if ($targetuser->UserPass == $request->input('UserPass')) {
                            $UpdateData = [
                                'password' => Hash::make($request->input('UserPass'))
                            ];
                            UserInfo::where('UserName', $request->input('UserName'))->update($UpdateData);
                            return $this->DoLogin($request);
                        } else {
                            return redirect()->back()->with('error', __("The username or password was incorrect"));
                        }
                    } else {
                        return redirect()->back()->with('error', __("The username or password was incorrect")); //todo handel error
                    }
                }
            }
        } else {
            return redirect()->back()->with('error', 'کد امنیتی درست وارد نشده است!');
        }
    }
}

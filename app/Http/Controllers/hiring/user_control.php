<?php

namespace App\Http\Controllers\hiring;

use App\APIS\SmsCenter;
use App\Functions\TextClassMain;
use App\hiring\hiring_workers;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\Controller;
use App\Models\provinces;
use App\myappenv;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class user_control extends Controller
{
    public function pb_register()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }
        $province = provinces::all();
        return view('Layouts.Theme7.pb_register', ['province' => $province, 'step' => 1]);

    }
    private function send_opt()
    {
        $my_text = new TextClassMain;
        $MyPassWoordRaw = Session::get('MyPassWoord');
        $SMSText = $my_text->ResetPassword(Session::get('MyPassWoord'));
        if (env('APP_NAME') == 'local') {
            echo '<h4 style="
            position: absolute;
            display: table-column;
            z-index: 90;
            text-align: left;
        "> PassWord:' . $MyPassWoordRaw . '</h4>';
        } else {
            $MySMS = new SmsCenter();
            $MySMS->OndemandSMS($SMSText, Session::get('MobileNo'), 'otp', Session::get('MobileNo'), $MyPassWoordRaw);
        }
    }
    public function Dopb_register(Request $request)
    {
        $my_text = new TextClassMain;
        if ($request->has('Name')) {
            $worker_class = new hiring_workers;
            $is_active_before = $worker_class->is_worker_exist_before($my_text->persian_number_to_en($request->mobile_no));
            if ($is_active_before['result'] && $is_active_before['type'] == 2) { // the user exist
                return view('Layouts.Theme7.pb_register', ['province' => null, 'step' => 3]);
            }


            $MyPassWoord = rand(myappenv::minpass, myappenv::maxpass);
            Session::put('MyPassWoord', $MyPassWoord);
            Session::put('Name', $my_text->StripText($request->Name));
            Session::put('Family', $my_text->StripText($request->Family));
            Session::put('sex', $request->sex);
            Session::put('expertin', $request->expertin);
            Session::put('MobileNo', $my_text->persian_number_to_en($request->mobile_no));
            Session::put('melli_id', $my_text->persian_number_to_en($request->melli_id));
            Session::put('Province', $request->Province);
            Session::put('Saharestan', $request->Saharestan);
            Session::put('email', $my_text->StripText($request->email));
            Session::put('education', $request->education);
            Session::save();
            $this->send_opt();
            $province = provinces::all();

            return view('Layouts.Theme7.pb_register', ['province' => $province, 'step' => 2]);


        }
        if ($request->has('submit')) {
            if ($request->submit == 'resend') {
                $usercontroller = new UserController;
                $bombing = $usercontroller->is_sms_bombing();
                if ($bombing) {
                    return redirect()->back()->with('error', 'شما بیشتر از حد مجاز درخواست ارسال کد نموده اید.');
                }
                $this->send_opt();
                return view('Layouts.Theme7.pb_register', ['province' => null, 'step' => 2])->with('success', 'کد یکبار مصرف مجددا ارسال شد.');
            }
            if ($request->submit == 'login') {
                $my_text = new TextClassMain;
                $password = $my_text->persian_number_to_en($request->Password);
                if ($password != Session::get('MyPassWoord')) {
                    return view('Layouts.Theme7.pb_register', ['province' => null, 'step' => 2])->with('error', 'کد ارسال شده صحیح نیست!');
                }
                $worker_class = new hiring_workers;
                $create_user = $worker_class->create_worker_form_session();
                if ($create_user['result']) { //user add or updated
                    $usercontroller = new UserController;
                    $usercontroller->login_with_onetime_pass($create_user['username'], Session::get('MyPassWoord'));
                    $worker_class->forget_sessions();
                    return redirect()->route('UserProfile')->with('success','اکانت کاربری شما ایجاد شد.');
                }
            }
        }
        dd($request->input());
    }
}

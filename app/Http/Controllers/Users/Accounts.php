<?php

namespace App\Http\Controllers\Users;

use App\Functions\TavanPardakhtClass;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\setting\SettingManagement;
use App\Functions\cashierClass;
use App\Functions\persian;
use App\Models\BankAccount;
use App\Models\locations;
use App\Models\product_order;
use App\Models\TicketMain;
use App\Models\ticket_recivers;
use App\Models\UserInfo;
use App\Models\UserPoint;
use App\myappenv;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;

class Accounts extends Controller
{
    public function get_user_bank_accounts($UserName){
        $Banks = BankAccount::where('UserName', $UserName)->get();
        return $Banks;
    }
    public function MyAccount()
    {
        if(Auth::user()->role != myappenv::role_customer){
            return redirect()->route('UserProfile');
        }

        $ticket_recivers = ticket_recivers::all();
        $UserName = Auth::id();
        $Tickets = TicketMain::where('FromUser', $UserName)->orwhere('UserName', $UserName)->get();
        $UserPoint = UserPoint::where('UserName', Auth::id())->where('ConfirmUser', '!=', null)->sum('Point');
        $TotallPoint = SettingManagement::GetSettingValue('point_to_copoun');
        if (isset($TotallPoint) || $TotallPoint != null) {
            $PointPercent = $UserPoint * 100 / $TotallPoint;
        } else {
            $PointPercent = 0;
        }

        $Locations = locations::all()->where('Owner', Auth::id())->where('Status', 1);
        $Orders = product_order::all()->where('CustomerId', Auth::id())->where('status', '>', 0);
        $Banks = BankAccount::where('UserName', Auth::id())->get();

        $cashier = new cashierClass();
        if (myappenv::SiteTheme == 'Theme1') {
            return view('Layouts.Theme1.MyAccount', ['cashier' => $cashier, 'Banks' => $Banks, 'Tickets' => $Tickets, 'ticket_recivers' => $ticket_recivers, 'PointPercent' => $PointPercent, 'page' => 'Accounts', 'Orders' => $Orders, 'Locations' => $Locations]);
        } else {
            return view('Users.MyAccountPWA', ['Banks' => $Banks, 'Tickets' => $Tickets, 'ticket_recivers' => $ticket_recivers, 'PointPercent' => $PointPercent, 'page' => 'Accounts', 'Orders' => $Orders, 'Locations' => $Locations]);
        }
    }
    public function DoMyAccount(Request $request)
    {
        if ($request->has('submit')) {
            if ($request->input('submit') == 'UpdateMellidCode') {
                $request->validate([
                    'mellicode' => 'digits:10',
                ], [
                    'mellicode.digits' => 'طول کد ملی ۱۰ کاراکتر می باشد!',
                ]);
                UserInfo::where('UserName', Auth::id())->update(['MelliID' => $request->input('mellicode')]);
                return redirect()->back()->with('success', 'کد ملی شما با موفقیت به روز رسانی شد!');
            } elseif ($request->input('submit') == 'tavnpardakht') {
                $confirmcode = $request->input('confirmcode');
                $SedCode = Session::get('tavanpardakht');
                $person = session::put('person');
                if ($SedCode == $confirmcode) {
                    info($SedCode);
                    $TargetMelliID = Auth::user()->MelliID;
                    $TargetMobileNumber = Auth::user()->MobileNo;
                    $UserAttr = [
                        'TargetMelliID' => $TargetMelliID,
                        'TargetMobileNumber' => $TargetMobileNumber,
                    ];
                    /* $UsersSrc = UserInfo::where('MelliID', $TargetMelliID)->get();
                    if ($UsersSrc != null) {
                        return redirect()->back()->with('error', 'کدملی وارد شده مشکل دارد لطفا با پشتیبانی کوکباز داخلی 106 تماس فرمایید');
                    }
                    else{
                        return true;
                    } */
                    $Mytavan = new TavanPardakhtClass;
                    $returnValue = $Mytavan->tavanpardakhtAdminfn($UserAttr);
                    if ($returnValue["result"] == 0) {
                        $mobile_number = $returnValue["mobile_number"];
                        $hidden_number = substr_replace($mobile_number, '****', 3, 4);
                        return redirect()->back()->with('error', "شماره موبایل ثبت شده در مرکز با شماره موبایل ثبت نامی تطابق ندارد! <br> $hidden_number");
                    } elseif ($returnValue["result"] == 1) {
                        return redirect()->back()->with('error', 'کدملی شناسایی نشد');
                    } elseif ($returnValue["result"] == true) {
                        return redirect()->back()->with('success', 'تبریک ،شما کاربر ویژه شدید!');
                    }
                } else {
                    return redirect()->back()->with('error', 'کد اعتبار سنجی اشتباه وارد شده است!');
                }
            } elseif ($request->input('submit') == 'Updatecardnumber') {
                $shabanumber = $request->input('shaba');
                $cardnumber = $request->input('cardnumber');
                $bankname = $request->input('bankname');
                $SaveData = [
                    'UserName' => Auth::id(),
                    'CardNo' => strip_tags($cardnumber),
                    'Account' => strip_tags($shabanumber),
                    '‌BankName' => strip_tags($bankname),
                    'Status' => 1,
                ];
                BankAccount::create($SaveData);
                return redirect()->back()->with('success', 'شماره شبا با موفقیت اضافه گردید!');
            } elseif ($request->input('submit') == 'updateUserInfo') {
                if ($request->input('new_password') != null) {
                    if (myappenv::MainOwner == 'kookbaz') {
                        $request->validate([
                            'MelliID' => 'digits:10',
                            'MobileNo' => 'digits:11',
                            'Name' => 'min:2',
                            'Family' => 'min:2',
                            'new_password' => 'min:8',
                        ], [
                            'MelliID.digits' => 'طول کد ملی ۱۰ کاراکتر می باشد!',
                            'MobileNo.digits' => 'شماره موبایل اشتباه وارد شده است!',
                            'Name.min' => 'نام باید حداقل از ۳ کارکتر باشد',
                            'Family.min' => 'نام خانوادگی باید حداقل از ۳ کارکتر باشد',
                            'new_password.min' => 'طول رمز عبور حد اقل ۸ کارکتر می باید تعیین شود!',
                        ]);
                    } else {
                        $request->validate([
                            'MelliID' => 'digits:10',
                            'MobileNo' => 'digits:11',
                            'Name' => 'min:2',
                            'Family' => 'min:2',
                            'new_password' => 'min:6',
                        ], [
                            'MelliID.digits' => 'طول کد ملی ۱۰ کاراکتر می باشد!',
                            'MobileNo.digits' => 'شماره موبایل اشتباه وارد شده است!',
                            'Name.min' => 'نام باید حداقل از ۳ کارکتر باشد',
                            'Family.min' => 'نام خانوادگی باید حداقل از ۳ کارکتر باشد',
                            'new_password.min' => 'طول رمز عبور حد اقل ۶ کارکتر می باید تعیین شود!',
                        ]);
                    }
                    $MyUserC = new UserController();
                    $UserPass = $request->input('new_password');
                    if (myappenv::ComplexPass) {
                        if (!$MyUserC->CheckPassComplex($UserPass)) {
                            return redirect()->back()->with('error', 'پسورد وارد شده پیچیده نیست!');
                        }
                    }
                    if ($request->has('MelliID')) {
                        $MelliID = strip_tags($request->input('MelliID'));
                    } elseif ($request->has('DisabledMelliID')) {
                        $MelliID = Auth::user()->MelliID;
                    }
                    $Mydate = new persian();
                    $Birthday = $Mydate->MiladiDate($request->input("Birthday"));
                    $UpdateData = [
                        'Name' => strip_tags($request->input('Name')),
                        'Family' => strip_tags($request->input('Family')),
                        'Birthday' => $Birthday,
                        'MarketingCode' => strip_tags($request->input('MarketingCode')),
                        'Marketer' => strip_tags($request->input('MarketingCode')),
                        'MobileNo' => strip_tags($request->input('MobileNo')),
                        'MelliID' => $MelliID,
                        'extranote' => strip_tags($request->input('extranote')),
                        'fathername' => strip_tags($request->input('fathername')),
                        'ShSh' => strip_tags($request->input('ShSh')),
                        'password' => strip_tags(Hash::make($request->input('new_password'))),

                    ];
                } else {
                    $request->validate([
                        'MelliID' => 'digits:10',
                        'MobileNo' => 'digits:11',
                        'Name' => 'min:2',
                        'Family' => 'min:2',
                    ], [
                        'MelliID.digits' => 'طول کد ملی ۱۰ کاراکتر می باشد!',
                        'MobileNo.digits' => 'شماره موبایل اشتباه وارد شده است!',
                        'Name.min' => 'نام باید حداقل از ۳ کارکتر باشد',
                        'Family.min' => 'نام خانوادگی باید حداقل از ۳ کارکتر باشد',
                    ]);
                    if ($request->has('MelliID')) {
                        $MelliID = strip_tags($request->input('MelliID'));
                    } elseif ($request->input('DisabledMelliID') == null) {
                        $MelliID = Auth::user()->MelliID;
                    }
                    if ($request->has('MobileNo')) {
                        $MobileNo = strip_tags($request->input('MobileNo'));
                    } elseif ($request->input('DisabledMobileNo') == null) {
                        $MobileNo = Auth::user()->MobileNo;
                    }

                    $Mydate = new persian();
                    $Birthday = $Mydate->MiladiDate($request->input("Birthday"));
                    $UpdateData = [
                        'Name' => strip_tags($request->input('Name')),
                        'Family' => strip_tags($request->input('Family')),
                        'Birthday' => $Birthday,
                        'MarketingCode' => strip_tags($request->input('MarketingCode')),
                        'Marketer' => strip_tags($request->input('MarketingCode')),
                        'MobileNo' => $MobileNo,
                        'MelliID' => $MelliID,
                        'extranote' => strip_tags($request->input('extranote')),
                        'fathername' => strip_tags($request->input('fathername')),
                        'ShSh' => strip_tags($request->input('ShSh')),

                    ];
                }


                UserInfo::where('UserName', Auth::id())->update($UpdateData);
                return back()->with('success', 'اطلاعات کاربری ویرایش شد!');
            } elseif ($request->input('submit') == 'add') {
                $request->validate([
                    'TicketText' => 'required',
                    'TickeReciver' => 'required',
                ], [
                    'TicketText.required' => 'مشخص سازی نقش گیرنده الزامی است!',
                    'TickeReciver.required' => 'مشخص سازی نام کاربری گیرنده الزامی است!',
                ]);
                $MyUser = new UserClass();
                if ($MyUser->IsUserExist($request->input('TickeReciver'))) {
                    $ticketReciverData = [
                        'TicketText' => $request->input('TicketText'),
                        'TickeReciver' => $request->input('TickeReciver'),

                    ];
                    ticket_recivers::create($ticketReciverData);
                    return 'man injam';
                    return back()->with('success', 'پیام با موفقیت ارسال گردید');
                } else {
                    return redirect()->back()->with('error', __("The username is not exist!"));
                }
            }
        }
        if ($request->input('new_password') != null) {
            $MyUserC = new UserController();
            $UserPass = $request->input('new_password');
            if (myappenv::ComplexPass) {
                if (!$MyUserC->CheckPassComplex($UserPass)) {
                    return redirect()->back()->with('error', 'پسورد وارد شده پیچیده نیست!');
                }
            }

            $UserData = [
                'Name' => strip_tags($request->input('firstname')),
                'Family' => strip_tags($request->input('lastname')),
                'password' => strip_tags(Hash::make($request->input('new_password'))),
            ];
            UserInfo::where('UserName', Auth::id())->update($UserData);
            return redirect()->back()->with('sucecss', 'مشخصات به روز رسانی شد!');
        } else {
            $UserData = [
                'Name' => strip_tags($request->input('firstname')),
                'Family' => strip_tags($request->input('lastname')),
            ];
            UserInfo::where('UserName', Auth::id())->update($UserData);
            return redirect()->back()->with('sucecss', 'مشخصات به روز رسانی شد!');
        }
    }
}

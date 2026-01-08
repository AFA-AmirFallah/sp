<?php

namespace App\Affiliate;

use App\APIS\SmsCenter;
use App\Functions\TextClassMain;
use App\Http\Controllers\APIS\VOIP;
use App\Models\UserInfo;
use App\myappenv;
use App\Users\UserClass;
use Ramsey\Uuid\Type\Integer;
use Illuminate\Support\Facades\DB;
use Session;


class affiliate_user
{
    public static function get_user_assign_coustomers($username)
    {
        $query = "SELECT ui.UserName,ui.Name ,ui.Family ,ui.MobileNo ,ui.extranote ,ui.CreateDate ,ur.RoleName,us.Name as status_name ,COUNT(po.id) as orders from UserInfo ui inner join UserRole ur on ui.Role = ur.Role INNER JOIN  UserStatus us on us.Status = ui.Status left JOIN  product_orders po  on po.CustomerId = ui.UserName and po.status  >= 90 WHERE ui.Marketer = '$username' GROUP BY ui.UserName ,ui.Name ,ui.Family ,ui.MobileNo ,ui.extranote ,ui.CreateDate ,ur.RoleName, us.Name ";
        $query_result = DB::select($query);
        return $query_result;
    }
    public static function who_is_introduced(string $target_user)
    {
        $Target_user_src = UserInfo::where('UserName', $target_user)->first();
        if ($Target_user_src == null) {
            return [
                'result' => false,
                'msg' => 'کاربر در سیتسم وجود ندارد!'
            ];
        }
        if ($Target_user_src->MarketingCode == null) {
            return [
                'result' => false,
                'msg' => 'کاربر معرف ندارد!'
            ];
        }
        $Target_user_src = UserInfo::where('UserName', $Target_user_src->MarketingCode)->first();
        if ($Target_user_src == null) {
            return [
                'result' => false,
                'msg' => 'معرف کاربر در سیستم وجود ندارد!'
            ];
        }
        return [
            'result' => true,
            'data' => $Target_user_src
        ];
    }
    public static function get_user_list_with_affiliates(string $target_user)
    {
        $Target_user_src = UserInfo::where('MarketingCode', $target_user)->get();
        return [
            'result' => true,
            'data' => $Target_user_src
        ];
    }
    public function get_to_pay_user_credit($UserName)
    {
        $query = "SELECT RelatedStaff.id as id, UserCredit.Mony,UserCredit.Date,UserCredit.ConfirmBy,RespnsType.RespnsTypeName ,branches.Name 
        FROM UserCredit INNER JOIN  RelatedStaff on RelatedStaff.RelatedCredite = UserCredit.ReferenceId 
        INNER JOIN RespnsType on RelatedStaff.RespnsType = RespnsType.id 
        INNER JOIN branches on RelatedStaff.branch = branches.id  
        WHERE UserCredit.ZeroRefrenceID is null and UserCredit.CreditMod = 1 and UserCredit.ConfirmBy is not null 
        and  UserCredit.UserName = 'v9dozgaqbl2i8zs7'";
        $result = DB::select($query);
        return $result;
    }


    public function get_who_many_clint_under_user_cat($main_user, $start_day, $end_day = null)
    {
        $user_count = UserInfo::where('MarketingCode', $main_user)->count();
        $result = [
            'result' => true,
            'data' => $user_count
        ];
        return $result;
    }
    public function get_who_many_request_under_user_cat($main_user, $start_day, $end_day = null)
    {
        $query = "SELECT count(*) as count FROM addorder1 INNER JOIN UserInfo on addorder1.BimarUserName = UserInfo.UserName ";
        $request_src = DB::select($query);
        $reauest_count = $request_src[0]->count;
        $result = [
            'result' => true,
            'data' => $reauest_count
        ];
        return $result;
    }
    public function get_who_many_service_under_user_cat($main_user, $start_day, $end_day = null)
    {
        $query = "SELECT count(*) as count FROM RelatedStaff INNER JOIN UserInfo on RelatedStaff.OwnerUserID = UserInfo.UserName and UserInfo.MarketingCode = '1222'";
        $request_src = DB::select($query);
        $reauest_count = $request_src[0]->count;
        $result = [
            'result' => true,
            'data' => $reauest_count
        ];
        return $result;
    }

    public function user_input_with_marketing_code(Integer $code)
    {
    }

    public function MarketingCodeEntered($code)
    {
        $MarketerSrc = UserInfo::where('EXT', $code)->first();
        if ($MarketerSrc == null) {
            return false;
        }
        Session::put('Marketer', $MarketerSrc->UserName);
        return true;
    }
    private function is_mobile_number_register_before($MobileNo)
    {
        $user_src = UserInfo::where('Role', myappenv::role_customer)->where('MobileNo', $MobileNo)->first();
        if ($user_src == null) {
            return false;
        }
        return true;
    }
    private function marketing_alert($MobileNo, $marketer_name, $creator)
    {
        $msg = "یمارستان مجازی 
کاربر گرامی شما توسط آقای/خانم : $marketer_name جهت ثبت نام در بیمارستان مجازی دعوت شده اید. برای مشاهده دعوتنامه و ثبت نام از طریق لینک ثبت نام اقدام نمایید. در صورت بروز اختلال در زمان ثبت نام از طریق لینک مشاوره با مشاور اختصاصی خود در تماس باشید . در صورت عدم پاسخگویی مشاور با شماره  1508  و بخش پشتیبانی و سپس داخلی 2 تماس بگیرید.
لینک ثبت نام : https://novin.hospital
لینک مشاوره : https://novin.hospital/Consultation/996";

        $Mysms = new SmsCenter();
        $Mysms->OndemandSMS($msg, $MobileNo, 'SystemUA', $creator);
        return true;
    }

    public function add_customer(array $customer_info)
    {
        $my_text = new TextClassMain;
        $my_voip = new VOIP;
        $Name = $my_text->StripText($customer_info['Name']);
        $Family = $my_text->StripText($customer_info['Family']);
        $MobileNo = $my_text->StripText($customer_info['MobileNo']);
        $MobileNo = $my_text->persian_number_to_en($MobileNo);
        $mobile_validation = $my_voip->NumberFormater($MobileNo);
        if ($mobile_validation['inputType'] != 'currect') {
            return [
                'result' => false,
                'msg' => 'فرمت شماره موبایل وارده شده اشتباه است. ' . $MobileNo
            ];
        }
        if ($this->is_mobile_number_register_before($MobileNo)) {
            return [
                'result' => false,
                'msg' => 'شماره وارد شده قبلا در سیستم ثبت شده است!'
            ];
        }
        $LastExt = DB::table('UserInfo')->latest('Ext')->first();
        $Ext = $LastExt->Ext;
        $extranote = $my_text->StripText($customer_info['customer_type']);
        $NewUserData = [
            'UserName' => UserClass::get_free_username(),
            'Email' => "",
            'password' => '',
            'UserPass' => '',
            'Name' => $Name,
            'Ext' => $Ext + 1,
            'Family' => $Family,
            'MobileNo' => $MobileNo,
            'Role' => myappenv::role_customer,
            'Sex' => $customer_info['Sex'],
            'Status' => myappenv::User_active_status,
            'MarketingCode' => $customer_info['create_user'],
            'Marketer' => $customer_info['create_user'],
            'city' => $customer_info['Saharestan'],
            'extranote' => $extranote,
            'province' => $customer_info['Province'],
            'branch' => myappenv::Branch
        ];
        $add_user_data = UserInfo::create($NewUserData);
        $this->marketing_alert($MobileNo, $customer_info['marketer'], $customer_info['create_user']);
        return [
            'result' => true
        ];

    }
    public function get_marketer()
    {
        if (Session::has('Marketer')) {
            return session::get('Marketer');
        } else {
            return null;
        }
    }
}

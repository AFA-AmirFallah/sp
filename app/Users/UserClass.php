<?php


namespace App\Users;
use App\APIS\SmsCenter;
use App\Models\UserInfo;
use App\myappenv;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Functions\MarketingClass;
use App\Functions\TextClassMain;
use App\Models\education;
use Illuminate\Support\Facades\DB;


class UserClass
{
    /**
     * AddExtraData function
     * This function use for add extradata to UserInfo Table
     *
     *
     * @param [type] $UserName
     * @param [stdClass] $extradata
     *
     * @return true
     */
    private $send_sms = false;
    private $sms_text = null;

    public function who_is_login(){
        $UserLogin = 'false';

        if (Auth::check()) {
            $UserLogin = 'user';
            $AdminLogin = false;
            if (Auth::user()->Role >= myappenv::role_admin) {
                $UserLogin = 'admin';
                $AdminLogin = true;
            }
        } else {
            Session::put('intended_url', \request()->url());
            $UserLogin = null;
            $AdminLogin = false;
        }
        return [
            'UserLogin'=>$UserLogin,
            'AdminLogin'=>$AdminLogin
        ];
    }

    private function get_worker_documents()
    {
        //note should start form 3 *****
        $item_1 = [
            'id' => 3,
            'name' => 'کارت ملی',
            'default_img' => 'https://parastarbank.com/storage/photos/main/document-file-database-secure-png.webp',
            'doc_img' => null,
            'status' => 0,
            'note' => null,
            'confirm_date' => null,
            'confirm_by' => null
        ];
        $item_2 = [
            'id' => 4,
            'name' => 'صفحه اول شناسنامه',
            'default_img' => 'https://parastarbank.com/storage/photos/main/document-file-database-secure-png.webp',
            'doc_img' => null,
            'status' => 0,
            'note' => null,
            'confirm_date' => null,
            'confirm_by' => null
        ];
        $item_3 = [
            'id' => 5,
            'name' => 'صفحه دوم شناسنامه',
            'default_img' => 'https://parastarbank.com/storage/photos/main/document-file-database-secure-png.webp',
            'doc_img' => null,
            'status' => 0,
            'note' => null,
            'confirm_date' => null,
            'confirm_by' => null
        ];
        $item_4 = [
            'id' => 6,
            'name' => 'آخرین مدرک تحصیلی',
            'default_img' => 'https://parastarbank.com/storage/photos/main/document-file-database-secure-png.webp',
            'doc_img' => null,
            'status' => 0,
            'note' => null,
            'confirm_date' => null,
            'confirm_by' => null
        ];
        $item_5 = [
            'id' => 7,
            'name' => 'کارت پایان خدمت',
            'default_img' => 'https://parastarbank.com/storage/photos/main/document-file-database-secure-png.webp',
            'doc_img' => null,
            'status' => 0,
            'note' => null,
            'confirm_date' => null,
            'confirm_by' => null
        ];
        $item_6 = [
            'id' => 8,
            'name' => 'مدرک پایان طرح',
            'default_img' => 'https://parastarbank.com/storage/photos/main/document-file-database-secure-png.webp',
            'doc_img' => null,
            'status' => 0,
            'note' => null,
            'confirm_date' => null,
            'confirm_by' => null
        ];
        return [
            $item_1,
            $item_2,
            $item_3,
            $item_4,
            $item_5,
            $item_6
        ];
    }
    public function get_role_documentation($role)
    {
        if ($role == myappenv::role_worker) {
            return $this->get_worker_documents();
        }
        return null;
    }



    public function send_sms_after_job($sms_text, $send_sms)
    {
        $this->send_sms = $send_sms;
        $this->sms_text = $sms_text;
    }

    public function AddExtraData($UserName, $extradata)
    {

        $MyUser = UserInfo::where('UserName', $UserName)->First();
        if ($MyUser == null) {
            return false;
        }
        $extraSRCdata = $MyUser->extradata;
        $extraSRCdata = TextClassMain::JsonComposer($extraSRCdata, $extradata);
        $MyUser = UserInfo::where('UserName', $UserName)->update(['extradata' => $extraSRCdata]);
        return true;
    }

    private function InitUserInfo($UserName)
    {
    }

    public function RefreshUserInfo($UserName)
    {
        $TargetUser = UserInfo::where('UserName', $UserName)->first();
        if ($TargetUser->extranote == null || $TargetUser->extranote == '') {
        } else {
            $DataArray = json_decode($TargetUser->extranote);
        }
    }

    public function UserInformation()
    {
        return Auth::user()->Name;
    }

    public function GetRandomPassword($Lengh)
    {
        $Min = pow(10, $Lengh);
        $max = pow(10, $Lengh + 1);
        $max--;
        $MyPassWoord = rand($Min, $max);
        return $MyPassWoord;
    }

    public function GetNewExtension()
    {
        $MaxId = UserInfo::max('Ext');
        if ($MaxId == null) {
            $MaxId = 100000;
        } else {
            $MaxId++;
        }
        return $MaxId;
    }
    private function get_marketer()
    {
    }
    public function add_user_form_calls($Name, $Family, $MobileNo, $sex)
    {
        $Role = myappenv::role_customer;
        $LastExt = DB::table('UserInfo')->latest('Ext')->first();
        $Ext = $LastExt->Ext;
        $mytest = new TextClassMain;
        $UserName = $mytest->StrRandom();
        $UserData = [
            'UserName' => $UserName,
            'UserPass' => $MobileNo,
            'password' => Hash::make($MobileNo),
            'Sex' => $sex,
            'Name' => $Name,
            'Family' => $Family,
            'MobileNo' => $MobileNo,
            'Email' => $MobileNo,
            'CreateDate' => now(),
            'Role' => $Role,
            'Status' => 101,
            'Ext' => $Ext + 1,
            'branch' => myappenv::Branch
        ];
        UserInfo::create($UserData);
        return $UserName;
    }
    public function add_worker_from_comments($Name, $MobileNo, $creator)
    {
        $Role = myappenv::role_worker;
        $LastExt = DB::table('UserInfo')->latest('Ext')->first();
        $Ext = $LastExt->Ext;
        $mytest = new TextClassMain;
        $UserName = $mytest->StrRandom();
        $UserData = [
            'UserName' => $UserName,
            'UserPass' => $MobileNo,
            'password' => Hash::make($MobileNo),
            'Sex' => 'm',
            'Name' => '',
            'Family' => $Name,
            'MobileNo' => $MobileNo,
            'Email' => $MobileNo,
            'CreateDate' => now(),
            'Role' => $Role,
            'Status' => 1,
            'Ext' => $Ext + 1,
            'Marketer' => $creator,
            'branch' => myappenv::Branch
        ];
        UserInfo::create($UserData);
        return [
            'result' => true,
            'UserName' => $UserName,
            'Ext' => $Ext + 1
        ];

    }
    public function AddUserBase($UserName, $UserPass, $Name, $Family, $MobileNo, $Email, $Role = 0, $Status = 101, $Ext = null, $branch = myappenv::Branch)
    {
        if ($Role == 0) {
            $Role = myappenv::role_customer;
        }
        $user_src = UserInfo::where('MobileNo', $MobileNo)->where('Role', $Role)->first();
        if ($user_src != null) { //The user exist before
            return $user_src;
        }
        $Marker = new MarketingClass();
        $LastExt = DB::table('UserInfo')->latest('Ext')->first();
        $Ext = $LastExt->Ext;
        $mytest = new TextClassMain;
        $UserName = $mytest->StrRandom();
        $UserData = [
            'UserName' => $UserName,
            'UserPass' => $UserPass,
            'password' => Hash::make($UserPass),
            'Name' => $Name,
            'Family' => $Family,
            'MobileNo' => $MobileNo,
            'Phone1' => $MobileNo,
            'Email' => $Email,
            'CreateDate' => now(),
            'Role' => $Role,
            'Status' => $Status,
            'MarketingCode' => $Marker->get_marketer(),
            'Marketer' => $Marker->get_marketer(),
            'Ext' => $Ext + 1,
            'branch' => $branch
        ];
        $result = UserInfo::create($UserData);
        if ($this->send_sms) {
            $MySMS = new SmsCenter();

            $MySMS->OndemandSMS($this->sms_text, $MobileNo, 'add_user', $MobileNo);
        }
        return UserInfo::where('UserName', $UserName)->first();
    }
    public function add_worker_hiring_with_session()
    {
        $Role = myappenv::role_worker;
        $Marker = new MarketingClass();
        $LastExt = DB::table('UserInfo')->latest('Ext')->first();
        $Ext = $LastExt->Ext;
        $mytest = new TextClassMain;
        $UserName = $mytest->StrRandom();
        $UserData = [
            'UserName' => $UserName,
            'UserPass' => Session::get('MobileNo'),
            'password' => Hash::make(Session::get('melli_id')),
            'Sex' => Session::get('sex'),
            'Name' => Session::get('Name'),
            'Family' => Session::get('Family'),
            'MobileNo' => Session::get('MobileNo'),
            'Phone1' => Session::get('MobileNo'),
            'Email' => Session::get('email') ?? '',
            'Degree' => Session::get('education'),
            'province' => Session::get('Province'),
            'city' => Session::get('Saharestan'),
            'CreateDate' => now(),
            'NationalCode' => Session::get('melli_id'),
            'MelliID' => Session::get('melli_id'),
            'expert'=>Session::get('expertin'),
            'Role' => $Role,
            'Status' => 1,
            'Ext' => $Ext + 1,
            'MarketingCode' => $Marker->get_marketer(),
            'Marketer' => $Marker->get_marketer(),
            'branch' => myappenv::Branch
        ];
        $result = UserInfo::create($UserData);

        if ($this->send_sms) {
            $MySMS = new SmsCenter();

            $MySMS->OndemandSMS($this->sms_text, Session::get('MobileNo'), 'add_user', Session::get('MobileNo'));
        }
        return $UserName;
    }
    public static function get_education_all()
    {
        return education::all();
    }
    public function AddUserwithmelliid($UserName, $UserPass, $Name, $Family, $MelliId, $MobileNo, $Email, $Role, $Status, $Ext = null, $branch = myappenv::Branch)
    {

        if ($Role == 0) {
            $Role = myappenv::role_customer;
        }
        $Marker = new MarketingClass();
        $LastExt = DB::table('UserInfo')->latest('Ext')->first();
        $Ext = $LastExt->Ext;
        $mytest = new TextClassMain;
        $UserName = $mytest->StrRandom();
        $UserData = [
            'UserName' => $UserName,
            'UserPass' => $UserPass,
            'password' => Hash::make($UserPass),
            'Name' => $Name,
            'Family' => $Family,
            'MobileNo' => $MobileNo,
            'Phone1' => $MobileNo,
            'Email' => $Email,
            'CreateDate' => now(),
            'NationalCode' => $MelliId,
            'MelliID' => $MelliId,
            'Role' => $Role,
            'Status' => $Status,
            'Ext' => $Ext + 1,
            'MarketingCode' => $Marker->get_marketer(),
            'Marketer' => $Marker->get_marketer(),
            'branch' => $branch
        ];
        $result = UserInfo::create($UserData);

        if ($this->send_sms) {
            $MySMS = new SmsCenter();

            $MySMS->OndemandSMS($this->sms_text, $MobileNo, 'add_user', $MobileNo);
        }
        return $UserName;
    }
    public static function get_user_by_username($UserName)
    {
        $result = UserInfo::where('UserName', $UserName)->first();
        return $result;
    }

    public static function get_free_username()
    {
        $mytest = new TextClassMain;
        $UserName = $mytest->StrRandom();
        $OldFeildSrc = UserInfo::where('UserName', $UserName)->first();
        while ($OldFeildSrc != null) {
            $UserName = $mytest->StrRandom();
            $OldFeildSrc = UserInfo::where('UserName', $UserName)->first();
        }
        return $UserName;
    }
    public function get_all_operator(){
        return UserInfo::where('Role','>=',myappenv::role_callcenter)->where('Status','>',100)->get();
    }

    public function IsUserExist($UserName)
    {
        $Result = UserInfo::where('UserName', $UserName)->first();
        if ($Result != null) {
            return true;
        } else {
            return false;
        }
    }
    public function IsUserExistAllItems($UserName)
    {
        $Result = UserInfo::where('UserName', $UserName)->orWhere('MobileNo', $UserName)->orWhere('Phone1', $UserName)->orWhere('Phone2', $UserName)->first();
        if ($Result != null) {
            return $Result->UserName;
        } else {
            return false;
        }
    }
}

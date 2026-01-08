<?php

namespace App\Http\Controllers\Users;

use App\APIS\SmsCenter;
use App\Exports\UsersExport;
use App\Functions\APIClass;
use App\Functions\Financial;
use App\Functions\Indexes;
use App\Functions\JsonWorks;
use App\Functions\persian;
use App\Functions\TextClassMain;
use App\hiring\hiring_main;
use App\Users\UserClass;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Credit\Reports;
use App\Models\BankAccount;
use App\Models\UserCredit;
use App\Models\UserInfo;
use App\Models\UserRole;
use App\Models\UserStatus;
use App\Models\WorkerSkils;
use App\Models\L3Work;
use App\myappenv;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Functions\CallCenterClass;
use Maatwebsite\Excel\Facades\Excel;
use Session;
use App\Functions\MarketingClass;
use App\Functions\ConsultClass;
use App\Http\Controllers\Credit\CreditTransfer;
use App\Models\branches;
use App\Models\product_order;
use App\Models\UserCreditIndex;
use App\Models\UserCreditModMeta;
use App\Shop\ProductMark;
use Illuminate\Support\Facades\Auth;
use stdClass;
use App\Functions\Orders;
use App\hiring\hiring_workers;
use Illuminate\Support\Facades\Log;

class UserManagement extends Controller
{
    public function BankList()
    {
        $Banks = UserInfo::where('Role', myappenv::role_Bank)->get();
        $BankArr = array();
        foreach ($Banks as $Bank) {
            $BankName = $Bank->Name . ' ' . $Bank->Family;
            $BankMony = UserCredit::where('UserName', $Bank->UserName)->where('Confirmdate', '!=', null)->where('CreditMod', myappenv::CachCredit)->sum('Mony');
            $ArrItem = [
                'avatar' => $Bank->avatar,
                'backcolor' => $Bank->Address,
                'BankName' => $BankName,
                'Mony' => $BankMony,
            ];
            array_push($BankArr, $ArrItem);
        }
        return view('Credit.banklist', ['BankArr' => $BankArr]);
    }
    public function DoBankList()
    {
        echo 'hi';
    }
    public function UserModifyMain()
    {
    }

    public function DoUserModifyMain()
    {
    }

    private function UserExist($UserName, $PhoneNumber, $UserEmail, $Role, $branch = null)
    {
        if ($branch == null) {
            $branch = myappenv::Branch;
        }
        $ResultUserName = UserInfo::all()->where('UserName', $UserName);
        if ($ResultUserName->count() == 0) {
            $ResultMobileNo = UserInfo::all()->where('MobileNo', $PhoneNumber)->where('branch', $branch);
            if ($ResultMobileNo->count() == 0) {
                $ResultEmail = UserInfo::all()->where('Email', $UserEmail)->where('branch', $branch);
                if ($ResultEmail->count() == 0) {
                    return 'Valid';
                } else {
                    return __('The Email has exist in database!');
                }
            } else {
                return __('The mobile number has exist in database!');
            }
        } else {
            return __('The user name has exist in database!');
        }
    }
    private function BankExist($UserName)
    {
        $ResultUserName = UserInfo::where('UserName', $UserName)->first();
        if ($ResultUserName == null) {
            return 'Valid';
        } else {
            return 'این بانک از قبل ثبت شده است!';
        }
    }

    public function BankCreate()
    {
        $ResultRole = UserRole::all()->where('Role', myappenv::role_Bank);
        return view("Users.CreateBank", ['ResultRole' => $ResultRole]);
    }

    public function DoBankCreate(Request $request)
    {
        if ($request->has("Registeruser")) {
            $UserValidate = $this->BankExist($request->input("ADDUserName"));
            if ($UserValidate != 'Valid') {
                return redirect()->back()->with('error', $UserValidate)->withInput($request->all());
            } else {
                $Marker = new MarketingClass();
                $LastExt = DB::table('UserInfo')->latest('Ext')->first();
                $Ext = $LastExt->Ext;
                $UserInfoData = [
                    'UserName' => UserClass::get_free_username(),
                    'password' => 'پسو',
                    'Name' => $request->input('ADDName'),
                    'Family' => $request->input('ADDFamily'),
                    'MobileNo' => '',
                    'Ext' => $Ext + 1,
                    'Email' => '',
                    'CreateDate' => now(),
                    'Sex' => '',
                    'Role' => myappenv::role_Bank,
                    'Status' => 1,
                    'MarketingCode' => $Marker->get_marketer(),
                    'Marketer' => $Marker->get_marketer(),
                    'branch' => Auth()->user()->branch,
                ];
                UserInfo::create($UserInfoData);
                return redirect()->back()->with("success", 'عملیات موفقیت آمیز');
            }
        }
    }
    public function CreateUser(Request $request)
    {
        if ($request->has('if')) {
            $layout = 'iframe';
        } else {
            $layout = null;
        }

        $ResultRole = UserRole::all()->where('Role', '<', Auth::user()->Role);
        return view("Users.CreateUser", ['layout' => $layout, 'ResultRole' => $ResultRole]);
    }
    private function create_user_without_username(Request $request)
    {
        if ($request->has("Registeruser")) {
            $request->validate([
                "ADDName" => ['required', 'max:50', 'min:3'],
                "ADDFamily" => ['required', 'max:80', 'min:3'],
                "ADDMobileNumber" => ['required', 'max:11', 'min:11'],
                "ADDPassword" => ['required', 'max:255', 'min:5'],
            ], [
                'ADDName.required' => __("fill feild ") . __('Name') . __(" is requird!"),
                'ADDFamily.required' => __("fill feild ") . __('Family') . __(" is requird!"),
                'ADDMobileNumber.required' => __("fill feild ") . __('Mobile No') . __(" is requird!"),
                'ADDPassword.required' => __("fill feild ") . __('Password') . __(" is requird!"),
                'ADDUserName.min' => __("The chars of feild ") . __('Username') . __(" Less than limet!"),
                'ADDName.min' => __("The chars of feild ") . __('Name') . __(" Less than limet!"),
                'ADDFamily.min' => __("The chars of feild ") . __('Family') . __(" Less than limet!"),
                'ADDMobileNumber.min' => __("The chars of feild ") . __('Mobile No') . __(" Less than limet!"),
                'ADDPassword.min' => __("The chars of feild ") . __('Password') . __(" Less than limet!"),
            ]);
            //"ADDRole" => "0"
            $Email = $request->input('ADDMobileNumber') . "@nomail.com";

            if ($request->has('ADDMailAddress')) {
                if ($request->input('ADDMailAddress') != null) {
                    $Email = $request->input('ADDMailAddress');
                }
            }
            $UserName = UserClass::get_free_username();
            $UserValidate = $this->UserExist($UserName, $request->input("ADDMobileNumber"), $Email, $request->input('ADDRole'), Auth()->user()->branch);
            if ($UserValidate != 'Valid') {
                return redirect()->back()->with('error', $UserValidate)->withInput($request->all());
            } else {
                $UserInfoData = [
                    'UserName' => $UserName,
                    'UserPass' => $request->input('ADDPassword'),
                    'password' => Hash::make($request->input('ADDPassword')),
                    'Name' => $request->input('ADDName'),
                    'Family' => $request->input('ADDFamily'),
                    'MobileNo' => $request->input('ADDMobileNumber'),
                    'Email' => $Email,
                    'CreateDate' => now(),
                    'Sex' => $request->input('Sex'),
                    'Role' => $request->input('ADDRole'),
                    'Status' => 1,
                    'MelliID' => $request->input('ADDMelliID'),
                    'branch' => Auth()->user()->branch,
                ];
                $ADDRole = $request->input('ADDRole');
                if ($ADDRole == 0) {
                    $ADDRole = myappenv::role_customer;
                } else {
                    $ADDRole = $request->input('ADDRole');
                }
                if ($ADDRole == myappenv::role_customer) {
                    $UserInfoData = [
                        'UserName' => $UserName,
                        'UserPass' => $request->input('ADDPassword'),
                        'password' => Hash::make($request->input('ADDPassword')),
                        'Name' => $request->input('ADDName'),
                        'Family' => $request->input('ADDFamily'),
                        'Sex' => $request->input('Sex'),
                        'MobileNo' => $request->input('ADDMobileNumber'),
                        'Email' => $Email,
                        'CreateDate' => now(),
                        'Role' => $ADDRole,
                        'Status' => myappenv::Default_customer_Status,
                        'MelliID' => $request->input('ADDMelliID'),
                        'branch' => Auth()->user()->branch,
                    ];
                } else {
                    $Marker = new MarketingClass();
                    $LastExt = DB::table('UserInfo')->latest('Ext')->first();
                    $Ext = $LastExt->Ext;
                    $UserInfoData = [
                        'UserName' => $UserName,
                        'UserPass' => $request->input('ADDPassword'),
                        'password' => Hash::make($request->input('ADDPassword')),
                        'Name' => $request->input('ADDName'),
                        'Sex' => $request->input('Sex'),
                        'Family' => $request->input('ADDFamily'),
                        'MobileNo' => $request->input('ADDMobileNumber'),
                        'Ext' => $Ext + 1,
                        'Email' => $Email,
                        'CreateDate' => now(),
                        'Role' => $ADDRole,
                        'MelliID' => $request->input('ADDMelliID'),
                        'Status' => myappenv::Default_Other_Role_Status,
                        'MarketingCode' => $Marker->get_marketer(),
                        'Marketer' => $Marker->get_marketer(),
                        'branch' => Auth()->user()->branch,
                    ];
                }
                UserInfo::create($UserInfoData);
                $myText = new TextClassMain();
                $MessageText = $myText->UserAddSMS($ADDRole, $UserName, $request->input('ADDPassword'), myappenv::CenterName, myappenv::CenterEndSmsTxt);
                $Mysms = new SmsCenter();
                $Mysms->OndemandSMS($MessageText, $UserName, 'SystemUA', $UserName);
                return redirect()->back()->with("success", __("The user add to system!"));
            }
        }
    }

    public function DoCreateUser(Request $request)
    {
        if (Auth::user()->Branch != myappenv::Branch) {

            return $this->create_user_without_username($request);
        }
        if ($request->has("Registeruser")) {
            $request->validate([
                "ADDUserName" => ['required', 'max:20', 'min:5'],
                "ADDName" => ['required', 'max:50', 'min:3'],
                "ADDFamily" => ['required', 'max:80', 'min:3'],
                "ADDMobileNumber" => ['required', 'max:11', 'min:11'],
                "ADDPassword" => ['required', 'max:255', 'min:5'],
            ], [
                'ADDUserName.required' => __("fill feild ") . __('Username') . __(" is requird!"),
                'ADDName.required' => __("fill feild ") . __('Name') . __(" is requird!"),
                'ADDFamily.required' => __("fill feild ") . __('Family') . __(" is requird!"),
                'ADDMobileNumber.required' => __("fill feild ") . __('Mobile No') . __(" is requird!"),
                'ADDPassword.required' => __("fill feild ") . __('Password') . __(" is requird!"),
                'ADDUserName.min' => __("The chars of feild ") . __('Username') . __(" Less than limet!"),
                'ADDName.min' => __("The chars of feild ") . __('Name') . __(" Less than limet!"),
                'ADDFamily.min' => __("The chars of feild ") . __('Family') . __(" Less than limet!"),
                'ADDMobileNumber.min' => __("The chars of feild ") . __('Mobile No') . __(" Less than limet!"),
                'ADDPassword.min' => __("The chars of feild ") . __('Password') . __(" Less than limet!"),
            ]);
            //"ADDRole" => "0"
            $Email = $request->input('ADDUserName') . "@nomail.com";

            if ($request->has('ADDMailAddress')) {
                if ($request->input('ADDMailAddress') != null) {
                    $Email = $request->input('ADDMailAddress');
                }
            }
            $UserValidate = $this->UserExist($request->input("ADDUserName"), $request->input("ADDMobileNumber"), $Email, $request->input('ADDRole'), Auth()->user()->branch);
            if ($UserValidate != 'Valid') {
                return redirect()->back()->with('error', $UserValidate)->withInput($request->all());
            } else {
                if ($request->has('branch') && $request->branch > 0) {
                    $input_branch = $request->branch;
                } else {
                    $input_branch = Auth()->user()->branch;
                }
                $UserInfoData = [
                    'UserName' => $request->input('ADDUserName'),
                    'UserPass' => $request->input('ADDPassword'),
                    'password' => Hash::make($request->input('ADDPassword')),
                    'Name' => $request->input('ADDName'),
                    'Family' => $request->input('ADDFamily'),
                    'MobileNo' => $request->input('ADDMobileNumber'),
                    'Email' => $Email,
                    'CreateDate' => now(),
                    'Sex' => $request->input('Sex'),
                    'Role' => $request->input('ADDRole'),
                    'Status' => 1,
                    'MelliID' => $request->input('ADDMelliID'),
                    'branch' => $input_branch,
                ];
                $ADDRole = $request->input('ADDRole');
                if ($ADDRole == 0) {
                    $ADDRole = myappenv::role_customer;
                } else {
                    $ADDRole = $request->input('ADDRole');
                }
                if ($ADDRole == myappenv::role_customer) {
                    if ($request->has('branch') && $request->branch > 0) {
                        $input_branch = $request->branch;
                    } else {
                        $input_branch = Auth()->user()->branch;
                    }
                    $UserInfoData = [
                        'UserName' => $request->input('ADDUserName'),
                        'UserPass' => $request->input('ADDPassword'),
                        'password' => Hash::make($request->input('ADDPassword')),
                        'Name' => $request->input('ADDName'),
                        'Family' => $request->input('ADDFamily'),
                        'Sex' => $request->input('Sex'),
                        'MobileNo' => $request->input('ADDMobileNumber'),
                        'Email' => $Email,
                        'CreateDate' => now(),
                        'Role' => $ADDRole,
                        'Status' => myappenv::Default_customer_Status,
                        'MelliID' => $request->input('ADDMelliID'),
                        'MarketingCode' => $Marker->get_marketer(),
                        'Marketer' => $Marker->get_marketer(),
                        'branch' => $input_branch,
                    ];
                } else {
                    $Marker = new MarketingClass();
                    $LastExt = DB::table('UserInfo')->latest('Ext')->first();
                    $Ext = $LastExt->Ext;
                    if ($request->has('branch') && $request->branch > 0) {
                        $input_branch = $request->branch;
                    } else {
                        $input_branch = Auth()->user()->branch;
                    }
                    $UserInfoData = [
                        'UserName' => UserClass::get_free_username(),
                        'UserPass' => $request->input('ADDPassword'),
                        'password' => Hash::make($request->input('ADDPassword')),
                        'Name' => $request->input('ADDName'),
                        'Sex' => $request->input('Sex'),
                        'Family' => $request->input('ADDFamily'),
                        'MobileNo' => $request->input('ADDMobileNumber'),
                        'Ext' => $Ext + 1,
                        'Email' => $Email,
                        'CreateDate' => now(),
                        'Role' => $ADDRole,
                        'MelliID' => $request->input('ADDMelliID'),
                        'Status' => myappenv::Default_Other_Role_Status,
                        'MarketingCode' => $Marker->get_marketer(),
                        'Marketer' => $Marker->get_marketer(),
                        'branch' => $input_branch,
                    ];
                }
                UserInfo::create($UserInfoData);
                $myText = new TextClassMain();
                $MessageText = $myText->UserAddSMS($ADDRole, $request->input('ADDMobileNumber'), $request->input('ADDPassword'), myappenv::CenterName, myappenv::CenterEndSmsTxt);
                $Mysms = new SmsCenter();
                $Mysms->OndemandSMS($MessageText, $request->input('ADDMobileNumber'), 'SystemUA', $request->input('ADDMobileNumber'));
                return redirect()->back()->with("success", __("The user add to system!"));
            }
        }
    }

    public function UserSearch($SearchPlan = null)
    {
        $hiring = new hiring_main;
        if ($SearchPlan == 'Shafatel') {
            if (myappenv::CoustomerType == 'Partner') {
                $Query = "SELECT UserInfoWithPrice.UserNameMain,UserInfoWithPrice.Name,UserInfoWithPrice.Family,UserInfoWithPrice.MobileNo,UserInfoWithPrice.Email,UserInfoWithPrice.Status ,UserInfoWithPrice.mony, UserInfoWithPrice.blocked ,UserInfoWithPrice.Sex , UserRole.RoleName , UserStatus.Name as UserStatusName , UserInfoWithPrice.CreateDate as CreateDate, UserInfoWithPrice.branch as branch FROM UserInfoWithPrice  INNER JOIN UserRole on UserInfoWithPrice.Role = UserRole.Role INNER JOIN UserStatus on UserInfoWithPrice.Status = UserStatus.Status  WHERE  branch = " . myappenv::shafatelunmanagedcustomers;
                $UserInfoResults = DB::select($Query);
                return view('Users.UserList', ['Users' => $UserInfoResults, 'hiring' => $hiring]);
            } else {
                return abort(404);
            }
        } elseif ($SearchPlan == null) {
            $UserRoles = UserRole::all()->where("Role", '<', Auth::user()->Role);
            $MyIndex = new Indexes();
            $IndexTree = $MyIndex->HTMLTreeIndex();
            return view('Users.UserSearch', ['UserRoles' => $UserRoles, 'IndexTree' => $IndexTree, 'hiring' => $hiring]);
        } else {
            return abort(404);
        }
    }

    public function DoUserSearch(Request $request)
    {
        if ($request->has('activate')) {
            $resume = new hiring_main;
            $resume->active_skill($request->activate);
            return redirect()->back()->with('success', 'فعال سازی شاخص انجام شد!');
        }
        if ($request->has('deactivate')) {
            $resume = new hiring_main;
            $resume->deactivate_skill($request->deactivate);
            return redirect()->back()->with('success', ' حذف شاخص انجام شد!');
        }
        if ($request->input('submit') == 'tmpsave') {
            $SelectedUser = $request->selected;
            Session::put('tempuserlist', $SelectedUser);
            return redirect()->back()->with('success', 'کاربران به صورت موفقت ذخیره شده اند لطفا باقی مراحل مد نظر را انجام دهید');
        }

        $UserRole = Auth::user()->Role;
        $DaramadUser = myappenv::StackHolder;
        $Branch = myappenv::Branch;
        $UserBranch = \Illuminate\Support\Facades\Auth::user()->branch;
        /**
         * Search by Name and family
         */

        if ($request->input('submit') == 'primary') {
            if ($UserBranch != $Branch) {
                $mybaranch = " and UserInfoWithPrice.branch = $UserBranch ";
            } else {
                $mybaranch = '';
            }
            if (\Illuminate\Support\Facades\Auth::user()->Role >= myappenv::role_Accounting) {
                $ShowDaramad = '';
            } else {
                $ShowDaramad = "and UserInfoWithPrice.UserNameMain !=  '$DaramadUser'";
            }
            //test
            $Query = "SELECT branches.Name as BranchName,UserInfoWithPrice.UserNameMain,UserInfoWithPrice.Name,UserInfoWithPrice.Family,UserInfoWithPrice.MobileNo,UserInfoWithPrice.Email,UserInfoWithPrice.Status ,UserInfoWithPrice.mony, UserInfoWithPrice.blocked ,UserInfoWithPrice.Sex , UserRole.RoleName , UserStatus.Name as UserStatusName, UserInfoWithPrice.CreateDate as CreateDate, UserInfoWithPrice.branch as branch FROM UserInfoWithPrice  INNER JOIN UserRole on UserInfoWithPrice.Role = UserRole.Role INNER JOIN UserStatus on UserInfoWithPrice.Status = UserStatus.Status INNER JOIN branches on branches.id = UserInfoWithPrice.branch  WHERE UserInfoWithPrice.Role < $UserRole  $ShowDaramad $mybaranch   ";
            if ($request->input('SUserName') != null) {
                $SUserName = $request->input('SUserName');
                $Query .= " and  CONCAT(UserInfoWithPrice.Name, UserInfoWithPrice.Family) like '%$SUserName%' ";
            }

            if ($request->input('FromPrice') != null) {
                $FromPrice = $request->input('FromPrice');
                $Query .= " and  UserInfoWithPrice.mony >= $FromPrice ";
            }
            if ($request->input('Branch') != null) {
                $Branch = $request->input('Branch');
                if ($Branch == 1000) {
                    $Query .= " and (UserInfoWithPrice.Branch = 1000 or UserInfoWithPrice.Branch = 1001)";
                } else {
                    //$Query .= " and  UserInfoWithPrice.Branch = $Branch ";
                    $Query .= " ";
                }
            }
            if ($request->input('ToPrice') != null) {
                $ToPrice = $request->input('ToPrice');
                $Query .= " and  UserInfoWithPrice.mony <=  $ToPrice ";
            }
            if ($request->input('SMobile') != null) {
                $SMobile = $request->input('SMobile');
                $Query .= " and  UserInfoWithPrice.MobileNo = '$SMobile'";
            }
            if ($request->input('sexselect') != null) {
                $sexselect = $request->input('sexselect');
                $Query .= " and  UserInfoWithPrice.Sex = '$sexselect'";
            }
            if ($request->input('Province') != 0) {
                $Province = $request->input('Province');
                $Query .= " and  UserInfoWithPrice.Province = $Province";
            }
            if ($request->input('city') != null && $request->input('city') != 0) {
                $city = $request->input('city');
                $Query .= " and  UserInfoWithPrice.city = $city ";
            }
            if ($request->input('optionsRadios') != null) {
                $Roleselect = $request->input('optionsRadios');
                if ($Roleselect == "-100") {
                    $Query .= ' and  UserInfoWithPrice.Role = ' . myappenv::role_customer . '  and UserInfoWithPrice.CreditePlan is not null';
                } else {
                    $Query .= " and  UserInfoWithPrice.Role = $Roleselect";
                }
            }
            $MyDate = new persian();
            if ($request->input('StartDate') != null) {
                $StartDate = $MyDate->MiladiDate($request->input('StartDate'));
                $Query .= " and  UserInfoWithPrice.CreateDate >= '$StartDate'";
            }

            if ($request->input('EndDate') != null) {
                $EndDate = $MyDate->MiladiDate($request->input('EndDate'));

                $Query .= " and  UserInfoWithPrice.CreateDate <= '$EndDate'";
            }
            if (Auth::user()->Role < myappenv::role_admin) {
                $Query .= " and UserInfoWithPrice.Status = 101";
            }
            $UserInfoResults = DB::select($Query);
        }
        /**
         * Search by user Indexes
         */

        if ($request->input('submit') == 'indexes') {
            if (\Illuminate\Support\Facades\Auth::user()->Role >= myappenv::role_Accounting) {
                $ShowDaramad = '';
            } else {
                $ShowDaramad = "and  UserInfoWithPrice.UserNameMain !=  '$DaramadUser' ";
            }

            $Query = "SELECT UserInfoWithPrice.UserNameMain,UserInfoWithPrice.Name,UserInfoWithPrice.Family,UserInfoWithPrice.MobileNo,UserInfoWithPrice.Email,UserInfoWithPrice.Status ,UserInfoWithPrice.mony, UserInfoWithPrice.blocked , WorkerSkils.UserName, WorkerSkils.SkilID ,L3Work.UID, L3Work.WorkCat, L3Work.L1ID, L3Work.L2ID, L3Work.L3ID, L3Work.Name,UserInfoWithPrice.Sex , UserRole.RoleName , UserStatus.Name , UserInfoWithPrice.CreateDate as CreateDate , UserInfoWithPrice.branch as branch FROM UserInfoWithPrice join L3Work join WorkerSkils INNER JOIN UserRole on UserInfoWithPrice.Role = UserRole.Role INNER JOIN UserStatus on UserInfoWithPrice.Status = UserStatus.Status INNER JOIN branches on branches.id = UserInfoWithPrice.branch WHERE L3Work.UID = WorkerSkils.SkilID and WorkerSkils.UserName = UserInfoWithPrice.UserNameMain $ShowDaramad and  UserInfoWithPrice.Role < $UserRole  ";
            $ConditionCount = 0;
            // Loop to store and display values of individual checked checkbox.
            $OrSearch = $request->input('OrSearch');
            $IndexSearch = 0;
            $Query .= " and (";
            $check_list = $request->input('check_list');
            if ($check_list == null) {
                return redirect()->back()->with('error', 'شاخصی برای جستجو وارد نشده است!');
            }
            foreach ($check_list as $selected) {
                $IndexSearch++;
                if ($ConditionCount > 0) {
                    $Query .= " or  L3Work.UID = $selected";
                } else {
                    $Query .= " L3Work.UID = $selected";
                }

                $ConditionCount++;
            }
            $Query .= " ) ";
            $UserInfoResults = DB::select($Query);
        }

        return view('Users.UserList', ['Users' => $UserInfoResults]);
    }

    public function UserProfile(Request $request, $RequestUser = null)
    {
        if ($request->ajax()) {
            if (myappenv::Lic['Voip']) {
                $BothSide = new ConsultClass();
                $BothSide->BothSideCall(Auth::user()->MobileNo, '09192228284');
                return 'درخواست تماس ثبت گردید!';
            } else {
                return 'لایسنس مورد نیاز این قابلیت برای شما وجود ندارد!';
            }
        }
        if ($request->has('if')) {
            $layout = 'iframe';
        } else {
            $layout = null;
        }

        if ($RequestUser == null || Auth::user()->Role < myappenv::role_admin) {
            $RequestUser = Auth::id();
        }
        if (in_array($RequestUser, myappenv::ForbidnUser)) {
            abort(403, __("Error code:") . ' 020101');
        } else {
            if ($RequestUser == Auth::id()) {
                $Query = "SELECT UserInfo.UserName,UserInfo.Degree,UserInfo.Ext,UserInfo.expert,UserInfo.city,UserInfo.province,UserInfo.Name as nameofuser,UserInfo.avatar as avatar,
                UserInfo.Family,UserInfo.MobileNo,UserInfo.fathername,UserInfo.Email,UserInfo.Phone1,UserInfo.Phone2,
                UserInfo.Address,UserInfo.Address2,UserInfo.Role,UserInfo.Birthday,UserInfo.CreateDate,UserInfo.extradata,
                UserStatus.Name as statusname,UserInfo.Status, UserInfo.UserPass,
                (SELECT COALESCE(sum(Point),0) as point FROM UserPoint WHERE UserName = '$RequestUser' and ConfirmUser is not null ) as point 
                ,UserInfo.Sex as Sex , UserRole.RoleName ,UserInfo.extranote,UserInfo.branch ,UserInfo.city,UserInfo.province, UserInfo.MelliID  FROM UserInfo inner join UserStatus on UserInfo.Status = UserStatus.Status INNER JOIN UserRole on UserInfo.Role = UserRole.Role where UserName = '$RequestUser'";
            } else {
                $UserRole = Auth::user()->Role;
                $Query = "SELECT UserInfo.UserName,UserInfo.Degree, UserInfo.Ext,UserInfo.Name as nameofuser,UserInfo.avatar as avatar ,UserInfo.city,UserInfo.province ,UserInfo.Family,UserInfo.MobileNo,UserInfo.fathername,UserInfo.Email,UserInfo.Phone1,UserInfo.Phone2,UserInfo.Address,UserInfo.Address2,UserInfo.Role,UserInfo.Birthday,UserInfo.CreateDate,UserInfo.extradata,UserStatus.Name as statusname,UserInfo.Status, UserInfo.UserPass,(SELECT COALESCE(sum(Point),0) as point FROM UserPoint WHERE UserName = '$RequestUser' and ConfirmUser is not null ) as point ,UserInfo.Sex as Sex , UserRole.RoleName ,UserInfo.extranote ,UserInfo.branch ,UserInfo.MelliID  FROM UserInfo inner join UserStatus on UserInfo.Status = UserStatus.Status INNER JOIN UserRole on UserInfo.Role = UserRole.Role where UserInfo.Role < $UserRole and UserName = '$RequestUser'";
            }
            $UserInfoBase = DB::select($Query);
            $BankAccounts = BankAccount::all()->where('UserName', $RequestUser)->where('Status', 1);
            $UserInfoResult = null;
            foreach ($UserInfoBase as $UserInfoBasetarget) {
                $UserInfoResult = $UserInfoBasetarget;
            }
            if (session::has('tavanpardakht')) {
                $tavanpardakht = true;
            } else {
                $tavanpardakht = false;
            }
            if ($UserInfoResult != null) {
                $MyJson = new JsonWorks();
                $JsonFild = $MyJson->GetJsonInArray($UserInfoResult->extranote);
                if (Auth::id() == $UserInfoResult->UserName) {
                    $SelfConfig = true;
                } else {
                    $SelfConfig = false;
                }
                $Query = "SELECT WorkerSkils.SkilID,L3Work.Name as Description, WorkerSkils.Weight from WorkerSkils INNER JOIN L3Work on WorkerSkils.SkilID = L3Work.UID WHERE WorkerSkils.UserName = '$RequestUser'";
                $UserSkills = DB::select($Query);
                $MyIndex = new Indexes();
                $IndexTree = $MyIndex->HTMLTreeIndex();
                $UserStatusInfo = UserStatus::all();
                $UserRoles = UserRole::where('Role', '<', Auth::user()->Role)->get();
                if ($UserInfoResult->extradata == null) {
                    $extradata = [];
                } else {
                    $extradata = json_decode($UserInfoResult->extradata);
                }
                if (myappenv::SiteTheme == 'Theme5' && Auth::user()->Role == myappenv::role_customer) {
                    return view('Layouts.Theme5.Users.Profile', ['extradata' => $extradata, 'UserRoles' => $UserRoles, 'layout' => $layout, 'tavanpardakht' => $tavanpardakht, 'UserInfoResult' => $UserInfoResult, 'BankAccounts' => $BankAccounts, 'UserSkills' => $UserSkills, 'IndexTree' => $IndexTree, 'UserStatusInfo' => $UserStatusInfo, 'UserStatus' => $UserInfoResult->Status, 'JsonFild' => $JsonFild, 'SelfConfig' => $SelfConfig]);
                }
                $worker_hires = new hiring_workers;
                $user_class = new UserClass;
                if (myappenv::Lic['hiring'] && Auth::user()->Role == myappenv::role_worker) {
                    return view("Users.Profile_hiring", ['user_class' => $user_class, 'worker_hires' => $worker_hires, 'extradata' => $extradata, 'UserRoles' => $UserRoles, 'layout' => $layout, 'tavanpardakht' => $tavanpardakht, 'UserInfoResult' => $UserInfoResult, 'BankAccounts' => $BankAccounts, 'UserSkills' => $UserSkills, 'IndexTree' => $IndexTree, 'UserStatusInfo' => $UserStatusInfo, 'UserStatus' => $UserInfoResult->Status, 'JsonFild' => $JsonFild, 'SelfConfig' => $SelfConfig]);
                }
                return view("Users.Profile", ['user_class' => $user_class, 'worker_hires' => $worker_hires, 'extradata' => $extradata, 'UserRoles' => $UserRoles, 'layout' => $layout, 'tavanpardakht' => $tavanpardakht, 'UserInfoResult' => $UserInfoResult, 'BankAccounts' => $BankAccounts, 'UserSkills' => $UserSkills, 'IndexTree' => $IndexTree, 'UserStatusInfo' => $UserStatusInfo, 'UserStatus' => $UserInfoResult->Status, 'JsonFild' => $JsonFild, 'SelfConfig' => $SelfConfig]);
            } else {
                abort(403, __("Error code:") . ' 011301');
            }
        }
    }
    public function SpecialUserFlow()
    {
    }
    private function edit_profile()
    {
        $usersrc = UserInfo::where('UserName', Auth::id())->first();
        if ($usersrc->Name == $usersrc->MobileNo) {
            $profiled_user = false;
        } else {
            $profiled_user = true;
        }
        return view('Layouts.Theme5.Users.objects.edit_profile', ['profiled_user' => $profiled_user, 'usersrc' => $usersrc])->render();
    }
    private function profile_addresses()
    {
        $orders = new Orders();


        return view('Layouts.Theme5.Users.objects.profile_addresses', ['orders' => $orders])->render();
    }
    private function profile_order()
    {
        $order_src = product_order::where('CustomerId', Auth::id())->get();
        $orders = new Orders();
        return view('Layouts.Theme5.Users.objects.profile_order', ['orders' => $orders, 'order_src' => $order_src])->render();
    }
    private function profile_main()
    {

        $RequestUser = Auth::id();
        $Query = "SELECT UserInfo.UserName,UserInfo.Name as nameofuser,UserInfo.Family,UserInfo.MobileNo,UserInfo.Email,UserInfo.Phone1
        ,UserInfo.Phone2,UserInfo.Address,UserInfo.Role,UserInfo.Birthday,UserInfo.CreateDate,UserStatus.Name as statusname,UserInfo.Status, 
        UserInfo.UserPass,(SELECT COALESCE(sum(Point),0) as point FROM UserPoint WHERE UserName = '$RequestUser' and ConfirmUser is not null ) as point ,UserInfo.Sex as Sex , 
        UserRole.RoleName ,UserInfo.extranote   FROM UserInfo inner join UserStatus on UserInfo.Status = UserStatus.Status 
        INNER JOIN UserRole on UserInfo.Role = UserRole.Role where  UserName = '$RequestUser'";
        $UserInfoBase = DB::select($Query);
        foreach ($UserInfoBase as $UserInfoBasetarget) {
            $UserInfoResult = $UserInfoBasetarget;
        }
        $mark = new ProductMark;

        return view('Layouts.Theme5.Users.objects.profile_main', ['mark' => $mark, 'UserInfoResult' => $UserInfoResult])->render();
    }
    private function load_order(int $order_id)
    {
        $orders = new Orders();
        $order_main = $orders->get_order($order_id);
        $order_detail = $orders->get_order_detail($order_id);
        return view('Layouts.Theme5.Users.objects.profile_order_order_detail', ['order_detail' => $order_detail, 'orders' => $orders, 'order_main' => $order_main])->render();
    }
    private function update_base_profile(Request $request)
    {
        $Name = strip_tags($request->name);
        $Family = strip_tags($request->family);
        $Email = strip_tags($request->email);
        $NationalCode = str_replace(array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'), array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9'), $request->id_code);
        $Birthday = null;
        if ($request->has('day') && $request->has('month') && $request->has('year')) {
            $my_persian = new persian;
            $Birthday = $my_persian->jalali_to_gregorian($request->year, $request->month, $request->day, '-');

        }
        $UserData = [
            "Name" => $Name,
            "Family" => $Family,
            "Email" => $Email,
            'MelliID' => $NationalCode,
            'Birthday' => $Birthday
        ];
        UserInfo::where("UserName", Auth::id())->update($UserData);
        return redirect()->back()->with('success', 'عملیات موفق!');
    }

    public function DoUserProfile(Request $request, $RequestUser = null)
    {
        if ($request->has('submit')) {
            if ($request->submit == 'add_extra_info') {
                $worker_class = new hiring_workers;
                $worker_class->update_worker_skills(Auth::id(), $request->SelectTags);
                $ExtraNote = strip_tags($request->input("extranote"));
                $UserData = [
                    "extranote" => $ExtraNote,
                ];
                UserInfo::where("UserName", Auth::id())->update($UserData);
                return back()->with('success', __('data has modify'));
            }
        }
        if ($request->has('submit') && myappenv::SiteTheme == 'Theme5') {
            return $this->update_base_profile($request);
        }

        if ($request->ajax()) {
            if ($request->has('function')) {
                if (Auth::user()->MobileNo == Auth::user()->Name) {
                    return $this->edit_profile();
                }
                switch ($request->function) {
                    case 'edit_profile':
                        return $this->edit_profile();
                    case 'profile_addresses':
                        return $this->profile_addresses();
                    case 'profile_order':
                        return $this->profile_order();
                    case 'profile_main':
                        return $this->profile_main();
                    case 'load_order':
                        return $this->load_order($request->order_id);
                    default:
                        # code...
                        break;
                }
                if ($request->function == 'edit_profile') {
                    return $this->edit_profile();
                }
            }
            if (myappenv::Lic['Voip']) {
                $BothSide = new ConsultClass();
                $request_user_info = UserInfo::where('UserName', $RequestUser)->first();
                if ($request_user_info == null) {
                    return 'کاربر مورد نظر یافت نشد!';
                }
                $target_mobile = $request_user_info->MobileNo;
                Log::info('request call');
                Log::info('request call' . Auth::user()->MobileNo . ' ' . $target_mobile);
                $BothSide->BothSideCall(Auth::user()->MobileNo, $target_mobile);
                return 'درخواست تماس ثبت گردید!';
            } else {
                return 'لایسنس مورد نیاز این قابلیت برای شما موجود ندارد!';
            }
        }

        if ($RequestUser == null || Auth::user()->Role < myappenv::role_superviser) {
            $RequestUser = Auth::id();
        }
        if (in_array($RequestUser, myappenv::ForbidnUser)) {
            abort(403, __("Error code:") . ' 020101');
        } else {
            if ($request->submit == 'max_credit') {
                $user_src = UserInfo::where('UserName', $RequestUser)->first();
                $extradata = $user_src->extradata;
                if ($extradata == null) {
                    $extradata = new stdClass;
                } else {
                    $extradata = json_decode($extradata);
                }
                $extradata->max_credit = $request->buy_credit;
                $extradata = json_encode($extradata);
                UserInfo::where('UserName', $RequestUser)->update(['extradata' => $extradata]);
                return redirect()->back()->with('success', 'سقف اعتبار در نظر گرفته شد!');
            }
            if ($request->input('submit') == 'add_user_documents') {
                $user_src = UserInfo::where('UserName', $RequestUser)->first();
                $extradata = $user_src->extradata;
                if ($extradata == null) {
                    $userclass = new UserClass;
                    $user_documents = $userclass->get_role_documentation($user_src->Role);
                } else { //user has extra data
                    $extradata = json_decode($extradata, true);
                    if (isset($extradata['docs'])) {
                        $user_documents = $extradata['docs'];
                    } else {
                        $userclass = new UserClass;
                        $user_documents = $userclass->get_role_documentation($user_src->Role);
                    }
                }
                foreach ($request->file('avatar') as $index => $single_file) {
                    $Mytext = new TextClassMain();
                    $avatarName = $Mytext->StrRandom() . '.' . $single_file->getClientOriginalExtension();
                    $single_file->storeAs("public/document/$RequestUser/", $avatarName, "private");
                    $user_documents[$index - 3]['doc_img'] = $avatarName;
                }
                $extradata['docs'] = $user_documents ?? [];
                $extradata = json_encode($extradata);
                UserInfo::where('UserName', $RequestUser)->update(['extradata' => $extradata]);
                return redirect()->back()->with('success', 'مدارک شما بارگذاری شد.');
            }

            if ($request->input('submit') == 'UpdateIMG') {
                if ($request->file('avatar')) {
                    $request->validate([
                        'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                    ]);
                    $Mytext = new TextClassMain();
                    $avatarName = $Mytext->StrRandom() . '.' . request()->avatar->getClientOriginalExtension();
                    $request->avatar->storeAs('public/avatar', $avatarName);
                    $avatarName = url('/') . '/storage/avatar/' . $avatarName;
                    $UserInfoResult = UserInfo::where('UserName', $RequestUser)->first();
                    $UserInfoResult->avatar = $avatarName;
                    $UserInfoResult->save();
                    return back()->with('success', __('You have successfully upload image.'));
                }
            } elseif ($request->input('submit') == "extranotesubmit") {
                $ExtraNote = strip_tags($request->input("extranote"));
                $UserData = [

                    "extranote" => $ExtraNote,

                ];
                UserInfo::where("UserName", $RequestUser)->update($UserData);
                return back()->with('success', __('data has modify'));
            } elseif ($request->input('submit') == "updatebaseinfo") {
                $request->validate([

                    "Name" => ['max:50', 'min:3'],
                    "Family" => ['max:80', 'min:3'],
                    "MobileNo" => ['max:11', 'min:11'],

                ], [
                    'Name.min' => __("The chars of feild ") . __('Name') . __(" Less than limet!"),
                    'Family.min' => __("The chars of feild ") . __('Family') . __(" Less than limet!"),
                    'MobileNo.min' => __("The chars of feild ") . __('Mobile No') . __(" Less than limet!"),
                ]);
                $Email = $request->input('UserName') . "@nomail.com";

                if ($request->has('Email')) {
                    if ($request->input('Email') != null) {
                        $Email = $request->input('Email');
                    }
                }
                $Mydate = new persian();
                $UserData = [
                    "Email" => $Email,
                    "Sex" => $request->input("Sex"),
                    'Degree' => $request->Degree,
                ];
                if ($request->has("Birthday")) {
                    if (trim($request->input("Birthday")) != '') {
                        $UserData['Birthday'] = $Mydate->MiladiDate($request->input("Birthday"));

                    }
                }
                if ($request->has("Name")) {
                    $UserData['Name'] = strip_tags($request->input("Name"));
                }
                if ($request->has("Family")) {
                    $UserData['Family'] = strip_tags($request->input("Family"));
                }
                if ($request->has("MobileNo")) {
                    $UserData['MobileNo'] = strip_tags($request->input("MobileNo"));
                }
                if ($request->has("Address")) {
                    $UserData['Address'] = strip_tags($request->input("Address"));
                }
                if ($request->has("Address2")) {
                    $UserData['Address2'] = strip_tags($request->input("Address2"));
                }

                if ($request->has("Phone1")) {
                    $UserData['Phone1'] = strip_tags($request->input("Phone1"));
                }

                if ($request->has("Phone2")) {
                    $UserData['Phone2'] = strip_tags($request->input("Phone2"));
                }
                if ($request->has("fathername")) {
                    $UserData['fathername'] = strip_tags($request->input("fathername"));
                }
                if ($request->has("expert")) {
                    $UserData['expert'] = strip_tags($request->input("expert"));
                }
                if ($request->has("Province")) {
                    $UserData['province'] = $request->Province;
                }
                if ($request->has('city')) {
                    $UserData['city'] = $request->city;
                }


                UserInfo::where("UserName", $RequestUser)->update($UserData);
                if ($request->input('branch') == myappenv::shafatelunmanagedcustomers || $request->input('branch') == myappenv::shafatelmanagedcustomers_done) {
                    $postRequest = array(
                        'function' => 'UpdateUser',
                        'keySec' => myappenv::ShafatelKey,
                        "UserName" => $RequestUser,
                        "Name" => $request->input("Name"),
                        "Family" => $request->input("Family"),
                        "Email" => $request->input("Email"),
                        "Sex" => $request->input("Sex"),
                        "MobileNo" => $request->input("MobileNo"),
                        "Birthday" => $Birthday,
                        "Address" => $request->input("Address"),
                        "Phone1" => $request->input("Phone1"),
                        "Phone2" => $request->input("Phone2"),
                    );
                    if ($request->has("Province")) {
                        $UserData['province'] = $request->Province;
                        $UserData['city'] = null;
                        if ($request->has('city')) {
                            $UserData['city'] = $request->city;
                        }
                    }

                    $MyAPI = new APIClass();
                    $apiResponse = $MyAPI->PostCurl(myappenv::ShafatelAPIAddress, $postRequest);
                    if ($request->input('branch') == myappenv::shafatelunmanagedcustomers) {
                        $UserData = array(
                            'branch' => myappenv::shafatelmanagedcustomers_done,
                        );
                        UserInfo::where("UserName", $RequestUser)->update($UserData);
                    }
                }

                return redirect()->back()->with('success', __("success alert"));
            } elseif ($request->input('submit') == "deleteindex") {
                WorkerSkils::where('UserName', $RequestUser)->wherein('SkilID', $request->input('deleteindexitems'))->delete();
                return redirect()->back()->with("success", __('data has modify'));
            } elseif ($request->input('submit') == "addindexes") {
                $indexarr = $request->input('check_list');
                $InsertData = array();
                foreach ($indexarr as $indexar) {
                    $skill_before = WorkerSkils::where('UserName', $RequestUser)->where('SkilID', $indexar)->first();
                    if ($skill_before == null) {
                        $TL3WorkSrc = L3Work::where('UID', $indexar)->first();
                        $TWorkCat = $TL3WorkSrc->WorkCat;
                        $TL1ID = $TL3WorkSrc->L1ID;
                        $TL2ID = $TL3WorkSrc->L2ID;
                        $SingleData = [
                            'UserName' => $RequestUser,
                            'SkilID' => $indexar,
                            'WorkCat' => $TWorkCat,
                            'L1ID' => $TL1ID,
                            'L2ID' => $TL2ID,
                            'CreateDate' => now(),
                            'Status' => 1,
                            'Note' => "",
                        ];
                        WorkerSkils::create($SingleData);
                    }
                }
                return redirect()->back()->with("success", __('data has modify'));
            } elseif ($request->input('submit') == "SendSms") {
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
            } elseif ($request->input('submit') == 'changestatus') {
                $Updatedata = ["Status" => $request->input('UserStatus')];
                UserInfo::where("UserName", $RequestUser)->update($Updatedata);
                return redirect()->back()->with("success", __('data has modify'));
            } elseif ($request->input('submit') == 'changepassword') {
                $Updatedata = ["password" => Hash::make($request->input('Password'))];
                UserInfo::where("UserName", $RequestUser)->update($Updatedata);
                return redirect()->back()->with("success", __('data has modify'));
            } elseif ($request->input('submit') == 'MelliID') {
                UserInfo::where('UserName', $RequestUser)->update(['MelliID' => $request->input('MelliID')]);
                return redirect()->back()->with('success', 'کد ملی به روز رسانی گردید');
            } elseif ($request->input('submit') == 'specialuser') {
                $TavanPardakht = new Reports();
                $Estelam = $TavanPardakht->Estelam(Auth::user()->MelliID);
                //$Es_Mobile = $Estelam->tham;
                $Es_Mobile = '09192228284';
                $Es_fullName = $Estelam->fullName;
                if ($Estelam->personType == 'PENSIONER') {
                    $personType = ' مستمری بگیر ';
                    $person = 2;
                } else {
                    $personType = 'بازنشسته ';
                    $person = 1;
                }
                $UserClass = new UserClass();
                $secCode = $UserClass->GetRandomPassword(5);
                $MessageText = $personType . ' گرامی در سامانه کوک باز شما درخواست کاربری ویژه جهت خرید اعتباری اقساطی داده اید در صورتی که مورد تایید است کد ' . $secCode . ' را در سامانه وارد فرمایید! ';
                $Mysms = new SmsCenter();
                $Mysms->OndemandSMS($MessageText, $Es_Mobile, 'SystemUA', Auth::id());
                session::put('tavanpardakht', $secCode);
                session::put('person', $person);
                return redirect()->back()->with('success', 'پیامک تاییدیه به شماره موبایل شما ارسال گردید جهت اتمام عملیات کد تاییدیه را وارد فرمایید!');
            } elseif ($request->input('submit') == 'confirmSpecialUser') {
                $seccode = $request->input('seccode');
                $tavanpardakhtCode = session::get('tavanpardakht');
                $person = session::get('person');
                if ($seccode == $tavanpardakhtCode) {
                    session::put('tavanpardakht', null);
                    session::put('person', null);
                    UserInfo::where('UserName', Auth::id())->update(['CreditePlan' => $person]);
                    return redirect()->back()->with('success', 'کاربر شما به سطح کاربری ویژه ارتقا پیدا کرد!');
                } else {
                    return redirect()->back()->with('error', 'کد وارد شده معتبر نمی باشد!');
                }
            } elseif ($request->input('submit') == 'Updatecardnumber') {
                $shabanumber = $request->input('shaba');
                $cardnumber = $request->input('cardnumber');
                $bankname = $request->input('bankname');
                $SaveData = [
                    'UserName' => $RequestUser,
                    'CardNo' => strip_tags($cardnumber),
                    'Account' => strip_tags($shabanumber),
                    '‌BankName' => strip_tags($bankname),
                    'Status' => 1,
                ];
                BankAccount::create($SaveData);
                return redirect()->back()->with('success', 'شماره شبا با موفقیت اضافه گردید!');
            } elseif ($request->input('submit') == 'changeRole') {
                $TargetRole = $request->input('UserRole');
                if ($TargetRole == 0) {
                    return redirect()->back()->with('error', 'نقش انتخاب نشده است!');
                }
                UserInfo::where('UserName', $RequestUser)->update(['Role' => $TargetRole]);
                return redirect()->back()->with('success', 'تغییر نقش انجام شد!');
            }
        }
    }

    public function UserReport($RequestUser)
    {
        if (in_array($RequestUser, myappenv::ForbidnUser)) {
            abort(403, __("Error code:") . ' 020101');
        } else {
            $UserRole = Auth::user()->Role;
            $Query = "SELECT UserInfo.UserName,UserInfo.Name as nameofuser,UserInfo.Family,UserInfo.MobileNo,UserInfo.Email,UserInfo.Phone1,UserInfo.Phone2,UserInfo.Address,UserInfo.Role,UserInfo.Birthday,UserInfo.CreateDate,UserStatus.Name as statusname,UserInfo.Status, UserInfo.UserPass,(SELECT COALESCE(sum(Point),0) as point FROM UserPoint WHERE UserName = '$RequestUser' and ConfirmUser is not null ) as point ,UserInfo.Sex as Sex , UserRole.RoleName ,UserInfo.extranote   FROM UserInfo inner join UserStatus on UserInfo.Status = UserStatus.Status INNER JOIN UserRole on UserInfo.Role = UserRole.Role where UserInfo.Role < $UserRole and UserName = '$RequestUser'";
            $UserInfoBase = DB::select($Query);
            $UserTotalReport = new Financial();
            $UserFinancialState = $UserTotalReport->UserFinalState($RequestUser);
            if ($UserInfoBase != null) {
                foreach ($UserInfoBase as $UserInfoBasetarget) {
                    $UserInfoResult = $UserInfoBasetarget;
                }
                $MyTransaction = new Financial();
                $myTrasaction = $MyTransaction->AccountHistory($RequestUser, 1000);
                $MyTrasactionCredit = $MyTransaction->AccountCreditHistory($RequestUser, 1000);
                $CallCenter = new CallCenterClass();
                $CallCenter->UserSetter($RequestUser);
                $UserCreditModMetas = UserCreditModMeta::all();
                $CreditIndex = UserCreditIndex::all();
                $usertransfer = new CreditTransfer;
                return view("Users.UsersReports", ['usertransfer' => $usertransfer, 'RequestPat' => $RequestUser, 'MyTrasactionCredit' => $MyTrasactionCredit, 'CreditIndex' => $CreditIndex, 'UserCreditModMetas' => $UserCreditModMetas, 'CallCenter' => $CallCenter, 'UserInfoResult' => $UserInfoResult, 'myTrasaction' => $myTrasaction, 'ShiftEnable' => true, 'UserFinancialState' => $UserFinancialState]);
            } else {
                abort(403, __("Error code:") . ' 011401');
            }
        }
    }

    public function DoUserReport(Request $request, $RequestUser)
    {
        if (in_array($RequestUser, myappenv::ForbidnUser)) {
            abort(403, __("Error code:") . ' 020101');
        } else {
        }
        if ($request->input('submit') == 'Trnsfer' || $request->input('submit') == 'TrnsferSnad') {

            $TargetUser = $RequestUser;


            foreach ($request->input('Trasaction') as $key => $Trasaction) {

                $CrediteIndex = $request->input('CreditIndex')[$Trasaction];
                if ($CrediteIndex == 0) {
                    $CrediteIndex = null;
                }
                $ID = $request->input('ID')[$Trasaction];
                $UserCredititem = UserCredit::where('ID', $ID)->first();
                $InvoiceNo = $UserCredititem->InvoiceNo;
                $Mony = $UserCredititem->Mony;
                $CreditMod = $UserCredititem->CreditMod;
                $Note = $request->input('Note');
                $Note .= ' سفارش  : ' . $InvoiceNo;
                $CreditType = myappenv::NormalCreditNumber;
                $CrediteData = [
                    'UserName' => $TargetUser,
                    'Mony' => $Mony * -1,
                    'Type' => $CreditType,
                    'Date' => now(),
                    'Note' => $Note,
                    'TransferBy' => Auth::ID(),
                    'CreditMod' => $CreditMod,
                    'InvoiceNo' => $InvoiceNo,
                    'ZeroRefrenceID' => $ID,
                    'branch' => '1',
                    'CreditIndex' => $CrediteIndex,
                ];
                $Result = UserCredit::create($CrediteData);
            }
            return redirect()->back()->with('success', 'درخواست انتقال به صورت موفقیت آمیز ثبت گردید!');
        }
    }
    public function DoPersonelCard(Request $request, $RequestUser)
    {
        if (!Auth::check()) {
            return abort('404', 'مجوز انجام این عملیات را ندارید');
        }
        if ($RequestUser == Auth::id()) {
            $ExtraNote = strip_tags($request->input("extranote"));
            $UserData = [
                "extranote" => $ExtraNote,
            ];
            UserInfo::where("UserName", $RequestUser)->update($UserData);
            return redirect()->back()->with('success', 'عملیات موفق');
        }
    }

    public function PersonelCard($RequestUser)
    {
        $TargetUserRole = UserInfo::where('Ext', $RequestUser)->orWhere('UserName', $RequestUser)->first();
        if ($TargetUserRole == null) {
            abort(404);
        }
        if ($TargetUserRole->Role == myappenv::role_worker) {
            $branch = branches::where('id', $TargetUserRole->branch)->first();
            $UserStatus = UserStatus::where('Status', $TargetUserRole->Status)->first();
            if (myappenv::Lic['hiring']) {
                $edit_mode = false;
                if (Auth::check()) {
                    if (Auth::user()->Role >= myappenv::role_admin) {
                        $edit_mode = true;
                    }
                    if (Auth::id() == $RequestUser) {
                        $edit_mode = true;
                    }
                }
                if ($edit_mode) { // show admin mode card
                    return view("Users.PersonelCard_hiring_admin", ['branch' => $branch, 'targetUser' => $TargetUserRole, 'UserStatus' => $UserStatus]);
                }
                return view("Users.PersonelCard_hiring", ['branch' => $branch, 'targetUser' => $TargetUserRole, 'UserStatus' => $UserStatus]);
            }
            return view("Users.PersonelCard", ['branch' => $branch, 'targetUser' => $TargetUserRole, 'UserStatus' => $UserStatus]);
        } else {
            $branch = branches::where('id', $TargetUserRole->branch)->first();
            $UserStatus = UserStatus::where('Status', $TargetUserRole->Status)->first();
            if (myappenv::Lic['hiring']) {
                return view("Users.PersonelCard_hiring", ['branch' => $branch, 'targetUser' => $TargetUserRole, 'UserStatus' => $UserStatus]);
            }
            return view("Users.PersonelCard", ['branch' => $branch, 'targetUser' => $TargetUserRole, 'UserStatus' => $UserStatus]);
        }
    }
}

<?php

namespace App\Http\Controllers\Order;

use App\APIS\SmsCenter;
use App\Functions\APIClass;
use App\Functions\MarketingClass;
use App\Functions\Orders;
use App\Functions\persian;
use App\Functions\TextClassMain;
use App\Users\UserClass;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Dashboard\Dashboard;
use App\Http\Controllers\Patients\Workflow;
use App\Models\addorder1;
use App\Models\branch_cat_orders;
use App\Models\branches;
use App\Models\catorder;
use App\Models\orderstatus;
use App\Models\UserInfo;
use App\myappenv;
use App\Order\OrderClass;
use Auth;
use DB;
use Hamcrest\Type\IsArray;
use Hamcrest\Type\IsNumeric;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Support\Facades\Hash;
use Session;
use Illuminate\Support\Facades\Log;

class OrderMain extends Controller
{
    private function order_selected($OrderID)
    {
        if (!Auth::check()) {
            Session::put('intended_url_important', url()->current());
            Session::put('intended_url', url()->current());
            return redirect()->route('login');
        }

        $OrderSrc = catorder::where('Cat', $OrderID)->first();
        if ($OrderSrc == null) {
            return abort('404');
        }
        $order_id = $OrderSrc->id;
        $Query = "SELECT branch_cat_orders.* , branches.Name as branch_name,branches.Description,branches.Phone,branches.avatar,branches.extra_info
            FROM branch_cat_orders INNER JOIN branches on branch_cat_orders.branch = branches.id
            WHERE branch_cat_orders.catorder = $order_id and branch_cat_orders.Status = 100 and branch_cat_orders.OnSale = 1";

        $supported_branch = DB::select($Query);
        if (myappenv::version < 3) {
            return view('Order.CustomerOrderSelected', ['OrderSrc' => $OrderSrc, 'supported_branch' => $supported_branch]);
        } else {
            return view('Order.CustomerOrderSelected_shafatel_pannel', ['OrderSrc' => $OrderSrc, 'supported_branch' => $supported_branch]);
        }
    }
    private function show_all_orders()
    {
        if (Auth::check()) {
            $orders = new OrderClass;
            $dashboard = new Dashboard;
            $cat_orders = $dashboard->get_cat_orders();
            return view('Order.CustomerDashboardOrder', ['cat_orders' => $cat_orders, 'orders' => $orders]);
        } else {
            $orders = new OrderClass;
            $dashboard = new Dashboard;
            $cat_orders = $dashboard->get_cat_orders();
            $theme = myappenv::SiteTheme;
            return view("Layouts.$theme.OrdersList", ['cat_orders' => $cat_orders, 'orders' => $orders]);
        }

    }
    public function CustomerOrder($OrderID = null)
    {
        if ($OrderID != null) {
            return $this->order_selected($OrderID);
        }
        return $this->show_all_orders();
    }
    public function DoCustomerOrder(Request $request, $OrderID = null)
    {
        if ($request->ajax) {
            $service_id = $request->service_id;
            if (!is_numeric($service_id)) {
                return 'false';
            }
            $branch_cat_order_src = branch_cat_orders::where('id', $service_id)->first();
            if ($branch_cat_order_src == null) {
                return 'false';
            }
            $branch_id = $branch_cat_order_src->branch;

            $branch_src = branches::where('id', $branch_id)->first();


            return $branch_src;
        }

        $mytext = new TextClassMain;
        $Extranote = $mytext->StripText($request->note);
        $MobileNo = $mytext->StripText($request->MobileNo);
        $family = $mytext->StripText($request->family);
        $name = $mytext->StripText($request->name);
        $branch = $request->branch ?? myappenv::Branch;
        $persian = new persian;
        $now_date = $persian->MyPersianNow();
        $DataInput = [
            'MobileNo' => $MobileNo,
            'Extranote' => $Extranote,
            'family' => $family,
            'name' => $name,
            'now_date' => $now_date
        ];

        $CatID = $request->CatID;
        $Customer_UserName = Auth::id();
        $DataSource = [
            'UserName' => $Customer_UserName,
            'BimarUserName' => $Customer_UserName,
            'CatID' => $CatID,
            'CreateDate' => now(),
            'Status' => '1',
            'Address' => '',
            'Extranote' => json_encode($DataInput),
            'branch' => $branch,
        ];
        $result = addorder1::create($DataSource);
        $branch_src = branches::where('id', $branch)->first();
        $SMSText = $branch_src->Description . "   " . "درخواست شما به شماره " . $result->id . ' ثبت گردید ، پس از بررسی کارشناسان ما با شما تماس خواهند گرفت !';
        $MySMS = new SmsCenter();
        $MySMS->OndemandSMS($SMSText, Auth::user()->MobileNo, 'register_order', Auth::user()->MobileNo);
        $SMSText = "سلام " . "درخواست شما به شماره " . $result->id . 'در سامانه شفاتل ثبت گردید!';
        $MySMS->OndemandSMS($SMSText, $branch_src->Phone, 'alert_order', $branch_src->Phone);
        Log::channel('slack')->info('ثبت خدمت به  ' . $branch_src->Description . "
        شماره همراه:   $MobileNo,
        توضیحات $Extranote,
        فامیل:  $family,
        نام: $name,
        زمان ثبت:  $now_date");
        return redirect()->route('CustomerOrder')->with('success', 'درخواست شما ثبت گردید  کارشناسان مرکز پس از بررسی با شما تماس خواهند گرفت!');
    }
    public function FaildBuy($id = null)
    {
        $Query = 'SELECT po.id, ui.Name,ui.Family,ui.MobileNo, po.total_sales,po.created_at,po.num_items_sold FROM product_orders as po
        INNER JOIN UserInfo as ui on po.CustomerId = ui.UserName WHERE po.status = 0 ORDER BY po.id DESC';
        $OpenOrder = DB::select($Query);
        return view('woocommerce.admin.FaildOrders', ['OpenOrder' => $OpenOrder]);
    }
    public function DoFaildBuy($id = null, Request $request)
    {
    }
    private function order_dictionary($input_str)
    {
        $input_str = strtolower($input_str);
        switch ($input_str) {
            case 'name':
                return 'نام';
            case 'family':
                return 'نام خانوادگی';
            case 'extranote':
                return 'توضیحات';
            case 'now_date':
                return 'تاریخ ثبت';
            case 'mobileno':
                return 'شماره همراه';
        }
        return $input_str;
    }
    public function extra_info_process($extra_data)
    {
        //return $extra_data;
        $extra_data_copy = $extra_data;
        $json_src = json_decode($extra_data, 1);

        if (json_last_error() === JSON_ERROR_NONE) {
            $output = '';
            foreach ($json_src as $index => $item) {
                if (!is_array($item)) {
                    $str_index = $this->order_dictionary($index);
                    $output .= "<li> $str_index : $item </li>";
                }
            }
            return $output;
        }



        return $extra_data_copy;
    }
    public function OrderList()
    {
        if (\App\myappenv::Lic['woocommerce']) {
            $Query = "SELECT * from product_orders po inner join UserInfo ui on ui.UserName  = po.CustomerId where po.status = 1 ";
            $product_order = DB::select($Query);
        } else {
            $product_order = null;
        }
        $myOrder = new Orders;
        $product_order = $myOrder->ViewOrders(Auth::id(), Auth::user()->Role);
        $orderstatus = orderstatus::all();
        $OrderClass = new Orders();
        $MyOrders = $OrderClass->ViewOrders(Auth::id(), Auth::user()->Role);
        if (myappenv::MainOwner == 'arzonline') {
            return view('Order.OrderList_arzonline', ['processor' => $this, 'product_order' => $product_order, 'MyOrders' => $MyOrders, 'orderstatus' => $orderstatus]);
        }
        return view('Order.OrderList', ['processor' => $this, 'product_order' => $product_order, 'MyOrders' => $MyOrders, 'orderstatus' => $orderstatus]);
    }

    public function DoOrderList()
    {
    }

    public function Order($OrderID = null)
    {
        if (!Auth::check()) { // if user not login
            if (myappenv::OrderAddressType == 'id') {
                $catorder = catorder::where('ID', $OrderID)->first();
            } elseif (myappenv::OrderAddressType == 'name') {
                $catorder = catorder::where('Cat', $OrderID)->first();
            }
            if ($catorder == null) {
                return abort('404');
            }
            return view("Order.CustomerOrder", ['catorder' => $catorder]);
        }
        if (Auth::user()->Role == myappenv::role_customer) {
            if ($OrderID == null) {
                return abort('404');
            } else {
                if (myappenv::OrderAddressType == 'id') {
                    $catorder = catorder::where('ID', $OrderID)->first();
                } elseif (myappenv::OrderAddressType == 'name') {
                    $catorder = catorder::where('Cat', $OrderID)->first();
                }
                $accesstype = Session::get('accesstype');
                if ($accesstype == 'wpa') {
                    return view("WPA.Order.CustomerOrder", ['catorder' => $catorder]);
                } else {
                    return view("Order.CustomerOrder", ['catorder' => $catorder]);
                }
            }
        } else {
            if (myappenv::Lic['MultiBranch']) {
                if (myappenv::version < 3) {
                    $catorders = catorder::all()->where('branch', Auth::user()->branch)->where('Status', 1);
                } else {
                    $user_branch = Auth::user()->branch;
                    $Query = "SELECT catorder.* FROM branch_cat_orders INNER JOIN catorder on branch_cat_orders.catorder = catorder.id
                    and branch_cat_orders.branch = $user_branch
                    and branch_cat_orders.OnSale = 1 ";
                   // $catorders = DB::select($Query);
                    $catorders = catorder::all()->where('branch', Auth::user()->branch)->where('Status', 1);
                    $UserName = Auth::id();

                    $Queryo = "SELECT addorder1.ID,addorder1.BimarUserName,UserInfo.Name,UserInfo.Family,UserInfo.MobileNo,catorder.Cat,catorder.TitleDescription,addorder1.CreateDate,addorder1.Address,addorder1.Extranote,orderstatus.status ,addorder1.status as OrderStatus
        FROM addorder1 INNER JOIN UserInfo ON addorder1.BimarUserName=UserInfo.UserName INNER JOIN orderstatus ON orderstatus.ID=addorder1.status INNER JOIN catorder ON catorder.ID=addorder1.CatID
        WHERE addorder1.UserName='$UserName'";
                    $Orders = DB::select($Queryo);
                    return view("Order.OrderMain", ['catorders' => $catorders, 'Orders' => $Orders]);
                }
            } else {
                $catorders = catorder::all();
            }

            $UserName = Auth::id();
            $Queryo = "SELECT addorder1.ID,addorder1.BimarUserName,UserInfo.Name,UserInfo.Family,UserInfo.MobileNo,catorder.Cat,catorder.TitleDescription,addorder1.CreateDate,addorder1.Address,addorder1.Extranote,orderstatus.status ,addorder1.status as OrderStatus
FROM addorder1 INNER JOIN UserInfo ON addorder1.BimarUserName=UserInfo.UserName INNER JOIN orderstatus ON orderstatus.ID=addorder1.status INNER JOIN catorder ON catorder.ID=addorder1.CatID
WHERE addorder1.UserName='$UserName'";
            $Orders = DB::select($Queryo);
            return view("Order.OrderMain", ['catorders' => $catorders, 'Orders' => $Orders]);
        }
    }

    public function DoOrder(Request $request, $OrderID = null)
    {
        $mytext = new TextClassMain;
        if ($request->has('Cancle_req')) {
            $OrderID = $request->input('Cancle_req');
            addorder1::where('ID', $OrderID)->update(['Status' => 8]);
            return redirect()->back();
        }
        if ($request->has('Recover_req')) {
            $OrderID = $request->input('Recover_req');
            addorder1::where('ID', $OrderID)->update(['Status' => 1]);
            return redirect()->back();
        }

        if (myappenv::OrderAddressType == 'id') {
        } elseif (myappenv::OrderAddressType == 'name') {

            $catorder = catorder::where('Cat', $OrderID)->first();
            if ($catorder != null) {
                $OrderID = $catorder->ID;
            } else {
                if (!Auth::check()) {
                    return abort('404');
                }
            }
        }

        if ($request->input('submit') == 'pwa') {
            $targetuser = UserInfo::where('MobileNo', $request->input('mobilenumber'))->first();
            if ($targetuser == null) {
                $Marker = new MarketingClass();
                $LastExt = DB::table('UserInfo')->latest('Ext')->first();
                $Ext = $LastExt->Ext;
                $NewUserData = [
                    'UserName' => UserClass::get_free_username(),
                    'Email' => $request->input('mobilenumber') . "@nomail.com",
                    'password' => Hash::make($request->input('mobilenumber')),
                    'UserPass' => $request->input('mobilenumber'),
                    'Name' => $request->input('name'),
                    'Ext' => $Ext + 1,
                    'Family' => $request->input('family'),
                    'MobileNo' => $request->input('mobilenumber'),
                    'Role' => myappenv::role_customer,
                    'Sex' => 'm',
                    'MarketingCode' => $Marker->get_marketer(),
                    'Marketer' => $Marker->get_marketer(),
                    'Status' => myappenv::User_active_status,
                ];
                UserInfo::create($NewUserData);
            }
            $Address = "";
            if ($request->has('ADDAddress')) {
                $Address = $mytext->StripText($request->input('ADDAddress'));
            }
            $Extranote = $mytext->StripText($request->input('note'));
            $DataSource = [
                'UserName' => $request->input('mobilenumber'),
                'BimarUserName' => $request->input('mobilenumber'),
                'CatID' => $OrderID,
                'CreateDate' => now(),
                'city' => $request->city,
                'Province' => $request->Province,
                'Status' => '1',
                'Address' => $Address,
                'Extranote' => $Extranote,
                'branch' => myappenv::Branch,
            ];
            $result = addorder1::create($DataSource);
            $SMSText = myappenv::CenterName . "   " . "درخواست شما به شماره " . $result->id . ' ثبت گردید ، پس از بررسی کارشناسان ما با شما تماس خواهند گرفت !';
            $MySMS = new SmsCenter();
            $MySMS->OndemandSMS($SMSText, $request->input('mobilenumber'), 'ResetPassword', $request->input('mobilenumber'));
            return redirect()->route('home');
        } elseif ($request->input('submit') == 'customeradd') {
            if (Auth::check()) {
                $Address = "";
                if ($request->has('address')) {
                    if ($request->input('address') != null) {
                        $Address = $request->input('address');
                    }
                }
                $DataSource = [
                    'UserName' => Auth::id(),
                    'BimarUserName' => Auth::id(),
                    'CatID' => $OrderID,
                    'CreateDate' => now(),
                    'Status' => '1',
                    'Address' => $Address,
                    'Extranote' => $request->input('ADDExtranote'),
                    'branch' => Auth::user()->Branch,
                ];
            } else {

                $targetuser = UserInfo::where('MobileNo', $request->input('mobilenumber'))->first();
                if ($targetuser == null) {
                    $Marker = new MarketingClass();
                    $LastExt = DB::table('UserInfo')->latest('Ext')->first();
                    $Ext = $LastExt->Ext;
                    $NewUserData = [
                        'UserName' => UserClass::get_free_username(),
                        'Email' => $request->input('mobilenumber') . "@nomail.com",
                        'password' => Hash::make($request->input('mobilenumber')),
                        'UserPass' => $request->input('mobilenumber'),
                        'Name' => $request->input('Name'),
                        'Ext' => $Ext + 1,
                        'Family' => $request->input('Family'),
                        'MobileNo' => $request->input('mobilenumber'),
                        'Role' => myappenv::role_customer,
                        'Sex' => 'm',
                        'Status' => myappenv::User_active_status,
                        'MarketingCode' => $Marker->get_marketer(),
                        'Marketer' => $Marker->get_marketer(),
                        'branch' => myappenv::Branch,
                    ];
                    UserInfo::create($NewUserData);

                }
                $Address = "";
                if ($request->has('address')) {
                    if ($request->input('address') != null) {
                        $Address = $request->input('address');
                    }
                }
                $DataSource = [
                    'UserName' => $targetuser->UserName,
                    'BimarUserName' => $request->input('mobilenumber'),
                    'CatID' => $OrderID,
                    'CreateDate' => now(),
                    'Status' => '1',
                    'Address' => $Address,
                    'Extranote' => $request->input('ADDExtranote'),
                    'branch' => myappenv::Branch,
                ];
                $result = addorder1::create($DataSource);
                $SMSText = "** شفاتل - کوک باز **" . "   " . $request->input('Name') . ' ' . $request->input('Family') . ' عزیز ' . "درخواست شما به شماره " . $result->id . ' ثبت گردید ، پس از بررسی کارشناسان ما با شما تماس خواهند گرفت !';
                $MySMS = new SmsCenter();
                $MySMS->OndemandSMS($SMSText, $request->input('mobilenumber'), 'ResetPassword', $request->input('mobilenumber'));
                return redirect()->route('home')->with('success', 'درخواست خدمت شما ثبت و به مراکز مربوطه ارسال گردید پس از بررسی کارشناس با شما جهت هماهنگی های انجام خدمت تماس گرفته خواهد شد!');
            }
            $result = addorder1::create($DataSource);
            if ($result->id != null) {
                $MessageText = Auth::user()->Name . ' ' . Auth::user()->Family . ' ' . "عزیز درخواست شما ثبت گردید. پس از بررسی کارشناسان با شما تماس گرفته خواهد شد " . " " . " شماره درخواست " . $result->id . " " . " **شفاتل**";
                $Mysms = new SmsCenter();
                $Mysms->OndemandSMS($MessageText, Auth::user()->MobileNo, 'Order', Auth::id());
                //todo handel for multi branch
                $targetAnswer = branches::where('Name', 'Arta')->first();
                $postRequest = array(
                    'function' => 'AddOrder',
                    'keySec' => $targetAnswer->license,
                    'UserName' => Auth::id(),
                    'UserPass' => Auth::user()->UserPass,
                    'Name' => Auth::user()->Name,
                    'Family' => Auth::user()->Family,
                    'MobileNo' => Auth::user()->MobileNo,
                    'Email' => Auth::user()->Email,
                    'Ext' => Auth::user()->Ext,
                    'branch' => myappenv::Shafatel_Branch,
                    'CatID' => $OrderID,
                    'Address' => $request->input('Address'),
                    'ADDExtranote' => $request->input('ADDExtranote'),
                    'PearID' => $result->id,
                );
                $MyAPI = new APIClass();
                $apiResponse = $MyAPI->PostCurl($targetAnswer->api, $postRequest);
                $response = json_decode($apiResponse);
                $postRequest = array(
                    'PearID' => $response->orderid,
                );
                addorder1::where('ID', $result->id)->update($postRequest);
                return redirect()->route('dashboard')->with('success', 'درخواست خدمت شما ثبت و به مراکز مربوطه ارسال گردید پس از بررسی کارشناس با شما جهت هماهنگی های انجام خدمت تماس گرفته خواهد شد!');
            } else {
                return redirect()->route('dashboard')->with('error', 'خطا در انجام عملیات!');
            }
        } else {
            $ReadyToAdd = false;
            if ($request->has('TargetUser')) {
                if ($request->input('TargetUser') == -1) { // add new user with same mobile number
                    $Myuser = new UserClass();
                    $Password = $Myuser->GetRandomPassword(4);
                    if ($request->has('MelliID')) {
                        $MelliID = $request->input('MelliID');
                    } else {
                        return redirect()->back()->with('error', 'بدون کد ملی کاربر بر روی یک شماره موبایل نمی تواند اضافه گردد!');
                    }
                    if ($request->input('ADDName') == null || $request->input('ADDFamily') == null || $request->input('ADDMobile') == null) {
                        return redirect()->back()->with('error', 'داده های وارد شده جهت ثبت درخواست کامل نمی باشند');
                    }
                    $mobile_number = $request->input('ADDMobile');
                    $customer_name = $request->input('ADDName');
                    $customer_family = $request->input('ADDFamily');
                    $center_name = myappenv::CenterName;
                    $site_address = myappenv::SiteAddress;
                    $sms_text = "$center_name
                    مشتری گرامی آقای/خانم : $customer_name $customer_family  ثبت نام شما همزمان با ثبت درخواست توسط همکاران ما انجام شد. نام کاربری شما :  $mobile_number میباشد برای ورود به پنل خود و یا تکمیل اطلاعات خود از لینک زیر اقدام نمایید.
                    $site_address";
                    $Myuser->send_sms_after_job($sms_text, true);
                    $Myuser->AddUserwithmelliid($request->input('MelliID'), $Password, $request->input('ADDName'), $request->input('ADDFamily'), $MelliID, $request->input('ADDMobile'), $request->input('ADDMobile') . "@nomail.com", myappenv::role_customer, myappenv::Default_customer_Status, null, Auth::user()->branch);
                    $BimarUserName = $request->input('MelliID');
                    $ReadyToAdd = true;
                } else {
                    $BimarUserName = $request->input('TargetUser');
                    $ReadyToAdd = true;
                }
            } else { // user not exist in database
                $Myuser = new UserClass();
                $Password = $Myuser->GetRandomPassword(4);
                if ($request->has('MelliID')) {
                    $MelliID = $request->input('MelliID');
                } else {
                    $MelliID = '0';
                }
                $mobile_number = $request->input('ADDMobile');
                $customer_name = $request->input('ADDName');
                $customer_family = $request->input('ADDFamily');
                $center_name = myappenv::CenterName;
                $site_address = myappenv::SiteAddress;

                $sms_text = "$center_name
                مشتری گرامی آقای/خانم : $customer_name $customer_family  ثبت نام شما همزمان با ثبت درخواست توسط همکاران ما انجام شد. نام کاربری شما :  $mobile_number میباشد برای ورود به پنل خود و یا تکمیل اطلاعات خود از لینک زیر اقدام نمایید.
                $site_address";
                $Myuser->send_sms_after_job($sms_text, true);

                $BimarUserName = $Myuser->AddUserwithmelliid($request->input('ADDMobile'), $Password, $request->input('ADDName'), $request->input('ADDFamily'), $MelliID, $request->input('ADDMobile'), $request->input('ADDMobile') . "@nomail.com", myappenv::role_customer, myappenv::Default_customer_Status, null, Auth::user()->branch);
                $ReadyToAdd = true;
            }
            if ($ReadyToAdd) {

                $Address = "";
                if ($request->has('ADDAddress')) {
                    $Address = $mytext->StripText($request->input('ADDAddress'));
                }
                $Extranote = $mytext->StripText($request->input('ADDExtranote'));

                $DataSource = [
                    'UserName' => Auth::id(),
                    'BimarUserName' => $BimarUserName,
                    'CatID' => $request->input('ServiceesID'),
                    'CreateDate' => now(),
                    'Status' => '1',
                    'city' => $request->city,
                    'Province' => $request->Province,
                    'Address' => $Address,
                    'Extranote' => $Extranote,
                    'branch' => myappenv::Branch,
                ];
                $result = addorder1::create($DataSource);
                if (\App\myappenv::Lic['HCIS_Workflow']) {
                    $MyWorkFlow = new Workflow();
                    $WorkFlowText = ' ثبت درخواست شماره : ' . $result->id . '<br>';
                    $OrderCat = catorder::where('ID', $request->input('ServiceesID'))->first();
                    $WorkFlowText .= '<h6>' . $OrderCat->TitleDescription . '</h6>';
                    $WorkFlowText .= $request->input('ADDExtranote');
                    $MyWorkFlow->AddWorkFlow($BimarUserName, Auth::id(), $WorkFlowText);
                }
                if ($result->exists) {
                    $center = myappenv::CenterName;
                    $primary_key = $result->id;
                    $request_user = $result->BimarUserName;
                    $user_src = UserInfo::where('UserName', $request_user)->first();
                    $owner_mobile = $user_src->MobileNo;
                    $sms_text = "$center
                    درخواست شما در سامانه با شماره پیگیری $primary_key ثبت شد";
                    $my_sms = new SmsCenter;
                    $my_sms->OndemandSMS($sms_text, $owner_mobile, 'order', $request_user);

                    return redirect()->back()->with("success", __("success alert"));
                } else {
                    return redirect()->back()->with("error", __("The error has accure in your requsest please try again or call to callcenter!"));
                }
            }
        }
    }
}

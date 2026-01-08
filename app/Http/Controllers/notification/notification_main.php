<?php

namespace App\Http\Controllers\notification;

use App\APIS\SmsCenter;
use App\APIS\SMSDotIR;
use App\Functions\persian;
use App\Http\Controllers\Controller;
use App\Models\notification;
use App\Models\UserCreditModMeta;
use App\Models\UserInfo;
use App\Models\UserRole;
use App\myappenv;
use Illuminate\Http\Request;
use DB;
use Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Arr;
use PhpParser\Node\Stmt\Switch_;
use Symfony\Component\Console\Output\Output;

class notification_main extends Controller
{
    public function NotificationCenter(Request $request)
    {
        $data = [
            'status' => 11,
            'AckTime' => now()
        ];
        $resutl = notification::where('id', $request->input('delete'))->update($data);
        return redirect()->back()->with('success');
    }
    public static function hasnotification($UserName)
    {
        $data = [
            'status' => 1,
            'ViewTime' => now()
        ];
        notification::where('status', 0)->where('TargetUser', $UserName)->update($data);
        return notification::all()->where('status', '<', 10)->where('TargetUser', $UserName);
    }
    public function makenotification()
    {
        $UserRoles = UserRole::all();
        $UserCreditModMetas = UserCreditModMeta::all();
        if (Session::has('tempuserlist')) {
            $SelectedUser = Session::get('tempuserlist');
        } else {
            $SelectedUser = [];
        }

        return view('Notification.MakeNotification', ['SelectedUser' => $SelectedUser, 'UserCreditModMetas' => $UserCreditModMetas, 'UserRoles' => $UserRoles]);
    }
    public function CreateNotification($TargetUser, $Creator, $Continer, $AlertType)
    {
        $SaveData = [
            'TargetUser' => $TargetUser,
            'Creator' => $Creator,
            'Container' => $Continer,
            'AlertType' => $AlertType
        ];
        return notification::create($SaveData);
    }
    private function get_item_value($user_src, $select_item)
    {
        switch ($select_item) {
            case '%Name%':
                return $user_src->Name;
            case '%Family%':
                return $user_src->Family;
            case '%MobileNo%':
                return $user_src->MobileNo;

            default:
                return $select_item;
        }
    }
    private function send_sms_by_fast_list(Request $request)
    {
        if ($request->sms_code == null) {
            return redirect()->route('notifications')->with('error', ' کد ارسال سریع وارد نشده است');
        }

        if (Session::has('tempuserlist')) {
            $UserList = json_encode(Session::get('tempuserlist'));
            $sms_code = $request->sms_code;

            $sms_center = new SMSDotIR;
            $UserList = Session::get('tempuserlist');
            $UserSrc = UserInfo::whereIn('UserName', $UserList)->get();
            $mobile_list = [];
            foreach ($UserSrc as $UserItem) {

                /* $arr = [
                     [
                         "name" => "NAME",
                         "value" => $request_item->Name
                     ],
                     [
                         "name" => "PRODUCT",
                         "value" => substr($request_item->NameEn, 0, 24)
                     ]
                 ];*/
                $list_name = $request->list_name;
                $list_value = $request->list_val;
                $arr = [];
                foreach ($list_name as $list_name_index => $list_name_item) {
                    if ($list_name_item != null) {
                        $arr_item = [
                            'name' => $list_name_item,
                            'value' => $this->get_item_value($UserItem, $list_value[$list_name_index])
                        ];
                        array_push($arr, $arr_item);
                    }

                }
                $sms_center->manual_sms($arr, $UserItem->MobileNo, $request->sms_code);
            }
            // Session::forget('tempuserlist');
            return redirect()->route('notifications')->with('success', 'ارسال موفق!');
        }
        return redirect()->route('notifications')->with('error', 'لیست کاربران وارد نشده است');

    }

    public function Domakenotification(Request $request)
    {
        if ($request->ajax()) {
            if ($request->AjaxType == 'remove_user_from_list') {
                $UserList = Session::get('tempuserlist');
                $newuserlist = [];
                $Counter = 0;
                foreach ($UserList as $UserList_item) {
                    if ($UserList_item != $request->selected_user) {
                        array_push($newuserlist, $UserList_item);
                        $Counter++;
                    }
                }
                Session::put('tempuserlist', $newuserlist);
                return $Counter;
            }

            if ($request->AjaxType == 'get_saved_user_list') {
                $UserList = Session::get('tempuserlist');
                $UserSrc = UserInfo::whereIn('UserName', $UserList)->get();




                $Table_data = '';
                foreach ($UserSrc as $UserItem) {
                    $Table_data .= "
                    <tr id='row_$UserItem->UserName'>
                    <td>$UserItem->Name  $UserItem->Family </td>
                    <td>$UserItem->MobileNo </td>
                    <td>
                    <button id='btn_$UserItem->UserName' type='button' onclick='removeuser(" . '"' . $UserItem->UserName . '"' . ")' class='btn btn-danger'>حذف کاربر</button>
                    </td>
                </tr>
                    ";
                }

                $Output = '
                <div class="table-responsive">
                <table id="ul-contact-list" style="width:100%">
                    <thead>
                        <tr>
                            <th>کاربر</th>
                            <th>شماره تلفن</th>
                            <th>عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                       ' . $Table_data . '
                    </tbody>
    
                </table>
            </div>
                ';
                return $Output;
            }
        }
        if ($request->submit == 'list') {
            return $this->send_sms_by_fast_list($request);
        }
        if ($request->submit == 'send_sms') {
            $send_text = strip_tags($request->ce);
            if (Session::has('tempuserlist')) {
                $UserList = json_encode(Session::get('tempuserlist'));
                $AcceptKey = rand(1000, 100000);
                $record_with_has_same_accept_key = notification::where('AcceptKey', $AcceptKey)->first();
                while ($record_with_has_same_accept_key != null) {
                    $AcceptKey = rand(1000, 100000);
                    $record_with_has_same_accept_key = notification::where('AcceptKey', $AcceptKey)->first();
                }
                $send_text = str_replace('NNNN', $AcceptKey, $send_text);
                $notification_data = [
                    'UserList' => $UserList,
                    'AcceptKey' => $AcceptKey,
                    'Creator' => Auth::id(),
                    'Container' => $send_text,
                    'AlertType' => 20
                ];
                $insert_result = notification::create($notification_data);
                $notification_id = $insert_result->id;
                $my_sms = new SmsCenter;
                $UserList = Session::get('tempuserlist');
                $UserSrc = UserInfo::whereIn('UserName', $UserList)->get();




                $mobile_list = [];
                foreach ($UserSrc as $UserItem) {
                    array_push($mobile_list, $UserItem->MobileNo);
                }
                $my_sms->OndemandSMS($send_text, $mobile_list, 1, Auth::id());
                Session::forget('tempuserlist');
                return redirect()->route('notifications')->with('success', 'نوتیفیکیشن شماره ' . $notification_id . ' به سیستم اضافه شد! ');
            }
            //TODO:send sms by user and role
        }
        $result = $this->CreateNotification($request->input('UserName'), Auth::id(), $request->input('ce'), $request->input('NotificationMod'));
        if ($request->has('desk')) { // to return to user desk
            return redirect()->back()->with('success', 'نوتیفیکیشن شماره ' . $result->id . ' به سیستم اضافه شد! ');
        }
        return redirect()->route('notifications')->with('success', 'نوتیفیکیشن شماره ' . $result->id . ' به سیستم اضافه شد! ');
    }
    public function check_sms_is_notification_response($mobile_number, $sms_text)
    {
        $Query = "SELECT * from notifications  WHERE UserList is not null and  status < 100";
        $notification_src = DB::select($Query);
        $Persian = new persian;
        foreach ($notification_src as $notification_item) {
            if ($notification_item->AcceptKey != null) {
                $AcceptKey = $notification_item->AcceptKey;

                if (str_contains($sms_text, $AcceptKey)) {


                    if ($notification_item->extra == null) {
                        $main_extra = array();
                        $extra = array(
                            1,
                            [
                                'mobile_no' => $mobile_number,
                                'sms_text' => $sms_text,
                                'receive_time' => $Persian->MyPersianNow()
                            ]
                        );
                    } else {
                        $main_extra = json_decode($notification_item->extra);
                        $Count = count($main_extra);
                        $Count++;
                        $extra = array(
                            $Count,
                            [
                                'mobile_no' => $mobile_number,
                                'sms_text' => $sms_text,
                                'receive_time' => $Persian->MyPersianNow()
                            ]
                        );
                    }
                    array_push($main_extra, $extra);
                    $extra = json_encode($main_extra);
                    notification::where('id', $notification_item->id)->update(['extra' => $extra]);
                    return true;
                }
            }
        }
        return false;
    }



    public function notifications()
    {
        $Query = "SELECT n.*,ui.Name , ui.Family from notifications n inner join UserInfo ui on n.TargetUser  = ui.UserName  WHERE  n.status < 100";
        $Notificaions = DB::select($Query);
        $sms_notifications = notification::where('UserList', '!=', null)->where('status', '<', 100)->get();
        $trypearr = array();
        return view('Notification.NotificationList', ['Notificaions' => $Notificaions, 'sms_notifications' => $sms_notifications]);
    }
    public function Donotifications(Request $request)
    {
        if ($request->has('delete')) {
            $NotificationData = [
                'status' => 101
            ];
            notification::where('id', $request->input('delete'))->update($NotificationData);
            return redirect()->back()->with('success', 'نوتیفیکیشن شماره ' . $request->input('delete') . ' از سیستم حذف گردید!');
        }
    }
}

<?php
namespace App\hiring;

use App\Models\notification;

class hiring_workers_notifications extends hiring_main
{
    public function get_workers_notifications($username)
    {
        $notification_src = notification::where('status','<',100)->where('TargetUser',$username)->get();
        return $notification_src;
        $Query = "SELECT n.* from notifications n WHERE  n.status < 100 and  TargetUser = '$username'";
        $Notificaions = DB::select($Query);
        $sms_notifications = notification::where('UserList', '!=', null)->where('status', '<', 100)->get();
        $trypearr = array();
    }

    public function get_worker_dashboard_notifications($username)
    {
        $notifications = [];
        $notification_item = [
            'type' => 'success',
            'msg' => 'تنظیمات انجام شد!',
        ];
        array_push($notifications, $notification_item);
        $notification_item = [
            'type' => 'danger',
            'msg' => 'تنظیمات انجام شد!',
        ];
        array_push($notifications, $notification_item);
        return $notifications;
    }

}
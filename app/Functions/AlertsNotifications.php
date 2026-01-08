<?php


namespace App\Functions;


use App\Models\UserInfo;
use App\myappenv;
use Illuminate\Support\Facades\Auth;
use Session;

class AlertsNotifications
{
    private function CheckShafatelCustomers()
    {
        $result = UserInfo::where("branch", myappenv::shafatelunmanagedcustomers)->get();
        Session::put('shafatelunmanagedcustomers', $result->count());
    }
    private function CheckOwnerCustomers(){
        $result = UserInfo::where("branch", Auth::user()->branch )->get();
        Session::put('shafatelunmanagedcustomers', $result->count());

    }

    public function MyNotification($UserName, $Role)
    {
        if (myappenv::CoustomerType == 'Partner') {
            $this->CheckShafatelCustomers();
        }
        if (myappenv::CoustomerType == 'Owner') {
            $this->CheckOwnerCustomers();
        }
    }

}

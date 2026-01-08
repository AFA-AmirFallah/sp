<?php

namespace App\hiring;

use App\Models\product_order;
use App\Models\UserInfo;
use App\myappenv;
use Illuminate\Support\Facades\DB;

class hiring_reporting extends hiring_main
{
    //private $buy_profile_price = 500000;
    private $buy_profile_price = 20000;
    public function check_customer_buy_worker_profile_before($profile_id, $customer)
    {
        $customer_profile = product_order::where('ServiceContract', 1)->where('status', 100)->where('CustomerId', $customer)->where('VirtualContract', $profile_id)->whereDate('expire_date', '>', now())->count();
        if ($customer_profile > 0) {
            return true;
        }
        return false;
    }

    public function buy_profile($profile_id, $buyer, $expire_days)
    {
        $OrderPreData = [
            'status' => 0,
            'ReturnCustomerId' => $buyer,
            'CustomerId' => $buyer,
            'SendLocation' => 0,
            'ReturnLocation' => 0,
            'ServiceContract' => 1,
            'total_sales' => $this->buy_profile_price,
            'expire_date' => now()->addDays($expire_days),
            'VirtualContract' => $profile_id
        ];
        $ProductOrderInsertResult = product_order::create($OrderPreData);
        return $ProductOrderInsertResult->id;

    }
    public function find_worker_by_code($code, $one_row = false)
    {
        if ($one_row) {
            $staff_src = UserInfo::where('Ext', $code)->where('Role', myappenv::role_worker)->first();
        } else {
            $staff_src = UserInfo::where('Ext', $code)->where('Role', myappenv::role_worker)->get();
        }
        return $staff_src;
    }
    public function find_worker_by_mobile_no($PhoneNumber)
    {
        $worker_role = myappenv::role_worker;
        $Query = "select * from UserInfo where Role = $worker_role and ( MobileNo = '$PhoneNumber' or Phone1 = '$PhoneNumber' or Phone2 = '$PhoneNumber')";
        $staff_src = DB::select($Query);
        return $staff_src;
    }

}
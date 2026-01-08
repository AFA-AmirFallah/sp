<?php

namespace App\Order;

use App\Models\catorder;
use App\myappenv;
use Auth;
use DB;

class OrderClass
{

    public function get_center_order_list()
    {
        if (!Auth::check()) {
            return [];
        }

        $user_branch = Auth::user()->branch;
        $UserName = Auth::id();
        if (myappenv::version >= 3) {
            $Query = "SELECT catorder.* , branch_cat_orders.MainDescription as center_desc , branch_cat_orders.max_price ,
             branch_cat_orders.used , branch_cat_orders.rank,branch_cat_orders.extra_info , addo.id as orderid
             FROM branch_cat_orders INNER JOIN catorder on branch_cat_orders.catorder = catorder.id and branch_cat_orders.branch = 5 and branch_cat_orders.OnSale = 1
            LEFT JOIN addorder1 as addo on  catorder.id = addo.CatID and addo.UserName = '$UserName' and addo.Status < 100";
        } else {
            $Query = "SELECT co.* , addo.id as orderid from catorder as co LEFT JOIN addorder1 as addo on  co.id = addo.CatID and addo.UserName = '$UserName' and addo.Status < 100 WHERE co.branch = $user_branch ";
        }
        $orders_src = DB::select($Query);
        return $orders_src;
    }

    public function get_active_orders()
    {
        if (!Auth::check()) {
            return [];
        }
        $user_branch = Auth::user()->branch;
        $UserName = Auth::id();

        $Query = "select catorder.* , orderstatus.status as StatusName , addorder1.CreateDate as regdate  , branches.Description as branch_desc , branches.avatar as branch_avatar
        from catorder 
        inner join addorder1 on catorder.id = addorder1.CatID 
        inner join orderstatus on  addorder1.Status = orderstatus.ID 
        inner join branches on addorder1.branch = branches.id
        where addorder1.UserName = '$UserName' and addorder1.Status < 100  ";
        $orders_src = DB::select($Query);
        return $orders_src;
    }
}

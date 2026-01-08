<?php

namespace App\Functions;

use App\Http\Controllers\woocommerce\product;
use App\Models\activeshift;
use App\Models\branchs_order;
use App\Models\catorder;
use App\Models\DeviceContract;
use App\Models\entrance_personel;
use App\Models\goods;
use App\Models\L2Work;
use App\Models\L3Work;
use App\Models\mobile_banner;
use App\Models\posts;
use App\Models\store;
use App\Models\TicketMain;
use App\myappenv;
use Illuminate\Support\Facades\Auth;
use DB;
use Cache;

class DashboardClass
{
    public function OpenOrders()
    {
        $UserBranch = Auth::user()->branch;
        $resutl = branchs_order::where('branch', $UserBranch)->where('order_status', 1)->count();
        return ($resutl);
    }
    
    public function GetL2Index($MainMenu)
    {
        $MainMenu = json_decode($MainMenu);
        $Cats =  L2Work::where('WorkCat', $MainMenu->WorkCat)->where('L1ID', $MainMenu->L1ID)->get();
        return $Cats;
    }
    public function GetSameLevelIndex($IndexId, $LimtRow = null)
    {
        $target_index_src = L3Work::where('UID',$IndexId)->first();
        $WorkCat = $target_index_src->WorkCat;
        $L1ID = $target_index_src->L1ID;
        $L2ID = $target_index_src->L2ID;
        return L3Work::where('WorkCat',$WorkCat)->where('L1ID',$L1ID)->where('L2ID',$L2ID)->limit($LimtRow)->get();
    }
    public function GetProductListFromIndex($IndexId, $LimtRow = null)
    {
        $MyProduct = new product();
        return $MyProduct->GetProducts($IndexId, null, true, $LimtRow);
    }
    public function GetUnReadCommnets()
    {
        return 10;
    }

    public function GetTotallActiveNews()
    {
        $ActivePostCount = posts::where('Status', 1)->count();
        return ($ActivePostCount);
    }
    public function GetTotallActiveShop()
    {
        return store::where('Status', 1)->count();
    }
    public function GetTotallActiveUsers($branch)
    {
        if ($branch == myappenv::Branch) {
            $condition = '';
        } else {
            $condition = " and UserInfo.branch = $branch ";
        }
        $Query = "SELECT count(*) as count_rows FROM entrance_personels INNER JOIN UserInfo on entrance_personels.UserName = UserInfo.UserName WHERE   DATE_FORMAT(entrance_personels.WorkingDate, '%Y-%m-%d')  = CURDATE() and entrance_personels.exittime is null $condition ";
        $result = DB::select($Query);
        foreach($result as $result_item){
            return $result_item->count_rows;
        }
       
    }
    public function GetTotallActiveShift()
    {
        return activeshift::where('RespnsType', '>', 0)->where('RespnsType', '<', 10000)->count();
    }
    public function GetTotallWorkFlow()
    {
        return TicketMain::where('State', '10001')->count();
    }
    public function GetTotallRentDevice()
    {
        return 0;
        //todo add function
    }
    public function GetTotallOrders()
    {
        return catorder::where('Status', 1)->count();
    }
    public function GetTotallSmartInvoice()
    {
        return DeviceContract::where('DeletedDate', null)->count();
    }

    public function Last24Users()
    {
        $user_branch = Auth::user()->branch;
        if($user_branch == myappenv::Branch){
            $Query = "SELECT UserInfo.UserName , UserInfo.Name , UserInfo.Family , UserInfo.MobileNo , branches.Name as BranchName FROM UserInfo INNER JOIN branches on UserInfo.branch = branches.id WHERE CreateDate >= CURDATE() AND CreateDate < CURDATE() + INTERVAL 1 DAY";

        }else{
            $Query = "SELECT  UserInfo.UserName ,UserInfo.Name , UserInfo.Family , UserInfo.MobileNo , branches.Name as BranchName FROM UserInfo INNER JOIN branches on UserInfo.branch = branches.id WHERE branches.id = $user_branch AND CreateDate >= CURDATE() AND CreateDate < CURDATE() + INTERVAL 1 DAY";
        }
        $Resutl = DB::select($Query);
        return $Resutl;
    }
    public function Last7DaysUsers()
    {
        $Query = "SELECT  UserInfo.UserName ,UserInfo.Name , UserInfo.Family , UserInfo.MobileNo , branches.Name as BranchName FROM UserInfo INNER JOIN branches on UserInfo.branch = branches.id WHERE CreateDate >= CURDATE() AND CreateDate < CURDATE() + INTERVAL 7 DAY";
        $Resutl = DB::select($Query);
        return $Resutl;
    }

    public function GetPageTitr($PageID)
    {

        $Target = mobile_banner::where('page', $PageID)->where('theme', 5)->where('status', 1)->first();
        if ($Target == null) {
            if (myappenv::DefultPageTitr != null) {
                return myappenv::DefultPageTitr;
            } else {
                return null;
            }
        } else {
            return $Target->title;
        }
    }
}

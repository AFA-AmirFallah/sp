<?php

namespace App\Http\Controllers\WPA;

use App\Functions\DashboardClass;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Functions\Orders;
use App\Http\Controllers\setting\debuger;
use App\Models\catorder;
use App\Models\mobile_banner;
use App\myappenv;
use DB;

class pages extends Controller
{
    public function Page($id, $PageName = null)
    {
        /*
        if (myappenv::Lic['wpa']) {
            $Query = "SELECT theme from mobile_banner mb WHERE  status  =  1 and page = $id group by theme ";
            $ElementsTypes = DB::select($Query);
            $PagesObjects = array();
            foreach ($ElementsTypes as $ElementsTypesItem) {
                array_push($PagesObjects, $ElementsTypesItem->theme);
            }
            if (empty($PagesObjects)) {
                return abort('404', 'لینک مورد نظر وجود ندارد');
            }
            $mobile_banners = mobile_banner::where('status', 1)->where('page', $id)->orderBy('theme')->get();
            return view("PWAPages.PWAPages", ['PagesObjects' => $PagesObjects, 'mobile_banners' => $mobile_banners]);
        } */
        /**
         * 
         */
        if (Auth::check()) {
            $OrderClass = new Orders();
            $MyOrders = $OrderClass->ViewOrders(Auth::id(), Auth::user()->Role);
        } else {
            if (myappenv::Lic['wpa']) {
                $MyOrders = [];
            } else {
                return route('login');
            }
        }
        $CatOrder = catorder::all()->where('Branch', myappenv::CustomerOrderBranch);
        if (myappenv::Lic['wpa']) {
            $Query = "SELECT theme from mobile_banner mb WHERE  status  =  1 and page = $id group by theme ";
            $ElementsTypes = DB::select($Query);
            $PagesObjects = array();
            foreach ($ElementsTypes as $ElementsTypesItem) {
                array_push($PagesObjects, $ElementsTypesItem->theme);
            }
            $mobile_banners = mobile_banner::where('status', 1)->where('page', $id)->orderBy('order', 'ASC')->get();
            $DashboardClass = new DashboardClass();
            $Titr = $DashboardClass->GetPageTitr($id);
            if ($PageName != $Titr) {
                return redirect()->route('Page', ['id' => $id, 'PageName' => $Titr]);
            }
            if (debuger::DebugEnable()) {
                return view("Site.wolmart.MainPage", ['page' => 'MainPage', 'DashboardClass' => $DashboardClass, 'PagesObjects' => $PagesObjects, 'CatOrders' => $CatOrder, 'MyOrders' => $MyOrders, 'mobile_banners' => $mobile_banners]);
            }
            return view("Dashboard.DashboardCustomerWPA", ['page' => $id, 'DashboardClass' => $DashboardClass, 'PagesObjects' => $PagesObjects, 'CatOrders' => $CatOrder, 'MyOrders' => $MyOrders, 'mobile_banners' => $mobile_banners]);
        } else {
            $DashboardClass = new DashboardClass();
            return view("Dashboard.DashboardCustomer", ['page' => $id, 'DashboardClass' => $DashboardClass, 'CatOrders' => $CatOrder, 'MyOrders' => $MyOrders]);
        }
    }
    public function doPage($id, Request $request)
    {
    }
}

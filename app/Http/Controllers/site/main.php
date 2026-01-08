<?php

namespace App\Http\Controllers\site;

use App\Functions\DashboardClass;
use App\Http\Controllers\Controller;
use App\Models\L3Work;
use App\Models\mobile_banner;
use App\myappenv;
use Illuminate\Http\Request;
use DB;
use PhpParser\Node\Stmt\StaticVar;

class main extends Controller
{

    public function mainpage()
    {
        $Query = "SELECT theme from mobile_banner mb WHERE  status  =  1 and page = 1 group by theme ";
        $ElementsTypes = DB::select($Query);
        $PagesObjects = array();
        foreach ($ElementsTypes as $ElementsTypesItem) {
            array_push($PagesObjects, $ElementsTypesItem->theme);
        }
        $DashboardClass = new DashboardClass();

        $mobile_banners = mobile_banner::where('status', 1)->where('page', 1)->orderBy('order')->get();
        return view('Site.wolmart.MainPage', ['DashboardClass' => $DashboardClass, 'PagesObjects' => $PagesObjects, 'page' => 'MainPage', 'mobile_banners' => $mobile_banners]);
    }
    public static function GetSiteElemet($Page, $Theme)
    {
        return mobile_banner::where('status', 1)->where('page', $Page)->where('theme', $Theme)->orderBy('order')->get();
    }
    public function productlist()
    {
        return view('Site.wolmart.ProductList', ['page' => 'ProductList']);
    }
    public static function GetProductBrands($ProductId = null)
    {
        

        return L3Work::all()->where('WorkCat', myappenv::Product‌BrandsMain['WorkCat'])->where('L1ID', myappenv::Product‌BrandsMain['L1ID'])->where('L2ID', myappenv::Product‌BrandsMain['L2ID']);
    }
    public static function theme5_shop_side_menu()
    {

        $Query = "SELECT lw2.Name as meta_name , lw.* from L3Work lw inner join L2Work lw2 on lw.WorkCat = lw2.WorkCat and lw.L1ID = lw2.L1ID = 1 and lw.L2ID = lw2.L2ID WHERE lw.WorkCat = 3 and lw.L1ID = 1 order by lw2.L2ID";
        $side_menu_src = DB::select($Query);
        return $side_menu_src;
    }



    public static function GetProductCategury($ProductId = null)
    {
        return L3Work::all()->where('WorkCat', myappenv::ProductCateguryMain['WorkCat'])->where('L1ID', myappenv::ProductCateguryMain['L1ID'])->where('L2ID', myappenv::ProductCateguryMain['L2ID']);
    }
}

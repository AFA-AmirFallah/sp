<?php

namespace App\Http\Controllers\WPA;

use App\Functions\Orders;
use App\Http\Controllers\Controller;
use App\Models\catorder;
use App\Models\L1Work;
use App\Models\L2Work;
use App\Models\L3Work;
use App\Models\mobile_banner;
use App\Models\WorkCat;
use App\myappenv;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RenderViews extends Controller
{
    public function ShowCats($workcat, $L1Work = null, $L2Work = null, $L3Work = null)
    {
        $mobile_banners = mobile_banner::all()->where('status', 1);
        if ($L1Work != null && $L2Work != null && $L3Work != null) {
            $Cats = L3Work::all()->where('WorkCat', $workcat)->where('L1ID', $L1Work)->where('L2ID', $L2Work)->where('L3ID', $L3Work);
            return view("CustomersViews.ShowCats", ['Cats' => $Cats, 'mobile_banners' => $mobile_banners]);
        } elseif ($L1Work != null && $L2Work != null && $L3Work == null) {
            $Cats = L3Work::all()->where('WorkCat', $workcat)->where('L1ID', $L1Work)->where('L2ID', $L2Work);
            return view("CustomersViews.ShowCats", ['Cats' => $Cats, 'mobile_banners' => $mobile_banners, 'route' => "Totarget"]);
        } elseif ($L1Work != null && $L2Work == null && $L3Work == null) {
            $Cats = L2Work::all()->where('WorkCat', $workcat)->where('L1ID', $L1Work);
            return view("CustomersViews.ShowCats", ['Cats' => $Cats, 'mobile_banners' => $mobile_banners, 'route' => "ToL3"]);
        } elseif ($L1Work == null && $L2Work == null && $L3Work == null) {
            $Cats = L1Work::all()->where('WorkCat', $workcat);
            return view("CustomersViews.ShowCats", ['Cats' => $Cats, 'mobile_banners' => $mobile_banners, 'route' => "ToL2"]);
        } else {
            return abort('404');
        }
    }
    public function DoShowCats(Request $request, $workcat, $L1Work = null, $L2Work = null, $L3Work = null)
    {
    }
    public function CustomerServices()
    {
        if (Auth::check()) {
            $OrderClass = new Orders();
            $MyOrders = $OrderClass->ViewOrders(Auth::id(), Auth::user()->Role);
        } else {
            $MyOrders = [];
        }
        $CatOrder = catorder::all()->where('Branch', myappenv::CustomerOrderBranch);
        $Cats =  L3Work::all()->where('WorkCat', myappenv::CatsToOffer_workcat)->where('L1ID', myappenv::CatsToOffer_L1)->where('L2ID', myappenv::CatsToOffer_L2);
        $mobile_banners = mobile_banner::all()->where('status', 1);
        $Services = L3Work::all()->where('WorkCat', myappenv::ServiceToOffer_workcat)->where('L1ID', myappenv::ServiceToOffer_L1)->where('L2ID', myappenv::ServiceToOffer_L2);
        return view('CustomersViews.CustomerServices', ['mobile_banners' => $mobile_banners, 'Services' => $Services, 'CatOrders' => $CatOrder, 'Cats' => $Cats]);
    }
    public function DoCustomerServices()
    {
    }
}

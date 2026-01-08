<?php

namespace App\Http\Controllers\search;

use App\Functions\ConsultClass;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Credit\currency;
use App\Http\Controllers\moshavereh\main;
use App\Http\Controllers\woocommerce\product;
use App\Models\goods;
use App\Models\L2Work;
use App\Models\L3Work;
use App\myappenv;
use Session;
use Illuminate\Http\Request;

class MainSearch extends Controller
{
    private $searchtext;
    public function search(Request $request)
    {
        $q = $request->input('q');
        $this->searchtext = $q;
        $MyProduct = new product();

        if ($request->ajax()) {
            $Goods = $MyProduct->SearchProductsV1(null, $this->searchtext);
            $theme = myappenv::ShopTheme;

            $management = $MyProduct->is_management_login();
            return view("Layouts.$theme.objects.ProductListFeilds", ['Goods' => $Goods, 'management' => $management, 'MyProduct' => $MyProduct])->render();
            return response()->json($Goods);
        }
        if ($request->has('q')) {

            $q = $request->input('q');
            $this->searchtext = $q;

            $Carrency = new currency();
            $SessionArray = json_decode(Session::get('basket'));
            $BuyArray = array();
            if (isset($SessionArray)) {
                foreach ($SessionArray as $SessionArrayTarget) {
                    array_push($BuyArray, $SessionArrayTarget[0]);
                }
            }
            $TagName = 'جستجو';
            $MyProduct = new product();
            //$Goods = $MyProduct->GetSrachedProductsByName($q, null);
            $Goods = [];
            $SearchArray = [];
            $SiteElements = new main();
            $theme = myappenv::ShopTheme;
            $matas = L2Work::where('WorkCat', 4)->where('L1ID', 1)->get();
            $Cats = L3Work::where('WorkCat', 4)->where('L1ID', 1)->where('L2ID', null)->orderBy('L3ID')->get();
            return view("Layouts.$theme.ProductList", ['post_src'=>null, 'matas' => $matas, 'Tags' => null, 'Cats' => $Cats, 'searchstr' => $q, 'SearchArray' => $SearchArray, 'TagName' => $TagName, 'SiteElements' => $SiteElements, 'Carrency' => $Carrency, 'Goods' => $Goods, 'BuyArray' => $BuyArray]);

        }
        if ($request->has('M')) {
            $M = $request->input('M');
            $this->searchtext = $M;
            $TagName = 'جستجو';
            $Consult = new ConsultClass;
            $searchtext = $this->searchtext;
            $MyConsult = $Consult->get_serach_consult($this->searchtext);
            return view('Layouts.Moshavereh.Reservationlist', ['Consult' => $Consult, 'searchtext' => $searchtext]);
        } else {
            return abort('404', 'صفحه مورد نظر یافت نشد!');
        }
    }
}

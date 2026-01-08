<?php

namespace App\Http\Controllers\cashier;

use App\Functions\cashierClass;
use App\Functions\Orders;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class cashier extends Controller
{
    public function cashier(Request $request)
    {

        if ($request->ajax()) {
            if ($request->has('data')) {
                $TargetPage = $request->input('page');
                $Data = $request->input('data');
                $cashier = new cashierClass();
                $returnHTML = view('cashier.Layouts.' . $TargetPage, ['cashier' => $cashier, 'Data' => $Data])->render();
                return $returnHTML;
            } elseif ($request->has('page')) {
                $TargetPage = $request->input('page');
                $cashier = new cashierClass();
                $returnHTML = view('cashier.Layouts.' . $TargetPage, ['cashier' => $cashier])->render();
                return $returnHTML;
            }
        }
        return view('cashier.cashier_main');
    }

    public function Docashier(Request $request)
    {
        $cashier = new cashierClass();
        if ($request->has('procedure')) {
            $procedure = $request->input('procedure');
            switch ($procedure) {
                case 'search':
                    $ProductList = $cashier->SearchProduct($request->input('searchtext'));
                    return view('cashier.Layouts.ProductTable', ['ProductList' => $ProductList])->render();
                case 'addtobasket':
                    $ProductId = $request->input('ProductID');
                    $Qty = $request->input('Qty');
                    $Pw_id = $request->input('Pw_id');
                    $ProductList = $cashier->AddToBasket($ProductId, $Qty, $Pw_id);
                    $Order = new Orders();
                    if ($request->has('Tashim')) {
                        $Tashim = $request->input('Tashim');
                        $Order->put_tashim($ProductId, $Pw_id, $Tashim);
                    }
                    return $ProductList;
                case 'FindProductTashim':
                    $Pw_id = $request->input('Pw_id');
                    $ProductId = $request->input('ProductID');
                    $row = $request->input('row');
                    $ProductList = $cashier->get_Product_tashims($Pw_id);
                    return view('cashier.Layouts.but_continner', ['ProductList' => $ProductList, 'row' => $row, 'ProductId' => $ProductId])->render();
                case 'clearorder':
                    $ProductList = $cashier->clear_order();
                    return true;
                case 'definecustomer':
                    $UserName = $request->input('UserName');
                    $result = $cashier->definecustomer($UserName);
                    return $result;
                case 'removeCustomer':
                    $cashier->removeCustomer();
                    return true;
                case 'removeitem':
                    $ProductId = $request->input('ProductID');
                    $cashier->removeitem($ProductId);
                    return true;
                case 'finalyze':
                    $resultItem = $cashier->finalyze();
                    return $resultItem;
            }
        }
    }
}

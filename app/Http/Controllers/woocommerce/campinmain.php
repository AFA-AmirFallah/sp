<?php

namespace App\Http\Controllers\woocommerce;

use App\Functions\campinsclass;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class campinmain extends Controller
{
    public function AddCampin()
    {

        return view('woocommerce.admin.AddCampin');
    }
    public function DoAddCampin(Request $request)
    {
        $MyCampain = new campinsclass();
        $Name = $request->input('Name');
        $buget = $request->input('buget');
        $Description = $request->input('Description');
        $StartDate = $request->input('StartDate');
        $ExprireDate = $request->input('ExprireDate');
        $result = $MyCampain->create_campin_meta($Name, $Description, $buget, $ExprireDate, $StartDate, Auth::id());
        $result = "کمپین شماره " . $result . " افزوده شد!";
        return redirect()->back()->with('success', $result);
    }
    public function CampinLsit(Request $request)
    {
        if ($request->ajax()) {
            if ($request->has('data')) {
                $TargetPage = $request->input('page');
                $Data =  $request->input('data');
                $campains = new campinsclass();
                $returnHTML = view('woocommerce.admin.' . $TargetPage, ['campains' => $campains, 'Data' => $Data])->render();
                return $returnHTML;
            } elseif ($request->has('page')) {
                $TargetPage = $request->input('page');
                $campains = new campinsclass();
                $returnHTML = view('woocommerce.admin.' . $TargetPage, ['campains' => $campains])->render();
                return $returnHTML;
            }
        }

        return view('woocommerce.admin.CampinMain');
    }
    public function DoCampinLsit()
    {
    }
}

<?php

namespace App\Http\Controllers\Office;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;

class entrance extends Controller
{
    public function entrance()
    {
        if (Session::has('Entrance') && Session::get('Entrance')) {
            $MyEntrance = new \App\Functions\Entrance();
            $Result = $MyEntrance->ExitSave(Auth::id());
            if ($Result) {
                Session::put('Entrance', null);
                return redirect()->back()->with('scuccess', 'ثبت خروج انجام گرفت');
            } else {
                return redirect()->back()->with('error', 'اختلال در ثبت خروجی');
            }

        } else {
            $MyEntrance = new \App\Functions\Entrance();
            $Result = $MyEntrance->SaveEntrance(Auth::id());
            if ($Result) {
                Session::put('Entrance', true);
                return redirect()->back()->with('scuccess', 'ثبت ورودی انجام گرفت');
            } else {
                return redirect()->back()->with('error', 'اختلال در ثبت ورودی');
            }
        }

    }

    public function Doentrance()
    {

    }
}

<?php

namespace App\Http\Controllers\Credit;

use App\Http\Controllers\Controller;
use App\myappenv;
use Illuminate\Http\Request;
use Session;

class currency extends Controller
{
    public function SetCurrency(Request $request )
    {
        $Currency = $request->input('Currency');
        if ($Currency == 'Rial') {
            Session::put('currencyName', 'Rial');
        }elseif ($Currency == 'Toman') {
            Session::put('currencyName', 'Toman');
        }

        return redirect()->back();
    }
    public static function GetCurrency()
    {
        if (Session::has('currencyName')) {
            $currencyName = Session::get('currencyName');
            if ($currencyName == 'Rial') {
                return 'ریال';
            } elseif ($currencyName == 'Toman') {
                return 'تومان';
            }
        } else {
            return myappenv::CurrencyName;
        }
    }
    public static function GetCurrencyRate()
    {
        if (Session::has('currencyName')) {
            $currencyName = Session::get('currencyName');
            if ($currencyName == 'Rial') {
                return 1;
            } elseif ($currencyName == 'Toman') {
                return 10;
            }
        } else {
            return myappenv::CurrencyRate;
        }
    }
}

<?php

namespace App\Http\Controllers\Crypto;

use App\Functions\TextClassMain;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Credit\currency as CreditCurrency;
use App\Models\Candeles;
use App\Models\CoinBackTest;
use App\Models\Currency;
use App\Models\metadata;
use App\Models\requests;
use Illuminate\Http\Request;
use Auth;
use DB;

class CryptoAdmin extends Controller
{
    public function ExDif()
    {
        $kucoinSrc = metadata::where('tt', 'kucoin')->where('meta_key', 'Stimestamp')->first();
        $kocoinTimeStamp = $kucoinSrc->meta_value;
        $CoinexSrc = metadata::where('tt', 'coinex')->where('meta_key', 'Stimestamp')->first();
        $coinexTimeStamp = $CoinexSrc->meta_value;
        $Query = "SELECT cu.* , ku.price as ku_price , co.price as co_price , abs( (ku.price - co.price) *100 /ku.price ) as ku_co  FROM crypto_price_1ms as ku INNER JOIN crypto_price_1ms_coinexes as co on ku.curency = co.curency and ku.timestamp = $kocoinTimeStamp and  co.timestamp = $coinexTimeStamp
        inner join currencies as cu on cu.symbol = ku.curency
        ORDER BY ku_co  DESC";
        $Curencys = DB::select($Query);
        return view('Crypto/Admin/ExDif', ['Curencys' => $Curencys]);
    }
    public function DoExDif()
    {
    }
    public function CurencyList()
    {
        $Curencys = Currency::all();
        return view('Crypto/Admin/CurencyList', ['Curencys' => $Curencys]);
    }
    public function DoCurencyList(Request $request)
    {
        if ($request->submit == 'updatecurencys') {
            $kuCoin = new kucoin();
            $result = $kuCoin->Update_symbols();
            return redirect()->back()->with('success', 'به روز رسانی موفق!');
        }
    }
    public function CurencyProfile($RequestCurency)
    {
        $CurncySrc = Currency::where('id', $RequestCurency)->first();
        $CryptoCandeles = Candeles::where('curency', $RequestCurency)->count();
        $Backtest = CoinBackTest::where('curency', $CurncySrc->MainName)->where('owner', Auth::id())->where('status', '<', 100)->first();
        if ($CurncySrc == null) {
            return abort('404', 'ارز مورد نظر در سامانه موجود نیست!');
        }
        return view('Crypto/Admin/CurencyProfile', ['CurncySrc' => $CurncySrc, 'CryptoCandeles' => $CryptoCandeles, 'Backtest' => $Backtest]);
    }
    public function DoCurencyProfile($RequestCurency, Request $request)
    {
        $CurncySrc = Currency::where('id', $RequestCurency)->first();
        $kuCoin = new kucoin();
        if ($request->submit == 'backtest') {

            $result = Currency::where('id', $RequestCurency)->first();
            $BT = new backtest;
            $DoneJob = $BT->AddUserBacktest(Auth::id(), $result->MainName);
            if ($DoneJob) {
                return redirect()->back()->with('success', 'بک تست افزوده شد');
            } else {
                return redirect()->back()->with('error', 'افزودن بک تست به مشکل برخود کرد!');
            }
        }
        if ($request->submit == 'activate') {
            $result = Currency::where('id', $RequestCurency)->update(['status' => 10]);
            if ($result) {
                return redirect()->back()->with('success', 'به روز رسانی موفق!');
            } else {
                return redirect()->back()->with('error', 'به روز رسانی نا موفق!');
            }
        }
        if ($request->submit == 'deactive') {
            $result = Currency::where('id', $RequestCurency)->update(['status' => 20]);
            if ($result) {
                return redirect()->back()->with('success', 'به روز رسانی موفق!');
            } else {
                return redirect()->back()->with('error', 'به روز رسانی نا موفق!');
            }
        }
        if ($request->submit == 'addcandel') {
            $result = $kuCoin->save_candels($CurncySrc->MainName, $RequestCurency, '1day');
            if ($result) {
                return redirect()->back()->with('success', 'به روز رسانی موفق!');
            } else {
                return redirect()->back()->with('error', 'به روز رسانی نا موفق!');
            }
        }
        if ($request->submit == 'renewcandel') {
            Candeles::where('curency', $RequestCurency)->delete();
            $result = $kuCoin->save_candels($CurncySrc->MainName, $RequestCurency, '1day');
            if ($result) {
                return redirect()->back()->with('success', 'به روز رسانی موفق!');
            } else {
                return redirect()->back()->with('error', 'به روز رسانی نا موفق!');
            }
        }
        if ($request->submit == 'updatebaseinfo') {
            $result = Currency::where('id', $RequestCurency)->update(['FaName' => $request->Name, 'ENName' => $request->ENName]);
            if ($result) {
                return redirect()->back()->with('success', 'به روز رسانی موفق!');
            } else {
                return redirect()->back()->with('error', 'به روز رسانی نا موفق!');
            }
        }
        if ($request->input('submit') == 'UpdateIMG') {
            if ($request->file('avatar')) {
                $request->validate([
                    'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                ]);
                $Mytext = new TextClassMain();
                $avatarName = $Mytext->StrRandom() . '.' . request()->avatar->getClientOriginalExtension();
                $request->avatar->storeAs('public/avatar', $avatarName);
                $avatarName = url('/') . '/storage/avatar/' . $avatarName;
                $InfoResult = Currency::where('id', $RequestCurency)->update(['pic' => $avatarName]);
                return redirect()->back();
            }
        }
    }
}

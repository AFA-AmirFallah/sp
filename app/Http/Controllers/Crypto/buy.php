<?php

namespace App\Http\Controllers\Crypto;

use App\Http\Controllers\Controller;
use App\Models\addorder1;
use App\Models\Currency;
use App\Models\provinces;
use App\Models\UserInfo;
use Illuminate\Http\Request;
use DB;
use Auth;

class buy extends Controller
{
    public function wizard_ex($CoinId)
    {
        $coin_src = Currency::where('MainName', $CoinId)->first();
        if ($coin_src == null) {
            return abort('404', 'ارز درخواست شده وجود ندارد!');
        }
        $province = provinces::all();
        return view('Theme2.wizard_ex_checkout', ['coin_src' => $coin_src, 'province' => $province]);
    }
    public function do_wizard_ex(Request $request, $CoinId)
    {
        if ($request->ajax()) {
            if ($request->AjaxType == 'save_order') {
                $coins = $request->coins;
                $save_sum_price = $request->sum_price;
                $save_coin_price = $request->unit_price;
                $sarafi_id = $request->sarafi_id;
                $DataInput = [
                    'CoinId' => $CoinId,
                    'Count' => $coins,
                    'unit_price' => $save_coin_price,
                    'sum_price' => $save_sum_price
                ];

                $DataSource = [
                    'UserName' => $sarafi_id,
                    'BimarUserName' => Auth::id(),
                    'CatID' => '5',
                    'CreateDate' => now(),
                    'Status' => '1',
                    'Address' => '',
                    'Extranote' => json_encode($DataInput),
                    'branch' => 1
                ];
                $result = addorder1::create($DataSource);
                $sarafi_src = UserInfo::where('UserName', $sarafi_id)->first();
                $DataInput = [
                    'CoinId' => $CoinId,
                    'Count' => $coins,
                    'unit_price' => $save_coin_price,
                    'sum_price' => $save_sum_price
                ];
                return view('Theme2.Layouts.checkout_order', ['result' => $result, 'sarafi_src' => $sarafi_src ,'DataInput'=>$DataInput ])->render();
                return $result->id;
            }
            if ($request->AjaxType == 'sarafi_list') {
                $city = $request->city;
                $sarafi_src = UserInfo::where('Role', 99)->where('city', $city)->get();
                return view('Theme2.Layouts.sarafi_list', ['sarafi_src' => $sarafi_src])->render();
            }
            if ($request->AjaxType == 'convert') {
                $coins_request = $request->coins;
                /*----------------------
                $sum_price = 500 * $coins_request;
                return [
                    'result' => true,
                    'coin_price' => 500,
                    'sum_price' => $sum_price,
                    'offerable' => true
                ];
                */
                //TODO:change by online price
                $query = "SELECT * FROM crypto_price_24hs 
                WHERE DATE_FORMAT(crypto_price_24hs.candate, '%Y-%m-%d') = CURDATE() and crypto_price_24hs.curency = '$CoinId' ";
                $today_src = DB::select($query);
                if ($today_src == null) {
                    return [
                        'result' => false,
                        'msg' => 'اطلاعات ارز درخواستی در سیستم موجود نیست!'
                    ];
                }
                foreach ($today_src as $today_item) {
                    $last_price = $today_item->ClosePrice;
                }
                $sum_price = $last_price * $coins_request;
                return [
                    'result' => true,
                    'coin_price' => $last_price,
                    'sum_price' => $sum_price,
                    'offerable' => true
                ];
            }
        }
    }
}

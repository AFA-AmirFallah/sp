<?php

namespace App\Http\Controllers\Crypto;

use App\Crypto\CryptoAlerts;
use App\Crypto\CryptoFormola_1;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserInfo;
use Auth;
use App\Crypto\CryptoFunctions;
use App\Crypto\LineProcess;
use App\Models\CoinBackTest;
use App\Models\coins;
use App\Models\Currency;
use App\Models\metadata;
use App\Models\product_order;
use DB;
use Session;
use Hamcrest\Type\IsNumeric;

class CryptoMain extends Controller
{
    public function analyze($curency)
    {
        $curencySrc = Currency::where('MainName', $curency)->first();
        if ($curencySrc == null) {
            return abort('404', 'صفحه درخواستی موجود نیست!');
        }
        return  view('Theme2.AnalyzeCurency', ['curencySrc' => $curencySrc]);
    }
    public function Doanalyze(Request $request, $curency)
    {
        if ($request->ajax()) {

            if ($request->procedure == 'like') {
                if ($request->sumnumber > 1 || $request->sumnumber < -1) {
                    return 'security error';
                }
                $Curency = $request->Curency;
                return $this->like_dislike($Curency, $request->sumnumber);
            }
            if ($request->procedure == 'analayzeresult') {
                $Currency =  Currency::where('id', $request->Curency)->first();
                $result = [
                    'f1' => round($Currency->f1, 2),
                    'f2' => round($Currency->f2 * 10, 1),
                    'f3' => round($Currency->f3 * 10, 1),
                    'f4' => round($Currency->f4, 2),
                ];
                return $result;
            }
            if ($request->procedure == 'volanalyze') {
                $Currency =  Currency::where('id', $request->Curency)->first();
                return $Currency->f1;
            }
            if ($request->procedure == 'IncreasementAnl') {
                $Currency =  Currency::where('id', $request->Curency)->first();
                return $Currency->f2;
            }
            if ($request->procedure == 'UnderSpace') {
                $Currency =  Currency::where('id', $request->Curency)->first();
                return $Currency->f3;
            }
            if ($request->procedure == 'linepercents') {
                $Currency =  Currency::where('id', $request->Curency)->first();
                $LineProcess = new LineProcess($Currency->name);
                $ProcessResult =  $LineProcess->get_result();
                return $ProcessResult['GPercent'];
            }
        }
    }

    private function Analyzer_vol()
    {
        $Crypto = new CryptoFunctions();
        return  view('Theme2.Analyzer_vol', ['Crypto' => $Crypto]);
    }
    private function GrowAnl()
    {

        $Crypto = new CryptoFunctions();
        $Query = "SELECT bt.* ,c.pic FROM coin_back_tests as bt INNER JOIN currencies as c on bt.curency = c.MainName WHERE bt.status < 100 and bt.owner = 'system' ORDER BY `bt`.`created_at` DESC ";
        $Curencys = DB::select($Query);
        $MyAlertSrc = metadata::where('fgstr', Auth::id())->where('fgint', 13000)->get();
        $ActiveSMS = false;
        $ActiveRobot = false;
        foreach ($MyAlertSrc as $MyAlert) {
            if ($MyAlert->tt ==  'signalsmsalert') {
                $ActiveSMS = true;
            }
            if ($MyAlert->tt ==  'signalRobot') {
                $ActiveRobot = true;
            }
        }


        return  view('Theme2.GrowAnl', ['Crypto' => $Crypto, 'Curencys' => $Curencys, 'ActiveSMS' => $ActiveSMS, 'ActiveRobot' => $ActiveRobot]);
    }
    private function futureAnl()
    {
        $Crypto = new CryptoFunctions();
        return  view('Theme2.futureAnl', ['Crypto' => $Crypto]);
    }
    private function IndicatorAnalysis()
    {

        $Crypto = new CryptoFunctions();
        return  view('Theme2.IndicatorAnl', ['Crypto' => $Crypto]);
    }
    private function for_buy_signal()
    {
        $buy_before = false;
        $buy_before_src =  product_order::where('status', 1)->where('VirtualContract', 0)->where('CustomerId', Auth::id())->first();
        if ($buy_before_src == null) {
            $buy_before = false;
        } else {
            $buy_before = true;
        }
        return $buy_before;
       
    }

    public function analyzer($type)
    {
        if(!$this->for_buy_signal()){
            return  view('Theme2.Analyzer_buy');
        }
        if ($type == 'VolAnl') {
            return $this->Analyzer_vol();
        }
        if ($type == 'spot') {
            return $this->GrowAnl();
        }
        if ($type == 'futures') {
            return $this->futureAnl();
        }
        if ($type == 'indicators') {
            return $this->IndicatorAnalysis();
        }
        if ($type == 'RSI') {
            return 'sakam';
        }
        return abort('404', 'صفحه مورد نظر موجود نیست');
    }
    private function checkUserLike($CurencyId)
    {
        $UserName = Auth::id();
        $Result = metadata::where('tt', 'userlike')->where('fgstr', $UserName)->where('fgint', $CurencyId)->first();
        if ($Result == null) {
            return false;
        } else {
            return $Result->meta_key;
        }
    }

    private function like_dislike($CurencyId, $Like)
    {
        $OldData = $this->checkUserLike($CurencyId);
        if ($OldData == 'like' && $Like == 1) {
            $State = 'RemoveLike';
        } elseif ($OldData == 'dislike' && $Like == -1) {
            $State = 'RemoveDislike';
        } elseif ($OldData == 'dislike' && $Like == 1) {
            $State = 'ChangeDislike';
        } elseif ($OldData == 'like' && $Like == -1) {
            $State = 'Changelike';
        } elseif ($Like == -1) {
            $State = 'dislike';
        } elseif ($Like == 1) {
            $State = 'like';
        }
        if ($State == 'RemoveLike') {
            $UserName = Auth::id();
            $CurencySrc = Currency::where('id', $CurencyId)->first();
            $CurencySrc->like--;
            $CurencySrc->save();
            metadata::where('tt', 'userlike')->where('fgint', $CurencyId)->where('fgstr', $UserName)->where('meta_key', 'like')->delete();
            return ['change', false, $CurencySrc->like, 'nochange', 'nochange', 'nochange'];
        }
        if ($State == 'RemoveDislike') {
            $UserName = Auth::id();
            $CurencySrc = Currency::where('id', $CurencyId)->first();
            $CurencySrc->dislike--;
            $CurencySrc->save();
            metadata::where('tt', 'userlike')->where('fgint', $CurencyId)->where('fgstr', $UserName)->where('meta_key', 'dislike')->delete();
            return ['nochange', 'nochange', 'nochange', 'change', false, $CurencySrc->dislike];
        }
        if ($State == 'ChangeDislike') {
            $UserName = Auth::id();
            $CurencySrc = Currency::where('id', $CurencyId)->first();
            $CurencySrc->dislike--;
            $CurencySrc->like++;
            $CurencySrc->save();
            metadata::where('tt', 'userlike')->where('fgint', $CurencyId)->where('fgstr', $UserName)->where('meta_key', 'dislike')->update(['meta_key' => 'like']);
            return ['change', true, $CurencySrc->like, 'change', false, $CurencySrc->dislike];
        }
        if ($State == 'Changelike') {
            $UserName = Auth::id();
            $CurencySrc = Currency::where('id', $CurencyId)->first();
            $CurencySrc->dislike++;
            $CurencySrc->like--;
            $CurencySrc->save();
            metadata::where('tt', 'userlike')->where('fgint', $CurencyId)->where('fgstr', $UserName)->where('meta_key', 'like')->update(['meta_key' => 'dislike']);
            return ['change', false, $CurencySrc->like, 'change', true, $CurencySrc->dislike];
        }
        if ($State == 'like') {
            $UserName = Auth::id();
            $CurencySrc = Currency::where('id', $CurencyId)->first();
            $CurencySrc->like++;
            $CurencySrc->save();
            $Data = [
                'tt' => 'userlike',
                'fgint' => $CurencyId,
                'fgstr' => $UserName,
            ];
            $Value = [
                'meta_key' => 'like'
            ];
            $resutl =  metadata::updateOrCreate($Data, $Value);
            return ['change', true, $CurencySrc->like, 'nochange', 'nochange', 'nochange'];
        }
        if ($State == 'dislike') {
            $UserName = Auth::id();
            $CurencySrc = Currency::where('id', $CurencyId)->first();
            $CurencySrc->dislike++;
            $CurencySrc->save();
            $Data = [
                'tt' => 'userlike',
                'fgint' => $CurencyId,
                'fgstr' => $UserName,


            ];
            $Value = [
                'meta_key' => 'dislike'
            ];
            $resutl = metadata::updateOrCreate($Data, $Value);
            return ['nochange', 'nochange', 'nochange', 'change', true, $CurencySrc->dislike];
        }

        return true;
    }
    public function doanalyzer($type, Request $request)
    {
        if ($request->axios) {
            if ($request->function == 'RSI') {
                $CryptoFuncions = new CryptoFunctions;
                $RSIsrc = $CryptoFuncions->get_crypto_by_rsi();
                return $RSIsrc;
            }
            if ($request->function == 'SMI') {
                $CryptoFuncions = new CryptoFunctions;
                $RSIsrc = $CryptoFuncions->get_crypto_by_rsi();
                $TargetUser = Auth::id();
                $join = " left join  coin_back_tests on  coin_back_tests.curency = currencies.MainName and coin_back_tests.owner = '$TargetUser' and coin_back_tests.status < 100";
                if ($request->type == 'down100') {
                    $result = DB::select('SELECT currencies.* , coin_back_tests.candate  FROM currencies ' . $join . ' WHERE enableTrading =1 and currencies.status = 10 and f8 > f7 and f7 < f6 and f8 < f6 and pic is not null and takerCoefficient = 1 and makerCoefficient = 1 ');
                }
                if ($request->type == 'up100') {
                    $result = DB::select('SELECT currencies.* , coin_back_tests.candate FROM currencies ' . $join . ' WHERE enableTrading =1 and currencies.status = 10 and f8 > f7 and f7 > f6  and pic is not null and takerCoefficient = 1 and makerCoefficient = 1 ');
                }
                return $result;
            }
            if ($request->function == 'backtest') {
                $CoinName = $request->CoinName;
                $Backtest = new backtest;
                $Result = $Backtest->AddUserBacktest(Auth::id(), $CoinName);
                return $Result;
            }
            if ($request->function == 'get_my_backtest') {
                $UserName = Auth::id();
                $Query = "SELECT coin_back_tests.* ,currencies.pic  FROM coin_back_tests INNER JOIN currencies on  coin_back_tests.curency = currencies.MainName WHERE coin_back_tests.owner = '$UserName' and coin_back_tests.status < 100 ";
                $my_backtest_src = DB::select($Query);
                return $my_backtest_src;
            }

            return 'notvalid';
        }
        if ($request->ajax()) {

            if ($request->procedure == 'like') {
                if ($request->sumnumber > 1 || $request->sumnumber < -1) {
                    return 'security error';
                }
                $Curency = $request->Curency;
                return $this->like_dislike($Curency, $request->sumnumber);
            }
            if ($request->procedure == 'volanalyze') {
                $Currency =  Currency::where('id', $request->Curency)->first();
                return $Currency->f1;
            }
            if ($request->procedure == 'IncreasementAnl') {
                $Currency =  Currency::where('id', $request->Curency)->first();
                return $Currency->f2;
            }
            if ($request->procedure == 'linepercents') {
                $Currency =  Currency::where('id', $request->Curency)->first();
                $LineProcess = new LineProcess($Currency->name);
                $ProcessResult =  $LineProcess->get_result();
                return $ProcessResult['GPercent'];
            }
        }
        if ($request->submit == 'active_sms') {
            $CryptoAlert = new CryptoAlerts;
            $SetAlert = $CryptoAlert->set_alert_user_when_signal_generate(Auth::id());
            if ($SetAlert['result']) {
                return redirect()->back()->with('success', 'عملیات موقیت آمیز!');
            } else {
                return redirect()->back()->with('error', $SetAlert['msg']);
            }
        }
        if ($request->submit == 'Deactive_robot') {

            metadata::where('fgstr', Auth::id())->where('fgint', 13000)->where('tt', 'signalRobot')->update(['tt' => 'signalRobot_history']);
            return redirect()->back()->with('success', 'عملیات موقیت آمیز!');
        }
        if ($request->submit == 'Deactive_sms') {
            $CryptoAlert = new CryptoAlerts;
            $SetAlert = $CryptoAlert->unset_alert_user_when_signal_generate(Auth::id());
            if ($SetAlert['result']) {
                return redirect()->back()->with('success', 'عملیات موقیت آمیز!');
            } else {
                return redirect()->back()->with('error', $SetAlert['msg']);
            }
        }
        if ($request->submit == 'pay_1' || $request->submit == 'pay_2' || $request->submit == 'pay_3') {
            if (!Auth::check()) {
                return redirect()->back()->with('error', 'جهت پرداخت می باید به سامانه وارد شوید!');
            }
            
            if($request->submit == 'pay_1' ){
                $price = 1500000;
                $Note = 'یک ماهه خرید آنالیزور';
            }
            if($request->submit == 'pay_2' ){
                $price = 3000000;
                $Note = ' سه ماهه خرید آنالیزور';
            }
            if($request->submit == 'pay_3' ){
                $price = 9000000;
                $Note = 'یک ساله خرید آنالیزور';
            }
            $token = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 10)), 0, 10);
            $ResNum = 41;             // for post analyzer
            Session::put('price', $price);
            Session::put('ResNum', $ResNum);
            Session::put('finoward_token', $token);
            Session::put('Note', $Note);
            $amount = $price; // مبلغ فاكتور
            $redirectAddress = route('finpay');
            $invoiceNumber = $ResNum; //شماره فاكتور
            $timeStamp = date("Y/m/d H:i:s");
            $invoiceDate = date("Y/m/d H:i:s"); //تاريخ فاكتور
            $action = "1003";    // 1003 : براي درخواست خريد
            $Mobile = Auth::user()->MobileNo;
            echo "<form id='peppeyment' action='https://finoward.ir/ipg.php' method='post'>
                <input  type='text' name='token' value='$token' /><br />
                <input  type='text' name='amount' value='$amount' /><br />
                <input  type='text' name='redirectAddress' value='$redirectAddress' /><br />
                <input  name='mobile' value='$Mobile' /><br />
                <input  type='text' name='Note' value='$Note' /><br />
                <button type='submit'>انتقال به درگاه  </button>
                </form><script>document.forms['peppeyment'].submit()</script>";
        }
    }
    private function define_robot_on_internal_wallet($CoinId)
    {
        $CoinSrc = coins::where('id', $CoinId)->first();
        if ($CoinSrc == null) {
            return abort('رمز ارز پیدا نشد!');
        }
        if ($CoinSrc->UserName != Auth::id()) {
            return abort('کجا عمو!!');
        }
        if ($CoinSrc->ExtraInfo != null) {
            $CryptoAttr = json_decode($CoinSrc->ExtraInfo);
        } else {
            $CryptoAttr = [];
        }

        $CryptoAttr = json_decode($CoinSrc->ExtraInfo);

        $CryptoAttr = $CryptoAttr->RobotAtt ?? null;
        return view('Crypto.CoinEdit', ['CoinSrc' => $CoinSrc, 'CryptoAttr' => $CryptoAttr]);
    }
    private function define_robot_on_spot_ai_signals()
    {

        return view('Crypto.SpotSignalRobot');
    }

    public function CoinEdit($CoinId)
    {
        if (is_numeric($CoinId)) {
            return $this->define_robot_on_internal_wallet($CoinId);
        }
        if ($CoinId == 'spot_ai') {
            return $this->define_robot_on_spot_ai_signals();
        }
    }
    private function set_robot_on_AI_signal(Request $request)
    {

        $RobAtt = [
            "InputBaget" => $request->InputBaget,
            'concurnet' => $request->concurnet,
            'market' => $request->market,
            "benefit" => $request->benefit,
            "stop" => $request->stop,
            "start" => $request->start,
            "timelimit" => $request->timelimit,
            "behav" => $request->behav,
            "active_robot" => 0
        ];
        $RobAtt = json_encode($RobAtt);
        $data = [
            'tt' => 'signalRobot',
            'fgstr' => Auth::id(),
            'fgint' => 13000, // for alerting code
            'meta_value' => $RobAtt,  //Basic info
        ];
        $InserResult = metadata::create($data);
        return redirect()->route('analyzer', ['type' => 'spot'])->with('success', 'ربات بر روی سیگنالهای هوش مصنوعی فعال شد!');
    }
    public function DoCoinEdit($CoinId, Request $request)
    {
        if ($CoinId == 'spot_ai') {
            return $this->set_robot_on_AI_signal($request);
        } else {
            $Coininfo = coins::where('id', $CoinId)->first();
            $ExtraInfo = json_decode($Coininfo->ExtraInfo);
            $RobAtt = [
                "InputBaget" => $request->InputBaget,
                "benefit" => $request->benefit,
                "stop" => $request->stop,
                "start" => $request->start,
                "decrate" => 0,
                "timelimit" => $request->timelimit,
                "type" => $request->type,
                "behav" => $request->behav,
                "khatere" => 0,
                "RobotstopDown" => $request->RobotstopDown,
                "RobotstopUp" => $request->RobotstopUp,
            ];
            $ExtraInfo->RobotAtt = $RobAtt;
            $ExtraInfo = json_encode($ExtraInfo);
            $Data = [
                'ExtraInfo' => $ExtraInfo,
                'Status' => 0
            ];
            coins::where('id', $CoinId)->update($Data);
            return redirect()->back()->with('success', 'با موفقیت انجام شد');
        }
    }
    public function RobotMGT()
    {
        $Markets =   metadata::where('fgstr', Auth::id())->where('tt', 'MarketRobot')->get();
        return view('Crypto.Robot1MGT', ['Markets' => $Markets]);
    }
    public function DoRobotMGT(Request $request)
    {
        // dd($request->input());
        if ($request->has('submit')) {
            $Market = $request->submit;
            $TargetMarket = $request->$Market;
            $MarketNO = substr($Market, 6);
            $MarketData = [
                'tt' => 'MarketRobot',
                'fgint' => $MarketNO,
                'fgstr' => Auth::id(),
                'meta_key' => strtoupper($TargetMarket),
            ];
            metadata::where('fgstr', Auth::id())->where('fgint', $MarketNO)->where('tt', 'MarketRobot')->delete();
            metadata::create($MarketData);
            return redirect()->back()->with('success', 'انجام شد!');
        }
    }
    public function CryptoAnalyze()
    {
        $Crypto = new CryptoFunctions();
        $MarketSrc = $Crypto->MarketAlyze(null, 'TMN');
        return view('Crypto.cryptoAnalyze', ['MarketSrc' => $MarketSrc]);
    }
    public function DoCryptoAnalyze()
    {
    }
    public function BestDirections(Request $request)
    {

        $Crypto = new CryptoFunctions();
        if ($request->has('market')) {
            return view('Crypto.cryptoBestDirections', ['BestDirections' => $Crypto->BestDirections($request->market)]);
        }
        return view('Crypto.cryptoBestDirections', ['BestDirections' => $Crypto->BestDirectionsAgregation()]);
    }
    public function DoBestDirections(Request $request)
    {
        $TMN = $request->TMN;
        $Coinname = $request->Buy;
        $USerName = Auth::id();
        $Crypto = new CryptoFunctions();
        $Crypto->TokenSetter(Auth::user()->remember_token, $USerName);
        $BuyResult = $Crypto->BuyCoinWithToman($Coinname, $TMN, $USerName);
        $NewPrice = $BuyResult['BuyPrice'];
        $Crypto->RenewWalet($USerName);
        $Crypto->SetNewLimit($USerName, $Coinname, $NewPrice);
        return redirect()->back();
    }
    public function WaletShow($EXCType = null)
    {

        if ($EXCType == 'all') {
            $Crypto = new CryptoFunctions();
            $Crypto->TokenSetter(Auth::user()->remember_token, Auth::id());
            $USerName = Auth::id();
            $Query = "SELECT * FROM coins inner join currencies on coins.CoinName = currencies.MainName  WHERE UserName = '$USerName' ORDER BY QTY * TMN DESC";
            $UserCoin = DB::select($Query);
            $CoinCount =  count($UserCoin);
            // dd($UserCoin->count());
            if ($CoinCount == 0) {
                $Crypto->RenewWalet(Auth::id());
                $Query = "SELECT * FROM coins inner join currencies on coins.CoinName = currencies.MainName   WHERE UserName = '$USerName' ORDER BY QTY * TMN DESC";
                $UserCoin = DB::select($Query);
            }
        } else {
            $Crypto = new CryptoFunctions();
            $Crypto->TokenSetter(Auth::user()->remember_token, Auth::id());
            $USerName = Auth::id();
            $Query = "SELECT coins.* , currencies.pic FROM coins inner join currencies on coins.CoinName = currencies.MainName  WHERE UserName = '$USerName' and QTY > 0  ORDER BY QTY * TMN DESC";
            $UserCoin = DB::select($Query);
            $CoinCount =  count($UserCoin);
            // dd($UserCoin->count());
            if ($CoinCount == 0) {
                $Crypto->RenewWalet(Auth::id());
                $Query = "SELECT * FROM coins inner join currencies on coins.CoinName = currencies.MainName  WHERE UserName = '$USerName' and QTY > 0 ORDER BY QTY * TMN DESC";

                $UserCoin = DB::select($Query);
            }
        }


        return view('Crypto.cryptoWaletShow', ['Userbalances' => $UserCoin, 'Crypto' => $Crypto]);
    }
    public function DoWaletShow(Request $request)
    {
        $Crypto = new CryptoFunctions();
        if ($request->submit == 'syncwithcenter') {
            $Crypto->TokenSetter(Auth::user()->remember_token, Auth::id());
            $Crypto->RenewWalet(Auth::id());
            return redirect()->back()->with('success', 'به روز رسانی انجام گرفت!');
        }

        if ($request->has('StartRobot')) {
            $CoinID = $request->StartRobot;
            $CryptoFurmola = new CryptoFormola_1;
            $result = $CryptoFurmola->StartRobot($CoinID);
            if ($result) {
                return redirect()->back()->with('success', 'ربات فعال شد!');
            } else {
                return redirect()->back()->with('error', 'ربات فعال نشد!!');
            }
        }
        if ($request->has('activeRobot')) {
            $CoinID = $request->activeRobot;
            $TargetCoin = coins::where('id', $CoinID)->first();
            $ExtraInfo = json_decode($TargetCoin->ExtraInfo, true);
            if (!isset($ExtraInfo['RobotAtt'])) {
                return redirect()->back()->with('error', 'تنظیمات ربات انجام نگرفته است!');
            }
            $CryptoFurmola = new CryptoFormola_1;
            $result = $CryptoFurmola->BuyCoin($CoinID);
            if ($result) {
                return redirect()->back()->with('success', 'ربات فعال شد!');
            } else {
                return redirect()->back()->with('error', 'ربات فعال نشد!!');
            }
        }
        if ($request->has('deactiveRobot')) {
            $CoinID = $request->deactiveRobot;
            $CoinRobotData = [
                'Robot' => null,
                'Tmn' => 0,
                'Status' => 0
            ];
            coins::where('id', $CoinID)->update($CoinRobotData);
            return redirect()->back()->with('success', 'ربات غیر  فعال شد!');
        }
        if ($request->has('sale')) {
            $Percent = $request->Percent;
            $Coinname = $request->sale;
            $Crypto->TokenSetter(Auth::user()->remember_token, Auth::id());
            return $Crypto->SaleCoin($Coinname, $Percent);
        }
        if ($request->has('Define')) {
            $CoinID = $request->Define;
            return view('Crypto.cryptoWaletShow', ['Userbalances' => $UserCoin, 'Crypto' => $Crypto]);
        }
        if ($request->has('TMNDownLimit_submit')) {
            $CoinsID = $request->TMNDownLimit_submit;
            $TMNDownLimit = $request->TMNDownLimit;
            coins::where('id', $CoinsID)->update(['TMNDownLimit' => $TMNDownLimit]);
            return redirect()->back();
        }
        if ($request->has('TMNUpLimit_submits')) {
            $CoinsID = $request->TMNUpLimit_submits;
            $TMNUpLimit = $request->TMNUpLimit;
            coins::where('id', $CoinsID)->update(['TMNUpLimit' => $TMNUpLimit]);
            return redirect()->back();
        }
        if ($request->has('limitset')) {
            $CoinName = $request->limitset;
            $NewPrice = $request->NewPrice;
            $UserName = Auth::id();
            $Crypto->SetNewLimit($UserName, $CoinName, $NewPrice);
            return redirect()->back();
        }
        if ($request->has('setbuy')) {
            $CoinName = $request->setbuy;
            $NewPrice = $request->NewPrice;
            $UserName = Auth::id();
            $Crypto->SetNewPrice($UserName, $CoinName, $NewPrice);
            return redirect()->back();
        }
    }
    public function crypto()
    {
        return view('Crypto.CryptoAdmin');
    }
    public function Docrypto(Request  $request)
    {
    }
    public function cryptoAccount()
    {
        return view('Crypto.cryptoAccount');
    }
    public function DocryptoAccount(Request $request)
    {
        if ($request->submit == 'saveToken') {
            $token = $request->token;
            UserInfo::where('UserName', Auth::id())->update(['remember_token' => $token]);
            return redirect()->back()->with('success', 'توکن ثبت شد!');
        }
        if ($request->submit == 'kocoin') {
            if (Auth::user()->extradata != null) {
                $extradata = json_decode(Auth::user()->extradata, true);
                $extradata['KC_key'] = $request->key;
                $extradata['KC_secret'] = $request->secret;
                $extradata['KC_passphrase'] = $request->passphrase;
            } else {
                $extradata = [];
                $extradata['KC_key'] = $request->key;
                $extradata['KC_secret'] = $request->secret;
                $extradata['KC_passphrase'] = $request->passphrase;
            }
            $extradata = json_encode($extradata);
            UserInfo::where('UserName', Auth::id())->update(['extradata' => $extradata]);
            return redirect()->back()->with('success', 'توکن ثبت شد!');
        }
        if ($request->submit == 'removewallex') {
            UserInfo::where('UserName', Auth::id())->update(['remember_token' => null]);
            return redirect()->back()->with('success', 'توکن حذف شد!');
        }
        if ($request->submit == 'removekucoin') {
            if (Auth::user()->extradata != null) {
                $extradata = json_decode(Auth::user()->extradata, true);
                $extradata['KC_key'] = null;
                $extradata['KC_secret'] = null;
                $extradata['KC_passphrase'] = null;
                $extradata = json_encode($extradata);
                UserInfo::where('UserName', Auth::id())->update(['extradata' => $extradata]);
            }
            return redirect()->back()->with('success', 'توکن ثبت شد!');
        }
        if ($request->submit == 'Checkkucoin') {
            $KuCoin = new kucoin(Auth::id());
            $UserWalet = $KuCoin->get_my_walet();
            if ($UserWalet == false) {
                return redirect()->back()->with('error', 'مشکل API تعریف شده در سامانه');
            } else {
                return redirect()->back()->with('success', 'ارتباط برقرار است!');
            }
        }
    }
    public function AccountShow()
    {
        $Crypto = new CryptoFunctions();
        $Crypto->TokenSetter(Auth::user()->remember_token, Auth::id());
        return view('Crypto.cryptoAccountShow', ['UserProfile' => $Crypto->UserProfile()]);
    }
}

<?php

namespace App\Http\Controllers\Order;

use App\APIS\SmsCenter;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Credit\Reports;
use App\Http\Controllers\Patients\Workflow;
use App\Models\addorder1;
use App\Models\catorder;
use App\Models\citys;
use App\myappenv;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\provinces;
use Session;

class RegisterForm extends Controller
{


    public function RegisterForm($RegType)
    {
        Session::put('intended_url_important', \request()->url());

        $Provinces = provinces::all();
        if (\App\myappenv::MainOwner == 'kookbaz') {

            if ($RegType == 11) {
                return view('Layouts.Theme1.landing.becomevendor', ['Provinces' => $Provinces]);
            } elseif ($RegType == 12) {
                return view('Layouts.Theme1.landing.Ghestibekhar', ['Provinces' => $Provinces]);
            } elseif ($RegType == 14) {
                return view('Layouts.Theme1.landing.nexalife', ['Provinces' => $Provinces]);
            } elseif ($RegType == 15) {
                return view('Layouts.Theme1.landing.Tourism', ['Provinces' => $Provinces]);
            } elseif ($RegType == 16) {
                return view('Layouts.Theme1.landing.kowsar', ['Provinces' => $Provinces]);
            } elseif ($RegType == 17) {
                return view('Layouts.Theme1.landing.KashfShow', ['Provinces' => $Provinces]);
            } elseif ($RegType == 18) {
                return view('Layouts.Theme1.landing.WordpressAcademy', ['Provinces' => $Provinces]);
            } elseif ($RegType == 19) {
                return view('Layouts.Theme1.landing.kowsartakmili', ['Provinces' => $Provinces]);
            } elseif ($RegType == 20) {
                return view('Layouts.Theme1.landing.TeleMarketer', ['Provinces' => $Provinces]);
            } elseif ($RegType == 21) {
                return view('Layouts.Theme1.landing.massage', ['Provinces' => $Provinces]);
            } elseif ($RegType == 22) {
                return view('Layouts.Theme1.landing.chin', ['Provinces' => $Provinces]);
            } elseif ($RegType == 23) {
                return view('Layouts.Theme1.landing.MainPage', ['Provinces' => $Provinces]);
            } else {
                return abort('404', 'فرم درخواستی در سیستم وجود ندارد!');
            }
        } elseif (\App\myappenv::MainOwner == 'finoward') {
            if ($RegType == 11) {
                return view('Layouts.Theme3.aboatus');
            }
        } elseif (\App\myappenv::MainOwner == 'shafatel') {
            if ($RegType == 29) {
                return view('Layouts.Theme1.landing.becomevendor_shafatel', ['Provinces' => $Provinces]);
            }
        } else {
            return abort('404', 'فرم درخواستی در سیستم وجود ندارد!');
        }
    }
    public function DoRegisterForm(Request $request, $RegType)
    {
        Session::put('intended_url_important', \request()->url());


        if ($RegType == 11) {
            $City = citys::where('id', $request->input('Saharestan'))->first();
            $Province = provinces::where('id', $request->input('Province'))->first();
            $DataInput = [
                'StoreName' => ['نام فروشگاه', strip_tags($request->input('StoreName'))],
                'Business' => ['نوع کسب و کار', strip_tags($request->input('Business-Type'))],
                'Province' => ['استان', $Province->ProvinceName],
                'Saharestan' => ['شهر', $City->CityName],
                'StoreAddress' => ['آدرس', strip_tags($request->input('StoreAddress'))],
                'ُStorePostalCode' => ['کدپستی', strip_tags($request->input('ُStorePostalCode'))],
                'StoreNote' => ['درباره فروشگاه', strip_tags($request->input('Storeaboutus'))]


            ];
        } elseif ($RegType == 12) {

            $City = citys::where('id', $request->input('Saharestan'))->first();
            $Province = provinces::where('id', $request->input('Province'))->first();
            if (($request->has('MeliID'))) {

                $TargetMelliID = strip_tags($request->input('MeliID'));
                $Tavan = new Reports();

                if ($TargetMelliID == '0123456789') { // just for test
                    $TavanSrc = [
                        "personType" => "RETIRED",
                        "identificationCode" => "00000011111",
                        "hogs" => "118669650",
                        "pard" => "80010273",
                        "tavg" => "5522255",
                        "hogm" => "122743545",
                        "fullName" => "حمید شجاع الدینی",
                        "tham" => Auth::user()->MobileNo,
                    ];
                    $TavanSrc = json_decode(json_encode($TavanSrc));
                } else {
                    $TavanSrc = $Tavan->Estelam($TargetMelliID);
                }

                if (isset($TavanSrc->tham)) {
                    $tham = $TavanSrc->tham;
                    if (Auth::user()->MobileNo == $tham) {
                        $tavg = $TavanSrc->tavg;
                    } else {
                        $tavg = 'شماره موبایل دریافتی با شماره موبایل سازمان تطابق ندارد';
                    }
                } else {
                    $tavg = "کدملی در سامانه وجود ندارد";
                }
            }
            $DataInput = [
                'Name' => [' نام ', strip_tags($request->input('Name'))],
                'Family' => ['  نام خانوادگی ', strip_tags($request->input('Family'))],
                'Province' => ['استان', $Province->ProvinceName],
                'Saharestan' => ['شهر', $City->CityName],
                'mobilenumber' => ['شماره موبایل', strip_tags($request->input('mobilenumber'))],
                'accountnumber' => ['شماره حساب ', strip_tags($request->input('accountnumber'))],
                'MeliID' => [' کدملی', strip_tags($request->input('MeliID'))],
                'tavg' => [' توان پرداخت', $tavg],


            ];
        } elseif ($RegType == 14) {
            $City = citys::where('id', $request->input('Saharestan'))->first();
            $Province = provinces::where('id', $request->input('Province'))->first();
            $DataInput = [
                'Name' => ['نام و نام خانوادگی:', strip_tags($request->input('Name'))],
                'MeliID' => ['کدملی', strip_tags($request->input('MelliID'))],
                'Address' => ['آدرس', strip_tags($request->input('Address'))],
                'Madrak' => ['مدرک', strip_tags($request->input('ُMadrak'))],
                'Mobileno' => ['موبایل', strip_tags($request->input('ُMobileno'))],
                'age' => ['سن', strip_tags($request->input('age'))],
                'note' => ['مشکل', strip_tags($request->input('note'))]
            ];
        } elseif ($RegType == 15) {
            $City = citys::where('id', $request->input('Saharestan'))->first();
            $Province = provinces::where('id', $request->input('Province'))->first();
            $DataInput = [
                'Name' => [' نام و نام خانوادگی مدیر', strip_tags($request->input('Name'))],
                'phone' => ['   تلفن ثابت', strip_tags($request->input('phone'))],
                'Province' => ['استان', $Province->ProvinceName],
                'Saharestan' => ['شهر', $City->CityName],
                'maxnumber' => ['حداکثر تعداد پذیرش', strip_tags($request->input('maxnumber'))],
                'numberofpeople' => ['تعداد نیروی مشغول به کار', strip_tags($request->input('numberofpeople'))]

            ];
        } elseif ($RegType == 16) {
            $City = citys::where('id', $request->input('Saharestan'))->first();
            $Province = provinces::where('id', $request->input('Province'))->first();
            $DataInput = [
                'Name' => [' نام و نام خانوادگی مدیر', strip_tags($request->input('Name'))],
                'MeliID' => ['  کدملی  ', strip_tags($request->input('meliId'))],
                'date' => ['  تاریخ تولد   ', strip_tags($request->input('date'))],
                'mobileno' => ['   تلفن ', strip_tags($request->input('mobileno'))],
                'Province' => ['استان', $Province->ProvinceName],
                'Saharestan' => ['شهر', $City->CityName],
                'Address' => ['آدرس', strip_tags($request->input('Address'))],
                'saal' => ['  سال اخذ مدرک', strip_tags($request->input('saal'))],
                'madrak' => ['آخرین مدرک تحصیلی', strip_tags($request->input('madrak'))]

            ];
        } elseif ($RegType == 19) {

            $City = citys::where('id', $request->input('Saharestan'))->first();
            $Province = provinces::where('id', $request->input('Province'))->first();
            $DataInput = [
                'Name' => [' نام و نام خانوادگی ', strip_tags($request->input('Name'))],
                'MeliID' => ['  کدملی  ', strip_tags($request->input('meliId'))],
                'mobileno' => ['   تلفن ', strip_tags($request->input('mobileno'))],
                'Province' => ['استان', $Province->ProvinceName],
                'Saharestan' => ['شهر', $City->CityName],

            ];
        } elseif ($RegType == 20) {
            $City = citys::where('id', $request->input('Saharestan'))->first();
            $Province = provinces::where('id', $request->input('Province'))->first();
            $DataInput = [
                'Name' => [' نام و نام خانوادگی ', strip_tags($request->input('Name'))],
                'phone' => ['   تلفن ', strip_tags($request->input('phone'))],
                'Province' => ['استان', $Province->ProvinceName],
                'Saharestan' => ['شهر', $City->CityName],
                'madrak' => [' مدرک', strip_tags($request->input('madrak'))],
                'age' => ['سن  ', strip_tags($request->input('age'))]
            ];
        } elseif ($RegType == 21) {
            $City = citys::where('id', $request->input('Saharestan'))->first();
            $Province = provinces::where('id', $request->input('Province'))->first();
            $DataInput = [
                'Name' => ['نام و نام خانوادگی:', strip_tags($request->input('Name'))],
                'MeliID' => ['کدملی', strip_tags($request->input('MelliID'))],
                'Madrak' => ['مدرک', strip_tags($request->input('ُMadrak'))],
                'age' => ['سن', strip_tags($request->input('age'))],
            ];
        } elseif ($RegType == 22) {
            $City = citys::where('id', $request->input('Saharestan'))->first();
            $Province = provinces::where('id', $request->input('Province'))->first();
            $DataInput = [
                'Name' => ['نام و نام خانوادگی:', strip_tags($request->input('Name'))],
                'MeliID' => ['کدملی', strip_tags($request->input('MelliID'))],
                'Province' => ['استان', $Province->ProvinceName],
                'Saharestan' => ['شهر', $City->CityName],
                'Address' => ['آدرس', strip_tags($request->input('Address'))],


            ];
        } elseif ($RegType == 29) {
            $City = citys::where('id', $request->input('Saharestan'))->first();
            $Province = provinces::where('id', $request->input('Province'))->first();
            $DataInput = [
                'StoreName' => ['نام فروشگاه', strip_tags($request->input('StoreName'))],
                'Business' => ['نوع کسب و کار', strip_tags($request->input('Business-Type'))],
                'Province' => ['استان', $Province->ProvinceName],
                'Saharestan' => ['شهر', $City->CityName],
                'StoreAddress' => ['آدرس', strip_tags($request->input('StoreAddress'))],
                'ُStorePostalCode' => ['کدپستی', strip_tags($request->input('ُStorePostalCode'))],
                'StoreNote' => ['درباره فروشگاه', strip_tags($request->input('Storeaboutus'))]


            ];
        }



        $DataInput = json_encode($DataInput);
        $DataSource = [
            'UserName' => Auth::id(),
            'BimarUserName' => Auth::id(),
            'CatID' => $RegType,
            'CreateDate' => now(),
            'Status' => '1',
            'Address' => '',
            'Extranote' => $DataInput,
            'branch' => myappenv::Branch
        ];
        $oldrequest = addorder1::where('UserName', Auth::id())->where('CatID', $RegType)->where('Status', '!=', 9)->get();
        if (is_null($oldrequest)) {
            return redirect()->back()->with('error', 'کاربر گرامی شما یک درخواست باز دارید و امکان ثبت درخواست جدید وجود ندارد');
        } else {
            $result = addorder1::create($DataSource);
            $MyWorkFlow = new Workflow();
            $WorkFlowText = ' ثبت درخواست شماره : ' . $result->id . '<br>';
            $OrderCat = catorder::where('ID', $RegType)->first();
            $WorkFlowText .= '<h6>' . $OrderCat->TitleDescription . '</h6>';
            $InputArr = json_decode($DataInput);
            $MyStr = '';
            foreach ($InputArr as $InputItem) {
                $MyStr .= $InputItem[0] . ': ' . $InputItem[1] . '<br>';
            }
            $WorkFlowText .= $MyStr;
            $MyWorkFlow->AddWorkFlow(Auth::id(), Auth::id(), $WorkFlowText);
            $SMSText = "** کوک باز **" . "   " . "درخواست شما به شماره " . $result->id . ' ثبت گردید ، پس از بررسی کارشناسان ما با شما تماس خواهند گرفت !';
            $MySMS = new SmsCenter();
            $MySMS->OndemandSMS($SMSText, Auth::user()->MobileNo, 'ResetPassword', Auth::id());
            return redirect()->back()->with('success', 'درخواست شما با موفقیت ثبت گردید!');
        }
    }
}

<?php

namespace App\Http\Controllers\Consult;

use App\Functions\ConsultClass;
use App\Functions\Financial;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Patients\PatShift;
use App\Models\mobile_banner;
use App\Models\post_views;
use App\Models\UserInfo;
use App\myappenv;
use App\Patient\PatiantServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;

class ConsultMain extends Controller
{
    private function get_user_credit($UserName)
    {
        $Financial = new Financial();
        $UserCredit = $Financial->UserHasCredite($UserName, myappenv::CachCredit);
        return $UserCredit;
    }
    public function Consultation($userid, Request $request)
    {

        $Consult = new ConsultClass;
        return view('Layouts.Moshavereh.Consultation', ['Consult' => $Consult, 'userid' => $userid])->render();
    }
    private function get_service_price($Service)
    {
        return 400;

    }
    /**
     * Undocumented function
     *
     * @param [type] $Seller => Seller Ext
     * @param [type] $Coustomer =>Coustomer username
     * @param [type] $Service => Index UID of sercie
     *
     * @return boolean
     */
    private function buy_service($Seller, $Coustomer, $Service)
    {
        $Consult = new ConsultClass();
        $SellerInfo = UserInfo::where('Ext', $Seller)->first();
        $CoustomerInfo = UserInfo::where('UserName', $Coustomer)->first();
        $Consult->BothSideCall($SellerInfo->MobileNo, $CoustomerInfo->MobileNo);
        $PatiantServices = new PatiantServices();
        $PatiantServices->add_cunsulting_service_to_patiant($Service, $Seller, $Coustomer);
        return true;
        $ServicePrice = $this->get_service_price($Service);



    }
    public function DoConsultation($userid, Request $request)
    {

        //TODO: 1)handele less mony na 2) not login  3) cancel events
        $SuccessMsg = '                        <h5 class="IRANSansWeb_Medium bg-light py-2 px-3  mb-4 rad25">برقراری تماس</h5>
        <p>در صورتی که تمایل به دریافت مشاوره دارید کلید شروع مشاوره را بزنید!</p>
        <p class="danger">توجه داشته باشید که در صورت درخواست برقراری مشاوره مبلغ مشاوره از حساب شما کسر
            خواهد شد!</p>
        <button type="submit" name="submit" value="startcall"
            class="btn btn-success px-4 text-white rad25  ml-3 ">شروع تماس</button>';
        $LoginMsg = ' <h5 class="IRANSansWeb_Medium bg-light py-2 px-3  mb-4 rad25">

            در صورتی که تمایل به دریافت مشاوره دارید لطفا ورود/ثبت نام کنید!
        </h5>
        <button type="submit" name="submit" value="login"
        class="btn btn-success px-4 text-white rad25  ml-3 "> ورود / ثبت نام</button>';
        $MoneyMsg = ' <h5 class="IRANSansWeb_Medium bg-light py-2 px-3  mb-4 rad25">
    متاسفانه اعتبار شما کافی نمی باشد.لطفا کیف پول خود را شارژ بفرمایید
    </h5>
    <button type="submit" name="submit" value="charge"
    class="btn btn-success px-4 text-white rad25  ml-3 ">  شارژ کیف پول  </button>';

        if ($request->has('submit')) {
            if ($request->input('submit') == 'login') {
                Session::put('intended_url_important', \request()->url());
                return redirect()->Route('login');
            }
            if ($request->input('submit') == 'charge') {
                return redirect()->Route('MyAccount');
            } else {

                echo '<!DOCTYPE html>  
<html dir="rtl" lang="fa-IR">  
<head>  
    <meta charset="UTF-8" />  
    <title>برقراری تماس امن</title>  
    <style>  
        html, body {  
            height: 100%;  
            margin: 0;  
            display: flex;  
            justify-content: center;  
            align-items: center;  
            background-color: #1EA499; 
            color: white;  
            font-size: 18px; 
            overflow: hidden; 
        }  
        h1 {  
            text-align: center; 
        }  
        a {  
            display: block; 
            color: white; 
            text-align: center; 
        }  
    </style>  
</head>  

<body>  
    <div>  
        <h1>در حال برقراری تماس با شما هستیم لطفاً منتظر تماس بمانید......</h1>        <a href="/">بازگشت به خانه</a>  
    </div>  
</body>  
</html>';

                $Consultent = $userid;
                $Buyer = Auth::id();

                $Service = $request->selected_service;
                $this->buy_service($Consultent, $Buyer, $Service);
                return null;
            }

        }
        if ($request->has('AddComment')) {
            $ViewsData = [
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'message' => $request->input('comment'),
                'Post' => $userid,
                'Status' => 2,
            ];

            $result = post_views::create($ViewsData);
            post_views::where('id', $result->id)->update(['refrence' => $result->id]);
            return redirect()->back()->with('success', 'دیدگاه شما ثبت شد ، پس از بررسی مدیر سایت منتشر خواهد شد!');
        }
        if ($request->ajax) {
            if ($request->procedure == 'callrequest') {
                //TODO:prebuys role
                if (Auth::check()) {
                    $Service = $request->Service;
                    $UserCredit = $this->get_user_credit(Auth::id());
                    $ServicePrice = $this->get_service_price($Service);
                    if ($ServicePrice < $UserCredit) {
                        return [$SuccessMsg, 'success'];
                    } else {

                        return [$MoneyMsg, 'error'];
                    }
                } else {
                    return [$LoginMsg, 'error'];
                }
            }
        }
    }
    public function Reservationlist(Request $request, $L3id = null, $L3Name = null)
    {
        //return view('Layouts.Moshavereh.objects.L3Category')->render();

        $Consult = new ConsultClass;

        //dd($Consult->get_cunsultent_in_one_aria(35));
        if ($request->has('page')) {
            if ($request->page == 'searching') {
                $sarchtext = $request->q;
                return view('Layouts.Moshavereh.objects.Reservation_items', ['Consult' => $Consult, 'sarchtext' => $sarchtext])->render();
            }
            if ($request->page == '1') {
                return view('Layouts.Moshavereh.objects.Reservation_items', ['Consult' => $Consult, 'L3id' => $L3id, 'L3Name' => $L3Name])->render();
            }
            if ($request->page == 'cats') {
                return view('Layouts.Moshavereh.objects.L3Category', ['Consult' => $Consult, 'L3id' => $L3id, 'L3Name' => $L3Name])->render();
            }
        }
        if ($L3id == null) {
            /**
             * AllCategory of Counsultings
             */
            //TODO: handle this function
        } elseif ($L3Name == null) {
            /**
             * fix L3Name and then show cunsulting categury
             */
            $L3Info = $Consult->get_l3_info($L3id);
            if ($L3Info == null) {
                return abort('404', 'دسته بندی درخواست شده وجود ندارد!');
            }
            return redirect()->route('Reservationlist', ['L3id' => $L3id, 'L3Name' => $L3Info->Name]);
        } else {
            /**
             * show caunsulting cat
             */
            $L3Info = $Consult->get_l3_info($L3id);
            if ($L3Name != $L3Info->Name) {
                return redirect()->route('Reservationlist', ['L3id' => $L3id, 'L3Name' => $L3Info->Name]);
            }
            return view('Layouts.Moshavereh.Reservationlist', ['Consult' => $Consult, 'L3id' => $L3id, 'L3Name' => $L3Info->Name]);
        }
    }
    public function DoReservationlist(Request $request, $L3id = null, $L3Name = null)
    {
    }

    private function LoadL1Level($CatID)
    {

        $Consult = new ConsultClass;
        $ConsultLvel = $Consult->get_type_of_indexing();
        if ($ConsultLvel == 'L1') {
            return view('Layouts.Moshavereh.objects.ListL2', ['Consult' => $Consult, 'CatID' => 1])->render();
        } else {
            return view('Layouts.Moshavereh.objects.maincats', ['Consult' => $Consult, 'CatID' => $CatID])->render();
        }
    }
    private function LoadL2Level($CatID)
    {
        $Consult = new ConsultClass;
        return view('Layouts.Moshavereh.objects.ListL2', ['Consult' => $Consult, 'CatID' => $CatID])->render();
        return view('Layouts.Theme1.objects.ConsultL2Lists', ['Consult' => $Consult, 'CatID' => $CatID])->render();
    }
    private function LoadL3Level($CatID, $ZoneID)
    {
        $Consult = new ConsultClass;
        return view('Layouts.Moshavereh.objects.ListL3', ['Consult' => $Consult, 'CatID' => $CatID, 'ZoneID' => $ZoneID])->render();
        return view('Layouts.Theme1.objects.ConsultL3Lists', ['Consult' => $Consult, 'CatID' => $CatID, 'ZoneID' => $ZoneID])->render();
    }

    public function Consulting(Request $request)
    {
        //return $this->LoadL1Level($request->catID);
        $Consult = new ConsultClass;
        if ($request->has('page')) {
            if ($request->page == 1) {
                return $this->LoadL1Level($request->catID);
            }
            if ($request->page == 2) {
                return $this->LoadL2Level($request->catID);
            }
            if ($request->page == 3) {
                return $this->LoadL3Level($request->catID, $request->ZoneID);
            }
            return view('Layouts.Theme1.objects.ConsultL2Lists', ['Consult' => $Consult])->render();
        }
        $mobile_banners = mobile_banner::where('status', 1)->where('page', 1)->orderBy('order', 'ASC')->get();
        return view('Layouts.Moshavereh.ConsultMain', ['Consult' => $Consult, 'mobile_banners' => $mobile_banners]);
        return view('Layouts.Theme1.ConsultingList', ['Consult' => $Consult]);
    }
    public function DoConsulting(Request $request)
    {
    }
    public function ContactUs(Request $request)
    {
        $Consult = new ConsultClass;
        return view('Layouts.Moshavereh.objects.ContactUs', ['Consult' => $Consult]);
    }
    public function DoContactUs(Request $request)
    {
    }
}

<?php

namespace App\Http\Controllers\moshavereh;

use App\Functions\APIClass;
use App\Functions\Financial;
use App\Functions\Indexes;
use App\Functions\MoshaverehClass;
use App\Http\Controllers\Controller;
use App\Models\L3Work;
use App\Models\ServiceRequest;
use App\Models\UserInfo;
use App\myappenv;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class main extends Controller
{
    public function ConfirmSession($Token)
    {
        $RequestSource = ServiceRequest::where('Token', $Token)->where('Status', '<', 50)->first();
        if ($RequestSource == null) {
            return abort('404');
        }
        $OwnerInfo = UserInfo::where('UserName', $RequestSource->Owner)->first();
        $ProviderInfo = UserInfo::where('UserName', $RequestSource->Provider)->first();

        return view('Moshavereh.ConfirmSession', ['RequestSource' => $RequestSource, 'OwnerInfo' => $OwnerInfo, 'ProviderInfo' => $ProviderInfo]);
    }
    public function DoConfirmSession($Token, Request $request)
    {
        $RequestSource = ServiceRequest::where('Token', $Token)->where('Status', '<', 50)->first();
        $OwnerInfo = UserInfo::where('UserName', $RequestSource->Owner)->first();
        $SubmitType = $request->input('submit');
        if ($SubmitType == 'call') {
            $Myapi = new APIClass();
            $Result = $Myapi->TwoDirectionCall($request->input('phoneNumber'), $OwnerInfo->MobileNo, 180000);
            if ($Result == 'error') {
                return abort('404', 'ارتباط برقرار نشد لطفا با پشتیبانی موضوع را در میان بگذارید');
            } else {
                $ServiceState = ServiceRequest::where('Token', $Token)->first();
                if ($ServiceState->Status < 20) {
                    ServiceRequest::where('Token', $Token)->where('Status', '<', 20)->update(['Status' => 21]); // call done but waiting for result from moshaver
                    $MyFinancail = new MoshaverehClass();
                    $MyFinancail->ServiceStart_financial($RequestSource->Provider,$RequestSource->Owner,600000,1000000,$RequestSource->id,'مشاوره');
                }
                return redirect()->back()->with('success', 'عملیات موفقیت آمیز انجام گرفت');
            }
        } elseif ($SubmitType == '2') { // call till 10 min
            ServiceRequest::where('Token', $Token)->where('Status', '<', 20)->update(['Status' => $SubmitType]);
        } elseif ($SubmitType == '3') { // call till 20 min
            ServiceRequest::where('Token', $Token)->where('Status', '<', 20)->update(['Status' => $SubmitType]);
        } elseif ($SubmitType == '11') {   // can not call
            ServiceRequest::where('Token', $Token)->where('Status', '<', 20)->update(['Status' => $SubmitType]);
        } elseif ($SubmitType == '12') { // cancel call
            ServiceRequest::where('Token', $Token)->where('Status', '<', 20)->update(['Status' => $SubmitType]);
        }
    }
    public function ShowMoshavers($CatID)
    {

        $MoshavesClass = new Indexes();
        $MoshaveRole = myappenv::role_worker;
        $Moshaves = $MoshavesClass->GetUsersWithTags($CatID, $MoshaveRole);
        $L3Work = L3Work::where("UID",$CatID)->First();
        $UserHasCreditClass = new Financial();
        if (Auth::check()) {
            $UserHasCredit = $UserHasCreditClass->UserHasCredite(Auth::id(), myappenv::CachCredit);
        } else {
            $UserHasCredit = null;
        }
        return view('Moshavereh.MoshaversList', ['L3Work'=>$L3Work ,'Moshaves' => $Moshaves, 'Price' => 1000000, 'UserHasCredit' => $UserHasCredit]);
    }

    public function DoShowMoshavers(Request $request, $CatID)
    {
        $MyMoshavereh = new MoshaverehClass();
        $Result = $MyMoshavereh->AddMoshaverhRequest(Auth::id(), $request->input('submit'), $CatID);
        if ($Result) {
            $MyMoshavereh->SendMessageToMoshaver();
        } else {
            return abort('404');
        }
    }
}

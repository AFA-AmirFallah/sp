<?php

namespace App\Http\Controllers\Patients;

use App\Http\Controllers\Controller;
use App\myappenv;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
    class MyPat extends Controller
{
    public function patdashboard(){
        return view('Patients.index');
    }
    public function Dopatdashboard(Request $request){

    }

    public function ListOfPat(){
        if(Auth::user()->branch != null && Auth::user()->branch != myappenv::Branch ){
            $mybaranch = ' and UserInfo.branch = ' . Auth::user()->branch;
        }else{
            $mybaranch = '';
        }
        if(Auth::user()->Role == myappenv::role_admin || Auth::user()->Role == myappenv::role_SuperAdmin || Auth::user()->Role == myappenv::role_Accounting  ){
            $ShiftEnable = true;
        }else{
            $ShiftEnable = false;
        }
        $CustomerRole = myappenv::role_customer;
        if(Auth::user()->Role == myappenv::role_admin || Auth::user()->Role == myappenv::role_SuperAdmin || Auth::user()->Role == myappenv::role_Accounting  ){
            $Query = "SELECT UserInfo.UserName as UserNameMain,UserInfo.Name,UserInfo.Family,UserInfo.MobileNo,UserInfo.Email,UserInfo.Status FROM UserInfo 
            WHERE UserInfo.Role = $CustomerRole $mybaranch and Status<>0 ";
        }
        else{
            $UserName = Auth::id();
            $Query = "SELECT UserInfo.UserName as UserNameMain,UserInfo.Name,UserInfo.Family,UserInfo.MobileNo,UserInfo.Email,UserInfo.Status 
            FROM UserInfo INNER JOIN RelatedStaff  
            WHERE UserInfo.Role = $CustomerRole $mybaranch and  RelatedStaff.ResponserID = '$UserName' and RelatedStaff.OwnerUserID = UserInfo.UserName and Status<>0  
            and  RelatedStaff.DeletedBy is null and((RelatedStaff.StartRespns <= now() and RelatedStaff.EndRespns >= now())) 
            GROUP by UserInfo.UserName, UserInfo.Name,UserInfo.Family,UserInfo.MobileNo,UserInfo.Email,UserInfo.Status ";
        }
       $Pats = DB::select($Query);
       return view('Patients.MyPathList',['Pats'=>$Pats,'ShiftEnable'=>$ShiftEnable]);
    }
    public function DoListOfPat(Request $request){

    }
}

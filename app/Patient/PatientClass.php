<?php

namespace App\Patient;

use App\Functions\MarketingClass;
use App\Functions\TextClassMain;
use App\Users\UserClass;
use App\Models\UserInfo;
use App\myappenv;
use Session; 
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PatientClass
{

    public static function  PatientGetter()
    {
        if (Session::has('Patient')) {
            $Target_Patient = Session::get('Patient');
            return $Target_Patient;
        } else {
            return null;
        }
    }

    public static function PatientSetter($UserName)
    {
        Session::put('Patient', $UserName);
        return true;
    }

    public function PatientSetter_1($UserName)
    {
        if ($UserName == 'null') {
            Session::forget('Patient');
            return true;
        }
        Session::put('Patient', $UserName);
        return true;
    }

    private function is_patient_add_before($MobileNo , $branch ){
        $target_user = UserInfo::where('MobileNo',$MobileNo)->where('branch',$branch)->get();
        $mycount = count($target_user);
        if(count($target_user)  > 0){
            return true;
        }else{
            return false;
        }
    }
    public function add_new_patient(Request $request)
    {
        
        $Marker = new MarketingClass();
        $LastExt = DB::table('UserInfo')->latest('Ext')->first();
        $Ext =  $LastExt->Ext;
        $role = myappenv::role_customer;
        $Branch = Auth::user()->branch;
        if($this->is_patient_add_before($request->input('MobileNo'),$Branch)){
            return [
                'result'=>false,
                'msg'=>'بیماری با مشخصات وارد شده در سیستم وجود دارد!'
            ];
        }
        $UserName = UserClass::get_free_username() ;
        $NewUserData = [
            'UserName' => $UserName,
            'Email' => $request->input('MobileNo') . "@nomail.com",
            'password' => Hash::make($request->input('MobileNo')),
            'UserPass' => $request->input('Password'),
            'Name' => $request->input('Name'),
            'Ext' => $Ext + 1,
            'Family' => $request->input('Family'),
            'MobileNo' => $request->input('MobileNo'),
            'Role' => $role,
            'Sex' => $request->input('sex'),
            'Status' => myappenv::User_active_status,
            'MarketingCode' => $Marker->get_marketer(),
            'Marketer' => $Marker->get_marketer(),
            'branch' => $Branch
        ];
        $result =  UserInfo::create($NewUserData);
        if ($result) {
            return [
                'result' => true,
                'data' => $UserName
            ];
        } else {
            return [
                'result' => false,
                'msg' => 'سیستم قادر به افزودن بیمار نیست لطفا با اطلاعات ورودی را بررسی فرمایید!'
            ];
        }
    }
}

<?php

namespace App\Http\Controllers\APIS;

use App\Http\Controllers\Controller;
use App\Models\UserInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use stdClass;

class WebService extends Controller
{
    /**
     * Undocumented function
     *
     * 
     * @param [type] $request
     * Input PhoneNumber
     * @return UserInfo Record
     */
    public function SerchUserByPhone($request)
    {
        $OutPut = new stdClass;
        if(!$request->has('Phone')){
            $OutPut->Status = 2;
            $OutPut->StatusDesc = "شماره تلفن وارد نشده است!";
            return $OutPut;
        }
        $TargetPhone = $request->Phone;
        if (strlen($TargetPhone) > 11) {
            $OutPut->Status = 2;
            $OutPut->StatusDesc = "طول شماره تلفن وارد شده صحیح نمی باشد!";
            return $OutPut;
        }
        if (!is_numeric($TargetPhone)) {
            $OutPut->Status = 2;
            $OutPut->StatusDesc = "فرمت شماره تلفن وارد شده صحیح نمی باشد!";
            return $OutPut;
        }

        $ResultUser = UserInfo::where('MobileNo', $TargetPhone)->orWhere('Phone1', $TargetPhone)->orWhere('Phone2', $TargetPhone)->orWhere('Ext', $TargetPhone)->get();
        $OutPut->Status = 1;
        $OutPut->StatusDesc = "عملیات موفقیت آمیز!";
        $OutPut->Payload = $ResultUser;
        $OutPut = json_encode($OutPut);
        return $OutPut;
    }

    public function WebService($endpoint)
    {
        return 'Your Requested Endpoint is: '.$endpoint;
    }
    /**
     * Undocumented function
     *
     * @param Request $request
     * 
     * return feilds:
     * 1) Status   1: successfull  2: faild  3: error
     * 2) StatusDesc 
     * 3) Payload
     * 
     * @return JsonArray
     */
    public function DoWebService(Request $request,$endpoint)
    {
        if($endpoint == 'voip'){
            $Voip = new VOIP;
            
            return  response($Voip->call_by_outside($request));

        }
        $OutPut = new stdClass;
        if ($request->has('token')) {
            if ($request->token == 'fuiq3fjdy4ywfsahgadjfjhewxnxwyeew@dsjcdjh') {
                if ($request->has('function')) {
                    if ($request->function == 'searchuser') {
                        $OutPut = $this->SerchUserByPhone($request);
                    }
                } else {
                    $OutPut->Status = 2;
                    $OutPut->StatusDesc = " تابع مورد نظر ارسال نشده است!";
                }
            } else {
                $OutPut->Status = 2;
                $OutPut->StatusDesc = " توکن ارسالی معتبر نیست!";
            }
        } else {
            $OutPut->Status = 2;
            $OutPut->StatusDesc = " توکنی  ارسال  نشده است !";
        }
        return $OutPut;
    }
}

<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use App\Models\L3Work;
use App\Models\RespnsType;
use Illuminate\Http\Request;

class Service extends Controller
{
    public function ServiceToBuy($ServiceID){
        $RespnsTypes = RespnsType::where('ID', $ServiceID)->first();
        if($RespnsTypes->hPrice == '0'){
            $targetPrice = $RespnsTypes->CustomerfixPrice;
            $TypeOfService = __("This service offer as session based");
        }else{
            $targetPrice = $RespnsTypes->hPrice;
            $TypeOfService = __("This service offer as hour based");
        }

        return view("WPA.Service.ServiceToBuy",['RespnsTypes'=>$RespnsTypes,'TypeOfService'=>$TypeOfService,'targetPrice'=>$targetPrice]);
    }
    public function DoServiceToBuy($ServiceID){

    }
    public function ServicesWithIndex($IndexID)
    {
        $L3result = L3Work::where('UID',$IndexID)->first();
        $RespnsTypes = RespnsType::all()->where('MainIndex', $IndexID);

        return view("WPA.Service.ServiceList",['RespnsTypes'=>$RespnsTypes,'L3result'=>$L3result]);
    }


    public function DoServicesWithIndex()
    {

    }
}

<?php


namespace App\Functions;

use App\APIS\SmsCenter;
use App\Models\ServiceRequest;
use App\Models\UserCredit;
use App\Models\UserInfo;
use App\myappenv;

class MoshaverehClass
{
    private $RequestToken;
    private $RequestID;
    private $Owner;
    private $Provider;
    public function AddMoshaverhRequest($Owner, $Provider, $CatID)
    {
        $this->Provider = $Provider;
        $this->Owner = $Owner;
        $MyTokenClass = new TokenClass();
        $this->RequestToken = $MyTokenClass->UniqueToken();
        $ServiceRequestData = [
            'Owner' => $Owner,
            'Provider' => $Provider,
            'CatID' => $CatID,
            'Status' => 1,
            'Token' => $this->RequestToken
        ];
        $Result =  ServiceRequest::create($ServiceRequestData);
        $this->RequestID = $Result->id;
        return true;
    }
    public function SendMessageToMoshaver()
    { // To confirm moshaverh session
        $SMSText = "شفاتل زنجیره تامین سلامت ";
        $SMSText .= "مشاور گرامی درخواست مشاوره تلفنی دارید لطفا جهت فعال سازی به لینک زیر مراجعه فرمایید";
        $SMSText .=  route('ConfirmSession', ['Token' => $this->RequestToken]);
        $Mysms = new SmsCenter();
        $ProviderData = UserInfo::where('UserName', $this->Provider)->first();
        $Mysms->OndemandSMS($SMSText, $ProviderData->MobileNo, 13, 'system');
    }

    public function ServiceStart_financial($Provider, $Customer, $ProviderPrice, $CustomerPrice, $ServiceID, $ExtraNote)
    {

        //decrese from customer
        $InsertData = [
            'UserName' => $Customer,
            'Mony' => -1 * $CustomerPrice,
            'Type' => 34,
            'Date' => now(),
            'Note' => $ExtraNote,
            'InvoiceNo' => 'Mo' . $ServiceID,
            'TransferBy' => 'system',
            'CreditMod' => myappenv::CachCredit
        ];
        $Result = UserCredit::create($InsertData);
        $RefrenceID = $Result->id;
        UserCredit::where('ID',$RefrenceID)->update(['ReferenceId'=>$RefrenceID]);
        //increse to provider
        $InsertData = [
            'UserName' => $Provider,
            'Mony' =>  $ProviderPrice,
            'Type' => 34,
            'Date' => now(),
            'Note' => $ExtraNote,
            'InvoiceNo' => 'Mo' . $ServiceID,
            'ReferenceId' => $RefrenceID,
            'TransferBy' => 'system',
            'CreditMod' => myappenv::UnaccessCredit
        ];
        $Result = UserCredit::create($InsertData);

        //Increse to daramad
        $InsertData = [
            'UserName' => myappenv::StackHolder,
            'Mony' =>  $CustomerPrice - $ProviderPrice,
            'Type' => 34,
            'Date' => now(),
            'Note' => $ExtraNote,
            'InvoiceNo' => 'Mo' . $ServiceID,
            'ReferenceId' => $RefrenceID,
            'TransferBy' => 'system',
            'CreditMod' => myappenv::CachCredit
        ];
        $Result = UserCredit::create($InsertData);
    }
}

<?php


namespace App\Functions;


use App\Models\RelatedStaff;
use App\Models\RespnsType;
use App\Models\UserCredit;
use App\myappenv;

class JobsDone
{
    private $UserMony;
    private $RequestUser;
    private $ResponserID;
    private $nowdate;
    private $UserName;
    private $DefMony;
    private $RefrenceID;

    function __construct($RequestUser, $ResponserID, $nowdate, $UserName, $UserMony)
    {
        $this->RequestUser = $RequestUser;
        $this->ResponserID = $ResponserID;
        $this->nowdate = $nowdate;
        $this->UserName = $UserName;
        $this->DefMony = 0;
        $this->UserMony = $UserMony;
    }

    private function SetRelatedStaffPoint($Point)
    {
        $UpdateData = [
            'Confirmer' => $this->UserName,
            'Price' => $this->UserMony,
            'Point' => $Point
        ];
        RelatedStaff::where('OwnerUserID', $this->RequestUser)->where('ResponserID', $this->ResponserID)->where('CreateDate', $this->nowdate)->update($UpdateData);
        $RelatedStaff = RelatedStaff::where('OwnerUserID', $this->RequestUser)->where('ResponserID', $this->ResponserID)->where('CreateDate', $this->nowdate)->first();
        $this->RefrenceID = $RelatedStaff->RelatedCredite;
    }

    private function ConvertTransActions()
    {
        /*
         * This fuction set all  UnaccessCredit transfer to zero by add zero negative Trasactions
         *
         */
        $UserCredit = UserCredit::all()->where('ReferenceId', $this->RefrenceID)->where('CreditMod', myappenv::UnaccessCredit);
        foreach ($UserCredit as $UserCreditItem) {
            $InsertData = [
                'UserName' => $UserCreditItem->UserName,
                'Mony' => $UserCreditItem->Mony * -1,
                'Type' => $UserCreditItem->Type,
                'Date' => now(),
                'Note' => $UserCreditItem->Note,
                'InvoiceNo' => $UserCreditItem->InvoiceNo,
                'PaymentId' => $UserCreditItem->PaymentId,
                'SpecialPaymentId' => $UserCreditItem->SpecialPaymentId,
                'GateWay' => $UserCreditItem->GateWay,
                'ReferenceId' => $UserCreditItem->ReferenceId,
                'TransferBy' => $this->UserName,
                'RealMony' => $UserCreditItem->RealMony * -1,
                'CreditMod' => $UserCreditItem->CreditMod,
                'ZeroRefrenceID' => $UserCreditItem->ID,
                'CreditIndex' => $UserCreditItem->CreditIndex
            ];
            UserCredit::create($InsertData);
        }
    }

    private function AddNewTransation()
    {
        $UserCredit = UserCredit::all()->where('ReferenceId', $this->RefrenceID)->where('ZeroRefrenceID', null)->where('CreditMod', myappenv::UnaccessCredit);
        foreach ($UserCredit as $UserCreditItem) {
            $InsertData = [
                'UserName' => $UserCreditItem->UserName,
                'Mony' => $UserCreditItem->Mony,
                'Type' => $UserCreditItem->Type,
                'Date' => now(),
                'Note' => $UserCreditItem->Note,
                'InvoiceNo' => $UserCreditItem->InvoiceNo,
                'PaymentId' => $UserCreditItem->PaymentId,
                'SpecialPaymentId' => $UserCreditItem->SpecialPaymentId,
                'GateWay' => $UserCreditItem->GateWay,
                'ReferenceId' => $this->RefrenceID,
                'TransferBy' => $this->UserName,
                'RealMony' => $UserCreditItem->RealMony,
                'CreditMod' => myappenv::CachCredit,
                'CreditIndex' => $UserCreditItem->CreditIndex
            ];
            UserCredit::create($InsertData);
        }
        $UpdateZeroRefrenceData = [
            'ZeroRefrenceID' => $this->RefrenceID
        ];
        UserCredit::where('CreditMod', myappenv::UnaccessCredit)->where('ReferenceId', $this->RefrenceID)->where('ZeroRefrenceID', null)->update($UpdateZeroRefrenceData);
        UserCredit::where('CreditMod', myappenv::UnaccessCredit)->where('ReferenceId', $this->RefrenceID)->where('ZeroRefrenceID', '')->update($UpdateZeroRefrenceData);
    }
    private function assign_tags()
    {
        $service_src = RelatedStaff::where('RelatedCredite', $this->RefrenceID)->first();
        $RespnsType_src = RespnsType::where('id', $service_src->RespnsType)->first();
        $MainIndex = $RespnsType_src->MainIndex;
        $customer_index = $RespnsType_src->customer_index;
        $worker_index = $RespnsType_src->worker_index;
        $OwnerUserID = $service_src->OwnerUserID;
        $ResponserID = $service_src->ResponserID;
        Indexes::assign_index_to_user_by_system($OwnerUserID, $customer_index);
        Indexes::assign_index_to_user_by_system($ResponserID, $worker_index);
        return true;
    }

    public function DoFinshWorks($Point)
    {
        $this->SetRelatedStaffPoint($Point);
        $this->ConvertTransActions(); #Set To Zero
        $this->AddNewTransation(); #Add New Transaction
        $this->assign_tags();
        return true;
    }
}

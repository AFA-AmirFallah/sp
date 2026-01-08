<?php


namespace App\Functions;

use App\Models\UserCredit;
use App\myappenv;
use Auth;

class SmartInvoice
{
    public function InsertTmpCredit($TargetUser, $DeviceContractId, $Note)
    {
        $CrediteData = [
            'UserName' => $TargetUser,
            'Mony' => 0,
            'Type' => 14,
            'Date' => now(),
            'Note' => $Note,
            'bill' => $DeviceContractId,
            'TransferBy' => Auth::ID(),
            'CreditMod' => myappenv::CachCredit,
            'branch' => Auth::user()->branch
        ];
        $Result = UserCredit::create($CrediteData);
        $ReferenceId = $Result->id;
        $UpdateRefrence = [
            'ReferenceId' => $ReferenceId
        ];
        UserCredit::where('ID', $ReferenceId)->update($UpdateRefrence);
        return $Result->id;
    }

    public function InsertInitCredit($TargetUser, $DeviceContractId, $Mony, $Note)
    {
        $CrediteData = [
            'UserName' => $TargetUser,
            'Mony' => $Mony,
            'Type' => 15,
            'Date' => now(),
            'Note' => $Note,
            'bill' => $DeviceContractId,
            'TransferBy' => Auth::ID(),
            'CreditMod' => myappenv::CachCredit,
            'branch' => Auth::user()->branch
        ];
        $Result = UserCredit::create($CrediteData);
        $ReferenceId = $Result->id;
        $UpdateRefrence = [
            'ReferenceId' => $ReferenceId
        ];
        UserCredit::where('ID', $ReferenceId)->update($UpdateRefrence);
        return $Result->id;
    }

    public function InsertCredit($TargetUser, $DeviceContractId, $Mony, $CreditMod, $ReferenceId, $Note)
    {
        $CrediteData = [
            'UserName' => $TargetUser,
            'Mony' => $Mony,
            'Type' => 16,
            'Date' => now(),
            'Note' => $Note,
            'bill' => $DeviceContractId,
            'TransferBy' => Auth::ID(),
            'CreditMod' => $CreditMod,
            'ReferenceId' => $ReferenceId,
            'branch' => Auth::user()->branch
        ];
        $Result = UserCredit::create($CrediteData);
        return $Result->id;
    }


    public function MakeIndex()
    {

    }

}

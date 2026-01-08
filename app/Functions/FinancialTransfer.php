<?php

namespace App\Functions;

use App\Models\UserCredit;
use Auth;

class FinancialTransfer
{
    public $RefrenceID;
    public $SanadName;
    public $bill;
    public $InvoiceNo;
    public $ConfirmBy;
    public $Confirmdate;

    public function AddSanad($SanadName, $SanadCreditIndex, $bill, $AutoConfirm = false, $InvoiceNo = '', $RefrenceID = null)
    {
        $this->SanadName = $SanadName;
        $this->SanadCreditIndex = $SanadCreditIndex;
        $this->bill = $bill;
        $this->InvoiceNo = $InvoiceNo;
        $this->RefrenceID = $RefrenceID;
        if ($AutoConfirm) {
            $this->ConfirmBy = Auth::id();
            $this->Confirmdate = now();
        } else {
            $this->ConfirmBy = null;
            $this->Confirmdate = null;
        }
    }
    public function AddTransaction($UserName, $Mony, $Type, $CreditMod, $branch)
    {
        if ($this->RefrenceID  == null) {
            $TransactionData = [
                'UserName' => $UserName,
                'Mony' => $Mony,
                'Type' => $Type,
                'Date' => now(),
                'Note' => $this->SanadName,
                'TransferBy' => $this->ConfirmBy,
                'CreditMod' => $CreditMod,
                'ConfirmBy' => 'system',
                'InvoiceNo' => $this->InvoiceNo,
                'Confirmdate' => $this->Confirmdate,
                'branch' => $branch
            ];
            $insertResult = UserCredit::create($TransactionData);
            $this->RefrenceID = $insertResult->id;
            UserCredit::where('ID', $this->RefrenceID)->update(['ReferenceId' => $this->RefrenceID]);
            return $insertResult;
        } else {
            $TransactionData = [
                'UserName' => $UserName,
                'Mony' => $Mony,
                'Type' => $Type,
                'Date' => now(),
                'Note' => $this->SanadName,
                'TransferBy' => $this->ConfirmBy,
                'CreditMod' => $CreditMod,
                'ConfirmBy' => 'system',
                'InvoiceNo' => $this->InvoiceNo,
                'Confirmdate' => $this->Confirmdate,
                'branch' => $branch,
                'ReferenceId' => $this->RefrenceID
            ];
            $insertResult = UserCredit::create($TransactionData);
            return $insertResult;
        }
    }


    public function AddCredit( $CreditAttr)
    {
        $UserName = $CreditAttr['UserName'];
        $Mony = $CreditAttr['Mony'];
        $Type = $CreditAttr['Type'];
        $CreditMod = $CreditAttr['CreditMod'];
        $branch  = $CreditAttr['branch'];
        $SanadName = $CreditAttr['SanadName'];
        $TransferBy = $CreditAttr['TransferBy'];
        $ConfirmBy = $CreditAttr['ConfirmBy'];
        $TransactionData = [
            'UserName' => $UserName,
            'Mony' => $Mony,
            'Type' => $Type,
            'Date' => now(),
            'Note' => $SanadName,
            'TransferBy' => $TransferBy,
            'CreditMod' => $CreditMod,
            'ConfirmBy' => $ConfirmBy,
            'Confirmdate' => now(),
            'branch' => $branch
        ];
        $insertResult = UserCredit::create($TransactionData);
        return $insertResult;
    }
}

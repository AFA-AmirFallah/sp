<?php


namespace App\Functions;
use DB;
use App\Models\UserCredit;
use App\Models\RelatedStaff;
use App\myappenv;


class Transfer
{
    protected $StackHolder;
    protected $DefMony;
    protected $DefMonyTotall;
    protected $ResponserID;
    protected $RequestUser;
    protected $RespnsType;
    protected $StartRespns;
    protected $EndRespns;
    protected $Note;
    protected $UserName;
    protected $nowdate;
    protected $RefrenceID;
    protected $Holders;
    protected $CreditePlan;
    protected $SystemOwner;
    protected $Partner;
    protected $CreditIndex;

    function __construct($RequestUser, $ResponserID, $nowdate, $UserName, $StartRespns, $EndRespns, $RespnsType, $Note, $Holders, $CreditePlan, $Branch = 1 , $CreditIndex = null ) 
    {
        $DefMony = 0;
        $this->StackHolder = myappenv::StackHolder;
        $this->SystemOwner = myappenv::SystemOwner;
        $this->Partner = myappenv::Partner;
        $this->RequestUser = $RequestUser;
        $this->ResponserID = $ResponserID;
        $this->nowdate = $nowdate;
        $this->UserName = $UserName;
        $this->StartRespns = $StartRespns;
        $this->EndRespns = $EndRespns;
        $this->RespnsType = $RespnsType;
        $this->Note = $Note;
        $this->DefMonyTotall = $DefMony;
        $this->DefMony = $DefMony;
        $this->Holders = $Holders;
        $this->CreditePlan = $CreditePlan;
        $this->Branch = $Branch;
        $this->CreditIndex = $CreditIndex;
    }

    private function DecriseFromBuyer()
    {
        $nowdate = date('Y-m-d H:i:s');
        $ArrTransferCredit0 = array($this->RequestUser, $this->lessMony, "66", $nowdate, $this->Note, $this->UserName, $this->CreditMeta);
        if ($this->CreditMeta == '1') {
            $this->CreditMeta = "2";
        }
        $this->CreditTransfer($ArrTransferCredit0, TRUE);
    }

    private function IncreseToWorker()
    {
        $nowdate = date('Y-m-d H:i:s');
        if ($this->CreditMeta == 1) {
            $ArrTransferCredit1 = array($this->ResponserID, $this->AddMony, "66", $nowdate, $this->Note, $this->UserName, "2");
        } else {
            $ArrTransferCredit1 = array($this->ResponserID, $this->AddMony, "66", $nowdate, $this->Note, $this->UserName, $this->CreditMeta);
        }
        $this->CreditTransfer($ArrTransferCredit1, FALSE);
    }


    private function IncreseToHolders()
    {

        $Queryp = "SELECT RelatedStaff.OwnerUserID, RelatedStaff.ResponserID,UserInfo.Name ,
UserInfo.Family, RelatedStaff.ContractID, RelatedStaff.CreateDate, RelatedStaff.CreateBy,
RelatedStaff.StartRespns, RelatedStaff.EndRespns, RelatedStaff.RespnsType,RespnsType.RespnsTypeName,
RelatedStaff.DeletedBy, RelatedStaff.DeletedTime, RelatedStaff.Note ,RelatedStaff.Point,RelatedStaff.Confirmer ,
RespnsType.hPrice FROM RelatedStaff INNER JOIN UserInfo INNER JOIN RespnsType where RelatedStaff.OwnerUserID = '$this->RequestUser' and UserInfo.UserName = RelatedStaff.ResponserID and RespnsType.id = RelatedStaff.RespnsType and RelatedStaff.DeletedBy is null and RelatedStaff.RespnsType >10000 and EndRespns > now() ";
        $Resultp = DB::select($Queryp);
        foreach ($Resultp as $rowp) {
            $nowdate = date('Y-m-d H:i:s');
            if (in_array($rowp->ResponserID, $this->Holders) && $rowp->RespnsTypeName == $this->CatHolders) {
                $ResponserID1 = $rowp->ResponserID;
                $NoteText = $this->Note . "</br> " . $rowp->RespnsTypeName;
                $PDefMony = $this->DefMonyTotall * $rowp->hPrice / 100;
                $ArrTransferCredit8 = array($ResponserID1, $PDefMony, "66", $nowdate, $NoteText, $this->UserName, $this->CreditMeta);
                $this->CreditTransfer($ArrTransferCredit8, FALSE);
                $this->DefMony -= $PDefMony;
            }
        }
    }


    private function MCatHolders()
    {
        $nowdate = date('Y-m-d H:i:s');
        $MyArr = $this->CatHolders;
        if($MyArr == null){
            $N = 0;
        }else{
            $N = count($MyArr);
        }

        $j = '0';
        for ($i = 0; $i < $N; $i++) {
            $Holders = $MyArr [$i][$j];
            $MyArr3 = explode(",", $Holders);
            $this->UserNameHolders = $MyArr3[$j];
            $this->CatHolders = $MyArr3[$j + 1];
            $Queryp = "SELECT RelatedStaff.OwnerUserID, RelatedStaff.ResponserID,UserInfo.Name , UserInfo.Family,
 RelatedStaff.ContractID, RelatedStaff.CreateDate, RelatedStaff.CreateBy, RelatedStaff.StartRespns, RelatedStaff.EndRespns,
 RelatedStaff.RespnsType,RespnsType.RespnsTypeName, RelatedStaff.DeletedBy, RelatedStaff.DeletedTime, RelatedStaff.Note ,
 RelatedStaff.Point,RelatedStaff.Confirmer ,RespnsType.hPrice FROM RelatedStaff INNER JOIN UserInfo INNER JOIN RespnsType where  RelatedStaff.OwnerUserID = '$this->RequestUser' and UserInfo.UserName = RelatedStaff.ResponserID and RespnsType.id = RelatedStaff.RespnsType and  RelatedStaff.DeletedBy is null and RelatedStaff.RespnsType >10000 and EndRespns > now()  and RespnsType.RespnsTypeName='$this->CatHolders'  and RelatedStaff.ResponserID= '$this->UserNameHolders' ";
            $Resultp = DB::select($Queryp);
            foreach ($Resultp as $Resultpinst){
                $rowp = $Resultpinst;
            }
            $ResponserID1 = $rowp->ResponserID;
            $NoteText = $this->Note . "</br> " . $this->CatHolders;
            $PDefMony = $this->DefMonyTotall * $rowp->hPrice / 100;
            $ArrTransferCredit8 = array($this->UserNameHolders, $PDefMony, "66", $nowdate, $NoteText, $this->UserName, $this->CreditMeta);
            $this->CreditTransfer($ArrTransferCredit8, FALSE);
            $this->DefMony -= $PDefMony;
        }
    }


    private function IncreseToBenifites()
    {
        $nowdate = date('Y-m-d H:i:s');
        if ($this->CreditMeta > 2) {
            $CrediteMeta = $this->CreditMeta;
        } else {
            $CrediteMeta = "1";
        }
        if ($this->CreditePlan == "0") { // without partner and system owner
            $ArrTransferCredit6 = array($this->StackHolder, $this->DefMony, "66", $nowdate, $this->Note, $this->UserName, $CrediteMeta);
            $this->CreditTransfer($ArrTransferCredit6, FALSE);
        } elseif ($this->CreditePlan == "1") { //dgkar and arta
            $SystemOwnerPrice = $this->DefMony / 100 * 10;
            $ArrTransferCredit6 = array($this->SystemOwner, $SystemOwnerPrice, "66", $nowdate, $this->Note, $this->UserName, $CrediteMeta);
            $this->CreditTransfer($ArrTransferCredit6, FALSE);
            $StackHolderPrice = $this->DefMony - $SystemOwnerPrice;
            $ArrTransferCredit6 = array($this->StackHolder, $StackHolderPrice, "66", $nowdate, $this->Note, $this->UserName, $CrediteMeta);
            $this->CreditTransfer($ArrTransferCredit6, FALSE);
        } elseif ($this->CreditePlan == "2") { //dgkar and arta and haftsaz
            $SystemOwnerPrice = $this->DefMony / 100 * 1;
            $ArrTransferCredit6 = array($this->SystemOwner, $SystemOwnerPrice, "66", $nowdate, $this->Note, $this->UserName, $CrediteMeta);
            $this->CreditTransfer($ArrTransferCredit6, FALSE);
            $PartnerPrice = $this->DefMony / 100 * 50;
            $ArrTransferCredit6 = array($this->Partner, $PartnerPrice, "66", $nowdate, $this->Note, $this->UserName, $CrediteMeta);
            $this->CreditTransfer($ArrTransferCredit6, FALSE);
            $StackHolderPrice = $this->DefMony - $SystemOwnerPrice - $PartnerPrice;
            $ArrTransferCredit6 = array($this->StackHolder, $StackHolderPrice, "66", $nowdate, $this->Note, $this->UserName, $CrediteMeta);
            $this->CreditTransfer($ArrTransferCredit6, FALSE);
        }


    }

    private function FinalizeProcess()
    {
        $RelatedStafData =[
            'RelatedCredite'=>$this->RefrenceID
        ];
        RelatedStaff::where('OwnerUserID',$this->RequestUser)->where('ResponserID',$this->ResponserID)->where('CreateDate',$this->nowdate)->update($RelatedStafData);
        $UserCrediteData =[
            'ReferenceId'=>$this->RefrenceID
        ];
        UserCredit::where('ID',$this->RefrenceID)->update($UserCrediteData);
    }

    private function CreditTransfer($ArrTransferCredit, $InitInsert)
    {

        $this->UserName1 = $ArrTransferCredit[0];
        $this->Mony1 = $ArrTransferCredit[1];
        $this->Type1 = $ArrTransferCredit[2];
        $this->Date1 = $ArrTransferCredit[3];
        $this->Note1 = $ArrTransferCredit[4];
        $this->TransferBy1 = $ArrTransferCredit[5];
        $this->CreditMod1 = $ArrTransferCredit[6];
        if ($InitInsert) {
            $TransactionData = [
                'UserName' => $this->UserName1,
                'Mony' => $this->Mony1,
                'Type' => $this->Type1,
                'Date' => $this->Date1,
                'Note' => $this->Note1,
                'TransferBy' => $this->TransferBy1,
                'CreditMod' => $this->CreditMod1,
                'branch' => $this->Branch,
                'CreditIndex'=> $this->CreditIndex
            ];
            $insertResult = UserCredit::create($TransactionData);
            $this->RefrenceID = $insertResult->id;
            return (TRUE);
        } else {
            $TransactionData = [
                'UserName' => $this->UserName1,
                'Mony' => $this->Mony1,
                'Type' => $this->Type1,
                'Date' => $this->Date1,
                'Note' => $this->Note1,
                'TransferBy' => $this->TransferBy1,
                'CreditMod' => $this->CreditMod1,
                'ReferenceId' => $this->RefrenceID,
                'branch' => $this->Branch,
                'CreditIndex'=> $this->CreditIndex
            ];
            UserCredit::create($TransactionData);
            return (TRUE);
        }
    }

    public function TransferShift()
    {
        $RelatedStaffData = [
            'OwnerUserID'=>$this->RequestUser,
            'ResponserID'=>$this->ResponserID,
            'CreateDate'=> $this->nowdate,
            'CreateBy'=>$this->UserName,
            'StartRespns'=>$this->StartRespns,
            'EndRespns'=>$this->EndRespns,
            'RespnsType'=>$this->RespnsType,
            'Note'=> $this->Note,
            'EndNote'=>'',
            'branch'=>$this->Branch
        ];
        $result = RelatedStaff::create($RelatedStaffData);
        return true;
    }

    public function SetLessMony($LessMony)
    {
        $this->lessMony = $LessMony;
    }

    public function AddMonyToWorkers($AddMony)
    {
        $this->AddMony = $AddMony;
    }

    public function SetTrasactionNote($Note)
    {
        $this->Note = $Note;
    }

    public function SetCreditMode($CrediteMode)
    {
        $this->CreditMeta = $CrediteMode;
    }


    public function SetCatHolders($MyArr2)
    {
        $this->CatHolders = $MyArr2;
    }

    public function TransferWithPrice()
    {
        $this->DefMonyTotall = $this->DefMony = ($this->AddMony + $this->lessMony) * (-1);
        $this->DecriseFromBuyer();
        $this->IncreseToWorker();
        //$this->IncreseToHolders();
        $this->MCatHolders();
        $this->IncreseToBenifites();
        $this->FinalizeProcess();


    }
}

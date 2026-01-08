<?php

namespace App\Http\Controllers\Patients;

use App\Http\Controllers\Controller;
use App\Http\Controllers\notification\notification_main;
use App\Models\Ticket;
use App\Models\TicketMain;
use App\Models\UserInfo;
use App\myappenv;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use PhpParser\JsonDecoder;
use SebastianBergmann\Exporter\Exporter;

class Workflow extends Controller
{
    private function GetUserWorkflow($RequestUser)
    {
        $TargetTicket = TicketMain::where('UserName', $RequestUser)->where('State', '10001')->first();
        if ($TargetTicket == null) {
            $savedData = [
                'UserName' => $RequestUser,
                'Subject' => 'روال کار',
                'State' => '10001',
                'Text' => 'روال کار',
            ];
            $Result = TicketMain::create($savedData);
            return $Result->id;
        } else {
            return $TargetTicket->TicketID;
        }
    }
    private function GetMaxTicketID($MainTeiketID)
    {
        $maxId = Ticket::where('TicketID', $MainTeiketID)->max('SubTicketID');
        if ($maxId == null) {
            return 1;
        } else {
            return $maxId + 1;
        }
    }
    public function Workflow($RequestUser)
    {
        $TargetUser = UserInfo::where('UserName', $RequestUser)->first();
        if ($TargetUser == null) {
            return abort('404', 'کاربر مورد نظر در سیستم وجود ندارد!');
        } else {
            if ($TargetUser->Role != myappenv::role_customer) {
                return abort('404', 'روال کار برای کاربر مورد نظر وجود ندارد!');
            } else {
                $Userinfo = UserInfo::where('UserName', $RequestUser)->first();
                $TiketID = $this->GetUserWorkflow($RequestUser);
                $Query = "SELECT t.Text , t.created_at ,ui.UserName , ui.Name , ui.Family from Ticket t inner join UserInfo ui on t.FromUser = ui.UserName where t.TicketID = $TiketID order by SubTicketID desc";
                $SubTickets = DB::select($Query);
                return view('Patients.Workflow', ['SubTickets' => $SubTickets, 'UserInfo' => $TargetUser, 'TiketID' => $TiketID]);
            }
        }
    }
    public function DoWorkflow(Request $request, $RequestUser)
    {
        //dd($request->input());

        if ($request->input('submit') == 'replay') {
            $WorkflowData = [
                'TicketID' => $request->input('TiketID'),
                'SubTicketID' => $this->GetMaxTicketID($request->input('TiketID')),
                'FromUser' => Auth::user()->UserName,
                'Text'=>$request->input('ce'),
                'CreateDate'=>now(),
                'Attachment'=>''
            ];
            Ticket::create($WorkflowData);
            return redirect()->back()->with('success','روال کاری به سیستم اضافه شد!');
        }
    }
    public function AddWorkFlow($CoustomerId , $CreatorId , $MainText  ){
        $MainTeiketID = $this->GetUserWorkflow($CoustomerId);
        $WorkflowData = [
            'TicketID' => $MainTeiketID,
            'SubTicketID' => $this->GetMaxTicketID($MainTeiketID),
            'FromUser' => $CreatorId,
            'Text'=>$MainText,
            'CreateDate'=>now(),
            'Attachment'=>''
        ];
        Ticket::create($WorkflowData);
        //todo for saman impement template
        /*
        $TargetCustomer = UserInfo::where('UserName',$CoustomerId)->first();
        $SamanUser = '09124597014';
        if($TargetCustomer->branch == 7 && $CreatorId != $SamanUser){ //saman user only add automatic notification
            $MyNotification = new notification_main();
            $Continner = $TargetCustomer->Name . ' ' . $TargetCustomer->Family. ': '. $MainText;
            $EmailText = strip_tags($Continner);
            $Continner .= '<br>'.'<a href="'. route('Workflow',['RequestUser'=>$CoustomerId]) .'"> نمایش روال کار</a>';
            $AlertType = 1;
            $MyNotification->CreateNotification($SamanUser,Auth::id(),$Continner,$AlertType);
            $HeaderText = 'مدیر محترم بیمه سامان  ';
            $subject = ' تغییر وضعیت درخواست' . $TargetCustomer->Name . ' ' . $TargetCustomer->Family;
            $Title = 'اعلام گردش کار';
            

            try{
             //   Mail::to('n.ebrahimi@samaninsurance.ir')->send(new \App\Mail\MyTestMail($subject,$HeaderText,$EmailText,$Title));
   //             Mail::to('rad.kaveh@gmail.com')->send(new \App\Mail\MyTestMail($subject,$HeaderText,$EmailText,$Title));
    
            }
            catch(Exporter $e){

            }
            //Mail::to('afa.private@gmail.com')->send(new \App\Mail\MyTestMail($subject,$HeaderText,$EmailText,$Title));
        }*/
        return true;

    }
}

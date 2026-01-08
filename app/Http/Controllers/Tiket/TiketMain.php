<?php

namespace App\Http\Controllers\Tiket;

use App\APIS\SmsCenter;
use App\Users\UserClass;
use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\myappenv;
use Illuminate\Http\Request;
use App\Models\ticket_recivers;
use App\Models\TicketMain;
use Auth;
use DB;
use Illuminate\Support\Facades\Redirect;

class TiketMain extends Controller
{
    public function Tiket($TicketID  = null)
    {

        // dd(__(myappenv::TicketState1[0][1]));
        if ($TicketID  == null) {
            $ticket_recivers = ticket_recivers::all();
            $UserName = Auth::id();
            $Query = "SELECT * FROM TicketMain WHERE State < 1000 and (FromUser = '$UserName' OR UserName = '$UserName' ) ORDER BY TicketID DESC";
            $Tickets = DB::select($Query);
            if (myappenv::DashboardTheme == 'Theme2') {
                return view('Theme2.Tiket.TiketList', ['Tickets' => $Tickets, 'ticket_recivers' => $ticket_recivers]);
            } else {
                return view('Tiket.TiketList', ['Tickets' => $Tickets, 'ticket_recivers' => $ticket_recivers]);
            }
        } else {
            $Query = "SELECT TicketMain.* ,CONCAT(UserInfo.Name,' ',UserInfo.Family) as UserInfoName ,UserInfo.avatar,UserInfo.UserName as Userinfo from TicketMain INNER JOIN UserInfo on TicketMain.FromUser = UserInfo.UserName WHERE TicketMain.TicketID = $TicketID";
            $MainTicket = DB::select($Query);
            if(!isset($MainTicket[0])){
                return abort(404);
            }
            if ($MainTicket[0]->FromUser == Auth::id() || $MainTicket[0]->UserName == Auth::id()) {
                $Query = "SELECT Ticket.*,CONCAT(UserInfo.Name,' ',UserInfo.Family) as UserInfoName ,UserInfo.avatar,UserInfo.UserName as Userinfo FROM Ticket INNER JOIN UserInfo on Ticket.FromUser = UserInfo.UserName WHERE TicketID = $TicketID";
                $SubTickets = DB::select($Query);
                if (myappenv::DashboardTheme == 'Theme2') {
                    return view('Theme2.Tiket.TicketSelected', ['MainTicket' => $MainTicket[0], 'SubTickets' => $SubTickets]);
                } else {
                    return view('Tiket.TicketSelected', ['MainTicket' => $MainTicket[0], 'SubTickets' => $SubTickets]);
                }
            } else {
                return abort(404);
            }
        }
    }

    public function DoTiket(Request $request, $TicketID  = null)
    {
        if ($request->axios) {
            if ($request->function == 'get_open_tiket') {
                $TiketCount =  TicketMain::where('UserName', Auth::id())->where('LastReplyUser', '!=', Auth::id())->get();
                return $TiketCount->count();
            }
        }

        if ($request->has("CloseTiket")) {
            $SaveData  = [
                'State' => 100,
                'Point' => $request->CloseTiket
            ];
            TicketMain::where('TicketID', $TicketID)->update($SaveData);
            return redirect()->back()->with('success', 'تیکت با موفقت به اتمام رسید!');
        }
        if ($request->input('submit') == 'replay') {
            $UserName = Auth::id();
            if (Auth::user()->Role >= myappenv::role_admin) {
                if (myappenv::DashboardTheme == 'Theme2') {
                    $VText = $request->input('cee');
                } else {
                    $VText = $request->input('ce');
                }
            } else {

                $VText = strip_tags($request->input('cee'));

               
            }

            $Query = "Select  IFNULL(max(SubTicketID) + 1, 1) as maxid FROM Ticket WHERE TicketID = $TicketID";
            $maxid = DB::select($Query);
            $maxid = $maxid[0]->maxid;
            $tiketData = [
                'TicketID' => $TicketID,
                'SubTicketID' => $maxid,
                'FromUser' => $UserName,
                'CreateDate' => now(),
                'Text' => $VText,
                'Attachment' => ''
            ];
            Ticket::create($tiketData);
            $MainTicket = TicketMain::where('TicketID', $TicketID)->first();
            if ($MainTicket->FromUser == Auth::id()) {
                $State = 0;
            } else {
                $State = 1;
                $MySMS = new SmsCenter();
                $CustomerText = myappenv::CenterName;
                $CustomerText .= ' کاربر گرامی پیام شما پاسخ داده شدید. با مراجعه به پنل کاربری خود میتوانید پیام های خود را مشاهده فرمایید';
                $MySMS->OndemandSMS($CustomerText, $MainTicket->FromUser, 'tnks', $MainTicket->FromUser);
            }
            TicketMain::where('TicketID', $TicketID)->update(['State' => $State]);
            return redirect()->back()->with('sucess', 'ارسال تیکت انجام شد!');
        } elseif ($request->input('submit') == 'DeskAdd') {

            $UserName = Auth::id();
            $Subject = strip_tags($request->input('subject'));
            $VText = strip_tags($request->input('ce'));
            $VPriority = $request->input('TicketPeriority');
            $TouserID = $request->input('ToUser');
            if (is_numeric($TouserID)) {
                $UserSrc = ticket_recivers::where('id', $TouserID)->first();
                $ToUser = $UserSrc->TickeReciver;
            } else {
                $ToUser = strip_tags($TouserID);
            }
            $SaveData  = [
                'UserName' => $ToUser,
                'Subject' => $Subject,
                'Text' => $VText,
                'CreateDate' => now(),
                'State' => 0,
                'FromUser' => $UserName,
                'LastReplyUser' => $UserName,
                'Priority' => $VPriority
            ];
            TicketMain::create($SaveData);
            return redirect()->back()->with('sucess', 'ارسال تیکت انجام شد!');
        } else {
            $UserName = Auth::id();
            $Subject = strip_tags($request->input('subject'));
            $VText = strip_tags($request->input('ce'));
            $VPriority = $request->input('TicketPeriority');
            $TouserID = $request->input('ToUser');
            if (is_numeric($TouserID)) {
                $UserSrc = ticket_recivers::where('id', $TouserID)->first();
                $ToUser = $UserSrc->TickeReciver;
            } else {
                $ToUser = strip_tags($TouserID);
            }
            $SaveData  = [
                'UserName' => $ToUser,
                'Subject' => $Subject,
                'Text' => $VText,
                'CreateDate' => now(),
                'State' => 0,
                'FromUser' => $UserName,
                'LastReplyUser' => $UserName,
                'Priority' => $VPriority
            ];
            TicketMain::create($SaveData);
            return redirect()->back()->with('sucess', 'ارسال تیکت انجام شد!');
        }
    }

    public function ticketsetting()
    {
        $ticket_recivers = ticket_recivers::all();
        return view('Tiket.TicketReciverSetting', ['ticket_recivers' => $ticket_recivers]);
    }
    public function Doticketsetting(Request $request)
    {
        // dd($request->input());
        if ($request->has('DeleteReciver')) {
            ticket_recivers::where('id', $request->input('DeleteReciver'))->delete();
            return redirect()->route('ticketsetting');
        }
        if ($request->has('submit')) {
            if ($request->input('submit') == 'add') {
                $request->validate([
                    'TicketText' => 'required',
                    'TickeReciver' => 'required'
                ], [
                    'TicketText.required' => 'مشخص سازی نقش گیرنده الزامی است!',
                    'TickeReciver.required' => 'مشخص سازی نام کاربری گیرنده الزامی است!',
                ]);
                $MyUser = new UserClass();
                if ($MyUser->IsUserExist($request->input('TickeReciver'))) {
                    $ticketReciverData = [
                        'TicketText' => $request->input('TicketText'),
                        'TickeReciver' => $request->input('TickeReciver')

                    ];
                    ticket_recivers::create($ticketReciverData);
                    return redirect()->back()->with('success', __("Transaction done!"));
                } else {
                    return redirect()->back()->with('error', __("The username is not exist!"));
                }
            }
        }
    }
}

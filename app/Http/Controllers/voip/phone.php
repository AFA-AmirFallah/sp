<?php

namespace App\Http\Controllers\voip;

use App\Functions\ConsultClass;
use App\Functions\persian;
use App\Http\Controllers\Controller;
use App\Models\cdr;
use App\Models\L3Work;
use App\Models\UserInfo;
use App\Models\WorkerSkils;
use App\SEO\meta_keyword;
use App\Users\UserClass;
use App\voip\Voip_sync;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class phone extends Controller
{
    public function phone()
    {
        return view('voip.phone');
    }
    public function Dophone(Request $request)
    {
        if ($request->ajax) {
            if ($request->function == 'load_list') {
                return view('voip.phone_contact_list', ['contact_list' => []])->render();

            }
            if ($request->function == 'search_text') {
                $search_text = $request->search;
                $Query = "SELECT Name , Family , MobileNo from UserInfo ui  WHERE Status > 100 and  CONCAT(Name ,' ' , Family,' ', MobileNo ) LIKE '%$search_text%' ";
                $contact_list = DB::select($Query);
                $view = view('voip.phone_contact_list', ['contact_list' => $contact_list])->render();
                return $view;
            }
            if ($request->function == 'recent') {
                $username = Auth::id();
                $Query = "SELECT mc.call_number as MobileNo ,ui.Name,ui.Family,mc.created_at FROM my_calls mc left join UserInfo ui on mc.answer_username = ui.UserName where mc.caller = '$username' limit 50";
                $recent_list = DB::select($Query);
                $view = view('voip.phone_contact_list', ['contact_list' => $recent_list])->render();
                return $view;
            }

        }
        $voip = new ConsultClass;
        $my_phone = $request->src_phone;
        $target_phone = $request->target;
        $output = $voip->BothSideCall($my_phone, $target_phone);
        return $output;
    }
    public function voip_main()
    {
        $key_words = new meta_keyword;

        $persian = new persian;
        $persian_now = $persian->TodayPersian();
        // $cdr_src = cdr::whereDate('calldate', '=', now())->orderBy('calldate', 'desc')->get();
        $query = "select cdr.* , ui.UserName , ui.Name , ui.Family , ui.Sex , uir.Name as rName ,  uir.Family as rFamily
        from cdrs  cdr left join UserInfo ui on ui.MobileNo = cdr.src
        left join UserInfo uir on uir.UserName = cdr.related_user
        where (cdr.todo_flag is null or cdr.todo_flag = 0)  and  DATE(cdr.calldate) = CURDATE() order by cdr.calldate desc";
        $cdr_src = DB::select($query);
        $query = "select cdr.* , ui.UserName , ui.Name , ui.Family , ui.Sex , uir.Name as rName ,  uir.Family as rFamily
        from cdrs  cdr left join UserInfo ui on ui.MobileNo = cdr.src
        left join UserInfo uir on uir.UserName = cdr.related_user
        where cdr.todo_flag = 1 order by cdr.calldate desc";
        $cdr_important = DB::select($query);
        $Tags = $key_words->get_all_tags();
        $user_class = new UserClass;
        $operator_src = $user_class->get_all_operator();
        return view('voip.voip_report', ['operator_src' => $operator_src, 'Tags' => $Tags, 'cdr_src' => $cdr_src, 'cdr_alerts_src' => $cdr_important, 'StartDate' => $persian_now, 'EndDate' => $persian_now]);
    }
    private function filter_records(Request $request)
    {
        $Persian = new persian();
        $start_date = $Persian->MiladiDate($request->input('StartDate'));
        $end_date = $Persian->MiladiDate($request->input('EndDate'));
        if ($request->has('caller_phone') && $request->caller_phone != null) {
            $caller_phone = $request->caller_phone;
            $query = "select * from cdrs where date(calldate) >= '$start_date' and date(calldate) <= '$end_date' and(src = '$caller_phone' or dst = '$caller_phone' )";
            $cdr_src = DB::select($query);
        } else {
            $cdr_src = cdr::whereDate('calldate', '>=', $start_date)->whereDate('calldate', '<=', $end_date)->orderBy('calldate', 'desc')->get();
        }
        $cdr_important = cdr::where('todo_flag', 1)->orderBy('calldate', 'desc')->get();
        $key_words = new meta_keyword;
        $Tags = $key_words->get_all_tags();
        $user_class = new UserClass;
        $operator_src = $user_class->get_all_operator();
        return view('voip.voip_report', ['operator_src' => $operator_src, 'Tags' => $Tags, 'cdr_src' => $cdr_src, 'cdr_alerts_src' => $cdr_important, 'StartDate' => $request->input('StartDate'), 'caller_phone' => $request->caller_phone, 'EndDate' => $request->input('EndDate')]);

    }
    private function add_report_base($cdr_id, $report_text)
    {
        $persian = new persian;
        $cdr_src = cdr::find($cdr_id);
        if ($cdr_src == null) {
            return false;
        }
        $insert_view = view('voip.voip_report_user_input', [
            'user' => Auth::user()->Name . ' ' . Auth::user()->Family,
            'date' => $persian->MyPersianNow(),
            'text' => $report_text
        ])->render();
        $cdr_src->more_data = $cdr_src->more_data . $insert_view;
        $cdr_src->save();
        return true;
    }
    private function add_report(Request $request)
    {
        $cdr_id = $request->cdr_id;
        $report_text = $request->report_text;
        return $this->add_report_base($cdr_id, $report_text);
    }
    private function get_report(Request $request)
    {
        $cdr_id = $request->cdr_id;
        $cdr_src = cdr::find($cdr_id);
        if ($cdr_src == null) {
            return false;
        }
        return $cdr_src->more_data ?? '';
    }
    private function set_alert(Request $request)
    {
        $cdr_id = $request->cdr_id;
        $cdr_src = cdr::find($cdr_id);
        if ($cdr_src == null) {
            return false;
        }
        $cdr_src->todo_flag = 1;
        $cdr_src->save();
        return true;
    }
    private function reset_alert(Request $request)
    {
        $cdr_id = $request->cdr_id;
        $cdr_src = cdr::find($cdr_id);
        if ($cdr_src == null) {
            return false;
        }
        $cdr_src->todo_flag = '';
        $cdr_src->save();
        return true;
    }
    private function add_user_tag($indexar, $RequestUser)
    {
        $TL3WorkSrc = L3Work::where('UID', $indexar)->first();
        $TWorkCat = $TL3WorkSrc->WorkCat;
        $TL1ID = $TL3WorkSrc->L1ID;
        $TL2ID = $TL3WorkSrc->L2ID;
        $SingleData = [
            'UserName' => $RequestUser,
            'SkilID' => $indexar,
            'WorkCat' => $TWorkCat,
            'L1ID' => $TL1ID,
            'L2ID' => $TL2ID,
            'CreateDate' => now(),
            'Status' => 1,
            'Note' => "",
        ];
        WorkerSkils::create($SingleData);
        return true;
    }
    private function add_user(Request $request)
    {

        $Name = $request->Name;
        $Family = $request->Family;
        $MobileNo = $request->MobileNo;
        $cat = $request->cat;
        $user_class = new UserClass;
        $Sex = $request->Sex;
        $username = $user_class->add_user_form_calls($Name, $Family, $MobileNo, $Sex);
        $data = [
            'result' => true,
            'name' => $Name,
            'family' => $Family,
            'username' => $username,
            'sex' => 'آقای'
        ];
        $this->add_user_tag($cat, $username);
        return $data;

    }
    private function add_responsible(Request $request)
    {
        $cdr_id = $request->cdr_id;
        $ReportTxt = $request->ReportTxt ?? '';
        $Responsible = $request->Responsible;
        $cdr_data = [
            'related_user' => $Responsible,
        ];
        cdr::where('id', $cdr_id)->update($cdr_data);
        if ($ReportTxt != '') {
            $this->add_report_base($cdr_id, $ReportTxt);
        }
        $related_src = UserInfo::where('UserName',$Responsible)->first();
        return $related_src->Name .' '. $related_src->Family;

    }
    public function Dovoip_main(Request $request)
    {

        if ($request->ajax()) {
            if ($request->procedure == 'add_report') {
                return $this->add_report($request);
            }
            if ($request->procedure == 'get_report') {
                return $this->get_report($request);
            }
            if ($request->procedure == 'add_responsible') {
                return $this->add_responsible($request);
            }
            if ($request->procedure == 'set_alert') {
                return $this->set_alert($request);
            }
            if ($request->procedure == 'reset_alert') {
                return $this->reset_alert($request);
            }
            if ($request->procedure == 'add_user') {
                return $this->add_user($request);
            }
            return null;
        }
        if ($request->submit == 'filter') {
            return $this->filter_records($request);
        }
        if ($request->submit == 'sync') {
            $my_voip = new Voip_sync;
            $result = $my_voip->sync_with_voip_server();
            return redirect()->back()->with('success', $result);
        }
        if ($request->submit == 'sync_voice') {
            $my_voip = new Voip_sync;
            $result = $my_voip->sync_all_voice();
            return redirect()->back()->with('success', "تعداد $result رکورد به روز رسانی شد!");
        }

    }
}

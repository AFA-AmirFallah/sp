<?php

namespace App\hiring;

use App\Functions\Indexes;
use App\Functions\persian;
use App\Functions\TextClassMain;
use App\Models\comments;
use App\Models\L3Work;
use App\Models\UserInfo;
use App\myappenv;
use App\Users\UserClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class hiring_comments extends hiring_main
{
    public function number_of_my_open_comment()
    {
        $result = comments::where('creator', Auth::id())->where('status', '<', 100)->get()->count();
        return $result;
    }
    public function get_positive_index()
    {
        return L3Work::where('WorkCat', 100)->where('L1ID', 1)->where('L2ID', 1)->get();
    }
    public function get_negative_index()
    {
        return L3Work::where('WorkCat', 100)->where('L1ID', 1)->where('L2ID', 2)->get();
    }
    public function confirm_report($id, $weight)
    {

        $Persian = new persian;
        $comment = comments::find($id);
        $index_src = json_decode($comment->indexes);
        $index_class = new Indexes;
        foreach ($index_src as $index_item) {
            $index_class->assign_index_to_user_by_system($comment->related_person, $index_item);
        }
        $history = $comment->history . '<br>' . ' تائید توسط: ' . Auth::user()->Name . ' ' . Auth::user()->Family . ' با وزن: ' . $weight . 'در تاریخ: ' . $Persian->MyPersianNow();
        $update_data = [
            'status' => 100,
            'weight' => $weight,
            'confirm_date' => now(),
            'confirm_by' => Auth::id(),
            'history' => $history
        ];
        $comment->update($update_data);
        $comment->save();
        return true;

    }
    public function worker_comment_overview($username)
    {
        $comment_src = comments::where('related_person', $username)->where('status', 100)->get();
        $comment_count = 0;
        $comment_rate = 0;
        foreach ($comment_src as $comment_item) {
            $comment_count++;
            $comment_rate += $comment_item->rate;
        }
        if ($comment_count == 0) {
            return [
                'result' => true,
                'count' => $comment_count,
                'rate' => 'تعیین نشده'
            ];
        }
        $comment_rate = $comment_rate / $comment_count;
        return [
            'result' => true,
            'count' => $comment_count,
            'rate' => $comment_rate
        ];

    }
    public function add_report_to_comment($id, $report_data)
    {
        $deal_file_src = comments::find($id);
        $report_src = $deal_file_src->report;
        if ($report_src == null || $report_src == '') {
            $report_src = [];
        } else {
            $report_src = json_decode($report_src);
        }
        array_push($report_src, $report_data);
        $report_src = json_encode($report_src);
        $deal_file_src->report = $report_src;
        $deal_file_src->save();
        return true;
    }
    public function change_staff($comment_id, $target_username)
    {
        $comment_src = comments::find($comment_id);
        $user_src = UserInfo::find($target_username);
        if ($user_src->Phone1 == null) {
            $user_src->update(['Phone1' => $comment_src->MobileNo]);
            $user_src->save();
        } else {
            $user_src->update(['Phone2' => $comment_src->MobileNo]);
            $user_src->save();
        }
        $Persian = new persian;
        $history = $comment_src->history . '<br> تجمیع نیروی عملیاتی توسط:  ' . ' ' . Auth::user()->Name . ' ' . Auth::user()->Family . 'در تاریخ: ' . $Persian->MyPersianNow();
        $old_user_id = $comment_src->related_person;
        $comment_data = [
            'code' => $user_src->Ext,
            'related_person' => $user_src->UserName,
            'history' => $history,
        ];
        $comment_src->update($comment_data);
        $comment_src->save();
        UserInfo::where('UserName', $old_user_id)->delete();
        return true;
    }
    public function can_exchange_user($username)
    {
        $user_src = UserInfo::where('UserName', $username)->first();
        if ($user_src == null) {
            return [
                'result' => false,
                'msg' => 'نام کاربری وجود ندارد!'
            ];
        }
        if ($user_src->Phone1 != null && $user_src->Phone2 != null) {
            return [
                'result' => false,
                'msg' => 'شماره تلفن های کابر مورد نظر پر شده است!'
            ];
        }
        return [
            'result' => true
        ];
    }
    public function admin_update_comment($id, Request $request)
    {
        $Persian = new persian;
        $comment = comments::find($id);
        $history = $comment->history . '<br>' . 'ویرایش توسط: ' . Auth::user()->Name . ' ' . Auth::user()->Family . 'در تاریخ: ' . $Persian->MyPersianNow();
        $update_data = [
            'Name' => $request->Name,
            'service' => $request->service,
            'center_name' => $request->center_name,
            'comment' => $request->comment,
            'history' => $history
        ];
        $comment->update($update_data);
        $comment->save();
        return true;
    }
    public function get_comment_state_text($state)
    {
        switch ($state) {
            case 0:
                return 'در انتظار تائید ادمین';
            case 100:
                return 'تائید شده';


        }
    }
    public function get_worker_comments($username, $limit = null)
    {
        $Query = "SELECT c.*,ui.Name as cname , ui.Family as cfamily,c.created_at
        from comments c  inner join UserInfo ui on c.creator  = ui.UserName and c.status = 100 and c.related_person = '$username' order by c.id DESC ";
        if ($limit != null) {
            $Query .= " limit  $limit";
        }
        $result = DB::select($Query);
        return $result;

    }
    public function get_all_open_comments()
    {
        $Query = "SELECT c.id,c.service,c.Name,c.rate,ui.Name as cname , ui.Family as cfamily,c.created_at,c.status from comments c  inner join UserInfo ui on c.creator  = ui.UserName and c.status  < 100";
        $result = DB::select($Query);
        return $result;
    }

    public function find_input_code_type($mobile_no)
    {
        $check_mobile = $this->is_mobile_number($mobile_no);
        if ($check_mobile['result']) {
            return [
                'result' => true,
                'msg' => 'mobile'
            ];
        }
        $check_code = $this->find_user_by_code($mobile_no);
        if ($check_code['result']) {
            return [
                'result' => true,
                'msg' => 'code'
            ];
        }
        return [
            'result' => false,
            'msg' => 'not find'
        ];
    }
    private function check_and_apply_code($code, $Name, $creator)
    {
        $mobile_number = $this->is_mobile_number($code);
        if ($mobile_number['result']) { // The code is mobile number
            $user_data = $this->who_is_by_phone($code);
            if ($user_data['result']) { // The user already exist
                $user_data = $user_data['data'];
                return [
                    'result' => true,
                    'MobileNo' => $code,
                    'UserName' => $user_data['UserName'],
                    'code' => $user_data['Ext']
                ];
            } else { // The user is not exist
                $user_class = new UserClass;
                $result = $user_class->add_worker_from_comments($Name, $code, $creator);
                return [
                    'result' => true,
                    'MobileNo' => $code,
                    'UserName' => $result['UserName'],
                    'code' => $result['Ext']
                ];
            }
        }
        $result = $this->find_user_by_code($code);
        return [
            'result' => true,
            'MobileNo' => $result['MobileNo'],
            'UserName' => $result['UserName'],
            'code' => $result['Ext']
        ];

    }
    public function get_single_comment($comment_id, $username, $user_role)
    {
        $creator_name = 'کاربر سامانه';
        if ($user_role == myappenv::role_customer) {
            $comment_src = comments::where('id', $comment_id)->where('creator', $username)->first();
            if ($comment_src == null) {
                return [
                    'result' => false,
                    'msg' => 'گزارش درخواست شده در سامانه وجود ندارد!'
                ];
            }

        }
        if ($user_role == myappenv::role_worker) {
            $comment_src = comments::where('id', $comment_id)->where('related_person', $username)->first();
            if ($comment_src == null) {
                return abort('404');
            }
            if ($comment_src->show_info) {
                $creator_src = UserInfo::where('UserName', $comment_src->creator)->first();
                $creator_name = $creator_src->Name . ' ' . $creator_src->Family;
            }
            if ($comment_src == null) {
                return [
                    'result' => false,
                    'msg' => 'گزارش درخواست شده در سامانه وجود ندارد!'
                ];
            }
        }
        if ($user_role >= myappenv::role_admin) {
            $comment_src = comments::where('id', $comment_id)->first();
            if ($comment_src == null) {
                return [
                    'result' => false,
                    'msg' => 'گزارش درخواست شده در سامانه وجود ندارد!'
                ];
            }
        }
        return [
            'result' => true,
            'service' => $comment_src->service,
            'Name' => $comment_src->Name,
            'code' => $comment_src->code,
            'MobileNo' => $comment_src->MobileNo,
            'related_person' => $comment_src->related_person,
            'creator' => $comment_src->creator,
            'center_name' => $comment_src->center_name,
            'comment' => $comment_src->comment,
            'indexes' => $comment_src->indexes,
            'recommend' => $comment_src->recommend,
            'call_allow' => $comment_src->call_allow,
            'show_info' => $comment_src->show_info,
            'creator_name' => $creator_name,
            'rate' => $comment_src->rate,
            'history' => $comment_src->history,
            'report' => $comment_src->report,
            'confirm_date' => $comment_src->confirm_date,
            'created_at' => $comment_src->created_at,
        ];
    }
    public function add_new_comment(Request $request,$creator)
    {
        $persian = new persian;
        $my_text = new TextClassMain;
        $service = $my_text->StripText($request->service);
        $creator_src = UserInfo::where('UserName',$creator)->first();
        $Name = $my_text->StripText($request->Name);
        $code_result = $this->check_and_apply_code($request->code, $Name, $creator);
        $code = $code_result['code'];
        $MobileNo = $code_result['MobileNo'];
        $related_person = $code_result['UserName'];
        $center_name = $my_text->StripText($request->center_name);
        $comment = $my_text->StripText($request->comment);
        $indexes = json_encode($request->indexes);
        $recommend = boolval($request->recommend);
        $call_allow = boolval($request->call_allow);
        $show_info = boolval($request->show_info);
        $rate = $request->rate;
        $history_text = 'ثبت توسط کاربر با نام: ' . $creator_src->Name . ' ' . $creator_src->Family . ' و نام کاربری: ' . Auth::id() . 'در تاریخ: ' . $persian->MyPersianNow();
        $history = $history_text;
        $comment_data = [
            'service' => $service,
            'Name' => $Name,
            'code' => $code,
            'MobileNo' => $MobileNo,
            'related_person' => $related_person,
            'creator' => $creator,
            'center_name' => $center_name,
            'comment' => $comment,
            'indexes' => $indexes,
            'recommend' => $recommend,
            'call_allow' => $call_allow,
            'show_info' => !$show_info,
            'rate' => $rate,
            'history' => $history,
        ];
        $result = comments::create($comment_data);
        return [
            'result' => true,
            'id' => $result->id
        ];


    }

}
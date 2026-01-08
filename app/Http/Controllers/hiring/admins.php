<?php

namespace App\Http\Controllers\hiring;

use App\hiring\hiring_comments;
use App\hiring\hiring_main;
use App\Http\Controllers\Controller;
use App\Models\L3Work;
use App\Models\UserInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class admins extends Controller
{
    public function hiring_confirmable(){
        $user_src = UserInfo::where('Status',1)->get();
        return view('hiring.admin_hiring_confirmable',['user_src'=>$user_src]);
    }   
    public function hiring_skill_mgt()
    {
        $resume = new hiring_main;
        $skill_src = $resume->skill_mgt(false);
        return view('hiring.admin_skill_mgt', ['skill_src' => $skill_src]);

    }
    public function Dohiring_skill_mgt(Request $request)
    {
        $resume = new hiring_main;
        $resume->active_skill($request->activate);
        return redirect()->back()->with('success','فعال سازی شاخص انجام شد!');

    }
    public function admin_experience_actions($id)
    {
        $comment = new hiring_comments;
        $comment_src = $comment->get_single_comment($id, Auth::id(), Auth::user()->Role);


        return view('hiring.admin_experience_actions', ['id' => $id, 'comment_src' => $comment_src]);
    }
    public function Doadmin_experience_actions(Request $request, $id)
    {
        if ($request->submit == 'confirm') {
            $comment = new hiring_comments;
            $weight = $request->weight;
            $comment_src = $comment->confirm_report($id, $weight);
            return redirect()->back()->with('success', 'عملیات موفقیت آمیز');
        }
    }
    public function admin_experience_reporting($id)
    {
        $comment = new hiring_comments;
        $comment_src = $comment->get_single_comment($id, Auth::id(), Auth::user()->Role);
        $report_src = $comment_src['report'];
        if ($report_src == null || $report_src == '') {
            $report_src = [];
        } else {
            $report_src = json_decode($report_src);
        }

        return view('hiring.admin_experience_reporting', ['id' => $id, 'comment_src' => $comment_src, 'report_src' => $report_src]);
    }
    public function Doadmin_experience_reporting(Request $request, $id)
    {
        if ($request->has('add_report')) {
            $report_type = $request->add_report;
            $reporter_username = Auth::id();
            $reporter_Name = Auth::user()->Name;
            $reporter_family = Auth::user()->Family;
            $report_time = time();
            $report_text = $request->report;
            $report_data = [
                'report_type' => $report_type,
                'reporter_username' => $reporter_username,
                'reporter_Name' => $reporter_Name,
                'reporter_family' => $reporter_family,
                'report_time' => $report_time,
                'report_text' => $report_text
            ];
            $workflow = new hiring_comments;
            $workflow->add_report_to_comment($id, $report_data);
            return redirect()->back()->with('success', 'گزارش ثبت شد!');

        }
    }
    public function get_related_index($index_arr)
    {
        $l3_src = L3Work::whereIn('UID', $index_arr)->get();
        return $l3_src;

    }
    public function hiring_dashboard()
    {
        return view('hiring.dashboard');
    }
    public function Dohiring_dashboard()
    {

    }
    public function admin_experience_list()
    {
        $comments = new hiring_comments;
        $comments_src = $comments->get_all_open_comments();
        return view('hiring.admin_experience_list', ['comments' => $comments, 'comments_src' => $comments_src]);
    }
    public function Doadmin_experience_list()
    {

    }
    public function admin_single_experience($id)
    {
        $comment = new hiring_comments;
        $comment_src = $comment->get_single_comment($id, Auth::id(), Auth::user()->Role);

        return view('hiring.admin_single_experience', ['id' => $id, 'comment_src' => $comment_src]);

    }

    public function Doadmin_single_experience(Request $request, $id)
    {
        if ($request->has('submit')) {
            $comment = new hiring_comments;
            $comment_src = $comment->admin_update_comment($id, $request);
            return redirect()->back()->with('success', 'ویرایش موفق!');
        }

    }
    public function admin_single_experience_person($id)
    {
        $comment = new hiring_comments;
        $comment_src = $comment->get_single_comment($id, Auth::id(), Auth::user()->Role);
        $index_src = $this->get_related_index(json_decode($comment_src['indexes']));

        return view('hiring.admin_single_experience_person', ['id' => $id, 'comment_src' => $comment_src, 'index_src' => $index_src]);
    }

    public function Doadmin_single_experience_person($id, Request $request)
    {
        if ($request->has('submit')) {
            if ($request->submit == 'exchange') {
                $comment = new hiring_comments;
                $comment->change_staff($id, $request->target_username);
                return redirect()->back()->with('success', 'عملیات موفقیت آمیز!');
            }
        }
        if ($request->ajax()) {
            if ($request->function == 'check_exchange') {
                $comment = new hiring_comments;
                $result = $comment->can_exchange_user($request->UserName);
                return $result;
            }
        }

    }
}

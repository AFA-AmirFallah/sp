<?php

namespace App\Http\Controllers\auto;

use App\Auto\Auto_user_class;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Console\Input\Input;

class GroupWorks extends Controller
{
    public function group_work($group_id)
    {
        $user_class = new Auto_user_class(Auth::id());
        $role = $user_class->get_group_role($group_id);
        $user_class->set_group_id($group_id);
        if ($role == null) {
            return abort(404, 'شما دسترسی به گروه مورد نظر ندارید');
        }
        $group_src = $user_class->get_group_info($group_id);
        if ($group_src == null) {
            return abort(404, 'گروه مورد نظر وجود ندارد!');
        }

        return view("Auto.GroupWorks", ['group_src' => $group_src, 'user_class' => $user_class]);


    }
    private function do_edit_task(Request $request)
    {

        return 'salam';

    }
    public function Dogroup_work($group_id, Request $request)
    {
        if ($request->ajax()) {
            switch ($request->AjaxType) {
                case 'edit_task':
                    return $this->edit_task($group_id, $request->id);
                case 'add_report':
                    return $this->add_report($group_id, $request);
                case 'do_edit_task':
                    return $this->do_edit_task($request);

            }
            return 'ajax';
        }
        if ($request->submit == 'add_task') {
            $user_class = new Auto_user_class(Auth::id());
            $user_class->add_task($request, $group_id);
            return redirect()->back()->with('success', 'فعالیت به سیستم اضافه شد');
        }

    }
    public function add_report($group_id, Request $request)
    {
        $task_id = $request->TaskId;
        $report_text = $request->ReportTxt;
        $user_class = new Auto_user_class(Auth::id());
        $user_class->add_report($task_id, $report_text);
        return true;
    }
    public function edit_task($group_id, $task_id)
    {

        $user_class = new Auto_user_class(Auth::id());
        $role = $user_class->get_group_role($group_id);
        $user_class->set_group_id($group_id);
        if ($role == null) {
            return abort(404, 'شما دسترسی به گروه مورد نظر ندارید');
        }
        $group_src = $user_class->get_group_info($group_id);
        if ($group_src == null) {
            return abort(404, 'گروه مورد نظر وجود ندارد!');
        }
        $task_src_main = $user_class->get_task_src($task_id);
        $task_src = $task_src_main['task_src'][0];
        $owner = false;
        if($task_src->creator == Auth::id()){
            $owner = true;
        }
        $responsible_src = $task_src_main['responsible_src'];
        $tag_src = $task_src_main['tag_src'];
        $items_src = $task_src_main['items_src'];
        $report_src = $task_src_main['report_src'];
        return view("Auto.SubView.tasks_edit_sub", ['owner'=>$owner, 'report_src' => $report_src, 'items_src' => $items_src, 'tag_src' => $tag_src, 'responsible_src' => $responsible_src, 'task_src' => $task_src, 'group_src' => $group_src, 'user_class' => $user_class])->render() ;

    }
    public function tasks($group_id, $task_id = null)
    {
        $user_class = new Auto_user_class(Auth::id());
        $role = $user_class->get_group_role($group_id);
        if ($role == null) {
            return abort(404, 'شما دسترسی به گروه مورد نظر ندارید');
        }
        $group_src = $user_class->get_group_info($group_id);
        if ($group_src == null) {
            return abort(404, 'گروه مورد نظر وجود ندارد!');
        }
        return view("Auto.tasks", ['group_src' => $group_src, 'user_class' => $user_class]);

    }
    public function Dotasks(Request $request, $group_id, $task_id = null)
    {
        $user_class = new Auto_user_class(Auth::id());
        $role = $user_class->get_group_role($group_id);
        if ($role == null) {
            return abort(404, 'شما دسترسی به گروه مورد نظر ندارید');
        }
        if ($request->submit == 'add_task') {
            $user_class = new Auto_user_class(Auth::id());
            $user_class->add_task($request, $group_id);
            dd($request->input());

        }
    }

}

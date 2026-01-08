<?php

namespace App\Auto;

use App\Functions\persian;
use App\Models\auto_group;
use App\Models\auto_group_members;
use App\Models\auto_tasks;
use App\Models\auto_tasks_items;
use App\Models\auto_tasks_report;
use App\Models\auto_tasksـresponsible;
use App\Models\auto_tasksـtags;
use App\myappenv;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Auto_user_class extends Auto_main_class
{
    private $username;
    private $group_id;
    function __construct($username)
    {
        $this->username = $username;
    }
    public function set_group_id($group_id)
    {
        $this->group_id = $group_id;
    }
    public function add_task_report($task_id, $report_text)
    {
        $report_data = [
            'task_id' => $task_id,
            'description' => $report_text,
            'creator' => $this->username
        ];
        auto_tasks_report::create($report_data);
        return true;

    }

    public function get_task_src($task_id)
    {
        $group_id = $this->group_id;
        $username = $this->username;
        $query = "SELECT
	t.id,
	t.title ,
	t.description ,
    t.progress,
	t.deadline,
	t.status,
    t.creator,
	GROUP_CONCAT(atm.name) as tags
from
	auto_tasks t
left join auto_tasksـresponsibles re on
	t.id = re.task_id and t.auto_group_id = $group_id and t.id = $task_id
left join auto_tasksـtags tag on
	tag.task_id = t.id
left join auto_tasksـtags_metas atm on
	tag.tag_id = atm.id
where
    t.id = $task_id and (
	t.creator = '$username'
	or re.username = '$username')
group by t.id,
	t.title ,
    t.progress,
	t.deadline,
	t.status
order by t.id DESC
";
        $task_src = DB::select($query);
        $query = "SELECT tr.* , ui.Name, ui.Family , ui.avatar from auto_tasksـresponsibles tr inner join UserInfo  ui on tr.username = ui.UserName where tr.task_id = $task_id ";
        $responsible_src = DB::select($query);
        $query = "SELECT tg.* , tm.name from auto_tasksـtags tg inner join auto_tasksـtags_metas tm on tg.tag_id = tm.id where tg.task_id = $task_id ";
        $tags_src = DB::select($query);
        $items_src = auto_tasks_items::where('task_id', $task_id)->get();
        $query = "select atr.*,ui.Name , ui.Family from auto_tasks_reports atr inner join UserInfo ui on atr.creator = ui.UserName where atr.task_id = $task_id";
        $report_src = DB::select($query);
        return [
            'task_src' => $task_src,
            'responsible_src' => $responsible_src,
            'tag_src' => $tags_src,
            'items_src' => $items_src,
            'report_src' => $report_src
        ];
    }

    public function get_groups_brif()
    {
        $username = $this->username;
        $query = "select ag.*,agm.auto_role_id , (select count(*)  from auto_group_members agm2  where agm2.auto_group_id = ag.id ) as user_count  from auto_group ag inner join auto_group_members agm on ag.id  = agm.auto_group_id and ag.status = 100 and agm.UserName = '$username' ";
        return DB::select($query);
    }
    public function get_group_role($group_id)
    {
        if (Auth::user()->Role == myappenv::role_SuperAdmin) {
            return 100;
        }
        $member = auto_group_members::where('auto_group_id', $group_id)->where('UserName', $this->username)->first();
        if ($member == null) {
            return null;
        }
        return $member->auto_role_id;
    }
    public function get_my_tasks()
    {
        $group_id = $this->group_id;
        $username = $this->username;
        $query = "SELECT
	t.id,
	t.title ,
    t.progress,
	t.deadline,
	t.status,
	GROUP_CONCAT(atm.name) as tags
from
	auto_tasks t
left join auto_tasksـresponsibles re on
	t.id = re.task_id and t.auto_group_id = $group_id
left join auto_tasksـtags tag on
	tag.task_id = t.id
left join auto_tasksـtags_metas atm on
	tag.tag_id = atm.id
where
	t.creator = '$username'
	or re.username = '$username'
group by t.id,
	t.title ,
    t.progress,
	t.deadline,
	t.status
order by t.id DESC
";
        return DB::select($query);
    }
    public function get_group_info($group_id)
    {
        return auto_group::where('id', $group_id)->first();
    }
    private function add_tags_to_task($task_id, $tag_arr)
    {
        foreach ($tag_arr as $tag) {
            $tag_data = [
                'task_id' => $task_id,
                'tag_id' => $tag
            ];
            auto_tasksـtags::create($tag_data);
        }
        return true;
    }
    public function add_task_responsible($task_id, $responsible_arr)
    {
        foreach ($responsible_arr as $responsible) {
            $responsible_data = [
                'task_id' => $task_id,
                'username' => $responsible
            ];
            auto_tasksـresponsible::create($responsible_data);

        }
        return true;
    }
    public function add_task_items($task_id, $items_arr)
    {
        $order = 0;
        foreach ($items_arr as $item) {
            $order++;
            $item_data = [
                'order' => $order,
                'task_id' => $task_id,
                'item' => $item,
                'progress' => 0,
            ];
            auto_tasks_items::create($item_data);
        }
        return true;

    }
    public function edit_task(Request $request, $group_id)
    {

    }
    public function add_report($task_id, $report_text)
    {
        $report_data = [
            'task_id' => $task_id,
            'description' => $report_text,
            'creator' => $this->username
        ];
        auto_tasks_report::create($report_data);
        return true;
    }
    public function add_task(Request $request, $group_id)
    {
        $MyPersian = new persian;
        $description = nl2br(htmlspecialchars($request->description));
        $deadline = null;
        if ($request->has('StartDate') && $request->StartDate != null) {
            $deadline = $MyPersian->MyMiladiDateTime($request->StartDate, $request->StartTime ?? '00:00');
        }

        $task_data = [
            'auto_group_id' => $group_id,
            'title' => $request->ADDName,
            'progress' => 0,
            'deadline' => $deadline,
            'description' => $description,
            'status' => 1,
            'creator' => $this->username,
        ];
        $task_src = auto_tasks::create($task_data);
        $task_id = $task_src->id;
        $this->add_tags_to_task($task_id, $request->SelectTags);
        $this->add_task_responsible($task_id, $request->responsible);
        $this->add_task_items($task_id, $request->items);
        return redirect(route('group_work', ['group_id' => $group_id]))->with('success', 'عملیات موفق افزودن');

    }



}

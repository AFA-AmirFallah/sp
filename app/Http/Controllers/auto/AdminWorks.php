<?php

namespace App\Http\Controllers\auto;

use App\Auto\Auto_admin_class;
use App\Auto\Auto_main_class;
use App\Http\Controllers\Controller;
use Hamcrest\Type\IsNumeric;
use Illuminate\Http\Request;

use function PHPUnit\Framework\isNumeric;

class AdminWorks extends Controller
{
    public function auto_admin(Request $request)
    {
        $page = $request->page;
        $admin_class = new Auto_admin_class();
        return view("Auto.AutoAdmin", ['page' => $page, 'admin_class' => $admin_class]);
    }
    public function Doauto_admin(Request $request)
    {

        if ($request->has('deactive_tag')) {
            $auto_class = new Auto_admin_class();
            $tag_id = $request->deactive_tag;
            $auto_class->change_tag_status($tag_id, 0);
            return redirect()->back()->with('success', 'عملیات انجام شد!');

        }
        if ($request->has('active_tag')) {
            $auto_class = new Auto_admin_class();
            $tag_id = $request->active_tag;
            $auto_class->change_tag_status($tag_id, 1);
            return redirect()->back()->with('success', 'عملیات انجام شد!');
        }

        if ($request->submit == 'makegroup') {
            $auto_class = new Auto_admin_class();
            $insert_result = $auto_class->add_group($request);
            if ($insert_result['result']) {
                return redirect()->back()->with('success', 'گروه مورد نظر به سامانه اضافه شد');
            }
            return redirect()->back()->with('error', $insert_result['msg']);
        }
        if ($request->submit == 'maketag') {
            $auto_class = new Auto_admin_class();
            $insert_result = $auto_class->add_tag($request);
            if ($insert_result['result']) {
                return redirect()->back()->with('success', 'برچسب مورد نظر به سامانه اضافه شد');
            }
            return redirect()->back()->with('error', $insert_result['msg']);
        }

    }
    public function group_admin($group_id)
    {
        $admin_class = new Auto_admin_class();
        if (!is_numeric($group_id)) {
            return abort(404, 'group id is not correct');
        }
        $group_src = $admin_class->get_specific_group($group_id);
        $group_member_src = $admin_class->get_group_members($group_id);
        if ($group_src == null) {
            return abort(404, 'group id is not correct');
        }
        return view("Auto.EditGroupAdmin", ['group_src' => $group_src[0], 'group_member_src' => $group_member_src, 'admin_class' => $admin_class]);


    }
    public function Dogroup_admin(Request $request, $group_id)
    {
        if ($request->has('add_perosn')) {
            $admin_class = new Auto_admin_class();
            $insert_result = $admin_class->add_group_member($group_id, $request->input('add_perosn'), $request->input('UserName'));
            if (!$insert_result['result']) {
                return redirect()->back()->with('error', $insert_result['msg']);
            }
            return redirect()->back()->with('success', 'عملیات موفق');
        }
        if ($request->has('change_status')) {
            $admin_class = new Auto_admin_class();
            $admin_class->change_group_status($group_id, $request->input('change_status'));
            return redirect()->back()->with('success', 'عملیات موفق');
        }
    }
}

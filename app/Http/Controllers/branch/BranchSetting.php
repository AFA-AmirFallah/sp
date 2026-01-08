<?php

namespace App\Http\Controllers\branch;

use App\branchenv;
use App\Http\Controllers\Controller;
use App\Models\branches;
use App\myappenv;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;


class BranchSetting extends Controller
{
    public function Shafatel_branch_setting()
    {
        $branch_src = branches::where('id', Auth::user()->branch)->first();
        $branch_app_env = $branch_src->myappenv;
        if ($branch_app_env == null) {
            $branch_app_env = [];
        } else {
            $branch_app_env = json_decode($branch_app_env, true);
        }
        return view('Setting.BranchSetting', ['branch_app_env' => $branch_app_env]);
    }
    public function BranchSetting()
    {
        if (myappenv::MainOwner == 'shafatel') {
            return $this->Shafatel_branch_setting();
        }
        $current_branch = branchenv::get_branch();
        $branch_src = branches::where('id', $current_branch['CenterID'])->first();
        $branch_app_env = $branch_src->myappenv;
        if ($branch_app_env == null) {
            $branch_app_env = [];
        } else {
            $branch_app_env = json_decode($branch_app_env, true);
        }
        return view('Setting.BranchSetting_webs', ['branch_app_env' => $branch_app_env, 'branch_src' => $branch_src]);


    }
    private function modify_branch_main_info(Request $request)
    {
        $current_branch = branchenv::get_branch();
        $update_data = [
            "Name" => $request->Name,
            "UserName" => $request->UserName,
            "Description" => $request->Description,
            "Phone" => $request->Phone,
            "Phone1" => $request->Phone1,
            "avatar" => $request->avatar
        ];
        branches::where('id', $current_branch['CenterID'])->update($update_data);
        return true;
    }
    private function add_branch_main_info(Request $request)
    {
        $update_data = [
            "Name" => $request->Name,
            "UserName" => $request->UserName,
            "Description" => $request->Description,
            "Phone" => $request->Phone,
            "Phone1" => $request->Phone1,
            "avatar" => $request->avatar
        ];
        branches::create($update_data);
        return true;
    }
    private function modify_branch_main_setting(Request $request)
    {
        $item_name_src = $request->item_name;
        $value_src = $request->value;
        foreach ($item_name_src as $item_index => $iem_name) {
            $settings[$iem_name] = $value_src[$item_index];
        }
        $myappenv = json_encode($settings);
        $current_branch = branchenv::get_branch();
        branches::where('id', $current_branch['CenterID'])->update(['myappenv' => $myappenv]);
        return true;
    }
    public function DoBranchSetting(Request $request)
    {
        if ($request->has('submit')) {
            if ($request->submit == 'add_main_info') {
                $modify_result = $this->add_branch_main_info($request);
                if ($modify_result) {
                    return redirect()->back()->with('success', 'عملیات انجام شد');
                }
                return redirect()->back()->with('error', 'عملیات انجام نشد');
            }
            if ($request->submit == 'save_main_info') {
                $modify_result = $this->modify_branch_main_info($request);
                if ($modify_result) {
                    return redirect()->back()->with('success', 'عملیات انجام شد');
                }
                return redirect()->back()->with('error', 'عملیات انجام نشد');
            }
            if ($request->submit == 'save_main_setting') {
                $modify_result = $this->modify_branch_main_setting($request);
                if ($modify_result) {
                    return redirect()->back()->with('success', 'عملیات انجام شد');
                }
                return redirect()->back()->with('error', 'عملیات انجام نشد');
            }
            if ($request->submit == 'flush') {
                $branch = Auth::user()->branch;
                if (Cache::has("branch_env_$branch")) {
                    Cache::forget("branch_env_$branch");
                }
                return redirect()->back()->with('success', 'عملیات موفقیت آمیز');

            }
            $field_name = $request->submit;
            $field_value = $request->input($field_name);
            $branch_src = branches::where('id', Auth::user()->branch)->first();
            $branch_app_env = $branch_src->myappenv;
            if ($branch_app_env == null) {
                $branch_app_env = [];
            } else {
                $branch_app_env = json_decode($branch_app_env, true);
            }
            $branch_app_env[$field_name] = $field_value;
            $branch_app_env = json_encode($branch_app_env);
            $branch = Auth::user()->branch;
            branches::where('id', $branch)->update(['myappenv' => $branch_app_env]);
            if (Cache::has("branch_env_$branch")) {
                Cache::forget("branch_env_$branch");
            }
            return redirect()->back()->with('success', 'عملیات موفقیت آمیز');
        }
    }
}

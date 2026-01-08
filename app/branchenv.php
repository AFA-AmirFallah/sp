<?php

namespace App;

use App\Models\branches;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\myappenv;

class branchenv
{
    public static function get_branch()
    {
        if (!Cache::has('CenterID')) {
            return [
                'result' => false,
                'CenterName' => branchenv::getenv('DefultPageTitr') ?? myappenv::CenterName,
                'CenterID' => myappenv::Branch
            ];
        }
        return [
            'result' => false,
            'CenterName' => Cache::get("CenterName"),
            'CenterID' => Cache::get("CenterID")
        ];


    }
    public static function set_branch($branch_id)
    {
        $target_branch_src = branches::where('id', $branch_id)->first();
        if ($target_branch_src == null) {
            return false;
        }
        Cache::put("CenterName", $target_branch_src->Name);
        Cache::put("CenterID", $target_branch_src->id);
        return true;

    }
    public static function is_multi_branch()
    {
        return myappenv::Lic['MultiBranch'];
    }
    public static function get_all_branches()
    {
        return branches::all();
    }
    private static function make_cache()
    {
    }

    public static function getenv($env_name)
    {
        if (!Auth::check()) {
            return null;
        }
        $branch = Auth::user()->branch;
        if (!Cache::has("branch_env_$branch")) {
            $branch_src = branches::where('id', Auth::user()->branch)->first();
            $branch_app_env = $branch_src->myappenv;
            if ($branch_app_env == null) {
                $branch_app_env = [];
                $branch_app_env['avatar'] = $branch_src->avatar;
                $branch_app_env['UserName'] = $branch_src->UserName;
                $branch_app_env['Name'] = $branch_src->Name;
                $branch_app_env['Description'] = $branch_src->Description;
                Cache::put("branch_env_$branch", $branch_app_env);
            } else {
                $branch_app_env = json_decode($branch_app_env, true);
                $branch_app_env['avatar'] = $branch_src->avatar;
                $branch_app_env['UserName'] = $branch_src->UserName;
                $branch_app_env['Name'] = $branch_src->Name;
                $branch_app_env['Description'] = $branch_src->Description;
                Cache::put("branch_env_$branch", $branch_app_env);
            }
        }
        $branch_env = Cache::get("branch_env_$branch");
        return $branch_env[$env_name] ?? null;
    }
    public static function get_base_info($object)
    {
        $branch_src = branches::where('id', Auth::user()->branch)->first();
        return $branch_src[$object];
    }
    public static function get_active_branches()
    {
        $active_branches = branches::whereNotNull('license')->get();
        return $active_branches;
    }
}

<?php

namespace App\Branchs;

use App\Models\branches;
use App\Models\UserInfo;
use App\myappenv;
use cache;

class BranchsFunctions
{
    public static function get_all_branches(){
        $all_branches = branches::all();
        return $all_branches;
    }

    public static function get_user_name_branch_info($UserName)
    {
        if ($UserName == null) {
            return [
                'branch_name' => myappenv::CenterName,
                'branch_avatar' => myappenv::MainIcon
            ];
        }
        $TargetUser = UserInfo::where('UserName', $UserName)->first();
        if ($TargetUser == null) { // User not exist before
            return [
                'branch_name' => myappenv::CenterName,
                'branch_avatar' => myappenv::MainIcon
            ];
        } else {
            $BranchId = $TargetUser->branch;
            $BranchSrc = branches::where('id', $BranchId)->first();
            return [
                'branch_name' => $BranchSrc->Description,
                'branch_avatar' => $BranchSrc->avatar
            ];
        }
    }

    public static function get_branch_id_with_name($branch_name)
    {
        $Target_branch = branches::where('login_name', $branch_name)->first();
        if ($Target_branch == null) {
            return [
                'result' => false,
                'msg' => 'The branch is not available'
            ];
        }

        return [
            'result' => true,
            'data' => $Target_branch
        ];
    }
    public static function get_user_branch()
    {
        if (cache::has('user_branch')) {
            return [
                'result' => true,
                'data' => cache::get('user_branch')
            ];
        } else {
            return [
                'result' => false,
                'msg' => 'The branch not assigned'
            ];
        }
    }
    public static function get_branch_info()
    {
        if (cache::has('user_branch_info')) {
            return [
                'result' => true,
                'data' => cache::get('user_branch_info')
            ];
        } else {
            return [
                'result' => false,
                'msg' => 'The branch not assigned'
            ];
        }
    }
    public static function set_user_branch($branch_id)
    { // this function use to assign branch session to user
        $Target_branch = branches::where('id', $branch_id)->first();
        if ($Target_branch == null) {
            return [
                'result' => false,
                'msg' => 'Target branch is not found'
            ];
        }
        cache::put('user_branch', $branch_id);
        cache::put('user_branch_info', $Target_branch);
        return [
            'result' => true,
            'data' => $Target_branch
        ];
    }
    public static function forget_user_branch()
    {
        cache::forget('user_branch');
        cache::forget('user_branch_info');
        return [
            'result' => true,
        ];
    }
}

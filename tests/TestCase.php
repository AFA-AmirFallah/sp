<?php

namespace Tests;

use App\Models\UserInfo;
use App\myappenv;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

abstract class TestCase extends BaseTestCase
{
    public function login_with_role($target_role){
        Auth::logout();
        $UserName = "user_$target_role";
        $userinfo_key = [
            'UserName' => $UserName,
        ];
        $UserData = [
            'UserPass' => $UserName,
            'password' => Hash::make($UserName),
            'Name' => $UserName,
            'Family' => $UserName,
            'MobileNo' => $UserName,
            'Phone1' => $UserName,
            'Email' => $UserName,
            'CreateDate' => now(),
            'Role' => $target_role,
            'Status' => 101,
            'branch' => myappenv::Branch
        ];
        UserInfo::updateOrCreate($userinfo_key,$UserData);
        Auth::attempt(['UserName' => $UserName, 'password' => $UserName]);
    }
    public function logout(){
        Auth::logout();
    }
}

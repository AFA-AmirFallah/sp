<?php

namespace App\hiring;

use App\Functions\TextClassMain;
use App\Models\L3Work;
use App\Models\UserInfo;
use App\Models\WorkerSkils;
use App\myappenv;
use App\Users\UserClass;
use Illuminate\Support\Facades\Session;

class hiring_workers extends hiring_main
{

    private $worker_username = null;

    public function get_worker_exact_skills($username){
        $skills = new hiring_skills;
        return $skills->get_worker_exact_skills($username);
    }

    public function get_worker_skills($username)
    {
        $skills = new hiring_skills;
        return $skills->get_worker_skills($username);
    }
    public function update_worker_skills(string $username, array $skill_arr)
    {
        $skills = new hiring_skills;
        $skills->update_worker_skills($username, $skill_arr);
        return true;
    }
    public function get_user_active_license()
    {
        $license_class = new hiring_package_manager;
        return $license_class->get_user_active_license($this->worker_username);
    }
    public function worker_setter($worker_username)
    {
        $this->worker_username = $worker_username;
    }
    public function get_worker_notifications($type)
    {
        $notifications = new hiring_workers_notifications;
        if ($type == 'dashboard') {
            return $notifications->get_worker_dashboard_notifications($this->worker_username);
        }
    }
    public function is_worker_exist_before($mobile_no)
    {
        $user_src = UserInfo::where('MobileNo', $mobile_no)->where('Role', myappenv::role_worker)->first();
        if ($user_src == null) {
            return [
                'result' => false
            ];
        }
        if ($user_src->Status == 0) { //user created by comment
            return [
                'result' => true,
                'username' => $user_src->UserName,
                'type' => 1
            ];
        }
        return [
            'result' => true,
            'username' => $user_src->UserName,
            'type' => 2
        ];

    }
    private function create_fresh_worker()
    {
        $userclass = new UserClass;
        $userclass->send_sms_after_job('', false);
        $new_user_username = $userclass->add_worker_hiring_with_session();
        return [
            'result' => true,
            'username' => $new_user_username
        ];

    }
    private function update_worker_base_info($username)
    {
        $update_data = [
            'Name' => Session::get('Name'),
            'Family' => Session::get('Family'),
            'Sex' => Session::get('sex'),
            'NationalCode' => Session::get('melli_id'),
            'MelliID' => Session::get('melli_id'),
            'province' => Session::get('Province'),
            'city' => Session::get('Saharestan'),
            'Status' => 1,
        ];
        UserInfo::where('UserName', $username)->update($update_data);
        return [
            'result' => true,
            'username' => $username
        ];
    }
    public function forget_sessions()
    {
        Session::forget('Name');
        Session::forget('Family');
        Session::forget('sex');
        Session::forget('expertin');
        Session::forget('MobileNo');
        Session::forget('melli_id');
        Session::forget('Province');
        Session::forget('Saharestan');
        Session::forget('email');
        Session::forget('education');

    }
    public function get_worker_comments($limit = null)
    {
        $comment_class = new hiring_comments;
        return $comment_class->get_worker_comments($this->worker_username,$limit);
    }
    public function create_worker_form_api($worker_info)
    {
        $mytext = new TextClassMain;
        $mobile = $mytext->persian_number_to_en($worker_info['MobileNo']);
        $name = $worker_info['Name'] ?? '';
        $family = $worker_info['Family'] ?? '';
        $melli_id = $worker_info['MelliID'] ?? '';
        $userclass = new UserClass;
        $userclass->send_sms_after_job('', false);
        $new_user_username = $userclass->AddUserwithmelliid('', $mobile,$name , $family ,$melli_id ,$mobile , $mobile, myappenv::role_worker, 1);
        return [
            'result' => true,
            'username' => $new_user_username
        ];



    }

    public function create_worker_form_session()
    {
        $is_existing_before = $this->is_worker_exist_before(Session::get('MobileNo'));
        if (!$is_existing_before['result']) {
            return $this->create_fresh_worker();
        }
        if ($is_existing_before['result'] && $is_existing_before['type'] == 1) {
            $username = $is_existing_before['username'];
            return $this->update_worker_base_info($username);
        }
        return [
            'result' => false,

        ];

    }
}
<?php

namespace App\hiring;

use App\Models\metadata;
use App\Users\UserClass;

class hiring_worker_insertion extends hiring_main
{
    private $max_insertion = 3;
    private function is_customer_valid_to_add_worker($username)
    {
        $insertion_count = metadata::where('fgstr', $username)->where('tt', 'worker_insertion')->count();
        if ($insertion_count > $this->max_insertion) {
            return [
                'result' => false,
                'msg' => '.با تشکر از شما دفعات مجاز معرفی شما به اتمام رسیده است'
            ];
        }
        return [
            'result' => true,
        ];
    }
    private function add_log_to_customer($customer_username, $worker_name, $worker_phone)
    {
        $MetaValue = [
            'customer_username' => $customer_username,
            'worker_name' => $worker_name,
            'worker_phone' => $worker_phone
        ];
        $data = [
            'tt' => 'worker_insertion',
            'fgstr' => $customer_username,
            'meta_key' => $worker_phone,  //user mobile number
            'meta_value' => json_encode($MetaValue)  //meta required data
        ];
        metadata::create($data);
        return true;
    }
    private function add_worker($customer_username, $worker_name, $worker_phone)
    {
        $user_class = new UserClass;
        $result = $user_class->add_worker_from_comments($worker_name, $worker_phone, $customer_username);
        return $result;
    }
    private function add_worker_notification($username)
    {
        //TODO: handle notifications

    }


    public function insertion_worker_by_customer($customer_username, $worker_name, $worker_phone)
    {
        $insert_validation = $this->is_customer_valid_to_add_worker($customer_username);
        if (!$insert_validation['result']) {
            return $insert_validation;
        }
        $this->add_log_to_customer($customer_username, $worker_name, $worker_phone);
        $worker_src = $this->add_worker($customer_username, $worker_name, $worker_phone);
        $this->add_worker_notification($worker_src['UserName']);
        return [
            'result' => true,
        ];

    }



}


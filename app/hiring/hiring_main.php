<?php

namespace App\hiring;

use App\Models\L3Work;
use App\Models\UserInfo;
use Illuminate\Support\Facades\DB;
class hiring_main
{
    public $skill_index = [
        'workcat' => 100,
        'l1' => 100,
        'l2' => 100
    ];

    public function skill_mgt($valid)
    {
        $skill_src =  L3Work::where('WorkCat', $this->skill_index['workcat'])->where('L1ID', $this->skill_index['l1'])->where('L2ID', $this->skill_index['l2'])->where('validation', $valid)->where('L3ID',99)->get();
        return $skill_src;
    }
    public function deactivate_skill($Uid)
    {
         L3Work::where('UID', $Uid)->update(['L3ID' => 0]);
         return true;
        
    }    public function active_skill($Uid)
    {
         L3Work::where('UID', $Uid)->update(['validation' => 1]);
         return true;
        
    }

    public function get_user_extra_info_by_data(string $field_name, string $request_felid, $target_user_jobs_info)
    {
        //dd($target_user_jobs_info);
        $user_data = json_decode($target_user_jobs_info, 1);
        if (isset($user_data[$field_name])) {
            if (!isset($user_data[$field_name][$request_felid])) {
                return [
                    'result' => false,
                    'code' => 2,
                    'msg' => 'فیلد مقدار دهی نشده!'
                ];
            }
            return [
                'result' => true,
                'code' => 100,
                'data' => $user_data[$field_name][$request_felid]
            ];
        } else {
            return [
                'result' => false,
                'code' => 2,
                'msg' => 'فیلد مقدار دهی نشده!'
            ];
        }
    }
    public function get_worker_hiring_skills($worker_username)
    {
        $Query = "SELECT WorkerSkils.SkilID,L3Work.Name,WorkerSkils.L2ID , WorkerSkils.Weight from WorkerSkils 
        INNER JOIN L3Work on WorkerSkils.SkilID = L3Work.UID WHERE 
       L3Work.WorkCat = 100 and L3Work.L1ID = 1 and
        WorkerSkils.UserName = '$worker_username' order by WorkerSkils.L2ID  ";
        $UserSkills = DB::select($Query);
        return $UserSkills;

    }
    public function who_is_by_phone($PhoneNumber)
    {
        $Result = UserInfo::where('MobileNo', $PhoneNumber)->orWhere('Phone1', $PhoneNumber)->orWhere('Phone2', $PhoneNumber)->first();
        if ($Result == null) {
            return [
                'result' => false,
                'data' => null
            ];
        }
        return [
            'result' => true,
            'data' => [
                'UserName' => $Result->UserName,
                'Ext' => $Result->Ext,
            ]
        ];

    }

    public function is_mobile_number(string $input_number)
    {
        $Len = strlen($input_number);
        if ($Len == 11) {
            if ($input_number[0] == 0) {
                if ($input_number[1] == 9) {
                    return [
                        'result' => true,
                        'msg' => 'ok'
                    ];
                } else {
                    return [
                        'result' => false,
                        'msg' => 'شماره موبایل می باید با 09 شروع شود'
                    ];
                }
            } else {
                return [
                    'result' => false,
                    'msg' => 'شماره موبایل می باید با 0 شروع شود'
                ];
            }
        } else {
            return [
                'result' => false,
                'msg' => 'طول شماره موبایل وارد شده صحیح نیست'
            ];
        }
    }
    public function find_user_by_code($user_code)
    {
        $user_src = UserInfo::where('Ext', $user_code)->first();
        if ($user_src == null) {
            return [
                'result' => false,
                'msg' => 'The user is not find'
            ];
        }
        return [
            'result' => true,
            'data' => $user_src,
            'UserName' => $user_src->UserName,
            'Ext' => $user_src->Ext,
        ];
    }

}
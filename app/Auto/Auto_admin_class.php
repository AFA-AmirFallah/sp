<?php

namespace App\Auto;

use App\Models\auto_group;
use App\Models\auto_group_members;
use App\Models\auto_tasksـtags_meta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Type\Integer;

class Auto_admin_class extends Auto_main_class
{
    public function change_tag_status($tag_id,$status){
        auto_tasksـtags_meta::where("id",$tag_id)->update(["status"=>$status]);
        return true;

    }
    public function change_group_status($group_id, $target_status)
    {
        $group = Auto_group::find($group_id);
        $group->status = $target_status;
        $group->save();
        return [
            'result' => true
        ];

    }

    public function add_tag(Request $request)
    {
        $tag_name = $request->name;
        $tag_color = $request->Backcolor;
        $tag_exist = $this->if_tag_name_exist($tag_name);
        if ($tag_exist['result']) {
            return [
                'result' => false,
                'msg' => 'برچسبی با این نام در سامانه وجود دارد'
            ];
        }
        $tag_data = [
            'name' => $tag_name,
            'color' => $tag_color,
            'status' => 1
        ];
        $insert_result = auto_tasksـtags_meta::create($tag_data);

        return [
            'result' => true,
            'data' => $insert_result

        ];
    }

    public function add_group(Request $request)
    {
        $group_name = $request->subject;
        $description = $request->desc;
        $group_exist = $this->if_group_name_exist($group_name);
        if ($group_exist['result']) {
            return [
                'result' => false,
                'msg' => 'گروهی با این نام در سامانه وجود دارد'
            ];
        }
        $group_data = [
            'name' => $group_name,
            'creator' => Auth::id(),
            'description' => $description,
            'status' => 0
        ];
        $insert_result = auto_group::create($group_data);
        return [
            'result' => true,
            'data' => $insert_result

        ];
    }
    public function get_group_list()
    {
        $query = "SELECT ag.* , ui.Name as creator_name , ui.Family as creator_family , ( select count(*) from auto_group_members agm  where agm.auto_group_id = ag.id  ) as memeber_count from auto_group ag inner join UserInfo ui on ui.UserName = ag.creator ";
        return DB::select($query);
    }
    public function get_tag_list($status = null)
    {
        if($status == null){
            return auto_tasksـtags_meta::all();

        }
        return auto_tasksـtags_meta::where("status", $status)->get();
    }

    public function get_specific_group(int $group_id)
    {
        $query = "SELECT ag.* , ui.Name as creator_name , ui.Family as creator_family , ( select count(*) from auto_group_members agm  where agm.auto_group_id = ag.id  ) as memeber_count from auto_group ag inner join UserInfo ui on ui.UserName = ag.creator where  ag.id = $group_id ";
        return DB::select($query);

    }
    public function get_group_members($group_id)
    {
        $query = "select agm.* , ui.Name as user_name , ui.Family as user_family  from auto_group_members agm inner join UserInfo ui on ui.UserName = agm.UserName  where agm.auto_group_id = $group_id ";
        return DB::select($query);
    }
    public function if_user_in_group($username, $group_id)
    {
        $memeber_src = auto_group_members::where("UserName", $username)->where('auto_group_id', $group_id)->first();
        if ($memeber_src == null) {
            return [
                'result' => false,
            ];
        }
        return [
            'result' => true,
            'data' => $memeber_src
        ];

    }
    public function add_group_member($group_id, $user_role, $username)
    {
        $user_in_group = $this->if_user_in_group($username, $group_id);
        if ($user_in_group['result']) {
            return [
                'result' => false,
                'msg' => 'کاربر تعیین شده در گروه وجود دارد!'
            ];
        }
        $member_data = [
            'auto_group_id' => $group_id,
            'auto_role_id' => $user_role,
            'UserName' => $username,
        ];
        auto_group_members::create($member_data);
        return [
            'result' => true
        ];

    }

}

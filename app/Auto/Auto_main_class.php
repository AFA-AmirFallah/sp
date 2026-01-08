<?php

namespace App\Auto;

use App\Models\auto_group;
use App\Models\auto_tasksـtags_meta;
use Illuminate\Support\Facades\DB;

class Auto_main_class
{
    public function get_tags($status = null)
    {
        if ($status == null) {
            return auto_tasksـtags_meta::all();
        }
        return auto_tasksـtags_meta::where("status", $status)->get();

    }
    public function if_group_name_exist(string $group_name)
    {
        $group_src = auto_group::where("name", $group_name)->first();
        if ($group_src == null) {
            return [
                'result' => false
            ];
        }
        return [
            'result' => true,
            'data' => $group_src
        ];
    }
    public function if_tag_name_exist(string $tag_name)
    {
        $tag_src = auto_tasksـtags_meta::where('name', $tag_name)->first();

        if ($tag_src == null) {
            return [
                'result' => false
            ];
        }
        return [
            'result' => true,
            'data' => $tag_src
        ];
    }
    public function get_group_members($group_id)
    {
        $query = "SELECT agm.UserName,agm.auto_role_id,ui.Name,ui.Family,ui.avatar from auto_group_members agm inner join UserInfo ui on ui.UserName = agm.UserName and agm.auto_group_id =  $group_id";
        return DB::select($query);
    }

}

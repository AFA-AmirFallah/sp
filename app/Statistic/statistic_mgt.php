<?php

namespace App\Statistic;

use App\Models\statistic_items;
use App\Models\statistic_main;

class statistic_mgt
{
    public function activate_statistic(int $static_id)
    {
        statistic_main::where('id', $static_id)->update(['status' => 101]);
        return true;
    }
    public function deactivate_statistic(int $static_id)
    {
        statistic_main::where('id', $static_id)->update(['status' => 0]);
        return true;
    }
    public function add_item(int $static_id, array $item_info)
    {
        if (!is_array(json_decode($item_info['item_index_str'], true))) {
            return redirect()->back()->with('error', 'رشته شاخص را مطابق الگو تعریف کنید');

        }

        $other_items = statistic_items::where('main_id', $static_id)->orderBy('row_number', 'desc')->first();

        $row_number = 1;
        if ($other_items != null) {
            $row_number = $other_items->row_number + 1;
        }
        $statistic_data = [
            'main_id' => $static_id,
            'row_number' => $row_number,
            'item_name' => $item_info['item_name'],
            'item_index_str' => $item_info['item_index_str'],
        ];
        statistic_items::create($statistic_data);
        return true;

    }
    public function edit_item(int $static_id, array $item_info)
    {
        if (!is_array(json_decode($item_info['item_index_str'], true))) {
            return redirect()->back()->with('error', 'رشته شاخص را مطابق الگو تعریف کنید');

        }
        $statistic_data = [
            'item_name' => $item_info['item_name'],
            'item_index_str' => $item_info['item_index_str'],
        ];
        $other_items = statistic_items::where('id', $item_info['item_id'])->update($statistic_data);
        return true;
    }
    public function add_statistic(array $statistic_info)
    {
        $statistic_data = [
            'Name' => $statistic_info['Name'],
            'period' => $statistic_info['period'],
            'type' => $statistic_info['type'],
            'branch' => $statistic_info['branch'],
            'post' => $statistic_info['post'],
            'desc' => $statistic_info['desc'],

        ];
        $result = statistic_main::create($statistic_data);
        if (isset($result->id)) {
            return [
                'result' => true,
                'id' => $result->id
            ];
        }
        return [
            'result' => false,
            'msg' => 'error inserting data'
        ];
    }
    public function edit_statistic(int $id, array $statistic_info)
    {
        $statistic_data = [
            'Name' => $statistic_info['Name'],
            'period' => $statistic_info['period'],
            'type' => $statistic_info['type'],
            'branch' => $statistic_info['branch'],
            'post' => $statistic_info['post'],
            'desc' => $statistic_info['desc'],

        ];
        $result = statistic_main::where('id', $id)->update($statistic_data);
        return [
            'result' => true,
        ];

    }
    public function get_main_statistic($id)
    {
        return statistic_main::where('id', $id)->first();
    }
    public function get_items_statistic($id)
    {
        return statistic_items::where('main_id', $id)->get();
    }


}
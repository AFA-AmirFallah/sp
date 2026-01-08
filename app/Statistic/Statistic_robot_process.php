<?php

namespace App\Statistic;

use App\Models\statistic_datas;
use App\Models\statistic_items;
use App\Models\statistic_main;

class Statistic_robot_process
{
    private $active_processor = false;
    private $active_src_main;
    private $statistic_items = null;
    private $input_text;
    private $recent_item_name;
    public function __construct()
    {
        $active_src = statistic_main::where('type', 2)->where('status', 101)->first();
        if ($active_src != null) {
            $this->active_processor = true;
            $this->active_src_main = $active_src;
        }

    }
    private function items_loader()
    {
        if ($this->statistic_items == null) {
            $this->statistic_items = statistic_items::where('main_id', $this->active_src_main->id)->get();
            return true;
        }
        return true;
    }
    private function create_new_data_row($main_id, $item_id)
    {
        $data_item = [
            'main_id' => $main_id,
            'item_id' => $item_id,
            'index_date' => now(),
            'one_value' => 1
        ];
        statistic_datas::create($data_item);
        return [
            'result'=>true,
            'msg'=>' ماژول آمار: افزودن شاخص داده جدید'. '('. $this->recent_item_name .')'
        ];
        
    }
    private function find_string($main_id, $item_id)
    {
        //reset each date
        $existing_src = statistic_datas::where('main_id', $main_id)->where('item_id', $item_id)->whereDate('created_at', today())->first();
        if ($existing_src == null) {
            return $this->create_new_data_row($main_id, $item_id);
        }
        $item_src = statistic_datas::find($existing_src->id);
        $item_src->index_date = now();
        $item_src->one_value = $item_src->one_value + 1;
        $item_src->save();
        return [
            'result'=>true,
            'msg'=>' ماژول آمار: به روز رسانی شاخص داده'. '('. $this->recent_item_name .')'
        ];
    }
    private function first_match()
    {
        $this->items_loader();
        foreach ($this->statistic_items as $statistic_items) {
            $item_index_str = $statistic_items['item_index_str'];
            $this->recent_item_name = $statistic_items['item_name'];
            $item_index_arr = json_decode($item_index_str);
            foreach ($item_index_arr as $item_index_item) {
                if (str_contains($this->input_text, $item_index_item)) {
                    return $this->find_string($statistic_items['main_id'], $statistic_items['id']);
                }
            }
        }
        return [
            'result' => false,
            'msg' => 'ماژول آمار: شاخص مناسب یافت نشد!'
        ];
    }
    public function process_text($input_text)
    {
        if (!$this->active_processor) {
            return [
                'result' => false,
                'msg' => 'ماژول آمار غیر فعال!'
            ];
        }
        $this->input_text = $input_text;
        return $this->first_match();
    }

}
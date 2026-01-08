<?php


namespace App\view_counter;

use App\Models\pages_view;
use App\Models\posts;
use App\myappenv;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class View_counter
{
    private $page_type;
    private $target_id;
    private $row_id;
    private $view_count;

    private function is_admin_login()
    {
        if (Auth::check()) {
            if (Auth::user()->Role == myappenv::role_customer) {
                return false;
            }
            return true;

        }
        return false;

    }
    private function is_today_field()
    {
        $today_row = pages_view::where('page_type', $this->page_type)->where('target_id', $this->target_id)->where('target_day', today())->first();
        if ($today_row == null) {
            return false;
        }
        $this->view_count = $today_row->view_count;
        $this->row_id = $today_row->id;
        return true;
    }
    private function add_new_row()
    {
        $row_data = [
            'page_type' => $this->page_type,
            'target_id' => $this->target_id,
            'target_day' => now(),
            'view_count' => 1
        ];
        pages_view::create($row_data);
        return true;
    }
    private function increment_row()
    {
        pages_view::where('id', $this->row_id)->update(['view_count' => $this->view_count + 1]);
        return true;
    }
    public function increment_view($page_type, $target_id)
    {
        if ($this->is_admin_login()) {
            return true;
        }
        $this->page_type = $page_type;
        $this->target_id = $target_id;
        $is_today_field = $this->is_today_field();
        if ($is_today_field) {
            return $this->increment_row();
        }
        return $this->add_new_row();

    }
    public function aggregate_view_counter()
    {
        $updated = 0;
        $duration =
            \App\Http\Controllers\setting\SettingManagement::GetSettingValue('view_count_days') ?? 90;
        $duration = -1 * $duration;
        $active_news_src = posts::where('Status', 1)->get();
        foreach ($active_news_src as $active_news_item) {
            $news_id = $active_news_item->id;
            $query = " SELECT sum(view_count) as view_count FROM pages_views pv WHERE pv.target_day >= DATE_ADD(CURDATE(), INTERVAL $duration DAY) and pv.target_id = $news_id";
            $sum_result = DB::select($query);
            $view_count = $sum_result[0]->view_count ?? 0;
            posts::where('id', $news_id)->update(['ViewCount' => $view_count]);
            $updated++;
        }
        return $updated;
    }
    public static function today_view()
    {
        // $query = "select p.id,p.Titel,p.OutLink ,p.MainPic  ,pv.view_count from pages_views pv inner join posts p on pv.target_id = p.id where pv.target_day  = CURDATE() ORDER by pv.view_count DESC ";
        $query = "select
	p.id,
	p.Titel,
	p.OutLink ,
	p.MainPic ,
	sum(pv.view_count) as view_count
from
	pages_views pv
inner join posts p on
	pv.target_id = p.id
where
	pv.target_day = CURDATE()
	GROUP BY 
	p.id,
	p.Titel,
	p.OutLink ,
	p.MainPic 
ORDER by
	view_count DESC";
        return DB::select($query);

    }
    public static function view_item_history($page_type, $target_id)
    {

        $view_history = pages_view::where('page_type', $page_type)->where('target_id', $target_id)->get();

        return $view_history;
    }
}

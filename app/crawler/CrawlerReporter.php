<?php

namespace App\crawler;

use App\Functions\persian;
use App\Models\crawl_data;
use App\Models\crawler;
use Illuminate\Support\Facades\DB;

class CrawlerReporter
{

    public static function get_product_list()
    {

        $query = "SELECT cd.* , c.Name as c_name from crawl_datas cd  inner join crawlers c on cd.CrawlID  = c.id  where cd.price > 0 ";
        return DB::select($query);
    }
    public static function get_product_total_count()
    {
        $crawl_data = crawl_data::count();
        return $crawl_data;
    }
    public static function get_product_last_update()
    {
        $crawl_data = crawl_data::orderBy('updated_at', 'DESC')->first();
        if ($crawl_data == null) {
            return '--';
        }
        $my_persian = new persian;
        return $my_persian->MyPersianDate($crawl_data->updated_at);
    }
    public static function get_product_process_count()
    {
        $crawl_data = crawl_data::whereNotNull('Name')->count();
        return $crawl_data;
    }
    public static function get_main_crawlers()
    {
        return crawler::where('TargetFun', 4)->get();
    }

}

<?php

namespace App\Http\Controllers;

use App\myappenv;
use Illuminate\Support\Facades\DB;

class RssFeedController extends Controller
{
    public function feed()
    {
        $branch = myappenv::Branch;
        $query = "SELECT p.*,lw.Name as cat_name from posts p inner join L3Work lw on p.MainIndex = lw.UID and p.type = 1 and p.Status =1 and branch = $branch order by id desc LIMIT 10 ";
        $Posts = DB::select($query);


        return response()->view('news.rss_feed', ['type' => 'post', 'Posts' => $Posts])->header('Content-Type', 'text/xml');
    }
}

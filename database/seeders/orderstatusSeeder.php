<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class orderstatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('orderstatus')->insert([[
            'ID' => 1,
            'status' => 'در انتظار بررسی کارشناس',
        ],[
            'ID' => 2,
            'status' => 'ارجاع به مسئول فنی',
        ],[
            'ID' => 3,
            'status' => 'تایید مسئول فنی',
        ],[
            'ID' => 4,
            'status' => 'در دست اقدام',
        ],[
            'ID' => 5,
            'status' => 'در انتظار تماس مجدد مشتری',
        ],[
            'ID' => 6,
            'status' => 'پذیرش و عقد قرارداد',
        ],[
            'ID' => 7,
            'status' => 'عدم پذیرش درخواست',
        ],[
            'ID' => 8,
            'status' => 'کنسل از طرف مشتری',
        ],[
            'ID' => 9,
            'status' => 'انجام شد',
        ]]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
class UserStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('UserStatus')->insert([[
                'Status' => '0',
                'Name' =>'حذف از سیستم',
            ],[
                'Status' => '1',
                'Name' =>'در انتظار تایید ادمین',
            ],[
                'Status' => '2',
                'Name' =>'در انتظار استعلام',
            ],[
                'Status' => '3',
                'Name' =>'در انتظار تکمیل مدارک',
            ],[
                'Status' => '4',
                'Name' =>'فوت شده',
            ],[
                'Status' => '5',
                'Name' =>'اخراج شده',
            ],[
                'Status' => '6',
                'Name' =>'انصراف از همکاری',
            ],[
                'Status' => '101',
                'Name' =>'فعال',
            ],]
        );
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
class educationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('education')->insert([[
            'educationID' => 1,
            'educationName' => 'بی سواد',
        ],[
            'educationID' => 2,
            'educationName' => 'محصل',
        ],[
            'educationID' => 3,
            'educationName' => 'دیپلم',
        ],[
            'educationID' => 4,
            'educationName' => 'دانشجو',
        ],[
            'educationID' => 5,
            'educationName' => 'لیسانس',
        ],[
            'educationID' => 6,
            'educationName' => 'فوق لیسانس',
        ],[
            'educationID' => 7 ,
            'educationName' => 'دکترا',
        ]]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class car_deal_product_type extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('deal_product_type')->insert([
            [ 'id' => 1, 'Name' => 'کامیون' ],[ 'id' => 2, 'Name' => 'کامیونت' ], [ 'id' => 3, 'Name' => 'کشنده' ], [ 'id' => 4, 'Name' => 'اتوبوس' ], [ 'id' => 5, 'Name' => 'مینی بوس' ] 
        ]);
    }
}

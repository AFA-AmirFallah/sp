<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class PicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('picrefrences')->insert([
            [ 'id' => 1, 'type' => '1', 'name' => 'عکس کوچک','W' => '100','H' => '100' ], [ 'id' => 2, 'type' => '1', 'name' => 'عکس بزرگ','W' => '100','H' => '100' ], [ 'id' => 3, 'type' => '1', 'name' => 'عکس رو','W' => '100','H' => '100' ], [ 'id' => 4, 'type' => '1', 'name' => 'عکس پشت','W' => '100','H' => '100' ]
        ]);
    }
}

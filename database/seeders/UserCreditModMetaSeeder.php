<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class UserCreditModMetaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('UserCreditModMeta')->insert([[
            'ID' => 0,
            'ModName' => 'نامعلوم',
        ],[
            'ID' => 1,
            'ModName' => 'قابل برداشت',
        ],[
            'ID' => 2,
            'ModName' => 'غیر قابل برداشت',
        ]]);

    }
}

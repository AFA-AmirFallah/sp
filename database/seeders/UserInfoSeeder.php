<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use DB;

class UserInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('UserInfo')->insert([[
                'UserName' => 'admin',
                'password' => Hash::make('admin'),
                'Name' => 'system',
                'Family' => 'admin',
                'MobileNo' => '09123936105',
                'Email' => 'afa.private@gmail.com',
                'Address' => 'HCIS Center',
                'CreateDate' => now(),
                'Role' => 100,
                'Status' => 101,
                'Ext'=>1000,
                'branch'=>1,
                'Address2'=>'aaa',
                'extranote'=>'note',
            ]]
        );
    }
}

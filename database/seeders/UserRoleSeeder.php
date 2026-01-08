<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('UserRole')->insert([[
            'Role' => '10',
            'RoleName' => 'پیک',
        ],[
            'Role' => '20',
            'RoleName' => 'نیروی عملیاتی',
        ],[
            'Role' => '30',
            'RoleName' => 'فروشنده',
        ],[
            'Role' => '40',
            'RoleName' => 'مشتری',
        ],[
            'Role' => '50',
            'RoleName' => 'کنترل کننده',
        ],[
            'Role' => '60',
            'RoleName' => 'انباردار',
        ],[
            'Role' => '65',
            'RoleName' => 'کال سنتر',
        ],[
            'Role' => '70',
            'RoleName' => 'سوپروایزر',
        ],[
            'Role' => '80',
            'RoleName' => 'ادمین',
        ],[
            'Role' => '90',
            'RoleName' => 'مالی',
        ],[
            'Role' => '95',
            'RoleName' => 'کارگزینی',
        ],[
            'Role' => '100',
            'RoleName' => 'مدیر',
        ]]);

    }
}

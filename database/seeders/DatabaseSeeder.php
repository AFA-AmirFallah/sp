<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(UserInfoSeeder::class);
        $this->call(UserStatusSeeder::class);
        $this->call(UserRoleSeeder::class);
        $this->call(catorderSeeder::class);
        $this->call(UserCreditModMetaSeeder::class);
        $this->call(educationSeeder::class);
        $this->call(orderstatusSeeder::class);
        $this->call(citys_seeder::class);
        $this->call(provinces_seeder::class);
    }
}

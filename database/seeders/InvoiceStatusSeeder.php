<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class InvoiceStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('invoice_statuses')->insert([[
            'id' => 1,
            'StatusName' => 'در انتظار پرداخت',
        ],[
            'id' => 100,
            'StatusName' => 'پرداخت شده',
        ],[
            'id' => 99,
            'StatusName' => 'باطل شده',
        ],[
            'id' => 2,
            'StatusName' => 'انصراف از پرداخت',
        ]]);
    }
}

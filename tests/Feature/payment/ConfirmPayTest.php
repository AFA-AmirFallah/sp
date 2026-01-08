<?php

namespace Tests\Feature\payment;

use App\Models\transactionstemp;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class ConfirmPayTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_ipg_payment() : void
    {
        $price = 10000;
        $gateway = 'sep';
        $ResNum = '11000';
        Session::put('price',$price);
        Session::save();
        $temp_src =  transactionstemp::where('refnumber', $ResNum)->delete();
        $DBData = [
            'refnumber' => $ResNum,
            'Amount' => $price,
            'gateway' => $gateway
        ];
        $insert_result = transactionstemp::create($DBData);

        $response = $this->get(route('ConfirmPayment', ['pay'=>$gateway,'ref'=>$insert_result->id]));

        $response->assertStatus(200);
    }
}

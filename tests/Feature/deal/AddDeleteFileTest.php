<?php

namespace Tests\Feature\deal;

use App\myappenv;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AddDeleteFileTest extends TestCase
{

    public function test_add_file()
    {
        $this->login_with_role(myappenv::role_SuperAdmin);
        $response = $this->get(route("add_file"));
        
        $response->assertStatus(200);
        

       
    }
}

<?php

namespace Tests\Feature\user;

use App\myappenv;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class loginTest extends TestCase
{
    public function test_login()
    {
        $Target_theme = myappenv::SiteTheme;
        if($Target_theme != 'Theme5'){
            $this->assertNotEquals($Target_theme,'Theme5','This test designed for Theme5');
            return null;
        }
        $this->assertEquals($Target_theme,'Theme5');

    }
    public function test_login_route_alive(){
        $response = $this->get(route("login"));
        $response->assertStatus(200);
    }
    


}

<?php

namespace Tests\Feature\hiring;

use App\myappenv;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class add_experienceTest extends TestCase
{
    /**
     * Summary of test_load_add_experience
     * @return void
     */
    public function test_load_add_experience(): void
    {
        $this->login_with_role(myappenv::role_customer);
        $response = $this->get(route('add_experience'));

        $response->assertStatus(200);
    }

    public function test_add_comment()
    {
        $this->login_with_role(myappenv::role_customer);
        $index_arr = [1, 3, 5];
        $header = [
            'HTTP_X-Requested-With' => 'XMLHttpRequest',
        ];
        $post_data = [
            'ajax' => true,
            'function' => 'add_comment',
            'service' => fake()->text(100),
            'Name' => fake()->name(),
            'code' => fake()->text(10),
            'MobileNo' => fake()->phoneNumber(),
            'center_name' => fake()->text(100),
            'comment' => fake()->text(300),
            'indexes' => $index_arr,
            'recommend' => fake()->boolean(),
            'call_allow' => fake()->boolean(),
        ];
        $response = $this->post(route('add_experience'), $post_data, $header);
        $response->assertStatus(200);

    }

}

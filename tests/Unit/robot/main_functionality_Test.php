<?php

namespace Tests\Unit\robot;
use App\robot\RobotMain;
use Tests\TestCase;

class main_functionality_Test extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_robot_can_make_and_handle_storage_file(): void
    {
        $robot = new RobotMain;
        $make_loop_file = $robot->robot_counter();
        $this->assertIsNumeric($make_loop_file, 'first make file has error');
        $make_loop_file_2 = $robot->robot_counter();
        $this->assertIsNumeric($make_loop_file, 'second edit storage file has error');
        $error_text = "make sure your robot is not active or something has error 
        - the first value is : $make_loop_file and the second value is : $make_loop_file_2 ";
        $this->assertEquals($make_loop_file_2 - $make_loop_file, 1, $error_text);

    }
    public function test_robot_variable_is_working()
    {
        $variable_name = 'test_var';
        $robot = new RobotMain;
        $var_result = $robot->get_robot_var($variable_name);
        $this->assertNull($var_result, 'this is not error : please remove robot storage file and then run the test');
        $var_result = $robot->set_robot_var($variable_name, 'salam');
        $this->assertTrue($var_result, 'can not set robot variable');
        $var_result = $robot->get_robot_var($variable_name);
        $this->assertEquals($var_result, 'salam', 'some error in set variable!');
    }

}

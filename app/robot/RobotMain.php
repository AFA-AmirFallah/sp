<?php

namespace App\robot;
use Illuminate\Support\Facades\Storage;

class RobotMain
{

    public function robot_counter()
    {
        if (Storage::exists('robot/LoopCounter.txt')) {
            $LoopCounter = Storage::get('robot/LoopCounter.txt');
            $LoopCounter++;
            if ($LoopCounter > 1440) { //reset loop counter after 24 hours
                $LoopCounter = 1;
            }
            Storage::put('robot/LoopCounter.txt', $LoopCounter);
            return $LoopCounter;
        }
        $LoopCounter = 1;
        Storage::put('robot/LoopCounter.txt', $LoopCounter);
        return $LoopCounter;

    }
    public function get_robot_var($var_name)
    {
        if (Storage::exists("robot/$var_name.txt")) {
            return Storage::get("robot/$var_name.txt");
        }
        return null;
    }
    public function set_robot_var($var_name, $var_value)
    {
        Storage::put("robot/$var_name.txt", $var_value);
        return true;

    }
}
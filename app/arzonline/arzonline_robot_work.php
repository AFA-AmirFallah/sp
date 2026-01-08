<?php

namespace App\arzonline;

class arzonline_robot_work
{
    public function each_run(){
        $api = new arzonline_api;
        $candle = new arzonline_candle;
        $token =  $api->get_token();
        $derham_info = $api->listbyid('-1001841865296',$token);
        $candle->update_candles($derham_info,'DRH-TMN');
        $usd_info = $api->listbyid('-1001823825116',$token);
        $candle->update_candles($usd_info,'USD-TMN');
        $usdt_info = $api->listbyid('-1001913313670',$token);
        $candle->update_candles($usdt_info,'USDT-TMN');
        return true;

    }

}
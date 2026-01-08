<?php

namespace App\APIS;

use Exception;

class spot_player
{
    private $API = 'Y9kTbm6i+MU8FTMei9aCsEf61nNixRiKQXqW/Aw=';

    private function filter($a): array
    {
        return array_filter($a, function ($v) {
            return !is_null($v);
        });
    }

    private function request($u, $o = null)
    {
        curl_setopt_array($c = curl_init(), [
            CURLOPT_URL => $u,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => $o ? 'POST' : 'GET',
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_FOLLOWLOCATION => false,
            CURLOPT_HTTPHEADER => ['$API: ' . $this->API, '$LEVEL: -1', 'content-type: application/json'],
        ]);
        if ($o) curl_setopt($c, CURLOPT_POSTFIELDS, json_encode($this->filter($o)));
        $json = json_decode(curl_exec($c), true);
        curl_close($c);
        if (is_array($json) && ($ex = @$json['ex'])) throw new Exception($ex['msg']);
        return $json;
    }

    private function license($name, $courses, $watermarks, $test)
    {
        return $this->request('https://panel.spotplayer.ir/license/edit/', [
            'test' => $test,
            'name' => $name,
            'course' => $courses,
            'watermark' => ['texts' => array_map(function ($w) {
                return ['text' => $w];
            }, $watermarks)]
        ]);
    }
    public function get_license($username,$course_code,$mobile_no)
    {
        $L = $this->license($username, [$course_code], [$mobile_no], false);
        return [
            'ID' => $L['_id'],
            'key' => $L['key'],
            'URL' => $L['url'],
            'course_code'=>$course_code
        ];
    }
}

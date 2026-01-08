<?php

namespace App\APIS;

class bale
{
    private $active_bale;
    private $bale_token;
    private $bale_user;
    private $bale_chatid;

    function __construct()
    {
        $this->active_bale = \App\Http\Controllers\setting\SettingManagement::GetSettingValue('bale_api') ?? 0;
        $this->bale_token = \App\Http\Controllers\setting\SettingManagement::GetSettingValue('bale_api_token') ?? 0;
        $this->bale_user = \App\Http\Controllers\setting\SettingManagement::GetSettingValue('bale_api_name') ?? 0;
        $this->bale_chatid = \App\Http\Controllers\setting\SettingManagement::GetSettingValue('bale_api_chat_id') ?? 0;
    }
    public function send_message($message_text)
    {
        if(! $this->active_bale){ // if bale is not active
            return true;
        }
        $bale_token = $this->bale_token;
        $chat_id = $this->bale_chatid;
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://tapi.bale.ai/bot$bale_token/sendMessage",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => array(
                'text' => $message_text,
                'chat_id' => $chat_id
            ),
        ));
        $response = curl_exec($curl);
        $response = json_decode($response);
        return $response->ok;

    }
}
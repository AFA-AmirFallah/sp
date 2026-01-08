<?php

namespace App\Http\Controllers\APIS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ICC extends Controller
{
    public function pay()
    {
        $terminalid = 
        $params = "terminalid=2005998&amount=10000&payload=&callbackurl=http://yoursite.com/sample_php2&invoiceid=20202454887";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://service.iccard.ir");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $res2 = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($res2, true);
        if ($result["status"]) {
            header("location: https://service.iccard.ir/pay/" . $result["invoiceid"]);
        } else {
            echo
            "لطفا بعدا تلاش کنید";
        }
    }
}

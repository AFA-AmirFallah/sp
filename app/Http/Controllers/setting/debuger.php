<?php

namespace App\Http\Controllers\setting;

use App\Functions\Indexes;
use App\Http\Controllers\Controller;
use App\Http\Controllers\crawler\CrawlerMain;
use App\Models\goodindex;
use App\Models\L3Work;
use App\Models\warehouse_goods;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Functions\CallCenterClass;

class debuger extends Controller
{
    public static function DebugEnable()
    {
        if ((session()->has('testdebug'))) {
            if (Session::get('testdebug')) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    public function Dodebugger(Request $request)
    {
        dd('ddd');
    }
    public function signature($sub_url, $request_method, $api_key): string
    {
        $plain  = $sub_url . '#' . time() . '#' . $request_method . '#' . $api_key;
        $key    = hex2bin($api_key);
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
        $digest = openssl_encrypt($plain, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);

        return bin2hex($digest);
    }
    public function send_sms()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.sms.ir/v1/send/verify',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
        "mobile": "09123936105",
        "templateId": 770112,
        "parameters": [
          {
            "name": "CODE",
            "value": "000000"
          }
        ]
      }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Accept: text/plain',
                'x-api-key: DgbmpeZvrxfGtVD0TwAryWolFTYNAYOoKn1jQKBc3aD6lJUZhzthudjq8HbUeZLe'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
    }

    public function debugger(Request $request, $State = null)
    {
        dd(env('Branch'));
        $crowler = new CrawlerMain;
        $outout = $crowler->rayan_reader();
        dd('inja');
        $reader = new CrawlerMain;
        $ss = $reader->bama_reader();
        dd('injam');
        $call_center = new CallCenterClass();
        echo $call_center->synccalls();

        dd('ssss');
        return $this->send_sms();
        dd('hiiii');
        $sig = $this->signature('/payment/purchase', 'POST', '4565175b030b173ec1398366150ab0b7cb5d973023b1eb90abbdc435b987ff85');
        dd($sig);
        $l3 = new L3Work();
        $l3->WorkCat = 100;
        $l3->L1ID = 100;
        $l3->L2ID = 100;
        $l3->L3ID = 100;
        $l3->Name = 'test';
        $l3->Description = 'test';
        $l3->img = 'test';
        $result = $l3->save();
        dd($result->id);



        dd('end');
        $filename = 'products.xml';
        $contents = File::get($filename);

        $xml = simplexml_load_string($contents);

        $json = json_encode($xml);

        $array = json_decode($json, TRUE);
        $array = $array['Product'];
        foreach ($array as $array_item) {
            $product_id = $array_item['ProductId'];
            $StockQuantity = $array_item['StockQuantity'];
            $StockQuantity = intval($StockQuantity);
            if ($StockQuantity < 0) {
                $StockQuantity = 0;
            }
            if (isset($array_item['TierPrices'])) {
                $PriceFormola = [];
                $TierPrices = $array_item['TierPrices'];
                foreach ($TierPrices as $TierPrices_item) {
                    foreach ($TierPrices_item as $TierPrices_item_s) {
                        if (isset($TierPrices_item_s['Quantity'])) {
                            array_push($PriceFormola, ['ToNumber' => intval($TierPrices_item_s['Quantity']), 'Price' => intval($TierPrices_item_s['Price'])]);
                        }
                    }
                }

                if ($PriceFormola == []) {
                    $PriceFormola = json_encode($PriceFormola);
                    $target_wg =  warehouse_goods::where('GoodID', $product_id)->first();
                    $update_data = [
                        'QTY' => $StockQuantity
                    ];
                    warehouse_goods::where('GoodID', $product_id)->update($update_data);
                } else {
                    $PriceFormola = json_encode($PriceFormola);
                    $target_wg =  warehouse_goods::where('GoodID', $product_id)->first();
                    $update_data = [
                        'PricePlan' => $PriceFormola,
                        'QTY' => $StockQuantity
                    ];
                    warehouse_goods::where('GoodID', $product_id)->update($update_data);
                }

                echo 'ok => ' . $product_id;
            }
        }
        dd('end');
        echo 'salam';
    }
}

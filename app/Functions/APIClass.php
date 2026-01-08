<?php


namespace App\Functions;

use Throwable;

class APIClass
{
    public function PostCurl($TargetAddress, $postRequest){
        $cURLConnection = curl_init($TargetAddress);
        if($postRequest != null){

            curl_setopt($cURLConnection, CURLOPT_POSTFIELDS, $postRequest);

        }

        curl_setopt($cURLConnection, CURLOPT_HEADER, 0);
        curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER,2); // Return data inplace of echoing on screen
        curl_setopt($cURLConnection, CURLOPT_URL, $TargetAddress);
        curl_setopt($cURLConnection, CURLOPT_SSL_VERIFYPEER, 0); // Skip SSL Verification
       // curl_setopt($cURLConnection, CURLOPT_PROXY, true);

        $apiResponse = curl_exec($cURLConnection);
        dd($TargetAddress,$apiResponse);
        curl_close($cURLConnection);
        return $apiResponse;

    }

    public function TwoDirectionCall($SourceNumber,$DestinationNumber,$Duration){
        $Duration *= 1000;
        // $Url= "https://192.168.66.250/autodial.php?phone=$SourceNumber&phone2=$DestinationNumber&time=$Duration";
        $Url ="https://79.127.58.251:8001/autodial.php?phone=$SourceNumber&phone2=$DestinationNumber&time=$Duration";
        $Url ="https://79.127.58.251:60660/autodial.php?phone=$SourceNumber&phone2=$DestinationNumber&time=$Duration";
        $arrContextOptions=array(
            "ssl"=>array(
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ),
        );
        try{
            $response = file_get_contents($Url, false, stream_context_create($arrContextOptions));
            return $response;

        }catch(Throwable $e){
            report($e);
            return 'error';
        }
    }

}

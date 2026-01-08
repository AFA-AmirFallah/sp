<?php

namespace App\Http\Controllers\security;

use Session;
use App\Http\Controllers\Controller;
use App\Models\SiteUrls;
use App\Models\SiteVists;
use App\myappenv;
use Illuminate\Http\Request;

class soc extends Controller
{
    public function RouteValidator()
    {
        if (myappenv::Lic['Statistics']) {
            $REMOTE_ADDR = request()->server('REMOTE_ADDR');
            $REQUEST_METHOD = request()->server('REQUEST_METHOD');
            $HTTP_SEC_CH_UA_PLATFORM = request()->server('HTTP_SEC_CH_UA_PLATFORM');
            $REQUEST_URI = urldecode(request()->server('REQUEST_URI'));
            $SiteUrls = SiteUrls::where('UrlAddress', $REQUEST_URI)->first();
            if ($SiteUrls == null) {
                $InsrtData = [
                    'UrlAddress' => $REQUEST_URI,
                ];
                $resutl = SiteUrls::create($InsrtData);
                $UrlID = $resutl->id;
            } else {
                $UrlID = $SiteUrls->id;
            }
            $InsetData = [
                'UrlAddress' => $UrlID,
                'REMOTE_ADDR' => $REMOTE_ADDR,
                'REQUEST_METHOD' => $REQUEST_METHOD
            ];
            SiteVists::create($InsetData);
        }
    }
}

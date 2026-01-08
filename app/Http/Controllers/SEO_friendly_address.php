<?php

namespace App\Http\Controllers;

use App\SEO\seo_urls;
use Illuminate\Http\Request;

class SEO_friendly_address extends Controller
{

    public function call_seo_friendly_address($seo_address)
    {
        if ($seo_address == null) { 
            return abort('404', 'صفحه درخواست شده وجود ندارد');
        }
        $seo_url = new seo_urls;
        return $seo_url->get_address_view($seo_address);
    }
}

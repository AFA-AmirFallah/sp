<?php

namespace App\SEO;

use App\Functions\TextClassMain;
use App\Models\metadata;

class seo_base
{
    public function is_valid_url_to_save($Target_url)
    {
        $mytext = new TextClassMain;
        $Target_url = $mytext->StripText($Target_url);
        $same_urls = metadata::where('tt', 'seo_url')->where('meta_value', $Target_url)->first();
        if ($same_urls == null) {
            return [
                'result' => true,
                'data' => $Target_url
            ];
        } 
        return [
            'result' => false,
            'msg' => 'مشابه لینک درخواست شده در سامانه موجود می باشد!'
        ];
    }
    
}

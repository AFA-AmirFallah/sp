<?php

namespace App\SEO;

use App\Models\metadata;

class seo_base_user extends seo_base
{
    private $UserName;
    private $url_src;
    function __construct($UserName)
    {
        $this->UserName = $UserName;
        $this->url_src = metadata::where('tt', 'seo_url')->where('meta_key', 'user')->where('fgstr', $this->UserName)->first();
    }
    /**
     * This function return family url if exist otherwise return null
     */
    public function get_url()
    {
        if ($this->url_src == null) {
            return null;
        }
        return $this->url_src->meta_value;
    }

    public function set_url($target_url)
    {
        metadata::where('tt', 'seo_url')->where('meta_key', 'user')->where('fgstr', $this->UserName)->delete();
        $meta_data = [
            'tt' => 'seo_url',
            'meta_key' => 'user',
            'fgstr' => $this->UserName,
            'meta_value' => $target_url,
            'status' => 101
        ];
        $insert_result = metadata::create($meta_data);
        return [
            'result' => true,
            'data' => $insert_result
        ];
    }
}

<?php

namespace App\crawler;

use DOMDocument;
use DOMXPath;
use Exception;

class html_analyzer
{
    private $html_input;
    private $html_json_script;
    private $recursive_search_last_type;

    public function __construct($html_input)
    {
        $this->html_input = $html_input;
        return $this->analyze_input();
    }
    private function analyze_input()
    {
        try {
            $dom = new DOMDocument();
            libxml_use_internal_errors(1);
            $dom->loadHTML($this->html_input);
            $xpath = new DOMXPath($dom);
            $jsonScripts = $xpath->query('//script[@type="application/ld+json"]');
            $this->html_json_script = trim($jsonScripts->item(0)->nodeValue);
            $this->html_json_script = json_decode(utf8_decode($this->html_json_script));
            return [
                'result' => true
            ];
        } catch (Exception $e) {
            return [
                'result' => false
            ];
        }
    }


    public function get_index_value($Key, $Arr = null)
    {
        if ($Arr == null) {
            $Arr = $this->html_json_script;
        }
        foreach ($Arr as $Arrkey => $Arrvalue) {
            if (is_object($Arrvalue)) {
                $result = $this->get_index_value($Key, $Arrvalue);
                if ($result != 'false') {
                    return $result;
                }
            }
            if (is_array($Arrvalue)) {
                if ($Arrkey == $Key) {
                    foreach ($Arrvalue as $ArrvalueTarget) {
                        return $ArrvalueTarget;
                    }
                }
                $result = $this->get_index_value($Key, $Arrvalue);
                if ($result != 'false') {
                    return $result;
                }
            } else {
                if ($Arrkey == "@type") {
                    $this->recursive_search_last_type = $Arrvalue;
                }
                if ($Key == $Arrkey) {
                    if ($this->recursive_search_last_type == 'Product') {
                        return $Arrvalue;
                    }
                }
            }
        }
        return 'false';
    }
}

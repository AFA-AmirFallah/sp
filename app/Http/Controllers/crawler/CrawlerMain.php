<?php

namespace App\Http\Controllers\crawler;

use App\APIS\bale;
use App\Functions\persian;
use App\Http\Controllers\Controller;
use App\Models\branches;
use App\Models\crawler;
use App\Models\crawl_data;
use App\Models\divar;
use App\Models\goods;
use App\Models\picrefrence;
use App\Models\report_detial;
use App\Models\sheypoor;
use App\Models\store;
use App\Models\warehouse;
use App\Models\warehouse_goods;
use App\robot\RobotMain;
use App\Statistic\Statistic_robot_process;
use Carbon\Carbon;
use DateTime;
use DOMDocument;
use DOMXPath;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function PHPUnit\Framework\isArray;

/**
 * Crawler_data Status
 * Status -1 = The link unprocessable
 * Status 0 = The link added and not process
 * Status 1 = The link Precessed
 * Status 2 = Deleted Precessed Link
 * Status 3 = Link is Precesable
 *
 * Status 100 = The link Related to internal Product
 *
 */
class CrawlerMain extends Controller
{
    private $product_price;
    public function competitor()
    {
        $Query = "SELECT  c.Name as cname, cd.* from crawlers c  inner join crawl_datas cd  on c.id = cd.CrawlID where cd.src_date >= DATE_ADD(CURDATE(), INTERVAL -3 DAY)  ";
        $crawler_src = DB::select($Query);
        $crawler_main_src = crawler::where('TargetFun', 3)->get();
        $title = 'فعالیت دو روزه رقبا';
        return view('crawler.competitor', ['crawler_src' => $crawler_src, 'crawler_main_src' => $crawler_main_src, 'title' => $title]);
    }
    public function Docompetitor(Request $request)
    {
        if ($request->submit == 'show_result') {
            $MyPersian = new persian();
            $StartDate_sh = $request->input('StartDate');
            $StartDate = $MyPersian->MiladiDate($request->input('StartDate'));
            $EndDate_sh = $request->input('EndDate');
            $EndDate = $MyPersian->MiladiDate($request->input('EndDate'));
            $Query = "SELECT  c.Name as cname, cd.* from crawlers c  inner join crawl_datas cd  on c.id = cd.CrawlID where cd.src_date >= '$StartDate' and cd.src_date <= '$EndDate' ";
            $crawler_src = DB::select($Query);
            $crawler_main_src = crawler::where('TargetFun', 3)->get();
            $title = "گزارش رقبا از تاریخ $StartDate_sh تا $EndDate_sh";
            return view('crawler.competitor', ['crawler_src' => $crawler_src, 'crawler_main_src' => $crawler_main_src, 'title' => $title]);
        }
        if ($request->has('reindex')) {

            if ($request->reindex == 'reindex') {
                $reindex = $this->reindex();
                return redirect()->back()->with('success', 'رقبا بررسی شدند');
            }
            $reindex = $this->reindex($request->reindex);
            return redirect()->back()->with('success', 'رقبا بررسی شدند');

        }

    }
    private function do_price_review()
    {
        $Items = crawl_data::where('Status', 0)->first();
        /*       if ($Items != null) {
                   $this->IsValidLink($Items->id);
                   return true;
               }*/
        $Items = crawl_data::where('Status', 100)->first();
        if ($Items != null) {
            $msg = $this->update_link($Items->id);
            $update_item = crawl_data::where('id', $Items->id)->first();
            $url_address = $update_item->TargetAddress;
            $bale = new bale;
            $send_description = " *$update_item->Name*
            $msg

            ";
            $send_description .= "

            $url_address
                                    ";
            $bale->send_message($send_description);
            return true;
        }
        $robot = new RobotMain;
        $robot->set_robot_var('has_record_to_process', 0);
        return true;
    }

    public function price_review()
    {
        $robot = new RobotMain;
        $counter = $robot->robot_counter();
        $var_result = $robot->get_robot_var('has_record_to_process') ?? 0;
        if ($counter == 10 || $counter == 180 || $counter == 360 || $counter == 540 || $counter == 720) {
            $crawl_result = $this->re_crawl_item(1);
            $robot->set_robot_var('has_record_to_process', 1);
        }
        if ($var_result != 1) {
            return true;
        }
        $this->do_price_review();
    }
    private function update_link($link_id)
    {
        $persian = new persian;
        $Name = false;
        $Items = crawl_data::where('id', $link_id)->first();
        $DataHistory = $Items->DataHistory;
        $DataHistory_new = '';
        $SourceAddress = $Items->TargetAddress;
        $CrawlID = $Items->CrawlID;
        $CrawlSrc = crawler::where('id', $CrawlID)->first();
        $TargetFun = $CrawlSrc->TargetFun;
        $result = $this->ItemAnalyzer($TargetFun, $SourceAddress);
        $Name = $result['Name'];
        $price = $result['price'];
        $image = $result['image'];
        $priceCurrency = $result['priceCurrency'];
        $availability = $result['availability'];
        $description = $result['description'];
        if ($availability != $Items->availability) {
            $DataHistory_new .= ' در تاریخ: ' . $persian->MyPersianNow() . ' ' . ' موجودی به ' . $availability . 'تغییر یافت';
        }
        if ($price != $Items->price) {
            $DataHistory_new .= ' در تاریخ: ' . $persian->MyPersianNow() . ' ' . ' قیمت از   ' . number_format($Items->price) . '  به ' . number_format($price) . 'تغییر یافت';
        }
        $DataHistory = $DataHistory . $DataHistory_new;
        if ($Name != 'false') {
            $DataSnap = [
                'Name' => $Name,
                'price' => $price,
                'priceCurrency' => $priceCurrency,
                'availability' => $availability,
                'image' => $image,
                'description' => $description,
            ];
            $TargetData = json_encode($DataSnap);
            $UpdateData = [
                'Name' => $Name,
                'TargetData' => $TargetData,
                'price' => $price,
                'DataHistory' => $DataHistory,
                'Status' => 3,
            ];
            crawl_data::where('id', $link_id)->update($UpdateData);
        } else {
            $DataUpdate = [
                'Status' => -1,
            ];
            crawl_data::where('id', $link_id)->update($DataUpdate);
        }
        return $DataHistory_new;
    }
    public function re_crawl_item($crawl_id)
    {
        $competitor_src = crawler::where('id', $crawl_id)->first();
        if ($competitor_src == null) {
            return [
                'result' => false,
                'msg' => 'مرجع کرال یافت نشد'
            ];
        }
        $sitemap = $competitor_src->Targets;
        $html = file_get_contents($sitemap);
        $reader_result = $this->sitemap_reader($html, $crawl_id);

        return $reader_result;
    }

    private function reindex($index_id = null)
    {
        if ($index_id == null) {
            $competitor_src = crawler::where('TargetFun', 3)->where('Status', 1)->get();

        } else {
            $competitor_src = crawler::where('id', $index_id)->get();

        }
        foreach ($competitor_src as $competitor_item) {
            $sitemap = $competitor_item->Targets;
            $html = file_get_contents($sitemap);
            $this->sitemap_reader($html, $competitor_item->id);
        }
        foreach ($competitor_src as $competitor_item) {
            $this->find_undefine_urls($competitor_item->id);
        }
        return true;
    }
    private function get_product_arr($Arr)
    {
        foreach ($Arr as $Arrkey => $Arrvalue) {
            if (is_string($Arrvalue)) {
                continue;
            }
            if (isArray($Arrvalue)) {
                if (isset($Arrvalue[1])) {
                    return $Arrvalue[1];
                }
            }
        }
        return [];
    }


    public function ArraySearcher($Arr, $Key)
    {
        $product_arr = $this->get_product_arr($Arr);
        if ($Key == 'price') {
            $this->product_price = 0;
            $this->product_price_searcher($product_arr, $Key);
            $price = $this->product_price;
            return $price;
        }
        $result = $this->ArraySearcher_product($product_arr, $Key);

        return $result;
    }
    private function product_price_searcher($Arr, $Key)
    {
        foreach ($Arr as $Arrkey => $Arrvalue) {
            if (is_array($Arrvalue)) {
                if (isset($Arrvalue[$Key])) {
                    if ($this->product_price == 0) {
                        $this->product_price = $Arrvalue[$Key];
                    }
                    if ($Arrvalue[$Key] < $this->product_price) {
                        $this->product_price = $Arrvalue[$Key];
                    }
                }
                $this->product_price_searcher($Arrvalue, $Key);
            } else {
                if (isset($Arr[$Key])) {
                    if ($this->product_price == 0) {
                        $this->product_price = $Arr[$Key];
                    }
                    if ($Arr[$Key] < $this->product_price) {
                        $this->product_price = $Arr[$Key];
                    }
                }
            }
        }
        return false;
    }


    private function ArraySearcher_product($Arr, $Key)
    {
        $return_result = 'false';
        // $key = array_search($Key, $Arr);

        foreach ($Arr as $Arrkey => $Arrvalue) {
            if (is_object($Arrvalue)) {
                $result = $this->ArraySearcher_product($Arrvalue, $Key);
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
                $result = $this->ArraySearcher_product($Arrvalue, $Key);
                if ($result != 'false') {
                    return $result;
                }
            } else {
                if ($Key == $Arrkey) {
                    if ($Key == 'name') {
                        return $Arrvalue;
                    }
                    if ($Key == 'price') {

                        if ($this->product_price == 0) {
                            $return_result = $Arrvalue;
                            $this->product_price = $Arrvalue;
                            return false;
                        }
                        if ($this->product_price > $Arrvalue) {
                            $return_result = $Arrvalue;
                            $this->product_price = $Arrvalue;
                            return false;
                        }
                    } else {
                        $return_result = $Arrvalue;
                    }
                }
            }
        }
        return $return_result;
    }
    public function ArraySearcher1($Arr, $Key)
    {
        foreach ($Arr as $Arrkey => $Arrvalue) {
            if (is_array($Arrvalue)) {
                $result = $this->ArraySearcher($Arrvalue, $Key);
                if ($result != 'false') {
                    return $result;
                }
            } else {
                if ($Key == $Arrkey) {
                    return $Arrvalue;
                }
            }
        }
        return 'false';
    }
    public function IsValidLink($ID, $Force = false)
    {
        $Name = false;
        $Items = crawl_data::where('id', $ID)->first();
        if (!$Force) {
            if ($Items->Status != 0) {
                return 'before';
            }
        }
        $SourceAddress = $Items->TargetAddress;
        $CrawlID = $Items->CrawlID;
        $CrawlSrc = crawler::where('id', $CrawlID)->first();
        $TargetFun = $CrawlSrc->TargetFun;
        $result = $this->ItemAnalyzer($TargetFun, $SourceAddress);
        $Name = $result['Name'];
        $price = $result['price'];
        $image = $result['image'];
        $priceCurrency = $result['priceCurrency'];
        $availability = $result['availability'];
        $description = $result['description'];
        if ($Name != 'false') {
            $DataSnap = [
                'Name' => $Name,
                'price' => $price,
                'priceCurrency' => $priceCurrency,
                'availability' => $availability,
                'image' => $image,
                'description' => $description,
            ];
            $TargetData = json_encode($DataSnap);
            $UpdateData = [
                'Name' => $Name,
                'TargetData' => $TargetData,
                'Status' => 3,
            ];
            crawl_data::where('id', $ID)->update($UpdateData);
        } else {
            $DataUpdate = [
                'Status' => -1,
            ];
            crawl_data::where('id', $ID)->update($DataUpdate);
        }
        return $Name;
    }
    public function AnalyzeModel1($TargetAddress)
    {

        try {
            $htmlContent = file_get_contents($TargetAddress);
            $dom = new DOMDocument();
            libxml_use_internal_errors(1);
            $dom->loadHTML($htmlContent);
            $xpath = new DOMXPath($dom);
            $jsonScripts = $xpath->query('//script[@type="application/ld+json"]');
            $json = trim($jsonScripts->item(0)->nodeValue);
            $json = json_decode(utf8_decode($json));

            $Name = $this->ArraySearcher($json, 'caption');

            $price = $this->ArraySearcher($json, 'price');
            if ($price == null || $price == "false") {
                $price = 0;
            } else {
                $price *= 10;
            }

            $image = $this->ArraySearcher($json, 'image');
            $priceCurrency = $this->ArraySearcher($json, 'priceCurrency');
            $availability = $this->ArraySearcher($json, 'availability');
            $description = $this->ArraySearcher($json, 'description');
            $Output = [
                'Name' => $Name,
                'price' => $price,
                'image' => $image,
                'priceCurrency' => $priceCurrency,
                'availability' => $availability,
                'description' => $description,
            ];
            return $Output;
        } catch (Exception $e) {
            $Output = [
                'Name' => false,
                'price' => false,
                'image' => false,
                'priceCurrency' => false,
                'availability' => false,
                'description' => false,
            ];
            return $Output;
        }
    }
    private function sypor_text()
    {
        return '';
    }
    private function divar_reader()
    {
        $prefix = '<script type="application/ld+json">';
        $htmlContent = file_get_contents('https://divar.ir/s/tehran/heavy-car');
        $htmlContent = mb_convert_encoding($htmlContent, 'UTF-8', mb_detect_encoding($htmlContent, 'UTF-8, ISO-8859-1', true));
        $htmlContent = strstr($htmlContent, $prefix);
        $end_prefix = '</script>';
        if (strpos($htmlContent, $prefix) === 0) {
            $htmlContent = substr($htmlContent, strlen($prefix));
        }

        //$htmlContent = substr($htmlContent, 0, -1);
        $htmlContent = substr($htmlContent, 0, strpos($htmlContent, $end_prefix));
        $htmlContent = json_decode($htmlContent);
        $bale = new bale;
        if ($htmlContent != null) {
            $robot = new Statistic_robot_process();
            foreach ($htmlContent as $html_item) {
                $target = false;
                $url_address = $html_item->url;
                $title = $html_item->name;
                $description = $html_item->description;
                $text = $title . ' ' . $description;
                if (str_contains($text, 'کامیون')) {
                    $target = true;
                }
                if (str_contains($text, 'کشنده')) {
                    $target = true;
                }
                if (str_contains($text, 'کامیونت')) {
                    $target = true;
                }
                if ($target) {
                    $old_src = divar::where('url_address', $url_address)->first();
                    if ($old_src == null) { // not add before
                        $desc = json_encode($html_item);
                        $divar_src = [
                            'url_address' => $url_address,
                            'desc' => $desc,
                        ];
                        divar::create($divar_src);


                        $offers = $html_item->offers;
                        $price = $offers->price ?? 0;
                        if ($price == 0) {
                            $price = 'توافقی';
                        } else {
                            $price = number_format($price);
                        }


                        $send_description = " *$title *
$description ";
                        $statistic = $robot->process_text($send_description);
                        $statistic = $statistic['msg'];
                        $send_description .= "
$statistic
قیمت:  $price
$url_address
                        ";

                        $bale->send_message($send_description);
                    }
                }
            }
        }
        return true;
    }

    private function sheypor_reader()
    {
        /*    $htmlContent = json_decode($this->sypor_text());
            return $htmlContent;*/
        $prefix = '{"state":{"data":{"pages":';
        $htmlContent = file_get_contents('https://www.sheypoor.com/s/iran/commercial-cars');
        $htmlContent = mb_convert_encoding($htmlContent, 'UTF-8', mb_detect_encoding($htmlContent, 'UTF-8, ISO-8859-1', true));
        $htmlContent = strstr($htmlContent, $prefix);
        $end_prefix = ',"extra_sections"';
        if (strpos($htmlContent, $prefix) === 0) {
            $htmlContent = substr($htmlContent, strlen($prefix));
        }
        //$htmlContent = substr($htmlContent, 0, -1);
        $htmlContent = substr($htmlContent, 0, strpos($htmlContent, $end_prefix));
        if (strpos($htmlContent, '[{"data":') === 0) {
            $htmlContent = substr($htmlContent, strlen('[{"data":'));
        }
        $htmlContent = substr($htmlContent, 0, -1);
        $htmlContent = $htmlContent . ']';
        $htmlContent = json_decode($htmlContent);
        return $htmlContent;
    }
    public function get_string_between($string, $start, $end)
    {
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0)
            return [
                'substring' => '',
                'remain_string' => ''
            ];
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        $substring = substr($string, $ini, $len);
        $remain_string = substr($string, $ini + $len);
        return [
            'substring' => $substring,
            'remain_string' => $remain_string
        ];
    }

    public function bama_reader()
    {
        $prefix = "window.__NUXT__=(function(";
        $htmlContent = file_get_contents('https://bama.ir/truck');
        $htmlContent = mb_convert_encoding($htmlContent, 'UTF-8', mb_detect_encoding($htmlContent, 'UTF-8, ISO-8859-1', true));
        $htmlContent = strstr($htmlContent, $prefix);
        $end_prefix = ';</script>';
        if (strpos($htmlContent, $prefix) === 0) {
            $htmlContent = substr($htmlContent, strlen($prefix));
        }

        //$htmlContent = substr($htmlContent, 0, -1);
        $htmlContent = substr($htmlContent, 0, strpos($htmlContent, $end_prefix));

        if (strpos($htmlContent, '[{"data":') === 0) {
            $htmlContent = substr($htmlContent, strlen('[{"data":'));
        }
        $temp_html = $htmlContent;
        while ($temp_html != '') {
            $pos = strpos($temp_html, '.detail=');
            //dd($pos);
            $symbol = substr($temp_html, $pos - 2, 2);
            dd($symbol);
            $temp_html = $this->get_string_between($temp_html, ';', '.detail=');
            echo $temp_html['substring'] . '<br>';
            $temp_html = $temp_html['remain_string'];
        }
        // echo $htmlContent;

        dd('');

        while ($htmlContent != '') {
            $htmlContent = $this->get_string_between($htmlContent, 'metadata=', ']');
            echo $htmlContent['substring'] . '<br>';
            $htmlContent = $htmlContent['remain_string'];
        }


        dd('');
        $htmlContent = substr($htmlContent, 0, -1);
        $htmlContent = $htmlContent . ']';
        $htmlContent = json_decode($htmlContent);
        return $htmlContent;
    }
    public function rayan_reader()
    {
        $divar_src = $this->divar_reader();
        return true;
        $shypor_src = $this->sheypor_reader();
        $bale = new bale;
        //  dd($shypor_src);
        foreach ($shypor_src as $shypor_item) {
            foreach ($shypor_item->items as $shypor_ad_src) {
                //id
                // dd($shypor_ad_src);
                $src_id = $shypor_ad_src->id; //varchar 12
                $src_type = $shypor_ad_src->type;
                $description = $shypor_ad_src->description;
                $attributes = $shypor_ad_src->attributes;
                $title = $attributes->title;
                $location = $attributes->location;
                $url = $attributes->url;
                $categoryId = $attributes->categoryId;
                $telephone = $attributes->telephone;
                $fullAttributes = json_encode($shypor_ad_src->fullAttributes);
                $price_src = $attributes->price;
                $price = '';
                foreach ($price_src as $price_item) {
                    $price .= $price_item->label . ' ' . $price_item->amount . ' ' . $price_item->currency . ' ';
                }
                $cat_src = $attributes->categories;
                foreach ($cat_src as $cat_item) {
                    if ($cat_item->id == $categoryId) {
                        $categoryname = $cat_item->name;
                    }
                }
                $images = json_encode($attributes->images->thumbnails);
                $price = trim($price);
                $exist_feild = sheypoor::where('src_id', $src_id)->first();
                if ($exist_feild == null) {
                    $database_feild = [
                        'src_id' => $src_id,
                        'src_type' => $src_type,
                        'location' => $location,
                        'telephone' => $telephone,
                        'title' => $title,
                        'price' => $price,
                        'categoryname' => $categoryname,
                        'categoryId' => $categoryId,
                        'description' => $description,
                        'url' => $url,
                        'images' => $images,
                        'fullAttributes' => $fullAttributes
                    ];
                    sheypoor::create($database_feild);
                    $send_description = " *$title *
" . $description . "
$price" . "
$location
" . "
$url";
                    $bale->send_message($send_description);
                }
            }
        }
        $send_description = "آنالیز در تاریخ: " . date('Y-m-d H:i:s');
        $bale->send_message($send_description);
        echo 'done';
        return true;
    }

    public function AnalyzeModel4($TargetAddress)
    {
        /**
         * model kafe kado
         * price is worng format should change to Rial by multiple 10
         */

        try {
            $htmlContent = file_get_contents($TargetAddress);
            $dom = new DOMDocument();
            libxml_use_internal_errors(1);
            $dom->loadHTML('<?xml encoding="utf-8" ?>' . $htmlContent);
            $xpath = new DOMXPath($dom);

            $jsonScripts = $xpath->query('//script[@type="application/ld+json"]');
            $json = $jsonScripts->item(0)->nodeValue;
            $json = trim($json);
            $json = preg_replace('/[[:cntrl:]]/', '', $json);
            $json = json_decode($json, true);

            $Name = $this->ArraySearcher($json, 'name');
            $price = $this->ArraySearcher($json, 'price');

            if ($price == null || $price == "false") {
                $price = 0;
            } else {
                $price *= 10;
            }

            $image = $this->ArraySearcher($json, 'image');
            $priceCurrency = $this->ArraySearcher($json, 'priceCurrency');
            $availability = $this->ArraySearcher($json, 'availability');
            $description = $this->ArraySearcher($json, 'description');
            $Output = [
                'Name' => $Name,
                'price' => $price,
                'image' => $image,
                'priceCurrency' => $priceCurrency,
                'availability' => $availability,
                'description' => $description,
            ];
            return $Output;
        } catch (Exception $e) {
            $Output = [
                'Name' => false,
                'price' => false,
                'image' => false,
                'priceCurrency' => false,
                'availability' => false,
                'description' => false,
            ];
            return $Output;
        }
    }
    public function AnalyzeModel2($TargetAddress)
    {
        try {
            $htmlContent = file_get_contents($TargetAddress);
            $dom = new DOMDocument();
            libxml_use_internal_errors(1);
            $dom->loadHTML($htmlContent);
            $xpath = new DOMXPath($dom);
            $jsonScripts = $xpath->query('//script[@type="application/ld+json"]');
            $json = trim($jsonScripts->item(1)->nodeValue);
            $json = json_decode(utf8_decode($json));
            $Name = $this->ArraySearcher1($json, 'name');
            $price = $this->ArraySearcher1($json, 'price');
            $image = $this->ArraySearcher1($json, 'image');
            $priceCurrency = $this->ArraySearcher1($json, 'priceCurrency');
            $availability = $this->ArraySearcher1($json, 'availability');
            $description = $this->ArraySearcher1($json, 'description');
            $Output = [
                'Name' => $Name,
                'price' => $price,
                'image' => $image,
                'priceCurrency' => $priceCurrency,
                'availability' => $availability,
                'description' => $description,
            ];
            return $Output;
        } catch (Exception $e) {
            $Output = [
                'Name' => false,
                'price' => false,
                'image' => false,
                'priceCurrency' => false,
                'availability' => false,
                'description' => false,
            ];
            return $Output;
        }
    }
    public function AnalyzeModel3($TargetAddress)
    {
        try {
            $tags = get_meta_tags($TargetAddress);
            if (isset($tags['priceCurrency'])) {
                $priceCurrency = $tags['priceCurrency'];
            } else {
                $priceCurrency = 'notset';
            }
            $Output = [
                'Name' => $tags['productname'],
                'price' => $tags['productprice'],
                'image' => $tags['productname'],
                'priceCurrency' => $priceCurrency,
                'availability' => $tags['availability'],
                'description' => $tags['description'],
            ];
            return $Output;
        } catch (Exception $e) {
            $Output = [
                'Name' => false,
                'price' => false,
                'image' => false,
                'priceCurrency' => false,
                'availability' => false,
                'description' => false,
            ];
            return $Output;
        }
    }

    public function ItemAnalyzer($AnalyzeModel, $TargetAddress)
    {
        switch ($AnalyzeModel) {
            case 1:
                return $this->AnalyzeModel1($TargetAddress);
                break;
            case 2:
                return $this->AnalyzeModel2($TargetAddress);
                break;
            case 3:
                return $this->AnalyzeModel3($TargetAddress);
                break;
            case 4:
                return $this->AnalyzeModel4($TargetAddress);
                break;
            default:
                return 'endofProcess';
        }
    }
    public function ItemAnalyze($ID)
    {
        /**
         *  $src = "salam this is test";
         *      preg_match("/salam (.*) test/", $src, $result);
         *
         */
        $Name = '';
        $price = '';
        $image = '';
        $priceCurrency = '';
        $availability = '';
        $description = '';
        $Items = crawl_data::where('id', $ID)->first();
        if ($Items == null) {
            return abort('404', 'صفحه درخواستی وجود ندارد');
        }
        $CrawlID = $Items->CrawlID;
        $CrawlSrc = crawler::where('id', $CrawlID)->first();
        $TargetFun = $CrawlSrc->TargetFun;
        if ($TargetFun == null) {
            return abort('404', 'نحوه پردازش برای سیستم مشخص نشده است!');
        }

        $SourceAddress = $Items->TargetAddress;

        //  dd($SourceAddress);
        if ($Items->Status == 0 || $Items->Status == -1) {

            $result = $this->ItemAnalyzer($TargetFun, $SourceAddress);
            $Name = $result['Name'];
            $price = $result['price'];

            $image = $result['image'];
            $image = (array) $image;
            if (!isset($image['@id'])) {
                $image = $image[0];
            } else {
                $image = $image['@id'];
            }

            $priceCurrency = $result['priceCurrency'];
            $availability = $result['availability'];
            $description = $result['description'];
        }
        if ($Items->Status > 0) {
            $TargetData = json_decode($Items->TargetData);
            $Name = $TargetData->Name;
            $price = $TargetData->price;
            $image = $TargetData->image;
            $image = (array) $image;

            if (!isset($image['@id'])) {
                $image = $image[0];
            } else {
                $image = $image['@id'];
            }

            $priceCurrency = $TargetData->priceCurrency;
            $availability = $TargetData->availability;
            $description = $TargetData->description;
        }
        return view('crawler.CrawleItem', ['Status' => $Items->Status, 'Name' => $Name, 'SourceAddress' => $SourceAddress, 'price' => $price, 'image' => $image, 'priceCurrency' => $priceCurrency, 'description' => $description, 'availability' => $availability]);
    }
    public function DoItemAnalyze($ID, Request $request)
    {

        if ($request->input('submit') == 'addnew') {
            $ItemSource = crawl_data::where('id', $ID)->first();
            $MainCrowler = crawler::where('id', $ItemSource->CrawlID)->first();
            $MainCrowlerID = $MainCrowler->id;
            $MainCrowlerName = $MainCrowler->Name;
            $TargetBranchSrc = branches::where('Name', $MainCrowlerName)->first();
            if ($TargetBranchSrc == null) {
                return redirect()->back()->with('error', 'شعبه ای به نام ' . $MainCrowlerName . ' در سامانه تعریف نشده است!');
            }
            $TargetStore = store::where('branch', $TargetBranchSrc->id)->first();
            if ($TargetStore == null) {
                return redirect()->back()->with('error', 'فروشگاهی به نام ' . $MainCrowlerName . ' در سامانه تعریف نشده است!');
            }
            $TargetWarehouse = warehouse::where('StoreID', $TargetStore->id)->first();
            if ($TargetWarehouse == null) {
                $warehousedata = [
                    'Name' => $MainCrowlerName,
                    'StoreID' => $TargetStore->id,
                    'status' => 1,
                    'address' => '',
                    'phone' => '',
                    'Postalcode' => '',
                ];
                warehouse::create($warehousedata);
                $TargetWarehouse = warehouse::where('StoreID', $TargetStore->id)->first();
            }
            $Sorurceimg = $request->input('image');
            if ($Sorurceimg != 'false') {
                $url = $Sorurceimg;
                $FilePath = "storage/photos/$MainCrowlerID";
                if (!is_dir($FilePath)) {
                    mkdir($FilePath, 0777, true);
                }
                $ext = pathinfo($Sorurceimg, PATHINFO_EXTENSION);
                $FileName = $ID . '.' . $ext;
                $img = "storage/photos/$MainCrowlerID/$FileName";
                file_put_contents($img, file_get_contents($url));
                $img = url('/') . "/storage/photos/$MainCrowlerID/$FileName";
                $picrefrence = picrefrence::all()->where('type', 1);
                $mainArr = array();
                $initimge = true;
                foreach ($picrefrence as $picrefrenceItem) {
                    if ($initimge) {
                        $NewArray = ['RefrenceID' => $picrefrenceItem->id, 'PicUrl' => $img];
                        $initimge = false;
                    } else {
                        $NewArray = ['RefrenceID' => $picrefrenceItem->id, 'PicUrl' => ''];
                    }
                    array_push($mainArr, $NewArray);
                }
                $ImgURL = json_encode($mainArr);
            } else {
                $ImgURL = '';
            }
            $updatedata = [
                'NameFa' => $request->input('Name'),
                'Description' => $request->input('description'),
                'MainDescription' => $request->input('description'),
                'SKU' => $ID,
                'IRID' => '',
                'IntID' => '',
                'downloadable' => '',
                'onsale' => 1,
                'Status' => 0,
                'total_sales' => 0,
                'stock_status' => 1,
                'stock_quantity' => 1,
                'rating_count' => 0,
                'ImgURL' => $ImgURL,
                'Unit' => 0,
                'urladdress' => $ID,
                'weight' => 100,
            ];
            $ProductResult = goods::create($updatedata);
            $ProductMainID = $ProductResult->id;
            $Price = $request->input('price');
            $Price = ($Price * 0.05) + $Price;
            $Data = [
                'WarehouseID' => $TargetWarehouse->id,
                'GoodID' => $ProductMainID,
                'QTY' => 1,
                'BuyPrice' => $request->input('price'),
                'MinPrice' => $Price,
                'MaxPrice' => $Price,
                'Price' => $Price,
                'OnSale' => 1,
                'SaleLimit' => 1,
                'AlertLimit' => 10,
                'AlertFinish' => 0,
                'InputDate' => now(),
                'MadeDate' => now(),
                'ExpireDate' => now(),
                'ActiveTime' => now(),
                'BasePrice' => $Price,
                'Remian' => 1,
                'DeactiveTime' => now(),
            ];
            $UserID = Auth::id();
            $ArryData = [
                'BuyPrice' => $request->input('BuyPrice'),

            ];
            $reportData = json_encode($ArryData);
            $SaveData = [
                'ProductID' => $ProductMainID,
                'WGID' => $TargetWarehouse->id,
                'UserID' => $UserID,
                'ReportType' => 5, //add product
                'ReportVal' => $reportData,
            ];
            report_detial::create($SaveData);
            $wpres = warehouse_goods::create($Data);
            $LocalWP = $wpres->id;
            crawl_data::where('id', $ID)->update(['LocalWP' => $LocalWP]);
            return redirect()->back()->with('success', 'عملیات موفقیت آمیز انجام شد');
        }
        if ($request->input('submit') == 'add') {
            if ($request->has('priceCurrency')) {
                $priceCurrency = $request->input('priceCurrency');
            } else {
                $priceCurrency = 'IRI';
            }
            if ($request->has('availability')) {
                $availability = $request->input('availability');
            } else {
                $availability = 'NotSet';
            }
            $DataSnap = [
                'Name' => $request->input('Name'),
                'price' => $request->input('price'),
                'priceCurrency' => $priceCurrency,
                'availability' => $availability,
                'image' => $request->input('image'),
                'description' => $request->input('description'),
            ];
            $TargetData = json_encode($DataSnap);
            $UpdateData = [
                'Name' => $request->input('Name'),
                'TargetData' => $TargetData,
                'Status' => 1,
            ];
            crawl_data::where('id', $ID)->update($UpdateData);
            return redirect()->back()->with('success', 'آدرس مورد نظر به انالیز محصول اضافه شد!');
        }
        if ($request->input('submit') == 'delete') {
            $UpdateData = [
                'Status' => 2, //dete product
            ];
            crawl_data::where('id', $ID)->update($UpdateData);
            return redirect()->back()->with('success', 'آدرس مورد نظر از آنالیز محصول حذف شد!');
        }
        if ($request->input('submit') == 'readd') {
            $UpdateData = [
                'Status' => 1, //readd product
            ];
            crawl_data::where('id', $ID)->update($UpdateData);
            return redirect()->back()->with('success', 'آدرس مورد نظر از آنالیز محصول حذف شد!');
        }
        if ($request->input('submit') == 'Link') {
            $ProductID = $request->input('targetID');
            $UpdateData = [
                'Status' => 100, //link product product
                'LocalProduct' => $ProductID,
            ];
            crawl_data::where('id', $ID)->update($UpdateData);
            return redirect()->back()->with('success', 'ارتباط با محصول داخلی برقرار گردید!');
        }
    }
    public function Crawler(Request $request, $ID)
    {
        if ($request->has('analyze')) {
            return view('crawler.Crawler_analyze');
        } else {
            $MinSrc = crawler::where('id', $ID)->first();
            $Items = crawl_data::where('CrawlID', $ID)->get();
            return view('crawler.Crawler', ['MinSrc' => $MinSrc, 'Items' => $Items]);
        }
    }
    private function next_crowl($ID)
    {
        $TargetItem = crawl_data::where('TargetData', null)->where('CrawlID', $ID)->first();
        if ($TargetItem == null) {
            echo 'Noting To Do';
        } else {
            $CrawlSrc = crawler::where('id', $TargetItem->CrawlID)->first();
            $TargetFun = $CrawlSrc->TargetFun;
            if ($TargetFun == null) {
                return [
                    'result' => false,
                    'msg' => 'اتمام کرال محصولات'
                ];
            } else {
                $address = $TargetItem->TargetAddress;
                $CrowlResutl = $this->ItemAnalyzer($TargetFun, $TargetItem->TargetAddress);
                $Name = $CrowlResutl['Name'];
                $price = $CrowlResutl['price'];
                $priceCurrency = $CrowlResutl['priceCurrency'];
                $availability = $CrowlResutl['availability'];
                $image = $CrowlResutl['image'];
                $description = $CrowlResutl['description'];
                $DataSnap = [
                    'Name' => $Name,
                    'price' => $price,
                    'priceCurrency' => $priceCurrency,
                    'availability' => $availability,
                    'image' => $image,
                    'description' => $description,
                ];
                $TargetData = json_encode($DataSnap);
                if ($Name == false && $price == false) {
                    $Status = -1;
                } else {
                    $Status = 3;
                }
                $UpdateData = [
                    'Name' => $Name,
                    'price' => $price,
                    'TargetData' => $TargetData,
                    'Status' => $Status,
                ];
                crawl_data::where('id', $TargetItem->id)->update($UpdateData);
                return [
                    'result' => true,
                    'data' => view('crawler.Crawler_analyze_item', ['address' => $address, 'image' => $image, 'price' => $price, 'Name' => $Name])->render()
                ];
            }
        }
    }
    public function DoCrawler($ID, Request $request)
    {
        if ($request->ajax()) {
            if ($request->AjaxType == 'another') {
                return $this->next_crowl($ID);
            }
        }
        if ($request->submit == 'check_all') {
            $this->find_undefine_urls($ID);
            return redirect()->back()->with('success', 'done');
        }
        if ($request->input('submit') == 'processselect') {

            $samplelink = $request->input('samplelink');
            $sampleprice = $request->input('sampleprice');

            $LinkSrc = crawl_data::where('CrawlID', $ID)->where('TargetAddress', $samplelink);
            if ($LinkSrc == null) {
                return redirect()->back()->with('error', 'لینک وارد شده در لیست کرال ها موجود نیست' . '<br>' . $samplelink);
            }
            for ($x = 1; $x < 5; $x++) {
                $SearchResutl = $this->ItemAnalyzer(4, $samplelink);

                //  dd($SearchResutl['price'], $sampleprice);
                if ($SearchResutl['price'] == $sampleprice || $SearchResutl['price'] == $sampleprice * 10 || $SearchResutl['price'] == 0) {
                    //find way
                    crawler::where('id', $ID)->update(['TargetFun' => $x]);
                    return redirect()->back()->with('success', 'فرمول پردازش یافت شد');
                } else {
                    $mesg = 'مبلغ وارد شده' . $sampleprice . '<br>' . 'مبلغ  دریافت شده از سایت' . $SearchResutl['price'];
                    return redirect()->back()->with('error', $mesg);
                }
            }
            return redirect()->back()->with('error', 'مبلغ دریافتی از سایت مرجع استخراج نشد!');
        }
    }
    public function MainCrawler()
    {
        $query = "SELECT c.* , count(cd.id) as items_count  from crawlers c left join crawl_datas cd  on c.id  = cd.CrawlID GROUP by c.id ,c.Name	,c.Targets	,c.Status,	c.TargetFun,	c.created_at,	c.updated_at ";
        $elements = DB::select($query);
        return view('crawler.MainCrawler', ['elements' => $elements]);
    }
    private function add_crowl(Request $request)
    {
        if ($request->input('CrowlMod') == 1) {
            $SaveData = [
                'Name' => $request->input('Name'),
                'Targets' => $request->input('Target1'),
                'Status' => $request->input('staus'),
            ];
        } elseif ($request->input('CrowlMod') == 2) {
            $SaveData = [
                'Name' => $request->input('Name'),
                'Targets' => $request->input('Target1'),
                'TargetFun' => 10,
                'Status' => $request->input('staus'),
            ];
        } else {
            $SaveData = [
                'Name' => $request->input('Name'),
                'Targets' => $request->input('Target1'),
                'TargetFun' => $request->input('CrowlMod'),
                'Status' => $request->input('staus'),
            ];
        }
        crawler::create($SaveData);
        return redirect()->back()->with('success', 'کرال جدید افزوده شد');
    }
    public function page_load_data($item_id)
    {
    }

    private function extractMetaTags($html)
    {
        $dom = new DOMDocument();

        // خاموش کردن هشدارهای HTML نامعتبر
        libxml_use_internal_errors(true);

        $dom->loadHTML($html);
        libxml_clear_errors();

        $metaTags = $dom->getElementsByTagName('meta');
        $metaData = [];

        foreach ($metaTags as $meta) {
            $name = $meta->getAttribute('name');
            $property = $meta->getAttribute('property');
            $content = $meta->getAttribute('content');

            // اگر name یا property وجود داشته باشد، آن را به عنوان کلید استفاده می‌کنیم
            if ($name) {
                $metaData[$name] = $content;
            } elseif ($property) {
                $metaData[$property] = $content;
            }
        }

        return $metaData;
    }


    public function find_undefine_urls($CrawlID)
    {
        $item_src = crawl_data::where('CrawlID', $CrawlID)->whereNull('og_title')->get();
        foreach ($item_src as $item) {
            $TargetAddress = $item->TargetAddress;
            $htmlContent = file_get_contents($TargetAddress);
            libxml_use_internal_errors(true); // Yeah if you are so worried about using @ with warnings
            $doc = new DomDocument();
            $doc->loadHTML($htmlContent);
            $xpath = new DOMXPath($doc);
            $query = '//*/meta[starts-with(@property, \'og:\')]';
            $metas = $xpath->query($query);
            $rmetas = array();
            foreach ($metas as $meta) {
                $property = $meta->getAttribute('property');
                $content = $meta->getAttribute('content');
                $rmetas[$property] = $content;
            }
            if (isset($rmetas['og:title'])) {
                $update_og = [
                    'og_title' => $rmetas['og:title'],
                    'og_site_name' => $rmetas['og:site_name'] ?? '',
                    'og_type' => $rmetas['og:type'] ?? '',
                    'og_description' => $rmetas['og:description'] ?? '',
                ];
                crawl_data::where('id', $item->id)->update($update_og);
            } else {
                $tags = $this->extractMetaTags($htmlContent);

                $update_og = [
                    'og_title' => $tags['twitter:title'],
                    'og_site_name' => $tags['publisher'] ?? '',
                    'og_type' => '',
                    'og_description' => $tags['description'] ?? '',
                ];
                crawl_data::where('id', $item->id)->update($update_og);


            }

        }
        return 'true';
    }
    private function sitemap_reader($sitemap_src, $CrawlID)
    {
        try {

            $xml = simplexml_load_string($sitemap_src, "SimpleXMLElement", LIBXML_NOCDATA);
        } catch (\Exception $e) {
            echo 'error in parse!';


            return [
                'result' => false,
                'UpdateItems' => null,
                'AddItems' => null
            ];


        }

        $json = json_encode($xml);
        $arraySrc = json_decode($json, true);

        if (isset($arraySrc['url'])) {
            $arraySrc = $arraySrc['url'];
        } else {
            $arraySrc = $arraySrc['sitemap'];
        }

        $AddItems = 0;
        $UpdateItems = 0;
        foreach ($arraySrc as $arrayTarget) {
            $LastMod = $arrayTarget['lastmod'];
            $TargetAddress = $arrayTarget['loc'];
            $CroulTargetSrc = crawl_data::where('CrawlID', $CrawlID)->where('TargetAddress', $TargetAddress)->first();
            if ($CroulTargetSrc == null) { // new distination
                $time = strtotime($LastMod);
                $new_date = date('Y-m-d', $time);
                $new_time = date('H:i', $time);
                $DataSrc = [
                    'CrawlID' => $CrawlID,
                    'TargetAddress' => $TargetAddress,
                    'SourceDate' => $LastMod,
                    'src_date' => $new_date,
                    'src_time' => $new_time,
                    'Status' => 0,
                ];
                crawl_data::create($DataSrc);
                $AddItems++;
            } else { // has before
                if ($CroulTargetSrc->SourceDate != $LastMod) {
                    $time = strtotime($LastMod);
                    $new_date = date('Y-m-d', $time);
                    $new_time = date('H:i', $time);
                    $new_date = [
                        'SourceDate' => $LastMod,
                        'src_date' => $new_date,
                        'src_time' => $new_time,
                        'Status' => 100
                    ];
                    crawl_data::where('id', $CroulTargetSrc->id)->update($new_date);
                    $UpdateItems++;
                }
            }
        }
        return [
            'result' => true,
            'UpdateItems' => $UpdateItems,
            'AddItems' => $AddItems
        ];
    }
    private function edit_crowl(Request $request)
    {
        $SaveData = [
            'Name' => $request->input('Name'),
            'Targets' => $request->input('Target1'),
            'Status' => $request->input('staus'),
        ];
        crawler::where('id', $request->input('tableid'))->update($SaveData);
        return redirect()->back()->with('success', 'کرال به روز رسانی شد!');
    }
    public function DoMainCrawler(Request $request)
    {
        if ($request->has('crawl')) {

            $CrawlID = $request->input('crawl');
            $CrawlSrc = crawler::where('id', $CrawlID)->first();
            $TargetXML = $CrawlSrc->Targets;
            $html = file_get_contents($TargetXML);

            if ($CrawlSrc->TargetFun == 10) {

                // if wordpress API V2
                $SoruceJson = json_decode($html);
                //&page=30
                dd($SoruceJson);
                $Routes = $SoruceJson->routes;
                foreach ($Routes as $RouteTarget) {
                    print_r($RouteTarget);
                }
                dd('finish');
            } else {
                $read_result = $this->sitemap_reader($html, $CrawlID);
                $AddItems = $read_result['AddItems'];
                $UpdateItems = $read_result['UpdateItems'];
                return redirect()->back()->with('success', 'کرال با موفقیت انجام شد' . '<br>' . "آپدیت شده: $UpdateItems" . '<br>' . "افزوده شده: $AddItems");
            }
        }
        if ($request->input('submit') == 'add') {
            return $this->add_crowl($request);
        }
        if ($request->input('submit') == 'edit') {
            return $this->edit_crowl($request);
        }
    }
}

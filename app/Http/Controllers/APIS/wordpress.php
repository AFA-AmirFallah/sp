<?php
/*
To find wordpress categuray use :
SELECT tax.term_id , tax.parent , tax.count ,ter.name FROM hoxicquhne_term_taxonomy as tax INNER JOIN hoxicquhne_terms as ter ON tax.term_id = ter.term_id WHERE taxonomy = 'product_cat' ORDER BY `tax`.`term_id` ASC


** sql to get attribute

CREATE TABLE attr AS ( SELECT tr.object_id,tr.term_taxonomy_id,tt.name,tt.term_group,tx.taxonomy FROM hoxicquhne_term_relationships as tr INNER JOIN hoxicquhne_terms as tt on tr.term_taxonomy_id = tt.term_id INNER JOIN hoxicquhne_term_taxonomy as tx on tr.term_taxonomy_id = tx.term_id)


*/


namespace App\Http\Controllers\APIS;

use App\Http\Controllers\Controller;
use App\Models\citys;
use App\Models\goodindex;
use App\Models\goods;
use App\Models\provinces;
use App\Models\warehouse_goods;
use App\myappenv;
use Illuminate\Http\Request;
use DB;

class wordpress extends Controller
{
    public function addindex($ProductId = null)
    {
        if ($ProductId == null) {
            $ProductSrc = goods::all();
        } else {
            $ProductSrc = goods::all()->where('id', $ProductId);
        }
        $UpdateItems = 0;
        foreach ($ProductSrc as $ProductItem) {
            $UpdateItems++;
            $TargetProductId = $ProductItem->id;
            $term_relationships = myappenv::wordressDatabsePree . 'term_relationships';
            $Query = "SELECT * FROM $term_relationships WHERE object_id = $TargetProductId";
            $result = $this->DGKAR_Select($Query);
            $result = json_decode($result);
            goodindex::where('GoodID', $TargetProductId)->delete();
            foreach ($result as $TargetIndex) {
                $CreateData = [
                    'GoodID' => $TargetProductId,
                    'IndexID' => $TargetIndex->term_taxonomy_id,
                    'CreateDate' => now(),
                    'Creator' => 'sync'
                ];
                goodindex::create($CreateData);
            }
        }
        return 'Updated feild = ' . $UpdateItems;
    }
    public function main($State, Request $request)
    {
        if ($State == 'syncproduct') {
            if (isset($request->start)) {
                $Start = $request->start;
            } else {
                $Start = 0;
            }
            if (isset($request->end)) {
                $End = $request->end;
            } else {
                $End = 10000000;
            }
            return $this->sysncProduct($Start, $End);
        }
        if ($State == 'syncindex') {
            if (isset($request->id)) {
                $ProductID = $request->id;
            } else {
                $ProductID = null;
            }
            return $this->addindex($ProductID);
        }
        if ($State == 'syncpictures') {
            return 'updated = ' . $this->syncpictures();
        }
        if ($State == 'sysncweight') {
            return 'updated = ' . $this->sysncweight();
        }
        if ($State == 'syncatt') {
            return 'updated = ' . $this->syncatt();
        }
        if ($State == 'testme') {
            // **Danger**  return 'updated = ' . $this->testme();
        }
    }
    public function testme()
    {
        $Goods = goods::all()->where('temprow', '!=', null);
        foreach ($Goods as $GoodItem) {
            $maintext = $GoodItem->temprow;
            $maintext = unserialize($maintext);
            echo "<br> GoodId = $GoodItem->id  <br> ";
            $Output = '';
            foreach ($maintext as $TargetItem) {
                if ($TargetItem["is_taxonomy"] == 1) {
                    $taxonomy = $TargetItem["name"];
                    $result =  DB::select("SELECT name FROM `attr` WHERE object_id = $GoodItem->id and taxonomy = '$taxonomy'");
                    foreach ($result as $target) {
                        $Output .= '<p class="productAttr">' . substr($taxonomy, 3) . ' : ' . $target->name . '</p>';
                    }
                } else {
                    $Output .= '<p class="productAttr">' . $TargetItem["name"] . ' : ' . $TargetItem["value"] . '</p>';
                }
            }
            if ($Output != '') {
                $OldDesc =  $GoodItem->MainDescription;
                $MainDescription = [
                    'DiscText' => $Output,
                    'MainText' => $OldDesc
                ];
                $MainDescription = json_encode($MainDescription);
                goods::where('id', $GoodItem->id)->update(['MainDescription' => $MainDescription]);
            }
        }
    }
    public function syncatt()
    {
        $postmeta = myappenv::wordressDatabsePree . 'postmeta';
        $Query = "SELECT pm.post_id , pm.meta_value  FROM $postmeta pm  WHERE pm.meta_key = '_product_attributes'";
        $result = $this->DGKAR_Select($Query);
        $result = json_decode($result);
        $unpic = goods::all();
        $count = 0;
        foreach ($unpic as $unpicItem) {
            foreach ($result as $resultItem) {
                if ($resultItem->post_id == $unpicItem->id) {
                    goods::where('id', $unpicItem->id)->update(['temprow' => $resultItem->meta_value]);
                    $count++;
                    break;
                }
            }
        }
        return $count;
    }
    public function downloadfromtableoffile()
    {
        $Prefix = "https://api.kookbaz.ir/";
        $Query = "SELECT * FROM kookbazSRCPic  where UploadCheck = 0 and SourcePics like '$Prefix%'";
        $MainSrc = DB::select($Query);
        foreach ($MainSrc as $SrcItem) {
            $SourcePics = $SrcItem->SourcePics;
            $FilePath = str_replace($Prefix, "", $SourcePics);
            $FileName = basename($SourcePics);
            $FilePath = str_replace($FileName, "", $FilePath);
            $FilePath = 'storage/photos/convert/' . $FilePath;
            if (!is_dir($FilePath)) {
                mkdir($FilePath, 0777, true);
            }
            $Query1 = "UPDATE kookbazSRCPic SET UploadCheck = 2 WHERE  SourcePics = '$SourcePics' ";
            DB::update($Query1);
            file_put_contents($FilePath . $FileName, fopen($SourcePics, 'r'));
            $Query1 = "UPDATE kookbazSRCPic SET UploadCheck = 1 WHERE  SourcePics = '$SourcePics' ";
            DB::update($Query1);
        }
    }
    public function syncpictures()
    {
        $posts = myappenv::wordressDatabsePree . 'posts';
        $postmeta = myappenv::wordressDatabsePree . 'postmeta';
        $Query = "SELECT pm.post_id , p.guid FROM $postmeta pm INNER JOIN $posts p on pm.meta_value = p.ID WHERE pm.meta_key = '_thumbnail_id'";
        $result = $this->DGKAR_Select($Query);
        $result = json_decode($result);
        $unpic = goods::all()->where('ImgURL', '');
        $count = 0;
        foreach ($unpic as $unpicItem) {
            foreach ($result as $resultItem) {
                if ($resultItem->post_id == $unpicItem->id) {
                    $storage_path = 'https://pwa.sepehrmall.com/storage/photos/';
                    $mainArr = array();

                    $str = $resultItem->guid;
                    $fileaddress = strstr($str, 'uploads/');
                    $fileaddress = $storage_path . '/' . $fileaddress;
                    $NewArray = ['RefrenceID' => 1, 'PicUrl' => $fileaddress];
                    array_push($mainArr, $NewArray);
                    $Mianjson = json_encode($mainArr);
                    goods::where('id', $unpicItem->id)->update(['ImgURL' => $Mianjson]);
                    $count++;
                    break;
                }
            }
        }
        return $count;
    }
    public function sysncweight()
    {
        $postmeta = myappenv::wordressDatabsePree . 'postmeta';
        $Query = "SELECT * FROM $postmeta WHERE meta_key = '_weight'";
        $postmeta = $this->DGKAR_Select($Query);
        $postmeta = json_decode($postmeta);
        $UpdateItems = 0;
        foreach ($postmeta as $postmetaItem) {
            $weight = 0;
            if ($postmetaItem->meta_value != '') {
                $weight = $postmetaItem->meta_value * 1000;
                $UpdateItems++;
            }
            goods::where('id', $postmetaItem->post_id)->update(['weight' => $weight]);
        }
        return $UpdateItems;
    }

    public function sysncProduct($start, $end)
    {
        $posts = myappenv::wordressDatabsePree . 'posts';
        $Query = "SELECT * FROM $posts WHERE post_type = 'product' and post_status = 'publish'";
        $result = $this->DGKAR_Select($Query);
        $result = json_decode($result);
        $UpdateField = 0;
        $AddedField = 0;
        foreach ($result as $WpProduct) {
            $product_id = $WpProduct->ID;
            $localgood = goods::where('id', $product_id)->first();
            if ($localgood != null) {

                $ExistProduct = warehouse_goods::where('GoodID', $product_id)->first();
                if ($ExistProduct == null) { // add to warehouse
                    $postmeta = myappenv::wordressDatabsePree . 'postmeta';
                    $Query = "SELECT * FROM $postmeta WHERE post_id = $product_id";
                    $postmeta = $this->DGKAR_Select($Query);
                    $postmeta = json_decode($postmeta);
                    $WarehouseID = 1;
                    $Discount = 0;
                    $OnSale = 0;
                    $BuyPrice = 0;
                    $Remians = 0;
                    $Price = 0;
                    $BasePrice = 0;
                    $weight = 0;
                    foreach ($postmeta as $postmetaItem) {
                        if ($postmetaItem->meta_key == '_regular_price') {
                            $BasePrice = $postmetaItem->meta_value;
                        }
                        if ($postmetaItem->meta_key == '_sale_price') {
                            $Price = $postmetaItem->meta_value;
                        }
                        if ($postmetaItem->meta_key == '_stock') {
                            if ($postmetaItem->meta_value == null) {
                                $Remians = 0;
                            } else {
                                $Remians = $postmetaItem->meta_value;
                            }
                        }
                        if ($postmetaItem->meta_key == '_ni_cost_goods') {
                            $BuyPrice = $postmetaItem->meta_value;
                        }
                        if ($postmetaItem->meta_key == '_enable_onsale') {
                            if ($postmetaItem->meta_value == 'on') {
                                $OnSale = 1;
                            } else {
                                $OnSale = 0;
                            }
                        }
                    }
                    $Discount = $BasePrice - $Price;

                    $WareHouseDate = [
                        'WarehouseID' => $WarehouseID,
                        'GoodID' => $product_id,
                        'QTY' => $Remians,
                        'BuyPrice' => $BuyPrice,
                        'MaxPrice' => 0,
                        'Price' => $Price,
                        'MinPrice' => 0,
                        'OnSale' => $OnSale,
                        'SaleLimit' => $Remians,
                        'Discount' => $Discount,
                        'AlertLimit' => 5,
                        'AlertFinish' => 1,
                        'InputDate' => now(),
                        'ActiveTime' => now(),
                        'Remian' => $Remians,
                        'BasePrice' => $BasePrice,
                    ];
                    warehouse_goods::create($WareHouseDate);
                    echo 'add Warehouse  ->' . $product_id . '<br>';
                } else { // todo update count and price 
                    if ($product_id > $start && $product_id < $end) {
                        $postmeta = myappenv::wordressDatabsePree . 'postmeta';
                        $Query = "SELECT * FROM $postmeta WHERE post_id = $product_id";
                        $postmeta = $this->DGKAR_Select($Query);
                        $postmeta = json_decode($postmeta);
                        $WarehouseID = 1;
                        $Discount = 0;
                        $OnSale = 0;
                        $BuyPrice = 0;
                        $Remians = 0;
                        $Price = 0;
                        $BasePrice = 0;
                        foreach ($postmeta as $postmetaItem) {
                            if ($postmetaItem->meta_key == '_regular_price') {
                                $BasePrice = $postmetaItem->meta_value;
                            }
                            if ($postmetaItem->meta_key == '_sale_price') {
                                $Price = $postmetaItem->meta_value;
                            }
                            if ($postmetaItem->meta_key == '_stock') {
                                if ($postmetaItem->meta_value == null) {
                                    $Remians = 0;
                                } else {
                                    $Remians = $postmetaItem->meta_value;
                                }
                            }
                            if ($postmetaItem->meta_key == '_ni_cost_goods') {
                                $BuyPrice = $postmetaItem->meta_value;
                            }
                            if ($postmetaItem->meta_key == '_enable_onsale') {
                                if ($postmetaItem->meta_value == 'on') {
                                    $OnSale = 1;
                                } else {
                                    $OnSale = 0;
                                }
                            }
                        }
                        $Discount = $BasePrice - $Price;

                        $WareHouseDate = [
                            'BuyPrice' => $BuyPrice,
                            'Price' => $Price,
                            'OnSale' => $OnSale,
                            'Discount' => $Discount,
                            'Remian' => $Remians,
                            'BasePrice' => $BasePrice
                        ];
                        warehouse_goods::where('id', $ExistProduct->id)->update($WareHouseDate);
                        echo 'update wharehouse => ' . $ExistProduct->id . '_' . $product_id . '<br>';
                    }
                }
                $UpdateField++;
            } else {
                $wc_product_meta_lookup = myappenv::wordressDatabsePree . 'wc_product_meta_lookup';
                $Query = "SELECT * FROM $wc_product_meta_lookup WHERE product_id = $product_id";
                $wc_product_meta_lookup = $this->DGKAR_Select($Query);
                $wc_product_meta_lookup = json_decode($wc_product_meta_lookup);
                if (isset($wc_product_meta_lookup[0])) {
                    $wc_product_meta_lookup = $wc_product_meta_lookup[0];
                    if ($wc_product_meta_lookup->stock_status == 'instock') {
                        $stock_status = 1;
                    } else {
                        $stock_status = 0;
                    }
                    if ($wc_product_meta_lookup->stock_quantity == null) {
                        $stock_quantity = 0;
                    } else {
                        $stock_quantity = $wc_product_meta_lookup->stock_quantity;
                    }
                    $updatedata = [
                        'id' => $product_id,
                        'NameFa' => $WpProduct->post_title,
                        'Description' => $WpProduct->post_title,
                        'MainDescription' => $WpProduct->post_content,
                        'SKU' => $wc_product_meta_lookup->sku,
                        'IRID' => $wc_product_meta_lookup->sku,
                        'IntID' => $wc_product_meta_lookup->sku,
                        'downloadable' => $wc_product_meta_lookup->downloadable,
                        'Virtual' => $wc_product_meta_lookup->virtual,
                        'onsale' => $wc_product_meta_lookup->onsale,
                        'Status' => 0,
                        'MinPrice' => $wc_product_meta_lookup->min_price,
                        'MaxPrice' => $wc_product_meta_lookup->max_price,
                        'average_rating' => $wc_product_meta_lookup->average_rating,
                        'total_sales' => $wc_product_meta_lookup->total_sales,
                        'stock_status' => $stock_status,
                        'stock_quantity' => $stock_quantity,
                        'rating_count' => $wc_product_meta_lookup->rating_count,
                        'ImgURL' => '',
                        'Unit' => 0,
                        'urladdress' => $WpProduct->post_name,
                        'weight' => 0
                    ];
                    goods::create($updatedata);
                    $this->addindex($product_id);
                    $AddedField++;
                }
            }
        }
        return "Addeddfeild: $AddedField / UpdateFeild = $UpdateField ";
    }

    public function DGKAR_Select($Query)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, myappenv::wordpressAddress);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt(
            $ch,
            CURLOPT_POSTFIELDS,
            "sql=$Query"
        );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        curl_close($ch);
        return ($server_output);
    }

    public function Topin_check_price($rate_type, $price, $weight, $pay_type, $to_province, $from_province,  $to_city, $from_city)
    {
        $ch = curl_init();
        if($weight == 0){
            $weight = 100;
        }
        curl_setopt($ch, CURLOPT_URL, "https://public.api.tapin.ir/api/v1/public/check-price/");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //$result = curl_exec($ch);
        curl_setopt(
            $ch,
            CURLOPT_POSTFIELDS,
            '{"rate_type":"' . $rate_type . '","price": "' . $price . '","weight": "' . $weight . '","order_type": "0","pay_type": "' . $pay_type . '","to_province": "' . $to_province . '","from_province": "' . $from_province . '","to_city": "' . $to_city . '","from_city": "' . $from_city . '"}'
        );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        curl_close($ch);
        $server_output = json_decode($server_output);
        $server_output = $server_output->entries;
        $server_output = $server_output->total;
        return ($server_output);
    }

    public function topin()
    {
        $Url = "https://public.api.tapin.ir/api/v1/public/state/tree/?format=json";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $Url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        curl_close($ch);
        $server_output = json_decode($server_output);
        $Conter = 1;
        $Pout = '';
        $Cout = '';
        foreach ($server_output->entries as $server_outputItem) {
            $MyProviceCode = $server_outputItem->code;
            $MyProviceName = $server_outputItem->title;
            // $provincesData = [
            //     'id' => $MyProviceCode,
            //     'Country' => 'IRI',
            //     'ProvinceName' => $MyProviceName
            // ];
            // provinces::create($provincesData);
            $Pdata = ",[
                'id' => $MyProviceCode,
                'Country' => 'IRI',
                'ProvinceName' => '$MyProviceName',
            ]";
            $Pout .= $Pdata;
            foreach ($server_outputItem->cities as $citie) {
                $CityCode = $citie->code;
                $CityName = $citie->title;
                // $CityData = [
                //     'id' => $CityCode,
                //     'province' => $MyProviceCode,
                //     'CityName' => $CityName
                // ];
                // citys::create($CityData);

                $Cdata = "<br>  
                ,['id'=>$CityCode,
                'province'=>$MyProviceCode,
                'CityName'=>'$CityName'
            ]";
                $Cout .= $Cdata;
            }

            //  dd($server_outputItem->code, $server_outputItem, $server_outputItem->cities);
        }
        echo $Pout;
        echo '<br>';
        echo $Cout;
        dd('sss');
    }
}

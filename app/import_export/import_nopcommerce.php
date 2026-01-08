<?php

namespace App\import_export;

use App\Models\goods;
use App\Models\warehouse;
use App\Models\warehouse_goods;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use SimpleXMLElement;

/**
 * change encoding to encoding="utf-8"
 * remove ,000
 */

class import_nopcommerce
{

    /*
            ProductId
            ProductTypeId
            ParentGroupedProductId
            Name
            ShortDescription
            FullDescription
            VendorId
            ProductTemplateId
            MetaKeywords
            MetaDescription
            MetaTitle
            SEName
            SKU
            ManufacturerPartNumber
            StockQuantity
            NotifyAdminForQuantityBelow
            Price
            OldPrice
            ProductCost
            Weight
            ProductDiscounts
            TierPrices
            ProductAttributes
            ProductPictures
            ProductCategories
            ProductManufacturers
            ProductSpecificationAttributes
            ProductTags

*/
    private $xml_location; // xml file location
    function __construct($xml_location)
    {
        $this->xml_location = $xml_location;
    }
    private function update_price_plan($price_plan_arr)
    {
        if (!isset($price_plan_arr->TierPrice)) {
            return null;
        }
        $PriceFormola = array();
        foreach ($price_plan_arr->TierPrice as $price_plan_item) {

            array_push($PriceFormola, ['ToNumber' => current($price_plan_item->Quantity), 'Price' => current($price_plan_item->Price)]);
        }
        $PriceFormola = json_encode($PriceFormola);
        return $PriceFormola;
    }


    public function update_existing_from_backup()
    {
        $backup_file = $this->read_from_file();
        if (!$backup_file['result']) {
            return [
                'result' => false,
                'msg' => $backup_file['msg']
            ];
        }
        $not_exist = '';
        $Product_src = $backup_file['data'];
        foreach ($Product_src as $product_item) {
            $GoodID = current($product_item->ProductId);
            $target_good_src = goods::where('id', $GoodID)->first();
            if ($target_good_src == null) {
                $not_exist .= "<p> GoodID => $GoodID is not exist <p/>";
                continue;
            }
            $PricePlan =  $this->update_price_plan($product_item->TierPrices);
            $QTY = current($product_item->StockQuantity);
            $QTY = (int)$QTY;
            $BuyPrice = current($product_item->ProductCost);
            $BasePrice = current($product_item->OldPrice);
            $Price = current($product_item->Price);
            if ($BasePrice == 0) {
                $BasePrice = $Price;
            }
            $Remian = current($product_item->StockQuantity);
            warehouse_goods::where('GoodID', $GoodID)->delete();
            if ($QTY > 0) {
                $wg_data = [
                    'WarehouseID' => 1,
                    'PricePlan' => $PricePlan,
                    'QTY' => $QTY,
                    'BuyPrice' => $BuyPrice,
                    'BasePrice' => $BasePrice,
                    'Price' => $Price,
                    'Remian' => $Remian,
                    'GoodID' => $GoodID,
                    'OnSale' => 1,
                    'SaleLimit' => 1,
                    'AlertLimit' => 1,
                    'AlertFinish' => 1,
                    'InputDate' => now(),
                    'MadeDate' => now(),
                    'ExpireDate' => now(),
                    'ActiveTime' => now(),
                    'DeactiveTime' => now(),
                    'MaxPrice' => 0,
                    'MinPrice' => 0,
                    'extra' => '',
                ];
                warehouse_goods::create($wg_data);
            }
        }
        return [
            'result' => true,
            'not_exist' => $not_exist
        ];
    }



    private function read_from_file()
    {
        $filePath = storage_path('app/public/files/products_sepehrmall.xml'); // Update with the actual path to your XML file

        if (File::exists($filePath)) {
            $xmlString = File::get($filePath);
            $xml = simplexml_load_string($xmlString);
            $Product_src = $xml->Product;
            return [
                'result' => true,
                'data' => $Product_src
            ];
            //-----------------------
            foreach ($Product_src as $product_item) {
                $good_data = [
                    'id' => $product_item->ProductId,
                    'SKU' => $product_item->SKU,
                    'NameFa' => $product_item->Name->Standard,
                    'NameEn' => $product_item->Name->Standard,
                    'Status' => 1,
                    'Unit' => 1,
                    'MainDescription' => $product_item->FullDescription->Standard,
                    'ImgURL' => '',
                    'IRC' => '',
                    'Description' => $product_item->ShortDescription->Standard,
                    'IntID' => $product_item->ManufacturerPartNumber
                ];

                goods::create($good_data);

                dd($product_item);
            }
        }
        return [
            'result' => false,
            'msg' => response()->json(['error' => 'XML file not found.'])
        ];
    }
}

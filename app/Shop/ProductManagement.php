<?php

namespace App\Shop;

use App\Models\goodindex;
use App\Models\goods;
use App\Models\warehouse_goods;

class ProductManagement
{
    private function duplicate_good($good_id)
    {
        $SourceProduct = goods::where('id', $good_id)->first();
        if ($SourceProduct == null) {
            return [
                'result' => false,
                'msg' => 'محصول مورد نظر موجود نیست'
            ];
        }
        $new_product = $SourceProduct->replicate();
        $new_product->NameFa = $new_product->NameFa . ' کپی ';
        $new_product->urladdress = $new_product->urladdress . 'copy';
        $result = $new_product->save();
        if ($result == false) {
            return [
                'result' => false,
                'msg' => 'محصول کپی نشد!'
            ];
        }
        return [
            'result' => true,
            'product_id' => $new_product->id
        ];
    }
    private function duplication_single_wg_item($wg_id, $new_good_id)
    {
        $wg_src = warehouse_goods::find($wg_id);
        $wg_new = $wg_src->replicate();
        $wg_new->GoodID = $new_good_id;
        return $wg_new->save();
    }
    private function duplicate_warehouse_good($old_good_id, $new_good_id)
    {
        $old_warehouse_good_source = warehouse_goods::where('GoodID', $old_good_id)->get();
        foreach ($old_warehouse_good_source as $old_warehouse_good_item) {
            $this->duplication_single_wg_item($old_warehouse_good_item->id, $new_good_id);
        }
        return true;
    }
    private function duplicate_good_index($old_good_id, $new_good_id)
    {
        $old_index_src = goodindex::where('GoodID', $old_good_id)->get();
        foreach ($old_index_src as $old_index_item) {
            $index_id = $old_index_item->id;
            $old_index = goodindex::find($index_id);
            $new_index = $old_index->replicate();
            $new_index->GoodID = $new_good_id;
            $new_index->save();
        }

    }
    public function make_double($product_id)
    {
        $duplicate_good_result = $this->duplicate_good($product_id);
        if (!$duplicate_good_result['result']) {
            return $duplicate_good_result;
        }
        $new_product_id = $duplicate_good_result['product_id'];
        $this->duplicate_warehouse_good($product_id, $new_product_id);
        $this->duplicate_good_index($product_id, $new_product_id);
        return [
            'result' => true,
            'product_id' => $new_product_id
        ];
    }
}
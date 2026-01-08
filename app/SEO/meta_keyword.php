<?php

namespace App\SEO;

use App\Models\ItemIndex;
use App\Models\L3Work;
use App\myappenv;
use Illuminate\Support\Facades\DB;

class meta_keyword
{
    private function add_tag_to_l3(string $tag_name)
    {
        $L3Data = [
            'WorkCat' => myappenv::PostIndexWorkCat,
            'L1ID' => myappenv::NewsIndexL1,
            'L2ID' => myappenv::NewsIndexL2,
            'L3ID' => myappenv::NewsIndexL2,
            'Name' => $tag_name,
            'Description' => '',
            'img' => ''
        ];
        $TargetL3work = L3Work::create($L3Data);
        $TargetL3work = $TargetL3work->id;
        return $TargetL3work;
    }
    private function add_item_index($item_id, $item_type, $TargetL3work)
    {
        $ItemIndexData = [
            'PostId' => $item_id,
            'Type' => $item_type,
            'Status' => 1,
            'IndexID' => $TargetL3work
        ];
        ItemIndex::create($ItemIndexData);
    }
    private function delete_existing_index($item_id, $item_type)
    {
        ItemIndex::where('PostId', $item_id)->where('Type', $item_type)->delete();
        return true;
    }
    public function add_meta_keyword_to_item(array $meta_list, $item_id, $item_type)
    {
        $this->delete_existing_index($item_id, $item_type);
        foreach ($meta_list as $SelectTag) {
            $TagResult = L3Work::where('Name', $SelectTag)->where('WorkCat', myappenv::PostIndexWorkCat)->where('L1ID', myappenv::NewsIndexL1)->where('L2ID', myappenv::NewsIndexL2)->first();
            if ($TagResult == null) {
                $TargetL3work = $this->add_tag_to_l3($SelectTag);
                $this->add_item_index($item_id, $item_type, $TargetL3work); // add new index to index item
                continue;
            }
            $TargetL3work = $TagResult->UID;
            $this->add_item_index($item_id, $item_type, $TargetL3work); // add new index to index item
            continue;
        }

    }
    public function get_all_tags(){
        $WorkCat = myappenv::PostIndexWorkCat;
        $L1ID = myappenv::NewsIndexL1;
        $L2ID = myappenv::NewsIndexL2;
        $Tags = L3Work::all()->where('WorkCat', $WorkCat)->where('L1ID', $L1ID)->where('L2ID', $L2ID);
        return $Tags;
    }
    public function get_item_tags($item_id, $item_type)
    {
        $WorkCat = myappenv::PostIndexWorkCat;
        $L1ID = myappenv::NewsIndexL1;
        $L2ID = myappenv::NewsIndexL2;
        $L1IDCat = myappenv::NewsCatL1;
        $L2IDCat = myappenv::NewsCatL2;
        $Query = "SELECT * FROM L3Work LEFT JOIN item_index on item_index.IndexID = L3Work.UID and item_index.Type = $item_type
        WHERE (item_index.PostId = $item_id or item_index.PostId is null) 
        and WorkCat = $WorkCat and L1ID = $L1ID and L2ID = $L2ID ";
        $Tags = DB::select($Query);
        return $Tags;
    }

}
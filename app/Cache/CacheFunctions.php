<?php

namespace App\Cache;

use App\Functions\Indexes;
use App\Models\goodindex;
use App\Models\L2Work;
use App\Models\L3Work;
use Illuminate\Support\Facades\DB;

class CacheFunctions
{
    private function Theme6_top_menu()
    {
        $menu = Indexes::get_index_id();
        if(!isset($menu->WorkCat)){
            return '';
        }
        $Query = "select * from L2Work where WorkCat = $menu->WorkCat and  L1ID = $menu->L1ID";
        $matas = DB::select($Query);
       // $matas = L2Work::where('WorkCat', $menu->WorkCat)->where('L1ID', $menu->L1ID)->get();
        $html = '<ul>';
        foreach($matas as $meta_item){
            if($html != '<ul>'){
                 $html .= '</ul></li>';
            }
            $route = route('ProductCats', ['TargetLayer' => $meta_item->L2ID]);
            $html .= '<li><a href="' . $route . '">' . $meta_item->Name . '</a> <ul class="row">';
            $Cats = L3Work::where('WorkCat', $menu->WorkCat)->where('L1ID', $menu->L1ID)->where('L2ID', $meta_item->L2ID)->orderBy('L3ID')->get();
            foreach($Cats  as $Cat_item){
                $product_count = goodindex::where('IndexID',$Cat_item->UID)->count();
                $route = route('ShowProduct',['Tags'=>$Cat_item->UID,'TagName'=>$Cat_item->Name]);
                $html .= '<li  class="sublist--title"><a href="'.$route.'">' ;
                $html .= $Cat_item->Name . " ($product_count)";
                $html .= '</a></li>';
            }
        }

        return $html . '</ul></li></ul>';
    }

    public function main($cache_function)
    {
        switch ($cache_function) {
            case 'Theme6_top_menu':
                return $this->Theme6_top_menu();

            default:
                return null;
        }

    }
}

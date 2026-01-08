<?php

namespace App\Http\Controllers\Themes;

use App\branchenv;
use App\Functions\Themes;
use App\Http\Controllers\Controller;
use App\Models\mobile_banner;
use Illuminate\Http\Request;
/* 
Thems:
1: Banners Items
2: Icon Item
3: Icon Box
4: single Posters
5: Titr
6: SmallPic
7: ArticlePic
8: SinglePic
9: IndexList
10: Horizental List
11: 4X Posters
12: scroll posters
13: show post in pwa
14: layer2 index
15: BoxIcon 3x
100: -wolmart- firstpage sliders 
101: -wolmart- text box pannel payment methods 
102: -wolmart- 2 side banner 
103: -wolmart- product list page top banner  
104: -wolmart- single Product right ads banner  
105: -wolmart- Condition state 

200 - 300 for new approach

201: main Slider
202: Vertical Product List
203: Tags show
204: Brands Show


501: main slider
502: main slider mobile
503: pics side slider
505: single banner

601: main slider



*/

class ThemeMgt extends Controller
{
    public function ThemeMgt()
    {
        $Themes = new Themes();
        $TatgetTheme = $Themes->get_theme();
        return view('Theme.ThemeMgt_' . $TatgetTheme);
    }

    public function DoThemeMgt()
    {
    }
    public function ThemeObjectMgt($Theme)
    {
        $branch_src = branchenv::get_branch();
        $branch_id = $branch_src['CenterID'];
        $elements = mobile_banner::all()->where('theme', $Theme)->where('status', '!=', 100)->where('branch',$branch_id);
        $Themes = new Themes();
        $Themes->set_object_id($Theme);
        return view('Theme.ThemeObjectMgt', ['elements' => $elements, 'Themes' => $Themes]);
    }
    public function DoThemeObjectMgt($Theme, Request $request)
    {
        $branch_src = branchenv::get_branch();
        $branch_id = $branch_src['CenterID'];
        $MyTheme = new Themes;
        $MyTheme->DataShaping($request->input(),$Theme);
        if ($request->input('submit') == 'add') {
            $InputData = [
                'page' => $MyTheme->get_page() ,
                'order' => $MyTheme->get_order() ,
                'theme' => $MyTheme->get_Object_id() ,
                'title' => $MyTheme->get_title() ,
                'pic' => $MyTheme->get_pic() ,
                'status' => $MyTheme->get_status() ,
                'link' => $MyTheme->get_link() ,
                'linkMeta' => $MyTheme->get_linkmeta(),
                'branch'=>$branch_id,
            ];
            mobile_banner::create($InputData);
            return redirect()->back()->with('success', __("Transaction done!"));
        } elseif ($request->input('submit') == 'edit') {
            $MyTheme = new Themes;
            $MyTheme->DataShaping($request->input(),$Theme);
            $tableid = $request->input("tableid");
            $InputData = [
                'page' => $MyTheme->get_page() ,
                'order' => $MyTheme->get_order() ,
                'title' => $MyTheme->get_title() ,
                'pic' => $MyTheme->get_pic() ,
                'status' => $MyTheme->get_status() ,
                'link' => $MyTheme->get_link() ,
                'linkMeta' => $MyTheme->get_linkmeta(),
                'branch'=>$branch_id
            ];
            mobile_banner::where('id', $tableid)->update($InputData);
            return redirect()->back()->with('success', __("Transaction done!"));
        } elseif ($request->input('submit') == 'delete') {
            $tableid = $request->input("tableid");
            $InputData = [
                'status' => 100,
            ];
            mobile_banner::where('id', $tableid)->update($InputData);
            return redirect()->back()->with('success', __("Transaction done!"));
        }
    }
    
}

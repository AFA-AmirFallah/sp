<?php

namespace App\Http\Controllers\WPA_admin;

use App\branchenv;
use App\Http\Controllers\Controller;
use App\Models\branches;
use App\Models\html_object;
use App\Models\L1Work;
use App\Models\L2Work;
use App\Models\L3Work;
use App\Models\mobile_banner;
use App\Models\posts;
use App\Models\UserRole;
use App\Models\WorkCat;
use App\myappenv;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

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
*/

class banners extends Controller
{
    public const BannerItems = [
        '1' => 'آیتم های بنر ',
        '2' => 'آیکون ها',
        '3' => 'آیکون باکس',
        '4' => 'پستر تکی',
        '5' => 'تیتر',
        '6' => 'عکس کوچک',
        '7' => 'عکس مقاله ای',
        '8' => 'عکس تکی',
        '9' => 'لیست شاخص',
        '10' => 'لیست افقی',
        '11' => 'عکس چهار تایی',
        '12' => 'پستر اسکرول',
        '13' => 'پست',
        '14' => 'دسته بندی لایه ۲',
        '15' => 'باکس ایکون ۳ تایی',
        '100' => 'اسلایدر سایت',
        '101' => 'روشهای پرداخت سایت',
        '102' => 'اسلایدر دوتایی سایت',
        '103' => 'لیست محصولات سایت',
        '104' => 'تبلیغ سمت راست سایت',
        '105' => 'شرایط سایت',
    ];


    public function BoxIcon3x()
    {
        $elements = mobile_banner::all()->where('theme', 15)->where('status', '!=', 100);
        return view('WPA_admin.IconBox3x', ['elements' => $elements]);
    }
    public function DoBoxIcon3x(Request $request)
    {

        if ($request->input('submit') == 'add') {
            $request->validate([
                'order' => 'required',
                'staus' => 'required',
            ], [
                'order.required' => 'پر کردن فیلد ترتیب الزامی میباشد!',
                'staus.required' => 'مشخص کردن فیلد وضعیت الزامی میباشد!',
            ]);
            $order = $request->input('order');
            $title = $request->input('title');
            $pic = [
                'pic1' => $request->input('pic1'),
                'link1' => $request->input('link1'),
                'txt1' => $request->input('text1'),
                'color1' => $request->input('color1'),
                'pic2' => $request->input('pic2'),
                'link2' => $request->input('link2'),
                'txt2' => $request->input('text2'),
                'color2' => $request->input('color2'),
                'pic3' => $request->input('pic3'),
                'link3' => $request->input('link3'),
                'txt3' => $request->input('text3'),
                'color3' => $request->input('color3'),
            ];
            $pic = json_encode($pic);
            $staus = $request->input('staus');
            $link = '#';
            $Page = $request->input('Page');
            $InputData = [
                'page' => $Page,
                'order' => $order,
                'theme' => 15,
                'title' => $title,
                'pic' => $pic,
                'status' => $staus,
                'link' => $link,
                'linkMeta' => 0
            ];
            mobile_banner::create($InputData);
            return redirect()->back()->with('success', __("Transaction done!"));
        } elseif ($request->input('submit') == 'edit') {
            $request->validate([
                'order' => 'required',
                'staus' => 'required',
            ]);
            $tableid = $request->input("tableid");
            $order = $request->input("order");
            $title = $request->input("title");
            $pic = [
                'pic1' => $request->input('pic1'),
                'link1' => $request->input('link1'),
                'txt1' => $request->input('text1'),
                'color1' => $request->input('color1'),
                'pic2' => $request->input('pic2'),
                'link2' => $request->input('link2'),
                'txt2' => $request->input('text2'),
                'color2' => $request->input('color2'),
                'pic3' => $request->input('pic3'),
                'link3' => $request->input('link3'),
                'txt3' => $request->input('text3'),
                'color3' => $request->input('color3'),
            ];
            $pic = json_encode($pic);
            $staus = $request->input("staus");
            $link = $request->input("link");
            $Page = $request->input('Page');
            $InputData = [
                'page' => $Page,
                'order' => $order,
                'title' => $title,
                'pic' => $pic,
                'status' => $staus,
                'link' => $link,
                'linkMeta' => 0
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
    public function Layer2Index()
    {
        $elements = mobile_banner::all()->where('theme', 14)->where('status', '!=', 100);
        return view('WPA_admin. Layer2Index', ['elements' => $elements]);
    }
    public function DoLayer2Index(Request $request)
    {
        if ($request->input('submit') == 'add') {
            $request->validate([
                'order' => 'required',
                'staus' => 'required',
            ], [
                'order.required' => 'پر کردن فیلد ترتیب الزامی میباشد!',
                'staus.required' => 'مشخص کردن فیلد وضعیت الزامی میباشد!',
            ]);
            $order = $request->input('order');
            $title = $request->input('title');
            $pic = $request->input('pic');
            $staus = $request->input('staus');
            $link = $request->input('link');
            $Page = $request->input('Page');
            $InputData = [
                'page' => $Page,
                'order' => $order,
                'theme' => 14,
                'title' => $title,
                'pic' => $pic,
                'status' => $staus,
                'link' => $link,
                'linkMeta' => 0
            ];
            mobile_banner::create($InputData);
            return redirect()->back()->with('success', __("Transaction done!"));
        } elseif ($request->input('submit') == 'edit') {
            $request->validate([
                'order' => 'required',
                'staus' => 'required',
            ]);
            $tableid = $request->input("tableid");
            $order = $request->input("order");
            $title = $request->input("title");
            $pic = $request->input("pic");
            $staus = $request->input("staus");
            $link = $request->input("link");
            $Page = $request->input('Page');
            $InputData = [
                'page' => $Page,
                'order' => $order,
                'title' => $title,
                'pic' => $pic,
                'status' => $staus,
                'link' => $link,
                'linkMeta' => 0
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
    public function PwaPostManagement()
    {
        $elements = mobile_banner::all()->where('theme', 13)->where('status', '!=', 100);
        return view('WPA_admin.PostManagement', ['elements' => $elements]);
    }
    public function DoPwaPostManagement(Request $request)
    {
        if ($request->input('submit') == 'add') {
            $request->validate([
                'order' => 'required',
                'staus' => 'required',
            ], [
                'order.required' => 'پر کردن فیلد ترتیب الزامی میباشد!',
                'staus.required' => 'مشخص کردن فیلد وضعیت الزامی میباشد!',
            ]);
            $order = $request->input('order');
            $title = $request->input('title');
            $pic = $request->input('pic');
            $staus = $request->input('staus');
            $link = $request->input('link');
            $Page = $request->input('Page');
            $InputData = [
                'page' => $Page,
                'order' => $order,
                'theme' => 13,
                'title' => $title,
                'pic' => $pic,
                'status' => $staus,
                'link' => $link,
                'linkMeta' => 0
            ];
            mobile_banner::create($InputData);
            return redirect()->back()->with('success', __("Transaction done!"));
        } elseif ($request->input('submit') == 'edit') {
            $request->validate([
                'order' => 'required',
                'staus' => 'required',
            ]);
            $tableid = $request->input("tableid");
            $order = $request->input("order");
            $title = $request->input("title");
            $pic = $request->input("pic");
            $staus = $request->input("staus");
            $link = $request->input("link");
            $Page = $request->input('Page');
            $InputData = [
                'page' => $Page,
                'order' => $order,
                'title' => $title,
                'pic' => $pic,
                'status' => $staus,
                'link' => $link,
                'linkMeta' => 0
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
    public static function GetPost($PostId)
    {
        return posts::where('id', $PostId)->first();
    }
    public static function gethtml($objectName)
    {
        $object = html_object::where('htmlname', $objectName)->first();
        if ($object != null) {
            return $object->htmlobj;
        } else {
            return null;
        }
    }
    private function check_Name_is_exist_in_htmlObj($ObjectName)
    {
        if (branchenv::is_multi_branch()) {
            $branch_src = \App\branchenv::get_branch();
            $Result = html_object::where('htmlname', $ObjectName)->where('branch', $branch_src['CenterID'])->first();

        } else {
            $Result = html_object::where('htmlname', $ObjectName)->first();

        }
        if ($Result == null) {
            return 0;
        } else {
            return $Result->id;
        }
    }



    public function HtmlObj($Cat = null)
    {

        if ($Cat == null) {
            if (myappenv::Lic['MultiBranch']) {
                $query = "SELECT ho.* , b.Name as branch_name from html_objects ho  inner join branches b  on ho.branch = b.id ";
                $html_object = DB::select($query);
            } else {
                $html_object = html_object::all();
            }
            $branches = branches::all();

            return view('WPA_admin.HtmlObjList', ['html_object' => $html_object, 'branches' => $branches]);
        } elseif ($Cat == 'add') {
            $html_object = null;
            $branches = branches::all();
            return view('news.ManageHTMLObj', ['html_object' => $html_object, 'branches' => $branches]);
        } else {
            if (is_numeric($Cat)) {
                $html_object = html_object::where('id', $Cat)->first();
                $branches = branches::all();
                return view('news.ManageHTMLObj', ['html_object' => $html_object, 'branches' => $branches]);
            } else {
                $CheckResult = $this->check_Name_is_exist_in_htmlObj($Cat);
                if ($CheckResult == 0) {
                    $Defultaddress = myappenv::SiteTheme . '/Defults/' . $Cat . '.txt';
                    $myfile = fopen($Defultaddress, "r") or die("Unable to open file!");
                    $HtmlContent = fread($myfile, filesize($Defultaddress));
                    fclose($myfile);
                    $HtmlMenuData = [
                        'htmlname' => $Cat,
                        'htmlobj' => $HtmlContent
                    ];
                    if (branchenv::is_multi_branch()) {
                        $branch_src = \App\branchenv::get_branch();
                        $HtmlMenuData['branch'] = $branch_src['CenterID'];
                    }
                    $result = html_object::create($HtmlMenuData);
                    Cache::put($Cat, $HtmlContent);
                    return redirect()->route('HtmlObj', ['Cat' => $result->id]);
                } else {
                    return redirect()->route('HtmlObj', ['Cat' => $CheckResult]);
                }
            }
        }
    }
    public function DoHtmlObj(Request $request, $Cat = null)
    {
        if ($request->input('submit') == 'addhtml') {
            $HtmlMenuData = [
                'htmlname' => $request->input('htmlname'),
                'htmlobj' => $request->input('myobject'),
                'branch' => $request->branch
            ];
            html_object::create($HtmlMenuData);
            if ($request->branch == myappenv::Branch) {
                Cache::put($request->input('htmlname'), $request->input('myobject'));
            }
            return redirect()->back()->with('success', 'المان مورد نظر به سیستم اضافه شد');
        } elseif ($request->has('delete')) {
            html_object::where('id', $request->input('delete'))->delete();
            if ($request->branch == myappenv::Branch) {
                Cache::forget($request->input('htmlname'));
            }

            return redirect()->back()->with('success', 'المان مورد نظر حذف شد');
        } elseif ($request->input('submit') == 'update') {
            $HtmlMenuData = [
                'htmlname' => $request->input('htmlname'),
                'htmlobj' => $request->input('myobject'),
                'branch' => $request->branch
            ];
            html_object::where('id', $Cat)->update($HtmlMenuData);
            if ($request->branch == myappenv::Branch) {
                Cache::put($request->input('htmlname'), $request->input('myobject'));
            }
            return redirect()->back()->with('success', 'المان مورد نظر ویرایش  شد');
        } elseif ($request->input('submit') == 'add_with_new_branch') {
            $exist_item = html_object::where('htmlname', $request->htmlname)->where('branch', $request->branch)->first();
            if ($exist_item != null) {
                return redirect()->back()->with('error', 'المان مورد نظر در شعبه وجود دارد');
            }
            $HtmlMenuData = [
                'htmlname' => $request->input('htmlname'),
                'htmlobj' => $request->input('myobject'),
                'branch' => $request->branch
            ];
            html_object::create($HtmlMenuData);
            return redirect()->back()->with('success', 'المان مورد نظر  اضافه  شد');
        }
    }
    public function ElementEditThemeMaker($ElementID)
    {
        $WorkCats = WorkCat::all();
        $L1Works = L1Work::all();
        $L2Works = L2Work::all();
        $L3Works = L3Work::all();
        $UserLevel = UserRole::all();
        $BannerSrc = mobile_banner::where('id', $ElementID)->first();
        if ($BannerSrc == null) {
            return abort('404', 'المان مورد درخواست وجود ندارد!');
        }
        return view('WPA_admin.EditElementTheme', ['BannerSrc' => $BannerSrc, 'WorkCats' => $WorkCats, 'L1Works' => $L1Works, 'L2Works' => $L2Works, 'L3Works' => $L3Works, 'UserLevel' => $UserLevel]);
    }
    public function DoElementEditThemeMaker($ElementID, Request $request)
    {
        $request->validate([
            'order' => 'required',
            'staus' => 'required',
        ], [
            'order.required' => 'پر کردن فیلد ترتیب الزامی میباشد!',
            'staus.required' => 'مشخص کردن فیلد وضعیت الزامی میباشد!',
        ]);
        $order = $request->input('order');
        $title = $request->input('title');
        if ($request->input('pic') != null) {
            $pic = $request->input('pic');
        } else {
            $pic = '';
        }

        $staus = $request->input('staus');
        $link = '';
        $Page = $request->input('Page');
        $InputData = [
            'page' => $Page,
            'order' => $order,
            'theme' => $request->input('theme'),
            'title' => $title,
            'pic' => $pic,
            'status' => $staus,
            'link' => $link,
            'linkMeta' => 0,
            'content' => $request->input('ce'),
            'UserRole' => $request->input('UserRole')
        ];
        mobile_banner::where('id', $ElementID)->update($InputData);
        return redirect()->back()->with('success', __("Transaction done!"));
    }
    public function ElementThemeMaker()
    {
        $WorkCats = WorkCat::all();
        $L1Works = L1Work::all();
        $L2Works = L2Work::all();
        $L3Works = L3Work::all();
        $UserLevel = UserRole::all();
        return view('WPA_admin.AddElementTheme', ['WorkCats' => $WorkCats, 'L1Works' => $L1Works, 'L2Works' => $L2Works, 'L3Works' => $L3Works, 'UserLevel' => $UserLevel]);
    }
    public function DoElementThemeMaker(Request $request)
    {
        $request->validate([
            'order' => 'required',
            'staus' => 'required',
        ], [
            'order.required' => 'پر کردن فیلد ترتیب الزامی میباشد!',
            'staus.required' => 'مشخص کردن فیلد وضعیت الزامی میباشد!',
        ]);
        $order = $request->input('order');
        $title = $request->input('title');
        if ($request->input('pic') == null) {
            $pic = '';
        } else {
            $pic = $request->input('pic');
        }

        $staus = $request->input('staus');
        $link = '';
        $Page = $request->input('Page');
        $InputData = [
            'page' => $Page,
            'order' => $order,
            'theme' => $request->input('theme'),
            'title' => $title,
            'pic' => $pic,
            'status' => $staus,
            'link' => $link,
            'linkMeta' => 0,
            'content' => $request->input('ce'),
            'UserRole' => $request->input('UserRole')
        ];
        mobile_banner::create($InputData);
        return redirect()->route('ThemeMaker')->with('success', __("Transaction done!"));
    }
    public function ThemeMaker()
    {
        $WorkCats = WorkCat::all();
        $L1Works = L1Work::all();
        $L2Works = L2Work::all();
        $L3Works = L3Work::all();
        $elements = mobile_banner::all()->where('status', '!=', 100)->where('status', 1);
        return view('WPA_admin.ThemeMaker', ['WorkCats' => $WorkCats, 'L1Works' => $L1Works, 'L2Works' => $L2Works, 'L3Works' => $L3Works, 'elements' => $elements]);
    }
    public function DoThemeMaker(Request $request)
    {
        if ($request->input('submit') == 'edit') {
            $request->validate([
                'order' => 'required',
                'staus' => 'required',
            ]);
            $tableid = $request->input("tableid");
            $order = $request->input("order");
            $title = $request->input("title");
            $staus = $request->input("staus");
            $Page = $request->input('Page');
            $InputData = [
                'page' => $Page,
                'order' => $order,
                'status' => $staus,
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
    public function IndexListManagementAdvnace()
    {
        $WorkCats = WorkCat::all();
        $L1Works = L1Work::all();
        $L2Works = L2Work::all();
        $L3Works = L3Work::all();

        $elements = mobile_banner::all()->where('theme', 10)->where('status', '!=', 100);
        return view('WPA_admin.IndexListManagementAdvance', ['WorkCats' => $WorkCats, 'L1Works' => $L1Works, 'L2Works' => $L2Works, 'L3Works' => $L3Works, 'elements' => $elements]);
    }
    public function DoIndexListManagementAdvnace(Request $request)
    {
        if ($request->input('submit') == 'add') {
            $request->validate([
                'order' => 'required',
                'staus' => 'required',
            ], [
                'order.required' => 'پر کردن فیلد ترتیب الزامی میباشد!',
                'staus.required' => 'مشخص کردن فیلد وضعیت الزامی میباشد!',
            ]);
            $order = $request->input('order');
            $title = [
                'Title' => $request->input('title'),
                'TagUID' => $request->input('TagUID'),
                'Limit' => $request->input('Limit'),
                'Backcolor' => $request->input('Backcolor')
            ];
            $title = json_encode($title);
            $pic = '';
            $staus = $request->input('staus');
            $link = '';
            $Page = $request->input('Page');
            $InputData = [
                'page' => $Page,
                'order' => $order,
                'theme' => 10,
                'title' => $title,
                'pic' => $pic,
                'status' => $staus,
                'link' => $link,
                'linkMeta' => 0
            ];
            mobile_banner::create($InputData);
            return redirect()->back()->with('success', __("Transaction done!"));
        } elseif ($request->input('submit') == 'edit') {
            $request->validate([
                'order' => 'required',
                'staus' => 'required',
            ]);
            $tableid = $request->input("tableid");
            $order = $request->input("order");
            $title = [
                'Title' => $request->input('title'),
                'TagUID' => $request->input('TagUID'),
                'Limit' => $request->input('Limit'),
                'Backcolor' => $request->input('Backcolor')
            ];
            $title = json_encode($title);
            $staus = $request->input("staus");
            $Page = $request->input('Page');
            $InputData = [
                'page' => $Page,
                'order' => $order,
                'title' => $title,
                'status' => $staus,
                'linkMeta' => 0
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
    public function IndexListManagement()
    {
        $elements = mobile_banner::all()->where('theme', 9)->where('status', '!=', 100);
        return view('WPA_admin.IndexListManagement', ['elements' => $elements]);
    }
    public function DoIndexListManagement(Request $request)
    {
        if ($request->input('submit') == 'add') {
            $request->validate([
                'order' => 'required',
                'staus' => 'required',
            ], [
                'order.required' => 'پر کردن فیلد ترتیب الزامی میباشد!',
                'staus.required' => 'مشخص کردن فیلد وضعیت الزامی میباشد!',
            ]);
            $order = $request->input('order');
            $title = $request->input('title');
            $pic = '';
            $staus = $request->input('staus');
            $link = '';
            $Page = $request->input('Page');
            $InputData = [
                'page' => $Page,
                'order' => $order,
                'theme' => 9,
                'title' => $title,
                'pic' => $pic,
                'status' => $staus,
                'link' => $link,
                'linkMeta' => 0
            ];
            mobile_banner::create($InputData);
            return redirect()->back()->with('success', __("Transaction done!"));
        } elseif ($request->input('submit') == 'edit') {
            $request->validate([
                'order' => 'required',
                'staus' => 'required',
            ]);
            $tableid = $request->input("tableid");
            $order = $request->input("order");
            $title = $request->input("title");
            $staus = $request->input("staus");
            $Page = $request->input('Page');
            $InputData = [
                'page' => $Page,
                'order' => $order,
                'title' => $title,
                'status' => $staus,
                'linkMeta' => 0
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
    public function SinglePicManagement()
    {
        $elements = mobile_banner::all()->where('theme', 8)->where('status', '!=', 100);
        return view('WPA_admin.SinglePicManagement', ['elements' => $elements]);
    }
    public function DoSinglePicManagement(Request $request)
    {
        if ($request->input('submit') == 'add') {
            $request->validate([
                'order' => 'required',
                'staus' => 'required',
            ], [
                'order.required' => 'پر کردن فیلد ترتیب الزامی میباشد!',
                'staus.required' => 'مشخص کردن فیلد وضعیت الزامی میباشد!',
            ]);
            $order = $request->input('order');
            $title = $request->input('title');
            $pic = $request->input('pic');
            $staus = $request->input('staus');
            $link = $request->input('link');
            $Page = $request->input('Page');
            $InputData = [
                'page' => $Page,
                'order' => $order,
                'theme' => 8,
                'title' => $title,
                'pic' => $pic,
                'status' => $staus,
                'link' => $link,
                'linkMeta' => 0
            ];
            mobile_banner::create($InputData);
            return redirect()->back()->with('success', __("Transaction done!"));
        } elseif ($request->input('submit') == 'edit') {
            $request->validate([
                'order' => 'required',
                'staus' => 'required',
            ]);
            $tableid = $request->input("tableid");
            $order = $request->input("order");
            $title = $request->input("title");
            $pic = $request->input("pic");
            $staus = $request->input("staus");
            $link = $request->input("link");
            $Page = $request->input('Page');
            $InputData = [
                'page' => $Page,
                'order' => $order,
                'title' => $title,
                'pic' => $pic,
                'status' => $staus,
                'link' => $link,
                'linkMeta' => 0
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
    public function ArticlePicManagement()
    {
        $elements = mobile_banner::all()->where('theme', 7)->where('status', '!=', 100);
        return view('WPA_admin.ArticlePicManagement', ['elements' => $elements]);
    }
    public function DoArticlePicManagement(Request $request)
    {
        if ($request->input('submit') == 'add') {
            $request->validate([
                'order' => 'required',
                'staus' => 'required',
            ], [
                'order.required' => 'پر کردن فیلد ترتیب الزامی میباشد!',
                'staus.required' => 'مشخص کردن فیلد وضعیت الزامی میباشد!',
            ]);
            $order = $request->input('order');
            $title = $request->input('title');
            $pic = $request->input('pic');
            $staus = $request->input('staus');
            $link = $request->input('link');
            $Page = $request->input('Page');
            $InputData = [
                'page' => $Page,
                'order' => $order,
                'theme' => 7,
                'title' => $title,
                'pic' => $pic,
                'status' => $staus,
                'link' => $link,
                'linkMeta' => 0
            ];
            mobile_banner::create($InputData);
            return redirect()->back()->with('success', __("Transaction done!"));
        } elseif ($request->input('submit') == 'edit') {
            $request->validate([
                'order' => 'required',
                'staus' => 'required',
            ]);
            $tableid = $request->input("tableid");
            $order = $request->input("order");
            $title = $request->input("title");
            $pic = $request->input("pic");
            $staus = $request->input("staus");
            $link = $request->input("link");
            $Page = $request->input('Page');
            $InputData = [
                'page' => $Page,
                'order' => $order,
                'title' => $title,
                'pic' => $pic,
                'status' => $staus,
                'link' => $link,
                'linkMeta' => 0
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
    public function SmallPicManagement()
    {
        $elements = mobile_banner::all()->where('theme', 6)->where('status', '!=', 100);
        return view('WPA_admin.SmallPicManagement', ['elements' => $elements]);
    }
    public function DoSmallPicManagement(Request $request)
    {
        if ($request->input('submit') == 'add') {
            $request->validate([
                'order' => 'required',
                'staus' => 'required',
            ], [
                'order.required' => 'پر کردن فیلد ترتیب الزامی میباشد!',
                'staus.required' => 'مشخص کردن فیلد وضعیت الزامی میباشد!',
            ]);
            $order = $request->input('order');
            $title = $request->input('title');
            $pic = $request->input('pic');
            $staus = $request->input('staus');
            $link = $request->input('link');
            $Page = $request->input('Page');
            $InputData = [
                'page' => $Page,
                'order' => $order,
                'theme' => 6,
                'title' => $title,
                'pic' => $pic,
                'status' => $staus,
                'link' => $link,
                'linkMeta' => 0
            ];
            mobile_banner::create($InputData);
            return redirect()->back()->with('success', __("Transaction done!"));
        } elseif ($request->input('submit') == 'edit') {
            $request->validate([
                'order' => 'required',
                'staus' => 'required',
            ]);
            $tableid = $request->input("tableid");
            $order = $request->input("order");
            $title = $request->input("title");
            $pic = $request->input("pic");
            $staus = $request->input("staus");
            $link = $request->input("link");
            $Page = $request->input('Page');
            $InputData = [
                'page' => $Page,
                'order' => $order,
                'title' => $title,
                'pic' => $pic,
                'status' => $staus,
                'link' => $link,
                'linkMeta' => 0
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
    public function TitrManagement()
    {
        $elements = mobile_banner::all()->where('theme', 5)->where('status', '!=', 100);
        return view('WPA_admin.PageTitrManagement', ['elements' => $elements]);
    }
    public function DoTitrManagement(Request $request)
    {
        if ($request->input('submit') == 'add') {
            $request->validate([
                'staus' => 'required',
            ], [
                'staus.required' => 'مشخص کردن فیلد وضعیت الزامی میباشد!',
            ]);
            $order = '1';
            $title = $request->input('title');
            $pic = '';
            $staus = $request->input('staus');
            $link = '';
            $Page = $request->input('Page');
            $InputData = [
                'page' => $Page,
                'order' => $order,
                'theme' => 5,
                'title' => $title,
                'pic' => $pic,
                'status' => $staus,
                'link' => $link,
                'linkMeta' => 0
            ];
            mobile_banner::create($InputData);
            return redirect()->back()->with('success', __("Transaction done!"));
        } elseif ($request->input('submit') == 'edit') {
            $request->validate([
                'staus' => 'required',
            ]);
            $tableid = $request->input("tableid");
            $order = 1;
            $title = $request->input("title");
            $pic = '';
            $staus = $request->input("staus");
            $link = '';
            $Page = $request->input('Page');
            $InputData = [
                'page' => $Page,
                'order' => $order,
                'title' => $title,
                'pic' => $pic,
                'status' => $staus,
                'link' => $link,
                'linkMeta' => 0
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
    public function PosterManagementscroll()
    {
        $elements = mobile_banner::all()->where('theme', 12)->where('status', '!=', 100);
        return view('WPA_admin.PosterManagementScroll', ['elements' => $elements]);
    }
    public function DoPosterManagementscroll(Request $request)
    {
        if ($request->input('submit') == 'add') {
            $request->validate([
                'order' => 'required',
                'staus' => 'required',
            ], [
                'order.required' => 'پر کردن فیلد ترتیب الزامی میباشد!',
                'staus.required' => 'مشخص کردن فیلد وضعیت الزامی میباشد!',
            ]);
            $order = $request->input('order');
            $title = $request->input('title');
            $pic = [
                'pic1' => $request->input('pic1'),
                'link1' => $request->input('link1'),
                'pic2' => $request->input('pic2'),
                'link2' => $request->input('link2'),
                'pic3' => $request->input('pic3'),
                'link3' => $request->input('link3'),
                'pic4' => $request->input('pic4'),
                'link4' => $request->input('link4'),
            ];
            $pic = json_encode($pic);
            $staus = $request->input('staus');
            $link = '#';
            $Page = $request->input('Page');
            $InputData = [
                'page' => $Page,
                'order' => $order,
                'theme' => 12,
                'title' => $title,
                'pic' => $pic,
                'status' => $staus,
                'link' => $link,
                'linkMeta' => 0
            ];
            mobile_banner::create($InputData);
            return redirect()->back()->with('success', __("Transaction done!"));
        } elseif ($request->input('submit') == 'edit') {
            $request->validate([
                'order' => 'required',
                'staus' => 'required',
            ]);
            $tableid = $request->input("tableid");
            $order = $request->input("order");
            $title = $request->input("title");
            $pic = [
                'pic1' => $request->input('pic1'),
                'link1' => $request->input('link1'),
                'pic2' => $request->input('pic2'),
                'link2' => $request->input('link2'),
                'pic3' => $request->input('pic3'),
                'link3' => $request->input('link3'),
                'pic4' => $request->input('pic4'),
                'link4' => $request->input('link4'),
            ];
            $pic = json_encode($pic);
            $staus = $request->input("staus");
            $link = $request->input("link");
            $Page = $request->input('Page');
            $InputData = [
                'page' => $Page,
                'order' => $order,
                'title' => $title,
                'pic' => $pic,
                'status' => $staus,
                'link' => $link,
                'linkMeta' => 0
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
    public function PosterManagement4X()
    {
        $elements = mobile_banner::all()->where('theme', 11)->where('status', '!=', 100);
        return view('WPA_admin.PosterManagement4X', ['elements' => $elements]);
    }
    public function DoPosterManagement4X(Request $request)
    {
        if ($request->input('submit') == 'add') {
            $request->validate([
                'order' => 'required',
                'staus' => 'required',
            ], [
                'order.required' => 'پر کردن فیلد ترتیب الزامی میباشد!',
                'staus.required' => 'مشخص کردن فیلد وضعیت الزامی میباشد!',
            ]);
            $order = $request->input('order');
            $title = $request->input('title');
            $pic = [
                'pic1' => $request->input('pic1'),
                'link1' => $request->input('link1'),
                'pic2' => $request->input('pic2'),
                'link2' => $request->input('link2'),
                'pic3' => $request->input('pic3'),
                'link3' => $request->input('link3'),
                'pic4' => $request->input('pic4'),
                'link4' => $request->input('link4'),
            ];
            $pic = json_encode($pic);
            $staus = $request->input('staus');
            $link = '#';
            $Page = $request->input('Page');
            $InputData = [
                'page' => $Page,
                'order' => $order,
                'theme' => 11,
                'title' => $title,
                'pic' => $pic,
                'status' => $staus,
                'link' => $link,
                'linkMeta' => 0
            ];
            mobile_banner::create($InputData);
            return redirect()->back()->with('success', __("Transaction done!"));
        } elseif ($request->input('submit') == 'edit') {
            $request->validate([
                'order' => 'required',
                'staus' => 'required',
            ]);
            $tableid = $request->input("tableid");
            $order = $request->input("order");
            $title = $request->input("title");
            $pic = [
                'pic1' => $request->input('pic1'),
                'link1' => $request->input('link1'),
                'pic2' => $request->input('pic2'),
                'link2' => $request->input('link2'),
                'pic3' => $request->input('pic3'),
                'link3' => $request->input('link3'),
                'pic4' => $request->input('pic4'),
                'link4' => $request->input('link4'),
            ];
            $pic = json_encode($pic);
            $staus = $request->input("staus");
            $link = $request->input("link");
            $Page = $request->input('Page');
            $InputData = [
                'page' => $Page,
                'order' => $order,
                'title' => $title,
                'pic' => $pic,
                'status' => $staus,
                'link' => $link,
                'linkMeta' => 0
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
    public function PosterManagement()
    {
        $elements = mobile_banner::all()->where('theme', 4)->where('status', '!=', 100);
        return view('WPA_admin.PosterManagement', ['elements' => $elements]);
    }
    public function DoPosterManagement(Request $request)
    {
        if ($request->input('submit') == 'add') {
            $request->validate([
                'order' => 'required',
                'staus' => 'required',
            ], [
                'order.required' => 'پر کردن فیلد ترتیب الزامی میباشد!',
                'staus.required' => 'مشخص کردن فیلد وضعیت الزامی میباشد!',
            ]);
            $order = $request->input('order');
            $title = $request->input('title');
            $pic = $request->input('pic');
            $staus = $request->input('staus');
            $link = $request->input('link');
            $Page = $request->input('Page');
            $InputData = [
                'page' => $Page,
                'order' => $order,
                'theme' => 4,
                'title' => $title,
                'pic' => $pic,
                'status' => $staus,
                'link' => $link,
                'linkMeta' => 0
            ];
            mobile_banner::create($InputData);
            return redirect()->back()->with('success', __("Transaction done!"));
        } elseif ($request->input('submit') == 'edit') {
            $request->validate([
                'order' => 'required',
                'staus' => 'required',
            ]);
            $tableid = $request->input("tableid");
            $order = $request->input("order");
            $title = $request->input("title");
            $pic = $request->input("pic");
            $staus = $request->input("staus");
            $link = $request->input("link");
            $Page = $request->input('Page');
            $InputData = [
                'page' => $Page,
                'order' => $order,
                'title' => $title,
                'pic' => $pic,
                'status' => $staus,
                'link' => $link,
                'linkMeta' => 0
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
    public function IconBoxManagement()
    {
        $elements = mobile_banner::all()->where('theme', 3)->where('status', '!=', 100);
        return view('WPA_admin.IconBoxManagement', ['elements' => $elements]);
    }
    public function DoIconBoxManagement(Request $request)
    {

        if ($request->input('submit') == 'add') {
            $request->validate([
                'order' => 'required',
                'staus' => 'required',
            ], [
                'order.required' => 'پر کردن فیلد ترتیب الزامی میباشد!',
                'staus.required' => 'مشخص کردن فیلد وضعیت الزامی میباشد!',
            ]);
            $Mytexts = [
                'title' => $request->input('title'),
                'BoxName' => $request->input('BoxName')
            ];
            $title = json_encode($Mytexts);

            $order = $request->input('order');
            $pic = $request->input('pic');
            $staus = $request->input('staus');
            $link = $request->input('link');
            $Page = $request->input('Page');
            $InputData = [
                'page' => $Page,
                'order' => $order,
                'theme' => 3,
                'title' => $title,
                'pic' => $pic,
                'status' => $staus,
                'link' => $link,
                'linkMeta' => 0
            ];
            mobile_banner::create($InputData);
            return redirect()->back()->with('success', __("Transaction done!"));
        } elseif ($request->input('submit') == 'edit') {
            $request->validate([
                'order' => 'required',
                'staus' => 'required',
            ]);
            $Mytexts = [
                'title' => $request->input('title'),
                'BoxName' => $request->input('BoxName')
            ];
            $title = json_encode($Mytexts);

            $tableid = $request->input("tableid");
            $order = $request->input("order");
            $pic = $request->input("pic");
            $staus = $request->input("staus");
            $link = $request->input("link");
            $Page = $request->input('Page');
            $InputData = [
                'page' => $Page,
                'order' => $order,
                'title' => $title,
                'pic' => $pic,
                'status' => $staus,
                'link' => $link,
                'linkMeta' => 0
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
    public function IconManagement()
    {
        $elements = mobile_banner::all()->where('theme', 2)->where('status', '!=', 100);
        return view('WPA_admin.IconManagement', ['elements' => $elements]);
    }
    public function DoIconManagement(Request $request)
    {
        if ($request->input('submit') == 'add') {
            $request->validate([
                'order' => 'required',
                'staus' => 'required',
            ], [
                'order.required' => 'پر کردن فیلد ترتیب الزامی میباشد!',
                'staus.required' => 'مشخص کردن فیلد وضعیت الزامی میباشد!',
            ]);
            $order = $request->input('order');
            $title = $request->input('title');
            $pic = $request->input('pic');
            $staus = $request->input('staus');
            $link = $request->input('link');
            $Page = $request->input('Page');
            $InputData = [
                'page' => $Page,
                'order' => $order,
                'theme' => 2,
                'title' => $title,
                'pic' => $pic,
                'status' => $staus,
                'link' => $link,
                'linkMeta' => 0
            ];
            mobile_banner::create($InputData);
            return redirect()->back()->with('success', __("Transaction done!"));
        } elseif ($request->input('submit') == 'edit') {
            $request->validate([
                'order' => 'required',
                'staus' => 'required',
            ]);
            $tableid = $request->input("tableid");
            $order = $request->input("order");
            $title = $request->input("title");
            $pic = $request->input("pic");
            $staus = $request->input("staus");
            $link = $request->input("link");
            $Page = $request->input('Page');
            $InputData = [
                'page' => $Page,
                'order' => $order,
                'title' => $title,
                'pic' => $pic,
                'status' => $staus,
                'link' => $link,
                'linkMeta' => 0
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
    public function BannerManagement()
    {
        $elements = mobile_banner::all()->where('theme', 1)->where('status', '!=', 100);
        return view('WPA_admin.BannerManagement', ['elements' => $elements]);
    }
    public function DoBannerManagement(Request $request)
    {
        if ($request->input('submit') == 'add') {
            $request->validate([
                'order' => 'required',
                'staus' => 'required',
            ], [
                'order.required' => 'پر کردن فیلد ترتیب الزامی میباشد!',
                'staus.required' => 'مشخص کردن فیلد وضعیت الزامی میباشد!',
            ]);
            $order = $request->input('order');
            $title = $request->input('title');
            $pic = $request->input('pic');
            $staus = $request->input('staus');
            $link = $request->input('link');
            $Page = $request->input('Page');
            $InputData = [
                'page' => $Page,
                'order' => $order,
                'theme' => 1,
                'title' => $title,
                'pic' => $pic,
                'status' => $staus,
                'link' => $link,
                'linkMeta' => 0
            ];
            mobile_banner::create($InputData);
            return redirect()->back()->with('success', __("Transaction done!"));
        } elseif ($request->input('submit') == 'edit') {
            $request->validate([
                'order' => 'required',
                'staus' => 'required',
            ]);
            $tableid = $request->input("tableid");
            $order = $request->input("order");
            $title = $request->input("title");
            $pic = $request->input("pic");
            $staus = $request->input("staus");
            $link = $request->input("link");
            $Page = $request->input('Page');
            $InputData = [
                'page' => $Page,
                'order' => $order,
                'title' => $title,
                'pic' => $pic,
                'status' => $staus,
                'link' => $link,
                'linkMeta' => 0
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

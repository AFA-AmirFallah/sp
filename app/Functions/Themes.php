<?php

namespace App\Functions;

use App\Models\html_object;
use App\Models\L1Work;
use App\Models\L2Work;
use App\Models\L3Work;
use App\Models\WorkCat;
use App\myappenv;

class Themes
{
    private $MainTheme;
    private $ObjectId;
    private $page;
    private $order;
    private $theme;
    private $title;
    private $pic;
    private $status;
    private $link;
    private $linkMeta;

    public function __construct()
    {
        $this->MainTheme = myappenv::SiteTheme;
    }
    public static function GetHtmlObj($Obj)
    {
        $HtmlObj = html_object::where('htmlname', $Obj)->first();
        if ($HtmlObj == null) {
            return null;
        } else {
            return $HtmlObj->htmlobj;
        }
    }

    public function set_object_id($Obj)
    {
        $Obj = intval($Obj);
        $this->ObjectId = $Obj;
        return true;
    }
    public function get_Object_id()
    {
        return $this->ObjectId;
    }
    public function get_object_name()
    {
        $Obj = $this->ObjectId;
        switch ($Obj) {
            case 201:
                return 'اسلایدر اصلی';
            case 202:
                return ' لیست محصولات افقی';
            case 203:
                return 'نمایش تگ های خرید ';
            case 204:
                return 'برند ها';
            case 205:
                return 'نمایش اخبار';
            case 206:
                return 'نمایش تصاویر ۴ تایی';
            case 207:
                return 'نمایش تصاویر 2 تایی';
            case 310:
                return 'در مشاوره نمایش اخبار';
            case 210:
                return ' لیست محصولات افقی جدید';
            case 401:
                return 'بنر اصلی';
            case 402:
                return 'کارت های کوچک';
            case 501:
                return 'اسلایدر بالا  حالت لپ تاپ';
            case 502:
                return 'اسلایدر بالا حالت موبایل ';
            case 503:
                return 'عکس های کناری اسلایدر';
            case 504:
                return 'لیست محصولات مدرن';
            case 505:
                return 'بنر تکی';
            case 506:
                return 'بنر دوتایی';
            case 507:
                return 'بنر جهارتایی';
            case 508:
                return 'لیست محصولات ';
            case 509:
                return 'لیست محصولات پیشرفته ';
            case 510:
                return 'لیست برند ها  ';
            case 511:
                return 'لیست محصولات کلاسیک ';
        }
    }
    public function get_theme()
    {
        return $this->MainTheme;
    }

    private function MakeJasonPicFeild($request)
    {
        $Pic = [];
        foreach ($request as $key => $requestitem) {
            if ($key == '_token' || $key == 'tableid' || $key == 'order' || $key == 'Page' || $key == 'title' || $key == 'staus' || $key == 'submit') {
            } else {
                array_push($Pic, (object) [$key => $requestitem]);
            }
        }
        $Pic = json_encode($Pic);
        return $Pic;
    }
    public static function get_l3_same($UID, $Limit)
    {
        $MainCat = L3Work::where('UID', $UID)->first();
        $SameCat = L3Work::where('WorkCat', $MainCat->WorkCat)->where('L1ID', $MainCat->L1ID)->where('L2ID', $MainCat->L2ID)->limit($Limit)->get();
        return $SameCat;
    }
    public static function get_value_from_Json($Json, $Inputkey)
    {
        $Banners = json_decode($Json);
        foreach ($Banners as $BannerArr) {
            foreach ($BannerArr as $key => $BannerItem) {
                if ($Inputkey == $key) {
                    return $BannerItem;
                }
            }
        }
        return null;
    }
    private function FormatPicField($request, $themeID)
    {
        if (!isset($request['pic'])) {
            return $this->MakeJasonPicFeild($request);
        } else {
            return $request['pic'];
        }
    }
    public function DataShaping($request, $themeID)
    {

        $this->set_object_id($themeID);
        $this->order = $request['order'];
        $this->page = $request['Page'];
        $this->title = $request['title'];
        $this->status = $request['staus'];
        if (isset($request['link'])) {
            $this->link = $request['link'];
        } else {
            $this->link = '#';
        }
        $this->linkMeta = 0;
        $this->pic = $this->FormatPicField($request, $themeID);
    }
    public function get_page()
    {
        return $this->page;
    }
    public function get_order()
    {
        return $this->order;
    }
    public function get_title()
    {
        return $this->title;
    }
    public function get_pic()
    {
        return $this->pic;
    }
    public function get_status()
    {
        return $this->status;
    }
    public function get_link()
    {

        return $this->link;
    }
    public function get_linkmeta()
    {
        return $this->linkMeta;
    }
    public function get_WorkCat()
    {
        return WorkCat::all();
    }
    public function get_L1work()
    {
        return L1Work::all();
    }
    public function get_L2work()
    {
        return L2Work::all();
    }
    public function get_L3work()
    {
        return L3Work::all();
    }
}

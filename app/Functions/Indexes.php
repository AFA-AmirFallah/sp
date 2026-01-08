<?php

namespace App\Functions;

use App\Http\Controllers\setting\debuger;
use App\Models\goodindex;
use App\Models\L1Work;
use App\Models\L2Work;
use App\Models\L3Work;
use App\Models\product_order;
use App\Models\product_order_items;
use App\Models\WorkCat;
use App\Models\WorkerSkils;
use Illuminate\Support\Facades\DB;
use App\myappenv;
use Ramsey\Uuid\Type\Integer;

class Indexes
{
    public static function who_buy_this_product($product_id)
    {
        $query = "SELECT ui.UserName , ui.Name , ui.Family , ui.MobileNo , po.id  , poi.product_qty , po.created_at  from product_order_items poi   INNER  JOIN  product_orders po  on po.id = poi.order_id and po.status >= 90 INNER join UserInfo ui on ui.UserName = po.CustomerId  WHERE  poi.product_id = $product_id";
        return DB::select($query);
    }
    public static function who_has_this_product_index($product_id)
    {
        $query = "SELECT ui.UserName , ui.Name , ui.Family , ui.MobileNo , SUM(ws.Weight) as Weight FROM  goodindices g  inner join WorkerSkils ws on g.IndexID = ws.SkilID INNER JOIN UserInfo ui on ui.UserName = ws.UserName WHERE g.GoodID = $product_id GROUP  by  ui.UserName , ui.Name , ui.Family , ui.MobileNo";
        return DB::select($query);
    }
    private function add_index_to_customer($user_id, $index_id, $index_weight)
    {
        $skill_before = WorkerSkils::where('UserName', $user_id)->where('SkilID', $index_id)->first();
        if ($skill_before != null) {
            $Weight = $skill_before->Weight ?? 0;
            $Weight += $index_weight;
            $worker_skill_exist = true;
        } else {
            $Weight = $index_weight;
            $worker_skill_exist = false;
        }
        if ($worker_skill_exist) {
            WorkerSkils::where('UserName', $user_id)->where('SkilID', $index_id)->update(['Weight' => $Weight]);
        } else {
            $TL3WorkSrc = L3Work::where('UID', $index_id)->first();
            if ($TL3WorkSrc == null) {
                return [
                    'result' => false,
                    'msg' => 'the index is not find'
                ];
            }
            $TWorkCat = $TL3WorkSrc->WorkCat;
            $TL1ID = $TL3WorkSrc->L1ID;
            $TL2ID = $TL3WorkSrc->L2ID;
            $SingleData = [
                'UserName' => $user_id,
                'SkilID' => $index_id,
                'WorkCat' => $TWorkCat,
                'L1ID' => $TL1ID,
                'L2ID' => $TL2ID,
                'CreateDate' => now(),
                'Status' => 1,
                'Weight' => $Weight,
                'Note' => "add by system",
            ];
            WorkerSkils::create($SingleData);
        }
        return [
            'result' => true,
        ];
    }
    public function assign_index_to_customer_by_order($order_id)
    {
        $order_src = product_order::where('id', $order_id)->first();
        if ($order_src == null) {
            return false;
        }
        if ($order_src->status == 90) {
            $customer_id = $order_src->CustomerId;
            $order_items_src = product_order_items::where('order_id', $order_id)->get();
            foreach ($order_items_src as $order_item) {
                $product_id = $order_item->product_id;
                $order_qty = $order_item->product_qty;
                $product_index_src = goodindex::where('GoodID', $product_id)->get();
                foreach ($product_index_src as $product_index) {
                    $this->add_index_to_customer($customer_id, $product_index->IndexID, $order_qty);
                }
            }
            return true;
        }
        return false;
    }
    public static function assign_index_to_user_by_system(string $RequestUser = null, int $index_id = null)
    {
        if ($RequestUser == null || $index_id == null) {
            return [
                'result' => true,
                'msg' => 'done with no index'
            ];
        }
        $skill_before = WorkerSkils::where('UserName', $RequestUser)->where('SkilID', $index_id)->first();
        if ($skill_before != null) {
            $Weight = $skill_before->Weight ?? 0;
            $Weight++;
            $worker_skill_exist = true;
        } else {
            $Weight = 1;
            $worker_skill_exist = false;
        }
        $TL3WorkSrc = L3Work::where('UID', $index_id)->first();
        if ($TL3WorkSrc == null) {
            return [
                'result' => false,
                'msg' => 'the index is not find'
            ];
        }
        $TWorkCat = $TL3WorkSrc->WorkCat;
        $TL1ID = $TL3WorkSrc->L1ID;
        $TL2ID = $TL3WorkSrc->L2ID;
        if ($worker_skill_exist) {
            WorkerSkils::where('UserName', $RequestUser)->where('SkilID', $index_id)->update(['Weight' => $Weight]);
        } else {
            $SingleData = [
                'UserName' => $RequestUser,
                'SkilID' => $index_id,
                'WorkCat' => $TWorkCat,
                'L1ID' => $TL1ID,
                'L2ID' => $TL2ID,
                'CreateDate' => now(),
                'Status' => 1,
                'Weight' => $Weight,
                'Note' => "add by system",
            ];
            WorkerSkils::create($SingleData);
        }

        return [
            'result' => true,
            'msg' => 'done'
        ];
    }
    public static function get_index_id()
    {
        if (debuger::DebugEnable()) {
            $ItemName = 'MainMenuT';
        } else {
            $ItemName = 'MainMenu';
        }
        $MainMenu = CacheData::GetSetting($ItemName);
        $MainMenu = json_decode($MainMenu);
        return $MainMenu;
    }
    public static function get_workcat_menu_id()
    {
        if (debuger::DebugEnable()) {
            $ItemName = 'MainMenuT';
        } else {
            $ItemName = 'MainMenu';
        }
        $MainMenu = CacheData::GetSetting($ItemName);
        $MainMenu = json_decode($MainMenu);
        if (isset($MainMenu->WorkCat)) {
            $WorkCatMenu = $MainMenu->WorkCat;
        } else {
            $MainMenu = $MainMenu->value;
            $MainMenu = json_decode($MainMenu);
            $WorkCatMenu = $MainMenu->WorkCat;
        }
        return $WorkCatMenu;
    }
    public static function get_workcat_menu()
    {
        $workcatId = self::get_workcat_menu_id();
        return WorkCat::where('ID', $workcatId)->get();
    }
    public static function get_l1_menu()
    {
        $workcatId = self::get_workcat_menu_id();
        return L1Work::where('WorkCat', $workcatId)->get();
    }
    public static function get_l2_menu($L1ID)
    {
        $workcatId = self::get_workcat_menu_id();
        return L2Work::where('WorkCat', $workcatId)->where('L1ID', $L1ID)->get();
    }
    public static function get_l3_menu($L1ID, $L2ID)
    {
        $workcatId = self::get_workcat_menu_id();
        return L3Work::where('WorkCat', $workcatId)->where('L1ID', $L1ID)->where('L2ID', $L2ID)->get();
    }

    public static function HTMLMenu($theme)
    {
        if (debuger::DebugEnable()) {
            $ItemName = 'MainMenuT';
        } else {
            $ItemName = 'MainMenu';
        }
        $MainMenu = CacheData::GetSetting($ItemName);
        $MainMenu = json_decode($MainMenu);
        if (isset($MainMenu->WorkCat)) {
            $WorkCatMenu = $MainMenu->WorkCat;
        } else {
            $MainMenu = $MainMenu->value;
            $MainMenu = json_decode($MainMenu);
            $WorkCatMenu = $MainMenu->WorkCat;
        }

        $SVG_L2 = '<svg width="10" height="8" viewBox="0 0 10 8" fill="none"><path d="M5.411 7.40678C5.21215 7.69378 4.78784 7.69378 4.589 7.40678L0.347536 1.28475C0.117796 0.953146 0.355124 0.5 0.758533 0.500001L9.24147 0.500001C9.64488 0.500001 9.8822 0.953148 9.65246 1.28475L5.411 7.40678Z" fill="#C4C4C4"></path></svg>';
        $TreeQuery = "SELECT WorkCat.ID as WorkCatID,WorkCat.Name  as WorkCatName,
        L1Work.L1ID as L1WorkL1ID, L1Work.Name as L1WorkName , L2Work.L2ID as L2WorkL2ID ,
         L2Work.Name as L2WorkName , L3Work.UID as L3WorkUID  ,L3Work.L3ID as L3WorkL3ID ,
         L3Work.Name as L3WorkName
         FROM WorkCat INNER JOIN L1Work on WorkCat.ID = L1Work.WorkCat INNER JOIN L2Work ON L1Work.WorkCat = L2Work.WorkCat and L1Work.L1ID = L2Work.L1ID INNER JOIN L3Work on L2Work.WorkCat = L3Work.WorkCat and L2Work.L1ID = L3Work.L1ID and L2Work.L2ID = L3Work.L2ID  where WorkCat.ID = $WorkCatMenu  ORDER BY WorkCat.ID ,L1Work.L1ID,L2Work.L2ID,L3Work.L3ID";
        $Treeresult = DB::Select($TreeQuery);

        $L1HTML = '';
        $MenuHTML = '';
        $Eztree = '';
        $haveFeildL1 = FALSE;
        $haveFeildL2 = FALSE;
        $haveFeildL3 = FALSE;
        $L3FirstTime = TRUE;
        $WorkCatIDT = "";
        $WorkCatF = FALSE;
        $L1IDT = "";
        $L1IDF = FALSE;
        $L2IDT = "";
        $MyCounter = 0;
        $L2IDF = FALSE;
        $L3IDT = 0;
        $L3IDF = FALSE;
        $EztreeT = '<ul id="myUL" class="font-tbody" >';
        $Plase = 'class="box"';
        foreach ($Treeresult as $Treerow) {
            if ($Treerow->WorkCatName == $WorkCatIDT) {
                if ($WorkCatF) {
                } else {
                    //$EztreeT .= "<ul>";
                    //$endline = "<ul>";
                    //$WorkCatF = TRUE;
                }
            } else {
                if ($WorkCatF) {
                    $EztreeT .= "</ul></ul></ul>";

                    $endline = '<ul class="nested4">';
                } else {

                    $endline = '<ul class="nested4">';
                }

                //$EztreeT .= "<li><span $Plase >$Treerow->WorkCatID - $Treerow->WorkCatName</span>$endline";

                $L1IDF = FALSE;
                $WorkCatF = TRUE;
                $endline = '';
                $WorkCatIDT = $Treerow->WorkCatName;
            }
            if ($Treerow->L1WorkName == $L1IDT) {
            } else {
                if ($L1IDF) {
                    $EztreeT .= "</ul></li></ul></li>";
                    $endline = '<ul id="l' . $Treerow->WorkCatID . '" class="nested4">';

                    $L2IDF = FALSE;
                } else {
                    $endline = '<ul class="nested4">';
                }
                $EztreeT .= "<li><span $Plase>$Treerow->WorkCatID ,$Treerow->L1WorkL1ID  - $Treerow->L1WorkName</span>$endline ";
                $L1HTML .= "<li onmouseover='ActiveL1($Treerow->L1WorkL1ID)' class='L1menu_item' >$Treerow->L1WorkName</li>";
                $MenuHTML .= "<div class='menu_items_title cat_$Treerow->L1WorkL1ID menu_items nested'><a href='#'>  همه محصولات $Treerow->L1WorkName > </a> </div> ";
                $L1IDF = TRUE;
                $L2IDF = FALSE;
                $endline = '';
                $L1IDT = $Treerow->L1WorkName;
            }
            if ($Treerow->L2WorkName == $L2IDT) {
            } else {
                if ($L2IDF) {
                    $EztreeT .= "</ul></li>";
                    $endline = '<ul class="nested4">';
                    $L2IDF = FALSE;
                } else {
                    $endline = '<ul class="nested4">';
                }

                $EztreeT .= "<li><span $Plase>$Treerow->WorkCatID ,$Treerow->L1WorkL1ID  ,$Treerow->L2WorkL2ID - $Treerow->L2WorkName</span>$endline";
                $MenuHTML .= "<li class='L2menu_item cat_$Treerow->L1WorkL1ID menu_items nested'>$Treerow->L2WorkName  $SVG_L2</li>";
                $L2IDF = TRUE;
                $endline = '';
                $L2IDT = $Treerow->L2WorkName;
            }
            $SelectCase = '<input name="check_list[' . $MyCounter . ']" value="' . "$Treerow->L3WorkUID" . '" data-id="custom-0" type="checkbox" />';
            if ($Treerow->L3WorkUID == $L3IDT) {
                $RouteL3 = route('ShowProduct', ['Tags' => $L3IDT]);
                $EztreeT .= "<li>$SelectCase<span>$Treerow->WorkCatID ,$Treerow->L1WorkL1ID  ,$Treerow->L2WorkL2ID ,$Treerow->L3WorkName </span></li>";
                $MenuHTML .= "<li class='L3menu_item cat_$Treerow->L1WorkL1ID menu_items nested' ><a class='L3LinkMenu' href='$RouteL3'> $Treerow->L3WorkName</a></li>";
                $MyCounter++;
            } else {
                $RouteL3 = route('ShowProduct', ['Tags' => $Treerow->L3WorkUID]);
                $EztreeT .= "<li>$SelectCase<span>$Treerow->WorkCatID ,$Treerow->L1WorkL1ID  ,$Treerow->L2WorkL2ID ,$Treerow->L3WorkUID - $Treerow->L3WorkName</span></li>";
                $MenuHTML .= "<li class='L3menu_item cat_$Treerow->L1WorkL1ID menu_items nested' > <a class='L3LinkMenu' href='$RouteL3'>  $Treerow->L3WorkName </a> </li>";
                $L3IDT = $Treerow->L3WorkUID;
                $MyCounter++;
            }
        }
        $Output = "<div class='row'> <div class='menu_head col-2'>$L1HTML</div>
        <div class='menu_main col-10'>$MenuHTML</div></div>";
        return $Output;
    }
    public static function HTMLVerticalMenu()
    {
        if (debuger::DebugEnable()) {
            $ItemName = 'MainMenuT';
        } else {
            $ItemName = 'MainMenu';
        }

        $MainMenu = CacheData::GetSetting($ItemName);
        $MainMenu = json_decode($MainMenu);
        $WorkCatMenu = $MainMenu->WorkCat;

        $SVG_L2 = '<svg viewBox="0 0 32 32" fill="currentColor" focusable="false" color="gray" style="width: 13px; height: 13px;"><path d="M14.406 7.781C6.715 15.461 6.625 15.562 6.625 16s.09.539 7.77 8.219L22.176 32h.494c.483 0 .539-.034 1.606-1.1 1.718-1.718 2.302-.775-5.3-8.387-3.514-3.526-6.4-6.434-6.4-6.467s2.74-2.785 6.074-6.119c3.346-3.324 6.22-6.254 6.4-6.49.213-.292.326-.573.326-.831 0-.359-.123-.528-1.1-1.505-1.067-1.067-1.123-1.1-1.594-1.1h-.505l-7.77 7.781z"></path></svg>';
        $TreeQuery = "SELECT WorkCat.ID as WorkCatID,WorkCat.Name  as WorkCatName,
        L1Work.L1ID as L1WorkL1ID, L1Work.Name as L1WorkName , L2Work.L2ID as L2WorkL2ID ,
         L2Work.Name as L2WorkName , L3Work.UID as L3WorkUID  ,L3Work.L3ID as L3WorkL3ID ,
         L3Work.Name as L3WorkName
         FROM WorkCat INNER JOIN L1Work on WorkCat.ID = L1Work.WorkCat INNER JOIN L2Work ON L1Work.WorkCat = L2Work.WorkCat and L1Work.L1ID = L2Work.L1ID INNER JOIN L3Work on L2Work.WorkCat = L3Work.WorkCat and L2Work.L1ID = L3Work.L1ID and L2Work.L2ID = L3Work.L2ID  where WorkCat.ID = $WorkCatMenu  ORDER BY WorkCat.ID ,L1Work.L1ID,L2Work.L2ID,L3Work.L3ID";
        $Treeresult = DB::Select($TreeQuery);


        return $Treeresult;
    }

    public function HTMLNewsTreeIndex()
    {
        $WorkCat = myappenv::PostIndexWorkCat;
        $TreeQuery = "SELECT L3Work.* , posts.id as post_id from  L3Work
 left join posts  on posts.MainIndex = L3Work.UID and posts.Type = 3
 where L3Work.WorkCat = $WorkCat and  L3Work.L1ID = $WorkCat
 order by post_id DESC
";
        $Treeresult = DB::Select($TreeQuery);
        return $Treeresult;
    }
    public function HTMLTreeIndex_cover_admin()
    {
        $TreeQuery = "SELECT WorkCat.ID as WorkCatID,WorkCat.Name  as WorkCatName,
L1Work.L1ID as L1WorkL1ID, L1Work.Name as L1WorkName , L2Work.L2ID as L2WorkL2ID ,
 L2Work.Name as L2WorkName , L3Work.UID as L3WorkUID  ,L3Work.L3ID as L3WorkL3ID ,
 L3Work.Name as L3WorkName , posts.id as post_id
 FROM WorkCat INNER JOIN L1Work on WorkCat.ID = L1Work.WorkCat
 INNER JOIN L2Work ON L1Work.WorkCat = L2Work.WorkCat and L1Work.L1ID = L2Work.L1ID
 INNER JOIN L3Work on L2Work.WorkCat = L3Work.WorkCat and L2Work.L1ID = L3Work.L1ID and L2Work.L2ID = L3Work.L2ID
 LEFT JOIN posts on L3Work.UID = posts.MainIndex and posts.Type > 1
 ORDER BY WorkCat.ID ,L1Work.L1ID,L2Work.L2ID,L3Work.L3ID";
        $Treeresult = DB::Select($TreeQuery);
        $Eztree = '';
        $haveFeildL1 = FALSE;
        $haveFeildL2 = FALSE;
        $haveFeildL3 = FALSE;
        $L3FirstTime = TRUE;
        $WorkCatIDT = "";
        $WorkCatF = FALSE;
        $L1IDT = "";
        $L1IDF = FALSE;
        $L2IDT = "";
        $MyCounter = 0;
        $L2IDF = FALSE;
        $L3IDT = 0;
        $L3IDF = FALSE;
        $EztreeT = '<ul id="myUL" class="font-tbody" >';
        $Plase = 'class="box"';
        foreach ($Treeresult as $Treerow) {

            if ($Treerow->WorkCatName == $WorkCatIDT) {
                if ($WorkCatF) {
                } else {
                    //$EztreeT .= "<ul>";
                    //$endline = "<ul>";
                    //$WorkCatF = TRUE;
                }
            } else {
                if ($WorkCatF) {
                    $EztreeT .= "</ul></ul></ul>";

                    $endline = '<ul class="nested">';
                } else {

                    $endline = '<ul class="nested">';
                }

                $EztreeT .= "<li><span $Plase >$Treerow->WorkCatID - $Treerow->WorkCatName</span>$endline";
                $L1IDF = FALSE;
                $WorkCatF = TRUE;
                $endline = '';
                $WorkCatIDT = $Treerow->WorkCatName;
                //$L1IDF = TRUE;
            }
            if ($Treerow->L1WorkName == $L1IDT) {
            } else {
                if ($L1IDF) {
                    $EztreeT .= "</ul></li></ul></li>";
                    $endline = '<ul id="l' . $Treerow->WorkCatID . '" class="nested">';

                    $L2IDF = FALSE;
                } else {
                    $endline = '<ul class="nested">';
                }
                $EztreeT .= "<li><span $Plase>$Treerow->WorkCatID ,$Treerow->L1WorkL1ID  - $Treerow->L1WorkName</span>$endline";
                $L1IDF = TRUE;
                $L2IDF = FALSE;
                $endline = '';
                $L1IDT = $Treerow->L1WorkName;
            }
            if ($Treerow->L2WorkName == $L2IDT) {
            } else {
                if ($L2IDF) {
                    $EztreeT .= "</ul></li>";
                    $endline = '<ul class="nested">';
                    $L2IDF = FALSE;
                } else {
                    $endline = '<ul class="nested">';
                }

                $EztreeT .= "<li><span $Plase>$Treerow->WorkCatID ,$Treerow->L1WorkL1ID  ,$Treerow->L2WorkL2ID - $Treerow->L2WorkName</span>$endline";
                $L2IDF = TRUE;
                $endline = '';
                $L2IDT = $Treerow->L2WorkName;
            }
            $SelectCase = '<input class="indexCehckbox" name="check_list[' . $MyCounter . ']" value="' . "$Treerow->L3WorkUID" . '" data-id="custom-0" type="checkbox" />';
            if ($Treerow->L3WorkUID == $L3IDT) {

                $EztreeT .= "<li>$SelectCase<span>$Treerow->WorkCatID ,$Treerow->L1WorkL1ID  ,$Treerow->L2WorkL2ID ,$Treerow->L3WorkName </span></li>";
                $MyCounter++;
            } else {
                $tag_route = route('MakeTagCover', ['TagID' => $Treerow->L3WorkUID]);
                $cover_text = '<a class="text-primary" href="' . $tag_route . '">افزودن کاور  </a>';
                if ($Treerow->post_id != null) {
                    $tag_route = route('EditTagCover', ['TagID' => $Treerow->L3WorkUID]);
                    $cover_text = '<a class="text-success"  href="' . $tag_route . '">  ویرایش کاور</a>';
                }
                $EztreeT .= "<li>$SelectCase<span>$Treerow->WorkCatID ,$Treerow->L1WorkL1ID  ,$Treerow->L2WorkL2ID ,$Treerow->L3WorkUID - $Treerow->L3WorkName</span> $cover_text</li> ";
                $L3IDT = $Treerow->L3WorkUID;
                $MyCounter++;
            }
        }

        return $EztreeT;
    }
    public function HTMLTreeIndex()
    {
        $TreeQuery = "SELECT WorkCat.ID as WorkCatID,WorkCat.Name  as WorkCatName,
L1Work.L1ID as L1WorkL1ID, L1Work.Name as L1WorkName , L2Work.L2ID as L2WorkL2ID ,
 L2Work.Name as L2WorkName , L3Work.UID as L3WorkUID  ,L3Work.L3ID as L3WorkL3ID ,
 L3Work.Name as L3WorkName
 FROM WorkCat INNER JOIN L1Work on WorkCat.ID = L1Work.WorkCat INNER JOIN L2Work ON L1Work.WorkCat = L2Work.WorkCat and L1Work.L1ID = L2Work.L1ID INNER JOIN L3Work on L2Work.WorkCat = L3Work.WorkCat and L2Work.L1ID = L3Work.L1ID and L2Work.L2ID = L3Work.L2ID ORDER BY WorkCat.ID ,L1Work.L1ID,L2Work.L2ID,L3Work.L3ID";
        $Treeresult = DB::Select($TreeQuery);
        $Eztree = '';
        $haveFeildL1 = FALSE;
        $haveFeildL2 = FALSE;
        $haveFeildL3 = FALSE;
        $L3FirstTime = TRUE;
        $WorkCatIDT = "";
        $WorkCatF = FALSE;
        $L1IDT = "";
        $L1IDF = FALSE;
        $L2IDT = "";
        $MyCounter = 0;
        $L2IDF = FALSE;
        $L3IDT = 0;
        $L3IDF = FALSE;
        $EztreeT = '<ul id="myUL" class="font-tbody" >';
        $Plase = 'class="box"';
        foreach ($Treeresult as $Treerow) {
            if ($Treerow->WorkCatName == $WorkCatIDT) {
                if ($WorkCatF) {
                } else {
                    //$EztreeT .= "<ul>";
                    //$endline = "<ul>";
                    //$WorkCatF = TRUE;
                }
            } else {
                if ($WorkCatF) {
                    $EztreeT .= "</ul></ul></ul>";

                    $endline = '<ul class="nested">';
                } else {

                    $endline = '<ul class="nested">';
                }

                $EztreeT .= "<li><span $Plase >$Treerow->WorkCatID - $Treerow->WorkCatName</span>$endline";
                $L1IDF = FALSE;
                $WorkCatF = TRUE;
                $endline = '';
                $WorkCatIDT = $Treerow->WorkCatName;
                //$L1IDF = TRUE;
            }
            if ($Treerow->L1WorkName == $L1IDT) {
            } else {
                if ($L1IDF) {
                    $EztreeT .= "</ul></li></ul></li>";
                    $endline = '<ul id="l' . $Treerow->WorkCatID . '" class="nested">';

                    $L2IDF = FALSE;
                } else {
                    $endline = '<ul class="nested">';
                }
                $EztreeT .= "<li><span $Plase>$Treerow->WorkCatID ,$Treerow->L1WorkL1ID  - $Treerow->L1WorkName</span>$endline";
                $L1IDF = TRUE;
                $L2IDF = FALSE;
                $endline = '';
                $L1IDT = $Treerow->L1WorkName;
            }
            if ($Treerow->L2WorkName == $L2IDT) {
            } else {
                if ($L2IDF) {
                    $EztreeT .= "</ul></li>";
                    $endline = '<ul class="nested">';
                    $L2IDF = FALSE;
                } else {
                    $endline = '<ul class="nested">';
                }

                $EztreeT .= "<li><span $Plase>$Treerow->WorkCatID ,$Treerow->L1WorkL1ID  ,$Treerow->L2WorkL2ID - $Treerow->L2WorkName</span>$endline";
                $L2IDF = TRUE;
                $endline = '';
                $L2IDT = $Treerow->L2WorkName;
            }
            $SelectCase = '<input class="indexCehckbox" name="check_list[' . $MyCounter . ']" value="' . "$Treerow->L3WorkUID" . '" data-id="custom-0" type="checkbox" />';
            if ($Treerow->L3WorkUID == $L3IDT) {

                $EztreeT .= "<li>$SelectCase<span>$Treerow->WorkCatID ,$Treerow->L1WorkL1ID  ,$Treerow->L2WorkL2ID ,$Treerow->L3WorkName </span></li>";
                $MyCounter++;
            } else {
                $EztreeT .= "<li>$SelectCase<span>$Treerow->WorkCatID ,$Treerow->L1WorkL1ID  ,$Treerow->L2WorkL2ID ,$Treerow->L3WorkUID - $Treerow->L3WorkName</span></li>";
                $L3IDT = $Treerow->L3WorkUID;
                $MyCounter++;
            }
        }

        return $EztreeT;
    }
    public function GetUsersWithTags($TagID, $UserRole, $ActiveUser = true)
    {
        $Query = "SELECT UserInfoWithPrice.UserNameMain,UserInfoWithPrice.Name as firstname,UserInfoWithPrice.extranote,UserInfoWithPrice.Family,UserInfoWithPrice.MobileNo,UserInfoWithPrice.Email,UserInfoWithPrice.Status ,UserInfoWithPrice.mony, UserInfoWithPrice.blocked , WorkerSkils.UserName, WorkerSkils.SkilID ,L3Work.UID, L3Work.WorkCat, L3Work.L1ID, L3Work.L2ID, L3Work.L3ID, L3Work.Name,UserInfoWithPrice.Sex , UserRole.RoleName , UserStatus.Name , UserInfoWithPrice.CreateDate as CreateDate , UserInfoWithPrice.branch as branch ,  UserInfoWithPrice.avatar
        FROM UserInfoWithPrice join L3Work join WorkerSkils INNER JOIN UserRole on UserInfoWithPrice.Role = UserRole.Role INNER JOIN UserStatus on UserInfoWithPrice.Status = UserStatus.Status INNER JOIN branches on branches.id = UserInfoWithPrice.branch
        WHERE L3Work.UID = WorkerSkils.SkilID and WorkerSkils.UserName = UserInfoWithPrice.UserNameMain  and  UserInfoWithPrice.Role = $UserRole  ";
        $IndexSearch = 0;
        $Query .= " and L3Work.UID = $TagID";
        if ($ActiveUser) {
            $Query .= ' and UserInfoWithPrice.Status =' . myappenv::User_active_status;
        }
        return DB::select($Query);
    }
}

<?php


namespace App\Functions;

use App\Models\html_object;
use App\Models\posts;
use App\myappenv;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\AssignOp\Mul;
use Illuminate\Support\Facades\Auth;


class NewsClass
{
    private $ItemType;
    private $MostViewCount;
    private $AdsPostsSource;
    private $LastPostsCount;
    private $AdminLogin;
    private $MainIndex;


    public function __construct($ItemType, $AdminLogin, $MostViewCount = 9, $LastPostsCount = 9)
    {
        $this->ItemType = $ItemType;
        $this->MostViewCount = $MostViewCount;
        $this->AdsPostsSource = null;
        $this->LastPostsCount = $LastPostsCount;
        $this->AdminLogin = $AdminLogin;
    }

    public function post_after_update_jobs(int $post_id)
    {
        $query = "SELECT  p.id as id from item_index ii  inner join posts p  on p.MainIndex  = ii.IndexID  and p.`Type` = 3 where  ii.IndexID  in (SELECT ii2.IndexID from item_index ii2 where ii2.PostId = $post_id) GROUP BY p.id ";
        $cover_src = DB::select($query);
        foreach ($cover_src as $cover_item) {
            posts::where('id', $cover_item->id)->update(['updated_at' => now()]);
        }
        return true;
    }
    public function IsAdminLogin()
    {
        return $this->AdminLogin;
    }
    public function HotnewsSorce()
    {
        if ($this->ItemType == "SingleNews") {
        }
    }
    public function mainmenu()
    {
        $MianMenu = html_object::where('htmlname', 'newsmenu')->first();
        return $MianMenu->htmlobj ?? '';
    }

    public function MostView()
    {
        $MostView = posts::where('adds', 0)->where('Status', 1)->where('mostview', 1)->where('branch', 1)->orderBy('id', 'DESC')->limit($this->MostViewCount)->get();
        return $MostView;
    }

    public function HotNews()
    {
        $hotPosts = posts::where('hotnews', 1)->where('Status', 1)->where('branch', 1)->orderBy('id', 'DESC')->get();
        return $hotPosts;
    }

    public function MostViewPosts()
    {
        $LastPosts = posts::where('adds', 0)->where('Status', 1)->where('mostview', 1)->where('branch', 1)->orderBy('id', 'DESC')->get();
        return $LastPosts;
    }
    public function LastPosts()
    {
        $LastPosts = posts::where('adds', 0)->where('Status', 1)->where('lastnews', 1)->where('branch', 1)->orderBy('id', 'DESC')->get();
        return $LastPosts;
    }
    public function LastGalery()
    {
        $LastGalery = posts::where('adds', 0)->where('Status', 1)->where('galery', 1)->where('branch', 1)->orderBy('id', 'DESC')->get();
        return $LastGalery;
    }
    public function GetMainIndex()
    {
        return $this->MainIndex;
    }
    public function get_related_cover(string $cover_text)
    {
        $mytext = new TextClassMain;
        //$cover_text = $mytext->StripText($cover_text);
        $query = "SELECT p.* FROM L3Work lw inner join posts p on lw.UID = p.MainIndex and p.`Type` = 3 and p.Status = 1  WHERE  lw.Name  = '$cover_text'";
        $cover_src = DB::select($query);
        if ($cover_src == []) {
            return null;
        }
        foreach ($cover_src as $cover_item) {
            return $cover_item;
        }
    }

    public function NewsListByIndexName($newscat)
    {
        $branch = 1;
        $WorkCat = myappenv::PostIndexWorkCat;
        $L1IDCat = myappenv::NewsCatL1;
        $L2IDCat = myappenv::NewsCatL2;
        $FindBaseQuery = "SELECT lw.UID   FROM  L3Work lw  INNER JOIN posts p on lw.UID = p.MainIndex WHERE p.branch = $branch and lw.Name = '$newscat' and L1ID = $L1IDCat and L2ID = $L2IDCat and WorkCat =  $WorkCat LIMIT 1";
        $BaseIndexReult = DB::select($FindBaseQuery);
        if ($BaseIndexReult != null) {
            $MainIndex = $BaseIndexReult[0]->UID;
        } else {
            $MainIndex = 0;
        }
        $this->MainIndex = $MainIndex;
        $Query = "SELECT
        posts.id ,
        posts.Titel ,
        posts.UpTitel ,
        posts.SubTitel ,
        posts.Name ,
        posts.Abstract ,
        posts.LinkAddress ,
        posts.OutLink ,
        posts.MainPic ,
        posts.titlePic ,
        posts.Pic ,
        posts.Content ,
        posts.CommentCount ,
        posts.ViewCount ,
        L3Work.Name as indexname ,
        UserInfo.Name as CreatorName ,
        UserInfo.Family as CreatorFamily,
        UserInfo.Avatar as Avatar,
        posts.CrateDate,
        posts.created_at
    FROM
        posts
    LEFT JOIN item_index on
        posts.ID = item_index.PostId
    INNER JOIN L3Work on
        L3Work.UID = item_index.IndexID
    inner join UserInfo on
        UserInfo.UserName = posts.Creator
    WHERE
        posts.Status = 1
        and posts.branch = $branch
        and posts.adds = 0
        and posts.Type = 1
        and L3Work.Name = '$newscat'
    GROUP BY
        posts.id ,
        posts.Titel ,
        posts.UpTitel ,
        posts.SubTitel ,
        posts.Abstract,
        posts.Name ,
        posts.OutLink,
        posts.LinkAddress ,
        posts.MainPic ,
        UserInfo.avatar,
        posts.CrateDate,
        posts.titlePic ,
        posts.Pic ,
        posts.Content ,
        posts.CommentCount ,
        posts.ViewCount ,
        UserInfo.Name ,
        UserInfo.Family,
        L3Work.Name,
        posts.created_at

        order by posts.id desc";
        return DB::select($Query);

    }
    public function FamilyListByIndexID($IndexID)
    {
        // $Query = "SELECT UserInfo.* from `WorkerSkils` INNER JOIN `UserInfo`on UserInfo.UserName = WorkerSkils.UserName WHERE SkilID = $IndexID";
        $Query = "SELECT   m.meta_value  as target_url , UserInfo.*  from `WorkerSkils` INNER JOIN `UserInfo`on UserInfo.UserName = WorkerSkils.UserName
        left join metadata m  on  m.tt  = 'seo_url' and m.fgstr = UserInfo.UserName  WHERE SkilID = $IndexID";
        return DB::select($Query);
    }
    public static function NewsListByIndexID($UID, $Limit = null)
    {
        $branch = env('Branch');
        $MainIndex = $UID;
        $Query = "SELECT
        posts.id ,
        posts.Titel ,
        posts.UpTitel ,
        posts.SubTitel ,
        posts.Name ,
        posts.LinkAddress ,
        posts.MainPic ,
        posts.titlePic ,
        posts.Pic ,
        posts.Content ,
        posts.CommentCount ,
        posts.ViewCount ,
        L3Work.Name as indexname ,
        UserInfo.Name as CreatorName ,
        UserInfo.Family as CreatorFamily,
        posts.CrateDate,
        posts.created_at
    FROM
        posts
    LEFT JOIN item_index on
        posts.ID = item_index.PostId
    INNER JOIN L3Work on
        L3Work.UID = item_index.IndexID
    inner join UserInfo on
        UserInfo.UserName = posts.Creator
    WHERE
        posts.Status = 1
        and posts.branch = $branch
        and posts.adds = 0
        and posts.Type = 1
        and (posts.MainIndex = $MainIndex or L3Work.UID = $UID )
    GROUP BY
        posts.id ,
        posts.Titel ,
        posts.UpTitel ,
        posts.SubTitel ,
        posts.Name ,
        posts.LinkAddress ,
        posts.MainPic ,
        posts.titlePic ,
        posts.Pic ,
        posts.Content ,
        posts.CommentCount ,
        posts.ViewCount ,
        UserInfo.Name ,
        UserInfo.Family,
        L3Work.Name,
        posts.CrateDate,
        posts.created_at
        order by posts.id desc";
        return DB::select($Query);

    }

    public function AdPosts($Single = false)
    {
        if ($this->AdsPostsSource == null) {
            $branch = env('‌Branch') ?? 1;
            $AdPosts = posts::all()->where('adds', '>', 0)->where('branch', $branch)->where('Status', 1);
            $this->AdsPostsSource = $AdPosts;
        }
        if ($Single) {
            $AdPost = null;
            foreach ($this->AdsPostsSource as $AdPostsItem) {
                $AdPost = $AdPostsItem;
            }
            return $AdPostsItem;
        } else {
            return $this->AdsPostsSource;
        }
    }
}

<?php

namespace App\Http\Controllers\News;

use App\APIS\spot_player;
use App\Functions\FamilyClass;
use App\Functions\NewsClass;
use App\Functions\OrderRequestClass;
use App\Functions\TextClassMain;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Dashboard\Dashboard;
use App\Http\Controllers\setting\debuger;
use App\Models\html_object;
use App\Models\L3Work;
use App\Models\mobile_banner;
use App\Models\post_views;
use App\Models\posts;
use App\Models\product_order;
use App\Models\requests;
use App\Models\UserInfo;
use App\myappenv;
use App\Users\UserClass;
use App\view_counter\View_counter;
use Illuminate\Database\Schema\PostgresSchemaState;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;
use Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\View;

use function PHPUnit\Framework\isNumeric;

class NewsItems extends Controller
{
    private $post_url_type;
    public function familycat($familycat, Request $request)
    {

        if ($request->ajax()) {
            if ($request->input('page') == 'info') {
                $UserName = $request->input('uid');
                $Family = new OrderRequestClass($UserName);
                return view('news.Layouts.familyItemShow', ['Family' => $Family])->render();
            }
            if ($request->input('page') == 'InfoTxt') {
                $UserName = $request->input('uid');
                $UserSrc = UserInfo::where('UserName', $UserName)->first();
                $UserInfoText = json_decode($UserSrc->extradata);
                return $UserInfoText->InfoTxt;
            }
        }
        if (Auth::check()) {
            $AdminLogin = false;
            if (Auth::user()->Role == myappenv::role_SuperAdmin) {
                $AdminLogin = true;
            }
        } else {
            $AdminLogin = false;
        }
        if ($this->startsWith($familycat, 'search-')) {
            $familycat = str_replace("search-", "", $familycat);
            $searchmode = true;
        } else {
            $searchmode = false;
        }

        $DataSource = new NewsClass('newscat', $AdminLogin);
        $RelatedPosts = $DataSource->NewsListByIndexName($familycat);
        $TagMain = L3Work::where('Name', $familycat)->where('WorkCat', myappenv::FamilyWorkCat)->where('L1ID', myappenv::FamilyIndexL1)->first();
        if ($TagMain == null) {
            $FamilySrc = null;
        } else {
            $FamilySrc = $DataSource->FamilyListByIndexID($TagMain->UID);
        }

        if ($DataSource->GetMainIndex() != 0) {
            $CoverPost = posts::where('MainIndex', $DataSource->GetMainIndex())->where('Type', 2)->first();
        } else {
            $CoverPost = null;
        }
        $FamilyClass = new FamilyClass;
        return view('news.FamilyCat', ['FamilySrc' => $FamilySrc, 'FamilyClass' => $FamilyClass, 'searchmode' => $searchmode, 'CoverPost' => $CoverPost, 'CatName' => $familycat, 'DataSource' => $DataSource, 'RelatedPosts' => $RelatedPosts]);
    }
    public function Dofamilycat()
    {
    }
    private function get_related_post($posts)
    {
        if ($posts->Related != null) {
            $RelatedPosts = json_decode($posts->Related);
            $RelatedPostStr = '(';
            $LoopInit = true;
            foreach ($RelatedPosts as $RelatedPostsTarget) {
                if ($LoopInit) {
                    $RelatedPostStr .= $RelatedPostsTarget;
                    $LoopInit = false;
                } else {
                    $RelatedPostStr .= ', ' . $RelatedPostsTarget;
                }
            }
            $RelatedPostStr .= ')';
            $Query = "SELECT * from posts where posts.Status and posts.adds = 0  and id in $RelatedPostStr ";
            $Relatednews = DB::select($Query);
        } else {
            $Relatednews = null;
        }
        return $Relatednews;
    }

    public function newsgroup($newscat)
    {
        if (Auth::check()) {
            $UserLogin = 'user';
            $AdminLogin = false;
            if (Auth::user()->Role == myappenv::role_SuperAdmin) {
                $UserLogin = 'admin';
                $AdminLogin = true;
            }
        } else {
            $UserLogin = null;
            $AdminLogin = false;
        }

        $DataSource = new NewsClass('newscat', $AdminLogin);
        $Query = "SELECT
        posts.id ,
        posts.Titel ,
        posts.Name ,
        posts.LinkAddress ,
        posts.MainPic ,
        posts.titlePic ,
        posts.Pic ,
        posts.Content ,
        posts.CommentCount ,
        posts.ViewCount ,
        GROUP_CONCAT(L3Work.Name) as indexname ,
        UserInfo.Name as CreatorName ,
        UserInfo.Family as CreatorFamily,
        posts.created_at
    FROM
        L3Work
    INNER JOIN posts on
        L3Work.UID = posts.MainIndex
    inner join UserInfo on
        UserInfo.UserName = posts.Creator
    WHERE
        posts.Status = 1 and posts.adds = 0 and posts.Type = 1
    GROUP BY
        posts.id ,
        posts.Titel ,
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
        posts.created_at
        HAVING GROUP_CONCAT(L3Work.Name) like '%$newscat%'";

        $RelatedPosts = DB::select($Query);
        $TagMain = L3Work::where('Name', $newscat)->where('L2ID', myappenv::NewsCatL2)->first();
        if ($TagMain == null) {
            return abort('404');
        }
        $CoverPost = posts::where('MainIndex', $TagMain->UID)->where('Type', 2)->first();

        return view('news.NewsGroup', ['CatName' => $newscat, 'DataSource' => $DataSource, 'RelatedPosts' => $RelatedPosts, 'CoverPost' => $CoverPost]);
    }
    public function Donewsgroup($newscat, Request $request)
    {
    }
    public function NewsHometmp()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        } else {
            return redirect()->away('http://www.carpetour.com/fa/index.asp');
        }
    }
    private function NewsHome_FirstPage()
    {
        $UserLogin = 'false';
        if (Auth::check()) {
            $UserLogin = 'user';
            $AdminLogin = false;
            if (Auth::user()->Role == myappenv::role_SuperAdmin) {
                $UserLogin = 'admin';
                $AdminLogin = true;
            }
        } else {
            $UserLogin = null;
            $AdminLogin = false;
        }
        $DataSource = new NewsClass('SingleNews', $AdminLogin);
        $mobile_banners = mobile_banner::where('status', 1)->where('page', 1)->orderBy('order')->get();
        $Query = "SELECT theme from mobile_banner mb WHERE  status  =  1 and page = 1 group by theme ";
        $ElementsTypes = DB::select($Query);
        $PagesObjects = array();
        $Minis = posts::where('Status', 1)->where('mini', 1)->orderBy('id', 'DESC')->get();
        $Article = posts::where('Status', 1)->where('article', '>', 0)->first();
        if ($Article != null) {
            $ArticleWriter = UserInfo::where('UserName', $Article->Writer)->first();
            if ($ArticleWriter != null) {
                if ($ArticleWriter->avatar != null) {
                    $ArticleWriterPic = $ArticleWriter->avatar;
                    $ArticleWriterName = $ArticleWriter->Name . ' ' . $ArticleWriter->Family;
                } else {
                    $ArticleWriterPic = asset('assets/images/avtar/useravatar.png');
                    $ArticleWriterName = $ArticleWriter->Name . ' ' . $ArticleWriter->Family;
                }
            } else {
                $ArticleWriterPic = asset('assets/images/avtar/useravatar.png');
                $ArticleWriterName = $Article->Writer;
            }
        } else {
            $ArticleWriterPic = null;
            $ArticleWriterName = null;
        }
        $Largs = posts::where('Status', 1)->where('larg', 1)->orderBy('id', 'DESC')->get();
        foreach ($ElementsTypes as $ElementsTypesItem) {
            array_push($PagesObjects, $ElementsTypesItem->theme);
        }
        if (myappenv::SiteTheme == 'Theme8') {
            return view("Layouts.Theme8.MainBlog ", ['ArticleWriterName' => $ArticleWriterName, 'homepage' => 1, 'ArticleWriterPic' => $ArticleWriterPic, 'Article' => $Article, 'Minis' => $Minis, 'Largs' => $Largs, 'mobile_banners' => $mobile_banners, 'ElementsTypes' => $ElementsTypes, 'PagesObjects' => $PagesObjects, 'DataSource' => $DataSource, 'UserLogin' => $UserLogin]);

        }
        return view('news.mainpage', ['ArticleWriterName' => $ArticleWriterName, 'homepage' => 1, 'ArticleWriterPic' => $ArticleWriterPic, 'Article' => $Article, 'Minis' => $Minis, 'Largs' => $Largs, 'mobile_banners' => $mobile_banners, 'ElementsTypes' => $ElementsTypes, 'PagesObjects' => $PagesObjects, 'DataSource' => $DataSource, 'UserLogin' => $UserLogin]);
    }
    private function NewsHome_InnerPage()
    {
        $UserLogin = 'false';
        if (Auth::check()) {
            $UserLogin = 'user';
            $AdminLogin = false;
            if (Auth::user()->Role == myappenv::role_SuperAdmin) {
                $UserLogin = 'admin';
                $AdminLogin = true;
            }
        } else {
            $UserLogin = null;
            $AdminLogin = false;
        }
        $DataSource = new NewsClass('SingleNews', $AdminLogin);
        $Article = posts::where('Status', 1)->where('mini', 1)->orderBy('id', 'DESC')->paginate(10);
        $TargetTheme = myappenv::SiteTheme;
        return view("Layouts.$TargetTheme.newslist", ['Article' => $Article, 'DataSource' => $DataSource, 'UserLogin' => $UserLogin]);
    }
    public function NewsHome()
    {
        if (!myappenv::Lic['news']) {
            return abort('404');
        }
        if (Session::has('TargetVeiw')) {
            $TargetView = Session::get('TargetVeiw');
            if ($TargetView == 'Site') {
                $SiteView = true;
            } else {
                $SiteView = false;
            }
        } else {
            $SiteView = false;
        }

        if (!$SiteView && Auth::check() && Auth::user()->Role != myappenv::role_customer) {
            return redirect()->route('dashboard');
            $my_dashboard = new Dashboard;

            return $my_dashboard->CustomerDashboard();
        }

        if (myappenv::MainPage == 'news' || myappenv::SiteTheme == 'Theme8') {
            return $this->NewsHome_FirstPage();
        } else {
            return $this->NewsHome_InnerPage();
        }
    }
    public function update_post_comments_count($comment_id)
    {
        $comment_src = post_views::where('id', $comment_id)->first();
        $post_id = $comment_src->Post;
        $comment_count = post_views::where('Post', $post_id)->where('Status', 100)->count();
        posts::where('id', $post_id)->update(['CommentCount' => $comment_count]);
        return true;
    }

    public function DoNewsHome()
    {
    }
    function startsWith($string, $startString)
    {
        $len = strlen($startString);
        return (substr($string, 0, $len) === $startString);
    }
    public function newscat($newscat)
    {
        $mytext = new TextClassMain;
        $newscat = $mytext->StripText($newscat);
        if ($newscat == '') {
            return abort('404');
        }
        if (Auth::check()) {
            $UserLogin = 'user';
            $AdminLogin = false;
            if (Auth::user()->Role == myappenv::role_SuperAdmin) {
                $UserLogin = 'admin';
                $AdminLogin = true;
            }
        } else {
            $UserLogin = null;
            $AdminLogin = false;
        }
        if ($this->startsWith($newscat, 'search-')) {
            $newscat = str_replace("search-", "", $newscat);
            $searchmode = true;
        } else {
            $searchmode = false;
        }
        $DataSource = new NewsClass('newscat', $AdminLogin);

        $RelatedPosts = $DataSource->NewsListByIndexName($newscat);

        $TagMain = L3Work::where('Name', $newscat)->first();
        if ($DataSource->GetMainIndex() != 0) {
            if (Session::get('testdebug')) {
                echo ('CatMain =' . $DataSource->GetMainIndex());
            }
            $CoverPost = posts::where('MainIndex', $DataSource->GetMainIndex())->where('Type', 2)->first();
        } else {
            $CoverPost = $DataSource->get_related_cover($newscat);
        }
        if (myappenv::DashboardTheme == 'Theme2') {
            return view('Theme2.NewsCat', ['searchmode' => $searchmode, 'CoverPost' => $CoverPost, 'CatName' => $newscat, 'DataSource' => $DataSource, 'RelatedPosts' => $RelatedPosts]);
        }
        $Theme = myappenv::SiteTheme;
        if (View::exists("Layouts.$Theme.NewsCat")) {
            return view("Layouts.$Theme.NewsCat", ['searchmode' => $searchmode, 'CoverPost' => $CoverPost, 'CatName' => $newscat, 'DataSource' => $DataSource, 'RelatedPosts' => $RelatedPosts]);
        }
        return view('news.NewsCat', ['searchmode' => $searchmode, 'CoverPost' => $CoverPost, 'CatName' => $newscat, 'DataSource' => $DataSource, 'RelatedPosts' => $RelatedPosts]);
    }

    public function Donewscat()
    {
    }

    public function DoShowNewsItem(Request $request, $NewsId, $newsitem = null)
    {

        if ($request->has('view_submit')) {
            $MobileNumber = strip_tags($request->input('MobileNumber'));
            $name = strip_tags($request->input('name'));
            if (Auth::check()) {
                $message = strip_tags($request->input('message'));
                $ViewsData = [
                    'name' => $name,
                    'email' => $request->input('WriterEmail'),
                    'MobileNumber' => $MobileNumber,
                    'UserName' => Auth::id(),
                    'message' => $message,
                    'Post' => $request->input('view_submit'),
                ];
            } else {
                $message = strip_tags($request->input('message'));
                $ViewsData = [
                    'name' => $name,
                    'email' => $request->input('WriterEmail') ?? '',
                    'MobileNumber' => $MobileNumber,
                    'message' => $message,
                    'Post' => $request->input('view_submit'),
                ];
            }
            $result = post_views::create($ViewsData);
            post_views::where('id', $result->id)->update(['refrence' => $result->id]);
            if (myappenv::SiteTheme == 'Theme6') {
                return view('Layouts.Theme6.NotificationPage');
            }
            return redirect()->back()->with('success', 'دیدگاه شما ثبت شد ، پس از بررسی مدیر سایت منتشر خواهد شد!');
        } elseif ($request->has('publish_view')) {
            post_views::where('id', $request->input('publish_view'))->update(['Status' => 100]);
            $this->update_post_comments_count($request->input('publish_view'));
            return redirect()->back()->with('success', 'نظر ثبت شده تایید شد!');
        } elseif ($request->has('Delete_view')) {
            post_views::where('id', $request->input('Delete_view'))->update(['Status' => 0]);
            return redirect()->back()->with('success', 'نظر ثبت شده حذف شد!');
        } elseif ($request->has('publish_answer')) {
            $SourceView = post_views::where('id', $request->input('publish_answer'))->first();
            $ViewsData = [
                'name' => $request->input('name'),
                'email' => $request->input('WriterEmail'),
                'MobileNumber' => $request->input('MobileNumber'),
                'UserName' => Auth::id(),
                'message' => $request->input('message'),
                'Post' => $SourceView->Post,
                'Status' => 100,
                'refrence' => $request->input('publish_answer')
            ];
            $result = post_views::create($ViewsData);
            return redirect()->back()->with('success', 'پاسخ شما ثبت شد !');
        }
        if ($request->has('submit')) {
            if ($request->submit == 'pay') {
                if (!Auth::check()) {
                    return redirect()->back()->with('error', 'جهت پرداخت می باید به سامانه وارد شوید!');
                }
                $Note = 'خرید مطلب شماره' . $NewsId;
                $price_attr = $this->for_buy_news($NewsId, null);
                $price = $price_attr['price'];
                $token = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 10)), 0, 10);
                $ResNum = 40;             // for post buy
                Session::put('price', $price);
                Session::put('ResNum', $ResNum);
                Session::put('target_post', $NewsId);
                Session::put('finoward_token', $token);
                Session::put('Note', $Note);
                $amount = $price; // مبلغ فاكتور
                $redirectAddress = route('finpay');
                $invoiceNumber = $ResNum; //شماره فاكتور
                $timeStamp = date("Y/m/d H:i:s");
                $invoiceDate = date("Y/m/d H:i:s"); //تاريخ فاكتور
                $action = "1003";    // 1003 : براي درخواست خريد
                $Mobile = Auth::user()->MobileNo;
                echo "<form id='peppeyment' action='https://finoward.ir/ipg.php' method='post'>
                <input  type='text' name='token' value='$token' /><br />
                <input  type='text' name='amount' value='$amount' /><br />
                <input  type='text' name='redirectAddress' value='$redirectAddress' /><br />
                <input  name='mobile' value='$Mobile' /><br />
                <input  type='text' name='Note' value='$Note' /><br />
                <button type='submit'>انتقال به درگاه  </button>
                </form><script>document.forms['peppeyment'].submit()</script>";
            }
        } else {
            return abort('404');
        }
    }
    private function return_post_by_id($post_id, $UserLogin)
    {

        if ($UserLogin == null || $UserLogin == 'user') {
            $posts = posts::where('id', $post_id)->where('branch', myappenv::Branch)->where('Status', 1)->where('type', 1)->first();
        } elseif ($UserLogin == 'admin') {
            $posts = posts::where('id', $post_id)->where('type', 1)->first();
        }
        if ($posts == null) {
            return [
                'post_id' => null,
                'post_src' => null
            ];
        }
        if ($posts->OutLink != null) { // the post use seo frindly url
            return [
                'post_id' => null,
                'post_src' => null
            ];
        }

        return [
            'post_id' => $posts->id ?? null,
            'post_src' => $posts
        ];
    }
    private function return_post_by_name($post_id, $UserLogin)
    {
        if ($UserLogin == null || $UserLogin == 'user') {
            $posts = posts::where('OutLink', $post_id)->where('branch', myappenv::Branch)->where('Status', 1)->where('type', 1)->first();
        } elseif ($UserLogin == 'admin') {
            $posts = posts::where('OutLink', $post_id)->where('type', 1)->first();
        }
        if ($posts == null) {
            return [
                'post_id' => null,
                'post_src' => null
            ];
        }
        return [
            'post_id' => $posts->id,
            'post_src' => $posts
        ];
    }
    private function get_target_post($post_id, $UserLogin)
    {
        if (is_numeric($post_id)) {
            $this->post_url_type = 'numeric';
            return $this->return_post_by_id($post_id, $UserLogin);
        }
        $this->post_url_type = 'exact';
        return $this->return_post_by_name($post_id, $UserLogin);
    }
    private function redirect_force($Titel, $newsitem)
    {
        if ($this->post_url_type == 'numeric') {
            if ($Titel != $newsitem) {
                return true;
            }
        }
        return false;

    }

    public function ShowNewsItem(Request $request, $NewsId, $newsitem = null)
    {



        $spot_player = [];
        if (!myappenv::Lic['news']) {
            return abort('404');
        }
        $user_class = new UserClass;
        $user_src = $user_class->who_is_login();
        $UserLogin = $user_src['UserLogin'];
        $AdminLogin = $user_src['UserLogin'];
        $DataSource = new NewsClass('SingleNews', $AdminLogin);
        $posts_src = $this->get_target_post($NewsId, $UserLogin);
        $posts = $posts_src['post_src'];
        $NewsId = $posts_src['post_id'];
        if ($posts == null) {
            return abort('404');
        }
        if ($this->redirect_force($posts->Titel, $newsitem)) {
            return redirect()->route('ShowNewsItem', ['NewsId' => $NewsId, 'newsitem' => $posts->Titel]);
        }
        $view_counter = new View_counter;
        $view_counter->increment_view('post', $NewsId);
        $Auther = UserInfo::where('UserName', $posts->Creator)->first();
        $WorkCat = myappenv::PostIndexWorkCat;
        $L1ID = myappenv::NewsIndexL1;
        $L2ID = myappenv::NewsIndexL2;
        $L1IDCat = myappenv::NewsCatL1;
        $L2IDCat = myappenv::NewsCatL2;
        $Query = "SELECT * FROM L3Work inner JOIN item_index  on item_index.IndexID = L3Work.UID WHERE item_index.PostId = $NewsId  and WorkCat = $WorkCat and L1ID = $L1ID and L2ID = $L2ID ";
        $Tags = DB::select($Query);
        $cats = L3Work::where('UID', $posts->MainIndex)->First();
        if ($cats == null) {
            $CatName = 'بدون دسته بندی';
        } else {
            $CatName = $cats->Name;
        }
        $Relatednews = $this->get_related_post($posts);
        $MyCommnets = new NewsAdmin();
        if (Auth::check() && Auth::user()->Role == myappenv::role_SuperAdmin) {
            $Views = $MyCommnets->GetComments('All', $NewsId);
        } else {
            $Views = $MyCommnets->GetComments('Comfirmd', $NewsId);
        }
        if (myappenv::SiteTheme == 'news247') {
            return view('news.SingleNews', ['DataSource' => $DataSource, 'Views' => $Views, 'UserLogin' => $UserLogin, 'posts' => $posts, 'Auther' => $Auther, 'Tags' => $Tags, 'CatName' => $CatName, 'Relatednews' => $Relatednews]);
        } else {
            $Theme = myappenv::SiteTheme;
            return view("Layouts.$Theme.SingleNews", ['spot_player' => $spot_player, 'for_buy_news' => $this->for_buy_news($NewsId, $posts), 'DataSource' => $DataSource, 'Views' => $Views, 'UserLogin' => $UserLogin, 'posts' => $posts, 'Auther' => $Auther, 'Tags' => $Tags, 'CatName' => $CatName, 'Relatednews' => $Relatednews]);
        }

    }
    private function for_buy_news($post_id, $post_src)
    {
        $buy_before = false;
        if ($post_src == null) {
            $post_src = posts::where('id', $post_id)->first();
        }
        $price = $post_src->Price;
        if ($price == 0) {
            $is_buyable = false;
        } else {
            $is_buyable = true;
        }
        if ($is_buyable) {
            $buy_before_src = product_order::where('status', 1)->where('VirtualContract', $post_id)->where('CustomerId', Auth::id())->first();
            if ($buy_before_src == null) {
                $buy_before = false;
            } else {
                $buy_before = true;
            }
        }
        return [
            'is_buyable' => $is_buyable,
            'buy_before' => $buy_before,
            'price' => $price,
        ];
    }
}

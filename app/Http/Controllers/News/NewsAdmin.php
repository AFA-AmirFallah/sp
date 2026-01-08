<?php

namespace App\Http\Controllers\News;

use App\Functions\Indexes;
use App\Functions\NewsClass;
use App\Functions\persian;
use App\Http\Controllers\Controller;
use App\Models\branches;
use App\Models\html_object;
use App\Models\L3Work;
use App\Models\post_views;
use App\Models\posts;
use App\Models\UserRole;
use App\myappenv;
use App\SEO\meta_keyword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;


class NewsAdmin extends Controller
{
    private function update_post_comments_count_with_post_id($post_id)
    {
        $comment_count = post_views::where('Post', $post_id)->where('Status', 100)->count();
        posts::where('id', $post_id)->update(['CommentCount' => $comment_count]);
        return true;
    }
    public function udpdate_all_post_comment_count()
    {
        $Query = "SELECT pv.Post from post_views pv where pv.Status = 100  GROUP BY pv.Post ";
        $post_with_comment_src = DB::select($Query);
        foreach ($post_with_comment_src as $post) {
            $post_id = $post->Post;
            $this->update_post_comments_count_with_post_id($post_id);
        }
    }
    public function editComment($commentID)
    {
        $Comment = post_views::where('id', $commentID)->first();
        return view('news.EditComments', ['Comment' => $Comment]);
    }
    public function DoeditComment(Request $request, $commentID)
    {
        if ($request->input('submit') == 'edit') {
            if ($request->has('name')) { // user Comments
                $Data = [
                    'name' => $request->input('name'),
                    'email' => $request->input('email'),
                    'MobileNumber' => $request->input('MobileNumber'),
                    'message' => $request->input('message')
                ];
                post_views::where('id', $commentID)->update($Data);
                return redirect()->route('ShowNewsItem', ['NewsId' => $request->input('Post')]);
            } else { //admin replay comment
                post_views::where('id', $commentID)->update(['message' => $request->input('message')]);
                return redirect()->route('ShowNewsItem', ['NewsId' => $request->input('Post')]);
            }
        }
        if ($request->input('submit') == 'delete') {
            $Comment = post_views::where('id', $commentID)->first();
            if ($Comment->id == $Comment->refrence) { // the comment is source comment and may has replay
                post_views::where('refrence', $commentID)->update(['Status' => 1]);
                return redirect()->route('ShowNewsItem', ['NewsId' => $request->input('Post')]);
            } else {
                post_views::where('id', $commentID)->update(['Status' => 1]);
                return redirect()->route('ShowNewsItem', ['NewsId' => $request->input('Post')]);
            }
        }
    }
    private function primary_search_news(Request $request)
    {
        $RelatedArr = null;
        $TargetSelected = null;
        $SelectPost = null;
        $MyPersian = new persian;
        $condition = '';
        $Titel = $request->Titel;
        $ListType = $request->news_type ?? 'news';
        switch ($ListType) {
            case 'news':
                $PageTitle = 'اخبار';
                $howview = true;
                break;
            case 'banners':
                $condition = " and  posts.adds > 0";
                $PageTitle = 'بنر ها';
                $howview = false;
                break;
            case 'hotnews':
                $condition = " and  posts.hotnews ";
                $PageTitle = 'اخبار داغ';
                $howview = true;
                break;
            case 'ads':
                $condition = " and adds > 0";
                $PageTitle = 'تبلیغات';
                $howview = true;
                break;
            case 'covers':
                $PageTitle = 'پوشش';
                $howview = true;
                break;
            case 'family':
                $condition = " and Type = 12";
                $PageTitle = 'خانواده فرش';
                $howview = true;
                break;
        }

        $status = $request->status;
        if ($status != null) {
            $condition .= " and posts.Status <= $status";
        }
        $Creator = $request->Creator;
        if ($Creator != null) {
            $condition .= " and posts.Creator = '$Creator'";
        }
        $StartDate = $request->StartDate;
        if ($StartDate != null) {
            $TargetDate = $MyPersian->MiladiDate($StartDate);
            $condition .= " and  posts.CrateDate >=  '$TargetDate' ";
        }
        $EndDate = $request->EndDate;
        if ($EndDate != null) {
            $TargetDate = $MyPersian->MiladiDate($EndDate);
            $condition .= " and  posts.CrateDate <=  '$TargetDate' ";
        }
        if ($ListType == 'covers') {
            $Query = "select  L3Work.Name  as TagName , posts.*,news_views_view.views_count  , branches.Name as branch_name
            from posts inner join branches on branches.id = posts.branch
            left join news_views_view on posts.id = news_views_view.Post inner join L3Work on posts.MainIndex = L3Work.UID
            and news_views_view.Status = 1
            where posts.Status is not null and posts.Type is not null
            $condition  ";

        } else {
            $Query = "select posts.*,news_views_view.views_count  , branches.Name as branch_name
            from posts inner join branches on branches.id = posts.branch
            left join news_views_view on posts.id = news_views_view.Post
            and news_views_view.Status = 1
            where posts.Status is not null and posts.Type is not null
            $condition  ";
        }
        $News = DB::select($Query);
        return view("news.NewsList", ['RelatedArr' => $RelatedArr, 'TargetSelected' => $TargetSelected, 'SelectPost' => $SelectPost, 'News' => $News, 'PageTitle' => $PageTitle, 'Showview' => $howview, 'ListType' => $ListType]);


    }

    public function DoNewsList(Request $request)
    {

        if ($request->has('select')) {
            Session::put('SelectPost', $request->input('select'));
            return redirect()->back();
        } elseif ($request->has('forget')) {
            Session::put('SelectPost', null);
            return redirect()->back();
        } elseif ($request->has('submit')) {
            if ($request->submit == 'primary') { // primary search
                return $this->primary_search_news($request);
            }
            if ($request->input('submit') == 'SaveRelated') {
                $TargetPost = Session::get('SelectPost');
                $RelatedArr = array();
                if ($request->has('Related')) {
                    $Related = $request->input('Related');
                    foreach ($Related as $RelatedItem) {
                        array_push($RelatedArr, $RelatedItem);
                    }
                    $RelatedJson = json_encode($RelatedArr);
                    $SavedData = [
                        'Related' => $RelatedJson,
                    ];
                } else {
                    $SavedData = [
                        'Related' => null,
                    ];
                }

                posts::where('id', $TargetPost)->update($SavedData);
                return redirect()->back()->with('success', 'خبر های مرتبط به روز رسانی گردید!');
            }
            if ($request->input('submit') == 'SaveRelatedBack') {
                $TargetPost = Session::get('SelectPost');
                $Related = $request->input('Related');
                foreach ($Related as $RelatedItem) {
                    $targetPostchange = posts::where('id', $RelatedItem)->first();
                    if ($targetPostchange->Related == null || $targetPostchange->Related == '') {
                        $RelatedArr = array();
                    } else {
                        $RelatedArr = json_decode($targetPostchange->Related);
                    }
                    array_push($RelatedArr, $RelatedItem);
                    $RelatedJson = json_encode($RelatedArr);
                    $SavedData = [
                        'Related' => $RelatedJson,
                    ];
                    posts::where('id', $RelatedItem)->update($SavedData);
                }
                return redirect()->back()->with('success', 'خبر های مرتبط به روز رسانی گردید!');
            }
        }
    }

    public function EditTagCover($TagID)
    {
        $WorkCat = myappenv::PostIndexWorkCat;
        $L1ID = myappenv::NewsIndexL1;
        $L2ID = myappenv::NewsIndexL2;
        $L1IDCat = myappenv::NewsCatL1;
        $L2IDCat = myappenv::NewsCatL2;
        $Query = "SELECT * FROM L3Work LEFT JOIN item_index  on item_index.IndexID = L3Work.UID WHERE (item_index.PostId = $TagID or item_index.PostId is null) and WorkCat = $WorkCat and L1ID = $L1IDCat and L2ID = $L2IDCat ";
        $cats = DB::select($Query);
        $Query = "SELECT * FROM L3Work LEFT JOIN item_index  on item_index.IndexID = L3Work.UID WHERE (item_index.PostId = $TagID or item_index.PostId is null) and WorkCat = $WorkCat and L1ID = $L1ID and L2ID = $L2ID ";
        //$Tags = DB::select($Query);
        $Tags = L3Work::all()->where('WorkCat', $WorkCat)->where('L1ID', $L1ID)->where('L2ID', $L2ID);
        $Query = "select * from posts where Status < 100 and MainIndex = $TagID and (type = 2 or Type = 3)";
        $result = DB::select($Query);
        foreach ($result as $resultItem) {
            $News = $resultItem;
        }
        return view("news.EditTagCover", ['News' => $News, 'Tags' => $Tags, 'cats' => $cats]);
    }
    public function DoEditTagCover(Request $request, $TagID)
    {

        $request->validate([
            'Titel' => 'required',
            'Name' => 'required',
            'pic' => 'required',
        ], [
            'Titel.required' => 'مشخص سازی تایتل الزامی است!',
            'Name.required' => 'مشخص سازی نام الزامی است!',
            'pic.required' => 'مشخص سازی تصویر الزامی است!',
        ]);
        if ($request->input('NewsCat') != 0) {
            $type = 2;
            $TargetIndex = $request->input('NewsCat');
        }
        if ($request->input('SelectTags') != 0) {
            $type = 3;
            $TargetIndex = $request->input('SelectTags');
        }
        $content = $request->input('ce');
        $content = preg_replace('/font-family.+?;/', "", $content);

        $DataToSave = [
            'Titel' => $request->input('Titel'),
            'Name' => $request->input('Name'),
            'LinkAddress' => $request->input('Name'),
            'MainPic' => $request->input('pic'),
            'Content' => $content,
            'Type' => $type,
            'MainIndex' => $TargetIndex,
        ];
        $Result = posts::where('id', $TagID)->update($DataToSave);
        return redirect()->route('NewsList', ['ListType' => 'covers'])->with('success', 'پوشش شماره ' . $TagID . ' ویرایش شد ! ');
    }
    public function MakeTagCover($TagID = null)
    {
        /**
         * Tag cover Post with type 2 for main index and type 3 for index - and main index id is tag id to cover
         */
        $WorkCat = myappenv::PostIndexWorkCat;
        $L1ID = myappenv::NewsIndexL1;
        $L2ID = myappenv::NewsIndexL2;
        $L1IDCat = myappenv::NewsCatL1;
        $L2IDCat = myappenv::NewsCatL2;
        $FamilyWorkCat = myappenv::FamilyWorkCat;
        $FamilyIndexL1 = myappenv::FamilyIndexL1;
        $FamilyIndexL2 = myappenv::FamilyIndexL2;
        $cats = L3Work::all()->where('WorkCat', $WorkCat)->where('L1ID', $L1IDCat)->where('L2ID', $L2IDCat);
        $Tags = L3Work::all()->where('WorkCat', $WorkCat)->where('L1ID', $L1ID)->where('L2ID', $L2ID);
        $Family = L3Work::all()->where('WorkCat', $FamilyWorkCat)->where('L1ID', $FamilyIndexL1)->where('L2ID', $FamilyIndexL2);
        return view("news.MakeTagCover", ['Family' => $Family, 'Tags' => $Tags, 'cats' => $cats]);
    }
    public function DoMakeTagCover(Request $request, $TagID = null)
    {
        $request->validate([
            'Titel' => 'required',
            'pic' => 'required',
        ], [
            'Titel.required' => 'مشخص سازی تایتل الزامی است!',
            'pic.required' => 'مشخص سازی تصویر الزامی است!',
        ]);
        $type = 2;
        $TargetIndex = $TagID;
        if ($request->input('NewsCat') != 0) {
            $type = 2;
            $TargetIndex = $request->input('NewsCat');
        }
        if ($request->input('SelectTags') != 0) {
            $type = 3;
            $TargetIndex = $request->input('SelectTags');
        }
        if ($request->input('FamilyTags') != 0) {
            $type = 3;
            $TargetIndex = $request->input('FamilyTags');
        }
        $content = $request->input('ce');
        $content = preg_replace('/font-family.+?;/', "", $content);

        $DataToSave = [
            'SubTitel' => $request->input('SubTitel'),
            'Titel' => $request->input('Titel'),
            'UpTitel' => $request->input('UpTitel'),
            'Name' => $request->input('Titel'),
            'LinkAddress' => $request->input('Titel'),
            'MainPic' => $request->input('pic'),
            'Lead' => $request->input('Titel'),
            'Content' => $content,
            'Creator' => Auth::id(),
            'Status' => 0,
            'Type' => $type,
            'Writer' => Auth::id(),
            'MainIndex' => $TargetIndex,
            'CrateDate' => now(),
            'paernt' => 0,
            'hotnews' => 0,
            'adds' => 0,
            'CommentCount' => 0
        ];
        $Result = posts::create($DataToSave);
        if ($Result->id != null) {
            return redirect()->route('NewsList', ['ListType' => 'covers'])->with('success', 'پوشش شماره ' . $Result->id . ' اضافه شد ! ');
        }
    }
    public function ConfigNews($NewsID)
    {
        $News = posts::where('Type', 1)->where('Status', '<', 100)->where('id', $NewsID)->First();
        return view('news.NewsConfig', ['News' => $News]);
    }
    public function DoConfigNews(Request $request, $NewsID)
    {

        if ($request->input('submit') == 'ChangeTime') {
            $request->validate([
                'NewsDate' => 'required',
                'NewsTime' => 'required',
            ], [
                'NewsDate.required' => 'مشخص سازی تاریخ الزامی است!',
                'NewsTime.required' => 'مشخص سازی زمان الزامی است!',
            ]);
            $MyPersian = new persian();

            $NewsTime = $MyPersian->MyMiladiDateTime($request->input('NewsDate'), $request->input('NewsTime'));
            $result = posts::where('id', $NewsID)->update(['created_at' => $NewsTime]);
            if ($result == 1) {
                return redirect()->back()->with('success', __("زمان تولید تغییر کرد!"));
            } else {
                return redirect()->back()->with('error', __("بروز مشکل در اجرای درخواست!"));
            }
        }
    }
    public function MenuWorks()
    {

        $newsmenu = html_object::where('htmlname', 'newsmenu')->first();
        if ($newsmenu == null) {
            $HtmlMenuData = [
                'htmlname' => 'newsmenu',
                'htmlobj' => ''
            ];
            html_object::create($HtmlMenuData);
            $newsmenu = html_object::where('htmlname', 'newsmenu')->first();
        }

        return view('news.ManageMenu', ['newsmenu' => $newsmenu]);
    }

    public function DoMenuWorks(Request $request)
    {
        $DataToSave = [
            'htmlobj' => $request->input('myobject')
        ];
        html_object::where('htmlname', 'newsmenu')->update($DataToSave);
        return redirect()->back()->with('success', __("success alert"));
    }

    public function EditNews($NewsID)
    {
        $key_words = new meta_keyword;
        $WorkCat = myappenv::PostIndexWorkCat;
        $L1ID = myappenv::NewsIndexL1;
        $L2ID = myappenv::NewsIndexL2;
        $L1IDCat = myappenv::NewsCatL1;
        $L2IDCat = myappenv::NewsCatL2;
        $Query = "SELECT * FROM L3Work LEFT JOIN item_index  on item_index.IndexID = L3Work.UID WHERE (item_index.PostId = $NewsID or item_index.PostId is null) and WorkCat = $WorkCat and L1ID = $L1IDCat and L2ID = $L2IDCat ";
        $cats = DB::select($Query);
        $UserLevel = UserRole::all();
        $Tags = $key_words->get_item_tags($NewsID, 1);
        $News = posts::where('id', $NewsID)->First();
        $branch_src = branches::all();
        // dd($cats , $News);
        return view("news.EditNews", ['News' => $News, 'Tags' => $Tags, 'cats' => $cats, 'branch_src' => $branch_src, 'UserLevel' => $UserLevel]);
    }
    private function change_post_status($post_id, $target_status)
    {
        $DataToSave = [
            'Status' => $target_status
        ];
        $Result = posts::where('id', $post_id)->update($DataToSave);
    }


    public function DoEditNews($NewsID, Request $request)
    {

        if ($request->has('change_state')) {
            $this->change_post_status($NewsID, $request->change_state);
            return redirect()->back()->with('successs', 'تغییر وضعیت موفق');
        }
        $request->validate([
            'Titel' => 'required',
            'pic' => 'required',
        ], [
            'Titel.required' => 'مشخص سازی تایتل الزامی است!',
            'pic.required' => 'مشخص سازی تصویر الزامی است!',
        ]);
        if ($request->input('NewsCat') == __('--select--')) {
            return redirect()->back()->withErrors('مشخص سازی دسته خبر الزامی است!')->withInput();
        }
        $post_orginal = posts::where('id', $NewsID)->first();
        if ($post_orginal->OutLink != $request->input('OutLink')) {
            if (!$this->check_outlink_not_exsit($request->input('OutLink'))) {
                return redirect()->back()->with('error', 'آدرس خارجی از پیش وجود داشته اشت.');
            }
        }


        if ($request->has('hotnews')) {
            $hotnews = 1;
        } else {
            $hotnews = 0;
        }
        if ($request->has('mostview')) {
            $mostview = 1;
        } else {
            $mostview = 0;
        }
        if ($request->has('galery')) {
            $galery = 1;
        } else {
            $galery = 0;
        }
        if ($request->has('article')) {
            $article = $request->article;
        } else {
            $article = 0;
        }
        if ($request->has('sami_index')) {
            $sami_index = true;
        } else {
            $sami_index = false;
        }
        if ($request->has('mini')) {
            $mini = 1;
        } else {
            $mini = 0;
        }
        if ($request->has('larg')) {
            $larg = 1;
        } else {
            $larg = 0;
        }
        if ($request->has('lastnews')) {
            $lastnews = 1;
        } else {
            $lastnews = 0;
        }
        if ($request->has('adds_Itself')) {
            $adds = 1;
        } elseif ($request->has('adds_Direct')) {
            $adds = 2;
        } elseif ($request->has('mainbanner')) {
            $adds = 3;
        } else {
            $adds = 0;
        }
        if ($request->has('Newslater')) {
            $Newslater = 1;
        } else {
            $Newslater = 0;
        }

        if ($request->input('ce') != null) {
            $content = $request->input('ce');
            $content = preg_replace('/font-family.+?;/', "", $content);
            $content = preg_replace('/font-family.+?/', "", $content);
        } else {
            $content = '';
        }
        if ($request->has('CloseComment')) {
            $Comment = -1;
        } else {
            $Comment = 0;
        }
        $TagResult = L3Work::where('Name', $request->input('NewsCat'))->where('WorkCat', myappenv::PostIndexWorkCat)->where('L1ID', myappenv::NewsCatL1)->where('L2ID', myappenv::NewsCatL2)->first();
        if ($TagResult == null) {
            $L3Data = [
                'WorkCat' => myappenv::PostIndexWorkCat,
                'L1ID' => myappenv::NewsCatL1,
                'L2ID' => myappenv::NewsCatL2,
                'L3ID' => myappenv::NewsCatL2,
                'Name' => $request->input('NewsCat'),
                'Description' => '',
                'img' => ''
            ];
            $TargetL3work = L3Work::create($L3Data);
            $TargetL3work = $TargetL3work->id;
        } else {
            $TargetL3work = $TagResult->UID;
        }
        $MyPersian = new persian();
        $CreateDate = $MyPersian->EnglishNumber($request->input('CreateDate'));
        $CreateTime = $MyPersian->MiladiDate($CreateDate);
        $branch = myappenv::Branch;
        if (myappenv::Lic['MultiBranch']) {
            $branch = $request->target_branch;
        }

        if ($Comment == -1) {
            $DataToSave = [
                'Abstract' => $request->input('Abstract'),
                'adds' => $adds,
                'CommentCount' => $Comment,
                'Content' => $content,
                'ContentAccessLevel' => $request->input('ContentAccessLevel'),
                'CrateDate' => $CreateTime,
                'ExtTranslater' => $request->input('ExtTranslater'),
                'description' => $request->input('description'),
                'ExtWriter' => $request->input('ExtWriter'),
                'hotnews' => $hotnews,
                'Lead' => $request->input('Titel'),
                'LinkAddress' => $request->input('Titel'),
                'MainPic' => $request->input('pic'),
                'Name' => $request->input('Titel'),
                'Newsletter' => $Newslater,
                'OutLink' => $request->input('OutLink'),
                'PostContent' => $request->input('PostContent'),
                'Price' => $request->input('Price'),
                'CreatorPrice' => $request->input('CreatorPrice'),
                'RefLink' => $request->input('RefLink'),
                'RefName' => $request->input('RefName'),
                'SubTitel' => $request->input('SubTitel'),
                'Titel' => $request->input('Titel'),
                'TitleAccessLevel' => $request->input('TitleAccessLevel'),
                'UpTitel' => $request->input('UpTitel'),
                'mostview' => $mostview,
                'lastnews' => $lastnews,
                'MainIndex' => $TargetL3work,
                'galery' => $galery,
                'article' => $article,
                'mini' => $mini,
                'larg' => $larg,
                'sami_index' => $sami_index,
                'branch' => $branch,
                'Writer' => $request->input('Writer') ?? Auth::id()
            ];
        } else {
            $DataToSave = [
                'Abstract' => $request->input('Abstract'),
                'adds' => $adds,
                'Content' => $content,
                'ContentAccessLevel' => $request->input('ContentAccessLevel'),
                'CrateDate' => $CreateTime,
                'ExtTranslater' => $request->input('ExtTranslater'),
                'description' => $request->input('description'),
                'ExtWriter' => $request->input('ExtWriter'),
                'hotnews' => $hotnews,
                'Lead' => $request->input('Titel'),
                'LinkAddress' => $request->input('Titel'),
                'MainPic' => $request->input('pic'),
                'Name' => $request->input('Titel'),
                'Newsletter' => $Newslater,
                'OutLink' => $request->input('OutLink'),
                'PostContent' => $request->input('PostContent'),
                'Price' => $request->input('Price'),
                'CreatorPrice' => $request->input('CreatorPrice'),
                'RefLink' => $request->input('RefLink'),
                'RefName' => $request->input('RefName'),
                'SubTitel' => $request->input('SubTitel'),
                'Titel' => $request->input('Titel'),
                'TitleAccessLevel' => $request->input('TitleAccessLevel'),
                'UpTitel' => $request->input('UpTitel'),
                'MainIndex' => $TargetL3work,
                'mostview' => $mostview,
                'lastnews' => $lastnews,
                'galery' => $galery,
                'article' => $article,
                'mini' => $mini,
                'larg' => $larg,
                'sami_index' => $sami_index,
                'branch' => $branch,
                'Writer' => $request->input('Writer') ?? Auth::id()
            ];
        }
        $Result = posts::where('id', $NewsID)->update($DataToSave);

        if (myappenv::wordpress_site) {
            $post_item = Posts::find($NewsID);
            if ($post_item && $post_item->wordpress_post_id !== null) {
                $wordpress_result = $this->EditNewsWordpress($request, $NewsID);
            }

        }
        if ($request->has('SelectTags')) {
            $my_keywords = new meta_keyword;
            $my_keywords->add_meta_keyword_to_item($request->input('SelectTags'), $NewsID, myappenv::NewsItemIndexType);
        }
        $post_source = posts::find($NewsID);
        if ($post_source->Type == 1 && $post_source->Status == 1) {
            $news_class = new NewsClass('SingleNews', true);
            $news_class->post_after_update_jobs($NewsID);
        }
        if ($request->input('OutLink') != null) {
            return redirect()->route('ShowNewsItem', ['NewsId' => $request->input('OutLink')])->with('success', 'ویرایش انجام شد!');
        }

        return redirect()->route('ShowNewsItem', ['NewsId' => $NewsID])->with('success', 'ویرایش انجام شد!');
    }
    private function show_news_search()
    {
        $MyIndex = new Indexes();
        $IndexNewsTree = $MyIndex->HTMLNewsTreeIndex();
        $IndexTree = $MyIndex->HTMLTreeIndex_cover_admin();
        $Query = "select ui.UserName , ui.Name , ui.Family   from UserInfo ui inner join posts p  on ui.UserName = p.Creator GROUP by ui.UserName , ui.Name , ui.Family ";
        $creator_src = DB::select($Query);
        return view('news.news_search', ['creator_src' => $creator_src, 'IndexTree' => $IndexTree, 'IndexNewsTree' => $IndexNewsTree]);
    }

    public function NewsList($ListType = null)
    {
        if ($ListType == null) {
            return $this->show_news_search();
        }
        if (Session::has('SelectPost')) {
            $SelectPost = Session::get('SelectPost');
            $TargetSelected = posts::where('id', $SelectPost)->first();
            $RelatedArr = json_decode($TargetSelected->Related);
        } else {
            $SelectPost = null;
            $TargetSelected = null;
            $RelatedArr = null;
        }

        switch ($ListType) {
            case 'news':
                $Condition = "";
                $PageTitle = 'اخبار';
                $howview = true;
                break;
            case 'banners':
                $Condition = " and  posts.adds > 0";
                $PageTitle = 'بنر ها';
                $howview = false;
                break;
            case 'hotnews':
                $Condition = " and  posts.hotnews ";
                $PageTitle = 'اخبار داغ';
                $howview = true;
                break;
            case 'ads':
                $Condition = " and adds > 0";
                $PageTitle = 'تبلیغات';
                $howview = true;
                break;
            case 'covers':
                $Condition = "";
                $PageTitle = 'پوشش';
                $howview = true;
                break;
            case 'family':
                $Condition = " and Type = 12";
                $PageTitle = 'خانواده فرش';
                $howview = true;
                break;
        }

        if ($ListType == 'covers') {
            $Query = "select L3Work.Name  as TagName ,posts.*,news_views_view.views_count , branches.Name as branch_name from posts inner join branches on branches.id = posts.branch inner join L3Work on posts.MainIndex = L3Work.UID left join news_views_view on posts.id = news_views_view.Post and news_views_view.Status = 1  where (posts.Type = 2  or posts.Type = 3) and posts.Status < 100";


        } else {
            $Query = "select posts.*,news_views_view.views_count  , branches.Name as branch_name from posts inner join branches on branches.id = posts.branch left join news_views_view on posts.id = news_views_view.Post and news_views_view.Status = 1  where posts.Type = 1 and posts.Status < 100 $Condition ";
        }
        $News = DB::select($Query);
        return view("news.NewsList", ['RelatedArr' => $RelatedArr, 'TargetSelected' => $TargetSelected, 'SelectPost' => $SelectPost, 'News' => $News, 'PageTitle' => $PageTitle, 'Showview' => $howview, 'ListType' => $ListType]);
    }
    public static function get_unread_comments_count()
    {
        $UnreadCount = post_views::where('Status', '<', 5)->where('Status', '>', 0)->count();
        return $UnreadCount;
    }
    public static function GetComments($Type, $PostId = null)
    {
        $PostIdCondition = '';
        if ($PostId != null) {
            $PostIdCondition = " and pv.Post = $PostId ";
        }
        if ($Type == 'Unread') {
            $Query = "SELECT pv.*, ui.Name as RegsterUserName , p.OutLink, p.Titel, ui.Family  as RegsterUserFamily  from post_views pv inner join posts p on p.id= pv.Post left join UserInfo ui on pv.UserName = ui.UserName where pv.Status < 5 and  pv.Status > 0 $PostIdCondition ORDER BY pv.refrence";
            return DB::select($Query);
        }
        if ($Type == 'Comfirmd') {
            $Query = "SELECT pv.*, ui.Name as RegsterUserName ,  p.OutLink, p.Titel, ui.Family  as RegsterUserFamily  from post_views pv inner join posts p on p.id= pv.Post left join UserInfo ui on pv.UserName = ui.UserName where pv.Status > 99 $PostIdCondition ORDER BY pv.refrence";
            return DB::select($Query);
        }
        if ($Type == 'All') {
            $Query = "SELECT pv.*, ui.Name as RegsterUserName ,  p.OutLink, p.Titel, ui.Family  as RegsterUserFamily  from post_views pv inner join posts p on p.id= pv.Post left join UserInfo ui on pv.UserName = ui.UserName where pv.Status > 0 $PostIdCondition ORDER BY pv.refrence";
            return DB::select($Query);
        }
    }
    public function get_family_index()
    {
        return L3Work::where('WorkCat', myappenv::FamilyWorkCat)->where('L1ID', myappenv::FamilyIndexL1)->where('L2ID', myappenv::FamilyIndexL2)->get();
    }

    public function MakeNews(Request $request)
    {
        if ($request->ajax()) {
            if ($request->input('function') == 'family') {
                return $this->get_family_index();
            }
        }
        $WorkCat = myappenv::PostIndexWorkCat;
        $L1ID = myappenv::NewsIndexL1;
        $L2ID = myappenv::NewsIndexL2;
        $L1IDCat = myappenv::NewsCatL1;
        $L2IDCat = myappenv::NewsCatL2;
        $family_index = $this->get_family_index();
        $cats = L3Work::all()->where('WorkCat', $WorkCat)->where('L1ID', $L1IDCat)->where('L2ID', $L2IDCat);
        $Tags = L3Work::all()->where('WorkCat', $WorkCat)->where('L1ID', $L1ID)->where('L2ID', $L2ID);
        $UserLevel = UserRole::all();
        $branch_src = branches::all();
        return view("news.MakeNews", ['family_index' => $family_index, 'Tags' => $Tags, 'cats' => $cats, 'branch_src' => $branch_src, 'UserLevel' => $UserLevel]);
    }
    private function check_outlink_not_exsit($outlink)
    {
        $outlink_news_src = posts::where('OutLink', $outlink)->first();
        if ($outlink_news_src == null) {
            return true;
        }
        return false;
    }

    public function DoMakeNews(Request $request)
    {

        if ($request->ajax()) {
            if ($request->AjaxType == 'check_outlink') {
                return $this->check_outlink_not_exsit($request->OutLink);
            }
        }

        $request->validate([
            'Titel' => 'required',
            'pic' => 'required',
        ], [
            'Titel.required' => 'مشخص سازی تایتل الزامی است!',
            'pic.required' => 'مشخص سازی تصویر الزامی است!',
        ]);
        if ($request->input('Registeruser') == 'register_family') {

            $Result = $this->makeFamily($request);
            if ($Result != null) {
                return redirect()->route('NewsList', ['ListType' => 'news'])->with('success', 'خبر شماره ' . $Result . ' اضافه شد ! ');
            }
        }

        if ($request->input('NewsCat') == __('--select--')) {
            return redirect()->back()->withErrors('مشخص سازی دسته خبر الازمی است!')->withInput();
        }
        if ($request->has('hotnews')) {
            $hotnews = 1;
        } else {
            $hotnews = 0;
        }
        if ($request->has('mostview')) {
            $mostview = 1;
        } else {
            $mostview = 0;
        }
        if ($request->has('galery')) {
            $galery = 1;
        } else {
            $galery = 0;
        }
        if ($request->has('article')) {
            $article = $request->article;
        } else {
            $article = 0;
        }

        if ($request->has('mini')) {
            $mini = 1;
        } else {
            $mini = 0;
        }
        if ($request->has('larg')) {
            $larg = 1;
        } else {
            $larg = 0;
        }

        if ($request->has('lastnews')) {
            $lastnews = 1;
        } else {
            $lastnews = 0;
        }
        if ($request->has('sami_index')) {
            $sami_index = true;
        } else {
            $sami_index = false;
        }
        if ($request->has('Newslater')) {
            $Newslater = 1;
        } else {
            $Newslater = 0;
        }
        if ($request->has('Writer')) {
            $Writer = Auth::user()->Name . ' ' . Auth::user()->Family;
        } else {
            $Writer = $request->input('Writer');
        }
        if ($request->has('adds_Itself')) {
            $adds = 1;
        } elseif ($request->has('adds_Direct')) {
            $adds = 2;
        } elseif ($request->has('mainbanner')) {
            $adds = 3;
        } else {
            $adds = 0;
        }
        if ($request->Registeruser == 'old') {
            if ($request->input('ce') != null) {
                $content = $request->input('freeContent');
            } else {
                $content = '';
            }
        } else {
            if ($request->input('ce') != null) {
                $content = $request->input('ce');
                $content = preg_replace('/font-family.+?;/', "", $content);
            } else {
                $content = '';
            }
        }

        if ($request->has('CloseComment')) {
            $Comment = -1;
        } else {
            $Comment = 0;
        }
        $MyPersian = new persian();
        $CreateTime = $MyPersian->MiladiDate($request->input('CreateDate'));
        $branch = myappenv::Branch;
        if (myappenv::Lic['MultiBranch']) {
            $branch = $request->target_branch;
        }
        $DataToSave = [
            'Abstract' => $request->input('Abstract'),
            'adds' => $adds,
            'CommentCount' => $Comment,
            'Content' => $content,
            'ContentAccessLevel' => $request->input('ContentAccessLevel'),
            'CrateDate' => $CreateTime,
            'Creator' => Auth::id(),
            'ExtTranslater' => $request->input('ExtTranslater'),
            'ExtWriter' => $request->input('ExtWriter'),
            'hotnews' => $hotnews,
            'Lead' => $request->input('Titel'),
            'LikeCount' => 0,
            'LinkAddress' => $request->input('Titel'),
            'description' => $request->input('description'),
            'MainPic' => $request->input('pic'),
            'Name' => $request->input('Titel'),
            'Newsletter' => $Newslater,
            'OutLink' => $request->input('OutLink'),
            'PostContent' => $request->input('PostContent'),
            'Price' => $request->input('Price'),
            'CreatorPrice' => $request->input('CreatorPrice'),
            'RefLink' => $request->input('RefLink'),
            'RefName' => $request->input('RefName'),
            'mini' => $mini,
            'larg' => $larg,
            'sami_index' => $sami_index,
            'article' => $article,
            'paernt' => 0,
            'Status' => 0,
            'SubTitel' => $request->input('SubTitel'),
            'Titel' => $request->input('Titel'),
            'TitleAccessLevel' => $request->input('TitleAccessLevel'),
            'Type' => 1,
            'UpTitel' => $request->input('UpTitel'),
            'ViewCount' => 0,
            'mostview' => $mostview,
            'lastnews' => $lastnews,
            'galery' => $galery,
            'branch' => $branch ?? 1,
            'Writer' => $Writer
        ];
        $Result = posts::create($DataToSave);
        $NewsID = $Result->id;
        if (myappenv::wordpress_site) {
            $wordpress_result = $this->MakeNewsWordpress($request);
            posts::where('id', $NewsID)->update(['wordpress_post_id' => $wordpress_result['Data']]);
        }


        $TagResult = L3Work::where('Name', $request->input('NewsCat'))->where('WorkCat', myappenv::PostIndexWorkCat)->where('L1ID', myappenv::NewsCatL1)->where('L2ID', myappenv::NewsCatL2)->first();
        if ($TagResult == null) {
            $L3Data = [
                'WorkCat' => myappenv::PostIndexWorkCat,
                'L1ID' => myappenv::NewsCatL1,
                'L2ID' => myappenv::NewsCatL2,
                'L3ID' => myappenv::NewsCatL2,
                'Name' => $request->input('NewsCat'),
                'Description' => '',
                'img' => ''
            ];
            $TargetL3work = L3Work::create($L3Data);
            $TargetL3work = $TargetL3work->id;
        } else {
            $TargetL3work = $TagResult->UID;
        }
        posts::where('id', $NewsID)->update(['MainIndex' => $TargetL3work]);
        if ($request->has('SelectTags')) {
            $my_keywords = new meta_keyword;
            $my_keywords->add_meta_keyword_to_item($request->input('SelectTags'), $NewsID, myappenv::NewsItemIndexType);
        }
        if ($Result->id != null) {
            return redirect()->route('EditNews', ['NewsID' => $Result->id])->with('success', 'خبر شماره ' . $Result->id . ' اضافه شد ! ');
            //return redirect()->route('NewsList', ['ListType' => 'news'])->with('success', 'خبر شماره ' . $Result->id . ' اضافه شد ! ');
        }
    }
    private function saveOrUpdateNewsWordpress($request, $post_id = null)
    {
        $isNewPost = !$post_id;

        $DataToSave = [
            'post_author' => 1,
            'post_date' => now(),
            'post_date_gmt' => now()->timezone('GMT'),
            'post_content' => $request->input('ce'),
            'post_title' => $request->input('Titel'),
            'post_status' => 'publish',  // Set as draft or publish
            'comment_status' => 'open',
            'ping_status' => 'open',
            'post_name' => $request->input('Titel'),
            'post_type' => 'post',
            'post_modified' => now(),
            'post_modified_gmt' => now()->timezone('GMT'),
        ];

        if ($isNewPost) {
            $post_id = DB::table('wp_posts')->insertGetId($DataToSave);

        } else {
            $post_item = posts::where('id', $post_id)->first();
            DB::table('wp_posts')->where('ID', $post_item->wordpress_post_id)->update($DataToSave);
        }

        if ($request->has('pic')) {
            $imageUrl = $request->input('pic');
            $imageFileName = basename($imageUrl);
            $siteAddress = myappenv::SiteAddress;
            $relativePath = str_replace($siteAddress . '/', '', $imageUrl);
            $imagePath = 'laravel/' . $relativePath;
            if ($isNewPost) {

                $attachmentId = DB::table('wp_posts')->insertGetId([
                    'post_author' => 1,
                    'post_date' => now(),
                    'post_date_gmt' => now()->timezone('GMT'),
                    'post_title' => $imageFileName,
                    'post_status' => 'inherit',
                    'post_name' => $imageFileName,
                    'post_type' => 'attachment',
                    'guid' => $imageUrl,
                    'post_mime_type' => 'image/jpeg',
                ]);

                DB::table('wp_postmeta')->insert([
                    'post_id' => $post_id,
                    'meta_key' => '_thumbnail_id',
                    'meta_value' => $attachmentId,
                ]);

                DB::table('wp_postmeta')->insert([
                    'post_id' => $attachmentId,
                    'meta_key' => '_wp_attached_file',
                    'meta_value' => $imagePath,
                ]);
            } else {

                $existingAttachment = DB::table('wp_postmeta')
                    ->where('post_id', $post_item->wordpress_post_id)
                    ->where('meta_key', '_thumbnail_id')
                    ->first();

                $attachmentId = $existingAttachment->meta_value;
                // dd($attachmentId);
                DB::table('wp_posts')->where('ID', $attachmentId)->update([
                    'post_title' => $imageFileName,
                    'post_name' => $imageFileName,
                    'guid' => $imageUrl,
                    'post_modified' => now(),
                    'post_modified_gmt' => now()->timezone('GMT'),
                ]);

                DB::table('wp_postmeta')->where('post_id', $attachmentId)->where('meta_key', '_wp_attached_file')->update([
                    'meta_value' => $imagePath,
                ]);
            }



        }
        return [
            'result' => true,
            'Data' => $post_id
        ];

    }

    public function MakeNewsWordpress($request)
    {

        return $this->saveOrUpdateNewsWordpress($request);


    }
    public function EditNewsWordpress($request, $post_id)
    {
        return $this->saveOrUpdateNewsWordpress($request, $post_id);
    }
}

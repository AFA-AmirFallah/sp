<?php

namespace App\Http\Controllers\Dashboard;

use App\Affiliate\affiliate_user;
use App\branchenv;
use App\crawler\html_analyzer;
use App\Crypto\CryptoFunctions;
use App\Deal\DealBase;
use App\Deal\DealCalls;
use App\Functions\AlertsNotifications;
use App\Functions\DashboardClass;
use App\Functions\Entrance;
use App\Functions\Financial;
use App\Functions\MarketingClass;
use App\Functions\NewsClass;
use App\Functions\Orders;
use App\hiring\hiring_package_manager;
use App\hiring\hiring_skills;
use App\hiring\hiring_workers;
use App\Http\Controllers\APIS\SMSReciver;
use App\Http\Controllers\APIS\SMSSender;
use App\Http\Controllers\auto\UserWorks;
use App\Http\Controllers\Controller;
use App\Http\Controllers\crawler\CrawlerMain;
use App\Http\Controllers\News\NewsAdmin;
use App\Http\Controllers\News\NewsItems;
use App\Http\Controllers\woocommerce\product;
use App\Http\Controllers\woocommerce\ProductClass;
use App\Models\branches;
use App\Models\Calls;
use App\Models\catorder;
use App\Models\crypto_price_24hs;
use App\Models\deal_file_pic;
use App\Models\goods;
use App\Models\metadata;
use App\Models\mobile_banner;
use App\Models\orderstatus;
use App\Models\post_views;
use App\Models\posts;
use App\Models\store;
use App\Models\TicketMain;
use App\Models\UserInfo;
use App\Models\SMS;
use App\myappenv;
use App\Order\OrderClass;
use App\SystemFunctions\SystemFunctions;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class Dashboard extends Controller
{
    public function shop()
    {
        $theme = myappenv::ShopTheme;
        $DashboardClass = new DashboardClass;
        $Product = new ProductClass();
        $CatOrder = catorder::all()->where('Branch', myappenv::CustomerOrderBranch);
        $MyProduct = new product;
        if (Auth::check()) {
            if (Auth::user()->Role >= myappenv::role_admin) {
                $management = true;
            } else {
                $management = false;
            }
        } else {
            $management = false;
        }
        if (Auth::check()) {
            $UserLogin = 'user';
            $AdminLogin = false;
            if (Auth::user()->Role >= myappenv::role_admin) {
                $UserLogin = 'admin';
                $AdminLogin = true;
            }
        } else {
            Session::put('intended_url', \request()->url());
            $UserLogin = null;
            $AdminLogin = false;
        }
        $DataSource = new NewsClass('SingleNews', $AdminLogin);
        $Query = "SELECT theme from mobile_banner mb WHERE  status  =  1 and page = 1 group by theme ";
        $ElementsTypes = DB::select($Query);
        $PagesObjects = array();
        foreach ($ElementsTypes as $ElementsTypesItem) {
            array_push($PagesObjects, $ElementsTypesItem->theme);
        }
        if (Auth::check()) {
            $OrderClass = new Orders();
            $MyOrders = $OrderClass->ViewOrders(Auth::id(), Auth::user()->Role);
        } else {
            if (myappenv::Lic['wpa']) {
                $MyOrders = [];
            } else {
                return route('login');
            }
        }
        $mobile_banners = mobile_banner::where('status', 1)->where('page', 1)->orderBy('order', 'ASC')->get();

        return view("Layouts.$theme.DashboardCustomer", ['DataSource' => $DataSource, 'management' => $management, 'MyProduct' => $MyProduct, 'page' => 1, 'DashboardClass' => $DashboardClass, 'Product' => $Product, 'PagesObjects' => $PagesObjects, 'CatOrders' => $CatOrder, 'MyOrders' => $MyOrders, 'mobile_banners' => $mobile_banners]);
    }
    public function Doshop(Request $request)
    {
    }
    public function changeview($Target)
    {

        if ($Target == 'Dashboard') {
            Session::put('TargetVeiw', 'Dashboard');
            return redirect()->route('dashboard');
        } elseif ($Target == 'site') {
            Session::put('TargetVeiw', 'Site');
            return redirect()->route('home');
        } else {
            Session::put('TargetVeiw', 'Site');
            return redirect()->route('home');
        }
    }
    private function customer_dashboard(Request $request)
    {
        return 'salam';
    }
    public function Dodashboard(Request $request)
    {

        if ($request->has('reload_crawler')) {
            $crawl_class = new CrawlerMain;
            $crawl_result = $crawl_class->re_crawl_item($request->reload_crawler);
            if ($crawl_result['result']) {
                return redirect()->back()->with('success', 'عملیات موفق: ' . 'تعداد آپدیت: ' . $crawl_result['UpdateItems'] . ' تعداد صفحات جدید: ' . $crawl_result['AddItems']);
            }
            return redirect()->back()->with('error', $crawl_result['msg']);
        }
        if ($request->has('change_branch')) {
            $change_result = branchenv::set_branch($request->branch);
            if ($change_result) {
                return redirect()->back()->with('success', 'تغییر شعبه انجام شد');
            }
            return redirect()->back()->with('error', 'تغییر شعبه انجام نشد');
        }
        if ($request->has('Registeruser')) {
            $affiliate = new affiliate_user;
            $user_info = [
                'Sex' => $request->Sex,
                'Name' => $request->Name,
                'Family' => $request->Family,
                'MobileNo' => $request->MobileNo,
                'create_user' => Auth::id(),
                'Saharestan' => $request->Saharestan,
                'customer_type' => $request->customer_type,
                'Province' => $request->Province,
                'marketer' => Auth::user()->Name . ' ' . Auth::user()->Family
            ];
            $add_use = $affiliate->add_customer($user_info);
            if (!$add_use['result']) {
                return redirect()->back()->with('error', $add_use['msg']);
            }
            return redirect()->back()->with('success', 'کاربر مورد نظر به سامانه افزوده شد!');
        }
        if ($request->has('add_expert')) {
            $skills = new hiring_skills;
            $skills->update_worker_skills(auth::id(), $request->SelectTags);
            return redirect()->back()->with('success', 'مهارتهای مورد نظر در سامانه به روز رسانی شد!');
        }

        if ($request->has('buy_package')) {
            $hiring = new hiring_package_manager;
            return $hiring->buy_package($request);
        }
        if ($request->ajax == true) {
            if ($request->procedure == 'totallMarketIndexChart_usd') {
                $MaxId = crypto_price_24hs::where('curency', 'USD-TMN')->orderBy('updated_at', 'DESC')->limit(10)->get();
                return $MaxId;
            }
            return 'true';
        }
        if ($request->axios) {
            if ($request->type == 'customer') {
                return $this->customer_dashboard($request);
            }
            if ($request->function == 'get_admins_meta_info') {
                $DashboardClass = new DashboardClass;
                $system_functions = new SystemFunctions;
                $storage_usage = $system_functions->get_storage_used_size();
                $branch = Auth::user()->branch;
                if (myappenv::Branch == $branch) { // main application user
                    $condition = '';
                    $AllUsers = UserInfo::count();
                } else {
                    $condition = " and branch =  $branch";
                    $AllUsers = UserInfo::where('branch', $branch)->count();
                }
                $usersin7days = 'SELECT count(*) as count FROM UserInfo WHERE CreateDate  >= DATE(NOW() - INTERVAL 7 DAY)' . $condition;
                $TotallActiveUsers = $DashboardClass->GetTotallActiveUsers($branch);
                $usersin7days = DB::select($usersin7days);
                $user_branch = Auth::user()->branch;
                if ($user_branch == myappenv::Branch) {
                    $usersin24h = "SELECT count(*) as count FROM UserInfo INNER JOIN branches on UserInfo.branch = branches.id WHERE CreateDate >= CURDATE() AND CreateDate < CURDATE() + INTERVAL 1 DAY";
                } else {
                    $usersin24h = "SELECT count(*) as count FROM UserInfo INNER JOIN branches on UserInfo.branch = branches.id WHERE branches.id = $user_branch AND CreateDate >= CURDATE() AND CreateDate < CURDATE() + INTERVAL 1 DAY";
                }
                $UnreadCommtsCount = NewsAdmin::get_unread_comments_count();

                $usersin24h = DB::select($usersin24h);
                $lic_count = $this->get_license_count();
                $user_branch = Auth::user()->branch;
                $branch_src = branches::where('id', $user_branch)->first();
                $Branch_owner = $branch_src->UserName;
                $financial = new Financial;
                $owner_financial_state = $financial->UserFinalState($Branch_owner);
                $owner_credit = 0;
                $orders = catorder::where('branch', $user_branch)->where('Status', 1)->count();

                foreach ($owner_financial_state as $owner_financial_state_item) {
                    if ($owner_financial_state_item->CreditMod == myappenv::CachCredit) {
                        $owner_credit += $owner_financial_state_item->Mony;
                    }
                }


                foreach ($usersin7days as $usersin7daysItem) {
                    $usersin7days_count = $usersin7daysItem->count;
                }
                foreach ($usersin24h as $usersin24hItem) {
                    $usersin24h_count = $usersin24hItem->count;
                }
                $result = [
                    'storage_usage' => $storage_usage,
                    'AllUsers' => $AllUsers,
                    'usersin7days' => $usersin7days_count,
                    'usersin24h' => $usersin24h_count,
                    'lic_count' => $lic_count,
                    'TotallActiveUsers' => $TotallActiveUsers,
                    'UnreadCommtsCount' => $UnreadCommtsCount,
                    'owner_credit' => $owner_credit,
                    'orders' => $orders
                ];
                return $result;
            }
        }
        if ($request->ajax == true) {
            if ($request->procedure == 'usdt-tmn-10-d') {
                $MaxId = metadata::where('tt', 'USDT-TMN')->max('fgint');
                $MaxId -= 10;
                $Result = metadata::where('tt', 'USDT-TMN')->where('fgint', '>', $MaxId)->orderBy('fgint')->get();
                return $Result;
            }
            if ($request->procedure == 'totallMarketIndexChart') {
                $MaxId = metadata::where('tt', 'MI')->orderBy('fgint', 'DESC')->limit(10)->get();
                return $MaxId;
            }
            if ($request->procedure == 'totallMarketIndexChart_usd') {
                $MaxId = crypto_price_24hs::where('curency', 'USD-TMN')->orderBy('updated_at', 'DESC')->limit(10)->get();
                return $MaxId;
            }
            return 'true';
        }
        if (myappenv::Lic['deal'] && Auth::user()->Role == myappenv::role_worker) {
            return $this->Dodealer_dashboard($request);
        }

        if ($request->has('confirmcomment')) {
            $ConfirmPost = $request->input('confirmcomment');
            post_views::where('id', $ConfirmPost)->update(['Status' => 100]);
            $news = new NewsItems;
            $news->update_post_comments_count($ConfirmPost);
            return redirect()->back()->with('success', 'نظر ثبت شده منتشر گردید!');
        } elseif ($request->has('Deletecomment')) {
            $ConfirmPost = $request->input('Deletecomment');
            post_views::where('id', $ConfirmPost)->update(['Status' => 0]);
            return redirect()->back()->with('success', 'نظر ثبت شده حذف گردید!');
        } elseif ($request->has('confirmsms')) {
            $ConfirmSMS = $request->input('confirmsms');
            SMS::where('SMSID', $ConfirmSMS)->update(['Status' => 100]);
            return redirect()->back()->with('success', 'عملیات با موفقیت آمیز انجام شد!');
        } elseif ($request->has('Deletesms')) {
            $ConfirmSMS = $request->input('Deletesms');
            SMS::where('SMSID', $ConfirmSMS)->update(['Status' => 1000]);
            return redirect()->back()->with('success', 'عملیات با موفقیت آمیز انجام شد!');
        }
    }
    public function get_cat_orders()
    {
        if (myappenv::version < 3) {
            $Query = "SELECT catorder.id , catorder.Cat , catorder.TitleDescription,catorder.Pic, 1 as centers FROM catorder LEFT JOIN branch_cat_orders on catorder.id = branch_cat_orders.catorder and branch_cat_orders.OnSale =1 and branch_cat_orders.Status = 100 GROUP by catorder.id , catorder.Cat , catorder.TitleDescription,catorder.Pic order by centers DESC";
        } else {
            $Query = "SELECT catorder.id , catorder.Cat , catorder.TitleDescription,catorder.Pic, COUNT(branch_cat_orders.id) as centers FROM catorder LEFT JOIN branch_cat_orders on catorder.id = branch_cat_orders.catorder and branch_cat_orders.OnSale =1 and branch_cat_orders.Status = 100 GROUP by catorder.id , catorder.Cat , catorder.TitleDescription,catorder.Pic order by centers DESC";
        }

        return DB::select($Query);
    }

    private function SuperAdminDashboard()
    {
        $branch = Auth::user()->branch;
        $PanelCharge = 10000;
        $daramad = myappenv::StackHolder;
        if (myappenv::Lic['MultiBranch']) {
            $daramad = $daramad . $branch;
        }
        $Query = "SELECT sum(Mony) as mony, date(Confirmdate) as confirmdate  FROM UserCredit  WHERE UserName = '$daramad' and Date(Confirmdate) > (CURDATE()- INTERVAL 14 DAY) GROUP by Date(Confirmdate)  ORDER BY Date(Confirmdate) ASC  ";
        //todo: delete this line V
        //$Query = "SELECT sum(Mony) as mony, date(Confirmdate) as confirmdate FROM UserCredit WHERE UserName = 'daramad' and Confirmdate >'2020-04-20' and Confirmdate <'2020-05-02' GROUP by Date(Confirmdate) ORDER BY Date(Confirmdate) ASC";
        $DaramadGraph = DB::select($Query);
        $date = date("Y-m-d", strtotime("-300 days")); // Y-m-d
        $conter = 0;
        foreach (myappenv::TicketPoint as $ticketpoint) {
            $fe = TicketMain::where('Point', $ticketpoint[0])->where('CreateDate', '>', $date)->count();
            $Tiketfilds[$conter] = [$fe, $ticketpoint[1]];
            $conter++;
        }
        $maxticket = 0;
        foreach ($Tiketfilds as $tiketfild) {
            $maxticket += $tiketfild[0];
        }
        $Customers = UserInfo::where('Role', myappenv::role_customer)->get()->count();
        $Staffs = UserInfo::where('Role', myappenv::role_worker)->where('Status', myappenv::User_active_status)->get()->count();
        $Query = "SELECT WorkerSkils.Weight,L3Work.Name FROM `WorkerSkils`  INNER JOIN L3Work on WorkerSkils.SkilID = L3Work.UID GROUP by WorkerSkils.Weight,L3Work.Name
        ORDER BY `WorkerSkils`.`Weight`  DESC LIMIT 10";
        $MostWorkerSkills = DB::select($Query);
        $baranches = branches::all();
        $baranches = $baranches->count();
        $mysms = new SMSReciver;
        $SMS = $mysms->GetInputSMS();
        $DashboardClass = new DashboardClass();
        if (myappenv::Lic['hozorgheyab']) {
            $hozorgheyabobj = new Entrance();
            $hozorgheyabs = $hozorgheyabobj->OnlinePersonel();
            return view("Dashboard.DashboardSuperAdmin", ['SMS' => $SMS, 'DashboardClass' => $DashboardClass, 'DaramadGraph' => $DaramadGraph, 'Tiketfilds' => $Tiketfilds, 'maxticket' => $maxticket, 'Customers' => $Customers, 'Staffs' => $Staffs, 'PanelCharge' => $PanelCharge, 'baranches' => $baranches, 'hozorgheyabs' => $hozorgheyabs, 'MostWorkerSkills' => $MostWorkerSkills]);
        } else {
            return view("Dashboard.DashboardSuperAdmin", ['SMS' => $SMS, 'DashboardClass' => $DashboardClass, 'DaramadGraph' => $DaramadGraph, 'Tiketfilds' => $Tiketfilds, 'maxticket' => $maxticket, 'Customers' => $Customers, 'Staffs' => $Staffs, 'PanelCharge' => $PanelCharge, 'baranches' => $baranches, 'MostWorkerSkills' => $MostWorkerSkills]);
        }
    }
    private function TraderDashboard()
    {
        $mobile_banners = mobile_banner::where('status', 1)->where('page', 1)->orderBy('order', 'ASC')->get();
        $Crypto = new CryptoFunctions();
        $MarketSrc = $Crypto->MarketAlyze(null, 'TMN');
        $Query = "SELECT posts.*,UserInfo.Name,UserInfo.Family,UserInfo.avatar from posts INNER JOIN UserInfo on UserInfo.UserName = posts.Creator where   posts.Status = 1    and ( posts.mini = 1 or  posts.larg = 1)  order by posts.larg ";
        $Minis = DB::select($Query);
        if (myappenv::MainOwner == 'arzonline') {
            $query = "SELECT crypto_price_24hs.*,currencies.FaName,currencies.pic FROM crypto_price_24hs INNER JOIN currencies on crypto_price_24hs.curency = currencies.MainName WHERE DATE_FORMAT(crypto_price_24hs.candate, '%Y-%m-%d') = CURDATE()";
            $today_src = DB::select($query);

            return view('Theme2.Dashboard_arzonline', ['today_src' => $today_src, 'Crypto' => $Crypto, 'Minis' => $Minis, 'mobile_banners' => $mobile_banners]);
        }
        return view('Theme2.Dashboard', ['Crypto' => $Crypto, 'Minis' => $Minis, 'mobile_banners' => $mobile_banners]);
    }

    public function CustomerDashboard()
    {
        if (myappenv::AppModel == 'traid') {

            return $this->TraderDashboard();
        }

        if (Auth::check()) {

            $OrderClass = new Orders();
            $MyOrders = $OrderClass->ViewOrders(Auth::id(), Auth::user()->Role);
        } else {
            if (myappenv::Lic['wpa']) {
                $MyOrders = [];
            } else {
                return route('login');
            }
        }
        $CatOrder = catorder::all()->where('Branch', myappenv::CustomerOrderBranch);
        if ((myappenv::MainOwner == 'shafatel' || myappenv::MainOwner == 'Ohp') && Auth::check()) {

            $orders = new OrderClass;
            $DashboardClass = new DashboardClass();
            $UserName = Auth::id();
            $topay_credit = myappenv::ToPayCredit;
            $Query = "SELECT
    UserCredit.UserName, UserCredit.CreditMod,
    UserCredit.Mony,
    UserCredit.RealMony,
    UserCredit.Note,
    CONCAT(requestuser.name,' ',requestuser.Family) AS TransferBy,
    UserCredit.Date,
    UserCreditModMeta.ModName,
    CONCAT(UserInfo.name,' ',UserInfo.Family) AS name,
    UserCredit.ID,
    UserCredit.RealMony,
    UserCreditIndex.IndexName as indexname,
    UserCredit.Type,
    UserCredit.ReferenceId
FROM UserCredit
JOIN UserCreditModMeta on UserCredit.CreditMod = UserCreditModMeta.ID
JOIN UserInfo on UserCredit.UserName = UserInfo.UserName
JOIN UserInfo as requestuser on UserCredit.TransferBy = requestuser.UserName
left join UserCreditIndex on UserCreditIndex.IndexID = UserCredit.CreditIndex
WHERE (ConfirmBy = '' or ConfirmBy is null) AND  UserCredit.ReferenceId IS NULL and UserCredit.UserName = '$UserName' and UserCredit.CreditMod =  $topay_credit
ORDER BY  UserCredit.ID  ";
            $OpenBills = DB::select($Query);

            $MyServices = "SELECT RelatedStaff.id,RelatedStaff.StartRespns,RelatedStaff.EndRespns,RespnsType.Description ,  IF( StartRespns > now() ,'notactive', IF( EndRespns > now() ,'active', 'finish')) as status FROM RelatedStaff INNER JOIN RespnsType on RelatedStaff.RespnsType = RespnsType.id WHERE RelatedStaff.OwnerUserID = '$UserName' and RelatedStaff.DeletedBy is null and RelatedStaff.EndNote = ''";
            $MyServices = DB::select($MyServices);
            $orders = new OrderClass;
            if (Session::has('new_thme')) {
                $new_theme = Session::get('new_thme');
            } else {
                $new_theme = true;
            }

            if (myappenv::MainOwner == 'shafatel' && $new_theme) {
                if (Auth::check()) {
                    $UserLogin = 'user';
                    $AdminLogin = false;
                    if (Auth::user()->Role >= myappenv::role_admin) {
                        $UserLogin = 'admin';
                        $AdminLogin = true;
                    }
                } else {
                    Session::put('intended_url', \request()->url());
                    $UserLogin = null;
                    $AdminLogin = false;
                }
                $DataSource = new NewsClass('SingleNews', $AdminLogin);

                return view("Dashboard.DashboardCustomer_shafatel", ['DataSource' => $DataSource, 'page' => 1, 'orders' => $orders, 'MyServices' => $MyServices, 'OpenBills' => $OpenBills, 'orders' => $orders, 'DashboardClass' => $DashboardClass, 'CatOrders' => $CatOrder, 'MyOrders' => $MyOrders]);
            } elseif (myappenv::MainOwner == 'sepehrmall' && $new_theme) {
                $orders = [];
                $MyServices = [];
                $OpenBills = [];
                if (Auth::check()) {
                    $UserLogin = 'user';
                    $AdminLogin = false;
                    if (Auth::user()->Role >= myappenv::role_admin) {
                        $UserLogin = 'admin';
                        $AdminLogin = true;
                    }
                } else {
                    Session::put('intended_url', \request()->url());
                    $UserLogin = null;
                    $AdminLogin = false;
                }
                $DataSource = new NewsClass('SingleNews', $AdminLogin);
                $Product_src = goods::where('id', '<', 30)->get();


                return view("Dashboard.DashboardCustomer_sepehrmall", ['Product_src' => $Product_src, 'DataSource' => $DataSource, 'page' => 1, 'orders' => $orders, 'MyServices' => $MyServices, 'OpenBills' => $OpenBills, 'orders' => $orders, 'DashboardClass' => $DashboardClass, 'CatOrders' => $CatOrder, 'MyOrders' => $MyOrders]);
            } else {

                return view("Dashboard.DashboardCustomer", ['page' => 1, 'orders' => $orders, 'MyServices' => $MyServices, 'OpenBills' => $OpenBills, 'orders' => $orders, 'DashboardClass' => $DashboardClass, 'CatOrders' => $CatOrder, 'MyOrders' => $MyOrders]);
            }

        }
        if (myappenv::Lic['wpa']) {
            $Query = "SELECT theme from mobile_banner mb WHERE  status  =  1 and page = 1 group by theme ";
            $ElementsTypes = DB::select($Query);
            $PagesObjects = array();
            foreach ($ElementsTypes as $ElementsTypesItem) {
                array_push($PagesObjects, $ElementsTypesItem->theme);
            }

            $mobile_banners = mobile_banner::where('status', 1)->where('page', 1)->where('branch', myappenv::Branch)->orderBy('order', 'ASC')->get();
            $Product = new ProductClass();
            $DashboardClass = new DashboardClass();
            if (Session::has('TargetVeiw')) {
                $TargetVeiw = Session::get('TargetVeiw');
            } else {
                $TargetVeiw = 'Site';
            }
            if ($TargetVeiw == 'Site') {
                if (myappenv::MainPage == 'dashboard') {
                    $theme = myappenv::SiteTheme;
                    $site_src = url('/');
                    if (Str::contains($site_src, 'panel.shafatel.com')) {
                        $cat_orders = $this->get_cat_orders();
                        return view("Layouts.Theme4.DashboardCustomer", ['page' => 1, 'DashboardClass' => $DashboardClass, 'Product' => $Product, 'PagesObjects' => $PagesObjects, 'CatOrders' => $CatOrder, 'MyOrders' => $MyOrders, 'mobile_banners' => $mobile_banners]);
                    } else {
                        if (Session::has('new_thme')) {
                            $new_theme = Session::get('new_thme');
                        } else {
                            $new_theme = true;
                        }

                        if (myappenv::MainOwner == 'shafatel' && $new_theme) {
                            $orders = [];
                            $MyServices = [];
                            $OpenBills = [];
                            if (Auth::check()) {
                                $UserLogin = 'user';
                                $AdminLogin = false;
                                if (Auth::user()->Role >= myappenv::role_admin) {
                                    $UserLogin = 'admin';
                                    $AdminLogin = true;
                                }
                            } else {
                                Session::put('intended_url', \request()->url());
                                $UserLogin = null;
                                $AdminLogin = false;
                            }
                            $DataSource = new NewsClass('SingleNews', $AdminLogin);
                            return view("Dashboard.DashboardCustomer_shafatel", ['DataSource' => $DataSource, 'page' => 1, 'orders' => $orders, 'MyServices' => $MyServices, 'OpenBills' => $OpenBills, 'orders' => $orders, 'DashboardClass' => $DashboardClass, 'CatOrders' => $CatOrder, 'MyOrders' => $MyOrders]);
                        } elseif (myappenv::MainOwner == 'sepehrmall' && $new_theme) {
                            $orders = [];
                            $MyServices = [];
                            $OpenBills = [];
                            if (Auth::check()) {
                                $UserLogin = 'user';
                                $AdminLogin = false;
                                if (Auth::user()->Role >= myappenv::role_admin) {
                                    $UserLogin = 'admin';
                                    $AdminLogin = true;
                                }
                            } else {
                                Session::put('intended_url', \request()->url());
                                $UserLogin = null;
                                $AdminLogin = false;
                            }
                            $DataSource = new NewsClass('SingleNews', $AdminLogin);
                            $Product_src = goods::where('id', '<', 30)->get();

                            return view("Dashboard.DashboardCustomer_sepehrmall", ['Product_src' => $Product_src, 'DataSource' => $DataSource, 'page' => 1, 'orders' => $orders, 'MyServices' => $MyServices, 'OpenBills' => $OpenBills, 'orders' => $orders, 'DashboardClass' => $DashboardClass, 'CatOrders' => $CatOrder, 'MyOrders' => $MyOrders]);
                        }
                        $MyProduct = new product;
                        if (Auth::check()) {
                            if (Auth::user()->Role >= myappenv::role_admin) {
                                $management = true;
                            } else {
                                $management = false;
                            }
                        } else {
                            $management = false;
                        }
                        if (Auth::check()) {
                            $UserLogin = 'user';
                            $AdminLogin = false;
                            if (Auth::user()->Role >= myappenv::role_admin) {
                                $UserLogin = 'admin';
                                $AdminLogin = true;
                            }
                        } else {
                            Session::put('intended_url', \request()->url());
                            $UserLogin = null;
                            $AdminLogin = false;
                        }
                        $DataSource = new NewsClass('SingleNews', $AdminLogin);
                        return view("Layouts.$theme.DashboardCustomer", ['DataSource' => $DataSource, 'management' => $management, 'MyProduct' => $MyProduct, 'page' => 1, 'DashboardClass' => $DashboardClass, 'Product' => $Product, 'PagesObjects' => $PagesObjects, 'CatOrders' => $CatOrder, 'MyOrders' => $MyOrders, 'mobile_banners' => $mobile_banners]);
                    }
                }
                /*elseif (myappenv::MainPage == 'news') {
                    $mynews = new NewsItems;
                    return $mynews->NewsHome();
                }*/
            } else {
                $theme = myappenv::DashboardTheme;
                if ($theme == 'defult') {
                    return abort('404', 'صفحه درخواست شده وجود ندارد');
                }

                if (Str::contains($site_src ?? '', 'panel.shafatel.com')) {
                    return view("Layouts.$theme.DashboardCustomer", ['page' => 1, 'DashboardClass' => $DashboardClass, 'Product' => $Product, 'PagesObjects' => $PagesObjects, 'CatOrders' => $CatOrder, 'MyOrders' => $MyOrders, 'mobile_banners' => $mobile_banners]);
                } else {
                    return view("Layouts.$theme.DashboardCustomer", ['page' => 1, 'DashboardClass' => $DashboardClass, 'Product' => $Product, 'PagesObjects' => $PagesObjects, 'CatOrders' => $CatOrder, 'MyOrders' => $MyOrders, 'mobile_banners' => $mobile_banners]);
                }
            }
        } else {

            $orders = new OrderClass;
            $DashboardClass = new DashboardClass();


            return view("Dashboard.DashboardCustomer", ['page' => 1, 'orders' => $orders, 'DashboardClass' => $DashboardClass, 'CatOrders' => $CatOrder, 'MyOrders' => $MyOrders]);
        }
    }


    private function AdminDashboard()
    {
        if (Auth::user()->branch != null) {
            if (Auth::user()->branch == myappenv::Branch) {
                $mybaranch = '';
            } else {
                $mybaranch = ' and UserInfo.branch = ' . Auth::user()->branch;
            }
        } else {
            $mybaranch = '';
        }
        if (myappenv::Lic['SMSReciver'] && Auth::user()->branch == myappenv::Branch) {
            $MyReciveSMS = new SMSReciver();
            $SMSReciver = $MyReciveSMS->GetInputSMS();
        } else {
            $SMSReciver = 'NoLic';
        }
        $OrderClass = new Orders();
        $MyOrders = $OrderClass->ViewOrders(Auth::id(), Auth::user()->Role);
        $orderstatus = orderstatus::all();
        $Query = "SELECT activeShift.OwnerUserID, activeShift.ResponserID, activeShift.Name, activeShift.Family, activeShift.ContractID, activeShift.CreateDate, activeShift.CreateBy, activeShift.StartRespns, activeShift.EndRespns, activeShift.RespnsType,activeShift.RespnsTypeName, activeShift.DeletedBy, activeShift.DeletedTime, activeShift.Note ,UserInfo.Name as ownername , UserInfo.Family as ownerFamily,activeShift.ownerMobile as ownerMobile , UserInfo.MobileNo as RespMobileNo
FROM activeShift inner join UserInfo
WHERE activeShift.OwnerUserID = UserInfo.UserName and activeShift.RespnsType > 0 $mybaranch and activeShift.RespnsType < 10000 ";
        $ActiveShifts = DB::select($Query);
        return view("Dashboard.DashboardAdmin", ['SMSReciver' => $SMSReciver, 'MyOrders' => $MyOrders, 'orderstatus' => $orderstatus, 'ActiveShifts' => $ActiveShifts]);
    }
    public function Dodealer_dashboard(Request $request)
    {

        if ($request->has('add')) {

            // add call to deal
            $calls = new DealCalls;
            $call_id = $request->add;
            $call_src = Calls::where('CallID', $call_id)->first();
            $call_attr = [
                'call_id' => $call_id,
                'Status' => $request->Status,
                'CallType' => $request->CallType,
                'note' => $request->note,
                'call_src' => $call_src,
            ];
            $CallerUser = $call_src->CallerUser;
            if ($CallerUser == 'tofo') {
                $caller_attr = [
                    'username' => null,
                    'MobileNo' => $call_src->CallerNumber,
                    'Name' => $request->Name,
                    'Family' => $request->Family,
                    'Sex' => $request->Sex
                ];
            } else {
                $caller_attr = [
                    'username' => $CallerUser,
                ];
            }
            $file_attr = [
                'file_id' => $request->file_id
            ];



            return $calls->define_incoming_call($call_attr, $caller_attr, $file_attr);
        }
    }
    public function dealer_dashboard()
    {
        if (Auth::user()->branch != null) {
            if (Auth::user()->branch == myappenv::Branch) {
                $mybaranch = '';
            } else {
                $mybaranch = ' and UserInfo.branch = ' . Auth::user()->branch;
            }
        } else {
            $mybaranch = '';
        }
        $OrderClass = new Orders();
        $MyOrders = $OrderClass->ViewOrders(Auth::id(), Auth::user()->Role);
        $orderstatus = orderstatus::all();
        $UserId = Auth::id();
        $Query = "SELECT count(*) FROM RelatedStaff WHERE DeletedBy is null and ResponserID = '$UserId' GROUP by OwnerUserID;";
        $MyCustomers = DB::select($Query);
        $MyCustomers = count($MyCustomers);
        $Query = "SELECT activeShift.OwnerUserID, activeShift.ResponserID, activeShift.Name, activeShift.Family, activeShift.ContractID, activeShift.CreateDate, activeShift.CreateBy, activeShift.StartRespns, activeShift.EndRespns, activeShift.RespnsType,activeShift.RespnsTypeName, activeShift.DeletedBy, activeShift.DeletedTime, activeShift.Note ,UserInfo.Name as ownername , UserInfo.Family as ownerFamily,activeShift.ownerMobile as ownerMobile , UserInfo.MobileNo as RespMobileNo
FROM activeShift inner join UserInfo
WHERE activeShift.OwnerUserID = UserInfo.UserName and activeShift.RespnsType>0 $mybaranch and activeShift.RespnsType<10000 ";
        $ActiveShifts = DB::select($Query);
        $deal_functions = new DealBase;
        $dealer_files = $deal_functions->get_dealer_files(Auth::id());
        $calls = $deal_functions->my_un_defined_calls(Auth::id());

        return view("Dashboard.DashboardDealer", ['calls' => $calls, 'deal_functions' => $deal_functions, 'dealer_files' => $dealer_files, 'MyCustomers' => $MyCustomers, 'MyOrders' => $MyOrders, 'orderstatus' => $orderstatus, 'ActiveShifts' => $ActiveShifts]);
    }
    public function hiring_dashboard()
    {
        $worker_class = new hiring_workers;
        $worker_class->worker_setter(Auth::id());

        return view("Dashboard.DashboardHiring", ['worker_class' => $worker_class, 'worker_class' => $worker_class]);
    }
    public function WorkerDashboard(Request $request)
    {

        if (myappenv::Lic['hiring']) {
            return $this->hiring_dashboard();
        }
        if (myappenv::Lic['deal']) {
            return $this->dealer_dashboard();
        }
        if (Auth::user()->branch != null) {
            if (Auth::user()->branch == myappenv::Branch) {
                $mybaranch = '';
            } else {
                $mybaranch = ' and UserInfo.branch = ' . Auth::user()->branch;
            }
        } else {
            $mybaranch = '';
        }
        $OrderClass = new Orders();
        $MyOrders = $OrderClass->ViewOrders(Auth::id(), Auth::user()->Role);
        $orderstatus = orderstatus::all();
        $UserId = Auth::id();
        $Query = "SELECT count(*) FROM RelatedStaff WHERE DeletedBy is null and ResponserID = '$UserId' GROUP by OwnerUserID;";
        $MyCustomers = DB::select($Query);
        $MyCustomers = count($MyCustomers);
        $Query = "SELECT activeShift.OwnerUserID, activeShift.ResponserID, activeShift.Name, activeShift.Family, activeShift.ContractID, activeShift.CreateDate, activeShift.CreateBy, activeShift.StartRespns, activeShift.EndRespns, activeShift.RespnsType,activeShift.RespnsTypeName, activeShift.DeletedBy, activeShift.DeletedTime, activeShift.Note ,UserInfo.Name as ownername , UserInfo.Family as ownerFamily,activeShift.ownerMobile as ownerMobile , UserInfo.MobileNo as RespMobileNo
FROM activeShift inner join UserInfo
WHERE activeShift.OwnerUserID = UserInfo.UserName and activeShift.RespnsType>0 $mybaranch and activeShift.RespnsType<10000 ";
        $ActiveShifts = DB::select($Query);
        $type = $request->action;
        $hiring = new hiring_skills;
        return view("Dashboard.DashboardWorker", ['hiring' => $hiring, 'type' => $type, 'MyCustomers' => $MyCustomers, 'MyOrders' => $MyOrders, 'orderstatus' => $orderstatus, 'ActiveShifts' => $ActiveShifts]);
    }
    public function ShopOwner()
    {
        $Product = new ProductClass();
        $UserBranch = Auth::user()->branch;
        $TargetStore = store::where('branch', $UserBranch)->first();
        $Product->SetShopID($TargetStore->id);
        $Myfin = new Financial();
        $UserCredit = $Myfin->UserHasCredite(Auth::id(), myappenv::CachCredit);
        $DashboardClass = new DashboardClass();
        Session::put('UserCredit', $UserCredit);
        $OrderClass = new Orders();
        $MyOrders = $OrderClass->ViewOrders(Auth::id(), Auth::user()->Role);
        $orderstatus = orderstatus::all();
        if (myappenv::Lic['hozorgheyab']) {
            $hozorgheyabobj = new Entrance();
            $hozorgheyabs = $hozorgheyabobj->OnlinePersonel($UserBranch);
        } else {
            $hozorgheyabs = [];
        }

        $daramad = myappenv::StackHolder . $UserBranch;

        $Query = "SELECT sum(Mony) as mony, date(Confirmdate) as confirmdate  FROM UserCredit  WHERE UserName = '$daramad' and Date(Confirmdate) > (CURDATE()- INTERVAL 14 DAY) GROUP by Date(Confirmdate)  ORDER BY Date(Confirmdate) ASC  ";
        $DaramadGraph = DB::select($Query);
        return view("Dashboard.DashboardShpOwner", ['DaramadGraph' => $DaramadGraph, 'hozorgheyabs' => $hozorgheyabs, 'MyOrders' => $MyOrders, 'orderstatus' => $orderstatus, 'DashboardClass' => $DashboardClass, 'UserCredit' => $UserCredit, 'Product' => $Product]);
    }
    public function ShopAdmin()
    {
        $DashboardClass = new DashboardClass();
        $Product = new ProductClass();
        $OrderClass = new Orders();
        $MyOrders = $OrderClass->ViewOrders(Auth::id(), Auth::user()->Role);
        $orderstatus = orderstatus::all();
        return view("Dashboard.DashboardShpAdmin", ['MyOrders' => $MyOrders, 'orderstatus' => $orderstatus, 'DashboardClass' => $DashboardClass, 'Product' => $Product]);
    }
    public function callcenter()
    {
        $DashboardClass = new DashboardClass();
        $Product = new ProductClass();
        $OrderClass = new Orders();

        return view("Dashboard.DashboardCallcenter", ['DashboardClass' => $DashboardClass, 'Product' => $Product]);
    }
    public function AccountingDashboard()
    {
        $DashboardClass = new DashboardClass();
        $Product = new ProductClass();
        $OrderClass = new Orders();
        $branch = Auth::user()->branch;
        $daramad = myappenv::StackHolder . $branch;
        $Query = "SELECT sum(Mony) as mony, date(Confirmdate) as confirmdate  FROM UserCredit  WHERE UserName = '$daramad' and Date(Confirmdate) > (CURDATE()- INTERVAL 14 DAY) GROUP by Date(Confirmdate)  ORDER BY Date(Confirmdate) ASC  ";
        //todo: delete this line V
        //$Query = "SELECT sum(Mony) as mony, date(Confirmdate) as confirmdate FROM UserCredit WHERE UserName = 'daramad' and Confirmdate >'2020-04-20' and Confirmdate <'2020-05-02' GROUP by Date(Confirmdate) ORDER BY Date(Confirmdate) ASC";
        $DaramadGraph = DB::select($Query);
        $MyOrders = $OrderClass->ViweOrderList();

        return view("Dashboard.DashboardAccounting", ['MyOrders' => $MyOrders, 'DashboardClass' => $DashboardClass, 'Product' => $Product, 'DaramadGraph' => $DaramadGraph]);
    }
    public function get_license_count()
    {
        $count = 0;
        foreach (myappenv::Lic as $licitem) {
            if ($licitem) {
                $count++;
            }
        }
        return $count;
    }


    public function Main(Request $request)
    {


        if ($request->has('MC')) {
            $Marketing = new MarketingClass();
            $Marketing->MarketingCodeEntered($request->MC);
        }
        if (!Auth::check()) {
            if (myappenv::Lic['wpa']) {
                return $this->CustomerDashboard();
            } else {
                return redirect()->route('login');
            }
        }
        if (isset(myappenv::Lic['family']) && Auth::user()->Role == myappenv::role_customer) {
            if (myappenv::Lic['family']) {
                $family = new family_dashboard();
                return $family->family_dashboard($request);
            }
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

        if (myappenv::Lic['wpa'] && $SiteView && Auth::check() && Auth::user()->Role == myappenv::role_customer) {
            return $this->CustomerDashboard();
        }

        $Myfin = new Financial();
        Session::put('UserCredit', $Myfin->UserHasCredite(Auth::id(), myappenv::CachCredit));

        $MyAlert = new AlertsNotifications();
        $MyAlert->MyNotification(Auth::id(), Auth::user()->Role);
        $accesstype = Session::get('accesstype');
        if ($SiteView) {
            return $this->CustomerDashboard();
        }
        switch (Auth::user()->Role) {

            case myappenv::role_SuperAdmin:
                return $this->SuperAdminDashboard();
                break;
            case myappenv::role_admin:
                if (\App\myappenv::Lic['auto'] ?? false) {
                    $auto = new UserWorks();
                    return $auto->user_dasahbord();
                }
                $MyAlert = new AlertsNotifications();
                $MyAlert->MyNotification(\Illuminate\Support\Facades\Auth::id(), Auth::user()->Role);
                return $this->AdminDashboard();
                break;
            case myappenv::role_customer:

                return $this->CustomerDashboard();
                break;
            case myappenv::role_ShopOwner:
                return $this->ShopOwner();
                break;
            case myappenv::role_worker:
                return $this->WorkerDashboard($request);
                break;
            case myappenv::role_ShopAdmin:
                return $this->ShopAdmin();
                break;
            case myappenv::role_callcenter:
                return $this->callcenter();
                break;
            case myappenv::role_trader:
                return $this->TraderDashboard();
                break;
            case myappenv::role_Accounting:
                return $this->AccountingDashboard();
                break;

        }
    }
}

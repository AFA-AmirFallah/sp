@php
    $Persian = new App\Functions\persian();
    $Feilds = App\Functions\CacheData::GetSetting('dashboard_su');
    $Feilds = json_decode($Feilds) ?? [];

@endphp
@extends('Layouts.MainPage')
@section('page-header-left')
@endsection
@section('MainCountent')
    <!-- Container-fluid starts-->

    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-lg-12">
                    <div class="page-header-left">
                        <h3>{{ __('Dashboard') }}
                            @if (App\branchenv::is_multi_branch())
                                @php
                                    $branch_src = \App\branchenv::get_branch();
                                @endphp
                                <form
                                    style="
                                display: contents;
                            "
                                    method="POST" action="{{ route('dashboard') }}">
                                    @csrf
                                    <small
                                        style="
                                    display: inline-flex;
                                ">
                                        <select name="branch" class="form-control">
                                            @foreach (\App\branchenv::get_all_branches() as $branch_item)
                                                <option value="{{ $branch_item->id }}"
                                                    @if ($branch_item->id == $branch_src['CenterID']) selected @endif>
                                                    {{ $branch_item->Name }}</option>
                                            @endforeach
                                        </select>
                                        <button type="submit" name="change_branch" value="1"
                                            class="btn btn-success">تغییر شعبه</button>
                                    </small>
                                </form>
                            @else
                                <small>{{ __('Dashboard') }}</small>
                            @endif

                        </h3>

                    </div>
                </div>
                <div class="col-lg-6">
                    <ol class="breadcrumb pull-right">
                        @include('Layouts.AddressBar')

                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
    <div id="app">
        <Superadmin></Superadmin>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <div class="row">
        @if ($Feilds->product_crawler ?? false)
            <div class="col-lg-12 col-md-12">
                @include('Dashboard.layouts.crawler_product')

            </div>
            <br>
        @endif
        @if ($Feilds->lic ?? false)
            <div class="col-lg-12 col-md-12">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="card-title m-0">سامانه من</div>
                            <p class="text-small text-muted">لایسنس های سامانه جامع کسب و کار دیجی کار</p>
                            <button id="show_lic_btn" onclick="show_lic()"
                                style="width: 41px;position: absolute;left: 10px;top: 23px;"
                                class="form-control btn btn-success"> V </button>
                            <button id="hide_lic_btn" onclick="hide_lic()"
                                style="width: 41px;position: absolute;left: 10px;top: 23px;"
                                class="nested form-control btn btn-success"> ^ </button>
                            <div id='licens_view' class="row nested">
                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 mb-4">
                                    @if (App\myappenv::Lic['HCIS'])
                                        <div class="p-4 rounded d-flex align-items-center bg-primary text-white">
                                            <i class="i-Data-Backup text-32 mr-3"></i>
                                            <div>
                                                <h4 class="text-18 mb-1 text-white">{{ __('Active shifts') }}</h4>
                                                <span><b>{{ $DashboardClass->GetTotallActiveShift() }}</b> شیفت در حال
                                                    انجام</span>
                                            </div>
                                        </div>
                                    @else
                                        <div class="p-4 rounded d-flex align-items-center bg-danger text-white">
                                            <i class="i-Data-Backup text-32 mr-3"></i>
                                            <div>
                                                <h4 class="text-18 mb-1 text-white">{{ __('Active shifts') }}</h4>
                                                <span>بدون لایسنس</span>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 mb-4">
                                    @if (App\myappenv::Lic['PersonelCard'])
                                        <div class="p-4 rounded d-flex align-items-center bg-primary text-white">
                                            <i class="i-Address-Book text-32 mr-3"></i>
                                            <div>
                                                <h4 class="text-18 mb-1 text-white">کارت پرسنلی</h4>
                                                <span>فعال</span>
                                            </div>
                                        </div>
                                    @else
                                        <div class="p-4 rounded d-flex align-items-center bg-danger text-white">
                                            <i class="i-Address-Book text-32 mr-3"></i>
                                            <div>
                                                <h4 class="text-18 mb-1 text-white">کارت پرسنلی</h4>
                                                <span>بدون لایسنس</span>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 mb-4">
                                    @if (App\myappenv::Lic['hozorgheyab'])
                                        <div class="p-4 rounded d-flex align-items-center bg-primary text-white">
                                            <i class="i-Myspace text-32 mr-3"></i>
                                            <div>
                                                <h4 class="text-18 mb-1 text-white">حضور غیاب پرسنل</h4>
                                                <span><b>{{ $DashboardClass->GetTotallActiveUsers(Auth::user()->branch) }}</b>
                                                    پرسنل مشغول به
                                                    کار </span>
                                            </div>
                                        </div>
                                    @else
                                        <div class="p-4 rounded d-flex align-items-center bg-danger text-white">
                                            <i class="i-Myspace text-32 mr-3"></i>
                                            <div>
                                                <h4 class="text-18 mb-1 text-white">پرسنل فعال</h4>
                                                <span>بدون لایسنس</span>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 mb-4">
                                    @if (App\myappenv::Lic['news'])
                                        <div class="p-4 rounded d-flex align-items-center bg-primary text-white">
                                            <i class="i-Newspaper-2 text-32 mr-3"></i>
                                            <div>
                                                <h4 class="text-18 mb-1 text-white">سایت خبری</h4>
                                                <span><b>
                                                        {{ $DashboardClass->GetTotallActiveNews() }} </b> خبر منتشر
                                                    شده</span>
                                            </div>
                                        </div>
                                    @else
                                        <div class="p-4 rounded d-flex align-items-center bg-danger text-white">
                                            <i class="i-Newspaper-2 text-32 mr-3"></i>
                                            <div>
                                                <h4 class="text-18 mb-1 text-white">سایت خبری</h4>
                                                <span>بدون لایسنس</span>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 mb-4">
                                    @if (App\myappenv::Lic['wpa'])
                                        <div class="p-4 rounded d-flex align-items-center bg-primary text-white">
                                            <i class="i-Smartphone--Secure text-32 mr-3"></i>
                                            <div>
                                                <h4 class="text-18 mb-1 text-white">اپلیکیشن موبایل </h4>
                                                <span>فعال</span>
                                            </div>
                                        </div>
                                    @else
                                        <div class="p-4 rounded d-flex align-items-center bg-danger text-white">
                                            <i class="i-Smartphone--Secure text-32 mr-3"></i>
                                            <div>
                                                <h4 class="text-18 mb-1 text-white">اپلیکیشن موبایل </h4>
                                                <span>بدون لایسنس</span>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 mb-4">
                                    @if (App\myappenv::Lic['HCIS_Workflow'])
                                        <div class="p-4 rounded d-flex align-items-center bg-primary text-white">
                                            <i class="i-Network text-32 mr-3"></i>
                                            <div>
                                                <h4 class="text-18 mb-1 text-white">گردش کار </h4>
                                                <span><b>
                                                        {{ $DashboardClass->GetTotallWorkFlow() }} </b> گردش کار ثبت
                                                    شده</span>
                                            </div>
                                        </div>
                                    @else
                                        <div class="p-4 rounded d-flex align-items-center bg-danger text-white">
                                            <i class="i-Network text-32 mr-3"></i>
                                            <div>
                                                <h4 class="text-18 mb-1 text-white">گردش کار </h4>
                                                <span>بدون لایسنس</span>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 mb-4">
                                    @if (App\myappenv::Lic['device'])
                                        <div class="p-4 rounded d-flex align-items-center bg-primary text-white">
                                            <i class="i-Rotation-390 text-32 mr-3"></i>
                                            <div>
                                                <h4 class="text-18 mb-1 text-white"> اجاره تجهیزات </h4>
                                                <span><b>
                                                        {{ $DashboardClass->GetTotallRentDevice() }} </b> قرارداد
                                                    اجاره</span>
                                            </div>
                                        </div>
                                    @else
                                        <div class="p-4 rounded d-flex align-items-center bg-danger text-white">
                                            <i class="i-Rotation-390 text-32 mr-3"></i>
                                            <div>
                                                <h4 class="text-18 mb-1 text-white"> اجاره تجهیزات </h4>
                                                <span>بدون لایسنس</span>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 mb-4">
                                    @if (App\myappenv::Lic['Service'])
                                        <div class="p-4 rounded d-flex align-items-center bg-primary text-white">
                                            <i class="i-Professor text-32 mr-3"></i>
                                            <div>
                                                <h4 class="text-18 mb-1 text-white">مدیریت خدمات </h4>

                                                <span> <b>{{ $DashboardClass->GetTotallOrders() }} </b> درخواست خدمت
                                                    فعال</span>
                                            </div>
                                        </div>
                                    @else
                                        <div class="p-4 rounded d-flex align-items-center bg-danger text-white">
                                            <i class="i-Professor text-32 mr-3"></i>
                                            <div>
                                                <h4 class="text-18 mb-1 text-white">مدیریت خدمات </h4>
                                                <span>بدون لایسنس</span>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 mb-4">
                                    @if (App\myappenv::Lic['MultiBranch'])
                                        <div class="p-4 rounded d-flex align-items-center bg-primary text-white">
                                            <i class="i-Shop-4 text-32 mr-3"></i>
                                            <div>
                                                <h4 class="text-18 mb-1 text-white">مدیریت شعب </h4>
                                                <span> {{ $baranches }} شعبه</span>
                                            </div>
                                        </div>
                                    @else
                                        <div class="p-4 rounded d-flex align-items-center bg-danger text-white">
                                            <i class="i-Shop-4 text-32 mr-3"></i>
                                            <div>
                                                <h4 class="text-18 mb-1 text-white">مدیریت شعب </h4>
                                                <span>بدون لایسنس</span>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 mb-4">
                                    @if (App\myappenv::Lic['moshavereh'])
                                        <div class="p-4 rounded d-flex align-items-center bg-primary text-white">
                                            <i class="i-Speak-2 text-32 mr-3"></i>
                                            <div>
                                                <h4 class="text-18 mb-1 text-white"> مشاوره تلفنی </h4>
                                                <span>فعال</span>
                                            </div>
                                        </div>
                                    @else
                                        <div class="p-4 rounded d-flex align-items-center bg-danger text-white">
                                            <i class="i-Speak-2 text-32 mr-3"></i>
                                            <div>
                                                <h4 class="text-18 mb-1 text-white"> مشاوره تلفنی </h4>
                                                <span>بدون لایسنس</span>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 mb-4">
                                    @if (App\myappenv::Lic['SmartInvoice'])
                                        <div class="p-4 rounded d-flex align-items-center bg-primary text-white">
                                            <i class="i-Receipt text-32 mr-3"></i>
                                            <div>
                                                <h4 class="text-18 mb-1 text-white"> فاکتور هوشمند </h4>

                                                <span><b>{{ $DashboardClass->GetTotallSmartInvoice() }}</b> فاکتور صادر
                                                    شده </span>
                                            </div>
                                        </div>
                                    @else
                                        <div class="p-4 rounded d-flex align-items-center bg-danger text-white">
                                            <i class="i-Receipt text-32 mr-3"></i>
                                            <div>
                                                <h4 class="text-18 mb-1 text-white"> فاکتور هوشمند </h4>
                                                <span>بدون لایسنس</span>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 mb-4">
                                    @if (App\myappenv::Lic['CustomerUpload'])
                                        <div class="p-4 rounded d-flex align-items-center bg-primary text-white">
                                            <i class="i-Upload text-32 mr-3"></i>
                                            <div>
                                                <h4 class="text-18 mb-1 text-white"> مدیریت آپلود </h4>
                                                <span>فعال</span>
                                            </div>
                                        </div>
                                    @else
                                        <div class="p-4 rounded d-flex align-items-center bg-danger text-white">
                                            <i class="i-Upload text-32 mr-3"></i>
                                            <div>
                                                <h4 class="text-18 mb-1 text-white"> مدیریت آپلود </h4>
                                                <span>بدون لایسنس</span>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 mb-4">
                                    @if (App\myappenv::Lic['SMSReciver'])
                                        <div class="p-4 rounded d-flex align-items-center bg-primary text-white">
                                            <i class="i-Receipt-4 text-32 mr-3"></i>
                                            <div>
                                                <h4 class="text-18 mb-1 text-white">دریافت پیامک</h4>
                                                <span>فعال</span>
                                            </div>
                                        </div>
                                    @else
                                        <div class="p-4 rounded d-flex align-items-center bg-danger text-white">
                                            <i class="i-Receipt-4 text-32 mr-3"></i>
                                            <div>
                                                <h4 class="text-18 mb-1 text-white">دریافت پیامک</h4>
                                                <span>بدون لایسنس</span>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 mb-4">
                                    @if (App\myappenv::Lic['Statistics'])
                                        <div class="p-4 rounded d-flex align-items-center bg-primary text-white">
                                            <i class="i-Statistic text-32 mr-3"></i>
                                            <div>
                                                <h4 class="text-18 mb-1 text-white">آمار بازدید</h4>
                                                <span>فعال</span>
                                            </div>
                                        </div>
                                    @else
                                        <div class="p-4 rounded d-flex align-items-center bg-danger text-white">
                                            <i class="i-Statistic text-32 mr-3"></i>
                                            <div>
                                                <h4 class="text-18 mb-1 text-white">آمار بازدید</h4>
                                                <span>بدون لایسنس</span>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 mb-4">
                                    @if (App\myappenv::Lic['woocommerce'])
                                        <div class="p-4 rounded d-flex align-items-center bg-primary text-white">
                                            <i class="i-Shopping-Cart text-32 mr-3"></i>
                                            <div>
                                                <h4 class="text-18 mb-1 text-white">فروشگاه اینترنتی</h4>
                                                <span> <b>
                                                        {{ $DashboardClass->GetTotallActiveShop() }} </b> فروشگاه
                                                    فعال</span>
                                            </div>
                                        </div>
                                    @else
                                        <div class="p-4 rounded d-flex align-items-center bg-danger text-white">
                                            <i class="i-Shopping-Cart text-32 mr-3"></i>
                                            <div>
                                                <h4 class="text-18 mb-1 text-white">فروشگاه اینترنتی</h4>
                                                <span>بدون لایسنس</span>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 mb-4">
                                    @if (App\myappenv::Lic['Ticketing'])
                                        <div class="p-4 rounded d-flex align-items-center bg-primary text-white">
                                            <i class="i-Ticket text-32 mr-3"></i>
                                            <div>
                                                <h4 class="text-18 mb-1 text-white">مدیریت تیکت ها</h4>
                                                <span>فعال</span>
                                            </div>
                                        </div>
                                    @else
                                        <div class="p-4 rounded d-flex align-items-center bg-danger text-white">
                                            <i class="i-Ticket text-32 mr-3"></i>
                                            <div>
                                                <h4 class="text-18 mb-1 text-white">مدیریت تیکت ها</h4>
                                                <span>بدون لایسنس</span>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 mb-4">
                                    @if (App\myappenv::Lic['crypto'])
                                        <div class="p-4 rounded d-flex align-items-center bg-primary text-white">
                                            <i class="i-Bitcoin text-32 mr-3"></i>
                                            <div>
                                                <h4 class="text-18 mb-1 text-white">سرمایه گذاری</h4>
                                                <span>فعال</span>
                                            </div>
                                        </div>
                                    @else
                                        <div class="p-4 rounded d-flex align-items-center bg-danger text-white">
                                            <i class="i-Bitcoin text-32 mr-3"></i>
                                            <div>
                                                <h4 class="text-18 mb-1 text-white">سرمایه گذاری</h4>
                                                <span>بدون لایسنس</span>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 mb-4">
                                    @if (App\myappenv::Lic['userlic'])
                                        <div class="p-4 rounded d-flex align-items-center bg-primary text-white">
                                            <i class="i-Diploma-2 text-32 mr-3"></i>
                                            <div>
                                                <h4 class="text-18 mb-1 text-white">مدیریت مجوز ها</h4>
                                                <span>فعال</span>
                                            </div>
                                        </div>
                                    @else
                                        <div class="p-4 rounded d-flex align-items-center bg-danger text-white">
                                            <i class="i-Diploma-2 text-32 mr-3"></i>
                                            <div>
                                                <h4 class="text-18 mb-1 text-white">مدیریت مجوز ها</h4>
                                                <span>بدون لایسنس</span>
                                            </div>
                                        </div>
                                    @endif
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>
        @endif
        @if ($Feilds->product_alert ?? false)
            <div class="col-lg-6 col-md-12 mb-5">
                <div class="card">
                    <div style="text-align: center" class="card-header green">

                        <div class="card-title"> <i class="i-Gift-Box"
                                style="font-size: 30px;display: inherit;color: cornsilk;"></i>پرفروشهای ۳۰ روز گذشته
                        </div>

                    </div>
                    <div class="card-body">

                        <div>
                            <table class="table" id="basic-1" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>تصویر</th>
                                        <th>محصول</th>
                                        <th>تعداد فروش</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach (App\Shop\ProductAlert::most_sell_30_days() as $most_sell)
                                        <tr>
                                            <td>
                                                <a href="{{ route('EditProduct', ['id' => $most_sell->id]) }}">
                                                    <img style="height: 60px;"
                                                        src="{{ App\Functions\Images::GetPicture($most_sell->ImgURL, 1) }}"
                                                        alt="">
                                                </a>
                                            </td>
                                            <td><a
                                                    href="{{ route('EditProduct', ['id' => $most_sell->id]) }}">{{ $most_sell->NameFa }}</a>
                                            </td>
                                            <td>{{ $most_sell->product_qty }}</td>
                                        </tr>
                                    @endforeach



                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if ($Feilds->product_alert ?? false)
            <div class="col-lg-6 col-md-12 mb-5">
                <div class="card">
                    <div style="text-align: center" class="card-header green">

                        <div class="card-title"> <i class="i-Gift-Box"
                                style="font-size: 30px;display: inherit;color: cornsilk;"></i>محصولات درخواستی مشتریان
                        </div>

                    </div>
                    <div class="card-body">

                        <div>
                            <table class="table" id="basic-1" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>تصویر</th>
                                        <th>محصول</th>
                                        <th>تعداد درخواست</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach (App\Shop\ProductAlert::get_alert_product_all() as $product_alert)
                                        <tr>
                                            <td>
                                                <a href="{{ route('EditProduct', ['id' => $product_alert->id]) }}">
                                                    <img style="height: 60px;"
                                                        src="{{ App\Functions\Images::GetPicture($product_alert->ImgURL, 1) }}"
                                                        alt="">
                                                </a>
                                            </td>
                                            <td><a
                                                    href="{{ route('EditProduct', ['id' => $product_alert->id]) }}">{{ $product_alert->NameFa }}</a>
                                            </td>
                                            <td>{{ $product_alert->row_count }}</td>
                                        </tr>
                                    @endforeach



                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if ($Feilds->sms_recive ?? false)
            <div class="col-lg-6  col-md-12  mb-5">
                <div class="card">
                    <div style="text-align: center" class="card-header orange">
                        <div class="card-title"> <i class="i-Mail"
                                style="font-size: 30px;display: inherit;color: cornsilk;"></i> پیامک های دریافتی سامانه
                        </div>
                    </div>
                    <div class="card-body">
                        <div>
                            <table class="table" id="basic-1" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>نام ارسال کننده</th>
                                        <th>متن ارسال کننده </th>
                                        <th> عملیات </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <form action="{{ route('Dodashboard') }}" method="POST">
                                        @csrf

                                        @foreach ($SMS as $SMSResult)
                                            <tr>
                                                <td><a href="{{ route('UserProfile', ['RequestUser' => $SMSResult->Sender]) }}"
                                                        target="_blank"> {{ $SMSResult->Name }}
                                                        {{ $SMSResult->Family }}</a>
                                                </td>

                                                <td>{{ $SMSResult->Message }}</td>
                                                <td><button type="submit" name="confirmsms"
                                                        value="{{ $SMSResult->SMSID }}"
                                                        class="btn btn-danger">تایید</button>
                                                    <button type="submit" name="Deletesms"
                                                        value="{{ $SMSResult->SMSID }}"
                                                        class="btn btn-primary">حذف</button>

                                                </td>
                                            </tr>
                                        @endforeach
                                    </form>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <br>
        @endif
        @if ($Feilds->product_danger ?? false)
            <div class="col-lg-6 col-md-12 mb-5">
                <div class="card">
                    <div style="text-align: center" class="card-header green">
                        <div class="card-title"> <i class="i-Gift-Box"
                                style="font-size: 30px;display: inherit;color: cornsilk;"></i> اخطار محصولات
                        </div>
                    </div>
                    <div class="card-body">

                        <div>
                            <table class="table" id="basic-1" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>تصویر</th>
                                        <th> محصول</th>
                                        <th>اخطار</th>
                                        <th>عملیات</th>
                                    </tr>
                                </thead>
                                <tbody>




                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if (\App\myappenv::Lic['news'])
            @if ($Feilds->new_comments ?? false)
                <div class="col-lg-6 col-md-12 mb-5">
                    <div class="card">
                        <div style="text-align: center" class="card-header blue">
                            <div class="card-title text-success"><i class="i-Notepad"
                                    style="font-size: 30px;display: inherit;color: cornsilk;"></i> نظرات جدید </div>
                        </div>
                        <div class="card-body">



                            <form action="{{ route('Dodashboard') }}" method="POST">
                                @csrf

                                @foreach (App\Http\Controllers\News\NewsAdmin::GetComments('Unread') as $Comment)
                                    @php
                                        if ($Comment->OutLink == null) {
                                            $news_route = route('ShowNewsItem', [
                                                'NewsId' => $Comment->Post,
                                                'newsitem' => $Comment->Titel,
                                            ]);
                                        } else {
                                            $news_route = route('ShowNewsItem', [
                                                'NewsId' => $Comment->OutLink,
                                            ]);
                                        }

                                    @endphp
                                    <a class="list-group-item list-group-item-action flex-column align-items-start active"
                                        href="{{ $news_route }}">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h5 class="mb-1 text-white">مطلب شماره : {{ $Comment->Post }}
                                            </h5>
                                            <small>{{ $Persian->MyPersianDate($Comment->created_at, true) }}</small>
                                        </div>
                                        <p class="mb-1">
                                            نام:
                                            @if ($Comment->name == null)
                                                <div style="color: red">
                                                    {{ $Comment->RegsterUserName }}
                                                    {{ $Comment->RegsterUserFamily }}
                                                </div>
                                            @else
                                                {{ $Comment->name }}
                                            @endif

                                        </p>
                                        <p class="mb-1">
                                            پیام: {{ $Comment->message }}
                                        </p>
                                        <p>مطلب: {{ $Comment->Titel }}</p>
                                        <div style="text-align: left">
                                            <button type="submit" title="ثبت" name="confirmcomment"
                                                value="{{ $Comment->id }}" class="btn btn-success "><i
                                                    class="i-Data-Yes"></i> تائید و انتشار </button>
                                            <button type="submit" name="Deletecomment" title="حذف"
                                                value="{{ $Comment->id }}" class="btn btn-danger "><i
                                                    class="i-Data-Block"></i> حذف </button>
                                        </div>

                                    </a>
                                @endforeach
                            </form>


                        </div>
                    </div>

                </div>
            @endif
        @endif
        @if ($Feilds->today_visit ?? false)
            @php
                $counter = 0;
            @endphp
            <div class="col-lg-6 col-md-12 mb-5">
                <div class="card">
                    <div style="text-align: center" class="card-header green">
                        <div class="card-title"> <i class="i-Checked-User"
                                style="font-size: 30px;display: inherit;color: cornsilk;"></i> بازدید های امروز
                        </div>
                    </div>
                    <div class="card-body">

                        <div class="table-responsive">
                            <table id="ul-contact-list" class="{{ \App\myappenv::MainTableClass }}" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>خبر</th>
                                        <th>تعداد بازدید امروز</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach (App\view_counter\View_counter::today_view() as $item)
                                        @php
                                            if ($item->OutLink == null) {
                                                $news_route = route('ShowNewsItem', [
                                                    'NewsId' => $item->id,
                                                    'newsitem' => $item->Titel,
                                                ]);
                                            } else {
                                                $news_route = route('ShowNewsItem', [
                                                    'NewsId' => $item->OutLink,
                                                ]);
                                            }

                                        @endphp
                                        <tr>
                                            <td><a href="{{ $news_route }}" target="_blank">{{ $item->Titel }}</a>
                                            </td>
                                            <td>{{ $item->view_count }}</td>
                                        </tr>
                                        @php
                                            $counter += $item->view_count;
                                        @endphp
                                    @endforeach
                                </tbody>
                            </table>
                            <strong>تعداد کل بازدید: {{ $counter }}</strong>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    @endif
    @if ($Feilds->user_last_24 ?? false)
        <div class="col-lg-6 col-md-12 mb-5">
            <div class="card">
                <div style="text-align: center" class="card-header green">
                    @if (app\myappenv::MainOwner == 'Carpetour')
                        <div class="card-title">کاربران هفت روز گذشته <i class="i-Checked-User"
                                style="font-size: 30px;display: inherit;color: cornsilk;"></i> </div>
                    @else
                        <div class="card-title"> <i class="i-Checked-User"
                                style="font-size: 30px;display: inherit;color: cornsilk;"></i> کاربران ۲۴ ساعت گذشته
                        </div>
                    @endif
                </div>
                <div class="card-body">

                    <div>
                        <table class="table" id="basic-1" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>نام</th>
                                    <th>نام خانوادگی</th>
                                    <th>موبایل</th>
                                    <th> شعبه </th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (app\myappenv::MainOwner == 'Carpetour')
                                    @foreach ($DashboardClass->Last7DaysUsers() as $User)
                                        <tr>
                                            <td><a href="{{ route('UserProfile', ['RequestUser' => $User->UserName]) }}">
                                                    {{ $User->Name }}</a></td>
                                            <td>{{ $User->Family }}</td>
                                            <td>{{ $User->MobileNo }}</td>
                                            <td>{{ $User->BranchName }}</td>

                                        </tr>
                                    @endforeach
                                @else
                                    @foreach ($DashboardClass->Last24Users() as $User)
                                        <tr>
                                            <td><a href="{{ route('UserProfile', ['RequestUser' => $User->UserName]) }}">
                                                    {{ $User->Name }}</a></td>
                                            <td>{{ $User->Family }}</td>
                                            <td>{{ $User->MobileNo }}</td>
                                            <td>{{ $User->BranchName }}</td>

                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if (\App\myappenv::Lic['hozorgheyab'])
        @if ($Feilds->hozorgheyab ?? false)
            <div class=" col-lg-6 col-md-12 mb-5">
                <div class="card">
                    <div style="text-align: center" class="card-header teal">
                        <div class="card-title"><i class="i-Business-Mens"
                                style="font-size: 30px;display: inherit;color: cornsilk;"></i>پرسنل مشغول به کار </div>
                    </div>
                    <div class="card-body">
                        <div>
                            <table class="table" id="basic-1" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>نام</th>
                                        <th>ساعت شروع</th>
                                        <th>از مبدا</th>
                                        @if (Auth::user()->Role == \App\myappenv::role_admin || Auth::user()->Role == \App\myappenv::role_SuperAdmin)
                                            <th>{{ __('Actions') }}</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($hozorgheyabs as $hozorgheyab)
                                        <tr>
                                            <td>{{ $hozorgheyab->Name }} {{ $hozorgheyab->Family }}</td>
                                            <td>{{ $hozorgheyab->entertime }} </td>
                                            <td>{{ $hozorgheyab->enterip }} </td>
                                            <td>-</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        @endif
    @endif
    @if ($Feilds->ticket_statistic ?? false)
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card-title">{{ __('Tickets overview last 30 days') }}</div>
                    <div id="TicketPie" style="height: 300px;"></div>
                </div>
            </div>
        </div>
    @endif
    </div>
    @if ($Feilds->daramad ?? false)
        <div class="col-md-12 mb-5">
            <div class="card ">
                <div style="text-align: center" class="card-header pink">
                    <div class="card-title"><i class="i-Coins"
                            style="font-size: 30px;display: inherit;color: cornsilk;"></i>
                        {{ __('Benefit in last 10 days') }}
                    </div>
                </div>
                <div class="card-body">
                    <div id="mygraph" style="height: 300px;"></div>
                </div>
            </div>
        </div>
    @endif

@endsection


@section('bottom-js')
    @if (app()->getLocale() == 'fa')
        <script src="{{ asset('assets/js/vendor/datatables.min.fa.js') }}"></script>
    @else
        <script src="{{ asset('assets/js/vendor/datatables.min.js') }}"></script>
    @endif
    <script>
        $('#ul-contact-list').DataTable();
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script>
        var w = document.getElementById("mygraph");
        if (w) {
            var g = echarts.init(w);
            g.setOption({
                tooltip: {
                    trigger: "axis",
                    axisPointer: {
                        animation: !0
                    }
                },
                grid: {
                    left: "4%",
                    top: "4%",
                    right: "3%",
                    bottom: "10%"
                },
                xAxis: {
                    type: "category",
                    boundaryGap: !1,
                    data: [
                        @php
                            $counter = 0;
                            $maxfeild = 0;
                        @endphp
                        @foreach ($DaramadGraph as $Daramadfeild)
                            @if ($counter != 0)
                                , "{{ $Persian->MyPersianDate($Daramadfeild->confirmdate) }}"
                                @if ($maxfeild < $Daramadfeild->mony)
                                    @php
                                        $maxfeild = $Daramadfeild->mony;
                                    @endphp
                                @endif
                            @else
                                "{{ $Persian->MyPersianDate($Daramadfeild->confirmdate) }}"
                                @php
                                    $counter = 1;
                                    $maxfeild = $Daramadfeild->mony;
                                @endphp
                            @endif
                        @endforeach
                    ],
                    axisLabel: {
                        formatter: "{value}",
                        color: "#666",
                        fontSize: 12,
                        fontStyle: "normal",
                        fontWeight: 400
                    },
                    axisLine: {
                        lineStyle: {
                            color: "#ccc",
                            width: 1
                        }
                    },
                    axisTick: {
                        lineStyle: {
                            color: "#ccc",
                            width: 1
                        }
                    },
                    splitLine: {
                        show: !1,
                        lineStyle: {
                            color: "#ccc",
                            width: 1
                        }
                    }
                },
                yAxis: {
                    type: "value",
                    min: 0,
                    max: {{ $maxfeild }},
                    interval: 10000000,
                    axisLabel: {
                        formatter: "{value}",
                        color: "#666",
                        fontSize: 12,
                        fontStyle: "normal",
                        fontWeight: 400
                    },
                    axisLine: {
                        lineStyle: {
                            color: "#ccc",
                            width: 1
                        }
                    },
                    axisTick: {
                        lineStyle: {
                            color: "#ccc",
                            width: 1
                        }
                    },
                    splitLine: {
                        lineStyle: {
                            color: "#ddd",
                            width: 1,
                            opacity: .5
                        }
                    }
                },
                series: [{
                    name: "درآمد",
                    type: "line",
                    smooth: !0,
                    data: [
                        @php
                            $counter = 0;
                        @endphp
                        @foreach ($DaramadGraph as $Daramadfeild)
                            @if ($counter != 0)
                                , "{{ $Daramadfeild->mony }}"
                            @else
                                "{{ $Daramadfeild->mony }}"
                                @php
                                    $counter = 1;
                                @endphp
                            @endif
                        @endforeach
                    ],
                    symbolSize: 8,
                    showSymbol: !1,
                    lineStyle: {
                        color: "rgb(255, 87, 33)",
                        opacity: 1,
                        width: 1.5
                    },
                    itemStyle: {
                        show: !1,
                        color: "#ff5721",
                        borderColor: "#ff5721",
                        borderWidth: 1.5
                    },
                    areaStyle: {
                        normal: {
                            color: {
                                type: "linear",
                                x: 0,
                                y: 0,
                                x2: 0,
                                y2: 1,
                                colorStops: [{
                                    offset: 0,
                                    color: "rgba(255, 87, 33, 1)"
                                }, {
                                    offset: .3,
                                    color: "rgba(255, 87, 33, 0.7)"
                                }, {
                                    offset: 1,
                                    color: "rgba(255, 87, 33, 0)"
                                }]
                            }
                        }
                    }
                }]
            }), $(window).on("resize", function() {
                setTimeout(function() {
                    g.resize()
                }, 500)
            })
        }
    </script>
    <script>
        let basicPieElem = document.getElementById('TicketPie');
        if (basicPieElem) {
            let basicPie = echarts.init(basicPieElem);
            basicPie.setOption({
                color: ['#c13018', '#f36d12', '#ebcb37', '#a0b967', '#0d94bc', '#04a9f4'],
                grid: {
                    left: '3%',
                    right: '4%',
                    bottom: '3%',
                    containLabel: true
                },
                xAxis: [{

                    axisLine: {
                        show: false
                    },
                    splitLine: {
                        show: false
                    }
                }],
                yAxis: [{
                    axisLine: {
                        show: false
                    },
                    splitLine: {
                        show: false
                    }
                }],

                series: [{
                        name: 'Sales by Countries',
                        type: 'pie',
                        radius: '75%',
                        center: ['50%', '50%'],
                        data: [
                            @php
                                $counter = 0;
                            @endphp
                            @foreach ($Tiketfilds as $Tiketfild)
                                @if ($counter != 0)
                                    , {
                                        value: {{ $Tiketfild[0] }},
                                        name: '{{ __($Tiketfild[1]) }}'
                                    }
                                @else
                                    {
                                        value: {{ $Tiketfild[0] }},
                                        name: '{{ __($Tiketfild[1]) }}'
                                    }
                                    @php
                                        $counter = 1;
                                    @endphp
                                @endif
                            @endforeach

                        ],
                        itemStyle: {
                            emphasis: {
                                shadowBlur: 10,
                                shadowOffsetX: 0,
                                shadowColor: 'rgba(0, 0, 0, 0.5)'
                            }
                        }
                    }

                ]

            });
            $(window).on('resize', function() {
                setTimeout(() => {
                    basicPie.resize();
                }, 500);
            });
        }
    </script>
    <script>
        function show_lic() {
            $('#licens_view').removeClass('nested');
            $('#hide_lic_btn').removeClass('nested');
            $('#show_lic_btn').addClass('nested');
        }

        function hide_lic() {
            $('#show_lic_btn').removeClass('nested');
            $('#hide_lic_btn').addClass('nested');
            $('#licens_view').addClass('nested');

        }
    </script>
@endsection

@php
    $Persian = new App\Functions\persian();
@endphp
@extends('Theme2.Layouts.MainLayout')

<!-- Content -->
@section('Content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <!-- Gamification Card -->
            <div class="col-md-6 col-lg-4 mb-4 order-0">
                <div class="card h-100">
                    <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                        <h3 class="card-title mb-2">سیگنال خرید روزانه ورژن 3.1
                        </h3>
                        <span class="d-block mb-4 text-nowrap primary-font">بررسی و تحلیل شده با معتبر ترین
                            اندیکاتورها</span>
                        <span class="d-block mb-4 text-nowrap primary-font text-info">هر <b>۴۰</b> دقیقه اجرای آنالیزور انجام
                            می شود</span>
                    </div>
                    @php
                        $LastTime = $Crypto->GetLastMaIndicator();
                    @endphp
                    <div class="card-body">
                        <div class="row align-items-end">
                            <div class="col-6">
                                <div style="display: flex;align-items: baseline;">
                                    <span class="badge bg-label-danger">{{ $LastTime['date'] }} </span>
                                    <h1 class="display-6 text-primary mb-2 pt-3 pb-2"> {{ $LastTime['time'] }}</h1>
                                </div>
                                <small class="d-block mb-3 lh-1-85">با دید باز معامله کنید و پیشنهادات سامانه را به دقت
                                    بررسی نمایید</small>
                                <a href="javascript:;" class="btn btn-sm btn-primary">تایم فریم ۱ ساعته</a>
                            </div>
                            <div class="col-6 text-end">
                                <img src="../../assets/img/illustrations/prize-light.png" width="140" height="150"
                                    class="rounded-start" alt="View Sales"
                                    data-app-light-img="illustrations/prize-light.png"
                                    data-app-dark-img="illustrations/prize-dark.png">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @php
                $MarketSrc = $Crypto->formola_v3_1(5, 'sup', 'spot');
            @endphp
            <div class="col-md-6 col-lg-4 col-xl-4 mb-4 order-0">
                <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="card-title m-0 me-2">پیشنهاد خرید spot</h5>
                        <small>بیشترین مساحت زیر نمودار</small>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-borderless mb-2 lh-inherit">
                            <tbody>
                                @foreach ($MarketSrc as $MarketItem)
                                    <tr>
                                        <td class="pt-0">
                                            <div class="d-flex justify-content-start align-items-center">
                                                <img src="{{ $MarketItem->pic }}" alt="coin" width="44"
                                                    class="me-2">
                                                <div class="d-flex flex-column">
                                                    <p class="mb-0">{{ $MarketItem->MainName }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="article-votes" style="display: flex;direction:rtl">
                                                @if ($MarketItem->meta_key == 'like')
                                                    <a href="javascript:like({{ $MarketItem->id }});"
                                                        style="display:inline-flex;width: 55px;"
                                                        class=" badge bg-label-success me-2 p-2">
                                                        <div style="margin: 3px;" class="like_{{ $MarketItem->id }}">
                                                            {{ $MarketItem->like }}
                                                            <i class="bx bxs-like"></i>
                                                        </div>
                                                    </a>
                                                @else
                                                    <a href="javascript:like({{ $MarketItem->id }});"
                                                        style="display:inline-flex;width: 55px;"
                                                        class=" badge bg-label-success me-2 p-2">
                                                        <div style="margin: 3px;" class="like_{{ $MarketItem->id }}">
                                                            {{ $MarketItem->like }}
                                                            <i class="bx bx-like"></i>
                                                        </div>
                                                    </a>
                                                @endif
                                                @if ($MarketItem->meta_key == 'dislike')
                                                    <a href="javascript:dislike({{ $MarketItem->id }});"
                                                        style="display:inline-flex;width: 55px;"
                                                        class="badge bg-label-danger p-2">
                                                        <div style="margin: 3px;" class="dislike_{{ $MarketItem->id }}">
                                                            {{ $MarketItem->dislike }}
                                                            <i class="bx bxs-dislike"></i>
                                                        </div>
                                                    </a>
                                                @else
                                                    <a href="javascript:dislike({{ $MarketItem->id }});"
                                                        style="display:inline-flex;width: 55px;"
                                                        class="badge bg-label-danger p-2">
                                                        <div style="margin: 3px;" class="dislike_{{ $MarketItem->id }}">
                                                            {{ $MarketItem->dislike }}
                                                            <i class="bx bx-dislike"></i>
                                                        </div>
                                                    </a>
                                                @endif

                                                <a class="badge bg-label-primary p-2" style="margin-right: 10px"
                                                    target="_blank"
                                                    href="{{ route('analyze', ['curency' => $MarketItem->MainName]) }}">
                                                    بررسی
                                                </a>
                                            </div>
                                        </td>

                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


            @php
                $MarketSrc = $Crypto->formola_v3_1(5, 'Growth', 'spot');
            @endphp
            <div class="col-md-6 col-lg-4 col-xl-4 mb-4 order-0">
                <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="card-title m-0 me-2">پیشنهاد خرید spot</h5>
                        <small>روند رشد</small>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-borderless mb-2 lh-inherit">
                            <tbody>
                                @foreach ($MarketSrc as $MarketItem)
                                    <tr>
                                        <td class="pt-0">
                                            <div class="d-flex justify-content-start align-items-center">
                                                <img src="{{ $MarketItem->pic }}" alt="coin" width="44"
                                                    class="me-2">
                                                <div class="d-flex flex-column">
                                                    <p class="mb-0">{{ $MarketItem->MainName }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="pt-0">

                                        <td>
                                            <div class="article-votes" style="display: flex;direction:rtl">
                                                @if ($MarketItem->meta_key == 'like')
                                                    <a href="javascript:like({{ $MarketItem->id }});"
                                                        style="display:inline-flex;width: 55px;"
                                                        class="badge bg-label-success me-2 p-2">
                                                        <div style="margin: 3px;" class="like_{{ $MarketItem->id }}">
                                                            {{ $MarketItem->like }}
                                                            <i class="bx bxs-like"></i>
                                                        </div>
                                                    </a>
                                                @else
                                                    <a href="javascript:like({{ $MarketItem->id }});"
                                                        style="display:inline-flex;width: 55px;"
                                                        class="badge bg-label-success me-2 p-2">
                                                        <div style="margin: 3px;" class="like_{{ $MarketItem->id }}">
                                                            {{ $MarketItem->like }}
                                                            <i class="bx bx-like"></i>
                                                        </div>
                                                    </a>
                                                @endif
                                                @if ($MarketItem->meta_key == 'dislike')
                                                    <a href="javascript:dislike({{ $MarketItem->id }});"
                                                        style="display:inline-flex;width: 55px;"
                                                        class="badge bg-label-danger p-2">
                                                        <div style="margin: 3px;" class="dislike_{{ $MarketItem->id }}">
                                                            {{ $MarketItem->dislike }}
                                                            <i class="bx bxs-dislike"></i>
                                                        </div>
                                                    </a>
                                                @else
                                                    <a href="javascript:dislike({{ $MarketItem->id }});"
                                                        style="display:inline-flex;width: 55px;"
                                                        class="badge bg-label-danger p-2">
                                                        <div style="margin: 3px;" class="dislike_{{ $MarketItem->id }}">
                                                            {{ $MarketItem->dislike }}
                                                            <i class="bx bx-dislike"></i>
                                                        </div>
                                                    </a>
                                                @endif
                                                <a class="badge bg-label-primary p-2" style="margin-right: 10px"
                                                    target="_blank"
                                                    href="{{ route('analyze', ['curency' => $MarketItem->MainName]) }}">
                                                    بررسی
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @php
                $MarketSrc = $Crypto->formola_v3_1(5, 'Growth', 'spot');
            @endphp


            @foreach ($Curencys as $CurencyItem)
                @php
                    $MaxH = 4;
                    
                    $now = new DateTime();
                    $date = new DateTime($CurencyItem->created_at);
                    $ldate = $date->diff($now);
                    $D_Y = $ldate->y; // difrence year
                    $D_M = $ldate->m;
                    $D_D = $ldate->d;
                    $D_h = $ldate->h;
                    $D_m = $ldate->i;
                    $continue = false;
                    if ($D_Y == $D_M && $D_M == $D_D && $D_D == 0) {
                        if ($D_h < $MaxH) {
                            $continue = true;
                            $Dif = $D_h * 60 + $D_m;
                            $Percent = round(($Dif * 100) / ($MaxH * 60));
                            $Percent = 100 - $Percent;
                        }
                    }
                    
                @endphp
                @if ($continue)
                    <div class="col-md-6 col-lg-6 col-xl-6 mb-4 order-0">
                        <div class="card h-100">
                            <div class="card-header d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center me-3">
                                    <img src="{{ $CurencyItem->pic }}" alt="{{ $CurencyItem->curency }} logo"
                                        class="rounded-circle me-3" width="54">
                                    <div class="card-title mb-0">
                                        <h5 class="mb-0">پیشنهاد خرید بر اساس هوش مصنوعی</h5>
                                        <small class="text-muted primary-font">یک پیشهاد عالی برای خرید
                                            {{ $CurencyItem->curency }}</small>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="d-flex flex-wrap gap-4 mb-5 mt-4">
                                    <div class="d-flex flex-column me-2">
                                        <h6>زمان شروع</h6>
                                        <span
                                            class="badge bg-label-success">{{ $Persian->MyPersianDate($CurencyItem->created_at, 1) }}
                                        </span>
                                    </div>
                                    <div class="d-flex flex-column me-2">
                                        <h6>زمان انقضا </h6>
                                        <span class="badge bg-label-danger">حد اکثر ۱ ساعت بعد</span>
                                    </div>
                                    <div class="d-flex flex-column me-2">
                                        <h6>عملیات</h6>
                                        <a class="badge bg-label-primary p-2" style="margin-right: 10px" target="_blank"
                                            href="{{ route('analyze', ['curency' => $CurencyItem->curency]) }}">
                                            بررسی
                                        </a>
                                    </div>
                                    <div class="d-flex flex-column me-2">
                                        <h6>مبلغ زمان پیشنهاد</h6>
                                        <span> {{ $CurencyItem->OpenPrice }} تتر</span>
                                    </div>

                                </div>
                                <div class="d-flex flex-column flex-grow-1">
                                    <span class="text-nowrap lh-1-85 d-block mb-2"> زمان طلایی</span>
                                    <div class="progress w-100 mb-3" style="height: 8px">
                                        @if ($Percent > 80)
                                            <div class="progress-bar bg-success" role="progressbar"
                                                style="width: {{ $Percent }}%" aria-valuenow="{{ $Percent }}"
                                                aria-valuemin="0" aria-valuemax="100"></div>
                                        @elseif($Percent > 60)
                                            <div class="progress-bar bg-info" role="progressbar"
                                                style="width: {{ $Percent }}%" aria-valuenow="{{ $Percent }}"
                                                aria-valuemin="0" aria-valuemax="100"></div>
                                        @elseif($Percent > 40)
                                            <div class="progress-bar bg-primary" role="progressbar"
                                                style="width: {{ $Percent }}%" aria-valuenow="{{ $Percent }}"
                                                aria-valuemin="0" aria-valuemax="100"></div>
                                        @elseif($Percent > 20)
                                            <div class="progress-bar bg-warning" role="progressbar"
                                                style="width: {{ $Percent }}%" aria-valuenow="{{ $Percent }}"
                                                aria-valuemin="0" aria-valuemax="100"></div>
                                        @else
                                            <div class="progress-bar bg-danger" role="progressbar"
                                                style="width: {{ $Percent }}%" aria-valuenow="{{ $Percent }}"
                                                aria-valuemin="0" aria-valuemax="100"></div>
                                        @endif

                                    </div>
                                </div>
                            </div>
                            <div class="card-footer border-top">
                                <ul class="list-inline mb-0">
                                    <li class="list-inline-item"><i class="bx bx-check"></i> بک تست فعال </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">بررسی پیشنهادات سامانه </h5>

                    </div>
                    <div class="card-body">
                        <form method="post">
                            @csrf
                            <div class="flex align-items-left  flex-wrap gap-3">
                                @if ($ActiveSMS)
                                    <button class="btn btn-sm btn-danger" name="submit" value="Deactive_sms"> قطع
                                        ارسال
                                        پیامک</button>
                                @else
                                    <button class="btn btn-sm btn-primary" name="submit" value="active_sms"> فعال سازی
                                        ارسال
                                        پیامک</button>
                                @endif
                                @if ($ActiveRobot)
                                    <button class="btn btn-sm btn-danger" name="submit" value="Deactive_robot">قطع
                                        ربات</button>
                                @else
                                    <a href="{{ route('CoinEdit', ['CoinId' => 'spot_ai']) }}"
                                        class="btn btn-sm btn-primary" type="button">فعال سازی ربات</a>
                                @endif
                            </div>
                        </form>
                    </div>
                    <div class="table-responsive">
                        <table class="table border-top">
                            <thead>
                                <tr>
                                    <th>تاریخ سیگنال</th>
                                    <th>نام ارز</th>
                                    <th>۵ دقیقه</th>
                                    <th>۱۵ دقیقه</th>
                                    <th>۳۰ دقیقه</th>
                                    <th>۱ ساعت</th>
                                    <th>۲ ساعت</th>
                                    <th>۴ ساعت</th>
                                    <th>۲۴ ساعت</th>
                                    <th>وضعیت</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                                @foreach ($Curencys as $CurencyItem)
                                    <tr>
                                        <td> {{ $Persian->MyPersianDate($CurencyItem->created_at, true) }} </td>
                                        <td class="text-nowrap"> <img width="20px" src="{{ $CurencyItem->pic }}"
                                                alt="CoinPic">
                                            {{ $CurencyItem->curency }} </td>

                                        @if ($CurencyItem->C5MuinPercent == '')
                                            <td>مقداردهی نشده</td>
                                        @elseif($CurencyItem->C5MuinPercent < 0)
                                            <td class="text-danger">{{ $CurencyItem->C5MuinPercent }} % </td>
                                        @else
                                            <td class="text-success">{{ $CurencyItem->C5MuinPercent }} % </td>
                                        @endif
                                        @if ($CurencyItem->C15MuinPercent == '')
                                            <td>مقداردهی نشده</td>
                                        @elseif($CurencyItem->C15MuinPercent < 0)
                                            <td class="text-danger">{{ $CurencyItem->C15MuinPercent }} % </td>
                                        @else
                                            <td class="text-success">{{ $CurencyItem->C15MuinPercent }} % </td>
                                        @endif
                                        @if ($CurencyItem->C30MuinPercent == '')
                                            <td>مقداردهی نشده</td>
                                        @elseif($CurencyItem->C30MuinPercent < 0)
                                            <td class="text-danger">{{ $CurencyItem->C30MuinPercent }} % </td>
                                        @else
                                            <td class="text-success">{{ $CurencyItem->C30MuinPercent }} % </td>
                                        @endif
                                        @if ($CurencyItem->C1HourPercent == '')
                                            <td>مقداردهی نشده</td>
                                        @elseif($CurencyItem->C1HourPercent < 0)
                                            <td class="text-danger">{{ $CurencyItem->C1HourPercent }} % </td>
                                        @else
                                            <td class="text-success">{{ $CurencyItem->C1HourPercent }} % </td>
                                        @endif
                                        @if ($CurencyItem->C2HourPercent == '')
                                            <td>مقداردهی نشده</td>
                                        @elseif($CurencyItem->C2HourPercent < 0)
                                            <td class="text-danger">{{ $CurencyItem->C2HourPercent }} % </td>
                                        @else
                                            <td class="text-success">{{ $CurencyItem->C2HourPercent }} % </td>
                                        @endif

                                        @if ($CurencyItem->C4HourPercent == '')
                                            <td>مقداردهی نشده</td>
                                        @elseif($CurencyItem->C4HourPercent < 0)
                                            <td class="text-danger">{{ $CurencyItem->C4HourPercent }} % </td>
                                        @else
                                            <td class="text-success">{{ $CurencyItem->C4HourPercent }} % </td>
                                        @endif

                                        @if ($CurencyItem->C24HourPercent == '')
                                            <td>مقداردهی نشده</td>
                                        @elseif($CurencyItem->C24HourPercent < 0)
                                            <td class="text-danger">{{ $CurencyItem->C24HourPercent }} % </td>
                                        @else
                                            <td class="text-success">{{ $CurencyItem->C24HourPercent }} % </td>
                                        @endif

                                        <td>
                                            @switch($CurencyItem->status)
                                                @case(0)
                                                    شروع تست
                                                @break

                                                @case(1)
                                                    بک تست ۵ دقیقه
                                                @break

                                                @case(2)
                                                    بک تست ۱۵ دقیقه
                                                @break

                                                @case(3)
                                                    بک تست ۳۰ دقیقه
                                                @break

                                                @case(4)
                                                    بک تست ۱ ساعت
                                                @break

                                                @case(5)
                                                    بک تست ۲ ساعت
                                                @break

                                                @case(6)
                                                    بک تست ۴ ساعت
                                                @break

                                                @case(7)
                                                    بک تست ۲۴ ساعت
                                                @break

                                                @default
                                            @endswitch
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!--/ Latest Update -->

            <!-- History -->
        </div>
    </div>
    <script></script>
@endsection
@section('EndScripts')
    <script>
        const $DangerLoader = `<div class="spinner-border spinner-border-sm text-danger">`;
        const $SuccessLoader = `<div class="spinner-border spinner-border-sm text-success">`;
        const $ActiveLike = ` <i class="bx bxs-like"></i>`;
        const $DeActiveLike = ` <i class="bx bx-like"></i>`;
        const $ActiveDislike = `<i class="bx bxs-dislike"></i>`;
        const $DeactiveDislike = `<i class="bx bx-dislike"></i>`;
        const $loader = `<div style="text-align: center;display: inline-block;" class="col">
                                        <div class="sk-wave sk-primary">
                                            <div class="sk-wave-rect"></div>
                                            <div class="sk-wave-rect"></div>
                                            <div class="sk-wave-rect"></div>
                                            <div class="sk-wave-rect"></div>
                                            <div class="sk-wave-rect"></div>
                                        </div>
                                    </div>`;
        let cardColor, headingColor, borderColor, shadeColor;
        if (isDarkStyle) {
            headingColor = config.colors_dark.axisColor;
            borderColor = config.colors_dark.borderColor;
            shadeColor = 'dark';
        } else {
            headingColor = config.colors.axisColor;
            borderColor = config.colors.borderColor;
            shadeColor = 'light';
        }

        function like($CurencyID) {
            $idStr = $CurencyID.toString();
            $('.like_' + $idStr).html($SuccessLoader);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('', {
                    ajax: true,
                    procedure: 'like',
                    sumnumber: '1',
                    Curency: $CurencyID
                },

                function(data, status) {

                    if (data[0] == 'change') {
                        output = '';
                        output += data[2];
                        if (data[1]) {
                            output += $ActiveLike;
                        } else {
                            output += $DeActiveLike;
                        }
                        $('.like_' + $idStr).html(output);
                    }
                    if (data[3] == 'change') {
                        output = '';
                        output += data[5];
                        if (data[4]) {
                            output += $ActiveLike;
                        } else {
                            output += $DeActiveLike;
                        }
                        $('.dislike_' + $idStr).html(output);
                    }


                });

        }

        function dislike($ID) {
            $idStr = $ID.toString();
            $('.dislike_' + $idStr).html($DangerLoader);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('', {
                    ajax: true,
                    procedure: 'like',
                    sumnumber: '-1',
                    Curency: $idStr
                },

                function(data, status) {
                    if (data[0] == 'change') {
                        output = '';
                        output += data[2];
                        if (data[1]) {
                            output += $ActiveLike;
                        } else {
                            output += $DeActiveLike;
                        }
                        $('.like_' + $idStr).html(output);
                    }
                    if (data[3] == 'change') {
                        output = '';
                        output += ' ' + data[5] + ' ';
                        if (data[4]) {
                            output += $ActiveDislike;
                        } else {
                            output += $DeactiveDislike;
                        }
                        $('.dislike_' + $idStr).html(output);
                    }

                });


        }



        function ajaxcall($procedure, $CurencyID) {
            $oUTpUT = 0;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('', {
                    ajax: true,
                    procedure: $procedure,
                    Curency: $CurencyID
                },

                function(data, status) {
                    loadgraph('#' + $procedure, data);
                });


        }

        function analyzeloader($CurencyID) {
            loader_set();
            ajaxcall('volanalyze', $CurencyID);
            ajaxcall('IncreasementAnl', $CurencyID);
            ajaxcall('linepercents', $CurencyID);

        }




        //  loadgraph('#statisticsRadialChart',20)


        function loadgraph(GraphName, PercentVal) {
            if (PercentVal <= 20) {
                TargetColor = config.colors.danger;
            }
            if (PercentVal > 20 && PercentVal <= 50) {
                TargetColor = config.colors.warning;
            }
            if (PercentVal > 50 && PercentVal <= 70) {
                TargetColor = config.colors.info;
            }
            if (PercentVal > 70) {
                TargetColor = config.colors.success;
            }
            statisticsRadialChartEl = document.querySelector(GraphName),
                statisticsRadialChartConfig = {
                    series: [PercentVal],
                    labels: ['پیشنهاد خرید'],
                    chart: {
                        height: 190,
                        type: 'radialBar',
                        sparkline: {
                            enabled: true
                        }
                    },
                    colors: [TargetColor],
                    plotOptions: {
                        radialBar: {
                            offsetY: 0,
                            startAngle: -140,
                            endAngle: 140,
                            hollow: {
                                size: '78%',
                                image: assetsPath + 'img/icons/unicons/rocket.png',
                                imageWidth: 24,
                                imageHeight: 24,
                                imageOffsetY: -40,
                                imageClipped: false
                            },
                            track: {
                                strokeWidth: '100%',
                                background: borderColor
                            },
                            dataLabels: {
                                value: {
                                    offsetY: -5,
                                    color: headingColor,
                                    fontSize: '2rem',
                                    fontWeight: '500'
                                },
                                name: {
                                    offsetY: 40,
                                    color: config.colors.secondary,
                                    fontSize: '0.938rem',
                                    fontWeight: '400'
                                }
                            }
                        }
                    },
                    stroke: {
                        lineCap: 'round'
                    },
                    grid: {
                        padding: {
                            top: -7,
                            bottom: 8
                        }
                    },
                    states: {
                        hover: {
                            filter: {
                                type: 'none'
                            }
                        },
                        active: {
                            filter: {
                                type: 'none'
                            }
                        }
                    }
                };
            if (typeof statisticsRadialChartEl !== undefined && statisticsRadialChartEl !== null) {
                const statisticsRadialChart = new ApexCharts(statisticsRadialChartEl, statisticsRadialChartConfig);
                statisticsRadialChart.render();
            }
        }

        function loadresultchart() {
            const timeSpentGaugeChartEl = document.querySelector('#timeSpentGaugeChart'),
                timeSpentGaugeChartConfig = {
                    series: [90],
                    labels: ['مدت زمان'],
                    chart: {
                        height: 220,
                        type: 'radialBar',
                        sparkline: {
                            enabled: true
                        }
                    },
                    colors: [config.colors.success],
                    plotOptions: {
                        radialBar: {
                            offsetY: 10,
                            startAngle: -140,
                            endAngle: 140,
                            hollow: {
                                size: '55%'
                            },
                            track: {
                                strokeWidth: '100%',
                                background: borderColor
                            },
                            dataLabels: {
                                name: {
                                    offsetY: -10,
                                    color: headingColor,
                                    fontSize: '1.125rem'
                                },
                                value: {
                                    offsetY: 7,
                                    color: config.colors.secondary,
                                    fontSize: '0.938rem',
                                    fontWeight: 500,
                                    formatter: function(val) {
                                        return val + ' دقیقه';
                                    }
                                }
                            }
                        }
                    },
                    stroke: {
                        lineCap: 'round'
                    },
                    grid: {
                        padding: {
                            top: -35,
                            left: -15,
                            right: -15,
                            bottom: 7
                        }
                    },
                    states: {
                        hover: {
                            filter: {
                                type: 'none'
                            }
                        },
                        active: {
                            filter: {
                                type: 'none'
                            }
                        }
                    }
                };
            if (typeof timeSpentGaugeChartEl !== undefined && timeSpentGaugeChartEl !== null) {
                const timeSpentGaugeChart = new ApexCharts(timeSpentGaugeChartEl, timeSpentGaugeChartConfig);
                timeSpentGaugeChart.render();
            }
        }
    </script>
@endsection

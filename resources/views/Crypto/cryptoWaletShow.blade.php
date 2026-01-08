@php
    $Persian = new App\Functions\persian();
    $registeDate = $Persian->MyPersianDate(Auth::user()->CreateDate);
@endphp

@extends('Theme2.Layouts.MainLayout')
@section('PageCSS')
    <link rel="stylesheet" href="/T1assets/vendor/css/pages/page-profile.css">
@endsection

@section('Content')
<div id="app" >
    <Crypto-Backtest></Crypto-Backtest>
</div>
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">کیف رمزارز من</h5>
                    <div class="dropdown primary-font">
                        <button class="btn p-0" type="button" id="orderSummaryOptions" data-bs-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <i class="bx bx-dots-vertical-rounded"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="orderSummaryOptions">
                            <a class="dropdown-item" href="{{ route('WaletShow', 'all') }}">مشاهده تمام رمز ارزها</a>
                            <a class="dropdown-item" href="{{ route('WaletShow') }}">مشاهده رمز ارزهای اصلی</a>
                            <button name="submit" value="syncwithcenter" class="dropdown-item"
                                href="{{ route('WaletShow', 'all') }}">به روز رسانی از صرافی</button>
                        </div>
                    </div>
                </div>


                <div class="card-body">
                    <div style="overflow :inherit" class="table-responsive text-nowrap">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>
                                        نام ارز
                                    </th>
                                    <th>
                                        میزان دارایی
                                    </th>
                                    <th>
                                        مرحله ربات
                                    </th>
                                    <th>
                                        وضعیت
                                    </th>

                                    <th>
                                        عملیات
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                                @foreach ($Userbalances as $UserbalancesItem)
                                    @php
                                        $Buy = '0';
                                    @endphp
                                    <form method="POST">
                                        @csrf
                                        <tr>
                                            <th>
                                                <img src="http://localhost:8000/storage/photos/CryptoLogo/{{ strtolower($UserbalancesItem->CoinName) }}.svg"
                                                    class="me-3" width="22" alt="{{ $UserbalancesItem->CoinName }}">
                                                {{ $UserbalancesItem->CoinName }}
                                            </th>
                                            <th style="direction: ltr;">
                                                {{ $UserbalancesItem->QTY }} ~
                                                ${{ $UserbalancesItem->QTY * $UserbalancesItem->TMN }}
                                            </th>
                                            </th>
                                            <th>
                                                @if ($UserbalancesItem->Status != 100)
                                                    <span class="badge bg-label-info me-1">بدون ربات</span>
                                                @else
                                                    @if ($UserbalancesItem->Robot == 0)
                                                        <span class="badge bg-label-warning me-1"> ربات درحال آماده سازی:
                                                            {{ $UserbalancesItem->Robot - 100 }}</span>
                                                    @else
                                                        <span class="badge bg-label-primary me-1"> ربات فعال مرحله:
                                                            {{ $UserbalancesItem->Robot - 100 }}</span>
                                                    @endif
                                                @endif
                                            </th>
                                            <th>
                                                @php
                                                    if ($UserbalancesItem->Status == 100 && $UserbalancesItem->Robot > 100) {
                                                        $Up = $UserbalancesItem->TMNUpLimit;
                                                        $TMN = $UserbalancesItem->TMN;
                                                        $Down = $UserbalancesItem->TMNDownLimit;
                                                        $Destance = $Up - $Down;
                                                        $Position = $TMN - $Down;
                                                    
                                                        if ($Destance > 0) {
                                                            $Percent = ($Position * 100) / $Destance;
                                                            $Percent = round($Percent, 2);
                                                        } else {
                                                            $Percent = false;
                                                        }
                                                        $ShowPercent = true;
                                                    } else {
                                                        $ShowPercent = false;
                                                    }
                                                    
                                                @endphp
                                                @if ($ShowPercent)
                                                    @if ($Percent)
                                                        {{ $Percent }} %
                                                        @if ($Percent < 30)
                                                            <div class="progress mb-1" style="height: 4px">
                                                                <div class="progress-bar bg-danger"
                                                                    style="width: {{ $Percent }}%" role="progressbar"
                                                                    aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                                                </div>
                                                            </div>
                                                        @elseif($Percent >= 30 && $Percent < 70)
                                                            <div class="progress mb-1" style="height: 4px">
                                                                <div class="progress-bar bg-warning"
                                                                    style="width: {{ $Percent }}%" role="progressbar"
                                                                    aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                                                </div>
                                                            </div>
                                                        @elseif($Percent >= 70)
                                                            <div class="progress mb-1" style="height: 4px">
                                                                <div class="progress-bar bg-success"
                                                                    style="width: {{ $Percent }}%" role="progressbar"
                                                                    aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endif
                                                @endif
                                            </th>
                                            <th>


                                                <div class="dropdown">
                                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                        data-bs-toggle="dropdown">
                                                        <i class="bx bx-dots-vertical-rounded"></i>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item"
                                                            href="{{ route('CoinEdit', ['CoinId' => $UserbalancesItem->id]) }}"><i
                                                                class="fa fa-cog" aria-hidden="true"></i>
                                                            تنظیم ربات</a>
                                                        @if ($UserbalancesItem->Status != 100)
                                                            <button type="submit"
                                                                class="dropdown-item btn btn-sm btn-success"
                                                                name="activeRobot" value="{{ $UserbalancesItem->id }}"> <i
                                                                    class="fa fa-play" aria-hidden="true"></i>
                                                                فعال
                                                                سازی ربات</button>
                                                        @else
                                                            @if ($UserbalancesItem->Robot != 100)
                                                                <button type="submit"
                                                                    class="dropdown-item btn btn-sm btn-danger"
                                                                    name="deactiveRobot"
                                                                    value="{{ $UserbalancesItem->id }}"><i
                                                                        class="fa fa-stop" aria-hidden="true"></i>
                                                                    غیر فعال سازی
                                                                    ربات</button>
                                                            @else
                                                                <button type="submit"
                                                                    class="dropdown-item btn btn-sm btn-warning"
                                                                    name="StartRobot" value="{{ $UserbalancesItem->id }}">
                                                                    <i class="fa fa-wheelchair-alt" aria-hidden="true"></i>
                                                                    شروع
                                                                    کار ربات</button>
                                                            @endif
                                                        @endif

                                                    </div>
                                                </div>

                                            </th>
                                        </tr>
                                    </form>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!--/ Bordered Table -->

            <hr class="my-5">


        </div>

@endsection
@section('EndScripts')
@endsection

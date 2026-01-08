@php
    $Persian = new App\Functions\persian();
@endphp
@extends('Theme2.Layouts.MainLayout')

<!-- Content -->
@section('Content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-xl-12 mb-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">آنالیز حجمی ورژن 2.3</h5>
                        <div class="dropdown primary-font">
                            <button class="btn p-0" type="button" id="marketingOptions" data-bs-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="marketingOptions">
                                <a class="dropdown-item" href="javascript:void(0);">بر اساس بازار داخلی</a>
                                <a class="dropdown-item" href="javascript:void(0);">بر اساس بازار خارجی</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                            <div class="d-flex justify-content-between align-content-center flex-wrap gap-4">
                                <div class="d-flex align-items-center gap-2">
                                    <div id="marketingCampaignChart1"></div>
                                    <div>
                                        <div class="d-flex align-items-center">
                                            <h6 class="mb-0 me-2">25,768</h6>
                                            <span class="text-success">(+16.2%)</span>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <span class="badge badge-dot bg-success me-2"></span> آرایش درآمد زایی روزانه
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <div id="marketingCampaignChart2"></div>
                                    <div>
                                        <div class="d-flex align-items-center">
                                            <h6 class="mb-0 me-2">5,352</h6>
                                            <span class="text-danger">(-4.9%)</span>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <span class="badge badge-dot bg-danger me-2"></span> آرایش درآمدزایی ۱۰ روزه
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <a href="javascript:;" class="btn btn-sm btn-primary" type="button">مشاهده گزارش</a>
                        </div>
                    </div>
                    @php
                        $MarketSrc = $Crypto->formola_v2_3(5);
                    @endphp
                    <div class="table-responsive">
                        <table class="table border-top">
                            <thead>
                                <tr>
                                    <th>نماد</th>
                                    <th>رشد</th>
                                    <th>جایگاه قیمت</th>
                                    <th>پیشنهاد خرید</th>
                                    <th>عمل</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                                @foreach ($MarketSrc as $MarketItem)
                                    <tr>
                                        <td class="text-nowrap">
                                            <img src="{{ $MarketItem->pic }}" class="me-3" width="22"
                                                alt="Fastrack">{{ $MarketItem->MainName }}
                                            @if ($MarketItem->faName != null)
                                                -
                                                {{ $MarketItem->faName }}
                                            @endif
                                        </td>

                                        @if ($MarketItem->changeRateInt >= 0)
                                            <td class="text-nowrap"><i
                                                    class="bx bx-trending-up text-success me-2"></i>{{ $MarketItem->changeRateInt }}%
                                            </td>
                                        @else
                                            <td><i
                                                    class="bx bx-trending-down text-danger me-2"></i>{{ $MarketItem->changeRateInt }}%
                                            </td>
                                        @endif
                                        @if ($MarketItem->f1 >= 0)
                                            <td class="text-nowrap"><i
                                                    class="bx bx-trending-up text-success me-2"></i>{{ $MarketItem->changeRateInt }}%
                                            </td>
                                        @else
                                            <td><i
                                                    class="bx bx-trending-down text-danger me-2"></i>{{ $MarketItem->changeRateInt }}%
                                            </td>
                                        @endif
                                        <td><span class="text-success">{{ $MarketItem->f1 }}%</span></td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn p-0" type="button" id="action1"
                                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="action1">
                                                    <a class="dropdown-item" href="javascript:void(0);">جزئیات</a>
                                                    <a class="dropdown-item" href="javascript:void(0);">نوشتن یک
                                                        نقد و
                                                        بررسی</a>
                                                    <a class="dropdown-item" href="javascript:void(0);">دریافت
                                                        صورتحساب</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script></script>
@endsection
@section('EndScripts')
@endsection

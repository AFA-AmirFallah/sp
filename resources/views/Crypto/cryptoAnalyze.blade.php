@extends('Crypto.CryptoAdmin')
@section('CryptoCountent')
    <div class="col-lg-‍12 mb-3">
        <div class="card">
            <div class="card-header bg-transparent">
                <h3 class="card-title">عرضه و تقاضا</h3>
            </div>
            <div style="overflow: scroll" class="card-body">
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <table class="{{ \App\myappenv::MainTableClass }}">
                            <thead>
                                <th>نماد بازار</th>
                                <th>ارز پایه</th>
                                <th> سفارش‌های خرید</th>
                                <th>سفارش‌های فروش</th>
                                <th> 24H </th>
                                <th>۲۴ ساعت گذشته</th>
                                <th>7D</th>
                                <th>حجم تراکنش‌ها در ۷ روز گذشته</th>
                                <th> قیمت </th>
                                <th>درصد خرید</th>
                                <th style="background-color:aquamarine">درصد خرید</th>
                                <th style="background-color:aquamarine">حجم خرید خرید</th>
                                <th style="background-color:aquamarine">جایگاه قیمت</th>
                                <th style="background-color:aquamarine">میزان نوسان</th>
                                <th style="background-color:aquamarine">تصاحب بازار</th>
                                <th style="background-color:aquamarine">فرمول ۱</th>
                            </thead>
                            @foreach ($MarketSrc as $MarketItem)
                                <form method="POST">
                                    @csrf
                                    <tr style="direction: rtl">
                                        <td {{ $MarketItem['symbol'] }}<br>{{ $MarketItem['faName'] }}</td>
                                        <td> {{ $MarketItem['baseAsset'] }} <br> {{ $MarketItem['faBaseAsset'] }}</td>
                                        <td> بیشترین قیمت: {{ number_format((float) $MarketItem['bidPrice']) }}
                                            <br> مجموع حجم: {{ number_format((float) $MarketItem['bidVolume']) }}
                                            <br> تعداد: {{ $MarketItem['bidCount'] }}
                                        </td>
                                        <td> کمترین قیمت: {{ number_format((float) $MarketItem['askPrice']) }}
                                            <br> مجموع حجم: {{ number_format((float) $MarketItem['askVolume']) }}
                                            <br>تعداد: {{ $MarketItem['askCount'] }}
                                        </td>
                                        @if ($MarketItem['ch_24h'] < 0)
                                            <td style="color:white;background-color: red;direction: rtl;">
                                                {{ $MarketItem['ch_24h'] }} %</td>
                                        @else
                                            <td style="color:white;background-color: green;direction: rtl;">
                                                {{ $MarketItem['ch_24h'] }} %</td>
                                        @endif
                                        <td> حجم: {{ number_format((float) $MarketItem['24h_volume']) }}
                                            <br> مبلغ: {{ number_format((float) $MarketItem['24h_quoteVolume']) }}
                                            <br> ماکزیمم: {{ number_format((float) $MarketItem['24h_highPrice']) }}
                                            <br> مینیموم: {{ number_format((float) $MarketItem['24h_lowPrice']) }}
                                            <br>
                                            <div class="progress mb-1" style="height: 4px">
                                                <div class="progress-bar bg-danger" style="width: 20%" role="progressbar"
                                                    aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                                </div>
                                            </div>
                                        </td>
                                        @if ($MarketItem['ch_7d'] < 0)
                                            <td style="color:white;background-color: red;direction: rtl;">
                                                {{ $MarketItem['ch_7d'] }} %</td>
                                        @else
                                            <td style="color:white;background-color: green;direction: rtl;">
                                                {{ $MarketItem['ch_7d'] }} %</td>
                                        @endif
                                        <td> {{ number_format((float) $MarketItem['7d_volume']) }}</td>
                                        <td> {{ number_format((float) $MarketItem['lastPrice']) }}</td>
                                        @if ($MarketItem['BUY'] < 50)
                                            <td style="color:white;background-color: red;direction: rtl;">
                                                {{ $MarketItem['BUY'] }} %</td>
                                        @else
                                            <td style="color:white;background-color: green;direction: rtl;">
                                                {{ $MarketItem['BUY'] }} %</td>
                                        @endif
                                        @if ($MarketItem['BuyPercent'] < 50)
                                            <td style="color:white;background-color: red;direction: rtl;">
                                                {{ $MarketItem['BuyPercent'] }} %</td>
                                        @else
                                            <td style="color:white;background-color: green;direction: rtl;">
                                                {{ $MarketItem['BuyPercent'] }} %</td>
                                        @endif
                                        @if ($MarketItem['AmountBuyPercent'] < 50)
                                            <td style="color:white;background-color: red;direction: rtl;">
                                                {{ $MarketItem['AmountBuyPercent'] }} %</td>
                                        @else
                                            <td style="color:white;background-color: green;direction: rtl;">
                                                {{ $MarketItem['AmountBuyPercent'] }} %</td>
                                        @endif
                                        @if ($MarketItem['PriceLocationPercnet'] < 50)
                                            <td style="color:white;background-color: red;direction: rtl;">
                                                {{ $MarketItem['PriceLocationPercnet'] }} %</td>
                                        @else
                                            <td style="color:white;background-color: green;direction: rtl;">
                                                {{ $MarketItem['PriceLocationPercnet'] }} %</td>
                                        @endif

                                        <td>
                                            {{ round($MarketItem['Telorance']) }} %</td>

                                        <td>{{ $MarketItem['MarketPercnet'] }}</td>
                                        @if ($MarketItem['f1'] < 50)
                                            <td style="color:white;background-color: red;direction: rtl;">
                                                {{ $MarketItem['f1'] }} %</td>
                                        @else
                                            <td style="color:white;background-color: green;direction: rtl;">
                                                {{ $MarketItem['f1'] }} %</td>
                                        @endif


                                    </tr>
                                </form>
                            @endforeach
                        </table>



                    </div>

                </div>
            </div>
            <form method="post">
                @csrf
                <div class="card-footer bg-transparent">
                    <div class="mc-footer">
                        <div class="row">
                            <div class="col-lg-12">
                                <button type="submit" name="submit" value="syncwithcenter" class="btn  btn-primary m-1">به
                                    روز رسانی از صرافی</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <!-- end::form -->
        </div>

    </div>
@endsection
@section('page-js')
@endsection

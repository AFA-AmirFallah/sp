@php
$Persian = new App\Functions\persian();
@endphp
@extends("Layouts.MainPage")
@section('page-css')
    <link rel="stylesheet" href="{{ asset('assets/styles/vendor/dropzone.min.css') }}">
    <style>
        .Shafatel17 {
            text-overflow: ellipsis;
            white-space: nowrap;
            margin: 0px 0px 0px 1.8rem;
            font-size: 14px;
            font-weight: 500;
            font-stretch: normal;
            font-style: normal;
            line-height: normal;
            color: rgb(103, 106, 112);
            padding: 0.3rem 0px;
        }

        .Shafatel18 {
            margin-top: 26px;
            position: relative;
            background: darkgrey;
        }

        .Shafatel19 {
            margin-top: 0px;
            position: relative;
            background: #f0eeee;
        }

        .active {
            border-width: 3px;
            border-color: blue;
            background: blue;
            color: white;
            border-radius: 6px;
            padding-right: 5px;
            padding-left: 5px;
        }

        .Discount_Percent {
            position: absolute;
            left: 6px;
            top: 6px;
            background: red;
            border-radius: 3px;
            color: white;
            padding: 3px;
            font-size: large;

        }

        .Discount_Percent label {
            padding-bottom: 0px;
            margin-bottom: 0px;

        }

        .navigation {


            border-width: 0px 0px 1px 0px;
            border-style: solid;
            width: 100%;
            border-color: darkgray;
            font-size: 13px;
        }

        .AccountTitle {
            text-align: center;
        }

        .accountDevision {
            background-color: black;
            margin-top: 7px;
            margin-bottom: 7px;
            margin-right: 10px;
            margin-left: 10px;
        }

        .AccountContiner {
            background-color: #00ff1426;
            margin-top: -14px;
        }

    </style>
@endsection
@section('page-header-left')
@endsection
@section('MainCountent')
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-lg-6">
                    <div class="page-header-left">
                        <h3>فروش   
                            <small> اکانت ويژه</small>
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
    <div class="row col-12">
        @foreach ($Goods as $Good)
            <div class="col-xl-3 col-md-3 col-s-6 col-xs-12">
                @if ($Good->PricePlan == null)
                    @if ($Good->BasePrice != null)
                        <div class="Discount_Percent">
                            <label>
                                {{ ceil((($Good->BasePrice - $Good->Price) * 100) / $Good->BasePrice) }}%
                            </label>
                        </div>
                    @endif
                @else
                    <div class="Discount_Percent">
                        <label>

                            {{ ceil((($Good->BasePrice - \App\Http\Controllers\woocommerce\product::GetMinPrice($Good->PricePlan)) * 100) /$Good->BasePrice) }}%
                        </label>
                    </div>
                @endif

                <img class="card-img-left" src="{{ App\Functions\Images::GetPicture($Good->ImgURL, 1) }}"
                    alt="{{ $Good->NameFa }}">
                <div class="AccountContiner">
                    <div class="AccountTitle">{{ $Good->NameFa }}</div>
                    <hr class="accountDevision">
                    <div class="AccountTitle">
                        نوع کاربری:
                        {{ $Good->Description }}</div>
                    <hr class="accountDevision">
                    <div class="AccountTitle">
                        <p>
                            هزینه اشتراک
                            @if ($Good->weight == 365)
                                سالیانه:
                            @elseif($Good->weight == 30 || $Good->weight == 31)
                                ماهیانه:
                            @elseif($Good->weight == 7)
                                هفتگی:
                            @else
                                {{ $Good->weight }} روزه
                            @endif
                        </p>
                        @if ($Good->BasePrice > 0 && $Good->BasePrice != $Good->Price)
                            <del class="text-secondary">{{ number_format($Good->BasePrice / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                {{ App\Http\Controllers\Credit\currency::GetCurrency() }}</del>
                            <br>
                        @endif

                        {{ number_format($Good->Price / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                        {{ App\Http\Controllers\Credit\currency::GetCurrency() }}
                    </div>
                    <hr class="accountDevision">
                    <div class="AccountTitle">{!! App\Http\Controllers\woocommerce\product::GetJsonFeild($Good->MainDescription, 'DiscText') !!}</div>
                    <form method='post'>
                        @csrf
                        <input class="nested" type="text" name="price" value="{{ $Good->Price }}">
                        <button type="submit" name="pay" value="{{ $Good->id }}"
                            class="btn btn-success  btn-block">خرید</button>
                    </form>

                </div>


            </div>
        @endforeach
    </div>
@endsection
@section('page-js')
@endsection

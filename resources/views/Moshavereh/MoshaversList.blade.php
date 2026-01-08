@php
$Persian = new App\Functions\persian();
@endphp
@extends("Layouts.CustomerMainPage")
@section('Header')
    <link rel="stylesheet" type="text/css" href="{{ url('/') }}/assets/css/bootstrap-clockpicker.min.css">
@endsection
@section('before-css')
    <link rel="stylesheet" href="{{ asset('assets/styles/vendor/sweetalert2.min.css') }}">
@endsection
@section('page-header-left')
@endsection
@section('MainCountent')
    <input class="nested" id="confirmcode">
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="pwa_h1_title">{{ $L3Work->Name }}</h1>
                </div>
                <div class="col-lg-6">
                    <ol class="breadcrumb pull-right">
                        @include('Layouts.AddressBar')
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="notloginmodal" tabindex="-1" role="dialog" aria-labelledby="notloginmodalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="notloginmodalLabel">ورود به سیستم</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>جهت انجام مشاوره می باید به سیتسم وارد شوید</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">بستن</button>
                    <a href="{{ route('login') }}" class="btn btn-primary">ورود به سیستم</a>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="lessmonyoginmodal" tabindex="-1" role="dialog" aria-labelledby="notloginmodalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="notloginmodalLabel">کمبود موجودی</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>لطفا جهت انجام مشاوره کیف پول خود را حد اقل به مبلغ {{ number_format($Price) }} ریال شارژ بفرمایید
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">بستن</button>
                    <a href="{{ route('DirectPay') }}" class="btn btn-primary">شارژ حساب </a>
                </div>
            </div>
        </div>
    </div>
    <form method="post">
        @csrf
        @foreach ($Moshaves as $Moshaver)
            <div class="col-md-3">
                <div class="card card-profile-1 mb-4">
                    <div class="card-body text-center">
                        <div class="avatar box-shadow-2 mb-3">
                            <img src="{{ $Moshaver->avatar }} " alt="">
                        </div>
                        <h5 class="m-0">{{ $Moshaver->firstname }} {{ $Moshaver->Family }}</h5>
                        {!! $Moshaver->extranote !!}
                        @if (Auth::check())
                            @if ($UserHasCredit < $Price)
                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                    data-target="#lessmonyoginmodal">
                                    درخواست مشاوره
                                </button>

                            @else
                                <button type="submit" name="submit" value='{{ $Moshaver->UserName }}'
                                    class="btn btn-primary btn-rounded">درخواست مشاوره</button>

                            @endif
                        @else
                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                data-target="#notloginmodal">
                                درخواست مشاوره
                            </button>

                        @endif
                        <div class="card-socials-simple mt-4">
                            <a href="">
                                <i class="i-Old-Telephone"></i>
                            </a>
                            <a href="">
                                <i class="i-File-Horizontal-Text"></i>
                            </a>
                            <a href="">
                                <i class="i-Affiliate"></i>
                            </a>
                        </div>
                        <div>
                            <h6>درخواست مشاوره مبلغ : صد هزار تومان</h6>
                            <h6>مدت مشاوره : چهل و پنج دقیقه</h6>
                        </div>
                    </div>

                </div>

            </div>
        @endforeach

    </form>


@endsection
@section('page-js')




@endsection

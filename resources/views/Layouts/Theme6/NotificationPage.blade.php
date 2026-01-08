@php
    $Persian = new App\Functions\persian();
@endphp
@extends('Layouts.Theme6.Layout.mian_layout')
@section('MainTitle')
@endsection


@section('content')
    <section class="error-page ptb-100">
        <div class="d-table">
            <div class="d-tablecell">
                <div class="container">
                    <div class="error-item-wrapper text-center">
                        <div class="single-error">
                            <h1 style="font-size: 70px" >عملیات موفق</h1>
                            <h4>با تشکر دیدگاه شما ثبت شد پس از بررسی منتشر خواهد شد.</h4>
                        </div>
                        <div class="custom-button">
                            <a href="{{URL::current()}}" class="custom-btn2">
                                بازگشت به صفحه اصلی
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

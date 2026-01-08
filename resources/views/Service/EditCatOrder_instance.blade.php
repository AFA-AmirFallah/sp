@php
    $Persian = new App\Functions\persian();
@endphp
@extends('Layouts.MainPage')
@section('Header')
@endsection

@section('MainCountent')
    <div class="ul-card-list__modal">
        <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        حذف درخواست
                        <button style="display: contents" type="button" class="close" data-dismiss="modal"
                            aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post">
                            @csrf
                            <p class="text-danger">آیا مطمئن هستید که میخواهید این خدمت را حذف نمایید؟</p>
                            <div class="form-group row">
                                <div class="col-sm-10">
                                    <button type="button" data-dismiss="modal" aria-label="Close"
                                        class="btn btn-success">انصراف
                                    </button>
                                    <button type="submit" name="submit" value="delete" class="btn btn-danger">حذف
                                    </button>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input class="nested" id="main-menu" value="#setting">
    <input class="nested" id="sub-menu" value="#req_mgt">
    <div class="row">
        <div class=" col-lg-3 col-md-6 col-sm-6 ">
            <a href="{{ route('AddCatOrder') }}">
                <div class="navcard navcard-main card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                    <div class="card-body text-center">
                        <i style="color: red" class="i-Cloud-"></i>
                        <div class="content">
                            <p class=" mt-2 mb-0 text-primary">افزودن درخواست</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 ">
            <a href="{{ route('CatOrderList') }}">
                <div class="navcard navcard-main card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                    <div class="card-body text-center">
                        <i style="color: green" class="i-Receipt-4"></i>
                        <div class="content">
                            <p class="text-primary mt-2 mb-0">لیست درخواست ها</p>

                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 ">
            <div class="navcard active-navcard card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                <div class="card-body text-center">
                    <i class="i-Pen-4"></i>
                    <div class="content">
                        <p class="text-white mt-2 mb-0">ویرایش درخواست</p>

                    </div>
                </div>
            </div>
        </div>
        @if (\App\myappenv::version >= 3 && \App\myappenv::Branch == Auth::user()->branch)
            <div class=" col-lg-3 col-md-6 col-sm-6 ">
                <a href="{{ route('branch_order_req') }}">
                    <div class="navcard navcard-main card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                        <div class="card-body text-center">
                            <i style="color: red" class="i-Cloud-"></i>
                            <div class="content">
                                <p class=" mt-2 mb-0 text-primary">  افزودن درخواست شعبه  </p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        @endif

    </div>

    <form method="post">
        @csrf

        <div class="2-columns-form-layout">
            <div class="">
                <div class="row">
                    <div class="col-lg-12">
                        <!-- start card -->
                        <div class="card">
                            <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                                <h5 class="text-white"><img src="{{ $order_meta_src->Pic }}" style="height: 50px"> ویرایش :
                                    {{ $order_meta_src->TitleDescription }}
                                </h5>
                            </div>
                            <!--begin::form-->
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label style="display: inline-flex" for="inputEmail2" class="ul-form__label">
                                            <p class="text-success"> حداقل </p> مبلغ خدمت-ریال
                                        </label>
                                        <input id="min_price" type="number" class="form-control" name="min_price"
                                            placeholder="حداقل مبلغ خدمات" value="{{ $order_src->min_price ?? 0 }}">
                                        <div id="min_price_text"></div>
                                        <small id="passwordHelpBlock" class="ul-form__text form-text ">
                                            حداقل مبلغ دریافتی از بیمار بابت انجام خدمات مربوط به این درخواست
                                        </small>
                                    </div>
                                    <div class="form-group col-md-6">

                                        <label style="display: inline-flex" class="ul-form__label">
                                            <p class="text-danger"> حداکثر </p> مبلغ خدمت-ریال
                                        </label>
                                        <input id="max_price" type="number" class="form-control" name="max_price"
                                            placeholder="حداکثر مبلغ خدمات" value="{{ $order_src->max_price ?? 0 }}">
                                        <div id="max_price_text"></div>
                                        <small class="ul-form__text form-text ">
                                            حداکثر مبلغ دریافتی از بیمار بابت انجام خدمات مربوط به این درخواست
                                        </small>
                                    </div>

                                </div>
                                <div class="custom-separator"></div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="inputEmail3" class="ul-form__label">توضیحات
                                        </label>
                                        <br>
                                        <small>این توضیحات در خصوص اطلاعات بیشتر نسبت به نحوه ارائه خدمت در مرکز
                                            شما می باشد که به مشتریان کمک می کند تا مرکز شما را انتخاب نمایند!</small>
                                    </div>

                                </div>
                                <div class="row ">
                                    <div class="input-right-icon col-md-12">
                                        <textarea name="MainDescription" rows="10" class="form-control"> {{ $order_src->MainDescription }} </textarea>

                                    </div>
                                </div>
                                <hr>
                                <label class="checkbox checkbox-success">
                                    @if ($order_src->OnSale == 1)
                                        <input type="checkbox" name="OnSale" checked value="1">
                                    @else
                                        <input type="checkbox" name="OnSale" value="1">
                                    @endif

                                    <span>فعال سازی این درخواست</span>
                                    <small>با انتخاب این گزینه امکان ثبت این درخواست برای مشتریان وجود خواهد داشت</small>
                                    <span class="checkmark"></span>
                                </label>
                                <label class="checkbox checkbox-primary">
                                    @switch($order_src->Status)
                                        @case(100)
                                            <input type="checkbox" name="show_global" checked value="1">
                                        @break

                                        @case(50)
                                            <input type="checkbox" name="show_global" checked value="1"> <span
                                                class="badge badge-pill badge-warning p-2 m-1">در دست بررسی کارشناسان
                                                شفاتل</span>
                                        @break

                                        @default
                                            <input type="checkbox" name="show_global" value="1">
                                    @endswitch


                                    <span>نمایش به مشتریان شفاتل</span>
                                    <small>با انتخاب این گزینه پس از بررسی و تایید کارشناسان شفاتل خدمت شما به تمامی مشتریان
                                        در پنل اصلی نمایش داده خواهد شد</small>
                                    <span class="checkmark"></span>
                                </label>
                                <div class="card-footer">
                                    <div class="mc-footer">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <button type="submit" class="btn btn-primary m-1" name="submit"
                                                    value="EditeService">ثبت ویرایش درخواست
                                                </button>
                                                <button type="button" class="btn btn-danger m-1" name="submit"
                                                    data-toggle="modal" data-target=".bd-example-modal-lg"
                                                    value="EditeService"> حذف درخواست
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end::form -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('page-js')
    <script>
        onload = function() {
            var e = document.getElementById('max_price');
            e.oninput = myHandler;
            e.onpropertychange = e.oninput; // for IE8
            function myHandler() {
                document.getElementById('max_price_text').innerHTML = e.value.toPersianLetter() + ' تومان ';
            }
            var e2 = document.getElementById('min_price');
            e2.oninput = myHandler2;
            e2.onpropertychange = e2.oninput; // for IE8
            function myHandler2() {
                document.getElementById('min_price_text').innerHTML = e2.value.toPersianLetter() + ' تومان ';
            }
        };

        function myHandler() {
            document.getElementById('max_price').innerHTML = e.value.toPersianLetter() + ' تومان ';
        }
    </script>
@endsection
@section('bottom-js')
@endsection

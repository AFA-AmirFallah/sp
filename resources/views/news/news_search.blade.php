@php
    $Persian = new App\Functions\persian();
@endphp
@extends('Layouts.MainPage')
@section('page-header-left')
@endsection
@section('MainCountent')
    @include('news.Layouts.news_admin_menu', ['active_menu' => 'MakeTagCover'])
    <form method="post">
        @csrf
        <div class="container-fluid">
            <div class="row product-adding">
                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                            <h5 class="text-white"><i class=" header-icon i-Receipt-3"></i>
                                جستجوی محتوا</h5>
                        </div>
                        <div class="card-body">
                            <div class="digital-add needs-validation">
                                <div class="form-group">
                                    <label for="validationCustom01" class="col-form-label pt-0">تیتر</label>
                                    <input class="form-control" name="Titel" id="validationCustom01" type="text">
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">نوع محتوا</label>
                                    <select class="custom-select" name="news_type">
                                        <option value="">{{ __('--select--') }}</option>
                                        <option value="news">خبر</option>
                                        <option value="banners">بنر</option>
                                        <option value="hotnews">خبرهای داغ</option>
                                        <option value="ads">تبلیغات</option>
                                        <option value="covers">پوشش</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">وضعیت</label>
                                    <select class="custom-select" name="status">
                                        <option value="">{{ __('--select--') }}</option>
                                        @foreach (\App\myappenv::PostStatus as $PostStatusItem)
                                            <option value="{{ $PostStatusItem[0] }}">
                                                {{ $PostStatusItem[1] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">تولید کننده</label>
                                    <select class="custom-select" name="Creator">
                                        <option value="">{{ __('--select--') }}</option>
                                        @foreach ($creator_src as $creator)
                                            <option value="{{ $creator->UserName }}">
                                                {{ $creator->Name }} {{ $creator->Family }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-xl-6">
                                            <label for="validationCustomtitle"
                                                class="col-form-label pt-0">{{ __('Register from date') }}</label>
                                            <input class="form-control" type="text" name="StartDate" autocomplete="off"
                                                onfocus="Mh1PersianDatePicker.Show(this,'{{ $Persian->MyPersianDate(date('Y-m-d'), false, 'n') }}',)"
                                                placeholder="{{ __('Register from date') }}" />

                                        </div>
                                        <div class="col-xl-6">
                                            <label for="validationCustomtitle"
                                                class="col-form-label pt-0">{{ __('Register to date') }}</label>
                                            <input class="form-control" type="text" name="EndDate" autocomplete="off"
                                                onfocus="Mh1PersianDatePicker.Show(this,'{{ $Persian->MyPersianDate(date('Y-m-d'), false, 'n') }}',)"
                                                placeholder="{{ __('Register to date') }}" />

                                        </div>
                                    </div>

                                </div>

                                <div class="form-group mb-0">
                                    <div class="product-buttons text-center">
                                        <button type="submit" name="submit" value="primary" class="btn btn-primary"><i
                                                style="font-size: 17px;margin: 5px;" class="i-Magnifi-Glass1"></i>
                                            {{ __('Search') }} </button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6">

                    <div class="card">
                        <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                            <h5 class="text-white"><i class=" header-icon i-Tag-4"></i> {{ __('Search based indexes') }}
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="digital-add needs-validation">
                                <div class="form-group mb-0">
                                    <div class="description-sm">
                                        <ul>
                                            @foreach ($IndexNewsTree as $IndexTree_item)
                                                <li>{{ $IndexTree_item->Name }}
                                                    @if ($IndexTree_item->post_id != null)
                                                        <a class="text-success"
                                                            href="{{ route('EditTagCover', ['TagID' => $IndexTree_item->post_id]) }}">ویرایش
                                                            کاور</a>
                                                    @else
                                                        <a class="text-primary" href="{{ route('MakeTagCover', ['TagID' => $IndexTree_item->UID]) }}">افزودن
                                                            کاور  </a>
                                                    @endif
                                                </li>
                                            @endforeach
                                        </ul>

                                        {!! $IndexTree !!}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb-0">
                                <div class="product-buttons text-center">
                                    <button type="submit" name="submit" value="indexes" class="btn btn-primary"><i
                                            style="font-size: 17px;margin: 5px;"
                                            class="i-Magnifi-Glass1"></i>{{ __('Search') }}</button>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </form>
@endsection
@section('page-js')
    <script>
        function LoadCitys($ProvinceCode) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('<?php echo e(route('ajax')); ?>', {
                    AjaxType: 'GetCitysOfProvinces',
                    ProvinceCode: $ProvinceCode,
                },

                function(data, status) {
                    $("#Shahrestan").empty();
                    data = `<option value="0">همه شهرها</option>` + data;
                    $("#Shahrestan").append(data);
                });

        }
    </script>

    <script>
        var toggler = document.getElementsByClassName("box");
        var i;

        for (i = 0; i < toggler.length; i++) {
            toggler[i].addEventListener("click", function() {
                if ($(this.parentElement.querySelector("ul")).hasClass('nested')) {
                    $(this.parentElement.querySelector("ul")).removeClass('nested');
                    this.parentElement.querySelector("ul").classList.toggle("active");
                } else {
                    $(this.parentElement.querySelector("ul")).removeClass('active');
                    this.parentElement.querySelector("ul").classList.toggle("nested");
                }


                this.classList.toggle("check-box");
                this.classList.toggle("active");
            });
        }
    </script>
    <script>
        var selected = new Array();
        $(document).ready(function() {

            $("input[type='checkbox']").on('change', function() {
                // check if we are adding, or removing a selected item
                if ($(this).is(":checked")) {
                    selected.push($(this).val());
                } else {
                    for (var i = 0; i < selected.length; i++) {
                        if (selected[i] == $(this).val()) {
                            // remove the item from the array
                            selected.splice(i, 1);
                        }
                    }
                }

                // output selected
                var output = "";
                for (var o = 0; o < selected.length; o++) {
                    if (output.length) {
                        output += ", " + selected[o];
                    } else {
                        output += selected[o];
                    }
                }

                $(".taid").val(output);

            });

        });
    </script>
    <script>
        $(document).ready(function() {
                    $("#L1").change(function() {
                        var num = this.value;
                        $("#L11").css("display", "none");
                    });
    </script>

    <script src="{{ url('/') }}/persian-datepicker/Mh1PersianDatePicker.js"></script>
@endsection

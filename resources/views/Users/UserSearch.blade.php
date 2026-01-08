@php
    $Persian = new App\Functions\persian();
@endphp
@extends('Layouts.MainPage')
@section('page-header-left')
@endsection
@section('MainCountent')
    <input class="nested" id="main-menu" value="#userworks">
    <input class="nested" id="sub-menu" value="#user_list">
    <div class="row">
        <div class=" col-lg-3 col-md-6 col-sm-6 ">
            <a href="{{ route('CreateUser') }}">
                <div class="navcard navcard-main card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                    <div class="card-body text-center">
                        <i style="color: red" class="i-Add-User"></i>
                        <div class="content">
                            <p class=" mt-2 mb-0 text-primary"> افزودن کاربر</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 ">
            <a href="{{ route('UserSearch') }}">
                <div class="navcard active-navcard card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                    <div class="card-body text-center">
                        <i class="i-Receipt-4"></i>
                        <div class="content">
                            <p class="text-white mt-2 mb-0">لیست کاربران</p>

                        </div>
                    </div>
                </div>
            </a>
        </div>

    </div>
    @php
        $skills = $hiring->skill_mgt(false) ?? [];
        $skill_count = count($skills);

    @endphp
    @if ($skill_count > 0)
        <section class="contact-list">
            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="card text-left">
                        <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                            <h5 class="text-white"><i class=" header-icon i-Geek1"></i>
                                مدیریت مهارت ها</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <form method="POST" name="object">
                                    @csrf
                                    <table id="ul-contact-list" class="display table " style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>کد</th>
                                                <th>نام مهارت </th>
                                                <th>وضعیت</th>
                                                <th>عملیات</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($skills as $skill_item)
                                                <tr>
                                                    <td>{{ $skill_item->UID }} </td>
                                                    <td>{{ $skill_item->Name }} </td>
                                                    <td>غیر فعال</td>
                                                    <td>
                                                        <button name="activate" value="{{ $skill_item->UID }}"
                                                            class="btn btn-success">فعال سازی</button>
                                                        <button name="deactivate" value="{{ $skill_item->UID }}"
                                                            class="btn btn-danger">حذف</button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
    <form method="post">
        @csrf
        <div class="container-fluid">
            <div class="row product-adding">
                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                            <h5 class="text-white"><i class=" header-icon i-Business-Mens"></i>
                                {{ __('Search based on basic information') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="digital-add needs-validation">
                                <div class="form-group">
                                    <label for="validationCustom01"
                                        class="col-form-label pt-0">{{ __('Name and family') }}</label>
                                    <input class="form-control" name="SUserName" id="validationCustom01" type="text">
                                </div>
                                <div class="form-group">
                                    <label for="validationCustomtitle"
                                        class="col-form-label pt-0">{{ __('Mobile No') }}</label>
                                    <input class="form-control" name="SMobile" id="validationCustomtitle"
                                        inputmode="numeric" type="text">
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">{{ __('User Role') }}</label>
                                    <select class="custom-select" name="optionsRadios">
                                        <option value="">{{ __('--select--') }}</option>
                                        <option value="-100">مشتریان ویژه</option>
                                        @foreach ($UserRoles as $UserRole)
                                            <option value="{{ $UserRole->Role }}">{{ $UserRole->RoleName }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">استان</label>
                                    <select name="Province" id="Province" onchange="LoadCitys(this.value)"
                                        class="form-control">
                                        <option value="0">انتخاب استان</option>
                                        @foreach (App\geometric\locations::get_all_provinces() as $ProvincesTarget)
                                            <option value="{{ $ProvincesTarget->id }}">
                                                {{ $ProvincesTarget->ProvinceName }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">شهر</label>
                                    <select class="form-control" id="Shahrestan" name="city">
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">{{ __('Sex') }}</label>
                                    <select name="sexselect" class="custom-select">
                                        <option value="">{{ __('--select--') }}</option>
                                        <option value="f">{{ __('Woman') }}</option>
                                        <option value="m">{{ __('Man') }}</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-xl-6">
                                            <label for="validationCustomtitle"
                                                class="col-form-label pt-0">{{ __('Credite from price') }}</label>
                                            <input class="form-control" name="FromPrice" id="validationCustomtitle"
                                                type="number">

                                        </div>
                                        <div class="col-xl-6">
                                            <label for="validationCustomtitle"
                                                class="col-form-label pt-0">{{ __('Credite to price') }}</label>
                                            <input class="form-control" name="ToPrice" id="validationCustomtitle"
                                                type="number">

                                        </div>
                                    </div>

                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-xl-6">
                                            <label for="validationCustomtitle"
                                                class="col-form-label pt-0">{{ __('Register from date') }}</label>
                                            <input class="form-control" type="text" name="StartDate"
                                                autocomplete="off"
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
    <!--<form method="post">
                                            @csrf
                                            <button type="submit" name="submit_excel" class="btn btn-primary">خروجی اکسل</button>

                                        </form>

                                        Container-fluid Ends-->
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

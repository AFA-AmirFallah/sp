@php
    $Persian = new App\Functions\persian();
@endphp
@extends('Layouts.MainPage')
@section('page-header-left')
@endsection
@section('MainCountent')
    <style>
        .label_red {
            color: red;
        }
    </style>

    @include('deal/objects/header')
    <form method="POST">
        @csrf
        <div class="container-fluid">
            <div class="row product-adding">
                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                            <h5 class="text-white"><i class=" header-icon i-Truck"></i>
                                جستجوی فایل ها</h5>
                        </div>
                        <div class="card-body">
                            <div class="digital-add needs-validation">
                                <div class="form-group">
                                    <label for="validationCustom01" class="col-form-label pt-0">نام فایل</label>
                                    <input class="form-control" name="title" type="text">
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">مورد معامله</label>
                                    <select class="custom-select" name="product_type">
                                        <option value="">{{ __('--select--') }}</option>

                                        @foreach ($deal_functions->get_product_type() as $product_type)
                                            <option value="{{ $product_type->id }}">{{ $product_type->Name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">مورد معامله</label>
                                    <select class="custom-select" name="deal_type">
                                        <option value="">{{ __('--select--') }}</option>
                                        <option value="1">فروش نقدی</option>
                                        <option value="2">فروش اقساطی</option>

                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">وضعیت فایل</label>
                                    <select class="custom-select" name="status">
                                        <option value="">{{ __('--select--') }}</option>
                                        <option value="0">غیر فعال</option>
                                        <option value="101">فعال</option>
                                        <option value="90">تمام شده</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">کارشناس</label>
                                    <select class="custom-select" name="status">
                                        <option value="">{{ __('--select--') }}</option>
                                        <option value="0">غیر فعال</option>
                                        <option value="101">فعال</option>
                                        <option value="90">تمام شده</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">شعبه</label>
                                    <select class="custom-select" name="branch">
                                        <option value="">{{ __('--select--') }}</option>
                                        @foreach ($branches as $branch_item)
                                            <option value="{{$branch_item->id}}">{{ $branch_item->Name }}</option>
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

            </div>
        </div>
    </form>
@endsection
@section('page-js')
    <script src="{{ url('/') }}/persian-datepicker/Mh1PersianDatePicker.js"></script>
@endsection

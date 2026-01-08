@php
$Persian = new App\Functions\persian();
@endphp
@extends("Layouts.MainPage")
@section('Header')
    <link rel="stylesheet" type="text/css" href="{{ url('/') }}/assets/css/bootstrap-clockpicker.min.css">
@endsection
@section('before-css')
@endsection
@section('page-header-left')
@endsection
@section('MainCountent')
    <input class="nested" id="confirmcode">
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">

                <div class="col-lg-6">
                    <ol class="breadcrumb pull-right">
                        @include('Layouts.AddressBar')
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <form method="post">
        @csrf
        <div class="col-lg-6 mb-3">
            <div class="card">
                <div class="card-header bg-transparent">
                    <h3 class="card-title">تایید جلسه مشاوره تلفنی</h3>
                </div>
                <!--begin::form-->
                <form action="">
                    <div class="card-body">
                        <div class="table-responsive profile-table">
                            <table class="{{ \App\myappenv::MainTableClass }}">
                                <tbody>
                                    <tr>
                                        <td>نام مراجع</td>
                                        <td class="textinfo">{{ $OwnerInfo->Name }} {{ $OwnerInfo->Family }} </td>
                                    </tr>
                                    <tr>
                                        <td>{{ __('Sex') }}</td>
                                        <td class="textinfo">
                                            @if ($OwnerInfo->Sex == 'm')
                                                {{ __('Man') }}
                                            @elseif($OwnerInfo->Sex == 'f')
                                                {{ __('Woman') }}
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>زمان ثبت درخواست</td>
                                        <td>{{ $Persian->MyPersianDate($RequestSource->create_date, true) }}</td>
                                    </tr>
                                    <tr>
                                        <td>اتصال به</td>
                                        <td> <select name="phoneNumber" class=" form-control tocheck">
                                                <option selected value="{{ $ProviderInfo->MobileNo }}">
                                                    {{ $ProviderInfo->MobileNo }}</option>
                                                @if ($ProviderInfo->Phone1)
                                                    <option value="{{ $ProviderInfo->Phone1 }}">
                                                        {{ $ProviderInfo->Phone1 }}</option>
                                                @endif
                                                @if ($ProviderInfo->Phone2)
                                                    <option value="{{ $ProviderInfo->Phone2 }}">
                                                        {{ $ProviderInfo->Phone2 }}
                                                @endif
                                                </option>
                                            </select></td>
                                    </tr>
                                </tbody>
                            </table>
                            @if ($RequestSource->Status < 10)
                                <button type="submit" name="submit" value="call" class="btn btn-primary">برقراری
                                    تماس</button>
                                @if ($RequestSource->Status < 3)
                                    <button type="submit" name="submit" value="2" class="btn btn-primary ">۱۰ دقیقه دیگر
                                        تماس
                                        میگیرم</button>
                                @endif
                                @if ($RequestSource->Status < 2)
                                    <button type="submit" name="submit" value="3" id="submitedit"
                                        class="btn btn-warning ">۲۰
                                        دققه دیگر تماس میگیرم</button>
                                @endif
                                @if ($RequestSource->Status == 1)
                                    <button type="submit" name="submit" value="11" id="submitedit"
                                        class="btn btn-danger ">آماده
                                        مشاوره نیستم</button>

                                @else
                                    <button type="submit" name="submit" value="12" id="submitedit"
                                        class="btn btn-danger ">کنسل با کسر جریمه</button>

                                @endif

                            @endif
                            @if ($RequestSource->Status > 10 && $RequestSource->Status < 30)
                                <button type="submit" name="submit" value="call" class="btn btn-danger">برقراری
                                    تماس مجدد</button>
                                    <button type="submit" name="submit" value="2" class="btn btn-warning "> تماس حاصل نشد بررسی کارشناس
                                        </button>
                                    <button type="submit" name="submit" value="3" id="submitedit"
                                        class="btn  btn-primary">مشاوره انجام شد </button>

                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </form>


@endsection
@section('page-js')




@endsection

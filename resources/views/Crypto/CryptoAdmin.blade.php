@php
    $Persian = new App\Functions\persian();
@endphp
@extends('Layouts.MainPage')
@section('page-header-left')
@endsection
@section('MainCountent')
    <style>
        .btnaria-header {
            margin-right: -7px;
            margin-bottom: -32px;
        }
    </style>

    <div class="breadcrumb">
        <h1>مدیریت رمز ارز</h1>
    </div>

    <div class="separator-breadcrumb border-top"></div>

    <form method="POST">
        @csrf
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <!-- CARD ICON -->
                <div class="row">
                    <div class="col-lg-2 col-md-3 col-sm-3">
                        <div class="card card-icon mb-4">
                            <div class="card-header text-center blue text-white font-weight-bold ">
                                <i class="i-Notepad text-white mt-1" style="font-size: 30px"></i>
                                اکانت من
                            </div>
                            <div class="card-body text-center">
                                <div class="btnaria-header" style="display: flex">
                                    <a href="{{ route('cryptoAccount') }}" type="submit" name="submit" value="editaccount"
                                        class="btn btn-danger btn-block m-1 mb-3"> ویرایش <i class=" text-white"></i></a>
                                    <a href="{{ route('AccountShow') }}" class="btn btn-primary btn-block m-1 mb-3">مشخصات
                                        <i class=" text-white"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-3 col-sm-3">
                        <div class="card card-icon mb-4">
                            <div class="card-header text-center pink text-white font-weight-bold ">
                                <i class="i-Professor text-white mt-1" style="font-size: 30px"></i>
                                کیف پول من
                            </div>
                            <div class="card-body text-center">

                                <div class="btnaria-header" style="display: flex">
                                    <a href="{{ route('WaletShow', ['EXCType' => 'IR']) }}"
                                        class="btn btn-danger btn-block m-1 mb-3">Walex</a>
                                    <a href="{{ route('WaletShow', ['EXCType' => 'KC']) }}"
                                        class="btn btn-primary btn-block m-1 mb-3">Kucoin</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-3 col-sm-3">
                        <div class="card card-icon mb-4">
                            <div class="card-header text-center cyan text-white font-weight-bold ">
                                <i class="i-Old-Telephone text-white mt-1" style="font-size: 30px"></i>
                                عرضه و تقاضا
                            </div>
                            <div class="card-body text-center">
                                <div class="btnaria-header" style="display: flex">
                                    <a href="{{ route('BestDirections') }}" class="btn btn-danger btn-block m-1 mb-3">یازار
                                        جهانی</a>
                                    <a href="{{ route('BestDirections', 'market=TMN') }}"
                                        class="btn btn-primary btn-block m-1 mb-3">بازار
                                        ایران
                                        <i class=" text-white"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-3 col-sm-3">
                        <div class="card card-icon mb-4">
                            <div class="card-header text-center indigo text-white font-weight-bold ">
                                <i class="i-Add-User text-white mt-1" style="font-size: 30px"></i>
                                آنالیز
                            </div>
                            <div class="card-body text-center">
                                <div class="btnaria-header" style="display: flex">
                                    <a href="{{ route('CryptoAnalyze') }}" type="button"
                                        class="btn btn-danger btn-block m-1 mb-3">آنالیز حجمی</a>
                                    <button onclick="ShowMyUsers()" type="button"
                                        class="btn btn-primary btn-block m-1 mb-3">فهرست </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-3 col-sm-3">
                        <div class="card card-icon mb-4">
                            <div class="card-header text-center orange text-white font-weight-bold ">
                                <i class="i-Paper-Plane text-white mt-1" style="font-size: 30px"></i>
                                ربات
                            </div>
                            <div class="card-body text-center">

                                <div class="btnaria-header" style="display: flex">
                                    <a type="button" href="{{ route('RobotMGT') }}"
                                        class="btn btn-danger btn-block m-1 mb-3">مدیریت <i class=" text-white"></i></a>
                                    <button type="button" class="btn btn-primary btn-block m-1 mb-3">نمایش <i
                                            class=" text-white"></i></button>
                                </div>

                            </div>
                        </div>
                    </div>


                    <div onclick="openform('sendnotif')" class="col-lg-2 col-md-3 col-sm-3">
                        <div class="card card-icon mb-4">
                            <div class="card-header text-center green text-white font-weight-bold ">
                                <i class="i-Mailbox-Full text-white mt-1" style="font-size: 30px"></i>
                                اعلان ها
                            </div>
                            <div class="card-body text-center">
                                <div class="btnaria-header" style="display: flex">
                                    <button type="button" class="btn btn-danger btn-block m-1 mb-3">افرودن <i
                                            class=" text-white"></i></button>
                                    <button type="button" class="btn btn-primary btn-block m-1 mb-3">فهرست <i
                                            class=" text-white"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </form>

    <hr>
    @yield('CryptoCountent')
@endsection
@section('page-js')
@endsection

@php
    $Persian = new App\Functions\persian();
@endphp
@extends('Layouts.MainPage')
@section('page-header-left')
@endsection
@section('MainCountent')
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-lg-6">
                    <div class="page-header-left">
                        <h3>{{ __('setting') }}
                            <small>تنظیمات عمومی</small>
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
        <hr>
        <div class="row">
            <div class="col-lg-12 mb-3">
                <div class="card">
                    <div class="card-header bg-info">
                        <h3 class="text-white card-title"><i style="font-size: 30px" class="i-Arrow-Around"></i> ریست کش
                            پلتفرم</h3>
                    </div>
                    <form method="post">
                        @csrf
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <p class="text-large radio radio-outline-secondary">
                                        ریست کردن کش پلتفرم باعث می شود که پلتفرم مجددا اطلاعات جدید را از سیستم خوانده و در
                                        کش خود ذخیره نماید
                                    </p>

                                    <p class="text-danger text-large">با استفاده از این قابلیت ممکن است سرعت پلتفرم اندکی
                                        کاهش
                                        یابد</p>

                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent">
                            <div class="mc-footer">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <button type="submit" name="submit" value="flush"
                                            class="btn  btn-primary m-1">ریست کردن کش پلتفرم</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- end::form -->
                </div>

            </div>
            <div class="col-lg-6 mb-3">
                <div class="card">
                    <div class="card-header bg-info">
                        <h3 class="text-white card-title"><i style="font-size: 30px" class="i-Arrow-Around"></i>اطلاعات اصلی
                        </h3>
                    </div>
                    <form method="post">
                        @csrf
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="ul-contact-list" class="{{ \App\myappenv::MainTableClass }}" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>شناسه</th>
                                            <th>مقدار</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>کد مرکز</td>
                                            <td>{{ $branch_src->id }}</td>
                                        </tr>
                                        <tr>
                                            <td>نام مرکز</td>
                                            <td><input name="Name" class="form-control" value="{{ $branch_src->Name }}"
                                                    type="text"></td>
                                        </tr>
                                        <tr>
                                            <td>نام کاربری مدیر</td>
                                            <td><input name="UserName" class="form-control"
                                                    value="{{ $branch_src->UserName }}" type="text"></td>
                                        </tr>
                                        <tr>
                                            <td>توضیحات مرکز</td>
                                            <td><input name="Description" class="form-control"
                                                    value="{{ $branch_src->Description }}" type="text"></td>
                                        </tr>
                                        <tr>
                                            <td>تلفن مرکز</td>
                                            <td><input name="Phone" class="form-control" value="{{ $branch_src->Phone }}"
                                                    type="text"></td>
                                        </tr>
                                        <tr>
                                            <td>نمایش تلفن</td>
                                            <td><input name="Phone1" class="form-control" value="{{ $branch_src->Phone1 }}"
                                                    type="text"></td>
                                        </tr>
                                        <tr>
                                            <td>آواتار</td>
                                            <td><input name="avatar" class="form-control" value="{{ $branch_src->avatar }}"
                                                    type="text"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer bg-transparent">
                                <div class="mc-footer">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <button type="submit" name="submit" value="save_main_info"
                                                class="btn  btn-primary m-1">ثبت اطلاعات اصلی</button>
                                            <button type="submit" name="submit" value="add_main_info"
                                                class="btn  btn-danger m-1">ساخت شعبه جدید</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- end::form -->
                </div>

            </div>
            <div class="col-lg-6 mb-3">
                <div class="card">
                    <div class="card-header bg-info">
                        <h3 class="text-white card-title"><i style="font-size: 30px" class="i-Arrow-Around"></i>تنظیمات
                        </h3>
                    </div>
                    <form method="post">
                        @csrf
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="ul-contact-list" class="{{ \App\myappenv::MainTableClass }}" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>شناسه</th>
                                            <th>مقدار</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>نام سایت</td>
                                            <td><input name="item_name[]" class="d-none" value="CenterName"> <input
                                                    name="value[]" class="form-control"
                                                    value="{{ $branch_app_env['CenterName'] ?? '' }}" type="text">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>آدرس سایت کامل</td>
                                            <td><input name="item_name[]" class="d-none" value="SiteAddress"> <input
                                                    name="value[]" class="form-control"
                                                    value="{{ $branch_app_env['SiteAddress'] ?? '' }}" type="text">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>آدرس سایت کوتاه شده</td>
                                            <td><input name="item_name[]" class="d-none" value="SiteAddress1"> <input
                                                    name="value[]" class="form-control"
                                                    value="{{ $branch_app_env['SiteAddress1'] ?? '' }}" type="text">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>آیکون fav</td>
                                            <td><input name="item_name[]" class="d-none" value="FavIcon"> <input
                                                    name="value[]" class="form-control"
                                                    value="{{ $branch_app_env['FavIcon'] ?? '' }}" type="text">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>آیکون اصلی</td>
                                            <td><input name="item_name[]" class="d-none" value="MainIcon"> <input
                                                    name="value[]" class="form-control"
                                                    value="{{ $branch_app_env['MainIcon'] ?? '' }}" type="text">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>توضیحات </td>
                                            <td><input name="item_name[]" class="d-none" value="description"> <input
                                                    name="value[]" class="form-control"
                                                    value="{{ $branch_app_env['description'] ?? '' }}" type="text">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>متن درباره ما فوتر</td>
                                            <td><input name="item_name[]" class="d-none" value="about_us"> <input
                                                    name="value[]" class="form-control"
                                                    value="{{ $branch_app_env['about_us'] ?? '' }}" type="text">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>آدرس</td>
                                            <td><input name="item_name[]" class="d-none" value="address"> <input
                                                    name="value[]" class="form-control"
                                                    value="{{ $branch_app_env['address'] ?? '' }}" type="text">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>تلفن مرکز</td>
                                            <td><input name="item_name[]" class="d-none" value="Phone"> <input
                                                    name="value[]" class="form-control"
                                                    value="{{ $branch_app_env['Phone'] ?? '' }}" type="text">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>نمایش تلفن</td>
                                            <td><input name="item_name[]" class="d-none" value="Phone1"> <input
                                                    name="value[]" class="form-control"
                                                    value="{{ $branch_app_env['Phone1'] ?? '' }}" type="text">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>ایمیل</td>
                                            <td><input name="item_name[]" class="d-none" value="email"> <input
                                                    name="value[]" class="form-control"
                                                    value="{{ $branch_app_env['email'] ?? '' }}" type="text">
                                            </td>
                                        </tr>



                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer bg-transparent">
                                <div class="mc-footer">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <button type="submit" name="submit" value="save_main_setting"
                                                class="btn  btn-primary m-1">ثبت تنظیمات </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- end::form -->
                </div>

            </div>
        </div>
    </div>
@endsection
@section('page-js')
@endsection

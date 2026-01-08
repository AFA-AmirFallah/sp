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
                            <small>{{ __('Financial setting') }}</small>
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
                    <div class="card-header bg-transparent">
                        <h3 class="card-title">ریست کش پلتفرم</h3>
                    </div>
                    <form method="post">
                        @csrf
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label class="radio radio-outline-secondary">
                                        ریست کردن کش پلتفرم باعث می شود که پلتفرم مجددا اطلاعات جدید را از سیستم خوانده و در
                                        کش خود ذخیره نماید
                                    </label>

                                    <small style="color: red">با استفاده از این قابلیت ممکن است سرعت پلتفرم اندکی کاهش
                                        یابد</small>

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
            <div class="col-lg-12 mb-3">
                <div class="card">
                    <div class="card-header bg-transparent">
                        <h3 class="card-title">ریست کامنت   خبر ها </h3>
                    </div>
                    <form method="post">
                        @csrf
                        <div class="card-footer bg-transparent">
                            <div class="mc-footer">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <button type="submit" name="submit" value="comment_reset"
                                            class="btn  btn-primary m-1">ریست کامنت ها</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- end::form -->
                </div>

            </div>
            <div class="col-lg-3 mb-3">
                <div class="card">
                    <div class="card-header bg-transparent">
                        <h3 class="card-title">شرایط و مقررات خرید از فروشگاه</h3>
                    </div>
                    @php
                        if (array_search('buy_rule', array_column($SettingSrc, 'name')) != false) {
                            $targetArr = $SettingSrc[array_search('buy_rule', array_column($SettingSrc, 'name'))];
                        } else {
                            $targetArr = null;
                        }

                    @endphp
                    <form method="post">
                        @csrf
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label class="radio radio-outline-secondary">
                                        پست مربوط به شرایط و مقررات خرید از فروشگاه
                                    </label>
                                    @if ($targetArr != null)
                                        <input type="number" class="form-control" name="buy_rule"
                                            value="{{ $targetArr['value'] }}">
                                    @else
                                        <input type="number" class="form-control" name="buy_rule" value="">
                                    @endif
                                    <small>کد پست مربوط به شرایط و مقررات خرید از سایت را درج کنید </small>
                                    <small class="text-danger"> - 0 غیر فعال</small>

                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent">
                            <div class="mc-footer">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <button type="submit" name="submit" value="buy_rule"
                                            class="btn  btn-primary m-1">{{ __('Submit') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- end::form -->
                </div>

            </div>
            <div class="col-lg-3 mb-3">
                <div class="card">
                    <div class="card-header bg-transparent">
                        <h3 class="card-title">شرایط و مقررات سایت</h3>
                    </div>
                    @php
                        if (array_search('Rolls', array_column($SettingSrc, 'name')) != false) {
                            $targetArr = $SettingSrc[array_search('Rolls', array_column($SettingSrc, 'name'))];
                        } else {
                            $targetArr = null;
                        }

                    @endphp
                    <form method="post">
                        @csrf
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label class="radio radio-outline-secondary">
                                        پست مربوط به شرایط و مقررات سایت
                                    </label>
                                    @if ($targetArr != null)
                                        <input type="number" class="form-control" name="Rolls"
                                            value="{{ $targetArr['value'] }}">
                                    @else
                                        <input type="number" class="form-control" name="Rolls" value="">
                                    @endif
                                    <small>کد پست مربوط به شرایط و مقررات سایت را درج کنید</small>

                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent">
                            <div class="mc-footer">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <button type="submit" name="submit" value="Rolls"
                                            class="btn  btn-primary m-1">{{ __('Submit') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- end::form -->
                </div>

            </div>
            <div class="col-lg-3 mb-3">
                <div class="card">
                    <div class="card-header bg-transparent">
                        <h3 class="card-title">شاخص جدید ترین محصولات</h3>
                    </div>
                    @php
                        if (array_search('new_product_index', array_column($SettingSrc, 'name')) != false) {
                            $targetArr =
                                $SettingSrc[array_search('new_product_index', array_column($SettingSrc, 'name'))];
                        } else {
                            $targetArr = null;
                        }

                    @endphp
                    <form method="post">
                        @csrf
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label class="radio radio-outline-secondary">
                                        شاخص انتخاب شده به صورت اتوماتیک جدید ترین محصولات را نمایش میدهد
                                    </label>
                                    @if ($targetArr != null)
                                        <input type="number" class="form-control" name="new_product_index"
                                            value="{{ $targetArr['value'] }}">
                                    @else
                                        <input type="number" class="form-control" name="new_product_index"
                                            value="">
                                    @endif

                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent">
                            <div class="mc-footer">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <button type="submit" name="submit" value="new_product_index"
                                            class="btn  btn-primary m-1">{{ __('Submit') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- end::form -->
                </div>

            </div>
            <div class="col-lg-3 mb-3">
                <div class="card">
                    <div class="card-header bg-transparent">
                        <h3 class="card-title">باشگاه مشتریان</h3>
                    </div>
                    @php
                        if (array_search('number_to_point', array_column($SettingSrc, 'name')) != false) {
                            $targetArr =
                                $SettingSrc[array_search('number_to_point', array_column($SettingSrc, 'name'))];
                        } else {
                            $targetArr = null;
                        }

                    @endphp
                    <form method="post">
                        @csrf
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label class="radio radio-outline-secondary">
                                        به ازای چه مبلغی یک امتیاز تعلق بگیرد
                                    </label>
                                    @if ($targetArr != null)
                                        <input type="number" class="form-control" name="number_to_point"
                                            value="{{ $targetArr['value'] }}">
                                    @else
                                        <input type="number" class="form-control" name="number_to_point"
                                            value="">
                                    @endif

                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent">
                            <div class="mc-footer">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <button type="submit" name="submit" value="number_to_point"
                                            class="btn  btn-primary m-1">{{ __('Submit') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- end::form -->
                </div>

            </div>

            <div class="col-lg-3 mb-3">
                <div class="card">
                    <div class="card-header bg-transparent">
                        <h3 class="card-title">متن باشگاه مشتریان</h3>
                    </div>
                    @php
                        if (array_search('number_to_point_txt', array_column($SettingSrc, 'name')) != false) {
                            $targetArr =
                                $SettingSrc[array_search('number_to_point_txt', array_column($SettingSrc, 'name'))];
                        } else {
                            $targetArr = null;
                        }

                    @endphp
                    <form method="post">
                        @csrf
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label class="radio radio-outline-secondary">
                                        متن نمایش باشگاه مشتریان
                                    </label>
                                    @if ($targetArr != null)
                                        <input type="text" class="form-control" name="number_to_point_txt"
                                            value="{{ $targetArr['value'] }}">
                                    @else
                                        <input type="text" class="form-control" name="number_to_point_txt"
                                            value="">
                                    @endif

                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent">
                            <div class="mc-footer">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <button type="submit" name="submit" value="number_to_point_txt"
                                            class="btn  btn-primary m-1">{{ __('Submit') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- end::form -->
                </div>

            </div>
            <div class="col-lg-3 mb-3">
                <div class="card">
                    <div class="card-header bg-transparent">
                        <h3 class="card-title">آیدی گفتینو</h3>
                    </div>
                    @php
                        if (array_search('goftino_id', array_column($SettingSrc, 'name')) != false) {
                            $targetArr = $SettingSrc[array_search('goftino_id', array_column($SettingSrc, 'name'))];
                        } else {
                            $targetArr = null;
                        }

                    @endphp
                    <form method="post">
                        @csrf
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label class="radio radio-outline-secondary">
                                        آیدی دریافتی از سایت گفتینو
                                    </label>
                                    @if ($targetArr != null)
                                        <input type="text" class="form-control" name="goftino_id"
                                            value="{{ $targetArr['value'] }}">
                                    @else
                                        <input type="text" class="form-control" name="goftino_id" value="">
                                    @endif

                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent">
                            <div class="mc-footer">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <button type="submit" name="submit" value="goftino_id"
                                            class="btn  btn-primary m-1">{{ __('Submit') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- end::form -->
                </div>

            </div>
            <div class="col-lg-3 mb-3">
                <div class="card">
                    <div class="card-header bg-transparent">
                        <h3 class="card-title">امتیاز به کوپن</h3>
                    </div>
                    @php
                        if (array_search('point_to_copoun', array_column($SettingSrc, 'name')) != false) {
                            $targetArr =
                                $SettingSrc[array_search('point_to_copoun', array_column($SettingSrc, 'name'))];
                        } else {
                            $targetArr = null;
                        }

                    @endphp
                    <form method="post">
                        @csrf
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label class="radio radio-outline-secondary">
                                        به ازای چه امتیازی کوپن تعلق گیرد
                                    </label>
                                    @if ($targetArr != null)
                                        <input type="text" class="form-control" name="point_to_copoun"
                                            value="{{ $targetArr['value'] }}">
                                    @else
                                        <input type="text" class="form-control" name="point_to_copoun"
                                            value="">
                                    @endif

                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent">
                            <div class="mc-footer">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <button type="submit" name="submit" value="point_to_copoun"
                                            class="btn  btn-primary m-1">{{ __('Submit') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- end::form -->
                </div>

            </div>
            <div class="col-lg-3 mb-3">
                <div class="card">
                    <div class="card-header bg-transparent">
                        <h3 class="card-title">درصد تخفیف در کوپن امتیازات</h3>
                    </div>
                    @php
                        if (array_search('percent_per_coupon', array_column($SettingSrc, 'name')) != false) {
                            $targetArr =
                                $SettingSrc[array_search('percent_per_coupon', array_column($SettingSrc, 'name'))];
                        } else {
                            $targetArr = null;
                        }

                    @endphp
                    <form method="post">
                        @csrf
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label class="radio radio-outline-secondary">
                                        درصد تخفیف در کوپن امتیازات
                                    </label>
                                    @if ($targetArr != null)
                                        <input type="text" class="form-control" name="percent_per_coupon"
                                            value="{{ $targetArr['value'] }}">
                                    @else
                                        <input type="text" class="form-control" name="percent_per_coupon"
                                            value="">
                                    @endif

                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent">
                            <div class="mc-footer">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <button type="submit" name="submit" value="percent_per_coupon"
                                            class="btn  btn-primary m-1">{{ __('Submit') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- end::form -->
                </div>

            </div>
            <div class="col-lg-3 mb-3">
                <div class="card">
                    <div class="card-header bg-transparent">
                        <h3 class="card-title">نمایش جدول مشخصات</h3>
                    </div>
                    @php
                        if (array_search('show_table_of_index', array_column($SettingSrc, 'name')) != false) {
                            $targetArr =
                                $SettingSrc[array_search('show_table_of_index', array_column($SettingSrc, 'name'))];
                        } else {
                            $targetArr = null;
                        }

                    @endphp
                    <form method="post">
                        @csrf
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label class="radio radio-outline-secondary">
                                        نمایش جدول مشخصات ۱: بله ۲: خیر
                                    </label>
                                    @if ($targetArr != null)
                                        <input type="number" class="form-control" name="show_table_of_index"
                                            value="{{ $targetArr['value'] }}">
                                    @else
                                        <input type="text" class="form-control" name="show_table_of_index"
                                            value="">
                                    @endif

                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent">
                            <div class="mc-footer">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <button type="submit" name="submit" value="show_table_of_index"
                                            class="btn  btn-primary m-1">{{ __('Submit') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- end::form -->
                </div>

            </div>
            <div class="col-lg-3 mb-3">
                <div class="card">
                    <div class="card-header bg-transparent">
                        <h3 class="card-title">مدت انقضای کوپن تولیدی</h3>
                    </div>
                    @php
                        if (array_search('coupon_expire_days', array_column($SettingSrc, 'name')) != false) {
                            $targetArr =
                                $SettingSrc[array_search('coupon_expire_days', array_column($SettingSrc, 'name'))];
                        } else {
                            $targetArr = null;
                        }

                    @endphp
                    <form method="post">
                        @csrf
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label class="radio radio-outline-secondary">
                                        مدت انقضای هر کوپن چند روز باشد
                                    </label>
                                    @if ($targetArr != null)
                                        <input type="text" class="form-control" name="coupon_expire_days"
                                            value="{{ $targetArr['value'] }}">
                                    @else
                                        <input type="text" class="form-control" name="coupon_expire_days"
                                            value="">
                                    @endif

                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent">
                            <div class="mc-footer">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <button type="submit" name="submit" value="coupon_expire_days"
                                            class="btn  btn-primary m-1">{{ __('Submit') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- end::form -->
                </div>
            </div>
            <div class="col-lg-3 mb-3">
                <div class="card">
                    <div class="card-header bg-transparent">
                        <h3 class="card-title">تعداد نمایش محصول در یک صفحه</h3>
                    </div>
                    @php
                        if (array_search('product_pag', array_column($SettingSrc, 'name')) != false) {
                            $targetArr = $SettingSrc[array_search('product_pag', array_column($SettingSrc, 'name'))];
                        } else {
                            $targetArr = null;
                        }

                    @endphp
                    <form method="post">
                        @csrf
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label class="radio radio-outline-secondary">
                                        pagination محصولات </label>
                                    @if ($targetArr != null)
                                        <input type="text" class="form-control" name="product_pag"
                                            value="{{ $targetArr['value'] }}">
                                    @else
                                        <input type="text" class="form-control" name="product_pag" value="">
                                    @endif

                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent">
                            <div class="mc-footer">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <button type="submit" name="submit" value="product_pag"
                                            class="btn  btn-primary m-1">{{ __('Submit') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- end::form -->
                </div>
            </div>
            <div class="col-lg-3 mb-3">
                <div class="card">
                    <div class="card-header bg-transparent">
                        <h3 class="card-title">منو اصلی</h3>
                    </div>
                    @php
                        if (array_search('MainMenu', array_column($SettingSrc, 'name')) != false) {
                            $targetArr = $SettingSrc[array_search('MainMenu', array_column($SettingSrc, 'name'))];
                        } else {
                            $targetArr = null;
                        }

                    @endphp
                    <form method="post">
                        @csrf
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label class="radio radio-outline-secondary">
                                        ورود منوی اصلی به جیسون
                                    </label>
                                    @if ($targetArr != null)
                                        <input type="text" class="form-control" name="MainMenu"
                                            value="{{ $targetArr['value'] }}">
                                    @else
                                        <input type="text" class="form-control" name="MainMenu" value="">
                                    @endif

                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent">
                            <div class="mc-footer">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <button type="submit" name="submit" value="MainMenu"
                                            class="btn  btn-primary m-1">{{ __('Submit') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- end::form -->
                </div>
            </div>
            <div class="col-lg-3 mb-3">
                <div class="card">
                    <div class="card-header bg-transparent">
                        <h3 class="card-title">منو تست</h3>
                    </div>
                    @php
                        if (array_search('MainMenuT', array_column($SettingSrc, 'name')) != false) {
                            $targetArr = $SettingSrc[array_search('MainMenuT', array_column($SettingSrc, 'name'))];
                        } else {
                            $targetArr = null;
                        }

                    @endphp
                    <form method="post">
                        @csrf
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label class="radio radio-outline-secondary">
                                        ورود منوی تست به جیسون
                                    </label>
                                    @if ($targetArr != null)
                                        <input type="text" class="form-control" name="MainMenuT"
                                            value="{{ $targetArr['value'] }}">
                                    @else
                                        <input type="text" class="form-control" name="MainMenuT" value="">
                                    @endif

                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent">
                            <div class="mc-footer">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <button type="submit" name="submit" value="MainMenuT"
                                            class="btn  btn-primary m-1">{{ __('Submit') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- end::form -->
                </div>
            </div>
            <div class="col-lg-3 mb-3">
                <div class="card">
                    <div class="card-header bg-transparent">
                        <h3 class="card-title">مهارت ها</h3>
                    </div>
                    @php
                        if (array_search('experts', array_column($SettingSrc, 'name')) != false) {
                            $targetArr = $SettingSrc[array_search('experts', array_column($SettingSrc, 'name'))];
                        } else {
                            $targetArr = null;
                        }

                    @endphp
                    <form method="post">
                        @csrf
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label class="radio radio-outline-secondary">
                                        ورود مهارت ها به جیسون
                                    </label>
                                    @if ($targetArr != null)
                                        <input type="text" class="form-control" name="experts"
                                            value="{{ $targetArr['value'] }}">
                                    @else
                                        <input type="text" class="form-control" name="experts" value="">
                                    @endif

                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent">
                            <div class="mc-footer">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <button type="submit" name="submit" value="experts"
                                            class="btn  btn-primary m-1">{{ __('Submit') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- end::form -->
                </div>
            </div>
            <div class="col-lg-3 mb-3">
                <div class="card">
                    <div class="card-header bg-transparent">
                        <h3 class="card-title">شرایط خرید</h3>
                        <small>نمایش در هنگام ثبت سفارش</small>
                    </div>
                    @php
                        if (array_search('BuyCondition', array_column($SettingSrc, 'name')) != false) {
                            $targetArr = $SettingSrc[array_search('BuyCondition', array_column($SettingSrc, 'name'))];
                        } else {
                            $targetArr = null;
                        }

                    @endphp
                    <form method="post">
                        @csrf
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label class="radio radio-outline-secondary">
                                        متن شرایط خرید به صورت HTML - حذف با #
                                    </label>
                                    @if ($targetArr != null)
                                        <input type="text" class="form-control" name="BuyCondition"
                                            value="{{ $targetArr['value'] }}">
                                    @else
                                        <input type="text" class="form-control" name="BuyCondition" value="">
                                    @endif

                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent">
                            <div class="mc-footer">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <button type="submit" name="submit" value="BuyCondition"
                                            class="btn  btn-primary m-1">{{ __('Submit') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- end::form -->
                </div>
            </div>
            <div class="col-lg-3 mb-3">
                <div class="card">
                    <div class="card-header bg-transparent">
                        <h3 class="card-title">مبلغ ارسال رایگان</h3>
                    </div>
                    @php
                        if (array_search('FreeDelever', array_column($SettingSrc, 'name')) != false) {
                            $targetArr = $SettingSrc[array_search('FreeDelever', array_column($SettingSrc, 'name'))];
                        } else {
                            $targetArr = null;
                        }

                    @endphp
                    <form method="post">
                        @csrf
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label class="radio radio-outline-secondary">
                                        عدد صفر به معنی نداشتن ارسال رایگان است
                                    </label>
                                    @if ($targetArr != null)
                                        <input type="text" class="form-control" name="FreeDelever"
                                            value="{{ $targetArr['value'] }}">
                                    @else
                                        <input type="text" class="form-control" name="FreeDelever" value="">
                                    @endif

                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent">
                            <div class="mc-footer">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <button type="submit" name="submit" value="FreeDelever"
                                            class="btn  btn-primary m-1">{{ __('Submit') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- end::form -->
                </div>
            </div>
            <div class="col-lg-3 mb-3">
                <div class="card">
                    <div class="card-header bg-transparent">
                        <h3 class="card-title">متن ارسال رایگان</h3>
                    </div>
                    @php
                        if (array_search('FreeDeleverText', array_column($SettingSrc, 'name')) != false) {
                            $targetArr =
                                $SettingSrc[array_search('FreeDeleverText', array_column($SettingSrc, 'name'))];
                        } else {
                            $targetArr = null;
                        }

                    @endphp
                    <form method="post">
                        @csrf
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label class="radio radio-outline-secondary">
                                        حذف #
                                    </label>
                                    @if ($targetArr != null)
                                        <input type="text" class="form-control" name="FreeDeleverText"
                                            value="{{ $targetArr['value'] }}">
                                    @else
                                        <input type="text" class="form-control" name="FreeDeleverText"
                                            value="">
                                    @endif

                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent">
                            <div class="mc-footer">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <button type="submit" name="submit" value="FreeDeleverText"
                                            class="btn  btn-primary m-1">{{ __('Submit') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- end::form -->
                </div>
            </div>
            <div class="col-lg-3 mb-3">
                <div class="card">
                    <div class="card-header bg-transparent">
                        <h3 class="card-title">پیامک در دست اقدام</h3>
                    </div>
                    @php
                        if (array_search('SMS_DDE', array_column($SettingSrc, 'name')) != false) {
                            $targetArr = $SettingSrc[array_search('SMS_DDE', array_column($SettingSrc, 'name'))];
                        } else {
                            $targetArr = null;
                        }

                    @endphp
                    <form method="post">
                        @csrf
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label class="radio radio-outline-secondary">
                                        ٪Name٪ => نام مشتری,
                                        ٪Factor٪=>شماره صورت حساب

                                    </label>
                                    @if ($targetArr != null)
                                        <input type="text" class="form-control" name="SMS_DDE"
                                            value="{{ $targetArr['value'] }}">
                                    @else
                                        <input type="text" class="form-control" name="SMS_DDE" value="">
                                    @endif

                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent">
                            <div class="mc-footer">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <button type="submit" name="submit" value="SMS_DDE"
                                            class="btn  btn-primary m-1">{{ __('Submit') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- end::form -->
                </div>
            </div>
            <div class="col-lg-3 mb-3">
                <div class="card">
                    <div class="card-header bg-transparent">
                        <h3 class="card-title">پیامک ارسال به انبار</h3>
                    </div>
                    @php
                        if (array_search('SMS_EBA', array_column($SettingSrc, 'name')) != false) {
                            $targetArr = $SettingSrc[array_search('SMS_EBA', array_column($SettingSrc, 'name'))];
                        } else {
                            $targetArr = null;
                        }

                    @endphp
                    <form method="post">
                        @csrf
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label class="radio radio-outline-secondary">
                                        ٪Name٪ => نام مشتری,
                                        ٪Factor٪=>شماره صورت حساب
                                    </label>
                                    @if ($targetArr != null)
                                        <input type="text" class="form-control" name="SMS_EBA"
                                            value="{{ $targetArr['value'] }}">
                                    @else
                                        <input type="text" class="form-control" name="SMS_EBA" value="">
                                    @endif

                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent">
                            <div class="mc-footer">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <button type="submit" name="submit" value="SMS_EBA"
                                            class="btn  btn-primary m-1">{{ __('Submit') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- end::form -->
                </div>
            </div>
            <div class="col-lg-3 mb-3">
                <div class="card">
                    <div class="card-header bg-transparent">
                        <h3 class="card-title">پیامک در حال بسته بندی</h3>
                    </div>
                    @php
                        if (array_search('SMS_DHBB', array_column($SettingSrc, 'name')) != false) {
                            $targetArr = $SettingSrc[array_search('SMS_DHBB', array_column($SettingSrc, 'name'))];
                        } else {
                            $targetArr = null;
                        }

                    @endphp
                    <form method="post">
                        @csrf
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label class="radio radio-outline-secondary">
                                        ٪Name٪ => نام مشتری,
                                        ٪Factor٪=>شماره صورت حساب

                                    </label>
                                    @if ($targetArr != null)
                                        <input type="text" class="form-control" name="SMS_DHBB"
                                            value="{{ $targetArr['value'] }}">
                                    @else
                                        <input type="text" class="form-control" name="SMS_DHBB" value="">
                                    @endif

                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent">
                            <div class="mc-footer">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <button type="submit" name="submit" value="SMS_DHBB"
                                            class="btn  btn-primary m-1">{{ __('Submit') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- end::form -->
                </div>
            </div>
            <div class="col-lg-3 mb-3">
                <div class="card">
                    <div class="card-header bg-transparent">
                        <h3 class="card-title">پیامک ارسال به پست</h3>
                    </div>
                    @php
                        if (array_search('SMS_EBP', array_column($SettingSrc, 'name')) != false) {
                            $targetArr = $SettingSrc[array_search('SMS_EBP', array_column($SettingSrc, 'name'))];
                        } else {
                            $targetArr = null;
                        }

                    @endphp
                    <form method="post">
                        @csrf
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label class="radio radio-outline-secondary">
                                        ٪Name٪ => نام مشتری,
                                        ٪Factor٪=>شماره صورت حساب
                                    </label>
                                    @if ($targetArr != null)
                                        <input type="text" class="form-control" name="SMS_EBP"
                                            value="{{ $targetArr['value'] }}">
                                    @else
                                        <input type="text" class="form-control" name="SMS_EBP" value="">
                                    @endif

                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent">
                            <div class="mc-footer">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <button type="submit" name="submit" value="SMS_EBP"
                                            class="btn  btn-primary m-1">{{ __('Submit') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- end::form -->
                </div>
            </div>

            <div class="col-lg-3 mb-3">
                <div class="card">
                    <div class="card-header bg-transparent">
                        <h3 class="card-title">اجاره کالا</h3>
                    </div>
                    @php
                        if (array_search('renting', array_column($SettingSrc, 'name')) != false) {
                            $targetArr = $SettingSrc[array_search('renting', array_column($SettingSrc, 'name'))];
                        } else {
                            $targetArr = null;
                        }

                    @endphp
                    <form method="post">
                        @csrf
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label class="radio radio-outline-secondary">
                                        فعال سازی قابلیت اجاره کالا ۱: بله ۲: خیر
                                    </label>
                                    @if ($targetArr != null)
                                        <input type="number" class="form-control" name="renting"
                                            value="{{ $targetArr['value'] }}">
                                    @else
                                        <input type="text" class="form-control" name="renting" value="">
                                    @endif

                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent">
                            <div class="mc-footer">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <button type="submit" name="submit" value="renting"
                                            class="btn  btn-primary m-1">{{ __('Submit') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- end::form -->
                </div>

            </div>
            <div class="col-lg-3 mb-3">
                <div class="card">
                    <div class="card-header bg-transparent">
                        <h3 class="card-title"> پیام رسان بله</h3>
                    </div>
                    @php
                        if (array_search('bale_api', array_column($SettingSrc, 'name')) != false) {
                            $targetArr = $SettingSrc[array_search('bale_api', array_column($SettingSrc, 'name'))];
                        } else {
                            $targetArr = null;
                        }

                    @endphp
                    <form method="post">
                        @csrf
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label class="radio radio-outline-secondary">
                                        فعال سازی پیام رسان بله ۱: بله ۲: خیر
                                    </label>
                                    @if ($targetArr != null)
                                        <input type="number" class="form-control" name="bale_api"
                                            value="{{ $targetArr['value'] }}">
                                    @else
                                        <input type="text" class="form-control" name="bale_api" value="">
                                    @endif

                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent">
                            <div class="mc-footer">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <button type="submit" name="submit" value="bale_api"
                                            class="btn  btn-primary m-1">{{ __('Submit') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- end::form -->
                </div>

            </div>
            <div class="col-lg-3 mb-3">
                <div class="card">
                    <div class="card-header bg-transparent">
                        <h3 class="card-title">توکن پیام رسان بله</h3>
                    </div>
                    @php
                        if (array_search('bale_api_token', array_column($SettingSrc, 'name')) != false) {
                            $targetArr = $SettingSrc[array_search('bale_api_token', array_column($SettingSrc, 'name'))];
                        } else {
                            $targetArr = null;
                        }

                    @endphp
                    <form method="post">
                        @csrf
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label class="radio radio-outline-secondary">
                                        توکن پیام رسان بله
                                    </label>
                                    @if ($targetArr != null)
                                        <input type="text" class="form-control" name="bale_api_token"
                                            value="{{ $targetArr['value'] }}">
                                    @else
                                        <input type="text" class="form-control" name="bale_api_token" value="">
                                    @endif

                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent">
                            <div class="mc-footer">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <button type="submit" name="submit" value="bale_api_token"
                                            class="btn  btn-primary m-1">{{ __('Submit') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- end::form -->
                </div>

            </div>
            <div class="col-lg-3 mb-3">
                <div class="card">
                    <div class="card-header bg-transparent">
                        <h3 class="card-title">نام کاربری پیام رسان بله</h3>
                    </div>
                    @php
                        if (array_search('bale_api_name', array_column($SettingSrc, 'name')) != false) {
                            $targetArr = $SettingSrc[array_search('bale_api_name', array_column($SettingSrc, 'name'))];
                        } else {
                            $targetArr = null;
                        }
                    @endphp
                    <form method="post">
                        @csrf
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label class="radio radio-outline-secondary">
                                        نام کاربری پیام رسان بله @name
                                    </label>
                                    @if ($targetArr != null)
                                        <input type="text" class="form-control" name="bale_api_name"
                                            value="{{ $targetArr['value'] }}">
                                    @else
                                        <input type="text" class="form-control" name="bale_api_name" value="">
                                    @endif

                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent">
                            <div class="mc-footer">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <button type="submit" name="submit" value="bale_api_name"
                                            class="btn  btn-primary m-1">{{ __('Submit') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- end::form -->
                </div>

            </div>
            <div class="col-lg-3 mb-3">
                <div class="card">
                    <div class="card-header bg-transparent">
                        <h3 class="card-title"> chatid پیام رسان بله</h3>
                    </div>
                    @php
                        if (array_search('bale_api_chat_id', array_column($SettingSrc, 'name')) != false) {
                            $targetArr =
                                $SettingSrc[array_search('bale_api_chat_id', array_column($SettingSrc, 'name'))];
                        } else {
                            $targetArr = null;
                        }

                    @endphp
                    <form method="post">
                        @csrf
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label class="radio radio-outline-secondary">
                                        chatid پیام رسان بله
                                    </label>
                                    @if ($targetArr != null)
                                        <input type="number" class="form-control" name="bale_api_chat_id"
                                            value="{{ $targetArr['value'] }}">
                                    @else
                                        <input type="text" class="form-control" name="bale_api_chat_id"
                                            value="">
                                    @endif

                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent">
                            <div class="mc-footer">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <button type="submit" name="submit" value="bale_api_chat_id"
                                            class="btn  btn-primary m-1">{{ __('Submit') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- end::form -->
                </div>

            </div>
            <div class="col-lg-3 mb-3">
                <div class="card">
                    <div class="card-header bg-transparent">
                        <h3 class="card-title">گزارش بازدید</h3>
                    </div>
                    @php
                        if (array_search('view_count_days', array_column($SettingSrc, 'name')) != false) {
                            $targetArr =
                                $SettingSrc[array_search('view_count_days', array_column($SettingSrc, 'name'))];
                        } else {
                            $targetArr = null;
                        }

                    @endphp
                    <form method="post">
                        @csrf
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label class="radio radio-outline-secondary">
                                        تعداد روزهای گزارش بازدید
                                    </label>
                                    @if ($targetArr != null)
                                        <input type="number" class="form-control" name="view_count_days"
                                            value="{{ $targetArr['value'] }}">
                                    @else
                                        <input type="text" class="form-control" name="view_count_days"
                                            value="">
                                    @endif

                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent">
                            <div class="mc-footer">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <button type="submit" name="submit" value="view_count_days"
                                            class="btn  btn-primary m-1">{{ __('Submit') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- end::form -->
                </div>

            </div>
            @if (\App\myappenv::Lic['crypto'])
                <div class="col-lg-3 mb-3">
                    <div class="card">
                        <div class="card-header bg-transparent">
                            <h3 class="card-title">بک تست</h3>
                        </div>
                        @php
                            if (array_search('Crypto_Back_test', array_column($SettingSrc, 'name')) != false) {
                                $targetArr =
                                    $SettingSrc[array_search('Crypto_Back_test', array_column($SettingSrc, 'name'))];
                            } else {
                                $targetArr = null;
                            }

                        @endphp
                        <form method="post">
                            @csrf
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label class="radio radio-outline-secondary">
                                            فعال سازی بک تست ۱: بله ۲: خیر
                                        </label>
                                        @if ($targetArr != null)
                                            <input type="number" class="form-control" name="Crypto_Back_test"
                                                value="{{ $targetArr['value'] }}">
                                        @else
                                            <input type="text" class="form-control" name="Crypto_Back_test"
                                                value="">
                                        @endif

                                    </div>
                                </div>
                            </div>
                            <div class="card-footer bg-transparent">
                                <div class="mc-footer">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <button type="submit" name="submit" value="Crypto_Back_test"
                                                class="btn  btn-primary m-1">{{ __('Submit') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <!-- end::form -->
                    </div>

                </div>
            @endif
            <div class="col-lg-3 mb-3">
                <div class="card">
                    <div class="card-header bg-transparent">
                        <h3 class="card-title"> نوع پلکانی</h3>
                    </div>
                    @php
                        if (array_search('step_mode', array_column($SettingSrc, 'name')) != false) {
                            $targetArr = $SettingSrc[array_search('step_mode', array_column($SettingSrc, 'name'))];
                        } else {
                            $targetArr = null;
                        }

                    @endphp
                    <form method="post">
                        @csrf
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label class="radio radio-outline-secondary">
                                        1: از تا و ۲: بیشتر از
                                    </label>
                                    @if ($targetArr != null)
                                        <input type="number" class="form-control" name="step_mode"
                                            value="{{ $targetArr['value'] }}">
                                    @else
                                        <input type="text" class="form-control" name="step_mode" value="">
                                    @endif

                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent">
                            <div class="mc-footer">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <button type="submit" name="submit" value="step_mode"
                                            class="btn  btn-primary m-1">{{ __('Submit') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- end::form -->
                </div>

            </div>
            <div class="col-lg-3 mb-3">
                <div class="card">
                    <div class="card-header bg-transparent">
                        <h3 class="card-title">آیتم های داشبورد سوپر ادمین</h3>
                    </div>
                    @php
                        if (array_search('dashboard_su', array_column($SettingSrc, 'name')) != false) {
                            $targetArr = $SettingSrc[array_search('dashboard_su', array_column($SettingSrc, 'name'))];
                            $Filds = json_decode($targetArr['value']);
                        } else {
                            $targetArr = null;
                            $Filds = [];
                        }

                    @endphp
                    <form method="post">
                        @csrf
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <table class="table">
                                        <tr>
                                            <td>
                                                لایسنس های سامانه
                                            </td>
                                            <td>
                                                @isset($Filds->lic)
                                                    <input type="checkbox" class="form-input" checked
                                                        name="dashboard_su[lic]">نمایش
                                                @else
                                                    <input type="checkbox" class="form-input" name="dashboard_su[lic]"> نمایش
                                                @endisset

                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                محصولات درخواستی مشتریان
                                            </td>
                                            <td>
                                                @isset($Filds->product_alert)
                                                    <input type="checkbox" class="form-input" checked
                                                        name="dashboard_su[product_alert]">نمایش
                                                @else
                                                    <input type="checkbox" class="form-input"
                                                        name="dashboard_su[product_alert]"> نمایش
                                                @endisset

                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                بیشترین فروش یک ماهه
                                            </td>
                                            <td>
                                                @isset($Filds->most_sell)
                                                    <input type="checkbox" class="form-input" checked
                                                        name="dashboard_su[most_sell]">نمایش
                                                @else
                                                    <input type="checkbox" class="form-input" name="dashboard_su[most_sell]">
                                                    نمایش
                                                @endisset
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                اخطار محصولات
                                            </td>
                                            <td>
                                                @isset($Filds->product_danger)
                                                    <input type="checkbox" class="form-input" checked
                                                        name="dashboard_su[product_danger]">نمایش
                                                @else
                                                    <input type="checkbox" class="form-input"
                                                        name="dashboard_su[product_danger]"> نمایش
                                                @endisset

                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                محصولات رقبا
                                            </td>
                                            <td>
                                                @isset($Filds->product_crawler)
                                                    <input type="checkbox" class="form-input" checked
                                                        name="dashboard_su[product_crawler]">نمایش
                                                @else
                                                    <input type="checkbox" class="form-input"
                                                        name="dashboard_su[product_crawler]"> نمایش
                                                @endisset

                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                پیامک های دریافتی سامانه
                                            </td>
                                            <td>
                                                @isset($Filds->sms_recive)
                                                    <input type="checkbox" class="form-input" checked
                                                        name="dashboard_su[sms_recive]">نمایش
                                                @else
                                                    <input type="checkbox" class="form-input"
                                                        name="dashboard_su[sms_recive]"> نمایش
                                                @endisset

                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                کاربران ۲۴ ساعت گذشته
                                            </td>
                                            <td>
                                                @isset($Filds->user_last_24)
                                                    <input type="checkbox" class="form-input" checked
                                                        name="dashboard_su[user_last_24]">نمایش
                                                @else
                                                    <input type="checkbox" class="form-input"
                                                        name="dashboard_su[user_last_24]"> نمایش
                                                @endisset

                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                نظرات جدید
                                            </td>
                                            <td>
                                                @isset($Filds->new_comments)
                                                    <input type="checkbox" class="form-input" checked
                                                        name="dashboard_su[new_comments]">نمایش
                                                @else
                                                    <input type="checkbox" class="form-input"
                                                        name="dashboard_su[new_comments]"> نمایش
                                                @endisset

                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                پرسنل مشغول به کار
                                            </td>
                                            <td>
                                                @isset($Filds->hozorgheyab)
                                                    <input type="checkbox" class="form-input" checked
                                                        name="dashboard_su[hozorgheyab]">نمایش
                                                @else
                                                    <input type="checkbox" class="form-input"
                                                        name="dashboard_su[hozorgheyab]"> نمایش
                                                @endisset

                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                تیکت ها در یک نگاه
                                            </td>
                                            <td>
                                                @isset($Filds->ticket_statistic)
                                                    <input type="checkbox" class="form-input" checked
                                                        name="dashboard_su[ticket_statistic]">نمایش
                                                @else
                                                    <input type="checkbox" class="form-input"
                                                        name="dashboard_su[ticket_statistic]"> نمایش
                                                @endisset

                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                درآمد ۱۰ روز اخیر
                                            </td>
                                            <td>
                                                @isset($Filds->daramad)
                                                    <input type="checkbox" class="form-input" checked
                                                        name="dashboard_su[daramad]">نمایش
                                                @else
                                                    <input type="checkbox" class="form-input" name="dashboard_su[daramad]">
                                                    نمایش
                                                @endisset

                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                بازدید های امروز
                                            </td>
                                            <td>
                                                @isset($Filds->today_visit)
                                                    <input type="checkbox" class="form-input" checked
                                                        name="dashboard_su[today_visit]">نمایش
                                                @else
                                                    <input type="checkbox" class="form-input"
                                                        name="dashboard_su[today_visit]">
                                                    نمایش
                                                @endisset

                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent">
                            <div class="mc-footer">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <button type="submit" name="submit" value="dashboard_su"
                                            class="btn  btn-primary m-1">{{ __('Submit') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- end::form -->
                </div>
            </div>
            <div class="col-lg-3 mb-3">
                <div class="card">
                    <div class="card-header bg-transparent">
                        <h3 class="card-title">فیلد های ضروری هنگام ثبت نام</h3>
                    </div>
                    @php
                        if (array_search('register_feilds', array_column($SettingSrc, 'name')) != false) {
                            $targetArr =
                                $SettingSrc[array_search('register_feilds', array_column($SettingSrc, 'name'))];
                            $Filds = json_decode($targetArr['value']);
                        } else {
                            $targetArr = null;
                            $Filds = [];
                        }

                    @endphp
                    <form method="post">
                        @csrf
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <table class="table">
                                        <tr>
                                            <td>
                                                کد ملی
                                            </td>
                                            <td>
                                                @isset($Filds->melliid)
                                                    <input type="checkbox" class="form-input" checked
                                                        name="register_feilds[melliid]"> وجود فیلد
                                                @else
                                                    <input type="checkbox" class="form-input"
                                                        name="register_feilds[melliid]"> وجود فیلد
                                                @endisset

                                            </td>
                                            <td>
                                                @isset($Filds->melliid_req)
                                                    <input type="checkbox" checked class="form-input"
                                                        name="register_feilds[melliid_req]"> الزامی
                                                @else
                                                    <input type="checkbox" class="form-input"
                                                        name="register_feilds[melliid_req]"> الزامی
                                                @endisset

                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                جنسیت
                                            </td>
                                            <td>
                                                <input type="checkbox" class="form-input" name="register_feilds[sex]">
                                                وجود فیلد
                                            </td>
                                            <td>
                                                <input type="checkbox" class="form-input"
                                                    name="register_feilds[sex_req]"> الزامی
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                نقش
                                            </td>
                                            <td>
                                                <input type="checkbox" class="form-input" name="register_feilds[role]">
                                                وجود فیلد
                                            </td>
                                            <td>
                                                <input type="checkbox" class="form-input"
                                                    name="register_feilds[role_req]"> الزامی
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                تحصیلات
                                            </td>
                                            <td>
                                                <input type="checkbox" class="form-input" name="register_feilds[edu]">
                                                وجود فیلد
                                            </td>
                                            <td>
                                                <input type="checkbox" class="form-input"
                                                    name="register_feilds[edu_req]"> الزامی
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                شعبه
                                            </td>
                                            <td>
                                                <input type="checkbox" class="form-input" name="register_feilds[branch]">
                                                وجود فیلد
                                            </td>
                                            <td>
                                                <input type="checkbox" class="form-input"
                                                    name="register_feilds[branch_req]"> الزامی
                                            </td>
                                        </tr>
                                    </table>





                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent">
                            <div class="mc-footer">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <button type="submit" name="submit" value="register_feilds"
                                            class="btn  btn-primary m-1">{{ __('Submit') }}</button>
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

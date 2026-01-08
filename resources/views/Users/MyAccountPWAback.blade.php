@php
$Persian = new App\Functions\persian();
@endphp
@extends("Layouts.CustomerMainPage")
@section('page-header-left')
@endsection
@section('MainCountent')

    @include('Layouts.PWAProductModal')
    <div style="margin-left: 13px;" class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
        <div class="card-header gradient-purple-indigo 0-hidden pb-80">
            باشگاه مشتریان
        </div>
        <div class="card-body">
            <div style="width: 100%" class="progress">
                <div class="progress-bar" role="progressbar" style="width: {{ $PointPercent }}%;"
                    aria-valuenow="{{ $PointPercent }}" aria-valuemin="0" aria-valuemax="100">{{ $PointPercent }}%</div>
            </div>
        </div>
        <div class="card-footer">
            {{ \App\Http\Controllers\setting\SettingManagement::GetSettingValue('number_to_point_txt') }}
        </div>
    </div>

    <div onclick="showmyorders()" id="navigation" class="row">
        <div class="col-lg-3 col-md-5 col-sm-12">
            <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                <div class="card-body text-center">
                    <i class="i-Professor"></i>
                    <div class="content">
                        <p class="text-muted mt-2 mb-0">سفارشات</p>
                    </div>
                </div>
            </div>
        </div>

        <div onclick="show_address()" class="col-lg-3 col-md-5 col-sm-12">
            <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                <div class="card-body text-center">
                    <i class="i-Map-Marker"></i>
                    <div class="content">
                        <p class="text-muted mt-2 mb-0">آدرس ها</p>
                    </div>
                </div>
            </div>
        </div>

        <div onclick="show_account()" class="col-lg-3 col-md-5 col-sm-12">
            <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                <div class="card-body text-center">
                    <i class="i-Male-21"></i>
                    <div class="content">
                        <p class="text-muted mt-2 mb-0">حساب کاربری</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-5 col-sm-12">
            <a href="{{ route('logout') }}">
                <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                    <div class="card-body text-center">
                        <i style="color: red" class="i-Power-3"></i>
                        <div class="content">
                            <p class="text-muted mt-2 mb-0">خروج</p>
                        </div>
                    </div>
                </div>
            </a>

        </div>

    </div>
    <div class="nested" id="account-addresses">
        <div class="icon-box icon-box-side icon-box-light">
            <span class="icon-box-icon icon-map-marker">
                <i class="w-icon-map-marker"></i>
            </span>
            <div class="icon-box-content">
                <h4 class="icon-box-title mb-0 ls-normal">آدرسها </h4>
                <div style="position: relative;text-align: left;left: 0px;top: -30px;">
                    <i onclick="hide_address()" class="i-Arrow-Out-Right" style="font-size: 34px;"></i>
                </div>
            </div>
        </div>
        <p>آدرس های زیر به طور پیش فرض در صفحه پرداخت استفاده می شود.</p>
        <div class="row">
            @foreach ($Locations as $Location)
                <div style="margin-right: 0px; padding-left:0px; margin-bottom: 10px;"
                    class="card col-lg-3 col-md-5 col-sm-12">
                    <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                        {{ $Location->name }}</h4>
                    </div>
                    <div class="card-body">
                        <address>
                            <table class="address-table">
                                <tbody>
                                    <tr>
                                        <th>نام :</th>
                                        <td>{{ $Location->recivername }}</td>
                                    </tr>
                                    <tr>
                                        <th>استان:</th>
                                        <td>{{ $Location->Province }}</td>
                                    </tr>
                                    <tr>
                                        <th>شهر :</th>
                                        <td>{{ $Location->City }}</td>
                                    </tr>
                                    <tr>
                                        <th>خیابان:</th>
                                        <td>{{ $Location->Street }} </td>
                                    </tr>

                                    <tr>
                                        <th>آدرس:</th>
                                        <td>{{ $Location->OthersAddress }} </td>
                                    </tr>
                                    <tr>
                                        <th>پلاک :</th>
                                        <td>{{ $Location->Pelak }} </td>
                                    </tr>
                                    <tr>
                                        <th>تلفن:</th>
                                        <td>{{ $Location->reciverphone }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </address>
                        <a href="#" class="btn btn-danger btn-rounded">حذف آدرس </a>
                    </div>
                </div>
                <br>
            @endforeach
            <div style="position: relative;text-align: left;left: 0px;">
                <i onclick="hide_address()" class="i-Arrow-Out-Right" style="font-size: 34px;"></i>
            </div>
        </div>
    </div>

    <div class="card nested" id="account-details">
        <div class="card-header gradient-purple-indigo 0-hidden pb-80">
            <h4 class="icon-box-title mb-0 ls-normal">جزئیات حساب </h4>
            <i onclick="hide_account()" class="i-Arrow-Out-Right" style="font-size: 34px;"></i>
        </div>
        <div class="card-body">
            <form class="form account-details-form " id="personalinfo" method="post">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="firstname">نام کوچک *</label>
                            <input type="text" id="firstname" required name="firstname" value="{{ Auth::user()->Name }}"
                                class="form-control form-control-md">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="lastname">نام خانوادگی *</label>
                            <input type="text" id="lastname" required name="lastname" value="{{ Auth::user()->Family }}"
                                class="form-control form-control-md">
                        </div>
                    </div>
                </div>
                <h4 class="title title-password ls-25 font-weight-bold">تغییر رمز عبور </h4>
                <div class="form-group">
                    <label class="text-dark" for="new-password">گذرواژه جدید </label>
                    <input type="password" class="form-control form-control-md" id="new-password" name="new_password">
                </div>
                <div class="form-group mb-10">
                    <label class="text-dark" for="conf-password">تکرار گذرواژه </label>
                    <input type="password" class="form-control form-control-md" id="conf-password" name="conf_password">
                </div>
                <button type="submit" name="submit" value="ChangeUserinfo"
                    class="btn btn-dark btn-rounded btn-sm mb-4">ذخیره
                    تغییرات </button>
            </form>
        </div>
    </div>

    <div class="card nested" id="accountorders">
        <div class="card-header gradient-purple-indigo 0-hidden pb-80">
            <div class="icon-box-content">
                <h4 class="icon-box-title text-capitalize ls-normal mb-0">سفارشات </h4>
                <i onclick="hidemyorders()" class="i-Arrow-Out-Right" style="font-size: 34px;"></i>
            </div>
        </div>
        <div class="card-body">
            @if (sizeof($Orders) == 0)
                <p>تا کنون سفارشی ثبت نشده است!</p>
            @endif
            @foreach ($Orders as $Order)
                <div class="card">
                    <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                        <h6>
                            سفارش شماره: {{ $Order->id }}
                        </h6>
                    </div>
                    <div class="card-body">
                        <p>تاریخ سفارش: {{ $Persian->MyPersianDate($Order->created_at) }} </p>
                        <p>وضیعت سفارش: @if ($Order->status == 1)
                                در انتظار پردازش
                            @elseif($Order->status == 2)
                                در حال پردازش
                            @elseif($Order->status == 100)
                                تکمیل سفارش
                            @endif
                        </p>
                        <p>مبلغ:
                            {{ number_format($Order->total_sales / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                            {{ App\Http\Controllers\Credit\currency::GetCurrency() }}</p>
                        <p>تعداد: {{ $Order->num_items_sold }} قلم کالا</p>
                    </div>
                </div>
            @endforeach
        </div>

    </div>

    @include('Layouts.MainRouteCard')
@endsection

@section('page-js')
    <script>
        function show_address() {
            $("#navigation").addClass('nested');
            $("#account-addresses").removeClass('nested');
        }

        function hide_address() {
            $("#navigation").removeClass('nested');
            $("#account-addresses").addClass('nested');
        }

        function show_account() {
            $("#navigation").addClass('nested');
            $("#account-details").removeClass('nested');
        }

        function hide_account() {
            $("#navigation").removeClass('nested');
            $("#account-details").addClass('nested');
        }

        function showmyorders() {
            if (!$("#navigation").hasClass('nested')) {
                $("#navigation").addClass('nested');
                $("#accountorders").removeClass('nested');
            }

        }

        function hidemyorders() {
            $("#navigation").removeClass('nested');
            $("#accountorders").addClass('nested');
        }
    </script>
@endsection

@section('bottom-js')
@endsection

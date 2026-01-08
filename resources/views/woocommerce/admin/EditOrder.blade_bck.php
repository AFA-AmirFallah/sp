@php
    $Persian = new App\Functions\persian();
@endphp
@extends('Layouts.MainPage')
@section('page-header-left')
@endsection
@section('MainCountent')
    <style>
        .table-responsive-overflow {

            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            -ms-overflow-style: -ms-autohiding-scrollbar;
        }
    </style>
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-lg-6">
                    <input class="nested" type="text" id="change-color" value="{{ $ProductOrder->status }}">

                    <div class="page-header-left">
                        <h3>ویرایش
                            <small> سفارش شماره: {{ $ProductOrder->id }}</small>
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class=" card col-lg-12 row" style="padding: 0px; margin-bottom: 20px;">
        <form method="post">
            @csrf
            <div class="card-header gradient-purple-indigo 0-hidden pb-80">وضعیت سفارش</div>
            <div class="card-body" style="display: flex ;justify-content: space-between; ">

                @if ($ProductOrder->status == 0)
                    <button type="submit" name="submit" value="Delete" class="btn btn-danger">حذف سفارش</button>
                @else
                    <div>
                        <button class="btn btn-secondary" id="button-color" type="submit" name="changestate"
                            value="1">پرداخت
                            شده</button>
                        <button class="btn btn-secondary" id="button-color1" type="submit" name="changestate"
                            value="10">در
                            دست
                            اقدام </button>
                        <button class="btn btn-secondary" id="button-color2" type="submit" name="changestate"
                            value="20">
                            ارسال به
                            انبار</button>
                        <button class="btn btn-secondary" id="button-color3" type="submit" name="changestate"
                            value="30">درحال بسته
                            بندی</button>
                        <button class="btn btn-secondary" id="button-color4" type="submit" name="changestate"
                            value="40">
                            در حال ارسال
                        </button>
                        @if (\App\myappenv::MainOwner != 'kookbaz')
                            <button class="btn btn-secondary" id="button-color5" type="button" onclick="TapinGetPrice()">
                                استعلام
                                هزینه
                                ارسال</button>
                            @if ($ProductOrder->status == 50)
                                <button id="button-color6" class="btn btn-secondary" type="submit" name="delever"
                                    value="{{ \App\Http\Controllers\woocommerce\product::GetPostDleverID($ProductOrder->status_history) }}">
                                    ارسال به تاپین</button>
                            @else
                                <button id="button-color7"class="btn btn-secondary" type="submit" name="delever"
                                    value="tapin"> ثبت در
                                    تاپین</button>
                            @endif
                        @endif
                        <button class="btn btn-secondary " id="button-color8" type="submit" name="changestate"
                            value="70">
                            تحویل سفارش
                        </button>

                        <div class="alert alert-success nested" id="button-color11" name="changestate" value="70">

                            <b> در انتظار تایید مالی </b>

                        </div>

                        <button class="btn btn-secondary nested" id="button-color12" type="submit" name="changestate"
                            value="80">
                            ثبت صورتحساب
                        </button>
                        <input type="text" name="UserName" value="{{ $Customer->UserName }}" class="nested">
                        <input type="text" name="MobileNo" value="{{ $Customer->MobileNo }}" class="nested">
                        <button class="btn btn-secondary nested" id="button-color13" type="submit" name="changestate"
                            value="90">
                            اتمام سفارش و ارسال پیامک نظرسنجی </button>
                        @if (Auth::user()->Role == \App\myappenv::role_SuperAdmin || Auth::user()->Role == \App\myappenv::role_ShopAdmin)
                            <button style="color: red;border-color: red;background: white;" id="CancelOrder" type="submit"
                                name="submit" value="CancelOrder" class="btn ">
                                لغو سفارش</button>
                        @endif
                        <div class="alert alert-success nested" id="button-color10" name="changestate" value="100">

                            <b> اتمام سفارش</b>

                        </div>
                        <div class="alert alert-danger nested" id="button-color9" name="changestate" value="60">

                            <b> لغو سفارش</b>

                        </div>







                    </div>
                @endif
        </form>
        <div>
            @if ($UserType == 'SuperAdmin')
                @if (\App\myappenv::TopenShopID != null)
                    <div class="alert alert-success" role="alert">

                        @if ($TopinCredit != null)
                            <li> <b>اعتبار تاپین :</b>
                                {{ number_format($TopinCredit->entries->credit) }} ریال </li>
                        @else
                            <li> اعتبار تاپین 0 ریال</li>
                        @endif

                    </div>
                @endif
            @endif
        </div>


    </div>
    </div>
    @if (Auth::user()->Role == \App\myappenv::role_SuperAdmin || Auth::user()->Role == \App\myappenv::role_ShopAdmin)
        <div class="col-lg-12 row">
            <div class="card col-lg-3" style=" margin: 0px 20px 20px 40px;
            padding: 0px">
                <div>
                    <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                        مسئول سفارش


                    </div>


                    <div class="card-body">
                        @if (Auth::user()->Role == \App\myappenv::role_SuperAdmin)
                            <div class="form-group ">

                                <div id="ownerselector">
                                    @include('Layouts.SearchUserInput', [
                                        'InputName' => 'UserName',
                                        'InputPalceholder' => __('Target username'),
                                    ])
                                    <button onclick="loadoperator()" type="button" class="btn btn-success mt-3">انتخاب
                                        مسئول</button>
                                </div>
                                @php
                                    if (isset($ProductOrder->Operator)) {
                                        $Owner = $ProductOrder->Operator;
                                    } else {
                                        $Owner = null;
                                    }

                                @endphp

                                <input id="ownerusername" class="nested" type="text" value="{{ $Owner }}"
                                    class="">
                                <div id="ownerdisplay" class="input-group col-xl-8 col-md-7">
                                    <div id="name_of_target_user" class="tag">
                                        <div id="nametarget"></div> <input type="hidden" name="tag[]"
                                            value="preexisting-tag"><a role="button"
                                            onclick="changestatetosearcharialoacl()" class="tag-i">×</a>
                                    </div>
                                </div>

                            </div>
                        @endif
                        <div style="display: flex;justify-content: space-between;">
                            <p>زمان سفارش:{{ $Persian->MyPersianDate($ProductOrder->created_at, false) }} </p>
                            <p>زمان آخرین تغییر: {{ $Persian->MyPersianDate($ProductOrder->updated_at, false) }}</p>
                        </div>
                        <div>

                            @if (isset($Operator))
                                <button class="btn btn-danger btn-block m-1 mb-3">
                                    {{ $Operator }}
                                </button>
                            @else
                                <button class="btn btn-danger btn-block m-1 mb-3">
                                    مسئولی تعریف نشده است
                                </button>
                                <p>


                                </p>
                            @endif


                        </div>

                    </div>

                </div>

            </div>

            <div class="card col-lg-8 mb-3 p-0">
                <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                    صورتحساب
                </div>
                <div class="card-body">
                    <input type="text" name="UserName" value="{{ $Customer->UserName }}" class="nested">

                    <a target="_blank" class="btn btn-primary ripple m-1"
                        href="{{ route('Invoice', ['Invoice' => $ProductOrder->id . '?type=p']) }}" title="صورت حساب">
                        چاپ
                        فاکتور</a>
                    <a target="_blank" class="btn btn-warning m-1"
                        href="{{ route('Kasrazhoghogh', ['Kasrazhoghogh' => $ProductOrder->id . '?case=K']) }}"
                        title="صدور کسر از حقوق">
                        صدور کسر از حقوق</a>

                    <button id="addobject" data-toggle="modal" data-target=".bd-example-modal-lg2" type="button"
                        class="btn btn-success m-1">ارسال پیامک به مشتری</button>

                    <a href="tel:{{ $Customer->MobileNo }}" type="button" class="btn btn-info m-1">تماس با
                        مشتری</a>


                    <a target="_blank" type="button" class="btn btn-dark m-1"
                        href="{{ route('PostReceipt', ['PostReceipt' => $ProductOrder->id . '?Receipt']) }}"
                        title=" رسید پستی ">
                        رسید پستی</a>

                    <button class="btn  btn-danger" type="submit" name="submit" value="SendPoint">
                        ارسال پیامک نظرسنجی

                    </button>

                </div>


                <form method="post">
                    @csrf
                    <input type="text" name="UserName" value="{{ $Customer->UserName }}" class="nested">
                    <!-- begin::modal -->
                    <div class="ul-card-list__modal">
                        <div class="modal fade bd-example-modal-lg2" tabindex="-1" role="dialog"
                            style="margin-right: 20%" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        ارسال پیامک به مشتری
                                    </div>
                                    <div class="modal-body">
                                        <form method="post">
                                            @csrf
                                            <div class="project-status">

                                                <div style="text-align: right">
                                                    <textarea name="MessageText" placeholder="{{ __('Enter your SMS text!!') }}" cols="100" rows="10"></textarea>
                                                    <div>
                                                        <button type="submit" class="btn btn-warning"
                                                            style="margin:auto;display:block" name="submit"
                                                            value="SendSms">
                                                            {{ __('send') }}
                                                        </button>
                                                    </div>
                                                </div>


                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>




            </div>




        </div>
    @endif




    <form method="post">
        @csrf
        <div class="col-lg-12 row">

            <div class="card col-lg-3" style=" margin: 0px 20px 20px 40px;
            padding: 0px">
                <div>
                    <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                        مشخصات مشتری <button type="button" onclick="UserInfo_edit_endable_func()"
                            id="UserInfo_edit_endable" class="btn btn-danger"> ویرایش</button> <button type="button"
                            onclick="UserInfo_edit_disable_func()" id="UserInfo_edit_disadable"
                            class="btn btn-success nested">
                            انصراف</button>


                    </div>
                    <input type="text" name="UserName" value="{{ $Customer->UserName }}" class="nested">
                    <div id="UserInfoEdit" class="card-body nested">
                        <table class="{{ \App\myappenv::MainTableClass }}">
                            <tr>
                                <td>نام</td>

                                <td><input id="Totall_first_name" type="text" class="form-control" name="Name"
                                        value="{{ $Customer->Name }}"></td>
                                <td><button type="submit" class=" btn btn-danger" name="UserInfo" value="Name"> ثبت
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>فامیل</td>
                                <td><input id="Totall_last_name" type="text" class="form-control" name="Family"
                                        value="{{ $Customer->Family }}">
                                </td>
                                <td><button type="submit" class=" btn btn-danger" name="UserInfo" value="Family"> ثبت
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>موبایل</td>
                                <td><input type="text" id="Totall_mobile" class="form-control" name="MobileNo"
                                        value="{{ $Customer->MobileNo }}">
                                </td>
                                <td><button type="submit" class=" btn btn-danger" name="UserInfo" value="MobileNo"> ثبت
                                    </button></td>
                            </tr>
                            <tr>
                                <td>امتیاز</td>
                                <td>{{ $UserPoint }}</td>

                            </tr>

                        </table>
                    </div>
                    <div id="UserInfoView" class="card-body">
                        <table class="{{ \App\myappenv::MainTableClass }}">
                            <tr>
                                <td>نام</td>
                                <td>{{ $Customer->Name }}</td>

                            </tr>
                            <tr>
                                <td>فامیل</td>
                                <td>{{ $Customer->Family }}</td>

                            </tr>
                            <tr>
                                <td>موبایل</td>
                                <td>{{ $Customer->MobileNo }}</td>

                            </tr>
                            <tr>
                                <td>امتیاز</td>
                                <td>{{ $UserPoint }}</td>

                            </tr>
                        </table>

                    </div>

                </div>

            </div>
            <div class="card col-lg-8" style="    padding: 0px;margin-bottom: 20px;">
                <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                    مشخصات سفارش
                </div>
                <div class="card-body">
                    <table class="{{ \App\myappenv::MainTableClass }}">
                        <tr>
                            <td>شماره سفارش</td>
                            <td>{{ $ProductOrder->id }}</td>
                        </tr>
                        <tr>
                            <td>مبلغ کل سفارش</td>
                            <td>{{ number_format($ProductOrder->total_sales + $ProductOrder->tax_total) }}</td>
                            <input type="text" id="Totall_price" name="Totall_price"
                                value="{{ $ProductOrder->total_sales }}" class="nested">
                        </tr>
                        <tr>
                            <td>هزینه ارسال </td>
                            <td>{{ number_format($ProductOrder->shipping_total) }}</td>
                        </tr>
                        <tr>
                            <td> مالیات بر ارزش افزوده </td>
                            <td>{{ number_format($ProductOrder->tax_total) }}</td>
                        </tr>
                        <tr>
                            <td> سود </td>
                            <td>{{ number_format($ProductOrder->net_total) }}</td>
                        </tr>
                        <tr>
                            <td>وضعیت

                            </td>

                            <td>

                                @if ($Offlinecheck == 0 || $Offlinecheck == 4)
                                    @if ($ProductOrder->status == 0)
                                        <p class="red text-white"> در انتظار پرداخت</p>
                                    @elseif ($ProductOrder->status == 1)
                                        پرداخت شده
                                    @elseif($ProductOrder->status == 10)
                                        در دست اقدام
                                    @elseif($ProductOrder->status == 20)
                                        ارسال به انبار
                                    @elseif($ProductOrder->status == 30)
                                        درحال بسته بندی
                                    @elseif($ProductOrder->status == 40)
                                        ارسال به پست
                                    @elseif($ProductOrder->status == 50)
                                        ثبت شده در تاپین <br>
                                        بارکد پستی:
                                        {{ \App\Http\Controllers\woocommerce\product::GetPostDleverBarcode($ProductOrder->status_history) }}
                                    @elseif($ProductOrder->status == 51)
                                        ارسال شده به تاپین <br>
                                        بارکد پستی:
                                        {{ \App\Http\Controllers\woocommerce\product::GetPostDleverBarcode($ProductOrder->status_history) }}
                                    @elseif($ProductOrder->status == 60)
                                        لغو سفارش
                                    @elseif($ProductOrder->status == 70)
                                        تحویل سفارش و در انتظار تایید مالی
                                    @elseif($ProductOrder->status == 80)
                                        ثبت صورتحساب
                                    @elseif($ProductOrder->status = 100)
                                        اتمام سفارش
                                    @endif
                                    @if ($Offlinecheck == 4)
                                        *فعال شده از طریق صورت حساب*
                                    @endif
                                @else
                                    @switch($Offlinecheck)
                                        @case(1)
                                            صورت حساب صادر نشده
                                        @break

                                        @case(2)
                                            صورت حساب در انتظار پرداخت
                                        @break

                                        @case(3)
                                            پرداخت بیعانه صورت حساب
                                        @break

                                        @default
                                    @endswitch
                                @endif

                            </td>
                        </tr>
                        <tr>
                            <td>وزن کل گرم</td>
                            <td style="display: flex";>
                                <input id="Totall_weight" class="form-control col-md-3
                                "
                                    type="text" name="Totallweight" value="{{ $ProductOrder->weight }}">
                                @if ($ProductOrder->status != 0)
                                    <button class="btn btn-danger" type="submit" name="changeweight" value="1"
                                        style="
                                    margin-right: 20px;">ثبت
                                        وزن
                                        مرسوله</button>
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <td>امتیاز </td>
                            <td>{{ $Point }}
                                @if ($ProductOrder->status != 0)
                                    @if ($CurentPoint == null)
                                        <button class="btn btn-success" type="submit" name="AddPoint"
                                            value="{{ $Point }}">ثبت
                                            امتیاز</button>
                                    @else
                                        <button class="btn btn-danger" type="submit" name="DellPoint"
                                            value="{{ $CurentPoint->id }}">حذف امتیاز</button>
                                    @endif
                                @endif
                            </td>
                        </tr>
                    </table>
                    <div id="Estelam" class="nested alert alert-success" role="alert">
                        <h4>استعلام قیمت ارسال</h4>
                        @if ($TopinCredit != null)
                            <p id="GetDeleverPrice">{{ number_format($TopinCredit->entries->credit) }} ریال</p>
                        @else
                            <p id="GetDeleverPrice">0 ریال</p>
                        @endif
                    </div>


                </div>

            </div>
            <div class="card col-lg-3" style="margin: 0px 20px 20px 40px;
            padding: 0px;">
                <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                    محل تحویل <button type="button" onclick="address_edit_endable_func()" id="address_edit_endable"
                        class="btn btn-danger"> ویرایش</button> <button type="button"
                        onclick="address_edit_disable_func()" id="address_edit_disadable" class="btn btn-success nested">
                        انصراف</button>
                </div>
                @if (isset($locations->id))
                    <input type="text" name="locationid" value="{{ $locations->id }}" class="nested">

                    <div id="Address_Edit" class="card-body nested">
                        <table class="{{ \App\myappenv::MainTableClass }}">
                            <tr>
                                <td> نام گیرنده</td>
                                @if ($locations->recivername != '')
                                    <td><input type="text" class="form-control" name="recivername"
                                            value="{{ $locations->recivername }}"></td>
                                @else
                                    <td><input type="text" class="form-control" name="recivername"
                                            value="{{ $Customer->Name }} {{ $Customer->Family }}"></td>
                                @endif
                                <td><button type="submit" class=" btn btn-danger" name="location"
                                        value="recivername">ثبت
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>تلفن</td>
                                <td><input type="text" class="form-control" name="reciverphone"
                                        value="{{ $locations->reciverphone }}"></td>
                                <td><button type="submit" class=" btn btn-danger" name="location" value="reciverphone">
                                        ثبت
                                    </button></td>
                            </tr>
                            <tr>
                                <td>استان</td>
                                <input id="Totall_province_code" name="Totall_province_code" type="text"
                                    class="nested" value="{{ $locations->ProvinceID }}">
                                <td>{{ $locations->Province }}</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>شهر</td>
                                <input id="Totall_city_code" name="Totall_city_code" type="text" class="nested"
                                    value="{{ $locations->CityID }}">
                                <td>{{ $locations->City }}</td>
                                <td></td>
                            </tr>
                            <input id="Totall_address" name="Totall_address" type="text" class="nested"
                                value="{{ $locations->Street }} {{ $locations->OthersAddress }}">
                            <tr>
                                <td>خیابان</td>

                                <td>
                                    <input type="text" class="form-control" name="Street"
                                        value="{{ $locations->OthersAddress }}">
                                </td>
                                <td><button type="submit" class=" btn btn-danger" name="location" value="Street"> ثبت
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>کوچه</td>
                                <td><input type="text" class="form-control" name="Street"
                                        value="{{ $locations->Street }}"></td>
                                <td><button type="submit" class=" btn btn-danger" name="location" value="Street">
                                        ثبت
                                    </button></td>
                            </tr>
                            <tr>
                                <td>پلاک</td>
                                <td><input type="text" class="form-control" name="Pelak"
                                        value="{{ $locations->Pelak }}">
                                </td>
                                <td><button type="submit" class=" btn btn-danger" name="location" value="Pelak"> ثبت
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>کد پستی</td>
                                <td><input type="text" id="Totall_postal_code" class="form-control" name="PostalCode"
                                        value="{{ $locations->PostalCode }}"></td>
                                <td><button type="submit" class=" btn btn-danger" name="location" value="PostalCode">
                                        ثبت
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>توضیحات</td>
                                <td><input type="text" class="form-control" name="ExtraNote"
                                        value="{{ $locations->ExtraNote }}"></td>
                                <td><button type="submit" class=" btn btn-danger" name="location" value="ExtraNote">
                                        ثبت
                                    </button>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div id="Address_View" class="card-body">
                        <table class="{{ \App\myappenv::MainTableClass }}">
                            <tr>
                                <td> نام گیرنده</td>
                                <td>{{ $locations->recivername }}</td>

                            </tr>
                            <tr>
                                <td>تلفن</td>
                                <td>{{ $locations->reciverphone }}</td>

                            </tr>
                            <tr>
                                <td>استان</td>
                                <td>{{ $locations->Province }}</td>

                            </tr>
                            <tr>
                                <td>شهر</td>
                                <td>{{ $locations->City }}</td>
                            </tr>
                            <input id="Totall_address" name="Totall_address" type="text" class="nested"
                                value="{{ $locations->Street }} {{ $locations->OthersAddress }}">
                            <tr>
                                <td>خیابان</td>
                                <td>{{ $locations->OthersAddress }}</td>

                            </tr>
                            <tr>
                                <td>کوچه</td>
                                <td>{{ $locations->Street }}</td>

                            </tr>
                            <tr>
                                <td>پلاک</td>
                                <td>{{ $locations->Pelak }}</td>

                            </tr>
                            <tr>
                                <td>کد پستی</td>
                                <td>{{ $locations->PostalCode }}</td>

                            </tr>
                            <tr>
                                <td>توضیحات</td>
                                <td>{{ $locations->ExtraNote }}</td>

                            </tr>
                        </table>
                    </div>
                @else
                    <div class="card-body">
                        <table class="{{ \App\myappenv::MainTableClass }}">
                            <tr>
                                <td>
                                    فروش حضوری
                                </td>
                            </tr>
                        </table>
                    </div>
                @endif

            </div>

            @if ($Offlinecheck == 0 || $Offlinecheck == 4)
                <div class="card col-lg-8" style="padding: 0px;
                margin-bottom: 20px;">
                    <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                        اقلام خریداری شده
                    </div>
                    <div class="card-body">
                        <table class="{{ \App\myappenv::MainTableClass }}">
                            <thead class="text-center">
                                <tr>
                                    <th>
                                        تصویر
                                    </th>
                                    <th>
                                        نام کالا
                                    </th>
                                    <th>
                                        تعداد
                                    </th>
                                    <th>
                                        وزن
                                    </th>
                                    <th>
                                        مبلغ واحد
                                    </th>
                                    <th>
                                        مبلغ فروش
                                    </th>
                                    <th>
                                        مبلغ خرید
                                    </th>
                                    <th>
                                        سود واحد
                                    </th>
                                    <th>
                                        سود کل
                                    </th>

                                    <th>
                                        مبلغ کل
                                    </th>
                                    <th>
                                        نوع پرداخت
                                    </th>
                                    @if (\App\myappenv::Lic['marketplace'])
                                        <th>
                                            تامین کننده
                                        </th>
                                    @endif

                                </tr>

                            </thead>
                            <tbody>
                                @foreach ($ProductOrderItem as $ProductOrderItemTarget)
                                    <tr>
                                        <td>
                                            <a
                                                href="{{ App\Functions\Images::GetPicture($ProductOrderItemTarget->ImgURL, 1) }}">
                                                <img style="height: 120px;"
                                                    src="{{ App\Functions\Images::GetPicture($ProductOrderItemTarget->ImgURL, 1) }}"
                                                    alt="">
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{ route('EditProduct', ['id' => $ProductOrderItemTarget->product_id]) }}"
                                                target="_blank">
                                                {{ $ProductOrderItemTarget->NameFa }}
                                            </a>
                                            <br>
                                            SKU: {{ $ProductOrderItemTarget->SKU }}

                                        </td>
                                        <td>
                                            {{ $ProductOrderItemTarget->product_qty }}
                                        </td>
                                        <td>
                                            <input type="text" class="form-control"
                                                name="weight[{{ $ProductOrderItemTarget->id }}]"
                                                value="{{ $ProductOrderItemTarget->weight }}" size="3">
                                        </td>
                                        <td>
                                            {{ number_format($ProductOrderItemTarget->unit_Price) }}
                                        </td>
                                        <td>

                                            {{ number_format($ProductOrderItemTarget->unit_sales) }}
                                        </td>
                                        <td>
                                            {{ number_format($ProductOrderItemTarget->unit_sales - $ProductOrderItemTarget->net_total / $ProductOrderItemTarget->product_qty) }}
                                        </td>
                                        <td>
                                            {{ number_format($ProductOrderItemTarget->net_total / $ProductOrderItemTarget->product_qty) }}
                                        </td>
                                        <td>

                                            {{ number_format($ProductOrderItemTarget->net_total) }}
                                        </td>
                                        <td>
                                            {{ number_format($ProductOrderItemTarget->total_sales) }}
                                        </td>
                                        <td>


                                            @if ($ProductOrderItemTarget->Tashim == null)
                                                خرید نقدی
                                            @else
                                                {{ $ProductOrderItemTarget->Name }}
                                            @endif


                                        </td>
                                        @if (\App\myappenv::Lic['marketplace'])
                                            <td>
                                                {{ $ProductOrderItemTarget->wname }}
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @if ($ProductOrder->status != 0)
                            <div style="text-align: center" class="row">
                                <button type="submit" class="btn btn-primary" name="updatewiget" value="1">بروز
                                    رسانی
                                    وزن</button>
                            </div>
                        @endif
                    </div>

                </div>
            @else
                @if (Auth::user()->Role == \App\myappenv::role_ShopOwner)
                    <div style="height: 800px;" class="card col-lg-8">
                        <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                            صورت حساب هوشمند
                        </div>
                        <div class="card-body">
                            <table class="{{ \App\myappenv::MainTableClass }}">
                                <thead class="text-center">
                                    <tr>
                                        <th>
                                            تصویر
                                        </th>
                                        <th>
                                            نام کالا
                                        </th>
                                        <th>
                                            تعداد
                                        </th>
                                        <th>
                                            وزن
                                        </th>
                                        <th>
                                            مبلغ پایه
                                        </th>
                                        <th>
                                            مبلغ فروش
                                        </th>
                                        <th>
                                            مبلغ کل
                                        </th>
                                        <th>
                                            نوع پرداخت
                                        </th>
                                        <th>
                                            تامین کننده
                                        </th>

                                    </tr>

                                </thead>
                                <tbody>
                                    @foreach ($ProductOrderItem as $ProductOrderItemTarget)
                                        <tr>
                                            <td>
                                                <a
                                                    href="{{ App\Functions\Images::GetPicture($ProductOrderItemTarget->ImgURL, 1) }}">
                                                    <img style="height: 120px;"
                                                        src="{{ App\Functions\Images::GetPicture($ProductOrderItemTarget->ImgURL, 1) }}"
                                                        alt="">
                                                </a>
                                            </td>
                                            <td>
                                                <a href="{{ route('EditProduct', ['id' => $ProductOrderItemTarget->product_id]) }}"
                                                    target="_blank">
                                                    {{ $ProductOrderItemTarget->NameFa }}
                                                </a>

                                            </td>
                                            <td>
                                                {{ $ProductOrderItemTarget->product_qty }}
                                            </td>
                                            <td>
                                                <input type="text" class="form-control"
                                                    name="weight[{{ $ProductOrderItemTarget->id }}]"
                                                    value="{{ $ProductOrderItemTarget->weight }}" size="3">
                                            </td>
                                            <td>
                                                {{ number_format($ProductOrderItemTarget->unit_Price) }}
                                            </td>
                                            <td>

                                                {{ number_format($ProductOrderItemTarget->unit_sales) }}
                                            </td>
                                            <td>
                                                {{ number_format($ProductOrderItemTarget->total_sales) }}
                                            </td>
                                            <td>


                                                @if ($ProductOrderItemTarget->Tashim == null)
                                                    خرید نقدی
                                                @else
                                                    {{ $ProductOrderItemTarget->Name }}
                                                @endif


                                            </td>
                                            <td>
                                                {{ $ProductOrderItemTarget->wname }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                @else
                    <div style="height: 800px;" class="card col-lg-8">
                        <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                            صورت حساب هوشمند
                        </div>
                        <div class="card-body">
                            <iframe style="width: 100%;height: 100%;"
                                src="{{ route('EditeSmartInvoice', ['InvoiceID' => $ProductOrder->DeviceContract . '?if=true']) }}"
                                frameborder="0"></iframe>
                        </div>

                    </div>
                @endif
            @endif
            <div class="card col-lg-3" style=" margin: 0px 20px 20px 40px;
            padding: 0px">
                <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                    تاریخچه چرخش کار
                </div>
                <div class="card-body">
                    @if ($ProductOrder->status_history != null)
                        @foreach (json_decode($ProductOrder->status_history) as $status_history)
                            @isset($status_history->Date)
                                <div>
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M8.00063 14.6709C11.6766 14.6702 14.6673 11.6796 14.6673 8.00356C14.6673 4.32756 11.6766 1.3369 7.99996 1.3369C4.32463 1.3369 1.33396 4.32757 1.3333 8.00357C1.3333 11.6796 4.32396 14.6702 8.00063 14.6709ZM7.99995 2.67025C10.9413 2.67025 13.334 5.06292 13.334 8.00359C13.334 10.9443 10.9413 13.3369 8.00062 13.3376C5.05929 13.3369 2.66662 10.9443 2.66662 8.00359C2.66729 5.06292 5.05995 2.67025 7.99995 2.67025Z"
                                            fill="#495057" />
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M7.99996 8.67085L10.6666 8.67085L10.6666 7.33752L7.99996 7.33752L7.99996 5.33352L5.32996 8.00352L7.99996 10.6729L7.99996 8.67085Z"
                                            fill="#495057" />
                                    </svg>
                                    <span> {{ $Persian->MyPersianDate($status_history->Date, true) }} :
                                        <strong>{{ $status_history->Userupdate }}</strong> </span>


                                </div>

                                وضعیت

                                به
                                @if ($status_history->status == 0)
                                    <p class="red text-white"> در انتظار پرداخت</p>
                                @elseif ($status_history->status == 1)
                                    <strong> پرداخت شده</strong>
                                @elseif($status_history->status == 10)
                                    <strong> در دست اقدام</strong>
                                @elseif($status_history->status == 20)
                                    <strong>ارسال به انبار</strong>
                                @elseif($status_history->status == 30)
                                    <strong>درحال بسته بندی</strong>
                                @elseif($status_history->status == 40)
                                    <strong>ارسال به پست</strong>
                                @elseif($status_history->status == 60)
                                    انصراف مشتری
                                @elseif($status_history->status == 70)
                                    تحویل سفارش
                                @elseif($status_history->status == 80)
                                    ثبت صورتحساب
                                @elseif($status_history->status == 90)
                                    اتمام سفارش
                                @endif
                                تغییر کرد
                            @endisset
                        @endforeach
                    @endif
                    @if ($ProductOrder->extra != null)
                        @foreach (json_decode($ProductOrder->extra) as $extranote)
                            <div>

                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M8.00063 14.6709C11.6766 14.6702 14.6673 11.6796 14.6673 8.00356C14.6673 4.32756 11.6766 1.3369 7.99996 1.3369C4.32463 1.3369 1.33396 4.32757 1.3333 8.00357C1.3333 11.6796 4.32396 14.6702 8.00063 14.6709ZM7.99995 2.67025C10.9413 2.67025 13.334 5.06292 13.334 8.00359C13.334 10.9443 10.9413 13.3369 8.00062 13.3376C5.05929 13.3369 2.66662 10.9443 2.66662 8.00359C2.66729 5.06292 5.05995 2.67025 7.99995 2.67025Z"
                                        fill="#495057" />
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M7.99996 8.67085L10.6666 8.67085L10.6666 7.33752L7.99996 7.33752L7.99996 5.33352L5.32996 8.00352L7.99996 10.6729L7.99996 8.67085Z"
                                        fill="#495057" />
                                </svg>

                                <span> {{ $Persian->MyPersianDate($extranote->Date, true) }}
                                    @if (isset($extranote->UserREport))
                                        :<strong>{{ $extranote->UserREport }}</strong>
                                </span>
                            @elseif (isset($extranote->UserDeliverReport))
                                :<strong>{{ $extranote->UserDeliverReport }}</strong> </span>
                        @endif
                        <p> {{ $extranote->note }}</p>

                </div>
                @endforeach
                @endif
            </div>

        </div>
        <div class="card col-lg-8" style="padding:0px;">
            <form action="post">
                <div class="card-header gradient-purple-indigo 0-hidden pb-80">گزارش کار سفارش </div>

                <div class="card-body">

                    <textarea class="form-control" type="text" id="" cols="80" rows="10" name="Report"></textarea>
                    <button class="btn btn-danger" type="submit" name="submit" value="savereport">ثبت
                        گزارش</button>

                </div>
            </form>
        </div>
        </div>

        <div class="card-body">


        </div>
    </form>
    <!-- Container-fluid Ends-->
    @include('Layouts.SearchUserInput_Js')
    @include('Layouts.SearchMultiUserInput_Js')
@endsection
@section('page-js')
    <script>
        $(document).ready(function() {
            $color = $('#change-color').val();
            $bottoncolor = $('#button-color').val();


            if ($color == $bottoncolor) {
                $('#button-color').addClass('btn-success').removeClass('btn-secondary');

            } else if ($color == $('#button-color1').val()) {
                $('#button-color1').addClass('btn-success').removeClass('btn-secondary');

            } else if ($color == $('#button-color2').val()) {
                $('#button-color2').addClass('btn-success').removeClass('btn-secondary');

            } else if ($color == $('#button-color3').val()) {
                $('#button-color3').addClass('btn-success').removeClass('btn-secondary');

            } else if ($color == $('#button-color4').val()) {
                $('#button-color4').addClass('btn-success').removeClass('btn-secondary');

            } else if ($color == $('#button-color5').val()) {
                $('#button-color5').addClass('btn-success').removeClass('btn-secondary');

            } else if ($color == $('#button-color9').attr('value')) {

                $('#button-color9').removeClass('nested');
                $('#button-color').addClass('nested');
                $('#button-color1').addClass('nested');
                $('#button-color2').addClass('nested');
                $('#button-color3').addClass('nested');
                $('#button-color4').addClass('nested');
                $('#button-color5').addClass('nested');
                $('#button-color7').addClass('nested');
                $('#button-color8').addClass('nested');
                $('#CancelOrder').addClass('nested');


            } else if ($color == $('#button-color8').val()) {
                $('#button-color11').addClass('btn-success').removeClass('btn-secondary');
                $('#button-color11').removeClass('nested');
                $('#button-color12').removeClass('nested');
                $('#button-color').addClass('nested');
                $('#button-color1').addClass('nested');
                $('#button-color2').addClass('nested');
                $('#button-color3').addClass('nested');
                $('#button-color4').addClass('nested');
                $('#button-color5').addClass('nested');
                $('#button-color6').addClass('nested');
                $('#button-color7').addClass('nested');
                $('#button-color8').addClass('nested');

            } else if ($color == $('#button-color11').attr('value')) {
                $('#button-color10').removeClass('nested');

                $('#button-color').addClass('nested');
                $('#button-color1').addClass('nested');
                $('#button-color2').addClass('nested');
                $('#button-color3').addClass('nested');
                $('#button-color4').addClass('nested');
                $('#button-color5').addClass('nested');
                $('#button-color6').addClass('nested');
                $('#button-color7').addClass('nested');
                $('#button-color8').addClass('nested');


            } else if ($color == $('#button-color12').attr('value')) {
                $('#button-color12').addClass('btn-success').removeClass('btn-secondary');
                $('#button-color13').removeClass('nested');
                $('#button-color').addClass('nested');
                $('#button-color1').addClass('nested');
                $('#button-color2').addClass('nested');
                $('#button-color3').addClass('nested');
                $('#button-color4').addClass('nested');
                $('#button-color5').addClass('nested');
                $('#button-color6').addClass('nested');
                $('#button-color7').addClass('nested');
                $('#button-color8').addClass('nested');
                $('#CancelOrder').addClass('nested');
                $('#button-color10').addClass('nested');

            } else if ($color == $('#button-color13').attr('value')) {
                $('#button-color10').addClass('btn-success').removeClass('btn-secondary');
                $('#button-color10').removeClass('nested');
                $('#button-color').addClass('nested');
                $('#button-color1').addClass('nested');
                $('#button-color2').addClass('nested');
                $('#button-color3').addClass('nested');
                $('#button-color4').addClass('nested');
                $('#button-color5').addClass('nested');
                $('#button-color6').addClass('nested');
                $('#button-color7').addClass('nested');
                $('#button-color8').addClass('nested');
                $('#button-color11').addClass('nested');
                $('#button-color12').addClass('nested');
                $('#button-color13').addClass('nested');
                $('#CancelOrder').addClass('nested');

            }
            $OwnerID = $('#ownerusername').val();
            if ($OwnerID == null || $OwnerID == '') {

            } else {
                //setowner
                $('#ownerselector').addClass('nested');
                $('#ownerdisplay').removeClass('nested');

                $('#nametarget').html('...');

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.post('', {
                        ajax: true,
                        getownerinfo: $OwnerID,

                    },
                    function(data, status) {
                        $('#nametarget').html(data);

                    });

            }

        });

        function loadoperator() {
            $UserName = $('#user_search_responser_text').val();
            if ($UserName == '') {
                alert('نام کاربری وارد نشده است!');
            }
            window.UserName = $UserName;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('', {
                    ajax: true,
                    procedure: 'defineoperator',
                    UserName: $UserName,

                },
                function(data, status) {

                    $('#ownerselector').addClass('nested');
                    $('#ownerdisplay').removeClass('nested');

                    $('#nametarget').html(data);




                });

        }




        function address_edit_endable_func() {
            $('#address_edit_endable').addClass('nested');
            $('#Address_View').addClass('nested');
            $('#address_edit_disadable').removeClass('nested');
            $('#Address_Edit').removeClass('nested');

        }

        function address_edit_disable_func() {
            $('#address_edit_endable').removeClass('nested');
            $('#Address_View').removeClass('nested');
            $('#address_edit_disadable').addClass('nested');
            $('#Address_Edit').addClass('nested');

        }

        function formatCurrency(total) {
            return total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }

        function TapinGetPrice() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('<?php echo e(route('ajax')); ?>', {
                    AjaxType: 'GetTapinPrice',
                    price: $("#Totall_price").val(),
                    weight: $("#Totall_weight").val(),
                    address: $("#Totall_address").val(),
                    city_code: $("#Totall_city_code").val(),
                    province_code: $("#Totall_province_code").val(),
                    first_name: $("#Totall_first_name").val(),
                    last_name: $("#Totall_last_name").val(),
                    mobile: $("#Totall_mobile").val(),
                    postal_code: $("#Totall_postal_code").val(),
                    package_weight: $("#Totall_weight").val(),
                },
                function(data, status) {

                    if (data[0]) {
                        $('#Estelam').removeClass('nested');
                        $('#GetDeleverPrice').html('مبلغ : ' + formatCurrency(data[1]) + ' ریال ارسال با تاپین');
                    } else {
                        alert(data[1]);
                    }
                });

        }
    </script>
    <script>
        function UserInfo_edit_endable_func() {
            $('#UserInfoEdit').removeClass('nested');
            $('#UserInfo_edit_disadable').removeClass('nested');
            $('#UserInfoView').addClass('nested');
            $('#UserInfo_edit_endable').addClass('nested');


        }

        function UserInfo_edit_disable_func() {
            $('#UserInfoEdit').addClass('nested');
            $('#UserInfo_edit_disadable').addClass('nested');
            $('#UserInfoView').removeClass('nested');
            $('#UserInfo_edit_endable').removeClass('nested');
        }

        function changestatetosearcharialoacl() {
            $('#ownerselector').removeClass('nested');
            $('#ownerdisplay').addClass('nested');
        }
    </script>
@endsection

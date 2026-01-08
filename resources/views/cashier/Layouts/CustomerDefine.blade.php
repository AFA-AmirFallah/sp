@php
    $Customer = $cashier->get_curent_customer();
    $UserName = $cashier->get_curent_customer('UserName');
    $Persian = new App\Functions\persian();
@endphp
@if ($Customer == null)
    <div class="card">
        <div class="card-header bg-transparent">
            <h3 class="card-title">مشخصات مشتری</h3>
        </div>
        <form method="post">
            @csrf
            <div class="card-body">

                <div class="form-row ">
                    <div class="form-group col-md-6">
                        <label for="inputEmail4" class="ul-form__label">مشتری :</label>
                        @include('Layouts.SearchUserInput', [
                            'InputName' => 'UserName',
                            'InputPalceholder' => __('Target username'),
                        ])
                        <small class="ul-form__text form-text ">
                            نام مشتری
                        </small>
                    </div>
                </div>
                <div class="custom-separator"></div>
                <div class="card-title">عملیات</div>
                <button onclick="definecustomer()" type="button" class="btn btn-scucess"><i
                        class="sidebar-icon-style nav-icon i-Thumbs-Up-Smiley "></i>انتخاب مشتری</button>
                <button onclick="addcustomer()" type="button" class="btn btn-scucess"><i
                        class="sidebar-icon-style nav-icon i-Add-User"></i>افزودن مشتری</button>



            </div>

        </form>
    </div>
@else
    <div class="row">
        <div class="col-lg-6 col-md-2 col-sm-6 col-xs-12 mb-4">
            <div class="card">
                <div class="card-header ">
                    <h3 class="card-title">نام مشتری</h3>
                </div>
                <div class="card-body bg-transparent">
                    <table id="ul-contact-list" class="{{ \App\myappenv::MainTableClass }}">
                        <thead>
                            <tr>
                                <th>نام</th>
                                <th>نام خانوادگی</th>
                                <th>شماره موبایل</th>
                                <th>کدملی</th>
                            </tr>

                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    {{ $Customer->Name }}
                                </td>


                                <td>
                                    {{ $Customer->Family }}
                                </td>

                                <td>
                                    {{ $Customer->MobileNo }}
                                </td>
                                <td>
                                    {{ $Customer->MelliID }}
                                </td>
                            </tr>
                            <input id="CustomerUserName" type="text" class="nested"
                                value="{{ $Customer->UserName }}">
                    </table>
                    <div id="tavan">

                    </div>

                </div>

                <div class="card-footer bg-transparent">
                    <button onclick="removeCustomer()" style="margin: 10px" type="button" class="btn btn-primary"><i
                            class="i-Thumbs-Down-Smiley"></i> فراموشی مشتری</button>
                    <button onclick="EditCustomer()" style="margin: 10px" type="button" class="btn btn-primary">ویرایش
                        مشتری</button>

                    <button type="button" onclick="estelam('{{ $Customer->MelliID }}','{{ $Customer->MobileNo }}')"
                        class="btn btn-warning">استعلام
                        توان پرداخت</button>



                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-2 col-sm-6 col-xs-12 mb-4">
            <div class="card">
                <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                    <h3 class="card-title">اعتبارات مشتری</h3>

                </div>
                <div class="card-body bg-transparent">
                    <table class="{{ \App\myappenv::MainTableClass }}">

                        <thead>
                            <tr>
                                <th>کیف پول </th>


                            </tr>
                        </thead>
                        @foreach ($cashier->get_user_walet($UserName) as $Walet)
                            <tbody>
                                <tr>
                                    <td>
                                        <b> {{ $Walet->ModName }}</b> : {{ number_format($Walet->Mony) }} ریال
                                    </td>
                                </tr>
                        @endforeach
                    </table>
                </div>

            </div>
        </div>
        <div class="col-lg-6 col-md-2 col-sm-6 col-xs-12 mb-4">
            <div class="card">
                <div class="card-header d-sm-flex justify-content-sm-between align-items-sm-center">

                    <h3 class="card-title">سوابق خرید</h3>
                    <a class="btn btn-primary btn-rounded" href="{{ route('Workflow', ['RequestUser' => $UserName]) }}"
                        target="_blank">گردش کار کاربر </a>
                </div>
                <div class="card-body bg-transparent">
                    <table class="{{ \App\myappenv::MainTableClass }}">
                        <thead>
                            <tr>
                                <th>سفارش </th>
                                <th>تاریخ </th>
                                <th>وضعیت </th>
                                <th>مجموع </th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cashier->get_User_Order_History($UserName) as $Order)
                                <tr>
                                    <td><a target="blank" href="{{ route('EditOrder', ['OrderID' => $Order->id]) }}">
                                            {{ $Order->id }}</a>
                                    </td>
                                    <td>{{ $Persian->MyPersianDate($Order->created_at) }} </td>
                                    <td>
                                        @if ($Order->status == 0)
                                            <p class="red text-white"> در انتظار پرداخت</p>
                                        @elseif ($Order->status == 1)
                                            پرداخت شده
                                        @elseif($Order->status == 10)
                                            در دست اقدام
                                        @elseif($Order->status == 20)
                                            ارسال به انبار
                                        @elseif($Order->status == 30)
                                            درحال بسته بندی
                                        @elseif($Order->status == 40)
                                            ارسال به پست
                                        @elseif($Order->status == 60)
                                            لغو سفارش
                                        @elseif($Order->status == 70)
                                            تحویل سفارش و در انتظار تایید مالی
                                        @elseif($Order->status == 80)
                                            ثبت صورتحساب
                                        @elseif($Order->status == 90)
                                            اتمام سفارش
                                        @elseif($Order->status == 100)
                                            تکمیل سفارش
                                        @endif
                                    </td>
                                    <td>
                                        <span>
                                            {{ number_format($Order->total_sales / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                            {{ App\Http\Controllers\Credit\currency::GetCurrency() }}</span> برای
                                        <span> {{ $Order->num_items_sold }}</span> آیتم
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>


                </div>
                <div class="card-footer bg-transparent">

                </div>
            </div>
        </div>
        @if ($cashier->UserHasPeriodicCredit($UserName))
            <div class="col-lg-6 col-md-2 col-sm-6 col-xs-12 mb-4">
                <div class="card">
                    <div class="card-header ">
                        <h3 class="card-title">اعتبار دوره ای</h3>
                    </div>
                    @if (Auth::user()->Role == \App\myappenv::role_SuperAdmin)
                        <div class="form-row align-items-center mt-3">
                            <div class="col-auto">

                                <input type="number" id="Periodcredit" class="form-control mb-2 mr-sm-2">

                            </div>
                            <div class="form-check mb-2 mr-sm-2">

                                <label class="form-check-label" for="inlineFormCheck">
                                    تعداد افزودن دوره بعد از ماه فعلی
                                </label>
                            </div>
                            <div class="col-auto">
                                <button type="button"
                                    onclick="defineusercredit('{{ $Customer->MelliID }}','{{ $Customer->MobileNo }}')"
                                    class="btn btn-danger mb-2">
                                    افزودن دوره</button>
                            </div>
                        </div>
                    @endif


                    <div class="card-body bg-transparent">
                        <table class="{{ \App\myappenv::MainTableClass }}">
                            <thead>
                                <tr>
                                    <th> دوره</th>
                                    <th>میزان اعتبار </th>
                                    <th>اعتبار مصرف شده </th>
                                    <th>اعتبار باقی مانده </th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($cashier->GetUserPeriodicCredit($UserName) as $Credit)
                                    <tr>
                                        <td>{{ $Credit['DateStr'] }}</td>
                                        <td>{{ number_format($Credit['BaseMony']) }}</td>
                                        <td>{{ number_format($Credit['UsedMony'] * -1) }}</td>
                                        <td>{{ number_format($Credit['BaseMony'] + $Credit['UsedMony']) }}</td>


                                    </tr>
                                @endforeach

                            </tbody>
                        </table>


                    </div>
                    <div class="card-footer bg-transparent">

                    </div>
                </div>
            </div>
        @endif
    </div>
@endif

<!-- end::form -->

@include('Layouts.SearchUserInput_Js')

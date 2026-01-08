@php
    $Persian = new App\Functions\persian();
    $User = new \App\Users\UserClass();
@endphp
@extends('Layouts.MainPage')
@section('page-header-left')
@endsection
@section('MainCountent')
    <div id="app">
        <Patdashboard></Patdashboard>
    </div>
    <input type="text" class="nested" id="UserName" value="{{ App\Patient\PatientClass::PatientGetter() }}">
    <input type="text" class="nested" id="UserName_page" value="{{ $RequestPat }}">
    <div class="container-fluid">
        <div class="row">
            @if (\App\myappenv::MainOwner != 'Ohp')
                <div class="col-xl-4">
                    @include('Users.UsersMainInfo')
                </div>
            @endif
            @if (\App\myappenv::MainOwner == 'Ohp')
                <div class="col-xl-12">
                @else
                    <div class="col-xl-8">
            @endif
            <div class="card tab2-card">
                <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                    <h5 class="text-white"><i class=" header-icon i-Dollar"></i> گزارش مالی:
                        {{ $UserInfoResult->nameofuser }}
                        {{ $UserInfoResult->Family }}</h5>
                </div>
                <div class="card-body">
                    <ul class="nav nav-tabs nav-material" id="top-tab" role="tablist">
                        <li class="nav-item"><a class="nav-link active" id="top-profile-tab" data-toggle="tab"
                                href="#top-profile" role="tab" aria-controls="top-profile" aria-selected="true"><i
                                    data-feather="user" class="mr-2"></i>{{ __('Financial State') }}</a>
                        </li>
                        <li class="nav-item"><a class="nav-link" id="contact-top-tab" data-toggle="tab" href="#credite-card"
                                role="tab" aria-controls="top-contact" aria-selected="false"><i
                                    data-feather="credit-card" class="mr-2"></i>{{ __('user credite report') }}
                            </a>
                        </li>
                        <li class="nav-item"><a class="nav-link" id="contact-top-tab" data-toggle="tab" href="#calls"
                                role="tab" aria-controls="top-contact" aria-selected="false"><i
                                    data-feather="credit-card" class="mr-2"></i>تماسها
                            </a>
                        </li>
                        <li class="nav-item"><a class="nav-link" id="contact-top-tab" data-toggle="tab"
                                href="#creditttarnsfer" role="tab" aria-controls="top-contact" aria-selected="false"><i
                                    data-feather="credit-card" class="mr-2"></i>انتقال
                                اعتبار
                            </a>
                        </li>
                        @if ($UserInfoResult->Role == \App\myappenv::role_worker )
                        <li class="nav-item"><a class="nav-link" id="contact-top-tab" data-toggle="tab" href="#user_shifts"
                                role="tab" aria-controls="top-contact" aria-selected="false"><i
                                    data-feather="credit-card" class="mr-2"></i> خدمات
                                انجام
                                شده
                            </a>
                        </li>
                        @endif

                    </ul>
                    <div class="tab-content" id="top-tabContent">
                        <div class="tab-pane fade show active" id="top-profile" role="tabpanel"
                            aria-labelledby="top-profile-tab">
                            <h5 class="f-w-600">{{ __('Financial State') }}</h5>
                            <table class="{{ \App\myappenv::MainTableClass }}">
                                <thead>
                                    <tr>
                                        <th>{{ __('Credit Type') }}</th>
                                        <th>{{ __('Price') }}</th>
                                        <th>{{ __('Discount') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($UserFinancialState as $UserFinancialStateItem)
                                        <tr>
                                            <th>{{ $UserFinancialStateItem->ModName }}</th>
                                            <th>{{ number_format($UserFinancialStateItem->Mony) }}</th>
                                            <th>{{ number_format($UserFinancialStateItem->RealMony) }}</th>

                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="credite-card" role="tabpanel" aria-labelledby="contact-top-tab">
                            <h5 class="f-w-600">{{ __('user credite report') }}</h5>
                            <li><a class="glyphicon glyphicon-export" href="#"
                                    onclick="$('#transaction_table').tableExport({type:'excel',escape:false});">خروجی
                                    اکسل</a></li>
                            <div class="card-body order-datatable">

                                <div class="card-body order-datatable">
                                    <div class="table-responsive">
                                        <table class="{{ \App\myappenv::MainTableClass }}" id="transaction_table">
                                            <thead>
                                                <tr>

                                                    <th>کد</th>
                                                    <th>{{ __('Transaction code') }}</th>
                                                    <th>{{ __('Transaction date') }}</th>
                                                    <th>{{ __('Transaction confirm date') }}</th>
                                                    <th>{{ __('Price') }}</th>
                                                    <th>{{ __('Credit Type') }}</th>
                                                    <th>{{ __('Account balance') }}</th>
                                                    <th>{{ __('notes') }}</th>
                                                    <th>فاکتور</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if ($myTrasaction != null)
                                                    @php
                                                        $total = 0;
                                                    @endphp

                                                    @foreach ($myTrasaction as $Trasaction)
                                                        <tr
                                                            @if ($Trasaction->Mony < 0) class="table-row-danger" @endif>

                                                            <td>
                                                                {{ $Trasaction->ID }}
                                                            </td>
                                                            <td>
                                                                {{ $Trasaction->ID }}
                                                                @if ($Trasaction->ZeroRefrenceID != 0)
                                                                    <br>{{ __('Refrence') }} <br>
                                                                    {{ $Trasaction->ZeroRefrenceID }}
                                                                @endif
                                                            </td>
                                                            <td>{{ $Persian->MyPersianDate($Trasaction->Date) }}
                                                            </td>
                                                            <td>{{ $Persian->MyPersianDate($Trasaction->Confirmdate) }}
                                                            </td>
                                                            <td>
                                                                @if ($Trasaction->RealMony != null)
                                                                    {{ __('Real mony') }}
                                                                    : {{ number_format($Trasaction->Mony) }}
                                                                    <br> {{ __('Pay mony') }}
                                                                    :
                                                                    {{ number_format($Trasaction->RealMony) }}
                                                                    <br> {{ __('Discount') }}
                                                                    :
                                                                    {{ number_format($Trasaction->Mony - $Trasaction->RealMony) }}
                                                                @else
                                                                    {{ number_format($Trasaction->Mony) }}
                                                                @endif
                                                            </td>
                                                            <td>
                                                                {{ $Trasaction->ModName }}
                                                                @if ($Trasaction->Type == 100)
                                                                    <p class="red text-white">تعیین سقف</p>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if ($Trasaction->CreditMod == \app\myappenv::CachCredit)
                                                                    {{ number_format($total += $Trasaction->Mony) }}
                                                                @endif
                                                            </td>
                                                            <td>
                                                                {{ $Trasaction->Note }}


                                                            </td>
                                                            <td>

                                                                @if ($Trasaction->InvoiceNo)
                                                                    @if ($Trasaction->Type == 166)
                                                                        <a target="blank"
                                                                            href="{{ route('EditOrder', ['OrderID' => $Trasaction->InvoiceNo, 'type' => 'service']) }}">{{ $Trasaction->InvoiceNo }}</a>
                                                                    @else
                                                                        <a target="blank"
                                                                            href="{{ route('EditOrder', ['OrderID' => $Trasaction->InvoiceNo]) }}">{{ $Trasaction->InvoiceNo }}</a>
                                                                    @endif
                                                                @endif

                                                            </td>

                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="tab-pane fade" id="calls" role="tabpanel" aria-labelledby="contact-top-tab">

                            <h5 class="f-w-600">گزارش تماس ها</h5>
                            <div class="card-body order-datatable">

                                <div class="card-body order-datatable">
                                    <div class="table-responsive">
                                        <table class="{{ \App\myappenv::MainTableClass }}" id="calls_table">
                                            <thead>
                                                <tr>
                                                    <th>کد</th>
                                                    <th>تاریخ تماس</th>
                                                    <th>مدت مکالمه</th>
                                                    <th>تماس گیرنده</th>
                                                    <th>پاسخگو</th>
                                                    <th>گزارش تماس</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                @foreach ($CallCenter->get_user_calls_history() as $CallItem)
                                                    <tr>
                                                        <td>
                                                            {{ $CallItem->CallID }}
                                                        </td>
                                                        <td>
                                                            {{ $Persian->MyPersianDate($CallItem->StartTime, true) }}
                                                        </td>
                                                        <td>
                                                            {{ $CallItem->CallDuration }} ثانیه
                                                        </td>
                                                        <td>
                                                            {{ $CallItem->CName }} {{ $CallItem->CFamily }}
                                                        </td>
                                                        <td>
                                                            {{ $CallItem->AName }} {{ $CallItem->AFamily }}
                                                        </td>
                                                        <td>

                                                        </td>

                                                    </tr>
                                                @endforeach

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>

                        @if (Auth::user()->Role == \App\myappenv::role_SuperAdmin)

                            <div class="tab-pane fade" id="creditttarnsfer" role="tabpanel"
                                aria-labelledby="contact-top-tab">
                                <h5 class="f-w-600">انتقال اعتبار</h5>

                                <div class="card-body order-datatable">

                                    <div class="card-body order-datatable">
                                        <form method="post">
                                            @csrf
                                            <div class="table-responsive">
                                                <table class="{{ \App\myappenv::MainTableClass }}"
                                                    id="creditttarnsfer_Table">
                                                    <thead>
                                                        <tr>

                                                            <th>شماره تراکنش</th>
                                                            <th>فاکتور</th>
                                                            <th>{{ __('Transaction date') }}</th>
                                                            <th>{{ __('Price') }}</th>
                                                            <th>سرفصل کل ملی</th>
                                                            <th>عملیات</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                        @if ($MyTrasactionCredit != null)
                                                            @php
                                                                $total = 0;
                                                                $counter = 0;
                                                            @endphp

                                                            @foreach ($MyTrasactionCredit as $Trasaction)
                                                                <tr
                                                                    @if ($Trasaction->Mony < 0) class="table-row-danger" @endif>

                                                                    <td>
                                                                        {{ $Trasaction->ID }}
                                                                    </td>

                                                                    <td>

                                                                        @if ($Trasaction->InvoiceNo)
                                                                            <a target="blank"
                                                                                href="{{ route('EditOrder', ['OrderID' => $Trasaction->InvoiceNo]) }}">{{ $Trasaction->InvoiceNo }}</a>
                                                                        @endif

                                                                    </td>
                                                                    <td>{{ $Persian->MyPersianDate($Trasaction->Date) }}
                                                                    </td>

                                                                    <td>
                                                                        @if ($Trasaction->RealMony != null)
                                                                            {{ __('Real mony') }}
                                                                            :
                                                                            {{ number_format($Trasaction->Mony) }}
                                                                            <br> {{ __('Pay mony') }}
                                                                            :
                                                                            {{ number_format($Trasaction->RealMony) }}
                                                                            <br> {{ __('Discount') }}
                                                                            :
                                                                            {{ number_format($Trasaction->Mony - $Trasaction->RealMony) }}
                                                                        @else
                                                                            {{ number_format($Trasaction->Mony) }}
                                                                        @endif
                                                                    </td>

                                                                    <td>

                                                                        <select name="CreditIndex[{{ $counter }}]"
                                                                            class="form-control">
                                                                            <option value="0">
                                                                                {{ __('--select--') }}
                                                                            </option>
                                                                            @foreach ($CreditIndex as $CreditIndexItem)
                                                                                @if ($CreditIndexItem->IndexID == old('CreditIndex') && old('CreditIndex') != 0)
                                                                                    <option
                                                                                        value="{{ $CreditIndexItem->IndexID }}"
                                                                                        selected>
                                                                                        {{ $CreditIndexItem->IndexName }}
                                                                                    </option>
                                                                                @else
                                                                                    <option
                                                                                        value="{{ $CreditIndexItem->IndexID }}">
                                                                                        {{ $CreditIndexItem->IndexName }}
                                                                                    </option>
                                                                                @endif
                                                                            @endforeach
                                                                        </select>

                                                                    </td>

                                                                    <td>
                                                                        <input class="ProductCheckBox" type="checkbox"
                                                                            name="Trasaction[]"
                                                                            value="{{ $counter }}">

                                                                        <input class="nested" type="text"
                                                                            name="ID[{{ $counter }}]"
                                                                            value="{{ $Trasaction->ID }}">
                                                                    </td>




                                                                </tr>
                                                                @php
                                                                    $counter++;
                                                                @endphp
                                                            @endforeach
                                                        @endif

                                                    </tbody>
                                                </table>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                            </div>
                        @endif

                        @if ($UserInfoResult->Role == \App\myappenv::role_worker )
                            <div class="tab-pane fade" id="user_shifts" role="tabpanel"
                                aria-labelledby="contact-top-tab">
                                <h5 class="f-w-600">خدمات انجام شده</h5>
                                @php
                                    $user_attr = [
                                        'user_type' => 'userinforesponder',
                                        'target_user' => $UserInfoResult->UserName,
                                    ];
                                    $user_shfits_totall = $usertransfer->CrediteTransferConfirmsrv(false, $user_attr);
                                    if ($user_shfits_totall['result']) {
                                        $user_shfits_totall = $user_shfits_totall['data'];
                                    } else {
                                        $user_shfits_totall = [];
                                    }
                                @endphp
                                <div class="card-body order-datatable">

                                    <div class="card-body order-datatable">
                                        <form method="post">
                                            @csrf
                                            <div class="table-responsive">
                                                <table class="{{ \App\myappenv::MainTableClass }}" id="user_shifts">
                                                    <thead>
                                                        <tr>

                                                            <th>کد خدمت</th>
                                                            <th>نام خدمت</th>
                                                            <th>گیرنده خدمت</th>
                                                            <th>مبلغ</th>
                                                            <th>تارخ شروع</th>
                                                            <th>تارخ پایان</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if ($user_shfits_totall != [])
                                                            @php
                                                                $total = 0;
                                                                $counter = 0;
                                                            @endphp

                                                            @foreach ($user_shfits_totall as $user_shfits)
                                                                <tr>
                                                                    <td>{{ $user_shfits->ID }} </td>
                                                                    <td>{{ $user_shfits->RespnsTypeName }}
                                                                    </td>
                                                                    <td>{{ $user_shfits->userinfoownerName }}
                                                                        {{ $user_shfits->userinfoownerFamily }}
                                                                    </td>
                                                                    <td> <button
                                                                            style="
                                                                            width: 20px;
                                                                            height: 20px;
                                                                        "
                                                                            type="button"
                                                                            class="btn round btn-primary btn-icon rounded-circle m-1"
                                                                            data-toggle="tooltip" data-placement="top"
                                                                            title=""
                                                                            data-original-title=" {{ $user_shfits->Note }}">
                                                                            ?
                                                                        </button>{{ number_format($user_shfits->Mony) }}
                                                                    </td>
                                                                    <td>{{ $Persian->MyPersianDate($user_shfits->StartRespns, true) }}
                                                                    </td>
                                                                    <td>{{ $Persian->MyPersianDate($user_shfits->EndRespns, true) }}
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        @endif

                                                    </tbody>
                                                </table>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                            </div>
                        @endif

                        <div class="tab-pane fade" id="setting" role="tabpanel" aria-labelledby="contact-top-tab">
                            <h5 class="f-w-600">{{ __('setting') }}</h5>

                        </div>
                        <div class="tab-pane fade" id="user-index" role="tabpanel" aria-labelledby="contact-top-tab">
                            <h5 class="f-w-600">{{ __('user index') }}</h5>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <!-- Container-fluid Ends-->
@endsection
@section('page-js')
    @if (app()->getLocale() == 'fa')
        <script src="{{ asset('assets/js/vendor/datatables.min.fa.js') }}"></script>
    @else
        <script src="{{ asset('assets/js/vendor/datatables.min.js') }}"></script>
    @endif
    <script>
        $('#creditttarnsfer_Table').DataTable();
        $('#calls_table').DataTable();
        $('#transaction_table').DataTable();
    </script>
    <script src="{{ asset('assets/js/tooltip.script.js') }}"></script>
@endsection
@section('bottom-js')
    <script>
        window.main_username = $('#UserName').val();
        window.page_username = $('#UserName_page').val();
        window.targetpage = 'UserReport';
    </script>
@endsection

@php
    $Persian = new App\Functions\persian();
@endphp
@extends('Layouts.MainPage')
@section('page-header-left')
    <h3>{{ __('Pats') }}
        <small>{{ __('My pats') }}</small>
    </h3>
@endsection
@section('MainCountent')

    <input class="nested" id="main-menu" value="#Financials">
    <input class="nested" id="sub-menu" value="#CahngeTransaction">
    @if ($Type == 'search')
        <div class="row ">
            <div class="col-6">
                <form style="display: contents" method="post">
                    @csrf
                    <div class="card">
                        <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                            جستجوی کد تراکنش
                        </div>
                        <div class="card-body">
                            <label>کد تراکنش</label>
                            <input type="number" required class="form-control" name="SingleTransactionCode">

                        </div>
                        <div class="card-footer">
                            <button type="submit" name="submit" value="single" class="btn btn-warning"> جستجوی شماره
                                تراکنش
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-6">
                <form style="display: contents" method="post">
                    @csrf
                    <div class="card">
                        <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                            جستجوی کد مرجع
                        </div>
                        <div class="card-body">
                            <label>کد مرجع تراکنش</label>
                            <input type="number" required class="form-control" name="RefrenceTransactionCode">

                        </div>
                        <div class="card-footer">
                            <button type="submit" name="submit" value="refrence" class="btn btn-danger"> جستجوی کد مرجع
                                تراکنش
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <hr>
        <form method="POST">
            @csrf
            <div class="card">
                <div class="card-header gradient-purple-indigo 0-hidden pb-80"> <i style="font-size: large"
                        class="i-Cash-register-2"></i>
                    لیست صندوقداران
                </div>
                <div class="card-body">
                    <div class="col-md-12 table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>
                                        نام </th>
                                    <th>
                                        نام خانوادگی
                                    </th>
                                    <th>
                                        مجموع بدهی
                                    </th>
                                    <th>
                                        عملیات </th>

                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($creditRefrnce as $creditRefrnceItem)
                                    <tr>


                                        <td>
                                            {{ $creditRefrnceItem->Name }}
                                        </td>
                                        <td>
                                            {{ $creditRefrnceItem->Family }}
                                        </td>
                                        <td>
                                            {{ number_format($creditRefrnceItem->sum) }}

                                        </td>
                                        <td>
                                            <button type="submit" title="{{ __('Confirme transaction') }}"
                                                class="btn btn-success " name="Confirm"
                                                value="{{ $creditRefrnceItem->UserName }}">مشاهده</button>

                                        </td>


                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
        </form>
    @elseif($Type == 'single')
        <form method="POST">
            @csrf
            <div class="card">
                <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                    تغییر تراکنش
                </div>
                <div class="card-body">
                    <div class="col-md-12 table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>
                                        کد تراکنش
                                    </th>
                                    <th>
                                        نام
                                    </th>
                                    <th>
                                        توضیح
                                    </th>
                                    <th>
                                        نوع تراکنش
                                    </th>
                                    <th>
                                        تاریخ
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    @foreach ($SourceCredits as $SourceCredit)
                                        <input class="nested" name="TransactionID" value="{{ $SourceCredit->ID }}"
                                            type="text">
                                        <td>{{ $SourceCredit->ID }}</td>
                                        <td>{{ $SourceCredit->Name }} {{ $SourceCredit->Family }}</td>
                                        <td>{{ $SourceCredit->Note }}</td>
                                        <td>{{ $SourceCredit->ModName }}</td>
                                        <td> {{ $Persian->MyPersianDate($SourceCredit->Confirmdate) }} </td>
                                    @endforeach
                                </tr>
                            </tbody>
                        </table>
                        <hr>
                        <label>انتخاب نوع تراکنش <label style="color: red">*</label> </label>
                        <select class="form-control" name="CrediteCahngeMode">
                            @foreach ($CredeteMods as $CredeteMod)
                                <option value="{{ $CredeteMod->ID }}"> {{ $CredeteMod->ModName }} </option>
                            @endforeach
                        </select>
                        <label>توضیحات</label>
                        <input type="text" class="form-control" name="ChangeNote">
                    </div>
                </div>
                <div class="card-fotter">
                    <button class="btn btn-danger" type="submit" name="submit" value="SingleChange">تغییر تراکنش</button>
                </div>
            </div>
        </form>
    @elseif($Type == 'refrence')
        <form method="POST">
            @csrf
            <div class="card">
                <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                    تغییر تراکنش با کد مرجع {{ $RefrenceTransactionCode }}
                </div>
                <div class="card-body">
                    <div class="col-md-12 table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>
                                        کد تراکنش
                                    </th>
                                    <th>
                                        نام
                                    </th>
                                    <th>
                                        توضیح
                                    </th>
                                    <th>
                                        نوع تراکنش
                                    </th>
                                    <th>
                                        تاریخ
                                    </th>
                                </tr>
                            </thead>
                            <input class="nested" name="TransactionID" value="{{ $RefrenceTransactionCode }}"
                                type="text">
                            <tbody>
                                @foreach ($SourceCredits as $SourceCredit)
                                    <tr>

                                        <td>{{ $SourceCredit->ID }}</td>
                                        <td>{{ $SourceCredit->Name }} {{ $SourceCredit->Family }}</td>
                                        <td>{{ $SourceCredit->Note }}</td>
                                        <td>{{ $SourceCredit->ModName }}</td>
                                        <td> {{ $Persian->MyPersianDate($SourceCredit->Confirmdate) }} </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <hr>
                        <label>انتخاب نوع تراکنش <label style="color: red">*</label> </label>
                        <select class="form-control" name="CrediteCahngeMode">
                            @foreach ($CredeteMods as $CredeteMod)
                                <option value="{{ $CredeteMod->ID }}"> {{ $CredeteMod->ModName }} </option>
                            @endforeach
                        </select>
                        <label>توضیحات</label>
                        <input type="text" class="form-control" name="ChangeNote">
                    </div>
                </div>
                <div class="card-fotter">
                    <button class="btn btn-danger" type="submit" name="submit" value="RefrenceChange">تغییر
                        تراکنش</button>
                </div>
            </div>
        </form>
    @elseif ($Type == 'confirmList')
        <form method="POST">
            @csrf
            <div class="card">
                <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                    لیست بدهی صندوقدار
                </div>
                <div class="card-body">
                    <div class="col-md-12 table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>
                                        نام </th>

                                    <th>
                                        بدهی
                                    </th>
                                    <th>
                                        تاریخ
                                    </th>
                                    <th>
                                        شماره فاکتور
                                    </th>
                                    <th>
                                        عملیات </th>

                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($creditRefrnceCDP as $creditRefrnceItemCDP)
                                    <tr id="Row_{{ $creditRefrnceItemCDP->ID }}">


                                        <td>
                                            {{ $creditRefrnceItemCDP->UserName }}
                                        </td>

                                        <td>
                                            {{ number_format($creditRefrnceItemCDP->Mony) }}

                                        </td>
                                        <td>
                                            {{ $Persian->MyPersianDate($creditRefrnceItemCDP->Date) }}

                                        </td>
                                        <td>
                                            <a target="blank"
                                                href="{{ route('EditOrder', ['OrderID' => $creditRefrnceItemCDP->InvoiceNo]) }}">{{ $creditRefrnceItemCDP->InvoiceNo }}</a>


                                        </td>
                                        <td>
                                            <button type="button" onclick="confirmer({{ $creditRefrnceItemCDP->ID }})"
                                                class="btn btn-primary " name="ConfirmCDP"
                                                value="{{ $creditRefrnceItemCDP->ID }}"><i
                                                    class="nav-icon i-Data-Yes"></i></button>


                                            <button type="submit" class="btn btn-danger " name="deleteCDP"
                                                value="{{ $creditRefrnceItemCDP->UserName }}"><i
                                                    class="nav-icon i-Close-Window"></i></button>
                                        </td>


                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
        </form>
    @endif
@endsection
@section('page-js')
    <script>
        function confirmer($CreditID) {
            $.ajax({
                url: '?ConfirmId=' + $CreditID,
                type: 'get',
                beforeSend: function() {

                },
                success: function(response) {
                    $('#Row_' + $CreditID).addClass('nested');
                    alert(response);
                },
                error: function() {
                    alert('can not');
                }
            });
        }
    </script>
@endsection

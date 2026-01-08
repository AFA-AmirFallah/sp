@php
    $Persian = new App\Functions\persian();
@endphp
@extends('Layouts.MainPage')

@section('MainCountent')
    <input class="nested" id="main-menu" value="#Financials">
    <input class="nested" id="sub-menu" value="#CrediteTransfer">

    <div class="row">
        <!-- ICON BG -->
        <div class=" col-lg-3 col-md-6 col-sm-6 ">
            <a href="{{ route('CrediteTransfer') }}">
                <div class="navcard active-navcard card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                    <div class="card-body text-center">
                        <i class="i-Money-2"></i>
                        <div class="content">
                            <p class=" mt-2 mb-0 text-white">درخواست انتقال</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 ">
            <a href="{{ route('CrediteTransferConfirm') }}">
                <div class="navcard navcard-main card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                    <div class="card-body text-center">
                        <i style="color: orange" class="i-Loading-2"></i>
                        <div class="content">
                            <p class="text-primary mt-2 mb-0">انتقالات در انتظار تایید</p>

                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 ">
            <a href="{{ route('CrediteTransferConfirmserv') }}">
                <div class="navcard navcard-main card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                    <div class="card-body text-center">
                        <i style="color: orange" class="i-Time-Backup"></i>
                        <div class="content">
                            <p class="text-primary mt-2 mb-0">خدمات در انتظار تایید</p>

                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 ">
            <a href="{{ Route('MyTransfersReport') }}">
                <div class="navcard navcard-main card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                    <div class="card-body text-center">
                        <i style="color: green" class="i-Receipt-3"></i>
                        <div class="content">
                            <p class="text-primary mt-2 mb-0">تاریخچه انتقالات من</p>

                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <section class="basic-action-bar">
        <div class="">
            <div class="row">
                @if ($RefrenceSrc != null)
                    @php
                        $TrazKol = 0;
                        $TrazKolConfirmed = 0;
                        $TrazKolUnConfirmed = 0;
                    @endphp
                    <div class="col-lg-4 mb-4">
                        <div class="card">
                            <div class="card-header bg-transparent">
                                <h3 class="card-title">سابقه تراکنش ها</h3>
                            </div>
                            <div class="card-body">
                                @foreach ($RefrenceSrc as $RefrenceItem)
                                    <div class="card">
                                        <div class="card-body">
                                            @php
                                                $TrazKol += $RefrenceItem->Mony;
                                                if ($RefrenceItem->Confirmdate == null) {
                                                    $TrazKolUnConfirmed += $RefrenceItem->Mony;
                                                } else {
                                                    $TrazKolConfirmed += $RefrenceItem->Mony;
                                                }
                                                $MainNote = $RefrenceItem->Note;
                                            @endphp
                                            @if ($RefrenceItem->Confirmdate == null && $RefrenceItem->ID != $ReferenceId && $RefrenceItem->ReferenceId != null)
                                                <form method="POST">
                                                    @csrf
                                                    <button style="float: left;" name='deleteTranscation'
                                                        value="{{ $RefrenceItem->ID }}"
                                                        class="btn btn-outline-danger">حذف</button>
                                                </form>
                                            @endif
                                            <li>کد تراکنش: {{ $RefrenceItem->ID }}</li>
                                            <li>ذی نفع: {{ $RefrenceItem->Name }} {{ $RefrenceItem->Family }}</li>
                                            <li>نوع تراکنش: {{ $RefrenceItem->ModName }}</li>
                                            @if ($RefrenceItem->Mony > 0)
                                                <li style="color: green">واریز: {{ number_format($RefrenceItem->Mony) }}
                                                    ریال</li>
                                            @else
                                                <li style="color: red">برداشت:
                                                    {{ number_format(-1 * $RefrenceItem->Mony) }} ریال</li>
                                            @endif
                                            <li>تاریخ ثبت: {{ $Persian->MyPersianDate($RefrenceItem->Date) }}</li>
                                            @if ($RefrenceItem->Confirmdate != null)
                                                <li>تاریخ تایید:
                                                    {{ $Persian->MyPersianDate($RefrenceItem->Confirmdate) }}</li>
                                            @else
                                                <li>تاریخ تایید: ---</li>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                                <div style="background-color: #a6f39f" class="card">
                                    <div class="card-body">
                                        <li>تراز کل: {{ number_format($TrazKol) }} ریال</li>
                                        <li style="color: green">تراز تایید شده: {{ number_format($TrazKolConfirmed) }}
                                            ریال</li>
                                        <li style="color: red">تراز تایید نشده: {{ number_format($TrazKolUnConfirmed) }}
                                            ریال</li>
                                    </div>
                                </div>
                                <hr>
                                @if (Auth::user()->Role == App\myappenv::role_SuperAdmin)
                                    <form method="POST">
                                        @csrf
                                        <button name="ConfirmRefrence" value="all"
                                            class="btn btn-success btn-block">تایید
                                            انتقالات</button>
                                    </form>
                                @endif
                            </div>

                        </div>

                    </div>
                @endif
                @if ($RefrenceSrc != null)
                    <div class="col-lg-8 mb-8">
                    @else
                        <div class="col-lg-12 mb-12">
                @endif
                @if ($RefrenceSrc != null)
                    <form method="POST">
                        @csrf
                        <div class="card">
                            <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                                <h5 class="text-white"><i class=" header-icon i-Money-2"></i>تسویه حساب تراکنش ها
                                </h5>
                            </div>
                            <div class="card-body order-datatable">
                                <div class="table-responsive">
                                    <table class="{{ \App\myappenv::MainTableClass }}" id="transaction_table">
                                        <thead>
                                            <tr>

                                                <th>{{ __('Transaction code') }}</th>
                                                <th>{{ __('Transaction date') }}</th>
                                                <th>{{ __('Transaction confirm date') }}</th>
                                                <th>{{ __('Price') }}</th>
                                                <th>{{ __('Credit Type') }}</th>
                                                <th>{{ __('notes') }}</th>
                                                <th>قرارداد</th>
                                                <th>عملیات</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $total = 0;
                                            @endphp
                                            @php
                                                $Trasaction_src = App\Functions\Financial::get_user_debit($ReferenceId);
                                                if ($Trasaction_src['result']) {
                                                    $Trasaction_src = $Trasaction_src['data'];
                                                } else {
                                                    $Trasaction_src = [];
                                                }
                                            @endphp


                                            @foreach ($Trasaction_src as $Trasaction)
                                                <tr>

                                                    <td>
                                                        {{ $Trasaction->ID }}
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
                                                            : {{ number_format($Trasaction->RealMony) }}
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
                                                    <td>
                                                        @if ($Trasaction->Prebill == null)
                                                            <button type="submit" class="btn btn-danger"
                                                                name="confirm_service"
                                                                value="{{ $Trasaction->ID }}">تسویه</button>
                                                        @else
                                                            تراکنش تسویه : {{ $Trasaction->Prebill }}
                                                        @endif
                                                    </td>

                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- end::form -->
                        </div>
                    </form>
                @endif
                <div class="card">
                    <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                        <h5 class="text-white"><i class=" header-icon i-Money-2"></i>{{ __('Credit transfer request') }}
                        </h5>
                    </div>
                    <form method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="form-row ">
                                <div class="form-group col-md-6">
                                    <label for="inputEmail4" class="ul-form__label">{{ __('To account') }} :</label>
                                    @include('Layouts.SearchUserInput', [
                                        'InputName' => 'UserName',
                                        'InputPalceholder' => __('Target username'),
                                    ])
                                    <small class="ul-form__text form-text ">
                                        {{ __('The Username of peple who credit transfer') }}
                                    </small>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="inputEmail4" class="ul-form__label">{{ __('Credit Type') }}:</label>
                                    <select name="CreditMod" class="form-control">
                                        <option value="0">{{ __('--select--') }}</option>
                                        @foreach ($UserCreditModMetas as $UserCreditModMeta)
                                            @if ($UserCreditModMeta->ID == old('CreditMod') && old('CreditMod') != 0)
                                                <option value="{{ $UserCreditModMeta->ID }}" selected>
                                                    {{ $UserCreditModMeta->ModName }}</option>
                                            @else
                                                <option value="{{ $UserCreditModMeta->ID }}">
                                                    {{ $UserCreditModMeta->ModName }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    <small class="ul-form__text form-text ">
                                        {{ __('Select transfer credite type') }}
                                    </small>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="inputEmail4" class="ul-form__label">سرفصل کل مالی:</label>
                                    <select name="CreditIndex" class="form-control">
                                        <option value="0">{{ __('--select--') }}</option>
                                        @foreach ($CreditIndex as $CreditIndexItem)
                                            @if ($CreditIndexItem->IndexID == old('CreditIndex') && old('CreditIndex') != 0)
                                                <option value="{{ $CreditIndexItem->IndexID }}" selected>
                                                    {{ $CreditIndexItem->IndexName }}</option>
                                            @else
                                                <option value="{{ $CreditIndexItem->IndexID }}">
                                                    {{ $CreditIndexItem->IndexName }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    <small class="ul-form__text form-text ">
                                        {{ __('Select transfer credite type') }}
                                    </small>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputEmail4"
                                        class="ul-form__label">{{ __('Credite mony real') }}:</label>
                                    <input required type="number" id="amount" autocomplete="off"
                                        class="form-control" name="Amount" value="{{ old('Amount') }}"
                                        placeholder="{{ __('Credite transfer to user account') }}">
                                    <div id="amountext"></div>
                                    <small class="ul-form__text form-text ">
                                        {{ __('Credite transfer to user account') }}
                                    </small>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputEmail4"
                                        class="ul-form__label">{{ __('Credite Real get mony') }}</label>
                                    <input type="number" id="amountDisc" class="form-control" autocomplete="off"
                                        name="RealAmount" value="{{ old('RealAmount') }}"
                                        placeholder="{{ __('Credite Real get mony with discount') }}">
                                    <div id="amountDiscText"></div>
                                    <small class="ul-form__text form-text ">
                                        {{ __('If the transfer has discount this feild should be use!') }}
                                    </small>
                                </div>
                                @if ($RefrenceSrc != null)
                                    <textarea required name="Note" rows="3" class="form-control nested">{{ $MainNote }}</textarea>
                                    <p style="text-align: center;font-size:16px">{{ $MainNote }}</p>
                                    <div class="form-group col-md-12">
                                        <label class="ul-form__label">{{ __('Note') }}</label>
                                        <textarea required required name="ce" class="col-sm-12 form-control"></textarea>

                                    </div>
                                @else
                                    <div class="form-group col-md-12">
                                        <label class="ul-form__label">{{ __('Note') }}</label>
                                        <textarea required name="Note" rows="3" class="form-control">{{ old('Note') }}</textarea>
                                    </div>
                                @endif


                                <div class="custom-separator"></div>
                                <div class="card-title">{{ __('Save Type') }}</div>
                                <label class="checkbox checkbox-primary"></label>
                                <input type="checkbox" name="Limit">
                                <span>{{ __('Save as CrediteLimit') }}</span>
                                <span class="checkmark"></span>

                            </div>
                            @if ($RefrenceSrc == null)
                                <div class="card-footer bg-transparent">
                                    <div class="mc-footer">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <button type="submit" name="submit" value="Trnsfer"
                                                    class="btn  btn-primary m-1">{{ __('Save as Credit') }}</button>
                                                <button type="submit" name="submit" value="TrnsferSnad"
                                                    class="btn  btn-warning m-1">ثبت و شروع سند</button>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="card-footer bg-transparent">
                                    <div class="mc-footer">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <button type="submit" name="submit" value="Trnsfer"
                                                    class="btn  btn-primary m-1">{{ __('Save as Credit') }}</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- end::form -->
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('page-js')
    @include('Layouts.SearchUserInput_Js')

    <script>
        onload = function() {
            var e = document.getElementById('amount');
            e.oninput = myHandler;
            e.onpropertychange = e.oninput; // for IE8
            function myHandler() {
                document.getElementById('amountext').innerHTML = e.value.toPersianLetter() + ' تومان ';
            }
            var e2 = document.getElementById('amountDisc');
            e2.oninput = myHandler2;
            e2.onpropertychange = e2.oninput; // for IE8
            function myHandler2() {
                document.getElementById('amountDiscText').innerHTML = e2.value.toPersianLetter() + ' تومان ';
            }
        };
    </script>
    @include('Layouts.FilemanagerScripts')

    @include('Layouts.SearchMultiUserInput_Js')
@endsection

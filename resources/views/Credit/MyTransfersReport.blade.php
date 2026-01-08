@php
    $Persian = new App\Functions\persian();
@endphp
@extends('Layouts.MainPage')
@section('page-header-left')
@endsection
@section('MainCountent')
    <input class="nested" id="main-menu" value="#Financials">
    <input class="nested" id="sub-menu" value="#CrediteTransfer">
    @if(Auth::user()->Role > App\myappenv::role_customer)
    <div class="row">
        <div class=" col-lg-3 col-md-6 col-sm-6 ">
            <a href="{{ route('CrediteTransfer') }}">
                <div class="navcard navcard-main card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                    <div class="card-body text-center">
                        <i style="color: red" class="i-Money-2"></i>
                        <div class="content">
                            <p class=" mt-2 mb-0 text-primary">درخواست انتقال</p>
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
                <div class="navcard active-navcard card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                    <div class="card-body text-center">
                        <i class="i-Receipt-3"></i>
                        <div class="content">
                            <p class="text-white mt-2 mb-0">تاریخچه انتقالات من</p>

                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
    @else
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6 ">
            <a href="{{ Route('MyTransfersReport') }}">
                <div class="navcard active-navcard card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                    <div class="card-body text-center">
                        <i class="i-Receipt-3"></i>
                        <div class="content">
                            <p class="text-white mt-2 mb-0">تاریخچه انتقالات من</p>

                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
    @endif
    <form method="post">
        @csrf
        <div class="card-body">
            <div class="table-responsive">
                <table id="ul-contact-list" class="{{ \App\myappenv::MainTableClass }}" style="width:100%">
                    <thead>
                        <tr>
                            <th>{{ __('No.') }}</th>
                            <th>{{ __('Service') }}</th>
                            <th>{{ __('Service owner') }}</th>
                            <th>{{ __('Personel') }}</th>
                            <th>{{ __('By') }}</th>
                            <th>{{ __('Shift assign date') }}</th>
                            <th>{{ __('Price') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($ServiceCredits != null)
                            @php
                                $Rowno = 1;
                            @endphp
                            @foreach ($ServiceCredits as $ServiceCredit)
                                <tr @if ($ServiceCredit->Mony < 0) class="table-row-danger" @endif>
                                    <td>{{ $ServiceCredit->ID }}</td>
                                    <td>{{ $ServiceCredit->RespnsTypeName }} - {{ $ServiceCredit->Note }}</td>
                                    <td>{{ $ServiceCredit->OwnerUserInfoName }} {{ $ServiceCredit->OwnerUserInfoFamily }}
                                    </td>
                                    <td>{{ $ServiceCredit->ResponserUserInfoName }}
                                        {{ $ServiceCredit->ResponserUserInfoFamily }}</td>
                                    <td>{{ $ServiceCredit->byUserInfoName }} {{ $ServiceCredit->byUserInfoFamily }}</td>
                                    <td>{{ $Persian->MyPersianDate($ServiceCredit->StartRespns) }}
                                        <br> {{ $Persian->MyPersianDate($ServiceCredit->EndRespns) }}
                                    </td>
                                    <td style="direction: ltr">{{ number_format($ServiceCredit->Mony) }}</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>

                </table>
            </div>

        </div>
    </form>
    <form method="post">
        @csrf
        <div class="card-body">
            <div class="table-responsive">
                <table id="Transaction_List" class="{{ \App\myappenv::MainTableClass }}" style="width:100%">
                    <thead>
                        <tr>
                            <th scope="col">{{ __('Transaction code') }}</th>
                            <th scope="col">{{ __('To account') }}</th>
                            <th scope="col">{{ __('By') }}</th>
                            <th scope="col">{{ __('Transaction date') }}</th>
                            <th scope="col">{{ __('Price') }}</th>
                            <th scope="col">{{ __('Credit Type') }}</th>
                            @if ($showOperation)
                                <th scope="col">{{ __('Actions') }}</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @if ($RequestedCredits != null)
                            @php
                                $Rowno = 1;
                            @endphp
                            @foreach ($RequestedCredits as $RequestedCredit)
                                <tr @if ($RequestedCredit->Mony < 0) class="table-row-danger" @endif>
                                    <td>{{ $RequestedCredit->ID }}</td>
                                    <td>{{ $RequestedCredit->name }} - {{ $RequestedCredit->Note }}</td>
                                    <td>{{ $RequestedCredit->byUserInfoName }} {{ $RequestedCredit->byUserInfoFamily }}
                                    </td>
                                    <td>{{ $Persian->MyPersianDate($RequestedCredit->UserCreditDate) }}</td>
                                    <td style="direction: ltr">{{ number_format($RequestedCredit->Mony) }}
                                        @if ($RequestedCredit->RealMony != null)
                                            <br>تخفیف:
                                            {{ number_format($RequestedCredit->RealMony) }}
                                        @endif
                                    </td>
                                    <td>{{ $RequestedCredit->ModName }}</td>
                                    @if ($showOperation)
                                        <td>
                                            @if ($RequestedCredit->ConfirmBy == null)
                                                <button type="submit" class="btn btn-danger" name="DeleteTransaction"
                                                    value="{{ $RequestedCredit->ID }}">{{ __('delete') }}</button>
                                            @endif
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        @endif
                    </tbody>

                </table>
            </div>

        </div>
    </form>
    <!-- Container-fluid Ends-->

@endsection
@section('page-js')
    @if (app()->getLocale() == 'fa')
        <script src="{{ asset('assets/js/vendor/datatables.min.fa.js') }}"></script>
    @else
        <script src="{{ asset('assets/js/vendor/datatables.min.js') }}"></script>
    @endif
    <!-- page script -->
    <script src="{{ asset('assets/js/tooltip.script.js') }}"></script>

    <script>
        $('#ul-contact-list').DataTable();
        $('#Transaction_List').DataTable();
    </script>

    <script>
        var toggler = document.getElementsByClassName("box");
        var i;

        for (i = 0; i < toggler.length; i++) {
            toggler[i].addEventListener("click", function() {
                this.parentElement.querySelector(".nested").classList.toggle("active");
                this.classList.toggle("check-box");
            });
        }
    </script>
    <script>
        var selected = new Array();
        $(document).ready(function() {

            $("input[type='checkbox']").on('change', function() {
                // check if we are adding, or removing a selected item
                if ($(this).is(":checked")) {
                    selected.push($(this).val());
                } else {
                    for (var i = 0; i < selected.length; i++) {
                        if (selected[i] == $(this).val()) {
                            // remove the item from the array
                            selected.splice(i, 1);
                        }
                    }
                }

                // output selected
                var output = "";
                for (var o = 0; o < selected.length; o++) {
                    if (output.length) {
                        output += ", " + selected[o];
                    } else {
                        output += selected[o];
                    }
                }

                $(".taid").val(output);

            });

        });
    </script>
    <script>
        $(document).ready(function() {
                    $("#L1").change(function() {
                        var num = this.value;
                        $("#L11").css("display", "none");
                    });
    </script>
@endsection

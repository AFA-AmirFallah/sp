@php
    $Persian = new App\Functions\persian();
@endphp
@extends('Layouts.MainPage')
@section('page-header-left')
@endsection
@section('MainCountent')
    <input class="nested" id="main-menu" value="#Financials">
    <input class="nested" id="sub-menu" value="#CrediteTransfer">
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
                <div class="navcard active-navcard card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                    <div class="card-body text-center">
                        <i class="i-Time-Backup"></i>
                        <div class="content">
                            <p class="text-white mt-2 mb-0">خدمات در انتظار تایید</p>

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
    @php
        $ReferenceId = 0;
        $rowcounter = 0;
    @endphp

    <form method="post">
        @csrf
        @if ($CreditRows != [])
            <div class="row mb-4">
                @foreach ($CreditRows as $CreditRow)
                    @if ($ReferenceId != $CreditRow->ReferenceId)
                        @if ($ReferenceId != 0)
                            </tbody>
                            </table>
            </div>
            <div class="custom-separator"></div>
            {!! $TransactionNote !!}
            <div class="custom-separator"></div>
            <button type="submit" name="ConfirmRefrence" value="{{ $ReferenceId }}"
                class="btn btn-danger">{{ __('Confirm Transactions') }}</button>

            </div>
            </div>
            </div>
        @endif

        @php
            $TransactionNote = $CreditRow->Note;
            $ReferenceId = $CreditRow->ReferenceId;
            if ($rowcounter < 2) {
                $rowcounter++;
            } else {
                $rowcounter = 1;
                echo '</div><div class="row mb-4">';
            }
        @endphp

        <div class="col-md-6 mb-3">
            <div class="card card-body ul-border__bottom">
                <div class="text-center">
                    <h5 class="heading text-primary">{{ __('Service') }} : {{ $CreditRow->RespnsTypeName }}</h5>
                    <p class="mb-3">بیمار: {{ $CreditRow->userinfoownerName }} {{ $CreditRow->userinfoownerFamily }}
                        - نیرو : {{ $CreditRow->userinforesponderName }} {{ $CreditRow->userinforesponderFamily }}</p>
                    <a href="#collapse-icon{{ $CreditRow->ID }}" class="text-default collapsed" data-toggle="collapse"
                        aria-expanded="false">
                        <i class="i-Arrow-Down-2 t-font-boldest"></i>
                    </a>

                </div>
                <div class="collapse" id="collapse-icon{{ $CreditRow->ID }}">
                    <div class="row">
                        <div class="col-6">

                            {{ __('Service owner') }}
                            : <a href="#" class="navbar-nav-link" data-toggle="dropdown" aria-expanded="false">
                                {{ $CreditRow->userinfoownerName }} {{ $CreditRow->userinfoownerFamily }}
                            </a>

                            <div class="dropdown-menu" style="text-align: right">
                                <a target="_blank"
                                    href="{{ route('UserReport', ['RequestUser' => $CreditRow->OwnerUserID]) }}"
                                    class="dropdown-item">{{ __('User reports') }}</a>
                                <div class="dropdown-divider"></div>
                                <a target="_blank"
                                    href="{{ route('UserProfile', ['RequestUser' => $CreditRow->OwnerUserID]) }}"
                                    class="dropdown-item">{{ __('User edite') }}</a>
                            </div>

                        </div>
                        <div class="col-6">
                            {{ __('Service responder') }}
                            :<a href="#" class="navbar-nav-link" data-toggle="dropdown" aria-expanded="false">
                                {{ $CreditRow->userinforesponderName }} {{ $CreditRow->userinforesponderFamily }}
                            </a>

                            <div class="dropdown-menu" style="text-align: right">
                                <a target="_blank"
                                    href="{{ route('UserReport', ['RequestUser' => $CreditRow->ResponserID]) }}"
                                    class="dropdown-item">{{ __('User reports') }}</a>
                                <div class="dropdown-divider"></div>
                                <a target="_blank"
                                    href="{{ route('UserProfile', ['RequestUser' => $CreditRow->ResponserID]) }}"
                                    class="dropdown-item">{{ __('User edite') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <p> {{ __('StartRespns') }} : {{ $Persian->MyPersianDate($CreditRow->StartRespns, true) }}
                            </p>
                        </div>
                        <div class="col-6">
                            <p> {{ __('EndRespns') }} : {{ $Persian->MyPersianDate($CreditRow->EndRespns, true) }}</p>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="{{ \App\myappenv::MainTableClass }}">
                            <thead>
                                <tr>
                                    <th scope="col">{{ __('Transaction code') }}</th>
                                    <th scope="col">{{ __('To account') }}</th>
                                    <th scope="col">{{ __('Price') }}</th>
                                    <th scope="col">{{ __('Credit Type') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr @if ($CreditRow->Mony < 0) class="table-row-danger" @endif>
                                    <td>{{ $CreditRow->ID }}</td>
                                    <td>{{ $CreditRow->userinfocreditName }} {{ $CreditRow->userinfocreditFamily }}</td>
                                    <td>{{ number_format($CreditRow->Mony) }}</td>
                                    @if ($CreditRow->ModName == 1)
                                        <td>قابل برداشت</td>
                                    @elseif($CreditRow->ModName == 2)
                                        <td>غیر قابل برداشت</td>
                                    @else
                                        <td>{{ $CreditRow->ModName }}</td>
                                    @endif
                                </tr>
                            @else
                                <tr @if ($CreditRow->Mony < 0) class="table-row-danger" @endif>
                                    <td>{{ $CreditRow->ID }}</td>
                                    <td>{{ $CreditRow->userinfocreditName }} {{ $CreditRow->userinfocreditFamily }}</td>
                                    <td style="direction: ltr">{{ number_format($CreditRow->Mony) }}</td>
                                    @if ($CreditRow->ModName == 1)
                                        <td>قابل برداشت</td>
                                    @elseif($CreditRow->ModName == 2)
                                        <td>غیر قابل برداشت</td>
                                    @else
                                        <td>{{ $CreditRow->ModName }}</td>
                                    @endif
                                </tr>
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="custom-separator"></div>
                    {!! $TransactionNote !!}
                    <div class="custom-separator"></div>
                    <button type="submit" name="ConfirmRefrence" value="{{ $ReferenceId }}"
                        class="btn btn-danger">{{ __('Confirm Transactions') }}</button>

                </div>
            </div>
        </div>
    @else
        @include('Layouts.nodata')
        @endif

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
@endsection

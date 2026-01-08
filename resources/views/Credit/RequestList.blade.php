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
        <div class="ul-card-list__modal">
            <div class="modal fade add-device-contract-modal" tabindex="-1" role="dialog"
                aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">

                    <div class="modal-content">
                        <div class="modal-header">
                            <p class="modal-title" id="device_model_title">درخواست پرداخت</p>
                            <button style="display: contents" type="button" class="close" data-dismiss="modal"
                                aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div id="modal_body" class="modal-body">

                        </div>
                    </div>
                </div>
            </div>
        </div>

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
                <div class="navcard active-navcard card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                    <div class="card-body text-center">
                        <i class="i-Loading-2"></i>
                        <div class="content">
                            <p class="text-white mt-2 mb-0">انتقالات در انتظار تایید</p>

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
    <form method="post">
        @csrf
        <div class="card">
            <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                <h5 class="text-white"><i class=" header-icon i-Loading-2"></i>انتقالات در انتظار تایید
                </h5>
            </div>
            <div class="card-body">
                @if ($Credites != [] || $bill_src != [])
                    <div class="table-responsive">
                        <table id="ul-contact-list" class="{{ \App\myappenv::MainTableClass }}" style="width:100%">
                            <thead>
                                <tr>
                                    <th>{{ __('Transaction code') }}</th>
                                    <th>{{ __('To account') }}</th>
                                    <th>{{ __('Price') }}</th>
                                    <th>{{ __('Credit Type') }}</th>
                                    <th>{{ __('Date of enter') }}</th>
                                    <th>{{ __('By') }}</th>
                                    <th>شاخص مالی</th>
                                    <th>{{ __('Note') }}</th>
                                    <th>{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bill_src as $Credit)
                                    <tr @if ($Credit->Mony < 0) class="table-row-danger" @endif>
                                        <td>{{ $Credit->ID }}</td>
                                        <td><a href="#" class="navbar-nav-link" data-toggle="dropdown"
                                                aria-expanded="false">
                                                {{ $Credit->name }}
                                            </a>

                                            <div class="dropdown-menu" style="text-align: right">
                                                <a target="_blank"
                                                    href="{{ route('UserReport', ['RequestUser' => $Credit->UserName]) }}"
                                                    class="dropdown-item">{{ __('User reports') }}</a>
                                                <div class="dropdown-divider"></div>
                                                <a target="_blank"
                                                    href="{{ route('UserProfile', ['RequestUser' => $Credit->UserName]) }}"
                                                    class="dropdown-item">{{ __('User edite') }}</a>
                                            </div>
                                        </td>
                                        @if (strlen($Credit->RealMony) != 0)
                                            <td style="direction: ltr">{{ number_format($Credit->Mony) }}
                                                <br>
                                                <div style="color: green">
                                                    دریافتی:
                                                    {{ number_format($Credit->RealMony) }}

                                                </div>
                                                <div style="color: red">
                                                    تخفیف:
                                                    {{ number_format($Credit->Mony - $Credit->RealMony) }}

                                                </div>
                                            </td>
                                        @else
                                            <td style="direction: ltr">{{ number_format($Credit->Mony) }}</td>
                                        @endif

                                        <td>{{ $Credit->ModName }}</td>
                                        <td>{{ $Persian->MyPersianDate($Credit->Date) }}</td>
                                        <td>{{ $Credit->TransferBy }}</td>
                                        <td>
                                            @if ($Credit->indexname != null)
                                                {{ $Credit->indexname }}
                                            @else
                                                تعریف نشده
                                            @endif
                                        </td>
                                        <td>{{ $Credit->Note }}</td>
                                        <td>
                                            <a class="btn btn-success"
                                                href="{{ route('CrediteTransfer', ['ReferenceId' => $Credit->ID]) }}">مشاهده
                                                سند</a>
                                            <button type="submit" title="حذف قرارداد اجاره" class="btn btn-danger"
                                                name="delete_rent" value="{{ $Credit->bill }}"><i
                                                    class="nav-icon i-Close-Window"></i></button>

                                        </td>
                                    </tr>
                                @endforeach

                                @php
                                    $Rowno = 1;
                                @endphp
                                @foreach ($Credites as $Credit)
                                    <tr @if ($Credit->Mony < 0) class="table-row-danger" @endif>
                                        <td>{{ $Credit->ID }}</td>
                                        <td><a href="#" class="navbar-nav-link" data-toggle="dropdown"
                                                aria-expanded="false">
                                                {{ $Credit->name }}
                                            </a>

                                            <div class="dropdown-menu" style="text-align: right">
                                                <a target="_blank"
                                                    href="{{ route('UserReport', ['RequestUser' => $Credit->UserName]) }}"
                                                    class="dropdown-item">{{ __('User reports') }}</a>
                                                <div class="dropdown-divider"></div>
                                                <a target="_blank"
                                                    href="{{ route('UserProfile', ['RequestUser' => $Credit->UserName]) }}"
                                                    class="dropdown-item">{{ __('User edite') }}</a>
                                            </div>
                                        </td>
                                        @if (strlen($Credit->RealMony) != 0)
                                            <td style="direction: ltr">{{ number_format($Credit->Mony) }}
                                                <br>
                                                <div style="color: green">
                                                    دریافتی:
                                                    {{ number_format($Credit->RealMony) }}

                                                </div>
                                                <div style="color: red">
                                                    تخفیف:
                                                    {{ number_format($Credit->Mony - $Credit->RealMony) }}

                                                </div>
                                            </td>
                                        @else
                                            <td style="direction: ltr">{{ number_format($Credit->Mony) }}</td>
                                        @endif

                                        <td>{{ $Credit->ModName }}</td>
                                        <td>{{ $Persian->MyPersianDate($Credit->Date) }}</td>
                                        <td>{{ $Credit->TransferBy }}</td>
                                        <td>
                                            @if ($Credit->indexname != null)
                                                {{ $Credit->indexname }}
                                            @else
                                                تعریف نشده
                                            @endif
                                        </td>
                                        <td>{{ $Credit->Note }}</td>
                                        <td>
                                            @if ($Credit->CreditMod == \App\myappenv::ToPayCredit)
                                                <a data-toggle="modal" class="btn btn-primary"
                                                    onclick="requestorder('{{ number_format($Credit->Mony) }}' , `{{ $Credit->name }}` , `{{ $Credit->Note }}` ,'{{ route('selfpay', ['id' => $Credit->ID]) }}')"
                                                    style="color: white" title="نمایش"
                                                    data-target=".add-device-contract-modal"> <i
                                                        class="nav-icon i-Eye-Visible"></i> </a>
                                            @else
                                                <button type="submit" title="{{ __('Confirme transaction') }}"
                                                    class="btn btn-primary " name="Confirm"
                                                    value="{{ $Credit->ID }}"><i
                                                        class="nav-icon i-Data-Yes"></i></button>
                                            @endif

                                            <button type="submit" title="{{ __('delete transaction') }}"
                                                class="btn btn-danger" name="delete" value="{{ $Credit->ID }}"><i
                                                    class="nav-icon i-Close-Window"></i></button>
                                        </td>
                                    </tr>
                                @endforeach


                            </tbody>

                        </table>
                    </div>
                @else
                    @include('Layouts.nodata')
                @endif
            </div>
        </div>
    </form>
    <!-- Container-fluid Ends-->

@endsection
@section('page-js')
    <script>
        function requestorder(mony, name, note, link) {
            text = `<p>درخواست پرداخت از: ` + name + `</p>
                            <p>بابت: ` + note + `</p>
                            <p>مبلغ: ` + mony + ` ریال</p>
                            <p style="direction: ltr;text-align: left;">link: <input class='form-control' value="` +
                link + `" /></p>
                            <button class="btn btn-success">ارسال مجدد پیامک</button>`;

            $('#modal_body').html(text);
        }
    </script>
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

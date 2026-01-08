@php
    $Persian = new App\Functions\persian();
@endphp
@extends('Layouts.MainPage')
@section('page-header-left')
@endsection
@section('MainCountent')
    <input class="nested" id="main-menu" value="#Financials">
    <input class="nested" id="sub-menu" value="#CrediteTransfer">
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
                            @foreach ($zero_ref_src as $ServiceCredit)
                                <tr>
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

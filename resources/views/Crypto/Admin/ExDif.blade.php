@php
    $Persian = new App\Functions\persian();
@endphp
@extends('Layouts.MainPage')
@section('page-header-left')
@endsection

@section('MainCountent')
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-lg-6">
                    <div class="page-header-left">
                        <h3>عملیات رمز ارزها
                            <small>لیست</small>
                        </h3>
                    </div>
                </div>
                <div class="col-lg-6">
                    <ol class="breadcrumb pull-right">
                        @include('Layouts.AddressBar')
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Container-fluid Ends-->

    <!-- Container-fluid starts-->
    <div class="row">

        <!-- end of col-->

        <div id="table-continer" class=" col-md-12">
            <form method="post">
                <div class="card o-hidden mb-4">
                    <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                        <h3 id="Table-card-header" class="w-50 float-left card-title m-0">لیست رمز ارزها</h3>
                        <div class="dropdown dropleft text-right w-50 float-right">
                            <button class="btn bg-gray-100" type="button" id="dropdownMenuButton_table_1"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="nav-icon i-Gear-2"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton_table_1">
                                <button class="btn" name="submit" value="updatecurencys">به روز رسانی لیست
                                    ارزها</button>
                            </div>
                        </div>

                    </div>
                    <div class="card-body">


                        <form method="post">

                            @csrf
                            <div class="card-body">

                                <div class="table-responsive">
                                    <table id="ul-contact-list" class="{{ \App\myappenv::MainTableClass }}"
                                        style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>ایدی</th>
                                                <th>نام ارز</th>
                                                <th>سمبل</th>
                                                <th>Kucoin - Coinex</th>
                                                <th>وضعیت</th>
                                                <th>{{ __('Actions') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $Rowno = 1;
                                            @endphp
                                            @foreach ($Curencys as $CurencyItem)
                                            
                                                <tr>
                                                    <td>{{ $CurencyItem->id }} </td>
                                                    <td> <img height="20px" src="{{ $CurencyItem->pic }}" alt="NoPic"> {{ $CurencyItem->MainName }} </td>
                                                   
                                                    <td>{{ $CurencyItem->symbol }} </td>
                                                    <td>{{ round($CurencyItem->ku_co ,2) }} %</td>
                                                    <td>
                                                        @switch($CurencyItem->status)
                                                            @case(0)
                                                                <p style="color:orange"> ارز جدید</p>
                                                            @break
                                                            @case(10)
                                                                <p style="color:green"> ارز فعال</p>
                                                            @break
                                                            @case(20)
                                                                <p style="color:red"> ارز غیر فعال</p>
                                                            @break
                                                            @default
                                                        @endswitch
                                                    </td>
                                                    <td>
                                                        <a
                                                            href="{{ route('CurencyProfile', ['RequestCurency' => $CurencyItem->id]) }}">ویرایش</a>
                                                    </td>
                                                </tr>
                                            @endforeach

                                        </tbody>

                                    </table>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>

            </form>
        </div>
        <!-- end of col-->
    </div>
    <!-- Container-fluid Ends-->
@endsection
@section('page-js')
    <script>
        function selectalloptions() {
            $(".user-select").prop('checked', true);

        }

        function deselecttalloptions() {
            $(".user-select").prop('checked', false);
        }

        function multiselect() {
            $('#ul-contact-list').DataTable().destroy();
            $('.action-div').addClass('nested');
            $('.select-div').removeClass('nested');
            $('#multi-user-option').removeClass('nested');
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
    <script>
        $(document).ready(function() {
                    $("#L1").change(function() {
                        var num = this.value;
                        $("#L11").css("display", "none");
                    });
    </script>
@endsection

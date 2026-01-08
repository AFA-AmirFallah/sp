@php
$Persian = new App\Functions\persian();
@endphp
@extends("Layouts.MainPage")
@section('page-header-left')
@endsection
@section('MainCountent')
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-lg-6">
                    <div class="page-header-left">
                        <h3>جستجوی
                            <small>اسناد مالی</small>
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
    <form method="post">
        @csrf
        <div class="container-fluid">
            <div class="row product-adding">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                            <h5 class="text-white" ><i class="i-Receipt-3 header-icon"></i> جستجوی اسناد</h5>
                        </div>
                        <div class="card-body">
                            <div class="digital-add needs-validation">
                                <div class="row">
                                    <div class="col-xl-3 ">
                                        <label for="validationCustom01" class="col-form-label pt-0">کد سند</label>
                                        <input class="form-control" name="SanadID" id="validationCustom01" type="number">
                                    </div>

                                    <div class="col-xl-3">
                                        <label for="validationCustomtitle"
                                            class="col-form-label pt-0">{{ __('Register from date') }}</label>
                                        <input class="form-control" type="text" name="StartDate" autocomplete="off"
                                            onfocus="Mh1PersianDatePicker.Show(this,'{{ $Persian->MyPersianDate(date('Y-m-d'), false, 'n') }}',)"
                                            placeholder="{{ __('Register from date') }}" />

                                    </div>
                                    <div class="col-xl-3">
                                        <label for="validationCustomtitle"
                                            class="col-form-label pt-0">{{ __('Register to date') }}</label>
                                        <input class="form-control" type="text" name="EndDate" autocomplete="off"
                                            onfocus="Mh1PersianDatePicker.Show(this,'{{ $Persian->MyPersianDate(date('Y-m-d'), false, 'n') }}',)"
                                            placeholder="{{ __('Register to date') }}" />

                                    </div>
                                    <div style="text-align: left;" class="col-xl-3">
                                        <button type="submit" name="submit" value="primary"
                                            class="btn btn-primary">{{ __('Search') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </form>
    @if ($Result != null)
        <div class="table-responsive">
            <table id="ul-contact-list" class="{{ \App\myappenv::MainTableClass }}" style="width:100%">
                <thead>
                    <tr>
                        <th>کد سند</th>
                        <th>توضیح سند</th>
                        <th>عملیات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($Result as $ResultItem)
                        <tr>
                            <td>{{ $ResultItem->ID }}</td>
                            <td>{{ $ResultItem->Note }}</td>
                            <td><a href="{{route('CrediteTransfer',['ReferenceId'=>$ResultItem->ID])  }}" target="blank">نمایش</a></td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    @endif
@endsection
@section('page-js')
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

    <script src="{{ url('/') }}/persian-datepicker/Mh1PersianDatePicker.js"></script>
@endsection

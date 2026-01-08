@php
$Persian = new App\Functions\persian();
@endphp
@extends("Layouts.CustomerMainPage")
@section('Header')
    <link rel="stylesheet" type="text/css" href="{{ url('/') }}/assets/css/bootstrap-clockpicker.min.css">
@endsection
@section('before-css')
    <link rel="stylesheet" href="{{ asset('assets/styles/vendor/smart.wizard/smart_wizard.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/styles/vendor/smart.wizard/smart_wizard_theme_arrows.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/styles/vendor/smart.wizard/smart_wizard_theme_circles.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/styles/vendor/smart.wizard/smart_wizard_theme_dots.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/styles/vendor/dropzone.min.css') }}">
@endsection
@section('page-header-left')
@endsection
@section('MainCountent')
    <input class="nested" id="confirmcode">
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="pwa_h1_title">{{ $catorder->Cat }}
                        <h2 class="pwa_h2_title">ثبت درخواست {{ $catorder->Cat }}</h2>
                    </h1>
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

        <div id="ConfirmCodeDiv" class="card nested">
            <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                ثبت کد تایید
            </div>
            <div class="card-body ">
                <p>لطفا جهت ثبت درخواست کد تائیده دریافتی را وارد فرمائید:</p>
                <input type="number" id="ConfirmCodeInput" required name="ConfirmCode" class="form-control"
                    style="margin-top: 10px" placeholder="کد تائیدیه" autocomplete="off" value=""
                    onkeyup="CheckConfrmCode()">
                <hr>
                <div id="FinalSubmit" class="nested">
                    <button type="submit" name="submit" value="customeradd" style="margin-bottom: 10px"
                        class="btn btn-primary"> ثبت درخواست
                    </button>

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <!-- SmartWizard html -->
                <div id="smartwizard">
                    <ul>
                        <li><a href="#step-1"><div class="pwa_stepper_number">1</div></a></li>
                        <li><a href="#step-2"><div class="pwa_stepper_number">2</div></a></li>
                        <li><a href="#step-3"><div class="pwa_stepper_number">3</div></a></li>
                    </ul>
                    <div>
                        <div id="step-1" style="text-align: justify">
                            <h3 class="border-bottom border-gray pb-2">شرایط و توضیحات ارائه خدمت</h3>
                            مجموعه شفاتل با در اختیار داشتن سامانه جامع مدیریت خدمات سلامت HCIS به عنوان تسهیل گر سلامت
                            درخواست شما را به مراکز دارای مجوز از وزارت بهداشت درمان و آموزش پزشکی ارائه می نماید و
                            مراکز
                            طرف قرارداد شفاتل بر اساس نوع درخواست شما عزیزان نسبت به ارائه خدمت اقدام خواهد نمود.
                            شفاتل در کنار مشتریان و بیماران محترم نسبت به ارائه خدمت نظارت داشته و حامی بیماران و
                            مشتریان
                            عزیز خواهد بود.
                            خواهشمند است به هیج عنوان با مراکز ارائه دهنده خدمت خارج از مجموعه شفاتل مراوده ای نداشته و
                            تمام
                            درخواست ها و پرداخت های خود را از طریق سایت و سامانه های شفاتل به انجام رسانید.
                            <hr>

                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="ul-product-detail__image">
                                                <img src="{{ $catorder->Pic }}" alt="{{ $catorder->Cat }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="ul-product-detail__brand-name mb-4">
                                                <h5 class="heading">{{ $catorder->Cat }}</h5>
                                                <span class="text-mute">{{ $catorder->TitleDescription }}</span>
                                            </div>
                                            <div class="ul-product-detail__features mt-3">
                                                {!! $catorder->MainDescription !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="step-2" class="">
                            <div class="form-group row" style="margin-right: 10px; margin-left: 10px;">
                                <label class="col-xl-3 col-md-4" style="text-align: right;margin-top: 10px"> زمان
                                    پیشنهادی
                                    شروع خدمت </label>
                                <div class="input-group col-xl-4 col-md-4">
                                    <input class="form-control" type="text" name="StartDate" id="InputStartDate"
                                        style="margin-top: 10px" autocomplete="off" onchange="SetServiceDate()"
                                        onfocus="Mh1PersianDatePicker.Show(this,'{{ $Persian->MyPersianDate(date('Y-m-d'), false, 'n') }}',)"
                                        placeholder="تاریخ شروع خدمت" />
                                </div>
                            </div>
                            <div class="form-group row" style="margin-right: 10px; margin-left: 10px;">
                                <label class="col-xl-3 col-md-4" style="text-align: right;margin-top: 10px"> شماره موبایل
                                    گیرنده
                                    خدمت</label>
                                <div class="input-group col-xl-4 col-md-4">
                                    <input type="number" id="mobilenumber" required name="mobilenumber" class="form-control"
                                        style="margin-top: 10px" placeholder="{{ __('Mobile No') }}" autocomplete="off"
                                        value="" onkeyup="ChangeName()">
                                </div>
                            </div>
                            <div class="form-group row" style="margin-right: 10px; margin-left: 10px;">
                                <label class="col-xl-3 col-md-4" style="text-align: right;margin-top: 10px"> نام گیرنده
                                    خدمت</label>
                                <div class="input-group col-xl-4 col-md-4">
                                    <input type="text" id="namefeild" name="Name" class="form-control"
                                        style="margin-top: 10px" placeholder="{{ __('Name') }}" autocomplete="off"
                                        value="" onkeyup="ChangeName()">
                                </div>
                            </div>
                            <div class="form-group row" style="margin-right: 10px; margin-left: 10px;">
                                <label class="col-xl-3 col-md-4" style="text-align: right;margin-top: 10px"> نام خانوادگی
                                    گیرنده
                                    خدمت</label>
                                <div class="input-group col-xl-4 col-md-4">
                                    <input class="form-control" type="text" name="Family" id="familyfeild"
                                        style="margin-top: 10px" autocomplete="off" placeholder="{{ __('Family') }}"
                                        onkeyup="ChangeName()" />
                                </div>
                            </div>
                            <div class="form-group row" style="margin-right: 10px; margin-left: 10px;">
                                <label class="col-xl-3 col-md-4" style="text-align: right;margin-top: 10px">محل انجام
                                    خدمت</label>
                                <div class="form-group  col-xl-8 col-md-8" style="text-align: right">
                                    <textarea id="َAddressLocation" name="Address" class="form-control" rows="3"
                                        onchange="SetAddress()" value=""></textarea>
                                    <small style="text-align: right">آدرس دقیق محل خدمت</small>
                                </div>
                            </div>
                            <div class="form-group row" style="margin-right: 10px; margin-left: 10px;">
                                <label class="col-xl-3 col-md-4" style="text-align: right;margin-top: 10px">توضیحات</label>
                                <div class="form-group  col-xl-8 col-md-8" style="text-align: right">
                                    <textarea id="ExteraNote" name="ADDExtranote" class="form-control" rows="3"
                                        onchange="SetExteraNote()" value=""></textarea>
                                    <small style="text-align: right"> مواردی که لازم است سوپروایزر در جریان قرار گیرد را
                                        جهت
                                        بهبود خدمت رسانی ذکر بفرمایید!</small>
                                </div>
                            </div>
                        </div>
                        <div id="step-3" class="">
                            <h3 class="border-bottom border-gray pb-2">ثبت و ارسال درخواست برای مراکز وابسته</h3>
                            <div class="card o-hidden" style="text-align: right">
                                <div class="card-header gradient-purple-indigo 0-hidden pb-80">جزئیات درخواست</div>
                                <div class="card-block p-0">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <th>نام بیمار</th>
                                                @if (\Illuminate\Support\Facades\Auth::check())
                                                    <td>{{ Auth::user()->Name }} {{ Auth::user()->Family }}</td>
                                                @else
                                                    <td>
                                                        <div id="NameFamily"></div>
                                                    </td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <th>خدمت / کالای درخواستی</th>
                                                <td> {{ $catorder->Cat }}</td>
                                            </tr>
                                            <tr>
                                                <th>زمان پشنهادی</th>
                                                <td id="PreferDateTime"></td>
                                            </tr>
                                            <tr>
                                                <th>محل ارائه خدمت</th>
                                                <td id="ServiceAddress"></td>
                                            </tr>
                                            <tr>
                                                <th>توضیحات</th>
                                                <td id="ServiceNote"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <hr>
                                    <div style="margin-top: 10px;text-align: center">
                                        <div id="Presubmit">
                                            <button type="button" style="margin-bottom: 10px" class="btn btn-primary"
                                                onclick="ConfirInputData()">
                                                تایید درخواست
                                            </button>

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </form>


@endsection
@section('page-js')

    <script src="{{ url('/') }}/persian-datepicker/Mh1PersianDatePicker.js"></script>
    <script>
        $("#prev-btn").on("click", function() {
            alert('fdf');
            $('#smartwizard').smartWizard("prev");
            return true;
        });

        $(document).ready(function() {
            $('.serviceselect').select2();
        });
    </script>
    <script type="text/javascript" src="{{ url('/') }}/assets/js/bootstrap-clockpicker.min.js"></script>
    <script type="text/javascript">
        $('.clockpicker').clockpicker({
            placement: 'top',
            align: 'left',
            donetext: 'ثبت'
        });
    </script>
    <script src="{{ asset('assets/js/dropzone.script.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/jquery.smartWizard.order.min.js') }}"></script>
    <script src="{{ asset('assets/js/smart.wizard.script.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/dropzone.min.js') }}"></script>
    <script>
        function confirmOrder() {
            mobilenumber = $("#mobilenumber").val();
            if (mobilenumber.length != 11 || mobilenumber.substr(0, 2) != '09') {
                alert('شماره موبایل وارد شده اشتباه است');
                $("#mobilenumber").addClass('is-invalid');
                return false;
            } else if ($("#InputStartDate").val() == '') {
                $("#mobilenumber").removeClass('is-invalid');
                $("#InputStartDate").addClass('is-invalid');
                alert('لطفا زمان مد نظر خود را وارد فرمایید');
                return false;
            } else if ($("#َAddressLocation").val() == '') {
                $("#mobilenumber").removeClass('is-invalid');
                $("#InputStartDate").removeClass('is-invalid');
                $("#InputStartDate").removeClass('is-invalid');
                $("#َAddressLocation").addClass('is-invalid');
                alert('آدرس وارد نشده است!');
                return false;
            } else if ($("#namefeild").val() == '') {
                $("#mobilenumber").removeClass('is-invalid');
                $("#InputStartDate").removeClass('is-invalid');
                $("#InputStartDate").removeClass('is-invalid');
                $("#َAddressLocation").removeClass('is-invalid');
                $("#namefeild").addClass('is-invalid');
                alert('نام وارد نشده است')
                return false;
            } else if ($("#familyfeild").val() == '') {
                $("#mobilenumber").removeClass('is-invalid');
                $("#InputStartDate").removeClass('is-invalid');
                $("#InputStartDate").removeClass('is-invalid');
                $("#َAddressLocation").removeClass('is-invalid');
                $("#namefeild").removeClass('is-invalid');
                $("#familyfeild").addClass('is-invalid');
                alert('نام خانوادگی وارد نشده است');
                return false;
            } else {
                return true;
            }

        }

        function ConfirInputData() {
            $("#ConfirmCodeDiv").removeClass('nested');
            $("#Presubmit").addClass('nested');
            $("#smartwizard").addClass('nested');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('<?php echo e(route('ajax')); ?>', {
                    AjaxType: 'SendConfirmCodeSMS',
                    MobileNumber: $("#mobilenumber").val(),
                },

                function(data, status) {
                    $("#confirmcode").val(data);
                    //alert(data); //todo: remove
                });

        }

        function ChangeName() {
            $('#NameFamily').html($('#namefeild').val() + '  ' + $('#familyfeild').val());
        }

        function SetExteraNote() {
            $('#ServiceNote').html(document.getElementById("ExteraNote").value);
        }

        function SetAddress() {
            $('#ServiceAddress').html(document.getElementById("َAddressLocation").value);
        }

        function SetServiceDate() {
            $('#PreferDateTime').html(document.getElementById("InputStartDate").value);
        }

        function imageupdloader() {
            $('#imguploadinput').trigger('click');
        }

        function CheckConfrmCode() {
            if ($("#confirmcode").val() == $("#ConfirmCodeInput").val()) {
                $("#FinalSubmit").removeClass('nested');
            } else {
                $("#FinalSubmit").addClass('nested');
            }

        }

        function ChangeImage() {
            alert('image changed');

            $('#ServiceDocuments').attr('src', $('#useravatar').attr('src'));

        }

        function cancelimagechange() {
            $('#useravatar').attr('src', '');
            $('#ServiceDocuments').attr('src', '');
            $('#savebutton').addClass('nested');
            $('#changebutton').removeClass('nested');
            $('#canclebutton').addClass('nested');

        }

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#useravatar').attr('src', e.target.result);
                    $('#ServiceDocuments').attr('src', e.target.result);
                    $('#savebutton').removeClass('nested');
                    $('#changebutton').addClass('nested');
                    $('#canclebutton').removeClass('nested');

                }

                reader.readAsDataURL(input.files[0]); // convert to base64 string
            }
        }
    </script>


@endsection

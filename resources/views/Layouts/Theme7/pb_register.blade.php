@php
    $Persian = new App\Functions\persian();
@endphp

@extends('Layouts.Theme7.layout.main_layout')
@section('content')
    <div class="section-full content-inner-2 browse-job">
        <div class="container">
            <h1 class="form-header">ایجاد حساب کاربری درمانگران - پرستاران</h1>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="personal" role="tabpanel" aria-labelledby="tabPersonal">
                    <div class="job-bx bg-white">
                        <div class="confirm_code row ">
                            @if ($step == 3)
                                <div id="confirm-code" class="col-lg-8">
                                    <div>
                                        <h1 class="mb-3 text-18 " style="text-align: center;">

                                            <hr>شما در سامانه ثبت نام کرده‌اید!
                                        </h1>
                                        <form method="post">
                                            @csrf
                                            <div class="form-group ">
                                                <label class="text-18" for="UserName"
                                                    style="float: right;text-align:right">شماره شما در سامانه ثبت می باشد
                                                    جهت ورود به سامانه از صفحه ورود استفاده کنید </label>
                                                <br>

                                            </div>
                                            <p style="text-align: center" class="explaintext" id="CountDownP"></p>
                                            <a href="{{ route('login') }}"
                                                class=" btn btn-rounded btn-primary btn-block mt-2 ">ورود</a>

                                        </form>
                                    </div>
                                    <hr>

                                </div>
                            @endif

                            @if ($step == 2)
                                <div id="confirm-code" class="col-lg-8">
                                    <div>
                                        <form method="post">
                                            @csrf
                                            <div class="form-group ">
                                                <label class="text-18" for="UserName" style="float: right;text-align:right">
                                                    کد یکبارمصرف به شماره موبایل شما ارسال شد.</label>
                                                <br>
                                                <input autocomplete="off" required name="Password" inputmode="numeric"
                                                    id="confirmcode" placeholder="کد را وارد کنید"
                                                    class="input-border form-control form-control-rounded">

                                            </div>
                                            <p style="text-align: center" class="explaintext" id="CountDownP"></p>
                                            <button id="OneStep_1btn" type="submit" name="submit" value="login"
                                                class=" btn btn-rounded btn-primary btn-block mt-2 ">ثبت و ادامه</button>

                                        </form>
                                    </div>
                                    <hr>

                                </div>
                            @endif
                            @if ($step == 1)
                                <div id="input_data" class="col-lg-8">
                                    <form id="input_data_form" method="POST" class="job-alert-bx">
                                        @csrf
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>نام <span class="text-danger">*</span> </label>
                                                    <input class=" input-border form-control" id="Name" name="Name"
                                                        placeholder="نام  خود را وارد کنید" type="text">
                                                    <div class="invalid-feedback">نام خود را با فارسی وارد کنید</div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>نام خانوادگی <span class="text-danger">*</span></label>
                                                    <input class="input-border form-control" name="Family" id="family"
                                                        placeholder="نام خانوادگی خود را وارد کنید" type="text">
                                                    <div class="invalid-feedback"> نام خانوادگی خود را به فارسی وارد کنید
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>جنسیت <span class="text-danger">*</span></label>
                                                    <select class="form-control" name="sex" id="sex">
                                                        <option value="f">خانم</option>
                                                        <option value="m">آقا</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>شماره موبایل <span class="text-danger">*</span></label>
                                                    <input class="input-border form-control" inputmode="numeric"
                                                        id="mobile_no" name="mobile_no" placeholder="09121234567"
                                                        type="text">
                                                    <div class="invalid-feedback"> شماره موبایل خود را به صورت صحیح وارد
                                                        کنید
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>ایمل</label>
                                                    <input class="input-border form-control" inputmode="email"
                                                        id="email" name="email" placeholder="name@domain.com"
                                                        type="email">
                                                    <div class="invalid-feedback"> ایمیل خود را به صورت صحیح وارد
                                                        کنید
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>کد ملی <span class="text-danger">*</span></label>
                                                    <input class="input-border form-control" inputmode="numeric"
                                                        name="melli_id" id="melli_id" placeholder="کد ملی ۱۰ رقمی"
                                                        type="text">
                                                    <div class="invalid-feedback"> کد ملی خود را به صورت صحیح وارد کنید
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>تحصیلات <span class="text-danger">*</span></label>
                                                    <select class="form-control" name="education" id="education">
                                                        <option value="0">{{ __('--select--') }}</option>
                                                        @foreach (App\Users\UserClass::get_education_all() as $edu_item)
                                                            <option value="{{ $edu_item->educationID }}">
                                                                {{ $edu_item->educationName }}</option>
                                                        @endforeach
                                                    </select>
                                                    <div class="invalid-feedback">لطفا تحصیلات خود را مشخص کنید</div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>تخصص <span class="text-danger">*</span></label>
                                                    <select class="form-control" name="expertin" id="expertin">
                                                        <option value="0">{{ __('--select--') }}</option>
                                                        <option value="1">پزشک</option>
                                                        <option value="2">پرستار</option>
                                                        <option value="3">فیزیوتراپ/کاردرمان</option>
                                                        <option value="4">روانشناس</option>
                                                        <option value="5">بهیار</option>
                                                        <option value="6">مراقب</option>
                                                        <option value="7">همدم</option>
                                                    </select>
                                                    <div class="invalid-feedback">لطفا تخصص خود را مشخص کنید</div>

                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>استان محل سکونت <span class="text-danger">*</span></label>
                                                    <select name="Province" id="Province"
                                                        onchange="LoadCitys(this.value)"
                                                        class="input-border form-control">
                                                        <option value="0">{{ __('--select--') }}</option>
                                                        @foreach ($province as $province_item)
                                                            <option value="{{ $province_item->id }}">
                                                                {{ $province_item->ProvinceName }}</option>
                                                        @endforeach
                                                    </select>
                                                    <div class="invalid-feedback">لطفا استان محل سکونت را مشخص کنید</div>

                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>شهر محل سکونت <span class="text-danger">*</span></label>
                                                    <select class="input-border form-control" id="Shahrestan_select"
                                                        name="Saharestan">
                                                    </select>
                                                    <div class="invalid-feedback"> لطفا شهرستان محل سکونت خود را مشخص کنید</div>

                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="input-border custom-control-input"
                                                            id="job-alert-check" name="job-alert-check">
                                                        <label id="terms" class="custom-control-label"
                                                            for="job-alert-check">من
                                                            با شرایط و ضوابط موافقم</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 text-center">
                                                <button id="pre_save_btn" type="button" onclick="next_step()"
                                                    class="site-button">ارسال کد یکبار مصرف</button>
                                                <button id="save_btn" type="submit" class="site-button d-none">ثبت فرم
                                                    و ارسال
                                                    کد</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            @endif
                            <div class="col-lg-4 bg-gray">
                                <div class="p-a25">
                                    <h6 style="font-weight: 800">چرا باید عضو پرستاربانک شوم؟</h6>
                                    <ul class="list-check primary">
                                        <li style="text-align: justify">رزومه شما در اختیار تمامی مراکز درمانی و مراقبتی
                                            همکار با ما قرار می گیرد.</li>
                                        <li style="text-align: justify">پیشنهادهای کاری را مستقیماً در حساب کاربری خود
                                            مشاهده کنید.</li>
                                        <li style="text-align: justify">با جدیدترین به روزرسانی ها ازبازخورد بیماران خود
                                            مطلع باشید.</li>
                                    </ul>
                                    <div class="dez-divider bg-gray-dark"></div>
                                    <h6 style="font-weight: 800" class="font-14">ثبت نام در پرستاربانک یک اعتبار برای
                                        شماست.</h6>
                                    <p style="text-align: justify" class="m-b10">برای بیماران و خانواده‌ها،نوع عملکرد شما
                                        مهم است.</p>
                                    <p style="text-align: justify" class="m-b10">برای مراکز، تجربیات کاری شما ملاک
                                        استخدام و پرداخت است.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <script>
        function validator() {
            $('#terms').removeClass('text-danger');
            confirm = $('#job-alert-check').prop('checked');
            if (!confirm) {
                alert('جهت ثبت مشاهده می باید شرایط و مقررات سایت را بپذیرید!');
                $('#terms').addClass('text-danger');
                return false;
            }
            valid = true;
            Province = $('#Province').val();
            if (Province == 0) {
                valid = false;
                $('#Province').addClass('is-invalid');
            } else {
                $('#Province').addClass('is-valid');
            }
            Shahrestan_select = $('#Shahrestan_select').val();
            if (Shahrestan_select == null || Shahrestan_select == 0) {
                valid = false;
                $('#Shahrestan_select').addClass('is-invalid');
            } else {
                $('#Shahrestan_select').addClass('is-valid');
            }
            expertin = $('#expertin').val();
            if (expertin == null || expertin == 0) {
                valid = false;
                $('#expertin').addClass('is-invalid');
            } else {
                $('#expertin').addClass('is-valid');
            }
            education = $('#education').val();
            if (education == null || education == 0) {
                valid = false;
                $('#education').addClass('is-invalid');
            } else {
                $('#education').addClass('is-valid');
            }
            name = $('#Name').val();
            if (name == '') {
                valid = false;
                $('#Name').addClass('is-invalid');
            } else {
                $('#Name').addClass('is-valid');
            }
            family = $('#family').val();
            if (family == '') {
                valid = false;
                $('#family').addClass('is-invalid');
            } else {
                $('#family').addClass('is-valid');
            }
            mobile_no = $('#mobile_no').val();
            if (mobile_no.length != 11) {
                valid = false;
                $('#mobile_no').addClass('is-invalid');
            } else {
                $('#mobile_no').addClass('is-valid');
            }
            melli_id = $('#melli_id').val();
            if (melli_id.length != 10) {
                valid = false;
                $('#melli_id').addClass('is-invalid');
            } else {
                $('#melli_id').addClass('is-valid');
            }
            if (valid) {
                return true;
            }
            return false;


        }

        // Passing a named function instead of an anonymous function.


        function next_step() {
            if (validator()) {
                //$('#input_data').addClass('d-none');
                //$('#confirm-code').removeClass('d-none');
                $('#pre_save_btn').addClass('d-none');
                $('#save_btn').removeClass('d-none');
                document.getElementById('input_data_form').submit();
                counter();
            }
        }

        @if ($step == 2)
            // Set the date we're counting down to
            var countDownDate = new Date().getTime() + 180000;

            // Update the count down every 1 second
            var x = setInterval(function() {

                // Get today's date and time
                var now = new Date().getTime();

                // Find the distance between now and the count down date
                var distance = countDownDate - now;

                // Time calculations for days, hours, minutes and seconds
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                // Display the result in the element with id="CountDownP"
                document.getElementById("CountDownP").innerHTML = "ارسال مجدد کد تا  " + seconds + " : " + minutes +
                    " دیگر";

                // If the count down is finished, write some text
                if (distance < 0) {
                    clearInterval(x);
                    document.getElementById("CountDownP").innerHTML = "اتمام زمان";
                    $("#OneStep_1btn").attr('value', 'resend');
                    $("#OneStep_1btn").html('ارسال مجدد');
                    $("#confirmcode").prop('disabled', true);

                }
            }, 1000);
        @endif
    </script>
    <script>
        function LoadCitys($ProvinceCode) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('/ajax', {
                    AjaxType: 'GetCitysOfProvinces',
                    ProvinceCode: $ProvinceCode,
                },

                function(data, status) {
                    $("#Shahrestan_select").empty();
                    $("#Shahrestan_select").append(data);
                    $("#Shahrestan_select").selectpicker("refresh");
                });
        }
    </script>
@endsection
@section('page-js')
    <script>
        $(document).ready(function() {

        });
    </script>
@endsection

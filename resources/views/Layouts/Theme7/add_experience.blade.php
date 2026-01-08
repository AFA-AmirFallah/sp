@extends('Layouts.Theme7.layout.main_layout')
@section('content')
    <div class="modal fade modal-bx-info" id="exampleModalLong" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="logo-img">
                        <img alt="" src="/Theme7/images/favicon.png">
                    </div>
                    <h5 class="modal-title">
                         قوانین سایت
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {!!\App\Http\Controllers\setting\SettingManagement::GetSettingValue('BuyCondition')??''!!}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">بستن</button>
                </div>
            </div>
        </div>
    </div>
    <div class="section-full content-inner-2 browse-job">
        <div class="container">
            <h1 class="form-header">فرم نظرسنجی کاربران</h1>
            <div class="tab-content" id="myTabContent">
                <form>
                    <div class="tab-pane fade show active" id="personal" role="tabpanel" aria-labelledby="tabPersonal">
                        <div class="job-bx bg-white">
                            <div class="row">
                                <div class="col-lg-8">
                                    <div style="display: contents" class="row">
                                        <div id="comment_div">
                                            <div class="col-lg-12">
                                                <div class="form-group ">
                                                    <label> نام و نام خانوادگی درمانگر / پرستار :<span
                                                            class="reqired">*</span>
                                                    </label>
                                                    <input class="input-border form-control persian_limit" required
                                                        name="Name" id="Name"
                                                        placeholder=" نام درمانگر / پرستار را وارد کنید" type="text">
                                                    <div class="invalid-feedback"> نام درمانگر / پرستار می باید وارد شود.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label>خدمت دریافتی:<span class="reqired">*</span></label>
                                                    <input class="input-border form-control persian_limit" required
                                                        name="service" id="service" placeholder="مثال: وصل سرم" type="text">
                                                    <div class="invalid-feedback">نام خدمت ارائه شده می باید وارد گردد.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label>تلفن همراه پرستار - کد پرستار بانک درمانگر / پرستار:<span
                                                            class="reqired">*</span></label>
                                                    <input class="input-border form-control number_only" required
                                                        inputmode="numeric" name="MobileNo" id="MobileNo"
                                                        placeholder="09122233203" type="text">
                                                    <div class="invalid-feedback">شماره همراه یا کد پرستار بانک می باید وارد
                                                        شود</div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label>نام مرکز ارائه کننده خدمت:</label>
                                                    <input class="input-border form-control persian_limit"
                                                        name="center_name" id="center_name" placeholder="مثال: مرکز پرستاری امید "
                                                        type="text">
                                                    <div class="invalid-feedback">در صورتی که از مرکز خدماتی خدمت گرفته اید
                                                        نام
                                                        مرکز را وارد نمائید.</div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label>متن گزارش: <span class="reqired">*</span></label>
                                                    <textarea class="input-border form-control persian_limit" style="height:230px;" name="comment" rows="4"
                                                        id="comment" placeholder="نظرتان را به سایر بیماران بگوئید"></textarea>
                                                    <div class="invalid-feedback">متن گزارش می باید وارد شود!</div>
                                                    <small>تجربه شخصی یا مشاهدات خود رااینجا بنویسید.</small>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="input-border form-group">
                                                    <label class="is-invalid">میزان رضایت شما از خدمات دریافتی :<span
                                                            class="reqired">*</span></label>
                                                    <div style="margin-right: 10px;">
                                                        <div>
                                                            <input type="radio" class="index_1 " name="index_1"
                                                                value="5">
                                                            <label>عالی</label>
                                                        </div>
                                                        <div>
                                                            <input type="radio" class="index_1" name="index_1"
                                                                value="4">
                                                            <label>خوب</label>
                                                        </div>
                                                        <div>
                                                            <input type="radio" class="index_1" name="index_1"
                                                                value="3">
                                                            <label>نسبتا خوب</label>
                                                        </div>
                                                        <div>
                                                            <input type="radio" class="index_1" name="index_1"
                                                                value="2">
                                                            <label>بد</label>
                                                        </div>
                                                        <div>
                                                            <input type="radio" class="index_1" name="index_1"
                                                                value="1">
                                                            <label>خیلی بد</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <ul class="nav nav-tabs">
                                                    <li class="nav-item active"><a class="nav-link active "
                                                            data-toggle="tab" href="#posetive">نقاط مثبت</a></li>
                                                    <li class="nav-item "><a class="nav-link " data-toggle="tab"
                                                            href="#negative">نقاط منفی</a></li>

                                                </ul>

                                                <div class="input-border tab-content">
                                                    <div id="posetive" class="tab-pane fade in active show">
                                                        @foreach ($hiring->get_positive_index() as $index)
                                                            <a id="{{ $index->UID }}"
                                                                href="javascript:active_item('#{{ $index->UID }}')"
                                                                class="comment-items positive-item">{{ $index->Name }}</a>
                                                        @endforeach

                                                    </div>

                                                    <div id="negative" class="tab-pane fade">
                                                        @foreach ($hiring->get_negative_index() as $index)
                                                            <a id="{{ $index->UID }}"
                                                                href="javascript:active_item('#{{ $index->UID }}')"
                                                                class="comment-items negative-item">{{ $index->Name }}</a>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>

                                            <script>
                                                function active_item(item) {
                                                    $(item).toggleClass('active');
                                                }
                                            </script>
                                            <div style="margin: 20px 0px 20px 0px">
                                                <div class="col-lg-12 d-none">
                                                    <div class="form-group">
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input"
                                                                id="call_allow" name="call_allow">
                                                            <label class="custom-control-label" for="call_allow">در
                                                                صورت نیاز کارشناسان پرستاربانک با من تماس بگیرند.</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input"
                                                                id="recommend" name="recommend">
                                                            <label class="custom-control-label" for="recommend">این
                                                                درمانگر /
                                                                پرستار را
                                                                به دیگران توصیه میکنم.</label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input"
                                                                id="show_info" name="show_info">
                                                            <label class="custom-control-label" for="show_info">نام من
                                                                نمایش
                                                                داده
                                                                نشود.</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="custom-control ">
                                                    <p>ثبت نظر و تجربه به معنای موافقت با<a href="javascript:void"
                                                        
                                                        data-toggle="modal" style="color: blue"  data-target="#exampleModalLong">
                                                        قوانین سایت</a> 
                                                        است</p>
                                                </div>
                                            </div>
                                            @if (Auth::check())
                                                <div class="col-lg-12 text-center">
                                                    <button type="button" onclick="pre_save()" class="site-button">ثبت
                                                        تجربه</button>
                                                </div>
                                            @else
                                                <div class="col-lg-12 text-center">
                                                    <button type="button" onclick="reg_and_pre_save()"
                                                        class="site-button">رجیستر و ثبت تجربه</button>
                                                </div>
                                            @endif
                                        </div>

                                        @if (!Auth::check())
                                            @include('Layouts.Theme7.layout.non_auth_info_for_exp')
                                        @endif

                                        <div
                                            style="display: block;
                                        width: 33px;
                                        height: 25px;">
                                        </div>

                                    </div>
                                </div>
                                <div class="col-lg-4 bg-gray">
                                    <div class="p-a25">
                                        <div>
                                            <h6>شما با ثبت تجربیات خود در پرستار بانک باعث:</h6>
                                            <ul class="list-check primary">
                                                <li>کمک به ارتقا کیفیت خدمت رسانی در منزل</li>
                                                <li>راهنمایی دیگران در انتخاب درمانگر / پرستار </li>
                                                <li>تشویق نیروهای با انگیزه و کارآمد</li>
                                                <li>ارجاع تخلفات ثبت شده به مراجع ذی‌صلاح</li>
                                            </ul>
                                        </div>

                                        <div class="dez-divider bg-gray-dark"></div>
                                        <div>
                                            <h6 class="font-14">اساس کار پرستار بانک، انصاف و صداقت است.</h6>
                                            <p style="text-align: justify">تجربیات شما برای ما ارزشمند است و ثبت آنها
                                                در سامانه پرستار بانک موجب راهنمائی و کمک به دیگران در انتخاب درست خواهد شد.
                                                لذا
                                                خواهشمندیم انصاف و صداقت را در
                                                بیان نظرات خود رعایت فرمائید.</p>
                                            <p class="m-b10"> کارشناسان
                                                ما پس از بازبینی، تجربیات شما را منتشر خواهند کرد.</p>
                                            <img src="https://parastarbank.com/storage/photos/پرستاربانک/ethic11.jpg"
                                                alt="">
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <script>
        function reg_and_pre_save() {
            switch_page = pre_save();
            if (switch_page) {
                $('#comment_div').addClass('d-none');
                $('#user_submiter_info').removeClass('d-none');
            }

        }

        function check_catptcha() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('', {
                    function: 'send_otp',
                    code: $('#MobileNo').val(),
                    captcha: $('#captcha').val(),
                },
                function(data, status) {
                    if (data['result']) {
                        $('#myTabContent').html(data['data']);

                        return true;

                    } else {
                        refresh_captcha();
                        alert('اختلالی در سامانه به وجود آمده است لطفا دقایقی دیگر تلاش کنید!');
                        return false;
                    }
                });
        }

        function send_otp() {

            user_MobileNo = $('#user_MobileNo').val();
            if (user_MobileNo.length == 0) {
                alert('شماره تلفن همراه خود را وارد فرمائید!');
                return false;
            }
            if (isNaN(user_MobileNo)) {
                alert('شماره تلفن همراه می باید مقدار عددی باشد!');
                return false;
            }
            if (user_MobileNo.length != 11) {
                alert('طول شماره تلفن همراه می باید ۱۱ کارکتر باشد!');
                return false;
            }
            if (!user_MobileNo.startsWith('09')) {
                alert('فرمت شماره تلفن همراه اشتباه است!');
                return false;
            }
            captcha_str = $('#captcha').val();
            if (captcha_str.length != 5) {
                alert('کد امنیتی را به درستی وارد کنید!');
                return false;
            }
            pre_save_val = pre_save();
            if (pre_save_val) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.post('', {
                        function: 'send_otp',
                        Mobile_no: user_MobileNo,
                        captcha: $('#captcha').val(),
                    },
                    function(data, status) {
                        if (data['result']) {
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
                                $("#send_otp_btn").html = "ارسال مجدد کد تا  " +
                                    seconds + " : " + minutes +
                                    " دیگر";

                                // If the count down is finished, write some text
                                if (distance < 0) {
                                    clearInterval(x);
                                    document.getElementById("CountDownP").innerHTML = "اتمام زمان";
                                    $("#OneStep_1btn").attr('value', 'GetPass');
                                    $("#OneStep_1btn").html('ارسال مجدد');
                                    $("#confirmcode").prop('disabled', true);

                                }
                            }, 1000);

                        } else {
                            alert(data['msg']);
                            return false;
                        }
                    });
            }
            return false;
        }

        function reg_user_validation() {
            valid = true;

            ceckfield = $('#user_Name').val();
            if (ceckfield.length < 2) {
                valid = false;
                $('#user_Name').addClass('is-invalid');
            } else {
                $('#user_Name').addClass('is-valid');
            }
            ceckfield = $('#user_Family').val();
            if (ceckfield.length < 2) {
                valid = false;
                $('#user_Family').addClass('is-invalid');
            } else {
                $('#user_Family').addClass('is-valid');
            }
            user_MobileNo = $('#user_MobileNo').val();
            if (user_MobileNo.length == 0) {
                $('#user_MobileNo').addClass('is-invalid');
                alert('شماره تلفن همراه خود را وارد فرمائید!');
                return false;
            } else {
                $('#user_MobileNo').addClass('is-valid');
            }
            if (isNaN(user_MobileNo)) {
                alert('شماره تلفن همراه می باید مقدار عددی باشد!');
                $('#user_MobileNo').addClass('is-invalid');
                return false;
            } else {
                $('#user_MobileNo').addClass('is-valid');
            }
            if (user_MobileNo.length != 11) {
                alert('طول شماره تلفن همراه می باید ۱۱ کارکتر باشد!');
                return false;
            } else {
                $('#user_MobileNo').addClass('is-valid');
            }
            if (!user_MobileNo.startsWith('09')) {
                alert('فرمت شماره تلفن همراه اشتباه است!');
                $('#user_MobileNo').addClass('is-invalid');
                return false;
            } else {
                $('#user_MobileNo').addClass('is-valid');
            }
            captcha_str = $('#captcha').val();
            if (captcha_str.length != 5) {
                alert('کد امنیتی را به درستی وارد کنید!');
                $('#captcha').addClass('is-invalid');
                return false;
            } else {
                $('#captcha').addClass('is-valid');
            }

            if (!valid) {
                alert('لطفا فیلد های ضروری را پر کنید');
                return false;
            }

            if (valid) {
                code_valid = check_code();
                if (code_valid) {
                    submit_from();

                }
            }


        }


        function pre_save() {

            $('#terms').removeClass('text-danger');
            valid = true;
            name = $('#Name').val();
            if (name == '') {
                valid = false;
                $('#Name').addClass('is-invalid');
            } else {
                $('#Name').addClass('is-valid');
            }
            service = $('#service').val();
            if (service == '') {
                valid = false;
                $('#service').addClass('is-invalid');
            } else {
                $('#service').addClass('is-valid');
            }
            MobileNo = $('#MobileNo').val();
            if (MobileNo == '') {
                valid = false;
                $('#MobileNo').addClass('is-invalid');
            } else {
                $('#MobileNo').addClass('is-valid');
            }
            comment = $('#comment').val();
            if (comment == '') {
                valid = false;
                $('#comment').addClass('is-invalid');
            } else {
                $('#comment').addClass('is-valid');
            }
            index_1 = $('input[name="index_1"]:checked').val();
            if (valid) {
                if (typeof index_1 === 'undefined') {
                    alert('لطفا رضایت مندی خود را اعلام نمائید!');
                    return false;
                }
            }
            if (!valid) {
                alert('لطفا فیلد های ضروری را پر کنید');
                return false;
            }
            //validation = check_validation();
            validation = true;
            if (validation == true) {
                if ($('#user_submiter_info').length) // if user not login is active
                {
                    if (valid) {
                        return true;
                    } else {
                        return false;
                    }
                }
                if (valid) {
                    submit_from();
                }
            } else {
                return false;
            }

            return true;
        }

        function submit_from() {
            var indexes = [];
            $('.comment-items').each(function(index) {
                result = $(this).hasClass('active');
                if (result) {
                    indexes.push($(this).attr('id'));
                }

            });
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('', {
                    function: 'add_comment',
                    code: $('#MobileNo').val(),
                    service: $('#service').val(),
                    captcha: $('#captcha').val(),
                    Name: $('#Name').val(),
                    center_name: $('#center_name').val(),
                    comment: $('#comment').val(),
                    indexes: indexes,
                    recommend: $('#recommend').prop('checked'),
                    call_allow: $('#call_allow').prop('checked'),
                    rate: $('input[name="index_1"]:checked').val(),
                    show_info: $('#show_info').prop('checked'),
                    user_Name: $('#user_Name').val(),
                    user_Family: $('#user_Family').val(),
                    user_MobileNo: $('#user_MobileNo').val()
                },
                function(data, status) {
                    if (data['result']) {
                        $('#myTabContent').html(data['data']);
                        return true;
                    } else {
                        alert('اختلالی در سامانه به وجود آمده است لطفا دقایقی دیگر تلاش کنید!');
                        return false;
                    }
                });
        }

        function check_validation() {
            MobileNo_val = $('#MobileNo').val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('', {
                    function: 'number_validation',
                    Mobile_number: MobileNo_val
                },
                function(data, status) {
                    console.log(data);

                    if (data['result']) {
                        return true;
                    } else {
                        alert('شماره تلفن همراه وارد شده یا کد پرستاربانک صحیح نیست!');
                        return false;
                    }
                });

        }
    </script>
@endsection

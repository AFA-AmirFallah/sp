@php
    $Persian = new App\Functions\persian();
@endphp
@extends('Layouts.MainPage')
@section('page-header-left')
@endsection
@section('MainCountent')
    <!-- Container-fluid starts-->
    <input class="nested" id="main-menu" value="#CustomerOrder">
    <input class="nested" id="sub-menu" value="#CustomerOrder">
    <input type="text" class="nested" id="UserName" value="{{ Auth::id() }}">
    <input type="text" class="nested" id="UserName_page" value="{{ Auth::id() }}">

    <div class="card-header text-right bg-transparent">

    </div>
    <!-- begin::modal -->
    <div class="ul-card-list__modal">
        <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">ثبت درخواست</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form method="POST">
                        @csrf
                        <div id="modalbase">

                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <div id="app">
        <patascustomer></patascustomer>
    </div>

    <div class="card">
        <div class="card-header gradient-purple-indigo 0-hidden pb-80">
            <h5 class="text-white"><i class=" header-icon i-Full-Basket"></i> ارائه دهندگان خدمات : {{ $OrderSrc->Cat }}
            </h5>
        </div>
        @php
            $serviceCount = 0;
        @endphp
        <div class="card-body">




            <div id="service_section" class="main-content">
                <div style="margin-top: 20px" class="container">
                    <div class="st-section-heading st-style2 text-center">
                        <h2> ارائه دهندگان خدمات : {{ $OrderSrc->Cat }} </h2>
                        <div class="st-seperator">
                            <div class="st-seperator-left-bar wow fadeInLeft" data-wow-duration="1s" data-wow-delay="0.2s">
                            </div>
                            <img src="/Theme4/assets/img/light-img/seperator-icon1.png" alt="demo"
                                class="st-seperator-icon">
                            <div class="st-seperator-right-bar wow fadeInRight" data-wow-duration="1s"
                                data-wow-delay="0.2s">
                            </div>
                        </div>
                        <p>{{ $OrderSrc->TitleDescription }} </p>
                    </div>
                </div>
                <div class="row cols-sm-2">
                    @foreach ($supported_branch as $supported_branch_item)
                        <div class="col-lg-4 col-xl-4  mb-3">
                            <div class="card  card-primary">
                                <div class="card-body">
                                    <div class="ul-contact-page__profile">
                                        <div class="user-profile">
                                            <img class="profile-picture mb-2" src="{{ $supported_branch_item->avatar }}"
                                                alt="{{ $supported_branch_item->branch_name }}">
                                        </div>
                                        <div class="ul-contact-page__info">
                                            <p class="m-0 text-24">{{ $supported_branch_item->branch_name }}</p>
                                            <p class="text-muted m-0">{{ $supported_branch_item->Description }}</p>
                                            <p class="text-muted mt-3"> {{ $supported_branch_item->MainDescription }}</p>
                                            @isset($supported_branch_item->min_price)
                                                <p class="text-muted mt-3">قیمت از:
                                                    {{ number_format($supported_branch_item->min_price) }} تا
                                                    {{ number_format($supported_branch_item->max_price) }} ریال</p>
                                            @else
                                                <p class="text-muted mt-3">حدود قیمت توسط تامین کننده درج نشده است</p>
                                            @endisset
                                            <button type="button" onclick="add_service({{ $supported_branch_item->id }})"
                                                class="btn btn-primary btn-icon m-1">
                                                <span class="ul-btn__icon"><i class="i-Disk"></i></span>
                                                <span class="ul-btn__text">ثبت درخواست برای تامین کننده</span>
                                            </button>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach


                </div>
            </div>

            <div id="register_section" class="main-content" style="display: none">

                <div style="margin-top: 20px">
                    <div class="st-section-heading st-style2 text-center">
                        <h2> ثبت رایگان درخواست: {{ $OrderSrc->Cat }} </h2>
                        
                        <div class="st-seperator">
                            <div class="st-seperator-left-bar wow fadeInLeft" data-wow-duration="1s" data-wow-delay="0.2s">
                            </div>
                            <img src="/Theme4/assets/img/light-img/seperator-icon1.png" alt="demo"
                                class="st-seperator-icon">
                            <div class="st-seperator-right-bar wow fadeInRight" data-wow-duration="1s"
                                data-wow-delay="0.2s">
                            </div>
                        </div>
                        <p>{{ $OrderSrc->TitleDescription }} </p>
                    </div>
                </div>
                <section class="row contact-section">
                    <div class="col-lg-6 mb-8">
                        <h4 style="display: flex" class="title mb-3"> ثبت درخواست خدمت در: <div id="center_title_2"
                                style="margin-right: 3px">
                            </div>
                        </h4>
                        <form class="form contact-us-form" method="post">
                            @csrf
                            <div class="form-group">

                                <input  class="nested" name="CatID" value="{{ $OrderSrc->id }}">
                                <input  type="number" class="nested" id="branch_src" name="branch" value="">
                                <label for="username">شماره موبایل جهت هماهنگی <small style="color: red" class="danger">
                                        (الزامی)</small></label>
                                <input inputmode="numeric" value="{{ Auth::user()->MobileNo }}" required id="username"
                                    name="MobileNo" class="form-control">

                            </div>
                            <div class="form-group">
                                <label for="email_1">نام بیمار <small style="color: red" class="danger">
                                        (الزامی)</small></label>
                                <input type="text" name="name" required value="{{ Auth::user()->Name }}"
                                    class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="email_1">نام خانوادگی بیمار <small style="color: red" class="danger">
                                        (الزامی)</small></label>
                                <input type="text" name="family" value="{{ Auth::user()->Family }}" required
                                    class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="message"> متن درخواست: توضیحاتی که مدیرعملیاتی مرکز را حهت ارائه بهتر خدمت
                                    یاری دهد</label>
                                <textarea id="message" placeholder="توضیحات و آدرس محل خدمت" name="note" cols="30" rows="5"
                                    class="form-control"></textarea>
                            </div>
                            <button type="button" onclick="back_to_centers()" class="btn btn-warning btn-rounded">
                                بازگشت</button>
                            <button type="submit" style="display: inline-flex;" class="btn btn-dark btn-rounded"> ثبت
                                درخواست در <div id="center_title" style="margin-right: 3px;margin-left: 3px"> </div>
                            </button>
                        </form>

                    </div>

                    <div class="col-lg-6 mb-8">
                        <div class="col-md-12 col-lg-12">
                            <!-- basic accordions with icons -->
                            <div class="card mt-4">
                                <div class="card-body">
                                    <div class="card-title ">
                                        <h3 class="card-title">سوالات متداول ثبت درخواست</h3>
                                    </div>

                                    <div class="accordion" id="accordionExample">
                                        <div class="card ul-card__border-radius">
                                            <div class="card-header ">
                                                <h6 class="card-title mb-0">
                                                    <a data-toggle="collapse" class="text-default collapsed"
                                                        href="#accordion-item-noicon-1" aria-expanded="false">
                                                        <span><i class="i-Big-Data ul-accordion__font"> </i></span>
                                                        شفاتل کیفیت خدمات را تضمین می نماید ؟
                                                    </a>
                                                </h6>
                                            </div>

                                            <div id="accordion-item-noicon-1" class="collapse"
                                                data-parent="#accordionExample" style="">
                                                <div class="card-body">
                                                    پلتفرم شفاتل مستقیما ارائه دهنده خدمت نمی باشد لذا نمیتواند کیفیت
                                                    خدمات
                                                    مراکز یا افراد را تضمین نماید. ولیکن تمام پزشکان - مراکز و
                                                    فروشگاه‌هایی که
                                                    در شفاتل فعال می‌باشند جزو بهترین خوش سابقه ترین‌های حوزه مربوط به
                                                    خود می
                                                    باشند.
                                                    پیشنهاد می شود قبل از ثبت خدمت سابقه ارائه دهنده خدمت را در پلتفرم
                                                    شفاتل
                                                    بررسی فرمائید.
                                                </div>
                                            </div>
                                        </div>

                                        <div class="card ul-card__border-radius">
                                            <div class="card-header">
                                                <h6 class="card-title mb-0">
                                                    <a class="text-default collapsed" data-toggle="collapse"
                                                        href="#accordion-item-noicon-2" aria-expanded="false">
                                                        <span><i class="i-Data-Settings ul-accordion__font">
                                                            </i></span>آیا شفاتل مرکز درمانی است؟</a>
                                                </h6>
                                            </div>

                                            <div id="accordion-item-noicon-2" class="collapse"
                                                data-parent="#accordionExample" style="">
                                                <div class="card-body">
                                                    خیر، شفاتل یک پلتفرم زنجیره تامین سلامت است که زیر ساخت فناوری لازم
                                                    را جهت
                                                    تسهیل کسب و کارهای حوزه سلامت در اختیار مراکز و افراد مجاز قرار می
                                                    دهد و پل
                                                    ارتباطی بیماران با فروشنده گان کالا یا خدمات پزشکی و درمانی است.
                                                </div>
                                            </div>
                                        </div>

                                        <div class="card ul-card__border-radius">
                                            <div class="card-header">
                                                <h6 class="card-title mb-0">
                                                    <a class="collapsed text-default" data-toggle="collapse"
                                                        href="#accordion-item-noicon-3">
                                                        <span><i class="i-Bell1 ul-accordion__font"> </i></span>
                                                        گونه می توانم درخواست خود را پیگیری کنم؟</a>
                                                </h6>
                                            </div>

                                            <div id="accordion-item-noicon-3" class="collapse"
                                                data-parent="#accordionExample">
                                                <div class="card-body">
                                                    پس از ثبت درخواست در پلتفرم شفاتل - درخواست ثبت شده مستقیما به مرکز
                                                    خدمات
                                                    دهنده‌ی انتخاب شده ارسال می گردد. شما می توانید در پنل کاربری خود
                                                    وضعیت
                                                    درخواست خود را مشاهده و از طریق همان پنل پیگیر درخواست خود از مرکز
                                                    خدمات
                                                    دهنده باشید.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card ul-card__border-radius">
                                            <div class="card-header">
                                                <h6 class="card-title mb-0">
                                                    <a class="collapsed text-default" data-toggle="collapse"
                                                        href="#accordion-item-noicon-4">
                                                        <span><i class="i-Bell1 ul-accordion__font"> </i></span>
                                                        چگونه می توانم نظر خودم را در خصوص نحوه انجام خدمت اعلام
                                                        نمایم؟</a>
                                                </h6>
                                            </div>

                                            <div id="accordion-item-noicon-4" class="collapse"
                                                data-parent="#accordionExample">
                                                <div class="card-body">
                                                    پس از اتمام هر خدمت از طریق پنل کاربری خود میتوانید میزان رضایت مندی
                                                    خود را از خدمات ارائه شده ثبت نمائید.


                                                </div>
                                            </div>
                                        </div>
                                        <div class="card ul-card__border-radius">
                                            <div class="card-header">
                                                <h6 class="card-title mb-0">
                                                    <a class="collapsed text-default" data-toggle="collapse"
                                                        href="#accordion-item-noicon-5">
                                                        <span><i class="i-Bell1 ul-accordion__font"> </i></span>چگونه
                                                        می توانم پولم را پس بگیرم؟</a>
                                                </h6>
                                            </div>

                                            <div id="accordion-item-noicon-5" class="collapse"
                                                data-parent="#accordionExample">
                                                <div class="card-body">
                                                    با توجه به اینکه پلتفرم شفاتل در روال مالی فی مابین ارائه دهندگان
                                                    خدمات یا
                                                    کالای درمان دخالتی ندارد لذا در خصوص این امر می باید به صورت مستقیم
                                                    با فرد
                                                    یا مرکز ارائه دهنده خدمات مذاکره نمائید اما در انجام این روند
                                                    کارشناسان
                                                    شفاتل این فرایند را برای شده تسهیل خواهند نمود.

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection

@section('page-js')
    <script>
        window.targetpage = 'CustomerOrder';
        window.main_username = $('#UserName').val();
        window.page_username = $('#UserName_page').val();
    </script>
    <script>
        function check_input() {

            if ($('#notes').val() == '') {
                alert('لطفا توضیحاتی در خصوص خدمات درخواستی وارد فرمایید!');
                $('#notes').css("border-color", "red");
            } else {

                $('#notes').css("border-color", "");
                $('#notes').css("border-color", "");
                $('#notes').attr('disabled', 'disabled'); //Disable
                //$('#fieldId').removeAttr('disabled'); //Enable
                alert_text = ` <input class="nested" name="note" value="` + $('#notes').val() + `" />
            <p class="text-danger" > آیا از ثبت درخواست مطمئن هستید؟ </p>
            <p> درنظر داشته باشید درخواست شما پس از بررسی کارشناسان مرکز اعلام زمان و هزینه خواهد شد. </p>
            <div class="ul-product-detail__quantity d-flex align-items-center mt-3">
                                    <button type="submit" class="btn btn-warning m-1">
                                        <i class="i-Full-Cart text-15"> </i>
                                        ثبت درخواست</button>
                                </div>
            
            `;
                $('#confirm_aria').html(alert_text);

            }
        }

        function load_order_modal(CatID, Title, SubTitle, text_note, image) {
            output = `   
      <input class="nested" name="CatID" value="` + CatID + `" />      
<section class="ul-product-detail">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">

                            <div class="ul-product-detail__image">
                                <img src="` + image + `"
                                    alt="">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="ul-product-detail__brand-name mb-4">
                                <h5 class="heading">` + Title + `</h5>
                                <span class="text-mute">` + SubTitle + `</span>
                            </div>
                            ` + text_note + `
                            <textarea id="notes" name="notes" class="form-control" cols="30" rows="10"></textarea>
                            
                            <div id="confirm_aria">
                                <div class="ul-product-detail__quantity d-flex align-items-center mt-3">
                                    <button type="button" onclick="check_input()" class="btn btn-primary m-1">
                                        <i class="i-Full-Cart text-15"> </i>
                                        ثبت درخواست</button>
                                </div>
                            </div>   

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>`;
            $('#modalbase').html(output);
        }
    </script>
@endsection

@section('bottom-js')
    @if (app()->getLocale() == 'fa')
        <script src="{{ asset('assets/js/vendor/datatables.min.fa.js') }}"></script>
    @else
        <script src="{{ asset('assets/js/vendor/datatables.min.js') }}"></script>
    @endif
    <script>
        function add_service(service_id) {
            $('#select_div').removeClass('active-box');
            $('#save_order_div').addClass('active-box');
            $('#center_title').html('.....');
            $('#center_title_2').html('.....');
            $('#center_desc').html('.....');
            $("#service_section").attr("style", "display:none;");
            $("#register_section").attr("style", "display:block;");
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('', {
                    ajax: true,
                    service_id: service_id
                },
                function(data, status) {
                    console.log(data);
                    $('#branch_src').val(data['id']);
                    $('#center_title').html(data['Name']);
                    $('#center_title_2').html(data['Name']);
                    $('#center_desc').html(data['Description']);
                });

        }

        function back_to_centers() {
            $('#select_div').addClass('active-box');
            $('#save_order_div').removeClass('active-box');
            $("#service_section").attr("style", "display:block;");
            $("#register_section").attr("style", "display:none;");
            $('#center_title').html('');
            $('#center_title_2').html('');
            $('#center_desc').html('');
        }
    </script>





    <script src="{{ asset('assets/js/tooltip.script.js') }}"></script>

    <script>
        $('#request_table').DataTable({
            "order": [
                [0, "desc"]
            ]
        });
    </script>

    <script>
        function ChangeOrderStatus($OrderID, $TargetStatus, $TargetStatusName) {
            var $loader = '<div class="loader-bubble loader-bubble-primary m-2"></div>';
            var $oldvalue = $('#status_' + $OrderID).html();
            $('#status_' + $OrderID).html($loader);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('<?php echo e(route('ajax')); ?>', {
                    AjaxType: 'ChangeOrderStatus',
                    OrderID: $OrderID,
                    TargetStatus: $TargetStatus,
                },

                function(data, status) {
                    if (data == '1') {
                        $('#status_' + $OrderID).html($TargetStatusName);
                    } else {
                        alert('بروز مشکل در انجام عملیات!');
                        $('#status_' + $OrderID).html($oldvalue);
                    }
                });


        }

        function DeleteMessage($MessageId) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('<?php echo e(route('ajax')); ?>', {
                    AjaxType: 'RemoveSMS',
                    MessageId: $MessageId,
                },

                function(data, status) {
                    if (data == true) {
                        $("#SmsRow_" + $MessageId).addClass("nested");
                    } else {
                        alert('بروز مشکل در انجام عملیات!');

                    }
                });



        }
    </script>
@endsection

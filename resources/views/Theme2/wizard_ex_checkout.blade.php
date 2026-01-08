@php
    $Persian = new App\Functions\persian();
@endphp
@extends('Theme2.Layouts.MainLayout')

@section('PageCSS')
    <link rel="stylesheet" href="/T1assets/vendor/libs/select2/select2.css">
    <link rel="stylesheet" href="/T1assets/vendor/libs/bs-stepper/bs-stepper.css">
    <link rel="stylesheet" href="/T1assets/vendor/libs/rateyo/rateyo.css">
    <link rel="stylesheet" href="/T1assets/vendor/libs/formvalidation/dist/css/formValidation.min.css">
@endsection

@section('Content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 breadcrumb-wrapper mb-4">
            <span class="text-muted fw-light"> ثبت سفارش ارز /</span> انتخاب صرافی
        </h4>
        <!-- Checkout Wizard -->
        <div id="wizard-checkout" class="bs-stepper wizard-icons wizard-icons-example mt-2">
            <div class="bs-stepper-header m-auto border-0">
                <div class="step" data-target="#checkout-cart">
                    <button type="button" class="step-trigger">
                        <span class="bs-stepper-icon">
                            <svg viewbox="0 0 58 54">
                                <use xlink:href="/T1assets/svg/icons/wizard-checkout-cart.svg#wizardCart"></use>
                            </svg>
                        </span>
                        <span class="bs-stepper-label"> سفارش</span>
                    </button>
                </div>
                <div class="line">
                    <i class="bx bx-chevron-right"></i>
                </div>
                <div class="step" data-target="#checkout-address">
                    <button type="button" class="step-trigger">
                        <span class="bs-stepper-icon">
                            <svg viewbox="0 0 54 54">
                                <use xlink:href="/T1assets/svg/icons/wizard-checkout-address.svg#wizardCheckoutAddress">
                                </use>
                            </svg>
                        </span>
                        <span class="bs-stepper-label">انتخاب صرافی</span>
                    </button>
                </div>
                <div class="line">
                    <i class="bx bx-chevron-right"></i>
                </div>
                <div class="step" data-target="#checkout-payment">
                    <button type="button" class="step-trigger">
                        <span class="bs-stepper-icon">
                            <svg viewbox="0 0 58 54">
                                <use xlink:href="/T1assets/svg/icons/wizard-checkout-payment.svg#wizardPayment"></use>
                            </svg>
                        </span>
                        <span class="bs-stepper-label">ثبت سفارش</span>
                    </button>
                </div>
                <div class="line">
                    <i class="bx bx-chevron-right"></i>
                </div>
                <div class="step" data-target="#checkout-confirmation">
                    <button type="button" class="step-trigger">
                        <span class="bs-stepper-icon">
                            <svg viewbox="0 0 58 54">
                                <use xlink:href="/T1assets/svg/icons/wizard-checkout-confirmation.svg#wizardConfirm">
                                </use>
                            </svg>
                        </span>
                        <span class="bs-stepper-label">تائید</span>
                    </button>
                </div>
            </div>
            <div class="bs-stepper-content border-top">
                <form id="wizard-checkout-form" onsubmit="return false">
                    <!-- Cart -->
                    <div id="checkout-cart" class="content">
                        <div class="row">
                            <!-- Cart left -->
                            <div class="col-xl-8 mb-3 mb-xl-0">
                                <!-- Offer alert -->
                                <div class="alert alert-success alert-dismissible mb-4" role="alert">
                                    <div class="fw-bold mb-2">پیشنهادات موجود</div>
                                    <ul class="list-unstyled mb-0">
                                        <li>- 10% تخفیف فوری در پرداخت از طریق کارت بانکی</li>
                                        <li>- 25% بازگشت مبلغ برای خریدهای بالای دو میلیون تومان</li>
                                    </ul>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>

                                <!-- Shopping bag -->
                                <h5 class="secondary-font">سفارش ارز</h5>
                                <ul class="list-group mb-3">
                                    <li class="list-group-item p-4">
                                        <div class="d-flex gap-3">
                                            <div class="flex-shrink-0">
                                                <img src="{{$coin_src->pic }}"
                                                    alt="google home" class="w-px-100">
                                            </div>
                                            <div class="flex-grow-1">
                                                <!-- Offer -->
                                                <h6 class="secondary-font">پیشنهاد</h6>
                                                <div class="row">
                                                    <div class="col-8 col-xxl-8 col-xl-12">
                                                        <input type="number" id="coins" class="form-control"
                                                            placeholder="میزان ارز مورد نیاز را وارد کنید"
                                                            aria-label="Enter Promo Code">
                                                    </div>
                                                    <div class="col-4 col-xxl-4 col-xl-12">
                                                        <div class="d-grid">
                                                            <button id="convert_btn" type="button" onclick="convert()"
                                                                class="btn btn-label-primary"> اعمال</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <script>
                                        function convert() {
                                            $('#convert_btn').html(`<span
                                                                    class="spinner-border spinner-border-sm" role="status"
                                                                    aria-hidden="true"></span> اعمال`);
                                            $("#convert_btn").prop("disabled", true);
                                            $coins = $('#coins').val();
                                            if ($coins == '' || $coins == null || $coins == 0) {
                                                alert('لطفا میزان ارز مورد نظر خود را وارد فرمائید!');
                                                return true;
                                            }
                                            $.ajaxSetup({
                                                headers: {
                                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                }
                                            });
                                            $.post('', {
                                                    AjaxType: 'convert',
                                                    coins: $coins,

                                                },

                                                function(data, status) {
                                                    if (data['result']) {
                                                        $save_sum_price = data['sum_price'];
                                                        $save_coin_price = data['coin_price'];
                                                        $sum_price = number_format(data['sum_price']);
                                                        $coin_price = number_format(data['coin_price']);

                                                        $('#total_coin').html(number_format($coins));
                                                        $('#rial_pay').html('مجموع: ' + $sum_price + ' تومان ');
                                                        $('#rial_each').html('هر واحد: ' + $coin_price + ' تومان ');
                                                        $('#total_sum').html($sum_price + ' تومان ');
                                                        $('#sum_sum').html($sum_price + ' تومان ');
                                                        $('#total_unit').html($coin_price + ' تومان ');
                                                        $('#convert_btn').html(`اعمال`);
                                                        $("#convert_btn").prop("disabled", false);
                                                    } else {
                                                        alert(data['msg']);
                                                        $('#convert_btn').html(`اعمال`);
                                                        $("#convert_btn").prop("disabled", false);
                                                    }

                                                });

                                        }
                                    </script>
                                    <li class="list-group-item p-4">
                                        <div class="d-flex gap-3">
                                            <div class="flex-shrink-0">
                                                <img src="https://arzonline.info/storage/photos/rial.png" alt="iran rial"
                                                    class="w-px-100">
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <h6 class="fw-normal mb-2 me-3">
                                                            <a href="javascript:void(0)" class="text-body">مبلغ ریالی جهت
                                                                خرید از صرافی</a>
                                                        </h6>
                                                        <div class="text-muted mb-1 d-flex flex-wrap">
                                                            <span class="me-1">فروش توسط:</span>
                                                            <a href="javascript:void(0)" class="me-1">صرافی های مجاز</a>
                                                            <span class="badge bg-label-success">موجود در صرافی</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="text-md-end">
                                                            <button type="button" class="btn-close btn-pinned"
                                                                aria-label="Close"></button>
                                                            <div class="my-2 my-md-4">
                                                                <span id="rial_each" class="text-primary">0 تومان</span>
                                                                <br>
                                                                <span id="rial_pay" class="text-primary">0 تومان</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>

                            <!-- Cart right -->
                            <div class="col-xl-4">
                                <div class="border rounded p-3 mb-3">

                                    <!-- Gift wrap -->
                                    <div class="bg-lighter rounded p-3">
                                        <p class="fw-bold mb-2">برای سرمایه گذاری ارز خریداری میکنید؟</p>
                                        <p>توجه داشته باشید ارز محل خوبی برای سرمایه گذاری نیست!</p>
                                    </div>
                                    <hr class="mx-n3">

                                    <!-- Price Details -->
                                    <h6 class="secondary-font">جزئیات قیمت</h6>
                                    <dl class="row mb-0">

                                        <dt class="col-6 fw-normal">میزان {{ $coin_src->FaName }}</dt>
                                        <dd id="total_coin" class="col-6 text-primary text-end">0 تومان</dd>

                                        <dt class="col-6 fw-normal">قیمت واحد</dt>
                                        <dd id="total_unit" class="col-6 text-primary text-end">0 تومان</dd>

                                        <dt class="col-6 fw-normal">مجموع سفارش</dt>
                                        <dd id="total_sum" class="col-6 text-end">0 تومان</dd>

                                        <dt class="col-6 fw-normal">هزینه ارسال</dt>
                                        <dd class="col-6 text-end text-muted">
                                            <span class="badge bg-label-success">تحویل توسط مشتری</span>
                                        </dd>

                                        <hr>

                                        <dt class="col-6">جمع</dt>
                                        <dd id="sum_sum" class="col-6 fw-semibold text-end mb-0">0 تومان</dd>
                                    </dl>
                                </div>
                                <div class="d-grid">
                                    <button class="btn btn-primary btn-next">انتخاب صرافی</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Address -->
                    <div id="checkout-address" class="content">
                        <div class="row">
                            <!-- Address left -->
                            <div class="col-xl-9 mb-3 mb-xl-0">
                                <!-- Select address -->
                                <p>صرافی محل تحویل را بر اساس استان و شهر انتخاب کنید</p>
                                <div class="row mb-3">
                                    <div class="col-md mb-md-0 mb-2">
                                        <div class="form-check custom-option custom-option-basic checked">
                                            <label class="form-check-label custom-option-content"
                                                for="customRadioAddress1">
                                                <span class="custom-option-header">
                                                    <span class="h6 mb-0">استان محل سکونت</span>
                                                </span>
                                                <span class="custom-option-body">
                                                    <select required name="Province" id="Province"
                                                        onchange="LoadCitys(this.value)"
                                                        class="select2 form-control form-control-md">
                                                        <option value="0">{{ __('--select--') }}</option>
                                                        @foreach ($province as $ProvincesTarget)
                                                            <option value="{{ $ProvincesTarget->id }}">
                                                                {{ $ProvincesTarget->ProvinceName }}</option>
                                                        @endforeach
                                                    </select>
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md">
                                        <div class="form-check custom-option custom-option-basic">
                                            <label class="form-check-label custom-option-content" style="display: grid"
                                                for="customRadioAddress2">
                                                <span class="custom-option-header">
                                                    <span class="h6 mb-0">شهر محل سکونت</span>
                                                </span>
                                                <div style="display: inline-flex">
                                                    <div class="col-8  col-s-12">
                                                        <select style="display: block !important;" id="Shahrestan"
                                                            name="Saharestan" class=" form-control form-control-md">
                                                        </select>
                                                    </div>
                                                    <div class="col-4  col-s-12 ">
                                                        <button id="search_exchanger" disabled type="button"
                                                            onclick="sarafi_list()" class="btn btn-primary ">
                                                            جستجو</button>
                                                    </div>


                                                </div>

                                            </label>

                                        </div>



                                    </div>
                                    <br>

                                </div>
                                <script>
                                    function sarafi_list() {
                                        $('#search_exchanger').html(`<span
                                                                    class="spinner-border spinner-border-sm" role="status"
                                                                    aria-hidden="true"></span> جستجو`);
                                        $("#search_exchanger").prop("disabled", true);
                                        $city = $('#Shahrestan').find(":selected").val();
                                        $.ajaxSetup({
                                            headers: {
                                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                            }
                                        });
                                        $.post('', {
                                                AjaxType: 'sarafi_list',
                                                city: $city,
                                            },

                                            function(data, status) {
                                                $('#sarafi_list').html(data);
                                                $('#search_exchanger').html(`جستجو`);
                                                $("#search_exchanger").prop("disabled", true);
                                                $("#search_exchanger").prop("disabled", false);
                                            });
                                    }
                                </script>
                                <!-- Choose Delivery -->
                                <p class="mt-2">انتخاب صرافی تحویل دهنده ارز</p>
                                <div id="sarafi_list" class="row">

                                </div>
                            </div>

                            <!-- Address right -->
                            <div class="col-xl-3">
                                <div class="border rounded p-3 mb-3">
                                    <!-- Estimated Delivery -->
                                    <div class="d-grid">
                                        <button class="btn btn-primary btn-next">ثبت سفارش</button>
                                    </div>

                                    <hr class="mx-n3">
                                    <div class="d-grid">
                                        <button class="btn btn-warning btn-prev"> مرحله قبل</button>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- Payment -->
                    <div id="checkout-payment" class="content">
                        <div class="row">
                            <!-- Payment left -->
                            <div class="col-xl-9 mb-3 mb-xl-0">
                                <!-- Payment Tabs -->
                                <div class="col-xxl-6 col-lg-8">


                                    <!-- Credit card -->
                                    <div class="tab-pane fade show active d-none" id="pills-cc" role="tabpanel"
                                        aria-labelledby="pills-cc-tab">
                                        <div class="row g-3">
                                            <div class="col-12">
                                                <label class="form-label w-100" for="paymentCard">شماره کارت</label>
                                                <div class="input-group input-group-merge">
                                                    <input id="paymentCard" name="paymentCard"
                                                        class="form-control credit-card-mask text-start" dir="ltr"
                                                        type="text" placeholder="1356 3215 6548 7898"
                                                        aria-describedby="paymentCard2">
                                                    <span class="input-group-text cursor-pointer p-1"
                                                        id="paymentCard2"><span class="card-type"></span></span>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label class="form-label" for="paymentCardName">نام</label>
                                                <input type="text" id="paymentCardName" class="form-control"
                                                    placeholder="جان اسنو">
                                            </div>
                                            <div class="col-6 col-md-3">
                                                <label class="form-label" for="paymentCardExpiryDate">تاریخ
                                                    انقضا</label>
                                                <input type="text" id="paymentCardExpiryDate"
                                                    class="form-control expiry-date-mask text-start" dir="ltr"
                                                    placeholder="YY/MM">
                                            </div>
                                            <div class="col-6 col-md-3">
                                                <label class="form-label" for="paymentCardCvv">کد CVV</label>
                                                <div class="input-group input-group-merge">
                                                    <input type="text" id="paymentCardCvv"
                                                        class="form-control cvv-code-mask" maxlength="3"
                                                        placeholder="654">
                                                    <span class="input-group-text cursor-pointer" id="paymentCardCvv2"><i
                                                            class="bx bx-help-circle text-muted" data-bs-toggle="tooltip"
                                                            data-bs-placement="top" title="شماره CVV کارت"></i></span>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <label class="switch">
                                                    <input type="checkbox" class="switch-input">
                                                    <span class="switch-toggle-slider">
                                                        <span class="switch-on"></span>
                                                        <span class="switch-off"></span>
                                                    </span>
                                                    <span class="switch-label">ذخیره کارت برای پرداخت های بعدی؟</span>
                                                </label>
                                            </div>
                                            <div class="col-12">
                                                <button type="button"
                                                    class="btn btn-primary btn-next me-sm-3 me-1">ثبت</button>
                                                <button type="reset" class="btn btn-label-secondary">انصراف</button>
                                            </div>
                                        </div>
                                    </div>

                                    <p class="fw-semibold">
                                        پرداخت در هنگام تحویل نوعی روش پرداخت است که در آن گیرنده مبلغ سفارش را در
                                        زمان تحویل سفارش پرداخت می‌کند.
                                    </p>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="terms-conditions"
                                            name="terms">
                                        <label class="form-check-label" for="terms-conditions">
                                            من موافقم با
                                            <a href="javascript:void(0);">سیاست حریم خصوصی و قوانین</a>
                                        </label>
                                        <div class="fv-plugins-message-container invalid-feedback"></div>
                                    </div>
                                    <button type="button" onclick="save_order()" class="btn btn-primary btn-next">پرداخت
                                        هنگام
                                        تحویل</button>


                                </div>
                            </div>

                        </div>
                    </div>
                    <script>
                        function save_order() {
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });
                            $.post('', {
                                    AjaxType: 'save_order',
                                    coins: $coins,
                                    sum_price: $save_sum_price,
                                    unit_price: $save_coin_price,
                                    sarafi_id: $sarafi_id
                                },

                                function(data, status) {
                                    $('#checkout-confirmation').html(data);

                                });
                        }
                    </script>

                    <!-- Confirmation -->
                    <div id="checkout-confirmation" class="content">



                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection
@section('EndScripts')
    <script src="/T1assets/vendor/libs/select2/select2.js"></script>
    <script src="/T1assets/vendor/libs/select2/i18n/fa.js"></script>
    <script src="/T1assets/vendor/libs/bs-stepper/bs-stepper.js"></script>
    <script src="/T1assets/vendor/libs/rateyo/rateyo.js"></script>
    <script src="/T1assets/vendor/libs/cleavejs/cleave.js"></script>
    <script src="/T1assets/vendor/libs/cleavejs/cleave-phone.js"></script>
    <script src="/T1assets/vendor/libs/formvalidation/dist/js/FormValidation.min.js"></script>
    <script src="/T1assets/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js"></script>
    <script src="/T1assets/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js"></script>
    <script src="/T1assets/js/modal-add-new-address.js"></script>
    <script src="/T1assets/js/wizard-ex-checkout.js"></script>
    <script>
        function set_sarafi(id) {
            $sarafi_id = id;
        }

        function LoadCitys($ProvinceCode, $selected = null) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('<?php echo e(route('ajax')); ?>', {
                    AjaxType: 'GetCitysOfProvinces',
                    ProvinceCode: $ProvinceCode,
                    selected: $selected,
                },

                function(data, status) {
                    $("#Shahrestan").empty();
                    $("#Shahrestan").append(data);
                    $('#search_exchanger').prop("disabled", false);
                });
        }
    </script>
@endsection

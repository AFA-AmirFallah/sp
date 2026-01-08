@php
    $OrderDetials = $Order->get_order_detials();
    $BenefitTotall = 0;
    $TOPayTotall = 0;
    $TotallProductPrice = 0;
    $counter = 0;

@endphp
@php
    $GetBasketItemsBrif = App\Http\Controllers\woocommerce\buy::GetBasketItemsBrif();
    if ($GetBasketItemsBrif == []) {
        $order_count = 0;
    }

    $benefit = 0;
    $totall = 0;
@endphp
@foreach ($GetBasketItemsBrif as $OrderItem)
    {{-- @dd($OrderItem['Remian']) --}}
    @if ($OrderItem['Remian'] != 0)
        @if (!isset($OrderItem['TashimRes'][0]))
            @php
                $totall += $OrderItem['Price'] * $OrderItem['Qty'];
                $benefit += $OrderItem['BasePrice'] * $OrderItem['Qty'] - $OrderItem['Price'] * $OrderItem['Qty'];
            @endphp
        @else
            @php
                $tashimArr = $OrderItem['TashimRes'];
                $targetPrice = 0;

                foreach ($tashimArr as $tashimItem) {
                    $targetPrice += $tashimItem['priceStr'];
                }
                $totall += $targetPrice * $OrderItem['Qty'];
                $benefit += $OrderItem['BasePrice'] * $OrderItem['Qty'] - $targetPrice * $OrderItem['Qty'];

            @endphp
        @endif
    @else
        @php
            $counter++;
        @endphp
    @endif

    </div>
    </div>
    </a>
    </li>
@endforeach
@if (count($GetBasketItemsBrif) == 0)
@endif
@if ($OrderDetials !== null)
    <div class="col-xl-3 col-lg-4 col-12 w-res-sidebar sticky-sidebar">
        <div class="dt-sn dt-sn--box border mb-2">
            <ul class="checkout-summary-summary">
                <li>
                    <span>مبلغ کل
                        سفارش</span><span>{{ number_format($totall / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                        <div style="display: inline-flex;width: 10px;"></div>
                        {{ App\Http\Controllers\Credit\currency::GetCurrency() }}
                    </span>
                </li>
                <li class="checkout-summary-discount">
                    <span>سود شما از
                        خرید</span><span>{{ number_format($benefit / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                        <div style="display: inline-flex;width: 10px;"></div>
                        {{ App\Http\Controllers\Credit\currency::GetCurrency() }}
                    </span>
                </li>

                <li>
                    <span>هزینه ارسال
                        <span class="help-sn" data-toggle="tooltip" data-html="true" data-placement="bottom"
                            title=" هزینه ارسال براساس آدرس، زمان تحویل، وزن و حجم مرسوله شما محاسبه می‌شود">
                        </span></span><span>وابسته به آدرس</span>
                </li>

            </ul>
            <div class="checkout-summary-devider">
                <div></div>
            </div>
            <div class="checkout-summary-content">
                <div style="font-size: 18px" class="checkout-summary-price-title">مبلغ قابل پرداخت:</div>
                <div class="checkout-summary-price-value">
                    <span
                        class="checkout-summary-price-value-amount">{{ number_format($totall / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}</span>
                    {{ App\Http\Controllers\Credit\currency::GetCurrency() }}
                </div>
                @if (Auth::Check())
                    @if ($counter != 0)
                        <div
                            style = "background-color: red;
    color: white;"class="alert alert-icon alert-error alert-bg alert-inline d-flex justify-content-center ">
                            <h4 class="alert-title">
                            </h4> سبد خرید شما نیاز به ویرایش دارد
                        </div>
                    @else
                        @if (Auth::user()->MobileNo == Auth::user()->Name)
                            <a href="{{ route('UserProfile') }}" class="mb-2 d-block">
                                <button class="btn-primary-cm btn-with-icon w-100 text-center pr-0">
                                    <i class="mdi mdi-arrow-left"></i>
                                    تکمیل اطلاعات کاربری
                                </button>

                            </a>
                        @else
                            <a href="javascript:steper('FinalizeOrder')" class="mb-2 d-block">
                                <button class="btn-primary-cm btn-with-icon w-100 text-center pr-0">
                                    <i class="mdi mdi-arrow-left"></i>
                                    ادامه ثبت سفارش
                                </button>

                            </a>
                        @endif
                    @endif
                @else
                    <a href="{{ route('login') }}"
                        class="btn btn-block btn-dark btn-icon-right btn-rounded  btn-checkout">
                        ورود و ادامه<i class="w-icon-long-arrow-left"></i></a>
                @endif

                <div>
                    <span>
                        کالاهای موجود در سبد شما ثبت و رزرو نشده‌اند، برای ثبت سفارش
                        مراحل بعدی را تکمیل کنید.
                </div>
            </div>
        </div>

    </div>

@endif


<script>
    $(document).ready(function() {
        $('#SumNavSide').html(formatCurrency(window.TOPayTotall / window.CurencyRate) + ' ' + window
            .CurencyName);
        $('#yourbenifit').html(formatCurrency(window.BenefitTotall / window.CurencyRate) + ' ' + window
            .CurencyName);

    });

    function steper($Location) {
        $VirtualType = $('#ProductVirtual').val();
        if ($VirtualType == 0) {
            // Product to delever
            Estelamstatus = $('#Estelamstatus').val();
            if (Estelamstatus == 0) { //check estelam order or normal order
                targeturl = '?page=AddressOFCheckout&page1=FinalOFCheckout&page2=PaymentOFCheckout';
            } else {
                targeturl = '?page=AddressOFCheckout&page1=FinalOFCheckout&page2=FinalEstelamCheckout';
            }
            $('#step_1').removeClass('active');
            $('#step_2').addClass('active');

        }
        if ($VirtualType == 1) {
            // Product to Come in
            targeturl = '?page=AddressOFCheckout_v1&page1=FinalOFCheckout_v1&page2=FinalCheckout_v1';

        }
        if ($VirtualType == 2) {
            // Product to  download
        }
        if ($VirtualType == 'TypeMismatch') {
            // error products type are not
        }


        $.ajax({
            url: targeturl,
            type: 'get',
            beforeSend: function() {

            },
            success: function(response) {

                $('#maincontent').html(response);

            },
            error: function() {
                alert('can not');
            }
        });
    }

    function LoadCitys($ProvinceCode) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.post('<?php echo e(route('ajax')); ?>', {
                AjaxType: 'GetCitysOfProvinces',
                ProvinceCode: $ProvinceCode,
            },

            function(data, status) {
                $("#Shahrestan").empty();
                $("#Shahrestan").append(data);
            });
    }
</script>

@php
    $OrderDetials = $Order->get_order_detials();

@endphp
@if ($OrderDetials !== null)

<div class="col-lg-4 sticky-sidebar-wrapper">
    <div class="sticky-sidebar">
        <div class="cart-summary mb-4">

            <div style="color: red ;margin-bottom: 14px;"
                class="cart-subtotal d-flex align-items-center justify-content-between">
                <label class="ls-25">سود شما از این خرید</label>
                <div id="yourbenifit"></div>


            </div>
            <p>
                هزینه ارسال براساس آدرس، زمان تحویل، وزن و حجم مرسوله شما محاسبه می‌شود




            </p>


            {{--  <div class="cart-subtotal d-flex align-items-center justify-content-between">
                <label class="ls-20">پرداخت نقدی</label>
                ۱۰۰۰۰۰ تومن
                <span>
            </div>
            <div class="cart-subtotal d-flex align-items-center justify-content-between">
                <label class="ls-20"> قسط اول</label>
                ۱۰۰۰۰۰ تومن
                <span>
            </div> --}}

            <hr class="divider">

            <div class="order-total d-flex justify-content-between align-items-center">
                <label>مجموع
                    خرید</label>
                <div id="SumNavSide"></div>
                <span class="ls-50">
            </div>
            @if (Auth::Check())
                <button onclick="steper('FinalizeOrder')"
                    class="btn btn-block btn-dark btn-icon-right btn-rounded  btn-checkout">
                    برای تسویه حساب ادامه دهید<i class="w-icon-long-arrow-left"></i></button>
            @else
                <a href="{{ route('login') }}" class="btn btn-block btn-dark btn-icon-right btn-rounded  btn-checkout">
                    ورود و ادامه<i class="w-icon-long-arrow-left"></i></a>
            @endif
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

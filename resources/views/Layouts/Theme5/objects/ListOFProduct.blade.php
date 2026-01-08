@php
    $OrderDetials = $Order->get_order_detials();
    $ProductVirtual = $Order->get_order_virtual();
    // echo "ProductVirtual = $ProductVirtual";
    $BenefitTotall = 0;
    $TOPayTotall = 0;
@endphp
@if ($OrderDetials !== null)
    <div class="title-breadcrumb-special dt-sl mb-3">
        <div class="breadcrumb dt-sl">
            <nav>
                <a href="{{ route('home') }}"> خانه</a>
                <a> سبد خرید </a>
            </nav>
        </div>
    </div>
    <div class="gfgdfg col-xl-9 col-lg-8 col-12 px-0">
        <input id="ProductVirtual" class="d-none" value="{{ $ProductVirtual }}">
        <input id="Totalweighttmp" class="d-none" value="{{ $Order->get_totall_wight() }}">


        <div class="table-responsive checkout-content dt-sl">
            <div class="checkout-header">

                <span class="checkout-header-title">سبد خرید شما</span>
                <span style="font-size:12px;"
                    class="checkout-header-extra-info">({{ \App\Http\Controllers\woocommerce\buy::BasketItemsStepper() ?? 0 }}
                    کالا)</span>
            </div>
            <div class="checkout-section-content-dd-k">
                <div class="cart-items-dd-k">
                    @foreach ($OrderDetials as $MyOrderTarget)
                        @php
                            $MyProduct->product_in_basket_process($MyOrderTarget);
                        @endphp
                        <div class="cart-item py-4 px-3">
                            <div class="item-thumbnail">
                                <a href="{{ route('SingleProduct', ['productID' => $MyOrderTarget['Product']->id]) }}">
                                    <img src="{{ App\Functions\Images::GetPicture($MyOrderTarget['Product']->ImgURL, 1) }}"
                                        alt="{{ $MyOrderTarget['Product']->NameFa }}">
                                </a>
                            </div>
                            <div class="item-info flex-grow-1">
                                <div class="item-title">
                                    <h2>
                                        <a style="line-height: 30px;"
                                            href="{{ route('SingleProduct', ['productID' => $MyOrderTarget['Product']->id]) }}">
                                            {{ $MyOrderTarget['Product']->NameFa }}</a>
                                    </h2>
                                </div>

                                <div class="item-detail">

                                    <div class="item-quantity--item-price">
                                        <div class="item-quantity">
                                            <button type="button"
                                                onclick="removeitem({{ $MyOrderTarget['Product']->id }})"
                                                class="text-danger item-remove-btn mr-3">
                                                <i class="far fa-trash-alt"></i>
                                                حذف
                                            </button>
                                            <button type="button" data-target="#product_fast_show" data-toggle="modal"
                                                role="button"
                                                onclick="load_fast_buy({{ $MyOrderTarget['Product']->id }})"
                                                class="item-remove-btn mr-3"> {{ $MyOrderTarget['ProductQty'] }} عدد
                                                @if ($MyOrderTarget['remain'] < $MyOrderTarget['ProductQty'])
                                                    <p class="text-danger bold" >متاسفانه تنها {{ $MyOrderTarget['remain'] }} عدد باقی  مانده
                                                        است لطفا تعداد سفارش خود را اصلاح کنید</p>
                                                @endif
                                                <i class="far fa-pen"></i>
                                                ویرایش
                                            </button>
                                        </div>
                                        <div class="item-price">
                                            {{ number_format($MyProduct->ItemTotall / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                            <span
                                                class="text-sm mr-1">{{ App\Http\Controllers\Credit\currency::GetCurrency() }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <input id="BenefitTotall" class="d-none" value="{{ $MyProduct->BenefitTotall }}">
                    <input id="TOPayTotall" class="d-none" value="{{ $MyProduct->TOPayTotall }}">
                </div>
            </div>
        </div>
    </div>
@else
    <div class="col-xl-9 col-lg-8 col-12 px-0">
        <div class="col-12">
            <div class="dt sl dt-sn dt-sn--box border pt-3 pb-5">
                <div class="cart-page cart-empty">
                    <div class="circle-box-icon">
                        <i class="mdi mdi-cart-remove"></i>
                    </div>
                    <p class="cart-empty-title">سبد خرید شما خالیست!</p>
                    <p>می‌توانید برای مشاهده محصولات بیشتر به صفحات زیر بروید:</p>
                    <div class="cart-empty-links mb-5">
                        <a href="#" class="border-bottom-dt">لیست مورد علاقه من</a>
                        <a href="#" class="border-bottom-dt">محصولات شگفت‌انگیز</a>
                        <a href="#" class="border-bottom-dt">محصولات پرفروش روز</a>
                    </div>
                    <a href="{{ route('home') }}" class="btn-primary-cm">ادامه خرید در
                        {{ App\myappenv::CenterName }}</a>
                </div>
            </div>
        </div>
    </div>
@endif

<script>
    $(document).ready(function() {
        window.BenefitTotall = $('#BenefitTotall').val();
        window.TOPayTotall = $('#TOPayTotall').val();
        $('#Totalweight').val($('#Totalweighttmp').val());




        // alternative is to use "change" - explained below


    });
</script>

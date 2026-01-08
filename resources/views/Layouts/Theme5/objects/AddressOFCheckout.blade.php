@php
    $GetBasketItemsBrif = App\Http\Controllers\woocommerce\buy::GetBasketItemsBrif();
    if ($GetBasketItemsBrif == []) {
        $order_count = 0;
    }
    $Active_address = 0;
    $benefit = 0;
    $totall = 0;
@endphp

<div class="cart-page-content col-xl-9 col-lg-8 col-12 px-0">
    <div>
        <div class="title-breadcrumb-special dt-sl mb-3">
            <div class="breadcrumb dt-sl">
                <nav>
                    <a href="{{ route('home') }}"> خانه</a>
                    <a href="{{ route('checkout') }}">سبد خرید</a>
                    <a>انتخاب آدرس تحویل سفارش</a>
                </nav>
            </div>
        </div>
        <section id="main_address_selector" class="page-content dt-sl">
            <div class="address-section">
                <div class="checkout-contact dt-sn dt-sn--box border px-0 pt-0 pb-0">
                    <div class="checkout-address dt-sn px-0 pt-0 pb-0 show" id="user-address-list-container">
                        <div class="checkout-address-content">
                            <div class="checkout-address-headline">آدرس مورد نظر خود را جهت تحویل سفارش
                                انتخاب یا ایجاد کنید:</div>
                            <div class="checkout-address-row">
                                <div class="checkout-address-col">
                                    <button class="btn-primary-cm btn-with-icon mx-auto w-100"
                                        onclick="add_new_location()">
                                        <i class="mdi mdi-map-marker-plus"></i>
                                        <strong>ایجاد آدرس جدید</strong>
                                    </button>
                                </div>
                            </div>
                            <hr>

                            <strong>لیست آدرس ها</strong>
                            <br>
                            <br>
                            @foreach ($Order->get_User_Locations() as $Locations)
                                @if ($loop->first)
                                    @php
                                        $Active_address = $Locations->id;
                                    @endphp
                                @endif
                                <div class="checkout-address-row">
                                    <div onclick="slect_address({{ $Locations->id }})" class="checkout-address-col">
                                        <div style="padding: 10px;" id="loc_{{ $Locations->id }}"
                                            class="checkout-address-box @if ($loop->first) is-selected-new @endif">
                                            <h5 class="checkout-address-title">
                                                {{ $Locations->name }}</h5>
                                            <p class="checkout-address-text">
                                                <span> استان: {{ $Locations->Province }} شهر: {{ $Locations->City }}
                                                    {{ $Locations->Street }} -
                                                    {{ $Locations->OthersAddress }}
                                                </span>
                                                <input class="d-none" id="city_{{ $Locations->id }}"
                                                    value="{{ $Locations->CityID }}">
                                            </p>
                                            <ul style="margin-top: -18px;" class="checkout-address-list">
                                                <li>
                                                    <ul class="checkout-address-contact-info">
                                                        <li class="">
                                                            کدپستی:
                                                            <span
                                                                style="margin-right: 3px;">{{ $Locations->PostalCode }}</span>
                                                        </li>
                                                        <div class="nndjhhs"></div>
                                                        <li style="margin-right: 3px;">شماره همراه:
                                                            <span>{{ $Locations->reciverphone }}</span>
                                                        </li>
                                                    </ul>
                                                </li>
                                                <li style="margin-top: 30px">
                                                    <ul>
                                                        <li style="display: flex">
                                                            <button id="select_btn_{{ $Locations->id }}"
                                                                style="display:inline-flex;"
                                                                class="@if ($loop->first) d-none @endif checkout-address-btn-remove select_btn "
                                                                onclick="slect_address({{ $Locations->id }})"> <i
                                                                    style="margin-left: 5px;font-size: 17px"
                                                                    class="mdi mdi-map-marker"></i>انتخاب این
                                                                آدرس</button>

                                                            <button id="selected_btn_{{ $Locations->id }}"
                                                                style="display:inline-flex; background-color: red;color:white;"
                                                                disabled
                                                                class="@if (!$loop->first) d-none @endif  checkout-address-btn-remove selected_btn"
                                                                data-target="#remove-location"> <i
                                                                    style="pointer-events:painted; margin-left: 5px;font-size: 17px;"
                                                                    class="mdi mdi-truck"></i> ارسال به این
                                                                آدرس</button>


                                                            <button class="checkout-address-btn-remove"
                                                                onclick="edit_location({{ $Locations->id }},'{{ $Locations->name }}' ,'{{ $Locations->reciverphone }}' ,'{{ $Locations->OthersAddress }}','{{ $Locations->PostalCode }}' , '{{ $Locations->ProvinceID }}', '{{ $Locations->City }}'  )"><i
                                                                    class="far fa-pen"></i> ویرایش</button>
                                                            <button class="checkout-address-btn-remove"
                                                                data-toggle="modal"
                                                                onclick="slect_address_to_remove({{ $Locations->id }})"
                                                                data-target="#remove-location"><i
                                                                    class="far fa-trash-alt"></i> حذف</button>
                                                        </li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <script>
                            $('#Locations').val({{ $Active_address }});

                            function active_address(loc) {
                                $('.checkout-address-box').removeClass('is-selected');
                                $('#loc_' + loc).addClass('is-selected');
                                $('#Locations').val(loc);
                            }
                        </script>
                    </div>
                    <div class="modal fade" id="remove-location" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: none;">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title mb-3" id="exampleModalLabel">آیا مطمئنید که
                                        این آدرس حذف شود؟</h5>
                                </div>
                                <div class="modal-footer">
                                    <button type="button"
                                        class="remodal-general-alert-button remodal-general-alert-button--cancel"
                                        data-dismiss="modal">خیر</button>
                                    <button type="button" onclick="removeaddress()" data-dismiss="modal"
                                        class="remodal-general-alert-button remodal-general-alert-button--approve">بله</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Modal remove-location -->
                </div>
            </div>


        </section>
    </div>
    <div id="InputAddress" class="d-none">
        <div class="">
            <div class="page-content">
                <div style="padding: 10px;" class="container">
                    <div>
                        <div class="col-lg-12 pr-lg-12 mb-12"
                            style="border: 1px solid var(--color_palet_6);
                            border-radius: 4px;">
                            <h3 class="title billing-title text-uppercase ls-10 pt-1 pb-3 mb-0">
                            </h3>
                            <div id="addnewaddress" class="checkbox-content">
                                <div class=" gutter-sm">
                                    @include('Layouts.Theme5.objects.AddressAddFilds')
                                </div>
                            </div>

                            <div id="ShowRegistedAddress">



                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

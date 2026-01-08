@php
    $Persian = new App\Functions\persian();
    $BenefitTotall = 0;
    $LocationInit = 0;
    $IsUse = false;
    $count = 0;
    $TOPayTotall = 0;
    $Loccounter = 1;
@endphp
@extends('Layouts.Theme1.MainLayout')
@section('MainTitle')
@endsection
@section('MainContent')
    <nav class="breadcrumb-nav">
        <div class="container">
            <ul class="breadcrumb shop-breadcrumb bb-no">
                <li id="step_1" class="active"><a>سبد خرید </a></li>
                <li id="step_2" class="deactive"><a>پرداخت</a></li>
                <li id="step_3" class="deactive"><a>اتمام خرید </a></li>
            </ul>
        </div>
    </nav>
    @if (!$IsValidTashim)
        @if (!Auth::check())
            <div class="col-md-6 mb-4">
                <div class="alert alert-icon alert-error alert-bg alert-inline">
                    <h4 class="alert-title">
                        <i class="w-icon-times-circle"></i>امکان خرید با شرایط درخواست شده برای شما وجود ندارد!
                    </h4>
                    <li>برای استفاده از امکانات خرید اعتباری ابتدا باید وارد حساب کاربری خود شوید</li>
                </div>
            </div>
        @elseif(Auth::user()->CreditePlan != 1)
            <div class="col-md-6 mb-4">
                <div class="alert alert-icon alert-error alert-bg alert-inline">
                    <h4 class="alert-title">
                        <i class="w-icon-times-circle"></i>امکان خرید با شرایط درخواست شده برای شما وجود ندارد!
                    </h4>
                    <li>برای استفاده از امکانات خرید اعتباری حساب شما باید کاربرویژه باشد <a
                            href="{{ route('MyAccount') }}">کاربر ویژه شوید </a></li>


                </div>
            </div>
        @else
            <div class="col-md-6 mb-4">
                <div class="alert alert-icon alert-error alert-bg alert-inline">
                    <h4 class="alert-title">
                        <i class="w-icon-times-circle"></i>امکان خرید با شرایط درخواست شده برای شما وجود ندارد.!
                    </h4>
                    <li>موجودی توان پرداخت شما کافی نیست!</li>

                    <li>در صورت نیاز با کارشناسان فروش تماس گرفته و مشکل را با ایشان مطرح فرمایید!</li>
                </div>
            </div>
        @endif
    @endif
    <div id="ListOFProduct">
        <input id="Totalweight" class="nested" value="">
        <div class="page-content">
            <div class="container">
                <div class="cart">
                    <div id="maincontent" class="row gutter-lg mb-10">

                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
@section('page-js')
    <script>
        function reloadbasket() {
            $.ajax({
                url: '?page=ListOFProduct&page1=SidebarListOFProduct',
                type: 'get',
                beforeSend: function() {

                },
                success: function(response) {
                    $('#maincontent').html(response);


                },
                error: function() {
                    emptycheckout();



                }
            });
        }
        $(document).ready(function() {
            reloadbasket();

        });
    </script>


    <script>
        function editaddress($Addressid) {
            $.ajax({
                url: '?page=AddressEditableFilds',
                type: 'get',
                beforeSend: function() {

                },
                success: function(response) {
                    $('#editAddress' + $Addressid).html(response);

                },
                error: function() {
                    alert('can not');
                }
            });
        }

        function emptycheckout() {
            $.ajax({
                url: '?page=EmptyCheckout',
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
    </script>

    <script>
        function newaddress() {
            if ($('#addnewaddressRadio').is(':checked')) {
                $('#addnewaddress').addClass("open");
                $("#addnewaddress").css({
                    "display": "block"
                });
            } else {
                $('#addnewaddress').removeClass("open");
                $("#addnewaddress").css({
                    "display": "none"
                });
            }


        }

        function confirm_creadit() {
            if ($('#addnewRadio').is(':checked')) {

                $("#addnewcheckbox").css({
                    "display": "block"
                });
            } else {
                $("#addnewcheckbox").css({
                    "display": "none"
                });
            }


        }

        function reloadThePage() {
            window.location.reload(true);
        }

        function updatebasket() {
            if ($("#update_cart").hasClass('disabled')) {
                const formButton = document.querySelector("#update_cart");
                formButton.disabled = true;
                alert('موجودی کالا را تغییر دهید');


            }




        }

        function qtyplus($Elemtid) {

            Oldval = parseInt($('#qty_' + $Elemtid).val(), 10);
            $("#update_cart").removeClass("disabled");
            newprice = Oldval + 1;
            maxAtt = $('#qty_' + $Elemtid).attr('max');
            if (newprice <= maxAtt) {
                $('#qty_' + $Elemtid).val(newprice);
            } else {
                alert('تعداد درخواستی از موجودی بیشتر است!');
            }

        }

        function qtyminus($Elemtid) {

            Oldval = parseInt($('#qty_' + $Elemtid).val(), 10);
            $("#update_cart").removeClass("disabled");
            newprice = Oldval - 1;
            minAtt = $('#qty_' + $Elemtid).attr('min');
            if (newprice >= minAtt) {
                $('#qty_' + $Elemtid).val(newprice);
            }
        }

        function clearorder() {
            $.ajax({
                url: '?page=ListOFProduct&page1=SidebarListOFProduct&clear=1',
                type: 'get',
                beforeSend: function() {

                },
                success: function(response) {
                    $('#maincontent').html(response);


                },
                error: function() {
                    $('#maincontent').html('');
                    emptycheckout();



                }
            });
        }

        function removeitem(TargetItem) {
            $.ajax({
                url: '?page=ListOFProduct&page1=SidebarListOFProduct&removeitem=' + TargetItem,
                type: 'get',
                beforeSend: function() {

                },
                success: function(response) {
                    if (response.result === false) {
                        emptycheckout();
                    } else if (response.result === true) {
                        reloadbasket();
                    }



                },
                error: function() {
                    alert('امکان حذف تک آیتم وجود ندارد لطفا سبد خرید خود را پاک بفرمایید');
                }
            });
        }
    </script>
    <script>
        function submitform() {
            if (checkreadytosave()) {
                $LocationCode = $('input[name="Location"]:checked').val();
                $('#Locations').val($LocationCode);
                if ($LocationCode == 0) {
                    if (validateaddress()) {
                        $('#finalmainform').submit();
                        document.getElementById('finalmainform').submit();
                    }
                } else {
                    $('#finalmainform').submit();
                    document.getElementById('finalmainform').submit();
                }


            }


        }

        function estelam() {
            $('#finalEstelammainform').submit();
            document.getElementById('finalEstelammainform').submit();
        }

        function virtual() {
            $ConfirmCode = $('input[name="addnewRadio"]:checked').val();
            if ($ConfirmCode == undefined) {

                Swal.fire({
                    title: 'لطفا کسر از حقوق را تایید کنید ',
                    confirmButtonText: 'بستن',
                })
                return false;

            } else {
                $('#finalmainformvirtual').submit();
                document.getElementById('finalmainformvirtual').submit();
            }
        }
    </script>
    <script>
        // delever
        window.Province = 0;
        window.BenefitTotall = 0;
        window.TOPayTotall = 0;
        window.CurencyRate = <?php echo App\Http\Controllers\Credit\currency::GetCurrencyRate(); ?>;
        window.CurencyName = '<?php echo App\Http\Controllers\Credit\currency::GetCurrency(); ?>';



        function checkreadytosave() {
            $LocationCode = $('input[name="Location"]:checked').val();
            $ConfirmCode = $('input[name="addnewRadio"]:checked').val();
            $shipping = $('input[name="shipping"]:checked').val();


            if ($LocationCode == undefined) {
                $('.delevertype').prop('checked', false);
                Swal.fire({
                    title: 'لطفا ابتدا آدرس خود را انتخاب کنید ',
                    confirmButtonText: 'بستن',
                })
                return false;

            } else if ($shipping == undefined) {
                $('.delevertype').prop('checked', false);
                Swal.fire({
                    title: 'لطفا نوع حمل و نقل خود را انتخاب کنید ',
                    confirmButtonText: 'بستن',
                })

                return false;

            } else if ($ConfirmCode == undefined) {

                Swal.fire({
                    title: 'لطفا کسر از حقوق را تایید کنید ',
                    confirmButtonText: 'بستن',
                })
                return false;
            } else {

                return true;
            }
        }

        function checkaddress() {
            $LocationCode = $('input[name="Location"]:checked').val();

            if ($LocationCode == undefined) {
                $('.delevertype').prop('checked', false);
                Swal.fire({
                    title: 'لطفا ابتدا آدرس خود را انتخاب کنید ',
                    confirmButtonText: 'بستن',
                })
                return false;
            } else {

                return true;
            }
        }

        function validateaddress() {

            if ($('#LocationName').val() == '') {
                Swal.fire({
                    title: 'لطفا برای استفاده از این آدرس در سفارشات بعدی نام محل را وارد فرمایید!',
                    confirmButtonText: 'بستن',
                })
            } else if ($('#Province').val() == '0') {
                Swal.fire({
                    title: 'لطفا استان را مشخص فرمایید!',
                    confirmButtonText: 'بستن',
                })
            } else if ($('#Shahrestan').val() == '') {
                Swal.fire({
                    title: 'لطفا شهر را مشخص فرمایید!',
                    confirmButtonText: 'بستن',
                })

            } else if ($('#Street').val() == '') {
                Swal.fire({
                    title: 'لطفا خیابان را مشخص فرمایید!',
                    confirmButtonText: 'بستن',
                })
            } else if ($('#Pelak').val() == '') {
                Swal.fire({
                    title: 'لطفا کوچه و پلاک را مشخص فرمایید!',
                    confirmButtonText: 'بستن',
                })
            } else {
                $('#Street_t').val($('#Street').val());
                $('#OthersAddress_t').val($('#OthersAddress').val());
                $('#ExtraNote_t').val($('#ExtraNote').val());
                $('#Pelak_t').val($('#Pelak').val());
                $('#recivername_t').val($('#recivername').val());
                $('#reciverphone_t').val($('#reciverphone').val());
                $('#Sharestan_t').val($('#Shahrestan').val());
                $('#PostalCode_t').val($('#PostalCode').val());
                $('#Province_t').val($('#Province').val());
                $('#LocationName_t').val($('#LocationName').val());



                return true;
            }




        }

        function PeykDelever() {
            if (checkaddress()) {
                $('#shipping').val('peyk');
                changeshiping(0);
                $('#DeleverNote').html(' هزینه ارسال به صورت پس کرایه و حداقل ۳۰ هزار تومان به بالا است');

                $('#TotalDeleveryPriceFinal').html(' پس کرایه');
                window.DeleverPyek = 0;
                $TotalTopay = $('#TotalPrice').val();
                $TotalTopay = formatCurrency($TotalTopay / window.CurencyRate);
                $('#TotalTopay').html($TotalTopay + window.CurencyName);
            }
        }

        function AskAndDelever() {
            if (checkaddress()) {
                $('#shipping').val('ask');
                changeshiping(0);
                $('#DeleverNote').html(' با مراجعه حضوری به شرکت می‌توانید سفارش خود را دریافت کنید');
                $('#TotalDeleveryPriceFinal').html('مراجعه حضوری ');
                window.DeleverPyek = 0;
                $TotalTopay = $('#TotalPrice').val();
                $TotalTopay = formatCurrency($TotalTopay / window.CurencyRate);
                $('#TotalTopay').html($TotalTopay + window.CurencyName);
            }
        }

        function AutoDelever() {
            if (checkaddress()) { //zahra todo
                $('#shipping').val('post'); //zahra todo
                $LocationCode = $('input[name="Location"]:checked').val();
                if ($LocationCode != 0) { //Old Place
                    $LocationProvince = $('#LocationProvince_' + $LocationCode).val();
                    $LocationCity = $('#LocationCity_' + $LocationCode).val();
                } else { //New Place
                    $LocationProvince = $('#Province').val();
                    $LocationCity = $('#Shahrestan').val();
                }
                TotalPrice = $('#TotalPrice').val();
                Totalweight = $('#Totalweight').val();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.post('<?php echo e(route('ajax')); ?>', {
                        AjaxType: 'GetDeleverPrice',
                        rate_type: 'tapin',
                        price: TotalPrice,
                        weight: Totalweight,
                        pay_type: '1',
                        to_province: $LocationProvince,
                        from_province: '1',
                        to_city: $LocationCity,
                        from_city: '1',

                    },

                    function(data, status) {
                        window.DeleverPyek = data;
                        changeshiping(data / window.CurencyRate);
                        $Price = formatCurrency(data / window.CurencyRate);

                        $('#TotalDeleveryPriceFinalInput').val(data);
                        $('#DeleverNote').html(' مبلغ' + $Price + ' ' + window.CurencyName +
                            '  جهت ارسال به فاکتور اضافه خواهد شد ');
                        $('#TotalDeleveryPriceFinal').html($Price + ' ' + window.CurencyName);
                        $('#TotalDeleveryPriceFinal').removeClass('nested');
                        $TotalTopay = parseInt($('#TotalPrice').val()) + parseInt(data);
                        $TotalTopay = formatCurrency($TotalTopay / window.CurencyRate);
                        $('#TotalTopay').html($TotalTopay + ' ' + window.CurencyName);
                        $('#shippingbtn').removeClass('disabled');

                    });

            }


        }
    </script>
    <script>
        function formatCurrency(total) {
            return total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }
    </script>
    <script>
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

        function changepayment($paytype) {

            $('#paymentfild').val($paytype);
        }
    </script>
@endsection

@php
    $Persian = new App\Functions\persian();
@endphp
@extends('Layouts.Theme5.layout.main_layout')
@section('content')
    <main class="main-content dt-sl mb-3">
        <div class="container main-container">
            <div class="row mx-0">
                <div class="col-12">
                    <div id="maincontent" class="row">
                    </div>
                </div>
            </div>

        </div>
    </main>
    <script>
        var $location = 0;
    </script>
@endsection
@section('end_script')
    <script>
        function slect_address(Locations) {
            $(".ct option[value='X']").each(function() {
                $(this).remove();
            });
            $(".ct option[value='X']").remove();


            $('.select_btn').removeClass('d-none');
            $('.selected_btn').addClass('d-none');
            $('#select_btn_' + Locations).addClass('d-none');
            $('#selected_btn_' + Locations).removeClass('d-none');
            $('.checkout-address-box').removeClass('is-selected-new');
            $('#loc_' + Locations).addClass('is-selected-new');
            $('#Locations').val(Locations);
            set_location_address(Locations);
        }

        function slect_address_to_remove(Locations) {
            $location_id = Locations;
        }

        function removeaddress() {
            if ($location_id == $('#Locations').val()) {
                $('.checkout-address-box').removeClass('is-selected');
                $('#Locations').val(0);


            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('/ajax', {
                    AjaxType: 'remove_user_address',
                    location_id: $location_id,
                },

                function(data, status) {
                    if (data) {
                        steper('FinalizeOrder');
                    } else {
                        alert('مشکلی پیش آمده لطفا دقایقی دیگر مجدد تلاش کنید.');
                    }

                });


        }

        function add_user_address() {

            
            LocationName_i = $('#LocationName').val();
            $('.address-input').removeClass('is-invalid');
            validation = true;

            if (LocationName_i == '') {
                $('#LocationName').addClass('is-invalid');
                validation = false;
                //  alert('لطفا عنوان آدرس را وارد کنید.');
                // return true;
            }
            mobile_no_i = $('#mobile_no').val();
            PostalCode_i = $('#PostalCode').val().replace(/[^0-9 ,^۰-۹]/g,'');
            if (PostalCode_i == '') {
                $('#PostalCode').addClass('is-invalid');
                validation = false;
                // alert('لطفا کد پستی را وارد کنید، درصورتی که کد پستی خود را نمیدانید عدد ۰ را وارد کنید');
                //return true;
            } else {
                if (PostalCode_i.length != 10) {
                    validation = false;
                    $('#PostalCode').addClass('is-invalid');
                    alert('کد پستی وارد شده درست نیست!');
                    return false;
                }

            }
            Province_i = $('#Province option:selected').val();
            if (Province_i == 0) {
                $('#Province').addClass('is-invalid');
                validation = false;
                // alert('لطفا استان را مشخص کنید');
                //return true;
            }
            Shahrestan_i = $('#Shahrestan option:selected').val();
            if (Shahrestan_i == 0) {
                $('#Shahrestan').addClass('is-invalid');
                validation = false;
                // alert('لطفا شهرستان را مشخص کنید');
                //return true;
            }
            OthersAddress_i = $('#OthersAddress').val();
            if (OthersAddress_i == '') {
                $('#OthersAddress').addClass('is-invalid');
                validation = false;
                //  alert('لطفا آدرس را وارد کنید.');
                //return true;
            }
            if (!validation) {
                alert('لطفا اطلاعات آدرس را وارد کنید.');
                return true;
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('/ajax', {
                    AjaxType: 'add_user_address',
                    Location: $location,
                    LocationName: LocationName_i,
                    mobile_no: mobile_no_i,
                    PostalCode: PostalCode_i,
                    Province: Province_i,
                    Shahrestan: Shahrestan_i,
                    OthersAddress: OthersAddress_i
                },

                function(data, status) {
                    if (data) {
                        if ($location == 0) {
                            success_alert('آدرس جدید افزوده شد', 'عملیات موفق');

                        } else {
                            success_alert('آدرس با موفقیت ویرایش  شد', 'عملیات موفق');

                        }
                        steper('FinalizeOrder');
                    } else {
                        alert('مشکلی پیش آمده لطفا دقایقی دیگر مجدد تلاش کنید.');
                    }

                });





        }
    </script>
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

        function add_new_location() {
            $('#main_address_selector').addClass('d-none');
            $('#InputAddress').removeClass('d-none');
            $('#save_btn').removeClass('d-none');
            $('#edit_btn').addClass('d-none');
            $location = 0;

        }

        function edit_location(loc_id, loc_name, phone, OthersAddress, PostalCode, Province, City) {
            $location = loc_id;
            $('#LocationName').val(loc_name);
            $('#mobile_no').val(phone);
            $('#Province').val(Province).change();
            $('#Shahrestan').val(City);
            $('#PostalCode').val(PostalCode);
            $('#OthersAddress').text(OthersAddress);
            $('#main_address_selector').addClass('d-none');
            $('#InputAddress').removeClass('d-none');
            $('#save_btn').addClass('d-none');
            $('#edit_btn').removeClass('d-none');
        }

        function reverse_add_new_location() {
            $('#main_address_selector').removeClass('d-none');
            $('#InputAddress').addClass('d-none');

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
                        location.reload();
                        reloadbasket();
                    } else if (response.result === true) {
                        location.reload();
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

        function LoadCityIndependent() {
            Province = $('#Province').val();
            if (Province == 0) {
                alert('لطفا ابتدا استان را مشخص کنید.');
                return null;
            }
            LoadCitys(Province);

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

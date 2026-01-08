@php
    $Persian = new App\Functions\persian();
@endphp
@extends('Layouts.MainPage')
@section('page-header-left')
@endsection
@section('MainCountent')
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-lg-6">
                    <div class="page-header-left">
                        <h3>پنل
                            <small>صندوقدار</small>
                        </h3>
                    </div>
                </div>
                <div class="col-lg-3">
                    <ol class="breadcrumb pull-right">
                        @include('Layouts.AddressBar')
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div id="licens_view" class="row">
        <div class="col-lg-4 col-md-3 col-sm-6 col-xs-12 mb-4" style="cursor: pointer">
            <a onclick="loadpage('CustomerDefine')">
                <div id="ExamList" class="selectors p-4 rounded d-flex align-items-center bg-primary text-white">
                    <i class="i-Address-Book text-32 mr-3"></i>
                    <div>
                        <h4 class="text-18 mb-1 text-white">معرفی مشتری</h4>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-4 col-md-3 col-sm-6 col-xs-12 mb-4" style="cursor: pointer">
            <div class="loadscreen" id="preloader1" style="display: none;">
                <div class="loader spinner-bubble spinner-bubble-primary">
                </div>
            </div>
            <a onclick="loadpage('ProductList')">
                <div id="ProductList" class="selectors p-4 rounded d-flex align-items-center bg-primary text-white">
                    <i class="i-Add-Window text-32 mr-3"></i>
                    <div>
                        <h4 class="text-18 mb-1 text-white">ثبت سبد خرید</h4>
                    </div>
                </div>
            </a>
        </div>


        {{--  <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 mb-4" style="cursor: pointer">
            <a onclick="loadpage('finalyzeinvoice')">
                <div id="CampinLsit" class="selectors p-4 rounded d-flex align-items-center bg-primary text-white">
                    <i class="i-Dollar text-32 mr-3"></i>
                    <div>
                        <h4 class="text-18 mb-1 text-white"> لیست سفارشات من</h4>
                    </div>
                </div>
            </a>
        </div> --}}

        <div class="col-lg-4 col-md-3 col-sm-6 col-xs-12 mb-4" style="cursor: pointer">
            <a onclick="loadpage('chasiarinfo')">
                <div class="selectors p-4 rounded d-flex align-items-center
                bg-primary text-white">
                    <i class="i-Cash-register-2 text-32 mr-3"></i>
                    <div>
                        <h4 class="text-18 mb-1 text-white">صندوق من </h4>
                    </div>
                </div>
            </a>
        </div>

    </div>
    </div>
    <hr>
    <div id="main_content">
    </div>
@endsection
@section('page-js')
    <script>
        window.UserName = null;



        function addcustomer() {
            $('#main_content').html(
                `<iframe src="/UserCreate?if=true" onload='javascript:(function(o){o.style.height=o.contentWindow.document.body.scrollHeight+"px";}(this));' style="height:200px;width:100%;border:none;overflow:hidden;"></iframe>`
            );
        }

        function EditCustomer() {
            UserName = $('#CustomerUserName').val();
            $('#main_content').html(`<iframe src="/UserProfile/` + UserName +
                `?if=true" onload='javascript:(function(o){o.style.height=o.contentWindow.document.body.scrollHeight+"px";}(this));' style="height:200px;width:100%;border:none;overflow:hidden;"></iframe>`
            );
        }

        function finalyze() {
            //loader show
            $('#preloader1').removeAttr("style");
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('', {

                    ajax: true,
                    procedure: 'finalyze',

                },
                function(data, status) {
                    if (data == 0) {
                        $('#preloader1').attr("style", "display: none;");
                        alert('مشکلی به وجود آمده است ');
                    } else {
                        loadpage('chasiarinfo');
                        $('#preloader1').attr("style", "display: none;");

                    }
                    //redirect
                });
        }

        function removeCustomer() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('', {
                    ajax: true,
                    procedure: 'removeCustomer',

                },
                function(data, status) {
                    alert('مشتری فراموش گردید!');
                    loadpage('CustomerDefine');
                });

        }

        function removeitem($ProductID) {
            $('#preloader1').removeAttr("style");
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('', {
                    ajax: true,
                    procedure: 'removeitem',
                    ProductID: $ProductID,

                },

                function(data, status) {
                    loadpage('BasketList', 'product_table_detial');
                    $('#preloader1').attr("style", "display: none;");



                });

        }

        function definecustomer() {
            $UserName = $('#user_search_responser_text').val();
            if ($UserName == '') {
                alert('نام کاربری وارد نشده است!');
            }
            window.UserName = $UserName;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('', {
                    ajax: true,
                    procedure: 'definecustomer',
                    UserName: $UserName,

                },
                function(data, status) {
                    if(data.result == true){
                        loadpage('CustomerDefine');

                    }
                    else{
                        alert('کاربر مورد نظر یافت نشد');
                    }
                });

        }


        function changeselectors(TargetPage) {
            $('.selectors').removeClass('bg-success');
            $('.selectors').addClass('bg-primary');
            $('#' + TargetPage).addClass('bg-success');
            $('#' + TargetPage).removeClass('bg-primary');
        }

        function loadpage(TargetPage, TargetID = null) {
            changeselectors(TargetPage);
            $.ajax({
                url: '?page=' + TargetPage,
                type: 'get',
                beforeSend: function() {

                },
                success: function(response) {
                    if (TargetID == null) {
                        $('#main_content').html(response);

                    } else {
                        $('#' + TargetID).html(response);
                    }

                },
                error: function() {
                    alert('can not');

                }
            });
        }


        function loadpage_with_data(TargetPage, data) {
            $.ajax({
                url: '?page=' + TargetPage + '&data=' + data,
                type: 'get',
                beforeSend: function() {

                },
                success: function(response) {
                    $('#main_content').html(response);

                },
                error: function() {
                    alert('can not');

                }
            });
        }



        function estelam($TargetUserName,$MobileNumber) {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('<?php echo e(route('ajax')); ?>', {
                    AjaxType: 'tavanpardakhtAdminfn',
                    TargetMelliID: $TargetUserName,
                    TargetMobileNumber: $MobileNumber,

                },

                function(data, status) {
                    if (data == 'notvalid') {
                        alert('notvalid');
                    } else {
                        $('#tavan').html(data);


                    }
                });

        }
    </script>

    <script>


        function defineusercredit($TargetUserName,$MobileNumber) {
            $Periodcredit = $('#Periodcredit').val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('<?php echo e(route('ajax')); ?>', {
                    AjaxType: 'tavanpardakhtAdminAdd',
                    TargetMelliID: $TargetUserName,
                    TargetMobileNumber: $MobileNumber,
                    TargetPeriodcredit: $Periodcredit,

                },

                function(data, status) {
                    if (data == 'notvalid') {
                        alert('notvalid');
                    } else {
                        $('#tavan').html(data);


                    }
                });

        }
    </script>
    <script>
        function Search_Product() {
            $searchtext = $('#product_search_text').val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('', {
                    ajax: true,
                    procedure: 'search',
                    searchtext: $searchtext,

                },
                function(data, status) {
                    $('#product-list-suggesstion-box').html(data);
                });
        }

        function addtobasket($ProductID, $row, $Tashim = null) {
            $Qty = $('#Qty_' + $row).val();
            $Pw_id = $('#wgid_' + $row).val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('', {
                    ajax: true,
                    procedure: 'addtobasket',
                    Qty: $Qty,
                    ProductID: $ProductID,
                    Pw_id: $Pw_id,
                    Tashim: $Tashim,
                },
                function(data, status) {
                    loadpage('BasketList', 'product_table_detial');
                });

        }

        function get_Product_tashims($ProductID, $row) {
            $Qty = $('#Qty_' + $row).val();
            $Pw_id = $('#wgid_' + $row).val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('', {
                    ajax: true,
                    procedure: 'FindProductTashim',
                    ProductID: $ProductID,
                    Pw_id: $Pw_id,
                    row: $row,
                },
                function(data, status) {
                    $('#but_continner_' + $row).html(data);
                });

        }
    </script>
@endsection

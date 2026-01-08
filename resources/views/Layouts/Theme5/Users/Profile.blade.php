@extends('Layouts.Theme5.layout.main_layout')
@section('content')
    <main class="main-content dt-sl mb-3">
        <div class="container main-container">
            <div class="row">
                <!-- Start Sidebar -->
                <div class="col-xl-3 col-lg-4 col-md-4 col-sm-12 sticky-sidebar">
                    <div class="profile-sidebar dt-sl">
                        <div class="dt-sl dt-sn border mb-3">
                            <div class="profile-menu-section dt-sl">
                                <div class="label-profile-menu mt-2 mb-2">
                                    <span>حساب کاربری شما</span>
                                </div>
                                <div class="profile-menu">
                                    <ul>
                                        <li>
                                            <a id="profile_main" href="javascript:load_section('profile_main')"
                                                class="profile_side active">
                                                <i class="mdi mdi-account-circle-outline"></i>
                                                پروفایل
                                            </a>
                                        </li>
                                        <li>
                                            <a id="profile_order" href="javascript:load_section('profile_order')"
                                                class="profile_side">
                                                <i class="mdi mdi-basket"></i>
                                                همه سفارش ها
                                            </a>
                                        </li>
                                        <li>
                                            <a id="profile_addresses" href="javascript:load_section('profile_addresses')"
                                                class="profile_side">
                                                <i class="mdi mdi-sign-direction"></i>
                                                آدرس ها
                                            </a>
                                        </li>
                                        <li>
                                            <a id="edit_profile" class="profile_side"
                                                href="javascript:load_section('edit_profile')">
                                                <i class="mdi mdi-account-edit-outline"></i>
                                                اطلاعات شخصی
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Sidebar -->
                <!-- Start Content -->
                <div id="main_profile_continer" class="col-xl-9 col-lg-8 col-md-8 col-sm-12">

                </div>
                <!-- End Content -->
            </div>

        </div>
    </main>
@endsection
@section('end_script')
    <script>
        function add_user_address() {
            LocationName_i = $('#LocationName').val();
            if (LocationName_i == '') {
                alert('لطفا عنوان آدرس را وارد کنید.');
                return true;
            }
            mobile_no_i = $('#mobile_no').val();
            PostalCode_i = $('#PostalCode').val();
            if (PostalCode_i == '') {
                alert('لطفا کد پستی را وارد کنید، درصورتی که کد پستی خود را نمیدانید عدد ۰ را وارد کنید');
                return true;
            }
            Province_i = $('#Province option:selected').val();
            if (Province_i == 0) {
                alert('لطفا استان را مشخص کنید');
                return true;
            }
            Shahrestan_i = $('#Shahrestan option:selected').val();
            if (Shahrestan_i == 0) {
                alert('لطفا شهرستان را مشخص کنید');
                return true;
            }
            OthersAddress_i = $('#OthersAddress').val();
            if (OthersAddress_i == '') {
                alert('لطفا آدرس را وارد کنید.');
                return true;
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('/ajax', {
                    AjaxType: 'add_user_address',
                    LocationName: LocationName_i,
                    mobile_no: mobile_no_i,
                    PostalCode: PostalCode_i,
                    Province: Province_i,
                    Shahrestan: Shahrestan_i,
                    OthersAddress: OthersAddress_i
                },

                function(data, status) {
                    if (data) {
                        steper('FinalizeOrder');
                    } else {
                        alert('مشکلی پیش آمده لطفا دقایقی دیگر مجدد تلاش کنید.');
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
    <script>
        function return_to_orders() {
            $('#all_orders').removeClass('d-none');
            $('#order_detail').html('');
        }

        function load_order(order_id) {
            $('#all_orders').addClass('d-none');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('', {
                    ajax: true,
                    function: 'load_order',
                    order_id: order_id
                },

                function(data, status) {
                    if (status == 'success') {
                        $('#order_detail').html(data);
                    } else {
                        alert('بروز خطا');
                    }
                });
        }
    </script>
    <script>
        $(document).ready(
            function() {
                load_section('profile_main');
            }
        )

        function load_section(section_name) {
            $('.profile_side').removeClass('active');
            $('#' + section_name).addClass('active');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('', {
                    ajax: true,
                    function: section_name,
                },

                function(data, status) {
                    if (status == 'success') {
                        $('#main_profile_continer').html(data);

                    } else {
                        alert('بروز خطا');
                    }
                });


        }

        function unmark(product_id) {
            $('#mark_' + product_id).addClass('d-none');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('/ajax', {
                    ajax: true,
                    AjaxType: 'product_mark',
                    product_id: product_id,
                },

                function(data, status) {
                    if (data['result']) {

                    } else {
                        alert(data['msg']);
                    }

                });
        }
    </script>
@endsection

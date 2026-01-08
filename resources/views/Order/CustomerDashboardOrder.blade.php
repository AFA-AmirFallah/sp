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
    @php
        $active_order_src = $orders->get_active_orders();
    @endphp
    <div id="app">
        <patascustomer></patascustomer>
    </div>
    <div id="my_service" class="card">
        <div class="card-header gradient-purple-indigo 0-hidden pb-80">
            <h5 class="text-white"><i class=" header-icon i-Full-Basket"></i>درخواست های من </h5>
        </div>
        <div class="card-body">
            <section class="product-cart" style="width: 100%">
                <div class="row list-grid">
                    @foreach ($active_order_src as $OrderItem)
                        <div class="list-item col-md-3">
                            <div class="card  card-primary o-hidden mb-4 d-flex flex-column">
                                <div class="list-thumb d-flex">
                                    <img alt="" src="{{ $OrderItem->Pic }}">
                                </div>
                                <div class="flex-grow-1 d-bock">
                                    <div
                                        class="card-body align-self-center d-flex flex-column justify-content-between align-items-lg-center">
                                        <a class="w-40 w-sm-100" href="">
                                            <div class="item-title">
                                                {{ $OrderItem->Cat }}
                                            </div>
                                        </a>
                                        وضعیت:
                                        {{ $OrderItem->TitleDescription }} 
                                        <hr>
                                        <p>
                                            {{ $OrderItem->StatusName }} در  : {{$OrderItem->branch_desc}} 
                                            <img width="40px" src="{{$OrderItem->branch_avatar}} " alt="{{$OrderItem->branch_desc}} ">
                                        </p>
                                        <small>
                                            تاریخ ثبت: {{ $Persian->MyPersianDate($OrderItem->regdate, true) }}
                                        </small>

                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div class="list-item col-md-3">
                        <div class="card  card-primary o-hidden mb-4 d-flex flex-column">
                            <div class="list-thumb d-flex">
                                <img alt="add service"
                                    src="https://panel.shafatel.com/storage/photos/admin/add_service.jpg">
                            </div>
                            <div class="flex-grow-1 d-bock">
                                <div
                                    class="card-body align-self-center d-flex flex-column justify-content-between align-items-lg-center">
                                    <a class="w-40 w-sm-100" href="">
                                        <div class="item-title">
                                            ثبت درخواست جدید
                                        </div>
                                    </a>
                                    ثبت درخواست در مراکز ارائه دهنده خدمات
                                    <hr>
                                    <button id="addobject" type="button" onclick="add_service()"
                                        data-target=".bd-example-modal-lg" class="btn btn-primary btn-block m-1 mb-3"><i
                                            class="nav-icon i-Add"></i>
                                        ثبت درخواست جدید
                                    </button>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </section>

        </div>
    </div>
    <script>
        function add_service() {
            $('#my_service').addClass('nested');
            $('#new_service_list').removeClass('nested');
        }
        function my_service(){
            $('#my_service').removeClass('nested');
            $('#new_service_list').addClass('nested');
        }
    </script>

    <div id="new_service_list"  class="nested card">
        <div class="card-header gradient-purple-indigo 0-hidden pb-80">
            <h5 class="text-white"><i class=" header-icon i-Full-Basket"></i> افزودن درخواست جدید</h5>
            <button type="button" class="close" onclick="my_service()" aria-label="Close"
                style="
            position: absolute;
            left: 10px;
            color: white;
            top: 10px;
        ">
                <span aria-hidden="true">×</span>
            </button>
        </div>
        @php
            $serviceCount = 0;
        @endphp
        <div class="card-body">




            <section class="product-cart" style="width: 100%">
                <div id="data_temp" class="product-wrapper row cols-md-3 cols-sm-2 cols-2">
                    @php
                        $Conter = 0;
                    @endphp

                    @foreach ($cat_orders as $cat_orders_item)
                        @php
                            $Conter++;
                        @endphp
                        <div class="list-item col-md-3">
                            <div class="card  card-primary o-hidden mb-4 d-flex flex-column">
                                <div class="list-thumb d-flex">
                                    <img alt="{{ $cat_orders_item->TitleDescription }}" src="{{ $cat_orders_item->Pic }}">
                                </div>
                                <div class="flex-grow-1 d-bock">
                                    <div
                                        class="card-body align-self-center d-flex flex-column justify-content-between align-items-lg-center">
                                        <a class="w-40 w-sm-100" href="">
                                            <div class="item-title">
                                                {{ $cat_orders_item->Cat }}
                                            </div>
                                        </a>

                                        {{ $cat_orders_item->TitleDescription }}
                                        <hr>

                                        @if ($cat_orders_item->centers > 0)
                                            <div class="st-blog-label"> {{ $cat_orders_item->centers }} <a
                                                    href="{{ route('CustomerOrder', ['OrderID' => $cat_orders_item->Cat]) }}">مرکز
                                                    ارائه دهنده</div>
                                            <div class="product-pa-wrapper">
                                                <div class="product-price">
                                                    <button id="addobject" type="button" data-toggle="modal"
                                                        onclick="" data-target=".bd-example-modal-lg"
                                                        class="btn btn-primary btn-md m-1"><i class="nav-icon i-Add"></i>
                                                        ثبت درخواست
                                                    </button>

                                                </div>
                                            </div>
                                        @else
                                            <div class="product-pa-wrapper">
                                                <div class="product-price">
                                                    <p style="color: red !important" class="m-0 text-small text-muted">
                                                        ارائه دهنده خدمت وجود ندارد </p>
                                                </div>
                                            </div>
                                        @endif


                                        <p class="m-0 text-muted text-small w-15 w-sm-100 d-none d-lg-block item-badges">

                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    @if ($Conter == 0)
                        <script>
                            show_moredata(2);
                        </script>
                    @elseif ($Conter == 10)
                        <script>
                            window.loaddatainit = true;
                            show_moredata(1);
                        </script>
                    @else
                        <script>
                            window.loaddatainit = true;
                            show_moredata(3);
                        </script>
                    @endif
                </div>




            </section>


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
    <!-- page script -->



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

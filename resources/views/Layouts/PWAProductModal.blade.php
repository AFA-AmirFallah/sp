<style>
    .takhfif {
        margin-top: 6px;
        text-align: center;
    }

    .requestNumber {
        border: none;
        height: 100%;
        background-color: transparent;
        color: #fff;
        -moz-text-align-last: center;
        text-align-last: center;
        margin: 0 40 px 0 12 px;
        outline: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        text-indent: 1 px;
    }

    .SelectStyle1106 {
        width: 128px;
        background-color: #0a0a0a;
        color: white;
        border-radius: 6px 0px 0px 6px;
        border-width: 0;
        direction: rtl;
        padding-right: 25px;
        text-align: center;
    }

    .CustomerServiceCardHeader12 {
        font-size: 1.25rem !important;
        text-align: center;
    }

    .pricesume {
        text-align: center;
        color: green;
        background: darkgrey;
        padding: 10px;
        width: fit-content;
        font-size: 17px;
        border-radius: 5px;
        border-color: chartreuse;
        border-width: 10px;
        display: initial;
    }

    .percentdiv {
        background-color: #2edd2eb5;
        text-align: center;
        font-size: 20px;
        border-radius: 2px;
        text-shadow: 2px 2px 5px red;
        margin-top: -29px;
        padding-top: 21px;
    }

</style>
<div class="ul-card-list__modal">
    <div id="modal" class="modal_bottom_PWA fade bd-example-modal-lg" tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modalPWA">
            <div class="modal-content">
                <div class="modal-header">
                    <img src="{{ \App\myappenv::FavIcon }}" style="width: 25px">
                    {{ \App\myappenv::CenterName }}
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post">
                        @csrf
                        <div class="form-group row">
                            <img id='modal_product_img' src="" alt="">
                        </div>
                        <h6 id="Modal_product_name" class="CustomerServiceCardHeader12 m-0"></h6>



                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end::modal -->
<script>
    function alertme() {
        $OrderText = $('#alertnote').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.post('<?php echo e(route('ajax')); ?>', {
                AjaxType: 'alertme',
                OrderText: $OrderText,
                GoodID: $('#AddToBasketbtn').val(),
            },
            function(data, status) {
                if (data == 'Added') {
                    alert(
                        'با تشکر از شما در صورت موجود شدن این کالا شما را از طریق پیامک یا ایمل مطلع خواهیم نمود!'
                    );

                    $("#alertbtn").addClass('nested');
                    $("#customertextaria").addClass('nested');


                } else if (data == 'not login') {
                    alert('جهت ثبت درخواست می باید به سیستم وارد شوید!');
                }


            });
    }
</script>
<script>
    function incQty() {
        if (parseInt($('#Qty').val()) < parseInt($('#TotalQty').val())) {
            $('#Qty').val(parseInt($('#Qty').val()) + 1);
            if (window.PricePlan == 'no') {
                $Totall = window.Price * parseInt($('#Qty').val());
                $Benefit = window.Benefit * parseInt($('#Qty').val());
                $("#totoall_div").text('مجموع : ' + number_format($Totall) + ' ریال ');
                $("#totall_benefit").text('سود شما از خرید : ' + number_format($Benefit) + ' ریال ');
            } else {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.post('<?php echo e(route('ajax')); ?>', {
                        AjaxType: 'GetInformolaPrice',
                        JsonPlan: window.PricePlan,
                        Qty: parseInt($('#Qty').val()),
                    },
                    function(data, status) {
                        $basePrice = data;
                        $TargetBase = $basePrice;
                        $Totall = data * parseInt($('#Qty').val());
                        $Benefit = window.BasePrice * parseInt($('#Qty').val()) - $Totall;
                        $("#totoall_div").text('مجموع : ' + number_format($Totall) + ' ریال ');
                        $("#totall_benefit").text('سود شما از خرید : ' + number_format($Benefit) + ' ریال ');

                    });
                $.post('<?php echo e(route('ajax')); ?>', {
                        AjaxType: 'GetBaseInformolaPrice',
                        JsonPlan: window.PricePlan,
                        Qty: parseInt($('#Qty').val()),
                    },
                    function(data, status) {
                        $basePrice = "مبلغ پایه: " +
                            '<del id="Modal_product_base_price" class="formola_break text-secondary"> ' +
                            number_format(window.BasePrice) + ' ریال</del>';
                        $basePrice += data;
                        $basePrice += number_format($TargetBase) + ' ریال';
                        $("#totoall_base_div").html($basePrice);

                    });


            }
        }
    }

    function decQty() {
        if (parseInt($('#Qty').val()) == 1) {} else {
            $('#Qty').val(parseInt($('#Qty').val()) - 1);
            if (window.PricePlan == 'no') {
                $Totall = window.Price * parseInt($('#Qty').val());
                $Benefit = window.Benefit * parseInt($('#Qty').val());
                $("#totoall_div").text('مجموع : ' + number_format($Totall) + ' ریال ');
                $("#totall_benefit").text('سود شما از خرید : ' + number_format($Benefit) + ' ریال ');
            } else {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.post('<?php echo e(route('ajax')); ?>', {
                        AjaxType: 'GetInformolaPrice',
                        JsonPlan: window.PricePlan,
                        Qty: parseInt($('#Qty').val()),
                    },
                    function(data, status) {
                        $basePrice = data;
                        $TargetBase = $basePrice;
                        $Totall = data * parseInt($('#Qty').val());
                        $Benefit = window.BasePrice * parseInt($('#Qty').val()) - $Totall;
                        $("#totoall_div").text('مجموع : ' + number_format($Totall) + ' ریال ');
                        $("#totall_benefit").text('سود شما از خرید : ' + number_format($Benefit) + ' ریال ');

                    });
                $.post('<?php echo e(route('ajax')); ?>', {
                        AjaxType: 'GetBaseInformolaPrice',
                        JsonPlan: window.PricePlan,
                        Qty: parseInt($('#Qty').val()),
                    },
                    function(data, status) {
                        $basePrice = "مبلغ پایه: " +
                            '<del id="Modal_product_base_price" class="formola_break text-secondary"> ' +
                            number_format(window.BasePrice) + ' ریال</del>';
                        $basePrice += data;
                        $basePrice += number_format($TargetBase) + ' ریال';
                        $("#totoall_base_div").html($basePrice);

                    });


            }
        }

    }
</script>
<script>
    function MultiPrice(ProductName, ProductWarehouseID, GoodID, Image, Price, BasePrice, PricePlan) {
        window.BasePrice = BasePrice;
        window.PricePlan = PricePlan;
        $('#Description').html($('#text_' + GoodID).html());
        $('#Attrebute').html($('#desc_' + GoodID).html());
        $('#totoall_base_div').removeClass('nested');
        $("#Modal_product_name").text('نام محصول : ' + ProductName);
        $("#modal_product_img").attr("src", Image);
        $('#Qty').val(1);
        $('#AddToBasketbtn').val(GoodID);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.post('<?php echo e(route('ajax')); ?>', {
                AjaxType: 'GetBasicInfoToloadModal',
                JsonPlan: PricePlan,
                Qty: 1,
            },
            function(data, status) {
                $MinPrice = data['MinPrice'];
                $MaxPrice = data['MaxPrice'];
                $initformola = data['initformola'];
                Price = data['Price'];
                $("#Modal_product_price").text('مبلغ : از ' + number_format($MinPrice) + ' تا ' + number_format(
                        $MaxPrice) +
                    ' ریال ');
                $("#totoall_div").text('مجموع : ' + number_format(Price) + ' ریال ');
                $("#Modal_product_base_price").text('مبلغ : ' + number_format(BasePrice) + ' ریال ');
                $("#totall_benefit").text('سود شما از خرید : ' + number_format(BasePrice - Price) + ' ریال ');
                $basePrice = "مبلغ پایه: " +
                    '<del id="Modal_product_base_price" class="formola_break text-secondary">  ' +
                    number_format(window.BasePrice) + ' ریال</del> ';
                $basePrice += $initformola;
                $basePrice += number_format(Price) + ' ریال';
                $("#totoall_base_div").html($basePrice);

            });
        $('#index_table').addClass('nested');
        $('#index_table_loader').removeClass('nested');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.post('<?php echo e(route('ajax')); ?>', {
                AjaxType: 'GetProductInfo',
                ProductWarehouseID: ProductWarehouseID,
                GoodID: GoodID,
            },
            function(data, status) {
                $JsonIndex = data[0];
                $TotalQty = data[1];
                if ($TotalQty > 0) {
                    $('#TotalQty').val($TotalQty * 1);
                    $('.buyform').removeClass('nested');
                    $('#finishproduct').addClass('nested');
                } else {
                    $('.buyform').addClass('nested');
                    $('#finishproduct').removeClass('nested');
                }
                if ($JsonIndex != '') {
                    myArr = JSON.parse($JsonIndex);
                    $("#index_table > tbody").html("");
                    $.each(myArr, function() {
                        $("#index_table").find('tbody')
                            .append($('<tr>')
                                .append($('<td>')
                                    .append($('<p>')
                                        .text($(this)[0].l2name)
                                    )
                                )
                                .append($('<td>')
                                    .append($('<p>')
                                        .text($(this)[0].l3name)
                                    )
                                )
                            );
                    });
                }
                $('#index_table_loader').addClass('nested');
                $('#index_table').removeClass('nested');
            });
        $("body").attr("style", "padding-right: -15px;");
    }

    function SinglePrice(ProductName, ProductWarehouseID, GoodID, Image, Price, BasePrice) {

        $('#totoall_base_div').addClass('nested');
        $('#Description').html($('#text_' + GoodID).html());
        $('#Attrebute').html($('#desc_' + GoodID).html());
        window.PricePlan = 'no';
        window.Price = Price;
        window.BasePrice = BasePrice;
        window.Benefit = BasePrice - Price;
        $('#PricePlan').val('no');
        $("#Modal_product_name").text('نام محصول : ' + ProductName);
        $("#Modal_product_price").text('مبلغ : ' + number_format(Price) + ' ریال ');
        $("#totoall_div").text('مجموع : ' + number_format(Price) + ' ریال ');
        if (Price != BasePrice) {
            $("#Modal_product_base_price").text('مبلغ : ' + number_format(BasePrice) + ' ریال ');
            $("#totall_benefit").text('سود شما از خرید : ' + number_format(BasePrice - Price) + ' ریال ');
        } else {
            $("#Modal_product_base_price").addClass('nested');
            $("#totall_benefit").addClass('nested');
        }
        $("#modal_product_img").attr("src", Image);;
        $('#index_table').addClass('nested');
        $('#index_table_loader').removeClass('nested');
        $('#AddToBasketbtn').val(GoodID);
        $('#Qty').val(1);

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.post('<?php echo e(route('ajax')); ?>', {
                AjaxType: 'GetProductInfo',
                ProductWarehouseID: ProductWarehouseID,
                GoodID: GoodID,
            },
            function(data, status) {

                $JsonIndex = data[0];
                $TotalQty = data[1];
                if ($TotalQty > 0) {
                    $('#TotalQty').val($TotalQty * 1);
                    $('.buyform').removeClass('nested');
                    $('#finishproduct').addClass('nested');

                } else {
                    $('.buyform').addClass('nested');
                    $('#finishproduct').removeClass('nested');

                }
                if ($JsonIndex != '') {
                    myArr = JSON.parse($JsonIndex);
                    $("#index_table > tbody").html("");
                    $.each(myArr, function() {
                        $("#index_table").find('tbody')
                            .append($('<tr>')
                                .append($('<td>')
                                    .append($('<p>')
                                        .text($(this)[0].l2name)
                                    )
                                )
                                .append($('<td>')
                                    .append($('<p>')
                                        .text($(this)[0].l3name)
                                    )
                                )
                            );
                    });

                }
                $('#index_table_loader').addClass('nested');
                $('#index_table').removeClass('nested');
            });
        $("body").attr("style", "padding-right: -15px;");
    }

    function SelectProduct(ProductName, ProductWarehouseID, GoodID, Image, Price, BasePrice, PricePlan) {

        window.location.href = '<?php
            echo \App\myappenv::SiteAddress.'/product/';
        ?>'+ GoodID;
        
        if (PricePlan == null || Price != 0) {
            SinglePrice(ProductName, ProductWarehouseID, GoodID, Image, Price, BasePrice);
        } else {
            MultiPrice(ProductName, ProductWarehouseID, GoodID, Image, Price, BasePrice, PricePlan)
        }

    }
</script>
<script>
    function AddToBasket() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.post('<?php echo e(route('ajax')); ?>', {
                AjaxType: 'AddToBasket',
                ProductId: $('#AddToBasketbtn').val(),
                OrderQty: $('#Qty').val(),
            },

            function(data, status) {
                if (data) {
                    document.getElementById("basketnumber").innerHTML = data;
                    $("#basketnumber").removeClass("nested");
                    $('#modal').modal('toggle');
                    ProductId = $('#AddToBasketbtn').val();
                    $('#ProductBox_' + ProductId).addClass('BuyedProduct');

                }
            });
    }
</script>
<script>
    function ChangeQty() {
        //todo quty function applay
    }
</script>

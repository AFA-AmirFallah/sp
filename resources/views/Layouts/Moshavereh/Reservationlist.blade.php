@php
    if (!isset($searchtext)) {
        $searchtext = null;
    }
    
@endphp
@extends('Layouts.Moshavereh.objects.MainLayout')

@section('content')
    <section class="container mt-3 p-lg-3">
        <div class="row">
            <div class="col-lg-3 col-md-4 mb-3 leftcol">
                <div class="box p-4">
                    <h6 class="IRANSansWeb_Medium bt-color bg-light py-2 px-3 rad25"><i class="fas fa-filter pl-2"></i>فیلترها
                    </h6>
                    <div class="mt-3 pr-3 pl-2 pt-2 brfilter">

                        <input class="form-control" type="text" placeholder="نام متخصص">


                        <input class="form-control" type="text" placeholder="تخصص">


                        <select class="custom-select mb-2">
                            <option selected="selected">استان</option>
                            <option>تهران</option>
                            <option>گلستان</option>
                            <option>همدان</option>
                            <option>ایلام</option>
                            <option>کرمانشاه</option>
                            <option>اصفهان</option>
                            <option>گیلان</option>
                        </select>

                        <select class="custom-select mb-2">
                            <option selected="selected">شهر</option>
                            <option>آزادشهر</option>
                            <option>کلاله</option>
                            <option>گنبدکاووس</option>
                            <option>مینودشت</option>
                            <option>آزادشهر</option>
                            <option>کلاله</option>
                            <option>گنبدکاووس</option>
                            <option>مینودشت</option>
                        </select>

                        <span class="IRANSansWeb_Medium">جنسیت :</span>
                        <div>
                            <div class="icheck-info">
                                <input type="radio" checked id="primary1" name="primary" />
                                <label for="primary1">آقا</label>
                            </div>
                            <div class="icheck-info">
                                <input type="radio" id="primary2" name="primary" />
                                <label for="primary2">خانم</label>
                            </div>
                        </div>
                        <a id="searcbtn" class="btn btn-success rad25  btn-block p-2 text-white">جستجو</a>
                    </div>


                </div>
                <div id="catshow" class="box p-4 text-dark mt-4">



                </div>
            </div>


            <div class="col-lg-9 col-md-8">
                <div id="counsultingcontiner">
                </div>
            </div>

        </div>

       
    </section>

@endsection









@section('script')
    <script>
        $loadingHtml = `<div class="d-flex justify-content-center">
        <div class="loader276 "></div>
    </div>`;
    </script>
    @isset($searchtext)
        <script>
            $(document).ready(function() {
                $(window).load(function() {
                    $Mianaddress = '<?php echo route('Reservationlist'); ?>';
                    $.ajax({
                        url: $Mianaddress + '/?page=searching&q=' + '<?php echo $searchtext; ?>',
                        type: 'get',
                        beforeSend: function() {
                            $('#counsultingcontiner').html($loadingHtml)

                        },
                        success: function(response) {
                            //todo: end loading 
                            $('#counsultingcontiner').html(response)

                        },
                        error: function() {
                            //todo: end loading 
                            alert(' بروز مشکل در برقراری ارتباط');
                        }
                    });
                    $('#catshow').html('sssss');
                    $.ajax({
                        url: $Mianaddress + '/?page=cats',
                        type: 'get',
                        beforeSend: function() {
                            $('#catshow').html($loadingHtml)

                        },
                        success: function(response) {
                            //todo: end loading 
                            $('#catshow').html(response)

                        },
                        error: function() {
                            //todo: end loading 
                            alert(' بروز مشکل در برقراری ارتباط');
                        }
                    });

                });

            });

            function selectcat($catID) {
                $.ajax({
                    url: '?page=2&catID=' + $catID,
                    type: 'get',
                    beforeSend: function() {
                        //todo: start loading 
                    },
                    success: function(response) {
                        //todo: end loading 
                        $('#counsultingcontiner').html(response)

                    },
                    error: function() {
                        //todo: end loading 
                        alert(' بروز مشکل در برقراری ارتباط');
                    }
                });

            }

            function l2laoding($catID, $ZoneID) {
                $.ajax({
                    url: '?page=3&catID=' + $catID + '&ZoneID=' + $ZoneID,
                    type: 'get',
                    beforeSend: function() {
                        //todo: start loading 
                    },
                    success: function(response) {
                        //todo: end loading 
                        $('#counsultingcontiner').html(response)

                    },
                    error: function() {
                        //todo: end loading 
                        alert(' بروز مشکل در برقراری ارتباط');
                    }
                });

            }
        </script>
    @else
        <script>
            function loadcats() {
                $.ajax({
                    url: '?page=cats',
                    type: 'get',
                    beforeSend: function() {
                        $('#catshow').html($loadingHtml);

                    },
                    success: function(response) {
                        //todo: end loading 
                        $('#catshow').html(response);

                    },
                    error: function() {
                        //todo: end loading 
                        alert(' بروز مشکل در برقراری ارتباط');
                    }
                });
            }
            $(document).ready(function() {
                $(window).load(function() {
                    $.ajax({
                        url: '?page=1',
                        type: 'get',
                        beforeSend: function() {
                            $('#counsultingcontiner').html($loadingHtml)

                        },
                        success: function(response) {
                            //todo: end loading 
                            $('#counsultingcontiner').html(response);
                            loadcats();

                        },
                        error: function() {
                            //todo: end loading 
                            alert(' بروز مشکل در برقراری ارتباط');
                        }
                    });
                });


            });

            function selectcat($catID) {
                $.ajax({
                    url: '?page=2&catID=' + $catID,
                    type: 'get',
                    beforeSend: function() {
                        //todo: start loading 
                    },
                    success: function(response) {
                        //todo: end loading 
                        $('#counsultingcontiner').html(response)

                    },
                    error: function() {
                        //todo: end loading 
                        alert(' بروز مشکل در برقراری ارتباط');
                    }
                });

            }

            function l2laoding($catID, $ZoneID) {
                $.ajax({
                    url: '?page=3&catID=' + $catID + '&ZoneID=' + $ZoneID,
                    type: 'get',
                    beforeSend: function() {
                        //todo: start loading 
                    },
                    success: function(response) {
                        //todo: end loading 
                        $('#counsultingcontiner').html(response)

                    },
                    error: function() {
                        //todo: end loading 
                        alert(' بروز مشکل در برقراری ارتباط');
                    }
                });

            }
        </script>
    @endisset
@endsection

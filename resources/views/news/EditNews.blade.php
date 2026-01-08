@php
    $Persian = new App\Functions\persian();
@endphp
@extends('Layouts.MainPage')
@section('MainCountent')
    @php
        if ($News->Type == 3) {
            $news_route = route('newscat', ['newscat' => $News->TagName]);
        } else {
            if ($News->OutLink == null) {
                $news_route = route('ShowNewsItem', [
                    'NewsId' => $News->id,
                    'newsitem' => $News->Titel,
                ]);
            } else {
                $news_route = route('ShowNewsItem', [
                    'NewsId' => $News->OutLink,
                ]);
            }
        }

    @endphp
    <div class="container-fluid ">
        @include('news.Layouts.news_admin_menu',['active_menu'=>''])
        <a href="{{ route('NewsList', ['ListType' => 'news']) }}">لیست خبر ها</a>
        /

        <a href="{{ $news_route }}">نمایش محتوا</a>
        <div class="row">
            <div class="col-sm-12">
                <div class="card tab2-card">
                    <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                        <h5 class="text-white">مطلب ویرایش</h5>
                        <div style="float: left;">
                            <a id="advance-show-btn" href="javascript:show_advance();" class="btn btn-success">نمایش
                                پیشرفته</a>
                            <a id="normal-show-btn" href="javascript:show_normal();" class="btn btn-info d-none">نمایش
                                عادی</a>
                        </div>
                    </div>
                    <div class="card-body">

                        <script>
                            function show_advance() {
                                $('#advance-show-btn').addClass('d-none');
                                $('#normal-show-btn').removeClass('d-none');
                                $('.advance').removeClass('d-none');
                            }

                            function show_normal() {
                                $('#advance-show-btn').removeClass('d-none');
                                $('#normal-show-btn').addClass('d-none');
                                $('.advance').addClass('d-none');
                            }
                        </script>
                        <div>
                            <div id="mygraph" style="height: 300px;"></div>
                            <div id="news_report"></div>
                        </div>


                        <div class="tab-pane fade active show" id="edit_news" role="tabpanel"
                            aria-labelledby="contact-top-tab">

                            <div class="form-group row">
                                <div class="col-xl-3 col-md-3" style="margin-top: 14px;margin-right: 20px;">
                                    <div class="title">
                                        وضعیت محتوا
                                        @foreach (\App\myappenv::PostStatus as $PostStatus)
                                            @if ($PostStatus[0] == $News->Status)
                                                <strong>{{ $PostStatus[1] }}</strong>
                                            @endif
                                        @endforeach
                                    </div>
                                    <form method="post">
                                        @csrf
                                        @foreach (\App\myappenv::PostStatus as $PostStatus)
                                            @if ($PostStatus[0] != $News->Status)
                                                <button style="margin-top:10px;" name="change_state"
                                                    value="{{ $PostStatus[0] }}"
                                                    class="btn">{{ $PostStatus[1] }}</button>
                                            @else
                                                <button style="margin-top:10px;" name="change_state"
                                                    value="{{ $PostStatus[0] }}"
                                                    class="btn btn-success disable">{{ $PostStatus[1] }}</button>
                                            @endif
                                        @endforeach
                                    </form>
                                </div>
                                <form method="post" style="display: contents;" class="needs-validation user-add"
                                    novalidate="">
                                    @csrf
                                    <div class="col-xl-3 col-md-3" style="margin-top: 14px;margin-right: 20px;">
                                        <div class="title">
                                            نوع محتوا
                                        </div>
                                        <ul style="height: 121px;overflow-y: scroll;">
                                            <li>
                                                <input class="form-group" type="checkbox" name="adds_Direct"
                                                    @if ($News->adds == 2) checked @endif value="1">
                                                <label> تبلیغ مستقیم</label>

                                            </li>
                                            <li>

                                                <input class="form-group" type="checkbox" name="hotnews"
                                                    @if ($News->hotnews == 1) checked @endif value="1">
                                                <label> خبر داغ</label>
                                            </li>
                                            <li>
                                                <input class="form-group" type="checkbox" name="adds_Itself"
                                                    @if ($News->adds == 1) checked @endif value="1">
                                                <label>تبلیغ به خبر</label>

                                            </li>
                                            <li>
                                                <input class="form-group" type="checkbox" name="adds_Direct"
                                                    @if ($News->adds == 2) checked @endif value="1">
                                                <label> تبلیغ مستقیم</label>

                                            </li>
                                            <li>
                                                <input class="form-group" type="checkbox" name="mainbanner"
                                                    @if ($News->adds == 3) checked @endif value="3">
                                                <label>بنر اصلی</label>

                                            </li>
                                            <li>
                                                <input class="form-group" type="checkbox" name="CloseComment"
                                                    @if ($News->CommentCount == -1) checked @endif value="1">
                                                <label>بدون ثبت نظر</label>


                                            </li>
                                            <li>
                                                <input class="form-group" type="checkbox" name="Newslater"
                                                    @if ($News->Newsletter == 1) checked @endif value="1">
                                                <label>خبرنامه</label>

                                            </li>
                                            <li>
                                                <input class="form-group" type="checkbox" name="mostview"
                                                    @if ($News->mostview == 1) checked @endif value="1">
                                                <label>اخبار پربازدید</label>


                                            </li>
                                            <li>
                                                <input class="form-group" type="checkbox" name="lastnews"
                                                    @if ($News->lastnews == 1) checked @endif value="1">
                                                <label>جدیدترین مطالب</label>

                                            </li>
                                            <li>
                                                <input class="form-group" type="checkbox" name="galery"
                                                    @if ($News->galery == 1) checked @endif value="1">
                                                <label>گالری تصاویر</label>

                                            </li>
                                            <li>
                                                <input class="form-group" type="checkbox" name="mini"
                                                    @if ($News->mini == 1) checked @endif value="1">
                                                <label>صفحه اول کوچک </label>

                                            </li>
                                            <li>
                                                <input class="form-group" type="checkbox" name="larg"
                                                    @if ($News->larg == 1) checked @endif value="1">
                                                <label>صفحه اول بزرگ</label>


                                            </li>
                                            <li>
                                                <input class="form-group" type="checkbox" name="sami_index"
                                                    @if ($News->sami_index == true) checked @endif value="1">
                                                <label>نمایش به شاخص های همنام</label>

                                            </li>
                                            <li>
                                                <input class="form-group" type="radio" name="article"
                                                    @if ($News->article == 0) checked @endif value="0">
                                                <label>مطلب</label>

                                            </li>
                                            <li>
                                                <input class="form-group" type="radio" name="article"
                                                    @if ($News->article == 1) checked @endif value="1">
                                                <label>سرمقاله</label>


                                            </li>
                                            <li>
                                                <input class="form-group" type="radio" name="article"
                                                    @if ($News->article == 3) checked @endif value="3">
                                                <label>سرمقاله بی لینک</label>

                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-xl-3 col-md-3" style="margin-top: 14px;margin-right: 20px;">
                                        <img id="imagepreviw" style="float: left;max-height: 100px;"
                                            src="{{ $News->MainPic }}">
                                        <a id="lfm" data-input="modal_pic" data-preview="holder"
                                            style="
                                            position: absolute;
                                            left: 0px;
                                            bottom: 0px;
                                        "
                                            class="btn btn-primary text-white">
                                            <i class="fa fa-picture-o"></i> انتخاب تصویر
                                        </a>
                                        <input id="modal_pic" class="form-control nested" required type="text"
                                            name="pic" value="{{ $News->MainPic }}" onchange="imagesetter()">
                                    </div>
                            </div>
                            <hr>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade active show" id="account" role="tabpanel"
                                    aria-labelledby="account-tab">
                                    <div class="row">
                                        <div class="col">
                                            <h4>جزئیات خبر</h4>
                                        </div>
                                    </div>

                                    <hr>
                                    @if (\App\myappenv::Lic['MultiBranch'])
                                        <div class="form-group row ">
                                            <label for="validationCustom0" class="col-xl-3 col-md-3">شعبه <span
                                                    style="color: red">*</span></label>
                                            <select name="target_branch" class="form-control col-xl-3 col-md-3">
                                                @foreach ($branch_src as $branch_item)
                                                    <option @if ($branch_item->id == $News->branch) selected="selected" @endif
                                                        value="{{ $branch_item->id }}">
                                                        {{ $branch_item->Name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @endif
                                    <div class="form-group row">
                                        <label for="validationCustom0" class="col-xl-3 col-md-3"> دسته
                                            خبری <span style="color: red">*</span></label>
                                        <select id="NewsCat" name="NewsCat" class="form-control col-xl-3 col-md-3">
                                            @foreach ($cats as $cat)
                                                <option @if ($cat->UID == $News->MainIndex) selected="selected" @endif>
                                                    {{ $cat->Name }}</option>
                                            @endforeach
                                        </select>
                                        <label for="validationCustom0" class="col-xl-2 col-md-2">زمان درج<span
                                                style="color: red">*</span></label>
                                        <input class="form-control col-xl-3 col-md-3" name="CreateDate"
                                            autocomplete="off"
                                            onfocus="Mh1PersianDatePicker.Show(this,'{{ $Persian->MyPersianDate(date('Y-m-d'), false, 'n') }}',)"
                                            value="{{ $Persian->MyPersianDate($News->CrateDate) }}" type="text"
                                            required="">
                                    </div>
                                    <div class="form-group row advance d-none">
                                        <label for="validationCustom0" class="col-xl-3 col-md-3">بهای مطلب</label>
                                        <input class="form-control col-xl-3 col-md-3" name="Price"
                                            value="{{ $News->Price }}" type="number">
                                        <label for="validationCustom0" class="col-xl-2 col-md-2">پرداخت به
                                            مالک</label>
                                        <input class="form-control col-xl-3 col-md-3" name="CreatorPrice"
                                            value="{{ $News->CreatorPrice }}" type="number">
                                    </div>
                                    <div class="form-group row advance d-none">
                                        <label for="validationCustom0" class="col-xl-3 col-md-3">مولف</label>
                                        <input class="form-control col-xl-3 col-md-3" name="Writer"
                                            value="{{ $News->Writer }}" type="text">
                                        <label for="validationCustom0" class="col-xl-2 col-md-2">مترجم</label>
                                        <input class="form-control col-xl-3 col-md-3" name="ExtTranslater"
                                            value="{{ $News->ExtTranslater }}" type="text">
                                    </div>
                                    <div class="form-group row advance d-none">
                                        <label for="validationCustom0" class="col-xl-3 col-md-3">نویسنده اصلی</label>
                                        <input class="form-control col-xl-3 col-md-3" name="ExtWriter"
                                            value="{{ $News->ExtWriter }}" type="text">
                                        <label for="validationCustom0" class="col-xl-2 col-md-2">نام منبع</label>
                                        <input class="form-control col-xl-3 col-md-3" name="RefName"
                                            value="{{ $News->RefName }}" type="text">
                                    </div>
                                    <div class="form-group row advance d-none">
                                        <label for="validationCustom0" class="col-xl-3 col-md-3">آدرس منبع</label>
                                        <input class="form-control col-xl-3 col-md-3" name="RefLink"
                                            value="{{ $News->RefLink }}" type="text">
                                        <label for="validationCustom0" class="col-xl-2 col-md-2"> آدرس خارجی</label>
                                        <input class="form-control col-xl-3 col-md-3" name="OutLink"
                                            value="{{ $News->OutLink }}" type="text">
                                    </div>
                                    <div class="form-group row advance d-none">
                                        <label for="validationCustom0" class="col-xl-3 col-md-3">
                                            سطح تیتر <span style="color: red">*</span></label>
                                        <select name="TitleAccessLevel" class="form-control col-xl-3 col-md-3">
                                            <option value="0">نمایش به همه</option>
                                            @foreach ($UserLevel as $UserLevelItem)
                                                <option value="{{ $UserLevelItem->Role }}"
                                                    @if ($News->TitleAccessLevel == $UserLevelItem->Role) selected="selected" @endif>
                                                    {{ $UserLevelItem->RoleName }}</option>
                                            @endforeach
                                        </select>
                                        <label for="validationCustom0" class="col-xl-2 col-md-2">
                                            سطح متن <span style="color: red">*</span></label>
                                        <select name="ContentAccessLevel" class="form-control col-xl-3 col-md-3">
                                            <option value="0">نمایش به همه</option>
                                            @foreach ($UserLevel as $UserLevelItem)
                                                <option value="{{ $UserLevelItem->Role }}"
                                                    @if ($News->ContentAccessLevel == $UserLevelItem->Role) selected="selected" @endif>
                                                    {{ $UserLevelItem->RoleName }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group row advance d-none">
                                        <label for="validationCustom0" class="col-xl-3 col-md-4">
                                            روتیتر </label>
                                        <input class="form-control col-xl-8 col-md-7" name="UpTitel"
                                            value="{{ $News->UpTitel }}" type="text">
                                    </div>
                                    <div class="form-group row">
                                        <label for="validationCustom0" class="col-xl-3 col-md-4">
                                            تیتر ياآدرس بیرونی <span style="color: red">*</span></label>
                                        <input class="form-control col-xl-8 col-md-7" required name="Titel"
                                            value="{{ $News->Titel }}" type="text" required="">
                                    </div>
                                    <div class="form-group row advance d-none">
                                        <label for="validationCustom0" class="col-xl-3 col-md-4">
                                            زیر تیتر</label>
                                        <input class="form-control col-xl-8 col-md-7" name="SubTitel"
                                            value="{{ $News->SubTitel }}" type="text">
                                    </div>

                                </div>
                                <div class="form-group row">
                                    <label for="validationCustom0" class="col-xl-3 col-md-4"> شاخص </label>
                                    <select id="SelectTags" name="SelectTags[]" class="form-control col-xl-8 col-md-7"
                                        multiple="multiple">
                                        @foreach ($Tags as $Tag)
                                            <option @if ($Tag->PostId != null) selected="selected" @endif>
                                                {{ $Tag->Name }}
                                            </option>
                                        @endforeach
                                    </select>

                                </div>
                                <div class="form-group row advance d-none">
                                    <label for="validationCustom0" class="col-xl-3 col-md-4"> خلاصه مطلب </label>
                                    <textarea name="Abstract" class="form-control col-xl-8 col-md-7">{!! $News->Abstract !!} </textarea>
                                </div>
                                <div class="form-group row">
                                    @if ($News->description == null)
                                        <label id="description-txt" style="color: red" class="col-xl-3 col-md-4">
                                            توضیحات
                                            موتور
                                            جستجو - <small id="description-count">{{ strlen($News->description) }}
                                            </small> </label>
                                    @elseif(strlen($News->description) == 0)
                                        <label id="description-txt" style="color: orange" class="col-xl-3 col-md-4">
                                            توضیحات موتور
                                            جستجو - <small id="description-count">{{ strlen($News->description) }}</small>
                                        </label>
                                    @elseif(strlen($News->description) <= 500)
                                        <label id="description-txt" style="color: green" class="col-xl-3 col-md-4">
                                            توضیحات موتور
                                            جستجو - <small id="description-count">{{ strlen($News->description) }}</small>
                                        </label>
                                    @elseif(strlen($News->description) > 500)
                                        <label id="description-txt" style="color: red" class="col-xl-3 col-md-4">
                                            توضیحات
                                            موتور
                                            جستجو - <small id="description-count">{{ strlen($News->description) }}</small>
                                        </label>
                                    @endif
                                    <textarea name="description" id="description" onkeyup="descriptionCkeker()" class="form-control col-xl-8 col-md-7">{!! $News->description !!}</textarea>
                                </div>

                                <div class="form-group row advance d-none">
                                    <label for="validationCustom0" class="col-xl-3 col-md-4"> پی نوشت </label>
                                    <textarea name="PostContent" class="form-control col-xl-8 col-md-7">{{ $News->PostContent }} </textarea>
                                </div>
                                <div class="form-group row">
                                    <label for="validationCustom0"> متن خبر <span style="color: red">*</span></label>
                                </div>
                                <div id="new_editor">
                                    <a href="javascript:active_old_editor()">ادیتور قدیمی</a>
                                    <textarea id="hiddenArea" required name="ce" class="col-sm-12 form-control">{!! $News->Content !!} </textarea>
                                    <hr>
                                    <div style="text-align: left" class="pull-left">
                                        <button type="submit" name="Registeruser" value="register"
                                            class="btn btn-primary">
                                            ثبت
                                        </button>
                                    </div>
                                </div>
                                <div id="old_editor" class="d-none">
                                    <a href="javascript:active_new_editor()">ادیتور جدید</a>

                                    <textarea id="hiddenArea" rows="30" required name="freeContent" class="col-sm-12 form-control">{!! $News->Content !!} </textarea>
                                    <hr>
                                    <div style="text-align: left" class="pull-left">
                                        <button type="submit" name="Registeruser" value="old"
                                            class="btn btn-warning">
                                            ثبت
                                        </button>
                                    </div>
                                </div>
                                <script>
                                    function active_old_editor() {
                                        $('#old_editor').removeClass('d-none');
                                        $('#new_editor').addClass('d-none');
                                    }

                                    function active_new_editor() {
                                        $('#old_editor').addClass('d-none');
                                        $('#new_editor').removeClass('d-none');
                                    }
                                </script>


                            </div>

                            </form>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    @php
        $view_src = App\view_counter\View_counter::view_item_history('post', $News->id);
    @endphp
    <!-- Container-fluid Ends-->
@endsection
@section('page-js')
    <script src="{{ asset('assets/js/vendor/echarts.min.js') }}"></script>
    <script src="{{ asset('assets/js/es5/echarts.script.min.js') }}"></script>
@endsection
@section('bottom-js')
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
    <script>
        var w = document.getElementById("mygraph");
        if (w) {
            var g = echarts.init(w);
            g.setOption({
                tooltip: {
                    trigger: "axis",
                    axisPointer: {
                        animation: !0
                    }
                },
                grid: {
                    left: "4%",
                    top: "4%",
                    right: "3%",
                    bottom: "10%"
                },
                xAxis: {
                    type: "category",
                    boundaryGap: !1,
                    data: [
                        @php
                            $counter = 0;
                            $maxfeild = 0;
                        @endphp
                        @foreach ($view_src as $Daramadfeild)
                            @if ($counter != 0)
                                , "{{ $Persian->MyPersianDate($Daramadfeild->target_day) }}"
                                @if ($maxfeild < $Daramadfeild->view_count)
                                    @php
                                        $maxfeild = $Daramadfeild->view_count;
                                    @endphp
                                @endif
                            @else
                                "{{ $Persian->MyPersianDate($Daramadfeild->target_day) }}"
                                @php
                                    $counter = 1;
                                    $maxfeild = $Daramadfeild->view_count;
                                @endphp
                            @endif
                        @endforeach
                    ],
                    axisLabel: {
                        formatter: "{value}",
                        color: "#666",
                        fontSize: 12,
                        fontStyle: "normal",
                        fontWeight: 400
                    },
                    axisLine: {
                        lineStyle: {
                            color: "#ccc",
                            width: 1
                        }
                    },
                    axisTick: {
                        lineStyle: {
                            color: "#ccc",
                            width: 1
                        }
                    },
                    splitLine: {
                        show: !1,
                        lineStyle: {
                            color: "#ccc",
                            width: 1
                        }
                    }
                },
                yAxis: {
                    type: "value",
                    min: 0,
                    max: {{ $maxfeild }},
                    interval: 10000000,
                    axisLabel: {
                        formatter: "{value}",
                        color: "#666",
                        fontSize: 12,
                        fontStyle: "normal",
                        fontWeight: 400
                    },
                    axisLine: {
                        lineStyle: {
                            color: "#ccc",
                            width: 1
                        }
                    },
                    axisTick: {
                        lineStyle: {
                            color: "#ccc",
                            width: 1
                        }
                    },
                    splitLine: {
                        lineStyle: {
                            color: "#ddd",
                            width: 1,
                            opacity: .5
                        }
                    }
                },
                series: [{
                    name: "بازدید",
                    type: "line",
                    smooth: !0,
                    data: [
                        @php
                            $counter = 0;
                        @endphp
                        @foreach ($view_src as $Daramadfeild)
                            @if ($counter != 0)
                                , "{{ $Daramadfeild->view_count }}"
                            @else
                                "{{ $Daramadfeild->view_count }}"
                                @php
                                    $counter = 1;
                                @endphp
                            @endif
                        @endforeach
                    ],
                    symbolSize: 8,
                    showSymbol: !1,
                    lineStyle: {
                        color: "rgb(255, 87, 33)",
                        opacity: 1,
                        width: 1.5
                    },
                    itemStyle: {
                        show: !1,
                        color: "#ff5721",
                        borderColor: "#ff5721",
                        borderWidth: 1.5
                    },
                    areaStyle: {
                        normal: {
                            color: {
                                type: "linear",
                                x: 0,
                                y: 0,
                                x2: 0,
                                y2: 1,
                                colorStops: [{
                                    offset: 0,
                                    color: "rgba(255, 87, 33, 1)"
                                }, {
                                    offset: .3,
                                    color: "rgba(255, 87, 33, 0.7)"
                                }, {
                                    offset: 1,
                                    color: "rgba(255, 87, 33, 0)"
                                }]
                            }
                        }
                    }
                }]
            }), $(window).on("resize", function() {
                setTimeout(function() {
                    g.resize()
                }, 500)
            })
        }
    </script>
    <script>
        function descriptionCkeker() {
            descriptionval = $('#description').val();
            if (descriptionval.length == 0) {

                $('#description-txt').css("color", "red");
            } else {
                if (descriptionval.length < 100) {
                    $('#description-txt').css("color", "orange");
                } else {
                    if (descriptionval.length < 500) {
                        $('#description-txt').css("color", "green");
                    } else { // overflow
                        $('#description-txt').css("color", "red");
                    }
                }
            }
            $('#description-count').html(descriptionval.length);
        }

        $('select').select2({
            createTag: function(params) {
                // Don't offset to create a tag if there is no @ symbol
                if (params.term.indexOf('@') === -1) {
                    // Return null to disable tag creation
                    return null;
                }

                return {

                    id: params.term,
                    text: params.term
                }
            }
        });
        $("#SelectTags").select2({
            tags: true
        });
        $("#NewsCat").select2({
            tags: true
        });
    </script>
    @include('Layouts.FilemanagerScripts')
    <script>
        function imagesetter() {
            //alert(document.getElementById("modal_pic").value)  ;
            document.getElementById("imagepreviw").src = document.getElementById("modal_pic").value;
        }
    </script>
    <script src="{{ url('/') }}/persian-datepicker/Mh1PersianDatePicker.js"></script>
@endsection

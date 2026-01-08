@php
    $MyImage = new \App\Functions\Images();
@endphp
@extends('Layouts.MainPage')
@section('page-header-left')
    <h3>{{ __('Pats') }}
        <small>{{ __('My pats') }}</small>
    </h3>
@endsection
@section('MainCountent')
    <input class="nested" id="main-menu" value="#setting">
    <input class="nested" id="sub-menu" value="#ManageIndex">
    <div class="card">
        <div class="card-header gradient-purple-indigo 0-hidden pb-80">
            <h5 class="text-white"><i class=" header-icon i-Newsvine"></i>ویرایش شاخص هوشمند
        </div>
        <div class="card-body">

            <small class="text-right">شاخص های هوشمند از ۱۰۰۰ به بالا برای نمایش مشخصات فنی در فروشگاه</small>
            <form id="targetform" method="post">
                @csrf
                <div class="row">
                    <div class="col-lg-3">
                        <h4>سرفصل شاخص</h4>
                        <select class="form-control" name="WorkCat" id="WorkCatSelectBox" onchange="WorkCatSelect()">
                            <option value="0">{{ __('--select--') }}</option>
                            @foreach ($WorkCats as $WorkCat)
                                <option class="nested" id="WorkCatIMG_{{ $WorkCat->ID }}">{{ $WorkCat->img }}</option>
                                <option value="{{ $WorkCat->ID }}">{{ $WorkCat->Name }}</option>
                            @endforeach
                        </select>
                        <div class="input-group mb-3">
                            <input type="text" name="WorkCatAdd" id="WorkCatAddInput" class="form-control"
                                placeholder="اضافه سرفصل شاخص">
                            <div class="input-group-append">
                                <span class="input-group-text" id="WorkCatAdd"
                                    onclick="submitter('WorkCatAddInput')">+</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <h4>شاخص لایه اول</h4>
                        <select class="form-control" name="L1Work" id="L1Select" onchange="L1Selectfun()" disabled>
                            <option value="0">{{ __('--select--') }}</option>
                            @foreach ($L1Works as $L1Work)
                                <option class="nested" id="L1IMG_{{ $L1Work->WorkCat }}_{{ $L1Work->L1ID }}">
                                    {{ $L1Work->img }}</option>
                                <option class="OptionL1 OptionL1_wc{{ $L1Work->WorkCat }}" value="{{ $L1Work->L1ID }}">
                                    {{ $L1Work->Name }}</option>
                            @endforeach
                        </select>
                        <div class="input-group mb-3">
                            <input type="text" name="L1Add" id="L1AddInput" class="form-control"
                                placeholder="اضافه شاخص لایه اول ">
                            <div class="input-group-append">
                                <span class="input-group-text" id="L1Add" onclick="submitter('L1AddInput')">+</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <h4> شاخص لایه دوم</h4>
                        <select class="form-control" name="L2Work" id="L2Select" onchange="L2Selectfun()" disabled>
                            <option value="0">{{ __('--select--') }}</option>
                            @foreach ($L2Works as $L2Work)
                                <option class="nested"
                                    id="L2IMG_{{ $L2Work->WorkCat }}_{{ $L2Work->L1ID }}_{{ $L2Work->L2ID }}">
                                    {{ $L2Work->img }}</option>

                                <option class="OptionL2 OptionL2_wc{{ $L2Work->WorkCat }}_L1{{ $L2Work->L1ID }}"
                                    value="{{ $L2Work->L2ID }}">{{ $L2Work->Name }}</option>
                            @endforeach
                        </select>
                        <div class="input-group mb-3">
                            <input type="text" name="L2Add" id="L2AddInput" class="form-control"
                                placeholder=" شاخص  لایه دوم">
                            <div class="input-group-append">
                                <span class="input-group-text" id="L2Add" onclick="submitter('L2AddInput')">+</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <h4>شاخص هدف </h4>
                        <select class="form-control" name="L3Work" id="L3Select" onchange="L3Selectfun()" disabled>
                            <option value="0">{{ __('--select--') }}</option>
                            @foreach ($L3Works as $L3Work)
                                <option
                                    class="OptionL3 OptionL3_wc{{ $L3Work->WorkCat }}_L1{{ $L3Work->L1ID }}_L2{{ $L3Work->L2ID }}"
                                    value="{{ $L3Work->UID }}">{{ $L3Work->Name }}</option>
                            @endforeach
                        </select>
                        <div class="input-group mb-3">
                            <input type="text" name="L3Add" id="L3AddInput" class="form-control"
                                placeholder="شاخص هدف ">

                            <div class="input-group-append">
                                <span class="input-group-text" id="L3Add" onclick="submitter('L3AddInput')">+</span>
                            </div>
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <a id="lfm" data-input="modal_pic" data-preview="holder"
                                        class="btn btn-primary text-white">
                                        <i class="fa fa-picture-o"></i> انتخاب تصویر
                                    </a>
                                </span>
                                <input id="modal_pic" class="form-control" type="text" name="pic" value="">
                            </div>
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </div>
    <hr>
    <div class="nested editindex" id="workcat_edit">
        <form method="POST">
            @csrf
            <div class="col-xl-9">

                <div class="card">
                    <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                        <h5 class="text-white"><i class=" header-icon i-Newsvine"></i>ویرایش سرفصل شاخص
                    </div>
                    <div class="card-body">
                        <label>کد شاخص</label>
                        <input required class="nested form-control WorkCat_ID" type="text" name="OldID">
                        <input required class="form-control WorkCat_ID" type="text" name="ID">
                        <label>نام شاخص</label>
                        <input required class="form-control" id="WorkCat_Name" type="text" name="Name">
                        <label>تصویر شاخص </label>
                        <input class="form-control" id="WorkCat_img" type="text" name="img">
                        <img id="WorkCat_img_show" src="" alt="">
                        <hr>
                        <button type="submit" class="btn btn-success" name="submit" value="workcat_edit">ثبت</button>
                    </div>

                </div>

            </div>
        </form>
    </div>
    <div class="nested editindex" id="L1_edit">
        <form method="POST">
            @csrf
            <div class="col-xl-9">

                <div class="card">
                    <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                        <h5 class="text-white"><i class=" header-icon i-Newsvine"></i> ویرایش شاخص لایه اول

                    </div>
                    <div class="card-body">
                        <label>کد شاخص</label>
                        <input required class="nested form-control WorkCat_ID" type="text" name="OldWorkCat">
                        <input required class="form-control WorkCat_ID" type="text" name="WorkCat">
                        <label>کد شاخص لایه اول</label>
                        <input required class="nested form-control L1_ID" type="text" name="OldL1ID">
                        <input required class="form-control L1_ID" type="text" name="L1ID">
                        <label>نام شاخص</label>
                        <input required class="form-control" id="L1_Name" type="text" name="Name">
                        <label>تصویر شاخص </label>
                        <input class="form-control" id="L1_img" type="text" name="img">
                        <img id="L1_img_show" src="" alt="">
                        <hr>
                        <button type="submit" class="btn btn-success" name="submit" value="L1_edit">ثبت</button>
                    </div>

                </div>

            </div>
        </form>
    </div>
    <div class="nested editindex" id="L2_edit">
        <form method="POST">
            @csrf
            <div class="col-xl-9">

                <div class="card">
                    <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                        <h5 class="text-white"><i class=" header-icon i-Newsvine"></i> ویرایش شاخص لایه دوم
                    </div>
                    <div class="card-body">
                        <label>کد شاخص</label>
                        <input required class="nested form-control WorkCat_ID" type="text" name="OldWorkCat">
                        <input required class="form-control WorkCat_ID" type="text" name="WorkCat">
                        <label>کد شاخص لایه اول</label>
                        <input required class="nested form-control L1_ID" type="text" name="OldL1ID">
                        <input required class="form-control L1_ID" type="text" name="L1ID">
                        <label>کد شاخص لایه دوم</label>
                        <input required class="nested form-control L2_ID" type="text" name="OldL2ID">
                        <input required class="form-control L2_ID" type="text" name="L2ID">
                        <label>نام شاخص</label>
                        <input required class="form-control" id="L2_Name" type="text" name="Name">
                        <label>تصویر شاخص </label>
                        <input class="form-control" id="L2_img" type="text" name="img">
                        <img id="L2_img_show" src="" alt="">
                        <hr>
                        <button type="submit" class="btn btn-success" name="submit" value="L2_edit">ثبت</button>
                    </div>

                </div>

            </div>
        </form>
    </div>
    <div class="nested editindex" id="L3_edit">
        <form method="POST">
            @csrf
            <div class="col-xl-9">

                <div class="card">
                    <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                        <h5 class="text-white"><i class=" header-icon i-Newsvine"></i> ویرایش شاخص لایه سوم (شاخص هدف)
                    </div>
                    <div class="card-body">
                        <label>کد شاخص</label>
                        <input required class="form-control WorkCat_ID" type="text" name="WorkCat">
                        <label>کد شاخص لایه اول</label>
                        <input required class="form-control L1_ID" type="text" name="L1ID">
                        <label>کد شاخص لایه دوم</label>
                        <input required class="form-control L2_ID" type="text" name="L2ID">
                        <label>کد شاخص لایه سوم (شاخص هدف)</label>
                        <input required class="form-control" id="L3_ID" type="text" name="L3ID">
                        <label>کد یکتا </label>
                        <input class="nested L3UID" type="text" name="UID">
                        <input disabled class="form-control L3UID" type="text">
                        <label>نام شاخص</label>
                        <input required class="form-control" id="L3_Name" type="text" name="Name">
                        <label>محتوای پوشش</label>
                        <div style="display: flex;">
                            <input class="form-control" id="cover_post" type="text" name="cover_post">
                            <a id="add_cover_post" class="mod_cover_post btn btn-success text-white d-none">افزودن محتوای پوشش</a>
                            <a id="edit_cover_post" class="mod_cover_post btn btn-success text-white d-none ">ویرایش محتوای پوشش</a>
                        </div>
                        <label>تصویر شاخص </label>
                        <input class="form-control" id="L3_img" type="text" name="img">
                        <img id="L3_img_show" src="" alt="">
                        <hr>
                        <button type="submit" class="btn btn-success" name="submit" value="L3_edit">ثبت</button>
                    </div>

                </div>

            </div>
        </form>
    </div>


    </div>
@endsection
@section('page-js')
    @if (app()->getLocale() == 'fa')
        <script src="{{ asset('assets/js/vendor/datatables.min.fa.js') }}"></script>
    @else
        <script src="{{ asset('assets/js/vendor/datatables.min.js') }}"></script>
    @endif
    <script>
        function submitter(myid) {
            if ($('#' + myid).val() != '') {
                if (myid != 'WorkCatAddInput') {
                    $('#WorkCatAddInput').val('');
                }
                if (myid != 'L1AddInput') {
                    $('#L1AddInput').val('');
                }
                if (myid != 'L2AddInput') {
                    $('#L2AddInput').val('');
                }
                if (myid != 'L3AddInput') {
                    $('#L3AddInput').val('');
                }

                $("#targetform").submit();
            } else {
                alert('مقدار ورودی نمی تواند خالی باشد');
            }


        }

        function WorkCatSelect() {
            if ($('#WorkCatSelectBox').val() != 0) {
                $(".OptionL1").hide();
                $(".WorkCat_ID").val($('#WorkCatSelectBox').val());
                $("#WorkCat_Name").val($('#WorkCatSelectBox').find(":selected").text());
                $("#WorkCat_img").val($("#WorkCatIMG_" + $('#WorkCatSelectBox').val()).text());
                $("#WorkCat_img_show").attr("src", $("#WorkCatIMG_" + $('#WorkCatSelectBox').val()).text());
                $('.editindex').addClass('nested');
                $("#workcat_edit").removeClass('nested');
                var TargetL1Show = '.OptionL1_wc' + $('#WorkCatSelectBox').val();
                $(TargetL1Show).show();
                $('#L1Select').prop('disabled', false);
                $('#L2Select').prop('disabled', true);
                $('#L3Select').prop('disabled', true);

            } else {
                $('#L1Select').prop('disabled', true);
                $('#L2Select').prop('disabled', true);
                $('#L3Select').prop('disabled', true);
            }
        }

        function L1Selectfun() {
            if ($('#L1Select').val() != 0) {
                var TargetL2Show = '.OptionL2_wc' + $('#WorkCatSelectBox').val() + '_L1' + $('#L1Select').val();
                $(".OptionL2").hide();
                $(TargetL2Show).show();
                $('#L1Select').prop('disabled', false);
                $('#L2Select').prop('disabled', false);
                $('#L3Select').prop('disabled', true);
                $(".L1_ID").val($('#L1Select').val());
                $("#L1_Name").val($('#L1Select').find(":selected").text().trim());
                L1_img = $("#L1IMG_" + $('#WorkCatSelectBox').val() + '_' + $('#L1Select').val()).text();
                L1_img = jQuery.trim(L1_img);
                $("#L1_img").val(L1_img);
                $("#L1_img_show").attr("src", $("#L1IMG_" + $('#WorkCatSelectBox').val() + '_' + $('#L1Select').val())
                    .text());
                $('.editindex').addClass('nested');
                $("#L1_edit").removeClass('nested');

            } else {
                $('#L1Select').prop('disabled', false);
                $('#L2Select').prop('disabled', true);
                $('#L3Select').prop('disabled', true);
            }
        }

        function L2Selectfun() {
            if ($('#L2Select').val() != 0) {
                var TargetL3Show = '.OptionL3_wc' + $('#WorkCatSelectBox').val() + '_L1' + $('#L1Select').val() + '_L2' + $(
                    '#L2Select').val();
                $(".OptionL3").hide();
                $(TargetL3Show).show();
                $('#L1Select').prop('disabled', false);
                $('#L2Select').prop('disabled', false);
                $('#L3Select').prop('disabled', false);

                $(".L2_ID").val($('#L2Select').val());
                $("#L2_Name").val($('#L2Select').find(":selected").text());
                l2_img = $("#L2IMG_" + $('#WorkCatSelectBox').val() + '_' + $('#L1Select').val() + '_' + $(
                    '#L2Select').val()).text();
                l2_img = jQuery.trim(l2_img);

                $("#L2_img").val(l2_img);
                $("#L2_img_show").attr("src", $("#L2IMG_" + $('#WorkCatSelectBox').val() + '_' + $('#L1Select').val() +
                    '_' + $('#L2Select').val()).text());
                $('.editindex').addClass('nested');
                $("#L2_edit").removeClass('nested');

            } else {
                $('#L1Select').prop('disabled', false);
                $('#L2Select').prop('disabled', false);
                $('#L3Select').prop('disabled', true);
            }
        }

        function L3Selectfun() {
            if ($('#L3Select').val() != 0) {
                $('.editindex').addClass('nested');
                $("#L3_edit").removeClass('nested');
                $('.mod_cover_post').addClass('d-none');
                $('#cover_post').val('');
                $("#L3_Name").val($('#L3Select').find(":selected").text());
                $uid = $('#L3Select').val();
                $(".L3UID").val($('#L3Select').val());
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.post('<?php echo e(route('ajax')); ?>', {
                        AjaxType: 'GetL3Index',
                        UID: $uid,
                    },
                    function(data, status) {
                        var arr = $.parseJSON(data);
                        $("#L3_img").val(arr['img']);
                        $("#L3_img_show").attr("src", arr['img']);
                        $('#L3_ID').val(arr['L3ID']);
                        $('#cover_post').val('تعیین نشده');

                    });

            } else {
                $('.editindex').addClass('nested');
            }

        }
    </script>
@endsection
@section('bottom-js')
    @include('Layouts.FilemanagerScripts')
@endsection

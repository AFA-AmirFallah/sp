@php
    $Persian = new App\Functions\persian();
    $Exam = $exams->get_exam($ExamID);

@endphp
@extends('Layouts.MainPage')
@section('page-header-left')
    <h3>{{ __('Pats') }}
        <small>{{ __('My pats') }}</small>
    </h3>
@endsection
@section('MainCountent')
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-lg-6">
                    <div class="page-header-left">
                        <h3>مدیریت سوالات
                            <small>اضافه کردن سوال</small>
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card tab2-card">
                    <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                        <h5>محتوای آزمون</h5>
                        @if ($Exam->ImgURL == '')
                            ثبت تصویر آزمون
                            <img id="imagepreviw" style="float: left;max-width: 80px;margin-top: -21px;border-radius: 50%;"
                                src="">
                        @else
                            <img id="imagepreviw" style="float: left;max-width: 80px;margin-top: -21px;border-radius: 50%;"
                                src="{{ $Exam->ImgURL }}">
                        @endif
                        <form method="post">
                            @csrf


                            <div class="form-group row">
                                <a id="lfm" data-input="modal_pic" data-preview="holder"
                                    class="btn btn-primary text-white">
                                    <i class="fa fa-picture-o"></i> انتخاب تصویر
                                </a>
                                <input required id="modal_pic" class="form-control nested" required type="text"
                                    name="pic" value="" onchange="imagesetter()">
                            </div>
                            <button type="submit" name="submit" value="save_img">ذخیره تصویر</button>

                        </form>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs nav-material" id="top-tab" role="tablist">
                            <li class="nav-item"><a id="edittab" class="nav-link active" id="top-profile-tab"
                                    data-toggle="tab" href="#top-profile" role="tab" aria-controls="top-profile"
                                    aria-selected="true"><i data-feather="user" class="mr-2"></i><small
                                        style="font-size: 13px" id="firsttab">افزودن سوال</small> </a>
                            </li>
                            <li class="nav-item"><a onclick="loadpage_with_data('ExamPaper','{{ $ExamID }}')"
                                    class="nav-link" id="contact-top-tab" data-toggle="tab" href="#credite-card"
                                    role="tab" aria-controls="top-contact" aria-selected="false"><i
                                        data-feather="credit-card" class="mr-2"></i> برگه آزمون
                                </a>
                            </li>
                        </ul>

                        <div class="tab-pane fade show active" id="top-profile" role="tabpanel"
                            aria-labelledby="top-profile-tab">
                            <form id="mainform" method="post" class="needs-validation user-add" novalidate="">
                                @csrf
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade active show" id="account" role="tabpanel"
                                        aria-labelledby="account-tab">
                                        <h4>جزئیات سوال</h4>
                                        <div class="form-group row">
                                            <label for="validationCustom0" class="col-xl-3 col-md-3">شماره سوال</label>
                                            <input class="form-control col-xl-3 col-md-3" name="order"
                                                value="{{ $exams->get_exam_item_count($ExamID) + 1 }}" type="text">

                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="validationCustom0" class="col-xl-3 col-md-4"> متن سوال <span
                                                style="color: red">*</span></label>
                                    </div>
                                    <textarea required id="hiddenArea" required name="ce" class="col-sm-12 form-control"></textarea>
                                </div>
                                <div class="pull-right">
                                    <button type="submit" name="submit" value="Save_Item" class="btn btn-primary">
                                        ذخیره
                                    </button>
                                </div>
                            </form>
                            <div class="nested" id="Itemdetial">

                            </div>
                            <form id="editexamform" method="post" class="nested needs-validation user-add" novalidate="">
                                @csrf
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade active show" id="account" role="tabpanel"
                                        aria-labelledby="account-tab">

                                        <div class="form-group row">
                                            <label id="orderfild" class="col-xl-3 col-md-3">شماره سوال</label>
                                            <input class="form-control col-xl-3 col-md-3" id="orderinput" name="order"
                                                value="" type="text">

                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label id="textfildlabale" class="col-xl-3 col-md-4">متن سوال<span
                                                style="color: red">*</span></label>
                                    </div>
                                    <textarea required id="maintextaria" required name="ce1" class="col-sm-12 form-control"></textarea>
                                </div>
                                <div class="pull-right">
                                    <button type="button" onclick="saveanswer()" class="btn btn-primary">
                                        ذخیره
                                    </button>
                                </div>
                            </form>


                        </div>
                        <div class="tab-pane fade" id="credite-card" role="tabpanel" aria-labelledby="contact-top-tab">
                            سوالات آزمون
                            <div id="main_content"></div>

                        </div>

                    </div>
                    <div id="main_content_2"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
@endsection
@section('bottom-js')
    <script>
        function deleteanswer($ExamItemId, $Order) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('', {
                    ajax: true,
                    procedure: 'deleteanswer',
                    ExamItemId: $ExamItemId,
                    order: $Order
                },
                function(data, status) {
                    if (data) {

                    }
                });
            edititem($ExamItemId)
        }

        function editanswer(ExamItemId, Order) {
            $('#editexamform').removeClass('nested');
            $('#orderfild').html('شماره پاسخ');
            $('#textfildlabale').html('متن پاسخ');
            $('#orderinput').val(Order);
            $('#maintextaria').val($('#content_' + Order).val());
            window.ExamItemId = ExamItemId;
        }

        function saveanswer() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('', {
                    ajax: true,
                    procedure: 'saveanswer',
                    ExamItemId: window.ExamItemId,
                    order: $('#orderinput').val(),
                    content: $('textarea#maintextaria').val()
                },
                function(data, status) {
                    if (data) {
                        $('textarea#maintextaria').val('');
                        $('#orderinput').val('');
                        $('#editexamform').addClass('nested');
                    }
                });
            edititem(window.ExamItemId)

        }


        function applytoSome(ExamItemId) {
            $inputtext = $('#inputtext').val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('', {
                    ajax: true,
                    procedure: 'applytoSome',
                    ExamItemId: ExamItemId,
                    inputtext: $inputtext
                },
                function(data, status) {
                    alert('عملیات انجام شد لطفا صفحه را رفرش کنید!');
                });

        }

        function applytoall(ExamItemId) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('', {
                    ajax: true,
                    procedure: 'applytoall',
                    ExamItemId: ExamItemId,

                },
                function(data, status) {
                    alert('عملیات انجام شد لطفا صفحه را رفرش کنید!');
                });

        }

        function addansewer(ExamItemId) {
            $('#editexamform').removeClass('nested');
            $('#orderfild').html('شماره پاسخ');
            $('#textfildlabale').html('متن پاسخ');
            window.ExamItemId = ExamItemId;
        }

        function edititem(ExamItemId) {
            $('#mainform').addClass('nested');
            $('a[href="#edittab"]').click()
            //$("#edittab").tab('active');
           // $("#edittab").tabs('show');
            $.ajax({
                url: '?page=ExamItem&data=' + ExamItemId,
                type: 'get',
                beforeSend: function() {

                },
                success: function(response) {
                    $('#Itemdetial').html(response);
                    $('#Itemdetial').removeClass('nested');


                },
                error: function() {
                    alert('can not');
                }
            });
        }

        function loadpage(TargetPage) {
            changeselectors(TargetPage);
            $.ajax({
                url: '?page=' + TargetPage,
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
    </script>
    <script>
        function removeforms() {

        }

        function addformula() {
            ExamItemId = window.data;
            ExamItemOrder = window.data1;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('', {
                    ajax: true,
                    procedure: 'saveformula',
                    ExamItemId: ExamItemId,
                    order: ExamItemOrder,
                    content: $('textarea#FormolStr').val()
                },
                function(data, status) {
                    if (data) {
                        $('textarea#FormolStr').val('');
                    }
                });
        }

        function loadpage_with_data_2(TargetPage, data, data1, TargetDisplay) {
            window.data = data;
            window.data1 = data1;

            $.ajax({
                url: '?page=' + TargetPage + '&data=' + data + '&data1=' + data1,
                type: 'get',
                beforeSend: function() {

                },
                success: function(response) {
                    $('#' + TargetDisplay).html(response);

                },
                error: function() {
                    alert('can not');
                }
            });
        }

        function checkfeilds() {
            if ($("#NewsCat option:selected").text() == "--انتخاب--") {
                alert("لطفا دسته خبری را مشخص فرمایید");

            } else {
                if ($("#maintitr").val() == "") {
                    alert("لطفا تیتر را مشخص فرمایید!!");
                } else {
                    if ($('#modal_pic').val() == '') {
                        alert('لطفا تصویر مطلب را انتخاب فرمایید!!');
                    } else {
                        if ($('#hiddenArea').val() == '') {
                            alert('لطفا متن مطلب را وارد فرمایید!!');
                        } else {
                            $('#mainform').submit()
                        }
                    }
                }

            }
        }
    </script>
    <script>
        function imagesetter() {
            //alert(document.getElementById("modal_pic").value)  ;
            document.getElementById("imagepreviw").src = document.getElementById("modal_pic").value;
            $('#modal_pic1').val(document.getElementById("modal_pic").value);
        }
    </script>


    @include('Layouts.FilemanagerScripts')
@endsection

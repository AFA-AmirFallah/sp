@php
    $Persian = new App\Functions\persian();
@endphp
@extends('Layouts.MainPage')
@section('page-header-left')
@endsection
@section('MainCountent')
    <style>
        .label_red {
            color: red;
        }
    </style>
    <div class="row">
        <div id="table-continer" class=" col-md-12">
            <div class="card o-hidden mb-4">
                <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                    <h3 id="Table-card-header" class="text-white  w-50 float-left card-title m-0"><i
                            class=" header-icon i-Receipt"></i>گزارش ثبت شده توسط: {{ $comment_src['creator_name'] }} </h3>


                </div>
                <div class="card-body">
                    <span class="badge badge-pill badge-success p-2 m-1"> افزوده شده در تاریخ:
                        {{ $Persian->MyPersianDate($comment_src['created_at'], true) }}</span>
                    @if ($comment_src['confirm_date'] != null)
                        <span class="badge badge-pill badge-success p-2 m-1"> تائید شده در تاریخ:
                            {{ $Persian->MyPersianDate($comment_src['confirm_date'], true) }}</span>
                    @endif
                    <form method="POST">
                        @csrf
                        <div class="tab-pane fade show active" id="personal" role="tabpanel" aria-labelledby="tabPersonal">
                            <div class="job-bx bg-white">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group ">
                                            <label> نام و نام خانوادگی درمانگر / پرستار :
                                            </label>
                                            <input class=" form-control " disabled value="{{ $comment_src['Name'] }}"
                                                placeholder=" نام درمانگر / پرستار را وارد کنید" type="text">
                                            <div class="invalid-feedback"> نام درمانگر / پرستار می باید وارد شود.</div>
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>خدمت دریافتی:</label>
                                            <input class="form-control" disabled value="{{ $comment_src['service'] }}"
                                                placeholder="وصل سرم" type="text">
                                            <div class="invalid-feedback">نام خدمت ارائه شده می باید وارد گردد.</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>شماره موبایل درمانگر / پرستار:</label>
                                            <input class="form-control" disabled value="{{ $comment_src['MobileNo'] }}"
                                                placeholder="09122233203" type="text">
                                            <div class="invalid-feedback">شماره موبایل یا کد پرستار بانک می باید وارد
                                                شود</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>کد پرستار بانک درمانگر / پرستار:</label>
                                            <input class="form-control" disabled value="{{ $comment_src['code'] }}"
                                                placeholder="09122233203" type="text">
                                            <div class="invalid-feedback">شماره موبایل یا کد پرستار بانک می باید وارد
                                                شود</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>نام مرکز ارائه کننده خدمت:</label>
                                            <input class="form-control" name="center_name"
                                                value="{{ $comment_src['center_name'] }}" disabled type="text">
                                            <div class="invalid-feedback">در صورتی که از مرکز خدماتی خدمت گرفته اید نام
                                                مرکز را وارد نمائید.</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>متن گزارش: </label>
                                            <textarea style="height:200px;" disabled class="form-control " name="comment" placeholder="متن گزارش"> {{ $comment_src['comment'] }}</textarea>
                                            <div class="invalid-feedback">متن گزارش می باید وارد شود!</div>

                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="is-invalid">میزان رضایت مندی از خدمات دریافتی :<span
                                                    class="reqired">*</span></label>
                                            <div style="margin-right: 10px;">
                                                <div>
                                                    <input type="radio" class="index_1" disabled
                                                        @if ($comment_src['rate'] == 5) checked @endif name="index_1"
                                                        value="5">
                                                    <label>عالی</label>
                                                </div>
                                                <div>
                                                    <input type="radio" class="index_1" name="index_1" disabled
                                                        @if ($comment_src['rate'] == 4) checked @endif value="4">
                                                    <label>خوب</label>
                                                </div>
                                                <div>
                                                    <input type="radio" class="index_1" disabled
                                                        name="index_1"@if ($comment_src['rate'] == 3) checked @endif
                                                        value="3">
                                                    <label>نسبتا خوب</label>
                                                </div>
                                                <div>
                                                    <input type="radio" class="index_1" disabled
                                                        @if ($comment_src['rate'] == 2) checked @endif value="2">
                                                    <label>بد</label>
                                                </div>
                                                <div>
                                                    <input type="radio" class="index_1" disabled
                                                        @if ($comment_src['rate'] == 1) checked @endif value="1">
                                                    <label>خیلی بد</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <ul class="nav nav-tabs">
                                            <li class="nav-item active"><a class="nav-link active " data-toggle="tab"
                                                    href="#posetive">نقاط مثبت</a></li>
                                            <li class="nav-item "><a class="nav-link " data-toggle="tab"
                                                    href="#negative">نقاط منفی</a></li>

                                        </ul>

                                        <div class="tab-content">
                                            <div id="posetive" class="tab-pane fade in active show">
                                                <a id="1" href="javascript:active_item('#1')"
                                                    class="comment-items positive-item">وقت شناس</a>
                                                <a id="2" href="javascript:active_item('#2')"
                                                    class="comment-items positive-item ">رفتار محترمانه</a>
                                                <a id="3" href="javascript:active_item('#3')"
                                                    class="comment-items positive-item">معتمد</a>
                                                <a id="4" href="javascript:active_item('#4')"
                                                    class="positive-item">ماهر</a>
                                            </div>
                                            <div id="negative" class="tab-pane fade">
                                                <a id="5" href="javascript:active_item('#5')"
                                                    class="comment-items negative-item">درخواست مبلغ اضافی</a>
                                                <a id="6" href="javascript:active_item('#6')"
                                                    class="comment-items negative-item ">رفتار نا مناسب</a>
                                                <a id="7" href="javascript:active_item('#7')"
                                                    class=" comment-items negative-item">بی توجهی به نیازها</a>
                                                <a id="8" href="javascript:active_item('#8')"
                                                    class="comment-items negative-item">عدم رعایت بهداشت</a>
                                            </div>
                                        </div>
                                    </div>
                                    <script>
                                        function active_item(item) {
                                            $(item).toggleClass('active');
                                        }
                                    </script>



                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" disabled
                                                    @if ($comment_src['recommend']) checked @endif name="recommend">
                                                <label class="custom-control-label" for="recommend">این درمانگر /
                                                    پرستار را
                                                    به دیگران توصیه میکنم</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" disabled
                                                    @if ($comment_src['call_allow']) checked @endif name="call_allow">
                                                <label class="custom-control-label" for="call_allow">در
                                                    صورت نیاز کارشناسان پرستاربانک با من تماس بگیرند</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" disabled
                                                    @if (!$comment_src['show_info']) checked @endif name="show_info">
                                                <label class="custom-control-label" for="show_info">نام من نمایش داده
                                                    نشود</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 text-center">
                                        <button type="submit" name="submit" value="save_main_info"
                                            class="btn btn-success">تائید و ابراز تشکر</button>
                                        <button type="submit" name="submit" value="save_main_info"
                                            class="btn btn-warning">تائید و ابراز تاسف</button>
                                        <button type="submit" name="submit" value="save_main_info"
                                            class="btn btn-danger">شکایت و درخواست بررسی مجدد </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- end of col-->
    </div>
@endsection
@section('page-js')
@endsection

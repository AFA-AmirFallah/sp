@php
    $MyImage = new \App\Functions\Images();
    $Persian = new \App\Functions\persian();
@endphp
@extends('Layouts.MainPage')
@section('page-header-left')
    <h3>{{ __('Pats') }}
        <small>{{ __('My pats') }}</small>
    </h3>
@endsection
@section('MainCountent')
    <section class="contact-list">
        @include('news.Layouts.news_admin_menu',['active_menu'=>'MakeTagCover'])
        <div class="row">
            <div class="col-md-12 mb-4">
                <div class="card text-left">
                    <div class="card-header bg-transparent" style="text-align: right">
                        <h5>فهرست مطالب : {{ $PageTitle }}</h5>
                    </div>
                    <form method="POST">
                        @csrf
                        @if ($SelectPost != null)
                            <div class="card " role="alert">
                                <div class="card-header">
                                    مطلب انتخاب شده: {{ $TargetSelected->Titel }}
                                    <button
                                        style="
                                    position: absolute;
                                    left: 19px;
                                "
                                        type="submit" name="forget" value="1" class="close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="card-body">
                                    <br>

                                    <button class="btn btn-primary" name="submit" value="SaveRelated" type="submit">مرتبط
                                        در
                                        خبر</button>
                                    <button class="btn btn-warning" name="submit" value="SaveRelatedBack"
                                        type="submit">خبر در
                                        مرتبط</button>
                                    <br>
                                    <small>مرتبط در خبر : اخباری که در ذیل خبر اتتخاب شده به عنوان اخبار مرتبط وارد می
                                        شوند</small>
                                    <br>
                                    <small>خبر در مرتبط : خبر انتخاب شده ذیل کدام اخبار به عنوان خبر مرتبط نمایش داده شود
                                    </small>
                                </div>


                            </div>
                        @endif
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="Post_table" class="{{ \App\myappenv::MainTableClass }}" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Number') }}</th>
                                            @if ($ListType == 'covers')
                                                <th>پوشش</th>
                                            @else
                                                <th>{{ __('Title') }}</th>
                                            @endif
                                            <th>{{ __('Date of enter') }}</th>
                                            <th>{{ __('Status') }}</th>
                                            @if (\App\myappenv::Lic['MultiBranch'])
                                                <th>شعبه</th>
                                            @endif
                                            <th>تعداد بازدید</th>
                                            @if ($ListType == 'covers')
                                                <th>نوع پوشش</th>
                                            @else
                                                <th>نظرات</th>
                                            @endif

                                            <th>{{ __('Actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($News as $NewsTarget)
                                            @php
                                                if ($NewsTarget->Type == 3) {
                                                    if(isset($NewsTarget->TagName)){
                                                        $news_route  = route('newscat',['newscat'=>$NewsTarget->TagName]);
                                                    }else{
                                                        $news_route = '';
                                                    }
                                                    
                                                } else {
                                                    if ($NewsTarget->OutLink == null) {
                                                        $news_route = route('ShowNewsItem', [
                                                            'NewsId' => $NewsTarget->id,
                                                            'newsitem' => $NewsTarget->Titel,
                                                        ]);
                                                    } else {
                                                        $news_route = route('ShowNewsItem', [
                                                            'NewsId' => $NewsTarget->OutLink,
                                                        ]);
                                                    }
                                                }

                                            @endphp
                                            <tr>
                                                <td>{{ $NewsTarget->id }}</td>
                                                <td style="overflow-wrap: anywhere;">
                                                    @if ($ListType == 'covers')
                                                        {{ $NewsTarget->TagName }}
                                                    @else
                                                        {!! $NewsTarget->Name !!}
                                                    @endif
                                                    @if ($Showview)
                                                        <a target="_blank" href="{{ $news_route }}"><i
                                                                style="font-size: 20px" class="i-Eye"></i> </a>
                                                        @if ($NewsTarget->views_count > 0)
                                                            <a style="color: red" target="_blank"
                                                                href="{{ $news_route }}">{{ $NewsTarget->views_count }}
                                                                <i style="font-size: 20px;color: red"
                                                                    class="i-Speach-Bubble-13"></i></a>
                                                        @endif
                                                    @endif
                                                </td>
                                                <td>{{ $Persian->MyPersianDate($NewsTarget->created_at) }}</td>
                                                <td id="status_{{ $NewsTarget->id }}" name="{{ $NewsTarget->Status }}">
                                                    {{ \App\myappenv::PostStatus[$NewsTarget->Status][1] ?? 'نامشخص' }}</td>
                                                @if (\App\myappenv::Lic['MultiBranch'])
                                                    <th>{{ $NewsTarget->branch_name }}</th>
                                                @endif
                                                <td>
                                                    @if ($NewsTarget->ViewCount == null)
                                                        0
                                                    @else
                                                        {{ $NewsTarget->ViewCount }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($ListType == 'covers')
                                                        @if ($NewsTarget->Type == 2)
                                                            دسته مطالب
                                                        @elseif($NewsTarget->Type == 3)
                                                            شاخص مطالب
                                                        @endif
                                                    @else
                                                        @if ($NewsTarget->CommentCount == -1)
                                                            بسته
                                                        @else
                                                            {{ $NewsTarget->views_count }}
                                                        @endif
                                                    @endif



                                                </td>
                                                <td>
                                                    @if ($SelectPost != null)
                                                        <input type="checkbox"
                                                            @if (!empty($RelatedArr) && in_array($NewsTarget->id, $RelatedArr)) checked @endif
                                                            name="Related[]" value="{{ $NewsTarget->id }}">خبر مرتبط
                                                    @else
                                                        @if ($ListType == 'covers')
                                                            <a href="{{ route('EditTagCover', ['TagID' => $NewsTarget->id]) }}"
                                                                class="btn bg-white _r_btn border-0">ویرایش
                                                            </a>
                                                        @else
                                                            <a href="{{ route('EditNews', ['NewsID' => $NewsTarget->id]) }}"
                                                                class="btn bg-white _r_btn border-0">ویرایش
                                                            </a>
                                                            <a href="{{ route('MakeNews') }}" target="_blank"> <i
                                                                    class="fa fa-plus"></i> </a>
                                                        @endif


                                                        <a href="{{ route('ConfigNews', ['NewsID' => $NewsTarget->id]) }}"
                                                            class="btn bg-white _r_btn border-0">تنظیمات
                                                        </a>
                                                        <button name="select" class="btn btn-primary"
                                                            value="{{ $NewsTarget->id }} "> انتخاب</button>
                                                        <button type="button" class="btn bg-white _r_btn border-0"
                                                            data-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">
                                                            <span class="_dot _inline-dot bg-primary"></span>
                                                            <span class="_dot _inline-dot bg-primary"></span>
                                                            <span class="_dot _inline-dot bg-primary"></span>
                                                        </button>
                                                        <div class="dropdown-menu" x-placement="bottom-start"
                                                            style="position: absolute; text-align: right; transform: translate3d(0px, 33px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                            @foreach (\App\myappenv::PostStatus as $PostStatus)
                                                                <a class="dropdown-item ul-widget__link--font"
                                                                    onclick="ChangeNewsStatus({{ $NewsTarget->id }},{{ $PostStatus[0] }},'{{ $PostStatus[1] }}')">
                                                                    <i class="i-Data-Save"> </i>
                                                                    {{ $PostStatus[1] }}
                                                                </a>
                                                                <div class="dropdown-divider"></div>
                                                            @endforeach


                                                        </div>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                        </select>
                                    </tbody>

                                </table>
                            </div>

                        </div>
                    </form>

                </div>
            </div>
        </div>
    </section>
@endsection
@section('page-js')
    @if ($SelectPost == null)
        @if (app()->getLocale() == 'fa')
            <script src="{{ asset('assets/js/vendor/datatables.min.fa.js') }}"></script>
        @else 
            <script src="{{ asset('assets/js/vendor/datatables.min.js') }}"></script>
        @endif
    @endif
    <!-- page script -->
    <script src="{{ asset('assets/js/tooltip.script.js') }}"></script>

    <script>
        $('#Post_table').DataTable();
    </script>
    <script>
        function ChangeNewsStatus($NewsID, $TargetStatus, $TargetStatusName) {
            var $loader = '<div class="loader-bubble loader-bubble-primary m-2"></div>';
            var $oldvalue = $('#status_' + $NewsID).html();
            $('#status_' + $NewsID).html($loader);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('<?php echo e(route('ajax')); ?>', {
                    AjaxType: 'ChangeNewsStatus',
                    NewsID: $NewsID,
                    TargetStatus: $TargetStatus,
                },

                function(data, status) {
                    if (data == '1') {
                        $('#status_' + $NewsID).html($TargetStatusName);
                    } else {
                        alert('بروز مشکل در انجام عملیات!');
                        $('#status_' + $NewsID).html($oldvalue);
                    }
                });


        }
    </script>
@endsection

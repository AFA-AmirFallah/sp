@php
    $Persian = new App\Functions\persian();
@endphp
@extends('Layouts.MainPage')
@section('page-header-left')
@endsection
@section('MainCountent')
    <!-- Container-fluid starts-->
    <style>
        .search-result {
            position: absolute;
            background: aquamarine;
            overflow-y: scroll;
            height: 142px;
        }

        img.search_item_308 {
            display: none;
        }
    </style>
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-lg-6">
                    <div class="page-header-left">
                        <h3>مدیریت
                            <small> کرال ها</small>
                        </h3>
                    </div>
                </div>
                <div class="col-lg-6">
                    <ol class="breadcrumb pull-right">
                        @include('Layouts.AddressBar')
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- begin::modal -->
    <div class="ul-card-list__modal">
        <div class="modal fade SelectBanner" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-body">
                        <h2>کرال</h2>
                        <p>کرال جدید اضافه کنید</p>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header gradient-purple-indigo 0-hidden pb-80">اطلاعات دریافتی از مقصد</div>
        <div class="card-body">


            <img style="position: absolute;left: 0px;top: 0px;width: 100px;" src="{{ $image }}" alt="تصویر محصول">



            <form method="post">
                @csrf

                <div>نام محصول: <input name="Name" value="{{ $Name }}"></div>
                <div>قیمت محصول: <input name="price" value="{{ $price }}"></div>
                <div>واحد قیمت: <input name="priceCurrency" value="{{ $priceCurrency }}"></div>
                <div>موجودی: <input name="availability" value="{{ $availability }}">
                </div>
                <div>توضیحات: <input name="description" value="{!! $description !!}"></div>
                <div>آدرس تصویر: <input name="image" value="{{ $image }}"></div>
                
        </div>
        <div class="card-footer">

          {{--   <input name="Name" value="{{ $Name }}">
            <input name="price" value="{{ $price }}">
            <input name="priceCurrency" value="{{ $priceCurrency }}">
            <input name="availability" value="{{ $availability }}">
            <input name="image" value="{{ $image }}">
            <input name="description" value="{!! $description !!}"> --}}
            @if ($Status == 0 || $Status == 3)
                <button type="submit" class="btn btn-success" name="submit" value="add">افزودن این محصول به تحلیل
                    رقبا</button>
            @elseif($Status == 1)
                <button type="submit" class="btn btn-success" name="submit" value="addnew">افزودن محصول به
                    سامانه</button>
                <button type="button" class="btn btn-success" onclick="OpenLink()">ارتباط این محصول با محصولات
                    موجود</button>
                <button type="submit" class="btn btn-danger" name="submit" value="delete">حذف محصول از تحلیل
                    رقبا</button>
            @elseif($Status == 2)
                <button type="submit" class="btn btn-success" name="submit" value="readd">افزودن این محصول به تحلیل
                    رقبا</button>
            @endif
            </form>
        </div>
    </div>
    @if ($Status == 1)
        <div id="OpenLink" class="card nested">
            <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                ارتباط آدرس کرال با محصول
            </div>
            <div class="card-body">

                <p style="margin-bottom: 2px">جستجوی محصولات سامانه:</p>
                <form style="margin-bottom: 20px" method="GET" action="{{ route('search') }}" class="form-style">
                    <input onkeyup="SearchResult()" id="search_input" class="form-control" name="search"
                        placeholder="جستجو.." autocomplete="off"
                        value="@if (isset($q)) {{ $q }} @endif">
                    <button
                        style="position: absolute;margin-top: -30px;left: 23px;border: none;background: transparent;outline: none;"
                        id="closebtn" onclick="removesearch()" type="button"
                        class="close-button @if (!isset($q)) nested @endif"><svg
                            style="margin-right: -4px;" width="18" height="18" viewBox="0 0 18 18" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M8.96484 0C13.9082 0 18 4.02152 18 8.96484C18 13.9082 13.9082 18 8.96484 18C4.02152 18 0 13.9082 0 8.96484C0 4.02152 4.02152 0 8.96484 0ZM4.52742 11.9106C4.11609 12.3219 4.11609 12.9909 4.52742 13.4026C4.93559 13.8104 5.60461 13.8171 6.01945 13.4026L8.96484 10.4562L11.9809 13.403C12.3922 13.8143 13.0613 13.8143 13.4729 13.403C13.8843 12.9916 13.8843 12.3226 13.4729 11.9109L10.5268 8.96484L13.4729 6.01875C13.8843 5.60707 13.8843 4.93805 13.4729 4.52672C13.0613 4.11539 12.3922 4.11539 11.9809 4.52672L8.96484 7.47352L6.01945 4.52672C5.60883 4.11609 4.93981 4.11469 4.52742 4.52672C4.11609 4.93805 4.11609 5.60707 4.52742 6.01875L7.47351 8.96484L4.52742 11.9106Z"
                                fill="#A6A4A4" />
                        </svg></button>
                    <div id="search-box" class="nested search-result">
                        <div id="Serch_Result">

                        </div>
                    </div>
                </form>


            </div>
            <div class="card-footer">
                <div id="saverelation" class="nested">
                    <form method="POST">
                        @csrf
                        <input class="nested" value="" name="targetID" id="targetID" type="text">
                        <button type="submit" class="btn btn-success" name="submit" value="Link">ارتباط محصول لوکال
                            با
                            کرال</button>
                    </form>
                </div>
            </div>
            <button type="button" class="btn btn-success" onclick="CloseLink()">لغو</button>

        </div>
    @endif

    <hr>
    <iframe style="width: 100%;height: 594px;" src="{{ $SourceAddress }}" title="description"></iframe>
@endsection

@section('page-js')
    <script>
        function OpenLink() {
            $('#OpenLink').removeClass('nested');
        }

        function CloseLink() {
            $('#OpenLink').addClass('nested');
        }

        function selectProductitem($Object) {
            $ProductID = $Object.id;
            $ProductName = $('#' + $ProductID).val();
            $('#search_input').val($ProductName);
            $('#Serch_Result').html('');
            $('#closebtn').addClass('nested');
            $('#search-box').addClass('nested');
            $('#targetID').val($ProductID);
            $('#saverelation').removeClass('nested');
        }

        function removesearch() {
            $('#closebtn').addClass('nested');
            $('#saverelation').addClass('nested');
            $('#search-box').addClass('nested');
            $('#search_input').val('');
            $('#Serch_Result').html('');
            $('#targetID').val('');

        }

        function SearchResult() {
            $SearchText = $('#search_input').val();
            if ($SearchText.length == 0) {
                $('#closebtn').addClass('nested');
            } else {
                $('#closebtn').removeClass('nested');
            }
            if ($SearchText.length > 3) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.post('<?php echo e(route('ajax')); ?>', {
                        AjaxType: 'SearchProductSystem',
                        SearchText: $SearchText,
                    },

                    function(data, status) {
                        $('#Serch_Result').html(data);
                        $('#search-box').removeClass('nested');
                    });

            } else {
                $('#Serch_Result').html('');
                $('#search-box').addClass('nested');
            }
        }
    </script>
@endsection
@section('bottom-js')
@endsection

@php
    $Persian = new App\Functions\persian();
@endphp
@extends('Layouts.MainPage')
@section('page-header-left')
@endsection
@section('MainCountent')
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-lg-6">
                    <div class="page-header-left">
                        <h3>مدیریت
                            <small>{{ $Themes->get_object_name() }}</small>
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
    <div class="separator-breadcrumb border-top"></div>
    <section class="contact-list">
        <div class="row">
            <div class="col-md-12 mb-4">
                @include('Theme.ObjectDesc')
                <div class="card text-left">
                    <div class="card-header text-right bg-transparent">
                        <button id="addobject" type="button" data-toggle="modal" data-target=".bd-example-modal-lg"
                            class="btn btn-primary btn-md m-1"> {{ $Themes->get_object_name() }} اضافه کنید
                        </button>
                    </div>
                    @if ($Themes->get_Object_id() == 201)
                        @include('Theme.Modal_Type_1')
                    @endif
                    @if ($Themes->get_Object_id() == 202)
                        @include('Theme.Modal_Type_2')
                        @include('Theme.IndexList')
                    @endif
                    @if ($Themes->get_Object_id() == 203)
                        @include('Theme.Modal_Type_2')
                        @include('Theme.IndexList')
                    @endif
                    @if ($Themes->get_Object_id() == 204)
                        @include('Theme.Modal_Type_2')
                        @include('Theme.IndexList')
                    @endif
                    @if ($Themes->get_Object_id() == 205)
                        @include('Theme.Modal_Type_2')
                        @include('Theme.IndexList')
                    @endif
                    @if ($Themes->get_Object_id() == 206)
                        @include('Theme.Modal_Type_4')
                    @endif
                    @if ($Themes->get_Object_id() == 207)
                        @include('Theme.Modal_Type_3')
                    @endif
                    @if ($Themes->get_Object_id() == 208)
                        @include('Theme.Modal_Type_5')
                    @endif
                    @if ($Themes->get_Object_id() == 209)
                        @include('Theme.Modal_Type_6')
                    @endif
                    @if ($Themes->get_Object_id() == 210)
                        @include('Theme.Modal_Type_2')
                        @include('Theme.IndexList')
                    @endif
                    @if ($Themes->get_Object_id() == 310)
                        @include('Theme.Modal_Type_2')
                        @include('Theme.IndexList')
                    @endif
                    @if ($Themes->get_Object_id() == 211)
                        @include('Theme.Modal_Type_7')
                        @include('Theme.IndexList')
                    @endif
                    @if ($Themes->get_Object_id() == 212)
                        @include('Theme.Modal_Type_8')
                    @endif
                    @if ($Themes->get_Object_id() == 401)
                        @include('Theme.Modal_Type_6')
                    @endif
                    @if ($Themes->get_Object_id() == 402)
                        @include('Theme.Modal_Type_9')
                    @endif
                    @if ($Themes->get_Object_id() == 501 || $Themes->get_Object_id() == 502)
                        @include('Theme.Modal_Type_1')
                    @endif
                    @if ($Themes->get_Object_id() == 503)
                        @include('Theme.Modal_Type_5')
                    @endif
                    @if ($Themes->get_Object_id() == 504)
                        @include('Theme.Modal_Type_2')
                        @include('Theme.IndexList')
                    @endif
                    @if ($Themes->get_Object_id() == 505)
                        @include('Theme.Modal_Type_6')
                    @endif
                    @if ($Themes->get_Object_id() == 506)
                        @include('Theme.Modal_Type_5')
                    @endif
                    @if ($Themes->get_Object_id() == 507)
                        @include('Theme.Modal_Type_4')
                    @endif
                    @if (
                        $Themes->get_Object_id() == 508 ||
                            $Themes->get_Object_id() == 509 ||
                            $Themes->get_Object_id() == 510 ||
                            $Themes->get_Object_id() == 511)
                        @include('Theme.Modal_Type_2')
                        @include('Theme.IndexList')
                    @endif
                    @if ($Themes->get_Object_id() == 601)
                        @include('Theme.Modal_Type_1')
                    @endif



                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="ul-contact-list" class="display table " style="width:100%">
                                <thead>
                                    <tr>
                                        <th>کد</th>
                                        <th>ترتیب</th>
                                        <th>تایتل</th>
                                        <th>صفحه</th>
                                        <th>عکس</th>
                                        <th>لینک به</th>
                                        <th>وضعیت</th>
                                        <th>عملیات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($elements as $element)
                                        <tr id="tr_{{ $element->id }}">
                                            <td id="id_{{ $element->id }}">
                                                {{ $element->id }}
                                            </td>
                                            <td id="order_{{ $element->id }}" name="{{ $element->order }}">
                                                {{ $element->order }}</td>
                                            <td id="title_{{ $element->id }}" name="{{ $element->title }}">
                                                {{ $element->title }}</td>

                                            <td id="page_{{ $element->id }}" name="{{ $element->page }}">
                                                {{ $element->page }}</td>
                                            <td id="pic_{{ $element->id }}" name="{{ $element->pic }}"><img
                                                    src="{{ $element->pic }}" style="width: 60px;" /></td>
                                            @php
                                                $Pics = json_decode($element->pic) ?? [];
                                            @endphp

                                            @foreach ($Pics as $PicItem)
                                                @foreach ($PicItem as $key => $Pic)
                                                    <input class="nested" id="{{ $key }}_{{ $element->id }}"
                                                        value="{{ $Pic }}">
                                                @endforeach
                                            @endforeach

                                            <td id="link_{{ $element->id }}" name="{{ $element->link }}"><a
                                                    target="_blank" href="{{ $element->link }}">لینک</a></td>
                                            <td id="status_{{ $element->id }}"
                                                @if ($element->status == '1') name="{{ $element->status }}">فعال
                                        </td>
                                        @else
                                            name="{{ $element->status }}"> غیر فعال </td> @endif
                                                <td>
                                                <button id="{{ $element->id }}" type="button" data-toggle="modal"
                                                    data-target=".bd-example-modal-lg"
                                                    onclick="EditModal({{ $element->id }})"
                                                    class="btn btn-primary btn-md m-1 " title="Edit">
                                                    <i class="i-Edit"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('page-js')
    @if (app()->getLocale() == 'fa')
        <script src="{{ asset('assets/js/vendor/datatables.min.fa.js') }}"></script>
    @else
        <script src="{{ asset('assets/js/vendor/datatables.min.js') }}"></script>
    @endif

    <!-- page script -->
@endsection
@section('bottom-js')
    @include('Layouts.FilemanagerScripts')
@endsection

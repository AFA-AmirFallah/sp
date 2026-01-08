@php
    $Persian = new App\Functions\persian();
@endphp
@extends('Layouts.MainPage')
@section('page-header-left')
@endsection
@section('MainCountent')
    <!-- Container-fluid starts-->
    <div id="app">
        <Patdashboard></Patdashboard>
    </div>
    <div id="nav_container" style="
    border-style: solid;
    border-radius: 6px;
    border-color: darkblue;
"
        class="row m-0 nested">
        <div class="col-md-4 p-4 gradient-purple-indigo 0-hidden pb-80">
            <h2 class="text-white title">پرونده الکترونیک: {{ $UserInfoResult->nameofuser }}
                {{ $UserInfoResult->Family }}</h2>
            <p class="text-white">پس از انجام هر خدمت می باید پرونده الکترونیک بیمار تکمیل گردد</p>
            <p class="text-white">جهت بهبود روند درمان پرونده الکترونیک را با دقت تکمیل نمایید!</p>
            {{-- <p class="mb-4">{{ __('Lorem ipsum dolor sit amet consectetur, adipisicing elit.') }} {{ __('Exercitationem odio amet eos dolore suscipit placeat.') }}</p> --}}
            <button onclick="active_global()" class="btn btn-lg btn-rounded btn-outline-warning"> فرم های عمومی</button>
            <button onclick="active_related()" class="btn btn-lg btn-rounded btn-outline-success"> فرم های اختصاصی</button>
            <button onclick="closenavigation()" class="btn btn-lg btn-rounded btn-outline-danger"> خروج</button>
        </div>

        <div id="RelatedForms" class="col-md-8 p-8">
            <p class="text-primary text--cap border-bottom-primary d-inline-block">فرم های اختصاصی </p>
            <div class="menu-icon-grid w-auto p-0">
                @foreach ($RelatedForms as $RelatedFormItem)
                    <a onclick="LoadForm({{ $RelatedFormItem->id }})"><img src="{{ $RelatedFormItem->Pic }}"
                            alt="{{ $RelatedFormItem->title }}">
                        {{ $RelatedFormItem->title }} </a>
                @endforeach
            </div>
        </div>
        <div id="GlobalForms" class="col-md-8 p-8 nested">
            <p class="text-primary text--cap border-bottom-primary d-inline-block">فرم های عمومی </p>
            <div class="menu-icon-grid w-auto p-0">
                @foreach ($GlobalForms as $RelatedFormItem)
                    <a onclick="LoadForm({{ $RelatedFormItem->id }})"><img src="{{ $RelatedFormItem->Pic }}"
                            alt="{{ $RelatedFormItem->title }}">
                        {{ $RelatedFormItem->title }} </a>
                @endforeach
            </div>
        </div>

    </div>
    <input type="text" class="nested" id="UserName" value="{{ App\Patient\PatientClass::PatientGetter() }}">
    <input type="text" class="nested" id="UserName_page" value="{{ $RequestPat }}">
    <div id="main_container" class="container-fluid ">
        <div class="row">
            <div class="col-xl-4">
                @include('Users.UsersMainInfo')
            </div>
            <div class="col-xl-8">
                <div class="card tab2-card">
                    <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                        <h5 class="text-white"><i class=" header-icon i-Folder-Archive"></i>پرونده الکترونیک:
                            {{ $UserInfoResult->nameofuser }}
                            {{ $UserInfoResult->Family }}</h5>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs nav-material" id="top-tab" role="tablist">
                            <li class="nav-item"><a class="nav-link active" id="top-profile-tab" data-toggle="tab"
                                    href="#top-profile" role="tab" aria-controls="top-profile" aria-selected="true"><i
                                        data-feather="user" class="mr-2"></i>{{ __('Electronic document') }}</a>
                            </li>
                            <li class="nav-item"><a class="nav-link" id="contact-top-tab" data-toggle="tab"
                                    href="#credite-card" role="tab" aria-controls="top-contact" aria-selected="false"><i
                                        data-feather="credit-card" class="mr-2"></i>{{ __('Create Doc') }}
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content" id="top-tabContent">
                            <div class="tab-pane fade show active" id="top-profile" role="tabpanel"
                                aria-labelledby="top-profile-tab">
                                <h5 class="f-w-600">{{ __('Electronic document') }}</h5>
                                <table class="{{ \App\myappenv::MainTableClass }}">
                                    <thead>
                                        <th>{{ __('Document number') }}</th>
                                        <th>{{ __('Document subject') }}</th>
                                        <th>{{ __('Crate Doc Date') }}</th>
                                        @if (Auth::user()->Role == \App\myappenv::role_SuperAdmin)
                                            <th>{{ __('User') }}</th>
                                        @endif
                                        <th>{{ __('Actions') }}</th>

                                    </thead>
                                    <tbody>
                                        @foreach ($ParvandehMains as $ParvandehMain)
                                            <tr>
                                                <th>{{ $ParvandehMain->ParvandehID }}</th>
                                                <th>{{ $ParvandehMain->Subject }}</th>
                                                <th>{{ $Persian->MyPersianDate($ParvandehMain->CreateDate) }}</th>
                                                @if (Auth::user()->Role == \App\myappenv::role_SuperAdmin)
                                                    <th>{{ $ParvandehMain->creatorName }} {{ $ParvandehMain->creatorFamily }} </th>
                                                @endif
                                                <th>
                                                    <a href="{{ route('PatDoc', ['RequestDoc' => $ParvandehMain->ParvandehID, 'RequestPat' => $RequestPat]) }}"
                                                        class="ul-link-action text-success" data-toggle="tooltip"
                                                        data-placement="top" title="{{ __('Edite Doc') }}">
                                                        <i class="i-Edit"></i>
                                                    </a>
                                                    <a onclick="addform({{ $ParvandehMain->ParvandehID }})"
                                                        class="ul-link-action text-success" data-placement="top"
                                                        title="افزودن فرم">
                                                        <i class="i-Add-File"></i>
                                                    </a>
                                                </th>

                                            </tr>
                                        @endforeach
                                    </tbody>

                                </table>
                            </div>
                            <div class="tab-pane fade" id="credite-card" role="tabpanel" aria-labelledby="contact-top-tab">
                                <h5 class="f-w-600">{{ __('Create Doc') }}</h5>
                                <form id="formtarget" method="post">
                                    @csrf
                                    <div class="col-md-12 form-group mb-12">
                                        <div class="row">
                                            <label for="picker1">{{ __('Document subject') }}</label>
                                            <select name="DocumentSubject" class="form-control">
                                                @foreach (\App\myappenv::DocumentTypes as $DocType)
                                                    <option value="{{ $DocType }}">{{ $DocType }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="row">
                                            <label for="firstName2">{{ __('Doc notes') }}</label>
                                            <input type="text" name="DocText" class="form-control"
                                                placeholder="{{ __('Doc notes') }}">
                                        </div>

                                    </div>
                                    <button class="btn btn-primary" name="submit"
                                        value="adddoc">{{ __('add document') }}</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="form_content" class="nested" id="target_form">
        <form method="POST">
            @csrf
            <input id="form_id" name="form_id" class="nested" type="text">
            <input id="ParvandehID" name="ParvandehID" class="nested" type="text">
            <div class="row">
                <div class="col-md-12 mb-4">
                    <div class="card">
                        <div class="card text-left">
                            <div class="card-header gradient-purple-indigo 0-hidden pb-80 ">
                                <h5 id="title_form" class="text-white"> </h5>
                            </div>
                            <div class="card-body">
                                <h5 id="up_title_form"> </h5>
                                <small id="sub_title_form"> </small>
                                <hr>
                                <input type="text" class="nested" id="formid" value="">
                                <div id="Content_form"></div>
                                <button type="submit" name="submit" value="form_register"
                                    class="btn btn-success">ثبت</button>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </form>


    </div>

    <!-- Container-fluid Ends-->
@endsection
@section('bottom-js')
    <script>
        function active_global() {
            $('#RelatedForms').addClass('nested')
            $('#GlobalForms').removeClass('nested');
        }

        function active_related() {
            $('#RelatedForms').removeClass('nested')
            $('#GlobalForms').addClass('nested');
        }
    </script>
    <script>
        function LoadForm($FormID) {

            var $loader = '<div class="loader-bubble loader-bubble-primary m-2"></div>';
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('', {
                    function: 'getform',
                    FormID: $FormID
                },

                function(data, status) {
                    console.log(data);
                    $('#title_form').html(data['title']);
                    $('#up_title_form').text(data['up_title']);
                    $('#sub_title_form').text(data['sub_title']);
                    $('#Content_form').html(data['Content']);
                    $('#form_id').val(data['id']);
                    $('#ParvandehID').val(window.parvande_id);
                    $('#form_content').removeClass('nested');
                });


        }

        function closenavigation() {
            $('#nav_container').addClass('nested');
            $('#main_container').removeClass('nested');
            $('#app').removeClass('nested');
            window.parvande_id = null;
        }

        function addform(parvande_id) {
            $('#nav_container').removeClass('nested');
            $('#main_container').addClass('nested');
            $('#app').addClass('nested');
            window.parvande_id = parvande_id;
        }
    </script>
    <script>
        window.main_username = $('#UserName').val();
        window.page_username = $('#UserName_page').val();
        window.targetpage = 'PatDoc';
    </script>
@endsection

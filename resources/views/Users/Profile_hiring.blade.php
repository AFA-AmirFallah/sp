@php
    $Persian = new App\Functions\persian();
@endphp

@extends('Layouts.MainPage')
@section('page-css')
    <script src="{{ asset('assets/js/webcam.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('assets/styles/vendor/dropzone.min.css') }}">
@endsection
@section('page-header-left')
@endsection
@section('MainCountent')
    @if (Auth::user()->Role == \App\myappenv::role_customer)
        <input type="text" class="nested" id="UserName" value="{{ Auth::id() }}">
        <input type="text" class="nested" id="UserName_page" value="{{ Auth::id() }}">
    @else
        <input type="text" class="nested" id="UserName" value="{{ App\Patient\PatientClass::PatientGetter() }}">
        <input type="text" class="nested" id="UserName_page" value="{{ $UserInfoResult->UserName }}">
        <div id="app">
            <Patdashboard></Patdashboard>
        </div>
    @endif
    <!-- Container-fluid starts-->

    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-header gradient-purple-indigo 0-hidden pb-80 d-float">
                        <h5 class="text-white"><i class=" header-icon i-Administrator"></i>{{ $UserInfoResult->nameofuser }}
                            {{ $UserInfoResult->Family }}
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="profile-details text-center">
                            @if ($UserInfoResult->avatar != null)
                                <form method="post" enctype="multipart/form-data" id="button-select-upload">
                                    @csrf
                                    <div>
                                        <img id="useravatar_1" name="{{ $UserInfoResult->avatar }}"
                                            src="{{ $UserInfoResult->avatar }}" alt="avatar"
                                            class="img-fluid img-90 rounded-circle blur-up lazyloaded dropzone dropzone-area dz-clickable">
                                        <div class="fallback">
                                            <input style="display: none" name="avatar" class="imguploadinput"
                                                id="imguploadinput_1" type="file" />
                                        </div>
                                        <button id="changebutton" type="button" class="btn btn-raised-danger"
                                            onclick="imageupdloader('_1')" style="margin-top: -20px">
                                            {{ __('change photo') }}</button>
                                        <button id="savebutton_1" type="submit" name="submit" value="UpdateIMG"
                                            class="btn btn-raised-warning nested "
                                            style="margin-top: -20px;background-color: rgb(30, 194, 71);">
                                            {{ __('save') }}</button>
                                        <button id="canclebutton_1" type="button" class="btn btn-raised-warning nested "
                                            onclick="cancelimagechange()" style="margin-top: -20px;">
                                            {{ __('discard') }}</button>
                                    </div>

                                </form>
                            @else
                                <form method="post" enctype="multipart/form-data" id="button-select-upload">
                                    @csrf
                                    <div>
                                        <img id="useravatar_2"
                                            name="{{ url('/') }}/assets/images/avtar/useravatar.png"
                                            src="{{ url('/') }}/assets/images/avtar/useravatar.png" alt=""
                                            class="img-fluid img-90 rounded-circle blur-up lazyloaded dropzone dropzone-area dz-clickable">
                                        <div class="fallback">
                                            <input style="display: none" name="avatar" class="imguploadinput"
                                                id="imguploadinput_2" type="file" />
                                        </div>
                                        <button id="changebutton" type="button" class="btn btn-raised-danger"
                                            onclick="imageupdloader('_2')" style="margin-top: -20px">
                                            {{ __('change photo') }}</button>
                                        <button id="savebutton_2" type="submit" name="submit" value="UpdateIMG"
                                            class="btn btn-raised-warning nested "
                                            style="margin-top: -20px;background-color: rgb(30, 194, 71);">
                                            {{ __('save') }}</button>
                                        <button id="canclebutton_2" type="submit" class="btn btn-raised-warning nested "
                                            style="margin-top: -20px;"> {{ __('discard') }}</button>
                                    </div>

                                </form>
                            @endif
                            <div style="display: inline-block;margin-top: 15px;margin-right:15px;align-items: center;"
                                class="row">
                                <div class="menu-icon-grid w-auto p-0">
                                    <a style="
                                        border-style: groove;
                                        border-color: lightseagreen;
                                    "
                                        href="javascript:change_tab('profile-tab')"><i class="i-Receipt-3"></i>پروفایل</a>
                                    <a style="
                                        border-style: groove;
                                        border-color: lightseagreen;
                                        margin-left: 3px;
                                        margin-right: 3px;
                                    "
                                        id="contact-top-tab" href="javascript:change_tab('ability_tab')"><i
                                            class="i-Checked-User"></i>مهارت‌ها</a>
                                    <a style="
                                        border-style: groove;
                                        border-color: lightseagreen;
                                        margin-left: 3px;
                                    "
                                        id="contact-top-tab" href="javascript:change_tab('doc_tab')"><i
                                            class="i-Checked-User"></i>مدارک</a>
                                    <a style="
                                        border-style: groove;
                                        border-color: lightseagreen;
                                    "
                                        target="_blank"
                                        href="{{ route('PersonelCard', ['RequestUser' => $UserInfoResult->UserName]) }}"><i
                                            class="i-Checked-User"></i>کارت شناسائی</a>
                                </div>

                            </div>


                        </div>
                    </div>

                </div>
                </form>
                <script>
                    function change_tab(tab_id) {
                        $('.main-tabs').addClass('d-none');
                        $('#' + tab_id).removeClass('d-none');
                    }
                </script>
                {{-- userprofile main --}}


            </div>
            <div id="ability_tab" class="d-none main-tabs col-xl-8">
                <div class="card tab2-card">
                    <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                        <h5 class="text-white"><i class=" header-icon i-Receipt-3"></i> مهارت‌ها:
                            {{ $UserInfoResult->nameofuser }}
                            {{ $UserInfoResult->Family }}</h5>
                    </div>
                    <div class="card-body">
                        <div id="can_do">
                            <h5 class="f-w-600">مهارت‌ها</h5>
                            <form id="formtarget" method="post">
                                @csrf
                                <div class="form-group col-md-12">
                                    <div class="form-group col-md-12">
                                        <label class="ul-form__label">چنانچه مهارت یاتوانائی خاصی دارید،آن را وارد نمائید.</label>
                                        <select style="width: 100%;" id="SelectTags" name="SelectTags[]"
                                            class="form-control" multiple="multiple">
                                            @foreach ($worker_hires->get_worker_skills(Auth::id()) as $skill_src)
                                                <option @if ($skill_src->UserName != null) selected @endif>
                                                    {{ $skill_src->Name }}
                                                </option>
                                            @endforeach
                                            </option>
                                        </select>

                                    </div>


                                </div>
                                <button type="submit" name="submit" value="add_extra_info" id="submitedit"
                                    class="btn btn-success float-right">ذخیره </button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
            <div id="doc_tab" class="d-none main-tabs col-xl-8">
                <div class="card tab2-card">
                    <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                        <h5 class="text-white"><i class=" header-icon i-Receipt-3"></i> مدارک:
                            {{ $UserInfoResult->nameofuser }}
                            {{ $UserInfoResult->Family }}</h5>
                    </div>
                    <div class="card-body">
                        @php
                            $doc_src = $user_class->get_role_documentation($UserInfoResult->Role);
                        @endphp
                        @if ($doc_src != null)
                            <div id="uploader" role="tabpanel">
                                <form method="post" enctype="multipart/form-data" id="button-select-upload">
                                    @csrf
                                    <div class="row">
                                        @foreach ($doc_src as $doc_item)
                                            <div class="col-xl-4">
                                                <h5 class="f-w-600"> {{ $doc_item['name'] }} </h5>
                                                <div>
                                                    <img style="width: 300px;border-radius: 0px !important;"
                                                        id="useravatar_{{ $doc_item['id'] }}"
                                                        @php
$target_id = $doc_item['id'] -3 ; @endphp
                                                        @isset($extradata->docs[$target_id])
                                                                            @if (isset($extradata->docs) && $extradata->docs[$target_id]->doc_img != null) src="{{ route('show', ['username' => $UserInfoResult->UserName, 'file_name' => $extradata->docs[$target_id]->doc_img]) }}"
                                                            alt="{{ $extradata->docs[$target_id]->doc_img }}"
        @endisset
                                                    @else src="{{ $doc_item['default_img'] }}"
                                                        alt="{{ $doc_item['default_img'] }}" @endif
                                                    class="img-fluid img-90 rounded-circle blur-up lazyloaded dropzone dropzone-area dz-clickable">
                                                    <div class="fallback">
                                                        <input style="display: none" name="avatar[{{ $doc_item['id'] }}]"
                                                            class="imguploadinput"
                                                            id="imguploadinput_{{ $doc_item['id'] }}" type="file" />
                                                    </div>
                                                    <button id="changebutton" type="button"
                                                        class="btn btn-raised-danger"
                                                        onclick="imageupdloader('_{{ $doc_item['id'] }}')"
                                                        style="margin-top: -20px">
                                                        {{ __('change photo') }}
                                                        {{ $doc_item['name'] }}</button>
                                                    <button id="canclebutton_{{ $doc_item['id'] }}" type="submit"
                                                        class="btn btn-raised-warning nested " style="margin-top: -20px;">
                                                        {{ __('discard') }}</button>
                                                </div>
                                            </div>
                                        @endforeach
                                        <button type="submit" name="submit" value="add_user_documents" id="submitedit"
                                            class="btn btn-success float-right">ذخیره </button>
                                    </div>

                                </form>

                            </div>
                        @endif

                    </div>
                </div>
            </div>
            <div id="profile-tab" class="main-tabs col-xl-8">
                <div class="card tab2-card">
                    <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                        <h5 class="text-white"><i class=" header-icon i-Receipt-3"></i> پروفایل:
                            {{ $UserInfoResult->nameofuser }}
                            {{ $UserInfoResult->Family }}</h5>
                    </div>
                    <div class="card-body">

                        <div id="top-profile" role="tabpanel" aria-labelledby="top-profile-tab">
                            <h5 class="f-w-600">{{ __('Profile') }}</h5>
                            <form id="formtarget" method="post">
                                @csrf

                                <div class="table-responsive profile-table">
                                    <table class="{{ \App\myappenv::MainTableClass }}">
                                        <thead>
                                            <th>
                                                مشخصه
                                            </th>
                                            <th>
                                                مقدار
                                            </th>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>{{ __('Name') }}</td>
                                                <td class="textinfo">{{ $UserInfoResult->nameofuser }} </td>
                                                <td class="inputinfo nested"><input class="form-control" name="Name"
                                                        value="{{ $UserInfoResult->nameofuser }}" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>{{ __('Family') }}</td>
                                                <td class="textinfo">{{ $UserInfoResult->Family }}</td>
                                                <td class="inputinfo nested"><input class="form-control" name="Family"
                                                        value="{{ $UserInfoResult->Family }}" />
                                                </td>

                                            </tr>
                                            <tr>
                                                <td>{{ __('Sex') }}</td>
                                                <td class="textinfo">
                                                    @if ($UserInfoResult->Sex == 'm')
                                                        {{ __('Man') }}
                                                    @elseif($UserInfoResult->Sex == 'f')
                                                        {{ __('Woman') }}
                                                    @endif
                                                </td>
                                                <td class="inputinfo nested">
                                                    <div
                                                        class="form-group m-checkbox-inline mb-0 custom-radio-ml d-flex radio-animated">
                                                        <label class="d-block" for="edo-ani1">
                                                            <input class="radio_animated" type="radio" name="Sex"
                                                                value="m"
                                                                @if ($UserInfoResult->Sex == 'm') checked="" @endif>
                                                            {{ __('Man') }}
                                                        </label>
                                                        <label class="d-block" for="edo-ani2">
                                                            <input class="radio_animated" type="radio" name="Sex"
                                                                value="f"
                                                                @if ($UserInfoResult->Sex == 'f') checked="" @endif>
                                                            {{ __('Woman') }}
                                                        </label>
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>{{ __('Birthday date') }}</td>
                                                <td class="textinfo">
                                                    @if ($UserInfoResult->Birthday != null)
                                                        {{ $Persian->MyPersianDate($UserInfoResult->Birthday) }}
                                                    @endif
                                                </td>
                                                <td class="inputinfo nested"><input class="form-control" name="Birthday"
                                                        @if ($UserInfoResult->Birthday != null) value="{{ $Persian->MyPersianDate($UserInfoResult->Birthday) }}" @endif />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>{{ __('Mobile No') }}</td>
                                                <td class="textinfo">{{ $UserInfoResult->MobileNo }}</td>
                                                <td class="inputinfo nested"><input class="form-control" name="MobileNo"
                                                        value="{{ $UserInfoResult->MobileNo }}" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>تحصیلات</td>
                                                <td class="inputinfo nested"><select style="width: 100%;"
                                                        class="form-control" name="Degree" id="Degree">
                                                        @if ($UserInfoResult->Degree == 0)
                                                            <option value="0" selected>انتخاب
                                                            </option>
                                                        @endif
                                                        <option value="1"
                                                            @if ($UserInfoResult->Degree == 1) selected @endif>زیر دیپلم
                                                        </option>
                                                        <option value="2"
                                                            @if ($UserInfoResult->Degree == 2) selected @endif>دیپلم
                                                        </option>
                                                        <option value="3"
                                                            @if ($UserInfoResult->Degree == 3) selected @endif>فوق دیپلم
                                                        </option>
                                                        <option value="4"
                                                            @if ($UserInfoResult->Degree == 4) selected @endif>کارشناسی
                                                        </option>
                                                        <option value="5"
                                                            @if ($UserInfoResult->Degree == 5) selected @endif>کارشناسی ارشد
                                                        </option>
                                                        <option value="6"
                                                            @if ($UserInfoResult->Degree == 6) selected @endif>دکترای تخصصی
                                                        </option>
                                                        <option value="7"
                                                            @if ($UserInfoResult->Degree == 7) selected @endif>پزشکی
                                                        </option>
                                                    </select></td>
                                                <td class="textinfo">
                                                    @switch($UserInfoResult->Degree)
                                                        @case(1)
                                                            زیر دیپلم
                                                        @break

                                                        @case(2)
                                                            دیپلم
                                                        @break

                                                        @case(3)
                                                            فوق دیپلم
                                                        @break

                                                        @case(4)
                                                            کارشناسی
                                                        @break

                                                        @case(5)
                                                            کارشناسی ارشد
                                                        @break

                                                        @case(6)
                                                            دکترای تخصصی
                                                        @break

                                                        @case(7)
                                                            پزشکی
                                                        @break

                                                        @default
                                                            نامشخص
                                                    @endswitch
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>شغل</td>
                                                <td class="textinfo">
                                                    @switch($UserInfoResult->expert)
                                                        @case(0)
                                                            نامشخص
                                                        @break

                                                        @case(1)
                                                            پزشک
                                                        @break

                                                        @case(2)
                                                            پرستار
                                                        @break

                                                        @case(3)
                                                            فیزیوتراپ/کاردرمان
                                                        @break

                                                        @case(4)
                                                            روانشناس
                                                        @break

                                                        @case(5)
                                                            بهیار
                                                        @break

                                                        @case(6)
                                                            مراقب
                                                        @break

                                                        @case(7)
                                                            همدم
                                                        @break

                                                        @default
                                                    @endswitch
                                                </td>
                                                <td class="inputinfo nested">
                                                    <select style="width: 100%;" class="form-control" name="expert">
                                                        @if ($UserInfoResult->expert == 0)
                                                            <option value="0" selected>
                                                                {{ __('--select--') }}</option>
                                                        @endif

                                                        <option value="1"
                                                            @if ($UserInfoResult->expert == 1) selected @endif>پزشک
                                                        </option>
                                                        <option value="2"
                                                            @if ($UserInfoResult->expert == 2) selected @endif>پرستار
                                                        </option>
                                                        <option value="3"
                                                            @if ($UserInfoResult->expert == 3) selected @endif>
                                                            فیزیوتراپ/کاردرمان</option>
                                                        <option value="4"
                                                            @if ($UserInfoResult->expert == 4) selected @endif>روانشناس
                                                        </option>
                                                        <option value="5"
                                                            @if ($UserInfoResult->expert == 5) selected @endif>بهیار
                                                        </option>
                                                        <option value="6"
                                                            @if ($UserInfoResult->expert == 6) selected @endif>مراقب
                                                        </option>
                                                        <option value="7"
                                                            @if ($UserInfoResult->expert == 7) selected @endif>همدم
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>


                                            <tr>
                                                <td>{{ __('Email') }}</td>
                                                <td class="textinfo">{{ $UserInfoResult->Email }}</td>
                                                <td class="inputinfo nested"><input class="form-control" name="Email"
                                                        value="{{ $UserInfoResult->Email }}" />
                                                    <input class="nested" name="branch"
                                                        value="{{ $UserInfoResult->branch }}" />
                                                </td>

                                            </tr>



                                            <tr>
                                                <td>استان</td>
                                                @phpclass="tab-content"
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    $province = '';
        @endphp 
                                                <td class="inputinfo nested">
                                                    <select name="Province" id="Province" style="width: 100%"
                                                        onchange="LoadCitys(this.value)" class="form-control">
                                                        <option value="0">{{ __('--select--') }}</option>
                                                        @foreach (App\geometric\locations::get_all_provinces() as $ProvincesTarget)
                                                            @if ($ProvincesTarget->id == $UserInfoResult->province)
                                                                <option selected value="{{ $ProvincesTarget->id }}">
                                                                    {{ $ProvincesTarget->ProvinceName }}</option>
                                                                @php
                                                                    $province = $ProvincesTarget->ProvinceName;
                                                                @endphp
                                                            @else
                                                                <option value="{{ $ProvincesTarget->id }}">
                                                                    {{ $ProvincesTarget->ProvinceName }}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td class="textinfo">{{ $province }}</td>
                                            </tr>
                                            <tr>

                                                <td>شهر</td>
                                                <td class="textinfo">
                                                    {{ App\geometric\locations::get_city_by_id($UserInfoResult->city) }}
                                                </td>
                                                <td class="inputinfo nested">
                                                    <select class="form-control" id="Shahrestan" style="width: 100%;"
                                                        name="city">
                                                    </select>
                                                </td>

                                            </tr>
                                        </tbody>
                                    </table>
                                    <button type="button" id="converttoedite"
                                        class="btn btn-primary float-right">{{ __('Edit') }}</button>
                                    <button type="submit" name="submit" value="updatebaseinfo" id="submitedit_profile"
                                        class="btn btn-success float-right nested">{{ __('Submit') }}</button>

                                    <button type="button" id="Aboartedite"
                                        class="btn btn-danger float-right nested">{{ __('aboart') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <!-- Container-fluid Ends-->
@endsection
@section('page-js')
    <script>
        window.main_username = $('#UserName').val();
        window.page_username = $('#UserName_page').val();
        window.targetpage = 'Profile';
        window.allowtoacall = true;
    </script>
    @if (\App\myappenv::Lic['hiring'] == false && $UserInfoResult->Role == \App\myappenv::role_worker)
        <script>
            if (window.allowtoacall) {
                $(document).ready(function() {
                    window.allowtoacall = false;
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.post('/ajax', {
                            AjaxType: 'call_parstarbank',
                            username: '{{ $UserInfoResult->UserName }}'
                        },

                        function(data, status) {
                            if (data['result']) {
                                $('#parastarbank_holder').html(data['html'])
                            } else {
                                alert(data['msg']);
                            }
                        });


                });
            }
        </script>
    @endif

    <script>
        function imageupdloader(id) {
            $('#imguploadinput' + id).trigger('click');
        }


        function showindexlist() {
            $("#userindex").addClass('nested');
            $("#listindex").removeClass('nested');
        }

        function showuserindexlist() {
            $("#userindex").removeClass('nested');
            $("#listindex").addClass('nested');
        }

        function cancelimagechange() {
            $('#useravatar').attr('src', $('#useravatar').attr('name'));
            $('#savebutton').addClass('nested');
            $('#changebutton').removeClass('nested');
            $('#canclebutton').addClass('nested');

        }
    </script>
    <script>
        function nothaveID() {
            alert('جهت تغییر وضعیت به کاربر ويژه ابتدا کد ملی خود را در سیستم ثبت نمایید!');
        }

        function readURL(input, id) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                //alert(e.target.result);
                reader.onload = function(e) {
                    $('#useravatar' + id).attr('src', e.target.result);
                    $('#savebutton' + id).removeClass('nested');
                    $('#changebutton' + id).addClass('nested');
                    $('#canclebutton' + id).removeClass('nested');

                }

                reader.readAsDataURL(input.files[0]); // convert to base64 string
            }
        }

        $(".imguploadinput").change(function() {
            target_id = $(this).attr('id');
            readURL(this, target_id.slice(-2));

        });
    </script>
    <script>
        var toggler = document.getElementsByClassName("box");
        var i;

        for (i = 0; i < toggler.length; i++) {
            toggler[i].addEventListener("click", function() {
                if ($(this.parentElement.querySelector("ul")).hasClass('nested')) {
                    $(this.parentElement.querySelector("ul")).removeClass('nested');
                    this.parentElement.querySelector("ul").classList.toggle("active");
                } else {
                    $(this.parentElement.querySelector("ul")).removeClass('active');
                    this.parentElement.querySelector("ul").classList.toggle("nested");
                }


                this.classList.toggle("check-box");
                this.classList.toggle("active");
            });
        }
    </script>
    <script>
        var selected = new Array();

        $(document).ready(function() {

            $("input[type='checkbox']").on('change', function() {
                // check if we are adding, or removing a selected item
                if ($(this).is(":checked")) {
                    selected.push($(this).val());
                } else {
                    for (var i = 0; i < selected.length; i++) {
                        if (selected[i] == $(this).val()) {
                            // remove the item from the array
                            selected.splice(i, 1);
                        }
                    }
                }

                // output selected
                var output = "";
                for (var o = 0; o < selected.length; o++) {
                    if (output.length) {
                        output += ", " + selected[o];
                    } else {
                        output += selected[o];
                    }
                }

                $(".taid").val(output);

            });

        });
    </script>
    <script>
        $(document).ready(function() {
            $("#L1").change(function() {
                var num = this.value;
                $("#L11").css("display", "none");

            });
        });
    </script>
    <script>
        function myFunction() {
            // Get the text field
            var copyText = document.getElementById("marketing_code");

            // Select the text field
            copyText.select();
            copyText.setSelectionRange(0, 99999); // For mobile devices

            // Copy the text inside the text field
            navigator.clipboard.writeText(copyText.value);

            // Alert the copied text
            alert("لینک بازاریابی در حافظه کپی شد");
        }
    </script>


    <script>
        $(function() {
            $('#converttoedite').click(function() {
                $(".textinfo").addClass('nested');
                $("#converttoedite").addClass('nested');
                $(".inputinfo").removeClass('nested');
                $("#Aboartedite").removeClass('nested');
                $("#submitedit_profile").removeClass('nested');
                LoadCitys(<?php echo $UserInfoResult->province; ?>);
            });
        });
    </script>
    <script>
        function estelam($TargetUserName) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('<?php echo e(route('ajax')); ?>', {
                    AjaxType: 'tavanpardakhtAdminfn',
                    TargetMelliID: $TargetUserName
                },

                function(data, status) {
                    if (data == 'notvalid') {
                        alert('notvalid');
                    } else {
                        $('#tavan').html(data);

                    }
                });

        }
    </script>
    <script>
        $(function() {
            $('#Aboartedite').click(function() {
                $(".textinfo").removeClass('nested');
                $("#converttoedite").removeClass('nested');
                $(".inputinfo").addClass('nested');
                $("#Aboartedite").addClass('nested');
                $("#submitedit_profile").addClass('nested');
            });
        });

        function BothSideCall() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('', {
                    ajax: true,
                    procedure: 'bothsidecall',
                },
                function(data, status) {
                    alert(data);
                });

        }
    </script>
    <script>
        function LoadCitys($ProvinceCode) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('<?php echo e(route('ajax')); ?>', {
                    AjaxType: 'GetCitysOfProvinces',
                    ProvinceCode: $ProvinceCode,
                },

                function(data, status) {
                    $("#Shahrestan").empty();
                    $("#Shahrestan").append(data);
                });

        }
    </script>
    <script>
        onload = function() {
            var e = document.getElementById('amount');
            e.oninput = myHandler;
            e.onpropertychange = e.oninput; // for IE8
            function myHandler() {
                document.getElementById('amountext').innerHTML = e.value.toPersianLetter() + ' تومان ';
            }
            var e2 = document.getElementById('amountDisc');
            e2.oninput = myHandler2;
            e2.onpropertychange = e2.oninput; // for IE8
            function myHandler2() {
                document.getElementById('amountDiscText').innerHTML = e2.value.toPersianLetter() + ' تومان ';
            }
        };
    </script>
@endsection
@section('bottom-js')
    @if (\App\myappenv::Lic['hiring'])
        <script>
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
        </script>
    @endif
@endsection

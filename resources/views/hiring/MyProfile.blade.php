@php
    $Persian = new App\Functions\persian();
@endphp
@extends('Layouts.MainPage')
@section('page-header-left')
    <h3>{{ __('Pats') }}
        <small>{{ __('My pats') }}</small>
    </h3>
@endsection
@section('MainCountent')
    <div id="base_info" class=" main_forms col-lg-12 mb-3">
        <div class="card">
            <div class="card-header gradient-purple-indigo 0-hidden pb-80 ">
                <h3 class="card-title text-white"> اطلاعات پایه </h3>
            </div>
            <div class="form-group">

                <div class="col-md-6 col-sm-6 col-xs-12">

                    <!-- Error -->
                    <div class='alert alert-danger mt-2 d-none text-danger' id="err_file"></div>

                </div>
            </div>

            @if (Auth::user()->avatar != null)
                <form method="post" enctype="multipart/form-data" id="button-select-upload">
                    @csrf
                    <div style="text-align: center">

                        <img id="useravatar" style="width: 250px" name="{{ Auth::user()->avatar }}"
                            src="{{ Auth::user()->avatar }}" alt="avatar"
                            class="img-fluid img-90 rounded-circle blur-up lazyloaded dropzone dropzone-area dz-clickable">
                        <div class="fallback">
                            <input style="display: none" name="avatar" id="imguploadinput" type="file" />
                        </div>
                        <button id="changebutton" type="button" class="btn btn-raised-danger" onclick="imageupdloader()"
                            style="margin-top: -20px">
                            {{ __('change photo') }}</button>
                        <button id="changebutton" type="button" class="nested btn btn-raised-danger"
                            onclick="set_web_cam()" style="margin-top: -20px">
                            webcam</button>
                        <button id="savebutton" type="submit" name="submit" value="UpdateIMG"
                            class="btn btn-raised-warning nested "
                            style="margin-top: -20px;background-color: rgb(30, 194, 71);">
                            {{ __('save') }}</button>
                        <button id="canclebutton" type="button" class="btn btn-raised-warning nested "
                            onclick="cancelimagechange()" style="margin-top: -20px;">
                            {{ __('discard') }}</button>

                    </div>

                </form>
            @else
                <form method="post" enctype="multipart/form-data" id="button-select-upload">
                    @csrf
                    <div style="text-align: center">

                        <img id="useravatar" style="width: 250px"
                            name="{{ url('/') }}/assets/images/avtar/useravatar.png"
                            src="{{ url('/') }}/assets/images/avtar/useravatar.png" alt=""
                            class="img-fluid img-90 rounded-circle blur-up lazyloaded dropzone dropzone-area dz-clickable">
                        <div class="fallback">
                            <input name="avatar" class="d-none" id="imguploadinput" type="file" />
                        </div>
                        <button id="changebutton" type="button" class="btn btn-raised-danger" onclick="imageupdloader()"
                            style="margin-top: -20px">
                            {{ __('change photo') }}</button>
                        <button id="savebutton" type="submit" name="submit" value="UpdateIMG"
                            class="btn btn-raised-warning nested " style="margin-top: -20px;background-color: coral;">
                            {{ __('save') }}</button>
                        <button id="canclebutton" type="submit" class="btn btn-raised-warning nested "
                            style="margin-top: -20px;"> {{ __('discard') }}</button>
                    </div>

                </form>
            @endif
            <div class="card-body">
                <div class="form-row ">
                    <div class="form-group col-md-6">
                        <label class="ul-form__label">نام</label>
                        <input class="form-control col-xl-12 col-md-12" name="Name" value="{{ Auth::user()->Name }}"
                            type="text" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="ul-form__label">نام خانوادگی</label>
                        <input class="form-control col-xl-12 col-md-12" name="Name" value="{{ Auth::user()->Family }}"
                            type="text" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="ul-form__label">تخصص - حرفه</label>
                        <input class="form-control col-xl-12 col-md-12" name="extranote"
                            value="{{ Auth::user()->extranote }}" type="text" required>
                        <small class="ul-form__text form-text ">
                            مثال: پزشک عمومی - پرستار
                        </small>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="ul-form__label">تحصیلات</label>
                        <select class="form-control col-xl-12 col-md-12" name="Name">
                            <option value="" disabled selected>مقطع تحصیلی
                            </option>
                            <option value="دکترا">دکترا</option>
                            <option value="پزشک">پزشک</option>
                            <option value="کارشناسی ارشد"> کارشناسی ارشد
                            </option>
                            <option value="کارشناس">کارشناس</option>
                            <option value="کاردانی">کاردانی</option>
                            <option value="دیپلم">دیپلم</option>
                            <option value="زیر دیپلم">زیر دیپلم</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="ul-form__label">استان</label>
                        <select name="Province" id="Province" onchange="LoadCitys(this.value)" class="form-control">
                            <option value="0">{{ __('--select--') }}</option>
                            @foreach (App\geometric\locations::get_all_provinces() as $ProvincesTarget)
                                @if ($ProvincesTarget->id == 0)
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
                        <small class="ul-form__text form-text ">
                            استان محل خدمت
                        </small>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="ul-form__label">شهر</label>
                        <select class="form-control" id="Shahrestan" name="city">
                        </select>
                        <small class="ul-form__text form-text ">
                            شهر محل خدمت
                        </small>
                    </div>
                    <hr>
                    <div class="form-group col-md-12">
                        <label class="ul-form__label">مهارت‌ها</label>
                        <select id="SelectTags" name="SelectTags[]" class="form-control" multiple="multiple">
                            <option>
                                php
                            </option>
                        </select>

                    </div>
                </div>
            </div>
            <div class="card-footer bg-transparent">
                <div class="mc-footer">
                    <div class="row">
                        <div class="col-lg-12">
                            <button type="button" class="btn  btn-primary m-1">ذخیره</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- end::form -->
        </div>
    </div>


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
@endsection
@section('bottom-js')
    <script>
        function imageupdloader() {
            $('#imguploadinput').trigger('click');
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

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#useravatar').attr('src', e.target.result);
                    $('#savebutton').removeClass('nested');
                    $('#changebutton').addClass('nested');
                    $('#canclebutton').removeClass('nested');

                }

                reader.readAsDataURL(input.files[0]); // convert to base64 string
            }
        }

        $("#imguploadinput").change(function() {
            readURL(this);
        });
    </script>
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
        $("#NewsCat").select2({
            tags: true
        });
    </script>
@endsection

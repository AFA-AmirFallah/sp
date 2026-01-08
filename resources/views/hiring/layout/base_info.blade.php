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




        <!--begin::form-->
        @if ($Order->GetUserInfo()->Pic != null)
            <form method="post" enctype="multipart/form-data" id="button-select-upload">
                @csrf
                <div style="text-align: center">

                    <img style="width: 250px" id="useravatar" name="{{ $Order->GetUserInfo()->Pic }}"
                        src="{{ $Order->GetUserInfo()->Pic }}" alt="avatar"
                        class="img-fluid img-90 rounded-circle blur-up lazyloaded dropzone dropzone-area dz-clickable">
                    <div class="fallback">
                        <input style="display: none" name='file' id="file" type="file" />
                    </div>
                    <button id="changebutton" type="button" class="btn btn-raised-danger" onclick="imageupdloader()"
                        style="margin-top: -20px">
                        {{ __('change photo') }}</button>
                    <button id="submit" type="button" value='Submit' class="btn btn-raised-warning nested "
                        style="margin-top: -20px;background-color: coral;">
                        {{ __('save') }}</button>
                    <button id="canclebutton" type="button" class="btn btn-raised-warning nested "
                        onclick="cancelimagechange()" style="margin-top: -20px;">
                        {{ __('discard') }}</button>
                    <hr>


                </div>

            </form>
        @else
            <form method="post" enctype="multipart/form-data" id="button-select-upload">
                @csrf
                <div style="text-align: center">
                    <img style="width: 250px" id="useravatar" name="{{ $Order->GetUserInfo()->Pic }}"
                        src="{{ url('/') }}/assets/images/avtar/useravatar.png" alt="avatar"
                        class="img-fluid img-90 rounded-circle blur-up lazyloaded dropzone dropzone-area dz-clickable">

                    <div class="fallback">
                        <input style="display: none" name="avatar" id="file" type="file" />
                    </div>
                    <button id="changebutton" type="button" class="btn btn-raised-danger" onclick="imageupdloader()"
                        style="margin-top: -20px">
                        {{ __('change photo') }}</button>
                    <button id="submit" type="button" name="submit" value="UpdateIMG"
                        class="btn btn-raised-warning nested " style="margin-top: -20px;background-color: coral;">
                        {{ __('save') }}</button>
                    <button id="canclebutton" type="button" class="btn btn-raised-warning nested "
                        style="margin-top: -20px;"> {{ __('discard') }}</button>
                </div>

            </form>
        @endif
        @php
            $address = $Order->get_data('address');
        @endphp
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
                    <label class="ul-form__label">تخصص - خرفه</label>
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
                </div>
                <div class="form-group col-md-6">
                    <label class="ul-form__label">شهر</label>
                    <select class="form-control" id="Shahrestan" name="city">
                    </select>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label for="validationCustom0" class="col-xl-3 col-md-4"> کلمات کلیدی / شاخص
            </label>
            <select id="SelectTags" name="SelectTags[]"
                class="form-control col-xl-8 col-md-7" multiple="multiple">
                    <option>
                        php
                    </option>
            </select>

        </div>
        <div class="card-footer bg-transparent">
            <div class="mc-footer">
                <div class="row">
                    <div class="col-lg-12">
                        <button type="button" onclick="saveBaseInfo()" class="btn  btn-primary m-1">ذخیره</button>
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

<script type="text/javascript">
    var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");

    function saveBaseInfo() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.post('', {
                submit: 'savebaseInfo',
                SubTitel: $('#SubTitel').val(),
                Titel: $('#Titel').val(),
                UpTitel: $('#UpTitel').val(),
                Pic: $('#Pic').val(),
            },

            function(data, status) {
                if (status == 'success') {
                    alert(data);
                } else {
                    alert('مشکلی به وجود آمده است');
                }

            });
    }

    $('#submit').click(function() {

        // Get the selected file
        var files = $('#file')[0].files;

        if (files.length > 0) {
            var fd = new FormData();

            // Append data 
            fd.append('file', files[0]);
            fd.append('_token', CSRF_TOKEN);

            // Hide alert 
            $('#responseMsg').hide();

            // AJAX request 
            $.ajax({
                url: "",
                method: 'post',
                data: fd,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {

                    // Hide error container
                    $('#err_file').removeClass('d-block');
                    $('#err_file').addClass('d-none');

                    if (response.success == 1) { // Uploaded successfully

                        // Response message
                        $('#responseMsg').removeClass("alert-danger");
                        $('#responseMsg').addClass("alert-success");
                        $('#responseMsg').html(response.message);
                        $('#responseMsg').show();

                        // File preview
                        $('#filepreview').show();
                        $('#filepreview img,#filepreview a').hide();
                        if (response.extension == 'jpg' || response.extension ==
                            'jpeg' || response.extension == 'png') {

                            $('#filepreview img').attr('src', response.filepath);
                            $('#filepreview img').show();
                        } else {
                            $('#filepreview a').attr('href', response.filepath).show();
                            $('#filepreview a').show();
                        }
                    } else if (response.success == 2) { // File not uploaded

                        // Response message
                        $('#responseMsg').removeClass("alert-success");
                        $('#responseMsg').addClass("alert-danger");
                        $('#responseMsg').html(response.message);
                        $('#responseMsg').show();
                    } else {
                        // Display Error
                        $('#err_file').text(response.error);
                        $('#err_file').removeClass('d-none');
                        $('#err_file').addClass('d-block');
                    }
                },
                error: function(response) {
                    console.log("error : " + JSON.stringify(response));
                }
            });
        } else {
            alert("Please select a file.");
        }

    });


    function saveaddress() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.post('', {
                submit: 'saveaddress',
                Province: $('#Province').val(),
                Shahrestan: $('#Shahrestan').val(),
                mgt_phone: $('#mgt_phone').val(),
                mgt_mail: $('#mgt_mail').val(),
                fulladdress: $('#fulladdress').val(),
            },

            function(data, status) {
                if (status == 'success') {
                    alert(data);
                } else {
                    alert('مشکلی به وجود آمده است');
                }

            });

    }

    function imageupdloader() {
        $('#file').trigger('click');
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
        $('#submit').addClass('nested');
        $('#changebutton').removeClass('nested');
        $('#canclebutton').addClass('nested');

    }

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#useravatar').attr('src', e.target.result);
                $('#submit').removeClass('nested');
                $('#changebutton').addClass('nested');
                $('#canclebutton').removeClass('nested');

            }

            reader.readAsDataURL(input.files[0]); // convert to base64 string
        }
    }

    $("#file").change(function() {
        readURL(this);

    });
</script>

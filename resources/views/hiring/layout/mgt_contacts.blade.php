<div id="mgt_contacts" class=" main_forms col-lg-6 mb-3">
    <div class="card">
        <div class="card-header bg-transparent">
            <h3 class="card-title">اطلاعات تماس</h3>
        </div>
        <form action="">
            <div class="card-body">
                <div class="form-row ">
                    <div class="form-group col-md-12">
                        <label class="ul-form__label">نام مسئول <span style="color: red">*</span></label>
                        <input class="form-control col-xl-12 col-md-12" id="mgt_name" value="{{ old('UpTitel') }}"
                            type="text" required>
                        <small class="ul-form__text form-text ">
                            نام کامل همراه با پسوند و پیشوند اختیاری (مهندس احمد فراهانی)
                        </small>
                    </div>
                    <div class="form-group col-md-12">
                        <label class="ul-form__label">
                            سمت مسئول<span style="color: red">*</span></label>
                        <input class="form-control col-xl-12 col-md-12" id="mgt_title" type="text" required>
                        <small class="ul-form__text form-text ">
                            مدیر- مدیرعامل - رئیس هیئت مدیره ...
                        </small>
                    </div>
                    <div class="form-group col-md-12">
                        <label class="ul-form__label">
                            شماره تماس<span style="color: red">*</span></label>
                        <input class="form-control col-xl-12 col-md-12" id="mgt_phone" value="" type="tel"
                            required>
                        <small class="ul-form__text form-text ">
                            شماره تماس جهت نمایش در سایت
                        </small>
                    </div>
                    <div class="form-group col-md-12">
                        <label class="ul-form__label">
                            ایمیل</label>
                        <input class="form-control col-xl-12 col-md-12" id="mgt_mail" value="" type="email"
                            required>
                        <small class="ul-form__text form-text ">
                            ایمیل جهت نمایش در سایت
                        </small>
                    </div>
                    <div class="form-group col-md-12">
                        <label class="ul-form__label">
                            توضحات کوتاه -یک خطی</label>
                        <input class="form-control col-xl-12 col-md-12" id="mgt_desc" value="{{ old('SubTitel') }}"
                            type="text" required>
                        <small class="ul-form__text form-text ">
                            مثال مسئول رسیدگی به امور نمایندگان
                        </small>
                    </div>
                </div>
                <div class="custom-separator"></div>
            </div>
            <div class="card-footer bg-transparent">
                <div class="mc-footer">
                    <div class="row">
                        <div class="col-lg-12">
                            <button id="mainsave" type="button" onclick="savemgtinfo()" class=" btn  btn-primary m-1">افزودن عضو جدید</button>
                            <button id="mainedit" type="button" onclick="Editmgtinfo()" class="nested editgroup btn  btn-primary m-1">ذخیره تغییرات</button>
                            <button id="cancelEdit" type="button" onclick="canceledit()" class="nested editgroup btn  btn-primary m-1"> لغو</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

    </div>
</div>
<div id="mgt_contacts" class=" main_forms col-lg-6 mb-3">
    @for ($i = 1; $i < 5; $i++)
        @php
            $FildName = 'mgt_' . $i;
        @endphp
        @if ($Order->get_data($FildName) != null)
            @php
                $mgtInfo = $Order->get_data($FildName);
            @endphp
            <input id="{{ $FildName }}_mgt_name" class="nested" type="text" value="{{ $mgtInfo->mgt_name }}">
            <input id="{{ $FildName }}_mgt_title" class="nested" type="text" value="{{ $mgtInfo->mgt_title }}">
            <input id="{{ $FildName }}_mgt_phone" class="nested" type="text" value="{{ $mgtInfo->mgt_phone }}">
            <input id="{{ $FildName }}_mgt_mail" class="nested" type="text" value="{{ $mgtInfo->mgt_mail }}">
            <input id="{{ $FildName }}_mgt_desc" class="nested" type="text" value="{{ $mgtInfo->mgt_desc }}">
            <section class=" widget-card">
                <div class="row">
                    <div class="col-lg-12 col-xl-12 mt-12">
                        <div class=" card">
                            <div class="card-body">
                                <div class="user-profile mb-4">
                                    @if ($mgtInfo->mgt_pic != null)
                                        <div style="text-align: center">

                                            <img style="width: 250px" id="useravatar{{ $i }}"
                                                src="{{ $mgtInfo->mgt_pic }}" alt="avatar"
                                                class="img-fluid img-90 rounded-circle blur-up lazyloaded dropzone dropzone-area dz-clickable">
                                            <div class="fallback">
                                                <input style="display: none" name='file'
                                                    id="file{{ $i }}" type="file" />
                                            </div>
                                            <button id="changebutton" type="button" class="btn btn-raised-danger"
                                                onclick="imageupdloader({{ $i }})"
                                                style="margin-top: -20px">
                                                {{ __('change photo') }}</button>
                                            <button id="submit" type="button" value="{{ $i }}"
                                                class="btn btn-raised-warning nested "
                                                style="margin-top: -20px;background-color: coral;">
                                                {{ __('save') }}</button>
                                            <button id="canclebutton" type="button"
                                                class="btn btn-raised-warning nested " onclick="cancelimagechange()"
                                                style="margin-top: -20px;">
                                                {{ __('discard') }}</button>
                                            <hr>


                                        </div>
                                    @else
                                        <div style="text-align: center">
                                            <img style="width: 250px" id="useravatar{{ $i }}"
                                                src="{{ url('/') }}/assets/images/avtar/useravatar.png"
                                                alt="avatar"
                                                class="img-fluid img-90 rounded-circle blur-up lazyloaded dropzone dropzone-area dz-clickable">

                                            <div class="fallback">
                                                <input style="display: none" name="avatar"
                                                    id="file{{ $i }}" type="file" />
                                            </div>
                                            <button id="changebutton{{ $i }}" type="button"
                                                class="btn btn-raised-danger"
                                                onclick="imageupdloader({{ $i }})"
                                                style="margin-top: -20px">
                                                {{ __('change photo') }}</button>
                                            <button id="submit{{ $i }}" type="button" name="submit"
                                                value="{{ $i }}"
                                                class="submit btn btn-raised-warning nested "
                                                style="margin-top: -20px;background-color: coral;">
                                                {{ __('save') }}</button>
                                            <button id="canclebutton{{ $i }}" type="button"
                                                class="btn btn-raised-warning nested " style="margin-top: -20px;">
                                                {{ __('discard') }}</button>
                                        </div>
                                    @endif
                                    <p style="text-align: center" class="m-0 text-24">{{ $mgtInfo->mgt_name }}</p>
                                    <p style="text-align: center" class="text-muted m-0"> {{ $mgtInfo->mgt_title }}
                                    </p>
                                </div>
                                <div class="ul-widget-card__rate-icon">
                                    <p>{{ $mgtInfo->mgt_desc }}</p>
                                </div>
                                <p class="text-muted m-0 text-center"><i class="i-Old-Telephone text-green"
                                        style="font-size: 20px;color:green;"></i> {{ $mgtInfo->mgt_phone }}</p>
                            </div>
                            <div class="ul-widget-card--line mt-2">
                                <button type="button" onclick="ready_to_edit({{ $i }})"
                                    class="btn btn-outline-success ul-btn-raised--v2 m-1 ">ویرایش</button>
                            </div>

                        </div>
                    </div>
                </div>
</div>
</section>
@endif
@endfor

</div>
<script>
    var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");

    $('.submit').click(function() {

        // Get the selected file
        $i = $(this).val();
        var files = $('#file' + $i)[0].files;

        if (files.length > 0) {
            var fd = new FormData();

            // Append data 
            fd.append('file', files[0]);
            fd.append('_token', CSRF_TOKEN);
            fd.append('mgt', $i);

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
    function canceledit(){
        $('#mgt_name').val('');
        $('#mgt_title').val('');
        $('#mgt_phone').val('');
        $('#mgt_mail').val('');
        $('#mgt_desc').val('');
        $('.editgroup').addClass('nested');
        $('#mainsave').removeClass('nested');
        window.mainid = null;
    }
    function Editmgtinfo(){
        if (savemgtinfo_validation()) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('', {
                    submit: 'mgtsave',
                    mgt_id: window.mainid,
                    mgt_name: $('#mgt_name').val(),
                    mgt_title: $('#mgt_title').val(),
                    mgt_phone: $('#mgt_phone').val(),
                    mgt_mail: $('#mgt_mail').val(),
                    mgt_desc: $('#mgt_desc').val(),
                },

                function(data, status) {
                    if (status == 'success') {
                        alert(data);
                    } else {
                        alert('مشکلی به وجود آمده است');
                    }

                });
        }

    }
    function ready_to_edit($i){
        $('#mgt_name').val($('#mgt_'+$i + '_mgt_name').val());
        $('#mgt_title').val($('#mgt_'+$i + '_mgt_title').val());
        $('#mgt_phone').val($('#mgt_'+$i + '_mgt_phone').val());
        $('#mgt_mail').val($('#mgt_'+$i + '_mgt_mail').val());
        $('#mgt_desc').val($('#mgt_'+$i + '_mgt_desc').val());
        $('.editgroup').removeClass('nested');
        $('#mainsave').addClass('nested');
        window.mainid = $i;

       
    }
    function imageupdloader($id) {
        $('#file' + $id).trigger('click');
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

    function readURL(input, $i) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#useravatar' + $i).attr('src', e.target.result);
                $('#submit' + $i).removeClass('nested');
                $('#changebutton' + $i).addClass('nested');
                $('#canclebutton' + $i).removeClass('nested');

            }

            reader.readAsDataURL(input.files[0]); // convert to base64 string
        }
    }
    $("#file1").change(function() {
        readURL(this, 1);

    });
    $("#file2").change(function() {
        readURL(this, 2);

    });
    $("#file3").change(function() {
        readURL(this, 3);

    });
    $("#file4").change(function() {
        readURL(this, 4);

    });
    $("#file5").change(function() {
        readURL(this, 5);

    });

    function savemgtinfo_validation() {
        $result = true;
        $('input').removeClass('redborder');
        if ($('#mgt_name').val() == "") {
            $('#mgt_name').addClass('redborder');
            $result = false;
        }
        if ($('#mgt_phone').val() == "") {
            $('#mgt_phone').addClass('redborder');
            $result = false;
        }
        if ($('#mgt_title').val() == "") {
            $('#mgt_title').addClass('redborder');
            $result = false;
        }
        if ($result == false) {
            alert("اطلاعات وارد شده کامل نیست");
            return false;
        } else {
            return true;
        }
    }

    function savemgtinfo() {
        if (savemgtinfo_validation()) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('', {
                    submit: 'mgtsave',
                    mgt_name: $('#mgt_name').val(),
                    mgt_title: $('#mgt_title').val(),
                    mgt_phone: $('#mgt_phone').val(),
                    mgt_mail: $('#mgt_mail').val(),
                    mgt_desc: $('#mgt_desc').val(),
                },

                function(data, status) {
                    if (status == 'success') {
                        alert(data);
                    } else {
                        alert('مشکلی به وجود آمده است');
                    }

                });
        }


    }
</script>

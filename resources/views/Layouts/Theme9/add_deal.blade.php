@php
    $Persian = new App\Functions\persian();
@endphp
@extends('Layouts.Theme9.Layout.mian_layout')
@section('content')
    <div class="main-container container">
        <div class="row mb-2">
            <div class="col">
                <h6 class="my-1">اطلاعات پایه</h6>
            </div>
        </div>
        <div class="row h-100 mb-4">
            <div class="col-12 col-md-6 col-lg-4">
                <div class="form-floating mb-3">
                    <select class="form-control" id="post_cat">
                        @php
                            $post_cat = $deal_src->post_cat ?? 0;
                        @endphp
                        <option value="0">{{ __('--select--') }}</option>

                        @foreach ($deal_functions->get_post_cats() as $cat)
                            <option value="{{ $cat->UID }}" @if ($post_cat == $cat->UID) selected @endif>
                                {{ $cat->Name }}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback">
                        لطفا نوع آکهی را انتخاب کنید
                    </div>
                    <label for="cat">نوع آگهی</label>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4">
                <div class="form-floating mb-3">
                    @php
                        $old_product_type = $deal_src->product_type ?? 0;
                    @endphp

                    <select name="product_type" id="product_type" class="form-control tocheck" style="width: 100%">
                        <option value="0">{{ __('--select--') }}</option>
                        @foreach ($deal_functions->get_product_type() as $product_type)
                            <option @if ($product_type->id == $old_product_type) selected @endif value="{{ $product_type->id }}">
                                {{ $product_type->Name }}
                            </option>
                        @endforeach

                    </select>
                    <div class="invalid-feedback">
                        لطفا نوع مورد معامله را انتخاب کنید
                    </div>
                    <label for="type"> نوع مورد معامله</label>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4">
                <div class="form-floating mb-3">
                    <select name="deal_type" class="form-control" id="deal_type">
                        @php
                            $old_deal_type = $deal_src->deal_type ?? 1;
                        @endphp
                        <option @if ($old_deal_type == 1) selected @endif value="1">فروش نقدی</option>
                        <option @if ($old_deal_type == 2) selected @endif value="2">فروش اقساطی</option>
                        <option @if ($old_deal_type == 3) selected @endif value="3">معاوضه</option>
                    </select>
                    <div class="invalid-feedback">
                        لطفا نوع معامله را انتخاب کنید
                    </div>
                    <label for="deal_type"> نوع معامله</label>
                </div>
            </div>
            <div class="col-12 col-md-12 col-lg-12">
                <div class="form-group form-floating  mb-3">
                    <input required name="title" type="text" class="form-control" placeholder="تیتر آگهی"
                        id="names">
                    <label for="names"> تیتر آگهی (نمایش بالای آگهی)

                    </label>
                    <div class="invalid-feedback">
                        تیتر آگهی نمیتواند خالی باشد!
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4">
                <div class="form-floating mb-3">
                    <select required name="Province" id="Province" onchange="LoadCitys(this.value)" class="form-control">
                        <option value="0">{{ __('--select--') }}</option>
                        @foreach ($Provinces as $ProvincesTarget)
                            <option value="{{ $ProvincesTarget->id }}">
                                {{ $ProvincesTarget->ProvinceName }}</option>
                        @endforeach

                    </select>
                    <label for="Province">استان</label>
                    <div class="invalid-feedback">
                        لطفا استان را انتخاب کنید
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4">
                <div class="form-floating mb-3">
                    <select required id="Shahrestan" name="Saharestan" class="form-control tocheck" style="width: 100%">
                    </select>
                    <label for="Shahrestan">شهر</label>

                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4">
                <div class="form-floating mb-3">
                    <input required name="show_price" type="text" class="form-control" placeholder="مبلغ آگهی"
                        id="show_price">
                    <label for="show_price">مبلغ</label>
                    <div class="invalid-feedback">
                        مبلغ آگهی نمیتواند خالی باشد!
                    </div>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col">
                    <h6 class="my-1"> توضیحات </h6>
                </div>
            </div>
            <div class="col-12 col-md-12 col-lg-12">
                <div class="form-group form-floating  mb-3">
                    <textarea name="description" id="description" rows="10" style="height: max-content" required class="form-control">{{ $deal_src->description ?? null }}</textarea>
                    <div class="invalid-feedback">
                        متن آگهی نمیتواند خالی باشد
                    </div>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col">
                    <h6 class="my-1"> تصاویر </h6>
                </div>
            </div>
            <div class="2-columns-form-layout">
                <div class="">
                    <div class="row">
                        <div class="col-lg-12">

                            <!-- start card -->
                            <div class="card">
                                <!--begin::form-->
                                <div class="card-body">
                                    <div class="row row-cols-1 row-cols-md-3 g-4">
                                        <div id="image_div" class="col">

                                        </div>

                                    </div>

                                    <script>
                                        function add_pic() {
                                            item = `<div class="card h-100">
                                                    <img src="" class="card-img-top">
                                                    <div class="card-body">
                                                    </div>
                                                </div>`;
                                            $('#image_div').html(item);
                                            alert('added');

                                        }
                                    </script>
                                    <div class="row">
                                        <button id="chooseFilesButton" type="button"
                                            style="padding: 10px 20px; background: #3498db; color: white; border: none; border-radius: 5px; cursor: pointer;">
                                            📷 انتخاب عکس‌ها
                                        </button>
                                        <input type="file" id="fileInput" multiple accept="image/*"
                                            style="display: none;">
                                        <div id="preview"
                                            style="margin-top: 20px; display: flex; flex-wrap: wrap; gap: 15px;"></div>
                                    </div>
                                    <!-- end::form -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button onclick="save_form()" type="button" class="btn btn-default mt-3">
                ثبت آگهی
            </button>
        </div>
    </div>
    @endsection
    @section('page-js')
        <script>
            let selectedFiles = [];

            document.getElementById('chooseFilesButton').addEventListener('click', function() {
                document.getElementById('fileInput').click();
            });
            document.getElementById('fileInput').addEventListener('change', function(event) {
                const newFiles = Array.from(event.target.files);
                selectedFiles = selectedFiles.concat(newFiles); // اضافه کردن بدون پاک کردن قبلی

                renderPreview();
            });

            function renderPreview() {
                const preview = document.getElementById('preview');
                preview.innerHTML = '';

                selectedFiles.forEach((file, index) => {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const container = document.createElement('div');
                        container.style.position = 'relative';
                        container.style.width = '100px';
                        container.style.height = '100px';
                        container.style.border = '2px solid #ccc';
                        container.style.borderRadius = '10px';
                        container.style.overflow = 'hidden';

                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.style.width = '100%';
                        img.style.height = '100%';
                        img.style.objectFit = 'cover';

                        const deleteBtn = document.createElement('button');
                        deleteBtn.textContent = 'X';
                        deleteBtn.style.position = 'absolute';
                        deleteBtn.style.top = '5px';
                        deleteBtn.style.right = '5px';
                        deleteBtn.style.background = 'red';
                        deleteBtn.style.color = 'white';
                        deleteBtn.style.border = 'none';
                        deleteBtn.style.borderRadius = '50%';
                        deleteBtn.style.width = '20px';
                        deleteBtn.style.height = '20px';
                        deleteBtn.style.cursor = 'pointer';
                        deleteBtn.title = 'حذف عکس';

                        deleteBtn.dataset.index = index; // اینجا ایندکس رو توی data ذخیره می‌کنیم

                        deleteBtn.addEventListener('click', function() {
                            const idx = this.dataset.index;
                            selectedFiles.splice(idx, 1);
                            renderPreview();
                        });

                        container.appendChild(img);
                        container.appendChild(deleteBtn);
                        preview.appendChild(container);
                    };
                    reader.readAsDataURL(file);
                });
            }
        </script>
        <script type="text/javascript">
            var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");

            function form_validation() {
                result = true;
                if ($('#product_type option:selected').val() == 0) {
                    $("#product_type").addClass("is-invalid").removeClass("is-valid");
                    result = false;
                }
                if ($('#post_cat option:selected').val() == 0) {
                    $("#post_cat").addClass("is-invalid").removeClass("is-valid");
                    result = false;
                }
                if ($('#deal_type option:selected').val() == 0) {
                    $("#deal_type").addClass("is-invalid").removeClass("is-valid");
                    result = false;
                }
                if ($('#Province option:selected').val() == 0) {
                    $("#Province").addClass("is-invalid").removeClass("is-valid");
                    result = false;
                }
                if ($('#show_price').val() == '') {
                    $("#show_price").addClass("is-invalid").removeClass("is-valid");
                    result = false;
                }
                if ($('#description').val() == '') {
                    $("#description").addClass("is-invalid").removeClass("is-valid");
                    result = false;
                }
                if ($('#names').val() == '') {
                    $("#names").addClass("is-invalid").removeClass("is-valid");
                    result = false;
                }
                return result;
            }

            function save_form() {
                if (!form_validation()) {
                    alert('لطفا اطلاعات را صحیح وارد کنید');
                    return false;
                }
                if (selectedFiles.length === 0) {
                    alert('هیچ عکسی برای آپلود وجود ندارد!');
                    return;
                }

                const formData = new FormData();
                selectedFiles.forEach((file, index) => {
                    formData.append('files[]', file);
                });
                formData.append('product_type', $('#product_type option:selected').val());
                formData.append('post_cat', $('#post_cat option:selected').val());
                formData.append('deal_type', $('#deal_type option:selected').val());
                formData.append('Province', $('#Province option:selected').val());
                formData.append('Shahrestan', $('#Shahrestan option:selected').val());
                formData.append('show_price', $('#show_price').val());
                formData.append('description', $('#description').val());
                formData.append('title', $('#names').val());
                const xhr = new XMLHttpRequest();
                xhr.open('POST', '', true);
                xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').getAttribute(
                    'content'));

                xhr.onload = function() {
                    if (xhr.status === 200) {
                        alert('همه عکس‌ها با موفقیت آپلود شدند!');
                        selectedFiles = [];
                        document.getElementById('fileInput').value = "";
                        document.getElementById('preview').innerHTML = "";
                    } else {
                        alert('خطایی در آپلود عکس‌ها رخ داده.');
                    }
                };

                xhr.send(formData);

                /*
                            product_type //select
                            post_cat //select
                            deal_type //select
                            Province // select
                            Shahrestan //select
                            show_price // text
                            description //text
                            names //text
                */
            }

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
                                if (response.extension == 'jpg' || response.extension == 'webp' || response
                                    .extension ==
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

            function imageupdloader() {
                $('#file').trigger('click');
            }

            function showindexlist() {
                $("#userindex").addClass('d-none');
                $("#listindex").removeClass('d-none');
            }

            function showuserindexlist() {
                $("#userindex").removeClass('d-none');
                $("#listindex").addClass('d-none');
            }

            function cancelimagechange() {
                $('#useravatar').attr('src', $('#useravatar').attr('name'));
                $('#submit').addClass('d-none');
                $('#changebutton').removeClass('d-none');
                $('#canclebutton').addClass('d-none');

            }

            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        $('#useravatar').attr('src', e.target.result);
                        $('#submit').removeClass('d-none');
                        $('#changebutton').addClass('d-none');
                        $('#canclebutton').removeClass('d-none');
                        item = `<div class="card h-100">
                                                    <img src="` + e.target.result + `" class="card-img-top">
                                                    <div class="card-body">
                                                    </div>
                                                </div>`;
                        $('#image_div').html(item);

                    }

                    reader.readAsDataURL(input.files[0]); // convert to base64 string
                }
            }

            $("#file").change(function() {
                readURL(this);

            });
        </script>
        <script>
            window.Province = 0;

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

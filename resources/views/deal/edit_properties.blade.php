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
    @include('deal/objects/header')
    @include('deal/objects/stepers', ['target_step' => 3, 'file_id' => $file_id])

    <form method="post" enctype="multipart/form-data">
        @csrf
        <div class="2-columns-form-layout">
            <div class="">
                <div class="row">
                    <div class="col-lg-12">
                        <!-- start card -->
                        <div class="card">
                            <div class="card-header bg-transparent">
                                <h5>مشخصات مربوط به : {{ $deal_src->title }}</h5>
                            </div>
                            <!--begin::form-->
                            <div class="card-body">
                                <table class="display table table-striped table-bordered dataTable">
                                    <thead>
                                        <tr>
                                            <th>
                                                مشخصه
                                            </th>
                                            <th>
                                                مقدار
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 0;
                                        @endphp
                                        @foreach ($properties as $propertie)
                                            @php
                                                $i++;
                                            @endphp
                                            <tr>
                                                <td><input class="form-control" name="item_name[]"
                                                        value="{{ $propertie['name'] }}"></td>
                                                <td class="inputinfo "><input class="form-control" name="item_value[]"
                                                        value="{{ $propertie['value'] }}">
                                                </td>
                                            </tr>
                                        @endforeach
                                        @if ($i == 0)
                                            <tr>
                                                <td><input class="form-control" name="item_name[]" value="سال ساخت :"></td>
                                                <td class="inputinfo "><input class="form-control" name="item_value[]"
                                                        value="">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><input class="form-control" name="item_name[]" value="کارکرد :"></td>
                                                <td class="inputinfo "><input class="form-control" name="item_value[]"
                                                        value="">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><input class="form-control" name="item_name[]" value="رنگ :"></td>
                                                <td class="inputinfo "><input class="form-control" name="item_value[]"
                                                        value="">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><input class="form-control" name="item_name[]" value="تناژ :"></td>
                                                <td class="inputinfo "><input class="form-control" name="item_value[]"
                                                        value="">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><input class="form-control" name="item_name[]" value="لاستیک :"></td>
                                                <td class="inputinfo "><input class="form-control" name="item_value[]"
                                                        value="">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><input class="form-control" name="item_name[]" value="بیمه :"></td>
                                                <td class="inputinfo "><input class="form-control" name="item_value[]"
                                                        value="">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><input class="form-control" name="item_name[]" value="دیفرانسیل :"></td>
                                                <td class="inputinfo "><input class="form-control" name="item_value[]"
                                                        value="">
                                                </td>
                                            </tr>
                                         
                                        @endif
                                    </tbody>
                                </table>

                            </div>
                            <div class="card-footer">
                                <button type="submit" name="submit" value="add" class="btn btn-success">ذخیره</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

    </form>
@endsection
@section('page-js')
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
@endsection

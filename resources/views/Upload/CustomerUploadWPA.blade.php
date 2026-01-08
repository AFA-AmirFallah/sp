@php
$Persian = new App\Functions\persian();
@endphp
@extends("Layouts.CustomerMainPage")
@section('page-css')
    <link rel="stylesheet" href="{{ asset('assets/styles/vendor/dropzone.min.css') }}">
@endsection
@section('page-header-left')

@endsection
@section('MainCountent')


    <div class="pwa_service_card_body card-body pwa_blue_gradian">
        <div class="pwa-card-title card-title">باگزاری فایل</div>
        <hr class="CustomerServiceCardHr">
        <p>پنل مخصوص بارگذاری فایل</p>
        <button id="button-select" style="width: 99%" class="btn btn-primary mb-4">انتخاب فایل</button>
        <form method="post" enctype="multipart/form-data" id="button-select-upload">
            @csrf
            <div>
                <img id="useravatar" name="" src="" alt="avatar"
                    class="img-fluid img-90 rounded-circle blur-up lazyloaded dropzone dropzone-area dz-clickable">
                <div class="fallback">
                    <input style="display: none" name="avatar" id="imguploadinput" type="file" />
                </div>
                <button id="changebutton" type="button" class="btn btn-raised-danger" onclick="imageupdloader()"
                    style="margin-top: -20px"> {{ __('change photo') }}</button>
                <button id="savebutton" type="submit" name="submit" value="UpdateIMG" class="btn btn-raised-warning nested "
                    style="margin-top: -20px;background-color: coral;"> {{ __('save') }}</button>
                <button id="canclebutton" type="button" class="btn btn-raised-warning nested " onclick="cancelimagechange()"
                    style="margin-top: -20px;"> {{ __('discard') }}</button>

            </div>

        </form>

    </div>

    @include("Layouts.MainRouteCard")


@endsection

@section('page-js')
    <script>
        function imageupdloader() {
            $('#imguploadinput').trigger('click');
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



@endsection

@section('bottom-js')

    <script src="{{ asset('assets/js/vendor/dropzone.min.js') }}"></script>
    <script src="{{ asset('assets/js/dropzone.script.js') }}"></script>
@endsection

@php
    $Persian = new App\Functions\persian();
    if ($iframe) {
        $Layout = 'iframe';
    } else {
        $Layout = null;
    }
@endphp

@extends('Layouts.MainPage', ['layout' => $Layout])
@section('page-header-left')
@endsection
@section('MainCountent')
    @if (!$iframe)
        <div class="breadcrumb">
            <h1>عملیات کالا</h1>
            <ul>
                <li><a href="">گالری </a></li>
                <li>کالا</li>
            </ul>
        </div>
        <div class="separator-breadcrumb border-top"></div>
    @endif

    <form method="post" enctype="multipart/form-data">
        @csrf
        <div class="2-columns-form-layout">
            <div class="">
                <div class="row">
                    <div class="col-lg-12">
                        <!-- start card -->
                        <div class="card">
                            @if (!$iframe)
                                <div class="card-header bg-transparent">
                                    <h3 class="card-title"> گالری {{ $good->NameFa }}</h3>
                                </div>

                            @endif

                            <!--begin::form-->
                            <div class="card-body">
                                <div>
                                    <ul>
                                        <li>ابعاد
                                            تصویر بایستی در بازه ۶۰۰x۶۰۰ و حجم آن باید کمتر از ۶ مگابایت باشد.
                                        </li>
                                        <li>کالا
                                            باید
                                            ۸۵٪ کل تصویر را در برگیرد و پس زمینه تصویر اصلی باید کاملاً سفید باشد.
                                        </li>
                                        <li>تصویر
                                            باید
                                            فقط کالایی که قصد فروش آن را دارید نمایش دهد و بدون هیچ لوگو، نوشته و یا
                                            واترمارکی
                                            باشد.
                                        </li>
                                        <li>
                                            تصویر شما باید مربعی باشد یا ابعاد یک در یک داشته باشد
                                        </li>
                                        <li>فرمت تصاویر بایستی JPG باشد</li>

                                    </ul>
                                </div>
                                <div>
                                    @php
                                        $Counter = 1;
                                    @endphp

                                    @foreach ($picrefrence as $picrefrenceItem)
                                        @if ($good->ImgURL == null)
                                            <div class="form-group row">
                                                <div class="form-group col-md-2">
                                                    {{ $picrefrenceItem->name }}
                                                </div>

                                                <div class="form-group col-md-2">


                                                    <img id="useravatar_{{ $Counter }}"
                                                        name="{{ url('/') }}/storage/photos/uproductplaceholder.jpg"
                                                        src="{{ url('/') }}/assets/images/avtar/productplaceholder.jpg"
                                                        alt=""
                                                        class="img-fluid img-90  blur-up lazyloaded dropzone dropzone-area dz-clickable">

                                                    <div class="fallback">
                                                        <input name="avatar_{{ $Counter }}"
                                                            class=" imguploadinput nested" id="triger_{{ $Counter }}"
                                                            type="file" />
                                                    </div>
                                                    <button id="changebutton_{{ $Counter }}" type="button"
                                                        class="btn btn-raised-danger"
                                                        onclick="imageupdloader('{{ $Counter }}')"
                                                        style="margin-top: -20px">
                                                        انتخاب تصویر</button>


                                                    <button id="canclebutton_{{ $Counter }}"
                                                        onclick="cancelimagechange('{{ $Counter }}')" type="button"
                                                        class="btn btn-raised-warning nested " style="margin-top: -20px;">
                                                        {{ __('discard') }}</button>




                                                </div>

                                                @php
                                                    $Counter++;
                                                @endphp


                                            </div>
                                        @else
                                            <div class="form-group row">
                                                <div class="form-group col-md-2">
                                                    {{ $picrefrenceItem->name }}
                                                </div>

                                                <div class="form-group col-md-2">
                                                    <img id="useravatar_{{ $Counter }}"
                                                        name=@if ($ImageArray != null) @foreach ($ImageArray as $ImageArrayItem)
                                                        @if ($ImageArrayItem->RefrenceID == $picrefrenceItem->id)
                                                    "{{ $Picurl = $ImageArrayItem->PicUrl }}" @endif
                                                        @endforeach
                                                @else
                                                    "{{ $Picurl = '' }}"
                                        @endif
                                        src=
                                        @if ($ImageArray != null) @foreach ($ImageArray as $ImageArrayItem)
                                                    @if ($ImageArrayItem->RefrenceID == $picrefrenceItem->id)
                                                "{{ $Picurl = $ImageArrayItem->PicUrl }}" @endif
                                    @endforeach
                                @else
                                    "{{ $Picurl = '' }}"
                                    @endif
                                    alt=""
                                    class="img-fluid img-90  blur-up lazyloaded dropzone dropzone-area dz-clickable">

                                    <div class="fallback">
                                        <input name="avatar_{{ $Counter }}" class=" imguploadinput nested"
                                            id="triger_{{ $Counter }}" type="file" />
                                    </div>
                                    <button id="changebutton_{{ $Counter }}" type="button"
                                        class="btn btn-raised-danger" onclick="imageupdloader('{{ $Counter }}')"
                                        style="margin-top: -20px">
                                        انتخاب تصویر</button>


                                    <button id="canclebutton_{{ $Counter }}"
                                        onclick="cancelimagechange('{{ $Counter }}')" type="button"
                                        class="btn btn-raised-warning nested " style="margin-top: -20px;">
                                        {{ __('discard') }}</button>




                                </div>

                                @php
                                    $Counter++;
                                @endphp
                            </div>



                        </div>
                        @endif
                        @endforeach

                        <div class="card-footer">
                            <div class="mc-footer">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <button class="btn btn-primary m-1" id="savebutton" type="submit" name="submit"
                                            value="UpdateIMG">ثبت تصاویر </button>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- end::form -->
                </div>
            </div>
        </div>
        </div>
        </div>
    </form>
@endsection
@section('page-js')
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js"></script>
    <script>
        function imageupdloader(TragetID) {
            $('#triger_' + TragetID).trigger('click');
        }

        function cancelimagechange(input) {
            $target = input;
            $('#useravatar_' + $target).attr('src', $('#useravatar_' + $target).attr('name'));
            $('#savebutton_' + $target).addClass('nested');
            $('#changebutton_' + $target).removeClass('nested');
            $('#canclebutton_' + $target).addClass('nested');

        }
    </script>
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $target = input.id;
                    $target = $target.replace('triger_', '')
                    $('#useravatar_' + $target).attr('src', e.target.result);
                    $('#savebutton_' + $target).removeClass('nested');
                    $('#changebutton_' + $target).addClass('nested');
                    $('#canclebutton_' + $target).removeClass('nested');
                }

                reader.readAsDataURL(input.files[0]); // convert to base64 string
            }
        }
        $(".imguploadinput").change(function() {

            readURL(this);

        });
    </script>
@endsection

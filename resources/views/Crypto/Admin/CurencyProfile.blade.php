@php
    $Persian = new App\Functions\persian();
@endphp

@extends('Layouts.MainPage')
@section('page-css')
    <link rel="stylesheet" href="{{ asset('assets/styles/vendor/dropzone.min.css') }}">
@endsection
@section('page-header-left')
@endsection
@section('MainCountent')
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-lg-6">
                    <div class="page-header-left">
                        <h3>عملیات ارز
                            <small>ویرایش ارز</small>
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
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-4">
                {{-- userprofile main --}}
                <div class="card">
                    <div class="card-body">
                        <div class="profile-details text-center">
                            @if ($CurncySrc->pic != null)
                                <form method="post" enctype="multipart/form-data" id="button-select-upload">
                                    @csrf
                                    <div>
                                        <img id="useravatar" name="{{ $CurncySrc->pic }}" src="{{ $CurncySrc->pic }}"
                                            alt="avatar"
                                            class="img-fluid img-90 rounded-circle blur-up lazyloaded dropzone dropzone-area dz-clickable">
                                        <div class="fallback">
                                            <input style="display: none" name="avatar" id="imguploadinput"
                                                type="file" />
                                        </div>
                                        <button id="changebutton" type="button" class="btn btn-raised-danger"
                                            onclick="imageupdloader()" style="margin-top: -20px">
                                            {{ __('change photo') }}</button>
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
                                    <div>

                                        <img id="useravatar" name="{{ url('/') }}/assets/images/avtar/useravatar.png"
                                            src="{{ url('/') }}/assets/images/avtar/useravatar.png" alt=""
                                            class="img-fluid img-90 rounded-circle blur-up lazyloaded dropzone dropzone-area dz-clickable">
                                        <div class="fallback">
                                            <input style="display: none" name="avatar" id="imguploadinput"
                                                type="file" />
                                        </div>
                                        <button id="changebutton" type="button" class="btn btn-raised-danger"
                                            onclick="imageupdloader()" style="margin-top: -20px">
                                            {{ __('change photo') }}</button>
                                        <button id="savebutton" type="submit" name="submit" value="UpdateIMG"
                                            class="btn btn-raised-warning nested "
                                            style="margin-top: -20px;background-color: coral;">
                                            {{ __('save') }}</button>
                                        <button id="canclebutton" type="submit" class="btn btn-raised-warning nested "
                                            style="margin-top: -20px;"> {{ __('discard') }}</button>



                                    </div>

                                </form>
                            @endif


                            <h5 class="f-w-600 mb-0">{{ $CurncySrc->MainName }}

                            </h5>
                            <span>{{ $CurncySrc->FaName }}</span>
                            <div class="social">
                                @switch($CurncySrc->status)
                                    @case(0)
                                        <span class="badge badge-danger" style="font-size: 18px">{{ __('Status') }}: غیر فعال
                                        </span>
                                    @break

                                    @case(1)
                                        <span class="badge badge-success" style="font-size: 18px">{{ __('Status') }}: فعال
                                        </span>
                                    @break

                                    @default
                                @endswitch
                            </div>
                            </form>
                        </div>
                        <hr>

                    </div>
                </div>
                </form>
                {{-- userprofile main --}}

            </div>
            <div class="col-xl-8">
                <div class="card tab2-card">
                    <div class="card-body">
                        <ul class="nav nav-tabs nav-material" id="top-tab" role="tablist">
                            <li class="nav-item"><a class="nav-link active" id="top-profile-tab" data-toggle="tab"
                                    href="#top-profile" role="tab" aria-controls="top-profile" aria-selected="true"><i
                                        data-feather="user" class="mr-2"></i>{{ __('Profile') }}</a>
                            </li>
                            <li class="nav-item"><a class="nav-link" id="contact-top-tab" data-toggle="tab"
                                    href="#credite-card" role="tab" aria-controls="top-contact"
                                    aria-selected="false"><i data-feather="credit-card" class="mr-2"></i>توضیحات ارز
                                </a>
                            </li>

                            <li class="nav-item"><a class="nav-link" id="contact-top-tab" data-toggle="tab"
                                    href="#setting" role="tab" aria-controls="top-contact" aria-selected="false"><i
                                        data-feather="settings" class="mr-2"></i>عملیات</a>


                            </li>
                            <li class="nav-item"><a class="nav-link" id="contact-top-tab" data-toggle="tab"
                                    href="#AdditionIDs" role="tab" aria-controls="top-contact"
                                    aria-selected="false"><i data-feather="AdditionIDs" class="mr-2"></i>مشخصات
                                    تکمیلی</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="top-tabContent">
                            <div class="tab-pane fade" id="AdditionIDs" role="tabpanel"
                                aria-labelledby="contact-top-tab">

                            </div>
                            <div class="tab-pane fade show active" id="top-profile" role="tabpanel"
                                aria-labelledby="top-profile-tab">
                                <h5 class="f-w-600">{{ __('Profile') }}</h5>
                                <form id="formtarget" method="post">
                                    @csrf
                                    <div class="table-responsive profile-table">
                                        <table class="{{ \App\myappenv::MainTableClass }}">
                                            <tbody>
                                                <tr>
                                                    <td>نام فارسی ارز</td>
                                                    <td class="textinfo">{{ $CurncySrc->FaName }}</td>
                                                    <td class="inputinfo nested"><input class="form-control"
                                                            name="Name" value="{{ $CurncySrc->FaName }}" />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>نام لاتین ارز</td>
                                                    <td class="textinfo">{{ $CurncySrc->ENName }}</td>
                                                    <td class="inputinfo nested"><input class="form-control"
                                                            name="ENName" value="{{ $CurncySrc->ENName }}" />
                                                    </td>
                                                </tr>

                                            </tbody>
                                        </table>
                                        <button type="button" id="converttoedite"
                                            class="btn btn-primary">{{ __('Edit') }}</button>
                                        <button type="button" id="Aboartedite"
                                            class="btn btn-danger nested">{{ __('aboart') }}</button>
                                        <button type="submit" name="submit" value="updatebaseinfo" id="submitedit"
                                            class="btn btn-success nested">{{ __('Submit') }}</button>


                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="credite-card" role="tabpanel"
                                aria-labelledby="contact-top-tab">
                                <h5 class="f-w-600">{{ __('Account number') }}</h5>

                            </div>
                            <div class="tab-pane fade" id="setting" role="tabpanel" aria-labelledby="contact-top-tab">
                                <h5 class="f-w-600">عملیات</h5>
                                <form id="formtarget" method="post">
                                    @csrf
                                    <div class="table-responsive profile-table">
                                        <table class="{{ \App\myappenv::MainTableClass }}">
                                            <tbody>
                                                @if ($CryptoCandeles == 0)
                                                    <tr>
                                                        <td> <button class="btn btn-success" type="submit"
                                                                name="submit" value="addcandel">دریافت کندل</button>
                                                        </td>
                                                        <td>دریافت کندل ها از صرافی</td>
                                                    </tr>
                                                @else
                                                    <tr>
                                                        <td> <button class="btn btn-danger" type="submit" name="submit"
                                                                value="renewcandel">حذف کندل های موجود و افزودن کندل از
                                                                صرافی</button> </td>
                                                        <td>دریافت کندل ها از صرافی <br>تعدا کندل های موجود
                                                            {{ $CryptoCandeles }} است </td>

                                                    </tr>
                                                @endif
                                                @if ($CurncySrc->status == 0 || $CurncySrc->status > 19)
                                                    <tr>
                                                        <td> <button class="btn btn-success" type="submit"
                                                                name="submit" value="activate">فعال سازی</button>
                                                        </td>
                                                        <td>فعال سازی ارز جهت نمایش به مشتری در پلتفرم</td>
                                                    </tr>
                                                @else
                                                    <tr>
                                                        <td> <button class="btn btn-danger" type="submit" name="submit"
                                                                value="deactive">غیر فعال سازی</button>
                                                        </td>
                                                        <td>غیر فعال سازی ارز و عدم نمایش به مشتری در پلتفرم</td>
                                                    </tr>

                                                    <tr>
                                                        @if ($Backtest == null)
                                                            <td> <button class="btn btn-danger" type="submit"
                                                                    name="submit" value="backtest">اجرای بک تست</button>
                                                            </td>
                                                            <td> فعال سازی بک تست</td>
                                                        @else
                                                            <td>
                                                                <p class="text-success">بک تست فعال است</p>
                                                            </td>
                                                            <td class="text-danger"> جهت فعال سازی مجدد بک تست تا اتمام بک
                                                                تست جاری منتظر بمانید</td>
                                                        @endif
                                                    </tr>
                                                @endif


                                            </tbody>
                                        </table>
                                        <button type="button" id="converttoedite"
                                            class="btn btn-primary">{{ __('Edit') }}</button>
                                        <button type="button" id="Aboartedite"
                                            class="btn btn-danger nested">{{ __('aboart') }}</button>
                                        <button type="submit" name="submit" value="updatebaseinfo" id="submitedit"
                                            class="btn btn-success nested">{{ __('Submit') }}</button>


                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="user-index" role="tabpanel"
                                aria-labelledby="contact-top-tab">
                                <h5 class="f-w-600">{{ __('user index') }}</h5>

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
    </script>
    <script>
        function nothaveID() {
            alert('جهت تغییر وضعیت به کاربر ويژه ابتدا کد ملی خود را در سیستم ثبت نمایید!');
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
        var toggler = document.getElementsByClassName("box");
        var i;

        for (i = 0; i < toggler.length; i++) {
            toggler[i].addEventListener("click", function() {
                this.parentElement.querySelector(".nested").classList.toggle("active");
                this.classList.toggle("check-box");
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
        $(function() {
            $('#converttoedite').click(function() {
                $(".textinfo").addClass('nested');
                $("#converttoedite").addClass('nested');
                $(".inputinfo").removeClass('nested');
                $("#Aboartedite").removeClass('nested');
                $("#submitedit").removeClass('nested');
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
                $("#submitedit").addClass('nested');
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
@endsection

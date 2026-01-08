@extends("WPA.Layouts.MainPage")

@section('MainCountent')
    <div class="page">
        <div class="page-content account-area">
            <div class="dz-banner"
                style=" width: 360px !important;right: calc((100vw - 360px) / 2);background-image:url({{ url('/') }}/images/banner/slide1.jpg); background-repeat:no-repeat; background-size:cover;">
            </div>
            <div class="dz-banner-height"></div>
            <div class="fixed-content py-30">
                <div class="container">
                    @if ($step == 1)
                        <div class="tabs">
                            <div class="tab tab-active form-elements tabs">
                                <div style="padding-right: 10px" class="card">
                                    @include('Layouts.ErrorHandler')
                                </div>
                                <form class="tab tab-active" method="post" id="tabA1">
                                    @csrf
                                    <div class="title-bar mb-20">
                                        <h3 class="dz-title ma-0">ثبت نام در سامانه</h3>
                                        <a href="{{ route('login') }}" class="icon-close"><i class="mdi mdi-arrow-left"></i></a>
                                    </div>
                                    <div class="list mb-0">
                                        <ul class="row">
                                            <li class="item-content item-input col-100 item-input-with-value">
                                                <div class="item-inner">
                                                    <div class="item-input-wrap">
                                                        <input type="number" autocomplete="off" required id="MobileNo"
                                                            name="MobileNo" placeholder="{{ __('Mobile No') }}" value=""
                                                            class="form-control" onkeyup="mobile_kye_down()" />
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="list">
                                        <ul>
                                            <button id="step1" type="submit" name="submit" value="step1" disabled
                                                class="button-large button button-fill disabled">{{ __('Send Submit Code') }}</button>
                                            <li class="mb-20 text-center"><a href="#tabA2" data-route-tab-id="tabA2"
                                                    class="tab-link fs-14 d-inline-block">ورود به سامانه</a></li>
                                        </ul>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @elseif ($step == 2)
                        <div class="tabs">
                            <div class="tab tab-active form-elements tabs">
                                <form class="tab tab-active" method="post" id="tabA1">
                                    @csrf
                                    <div class="title-bar mb-20">
                                        <h3 class="dz-title ma-0">{{ __('Send Submit Code') }}</h3>
                                        <a href="{{ route('login') }}" class="icon-close"><i class="mdi mdi-arrow-left"></i></a>
                                    </div>
                                    <div style="padding-right: 10px" class="card">
                                        @include('Layouts.ErrorHandler')
                                    </div>
                                    

                                    <div class="list mb-0">
                                        <ul class="row">
                                            <li class="item-content item-input col-100 item-input-with-value">
                                                <div class="item-inner">
                                                    <div class="item-input-wrap">
                                                        <input type="number" autocomplete="off" required id="MobileNo"
                                                            name="ConfirmCode" placeholder="کد دریافتی" value=""
                                                            class="form-control" />
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="list">
                                        <ul>
                                            <button type="submit" name="submit" value="ConfirmCode"
                                                class="button-large button button-fill">{{ __('Next step') }}</button>
                                            <hr>
                                            <div class="row">
                                                <button type="submit" style="background-color: rgb(21, 75, 0)" name="submit"
                                                    value="ResendCode"
                                                    class="col button-small button button-fill">{{ __('Resend code') }}</button>
                                                <button type="submit" name="submit" value="discard"
                                                    style="background-color: rgb(247, 4, 4)"
                                                    class="col button-small button button-fill">{{ __('discard') }}</button>
                                            </div>
                                        </ul>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @elseif ($step == 3)
                        <div class="tabs">
                            <div class="tab tab-active form-elements tabs">
                                <form class="tab tab-active" method="post" id="tabA1">
                                    @csrf
                                    <div class="title-bar mb-20">
                                        <h3 class="dz-title ma-0">{{ __('Save personal information') }}</h3>
                                        <a href="{{ route('login') }}" class="icon-close"><i class="mdi mdi-arrow-left"></i></a>
                                    </div>
                                    <div style="padding-right: 10px" class="card">
                                        @include('Layouts.ErrorHandler')
                                    </div>
                                    <div class="row">
                                        <label class="col form-check-label ml-3" for="gridRadios1">
                                            {{ __('Woman') }} <input class=" icon-radio" type="radio" name="Sex" value="f">
                                        </label>
                                        <label class="col form-check-label ml-3" for="gridRadios1">
                                            {{ __('Man') }} <input class=" icon-radio" type="radio" name="Sex" value="m" checked="">
                                        </label>
                                    </div>
                                    <hr>
                                    <div class="row"></div>
                                    <div class="list mb-0">
                                        <ul class="row">
                                            <label>{{ __('Name') }}</label>
                                            <li class="item-content item-input col-100 item-input-with-value">
                                                <div class="item-inner">
                                                    <div class="item-input-wrap">
                                                        <input id="input_name" style="
                                                            width: 82%;
                                                            height: 13px;
                                                            font-size: 20px;
                                                            font-family: 'iransans';
                                                        " name="Name" autocomplete="off" onkeyup="cehckinput()"
                                                            class="form-control" />
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="list mb-0">
                                        <ul class="row">
                                            <label>{{ __('Family') }}</label>
                                            <li class="item-content item-input col-100 item-input-with-value">
                                                <div class="item-inner">
                                                    <div class="item-input-wrap">
                                                        <input style="
                                                        width: 82%;
                                                        height: 13px;
                                                        font-size: 20px;
                                                        font-family: 'iransans';
                                                    " id="input_family" name="Family" autocomplete="off"
                                                            onkeyup="cehckinput()" class="form-control" />
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="list mb-0">
                                        <ul class="row">
                                            <label>{{ __('Password') }}</label>
                                            <li class="item-content item-input col-100 item-input-with-value">
                                                <div class="item-inner">
                                                    <div class="item-input-wrap">
                                                        <input style="
                                                        width: 82%;
                                                        height: 13px;
                                                        font-size: 20px;
                                                        font-family: 'iransans';
                                                    " id="input_password" name="Password" autocomplete="off"
                                                            onkeyup="cehckinput()" class="form-control" />
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="list">
                                        <button id="save_user" type="submit" name="submit" value="save" disabled
                                            class="button-large button button-fill disabled">{{ __('save') }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                    @elseif ($step == 4)
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        function mobile_kye_down() {
            var inputtext = $("#MobileNo").val();
            if (inputtext.startsWith('0') && inputtext.length > 0) {
                if (inputtext.length == 11) {
                    $("#step1").prop('disabled', false);
                    $("#step1").removeClass('disabled');

                } else {
                    $("#step1").prop('disabled', true);
                    $("#step1").addClass('disabled');
                }

            } else if (inputtext.length > 0) {
                alert("شماره موبایل می بایست با 0 شروع شود!");
                $("#MobileNo").val('');
            }

        }
    </script>
    <script>
        function cehckinput() {
            var input_name = $("#input_name").val();
            var input_family = $("#input_family").val();
            var input_password = $("#input_password").val();
            if (input_name.length > 2 && input_family.length > 2 && input_password > 3) {
                $("#save_user").prop('disabled', false);
                $("#save_user").removeClass('disabled');
            } else {
                $("#save_user").prop('disabled', true);
                $("#save_user").addClass('disabled');
            }

        }
    </script>
    <script type="text/javascript">
        $('#refresh-captcha').click(function() {
            $.ajax({
                type: 'GET',
                url: 'refresh-captcha',
                success: function(data) {
                    $(".captcha span").html(data.captcha);
                }
            });
        });
    </script>
@endsection

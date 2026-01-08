<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'fa' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @if ($branch_src == null)
        <title>{{ \App\myappenv::CenterName }}</title>
    @else
        <title>{{ $branch_src->Name }}</title>
    @endif
    @if (\App\myappenv::Captcha == 'google')
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
        <script>
            function onSubmit(token) {
                document.getElementById("login-form").submit();
            }
        </script>
    @endif
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet">
    <link id="gull-theme" rel="stylesheet" href="/assets/styles/css/themes/shafatel.min.css">
    <link id="gull-theme" rel="stylesheet" href="/assets/styles/css/themes/rtl.min.css">
    <link rel="stylesheet" href="/assets/styles/vendor/perfect-scrollbar.css">
    <link rel="icon" href="{{ url('/') . \App\myappenv::FavIcon }}">
    <script src='https://www.google.com/recaptcha/api.js'></script>

</head>

<body>
    @php
        $Feilds = App\Functions\CacheData::GetSetting('register_feilds');
        $Feilds = json_decode($Feilds);
        if (!isset($UserInfo->UserName)) {
            $UserName = null;
        } else {
            $UserName = $UserInfo->UserName;
        }
        $BrancSrc = App\Branchs\BranchsFunctions::get_user_name_branch_info($UserName);
    @endphp

    <div class="auth-layout-wrap style=text-align: right;" style="background-image: url({{ url('/') }})">
        <div class="auth-content">
            <div class="card o-hidden">
                <div class="row">
                    <div class="col-md-6">
                        <div class="p-4">
                            @include('Layouts.ErrorHandler')
                            <div>
                                <h1 class="mb-3 text-18 " style="text-align: center;">
                                    @if ($branch_src == null)
                                        <title style="display: block">{{ \App\myappenv::CenterName }}</title>
                                    @else
                                        <title style="display: block">{{ $branch_src->Name }}</title>
                                    @endif

                                    <hr>ورود با کد تایید
                                </h1>
                                <form method="post">
                                    @csrf
                                    <form method="post">
                                        @csrf
                                        <div class="form-group form-group-rtl">
                                            <label>{{ __('Sex') }}</label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="Sex"
                                                    value="m" checked="">
                                                <label class="form-check-label ml-3" for="gridRadios1">
                                                    {{ __('Man') }}
                                                </label>
                                                <input class="form-check-input" type="radio" name="Sex"
                                                    value="f">
                                                <label class="form-check-label ml-3" for="gridRadios1">
                                                    {{ __('Woman') }}
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group form-group-rtl">
                                            <label>{{ __('Name') }}</label>
                                            <input id="input_name" name="Name" autocomplete="off" required
                                                onkeyup="cehckinput()" class="form-control form-control-rounded"
                                                type="text">
                                        </div>
                                        <div class="form-group form-group-rtl">
                                            <label>{{ __('Family') }}</label>
                                            <input id="input_family" name="Family" required autocomplete="off"
                                                onkeyup="cehckinput()" class="form-control form-control-rounded"
                                                type="text">
                                        </div>
                                        @if (isset($Feilds->melliid))
                                            <div class="form-group form-group-rtl">
                                                <label>کد ملی</label>
                                                @if (isset($Feilds->melliid_req))
                                                    <input id="MelliID" name="MelliID" required autocomplete="off"
                                                        class="form-control form-control-rounded" type="text">
                                                @else
                                                    <input id="MelliID" name="MelliID" autocomplete="off"
                                                        class="form-control form-control-rounded" type="text">
                                                @endif
                                            </div>
                                        @endif
                                        <button id="save_user" type="submit" name="submit" value="SaveinfoOneTime" disabled
                                            class="btn btn-primary btn-block btn-rounded mt-3 ">{{ __('save') }}</button>
                                    </form>
                                </form>
                            </div>
                            <script>
                                function cehckinput() {
                                    var input_name = $("#input_name").val();
                                    var input_family = $("#input_family").val();
                                    if (input_name.length > 2 && input_family.length > 2) {
                                        $("#save_user").prop('disabled', false);

                                    } else {
                                        $("#save_user").prop('disabled', true);
                                    }
                                    if (input_name.length > 2 && input_family.length > 2) {
                                        $("#save_user_oneTime").prop('disabled', false);

                                    } else {
                                        $("#save_user_oneTime").prop('disabled', true);
                                    }

                                }
                            </script>


                        </div>
                    </div>

                    <div class="col-md-6 text-center "
                        style="background-size: cover;background-image: url({{ url('/') . \App\myappenv::login_background_image }})">
                        <div class="pr-3 auth-right">
                            <a href=" {{ route('home') }} ">
                                <div class="auth-logo text-center mb-4">
                                    @if ($branch_src == null)
                                        <img src="{{ $BrancSrc['branch_avatar'] }}" alt="">
                                    @else
                                        <img src="{{ $branch_src->avatar }}" alt="">
                                    @endif

                                </div>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <script src="/assets/js/common-bundle-script.js"></script>
        <script src="/assets/js/script.js"></script>
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


</body>

</html>

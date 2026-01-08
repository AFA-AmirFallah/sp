@include('web.layouts.head')
<body>
<div class="auth-layout-wrap" style="background-image: url({{asset('assets/images/photo-wide-4.jpg')}})">
    <div class="auth-content">
        <div class="card o-hidden">
            <div class="row">
                <div class="col-md-6 text-center "
                     style="background-size: cover;background-image: url({{asset('assets/images/photo-long-3.jpg')}})">
                    <div class="pl-3 auth-right">
                        <div class="auth-logo text-center mt-4">
                            <img src="{{ url('/') }}/images/Soapp.png" alt="">
                        </div>
                        <div class="flex-grow-1"></div>
                        <div class="w-100 mb-4">
                            <a class="btn btn-outline-primary btn-outline-email btn-block btn-icon-text btn-rounded"
                               href="{{route('login')}}">
                                <i class="i-Mail-with-At-Sign"></i> ورود
                            </a>
                        </div>
                        <div class="flex-grow-1"></div>
                    </div>
                </div>
                @if($Step == '2')
                    <div class="col-md-6">
                        <div class="p-4">

                            <h1 class="mb-3 text-18" style="text-align: center;">تایید شماره موبایل</h1>
                            <form method="post">
                                @csrf
                                @if(session('error'))
                                    <div class="alert alert-danger" style="direction: rtl; text-align: right;">
                                        <p>
                                            {{session('error')}}
                                        </p>
                                    </div>
                                @endif
                                <div class="form-group">
                                    <label for="username">ثبت کد تایید</label>
                                    <input id="username" name="ConfirmCode" class="form-control form-control-rounded"
                                           type="text">
                                </div>
                                <button type="submit" name="SignUp" value="ُSubmitCode"
                                        class="btn btn-primary btn-block btn-rounded mt-3">ثبت نام نهایی
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="col-md-6">
                        <div class="p-4">
                            <h1 class="mb-3 text-18" style="text-align: center;">ثبت نام</h1>
                            <form method="post">
                                @csrf
                                @if(session('error'))
                                    <div class="alert alert-danger" style="direction: rtl; text-align: right;">
                                        <p>
                                            {{session('error')}}
                                        </p>
                                    </div>
                                @endif
                                <div class="form-group">
                                    <label for="username">شماره موبایل</label>
                                    <input id="username" name="username" class="form-control form-control-rounded"
                                           type="text">
                                </div>
                                <button type="submit" name="SignUp" value="SendSMS"
                                        class="btn btn-primary btn-block btn-rounded mt-3">ارسال کد تایید
                                </button>
                            </form>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
<script src="{{asset('assets/js/common-bundle-script.js')}}"></script>
<script src="{{asset('assets/js/script.js')}}"></script>
</body>

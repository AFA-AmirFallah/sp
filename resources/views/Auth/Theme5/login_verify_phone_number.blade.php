<div class="row">
    <div class="col-xl-4 col-lg-5 col-md-7 col-12 mx-auto">
        <div class="logo-area text-center mb-3">
            <a href="#"><img src="{{ \App\myappenv::Sitelogo }}" class="img-fluid" alt="logo"></a>
        </div>
        <div class="auth-wrapper form-ui border pt-4">
            <div class="section-title title-wide mb-1 no-after-title-wide">
                <h2 class="font-weight-bold">تایید شماره</h2>
            </div>
            <input disabled id="UserName" class="d-none" value="{{ $phone_number }}">
            <div class="message-light">
                برای شماره همراه {{ $phone_number }} کد تایید ارسال گردید
                <a href="{{ route('login') }}" class="btn-link-border">
                    ویرایش شماره
                </a>
            </div>
            <form action="#">
                <div class="form-row-title">
                    <h3>کد تایید را وارد کنید</h3>
                </div>
                <div class="form-row">
                    <div class="numbers-verify">
                        <div class="lines-number-input">
                            @for ($i = 1; $i <= strlen(App\myappenv::minpass); $i++)
                                @if ($i == 1)
                                    <input inputmode="numeric" type="text" name="input[{{$i}}]" class="line-number" autocomplete="off"
                                         maxlength="1" autofocus="">
                                @else
                                    <input inputmode="numeric" type="text" name="input[{{$i}}]" class="line-number" autocomplete="off"
                                        maxlength="1">
                                @endif
                            @endfor

                        </div>
                    </div>
                </div>
                @if ($management_login)
                    <div class="form-row-title">
                        <h3>رمز عبور را وارد کنید</h3>
                    </div>
                    <div class="form-row">
                        <div class="numbers-verify">
                            <div class="lines-number-input">
                                <input id="admin_password" type="password" autocomplete="off" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="form-row mt-3">
                        <button type="button" onclick="send_verification_code_admin()"
                            class="btn-primary-cm btn-with-icon mx-auto w-100">
                            <i class="mdi mdi-login-variant"></i>
                            ورود به سپهرمال
                        </button>
                    </div>
                @endif
                <div class="form-row mt-3">
                    <div class="d-flex align-items-center">
                        <span class="text-primary btn-link-border ml-1">دریافت مجدد کد تایید</span>
                        <span>(</span>
                        <p id="countdown-verify-end"></p>
                        <span>)</span>
                    </div>
                </div>
            </form>
            <div class="form-footer mt-3">
                <div>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    if ($("#countdown-verify-end").length) {
        var $countdownOptionEnd = $("#countdown-verify-end");

        $countdownOptionEnd.countdown({
            date: new Date().getTime() + 120 * 1000, // 2 minute later
            text: '<span class="day">%s</span><span class="hour">%s</span><span>: %s</span><span>%s</span>',
            end: function() {
                $countdownOptionEnd.html(
                    "<a href='javascript:send_otp()' class='btn-link-border'>ارسال مجدد</a>"
                );
            },
        });

        $(".line-number").keyup(function() {
            total = '';
            pass_len = 0;
            input_char = $(this).val();
            if ($.isNumeric(input_char) == true) {
                $(this).next().focus();
            } else {
                $(this).val('');
            }
            $(".line-number").each(function() {
                total += $(this).val();
                pass_len++;
            });
            if (total.length == pass_len) {
                if ($('#admin_password').length > 0) { // admin login

                } else { //user login
                    send_verification_code(total);
                }

            }
        });
    }
</script>

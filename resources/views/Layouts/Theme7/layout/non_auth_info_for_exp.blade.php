<div id="user_submiter_info" class="d-none row">
    <div class="col-lg-12">
        <div class="form-group ">
            <label>
                مشخصات ثبت کننده
            </label>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="form-group ">
            <label> نام:<span class="reqired">*</span>
            </label>
            <input class="input-border form-control persian_limit" required name="user_Name" id="user_Name"
                placeholder=" نام خود را وارد کنید" type="text">
            <div class="invalid-feedback"> نام ثبت کننده.</div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="form-group ">
            <label> نام خانوادگی:<span class="reqired">*</span>
            </label>
            <input class="input-border form-control persian_limit" required name="user_Family" id="user_Family"
                placeholder="نام خانوادگی ثبت کننده" type="text">
            <div class="invalid-feedback"> نام خانوادگی ثبت کننده می باید وارد شود.
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="form-group ">
            <label>شماره تلفن همراه:<span class="reqired">*</span>
            </label>
            <input class="input-border form-control number_only " inputmode="numeric" required name="user_MobileNo"
                id="user_MobileNo" placeholder="09123412101" type="text">
            <div class="invalid-feedback"> شماره تلفن همراه ثبت کننده.</div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="form-group ">
            <label> کد امنیتی :<span class="reqired">*</span>
            </label>
            <div class="d-flex">
                <input style="margin: 0px" type="text" id="captcha" inputmode="numeric" name="captcha"
                    class="input-border form-control number_only @error('captcha') is-invalid @enderror"
                    placeholder="کد امنیتی">
                @error('captcha')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div style="display: contents" id="captcha-image">
                    <img src="{{ captcha_src() }}" alt="captcha">
                </div>

                <div class="mt-2"></div>
                <button type="button" onclick="refresh_captcha()" class="btn btn-info"><i
                        class=" fa fa-refresh"></i></button>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="form-group ">
            <label>کد یکبارمصرف:<span class="reqired">*</span>
            </label>
            <div class="input-group mb-3">


                <input type="text" inputmode="numeric" id="input_code" class="input-border form-control number_only"
                    aria-label="کد یکبار مصرف پیامک شده" placeholder="کد پیامک شده ">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="send_otp_btn" onclick="send_otp()" id="basic-addon2">ارسال
                        کدتائید</span>
                </div>
            </div>
            <div class="invalid-feedback">کد یکبار مصرف پیامک شده را وارد فرمائید.
            </div>
        </div>
    </div>
    <div class="col-lg-12 text-center">

        <button type="button" onclick="go_to_back()" class="btn btn-warning">بازگشت</button>
        <button type="button" onclick="reg_user_validation()" class="site-button">ثبت
            تجربه</button>
    </div>
</div>


<script>
    function check_code() {
        input_code = $('#input_code').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.post('', {
                function: 'code_verification',
                code: input_code
            },
            function(data, status) {

                if (data['result']) {
                    return true;
                } else {
                    alert('کد یکبارمصرف وارد شده صحیح نیست!');
                    return false;
                }
            });
    }

    function go_to_back() {
        $('#comment_div').removeClass('d-none');
        $('#user_submiter_info').addClass('d-none');
    }

    function refresh_captcha() {
        $('#captcha').val('');
        $.ajax({
            url: '/captcha-refresh', // Your endpoint for generating new captcha  
            type: 'GET',
            success: function(data) {
                $('#captcha-image').html(data);
            }
        });
    }
</script>

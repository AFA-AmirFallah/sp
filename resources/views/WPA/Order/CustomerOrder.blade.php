<?php
$Persian = new App\Functions\persian();
?>
@extends("WPA.Layouts.MainPage")

@section('MainCountent')
    <input id="confirmcode">
    <div id="phoneModal" class="sheet-modal my-sheet">
        <div class="toolbar">
            <div class="toolbar-inner">
                <div class="left">ثبت کد تایید</div>
                <div class="right"></div>
            </div>
        </div>
        <div class="sheet-modal-inner">
            <div class="block">
                <h4>ورود کد تایید</h4>
                <input style="text-align: center;width: 98%;font-size: 30px;" type="number" placeholder="کد تایید" required id="ConfirmCode_input"/>
                <button type="button" style="margin-bottom: 10px" onclick="confirm()"
                        class="col button button-raised button-fill button-round">ارسال مجدد
                </button>
                <button type="button" onclick="checkcode()"
                        class="col button button-raised button-fill button-round"> بررسی کد تایید

                </button>


            </div>
        </div>
    </div>

    <form method="post">
        @csrf
        <div class="page page-homepage light" data-name="homepage">
            <div class="page">
                <div class="navbar">
                    <div class="navbar-bg"></div>
                    <div class="navbar-inner sliding">
                        <div class="right">
                            <a href="{{route('home')}}" class="link external back">
                                <i class="icon icon-back"></i>
                                <span class="if-not-md">Back</span>
                            </a>
                        </div>
                        <div class="title">{{$catorder->Cat}}</div>
                    </div>
                </div>

                <div class="toolbar tabbar toolbar-bottom">
                    <div class="toolbar-inner">
                        <a href="#tab-1" id="tab1" class="tab-link tab-link-active">مرحله اول</a>
                        <a href="#tab-2" id="tab2" class="tab-link" onclick="step2()">مرحله دوم</a>
                        <a href="#tab-3" id="tab3" class="tab-link disabled" onclick="step3()">مرحله سوم</a>
                    </div>
                </div>
                <div class="tabs-animated-wrap">
                    <div class="tabs">
                        <div id="tab-1" class="page-content tab tab-active">
                            <div class="block">
                                <p>شرایط و توضیحات ارائه خدمت</p>
                                <p style="text-align: justify">
                                    مجموعه شفاتل با در اختیار داشتن سامانه جامع مدیریت خدمات سلامت HCIS به عنوان تسهیل
                                    گر
                                    سلامت
                                    درخواست شما را به مراکز دارای مجوز از وزارت بهداشت درمان و آموزش پزشکی ارائه می
                                    نماید و
                                    مراکز
                                    طرف قرارداد شفاتل بر اساس نوع درخواست شما عزیزان نسبت به ارائه خدمت اقدام خواهد
                                    نمود.
                                    شفاتل در کنار مشتریان و بیماران محترم نسبت به ارائه خدمت نظارت داشته و حامی بیماران
                                    و
                                    مشتریان
                                    عزیز خواهد بود.
                                    خواهشمند است به هیج عنوان با مراکز ارائه دهنده خدمت خارج از مجموعه شفاتل مراوده ای
                                    نداشته و
                                    تمام
                                    درخواست ها و پرداخت های خود را از طریق سایت و سامانه های شفاتل به انجام رسانید.

                                </p>
                            </div>
                        </div>
                        <div id="tab-2" class="page-content tab">
                            <div class="block">
                                <div class="block-title">زمان پیشنهادی جهت انجام خدمت</div>
                                <div class="list no-hairlines-md">
                                    <ul>
                                        <li>
                                            <div class="item-content item-input">
                                                <div class="item-inner">
                                                    <div class="item-input-wrap">
                                                        <input name="tododate" type="text"
                                                               placeholder="زمان پیشنهادی جهت انجام خدمت"
                                                               readonly="readonly" id="demo-picker-device"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="block">
                                <div class="block-title">شماره موبایل جهت هماهنگی</div>
                                <div class="list no-hairlines-md">
                                    <ul>
                                        <li>
                                            <div class="item-content item-input">
                                                <div class="item-inner">
                                                    <div class="item-input-wrap">
                                                        <input id="mobilenumber" name="mobilenumber" type="number"
                                                               placeholder="شماره موبایل هماهنگ کننده"
                                                               required />
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="block">
                                <div class="block-title">نام</div>
                                <div class="list no-hairlines-md">
                                    <ul>
                                        <li>
                                            <div class="item-content item-input">
                                                <div class="item-inner">
                                                    <div class="item-input-wrap">
                                                        <input name="name" placeholder="نام" type="text" required id="namefeild"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="block">
                                <div class="block-title">نام خانوادگی</div>
                                <div class="list no-hairlines-md">
                                    <ul>
                                        <li>
                                            <div class="item-content item-input">
                                                <div class="item-inner">
                                                    <div class="item-input-wrap">
                                                        <input  name="family"  type="text"   placeholder="نام خانوادگی" required id="familyfeild"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="block">
                                <div class="block-title">توضیحات</div>
                                <div class="block-header">مواردی که لازم است سوپروایزر در جریان قرار گیرد را جهت
                                    بهبود خدمت رسانی ذکر بفرمایید!
                                </div>
                                <textarea id="note" name="note" style="width: 90%" placeholder="توضیحات...."
                                          class="text-editor text-editor-init"></textarea>
                            </div>
                            <div class="block">
                                <div class="block-title">آدرس</div>
                                <div class="block-header">آدرس دقیق محل خدمت
                                </div>
                                <textarea id="address" name="address" style="width: 90%" placeholder="آدرس...."
                                          class="text-editor text-editor-init"></textarea>

                            </div>
                            <button type="button" onclick="confirm()"
                                    class="col button button-raised button-fill button-round">بررسی درخواست
                            </button>


                        </div>
                        <div id="tab-3" class="page-content tab">
                            <div class="block">
                                <p style="text-align: justify">مراجع محترم با تشکر از شما بابت انتخاب شفاتل - کوک
                                    باز</p>
                                <p style="text-align: justify">در صورت تمایل نسبت به ثبت درخواست لطفا درخواست خود را ثبت
                                    فرمایید.</p>
                                <p style="text-align: justify">درخواست شما پس از ثبت توسط کارشناسان و پزشکان ما بررسی و
                                    بر
                                    اساس درخواست شما و نظر پزشک و کارشناسان مرکز جهت خدمات متناسب با درخواست ثبت شده پس
                                    از
                                    هماهنگی با شما ارائه خواهد گردید </p>
                                <p style="text-align: justify">مشاواران ما حد اکثر تا یک ساعت دیگر در خصوص هماهنگی انجام
                                    خدمات با شما تماس خواهند گرفت</p>
                                <p style="text-align: justify">با آرزوی سلامتی برای شما!</p>
                                <button type="submit" name="submit" value="pwa"
                                        class="col button button-raised button-fill button-round">ثبت
                                    درخواست
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </form>
@endsection
@section('bottom-js')
    <script>
        var pickerDevice = app.picker.create({
            inputEl: '#demo-picker-device',
            cols: [
                {
                    textAlign: 'center',
                    values: [
                    @php
                        for ($i =1 ; $i < 8 ; $i++){
$OutPut = "'".$Persian->TodayPersian($i);
if($i != 7){
    $OutPut .= "',";
}else{
    $OutPut .= "']";
}
 echo  $OutPut;

}

                    @endphp
                }
            ]
        });
    </script>

    <script>


        function step2() {
            //   mobilenumber = $("#mobilenumber").val();
            // alert(mobilenumber);
        }

        function step3() {
            mobilenumber = $("#mobilenumber").val();
            $("#tab3").removeClass("tab-link-active");  // this deactivates the home tab
            $("#tab2").addClass("tab-link-active");  // this activates the profile tab
        }

        function mymodal() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('<?php echo e(route('ajax')); ?>',
                {
                    AjaxType: 'SendConfirmCodeSMS',
                    MobileNumber: $("#mobilenumber").val(),
                },

                function (data, status) {
                    if (data == '1') {
                        alert('yes');
                    } else {
                        alert('بروز مشکل در انجام عملیات!');
                    }
                });


        }

    </script>
    <script src="{{mix('assets/js/common-bundle-script.js')}}"></script>
    <script>
        function confirm() {
            app.tab.show('#tab-3');
            mobilenumber = $("#mobilenumber").val();
            if (mobilenumber.length != 11 || mobilenumber.substr(0, 2) != '09') {
                alert('شماره موبایل وارد شده اشتباه است');
            } else if ($("#demo-picker-device").val() == '') {
                alert('datepicker error');
            } else if ($("#address").val() == '') {
                alert('آدرس وارد نشده است!');
            } else if ($("#note").val() == '') {
                alert('توضیحات وارد نشده است');
            }else if ($("#namefeild").val() == '') {
                alert('نام وارد نشده است');
            }else if ($("#familyfeild").val() == '') {
                alert('نام خانوادگی وارد نشده است');
            } else {
                $("#phoneModal").addClass("modal-in");  // this activates the profile tab
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.post('<?php echo e(route('ajax')); ?>',
                    {
                        AjaxType: 'SendConfirmCodeSMS',
                        MobileNumber: $("#mobilenumber").val(),
                    },

                    function (data, status) {
                        $("#confirmcode").val(data);
                    });


            }

        }

        function checkcode() {
            if($("#ConfirmCode_input").val() == $("#confirmcode").val()){
                $("#tab3").removeClass("disabled");  // this activates the profile tab
                app.tab.show('#tab-3');
                $("#phoneModal").removeClass("modal-in");
                $("#tab1").addClass("disabled");  // this activates the profile tab
                $("#tab2").addClass("disabled");  // this activates the profile tab
            }else{
                alert('کد وارد شده صحیح نیست!');
            }
        }


    </script>

@endsection

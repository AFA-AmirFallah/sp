@extends('Layouts.Moshavereh.objects.MainLayout')
@php
    $UserInfo = $Consult->get_consulter_info($userid);
    $serviceItems = $Consult->get_worker_working_cats($UserInfo->UserName, null);
    $worktime = $Consult->get_extra_Fild($UserInfo->extradata, 'WorkTime');
@endphp
@section('MainTitle')
    {{ $UserInfo->Name }} {{ $UserInfo->Family }}
@endsection
@section('content')
    <style>
        .consultresult.success {
            background-color: greenyellow;
            font-weight: 800;
            padding: 10px;
        }
        .consultresult.warning {
            background-color: rgb(255, 47, 75);
            width: 100%;
            margin-top: 10px;
            padding: 10px;
            font-size: 20px;
            font-weight: 800;
            border-radius: 40px;
        }
        .dash-s {
            border: 2px solid #10ae82;

        }
        .consult-time {
            font-size: 14px;
            width: 100%;
            display: flex;
            min-height: 49px;
            align-items: center;
            justify-content: space-between;
            background-color: #F9F9F9;
        }
    </style>
    <form method="post">
        @csrf
        <section class="mt-3 ">

            <div class="container">
                <div class="row box  mx-wh  p-4  bg-half">
                    <div class="col-md-3  text-center">
                        <img src="{{ $UserInfo->avatar ?? App\myappenv::LoginUserAvatarPic }}" alt="{{ $UserInfo->Name }} {{ $UserInfo->Family }}" class="img-fluid rounded-circle border pic160" /><br />
                        <p class="pt-3 IRANSansWeb_Medium">کد مشاور : {{ $userid }}</p>
                    </div>
                    <div class="col-md-9 text-md-right text-center">
                        <h1 class="IRANSansWeb_Medium text-white b-dark mb-0">{{ $UserInfo->Name }} {{ $UserInfo->Family }}
                        </h1>
                        <span class="float-md-left float-none">
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                        </span>
                        <p class="text-sm-white IRANSansWeb_Medium text-white b-dark">
                            {{ $UserInfo->extranote }}

                        </p>

                        @if ($Consult->is_user_active($UserInfo->UserName))
                            <p class="mt-3 mb-0 IRANSansWeb_Medium text-success"><i class="online ml-2"></i>آماده پاسخگویی
                            </p>
                        @else
                            <p class="mt-3 mb-0 IRANSansWeb_Medium text-dark"><i class="offline ml-2"></i>
                                وضعیت: خارج از دسترس
                            </p>
                        @endif
                        <p>
                            <span class="IRANSansWeb_Medium">
                                @foreach ($serviceItems as $serviceItem)
                                    {{ $serviceItem->Name }}
                                @endforeach
                            </span>

                        </p>


                        {{--     <a href="#Chat" onclick="goToId('#Chat', 1000); return false;"
                            class="btn btn-success px-4 py-2 text-white  rad25 float-md-left mb-3  "><i
                                class="far fa-comment"></i> گفتگوی متنی با مشاور</a> --}}
                        <a href="#Call" onclick="goToId('#Call', 1000); return false;"
                            class="btn btn-danger px-4 py-2 text-white rad25 float-md-left ml-md-3 mb-3"><i
                                class="fas fa-phone"></i> گفتگوی تلفنی با مشاور</a>
                    </div>
                </div>

                <div class="row mt-4 p-4  mx-wh box">
                    <div class="col-md-12">
                        <h5 class="IRANSansWeb_Medium bg-light rad25 py-2 px-3 ">درباره مشاور</h5>
                        <p class="text-justify">
                            {!! $Consult->get_extra_Fild($UserInfo->extradata, 'InfoTxt') !!}
                        </p>
                    </div>
                </div>
                <div class="mt-4 p-4  mx-wh box text-md-right text-center">
                    <h5 class="IRANSansWeb_Medium bg-light py-2 px-3  mb-4 rad25"> ساعت کاری مشاور </h5>
                    @if ($Consult->get_extra_Fild($UserInfo->extradata, 'worktime') == null)
                        ساعت کاری مشاوره در دسترس نیست
                    @else
                        @for ($i = 1; $i < 8; $i++)
                            @php
                                $from = 'form' . $i;
                                $to = 'to' . $i;
                                $Day = 'Day' . $i;
                            @endphp
                            <div class="col-lg-7 mt-3">
                                <span class="dash-s p-2 rad25 mb-3 consult-time">
                                    @if ($worktime->$from == null)
                                        <span class="pl-3">

                                            <i class="fas fa-times fa-2x text-danger pl-1  "></i>
                                            {{ $worktime->$Day }} </span>
                                        <span class="pl-3">
                                            <div value="0" id="disabletime">
                                                غیرفعال
                                            </div>
                                        </span>
                                    @else
                                        <span class="pl-3">
                                            <i class="fas fa-check pl-1 text-success"></i>
                                            {{ $worktime->$Day }} </span>
                                        <span class="pl-3">
                                            {{ $worktime->$from }} - {{ $worktime->$to }}
                                        </span>
                                    @endif


                                </span>
                            </div>
                        @endfor
                    @endif
                </div>




            </div>
            </div>
            <div id="Call" class="mt-4 p-4  mx-wh box text-md-right text-center">
                <h5 class="IRANSansWeb_Medium  bg-light py-2 px-3  mb-4 rad25"> تماس تلفنی با مشاور (در کمترین زمان)
                </h5>

                <div class="row">

                    <div class="col-lg-7">
                        <p>

                            شروع تماس بلافاصله بعد از ثبت درخواست
                        </p>
                        <span class="dash-g p-2 rad25 mb-3">

                            @foreach ($serviceItems as $serviceItem)
                                @if ($loop->first)
                                    <a onclick="changeService({{ $serviceItem->SkilID }})"> <span class="pl-3">
                                            <div id="itemcheckdiv-{{ $serviceItem->SkilID }}" class="div-cehckbox"
                                                style="display: contents">
                                                <i class="fas fa-check pl-1 text-success"></i>
                                            </div> {{ $serviceItem->Name }}
                                        </span>
                                    </a>
                                @else
                                    <a onclick="changeService({{ $serviceItem->SkilID }})"> <span class="pl-3">
                                            <div id="itemcheckdiv-{{ $serviceItem->SkilID }}" class="div-cehckbox"
                                                style="display: contents">
                                            </div> {{ $serviceItem->Name }}
                                        </span>
                                    </a>
                                @endif
                            @endforeach
                        </span>
                    </div>
                    <div class="col-lg-2 text-md-left text-center my-3">
                        @foreach ($serviceItems as $serviceItem)
                            @if ($loop->first)
                                <input id="selected_service" name="selected_service" class="nested"
                                    value="{{ $serviceItem->SkilID }}">
                                <span id="price-service-{{ $serviceItem->SkilID }}"
                                    class="serviceOptions IRANSansWeb_Light fa-2x">
                                    {{ number_format($serviceItem->CustomerfixPrice / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                    {{ App\Http\Controllers\Credit\currency::GetCurrency() }}

                                </span>
                            @else
                                <span id="price-service-{{ $serviceItem->SkilID }}"
                                    class="nested serviceOptions IRANSansWeb_Light fa-2x">
                                    {{ number_format($serviceItem->CustomerfixPrice / App\Http\Controllers\Credit\currency::GetCurrencyRate()) }}
                                    {{ App\Http\Controllers\Credit\currency::GetCurrency() }}
                                </span>
                            @endif
                        @endforeach

                    </div>
                    <div class="col-lg-3 text-md-left text-center">
                        <a onclick="activecall()" class="btn btn-danger px-4 text-white rad25  ml-3 "><i
                                class="fas fa-phone mt-2"></i> شروع مشاوره</a>
                    </div>
                </div>
                <div id="consultresult" class="mt-4 p-4  mx-wh box text-md-right text-center consultresult nested">

                </div>
            </div>



            {{--     <div id="Chat" class="mt-4 p-4  mx-wh box text-md-right text-center">
                <h5 class="IRANSansWeb_Medium bg-light py-2 px-3  mb-4 rad25">گفتگوی متنی با مشاور</h5>
                <div class="row">

                    <div class="col-lg-7">
                        <p>
                            با مشاور تا کمتر از 3 ساعت دیگر به صورت متنی گفتگو کنید! مشاور با شما چت خواهد کرد و حداکثر
                            در
                            15 دقیقه پاسخگوی سوال شما خواهد بود. گوش به زنگ مشاور باشید.
                        </p>
                        <span class="dash-g p-2 rad25 mb-3">
                            <span class="pl-3"><i class="fas fa-times fa-2x text-danger pl-1 "></i>تماس تلفنی</span>
                            <span class="pl-3"><i class="fas fa-check pl-1 text-success"></i>ارسال متن</span>
                            <span class="pl-3"><i class="fas fa-check pl-1 text-success"></i>ارسال عکس</span>
                            <span class="pl-3"><i class="fas fa-check pl-1 text-success"></i>ارسال صوت</span>
                        </span>
                    </div>
                    <div class="col-lg-2 text-md-left text-center my-3">
                        <span class="IRANSansWeb_Light fa-2x">
                            26,000 تومان
                        </span>
                    </div>
                    <div class="col-lg-3 text-md-left text-center">
                        <a href="Login.html" class="btn btn-success px-4 text-white rad25  ml-3 "><i
                                class="far fa-comment mt-2"></i> شروع چـت </a>
                    </div>
                </div>
            </div> --}}


            <div class="mt-4 p-4  mx-wh box">
                <h5 class="IRANSansWeb_Medium bg-light py-2 px-3  mb-4 rad25">نظرات کاربران</h5>

                {{--   <ul>
                    <li>
                        <div class="d-flex flex-row flex-wrap justify-content-between dash rad25 m-md-3 m-1 p-3">
                            <div>
                                <span class="IRANSansWeb_Medium pl-4">علی حمیدی</span>
                                <span>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                </span>
                                <p class="mb-0">پاسخ گویی شون عالی و خوب بود</p>
                            </div>

                            <div class="float-left">
                                <span>22 : 16</span> -
                                <span>1398/4/25</span>
                            </div>

                        </div>
                    </li>

                </ul> --}}


                <div class="py-3 px-sm-5 sencom">
                    <h6 class="IRANSans-Bold pl-2 ml-3 IRANSansWeb_Medium">ارسال دیدگاه :</h6>
                    <img src="../Mosahvereh/Images/avatar.jpg" class="img-fluid mb-2 rounded-circle" />
                    <div class="form-group">
                        <input class="form-control w-75" type="text" name="name" placeholder="نـام" />
                        <input class="form-control w-75" type="email" name="email" placeholder="ایـمیل" />
                        <textarea class="form-control area" cols="60" rows="9" name="comment" placeholder="دیدگاه"
                            style="height: 150px!important"></textarea>
                    </div>
                    <button type="submit" name="AddComment" class="btn btn-warning mb-3">ارسـال &nbsp;<i
                            class="fa fa-paper-plane"></i></button>
                </div>
            </div>
            </div>
        </section>
    </form>
@endsection




<script>
    function changeService($selectedItem) {

        $('.serviceOptions').addClass('nested');
        $('.div-cehckbox').html('');
        $('#price-service-' + $selectedItem).removeClass('nested');
        $('#itemcheckdiv-' + $selectedItem).html('<i class="fas fa-check pl-1 text-success"></i>');
        $('#selected_service').val($selectedItem);
    }

    function activecall() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.post('', {
                ajax: true,
                procedure: 'callrequest',
                Service: $('#selected_service').val(),

            },
            function(data, status) {
                $('#consultresult').removeClass('nested');
                if (data[1] == 'success') {
                    $('#consultresult').removeClass('warning');
                    $('#consultresult').addClass('success');
                } else {
                    $('#consultresult').removeClass('success');
                    $('#consultresult').addClass('warning');
                }
                $('#consultresult').html(data[0]);
            });

    }

    function goToId(hash, animationTime) {
        var target = hash,
            scrollTop = target != "" ? $(target).offset().top : 0;
        $('html, body').stop().animate({
            'scrollTop': scrollTop
        }, animationTime, 'swing', function() {
            window.location.hash = target;
        });
    }
</script>

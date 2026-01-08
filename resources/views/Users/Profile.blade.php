@php
    $Persian = new App\Functions\persian();
@endphp

@extends('Layouts.MainPage')
@section('page-css')
    <script src="{{ asset('assets/js/webcam.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('assets/styles/vendor/dropzone.min.css') }}">
@endsection
@section('page-header-left')
@endsection
@section('MainCountent')
    @if (Auth::user()->Role == \App\myappenv::role_customer)
        <input type="text" class="nested" id="UserName" value="{{ Auth::id() }}">
        <input type="text" class="nested" id="UserName_page" value="{{ Auth::id() }}">
    @else
        <input type="text" class="nested" id="UserName" value="{{ App\Patient\PatientClass::PatientGetter() }}">
        <input type="text" class="nested" id="UserName_page" value="{{ $UserInfoResult->UserName }}">
        <div id="app">
            <Patdashboard></Patdashboard>
        </div>
    @endif
    <!-- Container-fluid starts-->
    @if (Auth::user()->Role == \App\myappenv::role_worker && !\App\myappenv::Lic['hiring'])
        @include('Dashboard.layouts.worker_top_bar')
    @endif

    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-header gradient-purple-indigo 0-hidden pb-80 d-float">
                        <h5 class="text-white"><i class=" header-icon i-Administrator"></i>{{ $UserInfoResult->nameofuser }}
                            {{ $UserInfoResult->Family }}
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="profile-details text-center">
                            @if ($UserInfoResult->avatar != null)
                                <form method="post" enctype="multipart/form-data" id="button-select-upload">
                                    @csrf
                                    <div>
                                        <img id="useravatar_1" name="{{ $UserInfoResult->avatar }}"
                                            src="{{ $UserInfoResult->avatar }}" alt="avatar"
                                            class="img-fluid img-90 rounded-circle blur-up lazyloaded dropzone dropzone-area dz-clickable">
                                        <div class="fallback">
                                            <input style="display: none" name="avatar" class="imguploadinput"
                                                id="imguploadinput_1" type="file" />
                                        </div>
                                        <button id="changebutton" type="button" class="btn btn-raised-danger"
                                            onclick="imageupdloader('_1')" style="margin-top: -20px">
                                            {{ __('change photo') }}</button>
                                        <button id="savebutton_1" type="submit" name="submit" value="UpdateIMG"
                                            class="btn btn-raised-warning nested "
                                            style="margin-top: -20px;background-color: rgb(30, 194, 71);">
                                            {{ __('save') }}</button>
                                        <button id="canclebutton_1" type="button" class="btn btn-raised-warning nested "
                                            onclick="cancelimagechange()" style="margin-top: -20px;">
                                            {{ __('discard') }}</button>
                                    </div>

                                </form>
                            @else
                                <form method="post" enctype="multipart/form-data" id="button-select-upload">
                                    @csrf
                                    <div>
                                        <img id="useravatar_2"
                                            name="{{ url('/') }}/assets/images/avtar/useravatar.png"
                                            src="{{ url('/') }}/assets/images/avtar/useravatar.png" alt=""
                                            class="img-fluid img-90 rounded-circle blur-up lazyloaded dropzone dropzone-area dz-clickable">
                                        <div class="fallback">
                                            <input style="display: none" name="avatar" class="imguploadinput"
                                                id="imguploadinput_2" type="file" />
                                        </div>
                                        <button id="changebutton" type="button" class="btn btn-raised-danger"
                                            onclick="imageupdloader('_2')" style="margin-top: -20px">
                                            {{ __('change photo') }}</button>
                                        <button id="savebutton_2" type="submit" name="submit" value="UpdateIMG"
                                            class="btn btn-raised-warning nested "
                                            style="margin-top: -20px;background-color: rgb(30, 194, 71);">
                                            {{ __('save') }}</button>
                                        <button id="canclebutton_2" type="submit" class="btn btn-raised-warning nested "
                                            style="margin-top: -20px;"> {{ __('discard') }}</button>
                                    </div>

                                </form>
                            @endif
                            <form id="formtarget"
                                action="{{ route('UserProfile', ['RequestUser' => $UserInfoResult->UserName]) }}"
                                method="post">
                                @csrf
                                @if (\App\myappenv::Lic['Voip'] && !$SelfConfig)
                                    <button type="button" onclick="BothSideCall()" class="btn btn-success"
                                        style="margin:auto;display:block" name="submit">
                                        تماس دو طرفه
                                    </button>
                                @endif
                                <h5 class="f-w-600 mb-0">{{ $UserInfoResult->nameofuser }}
                                    {{ $UserInfoResult->Family }}
                                </h5>
                                @if (!$SelfConfig)
                                    <span><a class="btn " href="tel:{{ $UserInfoResult->MobileNo }}"><i
                                                style="font-size: large" class="i-Telephone"></i>
                                            {{ $UserInfoResult->MobileNo }}</a></span>
                                @endif
                                <div class="social">
                                    @if ($UserInfoResult->Role > \App\myappenv::role_worker)
                                        <div class="row">
                                            <div class="col">
                                                <span class="badge badge-danger"
                                                    style="font-size: 18px">{{ __('User Role') }}:
                                                    {{ $UserInfoResult->RoleName }}</span>
                                            </div>
                                            <div class="col">
                                                <span class="badge badge-warning"
                                                    style="font-size: 18px">{{ __('Status') }}:
                                                    {{ $UserInfoResult->statusname }}</span>
                                            </div>
                                        </div>
                                    @endif
                                    @if (
                                        $UserInfoResult->branch == \App\myappenv::shafatelmanagedcustomers_done ||
                                            $UserInfoResult->branch == \App\myappenv::shafatelunmanagedcustomers)
                                        <div class="row" style="display: block;text-align: center;margin-top: 10px;">
                                            <span class="badge badge-danger"
                                                style="font-size: 18px">{{ __('Shafatel User') }}</span>

                                        </div>
                                    @endif
                                </div>
                            </form>
                            <div style="display: inline-block;margin-top: 15px;margin-right:15px;align-items: center;"
                                class="row">
                                @if (\App\myappenv::Lic['hiring'] && $UserInfoResult->Role == \App\myappenv::role_worker)
                                    <div class="menu-icon-grid w-auto p-0">
                                        <a style="
                                        border-style: groove;
                                        border-color: lightseagreen;
                                    "
                                            href="{{ route('PersonelCard', ['RequestUser' => $UserInfoResult->UserName]) }}"><i
                                                class="i-Shop-4"></i>صفحه شخصی</a>
                                        <a style="
                                        border-style: groove;
                                        border-color: lightseagreen;
                                        margin-left: 3px;
                                        margin-right: 3px;
                                    "
                                            href="{{ route('PersonelCard', ['RequestUser' => $UserInfoResult->UserName]) }}"
                                            target="_blank"><i class="i-Checked-User"></i> کارت‌ شناسائی</a>
                                        <a style="
                                        border-style: groove;
                                        border-color: lightseagreen;
                                    "
                                            href="#"><i class="i-Library"></i> رزومه من </a>
                                    </div>
                                @else
                                    @if (\App\myappenv::Lic['PersonelCard'] && $UserInfoResult->Role == \App\myappenv::role_worker)
                                        <div class="menu-icon-grid w-auto p-0">
                                            <div
                                                style="
                                            text-align: center;
                                            background-color: green;
                                            color: white;
                                            font-size: 18px;
                                        padding-left: 20px;
                                        margin-right:3px;
                                            padding-right: 20px;
                                            border-radius: 10px 10px 0px 0px;
                                        ">
                                                اطلاعات پرستاربانک</div>
                                            <div id="parastarbank_holder"
                                                style="
                                            width:100%;
                                    border-style: groove;
                                    border-color: lightseagreen;
                                    margin-bottom: 5px !important;
                                    margin-right: 3px;
                                    height: 110px;
                                ">

                                                پرستاربانک ....
                                            </div>

                                        </div>
                                        <div class="menu-icon-grid w-auto p-0">

                                            <a style="
                                        border-style: groove;
                                        border-color: lightseagreen;
                                        margin-left: 3px;
                                        margin-right: 3px;
                                    "
                                                href="{{ route('PersonelCard', ['RequestUser' => $UserInfoResult->UserName]) }}"
                                                target="_blank"><i class="i-Checked-User"></i> کارت‌ شناسائی</a>
                                            <a style="
                                        border-style: groove;
                                        border-color: lightseagreen;
                                    "
                                                href="{{ route('myprofile', ['RequestUser' => $UserInfoResult->UserName]) }}"><i
                                                    class="i-Library"></i> رزومه من </a>
                                            <a style="
                                                border-style: groove;
                                                border-color: lightseagreen;
                                            "
                                                href="{{ route('PersonelCard', ['RequestUser' => $UserInfoResult->UserName]) }}"><i
                                                    class="i-Shop-4"></i>صفحه شخصی</a>
                                        </div>
                                    @else
                                        <a href="{{ route('myprofile') }}">پروفایل</a>
                                    @endif
                                @endif
                            </div>


                        </div>


                        @if (!$SelfConfig)
                            <hr>
                            <form method="post">
                                @csrf
                                <div class="project-status">
                                    <div>
                                        <h5 class="f-w-600">{{ __('Send SMS:') }}</h5>
                                    </div>
                                    <div style="text-align: right">
                                        <textarea name="MessageText" class="form-control" required placeholder="{{ __('Enter your SMS text!!') }}"
                                            cols="37" rows="10"></textarea>
                                        <div>
                                            <button type="submit" class="btn btn-warning"
                                                style="margin:auto;display:block" name="submit" value="SendSms">
                                                {{ __('send') }}
                                            </button>


                                        </div>
                                    </div>


                                </div>
                            </form>
                        @endif
                    </div>

                </div>
                </form>
                {{-- userprofile main --}}


            </div>
            <div class="col-xl-8">
                <div class="card tab2-card">
                    <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                        <h5 class="text-white"><i class=" header-icon i-Receipt-3"></i> اطلاعات پایه:
                            {{ $UserInfoResult->nameofuser }}
                            {{ $UserInfoResult->Family }}</h5>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-pills" id="top-tab" role="tablist">
                            <li class="nav-item"><a class="nav-link active" id="top-profile-tab" data-toggle="tab"
                                    href="#top-profile" role="tab" aria-controls="top-profile"
                                    aria-selected="true"><i data-feather="user"
                                        class="mr-2"></i>{{ __('Profile') }}</a>
                            </li>
                            @if (App\myappenv::Lic['hiring'])
                                <li class="nav-item"><a class="nav-link" id="contact-top-tab" data-toggle="tab"
                                        href="#can_do" role="tab" aria-controls="top-contact"
                                        aria-selected="false"><i data-feather="can_do" class="mr-2"></i>مهارت ها</a>
                                </li>
                            @endif
                            @if (App\myappenv::Lic['woocommerce'])
                                <li class="nav-item"><a class="nav-link" id="contact-top-tab" data-toggle="tab"
                                        href="#woocommerce" role="tab" aria-controls="top-contact"
                                        aria-selected="false"><i data-feather="woocommerce" class="mr-2"></i>سوابق
                                        خرید</a>
                                </li>
                            @endif
                            @if (\App\myappenv::Lic['hiring'] && $UserInfoResult->Role == \App\myappenv::role_worker)
                            @else
                                <li class="nav-item"><a class="nav-link" id="contact-top-tab" data-toggle="tab"
                                        href="#credite-card" role="tab" aria-controls="top-contact"
                                        aria-selected="false"><i data-feather="credit-card"
                                            class="mr-2"></i>{{ __('Account number') }}
                                    </a>
                                </li>
                            @endif
                            @if (!$SelfConfig)
                                <li class="nav-item"><a class="nav-link" id="contact-top-tab" data-toggle="tab"
                                        href="#user-index" role="tab" aria-controls="top-contact"
                                        aria-selected="false"><i data-feather="book"
                                            class="mr-2"></i>{{ __('user index') }}
                                    </a>
                                </li>
                            @endif
                            @if ($UserInfoResult->Role == \App\myappenv::role_worker)
                                @php
                                    $doc_src = $user_class->get_role_documentation($UserInfoResult->Role);
                                @endphp
                                @if ($doc_src != null)
                                    <li class="nav-item"><a class="nav-link" id="contact-top-tab" data-toggle="tab"
                                            href="#uploader" role="tab" aria-controls="top-contact"
                                            aria-selected="false"><i data-feather="uploader" class="mr-2"></i>آپلود
                                            مدارک</a>
                                    </li>
                                @endif
                                @if (Auth::user()->Role > \App\myappenv::role_admin)
                                    <li class="nav-item"><a class="nav-link" id="contact-top-tab" data-toggle="tab"
                                            href="#setting-tab" role="tab" aria-controls="top-contact"
                                            aria-selected="false"><i data-feather="setting-tab"
                                                class="mr-2"></i>{{ __('setting') }}</a>
                                    </li>
                                @endif
                            @endif
                            <li class="nav-item"><a class="nav-link" id="contact-top-tab" data-toggle="tab"
                                    href="#setting-tab" role="tab" aria-controls="top-contact"
                                    aria-selected="false"><i data-feather="setting-tab"
                                        class="mr-2"></i>{{ __('setting') }}</a>
                            </li>

                            <li class="nav-item"><a class="nav-link" id="contact-top-tab" data-toggle="tab"
                                    href="#AdditionIDs" role="tab" aria-controls="top-contact"
                                    aria-selected="false"><i data-feather="AdditionIDs" class="mr-2"></i>مشخصات
                                    تکمیلی</a>
                            </li>
                            @if (!$SelfConfig)
                                <li class="nav-item"><a class="nav-link" id="contact-top-tab" data-toggle="tab"
                                        href="#Descriptions" role="tab" aria-controls="top-contact"
                                        aria-selected="false"><i data-feather="Descriptions"
                                            class="mr-2"></i>توضیحات</a>
                                </li>
                            @endif
                            @if (App\myappenv::Lic['affiliate'])
                                <li class="nav-item"><a class="nav-link" id="contact-top-tab" data-toggle="tab"
                                        href="#affiliate" role="tab" aria-controls="top-contact"
                                        aria-selected="false"><i data-feather="affiliate" class="mr-2"></i>همکاری در
                                        فروش</a>
                                </li>
                            @endif

                        </ul>

                        <div class="tab-content" id="top-tabContent">

                            @if (App\myappenv::Lic['affiliate'])
                                <div class="tab-pane fade" id="affiliate" role="tabpanel"
                                    aria-labelledby="contact-top-tab">
                                    <div class="flex-grow-1 p-4">
                                        <h5 class="m-0">لینک ارجاع کاربر</h5>

                                        <p class="text-muted mt-3">لینک ارجاع انحصاری کاربر بر اساس شماره داخلی توجه داشته
                                            باشید این مشخصه ارجاع نباید تغییر کند.</p>

                                        <div style="direction: ltr;" class="input-group mb-3">
                                            <input
                                                style="    border-top-left-radius: 0.25rem;
    border-bottom-left-radius: 0.25rem;
    border-top-right-radius: 0;
    border-bottom-right-radius: 0;"
                                                type="text" class="form-control" aria-label="Recipient's username"
                                                aria-describedby="basic-addon2"
                                                value="{{ route('home', ['MC' => $UserInfoResult->Ext]) }}" readonly>
                                            <div class="input-group-append">
                                                <span
                                                    style="margin-left: -69px;
    border-top-right-radius: 5px;
    border-bottom-right-radius: 5px;
    border-top-left-radius: 5px;
    margin-top: 3px;
    border-bottom-left-radius: 5px;
    height: 28px;
    width: 62px;
    color: white;
    z-index: 10;
    text-align: center;"
                                                    class="input-group-text bg-success" onclick="copy_to_clipboard()"
                                                    id="basic-addon2">کپی</span>
                                            </div>
                                        </div>
                                    </div>

                                    @php
                                        $affiliate_user = App\Affiliate\affiliate_user::who_is_introduced(
                                            $UserInfoResult->UserName,
                                        );
                                        $affiliate_list = App\Affiliate\affiliate_user::get_user_list_with_affiliates(
                                            $UserInfoResult->UserName,
                                        );
                                        $cont = 0;
                                    @endphp
                                    <div class="flex-grow-1 p-4">
                                        <h5 class="m-0">لینک ارجاع کاربر</h5>
                                        <p class="text-muted mt-3">معرف این کاربر به سامانه</p>

                                        @if ($affiliate_user['result'])
                                            <span style="    font-size: 16px;" class="badge badge-success w-badge">
                                                <a
                                                    href="{{ route('UserProfile', ['RequestUser' => $affiliate_user['data']->UserName]) }}">
                                                    {{ $affiliate_user['data']->Name }}
                                                    {{ $affiliate_user['data']->Family }}</a>

                                            </span>
                                        @else
                                            <span class="badge badge-danger w-badge"> {{ $affiliate_user['msg'] }} </span>
                                        @endif
                                    </div>
                                    <div class="flex-grow-1 p-4">
                                        <h5 class="m-0">کاربران ارجاع شده</h5>
                                        <p class="text-muted mt-3">کاربرانی که توسط این کاربر به سیستم معرفی شده‌اند</p>

                                        @if ($affiliate_list['result'])
                                            @foreach ($affiliate_list['data'] as $affiliate_item)
                                                @php
                                                    $cont++;
                                                @endphp
                                                <span style="font-size: 16px;color:white !important;"
                                                    class="badge badge-primary w-badge">
                                                    <a class="text-white"
                                                        href="{{ route('UserProfile', ['RequestUser' => $affiliate_item->UserName]) }}">
                                                        {{ $affiliate_item->Name }}
                                                        {{ $affiliate_item->Family }}</a>

                                                </span>
                                            @endforeach
                                            @if ($cont == 0)
                                                <p class="text-warning">فردی توسط کاربر به سیستم معرفی نشده است!</p>
                                            @endif
                                        @endif

                                    </div>

                                </div>
                            @endif
                            <div class="tab-pane fade" id="AdditionIDs" role="tabpanel"
                                aria-labelledby="contact-top-tab">
                                @if ($UserInfoResult->UserName == Auth::id())
                                    @if (Auth::user()->MelliID == null)
                                        <form method="POST">
                                            @csrf
                                            <div class="row">
                                                <label>کد ملی</label>
                                                <input type="number" name="MelliID"
                                                    placeholder="کیبورد در حالت انگلیسی و ۱۰ کاراکتر"
                                                    class="form-control">
                                                <hr>
                                                <button type="submit" name="submit" value="MelliID"
                                                    class="btn btn-success">ثبت
                                                    کد ملی</button>
                                            </div>
                                        </form>
                                    @else
                                        <label>کد ملی</label>
                                        <input type="number" name="MelliID"
                                            placeholder="کیبورد در حالت انگلیسی و ۱۰ کاراکتر" class="form-control"
                                            disabled value="{{ Auth::user()->MelliID }}">
                                    @endif
                                @else
                                    <form method="POST">
                                        @csrf
                                        <div class="row">
                                            <label>کد ملی</label>
                                            <input type="number" name="MelliID"
                                                placeholder="کیبورد در حالت انگلیسی و ۱۰ کاراکتر"
                                                value="{{ $UserInfoResult->MelliID }}" class="form-control">
                                            <hr>
                                            <button type="submit" name="submit" value="MelliID"
                                                class="btn btn-success">ثبت
                                                کد ملی</button>
                                            @if (\App\myappenv::Lic['TavanPardakht'])
                                                <button style="margin-right: 10px" type="button"
                                                    onclick="estelam('{{ $UserInfoResult->MelliID }}')"
                                                    class="btn btn-warning">استعلام توان پرداخت</button>
                                            @endif
                                        </div>
                                        <div id="tavan">

                                        </div>
                                    </form>
                                @endif
                            </div>

                            <div class="tab-pane fade" id="Descriptions" role="tabpanel"
                                aria-labelledby="contact-top-tab">
                                <form method="POST">
                                    @csrf
                                    @if (\App\myappenv::Lic['PersonelCard'])
                                        <br>
                                        توضیحات روی کارت پرسنلی:

                                        <input name="extranote" class="form-control" style="width: 100%" type="text"
                                            value="{{ $UserInfoResult->extranote }}">
                                        <br>
                                        <button type="submit" name="submit" class="btn btn-warning"
                                            value="extranotesubmit">ثبت
                                            توضیحات کارت پرسنلی</button>
                                    @endif
                                </form>


                            </div>
                            <div class="tab-pane fade show active" id="top-profile" role="tabpanel"
                                aria-labelledby="top-profile-tab">
                                <h5 class="f-w-600">{{ __('Profile') }}</h5>
                                <form id="formtarget" method="post">
                                    @csrf

                                    <div class="table-responsive profile-table">
                                        <table class="{{ \App\myappenv::MainTableClass }}">
                                            <thead>
                                                <th>
                                                    مشخصه
                                                </th>
                                                <th>
                                                    مقدار
                                                </th>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>{{ __('Name') }}</td>
                                                    <td class="textinfo">{{ $UserInfoResult->nameofuser }} </td>
                                                    <td class="inputinfo nested"><input class="form-control"
                                                            name="Name" value="{{ $UserInfoResult->nameofuser }}" />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ __('Family') }}</td>
                                                    <td class="textinfo">{{ $UserInfoResult->Family }}</td>
                                                    <td class="inputinfo nested"><input class="form-control"
                                                            name="Family" value="{{ $UserInfoResult->Family }}" />
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td>{{ __('Email') }}</td>
                                                    <td class="textinfo">{{ $UserInfoResult->Email }}</td>
                                                    <td class="inputinfo nested"><input class="form-control"
                                                            name="Email" value="{{ $UserInfoResult->Email }}" />
                                                        <input class="nested" name="branch"
                                                            value="{{ $UserInfoResult->branch }}" />
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td>{{ __('Sex') }}</td>
                                                    <td class="textinfo">
                                                        @if ($UserInfoResult->Sex == 'm')
                                                            {{ __('Man') }}
                                                        @elseif($UserInfoResult->Sex == 'f')
                                                            {{ __('Woman') }}
                                                        @endif
                                                    </td>
                                                    <td class="inputinfo nested">
                                                        <div
                                                            class="form-group m-checkbox-inline mb-0 custom-radio-ml d-flex radio-animated">
                                                            <label class="d-block" for="edo-ani1">
                                                                <input class="radio_animated" type="radio"
                                                                    name="Sex" value="m"
                                                                    @if ($UserInfoResult->Sex == 'm') checked="" @endif>
                                                                {{ __('Man') }}
                                                            </label>
                                                            <label class="d-block" for="edo-ani2">
                                                                <input class="radio_animated" type="radio"
                                                                    name="Sex" value="f"
                                                                    @if ($UserInfoResult->Sex == 'f') checked="" @endif>
                                                                {{ __('Woman') }}
                                                            </label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ __('Mobile No') }}</td>
                                                    <td class="textinfo">{{ $UserInfoResult->MobileNo }}</td>
                                                    <td class="inputinfo nested"><input class="form-control"
                                                            name="MobileNo" value="{{ $UserInfoResult->MobileNo }}" />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>تحصیلات</td>
                                                    <td class="inputinfo nested"><select style="width: 100%;"
                                                            class="form-control" name="Degree" id="Degree">
                                                            <option value="1">زیر دیپلم</option>
                                                            <option value="2">دیپلم</option>
                                                            <option value="3">فوق دیپلم</option>
                                                            <option value="4">کارشناسی</option>
                                                            <option value="5">کارشناسی ارشد</option>
                                                            <option value="6">دکترای تخصصی</option>
                                                            <option value="7">پزشکی</option>
                                                        </select></td>
                                                    <td class="textinfo">
                                                        @switch($UserInfoResult->Degree)
                                                            @case(1)
                                                                زیر دیپلم
                                                            @break

                                                            @case(2)
                                                                دیپلم
                                                            @break

                                                            @case(3)
                                                                فوق دیپلم
                                                            @break

                                                            @case(4)
                                                                کارشناسی
                                                            @break

                                                            @case(5)
                                                                کارشناسی ارشد
                                                            @break

                                                            @case(6)
                                                                دکترای تخصصی
                                                            @break

                                                            @case(7)
                                                                پزشکی
                                                            @break

                                                            @default
                                                                نامشخص
                                                        @endswitch
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ __('Birthday date') }}</td>
                                                    <td class="textinfo">
                                                        {{ $Persian->MyPersianDate($UserInfoResult->Birthday) }}</td>
                                                    <td class="inputinfo nested"><input class="form-control"
                                                            name="Birthday"
                                                            value="{{ $Persian->MyPersianDate($UserInfoResult->Birthday) }}" />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ __('Register date') }}</td>
                                                    <td>{{ $Persian->MyPersianDate($UserInfoResult->CreateDate) }}</td>
                                                </tr>
                                                <tr>
                                                    <td>استان</td>
                                                    @php
                                                        $province = '';
                                                    @endphp
                                                    <td class="inputinfo nested">
                                                        <select name="Province" id="Province" style="width: 100%"
                                                            onchange="LoadCitys(this.value)" class="form-control">
                                                            <option value="0">{{ __('--select--') }}</option>
                                                            @foreach (App\geometric\locations::get_all_provinces() as $ProvincesTarget)
                                                                @if ($ProvincesTarget->id == $UserInfoResult->province)
                                                                    <option selected value="{{ $ProvincesTarget->id }}">
                                                                        {{ $ProvincesTarget->ProvinceName }}</option>
                                                                    @php
                                                                        $province = $ProvincesTarget->ProvinceName;
                                                                    @endphp
                                                                @else
                                                                    <option value="{{ $ProvincesTarget->id }}">
                                                                        {{ $ProvincesTarget->ProvinceName }}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td class="textinfo">{{ $province }}</td>
                                                </tr>
                                                <tr>

                                                    <td>شهر</td>
                                                    <td class="textinfo">
                                                        {{ App\geometric\locations::get_city_by_id($UserInfoResult->city) }}
                                                    </td>
                                                    <td class="inputinfo nested">
                                                        <select class="form-control" id="Shahrestan" style="width: 100%;"
                                                            name="city">
                                                        </select>
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td>{{ __('address') }}</td>
                                                    <td class="textinfo">{{ $UserInfoResult->Address }}</td>
                                                    <td class="inputinfo nested"><input class="form-control"
                                                            name="Address" value="{{ $UserInfoResult->Address }}" />
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td>کدپستی</td>

                                                    <td class="textinfo">{{ $UserInfoResult->Address2 }}</td>
                                                    <td class="inputinfo nested"><input class="form-control"
                                                            name="Address2" value="{{ $UserInfoResult->Address2 }}" />
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td>{{ __('Phone1') }}</td>
                                                    <td class="textinfo">{{ $UserInfoResult->Phone1 }}</td>
                                                    <td class="inputinfo nested"><input class="form-control"
                                                            name="Phone1" value="{{ $UserInfoResult->Phone1 }}" />
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td>{{ __('Phone2') }}</td>
                                                    <td class="textinfo">{{ $UserInfoResult->Phone2 }}</td>
                                                    <td class="inputinfo nested"><input class="form-control"
                                                            name="Phone2" value="{{ $UserInfoResult->Phone2 }}" />
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td>نام پدر</td>
                                                    <td class="textinfo">{{ $UserInfoResult->fathername }}</td>
                                                    <td class="inputinfo nested"><input class="form-control"
                                                            name="fathername"
                                                            value="{{ $UserInfoResult->fathername }}" />
                                                    </td>

                                                </tr>
                                                @if (!App\myappenv::Lic['affiliate'])
                                                    <tr>
                                                        <td>لینک بازاریابی

                                                        </td>
                                                        <td style="display:flex"><input id="marketing_code"
                                                                type="text" class="form-control"
                                                                value="{{ route('home', ['MC' => $UserInfoResult->Ext]) }}">
                                                            <button type="button" onclick="myFunction()"
                                                                class="btn btn-success">کپی</button>
                                                        </td>

                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                        <button type="button" id="converttoedite"
                                            class="btn btn-primary float-right">{{ __('Edit') }}</button>
                                        <button type="submit" name="submit" value="updatebaseinfo" id="submitedit"
                                            class="btn btn-success float-right nested">{{ __('Submit') }}</button>

                                        <button type="button" id="Aboartedite"
                                            class="btn btn-danger float-right nested">{{ __('aboart') }}</button>


                                    </div>
                                </form>
                            </div>
                            @if (\App\myappenv::Lic['hiring'] && $UserInfoResult->Role == \App\myappenv::role_worker)
                            @else
                                <div class="tab-pane fade" id="credite-card" role="tabpanel"
                                    aria-labelledby="contact-top-tab">
                                    <h5 class="f-w-600">{{ __('Account number') }}</h5>
                                    <form id="formtarget" method="post">
                                        @csrf
                                        <div class="card-body order-datatable">
                                            <table class="{{ \App\myappenv::MainTableClass }}" id="basic-1">
                                                <thead>
                                                    <tr>
                                                        <th>{{ __('No.') }}</th>
                                                        <th>{{ __('Card number') }}</th>
                                                        <th>{{ __('Account number') }}</th>
                                                        <th>{{ __('Issued bank') }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $Rowno = 1;
                                                    @endphp
                                                    @foreach ($BankAccounts as $BankAccount)
                                                        <tr>
                                                            <td>{{ $Rowno++ }}</td>
                                                            <td>{{ $BankAccount->CardNo }}</td>
                                                            <td>{{ $BankAccount->Account }}</td>
                                                            <td>{{ $BankAccount->‌BankName }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            <div class="card-header text-right bg-transparent">
                                                <button id="addobject" type="button" data-toggle="modal"
                                                    data-target=".bd-example-modal-lg2"
                                                    class="btn btn-primary btn-md m-1">اضافه کردن
                                                    شماره شبا
                                                </button>
                                            </div>
                                            <!-- begin::modal -->
                                            <div class="ul-card-list__modal">
                                                <div class="modal fade bd-example-modal-lg2" tabindex="-1"
                                                    role="dialog" style="margin-right: 20%"
                                                    aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                افزودن شماره شبا
                                                            </div>
                                                            <div class="modal-body">
                                                                <form method="post">
                                                                    @csrf
                                                                    <label for="">شماره شبا (IR)</label>
                                                                    <input type="number" name="shaba"
                                                                        placeholder="شماره شبا بدون IR" required
                                                                        class="form-control" name="shabanumber">
                                                                    <label for="">شماره کارت</label>
                                                                    <input type="number" name="cardnumber"
                                                                        class="form-control" name="cardnumber">
                                                                    <label for="">بانک صادر کننده</label>
                                                                    <input type="text" name="bankname" required
                                                                        class="form-control" name="bankname">
                                                                    <button type="submit" name="submit"
                                                                        value="Updatecardnumber" class="btn btn-success">
                                                                        ثبت شماره شبا</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            @endif

                            @if (App\myappenv::Lic['woocommerce'])
                                <div class="tab-pane fade" id="woocommerce" role="tabpanel">
                                    <h5 class="f-w-600">سوابق خرید</h5>
                                    <table class="{{ \App\myappenv::MainTableClass }}" id="basic-2">
                                        <thead>
                                            <tr>
                                                <th>{{ __('No.') }}</th>
                                                <th>شماره سفارش</th>
                                                <th>مبلغ سفارش</th>
                                                <th>محل تحویل</th>
                                                <th>اقلام سفارش</th>
                                                <th>تاریخ سفارش</th>
                                                <th>عملیات</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $Rowno = 1;
                                            @endphp
                                            @foreach (App\Http\Controllers\woocommerce\buy::get_user_buy_history($UserInfoResult->UserName) as $Order_item)
                                                <tr>
                                                    <td>{{ $Rowno++ }}</td>
                                                    <td>{{ $Order_item->id }}</td>

                                                    <td>
                                                        {{ number_format($Order_item->total_sales) }}
                                                    </td>
                                                    <td>{{ $Order_item->SendLocation }}</td>
                                                    <td>
                                                        {{ $Order_item->num_items_sold }}
                                                    </td>
                                                    <td>
                                                        {{ $Persian->MyPersianDate($Order_item->created_at, true) }}
                                                    </td>
                                                    <td>
                                                        <a target="_blank"
                                                            href="{{ route('EditOrder', ['OrderID' => $Order_item->id]) }}">نمایش</a>
                                                    </td>
                                                </tr>
                                            @endforeach


                                        </tbody>

                                    </table>
                                    <h5 class="f-w-600">آدرس ارسال</h5>
                                    <table class="{{ \App\myappenv::MainTableClass }}" id="basic-2">
                                        <thead>
                                            <tr>
                                                <th>{{ __('No.') }}</th>
                                                <th>کد محل </th>
                                                <th>نام محل </th>
                                                <th> استان </th>
                                                <th> شهر </th>
                                                <th> آدرس </th>
                                                <th> کد پستی </th>


                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $Rowno = 1;
                                            @endphp
                                            @foreach (App\Http\Controllers\woocommerce\buy::get_user_buy_address($UserInfoResult->UserName) as $address_item)
                                                <tr>
                                                    <td>{{ $Rowno++ }}</td>
                                                    <td>{{ $address_item->id }}</td>
                                                    <td>{{ $address_item->name }}</td>
                                                    <td>{{ $address_item->Province }}</td>
                                                    <td>{{ $address_item->City }}</td>
                                                    <td>{{ $address_item->OthersAddress }}</td>
                                                    <td>{{ $address_item->PostalCode }}</td>
                                                </tr>
                                            @endforeach


                                        </tbody>

                                    </table>

                                </div>
                            @endif
                            @if (App\myappenv::Lic['hiring'])
                                <div class="tab-pane fade" id="can_do" role="tabpanel">
                                    <h5 class="f-w-600">مهارت‌ها</h5>
                                    <form id="formtarget" method="post">
                                        @csrf
                                        <div class="form-group col-md-12">
                                            <div class="form-group col-md-12">
                                                <label class="ul-form__label">حرفه‌ای که شما به آن شناخته می‌شوید - زیرنویس
                                                    نام شما </label>
                                                <input class="form-control col-xl-12 col-md-12" name="extranote"
                                                    value="{{ $UserInfoResult->extranote }}" type="text" required>
                                                <small class="ul-form__text form-text ">
                                                    توضیح کوتاه حرفه شما - مثال: پرستار - پزشک عمومی
                                                </small>
                                            </div>

                                            <div class="form-group col-md-12">
                                                <label class="ul-form__label">توانائی و تخصص</label>
                                                <select style="width: 100%;" id="SelectTags" name="SelectTags[]"
                                                    class="form-control" multiple="multiple">
                                                    @foreach ($worker_hires->get_worker_skills(Auth::id()) as $skill_src)
                                                        <option @if ($skill_src->UserName != null) selected @endif>
                                                            {{ $skill_src->Name }}
                                                        </option>
                                                    @endforeach
                                                    </option>
                                                </select>

                                            </div>


                                        </div>
                                        <button type="submit" name="submit" value="add_extra_info" id="submitedit"
                                            class="btn btn-success float-right">ذخیره </button>
                                    </form>
                                </div>
                            @endif
                            @if ($UserInfoResult->Role == \App\myappenv::role_worker || Auth::user()->Role > \App\myappenv::role_admin)
                                @php
                                    $doc_src = $user_class->get_role_documentation($UserInfoResult->Role);
                                @endphp
                                @if ($doc_src != null)
                                    <div class="tab-pane fade" id="uploader" role="tabpanel">
                                        <form method="post" enctype="multipart/form-data" id="button-select-upload">
                                            @csrf
                                            <div class="row">
                                                @foreach ($doc_src as $doc_item)
                                                    <div class="col-xl-4">
                                                        <h5 class="f-w-600"> {{ $doc_item['name'] }} </h5>
                                                        <div>
                                                            <img style="width: 300px;border-radius: 0px !important;"
                                                                id="useravatar_{{ $doc_item['id'] }}"
                                                                @php
$target_id = $doc_item['id'] -3 ; @endphp
                                                                @isset($extradata->docs[$target_id])
                                                                            @if (isset($extradata->docs) && $extradata->docs[$target_id]->doc_img != null) src="{{ route('show', ['username' => $UserInfoResult->UserName, 'file_name' => $extradata->docs[$target_id]->doc_img]) }}"
                                                            alt="{{ $extradata->docs[$target_id]->doc_img }}"
        @endisset
                                                            @else src="{{ $doc_item['default_img'] }}"
                                                                alt="{{ $doc_item['default_img'] }}" @endif
                                                            class="img-fluid img-90 rounded-circle blur-up lazyloaded dropzone dropzone-area dz-clickable">
                                                            <div class="fallback">
                                                                <input style="display: none"
                                                                    name="avatar[{{ $doc_item['id'] }}]"
                                                                    class="imguploadinput"
                                                                    id="imguploadinput_{{ $doc_item['id'] }}"
                                                                    type="file" />
                                                            </div>
                                                            <button id="changebutton" type="button"
                                                                class="btn btn-raised-danger"
                                                                onclick="imageupdloader('_{{ $doc_item['id'] }}')"
                                                                style="margin-top: -20px">
                                                                {{ __('change photo') }}
                                                                {{ $doc_item['name'] }}</button>
                                                            <button id="canclebutton_{{ $doc_item['id'] }}"
                                                                type="submit" class="btn btn-raised-warning nested "
                                                                style="margin-top: -20px;">
                                                                {{ __('discard') }}</button>
                                                        </div>
                                                    </div>
                                                @endforeach
                                                <button type="submit" name="submit" value="add_user_documents"
                                                    id="submitedit" class="btn btn-success float-right">ذخیره </button>
                                            </div>

                                        </form>

                                    </div>
                                @endif
                            @endif
                            <div class="tab-pane fade" id="setting-tab" role="tabpanel">

                                <h5 class="f-w-600">{{ __('setting') }}</h5>
                                <form id="formtarget" method="post">
                                    @csrf
                                    <div style="text-align: right" class="card-body order-datatable">
                                        <label>{{ __('Change password') }} </label>
                                        @section('ModalTitle1')
                                            {{ __('Change password') }}
                                        @endsection
                                        @section('ModalBody1')
                                            <label>{{ __('Change password') }} </label>
                                            <input name="Password" class="form-control" />
                                        @endsection
                                        @section('Modalfooter1')
                                            <button type="submit" name="submit" value="changepassword"
                                                class="btn btn-primary">
                                                {{ __('Save new password') }}
                                            </button>
                                        @endsection
                                        @include('Layouts.Modal.VerticalCenter', [
                                            'ModalID' => 'ChangePassword',
                                            'formid' => '1',
                                        ])
                                        <button type="button" class="btn btn-primary" data-toggle="modal"
                                            data-target="#ChangePassword">
                                            {{ __('Change password') }}
                                        </button>

                                    </div>
                                    @if (!$SelfConfig)
                                        <div style="text-align: right" class="card-body order-datatable">
                                            <label>{{ __('Change state') }} </label>
                                            @section('ModalTitle2')
                                                {{ __('Change state') }}
                                            @endsection
                                            @section('ModalBody2')
                                                <label>{{ __('Change user state') }} </label>
                                                <select name="UserStatus" class="form-control">
                                                    <option value="0">{{ __('--select--') }}</option>
                                                    @foreach ($UserStatusInfo as $UserStatusInfoOption)
                                                        @if ($UserStatusInfoOption->Status == $UserStatus)
                                                            <option value="{{ $UserStatusInfoOption->Status }}" selected>
                                                                {{ $UserStatusInfoOption->Name }}</option>
                                                        @else
                                                            <option value="{{ $UserStatusInfoOption->Status }}">
                                                                {{ $UserStatusInfoOption->Name }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            @endsection
                                            @section('Modalfooter2')
                                                <button type="submit" name="submit" value="changestatus"
                                                    class="btn btn-primary">
                                                    {{ __('Change state') }}
                                                </button>
                                            @endsection
                                            @include('Layouts.Modal.VerticalCenter', [
                                                'ModalID' => 'ChangState',
                                                'formid' => '2',
                                            ])
                                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                                data-target="#ChangState">
                                                {{ __('Change user state') }}
                                            </button>


                                        </div>
                                        <div style="text-align: right" class="card-body order-datatable">
                                            <label>تغییر نقش کاربر</label>
                                            @section('ModalTitle3')
                                                تغییر نقش کاربری
                                            @endsection
                                            @section('ModalBody3')
                                                <label>تغییر نقش کاربری </label>
                                                <select name="UserRole" class="form-control">
                                                    <option value="0">{{ __('--select--') }}</option>
                                                    @foreach ($UserRoles as $UserRole)
                                                        <option value="{{ $UserRole->Role }}">
                                                            {{ $UserRole->RoleName }}</option>
                                                    @endforeach
                                                </select>
                                            @endsection
                                            @section('Modalfooter3')
                                                <button type="submit" name="submit" value="changeRole"
                                                    class="btn btn-primary">
                                                    تغییر نقش کاربر
                                                </button>
                                            @endsection
                                            @include('Layouts.Modal.VerticalCenter', [
                                                'ModalID' => 'ChangRole',
                                                'formid' => '3',
                                            ])
                                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                                data-target="#ChangRole">
                                                تغییر نقش کاربر
                                            </button>
                                        </div>
                                        @if (Auth::user()->Role >= \App\myappenv::role_Accounting)
                                            <div style="text-align: right" class="card-body order-datatable">
                                                <label>مجوز خرید اعتباری</label>
                                                @section('ModalTitle4')
                                                    مجوز خرید اعتباری
                                                @endsection
                                                @section('ModalBody4')
                                                    <label> مجوز خرید اعتباری برای کاربر تا سقف مبلغ</label>
                                                    <input type="number" id="amount" class="form-control" value="0"
                                                        name="buy_credit">
                                                    <div id="amountext"></div>
                                                @endsection
                                                @section('Modalfooter4')
                                                    <button type="submit" name="submit" value="max_credit"
                                                        class="btn btn-warning">
                                                        مجوز خرید اعتباری
                                                    </button>
                                                @endsection
                                                @include('Layouts.Modal.VerticalCenter', [
                                                    'ModalID' => 'credit_buy',
                                                    'formid' => '4',
                                                ])
                                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                                    data-target="#credit_buy">
                                                    مجوز خرید اعتباری
                                                </button>
                                                @isset($extradata->max_credit)
                                                    <p>حد اکثر اعتبار {{ number_format($extradata->max_credit) }} ریال</p>
                                                @endisset
                                            </div>
                                        @endif
                                    @endif
                            </div>
                            <div class="tab-pane fade" id="user-index" role="tabpanel"
                                aria-labelledby="contact-top-tab">
                                <h5 class="f-w-600">{{ __('user index') }}</h5>
                                <form id="formtarget" method="post">
                                    @csrf
                                    <button type="button" class="btn btn-link"
                                        onclick="showindexlist()">{{ __('show index list') }}</button>
                                    <button type="button" class="btn btn-link"
                                        onclick="showuserindexlist()">{{ __('show user index list') }}</button>
                                    <div class="card-body order-datatable">
                                        <div id="userindex">
                                            <table class="{{ \App\myappenv::MainTableClass }}" id="basic-2">
                                                <thead>
                                                    <tr>
                                                        <th>{{ __('No.') }}</th>
                                                        <th>{{ __('Added index') }}</th>
                                                        <th>نوع شاخص کاربری</th>
                                                        <th>
                                                            <button class="btn btn-danger" type="submit" name="submit"
                                                                value="deleteindex">{{ __('delete') }}</button>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $Rowno = 1;
                                                    @endphp

                                                    @foreach ($UserSkills as $UserSkill)
                                                        <tr>
                                                            <td>{{ $Rowno++ }}</td>
                                                            <td>{{ $UserSkill->Description }}</td>

                                                            <td>
                                                                @if ($UserSkill->Weight == null)
                                                                    شاخص عادی
                                                                @else
                                                                    شاخص سیستم = {{ $UserSkill->Weight }}
                                                                @endif
                                                            </td>



                                                            <td class="jsgrid-cell jsgrid-align-center"
                                                                style="text-align: center">
                                                                <input type="checkbox" name="deleteindexitems[]"
                                                                    value="{{ $UserSkill->SkilID }}" />
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>

                                            </table>
                                        </div>
                                        <div id="listindex" class="nested" style="text-align: right">
                                            <div>
                                                {!! $IndexTree !!}
                                            </div>
                                            <div style="text-align: left">
                                                <button type="submit" name="submit" value="addindexes"
                                                    class="btn btn-primary">{{ __('update') }}</button>
                                            </div>


                                        </div>


                                    </div>
                                </form>
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
        window.main_username = $('#UserName').val();
        window.page_username = $('#UserName_page').val();
        window.targetpage = 'Profile';
        window.allowtoacall = true;
    </script>
    @if (\App\myappenv::Lic['hiring'] == false && $UserInfoResult->Role == \App\myappenv::role_worker)
        <script>
            if (window.allowtoacall) {
                $(document).ready(function() {
                    window.allowtoacall = false;
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.post('/ajax', {
                            AjaxType: 'call_parstarbank',
                            username: '{{ $UserInfoResult->UserName }}'
                        },

                        function(data, status) {
                            if (data['result']) {
                                $('#parastarbank_holder').html(data['html'])
                            } else {
                                alert(data['msg']);
                            }
                        });


                });
            }
        </script>
    @endif

    <script>
        function imageupdloader(id) {
            $('#imguploadinput' + id).trigger('click');
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

        function readURL(input, id) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                //alert(e.target.result);
                reader.onload = function(e) {
                    $('#useravatar' + id).attr('src', e.target.result);
                    $('#savebutton' + id).removeClass('nested');
                    $('#changebutton' + id).addClass('nested');
                    $('#canclebutton' + id).removeClass('nested');

                }

                reader.readAsDataURL(input.files[0]); // convert to base64 string
            }
        }

        $(".imguploadinput").change(function() {
            target_id = $(this).attr('id');
            readURL(this, target_id.slice(-2));

        });
    </script>
    <script>
        var toggler = document.getElementsByClassName("box");
        var i;

        for (i = 0; i < toggler.length; i++) {
            toggler[i].addEventListener("click", function() {
                if ($(this.parentElement.querySelector("ul")).hasClass('nested')) {
                    $(this.parentElement.querySelector("ul")).removeClass('nested');
                    this.parentElement.querySelector("ul").classList.toggle("active");
                } else {
                    $(this.parentElement.querySelector("ul")).removeClass('active');
                    this.parentElement.querySelector("ul").classList.toggle("nested");
                }


                this.classList.toggle("check-box");
                this.classList.toggle("active");
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
        function myFunction() {
            // Get the text field
            var copyText = document.getElementById("marketing_code");

            // Select the text field
            copyText.select();
            copyText.setSelectionRange(0, 99999); // For mobile devices

            // Copy the text inside the text field
            navigator.clipboard.writeText(copyText.value);

            // Alert the copied text
            alert("لینک بازاریابی در حافظه کپی شد");
        }
    </script>


    <script>
        $(function() {
            $('#converttoedite').click(function() {
                $(".textinfo").addClass('nested');
                $("#converttoedite").addClass('nested');
                $(".inputinfo").removeClass('nested');
                $("#Aboartedite").removeClass('nested');
                $("#submitedit").removeClass('nested');
                LoadCitys(<?php echo $UserInfoResult->province; ?>);
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
    <script>
        function LoadCitys($ProvinceCode) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('<?php echo e(route('ajax')); ?>', {
                    AjaxType: 'GetCitysOfProvinces',
                    ProvinceCode: $ProvinceCode,
                },

                function(data, status) {
                    $("#Shahrestan").empty();
                    $("#Shahrestan").append(data);
                });

        }
    </script>
    <script>
        onload = function() {
            var e = document.getElementById('amount');
            e.oninput = myHandler;
            e.onpropertychange = e.oninput; // for IE8
            function myHandler() {
                document.getElementById('amountext').innerHTML = e.value.toPersianLetter() + ' تومان ';
            }
            var e2 = document.getElementById('amountDisc');
            e2.oninput = myHandler2;
            e2.onpropertychange = e2.oninput; // for IE8
            function myHandler2() {
                document.getElementById('amountDiscText').innerHTML = e2.value.toPersianLetter() + ' تومان ';
            }
        };
    </script>
@endsection
@section('bottom-js')
    @if (\App\myappenv::Lic['hiring'])
        <script>
            $('select').select2({
                createTag: function(params) {
                    // Don't offset to create a tag if there is no @ symbol
                    if (params.term.indexOf('@') === -1) {
                        // Return null to disable tag creation
                        return null;
                    }

                    return {

                        id: params.term,
                        text: params.term
                    }
                }
            });
            $("#SelectTags").select2({
                tags: true
            });
        </script>
    @endif
@endsection

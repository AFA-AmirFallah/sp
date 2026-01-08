@php
    $Persian = new App\Functions\persian();
@endphp
<div class="row">
    <div class="col-12">
        <div class="px-3 px-res-0">
            <div class="section-title text-sm-title mb-1 no-after-dt-sl mb-2 px-res-1">
                <h2>ویرایش اطلاعات شخصی</h2>
            </div>
            <div class="form-ui additional-info dt-sl dt-sn pt-4">
                <form method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="form-row-title">
                                <h3>نام <span class="reqired-field">*</span></h3>
                            </div>
                            <div class="form-row">
                                <input type="text" name="name" required class="persian_limit input-ui pr-2"
                                    placeholder="نام خود را وارد نمایید"
                                    value="@if ($profiled_user) {{ $usersrc->Name }} @endif">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-row-title">
                                <h3> نام خانوادگی<span class="reqired-field">*</span> </h3>
                            </div>
                            <div class="form-row">
                                <input type="text" name="family" required class="persian_limit input-ui pr-2"
                                    placeholder="نام خانوادگی خود را وارد نمایید"
                                    value="@if ($profiled_user) {{ $usersrc->Family }} @endif">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-row-title">
                                <h3>کد ملی</h3>
                            </div>
                            <div class="form-row">
                                <input type="text" name="id_code" class="input-ui pl-2 text-left dir-ltr"
                                    placeholder="-"
                                    value="@if ($profiled_user) {{ $usersrc->MelliID }} @endif">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div style="display: flex" class="form-row-title">
                                <h3>شماره موبایل</h3> <span style="margin-right: 3px" class="text-danger">قابل
                                    ویرایش نیست</span>
                            </div>
                            <div class="form-row">
                                <input type="text" class="input-ui pl-2 text-left dir-ltr"
                                    placeholder="شماره موبایل خود را وارد نمایید" disabled
                                    value="{{ $usersrc->MobileNo }}">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-row-title">
                                <h3>آدرس ایمیل</h3>
                            </div>
                            <div class="form-row">
                                <input type="email" name="email" class="input-ui pl-2 text-left dir-ltr"
                                    placeholder="آدرس ایمیل خود را وارد نمایید"
                                    value="@if ($profiled_user) {{ $usersrc->Email }} @endif">
                            </div>
                        </div>
                        @php
                            $Peraian_arr = $Persian->MyPersianArray($usersrc->Birthday);
                        @endphp
                        <div class="col-md-6 mb-3">
                            <div class="form-row-title">
                                <h3> تاریخ تولد - روز/ ماه / سال</h3>
                            </div>
                            <div style="display: inline-flex">
                                <div>
                                    <select class="form-control" name="day" id="">
                                        <option value="0" selected> </option>
                                        @for ($i = 1; $i < 32; $i++)
                                            @if ($i == $Peraian_arr[2])
                                                <option selected value="{{ $i }}"> {{ $i }}
                                                </option>
                                            @else
                                                <option value="{{ $i }}"> {{ $i }}</option>
                                            @endif
                                        @endfor
                                    </select>
                                </div>
                                <div>
                                    <select class="form-control" name="month" id="">
                                        <option value="0" selected> </option>
                                        <option value="1" @if ($Peraian_arr[1] == 1) selected @endif>
                                            فروردین</option>
                                        <option value="2" @if ($Peraian_arr[1] == 2) selected @endif>
                                            اردیبهشت</option>
                                        <option value="3" @if ($Peraian_arr[1] == 3) selected @endif>خرداد
                                        </option>
                                        <option value="4" @if ($Peraian_arr[1] == 4) selected @endif> تیر
                                        </option>
                                        <option value="5" @if ($Peraian_arr[1] == 5) selected @endif> مرداد
                                        </option>
                                        <option value="6" @if ($Peraian_arr[1] == 6) selected @endif>
                                            شهریور</option>
                                        <option value="7" @if ($Peraian_arr[1] == 7) selected @endif> مهر
                                        </option>
                                        <option value="8" @if ($Peraian_arr[1] == 8) selected @endif> آبان
                                        </option>
                                        <option value="9" @if ($Peraian_arr[1] == 9) selected @endif> آذر
                                        </option>
                                        <option value="10" @if ($Peraian_arr[1] == 10) selected @endif> دی
                                        </option>
                                        <option value="11" @if ($Peraian_arr[1] == 11) selected @endif> بهمن
                                        </option>
                                        <option value="12" @if ($Peraian_arr[1] == 12) selected @endif>
                                            اسفند</option>
                                    </select>
                                </div>
                                <div>
                                    <select class="form-control" name="year" id="">
                                        <option value="0" selected> </option>
                                        @for ($i = 1387; $i > 1320; $i--)
                                            @if ($i == $Peraian_arr[0])
                                                <option selected value="{{ $i }}"> {{ $i }}
                                                </option>
                                            @else
                                                <option value="{{ $i }}"> {{ $i }}</option>
                                            @endif
                                        @endfor

                                    </select>
                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="dt-sl">
                        <div class="form-row mt-3 justify-content-end">
                            <button type="submit" name="submit" value="update_profile"
                                class="btn-primary-cm btn-with-icon ml-2">
                                <i class="mdi mdi-account-circle-outline"></i>
                                ثبت اطلاعات کاربری
                            </button>
                            <button class="btn-primary-cm bg-secondary">انصراف</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

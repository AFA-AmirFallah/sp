@extends('Theme2.Layouts.MainLayout')
@section('PageCSS')
    <link rel="stylesheet" href="/T1assets/vendor/css/pages/page-profile.css">
@endsection

@section('Content')
<div class="bs-toast toast fade show" role="alert" aria-live="assertive" aria-atomic="true">

  </div>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 breadcrumb-wrapper mb-4">
            <span class="text-muted fw-light">تنظیمات حساب /</span> امنیت
        </h4>

        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header gradient-purple-indigo 0-hidden pb-80">ثبت کلید API</h5>
                    <div class="row">
                        <div class="col-md-5 order-md-0 order-1">
                            <div class="card-body pt-md-0">
                                <div class="row">
                                    <div class="mb-3 col-12">
                                        <label for="apiAccess" class="form-label"> به کدام صرافی میخواهید ارتباط API
                                            داشته باشید!</label>
                                        <select id="apiAccess" class="select2 form-select">
                                            <option value="">انتخاب صرافی</option>
                                            <option value="wallex">صرافی wallex</option>
                                            <option value="kucoin">صرافی Kucoin</option>
                                        </select>
                                    </div>
                                    <form class="nested exchangeforms" id="wallexform" method="post">
                                        @csrf
                                        <div class="mb-3 col-12">
                                            <label for="token" class="form-label">کد کلید API را وارد کنید</label>
                                            <input type="text" class="form-control" name="token"
                                                placeholder="توکن ولکس">
                                        </div>
                                        <div class="col-12">
                                            <button type="submit" name="submit" value="saveToken"
                                                class="btn btn-primary me-2 d-grid w-100">ثبت
                                                دسترسی</button>
                                        </div>
                                    </form>
                                    <form class="nested exchangeforms" id="kucoinform" method="post">
                                        @csrf
                                        <div class="mb-3 col-12">
                                            <label for="token" class="form-label">کد کلید API را وارد کنید</label>
                                            <input type="text" class="form-control" name="key" placeholder="key">
                                        </div>
                                        <div class="mb-3 col-12">
                                            <label for="token" class="form-label">کد محرمانه API را وارد کنید</label>
                                            <input type="text" class="form-control" name="secret" placeholder="secret">
                                        </div>
                                        <div class="mb-3 col-12">
                                            <label for="token" class="form-label">پسورد لاگین را وارد کنید</label>
                                            <input type="text" class="form-control" name="passphrase"
                                                placeholder="passphrase">
                                        </div>
                                        <div class="col-12">
                                            <button type="submit" name="submit" value="kocoin"
                                                class="btn btn-primary me-2 d-grid w-100">ثبت
                                                دسترسی</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7 order-md-1 order-0">
                            <div class="text-center mt-md-n5 pt-md-2 mx-3 mx-md-0">
                                <img src="/T1assets/img/illustrations/boy-working-light.png" class="img-fluid"
                                    alt="Api Key Image" width="300"
                                    data-app-light-img="illustrations/boy-working-light.png"
                                    data-app-dark-img="illustrations/boy-working-dark.png">
                            </div>
                        </div>
                    </div>
                </div>
                <!--/ Create an API key -->

                <!-- API Key List & Access -->
                <div class="card mb-4">
                    <h5 class="card-header gradient-purple-indigo 0-hidden pb-80">لیست کلید API و دسترسی</h5>
                    <div class="card-body">
                        <p>
                            یک کلید API یک رشته رمزگذاری شده ساده است که یک برنامه را بدون هیچ گونه اصلی شناسایی می کند.
                            آنها برای دسترسی به داده های عمومی به صورت ناشناس مفید هستند و برای مرتبط کردن درخواست های API
                            با پروژه شما برای سهمیه و صورتحساب استفاده می شوند.
                        </p>
                        <form method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    @php
                                        $keys = false;
                                        $key ='';
                                        if (Auth::user()->extradata != null) {
                                            $extradata = json_decode(Auth::user()->extradata);
                                            $key = $extradata->KC_key ?? '';
                                            $secret = $extradata->KC_secret ?? '';
                                            $passphrase = $extradata->KC_passphrase ?? '';
                                            $kucoin = true;
                                            $keys = true;
                                        } else {
                                            $kucoin = false;
                                        }
                                        if ($key == '') {
                                            $kucoin = false;
                                            $keys = false;
                                        }
                                        
                                    @endphp
                                    @if ($kucoin)
                                        <div class="bg-lighter rounded p-3 mb-3 position-relative">
                                            <div class="dropdown api-key-actions">
                                                <a class="btn dropdown-toggle text-muted hide-arrow p-0"
                                                    data-bs-toggle="dropdown"><i
                                                        class="bx bx-dots-vertical-rounded"></i></a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a href="javascript:;" class="dropdown-item"><i
                                                            class="bx bx-pencil me-2"></i>ویرایش</a>
                                                    <a href="javascript:;" class="dropdown-item"><i
                                                            class="bx bx-trash me-2"></i>حذف</a>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center flex-wrap mb-3">
                                                <h4 class="mb-0 me-3">کلید سرور kucoin</h4>
                                                <span class="badge bg-label-primary">دسترسی کامل</span>
                                            </div>
                                            <div class="d-flex align-items-center mb-2 lh-1-85">
                                                <span class="fw-semibold me-3">{{ $key }} </span>
                                                <button type="submit" name="submit" value="Checkkucoin"
                                                class="btn btn-sm btn-success me-1 d-grid ">بررسی
                                                دسترسی</button>
                                                <button type="submit" name="submit" value="removekucoin"
                                                    class="btn btn-sm btn-danger me-1 d-grid ">حذف
                                                    دسترسی</button>
                                            </div>
                                            <span class="lh-1-85">دسترسی توسط تریدر آلمان</span>
                                        </div>
                                    @endif

                                    @if (Auth::user()->remember_token != null)
                                        @php
                                            $keys = true;
                                        @endphp
                                        <div class="bg-lighter rounded p-3 mb-3 position-relative">
                                            <div class="dropdown api-key-actions">
                                                <a class="btn dropdown-toggle text-muted hide-arrow p-0"
                                                    data-bs-toggle="dropdown"><i
                                                        class="bx bx-dots-vertical-rounded"></i></a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a href="javascript:;" class="dropdown-item"><i
                                                            class="bx bx-pencil me-2"></i>ویرایش</a>
                                                    <a href="javascript:;" class="dropdown-item"><i
                                                            class="bx bx-trash me-2"></i>حذف</a>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center flex-wrap mb-3">
                                                <h4 class="mb-0 me-3">کلید سرور wallex</h4>
                                                <span class="badge bg-label-primary">دسترسی کامل</span>
                                            </div>
                                            <div class="d-flex align-items-center mb-2 lh-1-85">
                                                <span class="fw-semibold me-3">{{ Auth::user()->remember_token }} </span>
                                                <button type="submit" name="submit" value="Checkwallex"
                                                    class="btn btn-sm btn-success me-1 d-grid ">بررسی
                                                    دسترسی</button>
                                                <button type="submit" name="submit" value="removewallex"
                                                    class="btn btn-sm btn-danger me-1 d-grid ">حذف
                                                    دسترسی</button>
                                            </div>
                                            <span class="lh-1-85">دسترسی توسط تریدر ایران</span>
                                        </div>
                                    @endif
                                    @if (!$keys)
                                        <div class="bg-lighter rounded p-3 position-relative mb-3">
                                            <div class="dropdown api-key-actions">
                                                <a class="btn dropdown-toggle text-muted hide-arrow p-0"
                                                    data-bs-toggle="dropdown"><i
                                                        class="bx bx-dots-vertical-rounded"></i></a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a href="javascript:;" class="dropdown-item"><i
                                                            class="bx bx-pencil me-2"></i>ویرایش</a>
                                                    <a href="javascript:;" class="dropdown-item"><i
                                                            class="bx bx-trash me-2"></i>حذف</a>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center flex-wrap mb-3">
                                                <h4 class="mb-0 me-3">کلید سرور </h4>
                                                <span class="badge bg-label-danger"> تعریف نشده</span>
                                            </div>

                                        </div>
                                    @endif

                                </div>
                            </div>

                        </form>
                    </div>
                </div>
                <!--/ API Key List & Access -->


            </div>
        </div>
    </div>
@endsection
@section('EndScripts')
    <script>
        $('select').on('change', function(e) {
            var optionSelected = $("option:selected", this);
            var valueSelected = this.value;
            $('.exchangeforms').addClass('nested');
            $('#' + valueSelected + 'form').removeClass('nested');
        });
    </script>
@endsection

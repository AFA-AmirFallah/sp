@php
    $Persian = new App\Functions\persian();
@endphp
@extends('Layouts.MainPage')
@section('page-header-left')
@endsection
@section('MainCountent')
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-lg-6">
                    <div class="page-header-left">
                        <h3>{{ __('setting') }}
                            <small>تنظیمات عمومی</small>
                        </h3>
                    </div>
                </div>
                <div class="col-lg-6">
                    <ol class="breadcrumb pull-right">
                        @include('Layouts.AddressBar')
                    </ol>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-lg-12 mb-3">
                <div class="card">
                    <div class="card-header bg-info">
                        <h3 class="text-white card-title"><i style="font-size: 30px" class="i-Arrow-Around" ></i> ریست کش پلتفرم</h3>
                    </div>
                    <form method="post">
                        @csrf
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <p class="text-large radio radio-outline-secondary">
                                        ریست کردن کش پلتفرم باعث می شود که پلتفرم مجددا اطلاعات جدید را از سیستم خوانده و در
                                        کش خود ذخیره نماید
                                    </p>

                                    <p class="text-danger text-large" >با استفاده از این قابلیت ممکن است سرعت پلتفرم اندکی کاهش
                                        یابد</p>

                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent">
                            <div class="mc-footer">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <button type="submit" name="submit" value="flush"
                                            class="btn  btn-primary m-1">ریست کردن کش پلتفرم</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- end::form -->
                </div>

            </div>
            

            <div class="col-lg-6 mb-3">
                <div class="card">
                    <div class="card-header bg-transparent">
                        <h3 class="card-title">نام مرکز</h3>
                    </div>

                    <form method="post">
                        @csrf
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label class="radio radio-outline-secondary">
                                       نام هدر پلتفرم
                                    </label>
                                    <input type="text" class="form-control" name="DefultPageTitr" value="{{$branch_app_env['DefultPageTitr'] ?? ''}}">
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent">
                            <div class="mc-footer">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <button type="submit" name="submit" value="DefultPageTitr"
                                            class="btn  btn-primary m-1">{{ __('Submit') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
            <div class="col-lg-6 mb-3">
                <div class="card">
                    <div class="card-header bg-transparent">
                        <h3 class="card-title">شماره تماس مرکز</h3>
                    </div>

                    <form method="post">
                        @csrf
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label class="radio radio-outline-secondary">
                                        شماره تلفن مرکز
                                    </label>
                                    <input type="text" class="form-control" name="center_phone" value="{{$branch_app_env['center_phone'] ?? ''}}">
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent">
                            <div class="mc-footer">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <button type="submit" name="submit" value="center_phone"
                                            class="btn  btn-primary m-1">{{ __('Submit') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>


                    <!-- end::form -->
                </div>
            </div>
            <div class="col-lg-6 mb-3">
                <div class="card">
                    <div class="card-header bg-transparent">
                        <h3 class="card-title">آیدی گفتینو </h3>
                    </div>

                    <form method="post">
                        @csrf
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label class="radio radio-outline-secondary">
                                       آیدی گفتینو
                                    </label>
                                    <input type="text" class="form-control" name="center_goftino" value="{{$branch_app_env['center_goftino'] ?? ''}}">
                                    <small>جهت چت کاربران با اپراتور های مرکز   <a href="https://www.goftino.com/?aff=Vtbxzk" class="btn btn-warning"> عضویت در گفتینو </a></small>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent">
                            <div class="mc-footer">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <button type="submit" name="submit" value="center_goftino"
                                            class="btn  btn-primary m-1">{{ __('Submit') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>


                    <!-- end::form -->
                </div>
            </div>



        </div>
    </div>
@endsection
@section('page-js')
@endsection

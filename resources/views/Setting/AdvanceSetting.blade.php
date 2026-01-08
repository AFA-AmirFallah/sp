@php
$Persian = new App\Functions\persian();
@endphp
@extends("Layouts.MainPage")
@section('page-header-left')
@endsection
@section('MainCountent')
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-lg-6">
                    <div class="page-header-left">
                        <h3>تنظیمات
                            <small>تنظیمات پیشرفته</small>
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
            <div class="col-lg-6 mb-3">
                <div class="card">
                    <div class="card-header bg-transparent">
                        <h3 class="card-title"> به روز رسانی کد ها</h3>
                    </div>

                    <form method="post">
                        @csrf
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    به روز رسانی کد ها از منبع 
                                 </div>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent">
                            <div class="mc-footer">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <button type="submit" name="submit" value="puller"
                                            class="btn  btn-primary m-1">به روز رسانی کدها از منبع</button>
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
                        <h3 class="card-title"> به روز رسانی دیتابیس</h3>
                    </div>

                    <form method="post">
                        @csrf
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                  به روز رسانی دیتا بیس از منبع
                                 </div>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent">
                            <div class="mc-footer">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <button type="submit" name="submit" value="migrate"
                                            class="btn  btn-primary m-1">به روز رسانی دیتابیس از منبع</button>
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

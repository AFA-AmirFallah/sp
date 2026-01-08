@extends("Layouts.MainPage")
@section('page-header-left')
    <h3>افزودن بانک
        <small>عملیات حسابداری</small>
    </h3>
@endsection
@section('MainCountent')
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-lg-6">
                    <div class="page-header-left">
                        <h3>افزودن بانک
                            <small>عملیات حسابداری</small>
                        </h3>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->

    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card tab2-card">
                    <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                        <h5>ایجاد بانک جدید</h5>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs tab-coupon" id="myTab" role="tablist">
                            <li class="nav-item"><a class="nav-link active show" id="account-tab" data-toggle="tab"
                                    href="#account" role="tab" aria-controls="account" aria-selected="true"
                                    data-original-title="" title="">مشخصات بانک</a>
                            </li>
                        </ul>
                        <form method="post" class="needs-validation user-add" novalidate="">
                            @csrf
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade active show" id="account" role="tabpanel"
                                    aria-labelledby="account-tab">
                                    <div style="text-align: left">
                                        <i class="i-Bank" style="font-size: 50px;"></i>
                                    </div>
                                    <div class="form-group row">
                                        <label for="validationCustom0" class="col-xl-3 col-md-4">شناسه بانک<span class="required" >*</span></label>
                                        <input class="form-control col-xl-8 col-md-7" name="ADDUserName"
                                            placeholder="شناسه بانک را با حروف انگلیسی وارد کنید" type="text"
                                            value="{{ old('ADDUserName') }}" required>
                                    </div>
                                    <div class="form-group row">
                                        <label for="validationCustom0" class="col-xl-3 col-md-4">نام بانک<span>*</span></label>
                                        <input class="form-control col-xl-8 col-md-7" name="ADDName"
                                            value="{{ old('ADDName') }}" type="text" required="">
                                    </div>
                                    <div class="form-group row">
                                        <label for="validationCustom1"
                                            class="col-xl-3 col-md-4">نام شعبه<span>*</span></label>
                                        <input class="form-control col-xl-8 col-md-7" name="ADDFamily"
                                            value="{{ old('ADDFamily') }}" type="text" required="">
                                    </div>
                                </div>
                            </div>
                            <div class="pull-right">
                                <button type="submit" name="Registeruser" value="register"
                                    class="btn btn-primary">ذخیره</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
@endsection

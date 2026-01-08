@php
$Persian = new App\Functions\persian();
$TargetCampian =  $campains->get_campin_meta($Data);
@endphp

<form action="{{ route('AddCampin') }}" method="post">
    @csrf
    <div class="2-columns-form-layout">
        <div class="">
            <div class="row">
                <div class="col-lg-12">
                    <!-- start card -->
                    <div class="card">
                        <div class="card-header bg-transparent">
                            <h3 class="card-title"> ویرایش کمپین</h3>
                        </div>
                        <!--begin::form-->
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputEmail2" class="ul-form__label">نام فارسی کمپین
                                    </label>
                                    <input type="text" class="form-control" required name="Name"
                                        placeholder="نام فارسی کمپین" value="{{ $TargetCampian->name }}">
                                    <small id="product_name_small" class="ul-form__text form-text ">
                                        نام اصلی کمپین به فارسی
                                    </small>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputEmail2" class="ul-form__label">بودجه کمپین
                                    </label>
                                    <input onkeyup="numbertotext(this.value)" id="amount" required type="number" class="form-control" name="buget"
                                        value="{{ $TargetCampian->buget }}">
                                    <div id="amountext"></div>
                                    <small id="product_name_small" class="ul-form__text form-text ">

                                    </small>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputEmail3" class="ul-form__label">تاریخ شروع کمپین
                                    </label>
                                    <div class="input-right-icon">
                                        <input
                                            onfocus="Mh1PersianDatePicker.Show(this,'{{ $Persian->MyPersianDate(date('Y-m-d'), false, 'n') }}',)"
                                            class="form-control" name="StartDate" placeholder=" تاریخ شروع کمپین "
                                            value="">
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputEmail3" class="ul-form__label">تاریخ پایان کمپین
                                    </label>
                                    <div class="input-right-icon">
                                        <input class="form-control"
                                            onfocus="Mh1PersianDatePicker.Show(this,'{{ $Persian->MyPersianDate(date('Y-m-d'), false, 'n') }}',)"
                                            name="ExprireDate" placeholder=" تاریخ پایان کمپین " 
                                             
                                            value=""
                                             >
                                    </div>
                                </div>

                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="inputEmail3" class="ul-form__label">توضیحات
                                    </label>
                                    <div class="input-right-icon">
                                        <textarea id="hiddenArea" name="Description" required class="col-sm-12 form-control">
</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <div class="mc-footer">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <button type="submit" class="btn btn-primary m-1" name="submit"
                                                value="UpdateGoods">ثبت کمپین </button>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end::form -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

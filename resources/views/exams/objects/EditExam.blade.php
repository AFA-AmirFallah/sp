@php
$ExamTarget = $exams->get_exam($Data);
$ExamVariabales = $exams->get_exam_variables();
@endphp
<form method="post">
    @csrf

    <div class="2-columns-form-layout">
        <div class="">
            <div class="row">
                <div class="col-lg-12">
                    <!-- start card -->
                    <div class="card">
                        <div class="card-header bg-transparent">
                            <h3 class="card-title"> ویرایش آزمون</h3>
                        </div>
                        <!--begin::form-->
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputEmail1" class="ul-form__label"> SKU

                                    </label>
                                    <input type="text" class="form-control" name="SKU" id="sku"
                                        placeholder="کد آزمون" value="{{ $ExamTarget->SKU }}">
                                    <small id="sku_samall" class="ul-form__text form-text ">
                                        کد آزمون
                                    </small>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputEmail2" class="ul-form__label">نام فارسی آزمون
                                    </label>
                                    <input type="text" class="form-control" required name="NameFa" id="NameFa"
                                        placeholder="نام فارسی آزمون" value="{{ $ExamTarget->NameFa }}">
                                    <small id="product_name_small" class="ul-form__text form-text ">
                                        نام اصلی آزمون به فارسی
                                    </small>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputEmail3" class="ul-form__label">نام لاتین آزمون
                                    </label>
                                    <div class="input-right-icon">
                                        <input type="text" class="form-control" name="NameEn" required
                                            placeholder="Enter Good English name" value="{{ $ExamTarget->NameEn }}">
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputEmail3" class="ul-form__label">واحد آزمون</label>
                                    <input type="text" class="form-control" name="unit"
                                        value="{{ $ExamTarget->unit }}">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputEmail3" class="ul-form__label">مبلغ آزمون
                                    </label>
                                    <div class="input-right-icon">
                                        <input type="number" class="form-control" name="Price"
                                            value="{{ $ExamTarget->Price }}">
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputEmail3" class="ul-form__label">مبلغ پیش از تخفیف
                                    </label>
                                    <div class="input-right-icon">
                                        <input type="number" class="form-control" name="BasePrice" value="{{ $ExamTarget->BasePrice }}">
                                    </div>
                                </div>
                            </div>

                            <div class="custom-separator"></div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="inputEmail1" class="ul-form__label">توضیح کوتاه
                                    </label>
                                    <input type="text" class="form-control" name="Description" required
                                        placeholder="توضیح کوتاه یک خطی" value="{{ $ExamTarget->Description }}">
                                    <small class="ul-form__text form-text ">
                                        توضیح برای نمایش
                                    </small>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="inputEmail1" class="ul-form__label">لینک تصویر آزمون
                                    </label>
                                    <input type="text" class="form-control" name="ImgURL" required
                                         value="{{$ExamTarget->ImgURL}}">
                                    <small class="ul-form__text form-text ">
                                       لینک تصویر آزمون
                                    </small>
                                </div>
                            </div>
                            <div class="custom-separator"></div>

                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="inputEmail3" class="ul-form__label">متغییر ها
                                    </label>
                                    <div class="col-sm-12 row  input-right-icon">
                                        <div class="col-sm-3">
                                            <label for="variables" class="ul-form__label">متغییر ها</label>
                                            <textarea id="variables" name="variables" rows="10" class=" form-control">
@foreach ($ExamVariabales->Variables as $variable)
{{ $variable }}
@endforeach
                                                
                                            </textarea>

                                        </div>
                                        <div class="col-sm-3">
                                            <label for="notes" class="ul-form__label">توضیح متغییر</label>
                                            <textarea id="notes" name="notes" rows="10" class="variabales form-control">
@foreach ($ExamVariabales->notes as $note)
{{ $note }}
@endforeach
</textarea>

                                        </div>
                                        <div class="col-sm-3">
                                            <label for="defaultval" class="ul-form__label">مقدار اولیه</label>
                                            <textarea id="defaultval" name="defaultval" rows="10" class=" form-control">
@foreach ($ExamVariabales->defaultval as $defaultval)
{{ $defaultval }}
@endforeach
</textarea>

                                        </div>
                                        <div class="col-sm-3">
                                            <label for="variables" class="ul-form__label">نتیجه</label>
                                            <textarea id="result" name="result" rows="10" class=" form-control"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="mc-footer">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <button type="submit" class="btn btn-primary m-1" name="save_edit"
                                                value="{{ $ExamTarget->id }}">ثبت ویرایش آزمون </button>
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


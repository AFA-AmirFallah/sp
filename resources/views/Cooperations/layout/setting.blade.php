<div id="base_info" class=" main_forms col-lg-6 mb-3">
    <div class="card">
        <div class="card-header bg-transparent">
            <h3 class="card-title"> اطلاعات پایه </h3>
        </div>
        <div class="form-group">

            <div class="col-md-6 col-sm-6 col-xs-12">

                <!-- Error -->
                <div class='alert alert-danger mt-2 d-none text-danger' id="err_file"></div>

            </div>
        </div>
        <form method="POST">
            @csrf
            <div class="card-body">
                <div class="form-row ">
                    <div class="form-group col-md-12">
                        <label class="ul-form__label">آدرس اختصاصی لینک</label>
                        <input class="form-control col-xl-12 col-md-12" name="target_url" value="{{ $seo->get_url() }}"
                            type="text" required>
                        <small class="ul-form__text form-text text-danger ">
                            آدرس نمی تواند تکراری باشد.
                            توجه داشته باشید بدون آدرس صفحه اختصاصی نمایش داده نمی شود
                        </small>
                    </div>
                </div>

            </div>
            <div class="card-footer bg-transparent">
                <div class="mc-footer">
                    <div class="row">
                        <div class="col-lg-12">
                            <button type="submit" name="seo" value="save_link"   class="btn  btn-primary m-1">ذخیره</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <!-- end::form -->
    </div>
</div>

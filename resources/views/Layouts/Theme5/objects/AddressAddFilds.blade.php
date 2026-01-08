<div id="InputAddress">
    <div class="row">
        <div class="">
            <form class="form-account" action="">
                <div class="row">
                    <div class="col-md-6 col-sm-12 mb-2">

                        <label for="LocationName"> عنوان آدرس <span style="color: red">*</span></label>
                        <input type="text" placeholder="مثال: خانه" class="form-control text-right address-input"
                            name="LocationName" id="LocationName" required>
                        <div class="invalid-feedback">عنوان آدرس باید وارد شود</div>
                    </div>
                    <div class="col-md-6 col-sm-12 mb-2">
                        <label for="LocationName"> شماره موبایل <span style="color: red">*</span></label>

                        <input class="form-control pl-2 dir-ltr text-left address-input" id="mobile_no" type="text"
                            inputmode="numeric" placeholder="09xxxxxxxxx">
                        <div class="invalid-feedback">شماره تلفن همراه گیرنده می باید وارد شود</div>
                    </div>
                    <div class="col-md-6 col-sm-12 mb-2">
                        <label for="LocationName"> استان <span style="color: red">*</span></label>
                        <select name="Province" id="Province" onchange="LoadCitys(this.value)"
                            class="form-control address-input">
                            <option value="0">{{ __('--select--') }}</option>
                            @foreach ($Order->get_provices_all() as $ProvincesTarget)
                                <option value="{{ $ProvincesTarget->id }}">
                                    {{ $ProvincesTarget->ProvinceName }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">انتخاب استان در آدرس الزامی است</div>
                    </div>
                    <div class="col-md-6 col-sm-12 mb-2">

                        <label for="LocationName"> شهر <span style="color: red">*</span></label>
                        <select id="Shahrestan" name="Saharestan" class="form-control address-input">
                        </select>
                        <a href="javascript:LoadCityIndependent()">بارگذاری شهر بر اساس استان</a>
                        <div class="invalid-feedback">انتخاب شهر الزامی است.</div>

                    </div>
                    <div class="col-12 mb-2">

                        <label for="LocationName"> آدرس پستی <span style="color: red">*</span></label>

                        <textarea id="OthersAddress" name="OthersAddress" style="padding-right: 24px!important;" required
                            class="form-control pr-2 text-right address-input" placeholder=" آدرس تحویل گیرنده را وارد نمایید"></textarea>
                        <div class="invalid-feedback">آدرس تحویل گیرنده می باید وارد شود</div>
                    </div>
                    <div class="col-12 mb-2">
                        <label for="LocationName"> کد پستی <span style="color: red">*</span></label>
                        <input id="PostalCode" name="PostalCode" required
                            class="form-control pl-2 dir-ltr text-left address-input" inputmode="numeric" type="text"
                            placeholder=" کد پستی را بدون خط تیره بنویسید">
                            <small>کد پستی باید ۱۰ رقم و بدون خط تیره باشد. </small>
                        <div class="invalid-feedback">وارد نمودن کد پستی الزامی است</div>

                    </div>
                    <div class="col-12 pr-4 pl-4">

                        <button
                            style="    
                    color:#636363;
                    width: 181px !important;
                   
                    background-color: #e3e3e3;"
                            class="btn-primary-cm btn-with-icon w-100 text-center pr-0 pl-0" type="button"
                            onclick="reverse_add_new_location()" data-target="#remove-location"><i
                                class="mdi mdi-arrow-right"></i>انصراف بازگشت</button>
                        <button id="edit_btn"
                            style="text-align: left !important;width: 200px !important;position: absolute;padding-left: 18px !important;
                    left: 14px;"
                            type="button" onclick="add_user_address()"
                            class=" btn-primary-cm btn-with-icon w-100 text-center pr-0 pl-0">
                            <i class="mdi mdi-content-save"></i>ویرایش آدرس </button> 
                            <button id="save_btn"
                            style="text-align: left !important;width: 200px !important;position: absolute;padding-left: 18px !important;
                    left: 14px;"
                            type="button" onclick="add_user_address()"
                            class="btn-primary-cm btn-with-icon w-100 text-center pr-0 pl-0">
                            <i class="mdi mdi-content-save"></i>ثبت آدرس جدید</button>

                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="section-title text-sm-title mb-1 no-after-dt-sl mb-2 px-res-1">
            <h2>آدرس ها</h2>
        </div>
        <div class="dt-sl">
            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <div class="card-horizontal-address text-center px-4">
                        <button class="checkout-address-location" data-toggle="modal" data-target="#modal-location">
                            <strong>ایجاد آدرس جدید</strong>
                            <i class="mdi mdi-map-marker-plus"></i>
                        </button>
                    </div>
                </div>
                @foreach ($orders->get_User_Locations() as $location)
                    <div class="col-lg-6 col-md-12">
                        <div class="card-horizontal-address">
                            <div class="card-horizontal-address-desc">
                                <h4 class="card-horizontal-address-full-name">{{$location->name}} </h4>
                                <p>
                                    {{$location->Province}} - {{$location->City}} , {{$location->Street}} {{$location->OthersAddress}}
                                </p>
                            </div>
                            <div class="card-horizontal-address-data">
                                <ul class="card-horizontal-address-methods float-right">
                                    <li class="card-horizontal-address-method">
                                        <i class="mdi mdi-email-outline"></i>
                                        کدپستی : <span>{{$location->PostalCode}}</span>
                                    </li>
                                    <li class="card-horizontal-address-method">
                                        <i class="mdi mdi-cellphone-iphone"></i>
                                        تلفن همراه : <span>{{$location->reciverphone}}</span>
                                    </li>
                                </ul>
                                <div class="card-horizontal-address-actions">
                                    <button class="btn-note" data-toggle="modal"
                                        data-target="#modal-location-edit">ویرایش</button>
                                    <button class="btn-note" data-toggle="modal"
                                        data-target="#remove-location">حذف</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
<div id="InputAddress">
    <div class="row">
        <div class="">
            <form class="form-account" action="">
                <div class="row">
                    <div class="col-md-6 col-sm-12 mb-2">

                        <label for="LocationName"> عنوان آدرس <span style="color: red">*</span></label>
                        <input type="text" placeholder="مثال: خانه" class="form-control text-right"
                            name="LocationName" id="LocationName" required>
                    </div>
                    <div class="col-md-6 col-sm-12 mb-2">
                        <label for="LocationName"> شماره موبایل <span style="color: red">*</span></label>

                        <input class="form-control pl-2 dir-ltr text-left" id="mobile_no" type="text"
                            inputmode="numeric" placeholder="09xxxxxxxxx">
                    </div>
                    <div class="col-md-6 col-sm-12 mb-2">
                        <label for="LocationName"> استان <span style="color: red">*</span></label>
                        <select name="Province" id="Province" onchange="LoadCitys(this.value)" class="form-control">
                            <option value="0">{{ __('--select--') }}</option>
                            @foreach ($orders->get_provices_all() as $ProvincesTarget)
                                <option value="{{ $ProvincesTarget->id }}">
                                    {{ $ProvincesTarget->ProvinceName }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 col-sm-12 mb-2">

                        <label for="LocationName"> شهر <span style="color: red">*</span></label>

                        <select id="Shahrestan" name="Saharestan" class="form-control">
                        </select>
                    </div>
                    <div class="col-12 mb-2">

                        <label for="LocationName"> آدرس پستی <span style="color: red">*</span></label>

                        <textarea id="OthersAddress" name="OthersAddress" required class="form-control pr-2 text-right"
                            placeholder=" آدرس تحویل گیرنده را وارد نمایید"></textarea>
                    </div>
                    <div class="col-12 mb-2">
                        <label for="LocationName"> کد پستی <span style="color: red">*</span></label>
                        <input id="PostalCode" name="PostalCode" required class="form-control pl-2 dir-ltr text-left "
                            inputmode="numeric" type="text" placeholder=" کد پستی را بدون خط تیره بنویسید">

                    </div>
                    <div class="col-12 pr-4 pl-4">
                        <button style="width: 200px !important" type="button" onclick="add_user_address()"
                            class="btn-primary-cm btn-with-icon w-100 text-center pr-0 pl-0">
                            <i class="mdi mdi-content-save"></i>ثبت آدرس جدید</button>
                        <button style="    text-align: left !important;
                        color:#636363;
                        width: 181px !important;
                        position: absolute;
                        left: 14px;
                        padding-left: 18px !important;
                        background-color: #e3e3e3;" class="btn-primary-cm btn-with-icon w-100 text-center pr-0 pl-0" data-toggle="modal"
                            data-target="#remove-location"><i class="mdi mdi-arrow-right"></i>انصراف بازگشت</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

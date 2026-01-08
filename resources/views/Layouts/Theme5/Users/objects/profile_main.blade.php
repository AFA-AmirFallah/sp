<div class="row">
    <div class="col-xl-6 col-lg-12">
        <div class="px-3">
            <div class="section-title text-sm-title mb-1 no-after-dt-sl mb-2">
                <h2>اطلاعات شخصی {{ $UserInfoResult->RoleName }} </h2>
            </div>
            <div class="profile-section dt-sl">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="label-info">
                            <span>نام:</span>
                        </div>
                        <div class="value-info">
                            <span>
                                {{ $UserInfoResult->nameofuser }}
                            </span>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="label-info">
                            <span> نام خانوادگی:</span>
                        </div>
                        <div class="value-info">
                            <span>{{ $UserInfoResult->Family }}</span>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="label-info">
                            <span>شماره تلفن همراه:</span>
                        </div>
                        <div class="value-info">
                            <span>{{ $UserInfoResult->MobileNo }}</span>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="label-info">
                            <span>کد ملی:</span>
                        </div>
                        <div class="value-info">
                            <span>{{ Auth::user()->MelliID ?? '-' }}</span>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="label-info">
                            <span>دریافت خبرنامه:</span>
                        </div>
                        <div class="value-info">
                            <span>خیر</span>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="label-info">
                            <span>شماره کارت:</span>
                        </div>
                        <div class="value-info">
                            <span>-</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="col-xl-6 col-lg-12">
        <div class="px-3">
            <div class="section-title text-sm-title mb-1 no-after-dt-sl mb-2">
                <h2>لیست آخرین علاقه‌مندی‌ها</h2>
            </div>
            @php
                $mark_src = $mark->get_my_marked_products(Auth::id(), 1);
            @endphp
            <div class="profile-section dt-sl">
                <ul class="list-favorites">
                    @foreach ($mark_src as $mark_item)
                        <li id="mark_{{$mark_item->id}}" >
                            <a href="{{ route('SingleProduct', ['productID' => $mark_item->id]) }}">
                                <img src="{{ App\Functions\Images::GetPicture($mark_item->ImgURL, 1) }}" alt="">
                                <span>{{ \Illuminate\Support\Str::limit($mark_item->NameFa, 45, $end = '...') }}</span>
                            </a>
                            <button type="button" onclick="unmark({{$mark_item->id}})">
                                <i class="mdi mdi-trash-can-outline"></i>
                            </button>
                        </li>
                    @endforeach
                </ul>
                <div class="profile-section-link">
                    <a  class="border-bottom-dt">
                        <i class="mdi mdi-square-edit-outline"></i>
                        مشاهده و ویرایش لیست مورد علاقه
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>


@php
    $file_pic = App\Deal\DealFiles::get_deal_file_min_pic($file_item->id);

@endphp
<div class="col-sm-6 col-md-4 col-lg-4">
    <div class="single-add-box">
        <div class="image deal-img">
            <a class="deal-img" href="{{ route('files', ['file_id' => $file_item->id]) }}">
                <img class="deal-img" src="{{ $file_pic->pic ?? '' }}" alt="{{ $file_item->title }}">
            </a>
        </div>

        <div class="image-caption-wrapper border-caption">

            <div class="add-box-content">
                <a href="{{ route('files', ['file_id' => $file_item->id]) }}">
                    <h3>{{ $file_item->title }}</h3>
                </a>
                <div class="info-list">
                    <ul>
                        <li><i class="flaticon-car"></i>
                            {{ App\Deal\DealFiles::get_product_cat($file_item->product_type) }}
                        </li>
                        <li><i class="flaticon-car"></i>
                            {{ App\Deal\DealFiles::get_post_cats_deatil($file_item->post_cat) }}
                        </li>
                        <li><i class="flaticon-facebook-placeholder-for-locate-places-on-maps"></i>پارکینگ
                        </li>
                    </ul>
                </div>
            </div>
            <div class="add-box-bottom">
                <h5>{{ $file_item->show_price }}</h5>

                <ul class="react">
                        <a style="      background: #be2026;
    padding: 5px 30px;
    color: #ffff;
    text-transform: capitalize;
    font-weight: 600;
    display: inline-block;
    font-size: 14px;
    border-radius: 10px;"
                            href="{{ route('files', ['file_id' => $file_item->id]) }}" class="add-cart">نمایش</a>
                </ul>
            </div>
        </div>
    </div>
    {{-- <div class="single-shop">
        <div class="shop-image">
            <a href="{{ route('files', ['file_id' => $file_item->id]) }}"><img src="{{ $file_pic->pic ?? '' }}" alt="{{ $file_item->title }}"></a>

            <div class="add-cart-hover">
                <div class="d-table">
                    <div class="d-tablecell">
                        <a href="#" class="add-cart">نمایش</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="image-caption">
            <a href="shop-details.html">
                <h3> {{ $file_item->title }} </h3>
            </a>
            <span>500000 تومان</span>
        </div>
    </div> --}}
</div>
{{-- <div class="col-md-6 col-lg-{{$height ?? 3}}">
    <div class="single-add-box">
        <div class="image deal-img">
            <a class="deal-img" href="{{ route('files', ['file_id' => $file_item->id]) }}">
                <img class="deal-img" src="{{ $file_pic->pic ?? '' }}" alt="{{ $file_item->title }}">
            </a>
        </div>

        <div class="image-caption-wrapper border-caption">

            <div class="add-box-content">
                <a href="{{ route('files', ['file_id' => $file_item->id]) }}">
                    <h3>{{ $file_item->title }}</h3>
                </a>
                <div class="info-list">
                    <ul>
                        <li><i class="flaticon-car"></i>
                            {{ App\Deal\DealFiles::get_product_cat($file_item->product_type) }}
                        </li>
                        <li><i class="flaticon-facebook-placeholder-for-locate-places-on-maps"></i>پارکینگ
                        </li>
                    </ul>
                </div>
            </div>
            <div class="add-box-bottom">
                <h5>{{ $file_item->show_price }}</h5>
                <ul class="react">
                    <li><a href="{{ route('files', ['file_id' => $file_item->id]) }}">نمایش</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div> --}}

@foreach ($cat_orders as $cat_orders_item)
    <div class="col-lg-4">
        <div class="st-blog st-style1 wow fadeInUp" data-wow-duration="0.8s" data-wow-delay="0.2s">
            <div class="st-zoom">
                <a href="#" class="st-blog-thumb st-bg st-zoom-in" data-src="{{ $cat_orders_item->Pic }}"></a>
            </div>
            <div class="st-blog-info">
                <div class="st-blog-label"> {{ $cat_orders_item->centers }} <a href="#">مرکز
                        ارائه دهنده</a></div>
                <h2 class="st-blog-title"><a href="#">{{ $cat_orders_item->Cat }}</a>
                </h2>
                <div class="st-blog-text">{{ $cat_orders_item->TitleDescription }}</div>
                <div class="st-blog-meta">
                    <div class="st-blog-meta-left"><span class="st-posted-by">خدمات
                            هوم‌کر</span>
                    </div>
                    @if ($cat_orders_item->centers > 0)
                        <div class="st-blog-meta-right"><a
                                href="{{ route('CustomerOrder', ['OrderID' => $cat_orders_item->Cat]) }} "
                                class="st-blog-btn text-success">درخواست
                                خدمت <i class="fas fa-chevron-right"></i></a></div>
                    @else
                        <div class="st-blog-meta-right text-danger">ارائه دهنده خدمت وجود ندارد
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endforeach

<div class="container main-container">
    <section class="slider-section dt-sl mb-5">
        <div class="row">
            <!-- Start Product-Slider -->
            <div class="col-12">
                <div class="brand-slider carousel-lg owl-carousel owl-theme">
                    @foreach ($DashboardClass->GetSameLevelIndex(App\Functions\Themes::get_value_from_Json($mobile_banner->pic, 'TagUID'), App\Functions\Themes::get_value_from_Json($mobile_banner->pic, 'Limit')) as $ProductItem)
                        <div class="item">
                            <a href="{{ route('ShowProduct', ['Tags' => App\Functions\Themes::get_value_from_Json($mobile_banner->pic, 'TagUID')]) }}">
                                <img src="{{ $ProductItem->img }}" class="img-fluid" alt="{{ $ProductItem->Name }}">

                            </a>
                        </div>
                    @endforeach

                </div>
            </div>
            <!-- End Product-Slider -->

        </div>
    </section>
    <!-- End Brand-Slider -->
</div>

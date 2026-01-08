<!--    140111 -->
<div class="container mt-10 pt-2">
    <div class="row cols-md-2 mb-5 ">
        <div class="banner banner-fixed mb-4 br-sm">
            <a href="{{ App\Functions\Themes::get_value_from_Json($mobile_banner->pic, 'link1') }}">

                <img src="{{ App\Functions\Themes::get_value_from_Json($mobile_banner->pic, 'pic1') }}" alt="دسته بنر" />

            </a>

        </div>
        <!-- End of Banner -->
        <div class="banner banner-fixed mb-4 .br-sm">
            <a href="{!! App\Functions\Themes::get_value_from_Json($mobile_banner->pic, 'link2') !!}">


                <img src="{{ App\Functions\Themes::get_value_from_Json($mobile_banner->pic, 'pic2') }}" alt="دسته بنر" />

            </a>
        </div>
        <!-- End of Banner -->
    </div>
</div>

<!--   end 140111 -->

<!--    140115 -->
<div class="container mt-10 pt-2">



    <div class="title-link-wrapper mb-3">
        <h2 class="title title-link mb-0 pt-2 pb-2">{{ $mobile_banner->title }}</h2>

        <a href="{{ route('NewsHome') }}" class="mb-0">مشاهده همه مقالات<i class="w-icon-long-arrow-left"></i></a>
    </div>
    <div class="owl-carousel owl-theme post-wrapper row cols-lg-4 cols-md-3 cols-sm-2 cols-1 mb-10 mb-lg-5 appear-animate"
        data-owl-options="{
                    'nav': false,
                    'dots': true,
                    'margin': 20,
                    'responsive': {
                        '0': {
                            'items': 1
                        },
                        '576': {
                            'items': 2
                        },
                        '768': {
                            'items': 3
                        },
                        '992': {
                            'items': 4
                        }
                    }
                }">
        @foreach (App\Functions\NewsClass::NewsListByIndexID(App\Functions\Themes::get_value_from_Json($mobile_banner->pic, 'TagUID'), App\Functions\Themes::get_value_from_Json($mobile_banner->pic, 'Limit')) as $PostItem)
        <div class="post text-center">
                <figure class="post-media br-sm">
                    <a href="{{ route('ShowNewsItem', [$PostItem->id]) }}">
                        <img src="{{ $PostItem->MainPic }}" alt="Post" width="620"
                            height="398" style="background-color: #898078;">
                    </a>
                    <div class="post-calendar">
                        @php
                            $DateArr = $Persian->PersianDateText($PostItem->CrateDate)
                        @endphp
                        <span class="post-day">{{ $DateArr[2] }}</span>
                        <span class="post-month">{{ $DateArr[1] }} </span>
                    </div>
                </figure>
                <div class="post-details">
                  
                    <h4 class="post-title"><a href="{{ route('ShowNewsItem', [$PostItem->id]) }}">{{ $PostItem->Titel }}</a></h4>
                    <a href="{{ route('ShowNewsItem', [$PostItem->id]) }}" class="btn btn-link btn-dark btn-underline">ادامه مطلب <i
                            class="w-icon-long-arrow-left"></i></a>
                </div>
            </div>
        @endforeach

    </div>
    <!-- Post Wrapper -->
</div>

<!--   end 140115 -->

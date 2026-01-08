<section class="list-news-wrapper block-wrapper">
    <div style="margin-right: -15px" class="container">
        <div style="margin-left: 15px" class="row">
            <div style="margin-right: 15px" class="slider-div col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="latest-news block">
                    <h3 class="block-title"><span>پربازدید ترین خبر ها</span></h3>

                    <div id="latest-news-slide" class="slides-continner owl-carousel owl-theme latest-news-slide">
                        @php
                            $mostviewconter = 1;
                        @endphp
                        @foreach ($DataSource->MostViewPosts() as $LastPost)
                            @if ($mostviewconter % 2 != 0)
                                <div class="item">
                                    <ul class="list-post">
                                        <li class="clearfix">
                                            <div class="post-block-style clearfix">
                                                <div class="post-thumb">
                                                    <a href="{{ route('ShowNewsItem', [$LastPost->id]) }}"><img
                                                            class="img-responsive" 
                                                            src="{{ $LastPost->MainPic }}" alt=""></a>
                                                </div>
                                                <div class="post-content" style="height: 55px;">
                                                    <h2 class="text-mian post-title title-medium">
                                                        <a class="text-mian"
                                                            href="{{ route('ShowNewsItem', [$LastPost->id]) }}">{{ strip_tags($LastPost->Titel) }}</a>
                                                    </h2>
                                                </div><!-- Post content end -->
                                            </div><!-- Post Block style end -->
                                        </li><!-- Li end -->
                                    @else
                                        <div class="gap-20"></div>

                                        <li class="clearfix">
                                            <div class="post-block-style clearfix">
                                                <div class="post-thumb">
                                                    <a href="{{ route('ShowNewsItem', [$LastPost->id]) }}"><img
                                                            class="img-responsive" 
                                                            src="{{ $LastPost->MainPic }}" alt=""></a>
                                                </div>
                                                <div class="post-content" style="height: 55px;">
                                                    <h2 class="text-mian post-title title-medium">
                                                        <a class="text-mian"
                                                            href="{{ route('ShowNewsItem', [$LastPost->id]) }}">{{ strip_tags($LastPost->Titel) }}</a>
                                                    </h2>
                                                </div><!-- Post content end -->
                                            </div><!-- Post Block style end -->
                                        </li><!-- Li end -->
                                    </ul><!-- List post 1 end -->

                                </div><!-- Item 1 end -->

                            @endif
                            @php
                                $mostviewconter++;
                            @endphp

                        @endforeach

                    </div><!-- Latest News owl carousel end-->
                </div>
                <!--- Latest news end -->

            </div><!-- Content Col end -->

        </div><!-- Row end -->
    </div><!-- Container end -->
</section><!-- First block end -->
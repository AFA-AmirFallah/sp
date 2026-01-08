@if ($ads == [])
    <div class="sidebar-overlay"></div>
    <a class="sidebar-close" href="#"><i class="close-icon"></i></a>
    <a href="#" class="sidebar-toggle d-flex d-lg-none"><i class="fas fa-chevron-left"></i></a>
    <div class="sidebar-content scrollable">
        <div class="pin-wrapper" style="height: 996.68px;">
            <div class="sticky-sidebar" style="border-bottom: 0px none rgb(102, 102, 102); width: 280px;">
                <div class="widget widget-banner mb-9">
                    <div class="banner banner-fixed br-sm">
                        <figure>
                            <img src="/assets/images/TBG.png" alt="Banner" width="266" height="220"
                                style="background-color: #1D2D44;">
                        </figure>

                    </div>
                </div>
                <!-- End of Widget Icon Box -->

                <div class="widget widget-banner mb-9">
                    <div class="banner banner-fixed br-sm">
                        <figure>
                            <img src="/assets/images/TBG2.png" alt="Banner" width="266" height="220"
                                style="background-color: #1D2D44;">
                        </figure>

                    </div>
                </div>
                <!-- End of Widget Banner -->


            </div>
        </div>
    </div>
@else
    <div class="sidebar-overlay"></div>
    <a class="sidebar-close" href="#"><i class="close-icon"></i></a>
    <a href="#" class="sidebar-toggle d-flex d-lg-none"><i class="fas fa-chevron-left"></i></a>
    <div class="sidebar-content scrollable">
        <div class="pin-wrapper" style="height: 996.68px;">
            <div class="sticky-sidebar" style="border-bottom: 0px none rgb(102, 102, 102); width: 280px;">

                @foreach ($ads as $AdsItem)
                    <div class="widget widget-banner mb-9">
                        <div class="banner banner-fixed br-sm">
                            <figure>
                                @if ($AdsItem->adds == 2)
                                    @php
                                        $BannerLink = strip_tags($AdsItem->Titel);
                                    @endphp
                                    <a href="{{ $BannerLink }}">
                                        <img src="{{ $AdsItem->MainPic }}" alt="Banner" width="266" height="220"
                                            style="background-color: #1D2D44;">
                                    </a>
                                @elseif ($AdsItem->adds == 1)
                                    <a href="{{ route('ShowNewsItem', ['NewsId' => $AdsItem->id]) }}">
                                        <img src="{{ $AdsItem->MainPic }}" alt="Banner" width="266" height="220"
                                            style="background-color: #1D2D44;">
                                    </a>
                                @endif
                            </figure>

                        </div>
                    </div>
                @endforeach

                <div class="widget widget-banner mb-9">
                    <div class="banner banner-fixed br-sm">
                        <figure>
                            <img src="/assets/images/TBG.png" alt="Banner" width="266" height="220"
                                style="background-color: #1D2D44;">
                        </figure>

                    </div>
                </div>
            </div>
        </div>
    </div>


@endif

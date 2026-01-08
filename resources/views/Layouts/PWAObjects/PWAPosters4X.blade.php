        @php
            $Src = json_decode($mobile_banner->pic);
        @endphp
        <div style="margin-bottom: 20px;display: flex;">
            <div  class="wpa-md12 col-md-12 poster4x_Continer_7">
                <div class="wpa-md6 col-md-6 poster4x_item_7">
                    <a class="poster4x_item_7" href="{{ $Src->link1 }} ">
                        <img class="poster4x_item_7" src="{{ $Src->pic1 }}" alt="{{ $mobile_banner->title }}">

                    </a>
                </div>
                <div class="wpa-md6 col-md-6 poster4x_item_7">
                    <a class="poster4x_item_7" href="{{ $Src->link2 }} ">
                        <img class="poster4x_item_7" src="{{ $Src->pic2 }}" alt="{{ $mobile_banner->title }}">

                    </a>
                </div>
            </div>
            @if ($Src->pic3 == '#' && $Src->pic4 == '#')
            @else
                <div class="wpa-md12 col-md-12 poster4x_Continer_7">
                    <div class="wpa-md6 col-md-6 poster4x_item_7">
                        <a class="poster4x_item_7" href="{{ $Src->link3 }} ">
                            <img class="poster4x_item_7" src="{{ $Src->pic3 }}" alt="{{ $mobile_banner->title }}">

                        </a>
                    </div>
                    <div class="wpa-md6 col-md-6 poster4x_item_7">
                        <a class="poster4x_item_7" href="{{ $Src->link4 }} ">
                            <img class="poster4x_item_7" src="{{ $Src->pic4 }}"
                                alt="{{ $mobile_banner->title }}">

                        </a>
                    </div>

                </div>
            @endif
        </div>

   @php
       $elements = json_decode($mobile_banner->pic);
   @endphp
   
   <div class="st-hero-slide st-style2 st-flex" id="home">
        <div class="container">
            <div class="st-hero-text st-style1 st-color1">
                {!! $elements[1]->link1 !!}
            </div>
        </div>
        <div class="st-hero-img"><img src="{{$elements[0]->pic1}}" alt="main_pic"></div>
        <div class="st-circla-animation">
            <div class="st-circle st-circle-first"></div>
            <div class="st-circle st-circle-second"></div>
        </div>
        <div class="st-wave-wrap">
            <div class="st-wave st-wave-first">
                <div class="st-wave-in" style="background-image: url(/Theme4/assets/img/light-img/shape1.png);">
                </div>
            </div>
            <div class="st-wave st-wave-second">
                <div class="st-wave-in" style="background-image: url(/Theme4/assets/img/light-img/shape1.png);">
                </div>
            </div>
        </div>
    </div>

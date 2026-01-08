@php
$Src = json_decode($mobile_banner->pic);
@endphp
<div class=" icons3rowtop carousel_wrap col-md-12 row">
    <div class="icons3rowFirst icons3row wpa-md4 col-md-4">
        <a href="{{ $Src->link1 }}">
            <div style="background:{{ $Src->color1 }};" class=" card card-ecommerce-3 o-hidden mb-4">
                <div class="d-flex flex-column flex-sm-row">
                    <div class="icons3rowimgholder">
                        <img class="icons3row" src="{{ $Src->pic1 }}" alt="{{ $Src->txt1 }}">
                    </div>
                    <div class="icons3rowtextholder flex-grow-1">
                        <p class="icons3row">{{ $Src->txt1 }}</p>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="icons3rowMedle icons3row wpa-md4 col-md-4">
        <a href="{{ $Src->link2 }}">
            <div style="background:{{ $Src->color2 }};" class=" card card-ecommerce-3 o-hidden mb-4">
                <div class="d-flex flex-column flex-sm-row">
                    <div class="icons3rowimgholder">
                        <img class="icons3row" src="{{ $Src->pic2 }}" alt="{{ $Src->txt2 }}">
                    </div>
                    <div class="icons3rowtextholder flex-grow-1">
                        <p class="icons3row">{{ $Src->txt2 }}</p>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="icons3rowLast icons3row wpa-md4 col-md-4">
        <a href="{{ $Src->link3 }}">
            <div style="background:{{ $Src->color3 }};" class=" card card-ecommerce-3 o-hidden mb-4">
                <div class="d-flex flex-column flex-sm-row">
                    <div class="icons3rowimgholder">
                        <img class="icons3row" src="{{ $Src->pic3 }}" alt="{{ $Src->txt3 }}">
                    </div>
                    <div class="icons3rowtextholder flex-grow-1">
                        <p class="icons3row">{{ $Src->txt3 }}</p>
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>

        <style>
            .scrol-slide-img {
                margin: auto;
            }

        </style>
        @php
            $Src = json_decode($mobile_banner->pic);
        @endphp
        <div style="margin-bottom: 20px;" class="horizental-list ">
            @if ($Src->pic1 != '0')
                <img style="margin-left: 10px" class="scrol-slide-img" alt="{{ $mobile_banner->title }}"
                    src="{{ $Src->pic1 }}">
            @endif
            @if ($Src->pic2 != '0')
                <img style="margin-left: 10px" class="scrol-slide-img" alt="{{ $mobile_banner->title }}"
                    src="{{ $Src->pic2 }}">
            @endif
            @if ($Src->pic3 != '0')
                <img style="margin-left: 10px" class="scrol-slide-img" alt="{{ $mobile_banner->title }}"
                    src="{{ $Src->pic3 }}">
            @endif
            @if ($Src->pic4 != '0')
                <img style="margin-left: 10px" class="scrol-slide-img" alt="{{ $mobile_banner->title }}"
                    src="{{ $Src->pic4 }}">
            @endif
        </div>

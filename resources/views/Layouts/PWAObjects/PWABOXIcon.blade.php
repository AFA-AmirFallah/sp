@php
$initBoxIcon = true;
$BoxIndex = null;
@endphp

@php
$ArrayTitle = json_decode($mobile_banner->title);
$BoxName = $ArrayTitle->BoxName;
$title = $ArrayTitle->title;
@endphp
@if ($initBoxIcon)
    <div class="pwa_service_card_body card-body pwa_blue_gradian">
        <div class="pwa-card-title card-title">{{ $BoxName }}</div>
        <hr class="CustomerServiceCardHr">
        <div style="margin: 0px" class="row col-lg-12 col-md-12 col-sm-12">

            @php
                $BoxIndex = $BoxName;
            @endphp
        @elseif($BoxIndex != $BoxName)
        </div>
    </div>
    <div class="pwa_service_card_body card-body pwa_blue_gradian">
        <div class="pwa-card-title card-title">{{ $BoxName }}</div>
        <hr class="CustomerServiceCardHr">
        <div style="margin: 0px" class="row col-lg-12 col-md-12 col-sm-12">

            @php
                $BoxIndex = $BoxName;
            @endphp


@endif
<div class="col-lg-6 col-md-6 col-sm-6 iconbardesign pwa_iconsmain">
    <a href="#" class="btn  btn-icon rounded-circle">
        <img class="line-btn" src="{{ $mobile_banner->pic }}" alt="{{ $title }}">
        {{ $title }}
    </a>
</div>
@if ($initBoxIcon)
    @php
        $initBoxIcon = false;
    @endphp
@endif

</div>
</div>

    @foreach ($mobile_banners as $mobile_banner)
        @if ($mobile_banner->theme == 5)
            <h5>{{ $mobile_banner->title }}</h5>
            <hr>
        @endif

    @endforeach
<div class="col-lg-2 col-md-3 col-sm-3">
    <div class="card card-primary card-icon mb-4">
        <div class="card-body text-center">
            <img src="{{ $image }}" alt="">
            <ul>
                <li>آدرس : <a target="_blank" href="{{ $address }}">{{ $address }}</a></li>
                <li>قیمت: {{ number_format($price ?? 0) }}</li>
                <li>نام: {{ $Name }}</li>
            </ul>
        </div>
    </div>
</div>

@php
    $Persian = new App\Functions\persian();
@endphp
@extends('Layouts.MainPage')
@section('page-header-left')
@endsection
@section('MainCountent')
    <div class="auth-content">

        <div class="card user-profile o-hidden mb-4">
            <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                <h1 class="text-white"><img width="100px" src="{{$branch->avatar}}" alt="">
                    {{ $branch->Description }}</h1>
            </div>
            <div class="user-info">
                <img style="max-width: 300px ; margin-top:50px" class="profile-picture avatar mb-2"
                    src="
                  @if ($targetUser->avatar != null) {{ $targetUser->avatar }}
        @else
            {{ url('/') }}/assets/images/avtar/useravatar.png @endif
            "
                    alt="">
                <p class="m-0 text-24">{{ $targetUser->Name }} {{ $targetUser->Family }}</p>
                <p class="text-muted m-0">{{ $targetUser->extranote }}</p>
                <hr>
                <h6>{{ __('Personel Status') }} : {{ $UserStatus->Name }} </h6>
                <h6>{{ __('Query time') }} : {{ $Persian->MyPersianDate(date('Y-m-d h:i:sa'), true) }}</h6>

            </div>
            <div class="card-body" style="text-align: center ; color:crimson">
                این کارت نشان دهنده وضعیت پرسنلی {{ $targetUser->Name }} {{ $targetUser->Family }}   در زمان استعلام می باشد.
            </div>
        </div>
    </div>
@endsection

@section('page-js')
    <script></script>
@endsection

@section('bottom-js')
@endsection

@if (Auth::check())
    <div class="row">
        <form action="{{ route('NotificationCenter') }}" method="POST">
            @csrf
            @foreach (\App\Http\Controllers\notification\notification_main::hasnotification(Auth::id()) as $notification)
                @if ($notification->AlertType == 1)
                    <div class="col-md-6 mb-4">
                        <div class="alert alert-icon alert-success alert-bg alert-inline">
                            <h4 class="alert-title">
                                <i class="fas fa-check"></i> انجام شد!
                            </h4>
                            {!! $notification->Continer !!}
                        </div>
                    </div>
                @elseif ($notification->AlertType == 2)
                    <div class="col-md-6 mb-4">
                        <div class="alert alert-icon alert-primary alert-bg alert-inline">
                            <h4 class="alert-title">
                                <i class="w-icon-cog"></i> !هشدار
                            </h4>
                            {!! $notification->Continer !!}
                        </div>
                    @elseif ($notification->AlertType == 3)
                        <div class="col-md-6 mb-4">
                            <div class="alert alert-icon alert-warning alert-bg alert-inline">
                                <h4 class="alert-title">
                                    <i class="w-icon-exclamation-triangle"></i>اخطار!
                                </h4>
                                {!! $notification->Continer !!}
                            </div>
                        </div>
                    @elseif ($notification->AlertType == 4)
                        <div class="col-md-6 mb-4">
                            <div class="alert alert-icon alert-error alert-bg alert-inline">
                                <h4 class="alert-title">
                                    <i class="w-icon-times-circle"></i>خطر!
                                </h4> {!! $notification->Continer !!}
                            </div>
                        </div>
                @endif
            @endforeach
        </form>
    </div>

@endif
@if ($errors->any())
    <div class="col-md-6 mb-4">
        <div class="alert alert-icon alert-error alert-bg alert-inline">
            <h4 class="alert-title">
                <i class="w-icon-times-circle"></i>{!! __('error alert') !!}
            </h4>
            @foreach ($errors->all() as $error)
                <li>{!! $error !!}</li>
            @endforeach
        </div>
    </div>

@endif
@if (session('error'))

    <div class="col-md-6 mb-4">
        <div class="alert alert-icon alert-error alert-bg alert-inline">
            <h4 class="alert-title">
                <i class="w-icon-times-circle"></i>{!! __('error alert') !!}
            </h4>
            @if ($errors->all() == [])
                <li>{!! session('error') !!}</li>
            @else
                @foreach ($errors->all() as $error)
                    <li>{!! session('error') !!}</li>
                @endforeach
            @endif
        </div>
    </div>

@endif
@if (session('lic_error'))
    <div class="col-md-6 mb-4">
        <div class="alert alert-icon alert-error alert-bg alert-inline">
            <h4 class="alert-title">
                <i class="w-icon-times-circle"></i>{!! __('license permission') !!}
            </h4>
            @foreach ($errors->all() as $error)
                <li>{!! session('lic_error') !!}</li>
            @endforeach
        </div>
    </div>

@endif
@if (session('success'))
    <div class="col-md-6 mb-4">
        <div class="alert alert-icon alert-success alert-bg alert-inline">
            <h4 class="alert-title">
                <i class="fas fa-check"></i> {!! __('success alert') !!}
            </h4>
            {!! session('success') !!}
        </div>
    </div>
@endif
@if (isset($success))
    <div class="col-md-6 mb-4">
        <div class="alert alert-icon alert-success alert-bg alert-inline">
            <h4 class="alert-title">
                <i class="fas fa-check"></i> {!! __('success alert') !!}
            </h4>
            {!! $success !!}
        </div>
    </div>
@endif

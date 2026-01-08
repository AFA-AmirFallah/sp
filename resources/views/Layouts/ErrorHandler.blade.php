@if (Auth::check())

    <form action="{{ route('NotificationCenter') }}" method="POST">
        @csrf
        @foreach (\App\Http\Controllers\notification\notification_main::hasnotification(Auth::id()) as $notification)
            @if ($notification->AlertType == 1)
                @if (\App\myappenv::DashboardTheme == 'Theme2')
                    <div class="bs-toast toast fade show" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="toast-header bg-success end-0 top-0">
                            <img src="/T1assets/img/avatars/1.png" class="d-block w-px-20 h-auto rounded me-2"
                                alt="">
                            <div class="me-auto fw-semibold">عملیات موفق</div>
                            <small>پیام سامانه</small>
                            <button type="button" class="btn-close" data-bs-dismiss="toast"
                                aria-label="Close"></button>
                        </div>
                        <div class="toast-body">{!! $notification->Continer !!}
                        </div>
                    </div>
                @else
                    <div class="alert alert-success" role="alert">
                        <button style="left: 10px;top: 10px;position: absolute;" type="submit" name="delete" value="{!! $notification->id !!}"
                            class="close">
                            <span aria-hidden="true">×</span>
                        </button>
                        {!! $notification->Continer !!}
                        <button style="left: 10px;top: 10px;position: absolute;" type="button" class="close" data-dismiss="alert"
                            aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>

                    </div>
                @endif
            @elseif ($notification->AlertType == 2)
                @if (\App\myappenv::DashboardTheme == 'Theme2')
                    <div class="bs-toast toast fade show" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="toast-header bg-info">
                            <img src="/T1assets/img/avatars/1.png" class="d-block w-px-20 h-auto rounded me-2"
                                alt="">
                            <div class="me-auto fw-semibold">عملیات موفق</div>
                            <small>پیام سامانه</small>
                            <button type="button" class="btn-close" data-bs-dismiss="toast"
                                aria-label="Close"></button>
                        </div>
                        <div class="toast-body">{!! $notification->Continer !!}
                        </div>
                    </div>
                @else
                    <div class="alert alert-info" role="alert">
                        <button style="left: 10px;top: 10px;position: absolute;" type="submit" name="delete" value="{!! $notification->id !!}"
                            class="close">
                            <span aria-hidden="true">×</span>
                        </button>
                        {!! $notification->Continer !!}
                        <button style="left: 10px;top: 10px;position: absolute;" type="button" class="close" data-dismiss="alert"
                            aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>

                    </div>
                @endif
            @elseif ($notification->AlertType == 3)
                @if (\App\myappenv::DashboardTheme == 'Theme2')
                    <div class="bs-toast toast fade show" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="toast-header bg-warning">
                            <img src="/T1assets/img/avatars/1.png" class="d-block w-px-20 h-auto rounded me-2"
                                alt="">
                            <div class="me-auto fw-semibold">عملیات موفق</div>
                            <small>پیام سامانه</small>
                            <button type="button" class="btn-close" data-bs-dismiss="toast"
                                aria-label="Close"></button>
                        </div>
                        <div class="toast-body">{!! $notification->Continer !!}
                        </div>
                    </div>
                @else
                    <div class="alert alert-warning" role="alert">
                        <button style="left: 10px;top: 10px;position: absolute;" type="submit" name="delete" value="{!! $notification->id !!}"
                            class="close">
                            <span aria-hidden="true">×</span>
                        </button>
                        {!! $notification->Continer !!}
                        <button style="left: 10px;top: 10px;position: absolute;" type="button" class="close" data-dismiss="alert"
                            aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>

                    </div>
                @endif
            @elseif ($notification->AlertType == 4)
                @if (\App\myappenv::DashboardTheme == 'Theme2')
                    <div class="bs-toast toast fade show" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="toast-header bg-danger">
                            <img src="/T1assets/img/avatars/1.png" class="d-block w-px-20 h-auto rounded me-2"
                                alt="">
                            <div class="me-auto fw-semibold">عملیات موفق</div>
                            <small>پیام سامانه</small>
                            <button type="button" class="btn-close" data-bs-dismiss="toast"
                                aria-label="Close"></button>
                        </div>
                        <div class="toast-body">{!! $notification->Continer !!}
                        </div>
                    </div>
                @else
                    <div class="alert alert-danger" role="alert">
                        <button style="left: 10px;top: 10px;position: absolute;" type="submit" name="delete" value="{!! $notification->id !!}"
                            class="close">
                            <span aria-hidden="true">×</span>
                        </button>
                        {!! $notification->Continer !!}
                        <button style="left: 10px;top: 10px;position: absolute;" type="button" class="close" data-dismiss="alert"
                            aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>

                    </div>
                @endif
            @endif
        @endforeach
    </form>
@endif
@if ($errors->any())
    @if (\App\myappenv::DashboardTheme == 'Theme2')
        <div class="bs-toast toast fade show" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header bg-danger">
                <img src="/T1assets/img/avatars/1.png" class="d-block w-px-20 h-auto rounded me-2" alt="">
                <div class="me-auto fw-semibold">{!! __('error alert') !!} </div>
                <small>پیام سامانه</small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                @foreach ($errors->all() as $error)
                    <li>{!! $error !!}</li>
                @endforeach
            </div>
        </div>
    @else
        <div class="alert alert-danger" role="alert">
            <h4>{!! __('error alert') !!} </h4>
            @foreach ($errors->all() as $error)
                <li>{!! $error !!}</li>
            @endforeach
            <button style="left: 10px;top: 10px;position: absolute;" type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
    @endif

@endif
@if (session('error'))
    @if (\App\myappenv::DashboardTheme == 'Theme2')
        <div class="bs-toast toast fade show" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header bg-danger">
                <img src="/T1assets/img/avatars/1.png" class="d-block w-px-20 h-auto rounded me-2" alt="">
                <div class="me-auto fw-semibold">{!! __('error alert') !!} </div>
                <small>پیام سامانه</small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                {!! session('error') !!}
            </div>
        </div>
    @else
        <div class="bs-toast toast fade show alert alert-danger " role="alert">
            <h4>{!! __('error alert') !!} </h4>
            <li> {!! session('error') !!}</li>
        </div>
    @endif
@endif
@if (session('lic_error'))
    <div class="alert alert-danger" role="alert">
        <h4>{!! __('license permission') !!} </h4>
        <li> {!! session('lic_error') !!}</li>
        <button style="left: 10px;top: 10px;position: absolute;" type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div>
@endif
@if (session('success'))
    @if (\App\myappenv::DashboardTheme == 'Theme2')
        <div class="bs-toast toast fade show" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header bg-success">
                <img src="/T1assets/img/avatars/1.png" class="d-block w-px-20 h-auto rounded me-2" alt="">
                <div class="me-auto fw-semibold">{!! __('success alert') !!} </div>
                <small>پیام سامانه</small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                {!! session('success') !!}
            </div>
        </div>
    @else
        <div class="alert alert-success" role="alert">
            <h4> {!! __('success alert') !!}</h4>
            <li>{!! session('success') !!}</li>
            <button style="left: 10px;top: 10px;position: absolute;" type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
    @endif
@endif
@if (isset($success))
    @if (\App\myappenv::DashboardTheme == 'Theme2')
        <div class="bs-toast toast fade show" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header bg-success">
                <img src="/T1assets/img/avatars/1.png" class="d-block w-px-20 h-auto rounded me-2" alt="">
                <div class="me-auto fw-semibold">{!! __('success alert') !!} </div>
                <small>پیام سامانه</small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                {!! $success !!}
            </div>
        </div>
    @else
        <div class="alert alert-success" role="alert">
            <h4> {!! __('success alert') !!}</h4>
            <li>{!! $success !!}</li>
            <button style="left: 10px;top: 10px;position: absolute;" type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
    @endif
@endif
@if (isset($error))
    @if (\App\myappenv::DashboardTheme == 'Theme2')
        <div class="bs-toast toast fade show" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header bg-danger">
                <img src="/T1assets/img/avatars/1.png" class="d-block w-px-20 h-auto rounded me-2" alt="">
                <div class="me-auto fw-semibold">{!! __('success alert') !!} </div>
                <small>پیام سامانه</small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                {!! $error !!}
            </div>
            <button style="left: 10px;top: 10px;position: absolute;" type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
    @else
        <div class="alert alert-danger" role="alert">
            <h4> {!! __('error alert') !!} </h4>
            <li>{!! $error !!}</li>
            <button style="left: 10px;top: 10px;position: absolute;" type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
    @endif
@endif

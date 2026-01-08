@php
    $Persian = new App\Functions\persian();
@endphp
@extends('Theme2.Layouts.MainLayout')

<!-- Content -->
@section('Content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 breadcrumb-wrapper mb-2">
            <span class="text-muted fw-light"><a href="{{route('tikets')}} ">{{ __('Ticket') }}</a>   /</span> {{ __('TicketView') }}

        </h4>

        <div class="row overflow-hidden">
            <div class="col-12">
                <ul class="timeline timeline-center mt-5">
                    <li class="timeline-item mb-md-4 mb-5">
                        <span class="timeline-indicator timeline-indicator-primary" data-aos="zoom-in" data-aos-delay="200">
                            <i class="bx bx-paint"></i>
                        </span>
                        @if ($MainTicket->FromUser == Auth::ID())
                            <div class="timeline-event card p-0" data-aos="fade-right">
                            @else
                                <div class="timeline-event card p-0" data-aos="fade-left">
                        @endif

                        <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
                            <h6 class="card-title mb-0">{{ $MainTicket->Subject }}</h6>
                            <div class="meta primary-font">
                                <span class="badge rounded-pill bg-label-primary">شروع تیکت</span>

                            </div>
                        </div>
                        <div class="card-body">
                            <p class="mb-2">
                                {{ $MainTicket->Text }}
                            </p>
                        </div>
                        <div class="timeline-event-time"> {{ $Persian->MyPersianDate($MainTicket->CreateDate) }}</div>
                    </li>
                    @foreach ($SubTickets as $SubTicket)
                        <li class="timeline-item mb-md-4 mb-5">
                            <span class="timeline-indicator timeline-indicator-primary" data-aos="zoom-in"
                                data-aos-delay="200">
                                <i class="bx bx-paint"></i>
                            </span>
                            @if ($SubTicket->FromUser == Auth::ID())
                                <div class="timeline-event card p-0" data-aos="fade-right">
                                @else
                                    <div class="timeline-event card p-0" data-aos="fade-left">
                            @endif

                            <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
                                <h6 class="card-title mb-0"> <img class="rounded-circle" width="50px"
                                        src="{{ $SubTicket->avatar }}" alt="Avatar"> {{ $SubTicket->UserInfoName }} </h6>
                            </div>
                            <div class="card-body">
                                <p class="mb-2">
                                    {{ $SubTicket->Text }}
                                </p>

                            </div>
                            <div class="timeline-event-time"> {{ $Persian->MyPersianDate($SubTicket->CreateDate) }}</div>
                        </li>
                    @endforeach
                    @if ($MainTicket->State < 100)
                        <li class="timeline-item mb-md-4 mb-5">
                            <span class="timeline-indicator timeline-indicator-danger" data-aos="zoom-in"
                                data-aos-delay="200">
                                <i class="bx bx-line-chart"></i>
                            </span>

                            <div class="timeline-event card p-0" data-aos="fade-right">
                                <h6 class="card-header gradient-purple-indigo 0-hidden pb-80">پاسخ / اتمام گفتگو</h6>

                                <div class="card-body">
                                    <form method="post">
                                        <p class="mb-2 pb-1">پاسخ خود را تایپ کنید.</p>
                                        <textarea placeholder="پاسخ به تیکت" required name="cee" class="form-control"></textarea>
                                        <hr>
                                        <button id="identifier" class="btn btn-sm btn-success" name="submit" type="submit"
                                            value="replay">{{ __('SendReply') }}</button>
                                        <button class="btn btn-primary btn-sm" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseExample" aria-expanded="false"
                                            aria-controls="collapseExample">
                                            اتمام گفتگو
                                        </button>
                                        @csrf
                                    </form>
                                    <form method="post">
                                        @csrf
                                        <div class="collapse" id="collapseExample">
                                            <ul class="list-group list-group-flush mt-3">
                                                <li class="list-group-item d-flex justify-content-between flex-wrap">
                                                    <span> بستن با کیفیت عالی </span>
                                                    <button name="CloseTiket" value="5"
                                                        class="btn btn-sm btn-success">ثبت و اتمام</button>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between flex-wrap">
                                                    <span> بستن با کیفیت خوب </span>
                                                    <button name="CloseTiket" value="4"
                                                        class="btn btn-sm btn-info ">ثبت و اتمام</button>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between flex-wrap">
                                                    <span> بستن با کیفیت متوسط </span>
                                                    <button name="CloseTiket" value="3"
                                                        class="btn btn-sm btn-primary ">ثبت و اتمام</button>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between flex-wrap">
                                                    <span> بستن با کیفیت بد </span>
                                                    <button name="CloseTiket" value="2"
                                                        class="btn btn-sm btn-warning ">ثبت و اتمام</button>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between flex-wrap">
                                                    <span> بستن با کیفیت افتضاح </span>
                                                    <button name="CloseTiket" value="1"
                                                        class="btn btn-sm btn-danger ">ثبت و اتمام</button>
                                                </li>
                                            </ul>
                                        </div>
                                    </form>

                                </div>
                                <div class="timeline-event-time"></div>
                            </div>
                        </li>
                    @else
                        <li class="timeline-item mb-md-4 mb-5">
                            <span class="timeline-indicator timeline-indicator-danger" data-aos="zoom-in"
                                data-aos-delay="200">
                                <i class="bx bx-line-chart"></i>
                            </span>

                            <div class="timeline-event card p-0" data-aos="fade-right">
                                <h6 class="card-header gradient-purple-indigo 0-hidden pb-80"> تیکت بسته شده! </h6>
                                <div class="timeline-event-time"></div>
                            </div>
                        </li>
                    @endif

                </ul>
            </div>
        </div>
    </div>
@endsection
@section('EndScripts')
@endsection

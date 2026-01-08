@php
    $Persian = new App\Functions\persian();
@endphp
@extends('Theme2.Layouts.MainLayout')

<!-- Content -->
@section('Content')

    <form id="submitform" method="post">
        @csrf
        <div class="modal-onboarding modal fade animate__animated" id="onboardingHorizontalSlideModal" tabindex="-1"
            aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content text-center">
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div id="modalHorizontalCarouselControls" class="carousel slide pb-4 mb-2" data-bs-interval="false">
                        <ol class="carousel-indicators">
                            <li data-bs-target="#modalHorizontalCarouselControls" data-bs-slide-to="0"> </li>
                            <li data-bs-target="#modalHorizontalCarouselControls" data-bs-slide-to="1"> </li>
                            <li data-bs-target="#modalHorizontalCarouselControls" data-bs-slide-to="2" class="active"> </li>
                        </ol>
                        <div class="carousel-inner">
                            <div class="carousel-item ">
                                <div class="onboarding-horizontal">
                                    <div class="onboarding-media">
                                        <img src="../../assets/img/illustrations/boy-with-rocket-light.png"
                                            alt="boy-with-rocket-light" width="273" class="img-fluid"
                                            data-app-light-img="illustrations/boy-with-rocket-light.png"
                                            data-app-dark-img="illustrations/boy-with-rocket-dark.png">
                                    </div>
                                    <div class="onboarding-content">
                                        <h4 class="onboarding-title text-body secondary-font">ثبت درخواست</h4>
                                        <div class="onboarding-info lh-2">
                                            لطفا میزان اولویت درخواست خود را مشخص فرمایید. درخواست های با اهمیت بالاتر در
                                            اولیت
                                            بررسی کارشناسان ما قرار خواهد گرفت.
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="mb-3">
                                                    <label for="roleEx4" class="form-label">اولویت</label>
                                                    <select class="form-select" tabindex="0" name="TicketPeriority">
                                                        @foreach (\App\myappenv::TicketPeriority as $Periority)
                                                            <option value="{{ $Periority[0] }}">
                                                                {{ __($Periority[1]) }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="mb-3">
                                                    <label for="nameEx4" class="form-label">نام کامل
                                                        شما</label>
                                                    <input class="form-control" placeholder="نام کامل خود را وارد کنید ..."
                                                        type="text"
                                                        value="{{ Auth::user()->Name }}  {{ Auth::user()->Family }}"
                                                        tabindex="0" id="nameEx4">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-0">

                                            <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">
                                                بستن
                                            </button>
                                            <button type="submit" name="submit" value="add" onclick="savecheck()"
                                                class="btn btn-primary">ثبت</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <div class="onboarding-horizontal">
                                    <div class="onboarding-media">
                                        <img src="../../assets/img/illustrations/girl-doing-yoga-light.png"
                                            alt="boy-with-rocket-light" width="273" class="img-fluid"
                                            data-app-light-img="illustrations/girl-doing-yoga-light.png"
                                            data-app-dark-img="illustrations/girl-doing-yoga-dark.png">
                                    </div>
                                    <div class="onboarding-content">
                                        <h4 class="onboarding-title text-body secondary-font">متن درخواست</h4>
                                        <div class="onboarding-info lh-2">
                                            لطفا متن درخواست خود را وارد فرمایید. تا در اسرع وقت همکاران ما بررسی نموده و
                                            پاسخگوی شما باشند. خواهشمند خواهشمند است مطلب خود را به صورت کامل تایپ بفرمایید.
                                        </div>

                                        <div style="text-align: right" class="row ">
                                            <div>
                                                <label for="defaultFormControlInput" class="form-label">موضوع
                                                    درخواست</label>
                                                <input type="text" required class="form-control" id="subject"
                                                    name="subject" placeholder="موضوع درخواست"
                                                    aria-describedby="defaultFormControlHelp">
                                                <div id="defaultFormControlHelp" class="form-text">
                                                    متن درخواست
                                                </div>
                                            </div>
                                            <div>
                                                <textarea class="form-control" required name="ce" id="TiketText" rows="3"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-item active">
                                <div class="onboarding-horizontal">
                                    <div class="onboarding-media">
                                        <img src="../../assets/img/illustrations/boy-with-laptop-light.png"
                                            alt="boy-with-laptop-light" width="273" class="img-fluid"
                                            data-app-light-img="illustrations/boy-with-laptop-light.png"
                                            data-app-dark-img="illustrations/boy-with-laptop-dark.png">
                                    </div>
                                    <div class="onboarding-content">
                                        <h4 class="onboarding-title text-body secondary-font">چه چیزی را میخواهید با ما در
                                            میان
                                            بگذارید</h4>
                                        <div class="onboarding-info lh-2">
                                            لطفا مشخص بفرمایید در چه خصوصی می خواهید با ما ارتباط داشته باشید.
                                            بر اساس موضعی که شما مشخص میکنید همکاران ما پاسخگوی شما خواهند بود!
                                        </div>
                                        <div class="row">


                                            <label for="roleEx6" class="form-label">تعیین نوع درخواست</label>
                                            <select class="form-select" tabindex="0" name="ToUser">
                                                @foreach ($ticket_recivers as $ticket_reciver)
                                                    <option value="{{ $ticket_reciver->id }}">
                                                        {{ $ticket_reciver->TicketText }}
                                                    </option>
                                                @endforeach
                                            </select>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a class="carousel-control-prev" href="#modalHorizontalCarouselControls" role="button"
                            data-bs-slide="prev">
                            <i class="bx bx-chevrons-left lh-1"></i><span>بعدی</span>
                        </a>
                        <a class="carousel-control-next" href="#modalHorizontalCarouselControls" role="button"
                            data-bs-slide="next">
                            <span>قبلی</span><i class="bx bx-chevrons-right lh-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div style="display: inline-flex">
                <h5 class="card-header gradient-purple-indigo 0-hidden pb-80">لیست تیکت ها</h5>
                <button type="button" class="btn btn-primary" style="position: absolute;left: 10px;top: 10px;"
                    data-bs-toggle="modal" data-bs-target="#onboardingHorizontalSlideModal">
                    افزودن تیکت
                </button>
            </div>
            <div class="table-responsive text-nowrap">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>کد</th>
                            <th>موضوع</th>
                            <th>تاریخ</th>
                            <th>اولویت</th>
                            <th>وضعیت</th>
                            <th>عملیات</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @if (count($Tickets) == 0)
                            <td colspan="6" style="text-align:center">داده ای برای نمایش وجود ندارد</td>
                        @else
                            @foreach ($Tickets as $Ticket)
                                <tr id="tr_{{ $Ticket->TicketID }}">
                                    <td id="id_{{ $Ticket->TicketID }}">
                                        <a href="{{ route('tikets', $Ticket->TicketID) }}">
                                            {{ $Ticket->TicketID }}
                                        </a>
                                    </td>
                                    <td id="Subject_{{ $Ticket->TicketID }}" name="{{ $Ticket->Subject }}">
                                        {{ $Ticket->Subject }}</td>
                                    <td id="CreateDate_{{ $Ticket->TicketID }}" name="{{ $Ticket->CreateDate }}">
                                        {{ $Persian->MyPersianDate($Ticket->CreateDate) }}</td>
                                    <td id="Priority_{{ $Ticket->TicketID }}" name="{{ $Ticket->Priority }}">
                                        @foreach (\App\myappenv::TicketPeriority as $Periority)
                                            @if ($Periority[0] == $Ticket->Priority)
                                                {{ __($Periority[1]) }}
                                            @endif
                                        @endforeach
                                    </td>
                                    <td id="State_{{ $Ticket->State }}" name="{{ $Ticket->State }}">
                                        @foreach (\App\myappenv::TicketState as $State)
                                            @if ($State[0] == $Ticket->State)
                                                @switch($Ticket->State)
                                                    @case(1)
                                                    <span class="badge bg-label-primary me-1">  {{ __($State[1]) }}</span>
                                                        @break
                                                    @case(0)
                                                    <span class="badge bg-label-warning me-1">{{ __($State[1]) }}</span>
                                                        @break
                                                   @case(100)
                                                   <span class="badge bg-label-success me-1">{{ __($State[1]) }} </span>
                                                        @break
                                                    @default
                                                        
                                                @endswitch
                                              
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        <a href="{{ route('tikets', $Ticket->TicketID) }}">
                                            نمایش
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('EndScripts')
    <script>
         function savecheck(){
            if( $('#subject').val()=='' ||  $('#subject').val()== null  ){
                alert('لطفا موضوع تیکیت را وارد کنید!');
            }else if($('#TiketText').val()=='' ||  $('#TiketText').val()== null) {
                alert('لطفا متن تیکیت را وارد کنید!');
            }
         }
    </script>
@endsection

@extends('Layouts.MainPage')
@section('page-header-left')
    <h3>{{ __('Pats') }}
        <small>{{ __('My pats') }}</small>
    </h3>
@endsection
@section('MainCountent')
    @if (Auth::user()->Role == \App\myappenv::role_worker)
        @include('Dashboard.layouts.worker_top_bar')
    @endif
    <input class="nested" id="main-menu" value="#patiantworks">
    <input class="nested" id="sub-menu" value="#patiant_list">
    <section class="contact-list">
        <div class="row">
            <div class="col-md-12 mb-4">
                <div class="card">
                    <div class="card text-left">
                        <div class="card-header gradient-purple-indigo 0-hidden pb-80 ">
                            <h5 class="text-white"><i class=" header-icon i-Business-ManWoman"></i>
                                {{ __('list of my paths') }}</h5>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="ul-contact-list" class="{{ \App\myappenv::MainTableClass }}" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Name') }}</th>
                                            <th>{{ __('Family') }}</th>
                                            <th>{{ __('Mobile No') }}</th>
                                            <th>{{ __('Actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($Pats as $Pat)
                                            <tr>
                                                <td>{{ $Pat->Name }}</td>
                                                <td>{{ $Pat->Family }}</td>
                                                <td>{{ $Pat->MobileNo }}</td>
                                                <td>
                                                    <button type="button" class="btn bg-white _r_btn border-0"
                                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <span class="_dot _inline-dot bg-primary"></span>
                                                        <span class="_dot _inline-dot bg-primary"></span>
                                                        <span class="_dot _inline-dot bg-primary"></span>
                                                    </button>
                                                    <div class="dropdown-menu" x-placement="bottom-start"
                                                        style="position: absolute; text-align: right; transform: translate3d(0px, 33px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                        @if (\App\myappenv::Lic['SmartInvoice'])
                                                            @if (Auth::user()->Role >= App\myappenv::role_admin)
                                                                <a class="dropdown-item ul-widget__link--font"
                                                                    @if (!$ShiftEnable) disabled="" @endif
                                                                    href="{{ Route('MakeSmartInvoice', $Pat->UserNameMain) }}">
                                                                    <i class="i-Diploma"> </i>
                                                                    {{ __('Smart invoice') }}
                                                                </a>
                                                            @endif
                                                        @endif
                                                        @if (\App\myappenv::Lic['SmartInvoice'])
                                                            @if (Auth::user()->Role != App\myappenv::role_customer)
                                                                <a class="dropdown-item ul-widget__link--font"
                                                                    href="{{ Route('Workflow', $Pat->UserNameMain) }}">
                                                                    <i class="i-Over-Time"> </i>
                                                                    روال کار
                                                                </a>
                                                            @endif
                                                        @endif
                                                        @if (Auth::user()->Role >= App\myappenv::role_superviser)
                                                            <a class="dropdown-item ul-widget__link--font"
                                                                @if (!$ShiftEnable) disabled="" @endif
                                                                href="{{ Route('PatShift', $Pat->UserNameMain) }}">
                                                                <i class="i-Bar-Chart-4"> </i>
                                                                {{ __('Assign shift') }}
                                                            </a>

                                                            <a class="dropdown-item ul-widget__link--font"
                                                                @if (!$ShiftEnable) disabled="" @endif
                                                                href="{{ Route('RentDevice', $Pat->UserNameMain) }}">
                                                                <i class="i-Fluorescent"> </i>
                                                                {{ __('device contract') }}
                                                            </a>
                                                        @endif
                                                        @if (\App\myappenv::version < 3)
                                                            <a class="dropdown-item ul-widget__link--font" href="#"
                                                                onclick="window.open('{{ url('/') . '/filemanager?type=file&usertraget=' . $Pat->UserNameMain }}',
                                                                            'newwindow',
                                                                            'width=1000,height=600');
                                                                 return false;">
                                                                <i class="i-Folder-Open"></i>
                                                                فولدر بیمار
                                                            </a>
                                                        @endif
                                                        <a class="dropdown-item ul-widget__link--font"
                                                            href="{{ Route('PatDoc', $Pat->UserNameMain) }}">
                                                            <i class="i-Data-Save"> </i>
                                                            {{ __('Electronic document') }}
                                                        </a>
                                                        @if (Auth::user()->Role >= App\myappenv::role_admin)
                                                            <div class="dropdown-divider"></div>
                                                            <a class="dropdown-item ul-widget__link--font"
                                                                href="{{ Route('UserProfile', $Pat->UserNameMain) }}">
                                                                <i class="i-Duplicate-Layer"></i>
                                                                {{ __('User edite') }}</a>
                                                    </div>
                                        @endif
                                        </tr>
                                        @endforeach
                                    </tbody>

                                </table>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
@section('page-js')
    @if (app()->getLocale() == 'fa')
        <script src="{{ asset('assets/js/vendor/datatables.min.fa.js') }}"></script>
    @else
        <script src="{{ asset('assets/js/vendor/datatables.min.js') }}"></script>
    @endif
    <!-- page script -->
    <script src="{{ asset('assets/js/tooltip.script.js') }}"></script>

    <script>
        $('#ul-contact-list').DataTable();
    </script>
@endsection

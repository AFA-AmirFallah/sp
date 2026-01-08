@php
    $Persian = new App\Functions\persian();
@endphp
@extends('Layouts.MainPage')
@section('page-header-left')
    <h3>{{ __('Pats') }}
        <small>{{ __('My pats') }}</small>
    </h3>
@endsection
@section('MainCountent')
    <input class="nested" id="main-menu" value="#patiantworks">
    <input class="nested" id="sub-menu" value="#patiant_shift_done">
    @if (Auth::user()->Role == \App\myappenv::role_customer)
        <input type="text" class="nested" id="UserName" value="{{ Auth::id() }}">
        <input type="text" class="nested" id="UserName_page" value="{{ Auth::id() }}">
        <div id="app">
            <patascustomer></patascustomer>
        </div>
    @else
    @endif
    @if ($Role == 'Admin')
        <div class="ul-card-list__modal">
            <div class="modal fade modal_detail_to_confirm_work" tabindex="-1" role="dialog"
                aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <form method="post">
                            @csrf
                            <div id="Modaldiv" style="text-align: center" class="modal-body">

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <section class="contact-list">
            <div class="row">
                <div class="col-md-12 mb-4">
                    <div class="card text-left">
                        <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                            <h5 class="text-white"><i class=" header-icon i-Check"></i> {{ __('Jobs done') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="ul-contact-list" class="{{ \App\myappenv::MainTableClass }}" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>کد خدمت</th>
                                            <th>{{ __('Personel') }}</th>
                                            <th>{{ __('Pat') }}</th>
                                            <th>{{ __('Assigner') }}</th>
                                            <th>{{ __('Service') }}</th>
                                            <th>{{ __('StartRespns') }}</th>
                                            <th>{{ __('EndRespns') }}</th>
                                            <th>{{ __('balance') }}</th>
                                            <th>{{ __('Actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($TodoShifts as $TodoShift)
                                            <tr>
                                                <td>{{ $TodoShift->service_id }}</td>
                                                <td>{{ $TodoShift->ResponserName }} {{ $TodoShift->ResponserFamily }}

                                                </td>
                                                <td>{{ $TodoShift->OwnerName }} {{ $TodoShift->OwnerFamily }}
                                                    @if ($TodoShift->EndNote == '')
                                                        <i class="i-Electricity text-warning"
                                                            onclick="shownote('اعلام نظر نشده')" style="font-size: 30px;">
                                                        </i>
                                                    @else
                                                        @php
                                                            $end_note = json_decode($TodoShift->EndNote);
                                                            $customer_note = $end_note->customer_note;
                                                            $result = $customer_note->result;
                                                            $MessageText = $customer_note->MessageText;
                                                        @endphp
                                                        @if ($result == 1)
                                                            <i class="i-Geek1 text-success"
                                                                onclick="shownote(`{{ $MessageText }}`)"
                                                                style="font-size: 30px;">
                                                            @elseif($result == 0)
                                                                <i class="i-Angry text-danger"
                                                                    onclick="shownote(`{{ $MessageText }}`)"
                                                                    style="font-size: 30px;">
                                                        @endif
                                                    @endif

                                                </td>
                                                <td>{{ $TodoShift->UserInfoName }} {{ $TodoShift->UserInfoFamily }}
                                                </td>
                                                <td>{{ $TodoShift->RespnsTypeName }}</td>
                                                <td>{{ $Persian->MyPersianDate($TodoShift->StartRespns, true) }}</td>
                                                <td>{{ $Persian->MyPersianDate($TodoShift->EndRespns, true) }}</td>
                                                <td>{{ number_format(abs($TodoShift->Mony)) }}</td>
                                                <td>
                                                    <button type="button" class="btn bg-white _r_btn border-0"
                                                        onclick="loadmodaldata('{{ $TodoShift->RelatedCredite }}','{{ $TodoShift->OwnerUserID }}','{{ $TodoShift->ResponserID }}','{{ $TodoShift->CreateDate }}','{{ $TodoShift->ResponserName }} {{ $TodoShift->ResponserFamily }}','{{ $TodoShift->OwnerName }} {{ $TodoShift->OwnerFamily }}','{{ $TodoShift->RespnsTypeName }}')"
                                                        data-toggle="modal" data-target=".modal_detail_to_confirm_work"
                                                        aria-haspopup="true" aria-expanded="false">
                                                        <span class="_dot _inline-dot bg-primary"></span>
                                                        <span class="_dot _inline-dot bg-primary"></span>
                                                        <span class="_dot _inline-dot bg-primary"></span>
                                                    </button>

                                            </tr>
                                        @endforeach
                                    </tbody>

                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
        <script>
            function shownote($text) {
                alert($text);
            }

            function loadmodaldata($RelatedCredit, $OwnerUserID, $ResponserID, $CreateDate, $worker, $Patant, $Work) {
                var $loader = '<div class="loader-bubble loader-bubble-primary m-2"></div>';
                $('#Modaldiv').html($loader);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.post('<?php echo e(route('ajax')); ?>', {
                        AjaxType: 'GetUserCredite',
                        ReferenceId: $RelatedCredit,
                        OwnerUserID: $OwnerUserID,
                        ResponserID: $ResponserID,
                        CreateDate: $CreateDate,
                        worker: $worker,
                        Patant: $Patant,
                        Work: $Work,
                    },

                    function(data, status) {
                        if (status == 'success') {
                            $('#Modaldiv').html(data);
                        } else {
                            alert('بروز مشکل در انجام عملیات!');
                            $('#Modaldiv').html('');
                        }
                    });

            }
        </script>
    @elseif($Role == 'Worker')
        <section class="contact-list">
            <div class="row">
                <div class="col-md-12 mb-4">
                    <div class="card text-left">
                        <div class="card-header gradient-purple-indigo 0-hidden pb-80" style="text-align: right">
                            <h5 class="text-white"><i class=" header-icon i-Check"></i>{{ __('Jobs done') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="ul-contact-list" class="{{ \App\myappenv::MainTableClass }}" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Pat') }}</th>
                                            <th>{{ __('Service') }}</th>
                                            <th>{{ __('StartRespns') }}</th>
                                            <th>{{ __('EndRespns') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($TodoShifts as $TodoShift)
                                            <tr>
                                                <td>{{ $TodoShift->OwnerName }} {{ $TodoShift->OwnerFamily }}</td>
                                                <td>{{ $TodoShift->RespnsTypeName }}</td>
                                                <td>{{ $Persian->MyPersianDate($TodoShift->StartRespns, true) }}</td>
                                                <td>
                                                    @if ($TodoShift->EndRespns == null)
                                                        خدمت به پایان نرسیده
                                                    @else
                                                        {{ $Persian->MyPersianDate($TodoShift->EndRespns, true) }}
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>

                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    @elseif($Role == 'Customer')
        <input type="text" class="nested" id="UserName" value="{{ Auth::id() }}">
        <input type="text" class="nested" id="UserName_page" value="{{ Auth::id() }}">
        <div id="app">
            <patascustomer></patascustomer>
        </div>
        <div class="ul-card-list__modal">
            <div class="modal fade modal_detail_to_confirm_work" tabindex="-1" role="dialog"
                aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <form method="post">
                            @csrf
                            <div id="Modaldiv" style="text-align: center" class="modal-body">
                                <div class="card">
                                    <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                                        <h5 class="text-white"><i class=" header-icon i-Administrator"></i>خدمت انجام شده
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="profile-details text-center">
                                            <img style="max-height: 100px;" id="useravatar" src=""
                                                class="img-fluid img-90 rounded-circle blur-up lazyloaded dropzone dropzone-area dz-clickable">
                                            <input type="hidden" name="_token"
                                                value="2gkbkDlrosSqPAfAKBYhhgiuXHg7r6ip88sZGlWK">
                                            <h4 id="worker_name" class="f-w-600 mb-0"></h4>
                                            <br>
                                            <h6 id="work_name" class="f-w-600 mb-0"></h6>
                                            <h6 id="start_end" class="f-w-600 mb-0"></h6>
                                        </div>
                                        <hr>
                                        <form method="post">
                                            @csrf
                                            <input id="serviceid" class="nested" name="serviceid">
                                            <div class="project-status">
                                                <div>
                                                    <h5 class="f-w-600"> ملاحظات نحوه انجام خدمت:</h5>
                                                </div>
                                                <div style="text-align: right">
                                                    <textarea id="MessageText" name="MessageText" class="form-control" placeholder="توضیحات نحوه انجام خدمت"
                                                        cols="37" rows="10"></textarea>
                                                    <br>
                                                    <div id="main_div" style="display: flex">

                                                        <button onclick="check_data('false')" type="button"
                                                            class="btn btn-danger" style="margin:auto;display:block"
                                                            name="submit" value="SendSms">
                                                            <i class="i-Thumbs-Down-Smiley" style="font-size: 50px;"></i>
                                                            ثبت عدم رضایت
                                                        </button>

                                                        <button onclick="check_data('true')" type="button"
                                                            class="btn btn-success" style="margin:auto;display:block"
                                                            name="submit" value="SendSms">
                                                            <i class="i-Thumbs-Up-Smiley" style="font-size: 50px;"> </i>
                                                            ثبت رضایت
                                                        </button>


                                                    </div>

                                                    <div id="acceptlevel" class="secondlevel nested"
                                                        style="display: flex" id="success_submit">
                                                        <button type="submit" class="btn btn-success"
                                                            style="margin:auto;display:block" name="submit"
                                                            value="1">

                                                            تایید خدمت با رضایت
                                                        </button>
                                                        <button onclick="canclesunmit()" type="button"
                                                            class="btn btn-danger" style="margin:auto;display:block"
                                                            name="submit">

                                                            انصراف
                                                        </button>

                                                    </div>
                                                    <div id="rejectlevel" class="secondlevel nested"
                                                        style="display: flex" id="success_submit">
                                                        <button type="submit" class="btn btn-warning"
                                                            style="margin:auto;display:block" name="submit"
                                                            value="0">
                                                            عدم رضایت از انجام خدمت
                                                        </button>
                                                        <button onclick="canclesunmit()" type="button"
                                                            class="btn btn-danger" style="margin:auto;display:block"
                                                            name="submit">
                                                            انصراف
                                                        </button>

                                                    </div>
                                                </div>


                                            </div>
                                        </form>
                                        <script>
                                            function canclesunmit() {
                                                $('.secondlevel').addClass('nested');
                                                $('#main_div').removeClass('nested');
                                            }

                                            function check_data(confirm) {
                                                if (confirm == 'true') {
                                                    $('#acceptlevel').removeClass('nested');
                                                    $('#main_div').addClass('nested');
                                                }
                                                if (confirm == 'false') {
                                                    if ($('#MessageText').val() == '') {
                                                        alert('لطفا در خصوص عدم رضایت خود توضیحاتی تایپ بفرمایید!');
                                                    } else {
                                                        $('#rejectlevel').removeClass('nested');
                                                        $('#main_div').addClass('nested');
                                                    }

                                                }
                                            }
                                        </script>

                                    </div>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <section class="contact-list">
            <div class="row">
                <div class="col-md-12 mb-4">
                    <div class="card text-left">
                        <div class="card-header gradient-purple-indigo 0-hidden pb-80" style="text-align: right">
                            <h5 class="text-white"><i class=" header-icon i-Check"></i>خدمات من</h5>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="ul-contact-list" class="{{ \App\myappenv::MainTableClass }}"
                                    style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>کد خدمت</th>
                                            <th>خدمت گیرنده</th>
                                            <th>خدمات دهنده</th>
                                            <th>{{ __('Service') }}</th>
                                            <th>{{ __('StartRespns') }}</th>
                                            <th>{{ __('EndRespns') }}</th>
                                            <th>{{ __('Actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($TodoShifts as $TodoShift)
                                            <tr>
                                                <td>{{ $TodoShift->id }}</td>
                                                <td>{{ Auth::user()->Name }} {{ Auth::user()->Family }}</td>
                                                <td>
                                                    <div class="ul-widget4__img">
                                                        <img src="{{ $TodoShift->workeravatar ?? App\myappenv::LoginUserAvatarPic }}"
                                                            id="userDropdown" alt="" data-toggle="dropdown"
                                                            aria-haspopup="true" aria-expanded="false">
                                                        {{ $TodoShift->ResponserName }} {{ $TodoShift->ResponserFamily }}
                                                    </div>
                                                </td>
                                                <td>{{ $TodoShift->RespnsTypeName }}</td>

                                                <td>{{ $Persian->MyPersianDate($TodoShift->StartRespns, true) }}</td>
                                                <td>
                                                    @if ($TodoShift->EndRespns == null)
                                                        خدمت به پایان نرسیده
                                                    @else
                                                        {{ $Persian->MyPersianDate($TodoShift->EndRespns, true) }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($TodoShift->EndNote != '')
                                                        <p>غیر قابل ویرایش</p>
                                                    @else
                                                        <button type="button" class="btn btn-success "
                                                            onclick="loadmodaldata('{{ $TodoShift->id }}', `{{ $TodoShift->workeravatar ?? App\myappenv::LoginUserAvatarPic }}`,`{{ $TodoShift->ResponserName }} {{ $TodoShift->ResponserFamily }}`,`{{ $TodoShift->RespnsTypeName }}`,`از :{{ $Persian->MyPersianDate($TodoShift->StartRespns, true) }} تا: {{ $Persian->MyPersianDate($TodoShift->EndRespns, true) }}`)"
                                                            data-toggle="modal"
                                                            data-target=".modal_detail_to_confirm_work">
                                                            تایید
                                                        </button>
                                                    @endif

                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>

                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
        <script>
            function loadmodaldata(serviceid, useravatar, worker_name, work_name, start_end) {
                $('#useravatar').attr('src', useravatar);
                $('#work_name').html(work_name);
                $('#worker_name').html(worker_name);
                $('#start_end').html(start_end);
                $('#serviceid').val(serviceid);
            }
        </script>
    @else
    @endif


@endsection
@section('page-js')
    <script>
        window.targetpage = 'PatShiftDone';
        window.main_username = $('#UserName').val();
        window.page_username = $('#UserName_page').val();
    </script>
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

@php
    $Persian = new App\Functions\persian();
@endphp
@extends('Layouts.MainPage')
@section('page-header-left')
@endsection
@section('MainCountent')
    <!-- Container-fluid starts-->
    <style>
        .search-result {
            position: absolute;
            background: aquamarine;
            overflow-y: scroll;
            height: 142px;
        }

        img.search_item_308 {
            display: none;
        }
    </style>

    <form method="post">
        @csrf
        <div class="container-fluid">
            <div class="card">
                <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                    گزارش عملکرد رقبا در تاریخ خاص
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-xl-3 col-md-4">{{ __('Start report date') }} </label>
                        <input class="form-control col-xl-4 col-md-3" required type="text" name="StartDate"
                            value="{{ old('StartDate') }}" autocomplete="off"
                            onfocus="Mh1PersianDatePicker.Show(this,'{{ $Persian->MyPersianDate(date('Y-m-d'), false, 'n') }}',)"
                            placeholder="{{ __('Start report date') }}" />
                    </div>
                    <div class="form-group row">
                        <label class="col-xl-3 col-md-4">{{ __('End report date') }} </label>
                        <input class="form-control col-xl-4 col-md-3" required type="text" name="EndDate"
                            value="{{ old('EndDate') }}" autocomplete="off"
                            onfocus="Mh1PersianDatePicker.Show(this,'{{ $Persian->MyPersianDate(date('Y-m-d'), false, 'n') }}',)"
                            placeholder="{{ __('End report date') }}" />

                    </div>
                    <div class="form-group row">
                        <label class="col-xl-3 col-md-4">رقیب</label>
                        <select class="form-control col-xl-4 col-md-3" name="ReportType" class="form-control">
                            <option value="0" selected>همه رقبا</option>
                            @foreach ($crawler_main_src as $crawler_main_item)
                                <option value="{{ $crawler_main_item->id }}">{{ $crawler_main_item->Name }}
                                </option>
                            @endforeach
                        </select>

                    </div>

                    <div class="form-group row col-md-3"></div>
                    <div class="form-group row col-md-6">
                        <button type="submit" class="btn btn-green" name="submit"
                            value="show_result">{{ __('Show Table') }}</button>
                    </div>
                    <div class="form-group row col-md-3"></div>
                </div>
            </div>
        </div>
    </form>
    <form method="POST">
        @csrf
        @foreach ($crawler_main_src as $competitor)
            @if ($competitor->Status == 1)
                <button type="submit" class="btn btn-primary" name="reindex" value="{{ $competitor->id }}">بررسی
                    {{ $competitor->Name }}</button>
            @else
                <button type="submit" class="btn btn-danger" name="reindex" value="{{ $competitor->id }}">بررسی
                    {{ $competitor->Name }}</button>
            @endif
        @endforeach
        <button type="submit" class="btn btn-danger" name="reindex" value="reindex">بررسی مجدد</button>
    </form>
    <hr>

    <div class="card">
        <div class="card-header gradient-purple-indigo 0-hidden pb-80">
            {{ $title }}
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="ul-contact-list" class="{{ \App\myappenv::MainTableClass }}" style="width:100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ __('Date') }}</th>
                            <th>رقیب</th>
                            <th>تایتل</th>
                            <th>تایتل</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $Rowno = 1;
                        @endphp
                        @foreach ($crawler_src as $crawler_item)
                            <tr>
                                <th><a href="{{ $crawler_item->TargetAddress }}" target="_blank">{{ $Rowno++ }}</a>
                                </th>
                                @php
                                    $update_date = $Persian->MyPersianDate($crawler_item->src_date);
                                    $create_date = $Persian->MyPersianDate($crawler_item->created_at);
                                @endphp
                                <td @if ($update_date == $create_date) style="background-color: yellow" @endif><a
                                        href="{{ $crawler_item->TargetAddress }}" target="_blank">به روز رسانی
                                        {{ $update_date }}
                                        <br>
                                        ثبت: {{ $create_date }}
                                    </a></td>
                                <td> <a href="{{ $crawler_item->TargetAddress }}" target="_blank">
                                        {{ $crawler_item->cname }}</a></td>
                                <td> <a href="{{ $crawler_item->TargetAddress }}" target="_blank">
                                        {{ $crawler_item->og_title }}</a></td>
                                <td><a href="{{ $crawler_item->TargetAddress }}"
                                        target="_blank">{{ $crawler_item->og_description }}</a> </td>
                            </tr>
                        @endforeach

                    </tbody>


                </table>
            </div>
        </div>
    </div>
@endsection

@section('page-js')
    <script src="{{ asset('assets/js/vendor/pickadate/picker.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/pickadate/picker.date.js') }}"></script>
    <script src="{{ url('/') }}/persian-datepicker/Mh1PersianDatePicker.js"></script>
@endsection
@section('bottom-js')
@endsection

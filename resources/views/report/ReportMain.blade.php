@php
    $Persian = new App\Functions\persian();
@endphp
@extends('Layouts.MainPage')
@section('page-header-left')
@endsection
@section('MainCountent')
    <form method="post">
        @csrf
        <div class="container-fluid">
            <div class="card">
                <div id="report_title" style="font-size: 18px;" class="card-header gradient-purple-indigo 0-hidden ">
                    انتخاب گزارش
                </div>
                <div class="card-body">
                    @foreach ($report_src as $report_Item)
                        <button type="button" class="btn   report_type"
                            id="{{ $report_Item->table_src }}">{{ $report_Item->report_name }}</button>
                    @endforeach
                    <hr>
                    <input type="text" id="report_type" class="d-none" name="report_type">
                    <div class="form-group row">
                        <label class="col-xl-2 col-md-4">{{ __('Start report date') }} </label>
                        <input required class="form-control col-xl-2 col-md-3" type="text" name="StartDate"
                            value="{{ old('StartDate') }}" autocomplete="off"
                            onfocus="Mh1PersianDatePicker.Show(this,'{{ $Persian->MyPersianDate(date('Y-m-d'), false, 'n') }}',)"
                            placeholder="{{ __('Start report date') }}" />
                        <label class="col-xl-2 col-md-4">{{ __('Financial index') }} </label>
                        <select name="CreditMod" class="form-control col-xl-4 col-md-3">
                            <option value="0">{{ __('--select--') }}</option>
                            @foreach ($UserCreditModMeta as $UserCreditModMetaItem)
                                @if ($UserCreditModMetaItem->ID == old('CreditMod') && old('CreditMod') != 0)
                                    <option value="{{ $UserCreditModMetaItem->ID }}" selected>
                                        {{ $UserCreditModMetaItem->ModName }}</option>
                                @else
                                    <option value="{{ $UserCreditModMetaItem->ID }}">{{ $UserCreditModMetaItem->ModName }}
                                    </option>
                                @endif
                            @endforeach
                        </select>

                    </div>
                    <div class="form-group row">
                        <label class="col-xl-2 col-md-4">{{ __('End report date') }} </label>
                        <input required class="form-control col-xl-2 col-md-3" type="text" name="EndDate"
                            value="{{ old('EndDate') }}" autocomplete="off"
                            onfocus="Mh1PersianDatePicker.Show(this,'{{ $Persian->MyPersianDate(date('Y-m-d'), false, 'n') }}',)"
                            placeholder="{{ __('End report date') }}" />
                        <label class="col-xl-2 col-md-4">{{ __('Report present') }} </label>
                        <select name="Showtype" class="form-control col-xl-4 col-md-3">
                            <option disabled value="1">{{ __('Show graph') }}</option>
                            <option value="2" selected>{{ __('Show Table') }}</option>
                        </select>

                    </div>
                    <div class="form-group row">
                        <button type="submit" class="btn btn-default" name="submit"
                            value="DaramadGraph">{{ __('Show') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
@section('page-js')
    <script>
        $(".report_type").on('click', function(event) {
            fun = $(this).attr('id');
            $('#report_type').val(fun);
            $(".report_type").removeClass('btn-success');
            $(this).addClass('btn_success');
            fun_id = '#' + fun;
            $(fun_id).addClass('btn-success');
            $('#report_title').html($(fun_id).html());

        });
    </script>
    <!-- page script -->
    <script src="{{ asset('assets/js/tooltip.script.js') }}"></script>

    <script>
        $('#ul-contact-list').DataTable();
    </script>

    <script src="{{ url('/') }}/persian-datepicker/Mh1PersianDatePicker.js"></script>
@endsection
@section('bottom-js')
@endsection

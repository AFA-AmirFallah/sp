@php
    $Persian = new App\Functions\persian();
@endphp
@extends('Layouts.MainPage')
@section('page-header-left')
@endsection
@section('MainCountent')
    <style>
        .label_red {
            color: red;
        }
    </style>
    @include('deal/objects/stepers_dealer', ['target_step' => 2, 'file_id' => $file_id])
    <div class="row">
        <div id="table-continer" class=" col-md-12">
            <div class="card o-hidden mb-4">
                <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                    <h3 id="Table-card-header" class="text-white  w-50 float-left card-title m-0"><i
                            class=" header-icon i-Business-Mens"></i> تماسهای ورودی مرتبط با این فایل </h3>


                </div>
                <div class="card-body">
                    <form method="post">
                        @csrf
                        <div class="card-body">

                            <div class="table-responsive">
                                <table id="ul-contact-list" class="{{ \App\myappenv::MainTableClass }}" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>{{ __('No.') }}</th>
                                            <th>تماس گیرنده</th>
                                            <th>پاسخگو</th>
                                            <th>تاریخ تماس</th>
                                            <th>مدت مکالمه</th>
                                            <th>نوع تماس</th>
                                            <th>موضوع تماس</th>
                                            <th>{{ __('Actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $Rowno = 1;
                                        @endphp
                                        @foreach ($calls_src as $calls_item)
                                            <tr>
                                                <td>{{ $Rowno }}</td>
                                                <td>{{ $calls_item->NameC }} {{ $calls_item->FamilyC }} </td>
                                                <td>{{ $calls_item->NameA }} {{ $calls_item->FamilyA }}</td>
                                                <td>{{ $Persian->MyPersianDate($calls_item->created_at, true) }}</td>
                                                <td>{{ $calls_item->CallDuration }}</td>
                                                <td>{{ $deal_functions->get_call_type($calls_item->CallType) }} </td>
                                                <td>{{ $deal_functions->get_call_subject($calls_item->Status) }} </td>
                                                <td>
                                                    <a href="javascript:BothSideCalls('{{ $calls_item->CallerNumber }}')">تماس
                                                        مجدد</a>
                                                </td>
                                            </tr>
                                            @php
                                                $Rowno++;
                                            @endphp
                                        @endforeach


                                    </tbody>

                                </table>
                            </div>

                        </div>
                        <button type="submit" name="submit" class="btn btn-success select-div nested" value="tmpsave">ثبت
                            موقت کاربران</button>
                    </form>
                </div>
            </div>
        </div>
        <!-- end of col-->
    </div>
@endsection
@section('page-js')
    <script src="{{ asset('assets/js/vendor/datatables.min.fa.js') }}"></script>
    <script>
        function BothSideCalls(target_phone) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('', {
                    ajax: true,
                    function: 'bothsidecall',
                    target: target_phone
                },
                function(data, status) {
                    alert(data);
                });

        }
    </script>
    <script>
        $('#ul-contact-list').DataTable();
    </script>
@endsection

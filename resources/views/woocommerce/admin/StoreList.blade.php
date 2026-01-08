@php
$Persian = new App\Functions\persian();
@endphp
@extends('Layouts.MainPage')
@section('page-header-left')
@endsection
@section('MainCountent')
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-lg-6">
                    <div class="page-header-left">
                        <h3>عملیات فروشگاه
                            <small>لیست فروشگاهها</small>
                        </h3>
                    </div>
                </div>
                <div class="col-lg-6">
                    <a href="{{ route('StoreAdd') }}" style="float: left" class="btn btn-success"> فروشگاه اضافه کنید
                    </a>
                </div>

            </div>
        </div>
    </div>

    <form method="post">
        @csrf
        <div class="card-body">

            <div class="table-responsive">
                <table id="ul-contact-list" class="{{ \App\myappenv::MainTableClass }}" style="width:100%">
                    <thead>
                        <tr>
                            <th>{{ __('No.') }}</th>
                            <th>نام فروشگاه</th>
                            <th>نوع فروشگاه</th>
                            <th>تلفن فروشگاه</th>
                            <th>مالک فروشگاه</th>
                            <th>تاریخ تاسیس فروشگاه</th>
                            <th>عملیات</th>

                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $Rowno = 1;
                        @endphp
                        @foreach ($Stores as $Store)
                            <tr>
                                <td>{{ $Rowno++ }}</td>
                                <td>{{ $Store->storename }}

                                    @canany(['shopadmin_', 'root_'])
                                        @if ($AdminStore == $Store->id)
                                            <p style="color: red"> انتخاب شده! </p>
                                        @else
                                            <button type="submit" class=" btn btn-primary" name="selectStore"
                                                value="{{ $Store->id }}">استفاده از این فروشگاه</button>
                                        @endif
                                    @endcanany
                                </td>
                                <td>{{ $Store->typename }}</td>
                                <td>{{ $Store->Mobile }}</td>
                                <td>{{ $Store->OwnerName }} {{ $Store->OwnerFamily }} </td>
                       
                                <td>  {{ $Persian->MyPersianDate($Store->CreateTime, true) }}  </td>

                                <td>
                                    <a target="_blank" href="{{ Route('StoreManageitems', $Store->id) }}"
                                        title="ویرایش فروشگاه">
                                        <i style="font-size: 20px" class="i-Edit"></i>
                                    </a>
                                    <a target="_blank" href="{{ Route('Warehouse', $Store->id) }}"
                                        title="مدیریت انبارها">
                                        <i style="font-size: 20px" class="i-Factory1"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>

                </table>
            </div>

        </div>
    </form>
    <!-- Container-fluid Ends-->
@endsection
@section('page-js')
    @if (app()->getLocale() == 'fa')
        <script src="{{ asset('assets/js/vendor/datatables.min.fa.js') }}"></script>
    @else
        <script src="{{ asset('assets/js/vendor/datatables.min.js') }}"></script>
    @endif
    <script src="{{ asset('assets/js/tooltip.script.js') }}"></script>
    <script>
        $('#ul-contact-list').DataTable();
    </script>
@endsection

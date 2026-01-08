@php
    $Persian = new App\Functions\persian();
@endphp
@extends('Layouts.MainPage')
@section('page-header-left')
@endsection
@section('MainCountent')
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-lg-6">
                    <div class="page-header-left">
                        <h3>مدیریت مالی
                            <small>تسیهم ها</small>
                        </h3>
                    </div>
                </div>
                <div class="col-lg-3">
                    <ol class="breadcrumb pull-right">
                        @include('Layouts.AddressBar')
                    </ol>
                </div>

                <div class="col-lg-3 " style="margin-top: -10px">
                    <ol class="breadcrumb pull-right">
                        <a href="{{ route('AddTashim') }}" class="btn btn-primary btn-md m-1">
                            <i class="i-Add-User text-white mr-2"></i>افرودن تسهیم جدید
                        </a>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Container-fluid Ends-->
    <form method="post">
        @csrf
        <div class="card-body">
            <div class="table-responsive">
                <table id="ul-contact-list" class="{{ \App\myappenv::MainTableClass }}" style="width:100%">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">نام تسهیم </th>
                            <th scope="col">توضیحات تسهیم </th>
                            <th scope="col">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $Conter = 1;
                        @endphp

                        @foreach ($Tashims as $TashimItem)
                            @if ($TashimItem->extra == 'defualt')
                                <td style="color: green">{{ $Conter }}</td>
                                <td style="color: green">{{ $TashimItem->Name }}</td>

                                <td style="color: green">{{ $TashimItem->Note }}</td>

                                <td>
                                    <a href="{{ route('EditTashim', ['TashimId' => $TashimItem->TashimID]) }}">ویرایش (تسهیم
                                        پیش فرض)</a>
                                </td>
                            @else
                                <tr>
                                    <td>{{ $Conter }}</td>
                                    <td>{{ $TashimItem->Name }}</td>
                                    <td>{{ $TashimItem->Note }}</td>

                                    <td>
                                        <a class="btn btn-primary"
                                            href="{{ route('EditTashim', ['TashimId' => $TashimItem->TashimID]) }}">ویرایش</a>
                                        <form method="post">
                                            @csrf
                                            <input type="text" name="TashimID" class="nested" value="{{ $TashimItem->TashimID}}">
                                            @isset($TashimItem->Operation)
                                                @if ($TashimItem->Operation == 1)
                                                    <button type="submit" class="btn btn-warning m-1"
                                                        name="submit" value="DisableItem">غیر
                                                        فعال
                                                        سازی
                                                    </button>
                                                @endif
                                                @if ($TashimItem->Operation == 0)
                                                    <button type="submit" class="btn btn-success m-1"
                                                        name="submit" value="EnableItem">فعال
                                                        سازی
                                                    </button>
                                                @endif
                                            @endisset
                                        </form>
                                    </td>

                                </tr>
                            @endif
                            @php
                                $Conter++;
                            @endphp
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>


    </form>
@endsection
@section('page-js')
    @if (app()->getLocale() == 'fa')
        <script src="{{ asset('assets/js/vendor/datatables.min.fa.js') }}"></script>
    @else
        <script src="{{ asset('assets/js/vendor/datatables.min.js') }}"></script>
    @endif

    <script>
        $('#ul-contact-list').DataTable();
    </script>
@endsection

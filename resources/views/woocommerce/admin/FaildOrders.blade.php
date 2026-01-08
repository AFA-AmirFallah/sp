@php
$Persian = new App\Functions\persian();
@endphp
@extends("Layouts.MainPage")
@section('page-header-left')

@endsection
@section('MainCountent')
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-lg-6">
                    <div class="page-header-left">
                        <h3>لیست
                            <small>سفارشات ناموفق</small>
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->

    <!-- Container-fluid starts-->
    <form method="post">
        @csrf
        <div class="card-body">

            <div class="table-responsive">
                <table id="ul-order-list" class="{{ \App\myappenv::MainTableClass }}" style="width:100%">
                    <thead>
                        <tr>
                            <th>شماره سفارش</th>
                            <th>نام مشتری</th>
                            <th>تاریخ خرید</th>
                            <th>تعداد اقلام</th>
                            <th>مبلغ</th>
                            <th>عملیات</th>

                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($OpenOrder as $OpenOrderTarget)
                            <tr>
                                <td>{{ $OpenOrderTarget->id }}</td>
                                <td>{{ $OpenOrderTarget->Name }} {{ $OpenOrderTarget->Family }}</td>
                                <td>{{ $Persian->MyPersianDate($OpenOrderTarget->created_at, true) }}</td>
                                <td>{{ $OpenOrderTarget->num_items_sold }}</td>
                                <td>{{ number_format($OpenOrderTarget->total_sales) }}</td>
                                <td>
                                    <a target="_blank" href="{{ route('EditOrder', ['OrderID' => $OpenOrderTarget->id]) }}"
                                        title="ویرایش سفارش">
                                        <i style="font-size: 20px" class="i-Edit"></i>
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
<script src="{{ asset('assets/js/vendor/datatables.min.fa.js') }}"></script>
<script src="{{ asset('assets/js/tooltip.script.js') }}"></script>

<script>
    $('#ul-order-list').DataTable({
        "order": [[ 0, "desc" ]]
    });
</script>


@endsection

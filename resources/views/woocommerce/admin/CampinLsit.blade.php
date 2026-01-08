@php
$Persian = new App\Functions\persian();
@endphp



<form method="post">
    @csrf
    <div class="card-body">

        <div class="table-responsive">
            <table id="ul-contact-list" class="{{ \App\myappenv::MainTableClass }}" style="width:100%">
                <thead>
                    <tr>
                        <th>{{ __('No.') }}</th>
                        <th>نام کمپین</th>
                        <th>وضعیت</th>
                        <th>اعتبار</th>
                        <th>اعتبار مصرف شده</th>
                        <th>شروع</th>
                        <th>پایان</th>
                        @if (Auth::user()->Role >= \App\myappenv::role_Accounting)
                            <th>{{ __('Actions') }}</th>
                        @endif


                    </tr>
                </thead>
                <tbody>
                    @foreach ($campains->get_campin_meta_all() as $campain)
                        <tr>
                            <td>{{ $campain->id }}</td>
                            <td>{{ $campain->name }}</td>
                            <td>{{ $campains->get_status_meta($campain->staus)}}</td>
                            <td>{{ number_format($campain->buget) }}</td>
                            <td>{{ number_format($campain->usedprice) }}</td>
                            @if ($campain->startdate != null)
                                <td>{{ $Persian->MyPersianDate($campain->startdate, false) }}</td>
                            @else
                                <td>-</td>
                            @endif
                            @if ($campain->expriredate != null)
                                <td>{{ $Persian->MyPersianDate($campain->expriredate, false) }}</td>
                            @else
                                <td>-</td>
                            @endif
                            
                            <td>
                                <a onclick="loadpage_with_data('EditCampin',{{ $campain->id }})"  title="ویرایش کمپین">
                                    <i style="font-size: 20px" class="i-Edit"></i>
                                </a>
                        </tr>
                    @endforeach

                </tbody>

            </table>
        </div>

    </div>
</form>

@php
    $Persian = new App\Functions\persian();
@endphp
@extends('Layouts.MainPage')
@section('page-header-left')
@endsection
@section('MainCountent')
    <script>
        window.affilite_id = {{ Auth::user()->Ext }};
    </script>
    <div id="app">
        <affiliate></affiliate>
    </div>
    <div class="row">
        <div class="col-lg-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">درخواست تسویه حساب</div>
                    <span class="text-muted">واریزی بابت خدمات</span>

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">خدمت</th>
                                    <th scope="col">مبلغ</th>
                                    <th scope="col">مرکز</th>
                                    <th scope="col">کد خدمت</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $Totall_price = 0;
                                    $counter = 0;
                                @endphp
                                @foreach ($affiliate->get_to_pay_user_credit(Auth::id()) as $credit_record)
                                    <tr class="">
                                        <td>
                                            {{ ++$counter }}
                                        </td>
                                        <td scope="row">
                                            <div class="ul-product-cart__detail d-inline-block align-middle ">
                                                <a href="">
                                                    <h6 class="heading">{{ $credit_record->RespnsTypeName }} </h6>
                                                </a>
                                                <span class="text-mute">تاریخ
                                                    {{ $Persian->MyPersianDate($credit_record->Date) }}</span>
                                            </div>
                                        </td>
                                        @php
                                            $Totall_price += $credit_record->Mony;
                                        @endphp
                                        <td>{{ number_format($credit_record->Mony) }} ریال</td>
                                        <td>{{ $credit_record->Name }} </td>
                                        <td>{{ $credit_record->id }} </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if ($counter > 0)
                        <div class="row ">
                            <div class="col-lg-12 mt-5">
                                <div class="ul-product-cart__invoice">
                                    <div class="card-title">
                                        <h4 class="heading text-primary">درخواست واریز </h4>
                                    </div>
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <th scope="row" class="text-16">مبلع کل</th>
                                                <td class="text-16 text-success font-weight-700">
                                                    {{ number_format($Totall_price) }} ریال
                                                </td>
                                            </tr>

                                            <tr>
                                                <th scope="row" class="text-16">انتقال به حساب</th>
                                                <td>

                                                    @foreach ($UserAccounts as $UserAccount_item)
                                                        <ul class="list-unstyled mb-0">
                                                            <li>
                                                                <div class="">
                                                                    <label class="radio radio-primary" checked="">
                                                                        <input type="radio" name="radio" value="0">
                                                                        <span>{{ $UserAccount_item->‌BankName }}</span>
                                                                        <span class="checkmark"></span>
                                                                    </label>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    @endforeach


                                                    <a href="{{ route('UserProfile') }}"
                                                        class="text-dark font-weight-bold">افزودن حساب
                                                        بانکی</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row" colspan="2" class="text-primary text-16">
                                                    <button class="btn btn-success btn-block m-1 mb-3">واریز به حساب
                                                        من</button>
                                                </th>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
@section('page-js')
@endsection
@section('bottom-js')
    <script>
        function myFunction() {
            // Get the text field
            var copyText = document.getElementById("marketing_code");

            // Select the text field
            copyText.select();
            copyText.setSelectionRange(0, 99999); // For mobile devices

            // Copy the text inside the text field
            navigator.clipboard.writeText(copyText.value);

            // Alert the copied text
            alert("لینک بازاریابی در حافظه کپی شد");
        }
    </script>
@endsection

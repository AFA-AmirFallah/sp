@php
$Persian = new App\Functions\persian();
@endphp
@extends("Layouts.CustomerMainPage")
@section('page-header-left')
    <h3>{{ __('Pats') }}
        <small>{{ __('My pats') }}</small>
    </h3>
@endsection
@section('MainCountent')
<div class="main_contineer_credit11">
    <div class="right_credit11" >
            <p>اعتبار ریالی</p>
            <div style="height:7px;" class="progress">
                <div  class="progress-bar bg-warning" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0"
                    aria-valuemax="100"></div>
            </div>
    </div>
    <div class="left_credit11">
        <div class="Percent_credit11">
            ۷۵٪
        </div>
        
        
    </div>
</div>

    <section class="basic-action-bar">
        <div class="">
            <div class="pwa_service_card_body card-body pwa_blue_gradian">
                <div class="pwa-card-title card-title">عملیات کیف پول</div>
                <div class="showprice">
                    {{ number_format(Session::get('UserCredit')) }} ریال
                </div>
                <hr class="CustomerServiceCardHr">
                <div style="padding-left: 0px;padding-right: 0px" class="row col-lg-12 col-md-12 col-sm-12">
                    <div class="col-lg-4 col-md-4 col-sm-4 pwa_iconsmain">
                        <a class="btn  btn-icon rounded-circle-pwa" onclick="AddMony()">
                            <img style="background-color: transparent" class="line-btn"
                                src="{{ asset('assets/images/deposite.png') }}" alt="">
                        </a>
                        افزایش موجودی
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 pwa_iconsmain">
                        <button onclick="ShowTransferList()" style="background-color: transparent" type="button"
                            class="btn btn-icon rounded-circle-pwa">
                            <img class="line-btn" src="{{ asset('assets/images/transactions.png') }}" alt="">
                        </button>
                        مشاهده تراکنش ها
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 pwa_iconsmain">
                        <button style="background-color: transparent" type="button" class="btn btn-icon rounded-circle-pwa">
                            <img class="line-btn" src="{{ asset('assets/images/deposite.png') }}" alt="">
                        </button>
                        درخواست برداشت
                    </div>

                </div>
            </div>
            <div id="TransferList" class=" nested row">
                @foreach ($Credites as $Credite)
                    <div class="col-lg-3 mb-3">
                    </div>
                    <div class="col-lg-6 mb-6">
                        @if ($Credite->Mony > 0)
                            <div class="card green">
                                <div class=" card-header bg-transparent">

                                    <h3 class="card-title">واریز</h3>
                                    <div class="card-body">
                                        <div class="form-row ">
                                            <div class="form-group col-md-12">
                                                <label for="inputEmail4" class="ul-form__label">مبلغ واریزی:</label>
                                                {{ number_format($Credite->Mony) }} ریال
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer bg-transparent">
                                        <div class="mc-footer">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="form-group col-md-12">
                                                        <small class="ul-form__text form-text ">
                                                            تاریخ تراکنش:
                                                            {{ $Persian->MyPersianDate($Credite->ConfirmDate, true) }}
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="card red">
                                        <div class=" card-header bg-transparent">

                                            <h3 class="red card-title">برداشت</h3>
                                            <div class="card-body">
                                                <div class="form-row ">
                                                    <div class="form-group col-md-12">
                                                        <label for="inputEmail4" class="ul-form__label">مبلغ برداشت:</label>
                                                        {{ number_format($Credite->Mony) }} ریال
                                                    </div>
                                                    <small class="ul-form__text form-text ">
                                                        بابت:
                                                        {{ $Credite->Note }}
                                                    </small>
                                                </div>
                                            </div>
                                            <div class="card-footer bg-transparent">
                                                <div class="mc-footer">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="form-group col-md-12">
                                                                <small class="ul-form__text form-text ">
                                                                    تاریخ تراکنش:
                                                                    {{ $Persian->MyPersianDate($Credite->ConfirmDate, true) }}
                                                                </small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                        @endif
                    </div>



                    <!-- end::form -->
            </div>
        </div>
        @endforeach

        </div>
        <div id="AddMony" class="nested row">
            <div class="col-lg-3 mb-3">
            </div>
            <div class="col-lg-6 mb-6">
                <div class="card">
                    <div class="card-header bg-transparent">
                        <h3 class="card-title">افزایش موجودی</h3>
                    </div>
                    <form method="post">
                        @csrf
                        <div class="card-body">
                            <div class="form-row ">
                                <div class="form-group col-md-12">
                                    <label for="inputEmail4" class="ul-form__label">مبلغ واریزی:</label>
                                    <input type="number" id="amount" autocomplete="off" class="form-control" required
                                        name="Amount" value="{{ old('Amount') }}" placeholder="مبلغ ورودی به ریال">
                                    <div id="amountext"></div>
                                    <small class="ul-form__text form-text ">
                                        واریز به حساب کیف پول مشتری
                                    </small>
                                </div>
                                <div class="nested form-group col-md-12">
                                    <label class="ul-form__label">{{ __('Note') }}</label>
                                    <textarea name="Note" rows="3" class="form-control">{{ old('Note') }}</textarea>

                                </div>


                            </div>

                        </div>

                        <div class="card-footer bg-transparent">
                            <div class="mc-footer">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <button type="submit" name="submit" value="pep"
                                            class="btn  btn-primary m-1">{{ __('Add credite') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- end::form -->
                </div>
            </div>
        </div>
        </div>
    </section>
@endsection
@section('page-js')
    <script>
        onload = function() {
            var e = document.getElementById('amount');
            e.oninput = myHandler;
            e.onpropertychange = e.oninput; // for IE8
            function myHandler() {
                document.getElementById('amountext').innerHTML = e.value.toPersianLetter() + ' تومان ';
            }

            var e2 = document.getElementById('amountDisc');
            e2.oninput = myHandler2;
            e2.onpropertychange = e2.oninput; // for IE8
            function myHandler2() {
                document.getElementById('amountDiscText').innerHTML = e2.value.toPersianLetter() + ' تومان ';
            }
        };
    </script>

    <script>
        function hideAllBox() {
            $("#AddMony").fadeOut();
            $("#TransferList").fadeOut();
        }

        function postAction() {

        }

        function AddMony() {
            hideAllBox();
            $("#AddMony").fadeIn();
        }

        function ShowTransferList() {
            hideAllBox();
            $("#TransferList").fadeIn();
        }
    </script>
@endsection

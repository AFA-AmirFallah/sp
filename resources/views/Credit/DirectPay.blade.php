@extends('Layouts.MainPage')
@section('page-header-left')
    <h3>{{ __('Pats') }}
        <small>{{ __('My pats') }}</small>
    </h3>
@endsection
@section('MainCountent')
    @if (Auth::user()->Role == \App\myappenv::role_worker)
        @include('Dashboard.layouts.worker_top_bar')
    @endif
    <input class="nested" id="main-menu" value="#Financials">
    <input class="nested" id="sub-menu" value="#DirectPay">
    <section class="basic-action-bar">
        <div class="">
            <div class="row">
                <div class="col-lg-3 mb-3">
                </div>
                <div class="col-lg-6 mb-6">
                    <div class="card">
                        <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                            <h5 class="text-white"><i class=" header-icon i-Credit-Card-2"></i>
                                افزایش موجودی کیف پول</h5>
                        </div>
                        <form method="post">
                            @csrf
                            <div class="card-body">
                                <div class="form-row ">
                                    <div class="form-group col-md-12">
                                        <label for="inputEmail4" class="ul-form__label">میزان افزایش موجودی (ریال) :</label>
                                        <input type="number" id="amount" required autocomplete="off"
                                            class="form-control" name="Amount" value="{{ old('Amount') }}"
                                            placeholder="میزان افزایش موجودی ">
                                        <div id="amountext"></div>
                                        <small class="ul-form__text form-text ">
                                            واریز از طریق درگاه بانکی به کیف پول
                                        </small>
                                    </div>
                                    <div class="row" style="text-align: center">
                                        <label style="margin: 10px" class="radio radio-outline-primary">
                                            <input type="radio" checked name="radio" value="{{ App\myappenv::Bank }}"
                                                formcontrolname="radio">
                                            <img style="max-width: 80px;" src="{{ App\myappenv::ipg_info['img'] }}">
                                            <span>{{ App\myappenv::ipg_info['fa_name'] }} </span>

                                            <span class="checkmark"></span>
                                        </label>

                                    </div>
                                    <div class="form-group col-md-12">
                                        <label class="ul-form__label">{{ __('Note') }}</label>
                                        <textarea name="Note" rows="3" class="form-control">{{ old('Note') }}</textarea>
                                        <small class="ul-form__text form-text ">
                                            توضیحات متن اختیاری است که در کنار تراکنش نمایش داده می شود
                                        </small>
                                    </div>


                                </div>
                                <div class="custom-separator"></div>

                            </div>

                            <div class="card-footer bg-transparent">
                                <div class="mc-footer">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <button type="submit" name="submit" value="Trnsfer"
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
@endsection

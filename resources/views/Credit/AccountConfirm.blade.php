@extends('Layouts.MainPage')
@section('page-header-left')
@endsection
@section('MainCountent')
    <input class="nested" id="main-menu" value="#Financials">
    <input class="nested" id="sub-menu" value="#AccountConfirm">
    <div class="ul-card-list__modal">
        <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-body">
                        <form method="post">
                            @csrf
                            <div class="form-group row">
                                <input style="visibility:hidden" id="tableID" name="tableid">
                            </div>
                            <div class="form-group row" style="display:none">
                                <label for="inputName" class="col-sm-2 col-form-label">{{ __('Username') }}</label>
                                <div class="col-sm-10">
                                    <input class="form-control" id="modal_UserName" name="UserName"
                                        style="visibility: hidden" value="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputName" class="col-sm-2 col-form-label">{{ __('Name and family') }}</label>
                                <div class="col-sm-10">
                                    <input class="form-control" id="modal_NameFamily" value="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputName" class="col-sm-2 col-form-label">{{ __('Issued bank') }}</label>
                                <div class="col-sm-10">
                                    <input class="form-control" name="modal_bank" id="modal_bank" value="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputName" class="col-sm-2 col-form-label">{{ __('Account no') }}</label>
                                <div class="col-sm-10">
                                    <input class="form-control" name="Accountno" id="modal_Account" value="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputName" class="col-sm-2 col-form-label">{{ __('Card no') }}</label>
                                <div class="col-sm-10">
                                    <input class="form-control" name="Cardno" id="modal_cardno" value="">
                                    <input style="display: none" class="form-control" name="CardnoBase"
                                        id="modal_cardno_base" value="">
                                </div>
                            </div>
                            <div class="ul-bottom__line mb-3">
                                <button type="submit" name="submit" value="update"
                                    class="btn btn-primary btn-rounded m-1">{{ __('Edit') }}</button>
                                <button type="submit" name="submitState" value="1"
                                    class="btn btn-success btn-rounded m-1">{{ __('Confirm account') }}</button>
                                <button type="submit" name="submitState" value="3"
                                    class="btn btn-danger btn-rounded m-1">{{ __('Delete account') }}</button>
                                <button type="submit" name="submitState" value="2"
                                    class="btn btn-warning btn-rounded m-1">{{ __('Invalid data') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form method="post">
        @csrf
        <div class="container-fluid">
            <div class="row product-adding">
                <div class="col-xl-3">
                    <div class="card">
                        <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                            <h5 class="text-white"> <i class=" header-icon i-Business-Man"></i>
                                {{ __('Search based on basic information') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="digital-add needs-validation">
                                <div class="form-group">
                                    <label for="validationCustom01"
                                        class="col-form-label pt-0">{{ __('Username') }}</label>
                                    <input class="form-control" name="CartOwner" type="text">
                                </div>
                                <div class="form-group">
                                    <label for="validationCustom01"
                                        class="col-form-label pt-0">{{ __('Name and family') }}</label>
                                    <input class="form-control" name="NameFamily" type="text">
                                </div>
                                <div class="form-group">
                                    <label for="validationCustom01"
                                        class="col-form-label pt-0">{{ __('Card no') }}</label>
                                    <input class="form-control" name="CartNumber" type="number">
                                </div>
                                <div class="form-group">
                                    <label>نوع کارت ها</label>
                                    <div dir="rtl" class="radio">
                                        <label class="radio radio-success">
                                            <input type="radio" name="optionsRadios" value="3"
                                                formControlName="radio" checked>
                                            <span>{{ __('All cards') }}</span>
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                    <div dir="rtl" class="radio">
                                        <label class="radio radio-success">
                                            <input type="radio" name="optionsRadios" value="1"
                                                formControlName="radio">
                                            <span>{{ __('Confirmed cards') }}</span>
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                    <div dir="rtl" class="radio">
                                        <label class="radio radio-success">
                                            <input type="radio" name="optionsRadios" value="2"
                                                formControlName="radio">
                                            <span>{{ __('Waiting for confirm cards') }}</span>
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>

                                </div>

                                <div class="form-group mb-0">
                                    <div class="product-buttons text-center">
                                        <button type="submit" name="submit" value="Search"
                                            class="btn btn-primary">{{ __('Search') }}</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-9">

                    <div class="card">
                        <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                            <h5 class="text-white"> <i class=" header-icon i-File-Horizontal-Text"></i>کارت های ثبت شده در
                                سامانه</h5>
                        </div>



                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="ul-contact-list" class="{{ \App\myappenv::MainTableClass }}"
                                    style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>{{ __('No.') }}</th>
                                            <th class="nested">{{ __('Username') }}</th>
                                            <th>{{ __('Name and family') }}</th>
                                            <th>{{ __('Card no') }}</th>
                                            <th>{{ __('Account no') }}</th>
                                            <th>{{ __('Bank name') }}</th>
                                            <th>{{ __('Status') }}</th>
                                            <th>{{ __('Actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $Rowno = 1;
                                        @endphp
                                        @if ($Cards == null)
                                        @else
                                            @foreach ($Cards as $Card)
                                                <tr>
                                                    <td>{{ $Rowno++ }}</td>
                                                    <td class="nested" id="UserName_{{ $Card->UserName }}"
                                                        name="{{ $Card->UserName }}">{{ $Card->UserName }}</td>
                                                    <td id="NameFamily_{{ $Card->UserName }}"
                                                        name="{{ $Card->Name }} {{ $Card->Family }}">
                                                        {{ $Card->Name }} {{ $Card->Family }}</td>
                                                    <td id="Cardno_{{ $Card->UserName }}" name="{{ $Card->CardNo }}"
                                                        style="direction: ltr">{{ $Card->CardNo }}</td>
                                                    <td id="CardAccount_{{ $Card->UserName }}"
                                                        name="{{ $Card->Account }}">{{ $Card->Account }}</td>
                                                    <td id="Bank_{{ $Card->UserName }}" name="{{ $Card->BankName }}">
                                                        {{ $Card->BankName }}</td>
                                                    <td>
                                                        @if ($Card->Status == 1)
                                                            <i class="i-Yes" style="font-size: 30px;"></i>
                                                        @elseif($Card->Status == 2)
                                                            <i class="i-Information" style="font-size: 30px;"></i>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <button id="{{ $Card->UserName }}" type="button"
                                                            data-toggle="modal" data-target=".bd-example-modal-lg"
                                                            class="btn btn-primary btn-md m-1 edit_btn_account"
                                                            title="Edit">
                                                            <i class="i-Edit"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>

                                </table>
                            </div>

                        </div>

                    </div>

                </div>
            </div>
        </div>
    </form>
    <!-- Container-fluid Ends-->

@endsection
@section('page-js')
    <script>
        $('.edit_btn_account').on('click', function() {
            var $selectID = $(this).attr('id');
            $('#modal_UserName').val($('#UserName_' + $selectID).attr('name'));
            $('#modal_NameFamily').val($('#NameFamily_' + $selectID).attr('name'));
            $('#modal_bank').val($('#Bank_' + $selectID).attr('name'));
            $('#modal_cardno').val($('#Cardno_' + $selectID).attr('name'));
            $('#modal_cardno_base').val($('#Cardno_' + $selectID).attr('name'));
            $('#modal_Account').val($('#CardAccount_' + $selectID).attr('name'));

        });
    </script>
    @if (app()->getLocale() == 'fa')
        <script src="{{ asset('assets/js/vendor/datatables.min.fa.js') }}"></script>
    @else
        <script src="{{ asset('assets/js/vendor/datatables.min.js') }}"></script>
    @endif
    <!-- page script -->
    <script src="{{ asset('assets/js/tooltip.script.js') }}"></script>

    <script>
        $('#ul-contact-list').DataTable();
    </script>
@endsection

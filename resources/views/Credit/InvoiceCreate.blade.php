@php
    $Persian= new App\Functions\persian();
@endphp
@extends("Layouts.MainPage")
@section("page-header-left")

@endsection
@section('MainCountent')
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-lg-6">
                    <div class="page-header-left">
                        <h3>صورتحساب ها
                            <small>عملیات افزودن صورت حساب</small>
                        </h3>
                    </div>
                </div>
                <div class="col-lg-6">
                    <ol class="breadcrumb pull-right">
                        @include('Layouts.AddressBar')
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div>
            <!--==== Edit Area =====-->
            <form method="post">
                @csrf
                <div class="form-row ">
                    <div class="form-group col-md-6">
                        <label for="inputEmail4" class="ul-form__label">{{__("Invoice To")}} :</label>
                        @include("Layouts.SearchUserInput",['InputName'=>'UserName','InputPalceholder'=>__( "Target username")])
                        <small class="ul-form__text form-text ">
                            {{__("The Username of peple owner of bill")}}
                        </small>
                    </div>
                    <div class="form-group col-md-6">
                        <div class="form-group">
                            <label for="inputEmail4" class="ul-form__label">{{__("تاریخ انقضای صورت حساب")}}
                                :</label>
                            <input class="form-control" type="text" name="StartDate" id="InputStartDate"
                                   style="margin-top: 10px"
                                   autocomplete="off"
                                   onchange="SetServiceDate()"
                                   onfocus="Mh1PersianDatePicker.Show(this,'{{$Persian->MyPersianDate(date("Y-m-d"),false,"n")}}',)"
                                   placeholder="تاریخ انقضا"/>
                            <small class="ul-form__text form-text ">
                                {{__("The Username of peple owner of bill")}}
                            </small>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 table-responsive">
                        <table class="table table-hover mb-3">
                            <thead class="bg-gray-300">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">{{ __('Item Name') }}</th>
                                <th scope="col">{{ __('Unit Price') }}</th>
                                <th scope="col">{{ __('Unit') }}</th>
                                <th scope="col">{{ __('Qty') }}</th>
                                <th scope="col">{{ __('Discount') }}</th>
                                <th scope="col">مالیات</th>
                                <th scope="col">{{ __('Price') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>
                                    <input name="ItemName[1]" value="" type="text" class="form-control"
                                           placeholder="{{ __('Item Name') }}">
                                </td>
                                <td>
                                    <input name="UnitPrice[1]" value="" type="number" class="form-control"
                                           placeholder="{{ __('Unit Price') }}">
                                </td>
                                <td>
                                    <input name="Unit[1]" value="" type="text" class="form-control"
                                           placeholder="{{ __('Unit') }}">
                                </td>
                                <td>
                                    <input name="Qty[1]" value="" type="number" class="form-control"
                                           placeholder="{{ __('Qty') }}">
                                </td>
                                <td>
                                    <input name="Discount[1]" value="0" type="number" class="form-control"
                                           placeholder="{{ __('Discount') }}">
                                </td>
                                <td>
                                    <input name="Tax[1]" value="0" type="number" class="form-control"
                                           placeholder="مالیات">
                                </td>
                                <td>

                                </td>
                            </tr>
                            <tr>
                                <th scope="row">2</th>
                                <td>
                                    <input name="ItemName[2]" value="" type="text" class="form-control"
                                           placeholder="{{ __('Item Name') }}">
                                </td>
                                <td>
                                    <input name="UnitPrice[2]" value="" type="number" class="form-control"
                                           placeholder="{{ __('Unit Price') }}">
                                </td>
                                <td>
                                    <input name="Unit[2]" value="" type="text" class="form-control"
                                           placeholder="{{ __('Unit') }}">
                                </td>
                                <td>
                                    <input name="Qty[2]" value="" type="number" class="form-control"
                                           placeholder="{{ __('Qty') }}">
                                </td>
                                <td>
                                    <input name="Discount[2]" value="0" type="number" class="form-control"
                                           placeholder="{{ __('Discount') }}">
                                </td>
                                <td>
                                    <input name="Tax[2]" value="0" type="number" class="form-control"
                                           placeholder="مالیات">
                                </td>
                                <td>

                                </td>
                            </tr>
                            <tr>
                                <th scope="row">3</th>
                                <td>
                                    <input name="ItemName[3]" value="" type="text" class="form-control"
                                           placeholder="{{ __('Item Name') }}">
                                </td>
                                <td>
                                    <input name="UnitPrice[3]" value="" type="number" class="form-control"
                                           placeholder="{{ __('Unit Price') }}">
                                </td>
                                <td>
                                    <input name="Unit[3]" value="" type="text" class="form-control"
                                           placeholder="{{ __('Unit') }}">
                                </td>
                                <td>
                                    <input name="Qty[3]" value="" type="number" class="form-control"
                                           placeholder="{{ __('Qty') }}">
                                </td>
                                <td>
                                    <input name="Discount[3]" value="0" type="number" class="form-control"
                                           placeholder="{{ __('Discount') }}">
                                </td>
                                <td>
                                    <input name="Tax[3]" value="0" type="number" class="form-control"
                                           placeholder="مالیات">
                                </td>
                                <td>

                                </td>
                            </tr>
                            <tr>
                                <th scope="row">4</th>
                                <td>
                                    <input name="ItemName[4]" value="" type="text" class="form-control"
                                           placeholder="{{ __('Item Name') }}">
                                </td>
                                <td>
                                    <input name="UnitPrice[4]" value="" type="number" class="form-control"
                                           placeholder="{{ __('Unit Price') }}">
                                </td>
                                <td>
                                    <input name="Unit[4]" value="" type="text" class="form-control"
                                           placeholder="{{ __('Unit') }}">
                                </td>
                                <td>
                                    <input name="Qty[4]" value="" type="number" class="form-control"
                                           placeholder="{{ __('Qty') }}">
                                </td>
                                <td>
                                    <input name="Discount[4]" value="0" type="number" class="form-control"
                                           placeholder="{{ __('Discount') }}">
                                </td>
                                <td>
                                    <input name="Tax[4]" value="0" type="number" class="form-control"
                                           placeholder="مالیات">
                                </td>
                                <td>

                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <div class="form-group col-md-12">
                            <label class="ul-form__label">{{__("Note")}}</label>
                            <textarea name="Note" rows="3" class="form-control">{{old('Note')}}</textarea>

                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <button type="submit" name="submit" value="Trnsfer"
                                        class="btn  btn-primary m-1">{{__("Save as invoice")}}</button>
                            </div>
                        </div>
                    </div>


                </div>
            </form>
            <!--==== / Edit Area =====-->
        </div>
    </div>
    <!-- Container-fluid Ends-->

@endsection
@section('page-js')
    @include("Layouts.SearchUserInput_Js")
    <script src="{{asset('assets/js/invoice.script.js')}}"></script>
    <script src="{{url('/')}}/persian-datepicker/Mh1PersianDatePicker.js"></script>

@endsection

@php
    $Persian = new App\Functions\persian();
    $Totall = 0;
@endphp
@extends('Layouts.NoLoginPage')
@section('page-header-left')
@endsection

@section('MainCountent')

    <div class="d-sm-flex mb-5" data-view="print">
        <span class="m-auto"></span>
        <button id="print-invoice" class="btn btn-primary mb-sm-0 mb-3 print-invoice"> چاپ رسید </button>
    </div>
    <div id="print-area">
        <div class="row">
            <div class="col-md-12">

                <div class="card">
                    <div style="display: flex;justify-content: space-around;">
                        @if (\App\myappenv::MainOwner == 'kookbaz')
                            <img style="  width: 100px;height: 100px;"
                                src="{{ asset('assets/images/favicon/kookted.png') }}">

                            <h3 class="font-weight-bold" style="margin-top: 50px;">   رسید پستی</h3>

                            <img style="  width: 100px;height: 83px; " src="{{ asset('assets/images/andishe.png') }}">
                        @endif
                    </div>
                    <div style="display: flex;justify-content: space-between;">
                        <div class="col-3 text-right">
                            <p>شماره سفارش:
                                K-{{ $TargetOrder->id }}</p>

                        </div>
                        <div class="col-3 " style="  float: left;">
                            <p>تاریخ سفارش:
                                {{ $Persian->MyPersianDate($TargetOrder->created_at, false) }}</p>

                        </div>
                    </div>


                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="invoice" role="tabpanel" aria-labelledby="invoice-tab">

                            <!---===== Print Area =======-->
                            <div class="container-xl">
                                <div class="row">


                                </div>
                                <div class="row">
                                    <table class="table table-bordered">
                                       
                                        <thead>
                                            <tr>
                                                <th class="text-center" colspan="11">مشخصات خریدار</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <tr>
                                                <td colspan="11">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <p>
                                                              گیرنده:{{ $TargetOrder->Name }}
                                                                {{ $TargetOrder->Family }}
                                                            </p>

                                                        </div>
                                                        

                                                        <div class="col-3">
                                                            <p>
                                                                تلفن: {{ $TargetOrder->MobileNo }}
                                                            </p>



                                                        </div>
                                                    </div>
                                                    @if (isset($SendLocation->id))
                                                        <div class="row">
                                                            <div class="col">
                                                                <p>
                                                                    استان:{{ $SendLocation->Province }}
                                                                </p>

                                                            </div>
                                                            <div class="col">
                                                                <p>
                                                                    شهر:{{ $SendLocation->City }}
                                                                </p>

                                                            </div>
                                                           
                                                        </div>
                                                        <div class="row">
                                                            <div class="col">
                                                                آدرس:{{ $SendLocation->Street }} -
                                                                {{ $SendLocation->OthersAddress }}
                                                            </div>
                                                            <div class="col">
                                                                کد پستی:{{ $SendLocation->PostalCode }}
                                                            </div>

                                                        </div>
                                                        @else
                                                    
                                                        <div class="row">
                                                            <div class="col">
                                                                آدرس:{{ $TargetOrder->Address }} 
                                                              
                                                            </div>
                                                            <div class="col">
                                                                کد پستی:{{ $TargetOrder->Address2 }}
                                                            </div>

                                                        </div>

                                                    @endif
                                </div>
                                </td>
                                </tr>
                                </tbody>
                                



                                </table>
                 


                                

                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Container-fluid starts-->
@endsection
@section('page-js')
    <script src="{{ asset('assets/js/vendor/pickadate/picker.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/pickadate/picker.date.js') }}"></script>
    <script>
        $(document).ready(function() {

            $('#print-invoice').on('click', function() {
                window.print();
            })
        });
    </script>
@endsection

@php
    $Persian = new App\Functions\persian();
@endphp
@extends('Layouts.MainPage')
@section('page-header-left')
@endsection
@section('MainCountent')
<div class="row">
    <div onclick="showorder()" style="cursor: pointer" class="col-lg-4 col-md-6 col-sm-6">
        <div class="card card-icon-bg card-icon-bg-primary blue o-hidden mb-4">
            <div class="card-body text-center">
                <i class="i-Receipt-3 text-white"></i>

                <h4 class="text-18 mb-1 text-white" style="margin: 25px;"> لیست سفارشات </h4>

            </div>
        </div>
    </div>
    <div onclick="showEstelam()" style="cursor: pointer" class="col-lg-4 col-md-6 col-sm-6">
        <div class="card card-icon-bg card-icon-bg-primary cyan  o-hidden mb-4">
            <div class="card-body text-center">
                <i class="i-File text-white"></i>

                <h4 class="text-18 mb-1 text-white text-center" style="margin: 25px;"> لیست استعلامی ها </h4>

            </div>
        </div>
    </div>
    <div onclick="sendingorder()" style="cursor: pointer" class="col-lg-4 col-md-6 col-sm-6">
        <div class="card card-icon-bg card-icon-bg-primary purple o-hidden mb-4">
            <div class="card-body text-center">
                <i class="i-Helmet text-white"></i>
                <h4 class="text-18 mb-1 text-white" style="margin: 25px;"> در حال ارسال </h4>

            </div>
        </div>
    </div>
</div>
    <div class="row">



        <div onclick="reciveorder()" style="cursor: pointer" class="col-lg-4 col-md-6 col-sm-6">
            <div class="card card-icon-bg card-icon-bg-primary orange o-hidden mb-4">
                <div class="card-body text-center">
                    <i class="i-Happy text-white"></i>

                    <h4 class="text-18 mb-1 text-white" style="margin: 25px;">   فرآیند مالی </h4>

                </div>
            </div>
        </div>
        <div onclick="canceleorder()" style="cursor: pointer" class="col-lg-4 col-md-6 col-sm-6">
            <div class="card card-icon-bg card-icon-bg-primary red o-hidden mb-4">
                <div class="card-body text-center">
                    <i class="i-Close-Window text-white"></i>

                    <h4 class="text-18 mb-1 text-white" style="margin: 25px;"> لغو سفارش </h4>

                </div>
            </div>
        </div>
        <div onclick="showlist()" style="cursor: pointer" class="col-lg-4 col-md-6 col-sm-6">
            <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4 green">
                <div class="card-body text-center">
                    <i class="i-Yes text-white"></i>
                    <h4 class="text-18 mb-1 text-white" style="margin: 25px;"> سفارشات تمام شده </h4>
                </div>
            </div>
        </div>

    </div>

    <div id="main_content">
    </div>
@endsection
@section('page-js')
    <script src="{{ asset('assets/js/vendor/datatables.min.fa.js') }}"></script>
    <script src="{{ asset('assets/js/tooltip.script.js') }}"></script>

    <script>
        $('#ul-order-list').DataTable();
    </script>
    <script>
        function showEstelam() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('', {

                    ajax: true,
                    procedure: 'showEstelam',

                },
                function(response) {

                    $('#main_content').html(response);

                });



        }

        function showorder() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('', {

                    ajax: true,
                    procedure: 'openorder',

                },
                function(response) {

                    $('#main_content').html(response);

                });



        }

        function reciveorder() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('', {

                    ajax: true,
                    procedure: 'reciveorder',

                },
                function(response) {

                    $('#main_content').html(response);

                });



        }

        function canceleorder() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('', {

                    ajax: true,
                    procedure: 'cancelorder',

                },
                function(response) {

                    $('#main_content').html(response);

                });



        }

        function showlist() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('', {

                    ajax: true,
                    procedure: 'DoneOrder',

                },
                function(response) {

                    $('#main_content').html(response);


                });


        }

        function sendingorder() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('', {

                    ajax: true,
                    procedure: 'SendOrder',

                },
                function(response) {

                    $('#main_content').html(response);


                });


        }
    </script>
@endsection

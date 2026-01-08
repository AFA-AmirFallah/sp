@php
    $Persian = new App\Functions\persian();
@endphp
@extends('Layouts.MainPage')
@section('page-header-left')
@endsection
@section('MainCountent')
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-lg-6">
                    <div class="page-header-left">
                        <h3>کرال محصولات</h3>
                        <a id="start_link" class="btn btn-warning" href="javascript:start_process()">شروع کرال محصولات</a>
                        <a id="stop_link" class="btn btn-error d-none" href="javascript:stop_process()">اتمام کرال
                            محصولات</a>
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

    <div id="another" class="row"></div>
@endsection

@section('page-js')
    @if (app()->getLocale() == 'fa')
        <script src="{{ asset('assets/js/vendor/datatables.min.fa.js') }}"></script>
    @else
        <script src="{{ asset('assets/js/vendor/datatables.min.js') }}"></script>
    @endif
    <script>
        var $process_run = false;

        function stop_process() {
            $process_run = false;
            $('#start_link').removeClass('d-none');
            $('#stop_link').addClass('d-none');
        }

        function start_process() {
            $('#start_link').addClass('d-none');
            $('#stop_link').removeClass('d-none');
            $process_run = true;
            single_process();
        }

        function single_process() {
            if (!$process_run) {
                alert('پایان عملیات');
                return true;
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('', {
                    AjaxType: 'another',
                },

                function(data, status) {
                    if (data['result']) {
                        old_html = $('#another').html();
                        $('#another').html(old_html + data['data']);
                        single_process();
                    }else{
                        alert('پایان');
                    }

                });

        }

        function checkall() {
            $Totall = $('#totalllink').val();
            for (let i = 1; i < $Totall; i++) {
                $Item = $('#link_id_' + i).val();
                $Result = cheklink($Item);

            }
        }

        function cheklink($LinkID) {
            $('#label_' + $LinkID).html('درحال بررسی...');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('<?php echo e(route('ajax')); ?>', {
                    AjaxType: 'checkCrawlLink',
                    LinkID: $LinkID,
                },

                function(data, status) {
                    $('#label_' + $LinkID).html(data);
                    return true;

                });


        }
    </script>
    <script src="{{ asset('assets/js/tooltip.script.js') }}"></script>
    <script>
        $('#ul-contact-list').DataTable();
    </script>
@endsection
@section('bottom-js')
    @include('Layouts.FilemanagerScripts')
@endsection

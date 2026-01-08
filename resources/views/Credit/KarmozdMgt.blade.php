@php
$Persian = new App\Functions\persian();
@endphp
@extends("Layouts.MainPage")
@section('page-header-left')
@endsection
@section('MainCountent')
    <!-- begin::modal -->
    <div class="ul-card-list__modal">
        <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-body">
                        <form method="post">
                            @csrf
                            <div class="form-group row">
                                <label for="inputName" class="col-sm-2 col-form-label">نام کارمزد</label>
                                <div class="col-sm-10">
                                    <input class="form-control" id="modal_PageName" name="IndexName"
                                        placeholder="نام مدل کارمزد">
                                </div>

                            </div>
                            <div class="form-group row">
                                <label for="inputName" class="col-sm-2 col-form-label">شعبه</label>
                                <div class="col-sm-10">
                                    <input class="form-control" id="modal_PageName" name="IndexName"
                                        placeholder="نام شعبه">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputName" class="col-sm-2 col-form-label">شاخص</label>
                                <div class="col-sm-10">
                                    <input class="form-control" id="modal_PageName" name="IndexName"
                                        placeholder="نام شعبه">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputName" class="col-sm-2 col-form-label">دوره قسط - به روز</label>
                                <div class="col-sm-10">
                                    <input class="form-control" id="modal_PageName" name="IndexName"
                                        placeholder="نام شعبه">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputName" class="col-sm-2 col-form-label">کارمزد عملیات</label>
                                <div class="col-sm-10">
                                    <input class="form-control" id="modal_PageName" name="IndexName"
                                        placeholder="نام شعبه">
                                    <input class="form-control" id="modal_PageName" name="IndexName"
                                        placeholder="نام شعبه">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputName" class="col-sm-2 col-form-label">کارمزد اقساط</label>
                                <div class="col-sm-10">
                                    <input class="form-control" id="modal_PageName" name="IndexName"
                                        placeholder="نام شعبه">
                                    <input class="form-control" id="modal_PageName" name="IndexName"
                                        placeholder="نام شعبه">
                                </div>
                            </div>

                            <div class="form-group row">
                                <button type="submit" class="btn btn-primary m-1" name="submit"
                                    value="AddIndex">{{ __('update') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end::modal -->

    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-lg-6">
                    <div class="page-header-left">
                        <h3>{{ __('Financial works') }}
                            <small>{{ __('Financial index') }}</small>
                        </h3>
                    </div>
                </div>
                <div class="col-lg-3">
                    <ol class="breadcrumb pull-right">
                        @include('Layouts.AddressBar')
                    </ol>
                </div>

                <div class="col-lg-3 " style="margin-top: -10px">
                    <ol class="breadcrumb pull-right">
                        <button id="addcontact" type="button" data-toggle="modal" data-target=".bd-example-modal-lg"
                            class="btn btn-primary btn-md m-1">
                            <i class="i-Add-User text-white mr-2"></i>{{ __('Add new financial index') }}
                        </button>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Container-fluid Ends-->
    <form method="post">
        @csrf
        <div class="card-body">
            <div class="table-responsive">
                <table id="ul-contact-list" class="{{ \App\myappenv::MainTableClass }}" style="width:100%">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">{{ __('Name of financial index') }}</th>
                            <th scope="col">{{ __('Date') }}</th>
                            <th scope="col">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>


    </form>
@endsection
@section('page-js')
    @if (app()->getLocale() == 'fa')
        <script src="{{ asset('assets/js/vendor/datatables.min.fa.js') }}"></script>
    @else
        <script src="{{ asset('assets/js/vendor/datatables.min.js') }}"></script>
    @endif

    <script>
        $('#ul-contact-list').DataTable();
    </script>
@endsection

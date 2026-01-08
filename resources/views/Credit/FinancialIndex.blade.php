@php
    $Persian = new App\Functions\persian();
@endphp
@extends('Layouts.MainPage')
@section('page-header-left')
@endsection
@section('MainCountent')
    <!-- begin::modal -->
    <input class="nested" id="main-menu" value="#setting">
    <input class="nested" id="sub-menu" value="#FinancialIndex">
    <div class="ul-card-list__modal">
        <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="card">
                            <form method="post">
                                @csrf
                                <div class="card-header">
                                    <h5>افزودن شاخص مالی جدید</h5>
                                </div>
                                <div class="card-body">

                                    <div class="form-group row">
                                        <label for="inputName"
                                            class="col-sm-2 col-form-label text-large">{{ __('Name of financial index') }}</label>
                                        <div class="col-sm-10">
                                            <input required class="form-control" id="modal_PageName" name="IndexName"
                                                placeholder="{{ __('Name of financial index') }}">
                                        </div>
                                    </div>



                                </div>
                                <div class="card-footer">
                                    <div class="form-group row">
                                        <button type="submit" class="btn btn-primary m-1" name="submit"
                                            value="AddIndex">{{ __('update') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>

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


            </div>
        </div>
    </div>

    <!-- Container-fluid Ends-->
    <form method="post">
        @csrf
        <div class="card">
            <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                <h5 class="text-white"> <i style="font-size: 20px" class="i-Library "></i> شاخص های مالی سامانه</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="ul-contact-list" class="{{ \App\myappenv::MainTableClass }}" style="width:100%">
                        <thead>
                            <tr>
                                <th scope="col">{{ __('Name of financial index') }}</th>
                                <th scope="col">وضعیت</th>
                                <th scope="col">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($usercreditindex as $MyPage)
                                <td>{{ $MyPage->IndexName }}</td>
                                @if ($MyPage->IndexType)
                                    <td class="text-success">فعال</td>
                                    <td>
                                        <button type="submit" name="DeleteIndex" value="{{ $MyPage->IndexID }}"
                                            class="btn btn-danger mr-2">
                                            <i class=" nav-icon i-Close-Window font-weight-bold"></i> غیر فعال سازی
                                        </button>
                                    </td>
                                @else
                                    <td class="text-danger" >غیر فعال</td>
                                    <td>
                                        <button type="submit" name="RecoverIndex" value="{{ $MyPage->IndexID }}"
                                            class="btn btn-success mr-2">
                                            <i class="nav-icon i-Refresh font-weight-bold"></i> فعال سازی
                                        </button>
                                    </td>
                                @endif

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-lg-3 " style="margin-top: -10px">
                <ol class="breadcrumb pull-right">
                    <button id="addcontact" type="button" data-toggle="modal" data-target=".bd-example-modal-lg"
                        class="btn btn-warning btn-md m-1">
                        <i class="i-Add  mr-2"></i>افزودن شاخص مالی جدید
                    </button>
                </ol>
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

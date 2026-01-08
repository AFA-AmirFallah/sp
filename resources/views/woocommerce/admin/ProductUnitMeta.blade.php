@php
    $Persian = new App\Functions\persian();
@endphp
@extends('Layouts.MainPage')
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
                                <label for="inputName" class="col-sm-2 col-form-label">نام واحد</label>
                                <div class="col-sm-10">

                                    <input required class="form-control" id="modal_PageName" name="Name"
                                        placeholder="نام واحد کالا">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputName" class="col-sm-2 col-form-label"> واحد مادر</label>
                                <div class="col-sm-10">
                                    <select id="SelectMeta_1" name="MainUnit" class="form-control tocheck"
                                        style="width: 100%">
                                        <option value="0">بدون واحد مادر</option>
                                        @foreach ($ProductUnits as $ProductUnit)
                                            @if ($ProductUnit->MainUnit == null)
                                                <option value="{{ $ProductUnit->id }}">{{ $ProductUnit->Name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputName" class="col-sm-2 col-form-label"> تعداد از واحد مادر</label>
                                <div class="col-sm-10">
                                    <input class="form-control" id="modal_PageName" name="MultiplNumber"
                                        placeholder="تعدادی که در واحد مادر ضرب می شود">
                                </div>
                            </div>
                            <div class="form-group row">
                                <button type="submit" class="btn btn-primary m-1" name="submit"
                                    value="AddIndex">{{ __('update') }}
                                </button>
                                <button type="submit" class="btn btn-primary m-1" name="submit" value="AddUnit"
                                    value="AddIndex">افزودن
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
    <div  class="container-fluid">
        <posts-index></posts-index>
        <div class="page-header">
            <div class="row">
                <div class="col-lg-6">
                    <div class="page-header-left">
                        <h3> فروشگاه
                            <small>مدیریت واحد کالا</small>
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
                            <i class="i-Cube-Molecule text-white mr-2"></i>افزودن واحد کالای جدید
                        </button>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
    <form method="post">
        @csrf
        <div class="card-header gradient-purple-indigo 0-hidden pb-80">
            <h5 class="text-white"> <i class=" header-icon i-Cube-Molecule"></i>مدیریت واحد کالا</h5>
        </div>
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
                        @foreach ($ProductUnits as $ProductUnit)
                            <th scope="row">
                                {{ $ProductUnit->id }}
                            </th>
                            <td>{{ $ProductUnit->Name }}</td>
                            <td></td>
                            <td>
                                <button type="submit" name="DeleteIndex" value="{{ $ProductUnit->id }}"
                                    class="text-success mr-2"
                                    style="width: 30px;height: 30px;padding-left: 0px;
                                                    padding-right: 0px; border: 2px solid #ffffff;    background-color: white;">
                                    <i class="nav-icon i-Close-Window font-weight-bold"></i>
                                </button>
                            </td>
                            </tr>
                        @endforeach
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

@php
$Persian = new App\Functions\persian();
@endphp
@extends("Layouts.MainPage")
@section('page-header-left')

@endsection
@section('MainCountent')
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-lg-6">
                    <div class="page-header-left">
                        <h3>مدیریت
                            <small>نمایش شاخص ها</small>
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
    <!-- begin::modal -->
    <div class="ul-card-list__modal">
        <div class="modal fade SelectBanner" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-body">
                        <h2>بنر یا پوستر</h2>
                        <p>پوستر اضافه کنید</p>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end::modal -->
    <div class="separator-breadcrumb border-top"></div>
    <section class="contact-list">
        <div class="row">
            <div class="col-md-12 mb-4">
                <div class="card text-left">
                    <div class="card-header text-right bg-transparent">
                        <button id="addobject" type="button" data-toggle="modal" data-target=".bd-example-modal-lg"
                            class="btn btn-primary btn-md m-1"> شاخص نمایش اضافه کنید
                        </button>
                    </div>
                    <!-- begin::modal -->
                    <div class="ul-card-list__modal">
                        <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog"
                            aria-labelledby="myLargeModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <form method="post">
                                            @csrf
                                            <div class="form-group row">
                                                <input style="visibility:hidden" id="tableID" name="tableid">
                                            </div>
                                            <div class="form-group row">
                                                <label for="inputName" class="col-sm-2 col-form-label">ترتیب</label>
                                                <div class="col-sm-10">
                                                    <input class="form-control" type="number" id="modal_order"
                                                        name="order" required
                                                        placeholder="ترتیب(کیبورد در حالت انگلیسی باشد)">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="inputName" class="col-sm-2 col-form-label">صفحه</label>
                                                <div class="col-sm-10">
                                                    <input class="form-control" type="number" id="modal_page" name="Page"
                                                        required placeholder="صفحه (کیبورد در حالت انگلیسی باشد)">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="inputName" class="col-sm-2 col-form-label">نام شاخص / متن نمایش </label>
                                                <div class="col-sm-10">
                                                    <input class="form-control" id="modal_title" required name="title"
                                                        placeholder="تایتل">
                                                </div>
                                            </div>
                                            <fieldset class="form-group">
                                                <div class="row">
                                                    <div class="col-form-label col-sm-2 pt-0">وضعیت</div>
                                                    <div class="col-sm-10">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" id="modal_active"
                                                                name="staus" id="gridRadios1" value="1" checked="">
                                                            <label class="form-check-label ml-3" for="gridRadios1">
                                                                فعال
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" id="modal_deactive"
                                                                name="staus" id="gridRadios2" value="0">
                                                            <label class="form-check-label ml-3" for="gridRadios2">
                                                                غیر فعال
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </fieldset>
                                            <div class="form-group row">
                                                <div class="col-sm-10">
                                                    <button id="addelement" type="submit" name="submit" value="add"
                                                        class="btn btn-success">افزودن
                                                    </button>
                                                    <button id="editeelement" type="submit" name="submit" value="edit"
                                                        class="btn btn-success">به روز رسانی
                                                    </button>
                                                    <button id="DeleteElement" type="submit" name="submit" value="delete"
                                                        class="btn btn-danger">حذف
                                                    </button>

                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end::modal -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="ul-contact-list" class="display table " style="width:100%">
                                <thead>
                                    <tr>
                                        <th>کد</th>
                                        <th>ترتیب</th>
                                        <th>تایتل</th>
                                        <th>صفحه</th>
                                        <th>وضعیت</th>
                                        <th>عملیات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($elements as $element)
                                        <tr id="tr_{{ $element->id }}">
                                            <td id="id_{{ $element->id }}">
                                                {{ $element->id }}
                                            </td>
                                            <td id="order_{{ $element->id }}" name="{{ $element->order }}">
                                                {{ $element->order }}</td>
                                            <td id="title_{{ $element->id }}" name="{{ $element->title }}">
                                                {{ $element->title }}</td>

                                            <td id="page_{{ $element->id }}" name="{{ $element->page }}">
                                                {{ $element->page }}</td>
                                            <td id="status_{{ $element->id }}" @if ($element->status == '1')
                                                name="{{ $element->status }}">فعال
                                            </td>
                                        @else
                                            name="{{ $element->status }}"> غیر فعال </td>
                                    @endif

                                    <td>
                                        <button id="{{ $element->id }}" type="button" data-toggle="modal"
                                            data-target=".bd-example-modal-lg" class="btn btn-primary btn-md m-1 edit_btn"
                                            title="Edit">
                                            <i class="i-Edit"></i>
                                        </button>
                                    </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('page-js')


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
@section('bottom-js')

    @include('Layouts.FilemanagerScripts')

@endsection

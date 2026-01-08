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
                        <h3>تم ساز
                            <small>مدیریت المانهای تم</small>
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
    <a href="{{ route('ElementThemeMaker') }}">افزودن المان</a>

    <div class="separator-breadcrumb border-top"></div>
    <section class="contact-list">
        <div class="row">
            <div class="col-md-12 mb-4">
                <div class="card text-left">
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
                                                <label for="inputName" class="col-sm-2 col-form-label">تایتل غیر فعال
                                                </label>
                                                <div class="col-sm-10">
                                                    <input class="form-control" id="modal_title" name="title"
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
                                                    <button id="editeelement" type="submit" name="submit" value="edit"
                                                        class="btn btn-success">به روز رسانی
                                                    </button>
                                                    <button id="DeleteElement" type="submit" name="submit" value="delete"
                                                        class="btn btn-danger">حذف
                                                    </button>
                                                    <a id="eidithref" href="#" class="btn btn-default">ویرایش
                                                    </a>
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
                        <div class="row">

                            <div class="table-responsive">
                                <table id="ul-contact-list" class="display table " style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>کد</th>
                                            <th>ترتیب</th>
                                            <th>تم</th>
                                            <th>تایتل</th>
                                            <th>صفحه</th>
                                            <th>وضعیت</th>
                                            <th>عملیات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($elements as $element)
                                            <input id="href_{{ $element->id }}" type="text" class="nested"
                                                value="{{ route('ElementEditThemeMaker', ['ElementID' => $element->id]) }}">
                                            <tr id="tr_{{ $element->id }}">
                                                <td id="id_{{ $element->id }}">
                                                    {{ $element->id }}
                                                </td>
                                                <td id="order_{{ $element->id }}" name="{{ $element->order }}">
                                                    {{ $element->order }}</td>
                                                <td>{{App\Http\Controllers\WPA_admin\banners::BannerItems[$element->theme] }}</td>
                                                @if ($element->theme == 10)
                                                    @php
                                                        $Title = json_decode($element->title);
                                                    @endphp
                                                    <td id="title_{{ $element->id }}"
                                                        name="{{ substr($Title->Title, 0, 30) }}">
                                                        {{ substr($Title->Title, 0, 30) }}</td>
                                                @else
                                                    <td id="title_{{ $element->id }}"
                                                        name="{{ substr($element->title, 0, 30) }}">
                                                        {{ substr($element->title, 0, 30) }}</td>
                                                @endif

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
                                                data-target=".bd-example-modal-lg" onclick="loaddata({{ $element->id }})"
                                                class="btn btn-primary btn-md m-1 " title="Edit">
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
    @if (app()->getLocale() == 'fa')
        <script src="{{ asset('assets/js/vendor/datatables.min.fa.js') }}"></script>
    @else
        <script src="{{ asset('assets/js/vendor/datatables.min.js') }}"></script>
    @endif


@endsection
@section('bottom-js')
    <script>
        function loaddata($selectID) {
            document.getElementById("tableID").value = $selectID;
            $('#modal_order').val($('#order_' + $selectID).attr('name'));
            $('#modal_page').val($('#page_' + $selectID).attr('name'));
            $('#modal_title').val($('#title_' + $selectID).attr('name'));
            $('#eidithref').attr("href", $('#href_' + $selectID).val());

        }
    </script>
    @include('Layouts.FilemanagerScripts')

@endsection

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
                            <small>نمایش شاخص های کالا</small>
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
                                                <label for="inputName" class="col-sm-2 col-form-label">کد شاخص
                                                </label>
                                                <div class="col-sm-10">
                                                    <input class="form-control" id="modal_TagUID" required name="TagUID"
                                                        placeholder="کد شاخص">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="inputName" class="col-sm-2 col-form-label"> تیتر نمایش
                                                </label>
                                                <div class="col-sm-10">
                                                    <input class="form-control" id="modal_title" required name="title"
                                                        placeholder="متن نمایش">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="inputName" class="col-sm-2 col-form-label"> تعداد نمایش
                                                </label>
                                                <div class="col-sm-10">
                                                    <input type="number" class="form-control" id="modal_Limit" required
                                                        name="Limit" value="">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="inputName" class="col-sm-2 col-form-label"> رنگ پس زمینه
                                                </label>
                                                <div class="col-sm-10">
                                                    <input type="color" id="modal_Backcolor" name="Backcolor" value="#ff0000">
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
                        <div class="row">
                            <div class="col-lg-3">
                                <h4>سرفصل </h4>
                                <select class="form-control" name="WorkCat" id="WorkCatSelectBox"
                                    onchange="WorkCatSelect()">
                                    <option value="0">{{ __('--select--') }}</option>
                                    @foreach ($WorkCats as $WorkCat)
                                        <option value="{{ $WorkCat->ID }}"> {{ $WorkCat->Name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-3">
                                <h4>سردسته </h4>
                                <select class="form-control" name="L1Work" id="L1Select" onchange="L1Selectfun()"
                                    disabled>
                                    <option value="0">{{ __('--select--') }}</option>
                                    @foreach ($L1Works as $L1Work)
                                        <option class="OptionL1 OptionL1_wc{{ $L1Work->WorkCat }}"
                                            value="{{ $L1Work->L1ID }}"> {{ $L1Work->Name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-3">
                                <h4>دسته بندی سرفصل </h4>
                                <select class="form-control" name="L2Work" id="L2Select" onchange="L2Selectfun()"
                                    disabled>
                                    <option value="0">{{ __('--select--') }}</option>
                                    @foreach ($L2Works as $L2Work)
                                        <option class="OptionL2 OptionL2_wc{{ $L2Work->WorkCat }}_L1{{ $L2Work->L1ID }}"
                                            value="{{ $L2Work->L2ID }}"> {{ $L2Work->Name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-3">
                                <h4>دسته </h4>
                                <select class="form-control" name="L3Work" id="L3Select" disabled>
                                    <option value="0">{{ __('--select--') }}</option>
                                    @foreach ($L3Works as $L3Work)
                                        <option
                                            class="OptionL3 OptionL3_wc{{ $L3Work->WorkCat }}_L1{{ $L3Work->L1ID }}_L2{{ $L3Work->L2ID }}"
                                            value="{{ $L3Work->UID }}"> {{ $L3Work->UID }} - {{ $L3Work->Name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <hr>
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
                                        @php
                                            $Sorce = json_decode($element->title);
                                            
                                        @endphp
                                        <tr id="tr_{{ $element->id }}">
                                            <td id="id_{{ $element->id }}">
                                                {{ $element->id }}
                                            </td>
                                            <td id="order_{{ $element->id }}" name="{{ $element->order }}">
                                                {{ $element->order }}</td>

                                            <td id="title_{{ $element->id }}" name="{{ $Sorce->Title }}">
                                                {{ $Sorce->Title }}</td>
                                            <input id="TagUID_{{ $element->id }}" value="{{ $Sorce->TagUID }}" class="nested" >    
                                            <input id="Limit_{{ $element->id }}" value="{{ $Sorce->Limit }}" class="nested" >    
                                            <input id="Backcolor_{{ $element->id }}" value="{{ $Sorce->Backcolor }}" class="nested" >    
                                            <td id="page_{{ $element->id }}" name="{{ $element->page }}">
                                                {{ $element->page }}</td>
                                            <td id="status_{{ $element->id }}" @if ($element->status == '1')
                                                name="{{ $element->status }}">فعال
                                            </td>
                                        @else
                                            name="{{ $element->status }}"> غیر فعال </td>
                                    @endif

                                    <td>
                                        <button onclick="form_loader({{ $element->id }})" id="{{ $element->id }}" type="button"
                                            data-toggle="modal" data-target=".bd-example-modal-lg"
                                            class="btn btn-primary btn-md m-1" title="Edit">
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
    <script>
        function form_loader($selectID) {

            $('#addelement').hide();
            $('#editeelement').show();
            $('#DeleteElement').show();

            $('#modal_order').val($('#order_' + $selectID).attr('name'));
            $('#modal_theme').val($('#theme_' + $selectID).attr('name'));
            $('#modal_pic').val($('#pic_' + $selectID).attr('name'));
            $('#modal_page').val($('#page_' + $selectID).attr('name'));
            $('#modal_title').val($('#title_' + $selectID).attr('name'));
            $('#modal_link').val($('#link_' + $selectID).attr('name'));
            $('#modal_TagUID').val($('#TagUID_' + $selectID).val());
            $('#modal_Limit').val($('#Limit_' + $selectID).val());
            $('#modal_Backcolor').val($('#Backcolor_' + $selectID).val());
            $('#BoxName').val($('#BoxName_' + $selectID).attr('name'));
            document.getElementById("tableID").value = $selectID;
            var $status = $('#status_' + $selectID).attr('name');
            if ($status == '1') {
                $('#modal_active').prop('checked', true);
                $('#modal_deactive').prop('checked', false);
            } else {
                $('#modal_active').prop('checked', false);
                $('#modal_deactive').prop('checked', true);
            }


        }
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
    @if (app()->getLocale() == 'fa')
        <script src="{{ asset('assets/js/vendor/datatables.min.fa.js') }}"></script>
    @else
        <script src="{{ asset('assets/js/vendor/datatables.min.js') }}"></script>
    @endif
    <script>
        function submitter(myid) {
            if ($('#' + myid).val() != '') {
                if (myid != 'WorkCatAddInput') {
                    $('#WorkCatAddInput').val('');
                }
                if (myid != 'L1AddInput') {
                    $('#L1AddInput').val('');
                }
                if (myid != 'L2AddInput') {
                    $('#L2AddInput').val('');
                }
                if (myid != 'L3AddInput') {
                    $('#L3AddInput').val('');
                }

                $("#targetform").submit();
            } else {
                alert('مقدار ورودی نمی تواند خالی باشد');
            }


        }

        function WorkCatSelect() {
            if ($('#WorkCatSelectBox').val() != 0) {
                $(".OptionL1").hide();
                var TargetL1Show = '.OptionL1_wc' + $('#WorkCatSelectBox').val();
                $(TargetL1Show).show();
                $('#L1Select').prop('disabled', false);
                $('#L2Select').prop('disabled', true);
                $('#L3Select').prop('disabled', true);

            } else {
                $('#L1Select').prop('disabled', true);
                $('#L2Select').prop('disabled', true);
                $('#L3Select').prop('disabled', true);
            }
        }

        function L1Selectfun() {
            if ($('#L1Select').val() != 0) {
                var TargetL2Show = '.OptionL2_wc' + $('#WorkCatSelectBox').val() + '_L1' + $('#L1Select').val();
                $(".OptionL2").hide();
                $(TargetL2Show).show();
                $('#L1Select').prop('disabled', false);
                $('#L2Select').prop('disabled', false);
                $('#L3Select').prop('disabled', true);

            } else {
                $('#L1Select').prop('disabled', false);
                $('#L2Select').prop('disabled', true);
                $('#L3Select').prop('disabled', true);
            }
        }

        function L2Selectfun() {
            if ($('#L2Select').val() != 0) {
                var TargetL3Show = '.OptionL3_wc' + $('#WorkCatSelectBox').val() + '_L1' + $('#L1Select').val() + '_L2' + $(
                    '#L2Select').val();
                $(".OptionL3").hide();
                $(TargetL3Show).show();
                $('#L1Select').prop('disabled', false);
                $('#L2Select').prop('disabled', false);
                $('#L3Select').prop('disabled', false);

            } else {
                $('#L1Select').prop('disabled', false);
                $('#L2Select').prop('disabled', false);
                $('#L3Select').prop('disabled', true);
            }
        }
    </script>


@endsection
@section('bottom-js')

    @include('Layouts.FilemanagerScripts')

@endsection

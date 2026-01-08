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
                            <small>پوستر ها اسکرول</small>
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
                            class="btn btn-primary btn-md m-1"> پوستر اضافه کنید
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
                                                <label for="inputName" class="col-sm-2 col-form-label">تایتل</label>
                                                <div class="col-sm-10">
                                                    <input class="form-control" id="modal_title" required name="title"
                                                        placeholder="تایتل">
                                                </div>
                                            </div>
                                            <div class="input-group">
                                                <span class="input-group-btn">
                                                    <a id="lfm_1" data-input="modal_pic_1" data-preview="holder"
                                                        class="btn btn-primary text-white">
                                                        <i class="fa fa-picture-o"></i> انتخاب تصویر
                                                    </a>
                                                </span>
                                                <input id="modal_pic_1" class="form-control" type="text" required
                                                    name="pic1" value="">
                                                <input class="form-control" type="text" id="modal_link_1" name="link1"
                                                    required value="#" placeholder="آدرس">
                                            </div>
                                            <div class="input-group">
                                                <span class="input-group-btn">
                                                    <a id="lfm_2" data-input="modal_pic_2" data-preview="holder"
                                                        class="btn btn-primary text-white">
                                                        <i class="fa fa-picture-o"></i> انتخاب تصویر
                                                    </a>
                                                </span>
                                                <input id="modal_pic_2" class="form-control" type="text" required
                                                    name="pic2" value="">
                                                <input class="form-control" type="text" id="modal_link_2" name="link2"
                                                    required value="#" placeholder="آدرس">

                                            </div>
                                            <div class="input-group">
                                                <span class="input-group-btn">
                                                    <a id="lfm_3" data-input="modal_pic_3" data-preview="holder"
                                                        class="btn btn-primary text-white">
                                                        <i class="fa fa-picture-o"></i> انتخاب تصویر
                                                    </a>
                                                </span>
                                                <input id="modal_pic_3" class="form-control" type="text" required
                                                    name="pic3" value="">
                                                <input class="form-control" type="text" id="modal_link_3" name="link3"
                                                    required value="#" placeholder="آدرس">

                                            </div>
                                            <div class="input-group">
                                                <span class="input-group-btn">
                                                    <a id="lfm_4" data-input="modal_pic_4" data-preview="holder"
                                                        class="btn btn-primary text-white">
                                                        <i class="fa fa-picture-o"></i> انتخاب تصویر
                                                    </a>
                                                </span>
                                                <input id="modal_pic_4" class="form-control" type="text" required
                                                    name="pic4" value="">
                                                <input class="form-control" type="text" id="modal_link_4" name="link4"
                                                    required value="#" placeholder="آدرس">

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
                                        <th>عکس</th>
                                        <th>لینک به</th>
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
                                            <td id="pic_{{ $element->id }}" name="{{ $element->pic }}">مجموعه ۴ تایی
                                                @php
                                                    $Pics = json_decode($element->pic);
                                                @endphp
                                                <input class="nested" id="Pic1_{{ $element->id }}"
                                                    value="{{ $Pics->pic1 }}">
                                                <input class="nested" id="link1_{{ $element->id }}"
                                                    value="{{ $Pics->link1 }}">
                                                <input class="nested" id="Pic2_{{ $element->id }}"
                                                    value="{{ $Pics->pic2 }}">
                                                <input class="nested" id="link2_{{ $element->id }}"
                                                    value="{{ $Pics->link2 }}">
                                                <input class="nested" id="Pic3_{{ $element->id }}"
                                                    value="{{ $Pics->pic3 }}">
                                                <input class="nested" id="link3_{{ $element->id }}"
                                                    value="{{ $Pics->link3 }}">
                                                <input class="nested" id="Pic4_{{ $element->id }}"
                                                    value="{{ $Pics->pic4 }}">
                                                <input class="nested" id="link4_{{ $element->id }}"
                                                    value="{{ $Pics->link4 }}">
                                            </td>
                                            <td id="link_{{ $element->id }}" name="{{ $element->link }}">
                                                {{ $element->link }}</td>
                                            <td id="status_{{ $element->id }}" @if ($element->status == '1')
                                                name="{{ $element->status }}">فعال
                                            </td>
                                        @else
                                            name="{{ $element->status }}"> غیر فعال </td>
                                    @endif

                                    <td>
                                        <button onclick="LoadModal({{ $element->id }})" id="{{ $element->id }}" type="button" data-toggle="modal"
                                            data-target=".bd-example-modal-lg" class="btn btn-primary btn-md m-1"
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

    <script>
        function LoadModal($selectID) {
            $('#addelement').hide();
            $('#editeelement').show();
            $('#DeleteElement').show();
            $('#modal_order').val($('#order_' + $selectID).attr('name'));
            $('#modal_theme').val($('#theme_' + $selectID).attr('name'));
            $('#modal_pic').val($('#pic_' + $selectID).attr('name'));
            $('#modal_page').val($('#page_' + $selectID).attr('name'));
            $('#modal_title').val($('#title_' + $selectID).attr('name'));
            $('#modal_link').val($('#link_' + $selectID).attr('name'));
            $('#BoxName').val($('#BoxName_' + $selectID).attr('name'));
            $('#modal_pic_1').val($('#Pic1_' + $selectID).val());
            $('#modal_link_1').val($('#link1_' + $selectID).val());
            $('#modal_pic_2').val($('#Pic2_' + $selectID).val());
            $('#modal_link_2').val($('#link2_' + $selectID).val());
            $('#modal_pic_3').val($('#Pic3_' + $selectID).val());
            $('#modal_link_3').val($('#link3_' + $selectID).val());
            $('#modal_pic_4').val($('#Pic4_' + $selectID).val());
            $('#modal_link_4').val($('#link4_' + $selectID).val());
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

    <script>
        var lfm = function(id, type, options) {
            let button = document.getElementById(id);
            button.addEventListener('click', function() {
                var route_prefix = (options && options.prefix) ? options.prefix : '/filemanager';
                var target_input = document.getElementById(button.getAttribute('data-input'));
                var target_preview = document.getElementById(button.getAttribute('data-preview'));
                window.open(route_prefix + '?type=' + options.type || 'file', 'FileManager',
                    'width=900,height=600');
                window.SetUrl = function(items) {
                    var file_path = items.map(function(item) {
                        return item.url;
                    }).join(',');
                    // set the value of the desired input to image url
                    target_input.value = file_path;
                    target_input.dispatchEvent(new Event('change'));
                    // clear previous preview
                    target_preview.innerHtml = '';
                    // set or change the preview image src
                    items.forEach(function(item) {
                        let img = document.createElement('img')
                        img.setAttribute('style', 'height: 5rem')
                        img.setAttribute('src', item.thumb_url)
                        target_preview.appendChild(img);
                    });
                    // trigger change event
                    target_preview.dispatchEvent(new Event('change'));
                };
            });
        };
        lfm('lfm2', 'file', {
            prefix: route_prefix
        });
    </script>

@endsection
@section('bottom-js')

    @include('Layouts.FilemanagerScripts')

@endsection

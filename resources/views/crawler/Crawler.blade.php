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
                        <h3>مدیریت
                            <small> کرال ها</small>
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
    @if ($MinSrc->TargetFun == null)
        <hr>
        <form method="POST">
            @csrf
            <div class="card">
                <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                    ثبت فرمول پردازش
                </div>
                <div class="card-body">
                    <small>فرمولی برای پردازش ثبت نشده است جهت پردازش وب سایت میباید یک نمونه از صفحه محصول را
                        برای سیستم مشخص سازید!</small>
                    <br>
                    <label>آدرس لینک محصول </label>
                    <input class="form-control" required name="samplelink" type="text">
                    <br>
                    <label> قیمت محصول </label>
                    <input class="form-control" required name="sampleprice" type="number">
                </div>
                <div class="card-footer">
                    <button class="btn btn-success" name="submit" value="processselect">بررسی فرمول مناسب پردازش</button>
                </div>
            </div>
        </form>
        <hr>
    @endif
    <section class="contact-list">
        <div class="row">
            <div class="col-md-12 mb-4">
                <div class="card text-left">
                    <div class="card-header text-right bg-transparent">
                        <a class="btn btn-success" target="blank" href="?analyze=true">آنالیز تک تک محصولات</a>
                        <form method="POST">
                            @csrf
                            <button class="btn btn-warning" type="submit" name="submit" value="check_all">بررسی
                                صفحات</button>
                        </form>

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
                                                <label for="inputName" class="col-sm-2 col-form-label">نام کرال</label>
                                                <div class="col-sm-10">
                                                    <input class="form-control" type="text" id="modal_Name"
                                                        name="Name" required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="inputName" class="col-sm-2 col-form-label">آدرس XML</label>
                                                <div class="col-sm-10">
                                                    <input class="form-control" type="text" id="modal_XML"
                                                        name="Target1">
                                                </div>
                                            </div>
                                            <fieldset class="form-group">
                                                <div class="row">
                                                    <div class="col-form-label col-sm-2 pt-0">وضعیت</div>
                                                    <div class="col-sm-10">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" id="modal_active"
                                                                name="staus" id="gridRadios1" value="1"
                                                                checked="">
                                                            <label class="form-check-label ml-3" for="gridRadios1">
                                                                فعال
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio"
                                                                id="modal_deactive" name="staus" id="gridRadios2"
                                                                value="0">
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
                                                    <button id="DeleteElement" type="submit" name="submit"
                                                        value="delete" class="btn btn-danger">حذف
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
                            <form method="POST" name="object">
                                <table id="ul-contact-list" class="display table " style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>کد</th>
                                            <th>لینک کرال</th>
                                            <th>وضعیت</th>
                                            <th>تایتل</th>
                                            <th>نوع</th>
                                            <th>توضیحات</th>
                                            <th>قیمت</th>
                                            <th>وضعیت</th>
                                            <th>عملیات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $Conter = 1;
                                        @endphp
                                        @foreach ($Items as $element)
                                            <input class="nested" id="link_id_{{ $Conter }}"
                                                value="{{ $element->id }}">
                                            @php
                                                $Conter++;
                                            @endphp
                                            <tr id="tr_{{ $element->id }}">
                                                <td>{{ $element->id }}</td>
                                                <td>
                                                    @if ($element->Status > 0)
                                                        {{ $element->Name }}
                                                    @endif
                                                    <a href="{{ $element->TargetAddress }}" target="blank">نمایش</a>
                                                </td>
                                                @if ($element->Status == '-1')
                                                    <td>غیر قابل پردازش</td>
                                                @elseif($element->Status == '1')
                                                    <td>فعال</td>
                                                @elseif($element->Status == '2')
                                                    <td>حذف شده</td>
                                                @elseif($element->Status == '3')
                                                    <td>قابل پردازش</td>
                                                @elseif($element->Status == '4')
                                                    <td>فعال</td>
                                                @elseif($element->Status == '0')
                                                    <td>پردازش نشده</td>
                                                @elseif($element->Status == '100')
                                                    <td>مرتبط با محصول</td>
                                                @endif
                                                <td>{{$element->og_title ?? 'not define'}}</td>
                                                <td>{{$element->og_type ?? 'not define'}}</td>
                                                <td>{{$element->og_description ?? 'not define'}}</td>
                                                <td>{{number_format($element->price) }}</td>
                                                <td @if ($element->Status == '1') name="{{ $element->Status }}">فعال
                                            </td>

                                            @else
                                                name="{{ $element->Status }}"> غیر فعال </td> @endif

                                                    @csrf <td> <a type="submit"
                                                        href="{{ route('ItemAnalyze', ['ID' => $element->id]) }}"
                                                        target="blank" class="btn btn-warning">آنالیز</a>
                                                    <button onclick="cheklink('{{ $element->id }}')" type="button"
                                                        class="btn btn-primary btn-md m-1 edit_btn" title="بررسی وضعیت">
                                                        <i class="i-Double-Tap"></i>
                                                    </button>
                                                    <label id="label_{{ $element->id }}"></label>
                                                </td>

                                            </tr>
                                        @endforeach
                                        <input class="nested" id="totalllink" value="{{ $Conter }}">

                                    </tbody>
                                </table>
                            </form>
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
    <script>
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

        function loadmodl($ID, $Name, $Staus, $Target) {
            $('#tableID').val($ID);
            $('#modal_Name').val($Name);
            // $('#tableID').val($Staus);
            $('#modal_XML').val($Target);

        }

        function clearmodl() {
            $('#tableID').val('');
            $('#modal_Name').val('');
            // $('#tableID').val($Staus);
            $('#modal_XML').val('');

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

@php
    $Persian = new App\Functions\persian();
@endphp
@extends('Layouts.MainPage')
@section('page-header-left')
@endsection
@section('MainCountent')
    @if ($ShowMod == 'List')
        <div class="modal fade" id="doblemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">آیا از دوبل کردن محصول مطمئن هستید</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="POST">
                        @csrf
                        <div class="modal-body">
                            درخواست دوبل محصول صادر گردیده این کار خطر ناک هست
                        </div>
                        <input type="text" class="nested" id="dobleproductid" name="ProductId" value="">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">بی خیال</button>
                            <button type="submit" name="submit" value="doble" class="btn btn-danger">دوبل</button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">آیا از حذف محصول مطمئن هستید</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="POST">
                        @csrf
                        <div class="modal-body">
                            درخواست حذف محصول صادر گردیده این کار خطر ناک هست
                        </div>
                        <input type="text" class="nested" id="deleteproductid" name="ProductId" value="">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">بی خیال</button>
                            <button type="submit" name="submit" value="delete" class="btn btn-danger">حذف</button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
        <form method="post">
            @csrf
            <div class="container-fluid">
                <div class="page-header">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="page-header-left">
                                <h3>عملیات محصولات
                                    <small>لیست محصولات</small>
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
            <button onclick="change_to_indexing_mode()" id="indexingmodebtn" type="button" class="btn btn-primary"> شاخص
                گذاری
                سریع</button>
            <a href="{{ route('ProductLsit') }}" class="btn btn-success">جستجوی مجدد</a>
            <button type="button" onclick="converttoedit()" id="converttoedite" class="btn btn-primary">ویرایش گروهی
                محصولات</button>
            <button type="button" id="Aboartedite" class="btn btn-danger nested">{{ __('aboart') }}</button>
            <button type="submit" name="submit" value="updateproductbulk" id="submitedit"
                class="btn btn-success nested">{{ __('Submit') }}</button>
            <div id="indexlistcard" class="card nested">
                <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                    <h5>شاخص های کالا و خدمات</h5>
                </div>
                <div class="card-body">
                    <div class="digital-add needs-validation">
                        <div class="form-group mb-0">
                            <div class="description-sm">
                                {!! $IndexTree !!}
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-0">
                        <div class="product-buttons text-center">
                            <button type="submit" name="submit" value="multiindex" class="btn btn-primary">افزودن شاخص
                                ها</button>

                            <button type="submit" name="submit" value="DeleteIndexes" class="btn btn-danger">حذف شاخص
                                ها</button>

                            <button type="button" class="btn ptn-primary" onclick="change_to_orginal()">بی خیال</button>
                        </div>
                    </div>
                </div>

            </div>
            <div class="card-body">
                <form id="formtarget" method="post">
                    @csrf
                    <div class="table-responsive">
                        <table id="Product-list" class="{{ \App\myappenv::MainTableClass }}" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>کد</th>
                                    <th>نام محصول</th>
                                    <th>مالیات</th>
                                    <th>موجودی</th>
                                    <th>قیمت خرید</th>
                                    <th>قیمت فروش</th>
                                    <th>تاریخ ثبت</th>
                                    <th>عملیات
                                        <input type="checkbox" id="Check_all_input" onchange="CheckDecheck()">
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $Rowno = 1;
                                    $GoodId = null;

                                @endphp

                                @foreach ($goods as $good)
                                    @if ($GoodId == $good->id)
                                        <tr>
                                            <td>{{ $Rowno++ }}</td>
                                            <td>-</td>

                                            <td>-</td>
                                            <td>-</td>
                                            <td>{{ $good->Name }} - {{ $good->QTY }}

                                            </td>
                                            <td>
                                            </td>
                                        </tr>
                                    @else
                                        <tr>
                                            <td>{{ $Rowno++ }}</td>
                                            <td>
                                                <div>
                                                    {{ $good->id }}
                                                </div>



                                            </td>

                                            <td>
                                                <div class="textinfo">
                                                    {{ $good->NameFa }}
                                                    @if ($good->onrent == 1)
                                                        <span class=" ml-3 badge badge-pill badge-danger">اجاره</span>
                                                    @else
                                                        {{ $good->onrent }}
                                                    @endif

                                                </div>
                                                @if (isset($good->wid))
                                                    <input class="inputinfo form-control nested"
                                                        name="good[{{ $good->id }}][{{ $good->wid }}][NameFa]"
                                                        value="{{ $good->NameFa }}" />
                                                    <input class=" form-control nested"
                                                        name="good[{{ $good->id }}][{{ $good->wid }}][oldNameFa]"
                                                        value="{{ $good->NameFa }}" />
                                                @else
                                                    <div class="inputinfo nested">
                                                        {{ $good->NameFa }}
                                                    </div>
                                                @endif
                                            </td>

                                            </td>

                                            <td>
                                                @if ($good->tax_status == 0)
                                                    <i class="i-Money-Bag"
                                                        style="color:green;font-weight: bold;font-size: 20px;">
                                                    </i>
                                                    معاف
                                                @else
                                                    <i class="i-Money-Bag"
                                                        style="color:red;font-weight: bold;font-size: 20px;"></i>
                                                    مشمول
                                                @endif
                                            </td>
                                            @if (isset($good->wid))
                                                <td style="white-space: nowrap;"><a
                                                        href="{{ route('Warehouse', ['StoreID' => $good->wid]) }}">{{ $good->Name }}
                                                        - {{ $good->QTY }}</a> <br>
                                                    @if (isset($good->phone))
                                                        {{ $good->phone }}
                                                    @endif
                                                </td>
                                            @else
                                                <td style="white-space: nowrap;"><a href="#">{{ $good->Name }} -
                                                        {{ $good->QTY }}</a> <br>
                                                    @if (isset($good->phone))
                                                        {{ $good->phone }}
                                                    @endif
                                                </td>
                                            @endif
                                            <td>
                                                <div class="textinfo">
                                                    {{ number_format($good->BuyPrice) }}
                                                </div>
                                                @if (isset($good->wid))
                                                    <input class="inputinfo form-control number-input nested"
                                                        name="good[{{ $good->id }}][{{ $good->wid }}][BuyPrice]"
                                                        value="{{ $good->BuyPrice }}" />
                                                    <input class="form-control nested"
                                                        name="good[{{ $good->id }}][{{ $good->wid }}][oldBuyPrice]"
                                                        value="{{ $good->BuyPrice }}" />
                                                @endif


                                            </td>
                                            <td>
                                                <div class="textinfo">
                                                    @if ($good->Price == 0 && $good->PricePlan != null)
                                                        {{ number_format($good->Price) }}
                                                    @else
                                                        پلکانی
                                                    @endif
                                                </div>
                                                @if (isset($good->wid))
                                                    <input class="inputinfo form-control number-input nested"
                                                        name="good[{{ $good->id }}][{{ $good->wid }}][Price]"
                                                        value="{{ $good->Price }}" />
                                                    <input class="form-control nested"
                                                        name="good[{{ $good->id }}][{{ $good->wid }}][oldPrice]"
                                                        value="{{ $good->Price }}" />
                                                @endif


                                            </td>
                                            <td>
                                                {{ $Persian->MyPersianDate($good->created_at, true) }}

                                            </td>
                                            <td>
                                                <div style="display: flex">
                                                    <a target="_blank" href="{{ Route('EditProduct', $good->id) }}"
                                                        title="ویرایش محصول">
                                                        <i style="font-size: 20px" class="i-Edit"></i>
                                                    </a>
                                                    <button title="حذف محصول"
                                                        style="background: none;border-style: hidden;color: red;cursor: pointer;font-size: 18px;"
                                                        type="button" onclick="validateForm({{ $good->id }})"
                                                        data-toggle="modal" data-target="#exampleModal">
                                                        <i class="i-Delete-File"></i>
                                                    </button>
                                                    <button title="دوبل کردن محصول"
                                                        style="background: none;border-style: hidden;color: blue;cursor: pointer;font-size: 18px;"
                                                        type="button" onclick="validateForm({{ $good->id }})"
                                                        data-toggle="modal" data-target="#doblemodal">
                                                        <i class="i-Duplicate-Layer"></i>
                                                    </button>


                                                </div>
                                                <input class="ProductCheckBox" type="checkbox" name="products[]"
                                                    value="{{ $good->id }}">

                                            </td>
                                        </tr>
                                    @endif
                                @endforeach

                            </tbody>

                        </table>
                    </div>
                </form>
            </div>
        </form>
    @elseif($ShowMod == 'Search')
        <form method="post">
            @csrf
            <div class="container-fluid">
                <div class="row product-adding">
                    <div class="col-xl-6">
                        <div class="card">
                            <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                                <h5 class="text-white"><i class=" header-icon i-Dropbox"></i> جستجوی محصولات</h5>
                            </div>
                            <div class="card-body">
                                <div class="digital-add needs-validation">
                                    <div class="form-group">
                                        <label for="validationCustom01" class="col-form-label pt-0">نام محصول</label>
                                        <input class="form-control" name="ProductName" id="validationCustom01"
                                            type="text">
                                    </div>
                                    <div class="form-group">
                                        <label for="validationCustomtitle" class="col-form-label pt-0">کد محصول - کد محصول
                                            یا SKU</label>
                                        <input class="form-control" name="ProductID" id="validationCustomtitle"
                                            type="text">
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label">وضعیت محصول</label>
                                        <select class="custom-select" name="ProductState">
                                            <option value="">{{ __('--select--') }}</option>
                                            <option value="1">موجود</option>
                                            <option value="2">تمام شده</option>
                                            <option value="3">غیر فعال</option>
                                            <option value="4">بدون تامین کننده</option>
                                            <option value="5">بدون تسهیم</option>
                                            <option value="6">کالاهای در انتظار تایید </option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label">روش تسهیم</label>
                                        <select name="Tashim" class="custom-select">
                                            <option value="">{{ __('--select--') }}</option>
                                            @foreach ($Tashims as $TashimItem)
                                                @if ($TashimItem->Operation == 1)
                                                    <option value="{{ $TashimItem->id }}">{{ $TashimItem->Name }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label">انبار فروشنده</label>
                                        <select id="warehouse" name="Productwarehouse" class="custom-select">
                                            <option value="">{{ __('--select--') }}</option>
                                            @foreach ($Sellers as $SellerTarget)
                                                <option value="{{ $SellerTarget->id }}">{{ $SellerTarget->Name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-xl-6">
                                                <label for="validationCustomtitle" class="col-form-label pt-0">از
                                                    مبلغ</label>
                                                <input class="form-control" name="FromPrice" id="validationCustomtitle"
                                                    type="number">

                                            </div>
                                            <div class="col-xl-6">
                                                <label for="validationCustomtitle"
                                                    class="col-form-label pt-0">تامبلغ</label>
                                                <input class="form-control" name="ToPrice" id="validationCustomtitle"
                                                    type="number">

                                            </div>
                                        </div>

                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-xl-6">
                                                <label for="validationCustomtitle" class="col-form-label pt-0">موجودی از
                                                    تعداد</label>
                                                <input class="form-control" name="FromRemain" id=""
                                                    type="number">

                                            </div>
                                            <div class="col-xl-6">
                                                <label for="validationCustomtitle" class="col-form-label pt-0">موجودی تا
                                                    تعداد</label>
                                                <input class="form-control" name="ToRemain" id=""
                                                    type="number">

                                            </div>
                                        </div>

                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-xl-6">
                                                <label for="validationCustomtitle"
                                                    class="col-form-label pt-0">{{ __('Register from date') }}</label>
                                                <input class="form-control" type="text" name="StartDate"
                                                    autocomplete="off"
                                                    onfocus="Mh1PersianDatePicker.Show(this,'{{ $Persian->MyPersianDate(date('Y-m-d'), false, 'n') }}',)"
                                                    placeholder="{{ __('Register from date') }}" />

                                            </div>
                                            <div class="col-xl-6">
                                                <label for="validationCustomtitle"
                                                    class="col-form-label pt-0">{{ __('Register to date') }}</label>
                                                <input class="form-control" type="text" name="EndDate"
                                                    autocomplete="off"
                                                    onfocus="Mh1PersianDatePicker.Show(this,'{{ $Persian->MyPersianDate(date('Y-m-d'), false, 'n') }}',)"
                                                    placeholder="{{ __('Register to date') }}" />

                                            </div>
                                        </div>

                                    </div>
                                    ` <div class="form-group mb-0">
                                        <div class="product-buttons text-center">
                                            <button type="submit" name="submit" value="Search"
                                                class="btn btn-primary">{{ __('Search') }}</button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6">

                        <div class="card">
                            <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                                <h5 class="text-white"><i class=" header-icon i-Tag-4"></i> جستجو بر اساس شاخص های هوشمند
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="digital-add needs-validation">
                                    <div class="form-group mb-0">
                                        <div class="description-sm">
                                            {!! $IndexTree !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-0">
                                    <div class="product-buttons text-center">
                                        <button type="submit" name="submit" value="indexes"
                                            class="btn btn-primary">{{ __('Search') }}</button>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </form>
    @endif
@endsection
@section('page-js')
    <script>
        $('.number-input').on('input', function() {
            // Remove non-numeric characters from the input value
            var value = $(this).val().replace(/\D/g, '');

            // Format the number with commas
            var formatted_value = value.replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');

            // Update the input value with the formatted number
            $(this).val(formatted_value);
        });


        function converttoedit() {


            $(".textinfo").addClass('nested');
            $(".inputinfo").removeClass('nested');
            $("#converttoedite").addClass('nested');
            $("#Aboartedite").removeClass('nested');
            $("#submitedit").removeClass('nested');

        }
        $(function() {
            $('#Aboartedite').click(function() {
                $(".textinfo").removeClass('nested');
                $("#converttoedite").removeClass('nested');
                $(".inputinfo").addClass('nested');
                $("#Aboartedite").addClass('nested');
                $("#submitedit").addClass('nested');
            });
        });
    </script>
    @if ($ShowMod == 'List')
        <script>
            function validateForm(productid) {
                $('#deleteproductid').val(productid);
                $('#dobleproductid').val(productid);
            }
        </script>
        <script>
            function CheckDecheck() {
                if ($('#Check_all_input').prop('checked') == true) {
                    $('.ProductCheckBox').prop('checked', true);
                } else {
                    $('.ProductCheckBox').prop('checked', false);
                }
            }
        </script>
        <script>
            function change_to_indexing_mode() {
                $('#indexingmodebtn').addClass('nested');
                $('.operation_center').addClass('nested');
                $('#indexlistcard').removeClass('nested');
            }

            function change_to_orginal() {
                $('#indexingmodebtn').removeClass('nested');
                $('.operation_center').removeClass('nested');
                $('#indexlistcard').addClass('nested');

            }
        </script>
        <script>
            $(document).ready(function() {
                        $("#L1").change(function() {
                            var num = this.value;
                            $("#L11").css("display", "none");
                        });
        </script>

        @if (app()->getLocale() == 'fa')
            <script src="{{ asset('assets/js/vendor/datatables.min.fa.js') }}"></script>
        @else
            <script src="{{ asset('assets/js/vendor/datatables.min.js') }}"></script>
        @endif
    @elseif($ShowMod == 'Search')
    @endif

    <script>
        var toggler = document.getElementsByClassName("box");
        var i;

        for (i = 0; i < toggler.length; i++) {
            toggler[i].addEventListener("click", function() {
                if ($(this.parentElement.querySelector("ul")).hasClass('nested')) {
                    $(this.parentElement.querySelector("ul")).removeClass('nested');
                    this.parentElement.querySelector("ul").classList.toggle("active");
                } else {
                    $(this.parentElement.querySelector("ul")).removeClass('active');
                    this.parentElement.querySelector("ul").classList.toggle("nested");
                }


                this.classList.toggle("check-box");
                this.classList.toggle("active");
            });
        }
    </script>
    <script>
        var selected = new Array();
        $(document).ready(function() {

            $("input[type='checkbox']").on('change', function() {
                // check if we are adding, or removing a selected item
                if ($(this).is(":checked")) {
                    selected.push($(this).val());
                } else {
                    for (var i = 0; i < selected.length; i++) {
                        if (selected[i] == $(this).val()) {
                            // remove the item from the array
                            selected.splice(i, 1);
                        }
                    }
                }

                // output selected
                var output = "";
                for (var o = 0; o < selected.length; o++) {
                    if (output.length) {
                        output += ", " + selected[o];
                    } else {
                        output += selected[o];
                    }
                }

                $(".taid").val(output);

            });

        });
    </script>




@endsection
@section('bottom-js')
    <script>
        $('select').select2({
            createTag: function(params) {
                // Don't offset to create a tag if there is no @ symbol
                if (params.term.indexOf('@') === -1) {
                    // Return null to disable tag creation
                    return null;
                }

                return {

                    id: params.term,
                    text: params.term
                }
            }
        });
        $("#warehouse").select2({
            tags: true
        });
    </script>
    <script src="{{ url('/') }}/persian-datepicker/Mh1PersianDatePicker.js"></script>
@endsection

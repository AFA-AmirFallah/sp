@php
$Persian = new App\Functions\persian();
$FormolaItems = 0;
foreach ($Tashim as $TashimItem) {
    if ($TashimItem->ItemOrder == 0) {
        $TashimSample = $TashimItem;
    } else {
        $FormolaItems++;
    }
}
@endphp
@extends('Layouts.MainPage')
@section('page-header-left')
@endsection
@section('MainCountent')
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-lg-6">
                    <div class="page-header-left">
                        <h3>مدیریت مالی
                            <small>ویرایش تسهیم</small>
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

    <div class="md-12">
        <h3 style="text-align: center">نام تسهیم : {{ $TashimSample->Name }}</h3>
    </div>
    <div class="modal fade" id="notloginmodal" tabindex="-1" role="dialog" aria-labelledby="notloginmodalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="notloginmodalLabel">اسکرپیت ها</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p style="color: green">Date: زمان ثبت تراکنش را تغییر میدهد</p>
                    <p>Date = firstmonth_x : ابتدای Xماه آینده</p>
                    <p>Date = firstmonth+x : زمان جاری بعلاوه x روز دیگر</p>
                    <p>Date = firstmonth-x : زمان جاری منهای x روز</p>
                </div>

            </div>
        </div>
    </div>
    <div id="Main_Pannel" class="nested modal-form">
        <form method="post">
            @csrf

            @if ($TashimSample->extra == 'defualt')
                <button type="button" class="btn btn-primary">تسهیم پیش فرض</button>
            @endif
            <div class="card-body">
                <input type="text" name="id" value="{{ $TashimSample->id }}" class="nested">
                <label> نام تسهیم را وارد کنید</label>
                <input type="text" name="Name" required placeholder="نام تسهیم " value="{{ $TashimSample->Name }}"
                    class="form-control">
                <label>توضیحات تسهیم  <small>علامت ~ به معنای نمایش ندادن  است</small></label>
                
                <input type="text" name="Note" required placeholder="توضیحات تسیهیم" value="{{ $TashimSample->Note }}"
                    class="form-control">
                <hr>
                <button type="submit" name="submit" value="updatemain" class="btn btn-warning">ویرایش تسهیم </button>
                <button type="submit" name="submit" value="setDefault" class="btn btn-danger"> این تسهیم به عنوان تسهیم
                    پیش فرض شناخته شود </button>
                <button type="button" onclick="editmain(0)" class="btn btn-success">انصراف</button>

            </div>
        </form>
    </div>
    <div class="nested modal-form" id="operation_pannel">
        <form method="post">
            @csrf
            <input type="text" name="MainTashimName" class="nested" value="{{ $TashimSample->Name }}">
            <input type="text" id="EditId" name="EditId" class="nested" value="">
            <div class="row">
                <div class="card-body col-md-4">
                    <label>کاربر</label>
                    <input type="text" id="TargetUser" name="TargetUser"  required placeholder="نام کاربر"
                        value="{{ old('Name') }}" class="form-control">
                    <li onclick="type_select('buyer')" >buyer: خریدار</li>
                    <li onclick="type_select('Seller')" >Seller: فروشنده - خدمت دهنده</li>
                    <li onclick="type_select('owner')" >owner: مدیر مرکز خدماتی- مالک کالا</li>
                    <li onclick="type_select('Marketer')" >Marketer: بازاریاب</li>
                    <li onclick="type_select('m2')" >m2:  بازاریاب لایه ۲</li>
                    <li onclick="type_select('m3')" >m3:  بازاریاب لایه ۳</li>
                    <li onclick="type_select('Taxer')" >Taxer: مالیات</li>
                    <li onclick="type_select('Insurance')" >Insurance: بیمه</li>
                    <li onclick="type_select('Daramad')" >Daramad: درآمد</li>
                    <script>
                        function type_select(typename){
                            $('#TargetUser').val(typename);
                        }
                    </script>
                    <br>
                    <label>شاخص مالی</label>
                    <select id="CreditIndex" class="form-control" name="CreditIndex">
                        <option value="0">بدون شاخص</option>

                        @foreach ($CreditIndex as $CreditIndexItem)
                            <option value="{{ $CreditIndexItem->IndexID }}">{{ $CreditIndexItem->IndexName }}</option>
                        @endforeach

                    </select>

                    <br>
                    <label>کیف پول</label>
                    <select class="form-control" id="creditMod" name="creditMod">
                        @foreach ($creditMod as $creditModItem)
                            <option value="{{ $creditModItem->ID }}">{{ $creditModItem->ModName }}</option>
                        @endforeach

                    </select>

                </div>
                <div class="card-body col-md-4">
                    <label>فرمول تسهیم</label>
                    <textarea class="form-control" style="direction: ltr" id="FormolStr" name="FormolStr" cols="30" rows="10"></textarea>
                    <li>purchase:  مبلغ خرید کالا- مبلغ پرداختی</li>
                    <li>selling: مبلغ فروش کالا - مبلغ دریافتی</li>
                    <li>shipping: مبلغ ارسال</li>
                    <li>tax: مبلغ مالیات</li>
                    <li>tavan: مبلغ توان پرداخت</li>
                    <li>سایر مبالغ به ریال</li>
                </div>
                <div class="card-body col-md-4">
                    <label>توضیحات تسهیم <small>علامت ~ به معنای نمایش ندادن  است</small></label>
                    <textarea class="form-control" id="Note" name="Note" cols="30" rows="3"></textarea>
                    <label>ترتیب اجرا</label>
                    <input type="number" id="ItemOrder" name="ItemOrder" required placeholder="اولویت اجرا"
                        value="{{ old('ItemOrder') }}" class="form-control">
                    <label>اسکریپت
                        <small>تنظیمات پیشرفته اسکریپتی</small>
                    </label>
                    <textarea class="form-control" style="direction: ltr" id="ItemScript" name="ItemScript" cols="30"
                        rows="7"></textarea>
                    <small style="direction: ltr;float:left">xxxxx = yyyyyy ;</small>
                    <a style="color: blue" data-toggle="modal" data-target="#notloginmodal">توضیحات </a></label>
                </div>
            </div>
            <hr>
            <button type="submit" name="submit" value="save" class="add-range btn btn-warning">ثبت مرحله تسهیم
            </button>
            <button type="submit" name="submit" value="edit" class="edit-range nested btn btn-warning">ویرایش مرحله
                تسهیم
            </button>
            <button type="submit" name="submit" value="delete" class="edit-range nested btn btn-danger">حذف مرحله
                تسهیم
            </button>
            <button type="button" onclick="hideedit()" class="btn btn-success">انصراف</button>

        </form>
    </div>
    <div class="nested modal-form" id="test_pannel">
        <form method="post">
            @csrf
            <input type="text" name="MainTashimName" class="nested" value="{{ $TashimSample->Name }}">
            <input type="text" id="EditId" name="EditId" class="nested" value="">
            <div class="row">
                <div class="card-body col-md-4">
                    <label>مبلغ فروش - مبلغ دریافتی</label>
                    <input type="number" id="SaleMony" value="0" class="form-control">
                    <br>
                    <label>مبلغ خرید - مبلغ پرداختی</label>
                    <input type="number" id="BuyMony" value="0" class="form-control">
                    <br>
                    <label>هزینه ارسال</label>
                    <input type="number" id="DeleverMony" value="0" class="form-control">
                    <br>
                    <label>توان پرداخت</label>
                    <input type="number" id="Tavan" value="0" class="form-control">
                    <label>مالیات</label>
                    <input type="number" id="Tax" value="0" class="form-control">
                    <br>
                    <button type="button" onclick="TestProc({{ $FormolaItems }},{{ $TashimSample->id }})"
                        class="btn btn-success">تست
                        روال</button>
                    <button type="button" onclick="hidetest()" class="btn btn-success">انصراف</button>

                </div>
                <div class="card-body col-md-8">
                    <label>خروجی</label>
                    <textarea class="form-control" style="direction: ltr" id="resutloutput" cols="30" rows="15"></textarea>
                </div>

            </div>
            <hr>
            <button type="submit" name="submit" value="save" class="add-range btn btn-warning">ثبت مرحله تسهیم
            </button>
            <button type="submit" name="submit" value="edit" class="edit-range nested btn btn-warning">ویرایش مرحله
                تسهیم
            </button>
            <button type="submit" name="submit" value="delete" class="edit-range nested btn btn-danger">حذف مرحله
                تسهیم
            </button>
            <button type="button" onclick="hideedit()" class="btn btn-success">انصراف</button>

        </form>
    </div>
    <button type="button" onclick="addformula()" style="float: left;margin-bottom:10px;" class="btn btn-success">افزدون
        فرمول</button>
    <button type="button" onclick="showtest()" style="float: left;margin-bottom:10px;margin-left:10px;"
        class="btn btn-success">تست
        فرمول</button>
        <a href="{{ route('TashimMgt') }}" style="float: left;margin-bottom:10px;margin-left:10px;"
        class="btn btn-danger">
        مدیریت تسهیم</a>

    <div id="list_pannel">
        <form method="post">
            @csrf
            <div class="card-body">
                <div class="table-responsive">
                    <table id="ul-contact-list" class="{{ \App\myappenv::MainTableClass }}" style="width:100%">
                        <thead>
                            <tr>
                                <th scope="col">ترتیب اجرا</th>
                                <th scope="col">توضیحات</th>
                                <th scope="col">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($Tashim as $TashimItem)
                                @if ($TashimItem->ItemOrder == 0)
                                    <td>Main</td>
                                    <td>{{ $TashimItem->Note }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sucess"
                                            onclick="editmain(1)">ویرایش</button>

                                    </td>
                                @else
                                    <tr>
                                        <td>{{ $TashimItem->ItemOrder }}</td>
                                        <td>{{ $TashimItem->Note }}</td>
                                        <td>
                                            <div class="nested" id="formula_{{ $TashimItem->id }}">
                                                {{ $function->format_Extra_view($TashimItem->extra) }}</div>
                                            <button type="button" class="btn btn-sucess"
                                                onclick="editformola({{ $TashimItem->id }},'{{ $TashimItem->TargetUser }}','{{ $TashimItem->CreditIndex }}','{{ $TashimItem->CreditMod }}','{{ $TashimItem->FormolStr }}','{{ $TashimItem->Note }}',{{ $TashimItem->ItemOrder }},{{ $TashimItem->extra }})">ویرایش</button>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('page-js')
    <script>
        function hidetest() {

            $('#test_pannel').addClass('nested');
        }

        function showtest() {
            $('.modal-form').addClass('nested');
            $('#test_pannel').removeClass('nested');
        }

        function TestProc($FormolaQty, $FormolaID) {
            $('#resutloutput').html('');
            $SaleMony = $('#SaleMony').val();
            $BuyMony = $('#BuyMony').val();
            $TaxMony = $('#Tax').val();
            $Tavan = $('#Tavan').val();
            $DeleverMony = $('#DeleverMony').val();
            for (let i = 0; i < $FormolaQty; i++) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.post('<?php echo e(route('ajax')); ?>', {
                        AjaxType: 'TestTashim',
                        FormolaID: $FormolaID,
                        SaleMony: $SaleMony,
                        BuyMony: $BuyMony,
                        TaxMony: $TaxMony,
                        DeleverMony: $DeleverMony,
                        Tavan: $Tavan,
                        Counter: i
                    },

                    function(data, status) {
                        $('#resutloutput').html($('#resutloutput').html() + data);
                    });
            }

        }

        function RestEditValue() {
            $('#TargetUser').val(null);
            $('#EditId').val(null);
            $('#ItemOrder').val(null);
            $('#FormolStr').html(null);
            $('#ItemScript').html(null);
            $('#Note').html(null);
            $('#creditMod option[value="0"]').attr("selected", "selected");
            $('#CreditIndex option[value="0"]').attr("selected", "selected");

        }

        function addformula() {
            RestEditValue();
            $('.modal-form').addClass('nested');
            $('#operation_pannel').removeClass('nested');
            $('.add-range').removeClass('nested');
            $('.edit-range').addClass('nested');

        }

        function hideedit() {
            RestEditValue();
            $('#operation_pannel').addClass('nested');
        }

        function editformola($formolaID, $TargetUser, $CreditIndex, $creditMod, $FormolStr, $Note, $ItemOrder, $Extra) {
            $Mysjon = $('#formula_' + $formolaID).html();

            $('.modal-form').addClass('nested');
            $('#TargetUser').val($TargetUser);
            $('#EditId').val($formolaID);
            $('#ItemOrder').val($ItemOrder);
            $('#FormolStr').html($FormolStr);
            $('#ItemScript').html($Mysjon);
            $('#Note').html($Note);
            $('#creditMod option[value="' + $creditMod + '"]').attr("selected", "selected");
            $('#CreditIndex option[value="' + $CreditIndex + '"]').attr("selected", "selected");
            $('#operation_pannel').removeClass('nested');
            $('.edit-range').removeClass('nested');
            $('.add-range').addClass('nested');
        }

        function editmain($show) {

            if ($show == 1) {
                $('.modal-form').addClass('nested');
                $('#Main_Pannel').removeClass('nested');

            } else {

                $('#Main_Pannel').addClass('nested');

            }
        }
    </script>
@endsection

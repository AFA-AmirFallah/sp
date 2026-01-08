@php
    $Persian = new App\Functions\persian();
@endphp
@extends('Layouts.MainPage')
@section('page-header-left')
@endsection
@section('MainCountent')
    <style>
        .label_red {
            color: red;
        }
    </style>
    @include('deal/objects/stepers_dealer', ['target_step' => 1, 'file_id' => $file_id])
    <form action="">
        @csrf
    </form>
    <div class="2-columns-form-layout">
        <div class="">
            <div class="row">
                <div class="col-lg-12">
                    <!-- start card -->
                    <div class="card">
                        <div class="card-header bg-transparent">
                            <h5>{{ $deal_src->title }}</h5>
                        </div>
                        <!--begin::form-->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h3 class="card-title">فایل قسمت عمومی</h3>
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label for="inputEmail1" class="ul-form__label"> دسته بندی

                                            </label>
                                            <select name="post_cat" class="form-control tocheck" style="width: 100%">
                                                @foreach ($deal_functions->get_post_cats() as $cat)
                                                    <option value="{{ $cat->UID }}"
                                                        @if ($deal_src->post_cat == $cat->UID) selected @endif>
                                                        {{ $cat->Name }}</option>
                                                @endforeach
                                            </select>
                                            <small id="sku_samall" class="ul-form__text form-text ">
                                                سرفصل اصلی </small>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="inputEmail1" class="ul-form__label"> نوع مورد معامله

                                            </label>
                                            @php
                                                $old_product_type = $deal_src->product_type ?? 0;
                                            @endphp

                                            <select name="product_type" disabled class="form-control tocheck"
                                                style="width: 100%">
                                                @foreach ($deal_functions->get_product_type() as $product_type)
                                                    @if ($product_type->id == $old_product_type)
                                                        <option selected value="{{ $product_type->id }}">
                                                            {{ $product_type->Name }}
                                                        </option>
                                                    @endif
                                                @endforeach

                                            </select>
                                            <small id="sku_samall" class="ul-form__text form-text ">
                                                نوع مورد معامله
                                            </small>
                                        </div>
                                        @php
                                            $old_deal_type = $deal_src->deal_type ?? 0;
                                        @endphp
                                        <div class="form-group col-md-6">
                                            <label for="inputEmail2" class="ul-form__label">نوع معامله
                                            </label>

                                            <select name="deal_type" disabled class="form-control tocheck"
                                                style="width: 100%">
                                                <option @if ($old_deal_type == 1) selected @endif value="1">
                                                    فروش نقدی</option>
                                                <option @if ($old_deal_type == 2) selected @endif value="2">
                                                    فروش اقساطی</option>
                                            </select>
                                            <small id="product_name_small" class="ul-form__text form-text ">
                                                مورد معامله نامی است که در آگهی از آن استفاده می شود
                                            </small>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="inputEmail2" class="ul-form__label">مورد معامله
                                            </label>

                                            <input type="text" class="form-control" disabled name="title"
                                                placeholder="نام مورد معامله" value="{{ $deal_src->title ?? '' }}">
                                            <small id="product_name_small" class="ul-form__text form-text ">
                                                مورد معامله نامی است که در آگهی از آن استفاده می شود
                                            </small>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="inputEmail3" class="ul-form__label">مبلغ در آگهی
                                            </label>

                                            <div class="input-right-icon">
                                                <input type="text" class="form-control" disabled name="show_price"
                                                    required placeholder="توافقی - ۱۰۰ میلون تومان"
                                                    value="{{ $deal_src->show_price ?? '' }}">
                                            </div>
                                        </div>

                                    </div>


                                    <div class="form-row">
                                        <div class="form-group col-md-12">

                                            <label for="inputEmail3" class="ul-form__label">توضیحات
                                            </label>

                                            <div class="disable-note input-right-icon">
                                                {!! $deal_src->description !!}

                                            </div>

                                        </div>

                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <h3 class="card-title">فایل قسمت همکاران (اختصاصی)</h3>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label class="ul-form__label">حداقل مبلغ
                                            </label>
                                            <div class="input-right-icon">
                                                <input class="form-control" disabled
                                                    value="{{ number_format($deal_src->min_price ?? 0) }}">

                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="ul-form__label">حداکثر مبلغ
                                            </label>
                                            <div class="input-right-icon">
                                                <input class="form-control" disabled
                                                    value="{{ number_format($deal_src->max_price ?? 0) }}">
                                            </div>
                                        </div>

                                    </div>
                                    @php
                                        $old_location = $deal_src->location ?? 0;
                                    @endphp
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label class="ul-form__label">محل مورد
                                            </label>
                                            <div class="input-right-icon">
                                                <select name="location" disabled class="form-control tocheck"
                                                    style="width: 100%">
                                                    <option @if ($old_location == 1) selected @endif
                                                        value="1">نمایشگاه</option>
                                                    <option @if ($old_location == 2) selected @endif
                                                        value="2">در اختیار مالک</option>
                                                    <option @if ($old_location == 3) selected @endif
                                                        value="3">نمایشگاه همکار</option>
                                                </select>
                                            </div>
                                        </div>
                                        @php
                                            $username = $deal_src->owner ?? null;
                                        @endphp
                                        <div class="form-group col-md-6">
                                            <label for="inputEmail1" class="ul-form__label"> مالک

                                            </label>
                                            @php
                                                $user_src = \App\Users\UserClass::get_user_by_username($username);
                                            @endphp
                                            <input type="text" class="form-control" disabled
                                                value="{{ $user_src->Name }} {{ $user_src->Family }}">
                                            <small id="sku_samall" class="ul-form__text form-text ">
                                                <button type="button" onclick="BothSideCalls('{{ $user_src->MobileNo }}')"
                                                    class="btn btn-success" style="margin:auto;display:block"
                                                    name="submit">
                                                    تماس با مالک
                                                </button>

                                            </small>
                                        </div>

                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label class="ul-form__label">شماره پلاک
                                            </label>
                                            <input type="text" disabled class="form-control" name="pelak"
                                                placeholder="شماره پلاک خودرو" value="{{ $deal_src->pelak ?? '' }}">
                                            <small id="sku_samall" class="ul-form__text form-text ">
                                                ۸۷ د ۷۱۱ ایرن ۸۸
                                            </small>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="inputEmail1" class="ul-form__label">
                                                vin
                                            </label>
                                            <input disabled type="text" class="form-control" name="vin"
                                                placeholder="کد VIN خودرو" value="{{ $deal_src->vin ?? '' }}">
                                            <small id="sku_samall" class="ul-form__text form-text ">
                                                کد vin خودرو
                                            </small>
                                        </div>

                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label for="inputEmail3" class="ul-form__label">توضیحات برای همکار
                                            </label>

                                            <div class="disable-note input-right-icon">
                                                {!! $deal_src->dealer_note ?? '' !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>


                        </div>
                        <!-- end::form -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="2-columns-form-layout">
        <div class="">
            <div class="row">
                <div class="col-lg-12">
                    <!-- start card -->
                    <div class="card">
                        <div class="card-header bg-transparent">
                            <h5>مشخصات مربوط به : {{ $deal_src->title }}</h5>
                        </div>
                        <!--begin::form-->
                        <div class="card-body">
                            <table class="display table table-striped table-bordered dataTable">
                                <thead>
                                    <tr>
                                        <th>
                                            مشخصه
                                        </th>
                                        <th>
                                            مقدار
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i = 0;
                                    @endphp
                                    @foreach ($properties as $propertie)
                                        @php
                                            $i++;
                                        @endphp
                                        <tr>
                                            <td>{{ $propertie['name'] }}</td>
                                            <td class="inputinfo ">{{ $propertie['value'] }}
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>

                        </div>
                        <div class="card-footer">
                            <button type="submit" name="submit" value="add" class="btn btn-success">ذخیره</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="2-columns-form-layout">
        <div class="">
            <div class="row">
                <div class="col-lg-12">
                    <!-- start card -->
                    <div class="card">
                        <div class="card-header bg-transparent">
                            <h5>تصاویر مربوط به : {{ $deal_src->title }}</h5>
                        </div>
                        <!--begin::form-->
                        <div class="card-body">
                            <div class="row">
                                @foreach ($img_src ?? [] as $img_item)
                                    <div class="col-md-3">
                                        <div class="card mb-4 o-hidden">
                                            <img class="card-img-top" src="{{ $img_item->pic }}" alt="">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <!-- end::form -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
    @section('page-js')
        <script>
            function BothSideCalls(target_phone) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.post('', {
                        ajax: true,
                        function: 'bothsidecall',
                        target: target_phone
                    },
                    function(data, status) {
                        alert(data);
                    });

            }
        </script>
    @endsection

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
    @include('statistic/objects/header')


    <div class="2-columns-form-layout">
        <div class="">
            <div class="row">
                <div class="col-lg-12">
                    <!-- start card -->
                    <div class="card">
                        <div class="card-header bg-transparent">
                            <h5>ویرایش آمار </h5>
                        </div>
                        <!--begin::form-->
                        <div class="card-body">
                            <div class="row">
                                <form style="display: contents" method="post">
                                    @csrf
                                    <div class="col-md-6">
                                        <h3 class="card-title">آمار قسمت عمومی</h3>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">

                                                <label for="inputEmail1" class="ul-form__label">شعبه

                                                </label>
                                                <select name="branch" class="form-control tocheck" style="width: 100%">
                                                    @foreach ($branch_src as $branch_item)
                                                        <option @if ($statistic_src->branch == $branch_item->id) selected @endif
                                                            value="{{ $branch_item->id }}">
                                                            {{ $branch_item->Name }}</option>
                                                    @endforeach
                                                </select>
                                                <small id="sku_samall" class="ul-form__text form-text ">
                                                    سرفصل اصلی </small>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="inputEmail1" class="ul-form__label"> نوع آمار یا نظر سنجی

                                                </label>


                                                <select name="type" class="form-control tocheck" style="width: 100%">
                                                    @foreach ($statistic_class->get_statistic_type() as $type_item)
                                                        <option @if ($statistic_src->type == $type_item['id']) selected @endif
                                                            value="{{ $type_item['id'] }}">
                                                            {{ $type_item['name'] }}</option>
                                                    @endforeach

                                                </select>

                                            </div>
                                            @php
                                                $old_deal_type = $deal_src->deal_type ?? 0;
                                            @endphp
                                            <div class="form-group col-md-12">
                                                <label for="inputEmail2" class="ul-form__label"> نام آمار یا نظر سنجی
                                                </label>
                                                <span class="label_red">*</span>
                                                <input type="text" class="form-control" required name="Name"
                                                    placeholder="نام  " value="{{ $statistic_src->Name }}">

                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="inputEmail2" class="ul-form__label">دوره زمانی
                                                </label>
                                                <span class="label_red">*</span>
                                                <input type="number" class="form-control" required name="period"
                                                    placeholder="دوره زمانی" value="{{ $statistic_src->period }}">
                                                <small id="product_name_small" class="ul-form__text form-text ">
                                                    عدد ۰ به معنای بدون دوره هست - دوره به دقیقه
                                                </small>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="inputEmail2" class="ul-form__label">پست مرتبط
                                                </label>
                                                <span class="label_red">*</span>
                                                <input type="number" class="form-control" required name="post"
                                                    placeholder="آیدی پست مرتبط" value="{{ $statistic_src->post }}">
                                                <small id="product_name_small" class="ul-form__text form-text ">
                                                    عدد صفر به معنای بدون پست است
                                                </small>
                                            </div>
                                        </div>


                                        <div class="form-row">
                                            <div class="form-group col-md-12">

                                                <label for="inputEmail3" class="ul-form__label">توضیحات
                                                </label>
                                                <span class="label_red">*</span>
                                                <div class="input-right-icon">
                                                    <textarea id="hiddenArea" name="desc" required class="ckeditor-basic col-sm-12 form-control">{{ $statistic_src->desc ?? '' }}</textarea>

                                                </div>

                                            </div>

                                        </div>
                                        <div class="row">
                                            <button type="submit" class="btn btn-primary m-1" name="submit"
                                                value="edit_main_file">ثبت فایل </button>
                                            @if ($statistic_src->status == 0)
                                                <button type="submit" class="btn btn-success m-1" name="submit"
                                                    value="activate"> فعال سازی </button>
                                            @else
                                                <button type="submit" class="btn btn-danger m-1" name="submit"
                                                    value="deactivate"> غیر سازی </button>
                                            @endif
                                        </div>
                                    </div>
                                </form>

                                <div class="col-md-6">
                                    @include('statistic.objects.item_list')
                                    @include('statistic.objects.item_add')
                                </div>
                            </div>


                        </div>
                        <!-- end::form -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('page-js')
    @include('Layouts.SearchUserInput_Js')
    @if (Auth::user()->Role == \App\myappenv::role_SuperAdmin || Auth::user()->Role == \App\myappenv::role_ShopAdmin)
        @include('Layouts.FilemanagerScripts')
    @endif
    <script>
        function load_item(item_id, item_name, item_index_str) {
            $('#item_name').val(item_name);
            $('#item_index_str').val(item_index_str);
            $('#item_id').val(item_id);
            $('#edit-zone').removeClass('d-none');
            $('#add_item').addClass('d-none');
        }

        function cancel_edit() {
            $('#item_name').val('');
            $('#item_index_str').val('');
            $('#edit-zone').addClass('d-none');
            $('#add_item').removeClass('d-none');
        }
    </script>
@endsection

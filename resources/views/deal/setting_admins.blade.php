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

    @include('deal/objects/header')
    @include('deal/objects/stepers', ['target_step' => 5, 'file_id' => $file_id])

    <form method="post" enctype="multipart/form-data">
        @csrf
        <div class="2-columns-form-layout">
            <div class="">
                <div class="row">
                    <div class="col-lg-12">
                        <!-- start card -->
                        <div class="card">
                            <div class="card-header bg-transparent">
                                <h5>تنظیمات مربوط به : {{ $deal_src->title }}</h5>
                            </div>
                            <!--begin::form-->
                            <div class="card-body">
                                @if ($deal_src->status < 100)
                                    <p class="text-danger"> وضعیت فعلی: غیر فعال</p>
                                @else
                                    <p class="text-success"> وضعیت فعلی: فعال </p>
                                @endif

                                <hr>
                                <button type="submit" name="submit" value="101" class="btn btn-success">فعال
                                    سازی</button>
                                <button type="submit" name="submit" value="0" class="btn btn-danger">غیر فعال
                                    سازی</button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

    </form>
@endsection
@section('page-js')
@endsection

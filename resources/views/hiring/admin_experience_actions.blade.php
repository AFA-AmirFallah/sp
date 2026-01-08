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
    @include('hiring/objects/stepers_comments', ['target_step' => 4, 'id' => $id])
    <div class="main-content">
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="card-title mb-3">عملیات گزارش</div>
                        <form method="POST">
                            @csrf
                            <div class="row">
                                <div class="ul-product-detail__quantity d-flex align-items-center mt-3">
                                    <input type="number" name="weight" value="1" class="form-control col-2">
                                    <button type="submit" name="submit" value="confirm" class="btn btn-primary m-1">
                                        <i class="i-Time-Backup text-18"> </i>
                                        تائید گزارش </button>
                                    <small>وزن تائید ۱ تا ۱۰ می باشد</small>
                                </div>
                                <div class="ul-product-detail__quantity d-flex align-items-center mt-3">
                                    <button type="submit" name="submit" value="reject" class="btn btn-danger m-1">
                                        <i class="i-Data-Block text-18"> </i>
                                        رد گزارش </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
@section('page-js')
@endsection

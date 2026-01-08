@php
$Persian = new App\Functions\persian();
@endphp
@extends("Layouts.MainPage")
@section('page-header-left')
    <h3>{{ __('Pats') }}
        <small>{{ __('My pats') }}</small>
    </h3>
@endsection
@section('MainCountent')
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-lg-6">
                    <div class="page-header-left">
                        <h3>ویرایش
                            <small>نظرات </small>
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card tab2-card">
                    <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                        <h5>متن نظر</h5>
                        <a href="{{ route('ShowNewsItem', ['NewsId' => $Comment->Post]) }}">بازگشت به خبر</a>
                    </div>
                    <form method="POST">
                        @csrf
                        <div class="card-body">
                            <input class="nested" type="text" name="Post" value="{{ $Comment->Post }}">

                            @if ($Comment->name != null)
                                <label>نام </label>
                                <input required class="form-control" type="text" name="name"
                                    value="{{ $Comment->name }}">
                                <label>ایمیل </label>
                                <input required class="form-control" type="text" name="email"
                                    value="{{ $Comment->email }}">
                                <label>موبایل </label>
                                <input required class="form-control" type="text" name="MobileNumber"
                                    value="{{ $Comment->MobileNumber }}">
                            @endif

                            <label>پیام </label>
                            <textarea name="message" class="form-control" cols="30"
                                rows="10">{{ $Comment->message }}</textarea>
                            <hr>
                            <button type="submit" class="btn btn-success" name="submit" value="edit"> ثبت تغییرات</button>
                            <button type="submit" class="btn btn-danger" name="submit" value="delete"> حذف</button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->

@endsection
@section('bottom-js')

    @include('Layouts.FilemanagerScripts')

@endsection

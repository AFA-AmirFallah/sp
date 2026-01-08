@extends('Layouts.Theme7.layout.main_layout')
@section('content')
    <div class="section-full content-inner-2 browse-job">
        <div class="container">
            <h1 class="form-header">ثبت تجربه دریافت خدمات درمانی ،مراقبتی</h1>
            <div id="save_result" class="success_box container text-center">
                <img class="success_box" src="/Theme7/images/success.png" alt="success">
                <h1>
                    گزارش تائید نشده!
                </h1>
                <p>شما یک گزارش ثبت شده‌ باز دارید</p>
                <p>پس از تائید گزارش شما توسط کارشناسان میتوانید مجددا گزارش ثبت کنید.</p>
                <a href="{{ route('experience_list') }}">فهرست گزارش‌های ثبت شده توسط شما</a>
            </div>
        </div>
    </div>
@endsection

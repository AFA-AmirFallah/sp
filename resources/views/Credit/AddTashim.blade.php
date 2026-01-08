@php
$Persian = new App\Functions\persian();
@endphp
@extends("Layouts.MainPage")
@section('page-header-left')
@endsection
@section('MainCountent')

    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-lg-6">
                    <div class="page-header-left">
                        <h3>مدیریت مالی
                            <small>افزودن تسهیم جدید</small>
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
    <form method="post">
        @csrf
        <div class="card-body">
            <label> نام تسهیم جدید را وارد کنید</label>
            <input type="text" name="Name" required placeholder="نام تسهیم جدید" value="{{ old("Name") }}" class="form-control">
            <label>توضیحات تسهیم    <small>علامت ~ به معنای نمایش ندادن  است</small></label>
          
            <input type="text" name="Note" required placeholder="توضیحات تسیهیم" value="{{ old("ٔNote") }}" class="form-control">
            <hr>
            <button type="submit" name="submit" value="save" class="btn btn-warning">ثبت تسهیم جدید</button>
        </div>


    </form>
@endsection
@section('page-js')

@endsection

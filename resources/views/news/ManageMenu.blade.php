@extends("Layouts.MainPage")
@section('page-header-left')
@endsection
@section('MainCountent')
    <form method="POST">
        @csrf
        <textarea id="hiddenArea" name="myobject" style="direction: ltr;text-align: left;" rows="50" class="col-sm-12 form-control">{{$newsmenu->htmlobj }} </textarea>
        <hr>
        <div class="pull-right">
            <button type="submit" name="Registeruser" value="register" class="btn btn-primary">
                ذخیره
            </button>
        </div>
    </form>
@endsection
@section('page-js')

    @include('Layouts.FilemanagerScripts')

@endsection

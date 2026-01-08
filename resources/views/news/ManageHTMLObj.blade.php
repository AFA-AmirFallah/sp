@extends('Layouts.MainPage')
@section('page-header-left')
@endsection
@section('MainCountent')
    @if ($html_object == null)
        <form method="POST">
            @csrf
            <label for="">شعبه</label>
            <select class="form-control" name="branch">
                @foreach ($branches as $branch_item)
                    <option value="{{ $branch_item->id }}">{{ $branch_item->Name }}</option>
                @endforeach
            </select>
            <label for="">نام المان</label>
            <input class="form-control" type="text" name="htmlname" required>
            <hr>
            <textarea id="hiddenArea" name="myobject" style="direction: ltr;text-align: left;" rows="50"
                class="col-sm-12 form-control"> </textarea>
            <hr>
            <div class="pull-right">
                <button type="submit" name="submit" value="addhtml" class="btn btn-primary">
                    ذخیره
                </button>
            </div>
        </form>
    @else
        <form method="POST">
            @csrf
            <label for="">شعبه</label>
            <select class="form-control" name="branch">
                @foreach ($branches as $branch_item)
                    <option value="{{ $branch_item->id }}" @if ($html_object->branch == $branch_item->id) selected @endif>
                        {{ $branch_item->Name }}</option>
                @endforeach
            </select>
            <label for="">نام المان</label>
            <input class="form-control" type="text" name="htmlname" value="{{ $html_object->htmlname }}" required>
            <hr>
            <textarea id="hiddenArea" name="myobject" style="direction: ltr;text-align: left;" rows="50"
                class="col-sm-12 form-control">{!! $html_object->htmlobj !!} </textarea>
            <hr>
            <div class="pull-right">
                <button type="submit" name="submit" value="update" class="btn btn-primary">
                    ذخیره
                </button>
                <button type="submit" name="submit" value="add_with_new_branch" class="btn btn-warning">
                    ذخیره برای شعبه جدید
                </button>
            </div>
        </form>
    @endif
@endsection
@section('page-js')
    @include('Layouts.FilemanagerScripts')
@endsection

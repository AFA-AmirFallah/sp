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
                        <h3>مدیریت مطالب
                            <small> ویرایش پوشش سر فصل</small>
                        </h3>
                    </div>
                </div>
                <div class="col-lg-6">
                    <ol class="breadcrumb pull-right">
                        <li class="breadcrumb-item"><a href="#"><i data-feather="home"></i></a>
                        </li>
                        <li class="breadcrumb-item">مدیریت پوشش</li>
                        <li class="breadcrumb-item active">ویرایش  پوشش سر فصل</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card tab2-card">
                    <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                        <h5>محتوای خبر</h5>
                        <img id="imagepreviw" style="float: left;max-height: 100px;" src="{{$News->MainPic}}">
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs tab-coupon" id="myTab" role="tablist">
                            <li class="nav-item"><a class="nav-link active show" id="account-tab" data-toggle="tab"
                                    href="#account" role="tab" aria-controls="account" aria-selected="true"
                                    data-original-title="" title="">ویرایش
                                    پوشش</a>
                            </li>

                        </ul>
                        <form method="post" class="needs-validation user-add" novalidate="">
                            @csrf
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade active show" id="account" role="tabpanel"
                                    aria-labelledby="account-tab">
                                    <h4>جزئیات پوشش</h4>
                                    <div class="form-group row">
                                        <label for="validationCustom0" class="col-xl-3 col-md-4"> دسته
                                            خبری</label>
                                        <select id="NewsCat" name="NewsCat" class="form-control col-xl-8 col-md-7">
                                            <option value="0">{{ __('--select--') }} </option>
                                            @foreach ($cats as $cat)
                                                <option value="{{ $cat->UID }}" @if ($News->MainIndex == $cat->UID) selected @endif>
                                                    {{ $cat->Name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <p style="color: red">یا</p>
                                    <div class="form-group row">
                                        <label for="validationCustom0" class="col-xl-3 col-md-4"> شاخص </label>
                                        <select id="SelectTags" name="SelectTags" class="form-control col-xl-8 col-md-7">
                                            <option value="0">{{ __('--select--') }} </option>
                                            @foreach ($Tags as $Tag)
                                                <option value="{{ $Tag->UID }}" @if ($Tag->UID == $News->MainIndex) selected @endif>
                                                    {{ $Tag->Name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group row">
                                        <label for="validationCustom0" class="col-xl-3 col-md-4"><span>*</span>
                                            تایتل</label>

                                        <textarea id="hiddenArea1" name="Titel" required=""
                                            class="form-control col-xl-8 col-md-7 ">{!! $News->Titel !!} </textarea>



                                    </div>
                                    <div class="form-group row">
                                        <label for="validationCustom0" class="col-xl-3 col-md-4"><span>*</span>
                                            {{ __('Name') }}</label>
                                        <input class="form-control col-xl-8 col-md-7" name="Name"
                                            value="{{ $News->Name }}" type="text" required="">

                                    </div>
                                    <div class="form-group row">
                                        <label for="validationCustom0" class="col-xl-3 col-md-4"><span>*</span>
                                            تصویر</label>
                                        <a id="lfm" data-input="modal_pic" data-preview="holder"
                                            class="btn btn-primary text-white">
                                            <i class="fa fa-picture-o"></i> انتخاب تصویر
                                        </a>
                                        <input id="modal_pic" class="form-control nested" type="text" name="pic" value="{{$News->MainPic}}"
                                            onchange="imagesetter()">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="validationCustom0" class="col-xl-3 col-md-4"><span>*</span> متن خبر</label>
                                </div>

                                <textarea id="hiddenArea" name="ce"
                                    class="col-sm-12 form-control">{!!$News->Content!!} </textarea>

                            </div>
                            <div class="pull-right">
                                <button type="submit" name="submit" value="SaveChange" class="btn btn-primary">
                                    ذخیره
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->

@endsection
@section('bottom-js')

    <script>
        $('select').select2({
            createTag: function(params) {
                // Don't offset to create a tag if there is no @ symbol
                if (params.term.indexOf('@') === -1) {
                    // Return null to disable tag creation
                    return null;
                }

                return {

                    id: params.term,
                    text: params.term
                }
            }
        });
        $("#SelectTags").select2({
            tags: true
        });
        $("#NewsCat").select2({
            tags: true
        });
    </script>
    @include('Layouts.FilemanagerScripts')
    <script>
        function imagesetter() {
            //alert(document.getElementById("modal_pic").value)  ;
            document.getElementById("imagepreviw").src = document.getElementById("modal_pic").value;
        }
    </script>

@endsection

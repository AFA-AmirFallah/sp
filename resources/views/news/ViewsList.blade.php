@extends("Layouts.MainPage")
@section("page-header-left")
    <h3>{{__('Pats')}}
        <small>{{__('My pats')}}</small>
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
                            <small>اضافه کردن مطلب</small>
                        </h3>
                    </div>
                </div>
                <div class="col-lg-6">
                    <ol class="breadcrumb pull-right">
                        <li class="breadcrumb-item"><a href="#"><i data-feather="home"></i></a>
                        </li>
                        <li class="breadcrumb-item">مدیریت خبر</li>
                        <li class="breadcrumb-item active">اضافه کردن خبر</li>
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
                        <img id="imagepreviw" style="float: left;max-height: 100px;" src="">
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs tab-coupon" id="myTab" role="tablist">
                            <li class="nav-item"><a class="nav-link active show" id="account-tab"
                                                    data-toggle="tab" href="#account" role="tab" aria-controls="account"
                                                    aria-selected="true" data-original-title="" title="">اضافه کردن
                                    مطالب</a>
                            </li>

                        </ul>
                        <form method="post" class="needs-validation user-add" novalidate="">
                            @csrf
                            <div class="form-group row" style="margin-top: 14px;margin-right: 20px;">
                                <div>
                                    <label> خبر داغ</label>
                                    <input class="form-group" type="checkbox" name="hotnews"
                                           @if(old('hotnews') == 1)
                                           checked
                                           @endif
                                           value="1">

                                </div>
                                <div style="margin-right: 20px">
                                    <label>تبلیغات</label>
                                    <input class="form-group" type="checkbox" name="adds"
                                           @if(old('adds') == 1)
                                           checked
                                           @endif
                                           value="1">
                                </div>
                            </div>

                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade active show" id="account" role="tabpanel"
                                     aria-labelledby="account-tab">
                                    <h4>جزئیات خبر</h4>
                                    <div class="form-group row">
                                        <label for="validationCustom0"
                                               class="col-xl-3 col-md-4"><span>*</span> دسته خبری</label>
                                        <select id="NewsCat" name="NewsCat" class="form-control col-xl-8 col-md-7">
                                            <option>{{__("--select--")}} </option>
                                            @foreach($cats as $cat)
                                                <option
                                                    @if(old('NewsCat') == $cat->Name)
                                                    selected="selected"
                                                    @endif
                                                >{{$cat->Name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group row">
                                        <label for="validationCustom0"
                                               class="col-xl-3 col-md-4"><span>*</span> تایتل</label>
                                        <input class="form-control col-xl-8 col-md-7" name="Titel"
                                               placeholder="تایتل خبر"
                                               type="text" value="{{old('Titel')}}" required="">
                                    </div>
                                    <div class="form-group row">
                                        <label for="validationCustom0"
                                               class="col-xl-3 col-md-4"><span>*</span> {{__('Name')}}</label>
                                        <input class="form-control col-xl-8 col-md-7" name="Name"
                                               value="{{old('Name')}}"
                                               type="text" required="">

                                    </div>
                                    <div class="form-group row">
                                        <label for="validationCustom0"
                                               class="col-xl-3 col-md-4"><span>*</span> تصویر</label>
                                        <a id="lfm" data-input="modal_pic" data-preview="holder"
                                           class="btn btn-primary text-white">
                                            <i class="fa fa-picture-o"></i> انتخاب تصویر
                                        </a>
                                        <input id="modal_pic" class="form-control nested" type="text"
                                               name="pic" value="" onchange="imagesetter()">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="validationCustom0"
                                           class="col-xl-3 col-md-4"> شاخص </label>
                                    <select id="SelectTags" name="SelectTags[]"
                                            class="form-control col-xl-8 col-md-7"
                                            multiple="multiple">
                                        @foreach($Tags as $Tag)
                                            <option
                                                @if($Tag->PostId != null)
                                                selected="selected"
                                                @endif
                                            >{{$Tag->Name}}
                                            </option>
                                        @endforeach
                                    </select>

                                </div>

                                <div class="form-group row">
                                    <label for="validationCustom0"
                                           class="col-xl-3 col-md-4"><span>*</span> متن خبر</label>
                                </div>

                                <textarea id="hiddenArea" name="ce"
                                          class="col-sm-12 form-control">{{old('ce')}} </textarea>

                            </div>
                            <div class="pull-right">
                                <button type="submit" name="Registeruser" value="register" class="btn btn-primary">
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
            createTag: function (params) {
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

@extends('Layouts.MainPage')
@section('page-header-left')
    <h3>{{ __('Pats') }}
        <small>{{ __('My pats') }}</small>
    </h3>
@endsection
@section('MainCountent')
    <input class="nested" id="main-menu" value="#userworks">
    <input class="nested" id="sub-menu" value="#User_add">
    <div class="row">
        <div class=" col-lg-3 col-md-6 col-sm-6 ">
            <a href="{{ route('CreateUser') }}">
                <div class="navcard active-navcard card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                    <div class="card-body text-center">
                        <i class="i-Add-User"></i>
                        <div class="content">
                            <p class=" mt-2 mb-0 text-white"> افزودن کاربر</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 ">
            <a href="{{ route('UserSearch') }}">
                <div class="navcard navcard-main card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                    <div class="card-body text-center">
                        <i style="color: red" class="i-Receipt-4"></i>
                        <div class="content">
                            <p class="text-primary mt-2 mb-0">لیست کاربران</p>

                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card tab2-card">
                    <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                        <h5 class="text-white"> <i class="header-icon i-Add-User"></i> {{ __('User add') }}</h5>
                    </div>
                    <div class="card-body">
                        <form method="post" class="needs-validation user-add" novalidate="">
                            @csrf
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade active show" id="account" role="tabpanel"
                                    aria-labelledby="account-tab">

                                    <h4>{{ __('Detail of user account') }}</h4>
                                    <div class="form-group row">
                                        <label for="validationCustom0" class="col-xl-3 col-md-4"><span>*</span>
                                            {{ __('Sex') }}</label>
                                        <div class="col-xl-9 col-sm-8">
                                            <div
                                                class="form-group m-checkbox-inline mb-0 custom-radio-ml d-flex radio-animated">
                                                <label style="margin-left: 10px" class="d-block" for="edo-ani1">
                                                    <input class="radio_animated" type="radio" name="Sex"
                                                        value="m" checked=""><i style="font-size: 20px"
                                                        class="i-Business-Man"></i>
                                                    {{ __('Man') }}
                                                </label>

                                                <label class="d-block" for="edo-ani2">
                                                    <input class="radio_animated" type="radio" name="Sex"
                                                        @if (old('Sex') == 'f') checked="" @endif value="f">
                                                    <i style="font-size: 20px" class="i-Business-Woman"></i>
                                                    {{ __('Woman') }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="validationCustom0" class="col-xl-3 col-md-4"><span>*</span>
                                            {{ __('Name') }}</label>
                                        <input class="form-control col-xl-8 col-md-7" name="ADDName"
                                            value="{{ old('ADDName') }}" type="text" required="">
                                    </div>
                                    <div class="form-group row">
                                        <label for="validationCustom1"
                                            class="col-xl-3 col-md-4"><span>*</span>{{ __('Family') }}</label>
                                        <input class="form-control col-xl-8 col-md-7" name="ADDFamily"
                                            value="{{ old('ADDFamily') }}" type="text" required="">
                                    </div>
                                    <div class="form-group row">
                                        <label for="validationCustom2" class="col-xl-3 col-md-4"><span>*</span>
                                            {{ __('Mobile namber') }}</label>
                                        <input class="form-control col-xl-8 col-md-7" name="ADDMobileNumber"
                                            value="{{ old('ADDMobileNumber') }}" inputmode="numeric" type="text"
                                            required="">
                                    </div>
                                    <div class="form-group row">
                                        <label for="validationCustom2" class="col-xl-3 col-md-4"><span>*</span>
                                            کدملی</label>
                                        <input class="form-control col-xl-8 col-md-7" name="ADDMelliID"
                                            value="{{ old('ADDMelliID') }}" type="text" inputmode="numeric"
                                            required="">
                                    </div>
                                    <div class="form-group row">
                                        <label for="validationCustom2" class="col-xl-3 col-md-4"><span></span>
                                            {{ __('Email') }}</label>
                                        <input class="form-control col-xl-8 col-md-7" name="ADDMailAddress"
                                            value="{{ old('ADDMailAddress') }}" type="text" required="">
                                    </div>
                                    <div class="form-group row">
                                        <label for="validationCustom3"
                                            class="col-xl-3 col-md-4"><span>*</span>{{ __('Password') }}</label>
                                        <input class="form-control col-xl-8 col-md-7" name="ADDPassword"
                                            value="{{ old('ADDPassword') }}" type="text" required="">
                                    </div>
                                    <div class="form-group row">
                                        <label for="validationCustom3"
                                            class="col-xl-3 col-md-4"><span>*</span>{{ __('User Role') }}</label>
                                        <select name="ADDRole" class="custom-select col-xl-8 col-md-7">
                                            <option value="0" selected>{{ __('--select--') }}</option>
                                            @foreach ($ResultRole as $Rolerow)
                                                @if ($Rolerow->Role == old('ADDRole'))
                                                    <option value="{{ $Rolerow->Role }}" selected>
                                                        {{ $Rolerow->RoleName }}</option>
                                                @else
                                                    <option value="{{ $Rolerow->Role }}">{{ $Rolerow->RoleName }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    @if (Auth::user()->branch == \App\myappenv::Branch)
                                        <div class="form-group row">
                                            <label for="validationCustom3"
                                                class="col-xl-3 col-md-4"><span>*</span>شعبه</label>
                                            <select name="branch" class="custom-select col-xl-8 col-md-7">
                                                <option value="0" selected>{{ __('--select--') }}</option>
                                                @foreach (\App\Branchs\BranchsFunctions::get_all_branches() as $Branch)
                                                    @if ($Branch->id == old('branch'))
                                                        <option value="{{ $Branch->id }}" selected>
                                                            {{ $Branch->Name }}</option>
                                                    @else
                                                        <option value="{{ $Branch->id }}">{{ $Branch->Name }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    @endif

                                </div>

                            </div>
                            <div class="pull-right">
                                <button type="submit" name="Registeruser" value="register"
                                    class="btn btn-primary">ذخیره</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
@endsection

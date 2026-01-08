@php
    $Persian = new App\Functions\persian();
@endphp
@extends('Layouts.MainPage')
@section('page-header-left')
@endsection
@section('MainCountent')
    <style>
        .btnaria-header {
            margin-right: -7px;
            margin-bottom: -32px;
        }
    </style>
    <form style="all: unset" method="post">
        @csrf
        <div style="display: flex" class="breadcrumb">
            <h1> گروه : {{ $group_src->name }}
                @switch($group_src->status)
                    @case(0)
                        <p class="text-danger">غیر فعال</p>
                        <button name="change_status" value="100" class="btn btn-success">فعال سازی</button>
                    @break

                    @case(100)
                        <p class="text-success"> فعال</p>
                        <button name="change_status" value="0" class="btn btn-danger">غیر فعال سازی</button>
                    @break

                    @default
                @endswitch
            </h1>

        </div>
    </form>


    <div class="col-lg-6 col-md-12 mb-5">
        <div class="card">
            <div style="text-align: center" class="card-header green">
                <div class="card-title"> <i class="i-Checked-User"
                        style="font-size: 30px;display: inherit;color: cornsilk;"></i> اعضای گروه
                </div>
            </div>
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table" id="basic-1" style="width: 100%;text-align:center">
                        <thead>
                            <tr>
                                <th>نام</th>
                                <th> نقش</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($group_member_src as $group_member_item)
                                <tr>
                                    <td>{{ $group_member_item->user_name }} {{ $group_member_item->user_family }}</td>
                                    @switch($group_member_item->auto_role_id)
                                        @case(1)
                                            <td class="text-success"> عضو </td>
                                        @break

                                        @case(100)
                                            <td class="text-danger"> مدیر </td>
                                        @break

                                        @default
                                    @endswitch
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                    <div class="form-group col-md-6">
                        <label for="inputEmail4" class="ul-form__label">عضو جدید :</label>
                        @include('Layouts.SearchUserInput', [
                            'InputName' => 'UserName',
                            'InputPalceholder' => __('Target username'),
                            'type' => 'call_center',
                        ])
                        <small class="ul-form__text form-text ">
                            {{ __('The Username of peple who credit transfer') }}
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="separator-breadcrumb border-top"></div>
@endsection

@section('page-js')
    @include('Layouts.SearchUserInput_Js')
    <script src="{{ asset('assets/js/vendor/datatables.min.fa.js') }}"></script>
    <!-- page script -->
    <script src="{{ asset('assets/js/tooltip.script.js') }}"></script>
    <script src="{{ asset('assets/js/moment.js') }}"></script>



    <script></script>
    <script src="{{ asset('assets/js/vendor/datatables.min.fa.js') }}"></script>
@endsection

@section('bottom-js')
@endsection

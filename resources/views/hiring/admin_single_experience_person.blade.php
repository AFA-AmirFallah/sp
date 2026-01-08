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
    @include('hiring/objects/stepers_comments', ['target_step' => 2, 'id' => $id])
    <div class="row">

        <div class=" col-md-6">
            <div class="card o-hidden mb-4">
                <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                    <h3 id="Table-card-header" class="text-white  w-50 float-left card-title m-0"><i
                            class=" header-icon i-Nurse"></i> تخصیص نیرو</h3>
                </div>
                <div class="card-body">
                    <form method="POST">
                        @csrf
                        <p>تخصیص نیروی اعلام شده توسط مشتری به کاربران دیگر سامانه</p>
                        <div class="col-lg-6">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text bg-transparent">
                                        <i class="i-Checked-User"></i>
                                    </div>
                                </div>
                                <input type="text" class="form-control" name="target_username" id="target_username"
                                    placeholder="نام کاربری">
                            </div>
                            <p class="text-danger" id="error_item"></p>
                        </div>
                        <div class="col-lg-6">
                            <button type="button" onclick="check_excahnge()" class="btn btn-primary">بررسی</button>
                            <button type="button" id="exchange-show" onclick="load_userinfo('show_exchange')" disabled
                                class="btn btn-primary">نمایش کاربر</button>

                            <button id="exchange-btn" type="submit" name="submit" disabled value="exchange"
                                class="btn btn-warning">تجمیع
                                نیرو</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>



        <div class=" col-md-6">
            <div class="card o-hidden mb-4">
                <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                    <h3 id="Table-card-header" class="text-white  w-50 float-left card-title m-0"><i
                            class=" header-icon i-Nurse"></i> تخصیص شاخص های اعلامی</h3>
                </div>
                <div class="card-body">
                    <p>تخصیص نیروی اعلام شده توسط مشتری به کاربران دیگر سامانه</p>
                    @foreach ($index_src as $index_item)
                        @if ($index_item->L2ID == 1)
                            <span class="badge badge-pill badge-success p-2 m-1">{{ $index_item->Name }}</span>
                        @else
                            <span class="badge badge-pill badge-danger p-2 m-1">{{ $index_item->Name }}</span>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div id="table-continer" class=" col-md-12">
            <div class="card o-hidden mb-4">
                <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                    <h3 id="Table-card-header" class="text-white  w-50 float-left card-title m-0"><i
                            class=" header-icon i-Nurse"></i> اطلاعات نیروی عملیاتی <a
                            href="javascript:load_userinfo('{{ $comment_src['related_person'] }}')"
                            class="btn btn-success">بارگذاری</a></h3>
                </div>
                <div id="card-body" class="card-body">
                </div>
            </div>
        </div>
        <!-- end of col-->
    </div>
@endsection
@section('page-js')
    <script>
        function load_userinfo(username) {
            if (username == 'show_exchange') {
                username = $('#target_username').val();
            }
            $('#card-body').html(` <iframe style="height:800px; width: 100%;" src="/UserProfile/` + username +
                `?if=true" frameborder="0"></iframe>`);
        }

        function check_excahnge() {
            username = $('#target_username').val();
            $('#error_item').html('');
            if (username == '') {
                $('#error_item').html('نام کاربری نمیتواند خالی باشد!');
                return false;
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('', {
                    function: 'check_exchange',
                    UserName: username,
                },
                function(data, status) {
                    if (data['result']) {
                        $('#exchange-btn').prop("disabled", false);
                        $('#exchange-show').prop("disabled", false);
                        return true;

                    } else {
                        $('#exchange-btn').prop("disabled", true);
                        $('#error_item').html(data['msg']);
                        return false;
                    }
                });

        }
    </script>
@endsection

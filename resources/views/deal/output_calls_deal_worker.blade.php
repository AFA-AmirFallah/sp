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
    @include('deal/objects/stepers_dealer', ['target_step' => 3, 'file_id' => $file_id])

    <div class="row">
        <div class="col-lg-6 mb-3">
            <div class="card">
                <div class="card-header bg-transparent">
                    <h3 class="card-title">برقراری ارتباط</h3>
                </div>
                <!--begin::form-->
                <form action="">
                    <div class="card-body">
                        <div class="form-row ">
                            <div id="search_box" class="form-group col-md-12">

                                <label for="inputEmail4" class="ul-form__label">جستجو - شماره تماس :</label>
                                <div class="input-group mb-3">
                                    @include('Layouts.SearchUserInput', [
                                        'InputName' => 'UserName',
                                        'InputPalceholder' => __('Target username'),
                                    ])
                                </div>
                            </div>
                            <div class="row nested contact_action" id="contact_show">
                                <div class="form-group col-md-12">
                                    <a href="javascript:closecontact()"
                                        style="
                                left: 20px;
                                position: absolute;
                            ">بستن</a>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="inputEmail4" class="ul-form__label">شماره</label>
                                    <div class="input-group mb-3">
                                        <input type="text" id="input_number" class="contact-detail form-control" disabled
                                            placeholder="">
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="inputEmail4" class="ul-form__label">نام</label>
                                    <div class="input-group mb-3">
                                        <input type="text" id="user_name" class="contact-detail form-control"
                                            placeholder="">
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="inputEmail4" class="ul-form__label">نام خانوادگی</label>
                                    <div class="input-group mb-3">
                                        <input type="text" id="user_family" class="contact-detail form-control"
                                            placeholder="">
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="inputEmail4" class="ul-form__label">جنسیت</label>
                                    <div class="input-group mb-3">
                                        <select class="form-control" name="Sex" id="user_sex">
                                            <option value="f">خانم</option>
                                            <option value="m">آقا</option>
                                        </select>
                                    </div>
                                </div>
                            </div>


                        </div>
                        <div class="custom-separator"></div>
                        <div id="sms_box" class="nested form-group col-md-12">
                            <textarea class="form-control contact-detail" name="sms_text" id="sms_text" cols="30" rows="10"></textarea>
                            <button type="button" onclick="send_sms()" class="btn btn-outline-secondary m-1">ارسال
                            </button>

                        </div>

                    </div>
                    <div class="card-footer bg-transparent">
                        <div class="mc-footer">
                            <div id="action_fotter" class="row contact_action nested ">
                                <div class="col-lg-12">
                                    <button type="button" onclick="call_by_search()" class="btn  btn-primary m-1">برقراری
                                        تماس</button>
                                    <button disabled type="button" onclick="ready_to_sms()"
                                        class="btn btn-outline-secondary m-1">ارسال پیام</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- end::form -->
            </div>
        </div>
        <div id="table-continer" class="col-lg-6 mb-3">
            <div class="card o-hidden mb-4">
                <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                    <h3 id="Table-card-header" class="text-white  w-50 float-left card-title m-0"><i
                            class=" header-icon i-Business-Mens"></i> تماسهای خروجی مرتبط با این فایل </h3>
                </div>
                <div class="card-body">
                    <form method="post">
                        @csrf
                        <div class="card-body">

                            <div class="table-responsive">
                                <table id="ul-contact-list" class="{{ \App\myappenv::MainTableClass }}" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>{{ __('No.') }}</th>
                                            <th>تماس گیرنده</th>
                                            <th>پاسخگو</th>
                                            <th>تاریخ تماس</th>
                                            <th>{{ __('Actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $Rowno = 1;
                                        @endphp
                                        @foreach ($calls_src as $calls_item)
                                            <tr>
                                                <td>{{ $Rowno }}</td>
                                                <td>{{ $calls_item->NameC }} {{ $calls_item->FamilyC }} </td>
                                                <td>{{ $calls_item->NameA }} {{ $calls_item->FamilyA }}</td>
                                                <td>{{ $Persian->MyPersianDate($calls_item->created_at, true) }}</td>
                                                <td>
                                                    <a href="javascript:BothSideCalls('{{ $calls_item->call_number }}')">تماس
                                                        مجدد</a>
                                                </td>
                                            </tr>
                                            @php
                                                $Rowno++;
                                            @endphp
                                        @endforeach


                                    </tbody>

                                </table>
                            </div>

                        </div>
                        <button type="submit" name="submit" class="btn btn-success select-div nested" value="tmpsave">ثبت
                            موقت کاربران</button>
                    </form>
                </div>
            </div>
        </div>
        <!-- end of col-->
    </div>
@endsection
@section('page-js')
    <script src="{{ asset('assets/js/vendor/datatables.min.fa.js') }}"></script>
    @include('Layouts.SearchUserInput_Js_with_add')
    <script>
        function send_sms() {
            sms_text = $('#sms_text').val();
            if (sms_text.length < 4) {
                alert('متن پیام را وارد کنید');
                return false;
            }
            input_value = $('#user_search_responser_text').val();
            if (/^[0-9]+(?:\.[0-9]+)?$/.test(input_value)) {
                if (input_value.length == 11) {
                    inputname = $('#user_name').val();
                    name = jQuery.trim(name);
                    family = $('#user_family').val();
                    family = jQuery.trim(family);
                    sex = $('#user_sex').val();
                    if (inputname == '') {
                        alert('لطفا نام را وارد کنید');
                        return false;
                    }
                    if (family == '') {
                        alert('لطفا فامیل را وارد کنید');
                        return false;
                    }
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.post('', {
                            ajax: true,
                            function: 'send_sms_add_user',
                            Name: inputname,
                            Family: family,
                            Sex: sex,
                            MobileNo: input_value
                        },
                        function(data, status) {
                            alert(data);
                            closecontact();
                        });



                } else {
                    alert('شماره وارد شده صحیح نیست!');
                }

            } else { // the user aleady exist
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.post('', {
                        ajax: true,
                        function: 'send_sms',
                        target: input_value,
                        text:sms_text
                    },
                    function(data, status) {
                        alert(data);
                    });
                closecontact();
            }



        }

        function call_by_search() { // new user
            input_value = $('#user_search_responser_text').val();
            if (/^[0-9]+(?:\.[0-9]+)?$/.test(input_value)) {
                if (input_value.length == 11) {
                    inputname = $('#user_name').val();
                    name = jQuery.trim(name);
                    family = $('#user_family').val();
                    family = jQuery.trim(family);
                    sex = $('#user_sex').val();
                    if (inputname == '') {
                        alert('لطفا نام را وارد کنید');
                        return false;
                    }
                    if (family == '') {
                        alert('لطفا فامیل را وارد کنید');
                        return false;
                    }
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.post('', {
                            ajax: true,
                            function: 'bothsidecall_with_add',
                            Name: inputname,
                            Family: family,
                            Sex: sex,
                            MobileNo: input_value
                        },
                        function(data, status) {
                            alert(data);
                            closecontact();
                        });



                } else {
                    alert('شماره وارد شده صحیح نیست!');
                }

            } else { // the user aleady exist
                BothSideCalls(target_username);
                closecontact();
            }
        }

        function BothSideCalls(target_phone) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('', {
                    ajax: true,
                    function: 'bothsidecall',
                    target: target_phone
                },
                function(data, status) {
                    alert(data);
                });

        }
    </script>
    <script>
        $('#ul-contact-list').DataTable();
    </script>
    <script>
        function closecontact() {
            $('.contact_action').addClass('nested');
            $('#sms_box').addClass('nested');
            $('#search_box').removeClass('nested');

            changestatetosearcharia();
            $('.contact-detail').val('');
        }

        function load_save_contact(input_number) {
            $('.contact_action').removeClass('nested');
            $('#search_box').addClass('nested');
            $('#input_number').val(input_number);

            //close modal
            $('#user-search-aria').addClass('nested');
            $('#user-show-aria').removeClass('nested');
            $('.modal').modal("hide");
            $("#user-list-suggesstion-box").html('');
        }

        function ready_to_sms() {
            $('#sms_box').removeClass('nested');
        }
    </script>
@endsection

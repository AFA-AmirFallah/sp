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

    <div class="breadcrumb">
        <h1>میز کار من</h1>
    </div>
    
    <div class="separator-breadcrumb border-top"></div>
    <form method="post">
        @csrf
        @foreach ($Desk->get_sessions() as $session)
            <button type="submit" name="DeleteList" value="{{ $session[1] }}" class="btn btn-danger btn-block m-1 mb-3">حذف
                {{ $session[0] }}</button>
        @endforeach
    </form>
    
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <!-- CARD ICON -->
            <div class="row">
                <div class="col-lg-2 col-md-3 col-sm-3">
                    <div class="card card-icon mb-4">
                        <div class="card-header text-center blue text-white font-weight-bold ">
                            <i class="i-Notepad text-white mt-1" style="font-size: 30px"></i>
                            پروژه های من
                        </div>
                        <div class="card-body text-center">


                            <div class="btnaria-header" style="display: flex">
                                <button type="button" onclick="openform('createProject')"
                                    class="btn btn-danger btn-block m-1 mb-3">افرودن <i class=" text-white"></i></button>
                                <button type="button" onclick="LoadProject()"
                                    class="btn btn-primary btn-block m-1 mb-3">فهرست <i class=" text-white"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-3">
                    <div class="card card-icon mb-4">
                        <div class="card-header text-center pink text-white font-weight-bold ">
                            <i class="i-Professor text-white mt-1" style="font-size: 30px"></i>
                            وظایف من
                        </div>
                        <div class="card-body text-center">

                            <div class="btnaria-header" style="display: flex">
                                <button onclick="ShowOrders()" type="button"
                                    class="btn btn-danger btn-block m-1 mb-3">سفارشات</button>
                                <button onclick="ShowMyProjects()" type="button"
                                    class="btn btn-primary btn-block m-1 mb-3">پروژه ها</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-3">
                    <div class="card card-icon mb-4">
                        <div class="card-header text-center cyan text-white font-weight-bold ">
                            <i class="i-Old-Telephone text-white mt-1" style="font-size: 30px"></i>
                            تماس من
                        </div>
                        <div class="card-body text-center">

                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-3">
                    <div class="card card-icon mb-4">
                        <div class="card-header text-center indigo text-white font-weight-bold ">
                            <i class="i-Add-User text-white mt-1" style="font-size: 30px"></i>
                            کاربران من
                        </div>
                        <div class="card-body text-center">
                            <div class="btnaria-header" style="display: flex">
                                <button onclick="ShowMyLink()" type="button" class="btn btn-danger btn-block m-1 mb-3">لینک
                                    اختصاصی</button>
                                <button onclick="ShowMyUsers()" type="button"
                                    class="btn btn-primary btn-block m-1 mb-3">فهرست </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-3">
                    <div class="card card-icon mb-4">
                        <div class="card-header text-center orange text-white font-weight-bold ">
                            <i class="i-Paper-Plane text-white mt-1" style="font-size: 30px"></i>
                            تیکت ها
                        </div>
                        <div class="card-body text-center">

                            <div class="btnaria-header" style="display: flex">
                                <button type="button" onclick="openform('SendTicket')"
                                    class="btn btn-danger btn-block m-1 mb-3">افرودن <i class=" text-white"></i></button>
                                <button type="button" class="btn btn-primary btn-block m-1 mb-3">فهرست <i
                                        class=" text-white"></i></button>
                            </div>

                        </div>
                    </div>
                </div>


                <div onclick="openform('sendnotif')" class="col-lg-2 col-md-3 col-sm-3">
                    <div class="card card-icon mb-4">
                        <div class="card-header text-center green text-white font-weight-bold ">
                            <i class="i-Mailbox-Full text-white mt-1" style="font-size: 30px"></i>
                            اعلان ها
                        </div>
                        <div class="card-body text-center">
                            <div class="btnaria-header" style="display: flex">
                                <button type="button" class="btn btn-danger btn-block m-1 mb-3">افرودن <i
                                        class=" text-white"></i></button>
                                <button type="button" class="btn btn-primary btn-block m-1 mb-3">فهرست <i
                                        class=" text-white"></i></button>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
    <hr>
    <div class="row">

        <!-- end of col-->

        <div id="table-continer" class="nested targetForm col-md-12">
            <div class="card o-hidden mb-4">
                <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                    <h3 id="Table-card-header" class="w-50 float-left card-title m-0">{{ __('Total Sales') }}</h3>
                    <div class="dropdown dropleft text-right w-50 float-right">
                        <button class="btn bg-gray-100" type="button" id="dropdownMenuButton_table_1"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="nav-icon i-Gear-2"></i>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton_table_1">
                            <a class="dropdown-item" href="#">{{ __('Add New User') }}</a>
                            <a class="dropdown-item" href="#">{{ __('View All User') }}</a>
                            <a class="dropdown-item" href="#">{{ __('Something') }}</a>
                        </div>
                    </div>

                </div>
                <div class="card-body">

                    <div class="table-responsive">

                        <table id="MainTable" class="table  text-center">
                            <thead id="main-table-header">
                            </thead>
                            <tbody id="MainTable_body">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- end of col-->
    </div>
    <div id="formloader1" class="row targetForm nested">

    </div>
    <div id="createProject" class="row targetForm nested">
        <div class="col-lg-12 mb-12">
            <div class="card">
                <div class="card-header bg-transparent">
                    <h3 class="card-title">ساخت پروژه</h3>
                </div>
                <form method="post">
                    @csrf
                    <div class="card-body">
                        <div class="form-row ">
                            <div class="form-group col-md-6">
                                <label for="inputEmail4" class="ul-form__label">نام پروژه :</label>
                                <input required type="text" class="form-control" name="subject" id=""
                                    placeholder=" نام پروژه" value="">
                                <small class="ul-form__text form-text ">
                                    نام پروژه
                                </small>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputEmail4" class="ul-form__label">توضیح پروژه :</label>
                                <input required type="text" class="form-control" name="desc" id=""
                                    placeholder="متن مختصری از پروژه" value="">
                                <small class="ul-form__text form-text ">
                                    متن مختصری از پروژه
                                </small>
                            </div>
                            <div class="form-group col-md-12">
                                <label class="ul-form__label">متن پروژه</label>
                                <small class="ul-form__text form-text ">
                                    تمامی مواردی که لازم است در خصوص پروژه دیگران بدانند!
                                </small>
                                <textarea required required name="ce" class="col-sm-12 form-control"></textarea>

                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent">
                        <div class="mc-footer">
                            <div class="row">
                                <div class="col-lg-12">
                                    <button type="submit" name="submit" value="makeProject"
                                        class="btn  btn-primary m-1">ثبت
                                        پروژه</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- end::form -->
            </div>
        </div>
    </div>
    <div class="row">
        <div id="row-div-continer" class="nested targetForm col-md-12">
            <div class="card o-hidden mb-4">
                <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                    <h3 id="row-div-card-header" class="w-50 float-left card-title m-0"></h3>
                </div>
                <div id="row-div-card-body" class="card-body">

                </div>

            </div>
        </div>
    </div>
    <div id="SendTicket" class="row targetForm nested">
        <div class="col-lg-12 mb-12">
            <div class="card">
                <div class="card-header bg-transparent">
                    <h3 class="card-title">ارسال تیکت</h3>
                </div>
                <form action="{{ route('tikets') }}" method="post">
                    @csrf
                    <input class="nested" name="desk" value="true">
                    <div class="card-body">
                        <div class="form-row ">
                            <div class="form-group col-md-12 ">
                                <label for="inputEmail4" class="ul-form__label"> به کاربر:</label>
                                @include('Layouts.SearchUserInput', [
                                    'InputName' => 'ToUser',
                                    'InputPalceholder' => __('Target username'),
                                ])
                                <small class="ul-form__text form-text ">
                                    نام کاربر
                                </small>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputEmail4" class="ul-form__label">موضوع :</label>
                                <input type="text" class="form-control" name="subject" id=""
                                    placeholder="{{ __('Ticket subject') }}" value="">
                                <small class="ul-form__text form-text ">
                                    موضوع تیکت
                                </small>
                            </div>


                            <div class="form-group col-md-6">
                                <label for="inputEmail4" class="ul-form__label">اولویت :</label>
                                <select name="TicketPeriority" class="form-control">
                                    @foreach (\App\myappenv::TicketPeriority as $Periority)
                                        <option value="{{ $Periority[0] }}">
                                            {{ __($Periority[1]) }}
                                        </option>
                                    @endforeach
                                </select>

                                <small class="ul-form__text form-text ">
                                    انتخاب اولویت
                                </small>
                            </div>
                            <div class="form-group col-md-12">
                                <label class="ul-form__label">{{ __('Note') }}</label>
                                <textarea required required name="ce" class="col-sm-12 form-control"></textarea>

                            </div>


                        </div>

                    </div>
                    <div class="card-footer bg-transparent">
                        <div class="mc-footer">
                            <div class="row">
                                <div class="col-lg-12">
                                    <button type="submit" name="submit" value="DeskAdd"
                                        class="btn  btn-primary m-1">ثبت
                                        تیکت</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- end::form -->
            </div>
        </div>
    </div>
    <div id="sendnotif" class="row targetForm nested">
        <div class="col-lg-12 mb-12">
            <div class="card">
                <div class="card-header bg-transparent">
                    <h3 class="card-title">ارسال اعلان</h3>
                </div>
                <form action="{{ route('makenotification') }}" method="post">
                    @csrf
                    <input class="nested" name="desk" value="true">
                    <div class="card-body">
                        <div class="form-row ">
                            <div class="form-group col-md-12 ">
                                <label for="inputEmail4" class="ul-form__label"> به کاربر:</label>
                                @include('Layouts.SearchUserInput', [
                                    'InputName' => 'UserName',
                                    'InputPalceholder' => __('Target username'),
                                ])
                                <small class="ul-form__text form-text ">
                                    نام کاربر
                                </small>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputEmail4" class="ul-form__label">به رول:</label>
                                <select id="NotificationRole" name="NotificationRole" class="form-control">
                                    <option value="0">{{ __('--select--') }}</option>

                                </select>
                                <small class="ul-form__text form-text ">
                                    ارسال اعلان به تمام اعضای یک نقش
                                </small>
                            </div>


                            <div class="form-group col-md-6">
                                <label for="inputEmail4" class="ul-form__label">نوع نوتیفیکیشن:</label>
                                <select name="NotificationMod" class="form-control">
                                    <option value="0">--انتخاب--</option>
                                    <option value="1">
                                        موفق</option>
                                    <option value="2">
                                        توضیح</option>
                                    <option value="3">
                                        هشدار</option>
                                    <option value="4">
                                        خطر</option>
                                </select>

                                <small class="ul-form__text form-text ">
                                    انتخاب نوع اعلان
                                </small>
                            </div>
                            <div class="form-group col-md-12">
                                <label class="ul-form__label">{{ __('Note') }}</label>
                                <textarea required required name="ce" class="col-sm-12 form-control"></textarea>

                            </div>


                        </div>

                    </div>
                    <div class="card-footer bg-transparent">
                        <div class="mc-footer">
                            <div class="row">
                                <div class="col-lg-12">
                                    <button type="submit" name="submit" value="Trnsfer"
                                        class="btn  btn-primary m-1">ثبت
                                        اعلان</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- end::form -->
            </div>
        </div>
    </div>
   

    <!-- end of row-->

    <!-- end of row-->
@endsection

@section('page-js')
    <script src="{{ asset('assets/js/vendor/datatables.min.fa.js') }}"></script>
    <!-- page script -->
    <script src="{{ asset('assets/js/tooltip.script.js') }}"></script>
    <script src="{{ asset('assets/js/moment.js') }}"></script>



    <script></script>
    <script src="{{ asset('assets/js/vendor/datatables.min.fa.js') }}"></script>
@endsection

@section('bottom-js')
    <script>
        function ShowMyProjects() {
            $('.targetForm').addClass('nested');

            $('#Table-card-header').html('پروژه های من');
            $('#MainTable_body').html('')
            $('#main-table-header').html(`<tr><th scope="col">#</th>
                                    <th scope="col">کد</th>
                                    <th scope="col">نام فرد</th>
                                    <th scope="col">نام پروژه</th>
                                    <th scope="col">تاریخ ثبت</th>
                                    <th scope="col">مسول</th>
                                    <th scope="col">عملیات</th>
                                    </tr>`);
            $('#table-continer').removeClass('nested');


            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('', {
                    func: 'get_my_projects'
                },

                function(data, status) {

                    i = 1
                    $.each(data, function(index, value) {
                        Mdate = moment(value.created_at).format("YYYY-MM-DD");
                        Mdate = new Date(Mdate).toLocaleDateString('fa-IR');
                        Price = value.total_sales + value.tax_total;
                        ProjectSrc = JSON.parse(value.projectinfo);
                        TaskSrc = JSON.parse(value.meta_value);
                        console.log(TaskSrc);
                        $('#MainTable_body').append(`<tr><th scope="row">` + i.toString() + `</th>
                                    <td>` + value.id + `</td>
                                    <td>` + TaskSrc.TargetName + `</td>
                                    <td>` + ProjectSrc.subject + `</td>
                                    <td>` + Mdate + `</td>
                                    <td>` + TaskSrc.TargetName + `</td>
                                    <td><a target="_blank"
                                            href="/EditOrder/` + value.id + `"
                                            title="ویرایش سفارش">
                                            <i style="font-size: 20px" class="i-Edit"></i>
                                        </a></td>

</tr>`);
                        i++;

                    });

                });

        }

        function ShowOrders() {
            $('.targetForm').addClass('nested');

            $('#Table-card-header').html('سفارشات من');
            $('#MainTable_body').html('');
            $('#main-table-header').html(`<tr><th scope="col">#</th>
                                    <th scope="col">شماره سفارش</th>
                                    <th scope="col">نام مشتری</th>
                                    <th scope="col">تاریخ خرید</th>
                                    <th scope="col">اقلام</th>
                                    <th scope="col">مبلغ</th>
                                    <th scope="col">سود</th>
                                    <th scope="col">وضعیت</th>
                                    <th scope="col">عملیات</th>
                                    </tr>`);
            $('#table-continer').removeClass('nested');


            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('', {
                    func: 'get_my_order'
                },

                function(data, status) {

                    i = 1
                    $.each(data, function(index, value) {
                        Mdate = moment(value.created_at).format("YYYY-MM-DD");
                        Mdate = new Date(Mdate).toLocaleDateString('fa-IR');
                        Price = value.total_sales + value.tax_total;
                        switch (value.status) {
                            case 1:
                                status = ' پرداخت شده';
                                break;
                            case 10:
                                status = ' در دست اقدام';
                                break;
                            case 20:
                                status = 'ارسال به انبار';
                                break;
                            case 30:
                                status = 'درحال بسته بندی';
                                break;
                            case 40:
                                status = ' ارسال به پست';
                                break;
                            case 50:
                                status = ' ثبت شده در تاپین';
                                break;
                            case 51:
                                status = ' ارسال شده به تاپین';
                                break;
                            case 60:
                                status = ' انصراف مشتری';
                                break;
                            case 70:
                                status = 'تحویل مشتری';
                                break;

                            default:
                                status = ' درخواست استعلام';
                        }
                        $('#MainTable_body').append(`<tr><th scope="row">` + i.toString() + `</th>
                                    <td>` + value.id + `</td>
                                    <td>` + value.customername + ' ' + value.customerfamily + `</td>
                                    <td>` + Mdate + `</td>
                                    <td>` + value.num_items_sold + `</td>
                                    <td>` + number_format(Price.toString()) + `</td>
                                    <td>` + number_format(value.net_total.toString()) + `</td>
                                    <td>` + status + `</td>
                                    <td><a target="_blank"
                                            href="/EditOrder/` + value.id + `"
                                            title="ویرایش سفارش">
                                            <i style="font-size: 20px" class="i-Edit"></i>
                                        </a></td>

</tr>`);
                        i++;

                    });

                });

        }

        function ShowMyUsers() {
            $('.targetForm').addClass('nested');

            $('#Table-card-header').html('کاربران من');
            $('#MainTable_body').html('')
            $('#main-table-header').html(`<tr><th scope="col">#</th>
                                    <th scope="col">نام مشتری</th>
                                    <th scope="col">تاریخ ثت</th>
                                    <th scope="col">اقلام خریداری شده</th>
                                    <th scope="col">مبلغ خرید</th>
                                    <th scope="col">تعدا خرید</th>
                                    <th scope="col">عملیات</th>
                                    </tr>`);
            $('#table-continer').removeClass('nested');


            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('', {
                    func: 'get_my_users'
                },

                function(data, status) {

                    i = 1
                    $.each(data, function(index, value) {
                        totallbuy = value.totallbuy;
                        Mdate = moment(value.CreateDate).format("YYYY-MM-DD");
                        Mdate = new Date(Mdate).toLocaleDateString('fa-IR');
                        $('#MainTable_body').append(`<tr><th scope="row">` + i.toString() + `</th>
                                    <td>` + value.Name + ' ' + value.Family + `</td>
                                    <td>` + Mdate + `</td>
                                    <td>` + value.totallitems + `</td>
                                    <td>` + number_format(totallbuy.toString()) + `</td>
                                    <td>` + value.invoices + `</td>
                                    <td><a target="_blank"
                                            href="#"
                                            title="ویرایش سفارش">
                                            <i style="font-size: 20px" class="i-Edit"></i>
                                        </a></td>

</tr>`);
                        i++;

                    });

                });

        }

        function ajaxloadrol(ObjectName) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('', {
                    func: 'loadRoles'
                },

                function(data, status) {
                    $.each(data, function(index, value) {
                        $('#' + ObjectName).append('<option value="' + value.Role + '">' + value.RoleName +
                            "</option>");
                    });

                });

        }

        function loadroles(ObjectName) {
            selectcount = $('#' + ObjectName).length;
            if (selectcount == 1) {
                ajaxloadrol(ObjectName);
            }


        }

        function openform(formID) {
            $('.targetForm').addClass('nested');
            $('#' + formID).removeClass('nested');
            if (formID == 'sendnotif') {
                loadroles('NotificationRole');
                LoadNotif();
            }
        }
        

        function ShowMyLink() {
            $('#row-div-card-header').html('لینک بازاریابی من');
            $('#row-div-card-body').html('...');
            $('.targetForm').addClass('nested');
            $('#row-div-continer').removeClass('nested');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('', {
                    func: 'getmymarkinglink'
                   
                },

                function(data, status) {

                    $('#row-div-card-body').html(data);

                });
        }

        function LoadNotif() {

            $('#Table-card-header').html('اعلانهای من');
            $('#MainTable_body').html('')
            $('#main-table-header').html(`<tr><th scope="col">#</th>
                                    <th scope="col">نام کاربری</th>
                                    <th scope="col">نوع اعلان</th>
                                    <th scope="col">متن</th>
                                    <th scope="col">تولید</th>
                                    <th scope="col">دیدن</th>
                                    <th scope="col">تایید</th>
                                    </tr>`);
            $('#table-continer').removeClass('nested');


            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('', {
                    func: 'get_notifications'
                },

                function(data, status) {
                    i = 1
                    $.each(data, function(index, value) {

                        Mdate = moment(value.created_at).format("YYYY-MM-DD");
                        Mdate = new Date(Mdate).toLocaleDateString('fa-IR');
                        Mtime = moment(value.created_at).format("HH:mm:ss");
                        Mdate = Mdate + '-' + Mtime;
                        if (value.ViewTime == null) {
                            Vdate = 'هنوز دیده نشده!';
                        } else {
                            Vdate = moment(value.ViewTime).format("YYYY-MM-DD");
                            Vdate = new Date(Vdate).toLocaleDateString('fa-IR');
                            Vtime = moment(value.ViewTime).format("HH:mm:ss");
                            Vdate = Vdate + '-' + Vtime;
                        }
                        if (value.AckTime == null) {
                            Vdate = 'هنوز تایید نشده!';
                        } else {
                            Adate = moment(value.AckTime).format("YYYY-MM-DD");
                            Adate = new Date(Adate).toLocaleDateString('fa-IR');
                            Atime = moment(value.AckTime).format("HH:mm:ss");
                            Adate = Adate + '-' + Atime;
                        }

                        $('#MainTable_body').append(`<tr><th scope="row">` + i.toString() + `</th>
                                    <td>` + value.Name + ' ' + value.Family + `</td>
                                    <td>` + value.AlertType + `</td>
                                    <td>` + value.Continer + `</td>
                                    <td>` + Mdate + `</td>
                                    <td>` + Vdate + `</td>
                                    <td>` + Adate + `</td>
</tr>`);
                        i++;

                    });

                });
            $('#MainTable').DataTable();


        }

        function WorkAssign($ProjectID, $target) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('', {
                    func: 'workassign',
                    target: $target,
                    ProjectID: $ProjectID
                },

                function(data, status) {

                    $('.targetForm').addClass('nested');
                    $('#formloader1').removeClass('nested');
                    $('#formloader1').html(data);

                });
        }

        function loadproject(projectID) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('', {
                    func: 'loadproject',
                    ProjectID: projectID
                },
                function(data, status) {
                    $('.targetForm').addClass('nested');
                    $('#formloader1').removeClass('nested');
                    $('#formloader1').html(data);
                });
        }

        function LoadProject() {
            $('.targetForm').addClass('nested');

            $('#Table-card-header').html('پروژه های من');
            $('#MainTable_body').html('')
            $('#main-table-header').html(`<tr><th scope="col">#</th>
                                    <th scope="col">نام پروژه</th>
                                    <th scope="col">توضیخ پروژه</th>
                                    <th scope="col">تاریخ ثبت</th>
                                    <th scope="col">آخرید ویرایش</th>
                                    <th scope="col">وضعیت</th>
                                    <th scope="col">عملیات</th>
                                    </tr>`);
            $('#table-continer').removeClass('nested');


            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('', {
                    func: 'get_project'
                },

                function(data, status) {

                    i = 1
                    $.each(data, function(index, value) {
                        meta_value = JSON.parse(value.meta_value);
                        Mdate = moment(value.created_at).format("YYYY-MM-DD");
                        Mdate = new Date(Mdate).toLocaleDateString('fa-IR');
                        Mtime = moment(value.created_at).format("HH:mm:ss");
                        Mdate = Mdate + '-' + Mtime;
                        Modate = moment(value.updated_at).format("YYYY-MM-DD");
                        Modate = new Date(Modate).toLocaleDateString('fa-IR');
                        Motime = moment(value.updated_at).format("HH:mm:ss");
                        Modate = Modate + '-' + Motime;
                        switch (value.status) {
                            case 1:
                                status = 'در انتظار ویرایش';
                                break;
                            case 2:
                                status = 'در انتظار فعال سازی';
                                break;
                            default:
                                status = 'نا مشخص';
                        }
                        $('#MainTable_body').append(`<tr><th scope="row">` + i.toString() + `</th>
                                    <td>` + meta_value.subject + `</td>
                                    <td>` + meta_value.desc + `</td>
                                    <td>` + Mdate + `</td>
                                    <td>` + Modate + `</td>
                                    <td>` + status + `</td>
                                    <td><a href="#" onclick="loadproject(` + value.id + `)">بارگذاری پروژه</a></td>

</tr>`);
                        i++;

                    });

                });
            //  $('#MainTable').DataTable();


        }
    </script>
    @include('Layouts.FilemanagerScriptssimple')
    @include('Layouts.SearchMultiUserInput_Js')
@endsection

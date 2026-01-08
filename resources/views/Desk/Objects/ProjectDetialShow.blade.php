@php
    $Persian = new App\Functions\persian();
    $ProductData = $Desk->get_projects($ProjectID);
    $ProductMetaValue = json_decode($ProductData->meta_value);
    
@endphp

<div id="createProject" class="row targetForm ">
    <div class="col-lg-12 col-md-3 col-sm-3 mb-12">
        <div class="card">
            <div class="card-header bg-transparent">
                <h3 class="card-title">اطلاعات پروژه</h3>
            </div>
            <form method="post">
                @csrf
                <div class="card-body">
                    <div class="form-row ">
                        <div class="form-group col-md-6">
                            <label class="ul-form__label">نام پروژه :</label>
                            <h6>{{ $ProductMetaValue->subject }}</h6>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="ul-form__label">توضیح پروژه :</label>
                            <h6>{{ $ProductMetaValue->desc }}</h6>
                        </div>
                        <hr>
                        <div class="form-group col-md-12">
                            {!! $ProductMetaValue->data !!}
                        </div>
                    </div>
                </div>

            </form>

            <!-- end::form -->
        </div>
    </div>
    <div  id = "goalgroup"class="col-lg-12 mb-12 mt-10">
        <div class="card">
            <div class="card-header bg-transparent">
                <h3 class="card-title">گروه هدف </h3>
            </div>
            <form method="post">
                @csrf
                <div class="card-body">
                    <div class="table-responsive">

                        <table class="table  text-center">
                            <thead>
                                <td>نام</td>
                                <td>مسئول</td>
                                <td>وضعیت</td>
                                <td>عملیات</td>
                            </thead>
                            <tbody>
                                @foreach ($Desk->get_Project_team_UserList($ProjectID, 0) as $Person)
                                    @if ($Person->ActionOwner == Auth::id())
                                        <tr>
                                            <td>
                                                {{ $Person->Name }} {{ $Person->Family }}
                                            </td>
                                            <td id="AssinedPerson_{{ $Person->UserName }}">
                                                @if ($Person->ActionOwner == null)
                                                    تخصیص نشده
                                                @else
                                                    {{ $Person->ActionOwnerName }} {{ $Person->ActionOwnerFamily }}
                                                @endif

                                            </td>
                                            <td id="Status_{{ $Person->UserName }}">
                                                @switch($Person->Fstatus)
                                                    @case(0)
                                                        در انتظار تخصیص
                                                    @break

                                                    @case(1)
                                                        ارجاع شده
                                                    @break

                                                    @default
                                                        نا مشخص
                                                @endswitch
                                            </td>
                                            <td id="Operation_{{ $Person->UserName }}">
                                                <a href="#oprationpanel"
                                                    onclick="loadtarget('{{ $Person->Ext }}','{{ $Person->ActionOwner }}','{{ $Person->ActionOwnerName }} {{ $Person->ActionOwnerFamily }}',{{ $ProjectID }})"
                                                    href="#">بارگذاری</a>
                                            </td>

                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </form>

            <!-- end::form -->
        </div>
    </div>
    <div id="oprationpanel" class=" row col-12 nested">
        <div class="col-lg-3 col-xl-4 mt-3">
            <div class="card">
                <div class="card-body">
                    <div class="user-profile mb-4">
                        <div class="ul-widget-card__user-info">
                            <img class="profile-picture avatar-lg mb-2"
                                src="{{ url('/') }}/assets/images/avtar/useravatar.png" alt="">

                            <p class="text-muted m-0" id="TargetName">...</p>
                        </div>
                    </div>
                   
                    <button onclick="backuserlist()" type="button" class=" btn btn-success" >
                        بازشگت به لیست کاربران
                    </button>
                    <div class="list-group mt-2" style=" cursor: pointer;">
                        <a onclick="UserLoad()" class="list-group-item list-group-item-action ">
                            <span class="custom-font"><i class="i-Add-Window"> </i></span> اطلاعات کاربر
                        </a>
                        <a onclick="AllMessage()" class="list-group-item list-group-item-action "><i
                                class="i-Empty-Box"> </i> لیست پیام ها </a>
                        <a onclick="AllCall()" class="list-group-item list-group-item-action"><i class="i-Edit">
                            </i> لیست تماس ها</a>
                        <a onclick="AllReport()" class="list-group-item list-group-item-action"><i class="i-Add-User">
                            </i> لیست گزارش ها </a>

                    </div>
                    <div class="mb-4"></div>
                    <!-- add task -->

                    <!-- end of Tasks -->


                </div>
            </div>
        </div>
        <div  class="col-lg-8 col-xl-8 mt-3 ">
            <div class="card">


                <div id="User" class="col-lg-12 col-md-12 col-sm-12 nested">
                    <div class="card-header bg-transparent">
                        <h3 class="card-title">اطلاعات کاربر</h3>
                    </div>
                    <div class="card card-icon mb-4">

                        <div class="table-responsive profile-table">
                            <table class="{{ \App\myappenv::MainTableClass }}">
                                <tbody>
                                    <tr>
                                        <td>{{ __('Name') }}</td>
                                        <td id="NameTXT" class="textinfo"> </td>
                                        <td class="inputinfo nested"><input class="form-control" id="Name"
                                                name="Name" value="" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ __('Family') }}</td>
                                        <td id="FamilyTXT" class="textinfo"></td>
                                        <td class="inputinfo nested"><input class="form-control" id="Family"
                                                name="Family" value="" />
                                        </td>

                                    </tr>
                                    <tr>
                                        <td>{{ __('Email') }}</td>
                                        <td id="EmailTXT" class="textinfo"></td>
                                        <td class="inputinfo nested"><input class="form-control" id="Email"
                                                name="Email" value="" />
                                            <input class="nested" name="branch" value="" />
                                        </td>

                                    </tr>
                                    <tr>
                                        <td>{{ __('Sex') }}</td>
                                        <td class="textinfo">

                                        </td>
                                        <td class="inputinfo nested">
                                            <div
                                                class="form-group m-checkbox-inline mb-0 custom-radio-ml d-flex radio-animated">
                                                <label class="d-block" for="edo-ani1">
                                                    <input class="radio_animated" type="radio" name="Sex"
                                                        value="m">
                                                    {{ __('Man') }}
                                                </label>
                                                <label class="d-block" for="edo-ani2">
                                                    <input class="radio_animated" type="radio" name="Sex"
                                                        value="f">
                                                    {{ __('Woman') }}
                                                </label>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>{{ __('Birthday date') }}</td>
                                        <td id="BirthdayTXT" class="textinfo">
                                        </td>
                                        <td class="inputinfo nested"><input class="form-control" id="Birthday"
                                                name="Birthday" value="" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ __('Register date') }}</td>
                                        <td id="CreateDate"></td>
                                    </tr>
                                    <tr>
                                        <td>{{ __('address') }}</td>
                                        <td id="AddressTXT" class="textinfo"></td>
                                        <td class="inputinfo nested"><input class="form-control" id="Address"
                                                name="Address" value="" />
                                        </td>

                                    </tr>
                                    <tr>
                                        <td>کدپستی</td>

                                        <td id="Address2TXT" class="textinfo"></td>
                                        <td class="inputinfo nested"><input class="form-control" id="Address2"
                                                name="Address2" value="" />
                                        </td>

                                    </tr>
                                    <tr>
                                        <td>نام پدر</td>
                                        <td id="fathernameTXT" class="textinfo"></td>
                                        <td class="inputinfo nested"><input class="form-control" name="fathername"
                                                id="fathername" value="" />
                                        </td>

                                    </tr>
                                    <tr>
                                        <td>کد ملی</td>
                                        <td id="MelliIDTXT" class="textinfo"></td>
                                        <td class="inputinfo nested"><input class="form-control" name="MelliID"
                                                id="MelliID" value="" />
                                        </td>

                                    </tr>
                                </tbody>
                            </table>
                            <button type="button" id="converttoedite"
                                class="btn btn-primary">{{ __('Edit') }}</button>
                            <button type="button" id="Aboartedite"
                                class="btn btn-danger nested">{{ __('aboart') }}</button>
                            <button type="button" name="submit" onclick="updatebaseinfo()" id="submitedit"
                                class="btn btn-success nested">{{ __('Submit') }}</button>
                            @if (\App\myappenv::Lic['PersonelCard'])
                                <br>
                                <input name="extranote" type="text" value="{{ $UserInfoResult->extranote }}">
                                <button type="button" onclick="saveuserinfo()" class="btn btn-primary"
                                    value="extranotesubmit">ثبت
                                    توضیحات</button>
                            @endif

                        </div>
                    </div>
                </div>

                <div id="allmessage" class="col-lg-12 col-md-12 col-sm-12 nested">
                    <div class="card-header bg-transparent">
                        <div class="ul-widget__head __g-support v-margin">
                            <div class="ul-widget__head-label">
                                <h3 class="ul-widget__head-title">
                                    لیست پیام ها
                                </h3>
                            </div>
                            <button type="button" class="btn btn-success" data-toggle="modal"
                                data-target=".bd-example-modal-lg">پیام جدید</button>

                        </div>



                    </div>
                    <div class="table-responsive">

                        <table class="table  text-center">
                            <thead>
                                <td>فرستنده </td>
                                <td>متن پیام</td>
                                <td>تاریخ و ساعت</td>
                            </thead>
                            <tbody id="MainTable_body_SMS">



                            </tbody>
                        </table>
                    </div>

                </div>
                <div id="allCall" class="col-lg-12 col-md-12 col-sm-12 nested">

                    <div class="card-header bg-transparent">
                        <div class="ul-widget__head __g-support v-margin">
                            <div class="ul-widget__head-label">
                                <h3 class="ul-widget__head-title">
                                    لیست تماس ها </h3>
                            </div>
                            <button type="button" class="btn btn-success" data-toggle="modal"
                                data-target=".bd-example-modal-lg3">برقراری تماس</button>

                        </div>



                    </div>


                    <div class="table-responsive">

                        <table class="table  text-center">
                            <thead>
                                <td>تماس گیرنده </td>
                                <td> مسئول</td>
                                <td>تاریخ و ساعت</td>

                            </thead>
                            <tbody id="MainTable_body_Call">

                            </tbody>
                        </table>
                    </div>


                </div>
                <div id="allreport" class="col-lg-12 col-md-12 col-sm-12 nested">
                    <div class="card-header bg-transparent">


                        <div class="ul-widget__head __g-support v-margin">
                            <div class="ul-widget__head-label">
                                <h3 class="ul-widget__head-title">
                                    لیست گزارش ها </h3>
                            </div>
                            <button type="button" class="btn btn-warning" data-toggle="modal"
                                data-target=".bd-example-modal-lg4"> ثبت گزارش </button>

                        </div>
                    </div>




                    <div class="table-responsive">

                        <table class="table  text-center">
                            <thead>
                                <td> گزارش دهنده </td>
                                <td> موضوع گزارش</td>
                                <td> متن گزارش</td>
                                <td>تاریخ و ساعت</td>

                            </thead>
                            <tbody id="MainTable_body_Report">

                            </tbody>
                        </table>
                    </div>


                </div>
                <div class="ul-card-list__modal">
                    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="#exampleModal2"
                        style="margin-right: 20%" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    ارسال پیامک به مشتری
                                </div>
                                <div class="modal-body">
                                    <form method="post">
                                        @csrf
                                        <div class="project-status">

                                            <div style="text-align: right">
                                                <textarea id="SMSBody" name="MessageText" placeholder="{{ __('Enter your SMS text!!') }}" cols="100"
                                                    rows="10"></textarea>
                                                <div>
                                                    <button type="button" class="btn btn-warning"
                                                        onclick="DoSendSMS()" style="margin:auto;display:block"
                                                        name="submit" value="SendSms">
                                                        {{ __('send') }}
                                                    </button>
                                                </div>
                                            </div>


                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ul-card-list__modal">
                    <div class="modal fade bd-example-modal-lg3" tabindex="-1" role="dialog"
                        style="margin-right: 20%" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">

                                <div class="modal-header">
                                    <h4 class="modal-title"> برقراری تماس </h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="card-body text-center">
                                        <div class="btnaria-header" style="display: flex">

                                            <button onclick="DoCall('{{ Auth::User()->MobileNo }}')" type="button"
                                                class="btn btn-danger ">ارتباط با
                                                {{ Auth::user()->MobileNo }}</button>
                                            @if (Auth::user()->Phone1 != null)
                                                <button onclick="DoCall('{{ Auth::User()->Phone1 }}')" type="button"
                                                    class="btn btn-primary">
                                                    ارتباط با
                                                    {{ Auth::user()->Phone1 }} </button>
                                            @endif
                                            @if (Auth::user()->Phone2 != null)
                                                <button onclick="DoCall('{{ Auth::User()->Phone2 }}')" type="button"
                                                    class="btn btn-primary ">
                                                    ارتباط با
                                                    {{ Auth::user()->Phone1 }} </button>
                                            @endif
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ul-card-list__modal">
                    <div class="modal fade bd-example-modal-lg4" tabindex="-1" role="dialog"
                        style="margin-right: 20%" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    ثبت گزارش
                                </div>
                                <div class="modal-body">
                                    <div class="form-group row">
                                        <label for="inputName" class="col-sm-2 col-form-label">موضوع</label>
                                        <div class="col-sm-10">

                                            <input type="text" class="form-control" name="subject" id=""
                                                placeholder="موضوع گزارش" value="">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputName" class="col-sm-2 col-form-label">متن گزارش</label>
                                        <div class="col-sm-10">

                                            <textarea class="form-control" id="reporttext" cols="30" rows="10"></textarea>
                                        </div>
                                    </div>
                                    <div>
                                        <button type="button" class="btn btn-primary" onclick="savereport()"
                                            style="margin:auto;display:block" name="submit" value="SendSms">
                                            ارسال
                                        </button>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end::form -->
            </div>
        </div>
    </div>
</div>


<!-- end::form -->


<br>
<hr>

<div id="ProjectAssign" class=" row targetForm"></div>
<script>
    $(function() {
        $('#converttoedite').click(function() {
            $(".textinfo").addClass('nested');
            $("#converttoedite").addClass('nested');
            $(".inputinfo").removeClass('nested');
            $("#Aboartedite").removeClass('nested');
            $("#submitedit").removeClass('nested');
        });
    });
    $(function() {
        $('#Aboartedite').click(function() {
            $(".textinfo").removeClass('nested');
            $("#converttoedite").removeClass('nested');
            $(".inputinfo").addClass('nested');
            $("#Aboartedite").addClass('nested');
            $("#submitedit").addClass('nested');
        });
    });
</script>
<script>
    var $GolTargetUserExt;
    var $TargetId;
    var $GolProjectID;
    var $GolFeildID;

    function updatebaseinfo() {
        $Name = $('#Name').val();
        $Family = $('#Family').val();
        $Email = $('#Email').val();
        $Birthday = $('#Birthday').val();
        $Address = $('#Address').val();
        $Address2 = $('#Address2').val();
        $fathername = $('#fathername').val();
        $MelliID = $('#MelliID').val();
        if ($Name == null || $Family == null || $Email == null) {
            alert('Please select');
            return null;
        }
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.post('', {
                func: 'UserEdit',
                GolTargetUserExt: $GolTargetUserExt,
                Name: $Name,
                Family: $Family,
                Email: $Email,
                Birthday: $Birthday,
                Address: $Address,
                Address2: $Address2,
                fathername: $fathername,
                MelliID: $MelliID
            },

            function(data, status) {
                alert(data);
            });

    }

    function UserLoad() {
        $('#User').removeClass('nested');
        $('#allmessage').addClass('nested');
        $('#allCall').addClass('nested');
        $('#allreport').addClass('nested');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.post('', {
                func: 'UserLoad',
                GolTargetUserExt: $GolTargetUserExt,
            },

            function(data, status) {
                $('#NameTXT').html(data['Name']);
                $('#Name').val(data['Name']);
                $('#FamilyTXT').html(data['Family']);
                $('#Family').val(data['Family']);
                $('#EmailTXT').html(data['Email']);
                $('#Email').val(data['Email']);
                $('#BirthdayTXT').html(data['Birthday']);
                $('#Birthday').val(data['Birthday']);
                $('#AddressTXT').html(data['Address']);
                $('#Address').val(data['Address']);
                $('#Address2TXT').html(data['Address2']);
                $('#Address2').val(data['Address2']);
                $('#fathernameTXT').html(data['fathername']);
                $('#fathername').val(data['fathername']);
                $('#MelliIDTXT').html(data['MelliID']);
                $('#MelliID').val(data['MelliID']);
                Mdate = moment(data['CreateDate']).format("YYYY-MM-DD");
                Mdate = new Date(Mdate).toLocaleDateString('fa-IR');
                $('#CreateDate').html(Mdate);
            });
    }

    function AllMessage() {
        $('#allmessage').removeClass('nested');
        $('#allCall').addClass('nested');
        $('#allreport').addClass('nested');
        $('#User').addClass('nested');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.post('', {
                func: 'MessageLoad',
                GolTargetUserExt: $GolTargetUserExt,
            },

            function(data, status) {
                $htmL = "";
                $.each(data, function(index, value) {
                    Mdate = moment(value.SMSDate).format("YYYY-MM-DD");
                    Mdate = new Date(Mdate).toLocaleDateString('fa-IR');
                    $htmL += `<tr>
                                    <td>` + value.SendBy + `</td>
                                    <td>` + value.Text + `</td>
                                    <td>` + Mdate + `</td>

</tr>`



                });
                $('#MainTable_body_SMS').html($htmL);

            });


    }

    function AllCall() {

        $('#allCall').removeClass('nested');
        $('#allmessage').addClass('nested');
        $('#allreport').addClass('nested');
        $('#User').addClass('nested');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.post('', {
                func: 'CallLoad',
                GolTargetUserExt: $GolTargetUserExt,
            },

            function(data, status) {
                $htmL = "";
                $.each(data, function(index, value) {
                    Mdate = moment(value.CallDate).format("YYYY-MM-DD");
                    Mdate = new Date(Mdate).toLocaleDateString('fa-IR');
                    $htmL += `<tr>
                                    <td>` + value.CallBy + `</td>
                                    <td>` + value.CallerPhone + `</td>
                                    <td>` + Mdate + `</td>

</tr>`
                  


                });
                $('#MainTable_body_Call').html($htmL);


            });


    }

    function AllReport() {

        $('#allreport').removeClass('nested');
        $('#allmessage').addClass('nested');
        $('#allCall').addClass('nested');
        $('#User').addClass('nested');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.post('', {
                func: 'ReportLoad',
                GolTargetUserExt: $GolTargetUserExt,
            },

            function(data, status) {
                $htmL = "";
                
                $.each(data, function(index, value) {
                    Mdate = moment(value.ReportDate).format("YYYY-MM-DD");
                    Mdate = new Date(Mdate).toLocaleDateString('fa-IR');
                    $htmL += `<tr>
                                    <td>` + value.Createby + `</td>
                                    <td>` + value.reportSubject + `</td>
                                    <td>` + value.ReportText + `</td>
                                    <td>` + Mdate + `</td>

</tr>`
                  


                });
                $('#MainTable_body_Report').html($htmL);


            });



    }

    function savereport() {
        $reporttext = $('#reporttext').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.post('', {
                func: 'savereport',
                reporttext: $reporttext,
                ProjectID: $GolProjectID,
                GolFeildID: $GolFeildID
            },

            function(data, status) {
                alert(data);
            });
    }

    function DoCall($device) {

        $(".bd-example-modal-lg3").modal('hide');


        $SMStext = $('#SMSBody').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.post('', {
                func: 'DoCall',
                TargetUserExt: $GolTargetUserExt,
                device: $device,
                ProjectID: $GolProjectID,
                GolFeildID: $GolFeildID
            },

            function(data, status) {
                alert(data);
            });
    }

    function DoSendSMS() {
        $SMStext = $('#SMSBody').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.post('', {
                func: 'SendSMS',
                TargetUserExt: $GolTargetUserExt,
                SMStext: $SMStext,
                ProjectID: $GolProjectID,
                GolFeildID: $GolFeildID
            },

            function(data, status) {
                alert(data);
            });
    }

    function loadtarget($TargetUserExt, $OwnerUserName, $TargetName, $ProjectID) {
        $GolProjectID = $ProjectID;
        $GolTargetUserExt = $TargetUserExt;
        $('#goalgroup').addClass('nested');
        $('#oprationpanel').removeClass('nested');
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.post('', {
                func: 'loadtarget',
                TargetUserExt: $TargetUserExt,
                OwnerUserName: $OwnerUserName,
                ProjectID: $ProjectID
            },

            function(data, status) {

                $GolFeildID = data['KeyId'];

                $('#TargetName').html(data['TargetName']);
            });
    }

    function backuserlist(){
        $('#oprationpanel').addClass('nested');
        $('#goalgroup').removeClass('nested');
    }
</script>

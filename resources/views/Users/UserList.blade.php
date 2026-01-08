@php
    $Persian = new App\Functions\persian();
@endphp
@extends('Layouts.MainPage')
@section('page-header-left')
@endsection

@section('MainCountent')
    <input class="nested" id="main-menu" value="#userworks">
    <input class="nested" id="sub-menu" value="#user_list">
    <div class="row">
        <div class=" col-lg-3 col-md-6 col-sm-6 ">
            <a href="{{ route('CreateUser') }}">
                <div class="navcard navcard-main card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                    <div class="card-body text-center">
                        <i style="color: red" class="i-Add-User"></i>
                        <div class="content">
                            <p class=" mt-2 mb-0 text-primary"> افزودن کاربر</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 ">
            <a href="{{ route('UserSearch') }}">
                <div class="navcard active-navcard card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                    <div class="card-body text-center">
                        <i class="i-Receipt-4"></i>
                        <div class="content">
                            <p class="text-white mt-2 mb-0">لیست کاربران</p>

                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <div class="row">
        <div id="table-continer" class=" col-md-12">
            <div class="card o-hidden mb-4">
                <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                    <h3 id="Table-card-header" class="text-white  w-50 float-left card-title m-0"><i
                            class=" header-icon i-Business-Mens"></i> لیست کاربران </h3>
                    <div class="dropdown dropleft text-right w-50 float-right">
                        <button class="btn btn-primary" type="button" id="dropdownMenuButton_table_1"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="nav-icon i-Gear-2"></i>
                        </button>
                        <div class="dropdown-menu " aria-labelledby="dropdownMenuButton_table_1">
                            <a class="dropdown-item" onclick="multiselect()">انتخاب چند کاربر</a>
                            <div id="multi-user-option" class="nested">
                                <a class="dropdown-item" onclick="selectalloptions()" href="#">انتخاب همه</a>
                                <a class="dropdown-item" onclick="deselecttalloptions()" href="#">حذف همه</a>
                            </div>

                        </div>
                    </div>

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
                                            <th>{{ __('Name') }}</th>
                                            <th>{{ __('Mobile No') }}</th>
                                            <th>{{ __('Credite') }}</th>
                                            <th>{{ __('Date') }}</th>
                                            <th>{{ __('Status') }}</th>
                                            @if (Auth::user()->branch == \App\myappenv::Branch)
                                                <th>{{ __('Branch') }}</th>
                                            @endif
                                            <th>{{ __('Role') }}</th>
                                            <th>{{ __('Actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $Rowno = 1;
                                        @endphp
                                        @foreach ($Users as $User)
                                            <tr>
                                                <td>{{ $Rowno++ }}</td>
                                                <td>
                                                    @if (\App\myappenv::MainOwner != 'kookbaz')
                                                        @if ($User->Sex == 'm')
                                                            {{ __('Mr. ') }}
                                                        @elseif($User->Sex == 'f')
                                                            {{ __('Mrs. ') }}
                                                        @else
                                                        @endif
                                                    @endif
                                                    {{ $User->Name }} {{ $User->Family }}
                                                    @if ($User->branch == \App\myappenv::shafatelunmanagedcustomers)
                                                        <img style="width: 20px;"
                                                            src="{{ asset('/assets/images/favicon/ShafatelRed.png') }}">
                                                    @elseif($User->branch == \App\myappenv::shafatelmanagedcustomers_done)
                                                        <img style="width: 20px;"
                                                            src="{{ asset('/assets/images/favicon/ShafatelGreen.png') }}">
                                                    @endif
                                                </td>
                                                <td>{{ $User->MobileNo }}</td>
                                                <td>
                                                    @if ($User->mony < 0)
                                                        <p style="color:red"> {{ $User->mony }} </p>
                                                    @else
                                                        {{ number_format($User->mony) }}
                                                    @endif
                                                </td>
                                                <td>{{ $Persian->MyPersianDate($User->CreateDate, false) }}</td>
                                                <td>{{ $User->UserStatusName ?? 'notdefine' }}</td>
                                                @if (Auth::user()->branch == \App\myappenv::Branch)
                                                    <th>{{ $User->BranchName ?? 'not define' }}</th>
                                                @endif

                                                <td>{{ $User->RoleName ?? 'not define' }}</td>
                                                <td>
                                                    <div class="action-div">
                                                        <a href="{{ Route('UserProfile', $User->UserNameMain) }}"
                                                            title="{{ __('Users edite') }}">
                                                            <i style="font-size: 20px" class="i-Edit"></i>
                                                        </a>
                                                        <a href="{{ Route('UserReport', $User->UserNameMain) }}"
                                                            title="{{ __('Users reports') }}">
                                                            <i style="font-size: 20px" class="i-Statistic"></i>
                                                        </a>
                                                        @if (\App\myappenv::Lic['HCIS_Workflow'])
                                                            <a href="{{ Route('Workflow', $User->UserNameMain) }}"
                                                                title="نمایش گردش کار">
                                                                <i style="font-size: 20px" class="i-Environmental-2"></i>
                                                            </a>
                                                            <a href="{{ Route('PatDoc', ['RequestPat' => $User->UserNameMain]) }}"
                                                                title="پرونده الکترونیک">
                                                                <i style="font-size: 20px" class="i-Affiliate"></i>
                                                            </a>
                                                        @else
                                                            <a href="{{ Route('myprofile', ['RequestUser' => $User->UserNameMain]) }}"
                                                                title="خانواده">
                                                                <i style="font-size: 20px" class="i-Affiliate"></i>
                                                            </a>
                                                        @endif

                                                        <a href=""
                                                            onclick="window.open('{{ url('/') . '/filemanager?type=file&usertraget=' . $User->UserNameMain }}',
                                                                    'newwindow',
                                                                    'width=1000,height=600');
                                                         return false;"><i
                                                                style="font-size: 20px" class="i-Folder-Open"></i></a>
                                                    </div>
                                                    <div class="select-div nested">
                                                        <input type="checkbox" name="selected[]"
                                                            class="form-control user-select"
                                                            value="{{ $User->UserNameMain }}">
                                                    </div>


                                            </tr>
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
    <!-- Container-fluid Ends-->
@endsection
@section('page-js')
    <script>
        function selectalloptions() {
            $(".user-select").prop('checked', true);

        }

        function deselecttalloptions() {
            $(".user-select").prop('checked', false);
        }

        function multiselect() {
            $('#ul-contact-list').DataTable().destroy();
            $('.action-div').addClass('nested');
            $('.select-div').removeClass('nested');
            $('#multi-user-option').removeClass('nested');
        }
    </script>
    @if (app()->getLocale() == 'fa')
        <script src="{{ asset('assets/js/vendor/datatables.min.fa.js') }}"></script>
    @else
        <script src="{{ asset('assets/js/vendor/datatables.min.js') }}"></script>
    @endif
    <!-- page script -->
    <script src="{{ asset('assets/js/tooltip.script.js') }}"></script>

    <script>
        $('#ul-contact-list').DataTable();
    </script>

    <script>
        var toggler = document.getElementsByClassName("box");
        var i;

        for (i = 0; i < toggler.length; i++) {
            toggler[i].addEventListener("click", function() {
                this.parentElement.querySelector(".nested").classList.toggle("active");
                this.classList.toggle("check-box");
            });
        }
    </script>
    <script>
        var selected = new Array();
        $(document).ready(function() {

            $("input[type='checkbox']").on('change', function() {
                // check if we are adding, or removing a selected item
                if ($(this).is(":checked")) {
                    selected.push($(this).val());
                } else {
                    for (var i = 0; i < selected.length; i++) {
                        if (selected[i] == $(this).val()) {
                            // remove the item from the array
                            selected.splice(i, 1);
                        }
                    }
                }

                // output selected
                var output = "";
                for (var o = 0; o < selected.length; o++) {
                    if (output.length) {
                        output += ", " + selected[o];
                    } else {
                        output += selected[o];
                    }
                }

                $(".taid").val(output);

            });

        });
    </script>
    <script>
        $(document).ready(function() {
                    $("#L1").change(function() {
                        var num = this.value;
                        $("#L11").css("display", "none");
                    });
    </script>
@endsection

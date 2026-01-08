@php
$Persian = new App\Functions\persian();
@endphp
@extends("Layouts.MainPage")
@section('page-header-left')

@endsection
@section('MainCountent')
    
    <form method="post">
        @csrf
        <div class="card-body">
            <div>
                <a class="btn btn-primary" href="{{ route('makenotification') }}">ارسال نوتیفیکیشن</a>
            </div>
            <div class="table-responsive">
                <table id="ul-contact-list" class="{{ \App\myappenv::MainTableClass }}" style="width:100%">
                    <thead>
                        <tr>
                            <th>{{ __('No.') }}</th>
                            <th>{{ __('Username') }}</th>
                            <th>نوع نوتیفیکیشن</th>
                            <th>متن</th>
                            <th>تولید</th>
                            <th>دیدن</th>
                            <th>تایید</th>
                            <th>{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $Rowno = 1;
                        @endphp
                        @foreach ($Notificaions as $Notificaion)
                            <tr>
                                <td>{{ $Notificaion->id }}</td>
                                <td>{{ $Notificaion->Name }} {{ $Notificaion->Family }}</td>
                                <td>
                                    @foreach (\app\myappenv::Notification as $arrtype)
                                        @if ($arrtype[0] == $Notificaion->AlertType)
                                            {{ $arrtype[1] }}
                                        @endif
                                    @endforeach
                                </td>
                                <td>{{ $Notificaion->Continer }}</td>
                                <td>{{ $Persian->MyPersianDate($Notificaion->created_at, true) }}</td>
                                <td>@if ($Notificaion->ViewTime == null) دیده نشده @else {{ $Persian->MyPersianDate($Notificaion->ViewTime, true) }} @endif </td>
                                <td>@if ($Notificaion->AckTime == null) تایید نشده @else {{ $Persian->MyPersianDate($Notificaion->AckTime, true) }} @endif </td>
                                <td> <button class="btn btn-danger" type="submit" name="delete"
                                        value="{{ $Notificaion->id }}">حذف</button> </td>
                            </tr>
                        @endforeach

                    </tbody>

                </table>
            </div>

        </div>
    </form>
    <!-- Container-fluid Ends-->

@endsection
@section('page-js')


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

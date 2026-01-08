@php
    $Persian= new App\Functions\persian();
@endphp
@extends("Layouts.MainPage")
@section("page-header-left")

@endsection
@section('MainCountent')
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-lg-6">
                    <div class="page-header-left">
                        <h3>{{__("Financial works")}}
                            <small>{{__("Credit reports")}} - {{__("Reports of ipg")}}</small>
                        </h3>
                    </div>
                </div>
                <div class="col-lg-6">
                    <ol class="breadcrumb pull-right">
                        @include('Layouts.AddressBar')
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <form method="post">
        @csrf
        <div class="card-body">

            <div class="table-responsive">
                <table id="ul-contact-list" class="{{\App\myappenv::MainTableClass}}" style="width:100%">
                    <thead>
                    <tr>
                        <th>{{__("Transaction code")}}</th>
                        <th>{{__("IPG code")}}</th>
                        <th>{{__("To account")}}</th>
                        <th>{{__("Price")}}</th>
                        <th>{{__("Credit Type")}}</th>
                        <th>{{__("Date of enter")}}</th>
                        <th>{{__("By")}}</th>
                        <th>{{__("Note")}}</th>
                        <th>{{__('Actions')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php
                        $Rowno = 1;
                    @endphp
                    @foreach($Credites as $Credit)
                        <tr
                            @if($Credit->Mony < 0)
                            class="table-row-danger"
                            @endif
                        >
                            <td>{{$Credit->ID}}</td>
                            <td>{{$Credit->PaymentId}}</td>
                            <td>{{$Credit->name}}</td>
                            <td style="direction: ltr" >{{number_format($Credit->Mony)}}</td>
                            <td>{{$Credit->ModName}}</td>
                            <td>{{$Persian->MyPersianDate($Credit->Date)}}</td>
                            <td>{{$Credit->UserName}}</td>
                            <td>{{$Credit->Note}}</td>
                            <td>
                                <button type="submit" title="{{__("Resend SMS")}}" class="btn btn-primary " name="SendSMS" value="{{$Credit->ID}}"><i  class="nav-icon i-Mail-Reply"></i></button>
                            </td>
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


    @if(app()->getLocale() == 'fa')
        <script src="{{asset('assets/js/vendor/datatables.min.fa.js')}}"></script>
    @else
        <script src="{{asset('assets/js/vendor/datatables.min.js')}}"></script>
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
            toggler[i].addEventListener("click", function () {
                this.parentElement.querySelector(".nested").classList.toggle("active");
                this.classList.toggle("check-box");
            });
        }
    </script>
    <script>
        var selected = new Array();
        $(document).ready(function () {

            $("input[type='checkbox']").on('change', function () {
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
        $(document).ready(function () {
            $("#L1").change(function () {
                var num = this.value;
                $("#L11").css("display", "none");
            });

    </script>
@endsection

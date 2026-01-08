@php
$Persian = new App\Functions\persian();
@endphp
@extends("Layouts.MainPage")
@section('page-header-left')

@endsection
@section('MainCountent')
    <form method="post">
        @csrf
        <div class="container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="page-header-left">
                            <h3>عملیات محصولات
                                <small>لیست محصولات</small>
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
        <div class="card-body">

            <div class="table-responsive">
                <table id="Product-list" class="{{ \App\myappenv::MainTableClass }}" style="width:100%">
                    <thead>
                        <tr>
                            <th>{{ __('No.') }}</th>
                            <th>sku</th>
                            <th>نام محصول</th>
                            <th>نام لاتین</th>
                            <th>موجودی</th>
                            <th>عملیات
                            </th>

                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $Rowno = 1;
                            $GoodId = null;
                        @endphp
                        @foreach ($goods as $good)
                            @if ($GoodId == $good->id)
                                <tr>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>{{ $good->Name }} - {{ $good->QTY }}</td>
                                    <td>
                                    </td>
                                </tr>
                            @else
                                <tr>
                                    <td>{{ $Rowno++ }}</td>
                                    <td>{{ $good->SKU }}</td>
                                    <td>{{ $good->NameFa }}</td>
                                    <td>{{ $good->NameEn }}</td>
                                    <td>{{ $good->Name }} - {{ $good->QTY }}</td>
                                    <td>
                                        <div class="operation_center">
                                            <a target="_blank" href="{{ Route('EditProduct', $good->id) }}"
                                                title="ویرایش محصول">
                                                <i style="font-size: 20px" class="i-Edit"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endif

                        @endforeach

                    </tbody>

                </table>
            </div>

        </div>
    </form>

@endsection
@section('page-js')
    <script>
        function CheckDecheck() {
            $('.ProductCheckBox').prop('checked', true);
        }
    </script>
    <script>
        function change_to_indexing_mode() {
            $('#indexingmodebtn').addClass('nested');
            $('.operation_center').addClass('nested');
            $('#indexlistcard').removeClass('nested');
        }

        function change_to_orginal() {
            $('#indexingmodebtn').removeClass('nested');
            $('.operation_center').removeClass('nested');
            $('#indexlistcard').addClass('nested');

        }
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

    @if (app()->getLocale() == 'fa')
        <script src="{{ asset('assets/js/vendor/datatables.min.fa.js') }}"></script>
    @else
        <script src="{{ asset('assets/js/vendor/datatables.min.js') }}"></script>
    @endif

    <script>
        $('#Product-list').DataTable();
    </script>


@endsection

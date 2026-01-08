@php
    $MyImage = new \App\Functions\Images();
    if ($iframe) {
        $Layout = 'iframe';
    } else {
        $Layout = null;
    }
@endphp
@extends('Layouts.MainPage', ['layout' => $Layout])
@section('page-header-left')
    <h3>{{ __('Pats') }}
        <small>{{ __('My pats') }}</small>
    </h3>
@endsection
@section('MainCountent')
    <form id="targetform" method="post">
        @csrf
        <div class="row">
            <div class="col-lg-3">
                <h4>شاخص اصلی</h4>
                <select class="form-control" name="WorkCat" id="WorkCatSelectBox" onchange="WorkCatSelect()">
                    <option value="0">{{ __('--select--') }}</option>
                    @foreach ($WorkCats as $WorkCat)
                        <option value="{{ $WorkCat->ID }}"> {{ $WorkCat->Name }}</option>
                    @endforeach
                </select>
                <div class="input-group mb-3">
                    <input type="text" name="WorkCatAdd" id="WorkCatAddInput" class="form-control"
                        placeholder="اضافه شاخص اصلی">
                    <div class="input-group-append">
                        <span class="input-group-text" id="WorkCatAdd" onclick="submitter('WorkCatAddInput')">+</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <h4>شاخص لایه ۱</h4>
                <select class="form-control" name="L1Work" id="L1Select" onchange="L1Selectfun()" disabled>
                    <option value="0">{{ __('--select--') }}</option>
                    @foreach ($L1Works as $L1Work)
                        <option class="OptionL1 OptionL1_wc{{ $L1Work->WorkCat }}" value="{{ $L1Work->L1ID }}">
                            {{ $L1Work->Name }}</option>
                    @endforeach
                </select>
                <div class="input-group mb-3">
                    <input type="text" name="L1Add" id="L1AddInput" class="form-control"
                        placeholder="افزودن شاخص لایه ۱">
                    <div class="input-group-append">
                        <span class="input-group-text" id="L1Add" onclick="submitter('L1AddInput')">+</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <h4>شاخص لایه ۲</h4>
                <select class="form-control" name="L2Work" id="L2Select" onchange="L2Selectfun()" disabled>
                    <option value="0">{{ __('--select--') }}</option>
                    @foreach ($L2Works as $L2Work)
                        <option class="OptionL2 OptionL2_wc{{ $L2Work->WorkCat }}_L1{{ $L2Work->L1ID }}"
                            value="{{ $L2Work->L2ID }}"> {{ $L2Work->Name }}</option>
                    @endforeach
                </select>
                <div class="input-group mb-3">
                    <input type="text" name="L2Add" id="L2AddInput" class="form-control"
                        placeholder="افزودن شاخص لایه ۲">
                    <div class="input-group-append">
                        <span class="input-group-text" id="L2Add" onclick="submitter('L2AddInput')">+</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <h4>شاخص مقدار</h4>
                <select class="form-control" name="L3Work" id="L3Select" disabled>
                    <option value="0">{{ __('--select--') }}</option>
                    @foreach ($L3Works as $L3Work)
                        <option
                            class="OptionL3 OptionL3_wc{{ $L3Work->WorkCat }}_L1{{ $L3Work->L1ID }}_L2{{ $L3Work->L2ID }}"
                            value="{{ $L3Work->UID }}"> {{ $L3Work->Name }}</option>
                    @endforeach
                </select>
                <div class="input-group mb-3">
                    <input type="text" name="L3Add" id="L3AddInput" class="form-control"
                        placeholder="افزودن شاخص مقدار">

                    <div class="input-group-append">
                        <span class="input-group-text" id="L3Add" onclick="submitter('L3AddInput')">+</span>
                    </div>
                    <div class="input-group">
                        <span class="input-group-btn">
                            <a id="lfm" data-input="modal_pic" data-preview="holder"
                                class="btn btn-primary text-white">
                                <i class="fa fa-picture-o"></i> انتخاب تصویر
                            </a>
                        </span>
                        <input id="modal_pic" class="form-control" type="text" name="pic" value="">
                    </div>
                </div>
                <button name="addindex" value="1" class="form-control btn btn-primary">افزودن شاخص</button>
            </div>
        </div>
    </form>
    <form method="POST">
        @csrf
        <div class="col-xl-6">

            <div class="card">
                <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                    <h5 class="text-white"> <i class=" header-icon i-Tag-4"></i> شاخص های کالا و خدمات</h5>
                </div>
                <div class="card-body">
                    <div class="digital-add needs-validation">
                        <div class="form-group mb-0">
                            <div class="description-sm">
                                {!! $IndexTree !!}
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-0">
                        <div class="product-buttons text-center">
                            <button type="submit" name="submit" value="multiindex" class="btn btn-primary">افزودن شاخص
                                ها</button>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </form>
    <hr>
    <form method="post">
        @csrf
        <div class="table-responsive">
            <table id="ul-contact-list" class="{{ \App\myappenv::MainTableClass }}" style="width:100%">
                <thead>
                    <tr>
                        <th>{{ __('No.') }}</th>
                        <th>شاخص</th>
                        <th>شاخص مقدار</th>
                        <th>عملیات</th>

                    </tr>
                </thead>
                <tbody>
                    @php
                        $Rowno = 1;
                    @endphp
                    @foreach ($GoodIndexes as $GoodIndex)
                        <tr>
                            <td>{{ $Rowno++ }} </td>
                            <td>{{ $GoodIndex->WorkcatName }} ->{{ $GoodIndex->L1Name }} ->{{ $GoodIndex->L2Name }}
                            </td>
                            <td>{{ $GoodIndex->L3Name }}</td>
                            <td><button class="btn btn-danger" name="delete" value="{{ $GoodIndex->id }}">حذف</button>
                            </td>
                        </tr>
                    @endforeach

                </tbody>

            </table>
        </div>
    </form>


    </div>
@endsection

@section('page-js')
    @if (app()->getLocale() == 'fa')
        <script src="{{ asset('assets/js/vendor/datatables.min.fa.js') }}"></script>
    @else
        <script src="{{ asset('assets/js/vendor/datatables.min.js') }}"></script>
    @endif
    <script>
        function submitter(myid) {
            if ($('#' + myid).val() != '') {
                if (myid != 'WorkCatAddInput') {
                    $('#WorkCatAddInput').val('');
                }
                if (myid != 'L1AddInput') {
                    $('#L1AddInput').val('');
                }
                if (myid != 'L2AddInput') {
                    $('#L2AddInput').val('');
                }
                if (myid != 'L3AddInput') {
                    $('#L3AddInput').val('');
                }

                $("#targetform").submit();
            } else {
                alert('مقدار ورودی نمی تواند خالی باشد');
            }


        }

        function WorkCatSelect() {
            if ($('#WorkCatSelectBox').val() != 0) {
                $(".OptionL1").hide();
                var TargetL1Show = '.OptionL1_wc' + $('#WorkCatSelectBox').val();
                $(TargetL1Show).show();
                $('#L1Select').prop('disabled', false);
                $('#L2Select').prop('disabled', true);
                $('#L3Select').prop('disabled', true);

            } else {
                $('#L1Select').prop('disabled', true);
                $('#L2Select').prop('disabled', true);
                $('#L3Select').prop('disabled', true);
            }
        }

        function L1Selectfun() {
            if ($('#L1Select').val() != 0) {
                var TargetL2Show = '.OptionL2_wc' + $('#WorkCatSelectBox').val() + '_L1' + $('#L1Select').val();
                $(".OptionL2").hide();
                $(TargetL2Show).show();
                $('#L1Select').prop('disabled', false);
                $('#L2Select').prop('disabled', false);
                $('#L3Select').prop('disabled', true);

            } else {
                $('#L1Select').prop('disabled', false);
                $('#L2Select').prop('disabled', true);
                $('#L3Select').prop('disabled', true);
            }
        }

        function L2Selectfun() {
            if ($('#L2Select').val() != 0) {
                var TargetL3Show = '.OptionL3_wc' + $('#WorkCatSelectBox').val() + '_L1' + $('#L1Select').val() + '_L2' + $(
                    '#L2Select').val();
                $(".OptionL3").hide();
                $(TargetL3Show).show();
                $('#L1Select').prop('disabled', false);
                $('#L2Select').prop('disabled', false);
                $('#L3Select').prop('disabled', false);

            } else {
                $('#L1Select').prop('disabled', false);
                $('#L2Select').prop('disabled', false);
                $('#L3Select').prop('disabled', true);
            }
        }
    </script>
@endsection
@section('bottom-js')
    <script>
        var toggler = document.getElementsByClassName("box");
        var i;

        for (i = 0; i < toggler.length; i++) {
            toggler[i].addEventListener("click", function() {
                if ($(this.parentElement.querySelector("ul")).hasClass('nested')) {
                    $(this.parentElement.querySelector("ul")).removeClass('nested');
                    this.parentElement.querySelector("ul").classList.toggle("active");
                } else {
                    $(this.parentElement.querySelector("ul")).removeClass('active');
                    this.parentElement.querySelector("ul").classList.toggle("nested");
                }


                this.classList.toggle("check-box");
                this.classList.toggle("active");
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

    @include('Layouts.FilemanagerScripts')
@endsection

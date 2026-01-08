<div class="card-body">
    <div class="row">
        <div class="col-lg-3">
            <h4>سرفصل </h4>
            <select class="form-control" name="WorkCat" id="WorkCatSelectBox"
                onchange="WorkCatSelect()">
                <option value="0">{{ __('--select--') }}</option>
                @foreach ($Themes->get_WorkCat() as $WorkCat)
                    <option value="{{ $WorkCat->ID }}"> {{ $WorkCat->Name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-lg-3">
            <h4>سردسته </h4>
            <select class="form-control" name="L1Work" id="L1Select" onchange="L1Selectfun()"
                disabled>
                <option value="0">{{ __('--select--') }}</option>
                @foreach ($Themes->get_L1work() as $L1Work)
                    <option class="OptionL1 OptionL1_wc{{ $L1Work->WorkCat }}"
                        value="{{ $L1Work->L1ID }}"> {{ $L1Work->Name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-lg-3">
            <h4>دسته بندی سرفصل </h4>
            <select class="form-control" name="L2Work" id="L2Select" onchange="L2Selectfun()"
                disabled>
                <option value="0">{{ __('--select--') }}</option>
                @foreach ($Themes->get_L2work() as $L2Work)
                    <option class="OptionL2 OptionL2_wc{{ $L2Work->WorkCat }}_L1{{ $L2Work->L1ID }}"
                        value="{{ $L2Work->L2ID }}"> {{ $L2Work->Name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-lg-3">
            <h4>دسته </h4>
            <select class="form-control" name="L3Work" id="L3Select" disabled>
                <option value="0">{{ __('--select--') }}</option>
                @foreach ($Themes->get_L3work() as $L3Work)
                    <option
                        class="OptionL3 OptionL3_wc{{ $L3Work->WorkCat }}_L1{{ $L3Work->L1ID }}_L2{{ $L3Work->L2ID }}"
                        value="{{ $L3Work->UID }}"> {{ $L3Work->UID }} - {{ $L3Work->Name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
</div>
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

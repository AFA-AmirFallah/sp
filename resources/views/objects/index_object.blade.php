<div class="card">
    <div class="card-header gradient-purple-indigo 0-hidden pb-80">
        <div class="text-white card-title">
            <i class=" header-icon i-Library"></i> شاخص های هوشمند
        </div>
    </div>
    <div class="card-body">
        @php
            $t_WorkCat = 0;
            $t_L1ID =0;
            $t_L2ID = 0;
        @endphp
        @foreach ($L3Works as $L3Work)
            @if ($RespnsType->MainIndex == $L3Work->UID)
                @php
                    $t_WorkCat = $L3Work->WorkCat;
                    $t_L1ID = $L3Work->L1ID;
                    $t_L2ID = $L3Work->L2ID;
                @endphp
            @endif
        @endforeach
        <h6><i class="i-First-Aid" style="font-size: 20px"></i> شاخص
            خدمت</h6>
        <div style="background-color: blue;padding-bottom: 20px;padding-top: 20px;border-radius: 5px;"
            class="form-row">
            <div class="col-lg-3">
                <p class="text-white">شاخص اصلی</p>
                <select class="form-control" name="WorkCat" id="WorkCatSelectBox_1"
                    onchange="WorkCatSelect_f('_1')">
                    <option value="0">{{ __('--select--') }}</option>
                    @foreach ($WorkCats as $WorkCat)
                        <option value="{{ $WorkCat->ID }}"
                            @if ($WorkCat->ID == $t_WorkCat) selected @endif>
                            {{ $WorkCat->Name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-3">
                <p class="text-white">شاخص لایه اول</p>
                <select class="form-control" name="L1Work" id="L1Select_1"
                    onchange="L1Selectfun_f('_1')" disabled>
                    <option value="0">{{ __('--select--') }}</option>
                    @foreach ($L1Works as $L1Work)
                        <option class="OptionL1_1 OptionL1_wc_1{{ $L1Work->WorkCat }}"
                            value="{{ $L1Work->L1ID }}"
                            @if ($L1Work->WorkCat == $t_WorkCat && $L1Work->L1ID == $t_L1ID) selected @endif>
                            {{ $L1Work->Name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-3">
                <p class="text-white">شاخص لایه دوم</p>
                <select class="form-control" name="L2Work" id="L2Select_1"
                    onchange="L2Selectfun_f('_1')" disabled>
                    <option value="0">{{ __('--select--') }}</option>
                    @foreach ($L2Works as $L2Work)
                        <option
                            class="OptionL2_1 OptionL2_wc_1{{ $L2Work->WorkCat }}_L1{{ $L2Work->L1ID }}"
                            value="{{ $L2Work->L2ID }}"
                            @if ($L2Work->WorkCat == $t_WorkCat && $L2Work->L1ID == $t_L1ID && $L2Work->L2ID == $t_L2ID) selected @endif>
                            {{ $L2Work->Name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-3">
                <p class="text-white"> شاخص هدف </p>
                <select class="form-control" name="L3Work" id="L3Select_1" disabled>
                    <option value="0">{{ __('--select--') }}</option>
                    @foreach ($L3Works as $L3Work)
                        <option
                            class="OptionL3_1 OptionL3_wc_1{{ $L3Work->WorkCat }}_L1{{ $L3Work->L1ID }}_L2{{ $L3Work->L2ID }}"
                            value="{{ $L3Work->UID }}"
                            @if ($RespnsType->MainIndex == $L3Work->UID) selected @endif>
                            {{ $L3Work->Name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="custom-separator"></div>
        <h6><i class="i-Cool-Guy" style="font-size: 20px"></i> شاخص خدمات دهنده </h6>
        <div style="background-color: green;padding-bottom: 20px;padding-top: 20px;border-radius: 5px;"
            class="form-row">
            <div class="col-lg-3">
                <p class="text-white">شاخص اصلی</p>
                @php
                $t_WorkCat = 0;
                $t_L1ID =0;
                $t_L2ID = 0;
            @endphp
                @foreach ($L3Works as $L3Work)
                    @if ($RespnsType->worker_index == $L3Work->UID)
                        @php
                            $t_WorkCat = $L3Work->WorkCat;
                            $t_L1ID = $L3Work->L1ID;
                            $t_L2ID = $L3Work->L2ID;
                        @endphp
                    @endif
                @endforeach
                <select class="form-control" name="WorkCat" id="WorkCatSelectBox_2"
                    onchange="WorkCatSelect_f('_2')">
                    <option value="0">{{ __('--select--') }}</option>
                    @foreach ($WorkCats as $WorkCat)
                        <option value="{{ $WorkCat->ID }}"
                            @if ($WorkCat->ID == $t_WorkCat) selected @endif>
                            {{ $WorkCat->Name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-3">
                <p class="text-white">شاخص لایه اول</p>
                <select class="form-control" name="L1Work" id="L1Select_2"
                    onchange="L1Selectfun_f('_2')" disabled>
                    <option value="0">{{ __('--select--') }}</option>
                    @foreach ($L1Works as $L1Work)
                        <option class="OptionL1_2 OptionL1_wc_2{{ $L1Work->WorkCat }}"
                            value="{{ $L1Work->L1ID }}"
                            @if ($L1Work->WorkCat == $t_WorkCat && $L1Work->L1ID == $t_L1ID) selected @endif>
                            {{ $L1Work->Name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-3">
                <p class="text-white">شاخص لایه دوم</p>
                <select class="form-control" name="L2Work" id="L2Select_2"
                    onchange="L2Selectfun_f('_2')" disabled>
                    <option value="0">{{ __('--select--') }}</option>
                    @foreach ($L2Works as $L2Work)
                        <option
                            class="OptionL2_2 OptionL2_wc_2{{ $L2Work->WorkCat }}_L1{{ $L2Work->L1ID }}"
                            value="{{ $L2Work->L2ID }}"
                            @if ($L2Work->WorkCat == $t_WorkCat && $L2Work->L1ID == $t_L1ID && $L2Work->L2ID == $t_L2ID) selected @endif>
                            {{ $L2Work->Name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-3">
                <p class="text-white"> شاخص هدف </p>
                <select class="form-control" name="worker_index" id="L3Select_2"
                    disabled>
                    <option value="0">{{ __('--select--') }}</option>

                    @foreach ($L3Works as $L3Work)
                        <option
                            class="OptionL3_2 OptionL3_wc_2{{ $L3Work->WorkCat }}_L1{{ $L3Work->L1ID }}_L2{{ $L3Work->L2ID }}"
                            value="{{ $L3Work->UID }}"
                            @if ($RespnsType->worker_index == $L3Work->UID) selected @endif>
                            {{ $L3Work->Name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="custom-separator"></div>
        <h6><i class="i-Business-Man" style="font-size: 20px"></i> شاخص خدمات گیرنده</h6>
        <div style="background-color: orange;padding-bottom: 20px;padding-top: 20px;border-radius: 5px;"
            class="form-row">
            <div class="col-lg-3">
                <p>شاخص اصلی</p>
                @php
                $t_WorkCat = 0;
                $t_L1ID =0;
                $t_L2ID = 0;
            @endphp
                @foreach ($L3Works as $L3Work)
                    @if ($RespnsType->customer_index == $L3Work->UID)
                        @php
                            $t_WorkCat = $L3Work->WorkCat;
                            $t_L1ID = $L3Work->L1ID;
                            $t_L2ID = $L3Work->L2ID;
                        @endphp
                    @endif
                @endforeach
                <select class="form-control" name="WorkCat" id="WorkCatSelectBox_3"
                    onchange="WorkCatSelect_f('_3')">
                    <option value="0">{{ __('--select--') }}</option>
                    @foreach ($WorkCats as $WorkCat)
                        <option value="{{ $WorkCat->ID }}"
                            @if ($WorkCat->ID == $t_WorkCat) selected @endif>
                            {{ $WorkCat->Name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-3">
                <p>شاخص لایه اول</p>
                <select class="form-control" name="L1Work" id="L1Select_3"
                    onchange="L1Selectfun_f('_3')" disabled>
                    <option value="0">{{ __('--select--') }}</option>
                    @foreach ($L1Works as $L1Work)
                        <option class="OptionL1_3 OptionL1_wc_3{{ $L1Work->WorkCat }}"
                            value="{{ $L1Work->L1ID }}"
                            @if ($L1Work->WorkCat == $t_WorkCat && $L1Work->L1ID == $t_L1ID) selected @endif>
                            {{ $L1Work->Name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-3">
                <p>شاخص لایه دوم</p>
                <select class="form-control" name="L2Work" id="L2Select_3"
                    onchange="L2Selectfun_f('_3')" disabled>
                    <option value="0">{{ __('--select--') }}</option>
                    @foreach ($L2Works as $L2Work)
                        <option
                            class="OptionL2_3 OptionL2_wc_3{{ $L2Work->WorkCat }}_L1{{ $L2Work->L1ID }}"
                            value="{{ $L2Work->L2ID }}"
                            @if ($L2Work->WorkCat == $t_WorkCat && $L2Work->L1ID == $t_L1ID && $L2Work->L2ID == $t_L2ID) selected @endif>
                            {{ $L2Work->Name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-3">
                <p> شاخص هدف </p>
                <select class="form-control" name="customer_index" id="L3Select_3"
                    disabled>
                    <option value="0">{{ __('--select--') }}</option>
                    @foreach ($L3Works as $L3Work)
                        <option
                            class="OptionL3_3 OptionL3_wc_3{{ $L3Work->WorkCat }}_L1{{ $L3Work->L1ID }}_L2{{ $L3Work->L2ID }}"
                            value="{{ $L3Work->UID }}"
                            @if ($RespnsType->customer_index == $L3Work->UID) selected @endif>
                            {{ $L3Work->Name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

</div>
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

    function WorkCatSelect_f(div_id) {
        if ($('#WorkCatSelectBox' + div_id).val() != 0) {
            $(".OptionL1" + div_id).hide();
            var TargetL1Show = '.OptionL1_wc' + div_id + $('#WorkCatSelectBox' + div_id).val();
            $(TargetL1Show).show();
            $('#L1Select' + div_id).prop('disabled', false);
            $('#L2Select' + div_id).prop('disabled', true);
            $('#L3Select' + div_id).prop('disabled', true);

        } else {
            $('#L1Select' + div_id).prop('disabled', true);
            $('#L2Select' + div_id).prop('disabled', true);
            $('#L3Select' + div_id).prop('disabled', true);
        }
    }

    function L1Selectfun_f(div_id) {
        if ($('#L1Select' + div_id).val() != 0) {
            var TargetL2Show = '.OptionL2_wc' + div_id + $('#WorkCatSelectBox' + div_id).val() + '_L1' + $('#L1Select' +
                div_id).val();
            $(".OptionL2" + div_id).hide();
            $(TargetL2Show).show();
            $('#L1Select' + div_id).prop('disabled', false);
            $('#L2Select' + div_id).prop('disabled', false);
            $('#L3Select' + div_id).prop('disabled', true);

        } else {
            $('#L1Select' + div_id).prop('disabled', false);
            $('#L2Select' + div_id).prop('disabled', true);
            $('#L3Select' + div_id).prop('disabled', true);
        }
    }

    function L2Selectfun_f(div_id) {
        if ($('#L2Select' + div_id).val() != 0) {
            var TargetL3Show = '.OptionL3_wc' + div_id + $('#WorkCatSelectBox' + div_id).val() + '_L1' + $('#L1Select' +
                div_id).val() + '_L2' + $(
                '#L2Select' + div_id).val();
            $(".OptionL3" + div_id).hide();
            $(TargetL3Show).show();
            $('#L1Select' + div_id).prop('disabled', false);
            $('#L2Select' + div_id).prop('disabled', false);
            $('#L3Select' + div_id).prop('disabled', false);

        } else {
            $('#L1Select' + div_id).prop('disabled', false);
            $('#L2Select' + div_id).prop('disabled', false);
            $('#L3Select' + div_id).prop('disabled', true);
        }
    }
</script>
<script>
    function newindex() {
        $('#newindexinput').attr("disabled", false);
        $('#Oldindexinput').attr("disabled", true);

    }

    function oldindex() {
        $('#newindexinput').attr("disabled", true);
        $('#Oldindexinput').attr("disabled", false);
    }
</script>
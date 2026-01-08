@php
    $Persian = new App\Functions\persian();
    $ProductData = $Desk->get_projects($ProjectID);
    $ProductMetaValue = json_decode($ProductData->meta_value);
@endphp
<div class="row">
    <div id="createProject" class="row targetForm ">
        <div class="col-lg-12 mb-12">
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
                                <input disabled type="text" class="form-control" name="subject" id=""
                                    placeholder=" نام پروژه" value="{{ $ProductMetaValue->subject }}">
                                <small class="ul-form__text form-text ">
                                    نام پروژه
                                </small>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="ul-form__label">توضیح پروژه :</label>
                                <input disabled type="text" class="form-control" name="desc" id=""
                                    placeholder="متن مختصری از پروژه" value="{{ $ProductMetaValue->desc }}">
                                <small class="ul-form__text form-text ">
                                    متن مختصری از پروژه
                                </small>
                            </div>
                            <div class="form-group col-md-12">
                                <label class="ul-form__label">متن پروژه</label>

                                <div>
                                    {!! $ProductMetaValue->data !!}
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent">
                        <div class="mc-footer">
                            <div class="row">
                                <div class="col-lg-6">
                                    <button type="submit" name="submit" value="makeProject"
                                        class="btn  btn-primary m-1">ویرایش اطلاعات
                                        پروژه</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- end::form -->
            </div>
        </div>
        @php
            $TargetTeam = $Desk->get_project_Info($ProjectID, 'TargetTeam');
            
        @endphp
        <div class="col-lg-6 mb-6">
            <div class="card">
                <div class="card-header bg-transparent">
                    <h3 class="card-title">گروه هدف</h3>
                </div>
                <form method="post">
                    @csrf

                    @if (count($TargetTeam) != 0)
                        @php
                            $TargetArray = json_decode($TargetTeam[0]->meta_value);
                        @endphp
                        <div class="card-body">
                            <div class="form-row ">
                                <div class="form-group col-md-12">
                                    <label class="ul-form__label"> شاخص گروه هدف :</label>
                                    <input disabled type="text" class="form-control" name="subject" id=""
                                        placeholder=" نام پروژه" value="{{ $TargetArray->Name }}">
                                    <small class="ul-form__text form-text ">
                                        نام شاخص گروه هدف
                                    </small>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent">
                            <button type="button" class="btn btn-success">نمایش</button>
                            <button type="button" class="btn btn-success">ارسال پیامک</button>
                            <button type="button" class="btn btn-success">ارسال اعلان</button>
                        </div>
                    @else
                        <div class="card-body">
                            <div class="form-row ">
                                <div id="TargetTeamShow" class="nested form-group col-md-12">
                                    <label class="ul-form__label">نام پروژه :</label>
                                    <input disabled type="text" class="form-control" id="TargetTeamIndexinput"
                                        placeholder=" نام پروژه" value="">
                                    <small class="ul-form__text form-text ">
                                        نام شاخص گروه هدف
                                    </small>
                                </div>
                                <div class="TargetTeamIndexList" class="form-group col-md-12">
                                    <label class="ul-form__label"> شاخص ها :</label>
                                    {!! $Desk->getIndexTree() !!}
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent">
                            <div class="TargetTeamIndexList mc-footer">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <button type="button" onclick="sumiter({{ $ProjectID }}, 'TargetTeam')"
                                            class="btn  btn-primary m-1">ثبت گروه هدف</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                </form>

                <!-- end::form -->
            </div>
        </div>
        @php
            $ProjectTeam = $Desk->get_project_Info($ProjectID, 'ProjectTeam');
        @endphp
        <div class="col-lg-6 mb-6">
            <div class="card">
                <div class="card-header bg-transparent">
                    <h3 class="card-title">گروه عملیات</h3>
                </div>
                <form method="post">
                    @csrf
                    <div class="card-body">
                        <div class="form-row ">
                            @if (count($ProjectTeam) != 0)
                                <div id="ProjectTeamShow" class="form-group col-md-12 ">
                                    <label class="ul-form__label">شاخص گروه عملیاتی :</label>
                                    <input disabled type="text" class="form-control" name="subject"
                                        id="ProjectTeamIndexinput" placeholder=" گروه عملیات"
                                        value="{{ $ProductMetaValue->subject }}">
                                    <small class="ul-form__text form-text ">
                                        نام شاخص گروه عملیات
                                    </small>

                                </div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent">
                        <button type="button" onclick="WorkAssign({{ $ProjectID }}, 'workassign')"
                            class="btn btn-success">تخصیص عملیات</button>
                        <button type="button" class="btn btn-success">ارسال پیامک</button>
                        <button type="button" class="btn btn-success">ارسال اعلان</button>
                    </div>
                @else
                    <div id="ProjectTeamShow" class="form-group col-md-12 nested">
                        <label class="ul-form__label">نام پروژه :</label>
                        <input disabled type="text" class="form-control" name="subject"
                            id="ProjectTeamIndexinput" placeholder=" گروه عملیات"
                            value="{{ $ProductMetaValue->subject }}">

                    </div>

                    <div class="ProjectTeamIndexList" class="form-group col-md-12">
                        <label class="ul-form__label"> شاخص ها :</label>
                        {!! $Desk->getIndexTree() !!}
                    </div>
            </div>
        </div>
        <div class="card-footer bg-transparent">
            <div class="ProjectTeamIndexList mc-footer">
                <div class="row">
                    <div class="col-lg-12">
                        <button type="button" onclick="sumiter({{ $ProjectID }}, 'ProjectTeam')"
                            class="btn  btn-primary m-1">
                            ثبت گروه عملیات</button>
                    </div>
                </div>
            </div>
        </div>
        @endif

        </form>
    </div>


    <!-- end::form -->
</div>
</div>
<br>
<hr>

<div id="ProjectAssign" class="col-lg-12 mb-12 row targetForm"></div>

<script>


    function sumiter($ProjectID, $target) {
        var count = 0;
        var $ThisVal = null;
        $('input.indexCehckbox:checkbox:checked').each(function() {
            $ThisVal = $(this).val();
            count++;

        });
        if (count == 1) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('', {
                    func: 'sumitIndex',
                    target: $target,
                    indexId: $ThisVal,
                    ProjectID: $ProjectID
                },

                function(data, status) {
                    $('#' + $target + 'Show').removeClass('nested');
                    $('.' + $target + 'IndexList').addClass('nested');
                    $('#' + $target + 'Indexinput').val(data);
                });


            $(".indexCehckbox").prop('checked', false);

        }
        if (count == 0) {
            alert('لطفا یک شاخص را انتخاب فرمایید');
        }
        if (count > 1) {
            alert('لطفا تنها یک شاخص را انتخاب فرمایید');
        }


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

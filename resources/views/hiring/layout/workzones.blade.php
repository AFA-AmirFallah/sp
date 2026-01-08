<div id="workzones" class=" main_forms col-lg-6 mb-3">
    <div class="card">
        <div class="card-header bg-transparent">
            <h3 class="card-title">زمینه فعالیت</h3>
        </div>
        <form action="">
            <div class="card-body">
                <div class="form-row ">
                    <div class="form-group col-md-12">
                        <label class="ul-form__label">رسته های فعالیت<span style="color: red">*</span></label>
                        <div class="row" style="padding: 15px;">
                            <select id="SelectTags" class="form-control col-xl-8 col-md-7">
                                @foreach ($Order->get_family_index() as $Tag)
                                    <option value="{{ $Tag->UID }}">
                                        {{ $Tag->Name }}
                                    </option>
                                @endforeach
                            </select>
                            <button type="button" onclick="addworkingzone()"
                                class="btn btn-success col-xl-4 col-md-5">افزودن</button>
                        </div>
                        <small class="ul-form__text form-text ">
                            رسته هایی که شرکت در آن فعالیت می نماید (یک یا چند رسته)
                        </small>
                    </div>

                </div>
                <div class="custom-separator"></div>

                <div class="form-row ">

                </div>
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="card-title">رسته های فعالیت</div>
                        @foreach ($Order->get_working_zone() as $workingZone)
                            <div class="d-flex flex-column flex-sm-row align-items-center mb-3">
                                <img class="avatar-lg mb-3 mb-sm-0 rounded mr-sm-3" src="{{ $workingZone->img }}"
                                    alt="">
                                <div class="flex-grow-1">
                                    <h5 class=""><a href="">{{ $workingZone->Name }}</a></h5>
                                </div>
                                <div>
                                    <button type="button" onclick="removeworkzone({{ $workingZone->UID }})"
                                        class="btn btn-outline-danger btn-rounded btn-sm">حذف رسته</button>
                                </div>
                            </div>
                        @endforeach




                    </div>
                </div>
            </div>

        </form>

    </div>
</div>
<div id="relations" class=" main_forms col-lg-6 mb-3">
    <div class="card">
        <div class="card-header bg-transparent">
            <h3 class="card-title">عضویت و وابستگی ها</h3>
        </div>
        <form action="">
            <div class="card-body">
                <div class="row" style="padding: 15px;">
                    <select id="MemeberTags" class="form-control col-xl-8 col-md-7">
                        @foreach ($Order->get_family_sandica_index() as $Tag)
                            <option value="{{ $Tag->UID }}">
                                {{ $Tag->Name }}
                            </option>
                        @endforeach
                    </select>
                    <button type="button" onclick="addmember()"
                        class="btn btn-success col-xl-4 col-md-5">افزودن</button>
                </div>
                <small class="ul-form__text form-text ">
                    رسته هایی که شرکت در آن فعالیت می نماید (یک یا چند رسته)
                </small>


                <div class="custom-separator"></div>

                <div class="form-row ">

                </div>
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="card-title"> عضویت در : </div>
                        @foreach ($Order->get_sandica_zone() as $workingZone)
                            <div class="d-flex flex-column flex-sm-row align-items-center mb-3">
                                <img class="avatar-lg mb-3 mb-sm-0 rounded mr-sm-3" src="{{ $workingZone->img }}"
                                    alt="">
                                <div class="flex-grow-1">
                                    <h5 class=""><a href="">{{ $workingZone->Name }}</a></h5>
                                </div>
                                <div>
                                    <button type="button" onclick="removeworkzone({{ $workingZone->UID }})"
                                        class="btn btn-outline-danger btn-rounded btn-sm">حذف عضویت</button>
                                </div>
                            </div>
                        @endforeach




                    </div>
                </div>
            </div>

        </form>

    </div>
</div>
<script>
    function removeworkzone($UID) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.post('', {
                submit: 'removeworkzone',
                UID: $UID,

            },

            function(data, status) {
                if (status == 'success') {
                    alert(data);
                    loadforms('workzones');
                } else {
                    alert('مشکلی به وجود آمده است');
                }

            });
    }

    function addmember() {
        $UID = $('#MemeberTags').find(":selected").val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.post('', {
                submit: 'savetag',
                UID: $UID,

            },

            function(data, status) {
                if (status == 'success') {
                    alert(data);
                    loadforms('workzones');
                } else {
                    alert('مشکلی به وجود آمده است');
                }

            });
    }
    function addworkingzone() {
        $UID = $('#SelectTags').find(":selected").val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.post('', {
                submit: 'savetag',
                UID: $UID,

            },

            function(data, status) {
                if (status == 'success') {
                    alert(data);
                    loadforms('workzones');
                } else {
                    alert('مشکلی به وجود آمده است');
                }

            });
    }
</script>

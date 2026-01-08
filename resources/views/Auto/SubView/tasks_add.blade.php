@php
    $Persian = new App\Functions\persian();
@endphp
<form method="post">
    @csrf
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade active show" id="account" role="tabpanel" aria-labelledby="account-tab">
            <div class="form-group row">
                <label for="validationCustom0" class="col-xl-3 col-md-4">
                    عنوان فعالیت <span class="text-danger">*</span></label>
                <input class="form-control col-xl-8 col-md-7" name="ADDName" placeholder="عنوان فعالیت" value=""
                    type="text" required>
            </div>
            <div class="form-group row">
                <label for="validationCustom1" class="col-xl-3 col-md-4">توضیحات</label>
                <textarea class="form-control col-xl-8 col-md-7" name="description" id="description"></textarea>

            </div>
            <div class="form-group row">
                <label for="validationCustom2" class="col-xl-3 col-md-4">برچسب ها</label>
                <select id="SelectTags" name="SelectTags[]" class="form-control col-xl-8 col-md-7" multiple="multiple">
                    @foreach ($user_class->get_tags(1) as $Tag)
                        <option value="{{ $Tag->id }}">
                            {{ $Tag->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group row">
                <label for="validationCustom2" class="col-xl-3 col-md-4">مسئول انجام</label>
                <select id="responsible" name="responsible[]" class="form-control col-xl-8 col-md-7"
                    multiple="multiple">
                    @foreach ($user_class->get_group_members($group_src->id) as $member)
                        <option value="{{ $member->UserName }}">
                            {{ $member->Name }} {{ $member->Family }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group row">
                <label class="col-xl-3 col-md-4">زمان اتمام</label>
                <div class="input-group  col-xl-4 col-md-4">
                    <input type="time" name="StartTime" class="form-control"  autocomplete="off"
                        placeholder="زمان اتمام" value="08:00">

                </div>
                <input class="form-control col-xl-4 col-md-3" type="text" name="StartDate"
                    autocomplete="off"
                    onfocus="Mh1PersianDatePicker.Show(this,'{{ $Persian->MyPersianDate(date('Y-m-d'), false, 'n') }}',)"
                    placeholder="تاریخ اتمام" />
            </div>
            <div class="form-group row">
                <label class="col-xl-3 col-md-4">چک لیست</label>
                <div class="col-xl-8 col-md-7" id="checklist">
                    <!-- آیتم‌ها اینجا اضافه می‌شوند -->
                </div>
            </div>


        </div>

    </div>
    <div style="float: left;padding: 10px;" >
        <button type="submit" name="submit" value="add_task" class="btn btn-primary">ذخیره</button>
    </div>
</form>



@php
    $Persian = new App\Functions\persian();
@endphp
<style>
    #progress-container {
        cursor: pointer;
        height: 30px;
    }

    #progress-bar {
        transition: width 0.2s ease;
    }
</style>
<form method="post">
    @csrf
    @if ($owner)
        <button type="button" onclick="switch_edit_mode()" style="float: left;margin:10px;"
            class="btn btn-warning">ویرایش</button>
    @endif
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade active show" id="account" role="tabpanel" aria-labelledby="account-tab">
            <div class="form-group row">
                <label for="validationCustom0" class="col-xl-3 col-md-4">
                    عنوان فعالیت <span class="text-danger">*</span></label>
                <div class="col-xl-8 col-md-7">
                    <h6 class="view_part">{{ $task_src->title }}</h6>
                    @if ($owner)
                        <input class="form-control edit_part d-none " name="ADDName" placeholder="عنوان فعالیت"
                            value="{{ $task_src->title }}" type="text" required>
                    @endif

                </div>

            </div>
            <div class="form-group row">
                <label for="validationCustom1" class="col-xl-3 col-md-4">توضیحات</label>
                <div class="col-xl-8 col-md-7">
                    <p class="view_part">
                        {{ str_replace('<br />', "\n", $task_src->description) }}
                    </p>
                    @if ($owner)
                        <textarea id="autoSizeTextarea" onkeyup="autoResize()" rows="5" class="form-control edit_part d-none ">{{ str_replace('<br />', "\n", $task_src->description) }}</textarea>
                    @endif
                </div>
            </div>
            <div class="form-group row">
                <label for="validationCustom2" class="col-xl-3 col-md-4">برچسب ها</label>
                <div class="col-xl-8 col-md-7">
                    <div class="row view_part">
                        @foreach ($tag_src as $tag)
                            <h6 class="badge badge-success">{{ $tag->name }}</h6>
                        @endforeach
                    </div>
                    @if ($owner)
                        <select id="SelectTags_edit" name="SelectTags[]" class="form-control edit_part d-none">
                            @foreach ($user_class->get_tags(1) as $Tag)
                                <option value="{{ $Tag->id }}">
                                    {{ $Tag->name }}
                                </option>
                            @endforeach
                        </select>
                    @endif
                </div>
            </div>
            <div class="form-group row">
                <label for="validationCustom2" class="col-xl-3 col-md-4">مسئول انجام</label>
                <div class=" col-xl-8 col-md-7">
                    <div class="row view_part">
                        @foreach ($responsible_src as $responsible)
                            <h6 class="badge badge-success">{{ $responsible->Name }} {{ $responsible->Family }}</h6>
                        @endforeach
                    </div>
                    @if ($owner)
                        <select id="responsible" name="responsible[]" class="form-control edit_part d-none">
                            @foreach ($user_class->get_group_members($group_src->id) as $member)
                                <option value="{{ $member->UserName }}">
                                    {{ $member->Name }} {{ $member->Family }}
                                </option>
                            @endforeach
                        </select>
                        <button class="btn btn-sml ">افزودن</button>
                    @endif
                </div>

            </div>
            <div class="form-group row">

                <label class="col-xl-3 col-md-4">زمان اتمام</label>
                <div class=" col-xl-8 col-md-7">
                    <div class="view_part">
                        {{ $Persian->MyPersianDate($task_src->deadline) }}

                    </div>
                    @if ($owner)
                        <div class="edit_part d-none">
                            <input class="form-control col-xl-7 col-md-7" type="text" name="StartDate"
                                autocomplete="off" value=""
                                onfocus="Mh1PersianDatePicker.Show(this,'{{ $Persian->MyPersianDate(date('Y-m-d'), false, 'n') }}',)"
                                placeholder="تاریخ اتمام" />
                        </div>
                    @endif


                </div>

            </div>
            <div class="form-group row">
                <label class="col-xl-3 col-md-4">چک لیست</label>
                <div class="col-xl-8 col-md-7" id="">
                    <table class="table table-bordered">
                        @foreach ($items_src as $item)
                            <tr>
                                <td><input type="checkbox" class="form-control"> </td>
                                <td>{{ $item->item }}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
            <h4>درصد انتخاب‌شده: <span id="selected-percent">0%</span></h4rss_feed>

                <div class="progress" id="progress-container">
                    <div class="progress-bar bg-success" role="progressbar" style="width: 0%;" id="progress-bar"></div>
                </div>

                <div class="form-group row"
                    style="margin: 10px;border-style: groove;border-width: 2px;padding: 10px;border-radius:10px;display:block;">
                    <h5>گزارشات</h5>
                    <textarea rows="3" id="report_txt" class="form-control"></textarea>
                    <button type="button" onclick="add_report({{ $task_src->id }})" class="btn btn-success">ثبت
                        گزارش</button>
                    <div class="row">
                        @foreach ($report_src as $report)
                            <p
                                style="display:block; margin-right: 9px;margin-top: 5px;background-color: antiquewhite;padding-top: 5px;padding-right: 10px;width: 97%;border-radius: 5px;">
                                {{ $Persian->MyPersianDate($report->created_at, true) }} {{ $report->Name }}
                                {{ $report->Family }} : <br>

                                {{ $report->description }}
                            </p>
                        @endforeach
                    </div>
                </div>
        </div>

    </div>
    <div style="float: left;padding: 10px;">
        <button type="button" name="submit" onclick="savetask()" class="btn btn-primary">ذخیره</button>
    </div>
</form>

@php
$TargetItem = $exams->get_single_item($Data);
$exams->set_input_Json($TargetItem->content);
$formula = $exams->get_item_ansewers_formula($Data2);
@endphp
<div class="modal-form" id="operation_pannel">
    <form method="post">
        @csrf
        <input type="text" name="MainTashimName" class="nested" value="">
        <input type="text" id="EditId" name="EditId" class="nested" value="">
        <div class="row">
            <div class="card-body col-md-4">
                <h3>فرمول</h3>
                فرمول پاسخ در صورت پاسخ دادن به گزینه انتخاب شده فعال می شود و یک یا چند متغییر از پیش تعریف شده را
                به روز رسانی می نماید
            </div>
            <div class="card-body col-md-4">
                <label>فرمول پاسخ</label>
                <textarea class="form-control" style="direction: ltr" id="FormolStr" name="FormolStr" cols="30" rows="10">{{ $formula }}</textarea>
                @php
                    $varSrc = $exams->get_exam_variables();
                    $vars = $varSrc->Variables;
                    $Notes = $varSrc->notes;
                    $conter = 0;
                @endphp
                @while (isset($vars[$conter]))
                    <li>{{ $vars[$conter] }}: {{ $Notes[$conter] }}</li>
                    @php
                        $conter++;
                    @endphp
                @endwhile

            </div>
            <div class="card-body col-md-4">
                <label>اسکریپت
                    <small>تنظیمات پیشرفته اسکریپتی</small>
                </label>
                <textarea class="form-control" style="direction: ltr" id="ItemScript" name="ItemScript" cols="30" rows="10"></textarea>
                <small style="direction: ltr;float:left">autoconfirm,custom_date_int</small>
                <br>
                <small style="direction: ltr;float:left">xxxxx : yyyyyy ;</small>
            </div>
        </div>
        <hr>

        <button type="button" onclick="addformula()" class="add-range btn btn-warning">ثبت فرمول</button>
        <button type="button" onclick="removeforms()" class="btn btn-success">انصراف</button>

    </form>
</div>

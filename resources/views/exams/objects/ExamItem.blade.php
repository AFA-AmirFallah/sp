@php
$TargetItem = $exams->get_single_item($Data);
$exams->set_input_Json($TargetItem->content);
@endphp
<div class="card">
    <div class="card-header gradient-purple-indigo 0-hidden pb-80">
        شماره: {{ $TargetItem->order }}

    </div>
    <div class="card-body">
        <div>
            {!! $exams->get_item_question() !!}
            @foreach ($exams->get_item_ansewers() as $ansewer)
                <div class=" row col col-md-12">
                    <div class="md-2">
                        {{ $ansewer->Order }}
                    </div>
                    <div class="md-10">
                        {!! $ansewer->content !!}
                        <div>
                            <input type="text" id="content_{{ $ansewer->Order }}" class="nested"
                                value="{!! $ansewer->content !!}">
                            <a onclick="editanswer({{ $TargetItem->id }},{{ $ansewer->Order }})" href="#">ویرایش
                                پاسخ</a>
                            <a onclick="loadpage_with_data_2('AnswerFormula','{{ $TargetItem->id }}',{{ $ansewer->Order }},'main_content_2')"
                                href="#">ویرایش فرمول</a>
                            <a onclick="deleteanswer({{ $TargetItem->id }},{{ $ansewer->Order }})" href="#">حذف
                                پاسخ</a>

                        </div>
                    </div>
                </div>
            @endforeach


        </div>
        <div class="card-footer">
            <a style="margin: 20px" onclick="editquestion({{ $TargetItem->id }})"> ویرایش سوال</a>
            <a style="margin: 20px" onclick="addansewer({{ $TargetItem->id }})"> افزودن پاسخ</a>
            <a style="margin: 20px" onclick="applytoall({{ $TargetItem->id }})">اعمال پاسخ های این پرسش بر همه</a>
            <div style="width: 90%;margin-top: 15px;border-style: solid;margin-right: 5%;padding: 13px;">
                <a >اعمال پاسخ های این پرسش بر روی</a>

                <input type="text" id="inputtext" class="form-control">
                <small>شماره سوالهایی که میخواهید جواب این پرسش بر روی آنها اعمال شود بین هر شماره یک space </small>
                <hr>
                <button  onclick="applytoSome({{ $TargetItem->id }})" class="btn btn-success" type="button" > اعمال</button>

            </div>

        </div>
    </div>
</div>

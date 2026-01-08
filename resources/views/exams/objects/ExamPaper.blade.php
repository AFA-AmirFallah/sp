@foreach ($exams->Get_exam_Item($Data) as $ExamItem)
    <div class="card">
        <div class="card-header gradient-purple-indigo 0-hidden pb-80">
            شماره: {{ $ExamItem->order }}
            <a onclick="edititem({{ $ExamItem->id }})" class="btn btn-warning">ویرایش</a>
        </div>
        @php
            $ItemContent = $exams->set_input_Json($ExamItem->content);
        @endphp
        <div class="card-body">
            <div>
                {!! $exams->get_item_question() !!}
            </div>

            @foreach ($exams->get_item_ansewers() as $ansewer)
                <div class=" row col col-md-12">
                    <div class="md-2">
                        {{ $ansewer->Order }}
                    </div>
                    <div class="md-10">
                        {!! $ansewer->content !!}
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endforeach

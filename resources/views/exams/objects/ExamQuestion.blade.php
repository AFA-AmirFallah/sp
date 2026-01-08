@php
$result = $exams->get_question_result();
@endphp
<form action="myform">
    <div>
        <h1 class="question mb-3 text-18">
            سوال {{ $QuestionSrc->order }} : {!! $exams->get_item_question() !!}
        </h1>
        <hr>
        @foreach ($exams->get_item_ansewers() as $ansewer)
            <div class="md-6" style="direction: initial;">
                <label for="addnewaddressRadio">{!! $ansewer->content !!}</label>
                @if ($result == $ansewer->Order)
                    <input id="addnewaddressRadio" checked type="radio" class="custom-checkbox" name="myRadio"
                        value="{{ $ansewer->Order }}">
                @else
                    <input id="addnewaddressRadio" type="radio" class="custom-checkbox" name="myRadio"
                        value="{{ $ansewer->Order }}">
                @endif
            </div>
        @endforeach
</form>
<div style="text-align: center">
    @if ($QuestionSrc->order != 1)
        <button style="font-size: 16px;display: inline-flex;" type="button" onclick="PreviousQuestion()"
            class=" btn btn-success"> <i class="i-Arrow-Forward-2"
                style="font-size: 18px;font-weight: 900;padding-left: 10px;padding-top: 2px;"> </i> سوال قبل </button>
    @endif
    @if ($exams->is_last_question($QuestionSrc->order))
        <button style="font-size: 16px;display: inline-flex;" type="button" onclick="finishQuestion()"
            class=" btn btn-success">ثبت آزمون</button>
    @else
        <button style="font-size: 16px;display: inline-flex;" type="button" onclick="nextQuestion()"
            class=" btn btn-success"> سوال بعد <i class="i-Arrow-Back-3"
                style="font-size: 18px;font-weight: 900;padding-right: 10px;padding-top: 2px;"></i></button>
    @endif
</div>


</div>

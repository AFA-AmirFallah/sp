<div id="list_pannel">
    <form method="post">
        @csrf
        <div class="card-body">
            <div class="table-responsive">
                <table id="ul-contact-list" class="{{ \App\myappenv::MainTableClass }}" style="width:100%">
                    <thead>
                        <tr>
                            <th scope="col">ترتیب اجرا</th>
                            <th scope="col">توضیحات</th>
                            <th scope="col">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <a class="btn btn-success" href="{{ route('AddExamItem',['ExamID'=>$Data]) }}">افزودن سوال</a>
                        @foreach ($exams->Get_exam_Item($Data) as $ExamItem )
                            <td>{{ $ExamItem->order }}</td>
                            <td>{{ $ExamItem->status }}</td>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </form>
</div>
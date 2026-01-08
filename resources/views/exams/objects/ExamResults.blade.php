@php
$Persian = new App\Functions\persian();

@endphp
<section class="contact-list">
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="card text-left">
                <div class="card-header text-right bg-transparent" style="text-align: right">
                    <h5 style="text-align: right;"> نتایج آزمون : {{ $exams->get_exam_Name($Data) }}</h5>
                </div>
                <form method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="request_table" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>شماره</th>
                                        <th>آزمون دهنده </th>
                                        <th>تاریخ آزمون </th>
                                        <th>نتیجه آزمون</th>
                                        <th>عملیات</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($exams->get_exam_results($Data) as $ExamResult)
                                        <tr>
                                            <td>{{ $ExamResult->id }}</td>
                                            <td>{{ $ExamResult->Name }} {{ $ExamResult->Family }}</td>
                                            <td>{{ $Persian->MyPersianDate($ExamResult->start_time, true) }}</td>
                                            @php
                                            
                                            if($ExamResult->exam_result == null){
                                                $ResultArr = null;

                                            }else{
                                                $ResultArr = $exams->get_result($ExamResult->exam_result);

                                            }
                                            @endphp
                                            <td>
                                                @if ($ResultArr == null)
                                                    پردازش نشده
                                                @else
                                                    @foreach ($ResultArr as $Resulttar)
                                                        @if ($loop->first)
                                                            {{ $Resulttar['PointName'] }} : {{ $Resulttar['Pointvalue'] }}
                                                        @else
                                                            <br>  {{ $Resulttar['PointName'] }} : {{ $Resulttar['Pointvalue'] }}
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach



                                </tbody>

                            </table>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

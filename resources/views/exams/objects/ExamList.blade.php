<section class="contact-list">
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="card text-left">
                <div class="card-header text-right bg-transparent" style="text-align: right">
                    <h5 style="text-align: right;"> لیست آزمون ها</h5>
                </div>
                <form method="POST">
                    @csrf 
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="request_table" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>شماره</th>
                                        <th>نام آزمون</th>
                                        <th>تعداد استفاده</th>
                                        <th>وضعیت</th>
                                        <th>عملیات</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($exams->get_exam() as $examItem)
                                        <tr>
                                            <td>{{ $examItem->id }}</td>
                                            <td><a href="{{ route('SingleExam',['ExamID'=>$examItem->id]) }}"> {{ $examItem->NameFa }} </a></td>
                                            <td>{{ $examItem->total_sales }} <a href="#" onclick="loadpage_with_data('ExamResults',{{$examItem->id}})">نمایش</a> </td>
                                            <td>
                                                @switch($examItem->Status)
                                                    @case(0)
                                                        غیر فعال
                                                    @break

                                                    @case(100)
                                                        فعال
                                                    @break

                                                    @default
                                                @endswitch
                                            </td>
                                            <td>
                                                @switch($examItem->Status)
                                                    @case(0)
                                                        <button type="submit" class="btn btn-danger" name="activate_exam"
                                                            value="{{ $examItem->id }}">فعال
                                                            سازی</button>
                                                    @break

                                                    @case(100)
                                                        <button type="submit" class="btn btn-danger" name="deactivate_exam"
                                                            value="{{ $examItem->id }}">غیر فعال
                                                            سازی</button>
                                                    @break

                                                    @default
                                                @endswitch
                                                <a onclick="loadpage_with_data('EditExam','{{ $examItem->id }}')" class="btn btn-warning">ویرایش آزمون</a>
                                                <a href="{{ route('ExamItems',['ExamID'=>$examItem->id]) }}" class="btn btn-warning">ویرایش محتوا </a>
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

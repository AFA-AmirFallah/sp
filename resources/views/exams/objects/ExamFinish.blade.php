<form action="myform">
    <div style="direction: rtl;text-align: right;" id="content">
        <div style="text-align: center">

            <div style="width: fit-content;" class="card">
                <div style="text-align: right;" class="card-header right">
                    <h5>ثبت موفق آزمون</h5>
                    
                </div>
                <div class="card-body">
                    <h6>آزمون شما با موفقیت ثبت گردید!</h6>
                    <p>سامانه در حال پردازش نتیجه آزمون شما می باشد </p>
                </div>
                <hr>
                <div class="card-fotter">
                    <a class="btn btn-success" href="{{ route('ExamResults',['ExamID'=>$exams->get_exam_Order_id()]) }}">نمایش نتیجه </a>
                </div>
            </div>
        </div>
    </div>
</form>



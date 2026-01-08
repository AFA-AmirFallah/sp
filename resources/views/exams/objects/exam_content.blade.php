<div class="auth-layout-wrap style=text-align: right;" style="background-image: url({{ url('/') }})">
    <div class="auth-content">
        <div class="card o-hidden">
            <div class="row">
                <div class="col-md-12">
                    <div class="p-4">
                        @include('Layouts.ErrorHandler')

                        <div style="direction: rtl;text-align: right;" id="content">
                            <div style="text-align: center">

                                <div style="width: fit-content;" class="card">
                                    <div style="text-align: right;" class="card-header right">
                                        <h5>{{ $ExamMAinSrc->NameFa }}</h5>
                                        <small>{{ $ExamMAinSrc->NameEn }}</small>
                                    </div>
                                    <div class="card-body">
                                        <img style="margin-bottom: 10px;" src="{{ $ExamMAinSrc->ImgURL }}"
                                            alt=" {{ $ExamMAinSrc->NameFa }}">

                                        <h3>{{ $ExamMAinSrc->Description }}</h3>
                                    </div>
                                    <hr>
                                    <div class="card-fotter">
                                        <button type="button" onclick="StartExam()" class="btn btn-primary">شروع
                                            آزمون</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>

        </div>
    </div>
</div>

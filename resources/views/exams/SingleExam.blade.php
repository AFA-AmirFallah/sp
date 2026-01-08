@extends('exams.objects.ExamLayout')
@section('Content')
    @if ($for_buy_exam['is_buyable'] && !$for_buy_exam['buy_before'])

    <div style="text-align: right" class="auth-layout-wrap style=text-align: right;" style="background-image: url({{ url('/') }})">
        <div class="auth-content">
            <div class="card o-hidden">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card border border-2 border-primary">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
                                    <h5 class="text-start text-uppercase mb-0">دسترسی به آزمون این صفحه
                                        نیاز به پرداخت دارد</h5>
                                    <span  class="badge bg-primary rounded-pill text-white">محتوای قابل خرید</span>
                                </div>
            
                                <div class="text-center position-relative mb-4 pb-3">
                                    <div class="d-flex">
                                        <h1 class="price-toggle text-primary price-yearly mb-0">
                                            {{ number_format($for_buy_exam['price']) }} <small>ریال</small>
                                        </h1>

                                        
            
                                        <sub class="h5 text-muted pricing-duration mt-auto mb-3"> /
                                            یک آزمون همراه با پاسخ</sub>
                                    </div>
                                    <h1>{{ $ExamMAinSrc->NameFa }}</h1>

                                </div>
                                <p>امکانات این صفحه پس از پرداخت</p>
            
                                <hr>

                                <ul class="list-unstyled pt-2 pb-1 lh-1-85">
                                    <li class="mb-2">
                                        <span
                                            class="badge badge-center align-middle w-px-20 h-px-20 rounded-pill bg-label-primary me-2">
                                            <i class="bx bx-check bx-xs"></i>
                                        </span>
                                        با خرید این محصول شما می توانید یک بار در آزمون مورد نظر شرکت نمایید و نتیجه آن را دانلود نمایید
                                    </li>
                                    <li class="mb-2">
                                        <span
                                            class="badge badge-center align-middle w-px-20 h-px-20 rounded-pill bg-label-primary me-2">
                                            <i class="bx bx-check bx-xs"></i>
                                        </span>
                                        در صورت نیاز به مشاوره در مورد نتیجه آزمون می توانید با ما در تماس باشید
                                    </li>

                                </ul>
                                <form method="POST">
                                    @csrf
                                    <button class="btn btn-primary d-grid w-100" type="submit" name="submit"
                                        value="pay">پرداخت</button>
                                </form>
            
                            </div>
                        </div>
                    </div>
    
    
                </div>
    
            </div>
        </div>
    </div>

    @elseif($for_buy_exam['is_buyable'] && $for_buy_exam['buy_before'])
        <span class="badge bg-success rounded-pill">خریداری شده</span>
        @include('exams.objects.exam_content')
    @else
        @include('exams.objects.exam_content')
    @endif



    @endsection
    @section('scripts')
        <script>
            function finishQuestion() {
                var myRadio = $("input[name=myRadio]");
                var checkedValue = myRadio.filter(":checked").val();
                if (checkedValue == null) {
                    alert('لطفا یک گزینه را انتخاب کنید!');
                    return null;
                }

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.post('', {
                        ajax: true,
                        procedure: 'finishQuestion',
                        checkedValue: checkedValue,

                    },
                    function(data, status) {
                        if (status == 'success') {
                            $('#content').html(data);
                        } else {
                            alert('مشکلی در ارتباط ایجاد شده است');
                        }
                    });
            }

            function nextQuestion() {
                var myRadio = $("input[name=myRadio]");
                var checkedValue = myRadio.filter(":checked").val();
                if (checkedValue == null) {
                    alert('لطفا یک گزینه را انتخاب کنید!');
                    return null;
                }

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.post('', {
                        ajax: true,
                        procedure: 'next',
                        checkedValue: checkedValue,

                    },
                    function(data, status) {
                        if (status == 'success') {
                            $('#content').html(data);
                        } else {
                            alert('مشکلی در ارتباط ایجاد شده است');
                        }
                    });
            }

            function PreviousQuestion() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.post('', {
                        ajax: true,
                        procedure: 'Previous',

                    },
                    function(data, status) {
                        if (status == 'success') {
                            $('#content').html(data);
                        } else {
                            alert('مشکلی در ارتباط ایجاد شده است');
                        }
                    });
            }

            function loadpages($Addressid) {
                $.ajax({
                    url: '?page=ExamQuestion',
                    type: 'get',
                    beforeSend: function() {

                    },
                    success: function(response) {
                        $('#content').html(response);

                    },
                    error: function() {
                        alert('can not');
                    }
                });
            }
        </script>
        <script>
            function StartExam() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.post('', {
                        ajax: true,
                        procedure: 'startexam',

                    },
                    function(data, status) {
                        if (status == 'success') {
                            $('#content').html(data);
                        } else {
                            alert('مشکلی در ارتباط ایجاد شده است');
                        }
                    });
            }
        </script>
    @endsection

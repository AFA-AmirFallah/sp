@php
    $Persian = new App\Functions\persian();
@endphp

@extends('Layouts.Theme7.layout.main_layout')
@section('content')
    <div class="page-content bg-white">
        <!-- contact area -->
        <div class="content-block">

            <!-- Browse Jobs -->
            <div class="section-full bg-white p-t50 p-b20">
                <div class="container">
                    <h1 class="form-header">فهرست تجربه دریافت خدمات درمانی ،مراقبتی</h1>
                    <div class="row">
                        <div class="col-xl-12 col-lg-12">
                            <div class="job-bx table-job-bx browse-job clearfix">
                                <div class="job-bx-title clearfix">
                                    <h5 class="font-weight-700 pull-left text-uppercase">نظرات ثبت توسط شما</h5>
                                </div>
                                <table>
                                    <thead>
                                        <tr>
                                            <th>کد</th>
                                            <th>نام درمانگر/پرستار</th>
                                            <th>امتیاز</th>
                                            <th>تاریخ</th>
                                            <th>وضعیت</th>
                                            <th>نمایش</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $count = 1;
                                        @endphp


                                        @foreach ($experience_src as $experience_item)
                                            @php
                                                $count++;
                                            @endphp
                                            <tr>
                                                <td>COM-{{ $experience_item->id }}</td>
                                                <td class="job-name">{{ $experience_item->Name }}
                                                </td>

                                                @switch($experience_item->rate)
                                                    @case(1)
                                                        <td class="criterias text-danger">
                                                            خیلی بد
                                                        </td>
                                                    @break

                                                    @case(2)
                                                        <td class="criterias text-danger">
                                                            بد
                                                        </td>
                                                    @break

                                                    @case(3)
                                                        <td class="criterias text-warning">
                                                            نسبتا خوب
                                                        </td>
                                                    @break

                                                    @case(4)
                                                        <td class="criterias text-success">
                                                            خوب
                                                        </td>
                                                    @break

                                                    @case(5)
                                                        <td class="job-name text-success">
                                                            عالی
                                                        </td>
                                                    @break

                                                    @default
                                                @endswitch
                                                <td class="date">
                                                    {{ $Persian->PersianDateText($experience_item->created_at) }}</td>
                                                <td>
                                                    @switch($experience_item->status)
                                                        @case(0)
                                                            در انتظار بررسی کارشناس
                                                        @break

                                                        @case(100)
                                                            منتشر شده
                                                        @break

                                                        @default
                                                    @endswitch

                                                </td>
                                                <td class="job-links">
                                                    <a href="javascript:void"
                                                        onclick="load_comment('{{ $experience_item->id }}')"
                                                        data-toggle="modal" data-target="#exampleModalLong">
                                                        <i class="fa fa-eye"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        @if ($count == 1)
                                            <tr>
                                                <td>
                                                    <p>تا کنون نظری توسط شما ثبت نشده است.</p>
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            <!-- Modal -->
                            <div class="modal fade modal-bx-info" id="exampleModalLong" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <div class="logo-img">
                                                <img alt="" src="/Theme7/images/favicon.png">
                                            </div>
                                            <h5 class="modal-title">
                                                گزارش خدمت درمانگر/پرستار
                                            </h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <ul>
                                                <li><strong>خدمت:</strong>
                                                    <p id="comm_service"></p>
                                                </li>
                                                <li><strong>خدمات‌دهنده:</strong>
                                                    <p id="comm_name"></p>
                                                </li>
                                                <li><strong>امتیاز :</strong>
                                                    <p id="comm_rate"></p>
                                                </li>
                                                <li><strong>توضیحات :</strong>
                                                    <p id="comm_comment"></p>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">بستن</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Modal End -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- Browse Jobs END -->
        </div>
    </div>
    <script>
        function load_comment(comment_id) {
            $('#comm_name').html('...');
            $('#comm_rate').html('...');
            $('#comm_service').html('...');
            $('#comm_comment').html('...');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('', {
                    function: 'load_comment',
                    id: comment_id
                },
                function(data, status) {
                    if (data['result']) {
                        $('#comm_name').html(data['Name']);
                        $('#comm_rate').html(data['rate']);
                        $('#comm_comment').html(data['comment']);
                        $('#comm_service').html(data['service']);
                        return true;
                    } else {
                        alert(data['msg']);
                        return false;
                    }
                });
        }
    </script>
@endsection

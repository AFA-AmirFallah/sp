@php
    $Persian = new App\Functions\persian();
@endphp
@extends('Layouts.Theme9.Layout.mian_layout')
@section('content')
    <div class="main-container container">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm mb-4">
                    <div class="card-header">
                        <div class="row">
                            <div class="col">
                                <h6 class="my-1">لیست آگهی های من</h6>
                            </div>

                        </div>
                    </div>
                    <ul class="list-group list-group-flush">
                        @foreach ($deals as $deal_item)
                            <li class="list-group-item border-0">
                                <div class="row">
                                    <div class="col-auto">
                                        <figure class="avatar avatar-50 rounded-circle">
                                            <img src="assets/img/user1.jpg" alt="">
                                        </figure>
                                    </div>
                                    <div class="col px-0">
                                        <p>{{ $deal_item->title }}<br><small class="text-muted">{{ $deal_item->show_price }}
                                            </small></p>
                                    </div>
                                    <div class="col-auto text-start">
                                        <p>
                                            @switch($deal_item->status)
                                                @case(0)
                                                    <small class="text-muted">در انتظار انتشار <span
                                                            class="avatar avatar-6 rounded-circle bg-warning d-inline-block"></span></small>
                                                @break

                                                @case(0)
                                                    <small class="text-muted">منتشر شده<span
                                                            class="avatar avatar-6 rounded-circle bg-success d-inline-block"></span></small>
                                                @break

                                                @default

                                                <small class="text-muted">منقضی <span
                                                    class="avatar avatar-6 rounded-circle bg-danger d-inline-block"></span></small>
                                            @endswitch

                                            <br><small class="text-success">۰ بازدید</small>
                                        </p>
                                    </div>
                                </div>
                            </li>
                        @endforeach

                    </ul>
                </div>
            </div>
        </div>

    </div>
@endsection
@section('page-js')
@endsection

@php
    $Persian = new App\Functions\persian();
@endphp
@extends('news.Layouts.MainLayout')
@section('trending')
    @include('news.Layouts.HotNews')
@endsection
@section('page-title')
    {{ $Order->GetUserInfo()->UpTitel }} {{ $Order->GetUserInfo()->Titel }}
@endsection
@section('end_css')
    <link rel="canonical" href="{{ url()->current() }}">
@endsection
@section('container')
    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
            <div class="single-post">
            </div><!-- Single post end -->
            <h1 style="font-size: 20px;margin-top:-10px;">
                {{ $Order->GetUserInfo()->UpTitel }} {{ $Order->GetUserInfo()->Titel }}
                @if ($AdminLogin)
                    <h5 style="float: left">
                        <a href="{{ route('myprofile', ['RequestUser' => $input_address_src->fgstr]) }} " target="_blank"> <i
                                class="fa fa-pencil"></i>
                        </a>

                    </h5>
                @endif
            </h1>
            {!! $Order->get_data('InfoTxt') !!}
            <hr>
            <div id="mgt_contacts" class=" main_forms col-lg-6 mb-3">
                @for ($i = 1; $i < 5; $i++)
                    @php
                        $FildName = 'mgt_' . $i;
                    @endphp
                    @if ($Order->get_data($FildName) != null)
                        @php
                            $mgtInfo = $Order->get_data($FildName);
                        @endphp
                        <section class=" widget-card">
                            <div class="row">
                                <div class="col-lg-12 col-xl-12 mt-12">
                                    <div class=" card">
                                        <div class="card-body">
                                            <div class="user-profile mb-4">
                                                @if ($mgtInfo->mgt_pic != null)
                                                    <div style="text-align: center">

                                                        <img style="width: 250px" id="useravatar{{ $i }}"
                                                            src="{{ $mgtInfo->mgt_pic }}" alt="avatar"
                                                            class="img-fluid img-90 rounded-circle blur-up lazyloaded dropzone dropzone-area dz-clickable">
                                                        <div class="fallback">
                                                            <input style="display: none" name='file'
                                                                id="file{{ $i }}" type="file" />
                                                        </div>

                                                        <hr>


                                                    </div>
                                                @else
                                                    <div style="text-align: center">
                                                        <img style="width: 250px" id="useravatar{{ $i }}"
                                                            src="{{ url('/') }}/assets/images/avtar/useravatar.png"
                                                            alt="avatar"
                                                            class="img-fluid img-90 rounded-circle blur-up lazyloaded dropzone dropzone-area dz-clickable">

                                                        <div class="fallback">
                                                            <input style="display: none" name="avatar"
                                                                id="file{{ $i }}" type="file" />
                                                        </div>

                                                    </div>
                                                @endif
                                                <p style="text-align: center" class="m-0 text-24">{{ $mgtInfo->mgt_name }}
                                                </p>
                                                <p style="text-align: center" class="text-muted m-0">
                                                    {{ $mgtInfo->mgt_title }}
                                                </p>
                                            </div>
                                            <div class="ul-widget-card__rate-icon">
                                                <p>{{ $mgtInfo->mgt_desc }}</p>
                                            </div>
                                            <p class="text-muted m-0 text-center"><i class="i-Old-Telephone text-green"
                                                    style="font-size: 20px;color:green;"></i> {{ $mgtInfo->mgt_phone }}</p>
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </section>
                    @endif
                @endfor

            </div>



        </div><!-- Content Col end -->

        @include('news.Layouts.MostView')

    </div><!-- Row end -->
@endsection

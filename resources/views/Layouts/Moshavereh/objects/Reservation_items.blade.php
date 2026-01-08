    @isset($sarchtext)
        @php
            $DataSurce = $Consult->get_serach_consult($sarchtext);
        @endphp
    @endisset
    @isset($L3id)
        @php

            $DataSurce = $Consult->get_cunsultent_in_one_aria($L3id);
        @endphp
    @endisset
    @foreach ($DataSurce as $ConsultItem)
        <div class="box p-4 mt-3">
            <div class="row">
                <div class="col-lg-2 text-lg-right text-center">
                    <a href="{{ route('Consultation', ['userid' => $ConsultItem->Ext]) }}">
                        @if($ConsultItem->avatar == null)
                        <img src="{{App\myappenv::LoginUserAvatarPic}}" class="img-fluid rounded-circle mb-lg-0 mb-3" >
                        @else
                        <img src="{{ $ConsultItem->avatar }}" class="img-fluid rounded-circle mb-lg-0 mb-3" >
                        @endif

                    </a>
                </div>
                <div class="col-lg-10 pr-lg-3 text-lg-right text-center">

                    <ul>
                        <li>
                            <span class="float-lg-left ">
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                            </span>

                        </li>
                        <li>
                            <a href="{{ route('Consultation', ['userid' => $ConsultItem->Ext]) }}">
                                <h5 class="IRANSansWeb_Medium">
                                    {{ $ConsultItem->Name }} {{ $ConsultItem->Family }}
                                </h5>

                            </a>
                        </li>
                        <li>
                            @php

                                $serviceItems = $Consult->get_worker_working_cats($ConsultItem->UserName, null);
                            @endphp
                            <p>
                                @foreach ($serviceItems as $serviceItem)
                                {{ $serviceItem->Name }}
                            @endforeach
                            </p>
                           {{--  <span class="bg-warning py-1 px-2 text-dark  rad25">154 مشاوره</span> - <span
                                class="IRANSansWeb_Medium text-danger">26 نظر</span>
 --}}
                            @if ($Consult->is_user_active($ConsultItem->UserName))
                                <p class="mt-3 mb-0 IRANSansWeb_Medium text-success"><i class="online ml-2"></i>
                                    وضعیت:آماده پاسخگویی

                                </p>
                            @else
                                <p class="mt-3 mb-0 IRANSansWeb_Medium text-dark"><i class="offline ml-2"></i>
                                    وضعیت: خارج از دسترس
                                </p>
                            @endif
                            <p class="mt-2 mb-lg-0">{{ $ConsultItem->Address }} </p>
                        </li>
                        <li class="float-lg-left">
                            <a href="{{ route('Consultation', ['userid' => $ConsultItem->Ext]) }}"
                                class="btn btn-danger text-white rad25">دریافت مشاوره</a>

{{--                             <a href="{{ route('Consultation', ['userid' => $ConsultItem->Ext]) }}" class="btn btn-success text-white rad25">نوبت دهی آنلاین</a>
 --}}                        </li>
                    </ul>

                </div>
            </div>
        </div>
    @endforeach

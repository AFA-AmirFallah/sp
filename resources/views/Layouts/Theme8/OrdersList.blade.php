@php
    $Persian = new App\Functions\persian();
@endphp
@extends('Layouts.Theme8.layout.main_layout')
@section('content')
    <section class="search-result-services">

        <section class="bg-dark py-md-5 py-4 px-xl-5 px-2 mb-4">
            <div class="container">
                <h1 class="text-white">ثبت درخواست خدمت</h1>
            </div>
        </section>

        <!--result-->
        <section class="result-services mb-4">
            <div class="container">
                <div class="row">
                    @php
                        $Conter = 0;
                    @endphp

                    @foreach ($cat_orders as $cat_orders_item)
                        @php
                            $Conter++;
                        @endphp
                        @if ($cat_orders_item->centers > 0)
                            <form style="display: contents"
                                action="{{ route('CustomerOrder', ['OrderID' => $cat_orders_item->Cat]) }}">
                                <div class="col-lg-4 col-md-6">
                                    <a href="#" class="service bg-white">
                                        <div class="img">
                                            <img class="w-100" src="{{ $cat_orders_item->Pic }}" alt="">
                                            <div class="s-type text-one-line text-white text-center p-2">
                                                خدمات هوم‌کر
                                            </div>
                                        </div>
                                        <div class="p-3">
                                            <div class="s-name text-one-line mb-2">
                                                {{ $cat_orders_item->TitleDescription }}
                                            </div>
                                            <div class="star-rate d-inline-flex mb-2">
                                                <div class="base-stars">
                                                    <div class="star">
                                                        <svg viewBox="0 0 15 14" fill="none"
                                                            xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                d="M7.36838 11.2516L11.9193 14L10.7135 8.81962L14.7368 5.33443L9.43928 4.88484L7.36838 0L5.29749 4.88484L0 5.33443L4.0233 8.81962L2.81464 14L7.36838 11.2516Z"
                                                                fill="currentColor" />
                                                        </svg>
                                                    </div>
                                                    <div class="star">
                                                        <svg viewBox="0 0 15 14" fill="none"
                                                            xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                d="M7.36838 11.2516L11.9193 14L10.7135 8.81962L14.7368 5.33443L9.43928 4.88484L7.36838 0L5.29749 4.88484L0 5.33443L4.0233 8.81962L2.81464 14L7.36838 11.2516Z"
                                                                fill="currentColor" />
                                                        </svg>
                                                    </div>
                                                    <div class="star">
                                                        <svg viewBox="0 0 15 14" fill="none"
                                                            xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                d="M7.36838 11.2516L11.9193 14L10.7135 8.81962L14.7368 5.33443L9.43928 4.88484L7.36838 0L5.29749 4.88484L0 5.33443L4.0233 8.81962L2.81464 14L7.36838 11.2516Z"
                                                                fill="currentColor" />
                                                        </svg>
                                                    </div>
                                                    <div class="star">
                                                        <svg viewBox="0 0 15 14" fill="none"
                                                            xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                d="M7.36838 11.2516L11.9193 14L10.7135 8.81962L14.7368 5.33443L9.43928 4.88484L7.36838 0L5.29749 4.88484L0 5.33443L4.0233 8.81962L2.81464 14L7.36838 11.2516Z"
                                                                fill="currentColor" />
                                                        </svg>
                                                    </div>
                                                    <div class="star">
                                                        <svg viewBox="0 0 15 14" fill="none"
                                                            xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                d="M7.36838 11.2516L11.9193 14L10.7135 8.81962L14.7368 5.33443L9.43928 4.88484L7.36838 0L5.29749 4.88484L0 5.33443L4.0233 8.81962L2.81464 14L7.36838 11.2516Z"
                                                                fill="currentColor" />
                                                        </svg>
                                                    </div>
                                                </div>
                                                <!-- set width inline style!! -->
                                                <div class="active-stars" style="width: 50%">
                                                    <div class="star">
                                                        <svg viewBox="0 0 15 14" fill="none"
                                                            xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                d="M7.36838 11.2516L11.9193 14L10.7135 8.81962L14.7368 5.33443L9.43928 4.88484L7.36838 0L5.29749 4.88484L0 5.33443L4.0233 8.81962L2.81464 14L7.36838 11.2516Z"
                                                                fill="currentColor" />
                                                        </svg>
                                                    </div>
                                                    <div class="star">
                                                        <svg viewBox="0 0 15 14" fill="none"
                                                            xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                d="M7.36838 11.2516L11.9193 14L10.7135 8.81962L14.7368 5.33443L9.43928 4.88484L7.36838 0L5.29749 4.88484L0 5.33443L4.0233 8.81962L2.81464 14L7.36838 11.2516Z"
                                                                fill="currentColor" />
                                                        </svg>
                                                    </div>
                                                    <div class="star">
                                                        <svg viewBox="0 0 15 14" fill="none"
                                                            xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                d="M7.36838 11.2516L11.9193 14L10.7135 8.81962L14.7368 5.33443L9.43928 4.88484L7.36838 0L5.29749 4.88484L0 5.33443L4.0233 8.81962L2.81464 14L7.36838 11.2516Z"
                                                                fill="currentColor" />
                                                        </svg>
                                                    </div>
                                                    <div class="star">
                                                        <svg viewBox="0 0 15 14" fill="none"
                                                            xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                d="M7.36838 11.2516L11.9193 14L10.7135 8.81962L14.7368 5.33443L9.43928 4.88484L7.36838 0L5.29749 4.88484L0 5.33443L4.0233 8.81962L2.81464 14L7.36838 11.2516Z"
                                                                fill="currentColor" />
                                                        </svg>
                                                    </div>
                                                    <div class="star">
                                                        <svg viewBox="0 0 15 14" fill="none"
                                                            xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                d="M7.36838 11.2516L11.9193 14L10.7135 8.81962L14.7368 5.33443L9.43928 4.88484L7.36838 0L5.29749 4.88484L0 5.33443L4.0233 8.81962L2.81464 14L7.36838 11.2516Z"
                                                                fill="currentColor" />
                                                        </svg>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="s-location d-flex pb-2 mb-3">
                                                <div class="ml-2">
                                                    <svg width="16" height="20" viewBox="0 0 16 20" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M10.6995 13.1889L10.364 13.5154C12.8457 13.7927 14.5779 14.6135 14.5779 15.664C14.5777 17.0314 11.7978 18.2725 8.00236 18.2725H7.99726H7.99216C4.19667 18.2725 1.41665 17.0315 1.41665 15.6642C1.41665 14.6135 3.14893 13.7928 5.63053 13.5156L5.29497 13.1891C1.9539 13.52 0 14.5874 0 16.2369C0 18.4622 3.57931 20.0001 7.99723 20.0001C12.415 20.0001 15.9945 18.4623 15.9945 16.2369C15.9943 14.5871 14.0406 13.5196 10.6995 13.1887L10.6995 13.1889Z"
                                                            fill="#C1C1C1" />
                                                        <path
                                                            d="M7.99695 16.5858C7.99803 16.5876 8.00205 16.5937 8.00205 16.5937C8.00205 16.5937 13.3457 8.39412 13.3457 5.6981C13.3457 1.73129 10.6376 0.00551483 7.99708 0C5.35658 0.00552916 2.64844 1.73143 2.64844 5.6981C2.64844 8.39393 7.99212 16.5937 7.99212 16.5937C7.99212 16.5937 7.99614 16.5874 7.99722 16.5858H7.99695ZM6.14433 5.47432C6.14433 4.45121 6.97378 3.6217 7.99695 3.6217C9.02028 3.6217 9.84956 4.45115 9.84956 5.47432C9.84956 6.49748 9.02011 7.32693 7.99695 7.32693C6.97384 7.32715 6.14433 6.4977 6.14433 5.47432Z"
                                                            fill="#C1C1C1" />
                                                    </svg>
                                                </div>
                                                <div class="text-one-line">
                                                    بیمارستان مجازی
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                @if(Auth::check())
                                                <button type="submit" class="btn-view font-semibold mr-auto">
                                                    ثبت درخواست
                                               </button>
                                                @else
                                                <button type="submit" class="btn-view font-semibold mr-auto">
                                                     لاگین و ثبت درخواست
                                                </button>
                                                @endif
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </form>
                        @endif
                    @endforeach


                </div>
            </div>
        </section>

    </section>
@endsection
@section('EndScripts')
@endsection

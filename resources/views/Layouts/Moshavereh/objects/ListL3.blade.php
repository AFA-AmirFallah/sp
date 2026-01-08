<section class="container mt-3 p-4 max-900 ">
    <h5 id="headingtitle" class="IRANSansWeb_Medium bt-color text-center mb-4"> گفتگو و مشاوره با بهترین مشاوره ها

        @foreach ($Consult->get_consulting_Aria($CatID, $ZoneID) as $Zone)
            @php

                if ($Zone->extra_data == null) {
                    $moshaver_list = [];
                    $user_count = 0;
                } else {
                    $extra_data = json_decode($Zone->extra_data);
                    $moshaver_list = json_decode($extra_data->user_set);
                    $user_count = $extra_data->count;
                }
            @endphp
            <a href="{{ route('Reservationlist', ['L3id' => $Zone->UID, 'L3Name' => $Zone->Name]) }}">
                <div class="row box-transform">
                    <div class="col-lg-12 value-body text-center mb-3 p-3 brbtm">
                        <div class="row">
                            <div class="col-md-3 pt-3 pr-3">

                                <span>گفتگو و مشاوره با <b class="IRANSansWeb_Medium"> {{ $Zone->Name }}
                                    </b></span>
                            </div>
                            <div class="col-md-7 px-3">
                                <ul class="Consulation-list">
                                    @if ($moshaver_list != [])
                                        @php
                                            $counter = 0;
                                        @endphp
                                        @foreach ($moshaver_list as $moshaver_item)
                                            @php
                                                $counter++;
                                            @endphp
                                            @if ($counter > 7)
                                            @break
                                        @endif
                                        <li>
                                            <img style="width: 70px;height: 70px;"
                                                src="{{ $moshaver_item->avatar ?? App\myappenv::LoginUserAvatarPic }}"
                                                class="rounded-circle img-fluid" />
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                        <div class="col-md-2 pt-3 pr-3">
                            <span class="IRANSansWeb_Light">+{{ $user_count }} مشاور دیگر .. &nbsp;</span>
                            <i class="fas fa-chevron-left"></i>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    @endforeach

    <div class="text-center my-3">
        <a href="#" class="btn btn-danger text-white px-5">+ مشاهده دیگر کارشناسان </a>

    </div>
</section>

        <div style="margin-bottom: 20px;">
            @if (\App\myappenv::MainOwner == 'sepehrmall')
                <div style="box-shadow: none" class="card">
                @else
                    <div class="card">
            @endif
            @if ($mobile_banner->pic != '#')
                <div style="font-size: 16px;font-weight: 600;" class="card-header gradient-purple-indigo 0-hidden pb-80">
                    <img style="
                    max-width: 60px;
                " src="{{ $mobile_banner->pic }}" alt=""> {{ $mobile_banner->title }}
                </div>
            @endif
            <div class="card-body">
                <div style="margin: 0px;margin-right: -18px !important;margin-left: 38px !important;display: -webkit-box;width: 111%;"
                    class="carousel_wrap col-md-12 row">

                    @foreach ($DashboardClass->GetL2Index($mobile_banner->link) as $Cat)
                        <div style="padding-left: 0px ;padding-right: 5px" class="wpa-md4 col-md-4">
                            <a href="{{ route('ShowProduct', ['l2' => $Cat->L2ID, 'l1' => $Cat->L1ID, 'TagsrcName' => $Cat->Name]) }} "
                                data-target=".bd-example-modal-lg">
                                <div class=" card card-ecommerce-3 o-hidden mb-4">
                                    <div class="d-flex flex-column flex-sm-row">
                                        <div class="">
                                            <img class=" card-img-left" src="{{ $Cat->img }}"
                                                alt="{{ $Cat->Name }}">
                                        </div>
                                        <div class="flex-grow-1 p-4">
                                            <h6 style="white-space: normal;height: 26px;"
                                                class="CustomerServiceCardHeader m-0">
                                                {{ $Cat->Name }} </h6>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>

            </div>
        </div>


        </div>

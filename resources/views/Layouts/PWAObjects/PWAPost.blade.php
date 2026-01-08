        <div style="margin-bottom: 20px;">
            <div class="card">
                <div style="
                font-size: 16px;
                font-weight: 600;
            " class="card-header gradient-purple-indigo 0-hidden pb-80">
                    <img style="
                    max-width: 60px;
                " src="{{ $mobile_banner->pic }}" alt=""> {{ $mobile_banner->title }}
                </div>
                <div class="card-body">
                    {!! \App\Http\Controllers\WPA_admin\banners::GetPost($mobile_banner->link)->Content !!}


                </div>
            </div>


        </div>

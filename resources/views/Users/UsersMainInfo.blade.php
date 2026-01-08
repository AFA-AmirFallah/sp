<form id="formtarget" action="{{route('UserProfile',['RequestUser'=>$UserInfoResult->UserName])}}" method="post">
    @csrf
    <div class="card">
        <div class="card-header gradient-purple-indigo 0-hidden pb-80">
            <h5 class="text-white"><i class=" header-icon i-Administrator"></i>{{ $UserInfoResult->nameofuser }}
                {{ $UserInfoResult->Family }}</h5>
        </div>
        <div class="card-body">
            <div class="profile-details text-center">
                @if(isset($JsonFild['pic']))
                    <img src="{{$JsonFild['pic']}}" alt=""
                         class="img-fluid img-90 rounded-circle blur-up lazyloaded">
                @else
                    <img id="button-select-upload" src="{{url('/')}}/assets/images/avtar/useravatar.png" alt=""
                         class="img-fluid img-90 rounded-circle blur-up lazyloaded">
                @endif
                <h5 class="f-w-600 mb-0">{{$UserInfoResult->nameofuser}} {{$UserInfoResult->Family}}</h5>
                <span>{{$UserInfoResult->MobileNo}}</span>
                <div class="social">
                                    <span class="badge badge-danger"
                                          style="font-size: 18px">{{__('User Role')}}: {{$UserInfoResult->RoleName}}</span>
                    <span class="badge badge-warning"
                          style="font-size: 18px">{{__('Status')}}: {{$UserInfoResult->statusname}}</span>
                </div>
            </div>
            <hr>
            <div class="project-status">
                <div>
                    <h5 class="f-w-600">{{__("Send SMS:")}}</h5>
                </div>
                <div style="text-align: right">
                                    <textarea name="MessageText" class="form-control" required placeholder="{{__("Enter your SMS text!!")}}" cols="37"
                                              rows="10"></textarea>
                    <div>
                        <button type="submit" class="btn btn-warning" style="margin:auto;display:block"
                                name="submit" value="SendSms">
                            {{__('send')}}
                        </button>
                    </div>
                </div>


            </div>
        </div>
    </div>
</form>

@extends('Crypto.CryptoAdmin')
@section('CryptoCountent')
    <div class="col-lg-‍12 mb-3">
        <div class="card">
            <div class="card-header bg-transparent">
                <h3 class="card-title">مدیریت ربات </h3>
            </div>
            @php
                $Market1 = '';
                $Market2 = '';
                $Market3 = '';
                $Market4 = '';
                $Market5 = '';
                foreach ($Markets as $MarketItem) {
                    switch ($MarketItem->fgint) {
                        case '1':
                            $Market1 = $MarketItem->meta_key;
                            break;
                        case '2':
                            $Market2 = $MarketItem->meta_key;
                            break;
                        case '3':
                            $Market3 = $MarketItem->meta_key;
                            break;
                        case '4':
                            $Market4 = $MarketItem->meta_key;
                            break;
                        case '5':
                            $Market5 = $MarketItem->meta_key;
                            break;
                
                        default:
                            # code...
                            break;
                    }
                }
            @endphp
            <form method="post">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-2 col-md-3 col-sm-3">
                            <div class="card card-icon mb-4">
                                <div class="card-header text-center blue text-white font-weight-bold ">
                                    <i class="i-Notepad text-white mt-1" style="font-size: 30px"></i>
                                    بازار اول
                                </div>
                                <div class="card-body text-center">
                                    <input type="text" name="Market1" class="form-control" value="{{$Market1}}">
                                    <div class="btnaria-header" style="display: flex">
                                        <button type="submit" name="submit" value="Market1"
                                            class="btn btn-danger btn-block m-1 mb-3"> ثبت </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-3 col-sm-3">
                            <div class="card card-icon mb-4">
                                <div class="card-header text-center blue text-white font-weight-bold ">
                                    <i class="i-Notepad text-white mt-1" style="font-size: 30px"></i>
                                    بازار دوم
                                </div>
                                <div class="card-body text-center">
                                    <input type="text" name="Market2" class="form-control"  value="{{$Market2}}">
                                    <div class="btnaria-header" style="display: flex">
                                        <button type="submit" name="submit" value="Market2"
                                            class="btn btn-danger btn-block m-1 mb-3"> ثبت </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-3 col-sm-3">
                            <div class="card card-icon mb-4">
                                <div class="card-header text-center blue text-white font-weight-bold ">
                                    <i class="i-Notepad text-white mt-1" style="font-size: 30px"></i>
                                    بازار سوم
                                </div>
                                <div class="card-body text-center">
                                    <input type="text" name="Market3" class="form-control"  value="{{$Market3}}">
                                    <div class="btnaria-header" style="display: flex">
                                        <button type="submit" name="submit" value="Market3"
                                            class="btn btn-danger btn-block m-1 mb-3"> ثبت </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-3 col-sm-3">
                            <div class="card card-icon mb-4">
                                <div class="card-header text-center blue text-white font-weight-bold ">
                                    <i class="i-Notepad text-white mt-1" style="font-size: 30px"></i>
                                    بازار چهارم
                                </div>
                                <div class="card-body text-center">
                                    <input type="text" name="Market4" class="form-control"  value="{{$Market4}}">
                                    <div class="btnaria-header" style="display: flex">
                                     c   <button type="submit" name="submit" value="Market4"
                                            class="btn btn-danger btn-block m-1 mb-3"> ثبت </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-3 col-sm-3">
                            <div class="card card-icon mb-4">
                                <div class="card-header text-center blue text-white font-weight-bold ">
                                    <i class="i-Notepad text-white mt-1" style="font-size: 30px"></i>
                                    بازار پنجم
                                </div>
                                <div class="card-body text-center">
                                    <input type="text" name="Market5" class="form-control"  value="{{$Market5}}"> 
                                    <div class="btnaria-header" style="display: flex">
                                        <button type="submit" name="submit" value="Market5"
                                            class="btn btn-danger btn-block m-1 mb-3"> ثبت </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div onclick="openform('sendnotif')" class="col-lg-2 col-md-3 col-sm-3">
                            <div class="card card-icon mb-4">
                                <div class="card-header text-center green text-white font-weight-bold ">
                                    <i class="i-Mailbox-Full text-white mt-1" style="font-size: 30px"></i>
                                    تنظیمات
                                </div>
                                <div class="card-body text-center">
                                    <div class="btnaria-header" style="display: flex">
                                        <button type="button" class="btn btn-danger btn-block m-1 mb-3">افرودن <i
                                                class=" text-white"></i></button>
                                        <button type="button" class="btn btn-primary btn-block m-1 mb-3">فهرست <i
                                                class=" text-white"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </form>
            <!-- end::form -->
        </div>

    </div>
@endsection
@section('page-js')
@endsection

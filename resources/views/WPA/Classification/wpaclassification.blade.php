@extends("WPA.Layouts.MainPage")

@section('MainCountent')

@endsection
<div class="page light">
    <div class="navbar navbar-style-1">
        <div class="navbar-inner">
            <div class="left">
                <a href="#" class="link back">
                    <i class="mdi mdi-arrow-right"></i>
                </a>
            </div>
            <div class="title">دسته بندی ها</div>
            <div class="right"></div>
        </div>
    </div>
    <div class="page-content content-area pt-90 pb-20">
        <div class="container">
            <div class="row">
                @foreach($Cats as $Cat)
                    <div class="col-50 medium-25">
                        <a href="/deals/" class="item-category">
                            <div class="item-icon">
                                <img style="height: 90px" src="{{$Cat->img}}">
                            </div>
                            <div class="item-info">
                                <h3 class="title">{{$Cat->Name}}</h3>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

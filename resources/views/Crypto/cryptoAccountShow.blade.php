@extends('Crypto.CryptoAdmin')
@section('CryptoCountent')
    <div class="col-lg-6 mb-3">
        <div class="card">
            <div class="card-header bg-transparent">
                <h3 class="card-title">مشخصات شما در صرافی</h3>
            </div>
            <!--begin::form-->
            <form method="post">
                @csrf
                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            {{ $UserProfile['first_name'] }}  {{ $UserProfile['last_name']}}
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('page-js')
@endsection

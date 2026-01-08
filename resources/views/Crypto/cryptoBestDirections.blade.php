@extends('Crypto.CryptoAdmin')
@section('CryptoCountent')
    <div class="col-lg-‍12 mb-3">
        <div class="card">
            <div class="card-header bg-transparent">
                <h3 class="card-title">عرضه و تقاضا</h3>
            </div>
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <table class="{{ \App\myappenv::MainTableClass }}">
                            <thead>
                                <th class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
                                    نام ارز
                                </th>
                                <th class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
                                    درصد کلی خرید نسبت به فروش
                                </th>
                                <th>

                                </th>
                            </thead>

                            @foreach ($BestDirections as $CoinName => $CoinDirection)
                                <form method="POST">
                                    @csrf
                                    <tr>
                                        <th class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
                                            {{ $CoinName }}
                                        </th>
                                        <th class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
                                            {{ $CoinDirection }}
                                        </th>
                                        <th>
                                            <button type="submit" name="Buy" value="{{ $CoinName }}">Buy</button>
                                            <input name="TMN" required type="text" placeholder="TMN Qty">
                                        </th>
                                    </tr>
                                </form>
                            @endforeach
                        </table>



                    </div>

                </div>
            </div>
            <form method="post">
                @csrf
                <div class="card-footer bg-transparent">
                    <div class="mc-footer">
                        <div class="row">
                            <div class="col-lg-12">
                                <button type="submit" name="submit" value="syncwithcenter" class="btn  btn-primary m-1">به
                                    روز رسانی از صرافی</button>
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

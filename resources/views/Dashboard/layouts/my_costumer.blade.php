<div class="col-lg-12 col-md-12 mb-5">
    <div class="card">
        <div style="text-align: center" class="card-header green">

            <div class="card-title text-white"> <i class="i-Myspace"
                    style="font-size: 30px;display: inherit;color: cornsilk;"></i>مشتریان من
            </div>

        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table" style="width: 100%">
                    <thead>
                            <tr>
                                <th>ردیف</th>
                                <th>نام</th>
                                <th>تلفن</th>
                                <th>توضیحات</th>
                                <th>تاریخ</th>
                                <th>وضعیت</th>
                                <th>خرید</th>
                            </tr>

                    </thead>
                    <tbody>
                        @foreach (App\Affiliate\affiliate_user::get_user_assign_coustomers(Auth::id()) as $single_user)
                            <tr>
                                <td> {{ $loop->iteration }}</td>
                                <td>{{$single_user->Name}} {{$single_user->Family}} </td>
                                <td>{{$single_user->MobileNo}}</td>
                                <td>{{$single_user->extranote}}</td>
                                <td>{{$Persian->MyPersianDate($single_user->CreateDate) }}</td>
                                <td>{{$single_user->status_name}} </td>
                                <td>{{$single_user->orders}} </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

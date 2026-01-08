@extends('Layouts.MainPage')
@section('page-header-left')
    <h3>افزودن بانک
        <small>عملیات حسابداری</small>
    </h3>
@endsection
@section('MainCountent')
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-lg-6">
                    <div class="page-header-left">
                        <h3>مدیریت کیف پول
                            <small>عملیات حسابداری</small>
                        </h3>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->

    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card tab2-card">
                    <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                        <h5>ایجاد کیف پول جدید</h5>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs tab-coupon" id="myTab" role="tablist">
                            <li class="nav-item"><a class="nav-link active show" id="account-tab" data-toggle="tab"
                                    href="#account" role="tab" aria-controls="account" aria-selected="true"
                                    data-original-title="" title="">مشخصات کیف پول</a>
                            </li>
                        </ul>
                        <form method="post" class="needs-validation user-add" novalidate="">
                            @csrf
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade active show" id="account" role="tabpanel"
                                    aria-labelledby="account-tab">
                                    <div style="text-align: left">
                                        <i class="i-Money-Bag" style="font-size: 50px;"></i>
                                    </div>
                                    <div class="form-group row">
                                        <label for="validationCustom0" class="col-xl-3 col-md-4">نام کیف پول<span
                                                class="required">*</span></label>
                                        <input class="form-control col-xl-8 col-md-7" name="ModName" type="text"
                                            value="" required>
                                    </div>
                                    <div class="form-group row">
                                        <label for="validationCustom1" class="col-xl-3 col-md-4">API</label>
                                        <input class="form-control col-xl-8 col-md-7" name="API" value=""
                                            type="text">
                                        <small>در صورتی که کیف پول از طریق API تغییر میکند این فیلد پر شود</small>
                                    </div>


                                </div>

                            </div>
                            <div class="pull-right">
                                <button type="submit" name="submit" value="register"
                                    class="btn btn-primary">ذخیره</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <hr>

        <div class="row">
            <div class="col-sm-12">
                <div class="card tab2-card">
                    <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                        <h5>لیست کیف پول ها</h5>
                    </div>
                    <form method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="ul-contact-list"
                                    class="display table table-striped table-bordered dataTable no-footer"
                                    style="width: 100%;" role="grid" aria-describedby="ul-contact-list_info">
                                    <thead>
                                        <tr role="row">
                                            <th>شناسه کیف پول</th>
                                            <th>نام کیف پول</th>
                                            <th>نوع کیف پول</th>
                                            <th>عملیات کیف پول</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($CreditModSrc as $CreditModItem)
                                            <tr>
                                                <td>{{ $CreditModItem->ID }}</td>
                                                <td>{{ $CreditModItem->ModName }}</td>
                                                <td>{{ $functions->GetWalletType($CreditModItem->extra, $CreditModItem->ID) }}
                                                </td>
                                                <td>
                                                    @if ($CreditModItem->ID < 3)
                                                        قابل ویرایش نیست
                                                    @else
                                                        <button type="submit" name="periodical"
                                                            value="{{ $CreditModItem->ID }}" class="btn btn-warning">اعتبار
                                                            دوره
                                                            ای</button>
                                                    @endif
                                                </td>


                                            </tr>
                                        @endforeach
                                        ‍
                                    </tbody>

                                </table>

                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
@endsection

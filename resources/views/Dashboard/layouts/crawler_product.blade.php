<div class="col-md-12">
    <div class="card mb-4">

        <div id="products_list" class="card-body">
            <div class="card-title m-0">محصولات رقبا</div>
            <a href="{{ route('MainCrawler') }}">تنظیمات</a>
            <hr>
            <div class="row">
                <div class="col-lg-2 col-md-3 col-sm-3">
                    <div class="card card-primary card-icon mb-4">
                        <div class="card-body text-center"><i class="i-Gift-Box"></i>
                            <p class="mt-2 mb-2">کل محصولات</p>
                            <p class="text-primary text-24 line-height-1 m-0">
                                {{ App\crawler\CrawlerReporter::get_product_total_count() }}</p><!--v-if-->
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-3">
                    <div class="card card-icon mb-4 card-primary">
                        <div class="card-body text-center"><i class="i-Gift-Box"></i>
                            <p class="mt-2 mb-2"> محصولات بررسی شده</p>
                            <p class="text-primary text-24 line-height-1 m-0">
                                {{ App\crawler\CrawlerReporter::get_product_process_count() }}</p><!--v-if-->
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-3">
                    <div class="card card-primary card-icon mb-4">
                        <div class="card-body text-center"><i class="i-Clock"></i>
                            <p class="mt-2 mb-2">آخرین به روز رسانی</p>
                            <p class="text-primary text-24 line-height-1 m-0">
                                {{ App\crawler\CrawlerReporter::get_product_last_update() }}</p><!--v-if-->
                        </div>
                    </div>
                </div>
                <form action="{{ route('dashboard') }}" style="display: contents" method="post">
                    @csrf
                    @foreach (App\crawler\CrawlerReporter::get_main_crawlers() as $crawler_main)
                        <div class="col-lg-2 col-md-3 col-sm-3">
                            <div class="card card-primary card-icon mb-4">
                                <div class="card-body text-center"><i class="i-Bar-Chart-2"></i>
                                    <p class="mt-2 mb-2"> {{ $crawler_main->Name }}</p>
                                    <p class="text-primary text-24 line-height-1 m-0">
                                        <button type="submit" name="reload_crawler" value="{{ $crawler_main->id }}"
                                            class="btn btn-danger">بررسی مجدد</button>
                                    </p><!--v-if-->
                                </div>
                            </div>
                        </div>
                    @endforeach
                </form>


            </div>
            <div class="col-lg-12 col-md-12 mb-5">
                <div class="card">
                    <div style="text-align: center" class="card-header green">

                        <div class="card-title"> <i class="i-Gift-Box"
                                style="font-size: 30px;display: inherit;color: cornsilk;"></i> محصولات موجود
                        </div>

                    </div>
                    <div class="card-body">
                        @php
                            $update_all = false;
                        @endphp
                        <div class="table-responsive">
                            <table class="{{ \App\myappenv::MainTableClass }}" id="ul-contact-list" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>محصول</th>
                                        <th>وضعیت</th>
                                        <th>قیمت</th>
                                        <th>مرجع</th>
                                        <th>به روز رسانی</th>
                                        <th>عملیات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach (App\crawler\CrawlerReporter::get_product_list() as $product_item)
                                        @php
                                            $update = false;
                                            $add = false;
                                            $availability = 'نا مشخص';
                                            if (str_contains($product_item->TargetData, 'InStock')) {
                                                $availability = 'موجود';
                                            }
                                            if (str_contains($product_item->TargetData, 'OutOfStock')) {
                                                $availability = 'ناموجود';
                                            }
                                            if ($product_item->Status == 100) {
                                                $update = true;
                                                $update_all = true;
                                            }
                                            if ($product_item->Status == 0) {
                                                $add = true;
                                                $update_all = true;
                                            }
                                        @endphp
                                        @if ($update)
                                            <tr style="background-color: greenyellow">
                                            @elseif($add)
                                            <tr style="background-color: orange">
                                            @else
                                            <tr>
                                        @endif
                                        @if ($update)
                                            <td>U</td>
                                        @elseif($add)
                                            <td>A</td>
                                        @else
                                            <td>#</td>
                                        @endif
                                        <td>{{ $product_item->Name }}</td>
                                        <td>{{ $availability }}</td>
                                        <td>{{ number_format($product_item->price) }}</td>
                                        <td>{{ $product_item->c_name }}</td>
                                        <td>{{ $Persian->MyPersianDate($product_item->updated_at, true) }}</td>
                                        <td><a target="_blank" href="{{ $product_item->TargetAddress }}">نمایش</a>
                                        </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @if ($update_all)
                                <button onclick="price_update()" class="btn btn-warning">به روز رسانی قیمت</button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<script>
    function price_update() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.post('<?php echo e(route('ajax')); ?>', {
                AjaxType: 'checkCrawlLink',
                LinkID: $LinkID,
            },

            function(data, status) {
                $('#label_' + $LinkID).html(data);
                return true;

            });
    }
</script>

@php
    $Persian = new App\Functions\persian();
@endphp
<div class="form-group col-md-6">
    <label for="inputEmail4" class="ul-form__label">
       لیست سفارشات</label>  
    <div style="text-align: center" class="ul-card-list__modal">
        <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div id="product-list-suggesstion-box" class="modal-body">

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="user-show-aria" class="input-group col-xl-8 col-md-7 nested">
        <div id="name_of_target_user" class="tag"></div>
    </div>


</div>
<div id="product_table_detial">
    <div class="card-body">
        <div class="table-responsive">
            <table id="Product-list" class="{{ \App\myappenv::MainTableClass }}" style="width:100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>تاریخ تراکنش</th>
                        <th>شماره فاکتور</th>
                        <th>مبلغ بدهی</th>

                    </tr>
                </thead>
                <tbody>
                    @php
                        $Rowno = 1;
                        $GoodId = null;
                    @endphp

                    @foreach ($cashier->MyUnPayed() as $CashItem)
                        <tr>
                            <td>{{ $Rowno++ }}</td>
                            <td>{{$Persian->MyPersianDate($CashItem->Date,true)   }}</td>
                            <td><a target="blank" href="{{ route('EditOrder',['OrderID'=>$CashItem->InvoiceNo]) }}">{{$CashItem->InvoiceNo  }}</a></td>
                            <td>{{ number_format(abs($CashItem->Mony ))   }}</td>
                        </tr>
                    @endforeach
                    @if ($Rowno == 1)
                        <p>موردی یافت نشد!</p>
                    @endif

                </tbody>

            </table>
        </div>

    </div>


</div>

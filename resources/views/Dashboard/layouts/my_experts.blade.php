<div style="text-align: center" class="ul-card-list__modal">
    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form method="post" action="{{route('dashboard')}}">
                @csrf
                <div class="modal-content">
                    <div id="product-list-suggesstion-box" class="modal-body">
                        <div class="form-group row">
                            <label for="validationCustom0" class="col-xl-3 col-md-4"> ثبت و ویرایش مهارتهای من: </label>
                            <select id="SelectTags" name="SelectTags[]" style="width: 100%"
                                class="form-control col-xl-12 col-md-12" multiple="multiple">
                                @foreach ($hiring->get_worker_skills(Auth::id()) as $Tag)
                                    <option @if ($Tag->UserName != null) selected="selected" @endif>
                                        {{ $Tag->Name }}
                                    </option>
                                @endforeach
                            </select>
                            <hr>
                            <button type="submit" class="btn btn-success" name="add_expert" value="add" >ثبت</button>

                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>

<div class="col-lg-12 col-md-12 mb-5">
    <div class="card">
        <div style="text-align: center" class="card-header green">

            <div class="card-title text-white"> <i class="i-Myspace"
                    style="font-size: 30px;display: inherit;color: cornsilk;"></i>مهارتهای من
            </div>
            <button id="search_user_btn_submit" class="add btn btn-success" type="button" data-toggle="modal"
                onclick="Search_Product()" data-target=".bd-example-modal-lg">ویرایش</button>

        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table" style="width: 100%">
                    <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>مهارت</th>
                            <th>وضعیت</th>
                        </tr>

                    </thead>
                    <tbody>
                        @foreach ($hiring->get_worker_exact_skills(Auth::id()) as $single_expert)
                            <tr>
                                <td> {{ $loop->iteration }}</td>
                                <td> {{ $single_expert->Name }}</td>
                                <td> {{ $single_expert->validation ? 'تائید' : 'در انتظار تائید ' }} </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

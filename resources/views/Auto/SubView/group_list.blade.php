<div class="row col-md-12">
    <!-- end of col-->

    <div id="table-continer" class="targetForm col-md-12">
        <div class="card o-hidden mb-4">
            <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                <h3 id="Table-card-header" class="w-50 text-white float-left card-title m-0">گروه ها</h3>

            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="MainTable" class="table  text-center">
                        <thead id="main-table-header">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">نام گروه</th>
                                <th scope="col">تاریخ ثبت</th>
                                <th scope="col">ثبت کننده</th>
                                <th scope="col">اعضا</th>
                                <th scope="col">وضعیت</th>
                                <th scope="col">عملیات</th>
                            </tr>
                        </thead>
                        <tbody id="MainTable_body">
                            @foreach ($admin_class->get_group_list() as $group_item)
                                <tr>
                                    <td>{{ $loop->iteration }} </td>
                                    <td>{{ $group_item->name }} </td>
                                    <td>{{ $Persian->MyPersianDate($group_item->created_at) }} </td>
                                    <td>{{ $group_item->creator_name }} {{ $group_item->creator_family }} </td>
                                    <td>{{ $group_item->memeber_count }} نفر</td>
                                    @switch($group_item->status)
                                        @case(0)
                                            <td class="text-danger">غیر فعال</td>
                                        @break

                                        @case(100)
                                            <td class="text-success"> فعال</td>
                                        @break

                                        @default
                                    @endswitch
                                    <td><a href="{{ route('group_admin', ['group_id' => $group_item->id]) }} ">ویرایش</a>
                                    </td>


                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- end of col-->
</div>

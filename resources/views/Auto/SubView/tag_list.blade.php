<div class="row col-md-12">
    <!-- end of col-->
    <form style="all: unset;width: 100%;" method="post">
        @csrf
        <div id="table-continer" class="targetForm  col-md-12">
            <div class="card o-hidden mb-4">
                <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                    <h3 id="Table-card-header" class="w-50 text-white float-left card-title m-0">برچسب ها</h3>

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="MainTable" class="table  text-center">
                            <thead id="main-table-header">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">نام برچسب</th>
                                    <th scope="col">تاریخ ثبت</th>
                                    <th scope="col">رنگ</th>
                                    <th scope="col">وضعیت</th>
                                    <th scope="col">عملیات</th>
                                </tr>
                            </thead>
                            <tbody id="MainTable_body">
                                @foreach ($admin_class->get_tag_list() as $tag_item)
                                    <tr>
                                        <td>{{ $loop->iteration }} </td>
                                        <td>{{ $tag_item->name }} </td>
                                        <td>{{ $Persian->MyPersianDate($tag_item->created_at) }} </td>
                                        <td style="background-color: {{ $tag_item->color }}">{{ $tag_item->color }}</td>
                                        @switch($tag_item->status)
                                            @case(0)
                                                <td class="text-danger">غیر فعال</td>
                                            @break

                                            @case(1)
                                                <td class="text-success"> فعال</td>
                                            @break

                                            @default
                                        @endswitch
                                        <td>
                                            @switch($tag_item->status)
                                                @case(0)
                                                    <button type="submit" name="active_tag" value="{{ $tag_item->id }}"
                                                        class="btn btn-success">فعال سازی</button>
                                                @break

                                                @case(1)
                                                    <button type="submit" name="deactive_tag" value="{{ $tag_item->id }}"
                                                        class="btn btn-danger">غیر فعال سازی</button>
                                                @break

                                                @default
                                            @endswitch
                                        </td>


                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- end of col-->
</div>

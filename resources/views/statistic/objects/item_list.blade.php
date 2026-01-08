    <h3 class="card-title">افزودن / ویرایش فیلد</h3>
    @foreach ($statistic_items_src as $statistic_items_item)
        <div class="card">
            <div class="card-body">
                <h6>
                    {{ $statistic_items_item->item_name }}

                </h6>
                <p>
                    {{ $statistic_items_item->item_index_str }}

                </p>
                <a href="javascript:load_item('{{ $statistic_items_item->id }}','{{ $statistic_items_item->item_name }}','{{ $statistic_items_item->item_index_str }}',);">ویرایش</a>
            </div>
        </div>
    @endforeach
    <hr>

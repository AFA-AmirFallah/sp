<button type="button" class="btn btn-success" onclick="addtobasket('{{ $ProductId }}',{{ $row }})">خرید
    نقدی</button>
@if ($ProductList != [])

    @foreach ($ProductList as $TashimItem)
        <button style="margin: 3px" type="button" class="btn btn-success"
            onclick="addtobasket('{{ $ProductId }}',{{ $row }},{{ $TashimItem->id }})">{{ $TashimItem->Name }}</button>

    @endforeach

@endif

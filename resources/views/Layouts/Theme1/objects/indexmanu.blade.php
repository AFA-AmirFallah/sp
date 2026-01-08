@if ($layer == 'l1')
    <h3 class="widget-title"><span>تمام دسته بندیها</span></h3>
    <ul class="widget-body filter-items search-ul">
        @foreach ($L1Src as $L1Item)
            <li><a onclick="l2load('{{ $L1Item->L1ID }}','{{ $L1Item->Name }}')">{{ $L1Item->Name }}</a></li>
        @endforeach
    </ul>
@endif
@if ($layer == 'l2')
    <h3 class="widget-title"><span>{{ $header }}</span></h3>
    <ul class="widget-body filter-items search-ul">
        @foreach ($L2Src as $L2Item)
            <li><a
                    onclick="l3load('{{ $L2Item->L1ID }}','{{ $L2Item->L2ID }}','{{ $header }}','{{ $L2Item->Name }}')">{{ $L2Item->Name }}</a>
            </li>
        @endforeach
    </ul>
@endif
@if ($layer == 'l3')
    <h3 class="widget-title"><span>{{ $header }}</span></h3>
    <ul class="widget-body filter-items search-ul">
        @if ($L3Src != null)
            @foreach ($L3Src as $L3Item)
                <li><a href="{{ route('ShowProduct', ['Tags' => $L3Item->UID]) }}">{{ $L3Item->Name }}</a></li>
            @endforeach
        @else
            <li><a>ناموجود</a></li>
        @endif
    </ul>
@endif

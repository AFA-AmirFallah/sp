<div class="separator-breadcrumb border-top">
    <ul class="nav nav-tabs step-anchor">
        <li class="nav-item top-link @if ($target_step == 1) actived  @else done @endif"><a
                @if ($file_id == null) href="" @else href="{{ route('working_file', ['file_id' => $file_id]) }}" @endif
                class="nav-link">اطلاعات
                پایه<br><small>مشخصات پایه
                    فایل</small></a>
        </li>
        <li class="nav-item top-link @if ($target_step == 2) actived  @else done @endif"><a
                @if ($file_id == null) href="" @else href="{{ route('input_calls', ['file_id' => $file_id]) }}" @endif
                class="nav-link">تماسها<br><small>تماسهای ورودی</small></a></li>
        <li class="nav-item top-link @if ($target_step == 3) actived  @else done @endif"><a
                @if ($file_id == null) href="" @else href="{{ route('output_calls', ['file_id' => $file_id]) }}" @endif
                class="nav-link">تماسها<br><small>تماسهای خروجی</small></a></li>
        <li class="nav-item top-link @if ($target_step == 4) actived  @else done @endif"><a
                @if ($file_id == null) href="" @else href="{{ route('file_workflow', ['file_id' => $file_id]) }}" @endif
                class="nav-link">گزارش<br><small>گزارش کارشناسان</small></a>
        </li>

    </ul>
</div>

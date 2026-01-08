<div class="separator-breadcrumb border-top">
    <ul class="nav nav-tabs step-anchor">
        <li class="nav-item top-link @if ($target_step == 1) actived  @else done @endif"><a
                @if ($file_id == null) href="" @else href="{{ route('edit_file', ['file_id' => $file_id]) }}" @endif
                class="nav-link">اطلاعات
                پایه<br><small>مشخصات پایه
                    فایل</small></a>
        </li>
        <li class="nav-item top-link @if ($target_step == 2) actived  @else done @endif"><a
                @if ($file_id == null) href="" @else href="{{ route('edit_pic', ['file_id' => $file_id]) }}" @endif
                class="nav-link">تصاویر<br><small>تصاویر فایل</small></a></li>
        <li class="nav-item top-link @if ($target_step == 3) actived  @else done @endif"><a
                @if ($file_id == null) href="" @else href="{{ route('edit_properties', ['file_id' => $file_id]) }}" @endif
                class="nav-link">مشخصات<br><small>مشخصات اصلی</small></a></li>
        <li class="nav-item top-link @if ($target_step == 4) actived  @else done @endif"><a
                @if ($file_id == null) href="" @else href="{{ route('edit_admins', ['file_id' => $file_id]) }}" @endif
                class="nav-link">کارشناسان<br><small>ویرایش کارشناسان</small></a>
        </li>
        <li class="nav-item top-link  @if ($target_step == 5) actived  @else done @endif"><a
                @if ($file_id == null) href="" @else href="{{ route('setting_admins', ['file_id' => $file_id]) }}" @endif
                class="nav-link">تنظیمات<br><small>تنظیمات انتشار فایل</small></a></li>
        @if ($file_id != null)
            <li class="nav-item top-link"><a href="{{ route('files', ['file_id' => $file_id]) }}" class="nav-link">نمایش
                    فایل</a></li>
        @endif

    </ul>
</div>

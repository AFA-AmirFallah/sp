<div class="separator-breadcrumb border-top">
    <ul class="nav nav-tabs step-anchor">
        <li class="nav-item top-link @if ($target_step == 1) actived  @else done @endif"><a
                href="{{ route('admin_single_experience', ['id' => $id]) }}" 
                class="nav-link">اطلاعات
                پایه<br><small>مشخصات پایه
                    فایل</small></a>
        </li>
        <li class="nav-item top-link @if ($target_step == 2) actived  @else done @endif"><a
                href="{{ route('admin_single_experience_person', ['id' => $id]) }}" 
                class="nav-link">نیرو<br><small>نیروی معرفی شده</small></a></li>
        <li class="nav-item top-link @if ($target_step == 3) actived  @else done @endif"><a
                href="{{ route('admin_experience_reporting', ['id' => $id]) }}" 
                class="nav-link">گزارش<br><small>گزارش کارشناسان</small></a>
        </li>
        <li class="nav-item top-link @if ($target_step == 4) actived  @else done @endif"><a
                href="{{ route('admin_experience_actions', ['id' => $id]) }}" 
                class="nav-link">عملیات گزارش<br><small>عملیات</small></a>
        </li>
    </ul>
</div>

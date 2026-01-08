@php
$address = $Family->get_data('address');
@endphp
@if($address == null )
    آدرس ثبت نشده است!
@else
<li>استان: {{ $address->ProvinceName }}</li>
<li> شهر: {{ $address->ShahrestanName }}</li>
<li> تماس: {{ $address->mgt_phone ?? '' }}</li>
<li> ایمیل: {{ $address->mgt_mail ?? '' }}</li>
<li> آدرس: {{ $address->fulladdress ?? '' }}</li>
@endif
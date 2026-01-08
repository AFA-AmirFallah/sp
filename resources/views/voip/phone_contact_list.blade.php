<div id="phone-contact-list-div">
    @foreach ($contact_list as $contact_item)
        <div class="phone-contact-list">
            <div class="contact-phone">
                {{$contact_item->MobileNo}} -
                {{$contact_item->Name}} {{$contact_item->Family}}
            </div>
            <div class="contact-dial" onclick="call_from_list('{{$contact_item->MobileNo}}')">
                <i style="font-size: 21px" class="i-Telephone"></i>
            </div>
        </div>
    @endforeach
</div>

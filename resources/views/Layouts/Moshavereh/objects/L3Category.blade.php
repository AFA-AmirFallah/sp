<h6 class="IRANSansWeb_Medium bt-color bg-light py-2 px-3 rad25">دسته بندی ها</h6>

<div id="skill" class="p-2">
    <ul>
        @php
            $cat_main = $Consult->get_up_layers_form_l3($L3id, 'L3');
            if ($cat_main == false) {
                $cat_main = [];
            }
        @endphp
        @if ($cat_main == [])
            <p>
                داده ای وجود ندارد

            </p>
        @endif
        @foreach ($cat_main as $catshow)
            <li>
                <a href="{{ route('Reservationlist', ['L3id' => $catshow->UID, 'L3Name' => $catshow->Name]) }}">{{ $catshow->Name }}<span
                        class="badge badge-secondary mr-3  p-2 rad25 float-left text-dark">2</span></a><br />
            </li>
        @endforeach
    </ul>
</div>

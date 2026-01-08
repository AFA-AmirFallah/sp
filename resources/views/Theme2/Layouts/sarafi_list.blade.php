<form id="myForm">
    @foreach ($sarafi_src as $sarafi_item)
        <div class="col-md-6 mb-md-0 mb-2">
            <div class="form-check custom-option custom-option-icon position-relative checked">
                <label class="form-check-label custom-option-content" for="customRadioDelivery1">
                    <span class="custom-option-body">
                        <i class="bx bx-shopping-bag mb-2"></i>
                        <span class="custom-option-title">{{ $sarafi_item->Family }}</span>
                        <span class="badge bg-label-success btn-pinned">دریافت در محل</span>
                        <small>دریافت در محل پس از ۲ ساعت</small>
                        <br>
                        <small>آدرس: {{ $sarafi_item->Address }} </small>
                    </span>
                    <input onclick="set_sarafi('{{ $sarafi_item->UserName }}')"  class="form-check-input" type="radio" value="{{ $sarafi_item->UserName }}"
                        id="customRadioDelivery1">
                </label>
            </div>
        </div>
    @endforeach
</form>

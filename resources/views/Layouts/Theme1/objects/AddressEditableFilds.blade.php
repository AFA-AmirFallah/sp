<div class="form-group">
    <label>نام محل(خانه، شرکت،....)<span style="color: red">*</span></label>
    <input type="text" class="form-control form-control-md" name="LocationName" required>
</div>

</div>

<div class="form-group">
    <label> استان <span style="color: red">*</span></label>
    <div class="select-box">
        <select name="Province" id="Province" onchange="LoadCitys(this.value)" class="form-control form-control-md">
            <option value="0">{{ __('--select--') }}</option>
            @foreach ($Order->get_provices_all() as $ProvincesTarget)
                <option value="{{ $ProvincesTarget->id }}">
                    {{ $ProvincesTarget->ProvinceName }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="row gutter-sm">

    <div class="form-group">
        <label>شهر / بخش <span style="color: red">*</span></label>

        <select id="Shahrestan" name="Saharestan" class="form-control form-control-md">
        </select>
    </div>



    <div class="form-group">
        <label>کد پستی <span style="color: red">*</span></label>
        <input type="text" class="form-control form-control-md" name="PostalCode" required>
    </div>

    <div class="form-group">
        <label>آدرس خیابان <span style="color: red">*</span></label>
        <input type="text" placeholder="شماره خانه و نام خیابان" class="form-control form-control-md mb-2"
            name="Street" required>

    </div>
    <div class="form-group">
        <label> کوچه <span style="color: red">*</span></label>

        <input type="text" placeholder="آپارتمان ، سوئیت ، واحد و غیره (اجباری)" class="form-control form-control-md"
            name="OthersAddress" required>
    </div>
    <div class="form-group">
        <label> نام تحویل گیرنده </label>

        <input type="text" placeholder="نام تحویل گیرنده (اختیاری)" class="form-control form-control-md"
            name="recivername">
    </div>
    <div class="form-group">
        <label> تلفن</label>

        <input type="text" placeholder="تلفن تحویل گیرنده(اختیاری)" class="form-control form-control-md"
            name="reciverphone">
    </div>

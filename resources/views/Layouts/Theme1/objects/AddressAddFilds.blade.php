<div id="InputAddress">

    <div class="form-group">
        <label>عنوان آدرس</label> <span style="color: red">*</span></label>
        <input type="text"  placeholder="مثال: خانه" class="form-control form-control-md" name="LocationName" id="LocationName" required>
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
            <input type="text" class="form-control form-control-md" id="PostalCode"  name="PostalCode" required>
        </div>

        <div class="form-group">
            <label>آدرس پستی  <span style="color: red">*</span></label>
            <input type="text" id="OthersAddress"  class="form-control form-control-md mb-2"
                name="OthersAddress" required>

        </div>

        <div class="form-group">
            <label>  پلاک <span style="color: red">*</span></label>
            <input id="Street" type="text" placeholder="مثال: پلاک ۳، واحد ۴"
                class="form-control form-control-md" name="Street" required>
        </div>
        <div class="form-group">
            <label> نام تحویل گیرنده </label>

            <input type="text" id="recivername" placeholder="نام تحویل گیرنده (اختیاری)" class="form-control form-control-md"
                name="recivername">
        </div>
        <div class="form-group">
            <label> تلفن</label>

            <input type="tel" id="reciverphone" placeholder="تلفن تحویل گیرنده(اختیاری)" class="form-control form-control-md"
                name="reciverphone">
        </div>
        <div class="form-group mt-3">
            <label for="ExtraNote">یادداشت های سفارش (اختیاری)</label>
            <textarea class="form-control mb-0" id="ExtraNote" name="ExtraNote" cols="30" rows="4"
                placeholder="یادداشت هایی در مورد سفارش شما ، به عنوان مثال یادداشت های ویژه برای تحویل"></textarea>
        </div>
    </div>
</div>

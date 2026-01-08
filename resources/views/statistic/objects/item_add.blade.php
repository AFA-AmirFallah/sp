    <h3 class="card-title">افزودن / ویرایش فیلد</h3>
    <form method="POST">
        @csrf
        <input type="text" id="item_id" class="d-none" name="item_id" value="">
        <div class="form-row">
            <div class="form-group col-md-6">

                <label for="inputEmail1" class="ul-form__label">نام

                </label>
                <input type="text" class="form-control" required id="item_name" name="item_name" placeholder="نام"
                    value="">
            </div>
            <div class="form-group col-md-6">

                <label for="inputEmail1" class="ul-form__label">رشته شاخص

                </label>
                <input type="text" class="form-control" required id="item_index_str" name="item_index_str"
                    placeholder="رشته ساخص" value="">
                <small>["text1","text2"]</small>
            </div>

        </div>
        <div class="form-row">

            <button type="submit" id="add_item" class="btn btn-primary m-1" name="submit" value="add_item">ثبت
                فیلد</button>
            <div id="edit-zone" class="d-none">
                <button type="submit" class="btn btn-primary m-1" name="submit" value="edit_item">ویرایش فیلد</button>
                <a href="javascript:cancel_edit()" class="btn btn-warning m-1" name="submit"
                    value="cancel_edit_item">بی خیال</a>
            </div>
        </div>
    </form>

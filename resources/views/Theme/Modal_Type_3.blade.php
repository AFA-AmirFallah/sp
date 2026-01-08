<div class="ul-card-list__modal">
    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog"
         aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <form method="post">
                        @csrf
                        <div class="form-group row">
                            <input style="visibility:hidden" id="tableID" name="tableid">
                        </div>
                        <div class="form-group row">
                            <label for="inputName"
                                   class="col-sm-2 col-form-label">ترتیب</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="number" id="modal_order"
                                       name="order" required
                                       placeholder="ترتیب(کیبورد در حالت انگلیسی باشد)">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputName"
                                   class="col-sm-2 col-form-label">صفحه</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="number" id="modal_page"
                                       name="Page" required
                                       placeholder="صفحه (کیبورد در حالت انگلیسی باشد)">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputName"
                                   class="col-sm-2 col-form-label">لینک به آدرس</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" id="modal_link" name="link" required value="#"
                                       placeholder="آدرس">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="inputName"
                                   class="col-sm-2 col-form-label">تایتل</label>
                            <div class="col-sm-10">
                                <input class="form-control" id="modal_title" required name="title"
                                       placeholder="تایتل">
                            </div>
                        </div>
                        <div class="input-group">
<span class="input-group-btn">
<a id="lfm" data-input="modal_pic" data-preview="holder" class="btn btn-primary text-white">
<i class="fa fa-picture-o"></i> انتخاب تصویر
</a>
</span>
                            <input id="modal_pic" class="form-control" type="text" required name="pic"
                                   value="">
                        </div>
                        <fieldset class="form-group">
                            <div class="row">
                                <div class="col-form-label col-sm-2 pt-0">وضعیت</div>
                                <div class="col-sm-10">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio"
                                               id="modal_active"
                                               name="staus" id="gridRadios1" value="1"
                                               checked="">
                                        <label class="form-check-label ml-3" for="gridRadios1">
                                            فعال
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio"
                                               id="modal_deactive"
                                               name="staus" id="gridRadios2" value="0">
                                        <label class="form-check-label ml-3" for="gridRadios2">
                                            غیر فعال
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <div class="form-group row">
                            <div class="col-sm-10">
                                <button id="addelement" type="submit" name="submit" value="add"
                                        class="btn btn-success">افزودن
                                </button>
                                <button id="editeelement" type="submit" name="submit" value="edit"
                                        class="btn btn-success">به روز رسانی
                                </button>
                                <button id="DeleteElement" type="submit" name="submit" value="delete"
                                        class="btn btn-danger">حذف
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Modal -->
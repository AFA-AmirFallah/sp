<div class="ul-card-list__modal">
    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <form method="post">
                        @csrf
                        <div class="form-group row">
                            <input style="visibility:hidden" id="tableID" name="tableid">
                        </div>
                        <div class="form-group row">
                            <label for="inputName" class="col-sm-2 col-form-label">ترتیب</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="number" id="modal_order" name="order" required
                                    placeholder="ترتیب(کیبورد در حالت انگلیسی باشد)">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputName" class="col-sm-2 col-form-label">صفحه</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="number" id="modal_page" name="Page" required
                                    placeholder="صفحه (کیبورد در حالت انگلیسی باشد)">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputName" class="col-sm-2 col-form-label">تایتل</label>
                            <div class="col-sm-10">
                                <input class="form-control" id="modal_title" required name="title"
                                    placeholder="تایتل">
                            </div>
                        </div>
                        <div class="input-group">

                            <label for="inputName" class="col-sm-2 col-form-label">کد شاخص
                            </label>

                                <input class="form-control" id="modal_TagUID_1" required name="TagUID1"
                                    placeholder="کد شاخص">


                            <label for="inputName" class="col-sm-2 col-form-label"> تیتر نمایش
                            </label>

                                <input class="form-control" id="modal_title_1" required name="title1"
                                    placeholder="متن نمایش">

                            <label for="inputName" class="col-sm-2 col-form-label"> تعداد نمایش
                            </label>
                                <input type="number" class="form-control" id="modal_Limit_1" required name="Limit1"
                                    value="">

                        </div>




                        <div class="input-group">

                            <label for="inputName" class="col-sm-2 col-form-label">کد شاخص
                            </label>

                                <input class="form-control" id="modal_TagUID_2" required name="TagUID2"
                                    placeholder="کد شاخص">


                            <label for="inputName" class="col-sm-2 col-form-label"> تیتر نمایش
                            </label>

                                <input class="form-control" id="modal_title_2" required name="title2"
                                    placeholder="متن نمایش">

                            <label for="inputName" class="col-sm-2 col-form-label"> تعداد نمایش
                            </label>
                                <input type="number" class="form-control" id="modal_Limit_2" required name="Limit2"
                                    value="">
                        </div>
                        <div class="input-group">

                            <label for="inputName" class="col-sm-2 col-form-label">کد شاخص
                            </label>

                                <input class="form-control" id="modal_TagUID_3" required name="TagUID3"
                                    placeholder="کد شاخص">


                            <label for="inputName" class="col-sm-2 col-form-label"> تیتر نمایش
                            </label>

                                <input class="form-control" id="modal_title_3" required name="title3"
                                    placeholder="متن نمایش">

                            <label for="inputName" class="col-sm-2 col-form-label"> تعداد نمایش
                            </label>
                                <input type="number" class="form-control" id="modal_Limit_3" required name="Limit3"
                                    value="">
                        </div>
                        <div class="input-group">

                            <label for="inputName" class="col-sm-2 col-form-label">کد شاخص
                            </label>

                                <input class="form-control" id="modal_TagUID_4" required name="TagUID4"
                                    placeholder="کد شاخص">


                            <label for="inputName" class="col-sm-2 col-form-label"> تیتر نمایش
                            </label>

                                <input class="form-control" id="modal_title_4" required name="title4"
                                    placeholder="متن نمایش">

                            <label for="inputName" class="col-sm-2 col-form-label"> تعداد نمایش
                            </label>
                                <input type="number" class="form-control" id="modal_Limit_4" required name="Limit4"
                                    value="">
                        </div>
                        <fieldset class="form-group">
                            <div class="row">
                                <div class="col-form-label col-sm-2 pt-0">وضعیت</div>
                                <div class="col-sm-10">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" id="modal_active"
                                            name="staus" id="gridRadios1" value="1" checked="">
                                        <label class="form-check-label ml-3" for="gridRadios1">
                                            فعال
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" id="modal_deactive"
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

<script>
    function EditModal($selectID) {
        $('#addelement').hide();
        $('#editeelement').show();
        $('#DeleteElement').show();
        $('#modal_order').val($('#order_' + $selectID).attr('name'));
        $('#modal_theme').val($('#theme_' + $selectID).attr('name'));
        $('#modal_page').val($('#page_' + $selectID).attr('name'));
        $('#modal_title').val($('#title_' + $selectID).attr('name'));
        $('#modal_link').val($('#link_' + $selectID).attr('name'));
        $('#BoxName').val($('#BoxName_' + $selectID).attr('name'));
        $('#modal_pic_1').val($('#pic1_' + $selectID).val());
        $('#modal_link_1').val($('#link1_' + $selectID).val());
        $('#modal_pic_2').val($('#pic2_' + $selectID).val());
        $('#modal_link_2').val($('#link2_' + $selectID).val());
        $('#modal_pic_3').val($('#pic3_' + $selectID).val());
        $('#modal_link_3').val($('#link3_' + $selectID).val());
        $('#modal_pic_4').val($('#pic4_' + $selectID).val());
        $('#modal_link_4').val($('#link4_' + $selectID).val());
        document.getElementById("tableID").value = $selectID;
        var $status = $('#status_' + $selectID).attr('name');
        if ($status == '1') {
            $('#modal_active').prop('checked', true);
            $('#modal_deactive').prop('checked', false);
        } else {
            $('#modal_active').prop('checked', false);
            $('#modal_deactive').prop('checked', true);
        }



    }
</script>

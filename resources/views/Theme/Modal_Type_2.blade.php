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
                                                <label for="inputName" class="col-sm-2 col-form-label">ترتیب</label>
                                                <div class="col-sm-10">
                                                    <input class="form-control" type="number" id="modal_order"
                                                        name="order" required
                                                        placeholder="ترتیب(کیبورد در حالت انگلیسی باشد)">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="inputName" class="col-sm-2 col-form-label">صفحه</label>
                                                <div class="col-sm-10">
                                                    <input class="form-control" type="number" id="modal_page"
                                                        name="Page" required
                                                        placeholder="صفحه (کیبورد در حالت انگلیسی باشد)">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="inputName" class="col-sm-2 col-form-label">تصویر</label>
                                                <div class="col-sm-10">
                                                    <input id="modal_pic_2" class="form-control" type="text" required
                                                        name="pic2" value="">
                                                    <a id="lfm_2" data-input="modal_pic_2" data-preview="holder"
                                                        class="btn btn-primary text-white">
                                                        <i class="fa fa-picture-o"></i> تصویر
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="inputName" class="col-sm-2 col-form-label">کد شاخص
                                                </label>
                                                <div class="col-sm-10">
                                                    <input class="form-control" id="modal_TagUID" required
                                                        name="TagUID" placeholder="کد شاخص">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="inputName" class="col-sm-2 col-form-label"> تیتر نمایش
                                                </label>
                                                <div class="col-sm-10">
                                                    <input class="form-control" id="modal_title" required name="title"
                                                        placeholder="متن نمایش">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="inputName" class="col-sm-2 col-form-label"> تعداد نمایش
                                                </label>
                                                <div class="col-sm-10">
                                                    <input type="number" class="form-control" id="modal_Limit" required
                                                        name="Limit" value="">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="inputName" class="col-sm-2 col-form-label"> رنگ پس زمینه
                                                </label>
                                                <div class="col-sm-10">
                                                    <input type="color" id="modal_Backcolor" name="Backcolor"
                                                        value="#ff0000">
                                                </div>
                                            </div>
                                            <fieldset class="form-group">
                                                <div class="row">
                                                    <div class="col-form-label col-sm-2 pt-0">وضعیت</div>
                                                    <div class="col-sm-10">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio"
                                                                id="modal_active" name="staus" id="gridRadios1"
                                                                value="1" checked="">
                                                            <label class="form-check-label ml-3" for="gridRadios1">
                                                                فعال
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio"
                                                                id="modal_deactive" name="staus" id="gridRadios2"
                                                                value="0">
                                                            <label class="form-check-label ml-3" for="gridRadios2">
                                                                غیر فعال
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </fieldset>
                                            <div class="form-group row">
                                                <div class="col-sm-10">
                                                    <button id="addelement" type="submit" name="submit"
                                                        value="add" class="btn btn-success">افزودن
                                                    </button>
                                                    <button id="editeelement" type="submit" name="submit"
                                                        value="edit" class="btn btn-success">به روز رسانی
                                                    </button>
                                                    <button id="DeleteElement" type="submit" name="submit"
                                                        value="delete" class="btn btn-danger">حذف
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
                            $('#modal_pic').val($('#pic_' + $selectID).attr('name'));
                            $('#modal_page').val($('#page_' + $selectID).attr('name'));
                            $('#modal_TagUID').val($('#TagUID_' + $selectID).val());
                            $('#modal_Limit').val($('#Limit_' + $selectID).val());
                            $('#modal_title').val($('#title_' + $selectID).attr('name'));
                            $('#modal_link').val($('#link_' + $selectID).attr('name'));
                            $('#BoxName').val($('#BoxName_' + $selectID).attr('name'));
                            $('#modal_pic_2').val($('#pic2_' + $selectID).val());
                            $('#modal_Backcolor').val($('#Backcolor_' + $selectID).val());
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

                        function addmodal() {
                            $('#addelement').show();
                            $('#editeelement').hide();
                            $('#DeleteElement').hide();
                            $('#modal_order').val(null);
                            $('#modal_theme').val(null);
                            $('#modal_pic').val(null);
                            $('#modal_title').val(null);
                        }
                    </script>

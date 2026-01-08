<div class="form-group col-md-6">
    <label for="inputEmail4" class="ul-form__label"> جستجوی کالا :</label>
    <div style="text-align: center" class="ul-card-list__modal">
        <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div id="product-list-suggesstion-box" class="modal-body">

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="user-search-aria" class="input-group col-xl-8 col-md-7">
        <input type="text" class="form-control" id="product_search_text" 
            placeholder="جستجوی محصول">
        <div class="input-group-append">
            <button id="search_user_btn_submit" class="add btn btn-success" type="button" data-toggle="modal"
                onclick="Search_Product()" data-target=".bd-example-modal-lg">جستجو</button>
        </div>
    </div>
    <div id="user-show-aria" class="input-group col-xl-8 col-md-7 nested">
        <div id="name_of_target_user" class="tag"></div>
    </div>

    <small class="ul-form__text form-text ">
        نام کالا یا بارکد کالا را جستجو کنید.
    </small>
</div>
<div id="product_table_detial" ></div>
<script>
    loadpage('BasketList','product_table_detial');
</script>
<script>
    var input = document.getElementById("user-search-aria");
    input.addEventListener("keypress", function(event) {
      if (event.key === "Enter") {
        event.preventDefault();
        document.getElementById("search_user_btn_submit").click();
      }
    });
    </script>



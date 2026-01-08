<div id="notsetlocation" class="d-none delever_mode">
    <h4 style="text-align: right;font-size:16px;">حمل و نقل بر اساس محل تحویل</h4>
</div>
<div class="d-none delever_mode" id="tehran_location">
    <div class="custom-control custom-radio pl-0 pr-3">
        <input type="radio" class="custom-control-input ct" name="radio1" id="radio1" onchange="TapinGetPrice()"
            value="option1">
        <label for="radio1" class="custom-control-label">
            پست
        </label>
    </div>
    <div class="custom-control custom-radio  pl-0 pr-3">
        <input type="radio" class="custom-control-input ct"  name="radio1" id="radio2" onchange="inhouse_delever()"
            value="option2">
        <label style="color: red" for="radio2" class="custom-control-label">
            تحویل حضوری
        </label>
    </div>
    <div class="custom-control custom-radio  pl-0 pr-3">
        <input type="radio" class="custom-control-input ct" name="radio1" id="radio3" onchange="peyk_delever()"
            value="option3">
        <label style="color: red" for="radio3" class="custom-control-label">
            ارسال با پیک
            <small class="text-danger">
                ( هزینه ارسال توسط مشتری در زمان تحویل کالا به پیک پرداخت می شود)
            </small>
        </label>
    </div>
</div>

<div class="d-none delever_mode" id="shahrestan_location">
    <div class="custom-control custom-radio pl-0 pr-3">
        <input type="radio" class="custom-control-input ct" name="radio1" id="radio5" onchange="TapinGetPrice()"
            value="option1">
        <label for="radio5" class="custom-control-label">
            پست
        </label>
    </div>
    <div class="custom-control custom-radio pl-0 pr-3">
        <input type="radio" class="custom-control-input ct" name="radio1" id="radio6" onchange="tipax_delever()"
            value="option4">
        <label for="radio6" class="custom-control-label">
            تیپاکس <small class="text-danger">
                ( هزینه ارسال توسط مشتری در زمان تحویل کالا به تیپاکس پرداخت می شود)
            </small>
        </label>
    </div>
</div>

<script>
    selected_address = $('#Locations').val();
    set_location_address(selected_address);

    function set_location_address(address_id) {
        $(".ct option[value='X']").each(function() {
            $(this).remove();
        });
        $('.delever_mode').addClass('d-none');
        if (address_id == 0) {
            $('#notsetlocation').removeClass('d-none');
        } else {
            $city = $('#city_' + address_id).val();
            if ($city == '1') {
                $('#tehran_location').removeClass('d-none');
            } else {
                $('#shahrestan_location').removeClass('d-none');
            }

        }

    }
</script>

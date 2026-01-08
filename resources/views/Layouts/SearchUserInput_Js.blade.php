<script>
    $('.select-target-user-to-show').on('click', function() {
        alert('hi');
        //var $selectID = $(this).attr('id');
        //$('#user_search_responser_text').val($selectID);
        //$('#modal_metadevicename').val($('#DeviceName_' + $selectID).attr('name'));
    });
</script>
<script>
    function fff(username, NameFamily) {
        $('#user_search_responser_text').val(username);
        $('#name_of_target_user').html(NameFamily +
            '<input type="hidden" name="tag[]" value="preexisting-tag"><a role="button" onclick="changestatetosearcharia()" class="tag-i">×</a>'
        );
        $('#user-search-aria').addClass('nested');
        $('#user-show-aria').removeClass('nested');
        $('.modal').modal("hide");
        $("#user-list-suggesstion-box").html('');
    }

    function changestatetosearcharia() {
        $('#user_search_responser_text').val('');
        $('#name_of_target_user').html('');
        $('#user-search-aria').removeClass('nested');
        $('#user-show-aria').addClass('nested');
    }
</script>
<script>
    function loaduserssearch_advance() {
        var $loader = ' <div style="text-align: center" class="loader-bubble loader-bubble-primary m-5"></div>';
        $("#user-list-suggesstion-box").html($loader);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.post('{{ route('ajax') }}', {
                AjaxType: 'WorkerSearch_advance',
                InputString: $("#user_search_responser_text_advance").val(),
                SelectService: $("#SelectService").val(),
            },
            function(data, status) {
                if (data != 'nok') {
                    Myhtml =
                        '<table id="modal-user-select-table"><table class="table"><thead><tr><th>{{ __('Name and family') }}</th><th>شماره همراه</th><th>نقش کاربر</th><th>{{ __('Actions') }}</th></thead><tbody>' +
                        data + '</tbody></table>';
                    $("#user-list-suggesstion-box").html(Myhtml);
                } else {
                    $("#user-list-suggesstion-box").html('جستجوی بدون نتیجه!');
                }
            });

    }

    function loaduserssearch() {
        // alert($("#user_search_responser_text").val().length);
        var $loader = ' <div style="text-align: center" class="loader-bubble loader-bubble-primary m-5"></div>';
        $("#user-list-suggesstion-box").html($loader);
        if ($("#user_search_responser_text").val().length > 2) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('{{ route('ajax') }}', {
                    AjaxType: 'WorkerSearch',
                    InputString: $("#user_search_responser_text").val(),
                },
                function(data, status) {
                    if (data != 'nok') {
                        Myhtml =
                            '<table id="modal-user-select-table"><table class="table"><thead><tr><th>{{ __('Name and family') }}</th><th>شماره همراه</th><th>نقش کاربر</th><th>{{ __('Actions') }}</th></thead><tbody>' +
                            data + '</tbody></table>';
                        $("#user-list-suggesstion-box").html(Myhtml);
                    } else {
                        $("#user-list-suggesstion-box").html('جستجوی بدون نتیجه!');
                    }
                });

        } else {
            $("#user-list-suggesstion-box").html('متن جستجو می باید بیشتر از ۲ کارکتر باشد');
        }
    }
</script>

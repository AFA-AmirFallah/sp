@if(\App\myappenv::MainOwner == 'sepehrmall')
<style>
    .search-result div {
        border: 1px solid #ced4da;
        padding-right: 10px;
        border-bottom-left-radius: 5px;
        border-bottom-right-radius: 5px;
    }

    .search-result a {
        display: block;
        color: black;

    }

    .close-button {
        float: left;
        margin-top: -27px;
        border: none;
        background-color: #f8f8ff00;
    }

    .form-style {
        width: 100%;
    }

    .form-control {
        border: initial;
        outline: initial !important;
        background: #e5e5e5;
        border: 1px solid #e5e5e5;
        color: #47404f;
        height: 40px;
    }

</style>
@else
<style>
    .search-result div {
        border: 1px solid #ced4da;
        padding-right: 10px;
        border-bottom-left-radius: 5px;
        border-bottom-right-radius: 5px;
    }

    .search-result a {
        display: block;
        color: black;
    }

    .close-button {
        float: left;
        margin-top: -27px;
        border: none;
        background-color: #f8f8ff00;
    }

    .form-style {
        width: 100%;
    }

    .form-control {
        border: initial;
        outline: initial !important;
        background: #4ccf9b1c;
        border: 1px solid #4dd099;
        color: #47404f;
        height: 40px;
    }

</style>
@endif
<p class="nested" style="margin-bottom: 2px">جستجو:</p>
<form style="margin-bottom: 20px" method="GET" action="{{ route('search') }}" class="form-style">

    <input onkeyup="SearchResult()" type="text" class="searchBox_main form-control" id="searchBox" name="q"
        placeholder="جستجوی برند یا محصول" autocomplete="off" value="@if (isset($q)){{ $q }}@endif">
    <button id="closebtn" onclick="removesearch()" type="button" class="close-button @if (!isset($q))nested @endif">X</button>
    <div id="search-box" class="nested search-result">
        <div id="Serch_Result">

        </div>
    </div>
</form>
<script>
    function removesearch() {
        $('#closebtn').addClass('nested');
        $('#search-box').addClass('nested');
        $('#searchBox').val('');
        $('#Serch_Result').html('');

    }

    function SearchResult() {
        $SearchText = $('#searchBox').val();
        if ($SearchText.length == 0) {
            $('#closebtn').addClass('nested');
        } else {
            $('#closebtn').removeClass('nested');
        }
        if ($SearchText.length > 3) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('<?php echo e(route('ajax')); ?>', {
                    AjaxType: 'SearchProduct',
                    SearchText: $SearchText,
                },

                function(data, status) {
                    $('#Serch_Result').html(data);
                    $('#search-box').removeClass('nested');
                });

        } else {
            $('#Serch_Result').html('');
            $('#search-box').addClass('nested');
        }
    }
</script>

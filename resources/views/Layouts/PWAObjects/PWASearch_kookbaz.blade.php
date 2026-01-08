
<p class="nested" style="margin-bottom: 2px">جستجو:</p>
<form style="margin-bottom: 20px" method="GET" action="{{ route('search') }}" class="form-style">
    <div id="search_icon_active" onclick="search_Click(1)" class="nested top-search-continer">
        <svg width="18" height="16" viewBox="0 0 18 16" fill="none">
            <path
                d="M15.7364 2.32233C14.2767 1.08547 12.336 0.404297 10.2717 0.404297C8.20747 0.404297 6.26674 1.08547 4.80709 2.32233C3.34744 3.55916 2.54352 5.20364 2.54352 6.95276C2.54352 8.55196 3.21585 10.0634 4.4466 11.2561L0.154617 14.8929C-0.0515391 15.0676 -0.0515391 15.3508 0.154617 15.5255C0.257695 15.6129 0.392801 15.6566 0.527871 15.6566C0.662941 15.6566 0.798082 15.6129 0.901125 15.5255L5.19314 11.8887C6.60069 12.9316 8.38445 13.5013 10.2717 13.5013C12.336 13.5013 14.2767 12.8201 15.7364 11.5833C17.196 10.3464 17.9999 8.70195 17.9999 6.95279C17.9999 5.20364 17.1961 3.55916 15.7364 2.32233ZM14.9899 10.9507C12.3883 13.1551 8.15526 13.1551 5.55367 10.9507C2.9521 8.74624 2.9521 5.15937 5.55367 2.95494C6.85459 1.85261 8.5629 1.30162 10.2718 1.30162C11.9802 1.30162 13.6892 1.85287 14.9899 2.95494C17.5914 5.15934 17.5914 8.74621 14.9899 10.9507Z"
                fill="#29A0A8"></path>
        </svg>
    </div>
    <input  onkeyup="SearchResult()" id="search_input" class="search_input nested" name="q" placeholder="جستجو.."
        autocomplete="off" value="@if (isset($q)){{ $q }}@endif">


    <button id="closebtn" onclick="removesearch()" type="button" class="close-button @if (!isset($q))nested @endif"><svg style="margin-right: -4px;" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M8.96484 0C13.9082 0 18 4.02152 18 8.96484C18 13.9082 13.9082 18 8.96484 18C4.02152 18 0 13.9082 0 8.96484C0 4.02152 4.02152 0 8.96484 0ZM4.52742 11.9106C4.11609 12.3219 4.11609 12.9909 4.52742 13.4026C4.93559 13.8104 5.60461 13.8171 6.01945 13.4026L8.96484 10.4562L11.9809 13.403C12.3922 13.8143 13.0613 13.8143 13.4729 13.403C13.8843 12.9916 13.8843 12.3226 13.4729 11.9109L10.5268 8.96484L13.4729 6.01875C13.8843 5.60707 13.8843 4.93805 13.4729 4.52672C13.0613 4.11539 12.3922 4.11539 11.9809 4.52672L8.96484 7.47352L6.01945 4.52672C5.60883 4.11609 4.93981 4.11469 4.52742 4.52672C4.11609 4.93805 4.11609 5.60707 4.52742 6.01875L7.47351 8.96484L4.52742 11.9106Z" fill="#A6A4A4"/>
        </svg></button>
    <div id="search-box" class="nested search-result">
        <div id="Serch_Result">

        </div>
    </div>
</form>
<script>
    function removesearch() {
        $('#closebtn').addClass('nested');
        $('#search-box').addClass('nested');
        $('#search_input').val('');
        $('#Serch_Result').html('');

    }

    function SearchResult() {
        $SearchText = $('#search_input').val();
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

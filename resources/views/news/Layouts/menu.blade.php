<div class="main-nav clearfix">
    <div class="container">
        <div class="row">
            {!! $DataSource->mainmenu() !!}
            <div class="nav-search">
                <span id="search"><i class="fa fa-search"></i></span>
            </div><!-- Search end -->
            <input style="display: none" id='searchpagesrc' value="{{ route('newscat',['newscat'=>'search-']) }}">
            <div class="search-block" style="display: none;">
                <input id="search_input"  onclick="searchiput()"
                    style="margin-top: -47px;hight:24px;margin-right:-6px;padding-right:26px;    font-weight: bolder;"
                    value="جستجو" type="text" class="form-control">
                <span onclick="cancelsearchiput()" class="search-close">× </span>
                <span style="    margin-left: 339px;
                margin-top: -1px;
                font-size: 17px;" class="search-close"><i class='fa fa-search'></i></span>
            </div><!-- Site search end -->

        </div>
        <!--/ Row end -->
    </div>
    <!--/ Container end -->

</div><!-- Menu wrapper end -->
<script>
    function searchiput() {
        $("#search_input").val('');
    }

    function cancelsearchiput() {
        $("#search_input").val('جستجو');
    }

</script>

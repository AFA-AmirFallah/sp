<div style="text-align: center" class="ul-card-list__modal">
    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div id="user-list-suggesstion-box" class="modal-body">

                </div>
            </div>
        </div>
    </div>
</div>
@if (isset($SmartSearch) && $SmartSearch)
    <div id="user-search-aria" style="display: contents">
        <div class="input-group col-xl-4 col-md-3">
            <input type="text" class="form-control" id="user_search_responser_text" name="{{ $InputName }}"
                placeholder="{{ $InputPalceholder }}">
            <div class="input-group-append">
                <button id="search_user_btn_submit" class="add btn btn-success" type="button" data-toggle="modal"
                    onclick="loaduserssearch()" data-target=".bd-example-modal-lg">{{ __('Search') }}</button>
            </div>
        </div>
        <div class="input-group col-xl-4 col-md-3">
            <input type="text" class="form-control" id="user_search_responser_text_advance"
                name="{{ $InputName }}_i" placeholder="{{ $InputPalceholder }}">
            <div class="input-group-append">
                <button id="search_user_btn_submit" class="add btn btn-success" type="button" data-toggle="modal"
                    onclick="loaduserssearch_advance()" data-target=".bd-example-modal-lg">جستجوی هوشمند</button>
            </div>
        </div>
    </div>
    <div id="user-show-aria" class="input-group col-xl-8 col-md-7 nested">
        <div id="name_of_target_user" class="tag"></div>
    </div>
    <script>
        var input = document.getElementById("user_search_responser_text");
        input.addEventListener("keypress", function(event) {
            if (event.key === "Enter") {
                event.preventDefault();
                document.getElementById("search_user_btn_submit").click();

            }
        });
    </script>
@else
    @isset($username)
        @php
            $user_src = \App\Users\UserClass::get_user_by_username($username);
        @endphp

        <div id="user-search-aria" class="input-group col-xl-8 col-md-7 nested">
            <input type="text" class="form-control" id="user_search_responser_text" name="{{ $InputName }}"
                value="{{ $username }}" placeholder="{{ $InputPalceholder }}">
            <div class="input-group-append">
                <button id="search_user_btn_submit" class="add btn btn-success" type="button" data-toggle="modal"
                    onclick="loaduserssearch()" data-target=".bd-example-modal-lg">{{ __('Search') }}</button>
            </div>
        </div>
        <div id="user-show-aria" class="input-group col-xl-8 col-md-7 ">
            <div id="name_of_target_user" class="tag">{{ $user_src->Name }} {{ $user_src->Family }}<input type="hidden"
                    name="tag[]" value="preexisting-tag"><a role="button" onclick="changestatetosearcharia()"
                    class="tag-i">×</a>

            </div>
        </div>
    @else
        <form method="post">
            @csrf
            <div id="user-search-aria" class="input-group col-xl-8 col-md-7">
                <input type="text" class="form-control" id="user_search_responser_text" name="{{ $InputName }}"
                    placeholder="{{ $InputPalceholder }}">
                <div class="input-group-append">
                    <button id="search_user_btn_submit" class="add btn btn-success" type="button" data-toggle="modal"
                        onclick="loaduserssearch()" data-target=".bd-example-modal-lg">{{ __('Search') }}</button>
                </div>
            </div>
            <div id="user-show-aria" style="display: contents;" class="input-group col-xl-8 col-md-7 nested">
                <div id="name_of_target_user" class="tag"></div>
                @if (isset($type) && $type == 'call_center')
                    <button type="submit" name="add_perosn" value="1" class="btn btn-success">ثبت کاربر</button>
                    <button type="submit" name="add_perosn" value="100" class="btn btn-warning">ثبت مدیر</button>
                @endif

            </div>
        </form>
    @endisset
    <script>
        var input = document.getElementById("user_search_responser_text");
        input.addEventListener("keypress", function(event) {
            if (event.key === "Enter") {
                event.preventDefault();
                document.getElementById("search_user_btn_submit").click();

            }
        });
    </script>
@endif

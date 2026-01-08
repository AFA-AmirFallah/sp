@if (Route::currentRouteName() == 'phone')
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>platform Dialer</title>
        <link rel="stylesheet" href="/assets/styles/css/themes/rtl.min.css">
        <link rel="stylesheet" href="/assets/styles/css/themes/shafatel.min.css">
        <link rel="stylesheet" href="{{ asset('storage/dashboard_assets/main-dashboard.css') }}">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/js/all.min.js"></script>
        <link rel="shortcut icon" href="{{ url('/') . \App\myappenv::FavIcon }}" type="image/x-icon">

    </head>

    <body class="phone_body">
@endif
<div id="Contacts_dev" class="iphone-dialer nested">
    <div class="contact-search">
        <input class="form-control phone_search" id="contact_search" placeholder="search"
            onkeyup="new_contacts_search()" type="text">
    </div>
    <div id="contact_list" class="contacts-display">

    </div>

    <div class="row bottom-nav">
        <div onclick="load_keypad('contacts','','#Contacts')" class="col main-items ">
            Keypad
        </div>
        <div class="col main-items">
            Recent
        </div>
        <div id="Contacts" class="col main-items active-btn">
            Contacts
        </div>
    </div>

</div>
<div id="recent_dev" class="iphone-dialer nested">
    <div class="contact-search">

    </div>
    <div id="recent_list" class="contacts-display">

    </div>

    <div class="row bottom-nav">
        <div onclick="load_keypad('contacts','','#Contacts')" class="col main-items ">
            Keypad
        </div>
        <div class="col main-items active-btn">
            Recent
        </div>
        <div id="Contacts" onclick="load_list('contacts','','#Contacts')" class="col main-items ">
            Contacts
        </div>
    </div>

</div>
<div id="keypad_dev" class="iphone-dialer">
    <div id='keypad'>
        @include('voip/keypad')
    </div>

    <div class="row bottom-nav">
        <div class="col active-btn">
            Keypad
        </div>
        <div onclick="load_recent()" class="col">
            Recent
        </div>
        <div onclick="load_list('contacts','','#Contacts')" class="col">
            Contacts
        </div>
    </div>

</div>
@if (Route::currentRouteName() == 'phone')
    <script src="/assets/js/common-bundle-script.js"></script>
    <script src="/assets/js/script.js"></script>
    <script src="{{ asset('assets/js/sidebar.large.script.js') }}"></script>
    <script src="{{ asset('assets/js/customizer.script.js') }}"></script>
    <script src="{{ asset('assets/js/num2persian.js') }}"></script>
    <script src="{{ url('/') }}/assets/js/select2.min.js"></script>
    <script src="{{ url('/') }}/assets/js/jquery-confirm.js"></script>
    <script src="{{ url('/') }}/storage/dashboard_assets/main-dashboard.js"></script>

    </body>

    </html>
@endif

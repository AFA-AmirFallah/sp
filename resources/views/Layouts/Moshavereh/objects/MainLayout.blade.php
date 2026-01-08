<!DOCTYPE html>
<html>

<head>
    @hasSection('MainTitle')
        <title>@yield('MainTitle')</title>
    @else
        <title>{{ \App\myappenv::CenterName }}</title>
    @endif
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="content-language" content="fa" />
    <meta name="document-type" content="Public" />
    <meta name="document-rating" content="General" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="author" content="{{ \App\myappenv::SystemOwner }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="/Mosahvereh/Css/main.min.css" rel="stylesheet"/>
    <script src="/Mosahvereh/Js/main.min.js"></script>
    <meta name="keywords" content="" />
    <meta name="description" content="{{ \App\myappenv::description }}">
    <meta name="author" content="{{ \App\myappenv::SystemOwner }}">
    <link rel="icon" type="image/png" href="{{ url('/') . \App\myappenv::FavIcon }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/js/all.min.js"></script>
</head>

<body id="home">

    @include('Layouts.Moshavereh.objects.Header')


    @include('Layouts.Moshavereh.objects.ErrorHanderler')
    @yield('content')

    @include('Layouts.Moshavereh.objects.Footer')

    @yield('script')



</body>

</html>

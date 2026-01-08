<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
          content="سامانه جامع زنجیره تامین کالا و خدمات سلامت شفاتل">
    <meta name="keywords"
          content="شفاتل, زنجیره تامین سلامت, سامانه جامع زنجیره تامین سلامت, shafatel, shafatel healthchain, health app">
    <meta name="author" content="dgkar.com">
    <link rel="icon" href="{{url('/')}}/assets/images/favicon/favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="{{url('/')}}/assets/images/favicon/favicon.ico" type="image/x-icon">
    <title>{{App\Myappenv::CenterName}}</title>
    <!-- Font Awesome-->
    <link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/css/font-awesome.css">
    <!-- Flag icon-->
    <link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/css/flag-icon.css">
    <!-- Chartist css -->
    <link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/css/chartist.css">
    <!-- vector map css -->
    <link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/css/vector-map.css">
    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/css/bootstrap.css">
    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/css/admin.css">
    <!-- Datatables css-->
    <link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/css/datatables.css">
    <link rel="stylesheet" href="{{url('/')}}/persian-datepicker/Mh1PersianDatePicker.css"/>
    <link href="{{url('/')}}/assets/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{url('/')}}/assets/css/jquery-confirm.css">
    <link rel="canonical" href="{{ url()->current() }}">

    @yield('Header')
</head>
<body class="rtl">
<div class='loadscreen' id="preloader">
    <div class="loader spinner-bubble spinner-bubble-primary">
    </div>
</div>
<!-- page-wrapper Start-->
<div class="page-wrapper">

    <!-- Page Header Start-->
@include('Layouts.NaveTop')
<!-- Page Header Ends -->

    <!-- Page Body Start-->
    <div class="page-body-wrapper">

        <!-- Page Sidebar Start-->
    @include("Layouts.NaveSide.NaveSide")
    <!-- Page Sidebar Ends-->
        <div class="page-body">
            <!-- Container-fluid starts-->
            <div class="container-fluid">
                <div class="page-header">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="page-header-left">
                                @yield('page-header-left')
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            @include("Layouts.ErrorHandler")
            @yield('MainCountent')

        </div>

        <!-- footer start-->
        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6"></div>
                    <div class="col-md-6 footer-copyright">
                        <p class="mb-0">Copyright © 2021 DGKAR</p>
                    </div>
                </div>
            </div>
        </footer>
        <!-- footer end-->
    </div>

</div>

<!-- latest jquery-->
<script src="{{url('/')}}/assets/js/jquery-3.3.1.min.js"></script>

<!-- Bootstrap js-->
<script src="{{url('/')}}/assets/js/popper.min.js"></script>
<script src="{{url('/')}}/assets/js/bootstrap.js"></script>

<!-- feather icon js-->
<script src="{{url('/')}}/assets/js/icons/feather-icon/feather.min.js"></script>
<script src="{{url('/')}}/assets/js/icons/feather-icon/feather-icon.js"></script>

<!-- Sidebar jquery-->
<script src="{{url('/')}}/assets/js/sidebar-menu.js"></script>

<!--Customizer admin-->
<script src="{{url('/')}}/assets/js/admin-customizer.js"></script>
<!-- Datatable js-->
<script src="{{url('/')}}/assets/js/datatables/jquery.dataTables.min.js"></script>
<script src="{{url('/')}}/assets/js/datatables/custom-basic.js"></script>
<!--right sidebar js-->
<script src="{{url('/')}}/assets/js/chat-menu.js"></script>

<!--height equal js-->
<script src="{{url('/')}}/assets/js/equal-height.js"></script>

<!-- lazyload js-->
<script src="{{url('/')}}/assets/js/lazysizes.min.js"></script>

<!--script admin-->
<script src="{{url('/')}}/assets/js/admin-script.js"></script>
<!--script Select2-->
<script src="{{url('/')}}/assets/js/select2.min.js"></script>
<script src="{{url('/')}}/assets/js/jquery-confirm.js"></script>

@yield('JavaScript')

</body>

</html>

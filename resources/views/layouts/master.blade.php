<!DOCTYPE html>

<html data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Sama3 Admin Dashboard">
    <meta name="keywords" content="Sama3 Admin Dashboard">
    <meta name="author">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sama3</title>
    <link rel="apple-touch-icon" href="{{ asset('assets/images/ico/apple-icon-120.png') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/images/ico/favicon.ico') }}">

    <link
        href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i%7COpen+Sans:300,300i,400,400i,600,600i,700,700i"
        rel="stylesheet">
    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/vendors.min.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/extensions/unslider.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/weather-icons/climacons.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/fonts/meteocons/style.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/charts/morris.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/tables/datatable/datatables.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('assets/css/plugins/forms/validation/form-validation.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/forms/selects/select2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/pickers/pickadate/pickadate.css') }}">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> <!-- new -->

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap-extended.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/colors.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/components.min.css') }}">
    <!-- END: Theme CSS-->

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('assets/css/core/menu/menu-types/vertical-menu-modern.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/core/colors/palette-gradient.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/fonts/simple-line-icons/style.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/pages/page-users.min.css') }}">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/style.css') }}">
    <!-- END: Custom CSS-->

</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern 2-columns   fixed-navbar" data-open="click"
    data-menu="vertical-menu-modern" data-col="2-columns">

    <!-- BEGIN: Header-->
    <nav class="header-navbar navbar-expand-lg navbar navbar-with-menu fixed-top navbar-semi-dark navbar-shadow">
        <div class="navbar-wrapper">
            <div class="navbar-header">
                <ul class="nav navbar-nav flex-row">
                    <li class="nav-item mobile-menu d-lg-none mr-auto"><a
                            class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i
                                class="feather icon-menu font-large-1"></i></a></li>
                    <li class="nav-item mr-auto"><a class="navbar-brand" href="index-2.html"><img class="brand-logo"
                                alt="stack admin logo" src="{{ asset('assets/images/logo/stack-logo-light.png') }}">
                            <h2 class="brand-text">Stack</h2>
                        </a></li>
                    <li class="nav-item d-none d-lg-block nav-toggle"><a class="nav-link modern-nav-toggle pr-0"
                            data-toggle="collapse"><i
                                class="toggle-icon feather icon-toggle-right font-medium-3 white"
                                data-ticon="feather.icon-toggle-right"></i></a></li>
                    <li class="nav-item d-lg-none"><a class="nav-link open-navbar-container" data-toggle="collapse"
                            data-target="#navbar-mobile"><i class="fa fa-ellipsis-v"></i></a></li>
                </ul>
            </div>
            <div class="navbar-container content">
                <div class="collapse navbar-collapse" id="navbar-mobile">
                    <ul class="nav navbar-nav mr-auto float-left">
                        <li class="nav-item d-none d-md-block"><a class="nav-link nav-link-expand" href="#"><i
                                    class="fa fa-window-maximize"></i></a></li>
                        <li class="nav-item nav-search"><a class="nav-link nav-link-search" href="#"><i
                                    class="fa fa-search"></i></a>
                            <div class="search-input">
                                <input class="input" type="text" placeholder="Explore Stack..." tabindex="0"
                                    data-search="template-search">
                                <div class="search-input-close"><i class="fa-solid fa-x"></i></div>
                                <ul class="search-list"></ul>
                            </div>
                        </li>
                    </ul>
                    <ul class="nav navbar-nav float-right">
                        <li class="dropdown dropdown-user nav-item"><a
                                class="dropdown-toggle nav-link dropdown-user-link" href="#"
                                data-toggle="dropdown">
                                <div class="avatar avatar-online"><img
                                        src="{{ asset('assets/images/portrait/small/avatar-s-1.png') }}"
                                        alt="avatar"><i></i></div><span class="user-name">Demo user</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="user-profile.html">
                                    <i class="fa fa-user"></i> Edit Profile
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fa fa-envelope"></i> My Inbox
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out"></i> Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                </form>
                            </div>

                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <!-- END: Header-->

    <!-- BEGIN: Main Menu-->
    <div class="main-menu menu-fixed menu-dark menu-accordion menu-shadow" data-scroll-to-active="true">
        <div class="main-menu-content">
            <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
                <li class=" navigation-header"><span>Pages</span><i class="fa fa-minus" data-toggle="tooltip"
                        data-placement="right" data-original-title="General"></i>
                </li>
                @role('Admin|Doctor')
                    <li class=" nav-item"><a href="#"><i class="fa fa-user"></i><span class="menu-title"
                                data-i18n="Users">Patients</span></a>
                        <ul class="menu-content">
                            <li class="active">
                                <a class="menu-item" href="{{ route('patient.index') }}" data-i18n="Users View">Patients
                                    List
                                </a>
                            </li>
                            <li><a class="menu-item" href="{{ route('patient.create') }}" data-i18n="Users Edit">Create
                                    Patient</a>
                            </li>
                        </ul>
                    </li>
                @endrole
                @role('Admin|Patient')
                    <li class=" nav-item"><a href="#"><i class="fa fa-user"></i><span class="menu-title"
                                data-i18n="Users">Doctors</span></a>
                        <ul class="menu-content">
                            <li class="">
                                <a class="menu-item" href="{{ route('doctor.index') }}" data-i18n="">Doctors
                                    List
                                </a>
                            </li>
                            @role('Admin')
                                <li><a class="menu-item" href="{{ route('doctor.create') }}" data-i18n="">Create
                                        Doctor</a>
                                </li>
                            @endrole
                        </ul>
                    </li>
                @endrole
                @role('Admin|Doctor|Patient')
                    <li class=" nav-item"><a href="#"><i class="fa fa-notes-medical"></i><span class="menu-title"
                                data-i18n="Users">Therapy</span></a>
                        <ul class="menu-content">
                            <li class="">
                                <a class="menu-item" href="{{ route('therapy.index') }}" data-i18n="">Therapy
                                    List
                                </a>
                            </li>
                        </ul>
                    </li>
                @endrole
                    <li class=" nav-item"><a href="#"><i class="fa fa-user"></i><span class="menu-title"
                                data-i18n="Users">Appointments</span></a>
                        @role('Doctor')
                            <ul class="menu-content">
                                <li><a class="menu-item" href="{{ route('doctors.booking.index') }}" data-i18n="">Patients
                                        Bookings</a>
                                </li>
                            </ul>
                            <ul class="menu-content">
                                <li><a class="menu-item" href="{{ route('doctors.calendar') }}" data-i18n="">Add available
                                        times</a>
                                </li>
                            </ul>
                        @endrole
                        @role('Patient')
                        <ul class="menu-content">
                            <li><a class="menu-item" href="{{ route('patients.booking.index') }}"
                                    data-i18n="">Patients Bookings</a>
                            </li>
                        </ul>
                        @endrole

                    </li>
            </ul>
        </div>
    </div>
    <!-- END: Main Menu-->

    <!-- Content -->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                @yield('content')
            </div>
        </div>
    </div>
    <!-- End: Content -->

    <!-- BEGIN: Footer-->
    <footer class="footer footer-static footer-light navbar-border">
        <p class="clearfix blue-grey lighten-2 text-sm-center mb-0 px-2"><span
                class="float-md-left d-block d-md-inline-block">Copyright &copy; 2024
                <a class="text-bold-800 grey darken-2" href="https://clingroup.net/" target="_blank">ClinGroup </a>
            </span></p>
    </footer>
    <!-- END: Footer-->

    <!-- BEGIN: Vendor JS-->
    <script src="{{ asset('assets/vendors/js/vendors.min.js') }}"></script>
    <!-- BEGIN Vendor JS-->

    <!-- new -->

    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <script src="{{ asset('assets/vendors/js/tables/datatable/datatables.min.js') }}"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="{{ asset('assets/js/core/app-menu.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/app.min.js') }}"></script>
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    <script src="{{ asset('assets/js/scripts/pages/page-users.min.js') }}"></script>
    <script src="{{ asset('assets/js/scripts/navs/navs.min.js') }}"></script>
    <script src="{{ asset('assets/js/scripts/pages/dashboard-ecommerce.min.js') }}"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script><!-- new -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script><!-- new -->

    <!-- BEGIN: Page Vendor JS-->
    <script src="{{ asset('assets/vendors/js/forms/select/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/js/forms/validation/jqBootstrapValidation.js') }}"></script>
    <script src="{{ asset('assets/vendors/js/pickers/pickadate/picker.js') }}"></script>
    <script src="{{ asset('assets/vendors/js/pickers/pickadate/picker.date.js') }}"></script>
    <script src="{{ asset('assets/vendors/js/extensions/unslider-min.js') }}"></script>
    <script src="{{ asset('assets/vendors/js/timeline/horizontal-timeline.js') }}"></script>

    <!-- FullCalendar CSS and JS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"><!-- new -->
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script><!-- new -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>


    <!-- END: Page JS-->

</body>
<!-- END: Body-->

<!-- Mirrored from demos.pixinvent.com/stack-html-admin-template/html/ltr/vertical-modern-menu-template/page-users-list.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 30 Aug 2024 10:38:55 GMT -->

</html>

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

    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap-extended.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/colors.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/components.min.css') }}">
    <!-- END: Theme CSS-->


    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/style.css') }}">
    <!-- END: Custom CSS-->

</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern 1-column   blank-page blank-page"
data-open="click" data-menu="vertical-menu-modern" data-col="1-column">

    <!-- Content -->
     <!-- BEGIN: Content-->
     <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body"><section class="flexbox-container">
                    <div
                        class="col-12 d-flex align-items-center justify-content-center">
                        <div class="col-lg-4 col-md-8 col-10 p-0">
                            <div
                                class="card-header bg-transparent border-0">
                                <h2
                                    class="error-code text-center mb-2">{{$error}}</h2>
                                <h3 class="text-uppercase text-center">{{$message}}</h3>
                            </div>
                            <div class="card-footer bg-transparent">
                                <div class="row">
                                    <p
                                        class="text-muted text-center col-12 py-1">©
                                        <span class="year"></span> <a
                                            href="#">Sama3 </a>Crafted
                                        </i> by <a
                                            href="https://clingroup.net/"
                                            target="_blank">ClinGroup</a></p>
                                    <div class="col-12 text-center">
                                        <a href="#"
                                            class="btn btn-social-icon mr-1 mb-1 btn-outline-facebook"><span
                                                class="fa fa-facebook"></span></a>
                                        <a href="#"
                                            class="btn btn-social-icon mr-1 mb-1 btn-outline-twitter"><span
                                                class="fa fa-twitter"></span></a>
                                        <a href="#"
                                            class="btn btn-social-icon mr-1 mb-1 btn-outline-linkedin"><span
                                                class="fa fa-linkedin font-medium-4"></span></a>
                                        <a href="#"
                                            class="btn btn-social-icon mr-1 mb-1 btn-outline-github"><span
                                                class="fa fa-github font-medium-4"></span></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

            </div>
        </div>
    </div>
    <!-- END: Content-->

    <!-- END: Page JS-->

</body>
<!-- END: Body-->
</html>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sama3</title>
    <link href="https://fonts.googleapis.com/css2?family=Shippori+Mincho&family=Work+Sans:wght@400;800&display=swap"
        rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat+Alternates:wght@500&family=Roboto:wght@400;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard/style.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body>
    <div id="sidebar" class="sidebar">
        <div class="toggle">
            <img src="{{ asset('assets/images/samaa-logo.png') }}" alt="logo">
            <button class="toggle-btn" onclick="toggleMenu()">
                <svg width="21" height="21" viewBox="0 0 21 21" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path d="M1 1.75H19.1818M4.40909 10.8409H19.1818M7.81818 19.9318H19.1818" stroke="#F1EEEC"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </button>
        </div>

        <div class="user-profile">

            @if (Auth::check() && Auth::user()->hasRole('Patient'))

                @if (Auth::check() && Auth::user()->patient && Auth::user()->patient->image)
                    <img src="{{ asset('storage/' . Auth::user()->patient->image) }}" alt="Profile">
                @else
                    <img src="{{ asset('storage/avatar1.png') }}" alt="Profile">
                @endif

                <div class="desc-profile">
                    <h3>{{ Auth::user()->patient->first_name }} {{ Auth::user()->patient->last_name }}</h3>
                </div>
            @elseif (Auth::check() && Auth::user()->hasRole('Doctor'))
                @if (Auth::check() && Auth::user()->doctor && Auth::user()->doctor->image)
                    <img src="{{ asset('storage/' . Auth::user()->doctor->image) }}" alt="Profile">
                @else
                    <img src="{{ asset('storage/avatar1.png') }}" alt="Profile">
                @endif

                <div class="desc-profile">
                    <h3>{{ Auth::user()->doctor->first_name }} {{ Auth::user()->doctor->last_name }}</h3>
                </div>
            @elseif (Auth::check() && Auth::user()->hasRole('Admin'))
                <img src="{{ asset('storage/avatar1.png') }}" alt="Profile">
                <div class="desc-profile">
                    <h3>{{ Auth::user()->name }}</h3>
                </div>
            @endif
        </div>

        <div class="sidebar-content">
            <ul class="menu-items">
                <li><a href="{{ route('dashboard') }}"><img src="{{ asset('assets/images/icons/dashboard.svg') }}"
                            alt="Dashboard"><span>Home</span></a></li>
                <li><a href="{{ route('about-us') }}"><img src="{{ asset('assets/images/icons/profile.svg') }}"
                            alt="Profile"><span>About Us</span></a></li>
                <!--<li><a href="#"><img src="{{ asset('assets/images/icons/listen-to-music.svg') }}"
                            alt="Listen to music"><span>Listen to Music</span></a></li>
                <li><a href="#"><img src="{{ asset('assets/images/icons/library.svg') }}"
                            alt="Library"><span>Library</span></a></li>-->
                @role('Admin|Doctor')
                    <li><a href="{{ route('patient.index') }}"><img src="{{ asset('assets/images/icons/treatment.svg') }}"
                                alt="Treatment"><span>Patient list</span></a></li>
                @endrole
                @role('Admin|Patient')
                    <li><a href="{{ route('doctor.index') }}"><img src="{{ asset('assets/images/icons/profile.svg') }}"
                                alt="Profile"><span>Doctor list</span></a></li>
                @endrole
                @role('Admin')
                    <li><a href="{{ route('feedback-list') }}"><img src="{{ asset('assets/images/icons/review.svg') }}"
                                alt="Review"><span>Feedback</span></a></li>
                @endrole
                @role('Doctor')
                    <li><a href="{{ route('doctors.booking.index') }}"><img
                                src="{{ asset('assets/images/icons/calendar.svg') }}" alt="Calendar"><span>Patients
                                Bookings</span></a></li>
                    <li><a href="{{ route('doctors.calendar') }}"><img
                                src="{{ asset('assets/images/icons/calendar.svg') }}"
                                alt="Calendar"><span>Schedule</span></a></li>
                @endrole
                @role('Patient')
                    <li><a href="{{ route('patients.booking.index') }}"><img
                                src="{{ asset('assets/images/icons/calendar.svg') }}" alt="Calendar"><span>My
                                Bookings</span></a></li>

                    <li><a href="{{ route('feedback') }}"><img src="{{ asset('assets/images/icons/review.svg') }}"
                        alt="Review"><span>Feedback</span></a></li>
                @endrole
                @role('Admin|Doctor|Patient')
                    <li><a href="{{ route('therapy.index') }}"><img src="{{ asset('assets/images/icons/therapy.svg') }}"
                                alt="Therapy"><span>Therapy</span></a></li>
                @endrole
                <li><a href="{{ route('contact-us') }}"><img src="{{ asset('assets/images/icons/phone.svg') }}"
                            alt="Phone"><span>Contact Us</span></a></li>
                <li>
                    @if (Auth::check())
                        <a href="#"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <img src="{{ asset('assets/images/icons/logout.svg') }}" alt="Logout"><span>Logout</span>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    @endif
                </li>
            </ul>
        </div>
    </div>

    <div class="profile-container">
        <!--<div class="main-content">-->

        <!--<div class="search-container">
                <input type="text" placeholder="Search...">
                <button>
                    <svg width="19" height="20" viewBox="0 0 21 22" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M20.75 20.1895L15.086 14.5255C16.4471 12.8914 17.1259 10.7956 16.981 8.67389C16.8362 6.55219 15.879 4.56801 14.3085 3.1341C12.7379 1.7002 10.6751 0.92697 8.54899 0.975279C6.42291 1.02359 4.39729 1.88971 2.89353 3.39347C1.38977 4.89723 0.523649 6.92284 0.47534 9.04893C0.427031 11.175 1.20026 13.2379 2.63416 14.8084C4.06807 16.3789 6.05225 17.3361 8.17395 17.481C10.2957 17.6258 12.3915 16.9471 14.0255 15.586L19.6895 21.25L20.75 20.1895ZM2.00003 9.24996C2.00003 7.91494 2.39591 6.6099 3.13761 5.49987C3.87931 4.38983 4.93351 3.52467 6.16691 3.01378C7.40031 2.50289 8.75751 2.36921 10.0669 2.62966C11.3763 2.89011 12.579 3.53299 13.523 4.47699C14.467 5.421 15.1099 6.62373 15.3703 7.9331C15.6308 9.24248 15.4971 10.5997 14.9862 11.8331C14.4753 13.0665 13.6102 14.1207 12.5001 14.8624C11.3901 15.6041 10.085 16 8.75003 16C6.96042 15.998 5.24469 15.2862 3.97925 14.0207C2.71381 12.7553 2.00201 11.0396 2.00003 9.24996Z"
                            fill="#818181" />
                    </svg>
                </button>
            </div>-->

        @if (session('status'))
            <script>
                Swal.fire({
                    icon: '{{ session('status')['type'] }}',
                    title: 'Success',
                    text: '{{ session('status')['msg'] }}',
                    confirmButtonText: 'OK'
                });
            </script>
        @endif

        @yield('content')

        <!--</div>-->
        <footer class="footer">
            <div class="footer-container">
                <div class="footer-logo">
                    <img src="{{ asset('assets/images/samaa-logo.png') }}" alt="Logo">
                </div>
                <div class="footer-links">
                    <div class="column">
                        <a href="{{ route('home') }}">Home</a>
                        <a href="{{ route('therapy.index') }}">Therapy</a>
                        @if (Auth::check())
                            <a href="#"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                style="display: none;">
                                @csrf
                            </form>
                        @else
                            <a href="{{ route('login') }}">Login</a>
                            <a href="{{ route('register') }}">register</a>
                        @endif

                    </div>
                    <div class="column">
                        <a href="{{ route('about-us') }}">About Us</a>
                        <a href="{{ route('contact-us') }}">Contact Us</a>
                    </div>
                    <div class="column">
                        <a href="#">Library</a>
                    </div>
                </div>
                <div class="footer-help">
                    <a href="#" class="help-btn">Help Center</a>
                    <div class="social-icons">
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p><i class="fas fa-envelope"></i> Samaa@Gmail.Com</p>
            </div>
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

    <script src="{{ asset('assets/js/dashboard/script.js') }}"></script>


</body>

</html>

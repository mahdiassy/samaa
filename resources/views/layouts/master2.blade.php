<!DOCTYPE html>
<html dir="{{ App::getLocale() == 'ar' ? 'rtl' : 'ltr' }}"
    lang="{{ App::getLocale() == 'ar'
        ? 'ar'
        : (App::getLocale() == 'fr'
            ? 'fr'
            : (App::getLocale() == 'en'
                ? 'en'
                : 'en')) }}">

<head>
    @laravelPWA
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SAMAA</title>
    <link rel="icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon">

    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

    <link href="https://fonts.googleapis.com/css2?family=Shippori+Mincho&family=Work+Sans:wght@400;800&display=swap"
        rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat+Alternates:wght@500&family=Roboto:wght@400;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard/style.css') }}">

    <!-- Default Theme Styles -->
    <link id="theme-style" type="text/css" rel="stylesheet" href="{{ asset('assets/css/dashboard/footer.css') }}">
    <!-- Include Kids Theme Styles (Loaded Dynamically) -->
    <link id="kids-style" type="text/css" rel="stylesheet" href="{{ asset('assets/css/dashboard/kids-footer.css') }}">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body>
    <div id="sidebar" class="sidebar">
        <div class="toggle">
            <span><a href="{{route('home')}}"><img src="{{ asset('assets/images/samaa-logo.png') }}" alt="logo"></a></span>
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
                    <img src="{{ asset('assets/images/avatar1.png') }}" alt="Profile">
                @endif

                <div class="desc-profile">
                    <a title="edit Profile" href="{{ route('profile.patient.edit', Auth::user()->patient) }}">
                        <h3>{{ Auth::user()->patient->first_name }} {{ Auth::user()->patient->last_name }}</h3>
                    </a>
                </div>
            @elseif (Auth::check() && Auth::user()->hasRole('Doctor'))
                @if (Auth::check() && Auth::user()->doctor && Auth::user()->doctor->image)
                    <img src="{{ asset('storage/' . Auth::user()->doctor->image) }}" alt="Profile">
                @else
                    <img src="{{ asset('assets/images/avatar1.png') }}" alt="Profile">
                @endif

                <div class="desc-profile">
                    <a title="edit Profile" href="{{ route('profile.doctor.edit', Auth::user()->doctor) }}">
                        <h3>{{ Auth::user()->doctor->first_name }} {{ Auth::user()->doctor->last_name }}</h3>
                    </a>
                </div>
            @elseif (Auth::check() && Auth::user()->hasRole('Admin'))
                <img src="{{ asset('assets/images/avatar1.png') }}" alt="Profile">
                <div class="desc-profile">
                    <h3>{{ Auth::user()->name }}</h3>
                </div>
            @endif
        </div>

        <div class="sidebar-content">
            <ul class="menu-items">
                <li title="{{ __('site.Home') }}"><a href="{{ route('dashboard') }}"><img
                            src="{{ asset('assets/images/icons/dashboard.svg') }}"
                            alt="Dashboard"><span>{{ __('site.Home') }}</span></a></li>
                <li title="{{ __('site.About Us') }}"><a href="{{ route('about-us') }}"><img
                            src="{{ asset('assets/images/icons/profile.svg') }}"
                            alt="Profile"><span>{{ __('site.About Us') }}</span></a></li>
                @role('Doctor')
                    <li title="{{ __('site.Patients Booking') }}"><a href="{{ route('doctors.booking.index') }}"><img
                                src="{{ asset('assets/images/icons/Appointment.svg') }}"
                                alt="Calendar"><span>{{ __('site.Patients Booking') }}</span></a></li>
                    <li title="{{ __('site.Schedule') }}"><a href="{{ route('doctors.calendar') }}"><img
                                src="{{ asset('assets/images/icons/calendar.svg') }}"
                                alt="Calendar"><span>{{ __('site.Schedule') }}</span></a></li>
                @endrole
                @role('Patient')
                    <li title="{{ __('site.My Bookings') }}"><a href="{{ route('patients.booking.index') }}"><img
                                src="{{ asset('assets/images/icons/Appointment.svg') }}"
                                alt="Calendar"><span>{{ __('site.My Bookings') }}</span></a></li>
                @endrole
                @role('Admin|Doctor')
                    <li title="{{ __('site.Patient list') }}"><a href="{{ route('patient.index') }}"><img
                                src="{{ asset('assets/images/icons/treatment.svg') }}"
                                alt="Treatment"><span>{{ __('site.Patient list') }}</span></a></li>
                @endrole
                @role('Admin|Doctor|Patient')
                    <li title="{{ __('site.Doctor list') }}"><a href="{{ route('doctor.index') }}"><img
                        src="{{ asset('assets/images/icons/Medical history.svg') }}"
                        alt="Profile"><span>{{ __('site.Doctor list') }}</span></a></li>
                    <li title="{{ __('site.therapy') }}"><a href="{{ route('therapy.index') }}"><img
                                src="{{ asset('assets/images/icons/therapy.svg') }}"
                                alt="Therapy"><span>{{ __('site.therapy') }}</span></a></li>
                    <li title="{{ __('site.Feedback') }}"><a href="{{ route('feedback-list') }}"><img
                                src="{{ asset('assets/images/icons/review.svg') }}"
                                alt="Review"><span>{{ __('site.Feedback') }}</span></a></li>
                @endrole
                @role('Admin')
                    <li title="{{ __('site.Blog list') }}"><a href="{{ route('blog.list') }}"><img
                        src="{{ asset('assets/images/icons/library.svg') }}"
                        alt="Profile"><span>{{ __('site.Blog list') }}</span></a></li>
                @endrole
                <li title="{{ __('site.Contact Us') }}"><a href="{{ route('contact-us') }}"><img
                            src="{{ asset('assets/images/icons/phone.svg') }}"
                            alt="Phone"><span>{{ __('site.Contact Us') }}</span></a></li>

                <li title="{{ __('site.change password') }}"><a href="{{ route('changePassword') }}"><img
                    src="{{ asset('assets/images/icons/Reset password.svg') }}"
                    alt="Phone"><span>{{ __('site.change password') }}</span></a></li>
                <li title="{{ __('site.Logout') }}">
                    @if (Auth::check())
                        <a href="#"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <img src="{{ asset('assets/images/icons/logout.svg') }}"
                                alt="Logout"><span>{{ __('site.Logout') }}</span>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                            style="display: none;">
                            @csrf
                        </form>
                    @endif
                </li>
            </ul>
        </div>
    </div>

    @if (App::getLocale() == 'ar')
        <div class="profile-container-Arabic">
        @else
            <div class="profile-container">
    @endif

    @if (session('status'))
        <script>
            Swal.fire({
                icon: '{{ session('status')['type'] }}',
                title: '{{ session('status')['title'] }}',
                text: '{{ session('status')['msg'] }}',
                confirmButtonText: '{{ __('site.OK') }}'
            });
        </script>
    @endif

    @routes
    @yield('content')

    <footer class="footer">
        <div class="footer-container">
            <a href="{{ route('home') }}">
                <div class="footer-logo"></div>
            </a>
            <div class="footer-links">
                <div class="column">
                    <a href="{{ route('home') }}">{{ __('site.Home') }}</a>
                    <a href="{{ route('therapy.index') }}">{{ __('site.therapy') }}</a>
                    @if (Auth::check())
                        <a href="#"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            {{ __('site.Logout') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                            style="display: none;">
                            @csrf
                        </form>
                    @else
                        <a href="{{ route('login') }}">{{ __('site.Login/Sign-up') }}</a>
                        <!--<a href="{{ route('register') }}">{{ __('site.Register') }}</a>-->
                    @endif

                </div>
                <div class="column">
                    <a href="{{ route('about-us') }}">{{ __('site.About Us') }}</a>
                    <a href="{{ route('contact-us') }}">{{ __('site.Contact Us') }}</a>
                </div>
                <div class="column">
                    <a href="{{ Auth::check() ? (\App\Models\Therapy::getTherapiesBasedRole()->isNotEmpty() ? route('playlist') : route('therapy.index')) : route('login') }}">
                        {{ __('site.Library') }}
                    </a>
                </div>
            </div>
            <div class="footer-help">
                <a href="#" class="help-btn">{{ __('site.Help Center') }}</a>
                <div class="social-icons">
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a target="__blank" href="https://www.facebook.com/profile.php?id=61573920330522"><i class="fab fa-facebook-f"></i></a>
                    <a target="__blank" href="https://www.linkedin.com/showcase/samaa-dnci/about/?viewAsMember=true"><i class="fab fa fa-linkedin"></i></a>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p><i class="fas fa-envelope"></i><a href="mailto:Samaa@gmail.com"> Samaa@gmail.com </a></p>
        </div>
    </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/ckeditor5-classic-free-full-feature@35.4.1/build/ckeditor.min.js"></script>

    <script>

        $(document).ready(function () {
            $('.diseases-select-backend').select2({
                placeholder: "{{ __('site.Select one or more diseases') }}",
                width: '100%'
            });
        });

        let selectDiseaseText = "{{ __('site.Diseases') }}";
        let samaaKidsTitle = "{{ __('site.Sama’a for kids') }}";
        let samaaTitle = "{{ __('site.Sama’a') }}";
        let noResult = "{{ __('site.No results found') }}";
        const BookingEnum = {
            PATIENT_CANCEL: "{{ \App\Enums\BookingEnum::PATIENT_CANCEL }}",
        };
        const translations = {
            "site.Pending": "{{ __('site.Pending') }}",
            "site.Done": "{{ __('site.Done') }}",
            "site.Approved": "{{ __('site.Approved') }}",
            "site.Canceled": "{{ __('site.Canceled') }}",
            "site.Canceled By Patient": "{{ __('site.Canceled By Patient') }}",
        };

        @foreach (config('app.locales') as $locale)
            ClassicEditor
                .create(document.querySelector('#description_{{ $locale }}'))
                .catch(error => {
                    console.error('CKEditor error for locale {{ $locale }}:', error);
                });
        @endforeach
    </script>

    <script src="{{ asset('assets/js/scripts.js') }}"></script>
    <script src="{{ asset('assets/js/dashboard/script.js') }}"></script>

</body>

</html>

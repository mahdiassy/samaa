<!DOCTYPE html>
<html dir="{{ App::isLocale('ar') ? 'rtl' : 'ltr' }}" lang="{{ app()->getLocale() }}">

<head>
    @laravelPWA
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SAMAA</title>

    <link rel="icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon">

    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

    <link rel="stylesheet" href="{{ asset('assets/css/frontend/style.css') }}">
    <link id="theme-override-style" rel="stylesheet" href="" data-kids-path="{{ asset('assets/css/frontend/kids-style.css') }}">

    <!-- Default Theme Styles -->
    {{-- <link id="theme-style" type="text/css" rel="stylesheet" href="{{ asset('assets/css/frontend/style.css') }}"> --}}
    <!-- Include Kids Theme Styles (Loaded Dynamically) -->
    {{-- <link id="kids-style" type="text/css" rel="stylesheet" href="{{ asset('assets/css/frontend/kids-style.css') }}"> --}}

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Shippori+Mincho&family=Work+Sans:wght@400;800&display=swap"
        rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat+Alternates:wght@500&family=Roboto:wght@400;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body>

    <div id="theme-popup" class="popup">
        <p>{{ __('site.theme-message') }}</p>
        <button class="popup-button" id="default-theme-btn">{{ __('site.Default') }}</button>
        <button class="popup-button" id="kids-theme-btn">{{ __('site.Kids') }}</button>
    </div>
    <div id="overlay" class="overlay"></div>

    <nav class="main-nav">
        <div class="logo">
            <a href="{{ route('home') }}"><img src="{{ asset('assets/images/samaa-logo.png') }}" alt="Logo"></a>
        </div>
        <div class="menu-toggle" id="menuToggle">
            <div></div>
            <div></div>
            <div></div>
        </div>
        <div class="menu" id="menu">
            <button class="close-menu" id="closeMenu">×</button>
            <h2 class="menu-title">{{ __('site.Menu') }}</h2>
            <a href="{{ route('home') }}">{{ __('site.Home') }}</a>
            <a href="{{ route('how-it-work') }}">{{ __('site.How It Works') }}</a>
            <a href="{{ route('therapists') }}">{{ __('site.Therapists') }}</a>
            <a href="{{ route('blog.index') }}">{{ __('site.blogs') }}</a>
            <a href="{{ route('about-us') }}">{{ __('site.About Us') }}</a>
            <a href="{{ route('contact-us') }}">{{ __('site.Contact Us') }}</a>
            @if (Auth::check())
                <a href="{{ route('dashboard') }}">{{ __('site.Dashboard') }}</a>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    {{ __('site.Logout') }}
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            @else
                <a href="{{ route('login') }}">{{ __('site.Login/Sign-up') }}</a>
                <!--<a href="{{ route('register') }}">{{ __('site.Register') }}</a>-->
            @endif

            <div
                class="profile {{ App::getLocale() == 'ar' ? 'profile-ar' : (App::getLocale() == 'fr' ? 'profile-fr' : 'profile-en') }}">

                @if (Auth::check() && Auth::user()->hasRole('Patient'))

                    <div class="a-desc-profile">
                        <a title="edit Profile" href="{{ route('profile.patient.edit', Auth::user()->patient) }}">
                            <span class="menu-desc-profile">{{ Auth::user()->patient->first_name }}
                                {{ Auth::user()->patient->last_name }}</span>
                        </a>
                    </div>

                    @if (Auth::check() && Auth::user()->patient && Auth::user()->patient->image)
                        <img src="{{ asset('storage/' . Auth::user()->patient->image) }}" alt="Profile">
                    @else
                        <img src="{{ asset('assets/images/avatar1.png') }}" alt="Profile">
                    @endif
                @elseif (Auth::check() && Auth::user()->hasRole('Doctor'))
                    <div class="a-desc-profile">
                        <a title="edit Profile" href="{{ route('profile.doctor.edit', Auth::user()->doctor) }}">
                            <span class="menu-desc-profile">{{ Auth::user()->doctor->first_name }}
                                {{ Auth::user()->doctor->last_name }}</span>
                        </a>
                    </div>

                    @if (Auth::check() && Auth::user()->doctor && Auth::user()->doctor->image)
                        <img src="{{ asset('storage/' . Auth::user()->doctor->image) }}" alt="Profile">
                    @else
                        <img src="{{ asset('assets/images/avatar1.png') }}" alt="Profile">
                    @endif
                @elseif (Auth::check() && Auth::user()->hasRole('Admin'))
                    <span>{{ Auth::user()->name }}</span>
                    <img src="{{ asset('assets/images/avatar1.png') }}" alt="Profile">
                @endif
            </div>

            <div class="language-selector">
                <select id="language-select" class="form-select" onchange="location = this.value;">
                    @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                        <option class="menu-flag"
                            value="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}"
                            {{ App::getLocale() == $localeCode ? 'selected' : '' }}>
                            <img src="https://cdn.jsdelivr.net/npm/svg-country-flags@1.2.10/svg/{{ $localeCode == 'ar' ? 'sa' : ($localeCode == 'fr' ? 'fr' : 'gb') }}.svg"
                                width="20px" alt="{{ $properties['name'] }}" />
                                {{ strtoupper($localeCode) }}
                        </option>
                    @endforeach
                </select>
            </div>

        </div>
    </nav>

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: "{{ session('error') }}",
            });
        </script>
    @endif

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: "{{ session('success') }}",
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
                    <a href="{{ route('therapy.index') }}">{{ __('site.Therapy') }}</a>
                    @if (Auth::check())
                        <a href="#"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            {{ __('site.Logout') }}
                        </a>
                    @else
                        <a href="{{ route('login') }}"> {{ __('site.Login/Sign-up') }}</a>
                        <!--<a href="{{ route('register') }}"> {{ __('site.Register') }}</a>-->
                    @endif

                </div>
                <div class="column">
                    <a href="{{ route('about-us') }}"> {{ __('site.About Us') }}</a>
                    <a href="{{ route('contact-us') }}"> {{ __('site.Contact Us') }}</a>
                </div>
                <div class="column">
                    <a
                        href="{{ Auth::check() ? (\App\Models\Therapy::getTherapiesBasedRole()->isNotEmpty() ? route('playlist') : route('therapy.index')) : route('login') }}">
                        {{ __('site.Library') }}
                    </a>
                </div>
            </div>
            <div class="footer-help">
                <a href="#" class="help-btn"> {{ __('site.Help Center') }}</a>
                <div class="social-icons">
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a target="__blank" href="https://www.facebook.com/profile.php?id=61573920330522"><i class="fab fa-facebook-f"></i></a>
                    <a target="__blank" href="https://www.linkedin.com/showcase/samaa-dnci/about/?viewAsMember=true"><i class="fab fa fa-linkedin"></i></a>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p><i class="fas fa-envelope"></i> <a href="mailto:Samaa@gmail.com">Samaa@gmail.com </a></p>
        </div>
    </footer>
    <script>
        let selectDiseaseText = "{{ __('site.Diseases') }}";
        let samaaKidsTitle = "{{ __('site.Sama’a for kids') }}";
        let samaaTitle = "{{ __('site.Sama’a') }}";
        let noResult = "{{ __('site.No results found') }}";
    </script>
    <script src="{{ asset('assets/js/scripts.js') }}"></script>
    <script src="{{ asset('assets/js/frontend/scripts.js') }}"></script>

</body>

</html>

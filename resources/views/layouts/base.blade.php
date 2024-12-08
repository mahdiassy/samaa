<!DOCTYPE html>
<html dir="{{ App::getLocale() == 'ar' ? "rtl" : "ltr" }}" lang="{{
    App::getLocale() == 'ar' ? 'ar' :
    (App::getLocale() == 'fr' ? 'fr' :
    (App::getLocale() == 'en' ? 'en' : 'en'))
}}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/frontend/style.css') }}">
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
    <nav>
        <div class="logo">
            <img src="{{ asset('assets/images/samaa-logo.png') }}" alt="Logo">
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
            <a href="{{ route('about-us') }}">{{ __('site.About Us') }}</a>
            <!--<a href="#">Library</a>
            <a href="#">Listen to Music</a>
            <a href="#">Patient List</a>
            <a href="#">Feedback</a>
            <a href="#">Schedule</a>
            <a href="#">Therapy</a>-->
            <a href="{{ route('contact-us') }}">{{ __('site.Contact Us') }}</a>
            <!--<a href="#">Login</a>-->
            @if (Auth::check())
                <a href="{{ route('dashboard') }}">{{ __('site.Dashboard') }}</a>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    {{ __('site.Logout') }}
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            @else
                <a href="{{ route('login') }}">{{ __('site.Login') }}</a>
                <a href="{{ route('register') }}">{{ __('site.Register') }}</a>
            @endif

            <div class="profile">

                @if (Auth::check() && Auth::user()->hasRole('Patient'))

                    <span>{{ Auth::user()->patient->first_name }} {{ Auth::user()->patient->last_name }}</span>

                    @if (Auth::check() && Auth::user()->patient && Auth::user()->patient->image)
                        <img src="{{ asset('storage/' . Auth::user()->patient->image) }}" alt="Profile">
                    @else
                        <img src="{{ asset('storage/avatar1.png') }}" alt="Profile">
                    @endif
                @elseif (Auth::check() && Auth::user()->hasRole('Doctor'))
                    <span>{{ Auth::user()->doctor->first_name }} {{ Auth::user()->doctor->last_name }}</span>
                    @if (Auth::check() && Auth::user()->doctor && Auth::user()->doctor->image)
                        <img src="{{ asset('storage/' . Auth::user()->doctor->image) }}" alt="Profile">
                    @else
                        <img src="{{ asset('storage/avatar1.png') }}" alt="Profile">
                    @endif
                @elseif (Auth::check() && Auth::user()->hasRole('Admin'))
                    <span>{{ Auth::user()->name }}</span>
                    <img src="{{ asset('storage/avatar1.png') }}" alt="Profile">
                @endif
            </div>

            <div class="language-selector">
                <select id="language-select" class="form-select" onchange="location = this.value;">
                    @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                        <option value="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}"
                            {{ App::getLocale() == $localeCode ? 'selected' : '' }}>
                            @if ($localeCode == 'en')
                                <img src="https://cdn.jsdelivr.net/npm/svg-country-flags@1.2.10/svg/gb.svg"
                                    width="23px" /> {{ $properties['native'] }}
                            @elseif ($localeCode == 'fr')
                                <img src="https://cdn.jsdelivr.net/npm/svg-country-flags@1.2.10/svg/fr.svg"
                                    width="23px" /> {{ $properties['native'] }}
                            @elseif ($localeCode == 'ar')
                                <img src="https://cdn.jsdelivr.net/npm/svg-country-flags@1.2.10/svg/sa.svg"
                                    width="23px" /> {{ $properties['native'] }}
                            @endif

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

    @yield('content')

    <footer class="footer">
        <div class="footer-container">
            <div class="footer-logo">
                <img src="{{ asset('assets/images/samaa-logo.png') }}" alt="Logo">
            </div>
            <div class="footer-links">
                <div class="column">
                    <a href="{{ route('home') }}">{{ __('site.Home') }}</a>
                    <a href="{{ route('therapy.index') }}">{{ __('site.Therapy') }}</a>
                    @if (Auth::check())
                        <a href="#"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            {{ __('site.Logout') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    @else
                        <a href="{{ route('login') }}"> {{ __('site.Login') }}</a>
                        <a href="{{ route('register') }}"> {{ __('site.Register') }}</a>
                    @endif

                </div>
                <div class="column">
                    <a href="{{ route('about-us') }}"> {{ __('site.About Us') }}</a>
                    <a href="{{ route('contact-us') }}"> {{ __('site.Contact Us') }}</a>
                </div>
                <div class="column">
                    <a href="#"> {{ __('site.Library') }}</a>
                </div>
            </div>
            <div class="footer-help">
                <a href="#" class="help-btn"> {{ __('site.Help Center') }}</a>
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

    <script src="{{ asset('assets/js/frontend/scripts.js') }}"></script>

</body>

</html>

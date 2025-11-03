<!DOCTYPE html>
<html dir="{{ App::isLocale('ar') ? 'rtl' : 'ltr' }}" lang="{{ app()->getLocale() }}">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    @laravelPWA
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ __('components.common.SAMAA - Sound therapy and music healing platform. Personalized AI-driven therapeutic sessions for wellness and healing.') }}">
    <meta name="keywords" content="music therapy, sound healing, AI therapy, wellness, mental health, SAMAA">
    <meta name="author" content="SAMAA">
    <meta property="og:title" content="SAMAA - Hear to Heal">
    <meta property="og:description" content="{{ __('components.common.Personalized sound therapy powered by AI for your wellness journey.') }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ asset('assets/images/samaa-logo.png') }}">
    <title>SAMAA - {{ __('components.common.Hear to Heal') }}</title>

    <!-- Preload critical resources -->
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;600;700&display=swap" as="style">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Main Styles (includes legacy styles for compatibility) -->
    <link rel="stylesheet" href="{{ asset('assets/css/frontend/style.css') }}">
    
    <!-- Vite Assets (Tailwind CSS) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- RTL Support for Arabic -->
    @if(App::isLocale('ar'))
    <style>
        /* RTL specific overrides */
        .rtl-flip {
            transform: scaleX(-1);
        }
        
        /* Custom RTL adjustments */
        [dir="rtl"] .text-left {
            text-align: right !important;
        }
        
        [dir="rtl"] .text-right {
            text-align: left !important;
        }
        
        [dir="rtl"] .float-left {
            float: right !important;
        }
        
        [dir="rtl"] .float-right {
            float: left !important;
        }
    </style>
    @endif
                            DEFAULT: '#0F4A6A',
                        },
                        secondary: {
                            50: '#f0fdfa',
                            100: '#ccfbf1',
                            200: '#99f6e4',
                            300: '#5eead4',
                            400: '#2dd4bf',
                            500: '#2D6B69',
                            600: '#1F4F4D',
                            700: '#0f766e',
                            800: '#115e59',
                            900: '#134e4a',
                            DEFAULT: '#2D6B69',
                        },
                        accent: {
                            50: '#fffbeb',
                            100: '#fef3c7',
                            200: '#fde68a',
                            300: '#fcd34d',
                            400: '#fbbf24',
                            500: '#B8860B',
                            600: '#d97706',
                            700: '#b45309',
                            800: '#92400e',
                            900: '#78350f',
                            DEFAULT: '#B8860B',
                        },
                        // High contrast colors for accessibility
                        contrast: {
                            high: '#000000',
                            medium: '#374151',
                            low: '#6b7280',
                            inverse: '#ffffff',
                        }
                    },
                    fontFamily: {
                        'sans': ['Inter', 'system-ui', 'sans-serif'],
                        'elegant': ['Playfair Display', 'serif'],
                    },
                    animation: {
                        'fade-in-up': 'fadeInUp 0.6s ease-out',
                        'fade-in-down': 'fadeInDown 0.6s ease-out',
                        'slide-in-left': 'slideInLeft 0.5s ease-out',
                        'slide-in-right': 'slideInRight 0.5s ease-out',
                        'scale-in': 'scaleIn 0.3s ease-out',
                        'float': 'float 3s ease-in-out infinite',
                        'glow': 'glow 2s ease-in-out infinite alternate',
                    },
                    keyframes: {
                        fadeInUp: {
                            '0%': { opacity: '0', transform: 'translateY(30px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        },
                        fadeInDown: {
                            '0%': { opacity: '0', transform: 'translateY(-30px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        },
                        slideInLeft: {
                            '0%': { opacity: '0', transform: 'translateX(-30px)' },
                            '100%': { opacity: '1', transform: 'translateX(0)' },
                        },
                        slideInRight: {
                            '0%': { opacity: '0', transform: 'translateX(30px)' },
                            '100%': { opacity: '1', transform: 'translateX(0)' },
                        },
                        scaleIn: {
                            '0%': { opacity: '0', transform: 'scale(0.9)' },
                            '100%': { opacity: '1', transform: 'scale(1)' },
                        },
                        float: {
                            '0%, 100%': { transform: 'translateY(0px)' },
                            '50%': { transform: 'translateY(-20px)' },
                        },
                        glow: {
                            '0%': { boxShadow: '0 0 5px rgba(15, 74, 106, 0.5)' },
                            '100%': { boxShadow: '0 0 20px rgba(15, 74, 106, 0.8)' },
                        },
                    }
                }
            }
        }
    </script>
    
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    
    <!-- Select2 (if needed) -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- Custom Mobile Menu Styles -->
    <style>
        /* Enhanced mobile menu animations */
        #mobileMenu {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-in-out, opacity 0.3s ease-in-out;
            opacity: 0;
        }
        
        #mobileMenu:not(.hidden) {
            max-height: 400px;
            opacity: 1;
        }
        
        /* Burger menu animation */
        #mobileMenuToggle span {
            transform-origin: center;
            transition: all 0.3s ease-in-out;
        }
        
        /* Mobile menu touch optimization */
        @media(max-width: 768px) {
            #mobileMenuToggle {
                min-width: 44px;
                min-height: 44px;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            
            #mobileMenu a {
                min-height: 48px;
                display: flex;
                align-items: center;
                touch-action: manipulation;
            }
        }
    </style>
    
    <!-- Critical CSS for immediate rendering -->
    <style>
        /* Ensure basic layout works even if external CSS fails */
        .hero {
            position: relative;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }
        
        .hero-text {
            position: relative;
            z-index: 20;
            text-align: center;
            padding: 1.5rem;
            max-width: 80rem;
            margin: 0 auto;
        }
        
        .hero-text h1 {
            font-size: 3rem;
            font-weight: bold;
            margin-bottom: 1.5rem;
            line-height: 1.2;
            color: white;
        }
        
        .hero-text p {
            font-size: 1.25rem;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 2rem;
            line-height: 1.6;
            max-width: 48rem;
            margin-left: auto;
            margin-right: auto;
        }
        
        .hero-buttons {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            justify-content: center;
            align-items: center;
        }
        
        .hero-buttons button {
            padding: 1rem 2rem;
            font-weight: 600;
            border-radius: 1rem;
            font-size: 1.125rem;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .landing-page {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
        }
        
        .landing-page img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        @media(min-width: 640px) {
            .hero-text h1 {
                font-size: 4rem;
            }
            .hero-text p {
                font-size: 1.5rem;
            }
            .hero-buttons {
                flex-direction: row;
            }
        }
        
        @media(min-width: 1024px) {
            .hero-text h1 {
                font-size: 6rem;
            }
        }
    </style>

    <!-- Mobile Menu JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuBtn = document.getElementById('mobileMenuToggle');
            const mobileMenu = document.getElementById('mobileMenu');
            const menuBars = mobileMenuBtn.getElementsByTagName('span');
            let isMenuOpen = false;

            function toggleMenu() {
                isMenuOpen = !isMenuOpen;
                mobileMenu.classList.toggle('hidden');
                
                if (isMenuOpen) {
                    // Animate to X
                    menuBars[0].style.transform = 'translateY(6px) rotate(45deg)';
                    menuBars[1].style.opacity = '0';
                    menuBars[2].style.transform = 'translateY(-6px) rotate(-45deg)';
                } else {
                    // Reset to hamburger
                    menuBars[0].style.transform = 'none';
                    menuBars[1].style.opacity = '1';
                    menuBars[2].style.transform = 'none';
                }
            }

            mobileMenuBtn.addEventListener('click', toggleMenu);

            // Close menu when clicking outside
            document.addEventListener('click', function(event) {
                if (isMenuOpen && !mobileMenuBtn.contains(event.target) && !mobileMenu.contains(event.target)) {
                    toggleMenu();
                }
            });
        });
    </script>
</head>

<body>
    <!-- Skip to Content Link for Accessibility -->
    <a href="#main-content" class="sr-only block md:hidden focus:not-sr-only focus:fixed focus:top-4 focus:left-4 focus:z-50 focus:px-4 focus:py-2 focus:bg-accent-500 focus:text-white focus:rounded-lg focus:shadow-lg">
        {{ __('site.Skip to main content') }}
    </a>

    <!-- Modern High-Contrast Navigation -->
    <nav class="fixed top-0 left-0 right-0 z-50 bg-gradient-to-r from-gray-900/98 via-slate-900/98 to-gray-900/98 backdrop-blur-xl border-b border-gray-700/30 shadow-2xl transition-all duration-300" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
        <!-- Desktop Navigation Container -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <!-- Brand Logo with Animation -->
                <a href="{{ route('home') }}" 
                   class="flex items-center @if(app()->getLocale() == 'ar') space-x-reverse @endif space-x-3 hover:opacity-90 
                          transform hover:scale-105 transition-all duration-300 animate-fade-in-down group">
                    <div class="relative">
                        <div class="absolute inset-0 bg-accent-400/20 blur-xl rounded-full group-hover:bg-accent-400/30 transition-all duration-300"></div>
                        <img src="{{ asset('assets/images/samaa-logo.png') }}" alt="SAMAA Logo" class="h-12 w-auto relative z-10">
                    </div>
                    <span class="text-2xl font-elegant font-bold bg-gradient-to-r from-white to-gray-200 bg-clip-text text-transparent">SAMAA</span>
                </a>

                <!-- Desktop Navigation -->
                <div class="hidden lg:flex items-center @if(app()->getLocale() == 'ar') space-x-reverse @endif space-x-2">
                    <a href="{{ route('home') }}" 
                       class="nav-link {{ request()->routeIs('home') ? 'text-accent-400 bg-accent-500/20 shadow-lg shadow-accent-500/20' : 'text-gray-300 hover:text-white' }} 
                              hover:bg-gray-800/50 px-4 py-2.5 rounded-xl transition-all duration-300
                              relative group animate-fade-in-down font-medium text-sm whitespace-nowrap
                              border border-transparent hover:border-gray-700/50"
                       style="animation-delay: 0.1s">
                        <span class="relative z-10">{{ __('site.Home') }}</span>
                        <span class="absolute inset-0 bg-gradient-to-r from-accent-500/0 via-accent-500/5 to-accent-500/0 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-xl"></span>
                    </a>
                    <a href="{{ route('about-us') }}" 
                       class="nav-link {{ request()->routeIs('about-us') ? 'text-accent-400 bg-accent-500/20 shadow-lg shadow-accent-500/20' : 'text-gray-300 hover:text-white' }} 
                              hover:bg-gray-800/50 px-4 py-2.5 rounded-xl transition-all duration-300
                              relative group animate-fade-in-down font-medium text-sm whitespace-nowrap
                              border border-transparent hover:border-gray-700/50"
                       style="animation-delay: 0.2s">
                        <span class="relative z-10">{{ __('site.About Us') }}</span>
                        <span class="absolute inset-0 bg-gradient-to-r from-accent-500/0 via-accent-500/5 to-accent-500/0 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-xl"></span>
                    </a>
                    <a href="{{ route('how-it-work') }}" 
                       class="nav-link {{ request()->routeIs('how-it-work') ? 'text-accent-400 bg-accent-500/20 shadow-lg shadow-accent-500/20' : 'text-gray-300 hover:text-white' }} 
                              hover:bg-gray-800/50 px-4 py-2.5 rounded-xl transition-all duration-300
                              relative group animate-fade-in-down font-medium text-sm whitespace-nowrap
                              border border-transparent hover:border-gray-700/50"
                       style="animation-delay: 0.3s">
                        <span class="relative z-10">{{ __('site.How It Works') }}</span>
                        <span class="absolute inset-0 bg-gradient-to-r from-accent-500/0 via-accent-500/5 to-accent-500/0 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-xl"></span>
                    </a>
                    <a href="{{ route('therapists') }}" 
                       class="nav-link {{ request()->routeIs('therapists') ? 'text-accent-400 bg-accent-500/20 shadow-lg shadow-accent-500/20' : 'text-gray-300 hover:text-white' }} 
                              hover:bg-gray-800/50 px-4 py-2.5 rounded-xl transition-all duration-300
                              relative group animate-fade-in-down font-medium text-sm whitespace-nowrap
                              border border-transparent hover:border-gray-700/50"
                       style="animation-delay: 0.4s">
                        <span class="relative z-10">{{ __('site.Therapists') }}</span>
                        <span class="absolute inset-0 bg-gradient-to-r from-accent-500/0 via-accent-500/5 to-accent-500/0 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-xl"></span>
                    </a>
                    <a href="{{ route('contact-us') }}" 
                       class="nav-link {{ request()->routeIs('contact-us') ? 'text-accent-400 bg-accent-500/20 shadow-lg shadow-accent-500/20' : 'text-gray-300 hover:text-white' }} 
                              hover:bg-gray-800/50 px-4 py-2.5 rounded-xl transition-all duration-300
                              relative group animate-fade-in-down font-medium text-sm whitespace-nowrap
                              border border-transparent hover:border-gray-700/50"
                       style="animation-delay: 0.5s">
                        <span class="relative z-10">{{ __('site.Contact Us') }}</span>
                        <span class="absolute inset-0 bg-gradient-to-r from-accent-500/0 via-accent-500/5 to-accent-500/0 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-xl"></span>
                    </a>
                </div>

                <!-- CTA Buttons -->
                <div class="hidden lg:flex items-center @if(app()->getLocale() == 'ar') space-x-reverse space-x-3 @else space-x-3 @endif">
                    @guest
                        <a href="{{ route('login') }}" 
                           class="inline-flex items-center px-4 xl:px-6 py-2 xl:py-3 text-white font-semibold rounded-xl text-sm xl:text-base
                                  bg-gradient-to-r from-primary-500 to-primary-600 
                                  hover:from-primary-600 hover:to-primary-700
                                  transform hover:scale-105 transition-all duration-300
                                  shadow-lg hover:shadow-xl whitespace-nowrap
                                  animate-fade-in-down"
                           style="animation-delay: 0.6s">
                            {{ __('site.Login') }}
                        </a>
                    @else
                        <a href="{{ route('dashboard') }}" 
                           class="inline-flex items-center px-4 xl:px-6 py-2 xl:py-3 text-white font-semibold rounded-xl text-sm xl:text-base
                                  bg-gradient-to-r from-secondary-500 to-secondary-600 
                                  hover:from-secondary-600 hover:to-secondary-700
                                  transform hover:scale-105 transition-all duration-300
                                  shadow-lg hover:shadow-xl whitespace-nowrap
                                  animate-fade-in-down"
                           style="animation-delay: 0.6s">
                            {{ __('site.Dashboard') }}
                        </a>
                    @endguest

                    <!-- Professional Language Switcher -->
                    <div class="relative animate-fade-in-down" style="animation-delay: 0.7s">
                        <div class="group">
                            <!-- Current Language Display -->
                            <button class="flex items-center @if(app()->getLocale() == 'ar') space-x-reverse @endif space-x-2 text-gray-200 hover:text-white bg-gray-800/50 hover:bg-gray-700/70 px-3 xl:px-4 py-2 rounded-xl border border-gray-600/50 hover:border-gray-500/70 transition-all duration-300 backdrop-blur-sm">
                                <i class="fas fa-globe text-accent-400"></i>
                                <span class="font-medium text-sm xl:text-base">
                                    @if(app()->getLocale() == 'en')
                                        EN
                                    @elseif(app()->getLocale() == 'ar')
                                        AR
                                    @else
                                        FR
                                    @endif
                                </span>
                                <i class="fas fa-chevron-down text-xs group-hover:rotate-180 transition-transform duration-300"></i>
                            </button>
                            
                            <!-- Dropdown Menu -->
                            <div class="absolute @if(app()->getLocale() == 'ar') left-0 @else right-0 @endif top-full mt-2 w-48 bg-gray-800/95 backdrop-blur-lg rounded-xl border border-gray-600/50 shadow-2xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50">
                                <div class="p-2">
                                    @if(app()->getLocale() != 'en')
                                        <a href="{{ LaravelLocalization::getLocalizedURL('en', null, [], true) }}" 
                                           class="flex items-center @if(app()->getLocale() == 'ar') space-x-reverse @endif space-x-3 text-gray-200 hover:text-white hover:bg-accent-500/20 px-3 py-2 rounded-lg transition-all duration-300">
                                            <span class="w-6 text-center font-medium">EN</span>
                                            <span>English</span>
                                        </a>
                                    @endif
                                    @if(app()->getLocale() != 'ar')
                                        <a href="{{ LaravelLocalization::getLocalizedURL('ar', null, [], true) }}" 
                                           class="flex items-center @if(app()->getLocale() == 'ar') space-x-reverse @endif space-x-3 text-gray-200 hover:text-white hover:bg-accent-500/20 px-3 py-2 rounded-lg transition-all duration-300">
                                            <span class="w-6 text-center font-medium">AR</span>
                                            <span>العربية</span>
                                        </a>
                                    @endif
                                    @if(app()->getLocale() != 'fr')
                                        <a href="{{ LaravelLocalization::getLocalizedURL('fr', null, [], true) }}" 
                                           class="flex items-center @if(app()->getLocale() == 'ar') space-x-reverse @endif space-x-3 text-gray-200 hover:text-white hover:bg-accent-500/20 px-3 py-2 rounded-lg transition-all duration-300">
                                            <span class="w-6 text-center font-medium">FR</span>
                                            <span>Français</span>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Mobile Menu Toggle Button -->
                <div class="block lg:hidden">
                    <button class="flex flex-col justify-center items-center w-10 h-10 rounded-lg bg-accent-500/20 hover:bg-accent-500/30 transition-colors duration-300" 
                            id="mobileMenuToggle">
                        <span class="w-5 h-0.5 bg-white mb-1 transform transition-transform duration-300"></span>
                        <span class="w-5 h-0.5 bg-white mb-1 transition-opacity duration-300"></span>
                        <span class="w-5 h-0.5 bg-white transform transition-transform duration-300"></span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div class="lg:hidden hidden bg-gray-900/95 backdrop-blur-lg border-t border-gray-700/50 transform transition-all duration-300 ease-in-out" id="mobileMenu">
            <div class="px-4 sm:px-6 py-4 space-y-2">
                <a href="{{ route('home') }}" 
                   class="block text-gray-200 hover:text-accent-400 hover:bg-accent-500/10 py-3 px-4 rounded-lg transition-all duration-300 font-medium {{ request()->routeIs('home') ? 'text-accent-400 bg-accent-500/10' : '' }}">
                    {{ __('site.Home') }}
                </a>
                <a href="{{ route('about-us') }}" 
                   class="block text-gray-200 hover:text-accent-400 hover:bg-accent-500/10 py-3 px-4 rounded-lg transition-all duration-300 font-medium {{ request()->routeIs('about-us') ? 'text-accent-400 bg-accent-500/10' : '' }}">
                    {{ __('site.About Us') }}
                </a>
                <a href="{{ route('how-it-work') }}" 
                   class="block text-gray-200 hover:text-accent-400 hover:bg-accent-500/10 py-3 px-4 rounded-lg transition-all duration-300 font-medium {{ request()->routeIs('how-it-work') ? 'text-accent-400 bg-accent-500/10' : '' }}">
                    {{ __('site.How It Works') }}
                </a>
                <a href="{{ route('therapists') }}" 
                   class="block text-gray-200 hover:text-accent-400 hover:bg-accent-500/10 py-3 px-4 rounded-lg transition-all duration-300 font-medium {{ request()->routeIs('therapists') ? 'text-accent-400 bg-accent-500/10' : '' }}">
                    {{ __('site.Therapists') }}
                </a>
                <a href="{{ route('contact-us') }}" 
                   class="block text-gray-200 hover:text-accent-400 hover:bg-accent-500/10 py-3 px-4 rounded-lg transition-all duration-300 font-medium {{ request()->routeIs('contact-us') ? 'text-accent-400 bg-accent-500/10' : '' }}">
                    {{ __('site.Contact Us') }}
                </a>
                
                <!-- Mobile Language Options -->
                <div class="border-t border-gray-700/50 pt-4 mt-4">
                    <p class="text-gray-400 text-sm mb-3 px-4">{{ __('site.Language') }}</p>
                    <div class="space-y-2">
                        @if(app()->getLocale() != 'en')
                            <a href="{{ LaravelLocalization::getLocalizedURL('en', null, [], true) }}" 
                               class="block text-gray-200 hover:text-accent-400 hover:bg-accent-500/10 py-2 px-4 rounded-lg transition-all duration-300 font-medium">
                                English
                            </a>
                        @endif
                        @if(app()->getLocale() != 'ar')
                            <a href="{{ LaravelLocalization::getLocalizedURL('ar', null, [], true) }}" 
                               class="block text-gray-200 hover:text-accent-400 hover:bg-accent-500/10 py-2 px-4 rounded-lg transition-all duration-300 font-medium">
                                العربية
                            </a>
                        @endif
                        @if(app()->getLocale() != 'fr')
                            <a href="{{ LaravelLocalization::getLocalizedURL('fr', null, [], true) }}" 
                               class="block text-gray-200 hover:text-accent-400 hover:bg-accent-500/10 py-2 px-4 rounded-lg transition-all duration-300 font-medium">
                                Français
                            </a>
                        @endif
                    </div>
                </div>
                
                @guest
                    <a href="{{ route('login') }}" 
                       class="block w-full text-center px-6 py-3 text-white font-semibold rounded-xl
                              bg-gradient-to-r from-primary-500 to-primary-600 mt-4">
                        {{ __('site.Login') }}
                    </a>
                @else
                    <a href="{{ route('dashboard') }}" 
                       class="block w-full text-center px-6 py-3 text-white font-semibold rounded-xl
                              bg-gradient-to-r from-secondary-500 to-secondary-600 mt-4">
                        {{ __('site.Dashboard') }}
                    </a>
                @endguest
            </div>
        </div>
    </nav>

    <!-- Main Content Area -->
    <main id="main-content" role="main">
        @yield('content')
    </main>

    <!-- Sophisticated Footer -->
    <footer class="py-16 sm:py-20 lg:py-24 bg-gradient-to-br from-slate-900 via-blue-900 to-slate-800 relative overflow-hidden">
        <!-- Scientific Background Grid -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0" style="background-image: 
                linear-gradient(rgba(59, 130, 246, 0.2) 1px, transparent 1px),
                linear-gradient(90deg, rgba(59, 130, 246, 0.2) 1px, transparent 1px),
                linear-gradient(rgba(16, 185, 129, 0.1) 1px, transparent 1px),
                linear-gradient(90deg, rgba(16, 185, 129, 0.1) 1px, transparent 1px);
                background-size: 80px 80px, 80px 80px, 20px 20px, 20px 20px;">
            </div>
        </div>
        
        <!-- Floating Elements - Hidden on mobile for performance -->
        <div class="hidden sm:block absolute inset-0 overflow-hidden">
            <div class="absolute top-20 left-20 w-2 h-2 bg-blue-400 rounded-full animate-float opacity-40"></div>
            <div class="absolute top-32 right-32 w-3 h-3 bg-teal-400 rounded-full animate-float opacity-30" style="animation-delay: 2s;"></div>
            <div class="absolute bottom-32 left-40 w-2 h-2 bg-emerald-400 rounded-full animate-float opacity-50" style="animation-delay: 4s;"></div>
            <div class="absolute bottom-20 right-20 w-4 h-4 bg-cyan-400 rounded-full animate-float opacity-20" style="animation-delay: 1s;"></div>
        </div>
        
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Main Footer Content -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 sm:gap-12 lg:gap-16 mb-12 sm:mb-16 lg:mb-20">
                <!-- Company Brand Section -->
                <div class="sm:col-span-2 lg:col-span-1">
                    <div class="mb-6 sm:mb-8">
                        <h3 class="font-serif text-2xl sm:text-3xl lg:text-4xl font-bold text-white mb-4 sm:mb-6">
                            SAMAA
                        </h3>
                        <p class="text-slate-300 leading-relaxed text-sm sm:text-base mb-6 sm:mb-8">
                            {{ __('components/footer.company.description') }}  
                        </p>
                    </div>
                    
                    <!-- Elegant Social Links -->
                    <div class="flex space-x-4">
                        <a href="#" class="group w-10 h-10 sm:w-12 sm:h-12 bg-white/5 backdrop-blur-sm border border-white/10 rounded-xl flex items-center justify-center hover:bg-blue-500/20 hover:border-blue-400/30 transition-all duration-300" aria-label="Facebook">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-slate-300 group-hover:text-blue-300 transition-colors duration-300" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </a>
                        <a href="#" class="group w-10 h-10 sm:w-12 sm:h-12 bg-white/5 backdrop-blur-sm border border-white/10 rounded-xl flex items-center justify-center hover:bg-cyan-500/20 hover:border-cyan-400/30 transition-all duration-300" aria-label="Twitter">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-slate-300 group-hover:text-cyan-300 transition-colors duration-300" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                            </svg>
                        </a>
                        <a href="#" class="group w-10 h-10 sm:w-12 sm:h-12 bg-white/5 backdrop-blur-sm border border-white/10 rounded-xl flex items-center justify-center hover:bg-pink-500/20 hover:border-pink-400/30 transition-all duration-300" aria-label="Instagram">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-slate-300 group-hover:text-pink-300 transition-colors duration-300" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 6.62 5.367 11.987 11.988 11.987s11.987-5.367 11.987-11.987C24.014 5.367 18.647.001 12.017.001zM8.449 16.988c-1.297 0-2.348-1.051-2.348-2.348s1.051-2.348 2.348-2.348 2.348 1.051 2.348 2.348-1.051 2.348-2.348 2.348zm7.718 0c-1.297 0-2.348-1.051-2.348-2.348s1.051-2.348 2.348-2.348 2.348 1.051 2.348 2.348-1.051 2.348-2.348 2.348z"/>
                            </svg>
                        </a>
                        <a href="https://www.linkedin.com/showcase/samaa-dnci/about/?viewAsMember=true" target="_blank" rel="noopener noreferrer" class="group w-10 h-10 sm:w-12 sm:h-12 bg-white/5 backdrop-blur-sm border border-white/10 rounded-xl flex items-center justify-center hover:bg-blue-600/20 hover:border-blue-500/30 transition-all duration-300" aria-label="LinkedIn">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-slate-300 group-hover:text-blue-400 transition-colors duration-300" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                            </svg>
                        </a>
                        <a href="mailto:support@samaa.dnci.net" class="group w-10 h-10 sm:w-12 sm:h-12 bg-white/5 backdrop-blur-sm border border-white/10 rounded-xl flex items-center justify-center hover:bg-emerald-500/20 hover:border-emerald-400/30 transition-all duration-300" aria-label="Email">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-slate-300 group-hover:text-emerald-300 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="font-serif text-lg sm:text-xl lg:text-xl font-bold text-white mb-4 sm:mb-6">
                    {{ __('components/footer.navigation.quick_links') }}
                    </h4>
                    <ul class="space-y-3 sm:space-y-4">
                        <li><a href="{{ route('home') }}" class="text-slate-300 hover:text-blue-300 transition-colors duration-300 text-sm sm:text-base">{{ __('components/footer.navigation.home') }}</a></li>
                        <li><a href="{{ route('about-us') }}" class="text-slate-300 hover:text-blue-300 transition-colors duration-300 text-sm sm:text-base">{{ __('components/footer.navigation.about') }}</a></li>
                        <li><a href="{{ route('how-it-work') }}" class="text-slate-300 hover:text-blue-300 transition-colors duration-300 text-sm sm:text-base">{{ __('components/footer.navigation.how_it_works') }}</a></li>
                        <li><a href="{{ route('therapists') }}" class="text-slate-300 hover:text-blue-300 transition-colors duration-300 text-sm sm:text-base">{{ __('components/footer.navigation.therapists') }}</a></li>
                        <li><a href="{{ route('contact-us') }}" class="text-slate-300 hover:text-blue-300 transition-colors duration-300 text-sm sm:text-base">{{ __('components/footer.navigation.contact') }}</a></li>
                    </ul>
                </div>

                <!-- Clinical Services -->
                <div>
                    <h4 class="font-serif text-lg sm:text-xl lg:text-xl font-bold text-white mb-4 sm:mb-6">
                        {{ __('components/footer.navigation.clinical_services') }}
                    </h4>
                    <ul class="space-y-3 sm:space-y-4">
                        <li><a href="{{ route('therapy.index') }}" class="text-slate-300 hover:text-teal-300 transition-colors duration-300 text-sm sm:text-base">{{ __('components/footer.services.music_therapy') }}</a></li>
                        <li><a href="#" class="text-slate-300 hover:text-teal-300 transition-colors duration-300 text-sm sm:text-base">{{ __('components/footer.services.sound_healing') }}</a></li>
                        <li><a href="#" class="text-slate-300 hover:text-teal-300 transition-colors duration-300 text-sm sm:text-base">{{ __('components/footer.services.meditation') }}</a></li>
                        <li><a href="#" class="text-slate-300 hover:text-teal-300 transition-colors duration-300 text-sm sm:text-base">{{ __('components/footer.services.personalized_playlists') }}</a></li>
                        @auth
                           <li><a href="{{ route('playlist') }}" class="text-slate-300 hover:text-teal-300 transition-colors duration-300 text-sm sm:text-base">{{ __('components/footer.services.dashboard') }}</a></li>
                        @endauth
                    </ul>
                </div>

                <!-- Contact & Newsletter -->
                <div>
                    <h4 class="font-serif text-lg sm:text-xl lg:text-xl font-bold text-white mb-4 sm:mb-6">
                        {{ __('components/footer.navigation.contact') }}
                    </h4>
                    <ul class="space-y-3 sm:space-y-4 mb-6 sm:mb-8">
                        <li>
                            <a href="mailto:support@samaa.dnci.net" class="text-slate-300 hover:text-emerald-300 transition-colors duration-300 text-sm sm:text-base flex items-center">
                                <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                <span dir="ltr">support@samaa.dnci.net</span>
                            </a>
                        </li>
                        <li>
                            <a href="tel:+96105551511" class="text-slate-300 hover:text-emerald-300 transition-colors duration-300 text-sm sm:text-base flex items-center">
                                <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                                <span dir="ltr">+961 0 551 511</span>
                            </a>
                        </li>
                        <li class="text-slate-300 text-sm sm:text-base flex items-center">
                            <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            {{ __('components/footer.contact_info.address') }}
                        </li>
                    </ul>

                    <!-- Elegant Newsletter Signup -->
                    <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl p-4 sm:p-6">
                                        <h5 class="font-serif text-base sm:text-lg font-bold text-white mb-3 sm:mb-4">{{ __('components/footer.newsletter.title') }}</h5>
                        <form class="space-y-3">
                            <input type="email" class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-400/50 focus:border-blue-400/50 transition-all duration-300 text-sm sm:text-base" placeholder="{{ __('components/footer.newsletter.enter_email') }}" required>
                            <button type="submit" class="w-full px-4 py-3 bg-gradient-to-r from-blue-600 to-teal-600 text-white font-semibold rounded-xl text-sm sm:text-base hover:from-blue-700 hover:to-teal-700 transform hover:scale-[1.02] transition-all duration-300">
                                                {{ __('components/footer.newsletter.subscribe') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Footer Bottom -->
            <div class="pt-8 sm:pt-12 border-t border-white/10">
                <div class="flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0">
                    <div class="text-center sm:text-left">
                        <p class="text-slate-400 text-sm sm:text-base">
                           &copy; {{ date('Y') }} SAMAA. {{ __('components/footer.copyright.all_rights_reserved') }}
                        </p>
                        <p class="text-slate-400 text-sm mt-1">
                           {{ __('components/footer.company.made_with') }} <span class="text-blue-400">♪</span> {{ __('components/footer.company.for_healing') }}
                        </p>
                    </div>
                    
                    <!-- Professional Certifications -->
                    <div class="flex items-center space-x-4 sm:space-x-6 text-xs sm:text-sm text-slate-400">
                        <span class="tracking-widest uppercase">FDA Compliant</span>
                        <div class="w-1 h-1 bg-slate-400 rounded-full"></div>
                        <span class="tracking-widest uppercase">HIPAA Secure</span>
                        <div class="w-1 h-1 bg-slate-400 rounded-full"></div>
                        <span class="tracking-widest uppercase">ISO Certified</span>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    @if(session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: "{{ session('error') }}",
                background: 'var(--color-bg-primary)',
                color: 'var(--color-text-primary)'
            });
        </script>
    @endif

    @if(session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: "{{ session('success') }}",
                background: 'var(--color-bg-primary)',
                color: 'var(--color-text-primary)'
            });
        </script>
    @endif

    @routes

    <!-- Hidden logout form -->
    @auth
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
            @csrf
        </form>
    @endauth

    <!-- Enhanced JavaScript -->
    <script src="{{ asset('assets/js/frontend/ui-enhancements.js') }}" defer></script>
    
    <!-- Additional page-specific scripts -->
    @stack('scripts')

    <!-- Professional Interactive Music Letters CSS -->
    <style>
        .music-letter-pro {
            position: relative;
            display: inline-block;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            filter: drop-shadow(0 4px 8px rgba(0,0,0,0.3));
        }
        
        .music-letter-pro:hover {
            filter: drop-shadow(0 8px 25px currentColor) brightness(1.2);
            animation: professionalPulse 0.8s ease-in-out;
        }
        
        .music-letter-pro::after {
            content: attr(data-note);
            position: absolute;
            top: 100%;
            left: 50%;
            transform: translateX(-50%) translateY(10px);
            font-size: 0.6em;
            opacity: 0;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            pointer-events: none;
            color: currentColor;
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.5));
        }
        
        .music-letter-pro:hover::after {
            opacity: 0.8;
            transform: translateX(-50%) translateY(20px);
            animation: noteGlide 1.2s ease-out;
        }
        
        .flying-note {
            animation-duration: 4s;
            animation-iteration-count: infinite;
            animation-timing-function: ease-in-out;
            filter: drop-shadow(0 2px 8px rgba(0,0,0,0.3));
        }
        
        @keyframes professionalPulse {
            0%, 100% { 
                transform: scale(1); 
                filter: drop-shadow(0 4px 8px rgba(0,0,0,0.3)); 
            }
            50% { 
                transform: scale(1.1); 
                filter: drop-shadow(0 8px 25px currentColor) brightness(1.3);
            }
        }
        
        @keyframes noteGlide {
            0% { 
                transform: translateX(-50%) translateY(10px) scale(0.5); 
                opacity: 0; 
            }
            30% { 
                transform: translateX(-50%) translateY(20px) scale(1); 
                opacity: 0.8; 
            }
            70% { 
                transform: translateX(-50%) translateY(35px) scale(1.2); 
                opacity: 0.6; 
            }
            100% { 
                transform: translateX(-50%) translateY(50px) scale(0.8); 
                opacity: 0; 
            }
        }
        
        @keyframes float {
            0%, 100% { 
                transform: translateY(0px) rotate(0deg); 
                opacity: 0.6; 
            }
            25% { 
                transform: translateY(-15px) rotate(5deg); 
                opacity: 0.8; 
            }
            50% { 
                transform: translateY(-25px) rotate(0deg); 
                opacity: 1; 
            }
            75% { 
                transform: translateY(-15px) rotate(-5deg); 
                opacity: 0.8; 
            }
        }
        
        /* Professional hero text enhancements */
        .hero h1 {
            background: linear-gradient(135deg, rgba(255,255,255,0.9) 0%, rgba(255,255,255,0.7) 100%);
            -webkit-background-clip: text;
            background-clip: text;
            position: relative;
        }
        
        .hero h1::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, transparent 30%, rgba(255,255,255,0.1) 50%, transparent 70%);
            background-size: 200% 200%;
            animation: textShimmer 4s ease-in-out infinite;
            pointer-events: none;
        }
        
        @keyframes textShimmer {
            0%, 100% { background-position: 0% 50%; opacity: 0; }
            50% { background-position: 100% 50%; opacity: 0.3; }
        }
        
        /* Advanced particle and lighting effects */
        .particle-note {
            filter: drop-shadow(0 0 10px currentColor);
            animation-name: float, twinkle;
            animation-iteration-count: infinite;
            animation-timing-function: ease-in-out;
        }
        
        @keyframes twinkle {
            0%, 100% { opacity: 0.2; transform: scale(1); }
            50% { opacity: 0.8; transform: scale(1.2); }
        }
        
        /* Gradient radial utility */
        .bg-gradient-radial {
            background: radial-gradient(circle, var(--tw-gradient-stops));
        }
        
        /* Enhanced flying notes */
        .flying-note {
            position: relative;
            animation-name: float, sparkle, drift;
            animation-iteration-count: infinite;
            animation-timing-function: ease-in-out;
        }
        
        @keyframes sparkle {
            0%, 100% { 
                filter: drop-shadow(0 0 5px currentColor) brightness(1);
                transform: scale(1);
            }
            33% { 
                filter: drop-shadow(0 0 15px currentColor) brightness(1.3);
                transform: scale(1.1);
            }
            66% { 
                filter: drop-shadow(0 0 10px currentColor) brightness(1.1);
                transform: scale(1.05);
            }
        }
        
        @keyframes drift {
            0% { transform: translateX(0px); }
            25% { transform: translateX(10px); }
            50% { transform: translateX(-5px); }
            75% { transform: translateX(8px); }
            100% { transform: translateX(0px); }
        }
        
        /* Professional music letter enhancements */
        .music-letter-pro {
            position: relative;
            overflow: visible;
        }
        
        .music-letter-pro:hover {
            animation: letterDance 0.8s ease-in-out;
        }
        
        @keyframes letterDance {
            0%, 100% { 
                transform: scale(1) rotate(0deg); 
                filter: drop-shadow(0 4px 8px rgba(0,0,0,0.3)); 
            }
            25% { 
                transform: scale(1.1) rotate(2deg); 
                filter: drop-shadow(0 8px 25px currentColor) brightness(1.3);
            }
            50% { 
                transform: scale(1.15) rotate(-1deg); 
                filter: drop-shadow(0 12px 35px currentColor) brightness(1.5);
            }
            75% { 
                transform: scale(1.1) rotate(1deg); 
                filter: drop-shadow(0 8px 25px currentColor) brightness(1.3);
            }
        }
        
        /* Professional Hero Section */
        .hero {
            position: relative;
        }
        
        /* Professional music letter styling */
        .music-letter-pro {
            position: relative;
            display: inline-block;
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            filter: drop-shadow(0 4px 12px rgba(0,0,0,0.4));
        }
        
        .music-letter-pro:hover {
            filter: drop-shadow(0 8px 25px currentColor) drop-shadow(0 4px 12px rgba(0,0,0,0.4)) brightness(1.2);
            animation: professionalGlow 0.8s ease-in-out;
        }
        
        @keyframes professionalGlow {
            0%, 100% { 
                transform: scale(1); 
                filter: drop-shadow(0 4px 12px rgba(0,0,0,0.4)); 
            }
            50% { 
                transform: scale(1.1); 
                filter: drop-shadow(0 12px 30px currentColor) drop-shadow(0 8px 20px rgba(0,0,0,0.6)) brightness(1.3);
            }
        }
        
        /* AMAZING Flying Symbol Animations */
        .flying-symbol {
            filter: drop-shadow(0 0 10px currentColor);
        }
        
        .flying-diagonal {
            filter: drop-shadow(0 0 15px currentColor);
        }
        
        .flying-spiral {
            filter: drop-shadow(0 0 12px currentColor);
        }
        
        /* Horizontal flying across screen */
        @keyframes flyAcross {
            0% { 
                transform: translateX(-100px) translateY(20vh) rotate(0deg) scale(0.8); 
                opacity: 0; 
            }
            10% { 
                opacity: 0.4; 
                transform: translateX(0px) translateY(20vh) rotate(45deg) scale(1); 
            }
            50% { 
                transform: translateX(50vw) translateY(15vh) rotate(180deg) scale(1.2); 
                opacity: 0.6; 
            }
            90% { 
                opacity: 0.4; 
                transform: translateX(100vw) translateY(25vh) rotate(315deg) scale(1); 
            }
            100% { 
                transform: translateX(calc(100vw + 100px)) translateY(25vh) rotate(360deg) scale(0.8); 
                opacity: 0; 
            }
        }
        
        /* Diagonal flying animation */
        @keyframes flyDiagonal {
            0% { 
                transform: translateX(-100px) translateY(100vh) rotate(0deg) scale(0.6); 
                opacity: 0; 
            }
            15% { 
                opacity: 0.3; 
                transform: translateX(10vw) translateY(80vh) rotate(90deg) scale(1); 
            }
            50% { 
                transform: translateX(50vw) translateY(30vh) rotate(180deg) scale(1.4); 
                opacity: 0.5; 
            }
            85% { 
                opacity: 0.3; 
                transform: translateX(90vw) translateY(10vh) rotate(270deg) scale(1); 
            }
            100% { 
                transform: translateX(calc(100vw + 100px)) translateY(-100px) rotate(360deg) scale(0.6); 
                opacity: 0; 
            }
        }
        
        /* Spiral flying animation */
        @keyframes flySpiral {
            0% { 
                transform: translateX(50vw) translateY(50vh) rotate(0deg) scale(0.5); 
                opacity: 0; 
            }
            25% { 
                transform: translateX(calc(50vw + 200px)) translateY(calc(50vh - 200px)) rotate(90deg) scale(1.2); 
                opacity: 0.4; 
            }
            50% { 
                transform: translateX(calc(50vw - 200px)) translateY(calc(50vh - 400px)) rotate(180deg) scale(1.5); 
                opacity: 0.6; 
            }
            75% { 
                transform: translateX(calc(50vw - 400px)) translateY(calc(50vh - 200px)) rotate(270deg) scale(1.2); 
                opacity: 0.4; 
            }
            100% { 
                transform: translateX(50vw) translateY(50vh) rotate(360deg) scale(0.5); 
                opacity: 0; 
            }
        }
        
        /* Floating animation for static particles */
        @keyframes float {
            0%, 100% { 
                transform: translateY(0px) rotate(0deg); 
                opacity: 0.05; 
            }
            50% { 
                transform: translateY(-20px) rotate(180deg); 
                opacity: 0.15; 
            }
        }
        
        /* Particle burst effects */
        .particle-burst {
            width: 100px;
            height: 100px;
        }
        
        /* Enhanced visual effects for letters */
        .music-letter-pro:active {
            transform: scale(1.3) rotate(10deg);
            filter: drop-shadow(0 0 40px currentColor) brightness(1.5);
        }
        
        /* Beautiful floating symbols under "Hear to Heal" */
        .floating-symbol {
            display: inline-block;
            filter: drop-shadow(0 0 10px currentColor);
        }
        
        @keyframes gentleFloat {
            0%, 100% { 
                transform: translateY(0px) translateX(0px) rotate(0deg) scale(1); 
                opacity: 0.7; 
            }
            25% { 
                transform: translateY(-15px) translateX(5px) rotate(10deg) scale(1.1); 
                opacity: 0.9; 
            }
            50% { 
                transform: translateY(-25px) translateX(-3px) rotate(-5deg) scale(1.2); 
                opacity: 1; 
            }
            75% { 
                transform: translateY(-10px) translateX(8px) rotate(15deg) scale(1.05); 
                opacity: 0.8; 
            }
        }
    </style>

    <!-- Initialize SAMAA UI -->
    <script>
        // Advanced Audio Context for Amazing Music Notes
        let audioContext;
        let musicNotes = {};
        let masterGain;
        
        // Initialize amazing audio system
        function initAudio() {
            if (!audioContext) {
                audioContext = new (window.AudioContext || window.webkitAudioContext)();
                
                // Create master gain for volume control
                masterGain = audioContext.createGain();
                masterGain.connect(audioContext.destination);
                masterGain.gain.setValueAtTime(0.4, audioContext.currentTime);
                
                // Amazing musical notes with rich harmonics
                const noteFrequencies = {
                    'note-c': { fundamental: 261.63, harmonics: [523.25, 784.88] },   // C4 with octaves
                    'note-d': { fundamental: 293.66, harmonics: [587.33, 880.00] },   // D4 with octaves
                    'note-e': { fundamental: 329.63, harmonics: [659.25, 988.88] },   // E4 with octaves
                    'note-f': { fundamental: 349.23, harmonics: [698.46, 1047.69] },  // F4 with octaves
                    'note-g': { fundamental: 392.00, harmonics: [784.00, 1176.00] },  // G4 with octaves
                    'note-a': { fundamental: 440.00, harmonics: [880.00, 1320.00] },  // A4 with octaves
                    'note-b': { fundamental: 493.88, harmonics: [987.77, 1481.65] },  // B4 with octaves
                    'note-c2': { fundamental: 523.25, harmonics: [1046.50, 1569.75] } // C5 with octaves
                };
                
                musicNotes = noteFrequencies;
            }
        }
        
        // Play amazing rich musical note with harmonics
        function playAmazingNote(noteData, duration = 1.2, volume = 0.3) {
            if (!audioContext || !noteData) return;
            
            const now = audioContext.currentTime;
            
            // Create fundamental frequency
            const fundamental = audioContext.createOscillator();
            const fundamentalGain = audioContext.createGain();
            
            fundamental.connect(fundamentalGain);
            fundamentalGain.connect(masterGain);
            
            fundamental.frequency.setValueAtTime(noteData.fundamental, now);
            fundamental.type = 'sine';
            
            // Create harmonics for rich sound
            const harmonics = noteData.harmonics.map((freq, index) => {
                const osc = audioContext.createOscillator();
                const gain = audioContext.createGain();
                
                osc.connect(gain);
                gain.connect(masterGain);
                
                osc.frequency.setValueAtTime(freq, now);
                osc.type = 'sine';
                
                // Diminishing volume for harmonics
                const harmVolume = volume / (index + 2);
                gain.gain.setValueAtTime(harmVolume, now);
                gain.gain.exponentialRampToValueAtTime(0.001, now + duration);
                
                return { osc, gain };
            });
            
            // Envelope for fundamental
            fundamentalGain.gain.setValueAtTime(0, now);
            fundamentalGain.gain.linearRampToValueAtTime(volume, now + 0.1);
            fundamentalGain.gain.exponentialRampToValueAtTime(volume * 0.7, now + duration * 0.3);
            fundamentalGain.gain.exponentialRampToValueAtTime(0.001, now + duration);
            
            // Start all oscillators
            fundamental.start(now);
            fundamental.stop(now + duration);
            
            harmonics.forEach(({ osc }) => {
                osc.start(now);
                osc.stop(now + duration);
            });
            
            // Add reverb effect
            const convolver = audioContext.createConvolver();
            const reverbGain = audioContext.createGain();
            
            fundamentalGain.connect(reverbGain);
            reverbGain.connect(convolver);
            convolver.connect(masterGain);
            
            reverbGain.gain.setValueAtTime(0.2, now);
        }
        
        // Create magical chord progression
        function playMagicalChord() {
            if (!audioContext) return;
            
            const chordNotes = [
                musicNotes['note-c'],
                musicNotes['note-e'], 
                musicNotes['note-g']
            ];
            
            chordNotes.forEach((note, index) => {
                setTimeout(() => {
                    playAmazingNote(note, 2.0, 0.15);
                }, index * 100);
            });
        }

        // Additional custom initialization can go here
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize audio on first click
            document.addEventListener('click', initAudio, { once: true });
            
            // Add amazing interactive handlers to music letters
            document.querySelectorAll('.music-letter-pro').forEach((letter, index) => {
                letter.addEventListener('click', function() {
                    const soundNote = this.getAttribute('data-sound');
                    if (musicNotes[soundNote]) {
                        // Play rich note with harmonics
                        playAmazingNote(musicNotes[soundNote], 1.5, 0.4);
                        
                        // Amazing visual feedback
                        this.style.transform = 'scale(1.4) rotate(5deg)';
                        this.style.filter = 'drop-shadow(0 0 30px currentColor) brightness(1.5)';
                        
                        // Create ripple effect
                        const ripple = document.createElement('div');
                        ripple.className = 'absolute inset-0 rounded-full border-2 border-current animate-ping';
                        ripple.style.borderColor = getComputedStyle(this).color;
                        this.appendChild(ripple);
                        
                        setTimeout(() => {
                            this.style.transform = '';
                            this.style.filter = '';
                            if (ripple.parentNode) ripple.remove();
                        }, 600);
                        
                        // Trigger particle explosion
                        createParticleExplosion(this);
                    }
                });
                
                // Enhanced hover with preview sound
                letter.addEventListener('mouseenter', function() {
                    const soundNote = this.getAttribute('data-sound');
                    if (musicNotes[soundNote] && audioContext) {
                        // Play softer preview note
                        playAmazingNote(musicNotes[soundNote], 0.6, 0.15);
                        
                        // Gentle glow effect
                        this.style.filter = 'drop-shadow(0 0 20px currentColor) brightness(1.3)';
                    }
                });
                
                letter.addEventListener('mouseleave', function() {
                    this.style.filter = '';
                });
            });
            
            // Create particle explosion effect
            function createParticleExplosion(element) {
                const rect = element.getBoundingClientRect();
                const centerX = rect.left + rect.width / 2;
                const centerY = rect.top + rect.height / 2;
                
                for (let i = 0; i < 8; i++) {
                    const particle = document.createElement('div');
                    particle.innerHTML = ['♪', '♫', '♬', '♩'][Math.floor(Math.random() * 4)];
                    particle.className = 'fixed pointer-events-none z-50 text-2xl';
                    particle.style.left = centerX + 'px';
                    particle.style.top = centerY + 'px';
                    particle.style.color = getComputedStyle(element).color;
                    particle.style.textShadow = '0 0 10px currentColor';
                    
                    document.body.appendChild(particle);
                    
                    const angle = (i / 8) * Math.PI * 2;
                    const distance = 100 + Math.random() * 50;
                    const endX = centerX + Math.cos(angle) * distance;
                    const endY = centerY + Math.sin(angle) * distance;
                    
                    particle.animate([
                        { transform: 'translate(-50%, -50%) scale(0) rotate(0deg)', opacity: 1 },
                        { transform: `translate(${endX - centerX}px, ${endY - centerY}px) scale(1.5) rotate(360deg)`, opacity: 0 }
                    ], {
                        duration: 1000,
                        easing: 'cubic-bezier(0.25, 0.46, 0.45, 0.94)'
                    }).onfinish = () => particle.remove();
                }
            }
            
            // Add magical chord on title click
            const titleElement = document.querySelector('.interactive-title h1');
            if (titleElement) {
                titleElement.addEventListener('click', function() {
                    playMagicalChord();
                    
                    // Visual feedback for entire title
                    this.style.transform = 'scale(1.05)';
                    this.style.filter = 'drop-shadow(0 0 50px rgba(255,255,255,0.8))';
                    
                    // Trigger spectacular visual effects
                    createSpectacularBurst();
                
                    setTimeout(() => {
                        this.style.transform = '';
                        this.style.filter = '';
                    }, 800);
                });
            }
            
            // Create spectacular visual burst effect
            function createSpectacularBurst() {
                const colors = ['#ef4444', '#f97316', '#eab308', '#10b981', '#06b6d4', '#3b82f6', '#8b5cf6', '#ec4899'];
                const symbols = ['♪', '♫', '♬', '♩', '𝄞'];
                
                // Create 20 flying particles
                for (let i = 0; i < 20; i++) {
                    const particle = document.createElement('div');
                    particle.innerHTML = symbols[Math.floor(Math.random() * symbols.length)];
                    particle.className = 'fixed pointer-events-none z-50 text-4xl';
                    particle.style.left = '50vw';
                    particle.style.top = '50vh';
                    particle.style.color = colors[Math.floor(Math.random() * colors.length)];
                    particle.style.textShadow = '0 0 20px currentColor';
                    
                    document.body.appendChild(particle);
                    
                    const angle = (i / 20) * Math.PI * 2;
                    const distance = 200 + Math.random() * 300;
                    const endX = Math.cos(angle) * distance;
                    const endY = Math.sin(angle) * distance;
                    
                    particle.animate([
                        { 
                            transform: 'translate(-50%, -50%) scale(0) rotate(0deg)', 
                            opacity: 1,
                            filter: 'drop-shadow(0 0 10px currentColor)'
                        },
                        { 
                            transform: `translate(${endX}px, ${endY}px) scale(2) rotate(720deg)`, 
                            opacity: 0,
                            filter: 'drop-shadow(0 0 30px currentColor)'
                        }
                    ], {
                        duration: 2000 + Math.random() * 1000,
                        easing: 'cubic-bezier(0.25, 0.46, 0.45, 0.94)'
                    }).onfinish = () => particle.remove();
                }
            }
            
            // Create continuous particle streams
            function createParticleStream() {
                const symbols = ['♪', '♫', '♬', '♩', '𝄞'];
                const colors = ['#fbbf24', '#ec4899', '#06b6d4', '#10b981', '#8b5cf6'];
                
                setInterval(() => {
                    if (Math.random() > 0.7) { // 30% chance every interval
                        const particle = document.createElement('div');
                        particle.innerHTML = symbols[Math.floor(Math.random() * symbols.length)];
                        particle.className = 'fixed pointer-events-none z-40 text-2xl';
                        particle.style.left = Math.random() * 100 + 'vw';
                        particle.style.top = '100vh';
                        particle.style.color = colors[Math.floor(Math.random() * colors.length)];
                        particle.style.textShadow = '0 0 15px currentColor';
                        
                        document.body.appendChild(particle);
                        
                        particle.animate([
                            { 
                                transform: 'translateY(0px) rotate(0deg) scale(0.5)', 
                                opacity: 0.3 
                            },
                            { 
                                transform: 'translateY(-100vh) rotate(360deg) scale(1.2)', 
                                opacity: 0 
                            }
                        ], {
                            duration: 8000 + Math.random() * 4000,
                            easing: 'linear'
                        }).onfinish = () => particle.remove();
                    }
                }, 1000);
            }
            
            // Start particle streams after page load
            setTimeout(createParticleStream, 3000);
            // Add data-animate attributes to elements for scroll animations
            document.querySelectorAll('.card, .feature-card, .therapist-card, .contact-item').forEach((el, index) => {
                if (!el.dataset.animate) {
                    el.dataset.animate = 'fade-in-up';
                    el.dataset.delay = (index * 100).toString();
                }
            });

            // Enhanced form handling
            document.querySelectorAll('form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    const submitBtn = this.querySelector('[type="submit"]');
                    if (submitBtn) {
                        submitBtn.classList.add('loading');
                        submitBtn.textContent = '{{ __("site.Loading...") }}';
                    }
                });
            });
        });
    </script>
</body>
</html>

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

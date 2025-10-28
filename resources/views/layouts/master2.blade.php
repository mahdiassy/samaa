<!DOCTYPE html>
<html dir="{{ App::isLocale('ar') ? 'rtl' : 'ltr' }}" lang="{{ app()->getLocale() }}">

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
    <link href="https://fonts.googleapis.com/css2?family=Montserrat+Alternates:wght@500&family=Roboto:wght@400;800&display=swap" rel="stylesheet">
    
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Trumbowyg CSS for Rich Text Editor -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/trumbowyg@2.27.3/dist/ui/trumbowyg.min.css">

    <!-- Dashboard styles - Load early so page-specific styles can override -->
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard/style.css') }}">

    <!-- SAMAA Admin Panel - Organized CSS Structure -->
    <link rel="stylesheet" href="{{ asset('assets/css/admin/admin-core.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/admin/admin-components.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/admin/admin-layout.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/admin/admin-pages.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/admin/admin-responsive.css') }}">
    
    <!-- Unified Admin Pages Styling - Load First for Consistency -->
    <link rel="stylesheet" href="{{ asset('assets/css/admin/admin-pages-unified.css') }}">
    
    <!-- Individual Management Pages -->
    <link rel="stylesheet" href="{{ asset('assets/css/admin/patient-management.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/admin/doctor-management-page.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/admin/blog-management-page.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/admin/therapy-management-page.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/admin/feedback-management-page.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/admin/feedback-list-page.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/admin/appointment-management-page.css') }}">
    
    <!-- Additional UI Improvements -->
    <style>
        /* Modern Sidebar Design */
        .modern-sidebar {
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            width: 240px !important;
            height: 100vh !important;
            background: linear-gradient(180deg, #1e293b 0%, #0f172a 100%) !important;
            border-right: none !important;
            z-index: 1000 !important;
            display: flex !important;
            flex-direction: column !important;
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.1) !important;
            transition: all 0.3s ease !important;
        }

        /* User Profile Section */
        .user-profile-section {
            padding: 1.5rem 1.25rem !important;
            border-bottom: none !important;
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
            text-align: center !important;
        }

        .user-avatar {
            margin-bottom: 1rem !important;
        }

        .user-avatar img {
            width: 50px !important;
            height: 50px !important;
            border-radius: 50% !important;
            border: 3px solid #3b82f6 !important;
            object-fit: cover !important;
        }

        .avatar-placeholder {
            width: 50px !important;
            height: 50px !important;
            border-radius: 50% !important;
            background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%) !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            color: white !important;
            font-weight: 600 !important;
            font-size: 1.125rem !important;
            text-transform: uppercase !important;
        }

        .user-info h3 {
            color: #f8fafc !important;
            font-size: 1rem !important;
            font-weight: 600 !important;
            margin: 0 0 0.25rem 0 !important;
        }

        .user-role {
            color: #94a3b8 !important;
            font-size: 0.75rem !important;
            font-weight: 500 !important;
            text-transform: uppercase !important;
            letter-spacing: 0.05em !important;
        }

        /* Navigation */
        .sidebar-navigation {
            flex: 1 !important;
            padding: 1rem 0 !important;
            overflow-y: auto !important;
        }

        .nav-menu {
            list-style: none !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        .nav-menu li {
            margin: 0 !important;
        }

        .nav-link {
            display: flex !important;
            align-items: center !important;
            padding: 0.75rem 1.25rem !important;
            color: #cbd5e1 !important;
            text-decoration: none !important;
            transition: all 0.3s ease !important;
            border-left: 3px solid transparent !important;
        }

        .nav-link:hover {
            background: rgba(59, 130, 246, 0.1) !important;
            color: #3b82f6 !important;
            border-left-color: #3b82f6 !important;
            text-decoration: none !important;
            transform: translateX(4px) !important;
        }

        .nav-link.active {
            background: rgba(59, 130, 246, 0.15) !important;
            color: #3b82f6 !important;
            border-left-color: #3b82f6 !important;
            font-weight: 600 !important;
        }

        .nav-icon {
            width: 18px !important;
            height: 18px !important;
            margin-right: 0.75rem !important;
            flex-shrink: 0 !important;
        }
        }

        .nav-icon svg {
            width: 100% !important;
            height: 100% !important;
            fill: currentColor !important;
        }

        .nav-text {
            font-size: 0.8rem !important;
            font-weight: 500 !important;
        }

        /* Sidebar Footer */
        .sidebar-footer {
            padding: 1rem 0 !important;
            border-top: none !important;
        }

        .logout-link {
            display: flex !important;
            align-items: center !important;
            padding: 0.75rem 1.25rem !important;
            color: #f87171 !important;
            text-decoration: none !important;
            transition: all 0.3s ease !important;
            border-left: 3px solid transparent !important;
        }

        .logout-link:hover {
            background: rgba(248, 113, 113, 0.1) !important;
            border-left-color: #f87171 !important;
            text-decoration: none !important;
            color: #f87171 !important;
            transform: translateX(4px) !important;
        }

        /* Admin Layout Container */
        .admin-layout {
            display: flex !important;
            min-height: 100vh !important;
        }

        /* Content wrapper adjustments - Full Width Layout */
        .admin-content-wrapper {
            flex: 1 !important;
            margin-left: 240px !important;
            /* Reduce left padding to minimize gap between sidebar and content */
            padding: 20px 20px 20px 8px !important;
            min-height: 100vh !important;
            width: calc(100% - 240px) !important;
            box-sizing: border-box !important;
            display: flex !important;
            justify-content: flex-start !important;
            align-items: flex-start !important;
        }

        /* Remove old sidebar styles */
        .sidebar {
            border-radius: 0 !important;
        }

        /* Improve admin content */
        .admin-main {
            border-radius: 12px !important;
            box-shadow: none !important;
            width: 100% !important;
            margin: 0 !important;
        }

        /* Responsive Design - Flexible Layout */
        @media (max-width: 1024px) {
            .modern-sidebar {
                width: 200px !important;
            }
            
            .admin-content-wrapper {
                margin-left: 200px !important;
                /* Match desktop: smaller left padding to keep content closer to sidebar */
                padding: 15px 15px 15px 8px !important;
                width: calc(100% - 200px) !important;
            }
        }

        @media (max-width: 768px) {
            .modern-sidebar {
                width: 240px !important;
                transform: translateX(-100%) !important;
                transition: transform 0.3s ease !important;
                position: fixed !important;
                z-index: 1001 !important;
            }
            
            .modern-sidebar.show {
                transform: translateX(0) !important;
            }
            
            .admin-content-wrapper {
                margin-left: 0 !important;
                padding: 10px !important;
                width: 100% !important;
            }
            
            /* Mobile menu toggle */
            .mobile-menu-toggle {
                display: block !important;
                position: fixed !important;
                top: 20px !important;
                left: 20px !important;
                z-index: 1002 !important;
                background: #1e293b !important;
                color: white !important;
                border: none !important;
                padding: 8px 12px !important;
                border-radius: 6px !important;
                cursor: pointer !important;
            }
        }

        @media (min-width: 769px) {
            .mobile-menu-toggle {
                display: none !important;
            }
        }
    </style>

    <!-- Trumbowyg JS -->
    <script src="https://cdn.jsdelivr.net/npm/trumbowyg@2.27.3/dist/trumbowyg.min.js"></script>

    <!-- Page Specific Styles -->
    @stack('styles')

</head>

<body class="admin-panel">
    <!-- Admin Layout Container -->
    <div class="admin-layout">

    <!-- Mobile Menu Toggle (hidden on desktop) -->
    <button class="mobile-menu-toggle" onclick="toggleSidebar()">
        <i class="fas fa-bars"></i>
    </button>

    <div id="sidebar" class="sidebar modern-sidebar">
        <!-- User Profile Section -->
        <div class="user-profile-section">
            @if(Auth::check() && Auth::user()->hasRole('Patient'))
                <div class="user-avatar">
                    @if(Auth::check() && Auth::user()->patient && Auth::user()->patient->image)
                        <img src="{{ asset('storage/' . Auth::user()->patient->image) }}" alt="Profile">
                    @else
                        <div class="avatar-placeholder">
                            {{ substr(Auth::user()->patient->first_name, 0, 1) }}{{ substr(Auth::user()->patient->last_name, 0, 1) }}
                        </div>
                    @endif
                </div>
                <div class="user-info">
                    <h3>{{ Auth::user()->patient->first_name }} {{ Auth::user()->patient->last_name }}</h3>
                    <span class="user-role">Patient</span>
                </div>
            @elseif(Auth::check() && Auth::user()->hasRole('Doctor'))
                <div class="user-avatar">
                    @if(Auth::check() && Auth::user()->doctor && Auth::user()->doctor->image)
                        <img src="{{ asset('storage/' . Auth::user()->doctor->image) }}" alt="Profile">
                    @else
                        <div class="avatar-placeholder">
                            {{ substr(Auth::user()->doctor->first_name, 0, 1) }}{{ substr(Auth::user()->doctor->last_name, 0, 1) }}
                        </div>
                    @endif
                </div>
                <div class="user-info">
                    <h3>{{ Auth::user()->doctor->first_name }} {{ Auth::user()->doctor->last_name }}</h3>
                    <span class="user-role">Doctor</span>
                </div>
            @elseif(Auth::check() && Auth::user()->hasRole('Admin'))
                <div class="user-avatar">
                    <div class="avatar-placeholder">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                </div>
                <div class="user-info">
                    <h3>{{ Auth::user()->name }}</h3>
                    <span class="user-role">Admin</span>
                </div>
            @endif
        </div>

        <!-- Navigation Menu -->
        <nav class="sidebar-navigation">
            <ul class="nav-menu">
                <li>
                    <a href="{{ route('dashboard') }}" class="nav-link">
                        <div class="nav-icon">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M3 13h1v7c0 1.1.9 2 2 2h3v-8h6v8h3c1.1 0 2-.9 2-2v-7h1s.8-.4.8-1.1c0-.3-.1-.5-.3-.7L12.5 3c-.6-.5-1.5-.5-2.1 0L1.3 11.2c-.2.2-.3.4-.3.7 0 .7.8 1.1.8 1.1z"/>
                            </svg>
                        </div>
                        <span class="nav-text">{{ __('site.Home') }}</span>
                    </a>
                </li>
                @role('Doctor')
                    <li>
                        <a href="{{ route('doctors.booking.index') }}" class="nav-link">
                            <div class="nav-icon">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-2 6h-5v5h5V9z"/>
                                </svg>
                            </div>
                            <span class="nav-text">{{ __('site.Patients Booking') }}</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('doctors.calendar') }}" class="nav-link">
                            <div class="nav-icon">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M20 3h-1V1h-2v2H7V1H5v2H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM4 7h16v2H4V7z"/>
                                </svg>
                            </div>
                            <span class="nav-text">{{ __('site.Schedule') }}</span>
                        </a>
                    </li>
                @endrole
                @role('Patient')
                    <li>
                        <a href="{{ route('patients.booking.index') }}" class="nav-link">
                            <div class="nav-icon">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-2 6h-5v5h5V9z"/>
                                </svg>
                            </div>
                            <span class="nav-text">{{ __('site.My Bookings') }}</span>
                        </a>
                    </li>
                @endrole
                @role('Admin|Doctor')
                    <li>
                        <a href="{{ route('patient.index') }}" class="nav-link">
                            <div class="nav-icon">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M16 4c0-1.11.89-2 2-2s2 .89 2 2-.89 2-2 2-2-.89-2-2zm4 18v-6h2.5l-2.54-7.63A3 3 0 0 0 17.04 6H16c-.8 0-1.54.37-2.01.97L12 9.5 9.01 6.97A2.5 2.5 0 0 0 7 6H5.96c-1.29 0-2.4.82-2.82 2.01L1 16h2.5v6h2v-6h2.5v6h2v-6h2.5v6h2z"/>
                                </svg>
                            </div>
                            <span class="nav-text">{{ __('site.Patient list') }}</span>
                        </a>
                    </li>
                @endrole
                @role('Admin|Doctor|Patient')
                    <li>
                        <a href="{{ route('doctor.index') }}" class="nav-link">
                            <div class="nav-icon">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 2c1.1 0 2 .9 2 2s-.9 2-2 2-2-.9-2-2 .9-2 2-2zm9 7h-6v13h-2v-6h-2v6H9V9H3V7h18v2z"/>
                                </svg>
                            </div>
                            <span class="nav-text">{{ __('site.Doctor list') }}</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('therapy.index') }}" class="nav-link">
                            <div class="nav-icon">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                </svg>
                            </div>
                            <span class="nav-text">{{ __('site.therapy') }}</span>
                        </a>
                    </li>
                @endrole
                @role('Doctor|Patient')
                <li>
                    <a href="{{ route('feedback') }}" class="nav-link">
                        <div class="nav-icon">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                            </svg>
                        </div>
                        <span class="nav-text">{{ __('site.Add Feedback') }}</span>
                    </a>
                </li>
                @endrole
                @role('Admin')
                    <li>
                        <a href="{{ route('blog.list') }}" class="nav-link">
                            <div class="nav-icon">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z"/>
                                </svg>
                            </div>
                            <span class="nav-text">{{ __('site.Blog list') }}</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('feedback-list') }}" class="nav-link">
                            <div class="nav-icon">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                                </svg>
                            </div>
                            <span class="nav-text">{{ __('site.Feedback') }}</span>
                        </a>
                    </li>
                @endrole
                <li>
                    <a href="{{ route('changePassword') }}" class="nav-link">
                        <div class="nav-icon">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/>
                            </svg>
                        </div>
                        <span class="nav-text">{{ __('site.change password') }}</span>
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Logout Section -->
        <div class="sidebar-footer">
            @if(Auth::check())
                <a href="#" class="logout-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <div class="nav-icon">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.59L17 17l5-5zM4 5h8V3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4V5z"/>
                        </svg>
                    </div>
                    <span class="nav-text">{{ __('site.Logout') }}</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            @endif
        </div>
    </div>

    <!-- SAMAA Admin Content Wrapper - Full Width Layout -->
    <div class="admin-content-wrapper">
        
        <!-- Admin Main Content -->
        <main class="admin-main" style="padding: 0; background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); min-height: calc(100vh - 40px); border-radius: 12px;">`
            @if(session('status'))
                <script>
                    Swal.fire({
                        icon: {!! json_encode(session('status')['type']) !!},
                        title: {!! json_encode(session('status')['title']) !!},
                        text: {!! json_encode(session('status')['msg']) !!},
                        confirmButtonText: {!! json_encode(__('site.OK')) !!}
                    });
                </script>
            @endif

            @routes
            @yield('content')
        </main>
    </div>

    <!-- Closing admin-layout div -->
    </div>
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

    <script>
        $(document).ready(function () {
            $('.diseases-select-backend').select2({
                placeholder: "{{ __('site.Select one or more diseases') }}",
                width: '100%'
            });
        });

        let selectDiseaseText = {!! json_encode(__('site.Diseases')) !!};
        let samaaKidsTitle = {!! json_encode(__('site.Sama\'a for kids')) !!};
        let samaaTitle = {!! json_encode(__('site.Sama\'a')) !!};
        let noResult = {!! json_encode(__('site.No results found')) !!};
        const BookingEnum = {
            PATIENT_CANCEL: {!! json_encode(\App\Enums\BookingEnum::PATIENT_CANCEL) !!},
        };
        const translations = {
            pending: {!! json_encode(__('site.Pending')) !!},
            done: {!! json_encode(__('site.Done')) !!},
            approved: {!! json_encode(__('site.Approved')) !!},
            canceled: {!! json_encode(__('site.Canceled')) !!},
            canceledByPatient: {!! json_encode(__('site.Canceled By Patient')) !!},
        };
    </script>

    <!-- Initialize Trumbowyg editors for each locale -->
    @foreach(config('app.locales') as $locale)
        <script>
            $(document).ready(function () {
                $('#editor_{{ $locale }}').trumbowyg();
            });
        </script>
    @endforeach

    <script src="{{ asset('assets/js/scripts.js') }}"></script>
    <script src="{{ asset('assets/js/mobile-menu.js') }}"></script>
    <script src="{{ asset('assets/js/dashboard/script.js') }}"></script>

    <!-- Enhanced Sidebar Navigation -->
    <script>
        // Mobile sidebar toggle function
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('show');
        }

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const toggle = document.querySelector('.mobile-menu-toggle');
            
            if (window.innerWidth <= 768 && 
                !sidebar.contains(event.target) && 
                !toggle.contains(event.target) && 
                sidebar.classList.contains('show')) {
                sidebar.classList.remove('show');
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            // Add active class to current navigation item
            const currentPath = window.location.pathname;
            const navLinks = document.querySelectorAll('.nav-link');
            
            navLinks.forEach(link => {
                const linkPath = new URL(link.href).pathname;
                if (currentPath === linkPath || currentPath.startsWith(linkPath + '/')) {
                    link.classList.add('active');
                }
            });

            // Add smooth scroll animation for better UX
            const sidebar = document.querySelector('.modern-sidebar');
            if (sidebar) {
                sidebar.style.scrollBehavior = 'smooth';
            }

            // Enhanced search functionality for patient management
            const searchInput = document.getElementById('patientSearch');
            if (searchInput) {
                searchInput.addEventListener('input', function(e) {
                    const searchTerm = e.target.value.toLowerCase();
                    const tableRows = document.querySelectorAll('.table-row');
                    
                    tableRows.forEach(row => {
                        const patientName = row.querySelector('.patient-details h4')?.textContent.toLowerCase();
                        const patientEmail = row.querySelector('.email')?.textContent.toLowerCase();
                        const patientPhone = row.querySelector('.phone')?.textContent.toLowerCase();
                        
                        const isMatch = patientName?.includes(searchTerm) || 
                                       patientEmail?.includes(searchTerm) || 
                                       patientPhone?.includes(searchTerm);
                        
                        row.style.display = isMatch ? '' : 'none';
                    });
                });
            }
        });
    </script>

</body>
</html>

</html>

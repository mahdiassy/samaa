@extends('layouts.master2')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/admin/doctor-show-page.css') }}">
@endpush

@section('content')
    @php
        $backRoute = Route::has('doctor.index') ? route('doctor.index') : url()->previous();
        $editRoute = Route::has('doctor.edit') ? route('doctor.edit', $doctor) : null;
        $scheduleRoute = Route::has('doctors.calendar') ? route('doctors.calendar') : null;
        $feedbackRoute = Route::has('feedback') ? route('feedback') : null;
        $feedbackListRoute = Route::has('feedback-list') ? route('feedback-list') : null;
        $age = $doctor->birthday ? \Carbon\Carbon::parse($doctor->birthday)->age : null;
        $birthdayFormatted = $doctor->birthday ? \Carbon\Carbon::parse($doctor->birthday)->format('d-m-Y') : null;
        $email = optional($doctor->user)->email;
        $hasSocial = filled($doctor->facebook) || filled($doctor->instagram) || filled($doctor->twitter);
    @endphp

    <div class="doctor-view-page">
        <div class="doctor-management-content">
            <div class="page-header">
                <div class="header-content">
                    <div class="header-info">
                        <h1 class="page-title">{{ $doctor->first_name }} {{ $doctor->last_name }}</h1>
                        <p class="page-subtitle">{{ $doctor->specialization ?? __('site.Specialization') }}</p>
                    </div>
                    <div class="header-actions">
                        <a href="{{ $backRoute }}" class="header-btn ghost-btn">
                            @if (app()->getLocale() === 'ar')
                                <span>{{ __('site.Go Back') }}</span>
                                <i class="fas fa-long-arrow-alt-right" aria-hidden="true"></i>
                            @else
                                <i class="fas fa-long-arrow-alt-left" aria-hidden="true"></i>
                                <span>{{ __('site.Go Back') }}</span>
                            @endif
                        </a>
                        @if ($editRoute)
                            <a href="{{ $editRoute }}" class="header-btn primary-btn">
                                <i class="fas fa-edit" aria-hidden="true"></i>
                                <span>{{ __('site.Edit') }}</span>
                            </a>
                        @endif
                    </div>
                </div>
                <div class="header-meta">
                    <span class="meta-chip">{{ __('site.ID') }} #{{ $doctor->id }}</span>
                    @if ($birthdayFormatted)
                        <span class="meta-chip">{{ __('site.Birthday') }}: {{ $birthdayFormatted }}</span>
                    @endif
                    @if ($age)
                        <span class="meta-chip">{{ $age }} yrs</span>
                    @endif
                    @if ($doctor->address)
                        <span class="meta-chip">{{ $doctor->address }}</span>
                    @endif
                </div>
            </div>

            <div class="search-card">
                @include('search_form')
            </div>

            <div class="content-shell">
                <aside class="media-panel">
                    <div class="avatar-wrapper">
                        <img src="{{ $doctor->image ? Storage::url($doctor->image) : asset('assets/images/avatar1.png') }}" alt="{{ $doctor->first_name }} {{ $doctor->last_name }}" class="profile-img">
                    </div>

                    <div class="info-card">
                        <div class="info-row">
                            <span class="label">{{ __('site.Email Address') }}</span>
                            <span class="value">{{ $email ?? 'N/A' }}</span>
                        </div>
                        <div class="info-row">
                            <span class="label">{{ __('site.Phone') }}</span>
                            <span class="value">{{ $doctor->phone ?? 'N/A' }}</span>
                        </div>
                        <div class="info-row">
                            <span class="label">{{ __('site.Specialization') }}</span>
                            <span class="value">{{ $doctor->specialization ?? 'N/A' }}</span>
                        </div>
                    </div>

                    @if ($doctor->address)
                        <div class="note-card">
                            <h3>{{ __('site.Address') }}</h3>
                            <p>{{ $doctor->address }}</p>
                        </div>
                    @endif

                    @if ($hasSocial)
                        <div class="social-card">
                            <span class="label">{{ __('Connect') }}</span>
                            <div class="social-links">
                                @if ($doctor->facebook)
                                    <a class="social-btn" target="_blank" href="{{ $doctor->facebook }}" aria-label="Facebook">
                                        <svg width="18" height="18" viewBox="0 0 291.319 291.319" xmlns="http://www.w3.org/2000/svg">
                                            <path fill="#3B5998" d="M145.659 0c80.45 0 145.66 65.219 145.66 145.66 0 80.45-65.21 145.659-145.66 145.659S0 226.109 0 145.66C0 65.219 65.21 0 145.659 0z"/>
                                            <path fill="#fff" d="M163.394 100.277h18.772v-27.73h-22.067v.1c-26.738.947-32.218 15.977-32.701 31.763h-.055v13.847h-18.207v27.156h18.207v72.793h27.439v-72.793h22.477l4.342-27.156h-26.81v-8.366c0-5.466 3.55-9.745 8.603-9.745z"/>
                                        </svg>
                                    </a>
                                @endif
                                @if ($doctor->instagram)
                                    <a class="social-btn" target="_blank" href="{{ $doctor->instagram }}" aria-label="Instagram">
                                        <svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <defs>
                                                <radialGradient id="insta-a" cx="0" cy="0" r="1" gradientUnits="userSpaceOnUse" gradientTransform="translate(7.5 14.375) rotate(-55.376) scale(15.95)">
                                                    <stop stop-color="#B13589"/>
                                                    <stop offset="0.793" stop-color="#C62F94"/>
                                                    <stop offset="1" stop-color="#8A3AC8"/>
                                                </radialGradient>
                                                <radialGradient id="insta-b" cx="0" cy="0" r="1" gradientUnits="userSpaceOnUse" gradientTransform="translate(6.875 19.375) rotate(-65.136) scale(14.121)">
                                                    <stop stop-color="#E0E8B7"/>
                                                    <stop offset="0.445" stop-color="#FB8A2E"/>
                                                    <stop offset="0.715" stop-color="#E2425C"/>
                                                    <stop offset="1" stop-color="#E2425C" stop-opacity="0"/>
                                                </radialGradient>
                                                <radialGradient id="insta-c" cx="0" cy="0" r="1" gradientUnits="userSpaceOnUse" gradientTransform="translate(.313 1.875) rotate(-8.13) scale(24.307 5.199)">
                                                    <stop offset="0.157" stop-color="#406ADC"/>
                                                    <stop offset="0.468" stop-color="#6A45BE"/>
                                                    <stop offset="1" stop-color="#6A45BE" stop-opacity="0"/>
                                                </radialGradient>
                                            </defs>
                                            <rect x="1.25" y="1.25" width="17.5" height="17.5" rx="8.75" fill="url(#insta-a)"/>
                                            <rect x="1.25" y="1.25" width="17.5" height="17.5" rx="8.75" fill="url(#insta-b)"/>
                                            <rect x="1.25" y="1.25" width="17.5" height="17.5" rx="8.75" fill="url(#insta-c)"/>
                                            <path fill="#fff" d="M13.5 7.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0z"/>
                                            <path fill="#fff" d="M10 12.5a2.5 2.5 0 100-5 2.5 2.5 0 000 5zm0 1a3.5 3.5 0 110-7 3.5 3.5 0 010 7z"/>
                                            <path fill="#fff" d="M5 9.8C5 8.12 5 7.28 5.327 6.638A2.5 2.5 0 016.638 5.327C7.28 5 8.12 5 9.8 5h.4c1.68 0 2.52 0 3.162.327.564.288 1.023.747 1.31 1.311C15 7.28 15 8.12 15 9.8v.4c0 1.68 0 2.52-.328 3.162a2.5 2.5 0 01-1.31 1.31C12.72 15 11.88 15 10.2 15h-.4c-1.68 0-2.52 0-3.162-.328a2.5 2.5 0 01-1.31-1.31C5 12.72 5 11.88 5 10.2V9.8z"/>
                                        </svg>
                                    </a>
                                @endif
                                @if ($doctor->twitter)
                                    <a class="social-btn" target="_blank" href="{{ $doctor->twitter }}" aria-label="Twitter">
                                        <svg width="20" height="20" viewBox="0 0 45 45" xmlns="http://www.w3.org/2000/svg">
                                            <circle cx="24" cy="24" r="20" fill="#1DA1F2"/>
                                            <path fill="#fff" d="M36 16.309a13.1 13.1 0 01-2.828.775 4.954 4.954 0 002.167-2.724 9.874 9.874 0 01-3.127 1.195 4.94 4.94 0 00-8.418 4.502 14.026 14.026 0 01-10.18-5.159 4.94 4.94 0 001.53 6.592 4.903 4.903 0 01-2.237-.618v.063a4.94 4.94 0 003.96 4.84 4.932 4.932 0 01-2.228.085 4.942 4.942 0 004.612 3.427A9.905 9.905 0 0112 31.292 13.965 13.965 0 0019.548 33.5c11.547 0 17.868-9.571 17.868-17.869 0-.272-.007-.543-.02-.813A12.78 12.78 0 0036 16.309z"/>
                                        </svg>
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endif
                </aside>

                <section class="details-panel">
                    <div class="section-block">
                        <div class="section-heading">
                            <h2>{{ __('Professional Overview') }}</h2>
                        </div>
                        <div class="detail-grid">
                            @if ($doctor->specialization)
                                <div class="detail-item">
                                    <span class="detail-label">{{ __('site.Specialization') }}</span>
                                    <p class="detail-value">{{ $doctor->specialization }}</p>
                                </div>
                            @endif
                            @if ($birthdayFormatted)
                                <div class="detail-item">
                                    <span class="detail-label">{{ __('site.Birthday') }}</span>
                                    <p class="detail-value">{{ $birthdayFormatted }} @if($age) ({{ $age }} yrs) @endif</p>
                                </div>
                            @endif
                            @if ($doctor->phone)
                                <div class="detail-item">
                                    <span class="detail-label">{{ __('site.Phone') }}</span>
                                    <p class="detail-value">{{ $doctor->phone }}</p>
                                </div>
                            @endif
                            @if ($email)
                                <div class="detail-item">
                                    <span class="detail-label">{{ __('site.Email Address') }}</span>
                                    <p class="detail-value">{{ $email }}</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    @if ($doctor->address || $hasSocial)
                        <div class="section-block">
                            <div class="section-heading">
                                <h2>{{ __('Practice Insights') }}</h2>
                            </div>
                            <div class="detail-grid">
                                @if ($doctor->address)
                                    <div class="detail-item">
                                        <span class="detail-label">{{ __('site.Address') }}</span>
                                        <p class="detail-value">{{ $doctor->address }}</p>
                                    </div>
                                @endif
                                @if ($hasSocial)
                                    <div class="detail-item">
                                        <span class="detail-label">{{ __('Digital presence') }}</span>
                                        <p class="detail-value">{{ __('Follow the doctor across social platforms for timely updates.') }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                </section>
            </div>

            <div class="action-bar">
                <a href="{{ $backRoute }}" class="header-btn ghost-btn">
                    <i class="fas fa-user-md" aria-hidden="true"></i>
                    <span>{{ __('site.Doctor list') }}</span>
                </a>

                @role('Patient|Doctor')
                    @if ($feedbackRoute)
                        <a href="{{ $feedbackRoute }}" class="header-btn secondary-btn">
                            <i class="fas fa-comments" aria-hidden="true"></i>
                            <span>{{ __('site.Feedback') }}</span>
                        </a>
                    @endif
                @endrole

                @role('Admin')
                    @if ($feedbackListRoute)
                        <a href="{{ $feedbackListRoute }}" class="header-btn secondary-btn">
                            <i class="fas fa-comments" aria-hidden="true"></i>
                            <span>{{ __('site.Feedback') }}</span>
                        </a>
                    @endif
                @endrole

                @role('Doctor')
                    @if ($scheduleRoute)
                        <a href="{{ $scheduleRoute }}" class="header-btn primary-btn">
                            <i class="fas fa-calendar-plus" aria-hidden="true"></i>
                            <span>{{ __('site.Schedule Appointment') }}</span>
                        </a>
                    @endif
                @endrole
            </div>
        </div>
    </div>
@endsection

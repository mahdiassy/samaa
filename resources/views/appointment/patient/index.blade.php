@extends('layouts.master2')

@section('content')
    <div class="admin-page-container">
        <!-- Page Header -->
        <div class="page-header">
            <div class="header-content">
                <div class="header-info">
                    <h1 class="page-title">{{ __('site.My Bookings') }}</h1>
                    <p class="page-subtitle">{{ __('site.Manage your appointments with doctors') }}</p>
                </div>
                <div class="header-actions">
                    <a href="{{ route('doctor.index') }}" class="header-btn secondary-btn">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span>{{ __('site.Book Appointment') }}</span>
                    </a>
                    <a href="{{ route('therapy.index') }}" class="header-btn primary-btn">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>
                        </svg>
                        <span>{{ __('site.All Therapies') }}</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Stats Overview -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="stat-content">
                    <div class="stat-value">{{ $patientBookings->where('status', \App\Enums\BookingEnum::COMPLETED)->count() }}</div>
                    <div class="stat-label">{{ __('site.Completed') }}</div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon" style="background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="stat-content">
                    <div class="stat-value">{{ $patientBookings->whereIn('status', [\App\Enums\BookingEnum::PENDING, \App\Enums\BookingEnum::CONFIRMED])->count() }}</div>
                    <div class="stat-label">{{ __('site.Upcoming') }}</div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <div class="stat-content">
                    <div class="stat-value">{{ $patientBookings->total() }}</div>
                    <div class="stat-label">{{ __('site.Total Bookings') }}</div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </div>
                <div class="stat-content">
                    <div class="stat-value">{{ $patientBookings->where('status', \App\Enums\BookingEnum::DOCTOR_CANCEL)->count() }}</div>
                    <div class="stat-label">{{ __('site.Cancelled') }}</div>
                </div>
            </div>
        </div>

        <!-- Bookings Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            @forelse($patientBookings as $booking)
                <div class="bg-white border border-slate-200 rounded-xl overflow-hidden transition-all duration-300 hover:shadow-xl hover:-translate-y-1 hover:border-blue-500 flex flex-col">
                    <!-- Booking Header -->
                    <div class="flex justify-between items-center px-5 py-4 bg-gradient-to-r from-slate-50 to-slate-100 border-b border-slate-200">
                        <span class="px-3 py-1.5 rounded-full text-xs font-semibold uppercase tracking-wide
                            {{ $booking->status == \App\Enums\BookingEnum::PENDING ? 'bg-yellow-100 text-yellow-700' : '' }}
                            {{ $booking->status == \App\Enums\BookingEnum::CONFIRMED ? 'bg-blue-100 text-blue-700' : '' }}
                            {{ $booking->status == \App\Enums\BookingEnum::COMPLETED ? 'bg-green-100 text-green-700' : '' }}
                            {{ in_array($booking->status, [\App\Enums\BookingEnum::DOCTOR_CANCEL, 'cancelled']) ? 'bg-red-100 text-red-700' : '' }}">
                            {{ __($booking->status) }}
                        </span>
                        <span class="text-sm text-slate-500 font-medium">#{{ $booking->id }}</span>
                    </div>

                    <!-- Doctor Info -->
                    <div class="flex items-center gap-4 p-5">
                        <div class="w-14 h-14 rounded-full overflow-hidden border-2 border-slate-200 flex-shrink-0">
                            <img src="{{ $booking->availability->doctor->image ? Storage::url($booking->availability->doctor->image) : asset('assets/images/avatar1.png') }}" 
                                 alt="{{ $booking->availability->doctor->first_name }}"
                                 class="w-full h-full object-cover">
                        </div>
                        <div class="flex-1 min-w-0">
                            <a href="{{ route('doctor.show', $booking->availability->doctor) }}" 
                               class="text-base font-semibold text-slate-800 hover:text-blue-600 transition-colors duration-200 block mb-1 no-underline">
                                {{ $booking->availability->doctor->first_name . ' ' . $booking->availability->doctor->last_name }}
                            </a>
                            <p class="text-sm text-slate-600 m-0">{{ $booking->availability->doctor->specialization }}</p>
                        </div>
                    </div>

                    <!-- Booking Details -->
                    <div class="flex flex-col gap-3 px-5 pb-5 border-b border-slate-200">
                        <div class="flex items-center gap-3 text-sm text-slate-700">
                            <svg class="w-5 h-5 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span>{{ \Carbon\Carbon::parse($booking->availability->time)->format('d M Y') }}</span>
                        </div>
                        <div class="flex items-center gap-3 text-sm text-slate-700">
                            <svg class="w-5 h-5 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>{{ \Carbon\Carbon::parse($booking->availability->time)->format('h:i A') }}</span>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex gap-2 p-5 bg-slate-50">
                        @if($booking->status == \App\Enums\BookingEnum::DOCTOR_CANCEL)
                            <a href="{{ route('patients.calendar', $booking->availability->doctor) }}" 
                               class="flex-1 flex items-center justify-center gap-2 px-4 py-2.5 rounded-lg text-sm font-semibold bg-blue-100 text-blue-700 hover:bg-blue-200 transition-all duration-200 no-underline">
                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                </svg>
                                {{ __('site.Reschedule') }}
                            </a>
                        @endif

                        @if($booking->status != \App\Enums\BookingEnum::PATIENT_CANCEL && $booking->status != \App\Enums\BookingEnum::COMPLETED)
                            <form action="{{ route('changeStatus', [$booking->availability->id, \App\Enums\BookingEnum::PATIENT_CANCEL]) }}" 
                                  method="POST" class="flex-1">
                                @csrf
                                <button type="submit" 
                                        class="w-full flex items-center justify-center gap-2 px-4 py-2.5 rounded-lg text-sm font-semibold bg-red-100 text-red-600 hover:bg-red-200 transition-all duration-200 border-0 cursor-pointer"
                                        onclick="return confirm('{{ __('site.Are you sure you want to cancel this booking?') }}')">
                                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                    {{ __('site.Cancel Booking') }}
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-full flex flex-col items-center justify-center p-16 text-center bg-white border-2 border-dashed border-slate-200 rounded-xl">
                    <svg class="w-16 h-16 text-slate-300 mb-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    <h3 class="text-xl font-semibold text-slate-800 mb-2">{{ __('site.No bookings yet') }}</h3>
                    <p class="text-sm text-slate-600 mb-6">{{ __('site.Book an appointment with a doctor to get started') }}</p>
                    <a href="{{ route('doctor.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg hover:from-blue-700 hover:to-blue-800 transition-all duration-200 shadow-md hover:shadow-lg font-semibold no-underline">
                        {{ __('site.Browse Doctors') }}
                    </a>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($patientBookings->hasPages())
            <div class="flex justify-center mt-8">
                {{ $patientBookings->links('pagination::bootstrap-4') }}
            </div>
        @endif
    </div>
@endsection
    <div class="admin-page-container">
        <!-- Page Header -->
        <div class="page-header">
            <div class="header-content">
                <div class="header-info">
                    <h1 class="page-title">{{ __('site.My Bookings') }}</h1>
                    <p class="page-subtitle">{{ __('site.Manage your appointments with doctors') }}</p>
                </div>
                <div class="header-actions">
                    <a href="{{ route('doctor.index') }}" class="header-btn secondary-btn">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span>{{ __('site.Book Appointment') }}</span>
                    </a>
                    <a href="{{ route('therapy.index') }}" class="header-btn primary-btn">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>
                        </svg>
                        <span>{{ __('site.All Therapies') }}</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Stats Overview -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="stat-content">
                    <div class="stat-value">{{ $patientBookings->where('status', \App\Enums\BookingEnum::COMPLETED)->count() }}</div>
                    <div class="stat-label">{{ __('site.Completed') }}</div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon" style="background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="stat-content">
                    <div class="stat-value">{{ $patientBookings->whereIn('status', [\App\Enums\BookingEnum::PENDING, \App\Enums\BookingEnum::CONFIRMED])->count() }}</div>
                    <div class="stat-label">{{ __('site.Upcoming') }}</div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <div class="stat-content">
                    <div class="stat-value">{{ $patientBookings->total() }}</div>
                    <div class="stat-label">{{ __('site.Total Bookings') }}</div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </div>
                <div class="stat-content">
                    <div class="stat-value">{{ $patientBookings->where('status', \App\Enums\BookingEnum::DOCTOR_CANCEL)->count() }}</div>
                    <div class="stat-label">{{ __('site.Cancelled') }}</div>
                </div>
            </div>
        </div>

        <!-- Bookings Grid -->
        <div class="bookings-grid">
            @forelse($patientBookings as $booking)
                <div class="booking-card">
                    <div class="booking-header">
                        <div class="booking-badge status-{{ strtolower($booking->status) }}">
                            {{ __($booking->status) }}
                        </div>
                        <span class="booking-id">#{{ $booking->id }}</span>
                    </div>

                    <div class="booking-doctor">
                        <div class="doctor-avatar">
                            <img src="{{ $booking->availability->doctor->image ? Storage::url($booking->availability->doctor->image) : asset('assets/images/avatar1.png') }}" 
                                 alt="{{ $booking->availability->doctor->first_name }}">
                        </div>
                        <div class="doctor-info">
                            <a href="{{ route('doctor.show', $booking->availability->doctor) }}" class="doctor-name">
                                {{ $booking->availability->doctor->first_name . ' ' . $booking->availability->doctor->last_name }}
                            </a>
                            <p class="doctor-specialty">{{ $booking->availability->doctor->specialization }}</p>
                        </div>
                    </div>

                    <div class="booking-details">
                        <div class="detail-row">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span>{{ \Carbon\Carbon::parse($booking->availability->time)->format('d M Y') }}</span>
                        </div>
                        <div class="detail-row">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>{{ \Carbon\Carbon::parse($booking->availability->time)->format('h:i A') }}</span>
                        </div>
                    </div>

                    <div class="booking-actions">
                        @if($booking->status == \App\Enums\BookingEnum::DOCTOR_CANCEL)
                            <a href="{{ route('patients.calendar', $booking->availability->doctor) }}" class="action-btn secondary">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                </svg>
                                {{ __('site.Reschedule') }}
                            </a>
                        @endif

                        @if($booking->status != \App\Enums\BookingEnum::PATIENT_CANCEL && $booking->status != \App\Enums\BookingEnum::COMPLETED)
                            <form action="{{ route('changeStatus', [$booking->availability->id, \App\Enums\BookingEnum::PATIENT_CANCEL]) }}" 
                                  method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="action-btn delete" onclick="return confirm('{{ __('site.Are you sure you want to cancel this booking?') }}')">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                    {{ __('site.Cancel Booking') }}
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @empty
                <div class="empty-state" style="grid-column: 1 / -1;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    <h3>{{ __('site.No bookings yet') }}</h3>
                    <p>{{ __('site.Book an appointment with a doctor to get started') }}</p>
                    <a href="{{ route('doctor.index') }}" class="primary-btn">{{ __('site.Browse Doctors') }}</a>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($patientBookings->hasPages())
            <div class="pagination-wrapper">
                {{ $patientBookings->links('pagination::bootstrap-4') }}
            </div>
        @endif
    </div>
@endsection

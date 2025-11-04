@extends('layouts.master2')
@section('content')
    <div class="admin-page-container">
        <!-- Page Header -->
        <div class="page-header">
            <div class="header-content">
                <div class="header-info">
                    <h1 class="page-title">{{ __('site.Patients Booking') }}</h1>
                    <p class="page-subtitle">{{ __('site.Manage patient appointments and bookings') }}</p>
                </div>
                <div class="header-actions">
                    @role('Doctor')
                        <a href="{{ route('doctors.calendar') }}" class="header-btn secondary-btn">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span>{{ __('site.Schedule') }}</span>
                        </a>
                    @endrole
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
                <div class="stat-icon" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="stat-content">
                    <div class="stat-value">{{ $patientBookings->where('status', \App\Enums\BookingEnum::PENDING)->count() }}</div>
                    <div class="stat-label">{{ __('site.Pending') }}</div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon" style="background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="stat-content">
                    <div class="stat-value">{{ $patientBookings->where('status', \App\Enums\BookingEnum::APPROVED)->count() }}</div>
                    <div class="stat-label">{{ __('site.Approved') }}</div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <div class="stat-content">
                    <div class="stat-value">{{ $patientBookings->where('status', \App\Enums\BookingEnum::DONE)->count() }}</div>
                    <div class="stat-label">{{ __('site.Completed') }}</div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon" style="background: linear-gradient(135deg, #8b5cf6 0%, #6d28d9 100%);">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <div class="stat-content">
                    <div class="stat-value">{{ $patientBookings->total() }}</div>
                    <div class="stat-label">{{ __('site.Total Bookings') }}</div>
                </div>
            </div>
        </div>

        <!-- Bookings Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6 mb-8">
            @forelse($patientBookings as $booking)
                <div class="bg-white border border-slate-200 rounded-xl overflow-hidden transition-all duration-300 hover:shadow-xl hover:-translate-y-1 hover:border-blue-500 flex flex-col">
                    <!-- Booking Header -->
                    <div class="flex justify-between items-center px-5 py-4 bg-gradient-to-r from-slate-50 to-slate-100 border-b border-slate-200">
                        <span class="px-3 py-1.5 rounded-full text-xs font-semibold uppercase tracking-wide
                            {{ $booking->status == \App\Enums\BookingEnum::PENDING ? 'bg-yellow-100 text-yellow-700' : '' }}
                            {{ $booking->status == \App\Enums\BookingEnum::APPROVED ? 'bg-blue-100 text-blue-700' : '' }}
                            {{ $booking->status == \App\Enums\BookingEnum::CONFIRMED ? 'bg-indigo-100 text-indigo-700' : '' }}
                            {{ $booking->status == \App\Enums\BookingEnum::DONE ? 'bg-green-100 text-green-700' : '' }}
                            {{ $booking->status == \App\Enums\BookingEnum::DOCTOR_CANCEL ? 'bg-red-100 text-red-700' : '' }}">
                            {{ __($booking->status) }}
                        </span>
                        <span class="text-sm text-slate-500 font-medium">#{{ $booking->id }}</span>
                    </div>

                    <!-- Patient Info -->
                    <div class="flex items-center gap-4 p-5">
                        <div class="w-14 h-14 rounded-full overflow-hidden border-2 border-slate-200 flex-shrink-0 bg-gradient-to-br from-blue-100 to-indigo-100 flex items-center justify-center">
                            @if($booking->patient->image)
                                <img src="{{ Storage::url($booking->patient->image) }}" 
                                     alt="{{ $booking->patient->first_name }}"
                                     class="w-full h-full object-cover">
                            @else
                                <svg class="w-8 h-8 text-blue-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2M12 11a4 4 0 100-8 4 4 0 000 8z"/>
                                </svg>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <a href="{{ route('patient.show', $booking->patient) }}" 
                               class="text-base font-semibold text-slate-800 hover:text-blue-600 transition-colors duration-200 block mb-1 no-underline">
                                {{ $booking->patient->first_name . ' ' . $booking->patient->last_name }}
                            </a>
                            <p class="text-sm text-slate-600 m-0">{{ __('site.Patient') }}</p>
                        </div>
                    </div>

                    <!-- Booking Details -->
                    <div class="flex flex-col gap-3 px-5 pb-5 border-b border-slate-200">
                        <div class="flex items-center gap-3 text-sm text-slate-700">
                            <svg class="w-5 h-5 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span>{{ \Carbon\Carbon::parse($booking->availability->time)->format('d M Y, h:i A') }}</span>
                        </div>
                        @if($booking->reason)
                            <div class="flex items-start gap-3 text-sm text-slate-700">
                                <svg class="w-5 h-5 text-slate-400 flex-shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <span class="line-clamp-2">{{ $booking->reason }}</span>
                            </div>
                        @endif
                    </div>

                    <!-- Actions -->
                    <div class="flex flex-col gap-2 p-5 bg-slate-50">
                        <!-- Change Status -->
                        <form id="status-form-{{ $booking->availability->id }}"
                              action="{{ route('doctorChangeStatus', [$booking->availability->id, 'placeholder']) }}"
                              method="POST">
                            @csrf
                            <select name="status"
                                    onchange="updateFormAction(this, '{{ $booking->availability->id }}')"
                                    class="w-full px-4 py-2.5 bg-white border border-slate-300 rounded-lg text-sm font-medium text-slate-700 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 cursor-pointer hover:border-slate-400">
                                <option value="" disabled selected>{{ __('site.Change Status') }}</option>
                                @foreach(\App\Enums\BookingEnum::doctorActions() as $status)
                                    <option value="{{ $status }}">{{ __($status) }}</option>
                                @endforeach
                            </select>
                        </form>

                        <!-- Add Therapy Button -->
                        @if($booking->status == \App\Enums\BookingEnum::APPROVED)
                            <a href="{{ route('therapy-create', $booking->patient) }}" 
                               class="w-full flex items-center justify-center gap-2 px-4 py-2.5 rounded-lg text-sm font-semibold bg-emerald-100 text-emerald-700 hover:bg-emerald-200 transition-all duration-200 no-underline">
                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M12 4v16m8-8H4"/>
                                </svg>
                                {{ __('site.Add Therapy') }}
                            </a>
                        @else
                            <div class="w-full px-4 py-2.5 rounded-lg text-sm font-medium text-slate-500 bg-slate-100 text-center">
                                {{ __('site.be Approved before') }}
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-full flex flex-col items-center justify-center p-16 text-center bg-white border-2 border-dashed border-slate-200 rounded-xl">
                    <svg class="w-16 h-16 text-slate-300 mb-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    <h3 class="text-xl font-semibold text-slate-800 mb-2">{{ __('site.No bookings yet') }}</h3>
                    <p class="text-sm text-slate-600 mb-6">{{ __('site.Patient bookings will appear here') }}</p>
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

    <script>
        function updateFormAction(selectElement, availabilityId) {
            const form = document.getElementById('status-form-' + availabilityId);
            const selectedStatus = selectElement.value;

            const newAction = "{{ route('doctorChangeStatus', [':availabilityId', ':status']) }}"
                .replace(':availabilityId', availabilityId)
                .replace(':status', selectedStatus);

            form.action = newAction;
            form.submit();
        }
    </script>
@endsection
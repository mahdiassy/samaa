@extends('layouts.master2')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/admin/appointment-management-page.css') }}">
@endpush

@section('content')
    @php
        use App\Enums\BookingEnum;

        $bookingsCollection = collect($patientBookings->items());
        $totalBookings = $patientBookings->total();
        $pendingCount = $bookingsCollection->where('status', BookingEnum::PENDING)->count();
        $approvedCount = $bookingsCollection->where('status', BookingEnum::APPROVED)->count();
        $canceledCount = $bookingsCollection
            ->whereIn('status', [BookingEnum::DOCTOR_CANCEL, BookingEnum::PATIENT_CANCEL])
            ->count();
        $nextSession = $bookingsCollection
            ->filter(fn ($booking) => in_array($booking->status, [BookingEnum::APPROVED, BookingEnum::PENDING])
                && optional($booking->availability)->time)
            ->sortBy(fn ($booking) => optional($booking->availability)->time)
            ->first();
        $nextSessionDate = $nextSession && optional($nextSession->availability)->time
            ? \Carbon\Carbon::parse($nextSession->availability->time)->translatedFormat('d M Y')
            : null;
    @endphp

    <div class="appointment-management-content">
        @include('search_form')

        <div class="appointments-shell patient-contaier">
            <header class="page-header">
                <div class="header-content">
                    <div class="header-info">
                        <h1 class="page-title">{{ __('site.My Bookings') }}</h1>
                        <p class="page-subtitle">
                            {{ __('Review upcoming consultations, manage reschedules, and stay on top of your wellness journey.') }}
                        </p>
                    </div>
                    <div class="header-actions">
                        <a href="{{ route('therapy.index') }}" class="header-btn ghost-btn">
                            <i class="fas fa-spa" aria-hidden="true"></i>
                            <span>{{ __('site.All Therapies') }}</span>
                        </a>
                        <a href="{{ route('doctor.index') }}" class="header-btn primary-btn">
                            <i class="fas fa-user-md" aria-hidden="true"></i>
                            <span>{{ __('site.Booking with a doctor') }}</span>
                        </a>
                    </div>
                </div>
                <div class="header-meta">
                    <span class="meta-chip">
                        <i class="fas fa-list-ol" aria-hidden="true"></i>
                        {{ __('Total bookings') }}: {{ $totalBookings }}
                    </span>
                    <span class="meta-chip">
                        <i class="fas fa-layer-group" aria-hidden="true"></i>
                        {{ __('site.Page') }} {{ $patientBookings->currentPage() }} / {{ $patientBookings->lastPage() }}
                    </span>
                    @if($nextSessionDate)
                        <span class="meta-chip">
                            <i class="fas fa-clock" aria-hidden="true"></i>
                            {{ __('Next session') }}: {{ $nextSessionDate }}
                        </span>
                    @endif
                </div>
            </header>

            <div class="insight-grid">
                <article class="insight-card">
                    <div class="insight-icon success">
                        <i class="fas fa-calendar-check" aria-hidden="true"></i>
                    </div>
                    <div class="insight-body">
                        <span class="insight-label">{{ __('Confirmed sessions') }}</span>
                        <span class="insight-value">{{ $approvedCount }}</span>
                        <p class="insight-note">{{ __('Ready for your next consultation—arrive a few minutes early to prepare.') }}</p>
                    </div>
                </article>
                <article class="insight-card">
                    <div class="insight-icon warning">
                        <i class="fas fa-hourglass-half" aria-hidden="true"></i>
                    </div>
                    <div class="insight-body">
                        <span class="insight-label">{{ __('Awaiting confirmation') }}</span>
                        <span class="insight-value">{{ $pendingCount }}</span>
                        <p class="insight-note">{{ __('We will notify you once your doctor accepts the pending slots.') }}</p>
                    </div>
                </article>
                <article class="insight-card">
                    <div class="insight-icon danger">
                        <i class="fas fa-ban" aria-hidden="true"></i>
                    </div>
                    <div class="insight-body">
                        <span class="insight-label">{{ __('Recent cancellations') }}</span>
                        <span class="insight-value">{{ $canceledCount }}</span>
                        <p class="insight-note">{{ __('Reschedule quickly to keep your progress on track.') }}</p>
                    </div>
                </article>
            </div>

            <section class="table-card">
                <div class="table-header">
                    <div>
                        <h2>{{ __('Booking timeline') }}</h2>
                        <p>{{ __('Below is a summary of your recent appointment activity and available actions.') }}</p>
                    </div>
                </div>

                @if($patientBookings->count())
                    <div class="table-responsive">
                        <table id="patientTable" class="bookings-table patient-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('site.Doctor Name') }}</th>
                                    <th>{{ __('site.Doctor Specialization') }}</th>
                                    <th>{{ __('site.Booking Date') }}</th>
                                    <th>{{ __('site.Booking status') }}</th>
                                    <th>{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody id="patientTbody">
                                @foreach($patientBookings as $key => $patientBooking)
                                    <tr id="{{ $key }}">
                                        <td>{{ $patientBooking->id }}</td>
                                        <td>
                                            <span class="text-truncate">
                                                <a class="link" href="{{ route('doctor.show', $patientBooking->availability->doctor) }}">
                                                    {{ $patientBooking->availability->doctor->first_name . ' ' . $patientBooking->availability->doctor->last_name }}
                                                </a>
                                            </span>
                                        </td>
                                        <td>{{ $patientBooking->availability->doctor->specialization }}</td>
                                        <td>{{ \Carbon\Carbon::parse($patientBooking->availability->time)->translatedFormat('d M Y') }}</td>
                                        <td>
                                            @php
                                                $statusClass = 'status-' . \Illuminate\Support\Str::slug($patientBooking->status);
                                            @endphp
                                            <span class="status-pill {{ $statusClass }}">{{ __($patientBooking->status) }}</span>
                                        </td>
                                        <td>
                                            <div class="table-actions">
                                                @if($patientBooking->status == BookingEnum::DOCTOR_CANCEL)
                                                    <a href="{{ route('patients.calendar', $patientBooking->availability->doctor) }}" class="table-action secondary">
                                                        <i class="fas fa-redo" aria-hidden="true"></i>
                                                        <span>{{ __('site.Reschedule appointment') }}</span>
                                                    </a>
                                                @endif

                                                <form class="table-action-form" action="{{ route('changeStatus', [$patientBooking->availability->id, BookingEnum::PATIENT_CANCEL]) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="table-action danger">
                                                        <i class="fas fa-times" aria-hidden="true"></i>
                                                        <span>{{ __('site.Cancel') }}</span>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="pagination-wrap">
                        {{ $patientBookings->links('pagination::bootstrap-4') }}
                    </div>
                @else
                    <div class="empty-state">
                        <i class="fas fa-calendar-plus" aria-hidden="true"></i>
                        <h3>{{ __('No appointments yet') }}</h3>
                        <p>{{ __('Once you request a session, it will appear here with the latest status updates.') }}</p>
                        <a href="{{ route('doctor.index') }}" class="header-btn primary-btn">
                            <i class="fas fa-user-md" aria-hidden="true"></i>
                            <span>{{ __('Find a doctor') }}</span>
                        </a>
                    </div>
                @endif
            </section>
        </div>
    </div>
@endsection

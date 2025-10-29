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
        $uniquePatients = $bookingsCollection->pluck('patient_id')->unique()->count();
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
                        <h1 class="page-title">{{ __('site.Patients Booking') }}</h1>
                        <p class="page-subtitle">
                            {{ __('Monitor patient appointments, respond to new requests, and assign therapies from one streamlined view.') }}
                        </p>
                    </div>
                    <div class="header-actions">
                        <a href="{{ route('therapy.index') }}" class="header-btn ghost-btn">
                            <i class="fas fa-spa" aria-hidden="true"></i>
                            <span>{{ __('site.All Therapies') }}</span>
                        </a>
                        @role('Doctor')
                            <a href="{{ route('doctors.calendar') }}" class="header-btn primary-btn">
                                <i class="fas fa-calendar-plus" aria-hidden="true"></i>
                                <span>{{ __('site.Schedule') }}</span>
                            </a>
                        @endrole
                    </div>
                </div>
                <div class="header-meta">
                    <span class="meta-chip">
                        <i class="fas fa-list-ol" aria-hidden="true"></i>
                        {{ __('Total bookings') }}: {{ $totalBookings }}
                    </span>
                    <span class="meta-chip">
                        <i class="fas fa-users" aria-hidden="true"></i>
                        {{ __('Active patients') }}: {{ $uniquePatients }}
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
                        <p class="insight-note">{{ __('Great news—these appointments are locked in and ready to go.') }}</p>
                    </div>
                </article>
                <article class="insight-card">
                    <div class="insight-icon warning">
                        <i class="fas fa-hourglass-half" aria-hidden="true"></i>
                    </div>
                    <div class="insight-body">
                        <span class="insight-label">{{ __('Awaiting action') }}</span>
                        <span class="insight-value">{{ $pendingCount }}</span>
                        <p class="insight-note">{{ __('Approve or decline pending requests to keep patients informed.') }}</p>
                    </div>
                </article>
                <article class="insight-card">
                    <div class="insight-icon danger">
                        <i class="fas fa-ban" aria-hidden="true"></i>
                    </div>
                    <div class="insight-body">
                        <span class="insight-label">{{ __('Recent cancellations') }}</span>
                        <span class="insight-value">{{ $canceledCount }}</span>
                        <p class="insight-note">{{ __('Follow up with patients to keep continuity of care strong.') }}</p>
                    </div>
                </article>
            </div>

            <section class="table-card">
                <div class="table-header">
                    <div>
                        <h2>{{ __('Appointment queue') }}</h2>
                        <p>{{ __('Track patient requests, update statuses, and launch therapy plans in one place.') }}</p>
                    </div>
                </div>

                @if($patientBookings->count())
                    <div class="table-responsive">
                        <table id="patientTable" class="bookings-table patient-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('site.Patient Name') }}</th>
                                    <th>{{ __('site.Booking Date') }}</th>
                                    <th>{{ __('site.Booking Reason') }}</th>
                                    <th>{{ __('site.Booking status') }}</th>
                                    <th>{{ __('site.Add Therapy') }}</th>
                                    <th>{{ __('site.Change Status') }}</th>
                                </tr>
                            </thead>
                            <tbody id="patientTbody">
                                @foreach($patientBookings as $patientBooking)
                                    <tr>
                                        <td>{{ $patientBooking->id }}</td>
                                        <td>
                                            <span class="text-truncate">
                                                <a class="link" href="{{ route('patient.show', $patientBooking->patient) }}">
                                                    {{ $patientBooking->patient->first_name . ' ' . $patientBooking->patient->last_name }}
                                                </a>
                                            </span>
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($patientBooking->availability->time)->translatedFormat('d M Y') }}</td>
                                        <td>{{ $patientBooking->reason }}</td>
                                        <td>
                                            @php
                                                $statusClass = 'status-' . \Illuminate\Support\Str::slug($patientBooking->status);
                                            @endphp
                                            <span class="status-pill {{ $statusClass }}">{{ __($patientBooking->status) }}</span>
                                        </td>
                                        <td>
                                            @if($patientBooking->status == BookingEnum::APPROVED)
                                                <a href="{{ route('therapy-create', $patientBooking->patient) }}" class="table-action primary">
                                                    <i class="fas fa-notes-medical" aria-hidden="true"></i>
                                                    <span>{{ __('site.Add') }}</span>
                                                </a>
                                            @else
                                                <span class="status-note">{{ __('site.be Approved before') }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <form id="status-form-{{ $patientBooking->availability->id }}"
                                                action="{{ route('changeStatus', [$patientBooking->availability->id, 'status_placeholder']) }}"
                                                method="POST" class="table-action-form">
                                                @csrf
                                                <select class="status-select status" name="status"
                                                    onchange="updateFormAction(this, '{{ $patientBooking->availability->id }}')">
                                                    <option value="" disabled selected>{{ __('site.Change Status') }}</option>
                                                    @foreach(BookingEnum::doctorActions() as $status)
                                                        <option value="{{ $status }}">{{ __($status) }}</option>
                                                    @endforeach
                                                </select>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="pagination-wrap">
                        {{ $patientBookings->links('pagination::bootstrap-4')}}
                    </div>
                @else
                    <div class="empty-state">
                        <i class="fas fa-calendar-plus" aria-hidden="true"></i>
                        <h3>{{ __('No patient bookings yet') }}</h3>
                        <p>{{ __('When patients request time with you, their booking information will appear here for review.') }}</p>
                    </div>
                @endif
            </section>
        </div>
    </div>
@endsection
<script>
    function updateFormAction(selectElement, availabilityId) {
        const form = document.getElementById('status-form-' + availabilityId);
        console.log(availabilityId);
        const selectedStatus = selectElement.value;

        const newAction = "{{ route('doctorChangeStatus', [':availabilityId', ':status']) }}"
            .replace(':availabilityId', availabilityId)
            .replace(':status', selectedStatus);

        form.action = newAction;
        form.submit();
    }
</script>

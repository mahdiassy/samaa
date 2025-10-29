@extends('layouts.master2')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/admin/appointment-schedule-page.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
@endpush

@section('content')
    @php
        use App\Enums\BookingEnum;

        $availabilityCollection = collect($availabilities);
        $openSlots = $availabilityCollection
            ->filter(fn ($slot) => !$slot->booking || optional($slot->booking)->status === BookingEnum::PATIENT_CANCEL)
            ->count();
        $reopenedSlots = $availabilityCollection
            ->filter(fn ($slot) => optional($slot->booking)->status === BookingEnum::PATIENT_CANCEL)
            ->count();
    @endphp

    <div class="appointment-schedule-page">
        @include('search_form')

        <div class="schedule-shell">
            <header class="schedule-page-header">
                <div class="schedule-header-content">
                    <div class="schedule-header-info">
                        <h1 class="schedule-title">{{ __('Appointment schedule') }}</h1>
                        <p class="schedule-subtitle">
                            {{ __('Pick a time that suits you best. Your doctor will review your note before confirming the visit.') }}
                        </p>
                    </div>
                    <div class="schedule-header-actions">
                        <a href="{{ route('patients.booking.index') }}" class="header-btn ghost-btn">
                            <i class="fas fa-arrow-left" aria-hidden="true"></i>
                            <span>{{ __('site.Go Back') }}</span>
                        </a>
                        @isset($doctor)
                            <a href="{{ route('doctor.show', $doctor) }}" class="header-btn primary-btn">
                                <i class="fas fa-user-md" aria-hidden="true"></i>
                                <span>{{ __('site.View Doctor Profile') }}</span>
                            </a>
                        @endisset
                    </div>
                </div>

                <div class="schedule-header-meta">
                    @isset($doctor)
                        <span class="schedule-meta-chip">
                            <i class="fas fa-stethoscope" aria-hidden="true"></i>
                            {{ $doctor->specialization }}
                        </span>
                    @endisset
                    <span class="schedule-meta-chip">
                        <i class="fas fa-calendar-check" aria-hidden="true"></i>
                        {{ __('Available slots') }}: {{ $openSlots }}
                    </span>
                    <span class="schedule-meta-chip">
                        <i class="fas fa-undo" aria-hidden="true"></i>
                        {{ __('Recently reopened') }}: {{ $reopenedSlots }}
                    </span>
                </div>
            </header>

            <section class="calendar-card">
                <div class="calendar-card-header">
                    <div>
                        <h2>{{ __('Schedule overview') }}</h2>
                        <p>{{ __('Select a day to review available time slots and reserve your preferred option.') }}</p>
                    </div>
                    <p class="schedule-note d-none d-md-block">
                        {{ __('Tap any highlighted time to confirm your request instantly.') }}
                    </p>
                </div>

                <div class="calendar-legend" role="list">
                    <span class="legend-item" role="listitem">
                        <span class="legend-dot available"></span>
                        {{ __('site.Available') }}
                    </span>
                    <span class="legend-item" role="listitem">
                        <span class="legend-dot reserved"></span>
                        {{ __('Reserved') }}
                    </span>
                </div>

                <div class="calendar-instance">
                    <div id="calendar"></div>
                </div>

                <p class="schedule-note">
                    {{ __('Please arrive a few minutes early to settle in before your session begins.') }}
                </p>
            </section>
        </div>
    </div>

    <div class="modal fade" id="appointmentEventModal" tabindex="-1" aria-labelledby="appointmentEventModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="appointmentEventModalLabel">{{ __('site.Book Appointment') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('site.Close') }}"></button>
                </div>
                <div class="modal-body">
                    <label for="reason" class="form-label">{{ __('site.Reason') }}</label>
                    <textarea id="reason" name="reason" class="form-control" rows="4" placeholder="{{ __('Let the doctor know what you would like to focus on.') }}"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('site.Cancel') }}</button>
                    <button type="button" class="btn btn-primary" id="saveAppointmentEvent">{{ __('site.Confirm Booking') }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const calendarElement = document.getElementById('calendar');

        if (!calendarElement) {
            return;
        }

        const locale = '{{ app()->getLocale() }}';
        const availabilityData = @json($availabilities);
        const statusLabels = @json([
            \App\Enums\BookingEnum::PENDING => __(\App\Enums\BookingEnum::PENDING),
            \App\Enums\BookingEnum::APPROVED => __(\App\Enums\BookingEnum::APPROVED),
            \App\Enums\BookingEnum::DOCTOR_CANCEL => __(\App\Enums\BookingEnum::DOCTOR_CANCEL),
            \App\Enums\BookingEnum::PATIENT_CANCEL => __(\App\Enums\BookingEnum::PATIENT_CANCEL),
        ]);
        const patientCancelledStatus = '{{ \App\Enums\BookingEnum::PATIENT_CANCEL }}';

        const events = availabilityData.map((slot) => {
            const booking = slot.booking;
            const hasBooking = Boolean(booking);
            const status = hasBooking ? booking.status : null;
            const isUnavailable = hasBooking && status !== patientCancelledStatus;

            const event = {
                title: "{{ __('site.Available') }}",
                start: slot.time,
                id: slot.id,
                extendedProps: {
                    isUnavailable: isUnavailable
                }
            };

            if (isUnavailable) {
                event.title = statusLabels[status] ?? "{{ __('Reserved') }}";
                event.color = '#ef4444';
                event.textColor = '#ffffff';
            }

            return event;
        });

        const calendar = new FullCalendar.Calendar(calendarElement, {
            locale: locale === 'ar' ? 'ar' : locale === 'fr' ? 'fr' : 'en',
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek'
            },
            buttonText: {
                today: "{{ __('site.today') }}",
                month: "{{ __('site.month') }}",
                week: "{{ __('site.week') }}",
                day: "{{ __('site.day') }}",
                list: "{{ __('site.list') }}",
                prev: "{{ __('site.prev') }}",
                next: "{{ __('site.next') }}",
            },
            slotMinTime: '08:00:00',
            slotMaxTime: '18:30:00',
            slotDuration: '00:30:00',
            allDaySlot: false,
            selectable: false,
            editable: false,
            displayEventTime: true,
            events
        });

        let previewEvent = null;
        const appointmentModalEl = document.getElementById('appointmentEventModal');
        const reasonField = document.getElementById('reason');

        calendar.on('eventClick', function (info) {
            if (info.event.extendedProps.isUnavailable) {
                Swal.fire({
                    title: "{{ __('site.Not Available') }}",
                    text: "{{ __('This slot is no longer available. Please choose another time.') }}",
                    icon: 'info',
                    confirmButtonText: "{{ __('site.OK') }}"
                });
                return;
            }

            previewEvent = info.event;
            const modalInstance = bootstrap.Modal.getOrCreateInstance(appointmentModalEl);
            modalInstance.show();
        });

        calendar.render();

        document.getElementById('saveAppointmentEvent')?.addEventListener('click', function () {
            if (!previewEvent) {
                return;
            }

            const reason = reasonField?.value?.trim() || '';

            $.ajax({
                data: {
                    id: previewEvent.id,
                    reason: reason
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('addAppointment') }}",
                type: 'POST',
                success: function () {
                    const modalInstance = bootstrap.Modal.getInstance(appointmentModalEl);
                    modalInstance?.hide();

                    if (reasonField) {
                        reasonField.value = '';
                    }

                    previewEvent.remove();
                    previewEvent = null;

                    Swal.fire({
                        title: "{{ __('site.Success') }}",
                        text: "{{ __('Your appointment request has been sent successfully.') }}",
                        icon: 'success',
                        confirmButtonText: "{{ __('site.OK') }}"
                    });
                },
                error: function () {
                    Swal.fire({
                        title: "{{ __('site.Error') }}",
                        text: "{{ __('Something went wrong while booking this slot. Please try again.') }}",
                        icon: 'error',
                        confirmButtonText: "{{ __('site.OK') }}"
                    });
                }
            });
        });
    });
</script>
@endpush

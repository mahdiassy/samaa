@extends('layouts.master2')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/admin/appointment-schedule-page.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/css/select2.min.css">
@endpush

@section('content')
    @php
        use App\Enums\BookingEnum;

        $availabilityCollection = collect($availabilities);

        $openSlots = $availabilityCollection
            ->filter(fn ($slot) => !$slot->booking || optional($slot->booking)->status === BookingEnum::PATIENT_CANCEL)
            ->count();

        $confirmedSlots = $availabilityCollection
            ->filter(fn ($slot) => optional($slot->booking)->status === BookingEnum::APPROVED)
            ->count();

        $pendingSlots = $availabilityCollection
            ->filter(fn ($slot) => optional($slot->booking)->status === BookingEnum::PENDING)
            ->count();

        $statusLabels = [
            BookingEnum::PENDING => __(BookingEnum::PENDING),
                }
            }

            return event;
        });

        let selectedRange = {
            start: null,
            end: null,
            viewType: null
        };

        let previewEvent = null;

        const calendar = new FullCalendar.Calendar(calendarElement, {
            locale: locale === 'ar' ? 'ar' : locale === 'fr' ? 'fr' : 'en',
            initialView: localStorage.getItem('doctorCalendarDefaultView') || 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek'
            },
            slotMinTime: '08:00:00',
            slotMaxTime: '18:30:00',
            slotDuration: '00:30:00',
            buttonText: {
                today: "{{ __('site.today') }}",
                month: "{{ __('site.month') }}",
                week: "{{ __('site.week') }}",
                day: "{{ __('site.day') }}",
                list: "{{ __('site.list') }}",
                prev: "{{ __('site.prev') }}",
                next: "{{ __('site.next') }}",
            },
            allDaySlot: false,
            selectable: true,
            editable: true,
            eventStartEditable: false,
            eventDurationEditable: false,
            displayEventTime: true,
            validRange: {
                start: new Date()
            },
            events,
            select(info) {
                if (previewEvent) {
                    previewEvent.remove();
                    previewEvent = null;
                }

                selectedRange = {
                    start: info.start,
                    end: info.end,
                    viewType: info.view.type
                };

                if (info.view.type === 'dayGridMonth') {
                    const formattedRange = formatDateRange(info.start, addDays(info.end, -1));

                    if (monthDateField) {
                        monthDateField.value = formattedRange.display;
                    }

                    bulkTimeSelect.val(null).trigger('change');
                    monthModal?.show();
                } else {
                    previewEvent = calendar.addEvent({
                        title: "{{ __('site.Available') }}",
                        start: info.start,
                        end: info.end,
                        backgroundColor: '#0f172a',
                        borderColor: '#1f2937',
                        textColor: '#fff'
                    });

                    if (weekDateField) {
                        weekDateField.value = formatTimeRange(info.start, info.end);
                    }

                    weekModal?.show();
                }

                calendar.unselect();
            },
            eventClick(info) {
                previewEvent = info.event;
                deleteModal?.show();
            },
            viewDidMount(arg) {
                localStorage.setItem('doctorCalendarDefaultView', arg.view.type);
            }
        });

        calendar.render();

        document.getElementById('saveMonthModalEvent')?.addEventListener('click', function () {
            const selectedTimes = bulkTimeSelect.val() || [];

            if (!selectedTimes.length || !selectedRange.start) {
                return;
            }

            const startDate = startOfDay(selectedRange.start);
            const endDateExclusive = startOfDay(selectedRange.end);
            const dates = buildDateArray(startDate, endDateExclusive);
            const payload = [];

            dates.forEach((date) => {
                const dateString = formatDateForApi(date);

                selectedTimes.forEach((time) => {
                    payload.push(`${dateString} ${time}`);
                });
            });

            if (!payload.length) {
                return;
            }

            persistTimes(payload, function (addedTimes) {
                addedTimes.forEach((timestamp) => {
                    const isoString = timestamp.includes('T') ? timestamp : timestamp.replace(' ', 'T');

                    calendar.addEvent({
                        title: "{{ __('site.Available') }}",
                        start: isoString,
                        backgroundColor: availableColor,
                        borderColor: availableColor,
                        textColor: '#fff'
                    });
                });

                monthModal?.hide();

                if (monthDateField) {
                    monthDateField.value = '';
                }

                bulkTimeSelect.val(null).trigger('change');
            });
        });

        document.getElementById('saveWeekModalEvent')?.addEventListener('click', function () {
            if (!previewEvent || !selectedRange.start || !selectedRange.end) {
                return;
            }

            const payload = buildTimeRangePayload(selectedRange.start, selectedRange.end);

            if (!payload.length) {
                return;
            }

            persistTimes(payload, function () {
                weekModal?.hide();

                if (previewEvent) {
                    previewEvent.remove();
                    previewEvent = null;
                }

                localStorage.setItem('doctorCalendarDefaultView', 'timeGridWeek');
                window.location.reload();
            });
        });

        document.getElementById('confirmDeleteEvent')?.addEventListener('click', function () {
            if (!previewEvent) {
                return;
            }

            const deleteUrl = "{{ route('deletetime', ':id') }}".replace(':id', previewEvent.id);

            $.ajax({
                url: deleteUrl,
                type: 'DELETE',
                data: {
                    id: previewEvent.id
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success(response) {
                    if (response.message === 'deleted') {
                        previewEvent.remove();
                        deleteModal?.hide();
                        previewEvent = null;

                        Swal.fire({
                            title: "{{ __('site.Success') }}",
                            text: "{{ __('site.The appointment has been successfully deleted') }}",
                            icon: 'success',
                            confirmButtonText: "{{ __('site.OK') }}"
                        });
                    } else {
                        deleteModal?.hide();

                        Swal.fire({
                            title: "{{ __('site.Error') }}",
                            text: "{{ __('site.You cannot delete it. It has already been booked') }}",
                            icon: 'error',
                            confirmButtonText: "{{ __('site.OK') }}"
                        });
                    }
                },
                error() {
                    deleteModal?.hide();

                    Swal.fire({
                        title: "{{ __('site.Error') }}",
                        text: "{{ __('Something went wrong while deleting this slot.') }}",
                        icon: 'error',
                        confirmButtonText: "{{ __('site.OK') }}"
                    });
                }
            });
        });

        monthModalEl?.addEventListener('hidden.bs.modal', function () {
            bulkTimeSelect.val(null).trigger('change');

            if (monthDateField) {
                monthDateField.value = '';
            }
        });

        weekModalEl?.addEventListener('hidden.bs.modal', function () {
            if (previewEvent) {
                previewEvent.remove();
                previewEvent = null;
            }

            if (weekDateField) {
                weekDateField.value = '';
            }
        });

        function parseJsonFromScript(elementId, fallback) {
            try {
                const element = document.getElementById(elementId);

                if (!element) {
                    return fallback;
                }

                const content = element.textContent ? element.textContent.trim() : '';

                if (!content) {
                    return fallback;
                }

                return JSON.parse(content);
            } catch (error) {
                console.error('Failed to parse JSON payload for', elementId, error);
                return fallback;
            }
        }

        function persistTimes(times, onSuccess) {
            $.ajax({
                url: "{{ route('addTimes') }}",
                type: 'POST',
                data: {
                    times: times
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success(response) {
                    const addedTimes = Array.isArray(response.added_times) ? response.added_times : [];

                    if (addedTimes.length) {
                        Swal.fire({
                            title: "{{ __('site.Success') }}",
                            text: "{{ __('site.This time has been added successfully') }}",
                            icon: 'success',
                            confirmButtonText: "{{ __('site.OK') }}"
                        });

                        if (typeof onSuccess === 'function') {
                            onSuccess(addedTimes);
                        }

                        previewEvent = null;
                    } else {
                        Swal.fire({
                            title: "{{ __('site.Error') }}",
                            text: "{{ __('site.This time has been predetermined') }}",
                            icon: 'error',
                            confirmButtonText: "{{ __('site.OK') }}"
                        });
                    }
                },
                error() {
                    Swal.fire({
                        title: "{{ __('site.Error') }}",
                        text: "{{ __('Something went wrong while adding these times.') }}",
                        icon: 'error',
                        confirmButtonText: "{{ __('site.OK') }}"
                    });
                }
            });
        }

        function buildDateArray(start, endExclusive) {
            const dates = [];
            const cursor = new Date(start.getTime());

            while (cursor < endExclusive) {
                dates.push(new Date(cursor.getTime()));
                cursor.setDate(cursor.getDate() + 1);
            }

            return dates;
        }

        function buildTimeRangePayload(start, end) {
            const payload = [];
            const cursor = new Date(start.getTime());

            while (cursor < end) {
                const datePart = formatDateForApi(cursor);
                const timePart = formatTimeForApi(cursor);

                payload.push(`${datePart} ${timePart}`);
                cursor.setMinutes(cursor.getMinutes() + 30);
            }

            return payload;
        }

        function formatDateRange(start, end) {
            const startFormatted = FullCalendar.formatDate(start, {
                year: 'numeric',
                month: 'short',
                day: 'numeric'
            });
            const endFormatted = FullCalendar.formatDate(end, {
                year: 'numeric',
                month: 'short',
                day: 'numeric'
            });

            return {
                display: `${startFormatted} → ${endFormatted}`
            };
        }

        function formatTimeRange(start, end) {
            const startFormatted = FullCalendar.formatDate(start, {
                hour: 'numeric',
                minute: '2-digit',
                hour12: false
            });
            const endFormatted = FullCalendar.formatDate(end, {
                hour: 'numeric',
                minute: '2-digit',
                hour12: false
            });

            return `${startFormatted} → ${endFormatted}`;
        }

        function startOfDay(date) {
            const clone = new Date(date.getTime());
            clone.setHours(0, 0, 0, 0);
            return clone;
        }

        function addDays(date, amount) {
            const clone = new Date(date.getTime());
            clone.setDate(clone.getDate() + amount);
            return clone;
        }

        function formatDateForApi(date) {
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        }

        function formatTimeForApi(date) {
            const hours = String(date.getHours()).padStart(2, '0');
            const minutes = String(date.getMinutes()).padStart(2, '0');
            return `${hours}:${minutes}`;
        }
    });
</script>
@endpush

@section('content')                            Swal.fire({

    @php                            title: "{{ __('site.Success') }}",

        use App\Enums\BookingEnum;                            text: "{{ __('site.The appointment has been successfully deleted') }}",

                            icon: "Success",

        $availabilityCollection = collect($availabilities);                            confirmButtonText: "{{ __('site.OK') }}') }}') }}') }}"

                            });

        $openSlots = $availabilityCollection

            ->filter(fn ($slot) => !$slot->booking || optional($slot->booking)->status === BookingEnum::PATIENT_CANCEL)                        } else {

            ->count();                            deleteModal.hide();

                            Swal.fire({

        $confirmedSlots = $availabilityCollection                            title: "{{ __('site.Error') }}",

            ->filter(fn ($slot) => optional($slot->booking)->status === BookingEnum::APPROVED)                            text: "{{ __('site.You cannot delete it. It has already been booked') }}",

            ->count();                            icon: "error",

                            confirmButtonText: "{{ __('site.OK') }}') }}') }}') }}"

        $pendingSlots = $availabilityCollection                            });

            ->filter(fn ($slot) => optional($slot->booking)->status === BookingEnum::PENDING)                        }

            ->count();                    },

                });

        $timeOptions = [

            '08:00' => '08:00 ' . __('site.AM'),

            '08:30' => '08:30 ' . __('site.AM'),            }

            '09:00' => '09:00 ' . __('site.AM'),        });

            '09:30' => '09:30 ' . __('site.AM'),

            '10:00' => '10:00 ' . __('site.AM'),        document.getElementById('weekModal').addEventListener('hidden.bs.modal', function() {

            '10:30' => '10:30 ' . __('site.AM'),            if (previewEvent) {

            '11:00' => '11:00 ' . __('site.AM'),                previewEvent.remove();

            '11:30' => '11:30 ' . __('site.AM'),                previewEvent = null;

            '12:00' => '12:00 ' . __('site.PM'),            }

            '12:30' => '12:30 ' . __('site.PM'),        });

            '13:00' => '01:00 ' . __('site.PM'),    });

            '13:30' => '01:30 ' . __('site.PM'),</script>

            '14:00' => '02:00 ' . __('site.PM'),
            '14:30' => '02:30 ' . __('site.PM'),
            '15:00' => '03:00 ' . __('site.PM'),
            '15:30' => '03:30 ' . __('site.PM'),
            '16:00' => '04:00 ' . __('site.PM'),
            '16:30' => '04:30 ' . __('site.PM'),
            '17:00' => '05:00 ' . __('site.PM'),
            '17:30' => '05:30 ' . __('site.PM'),
            '18:00' => '06:00 ' . __('site.PM'),
        ];
    @endphp

    <div class="appointment-schedule-page">
        @include('search_form')

        <div class="schedule-shell">
            <header class="schedule-page-header">
                <div class="schedule-header-content">
                    <div class="schedule-header-info">
                        <h1 class="schedule-title">{{ __('Manage your availability') }}</h1>
                        <p class="schedule-subtitle">
                            {{ __('Create, edit, or remove open sessions so patients always see an up-to-date calendar.') }}
                        </p>
                    </div>
                    <div class="schedule-header-actions">
                        <a href="{{ route('doctors.booking.index') }}" class="header-btn ghost-btn">
                            @if (App::getLocale() === 'ar')
                                <i class="fas fa-long-arrow-alt-right" aria-hidden="true"></i>
                            @else
                                <i class="fas fa-long-arrow-alt-left" aria-hidden="true"></i>
                            @endif
                            <span>{{ __('site.Go Back') }}</span>
                        </a>
                        <button type="button" class="header-btn primary-btn" id="monthQuickAddBtn">
                            <i class="fas fa-plus" aria-hidden="true"></i>
                            <span>{{ __('Add availability') }}</span>
                        </button>
                    </div>
                </div>

                <div class="schedule-header-meta">
                    <span class="schedule-meta-chip">
                        <i class="fas fa-calendar-plus" aria-hidden="true"></i>
                        {{ __('Open slots') }}: {{ $openSlots }}
                    </span>
                    <span class="schedule-meta-chip">
                        <i class="fas fa-user-check" aria-hidden="true"></i>
                        {{ __('Confirmed sessions') }}: {{ $confirmedSlots }}
                    </span>
                    <span class="schedule-meta-chip">
                        <i class="fas fa-hourglass-half" aria-hidden="true"></i>
                        {{ __('Awaiting replies') }}: {{ $pendingSlots }}
                    </span>
                </div>
            </header>

            <section class="calendar-card">
                <div class="calendar-card-header">
                    <div>
                        <h2>{{ __('Availability overview') }}</h2>
                        <p>{{ __('Select a day to add slots or review existing reservations.') }}</p>
                    </div>
                    <div class="schedule-alert d-none d-md-flex">
                        <i class="fas fa-lightbulb" aria-hidden="true"></i>
                        <span>{{ __('Drag on the weekly view to block multiple consecutive times at once.') }}</span>
                    </div>
                </div>

                <div class="calendar-legend" role="list">
                    <span class="legend-item" role="listitem">
                        <span class="legend-dot available"></span>
                        {{ __('site.Available') }}
                    </span>
                    <span class="legend-item" role="listitem">
                        <span class="legend-dot pending"></span>
                        {{ __('Pending') }}
                    </span>
                    <span class="legend-item" role="listitem">
                        <span class="legend-dot confirmed"></span>
                        {{ __('Confirmed') }}
                    </span>
                    <span class="legend-item" role="listitem">
                        <span class="legend-dot canceled"></span>
                        {{ __('Cancelled') }}
                    </span>
                </div>

                <div class="calendar-instance">
                    <div id="calendar"></div>
                </div>

                <p class="schedule-note">
                    {{ __('Mark cancellations promptly so patients receive instant updates and reclaimed slots reopen automatically.') }}
                </p>
            </section>
        </div>
    </div>

    <div class="modal fade" id="monthModal" tabindex="-1" aria-labelledby="monthModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="monthModalLabel">{{ __('site.Select Appointment - Month View') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('site.Close') }}"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label" for="selectedMonthDate">{{ __('Selected dates') }}</label>
                        <input type="text" id="selectedMonthDate" class="form-control" readonly>
                    </div>

                    <div>
                        <label class="form-label" for="bulkTimeSelect">{{ __('site.Select Time') }}</label>
                        <select class="form-control" id="bulkTimeSelect" multiple="multiple">
                            @foreach ($timeOptions as $timeValue => $timeLabel)
                                <option value="{{ $timeValue }}">{{ $timeLabel }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('site.Close') }}</button>
                    <button type="button" class="btn btn-primary" id="saveMonthModalEvent">{{ __('site.Save') }}</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="weekModal" tabindex="-1" aria-labelledby="weekModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="weekModalLabel">{{ __('site.Select Appointment - Week View') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('site.Close') }}"></button>
                </div>
                <div class="modal-body">
                    <label class="form-label" for="selectedWeekDate">{{ __('Selected range') }}</label>
                    <input type="text" id="selectedWeekDate" class="form-control" readonly>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('site.Close') }}</button>
                    <button type="button" class="btn btn-primary" id="saveWeekModalEvent">{{ __('site.Save') }}</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteEventModal" tabindex="-1" aria-labelledby="deleteEventModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteEventModalLabel">{{ __('site.Delete Event') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('site.Close') }}"></button>
                </div>
                <div class="modal-body">
                    {{ __('site.Are you sure you want to delete this event?') }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('site.Cancel') }}</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteEvent">{{ __('site.Delete') }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection


@extends('layouts.master2')

@section('content')
    <div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
        <!-- Header with Back Button -->
        <div class="max-w-7xl mx-auto mb-6">
            <a href="{{ route('doctors.booking.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50 transition-colors duration-200">
                @if(App::getLocale() == 'ar')
                <i class="fas fa-long-arrow-alt-right text-gray-600"></i>
                <span class="text-gray-700 font-medium">{{ __('site.Go Back') }}</span>
                @else
                <i class="fas fa-long-arrow-alt-left text-gray-600"></i>
                <span class="text-gray-700 font-medium">{{ __('site.Go Back') }}</span>
                @endif
            </a>
        </div>

        <!-- Calendar Card -->
        <div class="max-w-7xl mx-auto">
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="p-6">
                    <div id='calendar' class="w-full"></div>
                </div>
            </div>
        </div>

        <!-- Modal for Month View -->
        <div class="modal fade" id="monthModal" tabindex="-1" aria-labelledby="monthModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content rounded-lg overflow-hidden">
                    <div class="modal-header bg-gradient-to-r from-blue-600 to-blue-700 text-white px-6 py-4">
                        <h5 class="modal-title text-lg font-semibold" id="monthModalLabel">{{ __('site.Select Appointment - Month View') }}</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body px-6 py-4">
                        <div class="mb-4">
                            <input type="text" id="selectedMonthDate" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-gray-50" placeholder="Selected Date" readonly />
                        </div>
                        <div>
                            <label for="users-movies-select2" class="block text-sm font-medium text-gray-700 mb-2">{{ __('site.Select Time') }}:</label>
                            <select class="form-control select2 w-full" id="users-movies-select2" multiple="multiple">
                                <option value="08:00">08:00 {{ __('site.AM') }}</option>
                                <option value="08:30">08:30 {{ __('site.AM') }}</option>
                                <option value="09:00">09:00 {{ __('site.AM') }}</option>
                                <option value="09:30">09:30 {{ __('site.AM') }}</option>
                                <option value="10:00">10:00 {{ __('site.AM') }}</option>
                                <option value="10:30">10:30 {{ __('site.AM') }}</option>
                                <option value="11:00">11:00 {{ __('site.AM') }}</option>
                                <option value="11:30">11:30 {{ __('site.AM') }}</option>
                                <option value="12:00">12:00 {{ __('site.PM') }}</option>
                                <option value="12:30">12:30 {{ __('site.PM') }}</option>
                                <option value="13:00">01:00 {{ __('site.PM') }}</option>
                                <option value="13:30">01:30 {{ __('site.PM') }}</option>
                                <option value="14:00">02:00 {{ __('site.PM') }}</option>
                                <option value="14:30">02:30 {{ __('site.PM') }}</option>
                                <option value="15:00">03:00 {{ __('site.PM') }}</option>
                                <option value="15:30">03:30 {{ __('site.PM') }}</option>
                                <option value="16:00">04:00 {{ __('site.PM') }}</option>
                                <option value="16:30">04:30 {{ __('site.PM') }}</option>
                                <option value="17:00">05:00 {{ __('site.PM') }}</option>
                                <option value="17:30">05:30 {{ __('site.PM') }}</option>
                                <option value="18:00">06:00 {{ __('site.PM') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer bg-gray-50 px-6 py-4 flex gap-3 justify-end">
                        <button type="button" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors duration-200" data-bs-dismiss="modal">{{ __('site.Close') }}</button>
                        <button type="button" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200" id="saveMonthModalEvent">{{ __('site.Save') }}</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal for Week View -->
        <div class="modal fade" id="weekModal" tabindex="-1" aria-labelledby="weekModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content rounded-lg overflow-hidden">
                    <div class="modal-header bg-gradient-to-r from-green-600 to-green-700 text-white px-6 py-4">
                        <h5 class="modal-title text-lg font-semibold" id="weekModalLabel">{{ __('site.Select Appointment - Week View') }}</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body px-6 py-4">
                        <input type="text" id="selectedWeekDate" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 bg-gray-50" placeholder="Selected Date" readonly />
                    </div>
                    <div class="modal-footer bg-gray-50 px-6 py-4 flex gap-3 justify-end">
                        <button type="button" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors duration-200" data-bs-dismiss="modal">{{ __('site.Close') }}</button>
                        <button type="button" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors duration-200" id="saveWeekModalEvent">{{ __('site.Save') }}</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal for Deletion Confirmation -->
        <div class="modal fade" id="deleteEventModal" tabindex="-1" aria-labelledby="deleteEventModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content rounded-lg overflow-hidden">
                    <div class="modal-header bg-gradient-to-r from-red-600 to-red-700 text-white px-6 py-4">
                        <h5 class="modal-title text-lg font-semibold" id="deleteEventModalLabel">{{ __('site.Delete Event') }}</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body px-6 py-4">
                        <p class="text-gray-700">{{ __('site.Are you sure you want to delete this event?') }}</p>
                    </div>
                    <div class="modal-footer bg-gray-50 px-6 py-4 flex gap-3 justify-end">
                        <button type="button" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors duration-200" data-bs-dismiss="modal">{{ __('site.Cancel') }}</button>
                        <button type="button" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors duration-200" id="confirmDeleteEvent">{{ __('site.Delete') }}</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>

@if(app()->getLocale() == 'fr')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@3.10.0/dist/locale/fr.js"></script>
@elseif(app()->getLocale() == 'ar')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@3.10.0/dist/locale/ar.js"></script>
@endif

<style>
    /* FullCalendar Modern Styling */
    #calendar {
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }
    
    .fc {
        border-radius: 0.5rem;
    }
    
    .fc .fc-toolbar.fc-header-toolbar {
        margin-bottom: 1.5rem;
        padding: 1rem;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 0.75rem;
    }
    
    .fc .fc-toolbar-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: white;
    }
    
    .fc .fc-button {
        background-color: rgba(255, 255, 255, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.3);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
        font-weight: 500;
        text-transform: capitalize;
        transition: all 0.2s;
    }
    
    .fc .fc-button:hover {
        background-color: rgba(255, 255, 255, 0.3);
        border-color: rgba(255, 255, 255, 0.4);
    }
    
    .fc .fc-button-active,
    .fc .fc-button:active {
        background-color: white !important;
        color: #667eea !important;
        border-color: white !important;
    }
    
    .fc .fc-button:focus {
        box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.3);
    }
    
    .fc-theme-standard .fc-scrollgrid {
        border: 1px solid #e5e7eb;
        border-radius: 0.5rem;
    }
    
    .fc .fc-col-header-cell {
        background-color: #f9fafb;
        font-weight: 600;
        color: #374151;
        padding: 0.75rem;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.05em;
    }
    
    .fc .fc-daygrid-day-number {
        padding: 0.5rem;
        font-weight: 600;
        color: #1f2937;
    }
    
    .fc .fc-daygrid-day.fc-day-today {
        background-color: #eff6ff !important;
    }
    
    .fc .fc-daygrid-day.fc-day-today .fc-daygrid-day-number {
        background-color: #3b82f6;
        color: white;
        border-radius: 9999px;
        width: 2rem;
        height: 2rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .fc-event {
        border-radius: 0.375rem;
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
    }
    
    .fc-event:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }
    
    .fc .fc-timegrid-slot {
        height: 3rem;
    }
    
    .fc .fc-timegrid-axis-cushion {
        color: #6b7280;
        font-size: 0.875rem;
    }
    
    /* Select2 Styling */
    .select2-container--default .select2-selection--multiple {
        border: 1px solid #d1d5db;
        border-radius: 0.5rem;
        padding: 0.25rem;
        min-height: 42px;
    }
    
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background-color: #3b82f6;
        border: none;
        border-radius: 0.375rem;
        color: white;
        padding: 0.25rem 0.5rem;
        margin: 0.25rem;
    }
    
    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
        color: white;
        margin-right: 0.25rem;
    }
    
    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover {
        color: #fee;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        $('#users-movies-select2').select2({
            placeholder: "{{ __('site.Select a time') }}",
            width: '100%',
            allowClear: true,
            dropdownParent: $('#monthModal')
        });
        var availabilities = [{!! $availabilities !!}];
        availabile = []
        $(availabilities[0]).each(function(i, time) {
            availabile[i] = {
                title: "{{ __('site.Available') }}",
                start: time.time,
                id: time.id,
            };
            if (time.booking) {
                if (time.booking.status === BookingEnum.PATIENT_CANCEL) {
                    availabile[i].title = translations[time.booking.status]// `${time.booking.status}`
                    availabile[i].color = 'rgb(214 126 13)'
                } else {
                    availabile[i].title = translations[time.booking.status]//`${time.booking.status}`
                    availabile[i].color = 'rgb(249 57 57)'
                }
            }
        })

        var calendarEl = document.getElementById('calendar');
        const openInWeekView = localStorage.getItem('openInWeekView') === 'true';

        let selectedStartDate = '';
        let selectedEndDate = '';
        let previewEvent = null;
        let tiemsSelected = [];
        let tiemsWeekSelected = [];
        var daySelected = '';
        let deleteTimeUrl = "{{ route('deletetime', ':id') }}";


        function formatDateTime(dateStr) {
            const date = new Date(dateStr);
            return date.toLocaleTimeString('en-US', {
                hour: 'numeric',
                minute: '2-digit',
                hour12: false
            });
        }

        function getDatesInRange(startDate, endDate) {
            const start = new Date(startDate);
            const end = new Date(endDate);

            const dateArray = [];

            let currentDate = start;
            while (currentDate < (end - 1)) {
                dateArray.push(new Date(currentDate));
                currentDate.setDate(currentDate.getDate() + 1);
            }

            return dateArray;
        }

        function getTimesInRange(startTime, endTime) {
            const [startHour, startMinute] = startTime.split(':').map(Number);
            const [endHour, endMinute] = endTime.split(':').map(Number);

            const startDate = new Date();
            startDate.setHours(startHour, startMinute, 0, 0);

            const endDate = new Date();
            endDate.setHours(endHour, endMinute, 0, 0);

            const timeArray = [];

            let currentDate = new Date(startDate);
            while (currentDate < (endDate - 1)) {
                timeArray.push(currentDate.toTimeString().slice(0, 5));
                currentDate.setMinutes(currentDate.getMinutes() + 30);
            }

            return timeArray;
        }

        var locale = '{{ app()->getLocale() }}';

        var calendar = new FullCalendar.Calendar(calendarEl, {
            locale: locale === 'ar' ? 'ar' : locale === 'fr' ? 'fr' : 'en',
            initialView: openInWeekView ? 'timeGridWeek' : 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek'
            },
            slotMinTime: "08:00:00",
            slotMaxTime: "18:30:00",
            slotDuration: '00:30:00',
            allDaySlot: false,
            validRange: {
                start: new Date()
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
            selectable: true,
            editable: true,
            eventStartEditable: false,
            eventDurationEditable: false,
            displayEventTime: true,
            defaultTimedEventDuration: '00:30',

            select: function(info) {
                selectedStartDate = info.startStr;
                selectedEndDate = info.endStr;

                var formattedStartTime = formatDateTime(selectedStartDate);
                var formattedEndTime = formatDateTime(selectedEndDate);

                if (calendar.view.type === 'dayGridMonth') {
                    document.getElementById('selectedMonthDate').value = 'From: ' +
                        selectedStartDate + ' To: ' + selectedEndDate;
                    var monthModal = new bootstrap.Modal(document.getElementById('monthModal'));
                    monthModal.show();
                } else if (calendar.view.type === 'timeGridWeek') {
                    previewEvent = calendar.addEvent({
                        title: "{{ __('site.Available (Preview)') }}",
                        start: selectedStartDate,
                        end: selectedEndDate,
                        backgroundColor: '#1F1F1F',
                        borderColor: '#828787',
                        textColor: '#fff'
                    });
                    document.getElementById('selectedWeekDate').value = 'From: ' +
                        formattedStartTime + ' To: ' + formattedEndTime;

                    var weekModal = new bootstrap.Modal(document.getElementById('weekModal'));
                    weekModal.show();
                }

                calendar.unselect();
            },
            eventClick: function(info) {
                previewEvent = info.event;

                var deleteModal = new bootstrap.Modal(document.getElementById('deleteEventModal'));
                deleteModal.show();
            },
            events: availabile
        });

        calendar.render();

        localStorage.removeItem('openInWeekView');
        
        var saveMonthModalEvent = document.getElementById('saveMonthModalEvent');
        if (saveMonthModalEvent) {
            saveMonthModalEvent.addEventListener('click', function() {
                var selectedOptions = Array.from(document.getElementById('users-movies-select2')
                    .selectedOptions);

                daySelected = document.getElementById('selectedMonthDate').value;
                dates = daySelected.replace('From: ', '').replace('To: ', '');
                let datesArray = dates.split(' ');

                const dateArray = getDatesInRange(datesArray[0], datesArray[1]);

                if (selectedOptions.length > 0 && selectedStartDate) {
                    selectedOptions.forEach(option => {
                        dateArray.forEach(days => {
                            const [hours, minutes] = option.value.split(':');
                            tiemsSelected.push(
                                `${moment(days).format('YYYY-MM-DD')} ${option.value}`
                            );
                        });
                    });

                    $.ajax({
                        data: {
                            times: tiemsSelected
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: "{{ route('addTimes') }}",
                        type: 'POST',
                        success: function(e) {
                            if (Array.isArray(e.added_times) && e.added_times.length > 0) {

                                console.log(e.added_times);
                                selectedOptions.forEach(option => {
                                    dateArray.forEach(days => {
                                        const [hours, minutes] = option
                                            .value.split(':');
                                        const eventStart = new Date(days);

                                        eventStart.setHours(hours, minutes);

                                        calendar.addEvent({
                                            title: 'Appointment',
                                            start: eventStart,
                                            end: new Date(eventStart
                                                .getTime() +
                                                30 * 60 * 1000),
                                            backgroundColor: '#1F1F1F',
                                            borderColor: '#828787',
                                            textColor: '#fff'
                                        });
                                    });
                                });
                                Swal.fire({
                                title: "{{ __('site.Success') }}",
                                text: "{{ __('site.This time has been added successfully') }}",
                                icon: "success",
                                confirmButtonText: "{{ __('site.OK') }}') }}') }}') }}"
                                });
                                // Optionally reload or update UI here
                                location.reload();
                            } else {
                                Swal.fire({
                                title: "{{ __('site.Error') }}",
                                text: "{{ __('site.This time has been predetermined') }}",
                                icon: "error",
                                confirmButtonText: "{{ __('site.OK') }}') }}') }}') }}"
                                });
                            }
                        }
                    });

                    var monthModal = bootstrap.Modal.getInstance(document.getElementById('monthModal'));
                    monthModal.hide();
                    document.getElementById('selectedMonthDate').value = "";
                    $('#users-movies-select2').val(null).trigger('change');
                    timesSelected = [];
                }
            });
        }

        document.getElementById('saveWeekModalEvent').addEventListener('click', function() {
            if (previewEvent) {
                previewEvent.setProp('title', 'Available');
                previewEvent.setProp('backgroundColor', '#1F1F1F');
                previewEvent.setProp('borderColor', '#828787');
                previewEvent.setProp('textColor', '#fff');

                var weekModal = bootstrap.Modal.getInstance(document.getElementById('weekModal'));

                timeSelected = document.getElementById('selectedWeekDate').value;
                tiems = timeSelected.replace('From: ', '').replace('To: ', '');
                let timesArray = tiems.split(' ');
                const timeArray = getTimesInRange(timesArray[0], timesArray[1]);

                var eventDate = previewEvent.start;
                var formattedDate = moment(eventDate).format('YYYY-MM-DD');

                timeArray.forEach(time => {
                    tiemsWeekSelected.push(`${formattedDate} ${time}`);
                });
                $.ajax({
                    data: {
                        times: tiemsWeekSelected
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ route('addTimes') }}",
                    type: 'POST',
                    success: function(e) {
                        if (Array.isArray(e.added_times) && e.added_times.length > 0) {
                            // Optionally reload or update UI here
                            // location.reload();
                            Swal.fire({
                            title: "{{ __('site.Success') }}",
                            text: "{{ __('site.This time has been added successfully') }}",
                            icon: "success",
                            confirmButtonText: "{{ __('site.OK') }}') }}') }}') }}"
                            });

                            localStorage.setItem('openInWeekView', 'true');
                            location.reload();
                        } else {
                            //alert('{{ __('This time has been predetermined') }}');
                            Swal.fire({
                            title: "{{ __('site.Error') }}",
                            text: "{{ __('site.This time has been predetermined') }}",
                            icon: "error",
                            confirmButtonText: "{{ __('site.OK') }}') }}') }}') }}"
                            });
                        }
                    }
                });

                weekModal.hide();
                previewEvent = null;
                document.getElementById('selectedWeekDate').value = "";
                timesWeekSelected = [];
            }
        });

        document.getElementById('confirmDeleteEvent').addEventListener('click', function() {
            if (previewEvent) {

                var deleteModal = bootstrap.Modal.getInstance(document.getElementById(
                    'deleteEventModal'));
                $.ajax({
                    data: {
                        id: previewEvent.id
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: deleteTimeUrl.replace(':id', previewEvent.id),
                    type: 'DELETE',
                    success: function(e) {
                        // location.reload();
                        if (e.message == "deleted") {
                            previewEvent.remove();
                            deleteModal.hide();
                            previewEvent = null;
                            Swal.fire({
                            title: "{{ __('site.Success') }}",
                            text: "{{ __('site.The appointment has been successfully deleted') }}",
                            icon: "Success",
                            confirmButtonText: "{{ __('site.OK') }}') }}') }}') }}"
                            });

                        } else {
                            deleteModal.hide();
                            Swal.fire({
                            title: "{{ __('site.Error') }}",
                            text: "{{ __('site.You cannot delete it. It has already been booked') }}",
                            icon: "error",
                            confirmButtonText: "{{ __('site.OK') }}') }}') }}') }}"
                            });
                        }
                    },
                });


            }
        });

        document.getElementById('weekModal').addEventListener('hidden.bs.modal', function() {
            if (previewEvent) {
                previewEvent.remove();
                previewEvent = null;
            }
        });
    });
</script>

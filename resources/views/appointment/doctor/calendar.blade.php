@extends('layouts.master')

@section('content')
    <div class="container" id="content">
        <div class="row justify-content-center">
            <div class="col-md-12 box-design shadow w-100">
                <div class="row mt-2 mb-2">
                    <div class="col-md-12">
                        <div id='calendar'></div>
                    </div>
                </div>
                <!-- Modal for Month View -->
                <div class="modal fade" id="monthModal" tabindex="-1" aria-labelledby="monthModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="monthModalLabel">Select Appointment - Month View</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <input type="text" id="selectedMonthDate" class="form-control"
                                    placeholder="Selected Date" readonly />
                                <div class="pt-2">
                                    <label for="users-movies-select2">Select Time:</label>
                                    <select class="form-control" id="users-movies-select2" multiple="multiple">
                                        <option value="08:00">08:00 AM</option>
                                        <option value="08:30">08:30 AM</option>
                                        <option value="09:00">09:00 AM</option>
                                        <option value="09:30">09:30 AM</option>
                                        <option value="10:00">10:00 AM</option>
                                        <option value="10:30">10:30 AM</option>
                                        <option value="11:00">11:00 AM</option>
                                        <option value="11:30">11:30 AM</option>
                                        <option value="12:00">12:00 PM</option>
                                        <option value="12:30">12:30 PM</option>
                                        <option value="13:00">01:00 PM</option>
                                        <option value="13:30">01:30 PM</option>
                                        <option value="14:00">02:00 PM</option>
                                        <option value="14:30">02:30 PM</option>
                                        <option value="15:00">03:00 PM</option>
                                        <option value="15:30">03:30 PM</option>
                                        <option value="16:00">04:00 PM</option>
                                        <option value="16:30">04:30 PM</option>
                                        <option value="17:00">05:00 PM</option>
                                        <option value="17:30">05:30 PM</option>
                                        <option value="18:00">06:00 PM</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" id="saveMonthModalEvent">Save</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal for Week View -->
                <div class="modal fade" id="weekModal" tabindex="-1" aria-labelledby="weekModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="weekModalLabel">Select Appointment - Week View</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <input type="text" id="selectedWeekDate" class="form-control" placeholder="Selected Date"
                                    readonly />
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" id="saveWeekModalEvent">Save</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal for Deletion Confirmation -->
                <div class="modal fade" id="deleteEventModal" tabindex="-1" aria-labelledby="deleteEventModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteEventModalLabel">Delete Event</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Are you sure you want to delete this event?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="button" class="btn btn-danger" id="confirmDeleteEvent">Delete</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
<script>
    document.addEventListener('DOMContentLoaded', function() {

        var availabilities = [{!! $availabilities !!}];
        availabile = []
        $(availabilities[0]).each(function(i, time) {
            availabile[i] = {
                title: '{{ __('Available') }}',
                start: time.time,
                id: time.id,
            };
            if (time.booking) {
                availabile[i].title = `{{ __('reserved:') }} \n ${time.booking.user_name}`
                availabile[i].color = 'red'
            }
        })

        var calendarEl = document.getElementById('calendar');

        let selectedStartDate = '';
        let selectedEndDate = '';
        let previewEvent = null;
        let tiemsSelected = [];
        let tiemsWeekSelected = [];
        var daySelected = '';

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

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
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
                        title: 'Available (Preview)',
                        start: selectedStartDate,
                        end: selectedEndDate,
                        backgroundColor: '#99ccff',
                        borderColor: '#0077cc',
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
                                            backgroundColor: '#00aaff',
                                            borderColor: '#0077cc',
                                            textColor: '#fff'
                                        });
                                    });
                                });
                                // Optionally reload or update UI here
                                // location.reload();
                            } else {
                                alert('{{ __('This time has been predetermined') }}');
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
                previewEvent.setProp('backgroundColor', '#00aaff');
                previewEvent.setProp('borderColor', '#0077cc');
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
                        } else {
                            alert('{{ __('This time has been predetermined') }}');
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
                previewEvent.remove();

                var deleteModal = bootstrap.Modal.getInstance(document.getElementById(
                    'deleteEventModal'));
                $.ajax({
                    data: {
                        id: previewEvent.id
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "/doctors/deletetime/" + previewEvent.id,
                    type: 'DELETE',
                    success: function(data) {
                        // location.reload();
                        deleteModal.hide();
                        previewEvent = null;
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

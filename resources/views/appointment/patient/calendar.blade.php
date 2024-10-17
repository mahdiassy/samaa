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
                <div class="modal fade" id="appointmentEventModal" tabindex="-1" aria-labelledby="appointmentEventModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="appointmentEventModalLabel">Appointment Event</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <label>Reason:</label>
                                <textarea type="text" id="reason" class="form-control" name="reason" >
                                </textarea>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="button" class="btn btn-primary" id="saveAppointmentEvent">Save</button>
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

        let previewEvent = null;

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

            eventClick: function(info) {
                previewEvent = info.event;

                var appointmentModal = new bootstrap.Modal(document.getElementById('appointmentEventModal'));
                appointmentModal.show();
            },
            events: availabile
        });

        calendar.render();

        document.getElementById('saveAppointmentEvent').addEventListener('click', function() {
            if (previewEvent) {
                previewEvent.remove();

                var appointmentModal = bootstrap.Modal.getInstance(document.getElementById('appointmentEventModal'));
                var reason = document.getElementById("reason").value;
                $.ajax({
                    data: {
                        id: previewEvent.id,
                        reason:reason
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "/control/patients/addAppointment/",
                    type: 'POST',
                    success: function(data) {
                        // location.reload();
                        document.getElementById("reason").value = "";
                        appointmentModal.hide();
                        previewEvent = null;
                    },
                });
            }
        });

    });
</script>

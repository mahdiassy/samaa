@extends('layouts.master2')
@section('content')
    <div class="main-content">
        @include('search_form')
        <div class="patient-contaier">

            <div class="actions">
                <div class="title-container">
                    <h1 class="page-title">{{ __('site.Patients Booking') }}</h1>
                </div>
                <div class="button-container2">
                    <a href="{{ route('therapy.index') }}" class="add-primery-btn">{{ __('site.All Therapies') }}</a>

                    @role('Doctor')
                        <a href="{{ route('doctors.calendar') }}" class="add-patient-btn">{{ __('site.Schedule') }}</a>
                    @endrole
                </div>
            </div>

            <div class="table-container">
                <table id="patientTable" class="patient-table">
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
                        @foreach ($patientBookings as $patientBooking)
                            <tr>
                                <td>{{ $patientBooking->id }}</td>
                                <td>
                                    <span class="text-truncate">
                                        <a class="link" href="{{ route('patient.show', $patientBooking->patient) }}">{{ $patientBooking->patient->first_name . ' ' . $patientBooking->patient->last_name }}</a></span>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($patientBooking->availability->time)->format('d-m-Y') }}</td>
                                <td>{{ $patientBooking->reason }}</td>

                                <td class="custom-date">{{ __($patientBooking->status) }}</td>
                                @if ($patientBooking->status == \App\Enums\BookingEnum::APPROVED)
                                    <td><a href="{{ route('therapy-create',$patientBooking->patient) }}" class="btn edit-btn">{{ __('site.Add') }}</a></td>
                                @else
                                    <td>{{ __('site.be Approved before') }}</td>
                                @endif
                                <td>
                                    <form id="status-form-{{ $patientBooking->availability->id }}"
                                        action="{{ route('changeStatus', [$patientBooking->availability->id, 'status_placeholder']) }}"
                                        method="POST" style="display:inline;">
                                        @csrf
                                        <select class="status" name="status"
                                            onchange="updateFormAction(this, '{{ $patientBooking->availability->id }}')"
                                            class="form-select">
                                            <option value="" disabled selected>{{ __('site.Change Status') }}</option>
                                            @foreach (\App\Enums\BookingEnum::doctorActions() as $status)
                                                <option value="{{ $status }}">{{ __($status) }}</option>
                                            @endforeach
                                        </select>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="pagination1">
                    {{$patientBookings->links('pagination::bootstrap-4')}}
                </div>
            </div>
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

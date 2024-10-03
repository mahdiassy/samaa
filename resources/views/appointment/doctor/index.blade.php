@extends('layouts.master')
@section('content')
    <!-- users list start -->
    <section class="users-list-wrapper">
        <div class="col-12 px-0 d-flex justify-content-end align-items-right mb-2">
            <a href="{{ route('patient.create') }}" class="btn btn-sm btn-primary">Create Patient</a>
        </div>
        <div class="users-list-table">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <!-- datatable start -->
                        <div class="table-responsive">
                            <table id="users-list-datatable" class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Patient Name</th>
                                        <th>Patient Phone</th>
                                        <th>Booking Date</th>
                                        <th>Booking status</th>
                                        <th>Change Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($patientBookings as $patientBooking)
                                        <tr>
                                            <td>{{ $patientBooking->id }}</td>
                                            <td>
                                                <span class="text-truncate">
                                                    <a
                                                        href="{{ route('patient.show', $patientBooking->patient->first_name) }}">{{ $patientBooking->patient->first_name }}</a></span>
                                            </td>
                                            <td>{{ $patientBooking->patient->phone }}</td>
                                            <td>{{ $patientBooking->availability->time }}</td>
                                            <td>{{ $patientBooking->status }}</td>
                                            <td>
                                                <form id="status-form-{{ $patientBooking->availability->id }}" action="{{ route('changeStatus', [$patientBooking->availability->id, 'status_placeholder']) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    <select name="status" onchange="updateFormAction(this, '{{ $patientBooking->availability->id }}')" class="form-select">
                                                        <option value="" disabled selected>Change Status</option>
                                                        @foreach(\App\Enums\BookingEnum::all() as $status)
                                                            <option value="{{ $status }}">{{ $status }}</option>
                                                        @endforeach
                                                    </select>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- datatable ends -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- users list ends -->
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

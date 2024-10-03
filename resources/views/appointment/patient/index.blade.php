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
                                        <th>Doctor Name</th>
                                        <th>Doctor Specialization</th>
                                        <th>Booking Date</th>
                                        <th></th>
                                        <th>Booking status</th>
                                        <th></th>
                                        <th>Canceled</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($patientBookings as $patientBooking)
                                        <tr>
                                            <td>{{ $patientBooking->id }}</td>
                                            <td>
                                                <span class="text-truncate">
                                                    <a
                                                        href="{{ route('doctor.show', $patientBooking->availability->doctor) }}">{{ $patientBooking->availability->doctor->first_name .' '. $patientBooking->availability->doctor->last_name }}</a></span>
                                            </td>
                                            <td>{{ $patientBooking->availability->doctor->specialization }}</td>
                                            <td>{{ $patientBooking->availability->time }}</td>
                                            <td></td>
                                            <td>{{ $patientBooking->status }}</td>
                                            <td></td>
                                            <td>
                                                <form action="{{ route('changeStatus', [$patientBooking->availability->id, \App\Enums\BookingEnum::PATIENT_CANCEL]) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    <button type="submit" class="btn btn-link" style="border: none; background: none;">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"
                                                            class="main-grid-item-icon" fill="none" stroke="currentColor" stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-width="2">
                                                            <polyline points="3 6 5 6 21 6" />
                                                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                                                            <line x1="10" x2="10" y1="11" y2="17" />
                                                            <line x1="14" x2="14" y1="11" y2="17" />
                                                        </svg>
                                                    </button>
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

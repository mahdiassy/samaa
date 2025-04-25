@extends('layouts.master2')
@section('content')
    <div class="main-content">
        @include('search_form')
        <div class="patient-contaier">

            <div class="actions">
                <div class="title-container">
                    <h1 class="page-title">{{ __('site.My Bookings') }}</h1>
                </div>
                <div class="button-container2">
                    <a href="{{ route('therapy.index') }}" class="add-primery-btn">{{ __('site.All Therapies') }}</a>

                    <a href="{{ route('doctor.index') }}" class="add-patient-btn">{{ __('site.Booking with a doctor') }}</a>
                </div>
            </div>

            <div class="table-container">
                <table id="patientTable" class="patient-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ __('site.Doctor Name') }}</th>
                            <th>{{ __('site.Doctor Specialization') }}</th>
                            <th>{{ __('site.Booking Date') }}</th>
                            <th>{{ __('site.Booking status') }}</th>
                            <th>{{ __('site.Canceled') }}</th>
                        </tr>
                    </thead>
                    <tbody id="patientTbody">
                        @foreach ($patientBookings as $key => $patientBooking)
                            <tr id="{{ $key }}">
                                <td>{{ $patientBooking->id }}</td>
                                <td>
                                    <span class="text-truncate">
                                        <a class="link"
                                            href="{{ route('doctor.show', $patientBooking->availability->doctor) }}">{{ $patientBooking->availability->doctor->first_name . ' ' . $patientBooking->availability->doctor->last_name }}</a></span>
                                </td>
                                <td>{{ $patientBooking->availability->doctor->specialization }}</td>
                                <td>{{ \Carbon\Carbon::parse($patientBooking->availability->time)->format('d-m-Y') }}</td>

                                <td class="custom-date">{{ __($patientBooking->status) }}</td>
                                <td>
                                    @if ($patientBooking->status == \App\Enums\BookingEnum::DOCTOR_CANCEL)
                                        <a href="{{ route('patients.calendar', $patientBooking->availability->doctor) }}"
                                            class="btn edit-btn">
                                            {{ __('site.Reschedule appointment') }}
                                        </a>
                                    @endif

                                    <form class="btn delete-btn"
                                        action="{{ route('changeStatus', [$patientBooking->availability->id, \App\Enums\BookingEnum::PATIENT_CANCEL]) }}"
                                        method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-link" style="border: none; background: none;">
                                            <strong>X</strong>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="pagination1">
                    {{ $patientBookings->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
@endsection

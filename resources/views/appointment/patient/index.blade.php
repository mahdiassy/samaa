@extends('layouts.master2')
@section('content')
    <div class="main-content">
        <div class="search-container">
            <input type="text" placeholder="{{ __('site.Search') }}">
            <button>
                <svg width="19" height="20" viewBox="0 0 21 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M20.75 20.1895L15.086 14.5255C16.4471 12.8914 17.1259 10.7956 16.981 8.67389C16.8362 6.55219 15.879 4.56801 14.3085 3.1341C12.7379 1.7002 10.6751 0.92697 8.54899 0.975279C6.42291 1.02359 4.39729 1.88971 2.89353 3.39347C1.38977 4.89723 0.523649 6.92284 0.47534 9.04893C0.427031 11.175 1.20026 13.2379 2.63416 14.8084C4.06807 16.3789 6.05225 17.3361 8.17395 17.481C10.2957 17.6258 12.3915 16.9471 14.0255 15.586L19.6895 21.25L20.75 20.1895ZM2.00003 9.24996C2.00003 7.91494 2.39591 6.6099 3.13761 5.49987C3.87931 4.38983 4.93351 3.52467 6.16691 3.01378C7.40031 2.50289 8.75751 2.36921 10.0669 2.62966C11.3763 2.89011 12.579 3.53299 13.523 4.47699C14.467 5.421 15.1099 6.62373 15.3703 7.9331C15.6308 9.24248 15.4971 10.5997 14.9862 11.8331C14.4753 13.0665 13.6102 14.1207 12.5001 14.8624C11.3901 15.6041 10.085 16 8.75003 16C6.96042 15.998 5.24469 15.2862 3.97925 14.0207C2.71381 12.7553 2.00201 11.0396 2.00003 9.24996Z"
                        fill="#818181" />
                </svg>
            </button>
        </div>
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

                                <td class="custom-date">{{ $patientBooking->status }}</td>
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

@extends('layouts.master2')
@section('content')
    <div class="main-content">
        @include('search_form')
        <div class="patient-contaier">

            <div class="actions">
                <div class="title-container">
                    <h1 class="page-title">{{ __('site.Doctor list') }}</h1>
                </div>
                <div class="button-container">
                    <a href="#" class="filter-link">
                        {{ __('site.Filter') }}
                        <svg width="19" height="22" viewBox="0 0 19 22" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M8.3298 1L3.3998 8.9M2.7998 1H15.9998C17.0998 1 17.9998 1.9 17.9998 3V5.2C17.9998 6 17.4998 7 16.9998 7.5L12.6998 11.3C12.0998 11.8 11.6998 12.8 11.6998 13.6V17.9C11.6998 18.5 11.2998 19.3 10.7998 19.6L9.39981 20.5C8.09981 21.3 6.2998 20.4 6.2998 18.8V13.5C6.2998 12.8 5.8998 11.9 5.4998 11.4L1.6998 7.4C1.1998 6.9 0.799805 6 0.799805 5.4V3.1C0.799805 1.9 1.6998 1 2.7998 1Z"
                                stroke="#1A655E" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </a>
                    @role('Admin')
                        <a href="{{ route('doctor.create') }}" class="add-patient-btn">{{ __('site.Add New Doctor') }}</a>
                    @endrole
                    @role('Patient')
                        <a href="{{ route('patients.booking.index') }}" class="add-patient-btn">{{ __('site.My Bookings') }}</a>
                    @endrole
                </div>
            </div>

            <div class="table-container">
                <table id="patientTable" class="patient-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ __('site.Full Name') }}</th>
                            <th>{{ __('site.Phone') }}</th>
                            <th>{{ __('site.Address') }}</th>
                            <th>{{ __('site.Birthday') }}</th>
                            <th>{{ __('site.Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody id="patientTbody">
                        @foreach ($doctors as $doctor)
                            <tr>
                                <td>{{ $doctor->id }}</td>
                                <td>{{ $doctor->first_name }} {{ $doctor->last_name }}</td>
                                <td>{{ $doctor->phone }}</td>
                                <td>{{ $doctor->address }}</td>
                                <td class="custom-date">{{ \Carbon\Carbon::parse($doctor->birthday)->format('d-m-Y') }}</td>
                                <td>
                                    @role('Patient')
                                        <a href="{{ route('patients.calendar', $doctor) }}" class="btn edit-btn">{{ __('site.Book an appointment') }}</a>
                                    @endrole
                                    <a href="{{ route('doctor.show', $doctor) }}" class="btn view-btn">{{ __('site.View') }}</a>
                                    @role('Admin')
                                        <a href="{{ route('doctor.edit', $doctor) }}" class="btn edit-btn">{{ __('site.Edit') }}</a>

                                        <!--<form action="{{ route('doctor.destroy', $doctor) }}" method="post" class="m-0"
                                            id="deleteForm-{{ $doctor->id }}">
                                            @csrf
                                            @method('delete')
                                            <a class="btn delete-btn"
                                                onclick="event.preventDefault(); document.getElementById('deleteForm-{{ $doctor->id }}').submit();">
                                                <strong>X</strong>
                                            </a>
                                        </form>-->
                                    @endrole
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="pagination1">
                    {{$doctors->links('pagination::bootstrap-4')}}
                </div>
            </div>
        </div>
    </div>
@endsection

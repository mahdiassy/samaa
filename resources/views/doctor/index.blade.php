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

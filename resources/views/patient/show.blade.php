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
        <div class="header">
            <a href="{{ route('patient.index') }}" class="btn-back">
                @if (App::getLocale() == 'ar')
                <i class="fas fa-long-arrow-alt-right" aria-hidden="true"></i> {{ __('site.Go Back') }}
                @else
                <i class="fas fa-long-arrow-alt-left" aria-hidden="true"></i> {{ __('site.Go Back') }}
                @endif
            </a>
        </div>
        <div>
            <div class="profile-details">
                <div class="profile-info">
                    <div class="profile-header">
                        <img src="{{ Storage::url($patient->image) }}" alt="Patient Photo" class="profile-img">
                        <a href="{{ route('patient.edit', $patient) }}" class="btn-edit">+ {{ __('site.Edit') }}</a>
                    </div>

                </div>
                <div class="visit-details">

                    <div class="user-info">
                        <p class="big-title">{{ $patient->first_name }} {{ $patient->last_name }}</p>
                        <div class="small-title">
                            <p>{{ __('site.Patient Gender') }}: {{ $patient->gender}}</p>
                            <p>{{ __('site.ID') }}:#{{ $patient->id }}</p>
                        </div>
                        <div class="text-info">
                            <p><strong>{{ __('site.Country') }}:</strong> {{ $patient->country->name }}</p>

                            <p><strong>{{ __('site.Birthday') }}:</strong> {{ \Carbon\Carbon::parse($patient->birthday)->format('d-m-Y') }}</p>
                        </div>
                        <div class="text-info">
                            <p><strong>{{ __('site.Email Address') }}:</strong></p>
                            <p>{{ $patient->user->email }}</p>

                            <p><strong>{{ __('site.Phone') }}:</strong></p>
                            <p>{{ $patient->phone }}</p>
                        </div>
                    </div>
                    <div class="diagnosis">
                        <div class="text-info">
                            <p><strong>{{ __('site.Blood Type') }}</strong></p>
                            <p>{{ $patient->blood_type }}</p>
                        </div>
                        <div class="text-info">
                            <p><strong>{{ __('site.Smoker') }}:</strong> {{ $patient->is_smoker }}</p>
                        </div>
                        <div class="text-info">
                            <p><strong>Weight (Kg)</strong></p>
                            <p>{{ $patient->weight }}</p>
                        </div>

                        <div class="text-info">

                            <p><strong>Height (cm)</strong></p>
                            <p>{{ $patient->height }}</p>
                        </div>
                    </div>
                </div>
                <div class="action-buttons">
                    <a href="{{ route('patient.index') }}" class="btn patient-btn">Patient List</a>
                    @role('Admin')
                    <a href="{{ route('feedback-list') }}" class="btn patient-btn">Feedback</a>
                    @endrole

                    @role('Doctor')
                        <a href="{{ route('doctors.calendar') }}" class="btn patient-btn">+ Schedule Appointment</a>
                    @endrole
                </div>
            </div>
        </div>
    </div>
@endsection

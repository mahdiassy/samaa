@extends('layouts.master2')
@section('content')
    <div class="main-content">
        @include('search_form')
        <div class="header">
            <a href="{{ route('patient.index') }}" class="btn-back">
                @if(App::getLocale() == 'ar')
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
                        <img src="{{ $patient->image ? Storage::url($patient->image) : asset('assets/images/avatar1.png') }}" alt="Patient Photo" class="profile-img">
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

                        <div class="text-info">
                            <p><strong>{{ __('site.more_description') }} </strong></p>
                            <p>{{ $patient->open_description }}</p>
                        </div>
                    </div>
                    <div class="diagnosis">
                        @if($psychologicals && $psychologicals->count())
                            <div class="text-info">
                                <p><strong>{{ __('site.Have you been diagnosed with any of the following mental health conditions?') }}:</strong></p>
                                <p>    @foreach($psychologicals as $psychological)
                                    {{ $psychological->getTranslatedName() }}
                                    @if(!$loop->last), @endif
                                    @endforeach
                                </p>
                            </div>
                        @endif

                        @if($nervouses && $nervouses->count())
                            <div class="text-info">
                                <p><strong>{{ __('site.Have you ever been diagnosed with any neurological conditions?') }}:</strong></p>
                                <p>
                                    @foreach($nervouses as $nervous)
                                        {{ $nervous->getTranslatedName() }}
                                        @if(!$loop->last), @endif
                                    @endforeach
                                </p>
                            </div>
                        @endif

                        @if($therapeutic_areas && $therapeutic_areas->count())
                            <div class="text-info">
                                <p><strong>{{ __('site.Are you currently taking any medications for mental health conditions?') }}:</strong></p>
                                <p>
                                    @foreach($therapeutic_areas as $therapeutic_area)
                                        {{ $therapeutic_area->getTranslatedName() }}
                                        @if(!$loop->last), @endif
                                    @endforeach
                                </p>
                            </div>
                        @endif

                        @if($medications)
                        <div class="text-info">
                            <p><strong>{{ __('site.medication names') }}:</strong></p>
                            <p>{{ $medications}}</p>
                        </div>
                        @endif

                        @if($symptomes && $symptomes->count())
                            <div class="text-info">
                                <p><strong>{{ __('site.Have you experienced any of the following symptoms in the past 6 months?') }}:</strong></p>
                                <p>
                                    @foreach($symptomes as $symptom)
                                    {{ $symptom->getTranslatedName() }}
                                    @if(!$loop->last), @endif
                                    @endforeach
                                </p>
                            </div>
                        @endif

                        @if($addictiones && $addictiones->count())
                            <div class="text-info">
                                <p><strong>{{ __('site.Do you have a history of substance use or addiction?') }}:</strong></p>
                                <p>
                                    @foreach($addictiones as $addiction)
                                        {{ $addiction->getTranslatedName() }}
                                        @if(!$loop->last), @endif
                                    @endforeach
                                </p>
                            </div>
                        @endif

                        <div class="text-info">
                            <p><strong>{{ __('site.Do you have any chronic physical health conditions?') }}:</strong></p>
                            <p>
                                @foreach($diseases as $disease)
                                    {{ $disease->getTranslatedName() }}
                                    @if(!$loop->last), @endif
                                @endforeach
                            </p>
                        </div>

                        <div class="text-info">
                            <p><strong>{{ __('site.Have you experienced any major life events or traumas that may impact your mental health?') }}:</strong></p>
                            <p>
                                @foreach($incidents as $incident)
                                    {{ $incident->getTranslatedName() }}
                                    @if(!$loop->last), @endif
                                @endforeach
                            </p>
                        </div>
                        @if($consultationes)
                            <div class="text-info">
                                <p><strong>{{ __('site.Have you ever received therapy or counseling before?') }}:</strong></p>
                                <p>
                                    @foreach($consultationes as $consultation)
                                        {{ $consultation->getTranslatedName() }}
                                        @if(!$loop->last), @endif
                                    @endforeach
                                </p>
                            </div>
                        @endif

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

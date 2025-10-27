@extends('layouts.master2')
@section('content')
    <style>
        /* Enhanced Patient Show Page - User-Friendly Design */
        
        /* Main Content Container */
        .main-content {
            padding: 2rem;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            min-height: 100vh;
        }

        /* Header Section */
        .header {
            margin-bottom: 2rem;
        }

        .btn-back {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            border: none;
            font-size: 0.9rem;
        }

        .btn-back:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(79, 70, 229, 0.3);
            color: white;
            text-decoration: none;
        }

        .btn-back i {
            font-size: 1rem;
        }

        /* Profile Details Container */
        .profile-details {
            background: white;
            border-radius: 20px;
            padding: 2.5rem;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
            border: 1px solid #e5e7eb;
        }

        /* Profile Header */
        .profile-header {
            display: flex;
            align-items: center;
            gap: 2rem;
            margin-bottom: 2rem;
            padding-bottom: 2rem;
            border-bottom: 2px solid #f3f4f6;
        }

        .profile-img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #e5e7eb;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .btn-edit {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            padding: 0.875rem 1.75rem;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            font-size: 0.9rem;
        }

        .btn-edit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(16, 185, 129, 0.3);
            color: white;
            text-decoration: none;
        }

        /* User Information */
        .user-info {
            margin-bottom: 2rem;
        }

        .big-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: #1f2937;
            margin: 0 0 1rem 0;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .small-title {
            display: flex;
            gap: 2rem;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
        }

        .small-title p {
            background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
            color: #374151;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            margin: 0;
            font-weight: 600;
            font-size: 0.9rem;
        }

        /* Text Information Sections */
        .text-info {
            background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            border: 1px solid #e5e7eb;
            transition: all 0.3s ease;
        }

        .text-info:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.05);
            border-color: #d1d5db;
        }

        .text-info p {
            color: #374151;
            font-size: 1rem;
            line-height: 1.6;
            margin: 0 0 0.5rem 0;
        }

        .text-info p:last-child {
            margin-bottom: 0;
        }

        .text-info strong {
            color: #1f2937;
            font-weight: 700;
            display: block;
            margin-bottom: 0.5rem;
            font-size: 1.1rem;
        }

        /* Diagnosis Section */
        .diagnosis {
            margin-top: 2rem;
        }

        .diagnosis .text-info {
            background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
            border-color: #bfdbfe;
        }

        .diagnosis .text-info strong {
            color: #1e40af;
        }

        /* Visit Details */
        .visit-details {
            margin-bottom: 2rem;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            align-items: center;
            padding-top: 2rem;
            border-top: 2px solid #f3f4f6;
            flex-wrap: wrap;
        }

        .patient-btn {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            color: white;
            padding: 1rem 2rem;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            font-size: 1rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .patient-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(79, 70, 229, 0.3);
            color: white;
            text-decoration: none;
            background: linear-gradient(135deg, #7c3aed 0%, #4f46e5 100%);
        }

        /* Special Styling for Different Information Types */
        .text-info:nth-child(odd) {
            background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
            border-color: #bbf7d0;
        }

        .text-info:nth-child(odd) strong {
            color: #166534;
        }

        .text-info:nth-child(even) {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            border-color: #fbbf24;
        }

        .text-info:nth-child(even) strong {
            color: #92400e;
        }

        /* Contact Information Highlight */
        .text-info:has(strong:contains("Email")) {
            background: linear-gradient(135deg, #ede9fe 0%, #ddd6fe 100%);
            border-color: #c4b5fd;
        }

        .text-info:has(strong:contains("Phone")) {
            background: linear-gradient(135deg, #ede9fe 0%, #ddd6fe 100%);
            border-color: #c4b5fd;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .main-content {
                padding: 1rem;
            }

            .profile-details {
                padding: 1.5rem;
            }

            .profile-header {
                flex-direction: column;
                text-align: center;
                gap: 1.5rem;
            }

            .big-title {
                font-size: 2rem;
            }

            .small-title {
                flex-direction: column;
                gap: 0.5rem;
            }

            .action-buttons {
                flex-direction: column;
                gap: 1rem;
            }

            .patient-btn {
                width: 100%;
                justify-content: center;
            }
        }

        /* Search Form Styling */
        .search-form {
            margin-bottom: 2rem;
        }

        /* Loading Animation */
        .text-info {
            animation: fadeInUp 0.6s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Hover Effects for Better UX */
        .profile-img:hover {
            transform: scale(1.05);
            transition: transform 0.3s ease;
        }

        /* Text Selection */
        ::selection {
            background: rgba(79, 70, 229, 0.2);
            color: #1f2937;
        }
    </style>

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

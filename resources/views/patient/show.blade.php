@extends('layouts.master2')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/admin/patient-show-page.css') }}">
@endpush

@section('content')
    @php
        $age = $patient->birthday ? \Carbon\Carbon::parse($patient->birthday)->age : null;
        $formatList = function ($items) {
            if (!$items) {
                return null;
            }

            $collection = $items instanceof \Illuminate\Support\Collection ? $items : collect($items);

            if ($collection->isEmpty()) {
                return null;
            }

            return $collection->map(function ($item) {
                return $item->getTranslatedName();
            })->implode(', ');
        };

        $psychologicalList = $formatList($psychologicals);
        $neurologicalList = $formatList($nervouses);
        $therapeuticList = $formatList($therapeutic_areas);
        $symptomList = $formatList($symptomes);
        $addictionList = $formatList($addictiones);
        $diseaseList = $formatList($diseases);
        $incidentList = $formatList($incidents);
        $consultationList = $formatList($consultationes);
        $backRoute = route('patient.index');
    @endphp

    <div class="patient-view-page">
        <div class="patient-management-content">
            <div class="page-header">
                <div class="header-content">
                    <div class="header-info">
                        <h1 class="page-title">{{ $patient->first_name }} {{ $patient->last_name }}</h1>
                        <p class="page-subtitle">
                            {{ __('site.Patient Gender') }}: {{ $patient->gender ?? 'N/A' }}
                        </p>
                    </div>
                    <div class="header-actions">
                        <a href="{{ $backRoute }}" class="header-btn ghost-btn">
                            @if (App::getLocale() === 'ar')
                                <span>{{ __('site.Go Back') }}</span>
                                <i class="fas fa-long-arrow-alt-right" aria-hidden="true"></i>
                            @else
                                <i class="fas fa-long-arrow-alt-left" aria-hidden="true"></i>
                                <span>{{ __('site.Go Back') }}</span>
                            @endif
                        </a>
                        <a href="{{ route('patient.edit', $patient) }}" class="header-btn primary-btn">
                            <i class="fas fa-edit" aria-hidden="true"></i>
                            <span>{{ __('site.Edit') }}</span>
                        </a>
                    </div>
                </div>
                <div class="header-meta">
                    <span class="meta-chip">{{ __('site.ID') }} #{{ $patient->id }}</span>
                    @if ($patient->birthday)
                        <span class="meta-chip">
                            {{ __('site.Birthday') }}: {{ \Carbon\Carbon::parse($patient->birthday)->format('d-m-Y') }}
                        </span>
                    @endif
                    @if ($age)
                        <span class="meta-chip">{{ $age }} yrs</span>
                    @endif
                    <span class="meta-chip">{{ __('site.Country') }}: {{ optional($patient->country)->name ?? 'N/A' }}</span>
                </div>
            </div>

            <div class="search-card">
                @include('search_form')
            </div>

            <div class="content-shell">
                <aside class="media-panel">
                    <div class="avatar-wrapper">
                        <img src="{{ $patient->image ? Storage::url($patient->image) : asset('assets/images/avatar1.png') }}"
                             alt="{{ $patient->first_name }} {{ $patient->last_name }}" class="profile-img">
                    </div>
                    <div class="info-card">
                        <div class="info-row">
                            <span class="label">{{ __('site.Email Address') }}</span>
                            <span class="value">{{ optional($patient->user)->email ?? 'N/A' }}</span>
                        </div>
                        <div class="info-row">
                            <span class="label">{{ __('site.Phone') }}</span>
                            <span class="value">{{ $patient->phone ?? 'N/A' }}</span>
                        </div>
                        <div class="info-row">
                            <span class="label">{{ __('site.Country') }}</span>
                            <span class="value">{{ optional($patient->country)->name ?? 'N/A' }}</span>
                        </div>
                        <div class="info-row">
                            <span class="label">{{ __('site.Birthday') }}</span>
                            <span class="value">
                                {{ $patient->birthday ? \Carbon\Carbon::parse($patient->birthday)->format('d-m-Y') : 'N/A' }}
                            </span>
                        </div>
                    </div>
                    @if (!empty($patient->open_description))
                        <div class="note-card">
                            <h3>{{ __('site.more_description') }}</h3>
                            <p>{{ $patient->open_description }}</p>
                        </div>
                    @endif
                </aside>

                <section class="details-panel">
                    @if ($psychologicalList || $neurologicalList || $therapeuticList || $symptomList || $addictionList || $consultationList)
                        <div class="section-block">
                            <div class="section-heading">
                                <h2>Mental Health Overview</h2>
                            </div>
                            <div class="detail-grid">
                                @if ($psychologicalList)
                                    <div class="detail-item">
                                        <span class="detail-label">{{ __('site.Have you been diagnosed with any of the following mental health conditions?') }}</span>
                                        <p class="detail-value">{{ $psychologicalList }}</p>
                                    </div>
                                @endif

                                @if ($therapeuticList)
                                    <div class="detail-item">
                                        <span class="detail-label">{{ __('site.Are you currently taking any medications for mental health conditions?') }}</span>
                                        <p class="detail-value">{{ $therapeuticList }}</p>
                                    </div>
                                @endif

                                @if ($consultationList)
                                    <div class="detail-item">
                                        <span class="detail-label">{{ __('site.Have you ever received therapy or counseling before?') }}</span>
                                        <p class="detail-value">{{ $consultationList }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    @if ($neurologicalList || $symptomList || $addictionList || $diseaseList)
                        <div class="section-block">
                            <div class="section-heading">
                                <h2>Health Background</h2>
                            </div>
                            <div class="detail-grid">
                                @if ($neurologicalList)
                                    <div class="detail-item">
                                        <span class="detail-label">{{ __('site.Have you ever been diagnosed with any neurological conditions?') }}</span>
                                        <p class="detail-value">{{ $neurologicalList }}</p>
                                    </div>
                                @endif

                                @if ($symptomList)
                                    <div class="detail-item">
                                        <span class="detail-label">{{ __('site.Have you experienced any of the following symptoms in the past 6 months?') }}</span>
                                        <p class="detail-value">{{ $symptomList }}</p>
                                    </div>
                                @endif

                                @if ($addictionList)
                                    <div class="detail-item">
                                        <span class="detail-label">{{ __('site.Do you have a history of substance use or addiction?') }}</span>
                                        <p class="detail-value">{{ $addictionList }}</p>
                                    </div>
                                @endif

                                @if ($diseaseList)
                                    <div class="detail-item">
                                        <span class="detail-label">{{ __('site.Do you have any chronic physical health conditions?') }}</span>
                                        <p class="detail-value">{{ $diseaseList }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    @if ($incidentList || $medications)
                        <div class="section-block">
                            <div class="section-heading">
                                <h2>Additional Notes</h2>
                            </div>
                            <div class="detail-grid">
                                @if ($medications)
                                    <div class="detail-item">
                                        <span class="detail-label">{{ __('site.medication names') }}</span>
                                        <p class="detail-value">{{ $medications }}</p>
                                    </div>
                                @endif

                                @if ($incidentList)
                                    <div class="detail-item">
                                        <span class="detail-label">{{ __('site.Have you experienced any major life events or traumas that may impact your mental health?') }}</span>
                                        <p class="detail-value">{{ $incidentList }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                </section>
            </div>

            <div class="action-bar">
                <a href="{{ route('patient.index') }}" class="header-btn ghost-btn">
                    <i class="fas fa-users" aria-hidden="true"></i>
                    <span>Patient List</span>
                </a>
                @role('Admin')
                    <a href="{{ route('feedback-list') }}" class="header-btn secondary-btn">
                        <i class="fas fa-comments" aria-hidden="true"></i>
                        <span>Feedback</span>
                    </a>
                @endrole

                @role('Doctor')
                    <a href="{{ route('doctors.calendar') }}" class="header-btn primary-btn">
                        <i class="fas fa-calendar-plus" aria-hidden="true"></i>
                        <span>Schedule Appointment</span>
                    </a>
                @endrole
            </div>
        </div>
    </div>
@endsection

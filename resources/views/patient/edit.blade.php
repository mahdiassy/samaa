@extends('layouts.master2')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/admin/patient-create-page.css') }}">
@endpush

@section('content')
    @php
        $backRoute = Route::has('patient.index') ? route('patient.index') : url()->previous();
        $viewRoute = Route::has('patient.show') ? route('patient.show', $patient) : null;
        $currentLocale = app()->getLocale();

    $oldPsychological = (array) old('psychological_diseases', ($patient->psychologicals ?? collect())->pluck('id')->toArray());
    $oldSymptoms = (array) old('symptoms', ($patient->symptomes ?? collect())->pluck('id')->toArray());
    $oldNervouses = (array) old('nervouses', ($patient->nervouses ?? collect())->pluck('id')->toArray());
    $oldIncidents = (array) old('incidents', ($patient->incidents ?? collect())->pluck('id')->toArray());
    $oldDiseases = (array) old('diseases', ($patient->diseases ?? collect())->pluck('id')->toArray());

    $therapeuticSelected = old('therapeutic_areas', ($patient->therapeutic_areas ?? collect())->pluck('id')->first());
    $consultationSelected = old('consultation', ($patient->consultationes ?? collect())->pluck('id')->first());
    $addictionSelected = old('addiction', ($patient->addictiones ?? collect())->pluck('id')->first());
        $languageSelected = old('language', optional($patient->language)->id ?? '');
        $countrySelected = old('country', optional($patient->country)->id ?? '');
        $showMedication = (string) $therapeuticSelected === '2' || filled(old('medications', $medications ?? ''));
    @endphp

    <div class="admin-page-container patient-create-page patient-edit-page">
        <div class="page-header">
            <div class="header-content">
                <div class="header-info">
                    <h1 class="page-title">{{ __('site.Edit Patient Profile') }}</h1>
                    <p class="page-subtitle">Refresh personal details and medical history so care teams always act on the latest information.</p>
                </div>

                <div class="header-actions">
                    <a href="{{ $backRoute }}" class="header-btn ghost-btn">
                        @if ($currentLocale === 'ar')
                            <span>{{ __('site.Go Back') }}</span>
                            <i class="fas fa-long-arrow-alt-right" aria-hidden="true"></i>
                        @else
                            <i class="fas fa-long-arrow-alt-left" aria-hidden="true"></i>
                            <span>{{ __('site.Go Back') }}</span>
                        @endif
                    </a>

                    @if ($viewRoute)
                        <a href="{{ $viewRoute }}" class="header-btn secondary-btn">
                            <i class="fas fa-eye" aria-hidden="true"></i>
                            <span>{{ __('site.View Profile') }}</span>
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <div class="guideline-grid">
            <div class="guideline-card">
                <div class="guideline-icon">
                    <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                        <path d="M12 2l3 7h7l-5.5 4.5L18 21l-6-3.5L6 21l1.5-7.5L2 9h7z" />
                    </svg>
                </div>
                <div class="guideline-content">
                    <h3>Strengthen trust</h3>
                    <p>Keep identity and contact data accurate so every interaction feels personal.</p>
                </div>
            </div>
            <div class="guideline-card">
                <div class="guideline-icon">
                    <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                        <path d="M4 5h16v2H4zm0 6h16v2H4zm0 6h10v2H4z" />
                    </svg>
                </div>
                <div class="guideline-content">
                    <h3>Coordinate faster</h3>
                    <p>Ensure language, country, and access details support seamless follow ups.</p>
                </div>
            </div>
            <div class="guideline-card">
                <div class="guideline-icon">
                    <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                        <path d="M12 4a8 8 0 1 0 8 8 8 8 0 0 0-8-8zm3 9h-2v2a1 1 0 0 1-2 0v-2H9a1 1 0 0 1 0-2h2V9a1 1 0 0 1 2 0v2h2a1 1 0 0 1 0 2z" />
                    </svg>
                </div>
                <div class="guideline-content">
                    <h3>Stay proactive</h3>
                    <p>Track treatments and symptoms to deliver timely, personalised support.</p>
                </div>
            </div>
        </div>

        <div class="form-wrapper">
            <form action="{{ route('patient.update', $patient) }}" method="post" enctype="multipart/form-data" class="patient-edit-form">
                @csrf
                @method('put')

                <div class="form-shell">
                    <section class="form-panel media-panel">
                        <header class="panel-header">
                            <h2>{{ __('site.Profile Picture') }}</h2>
                            <p>Keep the profile photo current so teams can recognise patients immediately.</p>
                        </header>

                        <div class="image-upload-wrapper">
                            <input type="file" id="patient-image" name="image" accept="image/*" hidden>
                            <label for="patient-image" class="upload-label">
                                <div class="image-placeholder">
                                    <img id="patient-image-preview" src="{{ $patient->image ? Storage::url($patient->image) : asset('assets/images/avatar1.png') }}" alt="{{ $patient->first_name }} {{ $patient->last_name }}" class="placeholder-img">
                                    <div class="edit-icon">
                                        <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                            <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75zM20.71 7.04a1 1 0 0 0 0-1.41l-2.34-2.34a1 1 0 0 0-1.41 0l-1.83 1.83 3.75 3.75z" />
                                        </svg>
                                    </div>
                                </div>
                            </label>
                            <p class="image-upload-instruction">{{ __('site.Set the Blog thumbnail image. Only *.png, *.jpg, and *.jpeg image files are accepted') }}</p>
                        </div>

                        <ul class="upload-guidelines">
                            <li>Use a clear, recent headshot with even lighting.</li>
                            <li>Optimal size: 600 × 600 px (minimum 400 × 400 px).</li>
                            <li>Ensure the file is under 2&nbsp;MB and saved as JPG or PNG.</li>
                        </ul>
                    </section>

                    <section class="form-panel content-panel">
                        <header class="panel-header">
                            <h2>{{ __('site.Patient Profile') }}</h2>
                            <p>Update personal, communication, and health information to keep records aligned.</p>
                        </header>

                        <div class="section-block">
                            <div class="section-heading">
                                <h3>{{ __('site.Personal Information') }}</h3>
                                <p>Primary identifiers displayed on the patient dashboard.</p>
                            </div>

                            <div class="input-grid two-col">
                                <div class="input-group">
                                    <label for="first_name">{{ __('site.First Name') }}</label>
                                    <input type="text" id="first_name" name="first_name" class="form-input" placeholder="{{ __('site.First Name') }}" value="{{ old('first_name', $patient->first_name) }}" required>
                                    @error('first_name')
                                        <span class="error-message">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="input-group">
                                    <label for="surname">{{ __('site.Surname') }}</label>
                                    <input type="text" id="surname" name="surname" class="form-input" placeholder="{{ __('site.Surname') }}" value="{{ old('surname', $patient->last_name) }}">
                                    @error('surname')
                                        <span class="error-message">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="input-group span-2">
                                    <label for="email">{{ __('site.Email Address') }}</label>
                                    <input type="email" id="email" name="email" class="form-input" placeholder="{{ __('site.Email Address') }}" value="{{ old('email', optional($patient->user)->email) }}" required>
                                    @error('email')
                                        <span class="error-message">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="input-group">
                                    <label for="phone">{{ __('site.Phone') }}</label>
                                    <input type="text" id="phone" name="phone" class="form-input" placeholder="{{ __('site.Phone') }}" value="{{ old('phone', $patient->phone) }}">
                                    @error('phone')
                                        <span class="error-message">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="input-group">
                                    <label for="gender">{{ __('site.Gender') }}</label>
                                    <select id="gender" name="gender" class="form-input" required>
                                        <option value="" disabled {{ $patient->gender || old('gender') ? '' : 'selected' }}>{{ __('Select gender') }}</option>
                                        <option value="female" {{ old('gender', $patient->gender) === 'female' ? 'selected' : '' }}>{{ __('site.Female') }}</option>
                                        <option value="male" {{ old('gender', $patient->gender) === 'male' ? 'selected' : '' }}>{{ __('site.Male') }}</option>
                                    </select>
                                    @error('gender')
                                        <span class="error-message">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="input-group">
                                    <label for="birthday">{{ __('site.Birthday') }}</label>
                                    <input type="date" id="birthday" name="birthday" class="form-input" value="{{ old('birthday', $patient->birthday ? \Carbon\Carbon::parse($patient->birthday)->format('Y-m-d') : '') }}">
                                    @error('birthday')
                                        <span class="error-message">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="section-block">
                            <div class="section-heading">
                                <h3>{{ __('site.Contact Information') }}</h3>
                                <p>Ensure you can reach the patient using their preferred language and location.</p>
                            </div>

                            <div class="input-grid two-col">
                                <div class="input-group">
                                    <label for="country_id">{{ __('site.Country') }}</label>
                                    <select id="country_id" name="country_id" class="form-input" required>
                                        <option value="" disabled {{ $countrySelected ? '' : 'selected' }}>{{ __('Select country') }}</option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->id }}" {{ (string) $countrySelected === (string) $country->id ? 'selected' : '' }}>{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('country_id')
                                        <span class="error-message">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="input-group">
                                    <label for="language_id">{{ __('site.Language Spoken') }}</label>
                                    <select id="language_id" name="language_id" class="form-input" required>
                                        <option value="" disabled {{ $languageSelected ? '' : 'selected' }}>{{ __('Select language') }}</option>
                                        @foreach ($languages as $language)
                                            <option value="{{ $language->id }}" {{ (string) $languageSelected === (string) $language->id ? 'selected' : '' }}>{{ $language->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('language_id')
                                        <span class="error-message">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="section-block">
                            <div class="section-heading">
                                <h3>{{ __('site.Medical History') }}</h3>
                                <p>Track mental health diagnoses, active treatments, and symptoms.</p>
                            </div>

                            <div class="input-grid">
                                <div class="input-group">
                                    <label for="psychological_diseases">{{ __('site.Have you been diagnosed with any of the following mental health conditions?') }} {{ __('site.Select all that apply') }}</label>
                                    <select id="psychological_diseases" name="psychological_diseases[]" class="form-input select2 diseases-select-backend" multiple>
                                        @foreach ($psychological_diseases as $psychological_disease)
                                            <option value="{{ $psychological_disease->id }}" {{ in_array($psychological_disease->id, $oldPsychological, true) ? 'selected' : '' }}>
                                                {{ $psychological_disease->getTranslatedName() }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="input-group">
                                    <label for="therapeutic_areas_select">{{ __('site.Are you currently taking any medications for mental health conditions?') }}</label>
                                    <select id="therapeutic_areas_select" name="therapeutic_areas" class="form-input" required>
                                        <option value="" disabled {{ $therapeuticSelected ? '' : 'selected' }}>{{ __('Select option') }}</option>
                                        @foreach ($therapeutic_areas as $therapeutic_area)
                                            <option value="{{ $therapeutic_area->id }}" {{ (string) $therapeuticSelected === (string) $therapeutic_area->id ? 'selected' : '' }}>{{ $therapeutic_area->getTranslatedName() }}</option>
                                        @endforeach
                                    </select>
                                    @error('therapeutic_areas')
                                        <span class="error-message">{{ $message }}</span>
                                    @enderror

                                    <div id="medication_input_wrapper" class="medication-wrapper" style="{{ $showMedication ? '' : 'display: none;' }}">
                                        <label for="medications">{{ __('site.Please list the medications you are taking') }}</label>
                                        <input type="text" id="medications" name="medications" class="form-input" placeholder="{{ __('site.Enter medication names') }}" value="{{ old('medications', $medications ?? '') }}">
                                        @error('medications')
                                            <span class="error-message">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="input-group">
                                    <label for="symptoms_select">{{ __('site.Have you experienced any of the following symptoms in the past 6 months?') }} {{ __('site.Select all that apply') }}</label>
                                    <select id="symptoms_select" name="symptoms[]" class="form-input select2 diseases-select-backend" multiple>
                                        @foreach ($symptoms as $symptom)
                                            <option value="{{ $symptom->id }}" {{ in_array($symptom->id, $oldSymptoms, true) ? 'selected' : '' }}>
                                                {{ $symptom->getTranslatedName() }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="input-group">
                                    <label for="consultation">{{ __('site.Have you ever received therapy or counseling before?') }}</label>
                                    <select id="consultation" name="consultation" class="form-input" required>
                                        <option value="" disabled {{ $consultationSelected ? '' : 'selected' }}>{{ __('Select option') }}</option>
                                        @foreach ($consultations as $consultation)
                                            <option value="{{ $consultation->id }}" {{ (string) $consultationSelected === (string) $consultation->id ? 'selected' : '' }}>{{ $consultation->getTranslatedName() }}</option>
                                        @endforeach
                                    </select>
                                    @error('consultation')
                                        <span class="error-message">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="section-block">
                            <div class="section-heading">
                                <h3>{{ __('site.Health Background') }}</h3>
                                <p>Document neurological history, major incidents, and chronic conditions.</p>
                            </div>

                            <div class="input-grid">
                                <div class="input-group">
                                    <label for="nervouses_select">{{ __('site.Have you ever been diagnosed with any neurological conditions?') }} {{ __('site.Select all that apply') }}</label>
                                    <select id="nervouses_select" name="nervouses[]" class="form-input select2 diseases-select-backend" multiple>
                                        @foreach ($nervouses as $nervous)
                                            <option value="{{ $nervous->id }}" {{ in_array($nervous->id, $oldNervouses, true) ? 'selected' : '' }}>
                                                {{ $nervous->getTranslatedName() }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="input-group">
                                    <label for="addiction">{{ __('site.Do you have a history of substance use or addiction?') }}</label>
                                    <select id="addiction" name="addiction" class="form-input" required>
                                        <option value="" disabled {{ $addictionSelected ? '' : 'selected' }}>{{ __('Select option') }}</option>
                                        @foreach ($addictions as $addiction)
                                            <option value="{{ $addiction->id }}" {{ (string) $addictionSelected === (string) $addiction->id ? 'selected' : '' }}>{{ $addiction->getTranslatedName() }}</option>
                                        @endforeach
                                    </select>
                                    @error('addiction')
                                        <span class="error-message">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="input-group">
                                    <label for="incidents_select">{{ __('site.Have you experienced any major life events or traumas that may impact your mental health?') }} {{ __('site.Select all that apply') }}</label>
                                    <select id="incidents_select" name="incidents[]" class="form-input select2 diseases-select-backend" multiple>
                                        @foreach ($incidents as $incident)
                                            <option value="{{ $incident->id }}" {{ in_array($incident->id, $oldIncidents, true) ? 'selected' : '' }}>
                                                {{ $incident->getTranslatedName() }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="input-group">
                                    <label for="diseases_select">{{ __('site.Do you have any chronic physical health conditions?') }}</label>
                                    <select id="diseases_select" name="diseases[]" class="form-input select2 diseases-select-backend" multiple>
                                        @foreach ($diseases as $disease)
                                            <option value="{{ $disease->id }}" {{ in_array($disease->id, $oldDiseases, true) ? 'selected' : '' }}>
                                                {{ $disease->getTranslatedName() }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>

                <div class="action-bar">
                    <a href="{{ $backRoute }}" class="header-btn ghost-btn">{{ __('site.Cancel') }}</a>
                    <button type="submit" class="header-btn primary-btn">{{ __('site.Update') }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const fileInput = document.getElementById('patient-image');
        const previewImg = document.getElementById('patient-image-preview');
        const form = document.querySelector('.patient-edit-form');
        const requiredInputs = form ? form.querySelectorAll('.form-input[required]') : [];
        const therapeuticSelect = document.getElementById('therapeutic_areas_select');
        const medicationWrapper = document.getElementById('medication_input_wrapper');

        if (fileInput && previewImg) {
            fileInput.addEventListener('change', function (event) {
                const file = event.target.files[0];
                if (!file) {
                    return;
                }

                const reader = new FileReader();
                reader.onload = function (e) {
                    previewImg.src = e.target.result;
                };
                reader.readAsDataURL(file);
            });
        }

        if (therapeuticSelect && medicationWrapper) {
            const toggleMedication = function () {
                medicationWrapper.style.display = therapeuticSelect.value === '2' ? '' : 'none';
            };

            toggleMedication();
            therapeuticSelect.addEventListener('change', toggleMedication);
        }

        requiredInputs.forEach(function (input) {
            input.addEventListener('blur', function () {
                if (input.value.trim() !== '') {
                    input.classList.remove('error');
                    input.classList.add('success');
                } else {
                    input.classList.remove('success');
                }
            });
        });

        if (form) {
            form.addEventListener('submit', function () {
                requiredInputs.forEach(function (input) {
                    if (input.value.trim() === '') {
                        input.classList.add('error');
                    }
                });
            });
        }
    });
</script>
@endpush

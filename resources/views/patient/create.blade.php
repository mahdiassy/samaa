@extends('layouts.master2')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/admin/patient-create-page.css') }}">
@endpush

@section('content')
    @php
        $backRoute = Route::has('patient.index') ? route('patient.index') : url()->previous();
        $currentLocale = app()->getLocale();
        $oldPsychological = (array) old('psychological_diseases', []);
        $oldSymptoms = (array) old('symptoms', []);
        $oldNervouses = (array) old('nervouses', []);
        $oldIncidents = (array) old('incidents', []);
        $oldDiseases = (array) old('diseases', []);
        $showMedication = old('therapeutic_areas') == '2';
    @endphp

    <div class="patient-management-content patient-create-page">
        <div class="page-header">
            <div class="header-content">
                <div class="header-info">
                    <h1 class="page-title">{{ __('site.Add New Patient') }}</h1>
                    <p class="page-subtitle">Onboard patients with confidence by capturing their essential contact details and medical background.</p>
                </div>

                <div class="header-actions">
                    <a href="{{ $backRoute }}" class="header-btn secondary-btn">
                        <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            @if ($currentLocale === 'ar')
                                <path d="M19 11H9.83l3.58-3.59L12 6l-6 6 6 6 1.41-1.41L9.83 13H19v-2z" />
                            @else
                                <path d="M5 13h9.17l-3.58 3.59L12 18l6-6-6-6-1.41 1.41L14.17 11H5v2z" />
                            @endif
                        </svg>
                        {{ __('site.Go Back') }}
                    </a>
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
                    <h3>Capture trust</h3>
                    <p>Gather personal details carefully so every patient feels seen and supported.</p>
                </div>
            </div>
            <div class="guideline-card">
                <div class="guideline-icon">
                    <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                        <path d="M4 5h16v2H4zm0 6h16v2H4zm0 6h10v2H4z" />
                    </svg>
                </div>
                <div class="guideline-content">
                    <h3>Stay organised</h3>
                    <p>Keep contact, language, and location data accurate for seamless follow ups.</p>
                </div>
            </div>
            <div class="guideline-card">
                <div class="guideline-icon">
                    <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                        <path d="M12 4a8 8 0 1 0 8 8 8 8 0 0 0-8-8zm3 9h-2v2a1 1 0 0 1-2 0v-2H9a1 1 0 0 1 0-2h2V9a1 1 0 0 1 2 0v2h2a1 1 0 0 1 0 2z" />
                    </svg>
                </div>
                <div class="guideline-content">
                    <h3>Understand health</h3>
                    <p>Document medical history and ongoing treatments to tailor care pathways.</p>
                </div>
            </div>
        </div>

        <div class="form-wrapper">
            <form action="{{ route('patient.store') }}" method="post" enctype="multipart/form-data" class="patient-create-form">
                @csrf

                <div class="form-shell">
                    <section class="form-panel media-panel">
                        <header class="panel-header">
                            <h2>{{ __('site.Profile Picture') }}</h2>
                            <p>Upload a warm, friendly portrait that patients recognise across the platform.</p>
                        </header>

                        <div class="image-upload-wrapper">
                            <input type="file" id="patient-image" name="image" accept="image/*" hidden>
                            <label for="patient-image" class="upload-label">
                                <div class="image-placeholder">
                                    <img id="patient-image-preview" src="{{ asset('assets/images/avatar1.png') }}" alt="Patient avatar preview" class="placeholder-img">
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
                            <li>Choose a centred headshot with soft, even lighting.</li>
                            <li>Recommended size: 600 × 600 px, minimum 400 × 400 px.</li>
                            <li>Ensure the final file is under 2 MB in JPG or PNG format.</li>
                        </ul>
                    </section>

                    <section class="form-panel content-panel">
                        <header class="panel-header">
                            <h2>{{ __('site.Patient Profile') }}</h2>
                            <p>Complete personal, communication, and medical details so support teams can act quickly.</p>
                        </header>

                        <div class="section-block">
                            <div class="section-heading">
                                <h3>{{ __('site.Personal Information') }}</h3>
                                <p>Core contact fields that appear on the patient dashboard.</p>
                            </div>

                            <div class="input-grid two-col">
                                <div class="input-group">
                                    <label for="first_name">{{ __('site.First Name') }}</label>
                                    <input type="text" id="first_name" name="first_name" class="form-input" placeholder="{{ __('site.First Name') }}" value="{{ old('first_name') }}" required>
                                    @error('first_name')
                                        <span class="error-message">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="input-group">
                                    <label for="last_name">{{ __('site.Surname') }}</label>
                                    <input type="text" id="last_name" name="last_name" class="form-input" placeholder="{{ __('site.Surname') }}" value="{{ old('last_name') }}">
                                    @error('last_name')
                                        <span class="error-message">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="input-group span-2">
                                    <label for="email">{{ __('site.Email Address') }}</label>
                                    <input type="email" id="email" name="email" class="form-input" placeholder="{{ __('site.Email Address') }}" value="{{ old('email') }}" required>
                                    @error('email')
                                        <span class="error-message">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="input-group">
                                    <label for="phone">{{ __('site.Phone') }}</label>
                                    <input type="text" id="phone" name="phone" class="form-input" placeholder="{{ __('site.Phone') }}" value="{{ old('phone') }}">
                                    @error('phone')
                                        <span class="error-message">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="input-group">
                                    <label for="gender">{{ __('site.Gender') }}</label>
                                    <select id="gender" name="gender" class="form-input" required>
                                        <option value="" disabled {{ old('gender') ? '' : 'selected' }}>{{ __('Select gender') }}</option>
                                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>{{ __('site.Female') }}</option>
                                        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>{{ __('site.Male') }}</option>
                                    </select>
                                    @error('gender')
                                        <span class="error-message">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="input-group">
                                    <label for="birthday">{{ __('site.Birthday') }}</label>
                                    <input type="date" id="birthday" name="birthday" class="form-input" value="{{ old('birthday') }}">
                                    @error('birthday')
                                        <span class="error-message">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="input-group span-2">
                                    <label for="password">{{ __('site.Password') }}</label>
                                    <input type="password" id="password" name="password" class="form-input" placeholder="••••••••" autocomplete="new-password" required>
                                    @error('password')
                                        <span class="error-message">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="section-block">
                            <div class="section-heading">
                                <h3>{{ __('site.Contact Information') }}</h3>
                                <p>Help teams coordinate care in the patient’s preferred language and region.</p>
                            </div>

                            <div class="input-grid two-col">
                                <div class="input-group span-2">
                                    <label for="address">{{ __('site.Address') }}</label>
                                    <input type="text" id="address" name="address" class="form-input" placeholder="{{ __('site.Address') }}" value="{{ old('address') }}">
                                    @error('address')
                                        <span class="error-message">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="input-group">
                                    <label for="country">{{ __('site.Country') }}</label>
                                    <select id="country" name="country" class="form-input" required>
                                        <option value="" disabled {{ old('country') ? '' : 'selected' }}>{{ __('Select country') }}</option>
                                        @foreach($countries as $country)
                                            <option value="{{ $country->id }}" {{ old('country') == $country->id ? 'selected' : '' }}>{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('country')
                                        <span class="error-message">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="input-group">
                                    <label for="language">{{ __('site.Language Spoken') }}</label>
                                    <select id="language" name="language" class="form-input" required>
                                        <option value="" disabled {{ old('language') ? '' : 'selected' }}>{{ __('Select language') }}</option>
                                        @foreach($languages as $language)
                                            <option value="{{ $language->id }}" {{ old('language') == $language->id ? 'selected' : '' }}>{{ $language->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('language')
                                        <span class="error-message">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="section-block">
                            <div class="section-heading">
                                <h3>{{ __('site.Medical History') }}</h3>
                                <p>Document the patient’s mental health journey to personalise care plans.</p>
                            </div>

                            <div class="input-grid">
                                <div class="input-group">
                                    <label for="psychological_diseases">{{ __('site.Have you been diagnosed with any of the following mental health conditions?') }} {{ __('site.Select all that apply') }}</label>
                                    <select id="psychological_diseases" name="psychological_diseases[]" class="form-input select2 diseases-select-backend" multiple>
                                        @foreach($psychological_diseases as $psychological_disease)
                                            <option value="{{ $psychological_disease->id }}" {{ in_array($psychological_disease->id, $oldPsychological) ? 'selected' : '' }}>
                                                {{ $psychological_disease->getTranslatedName() }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="input-group">
                                    <label for="therapeutic_areas_select">{{ __('site.Are you currently taking any medications for mental health conditions?') }}</label>
                                    <select name="therapeutic_areas" id="therapeutic_areas_select" class="form-input" required>
                                        <option value="" disabled {{ old('therapeutic_areas') ? '' : 'selected' }}>{{ __('Select option') }}</option>
                                        @foreach($therapeutic_areas as $therapeutic_area)
                                            <option value="{{ $therapeutic_area->id }}" {{ old('therapeutic_areas') == $therapeutic_area->id ? 'selected' : '' }}>{{ $therapeutic_area->getTranslatedName() }}</option>
                                        @endforeach
                                    </select>
                                    @error('therapeutic_areas')
                                        <span class="error-message">{{ $message }}</span>
                                    @enderror

                                    <div id="medication_input_wrapper" class="medication-wrapper" style="{{ $showMedication ? '' : 'display: none;' }}">
                                        <label for="medications">{{ __('site.Please list the medications you are taking') }}</label>
                                        <input type="text" name="medications" id="medications" class="form-input" placeholder="{{ __('site.Enter medication names') }}" value="{{ old('medications') }}">
                                    </div>
                                </div>

                                <div class="input-group">
                                    <label for="symptoms_select">{{ __('site.Have you experienced any of the following symptoms in the past 6 months?') }} {{ __('site.Select all that apply') }}</label>
                                    <select id="symptoms_select" name="symptoms[]" class="form-input select2 diseases-select-backend" multiple>
                                        @foreach($symptoms as $symptom)
                                            <option value="{{ $symptom->id }}" {{ in_array($symptom->id, $oldSymptoms) ? 'selected' : '' }}>
                                                {{ $symptom->getTranslatedName() }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="input-group">
                                    <label for="consultation">{{ __('site.Have you ever received therapy or counseling before?') }}</label>
                                    <select id="consultation" name="consultation" class="form-input" required>
                                        <option value="" disabled {{ old('consultation') ? '' : 'selected' }}>{{ __('Select option') }}</option>
                                        @foreach($consultations as $consultation)
                                            <option value="{{ $consultation->id }}" {{ old('consultation') == $consultation->id ? 'selected' : '' }}>{{ $consultation->getTranslatedName() }}</option>
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
                                <p>Note any neurological conditions, life events, or chronic illnesses that may influence care.</p>
                            </div>

                            <div class="input-grid">
                                <div class="input-group">
                                    <label for="nervouses_select">{{ __('site.Have you ever been diagnosed with any neurological conditions?') }} {{ __('site.Select all that apply') }}</label>
                                    <select id="nervouses_select" name="nervouses[]" class="form-input select2 diseases-select-backend" multiple>
                                        @foreach($nervouses as $nervous)
                                            <option value="{{ $nervous->id }}" {{ in_array($nervous->id, $oldNervouses) ? 'selected' : '' }}>
                                                {{ $nervous->getTranslatedName() }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="input-group">
                                    <label for="addiction">{{ __('site.Do you have a history of substance use or addiction?') }}</label>
                                    <select id="addiction" name="addiction" class="form-input" required>
                                        <option value="" disabled {{ old('addiction') ? '' : 'selected' }}>{{ __('Select option') }}</option>
                                        @foreach($addictions as $addiction)
                                            <option value="{{ $addiction->id }}" {{ old('addiction') == $addiction->id ? 'selected' : '' }}>{{ $addiction->getTranslatedName() }}</option>
                                        @endforeach
                                    </select>
                                    @error('addiction')
                                        <span class="error-message">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="input-group">
                                    <label for="incidents_select">{{ __('site.Have you experienced any major life events or traumas that may impact your mental health?') }} {{ __('site.Select all that apply') }}</label>
                                    <select id="incidents_select" name="incidents[]" class="form-input select2 diseases-select-backend" multiple>
                                        @foreach($incidents as $incident)
                                            <option value="{{ $incident->id }}" {{ in_array($incident->id, $oldIncidents) ? 'selected' : '' }}>
                                                {{ $incident->getTranslatedName() }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="input-group">
                                    <label for="diseases_select">{{ __('site.Do you have any chronic physical health conditions?') }}</label>
                                    <select id="diseases_select" name="diseases[]" class="form-input select2 diseases-select-backend" multiple>
                                        @foreach($diseases as $disease)
                                            <option value="{{ $disease->id }}" {{ in_array($disease->id, $oldDiseases) ? 'selected' : '' }}>
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
                    <button type="submit" class="header-btn primary-btn">{{ __('site.Create') }}</button>
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
        const form = document.querySelector('.patient-create-form');
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
            form.addEventListener('submit', function (event) {
                let isValid = true;

                requiredInputs.forEach(function (input) {
                    if (input.value.trim() === '') {
                        input.classList.add('error');
                        isValid = false;
                    }
                });

                if (!isValid) {
                    event.preventDefault();
                    const firstInvalid = form.querySelector('.form-input.error');
                    if (firstInvalid) {
                        firstInvalid.focus({ preventScroll: true });
                        firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                }
            });
        }
    });
</script>
@endpush

@extends('layouts.master2')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/admin/doctor-create-page.css') }}">
@endpush

@section('content')
    @php
        $backRoute = Route::has('doctor.index') ? route('doctor.index') : url()->previous();
        $currentLocale = app()->getLocale();
        $avatarPath = $doctor->image ? Storage::url($doctor->image) : asset('assets/images/avatar1.png');
    @endphp

    <div class="doctor-management-content doctor-create-page doctor-edit-page">
        <div class="page-header">
            <div class="header-content">
                <div class="header-info">
                    <h1 class="page-title">{{ __('site.Edit Doctor') }}</h1>
                    <p class="page-subtitle">Refresh contact details, update specialties, and keep this doctor profile aligned with the SAMAA standard.</p>
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
                    <h3>Keep expertise visible</h3>
                    <p>Ensure speciality and credentials reflect the doctor’s most current focus areas.</p>
                </div>
            </div>
            <div class="guideline-card">
                <div class="guideline-icon">
                    <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                        <path d="M4 5h16v2H4zm0 6h16v2H4zm0 6h10v2H4z" />
                    </svg>
                </div>
                <div class="guideline-content">
                    <h3>Verify accessibility</h3>
                    <p>Double check phone, email, and address so patients can connect without friction.</p>
                </div>
            </div>
            <div class="guideline-card">
                <div class="guideline-icon">
                    <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                        <path d="M12 4a8 8 0 1 0 8 8 8 8 0 0 0-8-8zm3 9h-2v2a1 1 0 0 1-2 0v-2H9a1 1 0 0 1 0-2h2V9a1 1 0 0 1 2 0v2h2a1 1 0 0 1 0 2z" />
                    </svg>
                </div>
                <div class="guideline-content">
                    <h3>Add personal warmth</h3>
                    <p>Update the portrait and social links so patients recognise the doctor instantly.</p>
                </div>
            </div>
        </div>

        <div class="form-wrapper">
            <form action="{{ route('doctor.update', $doctor) }}" method="post" enctype="multipart/form-data" class="doctor-create-form">
                @csrf
                @method('put')

                <div class="form-shell">
                    <section class="form-panel media-panel">
                        <header class="panel-header">
                            <h2>{{ __('site.Profile Picture') }}</h2>
                            <p>Keep a professional, welcoming image that consistently represents this doctor.</p>
                        </header>

                        <div class="image-upload-wrapper">
                            <input type="file" id="doctor-image" name="image" accept="image/*" hidden>
                            <label for="doctor-image" class="upload-label">
                                <div class="image-placeholder">
                                    <img id="doctor-image-preview" src="{{ $avatarPath }}" alt="Doctor avatar preview" class="placeholder-img">
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
                            <li>Use a centred headshot with a clean background.</li>
                            <li>Recommended size: 600 × 600 px, minimum 400 × 400 px.</li>
                            <li>Ensure the file is under 2 MB and in JPG or PNG format.</li>
                        </ul>
                    </section>

                    <section class="form-panel content-panel">
                        <header class="panel-header">
                            <h2>{{ __('site.Doctor Profile') }}</h2>
                            <p>Review personal, professional, and social details to keep the profile dependable.</p>
                        </header>

                        <div class="section-block">
                            <div class="section-heading">
                                <h3>{{ __('site.Personal Information') }}</h3>
                                <p>Core profile fields used for communication and identification.</p>
                            </div>

                            <div class="input-grid two-col">
                                <div class="input-group">
                                    <label for="first_name">{{ __('site.First Name') }}</label>
                                    <input type="text" id="first_name" name="first_name" class="form-input" placeholder="{{ __('site.First Name') }}" value="{{ old('first_name', $doctor->first_name) }}" required>
                                    @error('first_name')
                                        <span class="error-message">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="input-group">
                                    <label for="surname">{{ __('site.Surname') }}</label>
                                    <input type="text" id="surname" name="surname" class="form-input" placeholder="{{ __('site.Surname') }}" value="{{ old('surname', $doctor->last_name) }}">
                                    @error('surname')
                                        <span class="error-message">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="input-group span-2">
                                    <label for="email">{{ __('site.Email Address') }}</label>
                                    <input type="email" id="email" name="email" class="form-input" placeholder="{{ __('site.Email Address') }}" value="{{ old('email', optional($doctor->user)->email) }}" required>
                                    @error('email')
                                        <span class="error-message">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="input-group">
                                    <label for="phone">{{ __('site.Phone') }}</label>
                                    <input type="text" id="phone" name="phone" class="form-input" placeholder="{{ __('site.Phone') }}" value="{{ old('phone', $doctor->phone) }}">
                                    @error('phone')
                                        <span class="error-message">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="input-group">
                                    <label for="birthday">{{ __('site.Birthday') }}</label>
                                    <input type="date" id="birthday" name="birthday" class="form-input" value="{{ old('birthday', $doctor->birthday) }}">
                                    @error('birthday')
                                        <span class="error-message">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="input-group">
                                    <label for="specialization">{{ __('site.Specialization') }}</label>
                                    <input type="text" id="specialization" name="specialization" class="form-input" placeholder="{{ __('site.Specialization') }}" value="{{ old('specialization', $doctor->specialization) }}">
                                    @error('specialization')
                                        <span class="error-message">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="input-group span-2">
                                    <label for="address">{{ __('site.Address') }}</label>
                                    <input type="text" id="address" name="address" class="form-input" placeholder="{{ __('site.Address') }}" value="{{ old('address', $doctor->address) }}">
                                    @error('address')
                                        <span class="error-message">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="section-block">
                            <div class="section-heading">
                                <h3>{{ __('site.Social Links') }}</h3>
                                <p>Keep professional social accounts up to date for patients and colleagues.</p>
                            </div>

                            <div class="input-grid two-col">
                                <div class="input-group span-2">
                                    <label for="facebook">{{ __('site.Facebook link') }}</label>
                                    <input type="url" id="facebook" name="facebook" class="form-input" placeholder="https://facebook.com/..." value="{{ old('facebook', $doctor->facebook) }}">
                                    @error('facebook')
                                        <span class="error-message">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="input-group">
                                    <label for="twitter">{{ __('site.Twitter link') }}</label>
                                    <input type="url" id="twitter" name="twitter" class="form-input" placeholder="https://twitter.com/..." value="{{ old('twitter', $doctor->twitter) }}">
                                    @error('twitter')
                                        <span class="error-message">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="input-group">
                                    <label for="instagram">{{ __('site.Instagram link') }}</label>
                                    <input type="url" id="instagram" name="instagram" class="form-input" placeholder="https://instagram.com/..." value="{{ old('instagram', $doctor->instagram) }}">
                                    @error('instagram')
                                        <span class="error-message">{{ $message }}</span>
                                    @enderror
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
        const fileInput = document.getElementById('doctor-image');
        const previewImg = document.getElementById('doctor-image-preview');
        const form = document.querySelector('.doctor-create-form');
        const requiredInputs = form ? form.querySelectorAll('.form-input[required]') : [];

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

@extends('layouts.base')
@section('content')
    <!-- Patient Registration Form -->
    <section class="relative min-h-screen flex items-center justify-center overflow-hidden bg-gradient-to-br from-slate-900 via-slate-800 to-emerald-900">
        <!-- Scientific Grid Pattern -->
        <div class="absolute inset-0 opacity-20">
            <div class="absolute inset-0" style="background-image: radial-gradient(circle at 1px 1px, rgba(255,255,255,0.15) 1px, transparent 0); background-size: 50px 50px;"></div>
        </div>
        
        <!-- Floating Particles -->
        <div class="absolute inset-0">
            <div class="absolute top-1/4 left-1/4 w-2 h-2 bg-emerald-400 rounded-full animate-ping"></div>
            <div class="absolute top-1/3 right-1/3 w-1 h-1 bg-blue-400 rounded-full animate-pulse"></div>
            <div class="absolute bottom-1/3 left-1/3 w-1.5 h-1.5 bg-teal-400 rounded-full animate-bounce"></div>
            <div class="absolute top-2/3 right-1/4 w-1 h-1 bg-emerald-300 rounded-full animate-pulse"></div>
            <div class="absolute bottom-1/4 left-2/3 w-1.5 h-1.5 bg-blue-300 rounded-full animate-ping"></div>
        </div>

        <div class="container mx-auto px-4 relative z-10 py-2">
            <div class="max-w-2xl mx-auto">
                <!-- Main Registration Card -->
                <div class="bg-white/10 backdrop-blur-lg rounded-xl border border-white/20 shadow-2xl p-4">
                    <!-- Header -->
                    <div class="text-center mb-4">
                        <div class="mb-2">
                            <div class="w-10 h-10 bg-gradient-to-br from-emerald-400 to-teal-400 rounded-xl flex items-center justify-center mx-auto mb-1">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                </svg>
                            </div>
                        </div>
                        <h1 class="text-lg lg:text-xl font-serif font-bold text-white mb-1">
                            {{ __('site.Patient Registration') }}
                        </h1>
                        <p class="text-xs text-slate-300">
                            {{ __('site.Join our community and get personalized therapy') }}
                        </p>
                    </div>

                    <!-- Registration Form -->
                    <form id="patientRegistrationForm" action="{{ route('registerPatient') }}" method="post" enctype="multipart/form-data">
                        @csrf

                        <!-- Step 1: Personal Information -->
                        <div id="step-1" class="form-step active">
                            <div class="space-y-3">
                                <!-- Profile Picture Section -->
                                <div class="text-center">
                                    <div class="relative inline-block">
                                        <div class="w-12 h-12 bg-white/20 rounded-full border border-emerald-400/30 flex items-center justify-center mx-auto overflow-hidden">
                                            <img id="profileImage" src="{{ asset('assets/images/profile.jfif') }}" alt="Profile Picture" class="w-full h-full object-cover">
                                        </div>
                                        <button type="button" class="absolute -bottom-0.5 -right-0.5 w-5 h-5 bg-emerald-500 hover:bg-emerald-600 rounded-full flex items-center justify-center text-white transition-colors duration-200" onclick="document.getElementById('fileInput').click();">
                                            <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                            </svg>
                                        </button>
                                        <input type="file" name="image" id="fileInput" accept="image/*" class="hidden" onchange="updateProfilePicture(event)">
                                    </div>
                                    <p class="text-slate-300 text-xs mt-0.5">{{ __('site.Upload Photo') }}</p>
                                </div>

                                <!-- Form Fields - More Compact Grid -->
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                                    <!-- First Name -->
                                    <div>
                                        <label class="form-label text-xs">{{ __('site.First Name') }}</label>
                                        <input type="text" name="first_name" class="form-input py-1.5 text-sm" placeholder="{{ __('site.First Name') }}" required>
                                        @error('first_name')
                                            <div class="form-error text-xs">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Last Name -->
                                    <div>
                                        <label class="form-label text-xs">{{ __('site.Surname') }}</label>
                                        <input type="text" name="last_name" class="form-input py-1.5 text-sm" placeholder="{{ __('site.Surname') }}">
                                        @error('last_name')
                                            <div class="form-error text-xs">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Birthday -->
                                    <div>
                                        <label class="form-label text-xs">{{ __('site.Birthday') }}</label>
                                        <input type="date" name="birthday" class="form-input py-1.5 text-sm">
                                        @error('birthday')
                                            <div class="form-error text-xs">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Email -->
                                    <div class="md:col-span-2">
                                        <label class="form-label text-xs">{{ __('site.Email') }}</label>
                                        <input type="email" name="email" class="form-input py-1.5 text-sm" placeholder="{{ __('site.Email Address') }}" required>
                                        @error('email')
                                            <div class="form-error text-xs">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Phone -->
                                    <div>
                                        <label class="form-label text-xs">{{ __('site.Phone') }}</label>
                                        <input type="tel" name="phone" class="form-input py-1.5 text-sm" placeholder="0918657965">
                                        @error('phone')
                                            <div class="form-error text-xs">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Password -->
                                    <div>
                                        <label class="form-label text-xs">{{ __('site.Password') }}</label>
                                        <input type="password" id="new_pass" name="password" class="form-input py-1.5 text-sm" placeholder="••••••••" required>
                                        @error('password')
                                            <div class="form-error text-xs">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Confirm Password -->
                                    <div>
                                        <label class="form-label text-xs">{{ __('site.Confirm') }}</label>
                                        <input type="password" id="confirm_pass" name="confirm_password" class="form-input py-1.5 text-sm" placeholder="••••••••" required>
                                        @error('confirm_password')
                                            <div class="form-error text-xs">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Country -->
                                    <div>
                                        <label class="form-label text-xs">{{ __('site.Country') }}</label>
                                        <select name="country" class="form-select py-1.5 text-sm">
                                            <option value="">{{ __('site.Select') }}</option>
                                            @foreach($countries as $country)
                                                <option value="{{ $country->id }}">{{ $country->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('country')
                                            <div class="form-error text-xs">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Language -->
                                    <div>
                                        <label class="form-label text-xs">{{ __('site.Language') }}</label>
                                        <select name="language" class="form-select py-1.5 text-sm">
                                            <option value="">{{ __('site.Select') }}</option>
                                            @foreach($languages as $language)
                                                <option value="{{ $language->id }}">{{ $language->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('language')
                                            <div class="form-error text-xs">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Gender -->
                                    <div>
                                        <label class="form-label text-xs">{{ __('site.Gender') }}</label>
                                        <div class="flex gap-3 mt-1">
                                            <label class="flex items-center cursor-pointer text-xs">
                                                <input type="radio" name="gender" value="male" class="w-3 h-3 text-emerald-600 bg-white/20 border-white/30 focus:ring-emerald-500 focus:ring-1">
                                                <span class="ml-1 text-white">{{ __('site.Male') }}</span>
                                            </label>
                                            <label class="flex items-center cursor-pointer text-xs">
                                                <input type="radio" name="gender" value="female" class="w-3 h-3 text-emerald-600 bg-white/20 border-white/30 focus:ring-emerald-500 focus:ring-1">
                                                <span class="ml-1 text-white">{{ __('site.Female') }}</span>
                                            </label>
                                        </div>
                                        @error('gender')
                                            <div class="form-error text-xs">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Next Button -->
                                <div class="flex justify-end pt-2 border-t border-white/20 mt-3">
                                    <button type="button" class="btn-primary text-sm px-4 py-1.5" onclick="goToNextStep()">
                                        {{ __('site.Next') }}
                                        <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Step 2: Medical History -->
                        <div id="step-2" class="form-step hidden">
                            <div class="space-y-3">
                                <!-- Step Header -->
                                <div class="text-center mb-3">
                                    <h2 class="text-lg font-serif font-bold text-white mb-1">
                                        {{ __('site.Medical History') }}
                                    </h2>
                                    <p class="text-slate-300 text-xs">
                                        {{ __('site.Help us understand your background') }}
                                    </p>
                                </div>

                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                                    <!-- Left Column -->
                                    <div class="space-y-3">
                                        <!-- Mental Health Conditions -->
                                        <div>
                                            <label class="form-label text-xs">
                                                {{ __('site.Mental health conditions diagnosed?') }}
                                                <span class="text-emerald-400 text-xs block">{{ __('site.Select all that apply') }}</span>
                                            </label>
                                            <select name="psychological_diseases[]" class="form-select diseases-select select2 py-1 text-sm" multiple>
                                                @foreach($psychological_diseases as $psychological_disease)
                                                    <option value="{{ $psychological_disease->id }}">
                                                        {{ $psychological_disease->getTranslatedName() }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('psychological_diseases')
                                                <div class="form-error">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Previous Therapy -->
                                        <div>
                                            <label class="form-label">{{ __('site.Have you ever received therapy or counseling before?') }}</label>
                                            <select name="consultation" class="form-select">
                                                <option value="">{{ __('site.Select an option') }}</option>
                                                @foreach($consultations as $consultation)
                                                    <option value="{{ $consultation->id }}">{{ $consultation->getTranslatedName() }}</option>
                                                @endforeach
                                            </select>
                                            @error('consultation')
                                                <div class="form-error">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Symptoms -->
                                        <div>
                                            <label class="form-label">
                                                {{ __('site.Have you experienced any of the following symptoms in the past 6 months?') }}
                                                <span class="text-emerald-400 text-sm block mt-1">{{ __('site.Select all that apply') }}</span>
                                            </label>
                                            <select name="symptoms[]" class="form-select diseases-select select2" multiple>
                                                @foreach($symptoms as $symptom)
                                                    <option value="{{ $symptom->id }}">{{ $symptom->getTranslatedName() }}</option>
                                                @endforeach
                                            </select>
                                            @error('symptoms')
                                                <div class="form-error">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Medications -->
                                        <div>
                                            <label class="form-label">{{ __('site.Are you currently taking any medications for mental health conditions?') }}</label>
                                            <select name="therapeutic_areas" id="therapeutic_areas_select" class="form-select">
                                                <option value="">{{ __('site.Select an option') }}</option>
                                                @foreach($therapeutic_areas as $therapeutic_area)
                                                    <option value="{{ $therapeutic_area->id }}">{{ $therapeutic_area->getTranslatedName() }}</option>
                                                @endforeach
                                            </select>
                                            
                                            <div id="medication_input_wrapper" class="hidden mt-4">
                                                <label class="form-label">{{ __('site.Please list the medications you are taking') }}</label>
                                                <input type="text" name="medications" id="medications" class="form-input" placeholder="{{ __('site.Enter medication names') }}">
                                            </div>
                                            @error('therapeutic_areas')
                                                <div class="form-error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Right Column -->
                                    <div class="space-y-4">
                                        <!-- Neurological Conditions -->
                                        <div>
                                            <label class="form-label">
                                                {{ __('site.Have you ever been diagnosed with any neurological conditions?') }}
                                                <span class="text-emerald-400 text-sm block mt-1">{{ __('site.Select all that apply') }}</span>
                                            </label>
                                            <select name="nervouses[]" class="form-select diseases-select select2" multiple>
                                                @foreach($nervouses as $nervous)
                                                    <option value="{{ $nervous->id }}">{{ $nervous->getTranslatedName() }}</option>
                                                @endforeach
                                            </select>
                                            @error('nervouses')
                                                <div class="form-error">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Addiction History -->
                                        <div>
                                            <label class="form-label">{{ __('site.Do you have a history of substance use or addiction?') }}</label>
                                            <select name="addiction" class="form-select">
                                                <option value="">{{ __('site.Select an option') }}</option>
                                                @foreach($addictions as $addiction)
                                                    <option value="{{ $addiction->id }}">{{ $addiction->getTranslatedName() }}</option>
                                                @endforeach
                                            </select>
                                            @error('addiction')
                                                <div class="form-error">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Life Events/Trauma -->
                                        <div>
                                            <label class="form-label">
                                                {{ __('site.Have you experienced any major life events or traumas that may impact your mental health?') }}
                                                <span class="text-emerald-400 text-sm block mt-1">{{ __('site.Select all that apply') }}</span>
                                            </label>
                                            <select name="incidents[]" class="form-select diseases-select select2" multiple>
                                                @foreach($incidents as $incident)
                                                    <option value="{{ $incident->id }}">{{ $incident->getTranslatedName() }}</option>
                                                @endforeach
                                            </select>
                                            @error('incidents')
                                                <div class="form-error">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Physical Health Conditions -->
                                        <div>
                                            <label class="form-label">{{ __('site.Do you have any chronic physical health conditions?') }}</label>
                                            <select name="diseases[]" class="form-select diseases-select select2" multiple>
                                                @foreach($diseases as $disease)
                                                    <option value="{{ $disease->id }}">{{ $disease->getTranslatedName() }}</option>
                                                @endforeach
                                            </select>
                                            @error('diseases')
                                                <div class="form-error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Navigation Buttons -->
                                <div class="flex justify-between pt-6 border-t border-white/20">
                                    <button type="button" class="btn-secondary" onclick="showPreviousStep()">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                        </svg>
                                        {{ __('site.Previous') }}
                                    </button>
                                    <button type="submit" class="btn-primary">
                                        {{ __('site.Complete Registration') }}
                                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- Step Indicator -->
                    <div class="mt-8 flex justify-center">
                        <div class="flex items-center space-x-4">
                            <div id="step-indicator-1" class="flex items-center justify-center w-8 h-8 bg-emerald-500 text-white rounded-full text-sm font-medium">
                                1
                            </div>
                            <div class="w-16 h-1 bg-white/20 rounded">
                                <div id="progress-bar" class="h-full bg-emerald-500 rounded transition-all duration-300" style="width: 50%"></div>
                            </div>
                            <div id="step-indicator-2" class="flex items-center justify-center w-8 h-8 bg-white/20 text-white rounded-full text-sm font-medium">
                                2
                            </div>
                        </div>
                    </div>

                    <!-- Back to Login -->
                    <div class="text-center mt-8 pt-6 border-t border-white/20">
                        <p class="text-slate-300 mb-2 text-sm">{{ __('site.Already have an account?') }}</p>
                        <a href="{{ route('login') }}" class="inline-flex items-center gap-2 text-emerald-400 hover:text-emerald-300 font-medium transition-colors duration-200 text-sm">
                            {{ __('site.Sign In') }}
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- JavaScript for form functionality -->
    <script>
        // Simpler form step management
        function goToNextStep() {
            console.log('Going to next step...');
            
            // Hide step 1, show step 2
            const step1 = document.getElementById('step-1');
            const step2 = document.getElementById('step-2');
            
            console.log('Step 1:', step1);
            console.log('Step 2:', step2);
            
            if (step1) step1.style.display = 'none';
            if (step2) step2.style.display = 'block';
            
            // Update indicators
            const indicator1 = document.getElementById('step-indicator-1');
            const indicator2 = document.getElementById('step-indicator-2');
            const progressBar = document.getElementById('progress-bar');
            
            if (indicator1) {
                indicator1.classList.remove('bg-emerald-500');
                indicator1.classList.add('bg-emerald-600');
            }
            
            if (indicator2) {
                indicator2.classList.remove('bg-white/20');
                indicator2.classList.add('bg-emerald-500');
            }
            
            if (progressBar) {
                progressBar.style.width = '100%';
            }
        }

        function goToPreviousStep() {
            const step1 = document.getElementById('step-1');
            const step2 = document.getElementById('step-2');
            
            if (step1) step1.style.display = 'block';
            if (step2) step2.style.display = 'none';
            
            // Update indicators
            const indicator1 = document.getElementById('step-indicator-1');
            const indicator2 = document.getElementById('step-indicator-2');
            const progressBar = document.getElementById('progress-bar');
            
            if (indicator1) {
                indicator1.classList.add('bg-emerald-500');
                indicator1.classList.remove('bg-emerald-600');
            }
            
            if (indicator2) {
                indicator2.classList.add('bg-white/20');
                indicator2.classList.remove('bg-emerald-500');
            }
            
            if (progressBar) {
                progressBar.style.width = '50%';
            }
        }

        // Form step management - keep original function as backup
        function validateAndGoToNext() {
            goToNextStep();
        }

        function showPreviousStep() {
            goToPreviousStep();
        }

        // Profile picture update
        function updateProfilePicture(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const profileImage = document.getElementById('profileImage');
                    if (profileImage) {
                        profileImage.src = e.target.result;
                    }
                };
                reader.readAsDataURL(file);
            }
        }

        // Show/hide medication input based on therapeutic areas selection
        document.addEventListener('DOMContentLoaded', function() {
            const therapeuticAreasSelect = document.getElementById('therapeutic_areas_select');
            const medicationWrapper = document.getElementById('medication_input_wrapper');
            
            if (therapeuticAreasSelect && medicationWrapper) {
                therapeuticAreasSelect.addEventListener('change', function() {
                    if (this.value) {
                        medicationWrapper.classList.remove('hidden');
                    } else {
                        medicationWrapper.classList.add('hidden');
                    }
                });
            }
        });
    </script>
@endsection

@extends('layouts.base')
@section('content')
    <!-- Patient Registration Form -->
    <section class="relative min-h-screen flex items-center justify-center overflow-hidden bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900">
        <!-- Scientific Grid Pattern -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0" style="background-image: radial-gradient(circle at 1px 1px, rgba(255,255,255,0.1) 1px, transparent 0); background-size: 40px 40px;"></div>
        </div>
        
        <!-- Floating Particles -->
        <div class="absolute inset-0">
            <div class="absolute top-1/4 left-1/4 w-2 h-2 bg-amber-400 rounded-full animate-ping"></div>
            <div class="absolute top-1/3 right-1/3 w-1 h-1 bg-amber-300 rounded-full animate-pulse"></div>
            <div class="absolute bottom-1/3 left-1/3 w-1.5 h-1.5 bg-amber-500 rounded-full animate-bounce"></div>
            <div class="absolute top-2/3 right-1/4 w-1 h-1 bg-amber-200 rounded-full animate-pulse"></div>
            <div class="absolute bottom-1/4 left-2/3 w-1.5 h-1.5 bg-amber-400 rounded-full animate-ping"></div>
        </div>

        <div class="container mx-auto px-4 relative z-10 py-4">
            <div class="min-h-screen flex items-center justify-center">
                <div class="max-w-6xl w-full space-y-8">
                    <!-- Header -->
                    <div class="text-center mb-8">
                        <div class="mx-auto h-16 w-16 flex items-center justify-center rounded-full bg-gradient-to-r from-amber-400 to-amber-600 shadow-lg">
                            <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <h1 class="mt-6 text-3xl font-bold text-white tracking-tight">
                            {{ __('site.Patient Registration') }}
                        </h1>
                        <p class="mt-3 text-lg text-slate-300">
                            {{ __('site.Join our community for mental health support') }}
                        </p>
                        <div class="mt-4 w-24 h-1 bg-gradient-to-r from-amber-400 to-amber-600 mx-auto rounded-full"></div>
                    </div>

                    <!-- Main Registration Card -->
                    <div class="bg-white/5 backdrop-blur-xl rounded-2xl border border-white/10 shadow-2xl overflow-hidden">
                        <!-- Progress Bar -->
                        <div class="bg-slate-800/50 px-8 py-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    <div class="flex items-center space-x-2">
                                        <div id="step-indicator-1" class="w-8 h-8 rounded-full bg-amber-500 text-white flex items-center justify-center text-sm font-semibold">1</div>
                                        <span class="text-white font-medium">{{ __('site.Personal Info') }}</span>
                                    </div>
                                    <div class="w-12 h-0.5 bg-slate-600"></div>
                                    <div class="flex items-center space-x-2">
                                        <div id="step-indicator-2" class="w-8 h-8 rounded-full bg-slate-600 text-slate-300 flex items-center justify-center text-sm font-semibold">2</div>
                                        <span class="text-slate-300 font-medium">{{ __('site.Medical History') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Form Content -->
                        <div class="p-8">
                            <!-- Success/Error Messages -->
                            @if(session('status'))
                                <div class="mb-6 p-4 rounded-lg border {{ session('status.type') === 'success' ? 'bg-green-500/10 border-green-500 text-green-400' : 'bg-red-500/10 border-red-500 text-red-400' }}">
                                    <div class="flex items-center">
                                        @if(session('status.type') === 'success')
                                            <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                        @else
                                            <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                        @endif
                                        <div>
                                            <p class="font-semibold">{{ session('status.title') ?? (session('status.type') === 'success' ? 'Success' : 'Error') }}</p>
                                            <p class="text-sm mt-1">{{ session('status.msg') ?? session('status') }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if($errors->any())
                                <div class="mb-6 p-4 rounded-lg border bg-red-500/10 border-red-500 text-red-400">
                                    <div class="flex items-start">
                                        <svg class="w-6 h-6 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <div class="flex-1">
                                            <p class="font-semibold">{{ __('site.Validation Error') }}</p>
                                            <ul class="text-sm mt-2 space-y-1 list-disc list-inside">
                                                @foreach($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- Registration Form -->
                            <form id="patientRegistrationForm" action="{{ route('registerPatient') }}" method="post" enctype="multipart/form-data" class="space-y-8">
                                @csrf

                                <!-- Step 1: Personal Information -->
                                <div id="step-1" class="form-step active">
                                    <!-- Profile Picture Section -->
                                    <div class="text-center mb-8">
                                        <div class="relative inline-block">
                                            <div class="w-24 h-24 bg-white rounded-full border-4 border-amber-400 flex items-center justify-center mx-auto overflow-hidden shadow-lg hover:shadow-xl transition-shadow duration-300">
                                                <img id="profileImage" src="{{ asset('assets/images/profile.jfif') }}" alt="Profile Picture" class="w-full h-full object-cover">
                                            </div>
                                            <button type="button" class="absolute -bottom-1 -right-1 w-8 h-8 bg-amber-500 hover:bg-amber-600 rounded-full flex items-center justify-center text-white transition-all duration-200 shadow-lg hover:shadow-xl hover:scale-110" onclick="document.getElementById('fileInput').click();">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                                </svg>
                                            </button>
                                            <input type="file" name="image" id="fileInput" accept="image/*" class="hidden" onchange="updateProfilePicture(event)">
                                        </div>
                                        <p class="text-slate-300 text-sm mt-3 font-medium">{{ __('site.Upload Photo') }}</p>
                                    </div>

                                    <!-- Form Fields - Better Organization -->
                                    <div class="space-y-8">
                                        <!-- Personal Information Section -->
                                        <div class="bg-white/5 rounded-xl p-6 border border-white/10">
                                            <h3 class="text-amber-400 text-lg font-semibold mb-6 flex items-center">
                                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                </svg>
                                                {{ __('site.Personal Information') }}
                                            </h3>
                                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                                                <!-- First Name -->
                                                <div class="form-group">
                                                    <label class="block text-sm font-medium text-slate-100 mb-2">{{ __('site.First Name') }}</label>
                                                    <input type="text" name="first_name" class="w-full px-4 py-3 bg-white rounded-lg border border-slate-300 text-slate-900 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all duration-200 hover:border-amber-300" placeholder="{{ __('site.First Name') }}" required>
                                                    @error('first_name')
                                                        <div class="text-red-400 text-sm mt-1">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <!-- Last Name -->
                                                <div class="form-group">
                                                    <label class="block text-sm font-medium text-slate-100 mb-2">{{ __('site.Surname') }}</label>
                                                    <input type="text" name="last_name" class="w-full px-4 py-3 bg-white rounded-lg border border-slate-300 text-slate-900 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all duration-200 hover:border-amber-300" placeholder="{{ __('site.Surname') }}" required>
                                                    @error('last_name')
                                                        <div class="text-red-400 text-sm mt-1">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <!-- Birthday -->
                                                <div class="form-group">
                                                    <label class="block text-sm font-medium text-slate-100 mb-2">{{ __('site.Birthday') }}</label>
                                                    <input type="date" name="birthday" class="w-full px-4 py-3 bg-white rounded-lg border border-slate-300 text-slate-900 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all duration-200 hover:border-amber-300" required>
                                                    @error('birthday')
                                                        <div class="text-red-400 text-sm mt-1">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <!-- Gender -->
                                                <div class="form-group">
                                                    <label class="block text-sm font-medium text-slate-100 mb-2">{{ __('site.Gender') }}</label>
                                                    <div class="flex space-x-4 mt-3">
                                                        <label class="relative flex items-center cursor-pointer">
                                                            <input type="radio" name="gender" value="male" class="sr-only peer" required>
                                                            <div class="w-6 h-6 bg-white border-2 border-slate-300 rounded-full peer-checked:bg-amber-500 peer-checked:border-amber-500 transition-all duration-200 flex items-center justify-center">
                                                                <div class="w-2 h-2 bg-white rounded-full opacity-0 peer-checked:opacity-100 transition-opacity duration-200"></div>
                                                            </div>
                                                            <span class="ml-3 text-white font-medium">{{ __('site.Male') }}</span>
                                                        </label>
                                                        <label class="relative flex items-center cursor-pointer">
                                                            <input type="radio" name="gender" value="female" class="sr-only peer">
                                                            <div class="w-6 h-6 bg-white border-2 border-slate-300 rounded-full peer-checked:bg-amber-500 peer-checked:border-amber-500 transition-all duration-200 flex items-center justify-center">
                                                                <div class="w-2 h-2 bg-white rounded-full opacity-0 peer-checked:opacity-100 transition-opacity duration-200"></div>
                                                            </div>
                                                            <span class="ml-3 text-white font-medium">{{ __('site.Female') }}</span>
                                                        </label>
                                                    </div>
                                                    @error('gender')
                                                        <div class="text-red-400 text-sm mt-1">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Contact & Security Section -->
                                        <div class="bg-white/5 rounded-xl p-6 border border-white/10">
                                            <h3 class="text-amber-400 text-lg font-semibold mb-6 flex items-center">
                                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                                </svg>
                                                {{ __('site.Contact & Security') }}
                                            </h3>
                                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                                                <!-- Email -->
                                                <div class="form-group">
                                                    <label class="block text-sm font-medium text-slate-100 mb-2">{{ __('site.Email') }}</label>
                                                    <input type="email" name="email" class="w-full px-4 py-3 bg-white rounded-lg border border-slate-300 text-slate-900 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all duration-200 hover:border-amber-300" placeholder="{{ __('site.Email Address') }}" required>
                                                    @error('email')
                                                        <div class="text-red-400 text-sm mt-1">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <!-- Phone -->
                                                <div class="form-group">
                                                    <label class="block text-sm font-medium text-slate-100 mb-2">{{ __('site.Phone') }}</label>
                                                    <input type="tel" name="phone" class="w-full px-4 py-3 bg-white rounded-lg border border-slate-300 text-slate-900 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all duration-200 hover:border-amber-300" placeholder="0918657965" required>
                                                    @error('phone')
                                                        <div class="text-red-400 text-sm mt-1">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <!-- Password -->
                                                <div class="form-group">
                                                    <label class="block text-sm font-medium text-slate-100 mb-2">{{ __('site.Password') }}</label>
                                                    <input type="password" id="new_pass" name="password" class="w-full px-4 py-3 bg-white rounded-lg border border-slate-300 text-slate-900 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all duration-200 hover:border-amber-300" placeholder="••••••••" required>
                                                    @error('password')
                                                        <div class="text-red-400 text-sm mt-1">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <!-- Confirm Password -->
                                                <div class="form-group">
                                                    <label class="block text-sm font-medium text-slate-100 mb-2">{{ __('site.Confirm') }}</label>
                                                    <input type="password" id="confirm_pass" name="password_confirmation" class="w-full px-4 py-3 bg-white rounded-lg border border-slate-300 text-slate-900 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all duration-200 hover:border-amber-300" placeholder="••••••••" required>
                                                    @error('password_confirmation')
                                                        <div class="text-red-400 text-sm mt-1">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Preferences Section -->
                                        <div class="bg-white/5 rounded-xl p-6 border border-white/10">
                                            <h3 class="text-amber-400 text-lg font-semibold mb-6 flex items-center">
                                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                </svg>
                                                {{ __('site.Preferences') }}
                                            </h3>
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                                <!-- Country -->
                                                <div class="form-group">
                                                    <label class="block text-sm font-medium text-slate-100 mb-2">{{ __('site.Country') }}</label>
                                                    <select name="country" class="w-full px-4 py-3 bg-white rounded-lg border border-slate-300 text-slate-900 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all duration-200 hover:border-amber-300 select2-single" required>
                                                        <option value="">{{ __('site.Select') }}</option>
                                                        @foreach($countries as $country)
                                                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('country')
                                                        <div class="text-red-400 text-sm mt-1">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <!-- Language -->
                                                <div class="form-group">
                                                    <label class="block text-sm font-medium text-slate-100 mb-2">{{ __('site.Language') }}</label>
                                                    <select name="language" class="w-full px-4 py-3 bg-white rounded-lg border border-slate-300 text-slate-900 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all duration-200 hover:border-amber-300 select2-single" required>
                                                        <option value="">{{ __('site.Select') }}</option>
                                                        @foreach($languages as $language)
                                                            <option value="{{ $language->id }}">{{ $language->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('language')
                                                        <div class="text-red-400 text-sm mt-1">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Next Button -->
                                    <div class="flex justify-end pt-6 border-t border-white/10">
                                        <button type="button" id="nextStepBtn" class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-amber-500 to-amber-600 text-white font-semibold rounded-lg shadow-lg hover:from-amber-600 hover:to-amber-700 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 focus:ring-offset-slate-800 transform hover:scale-105 transition-all duration-200">
                                            {{ __('site.Next') }}
                                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <!-- Step 2: Medical History -->
                                <div id="step-2" class="form-step hidden">
                                    <!-- Step Header -->
                                    <div class="text-center mb-8">
                                        <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-amber-400 to-amber-600 rounded-full mb-4">
                                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                        </div>
                                        <h2 class="text-2xl font-bold text-white mb-2">
                                            {{ __('site.Medical History') }}
                                        </h2>
                                        <p class="text-slate-300 text-lg">
                                            {{ __('site.Help us understand your background') }}
                                        </p>
                                        <div class="mt-4 w-24 h-1 bg-gradient-to-r from-amber-400 to-amber-600 mx-auto rounded-full"></div>
                                    </div>

                                    <div class="space-y-8">
                                        <!-- Mental Health Section -->
                                        <div class="bg-white/5 rounded-xl p-6 border border-white/10">
                                            <h3 class="text-amber-400 text-lg font-semibold mb-6 flex items-center">
                                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                                                </svg>
                                                {{ __('site.Mental Health') }}
                                            </h3>
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                                <!-- Mental Health Conditions -->
                                                <div class="form-group">
                                                    <label class="block text-sm font-medium text-slate-100 mb-2 min-h-[52px]">
                                                        {{ __('site.Diagnosed conditions?') }}
                                                        <span class="text-amber-400 text-sm block mt-1">{{ __('site.Select all') }}</span>
                                                    </label>
                                                    <select name="psychological_diseases[]" class="w-full px-4 py-3 bg-white rounded-lg border border-slate-300 text-slate-900 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all duration-200 hover:border-amber-300 diseases-select select2" multiple>
                                                        @foreach($psychological_diseases as $psychological_disease)
                                                            <option value="{{ $psychological_disease->id }}">
                                                                {{ $psychological_disease->getTranslatedName() }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('psychological_diseases')
                                                        <div class="text-red-400 text-sm mt-1">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <!-- Previous Therapy -->
                                                <div class="form-group">
                                                    <label class="block text-sm font-medium text-slate-100 mb-2 min-h-[52px]">{{ __('site.Previous therapy?') }}</label>
                                                    <select name="consultation" class="w-full px-4 py-3 bg-white rounded-lg border border-slate-300 text-slate-900 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all duration-200 hover:border-amber-300 select2-single" required>
                                                        <option value="">{{ __('site.Select') }}</option>
                                                        @foreach($consultations as $consultation)
                                                            <option value="{{ $consultation->id }}">{{ $consultation->getTranslatedName() }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('consultation')
                                                        <div class="text-red-400 text-sm mt-1">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <!-- Symptoms -->
                                                <div class="form-group">
                                                    <label class="block text-sm font-medium text-slate-100 mb-2 min-h-[52px]">
                                                        {{ __('site.Recent symptoms (6 months)?') }}
                                                        <span class="text-amber-400 text-sm block mt-1">{{ __('site.Select all') }}</span>
                                                    </label>
                                                    <select name="symptoms[]" class="w-full px-4 py-3 bg-white rounded-lg border border-slate-300 text-slate-900 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all duration-200 hover:border-amber-300 diseases-select select2" multiple>
                                                        @foreach($symptoms as $symptom)
                                                            <option value="{{ $symptom->id }}">{{ $symptom->getTranslatedName() }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('symptoms')
                                                        <div class="text-red-400 text-sm mt-1">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <!-- Medications -->
                                                <div class="form-group">
                                                    <label class="block text-sm font-medium text-slate-100 mb-2 min-h-[52px]">{{ __('site.Current medications?') }}</label>
                                                    <select name="therapeutic_areas" id="therapeutic_areas_select" class="w-full px-4 py-3 bg-white rounded-lg border border-slate-300 text-slate-900 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all duration-200 hover:border-amber-300 select2-single" required>
                                                        <option value="">{{ __('site.Select') }}</option>
                                                        @foreach($therapeutic_areas as $therapeutic_area)
                                                            <option value="{{ $therapeutic_area->id }}">{{ $therapeutic_area->getTranslatedName() }}</option>
                                                        @endforeach
                                                    </select>
                                                    
                                                    <div id="medication_input_wrapper" class="hidden mt-3">
                                                        <label class="block text-sm font-medium text-slate-100 mb-2">{{ __('site.List medications') }}</label>
                                                        <input type="text" name="medications" id="medications" class="w-full px-4 py-3 bg-white rounded-lg border border-slate-300 text-slate-900 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all duration-200 hover:border-amber-300" placeholder="{{ __('site.Enter medications') }}">
                                                    </div>
                                                    @error('therapeutic_areas')
                                                        <div class="text-red-400 text-sm mt-1">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Physical Health & Life Events Section -->
                                        <div class="bg-white/5 rounded-xl p-6 border border-white/10">
                                            <h3 class="text-amber-400 text-lg font-semibold mb-6 flex items-center">
                                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                                </svg>
                                                {{ __('site.Physical Health & Life Events') }}
                                            </h3>
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                                <!-- Neurological Conditions -->
                                                <div class="form-group">
                                                    <label class="block text-sm font-medium text-slate-100 mb-2 min-h-[52px]">
                                                        {{ __('site.Neurological conditions?') }}
                                                        <span class="text-amber-400 text-sm block mt-1">{{ __('site.Select all') }}</span>
                                                    </label>
                                                    <select name="nervouses[]" class="w-full px-4 py-3 bg-white rounded-lg border border-slate-300 text-slate-900 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all duration-200 hover:border-amber-300 diseases-select select2" multiple>
                                                        @foreach($nervouses as $nervous)
                                                            <option value="{{ $nervous->id }}">{{ $nervous->getTranslatedName() }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('nervouses')
                                                        <div class="text-red-400 text-sm mt-1">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <!-- Physical Health Conditions -->
                                                <div class="form-group">
                                                    <label class="block text-sm font-medium text-slate-100 mb-2 min-h-[52px]">
                                                        {{ __('site.Chronic conditions?') }}
                                                        <span class="text-amber-400 text-sm block mt-1">{{ __('site.Select all') }}</span>
                                                    </label>
                                                    <select name="diseases[]" class="w-full px-4 py-3 bg-white rounded-lg border border-slate-300 text-slate-900 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all duration-200 hover:border-amber-300 diseases-select select2" multiple>
                                                        @foreach($diseases as $disease)
                                                            <option value="{{ $disease->id }}">{{ $disease->getTranslatedName() }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('diseases')
                                                        <div class="text-red-400 text-sm mt-1">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <!-- Addiction History -->
                                                <div class="form-group">
                                                    <label class="block text-sm font-medium text-slate-100 mb-2 min-h-[52px]">{{ __('site.Substance use history?') }}</label>
                                                    <select name="addiction" class="w-full px-4 py-3 bg-white rounded-lg border border-slate-300 text-slate-900 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all duration-200 hover:border-amber-300 select2-single" required>
                                                        <option value="">{{ __('site.Select') }}</option>
                                                        @foreach($addictions as $addiction)
                                                            <option value="{{ $addiction->id }}">{{ $addiction->getTranslatedName() }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('addiction')
                                                        <div class="text-red-400 text-sm mt-1">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <!-- Life Events/Trauma -->
                                                <div class="form-group">
                                                    <label class="block text-sm font-medium text-slate-100 mb-2 min-h-[52px]">
                                                        {{ __('site.Major life events/trauma?') }}
                                                        <span class="text-amber-400 text-sm block mt-1">{{ __('site.Select all') }}</span>
                                                    </label>
                                                    <select name="incidents[]" class="w-full px-4 py-3 bg-white rounded-lg border border-slate-300 text-slate-900 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all duration-200 hover:border-amber-300 diseases-select select2" multiple>
                                                        @foreach($incidents as $incident)
                                                            <option value="{{ $incident->id }}">{{ $incident->getTranslatedName() }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('incidents')
                                                        <div class="text-red-400 text-sm mt-1">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Navigation Buttons -->
                                    <div class="flex justify-between pt-6 border-t border-white/10">
                                        <button type="button" id="prevStepBtn" class="inline-flex items-center px-8 py-3 bg-slate-700 text-white font-semibold rounded-lg shadow-lg hover:bg-slate-600 focus:outline-none focus:ring-2 focus:ring-slate-500 focus:ring-offset-2 focus:ring-offset-slate-800 transform hover:scale-105 transition-all duration-200">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                            </svg>
                                            {{ __('site.Previous') }}
                                        </button>
                                        <button type="submit" class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-amber-500 to-amber-600 text-white font-semibold rounded-lg shadow-lg hover:from-amber-600 hover:to-amber-700 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 focus:ring-offset-slate-800 transform hover:scale-105 transition-all duration-200">
                                            {{ __('site.Complete Registration') }}
                                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Back to Login -->
                    <div class="text-center mt-8">
                        <p class="text-slate-300 mb-3">{{ __('site.Already have an account?') }}</p>
                        <a href="{{ route('login') }}" class="inline-flex items-center gap-2 text-amber-400 hover:text-amber-300 font-medium transition-colors duration-200 group">
                            {{ __('site.Sign In') }}
                            <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
        // Define functions immediately in global scope
        console.log('=== Patient Registration Script Loading ===');
        
        function goToNextStep() {
            console.log('=== goToNextStep called ===');
            
            const step1 = document.getElementById('step-1');
            const step2 = document.getElementById('step-2');
            
            console.log('Step 1:', step1);
            console.log('Step 2:', step2);
            console.log('Step 1 classes before:', step1 ? step1.className : 'not found');
            console.log('Step 2 classes before:', step2 ? step2.className : 'not found');
            
            if (step1 && step2) {
                // Hide step 1
                step1.classList.remove('active');
                step1.classList.add('hidden');
                step1.style.display = 'none';
                
                // Show step 2
                step2.classList.remove('hidden');
                step2.classList.add('active');
                step2.style.display = 'block';
                
                updateStepIndicators(2);
                
                console.log('Step 1 classes after:', step1.className);
                console.log('Step 2 classes after:', step2.className);
                console.log('Steps switched successfully');
            } else {
                console.error('Could not find step elements!');
            }
        }
        
        function goToPreviousStep() {
            console.log('=== goToPreviousStep called ===');
            
            const step1 = document.getElementById('step-1');
            const step2 = document.getElementById('step-2');
            
            if (step1 && step2) {
                // Hide step 2
                step2.classList.remove('active');
                step2.classList.add('hidden');
                step2.style.display = 'none';
                
                // Show step 1
                step1.classList.remove('hidden');
                step1.classList.add('active');
                step1.style.display = 'block';
                
                updateStepIndicators(1);
                
                console.log('Steps switched successfully');
            } else {
                console.error('Could not find step elements!');
            }
        }
        
        function updateStepIndicators(currentStep) {
            const indicator1 = document.getElementById('step-indicator-1');
            const indicator2 = document.getElementById('step-indicator-2');
            
            if (!indicator1 || !indicator2) return;
            
            if (currentStep === 1) {
                indicator1.className = 'w-8 h-8 rounded-full bg-amber-500 text-white flex items-center justify-center text-sm font-semibold';
                indicator2.className = 'w-8 h-8 rounded-full bg-slate-600 text-slate-300 flex items-center justify-center text-sm font-semibold';
            } else {
                indicator1.className = 'w-8 h-8 rounded-full bg-green-500 text-white flex items-center justify-center text-sm font-semibold';
                indicator2.className = 'w-8 h-8 rounded-full bg-amber-500 text-white flex items-center justify-center text-sm font-semibold';
            }
        }

        function updateProfilePicture(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.getElementById('profileImage');
                    if (img) img.src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        }

        // Wait for DOM to be ready
        document.addEventListener('DOMContentLoaded', function() {
            console.log('=== DOM Ready ===');
            
            // Attach event listeners to buttons
            const nextBtn = document.getElementById('nextStepBtn');
            const prevBtn = document.getElementById('prevStepBtn');
            
            if (nextBtn) {
                nextBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    goToNextStep();
                });
                console.log('Next button listener attached');
            } else {
                console.error('Next button not found!');
            }
            
            if (prevBtn) {
                prevBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    goToPreviousStep();
                });
                console.log('Previous button listener attached');
            } else {
                console.error('Previous button not found!');
            }
            
            // Medication input toggle
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
                console.log('Medication toggle attached');
            }

            // Initialize Select2 for multi-select and single-select dropdowns
            if (typeof jQuery !== 'undefined' && typeof jQuery.fn.select2 !== 'undefined') {
                console.log('Initializing Select2...');
                
                // Multi-select dropdowns (diseases)
                jQuery('.diseases-select.select2').select2({
                    placeholder: "{{ __('site.Select') }}",
                    width: "100%",
                    dropdownParent: jQuery('body'),
                    theme: 'default'
                });
                
                // Single-select dropdowns
                jQuery('.select2-single').select2({
                    placeholder: "{{ __('site.Select') }}",
                    width: "100%",
                    dropdownParent: jQuery('body'),
                    theme: 'default',
                    minimumResultsForSearch: 10 // Show search box only if more than 10 options
                });
                
                // Fix Select2 styling to match inputs and ensure consistent appearance
                jQuery('<style>' +
                    // Dropdown options text color
                    '.select2-results__option { color: #1e293b !important; }' +
                    // Multi-select tags styling
                    '.select2-selection__choice { color: #1e293b !important; background-color: #fbbf24 !important; border-color: #f59e0b !important; }' +
                    // Single-select height to match inputs (py-3 = 12px top + 12px bottom + line-height)
                    '.select2-container--default .select2-selection--single { height: 48px !important; padding: 12px 16px !important; border-radius: 0.5rem !important; border: 1px solid #cbd5e1 !important; }' +
                    '.select2-container--default .select2-selection--single .select2-selection__rendered { line-height: 24px !important; padding-left: 0 !important; color: #0f172a !important; }' +
                    '.select2-container--default .select2-selection--single .select2-selection__arrow { height: 46px !important; }' +
                    // Multi-select min-height to match inputs
                    '.select2-container--default .select2-selection--multiple { min-height: 48px !important; padding: 8px 12px !important; border-radius: 0.5rem !important; border: 1px solid #cbd5e1 !important; }' +
                    // Focus states
                    '.select2-container--default.select2-container--focus .select2-selection--single, ' +
                    '.select2-container--default.select2-container--focus .select2-selection--multiple { border-color: #f59e0b !important; box-shadow: 0 0 0 2px rgba(245, 158, 11, 0.2) !important; }' +
                    // Hover states
                    '.select2-container--default .select2-selection--single:hover, ' +
                    '.select2-container--default .select2-selection--multiple:hover { border-color: #fcd34d !important; }' +
                    '</style>').appendTo('head');
                
                console.log('Select2 initialized');
            } else {
                console.error('Select2 not loaded properly');
            }
            
            console.log('=== All event listeners attached ===');
        });
    </script>
@endsection

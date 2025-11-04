@extends('layouts.base')
@section('content')
    <!-- Doctor Registration Form -->
    <section class="relative min-h-screen flex items-center justify-center overflow-hidden bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900">
        <!-- Scientific Grid Pattern -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0" style="background-image: radial-gradient(circle at 1px 1px, rgba(255,255,255,0.1) 1px, transparent 0); background-size: 40px 40px;"></div>
        </div>
        
        <!-- Floating Particles -->
        <div class="absolute inset-0">
            <div class="absolute top-1/4 left-1/4 w-2 h-2 bg-blue-400 rounded-full animate-ping"></div>
            <div class="absolute top-1/3 right-1/3 w-1 h-1 bg-blue-300 rounded-full animate-pulse"></div>
            <div class="absolute bottom-1/3 left-1/3 w-1.5 h-1.5 bg-blue-500 rounded-full animate-bounce"></div>
            <div class="absolute top-2/3 right-1/4 w-1 h-1 bg-blue-200 rounded-full animate-pulse"></div>
            <div class="absolute bottom-1/4 left-2/3 w-1.5 h-1.5 bg-blue-400 rounded-full animate-ping"></div>
        </div>

        <div class="container mx-auto px-4 relative z-10 py-8">
            <div class="min-h-screen flex items-center justify-center">
                <div class="max-w-4xl w-full space-y-8">
                    <!-- Header -->
                    <div class="text-center mb-8">
                        <div class="mx-auto h-16 w-16 flex items-center justify-center rounded-full bg-gradient-to-r from-blue-400 to-blue-600 shadow-lg">
                            <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h1 class="mt-6 text-3xl font-bold text-white tracking-tight">
                            {{ __('site.Doctor Registration') }}
                        </h1>
                        <p class="mt-3 text-lg text-slate-300">
                            {{ __('site.Join our healthcare network') }}
                        </p>
                        <div class="mt-4 w-24 h-1 bg-gradient-to-r from-blue-400 to-blue-600 mx-auto rounded-full"></div>
                    </div>

                    <!-- Main Registration Card -->
                    <div class="bg-white/5 backdrop-blur-xl rounded-2xl border border-white/10 shadow-2xl overflow-hidden">
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
                            <form id="doctorRegistrationForm" action="{{ route('registerDoctor') }}" method="post" enctype="multipart/form-data" class="space-y-8">
                                @csrf

                                <!-- Profile Picture Section -->
                                <div class="text-center mb-8">
                                    <div class="relative inline-block">
                                        <div class="w-24 h-24 bg-white rounded-full border-4 border-blue-400 flex items-center justify-center mx-auto overflow-hidden shadow-lg hover:shadow-xl transition-shadow duration-300">
                                            <img id="profileImage" src="{{ asset('assets/images/doctor-profile.jpg') }}" alt="Profile Picture" class="w-full h-full object-cover">
                                        </div>
                                        <button type="button" onclick="document.getElementById('fileInput').click()" class="absolute bottom-0 right-0 bg-blue-500 text-white p-2 rounded-full shadow-lg hover:bg-blue-600 transition-colors duration-200">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                            </svg>
                                        </button>
                                        <input type="file" name="image" id="fileInput" accept="image/*" class="hidden" onchange="updateProfilePicture(event)">
                                    </div>
                                    <p class="text-slate-300 text-sm mt-2">{{ __('site.Upload your professional photo') }}</p>
                                </div>

                                <div class="space-y-8">
                                    <!-- Personal Information Section -->
                                    <div class="bg-white/5 rounded-xl p-6 border border-white/10">
                                        <h3 class="text-blue-400 text-lg font-semibold mb-6 flex items-center">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                            </svg>
                                            {{ __('site.Personal Information') }}
                                        </h3>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                            <!-- First Name -->
                                            <div class="form-group">
                                                <label class="block text-sm font-medium text-slate-100 mb-2">{{ __('site.First Name') }}</label>
                                                <input type="text" name="first_name" value="{{ old('first_name') }}" class="w-full px-4 py-3 bg-white rounded-lg border border-slate-300 text-slate-900 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 hover:border-blue-300" placeholder="{{ __('site.First Name') }}" required>
                                                @error('first_name')
                                                    <div class="text-red-400 text-sm mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- Last Name -->
                                            <div class="form-group">
                                                <label class="block text-sm font-medium text-slate-100 mb-2">{{ __('site.Surname') }}</label>
                                                <input type="text" name="last_name" value="{{ old('last_name') }}" class="w-full px-4 py-3 bg-white rounded-lg border border-slate-300 text-slate-900 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 hover:border-blue-300" placeholder="{{ __('site.Surname') }}" required>
                                                @error('last_name')
                                                    <div class="text-red-400 text-sm mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- Birthday -->
                                            <div class="form-group">
                                                <label class="block text-sm font-medium text-slate-100 mb-2">{{ __('site.Birthday') }}</label>
                                                <input type="date" name="birthday" value="{{ old('birthday') }}" class="w-full px-4 py-3 bg-white rounded-lg border border-slate-300 text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 hover:border-blue-300" required>
                                                @error('birthday')
                                                    <div class="text-red-400 text-sm mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- Specialization -->
                                            <div class="form-group">
                                                <label class="block text-sm font-medium text-slate-100 mb-2">{{ __('site.Specialization') }}</label>
                                                <input type="text" name="specialization" value="{{ old('specialization') }}" class="w-full px-4 py-3 bg-white rounded-lg border border-slate-300 text-slate-900 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 hover:border-blue-300" placeholder="{{ __('site.e.g., Psychiatrist, Psychologist') }}" required>
                                                @error('specialization')
                                                    <div class="text-red-400 text-sm mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Contact Information Section -->
                                    <div class="bg-white/5 rounded-xl p-6 border border-white/10">
                                        <h3 class="text-blue-400 text-lg font-semibold mb-6 flex items-center">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                            </svg>
                                            {{ __('site.Contact Information') }}
                                        </h3>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                            <!-- Email -->
                                            <div class="form-group">
                                                <label class="block text-sm font-medium text-slate-100 mb-2">{{ __('site.Email') }}</label>
                                                <input type="email" name="email" value="{{ old('email') }}" class="w-full px-4 py-3 bg-white rounded-lg border border-slate-300 text-slate-900 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 hover:border-blue-300" placeholder="{{ __('site.Email Address') }}" required>
                                                @error('email')
                                                    <div class="text-red-400 text-sm mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- Phone -->
                                            <div class="form-group">
                                                <label class="block text-sm font-medium text-slate-100 mb-2">{{ __('site.Phone') }}</label>
                                                <input type="tel" name="phone" value="{{ old('phone') }}" class="w-full px-4 py-3 bg-white rounded-lg border border-slate-300 text-slate-900 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 hover:border-blue-300" placeholder="0918657965" required>
                                                @error('phone')
                                                    <div class="text-red-400 text-sm mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- Address -->
                                            <div class="form-group md:col-span-2">
                                                <label class="block text-sm font-medium text-slate-100 mb-2">{{ __('site.Address') }}</label>
                                                <input type="text" name="address" value="{{ old('address') }}" class="w-full px-4 py-3 bg-white rounded-lg border border-slate-300 text-slate-900 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 hover:border-blue-300" placeholder="{{ __('site.Clinic or Hospital Address') }}">
                                                @error('address')
                                                    <div class="text-red-400 text-sm mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- Password -->
                                            <div class="form-group">
                                                <label class="block text-sm font-medium text-slate-100 mb-2">{{ __('site.Password') }}</label>
                                                <input type="password" id="new_pass" name="password" class="w-full px-4 py-3 bg-white rounded-lg border border-slate-300 text-slate-900 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 hover:border-blue-300" placeholder="••••••••" required>
                                                @error('password')
                                                    <div class="text-red-400 text-sm mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- Confirm Password -->
                                            <div class="form-group">
                                                <label class="block text-sm font-medium text-slate-100 mb-2">{{ __('site.Confirm Password') }}</label>
                                                <input type="password" id="confirm_pass" name="password_confirmation" class="w-full px-4 py-3 bg-white rounded-lg border border-slate-300 text-slate-900 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 hover:border-blue-300" placeholder="••••••••" required>
                                                @error('password_confirmation')
                                                    <div class="text-red-400 text-sm mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Social Media Section (Optional) -->
                                    <div class="bg-white/5 rounded-xl p-6 border border-white/10">
                                        <h3 class="text-blue-400 text-lg font-semibold mb-6 flex items-center">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                            </svg>
                                            {{ __('site.Social Media') }} <span class="text-slate-400 text-sm ml-2">({{ __('site.Optional') }})</span>
                                        </h3>
                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                            <!-- Twitter -->
                                            <div class="form-group">
                                                <label class="block text-sm font-medium text-slate-100 mb-2">{{ __('site.Twitter') }}</label>
                                                <input type="text" name="twitter" value="{{ old('twitter') }}" class="w-full px-4 py-3 bg-white rounded-lg border border-slate-300 text-slate-900 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 hover:border-blue-300" placeholder="@username">
                                                @error('twitter')
                                                    <div class="text-red-400 text-sm mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- Facebook -->
                                            <div class="form-group">
                                                <label class="block text-sm font-medium text-slate-100 mb-2">{{ __('site.Facebook') }}</label>
                                                <input type="text" name="facebook" value="{{ old('facebook') }}" class="w-full px-4 py-3 bg-white rounded-lg border border-slate-300 text-slate-900 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 hover:border-blue-300" placeholder="facebook.com/username">
                                                @error('facebook')
                                                    <div class="text-red-400 text-sm mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- Instagram -->
                                            <div class="form-group">
                                                <label class="block text-sm font-medium text-slate-100 mb-2">{{ __('site.Instagram') }}</label>
                                                <input type="text" name="instagram" value="{{ old('instagram') }}" class="w-full px-4 py-3 bg-white rounded-lg border border-slate-300 text-slate-900 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 hover:border-blue-300" placeholder="@username">
                                                @error('instagram')
                                                    <div class="text-red-400 text-sm mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="flex justify-center pt-6 border-t border-white/10">
                                    <button type="submit" class="inline-flex items-center px-12 py-4 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold rounded-lg shadow-lg hover:from-blue-600 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-slate-800 transform hover:scale-105 transition-all duration-200">
                                        {{ __('site.Complete Registration') }}
                                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Back to Login -->
                    <div class="text-center mt-8">
                        <p class="text-slate-300 mb-3">{{ __('site.Already have an account?') }}</p>
                        <a href="{{ route('login') }}" class="inline-flex items-center gap-2 text-blue-400 hover:text-blue-300 font-medium transition-colors duration-200 group">
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

    <!-- JavaScript for profile picture update -->
    <script>
        function updateProfilePicture(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('profileImage').src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        }
    </script>
@endsection

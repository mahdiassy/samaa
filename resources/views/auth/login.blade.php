@extends('layouts.base')
@section('content')
    <!-- Login Hero Section -->
    <section class="relative min-h-screen flex items-center justify-center overflow-hidden bg-gradient-to-br from-slate-900 via-slate-800 to-blue-900 pt-20">
        <!-- Scientific Grid Pattern -->
        <div class="absolute inset-0 opacity-20">
            <div class="absolute inset-0" style="background-image: radial-gradient(circle at 1px 1px, rgba(255,255,255,0.15) 1px, transparent 0); background-size: 50px 50px;"></div>
        </div>
        
        <!-- Floating Particles -->
        <div class="absolute inset-0">
            <div class="absolute top-1/4 left-1/4 w-2 h-2 bg-blue-400 rounded-full animate-ping"></div>
            <div class="absolute top-1/3 right-1/3 w-1 h-1 bg-emerald-400 rounded-full animate-pulse"></div>
            <div class="absolute bottom-1/3 left-1/3 w-1.5 h-1.5 bg-teal-400 rounded-full animate-bounce"></div>
            <div class="absolute top-2/3 right-1/4 w-1 h-1 bg-blue-300 rounded-full animate-pulse"></div>
            <div class="absolute bottom-1/4 left-2/3 w-1.5 h-1.5 bg-emerald-300 rounded-full animate-ping"></div>
        </div>
        
        <div class="container mx-auto px-6 relative z-10">
            <div class="max-w-6xl mx-auto">
                <div class="grid lg:grid-cols-2 gap-16 items-center">
                    <!-- Left Side - Welcome Content -->
                    <div class="text-center lg:text-left">
                        <div class="mb-8">
                            <h2 class="text-2xl lg:text-3xl text-emerald-400 font-semibold mb-4">
                                Welcome to SAMAA
                            </h2>
                            <h1 class="text-5xl lg:text-7xl font-serif mb-6 bg-gradient-to-r from-white via-blue-100 to-emerald-100 bg-clip-text text-transparent leading-tight">
                                Hear to
                                <span class="block bg-gradient-to-r from-emerald-400 to-blue-400 bg-clip-text text-transparent">
                                    Heal
                                </span>
                            </h1>
                            <p class="text-xl lg:text-2xl text-slate-300 mb-8 max-w-2xl">
                                Sign in to continue your personalized healing journey with AI-powered sound therapy.
                            </p>
                        </div>
                        
                        <!-- Features Preview -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 max-w-lg mx-auto lg:mx-0">
                            <div class="flex items-center gap-4 text-slate-300">
                                <div class="w-10 h-10 bg-gradient-to-br from-emerald-400 to-blue-400 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                    </svg>
                                </div>
                                <span class="font-medium">Personalized Therapy</span>
                            </div>
                            <div class="flex items-center gap-4 text-slate-300">
                                <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-teal-400 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <span class="font-medium">Progress Tracking</span>
                            </div>
                            <div class="flex items-center gap-4 text-slate-300">
                                <div class="w-10 h-10 bg-gradient-to-br from-teal-400 to-emerald-400 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2z"/>
                                    </svg>
                                </div>
                                <span class="font-medium">Secure & Private</span>
                            </div>
                            <div class="flex items-center gap-4 text-slate-300">
                                <div class="w-10 h-10 bg-gradient-to-br from-emerald-400 to-blue-400 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                    </svg>
                                </div>
                                <span class="font-medium">Expert Guidance</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Right Side - Login Form -->
                    <div class="relative">
                        <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-6 lg:p-8 border border-white/20 shadow-2xl max-w-md mx-auto">
                            <div class="text-center mb-6">
                                <h3 class="text-2xl lg:text-3xl font-serif text-white mb-2">Sign In</h3>
                                <p class="text-slate-300 text-sm">Access your healing dashboard</p>
                            </div>
                            
                            <form class="space-y-4" action="{{ route('login') }}" method="POST">
                                @csrf
                                
                                <!-- Email Field -->
                                <div>
                                    <label for="email" class="block text-sm font-semibold text-white mb-2">Email Address</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="w-4 h-4 text-slate-400" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                                            </svg>
                                        </div>
                                        <input type="email" id="email" name="email" 
                                               class="w-full pl-10 pr-3 py-3 bg-white/20 border border-white/30 rounded-lg text-white placeholder-slate-300 focus:ring-2 focus:ring-emerald-400 focus:border-emerald-400 transition-all duration-300 text-sm"
                                               placeholder="Enter your email address"
                                               value="{{ old('email') }}" required>
                                    </div>
                                    @error('email')
                                        <div class="mt-2 text-red-300 text-sm">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <!-- Password Field -->
                                <div>
                                    <label for="password" class="block text-sm font-semibold text-white mb-2">Password</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="w-4 h-4 text-slate-400" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/>
                                            </svg>
                                        </div>
                                        <input type="password" id="password" name="password" 
                                               class="w-full pl-10 pr-3 py-3 bg-white/20 border border-white/30 rounded-lg text-white placeholder-slate-300 focus:ring-2 focus:ring-emerald-400 focus:border-emerald-400 transition-all duration-300 text-sm"
                                               placeholder="Enter your password" required>
                                    </div>
                                    @error('password')
                                        <div class="mt-2 text-red-300 text-sm">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <!-- Remember Me & Forgot Password -->
                                <div class="flex items-center justify-between">
                                    <label class="flex items-center cursor-pointer group">
                                        <div class="relative">
                                            <input type="checkbox" name="remember" class="sr-only peer">
                                            <div class="w-5 h-5 bg-white/20 border-2 border-white/30 rounded-md transition-all duration-300 peer-checked:bg-gradient-to-r peer-checked:from-emerald-500 peer-checked:to-blue-500 peer-checked:border-emerald-400 group-hover:border-emerald-400/60">
                                                <svg class="w-3 h-3 text-white absolute top-0.5 left-0.5 opacity-0 peer-checked:opacity-100 transition-opacity duration-300" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                </svg>
                                            </div>
                                        </div>
                                        <span class="ml-3 text-sm text-slate-300 group-hover:text-white transition-colors duration-300 select-none">Remember me</span>
                                    </label>
                                    <a href="#" class="text-sm text-emerald-400 hover:text-emerald-300 transition-colors duration-300 hover:underline">
                                        Forgot password?
                                    </a>
                                </div>
                                
                                <!-- Submit Button -->
                                <button type="submit" 
                                        class="w-full px-6 py-3 bg-gradient-to-r from-emerald-600 to-blue-600 hover:from-emerald-700 hover:to-blue-700 text-white font-semibold rounded-lg transition-all duration-300 transform hover:scale-105 shadow-lg text-sm">
                                    Sign In to SAMAA
                                </button>
                                
                                <!-- Divider -->
                                <div class="relative my-6">
                                    <div class="absolute inset-0 flex items-center">
                                        <div class="w-full border-t border-white/20"></div>
                                    </div>
                                    <div class="relative flex justify-center text-sm">
                                        <span class="px-3 bg-transparent text-slate-300 text-xs">Don't have an account?</span>
                                    </div>
                                </div>
                                
                                <!-- Register Link -->
                                <div class="text-center">
                                    <a href="{{ route('register') }}" 
                                       class="inline-flex items-center px-4 py-2 border-2 border-emerald-400 text-emerald-400 hover:bg-emerald-400 hover:text-slate-900 font-semibold rounded-lg transition-all duration-300 text-sm">
                                        Create New Account
                                    </a>
                                </div>
                            </form>
                        </div>
                        
                        <!-- Decorative Elements -->
                        <div class="absolute -top-3 -right-3 w-16 h-16 bg-gradient-to-br from-emerald-400/20 to-blue-400/20 rounded-full blur-xl"></div>
                        <div class="absolute -bottom-3 -left-3 w-20 h-20 bg-gradient-to-br from-blue-400/20 to-teal-400/20 rounded-full blur-xl"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

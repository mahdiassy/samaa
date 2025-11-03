@extends('layouts.base')
@section('content')
    <!-- Registration Type Selection -->
    <section class="relative min-h-screen flex items-center justify-center overflow-hidden bg-gradient-to-br from-slate-900 via-slate-800 to-blue-900">
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
            <div class="max-w-2xl mx-auto">
                <!-- Main Registration Card -->
                <div class="bg-white/10 backdrop-blur-lg rounded-3xl border border-white/20 shadow-2xl p-8 lg:p-12">
                    <!-- Header -->
                    <div class="text-center mb-10">
                        <div class="mb-6">
                            <div class="w-20 h-20 bg-gradient-to-br from-emerald-400 to-blue-400 rounded-2xl flex items-center justify-center mx-auto mb-4">
                                <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                </svg>
                            </div>
                        </div>
                        <h1 class="text-3xl lg:text-4xl font-serif font-bold text-white mb-4">
                            {{ __('site.Choose Registration Type') }}
                        </h1>
                        <p class="text-lg text-slate-300">
                            {{ __('site.Join SAMAA therapeutic community') }}
                        </p>
                    </div>

                    <!-- Registration Options -->
                    <div class="space-y-4 mb-8">
                        <!-- Patient Registration -->
                        <a href="{{ route('showRegisterPatient') }}" 
                           class="group block w-full bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 text-white rounded-2xl p-6 transition-all duration-300 transform hover:scale-[1.02] hover:shadow-xl">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                        </svg>
                                    </div>
                                    <div class="text-left">
                                        <h3 class="text-xl font-semibold">{{ __('site.Register as Patient') }}</h3>
                                        <p class="text-emerald-100 text-sm">{{ __('site.Receive personalized therapy') }}</p>
                                    </div>
                                </div>
                                <div class="transform group-hover:translate-x-1 transition-transform duration-300">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </div>
                            </div>
                        </a>

                        <!-- Doctor Registration -->
                        <a href="{{ route('showRegisterDoctor') }}" 
                           class="group block w-full bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white rounded-2xl p-6 transition-all duration-300 transform hover:scale-[1.02] hover:shadow-xl">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z"/>
                                        </svg>
                                    </div>
                                    <div class="text-left">
                                        <h3 class="text-xl font-semibold">{{ __('site.Register as Doctor') }}</h3>
                                        <p class="text-blue-100 text-sm">{{ __('site.Provide professional therapy') }}</p>
                                    </div>
                                </div>
                                <div class="transform group-hover:translate-x-1 transition-transform duration-300">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- Login Link -->
                    <div class="text-center border-t border-white/20 pt-6">
                        <p class="text-slate-300 mb-3">{{ __('site.Already have an account?') }}</p>
                        <a href="{{ route('login') }}" 
                           class="inline-flex items-center gap-2 text-emerald-400 hover:text-emerald-300 font-medium transition-colors duration-200">
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

@endsection

<!-- Bootstrap removed - now using Tailwind CSS -->
<!-- Tailwind is loaded via the vite directive in the layout -->

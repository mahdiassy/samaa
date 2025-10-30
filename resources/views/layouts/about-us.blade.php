@extends('layouts.base')
@section('content')
    <main id="main-content" class="min-h-screen bg-gradient-to-br from-slate-900 via-blue-900 to-slate-800">
        
        <!-- Hero Section: Where Science Meets Soul -->
        <section class="relative py-20 sm:py-24 lg:py-32 overflow-hidden">
            <!-- Scientific Background Pattern -->
            <div class="absolute inset-0 opacity-5">
                <div class="absolute inset-0" style="background-image: radial-gradient(circle at 1px 1px, rgba(255,255,255,0.3) 1px, transparent 0); background-size: 20px 20px;"></div>
            </div>
            
            <!-- Floating Elements -->
            <div class="absolute top-20 left-10 w-20 h-20 bg-blue-400/10 rounded-full blur-xl animate-pulse"></div>
            <div class="absolute bottom-20 right-10 w-32 h-32 bg-emerald-400/10 rounded-full blur-xl animate-pulse delay-1000"></div>
            
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="text-center max-w-4xl mx-auto">
                    @if (App::getLocale() == 'ar')
                        <h1 class="text-4xl sm:text-5xl lg:text-6xl xl:text-7xl font-serif font-bold mb-8 leading-tight">
                            <span class="text-white">{{ __('frontend/about.Where') }}</span>
                            <span class="bg-gradient-to-r from-blue-400 via-teal-400 to-emerald-400 bg-clip-text text-transparent">
                                {{ __('frontend/about.Science') }}
                            </span>
                            <span class="text-white">{{ __('frontend/about.Meets') }}</span>
                            <span class="bg-gradient-to-r from-emerald-400 via-blue-400 to-teal-400 bg-clip-text text-transparent">
                                {{ __('frontend/about.Soul') }}
                            </span>
                        </h1>
                    @elseif (App::getLocale() == 'fr')
                        <h1 class="text-4xl sm:text-5xl lg:text-6xl xl:text-7xl font-serif font-bold mb-8 leading-tight">
                            <span class="text-white">{{ __('frontend/about.Where') }}</span>
                            <span class="text-white">la</span>
                            <span class="bg-gradient-to-r from-blue-400 via-teal-400 to-emerald-400 bg-clip-text text-transparent">
                                {{ __('frontend/about.Science') }}
                            </span>
                            <span class="text-white">{{ __('frontend/about.Meets') }}</span>
                            <span class="text-white">l'</span><span class="bg-gradient-to-r from-emerald-400 via-blue-400 to-teal-400 bg-clip-text text-transparent">{{ __('frontend/about.Soul') }}</span>
                        </h1>
                    @else
                        <h1 class="text-4xl sm:text-5xl lg:text-6xl xl:text-7xl font-serif font-bold mb-8 leading-tight">
                            <span class="text-white">{{ __('frontend/about.Where') }}</span>
                            <span class="bg-gradient-to-r from-blue-400 via-teal-400 to-emerald-400 bg-clip-text text-transparent">
                                {{ __('frontend/about.Science') }}
                            </span>
                            <span class="text-white">{{ __('frontend/about.Meets') }}</span>
                            <span class="bg-gradient-to-r from-emerald-400 via-blue-400 to-teal-400 bg-clip-text text-transparent">
                                {{ __('frontend/about.Soul') }}
                            </span>
                        </h1>
                    @endif
                    
                    <p class="text-xl sm:text-2xl text-slate-300 mb-12 leading-relaxed font-light">
                        {{ __('frontend/about.story-description') }}
                    </p>

                    <!-- Elegant CTA Buttons -->
                    <div class="flex flex-col sm:flex-row gap-6 justify-center items-center">
                        <a href="{{ Auth::check() ? (\App\Models\Therapy::getTherapiesBasedRole()->isNotEmpty() ? route('playlist') : route('therapy.index')) : route('login')  }}" 
                           class="group px-8 py-4 bg-gradient-to-r from-blue-600 to-teal-600 text-white font-semibold rounded-2xl text-lg hover:from-blue-700 hover:to-teal-700 transform hover:scale-105 transition-all duration-300 shadow-xl hover:shadow-2xl hover:shadow-blue-500/25">
                            <span class="flex items-center">
                                @if(App::getLocale() == 'ar')
                                    <svg class="w-5 h-5 mr-2 group-hover:-translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12"></path>
                                    </svg>
                                @endif
                                {{__('frontend/about.Explore') }} SAMAA {{ __('frontend/about.Therapy') }}
                                @if(App::getLocale() != 'ar')
                                    <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                    </svg>
                                @endif
                            </span>
                        </a>
                        
                        <a href="{{ route('contact-us') }}" 
                           class="group px-8 py-4 bg-white/10 backdrop-blur-sm border border-white/20 text-white font-semibold rounded-2xl text-lg hover:bg-white/20 hover:border-white/30 transform hover:scale-105 transition-all duration-300">
                            <span class="flex items-center">
                                @if(App::getLocale() == 'ar')
                                    <svg class="w-5 h-5 mr-2 group-hover:-translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"></path>
                                    </svg>
                                @endif
                                {{ __('frontend/about.Become a Partner') }}
                                @if(App::getLocale() != 'ar')
                                    <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                    </svg>
                                @endif
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Mission Section -->
        <section class="py-16 sm:py-20 lg:py-24 relative">
            <!-- Elegant Separator -->
            <div class="absolute top-0 left-1/2 transform -translate-x-1/2 w-32 h-px bg-gradient-to-r from-transparent via-blue-400 to-transparent"></div>
            
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid lg:grid-cols-3 gap-8 lg:gap-12 items-center">
                    <!-- Mission Title -->
                    <div class="lg:col-span-1 text-center lg:text-left">
                        <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-3xl p-8 lg:p-10">
                            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-serif font-bold text-white mb-6">
                                <span class="bg-gradient-to-r from-blue-400 to-teal-400 bg-clip-text text-transparent">
                                    {{ __('frontend/about.our') }}
                                </span>
                                <br>
                                <span class="text-white">{{ __('frontend/about.Mission') }}</span>
                            </h2>
                        </div>
                    </div>
                    
                    <!-- Central Image -->
                    <div class="lg:col-span-1 flex justify-center">
                        <div class="relative group">
                            <div class="absolute inset-0 bg-gradient-to-r from-blue-600 to-teal-600 rounded-full blur-xl opacity-30 group-hover:opacity-50 transition-opacity duration-500"></div>
                            <div class="relative bg-white/10 backdrop-blur-sm border border-white/20 rounded-full p-8 lg:p-12">
                                <img src="{{ asset('assets/images/headphone2.png') }}" 
                                     alt="Professional headphones for music therapy" 
                                     class="w-32 h-32 lg:w-40 lg:h-40 object-contain filter drop-shadow-2xl" 
                                     loading="lazy">
                            </div>
                        </div>
                    </div>
                    
                    <!-- Mission Description -->
                    <div class="lg:col-span-1 text-center lg:text-right">
                        <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-3xl p-8 lg:p-10">
                            <p class="text-lg sm:text-xl text-slate-300 leading-relaxed font-light">
                                {{ __('frontend/about.mission-description') }}
                            </p>
                            <div class="mt-6 flex justify-center lg:justify-end">
                                <div class="w-16 h-px bg-gradient-to-r from-transparent to-teal-400"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Founder Section -->
        <section class="py-16 sm:py-20 lg:py-24 relative">
            <!-- Elegant Separator -->
            <div class="absolute top-0 left-1/2 transform -translate-x-1/2 w-32 h-px bg-gradient-to-r from-transparent via-emerald-400 to-transparent"></div>
            
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center">
                    <!-- Founder Info -->
                    <div class="order-2 lg:order-1 text-center lg:text-left">
                        <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-3xl p-8 lg:p-12">
                            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-serif font-bold text-white mb-6">
                                {{ __('frontend/about.Meet') }}
                                <span class="bg-gradient-to-r from-emerald-400 to-blue-400 bg-clip-text text-transparent block">
                                    {{ __('frontend/about.Dr. Nadia Cheaib') }}
                                </span>
                            </h2>
                            
                            <div class="space-y-6">
                                <p class="text-xl font-semibold text-blue-300">
                                    {{ __('frontend/about.Founder & Clinical Director') }}
                                </p>
                                
                                <p class="text-lg text-slate-300 leading-relaxed">
                                    {{ __('frontend/about.founder-description') }}
                                </p>
                                
                                <!-- Professional Credentials -->
                                <div class="bg-white/5 rounded-2xl p-6 border border-white/10">
                                    <h3 class="text-lg font-semibold text-white mb-4">{{ __('frontend/about.Professional Credentials') }}</h3>
                                    <ul class="space-y-2 text-slate-300">
                                        <li class="flex items-center">
                                            <svg class="w-4 h-4 text-emerald-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                            </svg>
                                            {{ __('frontend/about.PhD in Music Therapy') }}
                                        </li>
                                        <li class="flex items-center">
                                            <svg class="w-4 h-4 text-emerald-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                            </svg>
                                            {{ __('frontend/about.Board-Certified Music Therapist') }}
                                        </li>
                                        <li class="flex items-center">
                                            <svg class="w-4 h-4 text-emerald-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                            </svg>
                                            {{ __('frontend/about.15+ Years Clinical Experience') }}
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Founder Image -->
                    <div class="order-1 lg:order-2 flex justify-center">
                        <div class="relative group">
                            <div class="absolute inset-0 bg-gradient-to-r from-emerald-600 to-blue-600 rounded-3xl blur-xl opacity-30 group-hover:opacity-50 transition-opacity duration-500"></div>
                            <div class="relative bg-white/10 backdrop-blur-sm border border-white/20 rounded-3xl p-8 lg:p-10">
                                <img src="{{ asset('assets/images/Dr.Nadia.png') }}" 
                                     alt="Dr. Nadia Cheaib - Founder of SAMAA" 
                                     class="w-full max-w-sm h-auto object-cover rounded-2xl filter drop-shadow-2xl" 
                                     loading="lazy">
                                <div class="absolute -bottom-6 -right-6 bg-gradient-to-r from-emerald-500 to-blue-500 text-white px-4 py-2 rounded-full text-sm font-semibold shadow-xl">
                                    {{ __('frontend/about.Founder') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Recognition & Partnership Section -->
        <section class="py-16 sm:py-20 lg:py-24 relative">
            <!-- Elegant Separator -->
            <div class="absolute top-0 left-1/2 transform -translate-x-1/2 w-32 h-px bg-gradient-to-r from-transparent via-blue-400 to-transparent"></div>
            
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Section Header -->
                <div class="text-center mb-16">
                    <h2 class="text-3xl sm:text-4xl lg:text-5xl font-serif font-bold text-white mb-6">
                        <span class="bg-gradient-to-r from-blue-400 to-emerald-400 bg-clip-text text-transparent">
                            {{ __('frontend/about.Recognition') }}
                        </span>
                        <span class="text-white">&</span>
                        <span class="bg-gradient-to-r from-emerald-400 to-blue-400 bg-clip-text text-transparent">
                            {{ __('frontend/about.Partnerships') }}
                        </span>
                    </h2>
                    <div class="flex justify-center">
                        <div class="w-24 h-px bg-gradient-to-r from-transparent via-teal-400 to-transparent"></div>
                    </div>
                </div>

                <div class="grid lg:grid-cols-2 gap-12 lg:gap-16">
                    <!-- Awards Section -->
                    <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-3xl p-8 lg:p-10">
                        <h3 class="text-2xl sm:text-3xl font-serif font-bold text-white mb-8 text-center">
                            <span class="bg-gradient-to-r from-emerald-400 to-blue-400 bg-clip-text text-transparent">
                                {{ __('frontend/about.Awards') }}
                            </span>
                        </h3>
                        
                        <div class="space-y-6">
                            <div class="bg-white/5 rounded-2xl p-6 border border-white/10 hover:border-emerald-400/30 transition-colors duration-300">
                                <div class="flex items-start space-x-4">
                                    <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-r from-emerald-500 to-blue-500 rounded-full flex items-center justify-center">
                                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="text-lg font-semibold text-white mb-2">{{ __('frontend/about.Go Global Award 2022') }}</h4>
                                        <p class="text-slate-300">{{ __('frontend/about.Corporate Social Responsibility') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Trusted Partners Section -->
                    <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-3xl p-8 lg:p-10">
                        <h3 class="text-2xl sm:text-3xl font-serif font-bold text-white mb-8 text-center">
                            <span class="bg-gradient-to-r from-blue-400 to-emerald-400 bg-clip-text text-transparent">
                                {{ __('frontend/about.Trusted By') }}
                            </span>
                        </h3>
                        
                        <div class="space-y-4">
                            <div class="bg-white/5 rounded-2xl p-4 border border-white/10 hover:border-blue-400/30 transition-colors duration-300">
                                <p class="text-white font-medium">{{ __('frontend/about.Dubai Autism Center') }}</p>
                            </div>
                            <div class="bg-white/5 rounded-2xl p-4 border border-white/10 hover:border-blue-400/30 transition-colors duration-300">
                                <p class="text-white font-medium">{{ __('frontend/about.American European Music Therapy Association') }}</p>
                            </div>
                            <div class="bg-white/5 rounded-2xl p-4 border border-white/10 hover:border-blue-400/30 transition-colors duration-300">
                                <p class="text-white font-medium">{{ __('frontend/about.Forbes') }}</p>
                            </div>
                            <div class="bg-white/5 rounded-2xl p-4 border border-white/10 hover:border-blue-400/30 transition-colors duration-300">
                                <p class="text-white font-medium">{{ __('frontend/about.Hope MCF Foundation') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Final CTA Section -->
        <section class="py-16 sm:py-20 lg:py-24 relative">
            <!-- Elegant Separator -->
            <div class="absolute top-0 left-1/2 transform -translate-x-1/2 w-32 h-px bg-gradient-to-r from-transparent via-emerald-400 to-transparent"></div>
            
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-3xl p-8 lg:p-12">
                    <h2 class="text-3xl sm:text-4xl lg:text-5xl font-serif font-bold text-white mb-6">
                        {{ __('frontend/about.Let') }}<span class="text-white">'s</span>
                        <span class="bg-gradient-to-r from-blue-400 to-emerald-400 bg-clip-text text-transparent block">
                            {{ __('frontend/about.Heal') }} {{ __('frontend/about.Together') }}
                        </span>
                    </h2>
                    
                    <p class="text-xl text-slate-300 mb-8 leading-relaxed">
                        {{ __('frontend/about.join-journey-description') }}
                    </p>

                    <!-- Final CTA Buttons -->
                    <div class="flex flex-col sm:flex-row gap-6 justify-center items-center">
                        <a href="{{ Auth::check() ? (\App\Models\Therapy::getTherapiesBasedRole()->isNotEmpty() ? route('playlist') : route('therapy.index')) : route('login')  }}" 
                           class="group px-8 py-4 bg-gradient-to-r from-blue-600 to-emerald-600 text-white font-semibold rounded-2xl text-lg hover:from-blue-700 hover:to-emerald-700 transform hover:scale-105 transition-all duration-300 shadow-xl hover:shadow-2xl hover:shadow-emerald-500/25">
                            <span class="flex items-center">
                                @if(App::getLocale() == 'ar')
                                    <svg class="w-5 h-5 mr-2 group-hover:-translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12"></path>
                                    </svg>
                                @endif
                                {{ __('frontend/about.Explore') }} SAMAA {{ __('frontend/about.Therapy') }}
                                @if(App::getLocale() != 'ar')
                                    <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                    </svg>
                                @endif
                            </span>
                        </a>
                        
                        <a href="{{ route('contact-us') }}" 
                           class="group px-8 py-4 bg-white/10 backdrop-blur-sm border border-white/20 text-white font-semibold rounded-2xl text-lg hover:bg-white/20 hover:border-white/30 transform hover:scale-105 transition-all duration-300">
                            <span class="flex items-center">
                                @if(App::getLocale() == 'ar')
                                    <svg class="w-5 h-5 mr-2 group-hover:-translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"></path>
                                    </svg>
                                @endif
                                {{ __('frontend/about.Become a Partner') }}
                                @if(App::getLocale() != 'ar')
                                    <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                    </svg>
                                @endif
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
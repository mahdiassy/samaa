@extends('layouts.base')
@section('content')
    <main id="main-content" class="min-h-screen bg-gradient-to-br from-slate-900 via-blue-900 to-slate-800">
        
        <!-- Hero Section: The Science Behind SAMAA -->
        <section class="relative py-20 sm:py-24 lg:py-32 overflow-hidden" data-animate="fade-in-up">
            <!-- Scientific Background Pattern -->
            <div class="absolute inset-0 opacity-5">
                <div class="absolute inset-0" style="background-image: radial-gradient(circle at 1px 1px, rgba(255,255,255,0.3) 1px, transparent 0); background-size: 20px 20px;"></div>
            </div>
            
            <!-- Floating Elements -->
            <div class="absolute top-20 left-10 w-20 h-20 bg-blue-400/10 rounded-full blur-xl animate-pulse"></div>
            <div class="absolute bottom-20 right-10 w-32 h-32 bg-emerald-400/10 rounded-full blur-xl animate-pulse delay-1000"></div>
            
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="text-center max-w-5xl mx-auto">
                    @if (App::getLocale() == 'ar')
                        <h1 class="text-4xl sm:text-5xl lg:text-6xl xl:text-7xl font-serif font-bold mb-8 leading-tight">
                            <span class="text-white">{{ __('frontend/hIT.The') }}</span>
                            <span class="bg-gradient-to-r from-blue-400 via-teal-400 to-emerald-400 bg-clip-text text-transparent">
                                {{ __('frontend/hIT.science') }}
                            </span>
                            <span class="text-white">{{ __('frontend/hIT.Behind SAMAA') }}</span>
                        </h1>
                    @elseif (App::getLocale() == 'fr')
                        <h1 class="text-4xl sm:text-5xl lg:text-6xl xl:text-7xl font-serif font-bold mb-8 leading-tight">
                            <span class="text-white">{{ __('frontend/hIT.The') }}</span>
                            <span class="bg-gradient-to-r from-blue-400 via-teal-400 to-emerald-400 bg-clip-text text-transparent">
                                {{ __('frontend/hIT.science') }}
                            </span>
                            <span class="text-white">{{ __('frontend/hIT.Behind SAMAA') }}</span>
                        </h1>
                    @else
                        <h1 class="text-4xl sm:text-5xl lg:text-6xl xl:text-7xl font-serif font-bold mb-8 leading-tight">
                            <span class="text-white">{{ __('frontend/hIT.The') }}</span>
                            <span class="bg-gradient-to-r from-blue-400 via-teal-400 to-emerald-400 bg-clip-text text-transparent">
                                {{ __('frontend/hIT.science') }}
                            </span>
                            <span class="text-white">{{ __('frontend/hIT.Behind SAMAA') }}</span>
                        </h1>
                    @endif
                    
                    <p class="text-xl sm:text-2xl text-slate-300 mb-8 leading-relaxed font-light">
                        {{ __('frontend/hIT.Healing Through Sound, Perfected by Science') }}
                    </p>
                    
                    <p class="text-lg text-slate-400 mb-12 leading-relaxed max-w-4xl mx-auto">
                        {{ __('frontend/hIT.work-description') }}
                    </p>

                    <!-- Elegant CTA -->
                    <div class="flex justify-center">
                        <a href="#science-process" 
                           class="group px-8 py-4 bg-gradient-to-r from-blue-600 to-teal-600 text-white font-semibold rounded-2xl text-lg hover:from-blue-700 hover:to-teal-700 transform hover:scale-105 transition-all duration-300 shadow-xl hover:shadow-2xl hover:shadow-blue-500/25">
                            <span class="flex items-center">
                                Explore the Process
                                <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                                </svg>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Dr. Nadia Credentials Section -->
        <section class="py-16 sm:py-20 lg:py-24 relative" data-animate="fade-in-up" data-delay="200">
            <!-- Elegant Separator -->
            <div class="absolute top-0 left-1/2 transform -translate-x-1/2 w-32 h-px bg-gradient-to-r from-transparent via-blue-400 to-transparent"></div>
            
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center">
                    <!-- Doctor Image -->
                    <div class="flex justify-center">
                        <div class="relative group">
                            <div class="absolute inset-0 bg-gradient-to-r from-emerald-600 to-blue-600 rounded-3xl blur-xl opacity-30 group-hover:opacity-50 transition-opacity duration-500"></div>
                            <div class="relative bg-white/10 backdrop-blur-sm border border-white/20 rounded-3xl p-8 lg:p-10">
                                <img src="{{ asset('assets/images/doctor-profile.jpg') }}" 
                                     alt="Dr. Nadia Cheaib - SAMAA Founder" 
                                     class="w-full max-w-sm h-auto object-cover rounded-2xl filter drop-shadow-2xl" 
                                     loading="lazy">
                            </div>
                        </div>
                    </div>
                    
                    <!-- Credentials Timeline -->
                    <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-3xl p-8 lg:p-10">
                        <h3 class="text-2xl sm:text-3xl font-serif font-bold text-white mb-8 text-center">
                            <span class="bg-gradient-to-r from-emerald-400 to-blue-400 bg-clip-text text-transparent">
                                {{ __('frontend/hIT.Professional Credentials') }}
                            </span>
                        </h3>
                        
                        <div class="space-y-6">
                            <div class="flex items-start">
                                <div class="w-4 h-4 bg-emerald-400 rounded-full mt-2 mr-4 flex-shrink-0"></div>
                                <p class="text-slate-300 text-lg">{{ __('frontend/hIT.7x Forbes Most Influential Arab Woman') }}</p>
                            </div>
                            <div class="flex items-start">
                                <div class="w-4 h-4 bg-blue-400 rounded-full mt-2 mr-4 flex-shrink-0"></div>
                                <p class="text-slate-300 text-lg">{{ __('hIT.Pioneer In AI-Driven Healthcare Solutions') }}</p>
                            </div>
                            <div class="flex items-start">
                                <div class="w-4 h-4 bg-teal-400 rounded-full mt-2 mr-4 flex-shrink-0"></div>
                                <p class="text-slate-300 text-lg">{{ __('frontend/hIT.Backed By A 6-Month Clinical Trial Using The U-Shaped Montage Technique.') }}</p>
                            </div>
                            <div class="flex items-start">
                                <div class="w-4 h-4 bg-purple-400 rounded-full mt-2 mr-4 flex-shrink-0"></div>
                                <p class="text-slate-300 text-lg">{{ __('frontend/hIT.Endorsed By The American European Music Therapy Association.') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- U-Shaped Protocol Section -->
        <section class="py-16 sm:py-20 lg:py-24 relative" data-animate="fade-in-up" data-delay="400">
            <!-- Elegant Separator -->
            <div class="absolute top-0 left-1/2 transform -translate-x-1/2 w-32 h-px bg-gradient-to-r from-transparent via-emerald-400 to-transparent"></div>
            
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center">
                    <!-- Protocol Description -->
                    <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-3xl p-8 lg:p-10">
                        @if(App::getLocale() == 'ar')
                            <h2 class="text-3xl sm:text-4xl font-serif font-bold text-white mb-6">
                                <span class="bg-gradient-to-r from-emerald-400 to-blue-400 bg-clip-text text-transparent">{{ __('frontend/hIT.Protocol') }}</span>
                                <span class="text-white">{{ __('frontend/hIT.The') }} {{ __('frontend/hIT.Therapy') }}</span>
                            </h2>
                            <h2 class="text-3xl sm:text-4xl font-serif font-bold text-white mb-6">
                                <span class="text-white">{{ __('frontend/hIT.Sound') }}</span>
                                <span class="bg-gradient-to-r from-blue-400 to-emerald-400 bg-clip-text text-transparent">{{ __('frontend/hIT.U-Shaped') }}</span>
                            </h2>
                        @elseif(App::getLocale() == 'fr')
                            <h2 class="text-3xl sm:text-4xl font-serif font-bold text-white mb-6">
                                <span class="text-white">{{ __('frontend/hIT.The') }}</span>
                                <span class="bg-gradient-to-r from-emerald-400 to-blue-400 bg-clip-text text-transparent">{{ __('frontend/hIT.Protocol') }}</span>
                                <span class="text-white">{{ __('frontend/hIT.Therapy') }}</span>
                            </h2>
                            <h2 class="text-3xl sm:text-4xl font-serif font-bold text-white mb-6">
                                <span class="text-white">{{ __('frontend/hIT.Sound') }}</span>
                                <span class="bg-gradient-to-r from-blue-400 to-emerald-400 bg-clip-text text-transparent">{{ __('frontend/hIT.U-Shaped') }}</span>
                            </h2>
                        @else
                            <h2 class="text-3xl sm:text-4xl font-serif font-bold text-white mb-6">
                                <span class="text-white">{{ __('frontend/hIT.The') }}</span>
                                <span class="bg-gradient-to-r from-emerald-400 to-blue-400 bg-clip-text text-transparent">{{ __('frontend/hIT.U-Shaped') }}</span>
                                <span class="text-white">{{ __('frontend/hIT.Sound') }}</span>
                            </h2>
                            <h2 class="text-3xl sm:text-4xl font-serif font-bold text-white mb-6">
                                <span class="text-white">{{ __('frontend/hIT.Therapy') }}</span>
                                <span class="bg-gradient-to-r from-blue-400 to-emerald-400 bg-clip-text text-transparent">{{ __('frontend/hIT.Protocol') }}</span>
                            </h2>
                        @endif

                        <p class="text-xl text-slate-300 mb-6">{{ __('frontend/hIT.How U-Shaped Sound Transforms Lives') }}</p>
                        <p class="text-lg text-slate-400 leading-relaxed mb-8">{{ __('frontend/hIT.U-Shaped-description') }}</p>
                    </div>
                    
                    <!-- AI Replication Card -->
                    <div class="flex justify-center">
                        <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-3xl p-8 lg:p-10 text-center">
                            <div class="w-20 h-20 bg-gradient-to-r from-emerald-500 to-blue-500 rounded-full flex items-center justify-center mx-auto mb-6">
                                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                                </svg>
                            </div>
                            <p class="text-lg text-slate-300 leading-relaxed">{{ __('frontend/hIT.SAMAA’s AI replicates the U-shaped technique validated in European clinical studies') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- 4-Step Process Section -->
        <section class="py-16 sm:py-20 lg:py-24 relative" data-animate="fade-in-up" data-delay="600">
            <!-- Elegant Separator -->
            <div class="absolute top-0 left-1/2 transform -translate-x-1/2 w-32 h-px bg-gradient-to-r from-transparent via-blue-400 to-transparent"></div>
            
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Section Header -->
                <div class="text-center mb-16">
                    <h2 class="text-3xl sm:text-4xl lg:text-5xl font-serif font-bold text-white mb-6">
                        <span class="bg-gradient-to-r from-blue-400 to-emerald-400 bg-clip-text text-transparent">
                            {{ __('frontend/hIT.The 4-Step Process') }}
                        </span>
                    </h2>
                    <div class="flex justify-center">
                        <div class="w-24 h-px bg-gradient-to-r from-transparent via-emerald-400 to-transparent"></div>
                    </div>
                </div>

                <div class="grid lg:grid-cols-2 gap-12 lg:gap-16 items-start">
                    <!-- Steps Content -->
                    <div class="space-y-8">
                        <!-- Step 1 -->
                        <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-3xl p-8">
                            <div class="flex items-start">
                                <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-teal-500 rounded-full flex items-center justify-center mr-6 flex-shrink-0">
                                    <span class="text-white font-bold text-lg">1</span>
                                </div>
                                <div>
                                    <h4 class="text-xl font-serif font-bold text-white mb-4">{{ __('frontend/hIT.Personalized Profile Setup') }}</h4>
                                    <div class="space-y-3 text-slate-300">
                                        <p class="flex items-start">
                                            <span class="w-2 h-2 bg-blue-400 rounded-full mt-2 mr-3 flex-shrink-0"></span>
                                            {{ __('frontend/hIT.Tell Us About Your Needs (Age, Condition, Goals). SAMAA Respects Privacy—No Medical Data Is Stored Without Consent.') }}
                                        </p>
                                        <p class="flex items-start italic text-blue-300">
                                            <span class="w-2 h-2 bg-blue-400 rounded-full mt-2 mr-3 flex-shrink-0"></span>
                                            <em>{{ __('frontend/hIT.Dr-Nadia’s Quote: "Just As Every Patient Is Unique, So Is Their Path To Healing."') }}</em>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Step 2 -->
                        <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-3xl p-8">
                            <div class="flex items-start">
                                <div class="w-12 h-12 bg-gradient-to-r from-emerald-500 to-blue-500 rounded-full flex items-center justify-center mr-6 flex-shrink-0">
                                    <span class="text-white font-bold text-lg">2</span>
                                </div>
                                <div>
                                    <h4 class="text-xl font-serif font-bold text-white mb-4">{{ __('frontend/hIT.AI-Driven Customization') }}</h4>
                                    <div class="space-y-3 text-slate-300">
                                        <p class="flex items-start">
                                            <span class="w-2 h-2 bg-emerald-400 rounded-full mt-2 mr-3 flex-shrink-0"></span>
                                            {{ __('frontend/hIT.SAMAA’s AI Crafts A U-Shaped Sound Journey Tailored To Your Profile.') }}
                                        </p>
                                        <p class="flex items-start">
                                            <span class="w-2 h-2 bg-emerald-400 rounded-full mt-2 mr-3 flex-shrink-0"></span>
                                            {{ __('frontend/hIT.Clinicals Backing: European Studies Show U-Shaped Therapy Improves Emotional Regulation In 60% Of Autism Cases.') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Step 3 -->
                        <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-3xl p-8">
                            <div class="flex items-start">
                                <div class="w-12 h-12 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full flex items-center justify-center mr-6 flex-shrink-0">
                                    <span class="text-white font-bold text-lg">3</span>
                                </div>
                                <div>
                                    <h4 class="text-xl font-serif font-bold text-white mb-4">{{ __('frontend/hIT.Real-Time Adjustments') }}</h4>
                                    <div class="space-y-3 text-slate-300">
                                        <p class="flex items-start">
                                            <span class="w-2 h-2 bg-purple-400 rounded-full mt-2 mr-3 flex-shrink-0"></span>
                                            {{ __('frontend/hIT.SAMAA Adapts Tempo/Pitch Mid-Session Using Machine Learning.') }}
                                        </p>
                                        <p class="flex items-start">
                                            <span class="w-2 h-2 bg-purple-400 rounded-full mt-2 mr-3 flex-shrink-0"></span>
                                            {{ __('frontend/hIT.Tech Proof: Powered By Clinicouris AI. Recognized At The Go Global Awards 2022.') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Step 4 -->
                        <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-3xl p-8">
                            <div class="flex items-start">
                                <div class="w-12 h-12 bg-gradient-to-r from-teal-500 to-emerald-500 rounded-full flex items-center justify-center mr-6 flex-shrink-0">
                                    <span class="text-white font-bold text-lg">4</span>
                                </div>
                                <div>
                                    <h4 class="text-xl font-serif font-bold text-white mb-4">{{ __('frontend/hIT.Progress Tracking') }}</h4>
                                    <div class="space-y-3 text-slate-300">
                                        <p class="flex items-start">
                                            <span class="w-2 h-2 bg-teal-400 rounded-full mt-2 mr-3 flex-shrink-0"></span>
                                            {{ __('frontend/hIT.Monthly Reports Track Improvements In Focus, Behavior, And Sensory Responses Against Clinical Benchmarks.') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Visual Side -->
                    <div class="flex justify-center">
                        <div class="relative group">
                            <div class="absolute inset-0 bg-gradient-to-r from-blue-600 to-emerald-600 rounded-3xl blur-xl opacity-30 group-hover:opacity-50 transition-opacity duration-500"></div>
                            <div class="relative bg-white/10 backdrop-blur-sm border border-white/20 rounded-3xl p-8 lg:p-10">
                                @if(App::getLocale() == 'ar')
                                    <img src="{{ asset('assets/images/headphones-how-work-ar.png') }}" 
                                         alt="SAMAA Headphones - Arabic" 
                                         class="w-full max-w-md h-auto object-contain filter drop-shadow-2xl" 
                                         loading="lazy">
                                @else
                                    <img src="{{ asset('assets/images/headphones-how-work.png') }}" 
                                         alt="SAMAA Headphones" 
                                         class="w-full max-w-md h-auto object-contain filter drop-shadow-2xl" 
                                         loading="lazy">
                                @endif
                                
                                <!-- Floating Icons -->
                                <div class="absolute top-14 left-20 w-8 h-8 bg-blue-400/20 rounded-full flex items-center justify-center animate-pulse">
                                    <img src="{{ asset('assets/images/icons/Statistics.svg') }}" alt="Statistics" class="w-5 h-5">
                                </div>
                                <div class="absolute top-34 left-6 w-8 h-8 bg-emerald-400/20 rounded-full flex items-center justify-center animate-pulse delay-1000">
                                    <img src="{{ asset('assets/images/icons/Musical note.svg') }}" alt="Music" class="w-5 h-5">
                                </div>
                                <div class="absolute top-58 left-20 w-8 h-8 bg-purple-400/20 rounded-full flex items-center justify-center animate-pulse delay-2000">
                                    <img src="{{ asset('assets/images/icons/Brain.svg') }}" alt="Brain" class="w-5 h-5">
                                </div>
                                <div class="absolute top-78 left-100 w-8 h-8 bg-teal-400/20 rounded-full flex items-center justify-center animate-pulse delay-3000">
                                    <img src="{{ asset('assets/images/icons/Notes.svg') }}" alt="Notes" class="w-5 h-5">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Clinical Proof & Recognition Section -->
        <section class="py-16 sm:py-20 lg:py-24 relative" data-animate="fade-in-up" data-delay="800">
            <!-- Elegant Separator -->
            <div class="absolute top-0 left-1/2 transform -translate-x-1/2 w-32 h-px bg-gradient-to-r from-transparent via-emerald-400 to-transparent"></div>
            
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Section Header -->
                <div class="text-center mb-16">
                    <h2 class="text-3xl sm:text-4xl lg:text-5xl font-serif font-bold text-white mb-6">
                        <span class="bg-gradient-to-r from-emerald-400 to-blue-400 bg-clip-text text-transparent">{{ __('frontend/hIT.Clinical') }}</span>
                        <span class="text-white">{{ __('frontend/hIT.Proof') }} &</span>
                        <span class="bg-gradient-to-r from-blue-400 to-emerald-400 bg-clip-text text-transparent block">{{ __('frontend/hIT.Global Recognition') }}</span>
                    </h2>
                    <p class="text-xl text-slate-300 mb-8">{{ __('frontend/hIT.Proven Impact on Autism & Beyond') }}</p>
                    <div class="flex justify-center">
                        <div class="w-24 h-px bg-gradient-to-r from-transparent via-emerald-400 to-transparent"></div>
                    </div>
                </div>

                <div class="grid lg:grid-cols-2 gap-12 lg:gap-16">
                    <!-- Trial Results -->
                    <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-3xl p-8 lg:p-10">
                        <h3 class="text-2xl sm:text-3xl font-serif font-bold text-white mb-8 text-center">
                            <span class="bg-gradient-to-r from-emerald-400 to-blue-400 bg-clip-text text-transparent">
                                {{ __('frontend/hIT.Month Trial Results') }}
                            </span>
                        </h3>
                        
                        <div class="space-y-6">
                            <div class="bg-white/5 rounded-2xl p-6 border border-white/10">
                                <div class="flex items-center mb-4">
                                    <div class="w-12 h-12 bg-gradient-to-r from-emerald-500 to-blue-500 rounded-full flex items-center justify-center mr-4">
                                        <span class="text-white font-bold text-lg">70%</span>
                                    </div>
                                    <p class="text-lg text-slate-300">{{ __('frontend/hIT.improved sensory processing.') }}</p>
                                </div>
                            </div>
                            
                            <div class="bg-white/5 rounded-2xl p-6 border border-white/10">
                                <div class="flex items-center mb-4">
                                    <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-teal-500 rounded-full flex items-center justify-center mr-4">
                                        <span class="text-white font-bold text-lg">65%</span>
                                    </div>
                                    <p class="text-lg text-slate-300">{{ __('frontend/hIT.reduced anxiety/emotional outbursts.') }}</p>
                                </div>
                            </div>
                            
                            <div class="bg-white/5 rounded-2xl p-6 border border-white/10">
                                <div class="flex items-center mb-4">
                                    <div class="w-12 h-12 bg-gradient-to-r from-teal-500 to-emerald-500 rounded-full flex items-center justify-center mr-4">
                                        <span class="text-white font-bold text-lg">80%</span>
                                    </div>
                                    <p class="text-lg text-slate-300">{{ __('frontend/hIT.better sleep quality reported by parents.') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Partners & Awards -->
                    <div class="space-y-8">
                        <!-- Partners -->
                        <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-3xl p-8 lg:p-10">
                            <h3 class="text-2xl sm:text-3xl font-serif font-bold text-white mb-6 text-center">
                                <span class="bg-gradient-to-r from-blue-400 to-emerald-400 bg-clip-text text-transparent">
                                    {{ __('frontend/hIT.Partners') }}
                                </span>
                            </h3>
                            
                            <div class="space-y-4">
                                <div class="bg-white/5 rounded-2xl p-4 border border-white/10 hover:border-blue-400/30 transition-colors duration-300">
                                    <p class="text-white font-medium text-center">{{ __('frontend/hIT.Dubai Autism Center') }}</p>
                                </div>
                                <div class="bg-white/5 rounded-2xl p-4 border border-white/10 hover:border-blue-400/30 transition-colors duration-300">
                                    <p class="text-white font-medium text-center">{{ __('frontend/hIT.Hope MCF Foundation') }}</p>
                                </div>
                                <div class="bg-white/5 rounded-2xl p-4 border border-white/10 hover:border-blue-400/30 transition-colors duration-300">
                                    <p class="text-white font-medium text-center">{{ __('frontend/hIT.NAAN Women’s Empowerment') }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Awards -->
                        <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-3xl p-8 lg:p-10">
                            <h3 class="text-2xl sm:text-3xl font-serif font-bold text-white mb-6 text-center">
                                <span class="bg-gradient-to-r from-emerald-400 to-blue-400 bg-clip-text text-transparent">
                                    {{ __('frontend/hIT.Awards') }}
                                </span>
                            </h3>
                            
                            <div class="bg-white/5 rounded-2xl p-6 border border-white/10 hover:border-emerald-400/30 transition-colors duration-300">
                                <div class="flex items-center">
                                    <div class="w-12 h-12 bg-gradient-to-r from-emerald-500 to-blue-500 rounded-full flex items-center justify-center mr-4">
                                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="text-lg font-semibold text-white mb-2">{{ __('frontend/hIT.Go Global Award 2022') }}</h4>
                                        <p class="text-slate-300">{{ __('frontend/hIT.Corporate Social Responsibility') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Final CTA Section -->
        <section class="py-16 sm:py-20 lg:py-24 relative" data-animate="fade-in-up" data-delay="1000">
            <!-- Elegant Separator -->
            <div class="absolute top-0 left-1/2 transform -translate-x-1/2 w-32 h-px bg-gradient-to-r from-transparent via-blue-400 to-transparent"></div>
            
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-3xl p-8 lg:p-12">
                    <h2 class="text-3xl sm:text-4xl lg:text-5xl font-serif font-bold text-white mb-6">
                        <span class="text-white">{{ __('frontend/hIT.Ready to Experience') }}</span>
                        <span class="bg-gradient-to-r from-blue-400 to-emerald-400 bg-clip-text text-transparent block">
                            {{ __('frontend/hIT.Healing Through') }} <span class="text-white">{{ __('frontend/hIT.sound?') }}</span>
                        </span>
                    </h2>
                    
                    <p class="text-lg text-slate-400 mb-8 leading-relaxed">
                        {{ __('frontend/hIT.SAMAA adheres to GDPR and global privacy standards. Your data is never shared without consent') }}
                    </p>

                    <!-- Final CTA Buttons -->
                    <div class="flex flex-col sm:flex-row gap-6 justify-center items-center mb-8">
                        <a href="{{ route('login') }}" 
                           class="group px-8 py-4 bg-gradient-to-r from-blue-600 to-emerald-600 text-white font-semibold rounded-2xl text-lg hover:from-blue-700 hover:to-emerald-700 transform hover:scale-105 transition-all duration-300 shadow-xl hover:shadow-2xl hover:shadow-emerald-500/25">
                            <span class="flex items-center">
                                @if(App::getLocale() == 'ar')
                                    <svg class="w-5 h-5 mr-2 group-hover:-translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12"></path>
                                    </svg>
                                @endif
                                {{ __('frontend/hIT.Join Our Waitlist') }}
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
                                {{ __('frontend/hIT.Partner With SAMAA') }}
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

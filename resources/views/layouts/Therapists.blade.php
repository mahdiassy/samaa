@extends('layouts.base')
@section('content')
    <main id="main-content" class="min-h-screen bg-gradient-to-br from-slate-900 via-blue-900 to-slate-800">
        
        <!-- Hero Section: Empowering Therapists -->
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
                    @if(App::getLocale() == 'ar')
                        <h1 class="text-4xl sm:text-5xl lg:text-6xl xl:text-7xl font-serif font-bold mb-8 leading-tight">
                            <span class="text-white">{{ __('therapists.Empowering') }}</span>
                            <br>
                            <span class="bg-gradient-to-r from-orange-400 to-red-400 bg-clip-text text-transparent line-through decoration-4 decoration-orange-400">
                                {{ __('therapists.therapists') }}
                            </span>
                            <span class="text-white">{{ __('therapists.with') }} {{ __('therapists.therapy') }}</span>
                            <span class="bg-gradient-to-r from-blue-400 via-teal-400 to-emerald-400 bg-clip-text text-transparent">
                                {{ __('therapists.Sound') }}
                            </span>
                            <span class="text-white">{{ __('therapists.AI-Driven') }}</span>
                        </h1>
                    @elseif(App::getLocale() == 'fr')
                        <h1 class="text-4xl sm:text-5xl lg:text-6xl xl:text-7xl font-serif font-bold mb-8 leading-tight">
                            <span class="text-white">{{ __('therapists.Empowering') }}</span>
                            <br>
                            <span class="bg-gradient-to-r from-orange-400 to-red-400 bg-clip-text text-transparent line-through decoration-4 decoration-orange-400">
                                {{ __('therapists.therapists') }}
                            </span>
                            <span class="text-white">{{ __('therapists.with') }} {{ __('therapists.therapy') }}</span>
                            <span class="bg-gradient-to-r from-blue-400 via-teal-400 to-emerald-400 bg-clip-text text-transparent">
                                {{ __('therapists.Sound') }}
                            </span>
                            <span class="text-white">{{ __('therapists.AI-Driven') }}</span>
                        </h1>
                    @else
                        <h1 class="text-4xl sm:text-5xl lg:text-6xl xl:text-7xl font-serif font-bold mb-8 leading-tight">
                            <span class="text-white">{{ __('therapists.Empowering') }}</span>
                            <br>
                            <span class="bg-gradient-to-r from-orange-400 to-red-400 bg-clip-text text-transparent line-through decoration-4 decoration-orange-400">
                                {{ __('therapists.therapists') }}
                            </span>
                            <span class="text-white">{{ __('therapists.with') }} {{ __('therapists.AI-Driven') }}</span>
                            <span class="bg-gradient-to-r from-blue-400 via-teal-400 to-emerald-400 bg-clip-text text-transparent">
                                {{ __('therapists.Sound') }}
                    </span>
                            <span class="text-white">{{ __('therapists.therapy') }}</span>
                </h1>
                    @endif
            </div>
        </div>
    </section>

        <!-- Revolution in Music Therapy Section -->
        <section class="py-16 sm:py-20 lg:py-24 relative" data-animate="fade-in-up" data-delay="200">
            <!-- Elegant Separator -->
            <div class="absolute top-0 left-1/2 transform -translate-x-1/2 w-32 h-px bg-gradient-to-r from-transparent via-blue-400 to-transparent"></div>
            
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center">
                    <!-- Left Content -->
                    <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-3xl p-8 lg:p-10">
                        @if(App::getLocale() == 'ar')
                            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-serif font-bold text-white mb-6">
                                {{ __('therapists.Join A') }}<br>
                                <strong class="text-white">{{ __('therapists.Revolution In') }} {{ __('therapists.therapy') }}</strong>
                                <span class="bg-gradient-to-r from-emerald-400 to-blue-400 bg-clip-text text-transparent">{{ __('therapists.Music') }}</span>
                            </h2>
                            <p class="text-lg text-slate-300 leading-relaxed mb-8">
                                {{ __('therapists.SAMAA equips therapists and institutions with AI tools to enhance traditional practices, backed by') }}
                                {{ __('therapists.groundbreaking research.') }} <strong class="text-orange-400">{{ __('therapists.Dr. Nadia Cheaib') }}</strong>
                            </p>
                        @elseif(App::getLocale() == 'fr')
                            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-serif font-bold text-white mb-6">
                                {{ __('therapists.Join A') }}<br>
                                <strong class="text-white">{{ __('therapists.Revolution In') }}</strong>
                                <span class="bg-gradient-to-r from-emerald-400 to-blue-400 bg-clip-text text-transparent">{{ __('therapists.Music') }}</span>
                            </h2>
                            <p class="text-lg text-slate-300 leading-relaxed mb-8">
                                {{ __('therapists.SAMAA equips therapists and institutions with AI tools to enhance traditional practices, backed by') }}
                                {{ __('therapists.groundbreaking research.') }} <strong class="text-orange-400">{{ __('therapists.Dr. Nadia Cheaib') }}</strong>
                            </p>
                        @else
                            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-serif font-bold text-white mb-6">
                                {{ __('therapists.Join A') }}<br>
                                <strong class="text-white">{{ __('therapists.Revolution In') }}</strong>
                                <span class="bg-gradient-to-r from-emerald-400 to-blue-400 bg-clip-text text-transparent">{{ __('therapists.Music') }}</span>
                                <span class="text-white">{{ __('therapists.therapy') }}</span>
                            </h2>
                            <p class="text-lg text-slate-300 leading-relaxed mb-8">
                                {{ __('therapists.SAMAA equips therapists and institutions with AI tools to enhance traditional practices, backed by') }}
                                <strong class="text-orange-400">{{ __('therapists.Dr. Nadia Cheaib') }}</strong> {{ __('therapists.groundbreaking research.') }}
                            </p>
                        @endif
                        
                        <div class="flex flex-wrap gap-4">
                            <div class="bg-white/10 rounded-2xl px-4 py-2 border border-white/20">
                                <span class="text-slate-300 text-sm">{{ __('therapists.Endorsed By The American European Music Therapy Association.') }}</span>
                            </div>
                            <div class="bg-white/10 rounded-2xl px-4 py-2 border border-white/20">
                                <span class="text-slate-300 text-sm">{{ __('therapists.Clinically Validated In Autism Studie') }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Right Image & Quote -->
                    <div class="flex justify-center">
                        <div class="relative group">
                            <div class="absolute inset-0 bg-gradient-to-r from-emerald-600 to-blue-600 rounded-3xl blur-xl opacity-30 group-hover:opacity-50 transition-opacity duration-500"></div>
                            <div class="relative bg-white/10 backdrop-blur-sm border border-white/20 rounded-3xl p-8 lg:p-10">
                                <img src="{{ asset('assets/images/revolution.png') }}" 
                                     alt="Music Therapy Revolution" 
                                     class="w-full max-w-md h-auto object-contain filter drop-shadow-2xl mb-6" 
                                     loading="lazy">
                                
                                <div class="bg-white/10 rounded-2xl p-6 border border-white/20">
                                    <p class="text-lg text-slate-300 italic mb-4">
                                        <em>{{ __('therapists.Therapists Are The Heart Of Healing') }} <strong class="text-white">SAMAA</strong> {{ __('therapists.Is Here To Amplify Your Impact.') }}</em>
                                    </p>
                                    <p class="text-sm text-slate-400">{{ __('therapists.Dr. Nadia’s') }}</p>
                        </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

        <!-- Benefits for Therapists Section -->
        <section class="py-16 sm:py-20 lg:py-24 relative" data-animate="fade-in-up" data-delay="400">
            <!-- Elegant Separator -->
            <div class="absolute top-0 left-1/2 transform -translate-x-1/2 w-32 h-px bg-gradient-to-r from-transparent via-emerald-400 to-transparent"></div>
            
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Section Header -->
                <div class="text-center mb-16">
                    <h2 class="text-3xl sm:text-4xl lg:text-5xl font-serif font-bold text-white mb-6">
                        {{ __('therapists.Benefits for') }} <span class="bg-gradient-to-r from-emerald-400 to-blue-400 bg-clip-text text-transparent">{{ __('therapists.Therapists') }}</span>
                    </h2>
                    <p class="text-xl text-slate-300 mb-8">{{ __('therapists.Why Partner with SAMAA?') }}</p>
                    <div class="flex justify-center">
                        <div class="w-24 h-px bg-gradient-to-r from-transparent via-emerald-400 to-transparent"></div>
                    </div>
                </div>
                
                <!-- Benefits Grid -->
                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                    <!-- AI-Powered Tools -->
                    <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-3xl p-8 text-center group hover:border-emerald-400/30 transition-all duration-300">
                        <div class="w-16 h-16 bg-gradient-to-r from-emerald-500 to-blue-500 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                            <img src="{{ asset('assets/images/icons/Music.svg') }}" alt="Music" class="w-8 h-8">
                        </div>
                        <h3 class="text-xl font-serif font-bold text-white mb-4">{{ __('therapists.AI-Powered Tools:') }}</h3>
                        <p class="text-slate-300 leading-relaxed">
                            {{ __('therapists.Customize sessions using U-shaped sound therapy protocols, adapted in real-time for each patient.') }}
                        </p>
                    </div>

                    <!-- Progress Tracking -->
                    <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-3xl p-8 text-center group hover:border-blue-400/30 transition-all duration-300">
                        <div class="w-16 h-16 bg-gradient-to-r from-blue-500 to-teal-500 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                            <img src="{{ asset('assets/images/icons/Bar graph.svg') }}" alt="Progress" class="w-8 h-8">
                        </div>
                        <h3 class="text-xl font-serif font-bold text-white mb-4">{{ __('therapists.Progress Tracking:') }}</h3>
                        <p class="text-slate-300 leading-relaxed">
                            {{ __('therapists.Access dashboards to monitor behavioral improvements, sleep patterns, and sensory responses.') }}
                    </p>
                </div>
                
                    <!-- Global Collaboration -->
                    <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-3xl p-8 text-center group hover:border-teal-400/30 transition-all duration-300">
                        <div class="w-16 h-16 bg-gradient-to-r from-teal-500 to-emerald-500 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                            <img src="{{ asset('assets/images/icons/Global.svg') }}" alt="Global" class="w-8 h-8">
                        </div>
                        <h3 class="text-xl font-serif font-bold text-white mb-4">{{ __('therapists.Global Collaboration:') }}</h3>
                        <p class="text-slate-300 leading-relaxed">
                            {{ __('therapists.Join a network of therapists and institutions pioneering ethical, tech-driven care') }}
                        </p>
                    </div>

                    <!-- Training & Support -->
                    <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-3xl p-8 text-center group hover:border-purple-400/30 transition-all duration-300">
                        <div class="w-16 h-16 bg-gradient-to-r from-purple-500 to-pink-500 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                            <img src="{{ asset('assets/images/icons/Brain-vector.svg') }}" alt="Brain" class="w-8 h-8">
                        </div>
                        <h3 class="text-xl font-serif font-bold text-white mb-4">{{ __('therapists.Training & Support:') }}</h3>
                        <p class="text-slate-300 leading-relaxed">
                            {{ __('therapists.Free onboarding and access to SAMAA\'s research library') }}
                    </p>
                </div>
            </div>
        </div>
    </section>

        <!-- SAMAA for Organizations Section -->
        <section class="py-16 sm:py-20 lg:py-24 relative" data-animate="fade-in-up" data-delay="600">
            <!-- Elegant Separator -->
            <div class="absolute top-0 left-1/2 transform -translate-x-1/2 w-32 h-px bg-gradient-to-r from-transparent via-blue-400 to-transparent"></div>
            
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center">
                    <!-- Organizations Content -->
                    <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-3xl p-8 lg:p-10">
                        <h2 class="text-3xl sm:text-4xl font-serif font-bold text-white mb-8">
                            <span class="bg-gradient-to-r from-emerald-400 to-blue-400 bg-clip-text text-transparent">{{ __('therapists.Sama\'a') }}</span>
                            <span class="text-white">{{ __('therapists.for Organizations') }}</span>
                        </h2>
                        
                        <div class="space-y-6">
                            <div class="flex items-start">
                                <div class="w-4 h-4 bg-emerald-400 rounded-full mt-2 mr-4 flex-shrink-0"></div>
                                <div>
                                    <h3 class="text-lg font-bold text-white mb-2">{{ __('therapists.Tailored Programs:') }}</h3>
                                    <p class="text-slate-300">{{ __('therapists.Integrate SAMAA into your wellness initiatives for autism, anxiety, or chronic pain.') }}</p>
                                </div>
                        </div>
                            
                            <div class="flex items-start">
                                <div class="w-4 h-4 bg-blue-400 rounded-full mt-2 mr-4 flex-shrink-0"></div>
                        <div>
                                    <h3 class="text-lg font-bold text-white mb-2">{{ __('therapists.Data-Driven Insights:') }}</h3>
                                    <p class="text-slate-300">{{ __('therapists.Receive aggregated reports to measure program efficacy and secure funding') }}</p>
                        </div>
                    </div>
                    
                            <div class="flex items-start">
                                <div class="w-4 h-4 bg-teal-400 rounded-full mt-2 mr-4 flex-shrink-0"></div>
                                <div>
                                    <h3 class="text-lg font-bold text-white mb-2">{{ __('therapists.Ethical Mission:') }}</h3>
                                    <p class="text-slate-300">{{ __('therapists.Align with Dr. Nadia Cheaib\'s vision: 10% of SAMAA\'s profits fund therapy for underserved communities.') }}</p>
                                </div>
                        </div>
                        </div>
                    </div>
                    
                    <!-- Organizations Image -->
                    <div class="flex justify-center">
                        <div class="relative group">
                            <div class="absolute inset-0 bg-gradient-to-r from-emerald-600 to-blue-600 rounded-3xl blur-xl opacity-30 group-hover:opacity-50 transition-opacity duration-500"></div>
                            <div class="relative bg-white/10 backdrop-blur-sm border border-white/20 rounded-3xl p-8 lg:p-10">
                                <img src="{{ asset('assets/images/therapists-section1.png') }}" 
                                     alt="SAMAA for Organizations" 
                                     class="w-full max-w-sm h-auto object-cover rounded-2xl filter drop-shadow-2xl" 
                                     loading="lazy">
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- 3 Steps Process Section -->
        <section class="py-16 sm:py-20 lg:py-24 relative" data-animate="fade-in-up" data-delay="800">
            <!-- Elegant Separator -->
            <div class="absolute top-0 left-1/2 transform -translate-x-1/2 w-32 h-px bg-gradient-to-r from-transparent via-emerald-400 to-transparent"></div>
            
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Section Header -->
                <div class="text-center mb-16">
                    <h2 class="text-3xl sm:text-4xl lg:text-5xl font-serif font-bold text-white mb-6">
                        {{ __('therapists.Get Started In') }} <span class="bg-gradient-to-r from-emerald-400 to-blue-400 bg-clip-text text-transparent">{{ __('therapists.3 Steps') }}</span>
                    </h2>
                    <div class="flex justify-center">
                        <div class="w-24 h-px bg-gradient-to-r from-transparent via-emerald-400 to-transparent"></div>
                    </div>
                </div>

                <!-- Steps Container -->
                <div class="grid md:grid-cols-3 gap-8">
                    <!-- Step 1 -->
                    <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-3xl p-8 text-center group hover:border-blue-400/30 transition-all duration-300">
                        <div class="w-16 h-16 bg-gradient-to-r from-blue-500 to-teal-500 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                            <span class="text-white font-bold text-2xl">1</span>
                        </div>
                        <h3 class="text-xl font-serif font-bold text-white mb-4">{{ __('therapists.Apply') }}</h3>
                        <p class="text-slate-300">{{ __('therapists.Fill Out A Short Form.') }}</p>
                        </div>
                        
                    <!-- Step 2 -->
                    <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-3xl p-8 text-center group hover:border-emerald-400/30 transition-all duration-300">
                        <div class="w-16 h-16 bg-gradient-to-r from-emerald-500 to-blue-500 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                            <span class="text-white font-bold text-2xl">2</span>
                        </div>
                        <h3 class="text-xl font-serif font-bold text-white mb-4">{{ __('therapists.Onboard') }}</h3>
                        <p class="text-slate-300">{{ __('therapists.Attend A 30-Minute Training Webinar.') }}</p>
                        </div>
                        
                    <!-- Step 3 -->
                    <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-3xl p-8 text-center group hover:border-teal-400/30 transition-all duration-300">
                        <div class="w-16 h-16 bg-gradient-to-r from-teal-500 to-emerald-500 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                            <span class="text-white font-bold text-2xl">3</span>
                        </div>
                        <h3 class="text-xl font-serif font-bold text-white mb-4">{{ __('therapists.Launch') }}</h3>
                        <p class="text-slate-300">{{ __('therapists.Access SAMAA\'s Portal And Start Healing') }}</p>
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
                        <span class="bg-gradient-to-r from-emerald-400 to-blue-400 bg-clip-text text-transparent">{{ __('therapists.Join') }}</span>
                        <span class="text-white">{{ __('therapists.therapistss') }}</span>
                        <br>
                        <span class="text-white">{{ __('therapists.Transforming') }}</span>
                        <span class="bg-gradient-to-r from-blue-400 to-emerald-400 bg-clip-text text-transparent">{{ __('therapists.Lives') }}</span>
                    </h2>
                    
                    <p class="text-lg text-slate-400 mb-8 leading-relaxed">
                        {{ __('therapists.SAMAA complies with HIPAA/GDPR. Patient data is fully encrypted.') }}
                    </p>

                    <!-- CTA Buttons -->
                    <div class="flex flex-col sm:flex-row gap-6 justify-center items-center mb-8">
                        <a href="{{ route('login') }}" 
                           class="group px-8 py-4 bg-gradient-to-r from-blue-600 to-emerald-600 text-white font-semibold rounded-2xl text-lg hover:from-blue-700 hover:to-emerald-700 transform hover:scale-105 transition-all duration-300 shadow-xl hover:shadow-2xl hover:shadow-emerald-500/25">
                            <span class="flex items-center">
                                {{ __('therapists.Join Our Wait List') }}
                                <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                </svg>
                            </span>
                        </a>
                        
                        <a href="{{ route('contact-us') }}" 
                           class="group px-8 py-4 bg-white/10 backdrop-blur-sm border border-white/20 text-white font-semibold rounded-2xl text-lg hover:bg-white/20 hover:border-white/30 transform hover:scale-105 transition-all duration-300">
                            <span class="flex items-center">
                                {{ __('therapists.Partner With SAMAA') }}
                                <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                </svg>
                            </span>
                        </a>
                        </div>
                        
                    <p class="text-sm text-slate-500">
                        {{ __('therapists.Inquire About') }} <a href="#" class="text-emerald-400 hover:text-emerald-300 underline">{{ __('therapists.Institutional Partnerships') }}</a>
                    </p>
            </div>
        </div>
    </section>
    </main>
@endsection

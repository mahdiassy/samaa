@extends('layouts.base')
@section('content')
    <section class="hero relative min-h-screen flex items-center justify-center overflow-hidden">
        <!-- Piano Background - Clean and Professional -->
        <div class="absolute inset-0">
            <img src="{{ asset('assets/images/landing-page.png') }}" alt="Piano background" class="w-full h-full object-cover">
            
            <!-- Professional Dark Overlay for Text Clarity -->
            <div class="absolute inset-0 bg-black/60"></div>
            
            <!-- Flying Music Symbols - Dynamic Visual Effects -->
            <div class="absolute inset-0 overflow-hidden pointer-events-none">
                <!-- Flying symbols across screen -->
                <div class="flying-symbol absolute text-yellow-400/40 text-4xl" style="animation: flyAcross 12s linear infinite; animation-delay: 0s;">♪</div>
                <div class="flying-symbol absolute text-pink-400/40 text-5xl" style="animation: flyAcross 15s linear infinite; animation-delay: 2s;">♫</div>
                <div class="flying-symbol absolute text-cyan-400/40 text-3xl" style="animation: flyAcross 18s linear infinite; animation-delay: 4s;">♬</div>
                <div class="flying-symbol absolute text-green-400/40 text-6xl" style="animation: flyAcross 20s linear infinite; animation-delay: 6s;">♩</div>
                <div class="flying-symbol absolute text-purple-400/40 text-4xl" style="animation: flyAcross 14s linear infinite; animation-delay: 8s;">𝄞</div>
                <div class="flying-symbol absolute text-orange-400/40 text-5xl" style="animation: flyAcross 16s linear infinite; animation-delay: 10s;">♪</div>
                
                <!-- Diagonal flying symbols -->
                <div class="flying-diagonal absolute text-blue-400/30 text-3xl" style="animation: flyDiagonal 25s linear infinite; animation-delay: 1s;">♫</div>
                <div class="flying-diagonal absolute text-red-400/30 text-4xl" style="animation: flyDiagonal 22s linear infinite; animation-delay: 5s;">♬</div>
                <div class="flying-diagonal absolute text-emerald-400/30 text-5xl" style="animation: flyDiagonal 28s linear infinite; animation-delay: 9s;">♩</div>
                
                <!-- Spiral flying symbols -->
                <div class="flying-spiral absolute text-violet-400/35 text-3xl" style="animation: flySpiral 30s linear infinite; animation-delay: 3s;">𝄞</div>
                <div class="flying-spiral absolute text-fuchsia-400/35 text-4xl" style="animation: flySpiral 35s linear infinite; animation-delay: 7s;">♪</div>
            </div>
            
            <!-- Particle Burst Effects -->
            <div class="absolute inset-0 overflow-hidden pointer-events-none">
                <!-- Burst from corners -->
                <div class="particle-burst absolute top-0 left-0" id="burst-tl"></div>
                <div class="particle-burst absolute top-0 right-0" id="burst-tr"></div>
                <div class="particle-burst absolute bottom-0 left-0" id="burst-bl"></div>
                <div class="particle-burst absolute bottom-0 right-0" id="burst-br"></div>
            </div>
        </div>

        <!-- Hero Content - Centered Professionally -->
        <div class="relative z-10 text-center max-w-6xl mx-auto px-6 {{ App::getLocale() == 'ar' ? 'text-right' : 'text-center' }}">
            <!-- Welcome Message - Professional -->
            <div class="animate-fade-in-up" style="animation-delay: 0.2s;">
                <h2 class="text-sm md:text-base text-white/70 font-medium mb-8 tracking-widest uppercase">
                    {{ __('home.Welcome to SAMAA') }}
                </h2>
            </div>
            
            <!-- Main Title with Interactive Music Letters - Professional -->
            <div class="animate-fade-in-up" style="animation-delay: 0.4s;">
                @if (App::getLocale() == 'ar')
                    <h1 class="text-5xl md:text-7xl font-elegant font-bold text-white mb-8 leading-tight">
                        صحت<span class="text-accent-400">ك</span> في سمع<span class="text-accent-400">ك</span>
                    </h1>
                @elseif (App::getLocale() == 'fr')
                    <h1 class="text-5xl md:text-7xl font-elegant font-bold text-white mb-8 leading-tight">
                        Écoute<span class="text-accent-400">r</span> pour guéri<span class="text-accent-400">r</span>
                    </h1>
                @else
                    <!-- Professional "Hear to Heal" with Clean Design -->
                    <div class="relative mb-16">
                        <h1 class="text-6xl md:text-8xl font-elegant font-bold leading-tight tracking-wider mb-8">
                            <!-- HEAR -->
                            <span class="inline-block">
                                <span class="music-letter-pro text-red-400 hover:text-red-300 cursor-pointer transform hover:scale-110 transition-all duration-500 relative inline-block mx-1" 
                                      data-sound="note-c" style="text-shadow: 0 0 30px currentColor, 0 4px 8px rgba(0,0,0,0.5);">H</span><span class="music-letter-pro text-orange-400 hover:text-orange-300 cursor-pointer transform hover:scale-110 transition-all duration-500 relative inline-block mx-1" 
                                      data-sound="note-d" style="text-shadow: 0 0 30px currentColor, 0 4px 8px rgba(0,0,0,0.5);">e</span><span class="music-letter-pro text-yellow-400 hover:text-yellow-300 cursor-pointer transform hover:scale-110 transition-all duration-500 relative inline-block mx-1" 
                                      data-sound="note-e" style="text-shadow: 0 0 30px currentColor, 0 4px 8px rgba(0,0,0,0.5);">a</span><span class="music-letter-pro text-emerald-400 hover:text-emerald-300 cursor-pointer transform hover:scale-110 transition-all duration-500 relative inline-block mx-1" 
                                      data-sound="note-f" style="text-shadow: 0 0 30px currentColor, 0 4px 8px rgba(0,0,0,0.5);">r</span>
                            </span>
                            <span class="text-white mx-8 font-light" style="text-shadow: 0 4px 8px rgba(0,0,0,0.5);">to</span>
                            <!-- HEAL -->
                            <span class="inline-block">
                                <span class="music-letter-pro text-cyan-400 hover:text-cyan-300 cursor-pointer transform hover:scale-110 transition-all duration-500 relative inline-block mx-1" 
                                      data-sound="note-g" style="text-shadow: 0 0 30px currentColor, 0 4px 8px rgba(0,0,0,0.5);">H</span><span class="music-letter-pro text-blue-400 hover:text-blue-300 cursor-pointer transform hover:scale-110 transition-all duration-500 relative inline-block mx-1" 
                                      data-sound="note-a" style="text-shadow: 0 0 30px currentColor, 0 4px 8px rgba(0,0,0,0.5);">e</span><span class="music-letter-pro text-violet-400 hover:text-violet-300 cursor-pointer transform hover:scale-110 transition-all duration-500 relative inline-block mx-1" 
                                      data-sound="note-b" style="text-shadow: 0 0 30px currentColor, 0 4px 8px rgba(0,0,0,0.5);">a</span><span class="music-letter-pro text-fuchsia-400 hover:text-fuchsia-300 cursor-pointer transform hover:scale-110 transition-all duration-500 relative inline-block mx-1" 
                                      data-sound="note-c2" style="text-shadow: 0 0 30px currentColor, 0 4px 8px rgba(0,0,0,0.5);">l</span>
                            </span>
                    </h1>
                        
                        <!-- Beautiful Floating Music Symbols Under Letters -->
                        <div class="absolute -bottom-16 left-1/2 transform -translate-x-1/2 w-full">
                            <div class="flex items-center justify-center space-x-8">
                                <div class="floating-symbol text-red-400/70 text-2xl" style="animation: gentleFloat 3s ease-in-out infinite; animation-delay: 0s; text-shadow: 0 0 15px currentColor;">♪</div>
                                <div class="floating-symbol text-orange-400/70 text-3xl" style="animation: gentleFloat 3.5s ease-in-out infinite; animation-delay: 0.5s; text-shadow: 0 0 15px currentColor;">♫</div>
                                <div class="floating-symbol text-yellow-400/70 text-2xl" style="animation: gentleFloat 4s ease-in-out infinite; animation-delay: 1s; text-shadow: 0 0 15px currentColor;">♬</div>
                                <div class="floating-symbol text-emerald-400/70 text-3xl" style="animation: gentleFloat 3.2s ease-in-out infinite; animation-delay: 1.5s; text-shadow: 0 0 15px currentColor;">♩</div>
                                <div class="floating-symbol text-cyan-400/70 text-4xl" style="animation: gentleFloat 3.8s ease-in-out infinite; animation-delay: 2s; text-shadow: 0 0 15px currentColor;">𝄞</div>
                                <div class="floating-symbol text-blue-400/70 text-2xl" style="animation: gentleFloat 3.3s ease-in-out infinite; animation-delay: 2.5s; text-shadow: 0 0 15px currentColor;">♪</div>
                                <div class="floating-symbol text-violet-400/70 text-3xl" style="animation: gentleFloat 4.2s ease-in-out infinite; animation-delay: 3s; text-shadow: 0 0 15px currentColor;">♫</div>
                                <div class="floating-symbol text-fuchsia-400/70 text-2xl" style="animation: gentleFloat 3.6s ease-in-out infinite; animation-delay: 3.5s; text-shadow: 0 0 15px currentColor;">♬</div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Professional Description -->
            <div class="animate-fade-in-up" style="animation-delay: 0.6s;">
                <p class="text-lg md:text-xl text-white/90 max-w-4xl mx-auto mb-20 leading-relaxed font-light tracking-wide">
                    {{ __('home.When healthcare professionals educate you using sound to enhance your health and well-being.') }}
                </p>
            </div>
            </div>
            
        <!-- Amazing Learn More Button - Positioned Lower -->
        <div class="absolute bottom-20 left-1/2 transform -translate-x-1/2 z-20">
            <div class="flex justify-center animate-fade-in-up" style="animation-delay: 1s;">
                <a href="{{ route('how-it-work') }}" 
                   class="group relative inline-flex items-center px-10 py-5 text-xl font-bold text-white 
                          bg-gradient-to-r from-accent-500/90 to-accent-600/90 backdrop-blur-lg
                          border-2 border-accent-400/50 hover:border-accent-300/70
                          rounded-3xl shadow-2xl hover:shadow-accent-500/25
                          transform hover:scale-110 hover:-translate-y-2 transition-all duration-500
                          overflow-hidden">
                    <!-- Animated background -->
                    <span class="absolute inset-0 bg-gradient-to-r from-white/10 to-white/5 transform -skew-x-12 -translate-x-full 
                                 group-hover:translate-x-full transition-transform duration-1000 ease-out"></span>
                    <!-- Glowing border effect -->
                    <span class="absolute inset-0 rounded-3xl bg-gradient-to-r from-accent-400 to-accent-500 opacity-0 
                                 group-hover:opacity-20 transition-opacity duration-500 blur-sm"></span>
                    <!-- Button content -->
                    <span class="relative flex items-center">
                        <i class="fas fa-magic mr-4 text-2xl group-hover:rotate-12 transition-transform duration-300"></i>
                        <span class="tracking-wide">{{ __('home.Learn More') }}</span>
                        <i class="fas fa-arrow-right ml-4 text-xl transform group-hover:translate-x-2 group-hover:scale-125 transition-all duration-300"></i>
                    </span>
                </a>
            </div>
            </div>

        <!-- Floating Music Symbols at Very Bottom -->
        <div class="absolute bottom-6 left-1/2 transform -translate-x-1/2 animate-bounce">
            <div class="flex items-center space-x-4 text-white/40">
                <div class="text-2xl animate-pulse" style="animation-delay: 0s;">♪</div>
                <div class="text-3xl animate-pulse" style="animation-delay: 0.5s;">♫</div>
                <div class="text-2xl animate-pulse" style="animation-delay: 1s;">♬</div>
            </div>
        </div>
    </section>

    <!-- Stunning Sound Therapy Section -->
    <section class="relative py-32 bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 overflow-hidden">
        <!-- Dynamic Background Effects -->
        <div class="absolute inset-0">
            <!-- Animated gradient orbs -->
            <div class="absolute top-20 left-20 w-96 h-96 bg-gradient-to-r from-primary-500/20 to-secondary-500/20 rounded-full filter blur-3xl animate-pulse" style="animation-duration: 4s;"></div>
            <div class="absolute bottom-20 right-20 w-80 h-80 bg-gradient-to-r from-accent-500/20 to-pink-500/20 rounded-full filter blur-3xl animate-pulse" style="animation-duration: 6s; animation-delay: 2s;"></div>
            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-64 h-64 bg-gradient-to-r from-cyan-500/15 to-purple-500/15 rounded-full filter blur-3xl animate-pulse" style="animation-duration: 5s; animation-delay: 1s;"></div>
            
            <!-- Floating musical notes -->
            <div class="absolute inset-0 overflow-hidden">
                <div class="absolute top-16 left-16 text-white/10 text-3xl animate-float" style="animation-delay: 0s; animation-duration: 8s;">♪</div>
                <div class="absolute top-32 right-24 text-white/8 text-4xl animate-float" style="animation-delay: 2s; animation-duration: 10s;">♫</div>
                <div class="absolute bottom-24 left-32 text-white/12 text-2xl animate-float" style="animation-delay: 4s; animation-duration: 9s;">♬</div>
                <div class="absolute bottom-16 right-16 text-white/10 text-5xl animate-float" style="animation-delay: 6s; animation-duration: 7s;">𝄞</div>
            </div>
        </div>

        <div class="relative max-w-7xl mx-auto px-6">
            <!-- Stunning Section Header -->
            <div class="text-center mb-24">
                <div class="animate-fade-in-up">
                    <!-- Sound Therapy Title -->
                    <h2 class="text-6xl md:text-7xl font-elegant font-bold mb-8 leading-tight">
                        <span class="bg-gradient-to-r from-cyan-400 via-blue-400 to-purple-400 bg-clip-text text-transparent drop-shadow-lg">
                            {{ __('home.Sound') }}
                        </span> 
                        <span class="text-white drop-shadow-lg">{{ __('home.Therapy') }}</span>
                    </h2>
                    
                    <!-- Beautiful description with better typography -->
                    <div class="max-w-5xl mx-auto">
                        <p class="text-xl md:text-2xl text-gray-300 leading-relaxed mb-16 font-light tracking-wide">
                        {{ __('home.Music therapy is a discipline widely used in the medical field as a therapeutic tool. It can aid physical and emotional rehabilitation of individuals and help develop communication skills and positive relationships with others.') }}
                    </p>
            </div>

                    <!-- How SAMAA Works Title -->
                    <div class="relative inline-block">
                        <h1 class="text-5xl md:text-6xl font-elegant font-bold text-white mb-20 leading-tight">
                    {{ __('home.How') }} 
                            <span class="bg-gradient-to-r from-yellow-400 via-orange-400 to-red-400 bg-clip-text text-transparent">
                                {{ __("home.Sama'a") }}
                    </span> 
                    {{ __('home.Works') }}
                        </h1>
                        
                        <!-- Decorative underline -->
                        <div class="absolute -bottom-4 left-1/2 transform -translate-x-1/2 w-32 h-1 bg-gradient-to-r from-transparent via-accent-400 to-transparent rounded-full"></div>
                    </div>
                </div>
            </div>

        <div class="container max-w-7xl mx-auto px-6">
            <!-- Stunning Feature Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12 lg:gap-16">
                <!-- Card 1: You Share Your Needs -->
                <div class="group animate-fade-in-up" style="animation-delay: 0.3s;">
                    <div class="relative bg-gradient-to-br from-slate-800/80 to-slate-700/80 backdrop-blur-lg 
                               rounded-3xl p-10 shadow-2xl hover:shadow-cyan-500/20
                               transform hover:-translate-y-4 hover:scale-105 transition-all duration-700
                               border border-slate-600/50 hover:border-cyan-400/50
                               overflow-hidden h-full flex flex-col">
                        <!-- Glowing Background -->
                        <div class="absolute inset-0 bg-gradient-to-br from-cyan-500/10 to-blue-500/10 opacity-0 
                                   group-hover:opacity-100 transition-opacity duration-700"></div>
                        
                        <!-- Icon with Glow -->
                        <div class="relative mb-8">
                            <div class="w-24 h-24 mx-auto bg-gradient-to-br from-cyan-500/20 to-blue-500/20 
                                       rounded-3xl flex items-center justify-center
                                       transform group-hover:scale-110 group-hover:rotate-6 transition-all duration-500
                                       shadow-lg group-hover:shadow-cyan-500/30">
                                <img src="{{ asset('assets/images/icons/Brain-icon.svg') }}" 
                                     alt="Share your needs" 
                                     class="w-12 h-12 filter brightness-0 invert group-hover:drop-shadow-lg transition-all duration-300">
                            </div>
                        </div>
                        
                        <!-- Content -->
                        <div class="relative text-center flex-1 flex flex-col">
                            <h3 class="text-2xl md:text-3xl font-bold text-white mb-6 group-hover:text-cyan-300 transition-colors duration-500">
                                {{ __('home.You Share Your Needs') }}
                            </h3>
                        </div>

                        <!-- Floating particles on hover -->
                        <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-700 pointer-events-none">
                            <div class="absolute top-4 right-4 text-cyan-400 text-lg animate-bounce">♪</div>
                            <div class="absolute bottom-4 left-4 text-blue-400 text-sm animate-pulse">♫</div>
                        </div>
                    </div>
                </div>

                <!-- Card 2: SAMAA Creates Personalized Sessions -->
                <div class="group animate-fade-in-up" style="animation-delay: 0.5s;">
                    <div class="relative bg-gradient-to-br from-slate-800/80 to-slate-700/80 backdrop-blur-lg 
                               rounded-3xl p-10 shadow-2xl hover:shadow-purple-500/20
                               transform hover:-translate-y-4 hover:scale-105 transition-all duration-700
                               border border-slate-600/50 hover:border-purple-400/50
                               overflow-hidden h-full flex flex-col">
                        <!-- Glowing Background -->
                        <div class="absolute inset-0 bg-gradient-to-br from-purple-500/10 to-pink-500/10 opacity-0 
                                   group-hover:opacity-100 transition-opacity duration-700"></div>
                        
                        <!-- Icon with Glow -->
                        <div class="relative mb-8">
                            <div class="w-24 h-24 mx-auto bg-gradient-to-br from-purple-500/20 to-pink-500/20 
                                       rounded-3xl flex items-center justify-center
                                       transform group-hover:scale-110 group-hover:rotate-6 transition-all duration-500
                                       shadow-lg group-hover:shadow-purple-500/30">
                                <img src="{{ asset('assets/images/icons/AI.svg') }}" 
                                     alt="AI creates personalized sessions" 
                                     class="w-12 h-12 filter brightness-0 invert group-hover:drop-shadow-lg transition-all duration-300">
                            </div>
                        </div>
                        
                        <!-- Content -->
                        <div class="relative text-center flex-1 flex flex-col">
                            <h3 class="text-2xl md:text-3xl font-bold text-white mb-6 group-hover:text-purple-300 transition-colors duration-500">
                                {{ __('home.SAMAA Creates Personalized Sessions') }}
                            </h3>
                        </div>

                        <!-- Floating particles on hover -->
                        <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-700 pointer-events-none">
                            <div class="absolute top-4 right-4 text-purple-400 text-lg animate-bounce">♬</div>
                            <div class="absolute bottom-4 left-4 text-pink-400 text-sm animate-pulse">♩</div>
                        </div>
                    </div>
                </div>

                <!-- Card 3: You Listen, Heal, and Grow -->
                <div class="group animate-fade-in-up" style="animation-delay: 0.7s;">
                    <div class="relative bg-gradient-to-br from-slate-800/80 to-slate-700/80 backdrop-blur-lg 
                               rounded-3xl p-10 shadow-2xl hover:shadow-emerald-500/20
                               transform hover:-translate-y-4 hover:scale-105 transition-all duration-700
                               border border-slate-600/50 hover:border-emerald-400/50
                               overflow-hidden h-full flex flex-col">
                        <!-- Glowing Background -->
                        <div class="absolute inset-0 bg-gradient-to-br from-emerald-500/10 to-green-500/10 opacity-0 
                                   group-hover:opacity-100 transition-opacity duration-700"></div>
                        
                        <!-- Icon with Glow -->
                        <div class="relative mb-8">
                            <div class="w-24 h-24 mx-auto bg-gradient-to-br from-emerald-500/20 to-green-500/20 
                                       rounded-3xl flex items-center justify-center
                                       transform group-hover:scale-110 group-hover:rotate-6 transition-all duration-500
                                       shadow-lg group-hover:shadow-emerald-500/30">
                                <img src="{{ asset('assets/images/icons/Arrow-icon.svg') }}" 
                                     alt="Listen, heal and grow" 
                                     class="w-12 h-12 filter brightness-0 invert group-hover:drop-shadow-lg transition-all duration-300">
                            </div>
                        </div>
                        
                        <!-- Content -->
                        <div class="relative text-center flex-1 flex flex-col">
                            <h3 class="text-2xl md:text-3xl font-bold text-white mb-6 group-hover:text-emerald-300 transition-colors duration-500">
                                {{ __('home.You Listen, Heal, and Grow') }}
                            </h3>
                        </div>

                        <!-- Floating particles on hover -->
                        <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-700 pointer-events-none">
                            <div class="absolute top-4 right-4 text-emerald-400 text-lg animate-bounce">𝄞</div>
                            <div class="absolute bottom-4 left-4 text-green-400 text-sm animate-pulse">♪</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Professional Understanding Section -->
    <section class="py-24 bg-gradient-to-br from-slate-50 to-blue-50 relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <!-- Professional Content -->
                <div class="order-2 lg:order-1">
                    <div class="mb-8">
                        <h2 class="text-4xl md:text-5xl font-elegant font-bold text-gray-800 mb-6 leading-tight">
                            Understanding 
                            <span class="bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                                Music Therapy
                            </span>
                        </h2>
                        <div class="w-20 h-1 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full mb-6"></div>
                    </div>
                    <div class="prose prose-lg max-w-none">
                        <p class="text-xl text-gray-700 leading-relaxed mb-6 font-light">
                            {{ __('home.What is Music Therapy (answer)') }}
                        </p>
                        <div class="bg-blue-50 border-l-4 border-blue-500 p-6 rounded-r-xl">
                            <p class="text-gray-600 italic">
                                "Sound therapy creates pathways to healing by enhancing neural connectivity and emotional regulation."
                            </p>
                        </div>
                    </div>
                </div>
                <!-- Professional Image -->
                <div class="order-1 lg:order-2">
                    <div class="relative">
                        <img src="{{ asset('assets/images/music-therapy2.png') }}" alt="Music Therapy Research" 
                             class="w-full h-auto rounded-3xl shadow-2xl transform hover:scale-105 transition-transform duration-700">
                        <div class="absolute -bottom-4 -right-4 w-24 h-24 bg-gradient-to-r from-blue-500 to-purple-500 rounded-2xl opacity-20"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Professional Innovation Section -->
    <section class="py-24 bg-gradient-to-br from-indigo-50 to-purple-50 relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <!-- Professional Image -->
                <div class="relative">
                    <img src="{{ asset('assets/images/music-therapy.jpg') }}" alt="SAMAA Innovation" 
                         class="w-full h-auto rounded-3xl shadow-2xl transform hover:scale-105 transition-transform duration-700">
                    <div class="absolute -top-4 -left-4 w-24 h-24 bg-gradient-to-r from-purple-500 to-pink-500 rounded-2xl opacity-20"></div>
                </div>
                <!-- Professional Content -->
                <div>
                    <div class="mb-8">
                        <h2 class="text-4xl md:text-5xl font-elegant font-bold text-gray-800 mb-6 leading-tight">
                            <span class="bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">
                                SAMAA
                            </span>
                            Innovation
                        </h2>
                        <div class="w-20 h-1 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full mb-6"></div>
                    </div>
                    <div class="prose prose-lg max-w-none">
                        <p class="text-xl text-gray-700 leading-relaxed mb-6 font-light">
                            {{ __('home.Music Therapy (description)') }}
                        </p>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
                            <div class="bg-white p-6 rounded-xl shadow-lg border border-purple-100">
                                <div class="flex items-center mb-3">
                                    <div class="w-8 h-8 bg-gradient-to-r from-purple-500 to-pink-500 rounded-lg flex items-center justify-center mr-3">
                                        <i class="fas fa-brain text-white text-sm"></i>
                                    </div>
                                    <h4 class="font-bold text-gray-800">AI-Powered</h4>
                                </div>
                                <p class="text-gray-600 text-sm">Personalized therapy sessions</p>
                            </div>
                            <div class="bg-white p-6 rounded-xl shadow-lg border border-purple-100">
                                <div class="flex items-center mb-3">
                                    <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-cyan-500 rounded-lg flex items-center justify-center mr-3">
                                        <i class="fas fa-certificate text-white text-sm"></i>
                                    </div>
                                    <h4 class="font-bold text-gray-800">Clinically Validated</h4>
                                </div>
                                <p class="text-gray-600 text-sm">Evidence-based approach</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Professional Features Showcase -->
    <section class="py-24 bg-gradient-to-br from-emerald-50 to-teal-50 relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-6">
            <!-- Section Header -->
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-elegant font-bold text-gray-800 mb-6 leading-tight">
                    Why Choose 
                    <span class="bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent">
                        SAMAA
                    </span>
                </h2>
                <div class="w-20 h-1 bg-gradient-to-r from-emerald-500 to-teal-500 rounded-full mx-auto"></div>
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <!-- Professional Image -->
                <div class="relative">
                    <img class="w-full h-auto rounded-3xl shadow-2xl transform hover:scale-105 transition-transform duration-700" 
                         src="{{ asset('assets/images/home-section4.png') }}" alt="SAMAA Professional Features" />
                    <div class="absolute -bottom-4 -right-4 w-24 h-24 bg-gradient-to-r from-emerald-500 to-teal-500 rounded-2xl opacity-20"></div>
                </div>

                <!-- Professional Features Content -->
                <div>
                    <div class="space-y-10">
                        <div class="relative">
                            <div class="flex items-start space-x-4">
                                <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-r from-emerald-500 to-teal-500 rounded-xl flex items-center justify-center shadow-lg">
                                    <i class="fas fa-user-md text-white"></i>
                                </div>
                                <div>
                                    <h4 class="text-2xl font-bold text-gray-800 mb-3">{{ __('home.Personalized Sound Healing') }}</h4>
                                    <p class="text-lg text-gray-600 leading-relaxed">
                                        {{ __('home.Tailored therapy based on mood, needs, and goals.') }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="relative">
                            <div class="flex items-start space-x-4">
                                <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-r from-blue-500 to-cyan-500 rounded-xl flex items-center justify-center shadow-lg">
                                    <i class="fas fa-flask text-white"></i>
                                </div>
                                <div>
                                    <h4 class="text-2xl font-bold text-gray-800 mb-3">{{ __('home.Scientifically Validated') }}</h4>
                                    <p class="text-lg text-gray-600 leading-relaxed">
                                        {{ __('home.Developed and backed by experts ​SAMAA Profile.') }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="relative">
                            <div class="flex items-start space-x-4">
                                <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-r from-purple-500 to-pink-500 rounded-xl flex items-center justify-center shadow-lg">
                                    <i class="fas fa-heart text-white"></i>
                                </div>
                                <div>
                                    <h4 class="text-2xl font-bold text-gray-800 mb-3">{{ __('home.For Autism and Beyond') }}</h4>
                                    <p class="text-lg text-gray-600 leading-relaxed">
                                        {{ __('home.Special modules designed for children and adults on the spectrum ​ClinGroup_Music therapy…​Autism & Sound Virtual') }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="relative">
                            <div class="flex items-start space-x-4">
                                <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-r from-orange-500 to-red-500 rounded-xl flex items-center justify-center shadow-lg">
                                    <i class="fas fa-mobile-alt text-white"></i>
                                </div>
                                <div>
                                    <h4 class="text-2xl font-bold text-gray-800 mb-3">{{ __('home.Accessible Anytime, Anywhere') }}</h4>
                                    <p class="text-lg text-gray-600 leading-relaxed">
                                        {{ __('home.Mobile-friendly virtual therapy sessions Autism & Sound Virtual ….') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Beautiful Resources Section -->
    <section class="relative py-32 bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 overflow-hidden">
        <!-- Vibrant Background Effects -->
        <div class="absolute inset-0">
            <!-- Colorful gradient orbs -->
            <div class="absolute top-20 left-20 w-80 h-80 bg-gradient-to-r from-blue-300/30 to-cyan-300/30 rounded-full filter blur-2xl animate-pulse" style="animation-duration: 6s;"></div>
            <div class="absolute bottom-20 right-20 w-96 h-96 bg-gradient-to-r from-purple-300/25 to-pink-300/25 rounded-full filter blur-2xl animate-pulse" style="animation-duration: 8s; animation-delay: 3s;"></div>
            <div class="absolute top-1/2 right-1/4 w-64 h-64 bg-gradient-to-r from-emerald-300/20 to-teal-300/20 rounded-full filter blur-2xl animate-pulse" style="animation-duration: 7s; animation-delay: 1s;"></div>
            
            <!-- Floating colorful musical notes -->
            <div class="absolute inset-0 overflow-hidden pointer-events-none">
                <div class="absolute top-24 left-24 text-blue-400/20 text-2xl animate-float" style="animation-delay: 0s; animation-duration: 10s;">♪</div>
                <div class="absolute top-40 right-32 text-purple-400/15 text-3xl animate-float" style="animation-delay: 3s; animation-duration: 12s;">♫</div>
                <div class="absolute bottom-32 left-40 text-emerald-400/20 text-4xl animate-float" style="animation-delay: 6s; animation-duration: 9s;">♬</div>
                <div class="absolute bottom-24 right-24 text-pink-400/15 text-2xl animate-float" style="animation-delay: 9s; animation-duration: 11s;">♩</div>
            </div>
        </div>

        <div class="relative max-w-7xl mx-auto px-6">
            <!-- Stunning Section Header -->
            <div class="text-center mb-20">
                <div class="animate-fade-in-up">
                    <!-- Resources Title with Beautiful Gradient -->
                    <h3 class="text-5xl md:text-6xl font-elegant font-bold mb-6 leading-tight">
                        <span class="bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 bg-clip-text text-transparent drop-shadow-sm">
                            {{ __('home.Resource') }}
                        </span>
                    </h3>
                    <p class="text-lg md:text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed font-light">
                        Discover insights, tips, and stories from our community
                    </p>
                    
                    <!-- Decorative line -->
                    <div class="mt-8 flex justify-center">
                        <div class="w-24 h-1 bg-gradient-to-r from-blue-400 via-purple-400 to-pink-400 rounded-full"></div>
                    </div>
                </div>
            </div>
            
            <!-- Beautiful Blog Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10 lg:gap-12">
                @foreach ($blogs as $blog)
                @php
                    $locale = App::getLocale();
                    $title = json_decode($blog->title, true)[$locale] ?? '';
                    $cardColors = [
                        'from-blue-500/10 to-cyan-500/10 border-blue-200/50 hover:border-blue-400/70 hover:shadow-blue-500/20',
                        'from-purple-500/10 to-pink-500/10 border-purple-200/50 hover:border-purple-400/70 hover:shadow-purple-500/20',
                        'from-emerald-500/10 to-teal-500/10 border-emerald-200/50 hover:border-emerald-400/70 hover:shadow-emerald-500/20'
                    ];
                    $cardColor = $cardColors[$loop->index % 3];
                @endphp
                    <div class="group animate-fade-in-up" style="animation-delay: {{ 0.2 + ($loop->index * 0.1) }}s;">
                        <div class="relative bg-gradient-to-br {{ $cardColor }} backdrop-blur-sm
                                   rounded-3xl shadow-xl hover:shadow-2xl
                                   transform hover:-translate-y-3 hover:scale-105 transition-all duration-500
                                   border overflow-hidden h-full flex flex-col">
                            
                            <!-- Image with overlay -->
                            <div class="relative overflow-hidden rounded-t-3xl">
                                <img src="{{ $blog->image ? Storage::url($blog->image) : asset('assets/images/blog-image.png') }}" 
                                     alt="{{ $title }}" 
                                     class="w-full h-56 object-cover transform group-hover:scale-110 transition-transform duration-700">
                                <!-- Gradient overlay -->
                                <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                            </div>
                            
                            <!-- Content -->
                            <div class="p-8 flex-1 flex flex-col">
                                <h3 class="text-xl md:text-2xl font-bold text-gray-800 mb-6 leading-tight group-hover:text-gray-700 transition-colors duration-300">
                                    {{ $title }}
                                </h3>
                                
                                <!-- Enhanced footer -->
                                <div class="mt-auto flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-8 h-8 bg-gradient-to-r from-blue-400 to-purple-400 rounded-full flex items-center justify-center">
                                            <i class="fas fa-calendar-alt text-white text-sm"></i>
                                        </div>
                                        <p class="text-sm font-medium text-gray-600">
                                            {{ now()->diffInDays($blog->created_at) === 0 ? __('home.today') : (now()->diffInDays($blog->created_at) === 1 ? __('home.1_day_ago') : __('home.x_days_ago', ['count' => now()->diffInDays($blog->created_at)])) }}
                                        </p>
                                    </div>
                                    <a href="{{ route('blog.show', ['blog' => $blog->id]) }}" 
                                       class="group/link inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-500 to-purple-500 
                                              text-white font-semibold text-sm rounded-xl shadow-lg hover:shadow-xl
                                              transform hover:scale-105 transition-all duration-300">
                                        {{ __('home.learn more') }}
                                        <i class="fas fa-arrow-right ml-2 transform group-hover/link:translate-x-1 transition-transform duration-300"></i>
                                    </a>
                                </div>
                            </div>
                            
                            <!-- Floating musical note on hover -->
                            <div class="absolute top-4 right-4 opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none">
                                <div class="text-2xl animate-bounce" style="color: {{ $loop->index % 3 == 0 ? '#3b82f6' : ($loop->index % 3 == 1 ? '#8b5cf6' : '#10b981') }};">
                                    {{ ['♪', '♫', '♬'][$loop->index % 3] }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-gradient-to-r from-primary-600 to-secondary-600 relative overflow-hidden">
        <div class="max-w-4xl mx-auto px-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <!-- Text Section -->
                <div class="text-section text-white">
                    @if (App::getLocale() == 'ar')
                        <h1 class="text-4xl md:text-5xl font-elegant font-bold leading-tight">
                            {{ __('home.start') }}<br>
                            <span class="text-accent-200">{{ __('home.Journey') }}</span> {{ __('home.Healing') }}<br>
                            {{ __('home.Your') }} <span class="text-accent-200">{{ __('home.today') }}</span>
                        </h1>
                    @elseif (App::getLocale() == 'fr')
                        <h1 class="text-4xl md:text-5xl font-elegant font-bold leading-tight">
                            {{ __('home.start') }}<br>
                            {{ __('home.Your') }} <span class="text-accent-200">{{ __('home.Journey') }}</span><br>
                            <span class="text-accent-200">{{ __('home.Healing') }}</span> {{ __('home.today') }}
                        </h1>
                    @else
                        <h1 class="text-4xl md:text-5xl font-elegant font-bold leading-tight">
                            {{ __('home.start') }}<br>
                            {{ __('home.Your') }} <span class="text-accent-200">{{ __('home.Healing') }}</span><br>
                            <span class="text-accent-200">{{ __('home.Journey') }}</span> {{ __('home.today') }}
                        </h1>
                    @endif
                </div>

                <!-- CTA Form Section -->
                <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-8 border border-white/20">
                    <form action="{{ route('contactUs.store') }}" method="post" class="space-y-6">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <input type="text" name="first_name" 
                                   placeholder="{{ __('home.First Name') }}" 
                                   required
                                   class="w-full px-4 py-3 bg-white/20 border border-white/30 rounded-xl text-white placeholder-white/70 focus:outline-none focus:ring-2 focus:ring-accent-400 focus:border-accent-400 transition-all duration-300">
                            <input type="text" name="surname" 
                                   placeholder="{{ __('home.Surname') }}"
                                   class="w-full px-4 py-3 bg-white/20 border border-white/30 rounded-xl text-white placeholder-white/70 focus:outline-none focus:ring-2 focus:ring-accent-400 focus:border-accent-400 transition-all duration-300">
                        </div>
                        <input name="email" type="email" 
                               placeholder="{{ __('home.Email') }}" 
                               required
                               class="w-full px-4 py-3 bg-white/20 border border-white/30 rounded-xl text-white placeholder-white/70 focus:outline-none focus:ring-2 focus:ring-accent-400 focus:border-accent-400 transition-all duration-300">
                        <select name="subject"
                                class="w-full px-4 py-3 bg-white/20 border border-white/30 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-accent-400 focus:border-accent-400 transition-all duration-300">
                            @foreach (\App\Enums\SubjectsEnum::all() as $key)
                                <option value="{{ $key }}" class="text-gray-800">{{ __($key) }}</option>
                            @endforeach
                        </select>
                        <textarea name="message" 
                                  placeholder="{{ __('home.Message') }}" 
                                  required
                                  rows="4"
                                  class="w-full px-4 py-3 bg-white/20 border border-white/30 rounded-xl text-white placeholder-white/70 focus:outline-none focus:ring-2 focus:ring-accent-400 focus:border-accent-400 transition-all duration-300 resize-none"></textarea>
                        <input type="hidden" name="cta_source" value="homePage">
                        <button type="submit" 
                                class="w-full px-6 py-3 bg-accent-500 hover:bg-accent-600 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300">
                            {{ __('home.Submit') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Partnership CTA Section -->
    <section class="py-20 bg-gradient-to-r from-primary-600 to-secondary-600 relative overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0">
            <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-br from-primary-500/20 to-secondary-500/20"></div>
            <div class="absolute top-10 right-10 w-64 h-64 bg-white/10 rounded-full filter blur-3xl"></div>
            <div class="absolute bottom-10 left-10 w-80 h-80 bg-accent-400/20 rounded-full filter blur-3xl"></div>
        </div>

        <div class="relative max-w-4xl mx-auto px-6 text-center">
            <div class="animate-fade-in-up">
                <h2 class="text-4xl md:text-5xl font-elegant font-bold text-white mb-6 leading-tight">
                    {{ __('home.Partner with') }} 
                    <span class="text-accent-200">{{ __("home.Sama'a") }}</span>
                </h2>
                <p class="text-xl text-white/90 mb-10 leading-relaxed max-w-2xl mx-auto">
                    {{ __('home.Expand your practice with AI-driven music therapy') }}
                </p>
                
                <div class="animate-fade-in-up" style="animation-delay: 0.2s;">
                    <a href="{{ route('contact-us') }}" 
                       class="inline-flex items-center px-8 py-4 bg-white text-primary-600 
                              font-bold text-lg rounded-2xl shadow-xl hover:shadow-2xl
                              transform hover:-translate-y-1 hover:scale-105 
                              transition-all duration-300 group">
                        {{ __('home.Let’s Partner Up') }}
                        <i class="fas fa-arrow-right ml-3 transform group-hover:translate-x-1 transition-transform duration-300"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Floating Elements -->
        <div class="absolute top-20 left-20 w-4 h-4 bg-accent-300 rounded-full animate-float opacity-60"></div>
        <div class="absolute top-32 right-32 w-6 h-6 bg-white/30 rounded-full animate-float opacity-70" style="animation-delay: 1s;"></div>
        <div class="absolute bottom-24 left-1/3 w-3 h-3 bg-accent-200 rounded-full animate-float opacity-50" style="animation-delay: 2s;"></div>
    </section>
</main>
@endsection

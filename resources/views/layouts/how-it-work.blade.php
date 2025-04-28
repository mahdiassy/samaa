@extends('layouts.base')
@section('content')
    <section class="work-section">

        <div class="work-container">

            <div class="our-work">
                <div class="work-text">
                    <h2>{{ __('site.The') }}<span>{{ __('site.science') }}</span></h2>
                    <h2>{{ __('site.Behind SAMAA') }}</h2>
                    <p>{{ __('site.Healing Through Sound, Perfected by Science') }}</p>
                    <p>{{ __('site.work-description') }}</p>
                </div>
            </div>

            <div class="doctors-section">
                <div class="doctor-cards">

                    <div class="doctor-card">
                        <div class="doctor-image"
                            style="background-image: url('{{ asset('assets/images/doctor-profile.jpg') }}');">
                        </div>
                    </div>

                    <div class="doctor-card">
                        <div class="doctor-content">
                            <div class="timeline">
                                <div class="timeline-item">
                                    <div class="timeline-dot"></div>
                                    <div class="timeline-content">
                                        7x Forbes Most Influential Arab Woman
                                    </div>
                                </div>
                                <div class="timeline-item">
                                    <div class="timeline-dot"></div>
                                    <div class="timeline-content">
                                        Pioneer In AI-Driven Healthcare Solutions
                                    </div>
                                </div>
                                <div class="timeline-item">
                                    <div class="timeline-dot"></div>
                                    <div class="timeline-content">
                                        Backed By A 6-Month Clinical Trial Using<br> The U-Shaped Montage Technique.
                                    </div>
                                </div>
                                <div class="timeline-item">
                                    <div class="timeline-dot"></div>
                                    <div class="timeline-content">
                                        Endorsed By The American European Music<br> Therapy Association.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <section class="section2-work">
                <div class="section-description">
                    @if (App::getLocale() == 'ar')
                        <h2><span>{{ __('site.Protocol') }}</span> {{ __('site.The') }}{{ __('site.Therapy') }}</h2>
                        <h2> {{ __('site.Sound') }} <span>{{ __('site.U-Shaped') }}</span></h2>
                    @elseif (App::getLocale() == 'fr')
                        <h2>{{ __('site.The') }} <span>{{ __('site.Protocol') }}</span> {{ __('site.Therapy') }} </h2>
                        <h2>{{ __('site.Sound') }} <span>{{ __('site.U-Shaped') }}</span> </h2>
                    @else
                        <h2>{{ __('site.The') }} <span>{{ __('site.U-Shaped') }}</span> {{ __('site.Sound') }} </h2>
                        <h2>{{ __('site.Therapy') }} <span>{{ __('site.Protocol') }}</span> </h2>
                    @endif
                    <p>{{ __('site.How U-Shaped Sound Transforms Lives') }}</p>
                    <p>{{ __('site.U-Saped-description') }}
                    </p>
                </div>
                <div class="stat-card-work">
                    <p>{{ __('site.SAMAA’s AI replicates the U-shaped technique validated in European clinical studies') }}
                    </p>
                </div>
            </section>

            <div class="four-step-section">
                <div class="text-side">
                    <h2>{{ __('site.The 4-Step Process') }}</h2>
                    <p class="subtitle">{{ __('site.The 4-Step Process') }}</p>

                    <div class="step">
                        <h4>{{ __('site.Personalized Profile Setup') }}</h4>
                        <p>
                            <span class="circle-work" > </span>
                            {{ __('site.Tell Us About Your Needs (Age, Condition, Goals). SAMAA Respects Privacy—No Medical Data Is Stored Without Consent.') }}<br>
                            <span class="circle-work" > </span>
                            <em>{{ __('site.Dr-Nadia’s Quote: "Just As Every Patient Is Unique, So Is Their Path To Healing."') }}</em>
                        </p>
                    </div>

                    <div class="step">
                        <h4>{{ __('site.AI-Driven Customization') }}</h4>
                        <p>
                            <span class="circle-work" > </span>
                            {{ __('site.SAMAA’s AI Crafts A U-Shaped Sound Journey Tailored To Your Profile.') }}<br>
                            <span class="circle-work" > </span>
                            {{ __('site.Clinicals Backing: European Studies Show U-Shaped Therapy Improves Emotional Regulation In 60% Of Autism Cases.') }}
                        </p>
                    </div>

                    <div class="step">
                        <h4>{{ __('site.Real-Time Adjustments') }}</h4>
                        <p>
                            <span class="circle-work" > </span>
                            {{ __('site.SAMAA Adapts Tempo/Pitch Mid-Session Using Machine Learning.') }}<br>
                            <span class="circle-work" > </span>
                            {{ __('site.Tech Proof: Powered By Clinicouris AI. Recognized At The Go Global Awards 2022.') }}
                        </p>
                    </div>

                    <div class="step">
                        <h4>{{ __('site.Progress Tracking') }}</h4>
                        <p>
                            <span class="circle-work" > </span>
                            {{ __('site.Monthly Reports Track Improvements In Focus, Behavior, And Sensory Responses Against Clinical Benchmarks.') }}
                        </p>
                    </div>
                </div>

                <div class="image-side">
                    <div class="image-container-work">
                        @if (App::getLocale() == 'ar')
                            <img src="{{ asset('assets/images/headphones-how-work-ar.png') }}" alt="Main Image"
                                class="main-image-work">

                            <div class="icon" style="top: 14%; left: 330px;">
                                <img src="{{ asset('assets/images/icons/Statistics.svg') }}" alt="Icon 1">
                            </div>

                            <div class="icon" style="top: 34%; left: 398px;">
                                <img src="{{ asset('assets/images/icons/Musical note.svg') }}" alt="Icon 2">
                            </div>

                            <div class="icon" style="top: 58%; left: 390px;">
                                <img src="{{ asset('assets/images/icons/Brain.svg') }}" alt="Icon 3">
                            </div>

                            <div class="icon" style="top: 78%; left: 311px;">
                                <img src="{{ asset('assets/images/icons/Notes.svg') }}" alt="Icon 4">
                            </div>
                        @else
                            <img src="{{ asset('assets/images/headphones-how-work.png') }}" alt="Main Image"
                            class="main-image-work">

                            <div class="icon" style="top: 14%; left: 80px;">
                                <img src="{{ asset('assets/images/icons/Statistics.svg') }}" alt="Icon 1">
                            </div>

                            <div class="icon" style="top: 34%; left: 6px;">
                                <img src="{{ asset('assets/images/icons/Musical note.svg') }}" alt="Icon 2">
                            </div>

                            <div class="icon" style="top: 58%; left: 20px;">
                                <img src="{{ asset('assets/images/icons/Brain.svg') }}" alt="Icon 3">
                            </div>

                            <div class="icon" style="top: 78%; left: 100px;">
                                <img src="{{ asset('assets/images/icons/Notes.svg') }}" alt="Icon 4">
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="proof-work">
                <div class="proof-text">
                    <h2><span>{{ __('site.Clinical') }}</span> {{ __('site.Proof') }} &</h2>
                    <h2>{{ __('site.Global Recognition') }}</h2>
                    <p>{{ __('site.Proven Impact on Autism & Beyond') }}</p>
                    <br>
                    <br>
                    <h1>{{ __('site.Month Trial Results') }}:</h1>
                    <p>{{ __('site.70% improved sensory processing.') }}</p>
                    <p>{{ __('site.65% reduced anxiety/emotional outbursts.') }}</p>
                    <p>{{ __('site.80% better sleep quality reported by parents.') }}</p>

                    <h1>{{ __('site.Partners') }}:</h1>
                    <p>{{ __('site.Dubai Autism Center') }}, {{ __('site.Hope MCF Foundation') }},
                        {{ __('site.NAAM Women’s Empowerment') }}</p>

                    <h1>{{ __('site.Awards') }}:</h1>
                    <p>{{ __('site.Go Global Award 2022 (Corporate Social Responsibility)') }}</p>
                </div>
            </div>

            <div class="header-container">
                <div class="header">
                    <h1 class="custom-h1">{{ __('site.Ready to Experience') }}</h1>
                    <h1 class="custom-h1">{{ __('site.Healing Through') }} <span
                            class="custom-h1">{{ __('site.sound?') }}</span></h1>
                    <div class="bar-graph"></div>
                    <div class="buttons">
                        <button class="btn-sponsor">{{ __('site.Join Our Waitlist') }}</button>
                        <button class="btn-subscribe">{{ __('site.Partner With SAMAA') }}</button>
                    </div>
                    <p>{{ __('site.SAMAA adheres to GDPR and global privacy standards. Your data is never shared without consent') }}
                    </p>
                </div>
            </div>
        </div>
    </section>
@endsection

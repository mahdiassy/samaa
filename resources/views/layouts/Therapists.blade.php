@extends('layouts.base')
@section('content')
    <section class="work-section">

        <div class="work-container">

            <div class="our-therapists">
                <div class="therapists-text">
                    @if (App::getLocale() == 'ar')
                        <h2>{{ __('site.Empowering') }}<br> <span class="crossed-orange"> {{ __('site.therapists') }}
                            </span>{{ __('site.with') }} {{ __('site.therapy') }} <span class="span-coler">
                                {{ __('site.Sound') }} </span> {{ __('site.AI-Driven') }}</h2>
                    @elseif (App::getLocale() == 'fr')
                        <h2>{{ __('site.Empowering') }}<br> <span class="crossed-orange"> {{ __('site.therapists') }}
                            </span>{{ __('site.with') }} {{ __('site.therapy') }} <span class="span-coler">
                                {{ __('site.Sound') }} </span> {{ __('site.AI-Driven') }} </h2>
                    @else
                        <h2>{{ __('site.Empowering') }}<br> <span class="crossed-orange"> {{ __('site.therapists') }}
                            </span>{{ __('site.with') }} {{ __('site.AI-Driven') }} <span class="span-coler">
                                {{ __('site.Sound') }} </span> {{ __('site.therapy') }} </h2>
                    @endif
                </div>
            </div>

            <div class="therapy-section1">
                <div class="therapy-left">
                    @if (App::getLocale() == 'ar')
                        <h2>{{ __('site.Join A') }}<br><strong>{{ __('site.Revolution In') }}  {{ __('site.therapy') }}<span class="highlight"> {{ __('site.Music') }}</span></strong></h2>
                        <p>{{ __('site.SAMAA equips therapists and institutions with AI tools to enhance traditional practices, backed by') }}
                            {{ __('site.groundbreaking research.') }} <strong class="crossed-orange2">{{ __('site.Dr. Nadia Cheaib') }}</strong> </p>

                    @elseif (App::getLocale() == 'fr')
                        <h2>{{ __('site.Join A') }}<br><strong>{{ __('site.Revolution In') }}<span class="highlight"> {{ __('site.Music') }}</span></strong></h2>
                        <p>{{ __('site.SAMAA equips therapists and institutions with AI tools to enhance traditional practices, backed by') }}
                            {{ __('site.groundbreaking research.') }} <strong class="crossed-orange2">{{ __('site.Dr. Nadia Cheaib') }}</strong> </p>

                    @else
                        <h2>{{ __('site.Join A') }}<br><strong>{{ __('site.Revolution In') }}<span class="highlight"> {{ __('site.Music') }}</span> {{ __('site.therapy') }}</strong></h2>
                        <p>{{ __('site.SAMAA equips therapists and institutions with AI tools to enhance traditional practices, backed by') }}
                            <strong class="crossed-orange2">{{ __('site.Dr. Nadia Cheaib') }}</strong> {{ __('site.groundbreaking research.') }}</p>
                    @endif

                    <div class="badges">
                        <div class="badge">{{ __('site.Endorsed By The American European Music Therapy Association.') }}</div>
                        <div class="badge">{{ __('site.Clinically Validated In Autism Studie') }}</div>
                    </div>
                </div>

                <div class="therapy-right">
                    <img src="{{ asset('assets/images/revolution.png') }}" alt="Music Therapy" class="therapy-image-benf">
                    <div class="quote-box">
                        <em>{{ __('site.Therapists Are The Heart Of Healing') }} <strong>SAMAA</strong> {{ __('site.Is Here To Amplify Your Impact.') }}</em><br>
                        <span class="quote-author">{{ __('site.Dr. Nadia’s') }}</span>
                    </div>
                </div>
            </div>

            <div class="benefits-section">
                <div class="benefits-heading">
                    {{ __('site.Benefits for') }} <span>{{ __('site.Therapists') }}</span>
                    <p>{{ __('site.Why Partner with SAMAA?') }}</p>
                </div>

                <div class="box-container">
                    <div class="info-box">
                        <img src="{{ asset('assets/images/icons/Music.svg') }}" alt="Icon" class="box-icon">
                        <h3 class="box-title">{{ __('site.AI-Powered Tools:') }}</h3>
                        <p class="box-description">
                            {{ __('site.Customize sessions using U-shaped sound therapy protocols, adapted in real-time for each patient.') }}
                        </p>
                    </div>
                    <div class="info-box">
                        <img src="{{ asset('assets/images/icons/Bar graph.svg') }}" alt="Icon" class="box-icon">
                        <h3 class="box-title">{{ __('site.Progress Tracking:') }}</h3>
                        <p class="box-description">
                            {{ __('site.Access dashboards to monitor behavioral improvements, sleep patterns, and sensory responses.') }}
                        </p>
                    </div>
                    <div class="info-box">
                        <img src="{{ asset('assets/images/icons/Global.svg') }}" alt="Icon" class="box-icon">
                        <h3 class="box-title">{{ __('site.Global Collaboration:') }}</h3>
                        <p class="box-description">
                            {{ __('site.Join a network of therapists and institutions pioneering ethical, tech-driven care') }}
                        </p>
                    </div>
                    <div class="info-box">
                        <img src="{{ asset('assets/images/icons/Brain-vector.svg') }}" alt="Icon" class="box-icon">
                        <h3 class="box-title">{{ __('site.Training & Support:') }}</h3>
                        <p class="box-description">{{ __('site.Free onboarding and access to SAMAA’s research library') }}
                        </p>
                    </div>
                </div>

            </div>
            <div class="doctors-section">
                <div class="doctor-cards">

                    <div class="doctor-card">
                        <div class="doctor-content">
                            <h1 class="organizations-title"><span>{{ __('site.Sama’a') }}</span>
                                {{ __('site.for Organizations') }}</h1>
                            <div class="timeline">
                                <div class="timeline-item">
                                    <div class="timeline-dot"></div>
                                    <div class="timeline-content">
                                        <h1 style="margin: auto;">{{ __('site.Tailored Programs:') }}</h1>
                                        {{ __('site.Integrate SAMAA into your wellness initiatives for autism, anxiety, or chronic pain.') }}
                                    </div>
                                </div>
                                <div class="timeline-item">
                                    <div class="timeline-dot"></div>
                                    <div class="timeline-content">
                                        <h1 style="margin: auto;">{{ __('site.Data-Driven Insights:') }}</h1>
                                        {{ __('site.Receive aggregated reports to measure program efficacy and secure funding') }}
                                    </div>
                                </div>
                                <div class="timeline-item">
                                    <div class="timeline-dot"></div>
                                    <div class="timeline-content">
                                        <h1 style="margin: auto;">{{ __('site.Ethical Mission:') }}</h1>
                                        {{ __('site.Align with Dr. Nadia Cheaib’s vision: 10% of SAMAA’s profits fund therapy for underserved communities.') }}
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="doctor-card">
                        <div class="doctor-image"
                            style="background-image: url('{{ asset('assets/images/therapists-section1.png') }}');">
                        </div>
                    </div>

                </div>
            </div>

            <div class="steps-section">
                <div class="steps-heading">
                    {{ __('site.Get Started In') }} <span>{{ __('site.3 Steps') }}</span>
                </div>

                <div class="steps-container">
                    <div class="step">
                        <div class="step-header">
                            <span class="step-number">1</span>
                            <div class="step-title-container">
                                <span class="step-title">{{ __('site.Apply') }}</span>
                                <div class="step-line"></div>
                            </div>
                        </div>
                        <div class="step-desc">{{ __('site.Fill Out A Short Form.') }}</div>
                    </div>

                    <div class="step">
                        <div class="step-header">
                            <span class="step-number">2</span>
                            <div class="step-title-container">
                                <span class="step-title">{{ __('site.Onboard') }}</span>
                                <div class="step-line"></div>
                            </div>
                        </div>
                        <div class="step-desc">{{ __('site.Attend A 30-Minute Training Webinar.') }}</div>
                    </div>

                    <div class="step">
                        <div class="step-header">
                            <span class="step-number">3</span>
                            <div class="step-title-container">
                                <span class="step-title">{{ __('site.Launch') }}</span>
                                <div class="step-line"></div>
                            </div>
                        </div>
                        <div class="step-desc">{{ __('site.Access SAMAA’s Portal And Start Healing') }}</div>
                    </div>
                </div>
            </div>

            <div class="header-container">
                <div class="header">
                    <h1 class="custom-h1"><span class="custom-h1">{{ __('site.Join') }}
                        </span>{{ __('site.therapistss') }} <br> {{ __('site.Transforming') }} <span
                            class="custom-h1">{{ __('site.Lives') }}</span></h1>
                    <div class="bar-graph"></div>
                    <p>{{ __('site.SAMAA complies with HIPAA/GDPR. Patient data is fully encrypted.') }}</p>
                    <div class="buttons">
                        <button class="btn-sponsor">{{ __('site.Join Our Waitlist') }}</button>
                        <button class="btn-subscribe">{{ __('site.Partner With SAMAA') }}</button>
                    </div>
                    <p class="custom-p">{{ __('site.Inquire About') }} <a
                            href="#">{{ __('site.Institutional Partnerships') }} </a></p>
                </div>
            </div>
        </div>
    </section>
@endsection

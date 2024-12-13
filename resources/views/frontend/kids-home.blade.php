@extends('layouts.kids-base')
@section('content')
    <section class="hero">
        <img src="{{ asset('assets/images/kids-landing-page3.png') }}" alt="Piano background">
        <div class="hero-text {{ App::getLocale() == 'ar' ? 'text-right' : 'text-left' }}">
            <h2>{{ __('site.Welcome to SAMAA') }}</h2>
            @if (App::getLocale() == 'ar')
                <h1 class="heal-Arabic">
                    صحت<span class="different-r-Arabic">ك</span> في سمع<span class="different-l-Arabic">ك</span>
                </h1>
            @elseif (App::getLocale() == 'fr')
                <h1 class="heal-French">
                    Écoute<span class="different-r-French">r</span> pour guéri<span class="different-l-French">r</span>
                </h1>
            @else
                <h1 class="heal">
                    Hea<span class="different-r">r</span> to Hea<span class="different-l">l</span>
                </h1>
            @endif

            <p>{{ __('site.When healthcare professionals educate you using sound to enhance your health and well-being.') }}
            </p>
        </div>
    </section>

    <section class="therapy-section">
        <div class="therapy-content">
            <h2>{{ __('site.Music Therapy') }}</h2>
            <p>
                {{ __('site.Music Therapy (description)') }}
            </p>
        </div>
        <img src="{{ asset('assets/images/kids-music-therapy.jpg') }}" alt="Music Therapy">
    </section>

    <section class="therapy-section2">
        <img src="{{ asset('assets/images/kids-music-therapy2.png') }}" alt="Music Therapy">
        <div class="therapy-content2">
            <h2>{{ __('site.What is Music Therapy?') }}</h2>
            <p>
                {{ __('site.What is Music Therapy (answer)') }}
            </p>
        </div>
    </section>

    <div class="container">
        <div class="card" style="opacity: 1;">
            <img src="{{ asset('assets/images/music.png') }}" alt="Music Selection Icon">
            <h3>{{ __('site.Music Selection') }}</h3>
            <p>{{ __('site.Choose from a variety of music genres and styles to create your personalized therapeutic experience.') }}
            </p>
        </div>
        <div class="card" style="opacity: 1;">
            <img src="{{ asset('assets/images/dial.png') }}" alt="Mood Enhancement Icon">
            <h3>{{ __('site.Mood Enhancement') }}</h3>
            <p>{{ __('site.Enhance your mood by selecting music that matches your emotions and feelings.') }}</p>
        </div>
        <div class="card" style="opacity: 1;">
            <img src="{{ asset('assets/images/relacsation.png') }}" alt="Relaxation Icon">
            <h3>{{ __('site.Relaxation') }}</h3>
            <p>{{ __('site.Immerse yourself in calming melodies to unwind, reduce stress, and find tranquility.') }}</p>
        </div>
    </div>

    <section class="section2">
        <div class="section-description">
            <h2>{{ __('site.Sound Therapy and Composers') }}</h2>
            <p>{{ __('site.Learn about the role of music therapy in healing and relaxation. Discover how famous composers like Beethoven utilized the power of music to overcome challenges and inspire others.') }}
            </p>
            <button>{{ __('site.LISTEN TO MUSIC') }}</button>
        </div>
    </section>
@endsection

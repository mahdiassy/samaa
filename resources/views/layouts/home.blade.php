@extends('layouts.base')
@section('content')
    <section class="hero">
        <div class="landing-page"></div>
        <!--<img src="{{ asset('assets/images/landing-page.png') }}" alt="Piano background">-->
        <div class="hero-text {{ App::getLocale() == 'ar' ? 'text-right' : 'text-left' }}">
            <h2>{{ __('site.Welcome to SAMAA') }}</h2>
            @if (App::getLocale() == 'ar')
                <h1 class="
                heal-Arabic">
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

    <div class="sound-therapy-section">
        <div class="home-heading">
            <h1><span>{{ __('site.Sound') }} </span>{{ __('site.Therapy') }}</h1>
            <p>{{ __('site.Music therapy is a discipline widely used in the medical field as a therapeutic tool. It can aid physical and emotional rehabilitation of individuals and help develop communication skills and positive relationships with others.') }}</p>

           <h1> {{ __('site.How') }} <span>{{ __('site.Sama’a') }} </span>{{ __('site.Works') }} </h1>
        </div>

        <div class="container">

            <div class="card" style="opacity: 1;">
                <img src="{{ asset('assets/images/icons/Brain-icon.svg') }}" alt="Brain Icon">
                <h3>{{ __('site.You Share Your Needs') }}</h3>
                </p>
            </div>
            <div class="card" style="opacity: 1;">
                <img src="{{ asset('assets/images/icons/AI.svg') }}" alt="AI Icon">
                <h3>{{ __('site.SAMAA Creates Personalized Sessions') }}</h3>
            </div>
            <div class="card" style="opacity: 1;">
                <img src="{{ asset('assets/images/icons/Arrow-icon.svg') }}" alt="Arrow Icon">
                <h3>{{ __('site.You Listen, Heal, and Grow') }}</h3>
                </p>
            </div>
        </div>
    </div>

    <section class="therapy-section2">
        <div class="therapy-image2"></div>
        <!--<img src="{{ asset('assets/images/music-therapy2.png') }}" alt="Music Therapy">-->
        <div class="therapy-content2">
            <!--<h2>{{ __('site.What is Music Therapy?') }}</h2>-->
            <p>
                {{ __('site.What is Music Therapy (answer)') }}
            </p>
        </div>
    </section>

    <section class="therapy-section">
        <div class="therapy-content">
            <!--<h2>{{ __('site.Music Therapy') }}</h2>-->
            <p>
                {{ __('site.Music Therapy (description)') }}
            </p>
        </div>
        <div class="therapy-image"></div>
        <!--<img src="{{ asset('assets/images/music-therapy.jpg') }}" alt="Music Therapy">-->
    </section>

    <div class="doctors-section">
        <div class="doctor-cards">

            <div class="doctor-card">
                <div class="">
                    <img class="image-section4" src="{{ asset('assets/images/home-section4.png') }}" />
                </div>
            </div>

            <div class="doctor-card">
                <div class="doctor-content">
                    <div class="text-side">

                        <div class="step">
                            <h4 class="star-point" >{{ __('site.Personalized Sound Healing') }}</h4>
                            <p>
                                {{ __('site.Tailored therapy based on mood, needs, and goals.') }}</p>
                        </div>

                        <div class="step">
                            <h4 class="star-point">{{ __('site.Scientifically Validated') }}</h4>
                            <p>
                                {{ __('site.Developed and backed by experts ​SAMAA Profile.') }}<br>
                            </p>
                        </div>

                        <div class="step">
                            <h4  class="star-point" >{{ __('site.For Autism and Beyond') }}</h4>
                            <p>
                                {{ __('site.Special modules designed for children and adults on the spectrum ​ClinGroup_Music therapy…​Autism & Sound Virtual') }}<br>
                            </p>
                        </div>

                        <div class="step">
                            <h4  class="star-point" >{{ __('site.Accessible Anytime, Anywhere') }}</h4>
                            <p>
                                {{ __('site.Mobile-friendly virtual therapy sessions Autism & Sound Virtual ….') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="section2">
        <div class="section2-description">
            <h2>{{ __('site.Partner with') }} <span>{{ __('site.Sama’a') }}</span>. {{ __('site.Expand your practice with AI-driven music therapy') }} </h2>

            <button>{{ __('site.Let’s Partner Up') }}</button>
        </div>
    </section>

    <section class="doctors-section">
        <div class="blog">
            <h3 class="blog-title">{{ __('site.Resource') }}</h3>
            <div class="blog-cards">
                @foreach ($blogs as $blog)
                @php
                    $locale = App::getLocale();
                    $title = json_decode($blog->title, true)[$locale] ?? '';
                @endphp
                    <div class="blog-card">
                        <img src="{{ $blog->image ? Storage::url($blog->image) : asset('assets/images/blog-image.png') }}">
                        <div class="blog-info">
                            <h3>{{$title}}</h3>
                            <!--<p>{{ \Illuminate\Support\Str::words(strip_tags($blog->description), 10, '...') }}</p>-->
                        </div>
                        <div class="button-calendar">
                            <div class="calendar-date">
                                <img class="uim_calender" src="{{asset('assets/images/icons/uim_calender.svg') }}">
                                <p class="date-text">
                                    {{ now()->diffInDays($blog->created_at) === 0 ? __('site.today') : (now()->diffInDays($blog->created_at) === 1 ? __('site.1_day_ago')  : __('site.x_days_ago', ['count' => now()->diffInDays($blog->created_at)])) }}
                                </p>
                            </div>
                            <a class="a-card" href="{{ route('blog.show', $blog) }}" >{{ __('site.learn more') }}</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="doctors-section">
        <div class="CTA-container">
            <div class="text-section">
                @if (App::getLocale() == 'ar')
                    <h1>
                        {{ __('site.start') }}<br>
                        <span class="highlight">{{ __('site.Journey') }}</span> {{ __('site.Healing') }}<br>
                        {{ __('site.Your') }} <span class="highlight">{{ __('site.today') }}</span>
                    </h1>
                @elseif (App::getLocale() == 'fr')
                    <h1>
                        {{ __('site.start') }}<br>
                        {{ __('site.Your') }} <span class="highlight">{{ __('site.Journey') }}</span><br>
                        <span class="highlight">{{ __('site.Healing') }} </span>{{ __('site.today') }}
                    </h1>
                @else
                    <h1>
                        {{ __('site.start') }}<br>
                        {{ __('site.Your') }} <span class="highlight">{{ __('site.Healing') }}</span><br>
                        <span class="highlight">{{ __('site.Journey') }} </span>{{ __('site.today') }}
                    </h1>
                @endif
            </div>

            <div class="cta-section">
                <form>
                    <div class="form-row">
                        <input type="text" placeholder="{{ __('site.First Name') }}" required>
                        <input type="text" placeholder="{{ __('site.Last Name') }}" required>
                    </div>
                    <input type="email" placeholder="{{ __('site.Email') }}" required>
                    <textarea placeholder="{{ __('site.Message') }}"></textarea>
                    <button type="submit">{{ __('site.Submit') }}</button>
                </form>
            </div>
        </div>
    </section>
@endsection

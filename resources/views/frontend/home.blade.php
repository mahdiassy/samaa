@extends('layouts.base')
@section('content')
<section class="hero">
    <img src="assets/images/piano-background.png" alt="Piano background">
    <div class="hero-text">
        <h2>Welcome to SAMAA</h2>
        <h1 class="heal">
            Hea<span class="different-r">r</span> to Hea<span class="different-l">l</span>
        </h1>
        <p>Experience The Power Of Music For Relaxation, Healing, And Rejuvenation.</p>
    </div>
</section>

<section class="therapy-section">
    <div class="therapy-content">
        <h2>Music Therapy</h2>
        <p>
            Music therapy is a discipline widely used in the medical field as a therapeutic tool. It can aid
            physical and emotional rehabilitation of individuals and help develop communication skills and positive
            relationships with others.
        </p>
    </div>
    <img src="assets/images/music-therapy.png" alt="Music Therapy">
</section>

<section class="therapy-section2">
    <img src="assets/images/music-therapy2.png" alt="Music Therapy">
    <div class="therapy-content2">
        <h2>What is Music Therapy?</h2>
        <p>
            Music therapy involves harnessing music elements such as lyrics, melody, and rhythm to facilitate
            recovery from various conditions. Music therapists are responsible for organizing activities and
            selecting songs for therapeutic purposes based on the rehabilitation goals. Physical aspects of music
            therapy may involve movement in response to the music, playing musical instruments, or singing. On the
            other hand, using music therapy for emotional purposes entails listening to music and engaging in
            activities that promote emotional well-being.
        </p>
    </div>
</section>

<div class="container">
    <div class="card" style="opacity: 1;">
        <img src="assets/images/music.png" alt="Music Selection Icon">
        <h3>Music Selection</h3>
        <p>Choose from a variety of music genres and styles to create your personalized therapeutic experience.</p>
    </div>
    <div class="card" style="opacity: 1;">
        <img src="assets/images/dial.png" alt="Mood Enhancement Icon">
        <h3>Mood Enhancement</h3>
        <p>Enhance your mood by selecting music that matches your emotions and feelings.</p>
    </div>
    <div class="card" style="opacity: 1;">
        <img src="assets/images/relacsation.png" alt="Relaxation Icon">
        <h3>Relaxation</h3>
        <p>Immerse yourself in calming melodies to unwind, reduce stress, and find tranquility.</p>
    </div>
</div>

<section class="section2">
    <h2>Music Therapy and Composers</h2>
    <p>Learn about the role of music therapy in healing and relaxation. Discover how famous composers like Beethoven
        utilized the power of music to overcome challenges and inspire others.</p>
    <button>LISTEN TO MUSIC</button>
</section>
@endsection

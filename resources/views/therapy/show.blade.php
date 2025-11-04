@extends('layouts.master2')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/admin/therapy-show-page.css') }}">
@endpush

@section('content')
<div class="admin-page-container">
    <!-- Page Header -->
    <div class="page-header">
        <div class="header-content">
            <div class="header-info">
                <h1 class="page-title">{{ $therapy->name }}</h1>
                <p class="page-subtitle">Therapy Session Details</p>
            </div>
            <div class="header-actions">
                <a href="{{ route('therapy.index') }}" class="btn-secondary">
                    <svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20">
                        <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/>
                    </svg>
                    Back to Therapies
                </a>
                @role('Admin|Doctor')
                    <a href="{{ route('therapy.edit', $therapy) }}" class="btn-primary">
                        <svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20">
                            <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/>
                        </svg>
                        Edit Therapy
                    </a>
                @endrole
            </div>
        </div>
    </div>

    <!-- Therapy Details -->
    <div class="therapy-details-container">
        <div class="therapy-card-large">
            <!-- Therapy Header -->
            <div class="therapy-header">
                <div class="therapy-image">
                    @if($therapy->image)
                        <img src="{{ Storage::url($therapy->image) }}" alt="{{ $therapy->name }}" class="therapy-thumbnail">
                    @else
                        <div class="therapy-placeholder">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                            </svg>
                        </div>
                    @endif
                </div>
                <div class="therapy-info">
                    <h2 class="therapy-title">{{ $therapy->name }}</h2>
                    <div class="therapy-meta">
                        <div class="meta-item">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2C13.1 2 14 2.9 14 4C14 5.1 13.1 6 12 6C10.9 6 10 5.1 10 4C10 2.9 10.9 2 12 2ZM21 9V7L15 7.5V9M21 11H15V13H21V11ZM21 15H15V17H21V15ZM9 8C9.5 8 10 8.5 10 9V22H8V18H4V22H2V9C2 8.5 2.5 8 3 8H9ZM8 10H4V16H8V10Z"/>
                            </svg>
                            <span>Dr. {{ $therapy->user->name }}</span>
                        </div>
                        <div class="meta-item">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                            </svg>
                            <span>{{ $therapy->album->name }}</span>
                        </div>
                        <div class="meta-item">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7z"/>
                            </svg>
                            <span>Created {{ $therapy->created_at->format('M d, Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Audio Player Section -->
            @if($therapy->file)
                <div class="audio-section">
                    <h3 class="section-title">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 3v10.55c-.59-.34-1.27-.55-2-.55-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4V7h4V3h-6z"/>
                        </svg>
                        Audio Therapy Session
                    </h3>
                    <div class="audio-player-container">
                        <audio id="therapy-audio" controls preload="metadata" style="width: 100%;">
                            <source src="{{ route('therapy.audio', $therapy->id) }}" type="audio/mpeg">
                            <source src="{{ route('therapy.audio', $therapy->id) }}" type="audio/mp3">
                            <source src="{{ route('therapy.audio', $therapy->id) }}" type="audio/wav">
                            Your browser does not support the audio element.
                        </audio>
                    </div>
                    <div class="audio-info">
                        <div class="audio-details">
                            <span class="audio-name">{{ $therapy->name }}</span>
                            <span class="audio-separator">•</span>
                            <span class="audio-type">Audio Therapy</span>
                        </div>
                        <div class="audio-actions">
                            <button id="play-pause-btn" class="audio-btn" onclick="togglePlayPause()">
                                <svg id="play-icon" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M8 5v14l11-7z"/>
                                </svg>
                                <svg id="pause-icon" viewBox="0 0 24 24" fill="currentColor" style="display: none;">
                                    <path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/>
                                </svg>
                            </button>
                            <button id="stop-btn" class="audio-btn" onclick="stopAudio()">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M6 6h12v12H6z"/>
                                </svg>
                            </button>
                            <button id="volume-btn" class="audio-btn" onclick="toggleMute()">
                                <svg id="volume-on-icon" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02zM14 3.23v2.06c2.89.86 5 3.54 5 6.71s-2.11 5.85-5 6.71v2.06c4.01-.91 7-4.49 7-8.77s-2.99-7.86-7-8.77z"/>
                                </svg>
                                <svg id="volume-off-icon" viewBox="0 0 24 24" fill="currentColor" style="display: none;">
                                    <path d="M16.5 12c0-1.77-1.02-3.29-2.5-4.03v2.21l2.45 2.45c.03-.2.05-.41.05-.63zm2.5 0c0 .94-.2 1.82-.54 2.64l1.51 1.51C20.63 14.91 21 13.5 21 12c0-4.28-2.99-7.86-7-8.77v2.06c2.89.86 5 3.54 5 6.71zM4.27 3L3 4.27 7.73 9H3v6h4l5 5v-6.73l4.25 4.25c-.67.52-1.42.93-2.25 1.18v2.06c1.38-.31 2.63-.95 3.69-1.81L19.73 21 21 19.73l-9-9L4.27 3zM12 4L9.91 6.09 12 8.18V4z"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            @else
                <div class="no-audio-section">
                    <div class="no-audio-icon">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 3v10.55c-.59-.34-1.27-.55-2-.55-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4V7h4V3h-6z"/>
                        </svg>
                    </div>
                    <h3>No Audio Available</h3>
                    <p>This therapy session doesn't have an audio file attached.</p>
                </div>
            @endif

            <!-- Therapy Description -->
            <div class="therapy-description">
                <h3 class="section-title">About This Therapy</h3>
                <p>{{ $therapy->description ?? 'This is a professional therapy session designed to help you achieve your mental health goals. The audio content has been carefully crafted by our experienced therapists to provide effective therapeutic support.' }}</p>
            </div>

            <!-- Associated Patients -->
            @if($therapy->patients->count() > 0)
                <div class="associated-patients">
                    <h3 class="section-title">Associated Patients</h3>
                    <div class="patients-list">
                        @foreach($therapy->patients as $patient)
                            <div class="patient-item">
                                <div class="patient-avatar">
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                    </svg>
                                </div>
                                <div class="patient-info">
                                    <span class="patient-name">{{ $patient->first_name }} {{ $patient->last_name }}</span>
                                    <span class="patient-email">{{ $patient->email }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
let audio = document.getElementById('therapy-audio');
let playPauseBtn = document.getElementById('play-pause-btn');
let playIcon = document.getElementById('play-icon');
let pauseIcon = document.getElementById('pause-icon');
let stopBtn = document.getElementById('stop-btn');
let volumeBtn = document.getElementById('volume-btn');
let volumeOnIcon = document.getElementById('volume-on-icon');
let volumeOffIcon = document.getElementById('volume-off-icon');

function togglePlayPause() {
    if (audio.paused) {
        audio.play();
        playIcon.style.display = 'none';
        pauseIcon.style.display = 'block';
    } else {
        audio.pause();
        playIcon.style.display = 'block';
        pauseIcon.style.display = 'none';
    }
}

function stopAudio() {
    audio.pause();
    audio.currentTime = 0;
    playIcon.style.display = 'block';
    pauseIcon.style.display = 'none';
}

function toggleMute() {
    if (audio.muted) {
        audio.muted = false;
        volumeOnIcon.style.display = 'block';
        volumeOffIcon.style.display = 'none';
    } else {
        audio.muted = true;
        volumeOnIcon.style.display = 'none';
        volumeOffIcon.style.display = 'block';
    }
}

// Update play/pause button when audio state changes
audio.addEventListener('play', function() {
    playIcon.style.display = 'none';
    pauseIcon.style.display = 'block';
});

audio.addEventListener('pause', function() {
    playIcon.style.display = 'block';
    pauseIcon.style.display = 'none';
});

// Update volume button when audio is muted/unmuted
audio.addEventListener('volumechange', function() {
    if (audio.muted) {
        volumeOnIcon.style.display = 'none';
        volumeOffIcon.style.display = 'block';
    } else {
        volumeOnIcon.style.display = 'block';
        volumeOffIcon.style.display = 'none';
    }
});

// Handle audio loading errors
audio.addEventListener('error', function(e) {
    console.error('Audio loading error:', e);
    alert('There was an error loading the audio file. Please check if the file exists and try again.');
});
</script>
@endsection

@extends('layouts.master2')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/admin/therapy-create-page.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css">
@endpush

@section('content')
    @php
        $backRoute = Route::has('therapy.index') ? route('therapy.index') : url()->previous();
        $currentLocale = app()->getLocale();
    @endphp

    <div class="therapy-management-content therapy-create-page therapy-create-page--admin">
        <div class="page-header">
            <div class="header-content">
                <div class="header-info">
                    <h1 class="page-title">{{ __('site.Create') }} {{ __('site.therapy') }}</h1>
                    <p class="page-subtitle">{{ __('Launch a new therapy session with artwork and audio aligned to the admin experience.') }}</p>
                </div>
                <div class="header-actions">
                    <a href="{{ $backRoute }}" class="header-btn ghost-btn">
                        @if ($currentLocale === 'ar')
                            <span>{{ __('site.Go Back') }}</span>
                            <i class="fas fa-long-arrow-alt-right" aria-hidden="true"></i>
                        @else
                            <i class="fas fa-long-arrow-alt-left" aria-hidden="true"></i>
                            <span>{{ __('site.Go Back') }}</span>
                        @endif
                    </a>
                </div>
            </div>
            <div class="header-meta">
                <span class="meta-chip">{{ __('Admin Session') }}</span>
                <span class="meta-chip">{{ __('Fresh Upload') }}</span>
            </div>
        </div>

        <div class="insight-banner">
            <div class="insight-card">
                <div class="insight-icon">
                    <i class="fas fa-photo-video" aria-hidden="true"></i>
                </div>
                <div>
                    <h3>{{ __('Keep artwork consistent') }}</h3>
                    <p>{{ __('Upload a polished square image so therapists and patients recognise the session immediately.') }}</p>
                </div>
            </div>
            <div class="insight-card">
                <div class="insight-icon">
                    <i class="fas fa-wave-square" aria-hidden="true"></i>
                </div>
                <div>
                    <h3>{{ __('Optimise audio quality') }}</h3>
                    <p>{{ __('Stick to clear narration under 100MB to keep streaming reliable across all devices.') }}</p>
                </div>
            </div>
            <div class="insight-card">
                <div class="insight-icon">
                    <i class="fas fa-layer-group" aria-hidden="true"></i>
                </div>
                <div>
                    <h3>{{ __('Build a clear library') }}</h3>
                    <p>{{ __('Albums act as playlists—confirm the grouping so team members can find sessions fast.') }}</p>
                </div>
            </div>
        </div>

        <div class="form-wrapper">
            <form action="{{ route('admin_therapy_store') }}" method="post" enctype="multipart/form-data" class="therapy-create-form">
                @csrf

                <div class="form-shell">
                    <section class="form-panel media-panel">
                        <header class="panel-header">
                            <h2>{{ __('Visual identity') }}</h2>
                            <p>{{ __('Set the hero artwork patients will see before they play this session.') }}</p>
                        </header>

                        <div class="media-grid">
                            <label for="image-upload" class="image-dropzone" id="thumbnail-dropzone">
                                <input type="file" id="image-upload" name="image" accept="image/*" onchange="showPreview(event)" hidden>
                                <div class="preview-frame" data-empty="true">
                                    <img id="image-preview" src="https://placehold.co/300x300?text=Therapy" alt="{{ __('Therapy placeholder artwork') }}">
                                    <span class="preview-placeholder">{{ __('Tap to upload') }}</span>
                                </div>
                                <div class="dropzone-text">
                                    <strong>{{ __('Upload thumbnail') }}</strong>
                                    <span>{{ __('site.Set the Therapy thumbnail image. Only *.png, *.jpg, and *.jpeg image files are accepted') }}</span>
                                </div>
                            </label>

                            <ul class="upload-guidelines">
                                <li>{{ __('Use a 1:1 aspect ratio image for best display.') }}</li>
                                <li>{{ __('Keep designs bright and legible to stand out in patient dashboards.') }}</li>
                                <li>{{ __('Accepted formats: PNG or JPG up to 5MB.') }}</li>
                            </ul>
                        </div>
                    </section>

                    <section class="form-panel content-panel">
                        <header class="panel-header">
                            <h2>{{ __('Session details') }}</h2>
                            <p>{{ __('Give the session a meaningful title and place it inside the right album.') }}</p>
                        </header>

                        <div class="section-block">
                            <div class="section-heading">
                                <h3>{{ __('Audience') }}</h3>
                                <p>{{ __('You can assign the therapy to patients later from the therapy management area.') }}</p>
                            </div>

                            <div class="input-grid">
                                <div class="input-group">
                                    <label>{{ __('site.Patient Name') }}</label>
                                    <p class="static-value empty">{{ __('site.Create by Admin, No Patient Available') }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="section-block">
                            <div class="section-heading">
                                <h3>{{ __('File information') }}</h3>
                                <p>{{ __('Name the file clearly and choose or create an album for easy discovery.') }}</p>
                            </div>

                            <div class="input-grid two-col">
                                <div class="input-group">
                                    <label for="file-name">{{ __('site.File Name') }}</label>
                                    <input type="text" id="file-name" class="form-input" name="name" placeholder="{{ __('e.g. Morning Reset Session') }}" required>
                                </div>

                                <div class="input-group">
                                    <label for="album-select">{{ __('site.Select or Create Album') }}</label>
                                    <select id="album-select" class="form-input select2" name="album_name" style="width: 100%;" required>
                                        <option value="">{{ __('site.Search or Create Album') }}</option>
                                        @foreach ($albums as $album)
                                            <option value="{{ $album->name }}">{{ $album->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="section-block">
                            <div class="section-heading">
                                <h3>{{ __('Audio upload') }}</h3>
                                <p>{{ __('Upload the guided audio and review the preview before publishing.') }}</p>
                            </div>

                            <div class="input-grid">
                                <div class="input-group">
                                    <label for="file-upload">{{ __('site.Upload Audio File') }}</label>
                                    <input type="file" class="form-input" name="file" id="file-upload" accept="audio/mp3,audio/wav,audio/mpeg" onchange="previewAudio(event)" required>
                                    <div id="file-size-warning" class="warning-banner" hidden></div>
                                    <div id="audio-preview-card" class="audio-preview-card is-hidden">
                                        <span class="preview-label">{{ __('site.Audio Preview') }}</span>
                                        <div class="audio-player-container">
                                            <audio id="audio-preview" controls>
                                                {{ __('Your browser does not support the audio element.') }}
                                            </audio>
                                        </div>
                                        <div class="audio-info">
                                            <span id="audio-file-name"></span>
                                            <span id="audio-file-size"></span>
                                            <span id="audio-duration"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>

                <div class="action-bar">
                    <a href="{{ $backRoute }}" class="header-btn ghost-btn">{{ __('site.Cancel') }}</a>
                    <button type="submit" class="header-btn primary-btn">
                        <i class="fas fa-check" aria-hidden="true"></i>
                        <span>{{ __('site.Create') }}</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<script>
    const placeholderImage = 'https://placehold.co/300x300?text=Therapy';

    function showPreview(event) {
        const file = event.target.files[0];
        const previewImage = document.getElementById('image-preview');
        const dropzone = document.getElementById('thumbnail-dropzone');
        const previewFrame = dropzone ? dropzone.querySelector('.preview-frame') : null;

        if (!previewImage || !previewFrame) {
            return;
        }

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result;
                previewFrame.dataset.empty = 'false';
                dropzone.classList.add('has-image');
            };
            reader.readAsDataURL(file);
        } else {
            previewImage.src = placeholderImage;
            previewFrame.dataset.empty = 'true';
            dropzone.classList.remove('has-image');
        }
    }

    function previewAudio(event) {
        const file = event.target.files[0];
        const audioPreviewCard = document.getElementById('audio-preview-card');
        const audioPreview = document.getElementById('audio-preview');
        const fileNameSpan = document.getElementById('audio-file-name');
        const fileSizeSpan = document.getElementById('audio-file-size');
        const durationSpan = document.getElementById('audio-duration');
        const warningBanner = document.getElementById('file-size-warning');

        if (!audioPreviewCard || !audioPreview || !fileNameSpan || !fileSizeSpan || !warningBanner) {
            return;
        }

        if (!file) {
            audioPreviewCard.classList.add('is-hidden');
            audioPreview.removeAttribute('src');
            audioPreview.load();
            fileNameSpan.textContent = '';
            fileSizeSpan.textContent = '';
            durationSpan.textContent = '';
            warningBanner.hidden = true;
            warningBanner.textContent = '';
            return;
        }

        const maxSize = 100 * 1024 * 1024;
        if (file.size > maxSize) {
            alert('File size is too large! Maximum allowed size is 100MB. Your file is ' + formatFileSize(file.size) + '. Please compress your audio file or choose a smaller file.');
            event.target.value = '';
            audioPreviewCard.classList.add('is-hidden');
            audioPreview.removeAttribute('src');
            audioPreview.load();
            fileNameSpan.textContent = '';
            fileSizeSpan.textContent = '';
            durationSpan.textContent = '';
            warningBanner.hidden = true;
            warningBanner.textContent = '';
            return;
        }

        if (file.size > 50 * 1024 * 1024) {
            warningBanner.hidden = false;
            warningBanner.innerHTML = `⚠️ <strong>Large File Warning:</strong> ${formatFileSize(file.size)}. {{ __('Upload may take longer. Consider compressing your audio for better performance.') }}`;
        } else {
            warningBanner.hidden = true;
            warningBanner.textContent = '';
        }

        const audioURL = URL.createObjectURL(file);
        audioPreview.src = audioURL;
        audioPreview.load();
        audioPreview.onloadedmetadata = function() {
            durationSpan.textContent = formatDuration(audioPreview.duration);
        };

        fileNameSpan.textContent = file.name;
        fileSizeSpan.textContent = formatFileSize(file.size);
        audioPreviewCard.classList.remove('is-hidden');
    }

    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    function formatDuration(seconds) {
        if (!seconds && seconds !== 0) {
            return '';
        }
        const minutes = Math.floor(seconds / 60);
        const remainingSeconds = Math.floor(seconds % 60);
        return minutes + ':' + (remainingSeconds < 10 ? '0' : '') + remainingSeconds;
    }

    $(document).ready(function() {
        const albumSelect = $('#album-select');
        if (albumSelect.length) {
            albumSelect.select2({
                tags: true,
                placeholder: "{{ __('site.Search or Create Album') }}",
                allowClear: true,
                width: '100%',
                createTag: function(params) {
                    const term = $.trim(params.term);
                    if (term === '') {
                        return null;
                    }

                    return {
                        id: term,
                        text: term,
                    };
                },
                insertTag: function(data, tag) {
                    data.push(tag);
                }
            });
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('.therapy-create-form');
        if (!form) {
            return;
        }

        const requiredInputs = form.querySelectorAll('.form-input[required]');

        requiredInputs.forEach(function(input) {
            input.addEventListener('blur', function() {
                if (input.value.trim() !== '') {
                    input.classList.remove('error');
                    input.classList.add('success');
                } else {
                    input.classList.remove('success');
                }
            });
        });

        form.addEventListener('submit', function(event) {
            let isValid = true;

            requiredInputs.forEach(function(input) {
                if (input.value.trim() === '') {
                    input.classList.add('error');
                    isValid = false;
                }
            });

            if (!isValid) {
                event.preventDefault();
                const firstInvalid = form.querySelector('.form-input.error');
                if (firstInvalid) {
                    firstInvalid.focus({ preventScroll: true });
                    firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            }
        });
    });
</script>

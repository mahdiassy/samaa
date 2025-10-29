@extends('layouts.master2')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/admin/therapy-edit-page.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css">
@endpush

@section('content')
    @php
        $backRoute = Route::has('therapy.index') ? route('therapy.index') : url()->previous();
        $viewRoute = Route::has('therapy.show') ? route('therapy.show', $therapy) : null;
        $currentLocale = app()->getLocale();
        $patient = $therapy->patients->first();
        $albumName = optional($therapy->album)->name;
        $lastUpdated = $therapy->updated_at ? $therapy->updated_at->timezone(config('app.timezone', 'UTC'))->format('d M Y') : null;
        $audioRoute = route('therapy.audio', $therapy->id);
    @endphp

    <div class="therapy-management-content therapy-edit-page">
        <div class="page-header">
            <div class="header-content">
                <div class="header-info">
                    <h1 class="page-title">{{ __('site.Update') }} {{ __('site.therapy') }}</h1>
                    <p class="page-subtitle">{{ __('Refresh audio resources and visuals so patients always receive the most relevant support material.') }}</p>
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
                    @if ($viewRoute)
                        <a href="{{ $viewRoute }}" class="header-btn secondary-btn">
                            <i class="fas fa-eye" aria-hidden="true"></i>
                            <span>{{ __('site.View') }}</span>
                        </a>
                    @endif
                </div>
            </div>
            <div class="header-meta">
                <span class="meta-chip">{{ __('site.ID') }} #{{ $therapy->id }}</span>
                @if ($patient)
                    <span class="meta-chip">{{ __('site.Patient Name') }}: {{ $patient->first_name }} {{ $patient->last_name }}</span>
                @endif
                @if ($albumName)
                    <span class="meta-chip">{{ __('Album') }}: {{ $albumName }}</span>
                @endif
                @if ($lastUpdated)
                    <span class="meta-chip">{{ $lastUpdated }}</span>
                @endif
            </div>
        </div>

        <div class="insight-banner">
            <div class="insight-card">
                <div class="insight-icon">
                    <i class="fas fa-headphones" aria-hidden="true"></i>
                </div>
                <div>
                    <h3>{{ __('Keep sessions relevant') }}</h3>
                    <p>{{ __('Upload refreshed audio to reflect new protocols or patient milestones.') }}</p>
                </div>
            </div>
            <div class="insight-card">
                <div class="insight-icon">
                    <i class="fas fa-image" aria-hidden="true"></i>
                </div>
                <div>
                    <h3>{{ __('Strengthen engagement') }}</h3>
                    <p>{{ __('High quality artwork helps patients recognise the session instantly in their library.') }}</p>
                </div>
            </div>
        </div>

        <div class="form-wrapper">
            <form action="{{ route('therapy.update', $therapy) }}" method="POST" enctype="multipart/form-data" class="therapy-edit-form">
                @csrf
                @method('PUT')

                <div class="form-shell">
                    <section class="form-panel content-panel">
                        <header class="panel-header">
                            <h2>{{ __('Session Details') }}</h2>
                            <p>{{ __('Rename the file, update album placement, or refresh associated audio in one step.') }}</p>
                        </header>

                        <div class="section-block">
                            <div class="section-heading">
                                <h3>{{ __('Assignment') }}</h3>
                                <p>{{ __('Confirm the patient this therapy belongs to and keep their record linked.') }}</p>
                            </div>

                            <div class="input-grid">
                                @if ($patient)
                                    <input value="{{ $patient->id }}" class="form-input" name="patient_id" hidden required>
                                    <div class="input-group">
                                        <label>{{ __('site.Patient Name') }}</label>
                                        <p class="static-value">{{ $patient->first_name }} {{ $patient->last_name }}</p>
                                    </div>
                                @else
                                    <div class="input-group">
                                        <label>{{ __('site.Patient Name') }}</label>
                                        <p class="static-value empty">{{ __('site.Create by Admin, No Patient Available') }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="section-block">
                            <div class="section-heading">
                                <h3>{{ __('File information') }}</h3>
                                <p>{{ __('Keep titles short and descriptive so they are easy to search.') }}</p>
                            </div>

                            <div class="input-grid two-col">
                                <div class="input-group">
                                    <label for="filename">{{ __('site.File Name') }}</label>
                                    <input class="form-input" id="filename" name="name" type="text" value="{{ $therapy->name }}">
                                </div>

                                <div class="input-group">
                                    <label for="album-select">{{ __('site.Select or Create Album') }}</label>
                                    <select id="album-select" class="form-input select2" name="album_name" style="width: 100%;">
                                        <option value="">{{ __('site.Search or Create Album') }}</option>
                                        @foreach($albums as $album)
                                            <option value="{{ $album->name }}" @selected($album->name === $albumName)>
                                                {{ $album->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="section-block">
                            <div class="section-heading">
                                <h3>{{ __('Audio management') }}</h3>
                                <p>{{ __('Replace or review the therapy audio without losing track of the current file.') }}</p>
                            </div>

                            <div class="input-grid two-col">
                                <div class="input-group">
                                    <label for="audioFile">{{ __('site.Edit Audio (optional)') }}</label>
                                    <input type="file" class="form-input" id="audioFile" name="file" accept="audio/mp3,audio/wav,audio/mpeg" onchange="previewNewAudio(event)">
                                    <div id="new-audio-preview-container" class="audio-preview-card is-hidden">
                                        <span class="preview-label">{{ __('site.New Audio Preview') }}</span>
                                        <div class="audio-player-container">
                                            <audio id="new-audio-preview" controls>
                                                {{ __('Your browser does not support the audio element.') }}
                                            </audio>
                                        </div>
                                        <div class="audio-info">
                                            <span id="new-audio-file-name"></span>
                                            <span id="new-audio-file-size"></span>
                                            <span id="new-audio-duration"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="input-group">
                                    <label for="current-audio">{{ __('site.Current Audio') }}</label>
                                    <div class="audio-preview-card current">
                                        <div class="audio-player-container">
                                            <audio id="current-audio" controls preload="metadata">
                                                <source src="{{ $audioRoute }}" type="audio/mpeg">
                                                <source src="{{ $audioRoute }}" type="audio/mp3">
                                                <source src="{{ $audioRoute }}" type="audio/wav">
                                                {{ __('Your browser does not support the audio element.') }}
                                            </audio>
                                        </div>
                                        <div class="audio-info">
                                            <span>{{ $therapy->name }}</span>
                                            <span>{{ __('site.Current Audio') }}</span>
                                        </div>
                                        <div id="audio-error" class="error-banner" hidden>
                                            {{ __('Error loading audio file. Please check if the file exists.') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>

                <div class="action-bar">
                    <a href="{{ $backRoute }}" class="header-btn ghost-btn">
                        {{ __('site.Cancel') }}
                    </a>
                    <button class="header-btn primary-btn" type="submit">
                        <i class="fas fa-save" aria-hidden="true"></i>
                        <span>{{ __('site.Update') }}</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<script>
    function previewNewAudio(event) {
        var file = event.target.files[0];
        var audioPreviewContainer = document.getElementById('new-audio-preview-container');
        var audioPreview = document.getElementById('new-audio-preview');
        var audioFileName = document.getElementById('new-audio-file-name');
        var audioFileSize = document.getElementById('new-audio-file-size');
        var audioDuration = document.getElementById('new-audio-duration');
        var warningDiv = document.getElementById('new-file-size-warning');

        if (!file) {
            if (audioPreviewContainer) {
                audioPreviewContainer.classList.add('is-hidden');
            }
            if (warningDiv) {
                warningDiv.remove();
            }
            if (audioPreview) {
                audioPreview.removeAttribute('src');
                audioPreview.load();
            }
            if (audioFileName) audioFileName.textContent = '';
            if (audioFileSize) audioFileSize.textContent = '';
            if (audioDuration) audioDuration.textContent = '';
            return;
        }

        var maxSize = 100 * 1024 * 1024;
        if (file.size > maxSize) {
            alert('File size is too large! Maximum allowed size is 100MB. Your file is ' + formatFileSize(file.size) + '. Please compress your audio file or choose a smaller file.');
            event.target.value = '';
            if (audioPreviewContainer) {
                audioPreviewContainer.classList.add('is-hidden');
            }
            if (warningDiv) {
                warningDiv.remove();
            }
            return;
        }

        if (file.size > 50 * 1024 * 1024) {
            if (!warningDiv) {
                warningDiv = document.createElement('div');
                warningDiv.id = 'new-file-size-warning';
                warningDiv.className = 'warning-banner';
                warningDiv.innerHTML = '⚠️ <strong>Large File Warning:</strong> ' + formatFileSize(file.size) + '. Upload may take longer. Consider compressing your audio for better performance.';
                audioPreviewContainer.parentNode.insertBefore(warningDiv, audioPreviewContainer);
            } else {
                warningDiv.innerHTML = '⚠️ <strong>Large File Warning:</strong> ' + formatFileSize(file.size) + '. Upload may take longer. Consider compressing your audio for better performance.';
            }
        } else if (warningDiv) {
            warningDiv.remove();
        }

        if (audioPreviewContainer) {
            audioPreviewContainer.classList.remove('is-hidden');
        }
        var audioURL = URL.createObjectURL(file);
        if (audioPreview) {
            audioPreview.src = audioURL;
            audioPreview.load();
            audioPreview.onloadedmetadata = function() {
                if (audioDuration) {
                    audioDuration.textContent = formatDuration(audioPreview.duration);
                }
            };
        }
        if (audioFileName) {
            audioFileName.textContent = file.name;
        }
        if (audioFileSize) {
            audioFileSize.textContent = formatFileSize(file.size);
        }
    }

    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        var k = 1024;
        var sizes = ['Bytes', 'KB', 'MB', 'GB'];
        var i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    function formatDuration(seconds) {
        if (!seconds && seconds !== 0) {
            return '';
        }
        var minutes = Math.floor(seconds / 60);
        var remainingSeconds = Math.floor(seconds % 60);
        return minutes + ':' + (remainingSeconds < 10 ? '0' : '') + remainingSeconds;
    }

    $(document).ready(function() {
        var albumSelect = $('#album-select');
        if (albumSelect.length) {
            albumSelect.select2({
                tags: true,
                placeholder: "{{ __('site.Search or Create Album') }}",
                allowClear: true,
                width: '100%',
                createTag: function(params) {
                    var term = $.trim(params.term);
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

        var currentAudio = document.getElementById('current-audio');
        var audioError = document.getElementById('audio-error');
        if (currentAudio && audioError) {
            currentAudio.addEventListener('error', function() {
                audioError.hidden = false;
            });

            currentAudio.addEventListener('loadedmetadata', function() {
                audioError.hidden = true;
            });
        }
    });
</script>
@endpush

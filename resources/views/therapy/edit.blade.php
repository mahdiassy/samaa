@extends('layouts.master2')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/admin/therapy-create-page.css') }}">
@endpush

@section('content')
    @include('search_form_with_backbround')
    <div class="therapy-management-content">

        <div class="header">
            <a href="{{ route('therapy.index') }}" class="btn-back">
                @if(App::getLocale() == 'ar')
                <i class="fas fa-long-arrow-alt-right" aria-hidden="true"></i> {{ __('site.Go Back') }}
                @else
                <i class="fas fa-long-arrow-alt-left" aria-hidden="true"></i> {{ __('site.Go Back') }}
                @endif
            </a>
        </div>
        <section class="users-view">
            <form action="{{ route('therapy.update', $therapy) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="custom-card-content">
                    <div class="form-section">
                        <!-- Image Upload Section -->
                        <div class="image-upload-wrapper">
                            <input type="file" id="image-upload" name="image" accept="image/*"
                                value="{{ $therapy->image }}" onchange="showPreview(event)" style="display:none;">
                            <label for="image-upload" class="upload-label">
                                <div class="image-placeholder">
                                    <img id="image-preview" src="{{ Storage::url($therapy->image) }}" alt="Placeholder"
                                        class="placeholder-img">
                                    <div class="edit-icon">
                                        <img src="https://img.icons8.com/ios-filled/30/000000/edit.png" alt="Edit" />
                                    </div>
                                </div>
                            </label>
                            <p class="image-upload-instruction">{{ __('site.Set the Therapy thumbnail image. Only *.png, *.jpg, and *.jpeg image files are accepted') }}</p>
                        </div>

                        <!-- File Name and Patient Selection Row -->
                        <div class="input-row">
                            <div class="input-group">
                                <label for="users-movies-select2">{{ __('site.Patient Name') }}:</label>
                                @if($therapy->patients->isNotEmpty())
                                    <input value="{{ $therapy->patients->pluck('id')[0] }}" class="form-input" name="patient_id" hidden required>
                                    <h1>{{ $therapy->patients->pluck('first_name')[0] }}</h1>
                                @else
                                    <h1>{{ __('site.Create by Admin, No Patient Available') }}</h1>
                                @endif
                            </div>

                            <div class="input-group">
                                <label for="filename">{{ __('site.File Name') }}:</label>
                                <input class="form-input" id="filename" name="name" type="text"
                                    value="{{ $therapy->name }}">
                            </div>
                        </div>

                        <!-- Audio Edit and Old Audio Section -->
                        <div class="input-row">
                            <div class="input-group">
                                <label for="audioFile">{{ __('site.Edit Audio (optional)') }}:</label>
                                <input type="file" class="form-input" id="audioFile" name="file" accept="audio/mp3,audio/wav,audio/mpeg" onchange="previewNewAudio(event)">
                                <div id="new-audio-preview-container" style="display: none; margin-top: 10px;">
                                    <label>{{ __('site.New Audio Preview') }}</label>
                                    <div class="audio-player-container">
                                        <audio id="new-audio-preview" controls style="width: 100%;">
                                            Your browser does not support the audio element.
                                        </audio>
                                    </div>
                                    <div class="audio-info" style="margin-top: 5px; font-size: 12px; color: #666;">
                                        <span id="new-audio-file-name"></span> | <span id="new-audio-file-size"></span> | <span id="new-audio-duration"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="input-group">
                                <label for="oldAudio">{{ __('site.Current Audio') }}:</label>
                                <div>
                                    <audio id="current-audio" controls preload="metadata" style="width: 100%;">
                                        <source src="{{ route('therapy.audio', $therapy->id) }}" type="audio/mpeg">
                                        <source src="{{ route('therapy.audio', $therapy->id) }}" type="audio/mp3">
                                        <source src="{{ route('therapy.audio', $therapy->id) }}" type="audio/wav">
                                        Your browser does not support the audio element.
                                    </audio>
                                    <div class="audio-info" style="margin-top: 5px; font-size: 12px; color: #666;">
                                        {{ $therapy->name }} | {{ __('site.Current Audio') }}
                                    </div>
                                    <div id="audio-error" style="display: none; color: #dc2626; font-size: 12px; margin-top: 5px;">
                                        Error loading audio file. Please check if the file exists.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="input-row">
                            <div class="input-group">
                                <label for="album-select">{{ __('site.Select or Create Album') }}</label>
                                <select id="album-select" class="form-control select2" name="album_name" style="width: 100%;">
                                    <option value="">{{ __('site.Search or Create Album') }}</option>
                                    @foreach($albums as $album)
                                        <option value="{{ $album->name }}"
                                            @if($album->name == $therapy->album->name) selected @endif>
                                            {{ $album->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Buttons Section -->
                <div class="action-buttons">
                    <button class="btn patient-btn">{{ __('site.Update') }}</button>
                </div>
            </form>
        </section>
    </div>
@endsection
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

<script>
    function showPreview(event) {
        var file = event.target.files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                var imgElement = document.getElementById('image-preview');
                imgElement.src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    }

    function previewNewAudio(event) {
        var file = event.target.files[0];
        var audioPreviewContainer = document.getElementById('new-audio-preview-container');
        var audioPreview = document.getElementById('new-audio-preview');
        var audioFileName = document.getElementById('new-audio-file-name');
        var audioFileSize = document.getElementById('new-audio-file-size');
        var audioDuration = document.getElementById('new-audio-duration');

        if (file) {
            // Check file size (100MB limit)
            var maxSize = 100 * 1024 * 1024; // 100MB in bytes
            if (file.size > maxSize) {
                alert('File size is too large! Maximum allowed size is 100MB. Your file is ' + formatFileSize(file.size) + '. Please compress your audio file or choose a smaller file.');
                event.target.value = ''; // Clear the file input
                return;
            }
            
            // Show warning for large files (>50MB)
            if (file.size > 50 * 1024 * 1024) {
                var warningDiv = document.getElementById('new-file-size-warning');
                if (!warningDiv) {
                    warningDiv = document.createElement('div');
                    warningDiv.id = 'new-file-size-warning';
                    warningDiv.style.cssText = 'background: #fff3cd; border: 1px solid #ffeaa7; color: #856404; padding: 10px; margin: 10px 0; border-radius: 4px; font-size: 14px;';
                    warningDiv.innerHTML = '⚠️ <strong>Large File Warning:</strong> This file is ' + formatFileSize(file.size) + '. Upload may take longer. Consider compressing your audio for better performance.';
                    audioPreviewContainer.parentNode.insertBefore(warningDiv, audioPreviewContainer);
                }
            } else {
                // Remove warning if file is smaller
                var warningDiv = document.getElementById('new-file-size-warning');
                if (warningDiv) {
                    warningDiv.remove();
                }
            }
            
            // Show the preview container
            audioPreviewContainer.style.display = 'block';
            
            // Create object URL for the audio file
            var audioURL = URL.createObjectURL(file);
            audioPreview.src = audioURL;
            
            // Display file information
            audioFileName.textContent = file.name;
            audioFileSize.textContent = formatFileSize(file.size);
            
            // Get audio duration when loaded
            audioPreview.addEventListener('loadedmetadata', function() {
                audioDuration.textContent = formatDuration(audioPreview.duration);
            });
        } else {
            // Hide the preview container if no file selected
            audioPreviewContainer.style.display = 'none';
            // Remove warning
            var warningDiv = document.getElementById('new-file-size-warning');
            if (warningDiv) {
                warningDiv.remove();
            }
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
        var minutes = Math.floor(seconds / 60);
        var remainingSeconds = Math.floor(seconds % 60);
        return minutes + ':' + (remainingSeconds < 10 ? '0' : '') + remainingSeconds;
    }

    $(document).ready(function() {
        $('#album-select').select2({
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

        // Handle audio loading errors
        const currentAudio = document.getElementById('current-audio');
        if (currentAudio) {
            currentAudio.addEventListener('error', function(e) {
                console.error('Audio loading error:', e);
                document.getElementById('audio-error').style.display = 'block';
            });

            currentAudio.addEventListener('loadedmetadata', function() {
                document.getElementById('audio-error').style.display = 'none';
            });
        }
    });
</script>

@extends('layouts.master2')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/admin/therapy-create-page.css') }}">
@endpush

@section('content')
    @include('search_form_with_backbround')
    <div class="therapy-management-content">
        <div class="header">
            <a href="javascript:void(0);" onclick="history.back();" class="btn-back">
                @if(App::getLocale() == 'ar')
                <i class="fas fa-long-arrow-alt-right" aria-hidden="true"></i> {{ __('site.Go Back') }}
                @else
                <i class="fas fa-long-arrow-alt-left" aria-hidden="true"></i> {{ __('site.Go Back') }}
                @endif
            </a>
        </div>
        <div class="users-list-filter">
            <form action="{{ route('therapy.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-section">
                    <div class="image-upload-wrapper">
                        <input type="file" id="image-upload" name="image" accept="image/*"
                            onchange="showPreview(event)" style="display:none;">
                        <label for="image-upload" class="upload-label">
                            <div class="image-placeholder">
                                <img id="image-preview" src="https://placehold.co/150x150" alt="Placeholder"
                                    class="placeholder-img">
                                <div class="edit-icon">
                                    <img src="https://img.icons8.com/ios-filled/30/000000/edit.png" alt="Edit" />
                                </div>
                            </div>
                        </label>
                        <p class="image-upload-instruction">{{ __('site.Set the Therapy thumbnail image. Only *.png, *.jpg, and *.jpeg image files are accepted') }}</p>
                    </div>
                    <div class="input-row">
                        <div class="input-group">
                            <input value="{{ $patient->id}}" class="form-input" name="patient_id" hidden required>
                            <h1>{{ $patient->first_name}}</h1>
                        </div>
                    </div>
                    <div class="input-row">
                        <div class="input-group">
                            <label for="file-name">{{ __('site.File Name') }}</label>
                            <input type="text" id="file-name" class="form-input" name="name" placeholder="{{ __('site.File Name') }}"
                                required>
                        </div>
                        <div class="input-group">
                            <label for="file-upload">{{ __('site.Upload Audio File') }}</label>
                            <input type="file" class="form-input" name="file" id="file-upload" accept="audio/mp3,audio/wav,audio/mpeg" onchange="previewAudio(event)" required>
                            <div id="audio-preview-container" style="display: none; margin-top: 10px;">
                                <label>{{ __('site.Audio Preview') }}:</label>
                                <div class="audio-player-container">
                                    <audio id="audio-preview" controls style="width: 100%;">
                                        Your browser does not support the audio element.
                                    </audio>
                                </div>
                                <div class="audio-info" style="margin-top: 5px; font-size: 12px; color: #666;">
                                    <span id="audio-file-name"></span> | <span id="audio-file-size"></span> | <span id="audio-duration"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="input-row">
                        <div class="input-group">
                            <label for="album-select">{{ __('site.Search or Create Album') }}</label>
                            <select id="album-select" class="form-control select2" name="album_name" style="width: 100%;" required>
                                <option value="">{{ __('site.Search or Create Album') }}</option>
                                @foreach($albums as $album)
                                    <option value="{{ $album->name }}">{{ $album->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="action-buttons">
                        <button type="submit" class="btn patient-btn">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/>
                                <polyline points="17 21 17 13 7 13 7 21"/>
                                <polyline points="7 3 7 8 15 8"/>
                            </svg>
                            {{ __('site.Create') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
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

    function previewAudio(event) {
        var file = event.target.files[0];
        var audioPreviewContainer = document.getElementById('audio-preview-container');
        var audioPreview = document.getElementById('audio-preview');
        var audioFileName = document.getElementById('audio-file-name');
        var audioFileSize = document.getElementById('audio-file-size');
        var audioDuration = document.getElementById('audio-duration');

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
                var warningDiv = document.getElementById('file-size-warning');
                if (!warningDiv) {
                    warningDiv = document.createElement('div');
                    warningDiv.id = 'file-size-warning';
                    warningDiv.style.cssText = 'background: #fff3cd; border: 1px solid #ffeaa7; color: #856404; padding: 10px; margin: 10px 0; border-radius: 4px; font-size: 14px;';
                    warningDiv.innerHTML = '⚠️ <strong>Large File Warning:</strong> This file is ' + formatFileSize(file.size) + '. Upload may take longer. Consider compressing your audio for better performance.';
                    audioPreviewContainer.parentNode.insertBefore(warningDiv, audioPreviewContainer);
                }
            } else {
                // Remove warning if file is smaller
                var warningDiv = document.getElementById('file-size-warning');
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
            
            // Auto-play for testing (optional)
            // audioPreview.play();
        } else {
            // Hide the preview container if no file selected
            audioPreviewContainer.style.display = 'none';
            // Remove warning
            var warningDiv = document.getElementById('file-size-warning');
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
    });
</script>

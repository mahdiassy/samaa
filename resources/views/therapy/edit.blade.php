@extends('layouts.master2')
@section('content')
    @include('search_form_with_backbround')
    <div class="main-content">

        <div class="header">
            <a href="{{ route('therapy.index') }}" class="btn-back">
                @if (App::getLocale() == 'ar')
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
                                <input type="file" class="form-input" id="audioFile" name="file" accept="audio/mp3">
                            </div>
                            <div class="input-group">
                                <label for="oldAudio">{{ __('site.Old Audio') }}:</label>
                                <div>
                                    <audio controls>
                                        <source src="{{ Storage::url('Doctor therapy/' . decrypt($therapy->file)) }}"
                                            type="audio/mpeg">
                                        Your browser does not support the audio element.
                                    </audio>
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
                                            @if ($album->name == $therapy->album->name) selected @endif>
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

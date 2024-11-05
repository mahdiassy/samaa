@extends('layouts.master2')
@section('content')
    <div class="search-bar" style="background-image: url('/assets/images/therapy.png');">
        <input type="text" placeholder="Search...">
        <div class="search-bar-title">
            <h1>start your<br>music therapy</h1>
        </div>
    </div>
    <div class="main-content">

        <div class="header">
            <a href="{{ route('therapy.index') }}" class="btn-back">
                <i class="fas fa-long-arrow-alt-left" aria-hidden="true"></i> Go Back
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
                            <p class="image-upload-instruction">Set the Therapy thumbnail image. Only *.png, *.jpg, and
                                *.jpeg
                                image files are accepted.</p>
                        </div>

                        <!-- File Name and Patient Selection Row -->
                        <div class="input-row">
                            <div class="input-group">
                                <label for="users-movies-select2">Patient Name:</label>
                                <input value="{{ $therapy->patients->pluck('id')[0] }}" class="form-input" name="patient_id"
                                    hidden required>
                                <h1>{{ $therapy->patients->pluck('first_name')[0] }}</h1>
                            </div>
                            <div class="input-group">
                                <label for="filename">File Name:</label>
                                <input class="form-input" id="filename" name="name" type="text"
                                    value="{{ $therapy->name }}">
                            </div>
                        </div>

                        <!-- Audio Edit and Old Audio Section -->
                        <div class="input-row">
                            <div class="input-group">
                                <label for="audioFile">Edit Audio (optional):</label>
                                <input type="file" class="form-input" id="audioFile" name="file" accept="audio/mp3">
                            </div>
                            <div class="input-group">
                                <label for="oldAudio">Old Audio:</label>
                                <div>
                                    <audio controls>
                                        <source src="{{ Storage::url('Doctor therapy/' . decrypt($therapy->file)) }}"
                                            type="audio/mpeg">
                                        Your browser does not support the audio element.
                                    </audio>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Buttons Section -->
                <div class="action-buttons">
                    <button class="btn patient-btn">Update</button>
                </div>
            </form>
        </section>
    </div>
@endsection

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
</script>

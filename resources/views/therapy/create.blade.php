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
            <a href="javascript:void(0);" onclick="history.back();" class="btn-back">
                <i class="fas fa-long-arrow-alt-left" aria-hidden="true"></i> Go Back
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
                                <img id="image-preview" src="https://via.placeholder.com/150" alt="Placeholder"
                                    class="placeholder-img">
                                <div class="edit-icon">
                                    <img src="https://img.icons8.com/ios-filled/30/000000/edit.png" alt="Edit" />
                                </div>
                            </div>
                        </label>
                        <p class="image-upload-instruction">Set the Therapy thumbnail image. Only *.png, *.jpg, and *.jpeg
                            image
                            files are accepted</p>
                    </div>
                    <div class="input-row">
                        <div class="input-group">
                            <input value="{{$patient->id}}" class="form-input" name="patient_id" hidden required>
                            <h1>{{$patient->first_name}}</h1>
                        </div>
                    </div>
                    <div class="input-row">
                        <div class="input-group">
                            <label for="file-name">File Name</label>
                            <input type="text" id="file-name" class="form-input" name="name" placeholder="File Name"
                                required>
                        </div>
                        <div class="input-group">
                            <label for="file-upload">Upload File</label>
                            <input type="file" class="form-input" name="file" id="file-upload" accept="audio/mp3" required>
                        </div>
                    </div>

                    <div class="action-buttons">
                        <button type="submit" class="btn patient-btn">Create</button>
                    </div>
                </div>
            </form>
        </div>
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

@extends('layouts.master')
@section('content')
    <section class="users-view">
        <form action="{{ route('therapy.update', $therapy) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <!-- users view card data start -->
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="col-12 col-sm-12 col-lg-12 pb-3">
                                    <div class="image-upload-wrapper">
                                        <input type="file" id="image-upload" name="image" accept="image/*"
                                            value="{{ $therapy->image }}" onchange="showPreview(event)"
                                            style="display:none;">

                                        <!-- Placeholder and icon -->
                                        <label for="image-upload" class="upload-label">
                                            <div class="image-placeholder">
                                                <img id="image-preview" src="{{ Storage::url($therapy->image) }}"
                                                    alt="Placeholder" class="placeholder-img">
                                                <div class="edit-icon">
                                                    <img src="https://img.icons8.com/ios-filled/50/000000/edit.png"
                                                        alt="Edit" />
                                                </div>
                                            </div>
                                        </label>

                                        <p class="image-upload-instruction">Set the Therapy thumbnail image. Only *.png,
                                            *.jpg, and *.jpeg
                                            image files are accepted</p>
                                    </div>
                                </div>
                                <div class="row pb-3">
                                    <div class="col align-items-center">
                                        <label class="mr-3 mb-0 users-list-status pb-2" for="filename">File name:</label>
                                        <input class="form-control" id="filename" name="name" type="text"
                                            value="{{ $therapy->name }}">
                                    </div>
                                    <div class="col align-items-center">
                                        <label for="users-movies-select2" class="mr-3 mb-0 pb-2">Patients:</label>
                                        <select class="form-control" id="users-movies-select2" name="patient_id">
                                            @foreach ($patients as $patient)
                                                <option value="{{ $patient->id }}"
                                                    @if (in_array($patient->id, $therapy->patients->pluck('id')->toArray())) selected @endif>
                                                    {{ $patient->first_name }}
                                                </option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div>
                                <div class="row pb-3">
                                    <div class="col align-items-center">
                                        <label class="mr-3 mb-0 users-list-status pb-2" for="audioFile">Edit
                                            Audio (optional):</label>
                                        <input type="file" class="form-control" id="audioFile" name="file"
                                            accept="audio/*">
                                    </div>
                                    <div class="col align-items-center">
                                        <label for="audioFile" class="mr-3 mb-0 pb-2">Old Audio:</label>
                                        <div>
                                        <audio controls>
                                            <source src="{{ Storage::url(decrypt($therapy->file)) }}" type="audio/mpeg">
                                            Your browser does not support the audio element.
                                        </audio>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 d-flex flex-sm-row flex-column justify-content-end mt-1">
                <button type="submit" class="btn btn-primary glow mb-1 mb-sm-0 mr-0 mr-sm-1">Save
                    changes</button>
                <a type="reset" href="{{ route('therapy.index') }}" class="btn btn-light">Cancel</a>
            </div>
        </form>
    </section>
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

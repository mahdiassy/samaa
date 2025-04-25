@extends('layouts.master2')
@section('content')
    @include('search_form_with_backbround')
    <div class="main-content">
        <div class="header">
            <a href="javascript:void(0);" onclick="history.back();" class="btn-back">
                @if (App::getLocale() == 'ar')
                <i class="fas fa-long-arrow-alt-right" aria-hidden="true"></i> {{ __('site.Go Back') }}
                @else
                <i class="fas fa-long-arrow-alt-left" aria-hidden="true"></i> {{ __('site.Go Back') }}
                @endif
            </a>
        </div>
        <div class="users-list-filter">
            <form action="{{ route('blog.update',$blog) }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-section">
                    <div class="image-upload-wrapper">
                        <input type="file" id="image-upload" name="image" accept="image/*"
                            value="{{ $blog->image }}" onchange="showPreview(event)" style="display:none;">
                        <label for="image-upload" class="upload-label">
                            <div class="image-placeholder">
                                <img id="image-preview" src="{{ Storage::url($blog->image) }}" alt="Placeholder"
                                    class="placeholder-img">
                                <div class="edit-icon">
                                    <img src="https://img.icons8.com/ios-filled/30/000000/edit.png" alt="Edit" />
                                </div>
                            </div>
                        </label>
                        <p class="image-upload-instruction">{{ __('site.Set the Blog thumbnail image. Only *.png, *.jpg, and *.jpeg image files are accepted') }}</p>
                    </div>
                    <div class="input-row">
                        <div class="input-group">
                            <label for="title">{{ __('site.Title') }}</label>
                            <input type="text" id="title" class="form-input" name="title" value="{{$blog->title}}" placeholder="{{ __('site.Title') }}"
                                required>
                        </div>
                    </div>
                    <div class="input-group">
                        <label for="Bio">{{ __('site.Description') }}</label>
                        <textarea id="Bio" name="description" value="{{$blog->description}}" >{{$blog->description}}</textarea>
                    </div>

                    <div class="action-buttons">
                        <button type="submit" class="btn patient-btn">{{ __('site.Update') }}</button>
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

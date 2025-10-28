@extends('layouts.master2')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/admin/blog-create-page.css') }}">
@endpush

@section('content')
@include('search_form_with_backbround')

<div class="blog-management-content">
    <div class="header">
        <a href="javascript:void(0);" onclick="history.back();" class="btn-back">
            @if(App::getLocale() == 'ar')
                <i class="fas fa-long-arrow-alt-right"></i> {{ __('site.Go Back') }}
            @else
                <i class="fas fa-long-arrow-alt-left"></i> {{ __('site.Go Back') }}
            @endif
        </a>
    </div>

    <div class="users-list-filter">
        <form action="{{ route('blog.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-section">
                <div class="image-upload-wrapper">
                    <input type="file" id="image-upload" name="image" accept="image/*"
                           onchange="showPreview(event)" style="display:none;" />
                    <label for="image-upload" class="upload-label" >
                        <div class="image-placeholder">
                            <img id="image-preview" src="https://placehold.co/150x150" alt="Placeholder" class="placeholder-img">
                            <div class="edit-icon">
                                <img src="https://img.icons8.com/ios-filled/30/000000/edit.png" alt="Edit" />
                            </div>
                        </div>
                    </label>
                    <p class="image-upload-instruction">
                        {{ __('site.Set the Blog thumbnail image. Only *.png, *.jpg, and *.jpeg image files are accepted') }}
                    </p>
                </div>

                <ul class="nav nav-tabs" id="langTabs" role="tablist">
                    @foreach(config('app.locales') as $index => $locale)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link {{ $index == 0 ? 'active' : '' }}" id="tab-{{ $locale }}"
                                    data-bs-toggle="tab" data-bs-target="#content-{{ $locale }}" type="button" role="tab">
                                {{ strtoupper($locale) }}
                            </button>
                        </li>
                    @endforeach
                </ul>

                <div class="tab-content mt-3">
                    @foreach(config('app.locales') as $index => $locale)
                        <div class="tab-pane fade {{ $index == 0 ? 'show active' : '' }}" id="content-{{ $locale }}" role="tabpanel">
                            <div class="input-group">
                                <label for="title_{{ $locale }}">{{ __('site.Title') }} ({{ strtoupper($locale) }})</label>
                                <input type="text" name="title_{{ $locale }}" class="form-input"
                                       placeholder="{{ __('site.Title') }} ({{ strtoupper($locale) }})" required>
                            </div>

                            <div class="input-group mt-2">
                                <label for="description_{{ $locale }}">{{ __('site.Description') }} ({{ strtoupper($locale) }})</label>
                                <textarea id="editor_{{ $locale }}" name="description_{{ $locale }}" rows="10"></textarea>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="action-buttons mt-4">
                    <button type="submit" class="btn patient-btn">{{ __('site.Create') }}</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    function showPreview(event) {
        var file = event.target.files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('image-preview').src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    }
</script>

@endsection

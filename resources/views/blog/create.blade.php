@extends('layouts.master2')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/admin/blog-create-page.css') }}">
@endpush

@section('content')
@section('content')
    @php
        $backRoute = Route::has('blog.list') ? route('blog.list') : url()->previous();
        $currentLocale = app()->getLocale();
    @endphp

    <div class="blog-management-content blog-create-page">
        <div class="page-header">
            <div class="header-content">
                <div class="header-info">
                    <h1 class="page-title">{{ __('site.Add New Blog') }}</h1>
                    <p class="page-subtitle">Craft a new story for the SAMAA community and share expert insights.</p>
                </div>
                <div class="header-actions">
                    <a href="{{ $backRoute }}" class="header-btn secondary-btn">
                        <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            @if($currentLocale === 'ar')
                                <path d="M19 11H9.83l3.58-3.59L12 6l-6 6 6 6 1.41-1.41L9.83 13H19v-2z" />
                            @else
                                <path d="M5 13h9.17l-3.58 3.59L12 18l6-6-6-6-1.41 1.41L14.17 11H5v2z" />
                            @endif
                        </svg>
                        {{ __('site.Go Back') }}
                    </a>
                </div>
            </div>
        </div>

        <div class="guideline-grid">
            <div class="guideline-card">
                <div class="guideline-icon">
                    <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                        <path d="M12 2l3.5 6.99L23 9.75l-5.5 5.36L18.5 22 12 18.56 5.5 22l1-6.89L1 9.75l7.5-0.76z" />
                    </svg>
                </div>
                <div class="guideline-content">
                    <h3>Inspire confidence</h3>
                    <p>Lead with a clear headline and an overview that invites readers to explore.</p>
                </div>
            </div>

            <div class="guideline-card">
                <div class="guideline-icon">
                    <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                        <path d="M4 4h16v2H4zm0 7h16v2H4zm0 7h16v2H4z" />
                    </svg>
                </div>
                <div class="guideline-content">
                    <h3>Stay structured</h3>
                    <p>Use subheadings, short paragraphs, and descriptive media to guide readers.</p>
                </div>
            </div>

            <div class="guideline-card">
                <div class="guideline-icon">
                    <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                        <path d="M12 4a8 8 0 1 0 8 8 8 8 0 0 0-8-8zm-1 11-3-3 1.41-1.41L11 12.17l4.59-4.59L17 9z" />
                    </svg>
                </div>
                <div class="guideline-content">
                    <h3>Deliver value</h3>
                    <p>Ensure each section includes practical tips or research-backed recommendations.</p>
                </div>
            </div>
        </div>

        <div class="form-wrapper">
            <form action="{{ route('blog.store') }}" method="post" enctype="multipart/form-data" class="blog-create-form">
                @csrf

                <div class="form-shell">
                    <section class="form-panel media-panel">
                        <header class="panel-header">
                            <h2>Cover image</h2>
                            <p>Upload a compelling visual that represents the article at a glance.</p>
                        </header>

                        <div class="image-upload-wrapper">
                            <input type="file" id="image-upload" name="image" accept="image/*" onchange="showPreview(event)" hidden />
                            <label for="image-upload" class="upload-label">
                                <div class="image-placeholder">
                                    <img id="image-preview" src="https://placehold.co/300x300" alt="Blog cover preview" class="placeholder-img">
                                    <div class="edit-icon">
                                        <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                            <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75zM20.71 7.04a1 1 0 0 0 0-1.41l-2.34-2.34a1 1 0 0 0-1.41 0l-1.83 1.83 3.75 3.75z" />
                                        </svg>
                                    </div>
                                </div>
                            </label>
                            <p class="image-upload-instruction">
                                {{ __('site.Set the Blog thumbnail image. Only *.png, *.jpg, and *.jpeg image files are accepted') }}
                            </p>
                        </div>

                        <ul class="upload-guidelines">
                            <li>Recommended size: 1200 × 800 px</li>
                            <li>Keep important details centered for best cropping results</li>
                            <li>Use original imagery or assets cleared for publication</li>
                        </ul>
                    </section>

                    <section class="form-panel content-panel">
                        <header class="panel-header">
                            <h2>Localized content</h2>
                            <p>Provide a tailored title and description for each supported language.</p>
                        </header>

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

                        <div class="tab-content">
                            @foreach(config('app.locales') as $index => $locale)
                                <div class="tab-pane fade {{ $index == 0 ? 'show active' : '' }}" id="content-{{ $locale }}" role="tabpanel">
                                    <div class="input-group">
                                        <label for="title_{{ $locale }}">{{ __('site.Title') }} ({{ strtoupper($locale) }})</label>
                                        <input type="text" id="title_{{ $locale }}" name="title_{{ $locale }}" class="form-input"
                                               placeholder="{{ __('site.Title') }} ({{ strtoupper($locale) }})" required>
                                        @error("title_{$locale}")
                                            <span class="error-message">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="input-group">
                                        <label for="description_{{ $locale }}">{{ __('site.Description') }} ({{ strtoupper($locale) }})</label>
                                        <textarea id="description_{{ $locale }}" name="description_{{ $locale }}" rows="10"></textarea>
                                        @error("description_{$locale}")
                                            <span class="error-message">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </section>
                </div>

                <div class="action-bar">
                    <a href="{{ $backRoute }}" class="header-btn ghost-btn">{{ __('site.Cancel') }}</a>
                    <button type="submit" class="header-btn primary-btn">{{ __('site.Create') }}</button>
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

@extends('layouts.base')
@section('content')
    <div class="content-container position-relative background-style">
        <!-- Backdrop (only over content) -->
        <div class="custom-content-backdrop"></div>

        <!-- Modal (inside content only) -->
        <div class="modal show d-block" id="roleModal" tabindex="-1" aria-labelledby="roleModalLabel" aria-modal="true" role="dialog">
            <div class="modal-dialog modal-dialog-centered custom-modal-width">
                <div class="modal-content custom-modal-content text-center">
                    <div class="modal-header border-0">
                        <h5 class="modal-title w-100" id="roleModalLabel">{{ __('site.Choose Registration Type') }}</h5>
                    </div>
                    <div class="modal-body">
                        <a href="{{ route('showRegisterPatient') }}" class="btn btn-patient m-2">{{ __('site.Register as Patient') }}</a>
                        <a href="{{ route('showRegisterDoctor') }}" class="btn btn-doctor m-2">{{ __('site.Register as Doctor') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

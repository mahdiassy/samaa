@extends('layouts.master2')
@section('content')
    <div class="main-content">
        @include('search_form')
        <div class="header">
            <a href="{{ route('dashboard') }}" onclick="history.back();" class="btn-back">
                @if (App::getLocale() == 'ar')
                <i class="fas fa-long-arrow-alt-right" aria-hidden="true"></i> {{ __('site.Go Back') }}
                @else
                <i class="fas fa-long-arrow-alt-left" aria-hidden="true"></i> {{ __('site.Go Back') }}
                @endif
            </a>

        </div>
        <div>
            <div class="profile-details">
                <form id="changePasswordForm" action="{{ route('changePasswordSaved') }}" method="post">
                    @csrf
                    <div class="feedback">
                        <div class="feedback-container">
                            <p class="feedback-title">{{ __('site.change password') }}</p>

                            <div class="text-info">
                                <p class="form-label">{{ __('site.Old Password') }}</p>
                                <input type="password" class="styled-input form-control"  placeholder="*******" id="old_pass" name="old_password" required />

                                <div class="invalid-feedback">
                                    {{ __('site.Please enter your old password.') }}
                                </div>

                            </div>
                            <div class="text-info">
                                <p class="form-label">{{ __('site.New Password') }}</p>
                                <input type="password" class="styled-input form-control"  placeholder="*******" id="new_pass" name="new_password" required />

                                <div class="invalid-feedback">
                                    {{ __('site.Please enter a new password.') }}
                                </div>
                            </div>
                            <div class="text-info">
                                <p class="form-label">{{ __('site.Confirm Password') }}</p>
                                <input type="password" class="styled-input form-control"  placeholder="*******" id="confirm_pass" name="confirm_password" required />

                                <div class="invalid-feedback">
                                    {{ __('site.Passwords do not match.') }}
                                </div>
                            </div>
                        </div>
                        <div class="feedback-action-buttons">
                            <button class="btn submit-btn">{{ __('site.update') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

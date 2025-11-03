@extends('layouts.base')
@section('content')
    <div class="register-section">
        <!-- Form Steps Content -->
        <form id="changePasswordForm" action="{{ route('registerDoctor') }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="form-step personal-info active">
                <h2> {{ __('site.Personal Information') }}</h2>
                <div class="profile-container">
                    <div class="profile-picture">
                        <img id="profileImage" src="{{ asset('assets/images/doctor-profile.jpg') }}" alt="Profile Picture">
                    </div>
                    <div class="vector-icon" onclick="document.getElementById('fileInput').click();">
                        <i class="fas fa-plus"></i>
                    </div>
                    <input type="file" name="image" id="fileInput" accept="image/*" style="display: none;"
                        onchange="updateProfilePicture(event)">
                </div>

                <div class="form-group">
                    <div>
                        <label>{{ __('site.First Name') }}</label>

                        <input type="text" name="first_name" placeholder="{{ __('site.First Name') }}" required>
                        <div class="invalid-feedback">
                            {{ __('site.Please enter your First Name') }}
                        </div>
                    </div>

                    <div>
                        <label>{{ __('site.Surname') }}</label>

                        <input type="text" name="last_name" placeholder="{{ __('site.Surname') }}">
                    </div>

                </div>
                <div class="form-group">
                    <div>
                        <label>{{ __('site.Email') }}</label>
                        <input type="email" name="email"
                            placeholder="{{ __('site.Enter Your Registered Email Address') }}" required>
                        <div class="invalid-feedback">
                            {{ __('site.Please enter your Email Address') }}
                        </div>
                    </div>

                    <div>
                        <label>{{ __('site.Birthday') }}</label>
                        <input type="date" name="birthday" placeholder="{{ __('site.date') }}">
                    </div>

                </div>
                <div class="form-group">
                    <div>
                        <label>{{ __('site.Phone') }}</label>
                        <input type="tel" name="phone" placeholder="0918657965">
                    </div>
                    <div>
                        <label>{{ __('site.Address') }}</label>
                        <input type="text" name="address" placeholder="{{ __('site.Address') }}">
                    </div>
                </div>

                <div class="form-group">
                    <div>
                        <label>{{ __('site.New Password') }}</label>
                        <input type="password" id="new_pass" name="password" placeholder="XXXXXXXXXXXXXXX" required>
                        <div class="invalid-feedback">
                            {{ __('site.Please enter a new password.') }}
                        </div>
                    </div>

                    <div>
                        <label>{{ __('site.Confirm Password') }}</label>
                        <input type="password" id="confirm_pass" name="confirm_password" placeholder="XXXXXXXXXXXXXXX"
                            required>
                        <div class="invalid-feedback">
                            {{ __('site.Passwords do not match.') }}
                        </div>
                    </div>

                </div>

                <div class="form-group">
                    <div>
                        <label>{{ __('site.Specialization') }}</label>
                        <input type="text" name="specialization" placeholder="Specialization" required>
                    </div>

                </div>

                <div class="button-container">
                    <button type="submit" class="done-btn">{{ __('site.Done') }}</button>
                </div>

            </div>

        </form>

        <div class="info">
            <div>
                <p>{{ __('site.Copyright © 2022 Pharma Co. All rights reserved.') }}</p>
            </div>
            <div>
                <p>{{ __('site.Terms & Conditions') }}</p>
            </div>
        </div>
        <!-- End Form Steps Content -->
    </div>
@endsection

<!-- Bootstrap removed - now using Tailwind CSS -->
<!-- Tailwind is loaded via @vite in the layout -->

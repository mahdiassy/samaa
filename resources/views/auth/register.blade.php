@extends('layouts.base')
@section('content')
    <div class="register-section">
        <!-- Form Steps Content -->
        <form novalidate action="{{ route('registerPatient') }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="form-step personal-info active">
                <h2> {{ __('site.Personal Information') }}</h2>
                <div class="profile-container">
                    <div class="profile-picture">
                        <img id="profileImage" src="{{ asset('assets/images/profile.jfif') }}" alt="Profile Picture">
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

                        <input type="text" name="first_name" placeholder="{{ __('site.First Name') }}">
                    </div>

                    <div>
                        <label>{{ __('site.Surname') }}</label>

                        <input type="text" name="last_name" placeholder="{{ __('site.Surname') }}">
                    </div>

                </div>
                <div class="form-group">

                    <div>
                        <label>{{ __('site.Birthday') }}</label>
                        <input type="date" name="birthday" placeholder="{{ __('site.date') }}">
                    </div>

                    <div>
                        <label>{{ __('site.Phone') }}</label>
                        <input type="tel" name="phone" placeholder="0918657965">
                    </div>

                </div>
                <div class="form-group">
                    <div>
                        <label>{{ __('site.Email') }}</label>
                        <input type="email" name="email"
                            placeholder="{{ __('site.Enter Your Registered Email Address') }}">
                    </div>

                    <div>
                        <label>{{ __('site.New Password') }}</label>
                        <input type="password" name="password" placeholder="XXXXXXXXXXXXXXX">
                    </div>
                </div>
                <div class="form-group">
                    <div>
                        <label>{{ __('site.Country') }}</label>
                        <select name="country">
                            @foreach ($countries as $country)
                                <option value="{{ $country->id }}">{{ $country->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label>{{ __('site.Language Spoken') }}</label>
                        <select name="language">
                            @foreach ($languages as $language)
                                <option value="{{ $language->id }}">{{ $language->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="gender-group">
                    <label>{{ __('site.Gender') }}</label>
                    <div class="radio-container">
                        <label class="radio-option">
                            <input type="radio" name="gender" value="male">
                            <span></span>
                            <label>{{ __('site.Male') }}</label>
                        </label>
                        <label class="radio-option">
                            <input type="radio" name="gender" value="female">
                            <span></span>
                            <label>{{ __('site.Female') }}</label>
                        </label>
                    </div>
                </div>

                <div class="button-container">
                    <button type="button" class="next-btn" onclick="showNextStep()">{{ __('site.Next') }}</button>
                </div>

            </div>

            <div class="form-step medical-history">
                <h2>{{ __('site.Medical History') }}</h2>
                <div class="form-section">
                    <div class="left-column">
                        <div>
                            <div class="form-group">
                                <label>{{ __('site.Blood Type') }}</label>
                                <select name="blood_type">
                                    <option>{{ __('site.Blood Type') }}</option>
                                    <option value="A+">A+</option>
                                    <option value="A-">A-</option>
                                    <option value="AB+">AB+</option>
                                    <option value="AB-">AB-</option>
                                    <option value="O+">O+</option>
                                    <option value="O-">O-</option>
                                    <option value="B+">B+</option>
                                    <option value="B-">B-</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>{{ __('site.Psychological_diseases') }}</label>
                                <select name="psychological_disease">
                                    @foreach ($psychological_diseases as $psychological_disease)
                                        <option value="{{ $psychological_disease->id }}">
                                            {{ $psychological_disease->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="right-column">
                        <div class="form-group">
                            <label>{{ __('site.Therapeutic_area') }}</label>
                            <select name="therapeutic_area" id="therapeutic_area" class="form-control">
                                <option value="" disabled selected>{{ __('site.Therapeutic_area') }}</option>
                                @foreach ($therapeutic_areas as $therapeutic_area)
                                    <option value="{{ $therapeutic_area->id }}">{{ $therapeutic_area->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>{{ __('site.Diseases') }}</label>
                            <select name="disease" id="disease" class="form-control" disabled>
                                <option value="" disabled selected>{{ __('site.Diseases') }}</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-section2">
                    <div class="form-group">
                        <label>{{ __('site.open_description') }}</label>
                        <textarea name="open_description" class="styled-input textarea-input"></textarea>
                    </div>
                </div>
                <div class="button-container">
                    <button type="submit" class="done-btn">{{ __('site.Done') }}</button>
                </div>
            </div>
        </form>
        <div class="form-navigation">
            <div class="step-indicator">
                <span class="active-step">1</span>
                <div class="step-line"></div>
                <span>2</span>
            </div>
        </div>

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

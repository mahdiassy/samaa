@extends('layouts.base')
@section('content')
    <div class="register-section">
        <!-- Form Steps Content -->
        <form action="{{ route('registerPatient') }}" method="post" enctype="multipart/form-data">
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

                        <input type="text" name="first_name" placeholder="{{ __('site.First Name') }}" required>
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
                            placeholder="{{ __('site.Enter Your Registered Email Address') }}" required>
                    </div>

                    <div>
                        <label>{{ __('site.New Password') }}</label>
                        <input type="password" name="password" placeholder="XXXXXXXXXXXXXXX" required>
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
                                <label>{{ __('site.Have you been diagnosed with any of the following mental health conditions?') }} {{ __('site.Select all that apply') }}</label>
                                <select name="psychological_diseases[]" class="form-control diseases-select select2"
                                    multiple>
                                    @foreach ($psychological_diseases as $psychological_disease)
                                        <option value="{{ $psychological_disease->id }}">
                                            {{ $psychological_disease->getTranslatedName() }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>{{ __('site.Have you ever received therapy or counseling before?') }}</label>
                                <select name="consultation">
                                    @foreach ($consultations as $consultation)
                                        <option value="{{ $consultation->id }}">{{ $consultation->getTranslatedName() }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>{{ __('site.Have you experienced any of the following symptoms in the past 6 months?') }} {{ __('site.Select all that apply') }}</label>
                                <select name="symptoms[]" class="form-control diseases-select select2" multiple>
                                    @foreach ($symptoms as $symptom)
                                        <option value="{{ $symptom->id }}">
                                            {{ $symptom->getTranslatedName() }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>{{ __('site.Are you currently taking any medications for mental health conditions?') }}</label>
                                <select name="therapeutic_areas" id="therapeutic_areas_select" class="form-control">
                                    @foreach ($therapeutic_areas as $therapeutic_area)
                                        <option value="{{ $therapeutic_area->id }}">{{ $therapeutic_area->getTranslatedName() }}</option>
                                    @endforeach
                                </select>

                                <div id="medication_input_wrapper" style="display: none; margin-top: 10px;">
                                    <label for="medications">{{ __('site.Please list the medications you are taking') }}</label>
                                    <input type="text" name="medications" id="medications" class="form-control" placeholder="{{ __('site.Enter medication names') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="right-column">
                        <div class="form-group">
                            <label>{{ __('site.Have you ever been diagnosed with any neurological conditions?') }} {{ __('site.Select all that apply') }}</label>
                            <select name="nervouses[]" class="form-control diseases-select select2" multiple>
                                @foreach ($nervouses as $nervous)
                                    <option value="{{ $nervous->id }}">
                                        {{ $nervous->getTranslatedName() }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>{{ __('site.Do you have a history of substance use or addiction?') }}</label>
                            <select name="addiction">
                                @foreach ($addictions as $addiction)
                                    <option value="{{ $addiction->id }}">{{ $addiction->getTranslatedName() }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>{{ __('site.Have you experienced any major life events or traumas that may impact your mental health?') }} {{ __('site.Select all that apply') }}</label>
                            <select name="incidents[]" class="form-control diseases-select select2" multiple>
                                @foreach ($incidents as $incident)
                                    <option value="{{ $incident->id }}">
                                        {{ $incident->getTranslatedName() }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>{{ __('site.Do you have any chronic physical health conditions?') }}</label>
                            <select name="diseases[]" class="form-control diseases-select select2" multiple>
                                @foreach ($diseases as $disease)
                                    <option value="{{ $disease->id }}">
                                        {{ $disease->getTranslatedName() }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                </div>
                <!--<div class="form-section2">
                    <div class="form-group">
                        <label>{{ __('site.open_description') }}</label>
                        <textarea name="open_description" class="styled-input textarea-input"></textarea>
                    </div>
                </div>-->
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

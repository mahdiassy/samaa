@extends('layouts.master2')
@section('content')
    <div class="main-content">
        <div class="search-container">
            <input type="text" placeholder="{{ __('site.Search') }}">
            <button>
                <svg width="19" height="20" viewBox="0 0 21 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M20.75 20.1895L15.086 14.5255C16.4471 12.8914 17.1259 10.7956 16.981 8.67389C16.8362 6.55219 15.879 4.56801 14.3085 3.1341C12.7379 1.7002 10.6751 0.92697 8.54899 0.975279C6.42291 1.02359 4.39729 1.88971 2.89353 3.39347C1.38977 4.89723 0.523649 6.92284 0.47534 9.04893C0.427031 11.175 1.20026 13.2379 2.63416 14.8084C4.06807 16.3789 6.05225 17.3361 8.17395 17.481C10.2957 17.6258 12.3915 16.9471 14.0255 15.586L19.6895 21.25L20.75 20.1895ZM2.00003 9.24996C2.00003 7.91494 2.39591 6.6099 3.13761 5.49987C3.87931 4.38983 4.93351 3.52467 6.16691 3.01378C7.40031 2.50289 8.75751 2.36921 10.0669 2.62966C11.3763 2.89011 12.579 3.53299 13.523 4.47699C14.467 5.421 15.1099 6.62373 15.3703 7.9331C15.6308 9.24248 15.4971 10.5997 14.9862 11.8331C14.4753 13.0665 13.6102 14.1207 12.5001 14.8624C11.3901 15.6041 10.085 16 8.75003 16C6.96042 15.998 5.24469 15.2862 3.97925 14.0207C2.71381 12.7553 2.00201 11.0396 2.00003 9.24996Z"
                        fill="#818181" />
                </svg>
            </button>
        </div>
        <div class="header">

        </div>
        <div>
            <div class="profile-details">
                <form action="{{ route('profile.patient.update', $patient) }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="profile-info">
                        <div class="profile-header2">
                            <div class="image-container">
                                <img src="{{ $patient->image ? Storage::url($patient->image) : asset('assets/images/avatar1.png') }}" alt="Patient Photo" class="profile-img" id="patientPhoto">
                                <a href="#" class="btn-replace" id="replaceBtn">
                                    <svg width="25" height="25" viewBox="0 0 30 29" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M24.0066 12.5735C23.5374 12.5735 23.157 12.9539 23.157 13.4231V25.8845C23.157 26.6653 22.5217 27.3005 21.7409 27.3005H3.61533C2.83452 27.3005 2.19927 26.6653 2.19927 25.8845V7.75889C2.19927 6.97807 2.83452 6.34283 3.61533 6.34283H16.0767C16.5459 6.34283 16.9263 5.96242 16.9263 5.49319C16.9263 5.02397 16.5459 4.64355 16.0767 4.64355H3.61533C1.89754 4.64355 0.5 6.04109 0.5 7.75889V25.8845C0.5 27.6023 1.89754 28.9998 3.61533 28.9998H21.7409C23.4587 28.9998 24.8563 27.6023 24.8563 25.8845V13.4231C24.8563 12.9539 24.4758 12.5735 24.0066 12.5735Z"
                                            fill="black" />
                                        <path
                                            d="M28.9199 2.18184L27.3177 0.579707C26.5449 -0.193236 25.2872 -0.193236 24.5141 0.579707L11.6975 13.3964C11.5788 13.515 11.498 13.6661 11.4651 13.8306L10.664 17.8358C10.6083 18.1144 10.6955 18.4024 10.8964 18.6032C11.0573 18.7641 11.2741 18.8521 11.4971 18.8521C11.5526 18.8521 11.6083 18.8467 11.6637 18.8356L15.6689 18.0345C15.8334 18.0016 15.9845 17.9207 16.1031 17.8021L28.9199 4.98547C28.9199 4.98547 28.9199 4.98547 28.9199 4.98541C29.6928 4.21253 29.6928 2.95484 28.9199 2.18184ZM15.0835 16.4187L12.5802 16.9194L13.081 14.4162L23.5128 3.98415L25.5154 5.9868L15.0835 16.4187ZM27.7183 3.78391L26.717 4.78524L24.7143 2.78259L25.7156 1.78132C25.8261 1.67087 26.0057 1.67081 26.1162 1.78126L27.7183 3.3834C27.8288 3.49379 27.8288 3.67352 27.7183 3.78391Z"
                                            fill="black" />
                                    </svg>
                                </a>
                            </div>
                            <input type="file" name="image" id="imageUpload" style="display:none" accept="image/*" >
                        </div>
                    </div>

                    <div class="visit-details">

                        <div class="user-info">
                            <div class="text-info">
                                <p>{{ __('site.First Name') }}</p>
                                <input type="text" name="first_name" placeholder="{{ __('site.First Name') }}"
                                    value="{{ $patient->first_name }}" class="styled-input" required />
                            </div>
                            <div class="text-info">
                                <p>{{ __('site.Email Address') }}</p>
                                <input type="text" name="email" placeholder="{{ __('site.Email Address') }}"
                                    value="{{ $patient->user->email }}" class="styled-input" required />
                            </div>
                            <div class="text-info">
                                <p>{{ __('site.Phone') }}</p>
                                <input type="text" name="phone" placeholder="{{ __('site.Phone') }}"
                                    value="{{ $patient->phone }}" class="styled-input" />
                            </div>
                            <div class="text-info">
                                <p>{{ __('site.Language Spoken') }}</p>
                                <select name="language" style="margin-top: 0px;" class="styled-input">
                                    @foreach ($languages as $language)
                                        <option value="{{ $language->id }}"
                                            @if ($language->id == $patient->language->id) selected @endif>
                                            {{ $language->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <h2>{{ __('site.Medical History') }}</h2>

                            <div class="text-info">
                                <label>{{ __('site.Have you been diagnosed with any of the following mental health conditions?') }}
                                    {{ __('site.Select all that apply') }}</label>
                                <select name="psychological_diseases[]" style="margin-top: 0px;"
                                    class="styled-input form-control select2 diseases-select-backend" multiple>
                                    @foreach ($psychological_diseases as $psychological_disease)
                                        <option value="{{ $psychological_disease->id }}"
                                            @if (in_array($psychological_disease->id, old('psychologicals', isset($patient) ? $patient->psychologicals->pluck('id')->toArray() : []))) selected @endif>
                                            {{ $psychological_disease->getTranslatedName() }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="text-info">
                                <label>{{ __('site.Are you currently taking any medications for mental health conditions?') }}</label>
                                <select name="therapeutic_areas" id="therapeutic_areas_select" style="margin-top: 0px;" class="styled-input">
                                    @foreach ($therapeutic_areas as $therapeutic_area)
                                        <option value="{{ $therapeutic_area->id }}"
                                            @if (in_array($therapeutic_area->id, old('therapeutic_area', isset($patient) ? $patient->therapeutic_areas->pluck('id')->toArray() : []))) selected @endif>
                                            {{ $therapeutic_area->getTranslatedName() }}
                                        </option>
                                    @endforeach
                                </select>

                                <div id="medication_input_wrapper" style="display: {{ old('medications', $medications ?? '') ? 'block' : 'none' }}; margin-top: 10px;">
                                    <label for="medications">{{ __('site.Please list the medications you are taking') }}</label>
                                    <input type="text" name="medications" id="medications" value="{{ old('medications', $medications ?? '') }}" class="styled-input" placeholder="{{ __('site.Enter medication names') }}">
                                </div>
                            </div>

                            <div class="text-info">
                                <label>{{ __('site.Have you experienced any of the following symptoms in the past 6 months?') }}
                                    {{ __('site.Select all that apply') }}</label>
                                <select name="symptoms[]" style="margin-top: 0px;"
                                    class="styled-input form-control select2 diseases-select-backend" multiple>
                                    @foreach ($symptoms as $symptom)
                                        <option value="{{ $symptom->id }}"
                                            @if (in_array($symptom->id, old('symptoms', isset($patient) ? $patient->symptomes->pluck('id')->toArray() : []))) selected @endif>
                                            {{ $symptom->getTranslatedName() }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="text-info">
                                <label>{{ __('site.Have you ever received therapy or counseling before?') }}</label>
                                <select name="consultation" style="margin-top: 0px;" class="styled-input">
                                    @foreach ($consultations as $consultation)
                                        <option value="{{ $consultation->id }}">{{ $consultation->getTranslatedName() }}
                                        </option>
                                    @endforeach

                                    @foreach ($consultations as $consultation)
                                    <option value="{{ $consultation->id }}"
                                        @if (in_array($consultation->id, old('consultations', isset($patient) ? $patient->consultationes->pluck('id')->toArray() : []))) selected @endif>
                                        {{ $consultation->getTranslatedName() }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                        <div class="diagnosis">

                            <div class="text-info">
                                <p>{{ __('site.Last Name') }}</p>
                                <input type="text" name="last_name" placeholder="{{ __('site.Last Name') }}"
                                    value="{{ $patient->last_name }}" class="styled-input" />
                            </div>
                            <div class="text-info">
                                <p>{{ __('site.Country') }}</p>
                                <select name="country" style="margin-top: 0px;" class="styled-input">
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}"
                                            @if ($country->id == $patient->country->id) selected @endif>
                                            {{ $country->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="text-info">
                                <p>{{ __('site.Birthday') }}</p>
                                <input type="date" name="birthday" value="{{ $patient->birthday }}"
                                    class="styled-input date-input" />
                            </div>
                            <div class="text-info">
                                <p>{{ __('site.Gender') }}</p>
                                <select name="gender" style="margin-top: 0px;" class="styled-input">
                                    <option disabled {{ old('gender', $patient->gender ?? '') == '' ? 'selected' : '' }}>
                                        {{ __('site.Gender') }}</option>
                                    <option value="female"
                                        {{ old('gender', $patient->gender ?? '') == 'female' ? 'selected' : '' }}>
                                        {{ __('site.Female') }}</option>
                                    <option value="male"
                                        {{ old('gender', $patient->gender ?? '') == 'male' ? 'selected' : '' }}>
                                        {{ __('site.Male') }}</option>
                                </select>
                            </div>

                            <br>
                            <br>

                            <div class="text-info">
                                <label>{{ __('site.Have you ever been diagnosed with any neurological conditions?') }}
                                    {{ __('site.Select all that apply') }}</label>
                                <select name="nervouses[]" style="margin-top: 0px;"
                                    class="styled-input select2 diseases-select-backend" multiple>
                                    @foreach ($nervouses as $nervous)
                                        <option value="{{ $nervous->id }}"
                                            @if (in_array($nervous->id, old('nervouses', isset($patient) ? $patient->nervouses->pluck('id')->toArray() : []))) selected @endif>
                                            {{ $nervous->getTranslatedName() }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="text-info">
                                <label>{{ __('site.Do you have a history of substance use or addiction?') }}</label>
                                <select name="addiction" style="margin-top: 0px;" class="styled-input">
                                    @foreach ($addictions as $addiction)
                                        <option value="{{ $addiction->id }}"
                                            @if (in_array($addiction->id, old('addictions', isset($patient) ? $patient->addictiones->pluck('id')->toArray() : []))) selected @endif>
                                            {{ $addiction->getTranslatedName() }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="text-info">
                                <label>{{ __('site.Have you experienced any major life events or traumas that may impact your mental health?') }}
                                    {{ __('site.Select all that apply') }}</label>
                                <select name="incidents[]" style="margin-top: 0px;"
                                    class="styled-input form-control select2 diseases-select-backend" multiple>
                                    @foreach ($incidents as $incident)
                                        <option value="{{ $incident->id }}"
                                            @if (in_array($incident->id, old('nervouses', isset($patient) ? $patient->incidents->pluck('id')->toArray() : []))) selected @endif>
                                            {{ $incident->getTranslatedName() }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="text-info">
                                <label>{{ __('site.Do you have any chronic physical health conditions?') }}</label>
                                <select name="diseases[]" style="margin-top: 0px;"
                                    class="styled-input form-control select2 diseases-select-backend" multiple>
                                    @foreach ($diseases as $disease)
                                        <option value="{{ $disease->id }}"
                                            @if (in_array($disease->id, old('nervouses', isset($patient) ? $patient->diseases->pluck('id')->toArray() : []))) selected @endif>
                                            {{ $disease->getTranslatedName() }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                    </div>
                    <div class="action-buttons">
                        <button class="btn patient-btn">{{ __('site.Update') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

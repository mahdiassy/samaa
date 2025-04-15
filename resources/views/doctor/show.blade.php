@extends('layouts.master2')
@section('content')
    <div class="main-content">
        @include('search_form')
        <div class="header">
            <a href="{{ route('doctor.index') }}" class="btn-back">
                @if (App::getLocale() == 'ar')
                <i class="fas fa-long-arrow-alt-right" aria-hidden="true"></i> {{ __('site.Go Back') }}
                @else
                <i class="fas fa-long-arrow-alt-left" aria-hidden="true"></i> {{ __('site.Go Back') }}
                @endif
            </a>
        </div>
        <div>
            <div class="profile-details">
                <div class="doctor-details">
                        <img src="{{ $doctor->image ? Storage::url($doctor->image) : asset('assets/images/avatar1.png') }}" alt="Doctor Photo" class="profile-img">
                    <div class="user-info">
                        <div class="extra-user-info">
                            <p class="big-title">{{ $doctor->first_name }} {{ $doctor->last_name }}</p>
                            <div class="small-title">
                                <p>{{ __('site.ID') }}:#{{ $doctor->id }}</p>
                            </div>
                            <div class="text-info">
                                <p><strong>{{ __('site.Specialization') }}</strong></p>
                                <p>{{ $doctor->specialization }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="doctor-details">

                    <div class="user-info">
                        <p class="big-title">{{ $doctor->first_name }} {{ $doctor->last_name }}</p>
                        <div class="small-title">
                            <p>{{ __('site.ID') }}:#{{ $doctor->id }}</p>
                        </div>
                        <div class="text-info">
                            <p><strong>{{ __('site.Address') }}:</strong> {{ $doctor->address }}</p>

                            <p><strong>{{ __('site.Birthday') }}:</strong> {{ \Carbon\Carbon::parse($doctor->birthday)->format('d-m-Y') }}</p>
                        </div>
                    </div>
                    <div class="diagnosis">
                        <div class="text-info">
                            <p><strong>{{ __('site.Email Address') }}:</strong></p>
                            <p>{{ $doctor->user->email }}</p>

                            <p><strong>{{ __('site.Phone') }}:</strong></p>
                            <p>{{ $doctor->phone }}</p>
                        </div>
                        <div class="medias">
                            @if ($doctor->facebook)
                                <a target="_blank" href="{{ $doctor->facebook }}">
                                    <svg width="19" height="19" version="1.1" id="Layer_1"
                                        xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 291.319 291.319"
                                        xml:space="preserve">
                                        <g>
                                            <path style="fill:#3B5998;" d="M145.659,0c80.45,0,145.66,65.219,145.66,145.66c0,80.45-65.21,145.659-145.66,145.659
                                                S0,226.109,0,145.66C0,65.219,65.21,0,145.659,0z" />
                                            <path style="fill:#FFFFFF;" d="M163.394,100.277h18.772v-27.73h-22.067v0.1c-26.738,0.947-32.218,15.977-32.701,31.763h-0.055
                                            v13.847h-18.207v27.156h18.207v72.793h27.439v-72.793h22.477l4.342-27.156h-26.81v-8.366
                                            C154.791,104.556,158.341,100.277,163.394,100.277z" />
                                        </g>
                                    </svg>
                                </a>
                            @endif
                            @if ($doctor->instagram)
                                <a target="_blank" href="{{ $doctor->instagram }}">
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <rect x="1.25" y="1.25" width="17.5" height="17.5" rx="8.75"
                                            fill="url(#paint0_radial_124_18375)" />
                                        <rect x="1.25" y="1.25" width="17.5" height="17.5" rx="8.75"
                                            fill="url(#paint1_radial_124_18375)" />
                                        <rect x="1.25" y="1.25" width="17.5" height="17.5" rx="8.75"
                                            fill="url(#paint2_radial_124_18375)" />
                                        <path
                                            d="M13.5 7.25C13.5 7.66421 13.1642 8 12.75 8C12.3358 8 12 7.66421 12 7.25C12 6.83579 12.3358 6.5 12.75 6.5C13.1642 6.5 13.5 6.83579 13.5 7.25Z"
                                            fill="white" />
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M10 12.5C11.3807 12.5 12.5 11.3807 12.5 10C12.5 8.61929 11.3807 7.5 10 7.5C8.61929 7.5 7.5 8.61929 7.5 10C7.5 11.3807 8.61929 12.5 10 12.5ZM10 11.5C10.8284 11.5 11.5 10.8284 11.5 10C11.5 9.17157 10.8284 8.5 10 8.5C9.17157 8.5 8.5 9.17157 8.5 10C8.5 10.8284 9.17157 11.5 10 11.5Z"
                                            fill="white" />
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M5 9.8C5 8.11984 5 7.27976 5.32698 6.63803C5.6146 6.07354 6.07354 5.6146 6.63803 5.32698C7.27976 5 8.11984 5 9.8 5H10.2C11.8802 5 12.7202 5 13.362 5.32698C13.9265 5.6146 14.3854 6.07354 14.673 6.63803C15 7.27976 15 8.11984 15 9.8V10.2C15 11.8802 15 12.7202 14.673 13.362C14.3854 13.9265 13.9265 14.3854 13.362 14.673C12.7202 15 11.8802 15 10.2 15H9.8C8.11984 15 7.27976 15 6.63803 14.673C6.07354 14.3854 5.6146 13.9265 5.32698 13.362C5 12.7202 5 11.8802 5 10.2V9.8ZM9.8 6H10.2C11.0566 6 11.6389 6.00078 12.089 6.03755C12.5274 6.07337 12.7516 6.1383 12.908 6.21799C13.2843 6.40973 13.5903 6.71569 13.782 7.09202C13.8617 7.24842 13.9266 7.47262 13.9624 7.91104C13.9992 8.36113 14 8.94342 14 9.8V10.2C14 11.0566 13.9992 11.6389 13.9624 12.089C13.9266 12.5274 13.8617 12.7516 13.782 12.908C13.5903 13.2843 13.2843 13.5903 12.908 13.782C12.7516 13.8617 12.5274 13.9266 12.089 13.9624C11.6389 13.9992 11.0566 14 10.2 14H9.8C8.94342 14 8.36113 13.9992 7.91104 13.9624C7.47262 13.9266 7.24842 13.8617 7.09202 13.782C6.71569 13.5903 6.40973 13.2843 6.21799 12.908C6.1383 12.7516 6.07337 12.5274 6.03755 12.089C6.00078 11.6389 6 11.0566 6 10.2V9.8C6 8.94342 6.00078 8.36113 6.03755 7.91104C6.07337 7.47262 6.1383 7.24842 6.21799 7.09202C6.40973 6.71569 6.71569 6.40973 7.09202 6.21799C7.24842 6.1383 7.47262 6.07337 7.91104 6.03755C8.36113 6.00078 8.94342 6 9.8 6Z"
                                            fill="white" />
                                        <defs>
                                            <radialGradient id="paint0_radial_124_18375" cx="0"
                                                cy="0" r="1" gradientUnits="userSpaceOnUse"
                                                gradientTransform="translate(7.5 14.375) rotate(-55.3758) scale(15.9498)">
                                                <stop stop-color="#B13589" />
                                                <stop offset="0.79309" stop-color="#C62F94" />
                                                <stop offset="1" stop-color="#8A3AC8" />
                                            </radialGradient>
                                            <radialGradient id="paint1_radial_124_18375" cx="0"
                                                cy="0" r="1" gradientUnits="userSpaceOnUse"
                                                gradientTransform="translate(6.875 19.375) rotate(-65.1363) scale(14.1214)">
                                                <stop stop-color="#E0E8B7" />
                                                <stop offset="0.444662" stop-color="#FB8A2E" />
                                                <stop offset="0.71474" stop-color="#E2425C" />
                                                <stop offset="1" stop-color="#E2425C" stop-opacity="0" />
                                            </radialGradient>
                                            <radialGradient id="paint2_radial_124_18375" cx="0"
                                                cy="0" r="1" gradientUnits="userSpaceOnUse"
                                                gradientTransform="translate(0.312501 1.875) rotate(-8.1301) scale(24.3068 5.19897)">
                                                <stop offset="0.156701" stop-color="#406ADC" />
                                                <stop offset="0.467799" stop-color="#6A45BE" />
                                                <stop offset="1" stop-color="#6A45BE" stop-opacity="0" />
                                            </radialGradient>
                                        </defs>
                                    </svg>
                                </a>
                            @endif
                            @if ($doctor->twitter)
                            <a target="_blank" href="{{ $doctor->twitter }}">
                                <svg width="22" height="22" viewBox="0 0 45 45" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="24" cy="24" r="20" fill="#1DA1F2"/>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M36 16.3086C35.1177 16.7006 34.1681 16.9646 33.1722 17.0838C34.1889 16.4742 34.9697 15.5095 35.3368 14.36C34.3865 14.9247 33.3314 15.3335 32.2107 15.5551C31.3123 14.5984 30.0316 14 28.6165 14C25.8975 14 23.6928 16.2047 23.6928 18.9237C23.6928 19.3092 23.7368 19.6852 23.8208 20.046C19.7283 19.8412 16.1005 17.8805 13.6719 14.9015C13.2479 15.6287 13.0055 16.4742 13.0055 17.3766C13.0055 19.0845 13.8735 20.5916 15.1958 21.4747C14.3878 21.4491 13.6295 21.2275 12.9647 20.8587V20.9203C12.9647 23.3066 14.663 25.296 16.9141 25.7496C16.5013 25.8616 16.0661 25.9224 15.6174 25.9224C15.2998 25.9224 14.991 25.8912 14.6902 25.8336C15.3166 27.7895 17.1357 29.2134 19.2899 29.2534C17.6052 30.5733 15.4822 31.3612 13.1751 31.3612C12.7767 31.3612 12.3848 31.338 12 31.2916C14.1791 32.6884 16.7669 33.5043 19.5475 33.5043C28.6037 33.5043 33.5562 26.0016 33.5562 19.4956C33.5562 19.282 33.5522 19.0693 33.5418 18.8589C34.5049 18.1629 35.34 17.2958 36 16.3086Z" fill="white"/>
                                </svg>
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="action-buttons">
                    <a href="{{ route('doctor.index') }}" class="btn patient-btn">{{ __('site.Doctor list') }}</a>
                    @role('Patient|Doctor')
                    <a href="{{ route('feedback') }}" class="btn patient-btn">{{ __('site.Feedback') }}</a>
                    @endrole
                    @role('Admin')
                    <a href="{{ route('feedback-list') }}" class="btn patient-btn">{{ __('site.Feedback') }}</a>
                    @endrole
                    @role('Doctor')
                        <a href="{{ route('doctors.calendar') }}" class="btn patient-btn">+ {{ __('site.Schedule Appointment') }}</a>
                    @endrole
                </div>
            </div>
        </div>
    </div>
@endsection

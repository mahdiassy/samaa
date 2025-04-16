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
                <form action="{{ route('doctor.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="profile-info">
                        <div class="profile-header2">
                            <div class="image-container">
                                <img src="{{ asset('assets/images/avatar1.png') }}" alt="Doctor Photo" class="profile-img"
                                    id="patientPhoto">
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
                            <input type="file" name="image" id="imageUpload" style="display:none" accept="image/*">
                        </div>
                    </div>

                    <div class="visit-details">

                        <div class="user-info">
                            <div class="text-info">
                                <p>{{ __('site.First Name') }}</p>
                                <input type="text" name="first_name" placeholder="{{ __('site.First Name') }}" value=""
                                    class="styled-input" required />
                            </div>
                            <div class="text-info">
                                <p>{{ __('site.Email Address') }}</p>
                                <input type="text" name="email" placeholder="{{ __('site.Email Address') }}" value=""
                                    class="styled-input" required/>
                            </div>
                            <div class="text-info">
                                <p>{{ __('site.Phone') }}</p>
                                <input type="text" name="phone" placeholder="{{ __('site.Phone') }}" value=""
                                    class="styled-input" />
                            </div>
                            <div class="text-info">
                                <p>{{ __('site.Specialization') }}</p>
                                <input type="text" name="specialization" placeholder="{{ __('site.Specialization') }}" value=""
                                    class="styled-input" />
                            </div>
                            <div class="text-info">
                                <p>{{ __('site.Facebook link') }}</p>
                                <input type="text" name="facebook" placeholder="{{ __('site.Facebook link') }}" value=""
                                    class="styled-input" />
                            </div>
                            <div class="text-info">
                                <p>{{ __('site.Twitter link') }}</p>
                                <input type="text" name="twitter" placeholder="{{ __('site.Twitter link') }}" value=""
                                    class="styled-input" />
                            </div>
                        </div>
                        <div class="diagnosis">
                            <div class="text-info">
                                <p>{{ __('site.Surname') }}</p>
                                <input type="text" name="last_name" placeholder="{{ __('site.Surname') }}" value=""
                                    class="styled-input" />
                            </div>
                            <div class="text-info">
                                <p>{{ __('site.Birthday') }}</p>
                                <input type="date" name="{{ __('site.Birthday') }}" value="2024-10-22"
                                    class="styled-input date-input" />
                            </div>
                            <div class="text-info">
                                <p>{{ __('site.Password') }}</p>
                                <input type="password" placeholder="XXXXXXXXX" name="password" value="" class="styled-input" />
                            </div>
                            <div class="text-info">
                                <p>{{ __('site.Address') }}</p>
                                <input type="text" name="address" placeholder="{{ __('site.Address') }}" value=""
                                    class="styled-input" />
                            </div>
                            <div class="text-info">
                                <p>{{ __('site.Instagram link') }}</p>
                                <input type="text" name="instagram" placeholder="{{ __('site.Instagram link') }}" value=""
                                    class="styled-input" />
                            </div>
                        </div>
                    </div>
                    <div class="action-buttons">
                        <button class="btn patient-btn">{{ __('site.Create') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

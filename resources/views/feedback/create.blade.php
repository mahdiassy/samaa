@extends('layouts.master2')
@section('content')
    <div class="main-content">
        @include('search_form')
        <div class="header">

        </div>
        <div>
            <div class="profile-details">
                <form action="{{ route('feedback.store') }}" method="post">
                    @csrf

                    <div class="feedback">

                        <div class="feedback-container">
                            <p class="feedback-title">{{ __('site.Feedback') }}</p>

                            <div class="text-info">
                                <p>{{ __('site.ID') }}</p>
                                <input type="text" name="id" value="{{ $newFeedback }}" class="styled-input" disabled />
                            </div>
                            <div class="text-info">
                                <p>{{ __('site.User Name') }}</p>
                                <input type="text" name="full_name" value="{{ Auth::user()->name }}" class="styled-input" required/>
                            </div>
                            <div class="text-info">
                                <p>{{ __('site.Email') }}</p>
                                <input type="email" name="email" class="styled-input" required/>
                            </div>
                            <div class="text-info">
                                <p>{{ __('site.Feedback') }} (1/10)</p>
                                <input type="number" name="feedback" placeholder="form (1-10)" min="1" max="10" value=""
                                    class="styled-input" required/>
                            </div>
                            <div class="text-info">
                                <p>{{ __('site.Date') }}</p>
                                <input type="date" name="date" value="{{ now()->format('Y-m-d') }}" class="styled-input date-input" />
                            </div>
                            <input type="hidden" name="cta_source" value="dashboard_feedback">
                            {{-- <div class="text-info">
                                <p>{{ __('site.Improvement') }} (1% - 100%)</p>
                                <input type="number" name="improvement" min="1" max="100" value="" class="styled-input"/>
                            </div> --}}
                            <div class="text-info">
                                <p style="margin-bottom: -20px">{{ __('site.Subject') }}</p>
                                <select name="subject" class="styled-input">
                                    @foreach (\App\Enums\SubjectsEnum::all() as $key)
                                        <option value="{{ $key }}">{{ __($key) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="text-info">
                                <p>{{ __('site.Message') }}</p>
                                <textarea name="message" required class="styled-input textarea-input"></textarea>
                            </div>
                        </div>
                        <div class="feedback-action-buttons">
                            <button class="btn submit-btn">{{ __('site.Submit Feedback') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

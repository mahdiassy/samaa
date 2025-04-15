@extends('layouts.master2')
@section('content')
    <div class="main-content">
        @include('search_form')
        <div class="header">
            <a href="{{ route('feedback-list') }}" onclick="history.back();" class="btn-back">
                @if (App::getLocale() == 'ar')
                <i class="fas fa-long-arrow-alt-right" aria-hidden="true"></i> {{ __('site.Go Back') }}
                @else
                <i class="fas fa-long-arrow-alt-left" aria-hidden="true"></i> {{ __('site.Go Back') }}
                @endif
            </a>

        </div>
        <div>
            <div class="profile-details">
                    <div class="feedback">

                        <div class="feedback-container">
                            <p class="feedback-title">{{ __('site.Feedback') }}</p>

                            <div class="text-info">
                                <p>{{ __('site.ID') }}</p>
                                <input type="text" name="id" value="{{ $feedback->id }}" class="styled-input" disabled />
                            </div>
                            <div class="text-info">
                                <p>{{ __('site.User Name') }}</p>
                                <input type="text" name="patient-name" value="{{ $feedback->user->name }}" class="styled-input" disabled />
                            </div>
                            <div class="text-info">
                                <p>{{ __('site.Feedback') }} (1/10)</p>
                                <input type="number" name="feedback" placeholder="form (1-10)" min="1" max="10" value="{{$feedback->feedback}}"
                                    class="styled-input" disabled />
                            </div>
                            <div class="text-info">
                                <p>{{ __('site.Date') }}</p>
                                <input name="date" value="{{ \Carbon\Carbon::parse($feedback->date)->format('m/d/Y') }}" class="styled-input date-input" disabled />
                            </div>
                            <div class="text-info">
                                <p>{{ __('site.Improvement') }} (1% - 100%)</p>
                                <input type="number" name="improvement" min="1" max="100" value="{{$feedback->improvement}}" class="styled-input" disabled />
                            </div>
                            <div class="text-info">
                                <p>{{ __('site.Note') }}</p>
                                <textarea name="note" value="{{$feedback->note}}" class="styled-input textarea-input" disabled >{{$feedback->note}}</textarea>
                            </div>
                        </div>

                    </div>
            </div>
        </div>
    </div>
@endsection

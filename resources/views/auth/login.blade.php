@extends('layouts.base')
@section('content')
    <section class="login-section">
        <div class="login-container">
            <div class="login-text">
                <h2>{{ __('site.Welcome to') }} <span>{{ __('site.Sama’a') }} </span></h2>
                @if (App::getLocale() == 'ar')
                    <h1 class="heal-Arabic">
                        صحت<span class="different-r-Arabic">ك</span> في سمع<span class="different-l-Arabic">ك</span>
                    </h1>
                @else
                    <h1 class="heal">
                        Hea<span class="different-r">r</span> to Hea<span class="different-l">l</span>
                    </h1>
                @endif
            </div>
            <div class="contact-form">
                <form class="form-horizontal form-simple" action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <input type="email" name="email" placeholder=" {{ __('site.Email Address') }}*" required>
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" placeholder=" {{ __('site.Enter Your Password') }}*" required>
                    </div>
                    <button type="submit"> {{ __('site.Submit') }}</button>
                </form>
            </div>
        </div>
    </section>
@endsection

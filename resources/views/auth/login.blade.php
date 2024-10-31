@extends('layouts.base')
@section('content')
    <section class="login-section">
        <div class="login-container">
            <div class="login-text">
                <h2>Welcome to <span>SAMAA </span></h2>
                <h1>Hear to Heal</h1>
            </div>
            <div class="contact-form">
                <form class="form-horizontal form-simple" action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <input type="email" name="email" placeholder="Email Address*" required>
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" placeholder="Enter Your Password*" required>
                    </div>
                    <button type="submit">Submit</button>
                </form>
            </div>
        </div>
    </section>
@endsection

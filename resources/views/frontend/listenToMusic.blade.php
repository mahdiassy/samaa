@extends('layouts.master2')
@section('content')
    <div class="search-bar" style="background-image: url('/assets/images/listen2.png');" >
        <input type="text" placeholder="Search...">
    </div>

    <div class="content">
        <h1>Music for everyone</h1>

        <div class="music-options">
            <div class="music-option">
                <img src="{{ asset('assets/images/image1.png') }}" alt="Earphones">
                <label>WHAT TYPE OF MUSIC YOU PREFER TO HEAR</label>
                <select>
                    <option value="">cccc</option>
                    <option value="">hi</option>
                </select>
            </div>
            <div class="music-option">
                <img src="{{ asset('assets/images/image2.png') }}" alt="Expression">
                <label>DO YOU SUFFER FROM ANY SPECIFIC CONDITION</label>
                <select>
                    <option value="">cccc</option>
                    <option value="">hi</option>
                </select>
            </div>
        </div>

        <div class="questionnaire">
            <h2>Questionnaire</h2>

            <div class="questionnaire-cards">
                <div class="questionnaire-card">
                    <img src="{{ asset('assets/images/icons/money-stress.svg') }}" alt="Am I Stressed?">
                    <h3>Am I Stressed?</h3>
                    <button>Start the Quiz</button>
                </div>
                <div class="questionnaire-card">
                    <img src="{{ asset('assets/images/icons/depression.svg') }}" alt="Am I Depressed?">
                    <h3>Am I Depressed?</h3>
                    <button>Start the Quiz</button>
                </div>
                <div class="questionnaire-card">
                    <img src="{{ asset('assets/images/icons/obsessive.svg') }}" alt="How Severe Are My OCD Symptoms?">
                    <h3>How Severe Are My OCD Symptoms?</h3>
                    <button>Start the Quiz</button>
                </div>
            </div>
        </div>
    </div>
@endsection

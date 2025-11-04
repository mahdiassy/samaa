@extends('layouts.master2')
@section('content')
    <div class="admin-page-container">
        <!-- Page Header -->
        <div class="page-header">
            <div class="header-content">
                <div class="header-info">
                    <h1 class="page-title">Share Your Feedback</h1>
                    <p class="page-subtitle">Help us improve our services by sharing your experience</p>
                </div>
                <div class="header-actions">
                    <a href="{{ route('dashboard') }}" class="back-btn">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.42-1.41L7.83 13H20v-2z"/>
                        </svg>
                        Back to Dashboard
                    </a>
                </div>
            </div>
        </div>

        <!-- Feedback Info Cards -->
        <div class="feedback-info">
            <div class="info-card">
                <div class="info-icon">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.45,13.97L5.82,21L12,17.27Z"/>
                    </svg>
                </div>
                <div class="info-content">
                    <h3>Your Opinion Matters</h3>
                    <p>Every feedback helps us provide better healthcare services</p>
                </div>
            </div>
            
            <div class="info-card">
                <div class="info-icon">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                    </svg>
                </div>
                <div class="info-content">
                    <h3>Anonymous & Secure</h3>
                    <p>Your feedback is confidential and helps improve our services</p>
                </div>
            </div>
            
            <div class="info-card">
                <div class="info-icon">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                    </svg>
                </div>
                <div class="info-content">
                    <h3>Quality Improvement</h3>
                    <p>We act on feedback to continuously enhance patient care</p>
                </div>
            </div>
        </div>

        <!-- Feedback Form -->
        <div class="form-section">
            <div class="form-container">
                <div class="form-header">
                    <h3>Submit Your Feedback</h3>
                    <p>Please share your experience and help us serve you better</p>
                </div>
                
                <form action="{{ route('feedback.store') }}" method="post" class="feedback-form" id="feedbackForm">
                    @csrf
                    
                    <div class="form-grid">
                        <!-- User Information -->
                        <div class="form-section-card">
                            <h4 class="section-title">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                </svg>
                                Personal Information
                            </h4>
                            
                            <div class="form-group">
                                <label for="feedback_id" class="form-label">Feedback ID</label>
                                <input type="text" 
                                       id="feedback_id" 
                                       name="id" 
                                       value="{{ $newFeedback }}" 
                                       class="form-input" 
                                       disabled>
                            </div>

                            <div class="form-group">
                                <label for="full_name" class="form-label">Full Name</label>
                                <input type="text" 
                                       id="full_name" 
                                       name="full_name" 
                                       value="{{ Auth::user()->name }}" 
                                       class="form-input" 
                                       required>
                            </div>

                            <div class="form-group">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" 
                                       id="email" 
                                       name="email" 
                                       value="{{ Auth::user()->email }}"
                                       class="form-input" 
                                       required>
                            </div>

                            <div class="form-group">
                                <label for="date" class="form-label">Date</label>
                                <input type="date" 
                                       id="date" 
                                       name="date" 
                                       value="{{ now()->format('Y-m-d') }}" 
                                       class="form-input">
                            </div>
                        </div>

                        <!-- Feedback Details -->
                        <div class="form-section-card">
                            <h4 class="section-title">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.45,13.97L5.82,21L12,17.27Z"/>
                                </svg>
                                Your Experience
                            </h4>
                            
                            <div class="form-group">
                                <label for="subject" class="form-label">Subject Category</label>
                                <select id="subject" name="subject" class="form-select" required>
                                    @foreach(\App\Enums\SubjectsEnum::all() as $key)
                                        <option value="{{ $key }}">{{ __($key) }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="feedback" class="form-label">Overall Rating</label>
                                <div class="rating-container">
                                    <div class="rating-stars" id="ratingStars">
                                        @for($i = 1; $i <= 10; $i++)
                                            <button type="button" class="star-btn" data-rating="{{ $i }}">
                                                <svg viewBox="0 0 24 24" fill="currentColor">
                                                    <path d="M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.45,13.97L5.82,21L12,17.27Z"/>
                                                </svg>
                                            </button>
                                        @endfor
                                    </div>
                                    <div class="rating-display">
                                        <span class="rating-value" id="ratingValue">0</span>
                                        <span class="rating-label">out of 10</span>
                                    </div>
                                    <input type="hidden" id="feedback" name="feedback" value="" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="message" class="form-label">Your Message</label>
                                <textarea id="message" 
                                         name="message" 
                                         class="form-textarea" 
                                         rows="5" 
                                         placeholder="Please share your detailed feedback, suggestions, or concerns..."
                                         required></textarea>
                                <div class="character-count">
                                    <span id="charCount">0</span> / 1000 characters
                                </div>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="cta_source" value="dashboard_feedback">

                    <!-- Submit Section -->
                    <div class="submit-section">
                        <div class="submit-info">
                            <h4>Ready to Submit?</h4>
                            <p>Your feedback will be reviewed by our team and used to improve our services.</p>
                        </div>
                        
                        <div class="submit-actions">
                            <button type="submit" class="submit-btn" id="submitBtn">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/>
                                </svg>
                                Submit Feedback
                            </button>
                            <a href="{{ route('dashboard') }}" class="cancel-btn">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ratingStars = document.querySelectorAll('.star-btn');
            const ratingValue = document.getElementById('ratingValue');
            const feedbackInput = document.getElementById('feedback');
            const messageTextarea = document.getElementById('message');
            const charCount = document.getElementById('charCount');
            const submitBtn = document.getElementById('submitBtn');
            
            // Star rating functionality
            ratingStars.forEach((star, index) => {
                star.addEventListener('click', function() {
                    const rating = parseInt(this.dataset.rating);
                    
                    // Update visual stars
                    ratingStars.forEach((s, i) => {
                        if (i < rating) {
                            s.classList.add('active');
                        } else {
                            s.classList.remove('active');
                        }
                    });
                    
                    // Update display and hidden input
                    ratingValue.textContent = rating;
                    feedbackInput.value = rating;
                    
                    // Validate form
                    validateForm();
                });
            });
            
            // Character count for message
            messageTextarea.addEventListener('input', function() {
                const count = this.value.length;
                charCount.textContent = count;
                
                if (count > 1000) {
                    charCount.style.color = '#ef4444';
                    this.value = this.value.substring(0, 1000);
                    charCount.textContent = 1000;
                } else {
                    charCount.style.color = '#64748b';
                }
                
                validateForm();
            });
            
            // Form validation
            function validateForm() {
                const rating = feedbackInput.value;
                const message = messageTextarea.value.trim();
                const email = document.getElementById('email').value.trim();
                const fullName = document.getElementById('full_name').value.trim();
                
                const isValid = rating && message && email && fullName;
                submitBtn.disabled = !isValid;
                
                if (isValid) {
                    submitBtn.style.opacity = '1';
                    submitBtn.style.cursor = 'pointer';
                } else {
                    submitBtn.style.opacity = '0.6';
                    submitBtn.style.cursor = 'not-allowed';
                }
            }
            
            // Initial validation
            validateForm();
            
            // Add event listeners to all required fields
            ['email', 'full_name'].forEach(id => {
                document.getElementById(id).addEventListener('input', validateForm);
            });
            
            // Form submission
            document.getElementById('feedbackForm').addEventListener('submit', function(e) {
                if (!feedbackInput.value) {
                    e.preventDefault();
                    alert('Please select a rating before submitting.');
                    return;
                }
                
                // Add loading state
                submitBtn.innerHTML = `
                    <svg class="animate-spin" viewBox="0 0 24 24" fill="currentColor" style="width: 18px; height: 18px;">
                        <path d="M12 4V2A10 10 0 0 0 2 12h2a8 8 0 0 1 8-8z"/>
                    </svg>
                    Submitting...
                `;
                submitBtn.disabled = true;
            });
        });
    </script>
@endsection

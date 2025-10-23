@extends('layouts.master2')
@section('content')
    <div class="main-content">
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

    <style>
        /* Enhanced Feedback Form Styles */
        .main-content {
            padding: 2rem;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            min-height: 100vh;
        }

        .page-header {
            background: linear-gradient(135deg, #1e293b 0%, #334155 50%, #475569 100%);
            border-radius: 24px;
            padding: 2rem;
            margin-bottom: 2rem;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .page-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: radial-gradient(circle at 20% 80%, rgba(245, 158, 11, 0.3) 0%, transparent 50%),
                            radial-gradient(circle at 80% 20%, rgba(16, 185, 129, 0.3) 0%, transparent 50%);
            pointer-events: none;
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
            z-index: 1;
        }

        .page-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            background: linear-gradient(135deg, #ffffff 0%, #e2e8f0 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .page-subtitle {
            font-size: 1.1rem;
            opacity: 0.8;
            margin: 0;
        }

        .back-btn {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            padding: 0.75rem 1.5rem;
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
        }

        .back-btn:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateX(-4px);
        }

        .back-btn svg {
            width: 20px;
            height: 20px;
        }

        .feedback-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .info-card {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            border: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            gap: 1.5rem;
            transition: all 0.3s ease;
        }

        .info-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }

        .info-icon {
            width: 64px;
            height: 64px;
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .info-icon svg {
            width: 32px;
            height: 32px;
            color: white;
        }

        .info-content h3 {
            font-size: 1.3rem;
            font-weight: 600;
            color: #1e293b;
            margin: 0 0 0.5rem 0;
        }

        .info-content p {
            color: #64748b;
            margin: 0;
        }

        .form-section {
            background: white;
            border-radius: 20px;
            border: 1px solid #e2e8f0;
            overflow: hidden;
        }

        .form-container {
            padding: 2rem;
        }

        .form-header {
            text-align: center;
            margin-bottom: 3rem;
        }

        .form-header h3 {
            font-size: 2rem;
            font-weight: 700;
            color: #1e293b;
            margin: 0 0 0.5rem 0;
        }

        .form-header p {
            color: #64748b;
            font-size: 1.1rem;
            margin: 0;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .form-section-card {
            background: #f8fafc;
            border-radius: 16px;
            padding: 2rem;
            border: 1px solid #e2e8f0;
        }

        .section-title {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 1.25rem;
            font-weight: 600;
            color: #1e293b;
            margin: 0 0 1.5rem 0;
            padding-bottom: 1rem;
            border-bottom: 2px solid #e2e8f0;
        }

        .section-title svg {
            width: 24px;
            height: 24px;
            color: #f59e0b;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.5rem;
        }

        .form-input, .form-select, .form-textarea {
            width: 100%;
            padding: 1rem;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: white;
        }

        .form-input:focus, .form-select:focus, .form-textarea:focus {
            outline: none;
            border-color: #f59e0b;
            box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1);
        }

        .form-input:disabled {
            background: #f1f5f9;
            color: #94a3b8;
        }

        .rating-container {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .rating-stars {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .star-btn {
            background: none;
            border: none;
            cursor: pointer;
            padding: 0.25rem;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .star-btn svg {
            width: 32px;
            height: 32px;
            color: #e2e8f0;
            transition: all 0.3s ease;
        }

        .star-btn:hover svg {
            color: #fbbf24;
            transform: scale(1.1);
        }

        .star-btn.active svg {
            color: #f59e0b;
        }

        .rating-display {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 1rem;
            background: #f1f5f9;
            border-radius: 12px;
            border: 2px solid #e2e8f0;
        }

        .rating-value {
            font-size: 2rem;
            font-weight: 700;
            color: #f59e0b;
        }

        .rating-label {
            color: #64748b;
            font-weight: 500;
        }

        .character-count {
            text-align: right;
            font-size: 0.875rem;
            color: #64748b;
            margin-top: 0.5rem;
        }

        .submit-section {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            border-radius: 16px;
            padding: 2rem;
            text-align: center;
        }

        .submit-info h4 {
            font-size: 1.5rem;
            font-weight: 600;
            color: #1e293b;
            margin: 0 0 0.5rem 0;
        }

        .submit-info p {
            color: #64748b;
            margin: 0 0 2rem 0;
        }

        .submit-actions {
            display: flex;
            gap: 1rem;
            justify-content: center;
            align-items: center;
        }

        .submit-btn {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: white;
            border: none;
            padding: 1rem 2rem;
            border-radius: 12px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            font-size: 1rem;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(245, 158, 11, 0.3);
        }

        .submit-btn svg {
            width: 18px;
            height: 18px;
        }

        .cancel-btn {
            color: #64748b;
            text-decoration: none;
            padding: 1rem;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .cancel-btn:hover {
            color: #374151;
        }

        @media(max-width: 768px) {
            .main-content {
                padding: 1rem;
            }

            .header-content {
                flex-direction: column;
                gap: 1.5rem;
                text-align: center;
            }

            .feedback-info {
                grid-template-columns: 1fr;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .form-container {
                padding: 1.5rem;
            }

            .submit-actions {
                flex-direction: column;
            }

            .rating-stars {
                justify-content: center;
            }
        }
    </style>

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

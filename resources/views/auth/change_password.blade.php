@extends('layouts.master2')
@section('content')
    @extends('layouts.master2')
@section('content')
    <div class="main-content">
        <!-- Page Header -->
        <div class="page-header">
            <div class="header-content">
                <div class="header-info">
                    <h1 class="page-title">Security Settings</h1>
                    <p class="page-subtitle">Update your password to keep your account secure</p>
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

        <!-- Security Info Cards -->
        <div class="security-info">
            <div class="info-card">
                <div class="info-icon">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/>
                    </svg>
                </div>
                <div class="info-content">
                    <h3>Password Security</h3>
                    <p>Your password was last updated {{ Auth::user()->updated_at->diffForHumans() }}</p>
                </div>
            </div>
            
            <div class="info-card">
                <div class="info-icon">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4z"/>
                    </svg>
                </div>
                <div class="info-content">
                    <h3>Account Protection</h3>
                    <p>Strong passwords help protect your personal health data</p>
                </div>
            </div>
        </div>

        <!-- Change Password Form -->
        <div class="form-section">
            <div class="form-container">
                <div class="form-header">
                    <h3>Change Password</h3>
                    <p>Enter your current password and choose a new secure password</p>
                </div>
                
                <form id="changePasswordForm" action="{{ route('changePasswordSaved') }}" method="post" class="password-form">
                    @csrf
                    
                    <!-- Current Password -->
                    <div class="form-group">
                        <label for="old_password" class="form-label">
                            <svg class="label-icon" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2z"/>
                            </svg>
                            Current Password
                        </label>
                        <div class="input-wrapper">
                            <input type="password" 
                                   id="old_password" 
                                   name="old_password" 
                                   class="form-input" 
                                   placeholder="Enter your current password"
                                   required>
                            <button type="button" class="toggle-password" onclick="togglePasswordVisibility('old_password')">
                                <svg class="eye-icon" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                                </svg>
                            </button>
                        </div>
                        @error('old_password')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- New Password -->
                    <div class="form-group">
                        <label for="new_password" class="form-label">
                            <svg class="label-icon" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2z"/>
                            </svg>
                            New Password
                        </label>
                        <div class="input-wrapper">
                            <input type="password" 
                                   id="new_password" 
                                   name="new_password" 
                                   class="form-input" 
                                   placeholder="Enter your new password"
                                   required>
                            <button type="button" class="toggle-password" onclick="togglePasswordVisibility('new_password')">
                                <svg class="eye-icon" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                                </svg>
                            </button>
                        </div>
                        <!-- Password Strength Indicator -->
                        <div class="password-strength" id="passwordStrength">
                            <div class="strength-bars">
                                <div class="strength-bar"></div>
                                <div class="strength-bar"></div>
                                <div class="strength-bar"></div>
                                <div class="strength-bar"></div>
                            </div>
                            <span class="strength-text">Password strength</span>
                        </div>
                        @error('new_password')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="form-group">
                        <label for="confirm_password" class="form-label">
                            <svg class="label-icon" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                            </svg>
                            Confirm New Password
                        </label>
                        <div class="input-wrapper">
                            <input type="password" 
                                   id="confirm_password" 
                                   name="confirm_password" 
                                   class="form-input" 
                                   placeholder="Confirm your new password"
                                   required>
                            <button type="button" class="toggle-password" onclick="togglePasswordVisibility('confirm_password')">
                                <svg class="eye-icon" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                                </svg>
                            </button>
                        </div>
                        <div class="password-match" id="passwordMatch"></div>
                        @error('confirm_password')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Password Requirements -->
                    <div class="requirements-box">
                        <h4>Password Requirements:</h4>
                        <ul class="requirements-list">
                            <li class="requirement" id="req-length">
                                <svg class="req-icon" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                </svg>
                                At least 8 characters
                            </li>
                            <li class="requirement" id="req-uppercase">
                                <svg class="req-icon" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                </svg>
                                One uppercase letter
                            </li>
                            <li class="requirement" id="req-lowercase">
                                <svg class="req-icon" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                </svg>
                                One lowercase letter
                            </li>
                            <li class="requirement" id="req-number">
                                <svg class="req-icon" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                </svg>
                                One number
                            </li>
                        </ul>
                    </div>

                    <!-- Submit Button -->
                    <div class="form-actions">
                        <button type="submit" class="submit-btn" id="submitBtn" disabled>
                            <svg class="btn-icon" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2z"/>
                            </svg>
                            Update Password
                        </button>
                        <a href="{{ route('dashboard') }}" class="cancel-btn">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        /* Enhanced Change Password Styles */
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
            background-image: radial-gradient(circle at 20% 80%, rgba(16, 185, 129, 0.3) 0%, transparent 50%),
                            radial-gradient(circle at 80% 20%, rgba(59, 130, 246, 0.3) 0%, transparent 50%);
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

        .security-info {
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
        }

        .info-icon {
            width: 64px;
            height: 64px;
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
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
            margin-bottom: 2rem;
        }

        .form-header h3 {
            font-size: 1.5rem;
            font-weight: 600;
            color: #1e293b;
            margin: 0 0 0.5rem 0;
        }

        .form-header p {
            color: #64748b;
            margin: 0;
        }

        .password-form {
            max-width: 500px;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.5rem;
        }

        .label-icon {
            width: 16px;
            height: 16px;
            color: #64748b;
        }

        .input-wrapper {
            position: relative;
        }

        .form-input {
            width: 100%;
            padding: 1rem;
            padding-right: 3rem;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #f8fafc;
        }

        .form-input:focus {
            outline: none;
            border-color: #10b981;
            background: white;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
        }

        .toggle-password {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: #64748b;
            padding: 0.25rem;
            border-radius: 4px;
            transition: all 0.3s ease;
        }

        .toggle-password:hover {
            background: #f1f5f9;
        }

        .eye-icon {
            width: 20px;
            height: 20px;
        }

        .password-strength {
            margin-top: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .strength-bars {
            display: flex;
            gap: 0.25rem;
        }

        .strength-bar {
            width: 20px;
            height: 4px;
            border-radius: 2px;
            background: #e2e8f0;
            transition: background-color 0.3s ease;
        }

        .strength-bar.weak {
            background: #ef4444;
        }

        .strength-bar.medium {
            background: #f59e0b;
        }

        .strength-bar.strong {
            background: #10b981;
        }

        .strength-text {
            font-size: 0.875rem;
            color: #64748b;
        }

        .password-match {
            margin-top: 0.5rem;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .password-match.match {
            color: #10b981;
        }

        .password-match.no-match {
            color: #ef4444;
        }

        .requirements-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }

        .requirements-box h4 {
            font-size: 1rem;
            font-weight: 600;
            color: #374151;
            margin: 0 0 1rem 0;
        }

        .requirements-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .requirement {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 0;
            font-size: 0.875rem;
            color: #64748b;
        }

        .requirement.met {
            color: #10b981;
        }

        .req-icon {
            width: 16px;
            height: 16px;
            color: #e2e8f0;
        }

        .requirement.met .req-icon {
            color: #10b981;
        }

        .form-actions {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .submit-btn {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
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
        }

        .submit-btn:enabled:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(16, 185, 129, 0.3);
        }

        .submit-btn:disabled {
            background: #94a3b8;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        .btn-icon {
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

        .error-message {
            margin-top: 0.5rem;
            color: #ef4444;
            font-size: 0.875rem;
            font-weight: 500;
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

            .security-info {
                grid-template-columns: 1fr;
            }

            .form-container {
                padding: 1.5rem;
            }

            .form-actions {
                flex-direction: column;
                align-items: stretch;
            }
        }
    </style>

    <script>
        // Password visibility toggle
        function togglePasswordVisibility(inputId) {
            const input = document.getElementById(inputId);
            const icon = input.nextElementSibling.querySelector('.eye-icon');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.innerHTML = '<path d="M12 7c2.76 0 5 2.24 5 5 0 .65-.13 1.26-.36 1.83l2.92 2.92c1.51-1.26 2.7-2.89 3.43-4.75-1.73-4.39-6-7.5-11-7.5-1.4 0-2.74.25-3.98.7l2.16 2.16C10.74 7.13 11.35 7 12 7zM2 4.27l2.28 2.28.46.46C3.08 8.3 1.78 10.02 1 12c1.73 4.39 6 7.5 11 7.5 1.55 0 3.03-.3 4.38-.84l.42.42L19.73 22 21 20.73 3.27 3 2 4.27zM7.53 9.8l1.55 1.55c-.05.21-.08.43-.08.65 0 1.66 1.34 3 3 3 .22 0 .44-.03.65-.08l1.55 1.55c-.67.33-1.41.53-2.2.53-2.76 0-5-2.24-5-5 0-.79.2-1.53.53-2.2zm4.31-.78l3.15 3.15.02-.16c0-1.66-1.34-3-3-3l-.17.01z"/>';
            } else {
                input.type = 'password';
                icon.innerHTML = '<path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>';
            }
        }

        // Password strength checker
        function checkPasswordStrength(password) {
            let strength = 0;
            const checks = {
                length: password.length >= 8,
                uppercase: /[A-Z]/.test(password),
                lowercase: /[a-z]/.test(password),
                number: /\d/.test(password)
            };

            // Update requirement indicators
            Object.keys(checks).forEach(check => {
                const element = document.getElementById(`req-${check}`);
                if (checks[check]) {
                    element.classList.add('met');
                    strength++;
                } else {
                    element.classList.remove('met');
                }
            });

            // Update strength bars
            const bars = document.querySelectorAll('.strength-bar');
            const strengthText = document.querySelector('.strength-text');
            
            bars.forEach(bar => {
                bar.className = 'strength-bar';
            });

            if (strength >= 1) {
                bars[0].classList.add('weak');
                strengthText.textContent = 'Weak password';
            }
            if (strength >= 2) {
                bars[1].classList.add('weak');
            }
            if (strength >= 3) {
                bars[0].classList.remove('weak');
                bars[0].classList.add('medium');
                bars[1].classList.remove('weak');
                bars[1].classList.add('medium');
                bars[2].classList.add('medium');
                strengthText.textContent = 'Medium password';
            }
            if (strength === 4) {
                bars.forEach(bar => {
                    bar.classList.remove('weak', 'medium');
                    bar.classList.add('strong');
                });
                strengthText.textContent = 'Strong password';
            }

            return strength === 4;
        }

        // Password match checker
        function checkPasswordMatch() {
            const newPassword = document.getElementById('new_password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            const matchElement = document.getElementById('passwordMatch');

            if (confirmPassword.length > 0) {
                if (newPassword === confirmPassword) {
                    matchElement.textContent = '✓ Passwords match';
                    matchElement.className = 'password-match match';
                    return true;
                } else {
                    matchElement.textContent = '✗ Passwords do not match';
                    matchElement.className = 'password-match no-match';
                    return false;
                }
            } else {
                matchElement.textContent = '';
                matchElement.className = 'password-match';
                return false;
            }
        }

        // Form validation
        function validateForm() {
            const oldPassword = document.getElementById('old_password').value;
            const newPassword = document.getElementById('new_password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            
            const isStrongPassword = checkPasswordStrength(newPassword);
            const passwordsMatch = checkPasswordMatch();
            const allFieldsFilled = oldPassword && newPassword && confirmPassword;

            const submitBtn = document.getElementById('submitBtn');
            submitBtn.disabled = !(isStrongPassword && passwordsMatch && allFieldsFilled);
        }

        // Event listeners
        document.addEventListener('DOMContentLoaded', function() {
            const passwordInputs = ['old_password', 'new_password', 'confirm_password'];
            
            passwordInputs.forEach(inputId => {
                const input = document.getElementById(inputId);
                input.addEventListener('input', validateForm);
            });

            // Special handling for new password
            document.getElementById('new_password').addEventListener('input', function() {
                checkPasswordStrength(this.value);
                validateForm();
            });

            // Special handling for confirm password
            document.getElementById('confirm_password').addEventListener('input', function() {
                checkPasswordMatch();
                validateForm();
            });
        });
    </script>
@endsection
@endsection

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

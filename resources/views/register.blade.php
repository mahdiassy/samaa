@extends('layouts.base')
@section('content')
    <div class="register-section">
        <!-- Form Steps Content -->
        <div class="form-step personal-info active">
            <h2>Personal Information</h2>
            <div class="profile-container">
                <div class="profile-picture">
                    <img src="assets/images/profile.jfif" alt="Profile Picture">
                </div>
                <div class="vector-icon">
                    <i class="fas fa-plus"></i>
                </div>
            </div>

            <form>
                <div class="form-group">
                    <div>
                        <label>Full Name</label>

                        <input type="text" placeholder="Full Name">
                    </div>

                    <div>
                        <label>Birthday</label>
                        <input type="date" placeholder="MM/DD/YYYY">
                    </div>
                </div>
                <div class="form-group">
                    <div>
                        <label>Email</label>
                        <input type="email" placeholder="Enter Your Registered Email Address">
                    </div>
                    <div>
                        <label>Country</label>
                        <select>
                            <option>Country</option>
                            <option>Lebanon</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div>
                        <label>Phone</label>
                        <input type="tel" placeholder="0918657965">
                    </div>
                    <div>
                        <label>New Password</label>
                        <input type="password" placeholder="XXXXXXXXXXXXXXX">
                    </div>
                </div>
                <div class="form-group">
                    <div>
                        <label>Language Spoken</label>
                        <select>
                            <option>Language Spoken</option>
                            <option>Arabic</option>
                        </select>
                    </div>
                    <div>
                        <label>Confirm Password</label>
                        <input type="password" placeholder="XXXXXXXXXXXXXXX">
                    </div>
                </div>
                <div class="gender-group">
                    <label>Gender</label>
                    <div class="radio-container">
                        <label class="radio-option">
                            <input type="radio" name="gender" value="male">
                            <span></span>
                            <label>Male</label>
                        </label>
                        <label class="radio-option">
                            <input type="radio" name="gender" value="female">
                            <span></span>
                            <label>Female</label>
                        </label>
                    </div>
                </div>

                <div class="button-container">
                    <button type="button" class="next-btn" onclick="showNextStep()">Next</button>
                </div>

            </form>
        </div>

        <div class="form-step medical-history">
            <h2>Medical History</h2>
            <form>
                <div class="form-section">
                    <!-- Left Section (Inputs) -->
                    <div class="left-column">
                        <div>
                            <div class="form-group">
                                <label>Blood Type</label>
                                <select>
                                    <option>Blood Type</option>
                                    <option>A+</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Weight (kg)</label>
                                <input type="number" id="weight" class="custom-number-input" placeholder="Weight (kg)">
                                <div class="custom-number-container" style="position: relative;">
                                    <div class="spin-buttons-container">
                                        <button type="button" class="spin-button" id="incrementWeight">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M8 4a.5.5 0 0 1 .374.832l-4.5 5a.5.5 0 1 1-.748-.664L8 4.707l4.874 4.461a.5.5 0 0 1-.748.664l-4.5-5A.5.5 0 0 1 8 4z"/>
                                            </svg>
                                        </button>

                                        <button type="button" class="spin-button" id="decrementWeight">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-up" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M8 12a.5.5 0 0 0 .374-.832l-4.5-5a.5.5 0 1 0-.748.664L8 11.293 12.874 6.832a.5.5 0 1 0-.748-.664l-4.5 5A.5.5 0 0 0 8 12z"/>
                                            </svg>
                                        </button>

                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Height (cm)</label>
                                <input type="number" id="height" class="custom-number-input" placeholder="Height (cm)">
                                <div class="custom-number-container" style="position: relative;">
                                    <div class="spin-buttons-container">
                                        <button type="button" class="spin-button" id="increment">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M8 4a.5.5 0 0 1 .374.832l-4.5 5a.5.5 0 1 1-.748-.664L8 4.707l4.874 4.461a.5.5 0 0 1-.748.664l-4.5-5A.5.5 0 0 1 8 4z"/>
                                            </svg>
                                        </button>

                                        <button type="button" class="spin-button" id="decrement">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-up" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M8 12a.5.5 0 0 0 .374-.832l-4.5-5a.5.5 0 1 0-.748.664L8 11.293 12.874 6.832a.5.5 0 1 0-.748-.664l-4.5 5A.5.5 0 0 0 8 12z"/>
                                            </svg>
                                        </button>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="checkbox-group">
                            <input type="checkbox" id="agree">
                            <label for="agree">I Agree To The <a class="link">Terms & Conditions</a> of This Website</label>
                        </div>

                    </div>

                    <!-- Right Section (Radio Buttons) -->
                    <div class="right-column">
                        <div class="questions-group">
                            <label>Are You A Regular Smoker?</label>
                            <div class="radio-container">
                                <label class="radio-option">
                                    <input type="radio" name="smoker" value="yes">
                                    <span></span>
                                    <label>Yes</label>
                                </label>
                                <label class="radio-option">
                                    <input type="radio" name="smoker" value="no">
                                    <span></span>
                                    <label>No</label>
                                </label>
                            </div>
                        </div>
                        <div class="questions-group">
                            <label>Do You Take Permanent Medicine?</label>
                            <div class="radio-container">
                                <label class="radio-option">
                                    <input type="radio" name="medicine" value="yes">
                                    <span></span>
                                    <label>Yes</label>
                                </label>
                                <label class="radio-option">
                                    <input type="radio" name="medicine" value="no">
                                    <span></span>
                                    <label>No</label>
                                </label>
                            </div>
                        </div>
                        <div class="questions-group">
                            <label>Have You Had Any Surgery Before?</label>
                            <div class="radio-container">
                                <label class="radio-option">
                                    <input type="radio" name="surgery" value="yes">
                                    <span></span>
                                    <label>Yes</label>
                                </label>
                                <label class="radio-option">
                                    <input type="radio" name="surgery" value="no">
                                    <span></span>
                                    <label>No</label>
                                </label>
                            </div>
                        </div>
                        <div class="questions-group">
                            <label>Do you have any chronic diseases?</label>
                            <div class="radio-container">
                                <label class="radio-option">
                                    <input type="radio" name="disease" value="yes">
                                    <span></span>
                                    <label>Yes</label>
                                </label>
                                <label class="radio-option">
                                    <input type="radio" name="disease" value="no">
                                    <span></span>
                                    <label>No</label>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="button-container">
                    <button type="submit" class="done-btn">Done</button>
                </div>
            </form>
        </div>

        <div class="form-navigation">
            <div class="step-indicator">
                <span class="active-step">1</span>
                <div class="step-line"></div>
                <span>2</span>
            </div>
        </div>

        <div class="info">
            <div>
                <p>Copyright © 2022 Pharma Co. All rights reserved.</p>
            </div>
            <div>
                <p>Terms & Conditions</p>
            </div>
        </div>
        <!-- End Form Steps Content -->
    </div>
@endsection

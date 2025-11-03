@extends('layouts.base')

@section('content')
<!-- Tailwind CSS Medical Dashboard Demo -->
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-emerald-50">
    <div class="container mx-auto px-6 py-12">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl lg:text-5xl font-serif font-bold text-gradient mb-4">
                SAMAA Tailwind Components
            </h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                A showcase of our medical platform components built with Tailwind CSS
            </p>
        </div>

        <!-- Component Showcase Grid -->
        <div class="grid lg:grid-cols-2 xl:grid-cols-3 gap-8 mb-12">
            
            <!-- Button Components -->
            <div class="card">
                <div class="card-header">
                    <h3 class="text-lg font-semibold text-gray-800">Button Components</h3>
                </div>
                <div class="card-body space-y-4">
                    <button class="btn-primary w-full">Primary Button</button>
                    <button class="btn-secondary w-full">Secondary Button</button>
                    <button class="btn-outline w-full">Outline Button</button>
                    <button class="btn-danger w-full">Danger Button</button>
                </div>
            </div>

            <!-- Form Components -->
            <div class="card">
                <div class="card-header">
                    <h3 class="text-lg font-semibold text-gray-800">Form Components</h3>
                </div>
                <div class="card-body space-y-4">
                    <div>
                        <label class="form-label">Email Address</label>
                        <input type="email" class="form-input" placeholder="Enter your email">
                    </div>
                    <div>
                        <label class="form-label">Country</label>
                        <select class="form-select">
                            <option>Select country</option>
                            <option>United States</option>
                            <option>Canada</option>
                            <option>United Kingdom</option>
                        </select>
                    </div>
                    <div class="form-error">This is an error message example</div>
                </div>
            </div>

            <!-- Status Components -->
            <div class="card">
                <div class="card-header">
                    <h3 class="text-lg font-semibold text-gray-800">Status Components</h3>
                </div>
                <div class="card-body space-y-4">
                    <div class="flex flex-wrap gap-2">
                        <span class="booking-status status-pending">Pending</span>
                        <span class="booking-status status-confirmed">Confirmed</span>
                        <span class="booking-status status-completed">Completed</span>
                        <span class="booking-status status-cancelled">Cancelled</span>
                    </div>
                </div>
            </div>

        </div>

        <!-- Medical Cards Showcase -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
            
            <!-- Therapy Card Example -->
            <div class="therapy-card">
                <div class="relative">
                    <img src="{{ asset('assets/images/therapy-placeholder.jpg') }}" 
                         alt="Therapy Session" 
                         class="w-full h-48 object-cover">
                    <div class="absolute top-4 right-4">
                        <span class="booking-status status-confirmed">Active</span>
                    </div>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Relaxation Therapy</h3>
                    <p class="text-gray-600 mb-4">Calming sounds for stress relief and meditation</p>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-500">45 min session</span>
                        <button class="btn-primary">Start Session</button>
                    </div>
                </div>
            </div>

            <!-- Doctor Card Example -->
            <div class="doctor-card">
                <div class="flex items-center gap-4 mb-4">
                    <img src="{{ asset('assets/images/doctor-placeholder.jpg') }}" 
                         alt="Dr. Sarah Wilson" 
                         class="w-16 h-16 rounded-full object-cover">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">Dr. Sarah Wilson</h3>
                        <p class="text-primary-600">Clinical Psychologist</p>
                    </div>
                </div>
                <div class="space-y-2 mb-4">
                    <div class="flex items-center gap-2 text-sm text-gray-600">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                        </svg>
                        <span>15+ years experience</span>
                    </div>
                    <div class="flex items-center gap-2 text-sm text-gray-600">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                        </svg>
                        <span>4.9 rating (127 reviews)</span>
                    </div>
                </div>
                <button class="btn-outline w-full">Book Appointment</button>
            </div>

            <!-- Statistics Card -->
            <div class="card border-gradient">
                <div class="card-header bg-gradient-samaa text-white">
                    <h3 class="text-lg font-semibold">Your Progress</h3>
                </div>
                <div class="card-body">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600">Sessions Completed</span>
                            <span class="text-2xl font-bold text-primary-600">24</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600">Hours of Therapy</span>
                            <span class="text-2xl font-bold text-secondary-600">18.5</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600">Stress Reduction</span>
                            <span class="text-2xl font-bold text-emerald-600">75%</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Navigation Components -->
        <div class="card mb-12">
            <div class="card-header">
                <h3 class="text-lg font-semibold text-gray-800">Navigation Components</h3>
            </div>
            <div class="card-body">
                <nav class="flex flex-wrap gap-2">
                    <a href="#" class="nav-link-active">Dashboard</a>
                    <a href="#" class="nav-link">Therapies</a>
                    <a href="#" class="nav-link">Appointments</a>
                    <a href="#" class="nav-link">Doctors</a>
                    <a href="#" class="nav-link">Settings</a>
                </nav>
            </div>
        </div>

        <!-- Animation Examples -->
        <div class="grid md:grid-cols-3 gap-6 mb-12">
            <div class="card fade-in">
                <div class="card-body text-center">
                    <div class="w-16 h-16 bg-gradient-samaa rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                        </svg>
                    </div>
                    <h4 class="text-lg font-semibold mb-2">Fade In Animation</h4>
                    <p class="text-gray-600">Smooth fade in effect</p>
                </div>
            </div>

            <div class="card slide-up">
                <div class="card-body text-center">
                    <div class="w-16 h-16 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                        </svg>
                    </div>
                    <h4 class="text-lg font-semibold mb-2">Slide Up Animation</h4>
                    <p class="text-gray-600">Elegant slide up motion</p>
                </div>
            </div>

            <div class="card shadow-samaa">
                <div class="card-body text-center">
                    <div class="w-16 h-16 bg-gradient-to-r from-emerald-500 to-teal-500 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/>
                        </svg>
                    </div>
                    <h4 class="text-lg font-semibold mb-2">Custom Shadow</h4>
                    <p class="text-gray-600">SAMAA branded shadow</p>
                </div>
            </div>
        </div>

        <!-- RTL Support Demo -->
        <div class="card">
            <div class="card-header">
                <h3 class="text-lg font-semibold text-gray-800">RTL Support (Arabic)</h3>
            </div>
            <div class="card-body" dir="rtl">
                <div class="space-y-4">
                    <div>
                        <label class="form-label">البريد الإلكتروني</label>
                        <input type="email" class="form-input" placeholder="أدخل بريدك الإلكتروني">
                    </div>
                    <div class="flex gap-2 justify-end">
                        <button class="btn-primary">إرسال</button>
                        <button class="btn-outline">إلغاء</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center mt-12 pt-8 border-t border-gray-200">
            <p class="text-gray-600">
                ✅ <strong>Phase 13 Complete:</strong> Bootstrap fully replaced with Tailwind CSS
            </p>
            <p class="text-sm text-gray-500 mt-2">
                All components are responsive, accessible, and optimized for the SAMAA medical platform
            </p>
        </div>
    </div>
</div>
@endsection
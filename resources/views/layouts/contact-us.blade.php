@extends('layouts.base')
@section('content')
    <!-- Hero Section -->
    <section class="relative min-h-screen flex items-center justify-center overflow-hidden bg-gradient-to-br from-slate-900 via-slate-800 to-blue-900">
        <!-- Scientific Grid Pattern -->
        <div class="absolute inset-0 opacity-20">
            <div class="absolute inset-0" style="background-image: radial-gradient(circle at 1px 1px, rgba(255,255,255,0.15) 1px, transparent 0); background-size: 50px 50px;"></div>
        </div>
        
        <!-- Floating Particles -->
        <div class="absolute inset-0">
            <div class="absolute top-1/4 left-1/4 w-2 h-2 bg-blue-400 rounded-full animate-ping"></div>
            <div class="absolute top-1/3 right-1/3 w-1 h-1 bg-emerald-400 rounded-full animate-pulse"></div>
            <div class="absolute bottom-1/3 left-1/3 w-1.5 h-1.5 bg-teal-400 rounded-full animate-bounce"></div>
        </div>
        
        <div class="container mx-auto px-6 relative z-10">
            <div class="text-center max-w-5xl mx-auto">
                <h1 class="text-6xl lg:text-8xl font-serif mb-8 bg-gradient-to-r from-white via-blue-100 to-emerald-100 bg-clip-text text-transparent leading-tight">
                    Get In
                    <span class="block text-5xl lg:text-7xl bg-gradient-to-r from-emerald-400 to-blue-400 bg-clip-text text-transparent">
                        Touch
                    </span>
                </h1>
                <h2 class="text-3xl lg:text-4xl text-slate-300 mb-8 font-serif">
                    We are Here to Help You Heal
                </h2>
                <p class="text-xl lg:text-2xl text-slate-400 mb-16 max-w-4xl mx-auto leading-relaxed">
                    Connect with our team of experts. Whether you're a patient seeking healing or a therapist ready to transform lives, we're here to support your journey with SAMAA.
                </p>
            </div>
        </div>
    </section>

    <!-- Contact Information Section -->
    <section class="py-20 bg-gradient-to-b from-slate-50 to-blue-50">
        <div class="container mx-auto px-6">
            <div class="grid lg:grid-cols-2 gap-16 items-start">
                <!-- Contact Details -->
                <div class="space-y-8">
                    <div class="space-y-6">
                        <h3 class="text-4xl font-serif text-slate-800 mb-8">Contact Details</h3>
                        
                        <!-- Email -->
                        <div class="flex items-start gap-6 p-6 bg-white/70 backdrop-blur-sm rounded-2xl border border-slate-200 shadow-lg">
                            <div class="w-12 h-12 bg-gradient-to-br from-emerald-400 to-blue-400 rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-xl font-bold text-slate-800 mb-2">Message</h4>
                                <a href="mailto:support@samaa.dnci.net" class="text-emerald-600 hover:text-emerald-700 font-semibold text-lg">
                                    support@samaa.dnci.net
                                </a>
                            </div>
                        </div>
                        
                        <!-- Phone -->
                        <div class="flex items-start gap-6 p-6 bg-white/70 backdrop-blur-sm rounded-2xl border border-slate-200 shadow-lg">
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-400 to-teal-400 rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-xl font-bold text-slate-800 mb-2">Contact Us</h4>
                                <a href="tel:+96105551511" class="text-emerald-600 hover:text-emerald-700 font-semibold text-lg">
                                    +961 0 551 511
                                </a>
                            </div>
                        </div>
                        
                        <!-- Location -->
                        <div class="flex items-start gap-6 p-6 bg-white/70 backdrop-blur-sm rounded-2xl border border-slate-200 shadow-lg">
                            <div class="w-12 h-12 bg-gradient-to-br from-teal-400 to-emerald-400 rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-xl font-bold text-slate-800 mb-2">Visit Us</h4>
                                <p class="text-slate-600 text-lg">
                                    Beirut, Lebanon<br>
                                    Research & Innovation Center
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Form -->
                <div class="bg-white/70 backdrop-blur-sm rounded-3xl p-8 border border-slate-200 shadow-xl">
                    <h3 class="text-3xl font-serif text-slate-800 mb-8">Send us a Message</h3>
                    
                    <form action="{{ route('contactUs.store') }}" method="POST" class="space-y-6 p-4">
                        @csrf
                        <!-- Name -->
                        <div class="flex flex-col gap-2">
                            <label for="full_name" class="block text-sm font-semibold text-slate-700 mb-2">Full Name</label>
                            <input type="text" id="full_name" name="full_name" required 
                                   class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-300"
                                   placeholder="Enter Your Name">
                        </div>
                        
                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-semibold text-slate-700 mb-2">Email Address</label>
                            <input type="email" id="email" name="email" required 
                                   class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-300"
                                   placeholder="Email Address">
                        </div>
                        
                        <!-- Subject -->
                        <div>
                            <label for="subject" class="block text-sm font-semibold text-slate-700 mb-2">Subject</label>
                            <select id="subject" name="subject" required 
                                    class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-300">
                                <option value="">Select a subject</option>
                                <option value="patient-inquiry">Patient Inquiry</option>
                                <option value="therapist-partnership">Therapist Partnership</option>
                                <option value="institutional-partnership">Institutional Partnership</option>
                                <option value="technical-support">Technical Support</option>
                                <option value="research-collaboration">Research Collaboration</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        
                        <!-- Hidden field -->
                        <input type="hidden" name="cta_source" value="contactUsPage">
                        
                        <!-- Message -->
                        <div>
                            <label for="message" class="block text-sm font-semibold text-slate-700 mb-2">How can we support your healing journey?</label>
                            <textarea id="message" name="message" rows="5" required 
                                      class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-300 resize-vertical"
                                      placeholder="Your Message"></textarea>
                        </div>
                        
                        <!-- Submit Button -->
                        <button type="submit" 
                                class="w-full px-8 py-4 bg-gradient-to-r from-emerald-600 to-blue-600 hover:from-emerald-700 hover:to-blue-700 text-white font-semibold rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg">
                            Submit
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Office Hours & Additional Info -->
    <section class="py-20 bg-gradient-to-br from-slate-900 via-blue-900 to-emerald-900">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-5xl lg:text-6xl font-serif mb-6 bg-gradient-to-r from-white to-blue-100 bg-clip-text text-transparent">
                    We're Here to <span class="bg-gradient-to-r from-emerald-400 to-blue-400 bg-clip-text text-transparent">Help</span>
                </h2>
                <p class="text-xl text-slate-300 max-w-3xl mx-auto">
                    Our dedicated team is committed to supporting your healing journey and professional growth.
                </p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8 max-w-5xl mx-auto">
                <!-- Response Time -->
                <div class="text-center bg-white/10 backdrop-blur-lg rounded-2xl p-8 border border-white/20">
                    <div class="w-16 h-16 bg-gradient-to-br from-emerald-400 to-blue-400 rounded-xl flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10 10-4.5 10-10S17.5 2 12 2zm4.2 14.2L11 13V7h1.5v5.2l4.5 2.7-.8 1.3z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-4">Quick Response</h3>
                    <p class="text-slate-300">
                        We respond to all inquiries within 24 hours during business days.
                    </p>
                </div>
                
                <!-- Expert Support -->
                <div class="text-center bg-white/10 backdrop-blur-lg rounded-2xl p-8 border border-white/20">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-400 to-teal-400 rounded-xl flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M16 4c0-1.11.89-2 2-2s2 .89 2 2-.89 2-2 2-2-.89-2-2zm4 18v-6h2.5l-2.54-7.63A2.996 2.996 0 0 0 17.13 7H14.5c-.83 0-1.5.67-1.5 1.5S13.67 10 14.5 10h1.75l.25.75L15 18H9l-1.5-7.25L8.75 10H10.5c.83 0 1.5-.67 1.5-1.5S11.33 7 10.5 7H7.87c-1.21 0-2.29.86-2.54 2.02L3 16.5H5.5V22h2v-6h3v6h2z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-4">Expert Guidance</h3>
                    <p class="text-slate-300">
                        Connect directly with our research and clinical teams for specialized support.
                    </p>
                </div>
                
                <!-- Secure Communication -->
                <div class="text-center bg-white/10 backdrop-blur-lg rounded-2xl p-8 border border-white/20">
                    <div class="w-16 h-16 bg-gradient-to-br from-teal-400 to-emerald-400 rounded-xl flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-4">Secure & Private</h3>
                    <p class="text-slate-300">
                        All communications are encrypted and HIPAA/GDPR compliant for your privacy.
                    </p>
                </div>
            </div>
        </div>
    </section>

@extends('layouts.master2')
@section('content')
    <div class="main-content">
        <!-- Dashboard Header -->
        <div class="dashboard-header">
            <div class="header-content">
                <div class="welcome-section">
                    <h1 class="dashboard-title">
                        Welcome back, 
                        @php($user = Auth::user())
                        @if($user && $user->hasRole('Patient'))
                            {{ optional($user->patient)->first_name ?? $user->name ?? 'Guest' }}
                        @elseif($user && $user->hasRole('Doctor'))
                            Dr. {{ optional($user->doctor)->first_name ?? $user->name ?? 'Guest' }}
                        @else
                            {{ $user->name ?? 'Guest' }}
                        @endif
                    </h1>
                    <p class="dashboard-subtitle">Your healing journey continues here</p>
                </div>
                <div class="dashboard-stats">
                    <div class="stat-card">
                        <div class="stat-icon therapy-icon">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/>
                            </svg>
                        </div>
                        <div class="stat-content">
                            <h3>Active Sessions</h3>
                            <p class="stat-number">12</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon progress-icon">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                            </svg>
                        </div>
                        <div class="stat-content">
                            <h3>Progress</h3>
                            <p class="stat-number">85%</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions Grid -->
        <div class="quick-actions">
            <h2 class="section-title">Quick Actions</h2>
            <div class="actions-grid">
                @role('Patient')
                <div class="action-card" onclick="location.href='{{ route('patients.booking.index') }}'">
                    <div class="action-icon">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7z"/>
                        </svg>
                    </div>
                    <h3>My Bookings</h3>
                    <p>View and manage your therapy sessions</p>
                </div>
                @endrole

                @role('Doctor')
                <div class="action-card" onclick="location.href='{{ route('doctors.booking.index') }}'">
                    <div class="action-icon">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7z"/>
                        </svg>
                    </div>
                    <h3>Patients Booking</h3>
                    <p>Manage patient appointments and sessions</p>
                </div>

                <div class="action-card" onclick="location.href='{{ route('doctors.calendar') }}'">
                    <div class="action-icon">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                        </svg>
                    </div>
                    <h3>Schedule</h3>
                    <p>View your calendar and appointments</p>
                </div>
                @endrole

                <div class="action-card" onclick="location.href='{{ route('therapy.index') }}'">
                    <div class="action-icon">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 3v10.55c-.59-.34-1.27-.55-2-.55-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4V7h4V3h-6z"/>
                        </svg>
                    </div>
                    <h3>Therapy Sessions</h3>
                    <p>Access your healing sound library</p>
                </div>

                @role('Admin|Doctor')
                <div class="action-card" onclick="location.href='{{ route('patient.index') }}'">
                    <div class="action-icon">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M16 4c0-1.11.89-2 2-2s2 .89 2 2-.89 2-2 2-2-.89-2-2zm4 18v-6h2.5l-2.54-7.63A2.996 2.996 0 0 0 17.04 6H16c-.8 0-1.54.37-2.01.97L12 9.5 9.01 6.97A2.495 2.495 0 0 0 7 6H5.96c-1.29 0-2.4.82-2.82 2.01L1 16h2.5v6h2v-6h2.5v6h2v-6h2.5v6h2z"/>
                        </svg>
                    </div>
                    <h3>Patient List</h3>
                    <p>Manage and view all patients</p>
                </div>
                @endrole

                <div class="action-card" onclick="location.href='{{ route('doctor.index') }}'">
                    <div class="action-icon">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M19 8h-2v3h-3v2h3v3h2v-3h3v-2h-3zM4 8h6v6H4zm0 8h6v2H4zm8 0h2v2h-2zm0-8h2v6h-2z"/>
                        </svg>
                    </div>
                    <h3>Doctor Directory</h3>
                    <p>Browse available therapists</p>
                </div>

                @role('Doctor|Patient')
                <div class="action-card" onclick="location.href='{{ route('feedback') }}'">
                    <div class="action-icon">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                        </svg>
                    </div>
                    <h3>Feedback</h3>
                    <p>Share your experience with us</p>
                </div>
                @endrole

                @role('Admin')
                <div class="action-card" onclick="location.href='{{ route('blog.list') }}'">
                    <div class="action-icon">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M4 6H2v14c0 1.1.9 2 2 2h14v-2H4V6zm16-4H8c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-1 9H9V9h10v2zm-4 4H9v-2h6v2zm4-8H9V5h10v2z"/>
                        </svg>
                    </div>
                    <h3>Blog Management</h3>
                    <p>Create and manage blog posts</p>
                </div>
                @endrole
            </div>
        </div>

        <!-- Recent Activity & Progress -->
        <div class="dashboard-content">
            <div class="content-grid">
                <!-- Recent Activity -->
                <div class="activity-section">
                    <h3 class="section-title">Recent Activity</h3>
                    <div class="activity-list">
                        <div class="activity-item">
                            <div class="activity-icon completed">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                </svg>
                            </div>
                            <div class="activity-content">
                                <h4>Meditation Session Completed</h4>
                                <p>15-minute mindfulness therapy</p>
                                <span class="activity-time">2 hours ago</span>
                            </div>
                        </div>
                        
                        <div class="activity-item">
                            <div class="activity-icon therapy">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 3v10.55c-.59-.34-1.27-.55-2-.55-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4V7h4V3h-6z"/>
                                </svg>
                            </div>
                            <div class="activity-content">
                                <h4>New Therapy Available</h4>
                                <p>Nature sounds for anxiety relief</p>
                                <span class="activity-time">1 day ago</span>
                            </div>
                        </div>
                        
                        <div class="activity-item">
                            <div class="activity-icon appointment">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11z"/>
                                </svg>
                            </div>
                            <div class="activity-content">
                                <h4>Upcoming Session</h4>
                                <p>Dr. Smith - Tomorrow at 2:00 PM</p>
                                <span class="activity-time">Tomorrow</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Progress Chart -->
                <div class="progress-section">
                    <h3 class="section-title">Your Progress</h3>
                    <div class="progress-chart">
                        <div class="progress-circle">
                            <svg class="progress-ring" width="160" height="160">
                                <circle class="progress-ring-circle" cx="80" cy="80" r="70" 
                                        stroke-width="8" stroke="#e5e5e5" fill="transparent"/>
                                <circle class="progress-ring-circle progress" cx="80" cy="80" r="70"
                                        stroke-width="8" stroke="url(#gradient)" fill="transparent"
                                        stroke-dasharray="439.82" stroke-dashoffset="65.97"/>
                                <defs>
                                    <linearGradient id="gradient" x1="0%" y1="0%" x2="100%" y2="100%">
                                        <stop offset="0%" style="stop-color:#10b981;stop-opacity:1" />
                                        <stop offset="100%" style="stop-color:#3b82f6;stop-opacity:1" />
                                    </linearGradient>
                                </defs>
                            </svg>
                            <div class="progress-text">
                                <span class="progress-percentage">85%</span>
                                <span class="progress-label">Complete</span>
                            </div>
                        </div>
                        <div class="progress-stats">
                            <div class="stat">
                                <span class="stat-value">24</span>
                                <span class="stat-label">Sessions</span>
                            </div>
                            <div class="stat">
                                <span class="stat-value">180</span>
                                <span class="stat-label">Minutes</span>
                            </div>
                            <div class="stat">
                                <span class="stat-value">7</span>
                                <span class="stat-label">Days Streak</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recommended Therapies -->
        <div class="recommendations">
            <h3 class="section-title">Recommended for You</h3>
            <div class="therapy-cards">
                <div class="therapy-card">
                    <div class="therapy-image">
                        <div style="height: 160px; background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e1 100%); display: flex; align-items: center; justify-content: center; color: #64748b; font-size: 14px;">Nature Sounds</div>
                    </div>
                    <div class="therapy-content">
                        <h4>Nature Healing</h4>
                        <p>Calming forest sounds for deep relaxation</p>
                        <div class="therapy-meta">
                            <span class="duration">15 min</span>
                            <span class="category">Relaxation</span>
                        </div>
                    </div>
                </div>

                <div class="therapy-card">
                    <div class="therapy-image">
                        <div style="height: 160px; background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e1 100%); display: flex; align-items: center; justify-content: center; color: #64748b; font-size: 14px;">Meditation</div>
                    </div>
                    <div class="therapy-content">
                        <h4>Mindful Meditation</h4>
                        <p>Guided meditation for anxiety relief</p>
                        <div class="therapy-meta">
                            <span class="duration">20 min</span>
                            <span class="category">Meditation</span>
                        </div>
                    </div>
                </div>

                <div class="therapy-card">
                    <div class="therapy-image">
                        <div style="height: 160px; background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e1 100%); display: flex; align-items: center; justify-content: center; color: #64748b; font-size: 14px;">Sleep Therapy</div>
                    </div>
                    <div class="therapy-content">
                        <h4>Sleep Stories</h4>
                        <p>Peaceful narratives for better sleep</p>
                        <div class="therapy-meta">
                            <span class="duration">30 min</span>
                            <span class="category">Sleep</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Dashboard Styles */
        .main-content {
            padding: 2rem;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            min-height: 100vh;
        }

        .dashboard-header {
            background: linear-gradient(135deg, #1e293b 0%, #334155 50%, #475569 100%);
            border-radius: 24px;
            padding: 2rem;
            margin-bottom: 2rem;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .dashboard-header::before {
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

        .dashboard-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            background: linear-gradient(135deg, #ffffff 0%, #e2e8f0 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .dashboard-subtitle {
            font-size: 1.2rem;
            opacity: 0.8;
            margin: 0;
        }

        .dashboard-stats {
            display: flex;
            gap: 1.5rem;
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 16px;
            padding: 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            min-width: 180px;
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .therapy-icon {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        }

        .progress-icon {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        }

        .stat-icon svg {
            width: 24px;
            height: 24px;
            color: white;
        }

        .stat-content h3 {
            font-size: 0.9rem;
            margin: 0 0 0.25rem 0;
            opacity: 0.8;
        }

        .stat-number {
            font-size: 1.8rem;
            font-weight: 700;
            margin: 0;
            color: #10b981;
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 1.5rem;
        }

        .actions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
            margin-bottom: 3rem;
        }

        .action-card {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            border: 1px solid #e2e8f0;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .action-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #10b981 0%, #3b82f6 100%);
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .action-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }

        .action-card:hover::before {
            transform: scaleX(1);
        }

        .action-icon {
            width: 64px;
            height: 64px;
            background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
        }

        .action-icon svg {
            width: 32px;
            height: 32px;
            color: #475569;
        }

        .action-card h3 {
            font-size: 1.3rem;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 0.5rem;
        }

        .action-card p {
            color: #64748b;
            margin: 0;
            line-height: 1.5;
        }

        .content-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            margin-bottom: 3rem;
        }

        .activity-section, .progress-section {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            border: 1px solid #e2e8f0;
        }

        .activity-list {
            space-y: 1rem;
        }

        .activity-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem 0;
            border-bottom: 1px solid #f1f5f9;
        }

        .activity-item:last-child {
            border-bottom: none;
        }

        .activity-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .activity-icon.completed {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        }

        .activity-icon.therapy {
            background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
        }

        .activity-icon.appointment {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        }

        .activity-icon svg {
            width: 20px;
            height: 20px;
            color: white;
        }

        .activity-content h4 {
            font-size: 1rem;
            font-weight: 600;
            color: #1e293b;
            margin: 0 0 0.25rem 0;
        }

        .activity-content p {
            font-size: 0.9rem;
            color: #64748b;
            margin: 0 0 0.25rem 0;
        }

        .activity-time {
            font-size: 0.8rem;
            color: #94a3b8;
        }

        .progress-chart {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 2rem;
        }

        .progress-circle {
            position: relative;
        }

        .progress-ring-circle {
            transition: stroke-dashoffset 0.5s ease-in-out;
        }

        .progress-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
        }

        .progress-percentage {
            display: block;
            font-size: 2rem;
            font-weight: 700;
            color: #1e293b;
        }

        .progress-label {
            font-size: 0.9rem;
            color: #64748b;
        }

        .progress-stats {
            display: flex;
            gap: 2rem;
        }

        .stat {
            text-align: center;
        }

        .stat-value {
            display: block;
            font-size: 1.5rem;
            font-weight: 700;
            color: #1e293b;
        }

        .stat-label {
            font-size: 0.9rem;
            color: #64748b;
        }

        .therapy-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
        }

        .therapy-card {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid #e2e8f0;
            transition: all 0.3s ease;
        }

        .therapy-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }

        .therapy-content {
            padding: 1.5rem;
        }

        .therapy-content h4 {
            font-size: 1.2rem;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 0.5rem;
        }

        .therapy-content p {
            color: #64748b;
            margin-bottom: 1rem;
        }

        .therapy-meta {
            display: flex;
            gap: 1rem;
        }

        .duration, .category {
            background: #f1f5f9;
            color: #475569;
            padding: 0.25rem 0.75rem;
            border-radius: 12px;
            font-size: 0.8rem;
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

            .dashboard-stats {
                flex-direction: column;
                width: 100%;
            }

            .content-grid {
                grid-template-columns: 1fr;
            }

            .actions-grid {
                grid-template-columns: 1fr;
            }

            .therapy-cards {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endsection

@extends('layouts.master2')
@section('content')
    <div class="main-content">
        <!-- Page Header -->
        <div class="page-header">
            <div class="header-content">
                <div class="header-info">
                    <h1 class="page-title">Therapy Sessions</h1>
                    <p class="page-subtitle">Explore our comprehensive therapy programs and treatments</p>
                </div>
                <div class="header-actions">
                    <div class="search-container">
                        <svg class="search-icon" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
                        </svg>
                        <input type="text" placeholder="Search therapies..." id="therapySearch" class="search-input">
                    </div>
                    
                    @if(!$therapies->isEmpty())
                        <a href="{{ route('playlist') }}" class="playlist-btn">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M14,3V5H17.59L7.76,14.83L9.17,16.24L19,6.41V10H21V3M19,19H5V5H12V3H5C3.89,3 3,3.9 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V12H19V19Z"/>
                            </svg>
                            My Playlist
                        </a>
                    @endif
                    
                    @role('Admin')
                        <a href="{{ route('admin_therapy_create') }}" class="add-btn">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
                            </svg>
                            Add Therapy
                        </a>
                    @endrole
                    
                    @role('Doctor')
                        <a href="{{ route('doctors.booking.index') }}" class="add-btn secondary">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7z"/>
                            </svg>
                            Patient Bookings
                        </a>
                    @endrole
                    
                    @role('Patient')
                        <a href="{{ route('patients.booking.index') }}" class="add-btn secondary">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7z"/>
                            </svg>
                            My Bookings
                        </a>
                    @endrole
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon therapy-icon">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M11.5,1L2,6V8H21V6M16,10V17H20V15H22V17A2,2 0 0,1 20,19H16A2,2 0 0,1 14,17V10M4,17V15H6V17A2,2 0 0,1 4,19H8A2,2 0 0,1 6,17V10A2,2 0 0,1 8,8H4A2,2 0 0,1 6,6V10M8,10V17H12A2,2 0 0,1 10,19H14A2,2 0 0,1 12,17V10"/>
                    </svg>
                </div>
                <div class="stat-content">
                    <h3>{{ $therapies->total() }}</h3>
                    <p>Total Therapies</p>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon active-icon">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                    </svg>
                </div>
                <div class="stat-content">
                    <h3>{{ $therapies->count() }}</h3>
                    <p>Available Sessions</p>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon doctor-icon">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2C13.1 2 14 2.9 14 4C14 5.1 13.1 6 12 6C10.9 6 10 5.1 10 4C10 2.9 10.9 2 12 2ZM21 9V7L15 7.5V9M21 11H15V13H21V11ZM21 15H15V17H21V15ZM9 8C9.5 8 10 8.5 10 9V22H8V18H4V22H2V9C2 8.5 2.5 8 3 8H9ZM8 10H4V16H8V10Z"/>
                    </svg>
                </div>
                <div class="stat-content">
                    <h3>{{ collect($therapies->items())->unique('user_id')->count() }}</h3>
                    <p>Therapists</p>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon success-icon">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.45,13.97L5.82,21L12,17.27Z"/>
                    </svg>
                </div>
                <div class="stat-content">
                    <h3>4.9</h3>
                    <p>Success Rate</p>
                </div>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="filter-section">
            <div class="filter-container">
                <div class="filter-item">
                    <label for="therapistFilter">Therapist</label>
                    <select id="therapistFilter" class="filter-select">
                        <option value="">All Therapists</option>
                        @foreach($therapies->pluck('user.name')->unique() as $therapist)
                            <option value="{{ $therapist }}">{{ $therapist }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="filter-item">
                    <label for="typeFilter">Therapy Type</label>
                    <select id="typeFilter" class="filter-select">
                        <option value="">All Types</option>
                        <option value="cognitive">Cognitive Behavioral</option>
                        <option value="group">Group Therapy</option>
                        <option value="individual">Individual</option>
                        <option value="family">Family Therapy</option>
                    </select>
                </div>
                
                <div class="filter-item">
                    <label for="dateFilter">Date Range</label>
                    <select id="dateFilter" class="filter-select">
                        <option value="">All Dates</option>
                        <option value="today">Today</option>
                        <option value="week">This Week</option>
                        <option value="month">This Month</option>
                    </select>
                </div>
                
                <button class="clear-filters-btn" onclick="clearAllFilters()">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                    </svg>
                    Clear Filters
                </button>
            </div>
        </div>

        <!-- Therapies Grid -->
        <div class="therapies-section">
            <div class="section-header">
                <h2>Available Therapy Sessions</h2>
                <p>Choose from our range of professional therapy programs</p>
            </div>
            
            <div class="therapies-grid" id="therapiesGrid">
                @foreach($therapies as $therapy)
                    <div class="therapy-card" data-therapist="{{ $therapy->user->name }}" data-date="{{ $therapy->created_at->format('Y-m-d') }}">
                        <div class="therapy-header">
                            <div class="therapy-type-badge">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2Z"/>
                                </svg>
                                {{ ucfirst($therapy->type ?? 'Individual') }}
                            </div>
                            <div class="therapy-status available">
                                <div class="status-dot"></div>
                                Available
                            </div>
                        </div>
                        
                        <div class="therapy-content">
                            <h3 class="therapy-name">{{ $therapy->name }}</h3>
                            <p class="therapy-description">{{ $therapy->description ?? 'Professional therapy session designed to help you achieve your mental health goals.' }}</p>
                            
                            <div class="therapy-details">
                                <div class="detail-item">
                                    <svg class="detail-icon" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12 2C13.1 2 14 2.9 14 4C14 5.1 13.1 6 12 6C10.9 6 10 5.1 10 4C10 2.9 10.9 2 12 2ZM21 9V7L15 7.5V9M21 11H15V13H21V11ZM21 15H15V17H21V15ZM9 8C9.5 8 10 8.5 10 9V22H8V18H4V22H2V9C2 8.5 2.5 8 3 8H9ZM8 10H4V16H8V10Z"/>
                                    </svg>
                                    <span>Dr. {{ $therapy->user->name }}</span>
                                </div>
                                
                                <div class="detail-item">
                                    <svg class="detail-icon" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7z"/>
                                    </svg>
                                    <span>Created {{ $therapy->created_at->format('M d, Y') }}</span>
                                </div>
                                
                                <div class="detail-item">
                                    <svg class="detail-icon" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm3.5 6L12 10.5 8.5 8 12 5.5 15.5 8zM12 13.5l3.5 2.5L12 18.5 8.5 16l3.5-2.5z"/>
                                    </svg>
                                    <span>Updated {{ $therapy->updated_at->diffForHumans() }}</span>
                                </div>
                            </div>
                            
                            <div class="therapy-features">
                                <span class="feature-tag">
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                    </svg>
                                    Evidence-Based
                                </span>
                                <span class="feature-tag">
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                    </svg>
                                    Personalized
                                </span>
                            </div>
                        </div>
                        
                        <div class="therapy-actions">
                            @role('Patient')
                                <a href="#" class="action-btn primary" onclick="bookTherapy({{ $therapy->id }})">
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7z"/>
                                    </svg>
                                    Book Session
                                </a>
                            @endrole
                            
                            <a href="{{ route('therapy.show', $therapy) }}" class="action-btn secondary">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                                </svg>
                                View Details
                            </a>
                            
                            @role('Admin|Doctor')
                                <a href="{{ route('therapy.edit', $therapy) }}" class="action-btn edit">
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/>
                                    </svg>
                                    Edit
                                </a>
                                
                                <button class="action-btn delete" onclick="deleteTherapy({{ $therapy->id }})">
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/>
                                    </svg>
                                    Delete
                                </button>
                                
                                <form action="{{ route('therapy.destroy', $therapy) }}" method="post" id="deleteForm-{{ $therapy->id }}" style="display: none;">
                                    @csrf
                                    @method('delete')
                                </form>
                            @endrole
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="pagination-container">
                {{ $therapies->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>

    <style>
        /* Enhanced Therapy List Styles */
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
            background-image: radial-gradient(circle at 20% 80%, rgba(139, 92, 246, 0.3) 0%, transparent 50%),
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

        .header-actions {
            display: flex;
            gap: 1rem;
            align-items: center;
            flex-wrap: wrap;
        }

        .search-container {
            position: relative;
        }

        .search-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            width: 20px;
            height: 20px;
            color: #64748b;
        }

        .search-input {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            padding: 0.75rem 1rem 0.75rem 3rem;
            color: white;
            width: 300px;
            transition: all 0.3s ease;
        }

        .search-input::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }

        .search-input:focus {
            outline: none;
            background: rgba(255, 255, 255, 0.15);
            border-color: rgba(139, 92, 246, 0.5);
        }

        .add-btn, .playlist-btn {
            color: white;
            text-decoration: none;
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
        }

        .add-btn {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        }

        .add-btn.secondary {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        }

        .playlist-btn {
            background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
        }

        .add-btn:hover, .playlist-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
        }

        .add-btn svg, .playlist-btn svg {
            width: 18px;
            height: 18px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            border: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            gap: 1.5rem;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }

        .stat-icon {
            width: 64px;
            height: 64px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .therapy-icon {
            background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
        }

        .active-icon {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        }

        .doctor-icon {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        }

        .success-icon {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        }

        .stat-icon svg {
            width: 32px;
            height: 32px;
            color: white;
        }

        .stat-content h3 {
            font-size: 2rem;
            font-weight: 700;
            color: #1e293b;
            margin: 0 0 0.25rem 0;
        }

        .stat-content p {
            color: #64748b;
            margin: 0;
            font-weight: 500;
        }

        .filter-section {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 2rem;
            border: 1px solid #e2e8f0;
        }

        .filter-container {
            display: flex;
            gap: 2rem;
            align-items: end;
            flex-wrap: wrap;
        }

        .filter-item {
            flex: 1;
            min-width: 200px;
        }

        .filter-item label {
            display: block;
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.5rem;
        }

        .filter-select {
            width: 100%;
            padding: 0.75rem;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 1rem;
            background: #f8fafc;
            transition: all 0.3s ease;
        }

        .filter-select:focus {
            outline: none;
            border-color: #8b5cf6;
            background: white;
        }

        .clear-filters-btn {
            background: #f1f5f9;
            border: 1px solid #e2e8f0;
            color: #64748b;
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
        }

        .clear-filters-btn:hover {
            background: #e2e8f0;
        }

        .clear-filters-btn svg {
            width: 16px;
            height: 16px;
        }

        .therapies-section {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            border: 1px solid #e2e8f0;
        }

        .section-header {
            text-align: center;
            margin-bottom: 3rem;
        }

        .section-header h2 {
            font-size: 2rem;
            font-weight: 700;
            color: #1e293b;
            margin: 0 0 0.5rem 0;
        }

        .section-header p {
            color: #64748b;
            font-size: 1.1rem;
            margin: 0;
        }

        .therapies-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(400px, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
        }

        .therapy-card {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.3s ease;
            position: relative;
        }

        .therapy-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            border-color: #8b5cf6;
        }

        .therapy-header {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            padding: 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .therapy-type-badge {
            background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .therapy-type-badge svg {
            width: 16px;
            height: 16px;
        }

        .therapy-status {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
            font-weight: 600;
        }

        .therapy-status.available {
            color: #10b981;
        }

        .status-dot {
            width: 8px;
            height: 8px;
            background: #10b981;
            border-radius: 50%;
            animation: pulse 2s infinite;
        }

        .therapy-content {
            padding: 1.5rem;
        }

        .therapy-name {
            font-size: 1.25rem;
            font-weight: 700;
            color: #1e293b;
            margin: 0 0 1rem 0;
        }

        .therapy-description {
            color: #64748b;
            line-height: 1.6;
            margin: 0 0 1.5rem 0;
        }

        .therapy-details {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            margin-bottom: 1.5rem;
        }

        .detail-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
            color: #64748b;
        }

        .detail-icon {
            width: 16px;
            height: 16px;
            color: #94a3b8;
            flex-shrink: 0;
        }

        .therapy-features {
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        .feature-tag {
            background: #f1f5f9;
            color: #64748b;
            padding: 0.375rem 0.75rem;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .feature-tag svg {
            width: 12px;
            height: 12px;
        }

        .therapy-actions {
            padding: 1.5rem;
            background: #f8fafc;
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        .action-btn {
            flex: 1;
            min-width: 120px;
            padding: 0.75rem 1rem;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            font-size: 0.875rem;
            border: none;
            cursor: pointer;
        }

        .action-btn svg {
            width: 16px;
            height: 16px;
        }

        .action-btn.primary {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
        }

        .action-btn.primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(16, 185, 129, 0.3);
        }

        .action-btn.secondary {
            background: #f1f5f9;
            color: #64748b;
            border: 1px solid #e2e8f0;
        }

        .action-btn.secondary:hover {
            background: #e2e8f0;
            color: #374151;
        }

        .action-btn.edit {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            color: white;
        }

        .action-btn.edit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(59, 130, 246, 0.3);
        }

        .action-btn.delete {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
        }

        .action-btn.delete:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(239, 68, 68, 0.3);
        }

        .pagination-container {
            display: flex;
            justify-content: center;
            margin-top: 2rem;
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

            .header-actions {
                flex-direction: column;
                width: 100%;
            }

            .search-input {
                width: 100%;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .filter-container {
                flex-direction: column;
                gap: 1rem;
            }

            .therapies-grid {
                grid-template-columns: 1fr;
            }

            .therapy-actions {
                flex-direction: column;
            }

            .action-btn {
                min-width: auto;
            }
        }
    </style>

    <script>
        // Search functionality
        document.getElementById('therapySearch').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const therapyCards = document.querySelectorAll('.therapy-card');

            therapyCards.forEach(card => {
                const therapyName = card.querySelector('.therapy-name').textContent.toLowerCase();
                const therapistName = card.querySelector('.detail-item span').textContent.toLowerCase();
                
                if (therapyName.includes(searchTerm) || therapistName.includes(searchTerm)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });

        // Filter functionality
        function filterTherapies() {
            const therapistFilter = document.getElementById('therapistFilter').value;
            const typeFilter = document.getElementById('typeFilter').value;
            const dateFilter = document.getElementById('dateFilter').value;
            const therapyCards = document.querySelectorAll('.therapy-card');

            therapyCards.forEach(card => {
                let showCard = true;

                // Therapist filter
                if (therapistFilter && !card.dataset.therapist.includes(therapistFilter)) {
                    showCard = false;
                }

                // Type filter (could be implemented based on therapy names or descriptions)
                if (typeFilter) {
                    const therapyName = card.querySelector('.therapy-name').textContent.toLowerCase();
                    if (!therapyName.includes(typeFilter)) {
                        showCard = false;
                    }
                }

                // Date filter
                if (dateFilter) {
                    const cardDate = new Date(card.dataset.date);
                    const today = new Date();
                    
                    if (dateFilter === 'today' && cardDate.toDateString() !== today.toDateString()) {
                        showCard = false;
                    } else if (dateFilter === 'week') {
                        const weekAgo = new Date(today.getTime() - 7 * 24 * 60 * 60 * 1000);
                        if (cardDate < weekAgo) {
                            showCard = false;
                        }
                    } else if (dateFilter === 'month') {
                        const monthAgo = new Date(today.getTime() - 30 * 24 * 60 * 60 * 1000);
                        if (cardDate < monthAgo) {
                            showCard = false;
                        }
                    }
                }

                card.style.display = showCard ? 'block' : 'none';
            });
        }

        // Clear all filters
        function clearAllFilters() {
            document.getElementById('therapistFilter').value = '';
            document.getElementById('typeFilter').value = '';
            document.getElementById('dateFilter').value = '';
            document.getElementById('therapySearch').value = '';
            
            const therapyCards = document.querySelectorAll('.therapy-card');
            therapyCards.forEach(card => {
                card.style.display = 'block';
            });
        }

        // Book therapy function
        function bookTherapy(therapyId) {
            // This would typically redirect to a booking page or open a modal
            alert('Booking functionality would be implemented here for therapy ID: ' + therapyId);
        }

        // View therapy function
        function viewTherapy(therapyId) {
            // This would typically redirect to a therapy details page
            alert('View details functionality would be implemented here for therapy ID: ' + therapyId);
        }

        // Delete therapy function
        function deleteTherapy(therapyId) {
            if (confirm('Are you sure you want to delete this therapy session?')) {
                document.getElementById('deleteForm-' + therapyId).submit();
            }
        }

        // Add event listeners to filters
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('therapistFilter').addEventListener('change', filterTherapies);
            document.getElementById('typeFilter').addEventListener('change', filterTherapies);
            document.getElementById('dateFilter').addEventListener('change', filterTherapies);
        });
    </script>
@endsection

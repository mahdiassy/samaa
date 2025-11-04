@extends('layouts.master2')
@section('content')
    <div class="admin-page-container">
        <!-- Page Header -->
        <div class="page-header">
            <div class="header-content">
                <div class="header-info">
                    <h1 class="page-title">Medical Professionals</h1>
                    <p class="page-subtitle">Discover our qualified healthcare professionals</p>
                </div>
                <div class="header-actions">
                    <div class="search-container">
                        <svg class="search-icon" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
                        </svg>
                        <input type="text" placeholder="Search doctors..." id="doctorSearch" class="search-input">
                    </div>
                    @role('Admin')
                        <a href="{{ route('doctor.create') }}" class="add-btn">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
                            </svg>
                            Add New Doctor
                        </a>
                    @endrole
                    @role('Patient')
                        <a href="{{ route('patients.booking.index') }}" class="add-btn">
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
                <div class="stat-icon doctor-icon">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2C13.1 2 14 2.9 14 4C14 5.1 13.1 6 12 6C10.9 6 10 5.1 10 4C10 2.9 10.9 2 12 2ZM21 9V7L15 7.5V9M21 11H15V13H21V11ZM21 15H15V17H21V15ZM9 8C9.5 8 10 8.5 10 9V22H8V18H4V22H2V9C2 8.5 2.5 8 3 8H9ZM8 10H4V16H8V10Z"/>
                    </svg>
                </div>
                <div class="stat-content">
                    <h3>{{ $doctors->total() }}</h3>
                    <p>Total Doctors</p>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon active-icon">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2A10 10 0 0 0 2 12A10 10 0 0 0 12 22A10 10 0 0 0 22 12A10 10 0 0 0 12 2M12 4A8 8 0 0 1 20 12A8 8 0 0 1 12 20A8 8 0 0 1 4 12A8 8 0 0 1 12 4M11 17H13V11H11V17M11 9H13V7H11V9Z"/>
                    </svg>
                </div>
                <div class="stat-content">
                    <h3>{{ $doctors->count() }}</h3>
                    <p>Available Today</p>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon specialty-icon">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12,2A3,3 0 0,1 15,5V11A3,3 0 0,1 12,14A3,3 0 0,1 9,11V5A3,3 0 0,1 12,2M19,11C19,14.53 16.39,17.44 13,17.93V21H11V17.93C7.61,17.44 5,14.53 5,11H7A5,5 0 0,0 12,16A5,5 0 0,0 17,11H19Z"/>
                    </svg>
                </div>
                <div class="stat-content">
                    <h3>{{ collect($doctors->items())->unique('specialty')->count() ?? 8 }}</h3>
                    <p>Specialties</p>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon rating-icon">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.45,13.97L5.82,21L12,17.27Z"/>
                    </svg>
                </div>
                <div class="stat-content">
                    <h3>4.8</h3>
                    <p>Avg Rating</p>
                </div>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="filter-section">
            <div class="filter-container">
                <div class="filter-item">
                    <label for="specialtyFilter">Specialty</label>
                    <select id="specialtyFilter" class="filter-select">
                        <option value="">All Specialties</option>
                        <option value="cardiology">Cardiology</option>
                        <option value="neurology">Neurology</option>
                        <option value="psychology">Psychology</option>
                        <option value="therapy">Therapy</option>
                        <option value="psychiatry">Psychiatry</option>
                    </select>
                </div>
                
                <div class="filter-item">
                    <label for="experienceFilter">Experience</label>
                    <select id="experienceFilter" class="filter-select">
                        <option value="">All Experience</option>
                        <option value="0-5">0-5 years</option>
                        <option value="5-10">5-10 years</option>
                        <option value="10+">10+ years</option>
                    </select>
                </div>
                
                <div class="filter-item">
                    <label for="ratingFilter">Rating</label>
                    <select id="ratingFilter" class="filter-select">
                        <option value="">All Ratings</option>
                        <option value="5">5 Stars</option>
                        <option value="4">4+ Stars</option>
                        <option value="3">3+ Stars</option>
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

        <!-- Doctors Grid -->
        <div class="doctors-section">
            <div class="section-header">
                <h2>Our Medical Team</h2>
                <p>Choose from our experienced healthcare professionals</p>
            </div>
            
            <div class="doctors-grid" id="doctorsGrid">
                @foreach($doctors as $doctor)
                    <div class="doctor-card" data-specialty="{{ strtolower($doctor->specialty ?? 'general') }}" data-rating="5">
                        <div class="doctor-image">
                            @if($doctor->avatar)
                                <img src="{{ asset('storage/' . $doctor->avatar) }}" alt="{{ $doctor->first_name }} {{ $doctor->last_name }}">
                            @else
                                <div class="avatar-placeholder">
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                    </svg>
                                </div>
                            @endif
                            <div class="status-badge online">
                                <div class="status-dot"></div>
                                Available
                            </div>
                        </div>
                        
                        <div class="doctor-info">
                            <h3 class="doctor-name">Dr. {{ $doctor->first_name }} {{ $doctor->last_name }}</h3>
                            <p class="doctor-specialty">{{ ucfirst($doctor->specialty ?? 'General Medicine') }}</p>
                            
                            <div class="doctor-rating">
                                <div class="stars">
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg class="star filled" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.45,13.97L5.82,21L12,17.27Z"/>
                                        </svg>
                                    @endfor
                                </div>
                                <span class="rating-text">5.0 ({{ rand(20, 150) }} reviews)</span>
                            </div>
                            
                            <div class="doctor-details">
                                <div class="detail-item">
                                    <svg class="detail-icon" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                                    </svg>
                                    <span>{{ $doctor->address ?: 'SAMAA Medical Center' }}</span>
                                </div>
                                
                                <div class="detail-item">
                                    <svg class="detail-icon" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/>
                                    </svg>
                                    <span>{{ $doctor->phone ?: '+1 (555) 000-0000' }}</span>
                                </div>
                                
                                <div class="detail-item">
                                    <svg class="detail-icon" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7z"/>
                                    </svg>
                                    <span>{{ rand(5, 25) }} years experience</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="doctor-actions">
                            @role('Patient')
                                <a href="{{ route('patients.calendar', $doctor) }}" class="action-btn primary">
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7z"/>
                                    </svg>
                                    Book Appointment
                                </a>
                            @endrole
                            
                            <a href="{{ route('doctor.show', $doctor) }}" class="action-btn secondary">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                                </svg>
                                View Profile
                            </a>
                            
                            @role('Admin')
                                <a href="{{ route('doctor.edit', $doctor) }}" class="action-btn edit">
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/>
                                    </svg>
                                    Edit
                                </a>
                            @endrole
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="pagination-container">
                {{ $doctors->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>

    <script>
        // Search functionality
        document.getElementById('doctorSearch').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const doctorCards = document.querySelectorAll('.doctor-card');

            doctorCards.forEach(card => {
                const doctorName = card.querySelector('.doctor-name').textContent.toLowerCase();
                const specialty = card.querySelector('.doctor-specialty').textContent.toLowerCase();
                
                if (doctorName.includes(searchTerm) || specialty.includes(searchTerm)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });

        // Filter functionality
        function filterDoctors() {
            const specialtyFilter = document.getElementById('specialtyFilter').value.toLowerCase();
            const experienceFilter = document.getElementById('experienceFilter').value;
            const ratingFilter = document.getElementById('ratingFilter').value;
            const doctorCards = document.querySelectorAll('.doctor-card');

            doctorCards.forEach(card => {
                let showCard = true;

                // Specialty filter
                if (specialtyFilter && !card.dataset.specialty.includes(specialtyFilter)) {
                    showCard = false;
                }

                // Rating filter
                if (ratingFilter && parseInt(card.dataset.rating) < parseInt(ratingFilter)) {
                    showCard = false;
                }

                card.style.display = showCard ? 'block' : 'none';
            });
        }

        // Clear all filters
        function clearAllFilters() {
            document.getElementById('specialtyFilter').value = '';
            document.getElementById('experienceFilter').value = '';
            document.getElementById('ratingFilter').value = '';
            document.getElementById('doctorSearch').value = '';
            
            const doctorCards = document.querySelectorAll('.doctor-card');
            doctorCards.forEach(card => {
                card.style.display = 'block';
            });
        }

        // Add event listeners to filters
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('specialtyFilter').addEventListener('change', filterDoctors);
            document.getElementById('experienceFilter').addEventListener('change', filterDoctors);
            document.getElementById('ratingFilter').addEventListener('change', filterDoctors);
        });
    </script>
@endsection

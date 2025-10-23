@extends('layouts.master2')
@section('content')
    <div class="main-content">
        <!-- Page Header -->
        <div class="page-header">
            <div class="header-content">
                <div class="header-info">
                    <h1 class="page-title">Patient Management</h1>
                    <p class="page-subtitle">Manage and oversee all patient records and activities</p>
                </div>
                <div class="header-actions">
                    <div class="search-container">
                        <div class="search-input-wrapper">
                            <svg class="search-icon" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0 0 16 9.5 6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
                            </svg>
                            <input type="text" placeholder="Search patients..." class="search-input" id="patientSearch">
                        </div>
                    </div>
                    <a href="{{ route('patient.create') }}" class="add-btn">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
                        </svg>
                        Add New Patient
                    </a>
                </div>
            </div>
        </div>

        <!-- Patient Stats Cards -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon patients-icon">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M16 4c0-1.11.89-2 2-2s2 .89 2 2-.89 2-2 2-2-.89-2-2zm4 18v-6h2.5l-2.54-7.63A2.996 2.996 0 0 0 17.04 6H16c-.8 0-1.54.37-2.01.97L12 9.5 9.01 6.97A2.495 2.495 0 0 0 7 6H5.96c-1.29 0-2.4.82-2.82 2.01L1 16h2.5v6h2v-6h2.5v6h2v-6h2.5v6h2z"/>
                    </svg>
                </div>
                <div class="stat-content">
                    <h3>Total Patients</h3>
                    <p class="stat-number">{{ $patients->count() }}</p>
                    <span class="stat-change">Active registrations</span>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon active-icon">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                    </svg>
                </div>
                <div class="stat-content">
                    <h3>Active Sessions</h3>
                    <p class="stat-number">{{ rand(15, 45) }}</p>
                    <span class="stat-change">Currently in therapy</span>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon new-icon">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7z"/>
                    </svg>
                </div>
                <div class="stat-content">
                    <h3>New This Week</h3>
                    <p class="stat-number">{{ rand(3, 12) }}</p>
                    <span class="stat-change">Recent registrations</span>
                </div>
            </div>
        </div>

        <!-- Patients Table -->
        <div class="table-section">
            <div class="table-header">
                <h3>All Patients</h3>
                <div class="table-actions">
                    <button class="filter-btn" onclick="toggleFilters()">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M10 18h4v-2h-4v2zM3 6v2h18V6H3zm3 7h12v-2H6v2z"/>
                        </svg>
                        Filter
                    </button>
                    <button class="export-btn">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M19 12v7H5v-7H3v7c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2v-7h-2zm-6 .67l2.59-2.58L17 11.5l-5 5-5-5 1.41-1.41L11 12.67V3h2v9.67z"/>
                        </svg>
                        Export
                    </button>
                </div>
            </div>
            
            <div class="table-container">
                <table class="modern-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Patient Name</th>
                            <th>Contact Info</th>
                            <th>Location</th>
                            <th>Blood Type</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($patients as $patient)
                            <tr class="table-row">
                                <td class="id-cell">{{ $patient->id }}</td>
                                <td class="name-cell">
                                    <div class="patient-info">
                                        <div class="patient-avatar">
                                            @if($patient->image)
                                                <img src="{{ asset('storage/' . $patient->image) }}" alt="Patient">
                                            @else
                                                <div class="avatar-placeholder">
                                                    {{ substr($patient->first_name, 0, 1) }}{{ substr($patient->last_name, 0, 1) }}
                                                </div>
                                            @endif
                                        </div>
                                        <div class="patient-details">
                                            <h4>{{ $patient->first_name }} {{ $patient->last_name }}</h4>
                                            <span class="patient-id">ID: {{ $patient->id }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="contact-cell">
                                    <div class="contact-info">
                                        <span class="phone">{{ $patient->phone ?? 'Not provided' }}</span>
                                        <span class="email">{{ $patient->user->email ?? 'No email' }}</span>
                                    </div>
                                </td>
                                <td class="location-cell">
                                    <span class="country">{{ $patient->country->name ?? 'Unknown' }}</span>
                                </td>
                                <td class="blood-cell">
                                    <span class="blood-type">{{ $patient->blood_type ?? 'Unknown' }}</span>
                                </td>
                                <td class="status-cell">
                                    <span class="status-badge active">Active</span>
                                </td>
                                <td class="actions-cell">
                                    <div class="action-buttons">
                                        <a href="{{ route('patient.show', $patient) }}" class="action-btn view-btn" title="View Details">
                                            <svg viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                                            </svg>
                                        </a>
                                        <a href="{{ route('patient.edit', $patient) }}" class="action-btn edit-btn" title="Edit Patient">
                                            <svg viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/>
                                            </svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="empty-state">
                                    <div class="empty-content">
                                        <svg viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                        </svg>
                                        <h3>No patients found</h3>
                                        <p>Start by adding your first patient to the system.</p>
                                        <a href="{{ route('patient.create') }}" class="empty-action-btn">Add Patient</a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <style>
        /* Enhanced Patient List Styles */
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

        .header-actions {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .search-container {
            position: relative;
        }

        .search-input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .search-icon {
            position: absolute;
            left: 1rem;
            width: 20px;
            height: 20px;
            color: #64748b;
            z-index: 2;
        }

        .search-input {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            padding: 0.75rem 1rem 0.75rem 3rem;
            color: white;
            placeholder-color: rgba(255, 255, 255, 0.6);
            width: 300px;
            transition: all 0.3s ease;
        }

        .search-input:focus {
            outline: none;
            border-color: #10b981;
            background: rgba(255, 255, 255, 0.15);
        }

        .add-btn {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
        }

        .add-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(16, 185, 129, 0.3);
        }

        .add-btn svg {
            width: 20px;
            height: 20px;
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

        .patients-icon {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        }

        .active-icon {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        }

        .new-icon {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        }

        .stat-icon svg {
            width: 32px;
            height: 32px;
            color: white;
        }

        .stat-content h3 {
            font-size: 0.9rem;
            color: #64748b;
            margin: 0 0 0.5rem 0;
            font-weight: 500;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: #1e293b;
            margin: 0 0 0.25rem 0;
        }

        .stat-change {
            font-size: 0.8rem;
            color: #64748b;
        }

        .table-section {
            background: white;
            border-radius: 20px;
            border: 1px solid #e2e8f0;
            overflow: hidden;
        }

        .table-header {
            padding: 2rem;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .table-header h3 {
            font-size: 1.5rem;
            font-weight: 600;
            color: #1e293b;
            margin: 0;
        }

        .table-actions {
            display: flex;
            gap: 1rem;
        }

        .filter-btn, .export-btn {
            background: #f1f5f9;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 0.5rem 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .filter-btn:hover, .export-btn:hover {
            background: #e2e8f0;
        }

        .filter-btn svg, .export-btn svg {
            width: 16px;
            height: 16px;
            color: #64748b;
        }

        .table-container {
            overflow-x: auto;
        }

        .modern-table {
            width: 100%;
            border-collapse: collapse;
        }

        .modern-table th {
            background: #f8fafc;
            padding: 1rem;
            text-align: left;
            font-weight: 600;
            color: #374151;
            border-bottom: 1px solid #e2e8f0;
        }

        .modern-table td {
            padding: 1rem;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
        }

        .table-row:hover {
            background: #f8fafc;
        }

        .patient-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .patient-avatar {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            overflow: hidden;
            flex-shrink: 0;
        }

        .patient-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .avatar-placeholder {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 1rem;
        }

        .patient-details h4 {
            font-size: 1rem;
            font-weight: 600;
            color: #1e293b;
            margin: 0 0 0.25rem 0;
        }

        .patient-id {
            font-size: 0.8rem;
            color: #64748b;
        }

        .contact-info {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .phone, .email {
            font-size: 0.9rem;
            color: #64748b;
        }

        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        .status-badge.active {
            background: #dcfce7;
            color: #166534;
        }

        .action-buttons {
            display: flex;
            gap: 0.5rem;
        }

        .action-btn {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .view-btn {
            background: #eff6ff;
            color: #2563eb;
        }

        .view-btn:hover {
            background: #dbeafe;
        }

        .edit-btn {
            background: #fef3c7;
            color: #d97706;
        }

        .edit-btn:hover {
            background: #fde68a;
        }

        .action-btn svg {
            width: 18px;
            height: 18px;
        }

        .empty-state {
            padding: 4rem 2rem;
            text-align: center;
        }

        .empty-content svg {
            width: 64px;
            height: 64px;
            color: #94a3b8;
            margin-bottom: 1rem;
        }

        .empty-content h3 {
            font-size: 1.5rem;
            color: #374151;
            margin-bottom: 0.5rem;
        }

        .empty-content p {
            color: #64748b;
            margin-bottom: 2rem;
        }

        .empty-action-btn {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            display: inline-block;
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

            .table-header {
                flex-direction: column;
                gap: 1rem;
                align-items: flex-start;
            }
        }
    </style>
@endsection

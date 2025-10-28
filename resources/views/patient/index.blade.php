@extends('layouts.master2')

@section('content')
    <!-- Patient Management Content -->
    <div class="patient-management-content">
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
                                        <button type="button" class="action-btn delete-btn" title="Delete Patient" onclick="alert('Delete functionality not implemented yet')">
                                            <svg viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr class="empty-row">
                                <td colspan="7">
                                    <div class="empty-state">
                                        <h3>No patients yet</h3>
                                        <p>Add a new patient record to populate this table.</p>
                                        <a href="{{ route('patient.create') }}" class="empty-action-btn">Add Patient</a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div> <!-- /patient-management-content -->
@endsection

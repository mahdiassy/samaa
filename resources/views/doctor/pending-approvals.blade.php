@extends('layouts.master2')
@section('content')
    <div class="admin-page-container">
        <!-- Page Header -->
        <div class="page-header">
            <div class="header-content">
                <div class="header-info">
                    <h1 class="page-title">
                        <i class="fas fa-user-clock" style="color: #f59e0b;"></i>
                        Doctor Applications
                    </h1>
                    <p class="page-subtitle">Review and approve doctor registration applications</p>
                </div>
                <div class="header-actions">
                    <a href="{{ route('doctor.index') }}" class="add-btn" style="background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);">
                        <i class="fas fa-arrow-left"></i>
                        Back to Doctors
                    </a>
                </div>
            </div>
        </div>

        @if(session('status'))
            <div class="alert-banner alert-{{ session('status')['type'] }}" style="margin-bottom: 2rem;">
                <div class="alert-content">
                    <i class="fas fa-{{ session('status')['type'] === 'success' ? 'check-circle' : 'exclamation-circle' }}"></i>
                    <div>
                        <h3>{{ session('status')['title'] }}</h3>
                        <p>{{ session('status')['msg'] }}</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Statistics Cards -->
        <div class="stats-grid" style="margin-bottom: 2rem;">
            <div class="stat-card" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
                <div class="stat-icon" style="background: rgba(255, 255, 255, 0.2);">
                    <i class="fas fa-user-clock" style="font-size: 1.5rem; color: white;"></i>
                </div>
                <div class="stat-content">
                    <h3 style="color: white;">{{ $pendingDoctors->total() }}</h3>
                    <p style="color: rgba(255, 255, 255, 0.9);">Pending Approval</p>
                </div>
            </div>
            
            <div class="stat-card" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                <div class="stat-icon" style="background: rgba(255, 255, 255, 0.2);">
                    <i class="fas fa-user-check" style="font-size: 1.5rem; color: white;"></i>
                </div>
                <div class="stat-content">
                    <h3 style="color: white;">{{ $approvedDoctors->total() }}</h3>
                    <p style="color: rgba(255, 255, 255, 0.9);">Approved</p>
                </div>
            </div>
            
            <div class="stat-card" style="background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);">
                <div class="stat-icon" style="background: rgba(255, 255, 255, 0.2);">
                    <i class="fas fa-users" style="font-size: 1.5rem; color: white;"></i>
                </div>
                <div class="stat-content">
                    <h3 style="color: white;">{{ $pendingDoctors->total() + $approvedDoctors->total() }}</h3>
                    <p style="color: rgba(255, 255, 255, 0.9);">Total Applications</p>
                </div>
            </div>
        </div>

        <!-- Pending Approvals Section -->
        <div class="section-container" style="margin-bottom: 3rem;">
            <div class="section-header" style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1.5rem;">
                <div style="width: 4px; height: 32px; background: linear-gradient(180deg, #f59e0b 0%, #d97706 100%); border-radius: 2px;"></div>
                <div>
                    <h2 style="font-size: 1.5rem; font-weight: 700; color: #1e293b; margin: 0;">
                        Pending Approvals
                    </h2>
                    <p style="color: #64748b; margin: 0; font-size: 0.875rem;">
                        {{ $pendingDoctors->total() }} application(s) awaiting review
                    </p>
                </div>
            </div>

            @if($pendingDoctors->count() > 0)
                <div class="doctors-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 1.5rem;">
                    @foreach($pendingDoctors as $doctor)
                        <div class="doctor-approval-card">
                            <div class="card-header" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); padding: 1rem; border-radius: 12px 12px 0 0;">
                                <div style="display: flex; align-items: center; gap: 1rem;">
                                    <div class="doctor-avatar" style="width: 64px; height: 64px; border-radius: 50%; overflow: hidden; border: 3px solid white; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                                        @if($doctor->image)
                                            <img src="{{ asset('storage/' . $doctor->image) }}" alt="{{ $doctor->full_name }}" style="width: 100%; height: 100%; object-fit: cover;">
                                        @else
                                            <div style="width: 100%; height: 100%; background: white; display: flex; align-items: center; justify-content: center;">
                                                <i class="fas fa-user-md" style="font-size: 2rem; color: #f59e0b;"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div style="flex: 1;">
                                        <h3 style="color: white; font-size: 1.125rem; font-weight: 700; margin: 0;">
                                            {{ $doctor->full_name }}
                                        </h3>
                                        <p style="color: rgba(255, 255, 255, 0.9); margin: 0.25rem 0 0 0; font-size: 0.875rem;">
                                            <i class="fas fa-envelope" style="margin-right: 0.25rem;"></i>
                                            {{ $doctor->user->email }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body" style="padding: 1.5rem; background: white;">
                                <div class="info-grid" style="display: grid; gap: 0.75rem;">
                                    @if($doctor->phone)
                                        <div style="display: flex; align-items: start; gap: 0.75rem;">
                                            <i class="fas fa-phone" style="color: #3b82f6; margin-top: 0.25rem;"></i>
                                            <div>
                                                <p style="color: #64748b; font-size: 0.75rem; margin: 0;">Phone</p>
                                                <p style="color: #1e293b; font-weight: 600; margin: 0;">{{ $doctor->phone }}</p>
                                            </div>
                                        </div>
                                    @endif

                                    @if($doctor->specialization)
                                        <div style="display: flex; align-items: start; gap: 0.75rem;">
                                            <i class="fas fa-stethoscope" style="color: #10b981; margin-top: 0.25rem;"></i>
                                            <div>
                                                <p style="color: #64748b; font-size: 0.75rem; margin: 0;">Specialization</p>
                                                <p style="color: #1e293b; font-weight: 600; margin: 0;">{{ $doctor->specialization }}</p>
                                            </div>
                                        </div>
                                    @endif

                                    @if($doctor->address)
                                        <div style="display: flex; align-items: start; gap: 0.75rem;">
                                            <i class="fas fa-map-marker-alt" style="color: #ef4444; margin-top: 0.25rem;"></i>
                                            <div>
                                                <p style="color: #64748b; font-size: 0.75rem; margin: 0;">Address</p>
                                                <p style="color: #1e293b; font-weight: 600; margin: 0;">{{ $doctor->address }}</p>
                                            </div>
                                        </div>
                                    @endif

                                    @if($doctor->birthday)
                                        <div style="display: flex; align-items: start; gap: 0.75rem;">
                                            <i class="fas fa-birthday-cake" style="color: #f59e0b; margin-top: 0.25rem;"></i>
                                            <div>
                                                <p style="color: #64748b; font-size: 0.75rem; margin: 0;">Age</p>
                                                <p style="color: #1e293b; font-weight: 600; margin: 0;">{{ $doctor->age }} years old</p>
                                            </div>
                                        </div>
                                    @endif

                                    <div style="display: flex; align-items: start; gap: 0.75rem;">
                                        <i class="fas fa-clock" style="color: #8b5cf6; margin-top: 0.25rem;"></i>
                                        <div>
                                            <p style="color: #64748b; font-size: 0.75rem; margin: 0;">Applied</p>
                                            <p style="color: #1e293b; font-weight: 600; margin: 0;">{{ $doctor->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>

                                    @if($doctor->twitter || $doctor->facebook || $doctor->instagram)
                                        <div style="display: flex; align-items: start; gap: 0.75rem;">
                                            <i class="fas fa-share-alt" style="color: #06b6d4; margin-top: 0.25rem;"></i>
                                            <div>
                                                <p style="color: #64748b; font-size: 0.75rem; margin: 0 0 0.5rem 0;">Social Media</p>
                                                <div style="display: flex; gap: 0.5rem;">
                                                    @if($doctor->twitter)
                                                        <a href="{{ $doctor->twitter }}" target="_blank" style="color: #1da1f2; font-size: 1.25rem;">
                                                            <i class="fab fa-twitter"></i>
                                                        </a>
                                                    @endif
                                                    @if($doctor->facebook)
                                                        <a href="{{ $doctor->facebook }}" target="_blank" style="color: #1877f2; font-size: 1.25rem;">
                                                            <i class="fab fa-facebook"></i>
                                                        </a>
                                                    @endif
                                                    @if($doctor->instagram)
                                                        <a href="{{ $doctor->instagram }}" target="_blank" style="color: #e4405f; font-size: 1.25rem;">
                                                            <i class="fab fa-instagram"></i>
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="card-footer" style="padding: 1rem 1.5rem; background: #f8fafc; border-radius: 0 0 12px 12px; display: flex; gap: 0.75rem;">
                                <form action="{{ route('doctors.approve', $doctor) }}" method="POST" style="flex: 1;" onsubmit="return confirm('Are you sure you want to approve this doctor?');">
                                    @csrf
                                    <button type="submit" class="approve-btn" style="width: 100%; padding: 0.75rem; background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 0.5rem; transition: all 0.3s;">
                                        <i class="fas fa-check-circle"></i>
                                        Approve
                                    </button>
                                </form>
                                <form action="{{ route('doctors.reject', $doctor) }}" method="POST" style="flex: 1;" onsubmit="return confirm('Are you sure you want to reject this application? This will delete the doctor account.');">
                                    @csrf
                                    <button type="submit" class="reject-btn" style="width: 100%; padding: 0.75rem; background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 0.5rem; transition: all 0.3s;">
                                        <i class="fas fa-times-circle"></i>
                                        Reject
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div style="margin-top: 2rem;">
                    {{ $pendingDoctors->links() }}
                </div>
            @else
                <div class="empty-state" style="text-align: center; padding: 3rem; background: #f8fafc; border-radius: 12px; border: 2px dashed #cbd5e1;">
                    <i class="fas fa-check-circle" style="font-size: 4rem; color: #10b981; margin-bottom: 1rem;"></i>
                    <h3 style="font-size: 1.5rem; font-weight: 700; color: #1e293b; margin: 0 0 0.5rem 0;">
                        All Caught Up!
                    </h3>
                    <p style="color: #64748b; margin: 0;">
                        There are no pending doctor applications at the moment.
                    </p>
                </div>
            @endif
        </div>

        <!-- Recently Approved Section -->
        <div class="section-container">
            <div class="section-header" style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1.5rem;">
                <div style="width: 4px; height: 32px; background: linear-gradient(180deg, #10b981 0%, #059669 100%); border-radius: 2px;"></div>
                <div>
                    <h2 style="font-size: 1.5rem; font-weight: 700; color: #1e293b; margin: 0;">
                        Recently Approved Doctors
                    </h2>
                    <p style="color: #64748b; margin: 0; font-size: 0.875rem;">
                        {{ $approvedDoctors->total() }} doctor(s) approved and active
                    </p>
                </div>
            </div>

            @if($approvedDoctors->count() > 0)
                <div class="table-container" style="background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white;">
                                <th style="padding: 1rem; text-align: left; font-weight: 600;">Doctor</th>
                                <th style="padding: 1rem; text-align: left; font-weight: 600;">Contact</th>
                                <th style="padding: 1rem; text-align: left; font-weight: 600;">Specialization</th>
                                <th style="padding: 1rem; text-align: left; font-weight: 600;">Approved</th>
                                <th style="padding: 1rem; text-align: center; font-weight: 600;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($approvedDoctors as $doctor)
                                <tr style="border-bottom: 1px solid #e2e8f0;">
                                    <td style="padding: 1rem;">
                                        <div style="display: flex; align-items: center; gap: 0.75rem;">
                                            <div style="width: 40px; height: 40px; border-radius: 50%; overflow: hidden; background: #f1f5f9;">
                                                @if($doctor->image)
                                                    <img src="{{ asset('storage/' . $doctor->image) }}" alt="{{ $doctor->full_name }}" style="width: 100%; height: 100%; object-fit: cover;">
                                                @else
                                                    <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center;">
                                                        <i class="fas fa-user-md" style="color: #64748b;"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div>
                                                <p style="font-weight: 600; color: #1e293b; margin: 0;">{{ $doctor->full_name }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td style="padding: 1rem;">
                                        <p style="margin: 0 0 0.25rem 0; color: #64748b; font-size: 0.875rem;">
                                            <i class="fas fa-envelope" style="margin-right: 0.25rem;"></i>
                                            {{ $doctor->user->email }}
                                        </p>
                                        @if($doctor->phone)
                                            <p style="margin: 0; color: #64748b; font-size: 0.875rem;">
                                                <i class="fas fa-phone" style="margin-right: 0.25rem;"></i>
                                                {{ $doctor->phone }}
                                            </p>
                                        @endif
                                    </td>
                                    <td style="padding: 1rem;">
                                        <span style="background: #dbeafe; color: #1e40af; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.875rem; font-weight: 600;">
                                            {{ $doctor->specialization ?? 'General' }}
                                        </span>
                                    </td>
                                    <td style="padding: 1rem;">
                                        <p style="color: #64748b; margin: 0; font-size: 0.875rem;">
                                            {{ $doctor->updated_at->diffForHumans() }}
                                        </p>
                                    </td>
                                    <td style="padding: 1rem; text-align: center;">
                                        <a href="{{ route('doctor.show', $doctor) }}" style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.5rem 1rem; background: #3b82f6; color: white; border-radius: 6px; text-decoration: none; font-size: 0.875rem; font-weight: 600;">
                                            <i class="fas fa-eye"></i>
                                            View
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div style="margin-top: 2rem;">
                    {{ $approvedDoctors->links() }}
                </div>
            @else
                <div class="empty-state" style="text-align: center; padding: 3rem; background: #f8fafc; border-radius: 12px; border: 2px dashed #cbd5e1;">
                    <i class="fas fa-users" style="font-size: 4rem; color: #64748b; margin-bottom: 1rem;"></i>
                    <h3 style="font-size: 1.5rem; font-weight: 700; color: #1e293b; margin: 0 0 0.5rem 0;">
                        No Approved Doctors
                    </h3>
                    <p style="color: #64748b; margin: 0;">
                        There are no approved doctors in the system yet.
                    </p>
                </div>
            @endif
        </div>
    </div>

    <style>
        .doctor-approval-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07);
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .doctor-approval-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
            border-color: #f59e0b;
        }

        .approve-btn:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);
        }

        .reject-btn:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.4);
        }

        .alert-banner {
            padding: 1rem 1.5rem;
            border-radius: 12px;
            border-left: 4px solid;
        }

        .alert-success {
            background: #d1fae5;
            border-color: #10b981;
            color: #065f46;
        }

        .alert-error {
            background: #fee2e2;
            border-color: #ef4444;
            color: #991b1b;
        }

        .alert-content {
            display: flex;
            align-items: start;
            gap: 1rem;
        }

        .alert-content i {
            font-size: 1.5rem;
            margin-top: 0.25rem;
        }

        .alert-content h3 {
            font-weight: 700;
            margin: 0 0 0.25rem 0;
        }

        .alert-content p {
            margin: 0;
        }

        tbody tr:hover {
            background: #f8fafc;
        }
    </style>
@endsection

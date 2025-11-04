@extends('layouts.master2')

@section('content')
    @php
        $searchValue = $searchTerm ?? request('q', '');
        $latestFeedbackDate = null;

        if (!empty($latestFeedback)) {
            $latestFeedbackDate = $latestFeedback->created_at
                ? $latestFeedback->created_at
                : ($latestFeedback->date ? \Carbon\Carbon::parse($latestFeedback->date) : null);
        }
    @endphp

    <div class="admin-page-container">
        <!-- Page Header -->
        <div class="page-header">
            <div class="header-content">
                <div class="header-info">
                    <h1 class="page-title">{{ __('site.Feedback list') }}</h1>
                    <p class="page-subtitle">Monitor incoming feedback, spot trends, and follow up with confidence.</p>
                </div>

                <div class="header-actions">
                    <form method="GET" action="{{ route('feedback-list') }}" class="search-container" role="search">
                        <div class="search-input-wrapper">
                            <svg class="search-icon" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                <path d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0 0 16 9.5 6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z" />
                            </svg>
                            <input
                                type="search"
                                name="q"
                                value="{{ $searchValue }}"
                                placeholder="Search feedback..."
                                class="search-input"
                                aria-label="Search feedback"
                            >
                        </div>
                        <button type="submit" class="search-submit-btn" title="Search feedback">
                            <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                <path d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0 0 16 9.5 6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z" />
                            </svg>
                        </button>
                        @if($searchValue !== '')
                            <a href="{{ route('feedback-list') }}" class="clear-search-btn">Reset</a>
                        @endif
                    </form>

                    <a href="{{ route('feedback') }}" class="add-btn">
                        <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z" />
                        </svg>
                        Log Feedback
                    </a>
                </div>
            </div>
        </div>

        <!-- Statistics Overview -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon total-icon">
                    <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                        <path d="M12 2a10 10 0 1 0 10 10A10.011 10.011 0 0 0 12 2zm-1 15-5-5 1.41-1.41L11 14.17l7.59-7.58L20 8z" />
                    </svg>
                </div>
                <div class="stat-content">
                    <h3>{{ $totalFeedback }}</h3>
                    <p>Total feedback entries</p>
                    <span class="stat-meta">Updated {{ now()->format('M d, Y') }}</span>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon recent-icon">
                    <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                        <path d="M12 2a10 10 0 1 0 10 10A10.011 10.011 0 0 0 12 2zm1 11h4v2h-6V7h2z" />
                    </svg>
                </div>
                <div class="stat-content">
                    <h3>{{ $recentFeedbackCount }}</h3>
                    <p>New this week</p>
                    <span class="stat-meta">Past 7 days</span>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon subject-icon">
                    <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                        <path d="M3 5h18v2H3zm0 6h18v2H3zm0 6h18v2H3z" />
                    </svg>
                </div>
                <div class="stat-content">
                    <h3>{{ $uniqueSubjectsCount }}</h3>
                    <p>Topics covered</p>
                    <span class="stat-meta">Distinct subjects</span>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon latest-icon">
                    <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                        <path d="M19 3h-1V1h-2v2H8V1H6v2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2zm0 16H5V8h14z" />
                    </svg>
                </div>
                <div class="stat-content">
                    <h3>{{ $latestFeedbackDate ? $latestFeedbackDate->format('M d, Y') : '—' }}</h3>
                    <p>Last received</p>
                    <span class="stat-meta">{{ $latestFeedbackDate ? $latestFeedbackDate->diffForHumans() : 'Awaiting first entry' }}</span>
                </div>
            </div>
        </div>

        <!-- Feedback Table -->
        <div class="table-section">
            <div class="table-header">
                <div>
                    <h3>Feedback Inbox</h3>
                    <p class="table-subtitle">Review submissions and action items across the organisation.</p>
                </div>

                @if($searchValue !== '')
                    <div class="table-search-summary">
                        <span>Showing {{ $feedbacks->total() }} {{ \Illuminate\Support\Str::plural('result', $feedbacks->total()) }} for</span>
                        <strong>“{{ $searchValue }}”</strong>
                    </div>
                @endif
            </div>

            <div class="table-container">
                <table class="modern-table feedback-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Sender</th>
                            <th>Contact</th>
                            <th>Subject</th>
                            <th>Received</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($feedbacks as $feedback)
                            @php
                                $nameParts = preg_split('/\s+/u', $feedback->full_name ?? '', -1, PREG_SPLIT_NO_EMPTY);
                                $initials = strtoupper(collect($nameParts)->map(fn ($part) => mb_substr($part, 0, 1))->implode(''));
                                $initials = $initials !== '' ? mb_substr($initials, 0, 2) : 'FB';

                                $dateValue = $feedback->date
                                    ? \Carbon\Carbon::parse($feedback->date)
                                    : ($feedback->created_at ?? null);

                                $messagePreview = $feedback->message ?? $feedback->feedback;
                            @endphp

                            <tr>
                                <td class="id-cell">#{{ str_pad($feedback->id, 3, '0', STR_PAD_LEFT) }}</td>

                                <td class="name-cell">
                                    <div class="sender-info">
                                        <div class="sender-avatar" aria-hidden="true">
                                            <span class="avatar-initials">{{ $initials }}</span>
                                        </div>
                                        <div class="sender-details">
                                            <h4>{{ $feedback->full_name ?? 'Anonymous' }}</h4>
                                            @if($feedback->cta_source)
                                                <span class="sender-source">{{ ucfirst($feedback->cta_source) }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </td>

                                <td class="contact-cell">
                                    <div class="contact-info">
                                        <span class="email">{{ $feedback->email ?? 'Not provided' }}</span>
                                    </div>
                                </td>

                                <td class="subject-cell">
                                    <span class="subject-pill">{{ __($feedback->subject ?? 'General') }}</span>
                                    @if($messagePreview)
                                        <p class="message-preview">{{ \Illuminate\Support\Str::limit(strip_tags($messagePreview), 70) }}</p>
                                    @endif
                                </td>

                                <td class="date-cell">
                                    <div class="date-meta">
                                        <span class="date-primary">{{ $dateValue ? $dateValue->format('M d, Y') : '—' }}</span>
                                        <span class="date-secondary">{{ $dateValue ? $dateValue->diffForHumans() : 'Awaiting' }}</span>
                                    </div>
                                </td>

                                <td class="actions-cell">
                                    <div class="action-buttons">
                                        <a href="{{ route('feedback.show', $feedback) }}" class="action-btn view-btn" title="View feedback">
                                            <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                                <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zm0 11a3.5 3.5 0 1 1 3.5-3.5A3.5 3.5 0 0 1 12 15.5z" />
                                            </svg>
                                        </a>

                                        @role('Admin')
                                            <form
                                                action="{{ route('feedback.destroy', $feedback) }}"
                                                method="post"
                                                class="inline-delete-form"
                                                onsubmit="return confirm('Are you sure you want to delete this feedback entry?');"
                                            >
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="action-btn delete-btn" title="Delete feedback">
                                                    <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                                        <path d="M6 19a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V7H6zm3.46-9.12 1.41-1.41L12 10.59l1.12-1.12 1.41 1.41L13.41 12l1.12 1.12-1.41 1.41L12 13.41l-1.12 1.12-1.41-1.41L10.59 12l-1.13-1.12z" />
                                                    </svg>
                                                </button>
                                            </form>
                                        @endrole
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr class="empty-row">
                                <td colspan="6">
                                    <div class="empty-state">
                                        <h3>No feedback yet</h3>
                                        <p>Feedback submissions will appear here as soon as they are received.</p>
                                        <a href="{{ route('feedback') }}" class="empty-action-btn">Log Feedback</a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="table-pagination">
                {{ $feedbacks->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
@endsection

@extends('layouts.master2')

@section('content')
    @php
        $locale = app()->getLocale();
        $searchValue = $searchTerm ?? request('title', '');
    $latestPublishedAt = $latestBlog && $latestBlog->created_at ? $latestBlog->created_at : null;
    $searchRoute = request()->routeIs('blog.list') ? route('blog.list') : route('blog.index');
    $hasFeaturedColumn = $hasFeaturedColumn ?? false;
    @endphp

    <div class="admin-page-container">
        <div class="page-header">
            <div class="header-content">
                <div class="header-info">
                    <h1 class="page-title">{{ __('site.Blog list') }}</h1>
                    <p class="page-subtitle">Curate featured stories and keep your audience in the loop.</p>
                </div>

                <div class="header-actions">
                    <form method="GET" action="{{ $searchRoute }}" class="search-container" role="search">
                        <div class="search-input-wrapper">
                            <svg class="search-icon" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                <path d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0 0 16 9.5 6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z" />
                            </svg>
                            <input
                                type="search"
                                name="title"
                                value="{{ $searchValue }}"
                                placeholder="Search articles..."
                                class="search-input"
                                aria-label="Search blog articles"
                            >
                        </div>
                        <button type="submit" class="search-submit-btn" title="Search articles">
                            <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                <path d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0 0 16 9.5 6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z" />
                            </svg>
                        </button>
                        @if($searchValue !== '')
                            <a href="{{ $searchRoute }}" class="clear-search-btn">Reset</a>
                        @endif
                    </form>

                    @role('Admin')
                        <a href="{{ route('blog.create') }}" class="add-btn">
                            <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z" />
                            </svg>
                            {{ __('site.Add New Blog') }}
                        </a>
                    @endrole
                </div>
            </div>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon total-icon">
                    <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                        <path d="M19 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2zm-5 14H7v-2h7zm3-4H7v-2h10zm0-4H7V7h10z" />
                    </svg>
                </div>
                <div class="stat-content">
                    <h3>{{ $totalBlogs }}</h3>
                    <p>Total articles</p>
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
                    <h3>{{ $recentBlogs }}</h3>
                    <p>New this week</p>
                    <span class="stat-meta">Past 7 days</span>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon author-icon">
                    <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                        <path d="M12 12a5 5 0 1 0-5-5 5 5 0 0 0 5 5zm-7 9a7 7 0 0 1 14 0z" />
                    </svg>
                </div>
                <div class="stat-content">
                    <h3>{{ $activeAuthors }}</h3>
                    <p>Active authors</p>
                    <span class="stat-meta">Unique contributors</span>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon featured-icon">
                    <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.86L12 17.77 5.82 21l1.18-6.86-5-4.87 6.91-1.01z" />
                    </svg>
                </div>
                <div class="stat-content">
                    @if($hasFeaturedColumn)
                        <h3>{{ $featuredCount }}</h3>
                        <p>Featured stories</p>
                    @else
                        <h3>{{ $latestPublishedAt ? $latestPublishedAt->format('M d, Y') : '—' }}</h3>
                        <p>Last published</p>
                    @endif
                    <span class="stat-meta">
                        @if($latestPublishedAt)
                            Latest {{ $latestPublishedAt->diffForHumans() }}
                        @else
                            Awaiting first publish
                        @endif
                    </span>
                </div>
            </div>
        </div>

        <div class="table-section">
            <div class="table-header">
                <div>
                    <h3>Articles overview</h3>
                    <p class="table-subtitle">Review published entries, feature highlights, and take action quickly.</p>
                </div>

                @if($searchValue !== '')
                    <div class="table-search-summary">
                        <span>Showing {{ $blogs->total() }} {{ \Illuminate\Support\Str::plural('result', $blogs->total()) }} for</span>
                        <strong>“{{ $searchValue }}”</strong>
                    </div>
                @endif
            </div>

            <div class="table-container">
                <table class="modern-table blog-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Article</th>
                            <th>Author</th>
                            <th>Status</th>
                            <th>Published</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($blogs as $blog)
                            @php
                                $titleData = json_decode($blog->title, true) ?? [];
                                $articleTitle = $titleData[$locale] ?? ($titleData['en'] ?? (is_array($titleData) && !empty($titleData) ? reset($titleData) : 'Untitled Article'));

                                $contentSource = $blog->content ?? $blog->description ?? null;
                                $contentData = $contentSource ? json_decode($contentSource, true) : [];
                                if (!is_array($contentData)) {
                                    $contentData = [];
                                }
                                $articleBody = $contentData[$locale] ?? ($contentData['en'] ?? (is_array($contentData) && !empty($contentData) ? reset($contentData) : null));
                                $articleExcerpt = $articleBody ? \Illuminate\Support\Str::limit(strip_tags($articleBody), 110) : null;

                                $coverImage = $blog->image ? Storage::url($blog->image) : asset('assets/images/blog-image.png');

                                $authorName = optional($blog->user)->name;
                                $authorName = is_string($authorName) && trim($authorName) !== '' ? $authorName : 'Unknown author';
                                $authorInitials = collect(preg_split('/\s+/u', $authorName, -1, PREG_SPLIT_NO_EMPTY))
                                    ->map(fn ($part) => mb_substr($part, 0, 1))
                                    ->implode('');
                                $authorInitials = $authorInitials !== '' ? mb_substr($authorInitials, 0, 2) : 'BL';

                                $publishedAt = $blog->created_at;
                                $isFeatured = $hasFeaturedColumn ? !empty($blog->featured) : false;
                                $statusLabel = $hasFeaturedColumn
                                    ? ($isFeatured ? 'Featured' : 'Standard')
                                    : 'Published';
                            @endphp

                            <tr>
                                <td class="id-cell">#{{ str_pad($blog->id, 3, '0', STR_PAD_LEFT) }}</td>

                                <td class="article-cell">
                                    <div class="article-info">
                                        <div class="article-cover" aria-hidden="true">
                                            <img src="{{ $coverImage }}" alt="{{ $articleTitle }}">
                                        </div>
                                        <div class="article-details">
                                            <h4>{{ $articleTitle }}</h4>
                                            @if($articleExcerpt)
                                                <p class="article-excerpt">{{ $articleExcerpt }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </td>

                                <td class="author-cell">
                                    <div class="author-info">
                                        <div class="author-avatar" aria-hidden="true">
                                            <span>{{ $authorInitials }}</span>
                                        </div>
                                        <div class="author-details">
                                            <span class="author-name">{{ $authorName }}</span>
                                            @if($blog->user && method_exists($blog->user, 'getRoleNames'))
                                                @php
                                                    $roles = $blog->user->getRoleNames();
                                                    $primaryRole = $roles->first() ?? null;
                                                @endphp
                                                @if($primaryRole)
                                                    <span class="author-role">{{ $primaryRole }}</span>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </td>

                                <td class="status-cell">
                                    <span class="status-pill {{ $isFeatured ? 'featured' : 'standard' }}">{{ $statusLabel }}</span>
                                </td>

                                <td class="date-cell">
                                    <div class="date-meta">
                                        <span class="date-primary">{{ $publishedAt ? $publishedAt->format('M d, Y') : '—' }}</span>
                                        <span class="date-secondary">{{ $publishedAt ? $publishedAt->diffForHumans() : 'Awaiting publish' }}</span>
                                    </div>
                                </td>

                                <td class="actions-cell">
                                    <div class="action-buttons">
                                        <a href="{{ route('blog.show', $blog) }}" class="action-btn view-btn" title="View article">
                                            <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                                <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zm0 11a3.5 3.5 0 1 1 3.5-3.5A3.5 3.5 0 0 1 12 15.5z" />
                                            </svg>
                                        </a>

                                        @role('Admin')
                                            <a href="{{ route('blog.edit', $blog) }}" class="action-btn edit-btn" title="Edit article">
                                                <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                                    <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75zM20.71 7.04a1 1 0 0 0 0-1.41l-2.34-2.34a1 1 0 0 0-1.41 0l-1.83 1.83 3.75 3.75z" />
                                                </svg>
                                            </a>

                                            <form
                                                action="{{ route('blog.destroy', $blog) }}"
                                                method="post"
                                                class="inline-delete-form"
                                                onsubmit="return confirm('Are you sure you want to delete this article?');"
                                            >
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="action-btn delete-btn" title="Delete article">
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
                                        <h3>No articles yet</h3>
                                        <p>Start publishing stories to build your library of helpful resources.</p>
                                        @role('Admin')
                                            <a href="{{ route('blog.create') }}" class="empty-action-btn">Create article</a>
                                        @endrole
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="table-pagination">
                {{ $blogs->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
@endsection

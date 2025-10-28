@extends('layouts.master2')
@section('content')
    <!-- Blog Management Content with Consistent Layout -->
    <div class="blog-management-content">
        <!-- Page Header -->
        <div class="page-header">
            <div class="header-content">
                <div class="header-info">
                    <h1 class="page-title">Health & Wellness Blog</h1>
                    <p class="page-subtitle">Stay informed with the latest insights on mental health and wellness</p>
                </div>
                <div class="header-actions">
                    <div class="search-container">
                        <svg class="search-icon" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
                        </svg>
                        <form method="GET" action="{{ route('blog.index') }}" class="search-form">
                            <input type="search" 
                                   name="title" 
                                   value="{{ request('title') }}" 
                                   placeholder="Search articles..." 
                                   class="search-input">
                            <button type="submit" class="search-btn">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon articles-icon">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/>
                    </svg>
                </div>
                <div class="stat-content">
                    <h3>{{ $blogs->total() }}</h3>
                    <p>Total Articles</p>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon recent-icon">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                    </svg>
                </div>
                <div class="stat-content">
                    <h3>{{ $blogs->where('created_at', '>=', now()->subDays(7))->count() }}</h3>
                    <p>This Week</p>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon categories-icon">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                    </svg>
                </div>
                <div class="stat-content">
                    <h3>8</h3>
                    <p>Categories</p>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon featured-icon">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.45,13.97L5.82,21L12,17.27Z"/>
                    </svg>
                </div>
                <div class="stat-content">
                    <h3>{{ $blogs->where('featured', true)->count() ?? 3 }}</h3>
                    <p>Featured</p>
                </div>
            </div>
        </div>

        <!-- Featured Article -->
        @if($blogs->isNotEmpty())
            @php
                $featuredBlog = $blogs->first();
                $locale = App::getLocale();
                $featuredTitle = json_decode($featuredBlog->title, true)[$locale] ?? '';
                $featuredContent = json_decode($featuredBlog->content, true)[$locale] ?? '';
            @endphp
            <div class="featured-article">
                <div class="featured-header">
                    <h2>Featured Article</h2>
                    <p>Don't miss our top story this week</p>
                </div>
                
                <div class="featured-card">
                    <div class="featured-image">
                        <img src="{{ $featuredBlog->image ? Storage::url($featuredBlog->image) : asset('assets/images/blog-image.png') }}" 
                             alt="{{ $featuredTitle }}">
                        <div class="featured-badge">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.45,13.97L5.82,21L12,17.27Z"/>
                            </svg>
                            Featured
                        </div>
                    </div>
                    
                    <div class="featured-content">
                        <div class="featured-meta">
                            <span class="category-tag">Mental Health</span>
                            <span class="reading-time">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm3.5 6L12 10.5 8.5 8 12 5.5 15.5 8zM12 13.5l3.5 2.5L12 18.5 8.5 16l3.5-2.5z"/>
                                </svg>
                                5 min read
                            </span>
                        </div>
                        
                        <h3>{{ $featuredTitle }}</h3>
                        <p>{{ Str::limit(strip_tags($featuredContent), 150) }}</p>
                        
                        <div class="featured-footer">
                            <div class="article-date">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7z"/>
                                </svg>
                                {{ $featuredBlog->created_at->format('M d, Y') }}
                            </div>
                            
                            <a href="{{ route('blog.show', $featuredBlog) }}" class="read-more-btn">
                                Read Full Article
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 4l-1.41 1.41L16.17 11H4v2h12.17l-5.58 5.59L12 20l8-8z"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Main Content Grid -->
        <div class="content-grid">
            <!-- Articles Section -->
            <div class="articles-section">
                <div class="section-header">
                    <h2>Latest Articles</h2>
                    <p>Explore our collection of health and wellness insights</p>
                </div>
                
                <div class="articles-grid">
                    @foreach($blogs->skip(1) as $blog)
                        @php
                            $locale = App::getLocale();
                            $title = json_decode($blog->title, true)[$locale] ?? '';
                            $content = json_decode($blog->content, true)[$locale] ?? '';
                        @endphp
                        <article class="blog-card">
                            <div class="blog-image">
                                <img src="{{ $blog->image ? Storage::url($blog->image) : asset('assets/images/blog-image.png') }}" 
                                     alt="{{ $title }}">
                                <div class="blog-category">Mental Health</div>
                            </div>
                            
                            <div class="blog-content">
                                <div class="blog-meta">
                                    <span class="publish-date">
                                        <svg viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7z"/>
                                        </svg>
                                        {{ now()->diffInDays($blog->created_at) === 0
                                            ? __('site.today')
                                            : (now()->diffInDays($blog->created_at) === 1
                                                ? __('site.1_day_ago')
                                                : __('site.x_days_ago', ['count' => now()->diffInDays($blog->created_at)])) }}
                                    </span>
                                    <span class="reading-time">
                                        <svg viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm3.5 6L12 10.5 8.5 8 12 5.5 15.5 8zM12 13.5l3.5 2.5L12 18.5 8.5 16l3.5-2.5z"/>
                                        </svg>
                                        {{ rand(3, 8) }} min read
                                    </span>
                                </div>
                                
                                <h3 class="blog-title">{{ $title }}</h3>
                                <p class="blog-excerpt">{{ Str::limit(strip_tags($content), 120) }}</p>
                                
                                <div class="blog-footer">
                                    <div class="blog-tags">
                                        <span class="tag">Wellness</span>
                                        <span class="tag">Health</span>
                                    </div>
                                    
                                    <a href="{{ route('blog.show', $blog) }}" class="read-more">
                                        {{ __('site.learn more') }}
                                        <svg viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M12 4l-1.41 1.41L16.17 11H4v2h12.17l-5.58 5.59L12 20l8-8z"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
                
                <!-- Pagination -->
                <div class="pagination-container">
                    {{ $blogs->links('pagination::bootstrap-4') }}
                </div>
            </div>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Newsletter Signup -->
                <div class="sidebar-widget newsletter-widget">
                    <h3>Stay Updated</h3>
                    <p>Subscribe to our newsletter for the latest health insights</p>
                    <form class="newsletter-form">
                        <input type="email" placeholder="Enter your email" required>
                        <button type="submit">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/>
                            </svg>
                            Subscribe
                        </button>
                    </form>
                </div>

                <!-- Recent Posts -->
                <div class="sidebar-widget recent-posts-widget">
                    <h3>{{ __('site.related Post') }}</h3>
                    <div class="recent-posts">
                        @foreach($last_blogs as $last_blog)
                            @php
                                $locale = App::getLocale();
                                $title_last = json_decode($last_blog->title, true)[$locale] ?? '';
                            @endphp
                            <article class="recent-post">
                                <div class="recent-post-image">
                                    <img src="{{ $last_blog->image ? Storage::url($last_blog->image) : asset('assets/images/blog-image.png') }}" 
                                         alt="{{ $title_last }}">
                                </div>
                                <div class="recent-post-content">
                                    <h4><a href="{{ route('blog.show', $last_blog) }}">{{ Str::limit($title_last, 50) }}</a></h4>
                                    <span class="recent-post-date">{{ $last_blog->created_at->format('M d, Y') }}</span>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>

                <!-- Categories -->
                <div class="sidebar-widget categories-widget">
                    <h3>Categories</h3>
                    <ul class="categories-list">
                        <li><a href="#">Mental Health <span>({{ $blogs->count() }})</span></a></li>
                        <li><a href="#">Wellness Tips <span>(8)</span></a></li>
                        <li><a href="#">Therapy Insights <span>(12)</span></a></li>
                        <li><a href="#">Mindfulness <span>(6)</span></a></li>
                        <li><a href="#">Research <span>(4)</span></a></li>
                    </ul>
                </div>

                <!-- Popular Tags -->
                <div class="sidebar-widget tags-widget">
                    <h3>Popular Tags</h3>
                    <div class="tags-cloud">
                        <a href="#" class="tag-cloud-item">Anxiety</a>
                        <a href="#" class="tag-cloud-item">Depression</a>
                        <a href="#" class="tag-cloud-item">Mindfulness</a>
                        <a href="#" class="tag-cloud-item">Therapy</a>
                        <a href="#" class="tag-cloud-item">Wellness</a>
                        <a href="#" class="tag-cloud-item">Mental Health</a>
                        <a href="#" class="tag-cloud-item">Self Care</a>
                        <a href="#" class="tag-cloud-item">Meditation</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Newsletter form submission
        document.querySelector('.newsletter-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const email = this.querySelector('input[type="email"]').value;
            if (email) {
                alert('Thank you for subscribing! We\'ll keep you updated with the latest health insights.');
                this.querySelector('input[type="email"]').value = '';
            }
        });

        // Search functionality enhancement
        document.querySelector('.search-input').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            if (searchTerm.length > 2) {
                // Here you could implement real-time search suggestions
                console.log('Searching for:', searchTerm);
            }
        });
    </script>
@endsection

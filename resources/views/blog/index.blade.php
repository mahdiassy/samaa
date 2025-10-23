@extends('layouts.master2')
@section('content')
    <div class="main-content">
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

    <style>
        /* Enhanced Blog List Styles */
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
                            radial-gradient(circle at 80% 20%, rgba(245, 158, 11, 0.3) 0%, transparent 50%);
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

        .search-container {
            position: relative;
        }

        .search-form {
            display: flex;
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
            z-index: 1;
        }

        .search-input {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 12px 0 0 12px;
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

        .search-btn {
            background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
            border: none;
            border-radius: 0 12px 12px 0;
            padding: 0.75rem 1rem;
            color: white;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .search-btn:hover {
            background: linear-gradient(135deg, #7c3aed 0%, #6d28d9 100%);
        }

        .search-btn svg {
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

        .articles-icon {
            background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
        }

        .recent-icon {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        }

        .categories-icon {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        }

        .featured-icon {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
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

        .featured-article {
            margin-bottom: 3rem;
        }

        .featured-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .featured-header h2 {
            font-size: 2rem;
            font-weight: 700;
            color: #1e293b;
            margin: 0 0 0.5rem 0;
        }

        .featured-header p {
            color: #64748b;
            margin: 0;
        }

        .featured-card {
            background: white;
            border-radius: 24px;
            overflow: hidden;
            border: 1px solid #e2e8f0;
            display: grid;
            grid-template-columns: 1fr 1fr;
            transition: all 0.3s ease;
        }

        .featured-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
        }

        .featured-image {
            position: relative;
            height: 300px;
        }

        .featured-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .featured-badge {
            position: absolute;
            top: 1rem;
            left: 1rem;
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .featured-badge svg {
            width: 16px;
            height: 16px;
        }

        .featured-content {
            padding: 2rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .featured-meta {
            display: flex;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .category-tag {
            background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
            color: white;
            padding: 0.375rem 0.75rem;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .reading-time {
            display: flex;
            align-items: center;
            gap: 0.25rem;
            color: #64748b;
            font-size: 0.875rem;
        }

        .reading-time svg {
            width: 14px;
            height: 14px;
        }

        .featured-content h3 {
            font-size: 1.75rem;
            font-weight: 700;
            color: #1e293b;
            margin: 0 0 1rem 0;
            line-height: 1.4;
        }

        .featured-content p {
            color: #64748b;
            line-height: 1.6;
            margin: 0 0 2rem 0;
        }

        .featured-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .article-date {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #64748b;
            font-size: 0.875rem;
        }

        .article-date svg {
            width: 16px;
            height: 16px;
        }

        .read-more-btn {
            background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
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

        .read-more-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(139, 92, 246, 0.3);
        }

        .read-more-btn svg {
            width: 16px;
            height: 16px;
        }

        .content-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 3rem;
        }

        .articles-section {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            border: 1px solid #e2e8f0;
        }

        .section-header {
            margin-bottom: 2rem;
        }

        .section-header h2 {
            font-size: 1.75rem;
            font-weight: 700;
            color: #1e293b;
            margin: 0 0 0.5rem 0;
        }

        .section-header p {
            color: #64748b;
            margin: 0;
        }

        .articles-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
        }

        .blog-card {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .blog-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            border-color: #8b5cf6;
        }

        .blog-image {
            position: relative;
            height: 200px;
        }

        .blog-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .blog-category {
            position: absolute;
            top: 1rem;
            left: 1rem;
            background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
            color: white;
            padding: 0.375rem 0.75rem;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .blog-content {
            padding: 1.5rem;
        }

        .blog-meta {
            display: flex;
            gap: 1rem;
            margin-bottom: 1rem;
            font-size: 0.875rem;
            color: #64748b;
        }

        .publish-date, .reading-time {
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .publish-date svg, .reading-time svg {
            width: 14px;
            height: 14px;
        }

        .blog-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #1e293b;
            margin: 0 0 1rem 0;
            line-height: 1.4;
        }

        .blog-excerpt {
            color: #64748b;
            line-height: 1.6;
            margin: 0 0 1.5rem 0;
        }

        .blog-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .blog-tags {
            display: flex;
            gap: 0.5rem;
        }

        .tag {
            background: #f1f5f9;
            color: #64748b;
            padding: 0.25rem 0.5rem;
            border-radius: 8px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .read-more {
            color: #8b5cf6;
            text-decoration: none;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.25rem;
            font-size: 0.875rem;
            transition: all 0.3s ease;
        }

        .read-more:hover {
            color: #7c3aed;
        }

        .read-more svg {
            width: 14px;
            height: 14px;
        }

        .sidebar {
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }

        .sidebar-widget {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            border: 1px solid #e2e8f0;
        }

        .sidebar-widget h3 {
            font-size: 1.25rem;
            font-weight: 600;
            color: #1e293b;
            margin: 0 0 1rem 0;
        }

        .newsletter-widget {
            background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
            color: white;
        }

        .newsletter-widget h3 {
            color: white;
        }

        .newsletter-widget p {
            color: rgba(255, 255, 255, 0.8);
            margin: 0 0 1rem 0;
        }

        .newsletter-form {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .newsletter-form input {
            padding: 0.75rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.1);
            color: white;
        }

        .newsletter-form input::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }

        .newsletter-form button {
            background: white;
            color: #8b5cf6;
            border: none;
            padding: 0.75rem;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
        }

        .newsletter-form button:hover {
            background: #f8fafc;
        }

        .newsletter-form button svg {
            width: 16px;
            height: 16px;
        }

        .recent-posts {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .recent-post {
            display: flex;
            gap: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #e2e8f0;
        }

        .recent-post:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .recent-post-image {
            width: 80px;
            height: 60px;
            border-radius: 8px;
            overflow: hidden;
            flex-shrink: 0;
        }

        .recent-post-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .recent-post-content h4 {
            font-size: 0.875rem;
            font-weight: 600;
            margin: 0 0 0.25rem 0;
        }

        .recent-post-content h4 a {
            color: #1e293b;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .recent-post-content h4 a:hover {
            color: #8b5cf6;
        }

        .recent-post-date {
            font-size: 0.75rem;
            color: #64748b;
        }

        .categories-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .categories-list li {
            margin-bottom: 0.5rem;
        }

        .categories-list a {
            color: #64748b;
            text-decoration: none;
            display: flex;
            justify-content: space-between;
            padding: 0.5rem 0;
            border-bottom: 1px solid #f1f5f9;
            transition: color 0.3s ease;
        }

        .categories-list a:hover {
            color: #8b5cf6;
        }

        .categories-list span {
            color: #94a3b8;
            font-size: 0.875rem;
        }

        .tags-cloud {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .tag-cloud-item {
            background: #f1f5f9;
            color: #64748b;
            padding: 0.375rem 0.75rem;
            border-radius: 12px;
            text-decoration: none;
            font-size: 0.875rem;
            transition: all 0.3s ease;
        }

        .tag-cloud-item:hover {
            background: #8b5cf6;
            color: white;
        }

        .pagination-container {
            display: flex;
            justify-content: center;
            margin-top: 2rem;
        }

        @media(max-width: 1024px) {
            .content-grid {
                grid-template-columns: 1fr;
            }

            .featured-card {
                grid-template-columns: 1fr;
            }

            .featured-image {
                height: 250px;
            }
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

            .search-input {
                width: 250px;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .articles-grid {
                grid-template-columns: 1fr;
            }

            .featured-content {
                padding: 1.5rem;
            }

            .articles-section {
                padding: 1.5rem;
            }
        }
    </style>

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

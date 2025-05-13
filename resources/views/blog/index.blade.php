@extends('layouts.base')
@section('content')

    <div class="our-story">
        <div class="story-text">
            <h2>{{ __('site.Where') }} </h2>
            <h2><span>{{ __('site.Science') }}</span></h2>
            <h2>{{ __('site.Meets') }} <span>{{ __('site.Soul') }} </span> </h2>
            <p>{{ __('site.story-description') }}</p>
        </div>
    </div>

    <section class="jobguru-blog-page-area section_70">
        <div class="container-blog">
            <div class="row-blog">
                <div class="col-lg-8 col-sm-10 mx-auto">
                    <div class="blog-grid">
                        @foreach ($blogs as $blog)
                            @php
                                $locale = App::getLocale();
                                $title = json_decode($blog->title, true)[$locale] ?? '';
                            @endphp
                            <div class="blog-card-new">
                                <img src="{{ $blog->image ? Storage::url($blog->image) : asset('assets/images/blog-image.png') }}">
                                <div class="blog-info-new">
                                    <h3>{{ $title }}</h3>
                                </div>
                                <div class="button-calendar">
                                    <div class="calendar-date">
                                        <img class="uim_calender" src="{{ asset('assets/images/icons/uim_calender.svg') }}">
                                        <p class="date-text">
                                            {{ now()->diffInDays($blog->created_at) === 0
                                                ? __('site.today')
                                                : (now()->diffInDays($blog->created_at) === 1
                                                    ? __('site.1_day_ago')
                                                    : __('site.x_days_ago', ['count' => now()->diffInDays($blog->created_at)])) }}
                                        </p>
                                    </div>
                                    <a class="a-card" href="{{ route('blog.show', $blog) }}" >{{ __('site.learn more') }}</a>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="pagination-box-row">
                        {{ $blogs->links('pagination::bootstrap-4') }}
                    </div>
                </div>

                <div class="col-lg-4 col-sm-10 mx-auto">
                    <div class="blog-page-right">
                        <div class="blog-sidebar-widget">
                            <form method="GET" action="{{ route('blog.index') }}">
                                <input type="search" name="title" value="{{ request('title') }}" placeholder="{{ __('site.Search') }}">
                                <button type="submit"><i class="fa fa-search"></i></button>
                            </form>
                        </div>
                        <div class="blog-sidebar-widget">
                            <h3>{{ __('site.related Post') }}</h3>
                            <ul class="featured-list">
                                @foreach ($last_blogs as $last_blog)
                                @php
                                    $locale = App::getLocale();
                                    $title_last = json_decode($last_blog->title, true)[$locale] ?? '';
                                @endphp
                                <li class="sidebr-pro-widget">
                                    <div class="blog-thumb-info">
                                        <div class="blog-thumb-info-image">
                                            <a href="{{ route('blog.show',$last_blog) }}">
                                                <img src="{{ $last_blog->image ? Storage::url($last_blog->image) : asset('assets/images/blog-image.png') }}" alt="proudct" />
                                            </a>
                                        </div>
                                        <div class="blog-thumb-info-content">
                                            <h4><a href="{{ route('blog.show',$last_blog) }}">{{$title_last}}</a></h4>
                                            <p>{{ __('site.Posted on') }}: <span>{{ $last_blog->created_at->translatedFormat('d M Y') }}</span></p>
                                        </div>
                                    </div>
                                </li>
                                @endforeach

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

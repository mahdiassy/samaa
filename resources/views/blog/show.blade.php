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
                    <div class="blog-detail-wrapper">
                        @php
                            $locale = App::getLocale();
                            $title = json_decode($blog->title, true)[$locale] ?? '';
                            $description = json_decode($blog->description, true)[$locale] ?? '';
                        @endphp

                        <div class="blog-card-detail">
                            <img src="{{ $blog->image ? Storage::url($blog->image) : asset('assets/images/blog-image.png') }}" alt="{{ $title }}">
                            <div class="blog-card-detail-info">
                                <h3 class="h3-colored">{{ $title }}</h3>
                                <p class="blog-description">{!! nl2br(e($description)) !!}</p>

                                <div class="button-calendar">
                                    <div class="calendar-date">
                                        <img class="uim_calender" src="{{ asset('assets/images/icons/uim_calender.svg') }}" alt="calendar icon">
                                        <p class="date-text-colored">
                                            {{ $blog->created_at->translatedFormat('d M Y') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
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
                                                <img src="{{ $last_blog->image ? Storage::url($last_blog->image) : asset('assets/img/blog.jpg') }}" alt="proudct" />
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

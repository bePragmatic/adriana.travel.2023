@extends('rogoznica.layout.master')
@section('content')
<div class="blog-body__bg">

    <!-- Background in accommodation.css -->
    <div class="blog__hero">

        <!-- By adding ".header__branding--sm-dark" class logo - positive is displayed on small resolutions -->
        @include('rogoznica.includes.header')


        <div class="blog-header__wrapper">
            <div class="blog-list-header homepage__row__container blog-header__element blog-title-container__minwidth">
                <div class="blog__bg__white">
                    <div class="homepage__body__row padding__bottom__5px media-to-hide">
                        {{ $posts->first()->created_at->format('d. M. Y') }}
                    </div>
                    <div class="homepage__body__row text__padding__5">
                        <h2 class="blue__light media-to-title-change">
                            <a
                                href="{{ route('blog.single',  $posts->first()->translate(app()->getLocale())['slug']) }}">

                                {{ $posts->first()->translate(app()->getLocale())['title'] }}
                            </a>
                        </h2>
                    </div>
                    <div class="media-to-show__blog">
                        <img class="image__corner__all" src="{{  $posts->first()->src }}"
                            alt="{{ $posts->first()->translate(app()->getLocale())['title'] }}" />

                        <p class="media-blog-subtext"> {{ $posts->first()->created_at->format('d. M. Y') }} </p>
                    </div>
                    <div class="homepage__body__row blog-text-padding__10">
                        <p class="media-to-blog-p-change">
                            {!!   \Str::words(strip_tags($posts->first()->translate(app()->getLocale())['content']), 20) !!}

                        </p>
                    </div>
                    <div class="homepage__body__row text__padding">
                        <a href="{{ route('blog.single',  $posts->first()->translate(app()->getLocale())['slug']) }}"
                            class="blue__light section__readmore" style="padding-left: 5px;">
                            @lang('messages.home.read_more')
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="white-bg__blog white-bg__blog-props blog-body__wrapper">

        <!-- 1st blog row -->
        <div class="blog-list">

            @foreach($posts as $key => $post)
            @if($post->translate(app()->getLocale())['slug'] && $key != 0)
            <div class="blog-element__container">
                <a href="{{ route('blog.single',  $post->translate(app()->getLocale())['slug']) }}">
                    <img class="image__corner__all" src="{{  $post->src }}"
                        alt="{{ $post->translate(app()->getLocale())['title'] }}" />
                </a>

                <div class="text-container__blog">
                    <p class="t-eta padding__top__xs">{{ $post->created_at->format('d. M. Y') }}</p>
                    <h5 class="testnaBlog">
                        <a href="{{ route('blog.single',  $post->translate(app()->getLocale())['slug']) }}">
                            {{ $post->translate(app()->getLocale())['title'] }}
                        </a>
                    </h5>

                    <p class="t-eta padding__top__custom">
                       {!!   \Str::words(strip_tags($post->translate(app()->getLocale())['content']), 20) !!}

                        <br>
                        <a href="{{ route('blog.single',  $post->translate(app()->getLocale())['slug']) }}"
                            class="section__readmore">@lang('messages.home.read_more')</a>
                    </p>
                </div>
            </div>
            @endif

            @endforeach

        </div>


        <!-- pagination -->
        {{--  <div class="pagination accommodation__pagination " style="padding-bottom: 120px;
    padding-top: 20px;
    margin-bottom: -100px;
">
                <div style="display: flex; justify-content: center;">
                    <div>
                        <button type="button" class="pagination__btn pagination__btn--left"/>
                    </div>
                    <div style="display: flex; margin-left: 5rem; margin-right: 5rem;">
                        <a class="pagination__page" href="1" style="padding: 0 1em 0 0">
                            1
                        </a>
                        <a class="pagination__page" href="2" style="padding: 0 1em 0 0">
                            2
                        </a>
                        <a class="pagination__page pagination__page--active" href="3" style="padding: 0 0.2em 0 0">
                            3
                        </a>
                        <span class="pagination__dots">...</span>
                        <a class="pagination__page" href="112" style="padding-left: 0.2em; padding-right: 0">
                            112
                        </a>
                    </div>
                    <div>
                        <button type="button" class="pagination__btn pagination__btn--right"/>
                    </div>
                </div>

                <p class="pagination__results">
                    showing 17-21 of 112 results
                </p>

            </div>
--}}

        <!-- do ovdje -->
    </div>
</div>

@stop

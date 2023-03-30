@extends('rogoznica.layout.master')
@section('content')
<div>

    <div class="wrapper"></div>
    <div>
        <!-- Background in accommodation.css -->
        <div class="single-blog__hero" style="background: url('../images/single-blog-head-100.jpg');">
            @include('rogoznica.includes.header')
            <div class="wrapper single-blog__header">
                <h2 class="single-media-to-show__blog single-media-to-title-change">
                    @lang('messages.rogoznica.beaches')
                </h2>
                <div class="homepage__row__container media-from-hide" style="margin-top: 10px;">
                    <img style="max-width: 660px; object-fit: cover;

                        width: 100%;
                        height: 86.7%;
                        vertical-align: middle; border-radius: 8px;" src="{{ $post->src }}">
                </div>
            </div>
        </div>


        <div class="single-blog__white-bg">
            <div class="wrapper__blogpost__uska">
                <section class="padding__top__3">
                    <div class="accommodation__filters__padding__top single-blog__padding-btm">
                        <div class="info-and-share-container">
                            <div>
                                <p class="t-eta">
                                    <span class="t-bold">Adriana Travel</span> -
                                    {{ $parent->created_at->format('d.m.Y') }}
                                </p>
                            </div>
                            <div class="share__container">
                                <img src="/assets/shareicon.svg" />
                                <p>Share:</p>
                                <img src="/assets/facebookicon.svg" />
                                <img src="/assets/twittericon.svg" />
                            </div>
                        </div>
                        <h2 class="padding__top__xs padding__bottom__3 single-media-to-hide-xsml">
                            {{  $post->title}}
                        </h2>
                        {!! $post->content !!}

                        <div class="mobile-share__container">
                            <div style="display: flex;"> <img src="/assets/shareicon.svg" />
                                <p class="single-blog-share">@lang('messages.rooms.share'):</p>
                            </div>
                            <div style="display: flex;">
                                <img src="/assets/facebookicon.svg" />
                                <img style="padding-left: 10px" src="/assets/twittericon.svg" />
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>

@stop

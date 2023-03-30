<!-- ispod 700 tj. min-width:--screen-to-sml napraviti mobile -->

@extends('rogoznica.layout.master')
@section('content')
<div>
    <div class="homepage__hero">
        @include('rogoznica.includes.header')

        <div class="wrapper homepage__header">
            <div class="home-top">
                <h1 class="homepage__header__title">
                    {{-- Blue & Natural Dalmatia --}}
                    @lang('messages.home.minimise_the_hassle')
                    <span class="homepage-header-subtext t-eta title-subtitle__spacing">

                        <p class="t-eta"> @lang('messages.home.a_click_away')

                        </p>
                    </span>
                </h1>
            </div>

            <div class="accommodation__header__search">
                <header-search></header-search>
            </div>
        </div>

    </div>


    <div class="white-bg--nor">
        <div class="padding__top__bottom2b wrapper">
            <div class="homepage-lost">
                <div class="homepage-lost--2 homepage__row__container home-title-additional-column">
                    <div class="homepage-wave__container wave-icon__padding-top">
                        <img class="border-radius--12 wave__min-width" src="./assets/logoWaveSVG.svg" />

                    </div>

                    <div class="padding-left--2 media-padding-to-zero">
                        <h2>
                            @lang('messages.home.stress_free_dalmatia')
                        </h2>
                    </div>
                </div>


                <div class="homepage-lost--2 ">
                    <div class="text__box">
                        <p>
                            @lang('messages.home.whether_you_prefer' )
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- WHERE TO STAY -->


        <div class="wrapper padding__top__bottom">

            <h3 class="homepage__lightblue__title">
                @lang('messages.home.where_to_stay')
            </h3>

            {{-- <div class="homepage-lost--2">
                        <a href="{{ route('search_page') }}">
            <div class="img-container-overlay img-overlay border-radius--12">
                <img class="border-radius--12 stay-img-props-w"
                    src=" ./assets/images/digital-marketing-agency-ntwrk-g39p1kDjvSY-unsplash 1.jpg" />
                <div class="img-overlay"></div>
            </div>
            </a>
            <p class="t-zeta image__footer__blue">
                <a href="{{ route('search_page') }}">Villas</a>
            </p>
        </div> --}}
        <div class="homepage-lost media-to-hide--sml">
            {{-- <div class="hider-class">
                <wts-desktop>
                    <div class="wts-element wts-overlay">
                        <img class="border-radius--12 stay-img-props wts-zoom" src="/assets/images/vila.jpg" />
                        <p class="t-zeta image__footer__blue"> <a href="{{ route('search_page') }}">Villas</a></p>
        </div>
        <div class="wts-element wts-overlay">
            <div>
                <img class="border-radius--12 stay-img-props wts-zoom" src="/assets/images/apartman.jpg" />
                <p class="t-zeta image__footer__blue">
                    <a href="{{ route('search_page', ['property_type' => 1]) }}">Apartments
                    </a>
                </p>
            </div>
        </div>
        <div class="wts-element wts-overlay">
            <div>
                <img class="border-radius--12 stay-img-props wts-zoom" src="/assets/images/kuca.jpg" />
                <p class="t-zeta image__footer__blue"> <a
                        href="{{ route('search_page', ['property_type' => 1]) }}">Homes
                    </a></p>
            </div>
        </div>
        </wts-desktop>
    </div> --}}


    <div class="homepage-lost--1-3 wts-overlay">
        <a href="{{ route('search_page') }}">
            <img class="border-radius--12 stay-img-props wts-zoom" src=" ./assets/images/vila.jpg" />
        </a>
        <p class="t-zeta image__footer__blue">
            <a href="{{ route('search_page', ['property_type' => 9]) }}">@lang('messages.home.villas')</a>
        </p>
    </div>
    <div class="homepage-lost--1-3 wts-overlay">
        <a href="{{ route('search_page') }}">
            <img class="border-radius--12 stay-img-props wts-zoom" src="./assets/images/apartman.jpg" />
        </a>
        <p class="t-zeta image__footer__blue">
            <a href="{{ route('search_page', ['property_type' => 1]) }}">@lang('messages.home.apartments')
            </a>
        </p>
    </div>
    <div class="homepage-lost--1-3 wts-overlay">
        <a href="{{ route('search_page') }}">
            <img class="border-radius--12 stay-img-props wts-zoom" src="./assets/images/kuca.jpg" />
        </a>
        <p class="t-zeta image__footer__blue">
            <a href="{{ route('search_page', ['property_type' => 1]) }}">@lang('messages.home.homes')
            </a>
        </p>
    </div>

</div>

<div class="media-to-show--carousel">
    <wts-carousel>
        <div class="wts-element">
            <img class="border-radius--12 stay-img-props" src="/assets/images/vila.jpg" />

            <p class="t-zeta image__footer__blue"> <a
                    href="{{ route('search_page') }}">@lang('messages.home.villas')</a></p>
        </div>
        <div class="wts-element">
            <div>
                <img class="border-radius--12 stay-img-props" src="/assets/images/apartman.jpg" />
                <p class="t-zeta image__footer__blue">
                    <a href="{{ route('search_page', ['property_type' => 1]) }}">@lang('messages.home.apartments')
                    </a>
                </p>
            </div>
        </div>
        <div class="wts-element">
            <div>
                <img class="border-radius--12 stay-img-props" src="/assets/images/kuca.jpg" />
                <p class="t-zeta image__footer__blue"> <a
                        href="{{ route('search_page', ['property_type' => 1]) }}">@lang('messages.home.homes')
                    </a></p>
            </div>
        </div>
    </wts-carousel>
</div>
</div>


<!-- PLACES -->

<div class="padding__top__bottom places-padding-to-zero homeplaces-wrapper">
    <div class="wrapper">
        <h3 class="homepage__lightblue__title">@lang('messages.home.our_favourites')</h3>
    </div>
    <div class="homeplaces-padding__home padding-bottom--2">
        <div class="homepage-lost">

            <div class="homeplaces-carousel-wrapper homepage-lost--3-4 ">




                <div>
                    <pts-carousel>

                        @foreach($rooms as $room)


                        <div class="pts-element zoom-overlay" style="min-width: 273px;">

                            <div class="border-radius--12"
                                style="overflow: hidden; -webkit-mask-image: -webkit-radial-gradient(white, black);">
                                <a href="{{ route('accommodation.single', $room) }}" target="_blank">
                                    <img class="border-radius--12 places-img__size img-carousel-zoom"
                                        src="{{ $room->photo_name }}" />
                                </a>
                            </div>
                            <div class="homepage__row__container space__between padding-top--1">
                                <p>From @if($room->popup_price) {{ number_format($room->popup_price, 2) }} @else {{ number_format(0, 2) }} @endif
                                    € {{--/ Per Night--}}</p>

                                @if ($room->reviews_count != 0)
                                <p class="review-grade">
                                    {{ number_format($room->overall_star_rating['rating_value'], 1) }}
                                    ({{ $room['reviews_count']}})</p>

                                @else
                                <p class="review-grade">0(0)</p>
                                @endif

                            </div>
                            <p class="homepage-element__subtitle cursor--pointer">{{ $room->name }}
                                {{--{{ $room->sub_name }}--}}</p>

                        </div>

                        @endforeach
                    </pts-carousel>
                </div>
            </div>
            <div class=" homeplaces-discovery-wrapper homepage-lost--1-4">

                <div
                    class="homepage-places-bg__btn  border-radius--12 padding-all--1 places__flex-props places-element__container">
                    <p class="homepage-places__text">@lang('messages.home.a_lot_more')
                    </p>
                    <a href="{{ route('search_page') }}" class="btn btn--secondary btn--noborder btn--max-width">
                        <p class="button__text">@lang('messages.home.discover')</p>
                    </a>
                </div>


            </div>

        </div>

    </div>
</div>

<!-- SERVICES -->


<div class="bg-services">
    <div class=" home-services-wrapper padding-top-bottom--4-5b">


        <div class="homepage-lost fold-over">
            <div class="homepage-lost--1-3">
                <div class="">
                    <h3 class="homepage__lightblue__title">@lang('messages.home.services')</h3>
                </div>
                <p class="services-text o-60">
                    @lang('messages.home.tailor_made_experience')
                </p>
            </div>
            <div class="homepage-lost--2-3 homepage-lost content-align--center align-items--center margin-top--1">


                <div class="homepage-lost--4 content-align--center ">


                    <a href="{{ route('transfers') }}">
                        <img src="./assets/minivan.svg" class="service-element__icon" />
                        <p class="icon-services-text o-60">
                            @lang('messages.services-activities.airport_transfers')</p>
                    </a>
                </div>
                <div class="homepage-lost--4 content-align--center  ">
                    <a href="https://www.rentacarlastminute.hr/{{trans('messages.home.lang')}}/index.aspx?affiliate=026"
                        target="_blank">
                        <img src="./assets/car.svg" class="service-element__icon" />
                        <p class="icon-services-text  o-60">
                            @lang('messages.services-activities.rent_a_car')</p>
                    </a>
                </div>
                <div class="homepage-lost--4 content-align--center  ">
                    <a href="{{ route('rent-a-boat-one') }}"> <img src="./assets/boat.svg" class="service-element__icon" />
                        <p class="icon-services-text o-60">
                            @lang('messages.services-activities.rent_a_boat')</p>
                    </a>
                </div>
                <div class="homepage-lost--4 content-align--center ">
                    <a href="http://quadadventuremz.com/go/502/" target="_blank"> <img src="./assets/quad.svg"
                            class="service-element__icon" />
                        <p class="icon-services-text o-60">
                            @lang('messages.services-activities.adventure_quad')</p>
                    </a>
                </div>

            </div>

        </div>
    </div>
</div>


<!-- BLOG -->
<div class="wrapper padding-top-bottom--4-3c ">
    <div>
        <h3 class="homepage__lightblue__title">@lang('messages.home.blog')</h3>
    </div>
    <div class="homepage-lost media-to-hide--sml">

        @foreach($posts as $post)
        @if($post->translate(app()->getLocale())['slug'])
        <div class="homepage-lost--1-3 padding-top--1 ">
            <a href="{{ route('blog.single',  $post->translate(app()->getLocale())['slug']) }}">
                <img class="image__corner__all blog-zoom cursor--pointer" src="{{ $post->src }}" />
            </a>


            <div class="text-container__blog">
                <p class="homepage-element__subtitle font-weight--600 padding-top--1">
                    <a href="{{ route('blog.single',  $post->translate(app()->getLocale())['slug']) }}">
                        {{ $post->translate(app()->getLocale())['title'] }}
                    </a>
                </p>

                <p class="t-eta">
                    {!!   \Str::words(strip_tags($posts->first()->translate(app()->getLocale())['content']), 20) !!}
                    <a href="{{ route('blog.single',  $post->translate(app()->getLocale())['slug']) }}"
                        class="homepage-read-more__link cursor--pointer">
                        @lang('messages.home.read_more')
                    </a>
                </p>
            </div>
        </div>
        @endif
        @endforeach

    </div>


    <div class="media-to-show--carousel">

        <blog-carousel>
            @foreach($posts as $post)
            @if($post->translate(app()->getLocale())['slug'])

            <div>
                <a href="{{ route('blog.single',  $post->translate(app()->getLocale())['slug']) }}">
                    <img class="image__corner__all" src="{{ $post->src }}"
                        alt="{{ $post->translate(app()->getLocale())['title'] }}" />
                </a>

                <div class="text-container__blog">
                    <p class="homepage-element__subtitle font-weight--600 padding-top--1">
                        <a href="{{ route('blog.single',  $post->translate(app()->getLocale())['slug']) }}">
                            {{ $post->translate(app()->getLocale())['title'] }}
                        </a>
                    </p>

                    <p class="t-eta">
                        {!! \Str::words(strip_tags($post->content), 20) !!}
                        <a href="{{ route('blog.single',  $post->translate(app()->getLocale())['slug']) }}"
                            class="homepage-read-more__link">
                            @lang('messages.home.read_more')
                        </a>
                    </p>
                </div>
            </div>
            @endif
            @endforeach


        </blog-carousel>


    </div>
</div>
<!-- BG ROGO -->
<div class="homepage__row__container padding__top__2 screen-to-sml--hide">
    <div class="bg-rogo homepage__row__container reverse text__padding__5">
        <div class="wrapper homepage__row__container">
            <div class="dsx-empty"></div>
            <div class="dsx">
                <div class="homepage__body__row">
                    <img src="./assets/buddhism.svg" class="icon__size" />
                </div>
                <div class="homepage__body__row text__padding__5">
                    <h2>@lang('messages.home.beating_heart')</h2>
                </div>
                <div class="homepage__body__row text__padding__10">
                    <p>
                        @lang('messages.home.epicenter')
                    </p>
                </div>
                <div class="homepage__body__row text__padding">


                    {{-- <a href="{{ route('rogoznica') }}" class="btn btn--secondary">
                    <p class="button__text">Meet Rogoznica</p>
                    </a>--}}

                    <a href="{{ route('rogoznica') }}">
                        <button class="btn btn--secondary">

                            <p class="button__text">@lang('messages.home.discover_rogoznica')</p>

                        </button>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- SUBSCRIPTION -->
<div class="homepage-subscription-props media-padding-top">
    <newsletter color="home"></newsletter>
</div>
</div>

</div>
@stop




@extends('rogoznica.layout.master')
@section('content')
<div>
    <!-- Background in serviceandactivities.css -->
    <div class="serviceandactivities__hero">
        @include('rogoznica.includes.header')

        <div class="wrapper accommodation__header padding__top__3 media-to-header">
            <div>
                <h1 class="accommodation__header__title padding__bottom__xs service__title">
                    @lang('messages.services-activities.anywhere_you_please')
                </h1>
            </div>
            <div class="container__row__center-s">
                <p class="t-eta subtitle__alignment subtitle-services__padding-bottom">
                    @lang('messages.services-activities.stress-free')
                </p>
            </div>
        </div>
    </div>


    <div class="wrapper wrapper--sml-rounded wrapper-service">
        <div class="accommodation__list padding__bottom__0 padding__top__0">
            <section class="services__wrapper">
                <div class="accommodation__list">
                    <div class="homepage__row__container media__to__column">
                        <!-- airport -->
                        <div div class="services-box--item">
                            <div class="services--padding-top-3">
                                <img class="service-textbox__icon" src="./assets/minivan.svg" />
                            </div>
                            <div
                                class="service__padding-top-20 services--padding-bottom-3 homepage__body__row margin__left__20 flex-to-none">
                                <p class="t-zeta t-bold padding__top__xs padding__bottom__xs services__blue">
                                    @lang('messages.services-activities.airport_transfers_tours')
                                </p>

                                <div class="homepage__row__container transportation__maxwidth">
                                    <p class="t-eta">
                                        @lang('messages.services-activities.airport_transfers_desc')
                                    </p>

                                </div>
                                <a href="{{ route('transfers') }}"
                                    class="homepage-read-more__link cursor--pointer padding-top--5px">
                                    @lang('messages.home.read_more')
                                </a>
                            </div>

                        </div>
                        <!-- rent-a-car -->
                        <div class="services-box--item">

                            <div class="services--padding-top-3">
                                <a href="https://www.rentacarlastminute.hr/{{trans('messages.home.lang')}}/index.aspx?affiliate=026"
                                    target="_blank">
                                    <img class="service-textbox__icon" src="./assets/car.svg" />
                                </a>
                            </div>
                            <div
                                class="service__padding-top-20 services--padding-bottom-3 homepage__body__row margin__left__20 flex-to-none">
                                <p class="t-zeta t-bold padding__top__xs padding__bottom__xs services__blue">
                                    @lang('messages.services-activities.rent_a_car')
                                </p>

                                <div class="homepage__row__container transportation__maxwidth">
                                    <p class="t-eta">
                                        @lang('messages.services-activities.rent_a_car_desc')
                                    </p>
                                </div>
                                <a href="https://www.rentacarlastminute.hr/{{trans('messages.home.lang')}}/index.aspx?affiliate=026"
                                    class="homepage-read-more__link cursor--pointer padding-top--5px" target="_blank">
                                    @lang('messages.home.read_more')
                                </a>
                            </div>

                        </div>
                    </div>
                    <div class="homepage__row__container media__to__column">
                        <!-- rent-a-boat-->
                        <div class="services-box--item">
                            <div class="services--padding-top-3">
                                <img class="service-textbox__icon" src="./assets/boat.svg" />
                            </div>
                            <div
                                class="service__padding-top-20 services--pading-bottom-custom homepage__body__row margin__left__20 flex-to-none">
                                <p class="t-zeta t-bold padding__top__xs padding__bottom__xs services__blue">
                                    @lang('messages.services-activities.rent_a_boat_1')
                                </p>

                                <div class="homepage__row__container transportation__maxwidth">
                                    <p class="t-eta">
                                        @lang('messages.services-activities.rent_a_boat_desc')
                                    </p>
                                </div>
                                <a href="{{ route('rent-a-boat-one') }}"
                                    class="homepage-read-more__link cursor--pointer padding-top--5px">
                                    @lang('messages.home.read_more')
                                </a>
                            </div>
                        </div>
                        <div class="services-box--item">
                            <div class="services--padding-top-3">
                                <img class="service-textbox__icon" src="./assets/boat.svg" />
                            </div>
                            <div
                                class="service__padding-top-20 services--pading-bottom-custom homepage__body__row margin__left__20 flex-to-none">
                                <p class="t-zeta t-bold padding__top__xs padding__bottom__xs services__blue">
                                    @lang('messages.services-activities.rent_a_boat_2')
                                </p>

                                <div class="homepage__row__container transportation__maxwidth">
                                    <p class="t-eta">
                                        @lang('messages.services-activities.rent_a_boat_desc')
                                    </p>
                                </div>
                                <a href="{{ route('rent-a-boat-two') }}"
                                    class="homepage-read-more__link cursor--pointer padding-top--5px">
                                    @lang('messages.home.read_more')
                                </a>
                            </div>
                        </div>

                        <!-- adventure quad -->
                        <!--<div class="services-box--item">
                            <div class="services--padding-top-3">
                                <img class="service-textbox__icon" src="./assets/quad.svg" />
                            </div>
                            <div
                                class="service__padding-top-20 services--pading-bottom-custom homepage__body__row margin__left__20 flex-to-none">
                                <p class="t-zeta t-bold padding__top__xs padding__bottom__xs services__blue">
                                    @lang('messages.services-activities.adventure_quad')
                                </p>

                                <div class="homepage__row__container transportation__maxwidth">
                                    <p class="t-eta">
                                        @lang('messages.services-activities.adventure_quad_desc')
                                    </p>
                                </div>
                                <a href="http://quadadventuremz.com/go/502/" target="_blank"
                                    class="homepage-read-more__link cursor--pointer padding-top--5px">
                                    @lang('messages.home.read_more')
                                </a>
                            </div>
                        </div>-->
                    </div>
                </div>
            </section>
        </div>

        <div class="wrapper homepage__body__row services--padding-top-4 services--padding-left-0 ">
            <div class="homepage__row__container services--padding-bottom-title padding__top__1">
                <h2>@lang('messages.services-activities.to_miss')</h2>
            </div>


            <!-- OVDJE KREĆE -->
            <!-- first row -->


            <!-- lista od jedan do 4 -->
            <div class="service-list">

                <!-- 1 vibrant cities -->
                <div class="service-element__container">

                    <div class="service-element__title-container">
                        <h5 class="padding__bottom__xs">@lang('messages.services-activities.vibrant_cities')</h5>
                    </div>

                    <div class="service-element__image-container">
                        <div class="service-element__image-1 service-element--icon-position">
                            <div class="service-element__icon-container">
                                <img src="./assets/cyrcle-cities01.svg" class="service-element__icon" />
                            </div>
                        </div>


                    </div>


                    <div class="service-element__text-container ">
                        <p class="t-eta padding__top__custom">
                            @lang('messages.services-activities.vibrant_cities_desc')
                        </p>
                    </div>

                </div>

                <!-- 2 Off-beat destinations -->
                <div class="service-element__container">

                    <div class="service-element__title-container">
                        <h5 class="padding__bottom__xs">@lang('messages.services-activities.off-beat')</h5>
                    </div>

                    <div class="service-element__image-container">
                        <div class="service-element__image-2 service-element--icon-position">
                            <div class="service-element__icon-container">
                                <img src="./assets/cyrcle-mountain02.svg" class="service-element__icon" />
                            </div>
                        </div>
                    </div>


                    <div class="service-element__text-container">
                        <p class="t-eta padding__top__custom">
                            @lang('messages.services-activities.off-beat-desc')

                        </p>
                    </div>

                </div>


                <!-- second row -->


                <!-- 3 breathtaking outdoors -->
                <div class="service-element__container">

                    <div class="service-element__title-container">
                        <h5 class="padding__bottom__xs">
                            @lang('messages.services-activities.breathtaking')</h5>
                    </div>

                    <div class="service-element__image-container">
                        <div class="service-element__image-3 service-element--icon-position">
                            <div class="service-element__icon-container">
                                <img src="./assets/cyrcle-trees03.svg" class="service-element__icon" />
                            </div>
                        </div>
                    </div>


                    <div class="service-element__text-container">
                        <p class="t-eta padding__top__custom">
                            @lang('messages.services-activities.breathtaking_desc')

                        </p>
                    </div>

                </div>

                <!-- 4 vibrant cities -->
                <div class="service-element__container">

                    <div class="service-element__title-container">
                        <h5 class="padding__bottom__xs">
                            @lang('messages.services-activities.cuisine')

                        </h5>
                    </div>

                    <div class="service-element__image-container">
                        <div class="service-element__image-4 service-element--icon-position">
                            <div class="service-element__icon-container">
                                <img src="./assets/cyrcle-food04.svg" class="service-element__icon" />
                            </div>
                        </div>
                    </div>


                    <div class="service-element__text-container">
                        <p class="t-eta padding__top__custom">
                            @lang('messages.services-activities.cuisine_desc')

                        </p>
                    </div>

                </div>


                <!-- zadnji servicelist div -->
            </div>
            <!-- zadnji servicelist div -->


        </div>


        {{-- <div class="homepage__row__container services--padding-top-4 service-subscribe--visibility">
                        <!-- subscribe start-->

                        <!-- za uradit: dodati width, space between-->

                        <div
                                class="search homepage__row__container image__corner__all ds--primary"
                                style="padding: 20px 40px 20px 40px;"
                        >
                            <div>
                                <h5>
                                    Get more news about our top offers in newsletter subscription!
                                </h5>
                            </div>

                            <div class="padding__right__2">
                                <input
                                        type="text"
                                        class="input input--text"
                                        placeholder="Enter you e-mail address?"
                                        style="width: 230px;"
                                />
                            </div>
                            <div>
                                <button class="btn--med btn btn--primary">
                                    Subscribe
                                </button>
                            </div>
                        </div>

                        <!-- subscribe button end-->

                    </div> --}}


        <newsletter color="white"></newsletter>


        {{-- <section class="newsletter">
                        <h3 class="newsletter__title">
                            Get more news about our top offers in newsletter subscription!
                        </h3>
                        <div class="newsletter__input">
                            <input
                                    type="text"
                                    id="input"
                                    class="input input--text"
                                    placeholder="Enter your E-mail"
                            />
                        </div>
                        <button class="newsletter__button btn btn--primary btn--med">
                            Subscribe
                        </button>
                    </section> --}}
    </div>
</div>



@stop
<!-- 2. fotke. jednu hideat za prikaz u desktopu, a drugu za prikaz u mobile-u -->

@extends('rogoznica.layout.master')
@section('content')
<div>
    <!-- Background in serviceandactivities.css -->


    <!-- Background in serviceandactivities.css -->
    <div class="serviceandactivities__hero">
        @include('rogoznica.includes.header')
        <div class="wrapper accommodation__header padding__top__3 media-to-header">
            <h1 class="accommodation__header__title rogoznica__title padding-bottom--0">
                @lang('messages.rogoznica.heart_dalmatia') </h1>
            <div class="container__row__center-s rogo-sub-new title-subtitle__spacing">
                <p class="t-eta">@lang('messages.rogoznica.mediterranean')</p>
            </div>
        </div>
    </div>



    <div class="white-bg margin__top__minus18 padding__bottom d-white-stuff">
        <!-- Where is it 01-->
        <div class="wrapper homepage__row__container padding__top__bottom3 media-to-column wrapper-media-padding-first">
            <!-- lijeva ikonica -->
            <div class="margin__top__minus8">
                <img class="image__corner padding__right__3 media-to-hide" src="./assets/rogo-position-pin.svg" />
            </div>
            <!-- lijevi tekst -->

            <div class=" container-rogo__flex__1 ">

                <div class="display__column__flex max__width__520">
                    <h2 class="margin__top__minus10 padding__bottom__3 media-text-title media-zero-padding">
                        @lang('messages.rogoznica.where')
                    </h2>
                    <img class="border__radius__20 padding__left__5 img__props media-zero-padding media-to-show"
                        src="/assets/images/Where-is-it.jpg" />
                    <p class="t-zeta t-bold padding__bottom__2 media-text-body">
                        @lang('messages.rogoznica.where_desc')

                    </p>
                    <p class="t-eta media-text-body">
                        @lang('messages.rogoznica.where_desc_2')

                    </p>
                </div>
            </div>

            <!--desni foto desktop (skriven u mobile)-->
            <div class="container-rogo__flex__1 media-to-hide">
                <img class="border__radius__20 padding__left__5 img__props media-zero-padding"
                    src="/assets/images/Where-is-it.jpg" />
            </div>
        </div>

        <!-- How to get there 02-->
        <div class="wrapper homepage__row__container padding__top__bottom33 media-to-column wrapper-media-padding">
            <!-- lijeva ikonica -->
            <div class="margin__top__minus8">
                <img class="image__corner padding__right__3 media-to-hide" src="./assets/rogo-road-2.svg" />
            </div>
            <!-- lijevi tekst -->
            <div class=" container-rogo__flex__1 ">
                <div class="display__column__flex max__width__520">
                    <h2 class="margin__top__minus10 padding__bottom__3 media-text-title media-zero-padding">
                        @lang('messages.rogoznica.how')

                    </h2>
                    <img class="border__radius__20 padding__left__5 img__props media-zero-padding media-to-show"
                        src="/assets/images/Dalmatia-beating-heart.jpg" />
                    <p class="t-zeta t-bold padding__bottom__2 media-text-body">
                        @lang('messages.rogoznica.how_desc')

                    </p>
                    <p class="t-eta media-text-body">
                        @lang('messages.rogoznica.how_desc_2')

                    </p>
                </div>
            </div>

            <!--desni foto -->
            <div class="container-rogo__flex__1">
                <img class="border__radius__20 img__props media-zero-padding media-to-hide"
                    src="/assets/images/Dalmatia-beating-heart.jpg" />
            </div>
        </div>

        <!-- To sum it all... -->

        <div class="wrapper homepage__row__container padding__top__bottom333">
            <div class=" homepage__row__container ">
                <!-- lijeva ikonica -->
                <div>
                    <img class="image__corner padding__right__3 media-to-hide" src="./assets/rogo-buddhism.svg" />
                </div>
                <div class="display__column__flex">
                    <h5 class="italic__580">
                        @lang('messages.rogoznica.sum_all')
                    </h5>
                </div>
            </div>
        </div>

        {{-- <div
                    class="homepage__row__container padding__top__1 padding__bottom__70 media-to-hide"
            >
                <!-- subscribe start-->

                <!-- za uradit: dodati width, space between-->

                <div
                        class="search homepage__row__container image__corner__all ds--primary padding__20_40 background__greyish "
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



        <div class="wrapper rogoznica__padding-subscribe">



            <newsletter color="gray"></newsletter>
            {{-- <section class="newsletter background__greyish">
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

</div>

@stop
@extends('rogoznica.layout.master')
@section('content')
<div>
    <!-- Background in serviceandactivities.css -->
    <div class="rentaboat__hero">
        @include('rogoznica.includes.header')

        <div class="wrapper accommodation__header padding__top__3 media-to-header">
            <div style="display: flex; justify-content: center">
                <h1 class="accommodation__header__title padding__bottom__xs service__title" style="max-width: 680px">
                    {{-- @lang('messages.transfers.transfers') --}}

                    @lang('messages.services-activities.rent_a_boat_main')
                </h1>
            </div>

        </div>
    </div>


    <div class="wrapper wrapper--sml-rounded wrapper-service">
        <div class="accommodation__list padding__bottom__0 padding__top__0">
            <section class="services__wrapper">
                <div class="accommodation__list">
                    <div class="homepage__row__container media__to__column padding__top__bottom2e"
                        style="flex-direction: column">
                        <!-- title -->
                        <div div class="services-box--item" style="max-width: 451px; padding-bottom: 1em">

                            <h2>Rent-a-boat</h2>

                        </div>
                        <div>
                            <p class="t-eta dark__blue">
                                @lang('messages.services-activities.rent_a_boat_sub')

                            </p>
                        </div>
                        <!--van img -->


                    </div>

                    <div class="services-box--item" style="display: flex; padding-top: 3em; padding-bottom: 2em">
                        <div style="flex: 1">
                            <img src=" ./assets/boatcube.jpg" class="border-radius--16"
                                style="width: 100%; max-width: 450px;">
                        </div>
                        <div class="transfer-svg-init media-to-hide--sml">

                            {{-- <img src="./assets/illustration-transfer.svg"> --}}
                            <div class="transfer-boat-img"></div>

                        </div>

                    </div>


                    {{-- 
                    <div>
                        <!-- illustration -->
                        <div class="services-box--item" style="margin-top: 4em; margin-bottom: 2em">
                            <div class="van-img-container">
                                <img src="./assets/van01.jpg" style="width: 100%; border-radius: 16px;">
                            </div>
                            <div class="transfer-image-container media-to-hide--sml">
                                <img class="media-to-hide--sml" src=" ./assets/illustration-transfer.svg">
                            </div>
                        </div>
                    </div> --}}
                    <div class="homepage__row__container transfer-to-column transfer-media">

                        <!-- airport-split-->
                        <div class="transfer-box--item">

                            <div
                                class="service__padding-top-20 services--pading-bottom-custom homepage__body__row flex-to-none">
                                <p
                                    class="t-zeta t-bold padding__top__xs padding__bottom__xs homepage-element__subtitle">
                                    {{-- @lang('messages.services-activities.rent_a_boat') --}}
                                    220,00 € per day
                                </p>

                                <div class="transfer__maxwidth">
                                    <p class="t-eta services__blue">
                                        July / August
                                    </p>

                                </div>
                            </div>
                        </div>

                        <!-- airport-zadar -->
                        <div class="transfer-box--item">

                            <div
                                class="service__padding-top-20 services--pading-bottom-custom homepage__body__row flex-to-none">
                                <p
                                    class="t-zeta t-bold padding__top__xs padding__bottom__xs homepage-element__subtitle">
                                    {{-- @lang('messages.services-activities.minivan_tours') --}}
                                    199,00 € per day
                                </p>
                                <div class="transfer__maxwidth">
                                    <p class="t-eta services__blue">
                                        June & September

                                    </p>

                                </div>
                            </div>
                        </div>
                        <!-- airport-zadar -->
                        <div class="transfer-box--item">

                            <div
                                class="service__padding-top-20 services--pading-bottom-custom homepage__body__row flex-to-none">
                                <p
                                    class="t-zeta t-bold padding__top__xs padding__bottom__xs homepage-element__subtitle">
                                    {{-- @lang('messages.services-activities.minivan_tours') --}}
                                    189,00 € per day
                                </p>
                                <div class="transfer__maxwidth">
                                    <p class="t-eta services__blue">
                                        May / October

                                    </p>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>




    </div>



    <div class="wrapper wrapper--sml-rounded wrapper-service padding-top--4">
        <div class="wrapper homepage__body__row">


            {{-- <h3 class="homepage__lightblue__title" style="padding-bottom: 1em">Our transportation
                </h3> --}}

            <div>
                <sac-carousel>
                    <div class="pts-element">
                        <img class="border-radius--12" src="/assets/boat01.jpg" />
                    </div>
                    <div class="pts-element">
                        <img class="border-radius--12" src="/assets/boat02.jpg" />
                    </div>
                    <div class="pts-element">
                        <img class="border-radius--12" src="/assets/boat03.jpg" />
                    </div>
                    <div class="pts-element">
                        <img class="border-radius--12" src="/assets/boat04.jpg" />
                    </div>

                </sac-carousel>
            </div>
        </div>
    </div>
    <div class="wrapper transfer--padding-top-3 transfer--padding-bottom-4">
        <newsletter color="white"></newsletter>

    </div>



</div>



@stop
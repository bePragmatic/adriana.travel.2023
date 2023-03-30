@extends('rogoznica.layout.master')
@section('content')
<div>
    <!-- Background in serviceandactivities.css -->
    <div class="transfersandtours__hero">
        @include('rogoznica.includes.header')

        <div style="display: flex; align-items: center">
            <div class="wrapper accommodation__header padding__top__3 media-to-header" style="padding-top: 4em">
                <div>
                    <h1 class="accommodation__header__title service__title">
                        @lang('messages.services-activities.airport_transfers_tours_main')
                    </h1>
                </div>
                {{-- <div class="container__row__center-s">
                <p class="t-eta subtitle__alignment subtitle-services__padding-bottom">
                    @lang('messages.transfers.vw') </p>
            </div> --}}
            </div>
        </div>
    </div>


    <div class="wrapper wrapper--sml-rounded wrapper-service">
        <div class="accommodation__list padding__bottom__0 padding__top__0">
            <section class="services__wrapper">
                <div class="accommodation__list">
                    <div class="homepage__row__container media__to__column padding__top__bottom2e">
                        <!-- title -->
                        <div class="services-box--item"
                            style="max-width: 451px; padding-bottom: 1em; display: flex; flex-direction: column; justify-content: space-between">

                            <h2>@lang('messages.services-activities.airport_transfers')</h2>
                            <p class="t-eta dark__blue padding-top--2">
                                @lang('messages.services-activities.airport_transfers_descin')

                            </p>
                        </div>
                        <div>

                        </div>
                        <!--van img -->


                    </div>

                    <div class="services-box--item" style="display: flex; padding-top: 3em; padding-bottom: 2em">
                        <div style="flex: 1">
                            <img src=" ./assets/vozilo011.jpg" class="border-radius--16"
                                style="width: 100%; max-width: 450px;">
                        </div>
                        <div class="transfer-svg-init media-to-hide--sml">

                            {{-- <img src="./assets/illustration-transfer.svg"> --}}
                            <div class="transfer-van-img"></div>

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
                                <p class="t-bold padding__top__xs padding__bottom__xs homepage-element__subtitle">
                                    {{-- @lang('messages.services-activities.rent_a_boat') --}}
                                    @lang('messages.services-activities.rogo_split')
                                </p>

                                <div class="transfer__maxwidth">
                                    <div style="display: flex; padding-top: 1em">
                                        <p class=" t-eta services__blue">
                                            55,00 €
                                        </p>
                                        <p class=" margin-left--1">
                                            (@lang('messages.transfers.one-way'))
                                        </p>
                                    </div>
                                    <div style="display: flex; padding-top: 5px">
                                        <p class="t-eta services__blue">
                                            105,00 €
                                        </p>
                                        <p class="margin-left--1">
                                            (@lang('messages.transfers.round-trip'))
                                        </p>
                                    </div>
                                </div>


                            </div>
                        </div>

                        <!-- airport-zadar -->
                        <div class="transfer-box--item">

                            <div
                                class="service__padding-top-20 services--pading-bottom-custom homepage__body__row flex-to-none">
                                <p class="t-bold padding__top__xs padding__bottom__xs homepage-element__subtitle">
                                    {{-- @lang('messages.services-activities.minivan_tours') --}}
                                    @lang('messages.services-activities.rogo_zadar')
                                </p>

                                <div class="transfer__maxwidth">
                                    <div style="display: flex; padding-top: 1em">
                                        <p class=" t-eta services__blue">
                                            144,00 €
                                        </p>
                                        <p class=" margin-left--1">
                                            (@lang('messages.transfers.one-way'))
                                        </p>
                                    </div>
                                    <div style="display: flex; padding-top: 5px">
                                        <p class="t-eta services__blue">
                                            265,00 €
                                        </p>
                                        <p class="margin-left--1">
                                            (@lang('messages.transfers.round-trip'))
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <div class="wrapper wrapper--sml-rounded wrapper-service padding-top--4">
            <div class="wrapper homepage__body__row">


                {{-- <h3 class="homepage__lightblue__title" style="padding-bottom: 1em">Our transportation
                    </h3> --}}

                <div>
                    <sac-carousel>
                        <div class="pts-element">
                            <img class="border-radius--12" src="/assets/van01.jpg" />
                        </div>
                        <div class="pts-element">
                            <img class="border-radius--12" src="/assets/van02.jpg" />
                        </div>
                        <div class="pts-element">
                            <img class="border-radius--12" src="/assets/van03.jpg" />
                        </div>
                        <div class="pts-element">
                            <img class="border-radius--12" src="/assets/van04.jpg" />
                        </div>
                        <div class="pts-element">
                            <img class="border-radius--12" src="/assets/van05.jpg" />
                        </div>
                        <div class="pts-element">
                            <img class="border-radius--12" src="/assets/van06.jpg" />
                        </div>
                    </sac-carousel>
                </div>

            </div>
        </div>

        <div class="wrapper homepage__body__row transfer--padding-top-1 transfer--padding-bottom-4 padding-zero">
            <div class="padding-top--2">
                <h2 class="lightblue-title__basic">
                    @lang('messages.services-activities.minivan_tours')
                </h2>
                <p class="t-eta dark__blue padding-top--2 padding-bottom--3">
                    @lang('messages.services-activities.minivan_tours_descin')


                </p>
            </div>
            <div class="homepage-lost padding-top-bottom--1-3 media-to-hide--sml ">
                <div class="transfer-lost--1-3 border-radius--12 blog-zoom cursor--pointer transfer-item-props-c ">
                    <div class="transfer-img-container">
                        <img class="image__corner__top--12 " src="./assets/images/diokletian-split.jpg">
                    </div>
                    <div class=" text-container__transfer text-container-transfer--layout" style="flex: 1">
                        <p class="homepage-element__subtitle font-weight--600 padding-top--1">
                            <a>
                                @lang('messages.services-activities.rogoznica') - @lang('messages.explore.split')
                            </a>
                        </p>
                        <div class="padding-top--5px">
                            <p class="t-eta">
                                83,00 € (@lang('messages.transfers.one-way'))
                            </p>
                            <p class="t-eta">
                                160,00 € (@lang('messages.transfers.round-trip'))
                            </p>

                        </div>
                    </div>
                </div>

                <div class="transfer-lost--1-3 border-radius--12 blog-zoom cursor--pointer transfer-item-props-c ">
                    <div class=" transfer-img-container">
                        <img class="image__corner__top--12" src="./assets/images/trogir-city.jpg">
                    </div>
                    <div class=" text-container__transfer text-container-transfer--layout" style="flex: 1">
                        <p class="homepage-element__subtitle font-weight--600 padding-top--1">
                            <a>
                                @lang('messages.services-activities.rogoznica') - @lang('messages.explore.trogir')
                            </a>
                        </p>
                        <div class="padding-top--5px">
                            <p class="t-eta">
                                43,00 € (@lang('messages.transfers.one-way'))
                            </p>
                            <p class="t-eta">
                                81,00 € (@lang('messages.transfers.round-trip'))
                            </p>
                        </div>
                    </div>
                </div>

                <div class="transfer-lost--1-3 border-radius--12 blog-zoom cursor--pointer transfer-item-props-c ">
                    <div class="transfer-img-container">
                        <img class="image__corner__top--12" src="./assets/images/krka-park.jpg">
                    </div>
                    <div class=" text-container__transfer text-container-transfer--layout" style="flex: 1">
                        <p class="homepage-element__subtitle font-weight--600 padding-top--1">
                            <a>
                                @lang('messages.services-activities.rogoznica') - Krka</a>
                        </p>
                        <div class="padding-top--5px">
                            <p class="t-eta">
                                68,00 € (@lang('messages.transfers.one-way'))
                            </p>
                            <p class="t-eta">
                                130,00 € (@lang('messages.transfers.round-trip'))
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="homepage-lost media-to-hide--sml">
                <div class="transfer-lost--1-3 border-radius--12 blog-zoom cursor--pointer transfer-item-props-c ">
                    <div class="transfer-img-container">
                        <img class="image__corner__top--12" src="./assets/images/sibenik-transfer.jpg">
                    </div>
                    <div class=" text-container__transfer text-container-transfer--layout" style="flex: 1">

                        <p class="homepage-element__subtitle font-weight--600 padding-top--1">
                            <a>
                                @lang('messages.services-activities.rogoznica') - @lang('messages.explore.sibenik')
                            </a>
                        </p>
                        <div class="padding-top--5px">
                            <p class="t-eta">
                                53,00 € (@lang('messages.transfers.one-way'))
                            </p>
                            <p class="t-eta">
                                101,00 € (@lang('messages.transfers.round-trip'))
                            </p>
                        </div>

                    </div>
                </div>

                <div class="transfer-lost--1-3 border-radius--12 blog-zoom cursor--pointer transfer-item-props-c ">
                    <div class="transfer-img-container">
                        <img class="image__corner__top--12" src="/assets/images/zadar-small.jpg">
                    </div>
                    <div class=" text-container__transfer text-container-transfer--layout" style="flex: 1">
                        <p class="homepage-element__subtitle font-weight--600 padding-top--1">
                            <a>
                                @lang('messages.explore.zadar')
                            </a>
                        </p>
                        <div class="padding-top--5px">
                            <p class="t-eta">
                                83,00 € (@lang('messages.transfers.one-way'))
                            </p>
                            <p class="t-eta">
                                160,00 € (@lang('messages.transfers.round-trip'))
                            </p>
                        </div>
                    </div>
                </div>

                <div class="transfer-lost--1-3 blog-zoom cursor--pointer">

                    <div class="transfer-places-bg__btn border-radius--12 padding-all--1 places__flex-props">
                        <p class="transfer-places__text">
                            @lang('messages.explore.for_all_rides')

                        </p>
                        <a href="{{ route('contact_us') }}" class="btn btn--secondary btn--noborder btn--max-width">
                            <p class="button__text"> @lang('messages.contactus.contactus')</p>
                        </a>
                    </div>


                </div>

            </div>



            <div class="media-to-show--carousel padding-bottom--2">
                <wts-carousel>
                    <div class="wts-element">
                        <img class="image__corner__top--12 stay-img-props" src="/assets/images/krka-park.jpg" />

                        <div class=" text-container__transfer" style="flex: 1">
                            <p class="homepage-element__subtitle font-weight--600 padding-top--1">
                                <a>
                                    @lang('messages.services-activities.rogoznica') - @lang('messages.explore.split')
                                </a>
                            </p>
                            <div class="padding-top--5px">
                                <p class="t-eta">
                                    83,00 € (@lang('messages.transfers.one-way'))
                                </p>
                                <p class="t-eta">
                                    160,00 € (@lang('messages.transfers.round-trip'))
                                </p>

                            </div>
                        </div>
                    </div>
                    <div class="wts-element">
                        <div>
                            <img class="image__corner__top--12 stay-img-props" src="/assets/images/trogir-city.jpg" />
                            <div class=" text-container__transfer" style="flex: 1">
                                <p class="homepage-element__subtitle font-weight--600 padding-top--1">
                                    <a>
                                        @lang('messages.services-activities.rogoznica') -
                                        @lang('messages.explore.trogir')
                                    </a>
                                </p>
                                <div class="padding-top--5px">
                                    <p class="t-eta">
                                        43,00 € (@lang('messages.transfers.one-way'))
                                    </p>
                                    <p class="t-eta">
                                        81,00 € (@lang('messages.transfers.round-trip'))
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="wts-element">
                        <div>
                            <img class="image__corner__top--12 stay-img-props"
                                src="/assets/images/diokletian-split.jpg" />
                            <div class=" text-container__transfer" style="flex: 1">
                                <p class="homepage-element__subtitle font-weight--600 padding-top--1">
                                    <a>
                                        @lang('messages.services-activities.rogoznica') - Krka</a>
                                </p>
                                <div class="padding-top--5px">
                                    <p class="t-eta">
                                        68,00 € (@lang('messages.transfers.one-way'))
                                    </p>
                                    <p class="t-eta">
                                        130,00 € (@lang('messages.transfers.round-trip'))
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="wts-element">
                        <div>
                            <img class="image__corner__top--12 stay-img-props"
                                src="/assets/images/sibenik-transfer.jpg" />
                            <div class=" text-container__transfer" style="flex: 1">

                                <p class="homepage-element__subtitle font-weight--600 padding-top--1">
                                    <a>
                                        @lang('messages.services-activities.rogoznica') -
                                        @lang('messages.explore.sibenik')
                                    </a>
                                </p>
                                <div class="padding-top--5px">
                                    <p class="t-eta">
                                        53,00 € (@lang('messages.transfers.one-way'))
                                    </p>
                                    <p class="t-eta">
                                        101,00 € (@lang('messages.transfers.round-trip'))
                                    </p>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="wts-element">
                        <div>
                            <img class="image__corner__top--12 stay-img-props" src="/assets/images/zadar-small.jpg" />
                            <div class=" text-container__transfer" style="flex: 1">
                                <p class="homepage-element__subtitle font-weight--600 padding-top--1">
                                    <a>
                                        @lang('messages.explore.zadar')
                                    </a>
                                </p>
                                <div class="padding-top--5px">
                                    <p class="t-eta">
                                        83,00 € (@lang('messages.transfers.one-way'))
                                    </p>
                                    <p class="t-eta">
                                        160,00 € (@lang('messages.transfers.round-trip'))
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </wts-carousel>

            </div>


        </div>


    </div>


    <div class="media-to-show--carousel padding-top-transfer-d margin-bottom--3">

        <div class="transfer-places-bg__btn padding-all--1 places__flex-props">
            <p class="transfer-places__text" style="padding-top: 0">

                @lang('messages.explore.for_all_rides')


            </p>
            <a href="{{ route('contact_us') }}" class="btn btn--secondary btn--noborder btn--max-width">
                <p class="button__text">@lang('messages.contactus.contactus')</p>
            </a>
        </div>


    </div>



    <div class="wrapper transfer--padding-top-3 transfer--padding-bottom-4">
        <newsletter color="white"></newsletter>

    </div>



</div>



@stop
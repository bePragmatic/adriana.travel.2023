@extends('rogoznica.layout.master')
@section('content')
<div>
    <div class="explore__hero">
        @include('rogoznica.includes.header')

        <div class="wrapper">
            <div class="explore__header--lost">
                <div class="explore__title-container">
                    <h1 class="explore__header__title">
                        @lang('messages.explore.million-travellers') </h1>
                </div>
                <div class="explore__header-text">
                    <p class="t-eta dark__blue">
                        @lang('messages.explore.check')
                    </p>
                    <p class="padding-top--2">
                        @lang('messages.explore.dazzling')
                    </p>
                    <p class="padding-top--2">
                        @lang('messages.explore.stretching')
                    </p>
                </div>
            </div>
        </div>

    </div>

    <div class="wrapper">
        <section class="explore__subtitle">
            {{-- <div class="explore__subtitle--primary">


            </div> --}}
            <h2 class="explore__subtitle--secondary">
                @lang('messages.explore.ready')
            </h2>
        </section>


        <!-- test za git2 -->



        <!-- sibenik -->
        <section>
            <div class="ds ds--primary">
                <div class="ds__image ds__image ds__image--sibenik"></div>
                <div class="ds__copy">
                    <h2 class="ds__copy__title"> @lang('messages.explore.sibenik') </h2>
                    <div class="ds__copy__columns">
                        <p class="ds__copy__subtitle">
                            @lang('messages.explore.sibenik_desc01')
                        </p>
                        <p>
                            @lang('messages.explore.sibenik_desc02')

                        </p>
                        <p>@lang('messages.explore.sibenik_desc03')

                        </p>
                    </div>
                </div>
            </div>

            <div class="ds__noted">
                <h3>@lang('messages.explore.sibenik_worth') </h3>
                <div class="ds__noted__item">
                    <a href="https://www.sibenik-tourism.hr/lokacije/cathedral-of%20-st-james/1/en.html"
                        target="_blank"> <img class="explore-element__icon" src="./assets/icon-zadar-2.svg"
                            alt="Icon" />
                        <p class="icon-explore-text o-60 icon-text__min-width">@lang('messages.explore.st_james') </p>
                    </a>
                </div>
                <div class="ds__noted__item">
                    <a href="https://www.sibenik-tourism.hr/lokacije/st-nicholas'-fortress/2/en.html" target="_blank">
                        <img class="explore-element__icon" src="./assets/icon-sibenik-2.svg" alt="Icon" />
                        <p class="icon-explore-text o-60 icon-text__min-width">@lang('messages.explore.st_nicholas')
                        </p>
                    </a>
                </div>
                <div class="ds__noted__item">
                    <a href="http://www.np-krka.hr/en/" target="_blank"> <img class="explore-element__icon"
                            src="./assets/icon-sibenik-3.svg" alt="Icon" />
                        <p class="icon-explore-text o-60 icon-text__min-width">@lang('messages.explore.krka') </p>
                    </a>
                </div>
                <div class="ds__noted__item">
                    <a href="http://www.np-kornati.hr/en/" target="_blank"> <img class="explore-element__icon"
                            src="./assets/icon-sibenik-1.svg" alt="Icon" />
                        <p class="icon-explore-text o-60 icon-text__min-width">@lang('messages.explore.kornati') </p>
                    </a>
                </div>
            </div>
        </section>



        <!-- split -->
        <section>
            <div class="ds ds--secondary">
                <div class="ds__image ds__image--split"></div>
                <div class="ds__copy">
                    <h2 class="ds__copy__title">@lang('messages.explore.split')</h2>
                    <div class="ds__copy__columns">
                        <p class="ds__copy__subtitle">
                            @lang('messages.explore.split_desc01')

                        </p>
                        <p>
                            @lang('messages.explore.split_desc02')

                        </p>
                    </div>
                </div>
            </div>

            <div class="ds__noted">
                <h3>@lang('messages.explore.split_worth')</h3>
                <div class="ds__noted__item">
                    <a href="https://visitsplit.com/en/448/diocletian-palace" target="_blank"> <img
                            class="explore-element__icon" src="./assets/icon-zadar-2.svg" alt="Icon" />
                        <p class="icon-explore-text o-60 icon-text__min-width">@lang('messages.explore.diocletian')</p>
                    </a>
                </div>
                <div class="ds__noted__item">
                    <a href="https://visitsplit.com/en/527/cathedral-of-saint-domnius" target="_blank"> <img
                            class="explore-element__icon" src="./assets/oldTown.svg" alt="Icon" />
                        <p class="icon-explore-text o-60 icon-text__min-width">@lang('messages.explore.st_dominus') </p>
                    </a>
                </div>
                <div class="ds__noted__item">
                    <a href="https://www.tvrdavaklis.com/?lang=en" target="_blank"> <img class="explore-element__icon"
                            src="./assets/icon-sibenik-2.svg" alt="Icon" />
                        <p class="icon-explore-text o-60 icon-text__min-width">@lang('messages.explore.klis')</p>
                    </a>
                </div>
                <div class="ds__noted__item">
                    <a href="https://croatiaspots.com/bisevo/" target="_blank"> <img class="explore-element__icon"
                            src="./assets/icon-zadar-4.svg" alt="Icon" />
                        <p class="icon-explore-text o-60 icon-text__min-width">@lang('messages.explore.blue_cave')</p>
                    </a>
                </div>
            </div>
        </section>


        <!-- zadar -->
        <section>
            <div class="ds ds--primary">
                <div class="ds__image ds__image--zadar"></div>
                <div class="ds__copy">
                    <h2 class="ds__copy__title">@lang('messages.explore.zadar')</h2>
                    <div class="ds__copy__columns">
                        <p class="ds__copy__subtitle">
                            @lang('messages.explore.zadar_desc01')
                        </p>
                        <p> @lang('messages.explore.zadar_desc02')

                        </p>
                    </div>
                </div>
            </div>

            <div class="ds__noted">
                <h3>@lang('messages.explore.zadar_worth')</h3>
                <div class="ds__noted__item">
                    <a href="https://www.zadar.travel/en/city-guide/historical-monuments/22-05-2007/st-donatus-church#.XqKdBtMzajg "
                        target="_blank">
                        <img class="explore-element__icon" src="./assets/icon-zadar-2.svg" alt="Icon" />
                        <p class="icon-explore-text o-60 icon-text__min-width">@lang('messages.explore.st_donatus')</p>
                    </a>
                </div>
                <div class="ds__noted__item">
                    <a href="https://www.zadar.hr/en/experience/history-culture/sea-organ-sun-salutation"
                        target="_blank"> <img class="explore-element__icon" src="./assets/iconZadarOrgan.svg"
                            alt="Icon" />
                        <p class="icon-explore-text o-60 icon-text__min-width">@lang('messages.explore.sea_organ')</p>
                    </a>
                </div>
                <div class="ds__noted__item">
                    <a href="https://np-paklenica.hr/en/" target="_blank"> <img class="explore-element__icon"
                            src="./assets/icon-zadar-3.svg" alt="Icon" />
                        <p class="icon-explore-text o-60 icon-text__min-width">@lang('messages.explore.paklenica')</p>
                    </a>
                </div>
                <div class="ds__noted__item">
                    <a href="http://tzgpag.hr/en/" target="_blank"> <img class="explore-element__icon"
                            src="./assets/icon-sibenik-1.svg" alt="Icon" />
                        <p class="icon-explore-text o-60 icon-text__min-width">@lang('messages.explore.pag')</p>
                    </a>
                </div>
            </div>
        </section>

        <!-- dubrovnik -->
        <section>
            <div class="ds ds--secondary ">
                <div class="ds__image ds__image--dubrovnik"></div>
                <div class="ds__copy">
                    <h2 class="ds__copy__title">@lang('messages.explore.dubrovnik')</h2>
                    <div class="ds__copy__columns">
                        <p class="ds__copy__subtitle">
                            @lang('messages.explore.dubrovnik_desc01')
                     
                        </p>
                        <p> @lang('messages.explore.dubrovnik_desc02')

                            
                        </p>
                        <p> @lang('messages.explore.dubrovnik_desc03')

                            
                        </p>
                    </div>
                </div>
            </div>

            <div class="ds__noted">
                <h3> @lang('messages.explore.dubrovnik_worth')
                </h3>
                <div class="ds__noted__item">
                    <a href="https://www.wallsofdubrovnik.com/" target="_blank"> <img class="explore-element__icon"
                            src="./assets/icon-sibenik-2.svg" alt="Icon" />
                        <p class="icon-explore-text o-60 icon-text__min-width"> @lang('messages.explore.walls')
                            </p>
                    </a>
                </div>
                <div class="ds__noted__item">
                    <a href="https://www.dubrovnik-travel.net/dubrovnik-old-town/" target="_blank"> <img
                            class="explore-element__icon" src="./assets/oldTown.svg" alt="Icon" />
                        <p class="icon-explore-text o-60 icon-text__min-width"> @lang('messages.explore.old_town')
                            </p>
                    </a>
                </div>
                <div class="ds__noted__item">
                    <a href="https://www.mljettravel.com/national-park/" target="_blank"> <img
                            class="explore-element__icon" src="./assets/icon-sibenik-3.svg" alt="Icon" />
                        <p class="icon-explore-text o-60 icon-text__min-width"> @lang('messages.explore.mljet')
                            </p>
                    </a>
                </div>
                <div class="ds__noted__item">
                    <a href="https://www.korculainfo.com/" target="_blank"> <img class="explore-element__icon"
                            src="./assets/icon-sibenik-1.svg" alt="Icon" />
                        <p class="icon-explore-text o-60 icon-text__min-width"> @lang('messages.explore.korcula')
                            </p>
                    </a>
                </div>
            </div>
        </section>

        <newsletter color="white"></newsletter>
    </div>

</div>

@stop
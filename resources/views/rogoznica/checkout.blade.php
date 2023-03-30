@extends('rogoznica.layout.master')

@section('content')

<div>


    <!-- Background in accommodation.css -->
    <!-- Background in serviceandactivities.css -->
    <div class="payment-hero">
        @include('rogoznica.includes.header')
        <div class="wrapper payment-header__props">
            <h1 class="payment-header__title accommodation__header__title">
                @lang('messages.home.checkout-title')
            </h1>
        </div>
    </div>

    <!-- PAGE CONTENT (TWO COLUMNS) -->
    <div class="wrapper white-bg margin__bottom__30 overflow__hidden page-content-h-m">
        {{ Form::open(array('url' => '/', 'method' => 'post','id'=>'checkout-form')) }}

        <div class="accommodation">


            <!-- aside
                    staviti da aside zauzima određeni dio prostora
                i da ovaj drugi isto zauzima određeni dio prostora sa lost
            i onda gurnut između-->

            <aside class="accommodation__filters padding__top__1 aside-to-hide">

                <div class="border-radius--12 overflow--hidden">
                    {!! Html::image($result->photo_name, $result->name, ['class' => 'img-fluid']) !!}
                </div>
                <!-- Filter open/close. On click ".filter--header" should toggle class ".active" on itself and ".filter__holder". Should be incorporated with smooth js open -->
                <div class="filter__holder padding-top--2">
                    <div>
                        <div class="d-flex--space-between">
                            <h4 class="filter__title--dark-blue padding__bottom__xs o-80 font-size--21">
                                {{ $result->name }}
                            </h4>
                            <div class="grade__group">





                                @if ($result->reviews_count != 0)
                                <p class="review-grade">
                                    {{ number_format($result->overall_star_rating['rating_value'], 1) }}
                                    ({{ $result['reviews_count']}})</p>

                                @else
                                <p class="review-grade">0(0)</p>
                                @endif

                                {{--
                             <p class="font-size--14 padding-top--3px"><img src="/assets/icon-star.svg">
                                    4.3 ({{$result->reviews_count}})





                                </p> --}}
                            </div>
                        </div>
                        {{-- <p style="font-size: 14px"> {{$result->sub_name}}</p> --}}


                        <div class="padding-top--1 display-flex">
                            <p class="t-theta"><img src="/assets/Search/pin-3 (1) 1.svg" class="padding-jst-right">
                            </p>
                            <p class="t-theta">

                                @if($result->rooms_address->city !='') {{ $result->rooms_address->city }} , @endif
                                @if($result->rooms_address->state !=''){{ $result->rooms_address->state }} @endif
                                @if($result->rooms_address->country_name !='')
                                , {{  $result->rooms_address->country_name }} @endif
                            </p>


                        </div>

                        <!-- svojstva dinamička -->
                        <div class="padding-top--1">
                            <div class="single-accommodation-props font-size--14">


                                <div class="">


                                    <div class="homepage__row__container padding__top__xs">
                                        <img src="/assets/Search/Check icon.svg" class="padding__right__xs" />
                                        <p>
                                            {{ $result->accommodates }}
                                            {{ trans_choice('messages.home.guest', $result->accommodates ) }}
                                        </p>
                                    </div>

                                    <div class="homepage__row__container padding__top__xs">
                                        <img src="/assets/Search/Check icon.svg" class="padding__right__xs" />
                                        <p>
                                            {{ $result->bedrooms }}
                                            {{ trans_choice('messages.lys.bedrooms', $result->bedrooms ) }}
                                        </p>
                                    </div>

                                    <div class="homepage__row__container padding__top__xs">
                                        <img src="/assets/Search/Check icon.svg" class="padding__right__xs" />
                                        <p>
                                            {{ $result->beds }}
                                            {{ trans_choice('messages.lys.bed',$result->beds) }}
                                        </p>
                                    </div>

                                    <div class="homepage__row__container padding__top__xs">
                                        <img src="/assets/Search/Check icon.svg" class="padding__right__xs" />
                                        <p>
                                            {{ $result->bathrooms == null?'0':$result->bathrooms }}
                                            @if($result->bathrooms != null && $result->bathrooms !=0)
                                            /
                                            {{$result->bathroom_shared=='No'? trans('messages.lys.private'):trans('messages.lys.shared_bath')}}
                                            @endif
                                            {{ trans('messages.lys.bathrooms') }}:
                                        </p>
                                    </div>

                                </div>


                                @foreach(collect($result->amenities)->where('type_id',1)->chunk(2) as $chunk)
                                <div class="single-accommodation-props__container ">
                                    @foreach($chunk as $amenity)
                                    <div class="homepage__row__container padding__top__xs">
                                        <img src="/assets/Search/Check icon.svg" class="padding__right__xs" />
                                        <p>
                                            @if(Session::get('language')=='en')
                                            {{ $amenity->name }}
                                            @elseif($amenity->namelang == null)
                                            {{ $amenity->name }}
                                            @else
                                            {{ $amenity->namelang }}
                                            @endif
                                        </p>
                                    </div>
                                    @endforeach
                                </div>
                                @endforeach

                            </div>
                        </div>
                        <!-- svojstva dinamička kraj-->


                    </div>



                    <!-- nesgto -->

                    {{-- <div class="filter">
                            <p class="aside__text--dark-blue o-60 padding__bottom__2xs">
                                {{ $result->room_type_name }} {{ trans('messages.payments.for') }}
                    </p>
                    <p class="t-bold">
                        {{ date($php_format_date, strtotime($messages[0]->checkin)) }}
                        {{ trans('messages.payments.to') }}
                        {{ date($php_format_date, strtotime($messages[0]->checkout)) }}
                    </p>
                </div> --}}


                <div>
                    <!-- policies -->
                    {{-- <ul class="list__props filter color_000 o-80 padding__bottom__custom">
                                <li>
                                    <div class="homepage__row__container space__between">
                                        <p class="t-eta ">
                                            {{ trans('messages.payments.cancellation_policy') }}

                    </p>

                </div>
                </li>
                <li>
                    <!-- remove red__class from both <p> for regular font color-->
                    <div class="homepage__row__container space__between">
                        <p class="t-eta">
                            {{ trans('messages.lys.house_rules') }}
                        </p>
                        <p class="t-eta t-bold red__class">
                            {{ trans('messages.payments.read_policy') }}
                        </p>
                    </div>
                </li>

                <li>
                    <!-- remove red__class from both <p> for regular font color-->
                    <div class="homepage__row__container space__between">
                        <p class="t-eta">
                            {{ ucfirst(trans_choice('messages.rooms.night',2)) }}
                        </p>
                        <p class="t-eta t-bold">{{ $messages[0]->nights }}</p>
                    </div>
                </li>
                </ul> --}}


                {{-- <p class="t-theta o-60">Fee</p> --}}


                <!-- popusti
                            <ul class="list__props filter color_000 o-80 padding__bottom__custom">
                                <li>
                                    <div class="homepage__row__container space__between">
                                        <p class="t-eta red__class">
                                            {{-- {{ trans('messages.payments.apply') }} --}}
                                </p>
                            </div>
                        </li>
                    </ul>-->


        </div>

    </div>
    </aside>


    <section class="  accommodation__list__wrapper   payment-padding-bottom-3 padding__top__custom">
        <!--PAYMENT-->
        <div class="accommodation__filters__padding__top">


            <div>


                @if(Session::has('message'))
                <div class="alert {{ Session::get('alert-class') }} text-center" role="alert" style="color: red">
                    {{ Session::get('message') }}
                </div>
                @endif


                <h3> {{ trans('messages.payments.billing_info') }}</h3>
                {{-- <div class="padding-top--2 padding-bottom--1">
                                <p class="d-item__name subtext-blue-20"> {{$messages[0]->user_details->first_name}}
                {{$messages[0]->user_details->last_name}}</p>
            </div> --}}
            <div class="filter padding-top--2 display-flex">
                <div class="homepage__body__flex__1">
                    <p class="o-40">@lang('messages.header.checkin')</p>
                    <p class="blue__light">{{$messages[0]->reservation->checkin}}</p>
                </div>
                <div class="homepage__body__flex__1">
                    <p class="o-40">@lang('messages.header.checkout')</p>
                    <p class="blue__light">{{$messages[0]->reservation->checkout}}</p>
                </div>
                <div class="homepage__body__flex__1">
                    <p class="o-40 text-capitalize"> @lang('messages.lys.nights')</p>
                    <p class="blue__light">
                        {{$messages[0]->reservation->nights}}
                        {{ trans_choice('messages.rooms.night', $messages[0]->reservation->nights) }}</p>
                </div>
                <div class="homepage__body__flex__1">
                    <p class="o-40">Guests</p>
                    <p class="blue__light">{{$messages[0]->reservation->number_of_guests}}</p>
                </div>
            </div>

            <div>

                <div>
                    <p class="o-40">@lang('messages.inbox.price')</p>
                    <div class="d-flex--space-between">
                        <p class="o-80">{{number_format($messages[0]->reservation->per_night, 2)}} € x
                            {{$messages[0]->reservation->nights}}

                            {{ trans_choice('messages.rooms.night', $messages[0]->reservation->nights) }}
                        </p>
                        <p class="o-80 t-bold">
                            {{ number_format($messages[0]->reservation->per_night * $messages[0]->reservation->nights, 2)}}
                            €</p>

                    </div>
                    @if($messages[0]->reservation->cleaning > 0)
                    <div class="d-flex--space-between">
                        <p class="o-80">@lang('messages.lys.cleaning'): </p>
                        <p class="o-80 t-bold">{{ number_format($messages[0]->reservation->cleaning, 2) }} €</p>
                    </div>
                        @endif
                </div>

            </div>


            {{-- <div class="alert alert-danger danger-msg__container">
                <span class="payment-error-msg error-msg">test</span>
                <div class="x--exit" onclick="this.parentElement.style.display='none';">&times;</div>
            </div> --}}

            <!-- INPUT PART -->
            <div class="lost-payment">

                <checkout :messages="{{ $messages[0] }}" :user="{{ Auth::user()->load('country') }}"
                    :currency="{{  $messages[0]['reservation']->currency }}" encrypted_id="{{ $encrypted_id }}" />


                @error('error')
                {{-- <div class="flash-container" style="margin-top: 74.9844px;">
                    <div class="alert alert-danger text-center" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        </button><span class="payment-error-msg error-msg">{{ $message }}</span></div>
        </div> --}}

        <div class="alert alert-danger danger-msg__container">
            <span class="payment-error-msg error-msg">{{ $message }}</span>
            <div class="x--exit" onclick="this.parentElement.style.display='none';">&times;</div>
        </div>
        @enderror


</div>


</div>

<!-- INPUT PART END -->


</div>
</section>

<!-- 01 icon and text area -->

<!--
                                        <div class="homepage__row__container padding__top__2">
                                            <div class="message-person--left">
                                                <img src="/assets/images/iconPerson.jpg"/>
                                            </div>
                                            <div class="flex__container__1">
                                  <textarea
                                          class="text-area font__small__14"
                                          placeholder="Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit"
                                          rows="8"
                                          style="width: 80%"
                                  ></textarea>
                                            </div>
                                        </div>
                                    -->


{{-- <div class="paymany-chat__wrapper">
                                    <label for="input" class="field__lbl">EDO</label>
                                    <div class="lost-payment lost-align--center">
                                        <div class="lost-payment__textarea-container">
                                            <div>
                                                <textarea class="text-area font__small__14"
                                                    placeholder="Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit"
                                                    rows="4" style="width: 100%; padding-bottom: 5px"></textarea>
                                            </div>
                                        </div>
                                        <div class="lost-payment__image-container">
                                            <img src="/assets/images/iconPerson.jpg" />
                                        </div>
                                    </div>
                                </div> --}}

</div>

</div>


@push('scripts')

        <script type="text/javascript">
            window.dataLayer.push({
                'event': 'payment-checkout',
                'data': "{!! $result !!}"
            });
        </script>

{{-- <script type="text/javascript">
                 var payment_intent_client_secret  = "{!! session('payment.'.$s_key.'.payment_intent_client_secret') ? session('payment.'.$s_key.'.payment_intent_client_secret') : ''  !!}";
             </script>--}}
@routes
@endpush

@stop

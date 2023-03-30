@extends('rogoznica.layout.master')
@section('content')
<div class="bottom-margin-minus">

    <div style="background: url({{ $result->original_image }}) rgba(16, 48, 76, .6); background-position: center; background-size: cover; background-blend-mode: multiply; padding-bottom: 6px"
        class="sa__hero">


        @include('rogoznica.includes.header')


        <!-- header background image -->
        <div class="wrapper accommodation-single__header">

            <div class="contain-img__class">
                <gallery :images="{{ $rooms_photos }}"></gallery>
            </div>

            {{-- @foreach($rooms_photos as $row_photos)
                    <li data-thumb="{{ $row_photos->slider_image_name }}"
            data-src="{{ $row_photos->slider_image_name }}" data-sub-html=".caption_{{ $row_photos->id }}">
            <img src="{{ $row_photos->slider_image_name }}" title="{{ $row_photos->highlights }}" width="200">
            <div class="caption_{{ $row_photos->id }}">
                <p v-show="false"> {{ $row_photos->highlights }} </p>
            </div>
            </li>
            @endforeach
            --}}

        </div>
    </div>


    <div class="wrapper white-bg margin__bottom__30 overflow__hidden">



        <div class="accommodation single-accommodation-padding-bottom">


            <price-calculator :result="{{ $result }}" formatted_checkin="{{ $formatted_checkin }}"
                formatted_checkout="{{ $formatted_checkout }}" checkin="{{ $checkin }}" checkout="{{ $checkout }}"
                guests="{{  request()->guests }}" token="{{ csrf_token() }}" screen="desktop" />
            </price-calculator>


            <section class="accommodation__list__wrapper padding__top__custom">
                <div class="accommodation__filters__padding__top filter padding__bottom__4">

                    @if(Session::has('message'))
                    <div class="margin-bottom--2 alert alert-error danger-msg__container {{ Session::get('alert-class') }} text-center"
                        role="alert" style="color: red;">
                        <a href="#" class="alert-close x--danger" onclick="this.parentElement.style.display='none';"
                            data-dismiss="alert">&times;</a>
                        {{ Session::get('message') }}
                    </div>


                    @endif

                    <h3>{{ $result->name }} - {{ $result->room_type_name }}</h3>

                    <div class="homepage__row__container ">
                        <img src="/assets/Search/pin-3 (1) 1.svg" class="padding__top__right" />
                        <p class="t-eta padding__top__right">
                            {{$result->rooms_address->city}}@if($result->rooms_address->city !='')
                            ,
                            @endif
                            {{$result->rooms_address->state}}@if($result->rooms_address->state !=''),
                            @endif
                            {{$result->rooms_address->country_name}}
                        </p>
                    </div>




                    <br>
                    <div>
                        <h5 class="padding__top__3 padding__bottom__xs">
                            {{ trans('messages.lys.the_space') }}
                        </h5>
                    </div>

                    <div class="single-accommodation-props">


                        <div class="single-accommodation-props__container ">


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


                        @foreach(collect($amenities)->where('type_id',1)->chunk(4) as $chunk)
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

                <div class="accommodation__filters__padding__top filter padding__bottom__3">
                    <h5 class="padding__top__xs padding__bottom__xs">
                        {{ trans('messages.rooms.about_this_listing') }}
                    </h5>

                    <div class="homepage__row__container padding__top__xs">
                        {!! nl2br($result->summary) !!}
                    </div>
                </div>

                <div class="accommodation__filters__padding__top filter padding__bottom__3">
                    <h5 class="padding__top__xs padding__bottom__xs">
                        {{ trans('messages.rooms.prices') }}
                    </h5>

                    <div class="homepage__row__container padding__top__xs">

                        <div class="homepage__body__flex__1">

                            @if($result->rooms_price->guests !=0 && $result->rooms_price->additional_guest!=0)
                            <span>
                                {{ number_format($result->rooms_price->additional_guest,2) }} {{ $currency_symbol }} /
                                {{ trans('messages.rooms.night_after_guest',['count'=>$result->rooms_price->guests]) }}

                            </span>
                            @else
                            <span>
                                {{ trans('messages.rooms.no_charge') }}
                            </span>
                            @endif

                            <!-- weekend price -->
                            @if($result->rooms_price['original_weekend'] != 0)
                            <div>
                                {{ trans('messages.lys.weekend_pricing') }}:
                                <span id="weekly_price_string">
                                    {{ number_format($result->rooms_price->weekend) }} {{ $currency_symbol }}
                                </span> / {{ trans('messages.lys.weekend') }}
                            </div>
                            @endif
                            </p>
                        </div>

                        <div class="homepage__body__flex__1">


                            @if($result->rooms_price->minimum_stay || $result->rooms_price->maximum_stay)
                            <div class="row">
                                @if($result->rooms_price->minimum_stay)
                                <div class="col-md-6">
                                    <span>{{trans('messages.lys.minimum_stay')}}:</span>
                                    <strong>{{$result->rooms_price->minimum_stay}}</strong>
                                </div>
                                @endif
                                @if($result->rooms_price->maximum_stay)
                                <div class="col-md-6">
                                    <span>{{trans('messages.lys.maximum_stay')}}:</span>
                                    <strong>{{$result->rooms_price->maximum_stay}}</strong>
                                </div>
                                @endif
                            </div>
                            @endif

                            @if($result->availability_rules->count() > 0)
                            <div class="row flex-wrap mt-2">
                                @foreach($result->availability_rules->splice(0, 2) as $rule)
                                <div class="col-md-12 my-2">
                                    {{trans('messages.lys.during')}} {{$rule->during}}
                                    @if($rule->minimum_stay)
                                    <p class="m-0" style="text-transform: capitalize;">
                                        {{trans('messages.lys.guest_stay_for_minimum')}} {{$rule->minimum_stay}}
                                        {{trans('messages.lys.nights')}}
                                    </p>
                                    @endif
                                    @if($rule->maximum_stay)
                                    <p class="m-0" style="text-transform: capitalize;">
                                        {{trans('messages.lys.guest_stay_for_maximum')}} {{$rule->maximum_stay}}
                                        {{trans('messages.lys.nights')}}
                                    </p>
                                    @endif
                                </div>
                                @endforeach

                                @if($result->availability_rules->count() > 0)

                                <div id="expand_data_availability_rules" style="display: none;">
                                    @foreach($result->availability_rules as $rule)
                                    <div class="col-md-12 my-2">
                                        {{trans('messages.lys.during')}} {{$rule->during}}
                                        @if($rule->minimum_stay)
                                        <p class="m-0" style="text-transform: capitalize;">
                                            {{trans('messages.lys.guest_stay_for_minimum')}} {{$rule->minimum_stay}}
                                            {{trans('messages.lys.nights')}}
                                        </p>
                                        @endif
                                        @if($rule->maximum_stay)
                                        <p class="m-0" style="text-transform: capitalize;">
                                            {{trans('messages.lys.guest_stay_for_maximum')}} {{$rule->maximum_stay}}
                                            {{trans('messages.lys.nights')}}
                                        </p>
                                        @endif
                                    </div>
                                    @endforeach
                                </div>
                                @endif
                            </div>
                            @endif

                            {{--    {{ trans('messages.your_reservations.cancellation') }}:
                            <a href="{{ url('/home/cancellation_policies#'.$result->cancel_policy) }}"
                                id="cancellation-policy" class="theme-link">
                                <strong>
                                    {{trans('messages.cancellation_policy.'.strtolower($result->cancel_policy))}}
                                </strong>
                            </a>--}}
                        </div>
                    </div>

                    <div class="homepage__row__container padding__top__xs">

                        @if($result->length_of_stay_rules->count() > 0)
                        <div class="homepage__body__flex__1">
                            <p class="t-theta-iota t-bold padding__top__xs padding__bottom__xs">
                                {{trans('messages.lys.length_of_stay_discounts')}}
                            </p>

                            <div class="homepage__row__container">
                                <div class="homepage__body__flex__1">
                                    @foreach($result->length_of_stay_rules->splice(0,2) as $i => $rule)
                                    <div class="homepage__row__container">
                                        @if(@$rule['period'])
                                        <div class="homepage__body__flex__1">
                                            @if($rule['period'] == 7)
                                            {{trans('messages.lys.weekly')}}
                                            @elseif($rule['period'] == 28)
                                            {{trans('messages.lys.monthly')}}
                                            @else
                                            {{$rule['period']}} {{trans('messages.lys.nights')}}
                                            @endif
                                        </div>
                                        <div class="homepage__body__flex__1">
                                            {{$rule['discount']}}%
                                        </div>
                                        @endif
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @endif


                        @if($result->early_bird_rules->count() > 0)
                        <div class="homepage__body__flex__1">
                            <p class="t-theta-iota t-bold padding__top__xs padding__bottom__xs">
                                {{trans('messages.lys.early_bird_discounts')}}
                            </p>

                            @foreach($result->early_bird_rules->splice(0,2) as $rule)
                            <div class="homepage__row__container">
                                <div class="homepage__body__flex__1">
                                    {{$rule['period']}} {{trans_choice('messages.reviews.day', $rule['period'])}}
                                </div>
                                <div class="homepage__body__flex__1">
                                    {{$rule['discount']}}%
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @endif

                        @if($result->last_min_rules->count() > 0)
                        <div class="homepage__body__flex__1">
                            <p class="t-theta-iota t-bold padding__top__xs padding__bottom__xs">
                                {{trans('messages.lys.last_min_discounts')}}
                            </p>

                            @foreach($result->last_min_rules->splice(0,2) as $rule)
                            <div class="homepage__row__container">
                                <div class="homepage__body__flex__1">
                                    {{$rule['period']}} {{trans_choice('messages.reviews.day', $rule['period'])}}
                                </div>
                                <div class="homepage__body__flex__1">
                                    {{$rule['discount']}}%
                                </div>
                            </div>
                            @endforeach

                            @if($result->last_min_rules->count() > 0)
                            @foreach($result->last_min_rules as $rule)
                            <div class="homepage__row__container">
                                <div class="homepage__body__flex__1">
                                    {{$rule['period']}} {{trans_choice('messages.reviews.day', $rule['period'])}}
                                </div>
                                <div class="homepage__body__flex__1">
                                    {{$rule['discount']}}%
                                </div>
                            </div>
                            @endforeach
                            @endif
                        </div>
                        @endif
                    </div>
                </div>
                @if($result->rooms_description->space !='' || $result->rooms_description->access !='' ||
                $result->rooms_description->interaction !='' || $result->rooms_description->neighborhood_overview !=''
                || $result->rooms_description->transit || $result->rooms_description->notes ||
                $result->rooms_description->house_rules)

                <div class="accommodation__filters__padding__top filter">
                    <p class="t-zeta t-bold  padding__bottom__xs">
                        {{ trans('messages.lys.description') }}
                    </p>

                    @php
                    $res =$result->rooms_description->toArray();
                    $res = array_filter($res);
                    @endphp

                    <foldable>
                        @foreach ($res as $key => $value)
                        @if($key == 'space')
                        <div class="padding__bottom__xs">
                            <p><strong>{{ trans('messages.lys.the_space') }}</strong></p>
                            <p>{!! nl2br($result->rooms_description->space) !!}</p>
                        </div>
                        @endif

                        @if($key == 'access')
                        <div class="padding__bottom__xs">
                            <p><strong>{{ trans('messages.lys.guest_access') }}</strong></p>
                            <p>{!! nl2br($result->rooms_description->access) !!} </p>
                        </div>
                        @endif

                        @if($key == 'interaction')
                        <div class="padding__bottom__xs">
                            <p><strong>{{ trans('messages.lys.interaction_with_guests') }}</strong></p>
                            <p> {!! nl2br($result->rooms_description->interaction) !!}</p>
                        </div>
                        @endif
                        @if($key == 'notes')
                        <div class="padding__bottom__xs">
                            <p><strong>{{ trans('messages.lys.other_things_note') }}</strong></p>
                            <p> {!! nl2br($result->rooms_description->notes) !!}</p>
                        </div>
                        @endif
                        @if($key == 'neighborhood_overview')
                        <div class="padding__bottom__xs">
                            <p><strong>{{ trans('messages.lys.the_neighborhood') }}</strong></p>
                            <p> {!! nl2br($result->rooms_description->neighborhood_overview) !!}</p>
                        </div>
                        @endif
                        @if($key == 'transit')
                        <div>
                            <p><strong>{{ trans('messages.lys.getting_around') }}</strong></p>
                            <p>{!! nl2br($result->rooms_description->transit) !!}</p>
                        </div>
                        @endif
                        @endforeach
                    </foldable>


                </div>
                @endif

                @if($result->rooms_description->house_rules !='')
                <div class="accommodation__filters__padding__top filter padding__bottom__3">
                    <p class="t-zeta t-bold padding__top__xs padding__bottom__xs">
                        {{ trans('messages.lys.house_rules') }}
                    </p>

                    <div class="homepage__row__container ">
                        <p class="t-eta">
                            <p>{!! nl2br($result->rooms_description->house_rules) !!}</p>
                        </p>
                    </div>
                </div>
                @endif




                @if(count($safety_amenities) !=0)
                <div class="accommodation__filters__padding__top filter padding__bottom__3">
                    <h5 class="padding__top__xs padding__bottom__xs">
                        {{ trans('messages.rooms.safety_features') }}
                    </h5>
                    <div class="homepage__row__container ">
                        @foreach(collect($safety_amenities)->chunk(3) as $chunk)
                        <div class="homepage__body__flex__1">
                            @foreach($chunk as $row_safety)
                            <div class="homepage__row__container padding__top__xs">
                                <img src="/assets/Search/Check icon.svg" class="padding__right__xs" />
                                @if($row_safety->status == null)
                                <del>
                                    @endif

                                    @if(Session::get('language')=='en')
                                    {{ $row_safety->name }}
                                    @elseif($row_safety->namelang == null)
                                    {{ $row_safety->name }}
                                    @else
                                    {{ $row_safety->namelang }}
                                    @endif

                                    @if($row_safety->status == null)
                                </del>
                                @endif
                            </div>
                            @endforeach
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                @if($result->rooms_beds_count)
                <div class="accommodation__filters__padding__top filter padding__bottom__3">
                    <h5 class="padding__top__xs padding__bottom__xs">
                        {{trans('messages.rooms.sleeping_arrangements')}}
                    </h5>
                    <div>

                        <!-- UBACITI LOST GRID DA PREBACI KAD SE SUZI 2 U NOVI RED -->
                        <ul class="single-accommodation-list">

                            @foreach($result->get_first_bed_type as $room_no => $bed)
                            @if($result->searcharray('1','count', $bed) > 0)
                            <li class="single-accommodation-element__container bed-type-li-item"
                                style="display: flex; flex-direction: column; align-content: space-between">

                                <!-- ikonica od kreveta -->
                                <div class="bed-type-img bed-type-img-anchor">
                                    @foreach($bed as $bed_name)
                                    @if($bed_name['count'] > 0)
                                    @for($f=0;$f
                                    <$bed_name['count'];$f++) <img src="{{$bed_name['icon']}}" />
                                    @endfor
                                    @endif
                                    @endforeach
                                </div>
                                <div class="bed-type-info">
                                    <h5 class="bed-type-text-props">
                                        {{trans('messages.rooms.bedroom')}} {{$room_no}}
                                    </h5>
                                    @php $first=1; @endphp
                                    @foreach($bed as $bed_name)
                                    @if($bed_name['count'] > 0)
                                    <span>
                                        @if($first==0),@endif
                                        {{$bed_name['count']}}
                                        {{$bed_name['name']}}
                                        @php $first=0; @endphp
                                    </span>
                                    @endif
                                    @endforeach
                                </div>
                            </li>
                            @endif
                            @endforeach

                            @if($result->searcharray('1','count', $result->get_common_bed_type) > 0)
                            <li class="single-accommodation-element__container bed-type-li-item">

                                <!-- ikonica od kauča -->
                                <div class="bed-type-img bed-type-img-anchor">
                                    @foreach($result->get_common_bed_type as $bed_name)
                                    @if($bed_name['count'] > 0)
                                    @for($f=0;$f
                                    <$bed_name['count'];$f++) <img src="{{$bed_name['icon']}}" />
                                    @endfor
                                    @endif
                                    @endforeach
                                </div>
                                <div class="bed-type-info">
                                    <h5 class="bed-type-text-props">
                                        {{trans('messages.rooms.common_space')}}
                                    </h5>
                                    @php $first=1; @endphp
                                    @foreach($result->get_common_bed_type as $bed_name)
                                    @if($bed_name['count'] > 0)
                                    <span>
                                        @if($first==0) <span>,</span> @endif
                                        {{$bed_name['count']}} {{$bed_name['name']}}
                                        @php $first=0; @endphp
                                    </span>
                                    @endif
                                    @endforeach
                                </div>
                            </li>
                            @endif
                        </ul>
                    </div>
                </div>
                @endif


                <div class="accommodation__filters__padding__top filter padding__bottom__1">
                    <h5 class="padding__top__xs padding__bottom__xs">
                        @lang('messages.home.where_are_we')
                    </h5>

                    <div class="homepage__row__container padding__top__xs">
                        <accommodation-map :location="{{ $result->rooms_address }}" />
                    </div>

                    <!--
                        <div class="homepage__row__container ">
                            <h4>
                                {{ trans('messages.rooms.listing_location') }}
                            </h4>
                            <hr>
                            <a href="">
                                <span>{{$result->rooms_address->state}},</span>
                            </a>
                            <a href="">
                                <span>{{$result->rooms_address->country_name}}</span>
                            </a>
                        </div>
                        -->
                </div>

                @if(!$result->reviews->count())
                <div class="review-content mt-3">
                    <div class="panel-body">
                        <h5 class="padding__top__xs padding__bottom__xs">
                            {{ trans('messages.rooms.no_reviews_yet') }}
                        </h5>
                        @if($result->users->reviews->count())
                        <p>
                            {{ trans_choice('messages.rooms.review_other_properties', $result->users->reviews->count(), ['count'=>$result->users->reviews->count()]) }}
                        </p>
                        <a href="{{ url('users/show/'.$result->user_id) }}" class="btn btn-secondary mt-2">
                            {{ trans('messages.rooms.view_other_reviews') }}
                        </a>
                        @endif
                    </div>
                </div>
                @else


                <div class=" padding__bottom__3">
                    <h5 class="padding__top__xs padding__bottom__xs">
                        {{ trans_choice('messages.header.review',$result->reviews->count()) }}

                    </h5>


                    <!-- accommodation review SVE -->
                    <div class="single-accommodation-review filter">


                        <!-- MAIN = GENERAL SUMMARY naslov, zvijezda, based on -->
                        <div class="single-accomodation-review__summary single-type-rev-item">

                            <p class="t-eta"> {{ trans('messages.lys.summary') }} </p>
                            <p class="t-zeta" style="padding-top:5px; padding-bottom: 5px">
                                <img src="/assets/icon-star.svg" class="icon__20__20" />
                                {!! number_format($result->overall_star_rating['rating_value'], 1)!!}
                            </p>
                            <p class="t-iota o-60f t-primary">
                                @lang('messages.home.based')
                                {{ $result->reviews->count() }}
                                {{ trans_choice('messages.header.review',$result->reviews->count()) }}
                            </p>
                        </div>


                        <!-- reviews stars - I GRUPA = accuracy, accommodation, cleanliness -->

                        <div class="single-accommodation-review__container">
                            <div>
                                <!-- accuracy -->
                                <div class="single-accommodation-review-element__position">
                                    <div>
                                        <p class="t-theta"> {{ trans('messages.reviews.accuracy') }} </p>
                                    </div>
                                    <div>
                                        <p class="t-theta">
                                            {{-- {!! $result->accuracy_star_rating['rating_value']!!} --}}
                                            <star-rating :increment="0.01" :star-size="15" :inline="true"
                                                :read-only="true" :fixed-points="1"
                                                :rating="{!! $result->accuracy_star_rating['rating_value']!!}">
                                            </star-rating>
                                        </p>
                                    </div>
                                </div>

                                <!-- accommodation -->
                                <div class="single-accommodation-review-element__position">
                                    <div>
                                        <p class="t-theta">
                                            {{ trans('messages.reviews.communication') }}
                                        </p>
                                    </div>
                                    <div>
                                        <p class="t-theta">
                                            <star-rating :increment="0.01" :star-size="15" :inline="true"
                                                :read-only="true" :fixed-points="1"
                                                :rating="{!! $result->communication_star_rating['rating_value']!!}">
                                            </star-rating>
                                        </p>
                                    </div>
                                </div>

                                <!-- cleanliness -->
                                <div class="single-accommodation-review-element__position">
                                    <div>
                                        <p class="t-theta">
                                            {{ trans('messages.reviews.cleanliness') }}
                                        </p>
                                    </div>
                                    <div>
                                        <p class="t-theta">
                                            <star-rating :increment="0.01" :star-size="15" :inline="true"
                                                :read-only="true" :fixed-points="1"
                                                :rating="{!! $result->cleanliness_star_rating['rating_value']!!}">
                                            </star-rating>
                                        </p>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- reviews stars - II GRUPA = location, check-in, value -->
                        <div class="single-accommodation-review__container">

                            <div>
                                <!-- location -->

                                <div class="single-accommodation-review-element__position">
                                    <div>
                                        <p class="t-theta">
                                            {{ trans('messages.reviews.location') }}
                                        </p>
                                    </div>
                                    <div>
                                        <p class="t-theta">
                                            <star-rating :increment="0.01" :star-size="15" :inline="true"
                                                :read-only="true" :fixed-points="1"
                                                :rating="{!! $result->location_star_rating['rating_value']!!}">
                                            </star-rating>
                                        </p>
                                    </div>
                                </div>

                                <!-- check in -->
                                <div class="single-accommodation-review-element__position">
                                    <div>
                                        <p class="t-theta">
                                            {{ trans('messages.home.checkin') }}
                                        </p>
                                    </div>
                                    <div>
                                        <p class="t-theta">

                                            <star-rating :increment="0.01" :star-size="15" :inline="true"
                                                :read-only="true" :fixed-points="1"
                                                :rating="{!! $result->checkin_star_rating['rating_value']!!}">
                                            </star-rating>
                                        </p>
                                    </div>
                                </div>
                                <!-- value -->


                                <div class="single-accommodation-review-element__position">

                                    <div>
                                        <p class="t-theta">
                                            {{ trans('messages.reviews.value') }}
                                        </p>

                                    </div>

                                    <div>
                                        <p class="t-theta">
                                            <star-rating :increment="0.01" :star-size="15" :inline="true"
                                                :read-only="true" :fixed-points="1"
                                                :rating="{!! $result->value_star_rating['rating_value']!!}">
                                            </star-rating>
                                        </p>


                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!--  written review start-->
                    <foldable>
                        @foreach($result->reviews as $row_review)
                        <div class="padding__bottom__custom" id="{{ $row_review->id }}">
                            <div class="homepage__row__container filterB space__between padding__top__custom">
                                <div>
                                    <p class="t-primary lato "> {{ $row_review->users_from->first_name }}</p>
                                </div>

                                <div class="grade__group">
                                    <p class="t-iota">
                                        {{ \Carbon\Carbon::parse($row_review->date_fy)->diffForHumans() }}
                                        <img src="/assets/icon-star.svg" style="padding-bottom: 3px" />
                                        {!! $row_review->rating !!}

                                    </p>
                                </div>
                            </div>
                            <div class="homepage__row__container padding__top__xs">
                                <p class="t-theta">{{ $row_review->comments }}</p>
                            </div>
                        </div>
                        @endforeach
                        <!--  written review end-->


                        <!-- Show All Reviews-->
                    </foldable>

                </div>
                @endif


            </section>
        </div>
    </div>


    <div class="wrapper margin__bottom__30 overflow__hidden">
        <div class="padding-top-bottom--5-4">
            <h3 class="single-carousel-title padding-bottom--1">@lang('messages.rooms.similar_places')</h3>




            <div>
                <sac-carousel>

                    @foreach(collect($similar)->take(3) as $room)
                    <div class="pts-element" style="min-width: 273px">

                        <div>
                            <a href="{{ route('accommodation.single', $room) }}" target="_blank">
                                <img class="border-radius--12 places-img__size" src="{{ $room->photo_name }}" />
                            </a>
                        </div>
                        <div class="homepage__row__container space__between padding-top--1">
                           
                            <p>From {{ number_format($room->popup_price, 2) }}
                                € {{--/ Per Night--}}</p>

                            @if ($room->reviews_count != 0)
                            <p class="review-grade">
                                {{ number_format($room->overall_star_rating['rating_value'], 1) }}
                                ({{ $room['reviews_count']}})</p>

                            @else
                            <p class="review-grade">0(0)</p>
                            @endif

                        </div>
                        <p class="homepage-element__subtitle">{{ $room->name }}
                            {{--{{ $room->sub_name }}--}}</p>

                    </div>







                    @endforeach
                </sac-carousel>
            </div>


        </div>
    </div>


    {{--

    <div class="homepage-lost white-bg" style="max-width: 230px;">
        <div class=" lost-column--1 registerww__column" style="height: 200px;">


                <h2 class="text__align error-main-msg__404 o-80 " style="font-size: 18px ">
                    error msg
                </h2>


        </div>
    </div> --}}

    <book-now-modal screen="mobile">

        <price-calculator :result="{{ $result }}" formatted_checkin="{{ $formatted_checkin }}"
            formatted_checkout="{{ $formatted_checkout }}" checkin="{{ $checkin }}" checkout="{{ $checkout }}"
            guests="{{  request()->guests }}" token="{{ csrf_token() }}" screen="mobile" />
        </price-calculator>
    </book-now-modal>


</div>

@stop

@extends('rogoznica.layout.master')
@section('content')
<div>
  <!-- Background in accommodation.css -->
  <!-- Background in serviceandactivities.css -->
  <div class="payment-hero">
    @include('rogoznica.includes.header')
    <div class="wrapper payment-header__props">
      <h1 class="payment-header__title accommodation__header__title">
        {{ trans('messages.payments.booking_information') }}
       
      </h1>
    </div>
  </div>
</div>

    <!-- PAGE CONTENT (TWO COLUMNS) -->
<div class="wrapper white-bg margin__bottom__30 overflow__hidden">
  {{ Form::open(array('url' => $form_url, 'method' => 'post','id'=>'checkout-form')) }} 
  <div class="accommodation">
    <!-- aside
                staviti da aside zauzima određeni dio prostora
            i da ovaj drugi isto zauzima određeni dio prostora sa lost
        i onda gurnut između-->

    <aside class="accommodation__filters padding__top__1 aside-to-hide">
      <div class="img_show">
        <image src="https://adriana.travel/assets/boatcube.jpg"></image>
      </div>
      <div class="checkin_show">
        <h5> @lang('messages.rooms.Checkin_Date'): <span> {{ $checkin}}  </span></h5>
      </div>
      <div class="guest_show">  
        <h5> @lang('messages.rooms.head') : <span> {{ $number_of_guests}}  </span> </h5> 
      </div>
      <div class="price_show">
      @if($half_day_price!= "-")  <h5> @lang('messages.rooms.Half_day_price'): <span> {{ $half_day_price}} €</span> </h5>@endif
      @if($full_day_price!="-")  <h5> @lang('messages.rooms.full_day_price'): <span> {{ $full_day_price}} €</span></h5>@endif
      </div>
      <div class="total_show">  
        <h5> {{ trans('messages.rooms.total') }} : <span> {{ $total}} €  </span> </h5>
      </div>
  
              
                <!-- Filter open/close. On click ".filter--header" should toggle class ".active" on itself and ".filter__holder". Should be incorporated with smooth js open -->
                <div class="filter__holder aside__padding--top" v-sticky sticky-offset="{top: 0, bottom: 100}">
                



                    <div>
                        <!-- policies -->
                      

                            
                       



                            <!-- <li>

                                    <div class="homepage__row__container space__between">
                                        <p class="t-eta">
                                            <input class="flex-grow-1 coupon-code-field" autocomplete="off"
                                                   name="coupon_code" type="text" value="">
                                            <a href="javascript:void(0);" id="apply-coupon"
                                               class="btn btn-sm btn-primary apply-coupon ml-3">
                                                {{ trans('messages.payments.apply') }}
                                    </a>
                                </p>
                                <p class="t-eta t-bold">
                                <div class="cancel-coupon">
                                    <a href="javascript:void(0);" class="theme-link">
{{ trans('messages.your_reservations.cancel') }}
                                    </a>
                                </div>
                                </p>
                            </div>
                        </li> -->

                        </ul>

                      

                        <!-- popusti
                            <ul class="list__props filter color_000 o-80 padding__bottom__custom">
                                <li>
                                    <div class="homepage__row__container space__between">
                                        <p class="t-eta red__class">
                                            {{ trans('messages.payments.apply') }}
                                </p>
                            </div>
                        </li>
                    </ul>-->


                    </div>

                </div>
            </aside>


            <section class="  accommodation__list__wrapper   payment-padding-bottom-3 padding__top__custom">
                <!--PAYMENT-->
                <div class="accommodation__filters__padding__top filter">


                    <div class="filter">


                        @if(Session::has('message'))
                        <div class="alert {{ Session::get('alert-class') }} text-center" role="alert"
                            style="color: red">
                            {{ Session::get('message') }}
                        </div>
                        @endif


                        <h3> {{ trans('messages.payments.billing_info') }}</h3>


                        <!-- INPUT PART -->
                        <div class="lost-payment padding__top">


                            <div class="field lost-payment-input-2">
                                <label for="input" class="field__lbl">@lang('messages.login.first_name')</label>
                                {!! Form::text('first_name', '', ['class' => $errors->has('first_name') ? 'input
                                input--text input--text--error' : 'input input--text focus', 'id' => 'input',
                                'placeholder' =>
                                trans('messages.login.first_name')])!!}


                                @error('first_name')
                                <span class="payment-error-msg">{{ $message }}</span>
                                @enderror

                            </div>

                            <div class="field lost-payment-input-2">
                                <label for="input" class="field__lbl">@lang('messages.login.last_name')</label>
                                {!! Form::text('last_name', '', ['class' => $errors->has('last_name') ? 'input
                                input--text input--text--error' : 'input input--text focus', 'id' => 'input',
                                'placeholder' =>
                                trans('messages.login.last_name')])!!}

                                @error('last_name')
                                <span class="payment-error-msg">{{ $message }}</span>
                                @enderror
                            </div>


                            <div class="field lost-payment-input-2">
                                <label for="input" class="field__lbl">@lang('messages.login.email')</label>
                                {!! Form::email('email', '', ['class' => $errors->has('email') ? 'input
                                input--text input--text--error' : 'input input--text focus', 'id'=> 'input',
                                'placeholder' =>
                                trans('messages.login.email')])!!}

                                @error('email')
                                <span class="payment-error-msg">{{ $message }}</span>
                                @enderror
                            </div>


                            <div class="field lost-payment-input-2">
                                <label for="input" class="field__lbl">@lang('messages.login.password')</label>
                                {!! Form::password('password', ['class' => $errors->has('password') ? 'input
                                input--text input--text--error' : 'input input--text focus', 'id' => 'input',
                                'placeholder' => trans('messages.login.password')])!!}

                                @error('password')
                                <span class="payment-error-msg">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="field lost-payment-input-2">
                                <label for="input" class="field__lbl">@lang('messages.profile.phone_number')</label>
                                {!! Form::number('phone', '', ['class' => $errors->has('phone') ? 'input
                                input--text input--text--error' : 'input input--text focus', 'id'=> 'input',
                                'placeholder' =>
                                trans('messages.profile.phone_number')])!!}

                                @error('phone')
                                <span class="payment-error-msg">{{ $message }}</span>
                                @enderror
                            </div>


                            <div class="field lost-payment-input-2">
                                <label for="input" class="field__lbl">@lang('messages.profile.zip_code')</label>
                                {!! Form::text('zip', '', ['class' => $errors->has('zip') ? 'input
                                input--text input--text--error' : 'input input--text focus', 'id'=> 'input',
                                'placeholder' =>
                                trans('messages.lys.zip_postal_code')])!!}

                                @error('zip')
                                <span class="payment-error-msg">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="field lost-payment-input-2">
                                <label for="input" class="field__lbl">@lang('messages.account.country')</label>
                                @if(Session::get('payment_country'))
                                {!! Form::select('payment_country', $country,
                                Session::get('mobile_payment_counry_code'), ['id' => 'country-select', 'class' =>
                                'custom-select font__small__14']) !!}
                                @else
                                {!! Form::select('payment_country', $country, $default_country_code, ['id' =>
                                'country-select', 'class' => 'custom-select font__small__14']) !!}
                                @endif
                                @error('payment_country')
                                <span class="payment-error-msg">{{ $message }}</span>
                                @enderror
                            </div>


                            <div class="field lost-payment-input-2">
                                <label for="input" class="field__lbl">@lang('messages.account.city')</label>
                                {!! Form::text('city', '', ['class' => $errors->has('city') ? 'input
                                input--text input--text--error' : 'input input--text focus', 'id'=> 'input',
                                'placeholder' =>
                                trans('messages.account.city')])!!}

                                @error('city')
                                <span class="payment-error-msg">{{ $message }}</span>
                                @enderror
                            </div>



                            <div class="field lost-payment-input-2">
                                <label for="input" class="field__lbl">@lang('messages.account.address')</label>
                                {!! Form::text('address', '', ['class' => $errors->has('address') ? 'input
                                input--text input--text--error' : 'input input--text focus', 'id'=> 'input',
                                'placeholder' =>
                                trans('messages.account.address')])!!}

                                @error('address')
                                <span class="payment-error-msg">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="field lost-payment-input-2">
                                <label for="input" class="field__lbl">@lang('messages.account.date_birth')</label>
                                <div class="lost-payment padding__bottom__1">
                                    <div class="lost-payment-input-3">
                                        {!! Form::selectMonthWithDefault('birthday_month', null,
                                        trans('messages.header.month'), [ 'class' => $errors->has('birthday_month') ?
                                        'invalid custom-select font__small__14 custom--select--error font__small__err' :
                                        'custom-select
                                        font__small__14', 'id'
                                        => 'user_birthday_month']) !!}
                                        @error('birthday_month')
                                        <span class="payment-error-msg">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="lost-payment-input-3">
                                        {!! Form::selectRangeWithDefault('birthday_day', 1, 31, null,
                                        trans('messages.header.day'), [ 'class' => $errors->has('birthday_day') ?
                                        'invalid custom-select font__small__14 custom--select--error font__small__err' :
                                        ' custom-select
                                        font__small__14', 'id'
                                        => 'user_birthday_day']) !!}
                                        @error('birthday_day')
                                        <span class="payment-error-msg">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="lost-payment-input-3">
                                        {!! Form::selectRangeWithDefault('birthday_year', date('Y'), date('Y')-120,
                                        null, trans('messages.header.year'), [ 'class' => $errors->has('birthday_year')
                                        ? 'invalid custom-select font__small__14 custom--select--error font__small__err'
                                        :
                                        'custom-select
                                        font__small__14',
                                        'id' => 'user_birthday_year']) !!}
                                        @error('birthday_year')
                                        <span class="payment-error-msg">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    @error('minor')
                                    <span class="payment-error-msg">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                        </div>

                        <!-- INPUT PART END -->



                    </div>


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


                    <div class="paymany-chat__wrapper">
                        <label for="input" class="field__lbl">@lang('messages.dashboard.message_sing')</label>
                        <div class="lost-payment lost-align--center">
                            <div class="lost-payment__textarea-container">
                                <div>
                                    <textarea class="text-area font__small__14" name="msg"
                                        placeholder="Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit"
                                        rows="4" style="width: 100%; padding-bottom: 5px"></textarea>
                                </div>
                            </div>
                            <div class="lost-payment__image-container">
                                <img src="/assets/images/iconPerson.jpg" />
                            </div>
                        </div>
                    </div>

                </div>

                <!-- ovdje ubaciti aside za mobile -->


                <aside class="accommodation__filters padding__top__1 aside-to-show">
                    <h3> {{ trans('messages.payments.billing_details') }}</h3>
                    {{-- <div style="width: 100%; height: 100%; display: flex; justify-content: flex-start">
                        <div style="border-radius: 12px; overflow: hidden">
                    {!! Html::image($result->photo_name, $result->name, ['class' => 'img-fluid']) !!}
                        </div>
                    </div> --}}
                    <!-- Filter open/close. On click ".filter--header" should toggle class ".active" on itself and ".filter__holder". Should be incorporated with smooth js open -->
                    <div class="aside__padding--top" sticky-offset="{top: 0, bottom: 100}">
                        <div class="filter">
                            <h4 class="filter__title--dark-blue padding__bottom__xs">
                             
                            </h4>
                            <p class="t-theta">
                              
                            </p>
                        </div>

                        <div class="filter">
                            <p class="aside__text--dark-blue o-60 padding__bottom__2xs">
                            </p>
                            <p class="t-bold">
                                {{ date($php_format_date, strtotime($checkin)) }}
                                {{ trans('messages.payments.to') }}
                                {{ date($php_format_date, strtotime($checkout)) }}
                            </p>
                        </div>


                        <div>
                            <!-- policies -->
                            <ul class="list__props filter color_000 o-80 padding__bottom__custom">
                                <li>
                                   
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
                                        <p class="t-eta t-bold">{{ $nights }}</p>
                                    </div>
                                </li>
                            </ul>


                            <p class="t-theta o-60">@lang('messages.your_reservations.fee')</p>
                            <ul class="list__props filter color_000 o-80 padding__bottom__custom">

                                <li>
                                    <!-- remove red__class from both <p> for regular font color-->
                                    <div class="homepage__row__container space__between">
                                        <p class="t-eta">

                                           
                                            <i id="service-fee-tooltip" rel="tooltip"
                                                title="{{ trans('messages.rooms.avg_night_rate') }}">
                                            </i>
                                        </p>
                                        <p class="t-eta t-bold">
                                            <span>
                                                
                                            </span>

                                            <span>
                                               
                                            </span>
                                        </p>
                                    </div>
                                </li>
                               
                                <li>
                                    <!-- remove red__class from both <p> for regular font color-->
                                    <div class="homepage__row__container space__between">
                                        <p class="t-eta">
                                          
                                        </p>
                                        <p class="t-eta t-bold">
                                            -
                                            <span>
                                              
                                            </span>
                                            <span>
                                               
                                            </span>
                                        </p>
                                    </div>
                                </li>
                                

                               
                                <li>
                                    <!-- remove red__class from both <p> for regular font color-->
                                    <div class="homepage__row__container space__between">
                                        <p class="t-eta">
                                            
                                        </p>
                                        <p class="t-eta t-bold">
                                            -

                                            <span>
                                               
                                            </span>

                                            <span>
                                               
                                            </span>
                                        </p>
                                    </div>
                                </li>
                        

                               
                                <li>
                                    <!-- remove red__class from both <p> for regular font color-->
                                    <div class="homepage__row__container space__between">
                                        <p class="t-eta">
                                            {{ trans('messages.rooms.service_fee') }}
                                        </p>
                                        <p class="t-eta t-bold">

                                            <span>
                                               
                                            </span>

                                            <span>
                                               
                                            </span>
                                        </p>
                                    </div>
                                </li>
                            


                               
                                @if(@$special_offer_id == '' || @$special_offer_type == 'pre-approval' )
                                <li>
                                    <!-- remove red__class from both <p> for regular font color-->
                                    <div class="homepage__row__container space__between">
                                        <p class="t-eta">
                                            {{ trans('messages.rooms.addtional_guest_fee') }}

                                        </p>
                                        <p class="t-eta t-bold">

                                            <span>
                                                
                                            </span>
                                            <span>
                                                
                                            </span>
                                        </p>
                                    </div>
                                </li>
                                @endif
                            


                               
                                @if(@$special_offer_id =='' || @$special_offer_type == 'pre-approval')
                                <li>
                                    <!-- remove red__class from both <p> for regular font color-->
                                    <div class="homepage__row__container space__between">
                                        <p class="t-eta">
                                            {{ trans('messages.lys.cleaning') }}

                                        </p>
                                        <p class="t-eta t-bold">

                                            <span>
                                                
                                            </span>
                                            <span>
                                               
                                            </span>
                                        </p>
                                    </div>
                                </li>
                                @endif
                            




                                <!-- <li>

                        <div class="homepage__row__container space__between">
                            <p class="t-eta">
                                <input class="flex-grow-1 coupon-code-field" autocomplete="off"
                                       name="coupon_code" type="text" value="">
                                <a href="javascript:void(0);" id="apply-coupon"
                                   class="btn btn-sm btn-primary apply-coupon ml-3">
                                    {{ trans('messages.payments.apply') }}
                                        </a>
                                    </p>
                                    <p class="t-eta t-bold">
                                    <div class="cancel-coupon">
                                        <a href="javascript:void(0);" class="theme-link">
{{ trans('messages.your_reservations.cancel') }}
                                        </a>
                                    </div>
                                    </p>
                                </div>
                            </li> -->

                            </ul>

                           
                            <!-- popusti
                <ul class="list__props filter color_000 o-80 padding__bottom__custom">
                    <li>
                        <div class="homepage__row__container space__between">
                            <p class="t-eta red__class">
                                {{ trans('messages.payments.apply') }}
                                    </p>
                                </div>
                            </li>
                        </ul>-->


                        </div>

                    </div>
                </aside>


                <!-- iznad stoji aside za mobile -->

                <div class="accommodation__filters__padding__top filter padding__bottom__2 padding__top__1">
                    <div class="homepage__row__container checkbox-container">
                        <input class="initial-checkbox" id="gdpr" style="margin-top: 2px;" type="checkbox"
                            name="gdpr" />
                        <label for="gdpr" class="text__footnote o-60 padding__left__10xs" @error('gdpr')
                            style="color: red; opacity: 100%" @enderror>

                            {{ trans('messages.home.by_clicking') }}
                            <a href="/terms_of_service" target="_blank">
                                {{ trans('messages.home.terms') }}</a>
                            {{ trans('messages.home.and') }}
                            <a href="/privacy_policy" target="_blank">
                                {{ trans('messages.home.privacy') }}</a>
                        </label>

                    </div>
                </div>

                <!--
                    <div class="lost-payment padding__top__1">
                        <div class="lost-payment-container"><p class="font__medium__16__blue">Forgot password?</p></div>
                       <div class="lost-payment-container"> <p>
                            Already registered?
                            <span class="rogoznica__blue__forms o-80">Sign in!</span>
                        </p></div>
                    </div>
                -->


                <!-- BUTTONS -->


                <div class="lost-payment padding__top__3">
                    <!--      <div class="payment-btn-placeholder"></div> -->
                    <div class="payment-btn-container-spacer">
                    </div>
                    <div class="payment-btn-container">


                        {{-- <button class="btn btn--secondary payment-btn-props payment-btn-font">Continue as guest
                            </button> --}}
                        <button type="submit " id="payment-form-submit"
                            class="btn btn--primary payment-btn-props btn-mrgn-lft payment-btn-font">

                            {{ ($booking_type == 'instant_book') ? ($price_list->total == '0') ? trans('messages.lys.continue') : trans('messages.payments.book_now') : trans('messages.payments.book_now') }}
                        </button>
                    </div>
                </div>

                <!-- BTNS END -->

                <div class="container">

                    <input name="room_id" type="hidden" value="{{ $room_id }}">
                    <input name="checkin" type="hidden" value="{{ $checkin }}">
                    <input name="special_offer_id" type="hidden" value="{{ $special_offer_id }}">
                    <input name="checkout" type="hidden" value="{{ $checkout }}">
                    <input name="number_of_guests" type="hidden" value="{{ $number_of_guests }}">
                    <input name="half_day_price" type="hidden" value="{{ $half_day_price }}">
                    <input name="full_day_price" type="hidden" value="{{ $full_day_price }}">
                    <input name="total" type="hidden" value="{{ $total }}">
                    <input name="boat_type" type="hidden" value="{{ $boat_type }}">

                   
                    <input name="nights" type="hidden" value="{{ $nights }}">
                    <input type="hidden" name="payment_intent_id" id="payment_intent_id">
                    <input name="cancellation" type="hidden" value="{{ $cancellation }}">
                   
                    <input name="session_key" type="hidden" value="{{ $s_key }}">
                    <input name="guest_token" type="hidden" value="{{ Session::get('get_token') }}">
                    <input name="payment_country" type="hidden"
                        value="{{ Session::has('mobile_payment_counry_code') ? Session::get('mobile_payment_counry_code') : 'HR' }}">
                    <input name="payment_type" type="hidden"
                        value="{{ Session::has('mobile_payment_counry_code') ? Session::get('mobile_payment_counry_code') : 'HR' }}">
                    <input name="payment_method" type="hidden" value="wspay">


                    <div class="payment-wrap py-4 py-md-5 d-flex flex-wrap flex-column-reverse flex-md-row">
                        <div class="col-md-7 mt-4 mt-md-0 position-sticky">

    
    
                            <div class="alert alert-with-icon alert-error alert-block d-none" id="form-errors"
                                style="display: none">
                                <i class="icon alert-icon icon-alert-alt"></i>
                                <div class="error-header">
                                    {{ trans('messages.payments.almost_done') }}!
                                </div>
                            </div>


                            {{--                                <div class="checkout-info">--}}
                            {{--                                    <h2>--}}
                            {{--                                        {{ trans('messages.payments.tell_about_your_trip',['first_name'=>$result->users->first_name]) }}--}}
                            {{--                                    </h2>--}}
                            {{--                                    <p>--}}
                            {{--                                        {{ trans('messages.payments.helful_trips') }}:--}}
                            {{--                                    </p>--}}
                            {{--                                    <ul class="my-3 disc-type">--}}
                            {{--                                        <li>--}}
                            {{--                                            {{ trans('messages.rooms.what_brings_you',['city'=>$result->rooms_address->city]) }}--}}
                            {{--                                        </li>--}}
                            {{--                                        <li>--}}
                            {{--                                            {{ trans('messages.payments.checkin_plans') }}--}}
                            {{--                                        </li>--}}
                            {{--                                        <li>--}}
                            {{--                                            {{ trans('messages.payments.ask_recommendations') }}--}}
                            {{--                                        </li>--}}
                            {{--                                    </ul>--}}

                            {{--                                    <div class="chat-container mt-4">--}}
                            {{--                                        <div class="chat-row d-flex">--}}
                            {{--                                            <div class="user-img">--}}
                            {{--                                                @if(Session::get('get_token')=='')--}}
                            {{--                                                    <a href="{{ url('users/show/'.$result->user_id) }}">--}}
                            {{--                                                        <img alt="User Profile Image" data-pin-nopin="true" src="{{ $result->users->profile_picture->src }}"
                            title="{{ $result->users->first_name }}">--}}
                            {{--                                                    </a>--}}
                            {{--                                                @else--}}
                            {{--                                                    <a href="javascript:void(0);">--}}
                            {{--                                                        <img alt="User Profile Image" data-pin-nopin="true" src="{{ $result->users->profile_picture->src }}"
                            title="{{ $result->users->first_name }}">--}}
                            {{--                                                    </a>--}}
                            {{--                                                @endif--}}
                            {{--                                            </div>--}}
                            {{--                                            <div class="chat-box ml-4 flex-grow-1 panel-dark arrow-left">--}}
                            {{--                                                <p>--}}
                            {{--                                                    @if($result->booking_message)--}}
                            {{--                                                        {{ $result->booking_message }}--}}
                            {{--                                                    @else--}}
                            {{--                                                        {{ trans('messages.payments.welcome_to_city',['city'=>$result->rooms_address->city]) }}--}}
                            {{--                                                    @endif--}}
                            {{--                                                </p>--}}
                            {{--                                            </div>--}}
                            {{--                                        </div>--}}

                            {{--                                        <div class="chat-row d-flex">--}}
                            {{--                                            <div class="user-img">--}}
                            {{--                                                @if(Session::get('get_token')!='')--}}
                            {{--                                                    <a href="javascript:void(0);">--}}
                            {{--                                                        <img alt="User Profile Image" class="" data-pin-nopin="true" src="{{ @Session::get('payment')[$s_key]['mobile_user_image'] }}"
                            title="">--}}
                            {{--                                                    </a>--}}
                            {{--                                                @else--}}
                            {{--                                                    <a href="{{ url('users/show/'.Auth::user()->id) }}">--}}
                            {{--                                                        <img alt="User Profile Image" class="" data-pin-nopin="true" src="{{ Auth::user()->profile_picture->src }}"
                            title="{{ Auth::user()->first_name }}">--}}
                            {{--                                                    </a>--}}
                            {{--                                                @endif--}}
                            {{--                                            </div>--}}
                            {{--                                            <div class="chat-box ml-4 flex-grow-1 arrow-left">--}}
                            {{--                                                <label for="message-to-host-input" class="screen-reader-only">--}}
                            {{--                                                    {{ trans('messages.payments.message_your_host') }}...--}}
                            {{--                                                </label>--}}
                            {{--                                                <!--payment_message_to_host set for Api start -->--}}
                            {{--                                                <textarea id="message-to-host-input" name="message_to_host" rows="3" class="message-to-host-quote-input" placeholder="{{ trans('messages.payments.message_your_host') }}...">@if(@Session::get('payment')[$s_key]['payment_message_to_host']){{ @Session::get('payment')[$s_key]['payment_message_to_host'] }}
                            @endif</textarea>--}}
                            {{--                                                <!--payment_message_to_host set for Api stop -->--}}
                            {{--                                            </div>--}}
                            {{--                                        </div>--}}
                            {{--                                    </div>--}}

                            {{--                                    <div id="house-rules-agreement" class="checkout-rule-info">--}}
                            {{--                                        <h2>--}}
                            {{--                                            {{ trans('messages.lys.house_rules') }}--}}
                            {{--                                        </h2>--}}
                            {{--                                        <p>--}}
                            {{--                                            {{ trans('messages.payments.by_booking_this_space',['first_name'=>$result->users->first_name]) }}.--}}
                            {{--                                        </p>--}}
                            {{--                                        <div class="row-space-2">--}}
                            {{--                                            <div class="expandable expandable-trigger-more house-rules-panel-body expanded">--}}
                            {{--                                                <div class="expandable-content" data-threshold="50">--}}
                            {{--                                                    <p>{{ $result->rooms_description->house_rules }}
                            </p>--}}
                            {{--                                                    <div class="expandable-indicator"></div>--}}
                            {{--                                                </div>--}}
                            {{--                                            </div>--}}
                            {{--                                        </div>--}}
                            {{--                                    </div>--}}

                            {{--                                    <div id="policies" class="policies">--}}
                            {{--                                        <label for="agrees-to-terms">--}}
                            {{--                                            {{ trans('messages.payments.by_clicking',['booking_type'=>($booking_type == 'instant_book') ? ($price_list->total == '0') ? trans('messages.lys.continue') : trans('messages.payments.book_now') : trans('messages.lys.continue')]) }}--}}
                            {{--                                            @foreach($company_pages as $company_page)--}}
                            {{--                                                @if($company_page->name=='Terms of Service')--}}
                            {{--                                                    <a href="{{ url('terms_of_service') }}"
                            class="terms_link theme-link"
                            target="_blank">{{ trans('messages.login.terms_service') }}</a>,--}}
                            {{--                                                @endif--}}
                            {{--                                                @if($company_page->name=='Guest Refund')--}}
                            {{--                                                    <a href="{{ url('guest_refund') }}"
                            class="refund_policy_link theme-link"
                            target="_blank">{{ trans('messages.login.guest_policy') }}</a>,--}}
                            {{--                                                @endif--}}
                            {{--                                            @endforeach--}}

                            
                            {{--                                            <a href="#house-rules-agreement" class="house-rules-link theme-link">--}}
                            {{--                                                {{ trans('messages.lys.house_rules') }}--}}
                            {{--                                            </a>,--}}
                            {{--                                            <a href="{{ url('home/cancellation_policies#flexible') }}"
                            class="cancel-policy-link theme-link" target="_blank">--}}
                            {{--                                                {{ trans('messages.payments.cancellation_policy') }}--}}
                            {{--                                            </a>--}}
                            {{--                                        </label>--}}
                            {{--                                    </div>--}}
                            {{--                                    <button type="submit " id="payment-form-submit" class="btn btn-large btn-primary">--}}
                            {{--                                        {{ ($booking_type == 'instant_book') ? ($price_list->total == '0') ? trans('messages.lys.continue') : trans('messages.payments.book_now') : trans('messages.lys.continue') }}--}}
                            {{--                                    </button>--}}
                            {{--                                    <p class="book-now-explanation default"></p>--}}
                            {{--                                    <p class="book-now-explanation immediate_charge d-none">--}}
                            {{--                                        {{ trans('messages.payments.clicking') }}--}}
                            {{--                                        <strong>--}}
                            {{--                                            {{ trans('messages.lys.continue') }}--}}
                            {{--                                        </strong>--}}
                            {{--                                        {{ trans('messages.payments.charge_your_payment') }}--}}
                            {{--                                    </p>--}}
                            {{--                                    <p class="book-now-explanation deferred_payment d-none">--}}
                            {{--                                        {{ trans('messages.payments.host_will_reply') }}--}}
                            {{--                                    </p>--}}
                            {{--                                </div>--}}
                        </div>

                        {{--  <div class="col-md-5 position-sticky">
                                  <div class="payment_list_right">
                                      <div class="payments-listing-image">
                                          {!! Html::image($result->photo_name, $result->name, ['class' => 'img-fluid']) !!}
                                      </div>
                                      <div id="your-trip" class="hosting-info">
                                          <div class="payments-listing-name">
                                              <h3>
                                                  {{ $result->name }}
                        </h3>
                        <p>
                            @if($result->rooms_address->city !='') {{ $result->rooms_address->city }} , @endif
                            @if($result->rooms_address->state !=''){{ $result->rooms_address->state }} @endif
                            @if($result->rooms_address->country_name !='') , {{  $result->rooms_address->country_name }}
                            @endif
                        </p>
                    </div>
                    <div class="room-info mt-3 pt-3">
                        <p>
                            <strong>
                                {{ $result->room_type_name }}
                            </strong>
                            {{ trans('messages.payments.for') }}
                            <strong>
                                {{ $number_of_guests }} {{ trans_choice('messages.home.guest',$number_of_guests) }}
                            </strong>
                        </p>
                        <p>
                            <strong>
                                {{ date($php_format_date, strtotime($checkin)) }}
                            </strong>
                            {{ trans('messages.payments.to') }}
                            <strong>
                                {{ date($php_format_date, strtotime($checkout)) }}
                            </strong>
                        </p>
                    </div>

                    <div class="reso-info-table mt-3 pt-3">
                        <ul class="row">
                            --}}{{--    <li>
                                                      <div class="col-6">
                                                          {{ trans('messages.payments.cancellation_policy') }}
                    </div>
                    <div class="col-6">
                        @if($reservation_id!='')
                        <a href="{{ url('home/cancellation_policies#').strtolower($cancellation) }}" class="theme-link"
                            target="_blank">
                            {{trans('messages.cancellation_policy.'.strtolower($cancellation))}}
                        </a>
                        @else
                        <a href="{{ url('home/cancellation_policies#').strtolower($result->cancel_policy) }}"
                            class="theme-link" target="_blank">
                            {{trans('messages.cancellation_policy.'.strtolower($result->cancel_policy))}}
                        </a>
                        @endif
                    </div>
                    </li>
                    <li>
                        <div class="col-6">
                            {{ trans('messages.lys.house_rules') }}
                        </div>
                        <div class="col-6">
                            <a href="#house-rules-agreement" class="theme-link">
                                {{ trans('messages.payments.read_policy') }}
                            </a>
                        </div>
                    </li>
                    --}}{{--

                                              </ul>
                                          </div>
                                          --}}{{--   <div id="billing-summary" class="billing-summary mt-3 pt-3">
                                                          <div class="tooltip tooltip-top-middle taxes-breakdown" role="tooltip" data-sticky="true" data-trigger="#tax-tooltip" aria-hidden="true">
                                                              <div class="panel-body">
                                                                  <ul>
                                                                      <li>
                                                                          <td colspan="2"></td>
                                                                      </li>
                                                                  </ul>
                                                              </div>
                                                          </div>
                                                          <div class="tooltip tooltip-top-middle makent-credit-breakdown" role="tooltip" data-sticky="true" data-trigger="#makent-credit-tooltip" aria-hidden="true">
                                                              <div class="panel-body">
                                                                  <div class="makent-credit-breakdown">
                                                                  </div>
                                                              </div>
                                                          </div>
                                                        
                
                </li>

                <li class="editable-fields col-12 flex-wrap" id="after_apply">
                    <div class="coupon-input mt-2 d-none w-100">
                        <input class="flex-grow-1 coupon-code-field" autocomplete="off" name="coupon_code" type="text"
                            value="">
                        <a href="javascript:void(0);" id="apply-coupon"
                            class="btn btn-sm btn-primary apply-coupon ml-3">
                            {{ trans('messages.payments.apply') }}
                        </a>
                    </div>

                  
                </li>

                @if($reservation_id!='' || $booking_type == 'instant_book')
                <li class="coupon">
                    <div class="col-7">
                        <span class="without-applied-coupon">
                            <span class="coupon-section-link" id="after_apply_coupon"
                                style="{{ (Session::has('coupon_amount')) ? 'display:block;' : 'display:none;' }}">
                                @if($travel_credit !=0 && Session::get('coupon_code') == 'Travel_Credit')
                                {{ trans('messages.referrals.travel_credit') }}
                                @else
                                {{ trans('messages.payments.coupon') }}
                                @endif
                            </span>
                        </span>
                        <span class="without-applied-coupon" id="restrict_apply">
                            <a href="javascript:;" class="open-coupon-section-link theme-link"
                                style="{{ (Session::has('coupon_amount')) ? 'display:none;' : 'display:block;' }}">
                                {{ trans('messages.payments.coupon_code') }}
                            </a>
                        </span>
                    </div>
                    <div class="col-5 text-right">
                        <div class="without-applied-coupon label label-success" id="after_apply_amount"
                            style="{{ (Session::has('coupon_amount')) ? 'display:block;' : 'display:none;' }}">
                            -{{ html_string($result->rooms_price->currency->symbol) }}
                            <span id="applied_coupen_amount">
                                {{ $price_list->coupon_amount }}
                            </span>
                        </div>
                    </div>
                </li>

                <li id="after_apply_remove" style="{{ (Session::has('coupon_amount')) ? '' : 'display:none;' }}">
                    <div class="col-12">
                        <a data-prevent-default="true" href="javascript:void(0);" id="remove_coupon" class="theme-link">
                            <span>
                                @if($travel_credit !=0 && Session::get('coupon_code') == 'Travel_Credit')
                                {{ trans('messages.referrals.remove_travel_credit') }}
                                @else
                                {{ trans('messages.payments.remove_coupon') }}
                                @endif
                            </span>
                        </a>
                    </div>
                </li>
                @endif
                </ul>
        </div>


      
        <div class="panel-travel_credit-full">
            <span class="label label-success">
                @if(Session::get('coupon_code') == 'Travel_Credit')
                {{ trans('messages.payments.continue_with_travel_credit') }}
                @else
                {{ trans('messages.payments.continue_with_coupon_code') }}
                @endif
            </span>
        </div>
       
    </div>

    <div class="panel-total-charge mt-3 pt-3">
        <span id="currency-total-charge" class="">
            {{ trans('messages.payments.you_are_paying_in') }}
            <strong>
                <span id="payment-currency">
                    {{html_string(PAYPAL_CURRENCY_SYMBOL)}}{{PAYPAL_CURRENCY_CODE}}
                </span>
            </strong>.
            {{ trans('messages.payments.total_charge_is') }}
            <strong>
                <span id="payment-total-charge">
                    {{html_string(PAYPAL_CURRENCY_SYMBOL)}}{{ $paypal_price }}
                </span>
            </strong>.
        </span>
        <span id="fx-messaging">
            {!! trans('messages.payments.exchange_rate_booking',['symbol'=>html_string(PAYPAL_CURRENCY_SYMBOL)]) !!}
            {{ html_string($result->rooms_price->currency->original_symbol) }}{{ $paypal_price_rate }}
            {{ $result->rooms_price->currency_code }} ({{ trans('messages.payments.host_listing_currency') }}).
        </span>
    </div>
    --}}{{--
                                      </div>
                                  </div>
                              </div>--}}


</div>

</div>


</section>
</div>
{!! Form::close() !!}

</div>

</div>
@push('scripts')
<script type="text/javascript">
    window.dataLayer.push({
            'event': 'checkout',
            'roomId': "{!! $result->id !!}",
            'roomImg': "{!! $result->photo_name !!}",
            'checkIn': "{!! date($php_format_date, strtotime($checkin)) !!}",
            'checkOut': "{!! date($php_format_date, strtotime($checkout)) !!}",
            'nights': "{!! $nights !!}",
            'price': "767"
        });
</script>

@if(Request::offsetGet('s_key') == '')
<script type="text/javascript">
    url = window.location.href;
                url += (url.match(/\?/) ? '&' : '?') + "s_key={{$s_key}}";
                history.replaceState(null, null, url);
</script>
@endif

<script src="https://js.stripe.com/v3/"></script>

{{-- <script type="text/javascript">
             var payment_intent_client_secret  = "{!! session('payment.'.$s_key.'.payment_intent_client_secret') ? session('payment.'.$s_key.'.payment_intent_client_secret') : ''  !!}";
         </script>--}}
@endpush

@stop
<style>
    .img_show {
    margin-bottom: 20px;
}
.total_show, .price_show, .guest_show, .checkin_show {
    padding-bottom: 20px;
    margin-bottom: 20px;
    border-bottom: 1px solid #ccc;
}
.Cookie__content {
    display: none !important;
}

.accommodation__filters h5 {
    display: flex;
    justify-content: space-between;
    font-size: 16px;
    font-weight: 400;
    color: #000;
    opacity: .7;
    font-family: DM Sans,sans-serif;
    line-height: 1.6;
    text-transform: capitalize;
}
.total_show h5 {
    font-weight: bold;
}
    </style>

@extends('rogoznica.layout.master')
@section('content')

<div>
  @include('rogoznica.includes.header')
</div>



<div class="white-bg__blog wrapper__404 error-top-bottom__404 d-white-stuff">
  <div class="homepage-lost">

    <div class=" lost-column--1 registerww__column">



      <div class="img-container__404">
        <img class="img__404" src="/assets/images/paperplane.svg" />
      </div>
      <div class="padding-top--1 registerww__column">
        <h2 class="text__align error-main-msg__404 o-80">
          @lang('messages.payments.almost_there')
          {{-- {{ trans('messages.errors.404_desc') }} --}}
        </h2>
      </div>
      <div class="padding-top--1 padding-bottom--2" style="max-width: 600px; text-align: center">
        @lang('messages.payments.confirmation_ready_next')
        <br>
        @lang('messages.payments.extra_holiday_services')


      </div>
      <div class="homepage__row__container space__between padding-bottom--2 padding-top--2 success-width-60">
        <div>
          <a href="{{ route('dashboard') }}"> <button class="btn btn--secondary success-page-btn-w">
              <p class="button__text">@lang('messages.header.dashboard')</p>
            </button></a>
        </div>
        <div>
          <a href="{{ route('service-and-activities') }}"> <button class="btn btn--secondary success-page-btn-w">
              <p class="button__text">@lang('messages.payments.transfer')</p>
            </button></a>
        </div>
        <div>
          <a href="https://www.rentacarlastminute.hr/{{trans('messages.home.lang')}}/index.aspx?affiliate=026"
            target="_blank"> <button class="btn btn--secondary success-page-btn-w">
              <p class="button__text">@lang('messages.payments.car')</p>
            </button></a>
        </div>
        <div>
          <a href="{{ route('home_page') }}"> <button class="btn btn--secondary success-page-btn-w">
              <p class="button__text">@lang('messages.payments.back_home')</p>
            </button></a>
        </div>
      </div>






    </div>


  </div>

</div>




{{--
<div class="white-bg__blog padding__bottom__custom padding__top__7 margin__bottom__minus60">
  <div class="wrapper__blogpost__uska">
    <div class="padding__bottom__4">
      <div class="registerww__column">
        <p class="ptag__align padding__top__custom font__medium__19">
          {{ trans('messages.errors.error_code') }}:
</p>
<div class="padding__top__4 padding__bottom__3">
  <p class="font-size--90 ">
    404
  </p>
</div>
<div class="homepage__row__container padding__top__2">
  <img src="/assets/images/lighthouseBig.svg" />
</div>
<div class="text-container--500 registerww__column padding__top__4">
  <h2 class="text__align  font__large__36 font-style__oops">
    {{ trans('messages.errors.oops') }}!
    {{ trans('messages.errors.404_desc') }}
  </h2>

  <div class="mt-3 padding__top__4 padding__bottom__1 ">

    {{ trans('messages.errors.helpful_links') }}:

  </div>
  <div class="homepage__row__container space__between error-links__width padding__top__xs padding__bottom__2">
    <div>
      <a href="{{URL::to('/')}}/">
        {{ trans('messages.header.home') }}
      </a>
    </div>
    <div>
      <a href="{{URL::to('/')}}/dashboard">
        {{ trans('messages.header.dashboard') }}
      </a>
    </div>
    <div>
      <a href="{{URL::to('/')}}/users/edit">
        {{ trans('messages.header.profile') }}
      </a>
    </div>
  </div>

</div>


</div>
</div>
</div>
</div> --}}
</main>
@push('scripts')
  <script type="text/javascript">
    window.dataLayer.push({
      'event': 'request-sent',
      'data': '{!!  $reservation !!}'
    });
  </script>
@endpush
@stop


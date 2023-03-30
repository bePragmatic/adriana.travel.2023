@extends('rogoznica.layout.master')
@section('content')

<div>
  @include('rogoznica.includes.header')
</div>





<div class="white-bg__blog wrapper__404 error-top-bottom__404">
  <div class="homepage-lost">

    <div class=" lost-column--1 registerww__column">
      <p class="font__medium__19">
        {{ trans('messages.errors.error_code') }}:
      </p>
      <div class="title-container__404">
        <p class="title__404">
          404
        </p>
      </div>
      <div class="img-container__404">
        <img class="img__404" src="/assets/images/lighthouseBig.svg" />
      </div>
      <div class="text-container__404 registerww__column">
        <h2 class="text__align error-main-msg__404 o-80">
          {{ trans('messages.errors.oops') }}!
          {{ trans('messages.errors.404_desc') }}
        </h2>

        <div class="helpful-title__404">

          {{ trans('messages.errors.helpful_links') }}:

        </div>
        <div class="homepage__row__container space__between helpful-links__404">
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
@stop
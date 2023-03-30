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
          500
        </p>
      </div>
      <div class="img-container__404">
        <img class="img__404" src="/assets/images/lighthouseBig.svg" />
      </div>
      <div class="text-container__404 registerww__column">
        <h2 class="text__align error-main-msg__404 o-80">
          {{ trans('messages.errors.shoot') }}!
          {{ trans('messages.errors.this_unexpected') }}…
        </h2>
      </div>
      <div class="helpful-title__500">
        <p class="p-spacer__500">{{ trans('messages.errors.500_desc1') }}</p>
        <p> {{ trans('messages.errors.500_desc2') }}!</p>
      </div>

    </div>
  </div>
</div>

</main>
@stop
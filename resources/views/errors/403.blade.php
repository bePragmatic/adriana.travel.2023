@extends('rogoznica.layout.master')
@section('content')

<div>
  @include('rogoznica.includes.header')
</div>

<div class="white-bg__blog error-top-bottom__403">
  <div class="wrapper__blogpost__uska">
    <div class="permission--height permission--layout">
      <div class="registerww__column">
        <h2 class="text__align  font__large__36 font-style__oops">
          {{ trans('messages.errors.need_permission_desc') }}
        </h2>
      </div>
    </div>
  </div>
</div>
</main>
@stop
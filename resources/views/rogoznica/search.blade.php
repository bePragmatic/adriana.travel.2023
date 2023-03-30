@extends('rogoznica.layout.master')
@section('content')
<div>
    <!-- Background in accommodation.css -->
    <div class="accommodation__hero">
        @include('rogoznica.includes.header')

        <div class="wrapper accommodation__header padding__top">
            <h1 class="accommodation__header__title">
                @lang('messages.home.looking_best')
            </h1>
            <header-search></header-search>
        </div>
    </div>

    <search :default_data="{{ json_encode($data) }}"
        :guest="{{ request()->has('guest') ? request()->get('guest') : 1 }}"></search>

</div>

@stop
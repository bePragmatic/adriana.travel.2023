@extends('rogoznica.layout.master')
@section('content')
<div>

    <div class="wrapper"></div>

    <div class="explore__hero">
        @include('rogoznica.includes.header')


        <div class="wrapper explore__header padding__top__7"></div>
    </div>

    {!! Form::open(['action' => 'HomeController@contact_create','accept-charset' => 'UTF-8' , 'novalidate' => 'true'])
    !!}

    <div class="white-bg__blog bg-blog__addition">
        <div class=" wrapper__blogpost__uska">
            <div class="contact-logo__position">
                <img src="./assets/adriana-travel.svg" class="padding__bottom__4" />
            </div>
            <div class="accommodation__filters__padding__top padding__bottom__4">
                <div>
                    <p class="dark__blue padding__bottom__xs">
                        {{ trans('messages.contactus.contactus') }}
                    </p>
                    <p class="base__contact padding__bottom__2xs">
                        @lang('messages.contactus.adriana_consulting')
                    </p>
                    <p class="base__contact padding__bottom__2xs">
                        @lang('messages.contactus.adriana_address')
                    </p>
                    <p class="base__contact padding__bottom__2xs">
                        @lang('messages.contactus.adriana_number')


                    </p>
                    <p class="base__contact__blue padding__bottom__2xs">
                        @lang('messages.contactus.adriana_mail')
                    </p>
                </div>
                <!-- ovo je dio testa -->
                <div>

                    <div>
                        <div>
                            @if(session()->has('message'))
                            <div class="alert alert-success success-msg__container">
                                {{ session()->get('message') }}
                                <div class="x--exit" onclick="this.parentElement.style.display='none';">&times;</div>
                            </div>

                            <script>
                                window.dataLayer.push({'event': 'upit-poslan'})
                            </script>
                            @endif
                        </div>
                        <div class="field">
                            <label for="input" class="field__lbl">{{ trans('messages.contactus.name') }}</label>
                            {!! Form::text('name', '', ['class' => $errors->has('name') ? 'input input--text
                            input--text--error'
                            : 'input
                            input--text focus',
                            'placeholder' => trans('messages.contactus.name')]) !!}
                            @error('name')
                            <span class="payment-error-msg">{{ $message }}</span>
                            @enderror

                        </div>

                        <div class="field">
                            <label for="input" class="field__lbl">{{  trans('messages.contactus.email_address') }}
                            </label>
                            {!! Form::email('email', '', ['class' => $errors->has('email') ? 'input input--text
                            input--text--error' : 'input
                            input--text focus', 'placeholder' => trans('messages.contactus.email_address')]) !!}
                            @error('email')
                            <span class="payment-error-msg">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="field">
                            <label for="input" class="field__lbl">@lang('messages.contactus.inquiry')</label>
                            {!! Form::textarea('feedback', '', ['class' => $errors->has('feedback') ? 'input input--text
                            input--text--error' :
                            'input input--text focus ', 'placeholder' =>
                            trans('messages.contactus.feedback')]) !!}
                            @error('feedback')
                            <span class="payment-error-msg">{{ $message }}</span>
                            @enderror

                        </div>

                        <div class="accommodation__filters__padding__top">

                            <div class="homepage__row__container checkbox-container">
                                <input class="initial-checkbox" id="gdpr" style="margin-top: 2px;" type="checkbox"
                                    name="gdpr" />
                                <label for="gdpr" class="text__footnote o-60 padding__left__10xs" @error('gdpr')
                                    style="color: red; opacity: 100%;" @enderror>

                                    {{ trans('messages.home.by_clicking_send') }}
                                    <a href="/terms_of_service" target="_blank">
                                        {{ trans('messages.home.terms') }}</a>
                                    {{ trans('messages.home.and') }}
                                    <a href="/privacy_policy" target="_blank">
                                        {{ trans('messages.home.privacy') }}</a>
                                </label>

                            </div>
                        </div>

                        <div class="homepage__row__container flex__end__img padding__top__custom">
                            {!! Form::submit( trans('messages.contactus.send') , ['class' => 'btn btn--primary
                            btn--med']) !!}



                        </div>

                    </div>





                </div>
            </div>
        </div>

        {!! Form::close() !!}


    </div>
</div>
@stop
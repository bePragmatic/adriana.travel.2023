@extends('rogoznica.layout.master')
@section('content')
<div>


    <div class="explore__hero">
        @include('rogoznica.includes.header')
        <div class="wrapper explore__header padding__top__7"></div>
    </div>








    <div class="white-bg__blog padding__bottom__2 ">
        <div class="white-bg__blog padding__bottom__custom">
            <div class=" wrapper">
                <h1 class="font__large__36 padding__bottom__2">@lang('messages.account.register')</h1>
            </div>
            <div class="wrapper homepage__row__container">
                <!-- kolona s inputima -->
                <div class="padding__bottom__4" style="width: 50%">
                    <div class="field">
                        <label for="input" class="field__lbl">@lang('messages.email.email_address')</label>

                        <input type="text" defaultValue id="input" class="input input--text"
                            placeholder="Enter your e-mail address" />
                    </div>
                    <div class="field">
                        <label for="input" class="field__lbl">@lang('messages.login.first_name')</label>

                        <input type="text" defaultValue id="input" class="input input--text"
                            placeholder="Enter your first name" />
                    </div>
                    <div class="field">
                        <label for="input" class="field__lbl">@lang('messages.login.last_name')</label>

                        <input type="text" defaultValue id="input" class="input input--text"
                            placeholder="Enter your last name" />
                    </div>

                    <div class="field">
                        <label for="input" class="field__lbl">@lang('messages.login.phone_number')</label>

                        <input type="text" defaultValue id="input" class="input input--text"
                            placeholder="Enter your phone number" />
                    </div>

                    <div class="homepage__row__container flex__end__img padding__top__custom">
                        <button class="btn btn--primary btn--med btn__width">
                            @lang('messages.account.register')
                        </button>
                    </div>
                </div>

                <!-- kolona "or Sign in By" -->
                <div class="top__margin__16xs homepage__column__container flex__container__1"
                    style="justify-content: center;padding-bottom: 90px">
                    <p class="base__bold">@lang('messages.home.or')<span
                            class="t-bold">@lang('messages.header.sign_in')</span>@lang('messages.home.by')</p>
                </div>
                <!-- kolona social media buttons -->

                <div class="homepage__column__container"
                    style="justify-content: space-between; align-items: center; padding-bottom: 70px; margin-top: 34px;">
                    <button class="btn btn--secondary btn--med btn__width">
                        Google
                    </button>
                    <button class="btn btn--secondary btn--med btn__width">
                        Facebook
                    </button>
                    <button class="btn btn--secondary btn--med btn__width">
                        Twitter
                    </button>
                    <button class="btn btn--secondary btn--med btn__width">
                        LinkedIn
                    </button>

                    <p>
                        @lang('messages.header.already_registered')?
                        <span class="rogoznica__blue__forms o-80">@lang('messages.header.sign_in')!</span>
                    </p>
                </div>
            </div>
        </div>
    </div>

</div>
</div>
@stop

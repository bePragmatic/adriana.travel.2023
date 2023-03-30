<!DOCTYPE html>
<html dir="{{ (((Session::get('language')) ? Session::get('language') : $default_language[0]->value) == 'ar') ? 'rtl' : '' }}" lang="{{ (Session::get('language')) ? Session::get('language') : $default_language[0]->value }}"  xmlns:fb="http://ogp.me/ns/fb#">

@include('rogoznica.includes.head')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<body>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PRW6B8H"
                  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<noscript><strong>@lang('messages.header.vuerogoznica')</strong></noscript>
<div id="app">
    @yield('content')



    <cookie-law :buttonDecline="true">
        <div slot-scope="props" class="width__100">

            {{-- <div class="Cookie Cookie--bottom Cookie--base"> --}}
            <div class="Cookie__content">
                <div class="Cookie__alignment">
                    <p class="Cookie__message">@lang('messages.footer.using_cookies',['site_name' => $site_name])
                        <span>
                                <a href="{{url('privacy_policy')}}" class="theme-link" target="_blank">
                                    @lang('messages.login.privacy_policy').
                                </a>
                            </span>
                    </p>
                </div>

                <div class="Cookie__buttons">
                    <button class="Cookie__button" @click="props.accept">
                        @lang('messages.disputes.accept')
                    </button>
                    {{-- <button class="Cookie__button " @click="props.close">
                @lang('messages.your_reservations.decline')
            </button>--}}
                    {{-- </div> --}}
                </div>
            </div>
        </div>

    </cookie-law>
    @include('rogoznica.includes.footer')
</div>


</body>

</html>

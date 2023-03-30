<footer class="footer">

    <div class="wrapper">
        <div class="footer__content">
            <div class="footer__brand">
                <img src="/assets/logo-full.svg" alt="Adriana Consulting" />
            </div>
            <ul class="footer__menu footer__menu--navigation">
                <li>
                    <a href="{{ route('home_page') }}" class="footer__link">
                        @lang('messages.header.home')
                    </a>
                </li>
                <li>
                    <a href="/accommodation" class="footer__link">
                        @lang('messages.header.accommodations')
                    </a>
                </li>
                <li>
                    <a href="{{ route('service-and-activities') }}" class="footer__link">
                        @lang('messages.header.services') &amp; @lang('messages.header.activities')
                    </a>
                </li>
                <li>
                    <a href="{{ route('rogoznica') }}" class="footer__link">
                        Rogoznica
                    </a>
                </li>
            </ul>
            <ul class="footer__menu footer__menu--navigation">
                <li>
                    <a href="{{ route('explore') }}" class="footer__link">
                        @lang('messages.header.explore_dalmatia')
                    </a>
                </li>
                <li>
                    <a href="{{ route('blog') }}" class="footer__link">
                        @lang('messages.home.blog')
                    </a>
                </li>
                <li>
                    <a href="{{ route('contact_us') }}" class="footer__link">
                        @lang('messages.referrals.contact')
                    </a>
                </li>
                <li>
                    <a href="/login" class="footer__link">
                        @lang('messages.header.sign_in')
                    </a>
                </li>
            </ul>
            <ul class="footer__menu">
                <li>
                    <a href="{{ url('impressum') }}" class="footer__link">
                        @lang('messages.header.impressum')
                    </a>
                </li>
                <li>
                    <a href="{{ url('privacy_policy') }}" class="footer__link">
                        @lang('messages.login.privacy_policy')
                    </a>
                </li>
                <li>
                    <a href="{{ url('terms_of_service') }}" class="footer__link">
                        @lang('messages.login.terms_service')
                    </a>
                </li>
                {{--                <li>--}}
                {{--                    <currency-switcher defualt="{{  Session::get('currency') }}">
                </currency-switcher>--}}

                {{--                </li>--}}


            </ul>
            <div class="footer__social">
                <a href="http://google.com">
                    <img src="/assets/icon-facebook.svg" alt="Facebook" />
                </a>
                <a href="https://www.instagram.com/adriana.consulting/">
                    <img src="/assets/icon-instagram.svg" alt="Instagram" />
                </a>
                <a href="http://google.com">
                    <img src="/assets/icon-twitter.svg" alt="Twitter" />
                </a>
            </div>
        </div>
    </div>
    <div class="wrapper">
        <p class="footer__copyright">
            @lang('messages.header.all_rights_reserved') </p>
    </div>
</footer>
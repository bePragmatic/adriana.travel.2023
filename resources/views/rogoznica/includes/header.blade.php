<!-- By adding ".header__branding--sm-dark" class logo - positive is displayed on small resolutions -->

<!-- Hamburger button for showing menu on mobile resolutions. On click should toggle class ".active" on itself and the same class on ".nav" -->
<hamburger>
    <ul class="nav__list">
        <li class="nav__item nav__item--mobile">
            <a href="{{ route('home_page') }}" class="nav__link">
                @lang('messages.header.home')
            </a>
        </li>
        <li class="nav__item">
            <a href="/accommodation" class="nav__link {{ (request()->is('accommodation')) ? 'active' : '' }}">
                @lang('messages.header.accommodations')
            </a>
        </li>
        <li class="nav__item">
            <a href="{{ route('service-and-activities') }}"
                class="nav__link {{ (request()->is('service-and-activities')) ? 'active' : '' }}">
                @lang('messages.header.services') &amp; @lang('messages.header.activities')
            </a>
        </li>
        <li class="nav__item">
            <a href="{{ route('rogoznica') }}" class="nav__link {{ (request()->is('rogoznica')) ? 'active' : '' }}">
                Rogoznica
            </a>
        </li>
        <li class="nav__item">
            <a href="{{ route('explore') }}"
                class="nav__link {{ (request()->is('explore-dalmatian-coast')) ? 'active' : '' }}">
                @lang('messages.header.explore_dalmatia')
            </a>
        </li>
        <li class="nav__item">
            <a href="{{ route('blog') }}" class="nav__link {{ (request()->is('blog')) ? 'active' : '' }}">
                @lang('messages.home.blog')

            </a>
        </li>
        <li class="nav__item">
            <a href="{{ route('contact_us') }}" class="nav__link  {{ (request()->is('contact_us')) ? 'active' : '' }}">
                @lang('messages.referrals.contact')

            </a>
        </li>
        <!-- mobile  treba if-->
        <li class="nav__item nav__item--mobile nav__mobile-holder">
            {{-- <div class="nav__mobile-lang">
                <a href="#" class="active">
                    ENG
                </a>
                <a href="#">DE</a>
                <a href="#">HR</a>

            </div> --}}
            <language-switcher-mobile defualt="{{  Session::get('language') }}" />
            <div class="nav__mobile-social">
                <a href="https://www.instagram.com/adriana.consulting/">
                    <img src="/assets/icon-instagram.svg" alt="Instagram" />
                </a>
                <a href="#">
                    <img src="/assets/icon-facebook.svg" alt="Facebook" />
                </a>
                <a href="#">
                    <img src="/assets/icon-twitter.svg" alt="Twitter" />
                </a>
            </div>
        </li>
        <li class="nav__item">
            <a href="/login" class="nav__link">
                {{ trans('messages.header.signup') }}
            </a>
        </li>
    </ul>

    <language-switcher defualt="{{  Session::get('language') }}" />


</hamburger>




</header>
<!-- tajna -->


@extends('template')
@section('main')
<main id="site-content" role="main" class="main-vertical--center">
  <div class="container py-4 py-md-5">
    <div class="log-page p-4 log-page-modified">
      <div class="logo-position">
        <img class="logo-size--login" src="./assets/adriana-travel.svg">
      </div>
      {{--  <ul class="social-log">
        <li>
          <a href="{{ $fb_url }}" class="fb-btn btn d-flex align-items-center justify-content-center">
      <i class="icon icon-facebook"></i>
      <span class="d-inline-block ml-3">
        {{ trans('messages.login.login_with')}} Facebook
      </span>
      </a>
      </li>
      <li>
        <a href="javascript:;" id="google_login"
          class="google-btn btn d-flex align-items-center justify-content-center btn-google--v">
          <i class="icon icon-google-plus"></i>
          <span class="d-inline-block ml-3">
            {{ trans('messages.login.login_with')}} Google
          </span>
        </a>
      </li>
      <li>
        <a href="{{ getAppleLoginUrl() }}" id="apple_login"
          class="apple-btn btn d-flex align-items-center justify-content-center">
          <i class="fa fa-apple push-half--right"></i>
          <span class="d-inline-block ml-3">
            {{ trans('messages.login.login_with')}} Apple
          </span>
        </a>
      </li>
      --}}{{--
        <li>
          <a href="{{URL::to('auth/linkedin')}}" class="linkedin-btn btn d-flex align-items-center
      justify-content-center">
      <i class="icon icon-linkedin"></i>
      <span class="d-inline-block ml-3">
        {{ trans('messages.login.login_with')}} LinkedIn
      </span>
      </a>
      </li>
      s
      </ul>
      <div class="or-block my-4 d-flex align-items-center px-0">
        <span class="d-inline-block mx-3">
          {{ trans('messages.login.or')}}
        </span>
      </div>
      --}}
      <div class="log-form">
        {!! Form::open(['url' => route('login'), 'method' => 'POST', 'novalidate' => 'true']) !!}
        <input id="from" name="from" type="hidden" value="email_login">

        <div class="control-group">
          @if ($errors->has('login_email'))
          <p class="error-msg mb-1">
            {{ $errors->first('login_email') }}
          </p>
          @endif
          <div class="d-flex align-items-center">
            <input
              class="{{ $errors->has('email') ? 'decorative-input inspectletIgnore invalid' : 'decorative-input inspectletIgnore name-icon border-radius--8' }}"
              placeholder="{{ trans('messages.login.email_address') }}" name="login_email" type="email" value="">
            <i class="icon icon-envelope icon-envelope--color"></i>
          </div>
        </div>

        <div class="control-group">
          @if ($errors->has('login_password'))
          <p class="error-msg mb-1">
            {{ $errors->first('login_password') }}
          </p>
          @endif
          <div class="d-flex align-items-center">
            <input
              class="{{ $errors->has('password') ? 'decorative-input inspectletIgnore invalid' : 'decorative-input inspectletIgnore name-icon border-radius--8' }}"
              placeholder="{{ trans('messages.login.password') }}" data-hook="signin_password" name="login_password"
              type="password" value="">
            <i class="icon icon-lock icon-lock--color"></i>
          </div>
        </div>

        <div class="d-flex my-3 align-items-center justify-content-between">
          <label for="remember_me3" class="checkbox remember-me m-0">
            <input id="remember_me3" class="remember_me mr-1" name="remember_me" type="checkbox" value="1">
            {{ trans('messages.login.remember_me')}}
          </label>
          <a href="javascript:void(0)" class="forgot-open">
            {{ trans('messages.login.forgot_pwd')}}
          </a>
        </div>

        <input class="btn-blue btn-blue--radius" type="submit" value="{{ trans('messages.header.login') }}">
        {!! Form::close() !!}
        <div class="form-footer mt-3 pt-3 text-center">
          {{ trans('messages.login.dont_have_account')}}
          {{-- <a href="javascript:void(0)" class="signup-open">
            {{ trans('messages.header.signup')}}
          </a> --}}
          <a href="{{ $fb_url }}" class="email-btn" data-toggle="modal" data-target="#signup-popup">
            {{ trans('messages.header.signup')}}
          </a>

        </div>
      </div>
    </div>

  </div>



  <!-- MODAL BODY ZA REGISTRACIJU SIGN UP -->


  <div class="sign-popup modal fade" role="dialog" id="signup-popup2">
    <div class="modal-dialog">
      <div class="modal-content px-3 pb-4 pt-3" style="border-radius: 24px">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"></button>
        </div>




        <div class="modal-body">

          {{--    <div class="my-3">
           <p class="text-center m-0">
              {{ trans('messages.login.signup_with') }}
          <a href="{{ $fb_url }}" data-populate_uri="" data-redirect_uri="{{URL::to('/')}}/authenticate"
            class="green-link">
            Facebook
          </a>,
          <a href="javascript:;" id="pop_google_signup_link" class="green-link">
            Google
          </a>,
          or
          <a href="{{ getAppleLoginUrl() }}" id="apple_signup_link" class="green-link">
            Edo
          </a>
          {{--
                <a href="{{URL::to('auth/linkedin')}}" class="green-link">
          LinkedIn
          </a>

          </p>
        </div>--}}





        {{-- <div class="or-block my-4 d-flex align-items-center px-0">
          <span class="d-inline-block mx-3">
            {{ trans('messages.login.or')}}
        </span>
      </div> --}}


      <div class="log-form">
        {!! Form::open(['action' => 'UserController@create', 'class' => 'signup-form', 'data-action' => 'Signup',
        'id'
        => 'user_new', 'accept-charset' => 'UTF-8' , 'novalidate' => 'true']) !!}
        <div class="signup-form-fields">
          {!! Form::hidden('from', 'email_signup', ['id' => 'signup_from']) !!}
          <div class="control-group" id="inputFirst">
            @if ($errors->has('first_name'))
            <p class="error-msg">
              {{ $errors->first('first_name') }}
            </p>
            @endif
            <div class="d-flex align-items-center justify-content-center">
              {!! Form::text('first_name', '', ['class' => $errors->has('first_name') ? 'decorative-input invalid '
              :
              'decorative-input name-icon input_new border-radius--8', 'placeholder' =>
              trans('messages.login.first_name')]) !!}
              <i class="icon icon-users icon-envelope--color"></i>
            </div>
          </div>
          <div class="control-group" id="inputLast">
            @if ($errors->has('last_name'))
            <p class="error-msg">
              {{ $errors->first('last_name') }}
            </p>
            @endif
            <div class="d-flex align-items-center justify-content-center">
              {!! Form::text('last_name', '', ['class' => $errors->has('last_name') ? 'decorative-input
              inspectletIgnore invalid' : 'decorative-input inspectletIgnore name-icon input_new border-radius--8',
              'placeholder' =>
              trans('messages.login.last_name')]) !!}
              <i class="icon icon-users icon-envelope--color"></i>
            </div>
          </div>
          <div class="control-group" id="inputEmail">
            @if ($errors->has('email'))
            <p class="error-msg">
              {{ $errors->first('email') }}
            </p>
            @endif
            <div class="d-flex align-items-center justify-content-center">
              {!! Form::email('email', '', ['class' => $errors->has('email') ? 'decorative-input inspectletIgnore
              invalid' : 'decorative-input inspectletIgnore name-mail name-icon input_new border-radius--8',
              'placeholder' =>
              trans('messages.login.email_address')]) !!}
              <i class="icon icon-envelope icon-envelope--color"></i>
            </div>
          </div>
          <div class="control-group" id="inputPassword">
            @if ($errors->has('password'))
            <p class="error-msg">
              {{ $errors->first('password') }}
            </p>
            @endif
            <div class="d-flex align-items-center justify-content-center">
              {!! Form::password('password', ['class' => $errors->has('password') ? 'decorative-input
              inspectletIgnore
              invalid' : 'decorative-input inspectletIgnore name-pwd name-icon input_new border-radius--8',
              'placeholder' =>
              trans('messages.login.password'), 'id' => 'user_password', 'data-hook' => 'user_password']) !!}
              <i class="icon icon-lock icon-envelope--color"></i>
            </div>
            <div data-hook="password-strength" class="password-strength hide"></div>
          </div>
          <div class="control-group mt-3">

            <p class="m-0 pt-1">
              {{ trans('messages.login.birthday_message') }}
            </p>
          </div>
          <div class="control-group" id="inputBirthday"></div>
          @if ($errors->has('birthday_month') || $errors->has('birthday_day') || $errors->has('birthday_year'))
          <p class="error-msg">
            {{ $errors->has('birthday_day') ? $errors->first('birthday_day') : ( $errors->has('birthday_month') ? $errors->first('birthday_month') : $errors->first('birthday_year') ) }}
          </p>
          @endif
          <div class="control-group calander_new d-md-flex">
            <div class="select flex-grow-1">
              <i class="icon icon-chevron-down"></i>
              {!! Form::selectMonthWithDefault('birthday_month', null, trans('messages.header.month'), [ 'class' =>
              $errors->has('birthday_month') ? 'invalid' : '', 'id' => 'user_birthday_month']) !!}
            </div>
            <div class="select flex-grow-1 my-3 my-md-0 mx-0 mx-md-3">
              <i class="icon icon-chevron-down icon-envelope--color"></i>
              {!! Form::selectRangeWithDefault('birthday_day', 1, 31, null, trans('messages.header.day'), [ 'class'
              =>
              $errors->has('birthday_day') ? 'invalid' : '', 'id' => 'user_birthday_day']) !!}
            </div>
            <div class="select flex-grow-1">
              <i class="icon icon-chevron-down icon-envelope--color"></i>
              {!! Form::selectRangeWithDefault('birthday_year', date('Y'), date('Y')-120, null,
              trans('messages.header.year'), [ 'class' => $errors->has('birthday_year') ? 'invalid' : '', 'id' =>
              'user_birthday_year']) !!}
            </div>
          </div>

          <div class="mt-3 d-flex">
            <input type="checkbox" ng-model="agree_toc">
            <div class="agree-links">
              <ul class="clearfix">
                <li>
                  @lang('messages.login.signup_agree') {{ $site_name }}'s
                </li>
                @foreach($company_pages as $company_page)
                <li>
                  <a href="{{ url($company_page->url) }}" target="new">
                    {{ $company_page->name }}
                    <span>,</span>
                  </a>
                </li>
                @endforeach
              </ul>
            </div>
          </div>

          {!! Form::submit( trans('messages.header.signup'), ['class' => 'my-3 d-flex justify-content-center
          btn-blue
          btn-blue--radius' , 'id' => 'user-signup-btn', 'ng-disabled' => '!agree_toc']) !!}
          {!! Form::close() !!}

          {{-- <div class="form-footer mt-3 pt-3 text-center">
            {{ trans('messages.login.already_an') }} {{ $site_name }} {{ trans('messages.login.member') }}
          <a href="javascript:void(0)" class="login-open green-link" data-toggle="modal" data-target="#signup-popup2">
            {{ trans('messages.header.login') }}
          </a>
        </div> --}}
      </div>
    </div>
  </div>
  </div>
  </div>
  </div>


  <!-- DO OVDJE MODAL ZA REGISTRACIJU PUTEM MAILA -->







  <!-- Cookie Alert -->
  <div class="alert cookie-alert alert-dismissible m-0" style="display: none">
    <i class="close" data-dismiss="alert" style='cursor: pointer'></i>
    <p>
      @lang('messages.footer.using_cookies',['site_name' => $site_name])
      <a href="{{url('privacy_policy')}}" class="theme-link">
        @lang('messages.login.privacy_policy').
      </a>
    </p>
  </div>

  <script type="text/javascript">
    $(document).on('click','.cookie-alert .close',function() {
      writeCookie('accept_cookie','1',10);
    });

    var getCookiebyName = function() {
      var pair = document.cookie.match(new RegExp('accept_cookie' + '=([^;]+)'));
      var result = pair ? pair[1] : 0;
      $('.cookie-alert').show();
      if(result) {
        $('.cookie-alert').hide();
      }
    };

    var url = window.location.href;
    var arr = url.split("/");
    var result = arr[0] + "//" + arr[2];
    var domain =  result.replace(/(^\w+:|^)\/\//, '');

    writeCookie = function(cname, cvalue, days) {
      var dt, expires;
      dt = new Date();
      dt.setTime(dt.getTime()+(days*24*60*60*1000));
      expires = "; expires="+dt.toGMTString();
      document.cookie = cname+"="+cvalue+expires+'; domain='+domain+ "; path=/";
    }
    getCookiebyName();
  </script>

</main>
@stop
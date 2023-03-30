<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Admin Panel</title>
  <link rel="shortcut icon" href="{{ $favicon }}">
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.5 -->
  <link rel="stylesheet" href="{{ url('admin_assets/bootstrap/css/bootstrap.min.css') }}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

  <!-- Theme style -->
  <link rel="stylesheet" href="{{ url('admin_assets/dist/css/AdminLTE.css') }}">

  <!-- slider !-->
  <link rel="stylesheet" href="{{ url('admin_assets/plugins/login_slider/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ url('admin_assets/plugins/login_slider/style.css') }}">
  <!-- slider !-->

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>

<body class="hold-transition login-page" style="background: #eff3f5">

  <div class="flash-container" style="left:15px;">
    @if(Session::has('message') && !Auth::guard('admin')->check())
    <div class="alert {{ Session::get('alert-class') }}" role="alert">
      <a href="#" class="alert-close" data-dismiss="alert">&times;</a>
      {{ Session::get('message') }}
    </div>
    @endif
  </div>

  <div class="login-box">
    <div class="register-container container">
      <div class="row">

        <div class="register span4">
          <form action="{{ url(ADMIN_URL.'/authenticate') }}" method="post" style=" border-radius: 24px">
            {!! Form::token() !!}
            <p style="font-family: 'DM Sans', sans-serif; font-size: 18px; padding-top: 1.4em;">LOGIN TO
            </p>
            <h2><span
                style="font-family: 'DM Sans', sans-serif;color: #009fda;   font-family: 'DM Sans', sans-serif;"><strong>{{ $site_name }}</strong></span>
            </h2>

            <label style="font-family: 'DM Sans', sans-serif;" for="username">Username</label>
            <input style="border-radius: 6px; padding: 16px 16px;" type="text" id="username" value="" name="username"
              placeholder="Enter the username">
            <label style="font-family: 'DM Sans', sans-serif;" for="password">Password</label>
            <input style="border-radius: 6px; padding: 16px 16px;" type="password" id="password" value=""
              name="password" placeholder="Enter the password">
            <button type="submit" class="admin-btn__blue" style="  background: #009fda !important;
            padding: 0 24px 0 24px;
            font-size: 14px;
            line-height: 36px;
            border-radius: 6px;
            font-family: 'DM Sans', sans-serif;
            font-weight: 400;">LOG IN</button>
          </form>
        </div>
      </div>
    </div>
  </div>



  <!-- /.login-box -->

  <!-- jQuery 2.1.4 -->
  <script src="{{ url('admin_assets/plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>
  <!-- Bootstrap 3.3.5 -->
  <script src="{{ url('admin_assets/bootstrap/js/bootstrap.min.js') }}"></script>

  <script src="{{ url('admin_assets/plugins/login_slider/scripts.js') }}"></script>

  {{-- <script src="{{ url('admin_assets/plugins/login_slider/jquery.backstretch.min.js') }}"></script> --}}
</body>

</html>
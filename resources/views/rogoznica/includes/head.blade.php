<head>


    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-172680906-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-172680906-1');
    </script>

    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-PRW6B8H');</script>
    <!-- End Google Tag Manager -->


    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport"
          content="user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1, width=device-width, height=device-height">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <meta name="viewport" content="user-scalable=no, width=device-width">
    <meta name="daterangepicker_format" content="{{ $daterangepicker_format  }}">
    <meta name="datepicker_format" content="{{$datepicker_format }}">
    <meta name="datedisplay_format" content="{{ strtolower(DISPLAY_DATE_FORMAT) }}">
    <meta name="php_date_format" content="{{ PHP_DATE_FORMAT }}">

    <link rel="dns-prefetch" href="https://maps.googleapis.com/">
    <link rel="dns-prefetch" href="https://maps.gstatic.com/">
    <link rel="dns-prefetch" href="https://mts0.googleapis.com/">
    <link rel="dns-prefetch" href="https://mts1.googleapis.com/">
    <link rel="shortcut icon" href="{{ $favicon }}">

    <script>
        window.lang = "{!! (Session::get('language')) ? Session::get('language') : $default_language[0]->value !!}";
        var LANG = "{!! (Session::get('language')) ? Session::get('language') : $default_language[0]->value !!}";

    </script>

    @stack('scripts')

    <script src="{{asset('js/app.js')}}" defer></script>
    <link rel="stylesheet" href="{{asset('/compiled/normalize.css')}}">
    <link rel="stylesheet" href="{{asset('/compiled/app.css')}}">


    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="ahrefs-site-verification" content="b7c556a8d6699d627cc7b2ace7dbe8381e0078ed197148f1a10998722e94d82b">
    <meta name="keywords"
          content="{{ Helpers::meta((!isset($exception)) ? Route::current()->uri() : '', 'keywords') }}">
    <meta name="twitter:widgets:csp" content="on">

    @if (!isset($exception))

        @if (Route::current()->uri() == 'rooms/{id}')
            <title>{{ $result->name }} - {{ $result->room_type_name }} | {{ SITE_NAME }} </title>
            <meta property="og:image" content="{{ $result->photo_name }}">
            <meta itemprop="image" src="{{ $result->photo_name }}">
            <link rel="image_src" href="#" src="{{ $result->photo_name }}">

            <meta property="og:url" content="{{ $result->link }}">
            <meta property="og:type" content="website"/>
            <meta property="og:title" content="{{ @$result->title }}">
            <meta property="og:description"
                  content="{{ @$result->city_details->name }} - {{ @$result->tagline }} - {{ @$result->about_you}}">
            <meta property="og:image" content="{{ @$result->host_experience_photos[0]->og_image }}">
            <meta property="og:image:height" content="1280">
            <meta property="og:image:width" content="853">
            <meta itemprop="image" src="{{ @$result->photo_name }}">
            <link rel="image_src" href="#" src="{{ @$result->photo_name }}">
            <meta name="twitter:title" content="{{ @$result->title }}">
            <meta name="twitter:site" content="{{ SITE_NAME }}">
            <meta name="twitter:url" content="{{ $result->link }}">



        @elseif (Route::current()->uri() == 'experiences/{host_experience_id}')
            <title>{{ @$result->title.' - '.$site_name }}</title>
            <meta name="description"
                  content="{{ @$result->city_details->name }} - {{ @$result->tagline }} - {{ @$result->about_you}}">
            <meta name="twitter:widgets:csp" content="on">
            <meta property="og:url" content="{{ $result->link }}">
            <meta property="og:type" content="website"/>
            <meta property="og:title" content="{{ @$result->title }}">
            <meta property="og:description"
                  content="{{ @$result->city_details->name }} - {{ @$result->tagline }} - {{ @$result->about_you}}">
            <meta property="og:image" content="{{ @$result->host_experience_photos[0]->og_image }}">
            <meta property="og:image:height" content="1280">
            <meta property="og:image:width" content="853">
            <meta itemprop="image" src="{{ @$result->photo_name }}">
            <link rel="image_src" href="#" src="{{ @$result->photo_name }}">
            <meta name="twitter:title" content="{{ @$result->title }}">
            <meta name="twitter:site" content="{{ SITE_NAME }}">
            <meta name="twitter:url" content="{{ $result->link }}">

        @elseif (Route::current()->uri() == 'blog')
            <title>{{'Blog  | '.$site_name }}</title>

        @elseif (Route::current()->uri() == 'blog/{slug}')
            <title>{{ $post->title.' | '.$site_name }}</title>
            <meta name="description" content="{!!   \Str::words(strip_tags($post['content']), 20) !!}">
            <meta name="twitter:widgets:csp" content="on">
            <meta property="og:url" content="{{ Route::current()->uri }}">
            <meta property="og:type" content="article"/>
            <meta property="og:description" content="   {!!   \Str::words(strip_tags($post['content']), 20) !!}">

            <meta name="twitter:title" content="{{ $post->title }}">
            <meta name="twitter:site" content="{{ SITE_NAME }}">
            <meta name="twitter:url" content="{{  Route::current()->uri }}">

        @elseif (Route::current()->uri() == 'rent-a-boat-one')
            <title>Futurama 550 | {{ $site_name }}  </title>
            @elseif (Route::current()->uri() == 'rent-a-boat-two')
            <title>Rascala Bluline 19 Open | {{ $site_name }}  </title>
        @else
        
            <title>{{ $title ?? Helpers::meta((!isset($exception)) ? Route::current()->uri() : '', 'title') }} {{ $additional_title ?? '' }} | {{ $site_name }}  </title>
        @endif


    @endif


    <meta name="description"
          content="{{ Helpers::meta((!isset($exception)) ? Route::current()->uri() : '', 'description') }}">
    <meta name="mobile-web-app-capable" content="yes">


</head>

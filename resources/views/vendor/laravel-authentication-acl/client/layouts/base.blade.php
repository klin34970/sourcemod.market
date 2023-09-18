<!DOCTYPE html>
<!--[if IE 8]> <html lang="{!! App::getLocale() !!}" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="{!! App::getLocale() !!}" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="{!! App::getLocale() !!}"> <!--<![endif]-->

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta name="description" content="@yield('description')">
	<meta name="keywords" content="@yield('keywords')">
	
	<meta property="og:title" content="@yield('title')" />
	<meta property="og:description" content="@yield('description')" />
	<meta property="og:type" content="@yield('og_type')" />
	<meta property="og:url" content="{{ Request::url() }}" />
	<meta property="og:image" content="@yield('og_image')" />
	<meta property="fb:app_id" content="1764547317118152" />
	
	<meta name="twitter:card" content="@yield('twitter_card')" />
	<meta name="twitter:site" content="@SourcemodMarket" />
	<meta name="twitter:creator" content="@SourcemodMarket" />

	@if($logged_user)
		<meta name="user_id" content="{{ $logged_user->id }}" />
		<meta name="user_url" content="{{ Request::url() }}" />
	@endif
	<link rel="apple-touch-icon" sizes="57x57" href="/assets/images/favicons/apple-touch-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="/assets/images/favicons/apple-touch-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="/assets/images/favicons/apple-touch-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="/assets/images/favicons/apple-touch-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="/assets/images/favicons/apple-touch-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="/assets/images/favicons/apple-touch-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="/assets/images/favicons/apple-touch-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="/assets/images/favicons/apple-touch-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="/assets/images/favicons/apple-touch-icon-180x180.png">
	<link rel="icon" type="image/png" href="/assets/images/favicons/favicon-32x32.png" sizes="32x32">
	<link rel="icon" type="image/png" href="/assets/images/favicons/favicon-194x194.png" sizes="194x194">
	<link rel="icon" type="image/png" href="/assets/images/favicons/android-chrome-192x192.png" sizes="192x192">
	<link rel="icon" type="image/png" href="/assets/images/favicons/favicon-16x16.png" sizes="16x16">
	<link rel="manifest" href="/assets/images/favicons/manifest.json">
	<link rel="mask-icon" href="/assets/images/favicons/safari-pinned-tab.svg" color="#5bbad5">
	<link rel="shortcut icon" href="/assets/images/favicons/favicon.ico">
	<meta name="apple-mobile-web-app-title" content="Sourcemod.Market">
	<meta name="application-name" content="Sourcemod.Market">
	<meta name="msapplication-TileColor" content="#2d89ef">
	<meta name="msapplication-TileImage" content="/assets/images/favicons/mstile-144x144.png">
	<meta name="msapplication-config" content="/assets/images/favicons/browserconfig.xml">
	<meta name="theme-color" content="#ffffff">

    <title>@yield('title') - Sourcemod.Market</title>

	{!! Html::style('https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700') !!}
	{!! Html::style('/css/theme.css') !!}
	{!! Html::style('assets/admin/css/themes/'.App\Http\Classes\Theme::getThemeByDay().'', ['id'=>'theme']) !!}
	@yield('styles')

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body class="@yield('page') page-sound page-header-fixed page-sidebar-fixed page-sidebar-minimize">

<section id="wrapper">
    <!--[if lt IE 9]>
    <p class="upgrade-browser">Upps!! You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/" target="_blank">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->
	
	@include('laravel-authentication-acl::client.layouts.partials.header')
	@include('laravel-authentication-acl::client.layouts.partials.sidebar-left')
	@yield('content')
	@include('laravel-authentication-acl::client.layouts.partials.sidebar-right')
</section>


<div id="back-top" class="animated pulse circle">
    <i class="fa fa-angle-up"></i>
</div>

<!-- Scripts -->
{!! Html::script('https://cdn.socket.io/socket.io-1.3.4.js') !!}
{!! Html::script('js/theme.js') !!}

@yield('scripts')
<script>
	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

	ga('create', 'UA-81673803-1', 'auto');
	ga('send', 'pageview');
</script>
</body>
</html>
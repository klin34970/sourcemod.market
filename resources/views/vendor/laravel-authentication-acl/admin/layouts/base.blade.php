<!DOCTYPE html>
<!--[if IE 8]> <html lang="{!! App::getLocale() !!}" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="{!! App::getLocale() !!}" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="{!! App::getLocale() !!}"> <!--<![endif]-->

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>@yield('title')</title>

    @yield('styles')

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body class="@yield('page') page-sound page-header-fixed page-sidebar-fixed">

<section id="wrapper">
    <!--[if lt IE 9]>
    <p class="upgrade-browser">Upps!! You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/" target="_blank">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->
	
	@include('laravel-authentication-acl::admin.layouts.partials.header')
	@include('laravel-authentication-acl::admin.layouts.partials.sidebar-left')
	@yield('content')
	@include('laravel-authentication-acl::admin.layouts.partials.sidebar-right')
	
</section>


<div id="back-top" class="animated pulse circle">
    <i class="fa fa-angle-up"></i>
</div>

<!-- Scripts -->
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

@extends('laravel-authentication-acl::client.layouts.base')

@section('title', 'Contact Us')
@section('description', 'Contact Us')
@section('keywords', 'contact')
@section('og_type', 'website')
@section('twitter_card', 'website')
@section('og_image', url('/') . '/assets/images/logos/banner.png')

@section('page', 'page-help-contact') 
@section('content')
<!-- START @PAGE CONTENT -->
<section id="page-content">

	<!-- Start body content -->
	<div class="body-content animated fadeIn">

		<div class="row">
			<div class="alert alert-info">
				<span class="alert-icon"><i class="fa fa-envelope-o"></i></span>
				<div class="notification-info">
					<ul class="clearfix notification-meta">
						<li class="pull-left notification-sender"><span><a href="mailto:contact@sourcemod.market">Contact Us</a></span></li>
					</ul>
					<p>You can contact us via our e-mail <a href="mailto:contact@sourcemod.market">contact@devsapps.com</a></p>
				</div>
			</div>
		</div><!-- row -->

	</div><!-- /.body-content -->
	<!--/ End body content -->
	
	@include('laravel-authentication-acl::client.layouts.partials.footer')

</section><!-- /#page-content -->
<!--/ END PAGE CONTENT -->
@endsection
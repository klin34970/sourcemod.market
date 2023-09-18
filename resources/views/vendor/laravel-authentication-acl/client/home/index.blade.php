@extends('laravel-authentication-acl::client.layouts.base')

@section('title', trans('front/home.title'))
@section('description', 'Are you a content creator who wants to publish his work? Sourcemod.Market is the best solution for you! You\'re able to release your own scripts/plugins to be downloaded or bought by the community. We offer a variety of features in our store, such as reviews, versions, stats, notifications, comment section and many more! ')
@section('keywords', 'script, game, sourcemod, market, sm.market, dr. api', 'content', 'creator', 'sell', 'sale', 'puchase')

@section('og_type', 'website')
@section('twitter_card', 'summary')
@section('og_image', url('/') . '/assets/images/logos/banner.png')

@section('page', 'page-home') 
@section('content')
<!-- START @PAGE CONTENT -->
<section id="page-content">

	<!-- Start body content -->
	<div class="body-content animated fadeIn">
		<div class="row">
			<div class="col-md-12">
				<img class="img-responsive" src="/assets/images/logos/banner.png">
			</div>
		</div>
		
		<div class="panel rounded shadow">
			<div class="panel-body">

				<blockquote class="text-center text-danger" style="font-size: 25px;">
					<p><i class="fa fa-warning margin-right-5"></i>100% of your money back, no commission<i class="fa fa-warning margin-right-5"></i></p>
				</blockquote>
				
				<blockquote>
					<p><i class="fa fa-question-circle margin-right-5"></i> Are you a content creator who wants to publish his work?</p>
				</blockquote>

				<blockquote>
					<p>
					You're able to release your own scripts/plugins to be downloaded or bought by the community.
					<br>
					We offer a variety of features, such as "reviews, versions, stats, notifications, issues tracker" and many more!</p>
					<footer>If you find any bugs, or want to give some feedback then let us know.</footer>
				</blockquote>
				<div class="col-md-3">
					<a href="{{URL::route('dashboard.scripts.new')}}" class="btn btn-primary btn-block btn-lg"><i class="fa fa-code-fork margin-right-5"></i>Submit a script</a>
				</div>
				<div class="col-md-3">
					<a href="{{URL::route('dashboard.jobs.new')}}" class="btn btn-primary btn-block btn-lg"><i class="fa fa-suitcase margin-right-5"></i>Submit a job</a>
				</div>
				<blockquote class="blockquote-reverse">
					<p><i class="fa fa-rocket margin-right-5"></i>Sourcemod.Market is the best solution for you! </p>
					<small><i>Made by developers for developers</i></small>
				</blockquote>

			</div><!-- /.panel-body -->
		</div>
							
		<div class="panel panel-theme">
			<div class="panel-heading">
				<h3 class="panel-title text-center">Some random scripts</h3>
			</div>
			<div class="panel-body">
			
				@include('laravel-authentication-acl::client.scripts.single')
				
			</div><!-- /.panel-body -->
		</div>

	</div><!-- /.body-content -->
	<!--/ End body content -->

	@include('laravel-authentication-acl::client.layouts.partials.footer')
	
</section><!-- /#page-content -->
<!--/ END PAGE CONTENT -->
@endsection

@section('scripts')
	{!! Html::script('assets/admin/js/pages/blankon.home.js') !!}
@stop
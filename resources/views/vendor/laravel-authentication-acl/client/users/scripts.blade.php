@section('styles')
	{!! Html::style('assets/commercial/plugins/cube-portfolio/cubeportfolio/css/cubeportfolio.min.css') !!}
@stop

@extends('laravel-authentication-acl::client.layouts.base')

@section('title', $user->user_profile()->first()->first_name)
@section('description', $user->user_profile()->first()->first_name)
@section('keywords', str_replace(' ', ', ', $user->user_profile()->first()->first_name))
@section('og_type', 'website')
@section('twitter_card', 'website')
@section('og_image', url('/') . '/assets/images/logos/banner.png')

@section('page', 'page-users-scripts') 
@section('content')
<!-- START @PAGE CONTENT -->
<section id="page-content">

	<!-- Start page header -->
	<div class="header-content">
		<h2><i class="fa fa-user"></i> {{ $user->user_profile()->first()->first_name }}</h2>
	</div><!-- /.header-content -->
	<!--/ End page header -->

	<!-- Start body content -->
	<div class="body-content animated fadeIn">

		<div class="row" id="blog-single">

			@if (count($errors) > 0)
				<div class="alert alert-danger">
					<ul>
						@foreach($errors->all() as $error)
							<li>{{ $error }}</li>
						@endforeach
					</ul>
				</div>
			@endif
			
			<div class="col-lg-9 col-md-9 col-sm-8 col-xs-12">
				
				<div class="panel panel-tab rounded shadow">
				
					@include('laravel-authentication-acl::client.users.panel-heading')

					<!-- Start tabs content -->
					<div class="panel-body">
						<div class="tab-content">
							<div class="tab-pane fade in active" id="tab1">
								<div class="panel panel-default panel-blog rounded shadow">
									<div class="panel-body">
									@if(isset($scripts))
										@include('laravel-authentication-acl::client.scripts.single')
									@endif
									</div><!-- panel-body -->
								</div><!-- panel-blog -->
							</div>
						</div>
					</div><!-- /.panel-body -->
					<!--/ End tabs content -->
				</div><!-- /.panel -->
				
			</div>

			@include('laravel-authentication-acl::client.users.sidebar-right')

		</div><!-- row -->

	</div><!-- /.body-content -->
	<!--/ End body content -->
	
	@include('laravel-authentication-acl::client.layouts.partials.footer')

</section><!-- /#page-content -->
<!--/ END PAGE CONTENT -->
@endsection

@section('scripts')	
	{!! Html::script('assets/commercial/plugins/cube-portfolio/cubeportfolio/js/jquery.cubeportfolio.min.js') !!}
	{!! Html::script('assets/admin/js/pages/blankon.users.scripts.js') !!}
@stop
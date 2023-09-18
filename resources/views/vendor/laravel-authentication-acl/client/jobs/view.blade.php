@extends('laravel-authentication-acl::client.layouts.base')

@section('title', $job->title)
@section('description', App\Http\Classes\Word::limitWord(App\Http\Classes\Word::cleanDescription($job->description), 20))
@section('keywords', $job->tags)
@section('og_type', 'product')
@section('twitter_card', 'product')
@section('og_image', url('/') . '/assets/images/logos/banner.png')


@section('page', 'page-scripts') 
@section('content')
<!-- START @PAGE CONTENT -->
<section id="page-content">

	<!-- Start page header -->
	<div class="header-content">
		<h2><i class="fa fa-code"></i> {{ $job->title }}</h2>
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
				
				@if(!$job->activated)
					<div class="alert alert-info">
						{!! trans('front/jobs/view.info-activated') !!}
					</div>
				@endif
				
				<div class="panel panel-tab rounded shadow">
				
					@include('laravel-authentication-acl::client.jobs.panel-heading')

					<!-- Start tabs content -->
					<div class="panel-body">
						<div class="tab-content">
							<div class="tab-pane fade in active" id="tab1">
								<div class="panel panel-default panel-blog rounded shadow">
									<div class="panel-body">
										<h3 class="blog-title">{{ $job->title }}</h3>
										<ul class="blog-meta">
											<li>{{ trans('front/jobs/view.by') }}: <a href="{{ URL::route('users.view', ['id' => $job->user_id]) }}">{{ $job->user_profile->first()->first_name }}</a></li>
											<li>{{ $job->created_at->diffForHumans() }}</li>
										</ul>
										<div style="word-break: break-all;">
											{!! $job->description !!}
										</div>

									</div><!-- panel-body -->
								</div><!-- panel-blog -->
							</div>
						</div>
					</div><!-- /.panel-body -->
					<!--/ End tabs content -->
				</div><!-- /.panel -->
				
			</div>

			@include('laravel-authentication-acl::client.jobs.sidebar-right')

		</div><!-- row -->

	</div><!-- /.body-content -->
	<!--/ End body content -->
	
	@include('laravel-authentication-acl::client.layouts.partials.footer')

</section><!-- /#page-content -->
<!--/ END PAGE CONTENT -->
@endsection
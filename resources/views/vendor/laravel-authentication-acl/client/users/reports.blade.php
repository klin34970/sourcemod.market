@extends('laravel-authentication-acl::client.layouts.base')

@section('title', $user->user_profile()->first()->first_name)
@section('description', $user->user_profile()->first()->first_name)
@section('keywords', str_replace(' ', ', ', $user->user_profile()->first()->first_name))
@section('og_type', 'website')
@section('twitter_card', 'website')
@section('og_image', url('/') . '/assets/images/logos/banner.png')

@section('page', 'page-users-reports') 
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
							<div class="tab-pane fade in active" id="tab2">
								<div class="panel-body no-padding">
									<div class="line no-margin"></div><!-- /.line -->
									@foreach($user->reports()->paginate((int)config('sourcemod.market.reports_users_pagination')) as $report)
                                    <div class="media inner-all no-margin">
                                        <div class="pull-left">
                                            <img style="width:50px" src="{{ $report->user_profile->first()->presenter()->avatar('30') }}">
                                        </div><!-- /.pull-left -->
                                        <div class="media-body">
                                            <a href="{{ URL::route('users.view', $report->report_user_id) }}" class="h4">
												{{ $report->user_profile->first()->first_name }}
											</a>
                                            <small class="block text-muted">{!! $report->text !!}</small>
                                            <em class="text-xs text-muted">{{ trans('front/users/view.posted') }} <span class="text-danger">{{ $report->created_at->diffForHumans() }}</span></em>
                                        </div><!-- /.media-body -->
                                    </div><!-- /.media -->
                                    <div class="line no-margin"></div><!-- /.line -->
									@endforeach
                                </div>
								
								<div class="text-center">
									{{$user->reports()->paginate((int)config('sourcemod.market.reports_users_pagination'))->links()}}
								</div>
								
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
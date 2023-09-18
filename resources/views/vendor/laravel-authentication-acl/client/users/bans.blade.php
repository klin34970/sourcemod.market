@section('styles')
	{{ Html::style('assets/global/plugins/bower_components/bootstrap-datepicker-vitalets/css/datepicker.css') }}
	{{ Html::style('assets/global/plugins/bower_components/mjolnic-bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css') }}
	{{ Html::style('assets/global/plugins/bower_components/bootstrap-daterangepicker/daterangepicker.css') }}
@endsection

@extends('laravel-authentication-acl::client.layouts.base')

@section('title', $user->user_profile()->first()->first_name)
@section('description', $user->user_profile()->first()->first_name)
@section('keywords', str_replace(' ', ', ', $user->user_profile()->first()->first_name))
@section('og_type', 'website')
@section('twitter_card', 'website')
@section('og_image', url('/') . '/assets/images/logos/banner.png')

@section('page', 'page-users-bans') 
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

					<div class="panel-heading">
						<h3 class="panel-title">{{ trans('front/users/view.ban') }} <code>{{ $user->user_profile->first()->first_name}}</code></h3>
					</div>
					<!-- Start tabs content -->
					<div class="panel-body">
						<div class="tab-content">
							<div class="tab-pane fade in active" id="tab1">
								<div class="panel-body no-padding">
									<div class="panel-body">
									
										<table class="table">
											<tbody>
											@foreach($user->bans as $ban)
												<tr>
													<td>{!! $ban->reason !!}</td>
													<td>{{ $ban->from }}</td>
													<td>{{ $ban->to }}</td>
													<td>{{ $ban->banner->user_profile->first()->first_name }}</td>
												</tr>
											@endforeach
											</tbody>
										</table>

										<div class="form-body">
											{!! Form::model($user, [ 'url' => URL::route('users.bans', ['id' => $user->id]), 'class' => 'form-horizontal mt-10'] )  !!}
											<div class="form-group">
												{!! Form::text('date', null, ['class' => 'date-range-picker-time form-control', 'autocomplete' => 'off']) !!}
											</div>
											<div class="form-group">
												{!! Form::textarea('reason', null, ['class' => 'textarea form-control', 'autocomplete' => 'off']) !!}
											</div>
											<div class="form-footer">
												<div class="pull-right">
												{!! Form::submit(trans('front/users/view.form-button-ban'), array("class"=>"btn btn-danger")) !!}
												</div>
											</div>
											{!! Form::close() !!}
										</div>
									
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
{{ Html::script('assets/global/plugins/bower_components/bootstrap-datepicker-vitalets/js/bootstrap-datepicker.js') }}
	{{ Html::script('assets/global/plugins/bower_components/mjolnic-bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js') }}
	{{ Html::script('assets/global/plugins/bower_components/moment/min/moment.min.js') }}
	{{ Html::script('assets/global/plugins/bower_components/bootstrap-daterangepicker/daterangepicker.js') }}
	<script>
		// Date and Time
		$('.date-range-picker-time').daterangepicker({
			timePicker: true,
			timePickerIncrement: 1,
			locale: {
				format: 'YYYY-MM-DD hh:mm:ss'
			}
		});

		$('.textarea').wysihtml5({
			"stylesheets": 
			[
				"/assets/global/plugins/bower_components/bootstrap-wysihtml5/lib/css/wysiwyg-color.css", "/assets/global/plugins/bower_components/bootstrap-wysihtml5/lib/css/github.css"
			],
			//"color": true,
			"size": 'small',
			"html": true,
			"format-code": true
		});
	</script>
@endsection
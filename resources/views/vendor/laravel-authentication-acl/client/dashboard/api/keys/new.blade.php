@section('styles')
	{!! Html::style('assets/global/plugins/bower_components/chosen_v1.2.0/chosen.min.css') !!}
@stop

@extends('laravel-authentication-acl::client.layouts.base')

@section('title', trans('front/dashboard/api/keys/edit.title'))
@section('page', 'page-dashboard-scripts-api-key-edit') 

@section('navbar-left')
<li class="dropdown">
	<a href="{!! URL::route('dashboard.api.keys.new') !!}" class="dropdown-toggle">
		<i class="fa fa-edit"></i> {{ trans('front/dashboard/api/keys/edit.navbar-left-new-api-key') }}
	</a>
</li>
@endsection

@section('content')
<!-- START @PAGE CONTENT -->
<section id="page-content">

	<!-- Start page header -->
	<div class="header-content">
		<h2><i class="fa fa-pencil"></i> {{ trans('front/dashboard/api/keys/edit.header-title') }} <span>{{ trans('front/dashboard/api/keys/edit.header-title-small') }}</span></h2>
		<div class="breadcrumb-wrapper hidden-xs">
			<span class="label">{{ trans('front/dashboard/api/keys/edit.header-you-are-here') }}:</span>
			<ol class="breadcrumb">
				<li>
					<i class="fa fa-angle-right"></i>
					<a href="{!! URL::route('dashboard.index') !!}">{{ trans('front/dashboard/api/keys/edit.breadcrumb-home') }}</a>
					<i class="fa fa-angle-right"></i>
				</li>
				<li>
					<a href="{!! URL::route('dashboard.api.keys') !!}">{{ trans('front/dashboard/api/keys/edit.breadcrumb-api-keys') }}</a>
					<i class="fa fa-angle-right"></i>
				</li>
				<li class="active">{{ trans('front/dashboard/api/keys/edit.breadcrumb-active') }}</li>
			</ol>
		</div><!-- /.breadcrumb-wrapper -->
	</div><!-- /.header-content -->
	<!--/ End page header -->

	<!-- Start body content -->
	<div class="body-content animated fadeIn">

		<div class="row">
			<div class="col-md-12">
				@if (count($errors) > 0)
					<div class="alert alert-danger">
						<ul>
							@foreach($errors->all() as $error)
								<li>{{ $error }}</li>
							@endforeach
						</ul>
					</div>
				@endif

				
				<div class="panel rounded shadow">
					<div class="panel-body no-padding">

						{!! Form::model(null, [ 'url' => URL::route('dashboard.api.keys.new'), 'class' => 'form-horizontal mt-10'] )  !!}
							<div class="form-body">
								<div class="form-group">
										{!! Form::label('permissions',trans('front/dashboard/api/keys/edit.form-permissions'), ['class' => 'col-sm-2']) !!}
										<div class="col-sm-10">
										{!! Form::select('permissions[]', array(
											'tracker_scripts' => 'Tracker Scripts',
											'read_scripts' => 'Read Scripts',
										), null
										, 
										['multiple' => true, 'class' => 'chosen-select form-control', 'autocomplete' => 'off']); !!}
										</div>
									</div>
							</div><!-- /.form-body -->
							<div class="form-footer">
								<div class="col-sm-offset-2">
									<button type="submit" class="btn btn-success">{{ trans('front/dashboard/api/keys/edit.button-save') }}</button>
								</div>
							</div><!-- /.form-footer -->
						{!! Form::close() !!}

					</div><!-- /.panel-body -->
				</div>				
				
				
			</div><!-- /.col-md-12 -->
		</div><!-- /.row -->

	</div><!-- /.body-content -->
	<!--/ End body content -->
	
	@include('laravel-authentication-acl::client.layouts.partials.footer')

</section><!-- /#page-content -->
<!--/ END PAGE CONTENT -->
@endsection

@section('scripts')	
	
	{!! Html::script('assets/global/plugins/bower_components/chosen_v1.2.0/chosen.jquery.min.js') !!}
	<script>
		$('.chosen-select').chosen();
	</script>
	
@stop
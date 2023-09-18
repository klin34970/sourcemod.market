@section('styles')
	{!! Html::style('assets/global/plugins/bower_components/jasny-bootstrap-fileinput/css/jasny-bootstrap-fileinput.min.css') !!}
	{!! Html::style('assets/global/plugins/bower_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') !!}
	{!! Html::style('assets/global/plugins/bower_components/chosen_v1.2.0/chosen.min.css') !!}
@stop

@extends('laravel-authentication-acl::client.layouts.base')

@section('title', trans('front/dashboard/jobs/edit.title'))
@section('page', 'page-dashboard-scripts-edit') 

@section('navbar-left')
<li class="dropdown">
	<a href="{!! URL::route('dashboard.jobs.new') !!}" class="dropdown-toggle">
		<i class="fa fa-edit"></i> {{ trans('front/dashboard/jobs/edit.navbar-left-new-script') }}
	</a>
</li>
@endsection

@section('content')
<!-- START @PAGE CONTENT -->
<section id="page-content">

	<!-- Start page header -->
	<div class="header-content">
		<h2><i class="fa fa-pencil"></i> {{ trans('front/dashboard/jobs/edit.header-title') }} <span>{{ trans('front/dashboard/jobs/edit.header-title-small') }}</span></h2>
		<div class="breadcrumb-wrapper hidden-xs">
			<span class="label">{{ trans('front/dashboard/jobs/edit.header-you-are-here') }}:</span>
			<ol class="breadcrumb">
				<li>
					<i class="fa fa-angle-right"></i>
					<a href="{!! URL::route('dashboard.index') !!}">{{ trans('front/dashboard/jobs/edit.breadcrumb-home') }}</a>
					<i class="fa fa-angle-right"></i>
				</li>
				<li>
					<a href="{!! URL::route('dashboard.scripts') !!}">{{ trans('front/dashboard/jobs/edit.breadcrumb-scripts') }}</a>
					<i class="fa fa-angle-right"></i>
				</li>
				<li class="active">{{ trans('front/dashboard/jobs/edit.breadcrumb-active') }}</li>
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
				<!-- Start basic wizard vertical -->
				<div id="script-edit">
					<div class="panel panel-tab panel-tab-double panel-tab-vertical row no-margin rounded shadow">
						<!-- Start tabs heading -->
						<div class="panel-heading no-padding col-md-3">
							<ul class="nav nav-tabs">
								<li class="active">
									<a href="#tab1" data-toggle="tab">
										<i class="fa fa-pencil"></i>
										<div>
											<span class="text-strong">{{ trans('front/dashboard/jobs/edit.form-step1') }}</span>
											<span>{{ trans('front/dashboard/jobs/edit.form-step1-title') }}</span>
										</div>
									</a>
								</li>
								<li>
									<a href="#tab2" data-toggle="tab">
										<i class="fa fa-dollar"></i>
										<div>
											<span class="text-strong">{{ trans('front/dashboard/jobs/edit.form-step2') }}</span>
											<span>{{ trans('front/dashboard/jobs/edit.form-step2-title') }}</span>
										</div>
									</a>
								</li>
								<li>
									<a href="#tab100" data-toggle="tab">
										<i class="fa fa-check-circle"></i>
										<div>
											<span class="text-strong">{{ trans('front/dashboard/jobs/edit.form-step100') }}</span>
											<span>{{ trans('front/dashboard/jobs/edit.form-step100-title') }}</span>
										</div>
									</a>
								</li>
							</ul>
						</div><!-- /.panel-heading -->
						<!--/ End tabs heading -->

						<!-- Start tabs content -->
						<div class="panel-body col-md-9">
							{!! Form::model(null, [ 'url' => URL::route('dashboard.jobs.new'), 'class' => 'tab-content form-horizontal'] )  !!}
								<div class="tab-pane fade in active inner-all" id="tab1">
									<h4 class="page-header">{{ trans('front/dashboard/jobs/edit.form-step1-title') }}</h4>
									<div class="form-group">
										{!! Form::label('title', trans('front/dashboard/jobs/edit.form-title'), ['class' => 'col-sm-2']) !!}
										<div class="col-sm-10">
											{!! Form::text('title', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
										</div>
									</div>
									<div class="form-group">
										{!! Form::label('description',trans('front/dashboard/jobs/edit.form-description'), ['class' => 'col-sm-2']) !!}
										<div class="col-sm-10">
											{!! Form::textarea('description', null, ['data-provide' => 'markdown','class' => 'textarea form-control', 'autocomplete' => 'off']) !!}
										</div>
									</div>
									<div class="form-group">
										{!! Form::label('game_id',trans('front/dashboard/jobs/edit.form-games'), ['class' => 'col-sm-2']) !!}
										<div class="col-sm-10">
										{!! Form::select('game_id', $games, null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
										</div>
									</div>
									<div class="form-group">
										{!! Form::label('tags',trans('front/dashboard/jobs/edit.form-tags'), ['class' => 'col-sm-2']) !!}
										<div class="col-sm-10">
											{!! Form::text('tags', null, ['data-role' => 'tagsinput', 'class' => 'form-control', 'autocomplete' => 'off']) !!}
											<span class="help-block">{{ trans('front/dashboard/jobs/edit.help-tags')}} </span>
										</div>
									</div><!-- /.form-group -->
								</div>
								<div class="tab-pane fade inner-all" id="tab2">
									<h4 class="page-header">{{ trans('front/dashboard/jobs/edit.form-step2-title') }}</h4>
									<div class="form-group">
										{!! Form::label('price',trans('front/dashboard/jobs/edit.form-price'), ['class' => 'col-sm-2']) !!}
										<div class="col-sm-10">
											<div class="input-group mb-15">
												<span class="input-group-addon bg-success">$</span>
												{!! Form::number('price', null, ['class' => 'form-control', 'autocomplete' => 'off', 'min' => '0', 'max' => '100', 'step' => '0.50', 'onchange' => 'checkPrice()']) !!}
											</div>
										</div>
									</div>
								</div>							
								<div class="tab-pane fade inner-all" id="tab100">
									<h4 class="page-header">{{ trans('front/dashboard/jobs/edit.form-step100-title') }}</h4>
									<div class="ml-10">
									<p>
									{{ trans('front/dashboard/jobs/edit.form-step100-text') }}
									</p>
									</div>
									{!! Form::submit(trans('front/dashboard/jobs/edit.form-button-save'), array("class"=>"btn btn-success ml-10")) !!}
								</div>			
							{!! Form::close() !!}
							<!-- Start pager -->
							<div class="panel-footer no-bg">
								<ul class="pager wizard no-margin">
									<li class="previous"><a href="javascript:void(0);">Previous</a></li>
									<li class="next"><a href="javascript:void(0);">Next</a></li>
								</ul>
							</div>
							<!--/ End pager -->
						</div><!-- /.panel-body -->
						<!--/ End tabs content -->
					</div><!-- /.panel -->
				</div><!-- /#basic-wizard-vertical -->
				<!--/ End basic wizard vertical-->

			</div><!-- /.col-md-12 -->
		</div><!-- /.row -->

	</div><!-- /.body-content -->
	<!--/ End body content -->
	
	@include('laravel-authentication-acl::client.layouts.partials.footer')

</section><!-- /#page-content -->
<!--/ END PAGE CONTENT -->
@endsection

@section('scripts')	
	{!! Html::script('assets/global/plugins/bower_components/jquery-validation/dist/jquery.validate.min.js') !!}
	{!! Html::script('assets/global/plugins/bower_components/twitter-bootstrap-wizard/jquery.bootstrap.wizard.min.js') !!}
	{!! Html::script('assets/global/plugins/bower_components/jasny-bootstrap-fileinput/js/jasny-bootstrap.fileinput.min.js') !!}
	{!! Html::script('assets/global/plugins/bower_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') !!}
	{!! Html::script('assets/global/plugins/bower_components/chosen_v1.2.0/chosen.jquery.min.js') !!}
	<script>
		$('.chosen-select').chosen();
		$('#script-edit').bootstrapWizard();
		$('.textarea').wysihtml5({
			"stylesheets": 
			[
				"/assets/global/plugins/bower_components/bootstrap-wysihtml5/lib/css/wysiwyg-color.css", "/assets/global/plugins/bower_components/bootstrap-wysihtml5/lib/css/github.css"
			],
			//"color": true,
			"size": 'small',
			"html": true,
			"format-code": true,
		});
	</script>
	
@stop
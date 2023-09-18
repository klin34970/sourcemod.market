@section('styles')
	{!! Html::style('assets/global/plugins/bower_components/jasny-bootstrap-fileinput/css/jasny-bootstrap-fileinput.min.css') !!}
@stop

@extends('laravel-authentication-acl::client.layouts.base')

@section('title', trans('front/dashboard/scripts/versions/edit.title'))
@section('page', 'page-dashboard-scripts-versions-edit') 

@section('content')
<!-- START @PAGE CONTENT -->
<section id="page-content">

	<!-- Start page header -->
	<div class="header-content">
		<h2><i class="fa fa-pencil"></i> {{ trans('front/dashboard/scripts/versions/edit.header-title') }} <span>{{ trans('front/dashboard/scripts/versions/edit.header-title-small') }}</span></h2>
		<div class="breadcrumb-wrapper hidden-xs">
			<span class="label">{{ trans('front/dashboard/scripts/versions/edit.header-you-are-here') }}:</span>
			<ol class="breadcrumb">
				<li>
					<i class="fa fa-angle-right"></i>
					<a href="{!! URL::route('dashboard.index') !!}">{{ trans('front/dashboard/scripts/versions/edit.breadcrumb-home') }}</a>
					<i class="fa fa-angle-right"></i>
				</li>
				<li>
					<a href="{!! URL::route('dashboard.scripts') !!}">{{ trans('front/dashboard/scripts/versions/edit.breadcrumb-scripts') }}</a>
					<i class="fa fa-angle-right"></i>
				</li>
				<li class="active">{{ trans('front/dashboard/scripts/versions/edit.breadcrumb-active') }}</li>
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
							@foreach ($errors->all() as $error)
								<li>{{ $error }}</li>
							@endforeach
						</ul>
					</div>
				@endif
				<div id="script-version-edit">
					<div class="panel rounded shadow">
						<div class="panel-heading">
							<div class="pull-left">
								<h3 class="panel-title">{{ trans('front/dashboard/scripts/versions/edit.panel-title') }}</h3>
							</div>
							<div class="clearfix"></div>
						</div><!-- /.panel-heading -->
						<div class="panel-body no-padding">
							{!! Form::model($script, [ 'url' => URL::route('dashboard.scripts.versions.new', ['script_id' => $script->id]), 'files'=>true, 'class' => 'form-horizontal mt-10'] )  !!}
								<div class="form-body">
									<div class="form-group">
										{!! Form::label('name', trans('front/dashboard/scripts/versions/edit.form-name'), ['class' => 'col-sm-2']) !!}
										<div class="col-sm-10">
											{!! Form::text('name', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
										</div>
									</div><!-- /.form-group -->
									<div class="form-group">
										{!! Form::label('changes',trans('front/dashboard/scripts/versions/edit.form-changes'), ['class' => 'col-sm-2']) !!}
										<div class="col-sm-10">
											{!! Form::textarea('changes', null, ['class' => 'textarea form-control', 'autocomplete' => 'off']) !!}
										</div>
									</div>
									<div class="form-group">
										{!! Form::label('file',trans('front/dashboard/scripts/versions/edit.form-file'), ['class' => 'col-sm-2']) !!}
										<div class="col-md-10">
											<div class="fileinput fileinput-new input-group" data-provides="fileinput">
												<div class="form-control" data-trigger="fileinput"><i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div>
												<span class="input-group-addon btn btn-success btn-file">
												<span class="fileinput-new">Select file</span>
												<span class="fileinput-exists">Change</span>
												{!! Form::file('file') !!}
												</span>
												<a href="#" class="input-group-addon btn btn-danger fileinput-exists" data-dismiss="fileinput">Remove</a>
											</div>
										</div>
									</div><!-- /.form-group -->
								</div><!-- /.form-body -->
								<div class="form-footer">
									<div class="col-sm-offset-3">
										{!! Form::submit(trans('front/dashboard/scripts/versions/edit.form-button-save'), array("class"=>"btn btn-success")) !!}
									</div>
								</div><!-- /.form-footer -->
							{!! Form::close() !!}

						</div><!-- /.panel-body -->
					</div>
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
	{!! Html::script('assets/global/plugins/bower_components/jquery-validation/dist/jquery.validate.min.js') !!}
	{!! Html::script('assets/global/plugins/bower_components/jasny-bootstrap-fileinput/js/jasny-bootstrap.fileinput.min.js') !!}
	<script>
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
@stop
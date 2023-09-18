@section('styles')
	{!! Html::style('http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700') !!}
	
    {!! Html::style('assets/global/plugins/bower_components/bootstrap/dist/css/bootstrap.min.css') !!}
    {!! Html::style('assets/global/plugins/bower_components/fontawesome/css/font-awesome.min.css') !!}
    {!! Html::style('assets/global/plugins/bower_components/animate.css/animate.min.css') !!}
	
	{!! Html::style('assets/admin/css/reset.css') !!}
	{!! Html::style('assets/admin/css/layout.css') !!}
	{!! Html::style('assets/admin/css/components.css') !!}
	{!! Html::style('assets/admin/css/plugins.css') !!}
	{!! Html::style('assets/admin/css/themes/default.theme.css', ['id'=>'theme']) !!}
	{!! Html::style('assets/admin/css/custom.css') !!}
@stop

@extends('laravel-authentication-acl::admin.layouts.base')

@if(isset($user->id))
	@section('title', trans('admin/permissions/edit.title-edit')) 
@else
	@section('title', trans('admin/permissions/edit.title-add')) 
@endif

@section('page', 'page-permissions-edit') 


@section('content')
<!-- START @PAGE CONTENT -->
<section id="page-content">

	<!-- Start page header -->
	<div class="header-content">
		<h2>
			{!! isset($group->id) ? trans('admin/permissions/edit.header-title-edit') : trans('admin/permissions/edit.header-title-add') !!}
		</h2>
		<div class="breadcrumb-wrapper hidden-xs">
			<span class="label">{{ trans('admin/permissions/edit.header-you-are-here') }} :</span>
			<ol class="breadcrumb">
				<li>
					<i class="fa fa-home"></i>
					<a href="{!! URL::route('dashboard.default') !!}">{{ trans('admin/permissions/edit.breadcrumb-home') }}</a>
					<i class="fa fa-angle-right"></i>
				</li>
				<li>
					<a href="#">{{ trans('admin/permissions/edit.breadcrumb-permission') }}</a>
					<i class="fa fa-angle-right"></i>
				</li>
				<li class="active">{!! isset($group->id) ? trans('admin/permissions/edit.breadcrumb-active-edit') : trans('admin/permissions/edit.breadcrumb-active-add') !!}</li>
			</ol>
		</div><!-- /.breadcrumb-wrapper -->
	</div><!-- /.header-content -->
	<!--/ End page header -->

                <!-- Start body content -->
                <div class="body-content animated fadeIn">
				
                    <div class="row">
						<div class="panel panel-theme">
							<div class="panel-heading">
								<h3 class="panel-title">{{ trans('admin/permissions/edit.panel-title-1') }}</h3>
							</div><!-- /.panel-heading -->
							<div class="panel-body">
								{!! Form::model($permission, [ 'url' => [URL::route('permission.edit'), $permission->id], 'method' => 'post'] )  !!}
								<!-- description text field -->
								<div class="form-group">
									{!! Form::label('description', trans('admin/permissions/edit.form-label-description')) !!}
									{!! Form::text('description', null, ['class' => 'form-control', 'placeholder' => trans('admin/permissions/edit.form-placeholder-description'), 'id' => 'slugme']) !!}
								</div>
								<span class="text-danger">{!! $errors->first('description') !!}</span>
								<!-- permission text field -->
								<div class="form-group">
									{!! Form::label('permission',trans('admin/permissions/edit.form-label-permission')) !!}
									{!! Form::text('permission', null, ['class' => 'form-control', 'placeholder' => trans('admin/permissions/edit.form-placeholder-permission'), 'id' => 'slug']) !!}
								</div>
								<span class="text-danger">{!! $errors->first('permission') !!}</span>
								{!! Form::hidden('id') !!}
								<a href="{!! URL::route('permission.delete',['id' => $permission->id, '_token' => csrf_token()]) !!}" class="btn btn-danger pull-right margin-left-5 delete">{{ trans('admin/permissions/edit.form-button-delete') }}</a>
								{!! Form::submit(trans('admin/permissions/edit.form-button-save'), array("class"=>"btn btn-info pull-right ")) !!}
								{!! Form::close() !!}
							</div><!-- /.panel-body -->
						</div>
                    </div><!-- /.row -->

                </div><!-- /.body-content -->
                <!--/ End body content -->

</section><!-- /#page-content -->
<!--/ END PAGE CONTENT -->
@endsection

@section('scripts')	
	{!! Html::script('assets/global/plugins/bower_components/jquery/dist/jquery.min.js') !!}
	{!! Html::script('assets/global/plugins/bower_components/jquery-cookie/jquery.cookie.js') !!}
	{!! Html::script('assets/global/plugins/bower_components/bootstrap/dist/js/bootstrap.min.js') !!}
	{!! Html::script('assets/global/plugins/bower_components/jquery-easing-original/jquery.easing.1.3.min.js') !!}
	{!! Html::script('assets/global/plugins/bower_components/ionsound/js/ion.sound.min.js') !!}
	{!! Html::script('assets/global/plugins/bower_components/retina.js/dist/retina.min.js') !!}
	{!! Html::script('assets/global/plugins/bower_components/typehead.js/dist/handlebars.js') !!}
	{!! Html::script('assets/global/plugins/bower_components/typehead.js/dist/typeahead.bundle.min.js') !!}
	{!! Html::script('assets/global/plugins/bower_components/jquery-nicescroll/jquery.nicescroll.min.js') !!}
	{!! Html::script('assets/global/plugins/bower_components/jquery.sparkline.min/index.js') !!}
	{!! Html::script('assets/global/plugins/bower_components/bootbox/bootbox.js') !!}
	{!! Html::script('assets/global/plugins/bower_components/slug/slugit.js') !!}
	{!! Html::script('assets/admin/js/apps.js') !!}
	{!! Html::script('assets/admin/js/demo.js') !!}
	<script>
		$(".delete").click(function(){
			return confirm('{!! trans("admin/permissions/edit.confirm-delete") !!}');
		});
		$(function(){
			$('#slugme').slugIt();
		});
	</script>
	
@stop
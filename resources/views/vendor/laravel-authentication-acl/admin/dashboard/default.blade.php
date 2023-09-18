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

@section('title', trans('admin/dashboard/dashboard.title'))
@section('page', 'page-dashboard')

@section('content')

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
	{!! Html::script('assets/admin/js/apps.js') !!}
	{!! Html::script('assets/admin/js/demo.js') !!}
@stop
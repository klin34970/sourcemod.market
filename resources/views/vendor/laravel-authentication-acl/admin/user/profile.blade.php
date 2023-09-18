@section('styles')
	{!! Html::style('http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700') !!}
	
    {!! Html::style('assets/global/plugins/bower_components/bootstrap/dist/css/bootstrap.min.css') !!}
    {!! Html::style('assets/global/plugins/bower_components/fontawesome/css/font-awesome.min.css') !!}
    {!! Html::style('assets/global/plugins/bower_components/animate.css/animate.min.css') !!}
	
	{!! Html::style('assets/global/plugins/bower_components/jasny-bootstrap-fileinput/css/jasny-bootstrap-fileinput.min.css') !!}
	
	{!! Html::style('assets/admin/css/reset.css') !!}
	{!! Html::style('assets/admin/css/layout.css') !!}
	{!! Html::style('assets/admin/css/components.css') !!}
	{!! Html::style('assets/admin/css/plugins.css') !!}
	{!! Html::style('assets/admin/css/themes/default.theme.css', ['id'=>'theme']) !!}
	{!! Html::style('assets/admin/css/custom.css') !!}
@stop

@extends('laravel-authentication-acl::admin.layouts.base')

@section('title', trans('admin/users/profile.title'))
@section('page', 'page-users-profile') 

@section('content')
<!-- START @PAGE CONTENT -->
            <section id="page-content">

                <!-- Start page header -->
                <div class="header-content">
                    <h2><i class="fa fa-user"></i> {{ trans('admin/users/profile.header-title') }}</h2>
                    <div class="breadcrumb-wrapper hidden-xs">
                        <span class="label">{{ trans('admin/users/profile.header-you-are-here') }}:</span>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-home"></i>
                                <a href="{!! URL::route('dashboard.default') !!}">{{ trans('admin/users/profile.header-breadcrumb-home') }}</a>
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                <a href="#">{{ trans('admin/users/profile.header-breadcrumb-user') }}</a>
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li class="active">{{ trans('admin/users/profile.header-breadcrumb-active') }}</li>
                        </ol>
                    </div><!-- /.breadcrumb-wrapper -->
                </div><!-- /.header-content -->
                <!--/ End page header -->

                <!-- Start body content -->
                <div class="body-content animated fadeIn">
				
                    <div class="row">
                        <div class="col-md-6 col-xs-12">
							<div class="panel panel-theme">
                                <div class="panel-heading">
                                    <h3 class="panel-title">{{ trans('admin/users/profile.panel-title-1') }}</h3>
                                </div><!-- /.panel-heading -->
                                <div class="panel-body">
									@if(! $use_gravatar)
									{!! Form::open(['route' => 'users.profile.changeavatar', 'method' => 'POST', 'files' => true]) !!}
									<div class="form-group">
										<h4><i class="fa fa-picture-o"></i> {{ trans('admin/users/profile.form-avatar') }}</h4>
										<div class="fileinput fileinput-new" data-provides="fileinput">
											<div class="fileinput-new thumbnail" style="width: 200px;">
												<img src="{!! $user_profile->presenter()->avatar !!}" alt="...">
											</div>
											<div class="fileinput-preview fileinput-exists thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;"></div>
											<div>
												<span class="btn btn-primary btn-file">
													<span class="fileinput-new">{{ trans('admin/users/profile.form-avatar-select') }}</span>
													<span class="fileinput-exists">{{ trans('admin/users/profile.form-avatar-change') }}</span><input type="file" name="avatar">
												</span>
												<a href="#" class="btn btn-danger fileinput-exists" data-dismiss="fileinput">{{ trans('admin/users/profile.form-avatar-delete') }}</a>
												{!! Form::submit(trans('admin/users/profile.form-avatar-update'), ['class' => 'btn btn-success']) !!}
											</div>
										</div>
									</div><!-- /.form-group -->
									{!! Form::hidden('user_id', $user_profile->user_id) !!}
									{!! Form::hidden('user_profile_id', $user_profile->id) !!}
									<div class="form-group">
										
									</div>
									{!! Form::close() !!}
									@endif
									<h4><i class="fa fa-cubes"></i> {{ trans('admin/users/profile.form-user-data') }}</h4>
									{!! Form::model($user_profile,['route'=>'users.profile.edit', 'method' => 'post']) !!}
									<!-- code text field -->
									<div class="form-group">
										{!! Form::label('code', trans('admin/users/profile.form-label-user-code')) !!}
										{!! Form::text('code', null, ['class' => 'form-control', 'placeholder' => '']) !!}
									</div>
									<span class="text-danger">{!! $errors->first('code') !!}</span>
									<!-- first_name text field -->
									<div class="form-group">
										{!! Form::label('first_name', trans('admin/users/profile.form-label-user-firstname')) !!}
										{!! Form::text('first_name', null, ['class' => 'form-control', 'placeholder' => '']) !!}
									</div>
									<span class="text-danger">{!! $errors->first('first_name') !!}</span>
									<!-- last_name text field -->
									<div class="form-group">
										{!! Form::label('last_name', trans('admin/users/profile.form-label-user-lastname')) !!}
										{!! Form::text('last_name', null, ['class' => 'form-control', 'placeholder' => '']) !!}
									</div>
									<span class="text-danger">{!! $errors->first('last_name') !!}</span>
									<!-- phone text field -->
									<div class="form-group">
										{!! Form::label('phone', trans('admin/users/profile.form-label-user-phone')) !!}
										{!! Form::text('phone', null, ['class' => 'form-control', 'placeholder' => '']) !!}
									</div>
									<span class="text-danger">{!! $errors->first('phone') !!}</span>
									<!-- state text field -->
									<div class="form-group">
										{!! Form::label('state', trans('admin/users/profile.form-label-user-state')) !!}
										{!! Form::text('state', null, ['class' => 'form-control', 'placeholder' => '']) !!}
									</div>
									<span class="text-danger">{!! $errors->first('state') !!}</span>
									<!-- var text field -->
									<div class="form-group">
										{!! Form::label('var', trans('admin/users/profile.form-label-user-vat')) !!}
										{!! Form::text('var', null, ['class' => 'form-control', 'placeholder' => '']) !!}
									</div>
									<span class="text-danger">{!! $errors->first('vat') !!}</span>
									<!-- city text field -->
									<div class="form-group">
										{!! Form::label('city', trans('admin/users/profile.form-label-user-city')) !!}
										{!! Form::text('city', null, ['class' => 'form-control', 'placeholder' => '']) !!}
									</div>
									<span class="text-danger">{!! $errors->first('city') !!}</span>
									<!-- country text field -->
									<div class="form-group">
										{!! Form::label('country', trans('admin/users/profile.form-label-user-country')) !!}
										{!! Form::text('country', null, ['class' => 'form-control', 'placeholder' => '']) !!}
									</div>
									<span class="text-danger">{!! $errors->first('country') !!}</span>
									<!-- zip text field -->
									<div class="form-group">
										{!! Form::label('zip', trans('admin/users/profile.form-label-user-zip')) !!}
										{!! Form::text('zip', null, ['class' => 'form-control', 'placeholder' => '']) !!}
									</div>
									<span class="text-danger">{!! $errors->first('zip') !!}</span>
									<!-- address text field -->
									<div class="form-group">
										{!! Form::label('address', trans('admin/users/profile.form-label-user-address')) !!}
										{!! Form::text('address', null, ['class' => 'form-control', 'placeholder' => '']) !!}
									</div>
									<span class="text-danger">{!! $errors->first('address') !!}</span>
									{{-- custom profile fields --}}
									@foreach($custom_profile->getAllTypesWithValues() as $profile_data)
									<div class="form-group">
										{!! Form::label(trans(strtolower("admin/users/profile.form-label-user-{$profile_data->description}"))) !!}
										{!! Form::text("custom_profile_{$profile_data->id}", $profile_data->value, ["class" => "form-control"]) !!}
										{{-- delete field --}}
									</div>
									@endforeach

									{!! Form::hidden('user_id', $user_profile->user_id) !!}
									{!! Form::hidden('id', $user_profile->id) !!}
									{!! Form::submit(trans('admin/users/profile.form-button-save') ,['class' =>'btn btn-info pull-right margin-bottom-30']) !!}
									{!! Form::close() !!}
                                </div><!-- /.panel-body -->
                            </div>

                        </div>
						@if($can_add_fields)
                        <div class="col-md-6 col-xs-12">
							<div class="panel panel-theme">
                                <div class="panel-heading">
                                    <h3 class="panel-title">{{ trans('admin/users/profile.form-custom-fields') }}</h3>
                                </div><!-- /.panel-heading -->
                                <div class="panel-body">
									{{-- add fields --}}
									{!! Form::open(["route" => 'users.profile.addfield', 'class' => 'form-add-profile-field', 'role' => 'form']) !!}
									<div class="form-group">
										<div class="input-group">
											<span class="input-group-addon form-button button-add-profile-field"><span class="glyphicon glyphicon-plus-sign add-input"></span></span>
											{!! Form::text('description','',['class' =>'form-control','placeholder' => trans('admin/users/profile.form-placeholder-custom-fields')]) !!}
											{!! Form::hidden('user_id',$user_profile->user_id) !!}
										</div>
									</div>
									{!! Form::close() !!}

									{{-- delete fields --}}
									@foreach($custom_profile->getAllTypesWithValues() as $profile_data)
									{!! Form::open(["route" => 'users.profile.deletefield', 'name' => $profile_data->id, 'role' => 'form']) !!}
									<div class="form-group">
										<div class="input-group">
											<span class="input-group-addon form-button button-del-profile-field" name="{!! $profile_data->id !!}"><span
														class="glyphicon glyphicon-minus-sign add-input"></span></span>
											{!! Form::text('profile_description', $profile_data->description, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
											{!! Form::hidden('id', $profile_data->id) !!}
											{!! Form::hidden('user_id',$user_profile->user_id) !!}
										</div>
									</div>
									{!! Form::close() !!}
									@endforeach
                                </div><!-- /.panel-body -->
                            </div>
                        </div>
						@endif
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
	{!! Html::script('assets/global/plugins/bower_components/jasny-bootstrap-fileinput/js/jasny-bootstrap.fileinput.min.js') !!}
	{!! Html::script('assets/admin/js/apps.js') !!}
	{!! Html::script('assets/admin/js/demo.js') !!}
	<script>
		$(".button-add-profile-field").click(function () {
			$('.form-add-profile-field').submit();
		});
		$(".button-del-profile-field").click(function () {
			if (!confirm('{!! trans("admin/users/profile.confirm-delete-custom-fields")!!}')) return;

			// submit the form with the same name
			name = $(this).attr('name');
			$('form[name=' + name + ']').submit();
		});
	</script>
@parent
@stop
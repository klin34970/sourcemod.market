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
	@section('title', trans('admin/users/edit.title-edit')) 
@else
	@section('title', trans('admin/users/edit.title-add')) 
@endif
	


@section('page', 'page-users-edit')

@section('content')
<!-- START @PAGE CONTENT -->
            <section id="page-content">

                <!-- Start page header -->
                <div class="header-content">
                    <h2>
					{!! isset($user->id) ? trans("admin/users/edit.header-title-edit") : trans("admin/users/edit.header-title-add") !!}
					</h2>
                    <div class="breadcrumb-wrapper hidden-xs">
                        <span class="label">{{ trans('admin/users/edit.header-you-are-here') }}:</span>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-home"></i>
                                <a href="{!! URL::route('dashboard.default') !!}">{{ trans('admin/users/edit.header-breadcrumb-home') }}</a>
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                <a href="#">{{ trans('admin/users/edit.header-breadcrumb-users') }}</a>
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li class="active">{!! isset($user->id) ? trans('admin/users/edit.header-breadcrumb-active-edit') : trans('admin/users/edit.header-breadcrumb-active-add') !!}</li>
                        </ol>
                    </div><!-- /.breadcrumb-wrapper -->
                </div><!-- /.header-content -->
                <!--/ End page header -->

                <!-- Start body content -->
                <div class="body-content animated fadeIn">
				
                    <div class="row">
                        <div class="col-md-12">

                            <!-- Start basic wizard horizontal -->
                            <div id="basic-wizard-horizontal">
                                <div class="panel panel-tab rounded shadow">
                                    <!-- Start tabs heading -->
                                    <div class="panel-heading no-padding">
                                        <ul class="nav nav-tabs">
                                            <li class="active">
                                                <a href="#tab1-1" data-toggle="tab">
                                                    <i class="fa fa-pencil"></i>
                                                    <div>
                                                        <span class="text-strong">{{ trans('admin/users/edit.form-step-1') }}</span>
                                                        <span>{{ trans('admin/users/edit.form-step-1-title') }}</span>
                                                    </div>
                                                </a>
                                            </li>
											<li>
                                                <a href="#tab1-2" data-toggle="tab">
                                                    <i class="fa fa-group"></i>
                                                    <div>
                                                        <span class="text-strong">{{ trans('admin/users/edit.form-step-2') }}</span>
                                                        <span>{{ trans('admin/users/edit.form-step-2-title') }}</span>
                                                    </div>
                                                </a>
                                            </li>
											<li>
                                                <a href="#tab1-3" data-toggle="tab">
                                                    <i class="fa fa-gears"></i>
                                                    <div>
                                                        <span class="text-strong">{{ trans('admin/users/edit.form-step-3') }}</span>
                                                        <span>{{ trans('admin/users/edit.form-step-3-title') }}</span>
                                                    </div>
                                                </a>
                                            </li>
                                        </ul>
                                    </div><!-- /.panel-heading -->
                                    <!--/ End tabs heading -->

                                    <!-- Start tabs content -->
                                    <div class="panel-body">
										<div class="tab-content form-horizontal">
											<div class="tab-pane fade in active inner-all" id="tab1-1">
												<h4 class="page-header">{{ trans('admin/users/edit.form-step-1-title') }}</h4>
												{!! Form::model($user, [ 'url' => URL::route('users.edit'), 'class' => ''] )  !!}
												{!! Form::password('__to_hide_password_autocomplete', ['class' => 'hidden']) !!}
												<div class="form-group">
													{!! Form::label('email',trans('admin/users/edit.form-label-email'), ['class' => 'col-sm-2']) !!}
													<div class="col-sm-4">
														{!! Form::text('email', null, ['class' => 'form-control', 'placeholder' => trans('admin/users/edit.form-placeholder-email'), 'autocomplete' => 'off']) !!}
														@if($errors->first('email'))
														<label class="error" style="display: inline-block;">{!! $errors->first('email') !!}</label>
														@endif
													</div>
												</div>
												<div class="form-group">
													{!! Form::label('password',isset($user->id) ? trans('admin/users/edit.form-label-change-password') : trans('admin/users/edit.form-label-password'), ['class' => 'col-sm-2']) !!}
													<div class="col-sm-4">
														{!! Form::password('password', ['class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => '']) !!}
														@if($errors->first('password'))
														<label class="error" style="display: inline-block;">{!! $errors->first('password') !!}</label>
														@endif
													</div>
												</div>
												<div class="form-group">
													{!! Form::label('password_confirmation',isset($user->id) ? trans('admin/users/edit.form-label-confirm-password-change') : trans('admin/users/edit.form-label-confirm-password'), ['class' => 'col-sm-2']) !!}
													<div class="col-sm-4">
														{!! Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => '','autocomplete' => 'off']) !!}
														@if($errors->first('password_confirmation'))
														<label class="error" style="display: inline-block;">{!! $errors->first('password_confirmation') !!}</label>
														@endif
													</div>
												</div>
												<div class="form-group">
													{!! Form::label("activated", trans('admin/users/edit.form-label-user-active'), ['class' => 'col-sm-2']) !!}
													<div class="col-sm-4">
														{!! Form::select('activated', ["1" => trans('admin/users/edit.form-yes'), "0" => trans('admin/users/edit.form-no')], (isset($user->activated) && $user->activated) ? $user->activated : "0", ["class"=> "form-control"] ) !!}
													</div>
												</div>
												<div class="form-group">
													{!! Form::label("banned", trans('admin/users/edit.form-label-user-banned'), ['class' => 'col-sm-2']) !!}
													<div class="col-sm-4">
														{!! Form::select('banned', ["1" => trans('admin/users/edit.form-yes'), "0" => trans('admin/users/edit.form-no')], (isset($user->banned) && $user->banned) ? $user->banned : "0", ["class"=> "form-control"] ) !!}
													</div>
												</div>
												{!! Form::submit(trans('admin/users/edit.form-button-save'), array("class"=>"btn btn-success ml-10")) !!}
										
												{!! Form::hidden('id') !!}
												{!! Form::hidden('form_name','user') !!}
					
												{!! Form::close() !!}
											</div>
											
											<div class="tab-pane fade inner-all" id="tab1-2">
												<h4 class="page-header">{{ trans('admin/users/edit.form-step-2-title') }}</h4>
												{!! Form::open(["route" => "users.groups.add", 'class' => 'form-add-group', 'role' => 'form']) !!}
												<div class="form-group">
													<div class="input-group">
														<span class="input-group-addon form-button button-add-group"><span class="glyphicon glyphicon-plus-sign add-input"></span></span>
														{!! Form::select('group_id', $group_values, '', ["class"=>"form-control"]) !!}
														{!! Form::hidden('id', $user->id) !!}
													</div>
												</div>
												{!! Form::hidden('id', $user->id) !!}
												@if(! $user->exists)
												<div class="form-group">
													<span class="text-danger"><h5>{{ trans('admin/users/edit.form-create-user-first') }}</h5></span>
												</div>
												@endif
												{!! Form::close() !!}
												
												@if( ! $user->groups->isEmpty() )
												@foreach($user->groups as $group)
													{!! Form::open(["route" => "users.groups.delete", "role"=>"form", 'name' => $group->id]) !!}
													<div class="form-group">
														<div class="input-group">
															<span class="input-group-addon form-button button-del-group" name="{!! $group->id !!}"><span class="glyphicon glyphicon-minus-sign add-input"></span></span>
															{!! Form::text('group_name', $group->name, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
															{!! Form::hidden('id', $user->id) !!}
															{!! Form::hidden('group_id', $group->id) !!}
														</div>
													</div>
													{!! Form::close() !!}
												@endforeach
												@elseif($user->exists)
													<span class="text-warning"><h5>{{ trans('admin/users/edit.form-user-no-group') }}</h5></span>
												@endif												
												
											</div>
											
											<div class="tab-pane fade inner-all" id="tab1-3">
												<h4 class="page-header">{{ trans('admin/users/edit.form-step-3-title') }}</h4>
												{!! Form::open(["route" => "users.edit.permission","role"=>"form", 'class' => 'form-add-perm']) !!}
												<div class="form-group">
													<div class="input-group">
														<span class="input-group-addon form-button button-add-perm"><span class="glyphicon glyphicon-plus-sign add-input"></span></span>
														{!! Form::select('permissions', $permission_values, '', ["class"=>"form-control permission-select"]) !!}
													</div>
													<span class="text-danger">{!! $errors->first('permissions') !!}</span>
													{!! Form::hidden('id', $user->id) !!}
													{{-- add permission operation --}}
													{!! Form::hidden('operation', 1) !!}
												</div>
												@if(! $user->exists)
												<div class="form-group">
													<span class="text-danger"><h5>{{ trans('admin/users/edit.form-create-user-first') }}</span>
												</div>
												@endif
												{!! Form::close() !!}
												
												@if( $presenter->permissions )
												@foreach($presenter->permissions_obj as $permission)
												{!! Form::open(["route" => "users.edit.permission", "name" => $permission->permission, "role"=>"form"]) !!}
												<div class="form-group">
													<div class="input-group">
														<span class="input-group-addon form-button button-del-perm" name="{!! $permission->permission !!}"><span class="glyphicon glyphicon-minus-sign add-input"></span></span>
														{!! Form::text('permission_desc', $permission->description, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
														{!! Form::hidden('permissions', $permission->permission) !!}
														{!! Form::hidden('id', $user->id) !!}
														{{-- add permission operation --}}
														{!! Form::hidden('operation', 0) !!}
													</div>
												</div>
												{!! Form::close() !!}
												@endforeach
												@elseif($user->exists)
												<span class="text-warning"><h5>{{ trans('admin/users/edit.form-user-no-perms') }}</h5></span>
												@endif
												
											</div>
										</div>
                                    </div><!-- /.panel-body -->
                                    <!--/ End tabs content -->
									
									<!-- Start pager -->
                                    <div class="panel-footer">
                                        <ul class="pager wizard no-margin">
                                            <li class="previous"><a href="javascript:void(0);">{{ trans('admin/users/edit.form-previous') }}</a></li>
                                            <li class="next"><a href="javascript:void(0);">{{ trans('admin/users/edit.form-next') }}</a></li>
                                        </ul>
                                    </div><!-- /.panel-footer -->
                                    <!--/ End pager -->

                                </div><!-- /.panel -->
                            </div><!-- /#basic-wizard-horizontal -->
                            <!--/ End basic wizard horizontal-->

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
	{!! Html::script('assets/global/plugins/bower_components/jquery-validation/dist/jquery.validate.min.js') !!}
	{!! Html::script('assets/global/plugins/bower_components/twitter-bootstrap-wizard/jquery.bootstrap.wizard.min.js') !!}
	{!! Html::script('assets/admin/js/apps.js') !!}
	{!! Html::script('assets/admin/js/pages/blankon.edit.user.js') !!}
	{!! Html::script('assets/admin/js/demo.js') !!}
@parent
<script>
    $(".button-add-group").click( function(){
        <?php if($user->exists): ?>
        $('.form-add-group').submit();
        <?php endif; ?>
    });
    $(".button-del-group").click( function(){
        name = $(this).attr('name');
        $('form[name='+name+']').submit();
    });
</script>
<script>
    $(".button-add-perm").click(function () {
        <?php if($user->exists): ?>
        $('.form-add-perm').submit();
        <?php endif; ?>
    });
    $(".button-del-perm").click(function () {
        // submit the form with the same name
        name = $(this).attr('name');
        $('form[name='+name+']').submit();
    });
</script>
@stop
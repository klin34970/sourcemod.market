@section('styles')
	{!! Html::style('assets/global/plugins/bower_components/jasny-bootstrap-fileinput/css/jasny-bootstrap-fileinput.min.css') !!}
@stop

@extends('laravel-authentication-acl::client.layouts.base')

@section('title', trans('front/dashboard/users/profile.title'))
@section('page', 'page-users-profile no-modal-backdrop') 

@section('content')
<!-- START @PAGE CONTENT -->
            <section id="page-content">

                <!-- Start page header -->
                <div class="header-content">
                    <h2><i class="fa fa-user"></i> {{ trans('front/dashboard/users/profile.header-title') }}</h2>
                    <div class="breadcrumb-wrapper hidden-xs">
                        <span class="label">{{ trans('front/dashboard/users/profile.header-you-are-here') }}:</span>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-home"></i>
                                <a href="{!! URL::route('dashboard.default') !!}">{{ trans('front/dashboard/users/profile.header-breadcrumb-home') }}</a>
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                <a href="{!! URL::route('dashboard.users.self') !!}">{{ trans('front/dashboard/users/profile.header-breadcrumb-user') }}</a>
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li class="active">{{ trans('front/dashboard/users/profile.header-breadcrumb-active') }}</li>
                        </ol>
                    </div><!-- /.breadcrumb-wrapper -->
                </div><!-- /.header-content -->
                <!--/ End page header -->

                <!-- Start body content -->
                <div class="body-content animated fadeIn">
				
                    <div class="row">
                        <div class="col-md-12 col-xs-12">
							<div class="panel panel-theme">
                                <div class="panel-heading">
                                    <h3 class="panel-title">{{ trans('front/dashboard/users/profile.panel-title-1') }}</h3>
                                </div><!-- /.panel-heading -->
                                <div class="panel-body">
									<h4><i class="fa fa-cubes"></i> {{ trans('front/dashboard/users/profile.form-user-data') }}</h4>
									{!! Form::model($user_profile,['route'=>'dashboard.users.self', 'method' => 'post']) !!}
									<!-- code text field -->
									<div class="form-group">
										{!! Form::label('bio', trans('front/dashboard/users/profile.form-label-bio')) !!}
										{!! Form::textarea('bio', null, ['class' => 'textarea form-control', 'placeholder' => '']) !!}
									</div>
									<span class="text-danger">{!! $errors->first('bio') !!}</span>

									
									<!-- var text field -->
									<div class="form-group">
										{!! Form::label('vat', trans('front/dashboard/users/profile.form-label-user-vat')) !!}
										{!! Form::text('vat', null, ['class' => 'form-control', 'placeholder' => '']) !!}
									</div>
									<span class="text-danger">{!! $errors->first('vat') !!}</span>
									
									<!-- var text field -->
									<div class="form-group">
										{!! Form::label('paypal_email', trans('front/dashboard/users/profile.form-label-paypal_email')) !!}
										{!! Form::text('paypal_email', null, ['class' => 'form-control', 'placeholder' => '']) !!}
									</div>
									<span class="text-danger">{!! $errors->first('paypal_email') !!}</span>

									{!! Form::submit(trans('front/dashboard/users/profile.form-button-save') ,['class' =>'btn btn-info pull-left margin-bottom-30']) !!}
									{!! Form::close() !!}
                                </div><!-- /.panel-body -->
                            </div>

                        </div>
                    </div><!-- /.row -->

                </div><!-- /.body-content -->
                <!--/ End body content -->
				
				@include('laravel-authentication-acl::client.layouts.partials.footer')

            </section><!-- /#page-content -->
            <!--/ END PAGE CONTENT -->
@endsection

@section('scripts')	
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
@parent
@stop
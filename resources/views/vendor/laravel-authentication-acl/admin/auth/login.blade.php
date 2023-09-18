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
	{!! Html::style('assets/admin/css/pages/sign.css') !!}
	{!! Html::style('assets/admin/css/custom.css') !!}
@stop

@extends('laravel-authentication-acl::admin.layouts.auth')

@section('title', trans('auth/login.title'))

@section('content')
        <!-- START @SIGN WRAPPER -->
        <div id="sign-wrapper">

            <!-- Register form -->
            {!! Form::open(array('url' => URL::route("user.login.process"), 'method' => 'post', 'class' => 'sign-in form-horizontal shadow rounded no-overflow') ) !!}
                <div class="sign-header">
                    <div class="form-group">
                        <div class="sign-text">
                            <span>{{ trans('auth/login.form-title') }}</span>
                        </div>
                    </div><!-- /.form-group -->
                </div><!-- /.sign-header -->
                <div class="sign-body">
                    <div class="form-group">
                        <div class="input-group input-group-lg rounded no-overflow">
                            {!! Form::email('email', '', ['id' => 'email', 'class' => 'form-control', 'placeholder' => trans("auth/login.form-placeholder-email"), 'required', 'autocomplete' => 'off']) !!}
                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        </div>
                    </div><!-- /.form-group -->
                    <div class="form-group">
                        <div class="input-group input-group-lg rounded no-overflow">
                            {!! Form::password('password', ['id' => 'password', 'class' => 'form-control', 'placeholder' => trans("auth/login.form-placeholder-password"), 'required', 'autocomplete' => 'off']) !!}
                            <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                        </div>
                    </div><!-- /.form-group -->
                </div><!-- /.sign-body -->
                <div class="sign-footer">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="ckbox ckbox-theme">
									{!! Form::checkbox('remember', '', null, ['id' => 'rememberme']) !!}
                                    <label for="rememberme" class="rounded">{{ trans("auth/login.form-rememberme") }}</label>
                                </div>
                            </div>
                        </div>
                    </div><!-- /.form-group -->
                    <div class="form-group">
                        <button type="submit" class="btn btn-theme btn-lg btn-block no-margin rounded" id="login-btn">
						{{ trans("auth/login.form-signin") }}
						</button>
                    </div><!-- /.form-group -->
                </div><!-- /.sign-footer -->
            {!! Form::close() !!}
            <!--/ Register form -->

        </div><!-- /#sign-wrapper -->
        <!--/ END SIGN WRAPPER -->
@endsection

@section('scripts')
	{!! Html::script('assets/global/plugins/bower_components/jquery/dist/jquery.min.js') !!}
	{!! Html::script('assets/global/plugins/bower_components/jquery-cookie/jquery.cookie.js') !!}
	{!! Html::script('assets/global/plugins/bower_components/bootstrap/dist/js/bootstrap.min.js') !!}
	{!! Html::script('assets/global/plugins/bower_components/jquery-easing-original/jquery.easing.1.3.min.js') !!}
	{!! Html::script('assets/global/plugins/bower_components/ionsound/js/ion.sound.min.js') !!}
	{!! Html::script('assets/global/plugins/bower_components/retina.js/dist/retina.min.js') !!}
	{!! Html::script('assets/global/plugins/bower_components/jquery-validation/dist/jquery.validate.min.js') !!}
	{!! Html::script('assets/admin/js/pages/blankon.sign.js') !!}
	<script>
		BlankonSign.init(
							'{!! trans("auth/login.form-email-message") !!}', 
							'{!! trans("auth/login.form-password-message") !!}', 
							'{!! trans("auth/login.form-checking-message") !!}', 
							'{!! trans("auth/login.form-connected-message") !!}'
						);
	</script>
@stop
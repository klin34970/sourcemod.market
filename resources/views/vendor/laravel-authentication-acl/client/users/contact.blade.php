@extends('laravel-authentication-acl::client.layouts.base')

@section('title', $user->user_profile()->first()->first_name)
@section('description', $user->user_profile()->first()->first_name)
@section('keywords', str_replace(' ', ', ', $user->user_profile()->first()->first_name))
@section('og_type', 'website')
@section('twitter_card', 'website')
@section('og_image', url('/') . '/assets/images/logos/banner.png')

@section('page', 'page-users-contact')
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
						<h3 class="panel-title">{{ trans('front/users/view.contact') }} <code>{{ $user->user_profile->first()->first_name}}</code></h3>
					</div>
					<!-- Start tabs content -->
					<div class="panel-body">
						<div class="tab-content">
							<div class="tab-pane fade in active" id="tab1">
								<div class="panel-body no-padding">
									<div class="panel-body">

										<div class="form-body">
											{!! Form::model($user, [ 'url' => URL::route('contact.users', ['id' => $user->id]), 'class' => 'form-horizontal mt-10'] )  !!}
											<div class="form-group">
												{!! Form::text('title', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
											</div>
											<div class="form-group">
												{!! Form::textarea('text', null, ['class' => 'textarea form-control', 'autocomplete' => 'off']) !!}
											</div>
											<div class="form-footer">
												<div class="pull-right">
												{!! Form::submit(trans('front/users/view.form-button-contact'), array("class"=>"btn btn-success")) !!}
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
		$('.wysihtml5-sandbox').contents().find('body').on("keyup change input",function() 
		{
			var REG_EXP = /(:[\-+\w]*:)/g;
			var source = $('.textarea').data("wysihtml5").editor.getValue();
			
			if(source.match(REG_EXP))
			{
				var preview = emojione.toImage(source);
				if(preview.match(REG_EXP))
				{
					preview = preview.replace(REG_EXP, "");
				}
				$('.textarea').data("wysihtml5").editor.setValue(preview);
				$('.textarea').data("wysihtml5").editor.focus(true);
			}

		});
	</script>
@endsection
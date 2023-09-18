@section('styles')
	{{Html::style('assets/admin/css/pages/mail.css')}}
@stop

@extends('laravel-authentication-acl::client.layouts.base')

@section('title', $message->title)
@section('page', 'page-dashboard-messages-list') 

@section('content')
<!-- START @PAGE CONTENT -->
<section id="page-content">

	<!-- Start page header -->
	<div class="header-content">
		<h2><i class="fa fa-envelope"></i> {{ trans('front/dashboard/messages/read.header-title') }} <span>{{ $message->title }}</span></h2>
		<div class="breadcrumb-wrapper hidden-xs">
			<span class="label">{{ trans('front/dashboard/messages/read.header-you-are-here') }}:</span>
			<ol class="breadcrumb">
				<li>
					<i class="fa fa-angle-right"></i>
					<a href="{!! URL::route('dashboard.index') !!}">{{ trans('front/dashboard/messages/read.breadcrumb-home') }}</a>
					<i class="fa fa-angle-right"></i>
				</li>
				<li>
					<a href="#">{{ trans('front/dashboard/messages/read.breadcrumb-messages') }}</a>
					<i class="fa fa-angle-right"></i>
				</li>
				<li class="active">{{ trans('front/dashboard/messages/read.breadcrumb-active') }}</li>
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
			
				@if(!$message->closed)
				{!! Form::model(null, ['url' => URL::route('dashboard.messages.replies', ['id' => $message->id, 'page' => $message->user_messages_replies()->paginate((int)config('sourcemod.market.users_messages_pagination'))->lastPage()]), 'class' => 'form-horizontal mt-10'] )  !!}
				@endif
				   <div class="panel mail-wrapper rounded shadow">
						<div class="panel-heading">
							<div class="pull-left">
								<h3 class="panel-title">{{ $message->title }}</h3>
							</div>
							<div class="clearfix"></div>
						</div><!-- /.panel-heading -->
						<div class="panel-body">
						
							@if(Request::get('page') < 2)
							<div class="row" style="padding-bottom: 8px;">

								<div class="col-md-10 col-sm-10 col-xs-12">
									<div class="pull-left"><span class="badge badge-success"><i class="fa fa-pencil margin-right-5"></i>{{ $message->created_at->diffForHumans() }}</span></div>
									<div class="clearfix"></div>
									<div class="view-mail">
										{!! $message->text !!}
									</div><!-- /.view-mail -->
								</div>
								
								<div class="col-md-2 col-sm-2 col-xs-12">
									<div class="bg-theme" style="padding: 10px;">
										<ul class="list-unstyled">
											<li class="text-center">
												<img alt="{{ $message->user_profile->first()->first_name }}" id="{{ $message->user->id }}" style="width: 100px;" class="img-box {{ $message->user->online ? 'img-bordered-success' : 'img-bordered-danger'}}" src="{{ $message->user_profile->first()->presenter()->avatar('30') }}">
											</li>
											<li class="text-center" style="word-break: break-all;">
												<h4 class="text-capitalize"><a href="{{ URL::route('users.view', $message->user_id) }}">{{ $message->user_profile->first()->first_name }}</a></h4>
											</li>

											@if(isset($logged_user))
												<li>
													<a href="{!! URL::route('report.users', ['id' => $message->user_id]) !!}" class="btn btn-danger btn-block">
														<i class="margin-right-5 fa fa-meh-o"></i>
														Report this user
													</a>
												</li>
											@endif
										</ul>
									</div> 
								</div>
							</div>
							@endif
							
							@foreach($message->user_messages_replies()->paginate((int)config('sourcemod.market.users_messages_pagination')) as $key => $reply)
								@if($key % 2)
								<div class="row" style="border-top: 1px solid #eeeeef;padding-top: 8px;">
									<div class="col-md-10 col-sm-10 col-xs-12">
										<div class="pull-left"><span class="badge badge-success"><i class="fa fa-pencil margin-right-5"></i>{{ $reply->created_at->diffForHumans() }}</span></div>
										<div class="clearfix"></div>
										<div class="view-mail">
											{!! $reply->text !!}
										</div><!-- /.view-mail -->
									</div>
									<div class="col-md-2 col-sm-2 col-xs-12">
										<div class="bg-theme" style="padding: 10px;">
											<ul class="list-unstyled">
												<li class="text-center">
													<img alt="{{ $reply->user_profile->first()->first_name }}" id="{{ $reply->user->id }}" style="width: 100px;" class="img-box {{ $reply->user->online ? 'img-bordered-success' : 'img-bordered-danger'}}" src="{{ $reply->user_profile->first()->presenter()->avatar('30') }}">
												</li>
												<li class="text-center" style="word-break: break-all;">
													<h4 class="text-capitalize"><a href="{{ URL::route('users.view', $reply->user_id) }}">{{ $reply->user_profile->first()->first_name }}</a></h4>
												</li>

												@if(isset($logged_user))
													<li>
														<a href="{!! URL::route('report.users', ['id' => $reply->user_id]) !!}" class="btn btn-danger btn-block">
															<i class="margin-right-5 fa fa-meh-o"></i>
															Report this user
														</a>
													</li>
												@endif
											</ul>
										</div> 
									</div>
								</div>
								<br>
								@else
								<div class="row" style="border-top: 1px solid #eeeeef;padding-top: 8px;">
									<div class="col-md-2 col-sm-2 col-xs-12">
										<div class="bg-theme" style="padding: 10px;">
											<ul class="list-unstyled">
												<li class="text-center">
													<img alt="{{ $reply->user_profile->first()->first_name }}" id="{{ $reply->user->id }}" style="width: 100px;" class="img-box {{ $reply->user->online ? 'img-bordered-success' : 'img-bordered-danger'}}" src="{{ $reply->user_profile->first()->presenter()->avatar('30') }}">
												</li>
												<li class="text-center" style="word-break: break-all;">
													<h4 class="text-capitalize"><a href="{{ URL::route('users.view', $reply->user_id) }}">{{ $reply->user_profile->first()->first_name }}</a></h4>
												</li>

												@if(isset($logged_user))
													<li>
														<a href="{!! URL::route('report.users', ['id' => $reply->user_id]) !!}" class="btn btn-danger btn-block">
															<i class="margin-right-5 fa fa-meh-o"></i>
															Report this user
														</a>
													</li>
												@endif
											</ul>
										</div> 
									</div>
									<div class="col-md-10 col-sm-10 col-xs-12">
										<div class="pull-right"><span class="badge badge-success"><i class="fa fa-pencil margin-right-5"></i>{{ $reply->created_at->diffForHumans() }}</span></div>
										<div class="clearfix"></div>
										<div class="view-mail">
											{!! $reply->text !!}
										</div><!-- /.view-mail -->
									</div>
								</div>
								<br>
								@endif
							@endforeach
							
							@if(!$message->closed)
							<div>
								{!! Form::textarea('text', null, ['autofocus' => true, 'class' => '_reply_form textarea form-control', 'autocomplete' => 'off']) !!}
							</div>
							@endif
						</div><!-- /.panel-body -->
						@if(!$message->closed)
						<div class="panel-footer">
							<div class="pull-left">
							{{ $message->user_messages_replies()->paginate((int)config('sourcemod.market.users_messages_pagination'))->appends(['id' => Request::get('id')])->links() }}
							</div>
							<div class="pull-right">
								{!! Form::submit(trans('front/dashboard/messages/read.form-button-reply'), array("class"=>"btn btn-success")) !!}
							</div>
							<div class="clearfix"></div>
						</div>
						@endif
					</div><!-- /.panel -->
				@if(!$message->closed)
				{!! Form::close() !!}
				@endif


							
			</div><!-- /.col-md-12 -->
		</div><!-- /.row -->

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
@stop
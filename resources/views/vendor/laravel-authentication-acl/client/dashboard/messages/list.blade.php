@section('styles')
	{{Html::style('assets/admin/css/pages/mail.css')}}
@stop

@extends('laravel-authentication-acl::client.layouts.base')

@section('title', trans('front/dashboard/messages/list.title'))
@section('page', 'page-dashboard-messages-list') 


@section('content')
<!-- START @PAGE CONTENT -->
<section id="page-content">

	<!-- Start page header -->
	<div class="header-content">
		<h2><i class="fa fa-envelope"></i> {{ trans('front/dashboard/messages/list.header-title') }} <span>{{ trans('front/dashboard/messages/list.header-title-small') }}</span></h2>
		<div class="breadcrumb-wrapper hidden-xs">
			<span class="label">{{ trans('front/dashboard/messages/list.header-you-are-here') }}:</span>
			<ol class="breadcrumb">
				<li>
					<i class="fa fa-angle-right"></i>
					<a href="{!! URL::route('dashboard.index') !!}">{{ trans('front/dashboard/messages/list.breadcrumb-home') }}</a>
					<i class="fa fa-angle-right"></i>
				</li>
				<li>
					<a href="#">{{ trans('front/dashboard/messages/list.breadcrumb-messages') }}</a>
					<i class="fa fa-angle-right"></i>
				</li>
				<li class="active">{{ trans('front/dashboard/messages/list.breadcrumb-active') }}</li>
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
				<div class="panel rounded shadow panel-default">
					<div class="panel-heading">
						<form class="form-horizontal" method="GET">
							<div class="form-group no-margin no-padding has-feedback">
								<div class="col-md-3">
									<div class="input-group">
										<input name="search" class="form-control" type="text" value="{{ Request::has('search') ? Request::get('search') : '' }}">
										<span class="input-group-btn">
											<button type="submit" class="btn btn-theme"><i class="fa fa-search"></i></button>
										</span>
									</div>
								</div>		
								
								<div class="col-md-3">
									<div class="input-group" style="width: 100%;">
									<span class="input-group-addon bg-theme"><i class="fa fa-check"></i></span>
									<select name="status" class="form-control" onchange="this.form.submit()">
										<option value="">All</option>
										<option value="0" {{ Request::get('status') == "0" ? 'selected' : '' }}>Unread</option>
										<option value="1" {{ Request::get('status') == "1" ? 'selected' : '' }}>Read</option>
									</select>
									</div>
								</div>
							</div>
						</form>
						<div class="clearfix"></div>
					</div><!-- /.panel-heading -->
					<div class="panel-body no-padding">

						<div class="table-responsive">
							<table class="table table-hover table-email">
								<tbody>
									@foreach($messages as $message)
									<tr {{ !$message->read ? 'class=unread' : '' }}>
										<td>
											<div class="media">
												<a href="#" class="pull-left">
													@if($message->user_id == $logged_user->id)
														<img src="{{ $message->target_profile->first()->presenter()->avatar('30') }}" class="media-object">
													@else
														<img src="{{ $message->user_profile->first()->presenter()->avatar('30') }}" class="media-object">
													@endif
												</a>
												<div class="media-body">
													<a href="{{URL::route('dashboard.messages.read', ['id' => $message->id, 'page' => $message->user_messages_replies()->paginate((int)config('sourcemod.market.users_messages_pagination'))->lastPage()])}}">
														<h4 class="text-primary">
															{{ $message->title }}
														</h4>
													</a>
													<p class="email-summary">
													@if($message->user_id == $logged_user->id)
														To: {{ $message->target_profile->first()->first_name }}	
													@else
														Started by: {{ $message->user_profile->first()->first_name }}
													@endif
													</p>
													<span class="media-meta">
														@if(!$message->read)
														<span class="badge badge-danger">
															<i class="fa fa-check margin-right-5"></i>unread 
														</span>
														@endif
														<span class="badge badge-success">
															<i class="fa fa-pencil margin-right-5"></i>{{ $message->created_at->diffForHumans() }} 
														</span>
														<span class="badge badge-info">
															<i class="fa fa-eye margin-right-5"></i>{{ $message->updated_at->diffForHumans() }}
														</span>
													</span>
												</div>
											</div>
										</td>
									</tr>
									@endforeach
								</tbody>
							</table>
						</div><!-- /.table-responsive -->
					</div><!-- /.panel-body -->
					<div class="panel-footer text-center">
						{{ $messages->appends(['search' => Request::get('search'), 'status' => Request::get('status')])->links() }}
					</div>
				</div><!-- /.panel -->

			</div><!-- /.col-md-12 -->
		</div><!-- /.row -->

	</div><!-- /.body-content -->
	<!--/ End body content -->
	
	@include('laravel-authentication-acl::client.layouts.partials.footer')

</section><!-- /#page-content -->
<!--/ END PAGE CONTENT -->
@endsection

@section('scripts')	

@stop
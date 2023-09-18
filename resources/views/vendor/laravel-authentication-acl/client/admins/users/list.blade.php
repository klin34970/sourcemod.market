@extends('laravel-authentication-acl::client.layouts.base')

@section('title', trans('admin/users/list.title'))
@section('page', 'page-admins-scripts-list') 

@section('content')
<!-- START @PAGE CONTENT -->
<section id="page-content">

	<!-- Start page header -->
	<div class="header-content">
		<h2><i class="fa fa-code-fork"></i> {{ trans('admin/users/list.header-title') }} <span>{{ trans('admin/users/list.header-title-small') }}</span></h2>
		<div class="breadcrumb-wrapper hidden-xs">
			<span class="label">{{ trans('admin/users/list.header-you-are-here') }}:</span>
			<ol class="breadcrumb">
				<li>
					<i class="fa fa-angle-right"></i>
					<a href="{!! URL::route('dashboard.index') !!}">{{ trans('admin/users/list.breadcrumb-home') }}</a>
					<i class="fa fa-angle-right"></i>
				</li>
				<li>
					<a href="#">{{ trans('admin/users/list.breadcrumb-users') }}</a>
					<i class="fa fa-angle-right"></i>
				</li>
				<li class="active">{{ trans('admin/users/list.breadcrumb-active') }}</li>
			</ol>
		</div><!-- /.breadcrumb-wrapper -->
	</div><!-- /.header-content -->
	<!--/ End page header -->

	<!-- Start body content -->
	<div class="body-content animated fadeIn">

		<div class="row">
			<div class="col-md-12">
				<!-- Start basic color table -->
				<div class="panel">
				
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
									<span class="input-group-addon bg-theme"><i class="fa fa-meh-o"></i></span>
									<select name="report" class="form-control" onchange="this.form.submit()">
										<option value="">All</option>
										<option value="desc" {{ Request::get('report') == "desc" ? 'selected' : '' }}>Most reported</option>
										<option value="asc" {{ Request::get('report') == "asc" ? 'selected' : '' }}>Less reported</option>
									</select>
									</div>
								</div>
								
								<div class="col-md-3">
									<div class="input-group" style="width: 100%;">
									<span class="input-group-addon bg-theme"><i class="fa fa-meh-o"></i></span>
									<select name="banned" class="form-control" onchange="this.form.submit()">
										<option value="">All</option>
										<option value="desc" {{ Request::get('banned') == "desc" ? 'selected' : '' }}>Banned</option>
									</select>
									</div>
								</div>
								
							</div>
						</form>
					</div><!-- /.panel-heading -->
				
				
					<div class="panel-body no-padding">
						@if(!$users->isEmpty())
						<div class="table-responsive" style="margin-top: -1px;">
							<table class="table table-theme">
								<thead>
									<tr>
										<th style="min-width: 10px;" data-hide="phone, tablet">{{ trans('admin/users/list.table-header-key') }}</th>
										<th data-hide="phone, tablet">{{ trans('admin/users/list.table-header-name') }}</th>
										<th data-hide="phone, tablet">{{ trans('admin/users/list.table-header-registered') }}</th>
										<th data-hide="phone, tablet">{{ trans('admin/users/list.table-header-banned') }}</th>
										<th data-hide="phone, tablet">{{ trans('admin/users/list.table-header-report') }}</th>
									</tr>
								</thead>
								<tbody>
									@foreach($users as $key => $user)
									<tr>
										<td>{{ $key }}</td>
										<td><a target="_blank" href="{{ URL::route('users.view', ['id' => $user->id]) }}">{{ $user->user_profile->first()->first_name }}</a></td>
										<td>{{ $user->created_at->diffForHumans() }}</td>
										<td>
											{!! $user->isBanned() ? '<i class="fa fa-check"></i>' : '<i class="fa fa-close"></i>' !!}
											
											@if($user->isBanned())
												<a href="{!! URL::route('users.unbans', ['id' => $user->id ]) !!}" class="btn btn-success btn-xs btn-push" data-toggle="tooltip" data-placement="top" data-original-title="{{ trans('admin/users/list.table-ban') }}"><i class="fa fa-meh-o"></i> {{ trans('admin/users/list.unban') }}</a>
											@else
												<a target="_blank" href="{!! URL::route('users.bans', ['id' => $user->id ]) !!}" class="btn btn-danger btn-xs btn-push" data-toggle="tooltip" data-placement="top" data-original-title="{{ trans('admin/users/list.table-ban') }}"><i class="fa fa-meh-o"></i> {{ trans('admin/users/list.ban') }}</a>
											@endif
										</td>
										<td>
											<a target="_blank" href="{!! URL::route('users.view.reports', ['id' => $user->id ]) !!}" class="btn btn-danger btn-xs btn-push" data-toggle="tooltip" data-placement="top" data-original-title="{{ trans('admin/users/list.table-view') }}"><i class="fa fa-meh-o"></i> {!! $user->reports->count() !!} {{ trans('admin/users/list.table-reports') }}</a>
										</td>
									</tr>
									@endforeach
								</tbody>
							</table>
						</div><!-- /.table-responsive -->
					@endif
					</div><!-- /.panel-body -->
					<div class="panel-footer text-center">
						{{ $users->appends(['search' => Request::get('search'), 'report' => Request::get('report'), 'banned' => Request::get('banned')])->links() }}
					</div>
				</div><!-- /.panel -->
				<!--/ End basic color table -->

			</div><!-- /.col-md-12 -->
		</div><!-- /.row -->

	</div><!-- /.body-content -->
	<!--/ End body content -->
	
	@include('laravel-authentication-acl::client.layouts.partials.footer')

</section><!-- /#page-content -->
<!--/ END PAGE CONTENT -->
@endsection

@section('scripts')

@endsection
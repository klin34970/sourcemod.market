@extends('laravel-authentication-acl::client.layouts.base')

@section('title', trans('admin/scripts/list.title'))
@section('page', 'page-admins-scripts-list') 

@section('content')
<!-- START @PAGE CONTENT -->
<section id="page-content">

	<!-- Start page header -->
	<div class="header-content">
		<h2><i class="fa fa-code-fork"></i> {{ trans('admin/scripts/list.header-title') }} <span>{{ trans('admin/scripts/list.header-title-small') }}</span></h2>
		<div class="breadcrumb-wrapper hidden-xs">
			<span class="label">{{ trans('admin/scripts/list.header-you-are-here') }}:</span>
			<ol class="breadcrumb">
				<li>
					<i class="fa fa-angle-right"></i>
					<a href="{!! URL::route('dashboard.index') !!}">{{ trans('admin/scripts/list.breadcrumb-home') }}</a>
					<i class="fa fa-angle-right"></i>
				</li>
				<li>
					<a href="#">{{ trans('admin/scripts/list.breadcrumb-scripts') }}</a>
					<i class="fa fa-angle-right"></i>
				</li>
				<li class="active">{{ trans('admin/scripts/list.breadcrumb-active') }}</li>
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
									<span class="input-group-addon bg-theme"><i class="fa fa-gamepad"></i></span>
									{!! Form::select('game_id', ['' => 'All'] + App\Http\Models\Front\ScriptModel::_getGamesList(), Request::has('game_id') ? Request::get('game_id') : '', ['class' => 'form-control', 'autocomplete' => 'off', 'onchange' => 'this.form.submit()']) !!}
									</div>
								</div>
								<div class="col-md-3">
									<div class="input-group" style="width: 100%;">
									<span class="input-group-addon bg-theme"><i class="fa fa-unlock"></i></span>
									{!! Form::select('reason_id', ['' => 'All'] + App\Http\Models\Front\ScriptReasonModel::_getReasonsList(), Request::has('reason_id') ? Request::get('reason_id') : '', ['class' => 'form-control', 'autocomplete' => 'off', 'onchange' => 'this.form.submit()']) !!}
									</div>
								</div>			
								<div class="col-md-3">
									<div class="input-group" style="width: 100%;">
									<span class="input-group-addon bg-theme"><i class="fa fa-calendar"></i></span>
									<select name="added" class="form-control" onchange="this.form.submit()">
										<option value="">All</option>
										<option value="year" {{ Request::get('added') == "year" ? 'selected' : '' }}>Last year</option>
										<option value="month" {{ Request::get('added') == "month" ? 'selected' : '' }}>Last month</option>
										<option value="week" {{ Request::get('added') == "week" ? 'selected' : '' }}>Last week</option>
										<option value="day" {{ Request::get('added') == "day" ? 'selected' : '' }}>Last day</option>
									</select>
									</div>
								</div>
								
								<br>
								<br>
								<div class="col-md-3">
								</div>
								
								<div class="col-md-3">
									<div class="input-group" style="width: 100%;">
									<span class="input-group-addon bg-theme"><i class="fa fa-check"></i></span>
									<select name="activated" class="form-control" onchange="this.form.submit()">
										<option value="">All</option>
										<option value="0" {{ Request::get('activated') == "0" ? 'selected' : '' }}>Disabled</option>
										<option value="1" {{ Request::get('activated') == "1" ? 'selected' : '' }}>Enabled</option>
									</select>
									</div>
								</div>
								<div class="col-md-3">
									<div class="input-group" style="width: 100%;">
									<span class="input-group-addon bg-theme"><i class="fa fa-sort"></i></span>
									<select name="create" class="form-control" onchange="this.form.submit()">
										<option value="">All</option>
										<option value="desc" {{ Request::get('create') == "desc" ? 'selected' : '' }}>Newest</option>
										<option value="asc" {{ Request::get('create') == "asc" ? 'selected' : '' }}>Oldest</option>
									</select>
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
							</div>
						</form>
					</div><!-- /.panel-heading -->
				
				
					<div class="panel-body no-padding">
						@if(!$scripts->isEmpty())
						<div class="table-responsive" style="margin-top: -1px;">
							<table class="table table-theme">
								<thead>
									<tr>
										<th style="min-width: 10px;" data-hide="phone, tablet">{{ trans('admin/scripts/list.table-header-key') }}</th>
										<th data-class="expand">{{ trans('admin/scripts/list.table-header-name') }}</th>
										<th data-hide="phone, tablet">{{ trans('admin/scripts/list.table-header-game') }}</th>
										<th data-hide="phone, tablet">{{ trans('admin/scripts/list.table-header-category') }}</th>
										<th data-hide="phone, tablet" class="text-center">{{ trans('admin/scripts/list.table-header-active') }}</th>
										<th data-hide="phone, tablet" class="text-center" style="width: 200px;">{{ trans('admin/scripts/list.table-header-action') }}</th>
										<th data-hide="phone, tablet">{{ trans('admin/scripts/list.table-header-list') }}</th>
										<th data-hide="phone, tablet">{{ trans('admin/scripts/list.table-header-date') }}</th>
										<th data-hide="phone, tablet">{{ trans('admin/scripts/list.table-header-report') }}</th>
									</tr>
								</thead>
								<tbody>
									@foreach($scripts as $key => $script)
									<tr class="{{ $script->reason->class }}">
										<td>{!! $key !!}</td>
										<td>{!! $script->title !!}</td>
										<td>{!! $script->game->title !!}</td>
										<td>{!! $script->category->title !!}</td>
										<td class="text-center">{!! $script->activated ? '<i class="fa fa-check"></i>' : '<i class="fa fa-close"></i>' !!}</td>
										<td class="text-center">
											<a target="_blank" href="{!! URL::route('scripts.view', ['id' => $script->id, 'game' => App\Http\Classes\Slug::filter($script->game->title), 'category' => App\Http\Classes\Slug::filter($script->category->title), 'title' => App\Http\Classes\Slug::filter($script->title) ]) !!}" class="btn btn-primary btn-xs btn-push" data-toggle="tooltip" data-placement="top" data-original-title="{{ trans('admin/scripts/list.table-view') }}"><i class="fa fa-eye"></i> {{ trans('admin/scripts/list.table-view') }}</a>
											@if($script->activated && ($script->price > 0 || $script->price_discount > 0))
												<a target="_blank" href="{!! URL::route('purchase.scripts', ['id' => $script->id]) !!}" class="btn btn-success btn-xs btn-push" data-toggle="tooltip" data-placement="top" data-original-title="{{ trans('front/dashboard/scripts/list.table-purchase') }}"><i class="fa fa-dollar"></i> {{ trans('front/dashboard/scripts/list.table-purchase') }}</a>
											@endif
										</td>
										<td>
											{!! Form::select('reason', $reasons, $script->reason->id, ['class' => 'form-control', 'autocomplete' => 'off', 'onchange' => 'approve(this)', 'script_id' => $script->id]) !!}
										</td>
										<td>{!! $script->created_at->diffForHumans() !!}</td>
										<td>
											<a target="_blank" href="{!! URL::route('scripts.view.reports', ['id' => $script->id, 'game' => App\Http\Classes\Slug::filter($script->game->title), 'category' => App\Http\Classes\Slug::filter($script->category->title), 'title' => App\Http\Classes\Slug::filter($script->title) ]) !!}" class="btn btn-danger btn-xs btn-push" data-toggle="tooltip" data-placement="top" data-original-title="{{ trans('admin/scripts/list.table-view') }}"><i class="fa fa-meh-o"></i> {!! $script->reports->count() !!} {{ trans('admin/scripts/list.table-reports') }}</a>
										</td>
									</tr>
									@endforeach
								</tbody>
							</table>
						</div><!-- /.table-responsive -->
					</div><!-- /.panel-body -->
					@endif
					<div class="panel-footer text-center">
						{{ $scripts->appends(['search' => Request::get('search'), 'game_id' => Request::get('game_id'), 'sort' => Request::get('sort'), 'added' => Request::get('added'), 'reason_id' => Request::get('reason_id'), 'activated' => Request::get('activated'), 'create' => Request::get('create')])->links() }}
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
	<script>
	
		function approve(data)
		{
			var script_id = $(data).attr('script_id');
			var reason = $(data).val();
			
			console.log(script_id + '=' + reason);
			
			$.ajaxSetup({ 
				headers: 
				{ 
					'X-CSRF-TOKEN' : '{{ csrf_token() }}' 
				} 
			});
			
			$.ajax({
				type: 'POST',
				url: '{{ URL::route('admins.scripts.approvement') }}',
				data:
				{
					script_id: script_id,
					reason_id: reason,
				},
				datatype: 'json',
				success: function (data)
				{
					if(data.success)
					{
						location.reload();
					}
				}
			});
		}

	</script>
@endsection
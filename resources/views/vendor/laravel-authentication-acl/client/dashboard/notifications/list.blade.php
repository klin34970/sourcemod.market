@section('styles')
	{!! Html::style('assets/global/plugins/bower_components/datatables/css/dataTables.bootstrap.css') !!}
	{!! Html::style('assets/global/plugins/bower_components/datatables/css/datatables.responsive.css') !!}
	{!! Html::style('assets/global/plugins/bower_components/fuelux/dist/css/fuelux.min.css') !!}
@stop

@extends('laravel-authentication-acl::client.layouts.base')

@section('title', trans('front/dashboard/notifications/list.title'))
@section('page', 'page-dashboard-notifications-list') 

@section('content')
<!-- START @PAGE CONTENT -->
<section id="page-content">

	<!-- Start page header -->
	<div class="header-content">
		<h2><i class="fa fa-code-fork"></i> {{ trans('front/dashboard/notifications/list.header-title') }} <span>{{ trans('front/dashboard/notifications/list.header-title-small') }}</span></h2>
		<div class="breadcrumb-wrapper hidden-xs">
			<span class="label">{{ trans('front/dashboard/notifications/list.header-you-are-here') }}:</span>
			<ol class="breadcrumb">
				<li>
					<i class="fa fa-angle-right"></i>
					<a href="{!! URL::route('dashboard.index') !!}">{{ trans('front/dashboard/notifications/list.breadcrumb-home') }}</a>
					<i class="fa fa-angle-right"></i>
				</li>
				<li>
					<a href="#">{{ trans('front/dashboard/notifications/list.breadcrumb-scripts') }}</a>
					<i class="fa fa-angle-right"></i>
				</li>
				<li class="active">{{ trans('front/dashboard/notifications/list.breadcrumb-active') }}</li>
			</ol>
		</div><!-- /.breadcrumb-wrapper -->
	</div><!-- /.header-content -->
	<!--/ End page header -->

	@if(!$notifications->isEmpty())
	<!-- Start body content -->
	<div class="body-content animated fadeIn">

		<div class="row">
			<div class="col-md-12">
			
				<!-- Start datatable using dom -->
				<div class="panel rounded shadow">
					<div class="panel-body">
						<!-- Start datatable -->
						<table id="datatable-dom" class="table table-theme">
								<thead>
								<tr>
									<th style="min-width: 10px;" data-hide="phone, tablet">{{ trans('front/dashboard/notifications/list.table-header-key') }}</th>
									<th data-class="expand">{{ trans('front/dashboard/notifications/list.table-header-name') }}</th>
									<th data-hide="phone, tablet">{{ trans('front/dashboard/notifications/list.table-header-date') }}</th>
								</tr>
								</thead>
							<tbody>
								@foreach($notifications as $key => $notification)
								<tr class="{{ $notification->view ? 'success' : 'danger' }}">
									<td>{!! $key !!}</td>
									<td><a target="_blank" href="{{ URL::route('notifications.view', ['id' => $notification->id]) }}">{!! $notification->text !!}</a></td>
									<td>{{$notification->last_time->diffForHumans() }}</td>
								</tr>
								@endforeach
							</tbody>
							<tfoot>
								<tr>
									<th style="min-width: 10px;" data-hide="phone, tablet">{{ trans('front/dashboard/notifications/list.table-header-key') }}</th>
									<th data-class="expand">{{ trans('front/dashboard/notifications/list.table-header-name') }}</th>
									<th data-hide="phone, tablet">{{ trans('front/dashboard/notifications/list.table-header-date') }}</th>
								</tr>
							</tfoot>
						</table>
						<!--/ End datatable -->
					</div><!-- /.panel-body -->
				</div><!-- /.panel -->
				<!--/ End datatable using dom -->

			</div><!-- /.col-md-12 -->
		</div><!-- /.row -->

	</div><!-- /.body-content -->
	<!--/ End body content -->
	@endif
	
	@include('laravel-authentication-acl::client.layouts.partials.footer')

</section><!-- /#page-content -->
<!--/ END PAGE CONTENT -->
@endsection

@section('scripts')	
	{!! Html::script('assets/global/plugins/bower_components/datatables/js/jquery.dataTables.min.js') !!}
	{!! Html::script('assets/global/plugins/bower_components/datatables/js/dataTables.bootstrap.js') !!}
	{!! Html::script('assets/global/plugins/bower_components/datatables/js/datatables.responsive.js') !!}
	{!! Html::script('assets/global/plugins/bower_components/fuelux/dist/js/fuelux.min.js') !!}
	{!! Html::script('assets/admin/js/pages/blankon.dashboard.notifications.list.js') !!}
    <script>
		BlankonTable.init(
							'{!! trans("js/datatable.trans-menu") !!}', 
							'{!! trans("js/datatable.trans-record") !!}', 
							'{!! trans("js/datatable.trans-info") !!}', 
							'{!! trans("js/datatable.trans-info-empty") !!}', 
							'{!! trans("js/datatable.trans-info-filtered") !!}', 
							'{!! trans("js/datatable.trans-search") !!}', 
							'{!! trans("js/datatable.trans-previous") !!}', 
							'{!! trans("js/datatable.trans-next") !!}'
						);
    </script>
	
@stop
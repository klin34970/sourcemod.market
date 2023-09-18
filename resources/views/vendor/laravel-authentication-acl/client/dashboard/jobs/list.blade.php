@section('styles')
	{!! Html::style('assets/global/plugins/bower_components/datatables/css/dataTables.bootstrap.css') !!}
	{!! Html::style('assets/global/plugins/bower_components/datatables/css/datatables.responsive.css') !!}
@stop

@extends('laravel-authentication-acl::client.layouts.base')

@section('title', trans('front/dashboard/jobs/list.title'))
@section('page', 'page-dashboard-jobs-list') 

@section('navbar-left')
<li class="dropdown">
	<a href="{!! URL::route('dashboard.jobs.new') !!}" class="dropdown-toggle">
		<i class="fa fa-edit"></i> {{ trans('front/dashboard/jobs/list.navbar-left-new-script') }}
	</a>
</li>
@endsection
@section('content')
<!-- START @PAGE CONTENT -->
<section id="page-content">

	<!-- Start page header -->
	<div class="header-content">
		<h2><i class="fa fa-code-fork"></i> {{ trans('front/dashboard/jobs/list.header-title') }} <span>{{ trans('front/dashboard/jobs/list.header-title-small') }}</span></h2>
		<div class="breadcrumb-wrapper hidden-xs">
			<span class="label">{{ trans('front/dashboard/jobs/list.header-you-are-here') }}:</span>
			<ol class="breadcrumb">
				<li>
					<i class="fa fa-angle-right"></i>
					<a href="{!! URL::route('dashboard.index') !!}">{{ trans('front/dashboard/jobs/list.breadcrumb-home') }}</a>
					<i class="fa fa-angle-right"></i>
				</li>
				<li>
					<a href="#">{{ trans('front/dashboard/jobs/list.breadcrumb-jobs') }}</a>
					<i class="fa fa-angle-right"></i>
				</li>
				<li class="active">{{ trans('front/dashboard/jobs/list.breadcrumb-active') }}</li>
			</ol>
		</div><!-- /.breadcrumb-wrapper -->
	</div><!-- /.header-content -->
	<!--/ End page header -->

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
									<th style="min-width: 10px;" data-hide="phone, tablet">{{ trans('front/dashboard/jobs/list.table-header-key') }}</th>
									<th data-class="expand">{{ trans('front/dashboard/jobs/list.table-header-name') }}</th>
									<th data-hide="phone, tablet">{{ trans('front/dashboard/jobs/list.table-header-game') }}</th>
									<th data-hide="phone, tablet">{{ trans('front/dashboard/jobs/list.table-header-price') }}</th>
									<th data-hide="phone, tablet">{{ trans('front/dashboard/jobs/list.table-header-appliers') }}</th>
									<th data-hide="phone, tablet" class="text-center">{{ trans('front/dashboard/jobs/list.table-header-active') }}</th>
									<th data-hide="phone, tablet" class="text-center" style="width: 200px;">{{ trans('front/dashboard/jobs/list.table-header-action') }}</th>
								</tr>
								</thead>
							<tbody>
								@if(!$jobs->isEmpty())
								@foreach($jobs as $key => $job)
								<tr>
									<td>{!! $key !!}</td>
									<td>{!! $job->title !!}</td>
									<td>{!! $job->game->title !!}</td>
									<td>{!! number_format($job->price, 2) !!} $</td>
									<td><span class="badge badge-danger">{{ $job->appliers->count() }}</span></td>
									<td class="text-center">{!! $job->activated ? '<i class="fa fa-check"></i>' : '<i class="fa fa-close"></i>' !!}</td>
									<td class="text-center">
										<a target="_blank" href="{!! URL::route('jobs.view', ['id' => $job->id, 'game' => App\Http\Classes\Slug::filter($job->game->title), 'title' => App\Http\Classes\Slug::filter($job->title) ]) !!}" class="btn btn-warning btn-xs btn-push" data-toggle="tooltip" data-placement="top" data-original-title="{{ trans('front/dashboard/jobs/list.table-view') }}"><i class="fa fa-eye"></i> {{ trans('front/dashboard/jobs/list.table-view') }}</a>
										<a href="{!! URL::route('dashboard.jobs.edit', ['job_id' => $job->id]) !!}" class="btn btn-primary btn-xs btn-push" data-toggle="tooltip" data-placement="top" data-original-title="{{ trans('front/dashboard/jobs/list.table-edit') }}"><i class="fa fa-pencil"></i> {{ trans('front/dashboard/jobs/list.table-edit') }}</a>
									</td>
								</tr>
								@endforeach
								@endif
							</tbody>
							<tfoot>
								<tr>
									<th style="min-width: 10px;" data-hide="phone, tablet">{{ trans('front/dashboard/jobs/list.table-header-key') }}</th>
									<th data-class="expand">{{ trans('front/dashboard/jobs/list.table-header-name') }}</th>
									<th data-hide="phone, tablet">{{ trans('front/dashboard/jobs/list.table-header-game') }}</th>
									<th data-hide="phone, tablet">{{ trans('front/dashboard/jobs/list.table-header-price') }}</th>
									<th data-hide="phone, tablet">{{ trans('front/dashboard/jobs/list.table-header-appliers') }}</th>
									<th data-hide="phone, tablet" class="text-center">{{ trans('front/dashboard/jobs/list.table-header-active') }}</th>
									<th data-hide="phone, tablet" class="text-center" style="width: 200px;">{{ trans('front/dashboard/jobs/list.table-header-action') }}</th>
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
	
	@include('laravel-authentication-acl::client.layouts.partials.footer')

</section><!-- /#page-content -->
<!--/ END PAGE CONTENT -->
@endsection

@section('scripts')	
	{!! Html::script('assets/global/plugins/bower_components/datatables/js/jquery.dataTables.min.js') !!}
	{!! Html::script('assets/global/plugins/bower_components/datatables/js/dataTables.bootstrap.js') !!}
	{!! Html::script('assets/global/plugins/bower_components/datatables/js/datatables.responsive.js') !!}
	{!! Html::script('assets/admin/js/pages/blankon.dashboard.jobs.list.js') !!}
    <script>
        $(".delete").click(function(){
            return confirm('{!! trans("front/dashboard/jobs/list.confirm-delete") !!}');
        });
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
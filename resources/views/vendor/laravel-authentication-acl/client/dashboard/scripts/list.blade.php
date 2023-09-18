@section('styles')
	{!! Html::style('assets/global/plugins/bower_components/datatables/css/dataTables.bootstrap.css') !!}
	{!! Html::style('assets/global/plugins/bower_components/datatables/css/datatables.responsive.css') !!}
@stop

@extends('laravel-authentication-acl::client.layouts.base')

@section('title', trans('front/dashboard/scripts/list.title'))
@section('page', 'page-dashboard-scripts-list') 

@section('navbar-left')
<li class="dropdown">
	<a href="{!! URL::route('dashboard.scripts.new') !!}" class="dropdown-toggle">
		<i class="fa fa-edit"></i> {{ trans('front/dashboard/scripts/list.navbar-left-new-script') }}
	</a>
</li>
@endsection
@section('content')
<!-- START @PAGE CONTENT -->
<section id="page-content">

	<!-- Start page header -->
	<div class="header-content">
		<h2><i class="fa fa-code-fork"></i> {{ trans('front/dashboard/scripts/list.header-title') }} <span>{{ trans('front/dashboard/scripts/list.header-title-small') }}</span></h2>
		<div class="breadcrumb-wrapper hidden-xs">
			<span class="label">{{ trans('front/dashboard/scripts/list.header-you-are-here') }}:</span>
			<ol class="breadcrumb">
				<li>
					<i class="fa fa-angle-right"></i>
					<a href="{!! URL::route('dashboard.index') !!}">{{ trans('front/dashboard/scripts/list.breadcrumb-home') }}</a>
					<i class="fa fa-angle-right"></i>
				</li>
				<li>
					<a href="#">{{ trans('front/dashboard/scripts/list.breadcrumb-scripts') }}</a>
					<i class="fa fa-angle-right"></i>
				</li>
				<li class="active">{{ trans('front/dashboard/scripts/list.breadcrumb-active') }}</li>
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
									<th style="min-width: 10px;" data-hide="phone, tablet">{{ trans('front/dashboard/scripts/list.table-header-key') }}</th>
									<th data-class="expand">{{ trans('front/dashboard/scripts/list.table-header-name') }}</th>
									<th data-hide="phone, tablet">{{ trans('front/dashboard/scripts/list.table-header-game') }}</th>
									<th data-hide="phone, tablet">{{ trans('front/dashboard/scripts/list.table-header-category') }}</th>
									<th data-hide="phone, tablet">{{ trans('front/dashboard/scripts/list.table-header-price') }}</th>
									<th data-hide="phone, tablet">{{ trans('front/dashboard/scripts/list.table-header-price-discount') }}</th>
									<th data-hide="phone, tablet" class="text-center">{{ trans('front/dashboard/scripts/list.table-header-active') }}</th>
									<th data-hide="phone, tablet" class="text-center">{{ trans('front/dashboard/scripts/list.table-header-reason') }}</th>
									<th data-hide="phone, tablet" class="text-center" style="width: 300px;">{{ trans('front/dashboard/scripts/list.table-header-action') }}</th>
								</tr>
								</thead>
							<tbody>
								@if(!$scripts->isEmpty())
								@foreach($scripts as $key => $script)
								<tr class="{{ $script->reason->class }}">
									<td>{!! $key !!}</td>
									<td>{!! $script->title !!}</td>
									<td>{!! $script->game->title !!}</td>
									<td>{!! $script->category->title !!}</td>
									<td>{!! number_format($script->price, 2) !!} $</td>
									<td>{!! number_format($script->price_discount, 2) !!} $</td>
									<td class="text-center">{!! $script->activated ? '<i class="fa fa-check"></i>' : '<i class="fa fa-close"></i>' !!}</td>
									<td>{!! $script->reason->reason !!}</td>
									<td class="text-center">
									
										<a target="_blank" href="{!! URL::route('scripts.view', ['id' => $script->id, 'game' => App\Http\Classes\Slug::filter($script->game->title), 'category' => App\Http\Classes\Slug::filter($script->category->title), 'title' => App\Http\Classes\Slug::filter($script->title) ]) !!}" class="btn btn-warning btn-xs btn-push" data-toggle="tooltip" data-placement="top" data-original-title="{{ trans('front/dashboard/scripts/list.table-view') }}"><i class="fa fa-eye"></i> {{ trans('front/dashboard/scripts/list.table-view') }}</a>
										
										<a href="{!! URL::route('dashboard.scripts.edit', ['script_id' => $script->id]) !!}" class="btn btn-primary btn-xs btn-push" data-toggle="tooltip" data-placement="top" data-original-title="{{ trans('front/dashboard/scripts/list.table-edit') }}"><i class="fa fa-pencil"></i> {{ trans('front/dashboard/scripts/list.table-edit') }}</a>
										
										@if($script->reason_id == 2)
											<a href="{!! URL::route('dashboard.scripts.disable', ['id' => $script->id]) !!}" class="btn btn-danger btn-xs btn-push" data-toggle="tooltip" data-placement="top" data-original-title="{{ trans('front/dashboard/scripts/list.table-disable') }}"><i class="fa fa-close"></i> {{ trans('front/dashboard/scripts/list.table-disable') }}</a>
										@elseif($script->reason_id == 10 || ($script->reason_id == 9 && !$script->user->isBanned()))
											<a href="{!! URL::route('dashboard.scripts.active', ['id' => $script->id]) !!}" class="btn btn-success btn-xs btn-push" data-toggle="tooltip" data-placement="top" data-original-title="{{ trans('front/dashboard/scripts/list.table-active') }}"><i class="fa fa-close"></i> {{ trans('front/dashboard/scripts/list.table-active') }}</a>	
										@endif
										
										@if($script->price > 0 || $script->price_discount > 0)
											<a target="_blank" href="{!! URL::route('purchase.scripts', ['id' => $script->id]) !!}" class="btn btn-success btn-xs btn-push" data-toggle="tooltip" data-placement="top" data-original-title="{{ trans('front/dashboard/scripts/list.table-purchase') }}"><i class="fa fa-dollar"></i> {{ trans('front/dashboard/scripts/list.table-purchase') }}</a>
										@endif
										
									</td>
								</tr>
								@endforeach
								@endif
							</tbody>
							<tfoot>
								<tr>
									<th style="min-width: 10px;" data-hide="phone, tablet">{{ trans('front/dashboard/scripts/list.table-header-key') }}</th>
									<th data-class="expand">{{ trans('front/dashboard/scripts/list.table-header-name') }}</th>
									<th data-hide="phone, tablet">{{ trans('front/dashboard/scripts/list.table-header-game') }}</th>
									<th data-hide="phone, tablet">{{ trans('front/dashboard/scripts/list.table-header-category') }}</th>
									<th data-hide="phone, tablet">{{ trans('front/dashboard/scripts/list.table-header-price') }}</th>
									<th data-hide="phone, tablet">{{ trans('front/dashboard/scripts/list.table-header-price-discount') }}</th>
									<th data-hide="phone, tablet" class="text-center">{{ trans('front/dashboard/scripts/list.table-header-active') }}</th>
									<th data-hide="phone, tablet" class="text-center">{{ trans('front/dashboard/scripts/list.table-header-reason') }}</th>
									<th data-hide="phone, tablet" class="text-center" style="width: 300px;">{{ trans('front/dashboard/scripts/list.table-header-action') }}</th>
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
	{!! Html::script('assets/admin/js/pages/blankon.dashboard.scripts.list.js') !!}
    <script>
        $(".delete").click(function(){
            return confirm('{!! trans("front/dashboard/scripts/list.confirm-delete") !!}');
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
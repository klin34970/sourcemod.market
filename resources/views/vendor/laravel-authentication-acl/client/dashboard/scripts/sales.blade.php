@section('styles')
	{!! Html::style('assets/global/plugins/bower_components/datatables/css/dataTables.bootstrap.css') !!}
	{!! Html::style('assets/global/plugins/bower_components/datatables/css/datatables.responsive.css') !!}
	{!! Html::style('assets/global/plugins/bower_components/fuelux/dist/css/fuelux.min.css') !!}
@stop

@extends('laravel-authentication-acl::client.layouts.base')

@section('title', trans('front/dashboard/scripts/sales.title'))
@section('page', 'page-dashboard-scripts-list') 

@section('content')
<!-- START @PAGE CONTENT -->
<section id="page-content">

	<!-- Start page header -->
	<div class="header-content">
		<h2><i class="fa fa-code-fork"></i> {{ trans('front/dashboard/scripts/sales.header-title') }} <span>{{ trans('front/dashboard/scripts/sales.header-title-small') }}</span></h2>
		<div class="breadcrumb-wrapper hidden-xs">
			<span class="label">{{ trans('front/dashboard/scripts/sales.header-you-are-here') }}:</span>
			<ol class="breadcrumb">
				<li>
					<i class="fa fa-angle-right"></i>
					<a href="{!! URL::route('dashboard.index') !!}">{{ trans('front/dashboard/scripts/sales.breadcrumb-home') }}</a>
					<i class="fa fa-angle-right"></i>
				</li>
				<li>
					<a href="#">{{ trans('front/dashboard/scripts/sales.breadcrumb-scripts') }}</a>
					<i class="fa fa-angle-right"></i>
				</li>
				<li class="active">{{ trans('front/dashboard/scripts/sales.breadcrumb-active') }}</li>
			</ol>
		</div><!-- /.breadcrumb-wrapper -->
	</div><!-- /.header-content -->
	<!--/ End page header -->

	@if(!$sales->isEmpty())
	<!-- Start body content -->
	<div class="body-content animated fadeIn">

		<div class="row">
			<div class="col-md-12">
			
				<!-- Start datatable using dom -->
				<div class="panel rounded shadow">
					<div class="panel-body">
						<!-- Start datatable -->
						<table id="datatable-dom" class="table table-striped table-theme">
								<thead>
								<tr>
									<th data-class="expand">{{ trans('front/dashboard/scripts/sales.table-header-image') }}</th>
									<th data-hide="phone, tablet">{{ trans('front/dashboard/scripts/sales.table-header-title') }}</th>
									<th data-hide="phone, tablet">{{ trans('front/dashboard/scripts/sales.table-header-user') }}</th>
									<th data-hide="phone, tablet">{{ trans('front/dashboard/scripts/sales.table-header-amount') }}</th>
									<th data-hide="phone, tablet">{{ trans('front/dashboard/scripts/sales.table-header-comission') }}</th>
									<th data-hide="phone, tablet">{{ trans('front/dashboard/scripts/sales.table-header-date') }}</th>
								</tr>
								</thead>
							<tbody>
								@foreach($sales as $key => $sale)
								<tr>
									<td class="text-center" style="width: 1%">
										<img src="/assets/images/scripts/{{ $sale->script_id }}/340x96.jpg" width="160" class="mt-5 mb-5">
									</td>
									
									<td>
										<a target="_blank" href="{!! URL::route('scripts.view', ['id' => $sale->script_id, 'game' => App\Http\Classes\Slug::filter($sale->script->game->title), 'category' => App\Http\Classes\Slug::filter($sale->script->category->title), 'title' => App\Http\Classes\Slug::filter($sale->script->title) ]) !!}">
											{!! $sale->script->title !!}
										</a>
									</td>
									
									<td>
										<a href="{{ URL::route('users.view', ['id' => $sale->user_id]) }}">
											@if(isset($sale->user->user_profile->first()->first_name))
												{!! $sale->user->user_profile->first()->first_name !!}
											@else
												{!! $sale->user->steam_id !!}
											@endif
										</a>
									</td>
									
									<td>{!! number_format($sale->amount - $sale->comission, 2) !!} $</td>
									<td>{!! number_format($sale->comission, 2) !!} $</td>
									
									<td>{!! $sale->created_at->diffForHumans() !!}</td>
									
								</tr>
								@endforeach
							</tbody>
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
	{!! Html::script('assets/admin/js/pages/blankon.dashboard.scripts.sales.js') !!}
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
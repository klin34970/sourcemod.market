@section('styles')
	{!! Html::style('assets/global/plugins/bower_components/datatables/css/dataTables.bootstrap.css') !!}
	{!! Html::style('assets/global/plugins/bower_components/datatables/css/datatables.responsive.css') !!}
	{!! Html::style('assets/global/plugins/bower_components/fuelux/dist/css/fuelux.min.css') !!}
@stop

@extends('laravel-authentication-acl::client.layouts.base')

@section('title', trans('front/dashboard/scripts/purchase.title'))
@section('page', 'page-dashboard-scripts-list') 




@section('content')
<!-- START @PAGE CONTENT -->
<section id="page-content">

	<!-- Start page header -->
	<div class="header-content">
		<h2><i class="fa fa-code-fork"></i> {{ trans('front/dashboard/scripts/purchase.header-title') }} <span>{{ trans('front/dashboard/scripts/purchase.header-title-small') }}</span></h2>
		<div class="breadcrumb-wrapper hidden-xs">
			<span class="label">{{ trans('front/dashboard/scripts/purchase.header-you-are-here') }}:</span>
			<ol class="breadcrumb">
				<li>
					<i class="fa fa-angle-right"></i>
					<a href="{!! URL::route('dashboard.index') !!}">{{ trans('front/dashboard/scripts/purchase.breadcrumb-home') }}</a>
					<i class="fa fa-angle-right"></i>
				</li>
				<li>
					<a href="#">{{ trans('front/dashboard/scripts/purchase.breadcrumb-scripts') }}</a>
					<i class="fa fa-angle-right"></i>
				</li>
				<li class="active">{{ trans('front/dashboard/scripts/purchase.breadcrumb-active') }}</li>
			</ol>
		</div><!-- /.breadcrumb-wrapper -->
	</div><!-- /.header-content -->
	<!--/ End page header -->

	@if(!$purchases->isEmpty())
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
									<th data-class="expand">{{ trans('front/dashboard/scripts/purchase.table-header-image') }}</th>
									<th data-hide="phone, tablet">{{ trans('front/dashboard/scripts/purchase.table-header-title') }}</th>
									<th data-hide="phone, tablet">{{ trans('front/dashboard/scripts/purchase.table-header-key') }}</th>
									<th data-hide="phone, tablet">{{ trans('front/dashboard/scripts/purchase.table-header-amount') }}</th>
									<th data-hide="phone, tablet">{{ trans('front/dashboard/scripts/purchase.table-header-tax') }}</th>
									<th data-hide="phone, tablet">{{ trans('front/dashboard/scripts/purchase.table-header-date') }}</th>
									<th data-hide="phone, tablet" class="text-center" style="width: 200px;">{{ trans('front/dashboard/scripts/purchase.table-header-action') }}</th>
								</tr>
								</thead>
							<tbody>
								@foreach($purchases as $key => $purchase)
								<tr>
									<td class="text-center" style="width: 1%">
										<img src="/assets/images/scripts/{{ $purchase->script_id }}/340x96.jpg" width="160" class="mt-5 mb-5">
									</td>
									<td>
										<a target="_blank" href="{!! URL::route('scripts.view', ['id' => $purchase->script_id, 'game' => App\Http\Classes\Slug::filter($purchase->script->game->title), 'category' => App\Http\Classes\Slug::filter($purchase->script->category->title), 'title' => App\Http\Classes\Slug::filter($purchase->script->title) ]) !!}">
											{!! $purchase->script->title !!}
										</a>
									</td>
									<td>
										@if($purchase->status == 'COMPLETED')
											<a target="_blank" href="https://www.paypal.com/cgi-bin/webscr?cmd=_view-a-trans&id={!! $purchase->transaction_0_id_for_sender_txn !!}">
												{!! $purchase->transaction_0_id_for_sender_txn !!}
											</a>
											<br>
											<a target="_blank" href="https://www.paypal.com/cgi-bin/webscr?cmd=_view-a-trans&id={!! $purchase->transaction_1_id_for_sender_txn !!}">
												{!! $purchase->transaction_1_id_for_sender_txn !!}
											</a>
										@elseif($purchase->status == 'GIFT')
											GIFT
										@endif
									</td>
									<td>{!! number_format($purchase->amount, 2) !!} $</td>
									<td>{!! number_format($purchase->tax, 2) !!} $</td>
									<td>{!! $purchase->created_at->diffForHumans() !!}</td>
									<td class="text-center">
									<a target="_blank" href="{!! URL::route('scripts.view', ['id' => $purchase->script_id, 'game' => App\Http\Classes\Slug::filter($purchase->script->game->title), 'category' => App\Http\Classes\Slug::filter($purchase->script->category->title), 'title' => App\Http\Classes\Slug::filter($purchase->script->title) ]) !!}" class="btn btn-success btn-xs btn-push" data-toggle="tooltip" data-placement="top" data-original-title="{{ trans('front/dashboard/scripts/purchase.table-view') }}"><i class="fa fa-eye"></i> {{ trans('front/dashboard/scripts/purchase.table-view') }}</a>
									
									<a target="_blank" href="{!! URL::route('scripts.view.downloads', ['script_id' => $purchase->script_id, 'version_id' => $purchase->script->versions->first()->id]) !!}" class="btn btn-danger btn-xs btn-push" data-toggle="tooltip" data-placement="top" data-original-title="{{ trans('front/dashboard/scripts/purchase.table-view') }}"><i class="fa fa-download"></i> {{ trans('front/dashboard/scripts/purchase.table-download') }}</a>
									</td>
									
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
	{!! Html::script('assets/admin/js/pages/blankon.dashboard.scripts.purchases.js') !!}
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
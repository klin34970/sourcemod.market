@section('styles')
	{!! Html::style('assets/global/plugins/bower_components/datatables/css/dataTables.bootstrap.css') !!}
	{!! Html::style('assets/global/plugins/bower_components/datatables/css/datatables.responsive.css') !!}
@stop

@extends('laravel-authentication-acl::client.layouts.base')

@section('title', trans('front/dashboard/api/keys/list.title'))
@section('page', 'page-dashboard-api-keys') 

@section('navbar-left')
<li class="dropdown">
	<a href="{!! URL::route('dashboard.api.keys.new') !!}" class="dropdown-toggle">
		<i class="fa fa-edit"></i> {{ trans('front/dashboard/api/keys/list.navbar-left-new-api-key') }}
	</a>
</li>
@endsection
@section('content')
<!-- START @PAGE CONTENT -->
<section id="page-content">

	<!-- Start page header -->
	<div class="header-content">
		<h2><i class="fa fa-code-fork"></i> {{ trans('front/dashboard/api/keys/list.header-title') }} <span>{{ trans('front/dashboard/api/keys/list.header-title-small') }}</span></h2>
		<div class="breadcrumb-wrapper hidden-xs">
			<span class="label">{{ trans('front/dashboard/api/keys/list.header-you-are-here') }}:</span>
			<ol class="breadcrumb">
				<li>
					<i class="fa fa-angle-right"></i>
					<a href="{!! URL::route('dashboard.index') !!}">{{ trans('front/dashboard/api/keys/list.breadcrumb-home') }}</a>
					<i class="fa fa-angle-right"></i>
				</li>
				<li>
					<a href="#">{{ trans('front/dashboard/api/keys/list.breadcrumb-api-keys') }}</a>
					<i class="fa fa-angle-right"></i>
				</li>
				<li class="active">{{ trans('front/dashboard/api/keys/list.breadcrumb-active') }}</li>
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
									<th style="min-width: 10px;" data-hide="phone, tablet">{{ trans('front/dashboard/api/keys/list.table-header-key') }}</th>
									<th data-class="expand">{{ trans('front/dashboard/api/keys/list.table-header-api-key') }}</th>
									<th data-hide="phone, tablet" class="text-center" style="width: 200px;">{{ trans('front/dashboard/api/keys/list.table-header-action') }}</th>
								</tr>
								</thead>
							<tbody>
								@if(!$api_keys->isEmpty())
								@foreach($api_keys as $key => $api_key)
								<tr>
									<td>{{ $key }}</td>
									<td>{{ $api_key->key }}</td>
									<td class="text-center">
										<a class="btn btn-warning btn-xs btn-push" href="{{ URL::route('dashboard.api.keys.edit', ['id' => $api_key->id]) }}"><i class="fa fa-pencil"></i> {{ trans('front/dashboard/api/keys/list.table-edit') }}
										</a>	
									</td>
								</tr>
								@endforeach
								@endif
							</tbody>
							<tfoot>
								<tr>
									<th style="min-width: 10px;" data-hide="phone, tablet">{{ trans('front/dashboard/api/keys/list.table-header-key') }}</th>
									<th data-class="expand">{{ trans('front/dashboard/api/keys/list.table-header-api-key') }}</th>
									<th data-hide="phone, tablet" class="text-center" style="width: 200px;">{{ trans('front/dashboard/api/keys/list.table-header-action') }}</th>
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
	{!! Html::script('assets/admin/js/pages/blankon.dashboard.api.keys.list.js') !!}
    <script>
        $(".delete").click(function(){
            return confirm('{!! trans("front/dashboard/api/keys/list.confirm-delete") !!}');
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
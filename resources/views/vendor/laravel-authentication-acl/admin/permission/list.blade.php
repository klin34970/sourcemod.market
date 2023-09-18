@section('styles')
	{!! Html::style('http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700') !!}
	
    {!! Html::style('assets/global/plugins/bower_components/bootstrap/dist/css/bootstrap.min.css') !!}
    {!! Html::style('assets/global/plugins/bower_components/fontawesome/css/font-awesome.min.css') !!}
    {!! Html::style('assets/global/plugins/bower_components/animate.css/animate.min.css') !!}
	{!! Html::style('assets/global/plugins/bower_components/datatables/css/dataTables.bootstrap.css') !!}
	{!! Html::style('assets/global/plugins/bower_components/datatables/css/datatables.responsive.css') !!}
	{!! Html::style('assets/global/plugins/bower_components/fuelux/dist/css/fuelux.min.css') !!}
	
	{!! Html::style('assets/admin/css/reset.css') !!}
	{!! Html::style('assets/admin/css/layout.css') !!}
	{!! Html::style('assets/admin/css/components.css') !!}
	{!! Html::style('assets/admin/css/plugins.css') !!}
	{!! Html::style('assets/admin/css/themes/default.theme.css', ['id'=>'theme']) !!}
	{!! Html::style('assets/admin/css/custom.css') !!}
@stop

@extends('laravel-authentication-acl::admin.layouts.base')

@section('title', trans('admin/permissions/list.title'))
@section('page', 'page-permissions-list')

@section('content')
<!-- START @PAGE CONTENT -->
<section id="page-content">

	<!-- Start page header -->
	<div class="header-content">
		<h2><i class="fa fa-lock"></i> {{ trans('admin/permissions/list.header-title') }} <span>{{ trans('admin/permissions/list.header-title-small') }}</span></h2>
		<div class="breadcrumb-wrapper hidden-xs">
			<span class="label">{{ trans('admin/permissions/list.header-you-are-here') }}:</span>
			<ol class="breadcrumb">
				<li>
					<i class="fa fa-angle-right"></i>
					<a href="{!! URL::route('dashboard.default') !!}">{{ trans('admin/permissions/list.breadcrumb-home') }}</a>
					<i class="fa fa-angle-right"></i>
				</li>
				<li>
					<a href="#">{{ trans('admin/permissions/list.breadcrumb-permissions') }}</a>
					<i class="fa fa-angle-right"></i>
				</li>
				<li class="active">{{ trans('admin/permissions/list.breadcrumb-active') }}</li>
			</ol>
		</div><!-- /.breadcrumb-wrapper -->
	</div><!-- /.header-content -->
	<!--/ End page header -->

	@if( ! $permissions->isEmpty() )
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
									<th data-class="expand">{{ trans('admin/permissions/list.table-header-description') }}</th>
									<th data-hide="phone, tablet">{{ trans('admin/permissions/list.table-header-name') }}</th>
									<th data-hide="phone, tablet" class="text-center" style="width: 200px;">{{ trans('admin/permissions/list.table-header-action') }}</th>
								</tr>
								</thead>
							<tbody>
								@foreach($permissions as $permission)
								<tr>
									<td>{!! $permission->description !!}</td>
									<td>{!! $permission->permission !!}</td>
									<td class="text-center">
										@if(! $permission->protected)
										<a href="{!! URL::route('permission.edit', ['id' => $permission->id]) !!}" class="btn btn-primary btn-xs btn-push" data-toggle="tooltip" data-placement="top" data-original-title="{{ trans('admin/permissions/list.table-edit-tooltip') }}"><i class="fa fa-pencil"></i> {{ trans('admin/permissions/list.table-edit') }}</a>
										<a href="{!! URL::route('permission.delete',['id' => $permission->id, '_token' => csrf_token()]) !!}" class="btn btn-danger btn-xs delete btn-push" data-toggle="tooltip" data-placement="top" data-original-title="{{ trans('admin/permissions/list.table-delete-tooltip') }}"><i class="fa fa-times"></i> {{ trans('admin/permissions/list.table-delete') }}</a>
										@endif
									</td>
								</tr>
								@endforeach
							</tbody>
							<tfoot>
								<tr>
									<th data-class="expand">{{ trans('admin/permissions/list.table-header-description') }}</th>
									<th data-hide="phone, tablet">{{ trans('admin/permissions/list.table-header-name') }}</th>
									<th data-hide="phone, tablet" class="text-center" style="width: 200px;">{{ trans('admin/permissions/list.table-header-action') }}</th>
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

</section><!-- /#page-content -->
<!--/ END PAGE CONTENT -->
@endsection

@section('scripts')	
	{!! Html::script('assets/global/plugins/bower_components/jquery/dist/jquery.min.js') !!}
	{!! Html::script('assets/global/plugins/bower_components/jquery-cookie/jquery.cookie.js') !!}
	{!! Html::script('assets/global/plugins/bower_components/bootstrap/dist/js/bootstrap.min.js') !!}
	{!! Html::script('assets/global/plugins/bower_components/jquery-easing-original/jquery.easing.1.3.min.js') !!}
	{!! Html::script('assets/global/plugins/bower_components/ionsound/js/ion.sound.min.js') !!}
	{!! Html::script('assets/global/plugins/bower_components/retina.js/dist/retina.min.js') !!}
	{!! Html::script('assets/global/plugins/bower_components/typehead.js/dist/handlebars.js') !!}
	{!! Html::script('assets/global/plugins/bower_components/typehead.js/dist/typeahead.bundle.min.js') !!}
	{!! Html::script('assets/global/plugins/bower_components/jquery-nicescroll/jquery.nicescroll.min.js') !!}
	{!! Html::script('assets/global/plugins/bower_components/jquery.sparkline.min/index.js') !!}
	{!! Html::script('assets/global/plugins/bower_components/bootbox/bootbox.js') !!}
	{!! Html::script('assets/global/plugins/bower_components/datatables/js/jquery.dataTables.min.js') !!}
	{!! Html::script('assets/global/plugins/bower_components/datatables/js/dataTables.bootstrap.js') !!}
	{!! Html::script('assets/global/plugins/bower_components/datatables/js/datatables.responsive.js') !!}
	{!! Html::script('assets/global/plugins/bower_components/fuelux/dist/js/fuelux.min.js') !!}
	{!! Html::script('assets/admin/js/apps.js') !!}
	{!! Html::script('assets/admin/js/pages/blankon.perms.list.js') !!}
	{!! Html::script('assets/admin/js/demo.js') !!}
    <script>
        $(".delete").click(function(){
            return confirm('{!! trans("admin/permissions/list.confirm-delete") !!}');
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
@section('styles')
	{!! Html::style('assets/global/plugins/bower_components/c3js-chart/c3.min.css') !!}
	<style>
		.jqstooltip
		{
			width:auto!important;
		}
	</style>
@stop

@extends('laravel-authentication-acl::client.layouts.base')

@section('title', trans('front/dashboard/view.title'))
@section('page', 'page-dashboard') 


@section('content')
<!-- START @PAGE CONTENT -->
<section id="page-content">

	<!-- Start page header -->
	<div class="header-content">
		<h2><i class="fa fa-pencil"></i> {{ trans('front/dashboard/view.header-title') }} <span>{{ trans('front/dashboard/view.header-title-small') }}</span></h2>
		<div class="breadcrumb-wrapper hidden-xs">
			<span class="label">{{ trans('front/dashboard/view.header-you-are-here') }}:</span>
			<ol class="breadcrumb">
				<li>
					<i class="fa fa-angle-right"></i>
					<a href="{!! URL::route('dashboard.index') !!}">{{ trans('front/dashboard/view.breadcrumb-home') }}</a>
					<i class="fa fa-angle-right"></i>
				</li>
				<li class="active">{{ trans('front/dashboard/view.breadcrumb-active') }}</li>
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

				<!-- Start total investments -->
				<div class="panel rounded shadow panel-default">
				
					<div class="panel-heading">
						<form method="get" class="form-horizontal form-bordered">
							<div class="form-group no-margin no-padding has-feedback">
								<div class="col-md-3">
									<div class="input-group">
										<span class="input-group-addon bg-theme">
											<i class="fa fa-bar-chart-o"></i>
										</span>
										<select class="form-control" autocomplete="off" onchange="this.form.submit()" name="type">
											<option value="">Default</option>
											<option value="bar" {{ Request::get('type') == 'bar' ? 'selected="selected"' : '' }}>Bar</option>
											<option value="line" {{ Request::get('type') == 'line' ? 'selected="selected"' : '' }}>Line</option>
											<option value="spline" {{ Request::get('type') == 'spline' ? 'selected="selected"' : '' }}>Spline</option>
											<option value="area" {{ Request::get('type') == 'area' ? 'selected="selected"' : '' }}>Area</option>
										</select>
									</div>
								</div>
							</div>
						</form>
					</div>
					<div class="panel-body">
						<div id="total-investments" class="chart"></div>
						
						
						<div class="col-md-2 col-sm-4 col-xs-12 col-xs-override border-right dotted">
							<div class="mini-stat no-padding no-margin">
								<span class="mini-stat-chart">
									<span id="chart_purchases">{{implode(', ',$charts_spend)}}</span>
								</span><!-- /.mini-stat-chart -->
								<div class="mini-stat-info text-right">
									<span>${{array_sum($charts_spend)}}</span>
									<p class="text-muted no-margin">{{ trans('front/dashboard/view.total-spend') }}</p>
								</div><!-- /.mini-stat-info -->
							</div><!-- /.mini-stat -->
						</div>
						
						<div class="col-md-2 col-sm-4 col-xs-12 col-xs-override border-right dotted">
							<div class="mini-stat no-padding no-margin">
								<span class="mini-stat-chart">
									<span id="chart_profit">{{implode(', ',$charts_gains)}}</span>
								</span><!-- /.mini-stat-chart -->
								<div class="mini-stat-info text-right">
									<span>${{array_sum($charts_gains)}}</span>
									<p class="text-muted no-margin">{{ trans('front/dashboard/view.total-profit') }}</p>
								</div><!-- /.mini-stat-info -->
							</div><!-- /.mini-stat -->
						</div>
						
						<div class="col-md-2 col-sm-4 col-xs-12 col-xs-override border-right dotted">
							<div class="mini-stat no-padding no-margin">
								<span class="mini-stat-chart">
									<span id="chart_downloads">{{implode(', ',$charts_downloads)}}</span>
								</span><!-- /.mini-stat-chart -->
								<div class="mini-stat-info text-right">
									<span>{{array_sum($charts_downloads)}}</span>
									<p class="text-muted no-margin">{{ trans('front/dashboard/view.total-downloads') }}</p>
								</div><!-- /.mini-stat-info -->
							</div><!-- /.mini-stat -->
						</div>
						
						<div class="col-md-2 col-sm-4 col-xs-12 col-xs-override border-right dotted">
							<div class="mini-stat no-padding no-margin">
								<span class="mini-stat-chart">
									<span id="chart_taxes">{{implode(', ',$charts_taxes)}}</span>
								</span><!-- /.mini-stat-chart -->
								<div class="mini-stat-info text-right">
									<span>${{array_sum($charts_taxes)}}</span>
									<p class="text-muted no-margin">{{ trans('front/dashboard/view.total-taxes') }}</p>
								</div><!-- /.mini-stat-info -->
							</div><!-- /.mini-stat -->
						</div>
						
						<div class="col-md-2 col-sm-4 col-xs-12 col-xs-override border-right dotted">
							<div class="mini-stat no-padding no-margin">
								<span class="mini-stat-chart">
									<span id="chart_comissions">{{implode(', ',$charts_comissions)}}</span>
								</span><!-- /.mini-stat-chart -->
								<div class="mini-stat-info text-right">
									<span>${{array_sum($charts_comissions)}}</span>
									<p class="text-muted no-margin">{{ trans('front/dashboard/view.total-comissions') }}</p>
								</div><!-- /.mini-stat-info -->
							</div><!-- /.mini-stat -->
						</div>
						
						<div class="col-md-2 col-sm-4 col-xs-12 col-xs-override border-right dotted">
							<div class="mini-stat no-padding no-margin">
								<span class="mini-stat-chart">
									<span id="chart_issues">{{implode(', ',$charts_issues)}}</span>
								</span><!-- /.mini-stat-chart -->
								<div class="mini-stat-info text-right">
									<span>{{array_sum($charts_issues)}}</span>
									<p class="text-muted no-margin">{{ trans('front/dashboard/view.total-issues') }}</p>
								</div><!-- /.mini-stat-info -->
							</div><!-- /.mini-stat -->
						</div>
						
						
					</div><!-- /.panel-body -->
				</div><!-- /.panel -->
				<!--/ End total investments -->
							

			</div><!-- /.col-md-12 -->
		</div><!-- /.row -->

	</div><!-- /.body-content -->
	<!--/ End body content -->
	
	@include('laravel-authentication-acl::client.layouts.partials.footer')

</section><!-- /#page-content -->
<!--/ END PAGE CONTENT -->
@endsection

@section('scripts')	
	{!! Html::script('assets/global/plugins/bower_components/d3/d3.min.js') !!}
	{!! Html::script('assets/global/plugins/bower_components/c3js-chart/c3.min.js') !!}
	{!! Html::script('assets/global/plugins/bower_components/flot/jquery.flot.js') !!}
	<script>
		c3.generate({
			bindto: '#total-investments',
			data: 
			{
				x: 'x',
				columns: 
				[
					['x', 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
					['Scripts', {{implode(', ',$charts_scripts)}}],
					['Downloads', {{implode(', ',$charts_downloads)}}],
					['Sales', {{implode(', ',$charts_purchases)}}],
					['Profit', {{implode(', ',$charts_gains)}}],
					['Purchases', {{implode(', ',$charts_spend)}}],
					['Issues', {{implode(', ',$charts_issues)}}],
					
					@if($logged_user->hasPermission(['_superadmin']))
						['Taxes', {{implode(', ',$charts_taxes)}}],
						['Comissions', {{implode(', ',$charts_comissions)}}],
					@endif
				],
				types: 
				{
					Scripts: '{{ Request::has("type") ? Request::get("type") : "bar" }}',
					Downloads: '{{ Request::has("type") ? Request::get("type") : "bar" }}',
					Sales: '{{ Request::has("type") ? Request::get("type") : "bar" }}',
					Profit: '{{ Request::has("type") ? Request::get("type") : "spline" }}',
					Purchases: '{{ Request::has("type") ? Request::get("type") : "spline" }}',
					Issues: '{{ Request::has("type") ? Request::get("type") : "spline" }}',
					
					@if($logged_user->hasPermission(['_superadmin']))
						Taxes: '{{ Request::has("type") ? Request::get("type") : "bar" }}',	
						Comissions: '{{ Request::has("type") ? Request::get("type") : "bar" }}',
					@endif
				},
				// groups: 
				// [
					// ['Scripts','Downloads']
				// ]
			},
			color: 
			{
				pattern: ['#E9573F', '#00B1E1', '#37BC9B', '#906094', '#1f77b4', '#f19b69', '#00c133', '#00c133']
			},
			axis: 
			{
				x: 
				{
					type: 'categorized',
				}
			},
			tooltip: 
			{
				format: 
				{
					value: function (value, ratio, id) 
					{
						var format = (id === 'Profit' || id === 'Purchases') ? d3.format('$') : d3.format('');
						return format(value);
					}
				}
			}
		});
		$('#chart_purchases').sparkline('html',{
			type: 'bar',
			barColor: '#81b71a',
			height: '50px',
			barWidth: '5px'
		});
		$('#chart_profit').sparkline('html',{
			type: 'bar',
			barColor: '#81b71a',
			height: '50px',
			barWidth: '5px'
		});
		$('#chart_downloads').sparkline('html',{
			type: 'bar',
			barColor: '#81b71a',
			height: '50px',
			barWidth: '5px'
		});
		$('#chart_issues').sparkline('html',{
			type: 'bar',
			barColor: '#81b71a',
			height: '50px',
			barWidth: '5px'
		});
		$('#chart_taxes').sparkline('html',{
			type: 'bar',
			barColor: '#81b71a',
			height: '50px',
			barWidth: '5px'
		});
		$('#chart_comissions').sparkline('html',{
			type: 'bar',
			barColor: '#81b71a',
			height: '50px',
			barWidth: '5px'
		});
	</script>
@stop
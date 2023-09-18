@section('styles')
	{!! Html::style('assets/commercial/plugins/cube-portfolio/cubeportfolio/css/cubeportfolio.min.css') !!}
	{!! Html::style('assets/global/plugins/bower_components/ion.rangeSlider/css/ion.rangeSlider.css') !!}
@stop

@extends('laravel-authentication-acl::client.layouts.base')

@if(!$scripts->isEmpty())
	@section('title', 'Scripts')
	@section('description', 'Are you a content creator who wants to publish his work? Sourcemod.Market is the best solution for you! ')
	@section('keywords', 'script, content creator, sourcemod, gmod, css, csgo, plugin, minecraft, market, gta, half life')
	
	@section('og_type', 'website')
	@section('twitter_card', 'summary')
	@section('og_image', url('/') . '/assets/images/logos/banner.png')

@else
	@section('title', 'Scripts not found')
@endif

@section('page', 'page-scripts')		
@section('content')
<!-- START @PAGE CONTENT -->
<section id="page-content">

	<!-- Start body content -->
	<div class="body-content animated fadeIn" style="background-color: #e9eaed;">
			<div class="panel">
				<div class="panel-heading">
					<form class="form-horizontal" method="GET" style="padding-top: 8px!important;">
						<div class="form-group no-margin no-padding has-feedback">
							<div class="col-md-2">
								<div class="input-group">
									<input name="search" class="form-control" type="text" value="{{ Request::has('search') ? Request::get('search') : '' }}">
									<span class="input-group-btn">
										<button type="submit" class="btn btn-theme"><i class="fa fa-search"></i></button>
									</span>
								</div>
							</div>
							<div class="col-md-2">
								<div class="input-group" style="width: 100%;">
								<span class="input-group-addon bg-theme"><i class="fa fa-gamepad"></i></span>
								{!! Form::select('game_id', ['' => 'All'] + App\Http\Models\Front\ScriptModel::_getGamesList(), Request::has('game_id') ? Request::get('game_id') : '', ['class' => 'form-control', 'autocomplete' => 'off', 'onchange' => 'this.form.submit()']) !!}
								</div>
							</div>
							<div class="col-md-2">
								<div class="input-group" style="width: 100%;">
								<span class="input-group-addon bg-theme"><i class="fa fa-folder"></i></span>
								{!! Form::select('category_id', ['' => 'All'] + App\Http\Models\Front\ScriptModel::_getCategoriesList(), Request::has('category_id') ? Request::get('category_id') : '', ['class' => 'form-control', 'autocomplete' => 'off', 'onchange' => 'this.form.submit()']) !!}
								</div>
							</div>
							<div class="col-md-2">
								<div class="input-group" style="width: 100%;">
								<span class="input-group-addon bg-theme"><i class="fa fa-arrow-down"></i></span>
								<select name="sort" class="form-control" onchange="this.form.submit()">
									<option value="">All</option>
									<option value="featured" {{ Request::get('sort') == "featured" ? 'selected' : '' }}>Featured</option>
									<option value="best_rated" {{ Request::get('sort') == "best_rated" ? 'selected' : '' }}>Best rated</option>
									<option value="best_sellers" {{ Request::get('sort') == "best_sellers" ? 'selected' : '' }}>Best sellers</option>
									<option value="newest_items" {{ Request::get('sort') == "newest_items" ? 'selected' : '' }}>Newest items</option>
									<option value="recently_updated" {{ Request::get('sort') == "recently_updated" ? 'selected' : '' }}>Recently updated</option>
									<option value="price_low" {{ Request::get('sort') == "price_low" ? 'selected' : '' }}>Price: low to high</option>
									<option value="price_high" {{ Request::get('sort') == "price_high" ? 'selected' : '' }}>Price: high to low</option>
								</select>
								</div>
							</div>				
							<div class="col-md-2">
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
							<div class="col-md-2">
								<div class="slider-theme">
									<input id="slider" type="text" />
								</div>
							</div>
						</div>
						<input type="hidden" id="from" name="price_min">
						<input type="hidden" id="to" name="price_max">
					</form>
				</div><!-- /.panel-heading -->
				<div class="panel-body"><!-- /.panel-body -->
					@include('laravel-authentication-acl::client.scripts.single')
				</div><!-- /.panel -->
				<div class="panel-footer">
					<div class="text-center">
					{{ $links->appends(['search' => Request::get('search'), 'game_id' => Request::get('game_id'), 'category_id' => Request::get('category_id'), 'sort' => Request::get('sort'), 'added' => Request::get('added'), 'price_min' => Request::get('price_min'), 'price_max' => Request::get('price_max')])->links() }}
					</div>
				</div>
			</div>
	</div><!-- /.body-content -->
	<!--/ End body content -->
	
	@include('laravel-authentication-acl::client.layouts.partials.footer')

</section><!-- /#page-content -->
<!--/ END PAGE CONTENT -->
@endsection

@section('scripts')	
	{!! Html::script('assets/commercial/plugins/cube-portfolio/cubeportfolio/js/jquery.cubeportfolio.min.js') !!}
	{!! Html::script('assets/global/plugins/bower_components/ion.rangeSlider/js/ion.rangeSlider.min.js') !!}
	{!! Html::script('assets/admin/js/pages/blankon.home.js') !!}
	<script>
	
	$("#slider").ionRangeSlider({
                min: 0,
                max: 100,
                from: "{{ Request::has('price_min') ? Request::get('price_min') : 0}}",
				to: "{{ Request::has('price_max') ? Request::get('price_max') : 100}}",
                type: 'double',
                prefix: "$",
                maxPostfix: "+",
                prettify: false,
				onStart: function (data) 
				{
					$('#from').val(data.from);
					$('#to').val(data.to);
				},
				onFinish: function (data) 
				{
					$('#from').val(data.from);
					$('#to').val(data.to);
					$('form').submit();
				},
            });
	</script>
@stop
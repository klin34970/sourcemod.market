@section('styles')	
	{!! Html::style('assets/admin/css/pages/search.css') !!}
	{!! Html::style('assets/admin/css/pages/search-basic.css') !!}
@stop

@extends('laravel-authentication-acl::client.layouts.base')

@section('title', filter_var(Request::get('keywords'), FILTER_SANITIZE_STRING))
@section('description', filter_var(Request::get('keywords'), FILTER_SANITIZE_STRING))
@section('keywords', str_replace(' ', ', ', filter_var(Request::get('keywords'), FILTER_SANITIZE_STRING)))
@section('og_type', 'product')
@section('twitter_card', 'product')
@section('og_image', url('/') . '/assets/images/logos/banner.png')


@section('page', 'page-search') 
@section('content')
<!-- START @PAGE CONTENT -->
<section id="page-content">

	<!-- Start page header -->
	<div class="header-content">
		<h2><i class="fa fa-code"></i> {{ filter_var(Request::get('keywords'), FILTER_SANITIZE_STRING) }}</h2>
	</div><!-- /.header-content -->
	<!--/ End page header -->

	<!-- Start body content -->
	<div class="body-content animated fadeIn">


                    <div class="row">
                        <div class="col-md-12">
							
							@if($search != "")
							<div id="js-filters-tabs" class="cbp-l-filters-big">
                                <div data-filter=".scripts" class="cbp-filter-item-active cbp-filter-item">
                                    Scripts
                                </div>
                                <div data-filter=".users" class="cbp-filter-item">
                                    Users
                                </div>
								<div data-filter=".issues" class="cbp-filter-item">
                                    Issues
                                </div>
								<div data-filter=".forum" class="cbp-filter-item">
                                    Forum
                                </div>
                            </div>
							
                            <div id="js-grid-tabs" class="cbp cbp-l-grid-tabs">
                              
                                <div class="cbp-item scripts">
								@foreach($search as $item)
									@if($item['tab'] == 'scripts')
                                    <div class="search-basic-list">
                                        <div class="media">
                                            <div class="hidden-xs media-left">
                                                <a href="{{ $item['url'] }}">
                                                    <img class="media-object" src="{{ $item['image'] }}" alt="...">
                                                </a>
                                            </div>
                                            <div class="media-body">
                                                <h4 class="media-heading">
                                                    <a href="{{ $item['url'] }}" target="_blank">{!! $item['title'] !!}</a>
                                                </h4>
                                                <a href="{{ $item['url'] }}" target="_blank">{{ $item['url'] }}</a>
                                                <!--<p>
                                                    {!! $item['description'] !!}
                                                </p>-->
                                            </div>
                                        </div>
                                    </div>
									@endif
								@endforeach
                                </div>
								
								<div class="cbp-item users">
								@foreach($search as $item)
									@if($item['tab'] == 'users')
                                    <div class="search-basic-list">
                                        <div class="media">
                                            <div class="hidden-xs media-left">
                                                <a href="{{ $item['url'] }}">
                                                    <img class="media-object" src="{{ $item['image'] }}" alt="...">
                                                </a>
                                            </div>
                                            <div class="media-body">
                                                <h4 class="media-heading">
                                                    <a href="{{ $item['url'] }}" target="_blank">{!! $item['title'] !!}</a>
                                                </h4>
                                                <a href="{{ $item['url'] }}" target="_blank">{{ $item['url'] }}</a>
                                                <!--<p>
                                                    {!! $item['description'] !!}
                                                </p>-->
                                            </div>
                                        </div>
                                    </div>
									@endif
								@endforeach
                                </div>
								
								<div class="cbp-item issues">
								@foreach($search as $item)
									@if($item['tab'] == 'issues')
                                    <div class="search-basic-list">
                                        <div class="media">
                                            <div class="hidden-xs media-left">
                                                <a href="{{ $item['url'] }}">
                                                    <img class="media-object" src="{{ $item['image'] }}" alt="...">
                                                </a>
                                            </div>
                                            <div class="media-body">
                                                <h4 class="media-heading">
                                                    <a href="{{ $item['url'] }}" target="_blank">{!! $item['title'] !!}</a>
                                                </h4>
                                                <a href="{{ $item['url'] }}" target="_blank">{{ $item['url'] }}</a>
                                                <!--<p>
                                                    {!! $item['description'] !!}
                                                </p>-->
                                            </div>
                                        </div>
                                    </div>
									@endif
								@endforeach
                                </div>								
								
								<div class="cbp-item forum">
								@foreach($search as $item)
									@if($item['tab'] == 'forum')
                                    <div class="search-basic-list">
                                        <div class="media">
                                            <div class="media-body">
                                                <h4 class="media-heading">
                                                    <a href="{{ $item['url'] }}" target="_blank">{!! $item['title'] !!}</a>
                                                </h4>
                                                <a href="{{ $item['url'] }}" target="_blank">{{ $item['url'] }}</a>
                                                <!--<p>
                                                    {!! $item['description'] !!}
                                                </p>-->
                                            </div>
                                        </div>
                                    </div>
									@endif
								@endforeach
                                </div>
                            </div>
							@endif
                        </div>
                    </div>


	</div><!-- /.body-content -->
	<!--/ End body content -->
	
	@include('laravel-authentication-acl::client.layouts.partials.footer')

</section><!-- /#page-content -->
<!--/ END PAGE CONTENT -->
@endsection

@section('scripts')	
	{!! Html::script('assets/admin/js/pages/blankon.search.js') !!}
@stop
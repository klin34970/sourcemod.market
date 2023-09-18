@extends('laravel-authentication-acl::client.layouts.base')

@section('title', 'Games')
@section('description', 'List of games')
@section('keywords', 'game, css, cs, csgo, gmod, gta, minecraft')
@section('og_type', 'website')
@section('twitter_card', 'website')
@section('og_image', url('/') . '/assets/images/logos/banner.png')

@section('page', 'page-games') 
@section('content')
<!-- START @PAGE CONTENT -->
<section id="page-content">

	<div style="padding-top:30px;background-color: #eeeeef;"></div>
	<!-- Start body content -->
	<div class="body-content animated fadeIn">

		<div id="js-filters-masonry" class="cbp-l-filters-alignRight" style="margin-bottom: 10px;">
			<div data-filter="*" class="cbp-filter-item-active cbp-filter-item">
				All <div class="cbp-filter-counter"></div>
			</div>
			<div data-filter=".fps" class="cbp-filter-item">
				fps <div class="cbp-filter-counter"></div>
			</div>
			<div data-filter=".mmoprg" class="cbp-filter-item">
				mmoprg <div class="cbp-filter-counter"></div>
			</div>
			<div data-filter=".sandbox" class="cbp-filter-item">
				sandbox <div class="cbp-filter-counter"></div>
			</div>
		</div>

		<div id="js-grid-masonry" class="cbp">
			@foreach($games as $game)
			<div class="cbp-item {{ $game->genre }}">
				<a class="cbp-caption" href="{{ URL::route('games.scripts.list', ['id' => $game->id, 'title' => App\Http\Classes\Slug::filter($game->title)]) }}">
					<div class="cbp-caption-defaultWrap">
						<img src="{{ $game->image }}">
					</div>
					<div class="cbp-caption-activeWrap">
						<div class="cbp-l-caption-alignCenter">
							<div class="cbp-l-caption-body">
								<div class="cbp-l-caption-title">{{ $game->title }}</div>
								<div class="cbp-l-caption-title">{{ $game->scripts->count()}} {{ trans('front/games/view.scripts') }}</div>
							</div>
						</div>
					</div>
				</a>
			</div>
			@endforeach

		</div>

	</div><!-- /.body-content -->
	<!--/ End body content -->


	@include('laravel-authentication-acl::client.layouts.partials.footer')

</section><!-- /#page-content -->
<!--/ END PAGE CONTENT -->
@endsection

@section('scripts')	
	{!! Html::script('assets/admin/js/pages/blankon.games.js') !!}
@stop
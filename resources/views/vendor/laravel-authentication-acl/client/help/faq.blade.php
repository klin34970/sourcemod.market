@section('styles')
	{{ Html::style('assets/admin/css/pages/faq.css') }}
@endsection

@extends('laravel-authentication-acl::client.layouts.base')

@section('title', 'FAQ')
@section('description', 'faq')
@section('keywords', 'faq, help, buyer, seller, order, purchase')
@section('og_type', 'website')
@section('twitter_card', 'website')
@section('og_image', url('/') . '/assets/images/logos/banner.png')

@section('page', 'page-help-faq') 
@section('content')
<!-- START @PAGE CONTENT -->
<section id="page-content">

	<!-- Start body content -->
	<div class="body-content animated fadeIn">

		<div class="row">
			<div class="col-md-12">

				<div class="panel shadow panel-primary">
					<div class="panel-heading">
						<div class="pull-left">
							<h3 class="panel-title">FAQ</h3>
						</div>
						<div class="pull-right">
							<div id="filters-container" class="cbp-l-filters-underline cbp-l-filters-text no-margin">
								<div data-filter="*" class="cbp-filter-item-active cbp-filter-item">
									All <div class="cbp-filter-counter"></div>
								</div>
								@foreach($faq_categories as $faq_category)
								<div data-filter=".{{ strtolower($faq_category->title) }}" class="cbp-filter-item">
								{{ $faq_category->title }} <div class="cbp-filter-counter"></div>
								</div>
								@endforeach
							</div>
						</div>
						<div class="clearfix"></div>
					</div><!-- /.panel-heading -->
					<div class="panel-body pt-20">

					
					<div id="grid-container" class="cbp cbp-l-grid-faq">
						@foreach($faq as $item)
						<div class="cbp-item {{ strtolower($item->category->title) }}">
							<div class="cbp-caption">
								<div class="cbp-caption-defaultWrap">
									<i class="{{ $item->icon }} margin-right-5"></i>
									{{ $item->title }}
								</div>
								<div class="cbp-caption-activeWrap">
									<div class="cbp-l-caption-body">
									{!! $item->text !!}
									</div>
								</div>
							</div>
						</div>
						@endforeach
					</div>

					</div><!-- /.panel-body -->
				</div>

			</div>
		</div><!-- /.row -->

	</div><!-- /.body-content -->
	<!--/ End body content -->
	
	@include('laravel-authentication-acl::client.layouts.partials.footer')

</section><!-- /#page-content -->
<!--/ END PAGE CONTENT -->
@endsection

@section('scripts')
	{{ Html::script('assets/admin/js/pages/blankon.help.faq.js') }}
@endsection
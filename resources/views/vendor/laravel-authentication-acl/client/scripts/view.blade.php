@extends('laravel-authentication-acl::client.layouts.base')

@section('title', $script->title)
@section('description', App\Http\Classes\Word::limitWord(App\Http\Classes\Word::cleanDescription($script->description), 20))
@section('keywords', $script->tags)
@section('og_type', 'product')
@section('twitter_card', 'product')
@section('og_image', url('/') . '/assets/images/scripts/'.$script->id.'/750x212.jpg')


@section('page', 'page-scripts') 
@section('content')
<!-- START @PAGE CONTENT -->
<section id="page-content">

	<!-- Start page header -->
	<div class="header-content">
		<h2><i class="fa fa-code"></i> {{ $script->title }}</h2>
	</div><!-- /.header-content -->
	<!--/ End page header -->

	<!-- Start body content -->
	<div class="body-content animated fadeIn">

		<div class="row" id="blog-single">

			@if (count($errors) > 0)
				<div class="alert alert-danger">
					<ul>
						@foreach($errors->all() as $error)
							<li>{{ $error }}</li>
						@endforeach
					</ul>
				</div>
			@endif
			
			<div class="col-lg-9 col-md-9 col-sm-8 col-xs-12">
				
				@if(!$script->activated)
					<div class="alert alert-info">
						{!! trans('front/scripts/view.info-activated') !!}
					</div>
				@endif
				
				<div class="panel panel-tab rounded shadow">
				
					@include('laravel-authentication-acl::client.scripts.panel-heading')

					<!-- Start tabs content -->
					<div class="panel-body">
						<div class="tab-content">
							<div class="tab-pane fade in active" id="tab1">
								<div class="panel panel-default panel-blog rounded shadow">
									<div class="panel-body">
										<h3 class="blog-title">{{ $script->title }}</h3>
										<ul class="blog-meta">
											<li>{{ trans('front/scripts/view.by') }}: <a href="{{ URL::route('users.view', ['id' => $script->user_id]) }}">{{ $script->user_profile->first()->first_name }}</a></li>
											<li>{{ $script->created_at->diffForHumans() }}</li>
										</ul>
										<div class="blog-img">
											<img alt="{{ $script->title }}" src="/assets/images/scripts/{{ $script->id }}/750x212.jpg" class="img-responsive">
										</div>
										<div style="text-align: justify;">
											{!! $script->description !!}
										</div>

									</div><!-- panel-body -->
								</div><!-- panel-blog -->
							</div>
						</div>
					</div><!-- /.panel-body -->
					<!--/ End tabs content -->
				</div><!-- /.panel -->
				
			</div>

			@include('laravel-authentication-acl::client.scripts.sidebar-right')

		</div><!-- row -->

	</div><!-- /.body-content -->
	<!--/ End body content -->
	
	@include('laravel-authentication-acl::client.layouts.partials.footer')

</section><!-- /#page-content -->
<!--/ END PAGE CONTENT -->
@endsection

@section('scripts')	
	<script>
		$(".rating.allowed .star").click(function() 
		{
			var stars = $(this).attr('star');
			url = "{!! URL::route('scripts.stars.edit', ['id' => $script->id, 'game' => App\Http\Classes\Slug::filter($script->game->title), 'category' => App\Http\Classes\Slug::filter($script->category->title), 'title' => App\Http\Classes\Slug::filter($script->title), '_token' => csrf_token() ]) !!}";
			
			$.ajax({
			  type: "POST",
			  url: url,
			  data: 'stars=' + stars,
			  dataType: 'text',
			  success : function(data) 
			  {
				location.reload();
			  }
			});
		});
	</script>
@stop
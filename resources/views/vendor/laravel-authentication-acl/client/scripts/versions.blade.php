@extends('laravel-authentication-acl::client.layouts.base')

@section('title', $script->title)
@section('description', App\Http\Classes\Word::limitWord(App\Http\Classes\Word::cleanDescription($script->description), 20))
@section('keywords', $script->tags)
@section('og_type', 'product')
@section('twitter_card', 'product')
@section('og_image', url('/') . '/assets/images/scripts/'.$script->id.'/750x212.jpg')

@section('page', 'page-scripts-versions') 
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
							<div class="tab-pane fade in active" id="tab2">
							
								@foreach($script->versions as $version)
								<div class="panel" style="border: 1px solid #ccc;">
									<div class="panel-heading">
										<div class="pull-left">
											<h3 class="panel-title">{{ $version->name }}</h3> 
										</div>
										<div class="pull-right" style="display: inline-table;">
											<span style="line-height: 30px;">{{ trans('front/scripts/view.download') }}: {{ $version->downloads->count() }} {{ trans('front/scripts/view.time') }}</span>
											|
											<span style="line-height: 30px;">{{ trans('front/scripts/view.released') }}: {{ $version->created_at->diffForHumans() }}</span>
										</div>
										<div class="clearfix"></div>
									</div>
									<div class="panel-body" style="word-break: break-word;">
										{!! $version->changes !!}
										@if( 
											($script->price_discount == 0 && $script->price == 0) 
											|| 
											(isset($logged_user) && $script->user_id == $logged_user->id)
											||
											(isset($logged_user) && $logged_user->purchases()->where('script_id', $script->id)->count())
											||
											(isset($logged_user) && $logged_user->hasPermission(['_approver']))
										)
										<div class="pull-right">
											<a href="{!! URL::route('scripts.view.downloads', ['script_id' => $script->id, 'version_id' => $version->id]) !!}" class="btn btn-success">{{ trans('front/scripts/view.button-download') }}</a>
										</div>
										@endif
									</div>
								</div>
								@endforeach
							
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
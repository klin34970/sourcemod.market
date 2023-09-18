@extends('laravel-authentication-acl::client.layouts.base')

@section('title', $script->title)
@section('description', App\Http\Classes\Word::limitWord(App\Http\Classes\Word::cleanDescription($script->description), 20))
@section('keywords', $script->tags)
@section('og_type', 'product')
@section('twitter_card', 'product')
@section('og_image', url('/') . '/assets/images/scripts/'.$script->id.'/750x212.jpg')

@section('page', 'page-script-report') 
@section('content')
<!-- START @PAGE CONTENT -->
<section id="page-content">

	<!-- Start page header -->
	<div class="header-content">
		<h2><i class="fa fa-user"></i> {{ $script->title }}</h2>
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
				
				<div class="panel panel-tab rounded shadow">

					<div class="panel-heading">
						<h3 class="panel-title">{{ trans('front/scripts/view.report') }} <code>{{ $script->title}}</code></h3>
					</div>
					<!-- Start tabs content -->
					<div class="panel-body">
						<div class="tab-content">
							<div class="tab-pane fade in active" id="tab1">
								<div class="panel-body no-padding">
									<div class="panel-body">

										<div class="form-body">
											{!! Form::model($script, [ 'url' => URL::route('report.scripts', ['id' => $script->id, 'game' => App\Http\Classes\Slug::filter($script->game->title), 'category' => App\Http\Classes\Slug::filter($script->category->title), 'title' => App\Http\Classes\Slug::filter($script->title) ]), 'class' => 'form-horizontal mt-10'] )  !!}
											<div class="form-group">
												{!! Form::textarea('text', null, ['class' => 'textarea form-control', 'autocomplete' => 'off']) !!}
											</div>
											<div class="form-footer">
												<div class="pull-right">
												{!! Form::submit(trans('front/scripts/view.form-button-report'), array("class"=>"btn btn-danger")) !!}
												</div>
											</div>
											{!! Form::close() !!}
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
		$('.textarea').wysihtml5({
			"stylesheets": 
			[
				"/assets/global/plugins/bower_components/bootstrap-wysihtml5/lib/css/wysiwyg-color.css", "/assets/global/plugins/bower_components/bootstrap-wysihtml5/lib/css/github.css"
			],
			//"color": true,
			"size": 'small',
			"html": true,
			"format-code": true
		});
	</script>
@endsection
@extends('laravel-authentication-acl::client.layouts.base')

@section('title', trans('front/forum/threads.header-title'))
@section('description', 'Sourcemod Market Community')
@section('keywords', 'community, forum')
@section('og_type', 'website')
@section('twitter_card', 'website')
@section('og_image', url('/') . '/assets/images/logos/banner.png')


@section('page', 'page-community-forums-edit') 
@section('content')
<!-- START @PAGE CONTENT -->
<section id="page-content">

	<div class="header-content">
		<h2><i class="fa fa-table"></i> {{ trans('front/forum/threads.header-title') }}</h2>
		<div class="breadcrumb-wrapper hidden-xs">
			<span class="label">{{ trans('front/forum/threads.header-you-are-here') }}:</span>
			<ol class="breadcrumb">
				<li>
					<i class="fa fa-home"></i>
					<a href="{{ URL::route('community.forum') }}">{{ trans('front/forum/threads.header-title') }}</a>
					<i class="fa fa-angle-right"></i>
				</li>
				<li>
					<a href="{{ URL::route('community.forum') }}">{{ trans('front/forum/threads.header-forums') }}</a>
					<i class="fa fa-angle-right"></i>
				</li>
				<li>
					<a href="{{ URL::route('community.forum.forums', ['id' => $reply->thread->forum->id, 'title' => App\Http\Classes\Slug::filter($reply->thread->forum->title)]) }}">{{ $reply->thread->forum->title }}</a>
					<i class="fa fa-angle-right"></i>
				</li>
				<li class="active">{{ $reply->thread->title }}</li>
			</ol>
		</div><!-- /.breadcrumb-wrapper -->
	</div>

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
				
				<div class="panel rounded shadow">
					<div class="panel-heading">
						<div class="pull-left">
							<h3 class="panel-title">{{ trans('front/forum/threads.edit-reply') }}: {{ $reply->thread->title }}</h3>
						</div>
						<div class="clearfix"></div>
					</div><!-- /.panel-heading -->
					<div class="panel-body no-padding">

						{!! Form::model(null, [ 'url' => URL::route('community.forum.replies.edit', ['id' => $reply->id, 'page' => Request::get('page')]), 'class' => 'form-horizontal'] )  !!}
							<div class="form-body">
								<div class="form-group">
									{!! Form::textarea('text', $reply->text, ['class' => 'textarea form-control', 'autocomplete' => 'off']) !!}
								</div><!-- /.form-group -->
							</div><!-- /.form-body -->
							<div class="form-footer">
								<button type="submit" class="btn btn-success">{{ trans('front/forum/threads.button-save-changes') }}</button>
							</div><!-- /.form-footer -->
						{!! Form::close() !!}

					</div><!-- /.panel-body -->
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
	<script>
		$('.textarea').wysihtml5({
			"stylesheets": 
			[
				"/assets/global/plugins/bower_components/bootstrap-wysihtml5/lib/css/wysiwyg-color.css", "/assets/global/plugins/bower_components/bootstrap-wysihtml5/lib/css/github.css"
			],
			//"color": true,
			"size": 'small',
			"html": true,
			"format-code": true,
		});
		$('.wysihtml5-sandbox').contents().find('body').on("keyup change input",function() 
		{
			var REG_EXP = /(:[\-+\w]*:)/g;
			var source = $('.textarea').data("wysihtml5").editor.getValue();
			
			if(source.match(REG_EXP))
			{
				var preview = emojione.toImage(source);
				if(preview.match(REG_EXP))
				{
					preview = preview.replace(REG_EXP, "");
				}
				$('.textarea').data("wysihtml5").editor.setValue(preview);
				$('.textarea').data("wysihtml5").editor.focus(true);
			}

		});
	</script>
@stop
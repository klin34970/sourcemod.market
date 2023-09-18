@section('styles')
	{!! Html::style('assets/admin/css/pages/messages.css') !!}
@stop

@extends('laravel-authentication-acl::client.layouts.base')

@section('title', $thread->title)
@section('description', App\Http\Classes\Word::limitWord(App\Http\Classes\Word::cleanDescription($thread->text), 20))
@section('keywords', str_replace('-', ', ', App\Http\Classes\Slug::filter($thread->title)))
@section('og_type', 'website')
@section('twitter_card', 'website')
@section('og_image', url('/') . '/assets/images/logos/banner.png')


@section('page', 'page-community-replies') 
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
					<a href="{{ URL::route('community.forum.forums', ['id' => $thread->forum->id, 'title' => App\Http\Classes\Slug::filter($thread->forum->title)]) }}">{{ $thread->forum->title }}</a>
					<i class="fa fa-angle-right"></i>
				</li>
				<li class="active">{{ $thread->title }}</li>
			</ol>
		</div><!-- /.breadcrumb-wrapper -->
	</div>
	
	<div class="body-content animated fadeIn">

		<div class="row">
		
			@if(Request::get('page') < 2)
			<div class="_post col-md-12 message-sideright" data-author-name="{{ $thread->user_profile->first()->first_name }}" data-quote-body="{!! htmlentities(App\Http\Classes\Word::limitWord($thread->text, 100)) !!}">

				<div class="forum-post">
					<div class="forum-post-author bg-theme">
						@if($thread->user->isBanned())
							<div class="ribbon-wrapper">
								<div class="ribbon ribbon-shadow ribbon-danger">{{ trans('front/users/view.banned') }}</div>
							</div>
						@endif
						<ul class="inner-all list-unstyled">
							<li class="text-center">
								<img id="{{ $thread->user->id }}" data-no-retina="" width="104" class="img-box {{ $thread->user->online ? 'img-bordered-success' : 'img-bordered-danger'}}" src="{{ $thread->user_profile->first()->presenter()->avatar('30')}}" alt="{{ $thread->user_profile->first()->first_name }}">
							</li>
							<li class="text-center">
								<a href="{{ URL::route('users.view', ['id' => $thread->user->id]) }}"><h4 class="text-capitalize" style="word-break: break-all;">{{ $thread->user_profile->first()->first_name }}</h4></a>
							</li>
						</ul><!-- /.list-unstyled -->
					</div>
					<div class="forum-post-text">
						<div class="forum-meta">
							<i class="fa fa-calendar-check-o margin-right-5"></i>{{ trans('front/forum/threads.posted') }}: {{ $thread->created_at->diffForHumans() }}
							@if(isset($logged_user) && !$thread->closed)
								<div class="pull-right">
								@if($logged_user->id == $thread->user->id && !$thread->user->isBanned())
									<a class="btn btn-xs btn-theme" href="{{ URL::route('community.forum.threads.edit', ['id' => $thread->id, 'title' => App\Http\Classes\Slug::filter($thread->title)]) }}">
									<i class="fa fa-pencil margin-right-5"></i>
										{{ trans('front/forum/threads.edit') }}
									</a>
								@endif
								<a class="btn btn-xs btn-danger _quote" href="#"><i class="fa fa-reply margin-right-5"></i>{{ trans('front/forum/threads.quote') }}</a>
								</div>
							@endif
						</div>
						<div class="forum-body">
							<div class="post-text">
								{!! $thread->text !!}
							</div>
						</div>
						<div class="forum-meta-footer">

						</div>
					</div>
				</div>					

			</div><!-- /.message-sideright -->	
			@endif
			
			@if($thread->replies()->count())
				@foreach($thread->replies()->paginate((int)config('sourcemod.market.forum_threads_pagination')) as $reply)
					<div id="reply-{{ $reply->id }}" class="_post col-md-12 message-sideright" data-author-name="{{ $reply->user_profile->first()->first_name }}" data-quote-body="{!! htmlentities(App\Http\Classes\Word::limitWord($reply->text, 100)) !!}">

						<div class="forum-post">
							<div class="forum-post-author bg-theme">
								@if($reply->user->isBanned())
									<div class="ribbon-wrapper">
										<div class="ribbon ribbon-shadow ribbon-danger">{{ trans('front/users/view.banned') }}</div>
									</div>
								@endif
								<ul class="inner-all list-unstyled">
									<li class="text-center">
										<img id="{{ $reply->user->id }}" data-no-retina="" width="104" class="img-box {{ $reply->user->online ? 'img-bordered-success' : 'img-bordered-danger'}}" src="{{ $reply->user_profile->first()->presenter()->avatar('30')}}" alt="{{ $reply->user_profile->first()->first_name }}">
									</li>
									<li class="text-center">
										<a href="{{ URL::route('users.view', ['id' => $reply->user->id]) }}"><h4 class="text-capitalize" style="word-break: break-all;">{{ $reply->user_profile->first()->first_name }}</h4></a>
									</li>
								</ul><!-- /.list-unstyled -->
							</div>
							<div class="forum-post-text">
								<div class="forum-meta">
									<i class="fa fa-calendar-check-o margin-right-5"></i>Posted: {{ $reply->created_at->diffForHumans() }}
									@if($reply->created_at != $reply->updated_at)
										<i class="fa fa-calendar-plus-o margin-left-5 margin-right-5"></i>Edited: {{ $reply->updated_at->diffForHumans() }}
									@endif
									@if(isset($logged_user) && !$reply->thread->closed)
										<div class="pull-right">
										@if($logged_user->id == $reply->user->id && !$reply->user->isBanned())
											<a class="btn btn-xs btn-theme" href="{{ URL::route('community.forum.replies.edit', ['id' => $reply->id, 'page' => Request::get('page')]) }}">
											<i class="fa fa-pencil margin-right-5"></i>
												{{ trans('front/forum/threads.edit') }}
											</a>
										@endif
										<a class="btn btn-xs btn-danger _quote" href="#"><i class="fa fa-reply margin-right-5"></i>{{ trans('front/forum/threads.quote') }}</a>
										</div>
									@endif
								</div>
								<div class="forum-body">
									<div class="post-text">
										{!! $reply->text !!}
									</div>
								</div>
							</div>
						</div>					

					</div><!-- /.message-sideright -->
				@endforeach
				
				
				<div class="col-md-12">
					<div class="text-center">
						{{ $thread->replies()->paginate((int)config('sourcemod.market.forum_threads_pagination'))->links() }}
					</div>
				</div>
			@endif
			
			@if($logged_user && !$thread->closed)
				<a name="reply_form"></a>
				<div class="col-md-12">
					<div class="panel rounded shadow">
						<div class="panel-heading">
							<div class="pull-left">
								<h3 class="panel-title">{{ trans('front/forum/threads.reply') }}: {{ $thread->title }}</h3>
							</div>
							<div class="clearfix"></div>
						</div><!-- /.panel-heading -->
						<div class="panel-body no-padding">

							{!! Form::model(null, [ 'url' => URL::route('community.forum.replies.new', ['id' => $thread->id, 'page' => Request::get('page')]), 'class' => 'form-horizontal'] )  !!}
								<div class="form-body">
									<div class="form-group">
										{!! Form::textarea('text', null, ['class' => 'textarea form-control', 'autocomplete' => 'off']) !!}
									</div><!-- /.form-group -->
								</div><!-- /.form-body -->
								<div class="form-footer">
									<button type="submit" class="btn btn-success">{{ trans('front/forum/threads.button-save') }}</button>
								</div><!-- /.form-footer -->
							{!! Form::close() !!}

						</div><!-- /.panel-body -->
					</div>
				</div>
			@endif
		</div><!-- /.message-wrapper -->

	</div>
	
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
@extends('laravel-authentication-acl::client.layouts.base')

@section('title', $issue->title)
@section('description', App\Http\Classes\Word::limitWord(App\Http\Classes\Word::cleanDescription($issue->text), 20))
@section('keywords', str_replace(' ', ', ', $issue->title))
@section('og_type', 'product')
@section('twitter_card', 'product')
@section('og_image', url('/') . '/assets/images/scripts/'.$script->id.'/750x212.jpg')

@section('page', 'page-scripts-issues no-modal-backdrop') 
@section('content')
<!-- START @PAGE CONTENT -->
<section id="page-content">

	<!-- Start page header -->
	<div class="header-content">
		<h2><i class="fa fa-code"></i> {{ $issue->script->title }} <span>{{ $issue->title }}</span></h2>
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

				@if(!$issue->script->activated)
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
								<div class="panel-body no-padding">
								
									<h3 class="text-center">{{ $issue->title }}</h3>
									
									<div class="_post media inner-all no-margin" data-author-name="{{ $issue->user->user_profile->first()->first_name }}" data-quote-body="{!! htmlentities($issue->text) !!}">
										<div class="pull-right">
										@if(isset($logged_user))
											<a href="#" class="_quote"><i class="fa fa-reply margin-right-5"></i></a>
										@endif
										</div>
										
										<div class="pull-left">
											<img alt="{{ $issue->user->user_profile->first()->first_name }}" style="width:50px" src="{{ $issue->user->user_profile->first()->presenter()->avatar('30') }}">
										</div><!-- /.pull-left -->
										<div class="media-body">
											<a href="{{ URL::route('users.view', $issue->user->id) }}" class="h4">
												{{ $issue->user->user_profile->first()->first_name }}
											</a>
											<div class="block">{!! $issue->text !!}</div>
											<em class="text-xs text-muted">{{ trans('front/scripts/view.posted') }} <span class="text-danger">{{ $issue->created_at->diffForHumans() }}</span></em>
										</div><!-- /.media-body -->
									</div>
										
									<div class="line no-margin"></div><!-- /.line -->
									@foreach($issue->discussions()->where('activated', '=', true)->paginate((int)config('sourcemod.market.issues_discussions_pagination')) as $discussion)
                                    <div class="_post media inner-all no-margin" data-author-name="{{ $discussion->user_profile->first()->first_name }}" data-quote-body="{!! htmlentities($discussion->text) !!}">
										<div class="pull-right">
										@if(isset($logged_user))
											<a href="#" class="_quote"><i class="fa fa-reply margin-right-5"></i></a>
											@if(
												($discussion->user->id == $logged_user->id) 
												&&
												(time() - strtotime($discussion->created_at) < (int)config('sourcemod.market.delete_delay'))
											)
												<a href="{!! URL::route('discussions.issues.delete', ['id' => $discussion->id, '_token' => csrf_token()]) !!}"><i class="fa fa-close"></i></a>
											@endif
										@endif
										</div>
										
                                        <div class="pull-left">
                                            <img alt="{{ $discussion->user_profile->first()->first_name }}" style="width:50px" src="{{ $discussion->user_profile->first()->presenter()->avatar('30') }}">
                                        </div><!-- /.pull-left -->
                                        <div class="media-body">
                                            <a href="{{ URL::route('users.view', $discussion->user->id) }}" class="h4">
												{{ $discussion->user_profile->first()->first_name }}
												@if($discussion->user_id == $script->user_id)
													<span class="margin-left-5 badge badge-primary">Auhtor</span>
												@elseif($script->purchasesBy($discussion->user_id, $script->id)->exists())
													<span class="margin-left-5 badge badge-danger">Purchased</span>
												@elseif($discussion->user_id == $issue->user_id)
													<span class="margin-left-5 badge badge-warning">Issuer</span>
												@endif
											</a>
                                            <div class="block">{!! $discussion->text !!}</div>
                                            <em class="text-xs text-muted">{{ trans('front/scripts/view.posted') }} <span class="text-danger">{{ $discussion->created_at->diffForHumans() }}</span></em>
                                        </div><!-- /.media-body -->
                                    </div><!-- /.media -->
                                    <div class="line no-margin"></div><!-- /.line -->
									@endforeach
                                </div>
								
								<div class="text-center">
									{{$issue->discussions()->where('activated', '=', true)->paginate((int)config('sourcemod.market.issues_discussions_pagination'))->links()}}
								</div>
								
								@if(isset($logged_user) && !$issue->closed)
								<a name="reply_form"></a>
								<div class="panel rounded shadow">
									<div class="panel-body no-padding">
										<div class="form-body">
											{!! Form::model($script, [ 'url' => URL::route('discussions.issues.add', ['id' => $issue->id]), 'class' => 'form-horizontal mt-10'] )  !!}
											@if($issue->script->user_id == $logged_user->id)
												<div class="form-group">
													<select name="closed" class="form-control">
														<option></option>
														<option value="1">{{ trans('front/scripts/view.issue-fixed') }}</option>
														<option value="2">{{ trans('front/scripts/view.issue-closed') }}</option>
													</select>
												</div>
											@endif
											<div class="form-group">
												{!! Form::textarea('text', null, ['id'=> 'text', 'class' => 'textarea form-control', 'autocomplete' => 'off']) !!}
											</div>
											<div class="form-footer">
												<div class="pull-right">
												{!! Form::submit(trans('front/scripts/view.form-button-comment'), array("class"=>"btn btn-success")) !!}
												</div>
											</div>
											{!! Form::close() !!}
										</div>
									</div>
								</div>
								@endif
								

								
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
	{!! Html::script('assets/admin/js/pages/blankon.scripts.issues.js') !!}
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
		function showForm(data)
		{
			$('.form-issue').show();
		}
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
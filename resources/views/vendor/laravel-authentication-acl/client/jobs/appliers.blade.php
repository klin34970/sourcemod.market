@extends('laravel-authentication-acl::client.layouts.base')

@section('title', $job->title)
@section('description', App\Http\Classes\Word::limitWord(App\Http\Classes\Word::cleanDescription($job->description), 20))
@section('keywords', $job->tags)
@section('og_type', 'product')
@section('twitter_card', 'product')
@section('og_image', url('/') . '/assets/images/logos/banner.png')

@section('page', 'page-jobs-appliers') 
@section('content')
<!-- START @PAGE CONTENT -->
<section id="page-content">

	<!-- Start page header -->
	<div class="header-content">
		<h2><i class="fa fa-code"></i> {{ $job->title }}</h2>
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

				@if(!$job->activated)
					<div class="alert alert-info">
						{!! trans('front/jobs/view.info-activated') !!}
					</div>
				@endif
				
				<div class="panel panel-tab rounded shadow">
				
					@include('laravel-authentication-acl::client.jobs.panel-heading')
					
					<!-- Start tabs content -->
					<div class="panel-body">
						<div class="tab-content">
							<div class="tab-pane fade in active" id="tab2">
								<div class="panel-body no-padding">
									@foreach($job->appliers()->paginate((int)config('sourcemod.market.appliers_pagination')) as $applier)
                                    <div class="_post media inner-all no-margin" data-author-name="{{ $applier->user_profile->first()->first_name }}" data-quote-body="{!! htmlentities($applier->text) !!}">
										<div class="pull-right">
										@if(isset($logged_user))
											<a href="#" class="_quote"><i class="fa fa-reply margin-right-5"></i></a>
											@if(
												($applier->user->id == $logged_user->id) 
												&&
												time() - strtotime($applier->created_at) < (int)config('sourcemod.market.delete_delay')
											)
											
												<a href="{!! URL::route('appliers.jobs.delete', ['id' => $applier->id, '_token' => csrf_token()]) !!}"><i class="fa fa-close"></i></a>
											
											@endif
										@endif
										</div>
                                        <div class="pull-left">
                                            <img alt="{{ $applier->user_profile->first()->first_name }}" style="width:50px" src="{{ $applier->user_profile->first()->presenter()->avatar('30') }}">
                                        </div><!-- /.pull-left -->
                                        <div class="media-body">
                                            <a href="{{ URL::route('users.view', $applier->user->id) }}" class="h4">
												{{ $applier->user_profile->first()->first_name }} 
											</a>
											<span class="badge badge-success"><i class="fa fa-dollar margin-right-5"></i>{{ $applier->price }}</span>
											@if($applier->choosen)
												<span class="badge badge-info"><i class="fa fa-suitcase margin-right-5"></i>Choosen to do the Job</span>
												@if(isset($logged_user) && $job->user->id == $logged_user->id)
													<a href="{{ URL::route('appliers.jobs.users.done', ['id'=> $applier->id]) }}"><span class="badge badge-danger"><i class="fa fa-check margin-right-5"></i>Job is done</span></a>
												@endif
											@endif
											@if(isset($logged_user) && !$job->appliers()->where('choosen', '=', true)->exists())
												@if($job->user->id == $logged_user->id)
													<a href="{{ URL::route('appliers.jobs.users', ['id'=> $applier->id]) }}"><span class="badge badge-warning"><i class="fa fa-suitcase margin-right-5"></i>Choose him for the job</span></a>
												@endif
											@endif
		
											<div class="block">{!! $applier->text !!}</div>
											
                                            <em class="text-xs text-muted">{{ trans('front/jobs/view.posted') }} <span class="text-danger">{{ $applier->created_at->diffForHumans() }}</span></em>
                                        </div><!-- /.media-body -->
                                    </div><!-- /.media -->
                                    <div class="line no-margin"></div><!-- /.line -->
									@endforeach
                                </div>
								
								<div class="text-center">
									{{$job->appliers()->paginate((int)config('sourcemod.market.appliers_pagination'))->links()}}
								</div>
								
								@if(isset($logged_user) && !$job->appliers()->where('choosen', '=', true)->exists() && !$job->finished)
								<a name="reply_form"></a>
								<div class="panel rounded shadow">
									<div class="panel-body no-padding">
										<div class="form-body">
											{!! Form::model($job, [ 'url' => URL::route('jobs.appliers.add', ['id' => $job->id, 'game' => App\Http\Classes\Slug::filter($job->game->title), 'title' => App\Http\Classes\Slug::filter($job->title) ]), 'class' => 'form-horizontal mt-10'] )  !!}
											<div class="form-group">
												<div class="col-sm-12">
												<div class="input-group mb-15">
													<span class="input-group-addon bg-success">$</span>
													{!! Form::number('price', $job->price, ['class' => 'form-control', 'autocomplete' => 'off', 'min' => '0', 'max' => '100', 'step' => '0.50']) !!}
													</div>
												</div>
											</div>
											<div class="form-group">
												{!! Form::textarea('text', null, ['autofocus' => true, 'class' => '_reply_form textarea form-control', 'autocomplete' => 'off']) !!}
											</div>
											<div class="form-footer">
												<div class="pull-right">
												{!! Form::submit(trans('front/jobs/view.form-button-comment'), array("class"=>"btn btn-success")) !!}
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
			
			@include('laravel-authentication-acl::client.jobs.sidebar-right')

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
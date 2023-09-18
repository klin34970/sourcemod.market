@section('styles')
	<style>
		.ct-series-a .ct-bar, 
		.ct-series-a .ct-line, 
		.ct-series-a .ct-point, 
		.ct-series-a .ct-slice-donut
		{
			stroke:#8CC152!important;
		}
		.ct-series-b .ct-bar, 
		.ct-series-b .ct-line, 
		.ct-series-b .ct-point, 
		.ct-series-b .ct-slice-donut
		{
			stroke:#63D3E9!important;
		}
		.ct-series-c .ct-bar, 
		.ct-series-c .ct-line, 
		.ct-series-c .ct-point, 
		.ct-series-c .ct-slice-donut
		{
			stroke:#E9573F!important;
		}
	</style>
@endsection
@extends('laravel-authentication-acl::client.layouts.base')

@section('title', $script->title)
@section('description', App\Http\Classes\Word::limitWord(App\Http\Classes\Word::cleanDescription($script->description), 20))
@section('keywords', $script->tags)
@section('og_type', 'product')
@section('twitter_card', 'product')
@section('og_image', url('/') . '/assets/images/scripts/'.$script->id.'/750x212.jpg')

@section('page', 'page-scripts-issues no-modal-backdrop') 
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
									
									
										<div class="row">
											<div class="col-md-12">
												<!-- Start issue chart -->
												<ul class="list-inline heading-issue-chart">
													<li>
														<span class="label label-circle label-success">&nbsp;</span> 
														{{ trans('front/scripts/view.issue-fixed') }}
													</li>
													<li>
														<span class="label label-circle label-info">&nbsp;</span>
														{{ trans('front/scripts/view.issue-improvements') }}
													</li>
													<li>
														<span class="label label-circle label-danger">&nbsp;</span>
														{{ trans('front/scripts/view.issue-bugs') }}
													</li>
												</ul>
												<div class="ct-chart ct-issue-chart mb-20" style="height: 200px;"></div>
												<!--/ End issue chart -->
											</div>
										</div>
										
										@if(isset($logged_user))
											<div class="row form-issue" style="display:none">
												<div class="col-md-12">
													{!! Form::model(null, [ 'url' => URL::route('scripts.new.issues', ['id' => $script->id]), 'style' => 'margin-bottom: 10px', 'class' => 'form-horizontal'] )  !!}
														<div class="form-group">
															{!! Form::text('title', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
														</div>
														
														<div class="form-group">
															{!! Form::textarea('text', null, ['row' => '5','class' => 'textarea form-control', 'autocomplete' => 'off']) !!}
														</div>
														
														<div class="form-group">
															<select name="status" class="form-control">
																<option value="1">{{ trans('front/scripts/view.issue-bugs') }}</option>
																<option value="2">{{ trans('front/scripts/view.issue-improvements') }}</option>
															</select>
														</div>
														
														<button type="submit" class="btn btn-success">Submit</button>
														<input type="hidden" name="script_id" value="{{ $script->id }}">
													{!! Form::close() !!}
												</div>
											</div>
										@endif
										<div class="row" style="margin-left: -40px;margin-right: -40px;">
											<div class="col-md-12">
												<!-- Issue list -->
												<div class="panel panel-default panel-issue-tracker shadow">
													<div class="panel-heading">
														<div class="pull-left">
															<h3 class="panel-title">{{ trans('front/scripts/view.issue-list') }}</h3>
														</div>
														<div class="pull-right">
															@if(isset($logged_user))
															<button class="btn btn-sm btn-success" onclick="showForm(this)"><i class="fa fa-plus"></i> Add new issue</button>
															@endif
														</div>
														<div class="clearfix"></div>
													</div><!-- /.panel-heading -->
													<div class="panel-sub-heading inner-all">
														<div class="row">
															<div class="col-md-12">
																<form class="form-horizontal" method="get" action="">
																	<div class="form-body">
																		<div class="form-group no-margin">
																			<div class="input-group">
																				<input name="search" class="form-control" type="text" value="{{ Request::get('search') }}">
																				<span class="input-group-btn"><button type="submit" class="btn btn-default">{{ trans('front/scripts/view.issue-search') }}</button></span>
																			</div>
																		</div><!-- /.form-group -->
																	</div><!-- /.form-body -->
																</form>
															</div>
														</div>
													</div>
													<div class="panel-body">

														<div class="table-responsive">
															<table class="table table-issue-tracker table-middle">
																<tbody>
																@foreach($issues as $issue)
																<tr>
																	<td>
																		@if($issue->status == 1)
																			<span class="label label-danger rounded">{{ trans('front/scripts/view.issue-bugs') }}</span>
																		@elseif($issue->status == 2)
																			<span class="label label-info rounded">{{ trans('front/scripts/view.issue-improvements') }}</span>
																		@endif
																	</td>
																	<td>
																	@if($issue->closed == 1)
																		<span class="label label-success rounded">{{ trans('front/scripts/view.issue-fixed') }}</span>
																	@elseif($issue->closed == 2)
																		<span class="label label-danger rounded">{{ trans('front/scripts/view.issue-closed') }}</span>
																	@else
																		<span class="label label-warning rounded">{{ trans('front/scripts/view.issue-open') }}</span>	
																	@endif
																	</td>
																	<td>
																		<p class="no-margin" style="word-break: break-all;">
																		<a href="{!! URL::route('scripts.single.issues', ['id' => $script->id, 'game' => App\Http\Classes\Slug::filter($script->game->title), 'category' => App\Http\Classes\Slug::filter($script->category->title), 'title' => App\Http\Classes\Slug::filter($script->title), 'issue_id' => $issue->id ]) !!}">
																			{{ $issue->title }}
																		</a>
																		</p>
																	</td>
																	<td>
																		<div class="flag flag-icon-background flag-icon-it" title="Italy"></div>
																		<a href="{{URL::route('users.view', ['id' => $issue->user->id]) }}">
																		{{ isset($issue->user->user_profile()->first()->first_name) ? $issue->user->user_profile()->first()->first_name : $issue->user->steam_id }}</a>
																	</td>
																	<td>
																		@if($issue->closed == 1)
																			{{ trans('front/scripts/view.issue-fixed') }} : {{ $issue->updated_at->diffForHumans() }}
																		@elseif($issue->closed == 2)
																			{{ trans('front/scripts/view.issue-closed') }} : {{ $issue->updated_at->diffForHumans() }}
																		@else
																			{{ $issue->created_at->diffForHumans() }}
																		@endif
																	</td>
																	<td>
																		<i class="fa fa-comments"></i> {{ count($issue->discussions) }}
																	</td>
																</tr>
																@endforeach
																</tbody>
															</table>
														</div>

													</div><!-- /.panel-body -->
													<div class="panel-footer">
														<div class="pull-right">
														{{ $issues->links() }}
														</div>
														<div class="clearfix"></div>
													</div><!-- /.panel-footer -->
												</div>
												<!--/ End issue list -->
											</div>
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
		BlankonProjectIssuetracker.init('{!!$charts_fixed!!}', '{!!$charts_improvements!!}', '{!!$charts_bugs!!}');
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
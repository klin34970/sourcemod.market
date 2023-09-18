@section('styles')
	{!! Html::style('assets/global/plugins/bower_components/datatables/css/dataTables.bootstrap.css') !!}
	{!! Html::style('assets/global/plugins/bower_components/datatables/css/datatables.responsive.css') !!}
@stop

@extends('laravel-authentication-acl::client.layouts.base')

@section('title', trans('front/forum/index.header-title'))
@section('description', 'Sourcemod Market Community')
@section('keywords', 'community, forum')
@section('og_type', 'website')
@section('twitter_card', 'website')
@section('og_image', url('/') . '/assets/images/logos/banner.png')


@section('page', 'page-community') 
@section('content')
<!-- START @PAGE CONTENT -->
<section id="page-content">

	<div class="header-content">
		<h2><i class="fa fa-table"></i> {{ trans('front/forum/index.header-title') }}</h2>
		<div class="breadcrumb-wrapper hidden-xs">
			<span class="label">{{ trans('front/forum/index.header-you-are-here') }}:</span>
			<ol class="breadcrumb">
				<li>
					<i class="fa fa-home"></i>
					<a href="{{ URL::route('community.forum') }}">{{ trans('front/forum/index.header-title') }}</a>
					<i class="fa fa-angle-right"></i>
				</li>
				<li class="active">{{ trans('front/forum/index.header-forums') }}</li>
			</ol>
		</div><!-- /.breadcrumb-wrapper -->
	</div>

	<!-- Start body content -->
	<div class="body-content animated fadeIn">

		<div class="row">
			<div class="col-md-12">
			
				<div class="panel">
					<div class="panel-heading">
						<div class="pull-left">
							<h3 class="panel-title">Sourcemod Market</h3>
						</div>
						<div class="clearfix"></div>
					</div><!-- /.panel-heading -->
					<div class="panel-body">
						<table id="datatable-dom" class="datatable-dom table table-theme">
							<thead>
							<tr>
								<th data-class="expand" width="50%">{{ trans('front/forum/index.table-head-forum') }}</th>
								<th data-hide="phone, tablet" width="10%" class="text-center">{{ trans('front/forum/index.table-head-discussions') }}</th>
								<th data-hide="phone, tablet" width="10%" class="text-center">{{ trans('front/forum/index.table-head-messages') }}</th>
								<th data-hide="phone, tablet" width="30%">{{ trans('front/forum/index.table-head-latest-topic') }}</th>
							</tr>
							</thead>
							<tbody>
							@foreach($forums as $forum)
								@if($forum->category == '1')
									<tr class="border-primary">
										<td>
											<h4>
												<div class="pull-left margin-right-5">
													<i class="{{ $forum->icon }} margin-right-5 icon-forum"></i>
												</div>
												<a href="{{ URL::route('community.forum.forums', ['id' => $forum->id, 'title' => App\Http\Classes\Slug::filter($forum->title)]) }}">{{ $forum->title }}</a>
												<br>
												<small>{{ $forum->subtitle }}</small>
											</h4>
										</td>
										<td class="td-align">
											<div class="forum_table">
												{{ $forum->threads->count() }}
											</div>
										</td>
										<td class="td-align">
											<div class="forum_table">
												{{ $forum->replies->count() + $forum->threads->count() }}
											</div>
										</td>
										@if($forum->threads->count())
											<td>												
												@if(
												isset($forum->replies()->orderBy('created_at', 'desc')->first()->created_at) &&$forum->replies()->orderBy('created_at', 'desc')->first()->created_at > $forum->threads()->orderBy('created_at', 'desc')->first()->created_at)
													
													<div class="pull-left margin-right-5">
													<img width="60" src="{{ $forum->replies()->orderBy('created_at', 'desc')->first()->user_profile->first()->presenter()->avatar('30') }}" >
												</div>
												
												<h5 style="line-height:0;">
													<a href="{{ URL::route('community.forum.threads', ['id' => $forum->replies()->orderBy('created_at', 'desc')->first()->thread->id, 'title' => App\Http\Classes\Slug::filter($forum->replies()->orderBy('created_at', 'desc')->first()->thread->title), 'page' => $forum->replies()->orderBy('created_at', 'desc')->paginate((int)config('sourcemod.market.forum_threads_pagination'))->lastPage(), '#reply-'.$forum->replies()->orderBy('id', 'desc')->first()->id.'']) }}">
														{{ $forum->replies()->orderBy('created_at', 'desc')->first()->thread->title }}
													</a>
												</h5>
												<small>
													<a href="{{URL::route('users.view', ['id' => $forum->replies()->orderBy('created_at', 'desc')->first()->user->id]) }}">
														{{ $forum->replies()->orderBy('created_at', 'desc')->first()->user_profile->first()->first_name }}
													</a>
													<div>
														{{ $forum->replies()->orderBy('created_at', 'desc')->first()->created_at->diffForHumans() }}
													</div>
												</small>
													
												@else
													
													<div class="pull-left margin-right-5">
														<img width="60" src="{{ $forum->threads()->orderBy('created_at', 'desc')->first()->user_profile->first()->presenter()->avatar('30') }}" >
													</div>
													<h5 style="line-height:0;">
														<a href="{{ URL::route('community.forum.threads', ['id' => $forum->threads()->orderBy('created_at', 'desc')->first()->id, 'title' => App\Http\Classes\Slug::filter($forum->threads()->orderBy('created_at', 'desc')->first()->title)]) }}">
															{{ $forum->threads()->orderBy('created_at', 'desc')->first()->title }}
														</a>
													</h5>
													<small>
														<a href="{{URL::route('users.view', ['id' => $forum->threads()->orderBy('created_at', 'desc')->first()->user->id]) }}">
															{{ $forum->threads()->orderBy('created_at', 'desc')->first()->user_profile->first()->first_name }}
														</a>
														<div>
															{{ $forum->threads()->orderBy('created_at', 'desc')->first()->created_at->diffForHumans() }}
														</div>
													</small>
												@endif
												
											</td>
										@else
											<td></td>
										@endif
									</tr>
								@endif
							@endforeach
							</tbody>
						</table>
						
					</div><!-- /.panel-body -->
				</div>				
				
				<div class="panel">
					<div class="panel-heading">
						<div class="pull-left">
							<h3 class="panel-title">{{ trans('front/forum/index.table-head-off-topic') }}</h3>
						</div>
						<div class="clearfix"></div>
					</div><!-- /.panel-heading -->
					<div class="panel-body">
						<table id="datatable-dom-2" class="datatable-dom table table-theme">
							<thead>
							<tr>
								<th data-class="expand" width="50%">{{ trans('front/forum/index.table-head-forum') }}</th>
								<th data-hide="phone, tablet" width="10%" class="text-center">{{ trans('front/forum/index.table-head-discussions') }}</th>
								<th data-hide="phone, tablet" width="10%" class="text-center">{{ trans('front/forum/index.table-head-messages') }}</th>
								<th data-hide="phone, tablet" width="30%">{{ trans('front/forum/index.table-head-latest-topic') }}</th>
							</tr>
							</thead>
							<tbody>
							@foreach($forums as $forum)
								@if($forum->category == '2')
									<tr class="border-warning">
										<td>
											<h4>
												<div class="pull-left margin-right-5">
													<i class="{{ $forum->icon }} margin-right-5 icon-forum"></i>
												</div>
												<a href="{{ URL::route('community.forum.forums', ['id' => $forum->id, 'title' => App\Http\Classes\Slug::filter($forum->title)]) }}">{{ $forum->title }}</a>
												<br>
												<small>{{ $forum->subtitle }}</small>
											</h4>
										</td>
										<td class="td-align">
											<div class="forum_table">
												{{ $forum->threads->count() }}
											</div>
										</td>
										<td class="td-align">
											<div class="forum_table">
												{{ $forum->replies->count() + $forum->threads->count() }}
											</div>
										</td>
										@if($forum->threads->count())
											<td>												
												@if(
												isset($forum->replies()->orderBy('created_at', 'desc')->first()->created_at) &&$forum->replies()->orderBy('created_at', 'desc')->first()->created_at > $forum->threads()->orderBy('created_at', 'desc')->first()->created_at)
													
													<div class="pull-left margin-right-5">
													<img width="60" src="{{ $forum->replies()->orderBy('created_at', 'desc')->first()->user_profile->first()->presenter()->avatar('30') }}" >
												</div>
												<h5 style="line-height:0;">
													<a href="{{ URL::route('community.forum.threads', ['id' => $forum->replies()->orderBy('created_at', 'desc')->first()->thread->id, 'title' => App\Http\Classes\Slug::filter($forum->replies()->orderBy('created_at', 'desc')->first()->thread->title)]) }}">
														{{ $forum->replies()->orderBy('created_at', 'desc')->first()->thread->title }}
													</a>
												</h5>
												<small>
													<a href="{{URL::route('users.view', ['id' => $forum->replies()->orderBy('created_at', 'desc')->first()->user->id]) }}">
														{{ $forum->replies()->orderBy('created_at', 'desc')->first()->user_profile->first()->first_name }}
													</a>
													<div>
														{{ $forum->replies()->orderBy('created_at', 'desc')->first()->created_at->diffForHumans() }}
													</div>
												</small>
													
												@else
													
													<div class="pull-left margin-right-5">
														<img width="60" src="{{ $forum->threads()->orderBy('created_at', 'desc')->first()->user_profile->first()->presenter()->avatar('30') }}" >
													</div>
													<h5 style="line-height:0;">
														<a href="{{ URL::route('community.forum.threads', ['id' => $forum->threads()->orderBy('created_at', 'desc')->first()->id, 'title' => App\Http\Classes\Slug::filter($forum->threads()->orderBy('created_at', 'desc')->first()->title)]) }}">
															{{ $forum->threads()->orderBy('created_at', 'desc')->first()->title }}
														</a>
													</h5>
													<small>
														<a href="{{URL::route('users.view', ['id' => $forum->threads()->orderBy('created_at', 'desc')->first()->user->id]) }}">
															{{ $forum->threads()->orderBy('created_at', 'desc')->first()->user_profile->first()->first_name }}
														</a>
														<div>
															{{ $forum->threads()->orderBy('created_at', 'desc')->first()->created_at->diffForHumans() }}
														</div>
													</small>
												@endif
												
											</td>
										@else
											<td></td>
										@endif
									</tr>
								@endif
							@endforeach
							</tbody>
						</table>
						
					</div><!-- /.panel-body -->
				</div>				
				
				<div class="panel">
					<div class="panel-heading">
						<div class="pull-left">
							<h3 class="panel-title">{{ trans('front/forum/index.table-head-trash') }}</h3>
						</div>
						<div class="clearfix"></div>
					</div><!-- /.panel-heading -->
					<div class="panel-body">
						<table id="datatable-dom-3" class="datatable-dom table table-theme">
							<thead>
							<tr>
								<th data-class="expand" width="50%">{{ trans('front/forum/index.table-head-forum') }}</th>
								<th data-hide="phone, tablet" width="10%" class="text-center">{{ trans('front/forum/index.table-head-discussions') }}</th>
								<th data-hide="phone, tablet" width="10%" class="text-center">{{ trans('front/forum/index.table-head-messages') }}</th>
								<th data-hide="phone, tablet" width="30%">{{ trans('front/forum/index.table-head-latest-topic') }}</th>
							</tr>
							</thead>
							<tbody>
							@foreach($forums as $forum)
								@if($forum->category == '3')
									<tr class="border-danger">
										<td>
											<h4>
												<div class="pull-left margin-right-5">
													<i class="{{ $forum->icon }} margin-right-5 icon-forum"></i>
												</div>
												<a href="{{ URL::route('community.forum.forums', ['id' => $forum->id, 'title' => App\Http\Classes\Slug::filter($forum->title)]) }}">{{ $forum->title }}</a>
												<br>
												<small>{{ $forum->subtitle }}</small>
											</h4>
										</td>
										<td class="td-align">
											<div class="forum_table">
												{{ $forum->threads->count() }}
											</div>
										</td>
										<td class="td-align">
											<div class="forum_table">
												{{ $forum->replies->count() + $forum->threads->count() }}
											</div>
										</td>
										@if($forum->threads->count())
											<td>												
												@if(
												isset($forum->replies()->orderBy('created_at', 'desc')->first()->created_at) &&$forum->replies()->orderBy('created_at', 'desc')->first()->created_at > $forum->threads()->orderBy('created_at', 'desc')->first()->created_at)
													
													<div class="pull-left margin-right-5">
													<img width="60" src="{{ $forum->replies()->orderBy('created_at', 'desc')->first()->user_profile->first()->presenter()->avatar('30') }}" >
												</div>
												<h5 style="line-height:0;">
													<a href="{{ URL::route('community.forum.threads', ['id' => $forum->replies()->orderBy('created_at', 'desc')->first()->thread->id, 'title' => App\Http\Classes\Slug::filter($forum->replies()->orderBy('created_at', 'desc')->first()->thread->title)]) }}">
														{{ $forum->replies()->orderBy('created_at', 'desc')->first()->thread->title }}
													</a>
												</h5>
												<small>
													<a href="{{URL::route('users.view', ['id' => $forum->replies()->orderBy('created_at', 'desc')->first()->user->id]) }}">
														{{ $forum->replies()->orderBy('created_at', 'desc')->first()->user_profile->first()->first_name }}
													</a>
													<div>
														{{ $forum->replies()->orderBy('created_at', 'desc')->first()->created_at->diffForHumans() }}
													</div>
												</small>
													
												@else
													
													<div class="pull-left margin-right-5">
														<img width="60" src="{{ $forum->threads()->orderBy('created_at', 'desc')->first()->user_profile->first()->presenter()->avatar('30') }}" >
													</div>
													<h5 style="line-height:0;">
														<a href="{{ URL::route('community.forum.threads', ['id' => $forum->threads()->orderBy('created_at', 'desc')->first()->id, 'title' => App\Http\Classes\Slug::filter($forum->threads()->orderBy('created_at', 'desc')->first()->title)]) }}">
															{{ $forum->threads()->orderBy('created_at', 'desc')->first()->title }}
														</a>
													</h5>
													<small>
														<a href="{{URL::route('users.view', ['id' => $forum->threads()->orderBy('created_at', 'desc')->first()->user->id]) }}">
															{{ $forum->threads()->orderBy('created_at', 'desc')->first()->user_profile->first()->first_name }}
														</a>
														<div>
															{{ $forum->threads()->orderBy('created_at', 'desc')->first()->created_at->diffForHumans() }}
														</div>
													</small>
												@endif
												
											</td>
										@else
											<td></td>
										@endif
									</tr>
								@endif
							@endforeach
							</tbody>
						</table>
						
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
	{!! Html::script('assets/global/plugins/bower_components/datatables/js/jquery.dataTables.min.js') !!}
	{!! Html::script('assets/global/plugins/bower_components/datatables/js/dataTables.bootstrap.js') !!}
	{!! Html::script('assets/global/plugins/bower_components/datatables/js/datatables.responsive.js') !!}
	{!! Html::script('assets/admin/js/pages/blankon.forums.js') !!}
    <script>
        $(".delete").click(function(){
            return confirm('{!! trans("front/dashboard/scripts/list.confirm-delete") !!}');
        });
		BlankonTable.init(
							'{!! trans("js/datatable.trans-menu") !!}', 
							'{!! trans("js/datatable.trans-record") !!}', 
							'{!! trans("js/datatable.trans-info") !!}', 
							'{!! trans("js/datatable.trans-info-empty") !!}', 
							'{!! trans("js/datatable.trans-info-filtered") !!}', 
							'{!! trans("js/datatable.trans-search") !!}', 
							'{!! trans("js/datatable.trans-previous") !!}', 
							'{!! trans("js/datatable.trans-next") !!}'
						);
    </script>
@stop
@section('styles')
	{!! Html::style('assets/global/plugins/bower_components/datatables/css/dataTables.bootstrap.css') !!}
	{!! Html::style('assets/global/plugins/bower_components/datatables/css/datatables.responsive.css') !!}
@stop

@extends('laravel-authentication-acl::client.layouts.base')

@section('title', trans('front/forum/forums.header-title'))
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
		<h2><i class="fa fa-table"></i> {{ trans('front/forum/forums.header-title') }}</h2>
		<div class="breadcrumb-wrapper hidden-xs">
			<span class="label">{{ trans('front/forum/forums.header-you-are-here') }}:</span>
			<ol class="breadcrumb">
				<li>
					<i class="fa fa-home"></i>
					<a href="{{ URL::route('community.forum') }}">{{ trans('front/forum/forums.header-title') }}</a>
					<i class="fa fa-angle-right"></i>
				</li>
				<li>
					<a href="{{ URL::route('community.forum') }}">{{ trans('front/forum/forums.header-forums') }}</a>
					<i class="fa fa-angle-right"></i>
				</li>
				<li class="active">{{ $forum->title }}</li>
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
								<a href="{{ URL::route('community.forum.forums', ['id' => $forum->id, 'title' => App\Http\Classes\Slug::filter($forum->title)]) }}">
									<h3 class="panel-title">
										{{ $forum->title }}
									</h3>
								</a>
							</div>
							<div class="pull-right">
								@if(!$forum->closed || (isset($logged_user) && $logged_user->hasPermission(['_superadmin'])))
								<a href="{{ URL::route('community.forum.threads.new', ['id' => $forum->id, 'title' => App\Http\Classes\Slug::filter($forum->title)]) }}" class="btn btn-sm btn-theme">
									<i class="fa fa-pencil margin-right-5"></i>
									{{ trans('front/forum/forums.new-thread') }}
								</a>
								@endif
							</div>
							<div class="clearfix"></div>
						</div><!-- /.panel-heading -->
						<div class="panel-body">
								<table id="datatable-dom" class="table table-theme">
									<thead>
									<tr>
										<th data-class="expand" width="50%">{{ trans('front/forum/forums.table-head-title') }}</th>
										<th data-hide="phone, tablet" width="10%" class="text-center">{{ trans('front/forum/forums.table-head-replies') }}</th>
										<th data-hide="phone, tablet" width="10%" class="text-center">{{ trans('front/forum/forums.table-head-views') }}</th>
										<th data-hide="phone, tablet" width="30%">{{ trans('front/forum/forums.table-head-last-message') }}</th>
									</tr>
									</thead>
									<tbody>
									@if($forum->threads()->orderBy('updated_at', 'desc')->exists())
										@foreach($forum->threads()->orderBy('updated_at', 'desc')->paginate((int)config('sourcemod.market.forum_forums_pagination')) as $thread)
										
											<tr class="border-primary">
												<td>
													<div class="pull-left margin-right-5">
														<img width="70" src="{{ $thread->user_profile->first()->presenter()->avatar('30') }}" >
													</div>
													<h4>
														<a href="{{ URL::route('community.forum.threads', ['id' => $thread->id, 'title' => App\Http\Classes\Slug::filter($thread->title)]) }}">
															{{ $thread->title }}
														</a>
													</h4>
													<small>
														<a href="{{ URL::route('users.view', ['id' => $thread->user->id]) }}">
															{{ $thread->user_profile->first()->first_name }}
														</a>
														<div>
															{{ $thread->created_at->diffForHumans() }}
														</div>
													</small>
												</td>
												<td class="td-align">
													<div class="forum_table">
														{{ $thread->replies->count() }}
													</div>
												</td>
												<td class="td-align">
													<div class="forum_table">
														{{ $thread->view }}
													</div>
												</td>
												<td>
													@if($thread->replies->count())
														<div class="pull-left margin-right-5">
															<img width="60" src="{{ $thread->replies()->orderBy('created_at', 'desc')->first()->user_profile->first()->presenter()->avatar('30') }}" >
														</div>
														<small>
															<a href="{{URL::route('users.view', ['id' => $thread->replies()->orderBy('created_at', 'desc')->first()->user->id]) }}">
																{{ $thread->replies()->orderBy('created_at', 'desc')->first()->user_profile->first()->first_name }}
															</a>
															<div>
																<a href="{{ URL::route('community.forum.threads', ['id' => $thread->replies()->orderBy('created_at', 'desc')->first()->thread->id, 'title' => App\Http\Classes\Slug::filter($thread->replies()->orderBy('created_at', 'desc')->first()->thread->title), 'page' => $thread->replies()->orderBy('created_at', 'desc')->paginate((int)config('sourcemod.market.forum_threads_pagination'))->lastPage(), '#reply-'.$thread->replies()->orderBy('id', 'desc')->first()->id.'']) }}">
																	{{ $thread->replies()->orderBy('created_at', 'desc')->first()->created_at->diffForHumans() }}
																</a>
															</div>
														</small>
													@else
														<div class="pull-left margin-right-5">
															<img width="60" src="{{ $thread->user_profile->first()->presenter()->avatar('30') }}" >
														</div>
														<small>
															<a href="{{URL::route('users.view', ['id' => $thread->user->id]) }}">
																{{ $thread->user_profile->first()->first_name }}
															</a>
															<div>
																{{ $thread->created_at->diffForHumans() }}
															</div>	
													@endif
												</td>
												

											</tr>
											
										@endforeach
									@endif
									</tbody>
								</table>
						</div><!-- /.panel-body -->
						<div class="panel-footer">
							<div class="text-center">
								{{ $forum->threads()->orderBy('id', 'desc')->paginate((int)config('sourcemod.market.forum_forums_pagination'))->links() }}
							</div>
						</div>
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
	{!! Html::script('assets/admin/js/pages/blankon.threads.js') !!}
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
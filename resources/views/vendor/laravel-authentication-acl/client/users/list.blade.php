@extends('laravel-authentication-acl::client.layouts.base')

@section('title', 'Users')
@section('description', 'See users online, offline, banned')
@section('keywords', 'user, online, chat')
@section('og_type', 'website')
@section('twitter_card', 'website')
@section('og_image', url('/') . '/assets/images/logos/banner.png')

@section('page', 'page-users-list') 
@section('content')
<!-- START @PAGE CONTENT -->
<section id="page-content">

	<!-- Start body content -->
	<div class="body-content animated fadeIn">

		<div class="row">

			<div class="panel">
				<div class="panel-heading">
				
					<form class="form-horizontal" method="GET" style="padding-top: 8px!important;">
						<div class="form-group no-margin no-padding has-feedback">
							<div class="col-md-2">
								<div class="input-group">
									<input name="search" class="form-control" type="text" value="{{ Request::has('search') ? Request::get('search') : '' }}">
									<span class="input-group-btn">
										<button type="submit" class="btn btn-theme"><i class="fa fa-search"></i></button>
									</span>
								</div>
							</div>
							<div class="col-md-2">
								<div class="input-group" style="width: 100%;">
								<span class="input-group-addon bg-theme"><i class="fa fa-circle-o"></i></span>
								<select name="status" class="form-control" onchange="this.form.submit()">
									<option value="">All</option>
									<option value="online" {{ Request::get('status') == "online" ? 'selected' : '' }}>Online</option>
									<option value="banned" {{ Request::get('status') == "banned" ? 'selected' : '' }}>Banned</option>
								</select>
								</div>
							</div>
						</div>
					</form>
				
				</div><!-- /.panel-heading -->
				<div class="panel-body"><!-- /.panel-body -->
					
					@foreach($users as $user)
						<div class="col-lg-3 col-md-6 col-sm-6 col-xs-6">
                            <div class="panel rounded shadow">
								@if($user->isBanned())
								<div class="ribbon-wrapper">
									<div class="ribbon ribbon-shadow ribbon-danger">{{ trans('front/users/view.banned') }}</div>
								</div>
								@endif
                                <div id="{{ $user->id }}" class="panel-body {{ $user->online ? 'bg-success' : 'bg-danger'}}">
                                    <div class="row row-merge">
                                        <div class="col-sm-12 col-xs-12">
                                            <div class="media mb-10">
                                                <a class="pull-left media-object" href="{{URL::route('users.view', ['id' => $user->id]) }}">
													@if($user->user_profile->first())
                                                    <img style="width: 50px;" class="img-responsive img-box" src="{{ $user->user_profile->first()->presenter()->avatar('30') }}">
													@endif
									
                                                </a><!-- /.media-object -->
                                                <div class="media-body">
                                                    <h4 style="text-overflow: ellipsis;white-space: nowrap;width: 150px;overflow: hidden;" class="media-heading">
													<a href="{{URL::route('users.view', ['id' => $user->id]) }}">
														<span style="height:24px;display: block;">{{ isset($user->user_profile->first()->first_name) ? App\Http\Classes\Word::limitWord($user->user_profile->first()->first_name, 2) : $user->steam_id }}</span>
													</a>
													</h4>
                                                    <p class="text-muted h6 mt-5">
														<i class="fa fa-map-marker"></i> 
														{{ (isset($user->user_profile->first()->country) && $user->user_profile->first()->country != "") ? $user->user_profile->first()->country : 'Moon' }}
													</p>
													<p class="text-muted h6 mt-5">
														<i class="fa fa-pencil"></i> 
														{{ $user->last_activity->diffForHumans() }}
													</p>
                                                </div><!-- /.media-body -->
                                            </div><!-- /.media -->
                                        </div><!-- /.col-sm-9 -->
                                    </div><!-- /.row-merge -->
                                </div><!-- /.panel-body -->
                            </div><!-- /.panel -->
                        </div>
					@endforeach
				
				</div><!-- /.panel -->
				<div class="panel-footer">
					<div class="text-center">
					{{ $users->links() }}
					</div>
				</div>
			</div>		

		</div><!-- row -->

	</div><!-- /.body-content -->
	<!--/ End body content -->
	
	@include('laravel-authentication-acl::client.layouts.partials.footer')

</section><!-- /#page-content -->
<!--/ END PAGE CONTENT -->
@endsection
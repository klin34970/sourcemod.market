<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
	<div class="blog-sidebar">
		<div class="panel panel-theme rounded shadow">
			<div class="panel-heading">
				@if($user->isBanned())
				<div class="ribbon-wrapper">
					<div class="ribbon ribbon-shadow ribbon-danger">{{ trans('front/users/view.banned') }}</div>
				</div>
				@endif
				<h3 class="panel-title"><i class="fa fa-user"></i> {{ trans('front/users/view.panel-title-author') }}</h3>
			</div>
			<div class="panel-body">
				<div class="inner-all">
					<ul class="list-unstyled">
						<li class="text-center">
							@if($user->user_profile->first())
							<img id="{{ $user->id }}" style="width: 100px;" class="img-box {{ $user->online ? 'img-bordered-success' : 'img-bordered-danger'}}" src="{{ $user->user_profile->first()->presenter()->avatar('30') }}">
							@endif
						</li>
						<li class="text-center" style="word-break: break-all;">
							@if($user->user_profile->first())
							<h4 class="text-capitalize">{{ $user->user_profile->first()->first_name }}</h4>
							@endif
						</li>
						@if(isset($reputations))
						<li class="text-center">
							<div class="rating rating-2x rating-primary text-center" style="margin: 20px 20px;">
								<span style="vertical-align: top;font-size:10px;">({{ strrev($reputations->count()) }})</span>
								<span class="star {{ round($reputations->avg('stars')) == 5 ? 'active' : '' }}" star="5"></span>
								<span class="star {{ round($reputations->avg('stars')) == 4 ? 'active' : '' }}" star="4"></span>
								<span class="star {{ round($reputations->avg('stars')) == 3 ? 'active' : '' }}" star="3"></span>
								<span class="star {{ round($reputations->avg('stars')) == 2 ? 'active' : '' }}" star="2"></span>
								<span class="star {{ round($reputations->avg('stars')) == 1 ? 'active' : '' }}" star="1"></span>
							</div>
						</li>
						@endif
						<li>
							<a href="https://steamcommunity.com/profiles/{{ $user->steam_id }}" class="btn btn-theme btn-block">
								<i class="margin-right-5 fa fa-user"></i>
								Steam Profile
							</a>
						</li>
						<li>
							<a href="steam://friends/add/{{ $user->steam_id }}" class="btn btn-theme btn-block">
								<i class="margin-right-5 fa fa-plus"></i>
								Add on Steam
							</a>
						</li>
						@if(isset($logged_user))
							@if($user->id == $logged_user->id)
							<li><br></li>
							<li>
								<a href="{!! URL::route('dashboard.users.self') !!}" class="btn btn-theme btn-block">
									<i class="margin-right-5 fa fa-pencil"></i>
									Edit profile
								</a>
							</li>
							@else
							<li><br></li>
							<li>
								<a href="{!! URL::route('contact.users', ['id' => $user->id]) !!}" class="btn btn-info btn-block">
									<i class="margin-right-5 fa fa-envelope"></i>
									Contact this user
								</a>
							</li>
							<li>
								<a href="{!! URL::route('report.users', ['id' => $user->id]) !!}" class="btn btn-danger btn-block">
									<i class="margin-right-5 fa fa-meh-o"></i>
									Report this user
								</a>
							</li>
							@endif
							
							@if($logged_user->hasPermission(['_users-management']))
							<li><br></li>
							<li>
								<a href="{!! URL::route('users.bans', ['id' => $user->id]) !!}" class="btn btn-danger btn-block">
									<i class="margin-right-5 fa fa-meh-o"></i>
									Ban this user
								</a>
							</li>
							@endif
						@endif
					</ul>
				</div>
			</div>
		</div>
	</div><!-- blog-sidebar -->
</div>
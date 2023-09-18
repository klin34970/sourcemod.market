<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
	<div class="blog-sidebar">
		<div class="panel panel-theme rounded shadow">
		<div class="panel-heading">
				@if($job->user->isBanned())
				<div class="ribbon-wrapper">
					<div class="ribbon ribbon-shadow ribbon-danger">{{ trans('front/jobs/view.banned') }}</div>
				</div>
				@endif
				<h3 class="panel-title"><i class="fa fa-user"></i> {{ trans('front/jobs/view.panel-title-author') }}</h3>
			</div>
			<div class="panel-body">
				<div class="inner-all">
					<ul class="list-unstyled">
						<li class="text-center">
							<img alt="{{ $job->user_profile->first()->first_name }}" id="{{ $job->user->id }}" style="width: 100px;" class="img-circle {{ $job->user->online ? 'img-bordered-success' : 'img-bordered-danger'}}" src="{{ $job->user_profile->first()->presenter()->avatar('30') }}">
						</li>
						<li class="text-center" style="word-break: break-all;">
							<h4 class="text-capitalize"><a href="{{ URL::route('users.view', $job->user_id) }}">{{ $job->user_profile->first()->first_name }}</a></h4>
						</li>
						<li>
							<a href="https://steamcommunity.com/profiles/{{ $job->user->steam_id }}" class="btn btn-theme btn-block">
								<i class="margin-right-5 fa fa-user"></i>
								Steam Profile
							</a>
						</li>
						<li>
							<a href="steam://friends/add/{{ $job->user->steam_id }}" class="btn btn-theme btn-block">
								<i class="margin-right-5 fa fa-plus"></i>
								Add on Steam
							</a>
						</li>
						@if(isset($logged_user))
							@if($job->user_id == $logged_user->id)
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
								<a href="{!! URL::route('contact.users', ['id' => $job->user->id]) !!}" class="btn btn-info btn-block">
									<i class="margin-right-5 fa fa-envelope"></i>
									Contact this user
								</a>
							</li>
							<li>
								<a href="{!! URL::route('report.users', ['id' => $job->user_id]) !!}" class="btn btn-danger btn-block">
									<i class="margin-right-5 fa fa-meh-o"></i>
									Report this user
								</a>
							</li>
							@endif
						@endif
					</ul>
				</div>
			</div>
		</div>
			
		<div class="panel panel-theme shadow">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-gamepad"></i> {{ trans('front/jobs/view.panel-title-games') }}</h3>
			</div>
			<div class="panel-body no-padding">
				<div class="list-group no-margin">
					<a href="{{ URL::route('games.scripts.list', ['id' => $job->game->id, 'title' => App\Http\Classes\Slug::filter($job->game->title)]) }}" class="list-group-item">{!! $job->game->title !!}</a>
				</div>
			</div>
		</div>

		<div class="panel panel-theme shadow">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-tags"></i> {{ trans('front/jobs/view.panel-title-tags') }}</h3>
			</div>
			<div class="panel-body">
				<ul class="list-inline blog-tags">
				@foreach(explode(',', $job->tags) as $tag)
					<li>
						<a href="{{ URL::route('search', ['keywords' => $tag]) }}"><i class="fa fa-tags"></i> {{ $tag }} </a>
					</li>
				@endforeach
				</ul>
			</div>
		</div>

	</div><!-- blog-sidebar -->
</div>
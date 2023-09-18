<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
	<div class="blog-sidebar">
		<div class="panel panel-theme rounded shadow">
		<div class="panel-heading">
				@if($script->user->isBanned())
				<div class="ribbon-wrapper">
					<div class="ribbon ribbon-shadow ribbon-danger">{{ trans('front/scripts/view.banned') }}</div>
				</div>
				@endif
				<h3 class="panel-title"><i class="fa fa-user"></i> {{ trans('front/scripts/view.panel-title-author') }}</h3>
			</div>
			<div class="panel-body">
				<div class="inner-all">
					<ul class="list-unstyled">
						<li class="text-center">
							@if($script->user->user_profile->first())
							<img alt="{{ $script->user_profile->first()->first_name }}" id="{{ $script->user->id }}" style="width: 100px;" class="img-box {{ $script->user->online ? 'img-bordered-success' : 'img-bordered-danger'}}" src="{{ $script->user_profile->first()->presenter()->avatar('30') }}">
							@endif
						</li>
						<li class="text-center" style="word-break: break-all;">
							<h4 class="text-capitalize"><a href="{{ URL::route('users.view', $script->user_id) }}">{{ isset($script->user_profile->first()->first_name) ? $script->user_profile->first()->first_name : '' }}</a></h4>
						</li>
						@if($script->getReputations($script->user_id)->count())
						<li class="text-center">
							<div class="rating rating-2x rating-primary text-center" style="margin: 20px 20px;">
								<span style="vertical-align: top;font-size:10px;">({{ strrev($script->getReputations($script->user_id)->count()) }})</span>
								<span class="star {{ round($script->getReputations($script->user_id)->avg('stars')) == 5 ? 'active' : '' }}" star="5"></span>
								<span class="star {{ round($script->getReputations($script->user_id)->avg('stars')) == 4 ? 'active' : '' }}" star="4"></span>
								<span class="star {{ round($script->getReputations($script->user_id)->avg('stars')) == 3 ? 'active' : '' }}" star="3"></span>
								<span class="star {{ round($script->getReputations($script->user_id)->avg('stars')) == 2 ? 'active' : '' }}" star="2"></span>
								<span class="star {{ round($script->getReputations($script->user_id)->avg('stars')) == 1 ? 'active' : '' }}" star="1"></span>
							</div>
						</li>
						@endif
						<li>
							<a href="https://steamcommunity.com/profiles/{{ $script->user->steam_id }}" class="btn btn-theme btn-block">
								<i class="margin-right-5 fa fa-user"></i>
								Steam Profile
							</a>
						</li>
						<li>
							<a href="steam://friends/add/{{ $script->user->steam_id }}" class="btn btn-theme btn-block">
								<i class="margin-right-5 fa fa-plus"></i>
								Add on Steam
							</a>
						</li>
						@if(isset($logged_user))
							@if($script->user_id == $logged_user->id)
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
								<a href="{!! URL::route('contact.users', ['id' => $script->user->id]) !!}" class="btn btn-info btn-block">
									<i class="margin-right-5 fa fa-envelope"></i>
									Contact this user
								</a>
							</li>
							<li>
								<a href="{!! URL::route('report.users', ['id' => $script->user_id]) !!}" class="btn btn-danger btn-block">
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
		@if($script->type & 2)
			@if(!$script->dlcs($script->id)->isEmpty())
			<div class="panel panel-theme shadow">
				<div class="panel-heading">
					<h3 class="panel-title"><i class="fa fa-warning"></i> {{ trans('front/scripts/view.panel-title-dlcs-available') }}</h3>
				</div>
				<div class="panel-body no-padding">
					<ul class="list-group no-margin">
					@foreach($script->dlcs($script->id) as $dlc)
					
						<li class="list-group-item">
						<a href="{{ URL::route('scripts.view', ['id' => $dlc->id, 'game' => App\Http\Classes\Slug::filter($dlc->game->title), 'category' => App\Http\Classes\Slug::filter($dlc->category->title), 'title' => App\Http\Classes\Slug::filter($dlc->title) ]) }}" class="list-group-item">
						<img class="img-responsive" src="/assets/images/scripts/{{ $dlc->id }}/340x96.jpg" alt="{{ $dlc->title }}">
						<h4 class="text-center">{{ $dlc->title }}</h4>
						</a>
						</li>
					
					@endforeach
					</ul>
				</div>
			</div>
			@endif
		@endif
		
		@if($script->dlc_id)
		<div class="panel panel-theme shadow">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-warning"></i> {{ trans('front/scripts/view.panel-title-dlc') }}</h3>
			</div>
			<div class="panel-body no-padding">
				<div class="list-group no-margin">
					<a href="{{ URL::route('scripts.view', ['id' => $script->dlc($script->dlc_id)->id, 'game' => App\Http\Classes\Slug::filter($script->dlc($script->dlc_id)->game->title), 'category' => App\Http\Classes\Slug::filter($script->dlc($script->dlc_id)->category->title), 'title' => App\Http\Classes\Slug::filter($script->dlc($script->dlc_id)->title) ]) }}" class="list-group-item">
					<img class="img-responsive" src="/assets/images/scripts/{{ $script->dlc($script->dlc_id)->id }}/340x96.jpg" alt="{{ $script->dlc($script->dlc_id)->title }}">
					<h4 class="text-center">{{ $script->dlc($script->dlc_id)->title }}</h4>
					</a>
				</div>
			</div>
		</div>
		@endif
		
		<div class="mini-stat-type-3 shadow border-theme">
			<div class="ribbon-wrapper">
			</div>
			<span class="text-uppercase text-block text-center">{{ trans('front/scripts/view.panel-title-downloads') }}</span>
			<h3 class="text-strong text-center"><span class="counter">{{ $script->versions_downloads->count() }}</span></h3>
		</div>
		
		@if($script->price > 0 || $script->price_discount > 0)
		<div class="mini-stat-type-3 shadow border-theme">
			<div class="ribbon-wrapper">
			</div>
			<span class="text-uppercase text-block text-center">{{ trans('front/scripts/view.panel-title-purchases') }}</span>
			<h3 class="text-strong text-center"><span class="counter">{{ $script->purchases()->count() }}</span></h3>
		</div>
		@endif
			
		<div class="panel panel-theme shadow">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-gamepad"></i> {{ trans('front/scripts/view.panel-title-games') }}</h3>
			</div>
			<div class="panel-body no-padding">
				<div class="list-group no-margin">
					<a href="{{ URL::route('games.scripts.list', ['id' => $script->game->id, 'title' => App\Http\Classes\Slug::filter($script->game->title)]) }}" class="list-group-item">{!! $script->game->title !!}</a>
				</div>
			</div>
		</div>
		
		<div class="panel panel-theme shadow">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-folder"></i> {{ trans('front/scripts/view.panel-title-categories') }}</h3>
			</div>
			<div class="panel-body no-padding">
				<div class="list-group no-margin">
					<a href="" class="list-group-item">{!! $script->category->title !!}</a>
				</div>
			</div>
		</div>

		<div class="panel panel-theme shadow blog-list-slider">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-code-fork"></i> {{ trans('front/scripts/view.panel-title-updates') }}</h3>
			</div>
			<div id="carousel-blog-list" class="carousel slide" data-ride="carousel">
				<div class="carousel-inner">
					<div class="item active">
						<div class="blog-list">
							<div class="media">
								<div class="media-body">
									<h4 class="media-heading">{{ $script->versions->first()->name }}</h4>
									<small class="media-desc">Released: {{ date('l j F Y', strtotime($script->versions->first()->created_at)) }}</small>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="panel panel-theme shadow">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-tags"></i> {{ trans('front/scripts/view.panel-title-tags') }}</h3>
			</div>
			<div class="panel-body">
				<ul class="list-inline blog-tags">
				@foreach(explode(',', $script->tags) as $tag)
					<li>
						<a href="{{ URL::route('search', ['keywords' => $tag]) }}"><i class="fa fa-tags"></i> {{ $tag }} </a>
					</li>
				@endforeach
				</ul>
			</div>
		</div>

	</div><!-- blog-sidebar -->
</div>
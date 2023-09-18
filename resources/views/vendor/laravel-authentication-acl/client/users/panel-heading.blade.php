<!-- Start tabs heading -->
<div class="panel-heading no-padding">
	<ul class="nav nav-tabs">
		<li {{ App\Http\Classes\Menu::getActiveRoute(['users', '*'], 'class=active', '', true) }}>
			<a href="{{ URL::route('users.view', ['id' => $user->id ]) }}">
				<i class="fa fa-file-text"></i>
				<span>{{ trans('front/users/view.tab-item-profile') }}</span>
			</a>
		</li>
		<li {{ App\Http\Classes\Menu::getActiveRoute(['users', '*', 'scripts'], 'class=active', '') }}>
			<a href="{{ URL::route('users.view.scripts', ['id' => $user->id ]) }}">
				<i class="fa fa-code-fork"></i>
				<span>{{ trans('front/users/view.tab-item-scripts') }} ({{ isset($scripts) ? count($scripts) : '0'}})</span>
			</a>
		</li>
		<li {{ App\Http\Classes\Menu::getActiveRoute(['users', '*', 'reputations'], 'class=active', '') }}>
			<a href="{{ URL::route('users.view.reputations', ['id' => $user->id ]) }}">
				<i class="fa fa-star"></i>
				<span>{{ trans('front/users/view.tab-item-reputations') }} ({{ isset($reputations) ? $reputations->count() : '0' }})</span>
			</a>
		</li>
		@if(isset($logged_user))
			@if($logged_user->hasPermission(['_approver']))
			<li {{ App\Http\Classes\Menu::getActiveRoute(['scripts', '*', '*', '*', '*', 'reports'], 'class=active') }}>
				<a href="{!! URL::route('users.view.reports', ['id' => $user->id]) !!}">
					<i class="fa fa-meh-o"></i>
					<span>{{ trans('front/scripts/view.tab-reports') }} ({{ count($user->reports) }})</span>
				</a>
			</li>
			@endif
		@endif
	</ul>
</div><!-- /.panel-heading -->
<!--/ End tabs heading -->
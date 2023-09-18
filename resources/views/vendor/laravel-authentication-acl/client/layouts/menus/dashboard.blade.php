<li class="submenu {!!App\Http\Classes\Menu::getActiveRoute(['dashboard'], 'active')!!}">
	<a href="javascript:void(0);">
		<span class="icon"><i class="margin-right-5 fa fa-dashboard"></i></span>
		<span class="text">{!! trans('front/sidebar/left.menu-dashboard') !!}</span>
		{!!App\Http\Classes\Menu::getActiveRoute(['dashboard'], '<span class="arrow open fa-angle-double-down"></span>', '<span class="arrow fa-angle-double-right"></span>')!!}
	</a>
	<ul style="{!!App\Http\Classes\Menu::getActiveRoute(['dashboard'], 'display:block;', 'display:none;')!!}">
		<li class="submenu {!!App\Http\Classes\Menu::getActiveRoute(['dashboard', 'root'], 'active')!!}">
			<a href="{!! Url::route('dashboard.index') !!}">
				<span class="text">{!! trans('front/sidebar/left.menu-dashboard') !!}</span>
			</a>
		</li>
		<li class="submenu {!!App\Http\Classes\Menu::getActiveRoute(['dashboard', 'notifications'], 'active')!!}">
			<a href="{!! Url::route('dashboard.notifications') !!}">
				<span class="text">{!! trans('front/sidebar/left.menu-notifications') !!}</span>
			</a>
		</li>
		<li class="submenu {!!App\Http\Classes\Menu::getActiveRoute(['dashboard', 'messages'], 'active')!!}">
			<a href="{!! Url::route('dashboard.messages.list') !!}">
				<span class="text">{!! trans('front/sidebar/left.menu-messages') !!}</span>
			</a>
		</li>
		<li class="submenu {!!App\Http\Classes\Menu::getActiveRoute(['dashboard', 'scripts'], 'active')!!}">
			<a href="{!! Url::route('dashboard.scripts') !!}">
				<span class="text">{!! trans('front/sidebar/left.menu-scripts') !!}</span>
			</a>
		</li>
		@if($logged_user->purchases->count())
		<li class="submenu {!!App\Http\Classes\Menu::getActiveRoute(['dashboard', 'purchase', 'scripts'], 'active')!!}">
			<a href="{!! Url::route('dashboard.scripts.purchases') !!}">
				<span class="text">{!! trans('front/sidebar/left.menu-puchases-scripts') !!}</span>
			</a>
		</li>
		@endif
		@if($logged_user->sales->count())
		<li class="submenu {!!App\Http\Classes\Menu::getActiveRoute(['dashboard', 'sales', 'scripts'], 'active')!!}">
			<a href="{!! Url::route('dashboard.scripts.sales') !!}">
				<span class="text">{!! trans('front/sidebar/left.menu-sales-scripts') !!}</span>
			</a>
		</li>
		@endif
		<li class="submenu {!!App\Http\Classes\Menu::getActiveRoute(['dashboard', 'jobs'], 'active')!!}">
			<a href="{!! Url::route('dashboard.jobs') !!}">
				<span class="text">{!! trans('front/sidebar/left.menu-jobs') !!}</span>
			</a>
		</li>
		<li class="submenu {!!App\Http\Classes\Menu::getActiveRoute(['dashboard', 'api'], 'active')!!}">
			<a href="{!! Url::route('dashboard.api.keys') !!}">
				<span class="text">{!! trans('front/sidebar/left.menu-api-keys') !!}</span>
			</a>
		</li>
	</ul>
</li>
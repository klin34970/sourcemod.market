<li class="submenu {!!App\Http\Classes\Menu::getActiveRoute(['admins'], 'active')!!}">
	<a href="javascript:void(0);">
		<span class="icon"><i class="margin-right-5 fa fa-user-secret"></i></span>
		<span class="text">{!! trans('front/sidebar/left.menu-admins') !!}</span>
		{!!App\Http\Classes\Menu::getActiveRoute(['dashboard'], '<span class="arrow open fa-angle-double-down"></span>', '<span class="arrow fa-angle-double-right"></span>')!!}
	</a>
	<ul style="{!!App\Http\Classes\Menu::getActiveRoute(['admins'], 'display:block;', 'display:none;')!!}">
	
		@if($logged_user->hasPermission(['_approver']))
		<li class="submenu {!!App\Http\Classes\Menu::getActiveRoute(['admins', 'scripts'], 'active')!!}">
			<a href="{{ URL::route('admins.scripts', ['activated' => 0]) }}">
				<span class="text">{!! trans('front/sidebar/left.menu-admins-scripts') !!}</span>
			</a>
		</li>
		@endif		
		
		@if($logged_user->hasPermission(['_users-management']))
		<li class="submenu {!!App\Http\Classes\Menu::getActiveRoute(['admins', 'users'], 'active')!!}">
			<a href="{{ URL::route('admins.users') }}">
				<span class="text">{!! trans('front/sidebar/left.menu-admins-users') !!}</span>
			</a>
		</li>
		@endif
	</ul>
</li>
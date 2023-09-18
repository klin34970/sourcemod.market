<li class="sidebar-category hidden-sidebar-minimize">
	<span>{!! trans('admin/sidebar/left.menu-category-administration') !!}</span>
	<span class="pull-right"><i class="fa fa-cog"></i></span>
</li>

<li class="submenu {!!App\Http\Classes\Menu::getActiveRoute(['admin', 'users|groups|permissions'], 'active')!!}">

	<a href="javascript:void(0);">
		<span class="icon"><i class="fa fa-user"></i></span>
		<span class="text">{!! trans('admin/sidebar/left.menu-users') !!}</span>
		{!!App\Http\Classes\Menu::getActiveRoute(['admin', 'users|groups|permissions'], '<span class="arrow open fa-angle-double-down"></span>', '<span class="arrow fa-angle-double-right"></span>')!!}
	</a>
	
	<ul style="{!!App\Http\Classes\Menu::getActiveRoute(['admin', 'users|groups|permissions'], 'display:block;', 'display:none;')!!}">
	
		<li class="submenu {!!App\Http\Classes\Menu::getActiveRoute(['admin', 'users'], 'active')!!}">
			<a href="javascript:void(0);">
				<span class="text">{!! trans('admin/sidebar/left.menu-users') !!}</span>
				{!!App\Http\Classes\Menu::getActiveRoute(['admin', 'users'], '<span class="arrow open fa-angle-double-down"></span>', '<span class="arrow fa-angle-double-right"></span>')!!}
				
			</a>
			<ul style="{!!App\Http\Classes\Menu::getActiveRoute(['admin', 'users', 'list|edit'], 'display:block;', 'display:none;')!!}">
				<li class="submenu {!!App\Http\Classes\Menu::getActiveRoute(['admin', 'users', 'list'], 'active')!!}">
					<a href="{!! Url::route('users.list') !!}">{!! trans('admin/sidebar/left.submenu-users-list') !!}</a>
				</li>
				<li class="submenu {!!App\Http\Classes\Menu::getActiveRoute(['admin', 'users', 'edit'], 'active')!!}">
					<a href="{!! Url::route('users.edit') !!}">{!! trans('admin/sidebar/left.submenu-add-user') !!}</a>
				</li>
			</ul>
		</li>
		
		<li class="submenu {!!App\Http\Classes\Menu::getActiveRoute(['admin', 'groups'], 'active')!!}">
			<a href="javascript:void(0);">
				<span class="text">{!! trans('admin/sidebar/left.menu-groups') !!}</span>
				{!!App\Http\Classes\Menu::getActiveRoute(['admin', 'groups'], '<span class="arrow open fa-angle-double-down"></span>', '<span class="arrow fa-angle-double-right"></span>')!!}
				
			</a>
			<ul style="{!!App\Http\Classes\Menu::getActiveRoute(['admin', 'groups', 'list|edit'], 'display:block;', 'display:none;')!!}">
				<li class="submenu {!!App\Http\Classes\Menu::getActiveRoute(['admin', 'groups', 'list'], 'active')!!}">
					<a href="{!! Url::route('groups.list') !!}">{!! trans('admin/sidebar/left.submenu-groups-list') !!}</a>
				</li>
				<li class="submenu {!!App\Http\Classes\Menu::getActiveRoute(['admin', 'groups', 'edit'], 'active')!!}">
					<a href="{!! Url::route('groups.edit') !!}">{!! trans('admin/sidebar/left.submenu-add-group') !!}</a>
				</li>
			</ul>
		</li>
		
		<li class="submenu {!!App\Http\Classes\Menu::getActiveRoute(['admin', 'permissions'], 'active')!!}">
			<a href="javascript:void(0);">
				<span class="text">{!! trans('admin/sidebar/left.menu-permissions') !!}</span>
				{!!App\Http\Classes\Menu::getActiveRoute(['admin', 'permissions'], '<span class="arrow open fa-angle-double-down"></span>', '<span class="arrow fa-angle-double-right"></span>')!!}
			</a>
			<ul style="{!!App\Http\Classes\Menu::getActiveRoute(['admin', 'permissions', 'list|edit'], 'display:block;', 'display:none;')!!}">
				<li class="submenu {!!App\Http\Classes\Menu::getActiveRoute(['admin', 'permissions', 'list'], 'active')!!}">
					<a href="{!! Url::route('permission.list') !!}">{!! trans('admin/sidebar/left.submenu-permissions-list') !!}</a>
				</li>
				<li class="submenu {!!App\Http\Classes\Menu::getActiveRoute(['admin', 'permissions', 'edit'], 'active')!!}">
					<a href="{!! Url::route('permission.edit') !!}">{!! trans('admin/sidebar/left.submenu-add-permission') !!}</a>
				</li>
			</ul>
		</li>
		
	</ul>
</li>
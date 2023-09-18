            <aside id="sidebar-left" class="sidebar-circle">

                <!-- Start left navigation - profile shortcut -->
                <div class="sidebar-content">
                    <div class="media">
                        <a class="pull-left has-notif avatar" href="{!! URL::route('users.selfprofile.edit') !!}">
							@if(isset($logged_user) && $logged_user->user_profile()->count())
								<img src="{!! $logged_user->user_profile()->first()->presenter()->avatar('50') !!}" width="50" class="img-circle">
							@else
								<img src="{!! URL::asset('lol') !!}" width="50" class="img-circle">
							@endif
                            <i class="online"></i>
                        </a>
                        <div class="media-body">
                            <h4 class="media-heading">
							{{ trans('admin/sidebar/left.hello') }}, 
								<span>
									{!! isset($logged_user) ? $logged_user->user_profile()->first()->first_name  : 'First name' !!}
								</span>
							</h4>
                        </div>
                    </div>
                </div><!-- /.sidebar-content -->
                <!--/ End left navigation -  profile shortcut -->

                <!-- Start left navigation - menu -->
                <ul class="sidebar-menu">
					<li class="submenu {!!App\Http\Classes\Menu::getActiveRoute(['admin', 'dashboard'], 'active')!!}">
						<a href="{!! Url::route('dashboard.default') !!}">
							<span class="icon"><i class="fa fa-dashboard"></i></span>
							<span class="text">{!! trans('admin/sidebar/left.menu-dashboard') !!}</span>
							{!!App\Http\Classes\Menu::getActiveRoute(['admin', 'dashboard'], '<span class="selected"></span>')!!}
						</a>
					</li>
					@if($logged_user->hasPermission(['_superadmin']))
						@include('laravel-authentication-acl::admin.layouts.menus.users')
					@endif
                </ul><!-- /.sidebar-menu -->
                <!--/ End left navigation - menu -->

                <!-- Start left navigation - footer -->
                <div class="sidebar-footer hidden-xs hidden-sm hidden-md">
                    <a id="fullscreen" class="pull-left" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" data-title="{{ trans('admin/sidebar/left.fullscreen-tooltip') }}"><i class="fa fa-desktop"></i></a>
                    <a id="logout" data-url="{!! URL::route('user.logout') !!}" class="pull-left" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" data-title="{{ trans('admin/sidebar/left.logout-tooltip') }}"><i class="fa fa-power-off"></i></a>
                </div><!-- /.sidebar-footer -->
                <!--/ End left navigation - footer -->

            </aside><!-- /#sidebar-left -->
            <!--/ END SIDEBAR LEFT -->
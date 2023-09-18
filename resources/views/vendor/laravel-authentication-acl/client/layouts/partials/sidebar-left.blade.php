            <aside id="sidebar-left" class="sidebar-box">

				@if(isset($logged_user) && $logged_user->user_profile()->count())
                <!-- Start left navigation - profile shortcut -->
                <div class="sidebar-content">
                    <div class="media">
                        <a class="pull-left has-notif avatar" href="{!! URL::route('dashboard.users.self') !!}">
							<img src="{!! $logged_user->user_profile()->first()->presenter()->avatar('50') !!}" width="50" class="img-circle">
                            <i class="online"></i>
                        </a>
                        <div class="media-body">
                            <h4 class="media-heading" style="word-break: break-word;">
							{{ trans('front/sidebar/left.hello') }}, 
								<span>
									{!! isset($logged_user) ? $logged_user->user_profile()->first()->first_name  : 'First name' !!}
								</span>
							</h4>
                        </div>
                    </div>
                </div><!-- /.sidebar-content -->
                <!--/ End left navigation -  profile shortcut -->
				@endif

                <!-- Start left navigation - menu -->
                <ul class="sidebar-menu">
					<li class="submenu {!!App\Http\Classes\Menu::getActiveRoute(['root'], 'active')!!}">
						<a href="{!! Url::route('home.index') !!}">
							<span class="icon"><i class="margin-right-5 fa fa-home"></i></span>
							<span class="text">{!! trans('front/sidebar/left.menu-home') !!}</span>
							{!!App\Http\Classes\Menu::getActiveRoute(['root'], '<span class="selected"></span>')!!}
						</a>
					</li>
					<li class="submenu {!!App\Http\Classes\Menu::getActiveRoute(['scripts'], 'active')!!}">
						<a href="{!! Url::route('scripts.list') !!}">
							<span class="icon"><i class="margin-right-5 fa fa-code-fork"></i></span>
							<span class="text">{!! trans('front/sidebar/left.menu-scripts') !!}</span>
							{!!App\Http\Classes\Menu::getActiveRoute(['scripts'], '<span class="selected"></span>')!!}
						</a>
					</li>
					<li class="submenu {!!App\Http\Classes\Menu::getActiveRoute(['jobs'], 'active')!!}">
						<a href="{!! Url::route('jobs.list') !!}">
							<span class="icon"><i class="margin-right-5 fa fa-suitcase"></i></span>
							<span class="text">{!! trans('front/sidebar/left.menu-jobs') !!}</span>
							{!!App\Http\Classes\Menu::getActiveRoute(['jobs'], '<span class="selected"></span>')!!}
						</a>
					</li>
					<li class="submenu {!!App\Http\Classes\Menu::getActiveRoute(['games'], 'active')!!}">
						<a href="javascript:void(0);">
							<span class="icon"><i class="margin-right-5 fa fa-gamepad"></i></span>
							<span class="text">{!! trans('front/sidebar/left.menu-games') !!}</span>
							{!!App\Http\Classes\Menu::getActiveRoute(['games'], '<span class="selected"></span>')!!}
						</a>
						
						<ul style="{!!App\Http\Classes\Menu::getActiveRoute(['games'], 'display:block;', 'display:none;')!!}">
						@foreach(App\Http\Models\Front\GameModel::orderBy('title', 'asc')->get() as $game)
							<li class="{{ $game->id }} submenu {!! App\Http\Classes\Menu::getActiveRoute(['games', $game->id], 'active') !!}">
								<a href="{{ URL::route('games.scripts.list', ['id' => $game->id, 'title' => App\Http\Classes\Slug::filter($game->title)]) }}">
									<span class="text">{!! $game->title !!}</span>
								</a>
							</li>
						@endforeach
						</ul>
						
					</li>
					
					<li class="submenu {!!App\Http\Classes\Menu::getActiveRoute(['users'], 'active')!!}">
						<a href="{!! Url::route('users.front.list') !!}">
							<span class="icon"><i class="margin-right-5 fa fa-user"></i></span>
							<span class="text">{!! trans('front/sidebar/left.menu-users') !!}</span>
							{!!App\Http\Classes\Menu::getActiveRoute(['users'], '<span class="selected"></span>')!!}
						</a>
					</li>
					<li class="submenu {!!App\Http\Classes\Menu::getActiveRoute(['community'], 'active')!!}">
						<a href="{!! Url::route('community.forum') !!}">
							<span class="icon"><i class="margin-right-5 fa fa-map-signs"></i></span>
							<span class="text">{!! trans('front/sidebar/left.menu-community') !!}</span>
							{!!App\Http\Classes\Menu::getActiveRoute(['community'], '<span class="selected"></span>')!!}
						</a>
					</li>
					<li class="submenu {!!App\Http\Classes\Menu::getActiveRoute(['sourceguard'], 'active')!!}">
						<a href="{!! Url::route('sourceguard.servers.list') !!}">
							<span class="icon"><i class="margin-right-5 fa fa-shield"></i></span>
							<span class="text">{!! trans('front/sidebar/left.menu-sourceguard') !!}</span>
							{!!App\Http\Classes\Menu::getActiveRoute(['sourceguard'], '<span class="selected"></span>')!!}
						</a>
					</li>

					@if($logged_user)
						@include('laravel-authentication-acl::client.layouts.menus.dashboard')
					@endif
					@if(
						$logged_user
						&&
						(
							$logged_user->hasPermission(['_approver'])
						)
					)
						@include('laravel-authentication-acl::client.layouts.menus.admin')
					@endif
					
					<li class="submenu {!!App\Http\Classes\Menu::getActiveRoute(['help|about'], 'active')!!}">
						<a href="javascript:void(0);">
							<span class="icon"><i class="margin-right-5 fa fa-question"></i></span>
							<span class="text">{!! trans('front/sidebar/left.menu-help') !!}</span>
							{!!App\Http\Classes\Menu::getActiveRoute(['help'], '<span class="selected"></span>')!!}
						</a>
						
						<ul style="{!!App\Http\Classes\Menu::getActiveRoute(['help', 'faq'], 'display:block;', 'display:none;')!!}">
							<li class="submenu {!! App\Http\Classes\Menu::getActiveRoute(['help', 'faq'], 'active') !!}">
								<a href="{{ URL::route('help.faq') }}">
									<span class="text">{!! trans('front/sidebar/left.menu-help-faq') !!}</span>
								</a>
							</li>
							<li class="submenu {!! App\Http\Classes\Menu::getActiveRoute(['help', 'contact'], 'active') !!}">
								<a href="{{ URL::route('help.contact') }}">
									<span class="text">{!! trans('front/sidebar/left.menu-help-contact') !!}</span>
								</a>
							</li>
							<li class="submenu {!! App\Http\Classes\Menu::getActiveRoute(['about', 'terms'], 'active') !!}">
								<a href="{{ URL::route('about.terms') }}">
									<span class="text">{!! trans('front/sidebar/left.menu-about-terms') !!}</span>
								</a>
							</li>
							<li class="submenu {!! App\Http\Classes\Menu::getActiveRoute(['about', 'policy'], 'active') !!}">
								<a href="{{ URL::route('about.policy') }}">
									<span class="text">{!! trans('front/sidebar/left.menu-about-policy') !!}</span>
								</a>
							</li>
						</ul>
					</li>
                </ul><!-- /.sidebar-menu -->
                <!--/ End left navigation - menu -->

                <!-- Start left navigation - footer -->
                <div class="sidebar-footer hidden-xs hidden-sm hidden-md">
                    <a id="fullscreen" class="pull-left" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" data-title="{{ trans('front/sidebar/left.fullscreen-tooltip') }}"><i class="fa fa-desktop"></i></a>
                    <a id="logout" data-url="{!! URL::route('user.logout') !!}" class="pull-left" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" data-title="{{ trans('front/sidebar/left.logout-tooltip') }}"><i class="fa fa-power-off"></i></a>
                </div><!-- /.sidebar-footer -->
                <!--/ End left navigation - footer -->

            </aside><!-- /#sidebar-left -->
            <!--/ END SIDEBAR LEFT -->
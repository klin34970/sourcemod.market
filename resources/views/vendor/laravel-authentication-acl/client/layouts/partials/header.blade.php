            <!-- START @HEADER -->
            <header id="header">

                <!-- Start header left -->
                <div class="header-left">
                    <!-- Start offcanvas left: This menu will take position at the top of template header (mobile only). Make sure that only #header have the `position: relative`, or it may cause unwanted behavior -->
                    <div class="navbar-minimize-mobile left">
                        <i class="fa fa-bars"></i>
                    </div>
                    <!--/ End offcanvas left -->

                    <!-- Start navbar header -->
                    <div class="navbar-header">

                        <!-- Start brand -->
                        <a class="navbar-brand" href="{!! URL::route('home.index') !!}">
                            <img class="logo" src="/assets/images/logos/175x50.png" alt="sourcemod market">
                        </a><!-- /.navbar-brand -->
                        <!--/ End brand -->

                    </div><!-- /.navbar-header -->
                    <!--/ End navbar header -->

                    <!-- Start offcanvas right: This menu will take position at the top of template header (mobile only). Make sure that only #header have the `position: relative`, or it may cause unwanted behavior -->
                    <div class="navbar-minimize-mobile right">
                        <i class="fa fa-cog"></i>
                    </div>
                    <!--/ End offcanvas right -->

                    <div class="clearfix"></div>
                </div><!-- /.header-left -->
                <!--/ End header left -->

                <!-- Start header right -->
                <div class="header-right">
				
                    <!-- Start navbar toolbar -->
                    <div class="navbar navbar-toolbar">

                        <!-- Start left navigation -->
                        <ul class="nav navbar-nav navbar-left">
						

                            <!-- Start sidebar shrink -->
                            <li class="navbar-minimize">
                                <a href="javascript:void(0);" title="Minimize sidebar">
                                    <i class="fa fa-bars"></i>
                                </a>
                            </li>
                            <!--/ End sidebar shrink -->
							
							@yield('navbar-left')
							<!-- Start form search -->
                            <li class="navbar-search">
                                <!-- Just view on mobile screen-->
                                <a href="#" class="trigger-search"><i class="fa fa-search"></i></a>
                                <form method="get" action="{{ URL::route('search') }}" class="navbar-form">
                                    <div class="form-group has-feedback">
                                        <input name="keywords" type="text" class="form-control typeahead rounded" placeholder="Search for scripts, people and things" value="{{ Request::get('keywords') }}">
                                        <button type="submit" class="btn btn-theme fa fa-search form-control-feedback rounded"></button>
                                    </div>
                                </form>
                            </li>
                            <!--/ End form search -->

                        </ul><!-- /.nav navbar-nav navbar-left -->
                        <!--/ End left navigation -->

                        <!-- Start right navigation -->
                        <ul class="nav navbar-nav navbar-right"><!-- /.nav navbar-nav navbar-right -->
							@yield('navbar-right')
							
							@if(isset($logged_user))
								<li class="dropdown navbar-notification">

									<a href="#" class="dropdown-toggle" data-toggle="dropdown">
										<i class="fa fa-bell-o"></i>
										@if($logged_user->notifications()->where('view', 0)->count() > 0)
										<span id="notifications_count" class="count label label-danger rounded">
											{{ $logged_user->notifications()->where('view', 0)->count() }}
										</span>
										@endif
									</a>

									<!-- Start dropdown menu -->
									<div class="dropdown-menu animated flipInX">
										<div class="dropdown-header">
											<span class="title">{{ trans('front/header/navbar.notifications') }} <strong></strong></span>
											<span class="option text-right"><a href="{{ URL::route('dashboard.notifications.read.all') }}"><i class="fa fa-eye"></i> {{ trans('front/header/navbar.notifications-read-all') }}</a></span>
										</div>
										<div class="dropdown-body niceScroll" counter="{{ $logged_user->notifications()->limit(5)->get()->count() }}">

											<!-- Start notification list -->
											<div id="notifications" class="media-list small">

												@foreach($logged_user->notifications()->limit(5)->get() as $notification)
												<a href="{{ URL::route('notifications.view', ['id' => $notification->id]) }} " class="media {{ $notification->view == 0 ? 'to-see' : '' }}">
													<div class="media-object pull-left">
														<i class="{{ $notification->icon }}"></i>
													</div>
													<div class="media-body">
														<span class="media-text">
															{{ $notification->text }}
														</span>
														<!-- Start meta icon -->
														<span class="media-meta">{{ $notification->last_time->diffForHumans() }}</span>
														<!--/ End meta icon -->
													</div><!-- /.media-body -->
												</a><!-- /.media -->
												@endforeach

											</div>
											<!--/ End notification list -->

										</div>
										<div class="dropdown-footer">
											<a href="{{ URL::route('dashboard.notifications') }}">{{ trans('front/header/navbar.notifications-view-all') }}</a>
										</div>
									<!--/ End dropdown menu -->

								</li>
								
								@if($logged_user->user_profile()->count())
								<!-- Start profile -->
								<li class="dropdown navbar-profile">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown">
										<span class="meta">
											<span class="avatar">
												<img src="{{ $logged_user->user_profile()->first()->presenter()->avatar('30') }}"  width="30" class="img-box">
											</span>
											<span class="text hidden-xs hidden-sm text-muted">
												{!! isset($logged_user) ? App\Http\Classes\Word::limitWord($logged_user->user_profile()->first()->first_name, 2)  : 'First name' !!}
											</span>
											<span class="caret"></span>
										</span>
									</a>
									<!-- Start dropdown menu -->
									<ul class="dropdown-menu animated flipInX">
										<li class="dropdown-header">{{ trans('front/header/navbar.account') }}</li>
										<li><a href="{!! URL::route('dashboard.users.self') !!}"><i class="fa fa-user"></i>{{ trans('front/header/navbar.profile') }}</a></li>
										<li><a href="{!! URL::route('dashboard.index') !!}"><i class="fa fa-dashboard"></i>{{ trans('front/header/navbar.dashboard') }}</a></li>
										<li class="divider"></li>
										<li><a href="{!! URL::route('dashboard.scripts.new') !!}"><i class="fa fa-plus"></i>{{ trans('front/header/navbar.new-scripts') }}</a></li>
										<li><a href="{!! URL::route('dashboard.scripts') !!}"><i class="fa fa-code-fork"></i>{{ trans('front/header/navbar.scripts') }}</a></li>
										<li class="divider"></li>
										<li><a href="{!! URL::route('dashboard.jobs.new') !!}"><i class="fa fa-plus"></i>{{ trans('front/header/navbar.new-jobs') }}</a></li>
										<li><a href="{!! URL::route('dashboard.jobs') !!}"><i class="fa fa-suitcase"></i>{{ trans('front/header/navbar.jobs') }}</a></li>
										<li class="divider"></li>
										<li><a href="{!! URL::route('user.logout') !!}"><i class="fa fa-sign-out"></i>{{ trans('front/header/navbar.logout') }}</a></li>
									</ul>
									<!--/ End dropdown menu -->
								</li><!-- /.dropdown navbar-profile -->
								<!--/ End profile -->
								@endif
							@else
							<li>
								<a style="padding: 9px 10px;" href="{!! URL::route('steam.login') !!}"><img alt="steam" src="/assets/images/steam/login_steam.png"></a>
							</li>
							@endif

							<!-- Start settings -->
							<li class="navbar-setting pull-right">
								<a href="javascript:void(0);"><i class="fa fa-cog fa-spin"></i></a>
							</li><!-- /.navbar-setting pull-right -->
							<!--/ End settings -->

                        </ul>
                        <!--/ End right navigation -->

                    </div><!-- /.navbar-toolbar -->
                    <!--/ End navbar toolbar -->
                </div><!-- /.header-right -->
                <!--/ End header left -->

            </header> <!-- /#header -->
            <!--/ END HEADER -->